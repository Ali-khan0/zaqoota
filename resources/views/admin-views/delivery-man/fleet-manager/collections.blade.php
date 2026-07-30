@extends('layouts.admin.app')

@section('title', __('fleet_management.rider_payment_recoveries'))

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <h1 class="page-header-title">{{ __('fleet_management.rider_payment_recoveries') }}</h1>
            <p class="text-muted mb-0">{{ __('fleet_management.recoveries_intro') }}</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">{{ __('fleet_management.manager_recovery_accountability') }}</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-borderless mb-0">
                    <thead class="thead-light">
                    <tr>
                        <th>{{ __('fleet_management.fleet_manager') }}</th>
                        <th>{{ __('fleet_management.areas') }}</th>
                        <th>{{ __('fleet_management.assigned_riders') }}</th>
                        <th>{{ __('fleet_management.riders_with_due') }}</th>
                        <th>{{ __('fleet_management.rider_payable_balance') }}</th>
                        <th>{{ __('fleet_management.contact') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($recoveryManagers as $manager)
                        <tr class="{{ (float) $manager->rider_payable_balance > 0 ? 'table-warning' : '' }}">
                            <td>
                                <a href="{{ route('admin.users.delivery-man.fleet-manager.report', $manager->id) }}">
                                    {{ $manager->full_name }}
                                </a>
                            </td>
                            <td>{{ $manager->zones->pluck('name')->join(', ') }}</td>
                            <td>{{ $manager->riders_count }}</td>
                            <td>{{ $manager->riders_with_due_count }}</td>
                            <td><strong>{{ \App\CentralLogics\Helpers::format_currency($manager->rider_payable_balance) }}</strong></td>
                            <td>
                                <a class="btn btn-sm btn-outline-primary" href="tel:{{ $manager->phone }}">
                                    <i class="tio-call"></i> {{ $manager->phone }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-4">{{ __('fleet_management.no_fleet_managers') }}</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <form method="get" class="row w-100">
                    <div class="col-md-5 mb-2">
                        <select name="fleet_manager_id" class="form-control">
                            <option value="">{{ __('fleet_management.all_fleet_managers') }}</option>
                            @foreach($recoveryManagers as $manager)
                                <option value="{{ $manager->id }}" {{ (int) request('fleet_manager_id') === $manager->id ? 'selected' : '' }}>
                                    {{ $manager->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5 mb-2">
                        <select name="status" class="form-control">
                            <option value="">{{ __('fleet_management.all_statuses') }}</option>
                            @foreach(['pending', 'approved', 'rejected'] as $status)
                                <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                    {{ __('fleet_management.status_'.$status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <button class="btn btn--primary btn-block" type="submit">{{ __('fleet_management.filter') }}</button>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-borderless mb-0">
                    <thead class="thead-light">
                    <tr>
                        <th>{{ __('fleet_management.submitted') }}</th>
                        <th>{{ __('fleet_management.fleet_manager') }}</th>
                        <th>{{ __('fleet_management.rider') }}</th>
                        <th>{{ __('fleet_management.recovered_amount') }}</th>
                        <th>{{ __('fleet_management.current_payable_balance') }}</th>
                        <th>{{ __('fleet_management.due_before_after') }}</th>
                        <th>{{ __('fleet_management.method') }}</th>
                        <th>{{ __('fleet_management.status') }}</th>
                        <th>{{ __('fleet_management.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($collections as $collection)
                        <tr>
                            <td>{{ $collection->submitted_at }}</td>
                            <td>{{ $collection->fleetManager?->full_name }}</td>
                            <td>
                                {{ $collection->deliveryMan?->full_name }}
                                @if($collection->deliveryMan?->phone)
                                    <br>
                                    <a href="tel:{{ $collection->deliveryMan->phone }}">
                                        {{ $collection->deliveryMan->phone }}
                                    </a>
                                @endif
                            </td>
                            <td>{{ \App\CentralLogics\Helpers::format_currency($collection->amount) }}</td>
                            <td>
                                @php($currentPayable = max(0, (float) ($collection->deliveryMan?->wallet?->collected_cash ?? 0)))
                                @php($pendingAmount = max(0, (float) ($collection->deliveryMan?->pending_collection_amount ?? 0)))
                                <strong>{{ \App\CentralLogics\Helpers::format_currency($currentPayable) }}</strong>
                                @if($pendingAmount > 0)
                                    <br>
                                    <small class="text-warning">
                                        {{ __('fleet_management.pending_recovery_amount') }}:
                                        {{ \App\CentralLogics\Helpers::format_currency($pendingAmount) }}
                                    </small>
                                @endif
                            </td>
                            <td>
                                {{ \App\CentralLogics\Helpers::format_currency($collection->due_before) }}
                                /
                                {{ $collection->due_after === null ? '—' : \App\CentralLogics\Helpers::format_currency($collection->due_after) }}
                            </td>
                            <td>
                                {{ __('fleet_management.method_'.$collection->payment_method) }}
                                @if($collection->reference)<br><small>{{ $collection->reference }}</small>@endif
                                @if($collection->proof_file)
                                    <br>
                                    <a href="{{ route('admin.users.delivery-man.fleet-manager.collections.proof', $collection->id) }}"
                                       target="_blank" rel="noopener">{{ __('fleet_management.view_proof') }}</a>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-soft-{{ $collection->status === 'approved' ? 'success' : ($collection->status === 'rejected' ? 'danger' : 'warning') }}">
                                    {{ __('fleet_management.status_'.$collection->status) }}
                                </span>
                                @if($collection->rejection_reason)<br><small>{{ $collection->rejection_reason }}</small>@endif
                            </td>
                            <td>
                                @if($collection->status === 'pending')
                                    <form class="d-inline" method="post"
                                          action="{{ route('admin.users.delivery-man.fleet-manager.collections.approve', $collection->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-sm btn-outline-success" type="submit">{{ __('fleet_management.approve') }}</button>
                                    </form>
                                    <form class="mt-1" method="post"
                                          action="{{ route('admin.users.delivery-man.fleet-manager.collections.reject', $collection->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <input name="rejection_reason" class="form-control form-control-sm mb-1" required
                                               placeholder="{{ __('fleet_management.rejection_reason') }}">
                                        <button class="btn btn-sm btn-outline-danger" type="submit">{{ __('fleet_management.reject') }}</button>
                                    </form>
                                @else
                                    <small>{{ $collection->reviewer?->full_name }}<br>{{ $collection->reviewed_at }}</small>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center py-5">{{ __('fleet_management.no_payment_recoveries') }}</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            @if($collections->hasPages())
                <div class="card-footer">{{ $collections->withQueryString()->links() }}</div>
            @endif
        </div>
    </div>
@endsection
