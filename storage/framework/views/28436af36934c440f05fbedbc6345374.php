
<div class="row">
    <div class="col-lg-12 text-center "><h1 > <?php echo e(translate('Vehicle_List')); ?>

    </h1></div>
    <div class="col-lg-12">

    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('Filter_Criteria')); ?></th>
                <th></th>
                <th>
                    <?php echo e(translate('Search_Bar_Content')); ?>: <?php echo e($data['search'] ?? translate('N/A')); ?>


                </th>
                <th> </th>
                </tr>


        <tr>
            <th><?php echo e(translate('sl')); ?></th>
            <th><?php echo e(translate('Vehicle_Name')); ?></th>
            <th><?php echo e(translate('Vehicle_ID')); ?></th>
            <th><?php echo e(translate('Vehicle_Category')); ?></th>
            <th><?php echo e(translate('Vehicle_Brand')); ?></th>
            <th><?php echo e(translate('Trip Fair')); ?></th>
            <th><?php echo e(translate('New Tag')); ?></th>
            <th><?php echo e(translate('Status')); ?></th>

        </thead>
        <tbody>
        <?php $__currentLoopData = $data['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($loop->index+1); ?></td>
                <td><?php echo e($vehicle->name); ?></td>
                <td><?php echo e($vehicle->id); ?></td>
                <td><?php echo e($vehicle?->category?->name); ?></td>
                <td><?php echo e($vehicle?->brand?->name); ?></td>
                <td>
                    <?php if($vehicle->trip_hourly): ?>
                        <div>
                            <span class="opacity-lg"><?php echo e(translate('Hourly')); ?>: </span>
                            <span class="font-semibold"><?php echo e(\App\CentralLogics\Helpers::format_currency($vehicle['hourly_price'])); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if($vehicle->trip_distance): ?>
                        <div>
                            <span class="opacity-lg"><?php echo e(translate('Distance Wise')); ?>: </span>
                            <span class="font-semibold"><?php echo e(\App\CentralLogics\Helpers::format_currency($vehicle['distance_price'])); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if($vehicle->trip_day_wise): ?>
                        <div>
                            <span class="opacity-lg"><?php echo e(translate('Per Day')); ?>: </span>
                            <span class="font-semibold"><?php echo e(\App\CentralLogics\Helpers::format_currency($vehicle['day_wise_price'])); ?></span>
                        </div>
                    <?php endif; ?>
                </td>
                <td><?php echo e($vehicle->new_tag == 1 ? translate('messages.Yes') : translate('messages.No')); ?></td>
                <td><?php echo e($vehicle->status == 1 ? translate('messages.Active') : translate('messages.Inactive')); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/file-exports/vehicle-export.blade.php ENDPATH**/ ?>