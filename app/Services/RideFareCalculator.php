<?php

namespace App\Services;

use App\Models\RideFare;

class RideFareCalculator
{
    public function calculate(RideFare $fare, int $distanceMeters, int $durationSeconds): array
    {
        $base = $this->toCents($fare->base_fare);
        $distance = (int) round(($distanceMeters / 1000) * $this->toCents($fare->per_km_charge));
        $duration = (int) round(($durationSeconds / 60) * $this->toCents($fare->per_minute_charge));
        $calculated = max($this->toCents($fare->minimum_fare), $base + $distance + $duration);
        $minimum = (int) round($calculated * ((float) $fare->negotiation_min_percent / 100));
        $maximum = (int) round($calculated * ((float) $fare->negotiation_max_percent / 100));

        return [
            'base_fare' => $this->fromCents($base),
            'distance_charge' => $this->fromCents($distance),
            'duration_charge' => $this->fromCents($duration),
            'suggested_fare' => $this->fromCents($calculated),
            'minimum_negotiated_fare' => $this->fromCents($minimum),
            'maximum_negotiated_fare' => $this->fromCents($maximum),
        ];
    }

    public function settlement(float $finalAcceptedFare, float $commissionPercent): array
    {
        $fareCents = $this->toCents($finalAcceptedFare);
        $commissionCents = (int) round($fareCents * ($commissionPercent / 100));

        return [
            'final_accepted_fare' => $this->fromCents($fareCents),
            'platform_commission_amount' => $this->fromCents($commissionCents),
            'rider_earning_amount' => $this->fromCents($fareCents - $commissionCents),
        ];
    }

    public function waitingCharge(int $waitedSeconds, int $freeMinutes, float $chargePerMinute): array
    {
        $chargeableSeconds = max(0, $waitedSeconds - ($freeMinutes * 60));
        $chargedMinutes = $chargeableSeconds > 0 ? (int) ceil($chargeableSeconds / 60) : 0;

        return [
            'charged_waiting_minutes' => $chargedMinutes,
            'waiting_charge_amount' => $this->fromCents($chargedMinutes * $this->toCents($chargePerMinute)),
        ];
    }

    private function toCents(float|int|string $amount): int
    {
        return (int) round(((float) $amount) * 100);
    }

    private function fromCents(int $amount): float
    {
        return round($amount / 100, 2);
    }
}
