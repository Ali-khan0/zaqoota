@extends('layouts.admin.app')
@section('title', $application->reference)
@section('content')
<div class="content container-fluid">
    <a href="{{ route('admin.users.onboarding-applications.index') }}">{{ translate('Back to applications') }}</a>
    <h1 class="page-header-title my-3">{{ $application->reference }} · {{ $application->store_name }}</h1>
    @if(session('review_success'))<div class="alert alert-success">{{ session('review_success') }}</div>@endif
    @if($errors->any())<div class="alert alert-danger">@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>@endif
    <div class="row">
        <div class="col-12">@include('admin-views.onboarding-application.data-entry')</div>
        <div class="col-md-6 mb-3"><div class="card h-100"><div class="card-body">
            <h3>{{ translate('Owner and store') }}</h3>
            <p>{{ $application->owner_first_name }} {{ $application->owner_last_name }} · {{ $application->owner_phone }}</p>
            <p>{{ $application->owner_email }}</p>
            <p>{{ $application->store_phone }} · {{ $application->store_email }}</p>
            <p>{{ $application->formatted_address }}</p>
            <p>{{ $application->latitude }}, {{ $application->longitude }} · {{ $application->zone_name_snapshot }}</p>
            <p>{{ $application->module_name_snapshot }} · {{ $application->delivery_time_min }}–{{ $application->delivery_time_max }} {{ $application->delivery_time_unit }}</p>
        </div></div></div>
        <div class="col-md-6 mb-3"><div class="card h-100"><div class="card-body">
            <h3>{{ translate('Manager and invoice') }}</h3>
            <p>{{ $application->manager_name_snapshot }} · {{ $application->manager_email_snapshot }}</p>
            <p>{{ translate('Commission') }}: {{ $application->commission_rate_snapshot }}% · {{ $application->currency }} {{ $application->commission_amount_snapshot }}</p>
            <p>{{ translate('Status') }}: {{ translate(str_replace('_', ' ', $application->status)) }}</p>
            @if($application->invoice)
                <p>{{ $application->invoice->invoice_number }} · {{ $application->currency }} {{ $application->invoice->amount }} · {{ $application->invoice->display_status }}</p>
                @if(\App\CentralLogics\Helpers::module_permission_check('report'))
                    <a class="btn btn--primary" href="{{ route('admin.transactions.onboarding-invoices.show', $application->invoice->id) }}">{{ translate('Invoice, payment and reminders') }}</a>
                @endif
            @endif
        </div></div></div>
    </div>
    <div class="card mb-3"><div class="card-body"><h3>{{ translate('Registration photos') }}</h3><div class="row">
        @forelse($application->media as $media)
            <div class="col-6 col-md-3 mb-3"><a target="_blank" rel="noopener" href="{{ route('admin.users.onboarding-applications.media', [$application->id, $media->id]) }}"><img loading="lazy" class="img-fluid rounded" style="height:160px;object-fit:contain" src="{{ route('admin.users.onboarding-applications.media', [$application->id, $media->id]) }}" alt="{{ $media->collection }}"></a><div>{{ translate(str_replace('_', ' ', $media->collection)) }}</div></div>
        @empty<p>{{ translate('No photos available') }}</p>@endforelse
    </div></div></div>
    @if(!in_array($application->status, ['approved', 'cancelled', 'refunded', 'rejected']) && \App\CentralLogics\Helpers::module_permission_check('report'))
        <form method="post" action="{{ route('admin.users.onboarding-applications.review', $application->id) }}" class="card mb-3">
            @csrf
            <div class="card-body"><h3>{{ translate('Review application') }}</h3>
                <p>{{ translate('Correction notes are visible to the manager. Data-entry corrections return to the paid data queue. Paid applications must use the invoice refund workflow before closure.') }}</p>
                <input type="hidden" name="expected_status" value="{{ $application->status }}">
                <label for="action">{{ translate('Action') }}</label>
                <select id="action" name="action" class="form-control mb-3"><option value="correction">{{ translate('Request correction') }}</option>@if($application->invoice?->payment_status === 'unpaid' && !$application->invoice?->voided_at)<option value="reject">{{ translate('Reject and void unpaid invoice') }}</option>@endif</select>
                <label for="note">{{ translate('Reason / required corrections') }}</label>
                <textarea id="note" name="note" class="form-control mb-3" required maxlength="2000">{{ old('note') }}</textarea>
                <button class="btn btn--primary">{{ translate('Save review') }}</button>
            </div>
        </form>
    @endif
    <div class="card mb-3"><div class="card-body"><h3>{{ translate('Status and review history') }}</h3>
        @forelse($history as $entry)<div class="border-bottom py-3"><strong>{{ $entry->from_status }} → {{ $entry->to_status }}</strong><p class="mb-1">{{ $entry->note }}</p><small>{{ $entry->actor_name }} · {{ $entry->created_at }}</small></div>@empty<p>{{ translate('No history') }}</p>@endforelse
        {{ $history->links() }}
    </div></div>
    <div class="card"><div class="card-body"><h3>{{ translate('Email and reminder history') }}</h3>
        @forelse($deliveries ?? [] as $entry)<div class="border-bottom py-3">{{ $entry->delivery_type }} · {{ $entry->recipient_email }} · {{ $entry->status }}<div class="small">{{ $entry->sent_by_name }} · {{ $entry->sent_at ?? $entry->last_attempt_at }}</div></div>@empty<p>{{ translate('No delivery attempts') }}</p>@endforelse
        @if($deliveries){{ $deliveries->links() }}@endif
    </div></div>
</div>
@endsection
