@extends('layouts.admin.app')

@php($editing = $fleetManager->exists)
@section('title', $editing ? translate('Edit fleet manager') : translate('Add fleet manager'))

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <h1 class="page-header-title">
                {{ $editing ? translate('Edit fleet manager') : translate('Add fleet manager') }}
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
                <div class="card-header"><h5 class="mb-0">{{ translate('Account information') }}</h5></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>{{ translate('First name') }} *</label>
                            <input name="f_name" class="form-control" required value="{{ old('f_name', $fleetManager->f_name) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>{{ translate('Last name') }}</label>
                            <input name="l_name" class="form-control" value="{{ old('l_name', $fleetManager->l_name) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>{{ translate('Employee ID') }}</label>
                            <input name="employee_id" class="form-control" value="{{ old('employee_id', $fleetManager->employee_id) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>{{ translate('Phone') }} *</label>
                            <input name="phone" class="form-control" required value="{{ old('phone', $fleetManager->phone) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>{{ translate('Email') }}</label>
                            <input name="email" type="email" class="form-control" value="{{ old('email', $fleetManager->email) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>{{ translate('Password') }} {{ $editing ? '' : '*' }}</label>
                            <input name="password" type="password" class="form-control" {{ $editing ? '' : 'required' }}>
                            @if($editing)<small class="text-muted">{{ translate('Leave empty to keep the current password.') }}</small>@endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header"><h5 class="mb-0">{{ translate('Operational scope') }}</h5></div>
                <div class="card-body">
                    @php($selectedZones = old('zone_ids', $fleetManager->exists ? $fleetManager->zones->pluck('id')->all() : []))
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>{{ translate('Assigned areas') }} *</label>
                            <select name="zone_ids[]" class="form-control" multiple required size="6">
                                @foreach($zones as $zone)
                                    <option value="{{ $zone->id }}" {{ in_array($zone->id, $selectedZones) ? 'selected' : '' }}>
                                        {{ $zone->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">{{ translate('Use Ctrl/Cmd to select multiple areas.') }}</small>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>{{ translate('Primary area') }}</label>
                            <select name="primary_zone_id" class="form-control">
                                <option value="">{{ translate('Use first selected area') }}</option>
                                @foreach($zones as $zone)
                                    <option value="{{ $zone->id }}" {{ (int) old('primary_zone_id', $fleetManager->primary_zone_id) === $zone->id ? 'selected' : '' }}>
                                        {{ $zone->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>{{ translate('Rider capacity') }} *</label>
                            <input name="rider_capacity" type="number" min="1" class="form-control" required
                                   value="{{ old('rider_capacity', $fleetManager->rider_capacity ?: 50) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>{{ translate('Shift start') }}</label>
                            <input name="shift_start" type="time" class="form-control" value="{{ old('shift_start', $fleetManager->shift_start) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>{{ translate('Shift end') }}</label>
                            <input name="shift_end" type="time" class="form-control" value="{{ old('shift_end', $fleetManager->shift_end) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>{{ translate('Joining date') }}</label>
                            <input name="joining_date" type="date" class="form-control"
                                   value="{{ old('joining_date', optional($fleetManager->joining_date)->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>{{ translate('Contract type') }}</label>
                            <select name="contract_type" class="form-control">
                                @foreach(['employee', 'contractor', 'external_fleet'] as $type)
                                    <option value="{{ $type }}" {{ old('contract_type', $fleetManager->contract_type ?: 'employee') === $type ? 'selected' : '' }}>
                                        {{ translate(str_replace('_', ' ', ucfirst($type))) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <input type="hidden" name="status" value="0">
                            <label class="d-block">
                                <input type="checkbox" name="status" value="1" {{ old('status', $fleetManager->exists ? $fleetManager->status : true) ? 'checked' : '' }}>
                                {{ translate('Active') }}
                            </label>
                            <input type="hidden" name="on_leave" value="0">
                            <label class="d-block">
                                <input type="checkbox" name="on_leave" value="1" {{ old('on_leave', $fleetManager->on_leave) ? 'checked' : '' }}>
                                {{ translate('On leave') }}
                            </label>
                        </div>
                        <div class="col-md-9 mb-3">
                            <label>{{ translate('Internal notes') }}</label>
                            <textarea name="notes" class="form-control" rows="3">{{ old('notes', $fleetManager->notes) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <button class="btn btn--primary" type="submit">{{ translate('Save') }}</button>
            <a class="btn btn-secondary" href="{{ route('admin.users.delivery-man.fleet-manager.index') }}">{{ translate('Cancel') }}</a>
        </form>
    </div>
@endsection
