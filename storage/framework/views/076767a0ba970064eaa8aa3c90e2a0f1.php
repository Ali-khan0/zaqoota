<?php $__env->startSection('title',translate('messages.add_vehicle_category')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-sm mb-2 mb-sm-0">
                <h1 class="page-header-title">
                    <div class="page-header-icon"><i class="tio-add-circle-outlined"></i></div>
                    <?php echo e(translate('messages.add_vehicle_category')); ?>

                </h1>
            </div>
        </div>
    </div>
    <!-- End Page Header -->
    <div class="card">
        <div class="card-body">
            <form action="<?php echo e(route('admin.users.delivery-man.vehicle.store')); ?>" method="post"
                enctype="multipart/form-data" id="vehicle-form">
                <?php echo csrf_field(); ?>
                <?php if($language): ?>
                <ul class="nav nav-tabs mb-4">
                    <li class="nav-item">
                        <a class="nav-link lang_link active" href="#"
                            id="default-link"><?php echo e(translate('messages.default')); ?></a>
                    </li>
                    <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="nav-item">
                        <a class="nav-link lang_link" href="#" id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <?php endif; ?>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <?php if($language): ?>
                                <div class="form-group lang_form" id="default-form">
                                    <label class="input-label text-capitalize"
                                        for="title"><?php echo e(translate('messages.Vehicle_type')); ?> (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary text-danger"
                                            data-toggle="tooltip" data-placement="right"
                                            data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                        </span>
                                    </label>
                                    <input type="text" name="type[]" class="form-control h--45px"
                                        placeholder="<?php echo e(translate('messages.ex_:_bike')); ?>" maxlength="191" required>
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                                <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-group d-none lang_form" id="<?php echo e($lang); ?>-form">
                                    <label class="input-label text-capitalize"
                                        for="title"><?php echo e(translate('messages.Vehicle_type')); ?>

                                        (<?php echo e(strtoupper($lang)); ?>)</label>
                                    <input type="text" name="type[]" class="form-control h--45px"
                                        placeholder="<?php echo e(translate('messages.ex_:_bike')); ?>" maxlength="191">
                                </div>
                                <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                <div class="form-group">
                                    <label class="input-label text-capitalize"
                                        for="title"><?php echo e(translate('messages.Vehicle_type')); ?></label>
                                    <input type="text" name="type" class="form-control h--45px"
                                        placeholder="<?php echo e(translate('messages.ex_:_bike')); ?>" required maxlength="191">
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-label text-capitalize"
                                        for="title"><?php echo e(translate('messages.extra_charges')); ?> (<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>) <span
                                            class="input-label-secondary" data-toggle="tooltip" data-placement="right"
                                            data-original-title="<?php echo e(translate('This amount will be added with delivery charge')); ?>"><img
                                                src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                alt="public/img"></span><span class="form-label-secondary text-danger"
                                            data-toggle="tooltip" data-placement="right"
                                            data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                        </span>
                                    </label>
                                    <input type="number" id="extra_charges" class="form-control h--45px" step="0.001"
                                        min="0" required name="extra_charges">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-label text-capitalize"
                                        for="title"><?php echo e(translate('messages.Starting_coverage_area')); ?> (<?php echo e(translate('messages.km')); ?>) <span class="input-label-secondary"
                                            data-toggle="tooltip" data-placement="right"
                                            data-original-title="<?php echo e(translate('the_starting_coverage_area_represents_the_location_where_deliveries_are_made.')); ?>"><img
                                                src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                alt="public/img"></span><span class="form-label-secondary text-danger"
                                            data-toggle="tooltip" data-placement="right"
                                            data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                        </span>
                                    </label>
                                    <input type="number" id="starting_coverage_area" class="form-control h--45px"
                                        step="0.001" min="0" required name="starting_coverage_area">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="input-label text-capitalize"
                                        for="title"><?php echo e(translate('messages.maximum_coverage_area')); ?> (<?php echo e(translate('messages.km')); ?>) <span class="input-label-secondary"
                                            data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('the_maximum_coverage_area_represents_the_farthest_or_widest_extent_to_which_deliveries_can_be_made')); ?>"><img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                alt="public/img"></span><span class="form-label-secondary text-danger"
                                            data-toggle="tooltip" data-placement="right"
                                            data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                        </span>
                                    </label>
                                    <input type="number" id="maximum_coverage_area" class="form-control h--45px"
                                        step="0.001" min="0" required name="maximum_coverage_area">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="btn--container justify-content-end">
                    <button type="reset" id="reset_btn" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                    <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.submit')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/dm-vehichle.js"></script>
<script>
    "use strict";
        $('#vehicle-form').on('submit', function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '<?php echo e(route('admin.users.delivery-man.vehicle.store')); ?>',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.errors) {
                        for (let i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        toastr.success('<?php echo e(translate('messages.Vehicle_category_created')); ?>', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        setTimeout(function () {
                            location.href = '<?php echo e(route('admin.users.delivery-man.vehicle.list')); ?>';
                        }, 1000);
                    }
                }
            });
        });

        $('#reset_btn').click(function(){
            $('#choice_item').val(null).trigger('change');
            $('#viewer').attr('src','<?php echo e(asset('public/assets/admin/img/900x400/img1.jpg')); ?>');
        })
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/dm-vehicle/index.blade.php ENDPATH**/ ?>