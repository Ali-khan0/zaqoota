<?php

namespace App\Services;

use App\Models\BusinessSetting;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class RideRouteService
{
    public function calculate(float $pickupLat, float $pickupLng, float $destinationLat, float $destinationLng): array
    {
        $apiKey = BusinessSetting::query()->where('key', 'map_api_key_server')->value('value');
        if (! $apiKey) {
            throw new RuntimeException('Server map API key is not configured.');
        }

        $response = Http::timeout(10)
            ->retry(2, 200)
            ->withHeaders([
                'X-Goog-Api-Key' => $apiKey,
                'X-Goog-FieldMask' => 'routes.duration,routes.distanceMeters,routes.polyline.encodedPolyline',
            ])->post('https://routes.googleapis.com/directions/v2:computeRoutes', [
                'origin' => ['location' => ['latLng' => ['latitude' => $pickupLat, 'longitude' => $pickupLng]]],
                'destination' => ['location' => ['latLng' => ['latitude' => $destinationLat, 'longitude' => $destinationLng]]],
                'travelMode' => 'DRIVE',
                'routingPreference' => 'TRAFFIC_AWARE',
            ]);

        $route = $response->successful() ? $response->json('routes.0') : null;
        if (! $route || empty($route['distanceMeters']) || empty($route['duration'])) {
            throw new RuntimeException('A driving route could not be calculated.');
        }

        return [
            'distance_meters' => (int) $route['distanceMeters'],
            'duration_seconds' => (int) round((float) rtrim((string) $route['duration'], 's')),
            'route_polyline' => data_get($route, 'polyline.encodedPolyline'),
        ];
    }
}
