<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate('messages.customer_order_list')); ?></h1></div>
    <div class="col-lg-12">



    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('customer_information')); ?> -</th>
                <th></th>
                <th></th>
                <th> 
                    <?php echo e(translate('customer_id' )); ?> : <?php echo e(translate($data['customer_id'])); ?>

                    <br>
                    <?php echo e(translate('name' )); ?> : <?php echo e($data['customer_name']); ?>

                    <br>
                    <?php echo e(translate('phone' )); ?> : <?php echo e($data['customer_phone']); ?>

                    <br>
                    <?php echo e(translate('email' )); ?> : <?php echo e($data['customer_email']); ?>

                    <br>
                    <?php echo e(translate('total_orders' )); ?> : <?php echo e($data['orders']->count()); ?>


                </th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th><?php echo e(translate('messages.sl')); ?></th>
                <th><?php echo e(translate('messages.order_id')); ?></th>
                <th><?php echo e(translate('messages.store_name')); ?></th>
                <th><?php echo e(translate('messages.item_price')); ?></th>
                <th><?php echo e(translate('messages.item_discount')); ?></th>
                <th><?php echo e(translate('messages.coupon_discount')); ?></th>
                <th><?php echo e(translate('messages.discounted_amount')); ?></th>
                <th><?php echo e(translate('messages.tax')); ?></th>
                <th><?php echo e(translate('messages.total_amount')); ?></th>
                <th><?php echo e(translate('messages.payment_status')); ?></th>
                <th><?php echo e(translate('messages.order_status')); ?></th>
                <th><?php echo e(translate('messages.order_type')); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data['orders']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($key+1); ?></td>
                <td><?php echo e($order->id); ?></td>
                <td>
                    <?php if($order->store): ?>
                        <?php echo e($order->store->name); ?>

                    <?php else: ?>
                        <?php echo e(translate('messages.not_found')); ?>

                    <?php endif; ?>
                </td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($order['order_amount']-$order['dm_tips']-$order['total_tax_amount']-$order['delivery_charge']+$order['coupon_discount_amount'] + $order['store_discount_amount'])); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($order->details->sum('discount_on_item'))); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($order['coupon_discount_amount'])); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($order['coupon_discount_amount'] + $order['store_discount_amount'])); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($order['total_tax_amount'])); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($order['order_amount'])); ?></td>
                <td><?php echo e(translate($order->payment_status)); ?></td>
                <td><?php echo e(translate($order->order_status)); ?></td>
                <td><?php echo e(translate($order->order_type)); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/customer-order.blade.php ENDPATH**/ ?>