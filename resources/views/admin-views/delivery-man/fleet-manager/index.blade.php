@extends('layouts.admin.app')

@section('title', __('fleet_management.fleet_managers'))

@section('content')
    <div class="content container-fluid">
        <div class="page-header d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-header-title">{{ __('fleet_management.fleet_managers') }}</h1>
                <p class="text-muted mb-0">{{ __('fleet_management.manage_rider_supervisors') }}</p>
            </div>
            <a href="{{ route('admin.users.delivery-man.fleet-manager.create') }}" class="btn btn--primary">
                <i class="tio-add"></i> {{ __('fleet_management.add_fleet_manager') }}
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <form class="w-100">
                    <div class="input-group">
                        <input type="search" name="search" class="form-control" value="{{ request('search') }}"
                               placeholder="{{ __('fleet_management.search_manager_placeholder') }}">
                        <div class="input-group-append">
                            <button class="btn btn--primary" type="submit">{{ __('fleet_management.search') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-borderless align-middle mb-0">
                    <thead class="thead-light">
                    <tr>
                        <th>{{ __('fleet_management.manager') }}</th>
                        <th>{{ __('fleet_management.areas') }}</th>
                        <th>{{ __('fleet_management.riders') }}</th>
                        <th>{{ __('fleet_management.commission') }}</th>
                        <th>{{ __('fleet_management.earned_available') }}</th>
                        <th>{{ __('fleet_management.shift') }}</th>
                        <th>{{ __('fleet_management.status') }}</th>
                        <th class="text-center">{{ __('fleet_management.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($fleetManagers as $manager)
                        <tr>
                            <td>
                                <strong>{{ $manager->full_name }}</strong>
                                <div class="text-muted">{{ $manager->phone }}</div>
                                @if($manager->employee_id)
                                    <small>{{ $manager->employee_id }}</small>
                                @endif
                            </td>
                            <td>
                                {{ $manager->zones->pluck('name')->join(', ') }}
                            </td>
                            <td>
                                <a href="{{ route('admin.users.delivery-man.fleet-manager.riders', $manager->id) }}">
                                    {{ $manager->riders_count }} / {{ $manager->rider_capacity }}
                                </a>
                            </td>
                            <td>{{ number_format((float) $manager->commission_percentage, 2) }}%</td>
                            <td>
                                <strong>{{ \App\CentralLogics\Helpers::format_currency($manager->wallet?->total_earning ?? 0) }}</strong>
                                <br>
                                <small>
                                    {{ __('fleet_management.available') }}:
                                    {{ \App\CentralLogics\Helpers::format_currency($manager->wallet?->available_balance ?? 0) }}
                                </small>
                            </td>
                            <td>
                                {{ $manager->shift_start ?: '—' }} – {{ $manager->shift_end ?: '—' }}
                            </td>
                            <td>
                                <span class="badge {{ $manager->status && !$manager->on_leave ? 'badge-soft-success' : 'badge-soft-danger' }}">
                                    {{ $manager->on_leave ? __('fleet_management.on_leave') : ($manager->status ? __('fleet_management.active') : __('fleet_management.inactive')) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a class="btn btn-sm btn-outline-secondary"
                                   href="{{ route('admin.users.delivery-man.fleet-manager.riders', $manager->id) }}">
                                    <i class="tio-group-senior"></i> {{ __('fleet_management.view_riders') }}
                                </a>
                                <a class="btn btn-sm btn-outline-info"
                                   href="{{ route('admin.users.delivery-man.fleet-manager.report', $manager->id) }}">
                                    <i class="tio-chart-bar-1"></i> {{ __('fleet_management.report') }}
                                </a>
                                <a class="btn btn-sm btn-outline-primary"
                                   href="{{ route('admin.users.delivery-man.fleet-manager.edit', $manager->id) }}">
                                    <i class="tio-edit"></i> {{ __('fleet_management.edit') }}
                                </a>
                                <form method="post"
                                      action="{{ route('admin.users.delivery-man.fleet-manager.status', $manager->id) }}"
                                      class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-sm btn-outline-secondary" type="submit">
                                        {{ $manager->status ? __('fleet_management.deactivate') : __('fleet_management.activate') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">{{ __('fleet_management.no_fleet_managers') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            @if($fleetManagers->hasPages())
                <div class="card-footer">{{ $fleetManagers->withQueryString()->links() }}</div>
            @endif
        </div>
    </div>
@endsection
