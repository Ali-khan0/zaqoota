<div class="d-flex flex-wrap justify-content-between align-items-center mb-5 mt-4 __gap-12px">
    <div class="js-nav-scroller hs-nav-scroller-horizontal mt-2">
        <!-- Nav -->
        <ul class="nav nav-tabs border-0 nav--tabs nav--pills">
            <li class="nav-item">
                <a class="nav-link   <?php echo e(Request::is('admin/business-settings/third-party/payment-method') ? 'active' : ''); ?>" href="<?php echo e(route('admin.business-settings.third-party.payment-method')); ?>"   aria-disabled="true"><?php echo e(translate('Payment Methods')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/third-party/sms-module') ? 'active' : ''); ?>" href="<?php echo e(route('admin.business-settings.third-party.sms-module')); ?>"  aria-disabled="true"><?php echo e(translate('SMS Module')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/third-party/mail-config') || Request::is('admin/business-settings/third-party/test-mail')  ? 'active' : ''); ?>" href="<?php echo e(route('admin.business-settings.third-party.mail-config')); ?>"  aria-disabled="true"><?php echo e(translate('Mail Config')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/third-party/config-setup') ?'active':''); ?>" href="<?php echo e(route('admin.business-settings.third-party.config-setup')); ?>"  aria-disabled="true"><?php echo e(translate('Map APIs')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/third-party/social-login/view')?'active':''); ?>" href="<?php echo e(route('admin.business-settings.third-party.social-login.view')); ?>"  aria-disabled="true"><?php echo e(translate('Social Logins')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/third-party/recaptcha*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.business-settings.third-party.recaptcha_index')); ?>"  aria-disabled="true"><?php echo e(translate('Recaptcha')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/third-party/firebase-otp*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.business-settings.third-party.firebase_otp_index')); ?>"  aria-disabled="true"><?php echo e(translate('Firebase OTP')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/third-party/storage-connection*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.business-settings.third-party.storage_connection_index')); ?>"  aria-disabled="true"><?php echo e(translate('Storage_Connection')); ?></a>
            </li>
        </ul>
        <!-- End Nav -->
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/partials/third-party-links.blade.php ENDPATH**/ ?>