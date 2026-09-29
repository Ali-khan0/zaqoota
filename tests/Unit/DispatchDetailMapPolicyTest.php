<?php

namespace Tests\Unit;

use App\Http\Controllers\Admin\DispatchRealtimeController;
use App\Services\DispatchRiderLocationService;
use ReflectionMethod;
use Tests\TestCase;

class DispatchDetailMapPolicyTest extends TestCase
{
    public function test_single_rider_snapshot_is_zone_scoped(): void
    {
        $source = $this->methodBody(DispatchRiderLocationService::class, 'rider');

        self::assertStringContainsString("where('zone_id', \$zoneId)", $source);
        self::assertStringContainsString('find($deliveryManId)', $source);
    }

    public function test_rider_snapshot_endpoint_requires_dispatch_permission(): void
    {
        $source = $this->methodBody(DispatchRealtimeController::class, 'rider');

        self::assertStringContainsString('canViewDispatch()', $source);
        self::assertStringContainsString('adminZoneId()', $source);
    }

    public function test_commerce_detail_maps_keep_one_map_and_move_one_captain_marker(): void
    {
        foreach (['order-view.blade.php', 'parcel-order-view.blade.php'] as $view) {
            $source = file_get_contents(resource_path('views/admin-views/order/'.$view));
            self::assertStringContainsString('if (orderLocationMap)', $source);
            self::assertStringContainsString('orderCaptainMarker.position = position', $source);
            self::assertStringContainsString('handleCommerceOrderCaptainLocation', $source);
            self::assertStringContainsString('rider-location-client', $source);
        }
    }

    public function test_ride_detail_has_embedded_route_and_live_captain_map(): void
    {
        $source = file_get_contents(resource_path('views/admin-views/ride-hailing/rides/show.blade.php'));

        self::assertStringContainsString('id="ride-admin-map"', $source);
        self::assertStringContainsString('google.maps.geometry.encoding.decodePath', $source);
        self::assertStringContainsString('handleRideAdminCaptainLocation', $source);
        self::assertStringContainsString('ride-captain-external-map', $source);
    }

    private function methodBody(string $class, string $method): string
    {
        $reflection = new ReflectionMethod($class, $method);
        $source = file($reflection->getFileName());

        return implode('', array_slice(
            $source,
            $reflection->getStartLine() - 1,
            $reflection->getEndLine() - $reflection->getStartLine() + 1,
        ));
    }
}
