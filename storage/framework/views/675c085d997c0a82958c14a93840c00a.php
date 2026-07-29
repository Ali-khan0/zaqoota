<?php $__env->startSection('title', translate('Store Report')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="content container-fluid">
        <?php
            $from = session('from_date');
            $to = session('to_date');
        ?>

        <!-- Page Header -->
        <div class="page-header report-page-header">
            <div class="d-flex">
                <img src="<?php echo e(asset('public/assets/admin/img/store-report.svg')); ?>" class="page-header-icon" alt="">
                <div class="w-0 flex-grow-1 pl-3">
                    <h1 class="page-header-title m-0">
                        <?php echo e(translate('Store Report')); ?>

                    </h1>
                    <span>
                        <?php echo e(translate('Monitor_store’s_business_analytics_&_Reports')); ?>

                    </span>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Page Header Menu -->
        <ul class="nav nav-tabs page-header-tabs mb-2">
            <li class="nav-item">
                <a href="<?php echo e(route('admin.transactions.report.store-summary-report')); ?>"
                    class="nav-link"><?php echo e(translate('Summary Report')); ?></a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(route('admin.transactions.report.store-sales-report')); ?>"
                    class="nav-link active"><?php echo e(translate('Sales Report')); ?></a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(route('admin.transactions.report.store-order-report')); ?>"
                    class="nav-link"><?php echo e(translate('Order Report')); ?></a>
            </li>
        </ul>

        <div class="card filter--card">
            <div class="card-body p-xl-5">
                <h5 class="form-label m-0 mb-3">
                    <?php echo e(translate('Filter Data')); ?>

                </h5>
                <form action="<?php echo e(route('admin.transactions.report.set-date')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="row g-3">
                        <div class="col-md-4 col-sm-6">
                            <select name="zone_id" class="form-control js-select2-custom set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="zone_id" id="zone">
                                <option value="all"><?php echo e(translate('messages.All_Zones')); ?></option>
                                <?php $__currentLoopData = \App\Models\Zone::orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($z['id']); ?>"
                                        <?php echo e(isset($zone) && $zone->id == $z['id'] ? 'selected' : ''); ?>>
                                        <?php echo e($z['name']); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <select name="store_id"
                                    data-placeholder="<?php echo e(translate('messages.select_store')); ?>"
                                    class="js-data-example-ajax form-control set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="store_id">
                                <?php if(isset($store)): ?>
                                    <option value="<?php echo e($store->id); ?>" selected><?php echo e($store->name); ?></option>
                                <?php else: ?>
                                    <option value="all" selected><?php echo e(translate('messages.all_stores')); ?></option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <select class="form-control set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="filter" name="filter">
                                <option value="all_time" <?php echo e(isset($filter) && $filter == 'all_time' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.All Time')); ?></option>
                                <option value="this_year" <?php echo e(isset($filter) && $filter == 'this_year' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.This Year')); ?></option>
                                <option value="previous_year"
                                    <?php echo e(isset($filter) && $filter == 'previous_year' ? 'selected' : ''); ?>><?php echo e(translate('messages.Previous Year')); ?>

                                </option>
                                <option value="this_month"
                                    <?php echo e(isset($filter) && $filter == 'this_month' ? 'selected' : ''); ?>><?php echo e(translate('messages.This Month')); ?></option>
                                <option value="this_week" <?php echo e(isset($filter) && $filter == 'this_week' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.This Week')); ?></option>
                                <option value="custom" <?php echo e(isset($filter) && $filter == 'custom' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('Custom')); ?></option>
                            </select>
                        </div>
                        <?php if(isset($filter) && $filter == 'custom'): ?>
                        <div class="col-md-4 col-sm-6">
                            <input type="date" name="from" id="from_date"
                                <?php echo e(session()->has('from_date') ? 'value=' . session('from_date') : ''); ?>

                                class="form-control" required>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <input type="date" name="to" id="to_date"
                                <?php echo e(session()->has('to_date') ? 'value=' . session('to_date') : ''); ?> class="form-control"
                                required>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <button type="submit" class="btn btn--primary btn-block"><?php echo e(translate('show_data')); ?></button>
                        </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>


        <div class="store-report-content mt-11px">
            <div class="left-content">
                <div class="left-content-card">
                    <img src="<?php echo e(asset('/public/assets/admin/img/report/gross.svg')); ?>" alt="">
                    <div class="info">
                        <h4 class="subtitle">
                            <?php echo e(\App\CentralLogics\Helpers::number_format_short($orders->sum('order_amount'))); ?></h4>
                        <h6 class="subtext"><?php echo e(translate('Gross Sale')); ?></h6>
                    </div>
                </div>
                <div class="left-content-card">
                    <img src="<?php echo e(asset('/public/assets/admin/img/report/tax.svg')); ?>" alt="">
                    <div class="info">
                        <h4 class="subtitle">
                            <?php echo e(\App\CentralLogics\Helpers::number_format_short($orders->sum('total_tax_amount'))); ?></h4>
                        <h6 class="subtext"><?php echo e(translate('Total Tax')); ?></h6>
                    </div>
                </div>
                <div class="left-content-card">
                    <img src="<?php echo e(asset('/public/assets/admin/img/report/commission.svg')); ?>" alt="">
                    <div class="info">
                        <h4 class="subtitle">
                            <?php echo e(\App\CentralLogics\Helpers::number_format_short($orders->sum('transaction_sum_admin_commission')+$orders->sum('transaction_sum_delivery_fee_comission')-$orders->sum('transaction_sum_admin_expense'))); ?>

                        </h4>
                        <h6 class="subtext"><?php echo e(translate('Total Commission')); ?></h6>
                    </div>
                </div>
            </div>
            <div class="center-chart-area">
                <div class="center-chart-header">
                    <h4 class="title"><?php echo e(translate('Total Orders')); ?></h4>
                    <h5 class="subtitle"><?php echo e(translate('Average Order Value :')); ?>

                        <?php echo e($orders->count() > 0 ? \App\CentralLogics\Helpers::number_format_short($orders->sum('order_amount') / $orders->count()) : 0); ?>

                        <span class="input-label-secondary text--title" data-toggle="tooltip"
                    data-placement="right"
                    data-original-title="<?php echo e(translate('Average Value of completed orders.')); ?>">
                    <i class="tio-info-outined"></i>
                </span>
                    </h5>
                </div>
                <canvas id="updatingData" class="store-center-chart"
                    data-hs-chartjs-options='{
                    "type": "bar",
                    "data": {
                      "labels": [<?php echo e(implode(",",$label)); ?>],
                      "datasets": [{
                        "data": [<?php echo e(implode(",",$data)); ?>],
                        "backgroundColor": "#82CFCF",
                        "hoverBackgroundColor": "#82CFCF",
                        "borderColor": "#82CFCF"
                      }]
                    },
                    "options": {
                      "scales": {
                        "yAxes": [{
                          "gridLines": {
                            "color": "#e7eaf3",
                            "drawBorder": false,
                            "zeroLineColor": "#e7eaf3"
                          },
                          "ticks": {
                            "beginAtZero": true,
                            "stepSize": <?php echo e(ceil((array_sum($data)/10000))*2000); ?>,
                            "fontSize": 12,
                            "fontColor": "#97a4af",
                            "fontFamily": "Open Sans, sans-serif",
                            "padding": 5,
                            "postfix": " <?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>"
                          }
                        }],
                        "xAxes": [{
                          "gridLines": {
                            "display": false,
                            "drawBorder": false
                          },
                          "ticks": {
                            "fontSize": 12,
                            "fontColor": "#97a4af",
                            "fontFamily": "Open Sans, sans-serif",
                            "padding": 5
                          },
                          "categoryPercentage": 0.3,
                          "maxBarThickness": "10"
                        }]
                      },
                      "cornerRadius": 5,
                      "tooltips": {
                        "prefix": " ",
                        "hasIndicator": true,
                        "mode": "index",
                        "intersect": false
                      },
                      "hover": {
                        "mode": "nearest",
                        "intersect": true
                      }
                    }
                  }'>
                </canvas>
            </div>
            <div class="right-content">
                <!-- Dognut Pie -->
                <div class="card h-100 bg-white payment-statistics-shadow">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="earning-statistics-content">
                            <h6 class="subtitle"><?php echo e(translate('Total Store Earnings')); ?></h6>
                            <h3 class="title">
                                <?php echo e(\App\CentralLogics\Helpers::number_format_short($orders->sum('transaction_sum_store_amount'))); ?>

                            </h3>
                        </div>
                    </div>
                </div>
                <!-- Dognut Pie -->
            </div>
        </div>

        <div class="mt-11px card">
            <div class="card-header border-0 py-2">
                <div class="search--button-wrapper">
                    <h5 class="card-title"><?php echo e(translate('Total Sales')); ?></h5>
                    <form class="search-form">
                        <!-- Search -->
                        
                        <div class="input-group input--group">
                            <input id="datatableSearch_" type="search" name="search" class="form-control"
                                placeholder="<?php echo e(translate('Search by product..')); ?>"
                                aria-label="<?php echo e(translate('messages.search')); ?>" value="<?php echo e(request()?->search ?? null); ?>" required>
                            <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>

                        </div>
                        <!-- End Search -->
                    </form>
                    <!-- Unfold -->
                    <div class="hs-unfold mr-2">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle min-height-40"
                            href="javascript:;"
                            data-hs-unfold-options='{
                                "target": "#usersExportDropdown",
                                "type": "css-animation"
                            }'>
                            <i class="tio-download-to mr-1"></i> <?php echo e(translate('messages.export')); ?>

                        </a>

                        <div id="usersExportDropdown"
                            class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                            <span class="dropdown-header"><?php echo e(translate('messages.download_options')); ?></span>
                            <a id="export-excel" class="dropdown-item"
                                href="<?php echo e(route('admin.transactions.report.store-sales-report-export', ['type' => 'excel', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                    alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item"
                                href="<?php echo e(route('admin.transactions.report.store-sales-report-export', ['type' => 'csv', request()->getQueryString()])); ?>">
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
                                <th class="border-top border-bottom text-capitalize"><?php echo e(translate('Product')); ?></th>
                                <th class="border-top border-bottom text-capitalize text-center"><?php echo e(translate('QTY Sold')); ?></th>
                                <th class="border-top border-bottom text-capitalize text-center">
                                    <?php echo e(translate('Gross Sale')); ?></th>
                                <th class="border-top border-bottom text-capitalize text-center">
                                    <?php echo e(translate('Discount Given')); ?></th>
                                <th class="border-top border-bottom text-capitalize text-center"><?php echo e(translate('Action')); ?>

                                </th>
                            </tr>
                        </thead>
                        <tbody id="set-rows">

                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key + $items->firstItem()); ?></td>
                                    <td>
                                        <a class="media align-items-center"
                                            href="<?php echo e(route('admin.item.view', [$item['id'], 'module_id'=>$item['module_id']])); ?>">
                                            <div class="media-body">
                                                <h5 class="text-hover-primary mb-0"><?php echo e($item['name']); ?></h5>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <?php echo e($item->orders_sum_quantity ?? 0); ?>

                                    </td>
                                    <td class="text-center">
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($item->orders_sum_price)); ?>

                                    </td>
                                    <td class="text-center">
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($item->total_discount)); ?>

                                    </td>
                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a href="<?php echo e(route('admin.item.view', [$item['id'], 'module_id'=>$item['module_id']])); ?>"
                                                class="action-btn btn--primary btn-outline-primary">
                                                <i class="tio-invisible"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <?php if(count($items) !== 0): ?>
                        <hr>
                        <div class="page-area">
                            <?php echo $items->withQueryString()->links(); ?>

                        </div>
                    <?php endif; ?>
                    <?php if(count($items) === 0): ?>
                        <div class="empty--data">
                            <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                            <h5>
                                <?php echo e(translate('no_data_found')); ?>

                            </h5>
                        </div>
                    <?php endif; ?>
                </div>
            </div>


        </div>

    <?php $__env->stopSection(); ?>


    <?php $__env->startPush('script'); ?>
    <?php $__env->stopPush(); ?>


    <?php $__env->startPush('script_2'); ?>
        <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chart.js/dist/Chart.min.js"></script>
        <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chart.js.extensions/chartjs-extensions.js"></script>
        <script
            src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js">
        </script>
        <script>
            "use strict";
            // Bar Charts
            Chart.plugins.unregister(ChartDataLabels);

            $('.js-chart').each(function() {
                $.HSCore.components.HSChartJS.init($(this));
            });

            let updatingChart = $.HSCore.components.HSChartJS.init($('#updatingData'));

            $('.js-data-example-ajax').select2({
                ajax: {
                    url: '<?php echo e(url('/')); ?>/admin/store/get-stores',
                    data: function(params) {
                        return {
                            q: params.term, // search term
                            // all:true,
                            <?php if(isset($zone)): ?>
                                zone_ids: [<?php echo e($zone->id); ?>],
                            <?php endif; ?>
                            page: params.page
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    __port: function(params, success, failure) {
                        let $request = $.ajax(params);

                        $request.then(success);
                        $request.fail(failure);

                        return $request;
                    }
                }
            });

        </script>
    <?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/report/store-sales-report.blade.php ENDPATH**/ ?>