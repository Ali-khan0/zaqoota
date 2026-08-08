<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; color: #334257; font-family: dejavusans, sans-serif; font-size: 12px; }
        .invoice { border: 1px solid #dbe9e7; }
        .header { background: #0d988d; color: #fff; padding: 30px 34px; }
        .brand { font-size: 25px; font-weight: bold; }
        .invoice-title { float: right; font-size: 21px; font-weight: bold; }
        .content { padding: 34px; }
        .meta { width: 100%; border-collapse: collapse; margin-bottom: 34px; }
        .meta td { width: 50%; vertical-align: top; line-height: 1.65; }
        .right { text-align: right; }
        .muted { color: #718096; }
        .status { display: inline-block; padding: 5px 10px; color: #fff; background: {{ $invoice->payment_status === 'paid' ? '#0d988d' : '#d99020' }}; font-weight: bold; text-transform: uppercase; }
        .charges { width: 100%; border-collapse: collapse; margin-top: 12px; }
        .charges th { padding: 13px 14px; background: #edf8f7; color: #244a47; text-align: left; border-bottom: 1px solid #cde5e2; }
        .charges td { padding: 17px 14px; border-bottom: 1px solid #e3eceb; }
        .charges .amount { text-align: right; }
        .total { width: 42%; margin-left: 58%; margin-top: 18px; border-collapse: collapse; }
        .total td { padding: 10px 0; font-size: 15px; font-weight: bold; border-bottom: 2px solid #0d988d; }
        .footer { margin-top: 54px; padding-top: 18px; border-top: 1px solid #dbe9e7; color: #718096; line-height: 1.6; }
        .note { margin-top: 28px; padding: 14px; background: #f7fafb; border-left: 3px solid #0d988d; }
    </style>
</head>
<body>
<div class="invoice">
    <div class="header">
        <span class="brand">ZAQOOTA</span>
        <span class="invoice-title">INVOICE</span>
    </div>
    <div class="content">
        <table class="meta">
            <tr>
                <td>
                    <strong style="font-size:15px;color:#1f2937;">Bill to</strong><br>
                    <strong>{{ $invoice->store_name }}</strong><br>
                    @if($invoice->store_owner_name)<span class="muted">Attn: {{ $invoice->store_owner_name }}</span><br>@endif
                    {{ $invoice->store_email }}<br>
                    <span class="muted">{{ $invoice->store_address }}</span>
                </td>
                <td class="right">
                    <strong>Invoice #:</strong> {{ $invoice->invoice_number }}<br>
                    <strong>Invoice date:</strong> {{ $invoice->invoice_date->format('d M Y') }}<br>
                    <strong>Due date:</strong> {{ $invoice->due_date->format('d M Y') }}<br><br>
                    <span class="status">{{ $invoice->display_status }}</span>
                </td>
            </tr>
        </table>

        <table class="charges">
            <thead><tr><th>Description</th><th>Module</th><th class="amount">Amount</th></tr></thead>
            <tbody>
            @forelse($invoice->items as $item)<tr><td>{{ $item->description }}<br><span class="muted">{{ $item->quantity }} × {{ \App\CentralLogics\Helpers::format_currency($item->unit_price) }}</span></td><td>{{ $invoice->module_name }}</td><td class="amount">{{ \App\CentralLogics\Helpers::format_currency($item->line_total) }}</td></tr>
            @empty<tr><td>{{ $invoice->invoice_type === 'onboarding' ? 'Onboarding service' : 'Other service' }}</td><td>{{ $invoice->module_name }}</td><td class="amount">{{ \App\CentralLogics\Helpers::format_currency($invoice->amount) }}</td></tr>@endforelse
            </tbody>
        </table>
        <table class="total"><tr><td>Total</td><td class="right">{{ \App\CentralLogics\Helpers::format_currency($invoice->amount) }}</td></tr></table>
        @if($invoice->public_note)<div class="note"><strong>Note</strong><br>{{ $invoice->public_note }}</div>@endif
        @if($invoice->payment_status === 'unpaid' && !$invoice->voided_at)<div class="note"><strong>Payment Details</strong><br>Bank: {{ $bankDetails['bank_name'] }}<br>Account title: {{ $bankDetails['account_title'] }}<br>IBAN: {{ $bankDetails['iban'] }}<br>Account number: {{ $bankDetails['account_number'] }}<br><span class="muted">Please use {{ $invoice->invoice_number }} as your payment reference.</span></div>@endif
        @if($invoice->payment_status === 'paid' && $invoice->payment_method)<div class="note"><strong>Payment</strong><br>{{ $invoice->payment_method }}@if($invoice->payment_reference) · {{ $invoice->payment_reference }}@endif</div>@endif
        @if($invoice->voided_at)<div class="note" style="border-color:#c0392b;"><strong>VOID</strong><br>{{ $invoice->void_reason }}</div>@endif

        <div class="footer">
            <strong style="color:#334257;">{{ $business['business_name'] ?? 'Zaqoota' }}</strong><br>
            {{ $business['address'] ?? '' }}<br>
            {{ $business['email_address'] ?? '' }}@if(!empty($business['phone'])) &nbsp; | &nbsp; {{ $business['phone'] }} @endif
            @if($invoice->generated_by_name)<br><br><strong style="color:#334257;">Generated by:</strong> {{ $invoice->generated_by_name }}@endif
        </div>
    </div>
</div>
</body>
</html>
