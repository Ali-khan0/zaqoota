<?php $__env->startSection('title', translate('messages.websocket_settings')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title mr-3">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/business.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('business_setup')); ?>

                </span>
            </h1>
            <?php echo $__env->make('admin-views.business-settings.partials.nav-menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
        <!-- Page Header -->

        <!-- End Page Header -->
        <form action="<?php echo e(route('admin.business-settings.update-websocket')); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="row g-2">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-6 mt-5">
                                    <?php ($websocket = \App\Models\BusinessSetting::where('key', 'websocket_status')->first()); ?>
                                    <?php ($websocket = $websocket ? $websocket->value : 0); ?>
                                    <div class="form-group mb-0">
                                        <label
                                            class="toggle-switch h--45px toggle-switch-sm d-flex justify-content-between border rounded px-3 py-0 form-control">
                                            <span class="pr-1 d-flex align-items-center switch--label">
                                                <span class="line--limit-1">
                                                    <?php echo e(translate('messages.websocket')); ?>

                                                </span>
                                                <span class="form-label-secondary text-danger d-flex"
                                                    data-toggle="tooltip" data-placement="right"
                                                    data-original-title="<?php echo e(translate('messages.If_WebSocket_is_enabled,_configure_the_server_accordingly_for_optimal_functionality.')); ?>"><img
                                                        src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>"
                                                        alt="<?php echo e(translate('messages.websocket_toggle')); ?>"> *
                                                </span>
                                            </span>
                                            <input type="checkbox"
                                                   data-id="websocket"
                                                   data-type="toggle"
                                                   data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/schedule-on.png')); ?>"
                                                   data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/schedule-off.png')); ?>"
                                                   data-title-on="<?php echo e(translate('messages.Want_to_enable')); ?> <strong><?php echo e(translate('messages.websocket_?')); ?></strong>"
                                                   data-title-off="<?php echo e(translate('messages.Want_to_disable')); ?> <strong><?php echo e(translate('messages.websocket_?')); ?></strong>'"
                                                   data-text-on="<p><?php echo e(translate('messages.If_you_enable_this,Deliveyman_last_location_will_be_recorded_by_websocket.')); ?></p>"
                                                   data-text-off="<p><?php echo e(translate('messages.If_you_disable_this,Deliveyman_last_location_will_be_recorded_by_default_method.')); ?></p>"
                                                   class="status toggle-switch-input dynamic-checkbox-toggle"
                                                   value="1"
                                                name="websocket_status" id="websocket"
                                                <?php echo e($websocket == 1 ? 'checked' : ''); ?>>
                                            <span class="toggle-switch-label text">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <?php ($websocket_url = \App\Models\BusinessSetting::where('key', 'websocket_url')->first()); ?>
                                    <div class="form-group mb-0">
                                        <label class="form-label"
                                            for="websocket_url"><?php echo e(translate('messages.websocket_url')); ?></label>
                                        <input type="text" id="websocket_url" name="websocket_url" value="<?php echo e($websocket_url->value ?? ''); ?>"
                                            class="form-control" placeholder="<?php echo e(translate('messages.Ex_:_ws://178.128.117.0')); ?>"
                                            required>
                                    </div>
                                </div>
                                <div class="col-6">
                                <?php ($websocket_port = \App\Models\BusinessSetting::where('key', 'websocket_port')->first()); ?>
                                    <div class="form-group mb-0">
                                        <label class="form-label"
                                            for="websocket_port"><?php echo e(translate('messages.websocket_port')); ?></label>
                                        <input id="websocket_port" type="number" value="<?php echo e($websocket_port->value ?? ''); ?>" name="websocket_port"
                                            class="form-control" placeholder="<?php echo e(translate('messages.Ex_:_6001')); ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="btn--container justify-content-end">
                                <button type="reset" id="reset_btn" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                                <button type="submit" id="submit" class="btn btn--primary"><?php echo e(translate('messages.save_information')); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/business-settings/websocket-index.blade.php ENDPATH**/ ?>