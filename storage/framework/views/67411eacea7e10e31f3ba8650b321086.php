<?php $__env->startSection('title',translate('messages.terms_and_condition')); ?>



<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/privacy-policy.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.terms_and_condition')); ?>

                </span>
            </h1>
        </div>

        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="<?php echo e(route('admin.business-settings.terms-and-conditions')); ?>" method="post" id="terms_and_conditions-form">
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

                    <div class="form-group lang_form" id="default-form">
                        <input type="hidden" name="lang[]" value="default">
                        <textarea class="ckeditor form-control" name="terms_and_conditions[]"><?php echo $terms_and_conditions?->getRawOriginal('value') ?? ''; ?></textarea>
                    </div>

                    <?php if($language): ?>
                        <?php $__empty_1 = true; $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                if($terms_and_conditions?->translations){
                                    $translate = [];
                                    foreach($terms_and_conditions?->translations as $t)
                                    {
                                        if($t->locale == $lang && $t->key=="terms_and_conditions"){
                                            $translate[$lang]['terms_and_conditions'] = $t->value;
                                        }
                                    }
                                }

                                ?>

                            <div class="form-group d-none lang_form" id="<?php echo e($lang); ?>-form">
                                <textarea class="ckeditor form-control" name="terms_and_conditions[]"><?php echo $translate[$lang]['terms_and_conditions'] ?? null; ?></textarea>
                            </div>
                            <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
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

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/terms-and-conditions.blade.php ENDPATH**/ ?>