<?php $__env->startSection('title', translate('messages.update Provider')); ?>



<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header pb-20">
            <div class="d-flex justify-content-between flex-wrap gap-3">
                <div>
                    <h1 class="page-header-title text-break">
                        <span class="page-header-icon">
                            <img src="<?php echo e(asset('public/assets/admin/img/store.png')); ?>" class="w--22" alt="">
                        </span>
                        <span><?php echo e($store->name); ?>

                    </h1></span>
                    </h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <form action="" method="post" enctype="multipart/form-data" id="providerFormSubmit">
            <?php echo csrf_field(); ?>
            <div id="businessPlan">
                <div class="custom-timeline d-flex flex-wrap gap-40px text-title mb-2">
                    <h4 class="single text-primary checked"><span class="count-checked">1</span><?php echo e(translate('messages.Business Basic Setup')); ?></h4>
                    <h4 class="single font-semibold"><span class="count btn-primary">2</span><?php echo e(translate('messages.Business Plan Setup')); ?></h4>
                </div>
                <div class="row g-2">
                    <div class="col-lg-12">
                        <div class="card mt-3">
                            <div class="card-header">
                                <div>
                                    <h5 class="text-title mb-1">
                                        <?php echo e(translate('messages.Update Business Plan')); ?>

                                    </h5>

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-lg-6">
                                        <label class="business-plan-card-wrapper">
                                            <input type="radio" name="business_plan" class="business-plan-radio" value="commission-base" <?php echo e($store->store_business_model == 'commission' ? 'checked' : ''); ?>/>
                                            <div class="business-plan-card">
                                                <h4 class="fs-16 title text-title mb-10px opacity-70">
                                                    <?php echo e(translate('messages.Commission Base')); ?>

                                                </h4>
                                                <p class="fs-14 text-title opacity-70 mb-0">
                                                    <?php echo e(translate('messages.You have to give a certain percentage of commission to admin for every Trip request.')); ?>

                                                </p>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="business-plan-card-wrapper">
                                            <input type="radio" name="business_plan" class="business-plan-radio" value="subscription-base" <?php echo e($store->store_business_model == 'subscription' ? 'checked' : ''); ?>/>
                                            <div class="business-plan-card">
                                                <h4 class="fs-16 title text-title mb-10px opacity-70">
                                                    <?php echo e(translate('messages.Subscription Base')); ?>

                                                </h4>
                                                <p class="fs-14 text-title opacity-70 mb-0">
                                                    <?php echo e(translate('messages.You have to pay certain amount in every month/year to admin as subscription fee.')); ?>

                                                </p>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="col-lg-12 mt-20 d-none" id="subscription-plan">
                                        <div>
                                            <div class="text-center mb-20">
                                                <h3 class="modal-title fs-16 opacity-lg font-bold">
                                                    <?php echo e(translate('Choose Subscription Package')); ?></h3>
                                            </div>
                                            <div class="plan-slider owl-theme owl-carousel owl-refresh">
                                                <?php $__empty_1 = true; $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <label class="__plan-item d-block hover <?php echo e($package->id == $store->store_sub?->package_id ? 'active' : ''); ?>">
                                                        <input type="radio" name="package_id" id="package_id"
                                                               value="<?php echo e($package->id); ?>" class="d-none">
                                                        <div class="inner-div">
                                                            <div class="text-center">
                                                                <h3 class="title"><?php echo e($package->package_name); ?></h3>
                                                                <h2 class="price"><?php echo e(\App\CentralLogics\Helpers::format_currency($package->price)); ?></h2>
                                                                <div class="day-count"><?php echo e($package->validity); ?>

                                                                    <?php echo e(translate('messages.days')); ?></div>
                                                            </div>
                                                            <ul class="info">
                                                                <?php if($package->pos): ?>
                                                                    <li>
                                                                        <i class="tio-checkmark-circle"></i>
                                                                        <span><?php echo e(translate('messages.POS')); ?></span>
                                                                    </li>
                                                                <?php endif; ?>
                                                                <?php if($package->mobile_app): ?>
                                                                    <li>
                                                                        <i class="tio-checkmark-circle"></i>
                                                                        <span><?php echo e(translate('messages.mobile_app')); ?></span>
                                                                    </li>
                                                                <?php endif; ?>
                                                                <?php if($package->chat): ?>
                                                                    <li>
                                                                        <i class="tio-checkmark-circle"></i>
                                                                        <span><?php echo e(translate('messages.chatting_options')); ?></span>
                                                                    </li>
                                                                <?php endif; ?>
                                                                <?php if($package->review): ?>
                                                                    <li>
                                                                        <i class="tio-checkmark-circle"></i>
                                                                        <span><?php echo e(translate('messages.review_section')); ?></span>
                                                                    </li>
                                                                <?php endif; ?>
                                                                <?php if($package->self_delivery): ?>
                                                                    <li>
                                                                        <i class="tio-checkmark-circle"></i>
                                                                        <span><?php echo e(translate('messages.self_delivery')); ?></span>
                                                                    </li>
                                                                <?php endif; ?>
                                                                <?php if($package->max_order == 'unlimited'): ?>
                                                                    <li>
                                                                        <i class="tio-checkmark-circle"></i>
                                                                        <span><?php echo e(translate('messages.Unlimited_Orders')); ?></span>
                                                                    </li>
                                                                <?php else: ?>
                                                                    <li>
                                                                        <i class="tio-checkmark-circle"></i>
                                                                        <span><?php echo e($package->max_order); ?> <?php echo e(translate('messages.Orders')); ?> </span>
                                                                    </li>
                                                                <?php endif; ?>
                                                                <?php if($package->max_product == 'unlimited'): ?>
                                                                    <li>
                                                                        <i class="tio-checkmark-circle"></i>
                                                                        <span><?php echo e(translate('messages.Unlimited_uploads')); ?></span>
                                                                    </li>
                                                                <?php else: ?>
                                                                    <li>
                                                                        <i class="tio-checkmark-circle"></i>
                                                                        <span><?php echo e($package->max_product); ?> <?php echo e(translate('messages.uploads')); ?></span>
                                                                    </li>
                                                                <?php endif; ?>
                                                            </ul>
                                                        </div>
                                                    </label>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <div class="text-center">
                                                        <?php echo e(translate('No Package Found')); ?>

                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="btn--container justify-content-end mt-20">
                            <a href="<?php echo e(route('admin.rental.provider.edit-basic-setup', $store->id )); ?>" class="btn btn--reset min-w-100px justify-content-center"><?php echo e(translate('messages.back')); ?></a>
                            <div id="subscriptionBtn">
                                <button data-id="<?php echo e($store->store_business_model == 'commission' ? 0 : $store?->package?->id); ?>"
                                    data-target="#package_detail" id="package_detail" type="button" class="btn btn--primary shift-btn package_detail"><?php echo e(translate('messages.update')); ?></button>
                            </div>
                            <?php
                                $cash_backs= \App\CentralLogics\Helpers::calculateSubscriptionRefundAmount(store:$store ,return_data:true);
                            ?>
                            <div id="commissionBtn">
                                <button type="button" data-url="<?php echo e(route('admin.business-settings.subscriptionackage.switchToCommission',$store->id)); ?>" data-message="<?php echo e(translate('You_Want_To_Migrate_To_Commission.')); ?> <?php echo e(data_get($cash_backs,'back_amount') > 0  ?  translate('You will get').' '. \App\CentralLogics\Helpers::format_currency(data_get($cash_backs,'back_amount')) .' '.translate('to_your_wallet_for_remaining') .' '.data_get($cash_backs,'days').' '.translate('messages.days_subscription_plan') : ''); ?>"  class="btn btn--primary shift_to_commission"><?php echo e(translate('Update')); ?></button>
                            </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade __modal" id="subscription-renew-modal">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body px-4 pt-0">
                    <div class="data_package" id="data_package">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="d-none" id="data-set"
        data-store-business-model="<?php echo e($store->store_business_model); ?>"
        data-rental-provider-url="<?php echo e(route('admin.rental.provider.list')); ?>"

        data-store-id="<?php echo e($store->id); ?>"
        data-translate-are-you-sure="<?php echo e(translate('Are_you_sure?')); ?>"
        data-translate-no="<?php echo e(translate('no')); ?>"
        data-translate-yes="<?php echo e(translate('yes')); ?>"
        data-translate-success="<?php echo e(translate('Successfully_Switched_To_Commission')); ?>"
        data-select-subscription-package="<?php echo e(translate('Please select a subscription package.')); ?>"

        data-subscription-package-view-url="<?php echo e(route('admin.business-settings.subscriptionackage.packageView', ['PLACEHOLDER_ID', $store->id])); ?>"
    ></div>


<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin/js/spartan-multi-image-picker.js')); ?>"></script>
    <script src="<?php echo e(asset('Modules/Rental/public/assets/js/admin/view-pages/provider-business-plan-edit.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/provider/edit-business-setup.blade.php ENDPATH**/ ?>