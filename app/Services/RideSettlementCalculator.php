<?php

namespace App\Services;

use App\Models\RideRequest;

class RideSettlementCalculator
{
    public function calculate(RideRequest $ride): array
    {
        if ($ride->status === RideRequest::STATUS_CANCELLED) {
            $charge = $this->money($ride->cancellation_charge_amount);

            return [
                'final_payable_amount' => $charge,
                'platform_commission_amount' => 0.0,
                'captain_total_earning_amount' => $charge,
            ];
        }

        $acceptedFare = $this->money($ride->final_accepted_fare);
        $waiting = $this->money($ride->waiting_charge_amount);
        $couponDiscount = $this->money($ride->coupon_discount_amount);
        $commission = $this->money($ride->platform_commission_amount);

        return [
            'final_payable_amount' => $this->money(max(0, $acceptedFare + $waiting - $couponDiscount)),
            'platform_commission_amount' => $commission,
            'captain_total_earning_amount' => $this->money(($acceptedFare - $commission) + $waiting),
        ];
    }

    public function paymentSplit(float $payable, float $walletBalance, bool $useWallet): array
    {
        $payableCents = max(0, (int) round($payable * 100));
        $walletCents = $useWallet ? min($payableCents, max(0, (int) round($walletBalance * 100))) : 0;

        return [
            'wallet_amount' => $walletCents / 100.0,
            'remaining_amount' => ($payableCents - $walletCents) / 100.0,
        ];
    }

    private function money(float|int|string|null $amount): float
    {
        return round((float) $amount, 2);
    }
}
