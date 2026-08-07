<?php $__env->startSection('title',translate('Vehicles Bulk Export')); ?>



<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/items.png')); ?>" class="w--20" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.vehicles_bulk_export')); ?>

                </span>
            </h1>
        </div>
        <div class="card mt-2 rest-part">
            <div class="card-body">
                <div class="export-steps-2">
                    <div class="row g-4">
                        <div class="col-sm-6 col-lg-4">
                            <div class="export-steps-item-2 h-100">
                                <div class="top">
                                    <div>
                                        <h3 class="fs-20"><?php echo e(translate('Step 1')); ?></h3>
                                        <div>
                                            <?php echo e(translate('Select Data Type')); ?>

                                        </div>
                                    </div>
                                    <img src="<?php echo e(asset('/public/assets/admin/img/bulk-export-1.png')); ?>" alt="">
                                </div>
                                <h4><?php echo e(translate('Instruction')); ?></h4>
                                <ul class="m-0 pl-4">
                                    <li>
                                       <?php echo e(translate('Download the format file and fill it with proper data.')); ?>

                                    </li>
                                    <li>
                                       <?php echo e(translate('You can download the example file to understand how the data must be filled.')); ?>

                                    </li>
                                    <li>
                                       <?php echo e(translate('Have to upload zip file')); ?>

                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="export-steps-item-2 h-100">
                                <div class="top">
                                    <div>
                                        <h3 class="fs-20"><?php echo e(translate('Step 2')); ?></h3>
                                        <div>
                                            <?php echo e(translate('Select Data Range by Date or ID and Export')); ?>

                                        </div>
                                    </div>
                                    <img src="<?php echo e(asset('/public/assets/admin/img/bulk-export-2.png')); ?>" alt="">
                                </div>
                                <h4><?php echo e(translate('Instruction')); ?></h4>
                                <ul class="m-0 pl-4">
                                    <li>
                                        <?php echo e(translate('Download the format file and fill it with proper data.')); ?>

                                    </li>
                                    <li>
                                        <?php echo e(translate('You can download the example file to understand how the data must be filled.')); ?>

                                    </li>
                                    <li>
                                        <?php echo e(translate('Have to upload zip file')); ?>

                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="product-form" action="" method="POST"
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
                                <button type="reset" id="reset-btn" class="btn btn--reset"><?php echo e(translate('clear')); ?></button>
                                <button type="submit" class="btn btn--primary"><?php echo e(translate('export')); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
 <script src="<?php echo e(asset('Modules/Rental/public/assets/js/admin/view-pages/vehicle-bulk-export.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/vehicle/bulk-export.blade.php ENDPATH**/ ?>