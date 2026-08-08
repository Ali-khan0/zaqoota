@extends('layouts.admin.app')

@section('title', translate('messages.Ride Hailing Dashboard'))

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center py-2">
            <div class="col-sm mb-2 mb-sm-0">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('public/assets/admin/img/how-it-works/ride-sharing.svg') }}" width="38" height="38" alt="Ride Hailing">
                    <div class="w-0 flex-grow pl-2">
                        <h1 class="page-header-title mb-0">{{ translate('messages.Ride Hailing Dashboard') }}.</h1>
                        <p class="page-header-text m-0">{{ translate('messages.Manage rides, riders, vehicles and fares by zone.') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-auto min--280">
                <form method="GET" action="{{ route('admin.ride-hailing.dashboard') }}">
                    <select name="zone_id" class="form-control js-select2-custom" onchange="this.form.submit()">
                        <option value="all">{{ translate('messages.All_Zones') }}</option>
                        @foreach ($zones as $zone)
                            <option value="{{ $zone->id }}" @selected($zoneId === $zone->id)>{{ $zone->name }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row g-2">
                @foreach ([
                    [translate('messages.Riders in Ride Mode'), $stats['ride_mode_riders'], 'public/assets/admin/img/icons/i-rider.png', route('admin.ride-hailing.riders.index')],
                    [translate('messages.Registered Vehicles'), $stats['registered_vehicles'], 'public/assets/admin/img/car_icon.svg', route('admin.ride-hailing.vehicles.index')],
                    [translate('messages.Approved Vehicles'), $stats['approved_vehicles'], 'public/assets/admin/img/campaign-approved.png', route('admin.ride-hailing.vehicles.index')],
                    [translate('messages.Pending Approval'), $stats['pending_vehicles'], 'public/assets/admin/img/transactions/pending.png', route('admin.ride-hailing.vehicles.index')],
                    [translate('messages.Active Categories'), $stats['categories'], 'public/assets/admin/img/category.png', route('admin.ride-hailing.categories.index')],
                    [translate('messages.Configured Zone Fares'), $stats['configured_fares'], 'public/assets/admin/img/money.png', route('admin.ride-hailing.fares.index')],
                ] as [$label, $value, $icon, $url])
                    <div class="col-sm-6 col-lg-4">
                        <a href="{{ $url }}" class="__dashboard-card-2 h-100 d-block">
                            <img src="{{ asset($icon) }}" alt="{{ $label }}">
                            <h6 class="name">{{ $label }}</h6>
                            <h3 class="count">{{ number_format($value) }}</h3>
                            <div class="subtxt">{{ $zoneId === 'all' ? translate('messages.All Zones') : $zones->firstWhere('id', $zoneId)?->name }}</div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header"><h5 class="card-title">{{ translate('messages.Foundation Status') }}</h5></div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4"><strong>{{ translate('messages.Rider Work Mode') }}</strong><p class="text-muted mb-0 mt-1">{{ translate('messages.Delivery mode receives food, grocery and parcel work. Ride mode receives rides and parcel work.') }}</p></div>
                <div class="col-md-4"><strong>{{ translate('messages.Vehicle Limit') }}</strong><p class="text-muted mb-0 mt-1">{{ translate('messages.Each rider can register up to two ride vehicles.') }}</p></div>
                <div class="col-md-4"><strong>{{ translate('messages.Fare Scope') }}</strong><p class="text-muted mb-0 mt-1">{{ translate('messages.Every fare is configured by zone and ride category.') }}</p></div>
            </div>
        </div>
    </div>
</div>
@endsection
