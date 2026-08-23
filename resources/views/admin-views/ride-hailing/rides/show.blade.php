@extends('layouts.admin.app')

@section('title', translate('messages.Ride Details'))

@section('content')
@php
    $statusLabels = [
        'searching' => 'Searching Captain', 'negotiating' => 'Offers Received',
        'rider_selected' => 'Captain Assigned', 'captain_arriving' => 'Captain Coming',
        'arrived' => 'Captain Arrived', 'in_progress' => 'Ride In Progress',
        'completed' => 'Completed', 'cancelled' => 'Cancelled',
    ];
@endphp
<div class="content container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div><a href="{{ route('admin.ride-hailing.rides.index') }}" class="text-muted"><i class="tio-back-ui mr-1"></i>{{ translate('messages.Ride Operations') }}</a><h1 class="page-header-title mt-2"><span class="page-header-icon"><i class="tio-taxi"></i></span>{{ $ride->request_number }}</h1></div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ request()->fullUrl() }}" class="btn btn-outline-primary btn-icon" title="{{ translate('messages.Refresh') }}"><i class="tio-refresh"></i></a>
            <span class="badge badge-soft-primary p-2"><i class="tio-time mr-1"></i>{{ translate('messages.'.($statusLabels[$ride->status] ?? ucfirst($ride->status))) }}</span>
        </div>
    </div>

    @include('admin-views.ride-hailing.partials.alerts')

    @if($ride->status === 'cancelled')
        @php
            $cancelActor = match($ride->cancelled_by) { 'customer' => translate('messages.Passenger'), 'captain' => translate('messages.Captain'), 'admin' => translate('messages.Zaqoota Admin'), default => ucfirst((string)$ride->cancelled_by) };
        @endphp
        <div class="alert alert-soft-danger mb-3">
            <div class="d-flex"><i class="tio-clear-circle mr-3 mt-1"></i><div><h5 class="mb-1">{{ translate('messages.Ride Cancelled by') }} {{ $cancelActor }}</h5><p class="mb-1">{{ $ride->cancellation_reason ?: translate('messages.No cancellation reason was provided.') }}</p><small>{{ translate('messages.Cancellation Charge') }}: <strong>{{ \App\CentralLogics\Helpers::format_currency($ride->cancellation_charge_amount) }}</strong> · {{ translate('messages.Payment Status') }}: <strong>{{ ucfirst(str_replace('_', ' ', $ride->payment_status)) }}</strong></small></div></div>
        </div>
    @endif

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card mb-3"><div class="card-header"><h5 class="card-title"><i class="tio-map mr-2"></i>{{ translate('messages.Route Details') }}</h5></div><div class="card-body">
                <div class="d-flex"><i class="tio-location-search text-success mt-1 mr-3"></i><div><strong>{{ translate('messages.Pickup') }}</strong><p class="mb-0 text-muted">{{ $ride->pickup_address }}</p><small>{{ $ride->pickup_latitude }}, {{ $ride->pickup_longitude }}</small></div></div>
                <div class="border-left ml-2 my-2" style="height:24px"></div>
                <div class="d-flex"><i class="tio-location-search text-danger mt-1 mr-3"></i><div><strong>{{ translate('messages.Destination') }}</strong><p class="mb-0 text-muted">{{ $ride->destination_address }}</p><small>{{ $ride->destination_latitude }}, {{ $ride->destination_longitude }}</small></div></div>
                <div class="row mt-3 pt-3 border-top"><div class="col-sm-4"><small class="text-muted d-block">{{ translate('messages.Distance') }}</small><strong>{{ number_format($ride->distance_meters / 1000, 2) }} km</strong></div><div class="col-sm-4"><small class="text-muted d-block">{{ translate('messages.Estimated Duration') }}</small><strong>{{ max(1, round($ride->duration_seconds / 60)) }} min</strong></div><div class="col-sm-4"><small class="text-muted d-block">{{ translate('messages.Zone / Category') }}</small><strong>{{ $ride->zone?->name }} / {{ $ride->category?->name }}</strong></div></div>
                @if($ride->location_updated_at)
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3 pt-3 border-top">
                        <div><small class="text-muted d-block">{{ translate('messages.Last Captain Location') }}</small><strong>{{ number_format($ride->current_latitude, 6) }}, {{ number_format($ride->current_longitude, 6) }}</strong><div class="small text-muted">{{ translate('messages.Updated') }} {{ $ride->location_updated_at->diffForHumans() }}</div></div>
                        <a href="https://www.google.com/maps?q={{ $ride->current_latitude }},{{ $ride->current_longitude }}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm"><i class="tio-map mr-1"></i>{{ translate('messages.View on Map') }}</a>
                    </div>
                @endif
            </div></div>

            <div class="card mb-3"><div class="card-header"><h5 class="card-title"><i class="tio-time mr-2"></i>{{ translate('messages.Ride Timeline') }}</h5></div><div class="card-body">
                @forelse($ride->statusHistories->sortByDesc('id') as $history)<div class="d-flex mb-3"><span class="badge badge-soft-primary mr-3" style="height:fit-content">{{ $history->created_at?->format('h:i A') }}</span><div><strong>{{ ucfirst(str_replace('_', ' ', $history->to_status)) }}</strong><div class="text-muted small">{{ ucfirst($history->actor_type) }} #{{ $history->actor_id ?: '-' }} · {{ $history->created_at?->format('d M Y') }}</div>@if($history->note)<div class="small mt-1">{{ $history->note }}</div>@endif</div></div>@empty<p class="text-muted mb-0">{{ translate('messages.No timeline events found.') }}</p>@endforelse
            </div></div>

            <div class="card"><div class="card-header"><h5 class="card-title"><i class="tio-money mr-2"></i>{{ translate('messages.Offers and Payments') }}</h5></div><div class="table-responsive"><table class="table table-align-middle mb-0"><thead class="thead-light"><tr><th>{{ translate('messages.Type') }}</th><th>{{ translate('messages.Person / Method') }}</th><th>{{ translate('messages.Amount') }}</th><th>{{ translate('messages.Status') }}</th><th>{{ translate('messages.Time') }}</th></tr></thead><tbody>
                @foreach($ride->offers->sortByDesc('id') as $offer)<tr><td>{{ translate('messages.Captain Offer') }}</td><td>{{ $offer->deliveryMan?->full_name }}</td><td>{{ \App\CentralLogics\Helpers::format_currency($offer->amount) }}</td><td><span class="badge badge-soft-{{ $offer->status === 'accepted' ? 'success' : ($offer->status === 'pending' ? 'warning' : 'secondary') }}">{{ ucfirst($offer->status) }}</span></td><td>{{ $offer->created_at?->format('d M, h:i A') }}</td></tr>@endforeach
                @foreach($ride->payments->sortByDesc('id') as $payment)<tr><td>{{ translate('messages.Payment') }}</td><td>{{ ucfirst($payment->payment_method) }}{{ $payment->payment_gateway ? ' · '.ucfirst(str_replace('_', ' ', $payment->payment_gateway)) : '' }}</td><td>{{ \App\CentralLogics\Helpers::format_currency($payment->amount) }}</td><td><span class="badge badge-soft-{{ $payment->status === 'paid' ? 'success' : ($payment->status === 'pending' ? 'warning' : 'danger') }}">{{ ucfirst($payment->status) }}</span></td><td>{{ $payment->created_at?->format('d M, h:i A') }}</td></tr>@endforeach
                @if($ride->offers->isEmpty() && $ride->payments->isEmpty())<tr><td colspan="5" class="text-center text-muted py-4">{{ translate('messages.No offers or payments yet.') }}</td></tr>@endif
            </tbody></table></div></div>
        </div>

        <div class="col-lg-4">
            @php
                $requestDeliveries = $ride->notificationDeliveries->where('event', 'ride_request_available');
                $acceptedPushes = $requestDeliveries->where('push_status', 'accepted')->count();
                $queuedPushes = $requestDeliveries->whereIn('push_status', ['pending', 'queued'])->count();
                $failedPushes = $requestDeliveries->where('push_status', 'failed')->count();
                $missingTokens = $requestDeliveries->where('push_status', 'no_token')->count();
                $inAppStored = $requestDeliveries->where('in_app_stored', true)->count();
            @endphp
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0"><i class="tio-notifications mr-2"></i>{{ translate('messages.Request Notification Delivery') }}</h5>
                    @if($requestDeliveries->isNotEmpty())
                        <span class="badge badge-soft-primary">{{ $requestDeliveries->count() }} {{ translate('messages.Captains') }}</span>
                    @endif
                </div>
                <div class="card-body">
                    @if($requestDeliveries->isEmpty())
                        <p class="text-muted mb-0">{{ translate('messages.No eligible Captain notification attempts were recorded for this Ride.') }}</p>
                    @else
                        <div class="row text-center mx-n1">
                            <div class="col-6 px-1 mb-2"><div class="bg-light rounded p-2"><strong class="d-block text-success">{{ $acceptedPushes }}</strong><small>{{ translate('messages.Firebase Accepted') }}</small></div></div>
                            <div class="col-6 px-1 mb-2"><div class="bg-light rounded p-2"><strong class="d-block text-primary">{{ $inAppStored }}</strong><small>{{ translate('messages.In-App Stored') }}</small></div></div>
                            <div class="col-6 px-1 mb-2"><div class="bg-light rounded p-2"><strong class="d-block text-warning">{{ $queuedPushes }}</strong><small>{{ translate('messages.Queued') }}</small></div></div>
                            <div class="col-6 px-1 mb-2"><div class="bg-light rounded p-2"><strong class="d-block text-danger">{{ $failedPushes }}</strong><small>{{ translate('messages.Failed') }}</small></div></div>
                            <div class="col-6 px-1"><div class="bg-light rounded p-2"><strong class="d-block text-warning">{{ $missingTokens }}</strong><small>{{ translate('messages.No Device Token') }}</small></div></div>
                        </div>
                        <p class="small text-muted mt-2 mb-0">{{ translate('messages.Firebase Accepted means Firebase accepted the push request; it is not a device-read receipt.') }}</p>
                    @endif
                    @if(in_array($ride->status, ['searching', 'negotiating'], true))
                        <form action="{{ route('admin.ride-hailing.rides.retry-request-notifications', $ride) }}" method="POST" class="mt-3">@csrf
                            <button class="btn btn-outline-primary btn-block" onclick="return confirm('{{ translate('messages.Retry notifications for Captains who are currently eligible and do not already have an accepted push?') }}')"><i class="tio-refresh mr-1"></i>{{ translate('messages.Retry Pending Notifications') }}</button>
                        </form>
                    @endif
                </div>
            </div>
            @if($ride->status !== 'cancelled' && $ride->status !== 'completed' && $ride->status !== 'in_progress')
            <div class="card mb-3"><div class="card-header"><h5 class="card-title"><i class="tio-clear-circle mr-2 text-danger"></i>{{ translate('messages.Cancel Ride') }}</h5></div><div class="card-body">
                <form action="{{ route('admin.ride-hailing.rides.cancel', $ride) }}" method="POST" onsubmit="return confirm('{{ translate('messages.Cancel this Ride and notify the passenger and Captain?') }}')">@csrf
                    <div class="form-group"><label class="input-label">{{ translate('messages.Cancellation Reason') }}</label><select name="cancellation_reason_id" class="form-control js-select2-custom" required><option value="">{{ translate('messages.Select cancellation reason') }}</option>@foreach($cancellationReasons as $reason)<option value="{{ $reason->id }}" @selected(old('cancellation_reason_id') == $reason->id)>{{ $reason->title }}</option>@endforeach</select>@error('cancellation_reason_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror</div>
                    <button class="btn btn-outline-danger btn-block"><i class="tio-clear-circle mr-1"></i>{{ translate('messages.Cancel Ride') }}</button>
                </form>
            </div></div>
            @endif
            @if(in_array($ride->status, ['searching', 'negotiating'], true))
            <div class="card mb-3"><div class="card-header"><h5 class="card-title"><i class="tio-account-circle mr-2"></i>{{ translate('messages.Assign Captain') }}</h5></div><div class="card-body">
                <form action="{{ route('admin.ride-hailing.rides.assign', $ride) }}" method="POST">@csrf
                    <div class="form-group"><label class="input-label">{{ translate('messages.Eligible Captain') }}</label><select name="delivery_man_id" class="form-control js-select2-custom" required><option value="">{{ translate('messages.Select Captain') }}</option>@foreach($eligibleCaptains as $captain)<option value="{{ $captain->id }}" @selected(old('delivery_man_id') == $captain->id)>{{ $captain->full_name }} · {{ $captain->phone }} · {{ $captain->activeRideVehicle?->registration_number }}</option>@endforeach</select>@error('delivery_man_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror</div>
                    <div class="form-group"><label class="input-label">{{ translate('messages.Final Fare') }}</label><input type="number" name="final_fare" step="0.01" min="{{ $ride->minimum_negotiated_fare }}" max="{{ $ride->maximum_negotiated_fare }}" value="{{ old('final_fare', $ride->customer_offer) }}" class="form-control" required><small class="text-muted">{{ translate('messages.Allowed range') }}: {{ \App\CentralLogics\Helpers::format_currency($ride->minimum_negotiated_fare) }} – {{ \App\CentralLogics\Helpers::format_currency($ride->maximum_negotiated_fare) }}</small>@error('final_fare')<div class="text-danger small mt-1">{{ $message }}</div>@enderror</div>
                    <button class="btn btn--primary btn-block" @disabled($eligibleCaptains->isEmpty())><i class="tio-checkmark-circle mr-1"></i>{{ translate('messages.Assign Captain') }}</button>
                    @if($eligibleCaptains->isEmpty())<p class="text-warning small mt-2 mb-0">{{ translate('messages.No eligible Captain is currently available in this zone and category.') }}</p>@endif
                </form>
            </div></div>
            @endif

            <div class="card mb-3"><div class="card-header"><h5 class="card-title">{{ translate('messages.Customer and Captain') }}</h5></div><div class="card-body">
                <small class="text-muted d-block">{{ translate('messages.Customer') }}</small><strong>{{ trim(($ride->user?->f_name ?? '').' '.($ride->user?->l_name ?? '')) ?: '-' }}</strong><div>{{ $ride->user?->phone }}</div><div>{{ $ride->user?->email }}</div>
                <hr><small class="text-muted d-block">{{ translate('messages.Captain') }}</small>@if($ride->deliveryMan)<a href="{{ route('admin.users.delivery-man.preview', $ride->delivery_man_id) }}" class="font-weight-bold">{{ $ride->deliveryMan->full_name }}</a><div>{{ $ride->deliveryMan->phone }}</div><div class="mt-2"><span class="badge badge-soft-primary">{{ $ride->rideVehicle?->make }} {{ $ride->rideVehicle?->model }}</span> <span class="badge badge-soft-dark">{{ $ride->rideVehicle?->registration_number }}</span></div>@else<span class="text-muted">{{ translate('messages.Not Assigned') }}</span>@endif
            </div></div>

            <div class="card mb-3"><div class="card-header"><h5 class="card-title">{{ translate('messages.Trip Times') }}</h5></div><div class="card-body">
                @foreach ([['Requested', $ride->created_at], ['Captain Assigned', $ride->selected_at], ['Captain Coming', $ride->captain_arriving_at], ['Captain Arrived', $ride->arrived_at], ['Ride Started', $ride->trip_started_at], ['Completed', $ride->completed_at], ['Cancelled', $ride->cancelled_at]] as [$label, $time])
                    @if($time)<div class="d-flex justify-content-between mb-2"><span class="text-muted">{{ translate('messages.'.$label) }}</span><strong>{{ $time->format('d M Y, h:i A') }}</strong></div>@endif
                @endforeach
            </div></div>

            <div class="card"><div class="card-header"><h5 class="card-title">{{ translate('messages.Fare and Payment') }}</h5></div><div class="card-body">
                @foreach ([['Customer Offer', $ride->customer_offer], ['Accepted Fare', $ride->final_accepted_fare], ['Waiting Charge', $ride->waiting_charge_amount], ['Cancellation Charge', $ride->cancellation_charge_amount], ['Previous Cancellation Due', $ride->carried_cancellation_due_amount], ['Coupon Discount', $ride->coupon_discount_amount], ['Final Payable', $ride->final_payable_amount], ['Wallet Paid', $ride->wallet_paid_amount], ['Remaining Due', $ride->payment_status === 'paid' ? 0 : max(0, (float) $ride->final_payable_amount - (float) $ride->wallet_paid_amount)], ['Zaqoota Commission', $ride->platform_commission_amount], ['Captain Earning', $ride->captain_total_earning_amount]] as [$label, $amount])
                    <div class="d-flex justify-content-between mb-2"><span class="text-muted">{{ translate('messages.'.$label) }}</span><strong>{{ $amount === null ? '-' : \App\CentralLogics\Helpers::format_currency($amount) }}</strong></div>
                @endforeach
                <hr><div class="d-flex justify-content-between"><span>{{ translate('messages.Payment Status') }}</span><span class="badge badge-soft-{{ $ride->payment_status === 'paid' ? 'success' : 'warning' }}">{{ ucfirst(str_replace('_', ' ', $ride->payment_status)) }}</span></div>@if($ride->receipt_number)<div class="d-flex justify-content-between mt-2"><span class="text-muted">{{ translate('messages.Receipt') }}</span><strong>{{ $ride->receipt_number }}</strong></div>@endif
            </div></div>
        </div>
    </div>
</div>
@endsection
