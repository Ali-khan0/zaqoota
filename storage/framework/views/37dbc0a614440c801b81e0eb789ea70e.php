<?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<tr class="status-<?php echo e($order['order_status']); ?> class-all">
    <td class="">
        <?php echo e($key+1); ?>

    </td>
    <td class="table-column-pl-0">
        <a href="<?php echo e(route($parcel_order?'admin.parcel.order.details':'admin.order.details',['id'=>$order['id']])); ?>"><?php echo e($order['id']); ?></a>
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
        <?php if($order->customer): ?>
            <a class="text-body text-capitalize" href="<?php echo e(route('admin.users.customer.view',[$order['user_id']])); ?>">
                <strong><?php echo e($order->customer['f_name'].' '.$order->customer['l_name']); ?></strong>
                <div><?php echo e($order->customer['phone']); ?></div>
            </a>
        <?php else: ?>
            <label class="badge badge-danger"><?php echo e(translate('messages.invalid_customer_data')); ?></label>
        <?php endif; ?>
    </td>
    <?php if($parcel_order): ?>

    <?php endif; ?>
    <td>
        <?php if($parcel_order): ?>
            <div><?php echo e(Str::limit($order->parcel_category?$order->parcel_category->name:translate('messages.not_found'),20,'...')); ?></div>
        <?php elseif($order->store): ?>
            <div><a  class="text--title" href="<?php echo e(route('admin.store.view', [$order->store_id,'module_id'=>$order['module_id']])); ?>" alt="view store"><?php echo e(Str::limit($order->store?$order->store->name:translate('messages.store deleted!'),20,'...')); ?></a></div>
        <?php else: ?>
            <div><?php echo e(Str::limit(translate('messages.not_found'),20,'...')); ?></div>
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
            <?php elseif($order->payment_status=='partially_paid'): ?>
            <strong class="text-success">
                <?php echo e(translate('messages.partially_paid')); ?>

            </strong>
            <?php else: ?>
            <strong class="text-danger">
                <?php echo e(translate('messages.unpaid')); ?>

            </strong>
            <?php endif; ?>
        </div>
    </td>
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
        <?php else: ?>
            <span class="badge badge-soft-danger">
              <?php echo e(str_replace('_',' ',$order['order_status'])); ?>

            </span>
        <?php endif; ?>
        <?php if($order['order_type']=='take_away'): ?>
            <div class="text-info mt-1">
                <?php echo e(translate('messages.take_away')); ?>

            </div>
        <?php else: ?>
            <div class="text-title mt-1">
              <?php echo e(translate('messages.home Delivery')); ?>

            </div>
        <?php endif; ?>
    </td>
    <td>
        <div class="btn--container justify-content-center">
            <a class="ml-2 btn btn-sm btn--warning btn-outline-warning action-btn" href="<?php echo e(route($parcel_order?'admin.parcel.order.details':'admin.order.details',['id'=>$order['id'],'module_id'=>$order['module_id']])); ?>">
                <i class="tio-invisible"></i>
            </a>
            <a class="ml-2 btn btn-sm btn--primary btn-outline-primary action-btn" href="<?php echo e(route($parcel_order?'admin.order.generate-invoice':'admin.order.generate-invoice',['id'=>$order['id'],'module_id'=>$order['module_id']])); ?>">
                <i class="tio-print"></i>
            </a>
        </div>
    </td>
</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php if(count($orders) === 0): ?>
<tr>
    <td colspan="12">
        <div class="empty--data">
            <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
            <h5>
                <?php echo e(translate('no_data_found')); ?>

            </h5>
        </div>
    </td>
</tr>
<?php endif; ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/order/partials/_table.blade.php ENDPATH**/ ?>