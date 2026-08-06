@extends('layouts.admin.app')

@section('title', __('fleet_management.fleet_rider_assignments'))

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <h1 class="page-header-title">{{ __('fleet_management.fleet_rider_assignments') }}</h1>
            <p class="text-muted mb-0">{{ __('fleet_management.assignments_intro') }}</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <form method="post" action="{{ route('admin.users.delivery-man.fleet-manager.assign') }}">
            @csrf
            <div class="card mb-3">
                <div class="card-header"><h5 class="mb-0">{{ __('fleet_management.assignment') }}</h5></div>
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-md-4 mb-3">
                            <label>{{ __('fleet_management.fleet_manager') }}</label>
                            <select name="fleet_manager_id" class="form-control" required>
                                <option value="">{{ __('fleet_management.select_fleet_manager') }}</option>
                                @foreach($fleetManagers as $manager)
                                    <option value="{{ $manager->id }}">
                                        {{ $manager->full_name }} ({{ $manager->riders_count }}/{{ $manager->rider_capacity }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5 mb-3">
                            <label>{{ __('fleet_management.assignment_reason') }}</label>
                            <input name="reason" class="form-control" maxlength="191">
                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn--primary btn-block" type="submit">{{ __('fleet_management.assign_selected_riders') }}</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <div class="row w-100">
                        <div class="col-md-4">
                            <input form="rider-filter" name="search" class="form-control" value="{{ request('search') }}" placeholder="{{ __('fleet_management.search_riders') }}">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-borderless mb-0">
                        <thead class="thead-light">
                        <tr>
                            <th><input type="checkbox" onclick="document.querySelectorAll('.rider-check').forEach(el => el.checked = this.checked)"></th>
                            <th>{{ __('fleet_management.rider') }}</th>
                            <th>{{ __('fleet_management.area') }}</th>
                            <th>{{ __('fleet_management.current_manager') }}</th>
                            <th>{{ __('fleet_management.payment_due') }}</th>
                            <th>{{ __('fleet_management.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($riders as $rider)
                            <tr>
                                <td><input class="rider-check" type="checkbox" name="rider_ids[]" value="{{ $rider->id }}"></td>
                                <td><strong>{{ $rider->full_name }}</strong><br><small>{{ $rider->phone }}</small></td>
                                <td>{{ $rider->zone?->name }}</td>
                                <td>{{ $rider->fleetManager?->full_name ?: __('fleet_management.unassigned') }}</td>
                                <td>{{ \App\CentralLogics\Helpers::format_currency($rider->wallet?->collected_cash ?? 0) }}</td>
                                <td>
                                    @if($rider->fleet_manager_id)
                                        <button class="btn btn-sm btn-outline-danger" type="submit"
                                                form="unassign-{{ $rider->id }}">{{ __('fleet_management.unassign') }}</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-5">{{ __('fleet_management.no_riders') }}</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                @if($riders->hasPages())
                    <div class="card-footer">{{ $riders->withQueryString()->links() }}</div>
                @endif
            </div>
        </form>

        <form id="rider-filter" method="get"></form>
        @foreach($riders as $rider)
            @if($rider->fleet_manager_id)
                <form id="unassign-{{ $rider->id }}" method="post"
                      action="{{ route('admin.users.delivery-man.fleet-manager.unassign', $rider->id) }}">
                    @csrf
                    @method('DELETE')
                </form>
            @endif
        @endforeach

        <div class="card">
            <div class="card-header"><h5 class="mb-0">{{ __('fleet_management.recent_assignment_history') }}</h5></div>
            <div class="table-responsive">
                <table class="table table-borderless mb-0">
                    <thead class="thead-light">
                    <tr>
                        <th>{{ __('fleet_management.rider') }}</th>
                        <th>{{ __('fleet_management.fleet_manager') }}</th>
                        <th>{{ __('fleet_management.started') }}</th>
                        <th>{{ __('fleet_management.ended') }}</th>
                        <th>{{ __('fleet_management.assigned_by') }}</th>
                        <th>{{ __('fleet_management.ended_by') }}</th>
                        <th>{{ __('fleet_management.reason') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($history as $assignment)
                        <tr>
                            <td>{{ $assignment->deliveryMan?->full_name }}</td>
                            <td>{{ $assignment->fleetManager?->full_name }}</td>
                            <td>{{ $assignment->started_at }}</td>
                            <td>{{ $assignment->ended_at ?: __('fleet_management.active') }}</td>
                            <td>{{ $assignment->assignedBy?->full_name }}</td>
                            <td>{{ $assignment->endedBy?->full_name ?: '—' }}</td>
                            <td>
                                {{ $assignment->reason ?: '—' }}
                                @if($assignment->end_reason)
                                    <br><small class="text-muted">{{ $assignment->end_reason }}</small>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
