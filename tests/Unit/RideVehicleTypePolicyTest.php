<?php

namespace Tests\Unit;

use App\Models\RideVehicleType;
use PHPUnit\Framework\TestCase;

class RideVehicleTypePolicyTest extends TestCase
{
    public function test_bike_is_the_stable_commerce_delivery_vehicle_type(): void
    {
        self::assertSame('bike', RideVehicleType::COMMERCE_DELIVERY_SLUG);
    }
}
