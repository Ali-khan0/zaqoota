@extends('layouts.admin.app')

@section('title', translate('messages.Ride Vehicle Approval'))

@section('content')
<div class="content container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h1 class="page-header-title"><span class="page-header-icon"><i class="tio-car"></i></span>{{ translate('messages.Ride Vehicle Approval') }} <span class="badge badge-soft-dark ml-2">{{ $vehicles->total() }}</span></h1>
            <p class="text-muted mb-0">{{ translate('messages.Review rider and vehicle details before approving or rejecting.') }}</p>
        </div>
        <a href="{{ route($routePrefix.'.create') }}" class="btn btn--primary"><i class="tio-add mr-1"></i>{{ translate('messages.Add Ride Vehicle') }}</a>
    </div>

    @include('admin-views.ride-hailing.partials.alerts')

    <div class="row g-2 mb-3">
        @foreach(['pending' => 'warning', 'approved' => 'success', 'rejected' => 'danger'] as $filterStatus => $colour)
            <div class="col-md-4">
                <a class="card h-100 {{ $status === $filterStatus ? 'border-'.$colour : '' }}" href="{{ route($routePrefix.'.index', ['status' => $filterStatus]) }}">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <span class="text-capitalize font-weight-bold">{{ translate('messages.'.ucfirst($filterStatus)) }}</span>
                        <span class="badge badge-soft-{{ $colour }} badge-pill">{{ $statusCounts[$filterStatus] ?? 0 }}</span>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <div class="card">
        <div class="card-header border-0 pb-0">
            <form class="w-100" method="get">
                <div class="row g-2">
                    <div class="col-lg-4"><input type="search" name="search" value="{{ $search }}" class="form-control" placeholder="{{ translate('messages.Search rider, phone, plate, make or model') }}"></div>
                    <div class="col-sm-6 col-lg-2"><select name="status" class="form-control"><option value="all">{{ translate('messages.All Statuses') }}</option>@foreach(\App\Models\RideVehicle::STATUSES as $option)<option value="{{ $option }}" @selected($status === $option)>{{ ucfirst($option) }}</option>@endforeach</select></div>
                    <div class="col-sm-6 col-lg-2"><select name="vehicle_type_id" class="form-control"><option value="">{{ translate('messages.All Vehicle Types') }}</option>@foreach($types as $type)<option value="{{ $type->id }}" @selected($vehicleTypeId === $type->id)>{{ $type->name }}</option>@endforeach</select></div>
                    <div class="col-sm-6 col-lg-2"><select name="category_id" class="form-control"><option value="">{{ translate('messages.All Categories') }}</option>@foreach($types->flatMap->categories as $category)<option value="{{ $category->id }}" @selected($categoryId === $category->id)>{{ $category->name }}</option>@endforeach</select></div>
                    <div class="col-sm-6 col-lg-2"><select name="fuel_type" class="form-control"><option value="">{{ translate('messages.All Fuel Types') }}</option>@foreach(\App\Models\RideVehicle::FUEL_TYPES as $option)<option value="{{ $option }}" @selected($fuelType === $option)>{{ ucfirst($option) }}</option>@endforeach</select></div>
                    <div class="col-12 d-flex justify-content-end gap-2"><a href="{{ route($routePrefix.'.index') }}" class="btn btn--reset">{{ translate('messages.Reset') }}</a><button class="btn btn--primary"><i class="tio-filter-list mr-1"></i>{{ translate('messages.Filter') }}</button></div>
                </div>
            </form>
        </div>

        <div class="table-responsive mt-3"><table class="table table-hover table-borderless table-thead-bordered table-align-middle card-table">
            <thead class="thead-light"><tr><th>{{ translate('messages.Rider') }}</th><th>{{ translate('messages.Vehicle') }}</th><th>{{ translate('messages.Category') }}</th><th>{{ translate('messages.Registration') }}</th><th>{{ translate('messages.Status') }}</th><th>{{ translate('messages.Submitted') }}</th><th class="text-center">{{ translate('messages.Action') }}</th></tr></thead>
            <tbody>@forelse($vehicles as $vehicle)<tr>
                <td><strong>{{ $vehicle->deliveryMan?->full_name }}</strong><br><small class="text-muted">{{ $vehicle->deliveryMan?->phone }} · {{ ucfirst($vehicle->deliveryMan?->work_mode ?? 'delivery') }} mode</small></td>
                <td><strong>{{ $vehicle->make }} {{ $vehicle->model }}</strong><br><small class="text-muted">{{ $vehicle->model_year ?: '-' }} · {{ $vehicle->color }} · {{ ucfirst($vehicle->fuel_type) }}</small></td>
                <td>{{ $vehicle->vehicleType?->name }}<br><small class="text-muted">{{ $vehicle->category?->name }}</small></td><td><strong>{{ $vehicle->registration_number }}</strong></td>
                <td><span class="badge badge-soft-{{ $vehicle->status === 'approved' ? 'success' : ($vehicle->status === 'rejected' ? 'danger' : 'warning') }}">{{ ucfirst($vehicle->status) }}</span>@if($vehicle->is_active)<br><span class="badge badge-soft-primary mt-1">{{ translate('messages.Active Vehicle') }}</span>@endif</td>
                <td>{{ $vehicle->created_at?->format('d M Y') }}<br><small class="text-muted">{{ $vehicle->created_at?->format('h:i A') }}</small></td>
                <td class="text-center"><a href="{{ route($routePrefix.'.show', $vehicle) }}" class="btn action-btn btn--primary btn-outline-primary" title="{{ translate('messages.Review') }}"><i class="tio-visible-outlined"></i></a></td>
            </tr>@empty<tr><td colspan="7"><div class="text-center p-5"><h5>{{ translate('messages.No ride vehicles found.') }}</h5></div></td></tr>@endforelse</tbody>
        </table></div>
        @if($vehicles->hasPages())<div class="card-footer">{{ $vehicles->links() }}</div>@endif
    </div>
</div>
@endsection
