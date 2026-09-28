@php
    $dispatchDeliveries = $order->commerceNotificationDeliveries;
    $pushAccepted = $dispatchDeliveries->where('push_status', 'accepted')->count();
    $pushFailed = $dispatchDeliveries->where('push_status', 'failed')->count();
    $pushSuperseded = $dispatchDeliveries->where('push_status', 'superseded')->count();
@endphp

<div class="card mb-3 mb-lg-5">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
            <h4 class="card-header-title mb-1">{{ translate('Nearest-first dispatch monitor') }}</h4>
            <p class="text-muted mb-0">
                {{ translate('Shows the riders contacted for this order in nearest-first wave order.') }}
            </p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <span class="badge badge-soft-primary">{{ translate('Contacted') }}: {{ $dispatchDeliveries->count() }}</span>
            <span class="badge badge-soft-success">{{ translate('Push accepted') }}: {{ $pushAccepted }}</span>
            <span class="badge badge-soft-danger">{{ translate('Push failed') }}: {{ $pushFailed }}</span>
            <span class="badge badge-soft-secondary">{{ translate('Superseded') }}: {{ $pushSuperseded }}</span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
            <thead class="thead-light">
                <tr>
                    <th>{{ translate('Wave') }}</th>
                    <th>{{ translate('Deliveryman') }}</th>
                    <th>{{ translate('Pickup distance') }}</th>
                    <th>{{ translate('In-app') }}</th>
                    <th>{{ translate('Push status') }}</th>
                    <th>{{ translate('Attempts') }}</th>
                    <th>{{ translate('Last attempt') }}</th>
                    <th>{{ translate('Error') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dispatchDeliveries as $delivery)
                    @php
                        $statusClass = match ($delivery->push_status) {
                            'accepted' => 'success',
                            'failed' => 'danger',
                            'no_token' => 'warning',
                            'queued' => 'info',
                            'superseded' => 'secondary',
                            default => 'secondary',
                        };
                    @endphp
                    <tr>
                        <td>{{ $delivery->dispatch_wave ?? '—' }}</td>
                        <td>
                            @if($delivery->deliveryMan)
                                <strong>{{ trim($delivery->deliveryMan->f_name.' '.$delivery->deliveryMan->l_name) }}</strong>
                                <div class="text-muted">#{{ $delivery->delivery_man_id }}</div>
                            @else
                                <span class="text-muted">{{ translate('Deleted deliveryman') }} #{{ $delivery->delivery_man_id }}</span>
                            @endif
                        </td>
                        <td>
                            {{ $delivery->pickup_distance_meters === null
                                ? '—'
                                : number_format($delivery->pickup_distance_meters / 1000, 2).' km' }}
                        </td>
                        <td>
                            <span class="badge badge-soft-{{ $delivery->in_app_stored ? 'success' : 'secondary' }}">
                                {{ $delivery->in_app_stored ? translate('Stored') : translate('Not stored') }}
                            </span>
                        </td>
                        <td><span class="badge badge-soft-{{ $statusClass }}">{{ translate($delivery->push_status) }}</span></td>
                        <td>{{ $delivery->push_attempts }}</td>
                        <td>{{ $delivery->last_attempted_at?->format('d M Y '.config('timeformat')) ?? '—' }}</td>
                        <td class="text-wrap" style="min-width: 220px; max-width: 360px;">
                            {{ $delivery->last_error ?: '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            {{ translate('No rider dispatch has been recorded for this order yet.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
