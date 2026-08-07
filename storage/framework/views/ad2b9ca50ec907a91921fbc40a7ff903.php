<?php $__env->startSection('title',translate('messages.Update Flash Sale')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/edit.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.flash_sale_update')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="card">
            <div class="card-body">
                <form action="<?php echo e(route('admin.flash-sale.update',[$flash_sale['id']])); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <?php ($language=\App\Models\BusinessSetting::where('key','language')->first()); ?>
                                    <?php ($language = $language->value ?? null); ?>
                                    <?php ($defaultLang = str_replace('_', '-', app()->getLocale())); ?>
                                    <?php if($language): ?>
                                        <ul class="nav nav-tabs mb-4">
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
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="lang_form" id="default-form">
                                                    <div class="form-group">
                                                        <label class="input-label" for="default_title"><?php echo e(translate('messages.title')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                                        <input type="text" name="title[]" maxlength="100" id="default_title" class="form-control" placeholder="<?php echo e(translate('messages.updated_flash_sale')); ?>" value="<?php echo e($flash_sale?->getRawOriginal('title')); ?>">
                                                    </div>
                                                    <input type="hidden" name="lang[]" value="default">
                                                </div>
                                                <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        if(count($flash_sale['translations'])){
                                                            $translate = [];
                                                            foreach($flash_sale['translations'] as $t)
                                                            {
                                                                if($t->locale == $lang && $t->key=="title"){
                                                                    $translate[$lang]['title'] = $t->value;
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                    <div class="d-none lang_form" id="<?php echo e($lang); ?>-form">
                                                        <div class="form-group">
                                                            <label class="input-label" for="<?php echo e($lang); ?>_title"><?php echo e(translate('messages.title')); ?> (<?php echo e(strtoupper($lang)); ?>)</label>
                                                            <input type="text" name="title[]" maxlength="100" id="<?php echo e($lang); ?>_title" class="form-control" placeholder="<?php echo e(translate('messages.updated_flash_sale')); ?>" value="<?php echo e($translate[$lang]['title']??''); ?>">
                                                        </div>
                                                        <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="input-label"
                                                        for="default_title"><?php echo e(translate('messages.discount_Bearer')); ?>

                                                    </label>
                                                </div>
                                                <div class="row g-3 __bg-F8F9FC-card">
                                                    <div class="col-sm-6">
                                                        <label class="form-label"><?php echo e(translate('admin')); ?>(%)</label>
                                                    <input type="number" min=".01" step="0.001" max="100" name="admin_discount_percentage"
                                                            value="<?php echo e($flash_sale->admin_discount_percentage); ?>"
                                                            class="form-control" id="adminDiscount"
                                                            placeholder="<?php echo e(translate('Ex_:_50')); ?>" required>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="form-label"><?php echo e(translate('messages.store_owner')); ?>(%)</label>
                                                    <input type="number" min=".01" step="0.001" max="100" name="vendor_discount_percentage"
                                                            value="<?php echo e($flash_sale->vendor_discount_percentage); ?>"
                                                            class="form-control"  id="storeDiscount"
                                                            placeholder="<?php echo e(translate('Ex_:_50')); ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="input-label"
                                                        for="default_title"><?php echo e(translate('messages.validity')); ?>

                                                    </label>
                                                </div>
                                                <div class="row g-3 __bg-F8F9FC-card">
                                                    <div class="col-6">
                                                        <div>
                                                            <label class="input-label" for="title"><?php echo e(translate('messages.start_date')); ?></label>
                                                            <input type="datetime-local" id="from" class="form-control" required="" name="start_date" value="<?php echo e($flash_sale->start_date); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div>
                                                            <label class="input-label" for="title"><?php echo e(translate('messages.end_date')); ?></label>
                                                            <input type="datetime-local" id="to" class="form-control" required="" name="end_date" value="<?php echo e($flash_sale->end_date); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                    <div class="btn--container justify-content-end mt-5">
                        <button type="reset" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.update')); ?></button>
                    </div>
                </form>
            </div>
            <!-- End Table -->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/flash-sale-index.js"></script>
<script>
    "use strict";
        $(document).on('ready', function () {
            $('#from').attr('min',(new Date()).toISOString().split('T')[0]);
            $('#from').attr('max','<?php echo e($flash_sale->end_date); ?>');
            $('#to').attr('min','<?php echo e($flash_sale->start_date); ?>');
        });

</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/flash-sale/edit.blade.php ENDPATH**/ ?>