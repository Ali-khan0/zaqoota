<div class="d-flex flex-wrap justify-content-between align-items-center mb-5 mt-4 __gap-12px">
    <div class="js-nav-scroller hs-nav-scroller-horizontal mt-2">
        <!-- Nav -->
        <ul class="nav nav-tabs border-0 nav--tabs nav--pills">
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/rental-email-setup/provider/registration') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.rental-email-setup', ['provider','registration'])); ?>">
                    <?php echo e(translate('New Provider Registration')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/rental-email-setup/provider/approve') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.rental-email-setup', ['provider','approve'])); ?>">
                    <?php echo e(translate('New_Provider_Approval')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/rental-email-setup/provider/deny') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.rental-email-setup', ['provider','deny'])); ?>">
                    <?php echo e(translate('New_Provider_Rejection')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/rental-email-setup/provider/suspend') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.rental-email-setup', ['provider','suspend'])); ?>">
                    <?php echo e(translate('Account_Suspend')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/rental-email-setup/provider/unsuspend') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.rental-email-setup', ['provider','unsuspend'])); ?>">
                    <?php echo e(translate('Account_Unsuspend')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/rental-email-setup/provider/withdraw-approve') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.rental-email-setup', ['provider','withdraw-approve'])); ?>">
                    <?php echo e(translate('Withdraw_Approval')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/rental-email-setup/provider/withdraw-deny') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.rental-email-setup', ['provider','withdraw-deny'])); ?>">
                    <?php echo e(translate('Withdraw_Rejection')); ?>

                </a>
            </li>

            <?php if(\App\CentralLogics\Helpers::subscription_check()): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/rental-email-setup/provider/subscription-successful') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.rental-email-setup', ['provider','subscription-successful'])); ?>">
                    <?php echo e(translate('Subscription_Successful')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/rental-email-setup/provider/subscription-renew') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.rental-email-setup', ['provider','subscription-renew'])); ?>">
                    <?php echo e(translate('Subscription_Renew')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/rental-email-setup/provider/subscription-shift') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.rental-email-setup', ['provider','subscription-shift'])); ?>">
                    <?php echo e(translate('Subscription_Shift')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/rental-email-setup/provider/subscription-cancel') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.rental-email-setup', ['provider','subscription-cancel'])); ?>">
                    <?php echo e(translate('Subscription_Cancel')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/rental-email-setup/provider/subscription-plan_upadte') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.rental-email-setup', ['provider','subscription-plan_upadte'])); ?>">
                    <?php echo e(translate('Subscription_Plan_Upadte')); ?>

                </a>
            </li>
            <?php endif; ?>
        </ul>
        <!-- End Nav -->
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/business-settings/email-format-setting/partials/provider-email-template-setting-links.blade.php ENDPATH**/ ?>