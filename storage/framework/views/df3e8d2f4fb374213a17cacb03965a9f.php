<div class="d-flex flex-wrap justify-content-between align-items-center mb-5 mt-4 __gap-12px">
    <div class="js-nav-scroller hs-nav-scroller-horizontal mt-2">
        <!-- Nav -->
        <ul class="nav nav-tabs border-0 nav--tabs nav--pills">
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/store/registration') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['store','registration'])); ?>">
                    <?php echo e(translate('New Store Registration')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/store/approve') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['store','approve'])); ?>">
                    <?php echo e(translate('New_Store_Approval')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/store/deny') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['store','deny'])); ?>">
                    <?php echo e(translate('New_Store_Rejection')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/store/suspend') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['store','suspend'])); ?>">
                    <?php echo e(translate('Account_Suspend')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/store/unsuspend') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['store','unsuspend'])); ?>">
                    <?php echo e(translate('Account_Unsuspend')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/store/withdraw-approve') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['store','withdraw-approve'])); ?>">
                    <?php echo e(translate('Withdraw_Approval')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/store/withdraw-deny') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['store','withdraw-deny'])); ?>">
                    <?php echo e(translate('Withdraw_Rejection')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/store/campaign-request') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['store','campaign-request'])); ?>">
                    <?php echo e(translate('Campaign Join Request')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/store/campaign-approve') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['store','campaign-approve'])); ?>">
                    <?php echo e(translate('Campaign_Join_Approval')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/store/campaign-deny') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['store','campaign-deny'])); ?>">
                    <?php echo e(translate('Campaign_Join_Rejection')); ?>

                </a>
            </li>

            <?php if(\App\CentralLogics\Helpers::get_mail_status('product_approval')): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/store/product-approved') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['store','product-approved'])); ?>">
                    <?php echo e(translate('Product_approved')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/store/product-deny') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['store','product-deny'])); ?>">
                    <?php echo e(translate('Product_Rejection')); ?>

                </a>
            </li>
            <?php endif; ?>

            <?php if(\App\CentralLogics\Helpers::subscription_check()): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/store/subscription-successful') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['store','subscription-successful'])); ?>">
                    <?php echo e(translate('Subscription_Successful')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/store/subscription-renew') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['store','subscription-renew'])); ?>">
                    <?php echo e(translate('Subscription_Renew')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/store/subscription-shift') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['store','subscription-shift'])); ?>">
                    <?php echo e(translate('Subscription_Shift')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/store/subscription-cancel') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['store','subscription-cancel'])); ?>">
                    <?php echo e(translate('Subscription_Cancel')); ?>

                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/store/subscription-plan_upadte') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['store','subscription-plan_upadte'])); ?>">
                    <?php echo e(translate('Subscription_Plan_Upadte')); ?>

                </a>
            </li>
            <?php endif; ?>

            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/store/advertisement-create') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['store','advertisement-create'])); ?>">
                    <?php echo e(translate('Advertisement_Create_By_Admin')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/store/advertisement-approved') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['store','advertisement-approved'])); ?>">
                    <?php echo e(translate('Advertisement_Approval')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/store/advertisement-deny') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['store','advertisement-deny'])); ?>">
                    <?php echo e(translate('Advertisement_Deny')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/store/advertisement-resume') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['store','advertisement-resume'])); ?>">
                    <?php echo e(translate('Advertisement_Resume')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/store/advertisement-pause') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['store','advertisement-pause'])); ?>">
                    <?php echo e(translate('Advertisement_Pause')); ?>

                </a>
            </li>
        </ul>
        <!-- End Nav -->
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/email-format-setting/partials/store-email-template-setting-links.blade.php ENDPATH**/ ?>