<?php

namespace App\Jobs;

use App\CentralLogics\Helpers;
use App\Mail\OpsVendorApprovalMail;
use App\Models\OnboardingApplication;
use App\Models\OnboardingVendorPasswordSetup;
use App\Queue\Middleware\EnsureQueueProcessEnabled;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendOpsVendorApprovalEmail implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;

    public int $timeout = 120;

    public int $uniqueFor = 86400;

    public function __construct(public int $passwordSetupId)
    {
        $this->afterCommit();
    }

    public function handle(): void
    {
        $setup = OnboardingVendorPasswordSetup::query()
            ->with(['application.invoice', 'application.store', 'vendor'])
            ->find($this->passwordSetupId);
        if (! $setup
            || $setup->application?->status !== OnboardingApplication::STATUS_APPROVED
            || (int) $setup->vendor?->status !== 1
            || (int) $setup->application?->store?->status !== 1
            || $setup->used_at
            || $setup->revoked_at
            || $setup->expires_at->isPast()) {
            return;
        }
        if (! config('mail.status')
            || Helpers::get_mail_status('approve_mail_status_store') !== '1'
            || ! Helpers::getNotificationStatusData('store', 'store_registration_approval', 'mail_status')) {
            $setup->application?->invoice?->events()->create([
                'event_type' => 'approval_email_disabled',
                'description' => 'Vendor approval/password-setup email is disabled by mail settings.',
            ]);

            return;
        }

        Mail::to($setup->vendor->email)->send(new OpsVendorApprovalMail($setup));
        $setup->application?->invoice?->events()->create([
            'event_type' => 'approval_email_sent',
            'description' => 'Vendor approval and one-time password-setup email sent.',
            'metadata' => ['password_setup_id' => $setup->id, 'recipient' => $setup->vendor->email],
        ]);
    }

    public function middleware(): array
    {
        return [new EnsureQueueProcessEnabled('ops_vendor_approval_email')];
    }

    public function backoff(): array
    {
        return [60, 300, 900, 3600];
    }

    public function uniqueId(): string
    {
        return 'ops-vendor-approval:'.$this->passwordSetupId;
    }

    public function failed(?Throwable $exception): void
    {
        $setup = OnboardingVendorPasswordSetup::query()->with('application.invoice')->find($this->passwordSetupId);
        $setup?->application?->invoice?->events()->create([
            'event_type' => 'approval_email_failed',
            'description' => 'Vendor approval/password-setup email exhausted all queued delivery attempts.',
            'metadata' => ['error' => mb_substr($exception?->getMessage() ?? 'Unknown queue failure.', 0, 2000)],
        ]);
    }

    public function skipped(): void
    {
        $setup = OnboardingVendorPasswordSetup::query()->with('application.invoice')->find($this->passwordSetupId);
        $setup?->application?->invoice?->events()->create([
            'event_type' => 'approval_email_skipped',
            'description' => 'Vendor approval/password-setup email is disabled in queue operations.',
            'metadata' => ['reason' => 'queue_process_disabled'],
        ]);
    }
}
