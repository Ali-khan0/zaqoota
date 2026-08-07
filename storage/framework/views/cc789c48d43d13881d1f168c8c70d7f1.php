<div class="row g-4" id="order_stats">
    <div class="col-lg-3">
        <a class="__card-1 bg-E6F6EE h-100" href="<?php echo e(route('admin.rental.trip.list')); ?>?status=all">
            <img src="<?php echo e(asset('public/assets/admin/img/rental/1.png')); ?>"class="icon"
                 alt="report/new">
            <h3 class="title text-success"><?php echo e($totalCount); ?></h3>
            <h6 class="subtitle font-regular"><?php echo e(translate('messages.total_trip')); ?></h6>
        </a>
    </div>
    <div class="col-lg-9">
        <div class="row g-2">
            <div class="col-sm-6">
                <!-- Card -->
                <a class="resturant-card dashboard--card __dashboard-card card--bg-1" href="<?php echo e(route('admin.rental.trip.list')); ?>?status=pending">
                        <span class="meter">
                            <span style="height:<?php echo e($totalCount > 0 ? ($pendingCount / $totalCount) * 100 : 0); ?>%"></span>
                        </span>
                    <h4 class="title"><?php echo e($pendingCount); ?></h4>
                    <span class="subtitle font-regular"><?php echo e(translate('messages.pending_trip')); ?></span>
                    <img src="<?php echo e(asset('public/assets/admin/img/rental/5.png')); ?>" alt="img"
                         class="resturant-icon top-50px">
                </a>
                <!-- End Card -->
            </div>
            <div class="col-sm-6">
                <!-- Card -->
                <a class="resturant-card dashboard--card __dashboard-card card--bg-2" href="<?php echo e(route('admin.rental.trip.list')); ?>?status=ongoing">
                        <span class="meter">
                            <span style="height:<?php echo e($totalCount > 0 ? ($ongoingCount / $totalCount) * 100 : 0); ?>%"></span>
                        </span>
                    <h4 class="title"><?php echo e($ongoingCount); ?></h4>
                    <span class="subtitle font-regular"> <?php echo e(translate('messages.Ongoing_Trip')); ?>

                        </span>
                    <img src="<?php echo e(asset('public/assets/admin/img/rental/2.png')); ?>" alt="img"
                         class="resturant-icon top-50px">
                </a>
                <!-- End Card -->
            </div>
            <div class="col-sm-6">
                <!-- Card -->
                <a class="resturant-card dashboard--card __dashboard-card bg-F1E8FA" href="<?php echo e(route('admin.rental.trip.list')); ?>?status=completed">
                        <span class="meter">
                            <span style="height:<?php echo e($totalCount > 0 ? ($completedCount / $totalCount) * 100 : 0); ?>%"></span>
                        </span>
                    <h4 class="title text-success"><?php echo e($completedCount); ?></h4>
                    <span class="subtitle font-regular"> <?php echo e(translate('messages.Completed')); ?>

                        </span>
                    <img src="<?php echo e(asset('public/assets/admin/img/rental/3.png')); ?>" alt="img"
                         class="resturant-icon top-50px">
                </a>
                <!-- End Card -->
            </div>
            <div class="col-sm-6">
                <!-- Card -->
                <a class="resturant-card dashboard--card __dashboard-card card--bg-4" href="<?php echo e(route('admin.rental.trip.list')); ?>?status=canceled">
                        <span class="meter">
                            <span style="height:<?php echo e($totalCount > 0 ? ($canceledCount / $totalCount) * 100 : 0); ?>%"></span>
                        </span>
                    <h4 class="title"><?php echo e($canceledCount); ?></h4>
                    <span class="subtitle font-regular"> <?php echo e(translate('messages.Canceled_Trip')); ?>

                        </span>
                    <img src="<?php echo e(asset('public/assets/admin/img/rental/4.png')); ?>" alt="img"
                         class="resturant-icon top-50px">
                </a>
                <!-- End Card -->
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/partials/delivery-statistics.blade.php ENDPATH**/ ?>