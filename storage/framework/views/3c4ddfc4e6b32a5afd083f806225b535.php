<?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td><?php echo e($key+1); ?></td>
        <td>
            <span class="media align-items-center">
                <img class="img--ratio-3 w-auto h--50px rounded mr-2 onerror-image" src="<?php echo e($banner['image_full_url']); ?>"
                        data-onerror-image="<?php echo e(asset('/public/assets/admin/img/900x400/img1.jpg')); ?>" alt="<?php echo e($banner->name); ?> image">
                <div class="media-body">
                    <h5 class="text-hover-primary mb-0"><?php echo e(Str::limit($banner['title'], 25, '...')); ?></h5>
                </div>
            </span>
        <span class="d-block font-size-sm text-body">

        </span>
        </td>
        <td><?php echo e(Str::limit($banner->module->module_name, 15, '...')); ?></td>
        <td><?php echo e(translate('messages.'.$banner['type'])); ?></td>
        <td>
            <div class="d-flex justify-content-center">
                <label class="toggle-switch toggle-switch-sm" for="featuredCheckbox<?php echo e($banner->id); ?>">
                    <input type="checkbox" data-url="<?php echo e(route('admin.banner.featured',[$banner['id'],$banner->featured?0:1])); ?>" class="toggle-switch-input redirect-url" id="featuredCheckbox<?php echo e($banner->id); ?>" <?php echo e($banner->featured?'checked':''); ?>>
                    <span class="toggle-switch-label">
                        <span class="toggle-switch-indicator"></span>
                    </span>
                </label>
            </div>
        </td>
        <td>
            <div class="d-flex justify-content-center">
                <label class="toggle-switch toggle-switch-sm" for="statusCheckbox<?php echo e($banner->id); ?>">
                <input type="checkbox" data-url="<?php echo e(route('admin.banner.status',[$banner['id'],$banner->status?0:1])); ?>" class="toggle-switch-input redirect-url" id="statusCheckbox<?php echo e($banner->id); ?>" <?php echo e($banner->status?'checked':''); ?>>
                <span class="toggle-switch-label">
                    <span class="toggle-switch-indicator"></span>
                </span>
            </label>
            </div>
        </td>
        <td>
            <div class="btn--container justify-content-center">
                <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route('admin.banner.edit',[$banner['id']])); ?>"title="<?php echo e(translate('messages.edit_banner')); ?>"><i class="tio-edit"></i>
                </a>
                <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:" data-id="banner-<?php echo e($banner['id']); ?>" data-message="<?php echo e(translate('Want to delete this banner ?')); ?>"><i class="tio-delete-outlined"></i>
                </a>
                <form action="<?php echo e(route('admin.banner.delete',[$banner['id']])); ?>"
                            method="post" id="banner-<?php echo e($banner['id']); ?>">
                        <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                </form>
            </div>
        </td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/common.js"></script>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/banner/partials/_table.blade.php ENDPATH**/ ?>