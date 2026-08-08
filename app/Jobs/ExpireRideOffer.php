<?php

namespace App\Jobs;

use App\Models\RideOffer;
use App\Services\RideRealtimeService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class ExpireRideOffer implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly int $offerId) {}

    public function handle(RideRealtimeService $realtimeService): void
    {
        $offer = DB::transaction(function () {
            $offer = RideOffer::query()->lockForUpdate()->find($this->offerId);
            if (! $offer || $offer->status !== RideOffer::STATUS_PENDING || $offer->expires_at->isFuture()) {
                return null;
            }
            $offer->update(['status' => RideOffer::STATUS_EXPIRED]);

            return $offer->fresh('rideRequest');
        });

        if ($offer) {
            $realtimeService->offer($offer);
        }
    }
}
