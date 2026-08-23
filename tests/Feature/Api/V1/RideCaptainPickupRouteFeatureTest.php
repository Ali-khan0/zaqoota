<?php

namespace Tests\Feature\Api\V1;

use App\Models\RideRequest;
use App\Services\RideCaptainPickupRouteService;
use App\Services\RideRouteService;
use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mockery;
use Tests\TestCase;

class RideCaptainPickupRouteFeatureTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (! in_array('sqlite', \PDO::getAvailableDrivers(), true)) {
            $this->markTestSkipped('The pdo_sqlite extension is required for isolated Captain pickup route feature tests.');
        }
        config()->set('database.default', 'ride_pickup_route_test');
        config()->set('database.connections.ride_pickup_route_test', [
            'driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '', 'foreign_key_constraints' => false,
        ]);
        DB::purge('ride_pickup_route_test');
        DB::setDefaultConnection('ride_pickup_route_test');
        $this->createTable();
    }

    public function test_successful_route_is_persisted_reused_and_refreshed_after_movement(): void
    {
        $ride = $this->ride(7);
        $provider = Mockery::mock(RideRouteService::class);
        $provider->shouldReceive('calculate')->twice()->andReturn(
            ['route_polyline' => 'first-road-route', 'distance_meters' => 1850, 'duration_seconds' => 310],
            ['route_polyline' => 'moved-road-route', 'distance_meters' => 1700, 'duration_seconds' => 280],
        );
        $service = new RideCaptainPickupRouteService($provider);
        $at = Carbon::parse('2026-08-23 12:00:00');

        $ride = $service->refresh($ride, $at);
        self::assertSame('first-road-route', $ride->captain_pickup_route_polyline);
        self::assertSame(1850, $ride->captain_pickup_route_distance_meters);
        self::assertSame($ride->id, RideRequest::query()->where('user_id', 7)->findOrFail($ride->id)->id);
        self::assertNull(RideRequest::query()->where('user_id', 8)->find($ride->id));

        $ride = $service->refresh($ride, $at->copy()->addSeconds(5));
        self::assertSame('first-road-route', $ride->captain_pickup_route_polyline);

        $ride->update(['current_longitude' => 73.131]);
        $ride = $service->refresh($ride->fresh(), $at->copy()->addSeconds(6));
        self::assertSame('moved-road-route', $ride->captain_pickup_route_polyline);
        self::assertSame('booked-pickup-to-destination', $ride->route_polyline);
    }

    private function ride(int $userId): RideRequest
    {
        return RideRequest::query()->create([
            'user_id' => $userId, 'delivery_man_id' => 14, 'status' => RideRequest::STATUS_RIDER_SELECTED,
            'pickup_latitude' => 31.46, 'pickup_longitude' => 73.14,
            'current_latitude' => 31.45, 'current_longitude' => 73.13,
            'route_polyline' => 'booked-pickup-to-destination',
        ]);
    }

    private function createTable(): void
    {
        Schema::create('ride_requests', function (Blueprint $table): void {
            $table->id(); $table->unsignedBigInteger('user_id'); $table->unsignedBigInteger('delivery_man_id')->nullable();
            $table->string('status'); $table->decimal('pickup_latitude', 10, 7); $table->decimal('pickup_longitude', 10, 7);
            $table->decimal('current_latitude', 10, 7)->nullable(); $table->decimal('current_longitude', 10, 7)->nullable();
            $table->text('route_polyline')->nullable(); $table->text('captain_pickup_route_polyline')->nullable();
            $table->unsignedInteger('captain_pickup_route_distance_meters')->nullable();
            $table->unsignedInteger('captain_pickup_route_duration_seconds')->nullable();
            $table->decimal('captain_pickup_route_origin_latitude', 10, 7)->nullable();
            $table->decimal('captain_pickup_route_origin_longitude', 10, 7)->nullable();
            $table->timestamp('captain_pickup_route_generated_at')->nullable(); $table->timestamps();
        });
    }
}
