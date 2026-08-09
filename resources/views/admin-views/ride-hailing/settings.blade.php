@extends('layouts.admin.app')

@section('title', translate('messages.Ride Hailing Setup'))

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon"><i class="tio-car"></i></span>
                <span>{{ translate('messages.Ride Hailing Setup') }}</span>
            </h1>
        </div>

        @include('admin-views.ride-hailing.partials.alerts')

        <form action="{{ route('admin.ride-hailing.setup.update') }}" method="post">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ translate('messages.Basic Setup') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="input-label" for="service_name">{{ translate('messages.Service Name') }}</label>
                                <input id="service_name" name="service_name" class="form-control" maxlength="100"
                                    value="{{ old('service_name', $settings['service_name']) }}" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="input-label" for="maximum_pickup_radius_km">{{ translate('messages.Maximum Pickup Radius') }}</label>
                                <div class="input-group"><input id="maximum_pickup_radius_km" name="maximum_pickup_radius_km" type="number" min="1" max="200" step="0.1" class="form-control" value="{{ old('maximum_pickup_radius_km', $settings['maximum_pickup_radius_km']) }}" required><div class="input-group-append"><span class="input-group-text">km</span></div></div>
                                <small class="text-muted">{{ translate('messages.Only Captains inside this pickup radius can see and offer on a Ride.') }}</small>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="input-label" for="pickup_eta_speed_kmh">{{ translate('messages.Pickup ETA Average Speed') }}</label>
                                <div class="input-group"><input id="pickup_eta_speed_kmh" name="pickup_eta_speed_kmh" type="number" min="5" max="120" step="0.1" class="form-control" value="{{ old('pickup_eta_speed_kmh', $settings['pickup_eta_speed_kmh']) }}" required><div class="input-group-append"><span class="input-group-text">km/h</span></div></div>
                                <small class="text-muted">{{ translate('messages.Used to estimate pickup time; it does not change the passenger fare.') }}</small>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="input-label" for="distance_unit">{{ translate('messages.Distance Unit') }}</label>
                                <select id="distance_unit" name="distance_unit" class="form-control" required>
                                    <option value="km" @selected(old('distance_unit', $settings['distance_unit']) === 'km')>{{ translate('messages.Kilometres (km)') }}</option>
                                    <option value="mile" @selected(old('distance_unit', $settings['distance_unit']) === 'mile')>{{ translate('messages.Miles') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="input-label" for="support_email">{{ translate('messages.Support Email') }}</label>
                                <input id="support_email" name="support_email" type="email" class="form-control" maxlength="191"
                                    value="{{ old('support_email', $settings['support_email']) }}" placeholder="support@example.com">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="input-label" for="support_phone">{{ translate('messages.Support Phone') }}</label>
                                <input id="support_phone" name="support_phone" class="form-control" maxlength="30"
                                    value="{{ old('support_phone', $settings['support_phone']) }}" placeholder="+92 300 0000000">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn--container justify-content-end mt-4">
                <button type="reset" class="btn btn--reset">{{ translate('messages.Reset') }}</button>
                <button type="submit" class="btn btn--primary">{{ translate('messages.Save Information') }}</button>
            </div>
        </form>
    </div>
@endsection
