<?php

namespace App\Services;

use Carbon\CarbonInterface;

class RideNearbyMarkerService
{
    private const MAX_HEADING_AGE_SECONDS = 60;

    private const MAX_ACCURACY_METERS = 100;

    private const MIN_MOVING_SPEED_MPS = 0.5;

    public function marker(object $location, int $precision, CarbonInterface $generatedAt): array
    {
        return [
            'latitude' => round((float) $location->latitude, $precision),
            'longitude' => round((float) $location->longitude, $precision),
            'heading' => $this->reliableHeading($location, $generatedAt),
        ];
    }

    public function normalizeHeading(?float $heading): ?float
    {
        if ($heading === null || ! is_finite($heading)) {
            return null;
        }

        $normalized = fmod($heading, 360.0);

        return round($normalized < 0 ? $normalized + 360.0 : $normalized, 2);
    }

    private function reliableHeading(object $location, CarbonInterface $generatedAt): ?float
    {
        if ($location->heading === null
            || $location->speed_mps === null
            || $location->accuracy_meters === null
            || (float) $location->speed_mps < self::MIN_MOVING_SPEED_MPS
            || (float) $location->accuracy_meters > self::MAX_ACCURACY_METERS
            || ! $location->time
            || $location->time->diffInSeconds($generatedAt) > self::MAX_HEADING_AGE_SECONDS) {
            return null;
        }

        return $this->normalizeHeading((float) $location->heading);
    }
}
