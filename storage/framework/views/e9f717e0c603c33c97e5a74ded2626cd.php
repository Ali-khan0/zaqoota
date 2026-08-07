<div id="sidebarMain" class="d-none">
    <aside class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered  ">
        <div class="navbar-vertical-container">
            <div class="navbar-brand-wrapper justify-content-between">
                <!-- Logo -->
                <?php ($store_logo = \App\Models\BusinessSetting::where(['key' => 'logo'])->first()); ?>
                <a class="navbar-brand" href="#" aria-label="Front">
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
                <form autocomplete="off" class="sidebar--search-form">
                    <div class="search--form-group">
                        <button type="button" class="btn"><i class="tio-search"></i></button>
                        <input autocomplete="false" type="text" name="qq" class="form-control form--control" placeholder="<?php echo e(translate('Search Menu...')); ?>" id="search">
                        <div id="search-suggestions" class="flex-wrap mt-1"></div>
                    </div>
                </form>
                <ul class="navbar-nav navbar-nav-lg nav-tabs">
                <!-- Dashboards -->
                <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is('admin/dispatch') ? 'show active' : ''); ?>">
                    <a class="js-navbar-vertical-aside-menu-link nav-link" href="<?php echo e(route('admin.dispatch.dashboard')); ?>" title="<?php echo e(translate('messages.dashboard')); ?>">
                        <i class="tio-home-vs-1-outlined nav-icon"></i>
                        <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                            <?php echo e(translate('messages.dashboard')); ?>

                        </span>
                    </a>
                </li>
                <!-- End Dashboards -->
                <!-- Business Section-->
                <li class="nav-item">
                    <small class="nav-subtitle" title="<?php echo e(translate('messages.dispatch_section')); ?>"><?php echo e(translate('messages.dispatch_management')); ?></small>
                    <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>

                <!-- dispatch -->
                <?php if(\App\CentralLogics\Helpers::module_permission_check('order')): ?>
                    <!-- Order dispachment -->
                    <?php ($modules = \App\Models\Module::where('module_type', '!=' ,'rental')->when(auth('admin')->user()->zone_id, function($query){
                                $query->whereHas('zones',function($query){
                                    $query->where('zone_id',auth('admin')->user()->zone_id);
                                });
                            })->Active()->get()); ?>
                    <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($module->module_type != 'parcel'): ?>
                    <?php ($unassigned = \App\Models\Order::whereHas('module', function($query) use($module){
                                        $query->where('module_id', $module->id);
                                    })->SearchingForDeliveryman()->OrderScheduledIn(30)->StoreOrder()->count()); ?>
                    <?php ($ongoing = \App\Models\Order::whereHas('module', function($query) use($module){
                                        $query->where('module_id', $module->id);
                                    })->Ongoing()->OrderScheduledIn(30)->StoreOrder()->count() ); ?>
                    <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is("admin/dispatch/list/{$module->id}*") ? 'active' : ''); ?>">
                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" title="<?php echo e($module->module_name); ?>">
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                <?php echo e($module->module_name); ?>

                                <span class="badge badge-soft-info badge-pill ml-1">
                                    <?php echo e($unassigned + $ongoing); ?>


                                </span>
                            </span>
                        </a>
                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="<?php echo e(Request::is('admin/dispatch*') ? 'display-block' : 'display-none'); ?>">
                            <li class="nav-item <?php echo e(Request::is("admin/dispatch/list/{$module->id}/searching_for_deliverymen") ? 'active' : ''); ?>">
                                <a class="nav-link " href="<?php echo e(route('admin.dispatch.list', [$module->id,'searching_for_deliverymen'])); ?>" title="<?php echo e(translate('messages.unassigned_orders')); ?>">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate sidebar--badge-container">
                                        <?php echo e(translate('messages.unassigned_orders')); ?>

                                        <span class="badge badge-soft-info badge-pill ml-1">
                                            <?php echo e($unassigned); ?>

                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item <?php echo e(Request::is("admin/dispatch/list/{$module->id}/on_going") ? 'active' : ''); ?>">
                                <a class="nav-link " href="<?php echo e(route('admin.dispatch.list', [$module->id,'on_going'])); ?>" title="<?php echo e(translate('messages.ongoingOrders')); ?>">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate sidebar--badge-container">
                                        <?php echo e(translate('messages.ongoingOrders')); ?>

                                        <span class="badge badge-soft-light badge-pill ml-1">
                                            <?php echo e($ongoing); ?>

                                        </span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <?php else: ?>
                    <?php ($unassigned = \App\Models\Order::whereHas('module', function($query) use($module){
                                        $query->where('module_id', $module->id);
                                    })->SearchingForDeliveryman()->OrderScheduledIn(30)->ParcelOrder()->count()); ?>
                    <?php ($ongoing = \App\Models\Order::whereHas('module', function($query) use($module){
                                        $query->where('module_id', $module->id);
                                    })->Ongoing()->OrderScheduledIn(30)->ParcelOrder()->count() ); ?>
                    <li class="navbar-vertical-aside-has-menu <?php echo e(Request::is("admin/dispatch/parcel/list/{$module->id}*") ? 'active' : ''); ?>">
                        <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:" title="<?php echo e($module->module_name); ?>">
                            <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">
                                <?php echo e($module->module_name); ?>

                                <span class="badge badge-soft-light badge-pill ml-1">
                                    <?php echo e($unassigned + $ongoing); ?>

                                </span>
                            </span>
                        </a>
                        <ul class="js-navbar-vertical-aside-submenu nav nav-sub" style="<?php echo e(Request::is('admin/dispatch*') ? 'display-block' : 'display-none'); ?>">
                            <li class="nav-item <?php echo e(Request::is("admin/dispatch/parcel/list/{$module->id}/searching_for_deliverymen") ? 'active' : ''); ?>">
                                <a class="nav-link " href="<?php echo e(route('admin.dispatch.parcel.list', [$module->id,'searching_for_deliverymen'])); ?>" title="<?php echo e(translate('messages.unassigned_orders')); ?>">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate sidebar--badge-container">
                                        <?php echo e(translate('messages.unassigned_orders')); ?>

                                        <span class="badge badge-soft-info badge-pill ml-1">
                                            <?php echo e($unassigned); ?>

                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item <?php echo e(Request::is("admin/dispatch/parcel/list/{$module->id}/on_going") ? 'active' : ''); ?>">
                                <a class="nav-link " href="<?php echo e(route('admin.dispatch.parcel.list', [$module->id,'on_going'])); ?>" title="<?php echo e(translate('messages.ongoingOrders')); ?>">
                                    <span class="tio-circle nav-indicator-icon"></span>
                                    <span class="text-truncate sidebar--badge-container">
                                        <?php echo e(translate('messages.ongoingOrders')); ?>

                                        <span class="badge badge-soft-light badge-pill ml-1">
                                            <?php echo e($ongoing); ?>

                                        </span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <!-- Order dispachment End-->
                <?php endif; ?>
                <!-- End dispatch -->


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
            const suggestions = [ ];
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
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/layouts/admin/partials/_sidebar_dispatch.blade.php ENDPATH**/ ?>