@extends('layouts.admin.app')

@section('title', translate('messages.registration_fee_ledger'))

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="page-header-title">{{ translate('messages.registration_fee_ledger') }}</h1>
                    @if($fee->deliveryMan)
                        <p class="mb-0">{{ $fee->deliveryMan->f_name }} {{ $fee->deliveryMan->l_name }} — {{ translate('messages.remaining_due') }}:
                            <strong>{{ \App\CentralLogics\Helpers::currency_symbol() }}{{ number_format($fee->wallet_remaining_due, 2) }}</strong></p>
                    @endif
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.users.delivery-man.registration-fee') }}" class="btn btn--secondary">{{ translate('messages.back') }}</a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="table-responsive datatable-custom">
                <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle">
                    <thead class="thead-light">
                        <tr>
                            <th>{{ translate('messages.type') }}</th>
                            <th>{{ translate('messages.amount') }}</th>
                            <th>{{ translate('messages.direction') }}</th>
                            <th>{{ translate('messages.reference') }}</th>
                            <th>{{ translate('messages.date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ledgers as $row)
                            <tr>
                                <td>{{ str_replace('_', ' ', $row->transaction_type) }}</td>
                                <td>{{ \App\CentralLogics\Helpers::currency_symbol() }}{{ number_format($row->amount, 2) }}</td>
                                <td>{{ $row->direction }}</td>
                                <td>{{ $row->reference ?? '—' }}</td>
                                <td>{{ $row->created_at }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">{{ translate('messages.no_data_found') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($ledgers->hasPages())
                <div class="card-footer">{{ $ledgers->links() }}</div>
            @endif
        </div>
    </div>
@endsection
