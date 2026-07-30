<?php

namespace App\Services;

use App\Models\DeliveryMan;
use App\Models\DeliveryManWallet;
use App\Models\DeliveryManWalletLedger;
use App\Models\FleetManager;
use App\Models\FleetManagerRiderAssignment;
use App\Models\FleetPaymentCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class FleetManagementService
{
    public function assignRider(
        FleetManager $fleetManager,
        DeliveryMan $rider,
        ?int $assignedBy,
        ?string $reason = null
    ): FleetManagerRiderAssignment {
        return DB::transaction(function () use ($fleetManager, $rider, $assignedBy, $reason) {
            $fleetManager = FleetManager::query()->lockForUpdate()->findOrFail($fleetManager->id);
            $rider = DeliveryMan::withoutGlobalScopes()->lockForUpdate()->findOrFail($rider->id);

            if (! $fleetManager->status || $fleetManager->on_leave) {
                throw ValidationException::withMessages([
                    'fleet_manager_id' => translate('Fleet manager must be active and available.'),
                ]);
            }

            $allowedZoneIds = $fleetManager->zones()->pluck('zones.id');
            if ($rider->zone_id && ! $allowedZoneIds->contains((int) $rider->zone_id)) {
                throw ValidationException::withMessages([
                    'delivery_man_id' => translate('The rider is outside this fleet manager’s assigned areas.'),
                ]);
            }

            $currentRiderCount = DeliveryMan::withoutGlobalScopes()
                ->where('fleet_manager_id', $fleetManager->id)
                ->where('id', '!=', $rider->id)
                ->count();

            if ($currentRiderCount >= $fleetManager->rider_capacity) {
                throw ValidationException::withMessages([
                    'fleet_manager_id' => translate('The fleet manager has reached the rider capacity.'),
                ]);
            }

            FleetManagerRiderAssignment::query()
                ->where('delivery_man_id', $rider->id)
                ->where('is_active', true)
                ->update([
                    'is_active' => false,
                    'ended_at' => now(),
                    'ended_by' => $assignedBy,
                    'end_reason' => $reason ?: translate('Transferred to another fleet manager.'),
                ]);

            $rider->fleet_manager_id = $fleetManager->id;
            $rider->save();

            return FleetManagerRiderAssignment::create([
                'fleet_manager_id' => $fleetManager->id,
                'delivery_man_id' => $rider->id,
                'assigned_by' => $assignedBy,
                'started_at' => now(),
                'is_active' => true,
                'reason' => $reason,
            ]);
        });
    }

    public function unassignRider(DeliveryMan $rider, ?int $assignedBy, ?string $reason = null): void
    {
        DB::transaction(function () use ($rider, $assignedBy, $reason) {
            $rider = DeliveryMan::withoutGlobalScopes()->lockForUpdate()->findOrFail($rider->id);

            FleetManagerRiderAssignment::query()
                ->where('delivery_man_id', $rider->id)
                ->where('is_active', true)
                ->update([
                    'is_active' => false,
                    'ended_at' => now(),
                    'ended_by' => $assignedBy,
                    'end_reason' => $reason,
                ]);

            $rider->fleet_manager_id = null;
            $rider->save();
        });
    }

    public function submitCollection(
        FleetManager $fleetManager,
        DeliveryMan $rider,
        array $data
    ): FleetPaymentCollection {
        return DB::transaction(function () use ($fleetManager, $rider, $data) {
            $rider = DeliveryMan::withoutGlobalScopes()->lockForUpdate()->findOrFail($rider->id);
            if ((int) $rider->fleet_manager_id !== (int) $fleetManager->id) {
                throw ValidationException::withMessages([
                    'delivery_man_id' => translate('This rider is not assigned to the fleet manager.'),
                ]);
            }

            $wallet = DeliveryManWallet::query()
                ->where('delivery_man_id', $rider->id)
                ->lockForUpdate()
                ->first();
            $due = max(0, (float) ($wallet?->collected_cash ?? 0));
            $pendingAmount = (float) FleetPaymentCollection::query()
                ->where('delivery_man_id', $rider->id)
                ->where('status', FleetPaymentCollection::STATUS_PENDING)
                ->lockForUpdate()
                ->sum('amount');
            $availableDue = max(0, $due - $pendingAmount);

            if ($availableDue <= 0 || (float) $data['amount'] > $availableDue) {
                throw ValidationException::withMessages([
                    'amount' => translate('Collection amount exceeds the rider’s unreserved payable balance.'),
                ]);
            }

            return FleetPaymentCollection::create([
                'fleet_manager_id' => $fleetManager->id,
                'delivery_man_id' => $rider->id,
                'amount' => $data['amount'],
                'due_before' => $due,
                'payment_method' => $data['payment_method'],
                'reference' => $data['reference'] ?? null,
                'proof_file' => $data['proof_file'] ?? null,
                'proof_disk' => $data['proof_disk'] ?? 'local',
                'note' => $data['note'] ?? null,
                'status' => FleetPaymentCollection::STATUS_PENDING,
                'submitted_at' => now(),
            ]);
        });
    }

    public function approveCollection(FleetPaymentCollection $collection, int $reviewedBy): FleetPaymentCollection
    {
        return DB::transaction(function () use ($collection, $reviewedBy) {
            $collection = FleetPaymentCollection::query()->lockForUpdate()->findOrFail($collection->id);
            if ($collection->status !== FleetPaymentCollection::STATUS_PENDING) {
                throw ValidationException::withMessages([
                    'status' => translate('Only pending collections can be approved.'),
                ]);
            }

            $wallet = DeliveryManWallet::query()
                ->where('delivery_man_id', $collection->delivery_man_id)
                ->lockForUpdate()
                ->first();

            $currentDue = max(0, (float) ($wallet?->collected_cash ?? 0));
            if (! $wallet || $currentDue < (float) $collection->amount) {
                throw ValidationException::withMessages([
                    'amount' => translate('The rider payable balance changed and is lower than this collection.'),
                ]);
            }

            $wallet->collected_cash = $currentDue - (float) $collection->amount;
            $wallet->save();

            $collection->update([
                'status' => FleetPaymentCollection::STATUS_APPROVED,
                'due_after' => $wallet->collected_cash,
                'reviewed_at' => now(),
                'reviewed_by' => $reviewedBy,
                'rejection_reason' => null,
            ]);

            DeliveryManWalletLedger::create([
                'delivery_man_id' => $collection->delivery_man_id,
                'transaction_type' => DeliveryManWalletLedger::TYPE_FLEET_PAYMENT_RECOVERY,
                'reference' => 'fleet-collection-'.$collection->id,
                'amount' => $collection->amount,
                'direction' => DeliveryManWalletLedger::DIR_DEBIT,
                'meta' => [
                    'fleet_manager_id' => $collection->fleet_manager_id,
                    'collection_id' => $collection->id,
                    'payment_method' => $collection->payment_method,
                    'reviewed_by' => $reviewedBy,
                ],
            ]);

            return $collection->refresh();
        });
    }

    public function rejectCollection(
        FleetPaymentCollection $collection,
        int $reviewedBy,
        string $reason
    ): FleetPaymentCollection {
        if ($collection->status !== FleetPaymentCollection::STATUS_PENDING) {
            throw ValidationException::withMessages([
                'status' => translate('Only pending collections can be rejected.'),
            ]);
        }

        $collection->update([
            'status' => FleetPaymentCollection::STATUS_REJECTED,
            'reviewed_at' => now(),
            'reviewed_by' => $reviewedBy,
            'rejection_reason' => $reason,
        ]);

        return $collection->refresh();
    }
}
