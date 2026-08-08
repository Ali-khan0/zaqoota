@extends('layouts.admin.app')

@section('title', translate('messages.Ride Hailing Dashboard'))

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h1 class="page-header-title"><span class="page-header-icon"><i class="tio-taxi"></i></span>{{ translate('messages.Ride Hailing Dashboard') }}</h1>
                <p class="page-header-text mt-2 mb-0">{{ translate('messages.Manage ride vehicles, categories and zone pricing.') }}</p>
            </div>
            <a href="{{ route('admin.ride-hailing.vehicles.create') }}" class="btn btn--primary"><i class="tio-add mr-1"></i>{{ translate('messages.Register Vehicle') }}</a>
        </div>
    </div>

    <div class="row g-3">
        @foreach ([
            [translate('messages.Riders in Ride Mode'), $stats['ride_mode_riders'], 'tio-account-circle'],
            [translate('messages.Registered Vehicles'), $stats['registered_vehicles'], 'tio-car'],
            [translate('messages.Approved Vehicles'), $stats['approved_vehicles'], 'tio-checkmark-circle'],
            [translate('messages.Pending Approval'), $stats['pending_vehicles'], 'tio-time'],
            [translate('messages.Active Categories'), $stats['categories'], 'tio-category'],
            [translate('messages.Configured Zone Fares'), $stats['configured_fares'], 'tio-money'],
        ] as [$label, $value, $icon])
            <div class="col-sm-6 col-xl-4">
                <div class="card h-100">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div><p class="text-muted mb-2">{{ $label }}</p><h2 class="mb-0">{{ number_format($value) }}</h2></div>
                        <i class="{{ $icon }} fs-30 text-primary"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card mt-3">
        <div class="card-header"><h5 class="card-title">{{ translate('messages.Foundation Status') }}</h5></div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4"><strong>{{ translate('messages.Rider Work Mode') }}</strong><p class="text-muted mb-0 mt-1">{{ translate('messages.Riders receive either deliveries or ride requests, never both.') }}</p></div>
                <div class="col-md-4"><strong>{{ translate('messages.Vehicle Limit') }}</strong><p class="text-muted mb-0 mt-1">{{ translate('messages.Each rider can register up to two ride vehicles.') }}</p></div>
                <div class="col-md-4"><strong>{{ translate('messages.Fare Scope') }}</strong><p class="text-muted mb-0 mt-1">{{ translate('messages.Every fare is configured by zone and ride category.') }}</p></div>
            </div>
        </div>
    </div>
</div>
@endsection
