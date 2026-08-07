<?php $__currentLoopData = $digital_transaction; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$dt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td><?php echo e($k+$digital_transaction->firstItem()); ?></td>
    <td><a href="<?php echo e(route('admin.order.details',$dt->order_id)); ?>"><?php echo e($dt->order_id); ?></a></td>
    <td><?php echo e($dt->original_delivery_charge); ?></td>
    <td><?php echo e($dt->created_at->format('Y-m-d')); ?></td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/delivery-man/partials/_transation.blade.php ENDPATH**/ ?>