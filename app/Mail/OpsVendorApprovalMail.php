<?php

namespace App\Mail;

use App\CentralLogics\Helpers;
use App\Models\BusinessSetting;
use App\Models\EmailTemplate;
use App\Models\OnboardingVendorPasswordSetup;
use App\Services\OpsOnboardingApprovalService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OpsVendorApprovalMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public OnboardingVendorPasswordSetup $setup) {}

    public function build(): self
    {
        $this->setup->loadMissing(['application.store', 'vendor']);
        $application = $this->setup->application;
        $template = EmailTemplate::where('type', 'store')->where('email_type', 'approve')->first();
        $storeName = $application->store_name;
        $title = Helpers::text_variable_data_format(
            value: $template?->title ?: config('ops.approval.email_subject', 'Your Zaqoota partner account is approved'),
            store_name: $storeName,
        );
        $body = Helpers::text_variable_data_format(
            value: $template?->body ?: config('ops.approval.email_body', 'Your restaurant account is approved. Set your password using the secure one-time link below.'),
            store_name: $storeName,
        );
        $companyName = BusinessSetting::where('key', 'business_name')->value('value') ?: 'Zaqoota';

        return $this->subject(trim((string) preg_replace('/\s+/', ' ', strip_tags($title))))
            ->view('email-templates.ops-vendor-approved', [
                'companyName' => $companyName,
                'title' => $title,
                'body' => $body,
                'storeName' => $storeName,
                'email' => $this->setup->vendor->email,
                'setupUrl' => app(OpsOnboardingApprovalService::class)->signedUrl($this->setup),
                'expiresAt' => $this->setup->expires_at,
            ]);
    }
}
