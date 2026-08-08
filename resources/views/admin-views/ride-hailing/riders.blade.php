@extends('layouts.admin.app')

@section('title', translate('messages.Ride Riders'))

@section('content')
<div class="content container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h1 class="page-header-title"><span class="page-header-icon"><i class="tio-account-circle"></i></span>{{ translate('messages.Ride Riders') }}</h1>
            <p class="page-header-text mt-2 mb-0">{{ translate('messages.These are existing rider accounts shared with the delivery system.') }}</p>
        </div>
        <a href="{{ route('admin.ride-hailing.vehicles.create') }}" class="btn btn--primary"><i class="tio-add mr-1"></i>{{ translate('messages.Add Ride Vehicle') }}</a>
    </div>

    @include('admin-views.ride-hailing.partials.alerts')

    <div class="card">
        <div class="card-header border-0">
            <form class="w-100"><div class="row g-2">
                <div class="col-md-7"><input type="search" name="search" value="{{ $search }}" class="form-control" placeholder="{{ translate('messages.Search rider name, phone or email') }}"></div>
                <div class="col-md-3">
                    <select name="zone_id" class="form-control js-select2-custom" @disabled($adminZoneId)>
                        <option value="">{{ translate('messages.All_Zones') }}</option>
                        @foreach ($zones as $zone)
                            <option value="{{ $zone->id }}" @selected($zoneId === $zone->id)>{{ $zone->name }}</option>
                        @endforeach
                    </select>
                    @if ($adminZoneId)<input type="hidden" name="zone_id" value="{{ $adminZoneId }}">@endif
                </div>
                <div class="col-md-2"><button class="btn btn--primary w-100"><i class="tio-search mr-1"></i>{{ translate('messages.Filter') }}</button></div>
            </div></form>
        </div>
        <div class="table-responsive"><table class="table table-hover table-borderless table-thead-bordered table-align-middle card-table">
            <thead class="thead-light"><tr><th>{{ translate('messages.Rider') }}</th><th>{{ translate('messages.Work Mode') }}</th><th>{{ translate('messages.Ride Vehicles') }}</th><th>{{ translate('messages.Active Ride Vehicle') }}</th><th>{{ translate('messages.Account Status') }}</th></tr></thead>
            <tbody>@forelse($riders as $rider)<tr>
                <td><a href="{{ route('admin.users.delivery-man.preview', $rider->id) }}" class="font-weight-bold text-dark">{{ $rider->full_name }}</a><br><small class="text-muted">{{ $rider->phone }}{{ $rider->email ? ' · '.$rider->email : '' }}</small></td>
                <td><span class="badge badge-soft-{{ $rider->work_mode === 'ride' ? 'primary' : 'info' }}">{{ $rider->work_mode === 'ride' ? translate('messages.Ride Mode') : translate('messages.Delivery Mode') }}</span></td>
                <td><strong>{{ $rider->ride_vehicles_count }}/2</strong>@foreach($rider->rideVehicles as $vehicle)<br><small class="text-muted">{{ $vehicle->vehicleType?->name }} · {{ $vehicle->category?->name }} · {{ $vehicle->registration_number }}</small>@endforeach</td>
                <td>@if($rider->activeRideVehicle)<strong>{{ $rider->activeRideVehicle->make }} {{ $rider->activeRideVehicle->model }}</strong><br><small class="text-muted">{{ $rider->activeRideVehicle->category?->name }} · {{ $rider->activeRideVehicle->registration_number }}</small>@else<span class="text-muted">{{ translate('messages.No active ride vehicle') }}</span>@endif</td>
                <td><span class="badge badge-soft-{{ $rider->status && $rider->active ? 'success' : 'secondary' }}">{{ $rider->status && $rider->active ? translate('messages.Online') : translate('messages.Offline') }}</span></td>
            </tr>@empty<tr><td colspan="5"><div class="text-center p-5"><h5>{{ translate('messages.No riders found.') }}</h5></div></td></tr>@endforelse</tbody>
        </table></div>
        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span class="text-muted fs-12">{{ translate('messages.Total') }}: {{ $riders->total() }}</span>
            @if($riders->hasPages()){{ $riders->links() }}@endif
        </div>
    </div>
</div>
@endsection
