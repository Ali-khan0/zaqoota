<?php $__env->startSection('title',translate('Store Report')); ?>

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
            <a href="<?php echo e(route('admin.transactions.report.store-summary-report')); ?>" class="nav-link active"><?php echo e(translate('Summary Report')); ?></a>
        </li>
        <li class="nav-item">
            <a href="<?php echo e(route('admin.transactions.report.store-sales-report')); ?>" class="nav-link"><?php echo e(translate('Sales Report')); ?></a>
        </li>
        <li class="nav-item">
            <a href="<?php echo e(route('admin.transactions.report.store-order-report')); ?>" class="nav-link"><?php echo e(translate('Order Report')); ?></a>
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
                    <h4 class="subtitle"><?php echo e($new_stores); ?></h4>
                    <h6 class="subtext"><?php echo e(translate('messages.Registered Stores')); ?></h6>
                </div>
            </div>
            <div class="left-content-card">
                <img src="<?php echo e(asset('/public/assets/admin/img/report/cart.svg')); ?>" alt="">
                <div class="info">
                    <h4 class="subtitle"><?php echo e($orders->count()); ?></h4>
                    <h6 class="subtext"><?php echo e(translate('messages.Total Orders')); ?></h6>
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
                        <strong class="text-success"><?php echo e($total_delivered); ?></strong>
                        <div>
                            <?php echo e(translate('Completed')); ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="left-content-card">
                <img src="<?php echo e(asset('/public/assets/admin/img/report/product.svg')); ?>" alt="">
                <div class="info">
                    <h4 class="subtitle"><?php echo e($items->count()); ?></h4>
                    <h6 class="subtext"><?php echo e(translate('New Items')); ?></h6>
                </div>
            </div>
        </div>
        <div class="center-chart-area">
            <div class="center-chart-header">
                <h4 class="title"><?php echo e(translate('Total Orders')); ?></h4>
                <h5 class="subtitle"><?php echo e(translate('Average Order Value :')); ?>

                    <?php echo e($total_delivered > 0 ? \App\CentralLogics\Helpers::number_format_short($total_order_amount/ $total_delivered) : 0); ?>

                    <span class="input-label-secondary text--title" data-toggle="tooltip"
                    data-placement="right"
                    data-original-title="<?php echo e(translate('Average Value of completed orders.')); ?>">
                    <i class="tio-info-outined"></i>
                </span></h5>
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
                        <span><?php echo e(translate('Completed payment statistics')); ?></span>
                    </h5>
                </div>
                <div class="card-body px-0 pt-0">
                    <div class="position-relative pie-chart">
                        <div id="dognut-pie"></div>
                        <!-- Total Orders -->
                        <div class="total--orders">
                            <h3><?php echo e(\App\CentralLogics\Helpers::number_format_short($total_order_amount)); ?>

                            </h3>
                            
                        </div>
                        <!-- Total Orders -->
                    </div>
                    <div class="apex-legends">
                        <div class="before-bg-107980">
                            <span><?php echo e(translate('Cash Payments')); ?>

                                (<?php echo e(count($order_payment_methods)>0?\App\CentralLogics\Helpers::number_format_short(isset($order_payment_methods[0])?$order_payment_methods[0]->total_order_amount:0):0); ?>)</span>
                        </div>
                        <div class="before-bg-56B98F">
                            <span><?php echo e(translate('Digital Payments')); ?> (
                                <?php echo e(count($order_payment_methods)>0?\App\CentralLogics\Helpers::number_format_short(isset($order_payment_methods[1])?$order_payment_methods[1]->total_order_amount:0):0); ?>)</span>
                        </div>
                        <div class="before-bg-E5F5F1">
                            <span><?php echo e(translate('messages.Wallet')); ?>

                                (<?php echo e(count($order_payment_methods)>0?\App\CentralLogics\Helpers::number_format_short(isset($order_payment_methods[2])?$order_payment_methods[2]->total_order_amount:0):0); ?>)</span>
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
                <h5 class="card-title"><?php echo e(translate('messages.Total Stores')); ?></h5>
                <form class="search-form">
                                <!-- Search -->
                    
                    <div class="input-group input--group">
                        <input id="datatableSearch_" type="search" name="search" class="form-control"
                                placeholder="<?php echo e(translate('ex_:_Search_Store_Name')); ?>" value="<?php echo e(request()?->search ?? null); ?>" aria-label="<?php echo e(translate('messages.search')); ?>" required>
                        <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>

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
                        <a id="export-excel" class="dropdown-item" href="<?php echo e(route('admin.transactions.report.store-summary-report-export', ['type'=>'excel',request()->getQueryString()])); ?>">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                alt="Image Description">
                            <?php echo e(translate('messages.excel')); ?>

                        </a>
                        <a id="export-csv" class="dropdown-item" href="<?php echo e(route('admin.transactions.report.store-summary-report-export', ['type'=>'csv',request()->getQueryString()])); ?>">
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
                            <th class="border-top border-bottom text-capitalize"><?php echo e(translate('Store')); ?></th>
                            <th class="border-top border-bottom text-capitalize"><?php echo e(translate('Total Order')); ?></th>
                            <th class="border-top border-bottom text-capitalize"><?php echo e(translate('Total Delivered Order')); ?></th>
                            <th class="border-top border-bottom text-capitalize text-center"><?php echo e(translate('Total Amount')); ?></th>
                            <th class="border-top border-bottom text-capitalize text-center"><?php echo e(translate('Completion Rate')); ?></th>
                            <th class="border-top border-bottom text-capitalize text-center"><?php echo e(translate('Ongoing Rate')); ?></th>
                            <th class="border-top border-bottom text-capitalize text-center"><?php echo e(translate('Cancelation Rate')); ?></th>
                            <th class="border-top border-bottom text-capitalize text-center"><?php echo e(translate('Refund Request')); ?></th>
                            <th class="border-top border-bottom text-capitalize text-center"><?php echo e(translate('Action')); ?></th>
                        </tr>
                    </thead>
                    <tbody id="set-rows">
                    <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php ($delivered = $store->orders->where('order_status', 'delivered')->count()); ?>
                        <?php ($canceled = $store->orders->where('order_status', 'canceled')->count()); ?>
                        <?php ($refunded = $store->orders->where('order_status', 'refunded')->count()); ?>
                        <?php ($refund_requested = $store->orders->whereNotNull('refund_requested')->count()); ?>
                        <tr>
                            <td><?php echo e($k+$stores->firstItem()); ?></td>
                            <td>
                                <a href="<?php echo e(route('admin.store.view', [$store->id, 'module_id'=>$store->module_id])); ?>"><?php echo e($store->name); ?></a>
                            </td>
                            <td class="text-center">
                                <?php echo e($store->orders->count()); ?>

                            </td>
                            <td class="text-center">
                                <?php echo e($delivered); ?>

                            </td>
                            <td class="text-center white-space-nowrap">
                                <?php echo e(\App\CentralLogics\Helpers::number_format_short($store->orders->where('order_status','delivered')->sum('order_amount'))); ?>

                            </td>
                            <td class="text-center white-space-nowrap">
                                <?php echo e(($store->orders->count() > 0 && $delivered > 0)? number_format((100*$delivered)/$store->orders->count(), config('round_up_to_digit')): 0); ?>%
                            </td>
                            <td class="text-center">
                                <?php echo e(($store->orders->count() > 0 && $delivered > 0)? number_format((100*($store->orders->count()-($delivered+$canceled)))/$store->orders->count(), config('round_up_to_digit')): 0); ?>%
                            </td>
                            <td class="text-center">
                                <?php echo e(($store->orders->count() > 0 && $canceled > 0)? number_format((100*$canceled)/$store->orders->count(), config('round_up_to_digit')): 0); ?>%
                            </td>
                            <td class="text-center">
                                <?php echo e($refunded); ?> <small>(<?php echo e($refund_requested); ?> pending)</small>
                            </td>
                            <td>
                                <div class="btn--container justify-content-center">
                                    <a href="<?php echo e(route('admin.store.view', [$store->id, 'module_id'=>$store->module_id])); ?>" class="action-btn btn--primary btn-outline-primary">
                                        <i class="tio-invisible"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- End Body -->
        <?php if(count($stores) !== 0): ?>
        <hr>
        <div class="page-area">
            <?php echo $stores->withQueryString()->links(); ?>

        </div>
        <?php endif; ?>
        <?php if(count($stores) === 0): ?>
        <div class="empty--data">
            <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
            <h5>
                <?php echo e(translate('no_data_found')); ?>

            </h5>
        </div>
        <?php endif; ?>
    </div>


