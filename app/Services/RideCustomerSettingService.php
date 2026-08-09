<?php

namespace App\Services;

use App\Models\BusinessSetting;

class RideCustomerSettingService
{
    public const DEFINITIONS = [
        'customer_enabled' => ['key' => 'ride_hailing_customer_enabled', 'default' => true],
        'customer_rebid_enabled' => ['key' => 'ride_hailing_customer_rebid_enabled', 'default' => true],
        'offer_rejection_enabled' => ['key' => 'ride_hailing_customer_offer_rejection_enabled', 'default' => true],
        'customer_rebid_cooldown_seconds' => ['key' => 'ride_hailing_customer_rebid_cooldown_seconds', 'default' => 10],
        'nearby_availability_enabled' => ['key' => 'ride_hailing_nearby_availability_enabled', 'default' => false],
        'nearby_marker_precision' => ['key' => 'ride_hailing_nearby_marker_precision', 'default' => 2],
        'nearby_marker_limit' => ['key' => 'ride_hailing_nearby_marker_limit', 'default' => 20],
        'nearby_refresh_seconds' => ['key' => 'ride_hailing_nearby_refresh_seconds', 'default' => 20],
    ];

    public function all(): array
    {
        $stored = BusinessSetting::query()->whereIn('key', array_column(self::DEFINITIONS, 'key'))->pluck('value', 'key');

        return collect(self::DEFINITIONS)->mapWithKeys(function (array $definition, string $name) use ($stored) {
            $value = $stored->get($definition['key'], $definition['default']);

            return [$name => is_bool($definition['default']) ? (bool) ((int) $value) : (int) $value];
        })->all();
    }

    public function enabled(string $name): bool
    {
        return (bool) ($this->all()[$name] ?? false);
    }
}
