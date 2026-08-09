<?php

namespace App\Services;

use App\Models\DeliveryHistory;
use App\Models\DeliveryMan;
use App\Models\DeliveryManWallet;
use App\Models\DeliveryManWalletLedger;
use App\Models\Expense;
use App\Models\RideOffer;
use App\Models\RideRequest;
use App\Models\RideStatusHistory;
use Illuminate\Support\Facades\DB;

class RideTripService
{
    public function __construct(
        private readonly RideTripStateMachine $stateMachine,
        private readonly RideFareCalculator $fareCalculator,
        private readonly RideSettlementCalculator $settlementCalculator,
        private readonly RideCouponService $couponService,
    ) {}

    public function canCancel(string $status): bool
    {
        return $this->stateMachine->canCancel($status);
    }

    public function transition(DeliveryMan $captain, int $rideId, string $action, ?string $tripPin): array
    {
        return DB::transaction(function () use ($captain, $rideId, $action, $tripPin) {
            $ride = RideRequest::query()->where('delivery_man_id', $captain->id)->lockForUpdate()->findOrFail($rideId);
            $expectedAction = $this->stateMachine->actionFor($ride->status);
            if (! $expectedAction || $expectedAction !== $action) {
                return ['error' => "The next available action is {$expectedAction}."];
            }
            if ($action === 'start_trip' && (! $tripPin || ! hash_equals((string) $ride->trip_pin, $tripPin))) {
                return ['error' => 'The Trip PIN is incorrect.'];
            }

            $fromStatus = $ride->status;
            $toStatus = $this->stateMachine->nextCaptainStatus($fromStatus);
            $updates = ['status' => $toStatus];

            if ($toStatus === RideRequest::STATUS_CAPTAIN_ARRIVING) {
                $updates['captain_arriving_at'] = now();
            } elseif ($toStatus === RideRequest::STATUS_ARRIVED) {
                $updates['arrived_at'] = now();
            } elseif ($toStatus === RideRequest::STATUS_IN_PROGRESS) {
                $updates['trip_started_at'] = now();
                $updates += $this->fareCalculator->waitingCharge(
                    (int) $ride->arrived_at->diffInSeconds(now(), true),
                    (int) $ride->free_waiting_minutes,
                    (float) $ride->waiting_charge_per_minute,
                );
                $this->couponService->redeem($ride);
            } elseif ($toStatus === RideRequest::STATUS_COMPLETED) {
                $updates['completed_at'] = now();
                $updates += $this->settlementCalculator->calculate($ride);
            }

            $ride->update($updates);
            if ($toStatus === RideRequest::STATUS_COMPLETED) {
                $carriedDue = RideRequest::query()->where('recovery_ride_id', $ride->id)->whereNull('cancellation_recovered_at')->sum('cancellation_charge_amount');
                $ride->update(['carried_cancellation_due_amount' => round((float) $carriedDue, 2), ...$this->settlementCalculator->calculate($ride)]);
            }
            $this->history($ride, $fromStatus, $toStatus, 'captain', $captain->id, null, [
                'charged_waiting_minutes' => $ride->charged_waiting_minutes,
                'waiting_charge_amount' => $ride->waiting_charge_amount,
            ]);

            return ['ride' => $ride->fresh(['category', 'user', 'deliveryMan', 'rideVehicle'])];
        });
    }

