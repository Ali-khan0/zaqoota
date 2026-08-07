<?php ($params = session('dash_params')); ?>

<div class="position-relative pie-chart">
    <div id="dognut-pie"></div>
    <!-- Total Orders -->
    <div class="total--orders">
        <h3 class="text-uppercase mb-xxl-2"><?php echo e($data['customer'] + $data['delivery_man']); ?></h3>
        <span class="text-capitalize"><?php echo e(translate('messages.total_users')); ?></span>
    </div>
    <!-- Total Orders -->
</div>
<div class="d-flex flex-wrap justify-content-center mt-4">
    <div class="chart--label">
        <span class="indicator chart-bg-1"></span>
        <span class="info">
            <?php echo e(translate('messages.customer')); ?> <?php echo e($data['customer']); ?>

        </span>
    </div>
    <div class="chart--label">
        <span class="indicator chart-bg-3"></span>
        <span class="info">
            <?php echo e(translate('messages.delivery_man')); ?> <?php echo e($data['delivery_man']); ?>

        </span>
    </div>
</div>


<script>
    "use strict";
    options = {
        series: [<?php echo e($data['customer']); ?>, <?php echo e($data['delivery_man']); ?>],
        chart: {
            width: 320,
            type: 'donut',
        },
        labels: ['<?php echo e(translate('Customer')); ?>', '<?php echo e(translate('Delivery man')); ?>'],
        dataLabels: {
            enabled: false,
            style: {
                colors: ['#005555',  '#b9e0e0',]
            }
        },
        responsive: [{
            breakpoint: 1650,
            options: {
                chart: {
                    width: 250
                },
            }
        }],
        colors: ['#005555', '#111'],
        fill: {
            colors: ['#005555', '#b9e0e0']
        },
        legend: {
            show: false
        },
    };

    chart = new ApexCharts(document.querySelector("#dognut-pie"), options);
    chart.render();

<!-- Dognut Pie Chart -->

        // INITIALIZATION OF CHARTJS
        // =======================================================
        Chart.plugins.unregister(ChartDataLabels);

        $('.js-chart').each(function () {
            $.HSCore.components.HSChartJS.init($(this));
        });

        updatingChart = $.HSCore.components.HSChartJS.init($('#updatingData'));
    </script>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/partials/_user-overview-chart-parcel.blade.php ENDPATH**/ ?>