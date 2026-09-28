<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Services\CommerceOrderDispatchService;
use App\Services\CommerceOrderEligibilityService;
use PHPUnit\Framework\TestCase;

class CommerceOrderDispatchSettingsTest extends TestCase
{
    public function test_standard_and_parcel_orders_use_separate_pickup_radii(): void
    {
        $service = new class(new CommerceOrderEligibilityService) extends CommerceOrderDispatchService
        {
            protected function setting(string $key): mixed
            {
                return [
                    'commerce_dispatch_maximum_pickup_radius_km' => 4.5,
                    'parcel_dispatch_maximum_pickup_radius_km' => 12,
                ][$key] ?? null;
            }
        };

        self::assertSame(4500, $service->maximumPickupRadiusMeters(
            (new Order)->forceFill(['order_type' => 'delivery'])
        ));
        self::assertSame(12000, $service->maximumPickupRadiusMeters(
            (new Order)->forceFill(['order_type' => 'parcel'])
        ));
    }
}
