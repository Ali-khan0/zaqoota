@extends('layouts.admin.app')
@section('title', translate('Ops finance'))
@section('content')
<div class="content container-fluid">
    <h1 class="page-header-title mb-3">{{ translate('Ops finance') }}</h1>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if($errors->any())<div class="alert alert-danger">@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>@endif
    <div class="d-flex gap-2 mb-3">
        <a class="btn btn-outline-primary" href="{{ route('admin.transactions.ops-finance.export') }}">{{ translate('Export ledger CSV') }}</a>
        <a class="btn btn-outline-primary" href="{{ route('admin.transactions.onboarding-invoices.index') }}">{{ translate('Invoice payments and proofs') }}</a>
    </div>
    <p>{{ translate('Commission release follows the Ops release policy. Payment confirmation requires a staff member other than the withdrawal approver.') }}</p>
    <div class="card mb-4"><div class="card-body"><h3>{{ translate('Withdrawals') }}</h3>
        <form class="d-flex gap-2 mb-3"><select class="form-control w-auto" name="status"><option value="">{{ translate('All statuses') }}</option>@foreach(['pending','approved','processing','paid','rejected','cancelled'] as $status)<option @selected(request('status') === $status)>{{ $status }}</option>@endforeach</select><button class="btn btn--primary">{{ translate('Filter') }}</button></form>
        @forelse($withdrawals as $withdrawal)
            <div class="border rounded p-3 mb-3">
                <strong>{{ $withdrawal->reference }} · {{ $withdrawal->manager?->f_name }} {{ $withdrawal->manager?->l_name }}</strong>
                <p>{{ $withdrawal->currency }} {{ $withdrawal->amount }} · {{ $withdrawal->status }} · {{ $withdrawal->masked_destination }}</p>
                <p>{{ translate('Approved by') }}: {{ $withdrawal->reviewer?->email ?? '—' }} · {{ translate('Paid by') }}: {{ $withdrawal->payer?->email ?? '—' }}</p>
                <p>{{ $withdrawal->admin_note }} · {{ $withdrawal->payment_reference }}</p>
                @if($withdrawal->proof_path)<a href="{{ route('admin.transactions.ops-finance.proof', $withdrawal->id) }}">{{ translate('Payment proof') }}</a>@endif
                @if(in_array($withdrawal->status, ['approved','processing']))<a class="d-block mb-2" href="{{ route('admin.transactions.ops-finance.destination', $withdrawal->id) }}">{{ translate('View saved payout destination') }}</a>@endif
                @if(in_array($withdrawal->status, ['pending','approved','processing']))
                    <form method="post" enctype="multipart/form-data" action="{{ route('admin.transactions.ops-finance.withdrawal', $withdrawal->id) }}">@csrf
                        <label>{{ translate('Decision') }}</label><select name="action" class="form-control mb-2">@if($withdrawal->status === 'pending')<option value="approved">{{ translate('Approve') }}</option><option value="rejected">{{ translate('Reject') }}</option>@else<option value="paid">{{ translate('Confirm payment already sent') }}</option>@endif</select>
                        <label>{{ translate('Review note') }}</label><input name="note" class="form-control mb-2" required maxlength="1000">
                        @if($withdrawal->status !== 'pending')
                            <label>{{ translate('Bank / transfer reference') }}</label><input name="reference" class="form-control mb-2" required maxlength="150">
                            <label>{{ translate('Payment proof (JPG, PNG or PDF, maximum 5 MB)') }}</label><input type="file" name="proof" accept=".jpg,.jpeg,.png,.pdf" required class="form-control mb-2">
                        @endif
                        <button class="btn btn--primary">{{ translate('Save decision') }}</button>
                    </form>
                @endif
            </div>
        @empty<p>{{ translate('No withdrawals found') }}</p>@endforelse
        {{ $withdrawals->links() }}
    </div></div>
    <div class="card"><div class="card-body"><h3>{{ translate('Application commissions') }}</h3>
        @forelse($applications as $application)
            <div class="border rounded p-3 mb-3"><strong>{{ $application->reference }} · {{ $application->store_name }}</strong><p>{{ $application->manager_name_snapshot }} · {{ $application->currency }} {{ $application->commission_amount_snapshot }} · {{ $application->status }}</p>
                @if($application->invoice)<a href="{{ route('admin.transactions.onboarding-invoices.show', $application->invoice->id) }}">{{ $application->invoice->invoice_number }} · {{ $application->invoice->display_status }}</a>@endif
                <form class="mt-2" method="post" action="{{ route('admin.transactions.ops-finance.commission', $application->id) }}">@csrf
                    <label>{{ translate('Commission action') }}</label><select name="action" class="form-control mb-2"><option value="release">{{ translate('Release available pending commission') }}</option><option value="reverse">{{ translate('Reverse commission') }}</option></select>
                    <label>{{ translate('Reason') }}</label><input name="note" required maxlength="1000" class="form-control mb-2"><button class="btn btn--primary">{{ translate('Save decision') }}</button>
                </form>
            </div>
        @empty<p>{{ translate('No applications found') }}</p>@endforelse
        {{ $applications->links() }}
    </div></div>
</div>
@endsection
