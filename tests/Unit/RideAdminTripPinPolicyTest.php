<?php

namespace Tests\Unit;

use App\Http\Controllers\Admin\RideHailing\RideOperationController;
use App\Models\RideRequest;
use ReflectionClass;
use ReflectionMethod;
use Tests\TestCase;

class RideAdminTripPinPolicyTest extends TestCase
{
    public function test_pin_is_visible_only_for_assigned_pre_start_statuses(): void
    {
        foreach ([
            RideRequest::STATUS_RIDER_SELECTED,
            RideRequest::STATUS_CAPTAIN_ARRIVING,
            RideRequest::STATUS_ARRIVED,
        ] as $status) {
            self::assertSame('4821', $this->visiblePin($this->ride($status)));
        }

        foreach ([
            RideRequest::STATUS_SEARCHING,
            RideRequest::STATUS_NEGOTIATING,
            RideRequest::STATUS_IN_PROGRESS,
            RideRequest::STATUS_COMPLETED,
            RideRequest::STATUS_CANCELLED,
        ] as $status) {
            self::assertNull($this->visiblePin($this->ride($status)));
        }
    }

    public function test_pin_is_hidden_without_assignment_after_start_or_when_malformed(): void
    {
        $unassigned = $this->ride(RideRequest::STATUS_RIDER_SELECTED, deliveryManId: null);
        $started = $this->ride(RideRequest::STATUS_ARRIVED, started: true);
        $malformed = $this->ride(RideRequest::STATUS_RIDER_SELECTED, pin: '12345');

        self::assertNull($this->visiblePin($unassigned));
        self::assertNull($this->visiblePin($started));
        self::assertNull($this->visiblePin($malformed));
    }

    public function test_pin_remains_encrypted_at_rest_and_is_not_added_to_lists(): void
    {
        $ride = $this->ride(RideRequest::STATUS_RIDER_SELECTED);

        self::assertNotSame('4821', $ride->getAttributes()['trip_pin']);

        $detailView = file_get_contents(resource_path('views/admin-views/ride-hailing/rides/show.blade.php'));
        $listView = file_get_contents(resource_path('views/admin-views/ride-hailing/rides/index.blade.php'));
        self::assertStringContainsString('{{ $tripPin }}', $detailView);
        self::assertStringNotContainsString('$ride->trip_pin', $detailView);
        self::assertStringNotContainsString('trip_pin', $listView);
        self::assertStringNotContainsString('tripPin', $listView);
    }

    public function test_only_the_authorized_scoped_detail_prepares_the_pin(): void
    {
        $show = $this->methodBody(RideOperationController::class, 'show');
        $routes = file_get_contents(base_path('routes/admin/routes.php'));

        self::assertStringContainsString('$this->scopedQuery()', $show);
        self::assertStringContainsString('$this->tripPinForActiveAdminDetail($ride)', $show);
        self::assertStringContainsString("compact('ride', 'eligibleCaptains', 'cancellationReasons', 'tripPin')", $show);
        self::assertStringContainsString("'middleware' => ['admin', 'current-module','actch:admin_panel']", $routes);
        self::assertStringContainsString("'middleware' => ['module:settings']", $routes);
    }

    private function ride(
        string $status,
        ?int $deliveryManId = 14,
        bool $started = false,
        string $pin = '4821',
    ): RideRequest {
        $ride = new RideRequest;
        $ride->status = $status;
        $ride->delivery_man_id = $deliveryManId;
        $ride->trip_started_at = $started ? now() : null;
        $ride->trip_pin = $pin;

        return $ride;
    }

    private function visiblePin(RideRequest $ride): ?string
    {
        $controller = (new ReflectionClass(RideOperationController::class))->newInstanceWithoutConstructor();
        $method = new ReflectionMethod(RideOperationController::class, 'tripPinForActiveAdminDetail');
        $method->setAccessible(true);

        return $method->invoke($controller, $ride);
    }

    private function methodBody(string $class, string $methodName): string
    {
        $method = new ReflectionMethod($class, $methodName);
        $source = file($method->getFileName());

        return implode('', array_slice(
            $source,
            $method->getStartLine() - 1,
            $method->getEndLine() - $method->getStartLine() + 1,
        ));
    }
}
