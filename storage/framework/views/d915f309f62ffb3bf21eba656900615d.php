<?php $__env->startSection('title', translate('messages.vendor_registration')); ?>
<?php $__env->startPush('css_or_js'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/toastr.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/view-pages/vendor-registration.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/landing/css/select2.min.css')); ?>" />
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <section class="m-0 py-5">
        <div class="container">
            <!-- Page Header -->
            <div class="section-header">
                <h2 class="title mb-2"><?php echo e(translate('messages.vendor')); ?> <span
                        class="text--base"><?php echo e(translate('application')); ?></span></h2>
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


            <form action="<?php echo e(route('restaurant.business_plan')); ?>" class="reg-form js-validate" method="post">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="store_id" value="<?php echo e($store_id); ?>">
                <div class="card __card mb-3">
                    <div class="card-header border-0">
                        <h5 class="card-title text-center">
                            <?php echo e(translate('Choose Your Business Plan')); ?>

                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <?php if(\App\CentralLogics\Helpers::commission_check()): ?>
                                <div class="col-sm-6">
                                    <label class="plan-check-item pb-3 pb-sm-0">
                                        <input type="radio" name="business_plan" value="commission-base" class="d-none"
                                            checked>
                                        <div class="plan-check-item-inner">
                                            <div class="d-flex gap-3 justify-content-between align-items-center mb-10">
                                                <h5 class="mb-0"><?php echo e(translate('Commision_Base')); ?></h5>
                                                <span class="checkmark">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                                        <path
                                                            d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <p>
                                                <?php echo e(translate('Vendor will pay')); ?> <?php echo e($admin_commission); ?>%
                                                <?php echo e(translate('commission to')); ?> <?php echo e($business_name); ?>

                                                <?php echo e(translate('from each order. You will get access of all the features and options  in vendor panel , app and interaction with user.')); ?>

                                            </p>
                                        </div>
                                    </label>
                                </div>
                            <?php endif; ?>
                            <div class="col-sm-6">
                                <label class="plan-check-item">
                                    <input type="radio" name="business_plan" value="subscription-base" class="d-none">
                                    <div class="plan-check-item-inner">
                                        <div class="d-flex gap-3 justify-content-between align-items-center mb-10">
                                            <h5 class="mb-0"><?php echo e(translate('Subscription_Base')); ?></h5>
                                            <span class="checkmark">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                                    <path
                                                        d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0" />
                                                </svg>
                                            </span>
                                        </div>
                                        <p>
                                            <?php echo e(translate('Run vendor by puchasing subsciption packages. You will have access the features of in vendor panel , app and interaction with user according to the subscription packages.')); ?>

                                        </p>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div id="subscription-plan">
                            <br>
                            <div class="card-header px-0 m-0 border-0">
                                <h5 class="card-title text-center">
                                    <?php echo e(translate('Choose Subscription Package')); ?>

                                </h5>
                            </div>
                            <div class="plan-slider owl-theme owl-carousel owl-refresh">

                                <?php $__empty_1 = true; $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <label
                                        class="__plan-item <?php echo e((count($packages) > 4 && $key == 2) || (count($packages) < 5 && $key == 1) ? 'active' : ''); ?> ">
                                        <input type="radio" name="package_id" value="<?php echo e($package->id); ?>" class="d-none">
                                        <div class="inner-div">
                                            <div class="text-center">

                                                <h3 class="title"><?php echo e($package->package_name); ?></h3>
                                                <h2 class="price">
                                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($package->price)); ?></h2>
                                                <div class="day-count"><?php echo e($package->validity); ?>

                                                    <?php echo e(translate('messages.days')); ?></div>
                                            </div>
                                            <ul class="info">

                                                <?php if($package->pos): ?>
                                                    <li>
                                                        <img src="<?php echo e(asset('/public/assets/landing/img/check-1.svg')); ?>"
                                                            class="check" alt="">
                                                        <img src="<?php echo e(asset('/public/assets/landing/img/check-2.svg')); ?>"
                                                            class="check-white" alt=""> <span>
                                                            <?php echo e(translate('messages.POS')); ?> </span>
                                                    </li>
                                                <?php endif; ?>
                                                <?php if($package->mobile_app): ?>
                                                    <li>
                                                        <img src="<?php echo e(asset('/public/assets/landing/img/check-1.svg')); ?>"
                                                            class="check" alt="">
                                                        <img src="<?php echo e(asset('/public/assets/landing/img/check-2.svg')); ?>"
                                                            class="check-white" alt=""> <span>
                                                            <?php echo e(translate('messages.mobile_app')); ?> </span>
                                                    </li>
                                                <?php endif; ?>
                                                <?php if($package->chat): ?>
                                                    <li>
                                                        <img src="<?php echo e(asset('/public/assets/landing/img/check-1.svg')); ?>"
                                                            class="check" alt="">
                                                        <img src="<?php echo e(asset('/public/assets/landing/img/check-2.svg')); ?>"
                                                            class="check-white" alt=""> <span>
                                                            <?php echo e(translate('messages.chatting_options')); ?> </span>
                                                    </li>
                                                <?php endif; ?>
                                                <?php if($package->review): ?>
                                                    <li>
                                                        <img src="<?php echo e(asset('/public/assets/landing/img/check-1.svg')); ?>"
                                                            class="check" alt="">
                                                        <img src="<?php echo e(asset('/public/assets/landing/img/check-2.svg')); ?>"
                                                            class="check-white" alt=""> <span>
                                                            <?php echo e(translate('messages.review_section')); ?> </span>
                                                    </li>
                                                <?php endif; ?>
                                                <?php if($package->self_delivery): ?>
                                                    <li>
                                                        <img src="<?php echo e(asset('/public/assets/landing/img/check-1.svg')); ?>"
                                                            class="check" alt="">
                                                        <img src="<?php echo e(asset('/public/assets/landing/img/check-2.svg')); ?>"
                                                            class="check-white" alt=""> <span>
                                                            <?php echo e(translate('messages.self_delivery')); ?> </span>
                                                    </li>
                                                <?php endif; ?>
                                                <?php if($package->max_order == 'unlimited'): ?>
                                                    <li>
                                                        <img src="<?php echo e(asset('/public/assets/landing/img/check-1.svg')); ?>"
                                                            class="check" alt="">
                                                        <img src="<?php echo e(asset('/public/assets/landing/img/check-2.svg')); ?>"
                                                            class="check-white" alt=""> <span>
                                                            <?php echo e(isset($module) && $module == 'rental' ?  translate('messages.Unlimited_trips') :translate('messages.Unlimited_Orders')); ?> </span>
                                                    </li>
                                                <?php else: ?>
                                                    <li>
                                                        <img src="<?php echo e(asset('/public/assets/landing/img/check-1.svg')); ?>"
                                                            class="check" alt="">
                                                        <img src="<?php echo e(asset('/public/assets/landing/img/check-2.svg')); ?>"
                                                            class="check-white" alt=""> <span>
                                                            <?php echo e($package->max_order); ?> <?php echo e(isset($module) && $module == 'rental' ?  translate('messages.trips') : translate('messages.Orders')); ?>

                                                        </span>
                                                    </li>
                                                <?php endif; ?>
                                                <?php if($package->max_product == 'unlimited'): ?>
                                                    <li>
                                                        <img src="<?php echo e(asset('/public/assets/landing/img/check-1.svg')); ?>"
                                                            class="check" alt="">
                                                        <img src="<?php echo e(asset('/public/assets/landing/img/check-2.svg')); ?>"
                                                            class="check-white" alt=""> <span>
                                                            <?php echo e(translate('messages.Unlimited_uploads')); ?> </span>
                                                    </li>
                                                <?php else: ?>
                                                    <li>
                                                        <img src="<?php echo e(asset('/public/assets/landing/img/check-1.svg')); ?>"
                                                            class="check" alt="">
                                                        <img src="<?php echo e(asset('/public/assets/landing/img/check-2.svg')); ?>"
                                                            class="check-white" alt=""> <span>
                                                            <?php echo e($package->max_product); ?>

                                                            <?php echo e(translate('messages.uploads')); ?> </span>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </label>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>

                            </div>
                        </div>
                        <div class="text-end pt-5 d-flex flex-wrap justify-content-end gap-3">
                            
                            <button type="submit"
                                class="cmn--btn rounded-md border-0 outline-0"><?php echo e(translate('Next')); ?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script_2'); ?>
    <script>
        $('.plan-slider').owlCarousel({
            loop: false,
            margin: 30,
            responsiveClass: true,
            nav: false,
            dots: false,
            items: 3,
            // center: true,
            // autoplay:true,
            // autoplayTimeout:2500,
            // autoplayHoverPause:true,
            startPosition: 1,

            responsive: {
                0: {
                    items: 1.1,
                    margin: 10,
                },
                375: {
                    items: 1.3,
                    margin: 30,
                },
                576: {
                    items: 1.7,
                },
                768: {
                    items: 2.2,
                    margin: 40,
                },
                992: {
                    items: 3,
                    margin: 40,
                },
                1200: {
                    items: 4,
                    margin: 40,
                }
            }
        })
    </script>

    <script>
        $(window).on('load', function() {
            $('input[name="business_plan"]').each(function() {
                if ($(this).is(':checked')) {
                    if ($(this).val() == 'subscription-base') {
                        $('#subscription-plan').show()
                    } else {
                        $('#subscription-plan').hide()
                    }
                }
            })
            $('input[name="package_id"]').each(function() {
                if ($(this).is(':checked')) {
                    $(this).closest('.__plan-item').addClass('active')
                }
            })
        })
        $('input[name="business_plan"]').on('change', function() {
            if ($(this).val() == 'subscription-base') {
                $('#subscription-plan').slideDown()
            } else {
                $('#subscription-plan').slideUp()
            }
        })
        $('input[name="package_id"]').on('change', function() {
            $('input[name="package_id"]').each(function() {
                $(this).closest('.__plan-item').removeClass('active')
            })
            $(this).closest('.__plan-item').addClass('active')
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.landing.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/auth/register-step-2.blade.php ENDPATH**/ ?>