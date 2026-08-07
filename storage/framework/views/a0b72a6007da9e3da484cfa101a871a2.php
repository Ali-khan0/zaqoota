<?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<tr class="status-<?php echo e($order['order_status']); ?> class-all">
    <td class="">
        <?php echo e($key+ 1); ?>

    </td>
    <td class="table-column-pl-0">
        <a href="<?php echo e(route('admin.order.details',['id'=>$order['id']])); ?>"><?php echo e($order['id']); ?></a>
    </td>
    <td>
        <div>
            <?php echo e(date('d M Y',strtotime($order['created_at']))); ?>

        </div>
        <div class="d-block text-uppercase">
            <?php echo e(date(config('timeformat'),strtotime($order['created_at']))); ?>

        </div>
    </td>
    <td>
        <?php if($order->is_guest): ?>
        <?php ($customer_details = json_decode($order['delivery_address'],true)); ?>
        <strong><?php echo e($customer_details['contact_person_name']); ?></strong>
        <div><?php echo e($customer_details['contact_person_number']); ?></div>
        
        <?php elseif($order->customer): ?>
        <div>
            <a class="text-body text-capitalize"
            href="<?php echo e(route('admin.customer.view',[$order['user_id']])); ?>">
                <div>
                    <?php echo e($order->customer['f_name'].' '.$order->customer['l_name']); ?>

                </div>
                <div>
                    <?php echo e($order->customer['phone']); ?>

                </div>
            </a>
        </div>
        <?php else: ?>
            <label class="badge badge-danger"><?php echo e(translate('messages.invalid_customer_data')); ?></label>
        <?php endif; ?>
    </td>
    <td>
        <?php if($order->payment_status=='paid'): ?>
            <span class="badge badge-soft-success">
            <?php echo e(translate('messages.paid')); ?>

            </span>
        <?php else: ?>
            <span class="badge badge-soft-danger">
            <?php echo e(translate('messages.unpaid')); ?>

            </span>
        <?php endif; ?>
    </td>
    <td><?php echo e(\App\CentralLogics\Helpers::format_currency($order['order_amount'])); ?></td>
    <td class="text-capitalize text-center">
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
        <?php elseif($order['order_status']=='out_for_delivery'): ?>
            <span class="badge badge-soft-warning">
            <?php echo e(translate('messages.out_for_delivery')); ?>

            </span>
        <?php elseif($order['order_status']=='delivered'): ?>
            <span class="badge badge-soft-success">
            <?php echo e(translate('messages.delivered')); ?>

            </span>
        <?php else: ?>
            <span class="badge badge-soft-danger">
            <?php echo e(str_replace('_',' ',$order['order_status'])); ?>

            </span>
        <?php endif; ?>
    </td>
    <td>
        <div class="btn--container justify-content-center">
            <a class="btn action-btn btn--warning btn-outline-warning" href="<?php echo e(route('admin.order.details',['id'=>$order['id']])); ?>"><i class="tio-visible"></i></a>
            <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route('admin.order.generate-invoice',['id'=>$order['id']])); ?>"><i class="tio-print"></i></a>
        </div>
    </td>
</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/provider/details/partials/_order.blade.php ENDPATH**/ ?>