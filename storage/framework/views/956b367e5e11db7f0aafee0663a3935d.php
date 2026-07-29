<?php ($rf = $regFeeSettings ?? app(\App\Services\DeliveryManRegistrationFeeService::class)->getSettings()); ?>
<div class="modal fade" id="dmApproveModal" tabindex="-1" role="dialog" aria-labelledby="dmApproveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="<?php echo e(route('admin.users.delivery-man.application-approve')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="id" id="dm_approve_dm_id" value="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dmApproveModalLabel"><?php echo e(translate('messages.dm_approve_modal_title')); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo e(translate('messages.close')); ?>">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php if(!empty($rf['enabled'])): ?>
                        <p class="mb-2"><?php echo e(translate('messages.dm_registration_fee_total')); ?>: <strong><?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?><?php echo e(number_format($rf['total_fee'], 2)); ?></strong></p>
                        <p class="mb-3 text-muted small"><?php echo e(translate('messages.dm_registration_fee_initial_deposit')); ?> (<?php echo e(translate('messages.default')); ?>): <?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?><?php echo e(number_format($rf['manual_first_part'], 2)); ?></p>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="initial_deposit_received" id="dm_initial_deposit_received" value="1"
                                    <?php echo e(!empty($rf['require_initial_on_approve']) ? 'required' : ''); ?>>
                                <label class="custom-control-label" for="dm_initial_deposit_received"><?php echo e(translate('messages.dm_approve_initial_deposit_received')); ?></label>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <label class="form-label" for="dm_initial_deposit_amount"><?php echo e(translate('messages.dm_approve_initial_amount')); ?></label>
                            <input type="number" step="0.01" min="0" class="form-control" name="initial_deposit_amount" id="dm_initial_deposit_amount" value="<?php echo e($rf['manual_first_part']); ?>" placeholder="<?php echo e(translate('messages.dm_approve_initial_amount')); ?>">
                            <small class="text-muted"><?php echo e(translate('messages.dm_registration_fee_initial_deposit_hint')); ?></small>
                        </div>
                    <?php else: ?>
                        <p class="mb-0"><?php echo e(translate('messages.you_want_to_approve_this_application')); ?></p>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(translate('messages.cancel')); ?></button>
                    <button type="submit" class="btn btn-success"><?php echo e(translate('messages.approve')); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php /**PATH /var/www/zaqoota/resources/views/admin-views/delivery-man/partials/_dm_approve_modal.blade.php ENDPATH**/ ?>