    public function cancel(RideRequest $ride, string $actorType, int $actorId, ?string $reason): RideRequest
    {
        $fromStatus = $ride->status;
        $charge = $actorType === 'customer' && in_array($fromStatus, [
            RideRequest::STATUS_RIDER_SELECTED,
            RideRequest::STATUS_CAPTAIN_ARRIVING,
            RideRequest::STATUS_ARRIVED,
        ], true) ? (float) $ride->cancellation_charge : 0;
        $ride->status = RideRequest::STATUS_CANCELLED;
        $ride->cancellation_charge_amount = $charge;
        $financials = $charge > 0
            ? $this->settlementCalculator->calculate($ride)
            : [
                'payment_status' => 'not_required',
                'final_payable_amount' => 0,
                'platform_commission_amount' => 0,
                'rider_earning_amount' => 0,
                'captain_total_earning_amount' => 0,
            ];

        $ride->update([
            'status' => RideRequest::STATUS_CANCELLED,
            'cancelled_at' => now(),
            'cancelled_by' => $actorType,
            'cancellation_reason' => $reason,
            'cancellation_charge_amount' => $charge,
            'rider_earning_amount' => $charge,
            'coupon_discount_amount' => 0,
            'admin_coupon_expense_amount' => 0,
            ...$financials,
        ]);
        $this->couponService->release($ride);
        RideRequest::query()->where('recovery_ride_id', $ride->id)->whereNull('cancellation_recovered_at')->update(['recovery_ride_id' => null]);
        if ($ride->carried_cancellation_due_amount > 0) {
            $ride->update(['carried_cancellation_due_amount' => 0]);
        }
        RideOffer::query()->where('ride_request_id', $ride->id)->where('status', RideOffer::STATUS_PENDING)->update(['status' => RideOffer::STATUS_REJECTED]);
        $this->history($ride, $fromStatus, RideRequest::STATUS_CANCELLED, $actorType, $actorId, $reason, ['cancellation_charge_amount' => $charge]);

        if ($charge > 0 && $ride->delivery_man_id && ! $ride->cancellation_compensation_paid_at) {
            $wallet = DeliveryManWallet::query()->firstOrCreate(['delivery_man_id' => $ride->delivery_man_id]);
            $wallet = DeliveryManWallet::query()->whereKey($wallet->id)->lockForUpdate()->firstOrFail();
            $wallet->total_earning += $charge;
            $wallet->save();
            DeliveryManWalletLedger::query()->create([
                'delivery_man_id' => $ride->delivery_man_id, 'transaction_type' => DeliveryManWalletLedger::TYPE_RIDE_CANCELLATION_ADVANCE,
                'reference' => 'ride:'.$ride->id, 'amount' => $charge, 'direction' => DeliveryManWalletLedger::DIR_CREDIT,
                'meta' => ['ride_request_id' => $ride->id, 'request_number' => $ride->request_number, 'funded_by' => 'admin', 'recovery_status' => 'pending'],
            ]);
            $expense = new Expense;
            $expense->amount = $charge;
            $expense->type = 'ride_cancellation_advance';
            $expense->ride_request_id = $ride->id;
            $expense->created_by = 'admin';
            $expense->user_id = $ride->user_id;
            $expense->description = 'Captain cancellation compensation advanced for '.$ride->request_number;
            $expense->save();
            $ride->update(['cancellation_compensation_paid_at' => now(), 'payment_status' => 'due_next_ride']);
        }

        return $ride->fresh(['category', 'user', 'deliveryMan', 'rideVehicle']);
    }

    public function updateLocation(DeliveryMan $captain, int $rideId, float $latitude, float $longitude): ?RideRequest
    {
        return DB::transaction(function () use ($captain, $rideId, $latitude, $longitude) {
            $ride = RideRequest::query()->where('delivery_man_id', $captain->id)->lockForUpdate()->findOrFail($rideId);
            if (! in_array($ride->status, [
                RideRequest::STATUS_RIDER_SELECTED,
                RideRequest::STATUS_CAPTAIN_ARRIVING,
                RideRequest::STATUS_ARRIVED,
                RideRequest::STATUS_IN_PROGRESS,
            ], true)) {
                return null;
            }

            $ride->update([
                'current_latitude' => $latitude,
                'current_longitude' => $longitude,
                'location_updated_at' => now(),
            ]);
            DeliveryHistory::query()->updateOrCreate(['delivery_man_id' => $captain->id], [
                'longitude' => $longitude,
                'latitude' => $latitude,
                'time' => now(),
                'location' => "POINT ({$longitude} {$latitude})",
            ]);

            return $ride;
        });
    }

    public function history(RideRequest $ride, ?string $from, string $to, string $actorType, ?int $actorId, ?string $note = null, ?array $metadata = null): void
    {
        RideStatusHistory::query()->create([
            'ride_request_id' => $ride->id,
            'from_status' => $from,
            'to_status' => $to,
            'actor_type' => $actorType,
            'actor_id' => $actorId,
            'note' => $note,
            'metadata' => $metadata,
        ]);
    }
}
