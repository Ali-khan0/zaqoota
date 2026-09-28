<?php

namespace Tests\Unit;

use App\Models\DeliveryMan;
use App\Models\RideVehicle;
use App\Services\CommerceOrderEligibilityService;
use Tests\TestCase;

class CommerceOrderEligibilityServiceTest extends TestCase
{
    public function test_only_online_delivery_mode_captains_with_capacity_can_receive_commerce_orders(): void
    {
        config(['dm_maximum_orders' => 2]);
        $service = new CommerceOrderEligibilityService;

        self::assertTrue($service->canReceiveCommerceOrders($this->captain([
            'active' => 1,
            'work_mode' => 'delivery',
            'current_orders' => 1,
        ], hasActiveBike: true)));

        foreach ([
            ['active' => 0, 'work_mode' => 'delivery', 'current_orders' => 0],
            ['active' => 1, 'work_mode' => 'ride', 'current_orders' => 0],
            ['active' => 1, 'work_mode' => 'delivery', 'current_orders' => 2],
            ['active' => 1, 'work_mode' => 'delivery', 'current_orders' => 0],
        ] as $attributes) {
            self::assertFalse($service->canReceiveCommerceOrders($this->captain($attributes)));
        }
    }

    private function captain(array $attributes, bool $hasActiveBike = false): DeliveryMan
    {
        $captain = (new DeliveryMan)->forceFill($attributes);
        $captain->setRelation('activeCommerceVehicle', $hasActiveBike ? new RideVehicle : null);

        return $captain;
    }
}
