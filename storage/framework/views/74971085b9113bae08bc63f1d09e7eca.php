<?php $__env->startSection('title', translate('messages.banner')); ?>

<?php $__env->startPush('css_or_js'); ?>
<?php $__env->stopPush(); ?>

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
                        <form action="<?php echo e(route('admin.rental.banner.update', [$banner['id']])); ?>" method="post" enctype="multipart/form-data">
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

                                    <div class="form-group">
                                        <label class="input-label"
                                            for="exampleFormControlInput1"><?php echo e(translate('Banner_Type')); ?></label>
                                        <select name="banner_type" id="banner_type" class="custom-select js-select2-custom">
                                            <option  <?php echo e($banner->type == 'store_wise'? 'selected':''); ?>  value="store_wise"><?php echo e(translate('Provider_Wise')); ?></option>
                                            <option <?php echo e($banner->type == 'default'? 'selected':''); ?>   value="default"><?php echo e(translate('messages.default')); ?></option>
                                        </select>
                                    </div>


                                    <div class="form-group mb-0  <?php echo e($banner->type == 'store_wise'? '':'d-none'); ?>" id="store_wise">
                                        <label class="input-label"
                                            for="exampleFormControlSelect1"><?php echo e(translate('messages.provider')); ?></label>
                                        <select name="store_id" id="store_id" data-url="<?php echo e(route('admin.store.get-providers')); ?>" class="js-data-example-ajax form-control"
                                            title="<?php echo e(translate('messages.Select_Provider')); ?>">
                                            <?php if($banner->type=='store_wise'): ?>
                                        <?php ($store = \App\Models\Store::where('id', $banner->data)->first(['id','name'])); ?>
                                            <?php if($store): ?>
                                            <option value="<?php echo e($store->id); ?>" selected><?php echo e($store->name); ?></option>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        </select>
                                    </div>

                                    <div class="form-group mb-0 <?php echo e($banner->type !== 'store_wise'? '':'d-none'); ?>" id="default">
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
                                                    <img class="upload-file-img" loading="lazy"  src="<?php echo e($banner['image_full_url']); ?>" alt="">
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
    <input type="hidden" id="current_module_id" value="<?php echo e(Config::get('module.current_module_id')); ?>" >
    <input type="hidden" id="defaut_banner_type" value="<?php echo e($banner?->type); ?>" >
    <input type="hidden" id="defaut_image_url" value="<?php echo e($banner?->image_full_url); ?>" >
    <input type="hidden" id="default_store_id" value="<?php echo e($store?->id ?? null); ?>" >
    

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>

<script src="<?php echo e(asset('Modules/Rental/public/assets/js/admin/view-pages/banner-edit.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/banner/edit.blade.php ENDPATH**/ ?>