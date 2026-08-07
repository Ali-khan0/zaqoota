<?php $__env->startSection('title',translate('messages.flutter_web_landing_page')); ?>

<?php $__env->startSection('content'); ?>

<div class="content container-fluid">
    <div class="page-header pb-0">
        <div class="d-flex flex-wrap justify-content-between">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/flutter.png')); ?>" class="w--20" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.flutter_web_landing_page')); ?>

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
            <?php echo $__env->make('admin-views.business-settings.landing-page-settings.top-menu-links.flutter-landing-page-links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
    <div class="tab-content">
        <div class="tab-pane fade show active">
            <?php ($download_user_app_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','flutter_landing_page')->where('key','download_user_app_title')->first()); ?>
            <?php ($download_user_app_sub_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','flutter_landing_page')->where('key','download_user_app_sub_title')->first()); ?>
            <?php ($download_user_app_image=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','flutter_landing_page')->where('key','download_user_app_image')->first()); ?>
            <?php ($download_user_app_links = \App\Models\DataSetting::withoutGlobalScope('translate')->where(['key'=>'download_user_app_links','type'=>'flutter_landing_page'])->first()); ?>
            <?php ($download_user_app_links = isset($download_user_app_links->value)?json_decode($download_user_app_links->value, true):null); ?>
            <form action="<?php echo e(route('admin.business-settings.flutter-landing-page-settings', 'download-app-section')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <h5 class="card-title mb-3 mt-3">
                    <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span> <span><?php echo e(translate('Download User App Section Content')); ?></span>
                </h5>

                <div class="card">
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <?php if($language): ?>
                                <div class="col-md-12 lang_form default-form">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="download_user_app_title" class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(translate('messages.default')); ?>)
                                            <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_40_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span>
                                        </label>
                                            <input id="download_user_app_title" type="text" maxlength="40" name="download_user_app_title[]" value="<?php echo e($download_user_app_title?->getRawOriginal('value')??''); ?>" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                        </div>
                                        <div class="col-12">
                                            <label for="download_user_app_sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?> (<?php echo e(translate('messages.default')); ?>)
                                            <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span>
                                        </label>
                                            <input  id="download_user_app_sub_title" type="text" maxlength="20" name="download_user_app_sub_title[]" value="<?php echo e($download_user_app_sub_title?->getRawOriginal('value')??''); ?>" class="form-control" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                                    <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    if(isset($download_user_app_title->translations)&&count($download_user_app_title->translations)){
                                            $download_user_app_title_translate = [];
                                            foreach($download_user_app_title->translations as $t)
                                            {
                                                if($t->locale == $lang && $t->key=='download_user_app_title'){
                                                    $download_user_app_title_translate[$lang]['value'] = $t->value;
                                                }
                                            }

                                        }
                                    if(isset($download_user_app_sub_title->translations)&&count($download_user_app_sub_title->translations)){
                                            $download_user_app_sub_title_translate = [];
                                            foreach($download_user_app_sub_title->translations as $t)
                                            {
                                                if($t->locale == $lang && $t->key=='download_user_app_sub_title'){
                                                    $download_user_app_sub_title_translate[$lang]['value'] = $t->value;
                                                }
                                            }

                                        }
                                        ?>
                                    <div class="col-md-12 d-none lang_form" id="<?php echo e($lang); ?>-form1">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="download_user_app_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(strtoupper($lang)); ?>)
                                                <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_40_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span>
                                        </label>
                                                <input id="download_user_app_title<?php echo e($lang); ?>" type="text" maxlength="40" name="download_user_app_title[]" value="<?php echo e($download_user_app_title_translate[$lang]['value']??''); ?>" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                            </div>
                                            <div class="col-12">
                                                <label for="download_user_app_sub_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Sub Title')); ?> (<?php echo e(strtoupper($lang)); ?>)
                                                <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span>
                                        </label>
                                                <input id="download_user_app_sub_title<?php echo e($lang); ?>" type="text" maxlength="20" name="download_user_app_sub_title[]" value="<?php echo e($download_user_app_sub_title_translate[$lang]['value']??''); ?>" class="form-control" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                            </div>
                                        </div>
                                    </div>
                                        <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                <div class="col-md-12">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="download_user_app_title" class="form-label"><?php echo e(translate('Title')); ?>

                                            <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_40_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span>
                                        </label>
                                            <input id="download_user_app_title" type="text" maxlength="40" name="download_user_app_title[]" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                        </div>
                                        <div class="col-12">
                                            <label for="download_user_app_sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?>

                                            <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span>
                                        </label>
                                            <input id="download_user_app_sub_title" type="text" maxlength="20" name="download_user_app_sub_title[]" class="form-control" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                        </div>
                                    </div>
                                </div>
                                    <input type="hidden" name="lang[]" value="default">
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label d-block mb-2">
                                    <?php echo e(translate('messages.Banner')); ?>  <span class="text--primary"><?php echo e(translate('(size: 2:1)')); ?></span>
                                </label>
                                <label class="upload-img-3 m-0">
                                    <div class="position-relative">
                                    <div class="img">
                                        <img

                                        src="<?php echo e(\App\CentralLogics\Helpers::get_full_url('download_user_app_image', $download_user_app_image?->value?? '', $download_user_app_image?->storage[0]?->value ?? 'public','upload_image_4')); ?>" data-onerror-image="<?php echo e(asset('/public/assets/admin/img/upload-4.png')); ?>" alt="" class="vertical-img mw-100 vertical onerror-image">
                                    </div>
                                      <input type="file"  name="image" hidden>
                                      <?php if(isset($download_user_app_image['value'])): ?>
                                            <span id="download_user_app_image" class="remove_image_button remove-image"
                                                  data-id="download_user_app_image"
                                                  data-title="<?php echo e(translate('Warning!')); ?>"
                                                  data-text="<p><?php echo e(translate('Are_you_sure_you_want_to_remove_this_image_?')); ?></p>"
                                            > <i class="tio-clear"></i></span>

                                            <?php endif; ?>
                                        </div>
                                </label>
                            </div>
                        </div>
                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <h5 class="card-title mb-2">
                                    <img src="<?php echo e(asset('public/assets/admin/img/playstore.png')); ?>" class="mr-2" alt="">
                                    <?php echo e(translate('Playstore Button')); ?>

                                </h5>
                                <div class="__bg-F8F9FC-card">
                                    <div class="form-group mb-md-0">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label   for="playstore_url" class="form-label text-capitalize m-0">
                                                <?php echo e(translate('Download Link')); ?>

                                                <span class="input-label-secondary text--title" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('When_disabled,_the_Play_Store_download_button_will_be_hidden_from_the_landing_page')); ?>">
                                                    <i class="tio-info-outined"></i>
                                                </span>
                                            </label>
                                            <label class="toggle-switch toggle-switch-sm m-0">
                                                <input type="checkbox" name="playstore_url_status"



                                                       id="play-store-dm-status"
                                                       data-id="play-store-dm-status"
                                                       data-type="toggle"
                                                       data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/play-store-on.png')); ?>"
                                                       data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/play-store-off.png')); ?>"
                                                       data-title-on="<?php echo e(translate('Want_to_enable_the_Play_Store_button_for_User_App?')); ?>"
                                                       data-title-off="<?php echo e(translate('Want_to_disable_the_Play_Store_button_for_User_App?')); ?>"
                                                       data-text-on="<p><?php echo e(translate('If_enabled,_the_User_app_download_button_will_be_visible_on_the_Landing_page.')); ?></p>"
                                                       data-text-off="<p><?php echo e(translate('If_disabled,_this_button_will_be_hidden_from_the_landing_page.')); ?></p>"
                                                       class="status toggle-switch-input dynamic-checkbox-toggle"

                                                       value="1" <?php echo e((isset($download_user_app_links) && $download_user_app_links['playstore_url_status'])?'checked':''); ?>>
                                                <span class="toggle-switch-label text mb-0">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                        </div>
                                        <input id="playstore_url" type="text" placeholder="<?php echo e(translate('Ex: https://play.google.com/store/apps')); ?>" class="form-control h--45px" name="playstore_url" value="<?php echo e($download_user_app_links['playstore_url']?? ''); ?>">
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
                                            <label for="apple_store_url" class="form-label text-capitalize m-0">
                                                <?php echo e(translate('Download Link')); ?>

                                                <span class="input-label-secondary text--title" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('When_disabled,_the_App_Store_download_button_will_be_hidden_from_the_landing_page')); ?>">
                                                    <i class="tio-info-outined"></i>
                                                </span>
                                            </label>
                                            <label  class="toggle-switch toggle-switch-sm m-0">
                                                <input type="checkbox" name="apple_store_url_status"
                                                       id="apple-dm-status"
                                                       data-id="apple-dm-status"
                                                       data-type="toggle"
                                                       data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/apple-on.png')); ?>"
                                                       data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/apple-off.png')); ?>"
                                                       data-title-on="<?php echo e(translate('want_to_enable_the_app_store_button_for_user_app?')); ?>"
                                                       data-title-off="<?php echo e(translate('want_to_disable_the_app_store_button_for_user_app?')); ?>"
                                                       data-text-on="<p><?php echo e(translate('if_enabled,_the_user_app_download_button_will_be_visible_on_the_landing_page.')); ?></p>"
                                                       data-text-off="<p><?php echo e(translate('if_disabled,_this_button_will_be_hidden_from_the_landing_page.')); ?></p>"
                                                       class="status toggle-switch-input dynamic-checkbox-toggle"
                                                       value="1"
                                                    <?php echo e((isset($download_user_app_links) && $download_user_app_links['apple_store_url_status'])?'checked':''); ?>>
                                                <span class="toggle-switch-label text mb-0">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                        </div>
                                        <input id="apple_store_url" type="text" placeholder="<?php echo e(translate('Ex: https://www.apple.com/app-store/')); ?>" class="form-control h--45px" name="apple_store_url" value="<?php echo e($download_user_app_links['apple_store_url'] ?? ''); ?>">
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
            <form  id="download_user_app_image_form" action="<?php echo e(route('admin.remove_image')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo e($download_user_app_image?->id); ?>" >
                <input type="hidden" name="model_name" value="DataSetting" >
                <input type="hidden" name="image_path" value="download_user_app_image" >
                <input type="hidden" name="field_name" value="value" >
            </form>

        </div>
    </div>
</div>
    <!-- How it Works -->
    <?php echo $__env->make('admin-views.business-settings.landing-page-settings.partial.how-it-work-flutter', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/landing-page-settings/flutter-download-apps.blade.php ENDPATH**/ ?>