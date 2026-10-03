<?php

namespace App\Jobs;

use App\CentralLogics\Helpers;
use App\Models\OnboardingApplication;
use App\Queue\Middleware\EnsureQueueProcessEnabled;
use App\Services\OnboardingInvoiceDeliveryService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class SendOpsOnboardingSubmissionEmails implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;

    public int $timeout = 180;

    public int $uniqueFor = 86400;

    public function __construct(public int $applicationId)
    {
        $this->afterCommit();
    }

    public function handle(OnboardingInvoiceDeliveryService $deliveryService): void
    {
        $application = OnboardingApplication::query()
            ->with(['store.module', 'invoice.items', 'manager'])
            ->find($this->applicationId);
        if (! $application || ! $application->store || ! $application->invoice) {
            return;
        }

        $failed = [];
        if (config('mail.status')
            && Helpers::get_mail_status('registration_mail_status_store') === '1'
            && Helpers::getNotificationStatusData('store', 'store_registration', 'mail_status')) {
            $registration = $deliveryService->sendRegistration(
                invoice: $application->invoice,
                recipient: $application->owner_email,
                storeName: $application->store_name,
                actorAdminId: $application->onboarding_manager_id,
                actorName: $application->manager_name_snapshot,
                idempotencyKey: 'ops-submission-registration:'.$application->id,
            );
            if ($registration['failed'] > 0 || ($registration['sent'] + $registration['skipped']) < 1) {
                $failed[] = 'registration';
            }
        } else {
            $application->invoice->events()->firstOrCreate(
                ['event_type' => 'registration_delivery_disabled'],
                [
                    'description' => 'Pending-registration email is disabled by mail settings.',
                    'metadata' => ['reason' => 'mail_setting_disabled'],
                    'admin_id' => $application->onboarding_manager_id,
                    'admin_name' => $application->manager_name_snapshot,
                ],
            );
        }

        $invoice = $deliveryService->send(
            invoice: $application->invoice,
            deliveryType: 'invoice',
            actorAdminId: $application->onboarding_manager_id,
            actorName: $application->manager_name_snapshot,
            idempotencyKey: 'ops-submission-invoice:'.$application->id,
        );
        if ($invoice['failed'] > 0 || ($invoice['sent'] + $invoice['skipped']) < 1) {
            $failed[] = 'invoice';
        }

        if ($failed !== []) {
            throw new \RuntimeException('Ops onboarding email delivery failed: '.implode(', ', $failed));
        }
    }

    public function middleware(): array
    {
        return [new EnsureQueueProcessEnabled('ops_onboarding_submission_email')];
    }

    public function backoff(): array
    {
        return [60, 300, 900, 3600];
    }

    public function uniqueId(): string
    {
        return 'ops-onboarding-submission-email:'.$this->applicationId;
    }

    public function failed(?Throwable $exception): void
    {
        $application = OnboardingApplication::query()->with('invoice')->find($this->applicationId);
        if (! $application?->invoice) {
            return;
        }
        $application->invoice->events()->create([
            'event_type' => 'submission_email_failed',
            'description' => 'Registration or invoice email exhausted all queued delivery attempts.',
            'metadata' => ['error' => mb_substr($exception?->getMessage() ?? 'Unknown queue failure.', 0, 2000)],
            'admin_id' => $application->onboarding_manager_id,
            'admin_name' => $application->manager_name_snapshot,
        ]);
    }

    public function skipped(): void
    {
        $application = OnboardingApplication::query()->with('invoice')->find($this->applicationId);
        if (! $application?->invoice) {
            return;
        }
        $application->invoice->events()->create([
            'event_type' => 'submission_email_skipped',
            'description' => 'Registration and invoice email delivery was disabled in queue operations.',
            'metadata' => ['reason' => 'queue_process_disabled'],
            'admin_id' => $application->onboarding_manager_id,
            'admin_name' => $application->manager_name_snapshot,
        ]);
    }
}
