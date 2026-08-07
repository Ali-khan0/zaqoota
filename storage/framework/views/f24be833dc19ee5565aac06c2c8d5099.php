<?php $__currentLoopData = $delivery_men; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$dm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td><?php echo e($key+1); ?></td>
        <td>
            <a class="table-rest-info" href="<?php echo e(route('admin.users.delivery-man.preview',[$dm['id']])); ?>">
                <img class="onerror-image" data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
                src="<?php echo e($dm['image_full_url']); ?>"
                alt="<?php echo e($dm['f_name']); ?> <?php echo e($dm['l_name']); ?>">
                <div class="info">
                    <h5 class="text-hover-primary mb-0"><?php echo e($dm['f_name'].' '.$dm['l_name']); ?></h5>
                    <span class="d-block text-body">
                        <span class="rating">
                        <i class="tio-star"></i> <?php echo e(count($dm->rating)>0?number_format($dm->rating[0]->average, 1, '.', ' '):0); ?>

                        </span>
                    </span>
                </div>
            </a>
        </td>
    <td>
        <a class="deco-none" href="tel:<?php echo e($dm['phone']); ?>"><?php echo e($dm['phone']); ?></a>
    </td>
    <td>
        <?php if($dm->zone): ?>
        <label class="text--title font-medium mb-0"><?php echo e($dm->zone->name); ?></label>
        <?php else: ?>
        <label class="text--title font-medium mb-0"><?php echo e(translate('messages.zone_deleted')); ?></label>
        <?php endif; ?>
    </td>
    <td>
        <?php ($rf = $dm->registrationFee); ?>
        <?php if($rf && $rf->manual_confirmed): ?>
            <span class="text--title font-medium"><?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?><?php echo e(number_format($rf->manual_paid_amount, 2)); ?></span>
        <?php elseif($rf): ?>
            <span class="badge badge-soft-warning"><?php echo e(translate('messages.pending')); ?></span>
        <?php else: ?>
            <span class="text-muted">—</span>
        <?php endif; ?>
    </td>
    <td>
        <?php if($rf ?? null): ?>
            <span class="text--title font-medium"><?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?><?php echo e(number_format($rf->wallet_remaining_due, 2)); ?></span>
            <?php if($rf->completed_at): ?>
                <span class="badge badge-soft-success ml-1"><?php echo e(translate('messages.completed')); ?></span>
            <?php endif; ?>
        <?php else: ?>
            <span class="text-muted">—</span>
        <?php endif; ?>
    </td>
    <td>
        <a class="deco-none"><?php echo e(count($dm['orders'])); ?></a>
    </td>
    <td>
        <div>
            <?php echo e(translate('messages.currently_assigned_orders')); ?> : <?php echo e($dm->current_orders); ?>

        </div>
        <div>
            <?php echo e(translate('messages.active_status')); ?> :
            <?php if($dm->application_status == 'approved'): ?>
                <?php if($dm->active): ?>
                <strong class="text-capitalize text-primary"><?php echo e(translate('messages.online')); ?></strong>
                <?php else: ?>
                <strong class="text-capitalize text-secondary"><?php echo e(translate('messages.offline')); ?></strong>
                <?php endif; ?>
            <?php elseif($dm->application_status == 'denied'): ?>
                <strong class="text-capitalize text-danger"><?php echo e(translate('messages.denied')); ?></strong>
            <?php else: ?>
                <strong class="text-capitalize text-info"><?php echo e(translate('messages.pending')); ?></strong>
            <?php endif; ?>
        </div>
    </td>
    <td>
        <div class="btn--container justify-content-center">
            <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route('admin.users.delivery-man.edit',[$dm['id']])); ?>" title="<?php echo e(translate('messages.edit')); ?>"><i class="tio-edit"></i>
                </a>
            <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:" data-id="delivery-man-<?php echo e($dm['id']); ?>" data-message="<?php echo e(translate('Want to remove this deliveryman ?')); ?>" title="<?php echo e(translate('messages.delete')); ?>"><i class="tio-delete-outlined"></i>
            </a>
            <form action="<?php echo e(route('admin.users.delivery-man.delete',[$dm['id']])); ?>" method="post" id="delivery-man-<?php echo e($dm['id']); ?>">
                <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
            </form>
        </div>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/common.js"></script><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/delivery-man/partials/_table.blade.php ENDPATH**/ ?>