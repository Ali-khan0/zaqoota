<?php

namespace App\Services;

use App\Models\BusinessSetting;
use App\Models\DeliveryMan;
use App\Models\Order;
use App\Models\RideRequest;
use App\Models\RideVehicle;
use Illuminate\Support\Collection;

class RideCaptainEligibilityService
{
    public function eligibleCaptains(int $zoneId, int $categoryId, int $limit = 100): Collection
    {
        return DeliveryMan::query()->withoutGlobalScopes()
            ->where('application_status', 'approved')
            ->where('work_mode', 'ride')
            ->where('active', 1)
            ->where('zone_id', $zoneId)
            ->whereHas('rideVehicles', fn ($query) => $query
                ->where('ride_category_id', $categoryId)
                ->where('status', 'approved')
                ->where('is_active', true))
            ->limit(max(1, min($limit, 100)))
            ->get()
            ->filter(fn (DeliveryMan $captain) => $this->vehicleFor($captain, $categoryId, $zoneId) !== null)
            ->values();
    }

    public function eligibleCaptainsForRide(RideRequest $ride, int $limit = 100): Collection
    {
        $earthRadius = 6371000;
        $distanceSql = "$earthRadius * 2 * ASIN(SQRT(POWER(SIN(RADIANS(delivery_histories.latitude - ?) / 2), 2) + COS(RADIANS(?)) * COS(RADIANS(delivery_histories.latitude)) * POWER(SIN(RADIANS(delivery_histories.longitude - ?) / 2), 2)))";
        $bindings = [(float) $ride->pickup_latitude, (float) $ride->pickup_latitude, (float) $ride->pickup_longitude];

        return DeliveryMan::query()->withoutGlobalScopes()
            ->join('delivery_histories', 'delivery_histories.delivery_man_id', '=', 'delivery_men.id')
            ->select('delivery_men.*')->selectRaw("$distanceSql AS pickup_distance_meters", $bindings)
            ->whereRaw('delivery_histories.id = (SELECT MAX(dh.id) FROM delivery_histories dh WHERE dh.delivery_man_id = delivery_men.id)')
            ->where('application_status', 'approved')
            ->where('work_mode', 'ride')
            ->where('active', 1)
            ->where('zone_id', $ride->zone_id)
            ->whereHas('rideVehicles', fn ($query) => $query
                ->where('ride_category_id', $ride->ride_category_id)
                ->where('status', 'approved')
                ->where('is_active', true))
            ->whereRaw("$distanceSql <= ?", [...$bindings, $this->maximumPickupRadiusMeters()])
            ->orderBy('pickup_distance_meters')
            ->limit(max(100, min($limit * 3, 300)))
            ->get()
            ->filter(fn (DeliveryMan $captain) => $this->vehicleFor($captain, $ride->ride_category_id, $ride->zone_id) !== null)
            ->map(function (DeliveryMan $captain) {
                $distance = (int) round($captain->getAttribute('pickup_distance_meters'));
                $captain->setAttribute('pickup_distance_meters', $distance);
                $captain->setAttribute('pickup_eta_seconds', (int) ceil($distance / ($this->pickupEtaSpeedKmh() * 1000 / 3600)));

                return $captain;
            })
            ->take(max(1, min($limit, 100)))
            ->values();
    }

    public function pickupMetrics(DeliveryMan $captain, RideRequest $ride): ?array
    {
        $location = $captain->last_location()->first();
        if (! $location || ! is_numeric($location->latitude) || ! is_numeric($location->longitude)) {
            return null;
        }
        $distance = $this->distanceMeters((float) $location->latitude, (float) $location->longitude, (float) $ride->pickup_latitude, (float) $ride->pickup_longitude);
        $speedMetersPerSecond = $this->pickupEtaSpeedKmh() * 1000 / 3600;

        return ['distance_meters' => $distance, 'eta_seconds' => (int) ceil($distance / $speedMetersPerSecond)];
    }

    public function maximumPickupRadiusMeters(): int
    {
        return (int) round(max(1, min(200, (float) BusinessSetting::query()->where('key', 'ride_hailing_maximum_pickup_radius_km')->value('value') ?: 25)) * 1000);
    }

    public function pickupEtaSpeedKmh(): float
    {
        return max(5, min(120, (float) BusinessSetting::query()->where('key', 'ride_hailing_pickup_eta_speed_kmh')->value('value') ?: 25));
    }

    private function distanceMeters(float $latitude, float $longitude, float $pickupLatitude, float $pickupLongitude): int
    {
        $latitudeDelta = deg2rad($pickupLatitude - $latitude);
        $longitudeDelta = deg2rad($pickupLongitude - $longitude);
        $a = sin($latitudeDelta / 2) ** 2 + cos(deg2rad($latitude)) * cos(deg2rad($pickupLatitude)) * sin($longitudeDelta / 2) ** 2;

        return (int) round(6371000 * 2 * atan2(sqrt($a), sqrt(1 - $a)));
    }

    public function captainByToken(string $token): ?DeliveryMan
    {
        return DeliveryMan::query()->withoutGlobalScopes()->where('auth_token', $token)->first();
    }

    public function vehicleFor(DeliveryMan $captain, int $categoryId, int $zoneId): ?RideVehicle
    {
        if ($captain->application_status !== 'approved'
            || $captain->work_mode !== 'ride'
            || (int) $captain->active !== 1
            || (int) $captain->zone_id !== $zoneId
            || $this->hasConflictingOrder($captain)
            || $this->hasActivePassengerRide($captain)) {
            return null;
        }

        return RideVehicle::query()
            ->where('delivery_man_id', $captain->id)
            ->where('ride_category_id', $categoryId)
            ->where('status', 'approved')
            ->where('is_active', true)
            ->first();
    }

    private function hasConflictingOrder(DeliveryMan $captain): bool
    {
        return Order::query()
            ->where('delivery_man_id', $captain->id)
            ->where(function ($query) {
                $query->whereNull('order_type')->orWhere('order_type', '!=', 'parcel');
            })
            ->whereIn('order_status', ['accepted', 'confirmed', 'pending', 'processing', 'picked_up', 'handover'])
            ->exists();
    }

    private function hasActivePassengerRide(DeliveryMan $captain): bool
    {
        return RideRequest::query()
            ->where('delivery_man_id', $captain->id)
            ->whereIn('status', [
                RideRequest::STATUS_RIDER_SELECTED,
                RideRequest::STATUS_CAPTAIN_ARRIVING,
                RideRequest::STATUS_ARRIVED,
                RideRequest::STATUS_IN_PROGRESS,
            ])
            ->exists();
    }
}
