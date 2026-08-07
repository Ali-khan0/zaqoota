<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($key+1); ?></td>
            <td>
                <a class="media align-items-center" href="<?php echo e(route('vendor.item.view',[$item['id']])); ?>">
                    <img class="avatar avatar-lg mr-3 onerror-image" src="<?php echo e($item['image_full_url']); ?>"
                         data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>" alt="<?php echo e($item->name); ?> image">
                    <div class="media-body">
                        <h5 class="text-hover-primary mb-0"><?php echo e(Str::limit($item['name'],20,'...')); ?></h5>
                    </div>
                </a>
            </td>
            <td>
                <?php echo e(Str::limit($item->category?$item->category->name:translate('messages.category_deleted'),20,'...')); ?>

            </td>
            <td>
                <div class="mw--85px">
                    <?php echo e(\App\CentralLogics\Helpers::format_currency($item['price'])); ?>

                </div>
            </td>
            <td>
                <div class="d-flex">
                    <div class="mx-auto">
                        <label class="toggle-switch toggle-switch-sm mr-2"  data-toggle="tooltip" data-placement="top" title="<?php echo e(translate('messages.Recommend_to_customers')); ?>" for="recCheckbox<?php echo e($item->id); ?>">
                            <input type="checkbox" data-url="<?php echo e(route('vendor.item.recommended',[$item['id'],$item->recommended?0:1])); ?>" class="toggle-switch-input redirect-url" id="recCheckbox<?php echo e($item->id); ?>" <?php echo e($item->recommended?'checked':''); ?>>
                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                        </label>
                    </div>
                </div>
            </td>
            <td>
                <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox<?php echo e($item->id); ?>">
                    <input type="checkbox" data-url="<?php echo e(route('vendor.item.status',[$item['id'],$item->status?0:1])); ?>" class="toggle-switch-input redirect-url" id="stocksCheckbox<?php echo e($item->id); ?>" <?php echo e($item->status?'checked':''); ?>>
                    <span class="toggle-switch-label mx-auto">
                                        <span class="toggle-switch-indicator"></span>
                                    </span>
                </label>
            </td>
            <td>
                <div class="btn--container justify-content-center">
                    <a class="btn btn-sm btn--primary btn-outline-primary action-btn"
                       href="<?php echo e(route('vendor.item.edit',[$item['id']])); ?>" title="<?php echo e(translate('messages.edit_item')); ?>"><i class="tio-edit"></i>
                    </a>
                    <a class="btn btn-sm btn--danger btn-outline-danger action-btn form-alert" href="javascript:"
                       data-id="food-<?php echo e($item['id']); ?>" data-message="<?php echo e(translate('Want to delete this item ?')); ?>" title="<?php echo e(translate('messages.delete_item')); ?>"><i class="tio-delete-outlined"></i>
                    </a>
                </div>
                <form action="<?php echo e(route('vendor.item.delete',[$item['id']])); ?>"
                      method="post" id="food-<?php echo e($item['id']); ?>">
                    <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                </form>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/common.js"></script><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/product/partials/_table.blade.php ENDPATH**/ ?>