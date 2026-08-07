<?php $__env->startSection('title',translate('Withdraw information View')); ?>
<?php $__env->startPush('css_or_js'); ?>
    <!-- Custom styles for this page -->
    <link href="<?php echo e(asset('public/assets')); ?>/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="<?php echo e(asset('public/assets/css/croppie.css')); ?>" rel="stylesheet">

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $vendor = $wr?->vendor->stores[0]?->module_type == 'rental' ? 'Provider' : 'store';
    ?>
<div class="content container-fluid">
    <!-- Page Heading -->
    <div class="page-header">
        <h1 class="page-header-title mr-3 mb-md-0">
            <span class="page-header-icon">
                <img src="<?php echo e(asset('public/assets/admin/img/withdraw.png')); ?>" class="w--26" alt="">
            </span>
            <span>
                <?php echo e(translate($vendor.'_withdraw_information')); ?>

            </span>
        </h1>
    </div>
    <!-- Page Heading -->

    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <h5 class="d-flex __gap-5px text-capitalize">
                                <span><?php echo e(translate('messages.amount')); ?></span>
                                <span>:</span>
                                <span><?php echo e(\App\CentralLogics\Helpers::format_currency($wr->amount)); ?></span>
                            </h5>
                            <h5 class="d-flex __gap-5px">
                                <span><?php echo e(translate('messages.request_time')); ?></span><span>:</span><span><?php echo e($wr->created_at); ?></span>
                            </h5>
                        </div>
                        <div class="col-4">
                            <div class="d-flex __gap-5px">
                                <span><?php echo e(translate('messages.note')); ?></span><span>:</span><span> <?php echo e(translate($wr->transaction_note)); ?></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <?php if($wr->approved== 0): ?>
                                <button type="button" class="btn btn-success float-right" data-toggle="modal"
                                        data-target="#exampleModal"><?php echo e(translate('messages.proceed')); ?>

                                    <i class="tio-arrow-forward"></i>
                                </button>
                            <?php else: ?>
                                <div class="text-center float-right text-capitalize">
                                    <?php if($wr->approved==1): ?>
                                        <label class="badge badge-success p-2 rounded-bottom">
                                            <?php echo e(translate('messages.approved')); ?>

                                        </label>
                                    <?php else: ?>
                                        <label class="badge badge-danger p-2 rounded-bottom">
                                            <?php echo e(translate('messages.denied')); ?>

                                        </label>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <?php if($wr->method): ?>
        <div class="col-md-4">
            <div class="card min-height-260px">
                <div class="card-header">
                    <h3 class="h3 mb-0 text-capitalize"><?php echo e(translate($wr->method->method_name)); ?> </h3>
                    <i class="tio tio-dollar-outlined"></i>
                </div>
                <div class="card-body">
                    <div class="col-md-8 mt-2">
                    <?php $__empty_1 = true; $__currentLoopData = json_decode($wr->withdrawal_method_fields, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <h5 class="text-capitalize "> <?php echo e(translate($key)); ?>: <?php echo e($item); ?></h5>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <h5 class="text-capitalize"> <?php echo e(translate('messages.No_Data_found')); ?></h5>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php if($wr->vendor && $wr->vendor->stores[0]): ?>
            <div class="col-md-4">
                <div class="card min-height-260">
                    <div class="card-header">
                        <h3 class="h3 mb-0"><?php echo e(translate($vendor.'_info')); ?></h3>
                        <i class="tio tio-shop-outlined"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="d-flex __gap-5px"><span><?php echo e(translate($vendor)); ?></span> <span>:</span> <span><?php echo e($wr->vendor->stores[0]->name); ?></span></h5>
                        <h5 class="d-flex __gap-5px"><span><?php echo e(translate('messages.phone')); ?></span> <span>:</span> <span><?php echo e($wr->vendor->stores[0]->contact); ?></span></h5>
                        <h5 class="d-flex __gap-5px"><span><?php echo e(translate('messages.address')); ?></span> <span>:</span> <span><?php echo e($wr->vendor->stores[0]->address); ?></span></h5>
                        <h5 class="text-capitalize badge badge-success d-flex __gap-5px"><span><?php echo e(translate('messages.balance')); ?></span> <span>:</span> <span><?php echo e($wr->vendor->wallet->balance); ?></span></h5>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="col-md-4">
            <div class="card min-height-260">
                <div class="card-header">
                    <h3 class="h3 mb-0 "> <?php echo e(translate('messages.owner_info')); ?></h3>
                    <i class="tio tio-user-big-outlined"></i>
                </div>
                <div class="card-body">
                    <?php if($wr->vendor): ?>
                        <h5 class="d-flex __gap-5px"><span><?php echo e(translate('messages.name')); ?></span> <span>:</span> <span><?php echo e($wr->vendor->f_name); ?> <?php echo e($wr->vendor->l_name); ?></span></h5>
                        <h5 class="d-flex __gap-5px"><span><?php echo e(translate('messages.email')); ?></span> <span>:</span> <span><?php echo e($wr->vendor->email); ?></span></h5>
                        <h5 class="d-flex __gap-5px"><span><?php echo e(translate('messages.phone')); ?></span> <span>:</span> <span><?php echo e($wr->vendor->phone); ?></span></h5>
                    <?php else: ?>
                        <h5><?php echo e(translate('messages.'.$vendor.' deleted!')); ?></h5>
                    <?php endif; ?>

                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><?php echo e(translate('Withdraw request process')); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?php echo e(route('admin.transactions.store.withdraw_status',[$wr->id])); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label"><?php echo e(translate('messages.request')); ?>:</label>
                                <select name="approved" class="custom-select" id="inputGroupSelect02">
                                    <option value="1"><?php echo e(translate('messages.approve')); ?></option>
                                    <option value="2"><?php echo e(translate('messages.deny')); ?></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label"><?php echo e(translate('Note_about_transaction_or_request')); ?>:</label>
                                <textarea class="form-control" name="note" id="message-text"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(translate('messages.Close')); ?></button>
                            <button type="submit" class="btn btn-primary"><?php echo e(translate('messages.Submit')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/wallet/withdraw-view.blade.php ENDPATH**/ ?>