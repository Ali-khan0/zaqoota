<?php $__env->startSection('title',translate('messages.admin_landing_page')); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <div class="page-header pb-0">
        <div class="d-flex flex-wrap justify-content-between">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/landing.png')); ?>" class="w--20" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.admin_landing_pages')); ?>

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
            <?php echo $__env->make('admin-views.business-settings.landing-page-settings.top-menu-links.admin-landing-page-links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>
    <?php ($contact_us_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key','contact_us_title')->first()); ?>
    <?php ($contact_us_sub_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key','contact_us_sub_title')->first()); ?>
    <?php ($contact_us_image=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key','contact_us_image')->first()); ?>
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
            <form action="<?php echo e(route('admin.business-settings.admin-landing-page-settings', 'contact-us-section')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <?php if($language): ?>
                                <div class="col-md-12 lang_form default-form">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="contact_us_title" class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(translate('messages.default')); ?>)<span
                                        class="form-label-secondary" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                            alt="">
                                    </span>
                                                <span class="form-label-secondary text-danger"
                                                      data-toggle="tooltip" data-placement="right"
                                                      data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                </span></label>
                                <input required id="contact_us_title" type="text" maxlength="20" name="contact_us_title[]" value="<?php echo e($contact_us_title?->getRawOriginal('value')); ?>" class="form-control" placeholder="<?php echo e(translate('Ex_:_Contact_Us')); ?>">
                                        </div>
                                        <div class="col-12">
                                            <label for="contact_us_sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?> (<?php echo e(translate('messages.default')); ?>)<span
                                        class="form-label-secondary" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                            alt="">
                                    </span>
                                                <span class="form-label-secondary text-danger"
                                                      data-toggle="tooltip" data-placement="right"
                                                      data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                </span></label>
                                <input required id="contact_us_sub_title" type="text" maxlength="80" name="contact_us_sub_title[]" value="<?php echo e($contact_us_sub_title?->getRawOriginal('value')); ?>" class="form-control" placeholder="<?php echo e(translate('Ex_:_Any_questions_or_remarks_?_Just_write_us_a_message!')); ?>">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                                    <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    if(isset($contact_us_title->translations)&&count($contact_us_title->translations)){
                                            $contact_us_title_translate = [];
                                            foreach($contact_us_title->translations as $t)
                                            {
                                                if($t->locale == $lang && $t->key=='contact_us_title'){
                                                    $contact_us_title_translate[$lang]['value'] = $t->value;
                                                }
                                            }

                                        }
                                    if(isset($contact_us_sub_title->translations)&&count($contact_us_sub_title->translations)){
                                            $contact_us_sub_title_translate = [];
                                            foreach($contact_us_sub_title->translations as $t)
                                            {
                                                if($t->locale == $lang && $t->key=='contact_us_sub_title'){
                                                    $contact_us_sub_title_translate[$lang]['value'] = $t->value;
                                                }
                                            }

                                        }
                                        ?>
                                    <div class="col-md-12 d-none lang_form" id="<?php echo e($lang); ?>-form1">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="contact_us_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(strtoupper($lang)); ?>)<span
                                        class="form-label-secondary" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                            alt="">
                                    </span></label>
                                <input id="contact_us_title<?php echo e($lang); ?>" type="text" maxlength="20" name="contact_us_title[]" value="<?php echo e($contact_us_title_translate[$lang]['value']??''); ?>" class="form-control" placeholder="<?php echo e(translate('Ex_:_Contact_Us')); ?>">
                                            </div>
                                            <div class="col-12">
                                                <label for="contact_us_sub_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Sub Title')); ?> (<?php echo e(strtoupper($lang)); ?>)<span
                                        class="form-label-secondary" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                            alt="">
                                    </span></label>
                                <input id="contact_us_sub_title<?php echo e($lang); ?>" type="text" maxlength="80" name="contact_us_sub_title[]" value="<?php echo e($contact_us_sub_title_translate[$lang]['value']??''); ?>" class="form-control" placeholder="<?php echo e(translate('Ex_:_Any_questions_or_remarks_?_Just_write_us_a_message!')); ?>">
                                            </div>
                                        </div>
                                    </div>
                                        <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                <div class="col-md-12">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="contact_us_title" class="form-label"><?php echo e(translate('Title')); ?><span
                                        class="form-label-secondary" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                            alt="">
                                    </span></label>
                                <input id="contact_us_title" type="text" maxlength="20" name="contact_us_title[]" class="form-control" placeholder="<?php echo e(translate('Ex_:_Contact_Us')); ?>">
                                        </div>
                                        <div class="col-12">
                                            <label for="contact_us_sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?><span
                                        class="form-label-secondary" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                            alt="">
                                    </span></label>
                                <input id="contact_us_sub_title" type="text" maxlength="80" name="contact_us_sub_title[]" class="form-control" placeholder="<?php echo e(translate('Ex_:_Any_questions_or_remarks_?_Just_write_us_a_message!')); ?>">
                                        </div>
                                    </div>
                                </div>
                                    <input type="hidden" name="lang[]" value="default">
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                    <label class="form-label d-block mb-3">
                                        <?php echo e(translate('messages.Banner')); ?>  <span class="text--primary">(size: 6:1)</span>
                                        <span class="form-label-secondary text-danger"
                                              data-toggle="tooltip" data-placement="right"
                                              data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                </span>
                                        <div class="fs-12 opacity-70">
                                            <?php echo e(translate(IMAGE_FORMAT.' ' . 'Less Than 2MB')); ?>

                                        </div>
                                    </label>
                                    <label class="upload-img-3 m-0 d-block">
                                        <div class="position-relative">
                                        <div class="img">
                                            <img
                                            src="<?php echo e(\App\CentralLogics\Helpers::get_full_url('contact_us_image', $contact_us_image?->value?? '', $contact_us_image?->storage[0]?->value ?? 'public','upload_image_4')); ?>"

                                          class="vertical-img mw-100 onerror-image" alt="contact_us_image" data-onerror-image="<?php echo e(asset("public/assets/admin/img/upload-4.png")); ?>">
                                        </div>
                                          <input accept="<?php echo e(IMAGE_EXTENSION); ?>" class="upload-file__input single_file_input" type="file"  name="image" hidden="">
                                          <?php if(isset($contact_us_image['value'])): ?>
                                            <span id="contact_image" class="remove_image_button remove-image dynamic-checkbox"
                                                  data-id="contact_image"
                                                  data-image-off="<?php echo e(asset('/public/assets/admin/img/delete-confirmation.png')); ?>"
                                                  data-title="<?php echo e(translate('Warning!')); ?>"
                                                  data-text="<p><?php echo e(translate('Are_you_sure_you_want_to_remove_this_image_?')); ?></p>"
                                            > <i class="tio-clear"></i></span>
                                            <?php endif; ?>
                                        </div>
                                    </label>
                                </div>
                        </div>
                    </div>
                </div>
                <h5 class="card-title mb-3 mt-3">
                    <span class="card-header-icon mr-2"><i class="tio-poi"></i></span> <span><?php echo e(translate('Office Opening & Closing')); ?></span>
                </h5>
                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-sm-6 col-lg-3">
                                <?php ($opening_time = \App\Models\BusinessSetting::where('key', 'opening_time')->first()); ?>
                                <label for="opening_time" class="form-label"><?php echo e(translate('Start Time')); ?></label>
                                <input  type="time" value="<?php echo e($opening_time ? $opening_time->value: ''); ?>" name="opening_time" class="form-control" id="opening_time">
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                 <?php ($closing_time = \App\Models\BusinessSetting::where('key', 'closing_time')->first()); ?>
                                <label for="closing_time" class="form-label"><?php echo e(translate('End Time')); ?></label>
                                <input type="time" value="<?php echo e($closing_time ? $closing_time->value: ''); ?>" name="closing_time" class="form-control" id="closing_time">
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <?php ($opening_day = \App\Models\BusinessSetting::where('key', 'opening_day')->first()); ?>
                                <?php ($opening_day = $opening_day ? $opening_day->value : ''); ?>
                                <label for="opening_day" class="form-label"><?php echo e(translate('Start Day')); ?></label>
                                <select id="opening_day" name="opening_day" class="form-control">
                                    <option value="saturday" <?php echo e($opening_day == 'saturday' ? 'selected' : ''); ?>>
                                        <?php echo e(translate('messages.saturday')); ?>

                                    </option>
                                    <option value="sunday" <?php echo e($opening_day == 'sunday' ? 'selected' : ''); ?>>
                                        <?php echo e(translate('messages.sunday')); ?>

                                    </option>
                                    <option value="monday" <?php echo e($opening_day == 'monday' ? 'selected' : ''); ?>>
                                        <?php echo e(translate('messages.monday')); ?>

                                    </option>
                                    <option value="tuesday" <?php echo e($opening_day == 'tuesday' ? 'selected' : ''); ?>>
                                        <?php echo e(translate('messages.tuesday')); ?>

                                    </option>
                                    <option value="wednesday" <?php echo e($opening_day == 'wednesday' ? 'selected' : ''); ?>>
                                        <?php echo e(translate('messages.wednesday')); ?>

                                    </option>
                                    <option value="thrusday" <?php echo e($opening_day == 'thrusday' ? 'selected' : ''); ?>>
                                        <?php echo e(translate('messages.thrusday')); ?>

                                    </option>
                                    <option value="friday" <?php echo e($opening_day == 'friday' ? 'selected' : ''); ?>>
                                        <?php echo e(translate('messages.friday')); ?>

                                    </option>
                                </select>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <?php ($closing_day = \App\Models\BusinessSetting::where('key', 'closing_day')->first()); ?>
                                <?php ($closing_day = $closing_day ? $closing_day->value : ''); ?>
                                <label for="closing_day" class="form-label"><?php echo e(translate('End Day')); ?></label>
                                <select id="closing_day" name="closing_day" class="form-control">
                                    <option value="saturday" <?php echo e($closing_day == 'saturday' ? 'selected' : ''); ?>>
                                        <?php echo e(translate('messages.saturday')); ?>

                                    </option>
                                    <option value="sunday" <?php echo e($closing_day == 'sunday' ? 'selected' : ''); ?>>
                                        <?php echo e(translate('messages.sunday')); ?>

                                    </option>
                                    <option value="monday" <?php echo e($closing_day == 'monday' ? 'selected' : ''); ?>>
                                        <?php echo e(translate('messages.monday')); ?>

                                    </option>
                                    <option value="tuesday" <?php echo e($closing_day == 'tuesday' ? 'selected' : ''); ?>>
                                        <?php echo e(translate('messages.tuesday')); ?>

                                    </option>
                                    <option value="wednesday" <?php echo e($closing_day == 'wednesday' ? 'selected' : ''); ?>>
                                        <?php echo e(translate('messages.wednesday')); ?>

                                    </option>
                                    <option value="thrusday" <?php echo e($closing_day == 'thrusday' ? 'selected' : ''); ?>>
                                        <?php echo e(translate('messages.Thursday')); ?>

                                    </option>
                                    <option value="friday" <?php echo e($closing_day == 'friday' ? 'selected' : ''); ?>>
                                        <?php echo e(translate('messages.friday')); ?>

                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn--container justify-content-end mt-20">
                    <button type="reset" class="btn btn--reset mb-2"><?php echo e(translate('Reset')); ?></button>
                    <button type="submit"   class="btn btn--primary mb-2"><?php echo e(translate('Save Information')); ?></button>
                </div>
            </form>
            <form  id="contact_image_form" action="<?php echo e(route('admin.remove_image')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo e($contact_us_image?->id); ?>" >
                <input type="hidden" name="model_name" value="DataSetting" >
                <input type="hidden" name="image_path" value="contact_us_image" >
                <input type="hidden" name="field_name" value="value" >
            </form>

        </div>
    </div>
</div>
    <!-- How it Works -->
    <?php echo $__env->make('admin-views.business-settings.landing-page-settings.partial.how-it-work', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/landing-page-settings/admin-landing-contact.blade.php ENDPATH**/ ?>