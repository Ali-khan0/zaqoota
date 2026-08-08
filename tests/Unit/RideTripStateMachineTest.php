<?php

namespace Tests\Unit;

use App\Models\RideRequest;
use App\Services\RideTripStateMachine;
use PHPUnit\Framework\TestCase;

class RideTripStateMachineTest extends TestCase
{
    public function test_it_allows_only_the_ordered_captain_trip_actions(): void
    {
        $machine = new RideTripStateMachine;

        self::assertSame('start_pickup', $machine->actionFor(RideRequest::STATUS_RIDER_SELECTED));
        self::assertSame('arrived', $machine->actionFor(RideRequest::STATUS_CAPTAIN_ARRIVING));
        self::assertSame('start_trip', $machine->actionFor(RideRequest::STATUS_ARRIVED));
        self::assertSame('complete', $machine->actionFor(RideRequest::STATUS_IN_PROGRESS));
        self::assertNull($machine->actionFor(RideRequest::STATUS_COMPLETED));
    }

    public function test_it_blocks_cancellation_after_a_trip_starts(): void
    {
        $machine = new RideTripStateMachine;

        self::assertTrue($machine->canCancel(RideRequest::STATUS_ARRIVED));
        self::assertFalse($machine->canCancel(RideRequest::STATUS_IN_PROGRESS));
        self::assertFalse($machine->canCancel(RideRequest::STATUS_COMPLETED));
    }
}
