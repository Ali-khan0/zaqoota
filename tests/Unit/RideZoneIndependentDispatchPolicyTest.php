<?php

namespace Tests\Unit;

use App\Http\Controllers\Admin\RideHailing\RideOperationController;
use App\Http\Controllers\Api\V1\CaptainRideController;
use App\Http\Controllers\Api\V1\CustomerRideController;
use App\Services\RideCaptainEligibilityService;
use App\Services\RideDispatchService;
use ReflectionMethod;
use Tests\TestCase;

class RideZoneIndependentDispatchPolicyTest extends TestCase
{
    public function test_ride_eligibility_does_not_compare_the_captain_account_zone(): void
    {
        $ranked = $this->methodBody(RideCaptainEligibilityService::class, 'eligibleCaptainsForRide');
        $vehicle = $this->methodBody(RideCaptainEligibilityService::class, 'vehicleFor');

        self::assertStringNotContainsString("where('zone_id'", $ranked);
        self::assertStringNotContainsString('captain->zone_id', $vehicle);
        self::assertStringContainsString('maximumPickupRadiusMeters()', $ranked);
        self::assertStringContainsString('locationFreshnessSeconds()', $ranked);
    }

    public function test_captain_discovery_is_radius_and_wave_scoped_without_a_zone_filter(): void
    {
        $discovery = $this->methodBody(CaptainRideController::class, 'availableRequests');
        $wave = $this->methodBody(RideDispatchService::class, 'captainsVisibleThroughWave');

        self::assertStringNotContainsString("where('zone_id'", $discovery);
        self::assertStringContainsString('maximumPickupRadiusMeters()', $discovery);
        self::assertStringContainsString('visibleWaveFor($captain, $ride)', $discovery);
        self::assertStringContainsString('take(($wave + 1) * $this->waveSize())', $wave);
    }

    public function test_offer_and_assignment_paths_recheck_live_pickup_radius(): void
    {
        foreach ([
            [CaptainRideController::class, 'storeOffer'],
            [CustomerRideController::class, 'acceptOffer'],
            [RideOperationController::class, 'assign'],
        ] as [$class, $method]) {
            $body = $this->methodBody($class, $method);
            self::assertStringContainsString('pickupMetrics(', $body, $class.'::'.$method.' must require fresh Captain GPS.');
            self::assertStringContainsString('maximumPickupRadiusMeters()', $body, $class.'::'.$method.' must enforce the configured radius.');
        }
    }

    public function test_fare_estimate_still_uses_the_pickup_zone_fare(): void
    {
        $estimate = $this->methodBody(CustomerRideController::class, 'estimate');

        self::assertStringContainsString("where('zone_id', \$zone->id)", $estimate);
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
