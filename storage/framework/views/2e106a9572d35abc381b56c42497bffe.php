<?php $__env->startSection('title',translate('messages.about_us')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/privacy-policy.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.about_us')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="<?php echo e(route('admin.business-settings.about-us')); ?>" method="post" id="about_us-form">

                    <?php echo csrf_field(); ?>

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
                    <div class="lang_form" id="default-form">
                        <div class="form-group">
                            <label for="about_title"><?php echo e(translate('messages.about_title')); ?>(<?php echo e(translate('messages.Default')); ?>)</label>
                            <input type="text" id="about_title" name="about_title[]" class="form-control"
                              value="<?php echo e($about_title?->getRawOriginal('value') ?? ''); ?>" >
                        </div>

                        <div class="form-group">
                            <label for="about_us"><?php echo e(translate('messages.about_us_description')); ?>(<?php echo e(translate('messages.Default')); ?>)</label>
                            <textarea id="about_us" class="ckeditor form-control" name="about_us[]"><?php echo $about_us?->getRawOriginal('value') ?? ''; ?></textarea>
                        </div>
                        <input type="hidden" name="lang[]" value="default">
                    </div>

                    <?php if($language): ?>
                        <?php $__empty_1 = true; $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                if($about_us?->translations){
                                    $translateDescription = [];
                                    foreach($about_us?->translations as $t)
                                    {
                                        if($t->locale == $lang && $t->key=="about_us"){
                                            $translateDescription[$lang]['about_us'] = $t->value;
                                        }
                                    }
                                }
                                if($about_title?->translations){
                                    $translate = [];
                                    foreach($about_title?->translations as $t)
                                    {
                                        if($t->locale == $lang && $t->key=="about_title"){
                                            $translate[$lang]['about_title'] = $t->value;
                                        }
                                    }
                                }

                                ?>

                            <div class="d-none lang_form" id="<?php echo e($lang); ?>-form">
                                <div class="form-group">
                                    <label for="about_title"><?php echo e(translate('messages.about_title')); ?>(<?php echo e($lang); ?>)</label>
                                    <input type="text" id="about_title" name="about_title[]" class="form-control"
                                    value="<?php echo e($translate[$lang]['about_title'] ?? null); ?>" >
                                </div>

                                <div class="form-group">
                                    <label for="about_us<?php echo e($lang); ?>"><?php echo e(translate('messages.about_us_description')); ?>(<?php echo e($lang); ?>)</label>
                                    <textarea id="about_us<?php echo e($lang); ?>" class="ckeditor form-control" name="about_us[]"><?php echo $translateDescription[$lang]['about_us'] ?? null; ?></textarea>
                                </div>
                                <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                            </div>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    <div class="btn--container justify-content-end">
                        <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.submit')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin/ckeditor/ckeditor.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/about-us.blade.php ENDPATH**/ ?>