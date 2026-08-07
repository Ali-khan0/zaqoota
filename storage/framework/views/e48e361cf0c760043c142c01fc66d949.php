<?php $__env->startSection('title', translate('messages.Storage_Connection')); ?>


<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/captcha.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.storage_connection_credentials_setup')); ?>

                </span>
            </h1>
            <?php echo $__env->make('admin-views.business-settings.partials.third-party-links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
        <!-- End Page Header -->
        <div class="card border-0">
            <div class="card-header card-header-shadow">
                <h5 class="card-title align-items-center">
                    <?php echo e(translate('Storage_Connection_Settings')); ?>

                </h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <?php ($config=\App\CentralLogics\Helpers::get_business_settings('local_storage')??1); ?>
                        <form action="<?php echo e(route('admin.business-settings.third-party.storage_connection_update',['local_storage'])); ?>"
                              method="post" id="local_storage_status_form">
                            <?php echo csrf_field(); ?>
                            <label class="toggle-switch h--45px toggle-switch-sm d-flex justify-content-between border rounded px-3 py-0 form-control">
                                <span class="pr-1 d-flex align-items-center switch--label">
                                    <span class="line--limit-1">
                                        <?php echo e(translate('Local Storage')); ?>

                                    </span>
                                    <span class="form-label-secondary text-danger d-flex" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('If_enabled_System_will_store_all_files_and_images_to_local_storage')); ?>"><img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="Veg/non-veg toggle"> * </span>
                                </span>
                                <input type="hidden" name="toggle_type" value="local_storage">
                                <input
                                    type="checkbox" id="local_storage_status"
                                    data-id="local_storage_status"
                                    data-type="status"
                                    data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/local_storage.png')); ?>"
                                    data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/local_storage.png')); ?>"
                                    data-title-on="<?php echo e(translate('By Turning ON Local Storage Option')); ?>"
                                    data-title-off="<?php echo e(translate('By Turning OFF Local Storage Option')); ?>"
                                    data-text-on="<p><?php echo e(translate('System_will_store_all_files_and_images_to_local_storage')); ?></p>"
                                    data-text-off="<p><?php echo e(translate('System_will_not_store_all_files_and_images_to_local_storage')); ?></p>"
                                    class="status toggle-switch-input dynamic-checkbox"
                                    name="status" value="1" <?php echo e($config?($config==1?'checked':''):''); ?>>
                                <span class="toggle-switch-label text">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <?php ($config=\App\CentralLogics\Helpers::get_business_settings('3rd_party_storage')); ?>
                        <form action="<?php echo e(route('admin.business-settings.third-party.storage_connection_update',['3rd_party_storage'])); ?>"
                              method="post" id="3rd_party_storage_status_form">
                            <?php echo csrf_field(); ?>
                            <label class="toggle-switch h--45px toggle-switch-sm d-flex justify-content-between border rounded px-3 py-0 form-control">
                                <span class="pr-1 d-flex align-items-center switch--label">
                                    <span class="line--limit-1">
                                        <?php echo e(translate('3rd Party Storage')); ?>

                                    </span>
                                    <span class="form-label-secondary text-danger d-flex" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('If_enabled_System_will_store_all_files_and_images_to_3rd_party_storage')); ?>"><img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="Veg/non-veg toggle"> * </span>
                                </span>
                                <input type="hidden" name="toggle_type" value="3rd_party_storage">
                                <input
                                    type="checkbox" id="3rd_party_storage_status"
                                    data-id="3rd_party_storage_status"
                                    data-type="status"
                                    data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/3rd_party_storage.png')); ?>"
                                    data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/3rd_party_storage.png')); ?>"
                                    data-title-on="<?php echo e(translate('By Turning ON 3rd Party Storage Option')); ?>"
                                    data-title-off="<?php echo e(translate('By Turning OFF 3rd Party Storage Option')); ?>"
                                    data-text-on="<p><?php echo e(translate('System_will_store_all_files_and_images_to_3rd_party_storage')); ?></p>"
                                    data-text-off="<p><?php echo e(translate('System_will_not_store_all_files_and_images_to_3rd_party_storage')); ?></p>"
                                    class="status toggle-switch-input dynamic-checkbox"
                                    name="status" value="1" <?php echo e($config?($config==1?'checked':''):''); ?>>
                                <span class="toggle-switch-label text">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <?php ($config=\App\CentralLogics\Helpers::get_business_settings('s3_credential')); ?>
        <div class="card mt-3">
            <div class="p-4 card-header-shadow">
                <h4 class="card-title align-items-center">
                    <?php echo e(translate('S3_Credential')); ?>

                </h4>
                <span><?php echo e(translate('The_Access_Key_ID_is_a_publicly_accessible_identifier_used_to_authenticate_requests_to_S3.')); ?> <a target="_blank" href="https://aws.amazon.com/s3/"><?php echo e(translate('Learn_More')); ?></a></span>            </div>
            <div class="card-body">
                <div class="mt-2 px-3">
                    <form
                        action="<?php echo e(env('APP_MODE')!='demo'?route('admin.business-settings.third-party.storage_connection_update',['storage_connection']):'javascript:'); ?>"
                        method="post">
                        <?php echo csrf_field(); ?>
                                <div class="border pt-5 radius-10 row mb-3">
                                    <div class="col-lg-4 col-sm-6 p-10px">
                                        <label for="key" class="form-label"><?php echo e(translate('messages.key')); ?></label>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                        <div class="form-group">
                                            <input required id="key" type="text" class="form-control mb-2" name="key"
                                                   value="<?php echo e(env('APP_MODE')!='demo'?$config['key']??"":''); ?>">

                                        </div>
                                    </div>
                                </div>
                                <div class="border pt-5 radius-10 row mb-3">
                                    <div class="col-lg-4 col-sm-6 p-10px">
                                        <label for="secret" class="form-label"><?php echo e(translate('messages.secret')); ?></label>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                        <div class="form-group">
                                            <input required id="secret" type="text" class="form-control mb-2" name="secret"
                                                   value="<?php echo e(env('APP_MODE')!='demo'?$config['secret']??"":''); ?>">

                                        </div>
                                    </div>
                                </div>
                                <div class="border pt-5 radius-10 row mb-3">
                                    <div class="col-lg-4 col-sm-6 p-10px">
                                        <label for="region" class="form-label"><?php echo e(translate('messages.region')); ?></label>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                        <div class="form-group">
                                            <input required id="region" type="text" class="form-control mb-2" name="region"
                                                   value="<?php echo e(env('APP_MODE')!='demo'?$config['region']??"":''); ?>">

                                        </div>
                                    </div>
                                </div>
                                <div class="border pt-5 radius-10 row mb-3">
                                    <div class="col-lg-4 col-sm-6 p-10px">
                                        <label for="bucket" class="form-label"><?php echo e(translate('messages.bucket')); ?></label>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                        <div class="form-group">
                                            <input required id="bucket" type="text" class="form-control mb-2" name="bucket"
                                                   value="<?php echo e(env('APP_MODE')!='demo'?$config['bucket']??"":''); ?>">

                                        </div>
                                    </div>
                                </div>
                                <div class="border pt-5 radius-10 row mb-3">
                                    <div class="col-lg-4 col-sm-6 p-10px">
                                        <label for="url" class="form-label"><?php echo e(translate('messages.url')); ?></label>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                        <div class="form-group">
                                            <input required id="url" type="text" class="form-control mb-2" name="url"
                                                   value="<?php echo e(env('APP_MODE')!='demo'?$config['url']??"":''); ?>">

                                        </div>
                                    </div>
                                </div>
                                <div class="border pt-5 radius-10 row mb-3">
                                    <div class="col-lg-4 col-sm-6 p-10px">
                                        <label for="end_point" class="form-label"><?php echo e(translate('messages.end_point')); ?></label>
                                    </div>
                                    <div class="col-lg-8 col-sm-6">
                                        <div class="form-group">
                                            <input required id="end_point" type="text" class="form-control mb-2" name="end_point"
                                                   value="<?php echo e(env('APP_MODE')!='demo'?$config['end_point']??"":''); ?>">

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
    </div>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/storage-connection-index.blade.php ENDPATH**/ ?>