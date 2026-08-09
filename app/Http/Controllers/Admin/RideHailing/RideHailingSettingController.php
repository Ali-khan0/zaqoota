<?php

namespace App\Http\Controllers\Admin\RideHailing;

use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use App\Models\RideSettingAudit;
use App\Services\RideCustomerSettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RideHailingSettingController extends Controller
{
    private const KEYS = [
        'service_name' => 'ride_hailing_service_name',
        'distance_unit' => 'ride_hailing_distance_unit',
        'support_email' => 'ride_hailing_support_email',
        'support_phone' => 'ride_hailing_support_phone',
        'maximum_pickup_radius_km' => 'ride_hailing_maximum_pickup_radius_km',
        'pickup_eta_speed_kmh' => 'ride_hailing_pickup_eta_speed_kmh',
        'customer_enabled' => 'ride_hailing_customer_enabled',
        'customer_rebid_enabled' => 'ride_hailing_customer_rebid_enabled',
        'offer_rejection_enabled' => 'ride_hailing_customer_offer_rejection_enabled',
        'customer_rebid_cooldown_seconds' => 'ride_hailing_customer_rebid_cooldown_seconds',
        'nearby_availability_enabled' => 'ride_hailing_nearby_availability_enabled',
        'nearby_marker_precision' => 'ride_hailing_nearby_marker_precision',
        'nearby_marker_limit' => 'ride_hailing_nearby_marker_limit',
        'nearby_refresh_seconds' => 'ride_hailing_nearby_refresh_seconds',
    ];

    public function index(): View
    {
        $stored = BusinessSetting::query()
            ->whereIn('key', array_values(self::KEYS))
            ->pluck('value', 'key');

        $settings = [
            'service_name' => $stored->get(self::KEYS['service_name'], 'Zaqoota Ride'),
            'distance_unit' => $stored->get(self::KEYS['distance_unit'], 'km'),
            'support_email' => $stored->get(self::KEYS['support_email']),
            'support_phone' => $stored->get(self::KEYS['support_phone']),
            'maximum_pickup_radius_km' => $stored->get(self::KEYS['maximum_pickup_radius_km'], 25),
            'pickup_eta_speed_kmh' => $stored->get(self::KEYS['pickup_eta_speed_kmh'], 25),
            ...(app(RideCustomerSettingService::class)->all()),
        ];

        $settingAudits = RideSettingAudit::query()->latest('id')->limit(20)->get();

        return view('admin-views.ride-hailing.settings', compact('settings', 'settingAudits'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'service_name' => ['required', 'string', 'max:100'],
            'distance_unit' => ['required', 'in:km,mile'],
            'support_email' => ['nullable', 'email', 'max:191'],
            'support_phone' => ['nullable', 'string', 'max:30'],
            'maximum_pickup_radius_km' => ['required', 'numeric', 'min:1', 'max:200'],
            'pickup_eta_speed_kmh' => ['required', 'numeric', 'min:5', 'max:120'],
            'customer_enabled' => ['nullable', 'boolean'],
            'customer_rebid_enabled' => ['nullable', 'boolean'],
            'offer_rejection_enabled' => ['nullable', 'boolean'],
            'customer_rebid_cooldown_seconds' => ['required', 'integer', 'min:5', 'max:300'],
            'nearby_availability_enabled' => ['nullable', 'boolean'],
            'nearby_marker_precision' => ['required', 'integer', 'min:1', 'max:3'],
            'nearby_marker_limit' => ['required', 'integer', 'min:0', 'max:20'],
            'nearby_refresh_seconds' => ['required', 'integer', 'min:10', 'max:300'],
        ]);

        foreach (['customer_enabled', 'customer_rebid_enabled', 'offer_rejection_enabled', 'nearby_availability_enabled'] as $field) {
            $validated[$field] = $request->boolean($field) ? '1' : '0';
        }

        foreach (self::KEYS as $field => $key) {
            $newValue = filled($validated[$field] ?? null) ? trim((string) $validated[$field]) : null;
            $setting = BusinessSetting::query()->firstOrNew(['key' => $key]);
            $oldValue = $setting->exists ? $setting->value : null;
            if ((string) $oldValue === (string) $newValue) {
                continue;
            }
            $setting->value = $newValue;
            $setting->save();
            RideSettingAudit::query()->create([
                'admin_id' => auth('admin')->id(),
                'setting_key' => $key,
                'old_value' => $oldValue,
                'new_value' => $newValue,
                'ip_address' => $request->ip(),
            ]);
        }

        return back()->with('success', translate('messages.Ride hailing setup updated successfully.'));
    }
}
