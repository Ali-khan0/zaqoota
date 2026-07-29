<?php $__env->startSection('title', \App\Models\BusinessSetting::where(['key' => 'business_name'])->first()->value ?? translate('messages.dashboard')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <?php if(auth('admin')->user()->role_id == 1): ?>
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center py-2">
            <div class="col-sm mb-2 mb-sm-0">
                <div class="d-flex align-items-center">
                    <img src="<?php echo e(asset('/public/assets/admin/img/new-img/users.svg')); ?>" alt="img">
                    <div class="w-0 flex-grow pl-3">
                        <h1 class="page-header-title mb-0"><?php echo e(translate('messages.User Overview')); ?></h1>
                        <p class="page-header-text m-0"><?php echo e(translate('Hello,_here_you_can_manage_your_users_by_zone.')); ?>

                        </p>
                    </div>
                </div>
            </div>

            <div class="col-sm-auto min--280">
                <select name="zone_id" class="form-control js-select2-custom set-filter" data-url="<?php echo e(url()->full()); ?>"
                    data-filter="zone_id">
                    <option value="all"><?php echo e(translate('messages.All_Zones')); ?></option>
                    <?php $__currentLoopData = \App\Models\Zone::orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($zone['id']); ?>" <?php echo e($params['zone_id'] == $zone['id'] ? 'selected' : ''); ?>>
                            <?php echo e($zone['name']); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
    </div>
    <!-- End Page Header -->

    <div class="row g-2 pb-4 mb-0">
        <div class="col-sm-6 col-lg-4">
            <a href="<?php echo e(route('admin.users.customer.list', ['zone_id' => $params['zone_id'] ?? null])); ?>">
                <div class="__user-dashboard-card">
                    <div class="__user-dashboard-card-thumbs">
                        <?php ($total_customers = $blocked_customers + $active_customers); ?>
                        <div class="more-icon">
                            +<?php echo e($total_customers >= 4 ? $total_customers - 2 : $total_customers); ?>

                        </div>
                        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <img src="<?php echo e($customer['image_full_url']); ?>" class="onerror-image"
                                data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>" alt="new-img">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <h3 class="title"><?php echo e($total_customers); ?></h3>
                    <h5 class="subtitle text-capitalize"><?php echo e(translate('messages.total_customer')); ?></h5>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-lg-4">
            <a href="<?php echo e(route('admin.users.delivery-man.list', ['zone_id' => $params['zone_id'] ?? null])); ?>">
                <div class="__user-dashboard-card" style="--theme-clr:#006AB4">

                    <div class="__user-dashboard-card-thumbs">
                        <?php ($total_deliveryman = $inactive_deliveryman + $active_deliveryman + $blocked_deliveryman ); ?>
                        <div class="more-icon">
                            +<?php echo e($total_deliveryman >= 4 ? $total_deliveryman - 2 : $total_deliveryman); ?>

                        </div>
                        <?php $__currentLoopData = $delivery_man; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $dm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <img src="<?php echo e($dm['image_full_url']); ?>" class="onerror-image"
                                data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>" alt="new-img">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <h3 class="title"><?php echo e($total_deliveryman); ?></h3>
                    <h5 class="subtitle text-capitalize"><?php echo e(translate('messages.total_delivery_man')); ?></h5>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-lg-4">
            <a href="<?php echo e(route('admin.users.employee.list', ['zone_id' => $params['zone_id'] ?? null])); ?>">
                <div class="__user-dashboard-card" style="--theme-clr:#FFA800">
                    <div class="__user-dashboard-card-thumbs">
                        <?php ($total_employees = $employees->count()); ?>
                        <div class="more-icon">
                            +<?php echo e($total_employees >= 4 ? $total_employees - 2 : $total_employees); ?>

                        </div>
                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($key == 2): ?>
                                <?php break; ?>
                            <?php endif; ?>
                            <img src="<?php echo e($item['image_full_url']); ?>" class="onerror-image"
                                data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>" alt="new-img">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <h3 class="title"><?php echo e($total_employees); ?></h3>
                    <h5 class="subtitle text-capitalize"><?php echo e(translate('messages.total_employee')); ?></h5>
                </div>
            </a>
        </div>
    </div>

    <h4 class="mb-md-3"><?php echo e(translate('Customer Statistics')); ?></h4>

    <div class="row g-2 pb-4 mb-0">
        <div class="col-lg-8">
            <div class="row g-2">
                <div class="col-md-4">
                    <div class="row gap__10">
                        <div class="col-md-12 col-sm-6">
                            <a
                                href="<?php echo e(route('admin.users.customer.list', ['zone_id' => $params['zone_id'] ?? null, 'filter' => 'active'])); ?>">
                                <div class="__customer-statistics-card">
                                    <div class="title">
                                        <img src="<?php echo e(asset('/public/assets/admin/img/new-img/customer/active.svg')); ?>"
                                            alt="new-img">
                                        <h4><?php echo e($active_customers); ?></h4>
                                    </div>
                                    <h4 class="subtitle text-capitalize"><?php echo e(translate('messages.active_customer')); ?></h4>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-12 col-sm-6">
                            <a
                                href="<?php echo e(route('admin.users.customer.list', ['zone_id' => $params['zone_id'] ?? null, 'filter' => 'new'])); ?>">
                                <div class="__customer-statistics-card" style="--clr:#006AB4">
                                    <div class="title">
                                        <img src="<?php echo e(asset('/public/assets/admin/img/new-img/customer/newly.svg')); ?>"
                                            alt="new-img">
                                        <h4><?php echo e($newly_joined); ?></h4>
                                    </div>
                                    <h4 class="subtitle text-capitalize"><?php echo e(translate('messages.newly_joined')); ?></h4>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-12 col-sm-6">
                            <a
                                href="<?php echo e(route('admin.users.customer.list', ['zone_id' => $params['zone_id'] ?? null, 'filter' => 'blocked'])); ?>">
                                <div class="__customer-statistics-card" style="--clr:#FF5A54">
                                    <div class="title">
                                        <img src="<?php echo e(asset('/public/assets/admin/img/new-img/customer/blocked.svg')); ?>"
                                            alt="new-img">
                                        <h4><?php echo e($blocked_customers); ?></h4>
                                    </div>
                                    <h4 class="subtitle text-capitalize"><?php echo e(translate('messages.blocked_customer')); ?></h4>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card h-100">
                        <div class="card-body pb-0">
                            <div class="d-flex flex-wrap justify-content-between align-items-center __gap-12px">
                                <div class="__gross-amount">
                                    
                                    <span class="text-capitalize"><?php echo e(translate('messages.customer_growth')); ?></span>
                                </div>
                                <div class="chart--label __chart-label p-0 ml-auto">
                                    <span class="indicator chart-bg-2"></span>
                                    <span class="info">
                                        <span><?php echo e(translate('messages.this_year')); ?></span> (<?php echo e(now()->year); ?>)
                                    </span>
                                </div>
                            </div>
                            <div id="customer-growth-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="__customer-satisfaction">
                <div class="px-2">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="subtitle text-capitalize"><?php echo e(translate('messages.customer_satisfaction')); ?></h5>
                        <img src="<?php echo e(asset('/public/assets/admin/img/new-img/satisfactions.png')); ?>" alt="new-img">
                    </div>
                    <div class="px-sm-2">
                        <h4 class="review-count"><?php echo e($reviews); ?></h4>
                        <span class="review-received text-capitalize"><?php echo e(translate('messages.review_received')); ?></span>
                    </div>
                </div>
                <ul class="__customer-review">
                    <li
                        title="<?php echo e(translate('positive_review_given_total') . ' ' . $positive_reviews . ' ' . translate('messages.customers')); ?> (<?php echo e(translate('Scale: 4-5')); ?>) ">

                        <span class="tag"><?php echo e(translate('Positive')); ?></span>
                        <?php ($positive_parcent = $positive_reviews > 0 ? round($positive_reviews / $reviews * 100) : 0); ?>
                        <span class="review">
                            <i class="tio-user-big" <?php if($positive_parcent >= 5): ?> style="--clr:#00AA6D;" <?php endif; ?>></i>
                            <i class="tio-user-big" <?php if($positive_parcent >= 20): ?> style="--clr:#00AA6D;" <?php endif; ?>></i>
                            <i class="tio-user-big" <?php if($positive_parcent >= 30): ?> style="--clr:#00AA6D;" <?php endif; ?>></i>
                            <i class="tio-user-big" <?php if($positive_parcent >= 40): ?> style="--clr:#00AA6D;" <?php endif; ?>></i>
                            <i class="tio-user-big" <?php if($positive_parcent >= 50): ?> style="--clr:#00AA6D;" <?php endif; ?>></i>
                            <i class="tio-user-big" <?php if($positive_parcent >= 60): ?> style="--clr:#00AA6D;" <?php endif; ?>></i>
                            <i class="tio-user-big" <?php if($positive_parcent >= 70): ?> style="--clr:#00AA6D;" <?php endif; ?>></i>
                            <i class="tio-user-big" <?php if($positive_parcent >= 80): ?> style="--clr:#00AA6D;" <?php endif; ?>></i>
                            <i class="tio-user-big" <?php if($positive_parcent >= 87): ?> style="--clr:#00AA6D;" <?php endif; ?>></i>
                            <i class="tio-user-big" <?php if($positive_parcent >= 95): ?> style="--clr:#00AA6D;" <?php endif; ?>></i>
                        </span>
                        <span class="ratio"><?php echo e($positive_parcent); ?>%</span>
                    </li>
                    <li
                        title="<?php echo e(translate('good_review_given_total') . ' ' . $good_reviews . ' ' . translate('messages.customers')); ?> (<?php echo e(translate('Scale: 3')); ?>)">

                        <span class="tag"><?php echo e(translate('Good')); ?></span>
                        <?php ($good_parcent = $good_reviews > 0 ? round($good_reviews / $reviews * 100) : 0); ?>
                        <span class="review">
                            <i class="tio-user-big" <?php if($good_parcent >= 5): ?> style="--clr:#FEB019;" <?php endif; ?>></i>
                            <i class="tio-user-big" <?php if($good_parcent >= 20): ?> style="--clr:#FEB019;" <?php endif; ?>></i>
                            <i class="tio-user-big" <?php if($good_parcent >= 30): ?> style="--clr:#FEB019;" <?php endif; ?>></i>
                            <i class="tio-user-big" <?php if($good_parcent >= 40): ?> style="--clr:#FEB019;" <?php endif; ?>></i>
                            <i class="tio-user-big" <?php if($good_parcent >= 50): ?> style="--clr:#FEB019;" <?php endif; ?>></i>
                            <i class="tio-user-big" <?php if($good_parcent >= 60): ?> style="--clr:#FEB019;" <?php endif; ?>></i>
                            <i class="tio-user-big" <?php if($good_parcent >= 70): ?> style="--clr:#FEB019;" <?php endif; ?>></i>
                            <i class="tio-user-big" <?php if($good_parcent >= 80): ?> style="--clr:#FEB019;" <?php endif; ?>></i>
                            <i class="tio-user-big" <?php if($good_parcent >= 87): ?> style="--clr:#FEB019;" <?php endif; ?>></i>
                            <i class="tio-user-big" <?php if($good_parcent >= 95): ?> style="--clr:#FEB019;" <?php endif; ?>></i>
                        </span>
                        <span class="ratio"><?php echo e($good_parcent); ?>%</span>
                    </li>
                    <li
                        title="<?php echo e(translate('neutral_review_given_total') . ' ' . $neutral_reviews . ' ' . translate('messages.customers')); ?> (<?php echo e(translate('Scale: 2')); ?>)">
                        <span class="tag"><?php echo e(translate('Neutral')); ?></span>
                        <?php ($neutral_parcent = $neutral_reviews > 0 ? round($neutral_reviews / $reviews * 100) : 0); ?>
                        <span class="review">
                            <i class="tio-user-big" <?php if($neutral_parcent >= 5): ?> style="--clr:#0177CD;" <?php endif; ?>></i>
                            <i class="tio-user-big" <?php if($neutral_parcent >= 20): ?> style="--clr:#0177CD;" <?php endif; ?>></i>
                            <i class="tio-user-big" <?php if($neutral_parcent >= 30): ?> style="--clr:#0177CD;" <?php endif; ?>></i>
                            <i class="tio-user-big" <?php if($neutral_parcent >= 40): ?> style="--clr:#0177CD;" <?php endif; ?>></i>
                            <i class="tio-user-big" <?php if($neutral_parcent >= 50): ?> style="--clr:#0177CD;" <?php endif; ?>></i>
                            <i class="tio-user-big" <?php if($neutral_parcent >= 60): ?> style="--clr:#0177CD;" <?php endif; ?>></i>
                            <i class="tio-user-big" <?php if($neutral_parcent >= 70): ?> style="--clr:#0177CD;" <?php endif; ?>></i>
                            <i class="tio-user-big" <?php if($neutral_parcent >= 80): ?> style="--clr:#0177CD;" <?php endif; ?>></i>
                            <i class="tio-user-big" <?php if($neutral_parcent >= 87): ?> style="--clr:#0177CD;" <?php endif; ?>></i>
                            <i class="tio-user-big" <?php if($neutral_parcent >= 95): ?> style="--clr:#0177CD;" <?php endif; ?>></i>
                        </span>
                        <span class="ratio"><?php echo e($neutral_parcent); ?>%</span>
                    </li>
                    <li
                        title="<?php echo e(translate('negative_review_given_total') . ' ' . $negative_reviews . ' ' . translate('messages.customers')); ?> (<?php echo e(translate('Scale: 1')); ?>)">
                        <span class="tag"><?php echo e(translate('Negetive')); ?></span>
                        <?php ($negative_percent = $negative_reviews > 0 ? round($negative_reviews / $reviews * 100) : 0); ?>
                                                <span class="review">
                                                    <i class="tio-user-big" <?php if($negative_percent >= 5): ?> style="--clr:#FF7E7E;" <?php endif; ?>></i>
                                                    <i class="tio-user-big" <?php if($negative_percent >= 20): ?> style="--clr:#FF7E7E;" <?php endif; ?>></i>
                                                    <i class="tio-user-big" <?php if($negative_percent >= 30): ?> style="--clr:#FF7E7E;" <?php endif; ?>></i>
                                                    <i class="tio-user-big" <?php if($negative_percent >= 40): ?> style="--clr:#FF7E7E;" <?php endif; ?>></i>
                                                    <i class="tio-user-big" <?php if($negative_percent >= 50): ?> style="--clr:#FF7E7E;" <?php endif; ?>></i>
                                                    <i class="tio-user-big" <?php if($negative_percent >= 60): ?> style="--clr:#FF7E7E;" <?php endif; ?>></i>
                                                    <i class="tio-user-big" <?php if($negative_percent >= 70): ?> style="--clr:#FF7E7E;" <?php endif; ?>></i>
                                                    <i class="tio-user-big" <?php if($negative_percent >= 80): ?> style="--clr:#FF7E7E;" <?php endif; ?>></i>
                                                    <i class="tio-user-big" <?php if($negative_percent >= 87): ?> style="--clr:#FF7E7E;" <?php endif; ?>></i>
                                                    <i class="tio-user-big" <?php if($negative_percent >= 95): ?> style="--clr:#FF7E7E;" <?php endif; ?>></i>
                                                </span>
                                                <span class="ratio"><?php echo e($negative_percent); ?>%</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <h4 class="mb-md-3"><?php echo e(translate('Deliveryman Statistics')); ?></h4>
                            <div class="row g-2">
                                <div class="col-lg-8">
                                    <div class="row gap__10">
                                        <div class="col-md-3 col-sm-6">
                                            <a
                                                href="<?php echo e(route('admin.users.delivery-man.list', ['zone_id' => $params['zone_id'] ?? null, 'filter' => 'active'])); ?>">
                                                <div class="__customer-statistics-card h-100">
                                                    <div class="title">
                                                        <img src="<?php echo e(asset('/public/assets/admin/img/new-img/deliveryman/active.svg')); ?>"
                                                            alt="new-img">
                                                        <h4><?php echo e($active_deliveryman); ?></h4>
                                                    </div>
                                                    <h4 class="subtitle text-capitalize"><?php echo e(translate('messages.active_delivery_man')); ?></h4>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-3 col-sm-6">
                                            <a
                                                href="<?php echo e(route('admin.users.delivery-man.list', ['zone_id' => $params['zone_id'] ?? null, 'filter' => 'new'])); ?>">
                                                <div class="__customer-statistics-card h-100" style="--clr:#006AB4">
                                                    <div class="title">
                                                        <img src="<?php echo e(asset('/public/assets/admin/img/new-img/deliveryman/newly.svg')); ?>"
                                                            alt="new-img">
                                                        <h4><?php echo e($newly_joined_deliveryman); ?></h4>
                                                    </div>
                                                    <h4 class="subtitle text-capitalize"><?php echo e(translate('messages.newly_joined_delivery_man')); ?>

                                                    </h4>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-3 col-sm-6">
                                            <a
                                                href="<?php echo e(route('admin.users.delivery-man.list', ['zone_id' => $params['zone_id'] ?? null, 'filter' => 'inactive'])); ?>">
                                                <div class="__customer-statistics-card h-100" style="--clr:#FF5A54">
                                                    <div class="title">
                                                        <img src="<?php echo e(asset('/public/assets/admin/img/new-img/deliveryman/in-active.svg')); ?>"
                                                            alt="new-img">
                                                        <h4><?php echo e($inactive_deliveryman); ?></h4>
                                                    </div>
                                                    <h4 class="subtitle text-capitalize"><?php echo e(translate('messages.inactive_deliveryman')); ?></h4>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-3 col-sm-6">
                                            <a
                                                href="<?php echo e(route('admin.users.delivery-man.list', ['zone_id' => $params['zone_id'] ?? null, 'filter' => 'blocked'])); ?>">
                                                <div class="__customer-statistics-card h-100" style="--clr:#FF5A54">
                                                    <div class="title">
                                                        <img src="<?php echo e(asset('/public/assets/admin/img/new-img/customer/blocked.svg')); ?>"
                                                            alt="new-img">
                                                        <h4><?php echo e($blocked_deliveryman); ?></h4>
                                                    </div>
                                                    <h4 class="subtitle text-capitalize"><?php echo e(translate('messages.Blocked_deliveryman')); ?></h4>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="__map-wrapper-2 mt-3">
                                        <div class="map-pop-deliveryman">
                                            <form action="javascript:" id="search-form" class="map-pop-deliveryman-inner">
                                                <label><?php echo e(translate('Currently Active Delivery Men')); ?> </label>
                                                <div class="position-relative mx-auto">
                                                    <i class="tio-search"></i>
                                                    <input type="text" name="search" class="form-control"
                                                        placeholder="<?php echo e(translate('Search Delivery Man ...')); ?>">
                                                </div>
                                                <a href="<?php echo e(route('admin.users.delivery-man.list')); ?>"
                                                    class="link"><?php echo e(translate('View All Delivery Men')); ?></a>
                                            </form>
                                        </div>
                                        <div class="map-warper map-wrapper-2 rounded">
                                            <div id="map-canvas" class="rounded"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card h-100" id="top-deliveryman-view">
                                        <?php echo $__env->make('admin-views.partials._top-deliveryman', ['top_deliveryman' => $data['top_deliveryman']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-sm mb-2 mb-sm-0">
                <h1 class="page-header-title"><?php echo e(translate('messages.welcome')); ?>, <?php echo e(auth('admin')->user()->f_name); ?>.</h1>
                <p class="page-header-text"><?php echo e(translate('messages.employee_welcome_message')); ?></p>
            </div>
        </div>
    </div>
    <!-- End Page Header -->
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
<!-- Apex Charts -->
<script src="<?php echo e(asset('/public/assets/admin/js/apex-charts/apexcharts.js')); ?>"></script>
<!-- Apex Charts -->

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(\App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value); ?>&callback=initialize&libraries=drawing,places,marker&v=3.61"></script>

<script>
    "use strict";
    let map; // Global declaration of the map
    let drawingManager;
    let lastpolygon = null;
    let polygons = [];
    let dmMarkers = [];

    function resetMap(controlDiv) {
        // Set CSS for the control border.
        const controlUI = document.createElement("div");
        controlUI.style.backgroundColor = "#fff";
        controlUI.style.border = "2px solid #fff";
        controlUI.style.borderRadius = "3px";
        controlUI.style.boxShadow = "0 2px 6px rgba(0,0,0,.3)";
        controlUI.style.cursor = "pointer";
        controlUI.style.marginTop = "8px";
        controlUI.style.marginBottom = "22px";
        controlUI.style.textAlign = "center";
        controlUI.title = "Reset map";
        controlDiv.appendChild(controlUI);
        // Set CSS for the control interior.
        const controlText = document.createElement("div");
        controlText.style.color = "rgb(25,25,25)";
        controlText.style.fontFamily = "Roboto,Arial,sans-serif";
        controlText.style.fontSize = "10px";
        controlText.style.lineHeight = "16px";
        controlText.style.paddingLeft = "2px";
        controlText.style.paddingRight = "2px";
        controlText.innerHTML = "X";
        controlUI.appendChild(controlText);
        // Setup the click event listeners: simply set the map to Chicago.
        controlUI.addEventListener("click", () => {
            lastpolygon.setMap(null);
            $('#coordinates').val('');

        });
    }

    function initialize() {
        <?php ($default_location = \App\Models\BusinessSetting::where('key', 'default_location')->first()); ?>
        <?php ($default_location = $default_location->value ? json_decode($default_location->value, true) : 0); ?>
        var myLatlng = {
            lat: <?php echo e($default_location ? $default_location['lat'] : '23.757989'); ?>,
            lng: <?php echo e($default_location ? $default_location['lng'] : '90.360587'); ?>

            };
        var dmbounds = new google.maps.LatLngBounds(null);
        const mapId = "<?php echo e(\App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value); ?>"

        var myOptions = {
            zoom: 13,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapId: mapId,

        }
        var deliveryMan = <?php echo json_encode($deliveryMen); ?>;
        map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);

        var infowindow = new google.maps.InfoWindow();

        map.fitBounds(dmbounds);
        const { AdvancedMarkerElement } = google.maps.marker;

        deliveryMan.forEach(dm => {
            if (dm.lat) {
                const point = new google.maps.LatLng(dm.lat, dm.lng);
                dmbounds.extend(point);
                map.fitBounds(dmbounds);

                const activeIconContent = document.createElement("img");
                activeIconContent.src = "<?php echo e(asset('public/assets/admin/img/delivery_boy_active.png')); ?>";
                activeIconContent.alt = "Active DM";
                activeIconContent.style.width = '100%';
                activeIconContent.style.height = '100%';
                activeIconContent.style.borderRadius = '50%';

                const marker = new AdvancedMarkerElement({
                    position: point,
                    map: map,
                    title: dm.image,
                    content: activeIconContent,
                });

                dmMarkers[dm.id] = marker;

                google.maps.event.addListener(marker, 'click', function () {
                    infowindow.setContent(`
                <div style='float:left'>
                    <img style='max-height:40px;wide:auto;' src='${dm.image_link}'>
                </div>
                <div style='float:right; padding: 10px;'>
                    <b>${dm.name}</b><br/>
                    ${dm.location}<br/>
                    Assigned Order: ${dm.assigned_order_count}
                </div>`);
                    infowindow.open(map, marker);
                });
            }
        });

    }

    $('#search-form').on('submit', function (e) {
        initialize();
        var deliveryMan = <?php echo json_encode($deliveryMen); ?>;
        var infowindow = new google.maps.InfoWindow();
        let formData = new FormData(this);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post({
            url: '<?php echo e(route('admin.users.delivery-man.active-search')); ?>',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                let itemCount = 0;
                if (data.dm) {
                    deliveryMan.forEach(item => {

                        const isDMActive = data.dm.some(ddm => ddm.id === item.id);
                        if (isDMActive) {
                            itemCount++
                        }
                        const icon = isDMActive ?
                            "<?php echo e(asset('public/assets/admin/img/delivery_boy_active.png')); ?>" :
                            "<?php echo e(asset('public/assets/admin/img/delivery_boy_map_inactive.png')); ?>";

                        const newIconContent = document.createElement("img");
                        newIconContent.src = icon;
                        newIconContent.alt = isDMActive ? "Active" : "Inactive";
                        newIconContent.style.width = '100%';
                        newIconContent.style.height = '100%';
                        newIconContent.style.borderRadius = '50%';

                        const markerToUpdate = dmMarkers[item.id];
                        if (markerToUpdate) {
                            markerToUpdate.content = newIconContent;

                            if (isDMActive) {
                                itemCount++
                            }

                            map.panTo(markerToUpdate.position);
                            map.setZoom(20);
                            let dmViewContent = `
                <div style='float:left'>
                    <img style='max-height:40px;wide:auto;'  src='${item.image_link}'>
                </div>
                <div style='float:right; padding: 10px;'>
                    <b>${item.name}</b><br/>
                    ${item.location}<br/>
                    Assigned Order: ${item.assigned_order_count}
                </div>`

                            if (isDMActive && itemCount == 1) {
                                infowindow.setContent(dmViewContent);
                                infowindow.open(map, markerToUpdate);
                            } else {
                                google.maps.event.addListener(markerToUpdate, 'click', function () {
                                    infowindow.setContent(dmViewContent);
                                    infowindow.open(map, markerToUpdate);
                                });
                            }
                        }
                    });
                } else {
                    toastr.error('Delivery Man not found', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            },
        });
    });


    let options = {
        series: [{
            name: '<?php echo e(translate('New_Customer_Growth')); ?>',
            data: [<?php echo e($last_year_users > 0 ? number_format($user_data[1] / $last_year_users, 2) : 0); ?>,
           <?php echo e($user_data[1] > 0 ? number_format($user_data[2] / $user_data[1], 2) : 0); ?>,
           <?php echo e($user_data[2] > 0 ? number_format($user_data[3] / $user_data[2], 2) : 0); ?>,
           <?php echo e($user_data[3] > 0 ? number_format($user_data[4] / $user_data[3], 2) : 0); ?>,
           <?php echo e($user_data[4] > 0 ? number_format($user_data[5] / $user_data[4], 2) : 0); ?>,
           <?php echo e($user_data[5] > 0 ? number_format($user_data[6] / $user_data[5], 2) : 0); ?>,
           <?php echo e($user_data[6] > 0 ? number_format($user_data[7] / $user_data[6], 2) : 0); ?>,
           <?php echo e($user_data[7] > 0 ? number_format($user_data[8] / $user_data[7], 2) : 0); ?>,
           <?php echo e($user_data[8] > 0 ? number_format($user_data[9] / $user_data[8], 2) : 0); ?>,
           <?php echo e($user_data[9] > 0 ? number_format($user_data[10] / $user_data[9], 2) : 0); ?>,
           <?php echo e($user_data[10] > 0 ? number_format($user_data[11] / $user_data[10], 2) : 0); ?>,
           <?php echo e($user_data[11] > 0 ? number_format($user_data[12] / $user_data[11], 2) : 0); ?>]
        }],
        chart: {
            height: 235,
            type: 'area',
            toolbar: {
                show: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight',
            width: 2,
        },
        colors: ['#107980'],
        fill: {
            type: 'gradient',
            colors: ['#107980'],
        },
        xaxis: {
            //   type: 'datetime',
            categories: ["<?php echo e(translate('Jan')); ?>", "<?php echo e(translate('Feb')); ?>", "<?php echo e(translate('Mar')); ?>", "<?php echo e(translate('Apr')); ?>", "<?php echo e(translate('May')); ?>", "<?php echo e(translate('Jun')); ?>", "<?php echo e(translate('Jul')); ?>", "<?php echo e(translate('Aug')); ?>", "<?php echo e(translate('Sep')); ?>", "<?php echo e(translate('Oct')); ?>", "<?php echo e(translate('Nov')); ?>", "<?php echo e(translate('Dec')); ?>"]
        },
        tooltip: {
            x: {
                format: 'dd/MM/yy HH:mm'
            },
        },
    };

    let chart = new ApexCharts(document.querySelector("#customer-growth-chart"), options);
    chart.render();


</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/dashboard-users.blade.php ENDPATH**/ ?>