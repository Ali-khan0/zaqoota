@extends('layouts.admin.app')

@section('title', translate('Fleet managers'))

@section('content')
    <div class="content container-fluid">
        <div class="page-header d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-header-title">{{ translate('Fleet managers') }}</h1>
                <p class="text-muted mb-0">{{ translate('Manage rider supervisors, areas and workload capacity.') }}</p>
            </div>
            <a href="{{ route('admin.users.delivery-man.fleet-manager.create') }}" class="btn btn--primary">
                <i class="tio-add"></i> {{ translate('Add fleet manager') }}
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <form class="w-100">
                    <div class="input-group">
                        <input type="search" name="search" class="form-control" value="{{ request('search') }}"
                               placeholder="{{ translate('Search by name, phone or employee ID') }}">
                        <div class="input-group-append">
                            <button class="btn btn--primary" type="submit">{{ translate('Search') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-borderless align-middle mb-0">
                    <thead class="thead-light">
                    <tr>
                        <th>{{ translate('Manager') }}</th>
                        <th>{{ translate('Areas') }}</th>
                        <th>{{ translate('Riders') }}</th>
                        <th>{{ translate('Shift') }}</th>
                        <th>{{ translate('Status') }}</th>
                        <th class="text-center">{{ translate('Actions') }}</th>
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
                                {{ $manager->riders_count }} / {{ $manager->rider_capacity }}
                            </td>
                            <td>
                                {{ $manager->shift_start ?: '—' }} – {{ $manager->shift_end ?: '—' }}
                            </td>
                            <td>
                                <span class="badge {{ $manager->status && !$manager->on_leave ? 'badge-soft-success' : 'badge-soft-danger' }}">
                                    {{ $manager->on_leave ? translate('On leave') : ($manager->status ? translate('Active') : translate('Inactive')) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a class="btn btn-sm btn-outline-primary"
                                   href="{{ route('admin.users.delivery-man.fleet-manager.edit', $manager->id) }}">
                                    {{ translate('Edit') }}
                                </a>
                                <form method="post"
                                      action="{{ route('admin.users.delivery-man.fleet-manager.status', $manager->id) }}"
                                      class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-sm btn-outline-secondary" type="submit">
                                        {{ $manager->status ? translate('Deactivate') : translate('Activate') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">{{ translate('No fleet managers found.') }}</td>
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
