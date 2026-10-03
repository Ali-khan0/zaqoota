<?php

namespace App\Mail;

use App\Models\BusinessSetting;
use App\Models\OnboardingInvoice;
use App\Services\OpsOnboardingCheckoutService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\View;

class OnboardingInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public OnboardingInvoice $invoice, public string $deliveryType = 'invoice') {}

    public function build(): self
    {
        $type = in_array($this->deliveryType, ['invoice', 'reminder', 'paid'], true)
            ? $this->deliveryType
            : 'invoice';
        $templateKeys = [
            "onboarding_invoice_email_{$type}_subject",
            "onboarding_invoice_email_{$type}_heading",
            "onboarding_invoice_email_{$type}_body",
        ];
        $settings = BusinessSetting::whereIn('key', [
            'business_name', 'address', 'phone', 'email_address',
            'onboarding_invoice_bank_name', 'onboarding_invoice_account_title',
            'onboarding_invoice_iban', 'onboarding_invoice_account_number',
            ...$templateKeys,
        ])->pluck('value', 'key');
        $business = $settings->only(['business_name', 'address', 'phone', 'email_address']);
        $bankDetails = [
            'bank_name' => $settings['onboarding_invoice_bank_name'] ?? 'Askari Bank',
            'account_title' => $settings['onboarding_invoice_account_title'] ?? 'Zaqoota',
            'iban' => $settings['onboarding_invoice_iban'] ?? 'PK02ASCM0009010200001008',
            'account_number' => $settings['onboarding_invoice_account_number'] ?? '09010200001008',
        ];
        $defaults = config("ops.email_templates.{$type}", []);
        $copy = [
            'subject' => $settings["onboarding_invoice_email_{$type}_subject"] ?? ($defaults['subject'] ?? 'Zaqoota onboarding invoice'),
            'heading' => $settings["onboarding_invoice_email_{$type}_heading"] ?? ($defaults['heading'] ?? 'Your onboarding invoice'),
            'body' => $settings["onboarding_invoice_email_{$type}_body"] ?? ($defaults['body'] ?? 'Your onboarding invoice is attached.'),
        ];
        $copy = array_map(fn ($value) => $this->replaceVariables((string) $value), $copy);
        $copy['subject'] = str_replace(["\r", "\n"], ' ', $copy['subject']);
        $checkoutUrl = app(OpsOnboardingCheckoutService::class)->urlForInvoice($this->invoice);
        $html = View::make('admin-views.onboarding-invoice.pdf', [
            'invoice' => $this->invoice,
            'business' => $business,
            'bankDetails' => $bankDetails,
            'checkoutUrl' => $checkoutUrl,
        ])->render();
        $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('tmp'), 'default_font' => 'dejavusans', 'mode' => 'utf-8', 'format' => 'A4']);
        $mpdf->WriteHTML($html);

        return $this->subject($copy['subject'])
            ->view('email-templates.onboarding-invoice', [
                'invoice' => $this->invoice,
                'deliveryType' => $type,
                'bankDetails' => $bankDetails,
                'copy' => $copy,
                'checkoutUrl' => $checkoutUrl,
            ])
            ->attachData($mpdf->Output('', 'S'), 'Zaqoota-Invoice-'.$this->invoice->invoice_number.'.pdf', [
                'mime' => 'application/pdf',
            ]);
    }

    private function replaceVariables(string $value): string
    {
        return strtr($value, [
            '{invoiceNumber}' => $this->invoice->invoice_number,
            '{storeName}' => $this->invoice->store_name,
            '{amount}' => (string) $this->invoice->amount,
            '{dueDate}' => $this->invoice->due_date?->format('d M Y') ?? '',
        ]);
    }
}
