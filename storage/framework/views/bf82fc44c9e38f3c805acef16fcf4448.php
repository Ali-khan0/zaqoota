<?php $__env->startSection('title',translate('messages.Update campaign')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/campaign.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.update_campaign')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="card">
            <div class="card-body">
                <form class="custom-validation" data-ajax="true" id=campaign-form enctype="multipart/form-data">
                    <?php ($language=\App\Models\BusinessSetting::where('key','language')->first()); ?>
                    <?php ($language = $language->value ?? null); ?>
                    <?php ($defaultLang = str_replace('_', '-', app()->getLocale())); ?>
                    <?php if($language): ?>
                        <ul class="nav nav-tabs mb-4">
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
                        <div class="lang_form" id="default-form">
                            <div class="form-group error-wrapper">
                                <label class="input-label" for="default_title"><?php echo e(translate('messages.title')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                <input type="text" name="title[]" id="default_title" class="form-control" placeholder="<?php echo e(translate('messages.new_campaign')); ?>" value="<?php echo e($campaign?->getRawOriginal('title')); ?>" required>
                            </div>
                            <input type="hidden" name="lang[]" value="default">
                            <div class="form-group error-wrapper">
                                <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.short_description')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                <textarea type="text" name="description[]" class="form-control ckeditor" required><?php echo $campaign?->getRawOriginal('description'); ?></textarea>
                            </div>
                        </div>
                        <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                if(count($campaign['translations'])){
                                    $translate = [];
                                    foreach($campaign['translations'] as $t)
                                    {
                                        if($t->locale == $lang && $t->key=="title"){
                                            $translate[$lang]['title'] = $t->value;
                                        }
                                        if($t->locale == $lang && $t->key=="description"){
                                            $translate[$lang]['description'] = $t->value;
                                        }
                                    }
                                }
                            ?>
                            <div class="d-none lang_form" id="<?php echo e($lang); ?>-form">
                                <div class="form-group error-wrapper">
                                    <label class="input-label" for="<?php echo e($lang); ?>_title"><?php echo e(translate('messages.title')); ?> (<?php echo e(strtoupper($lang)); ?>)</label>
                                    <input type="text" name="title[]" id="<?php echo e($lang); ?>_title" class="form-control" placeholder="<?php echo e(translate('messages.new_campaign')); ?>" value="<?php echo e($translate[$lang]['title']??''); ?>">
                                </div>
                                <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                <div class="form-group error-wrapper">
                                    <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.short_description')); ?> (<?php echo e(strtoupper($lang)); ?>)</label>
                                    <textarea type="text" name="description[]" class="form-control ckeditor"><?php echo $translate[$lang]['description']??''; ?></textarea>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                    <div id="default-form">
                        <div class="form-group error-wrapper">
                            <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.title')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                            <input type="text" name="title[]" class="form-control" placeholder="<?php echo e(translate('messages.new_campaign')); ?>" value="<?php echo e($campaign['title']); ?>" maxlength="100">
                        </div>
                        <input type="hidden" name="lang[]" value="en">
                        <div class="form-group error-wrapper">
                            <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.short_description')); ?></label>
                            <textarea type="text" name="description[]" class="form-control ckeditor" maxlength="255"><?php echo $campaign['description']; ?></textarea>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div class="row g-3">
                        
                                <div class="col-sm-6">
                                    <div class="error-wrapper">
                                        <label class="input-label" for="title"><?php echo e(translate('messages.start_date')); ?></label>
                                        <input type="date" id="date_from" class="form-control" required name="start_date" value="<?php echo e($campaign->start_date->format('Y-m-d')); ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="error-wrapper">
                                        <label class="input-label" for="title"><?php echo e(translate('messages.end_date')); ?></label>
                                        <input type="date" id="date_to" class="form-control" required="" name="end_date" value="<?php echo e($campaign->end_date->format('Y-m-d')); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="error-wrapper">
                                        <label class="input-label text-capitalize" for="title"><?php echo e(translate('messages.daily_start_time')); ?></label>
                                        <input type="time" id="start_time" class="form-control" name="start_time" value="<?php echo e($campaign->start_time); ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="error-wrapper">
                                        <label class="input-label text-capitalize" for="title"><?php echo e(translate('messages.daily_end_time')); ?></label>
                                        <input type="time" id="end_time" class="form-control" name="end_time" value="<?php echo e($campaign->end_time); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="error-wrapper">
                                <div class="form-group mb-0 h-100 d-flex flex-column">
                                    <label>
                                        <?php echo e(translate('messages.campaign_image')); ?>

                                        <small class="text-danger">* ( <?php echo e(translate('messages.ratio')); ?> 900x300 )</small>
                                    </label>
                                    <div class="text-center py-3 my-auto">
                                        <img class="initial--4 onerror-image" id="viewer"
                                        src="<?php echo e($campaign->image_full_url); ?>"
                                             data-onerror-image="<?php echo e(asset('public/assets/admin/img/900x400/img1.jpg')); ?>" alt="campaign image"/>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" name="image" id="customFileEg1" class="custom-file-input"
                                               accept=".webp, .jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                        <label class="custom-file-label" for="customFileEg1"><?php echo e(translate('messages.choose_file')); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn--container justify-content-end mt-20">
                        <button type="reset" id="reset_btn" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.update')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/basic-campaign-edit.js"></script>
    <script>
        "use strict";
        $(document).ready(function(){
            $('#date_from').attr('max','<?php echo e($campaign->end_date->format("Y-m-d")); ?>');
            $('#date_to').attr('min','<?php echo e($campaign->start_date->format("Y-m-d")); ?>');
        });

        $('#campaign-form').on('submit', function (e) {
            e.preventDefault();

            let $form = $(this);
            if (!$form.valid()) {
                return false;
            }

            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '<?php echo e(route('admin.campaign.update-basic',[$campaign['id']])); ?>',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        toastr.success('Campaign updated successfully!', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        setTimeout(function () {
                            location.href = '<?php echo e(route('admin.campaign.list', 'basic')); ?>';
                        }, 2000);
                    }
                }
            });
        });

        $('#reset_btn').click(function(){
            $('#viewer').attr('src','<?php echo e(asset('storage/app/public/campaign')); ?>/<?php echo e($campaign->image); ?>');
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/campaign/basic/edit.blade.php ENDPATH**/ ?>