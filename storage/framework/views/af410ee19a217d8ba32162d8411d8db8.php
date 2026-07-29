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
        <div class="card py-3 px-xxl-4 px-3 mb-20">
            <div class="d-flex flex-sm-nowrap flex-wrap gap-3 align-items-center justify-content-between">
                <div class="">
                    <h3 class="mb-1"><?php echo e(translate('Seller App Download Section')); ?></h3>
                    <p class="mb-0 gray-dark fs-12">
                        <?php echo e(translate('See how your Seller App Download Section will look to customers.')); ?>

                    </p>
                </div>
                <div class="max-w-300px ml-sm-auto">
                    <button type="button" class="btn btn-outline-primary py-2 fs-12 px-3 offcanvas-trigger" data-target="#seller-downloadApp_section">
                        <i class="tio-invisible"></i> <?php echo e(translate('Section Preview')); ?>

                    </button>
                </div>
            </div>
        </div>

        <?php ($download_seller_app_section_status = \App\Models\DataSetting::where('type', 'react_landing_page')->where('key', "download_seller_app_section_status")->first()); ?>
        <div class="card py-3 px-xxl-4 px-3 mb-15 mt-4">
            <div class="row g-3 align-items-center justify-content-between">
                <div class="col-xxl-9 col-lg-8 col-md-7 col-sm-6">
                    <div class="">
                        <h3 class="mb-1"><?php echo e(translate('Show Seller App Download Section')); ?></h3>
                        <p class="mb-0 gray-dark fs-12">
                            <?php echo e(translate('If you turn of the availability status, this section will not show in the website')); ?>

                        </p>
                    </div>
                </div>
                <div class="col-xxl-3 col-lg-4 col-md-5 col-sm-6">
                    <div class="py-2 px-3 rounded d-flex justify-content-between border align-items-center w-300">
                        <h5 class="text-capitalize fw-normal mb-0"><?php echo e(translate('Status')); ?></h5>

                        <form
                            action="<?php echo e(route('admin.business-settings.statusUpdate', ['type' => 'react_landing_page', 'key' => 'download_seller_app_section_status'])); ?>"
                            method="get" id="CheckboxStatus_form">
                        </form>
                        <label class="toggle-switch toggle-switch-sm" for="CheckboxStatus">
                            <input type="checkbox" data-id="CheckboxStatus" data-type="status"
                                   data-image-on="<?php echo e(asset('/public/assets/admin/img/status-ons.png')); ?>"
                                   data-image-off="<?php echo e(asset('/public/assets/admin/img/off-danger.png')); ?>"
                                   data-title-on="<?php echo e(translate('Do you want turn on this section ?')); ?>"
                                   data-title-off="<?php echo e(translate('Do you want to turn off this section ?')); ?>"
                                   data-text-on="<p><?php echo e(translate('If you turn on this section will be show in react landing page.')); ?>"
                                   data-text-off="<p><?php echo e(translate('If you turn off this section will not be show in react landing page.')); ?></p>"
                                   class="toggle-switch-input  status dynamic-checkbox" id="CheckboxStatus"
                                <?php echo e($download_seller_app_section_status?->value ? 'checked' : ''); ?>>
                            <span class="toggle-switch-label text">
                                <span class="toggle-switch-indicator"></span>
                            </span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-20">
            <form class="custom-validation" action="<?php echo e(route('admin.business-settings.react-landing-page-settings', 'download-seller-app-section')); ?>"
                  method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="card-body">
                    <div class="mb-20">
                        <h3 class="mb-1"><?php echo e(translate('Seller App Download Section Content ')); ?></h3>
                        <p class="mb-0 fs-12"><?php echo e(translate('Encourage users to download the app for a seamless experience and instant access.')); ?></p>
                    </div>
                    <?php ($language = App\CentralLogics\Helpers::get_business_settings('language')); ?>
                    <?php ($download_seller_app_title = \App\Models\DataSetting::withoutGlobalScope('translate')->where('type', 'react_landing_page')->where('key', 'download_seller_app_title')->first()); ?>
                    <?php ($download_seller_app_sub_title = \App\Models\DataSetting::withoutGlobalScope('translate')->where('type', 'react_landing_page')->where('key', 'download_seller_app_sub_title')->first()); ?>
                    <?php ($download_seller_app_button_title = \App\Models\DataSetting::withoutGlobalScope('translate')->where('type', 'react_landing_page')->where('key', 'download_seller_app_button_title')->first()); ?>
                    <?php ($download_seller_app_image = \App\Models\DataSetting::withoutGlobalScope('translate')->where('type', 'react_landing_page')->where('key', 'download_seller_app_image')->first()); ?>

                    <div class="row g-3">
                        <div class="col-lg-8">
                            <div class="bg--secondary rounded h-100 p-xxl-4 p-3">
                                <?php if($language): ?>
                                    <ul class="nav nav-tabs mb-4 border-bottom">
                                        <li class="nav-item">
                                            <a class="nav-link lang_link active" href="#"
                                               id="default-link"><?php echo e(translate('messages.default')); ?></a>
                                        </li>
                                        <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="nav-item">
                                                <a class="nav-link lang_link" href="#"
                                                   id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php endif; ?>
                                <div class="row g-3">
                                    <?php if($language): ?>
                                        <div class="col-md-12 lang_form default-form">
                                            <div class="row g-1">
                                                <div class="col-12">
                                                    <label for="download_seller_app_title" class="form-label"><?php echo e(translate('Title')); ?>

                                                        (<?php echo e(translate('messages.default')); ?>)
                                                        <span class="form-label-secondary" data-toggle="tooltip"
                                                              data-placement="right"
                                                              data-original-title="<?php echo e(translate('Write_the_title_within_100_characters')); ?>">
                                                        <i class="tio-info color-A7A7A7"></i>
                                                    </span><span class="form-label-secondary text-danger"
                                                                 data-toggle="tooltip" data-placement="right"
                                                                 data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                    </span>
                                                    </label>
                                                    <input id="download_seller_app_title" type="text" maxlength="100"
                                                           name="download_seller_app_title[]"
                                                           value="<?php echo e($download_seller_app_title?->getRawOriginal('value') ?? ''); ?>"
                                                           class="form-control"
                                                           placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                                    <span
                                                        class="text-right text-counting color-A7A7A7 d-block mt-1">0/100</span>
                                                </div>
                                                <div class="col-12">
                                                    <label for="download_seller_app_sub_title"
                                                           class="form-label"><?php echo e(translate('Sub Title')); ?>

                                                        (<?php echo e(translate('messages.default')); ?>)
                                                        <span class="form-label-secondary" data-toggle="tooltip"
                                                              data-placement="right"
                                                              data-original-title="<?php echo e(translate('Write_the_sub_title_within_200_characters')); ?>">
                                                        <i class="tio-info color-A7A7A7"></i>
                                                    </span><span class="form-label-secondary text-danger"
                                                                 data-toggle="tooltip" data-placement="right"
                                                                 data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                    </span>
                                                    </label>
                                                    <textarea id="download_seller_app_sub_title" rows="2" type="text" maxlength="200"
                                                              name="download_seller_app_sub_title[]" class="form-control"
                                                              placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>"><?php echo e($download_seller_app_sub_title?->getRawOriginal('value') ?? ''); ?></textarea>
                                                    <span
                                                        class="text-right text-counting color-A7A7A7 d-block mt-1">0/200</span>
                                                </div>
                                                <div class="col-12">
                                                    <label for="download_seller_app_button_title"
                                                           class="form-label"><?php echo e(translate('Button Name')); ?>

                                                        (<?php echo e(translate('messages.default')); ?>)
                                                        <span class="form-label-secondary" data-toggle="tooltip"
                                                              data-placement="right"
                                                              data-original-title="<?php echo e(translate('Write_the_button_name_within_20_characters')); ?>">
                                                        <i class="tio-info color-A7A7A7"></i>
                                                    </span><span class="form-label-secondary text-danger"
                                                                 data-toggle="tooltip" data-placement="right"
                                                                 data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                    </span>
                                                    </label>
                                                    <input id="download_seller_app_button_title" type="text" maxlength="20"
                                                           name="download_seller_app_button_title[]"
                                                           value="<?php echo e($download_seller_app_button_title?->getRawOriginal('value') ?? ''); ?>"
                                                           class="form-control"
                                                           placeholder="<?php echo e(translate('messages.Button Name')); ?>">
                                                    <span class="text-right text-counting color-A7A7A7 d-block mt-1">0/20</span>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="lang[]" value="default">
                                        <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                $download_seller_app_title_translate = [];
                                                $download_seller_app_sub_title_translate = [];
                                                $download_seller_app_button_title_translate = [];

                                                if (isset($download_seller_app_title->translations) && count($download_seller_app_title->translations)) {
                                                    foreach ($download_seller_app_title->translations as $t) {
                                                        if ($t->locale == $lang && $t->key == 'download_seller_app_title') {
                                                            $download_seller_app_title_translate[$lang]['value'] = $t->value;
                                                        }
                                                    }
                                                }

                                                if (isset($download_seller_app_sub_title->translations) && count($download_seller_app_sub_title->translations)) {
                                                    foreach ($download_seller_app_sub_title->translations as $t) {
                                                        if ($t->locale == $lang && $t->key == 'download_seller_app_sub_title') {
                                                            $download_seller_app_sub_title_translate[$lang]['value'] = $t->value;
                                                        }
                                                    }
                                                }

                                                if (isset($download_seller_app_button_title->translations) && count($download_seller_app_button_title->translations)) {
                                                    foreach ($download_seller_app_button_title->translations as $t) {
                                                        if ($t->locale == $lang && $t->key == 'download_seller_app_button_title') {
                                                            $download_seller_app_button_title_translate[$lang]['value'] = $t->value;
                                                        }
                                                    }
                                                }
                                                ?>
                                            <div class="col-md-12 d-none lang_form" id="<?php echo e($lang); ?>-form">
                                                <div class="row g-1">
                                                    <div class="col-12">
                                                        <label for="download_seller_app_title<?php echo e($lang); ?>"
                                                               class="form-label"><?php echo e(translate('Title')); ?>

                                                            (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary"
                                                                                         data-toggle="tooltip" data-placement="right"
                                                                                         data-original-title="<?php echo e(translate('Write_the_title_within_100_characters')); ?>">
                                                                                    <i class="tio-info color-A7A7A7"></i>
                                                                                </span>
                                                        </label>
                                                        <input id="download_seller_app_title<?php echo e($lang); ?>" type="text" maxlength="100"
                                                               name="download_seller_app_title[]"
                                                               value="<?php echo e($download_seller_app_title_translate[$lang]['value'] ?? ''); ?>"
                                                               class="form-control"
                                                               placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                                        <span
                                                            class="text-right text-counting color-A7A7A7 d-block mt-1">0/100</span>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="download_seller_app_sub_title<?php echo e($lang); ?>"
                                                               class="form-label"><?php echo e(translate('Sub Title')); ?>

                                                            (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary"
                                                                                         data-toggle="tooltip" data-placement="right"
                                                                                         data-original-title="<?php echo e(translate('Write_the_sub_title_within_200_characters')); ?>">
                                                                                    <i class="tio-info color-A7A7A7"></i>
                                                                                </span>
                                                        </label>
                                                        <textarea id="download_seller_app_sub_title<?php echo e($lang); ?>" rows="2" type="text"
                                                                  maxlength="200" name="download_seller_app_sub_title[]" class="form-control"
                                                                  placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>"><?php echo e($download_seller_app_sub_title_translate[$lang]['value'] ?? ''); ?></textarea>
                                                        <span
                                                            class="text-right text-counting color-A7A7A7 d-block mt-1">0/200</span>
                                                    </div>

                                                    <div class="col-12">
                                                        <label for="download_seller_app_button_title<?php echo e($lang); ?>"
                                                               class="form-label"><?php echo e(translate('Button Name')); ?>

                                                            (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary"
                                                                                         data-toggle="tooltip" data-placement="right"
                                                                                         data-original-title="<?php echo e(translate('Write_the_button_name_within_20_characters')); ?>">
                                                                                    <i class="tio-info color-A7A7A7"></i>
                                                                                </span>
                                                        </label>
                                                        <input id="download_seller_app_button_title<?php echo e($lang); ?>" type="text" maxlength="20"
                                                               name="download_seller_app_button_title[]"
                                                               value="<?php echo e($download_seller_app_button_title_translate[$lang]['value'] ?? ''); ?>"
                                                               class="form-control"
                                                               placeholder="<?php echo e(translate('messages.Button Name')); ?>">
                                                        <span
                                                            class="text-right text-counting color-A7A7A7 d-block mt-1">0/200</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <div class="col-12">
                                            <div class="mb-2">
                                                <label for="download_seller_app_title" class="form-label"><?php echo e(translate('Title')); ?></label>
                                                <input id="download_seller_app_title" maxlength="100" type="text" name="download_seller_app_title[]"
                                                       class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                                <span class="text-right text-counting color-A7A7A7 d-block mt-1">0/100</span>
                                            </div>
                                            <div class="mb-4">
                                                <label for="download_seller_app_sub_title"
                                                       class="form-label"><?php echo e(translate('Sub Title')); ?></label>
                                                <textarea id="download_seller_app_sub_title" rows="2" type="text" maxlength="200"
                                                          name="download_seller_app_sub_title[]" class="form-control"
                                                          placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>"></textarea>
                                                <span class="text-right text-counting color-A7A7A7 d-block mt-1">0/200</span>
                                            </div>
                                            <div class="mb-4">
                                                <label for="download_seller_app_button_title"
                                                       class="form-label"><?php echo e(translate('Sub Title')); ?></label>
                                                <input id="download_seller_app_button_title" maxlength="20" type="text"
                                                       name="download_seller_app_button_title[]" class="form-control"
                                                       placeholder="<?php echo e(translate('messages.Button Name')); ?>">
                                                <span class="text-right text-counting color-A7A7A7 d-block mt-1">0/200</span>
                                            </div>
                                        </div>
                                        <input type="hidden" name="lang[]" value="default">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="bg--secondary h-100 rounded p-md-4 p-3 d-center">
                                <div class="text-center">
                                    <div class="mb-4">
                                        <h5 class="mb-1"><?php echo e(translate('Upload Image')); ?></h5>
                                        <p class="mb-0 fs-12 gray-dark">
                                            <?php echo e(translate('Upload your Seller App Download Section  Image')); ?>

                                        </p>
                                    </div>
                                    <div class="mx-auto text-center error-wrapper">
                                        <div class="upload-file_custom ratio-1 h-100px">
                                            <input type="file" name="download_seller_app_image"
                                                   class="upload-file__input single_file_input"
                                                   accept=".webp, .jpg, .jpeg, .png, .gif" <?php echo e($download_seller_app_image?->value ? '' : 'required'); ?>>
                                            <label class="upload-file__wrapper w-100 h-100 m-0">
                                                <div class="upload-file-textbox text-center"
                                                     style="<?php echo e($download_seller_app_image?->value ? 'display: none;' : ''); ?>">
                                                    <img width="22" class="svg"
                                                         src="<?php echo e(asset('public/assets/admin/img/document-upload.svg')); ?>"
                                                         alt="img">
                                                    <h6 class="mt-1 color-656566 fw-medium fs-10 lh-base text-center">
                                                        <span class="theme-clr">Click to upload</span>
                                                        <br>
                                                        Or drag and drop
                                                    </h6>
                                                </div>
                                                <img class="upload-file-img" loading="lazy" src="<?php echo e($download_seller_app_image?->value
    ? \App\CentralLogics\Helpers::get_full_url('download_seller_app_section', $download_seller_app_image->value, $download_seller_app_image->storage[0]?->value ?? 'public', 'aspect_1')
    : ''); ?>" data-default-src="<?php echo e($download_seller_app_image?->value
    ? \App\CentralLogics\Helpers::get_full_url('download_seller_app_section', $download_seller_app_image->value, $download_seller_app_image->storage[0]?->value ?? 'public', 'aspect_1')
    : ''); ?>" alt="">
                                            </label>
                                            <div class="overlay">
                                                <div
                                                    class="d-flex gap-1 justify-content-center align-items-center h-100">
                                                    <button type="button"
                                                            class="btn btn-outline-info icon-btn view_btn">
                                                        <i class="tio-invisible"></i>
                                                    </button>
                                                    <button type="button"
                                                            class="btn btn-outline-info icon-btn edit_btn">
                                                        <i class="tio-edit"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <p class="fs-10 text-center mb-0 mt-lg-4 mt-3">
                                        <?php echo e(translate('JPG, JPEG, PNG size : Max 2 MB')); ?> <span
                                            class="font-medium text-title"><?php echo e(translate('(1:1)')); ?></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn--container justify-content-end mt-20">
                        <button type="reset" class="btn btn--reset mb-2"><?php echo e(translate('Reset')); ?></button>
                        <button type="submit"   class="btn btn--primary mb-2"><?php echo e(translate('Save')); ?></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade show active">
                <?php ($download_seller_app_main_button_title = \App\Models\DataSetting::withoutGlobalScope('translate')->where('type', 'react_landing_page')->where('key', 'download_seller_app_main_button_title')->first()); ?>
                <?php ($download_seller_app_main_button_sub_title = \App\Models\DataSetting::withoutGlobalScope('translate')->where('type', 'react_landing_page')->where('key', 'download_seller_app_main_button_sub_title')->first()); ?>
                <?php ($download_seller_app_links = \App\Models\DataSetting::where(['key'=>'download_seller_app_links','type'=>'react_landing_page'])->first()); ?>
                <?php ($download_seller_app_links_data = isset($download_seller_app_links->value) ? json_decode($download_seller_app_links->value, true) : []); ?>
                <form action="<?php echo e(route('admin.business-settings.react-landing-page-settings', 'download-seller-app-button-section')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-20">
                                <h3 class="mb-1"><?php echo e(translate('Seller App Download Section Button ')); ?></h3>
                                <p class="mb-0 fs-12"><?php echo e(translate('Manage mobile app download area including QR codes and app store buttons.')); ?></p>
                            </div>
                            <div class="bg--secondary rounded p-xxl-4 p-3 mb-20">
                                <?php if($language): ?>
                                    <ul class="nav nav-tabs mb-4 border-0">
                                        <li class="nav-item">
                                            <a class="nav-link lang_link active" href="#"
                                               id="default-link"><?php echo e(translate('messages.default')); ?></a>
                                        </li>
                                        <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="nav-item">
                                                <a class="nav-link lang_link" href="#"
                                                   id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php endif; ?>
                                <div class="row g-4">
                                    <div class="col-12">
                                        <?php if($language): ?>
                                            <div class="col-md-12 lang_form default-form">
                                                <div class="row g-1">
                                                    <div class="col-12">
                                                        <label for="download_seller_app_main_button_title" class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(translate('messages.default')); ?>)
                                                            <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_100_characters')); ?>">
                                                    <i class="tio-info color-A7A7A7"></i>
                                                </span><span class="form-label-secondary text-danger"
                                                             data-toggle="tooltip" data-placement="right"
                                                             data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                </span>

                                                        </label>
                                                        <input id="download_seller_app_main_button_title" type="text"  maxlength="100" name="download_seller_app_main_button_title[]" value="<?php echo e($download_seller_app_main_button_title?->getRawOriginal('value')??''); ?>" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                                        <span class="text-right text-counting color-A7A7A7 d-block mt-1">0/100</span>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="download_seller_app_main_button_sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?> (<?php echo e(translate('messages.default')); ?>)
                                                            <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_sub_title_within_200_characters')); ?>">
                                                    <i class="tio-info color-A7A7A7"></i>
                                                </span><span class="form-label-secondary text-danger"
                                                             data-toggle="tooltip" data-placement="right"
                                                             data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                </span>

                                                        </label>
                                                        <input id="$download_seller_app_main_button_sub_title" type="text"  maxlength="200" name="download_seller_app_main_button_sub_title[]" value="<?php echo e($download_seller_app_main_button_sub_title?->getRawOriginal('value')??''); ?>" class="form-control" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                                        <span class="text-right text-counting color-A7A7A7 d-block mt-1">0/200</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="lang[]" value="default">
                                            <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                    if(isset($download_seller_app_main_button_title->translations)&&count($download_seller_app_main_button_title->translations)){
                                                        $download_seller_app_main_button_title_translate = [];
                                                        foreach($download_seller_app_main_button_title->translations as $t)
                                                        {
                                                            if($t->locale == $lang && $t->key=='download_seller_app_main_button_title'){
                                                                $download_seller_app_main_button_title_translate[$lang]['value'] = $t->value;
                                                            }
                                                        }

                                                    }
                                                    if(isset($download_seller_app_main_button_sub_title->translations)&&count($download_seller_app_main_button_sub_title->translations)){
                                                        $download_seller_app_main_button_sub_title_translate = [];
                                                        foreach($download_seller_app_main_button_sub_title->translations as $t)
                                                        {
                                                            if($t->locale == $lang && $t->key=='download_seller_app_main_button_sub_title'){
                                                                $download_seller_app_main_button_sub_title_translate[$lang]['value'] = $t->value;
                                                            }
                                                        }

                                                    }
                                                    ?>
                                                <div class="col-md-12 d-none lang_form" id="<?php echo e($lang); ?>-form1">
                                                    <div class="row g-1">
                                                        <div class="col-12">
                                                            <label for="download_seller_app_main_button_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_100_characters')); ?>">
                                                    <i class="tio-info color-A7A7A7"></i>
                                                </span></label>
                                                            <input id="download_seller_app_main_button_title<?php echo e($lang); ?>" type="text"  maxlength="100" name="download_seller_app_main_button_title[]" value="<?php echo e($download_seller_app_main_button_title_translate[$lang]['value']??''); ?>" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                                            <span class="text-right text-counting color-A7A7A7 d-block mt-1">0/100</span>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="download_seller_app_main_button_sub_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Sub Title')); ?> (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_sub_title_within_200_characters')); ?>">
                                                    <i class="tio-info color-A7A7A7"></i>
                                                </span></label>
                                                            <input type="text" id="download_seller_app_main_button_sub_title<?php echo e($lang); ?>" maxlength="200" name="download_seller_app_main_button_sub_title[]" value="<?php echo e($download_seller_app_main_button_sub_title_translate[$lang]['value']??''); ?>" class="form-control" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                                            <span class="text-right text-counting color-A7A7A7 d-block mt-1">0/200</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <div class="col-md-12">
                                                <div class="row g-1">
                                                    <div class="col-12">
                                                        <label for="download_seller_app_main_button_title" class="form-label"><?php echo e(translate('Title')); ?></label>
                                                        <input type="text" id="download_seller_app_main_button_title" name="download_seller_app_main_button_title[]" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="download_seller_app_main_button_sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?></label>
                                                        <input id="download_seller_app_main_button_sub_title" type="text" name="download_seller_app_main_button_sub_title[]" class="form-control" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="lang[]" value="default">
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="bg--secondary rounded p-xxl-4 p-3">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="bg-white rounded p-xxl-4 p-2">
                                            <div class="d-flex mb-20 align-items-center gap-2 flex-wrap justify-content-between">
                                                <h4 class="mb-0">
                                                    <img src="<?php echo e(asset('public/assets/admin/img/playstore.png')); ?>" class="mr-2" alt="">
                                                    <?php echo e(translate('Playstore Button')); ?>

                                                </h4>
                                                <label class="toggle-switch toggle-switch-sm m-0">
                                                    <input type="checkbox" name="seller_playstore_url_status"
                                                           id="play-store-dm-status"
                                                           data-id="play-store-dm-status"
                                                           data-type="toggle"
                                                           data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/play-store-on.png')); ?>"
                                                           data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/play-store-off.png')); ?>"
                                                           data-title-on="<?php echo e(translate('want_to_enable_the_play_store_button_for_user_app')); ?>"
                                                           data-title-off="<?php echo e(translate('want_to_disable_the_play_store_button_for_user_app')); ?>"
                                                           data-text-on="<p><?php echo e(translate('if_enabled,_the_user_app_download_button_will_be_visible_on_react_landing_page')); ?></p>"
                                                           data-text-off="<p><?php echo e(translate('if_disabled,_this_button_will_be_hidden_from_the_react_landing_page')); ?></p>"
                                                           class="status toggle-switch-input dynamic-checkbox-toggle"

                                                           value="1" <?php echo e((isset($download_seller_app_links_data['playstore_url_status']) && $download_seller_app_links_data['playstore_url_status'])?'checked':''); ?>>
                                                    <span class="toggle-switch-label text mb-0">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                                </label>
                                            </div>
                                            <div class="__bg-F8F9FC-card">
                                                <div class="form-group mb-md-0">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <label for="playstore_url" class="form-label text-capitalize m-0">
                                                            <?php echo e(translate('Download Link')); ?>

                                                            <span class="input-label-secondary text--title" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('When_disabled,_the_Play_Store_download_button_will_be_hidden_from_the_React_landing_page.')); ?>">
                                                            <i class="tio-info color-A7A7A7"></i>
                                                        </span>
                                                        </label>
                                                    </div>
                                                    <input type="url"
                                                           <?php echo e((isset($download_seller_app_links_data['playstore_url_status']) && $download_seller_app_links_data['playstore_url_status'])?'required':''); ?>

                                                           id="playstore_url"
                                                           placeholder="<?php echo e(translate('Ex: https://play.google.com/store/apps')); ?>"
                                                           class="form-control h--45px"
                                                           name="seller_playstore_url"
                                                           value="<?php echo e($download_seller_app_links_data['playstore_url'] ?? ''); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="bg-white rounded p-xxl-4 p-2">
                                            <div class="d-flex mb-20 align-items-center gap-2 flex-wrap justify-content-between">
                                                <h4 class="m-0">
                                                    <img src="<?php echo e(asset('public/assets/admin/img/ios.png')); ?>" class="mr-2" alt="">
                                                    <?php echo e(translate('App Store Button')); ?>

                                                </h4>
                                                <label class="toggle-switch toggle-switch-sm m-0">
                                                    <input type="checkbox" name="seller_apple_store_url_status"
                                                           data-id="apple-dm-status"
                                                           data-type="toggle"
                                                           data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/apple-on.png')); ?>"
                                                           data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/apple-off.png')); ?>"
                                                           data-title-on="<?php echo e(translate('want_to_enable_the_app_store_button_for_user_app')); ?>"
                                                           data-title-off="<?php echo e(translate('want_to_disable_the_app_store_button_for_user_app')); ?>"
                                                           data-text-on="<p><?php echo e(translate('if_enabled,_the_user_app_download_button_will_be_visible_on_react_landing_page')); ?></p>"
                                                           data-text-off="<p><?php echo e(translate('if_disabled,_this_button_will_be_hidden_from_the_react_landing_page')); ?></p>"
                                                           class="status toggle-switch-input dynamic-checkbox-toggle"
                                                           id="apple-dm-status"  value="1" <?php echo e((isset($download_seller_app_links_data['apple_store_url_status']) && $download_seller_app_links_data['apple_store_url_status'])?'checked':''); ?>>
                                                    <span class="toggle-switch-label text mb-0">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                                </label>
                                            </div>
                                            <div class="__bg-F8F9FC-card">
                                                <div class="form-group mb-md-0">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <label for="apple_store_url" class="form-label text-capitalize m-0">
                                                            <?php echo e(translate('Download Link')); ?>

                                                            <span class="input-label-secondary text--title" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('When_disabled,_the_User_app_download_button_will_be_hidden_on_React_Landing_page.')); ?>">
                                                            <i class="tio-info color-A7A7A7"></i>
                                                        </span>
                                                        </label>
                                                    </div>
                                                    <input type="url"
                                                           id="apple_store_url"
                                                           <?php echo e((isset($download_seller_app_links_data['apple_store_url_status']) && $download_seller_app_links_data['apple_store_url_status'])?'required':''); ?>

                                                           placeholder="<?php echo e(translate('Ex: https://www.apple.com/app-store/')); ?>"
                                                           class="form-control h--45px"
                                                           name="seller_apple_store_url"
                                                           value="<?php echo e($download_seller_app_links_data['apple_store_url'] ?? ''); ?>">
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

            </div>
        </div>
    </div>



    <!-- Section View Offcanvas here -->
    <div id="seller-downloadApp_section" class="custom-offcanvas offcanvas-750 offcanvas-xxl-1120 d-flex flex-column justify-content-between">
        <form action="<?php echo e(route('taxvat.store')); ?>" method="post">
            <div>
                <div class="custom-offcanvas-header bg--secondary d-flex justify-content-between align-items-center px-3 py-3">
                    <div class="py-1">
                        <h3 class="mb-0 line--limit-1"><?php echo e(translate('messages.Seller App Download Section Preview')); ?></h3>
                    </div>
                    <button type="button" class="btn-close w-25px h-25px border rounded-circle d-center bg--secondary text-dark offcanvas-close fz-15px p-0"aria-label="Close">
                        &times;
                    </button>
                </div>
                <div class="custom-offcanvas-body custom-offcanvas-body-100  p-20">
                    <section class="common-section-view bg-white border rounded-10 my-xl-2 mx-xl-2">
                        <div class="common-section-inner d-flex flex-xxl-nowrap justify-content-lg-between justify-content-center flex-wrap align-items-center gap-x-xl-20">
                            <div class="d-flex align-items-center flex-md-nowrap flex-wrap gap-x-xl-20 max-w-490 mb-xxl-0 mb-3 text-md-start text-center">
                                <div class="selling-thumb min-w-150 max-w-165 mr-xl-0 mr-md-3 mx-auto">
                                    <img width="160" src="<?php echo e($download_seller_app_image?->value
    ? \App\CentralLogics\Helpers::get_full_url('download_seller_app_section', $download_seller_app_image->value, $download_seller_app_image->storage[0]?->value ?? 'public', 'aspect_1')
    :asset('/public/assets/admin/img/400x400/selling-thumb.png')); ?>" alt="Google Play" class="object-contain h-100">
                                </div>
                                <div class="mt-xl-0 mt-2">
                                    <h2 class="mb-xxl-2 mb-1 fs-20">
                                        <?php echo \App\CentralLogics\Helpers::highlightWords($download_seller_app_title?->value ?? 'Start Selling with $6amMart$'); ?>

                                    </h2>
                                    <p class="text-title fs-12 mb-xl-3 mb-3">
                                        <?php echo e($download_seller_app_sub_title?->value ?? 'Turn your local shop into an online business and grow your sales with our powerful platform'); ?>

                                    </p>
                                    <a href="#0" class="btn btn-primary-white base-bg-cmn fs-12 text-white fw-medium">
                                        <?php echo e($download_seller_app_button_title?->value ?? 'Start Selling'); ?> <i class="tio-arrow-forward pl-1 text-white"></i>
                                    </a>
                                </div>
                            </div>
                            <div>
                                <div class="__bg-FAFAFA rounded-10 px-xl-3 px-1 py-3 d-flex flex-xl-nowrap flex-wrap justify-content-xl-start justify-content-center align-items-center gap-x-xl-20">
                                    <div class="scan-wrap bg-white max-w-138 rounded px-xl-2 px-1 py-3 mb-xl-0 mb-3 w-xl-auto w-100">
                                        <div class="scan d-center border w-80px h-80px mx-auto rounded p-1">
                                            <img src="<?php echo e(asset('/public/assets/admin/img/400x400/app-scan.png')); ?>" alt="Google Play" class="object-cover w-100 h-100">
                                        </div>
                                        <p class="mb-0 fs-12 mt-1 text-center"><?php echo e(translate('messages.Scan to DownLoad')); ?></p>
                                    </div>
                                    <div>
                                        <div class="mb-3 text-xl-start text-center">
                                            <h4 class="mb-0"><?php echo e($download_seller_app_main_button_title?->value ?? 'Download the Seller App'); ?></h4>
                                            <p class="mb-0 fs-12"><?php echo e($download_seller_app_main_button_sub_title?->value ?? 'Stay in control, wherever you are.'); ?></p>
                                        </div>
                                        <div class="d-flex justify-content-sm-start justify-content-center flex-sm-nowrap flex-wrap align-items-center gap-x-xl-10 app-manage">
                                            <!-- Google Play Button -->
                                            <a href="#" class="btn btn-primary d-flex align-items-center mr-2 px-3 py-2 bg-000 rounded mb-sm-0 mb-1">
                                                <img width="24" height="24" src="<?php echo e(asset('/public/assets/admin/img/icons/playstore.png')); ?>" alt="Google Play" class="mr-1">
                                                <div class="text-left">
                                                    <small class="d-block text-white mb-0 fs-12">GET IT ON</small>
                                                    <strong class="d-block text-white fs-14">Google Play</strong>
                                                </div>
                                            </a>
                                            <a href="#" class="btn btn-primary d-flex align-items-center px-3 py-2 bg-000 rounded">
                                                <img width="24" height="24" src="<?php echo e(asset('/public/assets/admin/img/icons/apple-icon.png')); ?>" alt="App Store" class="mr-1">
                                                <div class="text-left">
                                                    <small class="d-block text-white mb-0 fs-12">Download ON</small>
                                                    <strong class="d-block text-white fs-14">App Store</strong>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </form>
    </div>

    <div id="offcanvasOverlay" class="offcanvas-overlay"></div>
    <!-- Section View Offcanvas end -->



    <!-- How it Works -->
    <?php echo $__env->make('admin-views.business-settings.landing-page-settings.partial.how-it-work-react', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin/ckeditor/ckeditor.js')); ?>"></script>
    <script>
        "use strict";
        $(document).ready(function () {
            $('.ckeditor').ckeditor();
        });

        document.addEventListener('DOMContentLoaded', function () {
            var removeBtn = document.getElementById('remove_image_btn');
            var removeFlag = document.getElementById('image_remove');
            var fileInput = document.querySelector('input[name="download_seller_app_image"]');
            var form = fileInput ? fileInput.closest('form') : null;

            if (removeBtn && removeFlag) {
                removeBtn.addEventListener('click', function () {
                    removeFlag.value = '1';
                    if (fileInput) {
                        fileInput.removeAttribute('disabled');
                        fileInput.setAttribute('required', 'required');
                        fileInput.value = ''; // clear any previous file reference
                        fileInput.closest('.upload-file__wrapper').querySelector('.upload-file-textbox').style.display = 'block';
                    }
                });
            }

            if (form && removeFlag) {
                form.addEventListener('reset', function () {
                    removeFlag.value = '0';
                });
            }

            if (fileInput && removeFlag) {
                fileInput.addEventListener('change', function () {
                    removeFlag.value = '0';
                });
            }
        });
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/business-settings/landing-page-settings/react-landing-page-download-seller-app.blade.php ENDPATH**/ ?>