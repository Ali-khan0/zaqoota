@extends('layouts.admin.app')
@section('title', translate('Onboarding applications'))
@section('content')
<div class="content container-fluid">
    <h1 class="page-header-title mb-4">{{ translate('Onboarding applications') }}</h1>
    @if(\App\CentralLogics\Helpers::module_permission_check('settings'))<a class="btn btn-outline-primary mb-3" href="{{ route('admin.business-settings.ops.index') }}">{{ translate('Ops settings and email templates') }}</a>@endif
    <a class="btn btn--primary mb-3" href="{{ route('admin.users.onboarding-applications.data-queue') }}">{{ translate('Paid data-entry queue') }}</a>
    <div class="d-flex flex-wrap gap-2 mb-4">
        @foreach($counts as $status => $count)
            <a class="btn btn-outline-primary" href="{{ route('admin.users.onboarding-applications.index', ['status' => $status]) }}">{{ translate(str_replace('_', ' ', $status)) }} <span class="badge badge-light">{{ $count }}</span></a>
        @endforeach
    </div>
    <div class="card">
        <form class="card-body d-flex flex-wrap gap-2" method="get">
            <input class="form-control w-auto" name="search" value="{{ request('search') }}" placeholder="{{ translate('Reference, store, owner email or manager') }}">
            <select class="form-control w-auto" name="status"><option value="">{{ translate('All statuses') }}</option>
                @foreach(\App\Models\OnboardingApplication::STATUSES as $status)
                    @if($status !== 'draft')<option value="{{ $status }}" @selected(request('status') === $status)>{{ translate(str_replace('_', ' ', $status)) }}</option>@endif
                @endforeach
            </select>
            @if(request('manager_id'))<input type="hidden" name="manager_id" value="{{ request('manager_id') }}">@endif
            <button class="btn btn--primary">{{ translate('Filter') }}</button>
            <a class="btn btn--reset" href="{{ route('admin.users.onboarding-applications.index') }}">{{ translate('Reset') }}</a>
        </form>
        <div class="table-responsive"><table class="table table-align-middle card-table">
            <thead><tr><th>{{ translate('Reference') }}</th><th>{{ translate('Store') }}</th><th>{{ translate('Manager') }}</th><th>{{ translate('Status') }}</th><th>{{ translate('Invoice') }}</th></tr></thead>
            <tbody>@forelse($applications as $application)
                <tr><td><a href="{{ route('admin.users.onboarding-applications.show', $application->id) }}">{{ $application->reference }}</a></td><td>{{ $application->store_name }}<div class="small text-muted">{{ $application->zone_name_snapshot }}</div></td><td>{{ $application->manager_name_snapshot }}</td><td>{{ translate(str_replace('_', ' ', $application->status)) }}</td><td>{{ $application->invoice?->invoice_number ?? '—' }}<div>{{ $application->invoice?->display_status ?? '—' }}</div></td></tr>
            @empty<tr><td colspan="5" class="text-center">{{ translate('No applications found') }}</td></tr>@endforelse</tbody>
        </table></div>
        <div class="card-footer">{{ $applications->links() }}</div>
    </div>
</div>
@endsection
