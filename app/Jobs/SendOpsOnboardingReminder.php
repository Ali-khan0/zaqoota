<?php

namespace App\Jobs;

use App\Models\OnboardingInvoice;
use App\Models\OpsOnboardingReminderRequest;
use App\Queue\Middleware\EnsureQueueProcessEnabled;
use App\Services\OnboardingInvoiceDeliveryService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class SendOpsOnboardingReminder implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;

    public int $timeout = 180;

    public int $uniqueFor = 86400;

    public function __construct(public int $reminderRequestId)
    {
        $this->afterCommit();
    }

    public function handle(OnboardingInvoiceDeliveryService $deliveryService): void
    {
        $request = OpsOnboardingReminderRequest::query()
            ->with(['application.invoice'])
            ->find($this->reminderRequestId);
        if (! $request || $request->status === OpsOnboardingReminderRequest::STATUS_SENT) {
            return;
        }
        $application = $request->application;
        $invoice = $application?->invoice;
        if (! $application || ! $invoice) {
            $request->update([
                'status' => OpsOnboardingReminderRequest::STATUS_FAILED,
                'last_error' => 'The onboarding application or invoice is unavailable.',
            ]);

            return;
        }
        if ($invoice->voided_at || $invoice->payment_status === OnboardingInvoice::PAYMENT_PAID) {
            $request->update([
                'status' => OpsOnboardingReminderRequest::STATUS_CANCELLED,
                'last_error' => null,
            ]);
            $invoice->events()->create([
                'event_type' => 'reminder_cancelled',
                'description' => 'Queued payment reminder was cancelled because the invoice is no longer payable.',
                'metadata' => ['reminder_request_id' => $request->id],
                'admin_id' => $application->onboarding_manager_id,
                'admin_name' => $application->manager_name_snapshot,
            ]);

            return;
        }

        $request->update([
            'status' => OpsOnboardingReminderRequest::STATUS_QUEUED,
            'attempt_count' => $request->attempt_count + 1,
            'last_error' => null,
        ]);
        $result = $deliveryService->send(
            invoice: $invoice,
            deliveryType: 'reminder',
            actorAdminId: $application->onboarding_manager_id,
            actorName: $application->manager_name_snapshot,
            idempotencyKey: 'ops-reminder-request:'.$request->id,
        );
        if ($result['failed'] > 0 || ($result['sent'] + $result['skipped']) < 1) {
            $error = $result['error'] ?: 'The reminder could not be delivered.';
            $request->update(['last_error' => mb_substr($error, 0, 2000)]);
            throw new \RuntimeException($error);
        }

        $request->update([
            'status' => OpsOnboardingReminderRequest::STATUS_SENT,
            'last_error' => null,
            'sent_at' => now(),
        ]);
    }

    public function middleware(): array
    {
        return [new EnsureQueueProcessEnabled('ops_onboarding_reminder')];
    }

    public function backoff(): array
    {
        return [60, 300, 900, 3600];
    }

    public function uniqueId(): string
    {
        return 'ops-onboarding-reminder:'.$this->reminderRequestId;
    }

    public function failed(?Throwable $exception): void
    {
        OpsOnboardingReminderRequest::query()
            ->whereKey($this->reminderRequestId)
            ->where('status', '!=', OpsOnboardingReminderRequest::STATUS_SENT)
            ->update([
                'status' => OpsOnboardingReminderRequest::STATUS_FAILED,
                'last_error' => mb_substr($exception?->getMessage() ?? 'Unknown queue failure.', 0, 2000),
            ]);
    }

    public function skipped(): void
    {
        OpsOnboardingReminderRequest::query()
            ->whereKey($this->reminderRequestId)
            ->where('status', '!=', OpsOnboardingReminderRequest::STATUS_SENT)
            ->update([
                'status' => OpsOnboardingReminderRequest::STATUS_FAILED,
                'last_error' => 'Reminder delivery is disabled in queue operations.',
            ]);
    }
}
