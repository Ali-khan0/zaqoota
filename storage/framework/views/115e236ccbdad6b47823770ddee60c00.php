<?php $__env->startSection('title', translate('messages.dashboard')); ?>

<?php $__env->startPush('css_or_js'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">

        <?php if(auth('vendor')->check()): ?>
            <div class="page-header">
                <div class="row align-items-center py-2">
                    <div class="col-sm mb-2 mb-sm-0">
                        <div class="d-flex align-items-center">
                            <img class="onerror-image"
                                src="<?php echo e(asset('/public/assets/admin/img/rental/image_car.png')); ?>" width="38" alt="img">
                            <div class="w-0 flex-grow pl-2">
                                <h1 class="page-header-title text-title mb-0">
                                    <?php echo e(translate('messages.Dashboard')); ?></h1>
                                <p class="page-header-text text-title fs-12 m-0"><?php echo e(translate('messages.Monitor_your')); ?>

                                    <strong class="font-bold"> <?php echo e(translate('messages.business')); ?></strong>
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body pt-0">
                    <div class="d-flex flex-wrap align-items-center justify-content-between statistics--title-area">
                        <div class="statistics--title pr-sm-3" id="">
                            <div class="d-flex align-items-center gap-2">
                                <h3 class="page-header-title text-title fs-18 mb-0">
                                    <?php echo e(translate('messages.Delivery_Statistics')); ?></h3>

                            </div>
                        </div>
                        <div class="statistics--select">
                            <select class="custom-select border-0 trip_stats_update" name="statistics_type" data-route="<?php echo e(route('vendor.deliveryStatistics')); ?>">
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
                        <?php echo $__env->make('rental::provider.dashboard._delivery-statistics', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
                                    <h6 class="gross-earning">
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency(collect($commission)->sum())); ?></h6>
                                    <span><?php echo e(translate('messages.Gross_Earnings')); ?></span>
                                </div>
                                <div class="chart--label __chart-label p-0 move-left-100 ml-auto">
                                    <span class="indicator chart-bg-2"></span>
                                    <span class="info">
                                        <?php echo e(translate('Earnings')); ?> (<?php echo e(date('Y')); ?>)
                                    </span>
                                </div>
                                <select
                                        id="commission_overview_stats_update"
                                    class="custom-select border-0 text-center w-auto ml-auto commission_overview_stats_update"
                                    data-route="<?php echo e(route('vendor.commissionOverview')); ?>"
                                    name="commission_overview">
                                    <option value="all">
                                        <?php echo e(translate('All Time')); ?>

                                    </option>
                                    <option value="this_year"
                                        <?php echo e(request()->commission_overview == 'this_year' ? 'selected' : ''); ?>>
                                        <?php echo e(translate('this_year')); ?>

                                    </option>
                                    <option value="this_month"
                                        <?php echo e(request()->commission_overview == 'this_month' ? 'selected' : ''); ?>>
                                        <?php echo e(translate('this_month')); ?>

                                    </option>
                                    <option value="this_week"
                                        <?php echo e(request()->commission_overview == 'this_week' ? 'selected' : ''); ?>>
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
            </div>
        <?php else: ?>
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-sm mb-2 mb-sm-0">
                        <h1 class="page-header-title"><?php echo e(translate('messages.welcome')); ?>,
                            <?php echo e(auth('vendor_employee')->user()->f_name); ?>.</h1>
                        <p class="page-header-text"><?php echo e(translate('messages.employee_welcome_message')); ?></p>
                    </div>
                </div>
            </div>
            <!-- End Page Header -->
        <?php endif; ?>
        <div id="currency" data-currency="<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>"></div>
        <div class="d-none" id="current_url" data-src-url="<?php echo e(url()->current()); ?> "> </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('/public/assets/admin/js/apex-charts/apexcharts.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script_2'); ?>
    <script>
        "use strict";

        document.addEventListener('DOMContentLoaded', function() {
            const initialCommission = [<?php echo e(implode(",", array_map(fn($val) => number_format($val, 2, '.', ''), $commission))); ?>];
            const initialLabels = [<?php echo implode(",", $label); ?>];

            initializeAreaChart(initialCommission, initialLabels);
        });
    </script>
    <script src="<?php echo e(asset('Modules/Rental/public/assets/js/view-pages/provider/dashboard.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/provider/dashboard/dashboard.blade.php ENDPATH**/ ?>