<?php

namespace Tests\Unit;

use App\Models\RideFare;
use App\Services\RideFareCalculator;
use PHPUnit\Framework\TestCase;

class RideFareCalculatorTest extends TestCase
{
    public function test_it_calculates_suggested_and_negotiation_fares_in_cents(): void
    {
        $fare = new RideFare([
            'base_fare' => 50,
            'minimum_fare' => 100,
            'per_km_charge' => 25,
            'per_minute_charge' => 2,
            'negotiation_min_percent' => 80,
            'negotiation_max_percent' => 150,
        ]);

        $result = (new RideFareCalculator)->calculate($fare, 10000, 1200);

        self::assertSame(340.0, $result['suggested_fare']);
        self::assertSame(272.0, $result['minimum_negotiated_fare']);
        self::assertSame(510.0, $result['maximum_negotiated_fare']);
    }

    public function test_it_applies_the_minimum_fare(): void
    {
        $fare = new RideFare([
            'base_fare' => 20,
            'minimum_fare' => 100,
            'per_km_charge' => 10,
            'per_minute_charge' => 1,
            'negotiation_min_percent' => 100,
            'negotiation_max_percent' => 100,
        ]);

        self::assertSame(100.0, (new RideFareCalculator)->calculate($fare, 1000, 300)['suggested_fare']);
    }

    public function test_commission_uses_the_final_accepted_fare(): void
    {
        $result = (new RideFareCalculator)->settlement(500, 15);

        self::assertSame(500.0, $result['final_accepted_fare']);
        self::assertSame(75.0, $result['platform_commission_amount']);
        self::assertSame(425.0, $result['rider_earning_amount']);
    }

    public function test_it_charges_only_started_waiting_minutes_after_the_free_allowance(): void
    {
        $calculator = new RideFareCalculator;

        self::assertSame(['charged_waiting_minutes' => 0, 'waiting_charge_amount' => 0.0], $calculator->waitingCharge(180, 3, 5));
        self::assertSame(['charged_waiting_minutes' => 1, 'waiting_charge_amount' => 5.0], $calculator->waitingCharge(181, 3, 5));
        self::assertSame(['charged_waiting_minutes' => 3, 'waiting_charge_amount' => 15.0], $calculator->waitingCharge(301, 3, 5));
    }
}
