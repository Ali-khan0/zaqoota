<?php $__env->startSection('title',translate('FCM Settings')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/firebase.png')); ?>" class="w--26" alt="">
                </span>
                <span><?php echo e(translate('messages.firebase_push_notification_setup')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <?php
        $mod_type = 'grocery';
        if(request('module_type')){
            $mod_type = request('module_type');
        }
        ?>
        <div class="card">
            <div class="card-header card-header-shadow pb-0">
                <div class="d-flex flex-wrap justify-content-between w-100 row-gap-1">
                    <ul class="nav nav-tabs nav--tabs border-0 gap-2">
                        <li class="nav-item mr-2 mr-md-4">
                            <a href="<?php echo e(route('admin.business-settings.fcm-index')); ?>" class="nav-link pb-2 px-0 pb-sm-3" data-slide="1">
                                <img src="<?php echo e(asset('/public/assets/admin/img/notify.png')); ?>" alt="">
                                <span><?php echo e(translate('Push Notification')); ?></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('admin.business-settings.fcm-config')); ?>" class="nav-link pb-2 px-0 pb-sm-3 active" data-slide="2">
                                <img src="<?php echo e(asset('/public/assets/admin/img/firebase2.png')); ?>" alt="">
                                <span><?php echo e(translate('Firebase Configuration')); ?></span>
                            </a>
                        </li>
                    </ul>
                    <div class="py-1">
                        <div class="tab--content">
                            <div class="item show text--primary-2 d-flex flex-wrap align-items-center" type="button" data-toggle="modal" data-target="#firebase-modal">
                                <strong class="mr-2"><?php echo e(translate('Where to get this information')); ?></strong>
                                <div class="blinkings">
                                    <i class="tio-info-outined"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="firebase">
                        <form action="<?php echo e(env('APP_MODE')!='demo'?route('admin.business-settings.update-fcm'):'javascript:'); ?>" method="post"
                                enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>







                            <?php ($serviceFileContent = \App\CentralLogics\Helpers::get_business_settings('push_notification_service_file_content')); ?>
                            <div class="form-group">
                                <label class="input-label"><?php echo e(translate('service_file_content')); ?>

                                    <i class="tio-info cursor-pointer" data-toggle="tooltip" data-placement="top"
                                       title="<?php echo e(translate('select and copy all the service file content and add here')); ?>">
                                    </i>
                                </label>
                                <textarea name="push_notification_service_file_content" class="form-control" rows="15"
                                          required><?php echo e(env('APP_MODE')!='demo'?($serviceFileContent?json_encode($serviceFileContent):''):''); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label class="input-label" for="apiKey"><?php echo e(translate('messages.api_key')); ?></label>
                                <div class="d-flex">
                                    <input type="text" id="apiKey" value="<?php echo e($fcm_credentials['apiKey']??''); ?>"
                                        name="apiKey" class="form-control" placeholder="<?php echo e(translate('Ex: abcd1234efgh5678ijklmnop90qrstuvwxYZ')); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-sm-6">
                                    <?php ($project_id=\App\Models\BusinessSetting::where('key','fcm_project_id')->first()); ?>
                                    <div class="form-group">
                                        <label class="input-label" for="projectId"><?php echo e(translate('FCM Project ID')); ?></label>
                                        <div class="d-flex">
                                            <input id="projectId" type="text" value="<?php echo e($project_id->value??''); ?>"
                                                name="projectId" class="form-control" placeholder="<?php echo e(translate('Ex: my-awesome-app-12345')); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <div class="form-group">
                                        <label  class="input-label" for="authDomain"><?php echo e(translate('messages.auth_domain')); ?></label>
                                        <div class="d-flex">
                                            <input id="authDomain" type="text" value="<?php echo e($fcm_credentials['authDomain']??''); ?>"
                                                name="authDomain" class="form-control" placeholder="<?php echo e(translate('Ex: my-awesome-app.firebase.com')); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="storageBucket"><?php echo e(translate('messages.storage_bucket')); ?></label>
                                        <div class="d-flex">
                                            <input id="storageBucket" type="text" value="<?php echo e($fcm_credentials['storageBucket']??''); ?>"
                                                name="storageBucket" class="form-control" placeholder="<?php echo e(translate('Ex: my-awesome-app.apps.com')); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="messagingSenderId"><?php echo e(translate('messages.messaging_sender_id')); ?></label>
                                        <div class="d-flex">
                                            <input id="messagingSenderId" type="text" value="<?php echo e($fcm_credentials['messagingSenderId'] ?? ''); ?>"
                                                name="messagingSenderId" class="form-control" placeholder="<?php echo e(translate('Ex: 1234567890')); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="appId"><?php echo e(translate('messages.app_id')); ?></label>
                                        <div class="d-flex">
                                            <input id="appId" type="text" value="<?php echo e($fcm_credentials['appId']??''); ?>"
                                                name="appId" class="form-control" placeholder="<?php echo e(translate('Ex: 9876543210')); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="measurementId"><?php echo e(translate('messages.measurement_id')); ?></label>
                                        <div class="d-flex">
                                            <input id="measurementId" type="text" value="<?php echo e($fcm_credentials['measurementId']??''); ?>"
                                                name="measurementId" class="form-control" placeholder="<?php echo e(translate('Ex: F-12345678')); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="btn--container justify-content-end">
                                <button type="reset" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                                <button type="<?php echo e(env('APP_MODE')!='demo'?'submit':'button'); ?>" class="btn btn--primary call-demo"><?php echo e(translate('messages.submit')); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Firebase Modal -->
        <div class="modal fade" id="firebase-modal">
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
                                        <img src="<?php echo e(asset('/public/assets/admin/img/firebase/slide-1.png')); ?>" alt="" class="mb-20">
                                        <h5 class="modal-title"><?php echo e(translate('Go to Firebase Console')); ?></h5>
                                    </div>
                                    <ul>
                                        <li>
                                            <?php echo e(translate('Open your web browser and go to the Firebase Console')); ?>

                                            <a href="#" class="text--underline">
                                                <?php echo e(translate('(https://console.firebase.google.com/)')); ?>

                                            </a>
                                        </li>
                                        <li>
                                            <?php echo e(translate("Select the project for which you want to configure FCM from the Firebase Console dashboard.")); ?>

                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="item">
                                <div class="mb-20">
                                    <div class="text-center">
                                        <img src="<?php echo e(asset('/public/assets/admin/img/firebase/slide-2.png')); ?>" alt="" class="mb-20">
                                        <h5 class="modal-title"><?php echo e(translate('Navigate to Project Settings')); ?></h5>
                                    </div>
                                    <ul>
                                        <li>
                                            <?php echo e(translate('In the left-hand menu, click on the "Settings" gear icon, and then select "Project settings" from the dropdown.')); ?>

                                        </li>
                                        <li>
                                            <?php echo e(translate('In the Project settings page, click on the "Cloud Messaging" tab from the top menu.')); ?>

                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="item">
                                <div class="mb-20">
                                    <div class="text-center">
                                        <img src="<?php echo e(asset('/public/assets/admin/img/firebase/slide-3.png')); ?>" alt="" class="mb-20">
                                        <h5 class="modal-title"><?php echo e(translate('Obtain All The Information Asked!')); ?></h5>
                                    </div>
                                    <ul>
                                        <li>
                                            <?php echo e(translate('In the Firebase Project settings page, click on the "General" tab from the top menu.')); ?>

                                        </li>
                                        <li>
                                            <?php echo e(translate('Under the "Your apps" section, click on the "Web" app for which you want to configure FCM.')); ?>

                                        </li>
                                        <li>
                                            <?php echo e(translate('Then Obtain API Key, FCM Project ID, Auth Domain, Storage Bucket, Messaging Sender ID.')); ?>

                                        </li>
                                    </ul>
                                    <p>
                                        <?php echo e(translate('Note: Please make sure to use the obtained information securely and in accordance with Firebase and FCM documentation, terms of service, and any applicable laws and regulations.')); ?>

                                    </p>
                                    <div class="btn-wrap">
                                        <button type="submit" class="btn btn--primary w-100" data-dismiss="modal" data-toggle="modal" data-target="#firebase-modal-2"><?php echo e(translate('Got It')); ?></button>
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

    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/fcm-config.blade.php ENDPATH**/ ?>