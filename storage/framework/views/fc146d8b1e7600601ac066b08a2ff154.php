<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate('vehicle_report')); ?></h1></div>
    <div class="col-lg-12">



    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('Search_Criteria')); ?></th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('zone' )); ?> - <?php echo e($data['zone']??translate('all')); ?>

                    <br>
                    <?php echo e(translate('provider' )); ?> - <?php echo e($data['provider']??translate('all')); ?>

                    <?php if($data['from']): ?>
                    <br>
                    <?php echo e(translate('from' )); ?> - <?php echo e($data['from']?Carbon\Carbon::parse($data['from'])->format('d M Y'):''); ?>

                    <?php endif; ?>
                    <?php if($data['to']): ?>
                    <br>
                    <?php echo e(translate('to' )); ?> - <?php echo e($data['to']?Carbon\Carbon::parse($data['to'])->format('d M Y'):''); ?>

                    <?php endif; ?>
                    <br>
                    <?php echo e(translate('filter')); ?>- <?php echo e(translate($data['filter'])); ?>

                    <br>
                    <?php echo e(translate('Search_Bar_Content')); ?>- <?php echo e($data['search'] ??translate('N/A')); ?>


                </th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
                </tr>
        <tr>
            <th><?php echo e(translate('sl')); ?></th>
            <th><?php echo e(translate('messages.vehicle_image')); ?></th>
            <th><?php echo e(translate('messages.Vehicle Info')); ?></th>
            <th><?php echo e(translate('messages.provider')); ?></th>
            <th><?php echo e(translate('messages.hourly_rate')); ?></th>
            <th><?php echo e(translate('messages.distance_wise_rate')); ?></th>
            <th><?php echo e(translate('messages.day_wise_rate')); ?></th>
            <th><?php echo e(translate('messages.total_trip_count')); ?></th>
            <th><?php echo e(translate('messages.total_trip_vehicles')); ?></th>
            <th><?php echo e(translate('messages.total_trip_amount')); ?></th>
            <th><?php echo e(translate('messages.total_discount_given')); ?></th>
            <th><?php echo e(translate('messages.Average Trip Value')); ?></th>
            <th><?php echo e(translate('messages.total_reviews')); ?></th>
            <th><?php echo e(translate('messages.average_ratings')); ?></th>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data['vehicles']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($key+1); ?></td>
                <td></td>
                <td><?php echo e($vehicle['name']); ?></td>
                <td>
                    <?php if($vehicle->provider): ?>
                    <?php echo e($vehicle->provider->name); ?>

                    <?php else: ?>
                    <?php echo e(translate('messages.provider_deleted')); ?>

                    <?php endif; ?>
                </td>
                <td>
                    <?php echo e(\App\CentralLogics\Helpers::format_currency($vehicle->hourly_price)); ?>

                </td>
                <td>
                    <?php echo e(\App\CentralLogics\Helpers::format_currency($vehicle->distance_price)); ?>

                </td>
                <td>
                    <?php echo e(\App\CentralLogics\Helpers::format_currency($vehicle->day_wise_price)); ?>

                </td>
                <td>
                    <?php echo e($vehicle->trips_count ?? 0); ?>

                </td>
                <td>
                    <?php echo e($vehicle->trip_details_sum_quantity ?? 0); ?>

                </td>

                <td>
                    <?php echo e(\App\CentralLogics\Helpers::format_currency($vehicle->trips_sum_price)); ?>

                </td>
                <td>
                    <?php echo e(\App\CentralLogics\Helpers::format_currency($vehicle->total_discount)); ?>

                <td>
                    <?php echo e($vehicle->trips_count>0? \App\CentralLogics\Helpers::format_currency(($vehicle->trips_sum_price-$vehicle->total_discount)/($vehicle->trip_details_sum_quantity ?? 0) ) :0); ?>

                </td>
                <td><?php echo e($vehicle->total_reviews); ?></td>
                <td><?php echo e(round($vehicle->avg_rating,1)); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/file-exports/vehicle-report.blade.php ENDPATH**/ ?>