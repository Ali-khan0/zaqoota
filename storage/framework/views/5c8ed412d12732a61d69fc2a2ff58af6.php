<!-- Header -->
<div class="card-header">
    <h5 class="card-header-title text-capitalize">
        <i class="tio-align-to-top"></i> <?php echo e(translate('messages.top_selling_items')); ?>

    </h5>
    <a href="<?php echo e(route('vendor.item.list')); ?>" class="fz-12px font-medium text-006AE5"><?php echo e(translate('view_all')); ?></a>

</div>
<!-- End Header -->

<!-- Body -->
<div class="card-body">
    <?php if(count($top_sell) > 0): ?>
    <div class="row g-2">
        <?php $__currentLoopData = $top_sell; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4 col-sm-6 initial--27 redirect-url"
                 data-url="<?php echo e(route('vendor.item.view',[$item['id']])); ?>">
                <div class="grid-card">
                    <label class="label_1 text-center"><?php echo e(translate('messages.sold')); ?> : <?php echo e($item['order_count']); ?></label>
                    <img class="initial--28 onerror-image"
                    src="<?php echo e($item['image_full_url']); ?>"
                         data-onerror-image="<?php echo e(asset('public/assets/admin/img/placeholder-2.png')); ?>"
                         alt="<?php echo e($item->name); ?> image">
                    <div class="text-center mt-2">
                        <span class="fz--13"><?php echo e(Str::limit($item['name'],20,'...')); ?></span>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php else: ?>
    <div class="empty--data">
        <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/empty-state.svg')); ?>" alt="public">
        <h5>
            <?php echo e(translate('no_data_found')); ?>

        </h5>
    </div>

    <?php endif; ?>

</div>
<!-- End Body -->
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/common.js"></script>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/partials/_top-selling-items.blade.php ENDPATH**/ ?>