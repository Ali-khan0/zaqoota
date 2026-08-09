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
            <div class="card mt-3">
                <div class="card-header"><h5 class="card-title">{{ translate('messages.Customer Ride Capabilities') }}</h5></div>
                <div class="card-body">
                    <div class="row">
                        @foreach ([
                            ['customer_enabled', 'Customer Ride Booking', 'Show Ride in the customer app and permit new estimates and bookings.'],
                            ['customer_rebid_enabled', 'Customer Price Updates', 'Allow passengers to update their opening price before Captain selection.'],
                            ['offer_rejection_enabled', 'Individual Offer Rejection', 'Allow passengers to reject one pending Captain offer.'],
                            ['nearby_availability_enabled', 'Nearby Availability', 'Expose privacy-preserving Captain availability before booking.'],
                        ] as [$field, $label, $help])
                            <div class="col-lg-6 mb-3"><div class="border rounded p-3 h-100 d-flex justify-content-between align-items-start">
                                <div class="pr-3"><strong>{{ translate('messages.'.$label) }}</strong><div class="small text-muted mt-1">{{ translate('messages.'.$help) }}</div></div>
                                <label class="toggle-switch mb-0"><input type="checkbox" name="{{ $field }}" value="1" class="toggle-switch-input" @checked(old($field, $settings[$field]))><span class="toggle-switch-label"><span class="toggle-switch-indicator"></span></span></label>
                            </div></div>
                        @endforeach
                        <div class="col-lg-6"><div class="form-group"><label class="input-label">{{ translate('messages.Price Update Cooldown') }}</label><div class="input-group"><input type="number" min="5" max="300" name="customer_rebid_cooldown_seconds" class="form-control" value="{{ old('customer_rebid_cooldown_seconds', $settings['customer_rebid_cooldown_seconds']) }}" required><div class="input-group-append"><span class="input-group-text">sec</span></div></div></div></div>
                        <div class="col-lg-6"><div class="form-group"><label class="input-label">{{ translate('messages.Availability Refresh Time') }}</label><div class="input-group"><input type="number" min="10" max="300" name="nearby_refresh_seconds" class="form-control" value="{{ old('nearby_refresh_seconds', $settings['nearby_refresh_seconds']) }}" required><div class="input-group-append"><span class="input-group-text">sec</span></div></div></div></div>
                        <div class="col-lg-6"><div class="form-group"><label class="input-label">{{ translate('messages.Maximum Approximate Markers') }}</label><input type="number" min="0" max="20" name="nearby_marker_limit" class="form-control" value="{{ old('nearby_marker_limit', $settings['nearby_marker_limit']) }}" required></div></div>
                        <div class="col-lg-6"><div class="form-group"><label class="input-label">{{ translate('messages.Marker Coordinate Precision') }}</label><input type="number" min="1" max="3" name="nearby_marker_precision" class="form-control" value="{{ old('nearby_marker_precision', $settings['nearby_marker_precision']) }}" required><small class="text-muted">{{ translate('messages.Lower precision gives passengers less exact Captain positions.') }}</small></div></div>
                    </div>
                </div>
            </div>
            <div class="btn--container justify-content-end mt-4">
                <button type="reset" class="btn btn--reset">{{ translate('messages.Reset') }}</button>
                <button type="submit" class="btn btn--primary">{{ translate('messages.Save Information') }}</button>
            </div>
        </form>
        <div class="card mt-3">
            <div class="card-header"><h5 class="card-title">{{ translate('messages.Recent Setting Changes') }}</h5></div>
            <div class="table-responsive"><table class="table table-align-middle mb-0"><thead class="thead-light"><tr><th>{{ translate('messages.Setting') }}</th><th>{{ translate('messages.Previous') }}</th><th>{{ translate('messages.New') }}</th><th>{{ translate('messages.Admin') }}</th><th>{{ translate('messages.Time') }}</th></tr></thead><tbody>
                @forelse($settingAudits as $audit)<tr><td>{{ $audit->setting_key }}</td><td>{{ $audit->old_value ?? '-' }}</td><td>{{ $audit->new_value ?? '-' }}</td><td>#{{ $audit->admin_id ?? '-' }}</td><td>{{ $audit->created_at?->format('d M Y, h:i A') }}</td></tr>@empty<tr><td colspan="5" class="text-center text-muted py-4">{{ translate('messages.No setting changes recorded yet.') }}</td></tr>@endforelse
            </tbody></table></div>
        </div>
    </div>
@endsection
