@extends('layouts.admin.app')
@section('title', translate('Zaqoota Ops settings'))
@section('content')
<div class="content container-fluid">
    <h1 class="page-header-title mb-3">{{ translate('Zaqoota Ops settings') }}</h1>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="alert alert-danger">@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>@endif
    <div class="card mb-3"><div class="card-body">
        <h3>{{ translate('Existing partner email templates') }}</h3>
        <p>{{ translate('Registration and approval use the existing Store templates. Approval always includes the secure password setup link. Payment confirmation also informs the partner about the data-entry handoff.') }}</p>
        <a class="btn btn-outline-primary" href="{{ route('admin.business-settings.email-setup', ['type' => 'store', 'tab' => 'registration']) }}">{{ translate('Store email templates') }}</a>
    </div></div>
    <form method="post" action="{{ route('admin.business-settings.ops.update') }}">@csrf
        <div class="card mb-3"><div class="card-body"><h3>{{ translate('Operational policy') }}</h3><div class="row">
            @foreach(['due_days' => 'Default invoice due days', 'menu_photos' => 'Maximum menu photos (1–8)', 'photo_size_kb' => 'Photo size in KB (100–2048)', 'reminder_minutes' => 'Reminder cooldown in minutes', 'minimum_withdrawal' => 'Minimum withdrawal in PKR'] as $key => $label)
                <div class="col-md-6 mb-3"><label for="{{ $key }}">{{ translate($label) }}</label><input id="{{ $key }}" class="form-control" type="number" name="{{ $key }}" value="{{ old($key, $settings[$key]) }}" required></div>
            @endforeach
            <div class="col-md-6"><label>{{ translate('Commission may be released manually after') }}</label><select class="form-control" name="release_policy"><option value="approved" @selected(old('release_policy', $settings['release_policy']) === 'approved')>{{ translate('Payment and final store approval') }}</option><option value="paid" @selected(old('release_policy', $settings['release_policy']) === 'paid')>{{ translate('Verified payment') }}</option></select><p>{{ translate('Changing this policy does not release funds automatically.') }}</p></div>
        </div></div></div>
        <div class="card mb-3"><div class="card-body"><h3>{{ translate('Onboarding services') }}</h3><p>{{ translate('Keep service IDs stable. Clear an ID to remove that service. Existing invoices keep their saved prices.') }}</p>
            @foreach(array_pad(old('services', $settings['services']), 25, ['id' => '', 'description' => '', 'default_unit_price' => 0, 'default_selected' => false]) as $i => $service)
                @if($i === count(old('services', $settings['services'])))<details><summary>{{ translate('Add more services') }}</summary>@endif
                <div class="row mb-2">
                    <div class="col-md-3"><label>{{ translate('Service ID') }}</label><input class="form-control" name="services[{{ $i }}][id]" value="{{ $service['id'] }}"></div>
                    <div class="col-md-5"><label>{{ translate('Description') }}</label><input class="form-control" name="services[{{ $i }}][description]" value="{{ $service['description'] }}"></div>
                    <div class="col-md-2"><label>{{ translate('Price PKR') }}</label><input type="number" min="0" class="form-control" name="services[{{ $i }}][default_unit_price]" value="{{ $service['default_unit_price'] }}"></div>
                    <div class="col-md-2"><input type="hidden" name="services[{{ $i }}][default_selected]" value="0"><label class="mt-4"><input type="checkbox" name="services[{{ $i }}][default_selected]" value="1" @checked($service['default_selected'])> {{ translate('Selected') }}</label></div>
                </div>
            @endforeach
            @if(count(old('services', $settings['services'])) < 25)</details>@endif
        </div></div>
        <div class="card mb-3"><div class="card-body"><h3>{{ translate('Ops app access and versions') }}</h3>
            <input type="hidden" name="maintenance" value="0"><label><input type="checkbox" name="maintenance" value="1" @checked(old('maintenance', $settings['maintenance'] ?? false))> {{ translate('Ops maintenance screen') }}</label>
            <input class="form-control mb-3" name="maintenance_message" value="{{ old('maintenance_message', $settings['maintenance_message'] ?? '') }}" placeholder="{{ translate('Maintenance message') }}">
            @foreach(['android', 'ios'] as $platform)<div class="row mb-3"><div class="col-md-4"><label>{{ ucfirst($platform) }} {{ translate('minimum version') }}</label><input class="form-control" name="{{ $platform }}_version" value="{{ old($platform.'_version', $settings[$platform.'_version'] ?? '0.0.0') }}" required></div><div class="col-md-8"><label>{{ translate('HTTPS update link') }}</label><input class="form-control" name="{{ $platform }}_url" value="{{ old($platform.'_url', $settings[$platform.'_url'] ?? '') }}"></div></div>@endforeach
        </div></div>
        @foreach(['invoice' => 'Invoice', 'reminder' => 'Payment reminder', 'paid' => 'Payment received / data-entry handoff'] as $type => $label)
            <div class="card mb-3"><div class="card-body"><h3>{{ translate($label) }}</h3><p>{{ translate('Use {invoiceNumber} for the invoice number.') }}</p>
                @foreach(['subject', 'heading', 'body'] as $part)
                    <label>{{ translate(ucfirst($part)) }}</label><textarea class="form-control mb-2" name="mail[{{ $type }}][{{ $part }}]" required>{{ old('mail.'.$type.'.'.$part, $mail['onboarding_invoice_email_'.$type.'_'.$part] ?? config('ops.email_templates.'.$type.'.'.$part)) }}</textarea>
                @endforeach
            </div></div>
        @endforeach
        <button class="btn btn--primary">{{ translate('Save Ops settings') }}</button>
    </form>
</div>
@endsection
