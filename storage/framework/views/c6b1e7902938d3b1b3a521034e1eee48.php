<?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <th scope="row"><?php echo e($k+1); ?></th>
    <td class="text-capitalize"><?php echo e($employee['f_name']); ?> <?php echo e($employee['l_name']); ?></td>
    <td >
        <?php echo e($employee['email']); ?>

    </td>
    <td><?php echo e($employee['phone']); ?></td>
    <td><?php echo e($employee->role?$employee->role['name']:translate('messages.role_deleted')); ?></td>
    <td>
        <?php if(auth('admin')->id()  != $employee['id']): ?>
        <div class="btn--container justify-content-center">
            <a class="btn action-btn btn--primary btn-outline-primary"
                href="<?php echo e(route('admin.users.employee.edit',[$employee['id']])); ?>" title="<?php echo e(translate('messages.edit_Employee')); ?>"><i class="tio-edit"></i>
            </a>
            <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:" data-id="employee-<?php echo e($employee['id']); ?>" data-message="<?php echo e(translate('messages.Want_to_delete_this_role')); ?>" title="<?php echo e(translate('messages.delete_Employee')); ?>"><i class="tio-delete-outlined"></i>
            </a>
        </div>
        <form action="<?php echo e(route('admin.users.employee.delete',[$employee['id']])); ?>"
                method="post" id="employee-<?php echo e($employee['id']); ?>">
            <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
        </form>
        <?php endif; ?>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/employee/partials/_table.blade.php ENDPATH**/ ?>