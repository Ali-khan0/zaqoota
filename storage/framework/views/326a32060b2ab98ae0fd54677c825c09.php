<?php $__env->startSection('title',translate('edit_coupon')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/edit.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.coupon_update')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="card">
            <div class="card-body">
                <form action="<?php echo e(route('admin.coupon.update',[$coupon['id']])); ?>" method="post" class="custom-validation">
                    <?php echo csrf_field(); ?>
                    <div class="row g-3">
                        <div class="col-12">
                            <?php if($language): ?>
                                <ul class="nav nav-tabs mb-4">
                                    <li class="nav-item">
                                        <a class="nav-link lang_link active"
                                        href="#"
                                        id="default-link"><?php echo e(translate('messages.default')); ?></a>
                                    </li>
                                    <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="nav-item">
                                            <a class="nav-link lang_link"
                                                href="#"
                                                id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                                <div class="lang_form" id="default-form">
                                    <div class="form-group error-wrapper">
                                        <label class="input-label" for="default_title"><?php echo e(translate('messages.title')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                        <input type="text" name="title[]" id="default_title" class="form-control" placeholder="<?php echo e(translate('messages.new_coupon')); ?>" value="<?php echo e($coupon?->getRawOriginal('title')); ?>"  >
                                    </div>
                                    <input type="hidden" name="lang[]" value="default">
                                </div>
                                <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                        <div class="form-group error-wrapper">
                                            <label class="input-label" for="<?php echo e($lang); ?>_title"><?php echo e(translate('messages.title')); ?> (<?php echo e(strtoupper($lang)); ?>)</label>
                                            <input type="text" name="title[]" id="<?php echo e($lang); ?>_title" class="form-control" placeholder="<?php echo e(translate('messages.new_coupon')); ?>" value="<?php echo e($translate[$lang]['title']??''); ?>"  required>
                                        </div>
                                        <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                            <div id="default-form">
                                <div class="form-group error-wrapper">
                                    <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.title')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                    <input type="text" name="title[]" class="form-control" placeholder="<?php echo e(translate('messages.new_coupon')); ?>" value="<?php echo e($coupon['title']); ?>" maxlength="100">
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4 col-lg-3 col-sm-6">
                            <div class="form-group m-0 error-wrapper">
                                <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.coupon_type')); ?></label>
                                <select name="coupon_type" id="coupon_type" class="form-control" required>
                                    <option value="store_wise" <?php echo e($coupon['coupon_type']=='store_wise'?'selected':''); ?>><?php echo e(translate('messages.store_wise')); ?></option>
                                    <option value="zone_wise" <?php echo e($coupon['coupon_type']=='zone_wise'?'selected':''); ?>><?php echo e(translate('messages.zone_wise')); ?></option>
                                    <option value="free_delivery" <?php echo e($coupon['coupon_type']=='free_delivery'?'selected':''); ?>><?php echo e(translate('messages.free_delivery')); ?></option>
                                    <option value="first_order" <?php echo e($coupon['coupon_type']=='first_order'?'selected':''); ?>><?php echo e(translate('messages.first_order')); ?></option>
                                    <option value="default" <?php echo e($coupon['coupon_type']=='default'?'selected':''); ?>><?php echo e(translate('messages.default')); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3 col-sm-6" id="store_wise">
                            <div class="form-group m-0 error-wrapper">
                                    <label class="input-label" for="exampleFormControlSelect1"><?php echo e(translate('messages.store')); ?><span
                                            class="input-label-secondary"></span></label>
                                    <select name="store_ids[]" class="js-data-example-ajax form-control"  title="Select Restaurant">
                                    <?php if($coupon->coupon_type == 'store_wise'): ?>
                                    <?php ($store=\App\Models\Store::find(json_decode($coupon->data)[0])); ?>
                                        <?php if($store): ?>
                                        <option value="<?php echo e($store->id); ?>"><?php echo e($store->name); ?></option>
                                        <?php endif; ?>
                                    <?php else: ?>
                                    <option selected><?php echo e(translate('Select Store')); ?></option>
                                    <?php endif; ?>
                                    </select>
                                </div>
                        </div>
                        <div class="col-md-4 col-lg-3 col-sm-6"  id="zone_wise">
                            <div class="form-group m-0 error-wrapper">
                                <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.select_zone')); ?></label>
                                <select name="zone_ids[]" id="choice_zones"
                                    class="form-control multiple-select2"
                                    multiple="multiple" placeholder="<?php echo e(translate('messages.select_zone')); ?>">
                                <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($zone->id); ?>" <?php echo e(($coupon->coupon_type=='zone_wise'&&json_decode($coupon->data))?(in_array($zone->id, json_decode($coupon->data))?'selected':''):''); ?>><?php echo e($zone->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-lg-3 col-sm-6 error-wrapper" id="customer_wise" style="display: <?php echo e($coupon['coupon_type'] =='zone_wise' || $coupon['coupon_type'] =='first_order' ?'none':'block'); ?>">
                            <label class="input-label" for="select_customer"><?php echo e(translate('messages.select_customer')); ?></label>
                            <select name="customer_ids[]" id="select_customer"
                                class="form-control multiple-select2"
                                multiple="multiple" placeholder="<?php echo e(translate('messages.select_customer')); ?>">
                                <option value="all" <?php echo e(in_array('all', json_decode($coupon->customer_id))?'selected':''); ?>><?php echo e(translate('messages.all')); ?> </option>
                                <?php $__currentLoopData = \App\Models\User::get(['id','f_name','l_name']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($user->id); ?>" <?php echo e(in_array($user->id, json_decode($coupon->customer_id))?'selected':''); ?>><?php echo e($user->f_name.' '.$user->l_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-4 col-lg-3 col-sm-6">
                            <div class="form-group m-0 error-wrapper">
                                <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.code')); ?></label>
                                <input type="text" name="code" class="form-control" value="<?php echo e($coupon['code']); ?>"
                                       placeholder="<?php echo e(\Illuminate\Support\Str::random(8)); ?>" required maxlength="100">
                            </div>
                        </div>
                        <div id="limit_for_same_user" class="col-md-4 col-lg-3 col-sm-6">
                            <div class="form-group m-0 error-wrapper">
                                <label class="input-label" for="limit"><?php echo e(translate('messages.limit_for_same_user')); ?></label>
                                <input type="number" name="limit" id="coupon_limit" data-value="<?php echo e($coupon['limit']); ?>" value="<?php echo e($coupon['limit']); ?>" class="form-control" max="100"
                                       placeholder="<?php echo e(translate('EX: 10')); ?>">
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3 col-sm-6">
                            <div class="form-group m-0 error-wrapper">
                                <label class="input-label" for=""><?php echo e(translate('messages.start_date')); ?></label>
                                <input type="date" name="start_date" class="form-control" id="date_from" placeholder="<?php echo e(translate('messages.select_date')); ?>" value="<?php echo e(date('Y-m-d',strtotime($coupon['start_date']))); ?>">
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3 col-sm-6">
                            <div class="form-group m-0 error-wrapper">
                                <label class="input-label" for="date_to"><?php echo e(translate('messages.expire_date')); ?></label>
                                <input type="date" name="expire_date" class="form-control" placeholder="<?php echo e(translate('messages.select_date')); ?>" id="date_to" value="<?php echo e(date('Y-m-d',strtotime($coupon['expire_date']))); ?>"
                                       data-hs-flatpickr-options='{
                                     "dateFormat": "Y-m-d"
                                   }'>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3 col-sm-6">
                            <div class="form-group m-0 error-wrapper">
                                <label class="input-label" for="discount_type"><?php echo e(translate('messages.discount_type')); ?></label>
                                <select name="discount_type" id="discount_type" class="form-control">
                                    <option value="amount" <?php echo e($coupon['discount_type']=='amount'?'selected':''); ?>><?php echo e(translate('messages.amount')); ?> (<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)
                                    </option>
                                    <option value="percent" <?php echo e($coupon['discount_type']=='percent'?'selected':''); ?>>
                                        <?php echo e(translate('messages.percent')); ?> (%)
                                    </option>
                                </select>
                            </div>
                        </div>
                            <div class="col-md-4 col-lg-3 col-sm-6">
                            <div class="form-group m-0 error-wrapper">
                                <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.min_purchase')); ?> (<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)</label>
                                <input type="number" id="min_purchase" name="min_purchase" step="0.01" value="<?php echo e($coupon['min_purchase']); ?>"
                                       min="0" max="999999999999.99" class="form-control"
                                       placeholder="100">
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3 col-sm-6">
                            <div class="form-group m-0 error-wrapper">
                                <label class="input-label" for="discount"><?php echo e(translate('messages.discount')); ?>

                                    <span class="input-label-secondary text--title" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="<?php echo e(translate('Currently you need to manage discount with the Restaurant.')); ?>">
                                        <i class="tio-info-outined"></i>
                                    </span>
                                </label>
                                <input type="number" id="discount" min="1" max="999999999999.99" step="0.01" value="<?php echo e($coupon['discount']); ?>"
                                       name="discount" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3 col-sm-6">
                            <div class="form-group m-0 error-wrapper">
                                <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.max_discount')); ?> (<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)</label>
                                <input type="number" min="0" max="999999999999.99" step="0.01" value="<?php echo e($coupon['max_discount']); ?>" name="max_discount" id="max_discount" class="form-control" <?php echo e($coupon['discount_type']=='amount'?'readonly="readonly"':''); ?>>
                            </div>
                        </div>

                    </div>
                    <div class="btn--container justify-content-end mt-4">
                        <button type="reset" id="reset_btn" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.update')); ?></button>
                    </div>
                </form>
            </div>
            <!-- End Table -->
        </div>
    </div>
    <input type="hidden" id="min-purchase-toast" value="<?php echo e(translate('messages.Discount amount cannot be greater than minimum purchase amount')); ?>">

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/coupon-edit.js"></script>
    <script>
        "use strict";
        coupon_type_change('<?php echo e($coupon->coupon_type); ?>');

        $(document).on('ready', function () {
            let module_id = 0;
            $('#date_from').attr('max','<?php echo e(date("Y-m-d",strtotime($coupon["expire_date"]))); ?>');
            $('#date_to').attr('min','<?php echo e(date("Y-m-d",strtotime($coupon["start_date"]))); ?>');
            <?php if($coupon['discount_type']=='amount'): ?>
            $('#max_discount').attr("readonly","true");
            $('#max_discount').val(0);
            <?php endif; ?>


            $('.js-data-example-ajax').select2({
                ajax: {
                    url: '<?php echo e(url('/')); ?>/admin/store/get-stores',
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page,
                            module_id: module_id
                        };
                    },
                    processResults: function (data) {
                        return {
                        results: data
                        };
                    },
                    __port: function (params, success, failure) {
                        let $request = $.ajax(params);

                        $request.then(success);
                        $request.fail(failure);

                        return $request;
                    }
                }
            });
            // INITIALIZATION OF FLATPICKR
            // =======================================================
            $('.js-flatpickr').each(function () {
                $.HSCore.components.HSFlatpickr.init($(this));
            });
        });



    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/coupon/edit.blade.php ENDPATH**/ ?>