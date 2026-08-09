<?php

namespace Tests\Unit;

use App\Events\RideRealtimeEvent;
use App\Jobs\SendRideRequestPush;
use App\Services\RideNotificationService;
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
}
