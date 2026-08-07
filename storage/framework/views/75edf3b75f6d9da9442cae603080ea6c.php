<?php $__env->startSection('title', translate('Social Login Setup')); ?>


<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/captcha.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('Social Login Setup')); ?>

                </span>
            </h1>
            <?php echo $__env->make('admin-views.business-settings.partials.third-party-links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
        <!-- End Page Header -->

        <div class="row g-3">
            <?php if(isset($socialLoginServices)): ?>
            <?php $__currentLoopData = $socialLoginServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $socialLoginService): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6">
                        <form
                        action="<?php echo e(route('admin.social-login.update',[$socialLoginService['login_medium']])); ?>"
                        method="post">
                        <?php echo csrf_field(); ?>
                        <div class="card">
                            <div class="card-header card-header-shadow">
                                <h5 class="card-title align-items-center">
                                    <img src="<?php echo e(asset('/public/assets/admin/img')); ?>/<?php echo e($socialLoginService['login_medium']); ?>.png" class="mr-1 w-20" alt="">
                                    <?php echo e(translate('messages.'.$socialLoginService['login_medium'])); ?>

                                </h5>
                                <label class="toggle-switch toggle-switch-sm p-0">
                                    <span class="d-flex align-items-center switch--label">
                                        <span class="form-label-secondary text-danger d-flex" data-toggle="tooltip" data-placement="right" data-original-title="Lorem ipsum dolor set amet"><img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="Veg/non-veg toggle"> * </span>
                                    </span>
                                    <input id="<?php echo e($socialLoginService['login_medium']); ?>_status"

                                           data-id="<?php echo e($socialLoginService['login_medium']); ?>_status"
                                           data-type="toggle"
                                           data-image-on="<?php echo e(asset('/public/assets/admin/img/modal')); ?>/<?php echo e($socialLoginService['login_medium']); ?>-on.png"
                                           data-image-off="<?php echo e(asset('/public/assets/admin/img/modal')); ?>/<?php echo e($socialLoginService['login_medium']); ?>-off.png"
                                           data-title-on="<?php echo e(translate('messages.'.$socialLoginService['login_medium'])); ?> <?php echo e(translate('Login Turned ON ')); ?>"
                                           data-title-off="<?php echo e(translate('messages.'.$socialLoginService['login_medium'])); ?> <?php echo e(translate('Login Turned OFF ')); ?>"
                                           data-text-on="<p><?php echo e(translate('messages.'.$socialLoginService['login_medium'])); ?> <?php echo e(translate('Login is now enabled. Customers will be able to sign up or log in using their social media accounts.')); ?></p>"
                                           data-text-off="<p><?php echo e(translate('messages.'.$socialLoginService['login_medium'])); ?> <?php echo e(translate('Login is now disabled. Customers will not be able to sign up or log in using their social media accounts. Please note that this may affect user experience and registration/login process.')); ?></p>"
                                           class="status toggle-switch-input dynamic-checkbox-toggle"


                                           type="checkbox" name="status" value="1" <?php echo e($socialLoginService['status']==1?'checked' :''); ?>>
                                    <span class="toggle-switch-label text p-0">
                                        <span class="toggle-switch-indicator"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-end">
                                    <div class="text--primary-2 d-flex flex-wrap align-items-center" type="button" data-toggle="modal" data-target="#<?php echo e($socialLoginService['login_medium']); ?>-modal">
                                        <strong class="mr-2 text--underline"><?php echo e(translate('Credential Setup')); ?></strong>
                                        <div class="blinkings">
                                            <i class="tio-info-outined"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label"><?php echo e(translate('messages.callback_uri')); ?></label>
                                    <div class="position-relative">
                                        <span class="btn-right-fixed copy-to-clipboard" data-id="#id_<?php echo e($socialLoginService['login_medium']); ?>"><i class="tio-copy"></i></span>
                                        <span class="form-control h-unset" id="id_<?php echo e($socialLoginService['login_medium']); ?>"><?php echo e(url('/')); ?>/customer/auth/login/<?php echo e($socialLoginService['login_medium']); ?>/callback</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="client_id" class="form-label"><?php echo e(translate('messages.client_id')); ?></label>
                                    <input id="client_id" type="text" class="form-control" name="client_id" value="<?php echo e($socialLoginService['client_id']); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="client_secret"
                                        class="form-label"><?php echo e(translate('messages.client_secret')); ?></label>
                                    <input id="client_secret" type="text" class="form-control" name="client_secret"
                                            value="<?php echo e($socialLoginService['client_secret']); ?>">
                                </div>
                                <div class="btn--container justify-content-end">
                                    <button type="reset" class="btn btn--reset mb-2"><?php echo e(translate('Reset')); ?></button>
                                    <button type="<?php echo e(env('APP_MODE')!='demo'?'submit':'button'); ?>" class="btn btn--primary mb-2"><?php echo e(translate('messages.save')); ?></button>
                                </div>
                                </div>
                            </div>
                        </form>
                    </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <?php if(isset($appleLoginServices)): ?>
            <?php $__currentLoopData = $appleLoginServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appleLoginService): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6">
                        <div class="card">
                            <form
                            action="<?php echo e(route('admin.apple-login.update',[$appleLoginService['login_medium']])); ?>"
                            method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                                <div class="card-header card-header-shadow">
                                    <h5 class="card-title align-items-center">
                                        <img src="<?php echo e(asset('/public/assets/admin/img/apple.png')); ?>" class="mr-1 w--20" alt="">
                                        <?php echo e(translate('messages.'.$appleLoginService['login_medium'])); ?>

                                    </h5>
                                    <label class="toggle-switch toggle-switch-sm p-0">
                                        <span class="d-flex align-items-center switch--label">
                                            <span class="form-label-secondary text-danger d-flex" data-toggle="tooltip" data-placement="right" data-original-title="Lorem ipsum dolor set amet"><img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="Veg/non-veg toggle"> * </span>
                                        </span>
                                        <input  id="<?php echo e($appleLoginService['login_medium']); ?>_status"
                                               data-id="<?php echo e($appleLoginService['login_medium']); ?>_status"
                                               data-type="toggle"
                                               data-image-on="<?php echo e(asset('/public/assets/admin/img/modal')); ?>/<?php echo e($appleLoginService['login_medium']); ?>-on.png"
                                               data-image-off="<?php echo e(asset('/public/assets/admin/img/modal')); ?>/<?php echo e($appleLoginService['login_medium']); ?>-off.png"
                                               data-title-on="<?php echo e(translate('messages.'.$appleLoginService['login_medium'])); ?> <?php echo e(translate('Login Turned ON ')); ?>"
                                               data-title-off="<?php echo e(translate('messages.'.$appleLoginService['login_medium'])); ?> <?php echo e(translate('Login Turned OFF ')); ?>"
                                               data-text-on="<p><?php echo e(translate('messages.'.$appleLoginService['login_medium'])); ?> <?php echo e(translate('Login is now enabled. Customers will be able to sign up or log in using their social media accounts.')); ?></p>"
                                               data-text-off="<p><?php echo e(translate('messages.'.$appleLoginService['login_medium'])); ?> <?php echo e(translate('Login is now disabled. Customers will not be able to sign up or log in using their social media accounts. Please note that this may affect user experience and registration/login process.')); ?></p>"
                                               class="status toggle-switch-input dynamic-checkbox-toggle"


                                               type="checkbox" name="status" value="1" <?php echo e($appleLoginService['status']==1?'checked' :''); ?>>
                                        <span class="toggle-switch-label text p-0">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                    </label>
                                </div>
                                <div class="card-body text-<?php echo e(Session::get('direction') === "rtl" ? 'right' : 'left'); ?>">
                                    <div class="d-flex justify-content-end">
                                        <div class="text--primary-2 d-flex flex-wrap align-items-center" type="button" data-toggle="modal" data-target="#<?php echo e($appleLoginService['login_medium']); ?>-modal">
                                            <strong class="mr-2 text--underline"><?php echo e(translate('Credential Setup')); ?></strong>
                                            <div class="blinkings">
                                                <i class="tio-info-outined"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="client_id"
                                            class="form-label"><?php echo e(translate('messages.client_id_for_web')); ?></label>
                                        <input id="client_id" type="text" class="form-control" name="client_id"
                                            value="<?php echo e($appleLoginService['client_id']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="client_id_app"
                                            class="form-label"><?php echo e(translate('messages.client_id_for_app')); ?></label>
                                        <input id="client_id_app" type="text" class="form-control" name="client_id_app"
                                            value="<?php echo e($appleLoginService['client_id_app']??''); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="team_id"
                                            class="form-label"><?php echo e(translate('messages.team_id')); ?></label>
                                        <input id="team_id" type="text" class="form-control" name="team_id"
                                            value="<?php echo e($appleLoginService['team_id']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="key_id"
                                            class="form-label"><?php echo e(translate('messages.key_id')); ?></label>
                                        <input id="key_id" type="text" class="form-control" name="key_id"
                                            value="<?php echo e($appleLoginService['key_id']); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="key_id"
                                            class="form-label"><?php echo e(translate('messages.redirect_url_for_flutter_web')); ?></label>
                                        <input id="redirect_url_flutter" type="url" class="form-control" name="redirect_url_flutter"
                                            value="<?php echo e($appleLoginService['redirect_url_flutter']??''); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="key_id"
                                            class="form-label"><?php echo e(translate('messages.redirect_url_for_react_web')); ?></label>
                                        <input id="redirect_url_react" type="url" class="form-control" name="redirect_url_react"
                                            value="<?php echo e($appleLoginService['redirect_url_react']??''); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label
                                            class="form-label"><?php echo e(translate('messages.service_file')); ?> <?php echo e($appleLoginService['service_file']?translate('(Already Exists)'):''); ?></label>
                                        <input type="file" accept=".p8" class="form-control" name="service_file"
                                            value="<?php echo e('storage/app/public/apple-login/'.$appleLoginService['service_file']); ?>">
                                    </div>
                                    <div class="btn--container justify-content-end">
                                        <button type="reset" class="btn btn--reset mb-2"><?php echo e(translate('Reset')); ?></button>
                                        <button type="<?php echo e(env('APP_MODE')!='demo'?'submit':'button'); ?>" class="btn btn--primary mb-2"><?php echo e(translate('messages.save')); ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>

        <!-- Google -->
        <div class="modal fade" id="google-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog status-warning-modal">
                <div class="modal-content <?php echo e(Session::get('direction') === "rtl" ? 'text-right' : 'text-left'); ?>">
                    <div class="modal-header pb-0">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pb-0">
                        <div class="text-center mb-20">
                            <img src="<?php echo e(asset('/public/assets/admin/img/modal/google.png')); ?>" alt="" class="mb-20">
                            <h5 class="modal-title"><?php echo e(translate('messages.google_api_setup_instructions')); ?></h5>
                        </div>
                        <ol>
                            <li><?php echo e(translate('messages.go_to_the_credentials_page')); ?> (<?php echo e(translate('messages.click')); ?> <a href="https://console.cloud.google.com/apis/credentials" target="_blank"><?php echo e(translate('here')); ?></a>)</li>
                            <li><?php echo e(translate('messages.click')); ?> <b><?php echo e(translate('messages.create_credentials')); ?></b> > <b><?php echo e(translate('messages.auth_client_id')); ?></b>.</li>
                            <li><?php echo e(translate('messages.select_the')); ?> <b><?php echo e(translate('messages.web_application')); ?></b> <?php echo e(translate('messages.type')); ?>.</li>
                            <li><?php echo e(translate('messages.name_your_auth_client')); ?></li>
                            <li><?php echo e(translate('messages.click')); ?> <b><?php echo e(translate('messages.add_uri')); ?></b> <?php echo e(translate('messages.from')); ?> <b><?php echo e(translate('messages.authorized_redirect_uris')); ?></b> , <?php echo e(translate('messages.provide_the')); ?> <code><?php echo e(translate('messages.callback_uri')); ?></code> <?php echo e(translate('messages.from_below_and_click')); ?> <b><?php echo e(translate('messages.created')); ?></b></li>
                            <li><?php echo e(translate('messages.copy')); ?> <b><?php echo e(translate('messages.client_id')); ?></b> <?php echo e(translate('messages.and')); ?> <b><?php echo e(translate('messages.client_secret')); ?></b>, <?php echo e(translate('messages.past_in_the_input_field_below_and')); ?> <b>Save</b>.</li>
                        </ol>
                    </div>
                    <div class="modal-footer justify-content-center border-0">
                        <button type="button" class="btn btn--primary w-100 mw-300px" data-dismiss="modal"><?php echo e(translate('Got It')); ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Facebook -->
        <div class="modal fade" id="facebook-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog status-warning-modal">
                <div class="modal-content <?php echo e(Session::get('direction') === "rtl" ? 'text-right' : 'text-left'); ?>">
                    <div class="modal-header pb-0">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pb-0"><b></b>
                        <div class="text-center mb-20">
                            <img src="<?php echo e(asset('/public/assets/admin/img/modal/facebook.png')); ?>" alt="" class="mb-20">
                            <h5 class="modal-title"><?php echo e(translate('messages.facebook_api_set_instruction')); ?></h5>
                        </div>
                        <ol>
                            <li><?php echo e(translate('messages.goto_the_facebook_developer_page')); ?> (<a href="https://developers.facebook.com/apps/" target="_blank"><?php echo e(translate('messages.click_here')); ?></a>)</li>
                            <li><?php echo e(translate('messages.goto')); ?> <b><?php echo e(translate('messages.get_started')); ?></b> <?php echo e(translate('messages.from_navbar')); ?></li>
                            <li><?php echo e(translate('messages.from_register_tab_press')); ?> <b><?php echo e(translate('messages.continue')); ?></b> <small>(<?php echo e(translate('messages.if_needed')); ?>)</small></li>
                            <li><?php echo e(translate('messages.provide_primary_email_and_press')); ?> <b><?php echo e(translate('messages.confirm_email')); ?></b> <small>(<?php echo e(translate('messages.if_needed')); ?>)</small></li>
                            <li><?php echo e(translate('messages.in_about_section_select')); ?> <b><?php echo e(translate('messages.other')); ?></b> <?php echo e(translate('messages.and_press')); ?> <b><?php echo e(translate('messages.complete_registration')); ?></b></li>

                            <li><b><?php echo e(translate('messages.create_app')); ?></b> > <?php echo e(translate('messages.select_an_app_type_and_press')); ?> <b><?php echo e(translate('messages.next')); ?></b></li>
                            <li><?php echo e(translate('messages.complete_the_details_form_and_press')); ?> <b><?php echo e(translate('messages.create_app')); ?></b></li><br/>

                            <li><?php echo e(translate('messages.form')); ?> <b><?php echo e(translate('messages.facebook_login')); ?></b> <?php echo e(translate('messages.press')); ?> <b><?php echo e(translate('messages.set_up')); ?></b></li>
                            <li><?php echo e(translate('messages.select')); ?> <b><?php echo e(translate('messages.web')); ?></b></li>
                            <li><?php echo e(translate('messages.provide')); ?> <b><?php echo e(translate('messages.site_url')); ?></b> <small>(<?php echo e(translate('messages.base_url_of_the_site')); ?>: https://example.com)</small> > <b><?php echo e(translate('messages.save')); ?></b></li><br/>
                            <li><?php echo e(translate('messages.now_go_to')); ?> <b><?php echo e(translate('messages.setting')); ?></b> <?php echo e(translate('messages.form')); ?> <b><?php echo e(translate('messages.facebook_login')); ?></b> (<?php echo e(translate('messages.left_sidebar')); ?>)</li>
                            <li><?php echo e(translate('messages.make_sure_to_check')); ?> <b><?php echo e(translate('messages.client_auth_login')); ?></b> <small>(<?php echo e(translate('messages.must_on')); ?>)</small></li>
                            <li><?php echo e(translate('messages.provide')); ?> <code><?php echo e(translate('messages.valid_auth_redirect_uris')); ?></code> <?php echo e(translate('messages.from_below_and_click')); ?> <b><?php echo e(translate('messages.save_changes')); ?></b></li>

                            <li><?php echo e(translate('messages.now_go_to')); ?> <b><?php echo e(translate('messages.setting')); ?></b> (<?php echo e(translate('messages.from_left_sidebar')); ?>) > <b><?php echo e(translate('messages.basic')); ?></b></li>
                            <li><?php echo e(translate('messages.fill_the_form_and_press')); ?> <b><?php echo e(translate('messages.save_changes')); ?></b></li>
                            <li><?php echo e(translate('messages.now_copy')); ?> <b><?php echo e(translate('messages.client_id')); ?></b> & <b><?php echo e(translate('messages.client_secret')); ?></b>, <?php echo e(translate('messages.past_in_the_input_field_below_and')); ?> <b><?php echo e(translate('messages.save')); ?></b>.</li>
                        </ol>
                    </div>
                    <div class="modal-footer justify-content-center border-0">
                        <button type="button" class="btn btn--primary w-100 mw-300px" data-dismiss="modal"><?php echo e(translate('Got It')); ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Apple -->
        <div class="modal fade" id="apple-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog status-warning-modal">
                <div class="modal-content <?php echo e(Session::get('direction') === "rtl" ? 'text-right' : 'text-left'); ?>">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pb-0"><b></b>
                        <div class="text-center mb-20">
                            <img src="<?php echo e(asset('/public/assets/admin/img/modal/apple.png')); ?>" alt="" class="mb-20">
                            <h5 class="modal-title"><?php echo e(translate('messages.apple_api_set_instruction')); ?></h5>
                        </div>
                        <ol>
                            <li><?php echo e(translate('Go to Apple Developer page')); ?> (<a href="https://developer.apple.com/account/resources/identifiers/list" target="_blank"><?php echo e(translate('messages.click_here')); ?></a>)</li>
                            <li><?php echo e(translate('Here in top left corner you can see the')); ?> <b><?php echo e(translate('Team ID')); ?></b> <?php echo e(translate('[Apple_Developer_Account_Name - Team_ID]')); ?></li>
                            <li><?php echo e(translate('Click Plus icon -> select App IDs -> click on Continue')); ?></li>
                            <li><?php echo e(translate('Put a description and also identifier (identifier that used for app) and this is the')); ?> <b><?php echo e(translate('Client ID')); ?></b> </li>
                            <li><?php echo e(translate('Click Continue and Download the file in device named AuthKey_ID.p8 (Store it safely and it is used for push notification)')); ?> </li>
                            <li><?php echo e(translate('Again click Plus icon -> select Service IDs -> click on Continue')); ?> </li>
                            <li><?php echo e(translate('Push a description and also identifier and Continue')); ?> </li>
                            <li><?php echo e(translate('Download the file in device named')); ?> <b><?php echo e(translate('AuthKey_KeyID.p8')); ?></b> <?php echo e(translate('[This is the Service Key ID file and also after AuthKey_ that is the Key ID]')); ?></li>
                        </ol>
                    </div>
                    <div class="modal-footer justify-content-center border-0">
                        <button type="button" class="btn btn--primary w-100 mw-300px" data-dismiss="modal"><?php echo e(translate('Got It')); ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Twitter -->
        <div class="modal fade" id="twitter-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content <?php echo e(Session::get('direction') === "rtl" ? 'text-right' : 'text-left'); ?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><?php echo e(translate('messages.twitter_api_set_up_instructions')); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body"><b></b>
                        <?php echo e(translate('messages.instruction_will_be_available_very_soon')); ?>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--primary" data-dismiss="modal"><?php echo e(translate('messages.close')); ?></button>
                    </div>
                </div>
            </div>
        </div>
        



<?php $__env->stopSection(); ?>
<?php $__env->startPush('script_2'); ?>
    <script>
        "use strict";
        $(document).on('click', '.copy-to-clipboard', function () {
            let id=  $(this).data('id');
            let $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(id).text()).select();
            document.execCommand("copy");
            $temp.remove();
            toastr.success("<?php echo e(translate('Copied to the clipboard')); ?>");

        });

    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/social-login/view.blade.php ENDPATH**/ ?>