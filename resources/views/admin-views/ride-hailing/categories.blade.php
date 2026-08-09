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
                    <form action="{{ route('admin.ride-hailing.categories.store') }}" method="post" enctype="multipart/form-data">@csrf
                        <div class="form-group"><label class="input-label">{{ translate('messages.Vehicle Type') }}</label><select name="ride_vehicle_type_id" class="form-control" required>@foreach($types as $type)<option value="{{ $type->id }}">{{ $type->name }}</option>@endforeach</select></div>
                        <div class="form-group"><label class="input-label">{{ translate('messages.Category Name') }}</label><input name="name" value="{{ old('name') }}" class="form-control" maxlength="100" placeholder="{{ translate('messages.Example: Economy') }}" required></div>
                        <div class="form-group"><label class="input-label">{{ translate('messages.Fuel Type') }}</label><select name="fuel_type" class="form-control"><option value="">{{ translate('messages.Any Fuel Type') }}</option>@foreach(\App\Models\RideVehicle::FUEL_TYPES as $fuel)<option value="{{ $fuel }}">{{ ucfirst($fuel) }}</option>@endforeach</select></div>
                        <div class="form-group"><label class="input-label">{{ translate('messages.Passenger Capacity') }}</label><input type="number" name="passenger_capacity" value="{{ old('passenger_capacity', 1) }}" min="1" max="12" class="form-control" required></div>
                        <div class="form-group"><label class="input-label">{{ translate('messages.Category Image') }}</label><input type="file" name="image" accept=".jpg,.jpeg,.png,.webp" class="form-control"><small class="text-muted">JPG, PNG or WebP · Max 5 MB</small></div>
                        <button class="btn btn--primary w-100">{{ translate('messages.Add Category') }}</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-header"><h5 class="card-title">{{ translate('messages.Vehicle Type Images') }}</h5></div>
                <div class="card-body"><div class="row">@foreach($types as $type)<div class="col-md-4 mb-3"><form action="{{ route('admin.ride-hailing.vehicle-types.image', $type) }}" method="post" enctype="multipart/form-data" class="border rounded p-3 h-100">@csrf
                    <div class="d-flex align-items-center mb-2">@if($type->image_url)<img src="{{ $type->image_url }}" alt="" width="48" height="48" class="rounded mr-2" style="object-fit:cover">@else<span class="bg-light rounded d-flex align-items-center justify-content-center mr-2" style="width:48px;height:48px"><i class="tio-car"></i></span>@endif<strong>{{ $type->name }}</strong></div>
                    <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp" class="form-control form-control-sm mb-2">
                    <div class="d-flex"><button class="btn btn-sm btn-outline-primary flex-grow-1">{{ translate('messages.Save Image') }}</button>@if($type->image)<button name="remove_image" value="1" class="btn btn-sm btn-outline-danger ml-2" title="{{ translate('messages.Remove') }}"><i class="tio-delete"></i></button>@endif</div>
                </form></div>@endforeach</div></div>
            </div>
            <div class="card">
                <div class="card-header"><h5 class="card-title">{{ translate('messages.Category List') }}</h5></div>
                <div class="table-responsive"><table class="table table-hover table-borderless table-thead-bordered table-align-middle card-table">
                    <thead class="thead-light"><tr><th>{{ translate('messages.Category') }}</th><th>{{ translate('messages.Vehicle Type') }}</th><th>{{ translate('messages.Fuel') }}</th><th>{{ translate('messages.Capacity') }}</th><th>{{ translate('messages.Vehicles') }}</th><th>{{ translate('messages.Image') }}</th><th>{{ translate('messages.Status') }}</th></tr></thead>
                    <tbody>@foreach($categories as $category)<tr>
                        <td><strong>{{ $category->name }}</strong></td><td>{{ $category->vehicleType->name }}</td><td>{{ $category->fuel_type ? ucfirst($category->fuel_type) : translate('messages.Any') }}</td><td>{{ $category->passenger_capacity }}</td><td>{{ $category->vehicles_count }}</td><td><form action="{{ route('admin.ride-hailing.categories.image', $category) }}" method="post" enctype="multipart/form-data" class="d-flex align-items-center">@csrf @if($category->image_url)<img src="{{ $category->image_url }}" alt="" width="40" height="40" class="rounded mr-2" style="object-fit:cover">@endif<input type="file" name="image" accept=".jpg,.jpeg,.png,.webp" class="form-control form-control-sm" style="width:145px"><button class="btn btn-sm btn-outline-primary ml-1"><i class="tio-save"></i></button>@if($category->image)<button name="remove_image" value="1" class="btn btn-sm btn-outline-danger ml-1"><i class="tio-delete"></i></button>@endif</form></td>
                        <td><form action="{{ route('admin.ride-hailing.categories.status', $category) }}" method="post">@csrf @method('PUT')<button class="btn btn-sm {{ $category->status ? 'btn-outline-success' : 'btn-outline-secondary' }}">{{ $category->status ? translate('messages.Active') : translate('messages.Inactive') }}</button></form></td>
                    </tr>@endforeach</tbody>
                </table></div>
            </div>
        </div>
    </div>
</div>
@endsection
