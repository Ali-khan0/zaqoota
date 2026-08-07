<?php $__env->startSection('title',translate('messages.system_module_setup')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/sms.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.sms_gateway_setup')); ?>

                </span>
            </h1>
            <?php echo $__env->make('admin-views.business-settings.partials.third-party-links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
        <!-- End Page Header -->

        <div class="row g-3">

            <?php if($published_status == 1): ?>
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-body  d-flex flex-wrap  justify-content-around">
                            <h4  class="w-50 flex-grow-1 module-warning-text">
                                <i class="tio-info-outined"></i>
                                <?php echo e(translate('Your_current_sms_settings_are_disabled,_because_you_have_enabled_sms_gateway_addon,_To_visit_your_currently_active_sms_gateway_settings_please_follow_the_link.')); ?>

                                </h4>
                                <div>
                                    <a href="<?php echo e(!empty($payment_url) ? $payment_url : ''); ?>" class="btn btn-outline-primary"> <i class="tio-settings"></i> <?php echo e(translate('settings')); ?></a>
                                </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php ($is_published = $published_status == 1 ? 'inactive' : ''); ?>
            <?php $__currentLoopData = $data_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gateway): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6 digital_payment_methods  <?php echo e($is_published); ?> mb-3" >
                <div class="card">
                    <div class="card-header">
                        <h4 class="page-title"><?php echo e(translate($gateway->key_name)); ?></h4>
                    </div>
                    <div class="card-body p-30">
                        <form action="<?php echo e(route('admin.business-settings.third-party.sms-module-update',[$gateway->key_name])); ?>" method="POST"
                                id="<?php echo e($gateway->key_name); ?>-form" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('post'); ?>
                        <div class="discount-type">
                                <div class="d-flex align-items-center gap-4 gap-xl-5 mb-30">
                                    <div class="custom-radio">
                                        <input class="<?php echo e(\App\Models\BusinessSetting::where('key', 'firebase_otp_verification')->first()?->value == 1 ? 'firebase-check' : ''); ?> "  type="radio" id="<?php echo e($gateway->key_name); ?>-active"
                                                name="status"
                                                value="1" <?php echo e($data_values->where('key_name',$gateway->key_name)->first()->live_values['status']?'checked':''); ?>>
                                        <label
                                            for="<?php echo e($gateway->key_name); ?>-active"> <?php echo e(translate('messages.Active')); ?></label>
                                    </div>
                                    <div class="custom-radio">
                                        <input type="radio" id="<?php echo e($gateway->key_name); ?>-inactive"
                                                name="status"
                                                value="0" <?php echo e($data_values->where('key_name',$gateway->key_name)->first()->live_values['status']?'':'checked'); ?>>
                                        <label
                                            for="<?php echo e($gateway->key_name); ?>-inactive"> <?php echo e(translate('messages.Inactive')); ?></label>
                                    </div>
                                </div>

                                <input name="gateway" value="<?php echo e($gateway->key_name); ?>" class="d-none">
                                <input name="mode" value="live" class="d-none">

                                <?php ($skip=['gateway','mode','status']); ?>
                                <?php $__currentLoopData = $data_values->where('key_name',$gateway->key_name)->first()->live_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(!in_array($key,$skip)): ?>
                                        <div class="form-floating mb-30 mt-30 text-capitalize">
                                            <label for="<?php echo e($key); ?>" class="form-label"><?php echo e(translate($key)); ?>  <?php echo e($gateway->key_name == 'alphanet_sms' &&  $key == 'sender_id'? '('. translate('messages.Optional') .')' : '*'); ?>  </label>
                                            <input id="<?php echo e($key); ?>" type="text" class="form-control"
                                                   name="<?php echo e($key); ?>"
                                                   placeholder=" <?php echo e($key == 'otp_template' ?  translate('Your_Security_Pin_is'). ' #OTP#' : translate($key) .' *'); ?>    "
                                                   value="<?php echo e(env('APP_ENV')=='demo'?'':$value); ?>">
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn--primary demo_check">
                                <?php echo e(translate('messages.Update')); ?>

                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        </div>


        <div class="modal fade" id="firebase-modal">
            <div class="modal-dialog status-warning-modal">
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
                                    <img src="<?php echo e(asset('/public/assets/admin/img/modal/order-delivery-verification-on.png')); ?>" class="mb-20">
                                    <h5 class="modal-title" ><?php echo e(translate('messages.Note')); ?> </h5>
                                </div>
                                <div class="text-center">
                                    <p class="text--danger" >
                                        <?php echo e(translate('Currently_Your_FireBase_OTP_System_is_Active.Users_won’t_get_any_OTP_from_this_SMS_Gateway' )); ?>

                                    </p>
                                </div>
                            </div>
                            <div class="btn--container justify-content-center">
                                <button type="button"  data-dismiss="modal" class="btn btn--primary min-w-120 confirm-Status-Toggle" data-dismiss="modal" ><?php echo e(translate('OK')); ?></button>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>











<?php $__env->stopSection(); ?>
<?php $__env->startPush('script_2'); ?>

    <script>

    $(document).on('click', '.firebase-check', function(event) {
        // event.preventDefault();
        $('#firebase-modal').modal('show');
    });

    </script>
<?php $__env->stopPush(); ?>




<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/sms-index.blade.php ENDPATH**/ ?>