<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <title>{{ translate('Pay onboarding invoice') }} · Zaqoota</title>
    <style>
        *{box-sizing:border-box}body{margin:0;background:#f4f8f8;color:#17333a;font-family:Arial,sans-serif}.shell{width:min(560px,calc(100% - 32px));margin:40px auto}.brand{text-align:center;color:#0d988d;font-weight:800;font-size:27px;margin-bottom:20px}.card{background:#fff;border:1px solid #dbeae8;border-radius:20px;box-shadow:0 14px 40px rgba(22,66,63,.09);overflow:hidden}.head{background:linear-gradient(135deg,#087f77,#21b5a8);color:#fff;padding:26px}.body{padding:26px}.row{display:flex;justify-content:space-between;gap:20px;padding:11px 0;border-bottom:1px solid #edf3f2}.row:last-child{border:0}.muted{color:#718096}.amount{font-size:30px;font-weight:800;margin:8px 0}.alert{padding:13px 15px;border-radius:12px;margin:0 0 18px;background:#fff3cd;color:#765500}.success{background:#ddf7ed;color:#08654d}.danger{background:#fde8e8;color:#9b1c1c}.gateway{display:block;width:100%;padding:14px;margin-top:12px;border:1px solid #cde5e2;border-radius:13px;background:#fff;color:#17333a;text-align:left;font-weight:700;cursor:pointer}.gateway:hover{border-color:#0d988d;background:#f2fbfa}.gateway img{width:28px;height:28px;object-fit:contain;vertical-align:middle;margin-right:10px}.note{text-align:center;color:#718096;font-size:13px;line-height:1.5;margin-top:18px}@media(max-width:480px){.shell{margin:18px auto}.body,.head{padding:21px}.card{border-radius:16px}}
    </style>
</head>
<body>
<main class="shell">
    <div class="brand">ZAQOOTA</div>
    <section class="card">
        <header class="head">
            <div>{{ translate('Onboarding invoice') }} #{{ $invoice->invoice_number }}</div>
            <div class="amount">{{ $currency }} {{ number_format((float) $invoice->amount, 2) }}</div>
            <div>{{ $invoice->store_name }}</div>
        </header>
        <div class="body">
            @if($errors->any())<div class="alert danger">{{ $errors->first() }}</div>@endif
            @if($invoice->payment_status === 'paid')
                <div class="alert success"><strong>{{ translate('Payment received') }}</strong><br>{{ translate('Your payment has been verified. Keep this page for your records.') }}</div>
            @elseif($invoice->payment_status === 'refunded')
                <div class="alert"><strong>{{ translate('Payment refunded') }}</strong><br>{{ translate('The recorded payment was refunded. Contact Zaqoota support if you need assistance.') }}</div>
            @elseif($invoice->voided_at)
                <div class="alert danger">{{ translate('This invoice is void and cannot be paid.') }}</div>
            @elseif($latestAttempt?->status === 'refund_pending' || $latestAttempt?->status === 'review_required')
                <div class="alert">{{ translate('Your payment is under review. Please do not pay again. Zaqoota will confirm or refund it after verification.') }}</div>
            @elseif(!$checkoutUrl)
                <div class="alert">{{ translate('This checkout link has expired. Please ask Zaqoota for a new invoice payment link.') }}</div>
            @else
                @if($latestAttempt?->status === 'failed')<div class="alert danger">{{ translate('The previous payment did not complete. You can try again.') }}</div>@endif
                <h2 style="margin:0 0 6px;font-size:20px">{{ translate('Choose payment method') }}</h2>
                <p class="muted" style="margin-top:0">{{ translate('You will continue to the secure payment provider.') }}</p>
                @forelse($gateways as $gateway)
                    <form method="post" action="{{ $checkoutUrl }}">@csrf
                        <input type="hidden" name="gateway" value="{{ $gateway['gateway'] }}">
                        <button class="gateway" type="submit">
                            @if(!empty($gateway['gateway_image_full_url']))<img src="{{ $gateway['gateway_image_full_url'] }}" alt="">@endif
                            {{ $gateway['gateway_title'] ?: ucwords(str_replace('_', ' ', $gateway['gateway'])) }}
                        </button>
                    </form>
                @empty
                    <div class="alert">{{ translate('No online payment gateway currently supports this invoice currency. Please use the bank details in your invoice.') }}</div>
                @endforelse
            @endif

            <div style="margin-top:22px">
                <div class="row"><span class="muted">{{ translate('Invoice date') }}</span><strong>{{ $invoice->invoice_date->format('d M Y') }}</strong></div>
                <div class="row"><span class="muted">{{ translate('Due date') }}</span><strong>{{ $invoice->due_date->format('d M Y') }}</strong></div>
                <div class="row"><span class="muted">{{ translate('Status') }}</span><strong>{{ ucwords(str_replace('_', ' ', $invoice->display_status)) }}</strong></div>
            </div>
        </div>
    </section>
    <p class="note">{{ translate('The payment provider callback is verified by the server. Returning to this page alone never marks an invoice as paid.') }}</p>
</main>
</body>
</html>
