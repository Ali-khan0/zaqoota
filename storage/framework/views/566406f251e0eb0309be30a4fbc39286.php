<?php $__currentLoopData = $conditions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$condition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td><?php echo e($key+1); ?></td>
    <td>
        <span class="d-block font-size-sm text-body">
            <?php echo e(Str::limit($condition['name'], 20,'...')); ?>

        </span>
    </td>
    <td>
        <span class="d-block font-size-sm text-body text-center">
            <?php echo e($condition->items->count()); ?>

        </span>
    </td>
    <td>
        <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox<?php echo e($condition->id); ?>">
            <input type="checkbox" data-url="<?php echo e(route('admin.common-condition.status',[$condition['id'],$condition->status?0:1])); ?>" class="toggle-switch-input redirect-url" id="stocksCheckbox<?php echo e($condition->id); ?>" <?php echo e($condition->status?'checked':''); ?>>
            <span class="toggle-switch-label mx-auto">
                <span class="toggle-switch-indicator"></span>
            </span>
        </label>
    </td>
    <td>
        <div class="btn--container justify-content-center">
            <a class="btn action-btn btn--primary btn-outline-primary"
                href="<?php echo e(route('admin.common-condition.edit',[$condition['id']])); ?>" title="<?php echo e(translate('messages.edit_condition')); ?>"><i class="tio-edit"></i>
            </a>
            <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:" data-id="condition-<?php echo e($condition['id']); ?>" data-message="<?php echo e(translate('messages.Want to delete this condition')); ?>"  title="<?php echo e(translate('messages.delete_condition')); ?>"><i class="tio-delete-outlined"></i>
            </a>
            <form action="<?php echo e(route('admin.common-condition.delete',[$condition['id']])); ?>" method="post" id="condition-<?php echo e($condition['id']); ?>">
                <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
            </form>
        </div>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/common-condition/partials/_table.blade.php ENDPATH**/ ?>