@extends('layouts.admin.app')

@section('title', __('fleet_management.rider_payment_accountability'))

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <h1 class="page-header-title">{{ __('fleet_management.rider_payment_accountability') }}</h1>
            <p class="text-muted mb-0">{{ __('fleet_management.accountability_intro') }}</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <div class="w-100">
                    <h5 class="mb-3">{{ __('fleet_management.manager_recovery_accountability') }}</h5>
                    <form method="get" class="row align-items-end">
                        <div class="col-lg-3 col-md-6 mb-2">
                            <label>{{ __('fleet_management.search') }}</label>
                            <input type="search"
                                   name="search"
                                   class="form-control"
                                   value="{{ request('search') }}"
                                   placeholder="{{ __('fleet_management.search_manager_or_rider') }}">
                        </div>
                        <div class="col-lg-3 col-md-6 mb-2">
                            <label>{{ __('fleet_management.fleet_manager') }}</label>
                            <select name="fleet_manager_id" class="form-control">
                                <option value="">{{ __('fleet_management.all_fleet_managers') }}</option>
                                @foreach($managerOptions as $manager)
                                    <option value="{{ $manager->id }}" @selected((int) request('fleet_manager_id') === $manager->id)>
                                        {{ $manager->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-4 mb-2">
                            <label>{{ __('fleet_management.area') }}</label>
                            <select name="zone_id" class="form-control">
                                <option value="">{{ __('fleet_management.all_areas') }}</option>
                                @foreach($zones as $zone)
                                    <option value="{{ $zone->id }}" @selected((int) request('zone_id') === $zone->id)>
                                        {{ $zone->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-4 mb-2">
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
                        <div class="col-lg-2 col-md-4 mb-2">
                            <button class="btn btn--primary" type="submit">{{ __('fleet_management.filter') }}</button>
                            <a class="btn btn-light"
                               href="{{ route('admin.users.delivery-man.fleet-manager.collections') }}">
                                {{ __('fleet_management.reset') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-borderless align-middle mb-0">
                    <thead class="thead-light">
                    <tr>
                        <th>{{ __('fleet_management.fleet_manager') }}</th>
                        <th>{{ __('fleet_management.areas') }}</th>
                        <th>{{ __('fleet_management.assigned_riders') }}</th>
                        <th>{{ __('fleet_management.riders_with_due') }}</th>
                        <th>{{ __('fleet_management.riders_clear') }}</th>
                        <th>{{ __('fleet_management.rider_payable_balance') }}</th>
                        <th>{{ __('fleet_management.highest_rider_due') }}</th>
                        <th>{{ __('fleet_management.contact') }}</th>
                        <th class="text-center">{{ __('fleet_management.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($recoveryManagers as $manager)
                        @php($payable = max(0, (float) $manager->rider_payable_balance))
                        <tr class="{{ $payable > 0 ? 'table-warning' : '' }}">
                            <td>
                                <a href="{{ route('admin.users.delivery-man.fleet-manager.report', $manager->id) }}">
                                    <strong>{{ $manager->full_name }}</strong>
                                </a>
                                @if($manager->employee_id)
                                    <br><small class="text-muted">{{ $manager->employee_id }}</small>
                                @endif
                            </td>
                            <td>{{ $manager->zones->pluck('name')->join(', ') ?: '—' }}</td>
                            <td>{{ $manager->riders_count }}</td>
                            <td>
                                <span class="badge badge-soft-{{ $manager->riders_with_due_count > 0 ? 'danger' : 'success' }}">
                                    {{ $manager->riders_with_due_count }}
                                </span>
                            </td>
                            <td>{{ max(0, $manager->riders_count - $manager->riders_with_due_count) }}</td>
                            <td>
                                <strong class="{{ $payable > 0 ? 'text-danger' : 'text-success' }}">
                                    {{ \App\CentralLogics\Helpers::format_currency($payable) }}
                                </strong>
                            </td>
                            <td>{{ \App\CentralLogics\Helpers::format_currency(max(0, (float) $manager->highest_rider_payable)) }}</td>
                            <td>
                                <a href="tel:{{ $manager->phone }}">{{ $manager->phone }}</a>
                                @if($manager->email)<br><small>{{ $manager->email }}</small>@endif
                            </td>
                            <td class="text-center text-nowrap">
                                <a class="btn btn-sm btn-outline-primary"
                                   href="{{ route('admin.users.delivery-man.fleet-manager.riders', ['id' => $manager->id, 'due_status' => 'with_due']) }}">
                                    <i class="tio-group-senior"></i> {{ __('fleet_management.view_due_riders') }}
                                </a>
                                <a class="btn btn-sm btn-outline-secondary"
                                   href="{{ route('admin.users.delivery-man.fleet-manager.riders', $manager->id) }}">
                                    {{ __('fleet_management.view_all_riders') }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">{{ __('fleet_management.no_accountability_results') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($recoveryManagers->hasPages())
                <div class="card-footer">{{ $recoveryManagers->links() }}</div>
            @endif
        </div>
    </div>
@endsection
