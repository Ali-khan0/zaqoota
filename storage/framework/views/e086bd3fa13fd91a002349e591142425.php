<?php $__env->startSection('title', translate('messages.Car Rental Module Dashboard')); ?>


<?php $__env->startSection('dashboard'); ?>

show active
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
<?php ($mod = \App\Models\Module::find(Config::get('module.current_module_id'))); ?>
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center py-2">
                <div class="col-sm mb-2 mb-sm-0">
                    <div class="d-flex align-items-center">
                        <img class="onerror-image" data-onerror-image="<?php echo e(asset('/public/assets/admin/img/grocery.svg')); ?>"
                             src="<?php echo e($mod->icon_full_url); ?>" width="38" alt="img">
                        <div class="w-0 flex-grow pl-2">
                            <h1 class="page-header-title text-title mb-0">

                                <?php echo e(translate($mod->module_name)); ?> <?php echo e(translate('messages.Dashboard')); ?>

                            </h1>
                            <p class="page-header-text text-title fs-12 m-0"><?php echo e(translate('messages.Monitor_your')); ?>

                                <strong class="font-bold"> <?php echo e(translate($mod->module_name)); ?> <?php echo e(translate('messages.business')); ?></strong>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-auto min--280">
                    <select data-src-url="<?php echo e(route('admin.rental.dashboard')); ?>" name="zone_id" class="form-control js-select2-custom  fetch_data_zone_wise" >
                        <option value="all"><?php echo e(translate('messages.All_Zones')); ?></option>
                        <?php $__currentLoopData = \App\Models\Zone::orderBy('name')->get(['name','id']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option
                                value="<?php echo e($zone['id']); ?>" <?php echo e(request()->zone_id == $zone['id']?'selected':''); ?>>
                                <?php echo e($zone['name']); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body pt-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between statistics--title-area">
                    <div class="statistics--title pr-sm-3" id="stat_zone">
                        <div class="d-flex align-items-center gap-2">
                            <h3 class="page-header-title text-title fs-18 mb-0">
                                <?php echo e(translate('messages.Delivery_Statistics')); ?></h3>
                            <label class="badge badge-soft-primary m-0">
                                <?php echo e(translate('messages.zone')); ?> : <span id="zoneName"><?php echo e($zoneName); ?></span>
                            </label>
                        </div>
                    </div>
                    <div class="statistics--select">
                        <select class="custom-select border-0 trip_stats_update" name="statistics_type">
                            <option value="all" <?php echo e(request()->statistics_type ? '' : 'selected'); ?>>
                                <?php echo e(translate('messages.All_Time')); ?>

                            </option>
                            <option value="this_year" <?php echo e(request()->statistics_type == 'this_year' ? 'selected' : ''); ?>><?php echo e(translate('messages.this_year')); ?></option>
                            <option value="this_month" <?php echo e(request()->statistics_type == 'this_month' ? 'selected' : ''); ?>><?php echo e(translate('messages.this_month')); ?></option>
                            <option value="this_week" <?php echo e(request()->statistics_type == 'this_week' ? 'selected' : ''); ?>><?php echo e(translate('messages.this_week')); ?></option>
                        </select>
                    </div>
                </div>
                <div id="deliveryStatistics">
                    <?php echo $__env->make('rental::admin.partials.delivery-statistics', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>
        </div>

        <!-- End Stats -->
        <div class="row g-2">
            <div class="col-md-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex flex-wrap justify-content-between align-items-center __gap-12px">
                            <div class="__gross-amount" id="gross_earning">
                                <h6 class="gross-earning"><?php echo e(\App\CentralLogics\Helpers::format_currency(collect($total_sell)->sum())); ?></h6>
                                <span><?php echo e(translate('messages.Gross_Earnings')); ?></span>
                            </div>
                            <div class="chart--label __chart-label p-0 move-left-100 ml-auto">
                                <span class="indicator chart-bg-2"></span>
                                <span class="info">
                                    <?php echo e(translate('Earnings')); ?> (<?php echo e(date('Y')); ?>)
                                </span>
                            </div>
                            <select data-src-url="<?php echo e(route('admin.rental.dashboard-stats.commission_overview')); ?>" id="commission_overview_stats_update"
                                class="custom-select border-0 text-center w-auto ml-auto commission_overview_stats_update"
                                name="commission_overview">
                                <option value="all">
                                    <?php echo e(translate('All Time')); ?>

                                </option>
                                <option value="this_year" <?php echo e(request()->commission_overview == 'this_year' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('this_year')); ?>

                                </option>
                                <option value="this_month" <?php echo e(request()->commission_overview == 'this_month' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('this_month')); ?>

                                </option>
                                <option value="this_week" <?php echo e(request()->commission_overview == 'this_week' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('this_week')); ?>

                                </option>
                            </select>
                        </div>
                        <div id="commission-overview-board">

                            <div id="grow-sale-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <!-- Card -->
                <div class="card h-100">
                    <!-- Header -->
                    <div class="card-header border-0">
                        <h5 class="card-header-title">
                            <?php echo e(translate('Trips by Trip Type')); ?>

                        </h5>
                        <select data-src-url="<?php echo e(route('admin.rental.dashboard-stats.trip_by_trip_type')); ?>" id="trip_by_trip_type_stats_update" class="custom-select border-0 text-center w-auto user_overview_stats_update"
                                name="trip_overview">
                            <option value="all">
                                <?php echo e(translate('All Time')); ?>

                            </option>
                            <option value="this_year" <?php echo e(request()->trip_overview == 'this_year' ? 'selected' : ''); ?>>
                                <?php echo e(translate('This year')); ?>

                            </option>
                            <option value="this_month" <?php echo e(request()->trip_overview == 'this_month' ? 'selected' : ''); ?>>
                                <?php echo e(translate('This month')); ?>

                            </option>
                            <option value="this_week" <?php echo e(request()->trip_overview == 'this_week' ? 'selected' : ''); ?>>
                                <?php echo e(translate('This week')); ?>

                            </option>
                        </select>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body" id="trip-overview-board">
                        <?php echo $__env->make('rental::admin.partials.by-trip-type', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                    <!-- End Body -->
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <!-- Card -->
                <div class="card h-100" id="top-customer-view">
                    <div class="card-header border-0 order-header-shadow">
                        <h5 class="card-header-title font-bold d-flex justify-content-between">
                            <span><?php echo e(translate('messages.top_customers')); ?></span>
                        </h5>
                        <a href="<?php echo e(route('admin.users.customer.list')); ?>" class="fz-12px font-semibold text-006AE5"><?php echo e(translate('view_all')); ?></a>
                    </div>
                    <div class="card-body">

                        <div class="top--selling" id="topCustomers">
                            <?php echo $__env->make('rental::admin.partials.top-customers', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>

                    </div>
                </div>
                <!-- End Card -->
            </div>
            <div class="col-lg-4 col-md-6">
                <!-- Card -->
                <div class="card h-100" id="top-provider-view">
                    <div class="card-header border-0 order-header-shadow">
                        <h5 class="card-header-title font-bold d-flex justify-content-between">
                            <span><?php echo e(translate('messages.top_providers')); ?></span>
                        </h5>
                        <a href="<?php echo e(route('admin.rental.provider.list')); ?>" class="fz-12px font-semibold text-006AE5"><?php echo e(translate('view_all')); ?></a>
                    </div>
                    <div class="card-body">

                        <div class="top--selling" id="topProviders">
                            <?php echo $__env->make('rental::admin.partials.top-providers', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>

                    </div>
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>

    <div class="d-none" id="current_url" data-src-url="<?php echo e(url()->current()); ?>"> </div>
    <div class="d-none" id="current_currency" data-currency="<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>"></div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chart.js.extensions/chartjs-extensions.js"></script>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js">
    </script>
    <!-- Apex Charts -->
    <script src="<?php echo e(asset('/public/assets/admin/js/apex-charts/apexcharts.js')); ?>"></script>
    <!-- Apex Charts -->
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script_2'); ?>
    <script>
        "use strict";

        const hourlyCount = <?php echo e($hourlyCount); ?>;
        const distanceWiseCount = <?php echo e($distanceWiseCount); ?>;
        const daywiseCount = <?php echo e($daywiseCount); ?>;

        document.addEventListener('DOMContentLoaded', function() {
            initializeDonutChart(hourlyCount, distanceWiseCount, daywiseCount);
            const initialTotalSell = [<?php echo e(implode(",", array_map(fn($val) => number_format($val, 2, '.', ''), $total_sell))); ?>];
            const initialCommission = [<?php echo e(implode(",", array_map(fn($val) => number_format($val, 2, '.', ''), $commission))); ?>];
            const initialTotalSubs = [<?php echo e(implode(",", array_map(fn($val) => number_format($val, 2, '.', ''), $total_subs))); ?>];
            const initialLabels = [<?php echo implode(",", $label); ?>];

            initializeAreaChart(initialTotalSell, initialCommission, initialTotalSubs, initialLabels);
        });

    </script>

<script src="<?php echo e(asset('Modules/Rental/public/assets/js/admin/view-pages/dashboard.js')); ?>"></script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/dashboard-rental.blade.php ENDPATH**/ ?>