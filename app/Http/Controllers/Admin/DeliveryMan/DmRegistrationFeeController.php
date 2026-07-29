<?php

namespace App\Http\Controllers\Admin\DeliveryMan;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Services\DeliveryManRegistrationFeeService;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DmRegistrationFeeController extends Controller
{
    public function index(Request $request): View
    {
        $settings = app(DeliveryManRegistrationFeeService::class)->getSettings();

        return view('admin-views.delivery-man.registration-fee-index', compact('settings'));
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $request->validate([
            'dm_reg_fee_enabled' => 'nullable|in:0,1',
            'dm_reg_total_fee' => 'nullable|numeric|min:0',
            'dm_reg_manual_first_part' => 'nullable|numeric|min:0',
            'dm_reg_wallet_deduction_percent' => 'nullable|numeric|min:0|max:100',
            'dm_reg_deduction_frequency' => 'nullable|in:weekly,monthly',
            'dm_reg_require_initial_on_approve' => 'nullable|in:0,1',
        ]);

        $map = [
            'dm_reg_fee_enabled' => $request->input('dm_reg_fee_enabled', '1'),
            'dm_reg_total_fee' => $request->input('dm_reg_total_fee', '5000'),
            'dm_reg_manual_first_part' => $request->input('dm_reg_manual_first_part', '1500'),
            'dm_reg_wallet_deduction_percent' => $request->input('dm_reg_wallet_deduction_percent', '30'),
            'dm_reg_deduction_frequency' => $request->input('dm_reg_deduction_frequency', 'weekly'),
            'dm_reg_require_initial_on_approve' => $request->input('dm_reg_require_initial_on_approve', '0'),
        ];

        foreach ($map as $key => $value) {
            Helpers::businessUpdateOrInsert(['key' => $key], ['value' => (string) $value]);
        }

        Toastr::success(translate('messages.settings_updated'));

        return back();
    }
}
