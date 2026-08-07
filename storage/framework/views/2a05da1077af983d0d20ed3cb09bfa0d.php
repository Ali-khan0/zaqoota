<?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<tr class="status-<?php echo e($order['order_status']); ?> class-all">
    <td class="">
        <?php echo e($key+1); ?>

    </td>
    <td class="table-column-pl-0">
        <a href="<?php echo e(route('admin.transactions.order.details',['id' => $order['id'],'module_id'=>$order['module_id']])); ?>"><?php echo e($order['id']); ?></a>
    </td>
    <td>
        <div>
            <div>
                <?php echo e(date('d M Y',strtotime($order['created_at']))); ?>

            </div>
            <div class="d-block text-uppercase">
                <?php echo e(date(config('timeformat'),strtotime($order['created_at']))); ?>

            </div>
        </div>
    </td>
    <td>
        <?php if($order->is_guest): ?>
        <?php ($customer_details = json_decode($order['delivery_address'],true)); ?>
        <strong><?php echo e($customer_details['contact_person_name']); ?></strong>
        <div><?php echo e($customer_details['contact_person_number']); ?></div>
        
        <?php elseif($order->customer): ?>
        <a class="text-body text-capitalize" href="<?php echo e(route('admin.transactions.customer.view',[$order['user_id']])); ?>">
            <strong><?php echo e($order->customer['f_name'].' '.$order->customer['l_name']); ?></strong>
            <div><?php echo e($order->customer['phone']); ?></div>
        </a>
        <?php else: ?>
            <label class="badge badge-danger"><?php echo e(translate('messages.invalid_customer_data')); ?></label>
        <?php endif; ?>
    </td>
    <td>
        <div class="text-right mw--85px">
            <div>
                <?php echo e(\App\CentralLogics\Helpers::format_currency($order['order_amount'])); ?>

            </div>
            <?php if($order->payment_status=='paid'): ?>
            <strong class="text-success">
                <?php echo e(translate('messages.paid')); ?>

            </strong>
            <?php else: ?>
            <strong class="text-danger">
                <?php echo e(translate('messages.unpaid')); ?>

            </strong>
            <?php endif; ?>
        </div>
    </td>
    <td class="text-center mw--85px">
        <?php echo e(\App\CentralLogics\Helpers::format_currency($order['coupon_discount_amount']+$order['store_discount_amount'])); ?>

    </td>
    <td class="text-center mw--85px">
        <?php echo e(\App\CentralLogics\Helpers::format_currency($order['total_tax_amount'])); ?>

    </td>
    <td class="text-center mw--85px">
        <?php echo e(\App\CentralLogics\Helpers::format_currency($order['original_delivery_charge'])); ?>

    </td>

    <td>
        <div class="btn--container justify-content-center">
            <a class="ml-2 btn btn-sm btn--warning btn-outline-warning action-btn" href="<?php echo e(route('admin.transactions.order.details',['id' => $order['id'],'module_id'=>$order['module_id']])); ?>">
                <i class="tio-invisible"></i>
            </a>
            <a class="ml-2 btn btn-sm btn--primary btn-outline-primary action-btn" href="<?php echo e(route('admin.transactions.order.generate-invoice',['id'=>$order['id']])); ?>">
                <i class="tio-print"></i>
            </a>
        </div>
    </td>
</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/report/partials/_store_order_table.blade.php ENDPATH**/ ?>