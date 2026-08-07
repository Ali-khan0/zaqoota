<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td><?php echo e($key + 1); ?></td>
    <td>
        <a class="media align-items-center"
            href="<?php echo e(route('admin.item.view', [$item['id'], 'module_id'=>$item['module_id']])); ?>">
            <div class="media-body">
                <h5 class="text-hover-primary mb-0"><?php echo e($item['name']); ?></h5>
            </div>
        </a>
    </td>
    <td class="text-center">
        <?php echo e($item->orders->sum('quantity')); ?>

    </td>
    <td class="text-center">
        <?php echo e($item->orders->sum('price')); ?>

    </td>
    <td class="text-center">
        <?php echo e($item->orders->sum('discount_on_item')); ?>

    </td>
    <td>
        <div class="btn--container justify-content-center">
            <a href="<?php echo e(route('admin.item.view', [$item['id'], 'module_id'=>$item['module_id']])); ?>"
                class="action-btn btn--primary btn-outline-primary">
                <i class="tio-invisible"></i>
            </a>
        </div>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/report/partials/_store_sale_table.blade.php ENDPATH**/ ?>