@extends('layouts.admin.app')

@php($editing = $fleetManager->exists)
@section('title', $editing ? __('fleet_management.edit_fleet_manager') : __('fleet_management.add_fleet_manager'))

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <h1 class="page-header-title">
                {{ $editing ? __('fleet_management.edit_fleet_manager') : __('fleet_management.add_fleet_manager') }}
            </h1>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="post"
              action="{{ $editing ? route('admin.users.delivery-man.fleet-manager.update', $fleetManager->id) : route('admin.users.delivery-man.fleet-manager.store') }}">
            @csrf
            @if($editing) @method('PUT') @endif

            <div class="card mb-3">
                <div class="card-header"><h5 class="mb-0">{{ __('fleet_management.account_information') }}</h5></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>{{ __('fleet_management.first_name') }} *</label>
                            <input name="f_name" class="form-control" required value="{{ old('f_name', $fleetManager->f_name) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>{{ __('fleet_management.last_name') }}</label>
                            <input name="l_name" class="form-control" value="{{ old('l_name', $fleetManager->l_name) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>{{ __('fleet_management.employee_id') }}</label>
                            <input name="employee_id" class="form-control" value="{{ old('employee_id', $fleetManager->employee_id) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>{{ __('fleet_management.phone') }} *</label>
                            <input name="phone" class="form-control" required value="{{ old('phone', $fleetManager->phone) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>{{ __('fleet_management.email') }}</label>
                            <input name="email" type="email" class="form-control" value="{{ old('email', $fleetManager->email) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>{{ __('fleet_management.password') }} {{ $editing ? '' : '*' }}</label>
                            <input name="password" type="password" class="form-control" {{ $editing ? '' : 'required' }}>
                            @if($editing)<small class="text-muted">{{ __('fleet_management.leave_password_blank') }}</small>@endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header"><h5 class="mb-0">{{ __('fleet_management.operational_scope') }}</h5></div>
                <div class="card-body">
                    @php($selectedZones = old('zone_ids', $fleetManager->exists ? $fleetManager->zones->pluck('id')->all() : []))
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>{{ __('fleet_management.assigned_areas') }} *</label>
                            <select name="zone_ids[]" class="form-control" multiple required size="6">
                                @foreach($zones as $zone)
                                    <option value="{{ $zone->id }}" {{ in_array($zone->id, $selectedZones) ? 'selected' : '' }}>
                                        {{ $zone->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">{{ __('fleet_management.multi_area_hint') }}</small>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>{{ __('fleet_management.primary_area') }}</label>
                            <select name="primary_zone_id" class="form-control">
                                <option value="">{{ __('fleet_management.use_first_selected_area') }}</option>
                                @foreach($zones as $zone)
                                    <option value="{{ $zone->id }}" {{ (int) old('primary_zone_id', $fleetManager->primary_zone_id) === $zone->id ? 'selected' : '' }}>
                                        {{ $zone->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>{{ __('fleet_management.rider_capacity') }} *</label>
                            <input name="rider_capacity" type="number" min="1" class="form-control" required
                                   value="{{ old('rider_capacity', $fleetManager->rider_capacity ?: 50) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>{{ __('fleet_management.shift_start') }}</label>
                            <input name="shift_start" type="time" class="form-control" value="{{ old('shift_start', $fleetManager->shift_start) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>{{ __('fleet_management.shift_end') }}</label>
                            <input name="shift_end" type="time" class="form-control" value="{{ old('shift_end', $fleetManager->shift_end) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>{{ __('fleet_management.joining_date') }}</label>
                            <input name="joining_date" type="date" class="form-control"
                                   value="{{ old('joining_date', optional($fleetManager->joining_date)->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>{{ __('fleet_management.contract_type') }}</label>
                            <select name="contract_type" class="form-control">
                                @foreach(['employee', 'contractor', 'external_fleet'] as $type)
                                    <option value="{{ $type }}" {{ old('contract_type', $fleetManager->contract_type ?: 'employee') === $type ? 'selected' : '' }}>
                                        {{ __('fleet_management.contract_'.$type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <input type="hidden" name="status" value="0">
                            <label class="d-block">
                                <input type="checkbox" name="status" value="1" {{ old('status', $fleetManager->exists ? $fleetManager->status : true) ? 'checked' : '' }}>
                                {{ __('fleet_management.active') }}
                            </label>
                            <input type="hidden" name="on_leave" value="0">
                            <label class="d-block">
                                <input type="checkbox" name="on_leave" value="1" {{ old('on_leave', $fleetManager->on_leave) ? 'checked' : '' }}>
                                {{ __('fleet_management.on_leave') }}
                            </label>
                        </div>
                        <div class="col-md-9 mb-3">
                            <label>{{ __('fleet_management.internal_notes') }}</label>
                            <textarea name="notes" class="form-control" rows="3">{{ old('notes', $fleetManager->notes) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <button class="btn btn--primary" type="submit">{{ __('fleet_management.save') }}</button>
            <a class="btn btn-secondary" href="{{ route('admin.users.delivery-man.fleet-manager.index') }}">{{ __('fleet_management.cancel') }}</a>
        </form>
    </div>
@endsection
