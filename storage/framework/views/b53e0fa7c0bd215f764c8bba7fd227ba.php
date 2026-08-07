<?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td class="text-center">
        <span class="mr-3">
            <?php echo e($key+1); ?>

        </span>
    </td>
    <td class="text-center">
        <span class="font-size-sm text-body mr-3">
            <?php echo e(Str::limit($contact['name'],20,'...')); ?>

        </span>
    </td>
    <td class="text-center">
        <span class="font-size-sm text-body mr-3">
            <?php echo e($contact['email']); ?>

        </span>
    </td>
    <td class="text-center">
        <div class="font-size-sm text-body mr-3 white--space-initial max-w-180px mx-auto">
            <?php echo e(Str::limit($contact['subject'],40,'...')); ?>

        </div>
    </td>
    <td class="text-center">
        <span class="font-size-sm text-body mr-3">
            <?php if($contact->seen==1): ?>
            <label class="badge badge-soft-success mb-0"><?php echo e(translate('messages.Seen')); ?></label>
        <?php else: ?>
            <label class="badge badge-soft-info mb-0"><?php echo e(translate('messages.Not_Seen_Yet')); ?></label>
        <?php endif; ?>
        </span>
    </td>
    <td>
        <div class="btn--container justify-content-center">
            <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route('admin.users.contact.contact-view',[$contact['id']])); ?>" title="<?php echo e(translate('messages.edit')); ?>"><i class="tio-invisible"></i>
            </a>
            <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:" data-id="contact-<?php echo e($contact['id']); ?>" data-message="<?php echo e(translate('messages.Want to delete this message?')); ?>" title="<?php echo e(translate('messages.delete')); ?>"><i class="tio-delete-outlined"></i>
            </a>
            <form action="<?php echo e(route('admin.users.contact.contact-delete',[$contact['id']])); ?>"
                    method="post" id="contact-<?php echo e($contact['id']); ?>">
                <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
            </form>
        </div>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/contacts/partials/_table.blade.php ENDPATH**/ ?>