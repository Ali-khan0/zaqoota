<?php $__env->startSection('title',translate('vehicle_view')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-12">
                    <h1 class="page-header-title text-capitalize">
                        <div class="card-header-icon d-inline-flex mr-2 img">
                            <img src="<?php echo e(asset('/public/assets/admin/img/delivery-man.png')); ?>" alt="public">
                        </div>
                        <span>
                            <?php echo e(translate('vehicle_type')); ?>: <?php echo e($vehicle->type); ?>

                        </span>
                    </h1>
                </div>
            </div>
        </div>


        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-header py-2">
                        <div class="search--button-wrapper">
                            <h5 class="card-title"><?php echo e(translate('messages.deliveryman')); ?><span
                                    class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($deliveryMen->total()); ?></span>
                            </h5>
                        </div>
                    </div>
                    <!-- End Header -->

                    <!-- Table -->
                    <div class="table-responsive datatable-custom fz--14px">
                        <table id="columnSearchDatatable"
                            class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                            data-hs-datatables-options='{
                                 "order": [],
                                 "orderCellsTop": true,
                                 "paging":false
                               }'>
                            <thead class="thead-light">
                                <th class="text-capitalize"><?php echo e(translate('messages.sl')); ?></th>
                                <th class="text-capitalize w-20p"><?php echo e(translate('messages.name')); ?></th>
                                <th class="text-capitalize"><?php echo e(translate('messages.contact')); ?></th>
                                
                                <th class="text-capitalize text-center"><?php echo e(translate('Total Orders')); ?></th>
                                <th class="text-capitalize"><?php echo e(translate('messages.availability_status')); ?></th>
                                <th class="text-capitalize text-center w-110px"><?php echo e(translate('messages.action')); ?></th>
                            </thead>

                            <tbody id="set-rows">
                                <?php $__currentLoopData = $deliveryMen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$dm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key+$deliveryMen->firstItem()); ?></td>
                                        <td>
                                            <a class="table-rest-info" href="<?php echo e(route('admin.users.delivery-man.preview',[$dm['id']])); ?>">
                                                <img class="onerror-image" data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
                                                src="<?php echo e($dm['image_full_url']); ?>"
                                                alt="<?php echo e($dm['f_name']); ?> <?php echo e($dm['l_name']); ?>">
                                                <div class="info">
                                                    <h5 class="text-hover-primary mb-0"><?php echo e($dm['f_name'].' '.$dm['l_name']); ?></h5>
                                                    <span class="d-block text-body">
                                                        <!-- Rating -->
                                                        <span class="rating">
                                                            <i class="tio-star"></i> <?php echo e(count($dm->rating)>0?number_format($dm->rating[0]->average, 1, '.', ' '):0); ?>

                                                        </span>
                                                        <!-- Rating -->
                                                    </span>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="deco-none" href="tel:<?php echo e($dm['phone']); ?>"><?php echo e($dm['phone']); ?></a>
                                        </td>

                                        <!-- Static Data -->
                                        <td class="text-center">
                                            <div class="pr-3">
                                                <?php echo e($dm->orders ? count($dm->orders):0); ?>

                                            </div>
                                        </td>
                                        <!-- Static Data -->
                                        <td>
                                            <div>
                                                <!-- Status -->
                                                <?php echo e(translate('Currenty Assigned Orders')); ?> : <?php echo e($dm->current_orders); ?>

                                                <!-- Status -->
                                            </div>
                                            <?php if($dm->application_status == 'approved'): ?>
                                                <?php if($dm->active): ?>
                                                <div>
                                                    <?php echo e(translate('Active Status')); ?> : <strong class="text-primary text-capitalize"><?php echo e(translate('messages.online')); ?></strong>
                                                </div>
                                                <?php else: ?>
                                                <div>
                                                    <?php echo e(translate('Active Status')); ?> : <strong class="text-secondary text-capitalize"><?php echo e(translate('messages.offline')); ?></strong>
                                                </div>
                                                <?php endif; ?>
                                            <?php elseif($dm->application_status == 'denied'): ?>
                                                <div>
                                                    <?php echo e(translate('Active Status')); ?> : <strong class="text-danger text-capitalize"><?php echo e(translate('messages.denied')); ?></strong>
                                                </div>
                                            <?php else: ?>
                                                <div>
                                                    <?php echo e(translate('Active Status')); ?> : <strong class="text-info text-capitalize"><?php echo e(translate('messages.not_approved')); ?></strong>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn--container justify-content-center">
                                                <a class="btn btn-sm btn--primary btn-outline-primary action-btn" href="<?php echo e(route('admin.users.delivery-man.edit',[$dm['id']])); ?>" title="<?php echo e(translate('messages.edit')); ?>"><i class="tio-edit"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                        <?php if(count($deliveryMen) === 0): ?>
                            <div class="empty--data">
                                <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                                <h5>
                                    <?php echo e(translate('no_data_found')); ?>

                                </h5>
                            </div>
                        <?php endif; ?>
                        <div class="page-area px-4 pb-3">
                            <div class="d-flex align-items-center justify-content-end">
                                <div>
                                    <?php echo $deliveryMen->appends(request()->all())->links(); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Table -->
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>







<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script>
        "use strict";

        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            let datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

            $('#column1_search').on('keyup', function () {
                datatable
                    .columns(1)
                    .search(this.value)
                    .draw();
            });

            $('#column2_search').on('keyup', function () {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });

            $('#column3_search').on('keyup', function () {
                datatable
                    .columns(3)
                    .search(this.value)
                    .draw();
            });

            $('#column4_search').on('keyup', function () {
                datatable
                    .columns(4)
                    .search(this.value)
                    .draw();
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                let select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/dm-vehicle/view.blade.php ENDPATH**/ ?>