<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td><?php echo e($key+1); ?></td>
    <td>
        <a class="media align-items-center" href="<?php echo e(route('admin.item.view',[$item['id'],'module_id'=>$item['module_id']])); ?>">
            <img class="avatar avatar-lg mr-3 onerror-image"
            src="<?php echo e($item['image_full_url'] ?? asset('public/assets/admin/img/160x160/img2.jpg')); ?>"

            data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>"

            alt="<?php echo e($item->name); ?> image">
            <div class="media-body">
                <h5 class="text-hover-primary mb-0"><?php echo e($item['name']); ?></h5>
            </div>
        </a>
    </td>
    <td>
        <?php echo e($item->module->module_name); ?>

    </td>
    <td>
        <?php if($item->store): ?>
        <?php echo e(Str::limit($item->store->name,25,'...')); ?>

        <?php else: ?>
        <?php echo e(translate('messages.store_deleted')); ?>

        <?php endif; ?>
    </td>
    <td>
        <?php echo e($item->orders_count); ?>

    </td>
    <td>
        <?php echo e(\App\CentralLogics\Helpers::format_currency($item->price)); ?>

    </td>
    <td>
        <?php echo e(\App\CentralLogics\Helpers::format_currency($item->orders_sum_price)); ?>

    </td>
    <td>
        <?php echo e(\App\CentralLogics\Helpers::format_currency($item->orders_sum_discount_on_item)); ?>

    </td>
    <td>
        <?php echo e($item->orders_count>0? \App\CentralLogics\Helpers::format_currency(($item->orders_sum_price-$item->orders_sum_discount_on_item)/$item->orders_count):0); ?>

    </td>
    <td>
        <div class="rating">
            <span><i class="tio-star"></i></span><?php echo e($item->avg_rating); ?> (<?php echo e($item->rating_count); ?>)
        </div>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/common.js"></script>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/report/partials/_item_table.blade.php ENDPATH**/ ?>