<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate('store_order_reports')); ?></h1></div>
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
                    <?php echo e(translate('store' )); ?> - <?php echo e($data['store']??translate('all')); ?>

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
                <th><?php echo e(translate('Analytics')); ?></th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('total_orders')); ?>- <?php echo e($data['total_orders']); ?>

                    <br>
                    <?php echo e(translate('total_order_amount')); ?>- <?php echo e($data['total_order_amount']); ?>

                    <br>
                    <?php echo e(translate('canceled_order')); ?>- <?php echo e($data['total_canceled_count']); ?>

                    <br>
                    <?php echo e(translate('completed_orders')); ?>- <?php echo e($data['total_delivered_count']); ?>

                    <br>
                    <?php echo e(translate('incomplete_orders')); ?>- <?php echo e($data['total_ongoing_count']); ?>

                </th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        <tr>
            <th><?php echo e(translate('sl')); ?></th>
            <th><?php echo e(translate('messages.order_id')); ?></th>
            <th><?php echo e(translate('messages.order_date')); ?></th>
            <th><?php echo e(translate('messages.customer_name')); ?></th>
            <th><?php echo e(translate('messages.store_name')); ?></th>
            <th><?php echo e(translate('messages.total_amount')); ?></th>
            <th><?php echo e(translate('messages.payment_status')); ?></th>
            <th><?php echo e(translate('messages.discounted_amount')); ?></th>
            <th><?php echo e(translate('messages.tax')); ?></th>
            <th><?php echo e(translate('messages.delivery_charge')); ?></th>
        </thead>
        <tbody>
            <?php $__currentLoopData = $data['orders']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($key+1); ?></td>
                <td><?php echo e($order->id); ?></td>
                <td><div>
                    <?php echo e(date('d M Y', strtotime($order['created_at']))); ?>

                </div>
                <br>
                <div>
                    <?php echo e(date(config('timeformat'), strtotime($order['created_at']))); ?>

                </div></td>
                <td>
                    <?php if($order->customer): ?>
                        <?php echo e($order->customer['f_name'] . ' ' . $order->customer['l_name']); ?>

                    <?php else: ?>
                        <?php echo e(translate('not_found')); ?>

                    <?php endif; ?>
                </td>
                <td>
                    <?php if($order->store): ?>
                        <?php echo e($order->store->name); ?>

                    <?php else: ?>
                        <?php echo e(translate('messages.not_found')); ?>

                    <?php endif; ?>
                </td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($order['order_amount'])); ?></td>
                <td><?php echo e(translate($order->payment_status)); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($order['coupon_discount_amount']  + $order['ref_bonus_amount'] +  $order['store_discount_amount'])); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($order['total_tax_amount'])); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($order['delivery_charge'])); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/store-orders-report.blade.php ENDPATH**/ ?>