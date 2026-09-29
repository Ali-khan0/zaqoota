<div class="table-responsive">
    <table class="table table-borderless table-thead-bordered table-align-middle card-table mb-0">
        <thead class="thead-light">
        <tr>
            <th>{{ translate('ID') }}</th>
            <th>{{ translate('Customer') }}</th>
            <th>{{ translate('Pickup / Store') }}</th>
            <th>{{ translate('Status') }}</th>
            <th>{{ translate('Created') }}</th>
            <th class="text-center">{{ translate('Action') }}</th>
        </tr>
        </thead>
        <tbody>
        @forelse($items as $item)
            @php($isRide = $module === 'ride_hailing')
            <tr>
                <td>
                    <strong>{{ $isRide ? $item->request_number : '#'.$item->id }}</strong>
                    <small class="d-block text-muted">{{ ucwords(str_replace('_', ' ', $module)) }}</small>
                </td>
                <td>{{ trim(($item->user?->f_name ?? $item->customer?->f_name ?? '').' '.($item->user?->l_name ?? $item->customer?->l_name ?? '')) ?: translate('Guest') }}</td>
                <td>{{ $isRide ? \Illuminate\Support\Str::limit($item->pickup_address, 45) : ($item->store?->name ?? translate('Parcel pickup')) }}</td>
                <td><span class="badge badge-soft-info">{{ ucwords(str_replace('_', ' ', $isRide ? $item->status : $item->order_status)) }}</span></td>
                <td>{{ $item->created_at?->diffForHumans() }}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-primary dispatch-item-detail"
                            data-url="{{ route('admin.dispatch.item', ['type' => $isRide ? 'ride' : 'commerce', 'id' => $item->id]) }}">
                        {{ translate('View') }}
                    </button>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center py-5">{{ translate('No active requests found') }}</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

@if($items->hasPages())
    <div class="card-footer border-0 d-flex justify-content-end dispatch-feed-pagination">
        {{ $items->links() }}
    </div>
@endif
