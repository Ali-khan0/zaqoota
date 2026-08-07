<div class="d-flex flex-wrap justify-content-between align-items-center mb-5 mt-4 __gap-12px">
    <div class="js-nav-scroller hs-nav-scroller-horizontal mt-2">
        <!-- Nav -->
        <ul class="nav nav-tabs border-0 nav--tabs nav--pills">
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/admin/forgot-password') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['admin','forgot-password'])); ?>">
                    <?php echo e(translate('Forgot Password')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/admin/store-registration') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['admin','store-registration'])); ?>">
                    <?php echo e(translate('New Store Registration')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/admin/dm-registration') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['admin','dm-registration'])); ?>">
                    <?php echo e(translate('New Delivery Man Registration')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/admin/withdraw-request') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['admin','withdraw-request'])); ?>">
                    <?php echo e(translate('Withdraw Request')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/admin/dm-withdraw-request') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['admin','dm-withdraw-request'])); ?>">
                    <?php echo e(translate('Delivery Man Withdraw Request')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/admin/campaign-request') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['admin','campaign-request'])); ?>">
                    <?php echo e(translate('Campaign Join Request')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/admin/refund-request') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['admin','refund-request'])); ?>">
                    <?php echo e(translate('Refund Request')); ?>

                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/admin/new-advertisement') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['admin','new-advertisement'])); ?>">
                    <?php echo e(translate('New_Advertisement_Request')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/admin/update-advertisement') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['admin','update-advertisement'])); ?>">
                    <?php echo e(translate('Advertisement_Update_Request')); ?>

                </a>
            </li>
        </ul>
        <!-- End Nav -->
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/email-format-setting/partials/admin-email-template-setting-links.blade.php ENDPATH**/ ?>