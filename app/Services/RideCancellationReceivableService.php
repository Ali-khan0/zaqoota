<?php

namespace App\Services;

use App\Models\DeliveryManWallet;
use App\Models\DeliveryManWalletLedger;
use App\Models\RideCancellationReceivable;
use App\Models\RideRequest;

class RideCancellationReceivableService
{
    public function createPending(RideRequest $ride): ?RideCancellationReceivable
    {
        if (! $ride->delivery_man_id || (float) $ride->cancellation_charge_amount <= 0) {
            return null;
        }

        return RideCancellationReceivable::query()->firstOrCreate(
            ['ride_request_id' => $ride->id],
            [
                'user_id' => $ride->user_id,
                'delivery_man_id' => $ride->delivery_man_id,
                'amount' => round((float) $ride->cancellation_charge_amount, 2),
                'status' => RideCancellationReceivable::STATUS_PENDING,
            ],
        );
    }

    public function clear(
        RideRequest $cancelledRide,
        RideRequest $collectionRide,
        string $collectionSource,
        ?string $collectionMethod,
    ): bool {
        $receivable = RideCancellationReceivable::query()
            ->where('ride_request_id', $cancelledRide->id)
            ->lockForUpdate()
            ->first();
        if (! $receivable) {
            $this->createPending($cancelledRide);
            $receivable = RideCancellationReceivable::query()
                ->where('ride_request_id', $cancelledRide->id)
                ->lockForUpdate()
                ->first();
        }
        if (! $receivable || $receivable->status === RideCancellationReceivable::STATUS_CLEARED) {
            return false;
        }

        $reference = 'ride-cancellation-receivable:'.$receivable->id;
        $existingLedger = DeliveryManWalletLedger::query()
            ->where('delivery_man_id', $receivable->delivery_man_id)
            ->where('transaction_type', DeliveryManWalletLedger::TYPE_RIDE_CANCELLATION_EARNING)
            ->where('reference', $reference)
            ->lockForUpdate()
            ->first();
        if (! $existingLedger) {
            $wallet = DeliveryManWallet::query()->firstOrCreate([
                'delivery_man_id' => $receivable->delivery_man_id,
            ]);
            $wallet = DeliveryManWallet::query()->whereKey($wallet->id)->lockForUpdate()->firstOrFail();
            $wallet->total_earning += $receivable->amount;
            $wallet->save();

            DeliveryManWalletLedger::query()->create([
                'delivery_man_id' => $receivable->delivery_man_id,
                'transaction_type' => DeliveryManWalletLedger::TYPE_RIDE_CANCELLATION_EARNING,
                'reference' => $reference,
                'amount' => $receivable->amount,
                'direction' => DeliveryManWalletLedger::DIR_CREDIT,
                'meta' => [
                    'ride_request_id' => $cancelledRide->id,
                    'collection_ride_id' => $collectionRide->id,
                    'collection_source' => $collectionSource,
                    'collection_method' => $collectionMethod,
                    'collected_from_customer' => true,
                ],
            ]);
        }

        $clearedAt = now();
        $receivable->update([
            'status' => RideCancellationReceivable::STATUS_CLEARED,
            'collection_ride_id' => $collectionRide->id,
            'collection_source' => $collectionSource,
            'collection_method' => $collectionMethod,
            'cleared_at' => $clearedAt,
        ]);
        $cancelledRide->update([
            'cancellation_compensation_paid_at' => $clearedAt,
            'cancellation_recovered_at' => $clearedAt,
        ]);

        return true;
    }
}
