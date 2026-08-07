<?php $__env->startSection('title',translate('Update Banner')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/edit.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.update_banner')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="<?php echo e(route('vendor.banner.update', [$banner->id])); ?>" method="POST" enctype="multipart/form-data" class="custom-validation">
                    <?php echo csrf_field(); ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12 d-flex justify-content-between">
                                    <h3 class="form-label d-block mb-2">
                                        <?php echo e(translate('Upload_Banner')); ?>

                                    </h3>

                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group error-wrapper">

                                        <label for="title" class="form-label"><?php echo e(translate('title')); ?></label>
                                        <input id="title" type="text" name="title" class="form-control" value="<?php echo e($banner->title); ?>" placeholder="<?php echo e(translate('messages.title_here...')); ?>" required>
                                    </div>
                                    <div class="form-group error-wrapper">

                                        <label for="default_link" class="form-label"><?php echo e(translate('Redirection_URL_/_Link')); ?></label>
                                        <input id="default_link" type="url" name="default_link" class="form-control" value="<?php echo e($banner->default_link); ?>" placeholder="<?php echo e(translate('messages.Enter_URL')); ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="upload-img-3 m-0 d-block error-wrapper">
                                        <div class="img">
                                            <img src="<?php echo e($banner['image_full_url']); ?>"
                                            id="viewer"
                                                 data-onerror-image="<?php echo e(asset('/public/assets/admin/img/upload-4.png')); ?>"
                                                  class="vertical-img mw-100 vertical onerror-image" alt="">
                                        </div>
                                            <input type="file" name="image"  hidden>
                                    </label>
                                    <h3 class="form-label d-block mt-2">
                                        <?php echo e(translate('Banner_Image_Ratio_3:1')); ?>

                                    </h3>
                                    <p><?php echo e(translate('image_format_:_jpg_,_png_,_jpeg_|_maximum_size:_2_MB')); ?></p>
                                </div>
                                <div class="col-sm-6">
                                </div>
                            </div>
                            <div class="btn--container justify-content-end mt-20">
                                <button type="reset" id="reset_btn" class="btn btn--reset"><?php echo e(translate('Reset')); ?></button>
                                <button type="submit" class="btn btn--primary"><?php echo e(translate('Update')); ?></button>
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
            $('#reset_btn').click(function(){
                $('#viewer').attr('src','<?php echo e(asset('storage/app/public/banner')); ?>/<?php echo e($banner['image']); ?>');
            })
        </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/banner/edit.blade.php ENDPATH**/ ?>