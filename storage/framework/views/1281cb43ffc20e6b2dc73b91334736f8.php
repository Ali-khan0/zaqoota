<?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr class="status-<?php echo e($order['order_status']); ?> class-all">
    <td class="">
        <?php echo e($key + 1); ?>

    </td>
    <td class="table-column-pl-0">
        <a
            href="<?php echo e(route('admin.order.details', ['id' => $order['id'],'module_id'=>$order['module_id']])); ?>"><?php echo e($order['id']); ?></a>
    </td>
    <td  class="text-capitalize">
        <?php if($order->store): ?>
            <?php echo e(Str::limit($order->store->name,25,'...')); ?>

        <?php else: ?>
            <label class="badge badge-danger"><?php echo e(translate('messages.invalid')); ?>

        <?php endif; ?>
    </td>
    <td>
        <?php if($order->is_guest): ?>
        <?php ($customer_details = json_decode($order['delivery_address'],true)); ?>
        <strong><?php echo e($customer_details['contact_person_name']); ?></strong>
        <div><?php echo e($customer_details['contact_person_number']); ?></div>

        <?php elseif($order->customer): ?>
        <a class="text-body text-capitalize"
            href="<?php echo e(route('admin.users.customer.view', [$order['user_id']])); ?>">
            <strong><?php echo e($order->customer['f_name'] . ' ' . $order->customer['l_name']); ?></strong>
        </a>
        <?php else: ?>
            <label class="badge badge-danger"><?php echo e(translate('messages.invalid')); ?>

                <?php echo e(translate('messages.customer')); ?>

                <?php echo e(translate('messages.data')); ?></label>
        <?php endif; ?>
    </td>
    <td>
        <div class="text-right mw--85px">
            <div>
                <?php echo e(\App\CentralLogics\Helpers::number_format_short($order['order_amount']-$order['dm_tips']-$order['total_tax_amount']-$order['delivery_charge']+$order['coupon_discount_amount'] + $order['store_discount_amount'])); ?>

            </div>
            <?php if($order->payment_status == 'paid'): ?>
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
        <?php echo e(\App\CentralLogics\Helpers::number_format_short($order->details->sum('discount_on_item'))); ?>

    </td>
    <td class="text-center mw--85px">
        <?php echo e(\App\CentralLogics\Helpers::number_format_short($order['coupon_discount_amount'])); ?>

    </td>
    <td class="text-center mw--85px">
        <?php echo e(\App\CentralLogics\Helpers::number_format_short($order['coupon_discount_amount'] + $order['store_discount_amount'])); ?>

    </td>
    <td class="text-center mw--85px white-space-nowrap">
        <?php echo e(\App\CentralLogics\Helpers::number_format_short($order['total_tax_amount'])); ?>

    </td>
    <td class="text-center mw--85px">
        <?php echo e(\App\CentralLogics\Helpers::number_format_short($order['delivery_charge'])); ?>

    </td>
    <td>
        <div class="text-right mw--85px">
            <div>
                <?php echo e(\App\CentralLogics\Helpers::number_format_short($order['order_amount'])); ?>

            </div>
            <?php if($order->payment_status == 'paid'): ?>
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
    <td class="text-center mw--85px text-capitalize">
        <?php echo e(isset($order->transaction) ? $order->transaction->received_by : translate('messages.not_received_yet')); ?>

    </td>
    <td class="text-center mw--85px text-capitalize">
            <?php echo e(translate(str_replace('_', ' ', $order['payment_method']))); ?>

    </td>
    <td class="text-center mw--85px text-capitalize">
        <?php if($order['order_status']=='pending'): ?>
                <span class="badge badge-soft-info">
                  <?php echo e(translate('messages.pending')); ?>

                </span>
            <?php elseif($order['order_status']=='confirmed'): ?>
                <span class="badge badge-soft-info">
                  <?php echo e(translate('messages.confirmed')); ?>

                </span>
            <?php elseif($order['order_status']=='processing'): ?>
                <span class="badge badge-soft-warning">
                  <?php echo e(translate('messages.processing')); ?>

                </span>
            <?php elseif($order['order_status']=='picked_up'): ?>
                <span class="badge badge-soft-warning">
                  <?php echo e(translate('messages.out_for_delivery')); ?>

                </span>
            <?php elseif($order['order_status']=='delivered'): ?>
                <span class="badge badge-soft-success">
                  <?php echo e(translate('messages.delivered')); ?>

                </span>
            <?php elseif($order['order_status']=='failed'): ?>
                <span class="badge badge-soft-danger">
                  <?php echo e(translate('messages.payment_failed')); ?>

                </span>
            <?php elseif($order['order_status']=='handover'): ?>
                <span class="badge badge-soft-danger">
                  <?php echo e(translate('messages.handover')); ?>

                </span>
            <?php elseif($order['order_status']=='canceled'): ?>
                <span class="badge badge-soft-danger">
                  <?php echo e(translate('messages.canceled')); ?>

                </span>
            <?php elseif($order['order_status']=='accepted'): ?>
                <span class="badge badge-soft-danger">
                  <?php echo e(translate('messages.accepted')); ?>

                </span>
            <?php else: ?>
                <span class="badge badge-soft-danger">
                  <?php echo e(str_replace('_',' ',$order['order_status'])); ?>

                </span>
            <?php endif; ?>

    </td>


    <td>
        <div class="btn--container justify-content-center">
            <a class="ml-2 btn btn-sm btn--warning btn-outline-warning action-btn"
                href="<?php echo e(route('admin.order.details', ['id' => $order['id'],'module_id'=>$order['module_id']])); ?>">
                <i class="tio-invisible"></i>
            </a>
            <a class="ml-2 btn btn-sm btn--primary btn-outline-primary action-btn"
                href="<?php echo e(route('admin.transactions.order.generate-invoice', ['id' => $order['id']])); ?>">
                <i class="tio-print"></i>
            </a>
        </div>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/report/partials/_order_table.blade.php ENDPATH**/ ?>