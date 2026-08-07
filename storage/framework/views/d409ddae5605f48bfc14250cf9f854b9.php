
<div class="row">
    <div class="col-lg-12 text-center "><h1 > <?php echo e(translate('Store_Order_List')); ?>

    </h1></div>
    <div class="col-lg-12">

    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('Store_Details')); ?></th>
                <th></th>
                <th>
                    <?php echo e(translate('Store_Name')); ?>: <?php echo e($data['store'] ?? translate('N/A')); ?>

                    <br>
                    <?php echo e(translate('Zone')); ?>: <?php echo e($data['zone'] ?? translate('N/A')); ?>

                    <br>
                    <?php echo e(translate('Total_Order')); ?>: <?php echo e($data['data']->count() ?? translate('N/A')); ?>

                </th>
                <th> </th>
            </tr>


            <tr>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('Scheduled_Order')); ?>: <?php echo e($data['data']->where('scheduled', '1')->count() ?? translate('N/A')); ?>

                </th>
                <th>
                    <?php echo e(translate('Pending_Order')); ?>: <?php echo e($data['data']->where('order_status' ,'pending')->count() ?? translate('N/A')); ?>

                </th>
                <th>
                    <?php echo e(translate('Delivered_Order')); ?>: <?php echo e($data['data']->where('order_status' ,'delivered')->count() ?? translate('N/A')); ?>

                </th>
                <th>
                    <?php echo e(translate('Canceled_Order')); ?>: <?php echo e($data['data']->where('order_status' ,'canceled')->count() ?? translate('N/A')); ?>

                </th>
                <th>
                    <?php echo e(translate('Refunded_Order')); ?>: <?php echo e($data['data']->where('order_status' ,'refunded')->count() ?? translate('N/A')); ?>

                </th>
                <th> </th>
            </tr>


        <tr>
            <th><?php echo e(translate('sl')); ?></th>
            <th><?php echo e(translate('Order_ID')); ?></th>
            <th><?php echo e(translate('Order_Date')); ?></th>
            <th><?php echo e(translate('Customer_Name')); ?></th>
            <th><?php echo e(translate('Store_Name')); ?></th>
            <th><?php echo e(translate('Total_Items')); ?></th>
            <th><?php echo e(translate('Item_Price')); ?></th>
            <th><?php echo e(translate('Item_Discount')); ?></th>
            <th><?php echo e(translate('Coupon_Discount')); ?></th>
            <th><?php echo e(translate('Discounted_Amount')); ?></th>
            <th><?php echo e(translate('Vat/Tax')); ?></th>
            <th><?php echo e(translate('Total_Amount')); ?></th>
            <th><?php echo e(translate('Payment_Status')); ?></th>
            <th><?php echo e(translate('Order_Status')); ?></th>
            <th><?php echo e(translate('Order_Type')); ?></th>

        </thead>
        <tbody>
        <?php $__currentLoopData = $data['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($loop->index+1); ?></td>
                <td><?php echo e($order->id); ?></td>
                <td><?php echo e(\Carbon\Carbon::parse($order->created_at)->format('Y-m-d '.config('timeformat')) ??  translate('N/A')); ?></td>
                <td><?php echo e($order?->customer ?  $order?->customer?->f_name.' '.$order?->customer?->l_name  : translate('not_found')); ?></td>
                <td><?php echo e($order?->store?->name); ?></td>
                <td><?php echo e($order->details->count()); ?></td>
                <td> <?php echo e(\App\CentralLogics\Helpers::number_format_short($order['order_amount']-$order['dm_tips']-$order['total_tax_amount']-$order['delivery_charge']+$order['coupon_discount_amount'] + $order['store_discount_amount'])); ?>

                </td>
                <td> <?php echo e(\App\CentralLogics\Helpers::number_format_short($order->details->sum('discount_on_item'))); ?> </td>
                <td> <?php echo e(\App\CentralLogics\Helpers::number_format_short($order['coupon_discount_amount'])); ?></td>
                <td> <?php echo e(\App\CentralLogics\Helpers::number_format_short($order['coupon_discount_amount'] + $order['store_discount_amount'])); ?></td>
                <td> <?php echo e(\App\CentralLogics\Helpers::number_format_short($order['total_tax_amount'])); ?></td>
                <td> <?php echo e(\App\CentralLogics\Helpers::number_format_short($order['order_amount'])); ?></td>
                <td><?php echo e(translate($order->payment_status)); ?></td>
                <td> <?php echo e(translate($order->order_status)); ?></td>
                <td> <?php echo e(translate($order->order_type)); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/store-order-list.blade.php ENDPATH**/ ?>