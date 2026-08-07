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
                    <div style class="stepper-item active">
                        <div class="step-name"><?php echo e(translate('General Info')); ?></div>
                    </div>
                    <div class="stepper-item active">
                        <div class="step-name"><?php echo e(translate('Business Plan')); ?></div>
                    </div>
                    <div  class="stepper-item active">
                        <div class="step-name  <?php echo e(isset($payment_status) && $payment_status == 'fail' ? 'text-danger' : ''); ?>"><?php echo e(translate('Complete')); ?></div>
                    </div>
                </div>
            <!-- Stepper -->


            <div class="reg-form js-validate">
                <div class="card __card mb-3">
                    <div class="card-header border-0 pb-0 text-center pt-5">
                            <?php if( isset($payment_status) && $payment_status == 'fail'): ?>
                            <img src="<?php echo e(asset('/public/assets/landing/img/Failed.gif')); ?>" width="40" alt="" class="mb-4">
                            <h5 class="card-title text-center">
                                <?php echo e(translate('Transaction Failed!')); ?>

                            </h5>
                            <?php else: ?>
                            <img src="<?php echo e(asset('/public/assets/landing/img/Success.gif')); ?>" width="40" alt="" class="mb-4">
                            <h5 class="card-title text-center">
                                <?php echo e(translate('Congratulations!')); ?>

                            </h5>

                            <?php endif; ?>


                    </div>
                    <div class="card-body p-4 pb-5">
                        <div class="register-congrats-txt">
                            <?php if(isset($type) && $type == 'commission'): ?>
                            <?php echo e(translate('You’ve opted for our commission-based plan. Admin will review the details and activate your account shortly. To explore the site.')); ?>

                            <a href="<?php echo e(route('home',['new_user'=> true])); ?>" class="text-base font-bold"><?php echo e(translate('visit_here')); ?></a>

                            <?php elseif( isset($payment_status) && $payment_status == 'fail'): ?>
                            <?php echo e(translate('Sorry, Your Transaction can’t be completed. Please choose another payment method.')); ?>

                            <a href="<?php echo e(route('restaurant.back',['store_id' => $store_id ?? null])); ?>" class="text-base font-bold"><?php echo e(translate('Try_again')); ?></a>
                            <?php else: ?>
                            <?php echo e(translate('Thank you for your subscription purchase! Your payment was successfully processed. Please note that your subscription will be activated once it has been approved by our Admin Team. To explore the site')); ?>

                            <a href="<?php echo e(route('home',['new_user'=> true])); ?>" class="text-base font-bold"><?php echo e(translate('visit_here')); ?></a>
                            <?php endif; ?>

                        </div>

                        
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php $__env->stopSection(); ?>
    <?php $__env->startPush('script_2'); ?>
    <script>
        <?php if(! (isset($payment_status) && $payment_status == 'fail')): ?>
        document.addEventListener("DOMContentLoaded", function() {
            var homeLink = document.getElementById('home-link');
            var newUrl = "<?php echo e(route('home',['new_user'=> true])); ?>";
            homeLink.setAttribute('href', newUrl);
        });
        <?php endif; ?>
    </script>
    <?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.landing.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/auth/register-complete.blade.php ENDPATH**/ ?>