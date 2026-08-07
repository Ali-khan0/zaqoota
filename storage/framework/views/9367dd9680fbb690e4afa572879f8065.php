<?php $__env->startSection('title',translate('messages.modules')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><?php echo e(translate('messages.module_type')); ?></h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <div class="card">
            <div class="card-header"><h5><?php echo e(translate('messages.add_new_module')); ?></h5></div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.module.create')); ?>" method="get" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.type')); ?></label>
                        <input type="text" name="module_type" class="form-control" placeholder="<?php echo e(translate('messages.new_category')); ?>" value="<?php echo e(old('name')); ?>" required maxlength="191">
                    </div>

                    <div class="form-group">
                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.description')); ?></label>
                        <textarea class="ckeditor form-control" name="module_description"></textarea>
                    </div>

                    <div class="form-group pt-2">
                        <button type="submit" class="btn btn-primary"><?php echo e(translate('messages.add')); ?></button>
                    </div>

                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header pb-0">
                <h5><?php echo e(translate('messages.module_type_list')); ?></h5>
            </div>
            <div class="card-body">
                <div class="table-responsive datatable-custom">
                    <table id="columnSearchDatatable"
                        class="table table-borderless table-thead-bordered table-align-middle" data-hs-datatables-options='{
                            "isResponsive": false,
                            "isShowPaging": false,
                            "paging":false,
                        }'>
                        <thead class="thead-light">
                            <tr>
                                <th><?php echo e(translate('messages.module_type')); ?></th>
                                <th><?php echo e(translate('messages.description')); ?></th>
                            </tr>
                        </thead>

                        <tbody id="table-div">
                        <?php $__currentLoopData = $module_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <span class="d-block font-size-sm text-body">
                                        <?php echo e(Str::limit($module['module_type'], 20,'...')); ?>

                                    </span>
                                </td>
                                <td>
                                    <?php echo $module->description; ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin/ckeditor/ckeditor.js')); ?>"></script>
    <script>
        "use strict";
        $(document).ready(function () {
            $('.ckeditor').ckeditor();
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/module/module_type.blade.php ENDPATH**/ ?>