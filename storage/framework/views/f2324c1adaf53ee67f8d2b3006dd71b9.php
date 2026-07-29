
    <div class="col-sm-6 col-lg-3">
        <div class="__dashboard-card-2">
            <img src="<?php echo e(asset('/public/assets/admin/img/dashboard/food/items.svg')); ?>" alt="dashboard/grocery">
            <h6 class="name"><?php echo e(translate('messages.foods')); ?></h6>
            <h3 class="count"><?php echo e($data['total_items']); ?></h3>
            <div class="subtxt"><?php echo e($data['new_items']); ?> <?php echo e(translate('newly added')); ?></div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="__dashboard-card-2">
            <img src="<?php echo e(asset('/public/assets/admin/img/dashboard/food/orders.svg')); ?>" alt="dashboard/grocery">
            <h6 class="name"><?php echo e(translate('messages.orders')); ?></h6>
            <h3 class="count"><?php echo e($data['total_orders']); ?></h3>
            <div class="subtxt"><?php echo e($data['new_orders']); ?> <?php echo e(translate('newly added')); ?></div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="__dashboard-card-2">
            <img src="<?php echo e(asset('/public/assets/admin/img/dashboard/food/stores.svg')); ?>" alt="dashboard/grocery">
            <h6 class="name"><?php echo e(translate('messages.restaurants')); ?></h6>
            <h3 class="count"><?php echo e($data['total_stores']); ?></h3>
            <div class="subtxt"><?php echo e($data['new_stores']); ?> <?php echo e(translate('newly added')); ?></div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="__dashboard-card-2">
            <img src="<?php echo e(asset('/public/assets/admin/img/dashboard/food/customers.svg')); ?>" alt="dashboard/grocery">
            <h6 class="name"><?php echo e(translate('messages.customers')); ?></h6>
            <h3 class="count"><?php echo e($data['total_customers']); ?></h3>
            <div class="subtxt"><?php echo e($data['new_customers']); ?> <?php echo e(translate('newly added')); ?></div>
        </div>
    </div>
    <div class="col-12">
        <div class="row g-2">
            <div class="col-sm-6 col-lg-3">
                <a class="order--card h-100" href="<?php echo e(route('admin.order.list',['searching_for_deliverymen'])); ?>">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                            <img src="<?php echo e(asset('/public/assets/admin/img/dashboard/grocery/unassigned.svg')); ?>" alt="dashboard" class="oder--card-icon">
                            <span><?php echo e(translate('messages.unassigned_orders')); ?></span>
                        </h6>
                        <span class="card-title text-3F8CE8">
                            <?php echo e($data['searching_for_dm']); ?>

                        </span>
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-lg-3">
                <a class="order--card h-100" href="<?php echo e(route('admin.order.list',['accepted'])); ?>">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                            <img src="<?php echo e(asset('/public/assets/admin/img/dashboard/grocery/accepted.svg')); ?>" alt="dashboard" class="oder--card-icon">
                            <span><?php echo e(translate('Accepted by Delivery Man')); ?></span>
                        </h6>
                        <span class="card-title text-success">
                            <?php echo e($data['accepted_by_dm']); ?>

                        </span>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3">
                <a class="order--card h-100" href="<?php echo e(route('admin.order.list',['processing'])); ?>">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                            <img src="<?php echo e(asset('/public/assets/admin/img/dashboard/grocery/packaging.svg')); ?>" alt="dashboard" class="oder--card-icon">
                            <span><?php echo e(translate('Cooking')); ?></span>
                        </h6>
                        <span class="card-title text-FFA800">
                            <?php echo e($data['preparing_in_rs']); ?>

                        </span>
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-lg-3">
                <a class="order--card h-100" href="<?php echo e(route('admin.order.list',['item_on_the_way'])); ?>">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                            <img src="<?php echo e(asset('/public/assets/admin/img/dashboard/grocery/out-for.svg')); ?>" alt="dashboard" class="oder--card-icon">
                            <span><?php echo e(translate('Out for Delivery')); ?></span>
                        </h6>
                        <span class="card-title text-success">
                            <?php echo e($data['picked_up']); ?>

                        </span>
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-lg-3">
                <a class="order--card h-100" href="<?php echo e(route('admin.order.list',['delivered'])); ?>">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                            <img src="<?php echo e(asset('/public/assets/admin/img/dashboard/grocery/delivered.svg')); ?>" alt="dashboard" class="oder--card-icon">
                            <span><?php echo e(translate('messages.delivered')); ?></span>
                        </h6>
                        <span class="card-title text-success">
                            <?php echo e($data['delivered']); ?>

                        </span>
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-lg-3">
                <a class="order--card h-100" href="<?php echo e(route('admin.order.list',['canceled'])); ?>">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                            <img src="<?php echo e(asset('/public/assets/admin/img/order-status/canceled.svg')); ?>" alt="dashboard" class="oder--card-icon">
                            <span><?php echo e(translate('messages.canceled')); ?></span>
                        </h6>
                        <span class="card-title text-danger">
                            <?php echo e($data['canceled']); ?>

                        </span>
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-lg-3">
                <a class="order--card h-100" href="<?php echo e(route('admin.order.list',['refunded'])); ?>">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                            <img src="<?php echo e(asset('/public/assets/admin/img/order-status/refunded.svg')); ?>" alt="dashboard" class="oder--card-icon">
                            <span><?php echo e(translate('messages.refunded')); ?></span>
                        </h6>
                        <span class="card-title text-danger">
                            <?php echo e($data['refunded']); ?>

                        </span>
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-lg-3">
                <a class="order--card h-100" href="<?php echo e(route('admin.order.list',['failed'])); ?>">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                            <img src="<?php echo e(asset('/public/assets/admin/img/order-status/payment-failed.svg')); ?>" alt="dashboard" class="oder--card-icon">
                            <span><?php echo e(translate('messages.payment_failed')); ?></span>
                        </h6>
                        <span class="card-title text-danger">
                            <?php echo e($data['refund_requested']); ?>

                        </span>
                    </div>
                </a>
            </div>
        </div>
    </div>

<?php /**PATH /var/www/zaqoota/resources/views/admin-views/partials/_dashboard-order-stats-food.blade.php ENDPATH**/ ?>