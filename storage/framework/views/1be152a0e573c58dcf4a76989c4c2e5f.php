
<div class="row">
    <div class="col-lg-12 text-center "><h1 > <?php echo e(translate('Driver_Trip_List')); ?>

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
                <th><?php echo e(translate('Customer')); ?></th>
                <th><?php echo e(translate('Provider')); ?></th>
                <th><?php echo e(translate('Trip Amount')); ?></th>
                <th><?php echo e(translate('Discount On Trip')); ?></th>
                <th><?php echo e(translate('Coupon Discount Amount')); ?></th>
                <th><?php echo e(translate('Trip Status')); ?></th>
                <th><?php echo e(translate('Payment Status')); ?></th>
                <th><?php echo e(translate('Tax Amount')); ?></th>

            </thead>
            <tbody>
            <?php $__currentLoopData = $data['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $driverTrip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($loop->index+1); ?></td>
                    <td><?php echo e($driverTrip?->trip?->customer?->fullName ?? translate('messages.Guest_user')); ?></td>
                    <td><?php echo e($driverTrip?->trip?->provider->name); ?></td>
                    <td><?php echo e($driverTrip?->trip?->trip_amount); ?></td>
                    <td><?php echo e($driverTrip?->trip?->discount_on_trip); ?></td>
                    <td><?php echo e($driverTrip?->trip?->coupon_discount_amount); ?></td>
                    <td><?php echo e(ucwords($driverTrip?->trip?->trip_status)); ?></td>
                    <td><?php echo e(ucwords($driverTrip?->trip?->payment_status)); ?></td>
                    <td><?php echo e($driverTrip?->trip?->tax_amount); ?></td>

                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/file-exports/driver-trip-export.blade.php ENDPATH**/ ?>