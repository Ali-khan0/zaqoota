@extends('layouts.admin.app')

@section('title', __('fleet_management.fleet_manager_report'))

@section('content')
    <div class="content container-fluid">
        <div class="page-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h1 class="page-header-title">{{ __('fleet_management.fleet_manager_report') }}</h1>
                <p class="text-muted mb-0">
                    {{ $fleetManager->full_name }} &middot; {{ number_format((float) $fleetManager->commission_percentage, 2) }}%
                </p>
            </div>
            <div>
                <a class="btn btn-outline-primary"
                   href="{{ route('admin.users.delivery-man.fleet-manager.edit', $fleetManager->id) }}">
                    <i class="tio-edit"></i> {{ __('fleet_management.edit') }}
                </a>
                <a class="btn btn-secondary"
                   href="{{ route('admin.users.delivery-man.fleet-manager.index') }}">
                    {{ __('fleet_management.back') }}
                </a>
            </div>
        </div>

        @php($wallet = $fleetManager->wallet)
        <div class="row mb-3">
            @foreach([
                [__('fleet_management.total_earned'), $wallet?->total_earning ?? 0, 'success'],
                [__('fleet_management.available_balance'), $wallet?->available_balance ?? 0, 'primary'],
                [__('fleet_management.pending_withdrawal'), $wallet?->pending_withdraw ?? 0, 'warning'],
                [__('fleet_management.total_withdrawn'), $wallet?->total_withdrawn ?? 0, 'info'],
                [__('fleet_management.rider_payable_balance'), $summary['rider_payable_balance'], 'danger'],
                [__('fleet_management.approved_recoveries'), $summary['approved_recoveries'], 'secondary'],
            ] as [$label, $value, $color])
                <div class="col-md-4 col-xl-2 mb-3">
                    <div class="card h-100 border-left border-{{ $color }}">
                        <div class="card-body">
                            <small class="text-muted">{{ $label }}</small>
                            <h4 class="mb-0">{{ \App\CentralLogics\Helpers::format_currency($value) }}</h4>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row mb-3">
            <div class="col-md-4 mb-2">
                <div class="card card-body">
                    <small class="text-muted">{{ __('fleet_management.assigned_riders') }}</small>
                    <h4>{{ $summary['riders'] }}</h4>
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <div class="card card-body">
                    <small class="text-muted">{{ __('fleet_management.riders_with_due') }}</small>
                    <h4>{{ $summary['riders_with_due'] }}</h4>
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <div class="card card-body">
                    <small class="text-muted">{{ __('fleet_management.commission_orders') }}</small>
                    <h4>{{ $summary['orders'] }}</h4>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="w-100">
                    <h5>{{ __('fleet_management.commission_earning_history') }}</h5>
                    <form method="get" class="row align-items-end">
                        <div class="col-md-3 mb-2">
                            <label>{{ __('fleet_management.search') }}</label>
                            <input type="search" name="search" class="form-control"
                                   value="{{ request('search') }}"
                                   placeholder="{{ __('fleet_management.search_order_or_rider') }}">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label>{{ __('fleet_management.status') }}</label>
                            <select name="status" class="form-control">
                                <option value="">{{ __('fleet_management.all_statuses') }}</option>
                                <option value="earned" @selected(request('status') === 'earned')>
                                    {{ __('fleet_management.earning_status_earned') }}
                                </option>
                                <option value="reversed" @selected(request('status') === 'reversed')>
                                    {{ __('fleet_management.earning_status_reversed') }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label>{{ __('fleet_management.from') }}</label>
                            <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label>{{ __('fleet_management.to') }}</label>
                            <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                        </div>
                        <div class="col-md-3 mb-2">
                            <button class="btn btn--primary" type="submit">{{ __('fleet_management.filter') }}</button>
                            <a class="btn btn-light"
                               href="{{ route('admin.users.delivery-man.fleet-manager.report', $fleetManager->id) }}">
                                {{ __('fleet_management.reset') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-borderless mb-0">
                    <thead class="thead-light">
                    <tr>
                        <th>{{ __('fleet_management.date') }}</th>
                        <th>{{ __('fleet_management.order') }}</th>
                        <th>{{ __('fleet_management.rider') }}</th>
                        <th>{{ __('fleet_management.delivery_amount') }}</th>
                        <th>{{ __('fleet_management.admin_commission_pool') }}</th>
                        <th>{{ __('fleet_management.commission') }}</th>
                        <th>{{ __('fleet_management.earned') }}</th>
                        <th>{{ __('fleet_management.status') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($earnings as $earning)
                        <tr>
                            <td>{{ $earning->created_at }}</td>
                            <td>#{{ $earning->order_id }}</td>
                            <td>
                                {{ $earning->deliveryMan?->full_name ?? __('fleet_management.deleted_rider') }}
                                @if($earning->deliveryMan?->phone)<br><small>{{ $earning->deliveryMan->phone }}</small>@endif
                            </td>
                            <td>{{ \App\CentralLogics\Helpers::format_currency($earning->delivery_amount) }}</td>
                            <td>{{ \App\CentralLogics\Helpers::format_currency($earning->admin_commission_amount) }}</td>
                            <td>{{ number_format((float) $earning->fleet_commission_percentage, 2) }}%</td>
                            <td>{{ \App\CentralLogics\Helpers::format_currency($earning->amount) }}</td>
                            <td>
                                <span class="badge badge-soft-{{ $earning->status === 'earned' ? 'success' : 'danger' }}">
                                    {{ __('fleet_management.earning_status_'.$earning->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">{{ __('fleet_management.no_commission_earnings') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            @if($earnings->hasPages())
                <div class="card-footer">{{ $earnings->withQueryString()->links() }}</div>
            @endif
        </div>
    </div>
@endsection
