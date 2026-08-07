<?php $__env->startSection('title',translate('messages.login_page_setup')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header d-flex flex-wrap align-items-center justify-content-between">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/app.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('login_setup')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->

        <ul class="nav nav-tabs border-0 nav--tabs nav--pills mb-4">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.business-settings.login-settings.index')); ?>"><?php echo e(translate('Customer_Login')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="<?php echo e(route('admin.business-settings.login_url_page')); ?>"><?php echo e(translate('panel_login_page_Url')); ?></a>
            </li>
        </ul>


        <form action="<?php echo e(route('admin.business-settings.login_url_update')); ?>" method="post">
        <?php echo csrf_field(); ?>
            <h5 class="card-title mb-3 pt-3">
                <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span> <span><?php echo e(translate('Admin_login_page')); ?></span>
            </h5>
            <div class="card">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <h5 class="card-title mb-3">
                            </h5>
                            <input type="text" hidden  name="type" value="admin">
                            <div class="__bg-F8F9FC-card">
                                <div class="form-group">
                                    <label  class="form-label">
                                        <?php echo e(translate('messages.Admin_login_url')); ?>

                                        <span class="input-label-secondary text--title" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="<?php echo e(translate('Add_dynamic_url_to_secure_admin_login_access.')); ?>">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                    </label>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><?php echo e(url('/')); ?>/login/</div>
                                        <input type="text" placeholder="<?php echo e(translate('messages.admin_login_url')); ?>" class="form-control h--45px" name="admin_login_url"
                                                required value="<?php echo e($data['admin_login_url'] ?? null); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="btn--container justify-content-end mt-20">
                        <button type="<?php echo e(env('APP_MODE')!='demo'?'submit':'button'); ?>"  class="btn btn--primary mb-2 call-demo" ><?php echo e(translate('messages.submit')); ?></button>
                    </div>
                </div>
            </div>
        </form>
        <form action="<?php echo e(route('admin.business-settings.login_url_update')); ?>" method="post">
            <?php echo csrf_field(); ?>
            <h5 class="card-title mb-3 pt-3">
                <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span> <span><?php echo e(translate('admin_employee_login_page')); ?></span>
            </h5>
            <div class="card">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <h5 class="card-title mb-3">
                            </h5>
                            <input type="text" hidden  name="type" value="admin_employee">

                            <div class="__bg-F8F9FC-card">
                                <div class="form-group">
                                    <label  class="form-label">
                                        <?php echo e(translate('messages.admin_employee_login_url')); ?>

                                        <span class="input-label-secondary text--title" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="<?php echo e(translate('Add_dynamic_url_to_secure_admin_employee_login_access.')); ?>">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                    </label>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><?php echo e(url('/')); ?>/login/</div>
                                        <input type="text" placeholder="<?php echo e(translate('messages.admin_employee_login_url')); ?>" class="form-control h--45px" name="admin_employee_login_url"
                                                required value="<?php echo e($data['admin_employee_login_url'] ?? null); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="btn--container justify-content-end mt-20">
                        <button type="<?php echo e(env('APP_MODE')!='demo'?'submit':'button'); ?>"  class="btn btn--primary mb-2 call-demo"><?php echo e(translate('messages.submit')); ?></button>
                    </div>
                </div>
            </div>
        </form>
        <form action="<?php echo e(route('admin.business-settings.login_url_update')); ?>" method="post">
            <?php echo csrf_field(); ?>
            <h5 class="card-title mb-3 pt-3">
                <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span> <span><?php echo e(translate('store_login_page')); ?></span>
            </h5>
            <div class="card">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <h5 class="card-title mb-3">
                            </h5>
                            <input type="text" hidden  name="type" value="store">

                            <div class="__bg-F8F9FC-card">
                                <div class="form-group">
                                    <label  class="form-label">
                                        <?php echo e(translate('messages.store_login_url')); ?>

                                        <span class="input-label-secondary text--title" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="<?php echo e(translate('Add_dynamic_url_to_secure_store_login_access.')); ?>">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                    </label>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><?php echo e(url('/')); ?>/login/</div>
                                        <input type="text" placeholder="<?php echo e(translate('messages.store_login_url')); ?>" class="form-control h--45px" name="store_login_url"
                                        required value="<?php echo e($data['store_login_url'] ?? null); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn--container justify-content-end mt-20">
                        <button type="<?php echo e(env('APP_MODE')!='demo'?'submit':'button'); ?>" class="btn btn--primary mb-2 call-demo"><?php echo e(translate('messages.submit')); ?></button>
                    </div>
                </div>
            </div>
        </form>
        <form action="<?php echo e(route('admin.business-settings.login_url_update')); ?>" method="post">
            <?php echo csrf_field(); ?>
            <h5 class="card-title mb-3 pt-3">
                <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span> <span><?php echo e(translate('store_employee_login_page')); ?></span>
            </h5>
            <div class="card">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <h5 class="card-title mb-3">
                            </h5>
                            <input type="text" hidden  name="type" value="store_employee">

                            <div class="__bg-F8F9FC-card">
                                <div class="form-group">
                                    <label  class="form-label">
                                        <?php echo e(translate('messages.store_employee_login_url')); ?>

                                        <span class="input-label-secondary text--title" data-toggle="tooltip"
                                        data-placement="right"
                                        data-original-title="<?php echo e(translate('Add_dynamic_url_to_secure_store_employee_login_access.')); ?>">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                    </label>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><?php echo e(url('/')); ?>/login/</div>
                                        <input type="text" placeholder="<?php echo e(translate('messages.store_employee_login_url')); ?>" class="form-control h--45px" name="store_employee_login_url"
                                                required value="<?php echo e($data['store_employee_login_url'] ?? null); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="btn--container justify-content-end mt-20">
                        <button type="<?php echo e(env('APP_MODE')!='demo'?'submit':'button'); ?>" class="btn btn--primary mb-2 call-demo"><?php echo e(translate('messages.submit')); ?></button>
                    </div>
                </div>
            </div>
        </form>



    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/login-setup/login_setup.blade.php ENDPATH**/ ?>