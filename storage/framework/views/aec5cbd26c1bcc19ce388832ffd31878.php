<?php $__currentLoopData = $withdraw_req; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$wr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td scope="row"><?php echo e($k+1); ?></td>
    <td><?php echo e($wr['amount']); ?></td>
    <td>
        <?php if($wr->vendor): ?>
        <a class="deco-none"
            href="<?php echo e(route('admin.store.view',[$wr->vendor['id'],'module_id'=>$wr->vendor->stores[0]->module_id])); ?>"><?php echo e(Str::limit($wr->vendor->stores[0]->name, 20, '...')); ?></a>
        <?php else: ?>
        <?php echo e(translate('messages.store deleted!')); ?>

        <?php endif; ?>
    </td>
    <td><?php echo e(date('Y-m-d '.config('timeformat'),strtotime($wr->created_at))); ?></td>
    <td>
        <?php if($wr->approved==0): ?>
            <label class="badge badge-primary"><?php echo e(translate('messages.pending')); ?></label>
        <?php elseif($wr->approved==1): ?>
            <label class="badge badge-success"><?php echo e(translate('messages.approved')); ?></label>
        <?php else: ?>
            <label class="badge badge-danger"><?php echo e(translate('messages.denied')); ?></label>
        <?php endif; ?>
    </td>
    <td>
        <?php if($wr->vendor): ?>
        <a href="<?php echo e(route('admin.transactions.store.withdraw_view',[$wr['id'],$wr->vendor['id']])); ?>"
            class="btn action-btn btn--warning btn-outline-warning"><i class="tio-visible-outlined"></i>
        </a>
        <?php else: ?>
        <?php echo e(translate('messages.store_deleted')); ?>

        <?php endif; ?>

    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/wallet/partials/_table.blade.php ENDPATH**/ ?>