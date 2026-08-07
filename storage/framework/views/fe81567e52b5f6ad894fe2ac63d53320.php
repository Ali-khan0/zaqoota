<?php $__env->startSection('title', translate('messages.flutter_web_landing_page')); ?>

<?php $__env->startSection('content'); ?>

    <div class="content container-fluid">
        <div class="page-header pb-0">
            <div class="d-flex flex-wrap justify-content-between">
                <h1 class="page-header-title">
                    <span class="page-header-icon">
                        <img src="<?php echo e(asset('public/assets/admin/img/flutter.png')); ?>" class="w--15" alt="">
                    </span>
                    <span>
                        <?php echo e(translate('messages.flutter_web_landing_page')); ?>

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
                <?php echo $__env->make('admin-views.business-settings.landing-page-settings.top-menu-links.flutter-landing-page-links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
        <?php ($join_seller_flutter_status = \App\Models\DataSetting::withoutGlobalScope('translate')->where('type', 'flutter_landing_page')->where('key', 'join_seller_flutter_status')->first()?->value); ?>
        <?php ($join_DM_flutter_status = \App\Models\DataSetting::withoutGlobalScope('translate')->where('type', 'flutter_landing_page')->where('key', 'join_DM_flutter_status')->first()?->value); ?>


        <?php ($join_seller_title = \App\Models\DataSetting::withoutGlobalScope('translate')->where('type', 'flutter_landing_page')->where('key', 'join_seller_title')->first()); ?>
        <?php ($join_seller_sub_title = \App\Models\DataSetting::withoutGlobalScope('translate')->where('type', 'flutter_landing_page')->where('key', 'join_seller_sub_title')->first()); ?>
        <?php ($join_seller_button_name = \App\Models\DataSetting::withoutGlobalScope('translate')->where('type', 'flutter_landing_page')->where('key', 'join_seller_button_name')->first()); ?>
        <?php ($join_delivery_man_title = \App\Models\DataSetting::withoutGlobalScope('translate')->where('type', 'flutter_landing_page')->where('key', 'join_delivery_man_title')->first()); ?>
        <?php ($join_delivery_man_sub_title = \App\Models\DataSetting::withoutGlobalScope('translate')->where('type', 'flutter_landing_page')->where('key', 'join_delivery_man_sub_title')->first()); ?>
        <?php ($join_delivery_man_button_name = \App\Models\DataSetting::withoutGlobalScope('translate')->where('type', 'flutter_landing_page')->where('key', 'join_delivery_man_button_name')->first()); ?>

        <?php ($language = \App\Models\BusinessSetting::where('key', 'language')->first()); ?>
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
                            id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php endif; ?>
        <div class="tab-content">
            <div class="tab-pane fade show active">
                <form action="<?php echo e(route('admin.business-settings.flutter-landing-page-settings', 'join-seller')); ?>" method="post" id="join_seller_flutter_status_form">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="join_seller_flutter_status" value="<?php echo e($join_seller_flutter_status ?? 0); ?>">
                </form>

                <form action="<?php echo e(route('admin.business-settings.flutter-landing-page-settings', 'join-seller')); ?>"
                    method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-3 mt-3">
                                <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span>
                                <span><?php echo e(translate('Join_as_a_Seller_Section')); ?></span>
                            </h5>

                            <label class="toggle-switch justify-content-end  rounded">
                                <input type="checkbox" data-id="join_seller_flutter_status" data-type="status"
                                    data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/seller-app-on.png')); ?>"
                                    data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/seller-app-off.png')); ?>"
                                    data-title-on="<strong><?php echo e(translate('messages.Want_to_enable_Join_as_a_Seller_Section?')); ?></strong>"
                                    data-title-off="<strong><?php echo e(translate('messages.Want_to_disable_Join_as_a_Seller_Section?')); ?></strong>"
                                    data-text-on="<p><?php echo e(translate('messages.If_you_enable_this,_Join_as_a_Seller_Section_will_be_visible.')); ?></p>"
                                    data-text-off="<p><?php echo e(translate('messages.If_you_disable_this,_Join_as_a_Seller_Section_will_not_be_visible.')); ?></p>"
                                    class="status toggle-switch-input dynamic-checkbox" value="1"
                                    name="" id="join_seller_flutter_status"
                                    <?php echo e($join_seller_flutter_status == 1 ? 'checked' : ''); ?>>
                                <span class="toggle-switch-label text">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </div>
                        <div class="card-body <?php echo e($join_seller_flutter_status != 1 ? 'd-none' : ''); ?>">
                            <?php if($language): ?>
                                <div class="row g-3 lang_form default-form">
                                    <div class="col-sm-6">
                                        <label for="join_seller_title" class="form-label"><?php echo e(translate('Title')); ?>

                                            (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary"
                                                data-toggle="tooltip" data-placement="right"
                                                data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                    alt="">
                                            </span></label>
                                        <input type="text" id="join_seller_title" maxlength="20"
                                            name="join_seller_title[]" class="form-control"
                                            value="<?php echo e($join_seller_title?->getRawOriginal('value') ?? ''); ?>"
                                            placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="join_seller_button_name"
                                            class="form-label"><?php echo e(translate('Button Name')); ?>

                                            (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary"
                                                data-toggle="tooltip" data-placement="right"
                                                data-original-title="<?php echo e(translate('Write_the_title_within_15_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                    alt="">
                                            </span></label>
                                        <input id="join_seller_button_name" type="text" maxlength="15"
                                            name="join_seller_button_name[]" class="form-control"
                                            value="<?php echo e($join_seller_button_name?->getRawOriginal('value') ?? ''); ?>"
                                            placeholder="<?php echo e(translate('messages.button_name_here...')); ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="join_seller_sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?>

                                            (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary"
                                                data-toggle="tooltip" data-placement="right"
                                                data-original-title="<?php echo e(translate('Write_the_title_within_60_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                    alt="">
                                            </span></label>
                                        <textarea id="join_seller_sub_title" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>" maxlength="60"
                                            name="join_seller_sub_title[]" class="form-control" rows="2"><?php echo e($join_seller_sub_title?->getRawOriginal('value') ?? ''); ?></textarea>
                                    </div>

                                </div>
                                <input type="hidden" name="lang[]" value="default">
                                <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    if (isset($join_seller_title->translations) && count($join_seller_title->translations)) {
                                        $join_seller_title_translate = [];
                                        foreach ($join_seller_title->translations as $t) {
                                            if ($t->locale == $lang && $t->key == 'join_seller_title') {
                                                $join_seller_title_translate[$lang]['value'] = $t->value;
                                            }
                                        }
                                    }
                                    if (isset($join_seller_sub_title->translations) && count($join_seller_sub_title->translations)) {
                                        $join_seller_sub_title_translate = [];
                                        foreach ($join_seller_sub_title->translations as $t) {
                                            if ($t->locale == $lang && $t->key == 'join_seller_sub_title') {
                                                $join_seller_sub_title_translate[$lang]['value'] = $t->value;
                                            }
                                        }
                                    }
                                    if (isset($join_seller_button_name->translations) && count($join_seller_button_name->translations)) {
                                        $join_seller_button_name_translate = [];
                                        foreach ($join_seller_button_name->translations as $t) {
                                            if ($t->locale == $lang && $t->key == 'join_seller_button_name') {
                                                $join_seller_button_name_translate[$lang]['value'] = $t->value;
                                            }
                                        }
                                    }
                                    ?>
                                    <div class="row g-3 d-none lang_form" id="<?php echo e($lang); ?>-form">
                                        <div class="col-sm-6">
                                            <label for="join_seller_title<?php echo e($lang); ?>"
                                                class="form-label"><?php echo e(translate('Title')); ?>

                                                (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary"
                                                    data-toggle="tooltip" data-placement="right"
                                                    data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                                    <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                        alt="">
                                                </span></label>
                                            <input type="text" id="join_seller_title<?php echo e($lang); ?>"
                                                maxlength="20" name="join_seller_title[]" class="form-control"
                                                value="<?php echo e($join_seller_title_translate[$lang]['value'] ?? ''); ?>"
                                                placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="join_seller_button_name<?php echo e($lang); ?>"
                                                class="form-label"><?php echo e(translate('Button Name')); ?>

                                                (<?php echo e(strtoupper($lang)); ?>)
                                                <span class="form-label-secondary" data-toggle="tooltip"
                                                    data-placement="right"
                                                    data-original-title="<?php echo e(translate('Write_the_title_within_15_characters')); ?>">
                                                    <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                        alt="">
                                                </span></label>
                                            <input id="join_seller_button_name<?php echo e($lang); ?>" type="text"
                                                maxlength="15" name="join_seller_button_name[]" class="form-control"
                                                value="<?php echo e($join_seller_button_name_translate[$lang]['value'] ?? ''); ?>"
                                                placeholder="<?php echo e(translate('messages.button_name_here...')); ?>">
                                        </div>

                                        <div class="col-sm-6">
                                            <label for="join_seller_sub_title<?php echo e($lang); ?>"
                                                class="form-label"><?php echo e(translate('Sub Title')); ?>

                                                (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary"
                                                    data-toggle="tooltip" data-placement="right"
                                                    data-original-title="<?php echo e(translate('Write_the_title_within_60_characters')); ?>">
                                                    <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                        alt="">
                                                </span></label>
                                            <textarea id="join_seller_sub_title<?php echo e($lang); ?>" type="text"
                                                placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>" maxlength="60" name="join_seller_sub_title[]"
                                                class="form-control" rows="2"><?php echo e($join_seller_sub_title_translate[$lang]['value'] ?? ''); ?></textarea>
                                        </div>

                                    </div>
                                    <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label for="join_seller_title" class="form-label"><?php echo e(translate('Title')); ?><span
                                                class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                                                data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                    alt="">
                                            </span></label>
                                        <input type="text" id="join_seller_title" maxlength="20"
                                            name="join_seller_title[]" class="form-control"
                                            placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="join_seller_button_name"
                                            class="form-label"><?php echo e(translate('Button Name')); ?><span
                                                class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                                                data-original-title="<?php echo e(translate('Write_the_title_within_15_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                    alt="">
                                            </span></label>
                                        <input id="join_seller_button_name" type="text" maxlength="15"
                                            name="join_seller_button_name[]" class="form-control"
                                            placeholder="<?php echo e(translate('messages.button_name_here...')); ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="join_seller_sub_title"
                                            class="form-label"><?php echo e(translate('Sub Title')); ?><span
                                                class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                                                data-original-title="<?php echo e(translate('Write_the_title_within_60_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                    alt="">
                                            </span></label>
                                        <textarea id="join_seller_sub_title" value="join_seller_sub_title" maxlength="60" name="join_seller_sub_title[]"
                                            class="form-control" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>" rows="2"></textarea>
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


                <form action="<?php echo e(route('admin.business-settings.flutter-landing-page-settings', 'join-delivery')); ?>" method="post" id="join_DM_flutter_status_form">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="join_DM_flutter_status" value="<?php echo e($join_DM_flutter_status ?? 0); ?>">
                </form>

                <form action="<?php echo e(route('admin.business-settings.flutter-landing-page-settings', 'join-delivery')); ?>"
                    method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <div class="mt-4 card">
                        <div class="card-header">
                            <h5 class="card-title mb-3 mt-3">
                                <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span>
                                <span><?php echo e(translate('Join_as_a_Deliveryman_Section')); ?></span>
                            </h5>

                            <label class="toggle-switch justify-content-end  rounded">
                                <input type="checkbox" data-id="join_DM_flutter_status" data-type="status"
                                    data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/home-delivery-on.png')); ?>"
                                    data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/home-delivery-off.png')); ?>"
                                    data-title-on="<strong><?php echo e(translate('messages.Want_to_enable_Join_as_a_Deliveryman_Section?')); ?></strong>"
                                    data-title-off="<strong><?php echo e(translate('messages.Want_to_disable_Join_as_a_Deliveryman_Section?')); ?></strong>"
                                    data-text-on="<p><?php echo e(translate('messages.If_you_enable_this,_Join_as_a_Deliveryman_Section_will_be_visible.')); ?></p>"
                                    data-text-off="<p><?php echo e(translate('messages.If_you_disable_this,_Join_as_a_Deliveryman_Section_will_not_be_visible.')); ?></p>"
                                    class="status toggle-switch-input dynamic-checkbox" value="1"
                                    name="" id="join_DM_flutter_status"
                                    <?php echo e($join_DM_flutter_status == 1 ? 'checked' : ''); ?>>
                                <span class="toggle-switch-label text">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </div>
                        <div class="card-body <?php echo e($join_DM_flutter_status != 1 ? 'd-none' : ''); ?>">

                            <?php if($language): ?>
                                <div class="row g-3 lang_form default-form">
                                    <div class="col-sm-6">
                                        <label for="join_delivery_man_title" class="form-label"><?php echo e(translate('Title')); ?>

                                            (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary"
                                                data-toggle="tooltip" data-placement="right"
                                                data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                    alt="">
                                            </span></label>
                                        <input type="text" id="join_delivery_man_title" maxlength="20"
                                            name="join_delivery_man_title[]" class="form-control"
                                            value="<?php echo e($join_delivery_man_title?->getRawOriginal('value') ?? ''); ?>"
                                            placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="join_delivery_man_button_name"
                                            class="form-label"><?php echo e(translate('Button Name')); ?>

                                            (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary"
                                                data-toggle="tooltip" data-placement="right"
                                                data-original-title="<?php echo e(translate('Write_the_title_within_15_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                    alt="">
                                            </span></label>
                                        <input id="join_delivery_man_button_name" type="text" maxlength="15"
                                            name="join_delivery_man_button_name[]" class="form-control"
                                            value="<?php echo e($join_delivery_man_button_name?->getRawOriginal('value') ?? ''); ?>"
                                            placeholder="<?php echo e(translate('messages.button_name_here...')); ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="join_delivery_man_sub_title"
                                            class="form-label"><?php echo e(translate('Sub Title')); ?>

                                            (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary"
                                                data-toggle="tooltip" data-placement="right"
                                                data-original-title="<?php echo e(translate('Write_the_title_within_60_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                    alt="">
                                            </span></label>
                                        <textarea id="join_delivery_man_sub_title" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>"
                                            maxlength="60" name="join_delivery_man_sub_title[]" class="form-control" rows="2"><?php echo e($join_delivery_man_sub_title?->getRawOriginal('value') ?? ''); ?></textarea>
                                    </div>


                                </div>
                                <input type="hidden" name="lang[]" value="default">
                                <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    if (isset($join_delivery_man_title->translations) && count($join_delivery_man_title->translations)) {
                                        $join_delivery_man_title_translate = [];
                                        foreach ($join_delivery_man_title->translations as $t) {
                                            if ($t->locale == $lang && $t->key == 'join_delivery_man_title') {
                                                $join_delivery_man_title_translate[$lang]['value'] = $t->value;
                                            }
                                        }
                                    }
                                    if (isset($join_delivery_man_sub_title->translations) && count($join_delivery_man_sub_title->translations)) {
                                        $join_delivery_man_sub_title_translate = [];
                                        foreach ($join_delivery_man_sub_title->translations as $t) {
                                            if ($t->locale == $lang && $t->key == 'join_delivery_man_sub_title') {
                                                $join_delivery_man_sub_title_translate[$lang]['value'] = $t->value;
                                            }
                                        }
                                    }
                                    if (isset($join_delivery_man_button_name->translations) && count($join_delivery_man_button_name->translations)) {
                                        $join_delivery_man_button_name_translate = [];
                                        foreach ($join_delivery_man_button_name->translations as $t) {
                                            if ($t->locale == $lang && $t->key == 'join_delivery_man_button_name') {
                                                $join_delivery_man_button_name_translate[$lang]['value'] = $t->value;
                                            }
                                        }
                                    }
                                    ?>
                                    <div class="row g-3 d-none lang_form" id="<?php echo e($lang); ?>-form1">
                                        <div class="col-sm-6">
                                            <label for="join_delivery_man_title<?php echo e($lang); ?>"
                                                class="form-label"><?php echo e(translate('Title')); ?>

                                                (<?php echo e(strtoupper($lang)); ?>)
                                                <span class="form-label-secondary" data-toggle="tooltip"
                                                    data-placement="right"
                                                    data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                                    <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                        alt="">
                                                </span></label>
                                            <input type="text" id="join_delivery_man_title<?php echo e($lang); ?>"
                                                maxlength="20" name="join_delivery_man_title[]" class="form-control"
                                                value="<?php echo e($join_delivery_man_title_translate[$lang]['value'] ?? ''); ?>"
                                                placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="join_delivery_man_button_name<?php echo e($lang); ?>"
                                                class="form-label"><?php echo e(translate('Button Name')); ?>

                                                (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary"
                                                    data-toggle="tooltip" data-placement="right"
                                                    data-original-title="<?php echo e(translate('Write_the_title_within_15_characters')); ?>">
                                                    <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                        alt="">
                                                </span></label>
                                            <input type="text" id="join_delivery_man_button_name<?php echo e($lang); ?>"
                                                maxlength="15" name="join_delivery_man_button_name[]"
                                                class="form-control"
                                                value="<?php echo e($join_delivery_man_button_name_translate[$lang]['value'] ?? ''); ?>"
                                                placeholder="<?php echo e(translate('messages.button_name_here...')); ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="join_delivery_man_sub_title<?php echo e($lang); ?>"
                                                class="form-label"><?php echo e(translate('Sub Title')); ?>

                                                (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary"
                                                    data-toggle="tooltip" data-placement="right"
                                                    data-original-title="<?php echo e(translate('Write_the_title_within_60_characters')); ?>">
                                                    <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                        alt="">
                                                </span></label>
                                            <textarea id="join_delivery_man_sub_title<?php echo e($lang); ?>"
                                                placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>" maxlength="60" name="join_delivery_man_sub_title[]"
                                                class="form-control" rows="2"><?php echo e($join_delivery_man_sub_title_translate[$lang]['value'] ?? ''); ?></textarea>
                                        </div>
                                    </div>
                                    <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label for="join_delivery_man_title"
                                            class="form-label"><?php echo e(translate('Title')); ?><span
                                                class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                                                data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                    alt="">
                                            </span></label>
                                        <input id="join_delivery_man_title" type="text" maxlength="20"
                                            name="join_delivery_man_title[]" class="form-control"
                                            placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="join_delivery_man_sub_title"
                                            class="form-label"><?php echo e(translate('Sub Title')); ?><span
                                                class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                                                data-original-title="<?php echo e(translate('Write_the_title_within_60_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                    alt="">
                                            </span></label>
                                        <input id="join_delivery_man_sub_title" type="text" maxlength="60"
                                            name="join_delivery_man_sub_title[]" class="form-control"
                                            placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="join_delivery_man_button_name"
                                            class="form-label"><?php echo e(translate('Button Name')); ?><span
                                                class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                                                data-original-title="<?php echo e(translate('Write_the_title_within_15_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                    alt="">
                                            </span></label>
                                        <input id="join_delivery_man_button_name" type="text" maxlength="15"
                                            name="join_delivery_man_button_name[]" class="form-control"
                                            placeholder="<?php echo e(translate('messages.button_name_here...')); ?>">
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


            </div>
        </div>

        <!-- How it Works -->
        <?php echo $__env->make('admin-views.business-settings.landing-page-settings.partial.how-it-work-flutter', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/landing-page-settings/flutter-landing-page-join-as.blade.php ENDPATH**/ ?>