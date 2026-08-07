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

    <?php ($company_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','company_title')->first()); ?>
    <?php ($company_sub_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','company_sub_title')->first()); ?>
    <?php ($company_description=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','company_description')->first()); ?>
    <?php ($company_button_name=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','company_button_name')->first()); ?>
    <?php ($company_button_url=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','company_button_url')->first()); ?>

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
            <form action="<?php echo e(route('admin.business-settings.react-landing-page-settings', 'company-section')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <h5 class="card-title mb-3 mt-3">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <span>
                            <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span> <span><?php echo e(translate('Company Section')); ?></span>
                        </span>
                    </div>
                </h5>
                <div class="card">
                    <div class="card-body">

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="row g-3">
                                    <?php if($language): ?>
                                    <div class="col-12 lang_form default-form">
                                        <div class="mb-2">
                                            <label for="company_title" class="form-label"><?php echo e(translate('Title')); ?>(<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span><span class="form-label-secondary text-danger"
                                            data-toggle="tooltip" data-placement="right"
                                            data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                            </span>
                                            </label>
                                    <input id="company_title" type="text"  maxlength="20" name="company_title[]" value="<?php echo e($company_title?->getRawOriginal('value')??''); ?>" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                        </div>
                                        <div class="mb-2">
                                            <label for="company_sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?>(<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_40_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span>
                                            <span class="form-label-secondary text-danger"
                                            data-toggle="tooltip" data-placement="right"
                                            data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                            </span>
                                        </label>
                                    <input id="company_sub_title" type="text"  maxlength="40" name="company_sub_title[]" value="<?php echo e($company_sub_title?->getRawOriginal('value')??''); ?>" class="form-control" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                        </div>
                                        <div class="mb-2">
                                            <label for="company_description" class="form-label">
                                                <?php echo e(translate('Short Description')); ?>(<?php echo e(translate('messages.default')); ?>)
                                                <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_240_characters')); ?>">
                                                    <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                                </span></label>
                                            <textarea id="company_description" maxlength="240" name="company_description[]" class="form-control h--90px"><?php echo e($company_description['value']??''); ?></textarea>
                                        </div>
                                    </div>
                                <input type="hidden" name="lang[]" value="default">
                                    <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    if(isset($company_title->translations)&&count($company_title->translations)){
                                            $company_title_translate = [];
                                            foreach($company_title->translations as $t)
                                            {
                                                if($t->locale == $lang && $t->key=='company_title'){
                                                    $company_title_translate[$lang]['value'] = $t->value;
                                                }
                                            }

                                        }
                                    if(isset($company_sub_title->translations)&&count($company_sub_title->translations)){
                                            $company_sub_title_translate = [];
                                            foreach($company_sub_title->translations as $t)
                                            {
                                                if($t->locale == $lang && $t->key=='company_sub_title'){
                                                    $company_sub_title_translate[$lang]['value'] = $t->value;
                                                }
                                            }

                                        }
                                    if(isset($company_description->translations)&&count($company_description->translations)){
                                            $company_description_translate = [];
                                            foreach($company_description->translations as $t)
                                            {
                                                if($t->locale == $lang && $t->key=='company_description'){
                                                    $company_description_translate[$lang]['value'] = $t->value;
                                                }
                                            }

                                        }
                                        ?>
                                        <div class="col-12 d-none lang_form" id="<?php echo e($lang); ?>-form">
                                            <div class="mb-2">
                                                <label for="company_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Title')); ?>(<?php echo e(strtoupper($lang)); ?>)
                                                    <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                                    </span></label>
                                            <input id="company_title<?php echo e($lang); ?>" type="text"  maxlength="20" name="company_title[]" value="<?php echo e($company_title_translate[$lang]['value']??''); ?>" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                            </div>
                                            <div class="mb-2">
                                                <label for="company_sub_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Sub Title')); ?>(<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_40_characters')); ?>">
                                                    <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                                </span></label>
                                        <input id="company_sub_title<?php echo e($lang); ?>" type="text"  maxlength="40" name="company_sub_title[]" value="<?php echo e($company_sub_title_translate[$lang]['value']??''); ?>" class="form-control" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                            </div>
                                            <div class="mb-2">
                                                <label for="company_description<?php echo e($lang); ?>" class="form-label">
                                                    <?php echo e(translate('Short Description')); ?>(<?php echo e(strtoupper($lang)); ?>)
                                                    <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_240_characters')); ?>">
                                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                                    </span></label>
                                                <textarea id="company_description<?php echo e($lang); ?>" maxlength="240" name="company_description[]" class="form-control h--90px"><?php echo e($company_description_translate[$lang]['value']??''); ?></textarea>
                                            </div>
                                        </div>
                                        <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                <div class="col-12">
                                    <div class="mb-2">
                                        <label for="company_title" class="form-label"><?php echo e(translate('Title')); ?></label>
                                        <input id="company_title" type="text" name="company_title[]" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                    </div>
                                    <div class="mb-2">
                                        <label for="company_sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?></label>
                                        <input id="company_sub_title" type="text" name="company_sub_title[]" class="form-control" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                    </div>
                                    <div class="mb-2">
                                        <label for="company_description" class="form-label">
                                            <?php echo e(translate('Short Description')); ?>

                                        </label>
                                        <textarea id="company_description" name="company_description[]" class="form-control h--90px"></textarea>
                                    </div>
                                </div>
                                    <input type="hidden" name="lang[]" value="default">
                                <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="card-title">
                                        <img src="<?php echo e(asset('public/assets/admin/img/btn-cont.png')); ?>" class="mr-2" alt="">
                                        <?php echo e(translate('Button Content')); ?>

                                        <span class="input-label-secondary text--title" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('You_must_provide_a_redirect_URL_when_setting_the_button_name')); ?>">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                    </h5>
                                </div>
                                <div class="__bg-F8F9FC-card">
                                    <?php if($language): ?>
                                        <div class="form-group lang_form default-form">
                                            <label for="company_button_name" class="form-label text-capitalize">
                                                <?php echo e(translate('Button Name')); ?>(<?php echo e(translate('messages.default')); ?>)
                                                <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input id="company_button_name" type="text" maxlength="20" name="company_button_name[]" value="<?php echo e($company_button_name?->getRawOriginal('value')??''); ?>"  placeholder="<?php echo e(translate('Ex: Order now')); ?>" class="form-control h--45px company_button_name" >
                                        </div>
                                    <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    if(isset($company_button_name->translations)&&count($company_button_name->translations)){
                                            $company_button_name_translate = [];
                                            foreach($company_button_name->translations as $t)
                                            {
                                                if($t->locale == $lang && $t->key=='company_button_name'){
                                                    $company_button_name_translate[$lang]['value'] = $t->value;
                                                    $button_url= 1;
                                                }
                                            }

                                        }
                                        ?>
                                        <div class="form-group d-none lang_form" id="<?php echo e($lang); ?>-form1">
                                            <label for="company_button_name<?php echo e($lang); ?>" class="form-label text-capitalize">
                                                <?php echo e(translate('Button Name')); ?>(<?php echo e(strtoupper($lang)); ?>)
                                                <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input id="company_button_name<?php echo e($lang); ?>" type="text" maxlength="20" name="company_button_name[]" value="<?php echo e($company_button_name_translate[$lang]['value']??''); ?>"  placeholder="<?php echo e(translate('Ex: Order now')); ?>" class="form-control h--45px company_button_name" >
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                <div class="form-group">
                                    <label for="company_button_name" class="form-label text-capitalize">
                                        <?php echo e(translate('Button Name')); ?>

                                        <span class="input-label-secondary text--title" data-toggle="tooltip" data-placement="right" data-original-title="Lorem ipsum">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                    </label>
                                    <input id="company_button_name" type="text" placeholder="<?php echo e(translate('Ex: Order now')); ?>" class="form-control h--45px company_button_name" name="company_button_name[]" >
                                </div>
                                <?php endif; ?>
                                    <div class="form-group mb-md-0">
                                        <label for="company_button_url" class="form-label text-capitalize">
                                            <?php echo e(translate('Redirect Link')); ?>

                                            <span class="input-label-secondary text--title" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('The_button_will_direct_users_to_the_link_contained_within_this_box.')); ?>">
                                                <i class="tio-info-outined"></i>
                                            </span>
                                        </label>
                                        <input type="url"  id="company_button_url" placeholder="<?php echo e(translate('Ex: https://www.apple.com/app-store/')); ?>" class="form-control h--45px" name="company_button_url" value="<?php echo e($company_button_url['value']??''); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn--container justify-content-end mt-20">
                    <button type="reset" class="btn btn--reset mb-2"><?php echo e(translate('Reset')); ?></button>
                    <button type="submit"   class="btn btn--primary mb-2"><?php echo e(translate('Save Information')); ?></button>
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
    "use strict";

// $(".company_button_name").on("change", function () {
//     if( $(this).val() !== '' ){
//         $('#company_button_url').removeAttr('readonly').attr('required', true);
//     } else {
//         $('#company_button_url').attr('readonly', true).removeAttr('required');
//     }
// });


</script>
    <?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/landing-page-settings/react-landing-page-company.blade.php ENDPATH**/ ?>