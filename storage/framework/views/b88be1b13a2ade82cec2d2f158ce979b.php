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
    <?php ($fixed_header_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','flutter_landing_page')->where('key','fixed_header_title')->first()); ?>
    <?php ($fixed_header_sub_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','flutter_landing_page')->where('key','fixed_header_sub_title')->first()); ?>
    <?php ($fixed_header_image=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','flutter_landing_page')->where('key','fixed_header_image')->first()); ?>
    <?php ($fixed_module_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','flutter_landing_page')->where('key','fixed_module_title')->first()); ?>
    <?php ($fixed_module_sub_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','flutter_landing_page')->where('key','fixed_module_sub_title')->first()); ?>
    <?php ($fixed_location_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','flutter_landing_page')->where('key','fixed_location_title')->first()); ?>
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
            <form action="<?php echo e(route('admin.business-settings.flutter-landing-page-settings', 'fixed-header')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <h5 class="card-title mb-3">
                    <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span> <span><?php echo e(translate('messages.header_section')); ?></span>
                </h5>
                <div class="card">
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <?php if($language): ?>
                                <div class="col-md-12 lang_form default-form">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="fixed_header_title" class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input id="fixed_header_title" type="text"  maxlength="20" name="fixed_header_title[]" value="<?php echo e($fixed_header_title?->getRawOriginal('value')??''); ?>" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                        </div>
                                        <div class="col-12">
                                            <label for="fixed_header_sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?> (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_120_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input id="fixed_header_sub_title" type="text"  maxlength="120" name="fixed_header_sub_title[]" value="<?php echo e($fixed_header_sub_title?->getRawOriginal('value')??''); ?>" class="form-control" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                                    <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    if(isset($fixed_header_title->translations)&&count($fixed_header_title->translations)){
                                            $fixed_header_title_translate = [];
                                            foreach($fixed_header_title->translations as $t)
                                            {
                                                if($t->locale == $lang && $t->key=='fixed_header_title'){
                                                    $fixed_header_title_translate[$lang]['value'] = $t->value;
                                                }
                                            }

                                        }
                                    if(isset($fixed_header_sub_title->translations)&&count($fixed_header_sub_title->translations)){
                                            $fixed_header_sub_title_translate = [];
                                            foreach($fixed_header_sub_title->translations as $t)
                                            {
                                                if($t->locale == $lang && $t->key=='fixed_header_sub_title'){
                                                    $fixed_header_sub_title_translate[$lang]['value'] = $t->value;
                                                }
                                            }

                                        }
                                        ?>
                                    <div class="col-md-12 d-none lang_form" id="<?php echo e($lang); ?>-form1">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="fixed_header_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input id="fixed_header_title<?php echo e($lang); ?>" type="text"  maxlength="20" name="fixed_header_title[]" value="<?php echo e($fixed_header_title_translate[$lang]['value']??''); ?>" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                            </div>
                                            <div class="col-12">
                                                <label for="fixed_header_sub_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Sub Title')); ?> (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_120_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input type="text"  id="fixed_header_sub_title<?php echo e($lang); ?>" maxlength="120" name="fixed_header_sub_title[]" value="<?php echo e($fixed_header_sub_title_translate[$lang]['value']??''); ?>" class="form-control" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                            </div>
                                        </div>
                                    </div>
                                        <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                <div class="col-md-12">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="fixed_header_title" class="form-label"><?php echo e(translate('Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_50_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input type="text"  id="fixed_header_title" maxlength="50" name="fixed_header_title[]" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                        </div>
                                        <div class="col-12">
                                            <label for="fixed_header_sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_50_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input type="text" id="fixed_header_sub_title"  maxlength="50" name="fixed_header_sub_title[]" class="form-control" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                        </div>
                                    </div>
                                </div>
                                    <input type="hidden" name="lang[]" value="default">
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label d-block mb-2">
                                    <?php echo e(translate('messages.Image')); ?>  <span class="text--primary"><?php echo e(translate('(size: 1:1)')); ?></span>
                                </label>
                                <label class="upload-img-3 m-0">
                                    <div class="position-relative">
                                    <div class="img">
                                        <img

                                        src="<?php echo e(\App\CentralLogics\Helpers::get_full_url('fixed_header_image', $fixed_header_image?->value?? '', $fixed_header_image?->storage[0]?->value ?? 'public','aspect_1')); ?>" data-onerror-image="<?php echo e(asset('/public/assets/admin/img/aspect-1.png')); ?>" alt="" class="img__aspect-1 min-w-187px max-w-187px onerror-image">
                                    </div>
                                      <input type="file"  name="image" hidden>
                                        <?php if(isset($fixed_header_image['value'])): ?>
                                            <span id="fixed_header_image" class="remove_image_button remove-image"
                                                  data-id="fixed_header_image"
                                                  data-title="<?php echo e(translate('Warning!')); ?>"
                                                  data-text="<p><?php echo e(translate('Are_you_sure_you_want_to_remove_this_image_?')); ?></p>"
                                            > <i class="tio-clear"></i></span>

                                            <?php endif; ?>
                                        </div>
                                </label>
                            </div>
                        </div>
                        <div class="btn--container justify-content-end mt-20">
                            <button type="reset" class="btn btn--reset mb-2"><?php echo e(translate('Reset')); ?></button>
                            <button type="submit"   class="btn btn--primary mb-2"><?php echo e(translate('Save')); ?></button>
                        </div>
                    </div>
                </div>
            </form>
            <form  id="fixed_header_image_form" action="<?php echo e(route('admin.remove_image')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo e($fixed_header_image?->id); ?>" >
                <input type="hidden" name="model_name" value="DataSetting" >
                <input type="hidden" name="image_path" value="fixed_header_image" >
                <input type="hidden" name="field_name" value="value" >
            </form>
            <form action="<?php echo e(route('admin.business-settings.flutter-landing-page-settings', 'fixed-location')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <h5 class="card-title mb-3 mt-3">
                    <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span> <span><?php echo e(translate('messages.location_setup')); ?></span>
                </h5>
                <div class="card">
                    <div class="card-body">
                        <?php if($language): ?>
                            <div class="row g-3 lang_form default-form">
                                <div class="col-sm-12">
                                    <label for="fixed_location_title" class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_30_characters')); ?>">
                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                    </span></label>
                            <input type="text"  id="fixed_location_title" maxlength="30" name="fixed_location_title[]" class="form-control" value="<?php echo e($fixed_location_title?->getRawOriginal('value')??''); ?>" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                </div>
                            </div>
                            <input type="hidden" name="lang[]" value="default">
                                <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                if(isset($fixed_location_title->translations)&&count($fixed_location_title->translations)){
                                        $fixed_location_title_translate = [];
                                        foreach($fixed_location_title->translations as $t)
                                        {
                                            if($t->locale == $lang && $t->key=='fixed_location_title'){
                                                $fixed_location_title_translate[$lang]['value'] = $t->value;
                                            }
                                        }

                                    }
                                    ?>
                                    <div class="row g-3 d-none lang_form" id="<?php echo e($lang); ?>-form2">
                                        <div class="col-sm-12">
                                            <label for="fixed_location_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_30_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input id="fixed_location_title<?php echo e($lang); ?>" type="text"  maxlength="30" name="fixed_location_title[]" class="form-control" value="<?php echo e($fixed_location_title_translate[$lang]['value']?? ''); ?>" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                        </div>
                                    </div>
                                    <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="row g-3">
                                    <div class="col-sm-12">
                                        <label for="fixed_location_title" class="form-label"><?php echo e(translate('Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_30_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input id="fixed_location_title" type="text"  maxlength="30" name="fixed_location_title[]" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                    </div>
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                            <?php endif; ?>
                        <div class="btn--container justify-content-end mt-20">
                            <button type="reset" class="btn btn--reset mb-2"><?php echo e(translate('Reset')); ?></button>
                            <button type="submit"   class="btn btn--primary mb-2"><?php echo e(translate('Add')); ?></button>
                        </div>
                    </div>
                </div>
            </form>
            <form action="<?php echo e(route('admin.business-settings.flutter-landing-page-settings', 'fixed-module')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <h5 class="card-title mb-3 mt-3">
                    <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span> <span><?php echo e(translate('messages.module_setup')); ?></span>
                </h5>
                <div class="card">
                    <div class="card-body">

                        <?php if($language): ?>
                            <div class="row g-3 lang_form default-form">
                                <div class="col-sm-6">
                                    <label for="fixed_module_title" class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_40_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input id="fixed_module_title" type="text"  maxlength="40" name="fixed_module_title[]" class="form-control" value="<?php echo e($fixed_module_title?->getRawOriginal('value')??''); ?>" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                </div>
                                <div class="col-sm-6">
                                    <label  for="fixed_module_sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?> (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input id="fixed_module_sub_title" type="text"  maxlength="80" name="fixed_module_sub_title[]" class="form-control" value="<?php echo e($fixed_module_sub_title?->getRawOriginal('value')??''); ?>" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                </div>
                            </div>
                            <input type="hidden" name="lang[]" value="default">
                                <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                if(isset($fixed_module_title->translations)&&count($fixed_module_title->translations)){
                                        $fixed_module_title_translate = [];
                                        foreach($fixed_module_title->translations as $t)
                                        {
                                            if($t->locale == $lang && $t->key=='fixed_module_title'){
                                                $fixed_module_title_translate[$lang]['value'] = $t->value;
                                            }
                                        }

                                    }
                                if(isset($fixed_module_sub_title->translations)&&count($fixed_module_sub_title->translations)){
                                        $fixed_module_sub_title_translate = [];
                                        foreach($fixed_module_sub_title->translations as $t)
                                        {
                                            if($t->locale == $lang && $t->key=='fixed_module_sub_title'){
                                                $fixed_module_sub_title_translate[$lang]['value'] = $t->value;
                                            }
                                        }

                                    }
                                    ?>
                                    <div class="row g-3 d-none lang_form" id="<?php echo e($lang); ?>-form">
                                        <div class="col-sm-6">
                                            <label for="fixed_module_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_40_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input id="fixed_module_title<?php echo e($lang); ?>" type="text"  maxlength="40" name="fixed_module_title[]" class="form-control" value="<?php echo e($fixed_module_title_translate[$lang]['value']?? ''); ?>" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="fixed_module_sub_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Sub Title')); ?> (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input id="fixed_module_sub_title<?php echo e($lang); ?>" type="text"  maxlength="80" name="fixed_module_sub_title[]" class="form-control" value="<?php echo e($fixed_module_sub_title_translate[$lang]['value']?? ''); ?>" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                        </div>
                                    </div>
                                    <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label for="fixed_module_title" class="form-label"><?php echo e(translate('Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_40_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input id="fixed_module_title" type="text"  maxlength="40" name="fixed_module_title[]" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="fixed_module_sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input id="fixed_module_sub_title" type="text"  maxlength="80" name="fixed_module_sub_title[]" class="form-control" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                    </div>
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                            <?php endif; ?>
                        <div class="alert alert--primary d-flex mt-4">
                            <div class="alert--icon">
                                <i class="tio-info"></i>
                            </div>
                            <div>
                                <?php echo e(translate('NB_:_All_the_modules_and_their_information_will_be_dynamically_added_from_the_module_setup_section._You_just_need_to_add_the_title_and_subtitle_of_the_Module_List_Section.')); ?>

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

    <!-- How it Works -->
    <?php echo $__env->make('admin-views.business-settings.landing-page-settings.partial.how-it-work-flutter', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/landing-page-settings/flutter-fixed-data.blade.php ENDPATH**/ ?>