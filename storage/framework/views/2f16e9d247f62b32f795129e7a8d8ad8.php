<div class="d-flex flex-wrap justify-content-between align-items-center mb-5 mt-4 __gap-12px">
    <div class="js-nav-scroller hs-nav-scroller-horizontal mt-2">
        <!-- Nav -->
        <ul class="nav nav-tabs border-0 nav--tabs nav--pills">
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/dm/registration') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['dm','registration'])); ?>">
                <?php echo e(translate('New_Deliveryman_Registration')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/dm/approve') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['dm','approve'])); ?>">
                <?php echo e(translate('New_Deliveryman_Approval')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/dm/deny') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['dm','deny'])); ?>">
                <?php echo e(translate('New_Deliveryman_Rejection')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/dm/suspend') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['dm','suspend'])); ?>">
                    <?php echo e(translate('Account_Suspension')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/dm/unsuspend') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['dm','unsuspend'])); ?>">
                    <?php echo e(translate('Account_Unsuspension')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/dm/cash-collect') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['dm','cash-collect'])); ?>">
                    <?php echo e(translate('Cash_Collection')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/dm/forgot-password') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['dm','forgot-password'])); ?>">
                    <?php echo e(translate('Forgot_Password')); ?>

                </a>
            </li>
              <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/dm/withdraw-approve') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['dm','withdraw-approve'])); ?>">
                    <?php echo e(translate('Withdraw_Approval')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/dm/withdraw-deny') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['dm','withdraw-deny'])); ?>">
                    <?php echo e(translate('Withdraw_Rejection')); ?>

                </a>
            </li>
        </ul>
        <!-- End Nav -->
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/email-format-setting/partials/dm-email-template-setting-links.blade.php ENDPATH**/ ?>