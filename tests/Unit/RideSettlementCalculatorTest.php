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
            'coupon_discount_amount' => 100,
            'carried_cancellation_due_amount' => 0,
        ], true);

        self::assertSame([
            'final_payable_amount' => 420.0,
            'platform_commission_amount' => 75.0,
            'captain_total_earning_amount' => 445.0,
        ], (new RideSettlementCalculator)->calculate($ride));
    }

    public function test_previous_cancellation_due_is_added_to_customer_payable_but_not_captain_earning_or_commission(): void
    {
        $ride = (new RideRequest)->setRawAttributes([
            'status' => RideRequest::STATUS_COMPLETED,
            'final_accepted_fare' => 500,
            'waiting_charge_amount' => 20,
            'platform_commission_amount' => 75,
            'coupon_discount_amount' => 100,
            'carried_cancellation_due_amount' => 80,
        ], true);

        self::assertSame([
            'final_payable_amount' => 500.0,
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

    public function test_wallet_can_cover_part_of_a_ride_payment(): void
    {
        self::assertSame([
            'wallet_amount' => 125.25,
            'remaining_amount' => 374.75,
        ], (new RideSettlementCalculator)->paymentSplit(500, 125.25, true));
    }

    public function test_wallet_payment_never_exceeds_the_payable_amount(): void
    {
        self::assertSame([
            'wallet_amount' => 500.0,
            'remaining_amount' => 0.0,
        ], (new RideSettlementCalculator)->paymentSplit(500, 800, true));
    }
}
