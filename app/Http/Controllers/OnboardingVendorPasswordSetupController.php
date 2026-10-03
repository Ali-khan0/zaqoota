<?php

namespace App\Http\Controllers;

use App\CentralLogics\Helpers;
use App\Services\OpsOnboardingApprovalService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class OnboardingVendorPasswordSetupController extends Controller
{
    public function __construct(private readonly OpsOnboardingApprovalService $approvalService) {}

    public function show(string $token): View
    {
        $setup = $this->approvalService->resolve($token);

        return view('onboarding-vendor.password-setup', [
            'setup' => $setup,
            'completed' => false,
            'loginUrl' => null,
        ]);
    }

    public function store(Request $request, string $token): View
    {
        $setup = $this->approvalService->resolve($token);
        $validated = $request->validate([
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised(),
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if (str_contains((string) $value, ' ')) {
                        $fail('The password cannot contain spaces.');
                    }
                },
            ],
        ]);
        $vendor = $this->approvalService->complete($setup, $validated['password'], $request->ip());

        return view('onboarding-vendor.password-setup', [
            'setup' => $setup,
            'completed' => true,
            'vendor' => $vendor,
            'loginUrl' => route('login', [Helpers::get_login_url('store_login_url')]),
        ]);
    }
}
