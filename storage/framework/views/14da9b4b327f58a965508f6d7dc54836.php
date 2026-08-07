<?php $__env->startSection('title',translate('Update delivery-man')); ?>


<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/edit.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.update_deliveryman')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <form action="javascript:" method="post"
                enctype="multipart/form-data" id="deliaveryman_form" class="js-validate">
            <?php echo csrf_field(); ?>
            <div class="row g-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="tio-user"></i> <?php echo e(translate('messages.general_information')); ?>

                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-sm-6 col-md-4">
                                    <label class="input-label" for="f_name"><?php echo e(translate('messages.first_name')); ?></label>
                                    <input type="text" id="f_name" value="<?php echo e($delivery_man['f_name']); ?>" name="f_name"
                                        class="form-control" placeholder="<?php echo e(translate('messages.first_name')); ?>"
                                        required>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <label class="input-label" for="l_name"><?php echo e(translate('messages.last_name')); ?></label>
                                    <input type="text" id="l_name" value="<?php echo e($delivery_man['l_name']); ?>" name="l_name"
                                        class="form-control" placeholder="<?php echo e(translate('messages.last_name')); ?>"
                                        required>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="email"><?php echo e(translate('messages.email')); ?></label>
                                        <input type="email" id="email" value="<?php echo e($delivery_man['email']); ?>" name="email" class="form-control"
                                            placeholder="<?php echo e(translate('messages.Ex:')); ?> ex@example.com"
                                            required>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <label class="input-label" for="identity_type"><?php echo e(translate('messages.identity_type')); ?></label>
                                    <select name="identity_type" id="identity_type" class="form-control">
                                        <option
                                            value="passport" <?php echo e($delivery_man['identity_type']=='passport'?'selected':''); ?>>
                                            <?php echo e(translate('messages.passport')); ?>

                                        </option>
                                        <option
                                            value="driving_license" <?php echo e($delivery_man['identity_type']=='driving_license'?'selected':''); ?>>
                                            <?php echo e(translate('messages.driving_license')); ?>

                                        </option>
                                        <option value="nid" <?php echo e($delivery_man['identity_type']=='nid'?'selected':''); ?>><?php echo e(translate('messages.nid')); ?>

                                        </option>
                                    </select>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <label class="input-label" for="identity_number"><?php echo e(translate('messages.identity_number')); ?></label>
                                    <input type="text" name="identity_number" id="identity_number" value="<?php echo e($delivery_man['identity_number']); ?>"
                                        class="form-control"
                                        placeholder="<?php echo e(translate('messages.Ex:')); ?> DH-23434-LS"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="form-label m-0"><?php echo e(translate('messages.identity_image')); ?>

                            <small class="text-danger">* <?php echo e(translate('messages.( Ratio 190x120 )')); ?></small></h5>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="form-group">
                                <div class="btn--container" id="coba">
                                    <?php $__currentLoopData = $delivery_man['identity_image_full_url']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div>
                                            <img class="img--120"
                                            src="<?php echo e($img); ?>"  alt="image">
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="form-label m-0"><?php echo e(translate('messages.deliveryman_image')); ?>

                            <small class="text-danger">* ( <?php echo e(translate('messages.ratio')); ?> <?php echo e(translate('1:1')); ?> )</small></h5>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="my-auto">
                                <div class="text-center pt-3">
                                    <img class="img--120" id="viewer"

                                    src="<?php echo e($delivery_man['image_full_url']); ?>" alt="delivery-man image"/>
                                </div>
                            </div>
                            <div class="custom-file mt-3">
                                <input type="file" name="image" id="customFileEg1" class="custom-file-input read-url"
                                    accept=".webp, .jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                <label class="custom-file-label" for="customFileEg1"><?php echo e(translate('messages.choose_file')); ?></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="tio-user"></i> <?php echo e(translate('messages.account_information')); ?>

                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="phone"><?php echo e(translate('messages.phone')); ?></label>
                                        <input type="tel" id="phone" name="phone" value="<?php echo e($delivery_man['phone']); ?>" class="form-control"
                                                placeholder="<?php echo e(translate('messages.Ex:')); ?> 017********"
                                                required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="js-form-message form-group mb-0">
                                        <label class="input-label" for="signupSrPassword"><?php echo e(translate('messages.password')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right"
        data-original-title="<?php echo e(translate('messages.Must_contain_at_least_one_number_and_one_uppercase_and_lowercase_letter_and_symbol,_and_at_least_8_or_more_characters')); ?>"><img src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>" alt="<?php echo e(translate('messages.Must_contain_at_least_one_number_and_one_uppercase_and_lowercase_letter_and_symbol,_and_at_least_8_or_more_characters')); ?>"></span></label>

                                        <div class="input-group input-group-merge">
                                            <input type="password" class="js-toggle-password form-control" name="password" id="signupSrPassword" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="<?php echo e(translate('messages.Must_contain_at_least_one_number_and_one_uppercase_and_lowercase_letter_and_symbol,_and_at_least_8_or_more_characters')); ?>"
                                            placeholder="<?php echo e(translate('messages.password_length_placeholder', ['length' => '8+'])); ?>"
                                            aria-label="8+ characters required"
                                            data-msg="Your password is invalid. Please try again."
                                            data-hs-toggle-password-options='{
                                            "target": [".js-toggle-password-target-1", ".js-toggle-password-target-2"],
                                            "defaultClass": "tio-hidden-outlined",
                                            "showClass": "tio-visible-outlined",
                                            "classChangeTarget": ".js-toggle-passowrd-show-icon-1"
                                            }'>
                                            <div class="js-toggle-password-target-1 input-group-append">
                                                <a class="input-group-text" href="javascript:">
                                                    <i class="js-toggle-passowrd-show-icon-1 tio-visible-outlined"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="js-form-message form-group mb-0">
                                        <label class="input-label" for="signupSrConfirmPassword"><?php echo e(translate('messages.confirm_password')); ?></label>
                                        <div class="input-group input-group-merge">
                                        <input type="password" class="js-toggle-password form-control" name="confirmPassword" id="signupSrConfirmPassword" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="<?php echo e(translate('messages.Must_contain_at_least_one_number_and_one_uppercase_and_lowercase_letter_and_symbol,_and_at_least_8_or_more_characters')); ?>"
                                        placeholder="<?php echo e(translate('messages.password_length_placeholder', ['length' => '8+'])); ?>"
                                        aria-label="8+ characters required"
                                                data-msg="Password does not match the confirm password."
                                                data-hs-toggle-password-options='{
                                                "target": [".js-toggle-password-target-1", ".js-toggle-password-target-2"],
                                                "defaultClass": "tio-hidden-outlined",
                                                "showClass": "tio-visible-outlined",
                                                "classChangeTarget": ".js-toggle-passowrd-show-icon-2"
                                                }'>
                                            <div class="js-toggle-password-target-2 input-group-append">
                                                <a class="input-group-text" href="javascript:">
                                                <i class="js-toggle-passowrd-show-icon-2 tio-visible-outlined"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="btn--container justify-content-end">
                        <button type="reset" id="reset_btn" class="btn btn--reset location-reload" ><?php echo e(translate('messages.reset')); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.update')); ?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>

<script src="<?php echo e(asset('public/assets/admin/js/spartan-multi-image-picker.js')); ?>"></script>
<script type="text/javascript">
    "use strict";
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this);
        });
        $(function () {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'identity_image[]',
                maxCount: 5,
                rowHeight: '75px',
                groupClassName: '',
                maxFileSize: '',
                placeholderImage: {
                    image: '<?php echo e(asset('public/assets/admin/img/400x400/img2.jpg')); ?>',
                    width: '100%'
                },
                dropFileLabel: "<?php echo e(translate('Drop Here')); ?>",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function () {
                    toastr.error('<?php echo e(translate('Please only input png or jpg type file')); ?>', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function () {
                    toastr.error('<?php echo e(translate('File size too big')); ?>', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });

        $('#deliaveryman_form').on('submit', function () {
            let formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '<?php echo e(route('vendor.delivery-man.update',[$delivery_man['id']])); ?>',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.errors) {
                        for (let i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else if(data.message){
                        toastr.success(data.message, {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        setTimeout(function () {
                            location.href = '<?php echo e(route('vendor.delivery-man.list')); ?>';
                        }, 2000);
                    }
                }
            });
        });
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/delivery-man/edit.blade.php ENDPATH**/ ?>