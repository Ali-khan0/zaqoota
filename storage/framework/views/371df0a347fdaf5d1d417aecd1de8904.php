<?php $__env->startSection('title',translate('messages.Subscription')); ?>

<?php $__env->startSection('subscription_settings'); ?>
active
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="content container-fluid">
        <div class="page-header">
            <div class="d-flex flex-wrap justify-content-between align-items-center py-2">
                <div class="flex-grow-1">
                    <div class="d-flex align-items-start">
                        <img src="<?php echo e(asset('/public/assets/admin/img/store.png')); ?>" width="24" alt="img">
                        <div class="w-0 flex-grow pl-2">
                            <h1 class="page-header-title"><?php echo e(translate('Subscription Settings')); ?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header border-0 align-items-center">
                <div class="w-100 d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div>
                        <h3 class="text--title card-title"><?php echo e(translate('Offer_Free_Trial')); ?></h3>
                        <div><?php echo e(translate('You_can_offer_vendors_a_free_trial_to_experience_the_system_overall')); ?></div>
                    </div>
                    <label class="toggle-switch toggle-switch-sm"> <?php echo e(translate('Status')); ?>:&nbsp;
                        <input type="checkbox" data-url="<?php echo e(route('admin.business-settings.subscriptionackage.trialStatus')); ?>" data-title="<?php echo e(data_get($settings, 'subscription_free_trial_status') != 1 ? translate('Are you sure to enable the free trial option?') : translate('Are you sure to disable the free trial option?')); ?>"
                        data-message="<?php echo e(data_get($settings, 'subscription_free_trial_status') != 1 ? translate('If enabled, the store can experience the services at no cost for a limited time.') : translate('If disabled, the store can’t get the experience without any business plan.')); ?>"
                        class="toggle-switch-input status_change_alert" <?php echo e(data_get($settings, 'subscription_free_trial_status') == 1?'checked':''); ?> >
                        <span class="toggle-switch-label">
                            <span class="toggle-switch-indicator"></span>
                        </span>
                    </label>
                </div>
            </div>
                <?php
                    if( data_get($settings, 'subscription_free_trial_type') == 'year'){
                        $trial_period =data_get($settings, 'subscription_free_trial_days') > 0 ? data_get($settings, 'subscription_free_trial_days')  / 365 : 0;
                    } else if( data_get($settings, 'subscription_free_trial_type') == 'month'){
                        $trial_period =data_get($settings, 'subscription_free_trial_days') > 0 ? data_get($settings, 'subscription_free_trial_days')  / 30 : 0;
                    } else{
                        $trial_period =data_get($settings, 'subscription_free_trial_days') > 0 ? data_get($settings, 'subscription_free_trial_days') : null ;
                    }
                ?>
            <div class="card-body py-2">
                <div class="card mb-2">
                    <div class="card-body">
                        <form action="<?php echo e(route('admin.business-settings.subscriptionackage.settingUpdate')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field("post"); ?>
                            <div class="row g-3">
                                <div class="col-sm-6 col-lg-4 col-xl-5">
                                    <div class="pr-xl-4">
                                        <label class="form-label"><?php echo e(translate('Free Trial Period')); ?></label>
                                        <input type="number" required min="0" value="<?php echo e($trial_period); ?>" max="999" class="form-control" name="subscription_free_trial_days" placeholder="120">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4 col-xl-3 mr-auto">
                                    <label class="form-label d-none d-sm-block">&nbsp;</label>
                                    <select name="subscription_free_trial_type" class="form-control">
                                        <option <?php echo e(data_get($settings, 'subscription_free_trial_type') == 'day' ?'selected':''); ?> value="day" ><?php echo e(translate('Day')); ?></option>
                                        <option <?php echo e(data_get($settings, 'subscription_free_trial_type') == 'month' ?'selected':''); ?> value="month" ><?php echo e(translate('Month')); ?></option>
                                        
                                    </select>
                                </div>
                                <div class="col-lg-4 col-xl-2">
                                    <label class="form-label d-none d-lg-block">&nbsp;</label>
                                    <button type="submit" class="btn px-xl-5 btn--primary w-100 h--45px"><?php echo e(translate('Submit')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <div class="card ">
            <div class="card-header border-0 align-items-center">
                <div class="w-100 d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div>
                        <h3 class="text--title card-title"><?php echo e(translate('Show_Deadline_Warning')); ?></h3>
                        <div><?php echo e(translate('Select_the_number_of_days_before_the_warning_will_be_shown_with_a_countdown_to_the_end_of_all_packages')); ?></div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-2">
                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo e(route('admin.business-settings.subscriptionackage.settingUpdate')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field("post"); ?>
                            <div class="row g-3">
                                <div class="col-sm-6 col-lg-4 col-xl-5">
                                    <div class="pr-xl-4">
                                        <label class="form-label"><?php echo e(translate('Select_Days')); ?></label>
                                        <input type="number" required name="subscription_deadline_warning_days" value="<?php echo e(data_get($settings, 'subscription_deadline_warning_days') ?? ' '); ?>" min="1" max="99999999"  class="form-control" placeholder="120">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-4 col-xl-5">
                                    <div class="pr-xl-4">
                                        <label class="form-label"><?php echo e(translate('Type_Message')); ?></label>
                                        <input type="text" name="subscription_deadline_warning_message" value="<?php echo e(data_get($settings, 'subscription_deadline_warning_message')); ?>" class="form-control" maxlength="254" placeholder="<?php echo e(translate('Your subscription ending soon.')); ?> " required>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xl-2">
                                    <label class="form-label d-none d-lg-block">&nbsp;</label>
                                    <button type="submit" class="btn px-xl-5 btn--primary w-100 h--45px"><?php echo e(translate('Submit')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-header border-0 align-items-center">
                <div class="w-100 d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div>
                        <h3 class="text--title card-title"><?php echo e(translate('Return Money Restriction')); ?></h3>
                        <div><?php echo e(translate('Setup the amount after which if any store change / migrate the subscription plan you won’t return any money back')); ?></div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-2">
                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo e(route('admin.business-settings.subscriptionackage.settingUpdate')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field("post"); ?>
                            <div class="row g-3">
                                <div class="col-sm-6 col-lg-8 col-xl-10">
                                    <div class="pr-xl-4">
                                        <label class="form-label"><?php echo e(translate('Select subscription usage time')); ?> (%)</label>
                                        <input type="number" required name="subscription_usage_max_time" value="<?php echo e(data_get($settings, 'subscription_usage_max_time') ?? ' '); ?>" min="1" max="99"  class="form-control" placeholder="120">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-xl-2">
                                    <label class="form-label d-none d-lg-block">&nbsp;</label>
                                    <button type="submit" class="btn px-xl-5 btn--primary w-100 h--45px"><?php echo e(translate('Submit')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>




<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
<script>
    "use strict";
        $('.status_change_alert').on('click', function (event) {
        let title = $(this).data('title');
        let url = $(this).data('url');
        let message = $(this).data('message');
        status_change_alert(title,url, message, event)
    })

    function status_change_alert(title,url, message, e) {
        e.preventDefault();
        Swal.fire({
            title: title,
            text: message,
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: 'default',
            confirmButtonColor: '#FC6A57',
            cancelButtonText: '<?php echo e(translate('no')); ?>',
            confirmButtonText: '<?php echo e(translate('yes')); ?>',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                location.href=url;
            }
        })
    }
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/subscription/settings/setting.blade.php ENDPATH**/ ?>