<?php $__env->startSection('title',translate('messages.profile_settings')); ?>

<?php $__env->startPush('css_or_js'); ?>
<link href="<?php echo e(asset('public/assets/back-end/css/croppie.css')); ?>" rel="stylesheet">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><?php echo e(translate('messages.Settings')); ?></h1>
                </div>

                <div class="col-sm-auto">
                    <a class="btn btn-primary" href="<?php echo e(route('seller.dashboard')); ?>">
                        <i class="tio-home mr-1"></i> <?php echo e(translate('messages.Dashboard')); ?>

                    </a>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->

        <div class="row">
            <div class="col-lg-3">
                <!-- Navbar -->
                <div class="navbar-vertical navbar-expand-lg mb-3 mb-lg-5">
                    <!-- Navbar Toggle -->
                    <button type="button" class="navbar-toggler btn btn-block btn-white mb-3"
                            aria-label="Toggle navigation" aria-expanded="false" aria-controls="navbarVerticalNavMenu"
                            data-toggle="collapse" data-target="#navbarVerticalNavMenu">
                <span class="d-flex justify-content-between align-items-center">
                  <span class="h5 mb-0"> <?php echo e(translate('messages.Nav_menu')); ?> </span>

                  <span class="navbar-toggle-default">
                    <i class="tio-menu-hamburger"></i>
                  </span>

                  <span class="navbar-toggle-toggled">
                    <i class="tio-clear"></i>
                  </span>
                </span>
                    </button>
                    <!-- End Navbar Toggle -->

                    <div id="navbarVerticalNavMenu" class="collapse navbar-collapse">
                        <!-- Navbar Nav -->
                        <ul id="navbarSettings"
                            class="js-sticky-block js-scrollspy navbar-nav navbar-nav-lg nav-tabs card card-navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" href="javascript:" id="generalSection">
                                    <i class="tio-user-outlined nav-icon"></i><?php echo e(translate('messages.Basic_information')); ?>

                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:" id="passwordSection">
                                    <i class="tio-lock-outlined nav-icon"></i> <?php echo e(translate('messages.Password')); ?>

                                </a>
                            </li>
                        </ul>
                        <!-- End Navbar Nav -->
                    </div>
                </div>
                <!-- End Navbar -->
            </div>

            <div class="col-lg-9">
                <form action="<?php echo e(route('seller.profile.update')); ?>" method="post" enctype="multipart/form-data" id="seller-profile-form">
                <?php echo csrf_field(); ?>
                <!-- Card -->
                    <div class="card mb-3 mb-lg-5" id="generalDiv">
                        <!-- Profile Cover -->
                        <div class="profile-cover">
                            <div class="profile-cover-img-wrapper"></div>
                        </div>
                        <!-- End Profile Cover -->

                        <!-- Avatar -->
                        <label
                            class="avatar avatar-xxl avatar-circle avatar-border-lg avatar-uploader profile-cover-avatar"
                            for="avatarUploader">
                            <img id="viewer"
                                 data-onerror-image="<?php echo e(asset('public/assets/back-end/img/160x160/img1.jpg')); ?>"
                                 class="avatar-img onerror-image"
                                 src="<?php echo e($data->image_full_url); ?>"
                                 alt="Image">
                        </label>
                        <!-- End Avatar -->
                    </div>
                    <!-- End Card -->

                    <!-- Card -->
                    <div class="card mb-3 mb-lg-5">
                        <div class="card-header">
                            <h2 class="card-title h4"><?php echo e(translate('messages.Basic_information')); ?></h2>
                        </div>

                        <!-- Body -->
                        <div class="card-body">
                            <!-- Form -->
                            <!-- Form Group -->
                            <div class="row form-group">
                                <label for="firstNameLabel" class="col-sm-3 col-form-label input-label"><?php echo e(translate('messages.Full_name')); ?>  <i
                                        class="tio-help-outlined text-body ml-1" data-toggle="tooltip"
                                        data-placement="top"
                                        title="<?php echo e(translate('Display_name')); ?>"></i></label>

                                <div class="col-sm-9 row">
                                    <div class="col-md-6">
                                        <label for="name">First <?php echo e(translate('messages.Name')); ?>  <span class="text-danger">*</span></label>
                                        <input type="text" name="f_name" value="<?php echo e($data->f_name); ?>" class="form-control" id="name"
                                               required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="name"><?php echo e(translate('messages.Last_Name')); ?>  <span class="text-danger">*</span></label>
                                        <input type="text" name="l_name" value="<?php echo e($data->l_name); ?>" class="form-control" id="name"
                                               required>
                                    </div>
                                </div>
                            </div>
                            <!-- End Form Group -->

                            <!-- Form Group -->
                            <div class="row form-group">
                                <label for="phoneLabel" class="col-sm-3 col-form-label input-label"><?php echo e(translate('messages.Phone')); ?> <span
                                        class="input-label-secondary">(<?php echo e(translate('Optional')); ?>)</span></label>

                                <div class="col-sm-9">
                                    <input type="tel" class="js-masked-input form-control" name="phone" id="phoneLabel"
                                           placeholder="+x(xxx)xxx-xx-xx" aria-label="+(xxx)xx-xxx-xxxxx"
                                           value="<?php echo e($data->phone); ?>"
                                           data-hs-mask-options='{
                                           "template": "+(880)00-000-00000"
                                         }'>
                                </div>
                            </div>
                            <!-- End Form Group -->

                            <div class="row form-group">
                                <label for="newEmailLabel" class="col-sm-3 col-form-label input-label"><?php echo e(translate('messages.Email')); ?></label>

                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="email" id="newEmailLabel"
                                           value="<?php echo e($data->email); ?>"
                                           placeholder="<?php echo e(translate('messages.enter_new_email_address')); ?>" aria-label="<?php echo e(translate('messages.enter_new_email_address')); ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 col-form-label">
                                </div>
                                <div class="form-group col-md-9" id="select-img">
                                    <div class="custom-file">
                                        <input type="file" name="image" id="customFileUpload" class="custom-file-input"
                                            accept=".webp, .jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                        <label class="custom-file-label" for="customFileUpload"><?php echo e(translate('messages.image_Upload')); ?></label>
                                    </div>
                                </div>
                                </div>

                            <div class="d-flex justify-content-end">
                                <button type="button" data-id="seller-profile-form" data-message="<?php echo e(translate('Want to update seller info')); ?>" class="btn btn-primary <?php echo e(env('APP_MODE')!='demo'?'form-alert':'call-demo'); ?>"><?php echo e(translate('messages.Save_changes')); ?></button>
                            </div>

                            <!-- End Form -->
                        </div>
                        <!-- End Body -->
                    </div>
                    <!-- End Card -->
                </form>

                <!-- Card -->
                <div id="passwordDiv" class="card mb-3 mb-lg-5">
                    <div class="card-header">
                        <h4 class="card-title"><?php echo e(translate('messages.Change_your_password')); ?></h4>
                    </div>

                    <!-- Body -->
                    <div class="card-body">
                        <!-- Form -->
                        <form id="changePasswordForm" action="<?php echo e(route('seller.profile.settings-password')); ?>" method="post"
                              enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <!-- Form Group -->
                            <div class="row form-group">
                                <label for="newPassword" class="col-sm-3 col-form-label input-label"> <?php echo e(translate('messages.New_password')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right"
        data-original-title="<?php echo e(translate('messages.Must_contain_at_least_one_number_and_one_uppercase_and_lowercase_letter_and_symbol,_and_at_least_8_or_more_characters')); ?>"><img src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>" alt="<?php echo e(translate('messages.Must_contain_at_least_one_number_and_one_uppercase_and_lowercase_letter_and_symbol,_and_at_least_8_or_more_characters')); ?>"></span></label>

                                <div class="col-sm-9">
                                    <input type="password" class="js-pwstrength form-control" name="password"
                                           id="newPassword" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="<?php echo e(translate('messages.Must_contain_at_least_one_number_and_one_uppercase_and_lowercase_letter_and_symbol,_and_at_least_8_or_more_characters')); ?>"
                                           placeholder="<?php echo e(translate('messages.password_length_placeholder', ['length' => '8+'])); ?>"
                                           aria-label="8+ characters required"
                                           data-hs-pwstrength-options='{
                                           "ui": {
                                             "container": "#changePasswordForm",
                                             "viewports": {
                                               "progress": "#passwordStrengthProgress",
                                               "verdict": "#passwordStrengthVerdict"
                                             }
                                           }
                                         }'>

                                    <p id="passwordStrengthVerdict" class="form-text mb-2"></p>

                                    <div id="passwordStrengthProgress"></div>
                                </div>
                            </div>
                            <!-- End Form Group -->

                            <!-- Form Group -->
                            <div class="row form-group">
                                <label for="confirmNewPasswordLabel" class="col-sm-3 col-form-label input-label"> <?php echo e(translate('messages.Confirm_password')); ?> </label>

                                <div class="col-sm-9">
                                    <div class="mb-3">
                                        <input type="password" class="form-control" name="confirm_password"
                                               id="confirmNewPasswordLabel" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="<?php echo e(translate('messages.Must_contain_at_least_one_number_and_one_uppercase_and_lowercase_letter_and_symbol,_and_at_least_8_or_more_characters')); ?>"
                                               placeholder="<?php echo e(translate('messages.password_length_placeholder', ['length' => '8+'])); ?>"
                                               aria-label="8+ characters required">
                                    </div>
                                </div>
                            </div>
                            <!-- End Form Group -->

                            <div class="d-flex justify-content-end">
                                <button type="button" data-id="changePasswordForm" data-message="<?php echo e(translate('messages.want_to_update_password')); ?>" class="btn btn-primary <?php echo e(env('APP_MODE')!='demo'?'form-alert':'call-demo'); ?>"><?php echo e(translate('messages.Save_changes')); ?></button>
                            </div>
                        </form>
                        <!-- End Form -->
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
        </div>
        <!-- End Row -->
    </div>
    <!-- End Content -->
       <!--modal-->

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/vendor/profile-edit.js"></script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/profile/edit.blade.php ENDPATH**/ ?>