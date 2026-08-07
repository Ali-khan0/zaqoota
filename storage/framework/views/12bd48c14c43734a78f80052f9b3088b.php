<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/banner.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.Banners')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h5 class="text-title mb-1">
                                <?php echo e(translate('messages.Update_Banner')); ?>

                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo e(route('vendor.rental_banner.update',[$banner->id])); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row g-3">
                                <div class="col-lg-6">
                                    <div class="__bg-FAFAFA p-4 radius-10 mb-4">
                                        <?php if($language): ?>
                                            <ul class="nav nav-tabs mb-3 border-0">
                                                <li class="nav-item">
                                                    <a class="nav-link lang_link active" href="#"
                                                        id="default-link"><?php echo e(translate('messages.default')); ?></a>
                                                </li>
                                                <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li class="nav-item">
                                                        <a class="nav-link lang_link" href="#"
                                                            id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                            <div class="lang_form" id="default-form">
                                                <div class="form-group mb-0">
                                                    <label class="input-label"
                                                        for="default_title"><?php echo e(translate('messages.title')); ?>

                                                        (<?php echo e(translate('Default')); ?>)
                                                    </label>
                                                    <input type="text" name="title[]" id="default_title"
                                                        class="form-control" value="<?php echo e($banner?->getRawOriginal('title')); ?>"
                                                        placeholder="<?php echo e(translate('messages.new_banner')); ?>">
                                                </div>
                                                <input type="hidden" name="lang[]" value="default">
                                            </div>
                                            <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <?php
                                            if(count($banner['translations'])){
                                                $translate = [];
                                                foreach($banner['translations'] as $t)
                                                {
                                                    if($t->locale == $lang && $t->key=="title"){
                                                        $translate[$lang]['title'] = $t->value;
                                                    }
                                                }
                                            }
                                        ?>

                                                <div class="d-none lang_form" id="<?php echo e($lang); ?>-form">
                                                    <div class="form-group mb-0">
                                                        <label class="input-label"
                                                            for="<?php echo e($lang); ?>_title"><?php echo e(translate('messages.title')); ?>

                                                            (<?php echo e(strtoupper($lang)); ?>)
                                                        </label>
                                                        <input type="text" name="title[]" id="<?php echo e($lang); ?>_title"
                                                            class="form-control" value="<?php echo e($translate[$lang]['title']??''); ?>"
                                                            placeholder="<?php echo e(translate('messages.new_banner')); ?>">
                                                    </div>
                                                    <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>

                                    </div>


                                    <div class="form-group mb-0" id="default">
                                        <label class="input-label"
                                            for="exampleFormControlInput1"><?php echo e(translate('messages.default_link')); ?>(<?php echo e(translate('messages.optional')); ?>)</label>
                                        <input type="url" name="default_link" class="form-control" value="<?php echo e($banner->default_link); ?>"
                                            placeholder="<?php echo e(translate('messages.default_link')); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="h-100 d-flex flex-column justify-content-between">
                                        <div class="form-group">
                                            <label
                                                class="fs-16 text-title font-semibold  mb-0"><?php echo e(translate('messages.Banner_Image')); ?></label>
                                            <p class="mb-20"><?php echo e(translate('JPG, JPEG, PNG Less Than 2MB')); ?> <span
                                                    class="font-weight-bold">(<?php echo e(translate('Ratio 3:1')); ?>)</span>
                                            </p>
                                            <div class="upload-file image-general">
                                                <a href="javascript:void(0);" class="remove-btn opacity-0 z-index-99">
                                                    <i class="tio-clear"></i>
                                                </a>
                                                <input type="file" name="image" class="upload-file__input single_file_input" value="<?php echo e($banner['image_full_url']); ?>" accept=".webp, .jpg, .jpeg, .png" title="" />
                                                <label class="upload-file-wrapper fullwidth">
                                                    <div class="upload-file-textbox text-center">
                                                        <img width="34" height="34" src="<?php echo e(asset('public/assets/admin/img/document-upload.svg')); ?>" alt="">
                                                        <h6 class="mt-2 font-semibold text-center">
                                                            <span><?php echo e(translate('Click to upload')); ?></span>
                                                            <br>
                                                            <?php echo e(translate('or drag and drop')); ?>

                                                        </h6>
                                                    </div>
                                                    <img class="upload-file-img d-none" loading="lazy" src="<?php echo e($banner['image_full_url']); ?>" alt="" data-banner-image="<?php echo e($banner['image_full_url']); ?>">
                                                </label>
                                            </div>

                                        </div>
                                        <div class="btn--container justify-content-end">
                                            <button type="reset" id="reset_btn"
                                                class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                                            <button type="submit"
                                                class="btn btn--primary"><?php echo e(translate('messages.submit')); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
<script src="<?php echo e(asset('Modules/Rental/public/assets/js/view-pages/provider/banner-edit.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/provider/banner/edit.blade.php ENDPATH**/ ?>