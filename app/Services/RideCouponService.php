<?php

namespace App\Services;

use App\Models\RideCoupon;
use App\Models\RideCouponUsage;
use App\Models\RideRequest;
use RuntimeException;

class RideCouponService
{
    public function validateCode(string $code, int $userId, int $zoneId, int $categoryId, float $fare, ?int $ignoreRideId = null): array
    {
        $coupon = RideCoupon::query()->whereRaw('UPPER(code) = ?', [strtoupper(trim($code))])->first();
        if (! $coupon) {
            throw new RuntimeException('The Ride coupon code is invalid.');
        }
        $this->assertEligible($coupon, $userId, $zoneId, $categoryId, $fare, $ignoreRideId);

        return ['coupon' => $coupon, 'discount_amount' => $this->discountAmount($coupon, $fare)];
    }

    public function reserve(RideRequest $ride, float $acceptedFare): array
    {
        if (! $ride->ride_coupon_id) {
            return ['coupon_discount_amount' => 0.0, 'admin_coupon_expense_amount' => 0.0, 'coupon_payment_methods' => null];
        }

        $coupon = RideCoupon::query()->whereKey($ride->ride_coupon_id)->lockForUpdate()->first();
        if (! $coupon) {
            throw new RuntimeException('The selected Ride coupon is no longer available.');
        }
        $this->assertEligible($coupon, $ride->user_id, $ride->zone_id, $ride->ride_category_id, $acceptedFare, $ride->id);
        $discount = $this->discountAmount($coupon, $acceptedFare);

        RideCouponUsage::query()->updateOrCreate(
            ['ride_request_id' => $ride->id],
            [
                'ride_coupon_id' => $coupon->id,
                'user_id' => $ride->user_id,
                'discount_amount' => $discount,
                'status' => RideCouponUsage::STATUS_RESERVED,
                'reserved_at' => now(),
                'redeemed_at' => null,
                'released_at' => null,
            ]
        );

        return [
            'coupon_discount_amount' => $discount,
            'admin_coupon_expense_amount' => $discount,
            'coupon_payment_methods' => $coupon->payment_methods ?: ['all'],
        ];
    }

    public function redeem(RideRequest $ride): void
    {
        RideCouponUsage::query()->where('ride_request_id', $ride->id)
            ->where('status', RideCouponUsage::STATUS_RESERVED)
            ->update(['status' => RideCouponUsage::STATUS_REDEEMED, 'redeemed_at' => now()]);
    }

    public function release(RideRequest $ride): void
    {
        RideCouponUsage::query()->where('ride_request_id', $ride->id)
            ->where('status', RideCouponUsage::STATUS_RESERVED)
            ->update(['status' => RideCouponUsage::STATUS_RELEASED, 'released_at' => now()]);
    }

    public function assertPaymentMethod(RideRequest $ride, string $method, bool $usesWallet): void
    {
        if (! $ride->ride_coupon_id || $ride->coupon_discount_amount <= 0) {
            return;
        }
        $allowed = $ride->coupon_payment_methods;
        if (! $allowed || in_array('all', $allowed, true)) {
            return;
        }
        $required = $usesWallet && $method !== 'wallet' ? ['wallet', $method] : [$method];
        if (array_diff($required, $allowed)) {
            throw new RuntimeException('This Ride coupon is not valid for the selected payment method.');
        }
    }

    private function assertEligible(RideCoupon $coupon, int $userId, int $zoneId, int $categoryId, float $fare, ?int $ignoreRideId): void
    {
        if (! $coupon->status || now()->lt($coupon->starts_at) || now()->gt($coupon->expires_at)) {
            throw new RuntimeException('This Ride coupon is inactive or expired.');
        }
        if ($fare < $coupon->min_fare) {
            throw new RuntimeException('The accepted Ride fare does not meet this coupon minimum.');
        }
        if ($coupon->zone_ids && ! in_array($zoneId, array_map('intval', $coupon->zone_ids), true)) {
            throw new RuntimeException('This Ride coupon is not available in the pickup zone.');
        }
        if ($coupon->ride_category_ids && ! in_array($categoryId, array_map('intval', $coupon->ride_category_ids), true)) {
            throw new RuntimeException('This Ride coupon is not available for the selected Ride category.');
        }

        $activeUsage = RideCouponUsage::query()->where('ride_coupon_id', $coupon->id)
            ->whereIn('status', [RideCouponUsage::STATUS_RESERVED, RideCouponUsage::STATUS_REDEEMED])
            ->when($ignoreRideId, fn ($query) => $query->where('ride_request_id', '!=', $ignoreRideId));
        if ($coupon->total_limit && (clone $activeUsage)->count() >= $coupon->total_limit) {
            throw new RuntimeException('This Ride coupon usage limit has been reached.');
        }
        if ((clone $activeUsage)->where('user_id', $userId)->count() >= $coupon->per_user_limit) {
            throw new RuntimeException('You have already used this Ride coupon.');
        }
        if ($coupon->first_ride_only && RideRequest::query()->where('user_id', $userId)
            ->when($ignoreRideId, fn ($query) => $query->whereKeyNot($ignoreRideId))
            ->whereNotIn('status', [RideRequest::STATUS_CANCELLED, RideRequest::STATUS_SEARCHING, RideRequest::STATUS_NEGOTIATING])
            ->exists()) {
            throw new RuntimeException('This coupon is available only for the first Ride.');
        }
    }

    public function discountAmount(RideCoupon $coupon, float $fare): float
    {
        $discount = $coupon->discount_type === 'percent'
            ? round($fare * ($coupon->discount / 100), 2)
            : round($coupon->discount, 2);
        if ($coupon->discount_type === 'percent' && $coupon->max_discount > 0) {
            $discount = min($discount, $coupon->max_discount);
        }

        return round(min($fare, max(0, $discount)), 2);
    }
}
