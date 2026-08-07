<?php $__env->startSection('title', translate('messages.deliveryman_registration')); ?>


<?php $__env->startSection('content'); ?>

<?php
  $country=\App\Models\BusinessSetting::where('key','country')->first();
$countryCode= strtolower($country?$country->value:'auto');

?>
    <section class="about-section py-5 position-relative">
        <div class="container">
            <!-- Page Header -->
            <div class="section-header">
                <h2 class="title mb-2"><?php echo e(translate("messages.Deliveryman")); ?> <span class="text--base"><?php echo e(translate("messages.Application")); ?></span></h2>
            </div>
            <!-- End Page Header -->
                <form action="<?php echo e(route('deliveryman.store')); ?>" method="post" enctype="multipart/form-data" id="form-id">
                    <?php echo csrf_field(); ?>
                    <div class="card __card mb-3">
                        <div class="card-header">
                            <h5 class="card-title">
                                <svg width="20" x="0" y="0" viewBox="0 0 460.8 460.8" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><g><g><g>
                                        <path d="M230.432,239.282c65.829,0,119.641-53.812,119.641-119.641C350.073,53.812,296.261,0,230.432,0
                                            S110.792,53.812,110.792,119.641S164.604,239.282,230.432,239.282z" fill="#020202" data-original="#000000" class=""></path>
                                        <path d="M435.755,334.89c-3.135-7.837-7.314-15.151-12.016-21.943c-24.033-35.527-61.126-59.037-102.922-64.784
                                            c-5.224-0.522-10.971,0.522-15.151,3.657c-21.943,16.196-48.065,24.555-75.233,24.555s-53.29-8.359-75.233-24.555
                                            c-4.18-3.135-9.927-4.702-15.151-3.657c-41.796,5.747-79.412,29.257-102.922,64.784c-4.702,6.792-8.882,14.629-12.016,21.943
                                            c-1.567,3.135-1.045,6.792,0.522,9.927c4.18,7.314,9.404,14.629,14.106,20.898c7.314,9.927,15.151,18.808,24.033,27.167
                                            c7.314,7.314,15.673,14.106,24.033,20.898c41.273,30.825,90.906,47.02,142.106,47.02s100.833-16.196,142.106-47.02
                                            c8.359-6.269,16.718-13.584,24.033-20.898c8.359-8.359,16.718-17.241,24.033-27.167c5.224-6.792,9.927-13.584,14.106-20.898
                                            C436.8,341.682,437.322,338.024,435.755,334.89z" fill="#020202" data-original="#000000" class=""></path>
                                    </g>
                                </g>
                            </g>
                            </svg><?php echo e(translate('messages.deliveryman_info')); ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label class="input-label"
                                            for="exampleFormControlInput1"><?php echo e(translate('messages.first_name')); ?></label>
                                        <input type="text" name="f_name" class="form-control __form-control"
                                            placeholder="<?php echo e(translate('messages.first_name')); ?>" required
                                            value="<?php echo e(old('f_name')); ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label class="input-label"
                                            for="exampleFormControlInput1"><?php echo e(translate('messages.last_name')); ?></label>
                                        <input type="text" name="l_name" class="form-control __form-control"
                                            placeholder="<?php echo e(translate('messages.last_name')); ?>"
                                            value="<?php echo e(old('l_name')); ?>" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="input-label"
                                            for="exampleFormControlInput1"><?php echo e(translate('messages.email')); ?></label>
                                        <input type="email" name="email" class="form-control __form-control"
                                            placeholder="<?php echo e(translate('messages.Ex:')); ?> ex@example.com" value="<?php echo e(old('email')); ?>" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="input-label"
                                            for="exampleFormControlInput1"><?php echo e(translate('messages.deliveryman_type')); ?></label>
                                        <select name="earning" class="form-control __form-control">
                                            <option value="1"><?php echo e(translate('messages.freelancer')); ?></option>
                                            <option value="0"><?php echo e(translate('messages.salary_based')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group mb-3">
                                        <label class="input-label"
                                            for="exampleFormControlInput1"><?php echo e(translate('messages.zone')); ?></label>
                                        <select name="zone_id" class="form-control __form-control" required
                                            data-placeholder="<?php echo e(translate('messages.select_zone')); ?>">
                                            <option value="" readonly="true" hidden="true"><?php echo e(translate('messages.select_zone')); ?></option>
                                            <?php $__currentLoopData = \App\Models\Zone::active()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(isset(auth('admin')->user()->zone_id)): ?>
                                                    <?php if(auth('admin')->user()->zone_id == $zone->id): ?>
                                                        <option value="<?php echo e($zone->id); ?>" selected><?php echo e($zone->name); ?>

                                                        </option>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <option value="<?php echo e($zone->id); ?>"><?php echo e($zone->name); ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="form-group">
                                      <label class="input-label"
                                                for="exampleFormControlInput1"><?php echo e(translate('messages.Vehicle')); ?></label>
                                            <select name="vehicle_id" class="form-control js-select2-custom h--45px" required
                                                data-placeholder="<?php echo e(translate('messages.select_vehicle')); ?>">
                                                <option value="" readonly="true" hidden="true"><?php echo e(translate('messages.select_vehicle')); ?></option>
                                                <?php $__currentLoopData = \App\Models\DMVehicle::where('status',1)->get(['id','type']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($v->id); ?>" ><?php echo e($v->type); ?>

                                                            </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label class="input-label"
                                            for="exampleFormControlInput1"><?php echo e(translate('messages.identity_type')); ?></label>
                                        <select name="identity_type" class="form-control __form-control">
                                            <option value="passport"><?php echo e(translate('messages.passport')); ?></option>
                                            <option value="driving_license"><?php echo e(translate('messages.driving_license')); ?></option>
                                            <option value="nid"><?php echo e(translate('messages.nid')); ?></option>
                                            <option value="restaurant_id"><?php echo e(translate('messages.store_id')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-3">
                                        <label class="input-label"
                                            for="exampleFormControlInput1"><?php echo e(translate('messages.identity_number')); ?></label>
                                        <input type="text" name="identity_number" class="form-control __form-control"
                                            value="<?php echo e(old('identity_number')); ?>" placeholder="<?php echo e(translate('messages.Ex:')); ?> DH-23434-LS" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group mb-0">
                                        <label class="input-label"><?php echo e(translate('messages.identity_image')); ?></label>
                                        <div>
                                            <div class="row" id="coba"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card __card mb-3">
                        <div class="card-header">
                            <h5 class="card-title">
                                <svg width="20" x="0" y="0" viewBox="0 0 460.8 460.8" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><g><g><g>
                                        <path d="M230.432,239.282c65.829,0,119.641-53.812,119.641-119.641C350.073,53.812,296.261,0,230.432,0
                                            S110.792,53.812,110.792,119.641S164.604,239.282,230.432,239.282z" fill="#020202" data-original="#000000" class=""></path>
                                        <path d="M435.755,334.89c-3.135-7.837-7.314-15.151-12.016-21.943c-24.033-35.527-61.126-59.037-102.922-64.784
                                            c-5.224-0.522-10.971,0.522-15.151,3.657c-21.943,16.196-48.065,24.555-75.233,24.555s-53.29-8.359-75.233-24.555
                                            c-4.18-3.135-9.927-4.702-15.151-3.657c-41.796,5.747-79.412,29.257-102.922,64.784c-4.702,6.792-8.882,14.629-12.016,21.943
                                            c-1.567,3.135-1.045,6.792,0.522,9.927c4.18,7.314,9.404,14.629,14.106,20.898c7.314,9.927,15.151,18.808,24.033,27.167
                                            c7.314,7.314,15.673,14.106,24.033,20.898c41.273,30.825,90.906,47.02,142.106,47.02s100.833-16.196,142.106-47.02
                                            c8.359-6.269,16.718-13.584,24.033-20.898c8.359-8.359,16.718-17.241,24.033-27.167c5.224-6.792,9.927-13.584,14.106-20.898
                                            C436.8,341.682,437.322,338.024,435.755,334.89z" fill="#020202" data-original="#000000" class=""></path>
                                    </g>
                                </g>
                            </g>
                            </svg><?php echo e(translate('messages.login_info')); ?>

                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="input-label" for="phone"><?php echo e(translate('messages.phone')); ?></label>
                                        <div class="input-group">
                                            <input type="tel" name="phone" id="phone" placeholder="<?php echo e(translate('messages.Ex:')); ?> 017********"
                                                class="form-control __form-control" value="<?php echo e(old('tel')); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="input-label"
                                            for="exampleFormControlInput1"><?php echo e(translate('messages.password')); ?>  <span class="form-label-secondary" data-toggle="tooltip" data-placement="right"
        data-original-title="<?php echo e(translate('messages.Must_contain_at_least_one_number_and_one_uppercase_and_lowercase_letter_and_symbol,_and_at_least_8_or_more_characters')); ?>"><img src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>" alt="<?php echo e(translate('messages.Must_contain_at_least_one_number_and_one_uppercase_and_lowercase_letter_and_symbol,_and_at_least_8_or_more_characters')); ?>"></span></label>
                                        <input type="text" name="password" class="form-control __form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="<?php echo e(translate('messages.Must_contain_at_least_one_number_and_one_uppercase_and_lowercase_letter_and_symbol,_and_at_least_8_or_more_characters')); ?>"
                                        placeholder="<?php echo e(translate('messages.password_length_placeholder', ['length' => '8+'])); ?>"
                                        aria-label="8+ characters required"
                                            value="<?php echo e(old('password')); ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex">
                                <div class="col-lg-6">
                                    <div class="form-group pt-3 mb-5">
                                        <label  class="input-label"><?php echo e(translate('messages.deliveryman_image')); ?><small
                                            class="text-danger">* ( <?php echo e(translate('messages.ratio')); ?> 1:1 )</small></label>
                                        <label class="position-relative">
                                            <img class="__register-img mb-3 image--border h-140px" id="viewer"
                                                src="<?php echo e(asset('public/assets/admin/img/upload-img.png')); ?>"
                                                alt="delivery-man image" />
                                            <div class="icon-file-group">
                                                <div class="icon-file">
                                                    <input type="file" name="image" id="customFileEg1" class="form-control __form-control"
                                                    accept=".webp, .jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required>
                                                    <img src="<?php echo e(asset('/public/assets/admin/img/pen.png')); ?>" alt="">
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 col-12">
                                    
                                    <?php ($recaptcha = \App\CentralLogics\Helpers::get_business_settings('recaptcha')); ?>
                                    <?php if(isset($recaptcha) && $recaptcha['status'] == 1): ?>
                                        <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                                    <?php else: ?>
                                        <div class="row p-2">
                                            <div class="col-6 pr-0">
                                                <input type="text" class="form-control" name="custome_recaptcha"
                                                        id="custome_recaptcha" required placeholder="<?php echo e(\__('Enter recaptcha value')); ?>" autocomplete="off" value="<?php echo e(env('APP_DEBUG')?session('six_captcha'):''); ?>">
                                            </div>
                                            <div class="col-6" style="background-color: #FFFFFF; border-radius: 5px;">
                                                <img src="<?php echo $custome_recaptcha->inline(); ?>" style="width: 100%; border-radius: 4px;"/>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="cmn--btn border-0 outline-0" id="signInBtn"><?php echo e(translate('messages.submit')); ?></button>
                    </div>
                </form>
        </div>

    </section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function() {
            readURL(this);
        });

    </script>

    <script src="<?php echo e(asset('public/assets/admin/js/spartan-multi-image-picker.js')); ?>"></script>
    <script type="text/javascript">
        $(function() {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'identity_image[]',
                maxCount: 5,
                rowHeight: '120px',
                groupClassName: 'col-lg-2 col-md-4 col-sm-4 col-6',
                maxFileSize: '',
                placeholderImage: {
                    image: '<?php echo e(asset('public/assets/admin/img/upload-img.png')); ?>',
                    width: '100%',
                },
                dropFileLabel: "Drop Here",
                onAddRow: function(index, file) {

                },
                onRenderedPreview: function(index) {

                },
                onRemoveRow: function(index) {

                },
                onExtensionErr: function(index, file) {
                    toastr.error('<?php echo e(translate('messages.please_only_input_png_or_jpg_type_file')); ?>', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function(index, file) {
                    toastr.error('<?php echo e(translate('messages.file_size_too_big')); ?>', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });

    </script>


    
    <?php if(isset($recaptcha) && $recaptcha['status'] == 1): ?>
        <script src="https://www.google.com/recaptcha/api.js?render=<?php echo e($recaptcha['site_key']); ?>"></script>
    <?php endif; ?>
    <?php if(isset($recaptcha) && $recaptcha['status'] == 1): ?>
        <script>
            $(document).ready(function() {
                $('#signInBtn').click(function (e) {
                    e.preventDefault();
                    if (typeof grecaptcha === 'undefined') {
                        toastr.error('Invalid recaptcha key provided. Please check the recaptcha configuration.');
                        return;
                    }
                    grecaptcha.ready(function () {
                        grecaptcha.execute('<?php echo e($recaptcha['site_key']); ?>', {action: 'submit'}).then(function (token) {
                            $('#g-recaptcha-response').value = token;
                            $('#form-id').submit();
                        });
                    });
                    window.onerror = function (message) {
                        var errorMessage = 'An unexpected error occurred. Please check the recaptcha configuration';
                        if (message.includes('Invalid site key')) {
                            errorMessage = 'Invalid site key provided. Please check the recaptcha configuration.';
                        } else if (message.includes('not loaded in api.js')) {
                            errorMessage = 'reCAPTCHA API could not be loaded. Please check the recaptcha API configuration.';
                        }
                        toastr.error(errorMessage)
                        return true;
                    };
                });
            });
        </script>
    <?php endif; ?>
    
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.landing.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/dm-registration.blade.php ENDPATH**/ ?>