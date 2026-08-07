<?php $__env->startSection('title',translate('messages.deliverymen')); ?>


<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/deliveryman.png')); ?>" class="w--30" alt="">
                </span>
                <span>
                   <?php echo e(translate('messages.deliveryman')); ?><span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($delivery_men->total()); ?></span>
                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header justify-content-end">
                <form class="search-form" >
                    <div class="input-group input--group">
                        <input  type="search" name="search" class="form-control" value="<?php echo e(request()?->search ?? ''); ?>"
                                placeholder="<?php echo e(translate('messages.ex_search_name')); ?>" aria-label="<?php echo e(translate('messages.ex_search_name')); ?>" >
                        <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                    </div>
                    <!-- End Search -->
                </form>
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table id="columnSearchDatatable"
                        class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                        data-hs-datatables-options='{
                            "order": [],
                            "orderCellsTop": true,
                            "paging":false
                        }'>
                    <thead class="thead-light">
                    <tr>
                        <th class="border-0 text-capitalize"><?php echo e(translate('messages.#')); ?></th>
                        <th class="border-0 text-capitalize"><?php echo e(translate('messages.name')); ?></th>
                        <th class="border-0 text-capitalize"><?php echo e(translate('messages.availability_status')); ?></th>
                        <th class="border-0 text-capitalize"><?php echo e(translate('messages.phone')); ?></th>
                        <th class="border-0 text-capitalize text-center"><?php echo e(translate('messages.active_orders')); ?></th>
                        <th class="border-0 text-capitalize text-center"><?php echo e(translate('messages.action')); ?></th>
                    </tr>
                    </thead>

                    <tbody id="set-rows">
                    <?php $__currentLoopData = $delivery_men; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$dm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+$delivery_men->firstItem()); ?></td>
                            <td>
                                <a class="media align-items-center" href="<?php echo e(route('vendor.delivery-man.preview',[$dm['id']])); ?>">
                                    <img class="avatar avatar-lg mr-3 onerror-image"
                                         data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
                                         src="<?php echo e($dm['image_full_url']); ?>"
                                         alt="<?php echo e($dm['f_name']); ?> <?php echo e($dm['l_name']); ?>">
                                    <div class="media-body">
                                        <h5 class="text-hover-primary mb-0"><?php echo e($dm['f_name'].' '.$dm['l_name']); ?></h5>
                                        <span class="rating">
                                            <i class="tio-star"></i> <?php echo e(count($dm->rating)>0?number_format($dm->rating[0]->average, 1, '.', ' '):0); ?>

                                        </span>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <div>
                                    <?php echo e(translate('messages.currently_assigned_orders')); ?> : <?php echo e($dm->current_orders); ?>

                                </div>
                                <div>
                                    <?php echo e(translate('messages.active_status')); ?> :
                                    <?php if($dm->application_status == 'approved'): ?>
                                        <?php if($dm->active): ?>
                                        <strong class="text-capitalize text-success"><?php echo e(translate('messages.online')); ?></strong>
                                        <?php else: ?>
                                        <strong class="text-capitalize text-danger"><?php echo e(translate('messages.offline')); ?></strong>
                                        <?php endif; ?>
                                    <?php elseif($dm->application_status == 'denied'): ?>
                                        <strong class="text-capitalize text-danger"><?php echo e(translate('messages.denied')); ?></strong>
                                    <?php else: ?>
                                        <strong class="text-capitalize text-primary"><?php echo e(translate('messages.pending')); ?></strong>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <a class="deco-none" href="tel:<?php echo e($dm['phone']); ?>"><?php echo e($dm['phone']); ?></a>
                            </td>
                            <td class="text-center">
                                <?php echo e($dm->orders ? count($dm->orders):0); ?>

                            </td>
                            <td>
                                <div class="btn--container justify-content-center">
                                    <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route('vendor.delivery-man.edit',[$dm['id']])); ?>" title="<?php echo e(translate('messages.edit')); ?>"><i class="tio-edit"></i>
                                    </a>
                                    <a class="btn action-btn btn--danger btn-outline-danger form-alert"
                                       data-id="delivery-man-<?php echo e($dm['id']); ?>"
                                       data-message="<?php echo e(translate('Want_to_remove_this_deliveryman_?')); ?>"
                                       href="javascript:"  title="<?php echo e(translate('messages.delete')); ?>"><i class="tio-delete-outlined"></i>
                                    </a>
                                </div>
                                <form action="<?php echo e(route('vendor.delivery-man.delete',[$dm['id']])); ?>" method="post" id="delivery-man-<?php echo e($dm['id']); ?>">
                                    <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php if(count($delivery_men) !== 0): ?>
                <hr>
                <?php endif; ?>
                <div class="page-area">
                    <table>
                        <tfoot>
                        <?php echo $delivery_men->links(); ?>

                        </tfoot>
                    </table>
                </div>
                    <?php if(count($delivery_men) === 0): ?>
                    <div class="empty--data">
                        <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                        <h5>
                            <?php echo e(translate('no_data_found')); ?>

                        </h5>
                    </div>
                    <?php endif; ?>

            </div>
            <!-- End Table -->
        </div>
        <!-- End Card -->
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin/js/view-pages/datatable-search.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/delivery-man/list.blade.php ENDPATH**/ ?>