<?php

namespace App\Jobs;

use App\Models\OnboardingInvoice;
use App\Queue\Middleware\EnsureQueueProcessEnabled;
use App\Services\OnboardingInvoiceDeliveryService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class SendOpsOnboardingPaymentConfirmation implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;

    public int $timeout = 180;

    public int $uniqueFor = 86400;

    public function __construct(public int $invoiceId)
    {
        $this->afterCommit();
    }

    public function handle(OnboardingInvoiceDeliveryService $deliveryService): void
    {
        $invoice = OnboardingInvoice::query()
            ->with(['items', 'onboardingApplication', 'paymentVerifier'])
            ->find($this->invoiceId);
        if (! $invoice || $invoice->payment_status !== OnboardingInvoice::PAYMENT_PAID) {
            return;
        }
        $application = $invoice->onboardingApplication;
        $actor = $invoice->paymentVerifier;
        $result = $deliveryService->send(
            invoice: $invoice,
            deliveryType: 'paid',
            actorAdminId: $invoice->paid_by,
            actorName: trim(($actor?->f_name ?? '').' '.($actor?->l_name ?? '')) ?: $actor?->email,
            idempotencyKey: 'ops-payment-confirmation:'.$invoice->id,
        );
        if ($result['failed'] > 0 || ($result['sent'] + $result['skipped']) < 1) {
            throw new \RuntimeException($result['error'] ?: 'The payment confirmation could not be delivered.');
        }
    }

    public function middleware(): array
    {
        return [new EnsureQueueProcessEnabled('ops_onboarding_payment_email')];
    }

    public function backoff(): array
    {
        return [60, 300, 900, 3600];
    }

    public function uniqueId(): string
    {
        return 'ops-payment-confirmation:'.$this->invoiceId;
    }

    public function failed(?Throwable $exception): void
    {
        OnboardingInvoice::query()->find($this->invoiceId)?->events()->create([
            'event_type' => 'payment_email_failed',
            'description' => 'Payment confirmation email exhausted all queued delivery attempts.',
            'metadata' => ['error' => mb_substr($exception?->getMessage() ?? 'Unknown queue failure.', 0, 2000)],
        ]);
    }

    public function skipped(): void
    {
        OnboardingInvoice::query()->find($this->invoiceId)?->events()->create([
            'event_type' => 'payment_email_skipped',
            'description' => 'Payment confirmation email is disabled in queue operations.',
            'metadata' => ['reason' => 'queue_process_disabled'],
        ]);
    }
}
