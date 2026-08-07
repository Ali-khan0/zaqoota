<?php $__env->startSection('title', translate('email_template')); ?>
<?php $__env->startPush('css_or_js'); ?>
<link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/view-pages/email-templates.css')); ?>">
<?php $__env->stopPush(); ?>


<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex flex-wrap justify-content-between align-items-center __gap-15px">
                <h1 class="page-header-title mr-3 mb-0">
                    <span class="page-header-icon">
                        <img src="<?php echo e(asset('public/assets/admin/img/email-setting.png')); ?>" class="w--26" alt="">
                    </span>
                    <span>
                        <?php echo e(translate('messages.Email Templates')); ?>

                    </span>
                </h1>
                <?php echo $__env->make('admin-views.business-settings.email-format-setting.partials.email-template-options', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
            <?php echo $__env->make('admin-views.business-settings.email-format-setting.partials.store-email-template-setting-links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <div class="tab-content">
            <div class="tab-pane fade show active">
                <div class="card mb-3">
                    <?php ($mail_status=\App\Models\BusinessSetting::where('key','approve_mail_status_store')->first()?->value ?? '0'); ?>
                    <div class="card-body">
                        <div class="maintenance-mode-toggle-bar d-flex flex-wrap justify-content-between border rounded align-items-center p-2">
                            <h5 class="text-capitalize m-0 text--primary pl-2">
                                <?php echo e(translate('Send_Mail_on_New_Store_Approval?')); ?>

                        <span class="form-label-secondary text--primary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('If_Admin_accepts_a_Store’s_self-registration,_the_store_will_get_an_automatic_approval_mail_from_the_system.')); ?>">
                                    <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                </span>
                            </h5>
                            <label class="toggle-switch toggle-switch-sm">
                                <input type="checkbox" class="status toggle-switch-input dynamic-checkbox"
                                       data-id="mail-status"
                                       data-type="status"
                                       data-image-on='<?php echo e(asset('/public/assets/admin/img/modal')); ?>/place-order-on.png'
                                       data-image-off="<?php echo e(asset('/public/assets/admin/img/modal')); ?>/place-order-off.png"
                                       data-title-on="<?php echo e(translate('Want_to_enable_Store_approve_mail?')); ?>"
                                       data-title-off="<?php echo e(translate('Want_to_disable_Store_approve_mail?')); ?>"
                                       data-text-on="<p><?php echo e(translate('If_enabled,_Users_will_get_a_confirmation_email_when_the_Admin_approves_the_registration.')); ?></p>"
                                       data-text-off="<p><?php echo e(translate('If_disabled,_Users_will_not_get_a_registration_approval_email.')); ?></p>"
                                       id="mail-status" <?php echo e($mail_status == '1'?'checked':''); ?>>
                                <span class="toggle-switch-label text mb-0">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </div>
                        <form action="<?php echo e(route('admin.business-settings.email-status',['store','approve',$mail_status == '1'?0:1])); ?>" method="get" id="mail-status_form">
                        </form>
                    </div>
                </div>
                <?php ($data=\App\Models\EmailTemplate::where('type','store')->where('email_type', 'approve')->first()); ?>
                <?php ($template= $template ?? $data?->email_template ?? 5); ?>
                <form action="<?php echo e(route('admin.business-settings.email-setup', ['store','approve'])); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="email-format-wrapper">
                                <div class="left-content">
                                    <div class="d-inline-block">
                                        <?php echo $__env->make('admin-views.business-settings.email-format-setting.partials.email-template-section', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <?php echo $__env->make('admin-views.business-settings.email-format-setting.templates.email-format-'.$template, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="right-content">
                                    <div class="d-flex flex-wrap justify-content-between __gap-15px mt-2 mb-5">
                                        <?php ($data=\App\Models\EmailTemplate::withoutGlobalScope('translate')->where('type','store')->where('email_type', 'approve')->first()); ?>
                                        <?php ($language=\App\Models\BusinessSetting::where('key','language')->first()); ?>
                                        <?php ($language = $language->value ?? null); ?>
                                        <?php ($defaultLang = str_replace('_', '-', app()->getLocale())); ?>
                                        <?php if($language): ?>
                                            <ul class="nav nav-tabs m-0 border-0">
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
                                        <div class="d-flex justify-content-end">
                                            <div class="text--primary-2 py-1 d-flex flex-wrap align-items-center py-1" type="button" data-toggle="modal" data-target="#instructions">
                                                <strong class="mr-2"><?php echo e(translate('Read Instructions')); ?></strong>
                                                <div class="blinkings">
                                                    <i class="tio-info-outined"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="card-title mb-3">
                                            <?php echo e(translate('Icon')); ?>

                                        </h5>
                                        <label class="custom-file">
                                            <input type="file" name="icon" id="mail-icon" class="custom-file-input" accept=".webp, .jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                            <span class="custom-file-label"><?php echo e(translate('messages.Choose File')); ?></span>
                                        </label>
                                    </div>
                                    <br>
                                    <div>
                                        <h5 class="card-title mb-3">
                                            <img src="<?php echo e(asset('public/assets/admin/img/pointer.png')); ?>" class="mr-2" alt="">
                                            <?php echo e(translate('Header Content')); ?>

                                        </h5>
                                        <?php if($language): ?>
                                            <div class="__bg-F8F9FC-card default-form lang_form" id="default-form">
                                                <div class="form-group">
                                                    <label class="form-label"><?php echo e(translate('Main Title')); ?>(<?php echo e(translate('messages.default')); ?>)</label>
                                                    <input type="text" name="title[]" value="<?php echo e($data?->getRawOriginal('title')); ?>" data-id="mail-title" placeholder="Order has been placed successfully !" class="form-control">
                                                </div>
                                                <div class="form-group mb-0">
                                                    <label class="form-label">
                                                        <?php echo e(translate('Mail Body Message')); ?>(<?php echo e(translate('messages.default')); ?>)

                                                    </label>
                                                    <textarea class="form-control" id="ckeditor" data-id="mail-body" name="body[]">
                                                        <?php echo $data?->getRawOriginal('body'); ?>

                                                    </textarea>
                                                </div>
                                            </div>
                                            <input type="hidden" name="lang[]" value="default">
                                            <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                            if($data && count($data['translations'])){
                                                $translate = [];
                                                foreach($data['translations'] as $t)
                                                {
                                                    if($t->locale == $lang && $t->key=="title"){
                                                        $translate[$lang]['title'] = $t->value;
                                                    }
                                                    if($t->locale == $lang && $t->key=="body"){
                                                        $translate[$lang]['body'] = $t->value;
                                                    }
                                                }
                                            }
                                                ?>
                                                <div class="__bg-F8F9FC-card d-none lang_form" id="<?php echo e($lang); ?>-form">
                                                    <div class="form-group">
                                                        <label class="form-label"><?php echo e(translate('Main Title')); ?>(<?php echo e(strtoupper($lang)); ?>)</label>
                                                        <input type="text" name="title[]" placeholder="Order has been placed successfully !" class="form-control" value="<?php echo e($translate[$lang]['title']??''); ?>">
                                                    </div>
                                                    <div class="form-group mb-0">
                                                        <label class="form-label">
                                                            <?php echo e(translate('Mail Body Message')); ?>(<?php echo e(strtoupper($lang)); ?>)

                                                        </label>
                                                        <textarea class="ckeditor form-control" name="body[]">
                                                           <?php echo $translate[$lang]['body']??''; ?>

                                                        </textarea>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <div class="__bg-F8F9FC-card default-form">
                                                <div class="form-group">
                                                    <label class="form-label"><?php echo e(translate('Main Title')); ?></label>
                                                    <input type="text" name="title[]" placeholder="Order has been placed successfully !" class="form-control">
                                                </div>
                                                <div class="form-group mb-0">
                                                    <label class="form-label">
                                                        <?php echo e(translate('Mail Body Message')); ?>


                                                    </label>
                                                    <textarea class="ckeditor form-control" name="body[]">
                                                      <?php echo e(translate('Hi_Sabrina')); ?>,
                                                    </textarea>
                                                </div>
                                            </div>
                                            <input type="hidden" name="lang[]" value="default">
                                        <?php endif; ?>

                                    </div>
                                    <br>
                                    <div>
                                        <h5 class="card-title mb-3">
                                            <img src="<?php echo e(asset('public/assets/admin/img/pointer.png')); ?>" class="mr-2" alt="">
                                            <?php echo e(translate('Footer Content')); ?>

                                        </h5>
                                        <div class="__bg-F8F9FC-card">
                                                <?php if($language): ?>
                                                        <div class="form-group lang_form default-form">
                                                            <label class="form-label">
                                                                <?php echo e(translate('Section Text')); ?>(<?php echo e(translate('messages.default')); ?>)
                                                            </label>
                                                            <input type="text" data-id="mail-footer" name="footer_text[]"  placeholder="<?php echo e(translate('Please_contact_us_for_any_queries;_we’re_always_happy_to_help.')); ?>"class="form-control" value="<?php echo e($data?->getRawOriginal('footer_text')); ?>">
                                                        </div>
                                                    <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                    if($data && count($data['translations'])){
                                                        $translate = [];
                                                        foreach($data['translations'] as $t)
                                                        {
                                                            if($t->locale == $lang && $t->key=="footer_text"){
                                                                $translate[$lang]['footer_text'] = $t->value;
                                                            }
                                                        }
                                                        }
                                                        ?>
                                                        <div class="form-group d-none lang_form" id="<?php echo e($lang); ?>-form2">
                                                            <label class="form-label">
                                                                <?php echo e(translate('Section Text')); ?>(<?php echo e(strtoupper($lang)); ?>)
                                                            </label>
                                                            <input type="text" name="footer_text[]"  placeholder="<?php echo e(translate('Please_contact_us_for_any_queries;_we’re_always_happy_to_help.')); ?>"class="form-control" value="<?php echo e($translate[$lang]['footer_text']??''); ?>">
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                <div class="form-group">
                                                    <label class="form-label">
                                                        <?php echo e(translate('Section Text')); ?>


                                                    </label>
                                                    <input type="text" placeholder="<?php echo e(translate('Please_contact_us_for_any_queries;_we’re_always_happy_to_help.')); ?>"class="form-control" name="footer_text[]" value="">
                                                </div>
                                                <?php endif; ?>
                                                    <?php echo $__env->make('admin-views.business-settings.email-format-setting.partials.social-media-and-footer-section', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


                                            <div class="form-group mb-0">
                                                <?php if($language): ?>
                                                        <div class="form-group lang_form default-form">
                                                            <label class="form-label">
                                                                <?php echo e(translate('Copyright Content')); ?>(<?php echo e(translate('messages.default')); ?>)
                                                            </label>
                                                            <input type="text" data-id="mail-copyright" name="copyright_text[]"  placeholder="<?php echo e(translate('Ex:_Copyright_2023_6amMart._All_right_reserved')); ?>" class="form-control" value="<?php echo e($data?->getRawOriginal('copyright_text')); ?>">
                                                        </div>
                                                    <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                           $translate = [];
                                           if($data && count($data['translations'])){
                                                        foreach($data['translations'] as $t)
                                                        {
                                                            if($t->locale == $lang && $t->key=="copyright_text"){
                                                                $translate[$lang]['copyright_text'] = $t->value;
                                                            }
                                                        }
                                                        }
                                                        ?>
                                                        <div class="form-group d-none lang_form" id="<?php echo e($lang); ?>-form3">
                                                            <label class="form-label">
                                                                <?php echo e(translate('Copyright Content')); ?>(<?php echo e(strtoupper($lang)); ?>)
                                                            </label>
                                                            <input type="text" name="copyright_text[]"  placeholder="<?php echo e(translate('Ex:_Copyright_2023_6amMart._All_right_reserved')); ?>" class="form-control" value="<?php echo e($translate[$lang]['copyright_text']??''); ?>">
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                <div class="form-group">
                                                    <label class="form-label">
                                                        <?php echo e(translate('Copyright Content')); ?>


                                                    </label>
                                                    <input type="text" placeholder="<?php echo e(translate('Ex:_Copyright_2023_6amMart._All_right_reserved')); ?>" class="form-control" name="copyright_text[]" value="">
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn--container justify-content-end mt-20">
                                        <button type="reset" id="reset_btn" class="btn btn--reset"><?php echo e(translate('Reset')); ?></button>
                                        <button type="submit" class="btn btn--primary"><?php echo e(translate('Save')); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <!-- Instructions Modal -->
<?php echo $__env->make('admin-views.business-settings.email-format-setting.partials.email-template-instructions', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script_2'); ?>
    <!-- Email Template-->
    <script src="<?php echo e(asset('public/assets/admin/ckeditor/ckeditor.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/admin/js/view-pages/email-templates.js')); ?>"></script>
    <!-- Email Template End-->
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/email-format-setting/store-email-formats/approve-format.blade.php ENDPATH**/ ?>