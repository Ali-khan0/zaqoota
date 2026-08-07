<div class="col-sm-6 col-lg-3">
    <!-- Card -->
    <a class="resturant-card dashboard--card card--bg-1" href="<?php echo e(route('vendor.order.list',['confirmed'])); ?>">
       <h4 class="title"><?php echo e($data['confirmed']); ?></h4>
       <span class="subtitle"><?php echo e(translate('messages.confirmed')); ?></span>
       <img src="<?php echo e(asset('public/assets/admin/img/dashboard/1.png')); ?>" alt="img" class="resturant-icon">
    </a>
    <!-- End Card -->
</div>

<div class="col-sm-6 col-lg-3">
    <!-- Card -->
    <a class="resturant-card dashboard--card card--bg-2" href="<?php echo e(route('vendor.order.list',['cooking'])); ?>">
        <?php ($store_data=\App\CentralLogics\Helpers::get_store_data()); ?>
       <h4 class="title"><?php echo e($data['cooking']); ?></h4>
        <?php if($store_data->module->module_type == 'food'): ?>
       <span class="subtitle"><?php echo e(translate('messages.cooking')); ?></span>
        <?php else: ?>
       <span class="subtitle"><?php echo e(translate('messages.processing')); ?></span>
        <?php endif; ?>
       <img src="<?php echo e(asset('public/assets/admin/img/dashboard/2.png')); ?>" alt="img" class="resturant-icon">
    </a>
    <!-- End Card -->
</div>

<div class="col-sm-6 col-lg-3">
    <!-- Card -->
    <a class="resturant-card dashboard--card card--bg-3" href="<?php echo e(route('vendor.order.list',['ready_for_delivery'])); ?>">
       <h4 class="title"><?php echo e($data['ready_for_delivery']); ?></h4>
       <span class="subtitle"><?php echo e(translate('messages.ready_for_delivery')); ?></span>
       <img src="<?php echo e(asset('public/assets/admin/img/dashboard/3.png')); ?>" alt="img" class="resturant-icon">
    </a>
    <!-- End Card -->
</div>

<div class="col-sm-6 col-lg-3">
    <!-- Card -->
    <a class="resturant-card dashboard--card card--bg-4" href="<?php echo e(route('vendor.order.list',['item_on_the_way'])); ?>">
       <h4 class="title"><?php echo e($data['item_on_the_way']); ?></h4>
       <span class="subtitle"><?php echo e(translate('messages.item_on_the_way')); ?></span>
       <img src="<?php echo e(asset('public/assets/admin/img/dashboard/4.png')); ?>" alt="img" class="resturant-icon">
    </a>
    <!-- End Card -->
</div>


<div class="col-12">
    <div class="row g-2">
        <div class="col-sm-6 col-lg-3">
            <a class="order--card h-100" href="<?php echo e(route('vendor.order.list',['delivered'])); ?>">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                        <img src="<?php echo e(asset('/public/assets/admin/img/dashboard/statistics/1.png')); ?>" alt="dashboard" class="oder--card-icon">
                        <span><?php echo e(translate('messages.delivered')); ?></span>
                    </h6>
                    <span class="card-title text-success">
                        <?php echo e($data['delivered']); ?>

                    </span>
                </div>
            </a>
        </div>

        <div class="col-sm-6 col-lg-3">
            <a class="order--card h-100" href="<?php echo e(route('vendor.order.list',['refunded'])); ?>">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                        <img src="<?php echo e(asset('/public/assets/admin/img/dashboard/statistics/2.png')); ?>" alt="dashboard" class="oder--card-icon">
                        <span><?php echo e(translate('messages.refunded')); ?></span>
                    </h6>
                    <span class="card-title text-danger">
                        <?php echo e($data['refunded']); ?>

                    </span>
                </div>
            </a>
        </div>

        <div class="col-sm-6 col-lg-3">
            <a class="order--card h-100" href="<?php echo e(route('vendor.order.list',['scheduled'])); ?>">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                        <img src="<?php echo e(asset('/public/assets/admin/img/dashboard/statistics/3.png')); ?>" alt="dashboard" class="oder--card-icon">
                        <span><?php echo e(translate('messages.scheduled')); ?></span>
                    </h6>
                    <span class="card-title text-primary">
                        <?php echo e($data['scheduled']); ?>

                    </span>
                </div>
            </a>
        </div>

        <div class="col-sm-6 col-lg-3">
            <a class="order--card h-100" href="<?php echo e(route('vendor.order.list',['all'])); ?>">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                        <img src="<?php echo e(asset('/public/assets/admin/img/dashboard/statistics/4.png')); ?>" alt="dashboard" class="oder--card-icon">
                        <span><?php echo e(translate('messages.all')); ?></span>
                    </h6>
                    <span class="card-title text-info">
                        <?php echo e($data['all']); ?>

                    </span>
                </div>
            </a>
        </div>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/partials/_dashboard-order-stats.blade.php ENDPATH**/ ?>