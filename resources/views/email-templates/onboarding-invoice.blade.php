<!doctype html>
<html lang="en">
<body style="margin:0;padding:24px;background:#f4f7f8;font-family:Verdana,Geneva,sans-serif;color:#334257;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
    <tr><td align="center">
        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:600px;background:#fff;border:1px solid rgba(13,152,141,.16);border-radius:4px;">
            <tr><td style="padding:26px 40px;background:#0d988d;color:#fff;text-align:center;font-size:26px;font-weight:700;">ZAQOOTA</td></tr>
            <tr><td style="padding:38px 40px;">
                <h1 style="margin:0 0 18px;color:#222;font-size:22px;line-height:1.35;">{{ $deliveryType === 'paid' ? 'Payment received' : ($deliveryType === 'reminder' ? 'Payment reminder' : 'Your invoice is ready') }}</h1>
                <p style="margin:0 0 14px;line-height:1.65;">Dear {{ $invoice->store_name }} team,</p>
                <p style="margin:0 0 18px;line-height:1.65;">
                    {{ $deliveryType === 'paid' ? 'Thank you. Your paid invoice is attached for your records.' : ($deliveryType === 'reminder' ? 'This is a friendly reminder that the attached invoice remains unpaid.' : 'Please find your Zaqoota invoice attached to this email.') }}
                </p>
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f7fafb;border-left:3px solid #0d988d;">
                    <tr><td style="padding:16px;line-height:1.7;">
                        <strong>Invoice:</strong> {{ $invoice->invoice_number }}<br>
                        <strong>Amount:</strong> {{ \App\CentralLogics\Helpers::format_currency($invoice->amount) }}<br>
                        <strong>Due date:</strong> {{ $invoice->due_date->format('d M Y') }}<br>
                        <strong>Status:</strong> {{ ucfirst($invoice->payment_status) }}
                    </td></tr>
                </table>
                @if($invoice->payment_status === 'unpaid' && !$invoice->voided_at)
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin-top:18px;background:#f7fafb;border-left:3px solid #0d988d;"><tr><td style="padding:16px;line-height:1.7;"><strong>Payment Details</strong><br>Bank: {{ $bankDetails['bank_name'] }}<br>Account title: {{ $bankDetails['account_title'] }}<br>IBAN: {{ $bankDetails['iban'] }}<br>Account number: {{ $bankDetails['account_number'] }}<br><span style="color:#718096;">Please use {{ $invoice->invoice_number }} as your payment reference.</span></td></tr></table>
                @endif
                <p style="margin:22px 0 0;line-height:1.65;color:#718096;">Thanks &amp; Regards,<br>Zaqoota</p>
            </td></tr>
        </table>
    </td></tr>
</table>
</body>
</html>
