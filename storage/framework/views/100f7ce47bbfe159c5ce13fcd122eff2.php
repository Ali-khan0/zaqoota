<?php $__env->startSection('title',translate('messages.banner')); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
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
    <div class="mb-20 mt-2">
        <div class="js-nav-scroller hs-nav-scroller-horizontal">
            <?php echo $__env->make('admin-views.other-banners.partial.parcel-links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade show active">
            <div class="row g-3">
                <div class="col-lg-12 mb-3 mb-lg-2">
                    <div class="card h-100">
                        <form action="<?php echo e(route('admin.promotional-banner.update',[$banner['id']])); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <input type="text" name="key" value="promotional_banner"  hidden>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-12 d-flex justify-content-between">
                                            <span class="d-flex g-1">
                                                <img src="<?php echo e(asset('public/assets/admin/img/other-banner.png')); ?>" class="h-85" alt="">
                                                <h3 class="form-label d-block mb-2">
                                                    <?php echo e(translate('messages.Promotional_Banner_Edit')); ?>

                                                </h3>
                                            </span>
                                        </div>
                                        <div class="col-12">
                                            <label class="__upload-img aspect-4-1 m-auto d-block">
                                                <div class="img">
                                                    <img class="onerror-image"

                                                        src="<?php echo e($banner->value_full_url ?? asset('/public/assets/admin/img/upload-placeholder.png')); ?>" data-onerror-image="<?php echo e(asset('/public/assets/admin/img/upload-placeholder.png')); ?>" alt="">
                                                </div>
                                                    <input type="file" name="image"  hidden>
                                            </label>
                                            <div class="text-center mt-5">
                                                <h3 class="form-label d-block mt-2">
                                                <?php echo e(translate('Banner_Image_Ratio_4:1')); ?>

                                            </h3>
                                            <p><?php echo e(translate('image_format_:_jpg_,_png_,_jpeg_|_maximum_size:_2_MB')); ?></p>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn--container justify-content-end mt-20">
                                        <button type="submit" class="btn btn--primary mb-2"><?php echo e(translate('messages.Update')); ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/other-banners.js"></script>
        <script>
            $('#reset_btn').click(function(){
                $('#viewer').attr('src','<?php echo e(asset('/public/assets/admin/img/upload-placeholder.png')); ?>');
            })
        </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/other-banners/parcel-promotional-edit.blade.php ENDPATH**/ ?>