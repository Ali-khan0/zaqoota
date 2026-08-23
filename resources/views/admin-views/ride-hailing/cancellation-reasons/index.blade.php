@extends('layouts.admin.app')

@section('title', translate('messages.Ride Cancellation Reasons'))

@section('content')
@php
    $editing = isset($reason) && $reason;
    $locales = collect($languages)->map(fn($language) => is_array($language) ? ($language['key'] ?? null) : $language)->filter()->prepend('default')->unique()->values();
    $selectedStatuses = old('ride_statuses', $editing ? ($reason->ride_statuses ?? []) : $statuses);
@endphp
<div class="content container-fluid">
    <div class="page-header"><h1 class="page-header-title"><span class="page-header-icon"><i class="tio-clear-circle"></i></span>{{ translate('messages.Ride Cancellation Reasons') }}</h1><p class="page-header-text mb-0">{{ translate('messages.Configure actor and Ride lifecycle specific reasons shown to customers, Captains, and admins.') }}</p></div>
    @include('admin-views.ride-hailing.partials.alerts')

    <div class="card mb-3"><div class="card-header"><h5 class="card-title">{{ translate($editing ? 'messages.Edit Cancellation Reason' : 'messages.Create Cancellation Reason') }}</h5>@if($editing)<a href="{{ route('admin.ride-hailing.cancellation-reasons.index') }}" class="btn btn-outline-secondary btn-sm">{{ translate('messages.Cancel Edit') }}</a>@endif</div><div class="card-body">
        <form method="POST" action="{{ $editing ? route('admin.ride-hailing.cancellation-reasons.update', $reason) : route('admin.ride-hailing.cancellation-reasons.store') }}">@csrf @if($editing) @method('PUT') @endif
            <div class="row g-3">
                @foreach($locales as $index => $locale)
                    @php $translated = $editing && $locale !== 'default' ? $reason->translations->first(fn($item) => $item->locale === $locale && $item->key === 'title')?->value : null; @endphp
                    <input type="hidden" name="lang[]" value="{{ $locale }}">
                    <div class="col-md-6"><label class="input-label">{{ translate('messages.Title') }} ({{ strtoupper($locale) }})</label><input name="title[]" maxlength="255" class="form-control" @required($locale === 'default') value="{{ old('title.'.$index, $locale === 'default' ? $reason?->getRawOriginal('title') : $translated) }}"></div>
                @endforeach
                <div class="col-md-4"><label class="input-label">{{ translate('messages.Stable Code') }}</label><input name="code" maxlength="80" pattern="[a-z0-9_]+" class="form-control" @readonly($editing) required value="{{ old('code', $reason?->code) }}" placeholder="customer_plans_changed"></div>
                <div class="col-md-4"><label class="input-label">{{ translate('messages.Actor') }}</label><select name="user_type" class="form-control" required>@foreach(\App\Models\RideCancellationReason::ACTORS as $actor)<option value="{{ $actor }}" @selected(old('user_type', $reason?->user_type) === $actor)>{{ ucfirst($actor) }}</option>@endforeach</select></div>
                <div class="col-md-4"><label class="input-label">{{ translate('messages.Display Order') }}</label><input type="number" name="display_order" min="0" max="9999" class="form-control" required value="{{ old('display_order', $reason?->display_order ?? 0) }}"></div>
                <div class="col-12"><label class="input-label">{{ translate('messages.Applicable Ride Statuses') }}</label><select name="ride_statuses[]" class="form-control js-select2-custom" multiple required>@foreach($statuses as $status)<option value="{{ $status }}" @selected(in_array($status, $selectedStatuses, true))>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>@endforeach</select></div>
            </div>
            @if($errors->any())<div class="alert alert-danger mt-3 mb-0">{{ $errors->first() }}</div>@endif
            <div class="btn--container justify-content-end mt-3"><button class="btn btn--primary"><i class="tio-save mr-1"></i>{{ translate($editing ? 'messages.Update' : 'messages.Create') }}</button></div>
        </form>
    </div></div>

    <div class="card"><div class="card-header"><h5 class="card-title">{{ translate('messages.Configured Reasons') }} <span class="badge badge-soft-dark ml-1">{{ $reasons->total() }}</span></h5></div><div class="table-responsive"><table class="table table-borderless table-thead-bordered table-align-middle card-table"><thead class="thead-light"><tr><th>{{ translate('messages.Reason') }}</th><th>{{ translate('messages.Actor') }}</th><th>{{ translate('messages.Status Scope') }}</th><th>{{ translate('messages.Order') }}</th><th>{{ translate('messages.Status') }}</th><th class="text-center">{{ translate('messages.Action') }}</th></tr></thead><tbody>
        @forelse($reasons as $item)<tr><td><strong>{{ $item->title }}</strong><br><code>{{ $item->code }}</code></td><td><span class="badge badge-soft-info">{{ ucfirst($item->user_type) }}</span></td><td>@foreach($item->ride_statuses ?? [] as $status)<span class="badge badge-soft-secondary mr-1 mb-1">{{ ucfirst(str_replace('_', ' ', $status)) }}</span>@endforeach</td><td>{{ $item->display_order }}</td><td><form method="POST" action="{{ route('admin.ride-hailing.cancellation-reasons.status', $item) }}">@csrf @method('PUT')<label class="toggle-switch mb-0"><input type="checkbox" class="toggle-switch-input" onchange="this.form.submit()" @checked($item->status)><span class="toggle-switch-label"><span class="toggle-switch-indicator"></span></span></label></form></td><td><div class="btn--container justify-content-center"><a href="{{ route('admin.ride-hailing.cancellation-reasons.edit', $item) }}" class="btn btn-sm btn-outline-primary btn-icon"><i class="tio-edit"></i></a><form method="POST" action="{{ route('admin.ride-hailing.cancellation-reasons.destroy', $item) }}" onsubmit="return confirm('{{ translate('messages.Delete this cancellation reason? Historical Ride snapshots will remain available.') }}')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger btn-icon"><i class="tio-delete"></i></button></form></div></td></tr>@empty<tr><td colspan="6" class="text-center py-5">{{ translate('messages.No Ride cancellation reasons found.') }}</td></tr>@endforelse
        </tbody></table></div>@if($reasons->hasPages())<div class="card-footer">{{ $reasons->links() }}</div>@endif</div>
</div>
@endsection
