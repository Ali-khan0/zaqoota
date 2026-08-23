<?php

namespace App\Services;

use App\Models\RideRequest;
use Carbon\CarbonInterface;
use RuntimeException;

class RideCaptainPickupRouteService
{
    public const VISIBLE_STATUSES = [
        RideRequest::STATUS_RIDER_SELECTED,
        RideRequest::STATUS_CAPTAIN_ARRIVING,
        RideRequest::STATUS_ARRIVED,
    ];

    public const MOVEMENT_THRESHOLD_METERS = 75;

    public const MAX_AGE_SECONDS = 15;

    public function __construct(private readonly RideRouteService $routeService) {}

    public function refresh(RideRequest $ride, ?CarbonInterface $now = null): RideRequest
    {
        $now ??= now();
        if (! $this->isVisible($ride)
            || $ride->current_latitude === null
            || $ride->current_longitude === null
            || ! $this->needsRefresh($ride, $now)) {
            return $ride;
        }

        try {
            $route = $this->routeService->calculate(
                (float) $ride->current_latitude,
                (float) $ride->current_longitude,
                (float) $ride->pickup_latitude,
                (float) $ride->pickup_longitude,
            );
        } catch (RuntimeException) {
            return $ride;
        }

        $ride->update([
            'captain_pickup_route_polyline' => $route['route_polyline'],
            'captain_pickup_route_distance_meters' => $route['distance_meters'],
            'captain_pickup_route_duration_seconds' => $route['duration_seconds'],
            'captain_pickup_route_origin_latitude' => $ride->current_latitude,
            'captain_pickup_route_origin_longitude' => $ride->current_longitude,
            'captain_pickup_route_generated_at' => $now,
        ]);

        return $ride->fresh();
    }

    public function needsRefresh(RideRequest $ride, CarbonInterface $now): bool
    {
        if (! $ride->captain_pickup_route_polyline
            || $ride->captain_pickup_route_origin_latitude === null
            || $ride->captain_pickup_route_origin_longitude === null
            || ! $ride->captain_pickup_route_generated_at) {
            return true;
        }

        if ($ride->captain_pickup_route_generated_at->diffInSeconds($now) >= self::MAX_AGE_SECONDS) {
            return true;
        }

        return $this->distanceMeters(
            (float) $ride->captain_pickup_route_origin_latitude,
            (float) $ride->captain_pickup_route_origin_longitude,
            (float) $ride->current_latitude,
            (float) $ride->current_longitude,
        ) >= self::MOVEMENT_THRESHOLD_METERS;
    }

    public function data(RideRequest $ride): ?array
    {
        if (! $this->isVisible($ride) || ! $ride->captain_pickup_route_polyline || ! $ride->captain_pickup_route_generated_at) {
            return null;
        }

        return [
            'route_polyline' => $ride->captain_pickup_route_polyline,
            'distance_meters' => (int) $ride->captain_pickup_route_distance_meters,
            'duration_seconds' => (int) $ride->captain_pickup_route_duration_seconds,
            'generated_at' => $ride->captain_pickup_route_generated_at->toIso8601String(),
        ];
    }

    public function clear(RideRequest $ride): void
    {
        $ride->update($this->emptyCache());
    }

    public function emptyCache(): array
    {
        return [
            'captain_pickup_route_polyline' => null,
            'captain_pickup_route_distance_meters' => null,
            'captain_pickup_route_duration_seconds' => null,
            'captain_pickup_route_origin_latitude' => null,
            'captain_pickup_route_origin_longitude' => null,
            'captain_pickup_route_generated_at' => null,
        ];
    }

    private function isVisible(RideRequest $ride): bool
    {
        return in_array($ride->status, self::VISIBLE_STATUSES, true) && $ride->delivery_man_id !== null;
    }

    private function distanceMeters(float $fromLat, float $fromLng, float $toLat, float $toLng): float
    {
        $latitudeDelta = deg2rad($toLat - $fromLat);
        $longitudeDelta = deg2rad($toLng - $fromLng);
        $a = sin($latitudeDelta / 2) ** 2
            + cos(deg2rad($fromLat)) * cos(deg2rad($toLat)) * sin($longitudeDelta / 2) ** 2;

        return 6371000 * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }
}
