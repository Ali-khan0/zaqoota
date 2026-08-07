<?php $__currentLoopData = $order_transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $ot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr scope="row">
    <td><?php echo e($k + 1); ?></td>
    <?php if($ot->order->order_type == 'parcel'): ?>
        <td><a
                href="<?php echo e(route('admin.transactions.parcel.order.details', $ot->order_id)); ?>"><?php echo e($ot->order_id); ?></a>
        </td>
    <?php else: ?>
        <td><a
                href="<?php echo e(route('admin.transactions.order.details', $ot->order_id)); ?>"><?php echo e($ot->order_id); ?></a>
        </td>
    <?php endif; ?>
    <td  class="text-capitalize">
        <?php if($ot->order->store): ?>
            <?php echo e(Str::limit($ot->order->store->name,25,'...')); ?>

        <?php else: ?>
            <label class="badge badge-soft-success white-space-nowrap"><?php echo e(translate('messages.parcel_order')); ?>

        <?php endif; ?>
    </td>
    <td class="white-space-nowrap">
        <?php if($ot->order->customer): ?>
            <a class="text-body text-capitalize"
                href="<?php echo e(route('admin.users.customer.view', [$ot->order['user_id']])); ?>">
                <strong><?php echo e($ot->order->customer['f_name'] . ' ' . $ot->order->customer['l_name']); ?></strong>
            </a>
        <?php else: ?>
            <label class="badge badge-danger"><?php echo e(translate('messages.invalid')); ?>

                <?php echo e(translate('messages.customer')); ?>

                <?php echo e(translate('messages.data')); ?></label>
        <?php endif; ?>
    </td>
    <td class="white-space-nowrap"><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->order['order_amount'] - $ot->order['dm_tips']-$ot->order['delivery_charge'] - $ot['tax'] + $ot->order['coupon_discount_amount'] + $ot->order['store_discount_amount'])); ?></td>
    <td class="white-space-nowrap"><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->order->details->sum('discount_on_item'))); ?></td>
    <td class="white-space-nowrap"><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->order['coupon_discount_amount'])); ?></td>
    <td class="white-space-nowrap">  <?php echo e(\App\CentralLogics\Helpers::number_format_short($ot->order['coupon_discount_amount'] + $ot->order['store_discount_amount'])); ?></td>
    <td class="white-space-nowrap"><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->tax)); ?></td>
    <td class="white-space-nowrap"><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->delivery_charge)); ?></td>
    <td class="white-space-nowrap"><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->order_amount)); ?></td>
    <td class="white-space-nowrap"><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->admin_expense)); ?></td>
    <td class="white-space-nowrap"><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->order->store_discount_amount)); ?></td>
    <td class="white-space-nowrap"><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->net_non_delivery_commission)); ?></td>
    <td class="white-space-nowrap"><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->net_delivery_commission)); ?></td>
    <td class="white-space-nowrap"><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->net_admin_commission)); ?></td>
    <td class="white-space-nowrap"><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->store_amount - $ot->tax)); ?></td>
    <?php if($ot->received_by == 'admin'): ?>
        <td class="text-capitalize white-space-nowrap"><?php echo e(translate('messages.admin')); ?></td>
    <?php elseif($ot->received_by == 'deliveryman'): ?>
        <td class="text-capitalize white-space-nowrap">
            <div><?php echo e(translate('messages.delivery_man')); ?></div>
            <div class="text-right mw--85px">
                <?php if(isset($ot->delivery_man) && $ot->delivery_man->earning == 1): ?>
                <span class="badge badge-soft-primary">
                    <?php echo e(translate('messages.freelance')); ?>

                </span>
                <?php elseif(isset($ot->delivery_man) && $ot->delivery_man->earning == 0 && $ot->delivery_man->type == 'restaurant_wise'): ?>
                <span class="badge badge-soft-warning">
                    <?php echo e(translate('messages.restaurant')); ?>

                </span>
                <?php elseif(isset($ot->delivery_man) && $ot->delivery_man->earning == 0 && $ot->delivery_man->type == 'zone_wise'): ?>
                <span class="badge badge-soft-success">
                    <?php echo e(translate('messages.admin')); ?>

                    </span>
                <?php endif; ?>
            </div>
        </td>
    <?php elseif($ot->received_by == 'store'): ?>
        <td class="text-capitalize white-space-nowrap"><?php echo e(translate('messages.store')); ?></td>
    <?php endif; ?>
    <td class="mw--85px text-capitalize min-w-120 ">
            <?php echo e(translate(str_replace('_', ' ', $ot->order['payment_method']))); ?>

    </td>
    <td class="text-capitalize white-space-nowrap">
        <?php if($ot->status): ?>
        <span class="badge badge-soft-danger">
            <?php echo e(translate('messages.refunded')); ?>

          </span>
        <?php else: ?>
        <span class="badge badge-soft-success">
            <?php echo e(translate('messages.completed')); ?>

          </span>
        <?php endif; ?>
    </td>

    <td>
        <div class="btn--container justify-content-center">
            <a class="btn btn-outline-success square-btn btn-sm mr-1 action-btn"  href="<?php echo e(route('admin.report.generate-statement',[$ot['id']])); ?>">
                <i class="tio-download-to"></i>
            </a>
        </div>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/report/partials/_day_table.blade.php ENDPATH**/ ?>