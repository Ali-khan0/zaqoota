<?php $__env->startSection('title','Review List'); ?>


<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><?php echo e(translate('messages.deliveryman_reviews')); ?></h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-header">
                        <h5 class="card-header-title"></h5>
                    </div>
                    <!-- End Header -->

                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table id="columnSearchDatatable"
                               class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                               data-hs-datatables-options='{
                                 "order": [],
                                 "orderCellsTop": true,
                                 "paging": false
                               }'>
                            <thead class="thead-light">
                            <tr>
                                <th><?php echo e(translate('messages.#')); ?></th>
                                <th class="w-30p"><?php echo e(translate('messages.deliveryman')); ?></th>
                                <th class="w-25p"><?php echo e(translate('messages.customer')); ?></th>
                                <th><?php echo e(translate('messages.review')); ?></th>
                                <th><?php echo e(translate('messages.rating')); ?></th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(isset($review->delivery_man)): ?>
                                    <tr>
                                        <td><?php echo e($key+$reviews->firstItem()); ?></td>
                                        <td>
                                        <span class="d-block font-size-sm text-body">
                                            <a href="<?php echo e(route('vendor.delivery-man.preview',[$review['delivery_man_id']])); ?>">
                                                <?php echo e($review->delivery_man->f_name.' '.$review->delivery_man->l_name); ?>

                                            </a>
                                        </span>
                                        </td>
                                        <td>
                                            <?php if($review->customer): ?>
                                            <a href="<?php echo e(route('vendor.customer.view',[$review->user_id])); ?>">
                                                <?php echo e($review->customer->f_name); ?> <?php echo e($review->customer?->l_name); ?>

                                            </a>
                                            <?php else: ?>
                                                <?php echo e(translate('messages.customer_not_found')); ?>

                                            <?php endif; ?>

                                        </td>
                                        <td>
                                            <?php echo e($review->comment); ?>

                                        </td>
                                        <td>
                                            <label class="badge badge-soft-info">
                                                <?php echo e($review->rating); ?> <i class="tio-star"></i>
                                            </label>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <hr>
                        <table>
                            <tfoot>
                            <?php echo $reviews->links(); ?>

                            </tfoot>
                        </table>
                    </div>
                    <?php if(count($reviews) === 0): ?>
                        <div class="empty--data">
                            <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                            <h5>
                                <?php echo e(translate('no_data_found')); ?>

                            </h5>
                        </div>
                    <?php endif; ?>
                    <!-- End Table -->
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/delivery-man/reviews-list.blade.php ENDPATH**/ ?>