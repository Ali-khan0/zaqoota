<?php $__env->startSection('title',translate('messages.admin_landing_page')); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <div class="page-header pb-0">
        <div class="d-flex flex-wrap justify-content-between">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/landing.png')); ?>" class="w--20" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.admin_landing_pages')); ?>

                </span>
            </h1>
            <div class="text--primary-2 py-1 d-flex flex-wrap align-items-center" type="button" data-toggle="modal" data-target="#how-it-works">
                <strong class="mr-2"><?php echo e(translate('See_how_it_works!')); ?></strong>
                <div>
                    <i class="tio-info-outined"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-20 mt-2">
        <div class="js-nav-scroller hs-nav-scroller-horizontal">
            <?php echo $__env->make('admin-views.business-settings.landing-page-settings.top-menu-links.admin-landing-page-links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>
    <div class="card my-2">
        <div class="card-body">
            <form action="<?php echo e(route('admin.business-settings.admin-landing-page-settings', 'background-color')); ?>"
                method="POST">
                <?php ($backgroundChange = \App\Models\BusinessSetting::where(['key' => 'backgroundChange'])->first()); ?>
                <?php ($backgroundChange = isset($backgroundChange->value) ? json_decode($backgroundChange->value, true) : null); ?>
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-sm-4">
                        <label for="header-bg" class="form-label d-block text-center"><?php echo e(translate('Primary Color 1')); ?></label>
                        <input id="header-bg" name="header-bg" type="color" class="form-control form-control-color" value="<?php echo e($backgroundChange['primary_1_hex'] ?? '#EF7822'); ?>" required>
                    </div>
                    <div class="col-sm-6">
                        <label for="footer-bg" class="form-label d-block text-center"><?php echo e(translate('Primary Color 2')); ?></label>
                        <input id="footer-bg" name="footer-bg" type="color" class="form-control form-control-color" value="<?php echo e($backgroundChange['primary_2_hex'] ?? '#333E4F'); ?>" required>
                    </div>

                </div>
                <div class="form-group text-right mt-3 mb-0">
                    <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.submit')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
    <!-- How it Works -->
    <?php echo $__env->make('admin-views.business-settings.landing-page-settings.partial.how-it-work', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/business-settings/landing-page-settings/admin-landing-background-color.blade.php ENDPATH**/ ?>