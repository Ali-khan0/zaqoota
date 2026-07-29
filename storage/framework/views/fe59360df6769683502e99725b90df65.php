<?php $__env->startSection('title', translate('Store Report')); ?>

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
                        <?php echo e(translate('Store Wise Report')); ?>

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
                    class="nav-link"><?php echo e(translate('Sales Report')); ?></a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(route('admin.transactions.report.store-order-report')); ?>"
                    class="nav-link active"><?php echo e(translate('Order Report')); ?></a>
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
                    <img src="<?php echo e(asset('/public/assets/admin/img/report/cart.svg')); ?>" alt="">
                    <div class="info">
                        <h4 class="subtitle"><?php echo e($orders->total()); ?></h4>
                        <h6 class="subtext"><?php echo e(translate('messages.Total Order')); ?></h6>
                    </div>
                </div>
                <div class="left-content-card">
                    <img src="<?php echo e(asset('/public/assets/admin/img/report/total-order.svg')); ?>" alt="">
                    <div class="info">
                        <h4 class="subtitle"><?php echo e(\App\CentralLogics\Helpers::number_format_short($total_order_amount)); ?>

                        </h4>
                        <h6 class="subtext"><?php echo e(translate('messages.total_order_amount')); ?></h6>
                    </div>
                    <div class="coupon__discount w-100 text-right d-flex justify-content-between">
                        <div>
                            <strong class="text-danger"><?php echo e(\App\CentralLogics\Helpers::number_format_short($total_canceled)); ?></strong>
                            <div><?php echo e(translate('messages.canceled')); ?></div>
                        </div>
                        <div>
                            <strong><?php echo e(\App\CentralLogics\Helpers::number_format_short($total_ongoing)); ?></strong>
                            <div>
                                <?php echo e(translate('Incomplete')); ?>

                            </div>
                        </div>
                        <div>
                            <strong class="text-success"><?php echo e(\App\CentralLogics\Helpers::number_format_short($total_delivered)); ?></strong>
                            <div>
                                <?php echo e(translate('Completed')); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="left-content-card">
                    <img src="<?php echo e(asset('/public/assets/admin/img/report/total-discount.svg')); ?>" alt="">
                    <div class="info">
                        <h4 class="subtitle">
                            <?php echo e(\App\CentralLogics\Helpers::number_format_short($total_coupon_discount + $total_product_discount)); ?>

                        </h4>
                        <h6 class="subtext"><?php echo e(translate('Total Discount Given')); ?></h6>
                    </div>
                    <div class="coupon__discount w-100 text-right d-flex justify-content-between">
                        <div>
                            <strong><?php echo e(\App\CentralLogics\Helpers::number_format_short($total_coupon_discount)); ?></strong>
                            <div><?php echo e(translate('messages.coupon_discount')); ?></div>
                        </div>
                        <div>
                            <strong><?php echo e(\App\CentralLogics\Helpers::number_format_short($total_product_discount)); ?></strong>
                            <div>
                                <?php echo e(translate('Product Discount')); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="center-chart-area">
                <div class="center-chart-header">
                    <h4 class="title"><?php echo e(translate('Total Orders')); ?></h4>
                    <h5 class="subtitle"><?php echo e(translate('Average Order Value :')); ?>

                        <?php echo e($orders->count() > 0 ? \App\CentralLogics\Helpers::number_format_short($total_order_amount / $orders->total()) : 0); ?>

                        <span class="input-label-secondary text--title" data-toggle="tooltip"
                    data-placement="right"
                    data-original-title="<?php echo e(translate('Average Value of all type of orders.')); ?>">
                    <i class="tio-info-outined"></i>
                </span>
                    </h5>
                </div>
                <canvas id="updatingData" class="store-center-chart"
                    data-hs-chartjs-options='{
                "type": "bar",
                "data": {
                  "labels": [<?php echo e(implode(',', $label)); ?>],
                  "datasets": [{
                    "data": [<?php echo e(implode(',', $data)); ?>],
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
                    <div class="card-header border-0 ">
                        <h5 class="card-title">
                            <span><?php echo e(translate('order statistics')); ?></span>
                        </h5>
                    </div>
                    <div class="card-body px-0 pt-0">
                        <div class="position-relative pie-chart">
                            <div id="dognut-pie"></div>
                            <!-- Total Orders -->
                            <div class="total--orders">
                                <h3><?php echo e($orders->total()); ?>

                                </h3>
                                <span><?php echo e(translate('messages.orders')); ?></span>
                            </div>
                            <!-- Total Orders -->
                        </div>
                        <div class="apex-legends">
                            <div class="before-bg-107980">
                                <span><?php echo e(translate('Total_canceled')); ?>

                                    (<?php echo e($total_canceled_count); ?>)</span>
                            </div>
                            <div class="before-bg-56B98F">
                                <span><?php echo e(translate('Total_ongoing')); ?> (
                                    <?php echo e($total_ongoing_count); ?>)</span>
                            </div>
                            <div class="before-bg-E5F5F1">
                                <span><?php echo e(translate('Total_delivered')); ?>

                                    (<?php echo e($total_delivered_count); ?>)</span>
                            </div>
                        </div>
                        <div class="earning-statistics-content mt-3">
                            <a href="<?php echo e(route('admin.order.list', ['all'])); ?>" class="trx-btn"><?php echo e(translate('View All Orders')); ?></a>
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
                                placeholder="<?php echo e(translate('Search by ID..')); ?>"
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
                                href="<?php echo e(route('admin.transactions.report.store-order-report-export', ['type' => 'excel', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                    alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item"
                                href="<?php echo e(route('admin.transactions.report.store-order-report-export', ['type' => 'csv', request()->getQueryString()])); ?>">
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
                    <table class="table table-borderless middle-align __txt-14px">
                        <thead class="thead-light white--space-false">
                            <tr>
                                <th class="border-top border-bottom text-capitalize"><?php echo e(translate('SL')); ?></th>
                                <th class="border-top border-bottom text-capitalize"><?php echo e(translate('Order ID')); ?></th>
                                <th class="border-top border-bottom text-capitalize"><?php echo e(translate('Order Date')); ?></th>
                                <th class="border-top border-bottom text-capitalize"><?php echo e(translate('Customer Info')); ?></th>
                                <th class="border-top border-bottom text-capitalize"><?php echo e(translate('Total Amount')); ?></th>
                                <th class="border-top border-bottom text-capitalize text-center">
                                    <?php echo e(translate('Discount')); ?></th>
                                <th class="border-top border-bottom text-capitalize text-center"><?php echo e(translate('Tax')); ?>

                                </th>
                                <th class="border-top border-bottom text-capitalize text-center">
                                    <?php echo e(translate('Delivery Charge')); ?></th>
                                <th class="border-top border-bottom text-capitalize text-center">
                                    <?php echo e(\App\CentralLogics\Helpers::get_business_data('additional_charge_name')??translate('messages.additional_charge')); ?></th>
                                <th class="border-top border-bottom text-capitalize text-center"><?php echo e(translate('Action')); ?>

                                </th>
                            </tr>
                        </thead>
                        <tbody id="set-rows">
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="status-<?php echo e($order['order_status']); ?> class-all">
                                    <td class="">
                                        <?php echo e($key + $orders->firstItem()); ?>

                                    </td>
                                    <td class="table-column-pl-0">
                                        <a
                                            href="<?php echo e(route('admin.order.details', ['id' => $order['id'],'module_id'=>$order['module_id']])); ?>"><?php echo e($order['id']); ?></a>
                                    </td>
                                    <td>
                                        <div>
                                            <div>
                                                <?php echo e(date('d M Y', strtotime($order['created_at']))); ?>

                                            </div>
                                            <div class="d-block text-uppercase">
                                                <?php echo e(date(config('timeformat'), strtotime($order['created_at']))); ?>

                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if($order->is_guest): ?>
                                        <?php ($customer_details = json_decode($order['delivery_address'],true)); ?>
                                        <strong><?php echo e($customer_details['contact_person_name']); ?></strong>
                                        <div><?php echo e($customer_details['contact_person_number']); ?></div>
                                        <?php elseif($order->customer): ?>
                                        <a class="text-body text-capitalize"
                                            href="<?php echo e(route('admin.transactions.customer.view', [$order['user_id']])); ?>">
                                            <strong><?php echo e($order->customer['f_name'] . ' ' . $order->customer['l_name']); ?></strong>
                                            <div><?php echo e($order->customer['phone']); ?></div>
                                        </a>
                                        <?php else: ?>
                                            <label class="badge badge-danger"><?php echo e(translate('messages.invalid_customer_data')); ?></label>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="text-right mw--85px">
                                            <div>
                                                <?php echo e(\App\CentralLogics\Helpers::number_format_short($order['order_amount'])); ?>

                                            </div>
                                            <?php if($order->payment_status == 'paid'): ?>
                                                <strong class="text-success">
                                                    <?php echo e(translate('messages.paid')); ?>

                                                </strong>
                                            <?php else: ?>
                                                <strong class="text-danger">
                                                    <?php echo e(translate('messages.unpaid')); ?>

                                                </strong>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="text-center mw--85px">
                                        <?php echo e(\App\CentralLogics\Helpers::number_format_short($order['coupon_discount_amount'] + $order['store_discount_amount']  + $order['ref_bonus_amount'])); ?>

                                    </td>
                                    <td class="text-center mw--85px">
                                        <?php echo e(\App\CentralLogics\Helpers::number_format_short($order['total_tax_amount'])); ?>

                                    </td>
                                    <td class="text-center mw--85px">
                                        <?php echo e(\App\CentralLogics\Helpers::number_format_short($order['original_delivery_charge'])); ?>

                                    </td>
                                    <td class="text-center mw--85px">
                                        <?php echo e(\App\CentralLogics\Helpers::number_format_short($order['additional_charge'])); ?>

                                    </td>

                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a class="ml-2 btn btn-sm btn--warning btn-outline-warning action-btn"
                                                href="<?php echo e(route('admin.order.details', ['id' => $order['id'],'module_id'=>$order['module_id']])); ?>">
                                                <i class="tio-invisible"></i>
                                            </a>
                                            <a class="ml-2 btn btn-sm btn--primary btn-outline-primary action-btn"
                                                href="<?php echo e(route('admin.transactions.order.generate-invoice', ['id' => $order['id']])); ?>">
                                                <i class="tio-print"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <!-- End Table -->


                <?php if(count($orders) !== 0): ?>
                    <hr>
                    <div class="page-area">
                        <?php echo $orders->withQueryString()->links(); ?>

                    </div>
                <?php endif; ?>
                <?php if(count($orders) === 0): ?>
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
    <!-- Apex Charts -->
<?php $__env->stopPush(); ?>


<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chart.js.extensions/chartjs-extensions.js"></script>
    <script
        src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js">
    </script>


    <!-- Apex Charts -->
    <script src="<?php echo e(asset('/public/assets/admin/js/apex-charts/apexcharts.js')); ?>"></script>
    <!-- Dognut Pie Chart -->
    <script>
        "use strict";
        let options = {
            series: [<?php echo e($total_canceled_count); ?>, <?php echo e($total_ongoing_count); ?>, <?php echo e($total_delivered_count); ?>],
            chart: {
                width: 320,
                type: 'donut',
            },
            labels: ['<?php echo e(translate('Total canceled')); ?> (<?php echo e($total_canceled_count); ?>)',
                '<?php echo e(translate('Total ongoing')); ?> (<?php echo e($total_ongoing_count); ?>)',
                '<?php echo e(translate('Total delivered')); ?>  (<?php echo e($total_delivered_count); ?>)'
            ],
            dataLabels: {
                enabled: false,
                style: {
                    colors: ['#ffffff', '#ffffff', '#107980']
                }
            },
            responsive: [{
                breakpoint: 1650,
                options: {
                    chart: {
                        width: 260
                    },
                }
            }],
            colors: ['#107980', '#56B98F', '#111'],
            fill: {
                colors: ['#107980', '#56B98F', '#E5F5F1']
            },
            legend: {
                show: false
            },
        };

        let chart = new ApexCharts(document.querySelector("#dognut-pie"), options);
        chart.render();

    <!-- Dognut Pie Chart -->



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

        $('#search-form').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '<?php echo e(route('admin.transactions.report.store-order-report-search')); ?>',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    $('#set-rows').html(data.view);
                    $('.page-area').hide();
                },
                complete: function() {
                    $('#loading').hide();
                },
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/report/store-order-report.blade.php ENDPATH**/ ?>