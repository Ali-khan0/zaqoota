@extends('layouts.admin.app')

@section('title', translate('Invoice') . ' #' . $invoice->invoice_number)

@section('content')
@php
    $allRecipients = collect([$invoice->store_email, ...($invoice->recipient_emails ?? [])])->filter()->unique()->values();
    $statusColor = ['paid' => 'success', 'unpaid' => 'warning', 'due_soon' => 'info', 'overdue' => 'danger', 'void' => 'secondary'][$invoice->display_status] ?? 'secondary';
@endphp
<div class="content container-fluid">
    <div class="page-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div><h1 class="page-header-title">{{ translate('Invoice') }} #{{ $invoice->invoice_number }}</h1><p class="text-muted mb-0">{{ $invoice->store_name }} · {{ $invoice->module_name }}</p></div>
        <div class="d-flex gap-2"><a href="{{ route('admin.transactions.onboarding-invoices.index') }}" class="btn btn-outline-secondary"><i class="tio-arrow-backward mr-1"></i>{{ translate('Back') }}</a><a href="{{ route('admin.transactions.onboarding-invoices.download', $invoice) }}" class="btn btn-outline-primary"><i class="tio-download mr-1"></i>{{ translate('Download PDF') }}</a></div>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
    @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card overflow-hidden" style="border:1px solid rgba(13,152,141,.2);">
                <div class="card-header border-0 text-white p-4" style="background:#0d988d;"><h2 class="text-white mb-0">ZAQOOTA <span class="float-right">{{ translate('INVOICE') }}</span></h2></div>
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex justify-content-end mb-3"><span class="badge badge-soft-{{ $statusColor }} px-3 py-2">{{ ucwords(str_replace('_', ' ', $invoice->display_status)) }}</span></div>
                    <div class="row mb-5"><div class="col-6"><h5>{{ translate('Bill to') }}</h5><strong>{{ $invoice->store_name }}</strong><br>@if($invoice->store_owner_name)<span class="text-muted">{{ translate('Owner') }}: {{ $invoice->store_owner_name }}</span><br>@endif{{ $invoice->store_email }}<br><span class="text-muted">{{ $invoice->store_address }}</span></div><div class="col-6 text-right"><strong>{{ translate('Invoice') }}:</strong> #{{ $invoice->invoice_number }}<br><strong>{{ translate('Invoice Date') }}:</strong> {{ $invoice->invoice_date->format('d M Y') }}<br><strong>{{ translate('Due Date') }}:</strong> {{ $invoice->due_date->format('d M Y') }}</div></div>
                    <div class="table-responsive"><table class="table"><thead style="background:#edf8f7;"><tr><th>{{ translate('Description') }}</th><th>{{ translate('Quantity') }}</th><th>{{ translate('Unit Price') }}</th><th class="text-right">{{ translate('Amount') }}</th></tr></thead><tbody>
                        @forelse($invoice->items as $item)<tr><td>{{ $item->description }}</td><td>{{ $item->quantity }}</td><td>{{ \App\CentralLogics\Helpers::format_currency($item->unit_price) }}</td><td class="text-right">{{ \App\CentralLogics\Helpers::format_currency($item->line_total) }}</td></tr>@empty<tr><td>{{ $invoice->invoice_type === 'onboarding' ? translate('Onboarding service') : translate('Other service') }}</td><td>1</td><td>{{ \App\CentralLogics\Helpers::format_currency($invoice->amount) }}</td><td class="text-right">{{ \App\CentralLogics\Helpers::format_currency($invoice->amount) }}</td></tr>@endforelse
                    </tbody></table></div>
                    <div class="row justify-content-end"><div class="col-sm-6"><div class="d-flex justify-content-between border-bottom border-primary py-3"><h4 class="mb-0">{{ translate('Total') }}</h4><h4 class="mb-0">{{ \App\CentralLogics\Helpers::format_currency($invoice->amount) }}</h4></div></div></div>
                    @if($invoice->public_note)<div class="alert alert-soft-info mt-4 mb-0"><strong>{{ translate('Public Note') }}</strong><br>{{ $invoice->public_note }}</div>@endif
                    @if($invoice->payment_status === 'unpaid' && !$invoice->voided_at)
                    <div class="mt-4 p-3" style="background:#f7fafb;border-left:3px solid #0d988d;"><h5>{{ translate('Payment Details') }}</h5><div class="row"><div class="col-sm-6"><strong>{{ translate('Bank Name') }}:</strong> {{ $bankDetails['bank_name'] }}<br><strong>{{ translate('Account Title') }}:</strong> {{ $bankDetails['account_title'] }}</div><div class="col-sm-6"><strong>{{ translate('IBAN') }}:</strong> {{ $bankDetails['iban'] }}<br><strong>{{ translate('Account Number') }}:</strong> {{ $bankDetails['account_number'] }}</div></div><small class="text-muted d-block mt-2">{{ translate('Please use the invoice number as your payment reference.') }} <strong>{{ $invoice->invoice_number }}</strong></small></div>
                    @endif
                    @if($invoice->voided_at)<div class="alert alert-danger mt-4 mb-0"><strong>{{ translate('Void Reason') }}</strong><br>{{ $invoice->void_reason }}</div>@endif
                    @if($invoice->generated_by_name)<div class="text-right text-muted mt-5"><small>{{ translate('Generated by') }}</small><br><strong class="text-dark">{{ $invoice->generated_by_name }}</strong></div>@endif
                </div>
            </div>
            @if($invoice->private_note)<div class="alert alert-warning mt-3"><strong>{{ translate('Private Admin Note') }}</strong><br>{{ $invoice->private_note }}</div>@endif
        </div>

        <div class="col-lg-4">
            <div class="card mb-3"><div class="card-header"><h4 class="card-title mb-0">{{ translate('Invoice Status') }}</h4></div><div class="card-body">
                @if(!$invoice->voided_at)
                <form action="{{ route('admin.transactions.onboarding-invoices.payment-status', $invoice) }}" method="post">@csrf @method('PATCH')
                    <label class="input-label">{{ translate('Change payment status') }}</label><select class="form-control mb-3" name="payment_status"><option value="unpaid" @selected($invoice->payment_status === 'unpaid')>{{ translate('Unpaid') }}</option><option value="paid" @selected($invoice->payment_status === 'paid')>{{ translate('Paid') }}</option></select>
                    <label class="input-label">{{ translate('Payment Method') }}</label><input class="form-control mb-3" name="payment_method" value="{{ $invoice->payment_method }}" placeholder="{{ translate('Required when paid') }}">
                    <label class="input-label">{{ translate('Payment Reference') }}</label><input class="form-control mb-3" name="payment_reference" value="{{ $invoice->payment_reference }}" placeholder="{{ translate('Optional transaction reference') }}">
                    <button class="btn btn-primary btn-block">{{ translate('Update Payment') }}</button><small class="form-text text-muted">{{ translate('Changing an unpaid invoice to paid automatically emails the paid invoice to the store.') }}</small>
                </form>
                @else<span class="badge badge-soft-secondary">{{ translate('Void') }}</span>@endif
            </div></div>

            <div class="card mb-3"><div class="card-header"><h4 class="card-title mb-0">{{ translate('Recipients and Delivery') }}</h4></div><div class="card-body">
                @foreach($allRecipients as $recipient)<div class="d-flex justify-content-between align-items-center border-bottom py-2"><span class="text-break mr-2">{{ $recipient }} @if(strtolower($recipient) === strtolower((string)$invoice->store_email))<span class="badge badge-soft-info">{{ translate('Primary') }}</span>@endif</span>@if(strtolower($recipient) !== strtolower((string)$invoice->store_email))<form action="{{ route('admin.transactions.onboarding-invoices.recipients.remove', $invoice) }}" method="post">@csrf @method('DELETE')<input type="hidden" name="email" value="{{ $recipient }}"><button class="btn btn-xs btn-outline-danger" title="{{ translate('Remove') }}"><i class="tio-delete"></i></button></form>@endif</div>@endforeach
                <form action="{{ route('admin.transactions.onboarding-invoices.recipients.add', $invoice) }}" method="post" class="mt-3">@csrf<label class="input-label">{{ translate('Add Recipient') }}</label><div class="input-group"><input type="email" name="email" class="form-control" required placeholder="name@example.com"><div class="input-group-append"><button class="btn btn-outline-primary"><i class="tio-add"></i></button></div></div></form>
                @if(!$invoice->voided_at && $allRecipients->isNotEmpty())
                <form action="{{ route('admin.transactions.onboarding-invoices.send', $invoice) }}" method="post" class="mt-4">@csrf<label class="input-label">{{ translate('Send to') }}</label>@foreach($allRecipients as $recipient)<div class="custom-control custom-checkbox mb-2"><input type="checkbox" class="custom-control-input" id="send-{{ md5($recipient) }}" name="recipients[]" value="{{ $recipient }}" checked><label class="custom-control-label" for="send-{{ md5($recipient) }}">{{ $recipient }}</label></div>@endforeach<button class="btn btn-primary btn-block mt-3"><i class="tio-send mr-1"></i>{{ $invoice->send_status === 'sent' ? translate('Resend Invoice') : translate('Send Invoice') }}</button></form>
                @if($invoice->payment_status === 'unpaid')<form action="{{ route('admin.transactions.onboarding-invoices.remind', $invoice) }}" method="post" class="mt-2">@csrf @foreach($allRecipients as $recipient)<input type="hidden" name="recipients[]" value="{{ $recipient }}">@endforeach<button class="btn btn-outline-primary btn-block"><i class="tio-notifications-on mr-1"></i>{{ translate('Send Payment Reminder') }}</button></form>@endif
                @endif
            </div></div>

            @if(!$invoice->voided_at)<div class="card border-danger"><div class="card-header"><h4 class="card-title text-danger mb-0">{{ translate('Void Invoice') }}</h4></div><div class="card-body"><form action="{{ route('admin.transactions.onboarding-invoices.void', $invoice) }}" method="post">@csrf<textarea name="void_reason" class="form-control mb-3" rows="3" required placeholder="{{ translate('Reason for voiding this invoice') }}"></textarea><button class="btn btn-outline-danger btn-block">{{ translate('Void Invoice') }}</button></form></div></div>@endif
        </div>
    </div>

    <div class="row g-3 mt-1">
        <div class="col-lg-6"><div class="card h-100"><div class="card-header"><h4 class="card-title mb-0">{{ translate('Delivery History') }}</h4></div><div class="table-responsive"><table class="table table-align-middle mb-0"><thead class="thead-light"><tr><th>{{ translate('Recipient') }}</th><th>{{ translate('Type') }}</th><th>{{ translate('Status') }}</th><th>{{ translate('Date') }}</th></tr></thead><tbody>@forelse($invoice->deliveries as $delivery)<tr><td class="text-break">{{ $delivery->recipient_email }}</td><td>{{ ucfirst($delivery->delivery_type) }}</td><td><span class="badge badge-soft-{{ $delivery->status === 'sent' ? 'success' : 'danger' }}">{{ ucfirst($delivery->status) }}</span>@if($delivery->error_message)<br><small class="text-danger">{{ $delivery->error_message }}</small>@endif</td><td>{{ $delivery->created_at->format('d M Y, h:i A') }}</td></tr>@empty<tr><td colspan="4" class="text-center text-muted p-4">{{ translate('No delivery attempts yet') }}</td></tr>@endforelse</tbody></table></div></div></div>
        <div class="col-lg-6"><div class="card h-100"><div class="card-header"><h4 class="card-title mb-0">{{ translate('Audit Timeline') }}</h4></div><div class="card-body">@forelse($invoice->events as $event)<div class="d-flex mb-4"><span class="tio-checkmark-circle text-primary mr-3 mt-1"></span><div><strong>{{ $event->description }}</strong><br><small class="text-muted">{{ $event->admin_name ?: translate('System') }} · {{ $event->created_at->format('d M Y, h:i A') }}</small></div></div>@empty<p class="text-muted mb-0">{{ translate('No activity recorded') }}</p>@endforelse</div></div></div>
    </div>
</div>
@endsection
