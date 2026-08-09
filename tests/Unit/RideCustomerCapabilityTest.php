<?php

namespace Tests\Unit;

use App\Models\RideFare;
use App\Models\RideRequest;
use App\Services\RideCustomerSettingService;
use App\Services\RideFareCalculator;
use App\Services\RideNotificationService;
use App\Services\RidePaymentService;
use ReflectionMethod;
use Tests\TestCase;

class RideCustomerCapabilityTest extends TestCase
{
    public function test_customer_capability_defaults_match_the_advertised_contract(): void
    {
        $definitions = RideCustomerSettingService::DEFINITIONS;

        self::assertTrue($definitions['customer_enabled']['default']);
        self::assertTrue($definitions['customer_rebid_enabled']['default']);
        self::assertTrue($definitions['offer_rejection_enabled']['default']);
        self::assertFalse($definitions['nearby_availability_enabled']['default']);
        self::assertSame(10, $definitions['customer_rebid_cooldown_seconds']['default']);
        self::assertSame(20, $definitions['nearby_marker_limit']['default']);
    }

    public function test_same_route_metrics_produce_category_specific_estimates(): void
    {
        $calculator = new RideFareCalculator;
        $economy = new RideFare(['base_fare' => 50, 'minimum_fare' => 100, 'per_km_charge' => 25, 'per_minute_charge' => 2, 'negotiation_min_percent' => 80, 'negotiation_max_percent' => 150]);
        $business = new RideFare(['base_fare' => 100, 'minimum_fare' => 200, 'per_km_charge' => 40, 'per_minute_charge' => 3, 'negotiation_min_percent' => 80, 'negotiation_max_percent' => 150]);

        $economyEstimate = $calculator->calculate($economy, 9200, 1260);
        $businessEstimate = $calculator->calculate($business, 9200, 1260);

        self::assertSame(322.0, $economyEstimate['suggested_fare']);
        self::assertSame(531.0, $businessEstimate['suggested_fare']);
        self::assertNotSame($economyEstimate['minimum_negotiated_fare'], $businessEstimate['minimum_negotiated_fare']);
    }

    public function test_ride_notification_payload_never_contains_trip_pin(): void
    {
        $ride = new RideRequest;
        $ride->setRawAttributes(['id' => 42, 'request_number' => 'ZQR-42', 'status' => 'arrived']);
        $method = new ReflectionMethod(RideNotificationService::class, 'payload');
        $payload = $method->invoke(new RideNotificationService, $ride, 'Captain arrived', 'Open the Ride screen.');

        self::assertSame('42', $payload['ride_id']);
        self::assertSame('42', $payload['trip_id']);
        self::assertArrayNotHasKey('trip_pin', $payload);
        self::assertStringNotContainsString('pin', strtolower(json_encode($payload, JSON_THROW_ON_ERROR)));
    }

    public function test_new_customer_and_captain_notification_templates_exist(): void
    {
        self::assertSame('eligible_captains', RideNotificationService::DEFINITIONS['customer_offer_updated']['audience']);
        self::assertSame('captain', RideNotificationService::DEFINITIONS['offer_rejected']['audience']);
        self::assertStringContainsString('Open the Ride screen', RideNotificationService::DEFINITIONS['captain_arrived']['body']);
    }

    public function test_assan_pay_uses_the_shared_ride_payment_gateway_contract(): void
    {
        self::assertContains('assan_pay', RidePaymentService::DIGITAL_GATEWAYS);
        self::assertTrue(function_exists('ride_payment_success'));
        self::assertTrue(function_exists('ride_payment_fail'));
    }
}
