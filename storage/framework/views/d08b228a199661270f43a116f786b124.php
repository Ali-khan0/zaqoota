<?php $__currentLoopData = $account_transaction; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$at): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td scope="row"><?php echo e($k+1); ?></td>
    <td>
        <?php if($at->store): ?>
        <a href="<?php echo e(route('admin.store.view',[$at->store['id'],'module_id'=>$at->store['module_id']])); ?>"><?php echo e(Str::limit($at->store->name, 20, '...')); ?></a>
        <?php elseif($at->deliveryman): ?>
        <a href="<?php echo e(route('admin.users.delivery-man.preview',[$at->deliveryman->id])); ?>"><?php echo e($at->deliveryman->f_name); ?> <?php echo e($at->deliveryman->l_name); ?></a>
        <?php else: ?>
            <?php echo e(translate('messages.not_found')); ?>

        <?php endif; ?>
    </td>
    <td><label class="text-uppercase"><?php echo e($at['from_type']); ?></label></td>
    <td><?php echo e($at->created_at->format('Y-m-d '.config('timeformat'))); ?></td>
    <td><div class="pl-4">
        <?php echo e($at['amount']); ?>

    </div></td>
    <td><div class="pl-4">
        <?php echo e($at['ref']); ?>

    </div></td>
    <td>
        <div class="btn--container justify-content-center">
            <a href="<?php echo e(route('admin.transactions.account-transaction.view',[$at['id']])); ?>"
            class="btn action-btn btn--warning btn-outline-warning"><i class="tio-visible"></i>
            </a>
        </div>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/account/partials/_table.blade.php ENDPATH**/ ?>