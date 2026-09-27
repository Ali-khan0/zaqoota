@extends('layouts.admin.app')

@section('title', translate('Queue Operations'))

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <h1 class="page-header-title mr-3">
                <span class="page-header-icon">
                    <img src="{{ asset('public/assets/admin/img/business.png') }}" class="w--26" alt="">
                </span>
                <span>{{ translate('Queue Operations') }}</span>
            </h1>
            @include('admin-views.business-settings.partials.nav-menu')
        </div>

        @if(in_array($queueConnection, ['sync', 'null', ''], true))
            <div class="alert alert-danger">
                <strong>{{ translate('Asynchronous processing is not operational.') }}</strong>
                {{ translate('The current queue connection is') }} <code>{{ $queueConnection ?: 'missing' }}</code>.
                {{ translate('Configure a durable queue such as database or redis and run a supervised worker.') }}
            </div>
        @endif

        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="card h-100"><div class="card-body">
                    <small class="text-muted">{{ translate('Connection') }}</small>
                    <h3 class="mb-0">{{ $queueConnection ?: translate('Missing') }}</h3>
                </div></div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card h-100"><div class="card-body">
                    <small class="text-muted">{{ translate('Worker / scheduler heartbeat') }}</small>
                    <h3 class="mb-1 text-{{ $heartbeatHealthy ? 'success' : 'danger' }}">
                        {{ $heartbeatHealthy ? translate('Working') : translate('Not confirmed') }}
                    </h3>
                    <small>{{ $heartbeatAt?->format('d M Y '.config('timeformat')) ?? translate('Never received') }}</small>
                </div></div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card h-100"><div class="card-body">
                    <small class="text-muted">{{ translate('Queued jobs') }}</small>
                    <h3 class="mb-1">{{ $queueCounts['total'] ?? '—' }}</h3>
                    @if($queueCounts)
                        <small>{{ translate('Ready') }} {{ $queueCounts['ready'] }} · {{ translate('Delayed') }} {{ $queueCounts['delayed'] }} · {{ translate('Reserved') }} {{ $queueCounts['reserved'] }}</small>
                    @else
                        <small>{{ translate('Counts are available for the database queue driver.') }}</small>
                    @endif
                </div></div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="card h-100"><div class="card-body">
                    <small class="text-muted">{{ translate('Failed jobs') }}</small>
                    <h3 class="mb-0">{{ $failedCount ?? '—' }}</h3>
                    @if($failedCount === null)<small>{{ translate('failed_jobs table is unavailable.') }}</small>@endif
                </div></div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div>
                    <h4 class="card-header-title">{{ translate('Worker heartbeat check') }}</h4>
                    <p class="text-muted mb-0">{{ translate('This submits a real queued job. A successful manual probe confirms the worker; automatic heartbeats confirm both the scheduler and worker.') }}</p>
                </div>
                <form action="{{ route('admin.business-settings.queue-operations.probe') }}" method="post">
                    @csrf
                    <button class="btn btn--primary" type="submit">{{ translate('Send heartbeat') }}</button>
                </form>
            </div>
        </div>

        <form action="{{ route('admin.business-settings.queue-operations.update') }}" method="post">
            @csrf
            <div class="card mb-4">
                <div class="card-header">
                    <div>
                        <h4 class="card-header-title">{{ translate('Queue process controls') }}</h4>
                        <p class="text-muted mb-0">{{ translate('Disabled processes reject queued executions and affect new jobs after saving. Core web requests continue normally.') }}</p>
                    </div>
                    <label class="toggle-switch toggle-switch-sm ml-auto mb-0">
                        <input type="checkbox" name="master_enabled" value="1" class="toggle-switch-input" {{ $masterEnabled ? 'checked' : '' }}>
                        <span class="toggle-switch-label"><span class="toggle-switch-indicator"></span></span>
                        <span class="ml-2">{{ translate('Master queue processing') }}</span>
                    </label>
                </div>
                <div class="table-responsive">
                    <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                        <thead class="thead-light">
                            <tr>
                                <th>{{ translate('Process') }}</th>
                                <th>{{ translate('Status') }}</th>
                                <th>{{ translate('Pending') }}</th>
                                <th>{{ translate('Processed') }}</th>
                                <th>{{ translate('Failures') }}</th>
                                <th>{{ translate('Last activity') }}</th>
                                <th>{{ translate('Enable') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($definitions as $key => $definition)
                                @php
                                    $status = $statuses->get($key);
                                    $enabled = $status?->enabled ?? true;
                                    $lastProcessedAt = $status?->last_processed_at;
                                    $lastFailedAt = $status?->last_failed_at;
                                    $latestActivity = collect([$lastProcessedAt, $lastFailedAt, $status?->last_skipped_at])->filter()->sortDesc()->first();
                                    $hasNewFailure = $lastFailedAt && (!$lastProcessedAt || $lastFailedAt->gt($lastProcessedAt));
                                    $state = !$masterEnabled || !$enabled ? 'disabled' : ($hasNewFailure ? 'failing' : ($heartbeatHealthy ? 'ready' : 'worker_unconfirmed'));
                                    $stateClass = match ($state) {
                                        'ready' => 'success',
                                        'failing' => 'danger',
                                        'disabled' => 'secondary',
                                        default => 'warning',
                                    };
                                @endphp
                                <tr>
                                    <td>
                                        <strong>{{ translate($definition['label']) }}</strong>
                                        <div class="text-muted text-wrap" style="max-width: 360px;">{{ translate($definition['description']) }}</div>
                                        @if($status?->last_error)<div class="text-danger text-wrap mt-1" style="max-width: 360px;">{{ $status->last_error }}</div>@endif
                                    </td>
                                    <td><span class="badge badge-soft-{{ $stateClass }}">{{ translate(str_replace('_', ' ', $state)) }}</span></td>
                                    <td>{{ $pendingByProcess->get($key, $queueConnection === 'database' ? 0 : '—') }}</td>
                                    <td>{{ $status?->processed_count ?? 0 }}</td>
                                    <td>{{ $status?->failed_count ?? 0 }}</td>
                                    <td>{{ $latestActivity?->format('d M Y '.config('timeformat')) ?? '—' }}</td>
                                    <td>
                                        <label class="toggle-switch toggle-switch-sm mb-0">
                                            <input type="checkbox" name="processes[]" value="{{ $key }}" class="toggle-switch-input" {{ $enabled ? 'checked' : '' }}>
                                            <span class="toggle-switch-label"><span class="toggle-switch-indicator"></span></span>
                                        </label>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn--primary">{{ translate('Save queue controls') }}</button>
                </div>
            </div>
        </form>

        <div class="card">
            <div class="card-header"><h4 class="card-header-title">{{ translate('Recent failed jobs') }}</h4></div>
            <div class="table-responsive">
                <table class="table table-borderless table-thead-bordered table-align-middle card-table">
                    <thead class="thead-light"><tr><th>{{ translate('Job') }}</th><th>{{ translate('Queue') }}</th><th>{{ translate('Failed at') }}</th><th>{{ translate('Error') }}</th></tr></thead>
                    <tbody>
                        @forelse($recentFailures as $failure)
                            <tr>
                                <td>{{ $failure->display_name }}</td>
                                <td>{{ $failure->queue }}</td>
                                <td>{{ $failure->failed_at }}</td>
                                <td class="text-wrap" style="max-width: 520px;">{{ \Illuminate\Support\Str::limit($failure->exception, 500) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-5 text-muted">{{ translate('No failed queue jobs were found.') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
