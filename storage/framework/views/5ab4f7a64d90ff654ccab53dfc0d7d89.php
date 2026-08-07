<?php use App\CentralLogics\Helpers;use App\Models\BusinessSetting;use App\Models\DataSetting; ?>


<?php $__env->startSection('title', translate('messages.react_landing_page')); ?>

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
                <div class="text--primary-2 py-1 d-flex flex-wrap align-items-center" type="button" data-toggle="modal"
                     data-target="#how-it-works">
                    <strong class="mr-2"><?php echo e(translate('See_how_it_works!')); ?></strong>
                    <div>
                        <i class="tio-info-outined"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-4 mt-2">
            <div class="js-nav-scroller hs-nav-scroller-horizontal">
                <?php echo $__env->make('admin-views.business-settings.landing-page-settings.top-menu-links.react-landing-page-links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
        <?php ($join_seller_react_status = DataSetting::withoutGlobalScope('translate')->where('type', 'react_landing_page')->where('key', 'join_seller_react_status')->first()?->value); ?>
        <?php ($join_DM_react_status = DataSetting::withoutGlobalScope('translate')->where('type', 'react_landing_page')->where('key', 'join_DM_react_status')->first()?->value); ?>


        <?php ($earning_title = DataSetting::withoutGlobalScope('translate')->where('type', 'react_landing_page')->where('key', 'earning_title')->first()); ?>
        <?php ($earning_sub_title = DataSetting::withoutGlobalScope('translate')->where('type', 'react_landing_page')->where('key', 'earning_sub_title')->first()); ?>
        <?php ($earning_seller_title = DataSetting::withoutGlobalScope('translate')->where('type', 'react_landing_page')->where('key', 'earning_seller_title')->first()); ?>
        <?php ($earning_seller_sub_title = DataSetting::withoutGlobalScope('translate')->where('type', 'react_landing_page')->where('key', 'earning_seller_sub_title')->first()); ?>
        <?php ($earning_seller_button_name = DataSetting::withoutGlobalScope('translate')->where('type', 'react_landing_page')->where('key', 'earning_seller_button_name')->first()); ?>
        <?php ($earning_seller_button_url = DataSetting::withoutGlobalScope('translate')->where('type', 'react_landing_page')->where('key', 'earning_seller_button_url')->first()); ?>
        <?php ($earning_dm_title = DataSetting::withoutGlobalScope('translate')->where('type', 'react_landing_page')->where('key', 'earning_dm_title')->first()); ?>
        <?php ($earning_dm_sub_title = DataSetting::withoutGlobalScope('translate')->where('type', 'react_landing_page')->where('key', 'earning_dm_sub_title')->first()); ?>
        <?php ($earning_dm_button_name = DataSetting::withoutGlobalScope('translate')->where('type', 'react_landing_page')->where('key', 'earning_dm_button_name')->first()); ?>
        <?php ($earning_dm_button_url = DataSetting::withoutGlobalScope('translate')->where('type', 'react_landing_page')->where('key', 'earning_dm_button_url')->first()); ?>
        <?php ($language = BusinessSetting::where('key', 'language')->first()); ?>
        <?php ($language = $language->value ?? null); ?>
        <?php ($defaultLang = str_replace('_', '-', app()->getLocale())); ?>
        <?php if($language): ?>
            <ul class="nav nav-tabs mb-4 border-0">
                <li class="nav-item">
                    <a class="nav-link lang_link active" href="#"
                       id="default-link"><?php echo e(translate('messages.default')); ?></a>
                </li>
                <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="nav-item">
                        <a class="nav-link lang_link" href="#"
                           id="<?php echo e($lang); ?>-link"><?php echo e(Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php endif; ?>
        <div class="tab-content">
            <div class="tab-pane fade show active">
                <form action="<?php echo e(route('admin.business-settings.react-landing-page-settings', 'earning-title')); ?>"
                      method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <h5 class="card-title mt-3 mb-3">
                        <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span>
                        <span><?php echo e(translate('Download User App Section Content ')); ?></span>
                    </h5>
                    <div class="card mb-3">
                        <div class="card-body">

                            <?php if($language): ?>
                                <div class="row g-3 lang_form default-form">
                                    <div class="col-sm-6">
                                        <label for="earning_title" class="form-label"><?php echo e(translate('Title')); ?>

                                            (<?php echo e(translate('messages.default')); ?>)
                                            <span class="form-label-secondary" data-toggle="tooltip"
                                                  data-placement="right"
                                                  data-original-title="<?php echo e(translate('Write_the_title_within_40_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                     alt="">
                                            </span></label>
                                        <input id="earning_title" type="text" maxlength="40" name="earning_title[]"
                                               class="form-control"
                                               value="<?php echo e($earning_title?->getRawOriginal('value') ?? ''); ?>"
                                               placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="earning_sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?>

                                            (<?php echo e(translate('messages.default')); ?>)
                                            <span class="form-label-secondary" data-toggle="tooltip"
                                                  data-placement="right"
                                                  data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                     alt="">
                                            </span></label>
                                        <input id="earning_sub_title" type="text" maxlength="80"
                                               name="earning_sub_title[]" class="form-control"
                                               value="<?php echo e($earning_sub_title?->getRawOriginal('value') ?? ''); ?>"
                                               placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                    </div>
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                                <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                        if (isset($earning_title->translations) && count($earning_title->translations)) {
                                            $earning_title_translate = [];
                                            foreach ($earning_title->translations as $t) {
                                                if ($t->locale == $lang && $t->key == 'earning_title') {
                                                    $earning_title_translate[$lang]['value'] = $t->value;
                                                }
                                            }
                                        }
                                        if (isset($earning_sub_title->translations) && count($earning_sub_title->translations)) {
                                            $earning_sub_title_translate = [];
                                            foreach ($earning_sub_title->translations as $t) {
                                                if ($t->locale == $lang && $t->key == 'earning_sub_title') {
                                                    $earning_sub_title_translate[$lang]['value'] = $t->value;
                                                }
                                            }
                                        }
                                        ?>
                                    <div class="row g-3 d-none lang_form" id="<?php echo e($lang); ?>-form">
                                        <div class="col-sm-6">
                                            <label for="earning_title<?php echo e($lang); ?>"
                                                   class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(strtoupper($lang)); ?>)<span
                                                    class="form-label-secondary" data-toggle="tooltip"
                                                    data-placement="right"
                                                    data-original-title="<?php echo e(translate('Write_the_title_within_40_characters')); ?>">
                                                    <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                         alt="">
                                                </span></label>
                                            <input id="earning_title<?php echo e($lang); ?>" type="text" maxlength="40"
                                                   name="earning_title[]" class="form-control"
                                                   value="<?php echo e($earning_title_translate[$lang]['value'] ?? ''); ?>"
                                                   placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="earning_sub_title<?php echo e($lang); ?>"
                                                   class="form-label"><?php echo e(translate('Sub Title')); ?>

                                                (<?php echo e(strtoupper($lang)); ?>)
                                                <span class="form-label-secondary" data-toggle="tooltip"
                                                      data-placement="right"
                                                      data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                                    <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                         alt="">
                                                </span></label>
                                            <input type="text" id="earning_sub_title<?php echo e($lang); ?>" maxlength="80"
                                                   name="earning_sub_title[]" class="form-control"
                                                   value="<?php echo e($earning_sub_title_translate[$lang]['value'] ?? ''); ?>"
                                                   placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                        </div>
                                    </div>
                                    <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label for="earning_title" class="form-label"><?php echo e(translate('Title')); ?></label>
                                        <input id="earning_title" type="text" name="earning_title[]"
                                               class="form-control"
                                               placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="earning_sub_title"
                                               class="form-label"><?php echo e(translate('Sub Title')); ?></label>
                                        <input id="earning_sub_title" type="text" name="earning_sub_title[]"
                                               class="form-control"
                                               placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                    </div>
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                            <?php endif; ?>
                            <div class="btn--container justify-content-end mt-20">
                                <button type="reset" class="btn btn--reset mb-2"><?php echo e(translate('Reset')); ?></button>
                                <button type="submit" class="btn btn--primary mb-2"><?php echo e(translate('Save')); ?></button>
                            </div>
                        </div>
                    </div>
                </form>

                <form action="<?php echo e(route('admin.business-settings.react-landing-page-settings', 'earning-seller-link')); ?>"
                      method="post" id="join_seller_react_status_form">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="join_seller_react_status" value="<?php echo e($join_seller_react_status ?? 0); ?>">
                </form>

                <form action="<?php echo e(route('admin.business-settings.react-landing-page-settings', 'earning-seller-link')); ?>"
                      method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mt-3 mb-3">
                                <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span>
                                <span><?php echo e(translate('Seller Section Content')); ?></span>
                            </h5>

                            <label class="toggle-switch justify-content-end  rounded">
                                <input type="checkbox" data-id="join_seller_react_status" data-type="status"
                                       data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/seller-app-on.png')); ?>"
                                       data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/seller-app-off.png')); ?>"
                                       data-title-on="<strong><?php echo e(translate('messages.Want_to_enable_Seller_Section_Content?')); ?></strong>"
                                       data-title-off="<strong><?php echo e(translate('messages.Want_to_disable_Seller_Section_Content?')); ?></strong>"
                                       data-text-on="<p><?php echo e(translate('messages.If_you_enable_this,_Seller_Section_Content_will_be_visible.')); ?></p>"
                                       data-text-off="<p><?php echo e(translate('messages.If_you_disable_this,_Seller_Section_Content_will_not_be_visible.')); ?></p>"
                                       class="status toggle-switch-input dynamic-checkbox" value="1" name=""
                                       id="join_seller_react_status" <?php echo e($join_seller_react_status == 1 ? 'checked' : ''); ?>>
                                <span class="toggle-switch-label text">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </div>


                        <div class="card-body <?php echo e($join_seller_react_status != 1 ? 'd-none' : ''); ?>">
                            <div class="row g-3">
                                <div class="col-12">
                                    <?php if($language): ?>
                                        <div class="row g-3 lang_form default-form">
                                            <div class="col-sm-6">
                                                <label for="earning_seller_title"
                                                       class="form-label"><?php echo e(translate('Title')); ?>

                                                    (<?php echo e(translate('messages.default')); ?>)<span
                                                        class="form-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="<?php echo e(translate('Write_the_title_within_30_characters')); ?>">
                                                        <img
                                                            src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                            alt="">
                                                    </span></label>
                                                <input id="earning_seller_title" type="text" maxlength="30"
                                                       name="earning_seller_title[]" class="form-control"
                                                       value="<?php echo e($earning_seller_title?->getRawOriginal('value') ?? ''); ?>"
                                                       placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                            </div>

                                            <div class="col-sm-6">
                                                <label for="earning_seller_button_name"
                                                       class="form-label text-capitalize">
                                                    <?php echo e(translate('Button Name')); ?>(<?php echo e(translate('messages.default')); ?>)
                                                    <span class="form-label-secondary" data-toggle="tooltip"
                                                          data-placement="right"
                                                          data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                                        <img
                                                            src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                            alt="">
                                                    </span></label>
                                                <input id="earning_seller_button_name" type="text" maxlength="20"
                                                       name="earning_seller_button_name[]"
                                                       value="<?php echo e($earning_seller_button_name?->getRawOriginal('value') ?? ''); ?>"
                                                       placeholder="<?php echo e(translate('Ex: Order now')); ?>"
                                                       class="form-control h--45px">
                                            </div>

                                            <div class="col-sm-6">
                                                <label for="earning_seller_sub_title"
                                                       class="form-label"><?php echo e(translate('Sub Title')); ?>

                                                    (<?php echo e(translate('messages.default')); ?>)<span
                                                        class="form-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="<?php echo e(translate('Write_the_title_within_65_characters')); ?>">
                                                        <img
                                                            src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                            alt="">
                                                    </span></label>
                                                <textarea id="earning_seller_sub_title" maxlength="65"
                                                          name="earning_seller_sub_title[]" class="form-control"
                                                          placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>"
                                                          rows="2"><?php echo e($earning_seller_sub_title?->getRawOriginal('value') ?? ''); ?></textarea>
                                            </div>

                                        </div>
                                        <input type="hidden" name="lang[]" value="default">
                                        <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                if (isset($earning_seller_title->translations) && count($earning_seller_title->translations)) {
                                                    $earning_seller_title_translate = [];
                                                    foreach ($earning_seller_title->translations as $t) {
                                                        if ($t->locale == $lang && $t->key == 'earning_seller_title') {
                                                            $earning_seller_title_translate[$lang]['value'] = $t->value;
                                                        }
                                                    }
                                                }
                                                if (isset($earning_seller_sub_title->translations) && count($earning_seller_sub_title->translations)) {
                                                    $earning_seller_sub_title_translate = [];
                                                    foreach ($earning_seller_sub_title->translations as $t) {
                                                        if ($t->locale == $lang && $t->key == 'earning_seller_sub_title') {
                                                            $earning_seller_sub_title_translate[$lang]['value'] = $t->value;
                                                        }
                                                    }
                                                }
                                                if (isset($earning_seller_button_name->translations) && count($earning_seller_button_name->translations)) {
                                                    $earning_seller_button_name_translate = [];
                                                    foreach ($earning_seller_button_name->translations as $t) {
                                                        if ($t->locale == $lang && $t->key == 'earning_seller_button_name') {
                                                            $earning_seller_button_name_translate[$lang]['value'] = $t->value;
                                                        }
                                                    }
                                                }
                                                ?>
                                            <div class="row g-3 d-none lang_form" id="<?php echo e($lang); ?>-form1">
                                                <div class="col-sm-6">
                                                    <label for="earning_seller_title<?php echo e($lang); ?>"
                                                           class="form-label"><?php echo e(translate('Title')); ?>

                                                        (<?php echo e(strtoupper($lang)); ?>)
                                                        <span class="form-label-secondary" data-toggle="tooltip"
                                                              data-placement="right"
                                                              data-original-title="<?php echo e(translate('Write_the_title_within_30_characters')); ?>">
                                                            <img
                                                                src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                                alt="">
                                                        </span></label>
                                                    <input id="earning_seller_title<?php echo e($lang); ?>" type="text"
                                                           maxlength="30" name="earning_seller_title[]"
                                                           class="form-control"
                                                           value="<?php echo e($earning_seller_title_translate[$lang]['value'] ?? ''); ?>"
                                                           placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                                </div>

                                                <div class="col-sm-6">
                                                    <label for="earning_seller_button_name<?php echo e($lang); ?>"
                                                           class="form-label text-capitalize">
                                                        <?php echo e(translate('Button Name')); ?>(<?php echo e(strtoupper($lang)); ?>)
                                                        <span class="form-label-secondary" data-toggle="tooltip"
                                                              data-placement="right"
                                                              data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                                            <img
                                                                src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                                alt="">
                                                        </span></label>
                                                    <input id="earning_seller_button_name<?php echo e($lang); ?>"
                                                           type="text" maxlength="20"
                                                           name="earning_seller_button_name[]"
                                                           value="<?php echo e($earning_seller_button_name_translate[$lang]['value'] ?? ''); ?>"
                                                           placeholder="<?php echo e(translate('Ex: Order now')); ?>"
                                                           class="form-control h--45px">
                                                </div>

                                                <div class="col-sm-6">
                                                    <label for="earning_seller_sub_title<?php echo e($lang); ?>"
                                                           class="form-label"><?php echo e(translate('Sub Title')); ?>

                                                        (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary"
                                                                                       data-toggle="tooltip"
                                                                                       data-placement="right"
                                                                                       data-original-title="<?php echo e(translate('Write_the_title_within_65_characters')); ?>">
                                                            <img
                                                                src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                                alt="">
                                                        </span></label>
                                                    <textarea id="earning_seller_sub_title<?php echo e($lang); ?>" maxlength="65"
                                                              name="earning_seller_sub_title[]"
                                                              class="form-control"
                                                              placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>"
                                                              rows="2"><?php echo e($earning_seller_sub_title_translate[$lang]['value'] ?? ''); ?></textarea>
                                                </div>


                                            </div>
                                            <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <div class="row g-3">
                                            <div class="col-sm-6">
                                                <label for="earning_seller_title"
                                                       class="form-label"><?php echo e(translate('Title')); ?></label>
                                                <input id="earning_seller_title" type="text"
                                                       name="earning_seller_title[]" class="form-control"
                                                       placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="earning_seller_sub_title"
                                                       class="form-label"><?php echo e(translate('Sub Title')); ?></label>
                                                <input id="earning_seller_sub_title" type="text"
                                                       name="earning_seller_sub_title[]" class="form-control"
                                                       placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                            </div>

                                            <div class="col-sm-6">
                                                <label for="earning_seller_button_name"
                                                       class="form-label text-capitalize">
                                                    <?php echo e(translate('Button Name')); ?>


                                                </label>
                                                <input id="earning_seller_button_name" type="text"
                                                       placeholder="<?php echo e(translate('Ex: Order now')); ?>"
                                                       class="form-control h--45px" name="earning_seller_button_name[]">
                                            </div>
                                        </div>
                                        <input type="hidden" name="lang[]" value="default">
                                    <?php endif; ?>
                                </div>

                            </div>
                            <div class="btn--container justify-content-end mt-20">
                                <button type="reset" class="btn btn--reset mb-2"><?php echo e(translate('Reset')); ?></button>
                                <button type="submit" class="btn btn--primary mb-2"><?php echo e(translate('Save')); ?></button>
                            </div>
                        </div>
                    </div>
                </form>


                <form action="<?php echo e(route('admin.business-settings.react-landing-page-settings', 'earning-dm-link')); ?>"
                      method="post" id="join_DM_react_status_form">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="join_DM_react_status" value="<?php echo e($join_DM_react_status ?? 0); ?>">
                </form>


                <form action="<?php echo e(route('admin.business-settings.react-landing-page-settings', 'earning-dm-link')); ?>"
                      method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>


                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mt-3 mb-3">
                                <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span>
                                <span><?php echo e(translate('Deliveryman_Section_Content')); ?></span>
                            </h5>

                            <label class="toggle-switch justify-content-end  rounded">
                                <input type="checkbox" data-id="join_DM_react_status" data-type="status"
                                       data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/seller-app-on.png')); ?>"
                                       data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/seller-app-off.png')); ?>"
                                       data-title-on="<strong><?php echo e(translate('messages.Want_to_enable_Deliveryman_Section_Content?')); ?></strong>"
                                       data-title-off="<strong><?php echo e(translate('messages.Want_to_disable_Deliveryman_Section_Content?')); ?></strong>"
                                       data-text-on="<p><?php echo e(translate('messages.If_you_enable_this,_Deliveryman_Section_Content_will_be_visible.')); ?></p>"
                                       data-text-off="<p><?php echo e(translate('messages.If_you_disable_this,_Deliveryman_Section_Content_will_not_be_visible.')); ?></p>"
                                       class="status toggle-switch-input dynamic-checkbox" value="1" name=""
                                       id="join_DM_react_status" <?php echo e($join_DM_react_status == 1 ? 'checked' : ''); ?>>
                                <span class="toggle-switch-label text">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </div>


                        <div class="card-body <?php echo e($join_DM_react_status != 1 ? 'd-none' : ''); ?>">

                            <div class="row g-3">
                                <div class="col-12">
                                    <?php if($language): ?>
                                        <div class="row g-3 lang_form default-form">
                                            <div class="col-sm-6">
                                                <label for="earning_dm_title"
                                                       class="form-label"><?php echo e(translate('Title')); ?>

                                                    (<?php echo e(translate('messages.default')); ?>)<span
                                                        class="form-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="<?php echo e(translate('Write_the_title_within_30_characters')); ?>">
                                                        <img
                                                            src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                            alt="">
                                                    </span></label>
                                                <input id="earning_dm_title" type="text" maxlength="30"
                                                       name="earning_dm_title[]" class="form-control"
                                                       value="<?php echo e($earning_dm_title?->getRawOriginal('value') ?? ''); ?>"
                                                       placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                            </div>


                                            <div class="col-sm-6">
                                                <label for="earning_dm_button_name" class="form-label text-capitalize">
                                                    <?php echo e(translate('Button Name')); ?>(<?php echo e(translate('messages.default')); ?>)
                                                    <span class="form-label-secondary" data-toggle="tooltip"
                                                          data-placement="right"
                                                          data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                                        <img
                                                            src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                            alt="">
                                                    </span></label>
                                                <input id="earning_dm_button_name" type="text" maxlength="20"
                                                       name="earning_dm_button_name[]"
                                                       value="<?php echo e($earning_dm_button_name?->getRawOriginal('value') ?? ''); ?>"
                                                       placeholder="<?php echo e(translate('Ex: Order now')); ?>"
                                                       class="form-control h--45px">
                                            </div>


                                            <div class="col-sm-6">
                                                <label for="earning_dm_sub_title"
                                                       class="form-label"><?php echo e(translate('Sub Title')); ?>

                                                    (<?php echo e(translate('messages.default')); ?>)<span
                                                        class="form-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="<?php echo e(translate('Write_the_title_within_65_characters')); ?>">
                                                        <img
                                                            src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                            alt="">
                                                    </span></label>
                                                <textarea id="earning_dm_sub_title" maxlength="65"
                                                          name="earning_dm_sub_title[]" class="form-control"
                                                          placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>"
                                                          rows="2"><?php echo e($earning_dm_sub_title?->getRawOriginal('value') ?? ''); ?></textarea>

                                            </div>

                                        </div>
                                        <input type="hidden" name="lang[]" value="default">
                                        <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                if (isset($earning_dm_title->translations) && count($earning_dm_title->translations)) {
                                                    $earning_dm_title_translate = [];
                                                    foreach ($earning_dm_title->translations as $t) {
                                                        if ($t->locale == $lang && $t->key == 'earning_dm_title') {
                                                            $earning_dm_title_translate[$lang]['value'] = $t->value;
                                                        }
                                                    }
                                                }
                                                if (isset($earning_dm_sub_title->translations) && count($earning_dm_sub_title->translations)) {
                                                    $earning_dm_sub_title_translate = [];
                                                    foreach ($earning_dm_sub_title->translations as $t) {
                                                        if ($t->locale == $lang && $t->key == 'earning_dm_sub_title') {
                                                            $earning_dm_sub_title_translate[$lang]['value'] = $t->value;
                                                        }
                                                    }
                                                }
                                                if (isset($earning_dm_button_name->translations) && count($earning_dm_button_name->translations)) {
                                                    $earning_dm_button_name_translate = [];
                                                    foreach ($earning_dm_button_name->translations as $t) {
                                                        if ($t->locale == $lang && $t->key == 'earning_dm_button_name') {
                                                            $earning_dm_button_name_translate[$lang]['value'] = $t->value;
                                                        }
                                                    }
                                                }
                                                ?>
                                            <div class="row g-3 d-none lang_form" id="<?php echo e($lang); ?>-form3">
                                                <div class="col-sm-6">
                                                    <label for="earning_dm_title<?php echo e($lang); ?>"
                                                           class="form-label"><?php echo e(translate('Title')); ?>

                                                        (<?php echo e(strtoupper($lang)); ?>)
                                                        <span class="form-label-secondary" data-toggle="tooltip"
                                                              data-placement="right"
                                                              data-original-title="<?php echo e(translate('Write_the_title_within_30_characters')); ?>">
                                                            <img
                                                                src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                                alt="">
                                                        </span></label>
                                                    <input id="earning_dm_title<?php echo e($lang); ?>" type="text"
                                                           maxlength="30" name="earning_dm_title[]" class="form-control"
                                                           value="<?php echo e($earning_dm_title_translate[$lang]['value'] ?? ''); ?>"
                                                           placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                                </div>

                                                <div class="col-sm-6">
                                                    <label for="earning_dm_button_name<?php echo e($lang); ?>"
                                                           class="form-label text-capitalize">
                                                        <?php echo e(translate('Button Name')); ?>(<?php echo e(strtoupper($lang)); ?>)
                                                        <span class="form-label-secondary" data-toggle="tooltip"
                                                              data-placement="right"
                                                              data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                                            <img
                                                                src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                                alt="">
                                                        </span></label>
                                                    <input id="earning_dm_button_name<?php echo e($lang); ?>" type="text"
                                                           maxlength="20" name="earning_dm_button_name[]"
                                                           value="<?php echo e($earning_dm_button_name_translate[$lang]['value'] ?? ''); ?>"
                                                           placeholder="<?php echo e(translate('Ex: Order now')); ?>"
                                                           class="form-control h--45px">
                                                </div>


                                                <div class="col-sm-6">
                                                    <label for="earning_dm_sub_title<?php echo e($lang); ?>"
                                                           class="form-label"><?php echo e(translate('Sub Title')); ?>

                                                        (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary"
                                                                                       data-toggle="tooltip"
                                                                                       data-placement="right"
                                                                                       data-original-title="<?php echo e(translate('Write_the_title_within_65_characters')); ?>">
                                                            <img
                                                                src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                                alt="">
                                                        </span></label>
                                                    <textarea id="earning_dm_sub_title<?php echo e($lang); ?>" maxlength="65"
                                                              name="earning_dm_sub_title[]"
                                                              class="form-control"
                                                              placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>"
                                                              rows="2"><?php echo e($earning_dm_sub_title_translate[$lang]['value'] ?? ''); ?></textarea>

                                                </div>

                                            </div>
                                            <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <div class="row g-3">
                                            <div class="col-sm-6">
                                                <label for="earning_dm_title"
                                                       class="form-label"><?php echo e(translate('Title')); ?></label>
                                                <input id="earning_dm_title" type="text" name="earning_dm_title[]"
                                                       class="form-control"
                                                       placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="earning_dm_sub_title"
                                                       class="form-label"><?php echo e(translate('Sub Title')); ?></label>
                                                <input id="earning_dm_sub_title" type="text"
                                                       name="earning_dm_sub_title[]" class="form-control"
                                                       placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                            </div>

                                            <div class="col-sm-6">
                                                <label for="earning_dm_button_name" class="form-label text-capitalize">
                                                    <?php echo e(translate('Button Name')); ?>


                                                </label>
                                                <input id="earning_dm_button_name" type="text"
                                                       placeholder="<?php echo e(translate('Ex: Order now')); ?>"
                                                       class="form-control h--45px" name="earning_dm_button_name[]">
                                            </div>

                                        </div>
                                        <input type="hidden" name="lang[]" value="default">
                                    <?php endif; ?>
                                </div>

                            </div>
                            <div class="btn--container justify-content-end mt-20">
                                <button type="reset" class="btn btn--reset mb-2"><?php echo e(translate('Reset')); ?></button>
                                <button type="submit" class="btn btn--primary mb-2"><?php echo e(translate('Save')); ?></button>
                            </div>
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>
    <!-- How it Works -->
    <?php echo $__env->make('admin-views.business-settings.landing-page-settings.partial.how-it-work-react', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/landing-page-settings/react-landing-earn-money.blade.php ENDPATH**/ ?>