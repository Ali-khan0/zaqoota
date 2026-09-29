@if($type === 'ride')
    <div class="row g-3">
        <div class="col-md-6"><strong>{{ translate('Ride') }}:</strong> {{ $item->request_number }}</div>
        <div class="col-md-6"><strong>{{ translate('Status') }}:</strong> {{ ucwords(str_replace('_', ' ', $item->status)) }}</div>
        <div class="col-md-6"><strong>{{ translate('Customer') }}:</strong> {{ trim(($item->user?->f_name ?? '').' '.($item->user?->l_name ?? '')) ?: '—' }}</div>
        <div class="col-md-6"><strong>{{ translate('Captain') }}:</strong> {{ trim(($item->deliveryMan?->f_name ?? '').' '.($item->deliveryMan?->l_name ?? '')) ?: translate('Not assigned') }}</div>
        <div class="col-12"><strong>{{ translate('Pickup') }}:</strong> {{ $item->pickup_address }}</div>
        <div class="col-12"><strong>{{ translate('Destination') }}:</strong> {{ $item->destination_address }}</div>
        <div class="col-md-6"><strong>{{ translate('Fare') }}:</strong> {{ \App\CentralLogics\Helpers::format_currency($item->final_accepted_fare ?: $item->customer_offer) }}</div>
        <div class="col-md-6"><strong>{{ translate('Payment') }}:</strong> {{ ucwords(str_replace('_', ' ', $item->payment_status ?: 'pending')) }}</div>
    </div>
@else
    <div class="row g-3">
        <div class="col-md-6"><strong>{{ translate('Order') }}:</strong> #{{ $item->id }}</div>
        <div class="col-md-6"><strong>{{ translate('Status') }}:</strong> {{ ucwords(str_replace('_', ' ', $item->order_status)) }}</div>
        <div class="col-md-6"><strong>{{ translate('Customer') }}:</strong> {{ trim(($item->customer?->f_name ?? '').' '.($item->customer?->l_name ?? '')) ?: translate('Guest') }}</div>
        <div class="col-md-6"><strong>{{ translate('Rider') }}:</strong> {{ trim(($item->delivery_man?->f_name ?? '').' '.($item->delivery_man?->l_name ?? '')) ?: translate('Not assigned') }}</div>
        <div class="col-md-6"><strong>{{ translate('Store') }}:</strong> {{ $item->store?->name ?? translate('Parcel') }}</div>
        <div class="col-md-6"><strong>{{ translate('Zone') }}:</strong> {{ $item->zone?->name ?? '—' }}</div>
        <div class="col-md-6"><strong>{{ translate('Amount') }}:</strong> {{ \App\CentralLogics\Helpers::format_currency($item->order_amount) }}</div>
        <div class="col-md-6"><strong>{{ translate('Payment') }}:</strong> {{ ucwords(str_replace('_', ' ', $item->payment_method)) }}</div>
    </div>
@endif
