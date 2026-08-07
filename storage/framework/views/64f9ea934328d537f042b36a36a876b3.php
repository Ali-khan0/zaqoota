<?php $__env->startSection('title', translate('messages.react_site_setup')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-sm-0">
                    <h1 class="page-header-title"><?php echo e(translate('React Site Setup')); ?></h1>
                </div>
            </div>
        </div>
        <?php ($react_setup=\App\Models\BusinessSetting::where(['key'=>'react_setup'])->first()); ?>
        <?php ($react_setup=$react_setup?json_decode($react_setup->value, true):null); ?>

        <!-- End Page Header -->
        <div class="card">

            <div class="card-body">
                <form action="<?php echo e(env('APP_MODE')!='demo'?route('admin.business-settings.react-update'):'javascript:'); ?>" method="post"
                      enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="react_license_code" class="form-label text-capitalize"><?php echo e(translate('React license code')); ?></label>
                                <input id="react_license_code" type="text" placeholder="<?php echo e(translate('React license code')); ?>" class="form-control h--45px" name="react_license_code"
                                    value="<?php echo e(env('APP_MODE')!='demo'?( $react_setup['react_license_code'] ?? ''):''); ?>" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="react_domain" class="form-label text-capitalize"><?php echo e(translate('React Domain')); ?></label>
                                <input id="react_domain" type="text" placeholder="<?php echo e(translate('React Domain')); ?>" class="form-control h--45px" name="react_domain"
                                    value="<?php echo e(env('APP_MODE')!='demo'?( $react_setup['react_domain'] ?? ''):''); ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="<?php echo e(env('APP_MODE')!='demo'?'submit':'button'); ?>"  class="btn btn--primary mb-2 call-demo"><?php echo e(translate('messages.save')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/react-setup.blade.php ENDPATH**/ ?>