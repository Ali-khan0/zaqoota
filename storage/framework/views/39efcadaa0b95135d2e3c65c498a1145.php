<?php $__env->startSection('title', translate('messages.third_party_apis')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/api.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.third_party_apis')); ?>

                </span>
            </h1>
            <?php echo $__env->make('admin-views.business-settings.partials.third-party-links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
        <!-- End Page Header -->
        <div class="card">
        <?php ($map_api_key=\App\Models\BusinessSetting::where(['key'=>'map_api_key'])->first()); ?>
        <?php ($map_api_key=$map_api_key?$map_api_key->value:null); ?>

        <?php ($map_api_key_server=\App\Models\BusinessSetting::where(['key'=>'map_api_key_server'])->first()); ?>
        <?php ($map_api_key_server=$map_api_key_server?$map_api_key_server->value:null); ?>
            <div class="card-header card-header-shadow border-0 align-items-center">
                <h5 class="card-title align-items-center text--title">
                    <?php echo e(translate('Google Map API Setup')); ?>

                </h5>
                <div class="blinkings active lg-top">
                    <i class="tio-info-outined"></i>
                    <div class="business-notes">
                        <h6><img src="<?php echo e(asset('/public/assets/admin/img/notes.png')); ?>" alt=""> <?php echo e(translate('Note')); ?></h6>
                        <div>
                            <?php echo e(translate('Without configuring this section map functionality will not work properly. Thus the whole
                                 system will not work as it planned')); ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert--primary d-flex" role="alert">
                    <div class="alert--icon">
                        <i class="tio-info"></i>
                    </div>
                    <div>
                        <?php echo e(translate('messages.map_api_hint_map_api_hint_2')); ?>

                    </div>
                </div>
                <div class="py-1"></div>
                <form action="<?php echo e(env('APP_MODE')!='demo'?route('admin.business-settings.third-party.config-update'):'javascript:'); ?>" method="post"
                      enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row gy-3">
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <label for="map_api_key" class="input-label"><?php echo e(translate('messages.map_api_key')); ?> (<?php echo e(translate('messages.client')); ?>)</label>
                                <input id="map_api_key" type="text" placeholder="<?php echo e(translate('messages.map_api_key')); ?> (<?php echo e(translate('messages.client')); ?>)" class="form-control" name="map_api_key"
                                    value="<?php echo e(env('APP_MODE')!='demo'?$map_api_key??'':''); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <label for="map_api_key_server" class="input-label"><?php echo e(translate('messages.map_api_key')); ?> (<?php echo e(translate('messages.server')); ?>)</label>
                                <input id="map_api_key_server" type="text" placeholder="<?php echo e(translate('messages.map_api_key')); ?> (<?php echo e(translate('messages.server')); ?>)" class="form-control" name="map_api_key_server"
                                    value="<?php echo e(env('APP_MODE')!='demo'?$map_api_key_server??'':''); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="btn--container justify-content-end">
                                <button type="reset" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                                <button type="<?php echo e(env('APP_MODE')!='demo'?'submit':'button'); ?>"  class="btn btn--primary call-demo"><?php echo e(translate('messages.save')); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/config.blade.php ENDPATH**/ ?>