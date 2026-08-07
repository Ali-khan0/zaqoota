<?php $__env->startSection('title', translate('messages.Home_Page_Setup')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between flex-wrap gap-3 mb-3">
                <div>
                    <h1 class="page-header-title text-break">
                        <span class="page-header-icon">
                            <img src="<?php echo e(asset('public/assets/admin/img/store.png')); ?>" class="w--22" alt="">
                        </span>
                        <span><?php echo e(translate('messages.Home_Page_Setup')); ?> (<?php echo e(translate('Only_For_React_Web')); ?>)
                    </h1></span>
                    </h1>
                </div>
            </div>

            <!-- Nav Scroller -->
            <div class="js-nav-scroller hs-nav-scroller-horizontal">
                <span class="hs-nav-scroller-arrow-prev d-none">
                    <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                        <i class="tio-chevron-left"></i>
                    </a>
                </span>

                <span class="hs-nav-scroller-arrow-next d-none">
                    <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                        <i class="tio-chevron-right"></i>
                    </a>
                </span>

                <!-- Nav -->
                <ul class="nav nav-tabs border-0 nav--tabs nav--pills mb-2">
                    <li class="nav-item">
                        <a class="nav-link text-capitalize text-title active"
                            href="javascript:"><?php echo e(translate('messages.Download App')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-capitalize text-title"
                            href="<?php echo e(route('admin.rental.settings.vendors_registration')); ?>"><?php echo e(translate('messages.Vendors Registration')); ?></a>
                    </li>
                </ul>
                <!-- End Nav -->
            </div>
            <!-- End Nav Scroller -->
        </div>
        <!-- End Page Header -->


        
        <form action="<?php echo e(route('admin.rental.settings.down_app_update')); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="card mb-20">
                <div class="card-body">
                    <div class="row gy-3">
                        <div class="col-lg-6">
                            <?php if($language): ?>
                                <ul class="nav nav-tabs border-0 mb-4">
                                    <li class="nav-item">
                                        <a class="nav-link lang_link active" href="#"
                                            id="default-link"><?php echo e(translate('Default')); ?></a>
                                    </li>
                                    <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="nav-item">
                                            <a class="nav-link lang_link" href="#"
                                                id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            <?php endif; ?>
                            <?php if($language): ?>
                                <div class="lang_form" id="default-form">
                                    <div class="form-group mb-20">
                                        <label class="input-label font-semibold"
                                            for="default_name"><?php echo e(translate('messages.title')); ?>

                                            (<?php echo e(translate('messages.Default')); ?>)
                                        </label>
                                        <div class="character-count">
                                            <input type="text" name="title[]" id="default_name"
                                                class="form-control character-count-field h--45px"
                                                value="<?php echo e($title_data?->getRawOriginal('value')); ?>"
                                                placeholder="<?php echo e(translate('messages.type_title')); ?>" maxlength="30"
                                                data-max-character="30" required>
                                            <span class="d-flex text-count justify-content-end"></span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="lang[]" value="default">
                                    <div class="form-group mb-20">
                                        <label class="input-label font-semibold"
                                            for="exampleFormControlInput1"><?php echo e(translate('messages.subtitle')); ?>

                                            (<?php echo e(translate('messages.default')); ?>)</label>
                                        <div class="character-count">
                                            <textarea type="text" name="sub_title[]" placeholder="<?php echo e(translate('messages.type_subtitle')); ?>"
                                                class="form-control  character-count-field" maxlength="110" data-max-character="110"><?php echo e($sub_title_data?->getRawOriginal('value')); ?></textarea>
                                            <span class="d-flex text-count justify-content-end"></span>
                                        </div>

                                    </div>
                                </div>
                                <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    if(isset($title_data->translations)&&count($title_data->translations)){
                                        $title_data_translate = [];
                                        foreach($title_data->translations as $t)
                                        {
                                            if($t->locale == $lang && $t->key=='module_home_page_data_title'){
                                                $title_data_translate[$lang]['value'] = $t->value;
                                            }
                                        }

                                    }
                                if(isset($sub_title_data->translations) && count($sub_title_data->translations)){
                                        $sub_title_data_translate = [];
                                        foreach($sub_title_data->translations as $t)
                                        {
                                            if($t->locale == $lang && $t->key=='module_home_page_data_sub_title'){
                                                $sub_title_data_translate[$lang]['value'] = $t->value;
                                            }
                                        }

                                    }
                                    ?>


                                    <div class="d-none lang_form" id="<?php echo e($lang); ?>-form">
                                        <div class="form-group mb-20">
                                            <label class="input-label font-semibold"
                                                for="<?php echo e($lang); ?>_name"><?php echo e(translate('messages.title')); ?>

                                                (<?php echo e(strtoupper($lang)); ?>)
                                            </label>
                                            <div class="character-count">
                                                <input type="text" name="title[]" id="<?php echo e($lang); ?>_name"
                                                    class="form-control character-count-field h--45px" maxlength="30"
                                                    data-max-character="30" value="<?php echo e($title_data_translate[$lang]['value']?? ''); ?>"
                                                    placeholder="<?php echo e(translate('messages.type_title')); ?>">
                                                <span class="d-flex text-count justify-content-end"></span>
                                            </div>
                                        </div>
                                        <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                        <div class="form-group mb-20">
                                            <label class="input-label font-semibold"
                                                for="exampleFormControlInput1"><?php echo e(translate('messages.subtitle')); ?>

                                                (<?php echo e(strtoupper($lang)); ?>)</label>
                                            <div class="character-count">
                                                <textarea type="text" name="sub_title[]" placeholder="<?php echo e(translate('messages.type_subtitle')); ?>"
                                                    class="form-control character-count-field" maxlength="110" data-max-character="110"><?php echo e($sub_title_data_translate[$lang]['value']?? ''); ?></textarea>
                                                <span class="d-flex text-count justify-content-end"></span>
                                            </div>

                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-6">
                            <div class="d-flex flex-column justify-content-between h-100">
                                <div class="text-center">
                                    <label class="text--title fs-16 font-semibold mb-1">
                                        <?php echo e(translate('Image')); ?>

                                    </label>
                                    <div class="mb-20">
                                        <p class="fs-12">
                                            <?php echo e(translate('JPG, JPEG, PNG Less Than 1MB')); ?> <strong class="font-semibold">(<?php echo e(translate('Ratio 1:1')); ?>)</strong>
                                        </p>
                                    </div>
                                    <div class="upload-file image-general d-inline-block w-auto">
                                        <a href="javascript:void(0);" class="remove-btn opacity-0 z-index-99">
                                            <i class="tio-clear"></i>
                                        </a>
                                        <input type="file" name="image" class="upload-file__input single_file_input"
                                            accept=".webp, .jpg, .jpeg, .png"  value="<?php echo e($image?->value ?  \App\CentralLogics\Helpers::get_full_url('react_landing', $image?->value?? '', $image?->storage[0]?->value ?? 'public','upload_image_1' ) : ''); ?>">
                                        <label
                                            class="upload-file-wrapper w--180px">
                                            <div class="upload-file-textbox text-center">
                                                <img width="34" height="34" src="<?php echo e(asset('public/assets/admin/img/document-upload.svg')); ?>" alt="">
                                                <h6 class="mt-2 font-semibold text-center">
                                                    <span><?php echo e(translate('Click to upload')); ?></span>
                                                    <br>
                                                    <?php echo e(translate('or drag and drop')); ?>

                                                </h6>
                                            </div>
                                            <img class="upload-file-img d-none" data-src="<?php echo e($image?->value ?  \App\CentralLogics\Helpers::get_full_url('react_landing', $image?->value?? '', $image?->storage[0]?->value ?? 'public','upload_image_1' ) : ''); ?>" height="180" width="180" loading="lazy"   src="<?php echo e($image?->value ?  \App\CentralLogics\Helpers::get_full_url('react_landing', $image?->value?? '', $image?->storage[0]?->value ?? 'public','upload_image_1' ) : ''); ?>" alt="">
                                        </label>
                                    </div>

                                </div>
                                <div class="btn--container justify-content-end mt-5">
                                    <button type="reset" id="reset_btn" data-src="<?php echo e($image?->value ?  \App\CentralLogics\Helpers::get_full_url('react_landing', $image?->value?? '', $image?->storage[0]?->value ?? 'public','upload_image_1' ) : ''); ?>"
                                        class="btn btn--reset min-w-120px"><?php echo e(translate('messages.reset')); ?></button>
                                    <button type="submit"
                                        class="btn btn--primary min-w-120px"><?php echo e(translate('messages.Submit')); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="mt-4">
            <label class="badge badge-soft-secondary fs-12 p-10px">
                <span class="text--danger"># <?php echo e(translate('Note:')); ?> </span>
                <span class="font-regular opacity-lg text-title"><?php echo e(translate('This Section App Download buttons are appear based on
                    footer Apps Download button')); ?></span>
            </label>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>

<script src="<?php echo e(asset('Modules/Rental/public/assets/js/admin/view-pages/home-page-download-app.js')); ?>"></script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/home-page-setup/download-app.blade.php ENDPATH**/ ?>