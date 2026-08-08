@extends('layouts.admin.app')

@section('title', translate('messages.Ride Categories'))

@section('content')
<div class="content container-fluid">
    <div class="page-header"><h1 class="page-header-title"><span class="page-header-icon"><i class="tio-category"></i></span>{{ translate('messages.Ride Categories') }}</h1></div>
    @include('admin-views.ride-hailing.partials.alerts')
    <div class="row g-3">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header"><h5 class="card-title">{{ translate('messages.Add Ride Category') }}</h5></div>
                <div class="card-body">
                    <form action="{{ route('admin.ride-hailing.categories.store') }}" method="post">@csrf
                        <div class="form-group"><label class="input-label">{{ translate('messages.Vehicle Type') }}</label><select name="ride_vehicle_type_id" class="form-control" required>@foreach($types as $type)<option value="{{ $type->id }}">{{ $type->name }}</option>@endforeach</select></div>
                        <div class="form-group"><label class="input-label">{{ translate('messages.Category Name') }}</label><input name="name" value="{{ old('name') }}" class="form-control" maxlength="100" placeholder="{{ translate('messages.Example: Economy') }}" required></div>
                        <div class="form-group"><label class="input-label">{{ translate('messages.Fuel Type') }}</label><select name="fuel_type" class="form-control"><option value="">{{ translate('messages.Any Fuel Type') }}</option>@foreach(\App\Models\RideVehicle::FUEL_TYPES as $fuel)<option value="{{ $fuel }}">{{ ucfirst($fuel) }}</option>@endforeach</select></div>
                        <div class="form-group"><label class="input-label">{{ translate('messages.Passenger Capacity') }}</label><input type="number" name="passenger_capacity" value="{{ old('passenger_capacity', 1) }}" min="1" max="12" class="form-control" required></div>
                        <button class="btn btn--primary w-100">{{ translate('messages.Add Category') }}</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header"><h5 class="card-title">{{ translate('messages.Category List') }}</h5></div>
                <div class="table-responsive"><table class="table table-hover table-borderless table-thead-bordered table-align-middle card-table">
                    <thead class="thead-light"><tr><th>{{ translate('messages.Category') }}</th><th>{{ translate('messages.Vehicle Type') }}</th><th>{{ translate('messages.Fuel') }}</th><th>{{ translate('messages.Capacity') }}</th><th>{{ translate('messages.Vehicles') }}</th><th>{{ translate('messages.Status') }}</th></tr></thead>
                    <tbody>@foreach($categories as $category)<tr>
                        <td><strong>{{ $category->name }}</strong></td><td>{{ $category->vehicleType->name }}</td><td>{{ $category->fuel_type ? ucfirst($category->fuel_type) : translate('messages.Any') }}</td><td>{{ $category->passenger_capacity }}</td><td>{{ $category->vehicles_count }}</td>
                        <td><form action="{{ route('admin.ride-hailing.categories.status', $category) }}" method="post">@csrf @method('PUT')<button class="btn btn-sm {{ $category->status ? 'btn-outline-success' : 'btn-outline-secondary' }}">{{ $category->status ? translate('messages.Active') : translate('messages.Inactive') }}</button></form></td>
                    </tr>@endforeach</tbody>
                </table></div>
            </div>
        </div>
    </div>
</div>
@endsection
