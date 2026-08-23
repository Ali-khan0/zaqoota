<?php

namespace Tests\Unit;

use App\Services\RideNearbyMarkerService;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class RideNearbyMarkerServiceTest extends TestCase
{
    public function test_it_rounds_coordinates_and_normalizes_reliable_heading(): void
    {
        $generatedAt = Carbon::parse('2026-08-23 12:00:00');
        $location = (object) [
            'latitude' => 31.45123,
            'longitude' => 73.12987,
            'heading' => -10,
            'speed_mps' => 2,
            'accuracy_meters' => 12,
            'time' => $generatedAt->copy()->subSeconds(10),
        ];

        self::assertSame([
            'latitude' => 31.45,
            'longitude' => 73.13,
            'heading' => 350.0,
        ], (new RideNearbyMarkerService)->marker($location, 2, $generatedAt));
    }

    public function test_marker_contract_cannot_expose_captain_or_vehicle_identity(): void
    {
        $generatedAt = Carbon::parse('2026-08-23 12:00:00');
        $location = (object) [
            'latitude' => 31.45123,
            'longitude' => 73.12987,
            'heading' => 90,
            'speed_mps' => 2,
            'accuracy_meters' => 12,
            'time' => $generatedAt,
            'delivery_man_id' => 77,
            'name' => 'Private Captain',
            'phone' => '03000000000',
            'registration_number' => 'ABC-123',
            'auth_token' => 'secret',
            'private_channel' => 'ride.trip.10',
        ];

        $marker = (new RideNearbyMarkerService)->marker($location, 2, $generatedAt);

        self::assertSame(['latitude', 'longitude', 'heading'], array_keys($marker));
        self::assertSame(31.45, $marker['latitude']);
        self::assertSame(73.13, $marker['longitude']);
    }

    #[DataProvider('unreliableTelemetry')]
    public function test_it_hides_heading_when_telemetry_is_not_reliable(array $attributes): void
    {
        $generatedAt = Carbon::parse('2026-08-23 12:00:00');
        $location = (object) array_merge([
            'latitude' => 31.45,
            'longitude' => 73.13,
            'heading' => 90,
            'speed_mps' => 2,
            'accuracy_meters' => 12,
            'time' => $generatedAt->copy()->subSeconds(10),
        ], $attributes);

        self::assertNull((new RideNearbyMarkerService)->marker($location, 2, $generatedAt)['heading']);
    }

    public static function unreliableTelemetry(): array
    {
        return [
            'missing heading' => [['heading' => null]],
            'stationary' => [['speed_mps' => 0.49]],
            'inaccurate' => [['accuracy_meters' => 100.01]],
            'stale' => [['time' => Carbon::parse('2026-08-23 11:58:59')]],
        ];
    }
}
