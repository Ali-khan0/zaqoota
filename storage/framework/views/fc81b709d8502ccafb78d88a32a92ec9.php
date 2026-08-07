<?php $__env->startSection('title',translate('messages.edit_account_transaction')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(translate('messages.dashboard')); ?></a></li>
            <li class="breadcrumb-item" aria-current="page"><?php echo e(translate('messages.account_transaction')); ?>  </li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <!-- <h4 class=" mb-0 text-black-50"><?php echo e(translate('messages.account_transaction')); ?></h4> -->
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="text-capitalize"><?php echo e(translate('messages.add_account_transaction')); ?></h4>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('admin.account-transaction.store')); ?>" method='post' id="add_transaction">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                        <label class="input-label" for="type"><?php echo e(translate('messages.type')); ?><span class="input-label-secondary"></span></label>
                            <select name="type" id="type" class="form-control">
                                <option value="deliveryman" <?php echo e($account_transaction->from_type=='deliveryman'?'selected':''); ?>><?php echo e(translate('messages.deliveryman')); ?></option>
                                <option value="restaurant" <?php echo e($account_transaction->from_type=='deliveryman'?'selected':''); ?>><?php echo e(translate('messages.store')); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="input-label" for="restaurant"><?php echo e(translate('messages.store')); ?><span class="input-label-secondary"></span></label>
                            <select id="restaurant" name="store_id" data-placeholder="<?php echo e(translate('messages.select_store')); ?>" class="form-control" title="Select Restaurant" <?php echo e($account_transaction->deliveryman?'disabled':''); ?>>

                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="input-label" for="deliveryman"><?php echo e(translate('messages.deliveryman')); ?><span class="input-label-secondary"></span></label>
                            <select id="deliveryman" name="deliveryman_id" data-placeholder="<?php echo e(translate('messages.select_deliveryman')); ?>" class="form-control" title="Select deliveryman" <?php echo e($account_transaction->restaurant?'disabled':''); ?>>

                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="input-label" for="method"><?php echo e(translate('messages.method')); ?><span class="input-label-secondary"></span></label>
                            <input class="form-control" type="text" name="method" id="method" value="<?php echo e($account_transaction->method); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="input-label" for="ref"><?php echo e(translate('messages.reference')); ?><span class="input-label-secondary"></span></label>
                            <input  class="form-control" type="text" name="ref" id="ref" value="<?php echo e($account_transaction->ref); ?>">>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="input-label" for="amount"><?php echo e(translate('messages.amount')); ?><span class="input-label-secondary"></span></label>
                            <input class="form-control" type="number" min="1" step="0.01" name="amount" id="amount" value="<?php echo e($account_transaction->amount); ?>">>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="<?php echo e(translate('messages.save')); ?>" >
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/deliveryman-earning-provide.js"></script>
<script>
    "use strict";
    $('#restaurant').select2({
        ajax: {
            url: '<?php echo e(url('/')); ?>/admin/store/get-stores',
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data) {
                return {
                results: data
                };
            },
            __port: function (params, success, failure) {
                var $request = $.ajax(params);

                $request.then(success);
                $request.fail(failure);

                return $request;
            }
        }
    });

    $('#deliveryman').select2({
        ajax: {
            url: '<?php echo e(url('/')); ?>/admin/users/delivery-man/get-deliverymen',
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data) {
                return {
                results: data
                };
            },
            __port: function (params, success, failure) {
                var $request = $.ajax(params);

                $request.then(success);
                $request.fail(failure);

                return $request;
            }
        }
    });

    $('#add_transaction').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post({
            url: '<?php echo e(route('admin.account-transaction.update')); ?>',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.errors) {
                    for (var i = 0; i < data.errors.length; i++) {
                        toastr.error(data.errors[i].message, {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                } else {
                    toastr.success('<?php echo e(translate('messages.transaction_updated')); ?>', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                    setTimeout(function () {
                        location.href = '<?php echo e(route('admin.account-transaction.index')); ?>';
                    }, 2000);
                }
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/deliveryman-earning-provide/edit.blade.php ENDPATH**/ ?>