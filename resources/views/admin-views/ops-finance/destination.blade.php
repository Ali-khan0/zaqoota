@extends('layouts.admin.app')
@section('title', translate('Payout destination'))
@section('content')
<div class="content container-fluid"><div class="card"><div class="card-body">
    <h1>{{ $record->reference }}</h1>
    <p>{{ translate('Use these saved details for this withdrawal. Access is recorded in the audit history.') }}</p>
    @foreach(['account_title', 'provider_name', 'account_number'] as $key)
        <p><strong>{{ translate(str_replace('_', ' ', $key)) }}:</strong> {{ $destination[$key] ?? '—' }}</p>
    @endforeach
    <a href="{{ route('admin.transactions.ops-finance.index') }}">{{ translate('Back to finance') }}</a>
</div></div></div>
@endsection
