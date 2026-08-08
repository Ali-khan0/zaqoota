<?php

namespace Tests\Unit;

use App\Models\RideRequest;
use App\Services\RideSettlementCalculator;
use PHPUnit\Framework\TestCase;

class RideSettlementCalculatorTest extends TestCase
{
    public function test_completed_ride_commission_uses_only_the_accepted_fare(): void
    {
        $ride = (new RideRequest)->setRawAttributes([
            'status' => RideRequest::STATUS_COMPLETED,
            'final_accepted_fare' => 500,
            'waiting_charge_amount' => 20,
            'platform_commission_amount' => 75,
        ], true);

        self::assertSame([
            'final_payable_amount' => 520.0,
            'platform_commission_amount' => 75.0,
            'captain_total_earning_amount' => 445.0,
        ], (new RideSettlementCalculator)->calculate($ride));
    }

    public function test_customer_cancellation_charge_goes_to_the_captain_without_commission(): void
    {
        $ride = (new RideRequest)->setRawAttributes([
            'status' => RideRequest::STATUS_CANCELLED,
            'cancellation_charge_amount' => 100,
            'platform_commission_amount' => 75,
        ], true);

        self::assertSame([
            'final_payable_amount' => 100.0,
            'platform_commission_amount' => 0.0,
            'captain_total_earning_amount' => 100.0,
        ], (new RideSettlementCalculator)->calculate($ride));
    }
}
