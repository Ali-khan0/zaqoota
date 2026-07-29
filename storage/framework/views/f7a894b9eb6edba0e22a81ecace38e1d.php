<?php $__env->startSection('title', translate('messages.banner')); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <div class="page-header">
        <h1 class="page-header-title">
            <span class="page-header-icon">
                <img src="<?php echo e(asset('public/assets/admin/img/3rd-party.png')); ?>" class="w--26" alt="">
            </span>
            <span>
                <?php echo e(translate('messages.Other_Promotional_Content_Setup')); ?>

            </span>
        </h1>
    </div>
    <div class="mb-20 mt-2">
        <div class="js-nav-scroller hs-nav-scroller-horizontal">
            <?php echo $__env->make('admin-views.other-banners.partial.parcel-links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>
    <?php ($content1_title = \App\Models\ModuleWiseBanner::withoutGlobalScope('translate')->where('module_id', Config::get('module.current_module_id'))->where('type', 'video_banner_content')->where('key', 'content1_title')->first()); ?>
    <?php ($content1_subtitle = \App\Models\ModuleWiseBanner::withoutGlobalScope('translate')->where('module_id', Config::get('module.current_module_id'))->where('type', 'video_banner_content')->where('key', 'content1_subtitle')->first()); ?>
    <?php ($content2_title = \App\Models\ModuleWiseBanner::withoutGlobalScope('translate')->where('module_id', Config::get('module.current_module_id'))->where('type', 'video_banner_content')->where('key', 'content2_title')->first()); ?>
    <?php ($content2_subtitle = \App\Models\ModuleWiseBanner::withoutGlobalScope('translate')->where('module_id', Config::get('module.current_module_id'))->where('type', 'video_banner_content')->where('key', 'content2_subtitle')->first()); ?>
    <?php ($content3_title = \App\Models\ModuleWiseBanner::withoutGlobalScope('translate')->where('module_id', Config::get('module.current_module_id'))->where('type', 'video_banner_content')->where('key', 'content3_title')->first()); ?>
    <?php ($content3_subtitle = \App\Models\ModuleWiseBanner::withoutGlobalScope('translate')->where('module_id', Config::get('module.current_module_id'))->where('type', 'video_banner_content')->where('key', 'content3_subtitle')->first()); ?>
    <?php ($section_title = \App\Models\ModuleWiseBanner::withoutGlobalScope('translate')->where('module_id', Config::get('module.current_module_id'))->where('type', 'video_banner_content')->where('key', 'section_title')->first()); ?>
    <?php ($banner_type = \App\Models\ModuleWiseBanner::withoutGlobalScope('translate')->where('module_id', Config::get('module.current_module_id'))->where('type', 'video_banner_content')->where('key', 'banner_type')->first()); ?>
    <?php ($banner_video = \App\Models\ModuleWiseBanner::withoutGlobalScope('translate')->where('module_id', Config::get('module.current_module_id'))->where('type', 'video_banner_content')->where('key', 'banner_video')->first()); ?>
    <?php ($banner_video_content = \App\Models\ModuleWiseBanner::withoutGlobalScope('translate')->where('module_id', Config::get('module.current_module_id'))->where('type', 'video_banner_content')->where('key', 'banner_video_content')->first()); ?>
    <?php ($banner_image = \App\Models\ModuleWiseBanner::withoutGlobalScope('translate')->where('module_id', Config::get('module.current_module_id'))->where('type', 'video_banner_content')->where('key', 'banner_image')->first()); ?>
    <?php ($awsUrl = config('filesystems.disks.s3.url')); ?>
    <?php ($awsBucket = config('filesystems.disks.s3.bucket')); ?>
    <?php ($awsBaseURL = rtrim($awsUrl, '/') . '/' . ltrim($awsBucket . '/')); ?>
    <?php ($language = \App\Models\BusinessSetting::where('key', 'language')->first()); ?>
    <?php ($language = $language->value ?? null); ?>
    <?php if($language): ?>
        <ul class="nav nav-tabs mb-4 border-0">
            <li class="nav-item">
                <a class="nav-link lang_link active" href="#" id="default-link"><?php echo e(translate('messages.default')); ?></a>
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
            <form action="<?php echo e(route('admin.promotional-banner.video-image-store')); ?>" method="POST"
                enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="card mb-3">
                    <h5 class="card-title p-3">
                        <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span>
                        <span><?php echo e(translate('Video_/_Image')); ?></span>
                    </h5>
                    <div class="card-body">
                        <div class="row g-4">
                            <?php if($language): ?>
                                <div class="col-md-6 lang_form default-form">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label for="section_title" class="form-label"><?php echo e(translate('Section_Title')); ?>

                                                (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary"
                                                    data-toggle="tooltip" data-placement="right"
                                                    data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                                    <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                        alt="">
                                                </span></label>
                                            <input type="text" id="section_title" maxlength="20" name="section_title[]"
                                                value="<?php echo e($section_title?->getRawOriginal('value')); ?>" class="form-control"
                                                placeholder="<?php echo e(translate('Ex:Enter_section_title')); ?>">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                                <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php
                                    if (isset($section_title->translations) && count($section_title->translations)) {
                                        $section_title_translate = [];
                                        foreach ($section_title->translations as $t) {
                                            if ($t->locale == $lang && $t->key == 'section_title') {
                                                $section_title_translate[$lang]['value'] = $t->value;
                                            }
                                        }
                                    }
                                                                ?>
                                                        <div class="col-md-6 d-none lang_form" id="<?php echo e($lang); ?>-form1">
                                                            <div class="row g-3">
                                                                <div class="col-12">
                                                                    <label for="section_title<?php echo e($lang); ?>"
                                                                        class="form-label"><?php echo e(translate('Section_Title')); ?>

                                                                        (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary"
                                                                            data-toggle="tooltip" data-placement="right"
                                                                            data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                                                            <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                                                alt="">
                                                                        </span></label>
                                                                    <input type="text" id="section_title<?php echo e($lang); ?>" maxlength="20"
                                                                        name="section_title[]"
                                                                        value="<?php echo e($section_title_translate[$lang]['value'] ?? ''); ?>"
                                                                        class="form-control"
                                                                        placeholder="<?php echo e(translate('Ex:Enter_section_title')); ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            <div class="col-sm-12 col-lg-6">
                                <div class="form-group mb-0">
                                    <label class="input-label text-capitalize d-flex alig-items-center"><span
                                            class="line--limit-1"><?php echo e(translate('Upload_Content')); ?>

                                        </span>
                                    </label>
                                    <div class="resturant-type-group border">
                                        <label class="form-check form--check mr-2 mr-md-4">
                                            <input class="form-check-input" type="radio" value="video"
                                                name="banner_type" <?php echo e($banner_type ? ($banner_type->value == 'video' ? 'checked' : '') : ''); ?>>
                                            <span class="form-check-label">
                                                <?php echo e(translate('YouTube_Video_URL')); ?> <span class="input-label-secondary"
                                                    data-toggle="tooltip" data-placement="right"
                                                    data-original-title="<?php echo e(translate('Go_to_YouTube,_click_share_option_then_get_a_popup_of_share._Select_embed_&_get_a_embed_video_then_copy_the_generated_code_for_the_embedded_link')); ?>"><img
                                                        src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                        alt="public/img"></span>
                                            </span>
                                        </label>
                                        <label class="form-check form--check mr-2 mr-md-4">
                                            <input class="form-check-input" type="radio" value="video_content"
                                                name="banner_type" <?php echo e($banner_type ? ($banner_type->value == 'video_content' ? 'checked' : '') : ''); ?>>
                                            <span class="form-check-label">
                                                <?php echo e(translate('video')); ?>

                                            </span>
                                        </label>
                                        <label class="form-check form--check mr-2 mr-md-4">
                                            <input class="form-check-input" type="radio" value="image"
                                                name="banner_type" <?php echo e($banner_type ? ($banner_type->value == 'image' ? 'checked' : '') : ''); ?>>
                                            <span class="form-check-label">
                                                <?php echo e(translate('image')); ?>

                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 <?php echo e($banner_type ? ($banner_type->value == 'image' ? '' : 'd-none') : ''); ?>"
                                id="image">
                                <label class="__upload-img aspect-615-350 d-block position-relative">
                                    <div class="img">
                                        <img class="onerror-image"
                                            src="<?php echo e(\App\CentralLogics\Helpers::get_full_url('promotional_banner', $banner_image?->value ?? '', $banner_image?->storage[0]?->value ?? 'public', 'upload_placeholder')); ?>"
                                            data-onerror-image="<?php echo e(asset('/public/assets/admin/img/upload-placeholder.png')); ?>"
                                            alt="">
                                    </div>

                                    <div class="">
                                        <input type="file" name="banner_image" hidden>
                                    </div>
                                    <?php if(isset($banner_image?->value)): ?>
                                        <span id="banner_image" class="remove_image_button dynamic-checkbox"
                                            data-id="banner_image" data-type="status"
                                            data-image-on="<?php echo e(asset('/public/assets/admin/img/modal')); ?>/mail-success.png"
                                            data-image-off="<?php echo e(asset('/public/assets/admin/img/modal')); ?>/mail-warning.png"
                                            data-title-on="<?php echo e(translate('Important!')); ?>"
                                            data-title-off="<?php echo e(translate('Warning!')); ?>"
                                            data-text-on="<p><?php echo e(translate('Are_you_sure_you_want_to_remove_this_image')); ?></p>"
                                            data-text-off="<p><?php echo e(translate('Are_you_sure_you_want_to_remove_this_image.')); ?></p>">
                                            <i class="tio-clear"></i></span>
                                    <?php endif; ?>
                                </label>
                                <div class="text-center mt-5">
                                    <h3 class="form-label d-block mt-2">
                                        <?php echo e(translate('Image_Size_Min_615_x_350_px')); ?>

                                    </h3>
                                    <p><?php echo e(translate('image_format_:_jpg_,_png_,_jpeg_|_maximum_size:_2_MB')); ?></p>

                                </div>
                            </div>

                            <div class="col-12 <?php echo e($banner_type ? ($banner_type->value == 'video_content' ? '' : 'd-none') : ''); ?>"
                                id="video_content">

                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="mb-3 text-capitalize d-flex align-items-center">
                                            <?php echo e(translate('upload_video')); ?></h4>
                                        <div class="uploadDnD">
                                            <div class="form-group inputDnD">
                                                <input type="file" name="banner_video_content"
                                                    class="form-control-file text--primary font-weight-bold read-url"
                                                    id="inputFile" accept=".mp4 ,.webm"
                                                    data-title="<?php echo e(translate('Browse_file"')); ?>">
                                            </div>
                                        </div>

                                        <div class="mt-5 card px-3 py-2 d--none" id="progress-bar">
                                            <div class="d-flex flex-wrap align-items-center gap-3">
                                                <div class="">
                                                    <img width="24" src="<?php echo e(asset('/public/assets/admin/img/zip.png')); ?>"
                                                        alt="">
                                                </div>
                                                <div class="flex-grow-1 text-start">
                                                    <div
                                                        class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                                                        <span id="name_of_file" class="text-truncate fz-12"></span>
                                                        <span class="text-muted fz-12" id="progress-label">0%</span>
                                                    </div>
                                                    <progress id="uploadProgress" class="w-100" value="0"
                                                        max="100"></progress>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-center mt-5">
                                            <h3 class="form-label d-block mt-2">
                                                <?php echo e(translate('Video_Size_Max_5MB')); ?>

                                            </h3>
                                            <p><?php echo e(translate('Video_format_:_MP4')); ?></p>

                                        </div>

                                    </div>
                                    
                                    <?php if($banner_video_content?->value): ?>

                                    <div class="col-6">
                                        <h4 class="mb-3  ml-4 text-capitalize d-flex align-items-center">
                                            <?php echo e(translate('Video')); ?></h4>
                                        <?php ($extention = explode('.', $banner_video_content?->value)); ?>
                                        <video width="320" height="140" id="video-preview" controls>
                                            <source
                                                src="<?php echo e((count($banner_video_content?->storage) > 0 && $banner_video_content?->storage[0]?->value == 's3') ? $awsBaseURL . 'promotional_banner/video/' . $banner_video_content?->value : asset('storage/app/public/promotional_banner/video') . '/' . $banner_video_content?->value); ?>"
                                                type="video/<?php echo e(data_get($extention, 1, 'mp4')); ?>">
                                        </video>
                                    </div>
                                    <?php endif; ?>

                                </div>

                            </div>
                            <div class="col-12 <?php echo e($banner_type ? ($banner_type->value == 'video' ? '' : 'd-none') : 'd-none'); ?>"
                                id="video">
                                <label for="banner_video"
                                    class="form-label"><?php echo e(translate('YouTube_Video_URL')); ?></label>
                                <input type="url" id="banner_video" name="banner_video"
                                    value="<?php echo e($banner_video?->value); ?>" class="form-control"
                                    placeholder="<?php echo e(translate('messages.Enter_YouTube_Video_URL')); ?>">
                            </div>
                        </div>
                        <div class="btn--container justify-content-end mt-20">
                            <button type="reset" class="btn btn--reset"><?php echo e(translate('Reset')); ?></button>
                            <button type="submit" class="btn btn--primary mb-2"><?php echo e(translate('Save')); ?></button>
                        </div>
                    </div>
                </div>
            </form>
            <form action="<?php echo e(route('admin.promotional-banner.video-content-store')); ?>" method="POST"
                enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <h5 class="card-title mb-3">
                    <span class="card-header-icon mr-2"><i class="tio-calendar"></i></span>
                    <span><?php echo e(translate('Video_/_Image_Content')); ?></span>
                </h5>
                <div class="card mb-3">
                    <div class="card-body">
                        <?php if($language): ?>
                            <div class="lang_form default-form">
                                <div class="form-group">
                                    <label class="form-label"><?php echo e(translate('content-1')); ?></label>
                                    <div class="row g-3 __bg-F8F9FC-card">
                                        <div class="col-sm-6">
                                            <label for="content1_title" class="form-label"><?php echo e(translate('Title')); ?>

                                                (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary"
                                                    data-toggle="tooltip" data-placement="right"
                                                    data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                                    <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                        alt="">
                                                </span></label>
                                            <input type="text" id="content1_title" maxlength="80" name="content1_title[]"
                                                value="<?php echo e($content1_title?->getRawOriginal('value')); ?>" class="form-control"
                                                placeholder="<?php echo e(translate('Ex_:_Enter_Title')); ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="content1_subtitle"
                                                class="form-label"><?php echo e(translate('messages.Sub Title')); ?>

                                                (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary"
                                                    data-toggle="tooltip" data-placement="right"
                                                    data-original-title="<?php echo e(translate('Write_the_title_within_240_characters')); ?>">
                                                    <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                        alt="">
                                                </span></label>
                                            <input type="text" id="content1_subtitle" maxlength="240"
                                                name="content1_subtitle[]"
                                                value="<?php echo e($content1_subtitle?->getRawOriginal('value')); ?>"
                                                class="form-control" placeholder="<?php echo e(translate('Ex_:_Enter_Subtitle')); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label"><?php echo e(translate('content-2')); ?></label>
                                    <div class="row g-3 __bg-F8F9FC-card">
                                        <div class="col-sm-6">
                                            <label for="content2_title" class="form-label"><?php echo e(translate('Title')); ?>

                                                (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary"
                                                    data-toggle="tooltip" data-placement="right"
                                                    data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                                    <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                        alt="">
                                                </span></label>
                                            <input type="text" id="content2_title" maxlength="80" name="content2_title[]"
                                                value="<?php echo e($content2_title?->getRawOriginal('value')); ?>" class="form-control"
                                                placeholder="<?php echo e(translate('Ex_:_Enter_Title')); ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="content2_subtitle"
                                                class="form-label"><?php echo e(translate('messages.Sub Title')); ?>

                                                (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary"
                                                    data-toggle="tooltip" data-placement="right"
                                                    data-original-title="<?php echo e(translate('Write_the_title_within_240_characters')); ?>">
                                                    <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                        alt="">
                                                </span></label>
                                            <input id="content2_subtitle" type="text" maxlength="240"
                                                name="content2_subtitle[]"
                                                value="<?php echo e($content2_subtitle?->getRawOriginal('value')); ?>"
                                                class="form-control" placeholder="<?php echo e(translate('Ex_:_Enter_Subtitle')); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label"><?php echo e(translate('content-3')); ?></label>
                                    <div class="row g-3 __bg-F8F9FC-card">
                                        <div class="col-sm-6">
                                            <label for="content3_title" class="form-label"><?php echo e(translate('Title')); ?>

                                                (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary"
                                                    data-toggle="tooltip" data-placement="right"
                                                    data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                                    <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                        alt="">
                                                </span></label>
                                            <input id="content3_title" type="text" maxlength="80" name="content3_title[]"
                                                value="<?php echo e($content3_title?->getRawOriginal('value')); ?>" class="form-control"
                                                placeholder="<?php echo e(translate('Ex_:_Enter_Title')); ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="content3_subtitle"
                                                class="form-label"><?php echo e(translate('messages.Sub Title')); ?>

                                                (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary"
                                                    data-toggle="tooltip" data-placement="right"
                                                    data-original-title="<?php echo e(translate('Write_the_title_within_240_characters')); ?>">
                                                    <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                        alt="">
                                                </span></label>
                                            <input type="text" id="content3_subtitle" maxlength="240"
                                                name="content3_subtitle[]"
                                                value="<?php echo e($content3_subtitle?->getRawOriginal('value')); ?>"
                                                class="form-control" placeholder="<?php echo e(translate('Ex_:_Enter_Subtitle')); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="lang[]" value="default">
                            <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                if (isset($content1_title->translations) && count($content1_title->translations)) {
                                    $content1_title_translate = [];
                                    foreach ($content1_title->translations as $t) {
                                        if ($t->locale == $lang && $t->key == 'content1_title') {
                                            $content1_title_translate[$lang]['value'] = $t->value;
                                        }
                                    }
                                }
                                if (isset($content2_title->translations) && count($content2_title->translations)) {
                                    $content2_title_translate = [];
                                    foreach ($content2_title->translations as $t) {
                                        if ($t->locale == $lang && $t->key == 'content2_title') {
                                            $content2_title_translate[$lang]['value'] = $t->value;
                                        }
                                    }
                                }
                                if (isset($content3_title->translations) && count($content3_title->translations)) {
                                    $content3_title_translate = [];
                                    foreach ($content3_title->translations as $t) {
                                        if ($t->locale == $lang && $t->key == 'content3_title') {
                                            $content3_title_translate[$lang]['value'] = $t->value;
                                        }
                                    }
                                }
                                if (isset($content1_subtitle->translations) && count($content1_subtitle->translations)) {
                                    $content1_subtitle_translate = [];
                                    foreach ($content1_subtitle->translations as $t) {
                                        if ($t->locale == $lang && $t->key == 'content1_subtitle') {
                                            $content1_subtitle_translate[$lang]['value'] = $t->value;
                                        }
                                    }
                                }
                                if (isset($content2_subtitle->translations) && count($content2_subtitle->translations)) {
                                    $content2_subtitle_translate = [];
                                    foreach ($content2_subtitle->translations as $t) {
                                        if ($t->locale == $lang && $t->key == 'content2_subtitle') {
                                            $content2_subtitle_translate[$lang]['value'] = $t->value;
                                        }
                                    }
                                }
                                if (isset($content3_subtitle->translations) && count($content3_subtitle->translations)) {
                                    $content3_subtitle_translate = [];
                                    foreach ($content3_subtitle->translations as $t) {
                                        if ($t->locale == $lang && $t->key == 'content3_subtitle') {
                                            $content3_subtitle_translate[$lang]['value'] = $t->value;
                                        }
                                    }
                                }
                                                            ?>
                                                <div class="d-none lang_form" id="<?php echo e($lang); ?>-form">
                                                    <div class="form-group">
                                                        <label class="form-label"><?php echo e(translate('content-1')); ?></label>
                                                        <div class="row g-3 __bg-F8F9FC-card">
                                                            <div class="col-sm-6">
                                                                <label for="content1_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Title')); ?>

                                                                    (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary"
                                                                        data-toggle="tooltip" data-placement="right"
                                                                        data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                                                    </span></label>
                                                                <input type="text" id="content1_title<?php echo e($lang); ?>" maxlength="80"
                                                                    name="content1_title[]"
                                                                    value="<?php echo e($content1_title_translate[$lang]['value'] ?? ''); ?>"
                                                                    class="form-control" placeholder="<?php echo e(translate('Ex_:_Enter_Title')); ?>">
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="content1_subtitle<?php echo e($lang); ?>"
                                                                    class="form-label"><?php echo e(translate('messages.Sub Title')); ?>

                                                                    (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary"
                                                                        data-toggle="tooltip" data-placement="right"
                                                                        data-original-title="<?php echo e(translate('Write_the_title_within_240_characters')); ?>">
                                                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                                                    </span></label>
                                                                <input type="text" id="content1_subtitle<?php echo e($lang); ?>" maxlength="240"
                                                                    name="content1_subtitle[]"
                                                                    value="<?php echo e($content1_subtitle_translate[$lang]['value'] ?? ''); ?>"
                                                                    class="form-control" placeholder="<?php echo e(translate('Ex_:_Enter_Subtitle')); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label"><?php echo e(translate('content-2')); ?></label>
                                                        <div class="row g-3 __bg-F8F9FC-card">
                                                            <div class="col-sm-6">
                                                                <label for="content2_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Title')); ?>

                                                                    (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary"
                                                                        data-toggle="tooltip" data-placement="right"
                                                                        data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                                                    </span></label>
                                                                <input type="text" id="content2_title<?php echo e($lang); ?>" maxlength="80"
                                                                    name="content2_title[]"
                                                                    value="<?php echo e($content2_title_translate[$lang]['value'] ?? ''); ?>"
                                                                    class="form-control" placeholder="<?php echo e(translate('Ex_:_Enter_Title')); ?>">
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="content2_subtitle<?php echo e($lang); ?>"
                                                                    class="form-label"><?php echo e(translate('messages.Sub Title')); ?>

                                                                    (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary"
                                                                        data-toggle="tooltip" data-placement="right"
                                                                        data-original-title="<?php echo e(translate('Write_the_title_within_240_characters')); ?>">
                                                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                                                    </span></label>
                                                                <input type="text" id="content2_subtitle<?php echo e($lang); ?>" maxlength="240"
                                                                    name="content2_subtitle[]"
                                                                    value="<?php echo e($content2_subtitle_translate[$lang]['value'] ?? ''); ?>"
                                                                    class="form-control" placeholder="<?php echo e(translate('Ex_:_Enter_Subtitle')); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label"><?php echo e(translate('content-3')); ?></label>
                                                        <div class="row g-3 __bg-F8F9FC-card">
                                                            <div class="col-sm-6">
                                                                <label for="content3_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Title')); ?>

                                                                    (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary"
                                                                        data-toggle="tooltip" data-placement="right"
                                                                        data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                                                    </span></label>
                                                                <input type="text" id="content3_title<?php echo e($lang); ?>" maxlength="80"
                                                                    name="content3_title[]"
                                                                    value="<?php echo e($content3_title_translate[$lang]['value'] ?? ''); ?>"
                                                                    class="form-control" placeholder="<?php echo e(translate('Ex_:_Enter_Title')); ?>">
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="content3_subtitle<?php echo e($lang); ?>"
                                                                    class="form-label"><?php echo e(translate('messages.Sub Title')); ?>

                                                                    (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary"
                                                                        data-toggle="tooltip" data-placement="right"
                                                                        data-original-title="<?php echo e(translate('Write_the_title_within_240_characters')); ?>">
                                                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                                                    </span></label>
                                                                <input type="text" maxlength="240" id="content3_subtitle<?php echo e($lang); ?>"
                                                                    name="content3_subtitle[]"
                                                                    value="<?php echo e($content3_subtitle_translate[$lang]['value'] ?? ''); ?>"
                                                                    class="form-control" placeholder="<?php echo e(translate('Ex_:_Enter_Subtitle')); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        <div class="btn--container justify-content-end mt-20">
                            <button type="reset" class="btn btn--reset"><?php echo e(translate('Reset')); ?></button>
                            <button type="submit" class="btn btn--primary mb-2"><?php echo e(translate('Save')); ?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<form id="banner_image_form" action="<?php echo e(route('admin.remove_image')); ?>" method="post">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="id" value="<?php echo e($banner_image?->id); ?>">
    <input type="hidden" name="model_name" value="ModuleWiseBanner">
    <input type="hidden" name="image_path" value="promotional_banner">
    <input type="hidden" name="field_name" value="value">
</form>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin/js/view-pages/other-banners.js')); ?>"></script>
    <script>
        "use strict";
        const input = document.getElementById('inputFile');
        const video = document.getElementById('video-preview');
        const videoSource = document.createElement('source');

        input.addEventListener('change', function () {
            const files = this.files || [];

            if (!files.length) return;

            const reader = new FileReader()
            video.innerHTML = ""
            input.setAttribute('data-title', files[0].name);
            reader.onload = function (e) {
                videoSource.setAttribute('src', e.target.result);
                video.appendChild(videoSource);
                video.load();
                video.play();
            };

            reader.onprogress = function (e) {
                console.log('progress: ', Math.round((e.loaded * 100) / e.total));
            };

            reader.readAsDataURL(files[0]);
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/other-banners/parcel-video.blade.php ENDPATH**/ ?>