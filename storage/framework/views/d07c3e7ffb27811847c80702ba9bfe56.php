<?php $__env->startSection('title', translate('business_setup')); ?>


<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title mr-3">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/business.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.business_settings')); ?>

                </span>
            </h1>
            <?php echo $__env->make('admin-views.business-settings.partials.nav-menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
        <!-- End Page Header -->
        <form action="<?php echo e(route('admin.business-settings.update-order')); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php ($name = \App\Models\BusinessSetting::where('key', 'business_name')->first()); ?>

            <div class="row g-3">
                <?php ($default_location = \App\Models\BusinessSetting::where('key', 'default_location')->first()); ?>
                <?php ($default_location = $default_location->value ? json_decode($default_location->value, true) : 0); ?>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="py-2">
                                <div class="row g-3 align-items-end">
                                    <div class="col-sm-6 col-lg-4">
                                        <?php ($odc = \App\Models\BusinessSetting::where('key', 'order_delivery_verification')->first()); ?>
                                        <?php ($odc = $odc ? $odc->value : 0); ?>
                                        <div class="form-group mb-0">

                                            <label
                                                class="toggle-switch h--45px toggle-switch-sm d-flex justify-content-between border rounded px-3 py-0 form-control">
                                                <span class="pr-1 d-flex align-items-center switch--label">
                                                    <span class="line--limit-1">
                                                        <?php echo e(translate('messages.order_delivery_verification')); ?>

                                                    </span>
                                                    <span class="form-label-secondary text-danger d-flex"
                                                        data-toggle="tooltip" data-placement="right"
                                                        data-original-title="<?php echo e(translate('messages.When_a_deliveryman_arrives_for_delivery,_Customers_will_get_a_4-digit_verification_code_on_the_order_details_section_in_the_Customer_App_and_needs_to_provide_the_code_to_the_delivery_man_to_verify_the_order.')); ?>"><img
                                                            src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>"
                                                            alt="<?php echo e(translate('messages.order_varification_toggle')); ?>">
                                                    </span>
                                                </span>
                                                <input type="checkbox"
                                                       data-id="odc1"
                                                       data-type="toggle"
                                                       data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/order-delivery-verification-on.png')); ?>"
                                                       data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/order-delivery-verification-off.png')); ?>"
                                                       data-title-on="<?php echo e(translate('messages.Want_to_enable')); ?> <strong><?php echo e(translate('messages.Delivery_Verification?')); ?></strong>"
                                                       data-title-off="<?php echo e(translate('messages.Want_to_disable')); ?> <strong><?php echo e(translate('messages.Delivery_Verification?')); ?></strong>"
                                                       data-text-on="<p><?php echo e(translate('messages.If you enable this, the Deliveryman has to verify the order during delivery through a 4-digit verification code.')); ?></p>"
                                                       data-text-off="<p><?php echo e(translate('messages.If you disable this, the Deliveryman will deliver the order and update the status. He doesn’t need to verify the order with any code.')); ?></p>"
                                                       class="status toggle-switch-input dynamic-checkbox-toggle"

                                                       value="1"
                                                    name="odc" id="odc1" <?php echo e($odc == 1 ? 'checked' : ''); ?>>
                                                <span class="toggle-switch-label text">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <?php ($prescription_order_status = \App\Models\BusinessSetting::where('key', 'prescription_order_status')->first()); ?>

                                        <?php ($prescription_order_status = $prescription_order_status ? $prescription_order_status->value : 0); ?>
                                        <div class="form-group mb-0">

                                            <label
                                                class="toggle-switch h--45px toggle-switch-sm d-flex justify-content-between border rounded px-3 py-0 form-control">
                                                <span class="pr-1 d-flex align-items-center switch--label">
                                                    <span class="line--limit-1">
                                                        <?php echo e(translate('messages.Place_Order_by_Prescription')); ?>

                                                    </span>
                                                    <span class="form-label-secondary text-danger d-flex"
                                                        data-toggle="tooltip" data-placement="right"
                                                        data-original-title="<?php echo e(translate('messages.With_this_feature,_customers_can_place_an_order_by_uploading_prescription._Stores_can_enable/disable_this_feature_from_the_store_settings_if_needed.')); ?>"><img
                                                            src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>"
                                                            alt="<?php echo e(translate('messages.prescription_order_status')); ?>"> </span>
                                                </span>
                                                <input type="checkbox"
                                                       data-id="prescription_order_status"
                                                       data-type="toggle"
                                                       data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/prescription-on.png')); ?>"
                                                       data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/prescription-off.png')); ?>"
                                                       data-title-on="<?php echo e(translate('messages.Want_to_enable')); ?> <strong><?php echo e(translate('messages.Place_Order_by_Prescription?')); ?></strong>"
                                                       data-title-off="<?php echo e(translate('messages.Want_to_disable')); ?> <strong><?php echo e(translate('messages.Place_Order_by_Prescription?')); ?></strong>"
                                                       data-text-on="<p><?php echo e(translate('messages.If you enable this, customers can place an order by simply uploading their prescriptions in the Pharmacy module from the Customer App or Website. Stores can enable/disable this feature from store settings if needed.')); ?></p>"
                                                       data-text-off="<p><?php echo e(translate('messages.If disabled, this feature will be hidden from the Customer App, Website, and Store App & Panel.')); ?></p>"
                                                       class="status toggle-switch-input dynamic-checkbox-toggle"
                                                       value="1"
                                                    name="prescription_order_status" id="prescription_order_status"
                                                    <?php echo e($prescription_order_status == 1 ? 'checked' : ''); ?>>
                                                <span class="toggle-switch-label text">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <?php ($home_delivery_status = \App\Models\BusinessSetting::where('key', 'home_delivery_status')->first()); ?>

                                        <?php ($home_delivery_status = $home_delivery_status ? $home_delivery_status->value : 0); ?>
                                        <div class="form-group mb-0">
                                            <label
                                                class="toggle-switch h--45px toggle-switch-sm d-flex justify-content-between border rounded px-3 py-0 form-control">
                                                <span class="pr-1 d-flex align-items-center switch--label">
                                                    <span class="line--limit-1">
                                                        <?php echo e(translate('Home Delivery')); ?>

                                                    </span>
                                                    <span class="form-label-secondary text-danger d-flex"
                                                        data-toggle="tooltip" data-placement="right"
                                                        data-original-title="<?php echo e(translate('messages.If_you_enable_this_feature,_customers_can_choose_‘Home_Delivery’_and_get_the_product_delivered_to_their_preferred_location.')); ?>"><img
                                                            src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>"
                                                            alt="<?php echo e(translate('Home Delivery')); ?>"></span>
                                                </span>
                                                <input type="checkbox"
                                                       data-id="home_delivery"
                                                       data-type="toggle"
                                                       data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/home-delivery-on.png')); ?>"
                                                       data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/home-delivery-off.png')); ?>"
                                                       data-title-on="<?php echo e(translate('messages.Want_to_enable')); ?> <strong><?php echo e(translate('messages.Home_Delivery?')); ?></strong>"
                                                       data-title-off="<?php echo e(translate('messages.Want_to_disable')); ?> <strong><?php echo e(translate('messages.Home_Delivery?')); ?></strong>"
                                                       data-text-on="<p><?php echo e(translate('messages.If you enable this, customers can use the Home Delivery Option during checkout from the Customer App or Website.')); ?></p>"
                                                       data-text-off="<p><?php echo e(translate('messages.If you disable this, the Home Delivery feature will be hidden from the customer app and website.')); ?></p>"
                                                       class="status toggle-switch-input dynamic-checkbox-toggle"
                                                       name ="home_delivery_status" id="home_delivery" value="1"
                                               <?php echo e($home_delivery_status == 1 ? 'checked' : ''); ?>>
                                                <span class="toggle-switch-label text">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <?php ($takeaway_status = \App\Models\BusinessSetting::where('key', 'takeaway_status')->first()); ?>

                                        <?php ($takeaway_status = $takeaway_status ? $takeaway_status->value : 0); ?>
                                        <div class="form-group mb-0">
                                            <label
                                                class="toggle-switch h--45px toggle-switch-sm d-flex justify-content-between border rounded px-3 py-0 form-control">
                                                <span class="pr-1 d-flex align-items-center switch--label">
                                                    <span class="line--limit-1">
                                                        <?php echo e(translate('Takeaway')); ?>

                                                    </span>
                                                    <span class="form-label-secondary text-danger d-flex"
                                                        data-toggle="tooltip" data-placement="right"
                                                        data-original-title="<?php echo e(translate('messages.If_you_enable_this_feature,_customers_can_place_an_order_and_request_‘Takeaways’_or_‘self-pick-up’_from_stores.')); ?>"><img
                                                            src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>"
                                                            alt="<?php echo e(translate('Home Delivery')); ?>"></span>
                                                </span>
                                                <input type="checkbox"
                                                       data-id="take_away"
                                                       data-type="toggle"
                                                       data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/takeaway-on.png')); ?>"
                                                       data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/takeaway-off.png')); ?>"
                                                       data-title-on="<?php echo e(translate('messages.Want_to_enable')); ?> <strong><?php echo e(translate('messages.the_Takeaway_feature?')); ?></strong>"
                                                       data-title-off="<?php echo e(translate('messages.Want_to_disable')); ?> <strong><?php echo e(translate('messages.the_Takeaway_feature?')); ?></strong>"
                                                       data-text-on="<p><?php echo e(translate('messages.If you enable this, customers can use the Takeaway feature during checkout from the Customer App or Website.')); ?></p>"
                                                       data-text-off="<p><?php echo e(translate('messages.If you disable this, the Takeaway feature will be hidden from the Customer App or Website.')); ?></p>"
                                                       class="status toggle-switch-input dynamic-checkbox-toggle"
                                                       name="takeaway_status" value="1" id="take_away" <?php echo e($takeaway_status == 1 ? 'checked' : ''); ?>>
                                                <span class="toggle-switch-label text">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-4">
                                        <?php ($schedule_order = \App\Models\BusinessSetting::where('key', 'schedule_order')->first()); ?>
                                        <?php ($schedule_order = $schedule_order ? $schedule_order->value : 0); ?>
                                        <div class="form-group mb-0">
                                            <label
                                                class="toggle-switch h--45px toggle-switch-sm d-flex justify-content-between border rounded px-3 py-0 form-control">
                                                <span class="pr-1 d-flex align-items-center switch--label">
                                                    <span class="line--limit-1">
                                                        <?php echo e(translate('messages.Schedule_Order')); ?>

                                                    </span>
                                                    <span class="form-label-secondary text-danger d-flex"
                                                        data-toggle="tooltip" data-placement="right"
                                                        data-original-title="<?php echo e(translate('messages.With_this_feature,_customers_can_choose_their_preferred_delivery_slot._Customers_can_select_a_delivery_slot_for_ASAP_or_a_specific_date_(within_2_days_from_the_order).')); ?>"><img
                                                            src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>"
                                                            alt="<?php echo e(translate('messages.customer_varification_toggle')); ?>">
                                                    </span>
                                                </span>
                                                <input type="checkbox"
                                                       data-id="schedule_order"
                                                       data-type="toggle"
                                                       data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/schedule-on.png')); ?>"
                                                       data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/schedule-off.png')); ?>"
                                                       data-title-on="<?php echo e(translate('messages.Want_to_enable')); ?> <strong><?php echo e(translate('messages.Scheduled Order?')); ?></strong>"
                                                       data-title-off="<?php echo e(translate('messages.Want_to_disable')); ?> <strong><?php echo e(translate('messages.Scheduled Order?')); ?></strong>"
                                                       data-text-on="<p><?php echo e(translate('messages.If you enable this, customers can choose a suitable delivery schedule during checkout.')); ?></p>"
                                                       data-text-off="<p><?php echo e(translate('messages.If you disable this, the Scheduled Order feature will be hidden.')); ?></p>"
                                                       class="status toggle-switch-input dynamic-checkbox-toggle"
                                                       value="1"
                                                    name="schedule_order" id="schedule_order"
                                                    <?php echo e($schedule_order == 1 ? 'checked' : ''); ?>>
                                                <span class="toggle-switch-label text">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-4">
                                        <?php ($schedule_order_slot_duration = \App\Models\BusinessSetting::where('key', 'schedule_order_slot_duration')->first()); ?>
                                        <?php ($schedule_order_slot_duration_time_format = \App\Models\BusinessSetting::where('key', 'schedule_order_slot_duration_time_format')->first()); ?>
                                        <div class="form-group mb-0">
                                            <label class="input-label text-capitalize d-flex alig-items-center"
                                                for="schedule_order_slot_duration">


                                                <span class="pr-1 d-flex align-items-center switch--label">
                                                    <span class="line--limit-1">
                                                        <?php echo e(translate('messages.Time_Interval_for_Scheduled_Delivery')); ?>

                                                    </span>
                                                    <span class="form-label-secondary text-danger"
                                                    data-toggle="tooltip" data-placement="right"
                                                    data-original-title="<?php echo e(translate('messages.By_activating_this_feature,_customers_can_choose_their_suitable_delivery_slot_according_to_a_30-minute_or_1-hour_interval_set_by_the_Admin.')); ?>"><img
                                                        src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>"
                                                        alt="<?php echo e(translate('Home Delivery')); ?>"></span>
                                                </span>
                                            </label>
                                            <div class="d-flex">
                                                <input type="number" name="schedule_order_slot_duration" class="form-control mr-3"
                                                id="schedule_order_slot_duration"
                                                value="<?php echo e($schedule_order_slot_duration?->value ? $schedule_order_slot_duration_time_format?->value == 'hour' ? $schedule_order_slot_duration?->value /60 : $schedule_order_slot_duration?->value: 0); ?>"
                                                min="0" required>
                                                <select   name="schedule_order_slot_duration_time_format" class="custom-select form-control w-90px">
                                                    <option  value="min" <?php echo e($schedule_order_slot_duration_time_format?->value == 'min'? 'selected' : ''); ?>><?php echo e(translate('Min')); ?></option>
                                                    <option  value="hour" <?php echo e($schedule_order_slot_duration_time_format?->value == 'hour'? 'selected' : ''); ?>><?php echo e(translate('Hour')); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <?php ($extra_packaging_data = \App\Models\BusinessSetting::where('key', 'extra_packaging_data')->first()?->value ?? ''); ?>
                                    <?php ($extra_packaging_data =json_decode($extra_packaging_data , true)); ?>
                                    <div class="mt-4  mb-4 access_product_approval">

                                        <label class="mb-2 input-label text-capitalize d-flex alig-items-center" for=""> <img src="<?php echo e(asset('/public/assets/admin/img/icon-park_ad-product.png')); ?>" alt=""
                                            class="card-header-icon align-self-center mr-1"><?php echo e(translate('Enable Extra Packaging Charge')); ?>


                                            <span class="form-label-secondary text-danger"
                                            data-toggle="tooltip" data-placement="right"
                                            data-original-title="<?php echo e(translate('messages.After_saving_information,_sellers_will_get_the_option_to_offer_extra_packaging_charge_to_the_customer')); ?>"><img
                                                src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>"
                                                alt="<?php echo e(translate('Extra_Packaging_Charge')); ?>"></span>

                                        </label>
                                        <div class="justify-content-between border form-control">
                                            <?php $__currentLoopData = config('module.module_type'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($value != 'parcel' && $value != 'rental'): ?>
                                            <div class="form-check form-check-inline mx-4  ">
                                                <input class="mx-2 form-check-input" type="checkbox" <?php echo e(data_get($extra_packaging_data,$value,null) == 1 ? 'checked' :''); ?> id="inlineCheckbox<?php echo e($key); ?>" value="1" name="<?php echo e($value); ?>">
                                                <label class=" form-check-label" for="inlineCheckbox<?php echo e($key); ?>"><?php echo e(translate($value)); ?></label>
                                            </div>
                                            <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </div>
                                    </div>
                                </div>

                                    



                                <div class="btn--container justify-content-end mt-20">
                                    <button type="reset" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                                    <button type="<?php echo e(env('APP_MODE') != 'demo' ? 'submit' : 'button'); ?>"
                                        class="btn btn--primary call-demo"><?php echo e(translate('save_information')); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

            <div class="mt-4">
                <h4 class="card-title mb-3">
                    <i class="tio-document-text-outlined mr-1"></i>
                    <?php echo e(translate('Order Cancellation Messages')); ?>

                </h4>
                <div class="card">
                    <div class="card-body">
                <form action="<?php echo e(route('admin.business-settings.order-cancel-reasons.store')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                        <?php ($language = \App\Models\BusinessSetting::where('key', 'language')->first()); ?>
                        <?php ($language = $language->value ?? null); ?>
                        <?php ($defaultLang = str_replace('_', '-', app()->getLocale())); ?>
                        <?php if($language): ?>
                            <ul class="nav nav-tabs nav--tabs mb-3 border-0">
                                <li class="nav-item">
                                    <a class="nav-link lang_link1 active" href="#"
                                        id="default-link1"><?php echo e(translate('Default')); ?></a>
                                </li>
                                <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="nav-item">
                                        <a class="nav-link lang_link1" href="#"
                                            id="<?php echo e($lang); ?>-link1"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php endif; ?>
                        <div class="row g-3">
                            <div class="col-sm-6 lang_form1 default-form1">
                                <label for="order_cancellation" class="form-label"><?php echo e(translate('Order Cancellation Reason')); ?>

                                    (<?php echo e(translate('messages.default')); ?>)</label>
                                <input type="text" class="form-control h--45px" name="reason[]"
                                    id="order_cancellation" placeholder="<?php echo e(translate('Ex:_Item_is_Broken')); ?>">
                                <input type="hidden" name="lang[]" value="default">
                            </div>
                            <?php if($language): ?>
                                <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-sm-6 d-none lang_form1" id="<?php echo e($lang); ?>-form1">
                                        <label for="order_cancellation<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Order Cancellation Reason')); ?>

                                            (<?php echo e(strtoupper($lang)); ?>)</label>
                                        <input type="text" class="form-control h--45px" name="reason[]"
                                            id="order_cancellation<?php echo e($lang); ?>" placeholder="<?php echo e(translate('Ex:_Item_is_Broken')); ?>">
                                        <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            <div class="col-sm-6">
                                <label for="user_type" class="form-label d-flex">
                                    <span class="line--limit-1"><?php echo e(translate('User Type')); ?> </span>
                                    <span class="form-label-secondary text-danger d-flex" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="<?php echo e(translate('When this field is active, user can cancel an order with proper reason.')); ?>"><img
                                            src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>"
                                            alt="<?php echo e(translate('messages.prescription_order_status')); ?>"></span>
                                </label>
                                <select id="user_type" name="user_type" class="form-control h--45px" required>
                                    <option value=""><?php echo e(translate('messages.select_user_type')); ?></option>
                                    <option value="admin"><?php echo e(translate('messages.admin')); ?></option>
                                    <option value="store"><?php echo e(translate('messages.store')); ?></option>
                                    <option value="customer"><?php echo e(translate('messages.customer')); ?></option>
                                    <option value="deliveryman"><?php echo e(translate('messages.deliveryman')); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-2">
                            <?php echo e(translate('messages.*Users_cannot_cancel_an_order_if_the_Admin_does_not_specify_a_cause_for_cancellation,_even_though_they_see_the_‘Cancel_Order‘_option._So_Admin_MUST_provide_a_proper_Order_Cancellation_Reason_and_select_the_related_user.')); ?>

                       </div>
                        <div class="btn--container justify-content-end mt-3 mb-4">
                            <button type="reset" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                            <button type="<?php echo e(env('APP_MODE') != 'demo' ? 'submit' : 'button'); ?>"
                                class="btn btn--primary call-demo"><?php echo e(translate('Submit')); ?></button>
                        </div>
                    </form>
                        <div class="card">
                            <div class="card-body mb-3">
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-md-0 mb-3">
                                    <div class="mx-1">
                                        <h5 class="form-label mb-4">
                                            <?php echo e(translate('messages.order_cancellation_reason_list')); ?>

                                        </h5>
                                    </div>
                                    <div class="my-2">
                                        <select id="type" name="type" class="form-control h--45px set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="type">
                                            <option value="all" <?php echo e(request('type') == 'all' ? 'selected' : ''); ?>><?php echo e(translate('messages.all_user')); ?></option>
                                            <option value="admin" <?php echo e(request('type') == 'admin' ? 'selected' : ''); ?>><?php echo e(translate('messages.admin')); ?></option>
                                            <option value="store" <?php echo e(request('type') == 'store' ? 'selected' : ''); ?>><?php echo e(translate('messages.store')); ?></option>
                                            <option value="customer" <?php echo e(request('type') == 'customer' ? 'selected' : ''); ?>><?php echo e(translate('messages.customer')); ?></option>
                                            <option value="deliveryman" <?php echo e(request('type') == 'deliveryman' ? 'selected' : ''); ?>><?php echo e(translate('messages.deliveryman')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Table -->
                                <div class="card-body p-0">
                                    <div class="table-responsive datatable-custom">
                                        <table id="columnSearchDatatable"
                                            class="table table-borderless table-thead-bordered table-align-middle"
                                            data-hs-datatables-options='{
                                        "isResponsive": false,
                                        "isShowPaging": false,
                                        "paging":false,
                                    }'>
                                            <thead class="thead-light">
                                                <tr>
                                                    <th class="border-0"><?php echo e(translate('messages.SL')); ?></th>
                                                    <th class="border-0"><?php echo e(translate('messages.Reason')); ?></th>
                                                    <th class="border-0"><?php echo e(translate('messages.type')); ?></th>
                                                    <th class="border-0"><?php echo e(translate('messages.status')); ?></th>
                                                    <th class="border-0 text-center"><?php echo e(translate('messages.action')); ?></th>
                                                </tr>
                                            </thead>

                                            <tbody id="table-div">
                                                <?php $__currentLoopData = $reasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $reason): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($key + $reasons->firstItem()); ?></td>

                                                        <td>
                                                            <span class="d-block font-size-sm text-body" title="<?php echo e($reason->reason); ?>">
                                                                <?php echo e(Str::limit($reason->reason, 25, '...')); ?>

                                                            </span>
                                                        </td>
                                                        <td><?php echo e(Str::title($reason->user_type)); ?></td>
                                                        <td>
                                                            <label class="toggle-switch toggle-switch-sm"
                                                                for="stocksCheckbox<?php echo e($reason->id); ?>">
                                                                <input type="checkbox"
                                                                       data-url="<?php echo e(route('admin.business-settings.order-cancel-reasons.status', [$reason['id'], $reason->status ? 0 : 1])); ?>"
                                                                    class="toggle-switch-input redirect-url"
                                                                    id="stocksCheckbox<?php echo e($reason->id); ?>"
                                                                    <?php echo e($reason->status ? 'checked' : ''); ?>>
                                                                <span class="toggle-switch-label">
                                                                    <span class="toggle-switch-indicator"></span>
                                                                </span>
                                                            </label>
                                                        </td>

                                                        <td>
                                                            <div class="btn--container justify-content-center">

                                                                <a class="btn btn-sm btn--primary btn-outline-primary action-btn edit-reason"
                                                    title="<?php echo e(translate('messages.edit')); ?>"
                                                    data-toggle="modal"
                                                    data-target="#add_update_reason_<?php echo e($reason->id); ?>"><i
                                                        class="tio-edit"></i>
                                                </a>


                                                                <a class="btn btn-sm btn--danger btn-outline-danger action-btn form-alert"
                                                                    href="javascript:"
                                                                   data-id="order-cancellation-reason-<?php echo e($reason['id']); ?>"
                                                                   data-message="<?php echo e(translate('messages.If_you_want_to_delete_this_reason,_please_confirm_your_decision.')); ?>"
                                                                    title="<?php echo e(translate('messages.delete')); ?>">
                                                                    <i class="tio-delete-outlined"></i>
                                                                </a>
                                                                <form
                                                                    action="<?php echo e(route('admin.business-settings.order-cancel-reasons.destroy', $reason['id'])); ?>"
                                                                    method="post" id="order-cancellation-reason-<?php echo e($reason['id']); ?>">
                                                                    <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="add_update_reason_<?php echo e($reason->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel"><?php echo e(translate('messages.order_cancellation_reason')); ?>

                                                                        <?php echo e(translate('messages.Update')); ?></label></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                    <form action="<?php echo e(route('admin.business-settings.order-cancel-reasons.update')); ?>" method="post">
                                                                <div class="modal-body">
                                                                        <?php echo csrf_field(); ?>
                                                                        <?php echo method_field('put'); ?>

                                                                        <?php ($reason=  \App\Models\OrderCancelReason::withoutGlobalScope('translate')->with('translations')->find($reason->id)); ?>
                                                                        <?php ($language=\App\Models\BusinessSetting::where('key','language')->first()); ?>
                                                                    <?php ($language = $language->value ?? null); ?>
                                                                    <?php ($defaultLang = str_replace('_', '-', app()->getLocale())); ?>
                                                                    <ul class="nav nav-tabs nav--tabs mb-3 border-0">
                                                                        <li class="nav-item">
                                                                            <a class="nav-link update-lang_link add_active active"
                                                                            href="#"
                                                                            id="default-link"><?php echo e(translate('Default')); ?></a>
                                                                        </li>
                                                                        <?php if($language): ?>
                                                                        <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <li class="nav-item">
                                                                                <a class="nav-link update-lang_link"
                                                                                    href="#"
                                                                                   data-reason-id="<?php echo e($reason->id); ?>"
                                                                                    id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                                                            </li>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php endif; ?>
                                                                    </ul>
                                                                        <input type="hidden" name="reason_id"  value="<?php echo e($reason->id); ?>" />

                                                                        <div class="form-group mb-3 add_active_2  update-lang_form" id="default-form_<?php echo e($reason->id); ?>">
                                                                            <label for="reason" class="form-label"><?php echo e(translate('Order Cancellation Reason')); ?> (<?php echo e(translate('messages.default')); ?>) </label>
                                                                            <input id="reason" class="form-control" name='reason[]' value="<?php echo e($reason?->getRawOriginal('reason')); ?>" type="text">
                                                                            <input type="hidden" name="lang1[]" value="default">
                                                                        </div>
                                                                                        <?php if($language): ?>
                                                                                            <?php $__empty_1 = true; $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                                            <?php
                                                                                                if($reason?->translations){
                                                                                                    $translate = [];
                                                                                                    foreach($reason?->translations as $t)
                                                                                                    {
                                                                                                        if($t->locale == $lang && $t->key=="reason"){
                                                                                                            $translate[$lang]['reason'] = $t->value;
                                                                                                        }
                                                                                                    }
                                                                                                }

                                                                                                ?>
                                                                                                <div class="form-group mb-3 d-none update-lang_form" id="<?php echo e($lang); ?>-langform_<?php echo e($reason->id); ?>">
                                                                                                    <label for="reason<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Order Cancellation Reason')); ?> (<?php echo e(strtoupper($lang)); ?>)</label>
                                                                                                    <input id="reason<?php echo e($lang); ?>" class="form-control" name='reason[]' placeholder="<?php echo e(translate('Ex:_Item_is_Broken')); ?>" value="<?php echo e($translate[$lang]['reason'] ?? null); ?>"  type="text">
                                                                                                    <input type="hidden" name="lang1[]" value="<?php echo e($lang); ?>">
                                                                                                </div>
                                                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                                                <?php endif; ?>
                                                                                                <?php endif; ?>

                                                                        <select name="user_type"  class="form-control h--45px"
                                                                            required>
                                                                            <option value=""><?php echo e(translate('messages.select_user_type')); ?></option>
                                                                            <option <?php echo e($reason->user_type == 'admin' ? 'selected': ''); ?> value="admin"><?php echo e(translate('messages.admin')); ?></option>
                                                                            <option <?php echo e($reason->user_type == 'store' ? 'selected': ''); ?> value="store"><?php echo e(translate('messages.store')); ?></option>
                                                                            <option <?php echo e($reason->user_type == 'customer' ? 'selected': ''); ?> value="customer"><?php echo e(translate('messages.customer')); ?></option>
                                                                            <option <?php echo e($reason->user_type == 'deliveryman' ? 'selected': ''); ?> value="deliveryman"><?php echo e(translate('messages.deliveryman')); ?></option>
                                                                        </select>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(translate('Close')); ?></button>
                                                                    <button type="submit" class="btn btn-primary"><?php echo e(translate('Save_changes')); ?></button>
                                                                </div>
                                                                    </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- End Table -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <!-- Modal -->
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin/js/view-pages/business-settings-order-page.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/order-index.blade.php ENDPATH**/ ?>