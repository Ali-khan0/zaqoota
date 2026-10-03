<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessSetting;
use App\Services\OpsManagerAuditService;
use App\Services\OpsSettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OpsSettingsController extends Controller
{
    public function index(OpsSettingsService $service)
    {
        $settings = $service->saved();
        foreach (OpsSettingsService::FIELDS as $key => $path) {
            $settings[$key] ??= config('ops.'.$path);
        }
        $mail = BusinessSetting::where('key', 'like', 'onboarding_invoice_email_%')->pluck('value', 'key');

        return view('admin-views.ops-settings.index', compact('settings', 'mail'));
    }

    public function update(Request $request)
    {
        $request->validate(['services' => ['required', 'array', 'max:25'], 'services.*' => ['array']]);
        $services = array_values(array_filter($request->input('services', []), fn ($row) => is_array($row) && filled($row['id'] ?? null)));
        $request->merge(['services' => $services]);
        $rules = [
            'due_days' => ['required', 'integer', 'between:1,365'],
            'menu_photos' => ['required', 'integer', 'between:1,8'],
            'photo_size_kb' => ['required', 'integer', 'between:100,2048'],
            'reminder_minutes' => ['required', 'integer', 'between:1,10080'],
            'minimum_withdrawal' => ['required', 'numeric', 'between:1,1000000'],
            'release_policy' => ['required', Rule::in(['approved', 'paid'])],
            'maintenance' => ['required', 'boolean'],
            'maintenance_message' => ['nullable', 'string', 'max:500'],
            'services' => ['required', 'array', 'min:1', 'max:25'],
            'services.*.id' => ['required', 'regex:/^[a-z0-9-]+$/', 'max:100', 'distinct'],
            'services.*.description' => ['required', 'string', 'max:200'],
            'services.*.default_unit_price' => ['required', 'integer', 'between:0,10000000'],
            'services.*.default_selected' => ['required', 'boolean'],
        ];
        foreach (['android', 'ios'] as $platform) {
            $rules[$platform.'_version'] = ['required', 'regex:/^\d+\.\d+\.\d+$/', 'max:30'];
            $rules[$platform.'_url'] = ['nullable', 'url:https', 'max:500'];
        }
        foreach (['invoice', 'reminder', 'paid'] as $type) {
            foreach (['subject', 'heading', 'body'] as $part) {
                $rules["mail.$type.$part"] = ['required', 'string', 'max:'.($part === 'body' ? 4000 : 200)];
            }
        }
        $data = $request->validate($rules);
        foreach (['android', 'ios'] as $platform) {
            if ($data[$platform.'_version'] !== '0.0.0' && empty($data[$platform.'_url'])) {
                throw \Illuminate\Validation\ValidationException::withMessages([$platform.'_url' => 'An update URL is required when enforcing a minimum version.']);
            }
        }
        DB::transaction(function () use ($data): void {
            $settings = $data;
            unset($settings['mail']);
            foreach ($settings['services'] as &$row) {
                $row['default_selected'] = (bool) $row['default_selected'];
                $row['default_unit_price'] = (int) $row['default_unit_price'];
            }
            unset($row);
            BusinessSetting::updateOrCreate(['key' => 'ops_admin_settings'], ['value' => json_encode($settings)]);
            foreach ($data['mail'] as $type => $parts) {
                foreach ($parts as $part => $value) {
                    BusinessSetting::updateOrCreate(['key' => "onboarding_invoice_email_{$type}_{$part}"], ['value' => $value]);
                }
            }
            app(OpsManagerAuditService::class)->record('ops_settings_updated', metadata: ['settings' => $settings, 'email_types' => array_keys($data['mail'])]);
        });

        return back()->with('success', 'Ops settings saved.');
    }
}
