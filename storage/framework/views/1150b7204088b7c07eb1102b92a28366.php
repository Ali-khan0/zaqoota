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
        <?php ($language = \App\Models\BusinessSetting::where('key', 'language')->first()); ?>
        <?php ($language = $language->value ?? null); ?>
        <div class="tab-content">
            <div class="tab-pane fade show active">
                <form class="custom-validation"
                      action="<?php echo e(route('admin.business-settings.review-react-update',[$review->id])); ?>" method="POST"
                      enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card p-xxl-3 mb-20 border-0">
                        <div class="row g-3">
                            <div class="col-lg-8">
                                <div class="bg--secondary rounded h-100 p-xxl-4 p-3">
                                    <?php if($language): ?>
                                        <ul class="nav nav-tabs mb-4 border-bottom">
                                            <li class="nav-item">
                                                <a class="nav-link lang_link active" href="#"
                                                   id="testimonial-default-link"><?php echo e(translate('messages.default')); ?></a>
                                            </li>
                                            <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="nav-item">
                                                    <a class="nav-link lang_link" href="#"
                                                       id="testimonial-<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    <?php endif; ?>
                                    <?php if($language): ?>
                                        <div class="row g-3 lang_form" id="testimonial-default-form">
                                            <div class="col-md-6">
                                                <label for="name"
                                                       class="form-label"><?php echo e(translate('Reviewer Name')); ?>

                                                    (<?php echo e(translate('messages.default')); ?>)
                                                    <span class="form-label-secondary" data-toggle="tooltip"
                                                          data-placement="right"
                                                          data-original-title="<?php echo e(translate('Content...')); ?>">
                                                <i class="tio-info color-A7A7A7"></i>
                                            </span>
                                                    <span class="form-label-secondary text-danger"
                                                          data-toggle="tooltip" data-placement="right"
                                                          data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                    </span>
                                                </label>
                                                <input id="name" type="text" name="name[]" value="<?php echo e($review?->name); ?>"
                                                       class="form-control"
                                                       placeholder="<?php echo e(translate('Ex:  John Doe')); ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="designation"
                                                       class="form-label"><?php echo e(translate('Designation')); ?>

                                                    (<?php echo e(translate('messages.default')); ?>)
                                                    <span class="form-label-secondary" data-toggle="tooltip"
                                                          data-placement="right"
                                                          data-original-title="<?php echo e(translate('Content...')); ?>">
                                                <i class="tio-info color-A7A7A7"></i>
                                            </span>

                                                </label>
                                                <input id="designation" value="<?php echo e($review?->designation); ?>" type="text"
                                                       name="designation[]"
                                                       class="form-control"
                                                       placeholder="<?php echo e(translate('Ex:  CTO')); ?>">
                                            </div>
                                            <div class="col-md-12">
                                                <label for="review"
                                                       class="form-label"><?php echo e(translate('messages.review')); ?>

                                                    (<?php echo e(translate('messages.default')); ?>)
                                                    <span
                                                        class="form-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="<?php echo e(translate('Write_the_title_within_140_characters')); ?>">
                                                <i class="tio-info color-A7A7A7"></i>
                                            </span>
                                                    <span class="form-label-secondary text-danger"
                                                          data-toggle="tooltip" data-placement="right"
                                                          data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                    </span>
                                                </label>
                                                <textarea id="review" name="review[]" maxlength="200"
                                                          placeholder="<?php echo e(translate('Very Good Company')); ?>"
                                                          class="form-control h92px"
                                                          required><?php echo e($review?->review); ?></textarea>
                                                <span
                                                    class="text-right text-counting color-A7A7A7 d-block mt-1">0/200</span>
                                            </div>
                                        </div>
                                        <input type="hidden" name="lang[]" value="default">
                                        <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                $name_translate = [];
                                                $designation_translate = [];
                                                $review_translate = [];
                                                if (isset($review->translations) && count($review->translations)) {
                                                    foreach ($review->translations as $t) {
                                                        if ($t->locale == $lang && $t->key == 'name') {
                                                            $name_translate[$lang]['value'] = $t->value;
                                                        }
                                                    }
                                                }
                                                if (isset($review->translations) && count($review->translations)) {
                                                    foreach ($review->translations as $t) {
                                                        if ($t->locale == $lang && $t->key == 'designation') {
                                                            $designation_translate[$lang]['value'] = $t->value;
                                                        }
                                                    }
                                                }
                                                if (isset($review->translations) && count($review->translations)) {
                                                    foreach ($review->translations as $t) {
                                                        if ($t->locale == $lang && $t->key == 'review') {
                                                            $review_translate[$lang]['value'] = $t->value;
                                                        }
                                                    }
                                                }
                                                ?>
                                            <div class="row g-3 d-none lang_form"
                                                 id="testimonial-<?php echo e($lang); ?>-form">
                                                <div class="col-md-6">
                                                    <label for="name<?php echo e($lang); ?>"
                                                           class="form-label"><?php echo e(translate('Reviewer Name')); ?>

                                                        (<?php echo e(strtoupper($lang)); ?>)
                                                        <span class="form-label-secondary" data-toggle="tooltip"
                                                              data-placement="right"
                                                              data-original-title="<?php echo e(translate('Content...')); ?>">
                                                    <i class="tio-info color-A7A7A7"></i>
                                                </span>
                                                    </label>
                                                    <input id="name<?php echo e($lang); ?>" type="text" name="name[]"
                                                           value="<?php echo e($name_translate[$lang]['value']??''); ?>"
                                                           class="form-control"
                                                           placeholder="<?php echo e(translate('Ex:  John Doe')); ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="designation<?php echo e($lang); ?>"
                                                           class="form-label"><?php echo e(translate('Designation')); ?>

                                                        (<?php echo e(strtoupper($lang)); ?>)
                                                        <span class="form-label-secondary" data-toggle="tooltip"
                                                              data-placement="right"
                                                              data-original-title="<?php echo e(translate('Content...')); ?>">
                                                    <i class="tio-info color-A7A7A7"></i>
                                                </span>
                                                    </label>
                                                    <input id="designation<?php echo e($lang); ?>" type="text"
                                                           value="<?php echo e($designation_translate[$lang]['value'] ?? ''); ?>"
                                                           name="designation[]"
                                                           class="form-control"
                                                           placeholder="<?php echo e(translate('Ex:  CTO')); ?>">
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="review<?php echo e($lang); ?>"
                                                           class="form-label"><?php echo e(translate('messages.review')); ?>

                                                        (<?php echo e(strtoupper($lang)); ?>)
                                                        <span
                                                            class="form-label-secondary" data-toggle="tooltip"
                                                            data-placement="right"
                                                            data-original-title="<?php echo e(translate('Write_the_title_within_140_characters')); ?>">
                                                    <i class="tio-info color-A7A7A7"></i>
                                                </span></label>
                                                    <textarea id="review<?php echo e($lang); ?>" name="review[]"
                                                              maxlength="200"
                                                              placeholder="<?php echo e(translate('Very Good Company')); ?>"
                                                              class="form-control h92px"><?php echo e($review_translate[$lang]['value']??''); ?></textarea>
                                                    <span
                                                        class="text-right text-counting color-A7A7A7 d-block mt-1">0/200</span>
                                                </div>
                                            </div>
                                            <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="name"
                                                       class="form-label"><?php echo e(translate('Reviewer Name')); ?>

                                                    <span class="form-label-secondary" data-toggle="tooltip"
                                                          data-placement="right"
                                                          data-original-title="<?php echo e(translate('Content...')); ?>">
                                                <i class="tio-info color-A7A7A7"></i>
                                            </span>
                                                </label>
                                                <input id="name" type="text" name="name[]" class="form-control"
                                                       placeholder="<?php echo e(translate('Ex:  John Doe')); ?>">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="designation"
                                                       class="form-label"><?php echo e(translate('Designation')); ?>

                                                    <span class="form-label-secondary" data-toggle="tooltip"
                                                          data-placement="right"
                                                          data-original-title="<?php echo e(translate('Content...')); ?>">
                                                <i class="tio-info color-A7A7A7"></i>
                                            </span>
                                                </label>
                                                <input id="designation" type="text" name="designation[]"
                                                       class="form-control"
                                                       placeholder="<?php echo e(translate('Ex:  CTO')); ?>">
                                            </div>
                                            <div class="col-md-12">
                                                <label for="review"
                                                       class="form-label"><?php echo e(translate('messages.review')); ?><span
                                                        class="form-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="<?php echo e(translate('Write_the_title_within_140_characters')); ?>">
                                                <i class="tio-info color-A7A7A7"></i>
                                            </span></label>
                                                <textarea id="review" name="review[]" maxlength="200"
                                                          placeholder="<?php echo e(translate('Very Good Company')); ?>"
                                                          class="form-control h92px"></textarea>
                                                <span
                                                    class="text-right text-counting color-A7A7A7 d-block mt-1">0/200</span>
                                            </div>
                                        </div>
                                        <input type="hidden" name="lang[]" value="default">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="bg--secondary h-100 rounded p-md-4 p-3 d-center">
                                    <div class="text-center">
                                        <div class="mb-30">
                                            <h5 class="mb-1"><?php echo e(translate('Reviewer Image')); ?></h5>
                                            <p class="mb-0 fs-12 gray-dark"><?php echo e(translate('Upload Reviewer Image')); ?>

                                            </p>
                                        </div>
                                        <div class="mx-auto text-center error-wrapper">
                                            <div class="upload-file_custom ratio-1 h-100px">
                                                <input type="file" name="reviewer_image"
                                                       class="upload-file__input single_file_input"
                                                       accept=".webp, .jpg, .jpeg, .png, .gif" <?php echo e($review?->reviewer_image ? '':'required'); ?>>
                                                <label class="upload-file__wrapper w-100 h-100 m-0">
                                                    <div class="upload-file-textbox text-center" style="">
                                                        <img width="22" class="svg"
                                                             src="<?php echo e(asset('public/assets/admin/img/document-upload.svg')); ?>"
                                                             alt="img">
                                                        <h6
                                                            class="mt-1 color-656566 fw-medium fs-10 lh-base text-center">
                                                            <span class="theme-clr">Click to upload</span>
                                                            <br>
                                                            Or drag and drop
                                                        </h6>
                                                    </div>
                                                    <img class="upload-file-img" loading="lazy"
                                                         src="<?php echo e($review->reviewer_image ? $review->reviewer_image_full_url:''); ?>"
                                                         data-default-src="<?php echo e($review->reviewer_image ? $review->reviewer_image_full_url:''); ?>"
                                                         alt="" style="display: none;">
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
                                                class="font-medium text-title"><?php echo e(translate('(2:1)')); ?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn--container justify-content-end mt-20">
                            <button type="reset" class="btn btn--reset mb-2"><?php echo e(translate('Reset')); ?></button>
                            <button type="submit" class="btn btn--primary mb-2"><?php echo e(translate('Update')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- How it Works -->
    <?php echo $__env->make('admin-views.business-settings.landing-page-settings.partial.how-it-work-react', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script_2'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var removeBtn = document.getElementById('remove_image_btn');
            var removeFlag = document.getElementById('image_remove');
            var fileInput = document.querySelector('input[name="image"]');
            var form = fileInput ? fileInput.closest('form') : null;

            if (removeBtn && removeFlag) {
                removeBtn.addEventListener('click', function () {
                    removeFlag.value = '1';
                    if (fileInput) {
                        fileInput.removeAttribute('disabled');
                        fileInput.setAttribute('required', 'required');
                        fileInput.value = '';
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

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/landing-page-settings/react-landing-testimonial-edit.blade.php ENDPATH**/ ?>