<?php $__env->startSection('title',translate('messages.dashboard')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">


         <?php if(\App\CentralLogics\Helpers::employee_module_permission_check('dashboard')): ?>
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm">
                    <h1 class="page-header-title">
                    <span class="page-header-icon">
                        <img src="<?php echo e(asset('public/assets/admin/img/category.png')); ?>" class="w--20" alt="">
                    </span>
                        <span><?php echo e(translate('messages.dashboard')); ?></span>
                    </h1>
                </div>
                <div class="col-sm ">
                    <?php if(isset($out_of_stock_count) &&   $out_of_stock_count  > 1 ): ?>
                            <div class="alert __alert-4 m-0 py-1 px-2  max-w-450px hide-warning d-none" role="alert">
                                <div class="alert-inner">
                                    <img class="rounded mr-1"  width="25" src="<?php echo e(asset('/public/assets/admin/img/invalid-icon.png')); ?>" alt="">
                                    <div class="cont">
                                        <h4 class="mb-2"><?php echo e(translate('Warning!')); ?> </h4><?php echo e(( $out_of_stock_count -1).'+ '.  translate('more_products_are_low_on_Stock.')); ?>

                                        <br>
                                        <a data-id="stock_out_reminder_close_btn"  class="text-primary text-underline reming_me_later"><?php echo e(translate('Remind_Me_Later')); ?></a>  &nbsp; &nbsp; <a href="<?php echo e(route('vendor.item.stock-limit-list')); ?>" class="text-primary text-underline"><?php echo e(translate('Click_To_View')); ?></a>
                                    </div>
                                </div>
                                <button class="position-absolute right-0 top-0 py-2 px-2 bg-transparent border-0 outline-none shadow-none reming_me_later"  type="button">
                                    <i class="tio-clear fz--18"></i>
                                </button>
                            </div>

                            <?php elseif(isset($out_of_stock_count)  &&  $out_of_stock_count  == 1  && isset($item)): ?>
                            <div class="alert __alert-4 m-0 py-1 px-2  max-w-450px hide-warning d-none" role="alert">
                                <div class="alert-inner">
                                    <img class="aspect-1-1 mr-1 object--contain rounded" width="100" src="<?php echo e($item?->image_full_url ?? asset('/public/assets/admin/img/100x100/food-default-image.png')); ?>" alt="">
                                    <div class="cont">
                                        <h4 class="mb-2"><?php echo e($item?->name); ?> </h4><?php echo e(translate('This product is low stock.')); ?>

                                        <br>
                                        <a
                                        data-id="stock_out_reminder_close_btn"  class="text-primary text-underline reming_me_later"><?php echo e(translate('Remind_Me_Later')); ?></a>  &nbsp; &nbsp; <a href="<?php echo e(route('vendor.item.stock-limit-list')); ?>" class="text-primary text-underline"><?php echo e(translate('Click_To_View')); ?></a>
                                    </div>
                                </div>
                                <button class="position-absolute right-0 top-0 py-2 px-2 bg-transparent border-0 outline-none shadow-none reming_me_later"  type="button">
                                    <i class="tio-clear fz--18"></i>
                                </button>
                            </div>

                        <?php endif; ?>




                    <div class="promo-card-2">
                        <img src="<?php echo e(asset('public/assets/admin/img/promo-arrow.png')); ?>" class="shapes" alt="">
                        <div class="left">
                            <img src="<?php echo e(asset('public/assets/admin/img/promo.png')); ?>" width="40" class="mw-100" alt="">
                            <div class="inner">
                                <div class="d-flex flex-wrap flex-md-nowrap align-items-center justify-content-between gap-2">
                                    <div>
                                        <h4 class="m-0 text-white"><?php echo e(translate('Want_to_get_highlighted?')); ?></h4>
                                        <p class="m-0 text-white">
                                            <?php echo e(translate('Create_ads_to_get_highlighted_on_the_app_and_web_browser')); ?>

                                        </p>
                                    </div>
                                    <a href="<?php echo e(route('vendor.advertisement.create')); ?>" class="btn btn-white text-nowrap font-semibold text-dark"><?php echo e(translate('Create_Ads')); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <div class="card mb-3">
            <div class="card-body">
                <div class="row gx-2 gx-lg-3 mb-2">
                    <div class="col-md-9">
                        <h4><i class="tio-chart-bar-4 fz-30px"></i><?php echo e(translate('messages.dashboard_order_statistics')); ?></h4>
                    </div>
                    <div class="col-md-3">
                        <select class="custom-select order_stats_update" name="statistics_type">
                            <option
                                value="overall" <?php echo e($params['statistics_type'] == 'overall'?'selected':''); ?>>
                                <?php echo e(translate('messages.Overall Statistics')); ?>

                            </option>
                            <option
                                value="today" <?php echo e($params['statistics_type'] == 'today'?'selected':''); ?>>
                                <?php echo e(translate("messages.Today's Statistics")); ?>

                            </option>
                            <option
                                value="this_month" <?php echo e($params['statistics_type'] == 'this_month'?'selected':''); ?>>
                                <?php echo e(translate("messages.This Month's Statistics")); ?>

                            </option>
                        </select>
                    </div>
                </div>
                <div class="py-2"></div>
                <div class="row g-2" id="order_stats">
                    <?php echo $__env->make('vendor-views.partials._dashboard-order-stats',['data'=>$data], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>
        </div>

        <div class="row gx-2 gx-lg-3">
            <div class="col-lg-12 mb-3 mb-lg-12">
                <!-- Card -->
                <div class="card h-100">
                    <!-- Body -->
                    <div class="card-body">
                        <div class="row mb-2 align-items-center">
                            <div class="col-sm mb-2 mb-sm-0">
                                <div class="d-flex flex-wrap justify-content-center align-items-center">
                                    <?php ($amount=array_sum($earning)); ?>
                                    <span class="h5 m-0 mr-3 fz--11 d-flex align-items-center mb-2 mb-md-0">
                                        <span class="legend-indicator chart-bg-2"></span>
                                        <?php echo e(translate('messages.total_earning')); ?> : <span><?php echo e(\App\CentralLogics\Helpers::format_currency(array_sum($earning))); ?></span>
                                    </span>
                                    <span class="h5 m-0 fz--11 d-flex align-items-center mb-2 mb-md-0">
                                        <span class="legend-indicator chart-bg-3"></span>
                                        <?php echo e(translate('messages.commission_given')); ?> : <span><?php echo e(\App\CentralLogics\Helpers::format_currency(array_sum($commission))); ?></span>
                                    </span>
                                </div>

                            </div>

                            <div class="col-sm-auto align-self-sm-end">
                                <!-- Legend Indicators -->
                                <h5 class="text-center">
                                    <?php echo e(translate('messages.yearly_statistics')); ?>

                                    <i class="tio-chart-bar-4 fz--40px"></i>
                                </h5>
                                <!-- End Legend Indicators -->
                            </div>
                        </div>
                        <!-- End Row -->

                        <!-- Bar Chart -->
                        <div class="chartjs-custom">
                            <canvas id="updatingData" class="h-20rem"
                                    data-hs-chartjs-options='{
                            "type": "bar",
                            "data": {
                              "labels": ["Jan","Feb","Mar","April","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
                              "datasets": [{
                                "data": [<?php echo e($earning[1]); ?>,<?php echo e($earning[2]); ?>,<?php echo e($earning[3]); ?>,<?php echo e($earning[4]); ?>,<?php echo e($earning[5]); ?>,<?php echo e($earning[6]); ?>,<?php echo e($earning[7]); ?>,<?php echo e($earning[8]); ?>,<?php echo e($earning[9]); ?>,<?php echo e($earning[10]); ?>,<?php echo e($earning[11]); ?>,<?php echo e($earning[12]); ?>],
                                "backgroundColor": "#00AA96",
                                "hoverBackgroundColor": "#00AA96",
                                "borderColor": "#00AA96"
                              },
                              {
                                "data": [<?php echo e($commission[1]); ?>,<?php echo e($commission[2]); ?>,<?php echo e($commission[3]); ?>,<?php echo e($commission[4]); ?>,<?php echo e($commission[5]); ?>,<?php echo e($commission[6]); ?>,<?php echo e($commission[7]); ?>,<?php echo e($commission[8]); ?>,<?php echo e($commission[9]); ?>,<?php echo e($commission[10]); ?>,<?php echo e($commission[11]); ?>,<?php echo e($commission[12]); ?>],
                                "backgroundColor": "#b9e0e0",
                                "borderColor": "#b9e0e0"
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
                                    "stepSize": <?php echo e($amount>1?20000:1); ?>,
                                    "fontSize": 12,
                                    "fontColor": "#97a4af",
                                    "fontFamily": "Open Sans, sans-serif",
                                    "padding": 10,
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
                                  "categoryPercentage": 0.5,
                                  "maxBarThickness": "10"
                                }]
                              },
                              "cornerRadius": 2,
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
                          }'></canvas>
                        </div>
                        <!-- End Bar Chart -->
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>

            <div class="col-lg-6 mt-3">
                <!-- Card -->
                <div class="card h-100" id="top-selling-items-view">
                    <?php echo $__env->make('vendor-views.partials._top-selling-items',['top_sell'=>$data['top_sell']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
                <!-- End Card -->
            </div>

            <div class="col-lg-6 mt-3">
                <!-- Card -->
                <div class="card h-100" id="top-rated-items-view">
                    <?php echo $__env->make('vendor-views.partials._most-rated-items',['most_rated_items'=>$data['most_rated_items']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
                <!-- End Card -->
            </div>


        </div>
        <!-- End Row -->
        <?php else: ?>
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><?php echo e(translate('messages.welcome')); ?>, <?php echo e(auth('vendor_employee')->user()->f_name); ?>.</h1>
                    <p class="page-header-text"><?php echo e(translate('messages.employee_welcome_message')); ?></p>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <?php endif; ?>
    </div>



<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chart.js.extensions/chartjs-extensions.js"></script>
    <script
        src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js"></script>

<?php $__env->stopPush(); ?>


<?php $__env->startPush('script_2'); ?>
    <script>
"use strict";
        $('#free-trial-modal').modal('show');

        Chart.plugins.unregister(ChartDataLabels);

        $('.js-chart').each(function () {
            $.HSCore.components.HSChartJS.init($(this));
        });

        let updatingChart = $.HSCore.components.HSChartJS.init($('#updatingData'));

        $('.order_stats_update').on('change',function (){
            let type = $(this).val();
            order_stats_update(type);
        })

        function order_stats_update(type) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '<?php echo e(route('vendor.dashboard.order-stats')); ?>',
                data: {
                    statistics_type: type
                },
                beforeSend: function () {
                    $('#loading').show()
                },
                success: function (data) {
                    insert_param('statistics_type',type);
                    $('#order_stats').html(data.view)
                },
                complete: function () {
                    $('#loading').hide()
                }
            });
        }

        function insert_param(key, value) {
            key = encodeURIComponent(key);
            value = encodeURIComponent(value);
            // kvp looks like ['key1=value1', 'key2=value2', ...]
            let kvp = document.location.search.substr(1).split('&');
            let i = 0;

            for (; i < kvp.length; i++) {
                if (kvp[i].startsWith(key + '=')) {
                    let pair = kvp[i].split('=');
                    pair[1] = value;
                    kvp[i] = pair.join('=');
                    break;
                }
            }
            if (i >= kvp.length) {
                kvp[kvp.length] = [key, value].join('=');
            }
            // can return this or...
            let params = kvp.join('&');
            // change url page with new params
            window.history.pushState('page2', 'Title', '<?php echo e(url()->current()); ?>?' + params);
        }

        $(document).on('click', '.reming_me_later', function () {
            $('.hide-warning').hide();
            document.cookie = "stock_out_reminder_close_btn=accepted; path=/";
        });
        if(document.cookie.indexOf("stock_out_reminder_close_btn=accepted") === -1){
            $('.hide-warning').removeClass('d-none')
        }
        if(document.cookie.indexOf("stock_out_reminder_close_btn=accepted") !== -1){
            $('.hide-warning').hide();
        }

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/vendor-views/dashboard.blade.php ENDPATH**/ ?>