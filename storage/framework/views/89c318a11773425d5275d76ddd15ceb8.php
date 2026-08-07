<?php $__env->startSection('title',$store->name."'s ".translate('messages.Subscription')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <link href="<?php echo e(asset('public/assets/admin/css/croppie.css')); ?>" rel="stylesheet">

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <?php echo $__env->make('rental::admin.provider.details.partials._header',['store'=>$store], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php
        $vendor = $store?->module_type;
        $title = $vendor == 'rental' ? 'Provider' : 'Store';
        $orderOrTrip = $vendor == 'rental' ? 'trip' : 'order';
    ?>

    <?php if($store->store_business_model == 'commission' &&  \App\CentralLogics\Helpers::commission_check()): ?>

    <div class="card mb-3">
        <div class="card-header border-0 align-items-center">
            <h4 class="card-title align-items-center gap-2">
                <span class="card-header-icon">
                    <img width="25" src="<?php echo e(asset('public/assets/admin/img/subscription-plan/subscribed-user.png')); ?>" alt="">
                </span>
                <span><?php echo e(translate('Overview')); ?></span>
            </h4>
        </div>
        <div class="card-body pt-0">
            <div class="__bg-F8F9FC-card __plan-details">
                <div class="d-flex flex-wrap flex-md-nowrap justify-content-between __plan-details-top">
                    <div class="w-100">
                        <h2 class="name text--primary"><?php echo e(translate('Commission Base Plan')); ?></h2>
                        <h4 class="title mt-2"><span class="text-180"><?php echo e($store->comission > 0 ?  $store->comission :  $admin_commission); ?> %</span> <?php echo e(translate('messages.Commission_per_'.$orderOrTrip)); ?></h4>
                        <div class="info-text ">
                            <?php echo e(translate($title . ' will pay')); ?> <?php echo e($store->comission > 0 ?  $store->comission :  $admin_commission); ?>% <?php echo e(translate('commission to')); ?> <strong><?php echo e($business_name); ?></strong> <?php echo e(translate('from each '.$orderOrTrip.'. You will get access of all the features and options  in '.$title.' panel , app and interaction with user.')); ?>

                        </div>
                                <div class="mt-3">
                                    <form action="<?php echo e(route('admin.store.update-settings',[$store['id'] , 'tab' => 'business_plan'])); ?>" method="post">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field("post"); ?>
                                        <div class="row">
                                            <div class="col-xl-6 col-xxl-5">
                                                <div>
                                                    <label class="d-flex mb-1 justify-content-between switch toggle-switch-sm text-dark text-capitalize" for="comission_status">
                                                        <span><?php echo e(translate('messages.Change_Commission_Rate')); ?>(%) <span class="input-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('When_enabled,_admin_will_only_receive_the_certain_commission_percentage_he_set_for_this_store._Otherwise,_the_system_default_commission_will_be_applied.')); ?>"><img src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>" alt="<?php echo e(translate('When_enabled,_admin_will_only_receive_the_certain_commission_percentage_he_set_for_this_store._Otherwise,_the_system_default_commission_will_be_applied.')); ?>"></span></span>
                                                        <input type="checkbox" class="toggle-switch-input" name="comission_status" id="comission_status" value="1" <?php echo e(isset($store->comission)?'checked':''); ?>>
                                                        <span class="toggle-switch-label">
                                                            <span class="toggle-switch-indicator"></span>
                                                        </span>
                                                    </label>
                                                    <div class="d-flex flex-wrap gap-3">
                                                        <input type="number" id="comission" min="0" max="10000" step="0.01" name="comission" class="form-control w-200px flex-grow-1 bg-white" required value="<?php echo e($store->comission??'0'); ?>" <?php echo e(isset($store->comission)?'':'readonly'); ?>>
                                                        <button type="submit" class="btn btn--primary h--45px"><?php echo e(translate('Change')); ?></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                    </div>
                </div>

            </div>
            <?php if(\App\CentralLogics\Helpers::subscription_check() ): ?>
                <div class="btn--container justify-content-end mt-20">
                    <button type="button" data-toggle="modal" data-target="#plan-modal" class="btn btn--primary"><?php echo e(translate('Change Business Plan')); ?></button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php elseif(in_array($store->store_business_model,[ 'subscription' ,'unsubscribed']) && $store?->store_sub_update_application): ?>

                <div class="card mb-20">
                    <div class="card-header border-0 align-items-center">
                        <h4 class="card-title align-items-center gap-2">
                            <span class="card-header-icon">
                                <img src="<?php echo e(asset('public/assets/admin/img/billing.png')); ?>" alt="">
                            </span>
                            <span class="text-title"><?php echo e(translate('Billing')); ?></span>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-sm-6 col-lg-4">
                                <a class="__card-2 __bg-1 flex-row align-items-center gap-4" href="#">
                                    <img src="<?php echo e(asset('public/assets/admin/img/expiring.png')); ?>" alt="report/new" class="w-60px">
                                    <div class="w-0 flex-grow-1 py-md-3">
                                        <span class="text-body"><?php echo e(translate('Expire Date')); ?></span>
                                        <h4 class="title m-0"><?php echo e(\App\CentralLogics\Helpers::date_format($store?->store_sub_update_application?->expiry_date_parsed)); ?></h4>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <a class="__card-2 __bg-8 flex-row align-items-center gap-4" href="#">
                                    <img src="<?php echo e(asset('public/assets/admin/img/total-bill.png')); ?>" alt="report/new" class="w-60px">
                                    <div class="w-0 flex-grow-1 py-md-3">
                                        <span class="text-body"><?php echo e(translate('Total_Bill')); ?></span>
                                        <h4 class="title m-0"><?php echo e(\App\CentralLogics\Helpers::format_currency($store?->store_sub_update_application?->package?->price * ($store?->store_sub_update_application?->total_package_renewed + 1) )); ?></h4>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 col-lg-4">
                                <a class="__card-2 __bg-4 flex-row align-items-center gap-4" href="#">
                                    <img src="<?php echo e(asset('public/assets/admin/img/number.png')); ?>" alt="report/new" class="w-60px">
                                    <div class="w-0 flex-grow-1 py-md-3">
                                        <span class="text-body"><?php echo e(translate('Number of Uses')); ?></span>
                                        <h4 class="title m-0"><?php echo e($store?->store_sub_update_application?->total_package_renewed + 1); ?></h4>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header border-0 align-items-center">
                        <h4 class="card-title align-items-center gap-2">
                            <span class="card-header-icon">
                                <img width="25" src="<?php echo e(asset('public/assets/admin/img/subscription-plan/subscribed-user.png')); ?>" alt="">
                            </span>
                            <span><?php echo e(translate('Package Overview')); ?>


                                <?php if($store?->status == 0 &&  $store?->vendor?->status == 0): ?>
                                <span class=" badge badge-pill badge-info">  &nbsp; <?php echo e(translate('Approval_Pending')); ?>  &nbsp; </span>
                                <?php elseif($store?->store_sub_update_application?->status == 0): ?>
                                <span class=" badge badge-pill badge-danger">  &nbsp; <?php echo e(translate('Expired')); ?>  &nbsp; </span>
                                <?php elseif($store?->store_sub_update_application?->is_canceled == 1): ?>
                                <span class=" badge badge-pill badge-warning">  &nbsp; <?php echo e(translate('canceled')); ?>  &nbsp; </span>
                                <?php elseif($store?->store_sub_update_application?->status == 1): ?>
                                <span class=" badge badge-pill badge-success">  &nbsp; <?php echo e(translate('Active')); ?>  &nbsp; </span>
                                <?php endif; ?>

                            </span>
                        </h4>
                    </div>
                    <div class="card-body pt-0">
                        <div class="__bg-F8F9FC-card __plan-details">
                            <div class="d-flex flex-wrap flex-md-nowrap justify-content-between __plan-details-top">
                                <div class="left">
                                    <h3 class="name"><?php echo e($store?->store_sub_update_application?->package?->package_name); ?></h3>
                                    <div class="font-medium text--title"><?php echo e($store?->store_sub_update_application?->package?->text); ?></div>
                                </div>
                                <h3 class="right"><?php echo e(\App\CentralLogics\Helpers::format_currency($store?->store_sub_update_application?->last_transcations?->price)); ?> /<small class="font-medium text--title"><?php echo e($store?->store_sub_update_application?->last_transcations?->validity); ?> <?php echo e(translate('messages.Days')); ?></small></h3>
                            </div>


                            <div class="check--grid-wrapper mt-3 max-w-850px">


                                <div>
                                    <div class="d-flex align-items-center gap-2">
                                        <?php if( $store?->store_sub_update_application?->mobile_app == 1 ): ?>
                                        <img src="<?php echo e(asset('/public/assets/admin/img/subscription-plan/check.png')); ?>" alt="">
                                        <?php else: ?>
                                        <img src="<?php echo e(asset('/public/assets/admin/img/subscription-plan/check-1.png')); ?>" alt="">
                                        <?php endif; ?>
                                        <span class="form-check-label text-dark"><?php echo e(translate('messages.Mobile_App')); ?></span>
                                    </div>
                                </div>


                                <div>
                                    <div class="d-flex align-items-center gap-2">
                                        <?php if( $store?->store_sub_update_application?->review == 1 ): ?>
                                        <img src="<?php echo e(asset('/public/assets/admin/img/subscription-plan/check.png')); ?>" alt="">
                                        <?php else: ?>
                                        <img src="<?php echo e(asset('/public/assets/admin/img/subscription-plan/check-1.png')); ?>" alt="">
                                        <?php endif; ?>
                                        <span class="form-check-label text-dark"><?php echo e(translate('messages.review')); ?></span>
                                    </div>
                                </div>

                                <div>
                                    <div class="d-flex align-items-center gap-2">
                                        <?php if( $store?->store_sub_update_application?->chat == 1 ): ?>
                                        <img src="<?php echo e(asset('/public/assets/admin/img/subscription-plan/check.png')); ?>" alt="">
                                        <?php else: ?>
                                        <img src="<?php echo e(asset('/public/assets/admin/img/subscription-plan/check-1.png')); ?>" alt="">
                                        <?php endif; ?>
                                        <span class="form-check-label text-dark"><?php echo e(translate('messages.chat')); ?></span>
                                    </div>
                                </div>

                                <div>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="<?php echo e(asset('/public/assets/admin/img/subscription-plan/check.png')); ?>" alt="">
                                        <?php if( $store?->store_sub_update_application?->max_order == 'unlimited' ): ?>
                                        <span class="form-check-label text-dark"><?php echo e(translate('messages.unlimited_trips')); ?></span>
                                        <?php else: ?>
                                        <span class="form-check-label text-dark"> <?php echo e($store?->store_sub_update_application?->package?->max_order); ?> <?php echo e(translate('messages.Trips')); ?> <small>(<?php echo e($store?->store_sub_update_application?->max_order); ?> <?php echo e(translate('left')); ?>) </small> </span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="<?php echo e(asset('/public/assets/admin/img/subscription-plan/check.png')); ?>" alt="">
                                        <?php if( $store?->store_sub_update_application?->max_product == 'unlimited' ): ?>
                                        <span class="form-check-label text-dark"><?php echo e(translate('messages.unlimited_vehicle_Upload')); ?></span>
                                        <?php else: ?>
                                        <span class="form-check-label text-dark"> <?php echo e($store?->store_sub_update_application?->max_product); ?> <?php echo e(translate('messages.vehicle_Upload')); ?> <small>(<?php echo e($store?->store_sub_update_application?->max_product  - $store->vehicles_count > 0 ? $store?->store_sub_update_application?->max_product  - $store->vehicles_count : 0); ?> <?php echo e(translate('left')); ?>) </small></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn--container justify-content-end mt-20">
                            <?php if( $store?->store_sub_update_application?->is_canceled == 0 && $store?->store_sub_update_application?->status == 1  ): ?>
                            <button type="button"  data-url="<?php echo e(route('admin.business-settings.subscriptionackage.cancelSubscription',$store?->id)); ?>" data-message="<?php echo e(translate('If_you_cancel_the_subscription,_after_')); ?> <?php echo e(Carbon\Carbon::now()->diffInDays($store?->store_sub_update_application?->expiry_date_parsed->format('Y-m-d'), false)); ?> <?php echo e(translate('days_the_vendor_will_no_longer_be_able_to_run_the_business_before_subscribe_a_new_plan.')); ?>"
                                class="btn btn--danger text-white status_change_alert"><?php echo e(translate('Cancel Subscription')); ?></button>
                            <?php endif; ?>
                            <button type="button" data-toggle="modal" data-target="#plan-modal" class="btn btn--primary"><?php echo e(translate('Change / Renew Subscription Plan')); ?></button>
                        </div>
                    </div>
                </div>

        <?php else: ?>


        <div class="card">
            <div class="card-body text-center py-5">
                <div class="max-w-542 mx-auto py-sm-5 py-4">
                    <img class="mb-4" src="<?php echo e(asset('/public/assets/admin/img/empty-subscription.svg')); ?>" alt="img">
                    <h4 class="mb-3"><?php echo e(translate('Chose Subscription Plan')); ?></h4>
                    <p class="mb-4">
                        <?php echo e(translate('Chose a subscription packages from the list. So that Stores get more options to join the business for the growth and success.')); ?><br>
                    </p>
                    <button type="button" data-toggle="modal" data-target="#plan-modal" class="btn btn--primary"><?php echo e(translate('Chose Subscription Plan')); ?></button>
                </div>
            </div>
        </div>
    <?php endif; ?>



    <div class="modal fade show" id="plan-modal">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header px-3 pt-3">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" class="tio-clear"></span>
                    </button>
                </div>
                <div class="modal-body px-4 pt-0">
                    <div>
                        <div class="text-center">
                            <h2 class="modal-title"><?php echo e(translate('Change Plan')); ?></h2>
                        </div>
                        <div class="text-center text-14 mb-4 pb-3">
                           <?php echo e(translate('Renew or shift your plan to get better experience!')); ?>

                        </div>
                        <div class="plan-slider owl-theme owl-carousel owl-refresh">
                            
                            <?php if(\App\CentralLogics\Helpers::commission_check()): ?>
                            <div class="__plan-item hover <?php echo e($store->store_business_model == 'commission'  ? 'active' : ''); ?> ">
                                <div class="inner-div">
                                    <div class="text-center">
                                        <h3 class="title"><?php echo e(translate('Commission Base')); ?></h3>
                                        <h2 class="price"><?php echo e($store->comission > 0 ?  $store->comission :  $admin_commission); ?>%</h2>
                                    </div>
                                    <div class="py-5 mt-4">
                                        <div class="info-text text-center">
                                            <?php echo e(translate($title.' will pay')); ?> <?php echo e($store->comission > 0 ?  $store->comission :  $admin_commission); ?>% <?php echo e(translate('commission to')); ?> <?php echo e($business_name); ?> <?php echo e(translate('from each '.$orderOrTrip.'. You will get access of all the features and options  in '.$title.' panel , app and interaction with user.')); ?>

                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <?php if($store->store_business_model == 'commission'): ?>
                                        <button type="button" class="btn btn--secondary"><?php echo e(translate('Current_Plan')); ?></button>
                                        <?php else: ?>
                                        <?php
                                        $cash_backs= \App\CentralLogics\Helpers::calculateSubscriptionRefundAmount(store:$store ,return_data:true);
                                        ?>

                                        <button type="button" data-url="<?php echo e(route('admin.business-settings.subscriptionackage.switchToCommission',$store->id)); ?>" data-message="<?php echo e(translate('You_Want_To_Migrate_To_Commission.')); ?> <?php echo e(data_get($cash_backs,'back_amount') > 0  ?  translate('You will get').' '. \App\CentralLogics\Helpers::format_currency(data_get($cash_backs,'back_amount')) .' '.translate('to_your_wallet_for_remaining') .' '.data_get($cash_backs,'days').' '.translate('messages.days_subscription_plan') : ''); ?>"  class="btn btn--primary shift_to_commission"><?php echo e(translate('Shift in this plan')); ?></button>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php $__empty_1 = true; $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                            <div class="__plan-item hover <?php echo e($store?->store_sub_update_application?->package_id == $package->id  && $store->store_business_model != 'commission'  ? 'active' : ''); ?>">
                                <div class="inner-div">
                                    <div class="text-center">
                                        <h3 class="title"><?php echo e($package->package_name); ?></h3>
                                        <h2 class="price"><?php echo e(\App\CentralLogics\Helpers::format_currency($package->price)); ?></h2>
                                        <div class="day-count"><?php echo e($package->validity); ?> <?php echo e(translate('messages.days')); ?></div>
                                    </div>
                                    <ul class="info">


                                        <?php if($package->mobile_app): ?>
                                        <li>
                                            <i class="tio-checkmark-circle"></i> <span>  <?php echo e(translate('messages.mobile_app')); ?> </span>
                                        </li>
                                        <?php endif; ?>
                                        <?php if($package->chat): ?>
                                        <li>
                                            <i class="tio-checkmark-circle"></i> <span>  <?php echo e(translate('messages.chatting_options')); ?> </span>
                                        </li>
                                        <?php endif; ?>
                                        <?php if($package->review): ?>
                                        <li>
                                            <i class="tio-checkmark-circle"></i> <span>  <?php echo e(translate('messages.review_section')); ?> </span>
                                        </li>
                                        <?php endif; ?>

                                        <?php if($package->max_order == 'unlimited'): ?>
                                        <li>
                                            <i class="tio-checkmark-circle"></i> <span>  <?php echo e(translate('messages.Unlimited_Trips')); ?> </span>
                                        </li>
                                        <?php else: ?>
                                        <li>
                                            <i class="tio-checkmark-circle"></i> <span>  <?php echo e($package->max_order); ?> <?php echo e(translate('messages.Trips')); ?> </span>
                                        </li>
                                        <?php endif; ?>
                                        <?php if($package->max_product == 'unlimited'): ?>
                                        <li>
                                            <i class="tio-checkmark-circle"></i> <span>  <?php echo e(translate('messages.Unlimited_uploads')); ?> </span>
                                        </li>
                                        <?php else: ?>
                                        <li>
                                            <i class="tio-checkmark-circle"></i> <span>  <?php echo e($package->max_product); ?> <?php echo e(translate('messages.uploads')); ?> </span>
                                        </li>
                                        <?php endif; ?>

                                    </ul>
                                    <div class="text-center">
                                        

                                        <?php if( $store?->store_business_model != 'commission'  && $store?->store_sub_update_application?->package_id == $package->id): ?>
                                        <button data-id="<?php echo e($package->id); ?>"  data-url="<?php echo e(route('admin.business-settings.subscriptionackage.packageView',[$package->id,$store->id ])); ?>"
                                            data-target="#package_detail" id="package_detail" type="button" class="btn btn--warning text-white renew-btn package_detail"><?php echo e(translate('messages.Renew')); ?></button>
                                        <?php else: ?>
                                        <button data-id="<?php echo e($package->id); ?>" data-url="<?php echo e(route('admin.business-settings.subscriptionackage.packageView',[$package->id,$store->id ])); ?>"
                                            data-target="#package_detail" id="package_detail" type="button" class="btn btn--primary shift-btn package_detail"><?php echo e(translate('messages.Shift_in_this_plan')); ?></button>
                                        <?php endif; ?>


                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                            <?php endif; ?>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- subscription Plan Modal 2 -->
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

    <div class="modal fade" id="product_warning">
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
                                <img src="<?php echo e(asset('/public/assets/admin/img/subscription-plan/package-status-disable.png')); ?>" class="mb-20">
                                <h5 class="modal-title" ></h5>
                            </div>
                            <div class="text-center">
                                <h3><?php echo e(translate('Are_You_Sure_You_want_To_switch_to_this_plan?')); ?></h3>
                                <p><?php echo e(translate('You_are_about_to_downgrade_your_plan.After_subscribing_to_this_plan_your_oldest_')); ?> <span id="disable_item_count"></span> <?php echo e(translate('Items_will_be_inactivated.')); ?> </p>
                            </div>
                        </div>
                        <div class="btn--container justify-content-center">
                            <button  id="continue_btn" class="btn btn-outline-primary min-w-120" data-dismiss="modal" >
                                <?php echo e(translate("Continue")); ?>

                            </button>
                            <button  class="btn btn--primary min-w-120  shift_package"  id="back_to_planes" data-dismiss="modal" ><?php echo e(translate('Go_Back')); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="index" data-index="<?php echo e($index); ?>"></div>
    <div id="title" data-title="<?php echo e(translate('Are_you_sure?')); ?>"></div>
    <div id="buttonCancel" data-no="<?php echo e(translate('no')); ?>"></div>
    <div id="buttonApprove" data-yes="<?php echo e(translate('yes')); ?>"></div>
    <div id="storeId" data-id="<?php echo e($store->id); ?>"></div>
    <div id="storeSubId" data-sub-id="<?php echo e($store?->store_sub_update_application?->id); ?>"></div>
    <div id="successfully" data-successfully="<?php echo e(translate('Successfully_canceled_the_subscription')); ?>"></div>
    <div id="switched" data-switched="<?php echo e(translate('Successfully_Switched_To_Commission')); ?>"></div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('Modules/Rental/public/assets/js/admin/view-pages/provider-subscription.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/provider/details/subscription.blade.php ENDPATH**/ ?>