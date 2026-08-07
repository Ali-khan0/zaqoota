<?php $__env->startSection('title',translate('Add new campaign')); ?>

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
                    <?php echo e(translate('messages.Add new campaign')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="card">
            <div class="card-body">
                <form enctype="multipart/form-data" class="custom-validation" data-ajax="true" id="campaign-form">
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
                                <input type="text" name="title[]" id="default_title" class="form-control" placeholder="<?php echo e(translate('messages.new_campaign')); ?>"  required>
                            </div>
                            <input type="hidden" name="lang[]" value="default">
                            <div class="form-group error-wrapper">
                                <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.short_description')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                <textarea type="text" name="description[]" class="form-control ckeditor" required></textarea>
                            </div>
                        </div>
                        <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="d-none lang_form" id="<?php echo e($lang); ?>-form">
                                <div class="form-group error-wrapper">
                                    <label class="input-label" for="<?php echo e($lang); ?>_title"><?php echo e(translate('messages.title')); ?> (<?php echo e(strtoupper($lang)); ?>)</label>
                                    <input type="text" name="title[]" id="<?php echo e($lang); ?>_title" class="form-control" placeholder="<?php echo e(translate('messages.new_campaign')); ?>"  >
                                </div>
                                <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                <div class="form-group error-wrapper">
                                    <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.short_description')); ?> (<?php echo e(strtoupper($lang)); ?>)</label>
                                    <textarea type="text" name="description[]" class="form-control ckeditor"></textarea>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                    <div id="default-form">
                        <div class="form-group error-wrapper">
                            <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.title')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                            <input type="text" name="title[]" class="form-control" placeholder="<?php echo e(translate('messages.new_food')); ?>">
                        </div>
                        <input type="hidden" name="lang[]" value="en">
                        <div class="form-group error-wrapper">
                            <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.short_description')); ?></label>
                            <textarea type="text" name="description[]" class="form-control ckeditor"></textarea>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div class="row g-3">
                                
                                <div class="col-sm-6">
                                    <div class="error-wrapper">
                                        <label class="input-label" for="title"><?php echo e(translate('messages.start_date')); ?></label>
                                        <input type="date" id="date_from" class="form-control" required="" name="start_date">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="error-wrapper">
                                        <label class="input-label" for="title"><?php echo e(translate('messages.end_date')); ?></label>
                                        <input type="date" id="date_to" class="form-control" required="" name="end_date">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="error-wrapper">
                                        <label class="input-label text-capitalize" for="title"><?php echo e(translate('messages.daily_start_time')); ?></label>
                                        <input type="time" id="start_time" class="form-control" name="start_time">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="error-wrapper">
                                        <label class="input-label text-capitalize" for="title"><?php echo e(translate('messages.daily_end_time')); ?></label>
                                        <input type="time" id="end_time" class="form-control" name="end_time">
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
                                        <img class="initial--4" id="viewer"
                                             src="<?php echo e(asset('public/assets/admin/img/900x400/img1.jpg')); ?>" alt="campaign image"/>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" name="image" id="customFileEg1" class="custom-file-input"
                                               accept=".webp, .jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required>
                                        <label class="custom-file-label" for="customFileEg1"><?php echo e(translate('messages.choose_file')); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn--container justify-content-end mt-20">
                        <button type="reset" id="reset_btn" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.submit')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/basic-campaign-index.js"></script>
    <script>
    "use strict";
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
                url: '<?php echo e(route('admin.campaign.store-basic')); ?>',
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
                        toastr.success('Campaign created successfully!',{
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
            $('#module_id').val(null).trigger('change');
            $('#viewer').attr('src','<?php echo e(asset('public/assets/admin/img/900x400/img1.jpg')); ?>');
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/campaign/basic/index.blade.php ENDPATH**/ ?>