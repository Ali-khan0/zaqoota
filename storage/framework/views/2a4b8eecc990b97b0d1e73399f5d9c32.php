<div class="d-flex flex-wrap justify-content-between align-items-center mb-20 __gap-12px">
    <div class="js-nav-scroller hs-nav-scroller-horizontal mt-2">
        <!-- Nav -->
        <ul class="nav nav-tabs border-0 nav--tabs nav--pills">
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/pages/flutter-landing-page-settings/fixed-data') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.flutter-landing-page-settings', 'fixed-data')); ?>"><?php echo e(translate('messages.fixed_data')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/pages/flutter-landing-page-settings/special-criteria*') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.flutter-landing-page-settings', 'special-criteria')); ?>"><?php echo e(translate('messages.special_criteria')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/pages/flutter-landing-page-settings/available-zone*') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.flutter-landing-page-settings', 'available-zone')); ?>"><?php echo e(translate('messages.available_zone')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/pages/flutter-landing-page-settings/join-as') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.flutter-landing-page-settings', 'join-as')); ?>"><?php echo e(translate('messages.join_as')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/pages/flutter-landing-page-settings/download-apps') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.flutter-landing-page-settings', 'download-apps')); ?>"><?php echo e(translate('messages.download_apps')); ?></a>
            </li>
        </ul>
        <!-- End Nav -->
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/landing-page-settings/top-menu-links/flutter-landing-page-links.blade.php ENDPATH**/ ?>