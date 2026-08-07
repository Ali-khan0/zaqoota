<div class="d-flex flex-wrap justify-content-between align-items-center mb-5 mt-4 __gap-12px">
    <div class="js-nav-scroller hs-nav-scroller-horizontal mt-2">
        <!-- Nav -->
        <ul class="nav nav-tabs border-0 nav--tabs nav--pills">
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/user/registration') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['user','registration'])); ?>">
                    <?php echo e(translate('New_Customer_Registration')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/user/pos-registration') ? 'active' : ''); ?>"
                   href="<?php echo e(route('admin.business-settings.email-setup', ['user','pos-registration'])); ?>">
                    <?php echo e(translate('POS_New_Customer_Registration')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/user/registration-otp') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['user','registration-otp'])); ?>">
                    <?php echo e(translate('Registration OTP')); ?>

                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/user/forgot-password') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['user','forgot-password'])); ?>">
                    <?php echo e(translate('Forgot Password')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/user/order-verification') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['user','order-verification'])); ?>">
                    <?php echo e(translate('Delivery_Verification')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/user/new-order') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['user','new-order'])); ?>"><?php echo e(translate('Order_Placement')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/user/refund-order') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['user','refund-order'])); ?>"><?php echo e(translate('messages.refund_order')); ?></a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/user/refund-request-deny') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['user','refund-request-deny'])); ?>">
                    <?php echo e(translate('Refund_Request_Rejected')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/user/add-fund') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['user','add-fund'])); ?>">
                    <?php echo e(translate('Fund_Add')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/user/offline-payment-approve') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['user','offline-payment-approve'])); ?>">
                    <?php echo e(translate('Offline_Payment_Approve')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/user/offline-payment-deny') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['user','offline-payment-deny'])); ?>">
                    <?php echo e(translate('Offline_Payment_Deny')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/user/suspend') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['user','suspend'])); ?>">
                    <?php echo e(translate('Account_Suspension')); ?>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/email-setup/user/unsuspend') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.email-setup', ['user','unsuspend'])); ?>">
                    <?php echo e(translate('Account_Unsuspension')); ?>

                </a>
            </li>
        </ul>
        <!-- End Nav -->
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/email-format-setting/partials/user-email-template-setting-links.blade.php ENDPATH**/ ?>