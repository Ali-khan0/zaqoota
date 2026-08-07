<!-- Header -->
<div class="card-header">
    <h5 class="card-header-title text-capitalize">
        <i class="tio-star"></i> <?php echo e(translate('messages.top_rated_items')); ?>

    </h5>
    <a href="<?php echo e(route('vendor.item.list')); ?>" class="fz-12px font-medium text-006AE5"><?php echo e(translate('view_all')); ?></a>

</div>
<!-- End Header -->

<!-- Body -->
<div class="card-body">
    <?php if(count($most_rated_items) > 0): ?>
    <div class="row g-2">
        <?php $__currentLoopData = $most_rated_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-4 col-6">
            <div class="grid-card top--rated-food pb-4 cursor-pointer redirect-url"
                 data-url="<?php echo e(route('vendor.item.view',[$item['id']])); ?>">
                <div class="text-center">
                    <img class="rounded onerror-image" src="<?php echo e($item['image_full_url']); ?>"
                    data-onerror-image="<?php echo e(asset('public/assets/admin/img/100x100/2.png')); ?>" alt="<?php echo e(Str::limit($item->name??translate('messages.Item deleted!'),20,'...')); ?>">
                </div>

                <div class="text-center mt-3">
                    <h5 class="name m-0 mb-1"><?php echo e(Str::limit($item->name??translate('messages.Item deleted!'),20,'...')); ?></h5>
                    <div class="rating">
                        <span class="text-warning"><i class="tio-star"></i> <?php echo e(round($item['avg_rating'],1)); ?></span>
                        <span class="text--title">(<?php echo e($item['rating_count']); ?>  <?php echo e(translate('messages.reviews')); ?>)</span>
                    </div>
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
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/partials/_most-rated-items.blade.php ENDPATH**/ ?>