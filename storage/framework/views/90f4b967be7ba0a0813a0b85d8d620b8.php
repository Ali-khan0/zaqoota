<div id="sidebarMain" class="d-none">
    <aside class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered  ">
        <div class="navbar-vertical-container">
            <div class="navbar-brand-wrapper justify-content-between">
                <!-- Logo -->
                <?php ($store_logo = \App\Models\BusinessSetting::where(['key' => 'logo'])->first()); ?>
                <a class="navbar-brand" href="<?php echo e(route('admin.dashboard')); ?>" aria-label="Front">
                       <img class="navbar-brand-logo initial--36 onerror-image onerror-image" data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                    src="<?php echo e(\App\CentralLogics\Helpers::get_full_url('business', $store_logo?->value?? '', $store_logo?->storage[0]?->value ?? 'public','favicon')); ?>"
                    alt="Logo">
                    <img class="navbar-brand-logo-mini initial--36 onerror-image onerror-image" data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                    src="<?php echo e(\App\CentralLogics\Helpers::get_full_url('business', $store_logo?->value?? '', $store_logo?->storage[0]?->value ?? 'public','favicon')); ?>"
                    alt="Logo">
                </a>
                <!-- End Logo -->

                <!-- Navbar Vertical Toggle -->
                <button type="button" class="js-navbar-vertical-aside-toggle-invoker navbar-vertical-aside-toggle btn btn-icon btn-xs btn-ghost-dark">
                    <i class="tio-clear tio-lg"></i>
                </button>
                <!-- End Navbar Vertical Toggle -->

                <div class="navbar-nav-wrap-content-left">
                    <!-- Navbar Vertical Toggle -->
                    <button type="button" class="js-navbar-vertical-aside-toggle-invoker close">
                        <i class="tio-first-page navbar-vertical-aside-toggle-short-align" data-toggle="tooltip"
                        data-placement="right" title="Collapse"></i>
                        <i class="tio-last-page navbar-vertical-aside-toggle-full-align"
                        data-template='<div class="tooltip d-none d-sm-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'></i>
                    </button>
                    <!-- End Navbar Vertical Toggle -->
                </div>

            </div>

            <!-- Content -->
            <div class="navbar-vertical-content bg--005555" id="navbar-vertical-content">
                <form autocomplete="off"   class="sidebar--search-form">
                    <div class="search--form-group">
                        <button type="button" class="btn"><i class="tio-search"></i></button>
                        <input  autocomplete="false" name="qq" type="text" class="form-control form--control" placeholder="<?php echo e(translate('Search Menu...')); ?>" id="search">

                        <div id="search-suggestions" class="flex-wrap mt-1"></div>
                    </div>
                </form>

                <ul class="navbar-nav navbar-nav-lg nav-tabs">
                    <!-- Dashboards -->
                    <li class="navbar-vertical-aside-has-menu <?php echo $__env->yieldContent('dashboard'); ?> <?php echo e(Request::is('admin') ? 'show active' : ''); ?>">
                        <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.dashboard')); ?>?module_id=<?php echo e(Config::get('module.current_module_id')); ?>" title="<?php echo e(translate('messages.dashboard')); ?>">
                            <i class="tio-home-vs-1-outlined nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                <?php echo e(translate('messages.dashboard')); ?>

                            </span>
                        </a>
                    </li>
                    <!-- End Dashboards -->
                    <?php if(\App\CentralLogics\Helpers::module_permission_check('trip')): ?>
                        <li class="nav-item">
                            <small class="nav-subtitle"><?php echo e(translate('messages.Trip_management')); ?></small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>

                        <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/rental/trip*') ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" title="<?php echo e(translate('messages.Trips')); ?>">
                                <i class="tio-taxi nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    <?php echo e(translate('messages.Trips')); ?>

                                </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="display:<?php echo e(Request::is('admin/rental/trip*') ? 'block' : 'none'); ?>">
                                <li class="nav-item <?php echo e(request()->status == 'all' ? 'active' : ''); ?>">
                                    <a class="nav-link" href="<?php echo e(route('admin.rental.trip.list')); ?>?status=all" title="<?php echo e(translate('messages.all_trips')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                            <?php echo e(translate('messages.all')); ?>

                                            <span class="badge badge-soft-info badge-pill ml-1">
                                                <?php echo e(\Modules\Rental\Entities\Trips::count()); ?>

                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo e(request()->status == 'scheduled' ? 'active' : ''); ?> <?php echo $__env->yieldContent('scheduled'); ?>">
                                    <a class="nav-link" href="<?php echo e(route('admin.rental.trip.list')); ?>?status=scheduled" title="<?php echo e(translate('messages.scheduled_trips')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                            <?php echo e(translate('messages.scheduled')); ?>

                                            <span class="badge badge-soft-info badge-pill ml-1">
                                                <?php echo e(\Modules\Rental\Entities\Trips::Scheduled()->count()); ?>

                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo e(request()->status == 'pending' ? 'active' : ''); ?> <?php echo $__env->yieldContent('pending'); ?>">
                                    <a class="nav-link " href="<?php echo e(route('admin.rental.trip.list')); ?>?status=pending" title="<?php echo e(translate('messages.pending_trips')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                            <?php echo e(translate('messages.pending')); ?>

                                            <span class="badge badge-soft-info badge-pill ml-1">
                                                <?php echo e(\Modules\Rental\Entities\Trips::Pending()->count()); ?>

                                            </span>
                                        </span>
                                    </a>
                                </li>

                                <li class="nav-item <?php echo e(request()->status == 'confirmed' ? 'active' : ''); ?> <?php echo $__env->yieldContent('confirmed'); ?>">
                                    <a class="nav-link " href="<?php echo e(route('admin.rental.trip.list')); ?>?status=confirmed" title="<?php echo e(translate('messages.confirmed_trips')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                            <?php echo e(translate('messages.confirmed')); ?>

                                            <span class="badge badge-soft-info badge-pill ml-1">
                                                <?php echo e(\Modules\Rental\Entities\Trips::Confirmed()->count()); ?>

                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo e(request()->status == 'ongoing' ? 'active' : ''); ?> <?php echo $__env->yieldContent('ongoing'); ?>">
                                    <a class="nav-link " href="<?php echo e(route('admin.rental.trip.list')); ?>?status=ongoing" title="<?php echo e(translate('messages.Ongoing_trips')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                            <?php echo e(translate('messages.Ongoing')); ?>

                                            <span class="badge badge-soft-info badge-pill ml-1">
                                                <?php echo e(\Modules\Rental\Entities\Trips::Ongoing()->count()); ?>

                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo e(request()->status == 'completed' ? 'active' : ''); ?> <?php echo $__env->yieldContent('completed'); ?>">
                                    <a class="nav-link text-capitalize" href="<?php echo e(route('admin.rental.trip.list')); ?>?status=completed" title="<?php echo e(translate('messages.Completed_trips')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                            <?php echo e(translate('messages.Completed')); ?>

                                            <span class="badge badge-soft-success badge-pill ml-1">
                                                <?php echo e(\Modules\Rental\Entities\Trips::Completed()->count()); ?>

                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo e(request()->status == 'canceled' ? 'active' : ''); ?> <?php echo $__env->yieldContent('canceled'); ?>">
                                    <a class="nav-link " href="<?php echo e(route('admin.rental.trip.list')); ?>?status=canceled" title="<?php echo e(translate('messages.canceled_trips')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                            <?php echo e(translate('messages.canceled')); ?>

                                            <span class="badge badge-soft-danger  badge-pill ml-1">
                                                <?php echo e(\Modules\Rental\Entities\Trips::Canceled()->count()); ?>

                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo e(request()->status == 'payment_failed' ? 'active' : ''); ?> <?php echo $__env->yieldContent('payment_failed'); ?>">
                                    <a class="nav-link " href="<?php echo e(route('admin.rental.trip.list')); ?>?status=payment_failed" title="<?php echo e(translate('messages.payment_failed_trips')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container text-capitalize">
                                            <?php echo e(translate('messages.payment_failed')); ?>

                                            <span class="badge badge-soft-danger  badge-pill ml-1">
                                                <?php echo e(\Modules\Rental\Entities\Trips::PaymentFailed()->count()); ?>

                                            </span>
                                        </span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if(\App\CentralLogics\Helpers::module_permission_check('promotion')): ?>
                        <!-- Marketing section -->
                        <li class="nav-item">
                            <small class="nav-subtitle" title="<?php echo e(translate('Promotion Management')); ?>"><?php echo e(translate('Promotion Management')); ?></small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>

                        <!-- Banner -->
                        <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/rental/banner*') ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.rental.banner.add-new')); ?>" title="<?php echo e(translate('messages.banners')); ?>">
                                <i class="tio-image nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.banners')); ?></span>
                            </a>
                        </li>
                        <!-- Coupon -->
                        <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/rental/coupon*') ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.rental.coupon.add-new')); ?>" title="<?php echo e(translate('messages.coupons')); ?>">
                                <i class="tio-gift nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.coupons')); ?></span>
                            </a>
                        </li>
                        <!-- End Coupon -->
                         <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/rental/cashback*') ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.rental.cashback.list')); ?>" title="<?php echo e(translate('messages.cashback')); ?>">
                                <i class="tio-settings-back nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.cashback')); ?></span>
                            </a>
                        </li>
                        <!-- Notification -->
                        <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/rental/notification*') ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.rental.notification.list')); ?>" title="<?php echo e(translate('messages.push_notification')); ?>">
                                <i class="tio-notifications nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    <?php echo e(translate('messages.push_notification')); ?>

                                </span>
                            </a>
                        </li>
                        <!-- End Notification -->
                    <?php endif; ?>

                    <?php if(\App\CentralLogics\Helpers::module_permission_check('vehicle')): ?>
                        <li class="nav-item">
                            <small class="nav-subtitle" title="<?php echo e(translate('messages.vehicle_section')); ?>"><?php echo e(translate('messages.vehicle_management')); ?></small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>
                        <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/rental/category/list') || Request::is('admin/rental/category/edit*') ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.rental.category.list')); ?>" title="<?php echo e(translate('messages.category')); ?>">
                                <i class="tio-category nav-icon"></i>
                                <span class="text-truncate position-relative overflow-visible">
                                    <?php echo e(translate('messages.category')); ?>

                                </span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/rental/brand/list') || Request::is('admin/rental/brand/edit*') ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.rental.brand.list')); ?>" title="<?php echo e(translate('messages.brands')); ?>">
                                <i class="tio-medal nav-icon"></i>
                                <span class="text-truncate position-relative overflow-visible">
                                    <?php echo e(translate('messages.brands')); ?>

                                </span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/rental/provider/vehicle*') ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" title="<?php echo e(translate('Vehicle Setup')); ?>">
                                <i class="tio-car nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate text-capitalize"><?php echo e(translate('Vehicle Setup')); ?></span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="display:<?php echo e(Request::is('admin/rental/provider/vehicle*') ? 'block' : 'none'); ?>">
                                <li class="nav-item <?php echo e(Request::is('admin/rental/provider/vehicle/create') || Request::is('admin/rental/provider/vehicle/edit/*')  ? 'active' : ''); ?>">
                                    <a class="nav-link " href="<?php echo e(route('admin.rental.provider.vehicle.create')); ?>" title="<?php echo e(translate('messages.create_new')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate"><?php echo e(translate('messages.create_new')); ?></span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo e(Request::is('admin/rental/provider/vehicle/list')  ||Request::is('admin/rental/provider/vehicle/update/*') ||Request::is('admin/rental/provider/vehicle/details/*') || Request::is('admin/rental/provider/vehicle/edit/*')  ? 'active' : ''); ?>">
                                    <a class="nav-link " href="<?php echo e(route('admin.rental.provider.vehicle.list')); ?>" title="<?php echo e(translate('messages.vehicle_list')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate"><?php echo e(translate('messages.list')); ?></span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo e(Request::is('admin/rental/provider/vehicle/review-list') ? 'active' : ''); ?>">
                                    <a class="nav-link " href="<?php echo e(route('admin.rental.provider.vehicle.reviews')); ?>" title="<?php echo e(translate('messages.review_list')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate"><?php echo e(translate('messages.review')); ?></span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo e(Request::is('admin/rental/provider/vehicle/bulk-import') ? 'active' : ''); ?>">
                                    <a class="nav-link " href="<?php echo e(route('admin.rental.provider.vehicle.bulk_import')); ?>" title="<?php echo e(translate('messages.bulk_import')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate text-capitalize"><?php echo e(translate('messages.bulk_import')); ?></span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo e(Request::is('admin/rental/provider/vehicle/bulk-export') ? 'active' : ''); ?>">
                                    <a class="nav-link " href="<?php echo e(route('admin.rental.provider.vehicle.bulk-export-index')); ?>" title="<?php echo e(translate('messages.bulk_export')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate text-capitalize"><?php echo e(translate('messages.bulk_export')); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if(\App\CentralLogics\Helpers::module_permission_check('provider')): ?>
                        <li class="nav-item">
                            <small class="nav-subtitle" title="<?php echo e(translate('messages.provider_section')); ?>"><?php echo e(translate('messages.provider_management')); ?></small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>

                        <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/rental/provider/new-requests') || Request::is('admin/rental/provider/new-requests-details/*') ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.rental.provider.new-requests')); ?>?request_type=pending_provider" title="<?php echo e(translate('messages.new_providers_request')); ?>">
                                <span class="tio-calendar-note nav-icon"></span>
                                <span class="text-truncate position-relative overflow-visible">
                                    <?php echo e(translate('messages.new_providers_request')); ?>

                                    <?php ($new_str = \App\Models\Store::whereHas('vendor', function($query){
                                        return $query->where('status', null);
                                    })->module(Config::get('module.current_module_id'))->get()); ?>
                                    <?php if(count($new_str)>0): ?>

                                    <span class="btn-status btn-status-danger border-0 size-8px"></span>
                                    <?php endif; ?>
                                </span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/rental/provider/create') ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.rental.provider.create')); ?>" title="<?php echo e(translate('add new provider')); ?>">
                                <span class="tio-add-circle nav-icon"></span>
                                <span class="text-truncate position-relative overflow-visible">
                                    <?php echo e(translate('add new provider')); ?>

                                </span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/rental/provider/list') ||  Request::is('admin/rental/provider/details/*') ||  Request::is('admin/rental/provider/driver/*') ||  Request::is('admin/rental/provider/edit*') ||  Request::is('admin/store/withdraw-view*') ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.rental.provider.list')); ?>" title="<?php echo e(translate('messages.providers_list')); ?>">
                                <span class="tio-layout nav-icon"></span>
                                <span class="text-truncate"><?php echo e(translate('providers list')); ?></span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/rental/provider/bulk-import') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.rental.provider.bulk_import')); ?>" title="<?php echo e(translate('messages.bulk_import')); ?>">
                                <span class="tio-publish nav-icon"></span>
                                <span class="text-truncate text-capitalize"><?php echo e(translate('messages.bulk_import')); ?></span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/rental/provider/bulk-export') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.rental.provider.bulk_export_index')); ?>" title="<?php echo e(translate('messages.bulk_export')); ?>">
                                <span class="tio-download-to nav-icon"></span>
                                <span class="text-truncate text-capitalize"><?php echo e(translate('messages.bulk_export')); ?></span>
                            </a>
                        </li>
                   <?php endif; ?>

                    <?php if(\App\CentralLogics\Helpers::module_permission_check('download_app')): ?>
                        <li class="nav-item">
                            <small class="nav-subtitle" title="<?php echo e(translate('messages.Download_Apps')); ?>"><?php echo e(translate('Download_Apps')); ?></small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>
                        <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/rental/settings*')?'active':''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link " href="<?php echo e(route('admin.rental.settings.down_app')); ?>" title="<?php echo e(translate('Download_Apps')); ?>">
                                <i class="tio-shopping-basket-outlined nav-icon"></i>
                                <span class="text-truncate"><?php echo e(translate('Download_Apps')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>

                <li class="nav-item py-5">

                </li>

                    <?php if ($__env->exists('layouts.admin.partials._logout_modal')) echo $__env->make('layouts.admin.partials._logout_modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                </ul>
            </div>
            <!-- End Content -->
        </div>
    </aside>
</div>

<div id="sidebarCompact" class="d-none">

</div>


<?php $__env->startPush('script_2'); ?>

<script src="<?php echo e(asset('Modules/Rental/public/assets/js/admin/view-pages/rental-sidebar.js')); ?>"></script>

<?php $__env->stopPush(); ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/partials/_sidebar_rental.blade.php ENDPATH**/ ?>