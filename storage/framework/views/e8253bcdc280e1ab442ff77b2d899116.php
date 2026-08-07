<?php $__env->startSection('title',translate('messages.Bank Info View')); ?>
<?php $__env->startPush('css_or_js'); ?>
    <!-- Custom styles for this page -->
    <link href="<?php echo e(asset('public/assets/back-end')); ?>/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('vendor.dashboard')); ?>"><?php echo e(translate('messages.dashboard')); ?></a></li>
                <li class="breadcrumb-item" aria-current="page"><?php echo e(translate('messages.store')); ?></li>
                <li class="breadcrumb-item"><?php echo e(translate('messages.my_bank_info')); ?></li>
            </ol>
        </nav>

        <!-- Page Heading -->
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="h3 mb-0 text-capitalize"><?php echo e(translate('messages.my_bank_info')); ?>  </h3>
                    </div>
                    <div class="card-body">
                        <div class="col-md-8 mt-4">
                            <h4><?php echo e(translate('messages.bank_name')); ?>

                                : <?php echo e($data->bank_name ? $data->bank_name : 'No Data found'); ?></h4>
                            <h6><?php echo e(translate('messages.branch')); ?> : <?php echo e($data->branch ? $data->branch : 'No Data found'); ?></h6>
                            <h6><?php echo e(translate('messages.holder_name')); ?>

                                : <?php echo e($data->holder_name ? $data->holder_name : 'No Data found'); ?></h6>
                            <h6><?php echo e(translate('messages.account_no')); ?>

                                : <?php echo e($data->account_no ? $data->account_no : 'No Data found'); ?></h6>


                            <a class="btn btn-primary"
                               href="<?php echo e(route('vendor.profile.bankInfo')); ?>"><?php echo e(translate('messages.edit')); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <!-- Page level plugins -->
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/profile/view.blade.php ENDPATH**/ ?>