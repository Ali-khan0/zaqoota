<div class="h-100vh-150px">
    <div class="d-flex flex-column align-items-center gap-1 mb-3">
        <h3 class="mb-3"><?php echo e(translate('withdraw_Information')); ?></h3>
        <div class="d-flex gap-2 align-items-center mb-1 flex-wrap">
            <span><?php echo e(translate('withdraw_Amount')); ?>:</span>
            <span class="font-semibold"><?php echo e(\App\CentralLogics\Helpers::format_currency($withdraw['amount'])); ?></span>
            <?php if($withdraw->approved == 1): ?>
                <label class="badge badge-soft-success mb-0"><?php echo e(translate('approved')); ?></label>
            <?php elseif($withdraw->approved == 0): ?>
                <label class="badge badge-soft-info mb-0"><?php echo e(translate('Pending')); ?></label>
            <?php else: ?>
                <label class="badge badge-soft-danger mb-0"><?php echo e(translate('Denied')); ?></label>
            <?php endif; ?>
        </div>
        <div class="d-flex gap-2 align-items-center fs-12">
            <span><?php echo e(translate('request_time')); ?>:</span>
            <span><?php echo e(\App\CentralLogics\Helpers::time_date_format($withdraw->created_at)); ?></span>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <h6 class="mb-0 font-medium"><?php echo e(translate('messages.customer_info')); ?></h6>
        </div>
        <div class="card-body">
            <div class="key-val-list d-flex flex-column mb-2 gap-2" style="--min-width: 60px">
                <div class="key-val-list-item d-flex gap-3">
                    <span><?php echo e(translate('Name')); ?>:</span>
                    <span><?php echo e($withdraw->user->f_name.' '.$withdraw->user->l_name); ?></span>
                </div>
            </div>
            <div class="key-val-list d-flex flex-column mb-2 gap-2" style="--min-width: 60px">
                <div class="key-val-list-item d-flex gap-3">
                    <span><?php echo e(translate('Email')); ?>:</span>
                    <span class="text-title"><?php echo e($withdraw->user->email); ?></span>
                </div>
            </div>
            <div class="key-val-list d-flex flex-column mb-2 gap-2" style="--min-width: 60px">
                <div class="key-val-list-item d-flex gap-3">
                    <span><?php echo e(translate('Phone')); ?>:</span>
                    <span class="text-title"><?php echo e($withdraw->user->phone); ?></span>
                </div>
            </div>

            <div class="rounded bg-light p-3 mt-3">
                <div class="key-val-list-item d-flex gap-3 align-items-center lh-1">
                    <span><?php echo e(translate('wallet_Balance')); ?>:</span>
                    <span class="font-semibold text-primary fs-16"><?php echo e(\App\CentralLogics\Helpers::format_currency($withdraw->user->wallet_balance ?? 0)); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <h6 class="mb-0 font-medium"><?php echo e(translate('payment_Info')); ?></h6>
        </div>
        <div class="card-body">
            <div class="key-val-list d-flex flex-column gap-2" style="--min-width: 60px">
                <div class="key-val-list-item d-flex gap-3">
                    <span><?php echo e(translate('method')); ?>:</span>
                    <span class="text-title"><?php echo e($withdraw?->method?->method_name ?? translate('messages.No_Data_found')); ?></span>
                </div>

                <?php if($withdraw?->withdrawal_method_fields): ?>
                    <?php $__currentLoopData = json_decode($withdraw?->withdrawal_method_fields, true) ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="key-val-list-item d-flex gap-3">
                            <span><?php echo e(translate($key)); ?>:</span>
                            <span><?php echo e(is_array($item) ? '' : htmlspecialchars($item)); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <h5 class="text-capitalize"><?php echo e(translate('messages.No_Data_found')); ?></h5>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if($withdraw->approved == 1): ?>
        <div class="">
            <h5 class="font-medium"><?php echo e(translate('approved_Note')); ?></h5>
            <div class="rounded bg-light p-3">
                <?php echo e(str_replace('_', ' ', $withdraw->transaction_note)); ?>

            </div>
        </div>
    <?php elseif($withdraw->approved == 2): ?>
        <div class="">
            <h5 class="font-medium"><?php echo e(translate('Denied_Note')); ?></h5>
            <div class="rounded bg-light p-3">
                <?php echo e(str_replace('_', ' ', $withdraw->transaction_note)); ?>

            </div>
        </div>
    <?php endif; ?>
</div>

<?php if($withdraw->approved == 0): ?>
    <div class="offcanvas-footer p-3 d-flex align-items-center justify-content-center gap-3 w-100 withdraw-offcanvas-footer">
        <button type="button" data-id="<?php echo e($withdraw->id); ?>" class="btn btn-soft-danger min-w-100px w-100 show-deny-view"><?php echo e(translate('deny')); ?></button>
        <button type="button" data-id="<?php echo e($withdraw->id); ?>" class="btn btn--primary min-w-100px w-100 show-approve-view"><?php echo e(translate('approve')); ?></button>
    </div>
<?php endif; ?>
<?php /**PATH /var/www/zaqoota/resources/views/admin-views/wallet/customer-partials/_side_view.blade.php ENDPATH**/ ?>