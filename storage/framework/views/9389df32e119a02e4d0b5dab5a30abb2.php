<?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td scope="row"><?php echo e($k+1); ?></td>
        <td><?php echo e($role['name']); ?></td>
        <td class="text-capitalize">
            <?php if($role['modules']!=null): ?>
                <?php $__currentLoopData = (array)json_decode($role['modules']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e(str_replace('_',' ',$module)); ?>,
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </td>
        <td><?php echo e(date('d-M-y',strtotime($role['created_at']))); ?></td>
        <td>
            <div class="btn--container justify-content-center">
                <a class="btn action-btn btn--primary btn-outline-primary"
                    href="<?php echo e(route('admin.users.custom-role.edit',[$role['id']])); ?>" title="<?php echo e(translate('messages.edit_role')); ?>"><i class="tio-edit"></i>
                </a>
                <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:" data-id="role-<?php echo e($role['id']); ?>" data-message="<?php echo e(translate('messages.Want_to_delete_this_role')); ?>"
                   title="<?php echo e(translate('messages.delete_role')); ?>"><i class="tio-delete-outlined"></i>
                </a>
            </div>
            <form action="<?php echo e(route('admin.users.custom-role.delete',[$role['id']])); ?>"
                    method="post" id="role-<?php echo e($role['id']); ?>">
                <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
            </form>
        </td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/custom-role/partials/_table.blade.php ENDPATH**/ ?>