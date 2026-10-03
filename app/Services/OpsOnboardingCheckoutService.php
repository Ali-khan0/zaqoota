<?php

namespace App\Services;

use App\CentralLogics\Helpers;
use App\Library\Payer;
use App\Library\Payment as PaymentInfo;
use App\Library\Receiver;
use App\Models\Admin;
use App\Models\BusinessSetting;
use App\Models\OnboardingInvoice;
use App\Models\OnboardingInvoiceCheckoutToken;
use App\Models\OnboardingInvoicePaymentAttempt;
use App\Traits\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OpsOnboardingCheckoutService
{
    use Payment;

    public function gateways(string $currency): array
    {
        $currency = strtoupper($currency);

        return collect(Helpers::getActivePaymentGateways())
            ->filter(function (array $gateway) use ($currency): bool {
                $supported = Helpers::getPaymentGatewaySupportedCurrencies($gateway['gateway']);

                return $supported === [] || array_key_exists($currency, $supported);
            })
            ->values()
            ->all();
    }

    public function ensureToken(OnboardingInvoice $invoice, ?Admin $actor = null): ?OnboardingInvoiceCheckoutToken
    {
        if (! $invoice->onboarding_application_id
            || $invoice->voided_at
            || $invoice->payment_status !== OnboardingInvoice::PAYMENT_UNPAID) {
            return null;
        }

        return DB::transaction(function () use ($invoice, $actor): ?OnboardingInvoiceCheckoutToken {
            $invoice = OnboardingInvoice::query()->lockForUpdate()->findOrFail($invoice->id);
            if (! $invoice->onboarding_application_id
                || $invoice->voided_at
                || $invoice->payment_status !== OnboardingInvoice::PAYMENT_UNPAID) {
                return null;
            }
            $existing = OnboardingInvoiceCheckoutToken::query()
                ->where('onboarding_invoice_id', $invoice->id)
                ->whereNull('revoked_at')
                ->where('expires_at', '>', now())
                ->latest('id')
                ->first();
            if ($existing) {
                return $existing;
            }

            OnboardingInvoiceCheckoutToken::query()
                ->where('onboarding_invoice_id', $invoice->id)
                ->whereNull('revoked_at')
                ->update(['revoked_at' => now()]);
            $secret = Str::random(64);
            $token = OnboardingInvoiceCheckoutToken::query()->create([
                'onboarding_invoice_id' => $invoice->id,
                'token_hash' => hash('sha256', $secret),
                'token_secret' => $secret,
                'expires_at' => now()->addDays(max(1, (int) config('ops.checkout.token_lifetime_days', 30))),
                'created_by' => $actor?->id,
            ]);
            $invoice->events()->create([
                'event_type' => 'checkout_link_issued',
                'description' => 'Hosted invoice checkout link issued.',
                'metadata' => ['expires_at' => $token->expires_at->toIso8601String()],
                'admin_id' => $actor?->id,
                'admin_name' => $actor ? (trim($actor->f_name.' '.$actor->l_name) ?: $actor->email) : null,
            ]);

            return $token;
        }, 3);
    }

    public function rotateToken(OnboardingInvoice $invoice, Admin $actor): OnboardingInvoiceCheckoutToken
    {
        return DB::transaction(function () use ($invoice, $actor): OnboardingInvoiceCheckoutToken {
            OnboardingInvoice::query()->lockForUpdate()->findOrFail($invoice->id);
            OnboardingInvoiceCheckoutToken::query()
                ->where('onboarding_invoice_id', $invoice->id)
                ->whereNull('revoked_at')
                ->update(['revoked_at' => now()]);

            return $this->ensureToken($invoice->fresh(), $actor)
                ?? throw ValidationException::withMessages(['invoice' => ['Only an unpaid active Ops invoice can receive a checkout link.']]);
        }, 3);
    }

    public function signedUrl(OnboardingInvoiceCheckoutToken $token): string
    {
        return URL::temporarySignedRoute(
            'onboarding-invoice.checkout',
            $token->expires_at,
            ['token' => $token->token_secret],
        );
    }

    public function urlForInvoice(OnboardingInvoice $invoice, ?Admin $actor = null): ?string
    {
        $token = $this->ensureToken($invoice, $actor);

        return $token ? $this->signedUrl($token) : null;
    }

    public function resolve(string $secret, bool $requireActive = true): OnboardingInvoiceCheckoutToken
    {
        $token = OnboardingInvoiceCheckoutToken::query()
            ->with(['invoice.items', 'invoice.onboardingApplication'])
            ->where('token_hash', hash('sha256', $secret))
            ->firstOrFail();
        if ($requireActive && ($token->revoked_at || $token->expires_at->isPast())) {
            abort(410, 'This invoice checkout link has expired.');
        }
        $token->forceFill(['last_accessed_at' => now()])->saveQuietly();

        return $token;
    }

    public function startPayment(OnboardingInvoiceCheckoutToken $token, string $gateway): string
    {
        return DB::transaction(function () use ($token, $gateway): string {
            $token = OnboardingInvoiceCheckoutToken::query()->lockForUpdate()->findOrFail($token->id);
            $invoice = OnboardingInvoice::query()
                ->with('onboardingApplication')
                ->lockForUpdate()
                ->findOrFail($token->onboarding_invoice_id);
            if ($token->revoked_at || $token->expires_at->isPast()) {
                throw ValidationException::withMessages(['payment' => ['This checkout link has expired.']]);
            }
            if ($invoice->voided_at || $invoice->payment_status !== OnboardingInvoice::PAYMENT_UNPAID) {
                throw ValidationException::withMessages(['payment' => ['This invoice is no longer payable.']]);
            }
            $currency = strtoupper((string) ($invoice->onboardingApplication?->currency ?: 'PKR'));
            $enabled = collect($this->gateways($currency))->firstWhere('gateway', $gateway);
            if (! $enabled) {
                throw ValidationException::withMessages(['gateway' => ['This payment gateway is unavailable for the invoice currency.']]);
            }

            OnboardingInvoicePaymentAttempt::query()
                ->where('onboarding_invoice_id', $invoice->id)
                ->where('status', OnboardingInvoicePaymentAttempt::STATUS_PENDING)
                ->where('expires_at', '<=', now())
                ->update(['status' => OnboardingInvoicePaymentAttempt::STATUS_EXPIRED]);
            $pending = OnboardingInvoicePaymentAttempt::query()
                ->where('onboarding_invoice_id', $invoice->id)
                ->where('status', OnboardingInvoicePaymentAttempt::STATUS_PENDING)
                ->where('expires_at', '>', now())
                ->lockForUpdate()
                ->exists();
            if ($pending) {
                throw ValidationException::withMessages([
                    'payment' => ['A payment is already in progress. Wait for it to finish or expire before retrying.'],
                ]);
            }

            $businessName = (string) (BusinessSetting::where('key', 'business_name')->value('value') ?: 'Zaqoota');
            $payer = new Payer(
                $invoice->store_owner_name ?: $invoice->store_name,
                $invoice->store_email,
                $invoice->onboardingApplication?->owner_phone ?: '',
                $invoice->store_address ?: '',
            );
            $paymentInfo = new PaymentInfo(
                success_hook: 'onboarding_invoice_payment_success',
                failure_hook: 'onboarding_invoice_payment_failed',
                currency_code: $currency,
                payment_method: $gateway,
                payment_platform: 'web',
                payer_id: (string) $invoice->id,
                receiver_id: '100',
                additional_data: [
                    'business_name' => $businessName,
                    'invoice_number' => $invoice->invoice_number,
                ],
                payment_amount: $invoice->amount,
                external_redirect_link: route('onboarding-invoice.checkout.result', ['token' => $token->token_secret]),
                attribute: 'onboarding_invoice',
                attribute_id: $invoice->id,
            );
            $request = self::create_request($payer, $paymentInfo, new Receiver($businessName, ''));
            $redirect = self::gateway_link($request);
            if (! is_string($redirect) || $redirect === '') {
                throw ValidationException::withMessages(['gateway' => ['This payment gateway could not be started.']]);
            }
            OnboardingInvoicePaymentAttempt::query()->create([
                'onboarding_invoice_id' => $invoice->id,
                'checkout_token_id' => $token->id,
                'payment_request_id' => $request->id,
                'gateway' => $gateway,
                'amount' => $invoice->amount,
                'currency' => $currency,
                'status' => OnboardingInvoicePaymentAttempt::STATUS_PENDING,
                'expires_at' => now()->addMinutes(max(5, (int) config('ops.checkout.attempt_lifetime_minutes', 20))),
            ]);
            $invoice->events()->create([
                'event_type' => 'gateway_payment_started',
                'description' => 'Hosted checkout payment started.',
                'metadata' => ['gateway' => $gateway, 'payment_request_id' => $request->id],
            ]);

            return $redirect;
        }, 3);
    }
}
