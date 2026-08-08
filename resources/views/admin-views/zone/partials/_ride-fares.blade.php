<div class="bg-opacity-primary-10 rounded py-2 px-3 mb-3 d-flex gap-2 align-items-center">
    <i class="tio-light-on theme-clr-dark fs-16"></i>
    <p class="m-0 fs-12">{{ translate('Configure the fare for every Ride Hailing vehicle category in this zone.') }}</p>
</div>

@forelse ($rideCategories as $category)
    @php($fare = $rideFares->get($category->id))
    <div class="border rounded p-3 mb-3">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
            <div>
                <h5 class="mb-1">{{ $category->name }}</h5>
                <span class="text-muted fs-12">{{ $category->vehicleType?->name }}{{ $category->fuel_type ? ' - '.ucfirst($category->fuel_type) : '' }}</span>
            </div>
            <span class="badge badge-soft-{{ $fare ? 'success' : 'secondary' }}">
                {{ $fare ? translate('Configured') : translate('Not Configured') }}
            </span>
        </div>

        <div class="row g-3">
            @foreach ([
                'base_fare' => 'Base Fare',
                'minimum_fare' => 'Minimum Fare',
                'per_km_charge' => 'Per Kilometre',
                'per_minute_charge' => 'Per Minute',
                'pickup_distance_charge' => 'Pickup Distance Charge',
                'waiting_charge_per_minute' => 'Waiting Per Minute',
                'cancellation_charge' => 'Cancellation Charge',
            ] as $field => $label)
                <div class="col-sm-6 col-xl-3">
                    <label class="input-label">{{ translate($label) }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">{{ \App\CentralLogics\Helpers::currency_symbol() }}</span></div>
                        <input type="number" step="0.01" min="0" class="form-control"
                            name="ride_fares[{{ $category->id }}][{{ $field }}]"
                            value="{{ old("ride_fares.{$category->id}.{$field}", $fare?->{$field} ?? 0) }}">
                    </div>
                </div>
            @endforeach

            <div class="col-sm-6 col-xl-3">
                <label class="input-label">{{ translate('Platform Commission') }} (%)</label>
                <input type="number" step="0.01" min="0" max="100" class="form-control"
                    name="ride_fares[{{ $category->id }}][platform_commission_percent]"
                    value="{{ old("ride_fares.{$category->id}.platform_commission_percent", $fare?->platform_commission_percent ?? 0) }}">
            </div>
            <div class="col-sm-6 col-xl-3">
                <label class="input-label">{{ translate('Minimum Negotiated Fare') }} (%)</label>
                <input type="number" step="0.01" min="0" max="500" class="form-control"
                    name="ride_fares[{{ $category->id }}][negotiation_min_percent]"
                    value="{{ old("ride_fares.{$category->id}.negotiation_min_percent", $fare?->negotiation_min_percent ?? 100) }}">
            </div>
            <div class="col-sm-6 col-xl-3">
                <label class="input-label">{{ translate('Maximum Negotiated Fare') }} (%)</label>
                <input type="number" step="0.01" min="0" max="500" class="form-control"
                    name="ride_fares[{{ $category->id }}][negotiation_max_percent]"
                    value="{{ old("ride_fares.{$category->id}.negotiation_max_percent", $fare?->negotiation_max_percent ?? 100) }}">
            </div>
            <div class="col-sm-6 col-xl-3">
                <label class="input-label">{{ translate('Free Waiting') }} ({{ translate('Minutes') }})</label>
                <input type="number" step="1" min="0" max="60" class="form-control"
                    name="ride_fares[{{ $category->id }}][free_waiting_minutes]"
                    value="{{ old("ride_fares.{$category->id}.free_waiting_minutes", $fare?->free_waiting_minutes ?? 3) }}">
            </div>
            <div class="col-sm-6 col-xl-3">
                <label class="input-label">{{ translate('Offer Expiry') }} ({{ translate('Seconds') }})</label>
                <input type="number" step="1" min="10" max="300" class="form-control"
                    name="ride_fares[{{ $category->id }}][offer_expiry_seconds]"
                    value="{{ old("ride_fares.{$category->id}.offer_expiry_seconds", $fare?->offer_expiry_seconds ?? 30) }}">
            </div>
        </div>
    </div>
@empty
    <div class="alert alert-warning mb-0">{{ translate('Create at least one active Ride Hailing category before connecting this module.') }}</div>
@endforelse
