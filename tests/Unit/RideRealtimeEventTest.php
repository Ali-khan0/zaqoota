<?php

namespace Tests\Unit;

use App\Events\RideRealtimeEvent;
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
}
