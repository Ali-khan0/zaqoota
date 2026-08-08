@extends('layouts.admin.app')

@section('title', translate('messages.Ride Operations'))

@section('content')
@php
    $statusMeta = [
        'searching' => ['Searching Captain', 'warning', 'tio-search'],
        'negotiating' => ['Offers Received', 'info', 'tio-money'],
        'rider_selected' => ['Captain Assigned', 'primary', 'tio-account-circle'],
        'captain_arriving' => ['Captain Coming', 'primary', 'tio-car'],
        'arrived' => ['Captain Arrived', 'success', 'tio-location-search'],
        'in_progress' => ['Ride In Progress', 'success', 'tio-taxi'],
        'completed' => ['Completed', 'success', 'tio-checkmark-circle'],
        'cancelled' => ['Cancelled', 'danger', 'tio-clear-circle'],
    ];
@endphp
<div class="content container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h1 class="page-header-title"><span class="page-header-icon"><i class="tio-taxi"></i></span>{{ translate('messages.Ride Operations') }}</h1>
            <p class="page-header-text mb-0">{{ translate('messages.Monitor current rides, Captain assignment, trip progress and payment status.') }}</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <label class="toggle-switch toggle-switch-sm mb-0" title="{{ translate('messages.Auto refresh every 15 seconds') }}">
                <input type="checkbox" class="toggle-switch-input" id="ride-auto-refresh">
                <span class="toggle-switch-label"><span class="toggle-switch-indicator"></span></span>
            </label>
            <span class="text-muted small">{{ translate('messages.Auto Refresh') }}</span>
            <a href="{{ request()->fullUrl() }}" class="btn btn-outline-primary btn-icon" title="{{ translate('messages.Refresh') }}"><i class="tio-refresh"></i></a>
        </div>
    </div>

    @include('admin-views.ride-hailing.partials.alerts')

    <div class="row g-2 mb-3">
        @foreach ([
            ['all', 'All Rides', $counts['all'], 'tio-format-points'],
            ['unassigned', 'Need Captain', $counts['unassigned'], 'tio-search'],
            ['active', 'Active Rides', $counts['active'], 'tio-taxi'],
            ['completed', 'Completed', $counts['completed'], 'tio-checkmark-circle'],
            ['cancelled', 'Cancelled', $counts['cancelled'], 'tio-clear-circle'],
        ] as [$key, $label, $value, $icon])
            <div class="col-6 col-md">
                <a href="{{ request()->fullUrlWithQuery(['status' => $key, 'page' => null]) }}" class="__dashboard-card-2 h-100 d-block {{ $status === $key ? 'border-primary' : '' }}">
                    <i class="{{ $icon }} text-primary" style="font-size: 28px"></i>
                    <h6 class="name">{{ translate("messages.{$label}") }}</h6>
                    <h3 class="count">{{ number_format($value) }}</h3>
                </a>
            </div>
        @endforeach
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.ride-hailing.rides.index') }}">
                <input type="hidden" name="status" value="{{ $status }}">
                <div class="row g-2 align-items-end">
                    <div class="col-lg-3"><label class="input-label">{{ translate('messages.Search') }}</label><input type="search" name="search" value="{{ $search }}" class="form-control" placeholder="{{ translate('messages.Ride number, customer, Captain or location') }}"></div>
                    @unless($adminZoneId)<div class="col-sm-6 col-lg-2"><label class="input-label">{{ translate('messages.Zone') }}</label><select name="zone_id" class="form-control js-select2-custom"><option value="">{{ translate('messages.All Zones') }}</option>@foreach($zones as $zone)<option value="{{ $zone->id }}" @selected($zoneId === $zone->id)>{{ $zone->name }}</option>@endforeach</select></div>@endunless
                    <div class="col-sm-6 col-lg-2"><label class="input-label">{{ translate('messages.Category') }}</label><select name="category_id" class="form-control js-select2-custom"><option value="">{{ translate('messages.All Categories') }}</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected($categoryId === $category->id)>{{ $category->name }}</option>@endforeach</select></div>
                    <div class="col-sm-6 col-lg-2"><label class="input-label">{{ translate('messages.Payment') }}</label><select name="payment_status" class="form-control"><option value="all">{{ translate('messages.All') }}</option>@foreach(['due', 'unpaid', 'pending', 'partially_paid', 'paid', 'not_required'] as $payment)<option value="{{ $payment }}" @selected($paymentStatus === $payment)>{{ ucfirst(str_replace('_', ' ', $payment)) }}</option>@endforeach</select></div>
                    <div class="col-sm-6 col-lg-1"><label class="input-label">{{ translate('messages.From') }}</label><input type="date" name="from" value="{{ $from?->format('Y-m-d') }}" class="form-control"></div>
                    <div class="col-sm-6 col-lg-1"><label class="input-label">{{ translate('messages.To') }}</label><input type="date" name="to" value="{{ $to?->format('Y-m-d') }}" class="form-control"></div>
                    <div class="col-sm-6 col-lg-1 d-flex gap-1"><button class="btn btn--primary btn-icon" title="{{ translate('messages.Filter') }}"><i class="tio-filter-list"></i></button><a href="{{ route('admin.ride-hailing.rides.index') }}" class="btn btn-outline-secondary btn-icon" title="{{ translate('messages.Reset') }}"><i class="tio-clear"></i></a></div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover table-borderless table-thead-bordered table-align-middle card-table">
                <thead class="thead-light"><tr><th>{{ translate('messages.Ride') }}</th><th>{{ translate('messages.Customer') }}</th><th>{{ translate('messages.Route') }}</th><th>{{ translate('messages.Captain') }}</th><th>{{ translate('messages.Fare') }}</th><th>{{ translate('messages.Ride Status') }}</th><th>{{ translate('messages.Payment') }}</th><th class="text-center">{{ translate('messages.Action') }}</th></tr></thead>
                <tbody>
                @forelse($rides as $ride)
                    @php($meta = $statusMeta[$ride->status] ?? [ucfirst(str_replace('_', ' ', $ride->status)), 'secondary', 'tio-time'])
                    <tr>
                        <td><a href="{{ route('admin.ride-hailing.rides.show', $ride) }}" class="font-weight-bold text-primary">{{ $ride->request_number }}</a><br><small class="text-muted">{{ $ride->created_at?->format('d M Y, h:i A') }}</small><br><span class="badge badge-soft-dark mt-1">{{ $ride->category?->name }}</span></td>
                        <td><strong>{{ trim(($ride->user?->f_name ?? '').' '.($ride->user?->l_name ?? '')) ?: '-' }}</strong><br><small class="text-muted">{{ $ride->user?->phone }}</small></td>
                        <td class="min--250"><div class="text-truncate" style="max-width:280px"><i class="tio-location-search text-success mr-1"></i>{{ $ride->pickup_address }}</div><div class="text-truncate text-muted mt-1" style="max-width:280px"><i class="tio-location-search text-danger mr-1"></i>{{ $ride->destination_address }}</div><small class="text-muted">{{ number_format($ride->distance_meters / 1000, 1) }} km · {{ max(1, round($ride->duration_seconds / 60)) }} min</small></td>
                        <td>@if($ride->deliveryMan)<a href="{{ route('admin.users.delivery-man.preview', $ride->delivery_man_id) }}" class="font-weight-bold">{{ $ride->deliveryMan->full_name }}</a><br><small class="text-muted">{{ $ride->rideVehicle?->registration_number }}</small>@else<span class="badge badge-soft-warning">{{ translate('messages.Not Assigned') }}</span>@endif</td>
                        <td><strong>{{ \App\CentralLogics\Helpers::format_currency($ride->final_accepted_fare ?? $ride->customer_offer) }}</strong><br><small class="text-muted">{{ translate('messages.Offer') }}: {{ \App\CentralLogics\Helpers::format_currency($ride->customer_offer) }}</small></td>
                        <td><span class="badge badge-soft-{{ $meta[1] }}"><i class="{{ $meta[2] }} mr-1"></i>{{ translate('messages.'.$meta[0]) }}</span>@if($ride->status === 'captain_arriving')<br><small class="text-primary">{{ translate('messages.The Captain is coming to pickup.') }}</small>@endif</td>
                        <td><span class="badge badge-soft-{{ $ride->payment_status === 'paid' ? 'success' : ($ride->payment_status === 'pending' ? 'warning' : 'secondary') }}">{{ ucfirst(str_replace('_', ' ', $ride->payment_status)) }}</span>@if($ride->final_payable_amount !== null)<br><small class="text-muted">{{ \App\CentralLogics\Helpers::format_currency($ride->final_payable_amount) }}</small>@endif</td>
                        <td class="text-center"><a href="{{ route('admin.ride-hailing.rides.show', $ride) }}" class="btn btn-sm btn-outline-primary btn-icon" title="{{ translate('messages.View Ride') }}"><i class="tio-visible-outlined"></i></a></td>
                    </tr>
                @empty
                    <tr><td colspan="8"><div class="text-center p-5"><i class="tio-taxi" style="font-size:42px"></i><h5 class="mt-3">{{ translate('messages.No rides found.') }}</h5></div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($rides->hasPages())<div class="card-footer">{{ $rides->links() }}</div>@endif
    </div>
</div>
@endsection

@push('script_2')
<script>
    $(function () {
        const toggle = $('#ride-auto-refresh');
        toggle.prop('checked', localStorage.getItem('rideAdminAutoRefresh') === '1');
        toggle.on('change', function () { localStorage.setItem('rideAdminAutoRefresh', this.checked ? '1' : '0'); });
        setInterval(function () { if (toggle.prop('checked')) window.location.reload(); }, 15000);
    });
</script>
@endpush
