@extends('layouts.admin.app')
@section('title', translate('Paid onboarding data entry'))
@section('content')
<div class="content container-fluid">
    <h1 class="page-header-title mb-3">{{ translate('Paid onboarding data entry') }}</h1>
    <p>{{ translate('Only paid, non-void applications are shown. Open an application to claim work, complete store data and submit for review.') }}</p>
    <form class="d-flex flex-wrap gap-2 mb-3">
        <select class="form-control w-auto" name="stage">@foreach(['data_pending','data_entry','review_pending'] as $stage)<option value="{{ $stage }}" @selected(request('stage', 'data_pending') === $stage)>{{ translate(str_replace('_', ' ', $stage)) }}</option>@endforeach</select>
        <label class="m-2"><input type="checkbox" name="mine" value="1" @checked(request('mine'))> {{ translate('Assigned to me') }}</label>
        <button class="btn btn--primary">{{ translate('Filter') }}</button>
    </form>
    <div class="card"><div class="table-responsive"><table class="table card-table">
        <thead><tr><th>{{ translate('Application') }}</th><th>{{ translate('Store') }}</th><th>{{ translate('Assigned staff') }}</th><th>{{ translate('Payment') }}</th></tr></thead>
        <tbody>@forelse($applications as $application)<tr>
            <td><a href="{{ route('admin.users.onboarding-applications.show', $application->id) }}">{{ $application->reference }}</a></td>
            <td>{{ $application->store_name }} · {{ $application->zone_name_snapshot }}</td>
            <td>{{ $application->dataEntryStaff?->email ?? translate('Unassigned') }}</td>
            <td>{{ $application->invoice?->invoice_number }} · {{ translate('Paid') }}</td>
        </tr>@empty<tr><td colspan="4">{{ translate('No applications in this queue') }}</td></tr>@endforelse</tbody>
    </table></div><div class="card-footer">{{ $applications->links() }}</div></div>
</div>
@endsection
