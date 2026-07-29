

<?php $__env->startSection('title',translate('Update delivery-man')); ?>


<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title text-break">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/edit.png')); ?>" class="w--26" alt="">
                </span>
                <span><?php echo e(translate('messages.update_deliveryman')); ?></span>
            </h1>
        </div>
        <!-- End Page Header -->

        <?php if(!empty($regFeeSettings['enabled']) || ($registrationFee ?? null)): ?>
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <span class="card-header-icon"><i class="tio-money"></i></span>
                        <?php echo e(translate('messages.dm_edit_registration_fee_section')); ?>

                    </h5>
                </div>
                <div class="card-body">
                    <?php if(!empty($regFeeSettings['enabled'])): ?>
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <span class="d-block text-muted small"><?php echo e(translate('messages.dm_registration_fee_total')); ?></span>
                                <span class="font-weight-bold"><?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?><?php echo e(number_format($registrationFee->total_fee ?? $regFeeSettings['total_fee'], 2)); ?></span>
                                <?php if (! ($registrationFee ?? null)): ?>
                                    <span class="badge badge-soft-info ml-1"><?php echo e(translate('messages.default')); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-4 mb-2">
                                <span class="d-block text-muted small"><?php echo e(translate('messages.dm_approve_initial_amount')); ?> (<?php echo e(translate('messages.recorded')); ?>)</span>
                                <?php if($registrationFee && $registrationFee->manual_confirmed): ?>
                                    <span class="font-weight-bold text-success"><?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?><?php echo e(number_format($registrationFee->manual_paid_amount, 2)); ?></span>
                                    <span class="text-muted small d-block"><?php echo e(\App\CentralLogics\Helpers::time_date_format($registrationFee->manual_confirmed_at)); ?></span>
                                <?php else: ?>
                                    <span class="font-weight-bold text-muted">—</span>
                                    <span class="d-block small text-muted"><?php echo e(translate('messages.dm_edit_initial_not_recorded')); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-4 mb-2">
                                <span class="d-block text-muted small"><?php echo e(translate('messages.remaining_due')); ?></span>
                                <span class="font-weight-bold"><?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?><?php echo e(number_format($registrationFee->wallet_remaining_due ?? $regFeeSettings['total_fee'], 2)); ?></span>
                                <?php if($registrationFee && $registrationFee->completed_at): ?>
                                    <span class="badge badge-soft-success ml-1"><?php echo e(translate('messages.completed')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <p class="mb-2 small text-muted"><?php echo e(translate('messages.dm_edit_initial_expected_hint')); ?> <?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?><?php echo e(number_format($regFeeSettings['manual_first_part'], 2)); ?></p>
                        <a class="btn btn-sm btn--secondary" href="<?php echo e(route('admin.users.delivery-man.registration-fee')); ?>"><?php echo e(translate('messages.dm_registration_fee_settings')); ?></a>
                    <?php else: ?>
                        <p class="mb-0 text-muted"><?php echo e(translate('messages.dm_reg_fee_disabled_edit_hint')); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('admin.users.delivery-man.update',[$deliveryMan['id']])); ?>" method="post" class="js-validate"
                enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        <span class="card-title-icon"><i class="tio-user"></i></span>
                        <span>
                            <?php echo e(translate('general_information')); ?>

                        </span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.first_name')); ?> <span class="form-label-secondary text-danger"
                            data-toggle="tooltip" data-placement="right"
                            data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                            </span>
                                </label>
                                        <input type="text" value="<?php echo e($deliveryMan['f_name']); ?>" name="f_name"
                                                class="form-control" placeholder="<?php echo e(translate('messages.first_name')); ?>"
                                                required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.last_name')); ?> <span class="form-label-secondary text-danger"
                            data-toggle="tooltip" data-placement="right"
                            data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                            </span>
                                </label>
                                        <input type="text" value="<?php echo e($deliveryMan['l_name']); ?>" name="l_name"
                                                class="form-control" placeholder="<?php echo e(translate('messages.last_name')); ?>"
                                                required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.email')); ?> <span class="form-label-secondary text-danger"
                            data-toggle="tooltip" data-placement="right"
                            data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                            </span>
                                </label>
                                        <input type="email" value="<?php echo e($deliveryMan['email']); ?>" name="email" class="form-control"
                                                placeholder="<?php echo e(translate('messages.Ex:')); ?> ex@example.com"
                                                required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.deliveryman_type')); ?> <span class="form-label-secondary text-danger"
                            data-toggle="tooltip" data-placement="right"
                            data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                            </span>
                                </label>
                                        <select name="earning" class="form-control  js-select2-custom" required>
                                            <option value="1" <?php echo e($deliveryMan->earning?'selected':''); ?>><?php echo e(translate('messages.freelancer')); ?></option>
                                            <option value="0" <?php echo e($deliveryMan->earning?'':'selected'); ?>><?php echo e(translate('messages.salary_based')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.zone')); ?> <span class="form-label-secondary text-danger"
                            data-toggle="tooltip" data-placement="right"
                            data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                            </span>
                                </label>
                                        <select name="zone_id" class="form-control  js-select2-custom">
                                        <?php $__currentLoopData = \App\Models\Zone::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(isset(auth('admin')->user()->zone_id)): ?>
                                                <?php if(auth('admin')->user()->zone_id == $zone->id): ?>
                                                    <option value="<?php echo e($zone->id); ?>" <?php echo e($zone->id == $deliveryMan->zone_id?'selected':''); ?>><?php echo e($zone->name); ?></option>
                                                <?php endif; ?>
                                            <?php else: ?>
                                            <option value="<?php echo e($zone->id); ?>" <?php echo e($zone->id == $deliveryMan->zone_id?'selected':''); ?>><?php echo e($zone->name); ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-0">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.vehicle')); ?><span class="form-label-secondary text-danger"
                                            data-toggle="tooltip" data-placement="right"
                                            data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                            </span>
                                        </label>
                                        <select name="vehicle_id" class="form-control js-select2-custom h--45px">
                                            <option value="" readonly="true" hidden="true"><?php echo e(translate('messages.select_vehicle')); ?></option>
                                        <?php $__currentLoopData = \App\Models\DMVehicle::where('status',1)->get(['id','type']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($v->id); ?>" <?php echo e($v->id == $deliveryMan->vehicle_id?'selected':''); ?>><?php echo e($v->type); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="d-flex flex-column h-100">
                                <label><?php echo e(translate('messages.deliveryman_image')); ?> <small class="text-danger">* ( <?php echo e(translate('messages.ratio')); ?> 1:1 )</small></label>
                                <div class="text-center py-3 my-auto">
                                    <img class="img--100 rounded onerror-image" id="viewer"
                                    src="<?php echo e($deliveryMan['image_full_url']); ?>"
                                            data-onerror-image="<?php echo e(asset('/public/assets/admin/img/admin.png')); ?>"
                                            alt="delivery-man image"/>
                                </div>
                                <div class="custom-file">
                                    <input type="file" name="image" id="customFileEg1" class="custom-file-input"
                                            accept=".webp, .jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    <label class="custom-file-label" for="customFileEg1"><?php echo e(translate('messages.choose_file')); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="row g-3">
                                <div class="col-sm-6 col-lg-12">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.identity_type')); ?><span class="form-label-secondary text-danger"
                                            data-toggle="tooltip" data-placement="right"
                                            data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                            </span>
                </label>
                                        <select name="identity_type" class="form-control  js-select2-custom">
                                            <option
                                                value="passport" <?php echo e($deliveryMan['identity_type']=='passport'?'selected':''); ?>>
                                                <?php echo e(translate('messages.passport')); ?>

                                            </option>
                                            <option
                                                value="driving_license" <?php echo e($deliveryMan['identity_type']=='driving_license'?'selected':''); ?>>
                                                <?php echo e(translate('messages.driving_license')); ?>

                                            </option>
                                            <option value="nid" <?php echo e($deliveryMan['identity_type']=='nid'?'selected':''); ?>><?php echo e(translate('messages.nid')); ?>

                                            </option>
                                            <option
                                                value="store_id" <?php echo e($deliveryMan['identity_type']=='store_id'?'selected':''); ?>>
                                                <?php echo e(translate('messages.store_id')); ?>

                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-12">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.identity_number')); ?><span class="form-label-secondary text-danger"
                                            data-toggle="tooltip" data-placement="right"
                                            data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                            </span>
                </label>
                                        <input type="text" name="identity_number" value="<?php echo e($deliveryMan['identity_number']); ?>"
                                                class="form-control"
                                                placeholder="<?php echo e(translate('messages.Ex:')); ?> DH-23434-LS"
                                                required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="row g-3">
                                <div class="col-md-6 pb-0">
                                    <div class="row g-2">
                                        <div class="col-12 pb-0">
                                            <div class="form-group mb-0">
                                                <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.identity_images')); ?>

                                            </div>
                                        </div>
                                        <?php $__currentLoopData = $deliveryMan['identity_image_full_url']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-6 spartan_item_wrapper size--sm">
                                            <img class="rounded border" src="<?php echo e($img); ?>">
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.update_identity_image')); ?></label>
                                    <div>
                                        <div class="row g-2 mt-0" id="coba"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title">
                        <span class="card-header-icon">
                            <i class="tio-user"></i>
                        </span>
                        <span>
                            <?php echo e(translate('messages.account_information')); ?>

                        </span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-4">
                            <div class="form-group mb-0">
                                <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.phone')); ?><span class="form-label-secondary text-danger"
                                    data-toggle="tooltip" data-placement="right"
                                    data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                    </span>
        </label>
                                <input type="tel" id="phone" name="phone" value="<?php echo e($deliveryMan['phone']); ?>" class="form-control"
                                        placeholder="<?php echo e(translate('messages.Ex:')); ?> 017********"
                                        required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="js-form-message form-group mb-0">
                                <label class="input-label" for="signupSrPassword"><?php echo e(translate('messages.password')); ?>

                                    <span class="form-label-secondary" data-toggle="tooltip" data-placement="right"
        data-original-title="<?php echo e(translate('messages.Must_contain_at_least_one_number_and_one_uppercase_and_lowercase_letter_and_symbol,_and_at_least_8_or_more_characters')); ?>"><img src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>" alt="<?php echo e(translate('messages.Must_contain_at_least_one_number_and_one_uppercase_and_lowercase_letter_and_symbol,_and_at_least_8_or_more_characters')); ?>"></span>
                                </label>

                                <div class="input-group input-group-merge">
                                    <input type="password" class="js-toggle-password form-control" name="password" id="signupSrPassword"                                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="<?php echo e(translate('messages.Must_contain_at_least_one_number_and_one_uppercase_and_lowercase_letter_and_symbol,_and_at_least_8_or_more_characters')); ?>"
                                    placeholder="<?php echo e(translate('messages.password_length_placeholder', ['length' => '8+'])); ?>"
                                    aria-label="8+ characters required"
                                    data-msg="Your password is invalid. Please try again."
                                    data-hs-toggle-password-options='{
                                    "target": [".js-toggle-password-target-1"],
                                    "defaultClass": "tio-hidden-outlined",
                                    "showClass": "tio-visible-outlined",
                                    "classChangeTarget": ".js-toggle-passowrd-show-icon-1"
                                    }'>
                                    <div class="js-toggle-password-target-1 input-group-append">
                                        <a class="input-group-text" href="javascript:;">
                                            <i class="js-toggle-passowrd-show-icon-1 tio-visible-outlined"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="js-form-message form-group mb-0">
                                <label class="input-label" for="signupSrConfirmPassword"><?php echo e(translate('messages.confirm_password')); ?></label>
                                <div class="input-group input-group-merge">
                                <input type="password" class="js-toggle-password form-control" name="confirmPassword" id="signupSrConfirmPassword" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="<?php echo e(translate('messages.Must_contain_at_least_one_number_and_one_uppercase_and_lowercase_letter_and_symbol,_and_at_least_8_or_more_characters')); ?>"
                                placeholder="<?php echo e(translate('messages.password_length_placeholder', ['length' => '8+'])); ?>"
                                aria-label="8+ characters required"
                                        data-msg="Password does not match the confirm password."
                                        data-hs-toggle-password-options='{
                                        "target": [".js-toggle-password-target-2"],
                                        "defaultClass": "tio-hidden-outlined",
                                        "showClass": "tio-visible-outlined",
                                        "classChangeTarget": ".js-toggle-passowrd-show-icon-2"
                                        }'>
                                    <div class="js-toggle-password-target-2 input-group-append">
                                        <a class="input-group-text" href="javascript:;">
                                        <i class="js-toggle-passowrd-show-icon-2 tio-visible-outlined"></i>
                                        </a>
                                    </div>
                                </div>
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

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin/js/spartan-multi-image-picker.js')); ?>"></script>
<script>
    "use strict";
        function readURL(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();

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
                rowHeight: '100px',
                groupClassName: 'col-6 spartan_item_wrapper size--sm',
                maxFileSize: '',
                placeholderImage: {
                    image: '<?php echo e(asset('public/assets/admin/img/400x400/img2.jpg')); ?>',
                    width: '100%'
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('Please only input png or jpg type file', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('File size too big', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });

        $('#reset_btn').click(function(){
            $('#viewer').attr('src','<?php echo e(asset('storage/app/public/delivery-man')); ?>/<?php echo e($deliveryMan['image']); ?>');
            $("#coba").empty().spartanMultiImagePicker({
                fieldName: 'identity_image[]',
                maxCount: 5,
                rowHeight: '120px',
                groupClassName: 'col-6 spartan_item_wrapper size--sm',
                maxFileSize: '',
                placeholderImage: {
                    image: '<?php echo e(asset('public/assets/admin/img/400x400/img2.jpg')); ?>',
                    width: '100%'
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('<?php echo e(translate('messages.please_only_input_png_or_jpg_type_file')); ?>', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('<?php echo e(translate('messages.file_size_too_big')); ?>', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        })

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/delivery-man/edit.blade.php ENDPATH**/ ?>