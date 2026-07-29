@foreach($delivery_men as $key=>$dm)
<tr>
    <td>{{$key+1}}</td>
        <td>
            <a class="table-rest-info" href="{{route('admin.users.delivery-man.preview',[$dm['id']])}}">
                <img class="onerror-image" data-onerror-image="{{asset('public/assets/admin/img/160x160/img1.jpg')}}"
                src="{{ $dm['image_full_url'] }}"
                alt="{{$dm['f_name']}} {{$dm['l_name']}}">
                <div class="info">
                    <h5 class="text-hover-primary mb-0">{{$dm['f_name'].' '.$dm['l_name']}}</h5>
                    <span class="d-block text-body">
                        <span class="rating">
                        <i class="tio-star"></i> {{count($dm->rating)>0?number_format($dm->rating[0]->average, 1, '.', ' '):0}}
                        </span>
                    </span>
                </div>
            </a>
        </td>
    <td>
        <a class="deco-none" href="tel:{{$dm['phone']}}">{{$dm['phone']}}</a>
    </td>
    <td>
        @if($dm->zone)
        <label class="text--title font-medium mb-0">{{$dm->zone->name}}</label>
        @else
        <label class="text--title font-medium mb-0">{{translate('messages.zone_deleted')}}</label>
        @endif
    </td>
    <td>
        @php($rf = $dm->registrationFee)
        @if($rf && $rf->manual_confirmed)
            <span class="text--title font-medium">{{ \App\CentralLogics\Helpers::currency_symbol() }}{{ number_format($rf->manual_paid_amount, 2) }}</span>
        @elseif($rf)
            <span class="badge badge-soft-warning">{{ translate('messages.pending') }}</span>
        @else
            <span class="text-muted">—</span>
        @endif
    </td>
    <td>
        @if($rf ?? null)
            <span class="text--title font-medium">{{ \App\CentralLogics\Helpers::currency_symbol() }}{{ number_format($rf->wallet_remaining_due, 2) }}</span>
            @if($rf->completed_at)
                <span class="badge badge-soft-success ml-1">{{ translate('messages.completed') }}</span>
            @endif
        @else
            <span class="text-muted">—</span>
        @endif
    </td>
    <td>
        <a class="deco-none">{{count($dm['orders'])}}</a>
    </td>
    <td>
        <div>
            {{translate('messages.currently_assigned_orders')}} : {{$dm->current_orders}}
        </div>
        <div>
            {{translate('messages.active_status')}} :
            @if($dm->application_status == 'approved')
                @if($dm->active)
                <strong class="text-capitalize text-primary">{{translate('messages.online')}}</strong>
                @else
                <strong class="text-capitalize text-secondary">{{translate('messages.offline')}}</strong>
                @endif
            @elseif ($dm->application_status == 'denied')
                <strong class="text-capitalize text-danger">{{translate('messages.denied')}}</strong>
            @else
                <strong class="text-capitalize text-info">{{translate('messages.pending')}}</strong>
            @endif
        </div>
    </td>
    <td>
        <div class="btn--container justify-content-center">
            <a class="btn action-btn btn--primary btn-outline-primary" href="{{route('admin.users.delivery-man.edit',[$dm['id']])}}" title="{{translate('messages.edit')}}"><i class="tio-edit"></i>
                </a>
            <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:" data-id="delivery-man-{{$dm['id']}}" data-message="{{ translate('Want to remove this deliveryman ?') }}" title="{{translate('messages.delete')}}"><i class="tio-delete-outlined"></i>
            </a>
            <form action="{{route('admin.users.delivery-man.delete',[$dm['id']])}}" method="post" id="delivery-man-{{$dm['id']}}">
                @csrf @method('delete')
            </form>
        </div>
    </td>
</tr>
@endforeach
<script src="{{asset('public/assets/admin')}}/js/view-pages/common.js"></script>