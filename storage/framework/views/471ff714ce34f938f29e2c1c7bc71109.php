<div class="d-flex flex-wrap justify-content-between align-items-center mb-5 mt-4 __gap-12px">
    <div class="js-nav-scroller hs-nav-scroller-horizontal mt-2">
        <!-- Nav -->
        <ul class="nav nav-tabs border-0 nav--tabs nav--pills">
            <li class="nav-item">
                <a class="nav-link  <?php echo e(Request::is('admin/business-settings/business-setup') ?'active':''); ?>" href="<?php echo e(route('admin.business-settings.business-setup')); ?>"   aria-disabled="true"><?php echo e(translate('messages.business_information')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/business-setup/order') ?'active':''); ?>" href="<?php echo e(route('admin.business-settings.business-setup',  ['tab' => 'order'])); ?>"  aria-disabled="true"><?php echo e(translate('messages.order_settings')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/business-setup/refund-settings') ?'active':''); ?>" href="<?php echo e(route('admin.business-settings.business-setup',  ['tab' => 'refund-settings'])); ?>"  aria-disabled="true"><?php echo e(translate('messages.refund_settings')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/business-setup/store') ?'active':''); ?>" href="<?php echo e(route('admin.business-settings.business-setup',  ['tab' => 'store'])); ?>"  aria-disabled="true"><?php echo e(translate('messages.Vendor')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/business-setup/deliveryman') ?'active':''); ?>" href="<?php echo e(route('admin.business-settings.business-setup',  ['tab' => 'deliveryman'])); ?>"  aria-disabled="true"><?php echo e(translate('messages.deliveryman')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/business-setup/customer') ?'active':''); ?>" href="<?php echo e(route('admin.business-settings.business-setup',  ['tab' => 'customer'])); ?>"  aria-disabled="true"><?php echo e(translate('messages.customers')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/business-setup/priority') ?'active':''); ?>" href="<?php echo e(route('admin.business-settings.business-setup',  ['tab' => 'priority'])); ?>"  aria-disabled="true"><?php echo e(translate('messages.priority_setup')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/language') ?'active':''); ?>" href="<?php echo e(route('admin.business-settings.language.index')); ?>"  aria-disabled="true"><?php echo e(translate('messages.Languages')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/business-setup/landing-page') ?'active':''); ?>" href="<?php echo e(route('admin.business-settings.business-setup',  ['tab' => 'landing-page'])); ?>"  aria-disabled="true"><?php echo e(translate('messages.landing_page')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/business-setup/websocket') ?'active':''); ?>" href="<?php echo e(route('admin.business-settings.business-setup',  ['tab' => 'websocket'])); ?>"  aria-disabled="true"><?php echo e(translate('messages.websocket')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/business-setup/disbursement') ?'active':''); ?>" href="<?php echo e(route('admin.business-settings.business-setup',  ['tab' => 'disbursement'])); ?>"  aria-disabled="true"><?php echo e(translate('messages.disbursement')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/business-setup/automated-message') ?'active':''); ?>" href="<?php echo e(route('admin.business-settings.business-setup',  ['tab' => 'automated-message'])); ?>"  aria-disabled="true"><?php echo e(translate('messages.Automated_Message')); ?></a>
            </li>
        </ul>
        <!-- End Nav -->
    </div>
    <?php if(!(Request::is('admin/business-settings/language') || Request::is('admin/business-settings/business-setup/refund-settings') || Request::is('admin/business-settings/business-setup/automated-message'))): ?>
    <div class="d-flex flex-wrap justify-content-end align-items-center flex-grow-1">
        <div class="blinkings active">
            <i class="tio-info-outined"></i>
            <div class="business-notes">
                <h6><img src="<?php echo e(asset('/public/assets/admin/img/notes.png')); ?>" alt=""> <?php echo e(translate('Note')); ?></h6>
                <div>
                    <?php if(Request::is('admin/business-settings/business-setup/refund-settings')): ?>
                    <?php echo e(translate('messages.*If_the_Admin_enables_the_‘Refund_Request_Mode’,_customers_can_request_a_refund.')); ?>

                    <?php else: ?>
                    <?php echo e(translate('messages.don’t_forget_to_click_the_‘Save Information’_button_below_to_save_changes.')); ?>

                    <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/partials/nav-menu.blade.php ENDPATH**/ ?>