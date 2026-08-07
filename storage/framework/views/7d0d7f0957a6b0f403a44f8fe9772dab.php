<?php $__env->startSection('title',translate('messages.add_on_activation')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">

    <!-- Add On Activation Process -->
    <div class="d-content-between flex-wrap mb-20">
        <h2 class="title-clr"><?php echo e(translate('messages.add_on_activation')); ?></h2>
        
     </div>
     <div class="d-flex flex-column gap-3">
         <div class="card view-details-container">
            <form action="<?php echo e(route('admin.business-settings.addon-activation.activation')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="addon_name" value="vendor_app">
                <input type="hidden" name="software_type" value="addon">
                <input type="hidden" name="software_id" value="MzY3NzIxNzM=">
                <input type="hidden" name="key" value="addon_activation_vendor_app">
                <div class="card-body p-20">
                    <div class="row align-items-center">
                        <div class="col-xxl-8 col-md-6 mb-md-0 mb-2">
                            <h4 class="black-color mb-1 d-block"><?php echo e(translate('messages.vendor_app')); ?></h4>
                            <p class="fz-12 text-c mb-1"><?php echo e(translate('With_this_app_your_vendor_will_mange_their_business_through_mobile_app')); ?></p>
                        </div>
                        <?php ($addon_activation_vendor_app = \App\Models\BusinessSetting::where('key', 'addon_activation_vendor_app')->first()); ?>
                        <?php ($addon_activation_vendor_app = $addon_activation_vendor_app?->value ? json_decode($addon_activation_vendor_app->value, true) : ['activation_status' => 0, 'username' => '', 'purchase_key' => '']); ?>
                        <div class="col-xxl-4 col-md-6">
                            <div class="d-flex flex-sm-nowrap flex-wrap justify-content-end justify-content-end align-items-center gap-sm-3 gap-2">
                                <div class="view-btn order-sm-0 order-3 fz--14px text-primary cursor-pointer text-decoration-underline font-semibold d-flex align-items-center gap-1">
                                    <?php echo e(translate('messages.view')); ?> 
                                    <i class="tio-arrow-downward"></i>
                                </div>
                                <div class="mb-0">
                                    <label class="toggle-switch toggle-switch-sm mb-0">
                                            <input type="checkbox"
                                                    data-id="addon_activation_vendor_app_status"
                                                    data-type="toggle"
                                                    data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/free-delivery-on.png')); ?>"
                                                    data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/free-delivery-off.png')); ?>"
                                                    data-title-on="<strong><?php echo e(translate('messages.want_to_Turn_ON_the_Deliveryman_App_addon?')); ?></strong>"
                                                    data-title-off="<strong><?php echo e(translate('messages.want_to_Turn_OFF_the_Deliveryman_App_addon?')); ?></strong>"

                                                    class="status toggle-switch-input dynamic-checkbox-toggle"

                                                name="status" id="addon_activation_vendor_app_status"
                                                value="1"
                                                <?php echo e(isset($addon_activation_vendor_app['activation_status']) && $addon_activation_vendor_app['activation_status'] == 1 ? 'checked' : ''); ?>>
                                            <span class="toggle-switch-label text mb-0">
                                                <span
                                                    class="toggle-switch-indicator">
                                                </span>
                                            </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="view-details">
                        <div class="bg--secondary rounded p-20 mb-20"> 
                            <div class="row g-3">
                                <div class="col-md-6 col-lg-6">
                                    <div class="">
                                        <label class="mb-2 d-flex align-items-center gap-1 fz--14px">
                                            <?php echo e(translate('messages.codcanyon_user_name')); ?> <span class="text-danger">*</span>
                                            <i class="tio-info fz--14px secondary-clr" data-toggle="tooltip" data-bs-placement="top" title="<?php echo e(translate('messages.codcanyon_user_name')); ?> ...."></i>
                                        </label>
                                        <input type="text" value="<?php echo e(showDemoModeInputValue(value: $addon_activation_vendor_app['username'])); ?>"
                                                        placeholder="<?php echo e(translate('ex')); ?>: <?php echo e('Miler'); ?>"
                                                        name="username" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="">
                                        <label class="mb-2 d-flex align-items-center gap-1 fz--14px">
                                            <?php echo e(translate('messages.codcanyon_purchase_code')); ?> <span class="text-danger">*</span>
                                            <i class="tio-info fz--14px secondary-clr" data-toggle="tooltip" data-bs-placement="top" title="<?php echo e(translate('messages.codcanyon_purchase_code')); ?> ...."></i>
                                        </label>
                                        <input type="text" value="<?php echo e(showDemoModeInputValue(value: $addon_activation_vendor_app['purchase_key'])); ?>"
                                                        placeholder="<?php echo e(translate('ex')); ?>: <?php echo e('CAWFRWRAAWRCAWRA'); ?>"
                                                        name="purchase_key" class="form-control" required>
                                    </div>
                                </div>
                            </div>                   
                        </div>
                        <div class="d-flex align-items-center justify-content-end gap-2">
                            <button type="button" class="btn bg--secondary h--42px title-clr px-4"><?php echo e(translate('messages.reset')); ?></button>
                            <button type="<?php echo e(getDemoModeFormButton(type: 'button')); ?>" class="btn btn--primary <?php echo e(getDemoModeFormButton(type: 'class')); ?>"><?php echo e(translate('messages.submit')); ?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
         <div class="card view-details-container">
            <form action="<?php echo e(route('admin.business-settings.addon-activation.activation')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="addon_name" value="deliveryman_app">
                <input type="hidden" name="software_type" value="addon">
                <input type="hidden" name="software_id" value="MzY3NzIxNDg=">
                <input type="hidden" name="key" value="addon_activation_delivery_man_app">
                <div class="card-body p-20">
                    <div class="row align-items-center">
                        <div class="col-xxl-8 col-md-6 mb-md-0 mb-2">
                            <h4 class="black-color mb-1 d-block"><?php echo e(translate('messages.deliveryman_app')); ?></h4>
                            <p class="fz-12 text-c mb-1"><?php echo e(translate('with_this_app_your_all_your_deliveryman_will_mange_their_orders_through_mobile_app')); ?></p>
                        </div>
                        <?php ($addon_activation_delivery_man_app = \App\Models\BusinessSetting::where('key', 'addon_activation_delivery_man_app')->first()); ?>
                        <?php ($addon_activation_delivery_man_app = $addon_activation_delivery_man_app?->value ? json_decode($addon_activation_delivery_man_app->value, true) : ['activation_status' => 0, 'username' => '', 'purchase_key' => '']); ?>
                        <div class="col-xxl-4 col-md-6">
                            <div class="d-flex flex-sm-nowrap flex-wrap justify-content-end justify-content-end align-items-center gap-sm-3 gap-2">
                                <div class="view-btn order-sm-0 order-3 fz--14px text-primary cursor-pointer text-decoration-underline font-semibold d-flex align-items-center gap-1">
                                    <?php echo e(translate('messages.view')); ?> 
                                    <i class="tio-arrow-downward"></i>
                                </div>
                                <div class="mb-0">
                                    <label class="toggle-switch toggle-switch-sm mb-0">
                                            <input type="checkbox"
                                                    data-id="addon_activation_delivery_man_app_status"
                                                    data-type="toggle"
                                                    data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/free-delivery-on.png')); ?>"
                                                    data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/free-delivery-off.png')); ?>"
                                                    data-title-on="<strong><?php echo e(translate('messages.want_to_Turn_ON_the_Deliveryman_App_addon?')); ?></strong>"
                                                    data-title-off="<strong><?php echo e(translate('messages.want_to_Turn_OFF_the_Deliveryman_App_addon?')); ?></strong>"

                                                    class="status toggle-switch-input dynamic-checkbox-toggle"

                                                name="status" id="addon_activation_delivery_man_app_status"
                                                value="1"
                                                <?php echo e(isset($addon_activation_delivery_man_app['activation_status']) && $addon_activation_delivery_man_app['activation_status'] == 1 ? 'checked' : ''); ?>>
                                            <span class="toggle-switch-label text mb-0">
                                                <span
                                                    class="toggle-switch-indicator">
                                                </span>
                                            </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="view-details">
                        <div class="bg--secondary rounded p-20 mb-20"> 
                            <div class="row g-3">
                                <div class="col-md-6 col-lg-6">
                                    <div class="">
                                        <label class="mb-2 d-flex align-items-center gap-1 fz--14px">
                                            <?php echo e(translate('messages.codcanyon_user_name')); ?> <span class="text-danger">*</span>
                                            <i class="tio-info fz--14px secondary-clr" data-toggle="tooltip" data-bs-placement="top" title="<?php echo e(translate('messages.codcanyon_user_name')); ?> ...."></i>
                                        </label>
                                        <input type="text" value="<?php echo e(showDemoModeInputValue(value: $addon_activation_delivery_man_app['username'])); ?>"
                                                        placeholder="<?php echo e(translate('ex')); ?>: <?php echo e('Miler'); ?>"
                                                        name="username" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="">
                                        <label class="mb-2 d-flex align-items-center gap-1 fz--14px">
                                            <?php echo e(translate('messages.codcanyon_purchase_code')); ?> <span class="text-danger">*</span>
                                            <i class="tio-info fz--14px secondary-clr" data-toggle="tooltip" data-bs-placement="top" title="<?php echo e(translate('messages.codcanyon_purchase_code')); ?> ...."></i>
                                        </label>
                                        <input type="text" value="<?php echo e(showDemoModeInputValue(value: $addon_activation_delivery_man_app['purchase_key'])); ?>"
                                                        placeholder="<?php echo e(translate('ex')); ?>: <?php echo e('CAWFRWRAAWRCAWRA'); ?>"
                                                        name="purchase_key" class="form-control" required>
                                    </div>
                                </div>
                            </div>                   
                        </div>
                        <div class="d-flex align-items-center justify-content-end gap-2">
                            <button type="button" class="btn bg--secondary h--42px title-clr px-4"><?php echo e(translate('messages.reset')); ?></button>
                            <button type="<?php echo e(getDemoModeFormButton(type: 'button')); ?>" class="btn btn--primary <?php echo e(getDemoModeFormButton(type: 'class')); ?>"><?php echo e(translate('messages.submit')); ?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
         <div class="card view-details-container">
            <form action="<?php echo e(route('admin.business-settings.addon-activation.activation')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="addon_name" value="react_web">
                <input type="hidden" name="software_type" value="addon">
                <input type="hidden" name="software_id" value="NDUzNzAzNTE=">
                <input type="hidden" name="key" value="addon_activation_react">
                <div class="card-body p-20">
                    <div class="row align-items-center">
                        <div class="col-xxl-8 col-md-6 mb-md-0 mb-2">
                            <h4 class="black-color mb-1 d-block"><?php echo e(translate('messages.react_user_website')); ?></h4>
                            <p class="fz-12 text-c mb-1"><?php echo e(translate('with_this_react_website_your_customers_will_experience_your_system_in_a_more_attractive_and_seamless_way')); ?></p>
                        </div>
                        <?php ($addon_activation_react = \App\Models\BusinessSetting::where('key', 'addon_activation_react')->first()); ?>
                        <?php ($addon_activation_react = $addon_activation_react?->value ? json_decode($addon_activation_react->value, true) : ['activation_status' => 0, 'username' => '', 'purchase_key' => '']); ?>
                        <div class="col-xxl-4 col-md-6">
                            <div class="d-flex flex-sm-nowrap flex-wrap justify-content-end justify-content-end align-items-center gap-sm-3 gap-2">
                                <div class="view-btn order-sm-0 order-3 fz--14px text-primary cursor-pointer text-decoration-underline font-semibold d-flex align-items-center gap-1">
                                    <?php echo e(translate('messages.view')); ?> 
                                    <i class="tio-arrow-downward"></i>
                                </div>
                                <div class="mb-0">
                                    <label class="toggle-switch toggle-switch-sm mb-0">
                                            <input type="checkbox"
                                                    data-id="addon_activation_react_status"
                                                    data-type="toggle"
                                                    data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/free-delivery-on.png')); ?>"
                                                    data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/free-delivery-off.png')); ?>"
                                                    data-title-on="<strong><?php echo e(translate('messages.want_to_Turn_ON_the_Deliveryman_App_addon?')); ?></strong>"
                                                    data-title-off="<strong><?php echo e(translate('messages.want_to_Turn_OFF_the_Deliveryman_App_addon?')); ?></strong>"

                                                    class="status toggle-switch-input dynamic-checkbox-toggle"

                                                name="status" id="addon_activation_react_status"
                                                value="1"
                                                <?php echo e(isset($addon_activation_react['activation_status']) && $addon_activation_react['activation_status'] == 1 ? 'checked' : ''); ?>>
                                            <span class="toggle-switch-label text mb-0">
                                                <span
                                                    class="toggle-switch-indicator">
                                                </span>
                                            </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="view-details">
                        <div class="bg--secondary rounded p-20 mb-20"> 
                            <div class="row g-3">
                                <div class="col-md-6 col-lg-6">
                                    <div class="">
                                        <label class="mb-2 d-flex align-items-center gap-1 fz--14px">
                                            <?php echo e(translate('messages.codcanyon_user_name')); ?> <span class="text-danger">*</span>
                                            <i class="tio-info fz--14px secondary-clr" data-toggle="tooltip" data-bs-placement="top" title="<?php echo e(translate('messages.codcanyon_user_name')); ?> ...."></i>
                                        </label>
                                        <input type="text" value="<?php echo e(showDemoModeInputValue(value: $addon_activation_react['username'])); ?>"
                                                        placeholder="<?php echo e(translate('ex')); ?>: <?php echo e('Miler'); ?>"
                                                        name="username" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="">
                                        <label class="mb-2 d-flex align-items-center gap-1 fz--14px">
                                            <?php echo e(translate('messages.codcanyon_purchase_code')); ?> <span class="text-danger">*</span>
                                            <i class="tio-info fz--14px secondary-clr" data-toggle="tooltip" data-bs-placement="top" title="<?php echo e(translate('messages.codcanyon_purchase_code')); ?> ...."></i>
                                        </label>
                                        <input type="text" value="<?php echo e(showDemoModeInputValue(value: $addon_activation_react['purchase_key'])); ?>"
                                                        placeholder="<?php echo e(translate('ex')); ?>: <?php echo e('CAWFRWRAAWRCAWRA'); ?>"
                                                        name="purchase_key" class="form-control" required>
                                    </div>
                                </div>
                            </div>                   
                        </div>
                        <div class="d-flex align-items-center justify-content-end gap-2">
                            <button type="button" class="btn bg--secondary h--42px title-clr px-4"><?php echo e(translate('messages.reset')); ?></button>
                            <button type="<?php echo e(getDemoModeFormButton(type: 'button')); ?>" class="btn btn--primary <?php echo e(getDemoModeFormButton(type: 'class')); ?>"><?php echo e(translate('messages.submit')); ?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
     </div>
</div>


<!--  Offcanvas -->


<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/addon-activation/index.blade.php ENDPATH**/ ?>