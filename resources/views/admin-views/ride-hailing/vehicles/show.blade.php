@extends('layouts.admin.app')

@section('title', translate('messages.Ride Vehicle Review'))

@section('content')
<div class="content container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div><h1 class="page-header-title"><span class="page-header-icon"><i class="tio-car"></i></span>{{ translate('messages.Ride Vehicle Review') }} #{{ $vehicle->id }}</h1><p class="text-muted mb-0">{{ $vehicle->registration_number }}</p></div>
        <a href="{{ route($routePrefix.'.index') }}" class="btn btn--reset"><i class="tio-back-ui mr-1"></i>{{ translate('messages.Back to List') }}</a>
    </div>

    @include('admin-views.ride-hailing.partials.alerts')

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-header"><h4 class="mb-0">{{ translate('messages.Verification Photos') }}</h4></div>
                <div class="card-body"><div class="row g-3">
                    @foreach(['Front' => $vehicle->front_image_full_url, 'Back' => $vehicle->back_image_full_url] as $label => $image)
                        <div class="col-md-6"><h5>{{ translate('messages.'.$label) }}</h5>@if($image)<a href="{{ $image }}" target="_blank" rel="noopener"><img src="{{ $image }}" alt="{{ $label }}" class="img-fluid rounded border" style="width:100%;height:260px;object-fit:cover"></a>@else<div class="border rounded p-5 text-center text-muted">{{ translate('messages.No image uploaded') }}</div>@endif</div>
                    @endforeach
                </div></div>
            </div>

            <div class="card mb-3">
                <div class="card-header"><h4 class="mb-0">{{ translate('messages.Vehicle Details') }}</h4></div>
                <div class="card-body"><div class="row">
                    @foreach(['Vehicle Type' => $vehicle->vehicleType?->name, 'Ride Category' => $vehicle->category?->name, 'Fuel Type' => ucfirst($vehicle->fuel_type), 'Make' => $vehicle->make, 'Model' => $vehicle->model, 'Model Year' => $vehicle->model_year ?: '-', 'Color' => $vehicle->color, 'Registration' => $vehicle->registration_number] as $label => $value)
                        <div class="col-sm-6 col-xl-4 mb-3"><small class="text-muted d-block">{{ translate('messages.'.$label) }}</small><strong>{{ $value ?: '-' }}</strong></div>
                    @endforeach
                </div></div>
            </div>

            <div class="card">
                <div class="card-header"><h4 class="mb-0">{{ translate('messages.Decision Audit') }}</h4></div>
                <div class="table-responsive"><table class="table table-borderless table-thead-bordered card-table">
                    <thead class="thead-light"><tr><th>{{ translate('messages.Date') }}</th><th>{{ translate('messages.Admin') }}</th><th>{{ translate('messages.Change') }}</th><th>{{ translate('messages.Note') }}</th></tr></thead>
                    <tbody>@forelse($vehicle->reviewAudits as $audit)<tr><td>{{ $audit->reviewed_at?->format('d M Y, h:i A') }}</td><td>{{ $audit->reviewer?->full_name ?? translate('messages.System') }}</td><td><span class="text-capitalize">{{ $audit->from_status }}</span> → <strong class="text-capitalize">{{ $audit->to_status }}</strong></td><td>{{ $audit->admin_note ?: '-' }}</td></tr>@empty<tr><td colspan="4" class="text-center text-muted p-4">{{ translate('messages.No review decisions recorded yet.') }}</td></tr>@endforelse</tbody>
                </table></div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center"><h4 class="mb-0">{{ translate('messages.Review Status') }}</h4><span class="badge badge-soft-{{ $vehicle->status === 'approved' ? 'success' : ($vehicle->status === 'rejected' ? 'danger' : 'warning') }}">{{ ucfirst($vehicle->status) }}</span></div>
                <div class="card-body">
                    <p class="text-muted">{{ translate('messages.Submitted') }} <strong>{{ $vehicle->created_at?->format('d M Y, h:i A') }}</strong></p>
                    @if($vehicle->reviewed_at)<p class="text-muted">{{ translate('messages.Last reviewed by') }} <strong>{{ $vehicle->reviewer?->full_name ?? translate('messages.System') }}</strong><br>{{ $vehicle->reviewed_at->format('d M Y, h:i A') }}</p>@endif
                    @if($vehicle->admin_note)<div class="alert alert-soft-secondary"><strong>{{ translate('messages.Current Admin Note') }}</strong><br>{{ $vehicle->admin_note }}</div>@endif
                    <form action="{{ route($routePrefix.'.decision', $vehicle) }}" method="post" class="mb-3">@csrf @method('PUT')<input type="hidden" name="decision" value="approved"><label class="input-label">{{ translate('messages.Approval Note') }} <small class="text-muted">({{ translate('messages.Optional') }})</small></label><textarea name="admin_note" class="form-control mb-3" maxlength="1000" rows="3">{{ old('decision') === 'approved' ? old('admin_note') : '' }}</textarea><button class="btn btn-success btn-block" onclick="return confirm('{{ translate('messages.Approve this ride vehicle?') }}')"><i class="tio-checkmark-circle mr-1"></i>{{ translate('messages.Approve Vehicle') }}</button></form>
                    <hr>
                    <form action="{{ route($routePrefix.'.decision', $vehicle) }}" method="post">@csrf @method('PUT')<input type="hidden" name="decision" value="rejected"><label class="input-label">{{ translate('messages.Rejection Note') }} <span class="text-danger">*</span></label><textarea name="admin_note" class="form-control mb-3" maxlength="1000" rows="3" required>{{ old('decision') === 'rejected' ? old('admin_note') : '' }}</textarea><button class="btn btn--danger btn-block" onclick="return confirm('{{ translate('messages.Reject this ride vehicle?') }}')"><i class="tio-clear-circle mr-1"></i>{{ translate('messages.Reject Vehicle') }}</button></form>
                    @if($vehicle->status === 'approved' && !$vehicle->is_active)<hr><form action="{{ route($routePrefix.'.activate', $vehicle) }}" method="post">@csrf @method('PUT')<button class="btn btn-outline-primary btn-block" onclick="return confirm('{{ translate('messages.Make this the rider active vehicle?') }}')">{{ translate('messages.Make Active Vehicle') }}</button></form>@endif
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h4 class="mb-0">{{ translate('messages.Rider Details') }}</h4></div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3"><img class="rounded-circle mr-3" width="56" height="56" style="object-fit:cover" src="{{ $vehicle->deliveryMan?->image_full_url }}" alt=""><div><strong>{{ $vehicle->deliveryMan?->full_name }}</strong><br><small class="text-muted">#{{ $vehicle->delivery_man_id }}</small></div></div>
                    @foreach(['Phone' => $vehicle->deliveryMan?->phone, 'Email' => $vehicle->deliveryMan?->email, 'Zone' => $vehicle->deliveryMan?->zone?->name, 'Application Status' => ucfirst($vehicle->deliveryMan?->application_status ?? '-'), 'Work Mode' => ucfirst($vehicle->deliveryMan?->work_mode ?? 'delivery'), 'Account Status' => $vehicle->deliveryMan?->status ? translate('messages.Active') : translate('messages.Inactive')] as $label => $value)<div class="mb-2"><small class="text-muted d-block">{{ translate('messages.'.$label) }}</small><strong>{{ $value ?: '-' }}</strong></div>@endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
