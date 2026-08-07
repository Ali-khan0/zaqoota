<?php $__env->startSection('title',translate('Provider Report')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header report-page-header">
        <div class="d-flex">
            <img src="<?php echo e(asset('public/assets/admin/img/store-report.svg')); ?>" class="page-header-icon" alt="">
            <div class="w-0 flex-grow-1 pl-3">
                <h1 class="page-header-title m-0">
                    <?php echo e(translate('Provider Report')); ?>

                </h1>
                <span>
                    <?php echo e(translate('Monitor_provider’s_business_analytics_&_Reports')); ?>

                </span>
            </div>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- Page Header Menu -->
    <ul class="nav nav-tabs page-header-tabs mb-2">
        <li class="nav-item">
            <a href="<?php echo e(route('admin.transactions.rental.report.provider-summary-report')); ?>" class="nav-link active"><?php echo e(translate('Summary Report')); ?></a>
        </li>
        <li class="nav-item">
            <a href="<?php echo e(route('admin.transactions.rental.report.provider-sales-report')); ?>" class="nav-link"><?php echo e(translate('Vehicle Report')); ?></a>
        </li>
        <li class="nav-item">
            <a href="<?php echo e(route('admin.transactions.rental.report.provider-trip-report')); ?>" class="nav-link"><?php echo e(translate('Trip Report')); ?></a>
        </li>
    </ul>

    <div class="card border-0 mb-3">
        <div class="card-body">
            <div class="statistics-btn-grp">
                <label>
                    <input type="radio" name="filter" value="all_time" <?php echo e(isset($filter) && $filter == "all_time" ? 'checked' : ''); ?> data-url="<?php echo e(url()->full()); ?>" data-filter="filter" class="set-filter" hidden>
                    <span><?php echo e(translate('All Time')); ?></span>
                </label>
                <label>
                    <input type="radio" name="filter" value="this_year" <?php echo e(isset($filter) && $filter == "this_year" ? 'checked' : ''); ?> data-url="<?php echo e(url()->full()); ?>" data-filter="filter" class="set-filter" hidden>
                    <span><?php echo e(translate('This Year')); ?></span>
                </label>
                <label>
                    <input type="radio" name="filter" value="previous_year" <?php echo e(isset($filter) && $filter == "previous_year" ? 'checked' : ''); ?> data-url="<?php echo e(url()->full()); ?>" data-filter="filter" class="set-filter" hidden>
                    <span><?php echo e(translate('Previous Year')); ?></span>
                </label>
                <label>
                    <input type="radio" name="filter" value="this_month" <?php echo e(isset($filter) && $filter == "this_month" ? 'checked' : ''); ?> data-url="<?php echo e(url()->full()); ?>" data-filter="filter" class="set-filter" hidden>
                    <span><?php echo e(translate('This Month')); ?></span>
                </label>
                <label>
                    <input type="radio" name="filter" value="this_week" <?php echo e(isset($filter) && $filter == "this_week" ? 'checked' : ''); ?> data-url="<?php echo e(url()->full()); ?>" data-filter="filter" class="set-filter" hidden>
                    <span><?php echo e(translate('This Week')); ?></span>
                </label>
            </div>
        </div>
    </div>
    <div class="store-report-content">
        <div class="left-content">
            <div class="left-content-card">
                <img src="<?php echo e(asset('/public/assets/admin/img/report/store.svg')); ?>" alt="">
                <div class="info">
                    <h4 class="subtitle"><?php echo e($new_providers); ?></h4>
                    <h6 class="subtext"><?php echo e(translate('messages.Registered Providers')); ?></h6>
                </div>
            </div>
            <div class="left-content-card">
                <img src="<?php echo e(asset('/public/assets/admin/img/report/cart.svg')); ?>" alt="">
                <div class="info">
                    <h4 class="subtitle"><?php echo e($trips->count()); ?></h4>
                    <h6 class="subtext"><?php echo e(translate('messages.Total Trips')); ?></h6>
                </div>
                <div class="coupon__discount w-100 text-right d-flex justify-content-between">
                    <div>
                        <strong class="text-danger"><?php echo e($total_canceled); ?></strong>
                        <div><?php echo e(translate('messages.canceled')); ?></div>
                    </div>
                    <div>
                        <strong><?php echo e($total_ongoing); ?></strong>
                        <div>
                            <?php echo e(translate('Incomplete')); ?>

                        </div>
                    </div>
                    <div>
                        <strong class="text-success"><?php echo e($total_completed); ?></strong>
                        <div>
                            <?php echo e(translate('Completed')); ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="left-content-card">
                <img src="<?php echo e(asset('/public/assets/admin/img/report/product.svg')); ?>" alt="">
                <div class="info">
                    <h4 class="subtitle"><?php echo e($vehicles); ?></h4>
                    <h6 class="subtext"><?php echo e(translate('Total Vehicles')); ?></h6>
                </div>
            </div>
        </div>
        <div class="center-chart-area">
            <div class="center-chart-header">
                <h4 class="title"><?php echo e(translate('Total Trips')); ?></h4>
                <h5 class="subtitle"><?php echo e(translate('Average Trip Value :')); ?>

                    <?php echo e($total_completed > 0 ? \App\CentralLogics\Helpers::number_format_short($total_trip_amount/ $total_completed) : 0); ?>

                    <span class="input-label-secondary text--title" data-toggle="tooltip"
                    data-placement="right"
                    data-original-title="<?php echo e(translate('This Average Trip Value is calculated from all completed trips.')); ?>">
                    <i class="tio-info-outined"></i>
                </span></h5>
            </div>

            <canvas id="updatingData" class="store-center-chart"
                    data-chart-labels='[<?php echo e(implode(',', $label)); ?>]'
                    data-chart-data='[<?php echo e(implode(',', $data)); ?>]'
                    data-chart-currency-symbol="<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>">
            </canvas>

        </div>
         <div class="right-content">
            <!-- Dognut Pie -->
            <div class="card h-100 bg-white payment-statistics-shadow">
                <div class="card-header border-0 ">
                    <h5 class="card-title">
                        <span><?php echo e(translate('Completed payment statistics')); ?></span>
                    </h5>
                </div>
                <div class="card-body px-0 pt-0">
                    <div class="position-relative pie-chart">
                        <div id="dognut-pie"></div>
                        <!-- Total Trips -->
                        <div class="total--orders">
                            <h3><?php echo e(\App\CentralLogics\Helpers::number_format_short($total_trip_amount)); ?>

                            </h3>
                        </div>
                        <!-- Total Trips -->
                    </div>
                    <div class="apex-legends">
                        <div class="before-bg-107980">
                            <span><?php echo e(translate('Cash Payments')); ?>

                                (<?php echo e(count($trip_payment_methods)>0?\App\CentralLogics\Helpers::number_format_short(isset($trip_payment_methods[0])?$trip_payment_methods[0]->total_trip_amount:0):0); ?>)</span>
                        </div>
                        <div class="before-bg-56B98F">
                            <span><?php echo e(translate('Digital Payments')); ?> (
                                <?php echo e(count($trip_payment_methods)>0?\App\CentralLogics\Helpers::number_format_short(isset($trip_payment_methods[1])?$trip_payment_methods[1]->total_trip_amount:0):0); ?>)</span>
                        </div>
                        <div class="before-bg-E5F5F1">
                            <span><?php echo e(translate('messages.Wallet')); ?>

                                (<?php echo e(count($trip_payment_methods)>0?\App\CentralLogics\Helpers::number_format_short(isset($trip_payment_methods[2])?$trip_payment_methods[2]->total_trip_amount:0):0); ?>)</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Dognut Pie -->
        </div>
    </div>

    <div class="mt-11px card">
        <div class="card-header border-0 py-2">
            <div class="search--button-wrapper">
                <h5 class="card-title"><?php echo e(translate('messages.Total Providers')); ?>

                    <span class="badge badge-soft-dark ml-2 rounded-circle" id="itemCount"><?php echo e($providers->total()); ?></span>
                </h5>
                <form class="search-form">
                                <!-- Search -->
                    
                    <div class="input-group input--group">
                        <input id="datatableSearch_" type="search" name="search" class="form-control"
                                placeholder="<?php echo e(translate('ex_:_Search_Provider_Name')); ?>" value="<?php echo e(request()?->search ?? null); ?>" aria-label="<?php echo e(translate('messages.search')); ?>" required>
                        <button type="button" class="btn btn--secondary"><i class="tio-search"></i></button>

                    </div>
                    <!-- End Search -->
                </form>
                <!-- Unfold -->
                <div class="hs-unfold mr-2">
                    <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle min-height-40" href="javascript:;"
                        data-hs-unfold-options='{
                                "target": "#usersExportDropdown",
                                "type": "css-animation"
                            }'>
                        <i class="tio-download-to mr-1"></i> <?php echo e(translate('messages.export')); ?>

                    </a>

                    <div id="usersExportDropdown"
                        class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                        <span class="dropdown-header"><?php echo e(translate('messages.download_options')); ?></span>
                        <a id="export-excel" class="dropdown-item" href="<?php echo e(route('admin.transactions.rental.report.provider-summary-report-export', ['type'=>'excel',request()->getQueryString()])); ?>">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                alt="Image Description">
                            <?php echo e(translate('messages.excel')); ?>

                        </a>
                        <a id="export-csv" class="dropdown-item" href="<?php echo e(route('admin.transactions.rental.report.provider-summary-report-export', ['type'=>'csv',request()->getQueryString()])); ?>">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                alt="Image Description">
                            .<?php echo e(translate('messages.csv')); ?>

                        </a>
                    </div>
                </div>
                <!-- End Unfold -->
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <thead class="thead-light white--space-false">
                        <tr>
                            <th class="border-top border-bottom text-capitalize"><?php echo e(translate('SL')); ?></th>
                            <th class="border-top border-bottom text-capitalize"><?php echo e(translate('Provider')); ?></th>
                            <th class="border-top border-bottom text-capitalize text-center"><?php echo e(translate('Total Amount')); ?></th>
                            <th class="border-top border-bottom text-capitalize"><?php echo e(translate('Total Trips')); ?></th>
                            <th class="border-top border-bottom text-capitalize"><?php echo e(translate('Total Completed Trips')); ?></th>
                            <th class="border-top border-bottom text-capitalize text-center"><?php echo e(translate('Trip Completion Rate')); ?></th>
                            <th class="border-top border-bottom text-capitalize text-center"><?php echo e(translate('Ongoing Trip Rate')); ?></th>
                            <th class="border-top border-bottom text-capitalize text-center"><?php echo e(translate('Trip Cancelation Rate')); ?></th>
                            <th class="border-top border-bottom text-capitalize text-center"><?php echo e(translate('Action')); ?></th>
                        </tr>
                    </thead>
                    <tbody id="set-rows">
                    <?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php ($completed = $provider->trips->where('trip_status', 'completed')->count()); ?>
                        <?php ($canceled = $provider->trips->where('trip_status', 'canceled')->count()); ?>
                        <tr>
                            <td><?php echo e($k+$providers->firstItem()); ?></td>
                            <td>
                                <a href="<?php echo e(route('admin.rental.provider.details', $provider->id)); ?>"><?php echo e($provider->name); ?></a>
                            </td>
                            <td class="text-center white-space-nowrap">
                                <?php echo e(\App\CentralLogics\Helpers::number_format_short($provider->trips->where('trip_status','completed')->sum('trip_amount'))); ?>

                            </td>
                            <td class="text-center">
                                <?php echo e($provider->trips->count()); ?>

                            </td>
                            <td class="text-center">
                                <?php echo e($completed); ?>

                            </td>
                            <td class="text-center white-space-nowrap">
                                <?php echo e(($provider->trips->count() > 0 && $completed > 0)? number_format((100*$completed)/$provider->trips->count(), config('round_up_to_digit')): 0); ?>%
                            </td>
                            <td class="text-center">
                                <?php echo e(($provider->trips->count() > 0 && $completed > 0)? number_format((100*($provider->trips->count()-($completed+$canceled)))/$provider->trips->count(), config('round_up_to_digit')): 0); ?>%
                            </td>
                            <td class="text-center">
                                <?php echo e(($provider->trips->count() > 0 && $canceled > 0)? number_format((100*$canceled)/$provider->trips->count(), config('round_up_to_digit')): 0); ?>%
                            </td>
                            <td>
                                <div class="btn--container justify-content-center">
                                    <a href="<?php echo e(route('admin.rental.provider.details', $provider->id)); ?>" class="action-btn btn--primary btn-outline-primary">
                                        <i class="tio-invisible"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php if(count($providers) !== 0): ?>
                <hr>
                <div class="page-area">
                    <?php echo $providers->withQueryString()->links(); ?>

                </div>
                <?php endif; ?>
                <?php if(count($providers) === 0): ?>
                <div class="empty--data">
                    <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                    <h5>
                        <?php echo e(translate('no_data_found')); ?>

                    </h5>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- End Body -->
    </div>


</div>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chart.js.extensions/chartjs-extensions.js"></script>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js"></script>
    <!-- Apex Charts -->
    <script src="<?php echo e(asset('/public/assets/admin/js/apex-charts/apexcharts.js')); ?>"></script>
    <!-- Apex Charts -->
    <script src="<?php echo e(asset('Modules/Rental/public/assets/js/admin/view-pages/provider-summary-report.js')); ?>"></script>

    <!-- Dognut Pie Chart -->
    <script>
        "use strict";
        window.chartData = {
        series: <?php echo json_encode([
            $trip_payment_methods[0]->trip_count ?? 0, $trip_payment_methods[1]->trip_count ?? 0, $trip_payment_methods[2]->trip_count ?? 0
        ]) ?>,
        labels: <?php echo json_encode([
            __('Cash Payments') . ' (' . ($trip_payment_methods[0]->total_trip_amount ?? 0) . ')', __('Digital Payments') . ' (' . ($trip_payment_methods[1]->total_trip_amount ?? 0) . ')', __('Wallet') . ' (' . ($trip_payment_methods[2]->total_trip_amount ?? 0) . ')'
        ]) ?>
    };

</script>


<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/report/provider-summary-report.blade.php ENDPATH**/ ?>