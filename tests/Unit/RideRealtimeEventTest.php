<?php

namespace Tests\Unit;

use App\Events\RideRealtimeEvent;
use App\Jobs\SendRideRequestPush;
use App\Models\RideRequest;
use App\Services\RideNotificationService;
use App\Services\RideRealtimeService;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class RideRealtimeEventTest extends TestCase
{
    public function test_it_builds_unique_private_channels_and_payload(): void
    {
        $event = new RideRealtimeEvent(
            ['ride.customer.7', 'ride.trip.42', 'ride.trip.42'],
            'ride.status.updated',
            ['ride_id' => 42, 'status' => 'arrived'],
        );

        self::assertSame(['private-ride.customer.7', 'private-ride.trip.42'], array_map(fn ($channel) => $channel->name, $event->broadcastOn()));
        self::assertSame('ride.status.updated', $event->broadcastAs());
        self::assertSame(['ride_id' => 42, 'status' => 'arrived'], $event->broadcastWith());
    }

    public function test_new_ride_request_has_an_admin_managed_captain_template(): void
    {
        $template = RideNotificationService::DEFINITIONS['ride_request_available'];

        self::assertSame('eligible_captains', $template['audience']);
        self::assertStringContainsString('{rideNumber}', $template['body']);
        self::assertStringContainsString('{pickupAddress}', $template['body']);
    }

    public function test_new_ride_push_job_is_retryable_and_preserves_payload(): void
    {
        $payload = ['type' => 'ride_request', 'trip_id' => '42'];
        $job = new SendRideRequestPush(9, $payload);

        self::assertSame(9, $job->deliveryId);
        self::assertSame($payload, $job->payload);
        self::assertSame(3, $job->tries);
        self::assertSame(30, $job->timeout);
    }

    public function test_location_payload_contains_only_ride_telemetry_and_server_time(): void
    {
        $ride = new RideRequest;
        $ride->setRawAttributes([
            'id' => 42,
            'current_latitude' => 31.4504,
            'current_longitude' => 73.1350,
            'current_heading' => 145.5,
            'current_speed_mps' => 8.5,
            'current_accuracy_meters' => 12.0,
            'location_updated_at' => Carbon::parse('2026-08-15T12:10:00+05:00'),
        ]);

        $payload = RideRealtimeService::locationPayload($ride);

        self::assertSame(42, $payload['ride_id']);
        self::assertSame(145.5, $payload['heading']);
        self::assertSame(8.5, $payload['speed_mps']);
        self::assertSame(12.0, $payload['accuracy_meters']);
        self::assertArrayNotHasKey('captain_id', $payload);
        self::assertArrayNotHasKey('trip_pin', $payload);
    }
}
