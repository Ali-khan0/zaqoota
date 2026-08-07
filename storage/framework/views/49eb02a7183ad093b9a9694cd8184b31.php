<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate('delivery_man_earning_list')); ?></h1></div>
    <div class="col-lg-12">



    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('delivery_man_info')); ?></th>
                <th></th>
                <th>
                    <?php echo e(translate('name')); ?>- <?php echo e($data['dm']->f_name.' '.$data['dm']->l_name); ?>

                    <br>
                    <?php echo e(translate('phone')); ?>- <?php echo e($data['dm']->phone); ?>

                    <br>
                    <?php echo e(translate('email')); ?>- <?php echo e($data['dm']->email); ?>

                    <br>
                    <?php echo e(translate('total_order')); ?>- <?php echo e($data['dm']->order_count); ?>

                    <br>
                    <?php echo e(translate('total_earning')); ?>- <?php echo e($data['dm']->wallet->total_earning); ?>


                </th>
                <th></th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th><?php echo e(translate('Filter_Criteria')); ?></th>
                <th></th>
                <th>
                    <?php echo e(translate('date')); ?>- <?php echo e($data['date'] ??translate('N/A')); ?>


                </th>
                <th></th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        <tr>
            <th><?php echo e(translate('sl')); ?></th>
            <th><?php echo e(translate('messages.order_id')); ?></th>
            <th><?php echo e(translate('messages.distance')); ?></th>
            <th><?php echo e(translate('messages.delivery_fee_earned')); ?></th>
            <th><?php echo e(translate('messages.tips')); ?></th>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data['earnings']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $earning): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($key+1); ?></td>
                <td>
                    <?php echo e($earning->order_id); ?>

                </td>
                <td>
                    <?php echo e($earning->order->distance); ?> km
                </td>
                <td><?php echo e($earning->original_delivery_charge); ?></td>
                <td><?php echo e($earning->dm_tips); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/deliveryman-earning.blade.php ENDPATH**/ ?>