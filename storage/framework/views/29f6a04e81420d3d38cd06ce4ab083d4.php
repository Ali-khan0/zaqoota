<?php $__env->startSection('title',translate('messages.Delivery Man Preview')); ?>


<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title text-break">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/delivery-man.png')); ?>" class="w--26" alt="">
                </span>
                <span><?php echo e($deliveryMan['f_name'].' '.$deliveryMan['l_name']); ?></span>
            </h1>
            <div class="">
                <?php echo $__env->make('admin-views.delivery-man.partials._tab_menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
        <!-- End Page Header -->

        <div class="card">
            <div class="card-body">
                <div class="row gy-3">
                    <div class="col-sm-6 col-xl-3">
                        <div class="color-card flex-column align-items-center justify-content-center color-2">
                            <div class="img-box">
                                <img class="resturant-icon w--30" src="<?php echo e(asset('/public/assets/admin/img/icons/order-icon-1.png')); ?>" alt="transactions">
                            </div>

                            <div class="d-flex flex-column align-items-center">
                                <h2 class="title"> <?php echo e($deliveryMan->orders->count()); ?> </h2>
                                <div class="subtitle">
                                    <?php echo e(translate('messages.total_order')); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="color-card flex-column align-items-center justify-content-center color-5">
                            <div class="img-box">
                                <img class="resturant-icon w--30" src="<?php echo e(asset('/public/assets/admin/img/icons/order-icon-2.png')); ?>" alt="transactions">
                            </div>
                            <div class="d-flex flex-column align-items-center">
                                <h2 class="title"> <?php echo e(\App\CentralLogics\Helpers::format_currency($deliveryMan->total_ongoing_orders->sum('order_amount'))); ?> </h2>
                                <div class="subtitle">
                                    <?php echo e(translate('messages.ongoing_order')); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="color-card flex-column align-items-center justify-content-center color-7">
                            <div class="img-box">
                                <img class="resturant-icon w--30" src="<?php echo e(asset('/public/assets/admin/img/icons/order-icon-3.png')); ?>" alt="transactions">
                            </div>
                            <div class="d-flex flex-column align-items-center">
                                <h2 class="title">
                            <?php echo e(\App\CentralLogics\Helpers::format_currency($deliveryMan->total_delivered_orders->sum('order_amount'))); ?>


                                </h2>
                                <div class="subtitle">
                                    <?php echo e(translate('messages.completed_order')); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="color-card flex-column align-items-center justify-content-center color-4">
                            <div class="img-box">
                                <img class="resturant-icon w--30" src="<?php echo e(asset('/public/assets/admin/img/icons/order-icon-4.png')); ?>" alt="transactions">
                            </div>
                            <div class="d-flex flex-column align-items-center">
                                <h2 class="title"> <?php echo e($deliveryMan->total_canceled_orders->count()); ?> </h2>
                                <div class="subtitle">
                                    <?php echo e(translate('messages.cancel_order')); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3 mb-lg-5 mt-2">
            <div class="card-header py-2 border-0 gap-2">
                <div class="search--button-wrapper">
                    <h4 class="card-title"><?php echo e(translate('messages.order_list')); ?>

                        <span class="badge badge-soft-dark ml-2" id="itemCount">
                            <?php echo e($order_lists->total()); ?>

                        </span>
                    </h4>
                </div>
            </div>
            <!-- Body -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="datatable"
                        class="table table-borderless table-thead-bordered table-nowrap justify-content-between table-align-middle card-table">
                        <thead class="thead-light">
                            <tr>
                                <th class="border-0"><?php echo e(translate('SL')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.order_id')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.contact_info')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.total_items')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.total_amount')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.delivery_date')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $order_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td scope="row"><?php echo e($key+$order_lists->firstItem()); ?></td>
                                <td><a href="<?php echo e(route((isset($order->order) && $order->order_type=='parcel')?'admin.parcel.order.details':'admin.order.details',[$order->id,'module_id'=>$order->transaction?->module_id])); ?>"><?php echo e($order->id); ?></a></td>
                            <td>


                                <?php if($order->is_guest): ?>
                                <?php ($customer_details = json_decode($order['delivery_address'],true)); ?>
                                <strong title="<?php echo e($customer_details['contact_person_name']); ?>" ><?php echo e($customer_details['contact_person_name']); ?></strong>
                                <div><?php echo e($customer_details['contact_person_number']); ?></div>
                                <?php elseif($order->customer): ?>

                                <a class="text-body" title="<?php echo e($order->customer['f_name'].' '.$order->customer['l_name']); ?>" href="<?php echo e(route('admin.customer.view',[$order['user_id']])); ?>">
                                    <strong> <div> <?php echo e($order->customer['f_name'].' '.$order->customer['l_name']); ?></div></strong>
                                </a>
                                <a href="tel:<?php echo e($order->customer['phone']); ?>">
                                    <div><?php echo e($order->customer['phone']); ?></div>
                                </a>
                                <?php else: ?>
                                    <label class="badge badge-danger"><?php echo e(translate('messages.invalid_customer_data')); ?></label>
                                <?php endif; ?>
                                </td>
                                <td><?php echo e($order?->details()?->count()); ?></td>
                                <td>
                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($order['order_amount'])); ?>

                                </td>
                                <td><div>
                                    <?php echo e(\App\CentralLogics\Helpers::date_format($order->created_at)); ?>

                                </div>
                                <div class="d-block text-uppercase">
                                    <?php echo e(\App\CentralLogics\Helpers::time_format($order->created_at)); ?>

                                </div></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                    </table>
                    <?php if(count($order_lists) !== 0): ?>
                <hr>
                <?php endif; ?>
                <div class="page-area">
                    <?php echo $order_lists->links(); ?>

                </div>
                <?php if(count($order_lists) === 0): ?>
                <div class="empty--data">
                    <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                    <h5>
                        <?php echo e(translate('no_data_found')); ?>

                    </h5>
                </div>
                <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/delivery-man/view/order_list.blade.php ENDPATH**/ ?>