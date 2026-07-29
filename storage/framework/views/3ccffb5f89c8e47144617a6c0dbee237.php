

<?php $__env->startSection('title', translate('Account Deletion Request')); ?>

<?php $__env->startSection('content'); ?>
    <!-- ==== Account Deletion Request Section ==== -->
    <section class="about-section py-5 position-relative">
        <div class="container contact-container">
            <div class="section-header">
                <h2 class="title mb-2"><?php echo e(translate('Account Deletion Request')); ?></h2>
                <div class="text"><?php echo e(translate('Please enter your email address to submit a request for account deletion. Our admin team will review your request.')); ?></div>
            </div>
            <div class="row gy-5 mt-0">
                <div class="col-lg-8 mx-auto">
                    <form class="contact-form-wrapper" method="post" action="<?php echo e(route('submit-account-deletion-request')); ?>" id="form-id">
                        <?php echo csrf_field(); ?>
                        <div class="row g-4">
                            <div class="col-sm-12">
                                <input type="email" required name="email" placeholder="<?php echo e(translate('Your Email Address')); ?>" class="form-control form--control" value="<?php echo e(old('email')); ?>">
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger mt-1"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-sm-12">
                                <textarea name="reason" class="form-control form--control" placeholder="<?php echo e(translate('Reason for account deletion (Optional)')); ?>" rows="5"><?php echo e(old('reason')); ?></textarea>
                                <?php $__errorArgs = ['reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger mt-1"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <?php ($recaptcha = \App\CentralLogics\Helpers::get_business_settings('recaptcha')); ?>
                            <?php if(isset($recaptcha) && $recaptcha['status'] == 1): ?>
                                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                            <?php else: ?>
                                <div class="m-auto p-3 row" id="reload-captcha">
                                    <div class="col-6 pr-0">
                                        <input type="text" class="form-control form-control-lg" name="custome_recaptcha"
                                               id="custome_recaptcha" required placeholder="<?php echo e(translate('Enter recaptcha value')); ?>" autocomplete="off" value="<?php echo e(env('APP_MODE')=='dev'? session('six_captcha'):''); ?>">
                                    </div>
                                    <div class="col-6 bg-white rounded d-flex w-auto">
                                        <img src="<?php echo $custome_recaptcha->inline(); ?>" class="rounded w-100" />
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="col-sm-12 text-center">
                                <button class="cmn--btn border-0" type="submit" id="signInBtn"><?php echo e(translate("Submit Request")); ?> </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- ==== Account Deletion Request Section ==== -->
<?php $__env->stopSection(); ?>

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
                        $('#g-recaptcha-response').val(token);
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

<?php echo $__env->make('layouts.landing.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/account-deletion-request.blade.php ENDPATH**/ ?>