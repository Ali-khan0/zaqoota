<?php $__env->startSection('title',$store->name."'s ".translate('messages.settings')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <!-- Custom styles for this page -->
    <link href="<?php echo e(asset('public/assets/admin/css/croppie.css')); ?>" rel="stylesheet">

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <?php echo $__env->make('rental::admin.provider.details.partials._header',['store'=>$store], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!-- Page Heading -->
    <div class="tab-content">
        <div class="tab-pane fade show active" id="vendor">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        <span class="card-header-icon">
                            <img class="w--22" src="<?php echo e(asset('public/assets/admin/img/store.png')); ?>" alt="">
                        </span>
                        <span class="p-md-1"> <?php echo e(translate('messages.provider_meta_data')); ?></span>
                    </h5>
                </div>
                <?php ($language=\App\Models\BusinessSetting::where('key','language')->first()); ?>
                <?php ($language = $language->value ?? null); ?>
                <?php ($defaultLang = 'en'); ?>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.store.update-meta-data',[$store['id']])); ?>" method="post"
                    enctype="multipart/form-data" class="col-12">
                    <?php echo csrf_field(); ?>
                        <div class="row g-2">
                            <div class="col-lg-6">
                                <div class="card shadow--card-2">
                                    <div class="card-body">
                                        <?php if($language): ?>
                                        <ul class="nav nav-tabs mb-4">
                                            <li class="nav-item">
                                                <a class="nav-link lang_link active"
                                                href="#"
                                                id="default-link"><?php echo e(translate('Default')); ?></a>
                                            </li>
                                            <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="nav-item">
                                                    <a class="nav-link lang_link"
                                                        href="#"
                                                        id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                        <?php endif; ?>
                                        <?php if($language): ?>
                                        <div class="lang_form"
                                        id="default-form">
                                            <div class="form-group">
                                                <label class="input-label"
                                                    for="default_title"><?php echo e(translate('messages.meta_title')); ?>

                                                    (<?php echo e(translate('messages.Default')); ?>)
                                                </label>
                                                <input type="text" name="meta_title[]" id="default_title"
                                                    class="form-control" placeholder="<?php echo e(translate('messages.meta_title')); ?>" value="<?php echo e($store->getRawOriginal('meta_title')); ?>"
                                                >
                                            </div>
                                            <input type="hidden" name="lang[]" value="default">
                                            <div class="form-group mb-0">
                                                <label class="input-label"
                                                    for="exampleFormControlInput1"><?php echo e(translate('messages.meta_description')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                                <textarea type="text" name="meta_description[]" placeholder="<?php echo e(translate('messages.meta_description')); ?>" class="form-control min-h-90px ckeditor"><?php echo e($store->getRawOriginal('meta_description')); ?></textarea>
                                            </div>
                                        </div>
                                            <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                if(count($store['translations'])){
                                                    $translate = [];
                                                    foreach($store['translations'] as $t)
                                                    {
                                                        if($t->locale == $lang && $t->key=="meta_title"){
                                                            $translate[$lang]['value'] = $t->value;
                                                        }
                                                        if($t->locale == $lang && $t->key=="meta_description"){
                                                            $translate[$lang]['value'] = $t->value;
                                                        }
                                                    }
                                                }
                                            ?>
                                                <div class="d-none lang_form"
                                                    id="<?php echo e($lang); ?>-form">
                                                    <div class="form-group">
                                                        <label class="input-label"
                                                            for="<?php echo e($lang); ?>_title"><?php echo e(translate('messages.meta_title')); ?>

                                                            (<?php echo e(strtoupper($lang)); ?>)
                                                        </label>
                                                        <input type="text" name="meta_title[]" id="<?php echo e($lang); ?>_title"
                                                            class="form-control" value="<?php echo e($translate[$lang]['meta_title']??''); ?>" placeholder="<?php echo e(translate('messages.meta_title')); ?>">
                                                    </div>
                                                    <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                                    <div class="form-group mb-0">
                                                        <label class="input-label"
                                                            for="exampleFormControlInput1"><?php echo e(translate('messages.meta_description')); ?> (<?php echo e(strtoupper($lang)); ?>)</label>
                                                        <textarea type="text" name="meta_description[]" placeholder="<?php echo e(translate('messages.meta_description')); ?>" class="form-control min-h-90px ckeditor"><?php echo e($translate[$lang]['meta_description']??''); ?></textarea>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <div id="default-form">
                                                <div class="form-group">
                                                    <label class="input-label"
                                                        for="exampleFormControlInput1"><?php echo e(translate('messages.meta_title')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                                    <input type="text" name="meta_title[]" class="form-control"
                                                        placeholder="<?php echo e(translate('messages.meta_title')); ?>" >
                                                </div>
                                                <input type="hidden" name="lang[]" value="default">
                                                <div class="form-group mb-0">
                                                    <label class="input-label"
                                                        for="exampleFormControlInput1"><?php echo e(translate('messages.meta_description')); ?>

                                                    </label>
                                                    <textarea type="text" name="meta_description[]" placeholder="<?php echo e(translate('messages.meta_description')); ?>" class="form-control min-h-90px ckeditor"></textarea>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card shadow--card-2">
                                    <div class="card-header">
                                        <h5 class="card-title">
                                            <span class="card-header-icon mr-1"><i class="tio-dashboard"></i></span>
                                            <span><?php echo e(translate('provider_meta_image')); ?></span>
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex flex-wrap flex-sm-nowrap __gap-12px">
                                            <label class="__custom-upload-img mr-lg-5">
                                                <div class="position-relative">
                                                <label class="form-label">
                                                    <?php echo e(translate('meta_image')); ?> <span class="text--primary">(<?php echo e(translate('1:1')); ?>)</span>
                                                </label>
                                                <div class="text-center">
                                                    <img class="img--110 min-height-170px min-width-170px onerror-image" id="viewer"
                                                        data-onerror-image="<?php echo e(asset('public/assets/admin/img/upload.png')); ?>"

                                                        src="<?php echo e($store->meta_image_full_url ??  asset('public/assets/admin/img/upload.png')); ?>"

                                                        alt="<?php echo e(translate('meta_image')); ?>" />
                                                </div>
                                                <input type="file" name="meta_image" id="customFileEg1" class="custom-file-input"
                                                    accept=".webp, .jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">

                                                    <?php if(isset($store->meta_image)): ?>
                                                    <span id="earning_delivery_img" class="remove_image_button mt-4 dynamic-checkbox"
                                                          data-id="earning_delivery_img"
                                                          data-type="status"
                                                          data-image-on='<?php echo e(asset('/public/assets/admin/img/modal')); ?>/mail-success.png'
                                                          data-image-off="<?php echo e(asset('/public/assets/admin/img/modal')); ?>/mail-warning.png"
                                                          data-title-on="<?php echo e(translate('Important!')); ?>"
                                                          data-title-off="<?php echo e(translate('Warning!')); ?>"
                                                          data-text-on="<p><?php echo e(translate('Are_you_sure_you_want_to_remove_this_image')); ?></p>"
                                                          data-text-off="<p><?php echo e(translate('Are_you_sure_you_want_to_remove_this_image.')); ?></p>"
                                                        > <i class="tio-clear"></i></span>
                                                    <?php endif; ?>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="justify-content-end btn--container">
                                    <button type="submit" class="btn btn--primary"><?php echo e(translate('save_changes')); ?></button>
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
<script src="<?php echo e(asset('Modules/Rental/public/assets/js/admin/view-pages/provider-meta-data.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/provider/details/meta-data.blade.php ENDPATH**/ ?>