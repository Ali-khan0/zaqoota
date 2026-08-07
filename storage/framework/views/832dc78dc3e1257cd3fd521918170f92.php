<?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr class="">
    <td class="">
        <?php echo e($key + 1); ?>

    </td>
    <td class="table-column-pl-0">
        <a href="<?php echo e(route('admin.users.customer.view', [$customer['id']])); ?>" class="text--hover">
            <?php echo e($customer['f_name'] . ' ' . $customer['l_name']); ?>

        </a>
    </td>
    <td>
        <div>
            <?php echo e($customer['email']); ?>

        </div>
        <div>
            <?php echo e($customer['phone']); ?>

        </div>
    </td>
    <td>
        <label class="badge">
            <?php echo e($customer->order_count); ?>

        </label>
    </td>
    <td>
        <label class="toggle-switch toggle-switch-sm ml-xl-4" for="stocksCheckbox<?php echo e($customer->id); ?>">
            <input type="checkbox" data-url="<?php echo e(route('admin.users.customer.status', [$customer->id, $customer->status ? 0 : 1])); ?>" data-message="<?php echo e($customer->status? translate('messages.you_want_to_block_this_customer'): translate('messages.you_want_to_unblock_this_customer')); ?>"
                   class="toggle-switch-input status_change_alert" id="stocksCheckbox<?php echo e($customer->id); ?>"
                <?php echo e($customer->status ? 'checked' : ''); ?>>
            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
        </label>
    </td>
    <td>
        <a class="btn action-btn btn--warning btn-outline-warning"
            href="<?php echo e(route('admin.users.customer.view', [$customer['id']])); ?>"
            title="<?php echo e(translate('messages.view_customer')); ?>"><i
                class="tio-visible-outlined"></i>
        </a>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/customer/partials/_table.blade.php ENDPATH**/ ?>