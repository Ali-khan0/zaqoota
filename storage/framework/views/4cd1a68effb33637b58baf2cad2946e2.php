<?php $__env->startSection('title', translate('messages.react_landing_page')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<?php $__env->stopPush(); ?>

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

        <div class="mb-20 mt-2">
            <div class="js-nav-scroller hs-nav-scroller-horizontal">
                <?php echo $__env->make('admin-views.business-settings.landing-page-settings.top-menu-links.react-landing-page-links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
        <div class="card py-3 px-xxl-4 px-3 mb-20">
            <div class="d-flex flex-sm-nowrap flex-wrap gap-3 align-items-center justify-content-between">
                <div class="">
                    <h3 class="mb-1"><?php echo e(translate('Trust Section')); ?></h3>
                    <p class="mb-0 gray-dark fs-12">
                        <?php echo e(translate('See how your Trust Section will look to customers.')); ?>

                    </p>
                </div>
                <div class="max-w-300px ml-sm-auto">
                    <button type="button" class="btn btn-outline-primary py-2 fs-12 px-3 offcanvas-trigger"
                            data-target="#trust_section">
                        <i class="tio-invisible"></i> <?php echo e(translate('Section Preview')); ?>

                    </button>
                </div>
            </div>
        </div>
        <?php ($trust_section_status = \App\Models\DataSetting::where('type', 'react_landing_page')->where('key', "trust_section_status")->first()); ?>
        <div class="card py-3 px-xxl-4 px-3 mb-15 mt-4">
            <div class="row g-3 align-items-center justify-content-between">
                <div class="col-xxl-9 col-lg-8 col-md-7 col-sm-6">
                    <div class="">
                        <h3 class="mb-1"><?php echo e(translate('Show Trust Section')); ?></h3>
                        <p class="mb-0 gray-dark fs-12">
                            <?php echo e(translate('If you turn of the availability status, this section will not show in the website')); ?>

                        </p>
                    </div>
                </div>
                <div class="col-xxl-3 col-lg-4 col-md-5 col-sm-6">
                    <div class="py-2 px-3 rounded d-flex justify-content-between border align-items-center w-300">
                        <h5 class="text-capitalize fw-normal mb-0"><?php echo e(translate('Status')); ?></h5>

                        <form
                            action="<?php echo e(route('admin.business-settings.statusUpdate', ['type' => 'react_landing_page', 'key' => 'trust_section_status'])); ?>"
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
                                <?php echo e($trust_section_status?->value ? 'checked' : ''); ?>>
                            <span class="toggle-switch-label text">
                                <span class="toggle-switch-indicator"></span>
                            </span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <?php ($numCards = 4); ?>
        <?php
        function ordinalSuffix($number): string
        {
            if (!in_array($number % 100, [11, 12, 13])) {
                switch ($number % 10) {
                    case 1:
                        return $number . 'st';
                    case 2:
                        return $number . 'nd';
                    case 3:
                        return $number . 'rd';
                }
            }
            return $number . 'th';
        }
        ?>

        <div class="row g-3">
            <?php for($i = 1; $i <= $numCards; $i++): ?>
                <div class="col-md-6">
                    <form class="custom-validation"
                          action="<?php echo e(route('admin.business-settings.react-landing-page-settings', 'trust-section-card-' . $i)); ?>"
                          method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php ($language = App\CentralLogics\Helpers::get_business_settings('language')); ?>
                        <?php ($trust_status = \App\Models\DataSetting::where('type', 'react_landing_page')->where('key', "trust_status_card_$i")->first()); ?>
                        <?php ($trust_title = \App\Models\DataSetting::withoutGlobalScope('translate')->where('type', 'react_landing_page')->where('key', "trust_title_card_$i")->first()); ?>
                        <?php ($trust_sub_title = \App\Models\DataSetting::withoutGlobalScope('translate')->where('type', 'react_landing_page')->where('key', "trust_sub_title_card_$i")->first()); ?>
                        <?php ($trust_image = \App\Models\DataSetting::where('type', 'react_landing_page')->where('key', "trust_image_card_$i")->first()); ?>
                        <?php ($cardLabel = ordinalSuffix($i)); ?>

                        <div class="card">
                            <div class="card-header">
                                <div class="w-100 d-flex align-items-center gap-2 flex-wrap justify-content-between">
                                    <h5 class="mb-0"><?php echo e($cardLabel); ?> <?php echo e(translate(' Card')); ?></h5>
                                    <label
                                        class="toggle-switch h--45px toggle-switch-sm d-flex justify-content-between gap-4">
                                        <span
                                            class="w-auto switch--label text-nowrap fs-14 text-title"><?php echo e(translate('messages.Status')); ?></span>
                                        <input type="checkbox" class="status toggle-switch-input"
                                               name="trust_status_card_<?php echo e($i); ?>"
                                               value="1" <?php echo e($trust_status?->value ? 'checked' : ''); ?>>
                                        <span class="toggle-switch-label text">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="bg--secondary h-100 rounded p-4 mb-20">
                                    <div class="text-center py-1">
                                        <div class="mx-auto text-center error-wrapper">
                                            <div class="mb-4">
                                                <h5 class="mb-1"><?php echo e(translate('Upload Image')); ?></h5>
                                                <p class="mb-0 fs-12 gray-dark"><?php echo e(translate('Upload ')); ?> <?php echo e($cardLabel); ?> <?php echo e(translate(' Card Image')); ?></p>
                                            </div>
                                            <div class="upload-file_custom ratio-1 h-100px">
                                                <?php if($trust_image?->value): ?>
                                                    <input type="hidden" name="trust_image_card_<?php echo e($i); ?>_existing"
                                                           value="<?php echo e($trust_image->value); ?>">
                                                <?php endif; ?>
                                                <input type="file" id="trust_image_input_<?php echo e($i); ?>" name="trust_image_card_<?php echo e($i); ?>"
                                                       class="upload-file__input single_file_input"
                                                       accept=".webp, .jpg, .jpeg, .png, .gif" <?php echo e($trust_image?->value ? '' : 'required'); ?>>
                                                <label class="upload-file__wrapper w-100 h-100 m-0">
                                                    <div class="upload-file-textbox text-center"
                                                         style="<?php echo e($trust_image?->value ? 'display: none;' : ''); ?>">
                                                        <img width="22" class="svg"
                                                             src="<?php echo e(asset('public/assets/admin/img/document-upload.svg')); ?>"
                                                             alt="img">
                                                        <h6 class="mt-1 color-656566 fw-medium fs-10 lh-base text-center">
                                                            <span class="theme-clr">Click to upload</span>
                                                            <br>
                                                            Or drag and drop
                                                        </h6>
                                                    </div>
                                                    <img class="upload-file-img" loading="lazy" src="<?php echo e($trust_image?->value
    ? \App\CentralLogics\Helpers::get_full_url('trust_section', $trust_image->value, $trust_image->storage[0]?->value ?? 'public', 'aspect_1')
    : ''); ?>" data-default-src="<?php echo e($trust_image?->value
    ? \App\CentralLogics\Helpers::get_full_url('trust_section', $trust_image->value, $trust_image->storage[0]?->value ?? 'public', 'aspect_1')
    : ''); ?>" alt=""
                                                    >
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
                                            <?php echo e(translate('JPG, JPEG, PNG, Gif Image size : Max 2 MB')); ?> <span
                                                class="font-medium text-title"><?php echo e(translate('(1:1)')); ?></span>
                                        </p>
                                    </div>
                                </div>
                                <div class="bg--secondary h-100 rounded p-md-4 p-3">
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

                                        <div class="lang_form default-form">
                                            <div class="row g-1">
                                                <div class="col-sm-12">
                                                    <label for="trust_title_card_<?php echo e($i); ?>"><?php echo e(translate('Title')); ?>

                                                        (<?php echo e(translate('messages.default')); ?>)
                                                        <span class="form-label-secondary" data-toggle="tooltip"
                                                              data-placement="right"
                                                              data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                                            <i class="tio-info color-A7A7A7"></i>
                                                        </span>
                                                        <span class="form-label-secondary text-danger"
                                                              data-toggle="tooltip"
                                                              data-placement="right"
                                                              data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                        </span>
                                                    </label>
                                                    <input id="trust_title_card_<?php echo e($i); ?>" type="text" maxlength="20"
                                                           name="trust_title_card_<?php echo e($i); ?>[]" class="form-control"
                                                           value="<?php echo e($trust_title?->getRawOriginal('value') ?? ''); ?>"
                                                           placeholder="<?php echo e(translate('messages.title_here...')); ?>"
                                                           required>
                                                    <span class="text-right text-counting color-A7A7A7 d-block mt-1">0/20</span>
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="trust_sub_title_card_<?php echo e($i); ?>"
                                                           class="form-label"><?php echo e(translate('Sub Title')); ?>

                                                        (<?php echo e(translate('messages.default')); ?>)
                                                        <span class="form-label-secondary" data-toggle="tooltip"
                                                              data-placement="right"
                                                              data-original-title="<?php echo e(translate('Write_the_sub_title_within_30_characters')); ?>">
                                                            <i class="tio-info color-A7A7A7"></i>
                                                        </span>
                                                        <span class="form-label-secondary text-danger"
                                                              data-toggle="tooltip"
                                                              data-placement="right"
                                                              data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                        </span>
                                                    </label>
                                                    <input id="trust_sub_title_card_<?php echo e($i); ?>" type="text" maxlength="30"
                                                           name="trust_sub_title_card_<?php echo e($i); ?>[]" class="form-control"
                                                           value="<?php echo e($trust_sub_title?->getRawOriginal('value') ?? ''); ?>"
                                                           placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>"
                                                           required>
                                                    <span class="text-right text-counting color-A7A7A7 d-block mt-1">0/30</span>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="lang[]" value="default">

                                        <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                $trust_title_translate = [];
                                                $trust_sub_title_translate = [];

                                                if (isset($trust_title->translations) && count($trust_title->translations)) {
                                                    foreach ($trust_title->translations as $t) {
                                                        if ($t->locale == $lang && $t->key == "trust_title_card_$i") {
                                                            $trust_title_translate[$lang]['value'] = $t->value;
                                                        }
                                                    }
                                                }

                                                if (isset($trust_sub_title->translations) && count($trust_sub_title->translations)) {
                                                    foreach ($trust_sub_title->translations as $t) {
                                                        if ($t->locale == $lang && $t->key == "trust_sub_title_card_$i") {
                                                            $trust_sub_title_translate[$lang]['value'] = $t->value;
                                                        }
                                                    }
                                                }
                                                ?>
                                            <div class="d-none lang_form" id="<?php echo e($lang); ?>-form">
                                                <div class="row g-1">
                                                    <div class="col-12">
                                                        <label for="trust_title_card_<?php echo e($i); ?>_<?php echo e($lang); ?>"
                                                               class="form-label"><?php echo e(translate('Title')); ?>

                                                            (<?php echo e(strtoupper($lang)); ?>)
                                                            <span class="form-label-secondary" data-toggle="tooltip"
                                                                  data-placement="right"
                                                                  data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                                                                <i class="tio-info color-A7A7A7"></i>
                                                                            </span>
                                                        </label>
                                                        <input id="trust_title_card_<?php echo e($i); ?>_<?php echo e($lang); ?>" type="text"
                                                               maxlength="20"
                                                               name="trust_title_card_<?php echo e($i); ?>[]"
                                                               value="<?php echo e($trust_title_translate[$lang]['value'] ?? ''); ?>"
                                                               class="form-control"
                                                               placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                                        <span
                                                            class="text-right text-counting color-A7A7A7 d-block mt-1">0/20</span>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="trust_sub_title_card_<?php echo e($i); ?>_<?php echo e($lang); ?>"
                                                               class="form-label"><?php echo e(translate('Sub Title')); ?>

                                                            (<?php echo e(strtoupper($lang)); ?>)
                                                            <span class="form-label-secondary" data-toggle="tooltip"
                                                                  data-placement="right"
                                                                  data-original-title="<?php echo e(translate('Write_the_sub_title_within_30_characters')); ?>">
                                                                                <i class="tio-info color-A7A7A7"></i>
                                                                            </span>
                                                        </label>
                                                        <input id="trust_sub_title_card_<?php echo e($i); ?>_<?php echo e($lang); ?>" type="text"
                                                               maxlength="30"
                                                               name="trust_sub_title_card_<?php echo e($i); ?>[]"
                                                               value="<?php echo e($trust_sub_title_translate[$lang]['value'] ?? ''); ?>"
                                                               class="form-control"
                                                               placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                                        <span
                                                            class="text-right text-counting color-A7A7A7 d-block mt-1">0/30</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <div class="row g-1">
                                            <div class="col-sm-12">
                                                <label for="trust_title_card_<?php echo e($i); ?>"><?php echo e(translate('Title')); ?></label>
                                                <input id="trust_title_card_<?php echo e($i); ?>" type="text" maxlength="20"
                                                       name="trust_title_card_<?php echo e($i); ?>[]" class="form-control" value=""
                                                       placeholder="<?php echo e(translate('messages.title_here...')); ?>" required>
                                                <span
                                                    class="text-right text-counting color-A7A7A7 d-block mt-1">0/20</span>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="trust_sub_title_card_<?php echo e($i); ?>"
                                                       class="form-label"><?php echo e(translate('Sub Title')); ?></label>
                                                <input id="trust_sub_title_card_<?php echo e($i); ?>" type="text" maxlength="30"
                                                       name="trust_sub_title_card_<?php echo e($i); ?>[]" class="form-control"
                                                       value=""
                                                       placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>"
                                                       required>
                                                <span
                                                    class="text-right text-counting color-A7A7A7 d-block mt-1">0/30</span>
                                            </div>
                                        </div>
                                        <input type="hidden" name="lang[]" value="default">
                                    <?php endif; ?>
                                </div>
                                <div class="btn--container justify-content-end mt-20">
                                    <button type="reset" class="btn btn--reset mb-2"><?php echo e(translate('Reset')); ?></button>
                                    <button type="submit" class="btn btn--primary mb-2"><?php echo e(translate('Save')); ?></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            <?php endfor; ?>
        </div>
    </div>

    <!-- Section View Offcanvas here -->
    <div id="trust_section" class="custom-offcanvas offcanvas-750 d-flex flex-column justify-content-between">
        <form action="<?php echo e(route('taxvat.store')); ?>" method="post">
            <div>
                <div
                    class="custom-offcanvas-header bg--secondary d-flex justify-content-between align-items-center px-3 py-3">
                    <div class="py-1">
                        <h3 class="mb-0 line--limit-1"><?php echo e(translate('messages.Trust Section Preview')); ?></h3>
                    </div>
                    <button type="button"
                            class="btn-close w-25px h-25px border rounded-circle d-center bg--secondary text-dark offcanvas-close fz-15px p-0"
                            aria-label="Close">
                        &times;
                    </button>
                </div>
                <div class="custom-offcanvas-body custom-offcanvas-body-100  p-20">
                    <section class="common-section-view bg-white position-relative border rounded-10">
                        <div class="container p-0">
                            <div class="common-carousel-wrapper">
                                <div class="trust-preview-slide owl-theme owl-carousel">
                                    <?php for($i = 1; $i <= $numCards; $i++): ?>
                                        <?php ($trust_title = \App\Models\DataSetting::withoutGlobalScope('translate')->where('type', 'react_landing_page')->where('key', "trust_title_card_$i")->first()); ?>
                                        <?php ($trust_sub_title = \App\Models\DataSetting::withoutGlobalScope('translate')->where('type', 'react_landing_page')->where('key', "trust_sub_title_card_$i")->first()); ?>
                                        <?php ($trust_image = \App\Models\DataSetting::where('type', 'react_landing_page')->where('key', "trust_image_card_$i")->first()); ?>
                                        <div class="items__">
                                            <div class="px-3 py-4 shadow--card d-flex align-items-center gap-3">
                                                <div
                                                    class="thumb-area bg-F5F5F5 rounded-pill w-60px h-60px min-w-60px d-center">
                                                    <img wdith="28" height="28"
                                                         src="<?php echo e($trust_image?->value ? \App\CentralLogics\Helpers::get_full_url('trust_section', $trust_image->value, $trust_image->storage[0]?->value ?? 'public', 'aspect_1') :
                                                            asset('/public/assets/admin/img/order-delivery-list.png')); ?>"
                                                         alt="" class="min-w-28">
                                                </div>
                                                <div>
                                                    <h2 class="mb-1"><?php echo e($trust_title?->value??'10,000+'); ?></h2>
                                                    <p class="fs-14 m-0"><?php echo e($trust_sub_title?->value ?? 'Orders Delivered'); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endfor; ?>
                                </div>
                                <div class="custom-owl-nav z-2">
                                    <button type="button" class="custom-prev__ btn border-0 outline-none p-2"><i
                                            class="tio-chevron-left"></i></button>
                                    <button type="button" class="custom-next__ btn border-0 outline-none p-2"><i
                                            class="tio-chevron-right"></i></button>
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.remove_btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    const cardNumber = this.dataset.card;
                    const fileInput = document.getElementById('trust_image_input_' + cardNumber);
                    const removeFlag = document.getElementById('trust_image_card_' + cardNumber);

                    if (removeFlag) {
                        removeFlag.removeAttribute('disabled');
                        removeFlag.value = '1';
                    }

                    if (fileInput) {
                        fileInput.removeAttribute('disabled');
                        fileInput.setAttribute('required', 'required');
                        fileInput.value = '';

                        const wrapper = fileInput.closest('.upload-file__wrapper');
                        if (wrapper) {
                            const textbox = wrapper.querySelector('.upload-file-textbox');
                            if (textbox) textbox.style.display = 'block';
                        }

                        const img = wrapper.querySelector('.upload-file-img');
                        if (img) img.style.display = 'none';
                    }
                });
            });

            document.querySelectorAll('.single_file_input').forEach(function (input) {
                input.addEventListener('change', function () {
                    const index = this.id.split('trust_image_input_')[1];
                    const removeFlag = document.getElementById('trust_image_card_' + index);
                    if (removeFlag) removeFlag.value = '0';
                    this.removeAttribute('required');
                });
            });
        });
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/business-settings/landing-page-settings/react-landing-page-trust-section.blade.php ENDPATH**/ ?>