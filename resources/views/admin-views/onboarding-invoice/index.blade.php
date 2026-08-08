@extends('layouts.admin.app')

@section('title', translate('Onboarding Invoices'))

@section('content')
<div class="content container-fluid onboarding-invoice-history">
    <div class="page-header d-flex justify-content-between align-items-center">
        <h1 class="page-header-title">
            <span class="page-header-icon"><i class="tio-receipt"></i></span>
            {{ translate('Onboarding Invoices') }} <span class="badge badge-soft-dark ml-2">{{ $invoices->total() }}</span>
        </h1>
        <a href="{{ route('admin.transactions.onboarding-invoices.create') }}" class="btn btn-primary">
            <i class="tio-add mr-1"></i>{{ translate('Create Invoice') }}
        </a>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

    <div class="card mb-3">
        <div class="card-header"><h4 class="card-title mb-0">{{ translate('Invoice Payment Details') }}</h4></div>
        <div class="card-body"><form action="{{ route('admin.transactions.onboarding-invoices.bank-details') }}" method="post">@csrf @method('PATCH')<div class="row g-3">
            <div class="col-md-6 col-xl-3"><label class="input-label">{{ translate('Bank Name') }}</label><input name="bank_name" class="form-control" value="{{ old('bank_name', $bankDetails['bank_name']) }}" required></div>
            <div class="col-md-6 col-xl-3"><label class="input-label">{{ translate('Account Title') }}</label><input name="account_title" class="form-control" value="{{ old('account_title', $bankDetails['account_title']) }}" required></div>
            <div class="col-md-6 col-xl-3"><label class="input-label">{{ translate('IBAN') }}</label><input name="iban" class="form-control" value="{{ old('iban', $bankDetails['iban']) }}" required></div>
            <div class="col-md-6 col-xl-3"><label class="input-label">{{ translate('Account Number') }}</label><input name="account_number" class="form-control" value="{{ old('account_number', $bankDetails['account_number']) }}" required></div>
            <div class="col-12 text-right"><button class="btn btn-primary"><i class="tio-save mr-1"></i>{{ translate('Save Payment Details') }}</button></div>
        </div></form></div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-sm-6 col-xl-3"><div class="card h-100"><div class="card-body"><p class="text-muted mb-2">{{ translate('Total Invoice Amount') }}</p><h3 class="mb-1">{{ \App\CentralLogics\Helpers::format_currency($totals->total_amount) }}</h3><small class="text-muted">{{ $totals->invoice_count }} {{ translate('invoices') }}</small></div></div></div>
        <div class="col-sm-6 col-xl-3"><div class="card h-100"><div class="card-body"><p class="text-muted mb-2">{{ translate('Paid Amount') }}</p><h3 class="text-success mb-1">{{ \App\CentralLogics\Helpers::format_currency($totals->paid_amount) }}</h3><small class="text-muted">{{ translate('Received') }}</small></div></div></div>
        <div class="col-sm-6 col-xl-3"><div class="card h-100"><div class="card-body"><p class="text-muted mb-2">{{ translate('Unpaid Amount') }}</p><h3 class="text-warning mb-1">{{ \App\CentralLogics\Helpers::format_currency($totals->unpaid_amount) }}</h3><small class="text-muted">{{ translate('Outstanding') }}</small></div></div></div>
        <div class="col-sm-6 col-xl-3"><div class="card h-100"><div class="card-body"><p class="text-muted mb-2">{{ translate('Collection Progress') }}</p>@php($collectionRate = (float) $totals->total_amount > 0 ? ((float) $totals->paid_amount / (float) $totals->total_amount) * 100 : 0)<h3 class="mb-1">{{ number_format($collectionRate, 1) }}%</h3><div class="progress" style="height:6px;"><div class="progress-bar bg-success" style="width:{{ min(100, $collectionRate) }}%"></div></div></div></div>
    </div>

    <div class="card w-100">
        <div class="card-header border-0">
            <form class="w-100">
                <div class="row g-2">
                    <div class="col-md-5">
                        <input type="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="{{ translate('Search invoice number, store or email') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="payment_status" class="form-control">
                            <option value="">{{ translate('All payment statuses') }}</option>
                            <option value="paid" @selected(request('payment_status') === 'paid')>{{ translate('Paid') }}</option>
                            <option value="unpaid" @selected(request('payment_status') === 'unpaid')>{{ translate('Unpaid') }}</option>
                            <option value="due_soon" @selected(request('payment_status') === 'due_soon')>{{ translate('Due Soon') }}</option>
                            <option value="overdue" @selected(request('payment_status') === 'overdue')>{{ translate('Overdue') }}</option>
                            <option value="void" @selected(request('payment_status') === 'void')>{{ translate('Void') }}</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="send_status" class="form-control">
                            <option value="">{{ translate('All send statuses') }}</option>
                            <option value="sent" @selected(request('send_status') === 'sent')>{{ translate('Sent') }}</option>
                            <option value="not_sent" @selected(request('send_status') === 'not_sent')>{{ translate('Not sent') }}</option>
                            <option value="failed" @selected(request('send_status') === 'failed')>{{ translate('Failed') }}</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button class="btn btn-primary flex-grow-1"><i class="tio-search mr-1"></i>{{ translate('Filter') }}</button>
                        <a href="{{ route('admin.transactions.onboarding-invoices.index') }}" class="btn btn-outline-secondary"><i class="tio-refresh"></i></a>
                    </div>
                </div>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-borderless table-thead-bordered table-align-middle card-table w-100 onboarding-invoice-table">
                <thead class="thead-light"><tr>
                    <th>{{ translate('Invoice') }}</th><th>{{ translate('Store') }}</th><th>{{ translate('Module') }}</th>
                    <th>{{ translate('Date / Due') }}</th><th>{{ translate('Amount') }}</th><th>{{ translate('Payment') }}</th>
                    <th>{{ translate('Email') }}</th><th class="text-center">{{ translate('Action') }}</th>
                </tr></thead>
                <tbody>
                @forelse($invoices as $invoice)
                    <tr>
                        <td><a class="font-weight-bold text-primary" href="{{ route('admin.transactions.onboarding-invoices.show', $invoice) }}">#{{ $invoice->invoice_number }}</a><br><small class="text-muted">{{ ucfirst($invoice->invoice_type) }}</small></td>
                        <td><strong>{{ $invoice->store_name }}</strong><br><small class="text-muted">{{ $invoice->store_email }}</small></td>
                        <td>{{ $invoice->module_name }}</td>
                        <td>{{ $invoice->invoice_date->format('d M Y') }}<br><small class="text-muted">{{ translate('Due') }}: {{ $invoice->due_date->format('d M Y') }}</small></td>
                        <td class="font-weight-bold">{{ \App\CentralLogics\Helpers::format_currency($invoice->amount) }}</td>
                        @php($statusColor = ['paid' => 'success', 'unpaid' => 'warning', 'due_soon' => 'info', 'overdue' => 'danger', 'void' => 'secondary'][$invoice->display_status] ?? 'secondary')
                        <td><span class="badge badge-soft-{{ $statusColor }}">{{ ucwords(str_replace('_', ' ', $invoice->display_status)) }}</span></td>
                        <td><span class="badge badge-soft-{{ $invoice->send_status === 'sent' ? 'success' : ($invoice->send_status === 'failed' ? 'danger' : 'secondary') }}">{{ str_replace('_', ' ', ucfirst($invoice->send_status)) }}</span></td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-outline-primary square-btn" href="{{ route('admin.transactions.onboarding-invoices.show', $invoice) }}" title="{{ translate('View') }}"><i class="tio-visible"></i></a>
                            <a class="btn btn-sm btn-outline-primary square-btn" href="{{ route('admin.transactions.onboarding-invoices.download', $invoice) }}" title="{{ translate('Download PDF') }}"><i class="tio-download"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8"><div class="text-center p-5"><h5>{{ translate('No invoices found') }}</h5></div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($invoices->hasPages())<div class="card-footer">{{ $invoices->links() }}</div>@endif
    </div>
</div>
@endsection

@push('css_or_js')
<style>
    .onboarding-invoice-history { width: 100%; max-width: none; }
    .onboarding-invoice-history .card { min-width: 0; }
    .onboarding-invoice-table { min-width: 1050px; }
    .onboarding-invoice-table td { white-space: normal; }
</style>
@endpush
