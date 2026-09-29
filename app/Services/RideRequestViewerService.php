<?php

namespace App\Services;

use App\Models\DeliveryMan;
use App\Models\RideRequest;
use App\Models\RideRequestView;
use Illuminate\Support\Facades\DB;

class RideRequestViewerService
{
    public function __construct(
        private readonly RideCaptainEligibilityService $eligibility,
        private readonly RideDispatchService $dispatch,
    ) {}

    public function acknowledge(int $rideId, DeliveryMan $captain): array
    {
        return DB::transaction(function () use ($rideId, $captain) {
            $ride = RideRequest::query()->lockForUpdate()->findOrFail($rideId);
            if (! in_array($ride->status, [RideRequest::STATUS_SEARCHING, RideRequest::STATUS_NEGOTIATING], true)) {
                return ['accepted' => false, 'created' => false, 'ride' => $ride, 'summary' => null];
            }
            if ($ride->offers()->where('delivery_man_id', $captain->id)
                ->where('rejected_by', 'customer')->exists()) {
                return ['accepted' => false, 'created' => false, 'ride' => $ride, 'summary' => null];
            }

            $vehicle = $this->eligibility->vehicleFor($captain, (int) $ride->ride_category_id);
            $metrics = $this->eligibility->pickupMetrics($captain, $ride);
            if (! $vehicle || ! $metrics
                || $metrics['distance_meters'] > $this->eligibility->maximumPickupRadiusMeters()
                || ! $this->dispatch->isVisibleTo($captain, $ride)) {
                return ['accepted' => false, 'created' => false, 'ride' => $ride, 'summary' => null];
            }

            $now = now();
            $created = RideRequestView::query()->insertOrIgnore([
                'ride_request_id' => $ride->id,
                'delivery_man_id' => $captain->id,
                'viewed_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]) === 1;

            return [
                'accepted' => true,
                'created' => $created,
                'ride' => $ride,
                'summary' => $this->summary($ride),
            ];
        });
    }

    public function summary(RideRequest $ride): array
    {
        if (! in_array($ride->status, [RideRequest::STATUS_SEARCHING, RideRequest::STATUS_NEGOTIATING], true)) {
            return ['count' => 0, 'avatars' => []];
        }

        $query = RideRequestView::query()->where('ride_request_id', $ride->id);
        $count = (clone $query)->count();
        $avatars = $query->with('deliveryMan')->latest('viewed_at')->limit(5)->get()
            ->map(fn (RideRequestView $view) => [
                'image_url' => $view->deliveryMan?->image
                    ? (string) $view->deliveryMan->image_full_url
                    : '',
            ])->values()->all();

        return ['count' => $count, 'avatars' => $avatars];
    }
}
