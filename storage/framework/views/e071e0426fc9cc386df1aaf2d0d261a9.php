
<div class="row">
    <div class="col-lg-12 text-center "><h1 > <?php echo e(translate('Zone_List')); ?>

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
            <th><?php echo e(translate('Zone_Name')); ?></th>
            <th><?php echo e(translate('Zone_ID')); ?></th>
            <th><?php echo e(translate('Total_Stores')); ?></th>
            <th><?php echo e(translate('Total_Deliverymen')); ?></th>
            <th><?php echo e(translate('Digital_Payment')); ?></th>
            <th><?php echo e(translate('Cash_On_Delivery')); ?></th>
            <th><?php echo e(translate('Status')); ?></th>

        </thead>
        <tbody>
        <?php $__currentLoopData = $data['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
        <td><?php echo e($loop->index+1); ?></td>
        <td><?php echo e($addon->name); ?></td>
        <td><?php echo e($addon->id); ?></td>
        <td>
            <?php echo e($addon->stores_count); ?>

        </td>
        <td>

            <?php echo e($addon->deliverymen_count); ?>

        </td>
        <td><?php echo e($addon?->digital_payment == 1 ? translate('Yes') : translate('No')); ?></td>
        <td><?php echo e($addon?->cash_on_delivery == 1 ? translate('Yes') : translate('No')); ?></td>
        <td><?php echo e($addon?->status == 1 ? translate('Active') : translate('Inactive')); ?></td>

            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/zone.blade.php ENDPATH**/ ?>