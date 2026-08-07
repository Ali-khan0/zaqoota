<?php $__env->startSection('title',translate('Accoutn transaction information')); ?>
<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(translate('messages.dashboard')); ?></a></li>
            <li class="breadcrumb-item" aria-current="page"><?php echo e(translate('messages.account_transaction')); ?></li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <div class="d-sm-flex row align-items-center justify-content-between mb-2">
        <div class="col-md-6">
             <h4 class=" mb-0 text-black-50"><?php echo e(translate('messages.deliverymen_earning_provide_information')); ?></h4>
        </div>
    </div>
    <div class="row mt-3">

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="h3 mb-0  "><?php echo e($account_transaction->restaurant?translate('messages.store'):translate('messages.deliveryman_info')); ?></h3>
                </div>
                <div class="card-body">
                    <div class="col-md-8 mt-2">
                        <h4><?php echo e(translate('messages.name')); ?>: <?php echo e($account_transaction->restaurant ? $account_transaction->restaurant->name : $account_transaction->deliveryman->f_name.' '.$account_transaction->deliveryman->l_name); ?></h4>
                        <h6><?php echo e(translate('messages.phone')); ?>  : <?php echo e($account_transaction->restaurant ? $account_transaction->restaurant->phone : $account_transaction->deliveryman->phone); ?></h6>
                        <h6><?php echo e(translate('messages.collected_cash')); ?> : <?php echo e(\App\CentralLogics\Helpers::format_currency($account_transaction->restaurant ? $account_transaction->restaurant->vendor->wallet->collected_cash : $account_transaction->deliveryman->wallet->collected_cash)); ?></h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            

            <div class="card">
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

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/deliveryman-earning-provide/view.blade.php ENDPATH**/ ?>