<?php

namespace Tests\Unit;

use App\Models\RideRequest;
use App\Services\RideCaptainPickupRouteService;
use App\Services\RideRouteService;
use Carbon\Carbon;
use Mockery;
use RuntimeException;
use Tests\TestCase;

class RideCaptainPickupRouteServiceTest extends TestCase
{
    public function test_recent_cache_is_reused_below_movement_threshold(): void
    {
        $now = Carbon::parse('2026-08-23 12:00:10');
        $ride = $this->cachedRide([
            'current_latitude' => 31.4503,
            'current_longitude' => 73.1303,
            'captain_pickup_route_generated_at' => $now->copy()->subSeconds(10),
        ]);

        self::assertFalse($this->service()->needsRefresh($ride, $now));
    }

    public function test_cache_refreshes_after_material_movement(): void
    {
        $now = Carbon::parse('2026-08-23 12:00:10');
        $ride = $this->cachedRide([
            'current_longitude' => 73.131,
            'captain_pickup_route_generated_at' => $now->copy()->subSeconds(5),
        ]);

        self::assertTrue($this->service()->needsRefresh($ride, $now));
    }

    public function test_cache_refreshes_when_stale(): void
    {
        $now = Carbon::parse('2026-08-23 12:00:20');
        $ride = $this->cachedRide(['captain_pickup_route_generated_at' => $now->copy()->subSeconds(15)]);

        self::assertTrue($this->service()->needsRefresh($ride, $now));
    }

    public function test_route_payload_is_visible_only_before_trip_start_for_assigned_ride(): void
    {
        $ride = $this->cachedRide();
        $service = $this->service();

        self::assertSame([
            'route_polyline' => 'captain-to-pickup',
            'distance_meters' => 1850,
            'duration_seconds' => 310,
            'generated_at' => '2026-08-23T12:00:00+00:00',
        ], $service->data($ride));

        foreach ([RideRequest::STATUS_IN_PROGRESS, RideRequest::STATUS_CANCELLED, RideRequest::STATUS_COMPLETED] as $status) {
            $ride->status = $status;
            self::assertNull($service->data($ride));
        }
        $ride->status = RideRequest::STATUS_RIDER_SELECTED;
        $ride->delivery_man_id = null;
        self::assertNull($service->data($ride));
    }

    public function test_provider_failure_keeps_existing_ride_state_and_does_not_expose_empty_route(): void
    {
        $routeService = Mockery::mock(RideRouteService::class);
        $routeService->shouldReceive('calculate')->once()->andThrow(new RuntimeException('provider unavailable'));
        $service = new RideCaptainPickupRouteService($routeService);
        $ride = $this->cachedRide([
            'captain_pickup_route_polyline' => null,
            'captain_pickup_route_generated_at' => null,
        ]);

        self::assertSame($ride, $service->refresh($ride, Carbon::parse('2026-08-23 12:00:00')));
        self::assertNull($service->data($ride));
    }

    public function test_empty_cache_clears_only_captain_approach_fields(): void
    {
        $ride = $this->cachedRide(['route_polyline' => 'booked-pickup-to-destination']);
        $ride->forceFill($this->service()->emptyCache());

        self::assertSame('booked-pickup-to-destination', $ride->route_polyline);
        self::assertNull($ride->captain_pickup_route_polyline);
        self::assertNull($ride->captain_pickup_route_generated_at);
    }

    private function service(): RideCaptainPickupRouteService
    {
        return new RideCaptainPickupRouteService(Mockery::mock(RideRouteService::class));
    }

    private function cachedRide(array $overrides = []): RideRequest
    {
        $ride = new RideRequest;
        $ride->setRawAttributes(array_merge([
            'status' => RideRequest::STATUS_RIDER_SELECTED,
            'delivery_man_id' => 14,
            'pickup_latitude' => 31.46,
            'pickup_longitude' => 73.14,
            'current_latitude' => 31.45,
            'current_longitude' => 73.13,
            'captain_pickup_route_polyline' => 'captain-to-pickup',
            'captain_pickup_route_distance_meters' => 1850,
            'captain_pickup_route_duration_seconds' => 310,
            'captain_pickup_route_origin_latitude' => 31.45,
            'captain_pickup_route_origin_longitude' => 73.13,
            'captain_pickup_route_generated_at' => '2026-08-23 12:00:00',
        ], $overrides));

        return $ride;
    }
}
