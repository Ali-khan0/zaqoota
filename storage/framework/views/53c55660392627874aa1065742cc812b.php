<?php $__empty_1 = true; $__currentLoopData = $topCustomers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <a class="grid--card" href="<?php echo e(route('admin.users.customer.view', $customer->id)); ?>">
        <img class="onerror-image"
             data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
             src="<?php echo e($customer['image_full_url']); ?>">
        <div class="cont pt-2">
            <h6 class="mb-1"><?php echo e($customer->fullName); ?></h6>
            <span><?php echo e($customer->phone); ?></span>
        </div>
        <div class="ml-auto">
            <span class="badge badge-soft"><?php echo e(translate('Trips')); ?> : <?php echo e(count($customer->trips)); ?></span>
        </div>
    </a>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="empty--data">
        <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/empty-state.svg')); ?>" alt="public">
        <h5>
            <?php echo e(translate('no_data_found')); ?>

        </h5>
    </div>
<?php endif; ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/partials/top-customers.blade.php ENDPATH**/ ?>