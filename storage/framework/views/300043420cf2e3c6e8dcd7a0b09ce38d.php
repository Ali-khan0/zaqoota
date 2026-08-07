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
                <h3 class="mb-1"><?php echo e(translate('Footer Section')); ?></h3>
                <p class="mb-0 gray-dark fs-12">
                    <?php echo e(translate('See how your Footer Section will look to customers.')); ?>

                </p>
            </div>
            <div class="max-w-300px ml-sm-auto">
                <button type="button" class="btn btn-outline-primary py-2 fs-12 px-3 offcanvas-trigger" data-target="#footerPreview_section">
                    <i class="tio-invisible"></i> <?php echo e(translate('Section Preview')); ?>

                </button>
            </div>
        </div>
    </div>
    <!-- <?php ($fixed_newsletter_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','fixed_newsletter_title')->first()); ?>
    <?php ($fixed_newsletter_sub_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','fixed_newsletter_sub_title')->first()); ?>
    <?php ($fixed_footer_description=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','fixed_footer_description')->first()); ?>
    <?php ($fixed_promotional_banner=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','react_landing_page')->where('key','fixed_promotional_banner')->first()); ?>
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
    <?php endif; ?> -->
    <div class="tab-content">
        <div class="tab-pane fade show active">
            <!-- <form action="<?php echo e(route('admin.business-settings.react-landing-page-settings', 'fixed-banner')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <h5 class="card-title mt-3 mb-3">
                    <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span> <span><?php echo e(translate('promotional_Banner')); ?></span>
                </h5>
                <div class="card mb-3">
                    <div class="card-body">

                        <div class="row g-3">
                            <div class="col-md-7">
                                <label class="form-label d-block mb-2">
                                    <?php echo e(translate('Banner')); ?>  <span class="text--primary"><?php echo e(translate('(size: 2:1)')); ?></span>
                                </label>
                                <label class="upload-img-3 m-2 d-block">
                                    <div class="position-relative">
                                    <div class="img">
                                        <img
                                        src="<?php echo e(\App\CentralLogics\Helpers::get_full_url('promotional_banner', $fixed_promotional_banner?->value?? '', $fixed_promotional_banner?->storage[0]?->value ?? 'public','upload_image_4')); ?>"

                                        data-onerror-image="<?php echo e(asset('/public/assets/admin/img/upload-4.png')); ?>" class="vertical-img mw-100 vertical onerror-image" alt="">
                                    </div>
                                        <input type="file" name="fixed_promotional_banner"  hidden>
                                           <?php if(isset($fixed_promotional_banner['value'])): ?>

                                            <span id="promotional_banner" class="remove_image_button remove-image"
                                                  data-id="promotional_banner"
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
            <form  id="promotional_banner_form" action="<?php echo e(route('admin.remove_image')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo e($fixed_promotional_banner?->id); ?>" >
                <input type="hidden" name="model_name" value="DataSetting" >
                <input type="hidden" name="image_path" value="promotional_banner" >
                <input type="hidden" name="field_name" value="value" >
            </form> -->
            <form action="<?php echo e(route('admin.business-settings.react-landing-page-settings', 'fixed-newsletter')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="mb-20">
                            <h4 class="mb-1"><?php echo e(translate('Newsletter ')); ?></h4>
                            <p class="mb-0 fs-12"><?php echo e(translate('Manage the title and subtitle for the email newsletter sign-up section.')); ?></p>
                        </div>
                        <div class="bg--secondary rounded p-xxl-4 p-3">
                            <?php if($language): ?>
                                <ul class="nav nav-tabs mb-4 border-bottom">
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
                            <?php if($language): ?>
                            <div class="row g-1 lang_form default-form">
                                <div class="col-sm-12">
                                    <label for="fixed_newsletter_title"  class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(translate('messages.default')); ?>)
                                    <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_30_characters')); ?>">
                                                <i class="tio-info color-A7A7A7"></i>
                                            </span>
                                            <span class="form-label-secondary text-danger"
                                            data-toggle="tooltip" data-placement="right"
                                            data-original-title="<?php echo e(translate('messages.Required.')); ?>">
                                            </span>
                                        <span class="form-label-secondary text-danger"
                                              data-toggle="tooltip" data-placement="right"
                                              data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                    </span>

                                        </label>
                                    <input id="fixed_newsletter_title" type="text"  maxlength="30" name="fixed_newsletter_title[]" class="form-control" value="<?php echo e($fixed_newsletter_title?->getRawOriginal('value')??''); ?>" placeholder="<?php echo e(translate('messages.title_here...')); ?>" required>
                                    <span class="text-right text-counting color-A7A7A7 d-block mt-1">0/30</span>
                                </div>
                                <div class="col-sm-12">
                                    <label for="fixed_newsletter_sub_title"  class="form-label"><?php echo e(translate('Sub Title')); ?> (<?php echo e(translate('messages.default')); ?>)
                                    <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_100_characters')); ?>">
                                                <i class="tio-info color-A7A7A7"></i>
                                            </span><span class="form-label-secondary text-danger"
                                            data-toggle="tooltip" data-placement="right"
                                            data-original-title="<?php echo e(translate('messages.Required.')); ?>">
                                            </span>
                                        <span class="form-label-secondary text-danger"
                                              data-toggle="tooltip" data-placement="right"
                                              data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                    </span>
                                    </label>
                                    <input id="fixed_newsletter_sub_title" type="text"  maxlength="100" name="fixed_newsletter_sub_title[]" class="form-control" value="<?php echo e($fixed_newsletter_sub_title?->getRawOriginal('value')??''); ?>" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>" required>
                                    <span class="text-right text-counting color-A7A7A7 d-block mt-1">0/100</span>
                                </div>
                            </div>
                            <input type="hidden" name="lang[]" value="default">
                                <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                if(isset($fixed_newsletter_title->translations)&&count($fixed_newsletter_title->translations)){
                                        $fixed_newsletter_title_translate = [];
                                        foreach($fixed_newsletter_title->translations as $t)
                                        {
                                            if($t->locale == $lang && $t->key=='fixed_newsletter_title'){
                                                $fixed_newsletter_title_translate[$lang]['value'] = $t->value;
                                            }
                                        }

                                    }
                                if(isset($fixed_newsletter_sub_title->translations)&&count($fixed_newsletter_sub_title->translations)){
                                        $fixed_newsletter_sub_title_translate = [];
                                        foreach($fixed_newsletter_sub_title->translations as $t)
                                        {
                                            if($t->locale == $lang && $t->key=='fixed_newsletter_sub_title'){
                                                $fixed_newsletter_sub_title_translate[$lang]['value'] = $t->value;
                                            }
                                        }

                                    }
                                    ?>
                                    <div class="row g-1 d-none lang_form" id="<?php echo e($lang); ?>-form">
                                        <div class="col-sm-12">
                                            <label for="fixed_newsletter_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_30_characters')); ?>">
                                                <i class="tio-info color-A7A7A7"></i>
                                            </span></label>
                                    <input id="fixed_newsletter_title<?php echo e($lang); ?>" type="text"  maxlength="30" name="fixed_newsletter_title[]" class="form-control" value="<?php echo e($fixed_newsletter_title_translate[$lang]['value']?? ''); ?>" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                    <span class="text-right text-counting color-A7A7A7 d-block mt-1">0/30</span>
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="fixed_newsletter_sub_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Sub Title')); ?> (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_100_characters')); ?>">
                                                <i class="tio-info color-A7A7A7"></i>
                                            </span></label>
                                    <input id="fixed_newsletter_sub_title<?php echo e($lang); ?>" type="text"  maxlength="100" name="fixed_newsletter_sub_title[]" class="form-control" value="<?php echo e($fixed_newsletter_sub_title_translate[$lang]['value']?? ''); ?>" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                    <span class="text-right text-counting color-A7A7A7 d-block mt-1">0/100</span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="row g-3">
                                    <div class="col-sm-12">
                                        <label for="fixed_newsletter_title" class="form-label"><?php echo e(translate('Title')); ?></label>
                                        <input id="fixed_newsletter_title" type="text" maxlength="30" name="fixed_newsletter_title[]" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                        <span class="text-right text-counting color-A7A7A7 d-block mt-1">0/30</span>
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="fixed_newsletter_sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?></label>
                                        <input id="fixed_newsletter_sub_title" type="text" maxlength="100" name="fixed_newsletter_sub_title[]" class="form-control" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                        <span class="text-right text-counting color-A7A7A7 d-block mt-1">0/100</span>
                                    </div>
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="mb-20">
                            <h4 class="mb-1"><?php echo e(translate('Footer Article ')); ?></h4>
                            <p class="mb-0 fs-12"><?php echo e(translate('Set the main description or tagline for your company in the footer.')); ?></p>
                        </div>
                        <div class="bg--secondary rounded p-xxl-4 p-3">
                            <?php if($language): ?>
                                <ul class="nav nav-tabs mb-4 border-bottom">
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
                            <div class="row g-3">
                                <div class="col-12">
                                    <?php if($language): ?>
                                <div class="row g-3 lang_form default-form">
                                    <div class="col-12">
                                        <label for="fixed_footer_description" class="form-label"><?php echo e(translate('short_Description')); ?> (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_120_characters')); ?>">
                                                    <i class="tio-info color-A7A7A7"></i>
                                                </span></label>
                                        <input id="fixed_footer_description" type="text"  maxlength="120" name="fixed_footer_description[]" class="form-control" value="<?php echo e($fixed_footer_description?->getRawOriginal('value')??''); ?>" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                        <span class="text-right text-counting color-A7A7A7 d-block mt-1">0/120</span>
                                    </div>
                                </div>
                                    <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    if(isset($fixed_footer_description->translations)&&count($fixed_footer_description->translations)){
                                            $fixed_footer_description_translate = [];
                                            foreach($fixed_footer_description->translations as $t)
                                            {
                                                if($t->locale == $lang && $t->key=='fixed_footer_description'){
                                                    $fixed_footer_description_translate[$lang]['value'] = $t->value;
                                                }
                                            }

                                        }
                                        ?>
                                        <div class="row g-3 d-none lang_form" id="<?php echo e($lang); ?>-form1">
                                            <div class="col-12">
                                                <label for="fixed_footer_description<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('short_Description')); ?> (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_120_characters')); ?>">
                                                    <i class="tio-info color-A7A7A7"></i>
                                                </span></label>
                                        <input id="fixed_footer_description<?php echo e($lang); ?>" type="text"  maxlength="120" name="fixed_footer_description[]" class="form-control" value="<?php echo e($fixed_footer_description_translate[$lang]['value']?? ''); ?>" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                        <span class="text-right text-counting color-A7A7A7 d-block mt-1">0/120</span>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="fixed_footer_description" class="form-label"><?php echo e(translate('short_Description')); ?></label>
                                            <input id="fixed_footer_description" type="text" name="fixed_footer_description[]" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                        </div>
                                    </div>
                                <?php endif; ?>
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
<div id="footerPreview_section" class="custom-offcanvas offcanvas-750 d-flex flex-column justify-content-between">
    <form action="<?php echo e(route('taxvat.store')); ?>" method="post">
        <div>
            <div class="custom-offcanvas-header bg--secondary d-flex justify-content-between align-items-center px-3 py-3">
                <div class="py-1">
                    <h3 class="mb-0 line--limit-1"><?php echo e(translate('messages.Footer Section Preview')); ?></h3>
                </div>
                <button type="button" class="btn-close w-25px h-25px border rounded-circle d-center bg--secondary text-dark offcanvas-close fz-15px p-0"aria-label="Close">
                    &times;
                </button>
            </div>
            <div class="custom-offcanvas-body custom-offcanvas-body-100  p-20">
               <section class="common-section-view bg-white border rounded-10">
                    <div class="container p-0">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="banner-thumb w-100 h-100 rounded-10">
                                    <img src="<?php echo e(asset('/public/assets/admin/img/400x400/footer-preview.png')); ?>" alt="" class="w-100">
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

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/landing-page-settings/react-landing-page-footer.blade.php ENDPATH**/ ?>