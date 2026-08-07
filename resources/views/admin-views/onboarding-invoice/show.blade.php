@extends('layouts.admin.app')

@section('title', translate('Invoice') . ' #' . $invoice->invoice_number)

@section('content')
<div class="content container-fluid">
    <div class="page-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div><h1 class="page-header-title">{{ translate('Invoice') }} #{{ $invoice->invoice_number }}</h1><p class="text-muted mb-0">{{ $invoice->store_name }} · {{ $invoice->module_name }}</p></div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.transactions.onboarding-invoices.index') }}" class="btn btn-outline-secondary"><i class="tio-arrow-backward mr-1"></i>{{ translate('Back') }}</a>
            <a href="{{ route('admin.transactions.onboarding-invoices.download', $invoice) }}" class="btn btn-outline-primary"><i class="tio-download mr-1"></i>{{ translate('Download PDF') }}</a>
            <form action="{{ route('admin.transactions.onboarding-invoices.send', $invoice) }}" method="post">@csrf<button class="btn btn-primary"><i class="tio-send mr-1"></i>{{ $invoice->send_status === 'sent' ? translate('Resend Invoice') : translate('Send Invoice') }}</button></form>
        </div>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card overflow-hidden" style="border:1px solid rgba(13,152,141,.2);">
                <div class="card-header border-0 text-white p-4" style="background:#0d988d;">
                    <h2 class="text-white mb-0">ZAQOOTA <span class="float-right">{{ translate('INVOICE') }}</span></h2>
                </div>
                <div class="card-body p-4 p-md-5">
                    <div class="row mb-5">
                        <div class="col-6"><h5>{{ translate('Bill to') }}</h5><strong>{{ $invoice->store_name }}</strong><br>{{ $invoice->store_email }}<br><span class="text-muted">{{ $invoice->store_address }}</span></div>
                        <div class="col-6 text-right"><strong>{{ translate('Invoice') }}:</strong> #{{ $invoice->invoice_number }}<br><strong>{{ translate('Invoice Date') }}:</strong> {{ $invoice->invoice_date->format('d M Y') }}<br><strong>{{ translate('Due Date') }}:</strong> {{ $invoice->due_date->format('d M Y') }}</div>
                    </div>
                    <div class="table-responsive"><table class="table"><thead style="background:#edf8f7;"><tr><th>{{ translate('Description') }}</th><th>{{ translate('Module') }}</th><th class="text-right">{{ translate('Amount') }}</th></tr></thead><tbody><tr><td>{{ $invoice->invoice_type === 'onboarding' ? translate('Onboarding service') : translate('Other service') }}</td><td>{{ $invoice->module_name }}</td><td class="text-right">{{ \App\CentralLogics\Helpers::format_currency($invoice->amount) }}</td></tr></tbody></table></div>
                    <div class="row justify-content-end"><div class="col-sm-6"><div class="d-flex justify-content-between border-bottom border-primary py-3"><h4 class="mb-0">{{ translate('Total') }}</h4><h4 class="mb-0">{{ \App\CentralLogics\Helpers::format_currency($invoice->amount) }}</h4></div></div></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-3"><div class="card-header"><h4 class="card-title mb-0">{{ translate('Invoice Status') }}</h4></div><div class="card-body">
                <div class="d-flex justify-content-between mb-3"><span>{{ translate('Payment') }}</span><span class="badge badge-soft-{{ $invoice->payment_status === 'paid' ? 'success' : 'warning' }}">{{ ucfirst($invoice->payment_status) }}</span></div>
                <form action="{{ route('admin.transactions.onboarding-invoices.payment-status', $invoice) }}" method="post">@csrf @method('PATCH')
                    <label class="input-label">{{ translate('Change payment status') }}</label>
                    <div class="input-group"><select class="form-control" name="payment_status"><option value="unpaid" @selected($invoice->payment_status === 'unpaid')>{{ translate('Unpaid') }}</option><option value="paid" @selected($invoice->payment_status === 'paid')>{{ translate('Paid') }}</option></select><div class="input-group-append"><button class="btn btn-primary">{{ translate('Update') }}</button></div></div>
                    <small class="form-text text-muted">{{ translate('Changing an unpaid invoice to paid automatically emails the paid invoice to the store.') }}</small>
                </form>
            </div></div>
            <div class="card"><div class="card-header"><h4 class="card-title mb-0">{{ translate('Email Delivery') }}</h4></div><div class="card-body">
                <div class="d-flex justify-content-between"><span>{{ translate('Status') }}</span><span class="badge badge-soft-{{ $invoice->send_status === 'sent' ? 'success' : ($invoice->send_status === 'failed' ? 'danger' : 'secondary') }}">{{ str_replace('_', ' ', ucfirst($invoice->send_status)) }}</span></div>
                <div class="mt-3"><strong>{{ translate('Recipients') }}</strong><br><span class="text-muted">{{ collect([$invoice->store_email, ...($invoice->recipient_emails ?? [])])->filter()->unique()->implode(', ') ?: translate('No valid recipient') }}</span></div>
                @if($invoice->sent_at)<p class="text-muted mt-3 mb-0">{{ translate('Last sent') }}: {{ $invoice->sent_at->format('d M Y, h:i A') }}</p>@endif
                @if($invoice->last_send_error)<div class="alert alert-danger mt-3 mb-0 text-break"><strong>{{ translate('Last error') }}:</strong><br>{{ $invoice->last_send_error }}</div>@endif
            </div></div>
        </div>
    </div>
</div>
@endsection
