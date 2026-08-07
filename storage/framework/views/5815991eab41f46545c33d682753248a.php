<?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php if(isset($review->delivery_man)): ?>
    <tr>
        <td><?php echo e($key+1); ?></td>
        <td>
        <span class="d-block font-size-sm text-body">
            <a href="<?php echo e(route('admin.users.delivery-man.preview',[$review['delivery_man_id']])); ?>">
                <?php echo e($review->delivery_man->f_name.' '.$review->delivery_man->l_name); ?>

            </a>
        </span>
        </td>
        <td>
            <?php if($review->customer): ?>
            <a href="<?php echo e(route('admin.users.customer.view',[$review->user_id])); ?>">
                <?php echo e($review->customer?$review->customer->f_name:""); ?> <?php echo e($review->customer?$review->customer->l_name:""); ?>

            </a>
            <?php else: ?>
                <?php echo e(translate('messages.customer_not_found')); ?>

            <?php endif; ?>

        </td>
        <td>
            <?php echo e($review->comment); ?>

        </td>
        <td>
            <label class="rating">
                <?php echo e($review->rating); ?> <i class="tio-star"></i>
            </label>
        </td>
    </tr>
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/delivery-man/partials/_review.blade.php ENDPATH**/ ?>