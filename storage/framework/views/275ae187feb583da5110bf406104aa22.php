<?php $__env->startSection('title', translate('messages.reCaptcha Setup')); ?>


<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/captcha.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.reCaptcha_credentials_setup')); ?>

                </span>
            </h1>
            <?php echo $__env->make('admin-views.business-settings.partials.third-party-links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
        <!-- End Page Header -->

        <div class="card">
            <div class="card-header">
                <h4 class="m-0">
                    <?php echo e(translate('Google Recaptcha Information')); ?>

                </h4>
                <button type="button" class="btn btn--primary btn-outline-primary btn-sm px-3" data-toggle="modal" data-target="#setup-information">
                    <?php echo e(translate('Credential Setup Information')); ?> <i class="tio-info"></i>
                </button>
            </div>
            <div class="card-body">
                <div class="alert alert-soft-secondary">
                    <div class="d-flex gap-2">
                        <div class="w-0 flex-grow-1">
                            <h4 class="m-0"><?php echo e(translate('V3 Version is available now. Must setup for ReCAPTCHA V3')); ?></h4>
                            <div><?php echo e(translate('You must setup for V3 version. Otherwise the default reCAPTCHA will be displayed automatically')); ?></div>
                        </div>
                        <div>
                            <button type="button" class="btn p-0 text-danger" data-dismiss="alert">
                                <i class="tio-clear"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <?php ($config=\App\CentralLogics\Helpers::get_business_settings('recaptcha')); ?>
                <form action="<?php echo e(env('APP_MODE')!='demo'?route('admin.business-settings.third-party.recaptcha_update',['recaptcha']):'javascript:'); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <label class="toggle-switch h--45px toggle-switch-sm d-flex justify-content-between border rounded px-3 py-0 form-control mb-4">
                        <span class="pr-1 d-flex align-items-center switch--label">
                            <span class="line--limit-1">
                                <?php if(isset($config) && $config['status'] == 1): ?>
                                <?php echo e(translate('ReCAPTCHA Status Turn OFF')); ?>

                                <?php else: ?>
                                <?php echo e(translate('ReCAPTCHA Status Turn ON')); ?>

                                <?php endif; ?>
                            </span>
                        </span>
                        <input type="checkbox"
                                data-id="recaptcha_status"
                                data-type="toggle"
                                data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/important-recapcha.png')); ?>"
                                data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/warning-recapcha.png')); ?>"
                                data-title-on="<?php echo e(translate('Important!')); ?>"
                                data-title-off="<?php echo e(translate('Warning!')); ?>"
                                data-text-on="<p><?php echo e(translate('reCAPTCHA is now enabled for added security. Users may be prompted to complete a reCAPTCHA challenge to verify their human identity and protect against spam and malicious activity.')); ?></p>"
                                data-text-off="<p><?php echo e(translate('Disabling reCAPTCHA may leave your website vulnerable to spam and malicious activity and suspects that a user may be a bot. It is highly recommended to keep reCAPTCHA enabled to ensure the security and integrity of your website.')); ?></p>"
                                class="status toggle-switch-input dynamic-checkbox-toggle"
                                name="status" id="recaptcha_status" value="1" <?php echo e(isset($config) && $config['status'] == 1 ? 'checked':''); ?>>
                        <span class="toggle-switch-label text p-0">
                            <span class="toggle-switch-indicator"></span>
                        </span>
                    </label>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="site_key" class="form-label"><?php echo e(translate('messages.Site Key')); ?></label><br>
                                <input id="site_key" type="text" class="form-control" name="site_key"
                                        value="<?php echo e(env('APP_MODE')!='demo'?$config['site_key']??"":''); ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="site_key" class="form-label"><?php echo e(translate('messages.Secret Key')); ?></label><br>
                                <input id="site_key" type="text" class="form-control" name="secret_key"
                                        value="<?php echo e(env('APP_MODE')!='demo'?$config['secret_key']??"":''); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="btn--container justify-content-end">
                        <button type="reset" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                        <button type="<?php echo e(env('APP_MODE')!='demo'?'submit':'button'); ?>" class="btn btn--primary call-demo"><?php echo e(translate('messages.save')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="setup-information" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <div class="text-center">
                        <img src="<?php echo e(asset('/public/assets/admin/img/icons/wallet.png')); ?>" width="80" alt="">
                    </div>
                    <h4 class="modal-title">Instructions</h4>
                    <ol class="list-gap-5 fs-13 mt-3">
                        <li><?php echo e(translate('messages.Go to the Credentials page')); ?>

                            (<?php echo e(translate('messages.Click')); ?> <a
                                href="https://www.google.com/recaptcha/admin/create"
                                target="_blank"><?php echo e(translate('messages.here')); ?></a>)
                        </li>
                        <li><?php echo e(translate('messages.Add a ')); ?>

                            <b><?php echo e(translate('messages.label')); ?></b> <?php echo e(translate('messages.(Ex: Test Label)')); ?>

                        </li>
                        <li>
                            <?php echo e(translate('messages.Select reCAPTCHA v3 as ')); ?>

                            <b><?php echo e(translate('messages.reCAPTCHA Type')); ?></b>
                            (<?php echo e(translate("Sub type: I'm not a robot Checkbox")); ?>

                            )
                        </li>
                        <li>
                            <?php echo e(translate('messages.Add')); ?>

                            <b><?php echo e(translate('messages.domain')); ?></b>
                            <?php echo e(translate('messages.(For ex: demo.6amtech.com)')); ?>

                        </li>
                        <li>
                            <?php echo e(translate('messages.Check in ')); ?>

                            <b><?php echo e(translate('messages.Accept the reCAPTCHA Terms of Service')); ?></b>
                        </li>
                        <li>
                            <?php echo e(translate('messages.Press')); ?>

                            <b><?php echo e(translate('messages.Submit')); ?></b>
                        </li>
                        <li><?php echo e(translate('messages.Copy')); ?> <b><?php echo e(translate('Site')); ?>

                                <?php echo e(translate('Key')); ?></b> <?php echo e(translate('messages.and')); ?> <b><?php echo e(translate('Secret')); ?>

                                <?php echo e(translate('Key')); ?></b>, <?php echo e(translate('messages.paste in the input filed below and')); ?>

                            <b><?php echo e(translate('Save')); ?></b>.
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/recaptcha-index.blade.php ENDPATH**/ ?>