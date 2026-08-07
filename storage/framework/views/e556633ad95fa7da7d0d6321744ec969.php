<?php $__env->startSection('title',translate('Withdraw information View')); ?>
<?php $__env->startPush('css_or_js'); ?>
    <!-- Custom styles for this page -->
    <link href="<?php echo e(asset('public/assets')); ?>/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="<?php echo e(asset('public/assets/css/croppie.css')); ?>" rel="stylesheet">

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(translate('messages.Dashboard')); ?></a></li>
            <li class="breadcrumb-item" aria-current="page"><?php echo e(translate('messages.seller_Withdraw')); ?></li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <div class="d-sm-flex row align-items-center justify-content-between mb-2">
        <div class="col-md-6">
             <h4 class=" mb-0 text-black-50"><?php echo e(translate('messages.seller_Withdraw_information')); ?></h4>
            </div>

    </div>
    <div class="row mt-3">

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="h3 mb-0  "><?php echo e(translate('messages.my_bank_info')); ?> </h3>
                </div>
                <div class="card-body">
                    <div class="col-md-8 mt-2">

                        <h4><?php echo e(translate('messages.bank_name')); ?>: <?php echo e($seller->seller->bank_name ? $seller->seller->bank_name : 'No Data found'); ?></h4>
                        <h6><?php echo e(translate('messages.Branch')); ?>  : <?php echo e($seller->seller->branch ? $seller->seller->branch : 'No Data found'); ?></h6>
                        <h6><?php echo e(translate('messages.holder_name')); ?> : <?php echo e($seller->seller->holder_name ? $seller->seller->holder_name : 'No Data found'); ?></h6>
                        <h6><?php echo e(translate('messages.account_no')); ?>  : <?php echo e($seller->seller->account_no ? $seller->seller->account_no : 'No Data found'); ?></h6>



                    </div>
                </div>
            </div>
        </div>
        <?php if($seller->seller->shop): ?>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <?php echo e(translate('messages.Shop_info')); ?>

                </div>
                <div class="card-body">
                    <h5><?php echo e(translate('messages.seller_b')); ?> : <?php echo e($seller->seller->shop->name); ?></h5>
                    <h5><?php echo e(translate('messages.Phone')); ?> : <?php echo e($seller->seller->shop->contact); ?></h5>
                    <h5><?php echo e(translate('messages.address')); ?> : <?php echo e($seller->seller->shop->address); ?></h5>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="row mt-3" >
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <?php echo e(translate('messages.Seller_info')); ?>

                </div>
                <div class="card-body">
                    <h5><?php echo e(translate('messages.name')); ?> : <?php echo e($seller->seller->f_name); ?> <?php echo e($seller->seller->l_name); ?></h5>
                    <h5><?php echo e(translate('messages.Email')); ?> : <?php echo e($seller->seller->email); ?></h5>
                    <h5><?php echo e(translate('messages.Phone')); ?> : <?php echo e($seller->seller->phone); ?></h5>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            

            <div class="card">
                <div class="card-header">
                    <h3 class="h3 mb-0  "><?php echo e(translate('messages.Withdraw_information')); ?> </h3>
                </div>
                <div class="card-body">
                    <h5><?php echo e(translate('messages.amount')); ?> : <?php echo e($seller->amount); ?></h5>
                    <h5><?php echo e(translate('messages.request_time')); ?> : <?php echo e($seller->created_at); ?></h5>
                    
                    <?php if($seller->approved== 0): ?>

                    <div class="text-center mt-3">
                        <form class="d-inline-block" action="<?php echo e(route('admin.sellers.withdraw_status')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="id" value="<?php echo e($seller->id); ?>">
                            <input type="hidden" name="approved" value="1">
                            <button type="submit" class="btn btn-primary"><?php echo e(translate('messages.Approve')); ?></button>
                        </form>
                        <form class="d-inline-block" action="<?php echo e(route('admin.sellers.withdraw_status')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="id" value="<?php echo e($seller->id); ?>">
                            <input type="hidden" name="approved" value="2">
                            <button type="submit" class="btn btn-danger"><?php echo e(translate('messages.Denied')); ?></button>
                        </form>
                    </div>
                    <?php else: ?>
                      <div class="text-center col-sm-3  mt-3">

                    <?php if($seller->approved==1): ?>
                        <label class="badge badge-success p-2 rounded-bottom"><?php echo e(translate('messages.Approved')); ?></label>
                    <?php else: ?>
                        <label class="badge badge-danger p-2 rounded-bottom"><?php echo e(translate('messages.Denied')); ?></label>
                    <?php endif; ?>
                          
                      </div>
                    <?php endif; ?>
                </div>
            </div>



        </div>



    </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <!-- Page level plugins -->
    <script src="<?php echo e(asset('public/assets')); ?>/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo e(asset('public/assets')); ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script>
        "use strict";
        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/wallet/withdraw-view.blade.php ENDPATH**/ ?>