@extends('layouts.admin.app')

@section('title', translate('messages.Ride Notification Messages'))

@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <h1 class="page-header-title"><span class="page-header-icon"><i class="tio-message"></i></span>{{ translate('messages.Ride Notification Messages') }}</h1>
        <p class="page-header-text mb-0">{{ translate('messages.Configure condition-based messages separately for passengers and Captains.') }}</p>
    </div>

    @include('admin-views.ride-hailing.partials.alerts')

    <div class="alert {{ $firebaseReady ? 'alert-soft-success' : 'alert-soft-danger' }} mb-3">
        <div class="d-flex align-items-start">
            <i class="{{ $firebaseReady ? 'tio-checkmark-circle' : 'tio-warning' }} mr-2 mt-1"></i>
            <div>
                <strong>{{ translate($firebaseReady ? 'messages.Firebase push configuration is ready.' : 'messages.Firebase push configuration is incomplete.') }}</strong>
                <div class="small mt-1">{{ translate($firebaseReady ? 'messages.Push messages can be submitted to Firebase. Device delivery still depends on a valid Captain token and device permissions.' : 'messages.Upload a valid Firebase service-account configuration in Push Notification settings before enabling Ride push messages.') }}</div>
            </div>
        </div>
    </div>

    <div class="alert alert-soft-info mb-3">
        <strong>{{ translate('messages.Available Variables') }}:</strong>
        <code>{rideNumber}</code> <code>{passengerName}</code> <code>{captainName}</code> <code>{reason}</code>
        <code>{cancellationCharge}</code> <code>{pickupAddress}</code> <code>{finalFare}</code> <code>{captainEarning}</code>
    </div>

    <form method="POST" action="{{ route('admin.ride-hailing.notification-settings.update') }}">
        @csrf
        @method('PUT')
        <div class="row">
            @foreach($templates as $key => $template)
                <div class="col-xl-6 mb-3">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div><h5 class="card-title mb-1">{{ translate('messages.'.$template['label']) }}</h5><span class="badge badge-soft-{{ $template['audience'] === 'customer' ? 'info' : 'primary' }}">{{ translate($template['audience'] === 'customer' ? 'messages.Passenger' : ($template['audience'] === 'eligible_captains' ? 'messages.Eligible Captains' : 'messages.Captain')) }}</span></div>
                            <div class="d-flex align-items-center">
                                <label class="toggle-switch toggle-switch-sm mb-0 mr-2" title="{{ translate('messages.Push') }}"><input type="checkbox" name="templates[{{ $key }}][push_enabled]" value="1" class="toggle-switch-input" @checked(old("templates.$key.push_enabled", $template['push_enabled']))><span class="toggle-switch-label"><span class="toggle-switch-indicator"></span></span></label><small class="mr-3">{{ translate('messages.Push') }}</small>
                                <label class="toggle-switch toggle-switch-sm mb-0 mr-2" title="{{ translate('messages.In-App') }}"><input type="checkbox" name="templates[{{ $key }}][in_app_enabled]" value="1" class="toggle-switch-input" @checked(old("templates.$key.in_app_enabled", $template['in_app_enabled']))><span class="toggle-switch-label"><span class="toggle-switch-indicator"></span></span></label><small>{{ translate('messages.In-App') }}</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group"><label class="input-label">{{ translate('messages.Title') }}</label><input name="templates[{{ $key }}][title]" maxlength="191" class="form-control" required value="{{ old("templates.$key.title", $template['title']) }}">@error("templates.$key.title")<div class="text-danger small mt-1">{{ $message }}</div>@enderror</div>
                            <div class="form-group mb-0"><label class="input-label">{{ translate('messages.Message') }}</label><textarea name="templates[{{ $key }}][body]" maxlength="1000" rows="3" class="form-control" required>{{ old("templates.$key.body", $template['body']) }}</textarea>@error("templates.$key.body")<div class="text-danger small mt-1">{{ $message }}</div>@enderror</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="btn--container justify-content-end sticky-bottom bg-white py-3 border-top"><button class="btn btn--primary"><i class="tio-save mr-1"></i>{{ translate('messages.Save Notification Messages') }}</button></div>
    </form>
</div>
@endsection
