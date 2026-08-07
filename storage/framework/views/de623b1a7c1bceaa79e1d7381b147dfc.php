<!DOCTYPE html>
<?php

    $log_email_succ = session()->get('log_email_succ');
?>

<html dir="<?php echo e($site_direction); ?>" lang="<?php echo e($locale); ?>" class="<?php echo e($site_direction === 'rtl'?'active':''); ?>">
<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Title -->
    <title><?php echo e(translate('messages.login')); ?></title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo e(asset('public/favicon.ico')); ?>">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin')); ?>/css/vendor.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin')); ?>/vendor/icon-set/style.css">
    <!-- CSS Front Template -->
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/theme.minc619.css?v=1.0')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('public/assets/admin')); ?>/css/toastr.css">
</head>

<body>
<!-- ========== MAIN CONTENT ========== -->
<main id="content" role="main" class="main">
    <div class="auth-wrapper">
        <div class="auth-wrapper-left">
            <div class="auth-left-cont">
                <?php ($store_logo = \App\Models\BusinessSetting::where(['key' => 'logo'])->first()); ?>
                <img class="onerror-image"  data-onerror-image="<?php echo e(asset('/public/assets/admin/img/favicon.png')); ?>"
                src="<?php echo e(\App\CentralLogics\Helpers::get_full_url('business', $store_logo?->value?? '', $store_logo?->storage[0]?->value ?? 'public','favicon')); ?>"  alt="public/img">
                <h2 class="title"><?php echo e(translate('Your')); ?> <span class="d-block"><?php echo e(translate('All Service')); ?></span> <strong class="text--039D55"><?php echo e(translate('in one field')); ?>....</strong></h2>
            </div>
        </div>
        <div class="auth-wrapper-right">
            <label class="badge badge-soft-success __login-badge">
                <?php echo e(translate('messages.software_version')); ?> : <?php echo e(env('SOFTWARE_VERSION')); ?>

            </label>

            <!-- Card -->
            <div class="auth-wrapper-form">
                <!-- Form -->
                <form class="" action="<?php echo e(route('login_post')); ?>" method="post" id="form-id">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="role" value="<?php echo e($role ?? null); ?>">
                    <div class="auth-header">
                        <div class="mb-5">
                            <h2 class="title"><?php echo e(translate($role)); ?> <?php echo e(translate('messages.login')); ?></h2>
                            <div><?php echo e(translate('messages.welcome_back_login_to_your_panel')); ?>.</div>
                        </div>
                    </div>

                    <!-- Form Group -->
                    <div class="js-form-message form-group">
                        <label class="input-label text-capitalize" for="signinSrEmail"><?php echo e(translate('messages.your_email')); ?></label>

                        <input type="email" class="form-control form-control-lg" name="email" id="signinSrEmail"
                                tabindex="1" placeholder="email@address.com" value="<?php echo e($email ?? ''); ?>" aria-label="email@address.com"
                                required data-msg="<?php echo e(translate('Please_enter_a_valid_email_address.')); ?>">
                    </div>
                    <!-- End Form Group -->

                    <!-- Form Group -->
                    <div class="js-form-message form-group mb-2">
                        <label class="input-label" for="signupSrPassword" tabindex="0">
                            <span class="d-flex justify-content-between align-items-center">
                                <?php echo e(translate('messages.password')); ?>

                            </span>
                        </label>

                        <div class="input-group input-group-merge">
                            <input type="password" class="js-toggle-password form-control form-control-lg"
                                    name="password" id="signupSrPassword" placeholder="<?php echo e(translate('messages.password_length_placeholder',['length'=>'6+'])); ?>" value="<?php echo e($password ?? ''); ?>"
                                    aria-label="<?php echo e(translate('messages.password_length_placeholder',['length'=>'6+'])); ?>" required
                                    data-msg="<?php echo e(translate('messages.invalid_password_warning')); ?>"
                                    data-hs-toggle-password-options='{
                                                "target": "#changePassTarget",
                                    "defaultClass": "tio-hidden-outlined",
                                    "showClass": "tio-visible-outlined",
                                    "classChangeTarget": "#changePassIcon"
                                    }'>
                            <div id="changePassTarget" class="input-group-append">
                                <a class="input-group-text" href="javascript:">
                                    <i id="changePassIcon" class="tio-visible-outlined"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- End Form Group -->

                    <div class="d-flex justify-content-between mt-5">
                        <!-- Checkbox -->
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="termsCheckbox" <?php echo e($password ? 'checked' : ''); ?>

                                        name="remember">
                                <label class="custom-control-label text-muted" for="termsCheckbox">
                                    <?php echo e(translate('messages.remember_me')); ?>

                                </label>
                            </div>
                        </div>
                        <!-- End Checkbox -->
                        <!-- forget password -->
                        <div class="form-group" id="forget-password" style="display: <?php echo e($role == 'admin' ? '' : 'none'); ?>;">
                            <div class="custom-control">
                                <span type="button" data-toggle="modal" class="text-primary" data-target="#forgetPassModal"><?php echo e(translate('Forget Password')); ?>?</span>
                            </div>
                        </div>
                        <!-- End forget password -->
                        <div class="form-group" id="forget-password1" style="display: <?php echo e($role == 'vendor' ? '' : 'none'); ?>;">
                            <div class="custom-control">
                                <span type="button" data-toggle="modal" class="text-primary" data-target="#forgetPassModal1"><?php echo e(translate('messages.Forget Password')); ?>?</span>
                            </div>
                        </div>
                        <!-- End forget password -->
                    </div>

                    <?php ($recaptcha = \App\CentralLogics\Helpers::get_business_settings('recaptcha')); ?>
                    <?php if(isset($recaptcha) && $recaptcha['status'] == 1): ?>
                        <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                        <input type="hidden" name="set_default_captcha" id="set_default_captcha_value" value="0" >
                        <div class="row p-2 d-none" id="reload-captcha">
                            <div class="col-6 pr-0">
                                <input type="text" class="form-control form-control-lg border-0" name="custome_recaptcha"
                                        id="custome_recaptcha" required placeholder="<?php echo e(translate('Enter recaptcha value')); ?>" autocomplete="off" value="<?php echo e(env('APP_MODE')=='dev'? session('six_captcha'):''); ?>">
                            </div>
                            <div class="col-6 bg-white rounded d-flex">
                                <img src="<?php echo $custome_recaptcha->inline(); ?>" class="rounded w-100" />
                                <div class="p-3 pr-0 capcha-spin reloadCaptcha">
                                    <i class="tio-cached"></i>
                                </div>
                            </div>
                        </div>

                        <?php else: ?>
                        <div class="row p-2" id="reload-captcha">
                            <div class="col-6 pr-0">
                                <input type="text" class="form-control form-control-lg border-0" name="custome_recaptcha"
                                        id="custome_recaptcha" required placeholder="<?php echo e(translate('Enter recaptcha value')); ?>" autocomplete="off" value="<?php echo e(env('APP_MODE')=='dev'? session('six_captcha'):''); ?>">
                            </div>
                            <div class="col-6 bg-white rounded d-flex">
                                <img src="<?php echo $custome_recaptcha->inline(); ?>" class="rounded w-100" />
                                <div class="p-3 pr-0 capcha-spin reloadCaptcha">
                                    <i class="tio-cached"></i>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <button type="submit" class="btn btn-lg btn-block btn--primary mt-xxl-3" id="signInBtn"><?php echo e(translate('messages.login')); ?></button>
                </form>
                <!-- End Form -->
                <?php if(env('APP_MODE') == 'demo'): ?>
                <?php if(isset($role) && $role == 'admin'): ?>
                <div class="auto-fill-data-copy">
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div>
                            <span class="d-block"><strong>Email</strong> : admin@admin.com</span>
                            <span class="d-block"><strong>Password</strong> : 12345678</span>
                        </div>
                        <div>
                            <button class="btn action-btn btn--primary m-0 copy_cred"><i class="tio-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php if(isset($role) && $role == 'vendor'): ?>
                <div class="auto-fill-data-copy">
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div>
                            <span class="d-block"><strong>Email</strong> : test.restaurant@gmail.com</span>
                            <span class="d-block"><strong>Password</strong> : 12345678</span>
                        </div>
                        <div>
                            <button class="btn action-btn btn--primary m-0 copy_cred2"><i class="tio-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php endif; ?>
            </div>
            <!-- End Card -->

        </div>
    </div>
