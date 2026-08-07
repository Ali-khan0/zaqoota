<?php
    $tripOrOrder = $data['is_provider'] ? 'trip' : 'order';
    $storeOrProvider = $data['is_provider'] ? 'provider' : 'store';
?>
<div class="row">
    <div class="col-lg-12 text-center "><h1 > <?php echo e(translate($data['is_provider'] ? 'Provider_Trip_Transactions' : 'Store_Order_Transactions')); ?>

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
            <th><?php echo e(translate($tripOrOrder.'_ID')); ?></th>
            <th><?php echo e(translate($tripOrOrder.'_Time')); ?></th>
            <th><?php echo e(translate('Total_'.$tripOrOrder.'_amount')); ?></th>
            <th><?php echo e(translate($storeOrProvider.'_Earnings')); ?></th>
            <th><?php echo e(translate('Admin_Earnings')); ?></th>
            <?php if($data['is_provider']): ?>
                <th><?php echo e(translate('Additional_charge')); ?></th>
            <?php else: ?>
                <th><?php echo e(translate('Delivery_Fee')); ?></th>
            <?php endif; ?>
            <th><?php echo e(translate('Vat/Tax')); ?></th>

        </thead>
        <tbody>
        <?php $__currentLoopData = $data['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
        <td><?php echo e($loop->index+1); ?></td>
        <td><?php echo e($data['is_provider'] ? $tr->trip_id : $tr->order_id); ?></td>
        <td><?php echo e($tr->created_at->format('Y-m-d '.config('timeformat')) ??  translate('N/A')); ?></td>

        <td>
            <?php echo e(\App\CentralLogics\Helpers::format_currency($data['is_provider'] ? $tr->trip_amount : $tr->order_amount)); ?>

        </td>
        <td>
            <?php echo e(\App\CentralLogics\Helpers::format_currency($tr->store_amount - $tr->tax)); ?>

        </td>
        <td>
            <?php echo e(\App\CentralLogics\Helpers::format_currency($data['is_provider'] ? $tr->admin_commission : $tr->net_admin_commission)); ?>

        </td>
        <td>
            <?php echo e(\App\CentralLogics\Helpers::format_currency($data['is_provider'] ? $tr->additional_charge : $tr->delivery_charge)); ?>

        </td>
        <td>
            <?php echo e(\App\CentralLogics\Helpers::format_currency($tr->tax)); ?>

        </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/store-order-transaction.blade.php ENDPATH**/ ?>