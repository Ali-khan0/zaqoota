@extends('layouts.admin.app')

@section('title', translate('Rider payment recoveries'))

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <h1 class="page-header-title">{{ translate('Rider payment recoveries') }}</h1>
            <p class="text-muted mb-0">{{ translate('Review fleet-manager collections before reconciling rider payable balances.') }}</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <form method="get">
                    <select name="status" class="form-control" onchange="this.form.submit()">
                        <option value="">{{ translate('All statuses') }}</option>
                        @foreach(['pending', 'approved', 'rejected'] as $status)
                            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                {{ translate(ucfirst($status)) }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-borderless mb-0">
                    <thead class="thead-light">
                    <tr>
                        <th>{{ translate('Submitted') }}</th>
                        <th>{{ translate('Fleet manager') }}</th>
                        <th>{{ translate('Rider') }}</th>
                        <th>{{ translate('Amount') }}</th>
                        <th>{{ translate('Due before / after') }}</th>
                        <th>{{ translate('Method') }}</th>
                        <th>{{ translate('Status') }}</th>
                        <th>{{ translate('Actions') }}</th>
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
                                {{ translate(str_replace('_', ' ', ucfirst($collection->payment_method))) }}
                                @if($collection->reference)<br><small>{{ $collection->reference }}</small>@endif
                                @if($collection->proof_file)
                                    <br>
                                    <a href="{{ route('admin.users.delivery-man.fleet-manager.collections.proof', $collection->id) }}"
                                       target="_blank" rel="noopener">{{ translate('View proof') }}</a>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-soft-{{ $collection->status === 'approved' ? 'success' : ($collection->status === 'rejected' ? 'danger' : 'warning') }}">
                                    {{ translate(ucfirst($collection->status)) }}
                                </span>
                                @if($collection->rejection_reason)<br><small>{{ $collection->rejection_reason }}</small>@endif
                            </td>
                            <td>
                                @if($collection->status === 'pending')
                                    <form class="d-inline" method="post"
                                          action="{{ route('admin.users.delivery-man.fleet-manager.collections.approve', $collection->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-sm btn-outline-success" type="submit">{{ translate('Approve') }}</button>
                                    </form>
                                    <form class="mt-1" method="post"
                                          action="{{ route('admin.users.delivery-man.fleet-manager.collections.reject', $collection->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <input name="rejection_reason" class="form-control form-control-sm mb-1" required
                                               placeholder="{{ translate('Rejection reason') }}">
                                        <button class="btn btn-sm btn-outline-danger" type="submit">{{ translate('Reject') }}</button>
                                    </form>
                                @else
                                    <small>{{ $collection->reviewer?->full_name }}<br>{{ $collection->reviewed_at }}</small>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center py-5">{{ translate('No payment recoveries found.') }}</td></tr>
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