</main>
<!-- ========== END MAIN CONTENT ========== -->
<div class="modal fade" id="forgetPassModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header justify-content-end">
        <span type="button" class="close-modal-icon" data-dismiss="modal">
            <i class="tio-clear"></i>
        </span>
      </div>
      <div class="modal-body">
        <div class="forget-pass-content">
            <img src="<?php echo e(asset('/public/assets/admin/img/send-mail.svg')); ?>" alt="">
            <!-- After Succeed -->
            <h4>
                <?php echo e(translate('Send_Mail_to_Your_Email')); ?> ?
            </h4>
            <p>
                <?php echo e(translate('A mail will be send to your registered email')); ?> <?php echo e(isset($role) && $role == 'admin'  ? \App\Models\Admin::where('role_id',1)->first()?->masked_email : ''); ?> <?php echo e(translate('with a  link to change passowrd')); ?>

            </p>
            <a class="btn btn-lg btn-block btn--primary mt-3" href="<?php echo e(route('reset-password')); ?>">
                <?php echo e(translate('Send Mail')); ?>

            </a>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="forgetPassModal1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header justify-content-end">
        <span type="button" class="close-modal-icon" data-dismiss="modal">
            <i class="tio-clear"></i>
        </span>
      </div>
      <div class="modal-body">
        <div class="forget-pass-content">
            <img src="<?php echo e(asset('/public/assets/admin/img/send-mail.svg')); ?>" alt="">
            <!-- After Succeed -->
            <!-- <img src="<?php echo e(asset('/public/assets/admin/img/sent-mail.svg')); ?>" alt=""> -->
            <h4>
                <?php echo e(translate('messages.Send_Mail_to_Your_Email')); ?> ?
            </h4>
            <form class="" action="<?php echo e(route('vendor-reset-password')); ?>" method="post">
                <?php echo csrf_field(); ?>

                <input type="email" name="email" id="" class="form-control" placeholder="<?php echo e(translate('messages.plesae_enter_your_registerd_email')); ?>" required>
                <button type="submit" class="btn btn-lg btn-block btn--primary mt-3"><?php echo e(translate('messages.Send Mail')); ?></button>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="successMailModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header justify-content-end">
          <span type="button" class="close-modal-icon" data-dismiss="modal">
              <i class="tio-clear"></i>
          </span>
        </div>
        <div class="modal-body">
          <div class="forget-pass-content">
              <!-- After Succeed -->
              <img src="<?php echo e(asset('/public/assets/admin/img/sent-mail.svg')); ?>" alt="">
              <h4>
                <?php echo e(translate('A mail has been sent to your registered email')); ?>!
              </h4>
              <p>
                <?php echo e(translate('Click the link in the mail description to change password')); ?>

              </p>
              <button class="btn btn-lg btn-block btn--primary mt-3" data-dismiss="modal">
                <?php echo e(translate('Got_It')); ?>

              </button>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- JS Implementing Plugins -->
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/vendor.min.js"></script>

