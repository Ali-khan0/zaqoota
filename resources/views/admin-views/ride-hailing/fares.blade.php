@extends('layouts.admin.app')

@section('title', translate('messages.Zone Ride Pricing'))

@section('content')
<div class="content container-fluid">
    <div class="page-header"><h1 class="page-header-title"><span class="page-header-icon"><i class="tio-money"></i></span>{{ translate('messages.Zone Ride Pricing') }}</h1></div>
    @include('admin-views.ride-hailing.partials.alerts')
    <div class="card mb-3"><div class="card-body"><form method="get"><div class="row align-items-end"><div class="col-md-8"><label class="input-label">{{ translate('messages.Zone') }}</label><select name="zone_id" class="form-control" onchange="this.form.submit()">@foreach($zones as $zone)<option value="{{ $zone->id }}" @selected($zoneId === $zone->id)>{{ $zone->name }}</option>@endforeach</select></div><div class="col-md-4"><p class="text-muted mb-2">{{ translate('messages.Fares are saved independently for every zone and ride category.') }}</p></div></div></form></div></div>
    @if(!$zoneId)
        <div class="alert alert-warning">{{ translate('messages.Create an active zone before configuring ride fares.') }}</div>
    @else
    <form action="{{ route('admin.ride-hailing.fares.update') }}" method="post">@csrf @method('PUT')<input type="hidden" name="zone_id" value="{{ $zoneId }}">
        @foreach($categories as $category)
            @php($fare = $fares->get($category->id))
            <div class="card mb-3"><div class="card-header d-flex justify-content-between"><div><h5 class="card-title mb-1">{{ $category->name }}</h5><small class="text-muted">{{ $category->vehicleType->name }}{{ $category->fuel_type ? ' · '.ucfirst($category->fuel_type) : '' }}</small></div>@if($fare)<span class="badge badge-soft-success">{{ translate('messages.Configured') }}</span>@else<span class="badge badge-soft-secondary">{{ translate('messages.Not Configured') }}</span>@endif</div>
                <div class="card-body"><div class="row g-3">
                    @foreach ([
                        'base_fare' => 'Base Fare', 'minimum_fare' => 'Minimum Fare', 'per_km_charge' => 'Per Kilometre',
                        'per_minute_charge' => 'Per Minute', 'pickup_distance_charge' => 'Pickup Distance Charge',
                        'waiting_charge_per_minute' => 'Waiting Per Minute', 'cancellation_charge' => 'Cancellation Charge',
                    ] as $field => $label)
                        <div class="col-sm-6 col-xl-3"><label class="input-label">{{ translate('messages.'.$label) }}</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text">{{ \App\CentralLogics\Helpers::currency_symbol() }}</span></div><input type="number" step="0.01" min="0" name="fares[{{ $category->id }}][{{ $field }}]" value="{{ old("fares.{$category->id}.{$field}", $fare?->{$field} ?? 0) }}" class="form-control" required></div></div>
                    @endforeach
                    <div class="col-sm-6 col-xl-3"><label class="input-label">{{ translate('messages.Platform Commission') }} (%)</label><input type="number" step="0.01" min="0" max="100" name="fares[{{ $category->id }}][platform_commission_percent]" value="{{ old("fares.{$category->id}.platform_commission_percent", $fare?->platform_commission_percent ?? 0) }}" class="form-control" required></div>
                    <div class="col-sm-6 col-xl-3"><label class="input-label">{{ translate('messages.Minimum Negotiated Fare') }} (%)</label><input type="number" step="0.01" min="0" max="500" name="fares[{{ $category->id }}][negotiation_min_percent]" value="{{ old("fares.{$category->id}.negotiation_min_percent", $fare?->negotiation_min_percent ?? 100) }}" class="form-control" required><small class="text-muted">{{ translate('messages.Percentage of calculated fare') }}</small></div>
                    <div class="col-sm-6 col-xl-3"><label class="input-label">{{ translate('messages.Maximum Negotiated Fare') }} (%)</label><input type="number" step="0.01" min="0" max="500" name="fares[{{ $category->id }}][negotiation_max_percent]" value="{{ old("fares.{$category->id}.negotiation_max_percent", $fare?->negotiation_max_percent ?? 100) }}" class="form-control" required><small class="text-muted">{{ translate('messages.Percentage of calculated fare') }}</small></div>
                    <div class="col-sm-6 col-xl-3"><label class="input-label">{{ translate('messages.Surge Multiplier') }}</label><input type="number" step="0.01" min="1" max="10" name="fares[{{ $category->id }}][surge_multiplier]" value="{{ old("fares.{$category->id}.surge_multiplier", $fare?->surge_multiplier ?? 1) }}" class="form-control" required></div>
                    <div class="col-sm-6 col-xl-3 d-flex align-items-center"><label class="toggle-switch toggle-switch-sm"><input type="checkbox" name="fares[{{ $category->id }}][surge_enabled]" value="1" class="toggle-switch-input" @checked(old("fares.{$category->id}.surge_enabled", $fare?->surge_enabled ?? false))><span class="toggle-switch-label"><span class="toggle-switch-indicator"></span></span></label><span class="ml-2">{{ translate('messages.Enable Surge') }}</span></div>
                </div></div>
            </div>
        @endforeach
        <div class="btn--container justify-content-end"><button class="btn btn--primary">{{ translate('messages.Save Zone Fares') }}</button></div>
    </form>
    @endif
</div>
@endsection
