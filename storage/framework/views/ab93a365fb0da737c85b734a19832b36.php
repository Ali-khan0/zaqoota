<div class="row g-2" id="order_stats">
    <div class="col-sm-6 col-lg-3">
        <!-- Card -->
        <a class="resturant-card dashboard--card __dashboard-card card--bg-1" href="<?php echo e(route('vendor.trip.list', ['status'=>'confirmed'])); ?>">
            <h4 class="title"><?php echo e($confirmedCount); ?></h4>
            <span class="subtitle font-regular "><?php echo e(translate('messages.confirmed')); ?></span>
            <img src="<?php echo e(asset('public/assets/admin/img/rental/1.png')); ?>" alt="<?php echo e(translate('img')); ?>" class="resturant-icon top-50px">
        </a>
        <!-- End Card -->
    </div>

    <div class="col-sm-6 col-lg-3">
        <!-- Card -->
        <a class="resturant-card dashboard--card __dashboard-card card--bg-2" href="<?php echo e(route('vendor.trip.list', ['status'=>'ongoing'])); ?>">
            <h4 class="title"><?php echo e($ongoingCount); ?></h4>
            <span class="subtitle font-regular "><?php echo e(translate('messages.Ongoing_Trip')); ?></span>
            <img src="<?php echo e(asset('public/assets/admin/img/rental/2.png')); ?>" alt="<?php echo e(translate('img')); ?>" class="resturant-icon top-50px">
        </a>
        <!-- End Card -->
    </div>

    <div class="col-sm-6 col-lg-3">
        <!-- Card -->
        <a class="resturant-card dashboard--card __dashboard-card card--bg-3"
            href="<?php echo e(route('vendor.trip.list', ['status'=>'completed'])); ?>">
            <h4 class="title"><?php echo e($completedCount); ?></h4>
            <span class="subtitle font-regular "><?php echo e(translate('messages.completed')); ?></span>
            <img src="<?php echo e(asset('public/assets/admin/img/rental/3.png')); ?>" alt="<?php echo e(translate('img')); ?>" class="resturant-icon top-50px">
        </a>
        <!-- End Card -->
    </div>

    <div class="col-sm-6 col-lg-3">
        <!-- Card -->
        <a class="resturant-card dashboard--card __dashboard-card card--bg-4"
            href="<?php echo e(route('vendor.trip.list',['status'=>'canceled'])); ?>">
            <h4 class="title"><?php echo e($canceledCount); ?></h4>
            <span class="subtitle font-regular "><?php echo e(translate('messages.canceled')); ?></span>
            <img src="<?php echo e(asset('public/assets/admin/img/rental/4.png')); ?>" alt="<?php echo e(translate('img')); ?>" class="resturant-icon top-50px">
        </a>
        <!-- End Card -->
    </div>


    <div class="col-12">
        <div class="row g-2">
            <div class="col-sm-6 col-lg-3">
                <a class="order--card badge--accepted h-100" href="<?php echo e(route('vendor.trip.list', ['status'=>'all'])); ?>">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                            <span><?php echo e(translate('messages.All')); ?></span>
                        </h6>
                        <span class="card-title text-success">
                            <?php echo e($totalCount); ?>

                        </span>
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-lg-3">
                <a class="order--card badge--accepted h-100" href="<?php echo e(route('vendor.trip.list',  ['status'=>'pending'])); ?>">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                            <span><?php echo e(translate('messages.pending')); ?></span>
                        </h6>
                        <span class="card-title text-danger">
                            <?php echo e($pendingCount); ?>

                        </span>
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-lg-3">
                <a class="order--card badge--accepted h-100" href="<?php echo e(route('vendor.trip.list', ['status'=>'scheduled'])); ?>">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                            <span><?php echo e(translate('messages.scheduled')); ?></span>
                        </h6>
                        <span class="card-title text-primary">
                            <?php echo e($scheduledCount); ?>

                        </span>
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-lg-3">
                <a class="order--card badge--accepted h-100" href="<?php echo e(route('vendor.trip.list',  ['status'=>'instant'])); ?>">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                            <span><?php echo e(translate('Instant_Booking')); ?></span>
                        </h6>
                        <span class="card-title text-info">
                            <?php echo e($instantCount); ?>

                        </span>
                    </div>
                </a>
            </div>
        </div>
    </div>

</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/provider/dashboard/_delivery-statistics.blade.php ENDPATH**/ ?>