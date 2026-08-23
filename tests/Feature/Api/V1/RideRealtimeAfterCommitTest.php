<?php

namespace Tests\Feature\Api\V1;

use App\Events\RideRealtimeEvent;
use App\Models\RideRequest;
use App\Services\RideCaptainEligibilityService;
use App\Services\RideRealtimeService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Mockery;
use Tests\TestCase;

class RideRealtimeAfterCommitTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (! in_array('sqlite', \PDO::getAvailableDrivers(), true)) {
            $this->markTestSkipped('The pdo_sqlite extension is required for isolated Ride after-commit tests.');
        }
        config()->set('database.default', 'ride_realtime_commit_test');
        config()->set('database.connections.ride_realtime_commit_test', [
            'driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '', 'foreign_key_constraints' => false,
        ]);
        DB::purge('ride_realtime_commit_test');
        DB::setDefaultConnection('ride_realtime_commit_test');
    }

    public function test_status_event_is_dispatched_only_after_transaction_commits(): void
    {
        Event::fake([RideRealtimeEvent::class]);
        $service = new RideRealtimeService(Mockery::mock(RideCaptainEligibilityService::class));
        $ride = new RideRequest;
        $ride->setRawAttributes([
            'id' => 42, 'user_id' => 7, 'delivery_man_id' => 14, 'request_number' => 'ZQR-42',
            'status' => RideRequest::STATUS_CAPTAIN_ARRIVING, 'payment_status' => 'pending', 'updated_at' => now(),
        ]);

        DB::beginTransaction();
        $service->status($ride);
        Event::assertNotDispatched(RideRealtimeEvent::class);
        DB::commit();

        Event::assertDispatched(RideRealtimeEvent::class, fn (RideRealtimeEvent $event) =>
            $event->eventName === 'ride.status.updated' && $event->payload['ride_id'] === 42
        );
    }

    public function test_rolled_back_location_event_is_never_dispatched(): void
    {
        Event::fake([RideRealtimeEvent::class]);
        $service = new RideRealtimeService(Mockery::mock(RideCaptainEligibilityService::class));
        $ride = new RideRequest;
        $ride->setRawAttributes(['id' => 42, 'current_latitude' => 31.45, 'current_longitude' => 73.13]);

        DB::beginTransaction();
        $service->location($ride);
        DB::rollBack();

        Event::assertNotDispatched(RideRealtimeEvent::class);
    }
}
