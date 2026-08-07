

<?php $__env->startSection('title', translate('messages.dm_registration_fee_settings')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon"><img src="<?php echo e(asset('public/assets/admin/img/delivery-man.png')); ?>" class="w--26" alt=""></span>
                <span><?php echo e(translate('messages.dm_registration_fee_settings')); ?></span>
            </h1>
            <p class="text-muted mb-0"><?php echo e(translate('messages.dm_registration_fee_settings_intro')); ?></p>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <h5 class="card-title mb-0"><?php echo e(translate('messages.business_settings')); ?></h5>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.users.delivery-man.registration-fee.settings')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label"><?php echo e(translate('messages.status')); ?></label>
                            <select name="dm_reg_fee_enabled" class="form-control">
                                <option value="1" <?php echo e(($settings['enabled'] ?? true) ? 'selected' : ''); ?>><?php echo e(translate('messages.active')); ?></option>
                                <option value="0" <?php echo e(!($settings['enabled'] ?? true) ? 'selected' : ''); ?>><?php echo e(translate('messages.inactive')); ?></option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label"><?php echo e(translate('messages.dm_registration_fee_total')); ?></label>
                            <input type="number" step="0.01" name="dm_reg_total_fee" class="form-control" value="<?php echo e($settings['total_fee'] ?? 5000); ?>" title="<?php echo e(translate('messages.dm_registration_fee_total_hint')); ?>">
                            <small class="text-muted"><?php echo e(translate('messages.dm_registration_fee_total_hint')); ?></small>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label"><?php echo e(translate('messages.dm_registration_fee_initial_deposit')); ?></label>
                            <input type="number" step="0.01" name="dm_reg_manual_first_part" class="form-control" value="<?php echo e($settings['manual_first_part'] ?? 1500); ?>" title="<?php echo e(translate('messages.dm_registration_fee_initial_deposit_hint')); ?>">
                            <small class="text-muted"><?php echo e(translate('messages.dm_registration_fee_initial_deposit_hint')); ?></small>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">% <?php echo e(translate('messages.wallet')); ?></label>
                            <input type="number" step="0.01" name="dm_reg_wallet_deduction_percent" class="form-control" value="<?php echo e($settings['deduction_percent'] ?? 30); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label"><?php echo e(translate('messages.frequency')); ?></label>
                            <select name="dm_reg_deduction_frequency" class="form-control">
                                <option value="weekly" <?php echo e(($settings['deduction_frequency'] ?? 'weekly') === 'weekly' ? 'selected' : ''); ?>><?php echo e(translate('messages.weekly')); ?></option>
                                <option value="monthly" <?php echo e(($settings['deduction_frequency'] ?? '') === 'monthly' ? 'selected' : ''); ?>><?php echo e(translate('messages.monthly')); ?></option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><?php echo e(translate('messages.dm_reg_require_initial_on_approve')); ?></label>
                            <select name="dm_reg_require_initial_on_approve" class="form-control">
                                <option value="0" <?php echo e(empty($settings['require_initial_on_approve'] ?? false) ? 'selected' : ''); ?>><?php echo e(translate('messages.optional')); ?></option>
                                <option value="1" <?php echo e(!empty($settings['require_initial_on_approve'] ?? false) ? 'selected' : ''); ?>><?php echo e(translate('messages.required')); ?></option>
                            </select>
                            <small class="text-muted"><?php echo e(translate('messages.dm_reg_require_initial_on_approve_hint')); ?></small>
                        </div>
                    </div>
                    <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.submit')); ?></button>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/delivery-man/registration-fee-index.blade.php ENDPATH**/ ?>