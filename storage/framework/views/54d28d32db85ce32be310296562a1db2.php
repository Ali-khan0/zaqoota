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
    <?php ($fixed_header_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key','fixed_header_title')->first()); ?>
    <?php ($fixed_header_sub_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key','fixed_header_sub_title')->first()); ?>
    <?php ($fixed_module_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key','fixed_module_title')->first()); ?>
    <?php ($fixed_module_sub_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key','fixed_module_sub_title')->first()); ?>
    <?php ($fixed_referal_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key','fixed_referal_title')->first()); ?>
    <?php ($fixed_referal_sub_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key','fixed_referal_sub_title')->first()); ?>
    <?php ($fixed_newsletter_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key','fixed_newsletter_title')->first()); ?>
    <?php ($fixed_newsletter_sub_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key','fixed_newsletter_sub_title')->first()); ?>
    <?php ($fixed_footer_article_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key','fixed_footer_article_title')->first()); ?>
    <?php ($fixed_link = \App\Models\DataSetting::where(['key'=>'fixed_link','type'=>'admin_landing_page'])->first()); ?>
    <?php ($fixed_link = isset($fixed_link->value)?json_decode($fixed_link->value, true):null); ?>
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
            <form action="<?php echo e(route('admin.business-settings.admin-landing-page-settings', 'fixed-data')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php if($language): ?>
                <div class="lang_form"  id="default-form">
                    <h5 class="card-title mb-3">
                        <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span><?php echo e(translate('messages.header_section')); ?> (<?php echo e(translate('messages.default')); ?>)</span>
                    </h5>
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="fixed_header_title" class="form-label"><?php echo e(translate('Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_50_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input id="fixed_header_title" type="text"  maxlength="50" name="fixed_header_title[]" value="<?php echo e($fixed_header_title?->getRawOriginal('value')); ?>" class="form-control" placeholder="<?php echo e(translate('Ex_:_Manage_your_daily_life_on_one_platform')); ?>">
                                </div>
                                <div class="col-sm-6">
                                    <label for="fixed_header_sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_sub_title_within_100_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input id="fixed_header_sub_title" type="text"  maxlength="100" name="fixed_header_sub_title[]" value="<?php echo e($fixed_header_sub_title?->getRawOriginal('value')); ?>" class="form-control" placeholder="<?php echo e(translate('Ex_:_More_than_just_a_reliable_eCommerce_platform')); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <h5 class="card-title mb-3 mt-3">
                        <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span><?php echo e(translate('messages.module_list_section')); ?> (<?php echo e(translate('messages.default')); ?>)</span>
                    </h5>
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="fixed_module_title" class="form-label"><?php echo e(translate('Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_50_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input id="fixed_module_title" type="text"  maxlength="50" name="fixed_module_title[]" value="<?php echo e($fixed_module_title?->getRawOriginal('value')); ?>" class="form-control" placeholder="<?php echo e(translate('Ex_:_Your_eCommerce_venture_starts_here')); ?>">
                                </div>
                                <div class="col-sm-6">
                                    <label for="fixed_module_sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_sub_title_within_100_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input id="fixed_module_sub_title" type="text"  maxlength="100" name="fixed_module_sub_title[]" value="<?php echo e($fixed_module_sub_title?->getRawOriginal('value')); ?>" class="form-control" placeholder="<?php echo e(translate('Ex_:_Enjoy_all_services_in_one_platform')); ?>">
                                </div>
                            </div>
                            <div class="alert alert-warning d-flex mt-4 mb-0">
                                <div class="alert--icon">
                                    <i class="tio-info"></i>
                                </div>
                                <div>
                                    <?php echo e(translate('NB_:_All_the_modules_and_their_information_will_be_dynamically_added_from_the_module_setup_section._You_just_need_to_add_the_title_and_subtitle_of_the_Module_List_Section.')); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <h5 class="card-title mb-3 mt-3">
                        <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span><?php echo e(translate('Referral & Earning')); ?> (<?php echo e(translate('messages.default')); ?>)</span>
                    </h5>
                    <div class="card">
                        <div class="card-body">

                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="fixed_referal_title" class="form-label"><?php echo e(translate('Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_40_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input id="fixed_referal_title" type="text"  maxlength="40" name="fixed_referal_title[]" value="<?php echo e($fixed_referal_title?->getRawOriginal('value')); ?>" class="form-control" placeholder="<?php echo e(translate('Ex_:_Earn_Point')); ?>">
                                </div>
                                <div class="col-sm-6">
                                    <label for="fixed_referal_sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_sub_title_within_80_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input  id="fixed_referal_sub_title" type="text"  maxlength="80" name="fixed_referal_sub_title[]" value="<?php echo e($fixed_referal_sub_title?->getRawOriginal('value')); ?>" class="form-control" placeholder="<?php echo e(translate('Ex_:_By_referring_your_friend')); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <h5 class="card-title mb-3 mt-3">
                        <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span><?php echo e(translate('newsletter')); ?> (<?php echo e(translate('messages.default')); ?>)</span>
                    </h5>
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <label for="fixed_newsletter_title" class="form-label"><?php echo e(translate('Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_40_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input id="fixed_newsletter_title" type="text"  maxlength="40" name="fixed_newsletter_title[]" value="<?php echo e($fixed_newsletter_title?->getRawOriginal('value')); ?>" class="form-control" placeholder="<?php echo e(translate('Ex_:_Sign_Up_to_Our_Newsletter')); ?>">
                                </div>
                                <div class="col-sm-6">
                                    <label for="fixed_newsletter_sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_sub_title_within_80_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input id="fixed_newsletter_sub_title" type="text"  maxlength="80" name="fixed_newsletter_sub_title[]" value="<?php echo e($fixed_newsletter_sub_title?->getRawOriginal('value')); ?>" class="form-control" placeholder="<?php echo e(translate('Ex_:_Receive_Latest_News,_Updates_and_Many_Other_News_Every_Week')); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <h5 class="card-title mb-3 mt-3">
                        <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span><?php echo e(translate('Footer_Article')); ?> (<?php echo e(translate('messages.default')); ?>)</span>
                    </h5>
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="fixed_footer_article_title" class="form-label"><?php echo e(translate('Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_180_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input id="fixed_footer_article_title" type="text"  maxlength="180" name="fixed_footer_article_title[]" value="<?php echo e($fixed_footer_article_title?->getRawOriginal('value')); ?>" class="form-control" placeholder="<?php echo e(translate('Ex_:_6amMart_is_a_complete_package!__It`s_time_to_empower_your_multivendor_online_business_with__powerful_features!')); ?>">
                                </div>
                            </div>
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
                    if(isset($fixed_referal_title->translations)&&count($fixed_referal_title->translations)){
                            $fixed_referal_title_translate = [];
                            foreach($fixed_referal_title->translations as $t)
                            {
                                if($t->locale == $lang && $t->key=='fixed_referal_title'){
                                    $fixed_referal_title_translate[$lang]['value'] = $t->value;
                                }
                            }

                        }
                    if(isset($fixed_referal_sub_title->translations)&&count($fixed_referal_sub_title->translations)){
                            $fixed_referal_sub_title_translate = [];
                            foreach($fixed_referal_sub_title->translations as $t)
                            {
                                if($t->locale == $lang && $t->key=='fixed_referal_sub_title'){
                                    $fixed_referal_sub_title_translate[$lang]['value'] = $t->value;
                                }
                            }

                        }
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
                    if(isset($fixed_footer_article_title->translations)&&count($fixed_footer_article_title->translations)){
                        $fixed_footer_article_title_translate = [];
                        foreach($fixed_footer_article_title->translations as $t)
                        {
                            if($t->locale == $lang && $t->key=='fixed_footer_article_title'){
                                $fixed_footer_article_title_translate[$lang]['value'] = $t->value;
                            }
                        }

                    }
                    ?>
                        <div class="d-none lang_form" id="<?php echo e($lang); ?>-form">
                            <h5 class="card-title mb-3">
                                <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span><?php echo e(translate('messages.header_section')); ?> (<?php echo e(strtoupper($lang)); ?>)</span>
                            </h5>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <label for="fixed_header_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_50_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                            <input id="fixed_header_title<?php echo e($lang); ?>" type="text"  maxlength="50" name="fixed_header_title[]" value="<?php echo e($fixed_header_title_translate[$lang]['value']??''); ?>" class="form-control" placeholder="<?php echo e(translate('Ex_:_Manage_your_daily_life_on_one_platform')); ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="fixed_header_sub_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Sub Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_sub_title_within_100_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                            <input id="fixed_header_sub_title<?php echo e($lang); ?>" type="text"  maxlength="100" name="fixed_header_sub_title[]" value="<?php echo e($fixed_header_sub_title_translate[$lang]['value']??''); ?>" class="form-control" placeholder="<?php echo e(translate('Ex_:_More_than_just_a_reliable_eCommerce_platform')); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h5 class="card-title mb-3 mt-3">
                                <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span><?php echo e(translate('messages.module_list_section')); ?> (<?php echo e(strtoupper($lang)); ?>)</span>
                            </h5>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <label for="fixed_module_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_50_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                            <input  id="fixed_module_title<?php echo e($lang); ?>" type="text"  maxlength="50" name="fixed_module_title[]" value="<?php echo e($fixed_module_title_translate[$lang]['value']??''); ?>" class="form-control" placeholder="<?php echo e(translate('Ex_:_Your_eCommerce_venture_starts_here')); ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="fixed_module_sub_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Sub Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_sub_title_within_100_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                            <input id="fixed_module_sub_title<?php echo e($lang); ?>" type="text"  maxlength="100" name="fixed_module_sub_title[]" value="<?php echo e($fixed_module_sub_title_translate[$lang]['value']??''); ?>" class="form-control" placeholder="<?php echo e(translate('Ex_:_Enjoy_all_services_in_one_platform')); ?>">
                                        </div>
                                    </div>
                                    <div class="alert alert-warning d-flex mt-4 mb-0">
                                        <div class="alert--icon">
                                            <i class="tio-info"></i>
                                        </div>
                                        <div>
                                            <?php echo e(translate('NB_:_All_the_modules_and_their_information_will_be_dynamically_added_from_the_module_setup_section._You_just_need_to_add_the_title_and_subtitle_of_the_Module_List_Section.')); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h5 class="card-title mb-3 mt-3">
                                <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span><?php echo e(translate('Referral & Earning')); ?> (<?php echo e(strtoupper($lang)); ?>)</span>
                            </h5>
                            <div class="card">
                                <div class="card-body">

                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <label for="fixed_referal_title<?php echo e($lang); ?>"  class="form-label"><?php echo e(translate('Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_40_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                            <input id="fixed_referal_title<?php echo e($lang); ?>"  type="text"  maxlength="40" name="fixed_referal_title[]" value="<?php echo e($fixed_referal_title_translate[$lang]['value']??''); ?>" class="form-control" placeholder="<?php echo e(translate('Ex_:_Earn_Point')); ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="fixed_referal_sub_title<?php echo e($lang); ?>"  class="form-label"><?php echo e(translate('Sub Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_sub_title_within_80_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                            <input id="fixed_referal_sub_title<?php echo e($lang); ?>"  type="text"  maxlength="80" name="fixed_referal_sub_title[]" value="<?php echo e($fixed_referal_sub_title_translate[$lang]['value']??''); ?>" class="form-control" placeholder="<?php echo e(translate('Ex_:_By_referring_your_friend')); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h5 class="card-title mb-3 mt-3">
                                <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span><?php echo e(translate('newsletter')); ?> (<?php echo e(strtoupper($lang)); ?>)</span>
                            </h5>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <label for="fixed_newsletter_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_40_characters')); ?>">
                                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                                    </span></label>
                                            <input id="fixed_newsletter_title<?php echo e($lang); ?>" type="text"  maxlength="40" name="fixed_newsletter_title[]" value="<?php echo e($fixed_newsletter_title_translate[$lang]['value']??''); ?>" class="form-control" placeholder="<?php echo e(translate('Ex_:_Sign_Up_to_Our_Newsletter')); ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="fixed_newsletter_sub_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Sub Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_sub_title_within_80_characters')); ?>">
                                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                                    </span></label>
                                            <input id="fixed_newsletter_sub_title<?php echo e($lang); ?>" type="text"  maxlength="80" name="fixed_newsletter_sub_title[]" value="<?php echo e($fixed_newsletter_sub_title_translate[$lang]['value']??''); ?>" class="form-control" placeholder="<?php echo e(translate('Ex_:_Receive_Latest_News,_Updates_and_Many_Other_News_Every_Week')); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h5 class="card-title mb-3 mt-3">
                                <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span><?php echo e(translate('Footer_Article')); ?> (<?php echo e(strtoupper($lang)); ?>)</span>
                            </h5>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="fixed_footer_article_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_180_characters')); ?>">
                                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                                    </span></label>
                                            <input id="fixed_footer_article_title<?php echo e($lang); ?>" type="text"  maxlength="180" name="fixed_footer_article_title[]" value="<?php echo e($fixed_footer_article_title_translate[$lang]['value']??''); ?>" class="form-control" placeholder="<?php echo e(translate('Ex_:_6amMart_is_a_complete_package!__It`s_time_to_empower_your_multivendor_online_business_with__powerful_features!')); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div>
                        <h5 class="card-title mb-3">
                            <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span><?php echo e(translate('messages.header_section')); ?></span>
                        </h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label for="fixed_header_title" class="form-label"><?php echo e(translate('Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_50_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                        <input  id="fixed_header_title" type="text"  maxlength="50" name="fixed_header_title[]" class="form-control" placeholder="<?php echo e(translate('Ex_:_Manage_your_daily_life_on_one_platform')); ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="fixed_header_sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_sub_title_within_50_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                        <input id="fixed_header_sub_title" type="text"  maxlength="50" name="fixed_header_sub_title[]" class="form-control" placeholder="<?php echo e(translate('Ex_:_More_than_just_a_reliable_eCommerce_platform')); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title mb-3 mt-3">
                            <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span><?php echo e(translate('messages.module_list_section')); ?></span>
                        </h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label for="fixed_module_title" class="form-label"><?php echo e(translate('Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_50_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                        <input id="fixed_module_title" type="text"  maxlength="50" name="fixed_module_title[]" class="form-control" placeholder="<?php echo e(translate('Ex_:_Your_eCommerce_venture_starts_here')); ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="fixed_module_sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_sub_title_within_50_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                        <input type="text"  id="fixed_module_sub_title" maxlength="50" name="fixed_module_sub_title[]" class="form-control" placeholder="<?php echo e(translate('Ex_:_Enjoy_all_services_in_one_platform')); ?>">
                                    </div>
                                </div>
                                <div class="alert alert-warning d-flex mt-4 mb-0">
                                    <div class="alert--icon">
                                        <i class="tio-info"></i>
                                    </div>
                                    <div>
                                        <?php echo e(translate('NB_:_All_the_modules_and_their_information_will_be_dynamically_added_from_the_module_setup_section._You_just_need_to_add_the_title_and_subtitle_of_the_Module_List_Section.')); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title mb-3 mt-3">
                            <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span><?php echo e(translate('Referral & Earning')); ?></span>
                        </h5>

                        <div class="card">
                            <div class="card-body">

                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label for="fixed_ref_title" class="form-label"><?php echo e(translate('Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_50_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                        <input id="fixed_ref_title" type="text"  maxlength="50" name="fixed_referal_title[]" class="form-control" placeholder="<?php echo e(translate('Ex_:_Earn_Point')); ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="fixed_ref_sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_sub_title_within_50_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                        <input id="fixed_ref_sub_title" type="text"  maxlength="50" name="fixed_referal_sub_title[]" class="form-control" placeholder="<?php echo e(translate('Ex_:_By_referring_your_friend')); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title mb-3 mt-3">
                            <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span><?php echo e(translate('newsletter')); ?> (<?php echo e(translate('messages.default')); ?>)</span>
                        </h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label for="fixed_newsletter_title" class="form-label"><?php echo e(translate('Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_50_characters')); ?>">
                                                    <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                                </span></label>
                                        <input id="fixed_newsletter_title" type="text"  maxlength="50" name="fixed_newsletter_title[]" class="form-control" placeholder="<?php echo e(translate('Ex_:_Sign_Up_to_Our_Newsletter')); ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="fixed_newsletter_sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_sub_title_within_50_characters')); ?>">
                                                    <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                                </span></label>
                                        <input id="fixed_newsletter_sub_title" type="text"  maxlength="50" name="fixed_newsletter_sub_title[]"  class="form-control" placeholder="<?php echo e(translate('Ex_:_Receive_Latest_News,_Updates_and_Many_Other_News_Every_Week')); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h5 class="card-title mb-3 mt-3">
                            <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span> <span><?php echo e(translate('Footer_Article')); ?> (<?php echo e(translate('messages.default')); ?>)</span>
                        </h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="fixed_footer_article_title" class="form-label"><?php echo e(translate('Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_50_characters')); ?>">
                                                    <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                                </span></label>
                                        <input id="fixed_footer_article_title" type="text"  maxlength="50" name="fixed_footer_article_title[]"  class="form-control" placeholder="<?php echo e(translate('Ex_:_6amMart_is_a_complete_package!__It`s_time_to_empower_your_multivendor_online_business_with__powerful_features!')); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="lang[]" value="default">
                <?php endif; ?>
                <h5 class="card-title card-title mb-3 mt-3">
                    <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span>
                    <span><?php echo e(translate('Browse Web Button')); ?></span>
                </h5>
                <div class="card">
                    <div class="__bg-F8F9FC-card">
                        <div class="form-group mb-md-0">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label for="web_app_url" class="form-label text-capitalize m-0">
                                    <?php echo e(translate('Web Link')); ?>


                                </label>
                                <label class="toggle-switch toggle-switch-sm m-0">
                                    <input type="checkbox" name="web_app_url_status" id="apple-dm-status"
                                           data-id="apple-dm-status"
                                           data-type="status"
                                           data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/apple-on.png')); ?>"
                                           data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/apple-off.png')); ?>"
                                           data-title-on="<?php echo e(translate('Browse Web Button Enabled for Landing Page')); ?>"
                                           data-title-off="<?php echo e(translate('Browse Web Button Disabled for Landing Page')); ?>"
                                           data-text-on="<p><?php echo e(translate('Browse Web button is enabled now everyone can use or see the button')); ?></p>"
                                           data-text-off="<p><?php echo e(translate('Browse Web button is disabled now no one can use or see the button')); ?></p>"
                                           class="status toggle-switch-input dynamic-checkbox"


                                           value="1" <?php echo e((isset($fixed_link) && $fixed_link['web_app_url_status'])?'checked':''); ?>>
                                    <span class="toggle-switch-label text mb-0">
                                        <span class="toggle-switch-indicator"></span>
                                    </span>
                                </label>
                            </div>
                            <input id="web_app_url" type="text" placeholder="<?php echo e(translate('Ex: https://6ammart-web.6amtech.com/')); ?>" class="form-control h--45px" name="web_app_url" value="<?php echo e($fixed_link['web_app_url'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
                <div class="btn--container justify-content-end mt-20">
                    <button type="reset" class="btn btn--reset mb-2"><?php echo e(translate('Reset')); ?></button>
                    <button type="submit" class="btn btn--primary mb-2"><?php echo e(translate('Save Information')); ?></button>
                </div>
            </form>
            <!-- Module Setup Section View -->
            <div class="modal fade" id="section-view">
                <div class="modal-dialog modal-lg warning-modal">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="mb-3">
                                <h3 class="modal-title mb-3"><?php echo e(translate('Referral & Earning')); ?></h3>
                            </div>
                            <img src="<?php echo e(asset('/public/assets/admin/img/zone-instruction.png')); ?>" alt="admin/img" class="w-100">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- How it Works -->
    <?php echo $__env->make('admin-views.business-settings.landing-page-settings.partial.how-it-work', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/landing-page-settings/admin-fixed-data.blade.php ENDPATH**/ ?>