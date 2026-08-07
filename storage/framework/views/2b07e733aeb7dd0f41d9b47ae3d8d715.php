<?php $__env->startSection('title', translate('messages.vendor_registration')); ?>
<?php $__env->startPush('css_or_js'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/toastr.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/view-pages/vendor-registration.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/landing/css/select2.min.css')); ?>"/>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <section class="m-0 py-5">
        <div class="container">
            <!-- Page Header -->
            <div class="section-header">
                <h2 class="title mb-2"><?php echo e(translate('messages.vendor')); ?> <span class="text--base"><?php echo e(translate('application')); ?></span></h2>
            </div>

            <!-- End Page Header -->

            <!-- Stepper -->
                <div class="stepper">
                    <div class="stepper-item active">
                        <div class="step-name"><?php echo e(translate('General Info')); ?></div>
                    </div>
                    <div class="stepper-item active">
                        <div class="step-name"><?php echo e(translate('Business Plan')); ?></div>
                    </div>
                    <div class="stepper-item">
                        <div class="step-name"><?php echo e(translate('Complete')); ?></div>
                    </div>
                </div>
            <!-- Stepper -->


            <form class="reg-form js-validate" action="<?php echo e(route('restaurant.payment')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <?php echo method_field('post'); ?>
                <input type="hidden" name="store_id" value="<?php echo e($store_id); ?>" >
                <input type="hidden" name="package_id" value="<?php echo e($package_id); ?>" >
                <div class="card __card mb-3 pt-4">
                    <div class="card-header border-0">
                        <h5 class="card-title text-center">
                            <?php echo e(translate('Make Payment For Your Business Plan')); ?>

                        </h5>
                    </div>
                    <div class="card-body p-4 pt-0">

                        <?php
                        if( data_get($free_trial_settings, 'subscription_free_trial_type') == 'year'){
                                $trial_period =data_get($free_trial_settings, 'subscription_free_trial_days') > 0 ? data_get($free_trial_settings, 'subscription_free_trial_days')  / 365 : 0;
                            } else if( data_get($free_trial_settings, 'subscription_free_trial_type') == 'month'){
                                $trial_period =data_get($free_trial_settings, 'subscription_free_trial_days') > 0 ? data_get($free_trial_settings, 'subscription_free_trial_days')  / 30 : 0;
                            } else{
                                $trial_period =data_get($free_trial_settings, 'subscription_free_trial_days') > 0 ? data_get($free_trial_settings, 'subscription_free_trial_days') : 0 ;
                            }
                        ?>
                        <?php if(data_get($free_trial_settings,'subscription_free_trial_status') == 1 && data_get($free_trial_settings,'subscription_free_trial_days') > 0 ): ?>
                            <label class="payment-item">
                                <input type="radio" class="d-none" checked value="free_trial" name="payment">
                                <div class="payment-item-inner justify-content-center">
                                    <div class="check">
                                        
                                        <img src="<?php echo e(asset('public/assets/admin/img/check-2.png')); ?>" class="check" alt="">
                                    </div>
                                    <span><?php echo e(translate('Continue with')); ?> <?php echo e($trial_period); ?>  <?php echo e(data_get($free_trial_settings, 'subscription_free_trial_type')); ?> <?php echo e(translate('Free_Trial')); ?></span>
                                </div>
                            </label>
                        <?php endif; ?>


                        <br>
                        <br>
                        <h6 class="text-16 mb-4"><?php echo e(translate('Pay Via Online')); ?> <span class="font-regular text-body">(<?php echo e(translate('Faster & secure way to pay bill')); ?>)</span></h6>
                        <div class="row g-3">


                            <?php $__currentLoopData = $payment_methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-6 col-lg-4">
                                <label class="payment-item">
                                    <input type="radio" class="d-none" value="<?php echo e($item['gateway']); ?>" name="payment">
                                    <div class="payment-item-inner">
                                        <div class="check">
                                            <img src="<?php echo e(asset('public/assets/admin/img/check-1.png')); ?>" class="uncheck" alt="">
                                            <img src="<?php echo e(asset('public/assets/admin/img/check-2.png')); ?>" class="check" alt="">
                                        </div>
                                        <span><?php echo e($item['gateway_title']); ?></span>
                                        <img class="ms-auto" height="30"


                                            src="<?php echo e(\App\CentralLogics\Helpers::get_full_url('payment_modules/gateway_image',$item['gateway_image'],$item['storage'] ?? 'public')); ?>"


                                        width="30" alt="">
                                    </div>
                                </label>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="text-end pt-5 d-flex flex-wrap justify-content-end gap-3">
                            <a  href="<?php echo e(route('restaurant.back',['store_id' => $store_id] )); ?>" type="button" class="cmn--btn btn--secondary shadow-none rounded-md border-0 outline-0"><?php echo e(translate('Back')); ?></a>
                            <button type="submit" class="cmn--btn rounded-md border-0 outline-0"><?php echo e(translate('Next')); ?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <?php $__env->stopSection(); ?>
    <?php $__env->startPush('script_2'); ?>
    <?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.landing.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/auth/register-subscription-payment.blade.php ENDPATH**/ ?>