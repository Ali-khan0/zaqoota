<?php

namespace App\Http\Controllers\Admin\RideHailing;

use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
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
        ];

        return view('admin-views.ride-hailing.settings', compact('settings'));
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
        ]);

        foreach (self::KEYS as $field => $key) {
            BusinessSetting::updateOrCreate(
                ['key' => $key],
                ['value' => filled($validated[$field] ?? null) ? trim($validated[$field]) : null]
            );
        }

        return back()->with('success', translate('messages.Ride hailing setup updated successfully.'));
    }
}
