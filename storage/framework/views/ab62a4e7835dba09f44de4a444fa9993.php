<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate('messages.order_report')); ?></h1></div>
    <div class="col-lg-12">



    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('filter_criteria')); ?> -</th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('module' )); ?> - <?php echo e($data['module']?translate($data['module']):translate('all')); ?>

                    <br>
                    <?php echo e(translate('zone' )); ?> - <?php echo e($data['zone']??translate('all')); ?>

                    <br>
                    <?php echo e(translate('store' )); ?> - <?php echo e($data['store']??translate('all')); ?>

                    <br>
                    <?php echo e(translate('customer' )); ?> - <?php echo e($data['customer']??translate('all')); ?>

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
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th><?php echo e(translate('messages.sl')); ?></th>
                <th><?php echo e(translate('messages.order_id')); ?></th>
                <th><?php echo e(translate('messages.customer_name')); ?></th>
                <th><?php echo e(translate('messages.store_name')); ?></th>
                <th><?php echo e(translate('messages.item_price')); ?></th>
                <th><?php echo e(translate('messages.item_discount')); ?></th>
                <th><?php echo e(translate('messages.coupon_discount')); ?></th>
                <th><?php echo e(translate('messages.referral_discount')); ?></th>
                <th><?php echo e(translate('messages.discounted_amount')); ?></th>
                <th><?php echo e(\App\CentralLogics\Helpers::get_business_data('additional_charge_name')??translate('messages.additional_charge')); ?></th>
                <th><?php echo e(translate('messages.extra_packaging_amount')); ?></th>
                <th><?php echo e(translate('messages.tax')); ?></th>
                <th><?php echo e(translate('messages.total_amount')); ?></th>
                <th><?php echo e(translate('messages.payment_status')); ?></th>
                <th><?php echo e(translate('messages.order_type')); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data['orders']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($key+1); ?></td>
                <td><?php echo e($order->id); ?></td>
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
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($order['order_amount'] - $order->additional_charge -$order['dm_tips']-$order['total_tax_amount']-$order['delivery_charge']+$order['coupon_discount_amount'] + $order['store_discount_amount'] + $order['ref_bonus_amount'] - $order['extra_packaging_amount'] +$order['flash_admin_discount_amount'] +$order['flash_store_discount_amount'] )); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($order->details()->sum(DB::raw('discount_on_item * quantity')) + $order['flash_admin_discount_amount'] +$order['flash_store_discount_amount'] )); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($order['coupon_discount_amount'])); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($order['ref_bonus_amount'])); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($order['coupon_discount_amount'] + $order['store_discount_amount'] + $order['ref_bonus_amount'] )); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($order['additional_charge'])); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($order['extra_packaging_amount'])); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($order['total_tax_amount'])); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($order['order_amount'])); ?></td>
                <td><?php echo e(translate($order->payment_status)); ?></td>
                <td><?php echo e(translate($order->order_type)); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/order-report.blade.php ENDPATH**/ ?>