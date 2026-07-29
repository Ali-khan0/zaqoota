<?php $__env->startSection('title',translate('messages.admin_landing_page')); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <div class="page-header pb-0">
        <div class="d-flex flex-wrap justify-content-between">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/landing.png')); ?>" class="w--20" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.admin_landing_pages')); ?>

                </span>
            </h1>
            <div class="text--primary-2 py-1 d-flex flex-wrap align-items-center" type="button" data-toggle="modal" data-target="#how-it-works">
                <strong class="mr-2"><?php echo e(translate('See_how_it_works!')); ?></strong>
                <div>
                    <i class="tio-info-outined"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-20 mt-2">
        <div class="js-nav-scroller hs-nav-scroller-horizontal">
            <?php echo $__env->make('admin-views.business-settings.landing-page-settings.top-menu-links.admin-landing-page-links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>

    <?php ($language=\App\Models\BusinessSetting::where('key','language')->first()); ?>
    <?php ($language = $language->value ?? null); ?>
    <?php ($defaultLang = str_replace('_', '-', app()->getLocale())); ?>
    <?php if($language): ?>
        <ul class="nav nav-tabs mb-4 border-0">
            <li class="nav-item">
                <a class="nav-link lang_link active"
                href="#"
                id="default-link"><?php echo e(translate('messages.default')); ?></a>
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
    <div class="tab-content">
        <div class="tab-pane fade show active">
            <form action="<?php echo e(route('admin.business-settings.promotional-update',[$banner['id']])); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <?php if($language): ?>
                            <div class="row g-3 lang_form" id="default-form">
                                <div class="col-sm-6">
                                    <label for="text" class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span>
                                        <span class="form-label-secondary text-danger"
                                              data-toggle="tooltip" data-placement="right"
                                              data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                </span></label>
                                        <input id="text" required type="text"  maxlength="20" name="title[]" value="<?php echo e($banner?->getRawOriginal('title')); ?>" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                </div>
                                <div class="col-sm-6">
                                    <label for="sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?> (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span>
                                        <span class="form-label-secondary text-danger"
                                              data-toggle="tooltip" data-placement="right"
                                              data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                </span></label>
                                        <input required id="sub_title" type="text"  maxlength="80" name="sub_title[]" value="<?php echo e($banner?->getRawOriginal('sub_title')); ?>" class="form-control" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                </div>
                            </div>
                            <input type="hidden" name="lang[]" value="default">
                                <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                        if(count($banner['translations'])){
                                            $translate = [];
                                            foreach($banner['translations'] as $t)
                                            {
                                                if($t->locale == $lang && $t->key=="title"){
                                                    $translate[$lang]['title'] = $t->value;
                                                }
                                                if($t->locale == $lang && $t->key=="sub_title"){
                                                    $translate[$lang]['sub_title'] = $t->value;
                                                }
                                            }
                                        }
                                    ?>
                                    <div class="row g-3 d-none lang_form" id="<?php echo e($lang); ?>-form">
                                        <div class="col-sm-6">
                                            <label for="title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                        <input id="title<?php echo e($lang); ?>" type="text"  maxlength="20" name="title[]" value="<?php echo e($translate[$lang]['title']??''); ?>" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="sub_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Sub Title')); ?> (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                        <input id="sub_title<?php echo e($lang); ?>" type="text"  maxlength="80" name="sub_title[]" value="<?php echo e($translate[$lang]['sub_title']??''); ?>" class="form-control" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                        </div>
                                    </div>
                                    <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label for="title" class="form-label"><?php echo e(translate('Title')); ?></label>
                                        <input id="title" type="text" name="title[]" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?></label>
                                        <input  id="sub_title" type="text" name="sub_title[]" class="form-control" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                    </div>
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                            <?php endif; ?>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label d-block mb-3">
                                    <?php echo e(translate('Banner')); ?>  <span class="text--primary"><?php echo e(translate('(size: 3:1)')); ?></span>
                                    <span class="form-label-secondary text-danger"
                                          data-toggle="tooltip" data-placement="right"
                                          data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                </span>
                                    <div class="fs-12 opacity-70">
                                        <?php echo e(translate(IMAGE_FORMAT.' ' . 'Less Than 2MB')); ?>

                                    </div>
                                </label>
                                <div class="position-relative">
                                    <label class="upload-img-3 m-0 d-block">
                                        <div class="img">
                                            <img
                                            src="<?php echo e($banner['image_full_url'] ?? asset('/public/assets/admin/img/upload-4.png')); ?>"
                                            data-onerror-image="<?php echo e(asset('/public/assets/admin/img/upload-4.png')); ?>" class="vertical-img mw-100 vertical onerror-image" alt="">
                                        </div>
                                            <input accept="<?php echo e(IMAGE_EXTENSION); ?>" class="upload-file__input single_file_input" type="file" name="image"  hidden>
                                    </label>
                                    <?php if(isset($banner['image'] )): ?>
                                        <span id="banner_image" class="remove_image_button remove-image dynamic-checkbox"
                                              data-id="banner_image"
                                              data-image-off="<?php echo e(asset('/public/assets/admin/img/delete-confirmation.png')); ?>"
                                              data-title="<?php echo e(translate('Warning!')); ?>"
                                              data-text="<p><?php echo e(translate('Are_you_sure_you_want_to_remove_this_image_?')); ?></p>"
                                        > <i class="tio-clear"></i></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="btn--container justify-content-end mt-20">
                            <button type="reset" class="btn btn--reset mb-2"><?php echo e(translate('Reset')); ?></button>
                            <button type="submit" class="btn btn--primary mb-2"><?php echo e(translate('messages.Update')); ?></button>
                        </div>
                    </div>
                </div>
            </form>
            <form  id="banner_image_form" action="<?php echo e(route('admin.remove_image')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo e($banner?->id); ?>" >
                <input type="hidden" name="model_name" value="AdminPromotionalBanner" >
                <input type="hidden" name="image_path" value="promotional_banner" >
                <input type="hidden" name="field_name" value="image" >
            </form>
        </div>
    </div>
</div>
    <!-- How it Works -->
    <?php echo $__env->make('admin-views.business-settings.landing-page-settings.partial.how-it-work', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/business-settings/landing-page-settings/admin-promotional-section-edit.blade.php ENDPATH**/ ?>