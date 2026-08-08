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
        <input type="hidden" name="submit_action" id="submit_action" value="create">
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
                        <small class="form-text text-muted">{{ translate('Start typing to find a store in the selected module.') }}</small>
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
                        <input type="text" id="invoice_number" class="form-control" value="{{ $invoiceNumber }}" readonly>
                        <small class="form-text text-muted">{{ translate('Generated automatically when the invoice is created.') }}</small>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <label class="input-label" for="invoice_type">{{ translate('Invoice Type') }}</label>
                        <select name="invoice_type" id="invoice_type" class="form-control js-select2-custom" required>
                            <option value="onboarding" @selected(old('invoice_type', 'onboarding') === 'onboarding')>{{ translate('Onboarding') }}</option>
                            <option value="other" @selected(old('invoice_type') === 'other')>{{ translate('Other') }}</option>
                        </select>
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
                <div class="mt-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-2">
                        <label class="input-label mb-0">{{ translate('Invoice Items') }}</label>
                        <div class="d-flex align-items-end gap-2">
                            <div><label class="input-label mb-1" for="service-preset">{{ translate('Add Service') }}</label><select id="service-preset" class="form-control"><option value="">{{ translate('Select a service') }}</option><option>Product photography</option><option>Video shoot</option><option>Menu design</option><option>Menu data entry</option><option>Promotional banner design</option><option>Social media content</option><option>Featured store placement</option><option>Staff training</option><option>Additional technical support</option><option>Custom integration</option><option>Other service</option></select></div>
                            <button type="button" id="add-preset-item" class="btn btn-outline-primary">{{ translate('Add Service') }}</button>
                            <button type="button" id="add-invoice-item" class="btn btn-outline-secondary"><i class="tio-add mr-1"></i>{{ translate('Custom Item') }}</button>
                        </div>
                    </div>
                    <div class="table-responsive"><table class="table table-bordered" id="invoice-items-table"><thead class="thead-light"><tr><th>{{ translate('Description') }}</th><th style="width:130px">{{ translate('Quantity') }}</th><th style="width:180px">{{ translate('Unit Price') }}</th><th style="width:150px" class="text-right">{{ translate('Line Total') }}</th><th style="width:55px"></th></tr></thead><tbody>
                        @php($oldItems = old('items', old('invoice_type', 'onboarding') === 'onboarding' ? [
                            ['description' => 'Partner account onboarding', 'quantity' => 1, 'unit_price' => ''],
                            ['description' => 'Store profile and menu configuration', 'quantity' => 1, 'unit_price' => ''],
                            ['description' => 'Delivery zone setup and initial technical support', 'quantity' => 1, 'unit_price' => ''],
                        ] : [['description' => 'Other service', 'quantity' => 1, 'unit_price' => '']]))
                        @foreach($oldItems as $index => $item)
                        <tr class="invoice-item-row"><td><input class="form-control" name="items[{{ $index }}][description]" value="{{ $item['description'] ?? '' }}" maxlength="255" required></td><td><input type="number" class="form-control item-quantity" name="items[{{ $index }}][quantity]" value="{{ $item['quantity'] ?? 1 }}" min="0.01" step="0.01" required></td><td><input type="number" class="form-control item-price" name="items[{{ $index }}][unit_price]" value="{{ $item['unit_price'] ?? '' }}" min="0" step="0.01" required></td><td class="text-right align-middle font-weight-bold item-total">0.00</td><td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger remove-invoice-item" title="{{ translate('Remove') }}"><i class="tio-delete"></i></button></td></tr>
                        @endforeach
                    </tbody><tfoot><tr><th colspan="3" class="text-right">{{ translate('Invoice Total') }}</th><th class="text-right" id="invoice-total">0.00</th><th></th></tr></tfoot></table></div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-6"><label class="input-label" for="public_note">{{ translate('Public Note') }} <span class="text-muted">({{ translate('Optional') }})</span></label><textarea name="public_note" id="public_note" class="form-control" rows="3" maxlength="2000" placeholder="{{ translate('Shown on the invoice PDF') }}">{{ old('public_note') }}</textarea></div>
                    <div class="col-md-6"><label class="input-label" for="private_note">{{ translate('Private Admin Note') }} <span class="text-muted">({{ translate('Optional') }})</span></label><textarea name="private_note" id="private_note" class="form-control" rows="3" maxlength="5000" placeholder="{{ translate('Only admins can see this note') }}">{{ old('private_note') }}</textarea></div>
                </div>
            </div>
            <div class="card-footer d-flex flex-wrap justify-content-end gap-2">
                <button type="submit" class="btn btn-outline-primary" data-submit-action="create">
                    <i class="tio-add-circle mr-1"></i>{{ translate('Create Invoice') }}
                </button>
                <button type="submit" class="btn btn-primary" data-submit-action="create_and_send">
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
        let itemIndex = {{ count($oldItems) }};

        function calculateInvoiceTotal() {
            let total = 0;
            $('.invoice-item-row').each(function () {
                const lineTotal = (parseFloat($(this).find('.item-quantity').val()) || 0) * (parseFloat($(this).find('.item-price').val()) || 0);
                $(this).find('.item-total').text(lineTotal.toFixed(2));
                total += lineTotal;
            });
            $('#invoice-total').text(total.toFixed(2));
        }

        function appendInvoiceItem(description) {
            const safeDescription = $('<div>').text(description || '').html();
            $('#invoice-items-table tbody').append(`<tr class="invoice-item-row"><td><input class="form-control" name="items[${itemIndex}][description]" value="${safeDescription}" maxlength="255" required></td><td><input type="number" class="form-control item-quantity" name="items[${itemIndex}][quantity]" value="1" min="0.01" step="0.01" required></td><td><input type="number" class="form-control item-price" name="items[${itemIndex}][unit_price]" min="0" step="0.01" required></td><td class="text-right align-middle font-weight-bold item-total">0.00</td><td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger remove-invoice-item"><i class="tio-delete"></i></button></td></tr>`);
            itemIndex++;
        }

        function setupStoreSearch() {
            if ($store.hasClass('select2-hidden-accessible')) {
                $store.select2('destroy');
            }
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
        $('#add-invoice-item').on('click', function () {
            appendInvoiceItem('');
        });
        $('#add-preset-item').on('click', function () {
            const description = $('#service-preset').val();
            if (!description) return;
            appendInvoiceItem(description);
            $('#service-preset').val('');
        });
        $(document).on('input', '.item-quantity,.item-price', calculateInvoiceTotal);
        $(document).on('click', '.remove-invoice-item', function () {
            if ($('.invoice-item-row').length > 1) { $(this).closest('tr').remove(); calculateInvoiceTotal(); }
        });
        $('[data-submit-action]').on('click', function () {
            $('#submit_action').val($(this).data('submit-action'));
        });
        $store.on('select2:select', function (event) {
            const email = event.params.data.email || '';
            $('#additional_emails').val(email);
        });
        setupStoreSearch();
        $('#invoice_date').on('change', function () { $('#due_date').attr('min', this.value); }).trigger('change');
        calculateInvoiceTotal();
    });
</script>
@endpush
