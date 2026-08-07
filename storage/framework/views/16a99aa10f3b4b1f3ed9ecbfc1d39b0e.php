<?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td><?php echo e($key+1); ?></td>
    <td>
        <?php if($review->item): ?>
            <a class="media align-items-center" href="<?php echo e(route('admin.item.view',[$review->item['id']])); ?>">
                <img class="avatar avatar-lg mr-3 onerror-image"
              
                src="<?php echo e($review->item['image_full_url'] ?? asset('public/assets/admin/img/160x160/img2.jpg')); ?>"

                data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>" alt="<?php echo e($review->item->name); ?> image">
                <div class="media-body">
                    <h5 class="text-hover-primary mb-0"><?php echo e(Str::limit($review->item['name'],20,'...')); ?></h5>
                </div>
            </a>
            <span class="ml-10"><a href="<?php echo e(route('admin.order.details',['id'=>$review->order_id])); ?>"><?php echo e(translate('messages.order_id')); ?>: <?php echo e($review->order_id); ?></a></span>
        <?php else: ?>
            <?php echo e(translate('messages.Item deleted!')); ?>

        <?php endif; ?>

    </td>
    <td>
        <a href="<?php echo e(route('admin.customer.view',[$review->user_id])); ?>">
            <?php echo e($review->customer?$review->customer->f_name:""); ?> <?php echo e($review->customer?$review->customer->l_name:""); ?>

        </a>
    </td>
    <td>
        <p class="text-wrap"><?php echo e($review->comment); ?></p>
    </td>
    <td>
        <label class="badge badge-soft-info">
            <?php echo e($review->rating); ?> <i class="tio-star"></i>
        </label>
    </td>
    <td>
        <label class="toggle-switch toggle-switch-sm" for="reviewCheckbox<?php echo e($review->id); ?>">
            <input type="checkbox"
                   data-id="status-<?php echo e($review['id']); ?>" data-message="<?php echo e($review->status ? translate('messages.you_want_to_hide_this_review_for_customer') : translate('messages.you_want_to_show_this_review_for_customer')); ?>"
                   class="toggle-switch-input status_form_alert" id="reviewCheckbox<?php echo e($review->id); ?>"
                <?php echo e($review->status ? 'checked' : ''); ?>>
            <span class="toggle-switch-label">
                <span class="toggle-switch-indicator"></span>
            </span>
        </label>
        <form action="<?php echo e(route('admin.item.reviews.status',[$review['id'],$review->status?0:1])); ?>" method="get" id="status-<?php echo e($review['id']); ?>">
        </form>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/common.js"></script>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/product/partials/_review-table.blade.php ENDPATH**/ ?>