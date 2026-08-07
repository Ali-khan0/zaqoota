
<div class="row">
    <div class="col-lg-12 text-center "><h1 > <?php echo e(translate('subscription_package_list')); ?>

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
            <th><?php echo e(translate('Package_Name')); ?></th>
            <th><?php echo e(translate('Price')); ?></th>
            <th><?php echo e(translate('Duration')); ?></th>
            <th><?php echo e(translate('Current_Subscriber')); ?></th>
            <th><?php echo e(translate('Status')); ?></th>

        </thead>
        <tbody>
        <?php $__currentLoopData = $data['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
        <td><?php echo e($loop->index+1); ?></td>
        <td><?php echo e($package->package_name); ?></td>
        <td>
            <?php echo e(\App\CentralLogics\Helpers::format_currency($package->price)); ?>

        </td>
        <td><?php echo e($package->validity); ?> <?php echo e(translate('days')); ?></td>
        <td><?php echo e($package->current_subscribers_count ?? 0); ?></td>
        <td><?php echo e($package->status == 1 ? translate('messages.Activate') : translate('messages.Inactivate')); ?></td>

            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/subscrition_package.blade.php ENDPATH**/ ?>