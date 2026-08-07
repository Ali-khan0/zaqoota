<?php $__env->startSection('title',translate('Update_Business_Module')); ?>

<?php $__env->startPush('css_or_js'); ?>
<link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/radio-image.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/module.png')); ?>" alt="">
                </span>
                <span>
                    <?php echo e(translate('Edit_Business_Module')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="card">
            <div class="card-body pb-0">
                <form action="<?php echo e(route('admin.business-settings.module.update',[$module['id']])); ?>" method="post" enctype="multipart/form-data">
                    <?php echo method_field('PUT'); ?>
                    <?php echo csrf_field(); ?>
                    <?php if($language): ?>
                        <ul class="nav nav-tabs mb-4 border-0">
                            <li class="nav-item">
                                <a class="nav-link lang_link active"
                                href="#"
                                id="default-link"><?php echo e(translate('messages.default')); ?></a>
                            </li>
                            <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="nav-item">
                                    <a class="nav-link lang_link"
                                        href="#"
                                        id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <div class="lang_form" id="default-form">
                            <div class="form-group" >
                                <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.Business_Module_name')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                <input type="text" name="module_name[]" class="form-control" maxlength="191" value="<?php echo e($module?->getRawOriginal('module_name')); ?>">
                            </div>
                            <div class="form-group">
                                <label class="input-label d-flex" for="module_type"><?php echo e(translate('messages.description')); ?> (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary text-danger d-flex"
                                    data-toggle="tooltip" data-placement="right"
                                    data-original-title="<?php echo e(translate('messages.Write_a_short_description_of_your_new_business_module_within_100_words_(550_characters)')); ?>"><img
                                        src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>"
                                        alt="<?php echo e(translate('messages.veg_non_veg')); ?>"></span></label>
                                <textarea  data-value="<?php echo $module->description ?? ''; ?>" id="description"  class="ckeditor form-control" name="description[]"><?php echo $module?->getRawOriginal('description') ?? ''; ?></textarea>
                            </div>
                        </div>

                        <input type="hidden" name="lang[]" value="default">
                        <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                if(count($module['translations'])){
                                    $translate = [];
                                    foreach($module['translations'] as $t)
                                    {
                                        if($t->locale == $lang && $t->key=="module_name"){
                                            $translate[$lang]['module_name'] = $t->value;
                                        }

                                        if($t->locale == $lang && $t->key=="description"){
                                            $translate[$lang]['description'] = $t->value;
                                        }
                                    }
                                }
                            ?>
                            <div class="d-none lang_form" id="<?php echo e($lang); ?>-form">
                                <div class="form-group" >
                                    <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.Business_Module_name')); ?> (<?php echo e(strtoupper($lang)); ?>)</label>
                                    <input type="text" name="module_name[]" class="form-control" maxlength="191" value="<?php echo e($translate[$lang]['module_name']??''); ?>">
                                </div>
                                <div class="form-group">
                                    <label class="input-label d-flex" for="module_type"><?php echo e(translate('messages.description')); ?> (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary text-danger d-flex"
                                        data-toggle="tooltip" data-placement="right"
                                        data-original-title="<?php echo e(translate('messages.Write_a_short_description_of_your_new_business_module_within_100_words_(550_characters)')); ?>"><img
                                            src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>"
                                            alt="<?php echo e(translate('messages.veg_non_veg')); ?>"></span></label>
                                    <textarea  data-value="<?php echo $translate[$lang]['description']??''; ?>" id="description<?php echo e($lang); ?>" class="ckeditor form-control" name="description[]"><?php echo $translate[$lang]['description']??''; ?></textarea>
                                </div>
                            </div>

                            <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <div class="form-group">
                            <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.Business_Module_name')); ?></label>
                            <input type="text" name="module_name" class="form-control" placeholder="<?php echo e(translate('messages.new_category')); ?>" value="<?php echo e(old('name')); ?>" maxlength="191">
                        </div>
                        <div class="form-group">
                            <label class="input-label" for="module_type"><?php echo e(translate('messages.description')); ?></label>
                            <textarea  data-value="<?php echo $module->description; ?>" id="description" class="ckeditor form-control" name="description"><?php echo $module->description; ?></textarea>
                        </div>
                        <input type="hidden" name="lang[]" value="default">
                    <?php endif; ?>
                </div>
            </div>
                <br>
                <h5 class="mb-3"><?php echo e(translate('module_setup')); ?></h5>

                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <h6 class="mb-3"><?php echo e(translate('business_module_type')); ?> <span class="badge badge-danger"><?php echo e(translate('not_editable')); ?></span></h6>
                                    <div class="card">
                                        <div class="card-body p-0">
                                            <div class="module-radio-group">
                                            <?php $__currentLoopData = config('module.module_type'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($key != 'rental'  ): ?>
                                            <label class="form-check form--check">
                                                <input class="form-check-input" disabled type="radio" name="module_type" value="<?php echo e($key); ?>" <?php echo e($key==$module->module_type?'checked':''); ?>>
                                                <span class="form-check-label">
                                                    <?php echo e(translate($key)); ?>

                                                </span>
                                            </label>
                                            <?php elseif($key == 'rental' && addon_published_status('Rental')  ): ?>
                                            <label class="form-check form--check">
                                                <input class="form-check-input" disabled type="radio" name="module_type" value="<?php echo e($key); ?>" <?php echo e($key==$module->module_type?'checked':''); ?>>
                                                <span class="form-check-label">
                                                    <?php echo e(translate($key)); ?>

                                                </span>
                                            </label>
                                            <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mt-1" id="module_des_card">
                                        <div class="card-body" id="module_description"><?php echo e(config('module.'.$module->module_type)['description']); ?></div>
                                    </div>
                                </div>
                            </div>
                        <div class="col-lg-6">
                            <h6 class="mb-3"><?php echo e(translate('Chose related images')); ?></h6>
                            <div class="card module-logo-card mb-3">
                                <div class="card-body">
                                    <div class="row h-100">
                                        <div class="col-sm-6">
                                            <div class="form-group m-0 h-100 d-flex flex-column justify-content-center align-items-center">
                                                <label>
                                                    <?php echo e(translate('messages.icon')); ?>

                                                    <small class="text-danger">* ( <?php echo e(translate('messages.ratio')); ?> 1:1)</small>
                                                </label>
                                                <label class="text-center my-auto position-relative">
                                                    <img class="img--176 h-unset aspect-ratio-1 image--border" id="viewer" data-onerror-image="<?php echo e(asset('public/assets/admin/img/upload-img.png')); ?>" src="<?php echo e($module['icon_full_url']); ?>"
                                                    alt="image" />
                                                    <div class="icon-file-group">
                                                        <div class="icon-file">
                                                            <input type="file" name="icon" id="customFileEg1" class="custom-file-input" accept=".webp, .jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                                            <i class="tio-edit"></i>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-0 h-100 d-flex flex-column justify-content-center align-items-center">
                                                <label>
                                                    <?php echo e(translate('messages.thumbnail')); ?>

                                                    <small class="text-danger">* ( <?php echo e(translate('messages.ratio')); ?> 1:1)</small>
                                                </label>
                                                <label class="text-center my-auto position-relative">
                                                    <img class="img--176 h-unset aspect-ratio-1 image--border" id="viewer2" data-onerror-image="<?php echo e(asset('public/assets/admin/img/upload-img.png')); ?>" src="<?php echo e($module['thumbnail_full_url']); ?>"
                                                    alt="image" />
                                                    <div class="icon-file-group">
                                                        <div class="icon-file">
                                                            <input type="file" name="thumbnail" id="customFileEg2" class="custom-file-input" accept=".webp, .jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                                            <i class="tio-edit"></i>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn--container justify-content-end mt-20">
                <button type="reset" id="reset_btn" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.Save_changes')); ?></button>
            </div>
        </form>
            <!-- End Table -->
    </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin/ckeditor/ckeditor.js')); ?>"></script>
    <script>
        "use strict";


        function readURL(input, id) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();

                reader.onload = function (e) {
                    $('#'+id).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this,'viewer');
        });

        $("#customFileEg2").change(function () {
            readURL(this,'viewer2');
        });



        $(document).ready(function () {
            <?php if($module->module_type=='parcel'): ?>
                $('#module_des_card').hide();
            <?php endif; ?>
            $('.ckeditor').ckeditor();
        });

        $('#reset_btn').click(function(){
            $('.ckeditor').each(function() {
                CKEDITOR.instances[$(this).attr('id')].setData($(this).data('value'));
            });

            $('#viewer').attr('src','<?php echo e($module['icon_full_url']); ?>');
            $('#viewer2').attr('src','<?php echo e($module['thumbnail_full_url']); ?>');
        })
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/module/edit.blade.php ENDPATH**/ ?>