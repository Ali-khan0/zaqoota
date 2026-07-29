@extends('layouts.admin.app')

@section('title', translate('messages.dm_milestone_bonus'))

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon"><i class="tio-gift"></i></span>
                {{ translate('messages.dm_milestone_bonus') }}
            </h1>
            <div class="mt-2">
                <a href="{{ route('admin.delivery-man.milestone-bonus.awards') }}" class="btn btn-sm btn--primary">{{ translate('messages.dm_bonus_awards') }}</a>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header"><h5 class="mb-0">{{ translate('messages.add_new') }}</h5></div>
            <div class="card-body">
                <form action="{{ route('admin.delivery-man.milestone-bonus.store') }}" method="post" class="row align-items-end">
                    @csrf
                    <div class="col-md-3 mb-2">
                        <label class="form-label">{{ translate('messages.type') }}</label>
                        <select name="period_type" class="form-control" required>
                            <option value="daily">{{ translate('messages.period_daily') }}</option>
                            <option value="weekly">{{ translate('messages.period_weekly') }}</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">{{ translate('messages.orders_required') }}</label>
                        <input type="number" name="orders_required" class="form-control" min="1" required>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">{{ translate('messages.bonus_amount') }}</label>
                        <input type="number" step="0.01" name="bonus_amount" class="form-control" min="0" required>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button type="submit" class="btn btn--primary">{{ translate('messages.add') }}</button>
                    </div>
                </form>
                <p class="text-muted small mb-0">{{ translate('messages.maximum') }} 4 {{ translate('messages.daily') }} / 4 {{ translate('messages.weekly') }}.</p>
            </div>
        </div>

        @foreach(['daily' => $daily, 'weekly' => $weekly] as $period => $rows)
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">{{ $period === 'daily' ? translate('messages.period_daily') : translate('messages.period_weekly') }}</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-borderless table-thead-bordered table-nowrap">
                        <thead class="thead-light">
                            <tr>
                                <th>{{ translate('messages.milestone_slot') }}</th>
                                <th>{{ translate('messages.orders_required') }}</th>
                                <th>{{ translate('messages.bonus_amount') }}</th>
                                <th>{{ translate('messages.status') }}</th>
                                <th>{{ translate('messages.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rows as $m)
                                <tr>
                                    <td>{{ $m->slot }}</td>
                                    <td colspan="3">
                                        <form action="{{ route('admin.delivery-man.milestone-bonus.update', $m->id) }}" method="post" class="form-inline flex-wrap align-items-center">
                                            @csrf
                                            <input type="number" name="orders_required" value="{{ $m->orders_required }}" class="form-control form-control-sm mr-2 mb-1" min="1" style="width:90px">
                                            <input type="number" step="0.01" name="bonus_amount" value="{{ $m->bonus_amount }}" class="form-control form-control-sm mr-2 mb-1" min="0" style="width:110px">
                                            <select name="status" class="form-control form-control-sm mr-2 mb-1" style="width:100px">
                                                <option value="1" {{ $m->status ? 'selected' : '' }}>{{ translate('messages.active') }}</option>
                                                <option value="0" {{ !$m->status ? 'selected' : '' }}>{{ translate('messages.inactive') }}</option>
                                            </select>
                                            <button type="submit" class="btn btn-sm btn--primary mb-1">{{ translate('messages.update') }}</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.delivery-man.milestone-bonus.delete', $m->id) }}" method="post" class="d-inline" onsubmit="return confirm('{{ translate('messages.are_you_sure') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">{{ translate('messages.delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center py-3">{{ translate('messages.no_data_found') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
@endsection
