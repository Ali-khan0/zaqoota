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
            <!-- OTP Card -->
            <div class="otp-card">
                <div class="text-center">
                    <img class="mb-4" src="<?php echo e(asset('/public/assets/admin/img/lock.svg')); ?>" alt="">
                    <div class="mb-2">
                        <?php echo e(translate('a_5_digit_verification_code_has_been')); ?> <br> <?php echo e(translate('sent_to')); ?> <strong><?php echo e(substr($admin->phone, 0, 3) . str_repeat('X', strlen($admin->phone) - 5) . substr($admin->phone, -2)); ?></strong>
                    </div>
                    <div><?php echo e(translate('enter_the_verification_code')); ?></div>
                    <div class="mt-4">
                        <form action="<?php echo e(route('verify-otp')); ?>" method="POST" class="otp-form">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="reset_token" value="<?php echo e($token); ?>">
                            <input type="hidden" name="phone" value="<?php echo e($admin->phone); ?>">
                            <div class="d-flex align-items-end justify-content-center __gap-15px">
                                <input class="otp-field" type="text" name="opt-field[]" maxlength="1" autocomplete="off">
                                <input class="otp-field" type="text" name="opt-field[]" maxlength="1" autocomplete="off">
                                <input class="otp-field" type="text" name="opt-field[]" maxlength="1" autocomplete="off">
                                <input class="otp-field" type="text" name="opt-field[]" maxlength="1" autocomplete="off">
                                <input class="otp-field" type="text" name="opt-field[]" maxlength="1" autocomplete="off">
                            </div>

                            <!-- Store OTP Value -->
                            <input class="otp-value" type="hidden" name="opt-value">
                            <button type="submit" class="btn btn-lg btn-block btn--primary"><?php echo e(translate('Verify')); ?></button>
                        </form>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span><?php echo e(translate('Didn`t receive the code?')); ?></span>
                        <button class="text--primary resend otp_resend" disabled id="otp-button"><?php echo e(translate('Resend_it')); ?>

                        </button>
                    </div>
                </div>
            </div>
            <!-- End Card -->
        </div>
    </div>
</main>
<!-- ========== END MAIN CONTENT ========== -->

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
        toastr.error('<?php echo e($error); ?>', Error, {
            CloseButton: true,
            ProgressBar: true
        });
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </script>
<?php endif; ?>

<script>
    "use strict";

    $('.otp_resend').on('click', function () {
        $.ajax({
            url: "<?php echo e(route('otp_resent')); ?>",
            type: "GET",
            dataType: 'json',
            data: {
                        "token": $('#reset_token').val()
                    },
            success: function(data) {

                if (data.errors == 'link_expired') {
                    toastr.error('<?php echo e(translate('Link_expired')); ?>', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
                if (data.otp_fail == 'otp_fail') {
                    toastr.error('<?php echo e(translate('Failed_to_sent_otp')); ?>', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
                if (data.success == 'otp_send') {
                    startCountdown();
                    toastr.success('<?php echo e(translate('Otp_successfull_sent')); ?>', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            }
        });
    })

    $(document).ready(function() {
            $('.onerror-image').on('error', function() {
                let img = $(this).data('onerror-image')
                $(this).attr('src', img);
            });
        });

</script>

<!-- IE Support -->
<script>
    if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) document.write('<script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/babel-polyfill/polyfill.min.js"><\/script>');
</script>


<script>
    "use strict";
  $(document).ready(function () {
    $(".otp-form *:input[type!=hidden]:first").focus();
    let otp_fields = $(".otp-form .otp-field"),
      otp_value_field = $(".otp-form .otp-value");
    otp_fields
      .on("input", function (e) {
        $(this).val(
          $(this)
            .val()
            .replace(/[^0-9]/g, "")
        );
        let opt_value = "";
        otp_fields.each(function () {
          let field_value = $(this).val();
          if (field_value != "") opt_value += field_value;
        });
        otp_value_field.val(opt_value);
      })
      .on("keyup", function (e) {
        let key = e.keyCode || e.charCode;
        if (key == 8 || key == 46 || key == 37 || key == 40) {
          // Backspace or Delete or Left Arrow or Down Arrow
          $(this).prev().focus();
        } else if (key == 38 || key == 39 || $(this).val() != "") {
          // Right Arrow or Top Arrow or Value not empty
          $(this).next().focus();
        }
      })
      .on("paste", function (e) {
        let paste_data = e.originalEvent.clipboardData.getData("text");
        let paste_data_splitted = paste_data.split("");
        $.each(paste_data_splitted, function (index, value) {
          otp_fields.eq(index).val(value);
        });
      });
  });

  $(document).ready(function() {
  let otpButton = $("#otp-button");
  let countdownTimer;

  function startCountdown() {
    otpButton.prop("disabled", true);
    otpButton.addClass("resend");
    let countdown = 30;
    countdownTimer = setInterval(function() {
      otpButton.text("Resend it (" + countdown + ")");
      countdown--;
      if (countdown < 0) {
        clearInterval(countdownTimer);
        otpButton.prop("disabled", false);
        otpButton.addClass("resend");
        otpButton.text("Resend it");
      }
    }, 1000);
  }

  startCountdown();
});



</script>


</body>
</html>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/auth/verify-otp.blade.php ENDPATH**/ ?>