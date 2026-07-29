<div class="plan-slider owl-theme owl-carousel owl-refresh">
    <?php $__empty_1 = true; $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <label
            class="__plan-item <?php echo e((count($packages) > 4 && $key == 2) || (count($packages) < 5 && $key == 1) ? 'active' : ''); ?> ">
            <input type="radio" name="package_id"  <?php echo e((count($packages) > 4 && $key == 2) || (count($packages) < 5 && $key == 1) ? 'checked' : ''); ?> id="package_id<?php echo e($key); ?>" value="<?php echo e($package->id); ?>"
                class="d-none">
            <div class="inner-div">
                <div class="text-center">

                    <h3 class="title"><?php echo e($package->package_name); ?></h3>
                    <h2 class="price">
                        <?php echo e(\App\CentralLogics\Helpers::format_currency($package->price)); ?>

                    </h2>
                    <div class="day-count"><?php echo e($package->validity); ?>

                        <?php echo e(translate('messages.days')); ?></div>
                </div>
                <ul class="info">

                    <?php if($package->pos): ?>
                        <li>
                            <img src="<?php echo e(asset('/public/assets/landing/img/check-1.svg')); ?>" class="check"
                                alt="">
                            <img src="<?php echo e(asset('/public/assets/landing/img/check-2.svg')); ?>" class="check-white"
                                alt=""> <span>
                                <?php echo e(translate('messages.POS')); ?> </span>
                        </li>
                    <?php endif; ?>
                    <?php if($package->mobile_app): ?>
                        <li>
                            <img src="<?php echo e(asset('/public/assets/landing/img/check-1.svg')); ?>" class="check"
                                alt="">
                            <img src="<?php echo e(asset('/public/assets/landing/img/check-2.svg')); ?>" class="check-white"
                                alt=""> <span>
                                <?php echo e(translate('messages.mobile_app')); ?> </span>
                        </li>
                    <?php endif; ?>
                    <?php if($package->chat): ?>
                        <li>
                            <img src="<?php echo e(asset('/public/assets/landing/img/check-1.svg')); ?>" class="check"
                                alt="">
                            <img src="<?php echo e(asset('/public/assets/landing/img/check-2.svg')); ?>" class="check-white"
                                alt=""> <span>
                                <?php echo e(translate('messages.chatting_options')); ?> </span>
                        </li>
                    <?php endif; ?>
                    <?php if($package->review): ?>
                        <li>
                            <img src="<?php echo e(asset('/public/assets/landing/img/check-1.svg')); ?>" class="check"
                                alt="">
                            <img src="<?php echo e(asset('/public/assets/landing/img/check-2.svg')); ?>" class="check-white"
                                alt=""> <span>
                                <?php echo e(translate('messages.review_section')); ?> </span>
                        </li>
                    <?php endif; ?>
                    <?php if($package->self_delivery): ?>
                        <li>
                            <img src="<?php echo e(asset('/public/assets/landing/img/check-1.svg')); ?>" class="check"
                                alt="">
                            <img src="<?php echo e(asset('/public/assets/landing/img/check-2.svg')); ?>" class="check-white"
                                alt=""> <span>
                                <?php echo e(translate('messages.self_delivery')); ?> </span>
                        </li>
                    <?php endif; ?>
                    <?php if($package->max_order == 'unlimited'): ?>
                        <li>
                            <img src="<?php echo e(asset('/public/assets/landing/img/check-1.svg')); ?>" class="check"
                                alt="">
                            <img src="<?php echo e(asset('/public/assets/landing/img/check-2.svg')); ?>" class="check-white"
                                alt=""> <span>
                                <?php echo e(isset($module) && $module == 'rental' ?  translate('messages.Unlimited_Trips') : translate('messages.Unlimited_Orders')); ?> </span>
                        </li>
                    <?php else: ?>
                        <li>
                            <img src="<?php echo e(asset('/public/assets/landing/img/check-1.svg')); ?>" class="check"
                                alt="">
                            <img src="<?php echo e(asset('/public/assets/landing/img/check-2.svg')); ?>" class="check-white"
                                alt=""> <span>
                                <?php echo e($package->max_order); ?>

                                <?php echo e(isset($module) && $module == 'rental' ?  translate('messages.Trips') : translate('messages.Orders')); ?> </span>
                        </li>
                    <?php endif; ?>
                    <?php if($package->max_product == 'unlimited'): ?>
                        <li>
                            <img src="<?php echo e(asset('/public/assets/landing/img/check-1.svg')); ?>" class="check"
                                alt="">
                            <img src="<?php echo e(asset('/public/assets/landing/img/check-2.svg')); ?>" class="check-white"
                                alt=""> <span>
                                <?php echo e(translate('messages.Unlimited_uploads')); ?> </span>
                        </li>
                    <?php else: ?>
                        <li>
                            <img src="<?php echo e(asset('/public/assets/landing/img/check-1.svg')); ?>" class="check"
                                alt="">
                            <img src="<?php echo e(asset('/public/assets/landing/img/check-2.svg')); ?>" class="check-white"
                                alt=""> <span>
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
<script>
    $('.plan-slider').owlCarousel({
        loop: false,
        margin: 30,
        responsiveClass: true,
        nav: false,
        dots: false,
        items: 3,
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
        $('#reset-btn').on('click', function() {
            location.reload()
        })
    </script>
<?php /**PATH /var/www/zaqoota/resources/views/vendor-views/auth/_package_data.blade.php ENDPATH**/ ?>