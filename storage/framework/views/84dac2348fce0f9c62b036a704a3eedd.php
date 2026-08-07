<div class="position-relative pie-chart">
    <div id="dognut-pie"></div>
    <!-- Total Orders -->
    <div class="total--orders">
        <h3 class="text-uppercase mb-xxl-2">
            <?php echo e($totalCount); ?></h3>
        <span class="text-capitalize"><?php echo e(translate('messages.total_trip')); ?></span>
    </div>
    <!-- Total Orders -->
</div>
<div class="d-flex flex-wrap justify-content-center mt-4">
    <div class="chart--label">
        <span class="indicator chart-bg-1"></span>
        <span class="info">
            <?php echo e(translate('messages.Hourly_Trip')); ?> <?php echo e($hourlyCount); ?>

        </span>
    </div>
    <div class="chart--label">
        <span class="indicator chart-bg-3"></span>
        <span class="info">
            <?php echo e(translate('messages.Distance_Wise_Trip')); ?> <?php echo e($distanceWiseCount); ?>

        </span>
    </div>
    <div class="chart--label">
        <span class="indicator chart-bg-4"></span>
        <span class="info">
            <?php echo e(translate('messages.Day_Wise_Trip')); ?> <?php echo e($daywiseCount); ?>

        </span>
    </div>
</div>


<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/partials/by-trip-type.blade.php ENDPATH**/ ?>