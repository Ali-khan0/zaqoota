<?php $__env->startSection('title',translate('Withdraw Request')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center py-2">
                <div class="col-sm mb-2 mb-sm-0">
                    <div class="d-flex align-items-center">
                        <img src="<?php echo e(asset('/public/assets/admin/img/new-img/users.svg')); ?>" alt="img">
                        <div class="w-0 flex-grow pl-3">
                            <h1 class="page-header-title mb-0"><?php echo e(translate('messages.Transaction Overview')); ?></h1>
                            <p class="page-header-text m-0"><?php echo e(translate('Hello, here you can manage your transactions.')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/wallet/withdraw-dashboard.blade.php ENDPATH**/ ?>