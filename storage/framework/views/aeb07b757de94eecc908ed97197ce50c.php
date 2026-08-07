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
    <?php ($language=\App\Models\BusinessSetting::where('key','language')->first()); ?>
    <?php ($language = $language->value ?? null); ?>
    <?php ($defaultLang = str_replace('_', '-', app()->getLocale())); ?>
    <div class="tab-content">
        <div class="tab-pane fade show active">
            <div class="card mb-3">
                <div class="card-body">
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
                        <form action="<?php echo e(route('admin.promotional-banner.why-choose-update',[$banner['id']])); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row g-3">
                                <?php if($language): ?>
                                <div class="col-6">
                                    <div class="row lang_form default-form">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                                            <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                                        </span></label>
                                                <input type="text"  maxlength="80" name="title[]" value="<?php echo e($banner?->getRawOriginal('title')??''); ?>" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label"><?php echo e(translate('messages.Short_Description')); ?> (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_short_description_within_100_characters')); ?>">
                                                            <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                                        </span></label>
                                                <textarea type="text"  maxlength="100" name="short_description[]" class="form-control" rows="3" <?php echo e(translate('messages.short_description_here...')); ?>> <?php echo e($banner?->getRawOriginal('short_description')??''); ?></textarea>
                                            </div>
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
                                            if($t->locale == $lang && $t->key=="short_description"){
                                                $translate[$lang]['short_description'] = $t->value;
                                            }
                                        }
                                    }
                                    ?>
                                    <div class="row d-none lang_form" id="<?php echo e($lang); ?>-form1">

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                                    <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                                </span></label>
                                                <input type="text"  maxlength="80" name="title[]" value="<?php echo e($translate[$lang]['title']??''); ?>"class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label"><?php echo e(translate('messages.Short_Description')); ?> (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_short_description_within_100_characters')); ?>">
                                                    <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                                </span></label>
                                                <textarea type="text"  maxlength="100" name="short_description[]" class="form-control" rows="3" <?php echo e(translate('messages.short_description_here...')); ?>> <?php echo e($translate[$lang]['short_description']??''); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </div>

                                <?php else: ?>
                                <div class="col-sm-6">
                                    <label class="form-label"><?php echo e(translate('Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="80" name="title[]" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                </div>
                                    <input type="hidden" name="lang[]" value="default">
                                <?php endif; ?>
                                <div class="col-sm-6">
                                    <div class="ml-5">
                                        <div>

                                            <label class="form-label"><?php echo e(translate('image (1:1)')); ?></label>
                                        </div>
                                        <label class="upload-img-3 m-0">
                                            <div class="img">
                                                <img
                                                src="<?php echo e($banner['image_full_url'] ?? asset('/public/assets/admin/img/aspect-1.png')); ?>" data-onerror-image="<?php echo e(asset('/public/assets/admin/img/aspect-1.png')); ?>" alt="" class="img__aspect-1 min-w-187px max-w-187px onerror-image">
                                            </div>
                                              <input type="file"  name="image" hidden>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="btn--container justify-content-end mt-20">
                                <button type="submit" class="btn btn--primary mb-2"><?php echo e(translate('Update')); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/other-banners.js"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/other-banners/parcel-why-choose-edit.blade.php ENDPATH**/ ?>