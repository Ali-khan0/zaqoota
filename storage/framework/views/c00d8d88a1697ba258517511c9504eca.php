<?php $__env->startSection('title', translate('messages.customer_settings')); ?>

<?php $__env->startPush('css_or_js'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title mr-3">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/business.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('business_setup')); ?>

                </span>
            </h1>

            <?php echo $__env->make('admin-views.business-settings.partials.nav-menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        </div>
        <!-- Page Header -->





        <form action="<?php echo e(route('admin.customer.update-settings')); ?>" method="post" enctype="multipart/form-data"
            id="update-settings">
            <?php echo csrf_field(); ?>

            <div class="row g-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-shadow">
                            <h5 class="card-title d-flex align-items-center">
                                <img src="<?php echo e(asset('/public/assets/admin/img/ic_round-campaign.png')); ?>" alt=""
                                    class="card-header-icon align-self-center mr-1">
                                <span>
                                    <?php echo e(translate('Customer_Setup')); ?>

                                </span>
                                <span class="input-label-secondary" data-toggle="tooltip" data-placement="right"
                                    data-original-title="<?php echo e(translate('messages.Here,_customers_can_store_their_refunded_order_amount,_referral_earnings,_and_loyalty_points.')); ?>"><img
                                        src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>"
                                        alt="<?php echo e(translate('messages.show_hide_food_menu')); ?>"></span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="py-2">
                                <div class="row g-3 align-items-end">
































                                    <div class="col-sm-6 col-lg-4">
                                        <div class="form-group mb-0">
                                            <label
                                                class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control">
                                                <span
                                                    class="pr-2"><?php echo e(translate('Customer_Wallet')); ?>

                                                    <span class="input-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="<?php echo e(translate('messages.With_this_feature,_customers_can_have_virtual_wallets_in_their_account_via_Customer_App_&_Website._They_can_also_earn_(via_referral,_refund,_loyalty_points,_or_cashback)_and_buy_with_the_wallet’s_amount.')); ?>">
                                                        <img src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>"
                                                            alt="<?php echo e(translate('messages.show_hide_food_menu')); ?>">
                                                    </span>
                                                </span>
                                                <input type="checkbox" data-id="wallet_status" data-type="toggle"
                                                    data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/wallet-on.png')); ?>"
                                                    data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/wallet-off.png')); ?>"
                                                    data-title-on="<?php echo e(translate('messages.Want_to_enable')); ?> <strong><?php echo e(translate('the_Wallet_feature?')); ?></strong>"
                                                    data-title-off="<?php echo e(translate('messages.Want_to_disable')); ?> <strong><?php echo e(translate('the_Wallet_feature?')); ?></strong>"
                                                    data-text-on="<p><?php echo e(translate('messages.If_you_enable_this,_Customers_can_see_&_use_the_Wallet_option_from_their_profile_in_the_Customer_App_&_Website.')); ?></p>"
                                                    data-text-off="<p><?php echo e(translate('messages.If_you_disable_this,_the_Wallet_feature_will_be_hidden_from_the_Customer_App_&_Website.')); ?></p>"
                                                    class="status toggle-switch-input dynamic-checkbox-toggle"
                                                    name="customer_wallet" id="wallet_status" value="1"
                                                    <?php echo e(isset($data['wallet_status']) && $data['wallet_status'] == 1 ? 'checked' : ''); ?>>
                                                <span class="toggle-switch-label text">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-4">
                                        <div class="form-group mb-0">
                                            <label
                                                class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control <?php echo e(isset($data['wallet_status']) && $data['wallet_status'] == 1 ? '' : 'text-muted'); ?>">
                                                <span
                                                    class="pr-2"><?php echo e(translate('Customer Can Earn & Buy From Referral')); ?></span>
                                                <input <?php echo e(isset($data['wallet_status']) && $data['wallet_status'] == 1 ? '' : 'disabled'); ?>

                                                 type="checkbox" data-id="ref_earning_status" data-type="toggle"
                                                    data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/referral-on.png')); ?>"
                                                    data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/referral-off.png')); ?>"
                                                    data-title-on="<?php echo e(translate('messages.Want_to_enable')); ?> <strong><?php echo e(translate('messages.Referral_Earning?')); ?></strong>"
                                                    data-title-off="<?php echo e(translate('messages.Want_to_disable')); ?> <strong><?php echo e(translate('messages.Referral_Earning?')); ?></strong>"
                                                    data-text-on="<p><?php echo e(translate('messages.If_you_enable_this,_Customers_can_earn_points_by_referring_others_to_sign_up_&_purchase_from_your_business.')); ?></p>"
                                                    data-text-off="<p><?php echo e(translate('messages.If_you_disable_this,_the_referral-earning_feature_will_be_hidden_from_the_Customer_App_&_Website.')); ?></p>"
                                                    class="status toggle-switch-input dynamic-checkbox-toggle "
                                                    name="ref_earning_status" id="ref_earning_status"
                                                    data-section="referrer-earning" value="1"
                                                    <?php echo e(isset($data['ref_earning_status']) && $data['ref_earning_status'] == 1 ? 'checked' : ''); ?>>
                                                <span class="toggle-switch-label text">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-4">
                                        <div class="form-group mb-0">
                                            <label
                                                class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control <?php echo e(isset($data['wallet_status']) && $data['wallet_status'] == 1 ? '' : 'text-muted'); ?>">
                                                <span class="pr-2"><?php echo e(translate('messages.refund_to_wallet')); ?><span
                                                        class="input-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="<?php echo e(translate('messages.If_it’s_enabled,_Customers_will_automatically_receive_the_refunded_amount_in_their_wallets._But_if_it’s_disabled,_the_Admin_will_handle_the_Refund_Request_in_his_convenient_transaction_channel.')); ?>"><img
                                                            src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>"
                                                            alt="<?php echo e(translate('messages.show_hide_food_menu')); ?>"></span></span>
                                                <input type="checkbox"
                                                <?php echo e(isset($data['wallet_status']) && $data['wallet_status'] == 1 ? '' : 'disabled'); ?>

                                                data-id="refund_to_wallet" data-type="toggle"
                                                    data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/refund-on.png')); ?>"
                                                    data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/refund-off.png')); ?>"
                                                    data-title-on="<?php echo e(translate('messages.Want_to_enable')); ?> <strong><?php echo e(translate('messages.Refund_to_Wallet_feature?')); ?></strong>"
                                                    data-title-off="<?php echo e(translate('messages.Want_to_disable')); ?> <strong><?php echo e(translate('messages.Refund_to_Wallet_feature?')); ?></strong>"
                                                    data-text-on="<p><?php echo e(translate('messages.If_you_enable_this,_Customers_will_automatically_receive_the_refunded_amount_in_their_wallets.')); ?></p>"
                                                    data-text-off="<p><?php echo e(translate('messages.If_you_disable_this,_the_Admin_will_handle_the_Refund_Request_in_his_convenient_transaction_channel.')); ?></p>"
                                                    class="status toggle-switch-input dynamic-checkbox-toggle "
                                                    name="refund_to_wallet" id="refund_to_wallet" value="1"
                                                    <?php echo e(isset($data['wallet_add_refund']) && $data['wallet_add_refund'] == 1 ? 'checked' : ''); ?>>
                                                <span class="toggle-switch-label text">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>



                                    <div class="col-sm-6 col-lg-4">
                                        <div class="form-group mb-0">
                                            <label
                                                class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control <?php echo e(isset($data['wallet_status']) && $data['wallet_status'] == 1 ? '' : 'text-muted'); ?>">
                                                <span class="pr-2"><?php echo e(translate('customer_can_add_fund_to_wallet')); ?>

                                                    <span class="input-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="<?php echo e(translate('messages.With_this_feature,_customers_can_add_fund_to_wallet_if_the_payment_module_is_available.')); ?>">
                                                        <img src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>"
                                                            alt="<?php echo e(translate('messages.add_fund_status')); ?>">
                                                    </span>
                                                </span>
                                                <input <?php echo e(isset($data['wallet_status']) && $data['wallet_status'] == 1 ? '' : 'disabled'); ?>

                                                type="checkbox" data-id="add_fund_status" data-type="toggle"
                                                    data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/wallet-on.png')); ?>"
                                                    data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/wallet-off.png')); ?>"
                                                    data-title-on="<?php echo e(translate('messages.Want_to_enable')); ?> <strong><?php echo e(translate('add_fund_to_Wallet_feature?')); ?></strong>"
                                                    data-title-off="<?php echo e(translate('messages.Want_to_disable')); ?> <strong><?php echo e(translate('add_fund_to_Wallet_feature?')); ?></strong>"
                                                    data-text-on="<p><?php echo e(translate('messages.If_you_enable_this,_Customers_can_add_fund_to_wallet_using_payment_module')); ?></p>"
                                                    data-text-off="<p><?php echo e(translate('messages.If_you_disable_this,_add_fund_to_wallet_will_be_hidden_from_the_Customer_App_&_Website.')); ?></p>"
                                                    class="status toggle-switch-input dynamic-checkbox-toggle "
                                                    name="add_fund_status" id="add_fund_status" value="1"
                                                    <?php echo e(isset($data['add_fund_status']) && $data['add_fund_status'] == 1 ? 'checked' : ''); ?>>
                                                <span class="toggle-switch-label text">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-4">
                                        <div class="form-group mb-0">
                                            <label
                                                class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control"
                                                for="customer_loyalty_point">
                                                <span
                                                    class="pr-2"><?php echo e(translate('Customer Can Earn Loyalty Point')); ?></span>
                                                <input type="checkbox" data-id="customer_loyalty_point"
                                                    data-type="toggle"
                                                    data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/loyalty-on.png')); ?>"
                                                    data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/loyalty-off.png')); ?>"
                                                    data-title-on="<?php echo e(translate('messages.Want_to_enable')); ?> <strong><?php echo e(translate('Loyalty Point')); ?></strong>"
                                                    data-title-off="<?php echo e(translate('messages.Want_to_disable')); ?> <strong><?php echo e(translate('Loyalty Point')); ?></strong>"
                                                    data-text-on="<p><?php echo e(translate('Customer will see loyalty point option in his profile settings & can earn & convert this point to wallet money')); ?></p>"
                                                    data-text-off="<p><?php echo e(translate('Customer will not see loyalty point option from his profile settings')); ?></p>"
                                                    class="status toggle-switch-input dynamic-checkbox-toggle"
                                                    name="customer_loyalty_point" id="customer_loyalty_point"
                                                    data-section="loyalty-point-section" value="1"
                                                    <?php echo e(isset($data['loyalty_point_status']) && $data['loyalty_point_status'] == 1 ? 'checked' : ''); ?>>
                                                <span class="toggle-switch-label text">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-2">
                        <div class="card-header card-header-shadow">
                            <h5 class="card-title">
                                <img src="<?php echo e(asset('/public/assets/admin/img/loyalty.png')); ?>" alt=""
                                    class="card-header-icon align-self-center mr-1">
                                <span>
                                    <?php echo e(translate('Customer_Loyalty_Point_Settings')); ?>

                                </span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="py-2">
                                <div class="row g-3 align-items-end">
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="form-group mb-0">
                                            <label class="input-label" for="loyalty_point_exchange_rate">1
                                                <?php echo e(\App\CentralLogics\Helpers::currency_code()); ?>

                                                <?php echo e(translate('equivalent point amount')); ?></label>
                                            <input <?php echo e(isset($data['loyalty_point_status']) && $data['loyalty_point_status'] == 1 ? 'required' : 'readonly'); ?>

                                            id="loyalty_point_exchange_rate" type="number" class="form-control"
                                                name="loyalty_point_exchange_rate" step=".001" min="0"
                                                value="<?php echo e($data['loyalty_point_exchange_rate'] ?? '0'); ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="form-group mb-0">
                                            <label class="input-label" for="item_purchase_point">
                                                <?php echo e(translate('Loyalty_Point_Earn_Per_Order')); ?> (%)
                                                <small class="text-danger"><span class="input-label-secondary"
                                                        data-toggle="tooltip" data-placement="right"
                                                        data-original-title="<?php echo e(translate('messages.On_every_purchase_this_percent_of_amount_will_be_added_as_loyalty_point_on_his_account')); ?>"><img
                                                            src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>"
                                                            alt="<?php echo e(translate('messages.On_every_purchase_this_percent_of_amount_will_be_added_as_loyalty_point_on_his_account')); ?>"></span>
                                                    *</small>
                                            </label>
                                            <input <?php echo e(isset($data['loyalty_point_status']) && $data['loyalty_point_status'] == 1 ? 'required' : 'readonly'); ?> id="item_purchase_point" type="number" class="form-control"
                                                name="item_purchase_point" step=".001" min="0"
                                                value="<?php echo e($data['loyalty_point_item_purchase_point'] ?? '0'); ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="form-group mb-0">
                                            <label class="input-label" for="minimum_transfer_point">
                                                <?php echo e(translate('Minimum_Point_Required_To_Convert')); ?>

                                            </label>
                                            <input <?php echo e(isset($data['loyalty_point_status']) && $data['loyalty_point_status'] == 1 ? 'required' : 'readonly'); ?> id="minimum_transfer_point" type="number" class="form-control"
                                                name="minimun_transfer_point" min="0" step=".001"
                                                value="<?php echo e($data['loyalty_point_minimum_point'] ?? '0'); ?>">
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-2">
                        <div class="card-header card-header-shadow">
                            <h5 class="card-title">
                                <img src="<?php echo e(asset('/public/assets/admin/img/loyalty.png')); ?>" alt=""
                                    class="card-header-icon align-self-center mr-1">
                                <span>
                                    <?php echo e(translate('Customer_Referral_Earning_Settings')); ?>

                                </span>
                                <span class="input-label-secondary" data-toggle="tooltip" data-placement="right"
                                    data-original-title="<?php echo e(translate('messages.Existing_Customers_can_share_a_referral_code_with_others_to_earn_a_referral_bonus._For_this,_the_new_user_MUST_sign_up_using_the_referral_code_and_make_their_first_purchase.')); ?>">
                                    <img src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>"
                                        alt="<?php echo e(translate('messages.show_hide_food_menu')); ?>">
                                </span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="py-2">
                                <div class="row g-3 align-items-end">

                                    <div class="align-self-center  col-4">
                                        <div class="text-left">
                                            <h4 class="align-items-center">
                                                <img src="<?php echo e(asset('/public/assets/admin/img/referral.png')); ?>"
                                                    alt="" class="card-header-icon align-self-center mr-1">
                                                <span>
                                                    <?php echo e(translate('Who_Share_the_code')); ?>

                                                </span>
                                            </h4>
                                            <p>
                                                <?php echo e(translate('Customers_will_receive_this_wallet_balance_rewards_for_sharing_their_referral_code_with_friends,_who_use_the_code_when_signing_up_and_completing_their_first_order.')); ?>

                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="card __bg-F8F9FC-card text-left">
                                            <div class="card-body">
                                                <div class="form-group mb-0">
                                                    <label class="input-label" for="ref_earning_exchange_rate">
                                                        <?php echo e(translate('Earning Per Referral')); ?>

                                                        <?php echo e(\App\CentralLogics\Helpers::currency_code()); ?>

                                                    </label>
                                                    <input <?php echo e(isset($data['wallet_status']) && $data['wallet_status'] == 1 ? '' : 'readonly'); ?>

                                                    id="ref_earning_exchange_rate" type="number" step=".001" min="0" max="99999999999"
                                                        class="form-control" name="ref_earning_exchange_rate"
                                                        value="<?php echo e($data['ref_earning_exchange_rate'] ?? '0'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row g-3 align-items-end">
                                    <div class="align-self-center col-4 text-center">
                                        <div class="text-left">

                                            <h4 class="align-items-center">
                                                <img src="<?php echo e(asset('/public/assets/admin/img/Who_Use_the_code.png')); ?>"
                                                    alt="" class="card-header-icon align-self-center mr-1">
                                                <span>
                                                    <?php echo e(translate('Who_Use_the_code')); ?>

                                                </span>
                                            </h4>
                                            <p>
                                                <?php echo e(translate('By_applying_the_referral_code_during_signup_and_when_making_their_first_purchase,_customers_will_enjoy_a_discount_for_a_limited_time.')); ?>

                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="card __bg-F8F9FC-card text-left">
                                            <div class="card-body">
                                                <div>
                                                    <div class="form-group mb-0">
                                                        <label
                                                            class="toggle-switch toggle-switch-sm d-flex justify-content-between border border-secondary rounded px-4 form-control <?php echo e(isset($data['wallet_status']) && $data['wallet_status'] == 1 ? '' : 'text-muted'); ?>">
                                                            <span
                                                                class="pr-2"><?php echo e(translate('Customer_will_get_Discount_on_first_order ')); ?>

                                                                <span class="input-label-secondary" data-toggle="tooltip"
                                                                    data-placement="right"
                                                                    data-original-title="<?php echo e(translate('messages.Configure_discounts_for_newly_registered_users_who_sign_up_with_a_referral_code._Customize_the_discount_type_and_amount_to_incentivize_referrals_and_encourage_user_engagement.')); ?>">
                                                                    <img src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>"
                                                                        alt="<?php echo e(translate('messages.show_hide_food_menu')); ?>">
                                                                </span>
                                                            </span>
                                                            <input <?php echo e(isset($data['wallet_status']) && $data['wallet_status'] == 1 ? '' : 'disabled'); ?>

                                                            type="checkbox" data-id="new_customer_discount_status"
                                                                data-type="toggle"
                                                                data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/basic_campaign_on.png')); ?>"
                                                                data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/basic_campaign_off.png')); ?>"
                                                                data-title-on="<?php echo e(translate('messages.Want_to_enable')); ?> <strong><?php echo e(translate('messages.new_customer_discount?')); ?></strong>"
                                                                data-title-off="<?php echo e(translate('messages.Want_to_disable')); ?> <strong><?php echo e(translate('messages.new_customer_discount?')); ?></strong>"
                                                                data-text-on="<p><?php echo e(translate('messages.If_you_enable_this,_Customers_will_get_discount_on_first_order.')); ?></p>"
                                                                data-text-off="<p><?php echo e(translate('mo.If_you_disable_this,_Customers_won’t_get_any_discount_on_first_order.')); ?></p>"
                                                                class="status toggle-switch-input dynamic-checkbox-toggle "
                                                                name="new_customer_discount_status"
                                                                id="new_customer_discount_status" value="1"
                                                                <?php echo e(data_get($data, 'new_customer_discount_status') == 1 ? 'checked' : ''); ?>>
                                                            <span class="toggle-switch-label text">
                                                                <span class="toggle-switch-indicator"></span>
                                                            </span>
                                                        </label>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-8 mt-3">
                                                        <div class="form-group mb-0">
                                                            <label class="input-label" for="new_customer_discount_amount">
                                                                <?php echo e(translate('Discount_Amount')); ?>


                                                                <span class="<?php echo e(data_get($data, 'new_customer_discount_amount_type') != 'amount'  ? '': 'd-none'); ?> " id="percentage">(%)</span>
                                                                <span  class=" <?php echo e(data_get($data, 'new_customer_discount_amount_type') == 'amount' ? '': 'd-none'); ?> " id='cuttency_symbol'>(<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)
                                                                </span>


                                                                <span
                                                                    class="input-label-secondary" data-toggle="tooltip"
                                                                    data-placement="right"
                                                                    data-original-title="<?php echo e(translate('Enter_the_discount_value_for_referral-based_new_user_registrations.')); ?>">
                                                                    <img src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>"
                                                                        alt="<?php echo e(translate('messages.show_hide_food_menu')); ?>">
                                                                </span>
                                                            </label>
                                                            <input id="new_customer_discount_amount" type="number" step=".001" min="0"
                                                            <?php echo e(isset($data['wallet_status']) && $data['wallet_status'] == 1 && data_get($data, 'new_customer_discount_status') == 1 ? 'required' : 'readonly'); ?>

                                                                class="form-control" name="new_customer_discount_amount" max='<?php echo e(data_get($data, 'new_customer_discount_amount_type') != 'amount'  ? '100': '9999999999'); ?>'
                                                                value="<?php echo e(data_get($data, 'new_customer_discount_amount') ?? '0'); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-4  mt-3">
                                                        <div class="form-group mb-0">
                                                            <select   name="new_customer_discount_amount_type"  class="form-control mt-5"  id="new_customer_discount_amount_type"
                                                            <?php echo e(isset($data['wallet_status']) && $data['wallet_status'] == 1 && data_get($data, 'new_customer_discount_status') == 1 ? 'required' : 'disabled'); ?>


                                                            >
                                                                <option <?php echo e(data_get($data, 'new_customer_discount_amount_type') == 'percentage' ? "selected": ''); ?> value="percentage"><?php echo e(translate('messages.percentage')); ?> (%)</option>
                                                                <option <?php echo e(data_get($data, 'new_customer_discount_amount_type') == 'amount' ? "selected": ''); ?>  value="amount"><?php echo e(translate('messages.amount')); ?> <?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-8 mt-3">
                                                        <div class="form-group mb-0">
                                                            <label class="input-label" for="new_customer_discount_amount_validity">
                                                                <?php echo e(translate('validity')); ?>

                                                                <span class="input-label-secondary" data-toggle="tooltip"
                                                                    data-placement="right"
                                                                    data-original-title="<?php echo e(translate('Set_how_long_the_discount_remains_active_after_registration.')); ?>">
                                                                    <img src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>"
                                                                        alt="<?php echo e(translate('messages.show_hide_food_menu')); ?>">
                                                                </span>
                                                            </label>
                                                            <input id="new_customer_discount_amount_validity" type="number" step="1" min="0" max="999"
                                                            <?php echo e(isset($data['wallet_status']) && $data['wallet_status'] == 1 && data_get($data, 'new_customer_discount_status') == 1 ? 'required' : 'readonly'); ?>

                                                                class="form-control" name="new_customer_discount_amount_validity"
                                                                value="<?php echo e(data_get($data, 'new_customer_discount_amount_validity') ?? '0'); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-4 mt-3">
                                                        <div class="form-group  mb-0">
                                                            <select name="new_customer_discount_validity_type" class="form-control mt-5" id="new_customer_discount_validity_type"  <?php echo e(isset($data['wallet_status']) && $data['wallet_status'] == 1 &&  data_get($data, 'new_customer_discount_status') == 1 ? 'required' : 'disabled'); ?>>
                                                                <option <?php echo e(data_get($data, 'new_customer_discount_validity_type') == 'day' ? "selected": ''); ?> value="day"><?php echo e(translate('messages.day')); ?></option>
                                                                <option <?php echo e(data_get($data, 'new_customer_discount_validity_type') == 'month' ? "selected": ''); ?>  value="month"><?php echo e(translate('messages.month')); ?> </option>
                                                                <option <?php echo e(data_get($data, 'new_customer_discount_validity_type') == 'year' ? "selected": ''); ?>  value="year"><?php echo e(translate('messages.year')); ?> </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-12">
                        <div class="btn--container justify-content-end mt-20">
                            <button type="reset" id="reset_btn"
                                class="btn btn--reset location-reload"><?php echo e(translate('reset')); ?></button>
                            <button type="submit" id="submit"
                                class="btn btn--primary"><?php echo e(translate('Save Information')); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- End Table -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
<script>
    "use strict";

    $('#new_customer_discount_amount_type').on('change', function() {
        if($('#new_customer_discount_amount_type').val() == 'amount')
        {
            $('#percentage').addClass('d-none');
            $('#cuttency_symbol').removeClass('d-none');
            $('#new_customer_discount_amount').attr('max',99999999999);

        }
        else
        {
            $('#percentage').removeClass('d-none');
            $('#cuttency_symbol').addClass('d-none');
            $('#new_customer_discount_amount').attr('max',100);

        }
    });

</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/customer-index.blade.php ENDPATH**/ ?>