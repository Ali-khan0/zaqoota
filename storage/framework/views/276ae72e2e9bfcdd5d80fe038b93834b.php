<?php
    $vendorData = \App\CentralLogics\Helpers::get_store_data();
    $title = $vendorData?->module_type == 'rental' && addon_published_status('Rental') ? 'Provider' : 'Store';
?>

<?php $__env->startSection('title',translate('messages.store_view')); ?>
<?php $__env->startPush('css_or_js'); ?>
    <!-- Custom styles for this page -->
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <div class="page-header">
        <div class="d-flex flex-wrap justify-content-between">
            <h2 class="page-header-title text-capitalize my-2">
                <img class="w--26" src="<?php echo e(asset('/public/assets/admin/img/store.png')); ?>" alt="public">
                <span>
                    <?php echo e(translate('messages.my_'.$title.'_info')); ?>

                </span>
            </h2>
            <div class="my-2">
                <a class="btn btn--primary" href="<?php echo e(route('vendor.shop.edit')); ?>"><i class="tio-edit"></i><?php echo e(translate('messages.edit_'.$title.'_information')); ?></a>
            </div>
        </div>
    </div>
    <div class="card border-0">
        <div class="card-body p-0">
            <?php if($shop->cover_photo): ?>
            <div>
                <img class="my-restaurant-img onerror-image" src="<?php echo e($shop->cover_photo_full_url); ?>"
                data-onerror-image="<?php echo e(asset('public/assets/admin/img/900x400/img1.jpg')); ?>">
            </div>
            <?php endif; ?>
            <div class="my-resturant--card">

                <?php if($shop->image=='def.png'): ?>
                <div class="my-resturant--avatar">
                    <img class="border onerror-image"
                    src="<?php echo e(asset('public/assets/back-end')); ?>/img/shop.png"
                    data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>" alt="User Pic">
                </div>
                <?php else: ?>
                    <div class="my-resturant--avatar onerror-image">
                        <img src="<?php echo e($shop->logo_full_url); ?>"
                        class="border" data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>" alt="">
                    </div>
                <?php endif; ?>

                <div class="my-resturant--content">
                    <span class="d-block mb-1 pb-1">
                        <strong> <?php echo e(translate('messages.name')); ?> :</strong><?php echo e($shop->name); ?>

                    </span>
                    <span class="d-block mb-1 pb-1">
                        <strong><?php echo e(translate('messages.phone')); ?> :</strong> <a href="tel:<?php echo e($shop->phone); ?>"><?php echo e($shop->phone); ?></a>
                    </span>
                    <span class="d-block mb-1 pb-1">
                        <strong><?php echo e(translate('messages.address')); ?> : </strong> <?php echo e($shop->address); ?>

                    </span>
                    <span class="d-block mb-1 pb-1">
                        <strong><?php echo e(translate('messages.Business_Plan')); ?> : </strong> <?php echo e(translate($shop->store_business_model)); ?>

                    </span>
                    <span class="d-block mb-1 pb-1">
                        <?php if($shop->store_business_model == 'commission'): ?>

                        <strong><?php echo e(translate('messages.admin_commission')); ?> : </strong> <?php echo e((isset($shop->comission)? $shop->comission:\App\Models\BusinessSetting::where('key','admin_commission')->first()->value)); ?>%
                        <?php elseif(in_array($shop->store_business_model ,['subscription','unsubscribed'])): ?>

                        <strong><?php echo e(translate('Subscription_plan')); ?> : </strong> <?php echo e($shop?->store_sub_update_application?->package?->package_name); ?>

                        <?php endif; ?>

                    </span>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="card border-0 mt-2">
        <div class="card-header">
            <h5 class="card-title toggle-switch toggle-switch-sm d-flex justify-content-between">
                <span class="card-header-icon mr-1"><i class="tio-dashboard"></i></span>
                <span><?php echo e(translate('Announcement')); ?></span><span class="input-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('This_feature_is_for_sharing_important_information_or_announcements_related_to_the_'.$title.'.')); ?>"><img src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>" alt="<?php echo e(translate('messages.This_feature_is_for_sharing_important_information_or_announcements_related_to_the_'.$title)); ?>"></span>
            </h5>
            <label class="toggle-switch toggle-switch-sm" for="announcement_status">
                <input class="toggle-switch-input dynamic-checkbox" type="checkbox" id="announcement_status"
                       data-id="announcement_status"
                       data-type="status"
                       data-image-on='<?php echo e(asset('/public/assets/admin/img/modal')); ?>/digital-payment-on.png'
                       data-image-off="<?php echo e(asset('/public/assets/admin/img/modal')); ?>/digital-payment-off.png"
                       data-title-on="<?php echo e(translate('Do_you_want_to_enable_the_announcement')); ?>"
                       data-title-off="<?php echo e(translate('Do_you_want_to_disable_the_announcement')); ?>"
                       data-text-on="<p><?php echo e(translate('User_will_able_to_see_the_Announcement_on_the_store_page.')); ?></p>"
                       data-text-off="<p><?php echo e(translate('User_will_not_be_able_to_see_the_Announcement_on_the_store_page')); ?></p>"
                       name="announcement" value="1" <?php echo e($shop->announcement?'checked':''); ?>>
                                <span class="toggle-switch-label">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
            </label>


        </div>
        <form action="<?php echo e(route('vendor.business-settings.toggle-settings',[$shop->id,$shop->announcement?0:1, 'announcement'])); ?>"
            method="get" id="announcement_status_form">
            </form>
        <div class="card-body">
            <form action="<?php echo e(route('vendor.shop.update-message')); ?>" method="post">
            <?php echo csrf_field(); ?>
                <textarea name="announcement_message" id="" class="form-control" rows="5" placeholder="<?php echo e(translate('messages.ex_:_ABC_Company')); ?>"><?php echo e($shop->announcement_message??''); ?></textarea>
                <div class="justify-content-end btn--container mt-2">
                    <button type="submit" class="btn btn--primary"><?php echo e(translate('publish')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/shop/shopInfo.blade.php ENDPATH**/ ?>