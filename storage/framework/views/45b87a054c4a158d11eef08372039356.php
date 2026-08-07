<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate('customer_list')); ?></h1></div>
    <div class="col-lg-12">



    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('Customer_Analytics')); ?></th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('Total_Customer')); ?>: <?php echo e($data['customers']->count()); ?>

                    <br>
                    <?php echo e(translate('Active_Customer')); ?>: <?php echo e($data['customers']->where('status',1)->count()); ?>

                    <br>
                    <?php echo e(translate('Inactive_Customer')); ?>: <?php echo e($data['customers']->where('status',0)->count()); ?>


                </th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
                </tr>
            <tr>
                <th><?php echo e(translate('Search_Criteria')); ?></th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('Search_Bar_Content')); ?>: <?php echo e($data['search'] ??translate('N/A')); ?>

                </th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th><?php echo e(translate('Filter_Criteria')); ?></th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('Customer_Status')); ?>: <?php echo e($data['filter'] ?translate($data['filter']):translate('all')); ?>

                    <br>
                    <?php echo e(translate('Sort_by')); ?>: <?php echo e($data['order_wise'] ??translate('N/A')); ?>

                    <br>
                    <?php echo e(translate('Show_Limit')); ?>: <?php echo e($data['show_limit'] ??translate('N/A')); ?>

                    <br>
                    <?php echo e(translate('Order_Date_Range')); ?>: <?php echo e($data['order_date'] ??translate('N/A')); ?>

                    <br>
                    <?php echo e(translate('Join_Date_Range')); ?>: <?php echo e($data['join_date'] ??translate('N/A')); ?>

                </th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        <tr>
            <th><?php echo e(translate('sl')); ?></th>
            <th><?php echo e(translate('first_name')); ?></th>
            <th><?php echo e(translate('last_name')); ?></th>
            <th><?php echo e(translate('phone')); ?></th>
            <th><?php echo e(translate('email')); ?></th>
            <th><?php echo e(translate('saved_address')); ?></th>
            <th><?php echo e(translate('total_orders')); ?></th>
            <th><?php echo e(translate('total_wallet_amount')); ?> </th>
            <th><?php echo e(translate('total_loyality_points')); ?> </th>
            <th><?php echo e(translate('status')); ?> </th>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data['customers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
        <td><?php echo e($key+1); ?></td>
        <td><?php echo e($customer['f_name']); ?></td>
        <td><?php echo e($customer['l_name']); ?></td>
        <td><?php echo e($customer['phone']); ?></td>
        <td><?php echo e($customer['email']); ?></td>
        <td>
            <?php $__currentLoopData = $customer->addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <br>
            <?php echo e($address['address']); ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </td>
        <td><?php echo e($customer['order_count']); ?></td>
        <td><?php echo e($customer['wallet_balance']); ?></td>
        <td><?php echo e($customer['loyalty_point']); ?></td>
        <td><?php echo e($customer->status ? translate('messages.Active') : translate('messages.Inactive')); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/customer-list.blade.php ENDPATH**/ ?>