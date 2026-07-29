<?php $__env->startSection('title',translate('messages.Payment Method')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <?php
        $currency= \App\Models\BusinessSetting::where('key','currency')->first()?->value?? 'USD';
        $checkCurrency = \App\CentralLogics\Helpers::checkCurrency($currency);
        $currency_symbol =\App\CentralLogics\Helpers::currency_symbol();

    ?>

        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('/public/assets/admin/img/payment.png')); ?>" class="w--22" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.payment_gateway_setup')); ?>

                </span>
            </h1>
            <?php echo $__env->make('admin-views.business-settings.partials.third-party-links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <div class="d-flex flex-wrap justify-content-end align-items-center flex-grow-1">
                <div class="blinkings trx_top active">
                    <i class="tio-info-outined"></i>
                    <div class="business-notes">
                        <h6><img src="<?php echo e(asset('/public/assets/admin/img/notes.png')); ?>" alt=""> <?php echo e(translate('Note')); ?></h6>
                        <div>
                            <?php echo e(translate('Without configuring this section functionality will not work properly. Thus the whole system will not work as it planned')); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="card border-0">
            <div class="card-header card-header-shadow">
                <h5 class="card-title align-items-center">
                    <img src="<?php echo e(asset('/public/assets/admin/img/payment-method.png')); ?>" class="mr-1" alt="">
                    <?php echo e(translate('Payment Method')); ?>

                </h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <?php ($config=\App\CentralLogics\Helpers::get_business_settings('cash_on_delivery')); ?>
                        <form action="<?php echo e(route('admin.business-settings.third-party.payment-method-update',['cash_on_delivery'])); ?>"
                              method="post" id="cash_on_delivery_status_form">
                            <?php echo csrf_field(); ?>
                            <label class="toggle-switch h--45px toggle-switch-sm d-flex justify-content-between border rounded px-3 py-0 form-control">
                                <span class="pr-1 d-flex align-items-center switch--label">
                                    <span class="line--limit-1">
                                        <?php echo e(translate('Cash On Delivery')); ?>

                                    </span>
                                    <span class="form-label-secondary text-danger d-flex" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('If_enabled_Customers_will_be_able_to_select_COD_as_a_payment_method_during_checkout')); ?>"><img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="Veg/non-veg toggle"> * </span>
                                </span>
                                <input type="hidden" name="toggle_type" value="cash_on_delivery">
                                <input
                                    type="checkbox" id="cash_on_delivery_status"
                                    data-id="cash_on_delivery_status"
                                    data-type="status"
                                    data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/digital-payment-on.png')); ?>"
                                    data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/digital-payment-off.png')); ?>"
                                    data-title-on="<?php echo e(translate('By Turning ON Cash On Delivery Option')); ?>"
                                    data-title-off="<?php echo e(translate('By Turning OFF Cash On Delivery Option')); ?>"
                                    data-text-on="<p><?php echo e(translate('Customers will not be able to select COD as a payment method during checkout. Please review your settings and enable COD if you wish to offer this payment option to customers.')); ?></p>"
                                    data-text-off="<p><?php echo e(translate('Customers will be able to select COD as a payment method during checkout.')); ?></p>"
                                    class="status toggle-switch-input dynamic-checkbox"
                                    name="status" value="1" <?php echo e($config?($config['status']==1?'checked':''):''); ?>>
                                <span class="toggle-switch-label text">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <?php ($digital_payment=\App\CentralLogics\Helpers::get_business_settings('digital_payment')); ?>
                        <form action="<?php echo e(route('admin.business-settings.third-party.payment-method-update',['digital_payment'])); ?>"
                              method="post" id="digital_payment_status_form">
                            <?php echo csrf_field(); ?>
                            <label class="toggle-switch h--45px toggle-switch-sm d-flex justify-content-between border rounded px-3 py-0 form-control">
                                <span class="pr-1 d-flex align-items-center switch--label">
                                    <span class="line--limit-1">
                                        <?php echo e(translate('digital payment')); ?>

                                    </span>
                                    <span class="form-label-secondary text-danger d-flex" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('If_enabled_Customers_will_be_able_to_select_digital_payment_as_a_payment_method_during_checkout')); ?>"><img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="Veg/non-veg toggle"> * </span>
                                </span>
                                <input type="hidden" name="toggle_type" value="digital_payment">
                                <input  type="checkbox" id="digital_payment_status"
                                        data-id="digital_payment_status"
                                        data-type="status"
                                        data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/digital-payment-on.png')); ?>"
                                        data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/digital-payment-off.png')); ?>"
                                        data-title-on="<?php echo e(translate('By Turning ON Digital Payment Option')); ?>"
                                        data-title-off="<?php echo e(translate('By Turning OFF Digital Payment Option')); ?>"
                                        data-text-on="<p><?php echo e(translate('Customers will not be able to select digital payment as a payment method during checkout. Please review your settings and enable digital payment if you wish to offer this payment option to customers.')); ?></p>"
                                        data-text-off="<p><?php echo e(translate('Customers will be able to select digital payment as a payment method during checkout.')); ?></p>"
                                        class="status toggle-switch-input dynamic-checkbox"
                                        name="status" value="1" <?php echo e($digital_payment?($digital_payment['status']==1?'checked':''):''); ?>>
                                <span class="toggle-switch-label text">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <?php ($Offline_Payment=\App\CentralLogics\Helpers::get_business_settings('offline_payment_status')); ?>
                        <form action="<?php echo e(route('admin.business-settings.third-party.payment-method-update',['offline_payment_status'])); ?>"
                              method="post" id="offline_payment_status_form">
                            <?php echo csrf_field(); ?>
                            <label class="toggle-switch h--45px toggle-switch-sm d-flex justify-content-between border rounded px-3 py-0 form-control">
                                <span class="pr-1 d-flex align-items-center switch--label">
                                    <span class="line--limit-1">
                                        <?php echo e(translate('Offline_Payment')); ?>

                                    </span>
                                    <span class="form-label-secondary text-danger d-flex" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('If_enabled_Customers_will_be_able_to_select_offline_payment_as_a_payment_method_during_checkout')); ?>"><img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="Veg/non-veg toggle"> * </span>
                                </span>
                                <input type="hidden" name="toggle_type" value="offline_payment_status" >
                                <input  type="checkbox" id="offline_payment_status"
                                        data-id="offline_payment_status"
                                        data-type="status"
                                        data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/digital-payment-on.png')); ?>"
                                        data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/digital-payment-off.png')); ?>"
                                        data-title-on="<?php echo e(translate('By Turning ON Offline Payment Option')); ?>"
                                        data-title-off="<?php echo e(translate('By Turning OFF Offline Payment Option')); ?>"
                                        data-text-on="<p><?php echo e(translate('Customers will not be able to select Offline Payment as a payment method during checkout. Please review your settings and enable Offline Payment if you wish to offer this payment option to customers.')); ?></p>"
                                        data-text-off="<p><?php echo e(translate('Customers will be able to select Offline Payment as a payment method during checkout.')); ?></p>"
                                        class="status toggle-switch-input dynamic-checkbox"

                                        name="status" value="1" <?php echo e($Offline_Payment == 1?'checked':''); ?>>
                                <span class="toggle-switch-label text">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php if($published_status == 1): ?>
            <br>
            <div>
                <div class="card">
                    <div class="card-body d-flex flex-wrap justify-content-around">
                        <h4 class="w-50 flex-grow-1 module-warning-text">
                            <i class="tio-info-outined"></i>
                            <?php echo e(translate('Your_current_payment_settings_are_disabled,_because_you_have_enabled_payment_gateway_addon,_To_visit_your_currently_active_payment_gateway_settings_please_follow_the_link.')); ?></h4>
                        <div>
                            <a href="<?php echo e(!empty($payment_url) ? $payment_url : ''); ?>" class="btn btn-outline-primary"> <i class="tio-settings"></i> <?php echo e(translate('Settings')); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if($digital_payment && $digital_payment['status'] ==1 && $checkCurrency !== true ): ?>
        <br>
        <div>
            <div class="card">
                <div class="bg--3 px-5 pb-2 card-body d-flex flex-wrap justify-content-around">
                    <p class="w-50 fs-15 text-danger flex-grow-1 ">
                        <i class="tio-info-outined"></i>
                    <?php echo e(translate($checkCurrency).' '. translate('Does_not_support_your_current')); ?>   <?php echo e($currency); ?>(<?php echo e($currency_symbol); ?>) <?php echo e(translate('Currency,_thus_users_cannot_use_this_digital_payment_options_as_payment_in_the_websites_and_apps.')); ?></p>

                </div>
            </div>
        </div>
        <?php elseif($digital_payment && $digital_payment['status'] ==1 && $data_values->where('is_active',1  )->count()  == 0): ?>
        <br>
        <div>
            <div class="card">
                <div class="bg--3 px-5 pb-2 card-body d-flex flex-wrap justify-content-around">
                    <p class="w-50 fs-15 text-danger flex-grow-1 ">
                        <i class="tio-info-outined"></i>
                    <?php echo e(translate('Currently,_there_is_no_digital_payment_method_is_set_up_that_supports_')); ?>   <?php echo e($currency); ?>(<?php echo e($currency_symbol); ?>),<?php echo e(translate('_thus_users_cannot_view_digital_payment_options_in_their_websites_and_apps_._You_must_activate_at_least_one_digital_payment_method_that_supports_')); ?>   <?php echo e($currency); ?>(<?php echo e($currency_symbol); ?>) <?php echo e(translate('_otherwise,_all_users_will_be_unable_to_pay_via_digital_payments.')); ?></p>

                </div>
            </div>
        </div>

        <?php endif; ?>
        <?php ($is_published = $published_status == 1 ? 'inactive' : ''); ?>
        <!-- Tab Content -->
        <div class="row digital_payment_methods  <?php echo e($is_published); ?> mt-3 g-3">
            <?php $__currentLoopData = $data_values->sortByDesc('is_active'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment_key => $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <form action="<?php echo e(env('APP_MODE')!='demo'?route('admin.business-settings.third-party.payment-method-update'):'javascript:'); ?>" method="POST"
                              id="<?php echo e($payment->key_name); ?>-form" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="card-header d-flex flex-wrap align-content-around">
                                <h5>
                                    <span class="text-uppercase"><?php echo e(str_replace('_',' ',$payment->key_name)); ?></span>
                                </h5>
                                <label  id="span_on_<?php echo e($payment->key_name); ?>" class="switch--custom-label toggle-switch toggle-switch-sm d-inline-flex">
                                    <span
                                        class="mr-2 switch--custom-label-text text-primary on text-uppercase"><?php echo e(translate('on')); ?></span>
                                    <span class="mr-2 switch--custom-label-text off text-uppercase"><?php echo e(translate('off')); ?></span>
                                    <input id="add_check_<?php echo e($payment->key_name); ?>"  type="checkbox" name="status" value="1" data-gateway="<?php echo e($payment->key_name); ?>" data-status="<?php echo e($payment['is_active']); ?>"
                                           class="toggle-switch-input  <?php echo e(\App\CentralLogics\Helpers::checkCurrency($payment->key_name , 'payment_gateway') === true && $payment['is_active']  ? 'open-warning-modal' : ''); ?> " <?php echo e($payment['is_active']==1?'checked':''); ?>>
                                    <span class="toggle-switch-label text">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                </label>
                            </div>

                            <?php ($additional_data = $payment['additional_data'] != null ? json_decode($payment['additional_data']) : []); ?>
                            <div class="card-body">
                                <div class="payment--gateway-img">
                                    <img  id="<?php echo e($payment->key_name); ?>-image-preview" class="__height-80 onerror-image"
                                          data-onerror-image="<?php echo e(asset('/public/assets/admin/img/payment/placeholder.png')); ?>"

                                          <?php if($additional_data != null): ?>
                                              src="<?php echo e(\App\CentralLogics\Helpers::get_full_url('payment_modules/gateway_image',$additional_data?->gateway_image,$additional_data?->storage ?? 'public')); ?>"

                                          <?php else: ?>
                                              src="<?php echo e(asset('/public/assets/admin/img/payment/placeholder.png')); ?>"
                                          <?php endif; ?>



                                          alt="public">
                                </div>

                                <input name="gateway" value="<?php echo e($payment->key_name); ?>" class="d-none">

                                <?php ($mode=$data_values->where('key_name',$payment->key_name)->first()->live_values['mode']); ?>
                                <div class="form-floating mb-2" >
                                    <select class="js-select form-control theme-input-style w-100" name="mode">
                                        <option value="live" <?php echo e($mode=='live'?'selected':''); ?>><?php echo e(translate('Live')); ?></option>
                                        <option value="test" <?php echo e($mode=='test'?'selected':''); ?>><?php echo e(translate('Test')); ?></option>
                                    </select>
                                </div>

                                <?php ($skip=['gateway','mode','status']); ?>
                                <?php $__currentLoopData = $data_values->where('key_name',$payment->key_name)->first()->live_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(!in_array($key,$skip)): ?>
                                        <div class="form-floating mb-2" >
                                            <label for="<?php echo e($payment_key); ?>-<?php echo e($key); ?>"
                                                   class="form-label"><?php echo e(ucwords(str_replace('_',' ',$key))); ?>

                                                *</label>
                                            <input id="<?php echo e($payment_key); ?>-<?php echo e($key); ?>" type="text" class="form-control"
                                                   name="<?php echo e($key); ?>"
                                                   placeholder="<?php echo e(ucwords(str_replace('_',' ',$key))); ?> *"
                                                   value="<?php echo e(env('APP_ENV')=='demo'?'':$value); ?>">
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php if($payment['key_name'] == 'paystack'): ?>
                                    <div class="form-floating mb-2" >
                                        <label for="Callback_Url" class="form-label"><?php echo e(translate('Callback Url')); ?></label>
                                        <input id="Callback_Url" type="text"
                                               class="form-control"
                                               placeholder="<?php echo e(translate('Callback Url')); ?> *"
                                               readonly
                                               value="<?php echo e(env('APP_ENV')=='demo'?'': route('paystack.callback')); ?>" <?php echo e($is_published); ?>>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if($payment['key_name'] == 'assan_pay'): ?>
                                    <?php ($assanPayCallback = env('APP_ENV')=='demo' ? '' : route('assan-pay.callback', absolute: true)); ?>
                                    <div class="form-floating mb-2" >
                                        <label for="AssanPay_Callback_Url" class="form-label"><?php echo e(translate('Callback Url')); ?> (for AssanPay dashboard)</label>
                                        <input id="AssanPay_Callback_Url" type="text"
                                               class="form-control"
                                               placeholder="<?php echo e(translate('Callback Url')); ?>"
                                               readonly
                                               value="<?php echo e($assanPayCallback); ?>" <?php echo e($is_published); ?>>
                                    </div>
                                    <p class="small text-muted mb-3">
                                        <strong>Merchant ID:</strong> From AssanPay Merchant Portal → Dashboard (used in API path <code>/payment-request/{merchantId}</code>).
                                        <br>
                                        <strong>API key:</strong> From the portal; sent as <code>Authorization: Bearer …</code>. If AssanPay gives a different header, contact support or adjust <code>AssanPayController::httpWithAssanAuth</code>.
                                        <br>
                                        <strong>Decryption key:</strong> Optional; also sent as <code>X-Decryption-Key</code> if filled (remove that header in code if not required).
                                        <br>
                                        <strong>API base URL:</strong> Usually <code>https://api.assanpay.com</code> (leave default unless docs say otherwise). Used for POST <code>/payment-request/…</code> and GET <code>/payment/all-inquiry/…</code>.
                                        <br>
                                        <strong>Return <code>link</code> (your site):</strong> Use the readonly URL above as the <code>link</code> in the API body so customers return to your site; the app then checks payment status via AssanPay inquiry.
                                    </p>
                                <?php endif; ?>

                                <div class="form-floating mb-2" >
                                    <label for="payment_gateway_title-<?php echo e($payment_key); ?>"
                                           class="form-label"><?php echo e(translate('payment_gateway_title')); ?></label>
                                    <input type="text" class="form-control"
                                           name="gateway_title" id="payment_gateway_title-<?php echo e($payment_key); ?>"
                                           placeholder="<?php echo e(translate('payment_gateway_title')); ?>"
                                           value="<?php echo e($additional_data != null ? $additional_data->gateway_title : ''); ?>">
                                </div>

                                <div class="form-floating mb-2" >
                                    <label for="exampleFormControlInput1"
                                           class="form-label"><?php echo e(translate('logo')); ?></label>
                                    <input type="file" class="form-control logo" name="gateway_image" data-id="<?php echo e($payment->key_name); ?>" id="<?php echo e($payment->key_name); ?>-image" accept=".webp, .jpg, .png, .jpeg|image/*">
                                </div>

                                <div class="text-right mt-2 "  >
                                    <button type="submit" class="btn btn-primary px-5"><?php echo e(translate('save')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <!-- End Tab Content -->
    </div>


    <div class="modal fade" id="payment-gateway-warning-modal">
        <div class="modal-dialog modal-dialog-centered status-warning-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" class="tio-clear"></span>
                    </button>
                </div>
                <div class="modal-body pb-5 pt-0">
                    <div class="max-349 mx-auto mb-20">
                        <div>
                            <div class="text-center">
                                <img width="80" src="<?php echo e(asset('public/assets/admin/img/modal/gateway.png')); ?>" class="mb-20">
                                <h5 class="modal-title"></h5>
                            </div>
                            <div class="text-center" >
                                <h3 > <?php echo e(translate('Are_you_sure,_want_to_turn_Off')); ?> <span id="gateway_name"></span> <?php echo e(translate('_as_the_Digital_Payment_method?')); ?></h3>
                                <div > <p><?php echo e(translate('You_must_active_at_least_one_digital_payment_method_that_support')); ?> <?php echo e($currency); ?> <?php echo e(translate('._Otherwise_customers_cannot_pay_via_digital_payments_from_the_app_and_websites._And_Also_restaurants_cannot_pay_you_digitally.')); ?></h3></p></div>
                            </div>

                            <div class="text-center mb-4" >
                                <a class="text--underline" href="<?php echo e(route('admin.business-settings.business-setup')); ?>"> <?php echo e(translate('View_Currency_Settings.')); ?></a>
                            </div>
                            </div>

                        <div class="btn--container justify-content-center">
                            <button data-dismiss="modal"  class="btn btn--cancel min-w-120" ><?php echo e(translate("Cancel")); ?></button>
                            <button data-dismiss="modal"  id="confirm-currency-change" type="button"  class="btn btn--primary min-w-120"><?php echo e(translate('OK')); ?></button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin/js/view-pages/business-settings-payment-page.js')); ?>"></script>
    <script>
        "use strict";


        $(document).on('click', '.open-warning-modal', function(event) {

            const elements = document.querySelectorAll('.open-warning-modal');
            const count = elements.length;

            if(elements.length === 1){

                let gateway = $(this).data('gateway');
                if ($(this).is(':checked') === false) {
                    event.preventDefault();
                    $('#payment-gateway-warning-modal').modal('show');
                    var formated_text=  gateway.split('_').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')
                    $('#gateway_name').attr('data-gateway_key', gateway).html(formated_text);
                    $(this).data('originalEvent', event);
                }
            }


        });

    $(document).on('click', '#confirm-currency-change', function() {
    var gatewayName =   $('#gateway_name').data('gateway_key');
    if (gatewayName) {
    $('#span_on_' + gatewayName).removeClass('checked');
    }

    var originalEvent = $('.open-warning-modal[data-gateway="' + gatewayName + '"]').data('originalEvent');
    if (originalEvent) {
    var newEvent = $.Event(originalEvent);
    $(originalEvent.target).trigger(newEvent);
    }

    $('#payment-gateway-warning-modal').modal('hide');
    });

    $(".logo").change(function() {
    let viewer = $(this).data('id');
    if (this.files && this.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            $('#' + viewer + '-image-preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    }
    });


        <?php if(!isset($digital_payment) || $digital_payment['status']==0): ?>
        $('.digital_payment_methods').hide();
        <?php endif; ?>
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/business-settings/payment-index.blade.php ENDPATH**/ ?>