</div>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('script'); ?>
<?php $__env->stopPush(); ?>


<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chart.js.extensions/chartjs-extensions.js"></script>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js"></script>


    <!-- Apex Charts -->
    <script src="<?php echo e(asset('/public/assets/admin/js/apex-charts/apexcharts.js')); ?>"></script>
    <!-- Apex Charts -->

    <!-- Dognut Pie Chart -->
    <script>
        "use strict";
        let options = {
            series: [<?php echo e(count($order_payment_methods)>0?isset($order_payment_methods[0])?$order_payment_methods[0]->order_count:0:0); ?>, <?php echo e(count($order_payment_methods)>0?isset($order_payment_methods[1])?$order_payment_methods[1]->order_count:0:0); ?>, <?php echo e(count($order_payment_methods)>0?isset($order_payment_methods[2])?$order_payment_methods[2]->order_count:0:0); ?>],
            chart: {
                width: 320,
                type: 'donut',
            },
            labels: ['<?php echo e(translate('Cash Payments')); ?> (<?php echo e(count($order_payment_methods)>0?isset($order_payment_methods[0])?$order_payment_methods[0]->total_order_amount:0:0); ?>)',
                '<?php echo e(translate('Digital Payments')); ?> (<?php echo e(count($order_payment_methods)>0?isset($order_payment_methods[1])?$order_payment_methods[1]->total_order_amount:0:0); ?>)',
                '<?php echo e(translate('Wallet')); ?> (<?php echo e(count($order_payment_methods)>0?isset($order_payment_methods[2])?$order_payment_methods[2]->total_order_amount:0:0); ?>)'
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

    $('.js-chart').each(function () {
        $.HSCore.components.HSChartJS.init($(this));
    });

    let updatingChart = $.HSCore.components.HSChartJS.init($('#updatingData'));

    $('#search-form').on('submit', function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            // let new_url= location.href+"&search="+formData.get('search');
            // window.history.pushState('', 'New Page Title', new_url);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '<?php echo e(route('admin.transactions.report.store-summary-report-search',request()->getQueryString())); ?>',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    // $('#countItems').html(data.count);
                    $('.page-area').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
</script>


<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/report/store-summary-report.blade.php ENDPATH**/ ?>