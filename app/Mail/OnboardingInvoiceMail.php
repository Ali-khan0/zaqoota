<?php

namespace App\Mail;

use App\Models\BusinessSetting;
use App\Models\OnboardingInvoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\View;

class OnboardingInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public OnboardingInvoice $invoice, public string $deliveryType = 'invoice')
    {
    }

    public function build(): self
    {
        $status = match ($this->deliveryType) {
            'paid' => 'Paid invoice',
            'reminder' => 'Payment reminder',
            default => 'Invoice',
        };

        $settings = BusinessSetting::whereIn('key', ['business_name', 'address', 'phone', 'email_address', 'onboarding_invoice_bank_name', 'onboarding_invoice_account_title', 'onboarding_invoice_iban', 'onboarding_invoice_account_number'])->pluck('value', 'key');
        $business = $settings->only(['business_name', 'address', 'phone', 'email_address']);
        $bankDetails = [
            'bank_name' => $settings['onboarding_invoice_bank_name'] ?? 'Askari Bank',
            'account_title' => $settings['onboarding_invoice_account_title'] ?? 'Zaqoota',
            'iban' => $settings['onboarding_invoice_iban'] ?? 'PK02ASCM0009010200001008',
            'account_number' => $settings['onboarding_invoice_account_number'] ?? '09010200001008',
        ];
        $html = View::make('admin-views.onboarding-invoice.pdf', [
            'invoice' => $this->invoice,
            'business' => $business,
            'bankDetails' => $bankDetails,
        ])->render();
        $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('tmp'), 'default_font' => 'dejavusans', 'mode' => 'utf-8', 'format' => 'A4']);
        $mpdf->WriteHTML($html);

        return $this->subject("{$status} #{$this->invoice->invoice_number} - Zaqoota")
            ->view('email-templates.onboarding-invoice', ['invoice' => $this->invoice, 'deliveryType' => $this->deliveryType, 'bankDetails' => $bankDetails])
            ->attachData($mpdf->Output('', 'S'), 'Zaqoota-Invoice-' . $this->invoice->invoice_number . '.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
