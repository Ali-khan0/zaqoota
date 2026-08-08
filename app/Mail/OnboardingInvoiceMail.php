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

        $business = BusinessSetting::whereIn('key', ['business_name', 'address', 'phone', 'email_address'])->pluck('value', 'key');
        $html = View::make('admin-views.onboarding-invoice.pdf', [
            'invoice' => $this->invoice,
            'business' => $business,
        ])->render();
        $mpdf = new \Mpdf\Mpdf(['tempDir' => storage_path('tmp'), 'default_font' => 'dejavusans', 'mode' => 'utf-8', 'format' => 'A4']);
        $mpdf->WriteHTML($html);

        return $this->subject("{$status} #{$this->invoice->invoice_number} - Zaqoota")
            ->view('email-templates.onboarding-invoice', ['invoice' => $this->invoice, 'deliveryType' => $this->deliveryType])
            ->attachData($mpdf->Output('', 'S'), 'Zaqoota-Invoice-' . $this->invoice->invoice_number . '.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
