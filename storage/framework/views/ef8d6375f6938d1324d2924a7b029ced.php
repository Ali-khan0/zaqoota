<div id="sidebarMain" class="d-none">
    <aside class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered  ">
        <div class="navbar-vertical-container">
            <div class="navbar-brand-wrapper justify-content-between">
                <!-- Logo -->
                <?php ($store_logo = \App\Models\BusinessSetting::where(['key' => 'logo'])->first()); ?>
                <a class="navbar-brand" href="<?php echo e(route('admin.dispatch.dashboard')); ?>" aria-label="Front">
                       <img class="navbar-brand-logo initial--36 onerror-image onerror-image" data-onerror-image="<?php echo e(asset('assets/admin/img/160x160/img2.jpg')); ?>"
                    src="<?php echo e(\App\CentralLogics\Helpers::get_full_url('business', $store_logo?->value?? '', $store_logo?->storage[0]?->value ?? 'public','favicon')); ?>"
                    alt="Logo">
                    <img class="navbar-brand-logo-mini initial--36 onerror-image onerror-image" data-onerror-image="<?php echo e(asset('assets/admin/img/160x160/img2.jpg')); ?>"
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
                <form class="sidebar--search-form">
                    <div class="search--form-group">
                        <button type="button" class="btn"><i class="tio-search"></i></button>
                        <input type="text" class="form-control form--control" placeholder="<?php echo e(translate('Search Menu...')); ?>" id="search-sidebar-menu">
                    </div>
                </form>
                <ul class="navbar-nav navbar-nav-lg nav-tabs">
                    <!-- Dashboards -->
                    <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin') ? 'show active' : ''); ?>">
                        <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.dashboard')); ?>?module_id=<?php echo e(Config::get('module.current_module_id')); ?>" title="<?php echo e(translate('messages.dashboard')); ?>">
                            <i class="tio-home-vs-1-outlined nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                <?php echo e(translate('messages.dashboard')); ?>

                            </span>
                        </a>
                    </li>
                    <!-- End Dashboards -->

                    <!-- Marketing section -->
                    <li class="nav-item">
                        <small class="nav-subtitle" title="<?php echo e(translate('messages.employee_handle')); ?>"><?php echo e(translate('pos section')); ?></small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>
                    <!-- Pos -->
                    <?php if(\App\CentralLogics\Helpers::module_permission_check('pos')): ?>
                    <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/pos*')?'active':''); ?>">
                        <a class="js-navbar-vertical-aside-menu-link nav-link " href="<?php echo e(route('admin.pos.index')); ?>" title="<?php echo e(translate('New Sale')); ?>">
                            <i class="tio-shopping-basket-outlined nav-icon"></i>
                            <span class="text-truncate"><?php echo e(translate('New Sale')); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <!-- Pos -->

                    <li class="nav-item">
                        <small class="nav-subtitle" title="<?php echo e(translate('messages.module_section')); ?>"><?php echo e(translate('messages.module_management')); ?></small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>

                    <?php if(\App\CentralLogics\Helpers::module_permission_check('zone')): ?>
                    <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/zone*') ? 'active' : ''); ?>">
                        <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.zone.home')); ?>" title="<?php echo e(translate('messages.zone_setup')); ?>">
                            <i class="tio-city nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                <?php echo e(translate('messages.zone_setup')); ?> </span>
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php if(\App\CentralLogics\Helpers::module_permission_check('module')): ?>
                    <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/module') ? 'active' : ''); ?>">
                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" title="<?php echo e(translate('messages.system_module_setup')); ?>">
                            <i class="tio-globe nav-icon"></i>
                            <span class="text-truncate"><?php echo e(translate('messages.system_module_setup')); ?></span>
                        </a>
                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="display:<?php echo e(Request::is('admin/module*') ? 'block' : 'none'); ?>">
                            <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/module/create') ? 'active' : ''); ?>">
                                <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.module.create')); ?>" title="<?php echo e(translate('messages.add_module')); ?>">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">
                                        <?php echo e(translate('messages.add_module')); ?>

                                    </span>
                                </a>
                            </li>
                            <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/module') ? 'active' : ''); ?>">
                                <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.module.index')); ?>" title="<?php echo e(translate('messages.modules')); ?>">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">
                                        <?php echo e(translate('messages.modules')); ?>

                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <?php endif; ?>

                <!-- Marketing section -->
                <li class="nav-item">
                    <small class="nav-subtitle" title="<?php echo e(translate('messages.employee_handle')); ?>"><?php echo e(translate('Promotions')); ?></small>
                    <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>
                <!-- Campaign -->
                <?php if(\App\CentralLogics\Helpers::module_permission_check('campaign')): ?>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/campaign') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" title="<?php echo e(translate('messages.campaigns')); ?>">
                        <i class="tio-layers-outlined nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.campaigns')); ?></span>
                    </a>
                    <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="display:<?php echo e(Request::is('admin/campaign*') ? 'block' : 'none'); ?>">

                        <li class="nav-item <?php echo e(Request::is('admin/campaign/basic/*') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.campaign.list', 'basic')); ?>" title="<?php echo e(translate('messages.basic_campaigns')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate"><?php echo e(translate('messages.basic_campaigns')); ?></span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo e(Request::is('admin/campaign/item/*') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.campaign.list', 'item')); ?>" title="<?php echo e(translate('messages.item_campaigns')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate"><?php echo e(translate('messages.item_campaigns')); ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
                <!-- End Campaign -->
                <!-- Banner -->
                <?php if(\App\CentralLogics\Helpers::module_permission_check('banner')): ?>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/banner*') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.banner.add-new')); ?>" title="<?php echo e(translate('messages.banners')); ?>">
                        <i class="tio-image nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.banners')); ?></span>
                    </a>
                </li>
                <?php endif; ?>
                <!-- End Banner -->
                <!-- Coupon -->
                <?php if(\App\CentralLogics\Helpers::module_permission_check('coupon')): ?>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/coupon*') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.coupon.add-new')); ?>" title="<?php echo e(translate('messages.coupons')); ?>">
                        <i class="tio-gift nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.coupons')); ?></span>
                    </a>
                </li>
                <?php endif; ?>
                <!-- End Coupon -->
                 <?php if(\App\CentralLogics\Helpers::module_permission_check('cashback')): ?>
                 <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/cashback*') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.cashback.add-new')); ?>" title="<?php echo e(translate('messages.cashback')); ?>">
                        <i class="tio-settings-back nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.cashback')); ?></span>
                    </a>
                </li>
                <?php endif; ?>
                <!-- Notification -->
                <?php if(\App\CentralLogics\Helpers::module_permission_check('notification')): ?>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/notification*') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.notification.add-new')); ?>" title="<?php echo e(translate('messages.push_notification')); ?>">
                        <i class="tio-notifications nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                            <?php echo e(translate('messages.push_notification')); ?>

                        </span>
                    </a>
                </li>
                <?php endif; ?>
                <!-- End Notification -->

                <!-- End marketing section -->
                    <!-- Orders -->
                    <?php if(\App\CentralLogics\Helpers::module_permission_check('order')): ?>
                    <li class="nav-item">
                        <small class="nav-subtitle"><?php echo e(translate('messages.order_management')); ?></small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>

                    <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/order') ? 'active' : ''); ?>">
                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" title="<?php echo e(translate('messages.orders')); ?>">
                            <i class="tio-shopping-cart nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                <?php echo e(translate('messages.orders')); ?>

                            </span>
                        </a>
                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="display:<?php echo e(Request::is('admin/order*') ? 'block' : 'none'); ?>">
                            <li class="nav-item <?php echo e(Request::is('admin/order/list/all') ? 'active' : ''); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.order.list', ['all'])); ?>" title="<?php echo e(translate('messages.all_orders')); ?>">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate sidebar--badge-container">
                                        <?php echo e(translate('messages.all')); ?>

                                        <span class="badge badge-soft-info badge-pill ml-1">
                                            <?php echo e(\App\Models\Order::StoreOrder()->count()); ?>

                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item <?php echo e(Request::is('admin/order/list/scheduled') ? 'active' : ''); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.order.list', ['scheduled'])); ?>" title="<?php echo e(translate('messages.scheduled_orders')); ?>">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate sidebar--badge-container">
                                        <?php echo e(translate('messages.scheduled')); ?>

                                        <span class="badge badge-soft-info badge-pill ml-1">
                                            <?php echo e(\App\Models\Order::Scheduled()->StoreOrder()->count()); ?>

                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item <?php echo e(Request::is('admin/order/list/pending') ? 'active' : ''); ?>">
                                <a class="nav-link " href="<?php echo e(route('admin.order.list', ['pending'])); ?>" title="<?php echo e(translate('messages.pending_orders')); ?>">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate sidebar--badge-container">
                                        <?php echo e(translate('messages.pending')); ?>

                                        <span class="badge badge-soft-info badge-pill ml-1">
                                            <?php echo e(\App\Models\Order::Pending()->OrderScheduledIn(30)->StoreOrder()->count()); ?>

                                        </span>
                                    </span>
                                </a>
                            </li>

                            <li class="nav-item <?php echo e(Request::is('admin/order/list/accepted') ? 'active' : ''); ?>">
                                <a class="nav-link " href="<?php echo e(route('admin.order.list', ['accepted'])); ?>" title="<?php echo e(translate('messages.accepted_orders')); ?>">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate sidebar--badge-container">
                                        <?php echo e(translate('messages.accepted')); ?>

                                        <span class="badge badge-soft-success badge-pill ml-1">
                                            <?php echo e(\App\Models\Order::AccepteByDeliveryman()->OrderScheduledIn(30)->StoreOrder()->count()); ?>

                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item <?php echo e(Request::is('admin/order/list/processing') ? 'active' : ''); ?>">
                                <a class="nav-link " href="<?php echo e(route('admin.order.list', ['processing'])); ?>" title="<?php echo e(translate('messages.processing_orders')); ?>">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate sidebar--badge-container">
                                        <?php echo e(translate('messages.processing')); ?>

                                        <span class="badge badge-soft-warning badge-pill ml-1">
                                            <?php echo e(\App\Models\Order::Preparing()->OrderScheduledIn(30)->StoreOrder()->count()); ?>

                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item <?php echo e(Request::is('admin/order/list/item_on_the_way') ? 'active' : ''); ?>">
                                <a class="nav-link text-capitalize" href="<?php echo e(route('admin.order.list', ['item_on_the_way'])); ?>" title="<?php echo e(translate('messages.order_on_the_way')); ?>">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate sidebar--badge-container">
                                        <?php echo e(translate('messages.order_on_the_way')); ?>

                                        <span class="badge badge-soft-warning badge-pill ml-1">
                                            <?php echo e(\App\Models\Order::ItemOnTheWay()->OrderScheduledIn(30)->StoreOrder()->count()); ?>

                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item <?php echo e(Request::is('admin/order/list/delivered') ? 'active' : ''); ?>">
                                <a class="nav-link " href="<?php echo e(route('admin.order.list', ['delivered'])); ?>" title="<?php echo e(translate('messages.delivered_orders')); ?>">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate sidebar--badge-container">
                                        <?php echo e(translate('messages.delivered')); ?>

                                        <span class="badge badge-soft-success badge-pill ml-1">
                                            <?php echo e(\App\Models\Order::Delivered()->StoreOrder()->count()); ?>

                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item <?php echo e(Request::is('admin/order/list/canceled') ? 'active' : ''); ?>">
                                <a class="nav-link " href="<?php echo e(route('admin.order.list', ['canceled'])); ?>" title="<?php echo e(translate('messages.canceled_orders')); ?>">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate sidebar--badge-container">
                                        <?php echo e(translate('messages.canceled')); ?>

                                        <span class="badge badge-soft-warning bg-light badge-pill ml-1">
                                            <?php echo e(\App\Models\Order::Canceled()->StoreOrder()->count()); ?>

                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item <?php echo e(Request::is('admin/order/list/failed') ? 'active' : ''); ?>">
                                <a class="nav-link " href="<?php echo e(route('admin.order.list', ['failed'])); ?>" title="<?php echo e(translate('messages.payment_failed_orders')); ?>">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate sidebar--badge-container text-capitalize">
                                        <?php echo e(translate('messages.payment_failed')); ?>

                                        <span class="badge badge-soft-danger bg-light badge-pill ml-1">
                                            <?php echo e(\App\Models\Order::failed()->StoreOrder()->count()); ?>

                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item <?php echo e(Request::is('admin/order/list/refunded') ? 'active' : ''); ?>">
                                <a class="nav-link " href="<?php echo e(route('admin.order.list', ['refunded'])); ?>" title="<?php echo e(translate('messages.refunded_orders')); ?>">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate sidebar--badge-container">
                                        <?php echo e(translate('messages.refunded')); ?>

                                        <span class="badge badge-soft-danger bg-light badge-pill ml-1">
                                            <?php echo e(\App\Models\Order::Refunded()->StoreOrder()->count()); ?>

                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item <?php echo e(Request::is('admin/order/offline/payment/list*') ? 'active' : ''); ?>">
                                <a class="nav-link " href="<?php echo e(route('admin.order.offline_verification_list', ['all'])); ?>" title="<?php echo e(translate('Offline_Payments')); ?>">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate sidebar--badge-container">
                                        <?php echo e(translate('messages.Offline_Payments')); ?>

                                        <span class="badge badge-soft-danger bg-light badge-pill ml-1">
                                            <?php echo e(\App\Models\Order::has('offline_payments')->StoreOrder()->module(Config::get('module.current_module_id'))->count()); ?>

                                        </span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Order refund -->
                    <li
                    class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/refund/*') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                        title="<?php echo e(translate('Order Refunds')); ?>">
                        <i class="tio-receipt nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                            <?php echo e(translate('Order Refunds')); ?>

                        </span>
                    </a>
                    <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                        style="display: <?php echo e(Request::is('admin/refund*') ? 'block' : 'none'); ?>">

                        <li class="nav-item <?php echo e(Request::is('admin/refund/requested') ||  Request::is('admin/refund/rejected') ||Request::is('admin/refund/refunded') ? 'active' : ''); ?>">
                            <a class="nav-link "
                                href="<?php echo e(route('admin.refund.refund_attr', ['requested'])); ?>"
                                title="<?php echo e(translate('Refund Requests')); ?> ">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate sidebar--badge-container">
                                    <?php echo e(translate('Refund Requests')); ?>

                                    <span class="badge badge-soft-danger badge-pill ml-1">
                                        <?php echo e(\App\Models\Order::Refund_requested()->StoreOrder()->count()); ?>

                                    </span>
                                </span>
                            </a>
                        </li>

                         
                    </ul>
                    </li>
                    <!-- Order refund End-->

                    <!-- Order dispachment -->
                    <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/dispatch/*') ? 'active' : ''); ?>">
                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" title="<?php echo e(translate('messages.dispatch')); ?>">
                            <i class="tio-clock nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                <?php echo e(translate('messages.dispatch')); ?>

                            </span>
                        </a>
                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="<?php echo e(Request::is('admin/dispatch*') ? 'display-block' : 'display-none'); ?>">
                            <li class="nav-item <?php echo e(Request::is('admin/dispatch/list/searching_for_deliverymen') ? 'active' : ''); ?>">
                                <a class="nav-link " href="<?php echo e(route('admin.dispatch.list', ['searching_for_deliverymen'])); ?>" title="<?php echo e(translate('messages.unassigned_orders')); ?>">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate sidebar--badge-container">
                                        <?php echo e(translate('messages.unassigned_orders')); ?>

                                        <span class="badge badge-soft-info badge-pill ml-1">
                                            <?php echo e(\App\Models\Order::SearchingForDeliveryman()->OrderScheduledIn(30)->StoreOrder()->count()); ?>

                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item <?php echo e(Request::is('admin/dispatch/list/on_going') ? 'active' : ''); ?>">
                                <a class="nav-link " href="<?php echo e(route('admin.dispatch.list', ['on_going'])); ?>" title="<?php echo e(translate('messages.ongoingOrders')); ?>">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate sidebar--badge-container">
                                        <?php echo e(translate('messages.ongoingOrders')); ?>

                                        <span class="badge badge-soft-light badge-pill ml-1">
                                            <?php echo e(\App\Models\Order::Ongoing()->OrderScheduledIn(30)->StoreOrder()->count()); ?>

                                        </span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Order dispachment End-->
                    <?php endif; ?>
                    <!-- End Orders -->



                    <!-- Parcel Section -->
                    <li class="nav-item">
                        <small class="nav-subtitle" title="<?php echo e(translate('messages.parcel_section')); ?>"><?php echo e(translate('messages.parcel_management')); ?></small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>

                    <?php if(\App\CentralLogics\Helpers::module_permission_check('parcel')): ?>
                    <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/parcel*') ? 'active' : ''); ?>">
                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" title="<?php echo e(translate('messages.parcel')); ?>">
                            <i class="tio-bus nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.parcel')); ?></span>
                        </a>
                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="display:<?php echo e(Request::is('admin/parcel*') ? 'block' : 'none'); ?>">
                            <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/parcel/category') ? 'active' : ''); ?>">
                                <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.parcel.category.index')); ?>" title="<?php echo e(translate('messages.parcel_category')); ?>">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">
                                        <?php echo e(translate('messages.parcel_category')); ?>

                                    </span>
                                </a>
                            </li>
                            <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/parcel/orders*') ? 'active' : ''); ?>">
                                <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.parcel.orders')); ?>" title="<?php echo e(translate('messages.parcel_orders')); ?>">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">
                                        <?php echo e(translate('messages.parcel_orders')); ?>

                                    </span>
                                </a>
                            </li>

                            <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/parcel/settings') ? 'active' : ''); ?>">
                                <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.parcel.settings')); ?>" title="<?php echo e(translate('messages.parcel_settings')); ?>">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">
                                        <?php echo e(translate('messages.parcel_settings')); ?>

                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <?php endif; ?>
                    <!--End Parcel Section -->

                    <li class="nav-item">
                        <small class="nav-subtitle" title="<?php echo e(translate('messages.item_section')); ?>"><?php echo e(translate('messages.item_management')); ?></small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>

                    <!-- Category -->
                    <?php if(\App\CentralLogics\Helpers::module_permission_check('category')): ?>
                    <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/category*') ? 'active' : ''); ?>">
                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" title="<?php echo e(translate('messages.categories')); ?>">
                            <i class="tio-category nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.categories')); ?></span>
                        </a>
                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub"  style="display:<?php echo e(Request::is('admin/category*') ? 'block' : 'none'); ?>">
                            <li class="nav-item <?php echo $__env->yieldContent('main_category'); ?> <?php echo e(Request::is('admin/category/add') ? 'active' : ''); ?>">
                                <a class="nav-link " href="<?php echo e(route('admin.category.add')); ?>" title="<?php echo e(translate('messages.category')); ?>">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate"><?php echo e(translate('messages.category')); ?></span>
                                </a>
                            </li>

                            <li class="nav-item <?php echo $__env->yieldContent('sub_category'); ?> <?php echo e(Request::is('admin/category/add-sub-category') ? 'active' : ''); ?>">
                                <a class="nav-link " href="<?php echo e(route('admin.category.add-sub-category')); ?>" title="<?php echo e(translate('messages.sub_category')); ?>">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate"><?php echo e(translate('messages.sub_category')); ?></span>
                                </a>
                            </li>

                            
                        <li class="nav-item <?php echo e(Request::is('admin/category/bulk-import') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.category.bulk-import')); ?>" title="<?php echo e(translate('messages.bulk_import')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate text-capitalize"><?php echo e(translate('messages.bulk_import')); ?></span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo e(Request::is('admin/category/bulk-export') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.category.bulk-export-index')); ?>" title="<?php echo e(translate('messages.bulk_export')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate text-capitalize"><?php echo e(translate('messages.bulk_export')); ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
                <!-- End Category -->

                <!-- Attributes -->
                <?php if(\App\CentralLogics\Helpers::module_permission_check('attribute')): ?>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/attribute*') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.attribute.add-new')); ?>" title="<?php echo e(translate('messages.attributes')); ?>">
                        <i class="tio-apps nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                            <?php echo e(translate('messages.attributes')); ?>

                        </span>
                    </a>
                </li>
                <?php endif; ?>
                <!-- End Attributes -->

                <!-- Unit -->
                <?php if(\App\CentralLogics\Helpers::module_permission_check('unit')): ?>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/unit*') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.unit.index')); ?>" title="<?php echo e(translate('messages.units')); ?>">
                        <i class="tio-ruler nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate text-capitalize">
                            <?php echo e(translate('messages.units')); ?>

                        </span>
                    </a>
                </li>
                <?php endif; ?>
                <!-- End Unit -->

                <!-- AddOn -->
                <?php if(\App\CentralLogics\Helpers::module_permission_check('addon')): ?>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/addon*') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" title="<?php echo e(translate('messages.addons')); ?>">
                        <i class="tio-add-circle-outlined nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.addons')); ?></span>
                    </a>
                    <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="display:<?php echo e(Request::is('admin/addon*') ? 'block' : 'none'); ?>">
                        <li class="nav-item <?php echo e(Request::is('admin/addon/add-new') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.addon.add-new')); ?>" title="<?php echo e(translate('messages.addon_list')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate"><?php echo e(translate('messages.list')); ?></span>
                            </a>
                        </li>

                        <li class="nav-item <?php echo e(Request::is('admin/addon/bulk-import') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.addon.bulk-import')); ?>" title="<?php echo e(translate('messages.bulk_import')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate text-capitalize"><?php echo e(translate('messages.bulk_import')); ?></span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo e(Request::is('admin/addon/bulk-export') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.addon.bulk-export-index')); ?>" title="<?php echo e(translate('messages.bulk_export')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate text-capitalize"><?php echo e(translate('messages.bulk_export')); ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
                <!-- End AddOn -->
                <!-- Food -->
                <?php if(\App\CentralLogics\Helpers::module_permission_check('item')): ?>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/item*') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" title="<?php echo e(translate('messages.items')); ?>">
                        <i class="tio-premium-outlined nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate text-capitalize"><?php echo e(translate('messages.items')); ?></span>
                    </a>
                    <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="display:<?php echo e(Request::is('admin/item*') ? 'block' : 'none'); ?>">
                        <li class="nav-item <?php echo e(Request::is('admin/item/add-new') || (Request::is('admin/item/edit/*') && strpos(request()->fullUrl(), 'product_gellary=1') !== false  )  ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.item.add-new')); ?>" title="<?php echo e(translate('messages.add_new')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate"><?php echo e(translate('messages.add_new')); ?></span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo e(Request::is('admin/item/list') || (Request::is('admin/item/edit/*') && (strpos(request()->fullUrl(), 'temp_product=1') == false && strpos(request()->fullUrl(), 'product_gellary=1') == false  ) ) ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.item.list')); ?>" title="<?php echo e(translate('messages.food_list')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate"><?php echo e(translate('messages.list')); ?></span>
                            </a>
                        </li>
                        
                        <li class="nav-item <?php echo e(Request::is('admin/item/product-gallery') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.item.product_gallery')); ?>" title="<?php echo e(translate('messages.Product_Gallery')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate"><?php echo e(translate('messages.Product_Gallery')); ?></span>
                            </a>
                        </li>
                        
                        <?php if(\App\CentralLogics\Helpers::get_mail_status('product_approval')): ?>
                        <li class="nav-item <?php echo e(Request::is('admin/item/new/item/list') || (Request::is('admin/item/edit/*') && strpos(request()->fullUrl(), 'temp_product=1') !== false  ) ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.item.approval_list')); ?>" title="<?php echo e(translate('messages.New_Item_Request')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate"><?php echo e(translate('messages.New_Item_Request')); ?></span>
                            </a>
                        </li>
                        <?php endif; ?>
                        <li class="nav-item <?php echo e(Request::is('admin/item/reviews') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.item.reviews')); ?>" title="<?php echo e(translate('messages.review_list')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate"><?php echo e(translate('messages.review')); ?></span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo e(Request::is('admin/item/bulk-import') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.item.bulk-import')); ?>" title="<?php echo e(translate('messages.bulk_import')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate text-capitalize"><?php echo e(translate('messages.bulk_import')); ?></span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo e(Request::is('admin/item/bulk-export') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.item.bulk-export-index')); ?>" title="<?php echo e(translate('messages.bulk_export')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate text-capitalize"><?php echo e(translate('messages.bulk_export')); ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
                <!-- End Food -->

                    <!-- Store Store -->
                    <li class="nav-item">
                        <small class="nav-subtitle" title="<?php echo e(translate('messages.store_section')); ?>"><?php echo e(translate('messages.store_management')); ?></small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>

                    <?php if(\App\CentralLogics\Helpers::module_permission_check('store')): ?>
                    <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/store*') && !Request::is('admin/store/withdraw_list') ? 'active' : ''); ?>">
                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" title="<?php echo e(translate('messages.stores')); ?>">
                            <i class="tio-filter-list nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.stores')); ?></span>
                        </a>
                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub"  style="display:<?php echo e(Request::is('admin/store*') ? 'block' : 'none'); ?>">
                            <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/store/add') ? 'active' : ''); ?>">
                                <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.store.add')); ?>" title="<?php echo e(translate('messages.add_store')); ?>">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate">
                                        <?php echo e(translate('messages.add_store')); ?>

                                    </span>
                                </a>
                            </li>

                            <li class="navbar-item <?php echo e(Request::is('admin/store/list') ||  Request::is('admin/store/view/*')  ? 'active' : ''); ?>">
                                <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.store.list')); ?>" title="<?php echo e(translate('messages.stores_list')); ?>">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate"><?php echo e(translate('messages.stores')); ?>

                                        <?php echo e(translate('list')); ?></span>
                                </a>
                            </li>
                            <li class="navbar-item <?php echo e(Request::is('admin/store/pending-requests') ? 'active' : ''); ?>">
                                <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.store.pending-requests')); ?>" title="<?php echo e(translate('messages.pending_requests')); ?>">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate text-capitalize"><?php echo e(translate('new_joining_requests')); ?></span>
                                </a>
                            </li>

                            <li class="navbar-item <?php echo e(Request::is('admin/store/recommended-store') ? 'active' : ''); ?>">
                                <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.store.recommended_store')); ?>" title="<?php echo e(translate('messages.pending_requests')); ?>">
                                    <span class="tio-hot"></span>
                                    <span class="text-truncate text-capitalize"><?php echo e(translate('Recommended_Store')); ?></span>
                                </a>
                            </li>


                            <li class="nav-item <?php echo e(Request::is('admin/store/bulk-import') ? 'active' : ''); ?>">
                                <a class="nav-link " href="<?php echo e(route('admin.store.bulk-import')); ?>" title="<?php echo e(translate('messages.bulk_import')); ?>">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate text-capitalize"><?php echo e(translate('messages.bulk_import')); ?></span>
                                </a>
                            </li>
                            <li class="nav-item <?php echo e(Request::is('admin/store/bulk-export') ? 'active' : ''); ?>">
                                <a class="nav-link " href="<?php echo e(route('admin.store.bulk-export-index')); ?>" title="<?php echo e(translate('messages.bulk_export')); ?>">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate text-capitalize"><?php echo e(translate('messages.bulk_export')); ?></span>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <?php endif; ?>
                    <!-- End Store -->
                <!-- DeliveryMan -->
                <?php if(\App\CentralLogics\Helpers::module_permission_check('deliveryman')): ?>
                <li class="nav-item">
                    <small class="nav-subtitle" title="<?php echo e(translate('messages.deliveryman_section')); ?>"><?php echo e(translate('messages.deliveryman_management')); ?></small>
                    <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/users/delivery-man/add') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.users.delivery-man.add')); ?>" title="<?php echo e(translate('messages.add_delivery_man')); ?>">
                        <i class="tio-running nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                            <?php echo e(translate('messages.add_delivery_man')); ?>

                        </span>
                    </a>
                </li>

                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/users/delivery-man/new') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link text-capitalize" href="<?php echo e(route('admin.users.delivery-man.new')); ?>" title="<?php echo e(translate('messages.new_joining_requests')); ?>">
                        <i class="tio-man nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                            <?php echo e(translate('messages.new_joining_requests')); ?>

                        </span>
                    </a>
                </li>


                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/users/delivery-man') || Request::is('admin/users/delivery-man/edit*') || Request::is('admin/users/delivery-man/preview*') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.users.delivery-man.list')); ?>" title="<?php echo e(translate('messages.deliveryman_list')); ?>">
                        <i class="tio-filter-list nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                            <?php echo e(translate('messages.deliveryman_list')); ?>

                        </span>
                    </a>
                </li>

                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/users/delivery-man/reviews*') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.users.delivery-man.reviews.list')); ?>" title="<?php echo e(translate('messages.reviews')); ?>">
                        <i class="tio-star-outlined nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                            <?php echo e(translate('messages.reviews')); ?>

                        </span>
                    </a>
                </li>

                <li class="navbar-vertical-aside-has-menu <?php echo e(request()->routeIs('admin.users.delivery-man.milestone-bonus') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.users.delivery-man.milestone-bonus')); ?>" title="<?php echo e(translate('messages.dm_milestone_bonus')); ?>">
                        <i class="tio-gift nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                            <?php echo e(translate('messages.dm_milestone_bonus')); ?>

                        </span>
                    </a>
                </li>

                <li class="navbar-vertical-aside-has-menu <?php echo e(request()->routeIs('admin.users.delivery-man.milestone-bonus.awards') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.users.delivery-man.milestone-bonus.awards')); ?>" title="<?php echo e(translate('messages.dm_bonus_awards')); ?>">
                        <i class="tio-medal nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                            <?php echo e(translate('messages.dm_bonus_awards')); ?>

                        </span>
                    </a>
                </li>

                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/users/delivery-man/registration-fee*') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.users.delivery-man.registration-fee')); ?>" title="<?php echo e(translate('messages.dm_registration_fee_settings')); ?>">
                        <i class="tio-money nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                            <?php echo e(translate('messages.dm_registration_fee_settings')); ?>

                        </span>
                    </a>
                </li>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/users/delivery-man/fleet-manager') || Request::is('admin/users/delivery-man/fleet-manager/create') || Request::is('admin/users/delivery-man/fleet-manager/*/edit') || Request::is('admin/users/delivery-man/fleet-manager/*/report') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.users.delivery-man.fleet-manager.index')); ?>" title="<?php echo e(__('fleet_management.fleet_managers')); ?>">
                        <i class="tio-group-senior nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(__('fleet_management.fleet_managers')); ?></span>
                    </a>
                </li>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/users/delivery-man/fleet-manager/rider/assignments') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.users.delivery-man.fleet-manager.assignments')); ?>" title="<?php echo e(__('fleet_management.rider_assignments')); ?>">
                        <i class="tio-group-add nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(__('fleet_management.rider_assignments')); ?></span>
                    </a>
                </li>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/users/delivery-man/fleet-manager/payment/collections') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.users.delivery-man.fleet-manager.collections')); ?>" title="<?php echo e(__('fleet_management.payment_recoveries')); ?>">
                        <i class="tio-money nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(__('fleet_management.payment_recoveries')); ?></span>
                    </a>
                </li>
                <?php endif; ?>
                <!-- End DeliveryMan -->

                <!-- Customer Section -->
                <?php if(\App\CentralLogics\Helpers::module_permission_check('customer_management')): ?>
                <li class="nav-item">
                    <small class="nav-subtitle" title="<?php echo e(translate('messages.customer_section')); ?>"><?php echo e(translate('messages.customer_management')); ?></small>
                    <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>
                <!-- Custommer -->

                <li class="navbar-vertical-aside-has-menu <?php echo e((Request::is('admin/customer/list') || Request::is('admin/customer/view*')) ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.customer.list')); ?>" title="<?php echo e(translate('messages.customers')); ?>">
                        <i class="tio-poi-user nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                            <?php echo e(translate('messages.customers')); ?>

                        </span>
                    </a>
                </li>

                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/customer/wallet*') ? 'active' : ''); ?>">

                    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" title="<?php echo e(translate('messages.customer_wallet')); ?>">
                        <i class="tio-wallet nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate  text-capitalize">
                            <?php echo e(translate('messages.customer_wallet')); ?>

                        </span>
                    </a>

                    <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="display:<?php echo e(Request::is('admin/customer/wallet*') ? 'block' : 'none'); ?>">
                        <li class="nav-item <?php echo e(Request::is('admin/customer/wallet/add-fund') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.customer.wallet.add-fund')); ?>" title="<?php echo e(translate('messages.add_fund')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate text-capitalize"><?php echo e(translate('messages.add_fund')); ?></span>
                            </a>
                        </li>

                        <li class="nav-item <?php echo e(Request::is('admin/customer/wallet/report*') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.customer.wallet.report')); ?>" title="<?php echo e(translate('messages.report')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate text-capitalize"><?php echo e(translate('messages.report')); ?></span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/customer/loyalty-point*') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link  nav-link-toggle" href="javascript:" title="<?php echo e(translate('messages.customer_loyalty_point')); ?>">
                        <i class="tio-medal nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate  text-capitalize">
                            <?php echo e(translate('messages.customer_loyalty_point')); ?>

                        </span>
                    </a>

                    <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="display:<?php echo e(Request::is('admin/customer/loyalty-point*') ? 'block' : 'none'); ?>">
                        <li class="nav-item <?php echo e(Request::is('admin/customer/loyalty-point/report*') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.customer.loyalty-point.report')); ?>" title="<?php echo e(translate('messages.report')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate text-capitalize"><?php echo e(translate('messages.report')); ?></span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- End Custommer -->
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/customer/subscribed') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.customer.subscribed')); ?>" title="<?php echo e(translate('subscribed_emails')); ?>">
                        <i class="tio-email-outlined nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                            <?php echo e(translate('messages.subscribed_mail_list')); ?>

                        </span>
                    </a>
                </li>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/contact/contact-list') ? 'active' : ''); ?>">
                    <a class="nav-link " href="<?php echo e(route('admin.contact.contact-list')); ?>" title="<?php echo e(translate('messages.contact_messages')); ?>">
                        <span class="tio-message nav-icon"></span>
                        <span class="text-truncate"><?php echo e(translate('messages.contact_messages')); ?></span>
                    </a>
                </li>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/customer/settings') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.customer.settings')); ?>" title="<?php echo e(translate('messages.Customer_settings')); ?>">
                        <i class="tio-settings nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                            <?php echo e(translate('messages.Customer_settings')); ?>

                        </span>
                    </a>
                </li>
                <li
                class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/message/list') ? 'active' : ''); ?>">
                <a class="js-navbar-vertical-aside-menu-link nav-link"
                    href="<?php echo e(route('admin.message.list')); ?>"
                    title="<?php echo e(translate('messages.customer_chat')); ?>">
                    <i class="tio-chat nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                        <?php echo e(translate('messages.Customer_Chat')); ?>

                    </span>
                </a>
            </li>
                <?php endif; ?>
                <!-- End customer Section -->

                <!-- Business Section-->
                <li class="nav-item">
                    <small class="nav-subtitle" title="<?php echo e(translate('messages.business_section')); ?>"><?php echo e(translate('messages.business_management')); ?></small>
                    <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>

                <!-- withdraw -->
                <?php if(\App\CentralLogics\Helpers::module_permission_check('withdraw_list')): ?>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/store/withdraw*') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.store.withdraw_list')); ?>" title="<?php echo e(translate('messages.store_withdraws')); ?>">
                        <i class="tio-table nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.store_withdraws')); ?></span>
                    </a>
                </li>
                <?php endif; ?>
                <!-- End withdraw -->
                <!-- account -->
                <?php if(\App\CentralLogics\Helpers::module_permission_check('collect_cash')): ?>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/account-transaction*') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.account-transaction.index')); ?>" title="<?php echo e(translate('messages.collect_cash')); ?>">
                        <i class="tio-money nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.collect_cash')); ?></span>
                    </a>
                </li>
                <?php endif; ?>
                <!-- End account -->

                <!-- provide_dm_earning -->
                <?php if(\App\CentralLogics\Helpers::module_permission_check('provide_dm_earning')): ?>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/provide-deliveryman-earnings*') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.provide-deliveryman-earnings.index')); ?>" title="<?php echo e(translate('messages.deliverymen_earning_provide')); ?>">
                        <i class="tio-send nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.deliverymen_earning_provide')); ?></span>
                    </a>
                </li>
                <?php endif; ?>
                <!-- End provide_dm_earning -->

                <!-- Business Settings -->
                <?php if(\App\CentralLogics\Helpers::module_permission_check('settings')): ?>
                <li class="nav-item">
                    <small class="nav-subtitle" title="<?php echo e(translate('messages.business_settings')); ?>"><?php echo e(translate('messages.business_settings')); ?></small>
                    <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/business-settings/business-setup') ? 'active' : ''); ?>">
                    <a class="nav-link " href="<?php echo e(route('admin.business-settings.business-setup')); ?>" title="<?php echo e(translate('messages.business_setup')); ?>">
                        <span class="tio-settings nav-icon"></span>
                        <span class="text-truncate"><?php echo e(translate('messages.business_setup')); ?></span>
                    </a>
                </li>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/business-settings/social-media')?'active':''); ?>">
                    <a class="nav-link " href="<?php echo e(route('admin.business-settings.social-media.index')); ?>" title="<?php echo e(translate('messages.Social Media')); ?>">
                        <span class="tio-facebook nav-icon"></span>
                        <span class="text-truncate"><?php echo e(translate('messages.Social Media')); ?></span>
                    </a>
                </li>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/business-settings/payment-method') ? 'active' : ''); ?>">
                    <a class="nav-link " href="<?php echo e(route('admin.business-settings.payment-method')); ?>" title="<?php echo e(translate('messages.payment_methods')); ?>">
                        <span class="tio-atm nav-icon"></span>
                        <span class="text-truncate"><?php echo e(translate('messages.payment_methods')); ?></span>
                    </a>
                </li>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/business-settings/mail-config') ? 'active' : ''); ?>">
                    <a class="nav-link " href="<?php echo e(route('admin.business-settings.mail-config')); ?>" title="<?php echo e(translate('messages.mail_config')); ?>">
                        <span class="tio-email nav-icon"></span>
                        <span class="text-truncate"><?php echo e(translate('messages.mail_config')); ?></span>
                    </a>
                </li>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/business-settings/sms-module') ? 'active' : ''); ?>">
                    <a class="nav-link " href="<?php echo e(route('admin.business-settings.sms-module')); ?>" title="<?php echo e(translate('messages.sms_system_module')); ?>">
                        <span class="tio-message nav-icon"></span>
                        <span class="text-truncate"><?php echo e(translate('messages.sms_system_module')); ?></span>
                    </a>
                </li>

                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/business-settings/fcm-index') ? 'active' : ''); ?>">
                    <a class="nav-link " href="<?php echo e(route('admin.business-settings.fcm-index')); ?>" title="<?php echo e(translate('messages.notification_settings')); ?>">
                        <span class="tio-notifications nav-icon"></span>
                        <span class="text-truncate"><?php echo e(translate('messages.notification_settings')); ?></span>
                    </a>
                </li>

                <?php endif; ?>
                <!-- End Business Settings -->

                <!-- web & adpp Settings -->
                <?php if(\App\CentralLogics\Helpers::module_permission_check('settings')): ?>
                <li class="nav-item">
                    <small class="nav-subtitle" title="<?php echo e(translate('messages.business_settings')); ?>"><?php echo e(translate('messages.web_and_app_settings')); ?></small>
                    <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/business-settings/app-settings*') ? 'active' : ''); ?>">
                    <a class="nav-link " href="<?php echo e(route('admin.business-settings.app-settings')); ?>" title="<?php echo e(translate('messages.app_settings')); ?>">
                        <span class="tio-android nav-icon"></span>
                        <span class="text-truncate"><?php echo e(translate('messages.app_settings')); ?></span>
                    </a>
                </li>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/business-settings/landing-page-settings*') ? 'active' : ''); ?>">
                    <a class="nav-link " href="<?php echo e(route('admin.business-settings.landing-page-settings', 'index')); ?>" title="<?php echo e(translate('messages.landing_page_settings')); ?>">
                        <span class="tio-website nav-icon"></span>
                        <span class="text-truncate"><?php echo e(translate('messages.landing_page_settings')); ?></span>
                    </a>
                </li>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/business-settings/config*') ? 'active' : ''); ?>">
                    <a class="nav-link " href="<?php echo e(route('admin.business-settings.config-setup')); ?>" title="<?php echo e(translate('messages.third_party_apis')); ?>">
                        <span class="tio-key nav-icon"></span>
                        <span class="text-truncate"><?php echo e(translate('messages.third_party_apis')); ?></span>
                    </a>
                </li>

                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/business-settings/pages*') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" title="<?php echo e(translate('messages.pages_setup')); ?>">
                        <i class="tio-pages nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.pages_setup')); ?></span>
                    </a>
                    <ul class="js-navbar-vertical-aside-submenu nav nav-sub"  style="display:<?php echo e(Request::is('admin/business-settings/pages*') ? 'block' : 'none'); ?>">

                        <li class="nav-item <?php echo e(Request::is('admin/business-settings/pages/terms-and-conditions') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.business-settings.terms-and-conditions')); ?>" title="<?php echo e(translate('messages.terms_and_condition')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate"><?php echo e(translate('messages.terms_and_condition')); ?></span>
                            </a>
                        </li>

                        <li class="nav-item <?php echo e(Request::is('admin/business-settings/pages/privacy-policy') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.business-settings.privacy-policy')); ?>" title="<?php echo e(translate('messages.privacy_policy')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate"><?php echo e(translate('messages.privacy_policy')); ?></span>
                            </a>
                        </li>

                        <li class="nav-item <?php echo e(Request::is('admin/business-settings/pages/about-us') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.business-settings.about-us')); ?>" title="<?php echo e(translate('messages.about_us')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate"><?php echo e(translate('messages.about_us')); ?></span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo e(Request::is('admin/business-settings/pages/refund') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.business-settings.refund')); ?>" title="<?php echo e(translate('messages.Refund Policy')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate"><?php echo e(translate('Refund Policy')); ?></span>
                            </a>
                        </li>

                        <li class="nav-item <?php echo e(Request::is('admin/business-settings/pages/cancelation') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.business-settings.cancelation')); ?>" title="<?php echo e(translate('messages.Cancelation Policy')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate"><?php echo e(translate('Cancelation Policy')); ?></span>
                            </a>
                        </li>


                        <li class="nav-item <?php echo e(Request::is('admin/business-settings/pages/shipping-policy') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.business-settings.shipping-policy')); ?>" title="<?php echo e(translate('messages.shipping_policy')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate"><?php echo e(translate('Shipping Policy')); ?></span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/file-manager*') ? 'active' : ''); ?>">
                    <a class="nav-link " href="<?php echo e(route('admin.file-manager.index')); ?>" title="<?php echo e(translate('messages.gallery')); ?>">
                        <span class="tio-album nav-icon"></span>
                        <span class="text-truncate text-capitalize"><?php echo e(translate('messages.gallery')); ?></span>
                    </a>
                </li>

                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/social-login/view')?'active':''); ?>">
                <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.social-login.view')); ?>">
                    <i class="tio-twitter nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                        <?php echo e(translate('messages.social_login')); ?>

                    </span>
                </a>
                </li>

                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/business-settings/recaptcha*') ? 'active' : ''); ?>">
                    <a class="nav-link " href="<?php echo e(route('admin.business-settings.recaptcha_index')); ?>" title="<?php echo e(translate('messages.reCaptcha')); ?>">
                        <span class="tio-top-security-outlined nav-icon"></span>
                        <span class="text-truncate"><?php echo e(translate('messages.reCaptcha')); ?></span>
                    </a>
                </li>

                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/business-settings/db-index')?'active':''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.business-settings.db-index')); ?>" title="<?php echo e(translate('messages.clean_database')); ?>">
                        <i class="tio-cloud nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                            <?php echo e(translate('messages.clean_database')); ?>

                        </span>
                    </a>
                </li>
                <?php endif; ?>
                <!-- End web & adpp Settings -->

                <!-- Report -->
                <?php if(\App\CentralLogics\Helpers::module_permission_check('report')): ?>
                <li class="nav-item">
                    <small class="nav-subtitle" title="<?php echo e(translate('messages.report_and_analytics')); ?>"><?php echo e(translate('messages.report_and_analytics')); ?></small>
                    <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>

                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/report/item-wise-report') ? 'active' : ''); ?>">
                    <a class="nav-link " href="<?php echo e(route('admin.report.item-wise-report')); ?>" title="<?php echo e(translate('messages.item_report')); ?>">
                        <span class="tio-chart-bar-1 nav-icon"></span>
                        <span class="text-truncate"><?php echo e(translate('messages.item_report')); ?></span>
                    </a>
                </li>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/report/stock-report') ? 'active' : ''); ?>">
                    <a class="nav-link " href="<?php echo e(route('admin.report.stock-report')); ?>" title="<?php echo e(translate('messages.limited_stock_item')); ?>">
                        <span class="tio-chart-bar-4 nav-icon"></span>
                        <span class="text-truncate text-capitalize"><?php echo e(translate('messages.limited_stock_item')); ?></span>
                    </a>
                </li>


                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/report/store-wise-report') ? 'active' : ''); ?>">
                    <a class="nav-link " href="<?php echo e(route('admin.report.store-summary-report')); ?>" title="<?php echo e(translate('messages.store_wise_report')); ?>">
                        <span class="tio-home nav-icon"></span>
                        <span class="text-truncate"><?php echo e(translate('messages.store_report')); ?></span>
                    </a>
                </li>


                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/report/order-report') ? 'active' : ''); ?>">
                    <a class="nav-link " href="<?php echo e(route('admin.report.order-report')); ?>" title="<?php echo e(translate('messages.order_report')); ?>">
                        <span class="tio-voice nav-icon"></span>
                        <span class="text-truncate text-capitalize"><?php echo e(translate('messages.order_report')); ?></span>
                    </a>
                </li>

                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/report/transaction-report') ? 'active' : ''); ?>">
                    <a class="nav-link " href="<?php echo e(route('admin.report.transaction-report')); ?>" title="<?php echo e(translate('messages.transaction_report')); ?>">
                        <span class="tio-chart-pie-1 nav-icon"></span>
                        <span class="text-truncate"><?php echo e(translate('messages.transaction_report')); ?></span>
                    </a>
                </li>


                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/report/expense-report') ? 'active' : ''); ?>">
                    <a class="nav-link " href="<?php echo e(route('admin.report.expense-report')); ?>" title="<?php echo e(translate('messages.expense_report')); ?>">
                        <span class="tio-money nav-icon"></span>
                        <span class="text-truncate"><?php echo e(translate('messages.expense_report')); ?></span>
                    </a>
                </li>

                <?php endif; ?>

                <!-- Employee-->

                <li class="nav-item">
                    <small class="nav-subtitle" title="<?php echo e(translate('messages.employee_handle')); ?>"><?php echo e(translate('messages.employee')); ?>

                        <?php echo e(translate('management')); ?></small>
                    <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>

                <?php if(\App\CentralLogics\Helpers::module_permission_check('custom_role')): ?>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/custom-role*') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.custom-role.create')); ?>" title="<?php echo e(translate('messages.employee_Role')); ?>">
                        <i class="tio-incognito nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.employee_Role')); ?></span>
                    </a>
                </li>
                <?php endif; ?>

                <?php if(\App\CentralLogics\Helpers::module_permission_check('employee')): ?>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/employee*') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" title="<?php echo e(translate('messages.Employee')); ?>">
                        <i class="tio-user nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.employees')); ?></span>
                    </a>
                    <ul class="js-navbar-vertical-aside-submenu nav nav-sub"  style="display:<?php echo e(Request::is('admin/employee*') ? 'block' : 'none'); ?>">
                        <li class="nav-item <?php echo e(Request::is('admin/employee/add-new') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.employee.add-new')); ?>" title="<?php echo e(translate('messages.add_new_Employee')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate"><?php echo e(translate('messages.add_new')); ?></span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo e(Request::is('admin/employee/list') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.employee.list')); ?>" title="<?php echo e(translate('messages.Employee_list')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate"><?php echo e(translate('messages.list')); ?></span>
                            </a>
                        </li>

                    </ul>
                </li>
                <?php endif; ?>
                <!-- End Employee -->


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
<script>
    $(window).on('load' , function() {
        if($(".navbar-vertical-content li.active").length) {
            $('.navbar-vertical-content').animate({
                scrollTop: $(".navbar-vertical-content li.active").offset().top - 150
            }, 10);
        }
    });

    var $rows = $('#navbar-vertical-content li');
    $('#search-sidebar-menu').keyup(function() {
        var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

        $rows.show().filter(function() {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    });
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/layouts/admin/partials/_sidebar.blade.php ENDPATH**/ ?>