<?php $__env->startSection('title',translate('messages.react_landing_page')); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <div class="page-header pb-0">
        <div class="d-flex flex-wrap justify-content-between">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/landing.png')); ?>" class="w--20" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.react_landing_page')); ?>

                </span>
            </h1>
            <div class="text--primary-2 py-1 d-flex flex-wrap align-items-center" type="button" data-toggle="modal" data-target="#how-it-works">
                <strong class="mr-2"><?php echo e(translate('See_how_it_works!')); ?></strong>
                <div>
                    <i class="tio-info-outined"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-20 mt-2">
        <div class="js-nav-scroller hs-nav-scroller-horizontal">
            <?php echo $__env->make('admin-views.business-settings.landing-page-settings.top-menu-links.react-landing-page-links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>

    <?php ($language=\App\Models\BusinessSetting::where('key','language')->first()); ?>
    <?php ($language = $language->value ?? null); ?>
    <?php ($defaultLang = str_replace('_', '-', app()->getLocale())); ?>
    <?php if($language): ?>
        <ul class="nav nav-tabs mb-4 border-0">
            <li class="nav-item">
                <a class="nav-link lang_link active"
                href="#"
                id="default-link"><?php echo e(translate('messages.default')); ?></a>
            </li>
            <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="nav-item">
                    <a class="nav-link lang_link"
                        href="#"
                        id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php endif; ?>
    <?php ($business_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','business_title')->first()); ?>
    <?php ($business_sub_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','business_sub_title')->first()); ?>
    <?php ($download_app_links = \App\Models\DataSetting::where(['key'=>'download_business_app_links','type'=>'react_landing_page'])->first()); ?>
    <?php ($download_app_links = isset($download_app_links->value)?json_decode($download_app_links->value, true):null); ?>

    <?php ($business_image=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','business_image')->first()); ?>
    <div class="tab-content">
        <div class="tab-pane fade show active">
            <form action="<?php echo e(route('admin.business-settings.react-landing-page-settings', 'business-section')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="card">
                    <div class="card-body">

                        <div class="row g-4">
                            <div class="col-md-6">
                                <?php if($language): ?>
                                <div class="col-md-12 lang_form default-form">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="business_title" class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(translate('messages.default')); ?>)
                                            <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_30_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input type="text" id="business_title" maxlength="30" name="business_title[]" value="<?php echo e($business_title?->getRawOriginal('value')??''); ?>" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                        </div>
                                        <div class="col-12">
                                            <label for="business_sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?> (<?php echo e(translate('messages.default')); ?>)
                                            <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_35_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input type="text" id="business_sub_title" maxlength="35" name="business_sub_title[]" value="<?php echo e($business_sub_title?->getRawOriginal('value')??''); ?>" class="form-control" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                                    <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    if(isset($business_title->translations)&&count($business_title->translations)){
                                            $business_title_translate = [];
                                            foreach($business_title->translations as $t)
                                            {
                                                if($t->locale == $lang && $t->key=='business_title'){
                                                    $business_title_translate[$lang]['value'] = $t->value;
                                                }
                                            }

                                        }
                                    if(isset($business_sub_title->translations)&&count($business_sub_title->translations)){
                                            $business_sub_title_translate = [];
                                            foreach($business_sub_title->translations as $t)
                                            {
                                                if($t->locale == $lang && $t->key=='business_sub_title'){
                                                    $business_sub_title_translate[$lang]['value'] = $t->value;
                                                }
                                            }

                                        }
                                        ?>
                                    <div class="col-md-12 d-none lang_form" id="<?php echo e($lang); ?>-form1">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="business_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_30_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input type="text" id="business_title<?php echo e($lang); ?>"  maxlength="30" name="business_title[]" value="<?php echo e($business_title_translate[$lang]['value']??''); ?>" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                            </div>
                                            <div class="col-12">
                                                <label for="business_sub_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Sub Title')); ?> (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_35_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input type="text" id="business_sub_title<?php echo e($lang); ?>"  maxlength="35" name="business_sub_title[]" value="<?php echo e($business_sub_title_translate[$lang]['value']??''); ?>" class="form-control" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                            </div>
                                        </div>
                                    </div>
                                        <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                <div class="col-md-12">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="business_title" class="form-label"><?php echo e(translate('Title')); ?></label>
                                            <input id="business_title" type="text" name="business_title[]" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                        </div>
                                        <div class="col-12">
                                            <label for="business_title" class="form-label"><?php echo e(translate('Sub Title')); ?></label>
                                            <input id="business_sub_title" type="text" name="business_sub_title[]" class="form-control" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                        </div>
                                    </div>
                                </div>
                                    <input type="hidden" name="lang[]" value="default">
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label d-block mb-2">
                                    <?php echo e(translate('messages.Banner')); ?>  <span class="text--primary"><?php echo e(translate('(size: 1:1)')); ?></span>
                                </label>
                                <label class="upload-img-3 m-0">
                                    <div class="position-relative">
                                    <div class="img">
                                        <img
                                        src="<?php echo e(\App\CentralLogics\Helpers::get_full_url('business_image', $business_image?->value?? '', $business_image?->storage[0]?->value ?? 'public','aspect_1')); ?>" data-onerror-image="<?php echo e(asset('/public/assets/admin/img/aspect-1.png')); ?>" alt="" class="img__aspect-1 min-w-187px max-w-187px onerror-image">
                                    </div>
                                      <input type="file"  name="image" hidden>
                                         <?php if(isset($business_image['value'])): ?>
                                            <span id="business_image" class="remove_image_button remove-image"
                                                  data-id="business_image"
                                                  data-title="<?php echo e(translate('Warning!')); ?>"
                                                  data-text="<p><?php echo e(translate('Are_you_sure_you_want_to_remove_this_image_?')); ?></p>"
                                            > <i class="tio-clear"></i></span>
                                            <?php endif; ?>
                                        </div>
                                </label>
                            </div>
                        </div>
                        <div class="row g-3 mt-3">
                            <div class="col-12">
                                <h5 class="card-title mb-5">
                                    <img src="<?php echo e(asset('public/assets/admin/img/seller.png')); ?>" class="mr-2" alt="">
                                    <?php echo e(translate('Download the Seller App')); ?>

                                </h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="card-title mb-2">
                                            <img src="<?php echo e(asset('public/assets/admin/img/playstore.png')); ?>" class="mr-2" alt="">
                                            <?php echo e(translate('Playstore Button')); ?>

                                        </h5>
                                        <div class="__bg-F8F9FC-card">
                                            <div class="form-group mb-md-0">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <label for="seller_playstore_url" class="form-label text-capitalize m-0">
                                                        <?php echo e(translate('Download Link')); ?>


                                                    </label>
                                                    <label class="toggle-switch toggle-switch-sm m-0">
                                                        <input type="checkbox" name="seller_playstore_url_status"

                                                               id="play-store-seller-status"
                                                               data-id="play-store-seller-status"
                                                               data-type="toggle"
                                                               data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/play-store-on.png')); ?>"
                                                               data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/play-store-off.png')); ?>"
                                                               data-title-on="<?php echo e(translate('playstore_button_enabled_for_seller')); ?>"
                                                               data-title-off="<?php echo e(translate('playstore_button_disabled_for_seller')); ?>"
                                                               data-text-on="<p><?php echo e(translate('Playstore_button_is_enabled_now_everyone_can_use_or_see_the_button')); ?></p>"
                                                               data-text-off="<p><?php echo e(translate('Playstore_button_is_disabled_now_no_one_can_use_or_see_the_button')); ?></p>"
                                                               class="status toggle-switch-input dynamic-checkbox-toggle"

                                                               value="1" <?php echo e((isset($download_app_links) && $download_app_links['seller_playstore_url_status'])?'checked':''); ?>>
                                                        <span class="toggle-switch-label text mb-0">
                                                            <span class="toggle-switch-indicator"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <input id="seller_playstore_url" type="text" placeholder="<?php echo e(translate('Ex: https://play.google.com/store/apps')); ?>" class="form-control h--45px" name="seller_playstore_url" value="<?php echo e($download_app_links['seller_playstore_url']??''); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="card-title mb-2">
                                            <img src="<?php echo e(asset('public/assets/admin/img/ios.png')); ?>" class="mr-2" alt="">
                                            <?php echo e(translate('App Store Button')); ?>

                                        </h5>
                                        <div class="__bg-F8F9FC-card">
                                            <div class="form-group mb-md-0">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <label for="seller_appstore_url" class="form-label text-capitalize m-0">
                                                        <?php echo e(translate('Download Link')); ?>


                                                    </label>
                                                    <label class="toggle-switch toggle-switch-sm m-0">
                                                        <input type="checkbox" name="seller_appstore_url_status"

                                                               id="apple-seller-status"
                                                               data-id="apple-seller-status"
                                                               data-type="toggle"
                                                               data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/apple-on.png')); ?>"
                                                               data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/apple-off.png')); ?>"
                                                               data-title-on="<?php echo e(translate('app_store_button_enabled_for_seller')); ?>"
                                                               data-title-off="<?php echo e(translate('app_store_button_disabled_for_seller')); ?>"
                                                               data-text-on="<p><?php echo e(translate('App Store button is enabled now everyone can use or see the button')); ?></p>"
                                                               data-text-off="<p><?php echo e(translate('App Store button is disabled now no one can use or see the button')); ?></p>"
                                                               class="status toggle-switch-input dynamic-checkbox-toggle"

                                                               value="1" <?php echo e((isset($download_app_links) && $download_app_links['seller_appstore_url_status'])?'checked':''); ?>>
                                                        <span class="toggle-switch-label text mb-0">
                                                            <span class="toggle-switch-indicator"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <input id="seller_appstore_url" type="text" placeholder="<?php echo e(translate('Ex: https://www.apple.com/app-store/')); ?>" class="form-control h--45px" name="seller_appstore_url" value="<?php echo e($download_app_links['seller_appstore_url']??''); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mt-3">
                            <div class="col-12">
                                <h5 class="card-title mb-5">
                                    <img src="<?php echo e(asset('public/assets/admin/img/dm.png')); ?>" class="mr-2" alt="">
                                    <?php echo e(translate('Download the Deliveryman App')); ?>

                                </h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="card-title mb-2">
                                            <img src="<?php echo e(asset('public/assets/admin/img/playstore.png')); ?>" class="mr-2" alt="">
                                            <?php echo e(translate('Playstore Button')); ?>

                                        </h5>
                                        <div class="__bg-F8F9FC-card">
                                            <div class="form-group mb-md-0">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <label for="dm_playstore_url" class="form-label text-capitalize m-0">
                                                        <?php echo e(translate('Download Link')); ?>


                                                    </label>
                                                    <label class="toggle-switch toggle-switch-sm m-0">
                                                        <input type="checkbox" name="dm_playstore_url_status"

                                                               id="play-store-dm-status"
                                                               data-id="play-store-dm-status"
                                                               data-type="toggle"
                                                               data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/play-store-on.png')); ?>"
                                                               data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/play-store-off.png')); ?>"
                                                               data-title-on="<?php echo e(translate('playstore_button_enabled_for_delivery_man')); ?>"
                                                               data-title-off="<?php echo e(translate('playstore_button_disabled_for_delivery_man')); ?>"
                                                               data-text-on="<?php echo e(translate('Playstore_button_is_enabled_now_everyone_can_use_or_see_the_button')); ?>"
                                                               data-text-off="<?php echo e(translate('Playstore_button_is_disabled_now_no_one_can_use_or_see_the_button')); ?>"
                                                               class="status toggle-switch-input dynamic-checkbox-toggle"

                                                               value="1" <?php echo e((isset($download_app_links) && $download_app_links['dm_playstore_url_status'])?'checked':''); ?>>
                                                        <span class="toggle-switch-label text mb-0">
                                                            <span class="toggle-switch-indicator"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <input id="dm_playstore_url" type="text" placeholder="<?php echo e(translate('Ex: https://play.google.com/store/apps')); ?>" class="form-control h--45px" name="dm_playstore_url" value="<?php echo e($download_app_links['dm_playstore_url']??''); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="card-title mb-2">
                                            <img src="<?php echo e(asset('public/assets/admin/img/ios.png')); ?>" class="mr-2" alt="">
                                            <?php echo e(translate('App Store Button')); ?>

                                        </h5>
                                        <div class="__bg-F8F9FC-card">
                                            <div class="form-group mb-md-0">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <label for="dm_appstore_url" class="form-label text-capitalize m-0">
                                                        <?php echo e(translate('Download Link')); ?>


                                                    </label>
                                                    <label class="toggle-switch toggle-switch-sm m-0">
                                                        <input type="checkbox" name="dm_appstore_url_status"

                                                               id="apple-dm-status"
                                                               data-id="apple-dm-status"
                                                               data-type="toggle"
                                                               data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/apple-on.png')); ?>"
                                                               data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/apple-off.png')); ?>"
                                                               data-title-on="<?php echo e(translate('app_store_button_enabled_for_delivery_man')); ?>"
                                                               data-title-off="<?php echo e(translate('app_store_button_disabled_for_delivery_man')); ?>"
                                                               data-text-on="<p><?php echo e(translate('App_Store_button_is_enabled_now_everyone_can_use_or_see_the_button')); ?></p>"
                                                               data-text-off="<p><?php echo e(translate('App_Store_button_is_disabled_now_no_one_can_use_or_see_the_button')); ?></p>"
                                                               class="status toggle-switch-input dynamic-checkbox-toggle"

                                                               value="1" <?php echo e((isset($download_app_links) && $download_app_links['dm_appstore_url_status'])?'checked':''); ?>>
                                                        <span class="toggle-switch-label text mb-0">
                                                            <span class="toggle-switch-indicator"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <input id="dm_appstore_url" type="text" placeholder="<?php echo e(translate('Ex: https://www.apple.com/app-store/')); ?>" class="form-control h--45px" name="dm_appstore_url" value="<?php echo e($download_app_links['dm_appstore_url']??''); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn--container justify-content-end mt-20">
                            <button type="reset" class="btn btn--reset mb-2"><?php echo e(translate('Reset')); ?></button>
                            <button type="submit"   class="btn btn--primary mb-2"><?php echo e(translate('Save')); ?></button>
                        </div>
                    </div>
                </div>
            </form>
                        <form  id="business_image_form" action="<?php echo e(route('admin.remove_image')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo e($business_image?->id); ?>" >

                <input type="hidden" name="model_name" value="DataSetting" >
                <input type="hidden" name="image_path" value="business_image" >
                <input type="hidden" name="field_name" value="value" >
            </form>

        </div>
    </div>
</div>
<!-- How it Works -->
<?php echo $__env->make('admin-views.business-settings.landing-page-settings.partial.how-it-work-react', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/landing-page-settings/react-landing-business.blade.php ENDPATH**/ ?>