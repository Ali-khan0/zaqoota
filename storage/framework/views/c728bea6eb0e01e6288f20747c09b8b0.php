<?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td><?php echo e($key+1); ?></td>
    <td>
    <span class="d-block font-size-sm text-body">
        <?php echo e(Str::limit($unit['unit'],20,'...')); ?>

    </span>
    </td>
    <td>
        <div class="btn--container justify-content-center">
            <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route('admin.unit.edit',[$unit['id']])); ?>" title="<?php echo e(translate('messages.edit')); ?>"><i class="tio-edit"></i>
            </a>
            <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:" data-id="unit-<?php echo e($unit['id']); ?>" data-message="<?php echo e(translate('Want to delete this unit ?')); ?>" title="<?php echo e(translate('messages.delete')); ?>"><i class="tio-delete-outlined"></i>
            </a>
            <form action="<?php echo e(route('admin.unit.destroy',[$unit['id']])); ?>"
                    method="post" id="unit-<?php echo e($unit['id']); ?>">
                <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
            </form>
        </div>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/unit/partials/_table.blade.php ENDPATH**/ ?>