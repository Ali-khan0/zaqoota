<?php

namespace App\Services;

use App\Models\BusinessSetting;
use App\Models\RideRequest;
use App\Models\User;

class RideCancellationPolicyService
{
    public const DEFINITIONS = [
        'cancellation_charge_enabled' => ['key' => 'ride_hailing_cancellation_charge_enabled', 'default' => false],
        'cancellation_charge_amount' => ['key' => 'ride_hailing_cancellation_charge_amount', 'default' => 0.0],
        'cancellation_progress_enabled' => ['key' => 'ride_hailing_cancellation_progress_enabled', 'default' => true],
        'cancellation_progress_threshold_percent' => ['key' => 'ride_hailing_cancellation_progress_threshold_percent', 'default' => 30],
        'cancellation_strike_limit' => ['key' => 'ride_hailing_cancellation_strike_limit', 'default' => 2],
        'cancellation_strike_window_hours' => ['key' => 'ride_hailing_cancellation_strike_window_hours', 'default' => 24],
        'cancellation_temporary_block_enabled' => ['key' => 'ride_hailing_cancellation_temporary_block_enabled', 'default' => true],
        'cancellation_cooldown_minutes' => ['key' => 'ride_hailing_cancellation_cooldown_minutes', 'default' => 60],
    ];

    private ?array $cached = null;

    public function settings(): array
    {
        if ($this->cached !== null) {
            return $this->cached;
        }
        $stored = BusinessSetting::query()
            ->whereIn('key', array_column(self::DEFINITIONS, 'key'))
            ->pluck('value', 'key');

        return $this->cached = collect(self::DEFINITIONS)->mapWithKeys(function (array $definition, string $name) use ($stored) {
            $value = $stored->get($definition['key'], $definition['default']);

            $castValue = match (true) {
                is_bool($definition['default']) => (bool) ((int) $value),
                is_float($definition['default']) => (float) $value,
                default => (int) $value,
            };

            return [$name => $castValue];
        })->all();
    }

    public function quoteChargeAmount(): float
    {
        return round(max(0, (float) $this->settings()['cancellation_charge_amount']), 2);
    }

    public function chargeDecision(RideRequest $ride, string $actorType): array
    {
        $settings = $this->settings();
        $progress = $ride->status === RideRequest::STATUS_ARRIVED
            ? 100.0
            : ($ride->captain_pickup_progress_percent === null ? null : (float) $ride->captain_pickup_progress_percent);
        $eligibleStatus = in_array($ride->status, [
            RideRequest::STATUS_RIDER_SELECTED,
            RideRequest::STATUS_CAPTAIN_ARRIVING,
            RideRequest::STATUS_ARRIVED,
        ], true);
        $progressReached = ! $settings['cancellation_progress_enabled']
            || ($progress !== null && $progress >= $settings['cancellation_progress_threshold_percent']);
        $applies = $actorType === 'customer'
            && $settings['cancellation_charge_enabled']
            && $eligibleStatus
            && $progressReached
            && (float) $ride->cancellation_charge > 0;

        return [
            'amount' => $applies ? round((float) $ride->cancellation_charge, 2) : 0.0,
            'progress_percent' => $progress,
            'rule' => $actorType !== 'customer' ? 'actor_not_chargeable'
                : (! $settings['cancellation_charge_enabled'] ? 'disabled'
                    : (! $eligibleStatus ? 'status_not_eligible'
                        : (! $progressReached ? 'pickup_progress_below_threshold'
                            : ((float) $ride->cancellation_charge <= 0 ? 'amount_not_configured' : 'pickup_progress_threshold_met')))),
        ];
    }

    public function registerChargedCancellation(int $userId): array
    {
        $settings = $this->settings();
        $user = User::query()->withoutGlobalScopes()->whereKey($userId)->lockForUpdate()->firstOrFail();
        $lastStrike = $user->ride_cancellation_last_strike_at;
        $strikes = (int) $user->ride_cancellation_strikes;
        if (! $lastStrike || $lastStrike->lt(now()->subHours($settings['cancellation_strike_window_hours']))) {
            $strikes = 0;
        }
        $strikes++;
        $blockedUntil = $user->ride_booking_blocked_until;
        if ($settings['cancellation_temporary_block_enabled'] && $strikes >= $settings['cancellation_strike_limit']) {
            $blockedUntil = now()->addMinutes($settings['cancellation_cooldown_minutes']);
            $strikes = 0;
        }
        $user->forceFill([
            'ride_cancellation_strikes' => $strikes,
            'ride_cancellation_last_strike_at' => now(),
            'ride_booking_blocked_until' => $blockedUntil,
        ])->save();

        return $this->blockData($user->fresh());
    }

    public function blockData(User $user): array
    {
        $until = $user->ride_booking_blocked_until;
        $active = $until !== null && $until->isFuture();

        return [
            'booking_blocked' => $active,
            'blocked_until' => $active ? $until->toIso8601String() : null,
            'cooldown_seconds' => $active ? max(1, now()->diffInSeconds($until)) : 0,
        ];
    }
}
