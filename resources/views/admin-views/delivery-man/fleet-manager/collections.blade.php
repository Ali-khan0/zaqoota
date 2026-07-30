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

        <div class="card">
            <div class="card-header">
                <form method="get">
                    <select name="status" class="form-control" onchange="this.form.submit()">
                        <option value="">{{ __('fleet_management.all_statuses') }}</option>
                        @foreach(['pending', 'approved', 'rejected'] as $status)
                            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                {{ __('fleet_management.status_'.$status) }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-borderless mb-0">
                    <thead class="thead-light">
                    <tr>
                        <th>{{ __('fleet_management.submitted') }}</th>
                        <th>{{ __('fleet_management.fleet_manager') }}</th>
                        <th>{{ __('fleet_management.rider') }}</th>
                        <th>{{ __('fleet_management.amount') }}</th>
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
                            <td>{{ $collection->deliveryMan?->full_name }}<br><small>{{ $collection->deliveryMan?->phone }}</small></td>
                            <td>{{ \App\CentralLogics\Helpers::format_currency($collection->amount) }}</td>
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
                        <tr><td colspan="8" class="text-center py-5">{{ __('fleet_management.no_payment_recoveries') }}</td></tr>
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
