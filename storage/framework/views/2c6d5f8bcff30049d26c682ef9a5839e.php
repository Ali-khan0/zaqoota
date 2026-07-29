<div class="card-header border-0 order-header-shadow">
    <h5 class="card-title d-flex justify-content-between">
        <span><?php echo e(translate('messages.top_customers')); ?></span>
    </h5>
    <a href="<?php echo e(route('admin.users.customer.list')); ?>"
        class="fz-12px font-medium text-006AE5"><?php echo e(translate('view_all')); ?></a>
</div>

<div class="card-body">

    <?php if(count($top_customers) > 0): ?>
        <div class="top--selling">

            <?php $__empty_1 = true; $__currentLoopData = $top_customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a class="grid--card" href="<?php echo e(route('admin.users.customer.view', [$item['id']])); ?>">
                    <img class="onerror-image"
                        data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
                        src="<?php echo e($item->image_full_url ?? asset('public/assets/admin/img/160x160/img1.jpg')); ?>">
                    <div class="cont pt-2">
                        <h6 class="mb-1"><?php echo e($item['f_name'] ?? translate('Not exist')); ?></h6>
                        <span><?php echo e($item['phone'] ?? ''); ?></span>
                    </div>
                    <div class="ml-auto">
                        <span class="badge badge-soft"><?php echo e(translate('Orders')); ?> : <?php echo e($item['order_count']); ?></span>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php endif; ?>

        </div>
    <?php else: ?>
        <!-- <div class="empty--data">
            <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/empty-state.svg')); ?>" alt="public">
            <h5>
                <?php echo e(translate('no_data_found')); ?>

            </h5>
        </div> -->
        <div class="empty--data d-flex flex-column align-items-center justify-content-center h-100 w-100">
            <img src="<?php echo e(asset('/public/assets/admin/img/no-customer.png')); ?>" alt="public">
            <h5 class="secondary-clr">
                <?php echo e(translate('No customer available')); ?>

            </h5>
        </div>
    <?php endif; ?>

</div>

<script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/common.js"></script>
<?php /**PATH /var/www/zaqoota/resources/views/admin-views/partials/_top-customer.blade.php ENDPATH**/ ?>