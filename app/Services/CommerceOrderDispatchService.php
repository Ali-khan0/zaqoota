<?php

namespace App\Services;

use App\Jobs\DispatchCommerceOrderWave;
use App\Models\BusinessSetting;
use App\Models\DeliveryMan;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CommerceOrderDispatchService
{
    public function __construct(private readonly CommerceOrderEligibilityService $eligibility) {}

    public function visibleOrdersFor(DeliveryMan $deliveryMan): Collection
    {
        return $this->eligibility->availableQuery($deliveryMan)
            ->with(['customer', 'store', 'parcel_category'])
            ->get()
            ->map(function (Order $order) use ($deliveryMan) {
                $ranked = $this->rankedCaptains($order);
                $position = $ranked->search(fn (DeliveryMan $captain) => (int) $captain->id === (int) $deliveryMan->id);
                if ($position === false || $position >= $this->visibleCaptainCount($order)) {
                    return null;
                }
                $captain = $position === false ? null : $ranked->get($position);
                $order->setAttribute('pickup_distance_meters', $captain?->getAttribute('pickup_distance_meters'));
                $order->setAttribute('dispatch_wave', $position === false ? null : intdiv($position, $this->waveSize()) + 1);

                return $order;
            })
            ->filter()
            ->sortBy('pickup_distance_meters')
            ->values();
    }

    public function isVisibleTo(DeliveryMan $deliveryMan, Order $order): bool
    {
        if (! $this->pickupCoordinates($order) || ! $this->eligibility->isAvailableTo($deliveryMan, $order)) {
            return false;
        }

        $position = $this->rankedCaptains($order)
            ->search(fn (DeliveryMan $captain) => (int) $captain->id === (int) $deliveryMan->id);

        return $position !== false && $position < $this->visibleCaptainCount($order);
    }

    public function rankedCaptains(Order $order): Collection
    {
        $pickup = $this->pickupCoordinates($order);
        if (! $pickup) {
            return collect();
        }

        $query = DeliveryMan::query()->withoutGlobalScopes()
            ->with(['last_location', 'wallet', 'activeCommerceVehicle.vehicleType'])
            ->where('application_status', 'approved')
            ->where('active', 1)
            ->whereHas('activeCommerceVehicle')
            ->where(function ($captains) use ($order) {
                $captains->where(function ($zoneWise) use ($order) {
                    $zoneWise->where('type', 'zone_wise')->where('zone_id', $order->zone_id);
                });
                if ($order->store_id) {
                    $captains->orWhere(function ($storeWise) use ($order) {
                        $storeWise->where('type', '!=', 'zone_wise')->where('store_id', $order->store_id);
                    });
                }
            })
            ->get();
        $maximumPickupRadius = $this->maximumPickupRadiusMeters($order);

        return $query
            ->filter(function (DeliveryMan $captain) use ($order) {
                $location = $captain->last_location;

                return $location
                    && is_numeric($location->latitude)
                    && is_numeric($location->longitude)
                    && $this->locationTimestamp($location)?->gte(now()->subSeconds($this->locationFreshnessSeconds()))
                    && $this->eligibility->isAvailableTo($captain, $order);
            })
            ->map(function (DeliveryMan $captain) use ($pickup) {
                $captain->setAttribute('pickup_distance_meters', $this->distanceMeters(
                    (float) $captain->last_location->latitude,
                    (float) $captain->last_location->longitude,
                    $pickup['latitude'],
                    $pickup['longitude'],
                ));

                return $captain;
            })
            ->filter(fn (DeliveryMan $captain) => (int) $captain->getAttribute('pickup_distance_meters') <= $maximumPickupRadius)
            ->sortBy(fn (DeliveryMan $captain) => [
                $captain->getAttribute('pickup_distance_meters'),
                (int) $captain->id,
            ])
            ->values();
    }

    public function captainsForWave(Order $order, int $wave): Collection
    {
        return $this->rankedCaptains($order)
            ->slice($wave * $this->waveSize(), $this->waveSize())
            ->values();
    }

    public function captainsVisibleThroughWave(Order $order, int $wave): Collection
    {
        return $this->rankedCaptains($order)
            ->take(($wave + 1) * $this->waveSize())
            ->values();
    }

    public function dispatch(Order $order, array $payload): void
    {
        $captainCount = $this->rankedCaptains($order)->count();
        if ($captainCount === 0) {
            return;
        }

        $payload['type'] = 'order_request';
        $waveCount = (int) ceil($captainCount / $this->waveSize());
        for ($wave = 0; $wave < $waveCount; $wave++) {
            $releaseAt = $this->dispatchStartedAt($order)
                ->addSeconds($wave * $this->waveIntervalSeconds());
            DispatchCommerceOrderWave::dispatch($order->id, $wave, $payload)
                ->delay($releaseAt->isFuture() ? $releaseAt : now());
        }
    }

    public function visibleCaptainCount(Order $order): int
    {
        $elapsed = (int) max(0, $this->dispatchStartedAt($order)->diffInSeconds(now(), false));

        return ($this->waveSize() * (intdiv($elapsed, $this->waveIntervalSeconds()) + 1));
    }

    public function dispatchStartedAt(Order $order): Carbon
    {
        $createdAt = Carbon::parse($order->created_at);
        $statusTimestamp = match ($order->order_status) {
            'confirmed' => $order->confirmed,
            'processing' => $order->processing,
            'handover' => $order->handover,
            default => $order->pending,
        };
        $eligibleAt = $statusTimestamp && Carbon::parse($statusTimestamp)->greaterThan($createdAt)
            ? Carbon::parse($statusTimestamp)
            : $createdAt;

        if (! $order->scheduled || ! $order->schedule_at) {
            return $eligibleAt;
        }

        $scheduledStart = Carbon::parse($order->schedule_at)->subMinutes(30);

        return $scheduledStart->greaterThan($eligibleAt) ? $scheduledStart : $eligibleAt;
    }

    public function waveSize(): int
    {
        return max(1, min(50, (int) ($this->setting('commerce_dispatch_wave_size') ?: 3)));
    }

    public function waveIntervalSeconds(): int
    {
        return max(5, min(300, (int) ($this->setting('commerce_dispatch_wave_interval_seconds') ?: 20)));
    }

    public function locationFreshnessSeconds(): int
    {
        return max(30, min(1800, (int) ($this->setting('commerce_dispatch_location_freshness_seconds') ?: 180)));
    }

    public function maximumPickupRadiusMeters(Order $order): int
    {
        $key = $order->order_type === 'parcel'
            ? 'parcel_dispatch_maximum_pickup_radius_km'
            : 'commerce_dispatch_maximum_pickup_radius_km';
        $defaultKilometers = $order->order_type === 'parcel' ? 10 : 5;
        $kilometers = (float) ($this->setting($key) ?: $defaultKilometers);

        return (int) round(max(1, min(200, $kilometers)) * 1000);
    }

    private function pickupCoordinates(Order $order): ?array
    {
        if ($order->order_type === 'parcel') {
            $address = is_array($order->delivery_address)
                ? $order->delivery_address
                : json_decode((string) $order->delivery_address, true);
            $latitude = $address['latitude'] ?? null;
            $longitude = $address['longitude'] ?? null;
        } else {
            $order->loadMissing('store');
            $latitude = $order->store?->latitude;
            $longitude = $order->store?->longitude;
        }

        if (! is_numeric($latitude) || ! is_numeric($longitude)) {
            return null;
        }

        return ['latitude' => (float) $latitude, 'longitude' => (float) $longitude];
    }

    private function locationTimestamp($location): ?Carbon
    {
        $value = $location->time ?: $location->updated_at;

        return $value ? Carbon::parse($value) : null;
    }

    protected function setting(string $key): mixed
    {
        return BusinessSetting::query()->where('key', $key)->value('value');
    }

    private function distanceMeters(float $latitude, float $longitude, float $pickupLatitude, float $pickupLongitude): int
    {
        $latitudeDelta = deg2rad($pickupLatitude - $latitude);
        $longitudeDelta = deg2rad($pickupLongitude - $longitude);
        $a = sin($latitudeDelta / 2) ** 2
            + cos(deg2rad($latitude)) * cos(deg2rad($pickupLatitude)) * sin($longitudeDelta / 2) ** 2;

        return (int) round(6371000 * 2 * atan2(sqrt($a), sqrt(1 - $a)));
    }
}
