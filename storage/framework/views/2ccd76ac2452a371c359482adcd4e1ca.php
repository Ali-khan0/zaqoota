<?php use App\CentralLogics\Helpers;use App\Models\DeliveryMan; ?>


<?php $__env->startSection('title',translate('messages.Review List')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title text-break">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/delivery-man.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.deliveryman_reviews')); ?>

                    <span class="badge badge-soft-dark ml-2" id="itemCount">
                        <?php echo e($reviews->total()); ?>

                    </span>
                </span>
            </h1>
        </div>
        <!-- End Page Header -->

        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-header py-2 border-0">
                        <span class="card-header-title"></span>
                        <div class="search--button-wrapper justify-content-end">
                            <div class="col-sm-auto min--240">
                                <select name="deliveryman_id"
                                        class="form-control js-select2-custom set-filter theme-style"
                                        data-filter="deliveryman_id"
                                        data-url="<?php echo e(url()->full()); ?>">
                                    <option value="all"><?php echo e(translate('messages.All_DeliveryMan')); ?></option>
                                    <?php $__currentLoopData = DeliveryMan::oldest()->where('application_status' , 'approved')->get(['id','f_name','l_name' ]); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deliveryMan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option
                                            value="<?php echo e($deliveryMan->id); ?>" <?php echo e($deliveryMan->id == request()?->deliveryman_id ? 'selected':''); ?>>
                                            <?php echo e($deliveryMan->f_name.' '. $deliveryMan->l_name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-sm-auto min--240">
                                <select name="order_by"
                                        class="form-control js-select2-custom set-filter theme-style"
                                        data-filter="order_by"
                                        data-url="<?php echo e(url()->full()); ?>">
                                    <option><?php echo e(translate('messages.Latest_ratings')); ?></option>
                                    <option value="desc" <?php echo e(request()?->order_by == 'desc' ? 'selected' : ''); ?> ><?php echo e(translate('messages.Top_ratings')); ?></option>
                                    <option value="asc" <?php echo e(request()?->order_by == 'asc' ? 'selected' : ''); ?> ><?php echo e(translate('messages.Low_ratings')); ?></option>
                                </select>
                            </div>

                            <form class="search-form theme-style">
                                <div class="input-group input--group">
                                    <input id="datatableSearch" name="search" type="search" class="form-control"
                                           placeholder="<?php echo e(translate('ex_: search_delivery_man_,_email_or_phone')); ?>"
                                           value="<?php echo e(request()->get('search')); ?>"
                                           aria-label="<?php echo e(translate('messages.search_here')); ?>">
                                    <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                                </div>
                            </form>
                            <?php if(request()->get('search')): ?>
                                <button type="reset" class="btn btn--primary ml-2 location-reload-to-base"
                                        data-url="<?php echo e(url()->full()); ?>"><?php echo e(translate('messages.reset')); ?></button>
                            <?php endif; ?>

                            <!-- Unfold -->
                            <div class="hs-unfold mr-2">
                                <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle min-height-40"
                                   href="javascript:"
                                   data-hs-unfold-options='{
                                            "target": "#usersExportDropdown",
                                            "type": "css-animation"
                                        }'>
                                    <i class="tio-download-to mr-1"></i> <?php echo e(translate('messages.export')); ?>

                                </a>

                                <div id="usersExportDropdown"
                                     class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                                    <span class="dropdown-header"><?php echo e(translate('messages.download_options')); ?></span>
                                    <a id="export-excel" class="dropdown-item"
                                       href="<?php echo e(route('admin.users.delivery-man.reviews.export', ['type'=>'excel',request()->getQueryString()])); ?>">
                                        <img class="avatar avatar-xss avatar-4by3 mr-2"
                                             src="<?php echo e(asset('public/assets/admin/svg/components/excel.svg')); ?>"
                                             alt="Image Description">
                                        <?php echo e(translate('messages.excel')); ?>

                                    </a>
                                    <a id="export-csv" class="dropdown-item"
                                       href="<?php echo e(route('admin.users.delivery-man.reviews.export', ['type'=>'csv',request()->getQueryString()])); ?>">
                                        <img class="avatar avatar-xss avatar-4by3 mr-2"
                                             src="<?php echo e(asset('public/assets/admin/svg/components/placeholder-csv-format.svg')); ?>"
                                             alt="Image Description">
                                        .<?php echo e(translate('messages.csv')); ?>

                                    </a>
                                </div>
                            </div>
                            <!-- End Unfold -->
                        </div>
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
                                <th class="border-0"><?php echo e(translate('SL')); ?></th>
                                <th class="border-0"><?php echo e(translate('Order_ID')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.deliveryman')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.customer')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.rating')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.review')); ?></th>
                                <th class="border-0 text-center"><?php echo e(translate('messages.action')); ?></th>
                            </tr>
                            </thead>

                            <tbody id="set-rows">
                            <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr>
                                    <td><?php echo e($key+$reviews->firstItem()); ?></td>
                                    <td><a class="text-dark"
                                           href="<?php echo e(route((isset($review->order) && $review?->order?->order_type=='parcel')?'admin.parcel.order.details':'admin.order.details',[$review->order_id,'module_id'=>$review?->order?->module_id])); ?>"><?php echo e($review->order_id); ?></a>
                                    </td>
                                    <td>
                                        <span class="d-block font-size-sm text-body">
                                            <a href="<?php echo e(route('admin.users.delivery-man.preview',[$review['delivery_man_id']])); ?>"
                                               class="media gap-2 align-items-center text-dark">
                                                <img  src="<?php echo e($review->delivery_man->image_full_url); ?>"
                                                    class="rounded-circle object-cover" width="48" height="48"
                                                    alt="<?php echo e($review->delivery_man->f_name.' '.$review->delivery_man->l_name); ?>">
                                                <div class="meida-body">
                                                    <div
                                                        title="<?php echo e($review->delivery_man->f_name.' '.$review->delivery_man->l_name); ?>"><?php echo e($review->delivery_man->f_name.' '.$review->delivery_man->l_name); ?></div>
                                                    <div> <?php echo e($review?->delivery_man?->phone); ?> </div>
                                                </div>
                                            </a>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if($review->customer): ?>
                                            <a href="<?php echo e(route('admin.users.customer.view',[$review->user_id])); ?>"
                                               class="text-dark">
                                                <?php echo e($review->customer->f_name ?? ""); ?> <?php echo e($review->customer->l_name ?? ""); ?>

                                            </a>
                                        <?php else: ?>
                                            <div
                                                class="text-muted"><?php echo e(translate('messages.customer_not_found')); ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <label
                                                class="badge badge-soft-warning mb-0 d-flex align-items-center gap-1 justify-content-center">
                                                <span class="d-inline-block mt-3px"><?php echo e($review->rating); ?></span>
                                                <i class="tio-star"></i>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="cursor-pointer text-wrap max-349 min-w-100px max-text-2-line"
                                             data-toggle="tooltip" data-placement="top"
                                             title="<?php echo e($review->comment); ?>">
                                            <?php echo e($review->comment); ?>

                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a class="btn action-btn btn--warning btn-outline-warning view-details" href="#"
                                               title="View" data-order_id="<?php echo e($review->order_id); ?>"
                                               data-date="<?php echo e(Helpers::time_date_format($review->created_at)); ?>"
                                               data-name="<?php echo e($review?->delivery_man?->f_name.' '.$review?->delivery_man?->l_name); ?>"
                                               data-image="<?php echo e($review?->delivery_man?->image_full_url); ?>"
                                               data-phone="<?php echo e($review?->delivery_man?->phone); ?>"
                                               data-rating="<?php echo e($review->rating); ?>"
                                               data-comment="<?php echo e($review->comment); ?>" >
                                                <i class="tio-visible-outlined"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if(count($reviews) !== 0): ?>
                        <hr>
                    <?php endif; ?>
                    <div class="page-area">
                        <?php echo $reviews->links(); ?>

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

    <!-- Modal -->
    <div class="modal fade" id="deliverymanReviewModal" tabindex="-1" role="dialog"
         aria-labelledby="deliverymanReviewModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <div class="text-center d-flex flex-column align-items-center mb-3">
                        <h5><?php echo e(translate('Deliveryman_Review')); ?></h5>
                        <div class="fs-12 mb-1"><?php echo e(translate('Order#')); ?> <span id="order-id" class="font-semibold text-dark"></span></div>
                        <div id="date" class="text-muted fs-12"></div>
                    </div>

                    <div class="p-3 card rounded mb-3">
                        <div class="media gap-3">
                            <img width="100" height="100" class="rounded object-cover"
                                 src="" alt="image">
                            <div class="media-body">
                                <h5 id="name"></h5>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <i class="tio-android-phone"></i>
                                    <a href="tel:" id="phone" class="text-dark"></a>
                                </div>
                                <div class="d-flex">
                                    <label
                                        class="badge badge-soft-warning mb-0 d-flex align-items-center gap-1 justify-content-center">
                                        <span class="d-inline-block mt-3px" id="rating"></span>
                                        <i class="tio-star"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-3 card rounded">
                        <h5 class="text-warning"><?php echo e(translate('Review')); ?></h5>
                        <p id="comment"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script_2'); ?>
    <script>
        "use strict";
        $(document).on('click', '.view-details', function () {
            let data = $(this).data();
            $('#deliverymanReviewModal .modal-body #deliverymanReviewModalLabel').text('Deliveryman Review');
            $('#deliverymanReviewModal .modal-body #order-id').text(data.order_id);
            $('#deliverymanReviewModal .modal-body #date').text(data.date);
            $('#deliverymanReviewModal .modal-body img').attr('src', data.image);
            $('#deliverymanReviewModal .modal-body #name').text(data.name);
            $('#deliverymanReviewModal .modal-body #phone') .text(data.phone) .attr('href', 'tel:' + data.phone);
            $('#deliverymanReviewModal .modal-body #rating').text(data.rating);
            $('#deliverymanReviewModal .modal-body #comment').text(data.comment);
            $('#deliverymanReviewModal').modal('show');
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/delivery-man/reviews-list.blade.php ENDPATH**/ ?>