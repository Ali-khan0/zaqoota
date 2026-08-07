<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td><?php echo e($key + 1); ?></td>
        <td>
            <a class="media align-items-center" href="<?php echo e(route('admin.item.view', [$item['id']])); ?>">
                <img class="avatar avatar-lg mr-3 onerror-image"
            
                src="<?php echo e($item['image_full_url'] ?? asset('public/assets/admin/img/160x160/img2.jpg')); ?>"

                data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                    alt="<?php echo e($item->name); ?> image">
                <div class="media-body">
                    <h5 class="text-hover-primary mb-0"><?php echo e(Str::limit($item['name'], 20, '...')); ?></h5>
                </div>
            </a>
        </td>
        <td>
            <?php echo e(Str::limit($item->category ? $item->category->name : translate('messages.category_deleted'), 20, '...')); ?>

        </td>
        <td>
            <?php echo e(Str::limit($item->store ? $item->store->name : translate('messages.store deleted!'), 20, '...')); ?>

        </td>
        <td>
            <div class="text-right mw--85px">
                <?php echo e(\App\CentralLogics\Helpers::format_currency($item['price'])); ?>

            </div>
        </td>
        <td>
            <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox<?php echo e($item->id); ?>">
                <input type="checkbox" class="toggle-switch-input redirect-url" data-url="<?php echo e(route('admin.item.status', [$item['id'], $item->status ? 0 : 1])); ?>"
                    id="stocksCheckbox<?php echo e($item->id); ?>" <?php echo e($item->status ? 'checked' : ''); ?>>
                <span class="toggle-switch-label mx-auto">
                    <span class="toggle-switch-indicator"></span>
                </span>
            </label>
        </td>
        <td>
            <div class="btn--container justify-content-center">
                <a class="btn action-btn btn--primary btn-outline-primary"
                    href="<?php echo e(route('admin.item.edit', [$item['id']])); ?>"
                    title="<?php echo e(translate('messages.edit_item')); ?>"><i class="tio-edit"></i>
                </a>
                <a class="btn  action-btn btn--danger btn-outline-danger form-alert" href="javascript:"
                    data-id="food-<?php echo e($item['id']); ?>" data-message="<?php echo e(translate('messages.Want_to_delete_this_item')); ?>"
                    title="<?php echo e(translate('messages.delete_item')); ?>"><i
                        class="tio-delete-outlined"></i>
                </a>
                <form action="<?php echo e(route('admin.item.delete', [$item['id']])); ?>" method="post"
                    id="food-<?php echo e($item['id']); ?>">
                    <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                </form>
            </div>
        </td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/common.js"></script>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/product/partials/_table.blade.php ENDPATH**/ ?>