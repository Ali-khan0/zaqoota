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
        $commission = $this->money($ride->platform_commission_amount);

        return [
            'final_payable_amount' => $this->money($acceptedFare + $waiting),
            'platform_commission_amount' => $commission,
            'captain_total_earning_amount' => $this->money(($acceptedFare - $commission) + $waiting),
        ];
    }

    private function money(float|int|string|null $amount): float
    {
        return round((float) $amount, 2);
    }
}
