<div class="d-flex flex-wrap justify-content-between align-items-center mb-20 __gap-12px">
    <div class="js-nav-scroller hs-nav-scroller-horizontal mt-2">
        <!-- Nav -->
        <ul class="nav nav-tabs border-0 nav--tabs nav--pills">
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/pages/admin-landing-page-settings/fixed-data') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.admin-landing-page-settings', 'fixed-data')); ?>"><?php echo e(translate('messages.fixed_data')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/pages/admin-landing-page-settings/promotional-section*') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.admin-landing-page-settings', 'promotional-section')); ?>"><?php echo e(translate('messages.promotional_section')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/pages/admin-landing-page-settings/feature-list*') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.admin-landing-page-settings', 'feature-list')); ?>"><?php echo e(translate('messages.feature_list')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/pages/admin-landing-page-settings/earn-money') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.admin-landing-page-settings', 'earn-money')); ?>"><?php echo e(translate('messages.earn_money')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/pages/admin-landing-page-settings/why-choose-us*') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.admin-landing-page-settings', 'why-choose-us')); ?>"><?php echo e(translate('messages.why_choose_us')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/pages/admin-landing-page-settings/available-zone*') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.admin-landing-page-settings', 'available-zone')); ?>"><?php echo e(translate('messages.available_zone')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/pages/admin-landing-page-settings/download-apps') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.admin-landing-page-settings', 'download-apps')); ?>"><?php echo e(translate('messages.download_apps')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/pages/admin-landing-page-settings/testimonials*') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.admin-landing-page-settings', 'testimonials')); ?>"><?php echo e(translate('messages.testimonials')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/pages/admin-landing-page-settings/contact-us') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.admin-landing-page-settings', 'contact-us')); ?>"><?php echo e(translate('messages.contact_us_page')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/pages/admin-landing-page-settings/background-color') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.admin-landing-page-settings', 'background-color')); ?>"><?php echo e(translate('messages.background_colors')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/business-settings/pages/admin-landing-page-settings/meta-data') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.business-settings.admin-landing-page-settings', 'meta-data')); ?>"><?php echo e(translate('messages.meta_data')); ?></a>
            </li>
        </ul>
        <!-- End Nav -->
    </div>
</div>
<?php /**PATH /var/www/zaqoota/resources/views/admin-views/business-settings/landing-page-settings/top-menu-links/admin-landing-page-links.blade.php ENDPATH**/ ?>