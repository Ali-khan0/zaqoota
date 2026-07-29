<div id="sidebarMain" class="d-none">
    <aside
        class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered  ">
        <div class="navbar-vertical-container">
            <div class="navbar-brand-wrapper justify-content-between">
                <!-- Logo -->
                <?php ($store_logo = \App\Models\BusinessSetting::where(['key' => 'logo'])->first()); ?>
                <a class="navbar-brand" href="<?php echo e(route('admin.dashboard')); ?>" aria-label="Front">
                    <img class="navbar-brand-logo initial--36 onerror-image onerror-image"
                         data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                         src="<?php echo e(\App\CentralLogics\Helpers::get_full_url('business', $store_logo?->value?? '', $store_logo?->storage[0]?->value ?? 'public','favicon')); ?>"
                         alt="Logo">
                    <img class="navbar-brand-logo-mini initial--36 onerror-image onerror-image"
                         data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                         src="<?php echo e(\App\CentralLogics\Helpers::get_full_url('business', $store_logo?->value?? '', $store_logo?->storage[0]?->value ?? 'public','favicon')); ?>"
                         alt="Logo">
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
            <div class="navbar-vertical-content bg--005555" id="navbar-vertical-content">
                <form autocomplete="off" class="sidebar--search-form">
                    <div class="search--form-group">
                        <button type="button" class="btn"><i class="tio-search"></i></button>
                        <input autocomplete="false" name="qq" type="text" class="form-control form--control"
                               placeholder="<?php echo e(translate('Search Menu...')); ?>" id="search">

                        <div id="search-suggestions" class="flex-wrap mt-1"></div>
                    </div>
                </form>
                <ul class="navbar-nav navbar-nav-lg nav-tabs">
                    <!-- Dashboards -->
                    <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin') ? 'show active' : ''); ?>">
                        <a class="js-navbar-vertical-aside-menu-link nav-link"
                           href="<?php echo e(route('admin.dashboard')); ?>?module_id=<?php echo e(Config::get('module.current_module_id')); ?>"
                           title="<?php echo e(translate('messages.dashboard')); ?>">
                            <i class="tio-home-vs-1-outlined nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                <?php echo e(translate('messages.dashboard')); ?>

                            </span>
                        </a>
                    </li>
                    <!-- End Dashboards -->


                    <!-- Orders -->
                    <?php if(\App\CentralLogics\Helpers::module_permission_check('order')): ?>
                        <li class="nav-item">
                            <small class="nav-subtitle"><?php echo e(translate('messages.order_management')); ?></small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>

                        <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/parcel/orders/*') ||Request::is('admin/parcel/details/*')   ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                               title="<?php echo e(translate('messages.orders')); ?>">
                                <i class="tio-shopping-cart nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                <?php echo e(translate('messages.orders')); ?>

                            </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="display:<?php echo e(Request::is('admin/parcel/orders/*') ||Request::is('admin/parcel/details/*')  || Request::is('admin/order/offline/payment/list*')? 'block' : 'none'); ?>">
                                <li class="nav-item <?php echo e(Request::is('admin/parcel/orders/all') ? 'active' : ''); ?>">
                                    <a class="nav-link" href="<?php echo e(route('admin.parcel.orders', ['all'])); ?>"
                                       title="<?php echo e(translate('messages.all_orders')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                        <?php echo e(translate('messages.all')); ?>

                                        <span class="badge badge-soft-info badge-pill ml-1">
                                            <?php echo e(\App\Models\Order::ParcelOrder()->module(Config::get('module.current_module_id'))->count()); ?>

                                        </span>
                                    </span>
                                    </a>
                                </li>

                                <li class="nav-item <?php echo e(Request::is('admin/parcel/orders/pending') ? 'active' : ''); ?>">
                                    <a class="nav-link " href="<?php echo e(route('admin.parcel.orders', ['pending'])); ?>"
                                       title="<?php echo e(translate('messages.pending_orders')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                        <?php echo e(translate('messages.pending')); ?>

                                        <span class="badge badge-soft-info badge-pill ml-1">
                                            <?php echo e(\App\Models\Order::Pending()->OrderScheduledIn(30)->ParcelOrder()->module(Config::get('module.current_module_id'))->count()); ?>

                                        </span>
                                    </span>
                                    </a>
                                </li>

                                <li class="nav-item <?php echo e(Request::is('admin/parcel/orders/accepted') ? 'active' : ''); ?>">
                                    <a class="nav-link " href="<?php echo e(route('admin.parcel.orders', ['accepted'])); ?>"
                                       title="<?php echo e(translate('messages.accepted_orders')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                        <?php echo e(translate('messages.accepted')); ?>

                                        <span class="badge badge-soft-success badge-pill ml-1">
                                            <?php echo e(\App\Models\Order::AccepteByDeliveryman()->OrderScheduledIn(30)->ParcelOrder()->module(Config::get('module.current_module_id'))->count()); ?>

                                        </span>
                                    </span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo e(Request::is('admin/parcel/orders/processing') ? 'active' : ''); ?>">
                                    <a class="nav-link " href="<?php echo e(route('admin.parcel.orders', ['processing'])); ?>"
                                       title="<?php echo e(translate('messages.processing_orders')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                        <?php echo e(translate('messages.processing')); ?>

                                        <span class="badge badge-soft-warning badge-pill ml-1">
                                            <?php echo e(\App\Models\Order::Preparing()->OrderScheduledIn(30)->ParcelOrder()->module(Config::get('module.current_module_id'))->count()); ?>

                                        </span>
                                    </span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo e(Request::is('admin/parcel/orders/item_on_the_way') ? 'active' : ''); ?>">
                                    <a class="nav-link text-capitalize"
                                       href="<?php echo e(route('admin.parcel.orders', ['item_on_the_way'])); ?>"
                                       title="<?php echo e(translate('messages.order_on_the_way')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                        <?php echo e(translate('messages.order_on_the_way')); ?>

                                        <span class="badge badge-soft-warning badge-pill ml-1">
                                            <?php echo e(\App\Models\Order::ItemOnTheWay()->OrderScheduledIn(30)->ParcelOrder()->module(Config::get('module.current_module_id'))->count()); ?>

                                        </span>
                                    </span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo e(Request::is('admin/parcel/orders/delivered') ? 'active' : ''); ?>">
                                    <a class="nav-link " href="<?php echo e(route('admin.parcel.orders', ['delivered'])); ?>"
                                       title="<?php echo e(translate('messages.delivered_orders')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                        <?php echo e(translate('messages.delivered')); ?>

                                        <span class="badge badge-soft-success badge-pill ml-1">
                                            <?php echo e(\App\Models\Order::Delivered()->ParcelOrder()->module(Config::get('module.current_module_id'))->count()); ?>

                                        </span>
                                    </span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo e(Request::is('admin/parcel/orders/canceled') ? 'active' : ''); ?>">
                                    <a class="nav-link " href="<?php echo e(route('admin.parcel.orders', ['canceled'])); ?>"
                                       title="<?php echo e(translate('messages.canceled_orders')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                        <?php echo e(translate('messages.canceled')); ?>

                                        <span class="badge badge-soft-warning bg-light badge-pill ml-1">
                                            <?php echo e(\App\Models\Order::Canceled()->ParcelOrder()->module(Config::get('module.current_module_id'))->count()); ?>

                                        </span>
                                    </span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo e(Request::is('admin/parcel/orders/failed') ? 'active' : ''); ?>">
                                    <a class="nav-link " href="<?php echo e(route('admin.parcel.orders', ['failed'])); ?>"
                                       title="<?php echo e(translate('messages.payment_failed_orders')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container text-capitalize">
                                        <?php echo e(translate('messages.payment_failed')); ?>

                                        <span class="badge badge-soft-danger bg-light badge-pill ml-1">
                                            <?php echo e(\App\Models\Order::failed()->ParcelOrder()->module(Config::get('module.current_module_id'))->count()); ?>

                                        </span>
                                    </span>
                                    </a>
                                </li>


                                <li class="nav-item <?php echo e(Request::is('admin/order/offline/payment/list*') ? 'active' : ''); ?>">
                                    <a class="nav-link "
                                       href="<?php echo e(route('admin.order.offline_verification_list', ['all'])); ?>"
                                       title="<?php echo e(translate('Offline_Payments')); ?>">
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

                        <!-- Order dispachment -->
                        <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/parcel/dispatch/*') ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                               title="<?php echo e(translate('messages.dispatch')); ?>">
                                <i class="tio-clock nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                <?php echo e(translate('messages.dispatch')); ?>

                            </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="<?php echo e(Request::is('admin/parcel*') ? 'display-block' : 'display-none'); ?>">
                                <li class="nav-item <?php echo e(Request::is('admin/parcel/dispatch/searching_for_deliverymen') ? 'active' : ''); ?>">
                                    <a class="nav-link "
                                       href="<?php echo e(route('admin.parcel.list', ['searching_for_deliverymen'])); ?>"
                                       title="<?php echo e(translate('messages.unassigned_orders')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                        <?php echo e(translate('messages.unassigned_orders')); ?>

                                        <span class="badge badge-soft-info badge-pill ml-1">
                                            <?php echo e(\App\Models\Order::SearchingForDeliveryman()->OrderScheduledIn(30)->ParcelOrder()->module(Config::get('module.current_module_id'))->count()); ?>

                                        </span>
                                    </span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo e(Request::is('admin/parcel/dispatch/on_going') ? 'active' : ''); ?>">
                                    <a class="nav-link " href="<?php echo e(route('admin.parcel.list', ['on_going'])); ?>"
                                       title="<?php echo e(translate('messages.ongoingOrders')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                        <?php echo e(translate('messages.ongoingOrders')); ?>

                                        <span class="badge badge-soft-light badge-pill ml-1">
                                            <?php echo e(\App\Models\Order::Ongoing()->OrderScheduledIn(30)->ParcelOrder()->module(Config::get('module.current_module_id'))->count()); ?>

                                        </span>
                                    </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- Order dispachment End-->
                    <?php endif; ?>
                    <!-- End Orders -->


                    <!--End Parcel Section -->

                    <!-- Marketing section -->
                    <?php if(\App\CentralLogics\Helpers::module_permission_check('banner')): ?>

                        <li class="nav-item">
                            <small class="nav-subtitle"
                                   title="<?php echo e(translate('Promotion Management')); ?>"><?php echo e(translate('Promotion Management')); ?></small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>

                        <!-- Banner -->
                        <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/promotional-banner*') ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="<?php echo e(route('admin.promotional-banner.add-new')); ?>"
                               title="<?php echo e(translate('messages.Promotional Banners')); ?>">
                                <i class="tio-image nav-icon"></i>
                                <span
                                    class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.Promotional Banners')); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <!-- End Banner -->

                    <!-- End marketing section -->

                    <!-- Product Section -->
                    <?php if(\App\CentralLogics\Helpers::module_permission_check('parcel')): ?>

                        <li class="nav-item">
                            <small class="nav-subtitle"
                                   title="<?php echo e(translate('messages.product_section')); ?>"><?php echo e(translate('messages.product_management')); ?></small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>

                        <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/parcel/category') ? 'active' : ''); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link"
                               href="<?php echo e(route('admin.parcel.category.index')); ?>"
                               title="<?php echo e(translate('messages.category_setup')); ?>">
                                <i class="tio-category nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                <?php echo e(translate('messages.category_setup')); ?>

                            </span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <!--End Product Section -->

                    <!-- Product Section -->
                    <?php if(\App\CentralLogics\Helpers::module_permission_check('parcel')): ?>

                        <li class="nav-item">
                            <small class="nav-subtitle"
                                   title="<?php echo e(translate('messages.delivery_section')); ?>"><?php echo e(translate('messages.delivery_management')); ?></small>
                            <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                        </li>
                        <li class="navbar-vertical-aside-has-menu <?php echo $__env->yieldContent('parcel_settings'); ?> <?php echo $__env->yieldContent('parcel_cancellation'); ?>">
                            <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:"
                               title="<?php echo e(translate('delivery_Settings')); ?>">
                                <i class="tio-settings nav-icon"></i>
                                <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                <?php echo e(translate('delivery_Settings')); ?>

                            </span>
                            </a>
                            <ul class="js-navbar-vertical-aside-submenu nav nav-sub"
                                style="<?php echo e(Request::is('admin/parcel/settings*') || Request::is('admin/parcel/cancellation-settings') ? 'display-block' : 'display-none'); ?>">

                                <li class="nav-item <?php echo $__env->yieldContent('parcel_settings'); ?>">
                                    <a class="nav-link " href="<?php echo e(route('admin.parcel.settings')); ?>"
                                       title="<?php echo e(translate('Parcel Settings')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                        <?php echo e(translate('Parcel Settings')); ?>


                                    </span>
                                    </a>
                                </li>
                                <li class="nav-item <?php echo $__env->yieldContent('parcel_cancellation'); ?>">
                                    <a class="nav-link " href="<?php echo e(route('admin.parcel.cancellationSettings')); ?>"
                                       title="<?php echo e(translate('Cancellation_Setup')); ?>">
                                        <span class="tio-circle nav-indicator-icon"></span>
                                        <span class="text-truncate sidebar--badge-container">
                                        <?php echo e(translate('Cancellation_Setup')); ?>


                                    </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>



                    <!--End Product Section -->


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
        $(window).on('load', function () {
            if ($(".navbar-vertical-content li.active").length) {
                $('.navbar-vertical-content').animate({
                    scrollTop: $(".navbar-vertical-content li.active").offset().top - 150
                }, 10);
            }
        });

        var $rows = $('#navbar-vertical-content li');
        $('#search-sidebar-menu').keyup(function () {
            var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

            $rows.show().filter(function () {
                var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                return !~text.indexOf(val);
            }).hide();
        });
        $(document).ready(function () {
            const $searchInput = $('#search');
            const $suggestionsList = $('#search-suggestions');
            const $rows = $('#navbar-vertical-content li');
            const $subrows = $('#navbar-vertical-content li ul li');
            
            const focusInput = () => updateSuggestions($searchInput.val());
            const hideSuggestions = () => $suggestionsList.slideUp(700);
            const showSuggestions = () => $suggestionsList.slideDown(700);
            let clickSuggestion = function () {
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
                matchedItems.each(function () {
                    let $submenu = $(this).find($subrows);
                    let keywordCountInRows = 0;
                    $rows.each(function () {
                        let rowText = $(this).text().toLowerCase();
                        let valLower = val.toLowerCase();
                        let keywordCountRow = rowText.split(valLower).length - 1;
                        keywordCountInRows += keywordCountRow;
                    });
                    if ($submenu.length > 0) {
                        $subrows.show();
                        $submenu.each(function () {
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
            $searchInput.on('input', function () {
                updateSuggestions($(this).val());
            });
            $suggestionsList.on('click', '.search-suggestion', clickSuggestion);
            $searchInput.keyup(function () {
                filterItems($(this).val().toLowerCase());
            });
            $searchInput.on('focusout', hideSuggestions);
            $searchInput.on('focus', showSuggestions);
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/zaqoota/resources/views/layouts/admin/partials/_sidebar_parcel.blade.php ENDPATH**/ ?>