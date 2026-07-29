@extends('layouts.admin.app')

@section('title', translate('messages.dm_registration_fee_settings'))

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon"><img src="{{ asset('public/assets/admin/img/delivery-man.png') }}" class="w--26" alt=""></span>
                <span>{{ translate('messages.dm_registration_fee_settings') }}</span>
            </h1>
            <p class="text-muted mb-0">{{ translate('messages.dm_registration_fee_settings_intro') }}</p>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ translate('messages.business_settings') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.delivery-man.registration-fee.settings') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">{{ translate('messages.status') }}</label>
                            <select name="dm_reg_fee_enabled" class="form-control">
                                <option value="1" {{ ($settings['enabled'] ?? true) ? 'selected' : '' }}>{{ translate('messages.active') }}</option>
                                <option value="0" {{ !($settings['enabled'] ?? true) ? 'selected' : '' }}>{{ translate('messages.inactive') }}</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">{{ translate('messages.dm_registration_fee_total') }}</label>
                            <input type="number" step="0.01" name="dm_reg_total_fee" class="form-control" value="{{ $settings['total_fee'] ?? 5000 }}" title="{{ translate('messages.dm_registration_fee_total_hint') }}">
                            <small class="text-muted">{{ translate('messages.dm_registration_fee_total_hint') }}</small>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">{{ translate('messages.dm_registration_fee_initial_deposit') }}</label>
                            <input type="number" step="0.01" name="dm_reg_manual_first_part" class="form-control" value="{{ $settings['manual_first_part'] ?? 1500 }}" title="{{ translate('messages.dm_registration_fee_initial_deposit_hint') }}">
                            <small class="text-muted">{{ translate('messages.dm_registration_fee_initial_deposit_hint') }}</small>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">% {{ translate('messages.wallet') }}</label>
                            <input type="number" step="0.01" name="dm_reg_wallet_deduction_percent" class="form-control" value="{{ $settings['deduction_percent'] ?? 30 }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">{{ translate('messages.frequency') }}</label>
                            <select name="dm_reg_deduction_frequency" class="form-control">
                                <option value="weekly" {{ ($settings['deduction_frequency'] ?? 'weekly') === 'weekly' ? 'selected' : '' }}>{{ translate('messages.weekly') }}</option>
                                <option value="monthly" {{ ($settings['deduction_frequency'] ?? '') === 'monthly' ? 'selected' : '' }}>{{ translate('messages.monthly') }}</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ translate('messages.dm_reg_require_initial_on_approve') }}</label>
                            <select name="dm_reg_require_initial_on_approve" class="form-control">
                                <option value="0" {{ empty($settings['require_initial_on_approve'] ?? false) ? 'selected' : '' }}>{{ translate('messages.optional') }}</option>
                                <option value="1" {{ !empty($settings['require_initial_on_approve'] ?? false) ? 'selected' : '' }}>{{ translate('messages.required') }}</option>
                            </select>
                            <small class="text-muted">{{ translate('messages.dm_reg_require_initial_on_approve_hint') }}</small>
                        </div>
                    </div>
                    <button type="submit" class="btn btn--primary">{{ translate('messages.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
