<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate($data['status'])); ?> <?php echo e(translate('messages.order_list')); ?></h1></div>
    <div class="col-lg-12">
    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('filter_criteria')); ?> -</th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('order_status' )); ?> : <?php echo e(translate($data['status'])); ?>

                    <?php if($data['search']): ?>
                    <br>
                    <?php echo e(translate('search_bar_content' )); ?> : <?php echo e($data['search']); ?>

                    <?php endif; ?>
                    <?php if($data['zones']): ?>
                    <br>
                    <?php echo e(translate('zones' )); ?> : <?php echo e($data['zones']); ?>

                    <?php endif; ?>
                    <?php if($data['stores']): ?>
                    <br>
                    <?php echo e(translate('stores' )); ?> : <?php echo e($data['stores']); ?>

                    <?php endif; ?>
                    <?php if($data['type']): ?>
                    <br>
                    <?php echo e(translate('order_type' )); ?> : <?php echo e(translate($data['type'])); ?>

                    <?php endif; ?>
                    <?php if($data['from']): ?>
                    <br>
                    <?php echo e(translate('from' )); ?> : <?php echo e($data['from']?Carbon\Carbon::parse($data['from'])->format('d M Y'):''); ?>

                    <?php endif; ?>
                    <?php if($data['to']): ?>
                    <br>
                    <?php echo e(translate('to' )); ?> : <?php echo e($data['to']?Carbon\Carbon::parse($data['to'])->format('d M Y'):''); ?>

                    <?php endif; ?>

                </th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th><?php echo e(translate('messages.sl')); ?></th>
                <th><?php echo e(translate('messages.order_id')); ?></th>
                <?php if($data['status'] ==  'scheduled'): ?>
                <th><?php echo e(translate('messages.Scheduled_at')); ?></th>
                <?php else: ?>
                <th><?php echo e(translate('messages.Date')); ?></th>
                <?php endif; ?>
                <th><?php echo e(translate('messages.customer_name')); ?></th>
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
                <?php if($data['status'] ==  'scheduled'): ?>
                <td><?php echo e(\App\CentralLogics\Helpers::time_date_format($order->schedule_at)); ?></td>
                <?php else: ?>
                <td><?php echo e(\App\CentralLogics\Helpers::time_date_format($order->created_at)); ?></td>
                <?php endif; ?>
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
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($order['order_amount']-$order['dm_tips']-$order['total_tax_amount']-$order['delivery_charge']+$order['coupon_discount_amount'] + $order['store_discount_amount'])); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($order->details->sum('discount_on_item'))); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($order['coupon_discount_amount'])); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($order['coupon_discount_amount'] + $order['store_discount_amount']+ $order['ref_bonus_amount'] )); ?></td>
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
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/order-export.blade.php ENDPATH**/ ?>