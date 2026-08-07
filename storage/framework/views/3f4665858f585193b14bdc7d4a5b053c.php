<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td><?php echo e($key+1); ?></td>
    <td>
        <a class="media align-items-center" href="<?php echo e(route('admin.item.view',[$item['id'],'module_id'=>$item['module_id']])); ?>">
            <img class="avatar avatar-lg mr-3 onerror-image"
            src="<?php echo e($item['image_full_url'] ?? asset('public/assets/admin/img/160x160/img2.jpg')); ?>"

            data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>" alt="<?php echo e($item->name); ?> image">
            <div class="media-body">
                <h5 class="text-hover-primary mb-0 max-width-200px word-break line--limit-2"><?php echo e($item['name']); ?></h5>
            </div>
        </a>
    </td>
    <td>
        <?php if($item->store): ?>
        <?php echo e(Str::limit($item->store->name,25,'...')); ?>

        <?php else: ?>
        <?php echo e(translate('messages.store_deleted')); ?>

        <?php endif; ?>
    </td>
    <td>
        <?php if($item->store): ?>
        <?php echo e($item->store->zone->name); ?>

        <?php else: ?>
        <?php echo e(translate('messages.not_found')); ?>

        <?php endif; ?>
    </td>
    <td>
        <?php echo e($item->stock); ?>

    </td>

    <td>
        <a class="btn action-btn btn--primary btn-outline-primary update-quantity" href="javascript:" title="<?php echo e(translate('messages.edit_quantity')); ?>" data-id="<?php echo e($item->id); ?>" data-toggle="modal" data-target="#update-quantity"><i class="tio-edit"></i>
        </a>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/common.js"></script>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/report/partials/_stock_table.blade.php ENDPATH**/ ?>