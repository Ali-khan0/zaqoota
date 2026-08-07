<?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td class="text-center">
            <span class="mr-3">
                <?php echo e($key+1); ?>

            </span>
        </td>
        <td class="text-center">
            <span class="font-size-sm text-body mr-3">
                <?php echo e(Str::limit($attribute['name'],20,'...')); ?>

            </span>
        </td>
        <td>
            <div class="btn--container justify-content-center">
                <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route('admin.attribute.edit',[$attribute['id']])); ?>" title="<?php echo e(translate('messages.edit')); ?>"><i class="tio-edit"></i>
                </a>
                <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:" data-id="attribute-<?php echo e($attribute['id']); ?>" data-message="<?php echo e(translate('Want to delete this attribute ?')); ?>" title="<?php echo e(translate('messages.delete')); ?>"><i class="tio-delete-outlined"></i>
                </a>
                <form action="<?php echo e(route('admin.attribute.delete',[$attribute['id']])); ?>"
                        method="post" id="attribute-<?php echo e($attribute['id']); ?>">
                    <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                </form>
            </div>
        </td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/attribute/partials/_table.blade.php ENDPATH**/ ?>