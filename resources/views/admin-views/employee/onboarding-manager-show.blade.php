@extends('layouts.admin.app')

@section('title', 'Onboarding Manager Details')

@section('content')
@php
    $managerName = trim($manager->f_name.' '.$manager->l_name);
    $currency = static fn ($amount) => \App\CentralLogics\Helpers::format_currency((float) $amount);
    $statusClass = static fn ($status) => in_array($status, ['approved', 'paid'], true) ? 'success' : (in_array($status, ['rejected', 'cancelled', 'refunded'], true) ? 'danger' : 'warning');
@endphp
<div class="content container-fluid">
    <div class="page-header">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div>
                <a href="{{ route('admin.users.onboarding-manager.index') }}" class="text-muted"><i class="tio-chevron-left"></i> Managers</a>
                <h1 class="page-header-title mt-2 mb-1">{{ $managerName }}</h1>
                <p class="text-muted mb-0">Manager performance, finance and audit record.</p>
            </div>
            <div class="btn--container">
                <a class="btn btn-outline-primary" href="{{ route('admin.users.employee.edit', $manager) }}"><i class="tio-edit"></i> Edit manager</a>
                <button class="btn btn-{{ $manager->ops_status ? 'danger' : 'success' }}" data-toggle="modal" data-target="#ops-status-modal">
                    <i class="tio-{{ $manager->ops_status ? 'lock-outlined' : 'unlock' }}"></i>
                    {{ $manager->ops_status ? 'Ban Ops access' : 'Enable Ops access' }}
                </button>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <img class="avatar avatar-xl rounded-circle onerror-image mb-3" src="{{ $manager->image_full_url }}"
                         data-onerror-image="{{ asset('/public/assets/admin/img/admin.png') }}" alt="">
                    <h4>{{ $managerName }}</h4>
                    <span class="badge badge-soft-{{ $manager->canUseOps() ? 'success' : 'danger' }} mb-3">{{ $manager->canUseOps() ? 'Ops active' : ($manager->ops_status ? 'Role inactive' : 'Ops banned') }}</span>
                    <div class="text-left border-top pt-3">
                        <p class="mb-2"><strong>Email:</strong> {{ $manager->email }}</p>
                        <p class="mb-2"><strong>Phone:</strong> {{ $manager->phone }}</p>
                        <p class="mb-2"><strong>Role:</strong> {{ $manager->role?->name ?? 'Deleted role' }}</p>
                        <p class="mb-2"><strong>Territory:</strong> {{ $manager->zones?->name ?? 'All territories' }}</p>
                        <p class="mb-0"><strong>Commission:</strong> {{ number_format((float) $manager->onboarding_commission_percent, 2) }}%</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row g-3 h-100">
                <div class="col-sm-4"><div class="card h-100"><div class="card-body"><span class="text-muted">Applications</span><h3 class="mb-0 mt-2">{{ number_format($applicationCounts->sum()) }}</h3></div></div></div>
                <div class="col-sm-4"><div class="card h-100"><div class="card-body"><span class="text-muted">Approved</span><h3 class="text-success mb-0 mt-2">{{ number_format((int) ($applicationCounts['approved'] ?? 0)) }}</h3></div></div></div>
                <div class="col-sm-4"><div class="card h-100"><div class="card-body"><span class="text-muted">Paid invoices</span><h3 class="mb-0 mt-2">{{ $currency($invoiceTotals->paid_amount ?? 0) }}</h3><small class="text-muted">{{ $currency($invoiceTotals->invoiced_amount ?? 0) }} total invoiced</small></div></div></div>
                <div class="col-sm-4"><div class="card h-100"><div class="card-body"><span class="text-muted">Available</span><h3 class="text-success mb-0 mt-2">{{ $currency($balances['available_balance']) }}</h3><small class="text-muted">{{ $currency($balances['pending_commission']) }} pending commission</small></div></div></div>
                <div class="col-sm-4"><div class="card h-100"><div class="card-body"><span class="text-muted">Pending release</span><h3 class="text-warning mb-0 mt-2">{{ $currency($balances['pending_release']) }}</h3><small class="text-muted">{{ $currency($balances['awaiting_collection']) }} awaiting collection</small></div></div></div>
                <div class="col-sm-4"><div class="card h-100"><div class="card-body"><span class="text-muted">Withdrawn</span><h3 class="mb-0 mt-2">{{ $currency($balances['total_withdrawn']) }}</h3></div></div></div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header"><h5 class="card-title mb-0">Payout details</h5></div>
        <div class="card-body">
            @if($manager->opsPayoutMethod)
                <div class="row g-3">
                    <div class="col-md-3"><span class="text-muted d-block">Type</span><strong>{{ str($manager->opsPayoutMethod->type)->replace('_', ' ')->title() }}</strong></div>
                    <div class="col-md-3"><span class="text-muted d-block">Account title</span><strong>{{ $manager->opsPayoutMethod->account_title }}</strong></div>
                    <div class="col-md-3"><span class="text-muted d-block">Provider</span><strong>{{ $manager->opsPayoutMethod->provider_name }}</strong></div>
                    <div class="col-md-3"><span class="text-muted d-block">Destination</span><strong>•••• {{ $manager->opsPayoutMethod->account_last_four }}</strong></div>
                </div>
            @else
                <p class="text-muted mb-0">The manager has not added payout details yet.</p>
            @endif
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header"><h5 class="card-title mb-0">Applications</h5></div>
        <div class="table-responsive">
            <table class="table table-borderless table-thead-bordered table-align-middle card-table">
                <thead class="thead-light"><tr><th>Reference</th><th>Store</th><th>Territory</th><th>Status</th><th>Invoice</th><th>Submitted</th></tr></thead>
                <tbody>
                    @forelse($applications as $application)
                        <tr>
                            <td><strong>{{ $application->reference }}</strong></td>
                            <td>{{ $application->store_name }}</td>
                            <td>{{ $application->zone_name_snapshot ?: ($application->zone?->name ?? '—') }}</td>
                            <td><span class="badge badge-soft-{{ $statusClass($application->status) }}">{{ str($application->status)->replace('_', ' ')->title() }}</span></td>
                            <td>
                                @if($application->invoice)
                                    {{ $application->invoice->invoice_number }} · {{ $currency($application->invoice->amount) }}
                                    <div class="small text-muted">{{ ucfirst($application->invoice->payment_status) }}</div>
                                @else — @endif
                            </td>
                            <td>{{ optional($application->submitted_at)->format('d M Y, h:i A') ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No submitted applications.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($applications->hasPages())<div class="card-footer">{{ $applications->links() }}</div>@endif
    </div>

    <div class="card mb-4">
        <div class="card-header"><h5 class="card-title mb-0">Finance ledger</h5></div>
        <div class="table-responsive">
            <table class="table table-borderless table-thead-bordered table-align-middle card-table">
                <thead class="thead-light"><tr><th>Date</th><th>Type</th><th>Bucket</th><th>Reference</th><th class="text-right">Amount</th></tr></thead>
                <tbody>
                    @forelse($ledger as $entry)
                        <tr>
                            <td>{{ $entry->created_at?->format('d M Y, h:i A') }}</td>
                            <td>{{ str($entry->entry_type)->replace('_', ' ')->title() }}</td>
                            <td>{{ str($entry->bucket)->replace('_', ' ')->title() }}</td>
                            <td><span class="small">{{ $entry->reference }}</span></td>
                            <td class="text-right text-{{ $entry->direction === 'credit' ? 'success' : 'danger' }}">
                                {{ $entry->direction === 'credit' ? '+' : '−' }}{{ $currency($entry->amount) }}
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No ledger entries.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($ledger->hasPages())<div class="card-footer">{{ $ledger->links() }}</div>@endif
    </div>

    <div class="row g-3">
        <div class="col-xl-6">
            <div class="card h-100">
                <div class="card-header"><h5 class="card-title mb-0">Withdrawal requests</h5></div>
                <div class="table-responsive">
                    <table class="table table-borderless table-thead-bordered table-align-middle card-table">
                        <thead class="thead-light"><tr><th>Reference</th><th>Status</th><th class="text-right">Amount</th></tr></thead>
                        <tbody>
                            @forelse($withdrawals as $withdrawal)
                                <tr><td>{{ $withdrawal->reference }}</td><td><span class="badge badge-soft-{{ $statusClass($withdrawal->status) }}">{{ ucfirst($withdrawal->status) }}</span></td><td class="text-right">{{ $currency($withdrawal->amount) }}</td></tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted py-4">No withdrawals.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($withdrawals->hasPages())<div class="card-footer">{{ $withdrawals->links() }}</div>@endif
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card h-100">
                <div class="card-header"><h5 class="card-title mb-0">Audit history</h5></div>
                <div class="table-responsive">
                    <table class="table table-borderless table-thead-bordered table-align-middle card-table">
                        <thead class="thead-light"><tr><th>Date</th><th>Action</th><th>Actor</th><th>Details</th></tr></thead>
                        <tbody>
                            @forelse($audits as $audit)
                                <tr>
                                    <td>{{ $audit->created_at?->format('d M Y, h:i A') }}</td>
                                    <td>{{ str($audit->action)->replace('_', ' ')->title() }}</td>
                                    <td>{{ $audit->actor ? trim($audit->actor->f_name.' '.$audit->actor->l_name) : 'System' }}</td>
                                    <td class="text-muted small">
                                        @if(data_get($audit->metadata, 'reason'))
                                            {{ data_get($audit->metadata, 'reason') }}
                                        @elseif(data_get($audit->metadata, 'commission_percentage') !== null)
                                            Commission: {{ data_get($audit->metadata, 'commission_percentage') }}%
                                        @elseif(data_get($audit->metadata, 'after.onboarding_commission_percent') !== null)
                                            Commission: {{ data_get($audit->metadata, 'before.onboarding_commission_percent', 0) }}% → {{ data_get($audit->metadata, 'after.onboarding_commission_percent') }}%
                                        @elseif(data_get($audit->metadata, 'password_changed'))
                                            Password changed
                                        @else
                                            —
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-4">No audit events.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($audits->hasPages())<div class="card-footer">{{ $audits->links() }}</div>@endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ops-status-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('admin.users.onboarding-manager.status', $manager) }}">
                @csrf
                @method('put')
                <input type="hidden" name="ops_status" value="{{ $manager->ops_status ? 0 : 1 }}">
                <div class="modal-header"><h5 class="modal-title">{{ $manager->ops_status ? 'Ban Ops access' : 'Enable Ops access' }}</h5><button type="button" class="close" data-dismiss="modal"><span>&times;</span></button></div>
                <div class="modal-body">
                    <p>{{ $manager->ops_status ? 'This immediately blocks Zaqoota Ops login, clears the push token and revokes active mobile access tokens. Historical applications and finance records remain unchanged.' : 'This allows the manager to sign in to Zaqoota Ops again.' }}</p>
                    <label class="input-label">Reason (optional)</label>
                    <textarea class="form-control" name="reason" rows="3" maxlength="500" placeholder="Internal audit note"></textarea>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn--reset" data-dismiss="modal">Cancel</button><button type="submit" class="btn btn-{{ $manager->ops_status ? 'danger' : 'success' }}">Confirm</button></div>
            </form>
        </div>
    </div>
</div>
@endsection
