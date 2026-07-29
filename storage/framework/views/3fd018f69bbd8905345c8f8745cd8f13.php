<div id="sidebarMain" class="d-none">
    <aside class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered  ">
        <div class="navbar-vertical-container">
            <div class="navbar-brand-wrapper justify-content-between">
                <!-- Logo -->
                <?php ($store_logo = \App\Models\BusinessSetting::where(['key' => 'logo'])->first()); ?>
                <a class="navbar-brand" href="<?php echo e(route('admin.users.dashboard')); ?>" aria-label="Front">
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
                <form autocomplete="off"   class="sidebar--search-form">
                    <div class="search--form-group">
                        <button type="button" class="btn"><i class="tio-search"></i></button>
                        <input  autocomplete="false" name="qq" type="text" class="form-control form--control" placeholder="<?php echo e(translate('Search Menu...')); ?>" id="search">

                        <div id="search-suggestions" class="flex-wrap mt-1"></div>
                    </div>
                </form>
                <ul class="navbar-nav navbar-nav-lg nav-tabs">
                    <!-- Dashboards -->
                    <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/users') ? 'show active' : ''); ?>">
                        <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.users.dashboard')); ?>" title="<?php echo e(translate('messages.dashboard')); ?>">
                            <i class="tio-home-vs-1-outlined nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                <?php echo e(translate('User Overview')); ?>

                            </span>
                        </a>
                    </li>
                    <!-- End Dashboards -->

                    <?php if(\App\CentralLogics\Helpers::module_permission_check('cashback')): ?>
                    <li class="nav-item">
                        <small class="nav-subtitle" title="<?php echo e(translate('messages.Promotion_section')); ?>"><?php echo e(translate('messages.Promotion_management')); ?></small>
                        <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                    </li>
                    <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/users/cashback*') ? 'active' : ''); ?>">
                        <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.users.cashback.add-new')); ?>" title="<?php echo e(translate('messages.cashback')); ?>">
                            <i class="tio-settings-back nav-icon"></i>
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.cashback')); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>

                <!-- DeliveryMan -->
                <?php if(\App\CentralLogics\Helpers::module_permission_check('deliveryman')): ?>
                <li class="nav-item">
                    <small class="nav-subtitle" title="<?php echo e(translate('messages.deliveryman_section')); ?>"><?php echo e(translate('messages.deliveryman_management')); ?></small>
                    <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>
                <li
                    class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/users/delivery-man/vehicle*') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link"
                        href="<?php echo e(route('admin.users.delivery-man.vehicle.list')); ?>"
                        title="<?php echo e(translate('messages.vehicles_category')); ?>">
                        <i class="tio-car nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                            <?php echo e(translate('messages.vehicles_category')); ?>

                        </span>
                    </a>
                </li>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/users/delivery-man/add') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.users.delivery-man.add')); ?>" title="<?php echo e(translate('messages.add_delivery_man')); ?>">
                        <i class="tio-running nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                            <?php echo e(translate('messages.add_delivery_man')); ?>

                        </span>
                    </a>
                </li>

                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/users/delivery-man/new') || Request::is('admin/users/delivery-man/deny')  ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.users.delivery-man.new')); ?>" title="<?php echo e(translate('messages.new_delivery_man')); ?>">
                        <i class="tio-man nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                            <?php echo e(translate('messages.new_delivery_man')); ?>


                            <span class="badge badge-soft-info badge-pill ml-1">
                                <?php echo e(\App\Models\DeliveryMan::where('application_status','pending')->count()); ?>

                            </span>
                        </span>
                    </a>
                </li>


                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/users/delivery-man') ||  Request::is('admin/users/delivery-man/edit*') ||  Request::is('admin/users/delivery-man/preview*') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.users.delivery-man.list')); ?>" title="<?php echo e(translate('messages.deliveryman_list')); ?>">
                        <i class="tio-filter-list nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                            <?php echo e(translate('messages.deliveryman_list')); ?>

                        </span>
                    </a>
                </li>

                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/users/delivery-man/reviews') ? 'active' : ''); ?>">
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
                <?php endif; ?>
                <!-- End DeliveryMan -->

                <!-- Customer Section -->
                <?php if(\App\CentralLogics\Helpers::module_permission_check('customer_management')): ?>
                <li class="nav-item">
                    <small class="nav-subtitle" title="<?php echo e(translate('messages.customer_section')); ?>"><?php echo e(translate('messages.customer_management')); ?></small>
                    <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>
                <!-- Custommer -->

                <li class="navbar-vertical-aside-has-menu <?php echo e((Request::is('admin/users/customer/list') || Request::is('admin/users/customer/view*')) ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.users.customer.list')); ?>" title="<?php echo e(translate('messages.customers')); ?>">
                        <i class="tio-poi-user nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                            <?php echo e(translate('messages.customers')); ?>

                        </span>
                    </a>
                </li>

                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/users/customer/wallet*') ? 'active' : ''); ?>">

                    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" title="<?php echo e(translate('messages.customer_wallet')); ?>">
                        <i class="tio-wallet nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate  text-capitalize">
                            <?php echo e(translate('messages.customer_wallet')); ?>

                        </span>
                    </a>

                    <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="display:<?php echo e(Request::is('admin/users/customer/wallet*') ? 'block' : 'none'); ?>">
                        <li class="nav-item <?php echo e(Request::is('admin/users/customer/wallet/add-fund') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.users.customer.wallet.add-fund')); ?>" title="<?php echo e(translate('messages.add_fund')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate text-capitalize"><?php echo e(translate('messages.add_fund')); ?></span>
                            </a>
                        </li>

                        <li class="nav-item <?php echo e(Request::is('admin/users/customer/wallet/report*') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.users.customer.wallet.report')); ?>" title="<?php echo e(translate('messages.report')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate text-capitalize"><?php echo e(translate('messages.report')); ?></span>
                            </a>
                        </li>

                        <li class="nav-item <?php echo e(Request::is('admin/users/customer/wallet/bonus*') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.users.customer.wallet.bonus.add-new')); ?>" title="<?php echo e(translate('messages.bonus')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate text-capitalize"><?php echo e(translate('messages.bonus')); ?></span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/users/customer/loyalty-point*') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link  nav-link-toggle" href="javascript:" title="<?php echo e(translate('messages.customer_loyalty_point')); ?>">
                        <i class="tio-medal nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate  text-capitalize">
                            <?php echo e(translate('messages.customer_loyalty_point')); ?>

                        </span>
                    </a>

                    <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="display:<?php echo e(Request::is('admin/users/customer/loyalty-point*') ? 'block' : 'none'); ?>">
                        <li class="nav-item <?php echo e(Request::is('admin/users/customer/loyalty-point/report*') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.users.customer.loyalty-point.report')); ?>" title="<?php echo e(translate('messages.report')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate text-capitalize"><?php echo e(translate('messages.report')); ?></span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- End Custommer -->
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/users/customer/subscribed') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.users.customer.subscribed')); ?>" title="<?php echo e(translate('subscribed_emails')); ?>">
                        <i class="tio-email-outlined nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                            <?php echo e(translate('messages.subscribed_mail_list')); ?>

                        </span>
                    </a>
                </li>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/users/contact/contact-list') ? 'active' : ''); ?>">
                    <a class="nav-link " href="<?php echo e(route('admin.users.contact.contact-list')); ?>" title="<?php echo e(translate('messages.contact_messages')); ?>">
                        <span class="tio-message nav-icon"></span>
                        <span class="text-truncate"><?php echo e(translate('messages.contact_messages')); ?></span>
                    </a>
                </li>

                <?php endif; ?>
                <!-- End customer Section -->



                <!-- Employee-->

                <li class="nav-item">
                    <small class="nav-subtitle" title="<?php echo e(translate('messages.employee_handle')); ?>"><?php echo e(translate('messages.employee')); ?>

                        <?php echo e(translate('management')); ?></small>
                    <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>

                <?php if(\App\CentralLogics\Helpers::module_permission_check('custom_role')): ?>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/users/custom-role*') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.users.custom-role.create')); ?>" title="<?php echo e(translate('messages.employee_Role')); ?>">
                        <i class="tio-incognito nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.employee_Role')); ?></span>
                    </a>
                </li>
                <?php endif; ?>

                <?php if(\App\CentralLogics\Helpers::module_permission_check('employee')): ?>
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/users/employee*') ? 'active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" title="<?php echo e(translate('messages.Employee')); ?>">
                        <i class="tio-user nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate"><?php echo e(translate('messages.employees')); ?></span>
                    </a>
                    <ul class="js-navbar-vertical-aside-submenu nav nav-sub"  style="display:<?php echo e(Request::is('admin/users/employee*') ? 'block' : 'none'); ?>">
                        <li class="nav-item <?php echo e(Request::is('admin/users/employee/store') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.users.employee.add-new')); ?>" title="<?php echo e(translate('messages.add_new_Employee')); ?>">
                                <span class="tio-circle nav-indicator-icon"></span>
                                <span class="text-truncate"><?php echo e(translate('messages.add_new')); ?></span>
                            </a>
                        </li>
                        <li class="nav-item <?php echo e(Request::is('admin/users/employee/') ? 'active' : ''); ?>">
                            <a class="nav-link " href="<?php echo e(route('admin.users.employee.list')); ?>" title="<?php echo e(translate('messages.Employee_list')); ?>">
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
    $(document).ready(function() {
            const $searchInput = $('#search');
            const $suggestionsList = $('#search-suggestions');
            const $rows = $('#navbar-vertical-content li');
            const $subrows = $('#navbar-vertical-content li ul li');
            const suggestions = ['<?php echo e(strtolower(translate('messages.customer'))); ?>', '<?php echo e(strtolower(translate('messages.employee'))); ?>', '<?php echo e(strtolower(translate('messages.delivery_man'))); ?>', '<?php echo e(strtolower(translate('messages.review'))); ?>' ];
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
<?php /**PATH /var/www/zaqoota/resources/views/layouts/admin/partials/_sidebar_users.blade.php ENDPATH**/ ?>