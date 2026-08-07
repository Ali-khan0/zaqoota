<?php $__env->startSection('title', translate('messages.banner')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php ($best_reviewed_section_banner = \App\Models\ModuleWiseBanner::where('module_id', Config::get('module.current_module_id'))->where('key', 'best_reviewed_section_banner')->first()); ?>
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-header-title">
            <span class="page-header-icon">
                <img src="<?php echo e(asset('public/assets/admin/img/3rd-party.png')); ?>" class="w--26" alt="">
            </span>
            <span>
                <?php echo e(translate('messages.Other_Promotional_Content_Setup')); ?>

            </span>
        </h1>
    </div>
    <!-- End Page Header -->
    <div class="row g-3">
        <div class="col-lg-6 mb-3 mb-lg-2">
            <div class="card h-100">
                <form action="<?php echo e(route('admin.promotional-banner.store')); ?>" method="POST"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="text" name="key" value="best_reviewed_section_banner" hidden>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 d-flex justify-content-between">
                                <span class="d-flex g-1">
                                    <img src="<?php echo e(asset('public/assets/admin/img/other-banner.png')); ?>" class="h-85"
                                        alt="">
                                    <h3 class="form-label d-block mb-2">
                                        <?php echo e(translate('Best_Reviewed_Section_Banner')); ?>

                                    </h3>
                                </span>
                                <div>
                                    <div class="blinkings">
                                        <div>
                                            <i class="tio-info-outined"></i>
                                        </div>
                                        <div class="business-notes">
                                            <h6><img src="<?php echo e(asset('/public/assets/admin/img/notes.png')); ?>" alt="">
                                                <?php echo e(translate('Note')); ?></h6>
                                            <div>
                                                <?php echo e(translate('messages.this_banner_is_only_for_react_web.')); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <h3 class="form-label d-block mb-5 text-center">
                                    <?php echo e(translate('Upload_Banner')); ?>

                                </h3>
                                <label class="__upload-img aspect-235-375 m-auto d-block position-relative">
                                    <div class="img">
                                        <img class="onerror-image"
                                            src="<?php echo e(\App\CentralLogics\Helpers::get_full_url('promotional_banner', $best_reviewed_section_banner?->value ?? '', $best_reviewed_section_banner?->storage[0]?->value ?? 'public', 'upload_placeholder')); ?>"
                                            data-onerror-image="<?php echo e(asset('/public/assets/admin/img/upload-placeholder.png')); ?>"
                                            alt="">
                                    </div>
                                    <div class="">
                                        <input type="file" name="image" hidden>
                                    </div>
                                    <?php if(isset($best_reviewed_section_banner?->value)): ?>
                                        <span id="best_reviewed_section_banner" class="remove_image_button dynamic-checkbox"
                                            data-id="best_reviewed_section_banner" data-type="status"
                                            data-image-on="<?php echo e(asset('/public/assets/admin/img/modal')); ?>/mail-success.png"
                                            data-image-off="<?php echo e(asset('/public/assets/admin/img/modal')); ?>/mail-warning.png"
                                            data-title-on="<?php echo e(translate('Important!')); ?>"
                                            data-title-off="<?php echo e(translate('Warning!')); ?>"
                                            data-text-on="<p><?php echo e(translate('Are_you_sure_you_want_to_remove_this_image')); ?></p>"
                                            data-text-off="<p><?php echo e(translate('Are_you_sure_you_want_to_remove_this_image.')); ?></p>">
                                            <i class="tio-clear"></i></span>
                                    <?php endif; ?>
                                </label>

                                <div class="text-center mt-5">
                                    <h3 class="form-label d-block mt-2">
                                        <?php echo e(translate('Min_Size_for_Better_Resolution_235_x_375_px')); ?>

                                    </h3>
                                    <p><?php echo e(translate('image_format_:_jpg_,_png_,_jpeg_|_maximum_size:_2_MB')); ?></p>

                                </div>
                            </div>
                        </div>
                        <div class="btn--container justify-content-end mt-20">
                            <button type="submit" class="btn btn--primary mb-2"><?php echo e(translate('Submit')); ?></button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<form id="best_reviewed_section_banner_form" action="<?php echo e(route('admin.remove_image')); ?>" method="post">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="id" value="<?php echo e($best_reviewed_section_banner?->id); ?>">
    
    <input type="hidden" name="model_name" value="ModuleWiseBanner">
    <input type="hidden" name="image_path" value="promotional_banner">
    <input type="hidden" name="field_name" value="value">
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/other-banners.js"></script>
    <script>
        $('#reset_btn').click(function () {
            $('#viewer').attr('src', '<?php echo e(asset('/public/assets/admin/img/upload-placeholder.png')); ?>');
        })
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/other-banners/food-index.blade.php ENDPATH**/ ?>