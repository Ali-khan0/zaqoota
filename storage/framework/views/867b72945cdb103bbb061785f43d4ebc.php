<?php ($params=session('dash_params')); ?>
<?php if($params['zone_id']!='all'): ?>
    <?php ($zone_name=\App\Models\Zone::where('id',$params['zone_id'])->first()->name); ?>
<?php else: ?>
    <?php ($zone_name = translate('messages.all')); ?>
<?php endif; ?>

<div class="chartjs-custom mx-auto">
    <canvas id="business-overview" class="mt-2"></canvas>
</div>

<script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chart.js/dist/Chart.min.js"></script>

<script>
    "use strict";
    let ctx = document.getElementById('business-overview');
    let myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [
                'Food',
                'Review',
                'Wishlist'
            ],
            datasets: [{
                label: 'Business',
                data: ['<?php echo e($data['food']); ?>', '<?php echo e($data['reviews']); ?>', '<?php echo e($data['wishlist']); ?>'],
                backgroundColor: [
                    '#2C2E43',
                    '#595260',
                    '#B2B1B9'
                ],
                hoverOffset: 4
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/partials/_business-overview-chart.blade.php ENDPATH**/ ?>