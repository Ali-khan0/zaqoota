<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate('delivery_man_list')); ?></h1></div>
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
                    <?php echo e(translate('Search_Bar_Content')); ?>- <?php echo e($data['search'] ??translate('N/A')); ?>


                </th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
                </tr>
            <tr>
                <th><?php echo e(translate('Analytics')); ?></th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('total_delivery_man')); ?>- <?php echo e($data['delivery_men']->count()); ?>

                    <br>
                    <?php echo e(translate('active_delivery_man')); ?>- <?php echo e($data['delivery_men']->where('status',1)->count()); ?>

                    <br>
                    <?php echo e(translate('inactive_delivery_man')); ?>- <?php echo e($data['delivery_men']->where('status',0)->count()); ?>

                </th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        <tr>
            <th><?php echo e(translate('sl')); ?></th>
            <th><?php echo e(translate('image')); ?></th>
            <th><?php echo e(translate('first_name')); ?></th>
            <th><?php echo e(translate('last_name')); ?></th>
            <th><?php echo e(translate('phone')); ?></th>
            <th><?php echo e(translate('email')); ?></th>
            <th><?php echo e(translate('delivery_man_type')); ?></th>
            <th><?php echo e(translate('total_completed')); ?></th>
            <th><?php echo e(translate('total_running_orders')); ?></th>
            <th><?php echo e(translate('status')); ?></th>
            <th><?php echo e(translate('zone')); ?></th>
            <th><?php echo e(translate('vehicle_type')); ?></th>
            <th><?php echo e(translate('identity_type')); ?></th>
            <th><?php echo e(translate('identity_number')); ?></th>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data['delivery_men']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($key+1); ?></td>
            <td></td>
            <td><?php echo e($item['f_name']); ?></td>
            <td><?php echo e($item['l_name']); ?></td>
            <td><?php echo e($item['phone']); ?></td>
            <td><?php echo e($item['email']); ?></td>
            <td><?php echo e($item->earning?translate('messages.freelancer'):translate('messages.salary_based')); ?></td>
            <td><?php echo e($item['order_count']); ?></td>
            <td><?php echo e($item['current_orders']); ?></td>
            <td><?php echo e($item->active?translate('messages.online'):translate('messages.offline')); ?></td>
            <td><?php echo e($item->zone?$item->zone->name:''); ?></td>
            <td><?php echo e($item->vehicle?$item->vehicle->type:''); ?></td>
            <td><?php echo e(translate($item->identity_type)); ?></td>
            <td><?php echo e($item->identity_number); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/deliveryman-list.blade.php ENDPATH**/ ?>