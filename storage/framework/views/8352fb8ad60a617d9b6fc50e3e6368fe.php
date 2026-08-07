<?php $__env->startSection('title',translate('Update Coupon')); ?>

<?php $__env->startSection('content'); ?>
    <?php ($store_data = \App\CentralLogics\Helpers::get_store_data()); ?>

    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-edit"></i> <?php echo e(translate('messages.coupon_update')); ?></h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="card">
            <div class="card-body">
                <form action="" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-12">
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
                                <div class="lang_form" id="default-form">
                                    <div class="form-group">
                                        <label class="input-label" for="default_title"><?php echo e(translate('messages.title')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                        <input type="text" name="title[]" id="default_title" class="form-control" placeholder="<?php echo e(translate('messages.new_coupon')); ?>" value="<?php echo e($coupon?->getRawOriginal('title')); ?>"  >
                                    </div>
                                    <input type="hidden" name="lang[]" value="default">
                                </div>
                                <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                        if(count($coupon['translations'])){
                                            $translate = [];
                                            foreach($coupon['translations'] as $t)
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
                                            <input type="text" name="title[]" id="<?php echo e($lang); ?>_title" class="form-control" placeholder="<?php echo e(translate('messages.new_coupon')); ?>" value="<?php echo e($translate[$lang]['title']??''); ?>"  >
                                        </div>
                                        <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div id="default-form">
                                    <div class="form-group">
                                        <label class="input-label" for="title"><?php echo e(translate('messages.title')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                        <input type="text" name="title[]" id="title" class="form-control" placeholder="<?php echo e(translate('messages.new_coupon')); ?>" value="<?php echo e($coupon['title']); ?>" maxlength="100" required>
                                    </div>
                                    <input type="hidden" name="lang[]" value="default">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="form-group">
                                <label class="input-label" for="coupon_type"><?php echo e(translate('messages.coupon_type')); ?></label>
                                <select id="coupon_type" name="coupon_type" class="form-control" >
                                    <?php if($store_data->sub_self_delivery == 1): ?>
                                        <option value="free_delivery" <?php echo e($coupon['coupon_type']=='free_delivery'?'selected':''); ?>><?php echo e(translate('messages.free_delivery')); ?></option>
                                    <?php endif; ?>
                                    <option value="default" <?php echo e($coupon['coupon_type']=='default'?'selected':''); ?>><?php echo e(translate('messages.default')); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-lg-3">
                            <div class="form-group">
                                <label class="input-label" for="coupon_code"><?php echo e(translate('messages.code')); ?></label>
                                <input id="coupon_code" type="text" name="code" class="form-control" value="<?php echo e($coupon['code']); ?>"
                                       placeholder="<?php echo e(\Illuminate\Support\Str::random(8)); ?>" required maxlength="100">
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="form-group">
                                <label class="input-label" for="coupon_limit"><?php echo e(translate('messages.limit_for_same_user')); ?></label>
                                <input type="number" name="limit" id="coupon_limit" value="<?php echo e($coupon['limit']); ?>" class="form-control" max="100"
                                       placeholder="<?php echo e(translate('messages.Ex :')); ?> 10">
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="form-group">
                                <label class="input-label" for="date_from"><?php echo e(translate('messages.start_date')); ?></label>
                                <input type="date" name="start_date" class="form-control" id="date_from" placeholder="<?php echo e(translate('messages.select_date')); ?>" value="<?php echo e(date('Y-m-d',strtotime($coupon['start_date']))); ?>">
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="form-group">
                                <label class="input-label" for="date_to"><?php echo e(translate('messages.expire_date')); ?></label>
                                <input type="date" name="expire_date" class="form-control" placeholder="<?php echo e(translate('messages.select_date')); ?>" id="date_to" value="<?php echo e(date('Y-m-d',strtotime($coupon['expire_date']))); ?>"
                                       data-hs-flatpickr-options='{
                                        "dateFormat": "Y-m-d"
                                    }'>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="form-group">
                                <label class="input-label" for="min_purchase"><?php echo e(translate('messages.min_trip_amount')); ?></label>
                                <input id="min_purchase" type="number" id="min_purchase" name="min_purchase" step="0.01" value="<?php echo e($coupon['min_purchase']); ?>"
                                       min="0" max="999999999999.99" class="form-control"
                                       placeholder="100">
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="form-group">
                                <label class="input-label" for="discount_type"><?php echo e(translate('messages.discount_type')); ?></label>
                                <select name="discount_type" id="discount_type" class="form-control" <?php echo e($coupon['coupon_type']=='free_delivery'?'disabled':''); ?>>
                                    <option value="amount" <?php echo e($coupon['discount_type']=='amount'?'selected':''); ?>>
                                        <?php echo e(translate('messages.amount').' ('.\App\CentralLogics\Helpers::currency_symbol().')'); ?>

                                    </option>
                                    <option value="percent" <?php echo e($coupon['discount_type']=='percent'?'selected':''); ?>>
                                        <?php echo e(translate('messages.percent').' (%)'); ?>

                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="form-group">
                                <label class="input-label" for="discount"><?php echo e(translate('messages.discount')); ?> </label>
                                <input type="number" id="discount" min="1" max="999999999999.99" step="0.01" value="<?php echo e($coupon['discount']); ?>"
                                       name="discount" class="form-control" placeholder="<?php echo e(translate('messages.Ex :')); ?> 100" required <?php echo e($coupon['coupon_type']=='free_delivery'?'readonly':''); ?>>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="form-group">
                                <label class="input-label" for="max_discount"><?php echo e(translate('messages.max_discount')); ?></label>
                                <input type="number" min="0" max="999999999999.99" step="0.01"
                                       value="<?php echo e($coupon['max_discount']); ?>" name="max_discount" id="max_discount" class="form-control" <?php echo e($coupon['coupon_type']=='free_delivery'?'readonly':''); ?>>
                            </div>
                        </div>
                    </div>
                    <div class="btn--container justify-content-end">
                        <button id="reset_btn" type="button" class="btn btn--reset location-reload" ><?php echo e(translate('messages.reset')); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.update')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <input type="hidden" id="coupon-expire-date" value="<?php echo e(date('Y-m-d', strtotime($coupon['expire_date']))); ?>">
    <input type="hidden" id="coupon-start-date" value="<?php echo e(date('Y-m-d', strtotime($coupon['start_date']))); ?>">
    <input type="hidden" id="min-purchase-toast" value="<?php echo e(translate('messages.Discount amount cannot be greater than minimum purchase amount')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin/js/view-pages/vendor-coupon.js')); ?>"></script>
    <script src="<?php echo e(asset('Modules/Rental/public/assets/js/view-pages/provider/coupon-edit.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/provider/coupon/edit.blade.php ENDPATH**/ ?>