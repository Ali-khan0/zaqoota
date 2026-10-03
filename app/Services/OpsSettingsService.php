<?php

namespace App\Services;

use App\Models\BusinessSetting;

class OpsSettingsService
{
    public const FIELDS = [
        'due_days' => 'validation.invoice_due_days',
        'menu_photos' => 'media.maximum_menu_photos',
        'photo_size_kb' => 'media.maximum_size_kb',
        'reminder_minutes' => 'reminder_cooldown_minutes',
        'minimum_withdrawal' => 'finance.minimum_withdrawal_amount',
        'release_policy' => 'finance.release_policy',
        'services' => 'onboarding_services',
    ];

    public function saved(): array
    {
        return json_decode(BusinessSetting::where('key', 'ops_admin_settings')->value('value') ?? '{}', true) ?: [];
    }

    public function apply(): void
    {
        $saved = $this->saved();
        foreach (self::FIELDS as $key => $path) {
            if (array_key_exists($key, $saved)) {
                config(['ops.'.$path => $saved[$key]]);
            }
        }
    }

    public function lifecycle(): array
    {
        $saved = $this->saved();

        return [
            'maintenance_enabled' => (bool) ($saved['maintenance'] ?? false),
            'maintenance_message' => $saved['maintenance_message'] ?? null,
            'minimum_version_android' => $saved['android_version'] ?? '0.0.0',
            'minimum_version_ios' => $saved['ios_version'] ?? '0.0.0',
            'update_url_android' => $saved['android_url'] ?? null,
            'update_url_ios' => $saved['ios_url'] ?? null,
            'notification_token_enabled' => true,
        ];
    }
}
