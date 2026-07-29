<?php $__env->startSection('title',translate('messages.Order List')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title text-capitalize">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/order.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate(str_replace('_',' ',$status))); ?> <?php echo e(translate('messages.orders')); ?>

                    <span class="badge badge-soft-dark ml-2"><?php echo e($orders->total()); ?></span>
                </span>
            </h1>
        </div>
        <!-- End Page Header -->

        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header py-2 border-0">
                <div class="search--button-wrapper justify-content-end">
                        <form class="search-form min--260">

                            <!-- Search -->
                            <div class="input-group input--group">
                                <input  type="search" value="<?php echo e(request()?->search ?? null); ?>" name="search" class="form-control" placeholder="<?php echo e(translate('messages.ex_:_search_order_id')); ?>" aria-label="<?php echo e(translate('messages.search')); ?>" >
                                <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                            </div>
                            <!-- End Search -->
                        </form>
                        <!-- Unfold -->
                        <div class="hs-unfold mr-2">
                            <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle h--40px" href="javascript:"
                                data-hs-unfold-options='{
                                    "target": "#usersExportDropdown",
                                    "type": "css-animation"
                                }'>
                                <i class="tio-download-to mr-1"></i> <?php echo e(translate('messages.export')); ?>

                            </a>

                            <div id="usersExportDropdown"
                                    class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                                <span class="dropdown-header"><?php echo e(translate('messages.options')); ?></span>
                                <a id="export-copy" class="dropdown-item" href="javascript:">
                                    <img class="avatar avatar-xss avatar-4by3 mr-2"
                                            src="<?php echo e(asset('public/assets/admin/svg/illustrations/copy.svg')); ?>"
                                            alt="Image Description">
                                    <?php echo e(translate('messages.copy')); ?>

                                </a>
                                <a id="export-print" class="dropdown-item" href="javascript:">
                                    <img class="avatar avatar-xss avatar-4by3 mr-2"
                                            src="<?php echo e(asset('public/assets/admin/svg/illustrations/print.svg')); ?>"
                                            alt="Image Description">
                                    <?php echo e(translate('messages.print')); ?>

                                </a>
                                <div class="dropdown-divider"></div>
                                <span
                                    class="dropdown-header"><?php echo e(translate('messages.download_options')); ?></span>
                                <a id="export-excel" class="dropdown-item" href="javascript:">
                                    <img class="avatar avatar-xss avatar-4by3 mr-2"
                                            src="<?php echo e(asset('public/assets/admin/svg/components/excel.svg')); ?>"
                                            alt="Image Description">
                                    <?php echo e(translate('messages.excel')); ?>

                                </a>
                                <a id="export-csv" class="dropdown-item" href="javascript:">
                                    <img class="avatar avatar-xss avatar-4by3 mr-2"
                                            src="<?php echo e(asset('public/assets/admin/svg/components/placeholder-csv-format.svg')); ?>"
                                            alt="Image Description">
                                    .<?php echo e(translate('messages.csv')); ?>

                                </a>
                                <a id="export-pdf" class="dropdown-item" href="javascript:">
                                    <img class="avatar avatar-xss avatar-4by3 mr-2"
                                            src="<?php echo e(asset('public/assets/admin/svg/components/pdf.svg')); ?>"
                                            alt="Image Description">
                                    <?php echo e(translate('messages.pdf')); ?>

                                </a>
                            </div>
                        </div>
                        <!-- End Unfold -->

                        <!-- Unfold -->
                        <div class="hs-unfold">
                            <a class="js-hs-unfold-invoker btn btn-sm btn-white h--40px" href="javascript:"
                                data-hs-unfold-options='{
                                    "target": "#showHideDropdown",
                                    "type": "css-animation"
                                }'>
                                <i class="tio-table mr-1"></i> <?php echo e(translate('messages.column')); ?> <span
                                    class="badge badge-soft-dark rounded-circle ml-1"></span>
                            </a>

                            <div id="showHideDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right dropdown-card">
                                <div class="card card-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="mr-2"><?php echo e(translate('messages.order')); ?></span>

                                            <!-- Checkbox Switch -->
                                            <label class="toggle-switch toggle-switch-sm" for="toggleColumn_order">
                                                <input type="checkbox" class="toggle-switch-input"
                                                        id="toggleColumn_order" checked>
                                                <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                            <!-- End Checkbox Switch -->
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="mr-2"><?php echo e(translate('messages.date')); ?></span>

                                            <!-- Checkbox Switch -->
                                            <label class="toggle-switch toggle-switch-sm" for="toggleColumn_date">
                                                <input type="checkbox" class="toggle-switch-input"
                                                        id="toggleColumn_date" checked>
                                                <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                            <!-- End Checkbox Switch -->
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="mr-2"><?php echo e(translate('messages.customer')); ?></span>

                                            <!-- Checkbox Switch -->
                                            <label class="toggle-switch toggle-switch-sm"
                                                    for="toggleColumn_customer">
                                                <input type="checkbox" class="toggle-switch-input"
                                                        id="toggleColumn_customer" checked>
                                                <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                            <!-- End Checkbox Switch -->
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span
                                                class="mr-2 text-capitalize"><?php echo e(translate('messages.total_amount')); ?></span>

                                            <!-- Checkbox Switch -->
                                            <label class="toggle-switch toggle-switch-sm"
                                                    for="toggleColumn_payment_status">
                                                <input type="checkbox" class="toggle-switch-input"
                                                        id="toggleColumn_payment_status" checked>
                                                <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                            <!-- End Checkbox Switch -->
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="mr-2"><?php echo e(translate('messages.order_status')); ?></span>

                                            <!-- Checkbox Switch -->
                                            <label class="toggle-switch toggle-switch-sm" for="toggleColumn_order_status">
                                                <input type="checkbox" class="toggle-switch-input"
                                                        id="toggleColumn_order_status" checked>
                                                <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                            <!-- End Checkbox Switch -->
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="mr-2"><?php echo e(translate('messages.actions')); ?></span>

                                            <!-- Checkbox Switch -->
                                            <label class="toggle-switch toggle-switch-sm"
                                                    for="toggleColumn_actions">
                                                <input type="checkbox" class="toggle-switch-input"
                                                        id="toggleColumn_actions" checked>
                                                <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                            <!-- End Checkbox Switch -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Unfold -->
                    </div>
                </div>
                <!-- End Row -->
            </div>
            <!-- End Header -->
            <div class="card-body p-0">
                <!-- Table -->
                <div class="table-responsive datatable-custom">
                    <table id="datatable" class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                        data-hs-datatables-options='{
                                    "order": [],
                                    "orderCellsTop": true,
                                    "paging":false
                                }'>
                        <thead class="thead-light">
                        <tr>
                            <th class="border-0">
                                <?php echo e(translate('messages.#')); ?>

                            </th>
                            <th class="border-0 table-column-pl-0"><?php echo e(translate('messages.order_id')); ?></th>
                            <th class="border-0"><?php echo e(translate('messages.order_date')); ?></th>
                            <th class="border-0"><?php echo e(translate('messages.customer_information')); ?></th>
                            <th class="border-0"><?php echo e(translate('messages.total_amount')); ?></th>
                            <th class="border-0 text-center"><?php echo e(translate('messages.order_status')); ?></th>
                            <th class="border-0 text-center"><?php echo e(translate('messages.actions')); ?></th>
                        </tr>
                        </thead>

                        <tbody id="set-rows">
                        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="status-<?php echo e($order['order_status']); ?> class-all">
                                <td class="">
                                    <?php echo e($key+$orders->firstItem()); ?>

                                </td>
                                <td class="table-column-pl-0">
                                    <a href="<?php echo e(route('vendor.order.details',['id'=>$order['id']])); ?>"><?php echo e($order['id']); ?></a>
                                </td>
                                <td>
                                    <div>
                                        <?php echo e(date('d M Y',strtotime($order['created_at']))); ?>

                                    </div>
                                    <div class="d-block text-uppercase">
                                        <?php echo e(date(config('timeformat'),strtotime($order['created_at']))); ?>

                                    </div>
                                </td>
                                <td>
                                    <?php if($order->is_guest): ?>
                                    <?php ($customer_details = json_decode($order['delivery_address'],true)); ?>
                                    <strong><?php echo e($customer_details['contact_person_name']); ?></strong>
                                    <div><?php echo e($customer_details['contact_person_number']); ?></div>
                                    <?php elseif($order->customer): ?>

                                    <strong>
                                        <?php echo e($order->customer['f_name'].' '.$order->customer['l_name']); ?>

                                    </strong>
                                    <div>
                                        <?php echo e($order->customer['phone']); ?>

                                    </div>
                                    <?php else: ?>
                                        <label
                                            class="badge badge-danger"><?php echo e(translate('messages.invalid_customer_data')); ?></label>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="text-right mw--85px">
                                        <div>
                                            <?php echo e(\App\CentralLogics\Helpers::format_currency($order['order_amount'])); ?>

                                        </div>
                                        <?php if($order->payment_status=='paid'): ?>
                                        <strong class="text-success">
                                            <?php echo e(translate('messages.paid')); ?>

                                        </strong>
                                        <?php elseif($order->payment_status=='partially_paid'): ?>
                                        <strong class="text-success">
                                            <?php echo e(translate('messages.partially_paid')); ?>

                                        </strong>
                                        <?php else: ?>
                                        <strong class="text-danger">
                                            <?php echo e(translate('messages.unpaid')); ?>

                                        </strong>
                                        <?php endif; ?>
                                    </div>
                                </td>
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
                                    <?php elseif($order['order_status']=='picked_up'): ?>
                                        <span class="badge badge-soft-warning">
                                        <?php echo e(translate('messages.out_for_delivery')); ?>

                                        </span>
                                    <?php elseif($order['order_status']=='delivered'): ?>
                                        <span class="badge badge-soft-success">
                                        <?php echo e(translate('messages.delivered')); ?>

                                        </span>
                                    <?php elseif($order['order_status']=='failed'): ?>
                                        <span class="badge badge-soft-danger">
                                        <?php echo e(translate('messages.payment_failed')); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-soft-danger">
                                        <?php echo e(str_replace('_',' ',$order['order_status'])); ?>

                                        </span>
                                    <?php endif; ?>
                                    <?php if($order['order_type']=='take_away'): ?>
                                        <div class="text-info mt-1">
                                            <?php echo e(translate('messages.take_away')); ?>

                                        </div>
                                    <?php else: ?>
                                        <div class="text-title mt-1">
                                        <?php echo e(translate('messages.home Delivery')); ?>

                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn--container justify-content-center">
                                        <a class="btn btn-sm btn--warning btn-outline-warning action-btn" href="<?php echo e(route('vendor.order.details',['id'=>$order['id']])); ?>"><i class="tio-visible-outlined"></i></a>
                                        <a class="btn btn-sm btn--primary btn-outline-primary action-btn" target="_blank" href="<?php echo e(route('vendor.order.generate-invoice',[$order['id']])); ?>"><i class="tio-print"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <?php if(count($orders) === 0): ?>
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
            <!-- Footer -->
            <div class="card-footer">
                <?php echo $orders->links(); ?>

            </div>
            <!-- End Footer -->
        </div>
        <!-- End Card -->

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script>
        "use strict";
        $(document).on('ready', function () {

            let datatable = $.HSCore.components.HSDatatables.init($('#datatable'), {
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        className: 'd-none'
                    },
                    {
                        extend: 'excel',
                        className: 'd-none',
                        action: function ()
                        {
                            window.location.href = '<?php echo e(route("vendor.order.export",['status'=>$status,'file_type'=>'excel','type'=>'order', request()->getQueryString()])); ?>';
                        }
                    },
                    {
                        extend: 'csv',
                        className: 'd-none',
                        action: function ()
                        {
                            window.location.href = '<?php echo e(route("vendor.order.export",['status'=>$status,'file_type'=>'csv','type'=>'order', request()->getQueryString()])); ?>';
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'd-none'
                    },
                    {
                        extend: 'print',
                        className: 'd-none'
                    },
                ],
                select: {
                    style: 'multi',
                    selector: 'td:first-child input[type="checkbox"]',
                    classMap: {
                        checkAll: '#datatableCheckAll',
                        counter: '#datatableCounter',
                        counterInfo: '#datatableCounterInfo'
                    }
                },
                language: {
                    zeroRecords: '<div class="text-center p-4">' +
                        '<img class="w-7rem mb-3" src="<?php echo e(asset('public/assets/admin')); ?>/svg/illustrations/sorry.svg" alt="Image Description">' +

                        '</div>'
                }
            });

            $('#export-copy').click(function () {
                datatable.button('.buttons-copy').trigger()
            });

            $('#export-excel').click(function () {
                datatable.button('.buttons-excel').trigger()
            });

            $('#export-csv').click(function () {
                datatable.button('.buttons-csv').trigger()
            });

            $('#export-pdf').click(function () {
                datatable.button('.buttons-pdf').trigger()
            });

            $('#export-print').click(function () {
                datatable.button('.buttons-print').trigger()
            });

            $('#toggleColumn_order').change(function (e) {
                datatable.columns(1).visible(e.target.checked)
            })

            $('#toggleColumn_date').change(function (e) {
                datatable.columns(2).visible(e.target.checked)
            })

            $('#toggleColumn_customer').change(function (e) {
                datatable.columns(3).visible(e.target.checked)
            })

            $('#toggleColumn_payment_status').change(function (e) {
                datatable.columns(4).visible(e.target.checked)
            })

            $('#toggleColumn_order_status').change(function (e) {
                datatable.columns(5).visible(e.target.checked)
            })

            $('#toggleColumn_actions').change(function (e) {
                datatable.columns(6).visible(e.target.checked)
            })

        });
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/vendor-views/order/list.blade.php ENDPATH**/ ?>