<div id="sidebarMain" class="d-none">
    <aside
        class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered">
        <div class="navbar-vertical-container">
            <div class="navbar-brand-wrapper justify-content-between">
                <!-- Logo -->

                <?php ($store_data = \App\CentralLogics\Helpers::get_store_data()); ?>
                <a class="navbar-brand" href="<?php echo e(route('vendor.dashboard')); ?>" aria-label="Front">
                    <img class="navbar-brand-logo initial--36  onerror-image"
                        data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                        src="<?php echo e($store_data->logo_full_url); ?>" alt="Logo">
                    <img class="navbar-brand-logo-mini initial--36 onerror-image"
                        data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                        src="<?php echo e($store_data->logo_full_url); ?>" alt="Logo">
                </a>
                <!-- End Logo -->

                <!-- Navbar Vertical Toggle -->
                <button type="button"
                    class="js-navbar-vertical-aside-toggle-invoker navbar-vertical-aside-toggle btn btn-icon btn-xs btn-ghost-dark">
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
            <div class="navbar-vertical-content text-capitalize bg--005555" id="navbar-vertical-content">
                <form class="sidebar--search-form">
                    <div class="search--form-group">
                        <button type="button" class="btn"><i class="tio-search"></i></button>
                        <input type="text" class="form-control form--control"
                            placeholder="<?php echo e(translate('messages.Search Menu...')); ?>" id="search-sidebar-menu">
                    </div>
                </form>
                <ul class="navbar-nav navbar-nav-lg nav-tabs">
                    <!-- Dashboards -->
                    <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('vendor-panel/provider-dashboard*') ? 'active' : ''); ?>">
                        <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('vendor.providerDashboard')); ?>"
                            title="<?php echo e(translate('messages.dashboard')); ?>">
                            <i class="tio-home-vs-1-outlined nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                <?php echo e(translate('messages.dashboard')); ?>

                            </span>
                        </a>
                    </li>

                    <?php
                    $tripCount = Illuminate\Support\Facades\DB::select("SELECT
                            COUNT(*) AS total_trips,
                            COALESCE(SUM(CASE WHEN scheduled = 1 THEN 1 ELSE 0 END), 0) AS scheduled_trips,
                            COALESCE(SUM(CASE WHEN trip_status = 'pending' THEN 1 ELSE 0 END), 0) AS pending_trips,
                            COALESCE(SUM(CASE WHEN trip_status = 'confirmed' THEN 1 ELSE 0 END), 0) AS confirmed_trips,
                            COALESCE(SUM(CASE WHEN trip_status = 'ongoing' THEN 1 ELSE 0 END), 0) AS ongoing_trips,
                            COALESCE(SUM(CASE WHEN trip_status = 'completed' THEN 1 ELSE 0 END), 0) AS completed_trips,
                            COALESCE(SUM(CASE WHEN trip_status = 'canceled' THEN 1 ELSE 0 END), 0) AS canceled_trips,
                            COALESCE(SUM(CASE WHEN trip_status = 'payment_failed' THEN 1 ELSE 0 END), 0) AS payment_failed_trips
                        FROM trips
                        WHERE provider_id = :provider_id", ['provider_id' => \App\CentralLogics\Helpers::get_store_id()]);

                    $tripCount = (array) $tripCount[0];
                    ?>

                    <?php if(\App\CentralLogics\Helpers::employee_module_permission_check('trip')): ?>
                        <li class="nav-item">
                            <small class="nav-subtitle"><?php echo e(translate('messages.Trip_management')); ?></small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>

                        <li
                            class="navbar-vertical-aside-has-menu <?php echo e(Request::is('vendor-panel/trip*') ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                                title="<?php echo e(translate('messages.Trips')); ?>">
                                <i class="tio-taxi nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    <?php echo e(translate('messages.Trips')); ?>

                                </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                                <li class="nav-item <?php echo e(request()->status == 'all' ? 'active' : ''); ?>">
                                    <a class="nav-link" href="<?php echo e(route('vendor.trip.list')); ?>?status=all"
                                        title="<?php echo e(translate('messages.all_trips')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                            <?php echo e(translate('messages.all')); ?>

                                            <span class="badge badge-soft-info badge-pill ml-1">
                                                <?php echo e($tripCount['total_trips']); ?>

                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo e(request()->status == 'scheduled' ? 'active' : ''); ?>">
                                    <a class="nav-link" href="<?php echo e(route('vendor.trip.list')); ?>?status=scheduled"
                                        title="<?php echo e(translate('messages.scheduled_trips')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                            <?php echo e(translate('messages.scheduled')); ?>

                                            <span class="badge badge-soft-info badge-pill ml-1">
                                                <?php echo e($tripCount['scheduled_trips']); ?>

                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo e(request()->status == 'pending' ? 'active' : ''); ?> <?php echo $__env->yieldContent('pending'); ?>">
                                    <a class="nav-link " href="<?php echo e(route('vendor.trip.list')); ?>?status=pending"
                                        title="<?php echo e(translate('messages.pending_trips')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                            <?php echo e(translate('messages.pending')); ?>

                                            <span class="badge badge-soft-info badge-pill ml-1">
                                                <?php echo e($tripCount['pending_trips']); ?>

                                            </span>
                                        </span>
                                    </a>
                                </li>

                                <li class="nav-item <?php echo e(request()->status == 'confirmed' ? 'active' : ''); ?>  <?php echo $__env->yieldContent('confirmed'); ?>">
                                    <a class="nav-link " href="<?php echo e(route('vendor.trip.list')); ?>?status=confirmed"
                                        title="<?php echo e(translate('messages.confirmed_trips')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                            <?php echo e(translate('messages.confirmed')); ?>

                                            <span class="badge badge-soft-info badge-pill ml-1">
                                                <?php echo e($tripCount['confirmed_trips']); ?>

                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo e(request()->status == 'ongoing' ? 'active' : ''); ?> <?php echo $__env->yieldContent('ongoing'); ?>">
                                    <a class="nav-link " href="<?php echo e(route('vendor.trip.list')); ?>?status=ongoing"
                                        title="<?php echo e(translate('messages.Ongoing_trips')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                            <?php echo e(translate('messages.Ongoing')); ?>

                                            <span class="badge badge-soft-info badge-pill ml-1">
                                                <?php echo e($tripCount['ongoing_trips']); ?>

                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo e(request()->status == 'completed' ? 'active' : ''); ?> <?php echo $__env->yieldContent('completed'); ?>">
                                    <a class="nav-link text-capitalize"
                                        href="<?php echo e(route('vendor.trip.list')); ?>?status=completed"
                                        title="<?php echo e(translate('messages.Completed_trips')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                            <?php echo e(translate('messages.Completed')); ?>

                                            <span class="badge badge-soft-success badge-pill ml-1">
                                                <?php echo e($tripCount['completed_trips']); ?>

                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo e(request()->status == 'canceled' ? 'active' : ''); ?> <?php echo $__env->yieldContent('canceled'); ?>">
                                    <a class="nav-link " href="<?php echo e(route('vendor.trip.list')); ?>?status=canceled"
                                        title="<?php echo e(translate('messages.canceled_trips')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                            <?php echo e(translate('messages.canceled')); ?>

                                            <span class="badge badge-soft-danger  badge-pill ml-1">
                                                <?php echo e($tripCount['canceled_trips']); ?>

                                            </span>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo e(request()->status == 'payment_failed' ? 'active' : ''); ?>  <?php echo $__env->yieldContent('payment_failed'); ?>">
                                    <a class="nav-link "
                                        href="<?php echo e(route('vendor.trip.list')); ?>?status=payment_failed"
                                        title="<?php echo e(translate('messages.payment_failed_trips')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container text-capitalize">
                                            <?php echo e(translate('messages.payment_failed')); ?>

                                            <span class="badge badge-soft-danger  badge-pill ml-1">
                                                <?php echo e($tripCount['payment_failed_trips']); ?>

                                            </span>
                                        </span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <!-- Order refund End-->
                    <?php endif; ?>

                    <?php if(\App\CentralLogics\Helpers::employee_module_permission_check('vehicle')): ?>
                        <li class="nav-item">
                            <small class="nav-subtitle"><?php echo e(translate('messages.vehicle_management')); ?></small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>
                        <li
                            class="navbar-vertical-aside-has-menu <?php echo e(Request::is('vendor-panel/vehicle/*') ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                                title="<?php echo e(translate('Vehicle Setup')); ?>">
                                <i class="tio-car nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate text-capitalize"><?php echo e(translate('Vehicle Setup')); ?></span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                                <li
                                    class="nav-item <?php echo e(Request::is('vendor-panel/vehicle/create')  ? 'active' : ''); ?>">
                                    <a class="nav-link " href="<?php echo e(route('vendor.vehicle.create')); ?>"
                                        title="<?php echo e(translate('messages.create_new')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate"><?php echo e(translate('messages.create_new')); ?></span>
                                    </a>
                                </li>
                                <li
                                    class="nav-item <?php echo e(Request::is('vendor-panel/vehicle/list') || Request::is('vendor-panel/vehicle/details/*')|| Request::is('vendor-panel/vehicle/update/*') ? 'active' : ''); ?>">
                                    <a class="nav-link " href="<?php echo e(route('vendor.vehicle.list')); ?>"
                                        title="<?php echo e(translate('messages.vehicle_list')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate"><?php echo e(translate('messages.list')); ?></span>
                                    </a>
                                </li>
                                <li
                                    class="nav-item <?php echo e(Request::is('vendor-panel/vehicle/bulk-import') ? 'active' : ''); ?>">
                                    <a class="nav-link " href="<?php echo e(route('vendor.vehicle.bulk_import')); ?>"
                                        title="<?php echo e(translate('messages.bulk_import')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span
                                            class="text-truncate text-capitalize"><?php echo e(translate('messages.bulk_import')); ?></span>
                                    </a>
                                </li>
                                <li
                                    class="nav-item <?php echo e(Request::is('vendor-panel/vehicle/bulk-export') ? 'active' : ''); ?>">
                                    <a class="nav-link " href="<?php echo e(route('vendor.vehicle.bulk-export-index')); ?>"
                                        title="<?php echo e(translate('messages.bulk_export')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span
                                            class="text-truncate text-capitalize"><?php echo e(translate('messages.bulk_export')); ?></span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li
                            class="navbar-vertical-aside-has-menu <?php echo e(Request::is('vendor-panel/vehicle-category*') ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="<?php echo e(route('vendor.vehicle_category.list')); ?>"
                                title="<?php echo e(translate('messages.category list')); ?>">
                                <i class="tio-category nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    <?php echo e(translate('messages.categories')); ?>

                                </span>
                            </a>
                        </li>

                        <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('vendor-panel/vehicle-brand*') ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="<?php echo e(route('vendor.vehicle_brand.list')); ?>" title="<?php echo e(translate('messages.Brand list')); ?>">
                                <i class="tio-medal nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    <?php echo e(translate('messages.Brands')); ?>

                                </span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if(\App\CentralLogics\Helpers::employee_module_permission_check('driver')): ?>
                    <!-- driver -->
                        <li class="nav-item">
                            <small class="nav-subtitle"
                                title="<?php echo e(translate('messages.driver_section')); ?>"><?php echo e(translate('messages.driver_section')); ?></small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>
                        <li
                            class="navbar-vertical-aside-has-menu <?php echo e(Request::is('vendor-panel/driver/create') ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="<?php echo e(route('vendor.driver.create')); ?>"
                                title="<?php echo e(translate('messages.add_driver')); ?>">
                                <i class="tio-running nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    <?php echo e(translate('messages.add_driver')); ?>

                                </span>
                            </a>
                        </li>

                        <li
                            class="navbar-vertical-aside-has-menu <?php echo e(Request::is('vendor-panel/driver/list') || Request::is('vendor-panel/driver/details/*') || Request::is('vendor-panel/driver/update/*') ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="<?php echo e(route('vendor.driver.list')); ?>" title="<?php echo e(translate('messages.driver')); ?>">
                                <i class="tio-filter-list nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    <?php echo e(translate('messages.driver list')); ?>

                                </span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if(\App\CentralLogics\Helpers::employee_module_permission_check('marketing')): ?>
                        <li class="nav-item">
                            <small class="nav-subtitle"><?php echo e(translate('messages.marketing_section')); ?></small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>

                        <li
                            class="navbar-vertical-aside-has-menu <?php echo e(Request::is('vendor-panel/rental-coupon*') ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="<?php echo e(route('vendor.rental_coupon.list')); ?>"
                                title="<?php echo e(translate('messages.coupons')); ?>">
                                <i class="tio-ticket nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.coupons')); ?></span>
                            </a>
                        </li>
                        <li
                            class="navbar-vertical-aside-has-menu <?php echo e(Request::is('vendor-panel/rental-banner*') ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="<?php echo e(route('vendor.rental_banner.list')); ?>"
                                title="<?php echo e(translate('messages.banners')); ?>">
                                <i class="tio-image nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.banners')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <small class="nav-subtitle"
                            title="<?php echo e(translate('messages.business_section')); ?>"><?php echo e(translate('messages.business_section')); ?></small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>

                    <?php if(\App\CentralLogics\Helpers::employee_module_permission_check('store_setup')): ?>
                        <li
                            class="nav-item <?php echo e(Request::is('vendor-panel/business-settings/store-setup') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('vendor.business-settings.store-setup')); ?>"
                                title="<?php echo e(translate('messages.Provider_Config')); ?>">
                                <span class="tio-settings nav-icon"></span>
                                <span class="text-truncate"><?php echo e(translate('messages.Provider_Config')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if(\App\CentralLogics\Helpers::employee_module_permission_check('store_setup')): ?>
                    <li
                        class="navbar-vertical-aside-has-menu <?php echo e(Request::is('vendor-panel/business-settings/notification-setup') ? 'active' : ''); ?>">
                        <a class="nav-link " href="<?php echo e(route('vendor.business-settings.notification-setup')); ?>"
                            title="<?php echo e(translate('messages.notification_setup')); ?>">
                            <span class="tio-notifications nav-icon"></span>
                            <span class="text-truncate"><?php echo e(translate('messages.notification_setup')); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php if(\App\CentralLogics\Helpers::employee_module_permission_check('my_shop')): ?>
                        <li
                            class="navbar-vertical-aside-has-menu <?php echo e(Request::is('vendor-panel/store/*') ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="<?php echo e(route('vendor.shop.view')); ?>"
                                title="<?php echo e(translate('messages.my_shop')); ?>">
                                <i class="tio-home nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    <?php echo e(translate('messages.my_shop')); ?>

                                </span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if(\App\CentralLogics\Helpers::employee_module_permission_check('store_setup')): ?>
                    <li class="navbar-vertical-aside-has-menu <?php echo $__env->yieldContent('subscriberList'); ?>">
                        <a class="js-navbar-vertical-aside-menu-link nav-link"
                            href="<?php echo e(route('vendor.subscriptionackage.subscriberDetail')); ?>"
                            title="<?php echo e(translate('messages.My_Subscription')); ?>">
                            <i class="tio-crown nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                <?php echo e(translate('messages.My_Business_Plan')); ?>

                            </span>
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php if(\App\CentralLogics\Helpers::employee_module_permission_check('wallet')): ?>
                        <!-- StoreWallet -->
                        <li
                            class="navbar-vertical-aside-has-menu <?php echo e(Request::is('vendor-panel/wallet') ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="<?php echo e(route('vendor.wallet.index')); ?>"
                                title="<?php echo e(translate('messages.my_wallet')); ?>">
                                <i class="tio-table nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.my_wallet')); ?></span>
                            </a>
                        </li>


                        <li
                            class="navbar-vertical-aside-has-menu <?php echo e(Request::is('vendor-panel/withdraw-method*') ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="<?php echo e(route('vendor.wallet-method.index')); ?>"
                                title="<?php echo e(translate('messages.my_wallet')); ?>">
                                <i class="tio-museum nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.disbursement_method')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if(\App\CentralLogics\Helpers::employee_module_permission_check('reviews')): ?>
                        <li
                            class="navbar-vertical-aside-has-menu <?php echo e(Request::is('vendor-panel/rental-reviews') ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="<?php echo e(route('vendor.rental.reviews')); ?>" title="<?php echo e(translate('messages.reviews')); ?>">
                                <i class="tio-star-outlined nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    <?php echo e(translate('messages.reviews')); ?>

                                </span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if(\App\CentralLogics\Helpers::employee_module_permission_check('chat')): ?>
                        <li
                            class="navbar-vertical-aside-has-menu <?php echo e(Request::is('vendor-panel/message*') ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="<?php echo e(route('vendor.message.list')); ?>"
                                title="<?php echo e(translate('messages.chat')); ?>">
                                <i class="tio-chat nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                    <?php echo e(translate('messages.Chat')); ?>

                                </span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if(\App\CentralLogics\Helpers::employee_module_permission_check('report')): ?>
                        <li class="nav-item">
                            <small class="nav-subtitle"
                                       title="<?php echo e(translate('messages.Report_section')); ?>"><?php echo e(translate('messages.Report_section')); ?></small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>

                        <li
                            class="navbar-vertical-aside-has-menu <?php echo e(Request::is('vendor-panel/report/expense-report') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('vendor.report.expense-report')); ?>"
                                title="<?php echo e(translate('messages.expense_report')); ?>">
                                <span class="tio-money nav-icon"></span>
                                <span class="text-truncate"><?php echo e(translate('messages.expense_report')); ?></span>
                            </a>
                        </li>

                        <li
                            class="navbar-vertical-aside-has-menu <?php echo e(Request::is('vendor-panel/report/disbursement-report') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('vendor.report.disbursement-report')); ?>"
                                title="<?php echo e(translate('messages.disbursement_report')); ?>">
                                <span class="tio-saving nav-icon"></span>
                                <span class="text-truncate"><?php echo e(translate('messages.disbursement_report')); ?></span>
                            </a>
                        </li>
                        <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('vendor-panel/report/trip-report') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('vendor.report.trip-report')); ?>"
                               title="<?php echo e(translate('messages.trip_report')); ?>">
                                <span class="tio-chart-bar-4 nav-icon"></span>
                                <span class="text-truncate"><?php echo e(translate('messages.trip_report')); ?></span>
                            </a>
                        </li>
                           <li class="navbar-vertical-aside-has-menu <?php echo $__env->yieldContent('vendor_tax_report'); ?>">
                        <a class="nav-link " href="<?php echo e(route('vendor.report.providerTax')); ?>"
                           title="<?php echo e(translate('Vat_Report')); ?>">
                            <span class="tio-saving nav-icon"></span>
                            <span class="text-truncate"><?php echo e(translate('messages.Vat_Report')); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php if(\App\CentralLogics\Helpers::employee_module_permission_check('employee')): ?>
                        <li class="nav-item">
                            <small class="nav-subtitle"
                                title="<?php echo e(translate('messages.employee_section')); ?>"><?php echo e(translate('messages.employee_section')); ?></small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>
                        <li
                            class="navbar-vertical-aside-has-menu <?php echo e(Request::is('vendor-panel/custom-role*') ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                                href="<?php echo e(route('vendor.custom-role.list')); ?>"
                                title="<?php echo e(translate('messages.employee_Role')); ?>">
                                <i class="tio-incognito nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.employee_Role')); ?></span>
                            </a>
                        </li>
                        <li
                            class="navbar-vertical-aside-has-menu <?php echo e(Request::is('vendor-panel/employee*') ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                                title="<?php echo e(translate('messages.employees')); ?>">
                                <i class="tio-user nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.employees')); ?></span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                                <li class="nav-item <?php echo e(Request::is('vendor-panel/employee/add-new') ? 'active' : ''); ?>">
                                    <a class="nav-link " href="<?php echo e(route('vendor.employee.add-new')); ?>"
                                        title="<?php echo e(translate('messages.add_new_Employee')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate"><?php echo e(translate('messages.add_new')); ?></span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo e(Request::is('vendor-panel/employee/list') ? 'active' : ''); ?>">
                                    <a class="nav-link " href="<?php echo e(route('vendor.employee.list')); ?>"
                                        title="<?php echo e(translate('messages.Employee_list')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate"><?php echo e(translate('messages.list')); ?></span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <!-- End Content -->
        </div>
    </aside>
</div>

<div id="sidebarCompact" class="d-none">

</div>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('Modules/Rental/public/assets/js/view-pages/provider/sidebar.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/provider/partials/_sidebar_rental.blade.php ENDPATH**/ ?>