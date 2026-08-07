<div class="d-flex flex-wrap justify-content-between align-items-center mb-20 __gap-12px">
    <div class="js-nav-scroller hs-nav-scroller-horizontal mt-2">
        <!-- Nav -->
        <ul class="nav nav-tabs border-0 nav--tabs nav--pills">
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/promotional-banner/add-new') || Request::is('admin/promotional-banner/edit*') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.promotional-banner.add-new')); ?>"><?php echo e(translate('messages.Promotional Banners')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/promotional-banner/add-video') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.promotional-banner.add-video')); ?>"><?php echo e(translate('messages.video')); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo e(Request::is('admin/promotional-banner/add-why-choose') ||  Request::is('admin/promotional-banner/why-choose/edit*') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.promotional-banner.add-why-choose')); ?>"><?php echo e(translate('messages.why_choose_us')); ?></a>
            </li>
        </ul>
        <!-- End Nav -->
    </div>
</div><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/other-banners/partial/parcel-links.blade.php ENDPATH**/ ?>