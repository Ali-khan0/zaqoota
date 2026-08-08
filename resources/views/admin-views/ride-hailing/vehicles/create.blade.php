@extends('layouts.admin.app')

@section('title', translate('messages.Add Ride Vehicle'))

@section('content')
<div class="content container-fluid">
    <div class="page-header"><h1 class="page-header-title"><span class="page-header-icon"><i class="tio-car"></i></span>{{ translate('messages.Add Ride Vehicle') }}</h1></div>
    @include('admin-views.ride-hailing.partials.alerts')
    <form action="{{ route('admin.ride-hailing.vehicles.store') }}" method="post" enctype="multipart/form-data">@csrf
        <div class="card"><div class="card-header"><h5 class="card-title">{{ translate('messages.Rider and Vehicle Details') }}</h5></div><div class="card-body"><div class="row g-3">
            <div class="col-12"><label class="input-label">{{ translate('messages.Existing Rider Account') }}</label><select id="delivery_man_id" name="delivery_man_id" class="form-control" required></select><small class="text-muted">{{ translate('messages.Select an existing approved rider. This does not create a new rider account.') }} {{ translate('messages.Only riders with fewer than two ride vehicles appear.') }}</small></div>
            <div class="col-md-6"><label class="input-label">{{ translate('messages.Vehicle Type') }}</label><select id="ride_vehicle_type_id" name="ride_vehicle_type_id" class="form-control" required><option value="">{{ translate('messages.Select') }}</option>@foreach($types as $type)<option value="{{ $type->id }}">{{ $type->name }}</option>@endforeach</select></div>
            <div class="col-md-6"><label class="input-label">{{ translate('messages.Ride Category') }}</label><select id="ride_category_id" name="ride_category_id" class="form-control" required><option value="">{{ translate('messages.Select vehicle type first') }}</option>@foreach($types as $type)@foreach($type->categories as $category)<option class="category-option" data-type="{{ $type->id }}" data-fuel="{{ $category->fuel_type }}" value="{{ $category->id }}">{{ $category->name }}</option>@endforeach @endforeach</select></div>
            <div class="col-md-4"><label class="input-label">{{ translate('messages.Fuel Type') }}</label><select id="fuel_type" name="fuel_type" class="form-control" required>@foreach(\App\Models\RideVehicle::FUEL_TYPES as $fuel)<option value="{{ $fuel }}">{{ ucfirst($fuel) }}</option>@endforeach</select></div>
            <div class="col-md-4"><label class="input-label">{{ translate('messages.Make') }}</label><input name="make" value="{{ old('make') }}" class="form-control" placeholder="Toyota" required></div>
            <div class="col-md-4"><label class="input-label">{{ translate('messages.Model') }}</label><input name="model" value="{{ old('model') }}" class="form-control" placeholder="Corolla" required></div>
            <div class="col-md-3"><label class="input-label">{{ translate('messages.Model Year') }}</label><input type="number" name="model_year" value="{{ old('model_year') }}" min="1980" max="{{ now()->year + 1 }}" class="form-control"></div>
            <div class="col-md-3"><label class="input-label">{{ translate('messages.Color') }}</label><input name="color" value="{{ old('color') }}" class="form-control" required></div>
            <div class="col-md-3"><label class="input-label">{{ translate('messages.Registration Number') }}</label><input name="registration_number" value="{{ old('registration_number') }}" class="form-control text-uppercase" required></div>
            <div class="col-md-3"><label class="input-label">{{ translate('messages.Approval Status') }}</label><select name="status" class="form-control">@foreach(\App\Models\RideVehicle::STATUSES as $status)<option value="{{ $status }}">{{ ucfirst($status) }}</option>@endforeach</select></div>
            <div class="col-md-6"><label class="input-label">{{ translate('messages.Vehicle Front Photo') }}</label><input type="file" name="vehicle_front_image" class="form-control" accept="image/jpeg,image/png,image/webp" required></div>
            <div class="col-md-6"><label class="input-label">{{ translate('messages.Vehicle Back Photo') }}</label><input type="file" name="vehicle_back_image" class="form-control" accept="image/jpeg,image/png,image/webp" required></div>
            <div class="col-12"><label class="input-label">{{ translate('messages.Admin Note') }}</label><textarea name="admin_note" class="form-control" rows="3" maxlength="1000">{{ old('admin_note') }}</textarea></div>
        </div></div></div>
        <div class="btn--container justify-content-end mt-4"><a href="{{ route('admin.ride-hailing.vehicles.index') }}" class="btn btn--reset">{{ translate('messages.Cancel') }}</a><button class="btn btn--primary">{{ translate('messages.Add Ride Vehicle') }}</button></div>
    </form>
</div>
@endsection

@push('script_2')
<script>
"use strict";
$('#delivery_man_id').select2({ajax:{url:'{{ route('admin.ride-hailing.riders.search') }}',dataType:'json',delay:300,data:function(params){return {q:params.term};},processResults:function(data){return data;}},placeholder:'{{ translate('messages.Search rider name or phone') }}',minimumInputLength:1});
const allCategories = $('#ride_category_id .category-option').clone();
$('#ride_vehicle_type_id').on('change', function(){
    const type = $(this).val();
    $('#ride_category_id').empty().append('<option value="">{{ translate('messages.Select') }}</option>').append(allCategories.filter('[data-type="'+type+'"]')).val('');
});
$('#ride_category_id').on('change', function(){ const fuel = $(this).find(':selected').data('fuel'); if(fuel){ $('#fuel_type').val(fuel); } });
$('#ride_vehicle_type_id').trigger('change');
</script>
@endpush
