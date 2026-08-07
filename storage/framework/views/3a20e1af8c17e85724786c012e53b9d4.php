<?php $__env->startSection('title',translate('messages.business_modules')); ?>

<?php $__env->startPush('css_or_js'); ?>
<link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/radio-image.css')); ?>">

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-header-title">
            <span class="page-header-icon">
                <img src="<?php echo e(asset('/public/assets/admin/img/module.png')); ?>" alt="">
            </span>
            <span>
                <?php echo e(translate('Add_New_Business_Module')); ?>

            </span>
        </h1>
        <div class="alert alert-soft-primary alert-dismissible fade show d-flex" role="alert">
            <div>
                <img src="<?php echo e(asset('/public/assets/admin/img/icons/intel.png')); ?>" width="22" alt="">
            </div>
            <div class="w-0 flex-grow-1 pl-3">
                <strong><?php echo e(translate('Attention!')); ?></strong> <?php echo e(translate('Don’t_forget_to_click_the_‘Add_Module’_button_below_to_save_the_new_business_module')); ?>

            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- <div class="mt-2 d-flex">
            <div class="d-flex flex-wrap justify-content-end align-items-center flex-grow-1 p--10">
                <div class="blinkings active">
                    <i class="tio-info-outined"></i>
                    <div class="business-notes">
                        <h6><img src="<?php echo e(asset('/public/assets/admin/img/notes.png')); ?>" alt=""> <?php echo e(translate('Note')); ?></h6>
                        <div>
                        <?php echo e(translate('messages.Don’t_forget_to_click_the_‘Add_Module’_button_below_to_save_the_new_business_module.')); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
    <!-- End Page Header -->

    <h5 class="mb-3"><?php echo e(translate('basic_setup')); ?></h5>
    <form action="<?php echo e(route('admin.business-settings.module.store')); ?>" method="post" enctype="multipart/form-data">
        <div class="card">
            <div class="card-body pb-0">
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
                <?php endif; ?>
                <?php if($language): ?>
                <div class="lang_form p-1 mb-2" id="default-form">
                    <div class="form-group">
                        <label class="input-label text-capitalize d-flex" for="exampleFormControlInput1"><?php echo e(translate('Business_Module_name')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                        <input type="text" name="module_name[]" class="form-control" maxlength="191" placeholder="<?php echo e(translate('messages.Ex:_Grocery,eCommerce,Pharmacy,etc.')); ?>">
                    </div>
                    <div class="form-group">
                        <label class="input-label d-flex"><?php echo e(translate('Business_Module_description')); ?> (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary text-danger d-flex"
                            data-toggle="tooltip" data-placement="right"
                            data-original-title="<?php echo e(translate('messages.Write_a_short_description_of_your_new_business_module_within_100_words_(550_characters)')); ?>"><img
                                src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>"
                                alt="<?php echo e(translate('messages.veg_non_veg')); ?>"></span></label>
                        <textarea id="description" class="ckeditor form-control" name="description[]"></textarea>
                    </div>
                </div>

                <input type="hidden" name="lang[]" value="default">
                <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="d-none lang_form p-1 mb-2" id="<?php echo e($lang); ?>-form">
                    <div class="form-group">
                        <label class="input-label text-capitalize d-flex" for="exampleFormControlInput1"><?php echo e(translate('Business_Module_name')); ?> (<?php echo e(strtoupper($lang)); ?>)</label>
                        <input type="text" name="module_name[]" class="form-control" maxlength="191" placeholder="<?php echo e(translate('messages.Ex:_Grocery,eCommerce,Pharmacy,etc.')); ?>">
                    </div>
                    <div class="form-group">
                        <label class="input-label d-flex"><?php echo e(translate('Business_Module_description')); ?> (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary text-danger d-flex"
                            data-toggle="tooltip" data-placement="right"
                            data-original-title="<?php echo e(translate('messages.Write_a_short_description_of_your_new_business_module_within_100_words_(550_characters)')); ?>"><img
                                src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>"
                                alt="<?php echo e(translate('messages.veg_non_veg')); ?>"></span></label>
                        <textarea id="description<?php echo e($lang); ?>" class="ckeditor form-control" name="description[]"></textarea>
                    </div>
                </div>

                <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                <div class="form-group">
                    <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('Business_Module_name')); ?></label>
                    <input type="text" name="module_name" class="form-control" value="<?php echo e(old('name')); ?>" maxlength="191"  placeholder="<?php echo e(translate('messages.Ex:_business_Module Name')); ?>">
                </div>
                <div class="form-group">
                    <label class="input-label"><?php echo e(translate('Business_Module_description')); ?></label>
                    <textarea id="description" class="ckeditor form-control" name="description"></textarea>
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
                        <h6 class="mb-3"><?php echo e(translate('select_business_module_type')); ?></h6>
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="module-radio-group">
                                <?php $__currentLoopData = config('module.module_type'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($key != 'rental'): ?>
                                <label class="form-check form--check">
                                    <input class="form-check-input" type="radio" name="module_type" value="<?php echo e($key); ?>">
                                    <span class="form-check-label">
                                        <?php echo e(translate($key)); ?>

                                    </span>
                                </label>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h6 class="mb-3"><?php echo e(translate('Chose related images')); ?></h6>
                        <div class="card module-logo-card mb-3">
                            <div class="card-body">
                                <div class="row h-100">
                                    <div class="col-sm-6 mb-4 mb-sm-0">
                                        <div class="form-group m-0 h-100 d-flex align-items-center flex-column justify-content-center pb-lg-2">
                                            <label class="form-label mb-3">
                                                <?php echo e(translate('messages.icon')); ?>

                                                <small class="text-danger">* ( <?php echo e(translate('messages.ratio')); ?> 1:1)</small>
                                            </label>
                                            <label class="text-center my-auto position-relative">
                                                <img class="img--176 h-unset aspect-ratio-1 image--border" id="viewer" src="<?php echo e(asset('public/assets/admin/img/upload-img.png')); ?>" alt="image" />
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
                                        <div class="form-group m-0 h-100 d-flex flex-column justify-content-center align-items-center pb-lg-2">
                                            <label class="form-label mb-3">
                                                <?php echo e(translate('messages.thumbnail')); ?>

                                                <small class="text-danger">* ( <?php echo e(translate('messages.ratio')); ?> 1:1)</small>
                                            </label>
                                            <label class="text-center my-auto position-relative">
                                                <img class="img--176 h-unset aspect-ratio-1 image--border" id="viewer2" src="<?php echo e(asset('public/assets/admin/img/upload-img.png')); ?>" alt="image" />
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
        <div class="btn--container justify-content-end mt-4">
            <button type="reset" id="reset_btn" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
            <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.Add_Module')); ?></button>
        </div>
    </form>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin/ckeditor/ckeditor.js')); ?>"></script>
    <script>
        "use strict";
    $('.module-change').on('click', function (){
        let id = $(this).val();
        modulChange(id)
    })
    function modulChange(id) {
        $.get({
            url: "<?php echo e(url('/')); ?>/admin/module/type/?module_type=" + id,
            dataType: 'json',
            success: function(data) {
                if(data.data.description.length)
                {
                    $('#module_des_card').show();
                    $('#module_description').html(data.data.description);
                }
                else
                {
                    $('#module_des_card').hide();
                }
                if(id=='parcel')
                {
                    $('#module_theme').hide();
                    $('#zone_check').hide();
                }
                else{
                    $('#module_theme').show();
                    $('#zone_check').show();
                }
            },
        });
    }

    function readURL(input, id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#' + id).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#customFileEg1").change(function() {
        readURL(this, 'viewer');
    });

    $("#customFileEg2").change(function() {
        readURL(this, 'viewer2');
    });

    $(".lang_link").click(function(e) {
        e.preventDefault();
        $(".lang_link").removeClass('active');
        $(".lang_form").addClass('d-none');
        $(this).addClass('active');

        let form_id = this.id;
        let lang = form_id.substring(0, form_id.length - 5);
        console.log(lang);
        $("#" + lang + "-form").removeClass('d-none');
    });

    $(document).ready(function () {
        $('.ckeditor').ckeditor();
    });

        $('#reset_btn').click(function(){
            $('.ckeditor').each(function() {
                CKEDITOR.instances[$(this).attr('id')].setData('');
            });
            $('#viewer').attr('src','<?php echo e(asset('public/assets/admin/img/400x400/img2.jpg')); ?>');
            $('#viewer2').attr('src','<?php echo e(asset('public/assets/admin/img/400x400/img2.jpg')); ?>');
        })
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/module/create.blade.php ENDPATH**/ ?>