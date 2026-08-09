<?php

namespace App\Http\Controllers\Admin\RideHailing;

use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use App\Services\RideNotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RideNotificationSettingController extends Controller
{
    public function index(): View
    {
        return view('admin-views.ride-hailing.notification-settings', ['templates' => RideNotificationService::templates()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $rules = [];
        foreach (array_keys(RideNotificationService::DEFINITIONS) as $key) {
            $rules["templates.$key.title"] = ['required', 'string', 'max:191'];
            $rules["templates.$key.body"] = ['required', 'string', 'max:1000'];
            $rules["templates.$key.push_enabled"] = ['nullable', 'boolean'];
            $rules["templates.$key.in_app_enabled"] = ['nullable', 'boolean'];
        }
        $validated = $request->validate($rules);
        $templates = [];
        foreach (array_keys(RideNotificationService::DEFINITIONS) as $key) {
            $templates[$key] = [
                'title' => trim($validated['templates'][$key]['title']),
                'body' => trim($validated['templates'][$key]['body']),
                'push_enabled' => $request->boolean("templates.$key.push_enabled"),
                'in_app_enabled' => $request->boolean("templates.$key.in_app_enabled"),
            ];
        }
        BusinessSetting::query()->updateOrCreate(['key' => RideNotificationService::SETTING_KEY], ['value' => json_encode($templates)]);

        return back()->with('success', translate('messages.Ride notification messages updated successfully.'));
    }
}
