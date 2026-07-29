<?php $__env->startSection('title',$store->name."'s ".translate('messages.orders')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <!-- Custom styles for this page -->
    <link href="<?php echo e(asset('public/assets/admin/css/croppie.css')); ?>" rel="stylesheet">

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <?php echo $__env->make('admin-views.vendor.view.partials._header',['store'=>$store], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!-- Page Heading -->
    <div class="tab-content">
        <div class="tab-pane fade show active" id="order">
            <div class="row pt-2">
                <div class="col-md-12">
                    <div class="resturant-card-navbar">

                        <div class="order-info-item filter-on-click" data-type='all_orders' data-filter="filter" data-url="<?php echo e(route('admin.store.view', ['store'=>$store->id, 'tab'=> 'order'])); ?>">
                            <div class="order-info-icon">
                                <img src="<?php echo e(asset('public/assets/admin/img/navbar/all.png')); ?>" alt="public">
                            </div>
                            <h6 class="card-subtitle"><?php echo e(translate('messages.all')); ?><span class="amount text--primary"><?php echo e(\App\Models\Order::where('store_id', $store->id)->StoreOrder()->count()); ?></span></h6>
                        </div>
                        <span class="order-info-seperator"></span>
                        <div class="order-info-item filter-on-click"  data-filter="filter"  data-type="scheduled_orders" data-url="<?php echo e(route('admin.store.view', ['store'=>$store->id, 'tab'=> 'order'])); ?>"  >
                            <div class="order-info-icon">
                                <img src="<?php echo e(asset('public/assets/admin/img/navbar/schedule.png')); ?>" alt="public">
                            </div>
                            <h6 class="card-subtitle"><?php echo e(translate('messages.scheduled')); ?><span class="amount text--warning"><?php echo e(\App\Models\Order::Scheduled()->where('store_id', $store->id)->StoreOrder()->count()); ?></span></h6>
                        </div>
                        <span class="order-info-seperator"></span>
                        <div class="order-info-item filter-on-click"   data-filter="filter"  data-type="pending_orders" data-url="<?php echo e(route('admin.store.view', ['store'=>$store->id, 'tab'=> 'order'])); ?>" >
                            <div class="order-info-icon">
                                <img src="<?php echo e(asset('public/assets/admin/img/navbar/pending.png')); ?>" alt="public">
                            </div>
                            <h6 class="card-subtitle"><?php echo e(translate('messages.pending')); ?><span class="amount text--info"><?php echo e(\App\Models\Order::where(['order_status'=>'pending','store_id'=>$store->id])->StoreOrder()->OrderScheduledIn(30)->count()); ?></span></h6>
                        </div>
                        <span class="order-info-seperator"></span>
                        <div class="order-info-item filter-on-click"  data-filter="filter"  data-type="delivered_orders" data-url="<?php echo e(route('admin.store.view', ['store'=>$store->id, 'tab'=> 'order'])); ?>" >
                            <div class="order-info-icon">
                                <img src="<?php echo e(asset('public/assets/admin/img/navbar/delivered.png')); ?>" alt="public">
                            </div>
                            <h6 class="card-subtitle"><?php echo e(translate('messages.delivered')); ?><span class="amount text--success"><?php echo e(\App\Models\Order::where(['order_status'=>'delivered', 'store_id'=>$store->id])->StoreOrder()->count()); ?></span></h6>
                        </div>
                        <span class="order-info-seperator"></span>
                        <div class="order-info-item filter-on-click"  data-filter="filter"  data-type="canceled_orders" data-url="<?php echo e(route('admin.store.view', ['store'=>$store->id, 'tab'=> 'order'])); ?>" >
                            <div class="order-info-icon">
                                <img src="<?php echo e(asset('public/assets/admin/img/navbar/cancel.png')); ?>" alt="public">
                            </div>
                            <h6 class="card-subtitle"><?php echo e(translate('messages.canceled')); ?><span class="amount text--success"><?php echo e(\App\Models\Order::where(['order_status'=>'canceled', 'store_id'=>$store->id])->StoreOrder()->count()); ?></span></h6>
                        </div>

                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card w-100">

                    <div class="card-header py-2 border-0">
                        <div class="search--button-wrapper">
                            <h5 class="card-title">
                            </h5>
                            <form class="search-form">
                                <!-- Search -->

                                <div class="input-group input--group">
                                    <input id="datatableSearch_" type="search" value="<?php echo e(request()->search ?? null); ?>" name="search" class="form-control"
                                            placeholder="<?php echo e(translate('ex_:_order_id')); ?>" aria-label="Search">
                                    <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                                </div>
                                <!-- End Search -->
                            </form>
                            <?php if(request()->get('search')): ?>
                            <button type="reset" class="btn btn--primary ml-2 location-reload-to-base" data-url="<?php echo e(url()->full()); ?>"><?php echo e(translate('messages.reset')); ?></button>
                            <?php endif; ?>
                            <!-- Unfold -->
                            <div class="hs-unfold mr-2">
                                <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle min-height-40" href="javascript:;"
                                    data-hs-unfold-options='{
                                            "target": "#usersExportDropdown",
                                            "type": "css-animation"
                                        }'>
                                    <i class="tio-download-to mr-1"></i> <?php echo e(translate('messages.export')); ?>

                                </a>

                                <div id="usersExportDropdown"
                                    class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">

                                    <span class="dropdown-header"><?php echo e(translate('messages.download_options')); ?></span>
                                    <a id="export-excel" class="dropdown-item" href="<?php echo e(route('admin.order.store-export', ['type'=>'excel', 'store_id'=>$store->id , request()->getQueryString()])); ?>">
                                        <img class="avatar avatar-xss avatar-4by3 mr-2"
                                            src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                            alt="Image Description">
                                        <?php echo e(translate('messages.excel')); ?>

                                    </a>
                                    <a id="export-csv" class="dropdown-item" href="<?php echo e(route('admin.order.store-export', ['type'=>'csv', 'store_id'=>$store->id , request()->getQueryString() ])); ?>">
                                        <img class="avatar avatar-xss avatar-4by3 mr-2"
                                            src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                            alt="Image Description">
                                        .<?php echo e(translate('messages.csv')); ?>

                                    </a>

                                </div>
                            </div>
                            <!-- End Unfold -->
                        </div>
                    </div>
                        <div class="card-body p-0">
                            <!-- Table -->
                            <div class="table-responsive datatable-custom">
                                <table id="datatable"
                                    class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                    data-hs-datatables-options='{
                                    "columnDefs": [{
                                        "targets": [0],
                                        "orderable": false
                                    }],
                                    "order": [],
                                    "info": {
                                    "totalQty": "#datatableWithPaginationInfoTotalQty"
                                    },
                                    "search": "#datatableSearch",
                                    "entries": "#datatableEntries",
                                    "pageLength": 25,
                                    "isResponsive": false,
                                    "isShowPaging": false,
                                    "pagination": "datatablePagination"
                                }'>
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="border-0">
                                            <?php echo e(translate('sl')); ?>

                                        </th>
                                        <th class="table-column-pl-0 border-0"><?php echo e(translate('messages.order')); ?></th>
                                        <th class="border-0"><?php echo e(translate('messages.date')); ?></th>
                                        <th class="border-0"><?php echo e(translate('messages.customer')); ?></th>
                                        <th class="border-0"><?php echo e(translate('messages.payment_status')); ?></th>
                                        <th class="border-0"><?php echo e(translate('messages.total')); ?></th>
                                        <th class="border-0 text-center"><?php echo e(translate('messages.order_status')); ?></th>
                                        <th class="border-0 text-center"><?php echo e(translate('messages.actions')); ?></th>
                                    </tr>
                                    </thead>

                                    <tbody id="set-rows">
                                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <tr class="status-<?php echo e($order['order_status']); ?> class-all">
                                            <td class="">
                                                <?php echo e($key+ $orders->firstItem()); ?>

                                            </td>
                                            <td class="table-column-pl-0">
                                                <a href="<?php echo e(route('admin.order.details',['id'=>$order['id']])); ?>"><?php echo e($order['id']); ?></a>
                                            </td>
                                            <td>
                                                <div>
                                                    <?php echo e(\App\CentralLogics\Helpers::date_format($order['created_at'])); ?>

                                                </div>
                                                <div class="d-block text-uppercase">
                                                    <?php echo e(\App\CentralLogics\Helpers::time_format($order['created_at'])); ?>


                                                </div>
                                            </td>
                                            <td>
                                                <?php if($order->is_guest): ?>
                                                <?php ($customer_details = json_decode($order['delivery_address'],true)); ?>
                                                <strong><?php echo e($customer_details['contact_person_name']); ?></strong>
                                                <div><?php echo e($customer_details['contact_person_number']); ?></div>

                                                <?php elseif($order->customer): ?>
                                                <div>
                                                    <a title="<?php echo e($order->customer['f_name'].' '.$order->customer['l_name']); ?>" class="text-body text-capitalize"
                                                    href="<?php echo e(route('admin.customer.view',[$order['user_id']])); ?>">
                                                        <div>
                                                            <?php echo e($order->customer['f_name'].' '.$order->customer['l_name']); ?>

                                                        </div>
                                                    </a>
                                                    <a href="tel:<?php echo e($order->customer['phone']); ?>">
                                                        <div>
                                                            <?php echo e($order->customer['phone']); ?>

                                                        </div>
                                                    </a>
                                                </div>
                                                <?php else: ?>
                                                    <label class="badge badge-danger"><?php echo e(translate('messages.invalid_customer_data')); ?></label>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($order->payment_status=='paid'): ?>
                                                    <span class="badge badge-soft-success">
                                                    <?php echo e(translate('messages.paid')); ?>

                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-soft-danger">
                                                    <?php echo e(translate('messages.unpaid')); ?>

                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e(\App\CentralLogics\Helpers::format_currency($order['order_amount'])); ?></td>
                                            <td class="text-capitalize text-center">
                                                <?php if($order['order_status']=='pending'): ?>
                                                    <span class="badge badge-soft-info">
                                                    <?php echo e(translate('messages.pending')); ?>

                                                    </span>
                                                <?php elseif($order['order_status']=='confirmed'): ?>
                                                    <span class="badge badge-soft-info">
                                                    <?php echo e(translate('messages.confirmed')); ?>

                                                    </span>
                                                <?php elseif($order['order_status']=='processing'): ?>
                                                    <span class="badge badge-soft-warning">
                                                    <?php echo e(translate('messages.processing')); ?>

                                                    </span>
                                                <?php elseif($order['order_status']=='out_for_delivery'): ?>
                                                    <span class="badge badge-soft-warning">
                                                    <?php echo e(translate('messages.out_for_delivery')); ?>

                                                    </span>
                                                <?php elseif($order['order_status']=='delivered'): ?>
                                                    <span class="badge badge-soft-success">
                                                    <?php echo e(translate('messages.delivered')); ?>

                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-soft-danger">
                                                    <?php echo e(str_replace('_',' ',$order['order_status'])); ?>

                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="btn--container justify-content-center">
                                                    <a class="btn action-btn btn--warning btn-outline-warning" href="<?php echo e(route('admin.order.details',['id'=>$order['id']])); ?>"><i class="tio-visible"></i></a>
                                                    <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route('admin.order.generate-invoice',['id'=>$order['id']])); ?>"><i class="tio-print"></i></a>
                                                </div>
                                            </td>
                                        </tr>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- End Table -->

                            <?php if(count($orders) !== 0): ?>
                            <hr>
                            <?php endif; ?>
                            <div class="page-area">
                                <?php echo $orders->withQueryString()->links(); ?>

                            </div>
                            <?php if(count($orders) === 0): ?>
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
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <!-- Page level plugins -->
    <script>
        "use strict";
        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();

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

            $('#column3_search').on('change', function () {
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

            $('#search-form').on('submit', function () {
            let formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '<?php echo e(route('admin.order.store-search')); ?>',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('.page-area').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
        });

        $(".filter-on-click").on("click", function () {
    const type = $(this).data('type');
    const url = $(this).data('url');
    const filter_by = $(this).data('filter');
    let nurl = new URL(url);
    nurl.searchParams.delete('page');
    nurl.searchParams.set(filter_by, type);
    location.href = nurl;
});
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/vendor/view/order.blade.php ENDPATH**/ ?>