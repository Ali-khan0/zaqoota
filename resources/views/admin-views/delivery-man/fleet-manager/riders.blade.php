@extends('layouts.admin.app')

@section('title', __('fleet_management.assigned_riders_for_manager', ['manager' => $fleetManager->full_name]))

@section('content')
    <div class="content container-fluid">
        <div class="page-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h1 class="page-header-title">
                    {{ __('fleet_management.assigned_riders_for_manager', ['manager' => $fleetManager->full_name]) }}
                </h1>
                <p class="text-muted mb-0">
                    {{ __('fleet_management.assigned_riders_intro') }}
                    @if($fleetManager->zones->isNotEmpty())
                        &middot; {{ $fleetManager->zones->pluck('name')->join(', ') }}
                    @endif
                </p>
            </div>
            <div>
                <a class="btn btn-outline-info"
                   href="{{ route('admin.users.delivery-man.fleet-manager.report', $fleetManager->id) }}">
                    <i class="tio-chart-bar-1"></i> {{ __('fleet_management.report') }}
                </a>
                <a class="btn btn-secondary"
                   href="{{ route('admin.users.delivery-man.fleet-manager.index') }}">
                    {{ __('fleet_management.back') }}
                </a>
            </div>
        </div>

        <div class="row mb-3">
            @foreach([
                [__('fleet_management.assigned_riders'), $summary['assigned'], 'primary', false],
                [__('fleet_management.riders_with_due'), $summary['with_due'], 'danger', false],
                [__('fleet_management.rider_payable_balance'), $summary['payable'], 'warning', true],
            ] as [$label, $value, $color, $currency])
                <div class="col-md-4 mb-2">
                    <div class="card h-100 border-left border-{{ $color }}">
                        <div class="card-body">
                            <small class="text-muted">{{ $label }}</small>
                            <h3 class="mb-0">
                                {{ $currency ? \App\CentralLogics\Helpers::format_currency($value) : $value }}
                            </h3>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="card">
            <div class="card-header">
                <form method="get" class="row w-100 align-items-end">
                    <div class="col-md-5 mb-2">
                        <label>{{ __('fleet_management.search') }}</label>
                        <input type="search"
                               name="search"
                               class="form-control"
                               value="{{ request('search') }}"
                               placeholder="{{ __('fleet_management.search_riders') }}">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label>{{ __('fleet_management.payment_due') }}</label>
                        <select name="due_status" class="form-control">
                            <option value="">{{ __('fleet_management.all_balances') }}</option>
                            <option value="with_due" @selected(request('due_status') === 'with_due')>
                                {{ __('fleet_management.with_outstanding_balance') }}
                            </option>
                            <option value="clear" @selected(request('due_status') === 'clear')>
                                {{ __('fleet_management.fully_paid') }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button class="btn btn--primary" type="submit">{{ __('fleet_management.filter') }}</button>
                        <a class="btn btn-light"
                           href="{{ route('admin.users.delivery-man.fleet-manager.riders', $fleetManager->id) }}">
                            {{ __('fleet_management.reset') }}
                        </a>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-borderless align-middle mb-0">
                    <thead class="thead-light">
                    <tr>
                        <th>{{ __('fleet_management.rider') }}</th>
                        <th>{{ __('fleet_management.area') }}</th>
                        <th>{{ __('fleet_management.contact') }}</th>
                        <th>{{ __('fleet_management.rider_account_status') }}</th>
                        <th>{{ __('fleet_management.payment_due') }}</th>
                        <th class="text-center">{{ __('fleet_management.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($riders as $rider)
                        @php($payable = max(0, (float) ($rider->wallet?->collected_cash ?? 0)))
                        <tr class="{{ $payable > 0 ? 'table-warning' : '' }}">
                            <td>
                                <a href="{{ route('admin.users.delivery-man.preview', $rider->id) }}">
                                    <strong>{{ $rider->full_name }}</strong>
                                </a>
                                <br><small class="text-muted">#{{ $rider->id }}</small>
                            </td>
                            <td>{{ $rider->zone?->name ?: '—' }}</td>
                            <td>
                                <a href="tel:{{ $rider->phone }}">{{ $rider->phone }}</a>
                                @if($rider->email)<br><small>{{ $rider->email }}</small>@endif
                            </td>
                            <td>
                                <span class="badge badge-soft-{{ $rider->status ? 'success' : 'danger' }}">
                                    {{ $rider->status ? __('fleet_management.active') : __('fleet_management.inactive') }}
                                </span>
                            </td>
                            <td>
                                <strong class="{{ $payable > 0 ? 'text-danger' : 'text-success' }}">
                                    {{ \App\CentralLogics\Helpers::format_currency($payable) }}
                                </strong>
                            </td>
                            <td class="text-center text-nowrap">
                                <a class="btn btn-sm btn-outline-primary"
                                   href="{{ route('admin.users.delivery-man.preview', $rider->id) }}">
                                    {{ __('fleet_management.view_profile') }}
                                </a>
                                <form method="post"
                                      action="{{ route('admin.users.delivery-man.fleet-manager.unassign', $rider->id) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('{{ __('fleet_management.unassign_rider_confirm') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">
                                        {{ __('fleet_management.unassign') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">{{ __('fleet_management.no_riders') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($riders->hasPages())
                <div class="card-footer">{{ $riders->links() }}</div>
            @endif
        </div>
    </div>
@endsection
