@extends('layouts.admin.app')

@section('title', __('fleet_management.fleet_manager_withdrawals'))

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <h1 class="page-header-title">{{ __('fleet_management.fleet_manager_withdrawals') }}</h1>
            <p class="text-muted mb-0">{{ __('fleet_management.withdrawals_intro') }}</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <form method="get" class="row w-100">
                    <div class="col-md-4 mb-2">
                        <input type="search" name="search" class="form-control" value="{{ request('search') }}"
                               placeholder="{{ __('fleet_management.search_manager_placeholder') }}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <select name="fleet_manager_id" class="form-control js-select2-custom">
                            <option value="">{{ __('fleet_management.all_fleet_managers') }}</option>
                            @foreach($fleetManagers as $manager)
                                <option value="{{ $manager->id }}" {{ (int) request('fleet_manager_id') === $manager->id ? 'selected' : '' }}>
                                    {{ $manager->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
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
                        <th>{{ __('fleet_management.requested') }}</th>
                        <th>{{ __('fleet_management.fleet_manager') }}</th>
                        <th>{{ __('fleet_management.amount') }}</th>
                        <th>{{ __('fleet_management.withdrawal_method') }}</th>
                        <th>{{ __('fleet_management.account_details') }}</th>
                        <th>{{ __('fleet_management.status') }}</th>
                        <th>{{ __('fleet_management.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($withdrawals as $withdrawal)
                        <tr>
                            <td>{{ $withdrawal->created_at }}</td>
                            <td>
                                <strong>{{ $withdrawal->fleetManager?->full_name }}</strong><br>
                                <a href="tel:{{ $withdrawal->fleetManager?->phone }}">{{ $withdrawal->fleetManager?->phone }}</a>
                            </td>
                            <td>{{ \App\CentralLogics\Helpers::format_currency($withdrawal->amount) }}</td>
                            <td>{{ $withdrawal->method_name }}</td>
                            <td>
                                @foreach($withdrawal->method_fields ?? [] as $key => $value)
                                    <div><small>{{ str($key)->replace('_', ' ')->title() }}:</small> {{ $value }}</div>
                                @endforeach
                                @if($withdrawal->manager_note)
                                    <div class="text-muted mt-1">{{ $withdrawal->manager_note }}</div>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-soft-{{ $withdrawal->status === 'approved' ? 'success' : ($withdrawal->status === 'rejected' ? 'danger' : 'warning') }}">
                                    {{ __('fleet_management.status_'.$withdrawal->status) }}
                                </span>
                                @if($withdrawal->admin_note)<br><small>{{ $withdrawal->admin_note }}</small>@endif
                            </td>
                            <td>
                                @if($withdrawal->status === 'pending')
                                    <form method="post"
                                          action="{{ route('admin.transactions.fleet-manager.withdrawals.review', $withdrawal->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <input name="admin_note" class="form-control form-control-sm mb-1"
                                               placeholder="{{ __('fleet_management.admin_note') }}">
                                        <button name="status" value="approved" class="btn btn-sm btn-outline-success" type="submit">
                                            {{ __('fleet_management.approve') }}
                                        </button>
                                        <button name="status" value="rejected" class="btn btn-sm btn-outline-danger" type="submit">
                                            {{ __('fleet_management.reject') }}
                                        </button>
                                    </form>
                                @else
                                    <small>{{ $withdrawal->reviewer?->full_name }}<br>{{ $withdrawal->reviewed_at }}</small>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">{{ __('fleet_management.no_withdrawal_requests') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            @if($withdrawals->hasPages())
                <div class="card-footer">{{ $withdrawals->withQueryString()->links() }}</div>
            @endif
        </div>
    </div>
@endsection
