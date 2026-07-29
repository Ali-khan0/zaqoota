@php($rf = $regFeeSettings ?? app(\App\Services\DeliveryManRegistrationFeeService::class)->getSettings())
<div class="modal fade" id="dmApproveModal" tabindex="-1" role="dialog" aria-labelledby="dmApproveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="{{ route('admin.users.delivery-man.application-approve') }}">
            @csrf
            <input type="hidden" name="id" id="dm_approve_dm_id" value="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dmApproveModalLabel">{{ translate('messages.dm_approve_modal_title') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ translate('messages.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if(!empty($rf['enabled']))
                        <p class="mb-2">{{ translate('messages.dm_registration_fee_total') }}: <strong>{{ \App\CentralLogics\Helpers::currency_symbol() }}{{ number_format($rf['total_fee'], 2) }}</strong></p>
                        <p class="mb-3 text-muted small">{{ translate('messages.dm_registration_fee_initial_deposit') }} ({{ translate('messages.default') }}): {{ \App\CentralLogics\Helpers::currency_symbol() }}{{ number_format($rf['manual_first_part'], 2) }}</p>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="initial_deposit_received" id="dm_initial_deposit_received" value="1"
                                    {{ !empty($rf['require_initial_on_approve']) ? 'required' : '' }}>
                                <label class="custom-control-label" for="dm_initial_deposit_received">{{ translate('messages.dm_approve_initial_deposit_received') }}</label>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <label class="form-label" for="dm_initial_deposit_amount">{{ translate('messages.dm_approve_initial_amount') }}</label>
                            <input type="number" step="0.01" min="0" class="form-control" name="initial_deposit_amount" id="dm_initial_deposit_amount" value="{{ $rf['manual_first_part'] }}" placeholder="{{ translate('messages.dm_approve_initial_amount') }}">
                            <small class="text-muted">{{ translate('messages.dm_registration_fee_initial_deposit_hint') }}</small>
                        </div>
                    @else
                        <p class="mb-0">{{ translate('messages.you_want_to_approve_this_application') }}</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ translate('messages.cancel') }}</button>
                    <button type="submit" class="btn btn-success">{{ translate('messages.approve') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
