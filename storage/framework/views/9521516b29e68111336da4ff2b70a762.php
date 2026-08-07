<?php $__env->startSection('title', translate('mail_config')); ?>

<?php $__env->startPush('css_or_js'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/email.png')); ?>" class="w--26" alt="">
                </span>
                <span><?php echo e(translate('messages.smtp_mail_setup')); ?>

                </span>
            </h1>
            <?php echo $__env->make('admin-views.business-settings.partials.third-party-links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
        <!-- End Page Header -->

        <div class="card min-h-60vh">
            <div class="card-header card-header-shadow pb-0">
                <div class="d-flex flex-wrap justify-content-between w-100 row-gap-1">
                    <ul class="nav nav-tabs nav--tabs border-0 gap-2">
                        <li class="nav-item mr-2 mr-md-4">
                            <a href="<?php echo e(route('admin.business-settings.third-party.mail-config')); ?>" class="nav-link pb-2 px-0 pb-sm-3">
                                <img src="<?php echo e(asset('/public/assets/admin/img/mail-config.png')); ?>" alt="">
                                <span><?php echo e(translate('Mail Config')); ?></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('admin.business-settings.third-party.test')); ?>" class="nav-link pb-2 px-0 pb-sm-3 active">
                                <img src="<?php echo e(asset('/public/assets/admin/img/test-mail.png')); ?>" alt="">
                                <span><?php echo e(translate('Send Test Mail')); ?></span>
                            </a>
                        </li>
                    </ul>
                    <div class="py-1">
                        <div class="text--primary-2 d-flex flex-wrap align-items-center" type="button" data-toggle="modal" data-target="#works-modal">
                            <strong class="mr-2"><?php echo e(translate('How it Works')); ?></strong>
                            <div class="blinkings">
                                <i class="tio-info-outined"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="test-mail">
                        <div class="row">
                            <div class="col-lg-8">
                                <form class="" action="javascript:">
                                    <label class="form-label"><?php echo e(translate('Email')); ?></label>
                                    <div class="row gx-3 gy-1">
                                        <div class="col-md-8 col-sm-7">
                                            <div>
                                                <label for="test-email" class="sr-only">
                                                    <?php echo e(translate('mail')); ?></label>
                                                <input type="email" id="test-email" class="form-control"
                                                    placeholder="<?php echo e(translate('messages.Ex:')); ?> jhon@email.com">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-5">
                                            <button type="button"  class="btn btn--primary h--45px btn-block send-mail" data-toggle="modal" data-target="#sent-mail-modal">
                                                <i class="tio-telegram"></i>
                                                <?php echo e(translate('send_mail')); ?>

                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- How it Works Modal -->
    <div class="modal fade" id="works-modal">
        <div class="modal-dialog status-warning-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" class="tio-clear"></span>
                    </button>
                </div>
                <div class="modal-body pb-5 pt-0">
                    <div class="single-item-slider owl-carousel">
                        <div class="item">
                            <div class="mb-20">
                                <div class="text-center">
                                    <img src="<?php echo e(asset('/public/assets/admin/img/mail-config/slide-1.png')); ?>" alt="" class="mb-20">
                                    <h5 class="modal-title"><?php echo e(translate('Find SMTP Server Details')); ?></h5>
                                </div>
                                <ul>
                                    <li>
                                        <?php echo e(translate('Contact your email service provider or IT administrator to obtain the SMTP server details, such as hostname, port, username, and password.')); ?>

                                    </li>
                                    <li>
                                        <?php echo e(translate("Note: If you're not sure where to find these details, check the email provider's documentation or support resources for guidance.")); ?>

                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="item">
                            <div class="mb-20">
                                <div class="text-center">
                                    <img src="<?php echo e(asset('/public/assets/admin/img/mail-config/slide-2.png')); ?>" alt="" class="mb-20">
                                    <h5 class="modal-title"><?php echo e(translate('Configure SMTP Settings')); ?></h5>
                                </div>
                                <ul>
                                    <li>
                                        <?php echo e(translate('Go to the SMTP mail setup page in the admin panel.')); ?>

                                    </li>
                                    <li>
                                        <?php echo e(translate('Enter the obtained SMTP server details, including the hostname, port, username, and password.')); ?>

                                    </li>
                                    <li>
                                        <?php echo e(translate('Choose the appropriate encryption method (e.g., SSL, TLS) if required. Save the settings.')); ?>

                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="item">
                            <div class="mb-20">
                                <div class="text-center">
                                    <img src="<?php echo e(asset('/public/assets/admin/img/mail-config/slide-3.png')); ?>" alt="" class="mb-20">
                                    <h5 class="modal-title"><?php echo e(translate('Test SMTP Connection')); ?></h5>
                                </div>
                                <ul>
                                    <li>
                                        <?php echo e(translate('Click on the "Send Test Mail" button to verify the SMTP connection.')); ?>

                                    </li>
                                    <li>
                                        <?php echo e(translate('If successful, you will see a confirmation message indicating that the connection is working fine.')); ?>

                                    </li>
                                    <li>
                                        <?php echo e(translate('If not, double-check your SMTP settings and try again.')); ?>

                                    </li>
                                    <li>
                                        <?php echo e(translate("Note: If you're unsure about the SMTP settings, contact your email service provider or IT administrator for assistance.")); ?>

                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="item">
                            <div class="mw-353px mb-20 mx-auto">
                                <div class="text-center">
                                    <img src="<?php echo e(asset('/public/assets/admin/img/mail-config/slide-4.png')); ?>" alt="" class="mb-20">
                                    <h5 class="modal-title"><?php echo e(translate('Enable Mail Configuration')); ?></h5>
                                </div>
                                <ul class="px-3">
                                    <li>
                                        <?php echo e(translate('If the SMTP connection test is successful, you can now enable the mail configuration services by toggling the switch to "ON."')); ?>

                                    </li>
                                    <li>
                                        <?php echo e(translate('This will allow the system to send emails using the configured SMTP settings.')); ?>

                                    </li>
                                </ul>
                                <div class="btn-wrap">
                                    <button type="submit" class="btn btn--primary w-100" data-dismiss="modal"><?php echo e(translate('Got It')); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="slide-counter"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script_2'); ?>
    <script>
        "use strict";
        function ValidateEmail(inputText) {
            let mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            return !!inputText.match(mailformat);
        }

        $(document).on('click', '.send-mail', function () {
            <?php if(env('APP_MODE') =='demo'): ?>
            toastr.info('<?php echo e(translate('Update option is disabled for demo!')); ?>', {
                CloseButton: true,
                ProgressBar: true
            });
            <?php else: ?>

            if (ValidateEmail($('#test-email').val())) {
                Swal.fire({
                    title: '<?php echo e(translate('Are you sure?')); ?>?',
                    text: "<?php echo e(translate('a_test_mail_will_be_sent_to_your_email')); ?>!",
                    showCancelButton: true,
                    confirmButtonColor: '#00868F',
                    cancelButtonColor: 'secondary',
                    confirmButtonText: '<?php echo e(translate('Yes')); ?>!'
                }).then((result) => {
                    if (result.value) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "<?php echo e(route('admin.business-settings.third-party.mail.send')); ?>",
                            method: 'GET',
                            data: {
                                "email": $('#test-email').val()
                            },
                            beforeSend: function() {
                                $('#loading').show();
                            },
                            success: function(data) {
                                if (data.success === 2) {
                                    toastr.error(
                                        '<?php echo e(translate('email_configuration_error')); ?> !!'
                                    );
                                } else if (data.success === 1) {
                                    toastr.success(
                                        '<?php echo e(translate('email_configured_perfectly!')); ?>!'
                                    );
                                } else {
                                    toastr.info(
                                        '<?php echo e(translate('email_status_is_not_active')); ?>!'
                                    );
                                }
                            },
                            complete: function() {
                                $('#loading').hide();

                            }
                        });
                    }
                })
            } else {
                toastr.error('<?php echo e(translate('invalid_email_address')); ?> !!');
            }

            <?php endif; ?>

        });

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/send-mail-index.blade.php ENDPATH**/ ?>