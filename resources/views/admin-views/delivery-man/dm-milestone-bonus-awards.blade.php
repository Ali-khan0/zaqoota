@extends('layouts.admin.app')

@section('title', translate('messages.dm_bonus_awards'))

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="page-header-title">{{ translate('messages.dm_bonus_awards') }}</h1>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.delivery-man.milestone-bonus') }}" class="btn btn--secondary">{{ translate('messages.back') }}</a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header py-2">
                <form class="search-form">
                    <div class="input-group input--group max--320">
                        <input type="search" name="search" class="form-control h--45px" placeholder="{{ translate('ex:_DM_name_email_or_phone') }}" value="{{ request('search') }}">
                        <button type="submit" class="btn btn--secondary h--45px"><i class="tio-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-borderless table-thead-bordered table-nowrap">
                    <thead class="thead-light">
                        <tr>
                            <th>{{ translate('messages.deliveryman') }}</th>
                            <th>{{ translate('messages.type') }}</th>
                            <th>{{ translate('messages.orders_required') }}</th>
                            <th>{{ translate('messages.delivered') }}</th>
                            <th>{{ translate('messages.bonus_amount') }}</th>
                            <th>{{ translate('messages.period') }}</th>
                            <th>{{ translate('messages.date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($awards as $a)
                            @php($dm = $a->deliveryMan)
                            @php($ms = $a->milestone)
                            <tr>
                                <td>
                                    @if($dm)
                                        {{ $dm->f_name }} {{ $dm->l_name }}<br><small class="text-muted">{{ $dm->phone }}</small>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>{{ $ms ? ucfirst($ms->period_type) : '—' }}</td>
                                <td>{{ $ms ? $ms->orders_required : '—' }}</td>
                                <td>{{ $a->delivered_count }}</td>
                                <td>{{ \App\CentralLogics\Helpers::currency_symbol() }}{{ number_format($a->amount, 2) }}</td>
                                <td><code>{{ $a->period_key }}</code></td>
                                <td>{{ $a->awarded_at }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center py-4">{{ translate('messages.no_data_found') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($awards->hasPages())
                <div class="card-footer">{{ $awards->links() }}</div>
            @endif
        </div>
    </div>
@endsection