<!-- JS Front -->
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/theme.min.js"></script>
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/toastr.js"></script>
<?php echo Toastr::message(); ?>


<?php if($errors->any()): ?>
    <script>
        "use strict";
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        toastr.error('<?php echo e(translate($error)); ?>', Error, {
            CloseButton: true,
            ProgressBar: true
        });
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </script>
<?php endif; ?>
<?php if($log_email_succ): ?>
<?php (session()->forget('log_email_succ')); ?>
    <script>
        "use strict";
        $('#successMailModal').modal('show');
    </script>
<?php endif; ?>

<script>
    "use strict";
    // $("#forget-password").hide();
        $("#role-select").change(function() {
            var selectValue = $(this).val();
            if (selectValue == "admin") {
            $("#forget-password").show();
            $("#forget-password1").hide();
            } else if(selectValue == "vendor") {
            $("#forget-password").hide();
            $("#forget-password1").show();
            }
            else {
            $("#forget-password").hide();
            $("#forget-password1").hide();
            }
        });

    $(document).on('ready', function () {
        // INITIALIZATION OF SHOW PASSWORD
        // =======================================================
        $('.js-toggle-password').each(function () {
            new HSTogglePassword(this).init()
        });

        // INITIALIZATION OF FORM VALIDATION
        // =======================================================
        $('.js-validate').each(function () {
            $.HSCore.components.HSValidation.init($(this));
        });
    });


$(document).on('click','.reloadCaptcha', function(){
    $.ajax({
        url: "<?php echo e(route('reload-captcha')); ?>",
        type: "GET",
        dataType: 'json',
        beforeSend: function () {
            $('#loading').show()
            $('.capcha-spin').addClass('active')
        },
        success: function(data) {
            $('#reload-captcha').html(data.view);
        },
        complete: function () {
            $('#loading').hide()
            $('.capcha-spin').removeClass('active')
        }
    });
});


    $(document).ready(function() {
        $('.onerror-image').on('error', function() {
            let img = $(this).data('onerror-image')
            $(this).attr('src', img);
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
                if( $('#set_default_captcha_value').val() == 1){
                    $('#form-id').submit();
                    return true;
                }
                e.preventDefault();
                if (typeof grecaptcha === 'undefined') {
                    toastr.error('Invalid recaptcha key provided. Please check the recaptcha configuration.');
                    $('#reload-captcha').removeClass('d-none');
                    $('#set_default_captcha_value').val('1');

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
                    $('#reload-captcha').removeClass('d-none');
                    $('#set_default_captcha_value').val('1');
                    toastr.error(errorMessage)
                    return true;
                };
            });
        });
    </script>
<?php endif; ?>




<?php if(env('APP_MODE')=='demo'): ?>
    <script>
        "use strict";
        $('.copy_cred').on('click', function () {
            $('#signinSrEmail').val('admin@admin.com');
            $('#signupSrPassword').val('12345678');
            toastr.success('Copied successfully!', 'Success!', {
                CloseButton: true,
                ProgressBar: true
            });
        })
        $('.copy_cred2').on('click', function () {
            $('#signinSrEmail').val('test.restaurant@gmail.com');
            $('#signupSrPassword').val('12345678');
            toastr.success('Copied successfully!', 'Success!', {
                CloseButton: true,
                ProgressBar: true
            });
        })
    </script>
<?php endif; ?>

<!-- IE Support -->
<script>
    if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) document.write('<script src="<?php echo e(asset('public//assets/admin')); ?>/vendor/babel-polyfill/polyfill.min.js"><\/script>');
</script>
</body>
</html>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/auth/login.blade.php ENDPATH**/ ?>