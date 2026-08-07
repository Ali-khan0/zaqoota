<?php $__currentLoopData = $provide_dm_earning; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$at): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td><?php echo e($k+1); ?></td>
    <td><?php if($at->delivery_man): ?><a href="<?php echo e(route('admin.users.delivery-man.preview', $at->delivery_man_id)); ?>"><?php echo e($at->delivery_man->f_name.' '.$at->delivery_man->l_name); ?></a> <?php else: ?> <label class="text-capitalize text-danger"><?php echo e(translate('messages.deliveryman_deleted')); ?></label> <?php endif; ?> </td>
    <td><?php echo e($at->created_at->format('Y-m-d '.config('timeformat'))); ?></td>
    <td><?php echo e($at['amount']); ?></td>
    <td><?php echo e($at['method']); ?></td>
    <td><?php echo e($at['ref']); ?></td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/deliveryman-earning-provide/partials/_table.blade.php ENDPATH**/ ?>