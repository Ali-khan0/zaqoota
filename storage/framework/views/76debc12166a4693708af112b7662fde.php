<?php $__env->startSection('title',translate('Account transaction information')); ?>
<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <div class="page-header">
        <h1 class="page-header-title">
            <span class="page-header-icon">
                <img src="<?php echo e(asset('public/assets/admin/img/report.png')); ?>" class="w--22" alt="">
            </span>
            <span>
                <?php echo e(translate('messages.account_transaction_information')); ?>

            </span>
        </h1>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="h3 mb-0  "><?php echo e($account_transaction->from_type == 'store'?translate('messages.store'):translate('messages.deliveryman_info')); ?></h3>
                </div>
                <div class="card-body">
                    <div class="col-md-8 mt-2">
                        <h4><?php echo e(translate('messages.name')); ?>: <?php echo e($account_transaction->from_type == 'store' ?($account_transaction->store? $account_transaction->store->name : translate('messages.store deleted!')):($account_transaction->deliveryman? $account_transaction->deliveryman->f_name.' '.$account_transaction->deliveryman->l_name : translate('messages.Delivery Man Not Found'))); ?></h4>
                        <h6><?php echo e(translate('messages.phone')); ?>  : <?php echo e($account_transaction->from_type == 'store'?($account_transaction->store ? $account_transaction->store->phone : translate('messages.store deleted!')):($account_transaction->deliveryman ? $account_transaction->deliveryman->phone : translate('messages.Delivery Man Not Found'))); ?></h6>
                        <h6><?php echo e(translate('messages.cash_in_hand')); ?> : <?php echo e(\App\CentralLogics\Helpers::format_currency($account_transaction->from_type == 'store' ? ($account_transaction->store ? $account_transaction->store->vendor->wallet->collected_cash : 0): ($account_transaction->deliveryman ? $account_transaction->deliveryman->wallet->collected_cash : 0))); ?></h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="h3 mb-0  "><?php echo e(translate('messages.transaction_information')); ?> </h3>
                </div>
                <div class="card-body">
                    <h6><?php echo e(translate('messages.amount')); ?> : <?php echo e(\App\CentralLogics\Helpers::format_currency($account_transaction->amount)); ?></h6>
                    <h6 class="text-capitalize"><?php echo e(translate('messages.time')); ?> : <?php echo e($account_transaction->created_at->format('Y-m-d '.config('timeformat'))); ?></h6>
                    <h6><?php echo e(translate('messages.method')); ?> : <?php echo e($account_transaction->method); ?></h6>
                    <h6><?php echo e(translate('messages.reference')); ?> : <?php echo e($account_transaction->ref); ?></h6>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/account/view.blade.php ENDPATH**/ ?>