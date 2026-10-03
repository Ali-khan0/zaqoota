<?php

namespace App\Http\Controllers;

use App\Models\OnboardingInvoice;
use App\Models\OnboardingInvoicePaymentAttempt;
use App\Services\OpsOnboardingCheckoutService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OnboardingInvoiceCheckoutController extends Controller
{
    public function __construct(private readonly OpsOnboardingCheckoutService $checkoutService) {}

    public function show(Request $request, string $token): View
    {
        $checkoutToken = $this->checkoutService->resolve($token);

        return $this->view($checkoutToken->invoice, $checkoutToken->id, $request->fullUrl());
    }

    public function pay(Request $request, string $token): RedirectResponse
    {
        $checkoutToken = $this->checkoutService->resolve($token);
        $validated = $request->validate(['gateway' => ['required', 'string', 'max:80']]);
        $redirect = $this->checkoutService->startPayment($checkoutToken, $validated['gateway']);

        return redirect()->away($redirect);
    }

    public function result(Request $request, string $token): View
    {
        $checkoutToken = $this->checkoutService->resolve($token, false);
        $checkoutUrl = ! $checkoutToken->revoked_at && $checkoutToken->expires_at->isFuture()
            ? $this->checkoutService->signedUrl($checkoutToken)
            : null;

        return $this->view($checkoutToken->invoice->fresh(['items', 'onboardingApplication']), $checkoutToken->id, $checkoutUrl);
    }

    private function view(OnboardingInvoice $invoice, int $checkoutTokenId, ?string $checkoutUrl): View
    {
        $currency = strtoupper((string) ($invoice->onboardingApplication?->currency ?: 'PKR'));
        $latestAttempt = OnboardingInvoicePaymentAttempt::query()
            ->where('checkout_token_id', $checkoutTokenId)
            ->latest('id')
            ->first();

        return view('onboarding-invoice.checkout', [
            'invoice' => $invoice,
            'currency' => $currency,
            'gateways' => $this->checkoutService->gateways($currency),
            'latestAttempt' => $latestAttempt,
            'checkoutUrl' => $checkoutUrl,
        ]);
    }
}
