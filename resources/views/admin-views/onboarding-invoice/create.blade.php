@extends('layouts.admin.app')

@section('title', translate('Create Onboarding Invoice'))

@section('content')
<div class="content container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center">
        <h1 class="page-header-title">
            <span class="page-header-icon"><i class="tio-receipt"></i></span>
            {{ translate('Create Onboarding Invoice') }}
        </h1>
        <a href="{{ route('admin.transactions.onboarding-invoices.index') }}" class="btn btn-outline-primary">
            <i class="tio-list mr-1"></i>{{ translate('Invoice List') }}
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <form action="{{ route('admin.transactions.onboarding-invoices.store') }}" method="post">
        @csrf
        <div class="card mb-3">
            <div class="card-header"><h4 class="card-title mb-0">{{ translate('Store Details') }}</h4></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="input-label" for="module_id">{{ translate('Business Module') }}</label>
                        <select name="module_id" id="module_id" class="form-control js-select2-custom" required>
                            <option value="">{{ translate('Select module') }}</option>
                            @foreach ($modules as $module)
                                <option value="{{ $module->id }}" @selected(old('module_id') == $module->id)>{{ $module->module_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="input-label" for="store_id">{{ translate('Store') }}</label>
                        <select name="store_id" id="store_id" class="form-control" data-placeholder="{{ translate('Search store by name') }}" required disabled>
                            @if(old('store_id'))<option value="{{ old('store_id') }}" selected>{{ translate('Previously selected store') }}</option>@endif
                        </select>
                        <small class="form-text text-muted">{{ translate('Start typing to find an active store in the selected module.') }}</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h4 class="card-title mb-0">{{ translate('Financial Details') }}</h4></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6 col-lg-4">
                        <label class="input-label" for="invoice_number">{{ translate('Invoice Number') }}</label>
                        <input type="text" name="invoice_number" id="invoice_number" class="form-control" value="{{ old('invoice_number') }}" maxlength="100" placeholder="{{ translate('Ex: ONB-2026-0001') }}" required>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <label class="input-label" for="invoice_type">{{ translate('Invoice Type') }}</label>
                        <select name="invoice_type" id="invoice_type" class="form-control js-select2-custom" required>
                            <option value="onboarding" @selected(old('invoice_type', 'onboarding') === 'onboarding')>{{ translate('Onboarding') }}</option>
                            <option value="other" @selected(old('invoice_type') === 'other')>{{ translate('Other') }}</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <label class="input-label" for="amount">{{ translate('Invoice Amount') }}</label>
                        <input type="number" name="amount" id="amount" class="form-control" value="{{ old('amount') }}" min="0.01" step="0.01" placeholder="0.00" required>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <label class="input-label" for="invoice_date">{{ translate('Invoice Date') }}</label>
                        <input type="date" name="invoice_date" id="invoice_date" class="form-control" value="{{ old('invoice_date', now()->toDateString()) }}" required>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <label class="input-label" for="due_date">{{ translate('Due Date') }}</label>
                        <input type="date" name="due_date" id="due_date" class="form-control" value="{{ old('due_date') }}" required>
                    </div>
                    <div class="col-md-6 col-lg-8">
                        <label class="input-label" for="additional_emails">{{ translate('Additional Recipient Emails') }} <span class="text-muted">({{ translate('Optional') }})</span></label>
                        <input type="text" name="additional_emails" id="additional_emails" class="form-control" value="{{ old('additional_emails') }}" maxlength="1000" placeholder="accounts@example.com, owner@example.com">
                        <small class="form-text text-muted">{{ translate('The invoice will also be sent to these addresses. Separate multiple emails with commas.') }}</small>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex flex-wrap justify-content-end gap-2">
                <button type="submit" name="submit_action" value="create" class="btn btn-outline-primary">
                    <i class="tio-add-circle mr-1"></i>{{ translate('Create Invoice') }}
                </button>
                <button type="submit" name="submit_action" value="create_and_send" class="btn btn-primary">
                    <i class="tio-send mr-1"></i>{{ translate('Create and Send to Store') }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('script_2')
<script>
    'use strict';
    $(document).ready(function () {
        const $module = $('#module_id');
        const $store = $('#store_id');

        function setupStoreSearch() {
            $store.prop('disabled', !$module.val()).empty().trigger('change');
            if (!$module.val()) return;
            $store.select2({
                width: '100%',
                placeholder: $store.data('placeholder'),
                minimumInputLength: 1,
                ajax: {
                    url: '{{ route('admin.transactions.onboarding-invoices.stores') }}',
                    dataType: 'json',
                    delay: 300,
                    data: function (params) {
                        return {module_id: $module.val(), q: params.term || '', page: params.page || 1};
                    },
                    processResults: function (data) { return data; },
                    cache: true
                }
            });
        }

        $module.on('change', setupStoreSearch);
        setupStoreSearch();
        $('#invoice_date').on('change', function () { $('#due_date').attr('min', this.value); }).trigger('change');
    });
</script>
@endpush
