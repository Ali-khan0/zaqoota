<?php $__env->startSection('title',translate('Item Bulk Export')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/category.png')); ?>" class="w--20" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.export_items')); ?>

                </span>
            </h1>
        </div>
        <div class="card mt-2 rest-part">
            <div class="card-body">
                <div class="export-steps">
                    <div class="export-steps-item">
                        <div class="inner">
                            <h5><?php echo e(translate('STEP 1')); ?></h5>
                            <p>
                                <?php echo e(translate('Select Data Type')); ?>

                            </p>
                        </div>
                    </div>
                    <div class="export-steps-item">
                        <div class="inner">
                            <h5><?php echo e(translate('STEP 2')); ?></h5>
                            <p>
                                <?php echo e(translate('Select Data Range and Export')); ?>

                            </p>
                        </div>
                    </div>
                </div>
                <form class="product-form" action="<?php echo e(route('vendor.item.bulk-export')); ?>" method="POST"
                        enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlSelect1"><?php echo e(translate('messages.type')); ?><span
                                        class="input-label-secondary"></span></label>
                                <select name="type" id="type" data-placeholder="<?php echo e(translate('messages.select_type')); ?>" class="form-control" required title="Select Type">
                                    <option value="all"><?php echo e(translate('messages.all_data')); ?></option>
                                    <option value="date_wise"><?php echo e(translate('messages.date_wise')); ?></option>
                                    <option value="id_wise"><?php echo e(translate('messages.id_wise')); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group id_wise">
                                <label class="input-label" for="exampleFormControlSelect1"><?php echo e(translate('messages.start_id')); ?><span
                                        class="input-label-secondary"></span></label>
                                <input type="number" name="start_id" class="form-control">
                            </div>
                            <div class="form-group date_wise">
                                <label class="input-label" for="exampleFormControlSelect1"><?php echo e(translate('messages.from_date')); ?><span
                                        class="input-label-secondary"></span></label>
                                <input type="date" name="from_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group id_wise">
                                <label class="input-label" for="exampleFormControlSelect1"><?php echo e(translate('messages.end_id')); ?><span
                                        class="input-label-secondary"></span></label>
                                <input type="number" name="end_id" class="form-control">
                            </div>
                            <div class="form-group date_wise">
                                <label class="input-label text-capitalize" for="exampleFormControlSelect1"><?php echo e(translate('messages.to_date')); ?><span
                                        class="input-label-secondary"></span></label>
                                <input type="date" name="to_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="btn--container justify-content-end">
                                <button class="btn btn--reset" type="reset"><?php echo e(translate('messages.reset')); ?></button>
                                <button class="btn btn--primary" type="submit"><?php echo e(translate('messages.export')); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
<script>
    "use strict";
    $(document).on('ready', function (){
        $('.id_wise').hide();
        $('.date_wise').hide();
        $('#type').on('change', function()
        {
            $('.id_wise').hide();
            $('.date_wise').hide();
            $('.'+$(this).val()).show();
        })
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/product/bulk-export.blade.php ENDPATH**/ ?>