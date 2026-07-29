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
                    <?php if(\App\CentralLogics\Helpers::module_permission_check('pos')): ?>
                    <li class="nav-item">
                        <small class="nav-subtitle" title="<?php echo e(translate('messages.employee_handle')); ?>"><?php echo e(translate('pos section')); ?></small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>
                    <!-- Pos -->
                    <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/pos*')?'active':''); ?>">
                        <a class="js-navbar-vertical-aside-menu-link nav-link " href="<?php echo e(route('admin.pos.index')); ?>" title="<?php echo e(translate('New Sale')); ?>">
                            <i class="tio-shopping-basket-outlined nav-icon"></i>
                            <span class="text-truncate"><?php echo e(translate('New Sale')); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>
                    <!-- Pos -->

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
                                            <?php echo e(\App\Models\Order::StoreOrder()->module(Config::get('module.current_module_id'))->count()); ?>

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
                                            <?php echo e(\App\Models\Order::Scheduled()->StoreOrder()->module(Config::get('module.current_module_id'))->count()); ?>

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
                                            <?php echo e(\App\Models\Order::Pending()->OrderScheduledIn(30)->StoreOrder()->module(Config::get('module.current_module_id'))->count()); ?>

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
                                            <?php echo e(\App\Models\Order::AccepteByDeliveryman()->OrderScheduledIn(30)->StoreOrder()->module(Config::get('module.current_module_id'))->count()); ?>

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
                                            <?php echo e(\App\Models\Order::Preparing()->OrderScheduledIn(30)->StoreOrder()->module(Config::get('module.current_module_id'))->count()); ?>

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
                                            <?php echo e(\App\Models\Order::ItemOnTheWay()->OrderScheduledIn(30)->StoreOrder()->module(Config::get('module.current_module_id'))->count()); ?>

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
                                            <?php echo e(\App\Models\Order::Delivered()->StoreOrder()->module(Config::get('module.current_module_id'))->count()); ?>

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
                                            <?php echo e(\App\Models\Order::Canceled()->StoreOrder()->module(Config::get('module.current_module_id'))->count()); ?>

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
                                            <?php echo e(\App\Models\Order::failed()->StoreOrder()->module(Config::get('module.current_module_id'))->count()); ?>

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
                                            <?php echo e(\App\Models\Order::Refunded()->StoreOrder()->module(Config::get('module.current_module_id'))->count()); ?>

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
                                        <?php echo e(\App\Models\Order::Refund_requested()->StoreOrder()->module(Config::get('module.current_module_id'))->count()); ?>

                                    </span>
                                </span>
                            </a>
                        </li>

                        
                    </ul>
                    </li>
                    <!-- Order refund End-->
                    <?php endif; ?>
                    <!-- End Orders -->


                <!-- Marketing section -->
                    <?php if(\App\CentralLogics\Helpers::module_permission_check('campaign')||
                        \App\CentralLogics\Helpers::module_permission_check('banner') ||
                        \App\CentralLogics\Helpers::module_permission_check('coupon')||
                        \App\CentralLogics\Helpers::module_permission_check('notification') ||
                        \App\CentralLogics\Helpers::module_permission_check('advertisement')
                        ): ?>
                <li class="nav-item">
                    <small class="nav-subtitle" title="<?php echo e(translate('Promotion Management')); ?>"><?php echo e(translate('Promotion Management')); ?></small>
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
                            <a class="nav-link " href="<?php echo e(route('admin.campaign.list', 'item')); ?>" title="<?php echo e(translate('messages.food_campaigns')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate"><?php echo e(translate('messages.food_campaigns')); ?></span>
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
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/promotional-banner*') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.promotional-banner.add-new')); ?>" title="<?php echo e(translate('messages.other_banners')); ?>">
                        <i class="tio-image nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.other_banners')); ?></span>
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

            <!-- advertisement -->

            <?php if(\App\CentralLogics\Helpers::module_permission_check('advertisement')): ?>
                <li
                    class="navbar-vertical-aside-has-menu  <?php echo $__env->yieldContent('advertisement'); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                        title="<?php echo e(translate('messages.advertisement')); ?>">
                        <i class="tio-tv-old nav-icon"></i>
                        <span
                            class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.advertisement')); ?></span>
                    </a>
                    <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                        style="display: <?php echo e(Request::is('admin/advertisement*') ? 'block' : 'none'); ?>">

                        <li class="nav-item <?php echo $__env->yieldContent('advertisement_create'); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.advertisement.create')); ?>"
                                title="<?php echo e(translate('messages.New_Advertisement')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate"><?php echo e(translate('messages.New_Advertisement')); ?></span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $__env->yieldContent('advertisement_request'); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.advertisement.requestList')); ?>"
                                title="<?php echo e(translate('messages.Ad_Requests')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate"><?php echo e(translate('messages.Ad_Requests')); ?></span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo $__env->yieldContent('advertisement_list'); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.advertisement.index')); ?>"
                                title="<?php echo e(translate('messages.Ads_list')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate"><?php echo e(translate('messages.Ads_list')); ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>
            <!-- End advertisement -->
                    <?php endif; ?>
                <!-- End marketing section -->

                    <?php if(\App\CentralLogics\Helpers::module_permission_check('category')||
                        \App\CentralLogics\Helpers::module_permission_check('addon')||
                        \App\CentralLogics\Helpers::module_permission_check('item')
                        ): ?>
                        <li class="nav-item">
                            <small class="nav-subtitle" title="<?php echo e(translate('messages.item_section')); ?>"><?php echo e(translate('messages.food_management')); ?></small>
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
                                    <li class="nav-item  <?php echo $__env->yieldContent('main_category'); ?> <?php echo e(request()->input('position') == 0 && Request::is('admin/category/add') ? 'active' : ''); ?>">
                                        <a class="nav-link " href="<?php echo e(route('admin.category.add',['position'=>0])); ?>" title="<?php echo e(translate('messages.category')); ?>">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate"><?php echo e(translate('messages.category')); ?></span>
                                        </a>
                                    </li>

                                    <li class="nav-item   <?php echo $__env->yieldContent('sub_category'); ?> <?php echo e(request()->input('position') == 1 && Request::is('admin/category/add') ? 'active' : ''); ?>">
                                        <a class="nav-link " href="<?php echo e(route('admin.category.add',['position'=>1])); ?>" title="<?php echo e(translate('messages.sub_category')); ?>">
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
                        
                        <!-- End Attributes -->

                        <!-- Unit -->
                        
                        <!-- End Unit -->

                        <!-- AddOn -->
                        <?php if(\App\CentralLogics\Helpers::module_permission_check('addon')): ?>
                            <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/addon*') ? 'active' : ''); ?>">
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" title="<?php echo e(translate('messages.addons')); ?>">
                                    <i class="tio-add-circle-outlined nav-icon"></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.addons')); ?></span>
                                </a>
                                <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="display:<?php echo e(Request::is('admin/addon*') ? 'block' : 'none'); ?>">
                                    <li class="nav-item <?php echo e(Request::is('admin/addon/addon-category') ? 'active' : ''); ?>">
                                        <a class="nav-link " href="<?php echo e(route('admin.addon.addon-category')); ?>" title="<?php echo e(translate('messages.Addon_Category')); ?>">
                                            <span class="tio-circle nav-indicator-icon"></span>
                                            <span class="text-truncate"><?php echo e(translate('messages.Addon_Category')); ?></span>
                                        </a>
                                    </li>
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
                                <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" title="<?php echo e(translate('Food Setup')); ?>">
                                    <i class="tio-premium-outlined nav-icon"></i>
                                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate text-capitalize"><?php echo e(translate('Food Setup')); ?></span>
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
                                            <span class="text-truncate"><?php echo e(translate('messages.Food_Gallery')); ?></span>
                                        </a>
                                    </li>
                                    
                                    <?php if(\App\CentralLogics\Helpers::get_mail_status('product_approval')): ?>
                                        <li class="nav-item <?php echo e(Request::is('admin/item/requested/item/view/*') || Request::is('admin/item/new/item/list') || (Request::is('admin/item/edit/*') && strpos(request()->fullUrl(), 'temp_product=1') !== false  ) ? 'active' : ''); ?>">
                                            <a class="nav-link " href="<?php echo e(route('admin.item.approval_list')); ?>" title="<?php echo e(translate('messages.New_Item_Request')); ?>">
                                                <span class="tio-circle nav-indicator-icon"></span>
                                                <span class="text-truncate"><?php echo e(translate('messages.New_Food_Request')); ?></span>
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
                    <?php endif; ?>


                <!-- Store Store -->
                    <?php if(\App\CentralLogics\Helpers::module_permission_check('store')): ?>

                <li class="nav-item">
                    <small class="nav-subtitle" title="<?php echo e(translate('messages.restaurant_section')); ?>"><?php echo e(translate('messages.restaurant_management')); ?></small>
                    <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>

                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/store/pending-requests') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.store.pending-requests')); ?>" title="<?php echo e(translate('messages.new_restaurants')); ?>">
                        <span class="tio-calendar-note nav-icon"></span>
                        <span class="text-truncate position-relative overflow-visible">
                            <?php echo e(translate('messages.new_restaurants')); ?>

                            <?php ($new_str = \App\Models\Store::whereHas('vendor', function($query){
                                return $query->where('status', null);
                            })->module(Config::get('module.current_module_id'))->get()); ?>
                            <?php if(count($new_str)>0): ?>

                            <span class="btn-status btn-status-danger border-0 size-8px"></span>
                            <?php endif; ?>
                        </span>
                    </a>
                </li>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/store/add') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.store.add')); ?>" title="<?php echo e(translate('add new restaurant')); ?>">
                        <span class="tio-add-circle nav-icon"></span>
                        <span class="text-truncate position-relative overflow-visible">
                            <?php echo e(translate('add new restaurant')); ?>

                        </span>
                    </a>
                </li>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/store/list') ||  Request::is('admin/store/view/*') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.store.list')); ?>" title="<?php echo e(translate('messages.restaurants_list')); ?>">
                        <span class="tio-layout nav-icon"></span>
                        <span class="text-truncate"><?php echo e(translate('messages.restaurants')); ?>

                            <?php echo e(translate('list')); ?></span>
                    </a>
                </li>

                <li class="navbar-item <?php echo e(Request::is('admin/store/recommended-store') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.store.recommended_store')); ?>" title="<?php echo e(translate('messages.pending_requests')); ?>">
                        <span class="tio-hot  nav-icon"></span>
                        <span class="text-truncate text-capitalize"><?php echo e(translate('Recommended_Restaurants')); ?></span>
                    </a>
                </li>
                
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/store/bulk-import') ? 'active' : ''); ?>">
                    <a class="nav-link " href="<?php echo e(route('admin.store.bulk-import')); ?>" title="<?php echo e(translate('messages.bulk_import')); ?>">
                        <span class="tio-publish nav-icon"></span>
                        <span class="text-truncate text-capitalize"><?php echo e(translate('messages.bulk_import')); ?></span>
                    </a>
                </li>
                
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/store/bulk-export') ? 'active' : ''); ?>">
                    <a class="nav-link " href="<?php echo e(route('admin.store.bulk-export-index')); ?>" title="<?php echo e(translate('messages.bulk_export')); ?>">
                        <span class="tio-download-to nav-icon"></span>
                        <span class="text-truncate text-capitalize"><?php echo e(translate('messages.bulk_export')); ?></span>
                    </a>
                </li>
                
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/item/all-products-stores') ? 'active' : ''); ?>">
                    <a class="nav-link " href="<?php echo e(route('admin.item.all-products-stores')); ?>" title="<?php echo e(translate('All Products with Stores')); ?>">
                        <span class="tio-apps nav-icon"></span>
                        <span class="text-truncate"><?php echo e(translate('All Products with Stores')); ?></span>
                    </a>
                </li>
                
                <?php endif; ?>
                <!-- End Store -->

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
    $(document).ready(function() {
            const $searchInput = $('#search');
            const $suggestionsList = $('#search-suggestions');
            const $rows = $('#navbar-vertical-content li');
            const $subrows = $('#navbar-vertical-content li ul li');
            
            const focusInput = () => updateSuggestions($searchInput.val());
            const hideSuggestions = () => $suggestionsList.slideUp(700);
            const showSuggestions = () => $suggestionsList.slideDown(700);
            let clickSuggestion = function() {
                let suggestionText = $(this).text();
                $searchInput.val(suggestionText);
                hideSuggestions();
                filterItems(suggestionText.toLowerCase());
                updateSuggestions(suggestionText);
            };
            let filterItems = (val) => {
                let unmatchedItems = $rows.show().filter((index, element) => !~$(element).text().replace(
                    /\s+/g, ' ').toLowerCase().indexOf(val));
                let matchedItems = $rows.show().filter((index, element) => ~$(element).text().replace(/\s+/g,
                    ' ').toLowerCase().indexOf(val));
                unmatchedItems.hide();
                matchedItems.each(function() {
                    let $submenu = $(this).find($subrows);
                    let keywordCountInRows = 0;
                    $rows.each(function() {
                        let rowText = $(this).text().toLowerCase();
                        let valLower = val.toLowerCase();
                        let keywordCountRow = rowText.split(valLower).length - 1;
                        keywordCountInRows += keywordCountRow;
                    });
                    if ($submenu.length > 0) {
                        $subrows.show();
                        $submenu.each(function() {
                            let $submenu2 = !~$(this).text().replace(/\s+/g, ' ')
                                .toLowerCase().indexOf(val);
                            if ($submenu2 && keywordCountInRows <= 2) {
                                $(this).hide();
                            }
                        });
                    }
                });
            };
            let updateSuggestions = (val) => {
                $suggestionsList.empty();
                suggestions.forEach(suggestion => {
                    if (suggestion.toLowerCase().includes(val.toLowerCase())) {
                        $suggestionsList.append(
                            `<span class="search-suggestion badge badge-soft-light m-1 fs-14">${suggestion}</span>`
                        );
                    }
                });
                // showSuggestions();
            };
            $searchInput.focus(focusInput);
            $searchInput.on('input', function() {
                updateSuggestions($(this).val());
            });
            $suggestionsList.on('click', '.search-suggestion', clickSuggestion);
            $searchInput.keyup(function() {
                filterItems($(this).val().toLowerCase());
            });
            $searchInput.on('focusout', hideSuggestions);
            $searchInput.on('focus', showSuggestions);
        });
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/zaqoota/resources/views/layouts/admin/partials/_sidebar_food.blade.php ENDPATH**/ ?>