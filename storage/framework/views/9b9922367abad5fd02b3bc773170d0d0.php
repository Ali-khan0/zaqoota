<div class="">
    <div>
        <div class="text-center mb-4 pb-2">

            <?php if($store_subscription?->package_id ==  $package->id): ?>
            <h2 class="modal-title"><?php echo e(translate('Renew_Subscription_Plan')); ?></h2>
            <?php else: ?>
            <h2 class="modal-title"><?php echo e(translate('Shift to New Subscription Plan')); ?></h2>
            <?php endif; ?>

        </div>
        <div class="change-plan-wrapper align-items-center">
            <?php if($store_business_model == 'commission'  ): ?>
            <div class="__plan-item">
                <div class="inner-div">
                    <div class="text-center">
                        <h3 class="title"><?php echo e(translate('commission')); ?></h3>
                        <h2 class="price"><?php echo e($admin_commission); ?> %</h2>
                        
                    </div>
                </div>
            </div>
            <!-- Plan Seperator Arrow -->
            <div class="plan-seperator-arrow mx-auto">
                <img src="<?php echo e(asset('public/assets/admin/img/exchange.svg')); ?>" alt="" class="w-100">
            </div>
            <!-- Plan Seperator Arrow -->

            <?php elseif(!in_array($store_business_model,['commission','none'])): ?>

            <div class="__plan-item <?php echo e(!$store_subscription  || $store_subscription?->package_id ==  $package->id ?  'active' : ''); ?>">
                <div class="inner-div">
                    <div class="text-center">
                        <h3 class="title"><?php echo e($store_subscription?->package?->package_name); ?></h3>
                        <h2 class="price"><?php echo e(\App\CentralLogics\Helpers::format_currency($store_subscription?->package?->price)); ?></h2>
                        <div class="day-count"><?php echo e($store_subscription?->package?->validity); ?> <?php echo e(translate('days')); ?></div>
                    </div>
                </div>
            </div>
                <?php if( $store_subscription?->package_id !=  $package->id ): ?>
                <!-- Plan Seperator Arrow -->
                <div class="plan-seperator-arrow mx-auto">
                <img src="<?php echo e(asset('public/assets/admin/img/exchange.svg')); ?>" alt="" class="w-100">
                </div>
                <!-- Plan Seperator Arrow -->
                <?php endif; ?>
            <?php endif; ?>


            <?php if($store_subscription?->package_id !==  $package->id || $store_business_model == 'commission' ): ?>

            <div class="__plan-item active">
                <div class="inner-div">
                    <div class="text-center">
                        <h3 class="title"><?php echo e($package->package_name); ?></h3>
                        <h2 class="price"><?php echo e(\App\CentralLogics\Helpers::format_currency($package?->price)); ?></h2>
                        <div class="day-count"><?php echo e($package?->validity); ?> <?php echo e(translate('days')); ?></div>
                    </div>
                </div>
            </div>

            <?php endif; ?>
        </div>


        <div class="mb-2 mb-lg-3 subscription__plan-info-wrapper bg-ECEEF1 rounded-20">
            <div class="row g-3">
                <div class="col-md-<?php echo e($pending_bill > 0 ? '3' :'4'); ?>">
                    <div class="subscription__plan-info">
                        <div class="info">
                            <?php echo e(translate('Validity')); ?>

                        </div>
                        <h4 class="subtitle"><?php echo e($package?->validity); ?> <?php echo e(translate('days')); ?></h4>
                    </div>
                </div>
                <div class="col-md-<?php echo e($pending_bill > 0 ? '3' :'4'); ?>">
                    <div class="subscription__plan-info">
                        <div class="info">
                            <?php echo e(translate('Price')); ?>

                        </div>
                        <h4 class="subtitle"><?php echo e(\App\CentralLogics\Helpers::format_currency($package?->price)); ?></h4>
                    </div>
                </div>
                <?php if($pending_bill): ?>
                <div class="col-md-3">
                    <div class="subscription__plan-info">
                        <div class="info">
                            <?php echo e(translate('pending_bill')); ?>

                        </div>
                        <h4 class="subtitle"><?php echo e(\App\CentralLogics\Helpers::format_currency($pending_bill)); ?></h4>
                    </div>
                </div>

                <?php endif; ?>
                <div class="col-md-<?php echo e($pending_bill > 0 ? '3' :'4'); ?>">
                    <div class="subscription__plan-info">
                        <div class="info">
                            <?php echo e(translate('Bill_status')); ?>

                        </div> <h4 class="subtitle">  <?php echo e($store_business_model != 'commission' &&  $store_subscription?->package_id ==  $package->id ? translate('Renew') :  translate('Migrate_to_new_plan')); ?>  </h4> </div>
                </div>
            </div>
        </div>
        <?php if(data_get($cash_backs,'back_amount') > 0 ): ?>
        <div class="mb-2 mb-lg-3 subscription__plan-info-wrapper bg--10 rounded-20 py-2">
            <div class="row g-3">
            <div class="col-auto">
                <i class="tio-notice"></i>
                    <?php echo e(translate('You will get')); ?>  <?php echo e(\App\CentralLogics\Helpers::format_currency(data_get($cash_backs,'back_amount'))); ?> <?php echo e(translate('to_your_wallet_for_remaining')); ?>  <?php echo e(data_get($cash_backs,'days')); ?> <?php echo e(translate('messages.days_subscription_plan')); ?>

                </div>
            </div>
        </div>
        <?php endif; ?>
        <form action="<?php echo e(route('vendor.subscriptionackage.packageBuy')); ?>" method="post">
            <?php echo csrf_field(); ?>
            <?php echo method_field('POST'); ?>
                <input type="hidden" value="<?php echo e($package->id); ?>" name="package_id">
                <input type="hidden" value="<?php echo e($store_id); ?>" name="store_id">
                <input type="hidden" value="<?php echo e($store_subscription?->package_id ==  $package->id ? 'renew' : 'payment'); ?>" name="type">




        <h4 class="mb-4"><?php echo e(translate('Pay Via Online')); ?> <span class="font-regular text-body">(<?php echo e(translate('Faster & secure way to pay bill')); ?>)</span></h4>
        <div class="row g-3">
            <?php if($balance > 0): ?>

            <div class="col-md-6">
                <label class="payment-item">
                    <input type="radio" <?php echo e($balance >= $package?->price ? '' :'disabled'); ?> value="wallet"  class="d-none" name="payment_gateway">
                    <div  data-toggle="tooltip" data-placement="bottom" title="<?php echo e($balance >= $package?->price ? translate('pay_the_amount_via_wallet') : translate('You have not sufficient balance on you wallet! please add money to your wallet to purchase the packages')); ?>"  class="payment-item-inner">
                        <div class="check">
                            <img src="<?php echo e(asset('/public/assets/admin/img/check-1.png')); ?>" class="uncheck" alt="">
                            <img src="<?php echo e(asset('/public/assets/admin/img/check-2.png')); ?>" class="check" alt="">
                        </div>
                        <span><?php echo e(translate('wallet')); ?></span>
                        <span class="ml-auto" ><?php echo e(\App\CentralLogics\Helpers::format_currency($balance)); ?> </span>
                    </div>
                </label>
            </div>
            <?php endif; ?>


            <?php $__currentLoopData = $payment_methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="col-md-6">
                <label class="payment-item">
                    <input type="radio" class="d-none" value="<?php echo e($item['gateway']); ?>" name="payment_gateway">
                    <div class="payment-item-inner">
                        <div class="check">
                            <img src="<?php echo e(asset('/public/assets/admin/img/check-1.png')); ?>" class="uncheck" alt="">
                            <img src="<?php echo e(asset('/public/assets/admin/img/check-2.png')); ?>" class="check" alt="">
                        </div>
                        <span><?php echo e($item['gateway_title']); ?></span>
                        <img class="ml-auto"
                            src="<?php echo e(\App\CentralLogics\Helpers::get_full_url('payment_modules/gateway_image',$item['gateway_image'],$item['storage'] ?? 'public')); ?>"
                        width="30" alt="">
                    </div>
                </label>
            </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>
        <div class="btn--container justify-content-end mt-20">
            <button type="reset" data-dismiss="modal" class="btn btn--reset"><?php echo e(translate('Cancel')); ?></button>
            <?php if( $store_business_model != 'commission' && $store_subscription?->package_id ==  $package->id): ?>
            <button type="submit" class="btn btn--primary"><?php echo e(translate('Renew Subscription Plan')); ?></button>
            <?php else: ?>
            <button type="submit" class="btn btn--primary"><?php echo e(translate('Change_Plan')); ?></button>
            <?php endif; ?>
        </div>
    </div>
</form>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/subscription/subscriber/partials/_package_selected.blade.php ENDPATH**/ ?>