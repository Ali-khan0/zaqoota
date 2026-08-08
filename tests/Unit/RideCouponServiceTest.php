<?php

namespace Tests\Unit;

use App\Models\RideCoupon;
use App\Services\RideCouponService;
use PHPUnit\Framework\TestCase;

class RideCouponServiceTest extends TestCase
{
    public function test_percentage_discount_respects_its_cap(): void
    {
        $coupon = (new RideCoupon)->setRawAttributes([
            'discount_type' => 'percent',
            'discount' => 20,
            'max_discount' => 150,
        ], true);

        self::assertSame(150.0, (new RideCouponService)->discountAmount($coupon, 1000));
    }

    public function test_fixed_discount_cannot_exceed_the_accepted_fare(): void
    {
        $coupon = (new RideCoupon)->setRawAttributes([
            'discount_type' => 'amount',
            'discount' => 500,
            'max_discount' => 0,
        ], true);

        self::assertSame(300.0, (new RideCouponService)->discountAmount($coupon, 300));
    }
}
