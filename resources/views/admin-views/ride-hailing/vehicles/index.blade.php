@extends('layouts.admin.app')

@section('title', translate('messages.Ride Vehicles'))

@section('content')
<div class="content container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h1 class="page-header-title"><span class="page-header-icon"><i class="tio-car"></i></span>{{ translate('messages.Ride Vehicles') }} <span class="badge badge-soft-dark ml-2">{{ $vehicles->total() }}</span></h1>
        <a href="{{ route('admin.ride-hailing.vehicles.create') }}" class="btn btn--primary"><i class="tio-add mr-1"></i>{{ translate('messages.Register Vehicle') }}</a>
    </div>
    @include('admin-views.ride-hailing.partials.alerts')
    <div class="card">
        <div class="card-header"><form class="w-100"><div class="input-group"><input type="search" name="search" value="{{ $search }}" class="form-control" placeholder="{{ translate('messages.Search rider, phone, plate, make or model') }}"><div class="input-group-append"><button class="btn btn--primary"><i class="tio-search"></i></button></div></div></form></div>
        <div class="table-responsive"><table class="table table-hover table-borderless table-thead-bordered table-align-middle card-table">
            <thead class="thead-light"><tr><th>{{ translate('messages.Rider') }}</th><th>{{ translate('messages.Vehicle') }}</th><th>{{ translate('messages.Category') }}</th><th>{{ translate('messages.Registration') }}</th><th>{{ translate('messages.Fuel') }}</th><th>{{ translate('messages.Status') }}</th><th class="text-center">{{ translate('messages.Action') }}</th></tr></thead>
            <tbody>@forelse($vehicles as $vehicle)<tr>
                <td><strong>{{ $vehicle->deliveryMan?->full_name }}</strong><br><small class="text-muted">{{ $vehicle->deliveryMan?->phone }} · {{ ucfirst($vehicle->deliveryMan?->work_mode ?? 'delivery') }} mode</small></td>
                <td><strong>{{ $vehicle->make }} {{ $vehicle->model }}</strong><br><small class="text-muted">{{ $vehicle->model_year ?: '-' }} · {{ $vehicle->color }}</small></td>
                <td>{{ $vehicle->vehicleType?->name }}<br><small class="text-muted">{{ $vehicle->category?->name }}</small></td><td><strong>{{ $vehicle->registration_number }}</strong></td><td>{{ ucfirst($vehicle->fuel_type) }}</td>
                <td><span class="badge badge-soft-{{ $vehicle->status === 'approved' ? 'success' : ($vehicle->status === 'rejected' ? 'danger' : 'warning') }}">{{ ucfirst($vehicle->status) }}</span>@if($vehicle->is_active)<br><span class="badge badge-soft-primary mt-1">{{ translate('messages.Active Vehicle') }}</span>@endif</td>
                <td class="text-center"><div class="d-flex justify-content-center gap-1">
                    <form action="{{ route('admin.ride-hailing.vehicles.status', $vehicle) }}" method="post">@csrf @method('PUT')<select name="status" class="form-control form-control-sm" onchange="this.form.submit()">@foreach(\App\Models\RideVehicle::STATUSES as $status)<option value="{{ $status }}" @selected($vehicle->status === $status)>{{ ucfirst($status) }}</option>@endforeach</select></form>
                    @if($vehicle->status === 'approved' && !$vehicle->is_active)<form action="{{ route('admin.ride-hailing.vehicles.activate', $vehicle) }}" method="post">@csrf @method('PUT')<button class="btn btn-sm btn-outline-primary" title="{{ translate('messages.Make Active') }}"><i class="tio-checkmark-circle"></i></button></form>@endif
                </div></td>
            </tr>@empty<tr><td colspan="7"><div class="text-center p-5"><h5>{{ translate('messages.No ride vehicles found.') }}</h5></div></td></tr>@endforelse</tbody>
        </table></div>
        @if($vehicles->hasPages())<div class="card-footer">{{ $vehicles->links() }}</div>@endif
    </div>
</div>
@endsection
