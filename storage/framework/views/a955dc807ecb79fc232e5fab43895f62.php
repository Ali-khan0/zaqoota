<?php use App\CentralLogics\Helpers; ?>


<?php $__env->startSection('title',translate('messages.Order List')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <?php ($parcel_order = Request::is('admin/parcel/orders*')); ?>
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-xl-10 col-md-9 col-sm-8 mb-3 mb-sm-0 mb-2">
                    <h1 class="page-header-title text-capitalize m-0">
                        <span class="page-header-icon">
                            <img src="<?php echo e(asset('public/assets/admin/img/order.png')); ?>" class="w--26" alt="">
                        </span>
                        <span>
                            <?php echo e(translate('messages.parcel_orders')); ?>

                            <span class="badge badge-soft-dark ml-2"><?php echo e($total); ?></span>
                        </span>
                    </h1>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->
        <!-- Card -->

        <div class="card">
            <!-- Header -->
            <div class="card-header py-1 border-0">
                <div class="search--button-wrapper justify-content-end">
                    <form class="search-form min--260">
                        <!-- Search -->
                        <div class="input-group input--group">
                            <input id="datatableSearch_" type="search" name="search" class="form-control h--40px"
                                   placeholder="<?php echo e(translate('messages.Ex:')); ?> 10010"
                                   value="<?php echo e(request()?->search ?? null); ?>"
                                   aria-label="<?php echo e(translate('messages.search')); ?>">
                            <input type="hidden" name="parcel_order" value="<?php echo e($parcel_order); ?>">
                            <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                        </div>
                        <!-- End Search -->
                    </form>

                    <?php if(request()->get('search')): ?>
                        <button type="reset" class="btn btn--primary ml-2 location-reload-to-base"
                                data-url="<?php echo e(url()->full()); ?>"><?php echo e(translate('messages.reset')); ?></button>
                    <?php endif; ?>

                    <!-- Datatable Info -->
                    <div id="datatableCounterInfo" class="mr-2 mb-2 mb-sm-0 initial-hidden">
                        <div class="d-flex align-items-center">
                                <span class="font-size-sm mr-3">
                                <span id="datatableCounter">0</span>
                                <?php echo e(translate('messages.selected')); ?>

                                </span>
                        </div>
                    </div>

                    <div class="hs-unfold mr-2">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle h--40px" href="javascript:;"
                           data-hs-unfold-options='{
                                "target": "#usersExportDropdown",
                                "type": "css-animation"
                            }'>
                            <i class="tio-download-to mr-1"></i> <?php echo e(translate('messages.export')); ?>

                        </a>

                        <div id="usersExportDropdown"
                             class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                            <span class="dropdown-header"><?php echo e(translate('messages.download_options')); ?></span>
                            <a id="export-excel" class="dropdown-item" href="javascript:;">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                     src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                     alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item" href="javascript:;">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                     src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                     alt="Image Description">
                                .<?php echo e(translate('messages.csv')); ?>

                            </a>
                        </div>
                    </div>

                    <?php if(Request::is('admin/refund/*')): ?>
                        <div class="select-item">
                            <select name="slist" class="form-control js-select2-custom refund-filter">
                                <option
                                    <?php echo e(($status=='requested')?'selected':''); ?> value="<?php echo e(route('admin.refund.refund_attr', ['requested'])); ?>"><?php echo e(translate('messages.Refund Requests')); ?></option>
                                <option
                                    <?php echo e(($status=='refunded')?'selected':''); ?> value="<?php echo e(route('admin.refund.refund_attr', ['refunded'])); ?>"><?php echo e(translate('messages.Refund')); ?></option>
                                <option
                                    <?php echo e(($status=='rejected')?'selected':''); ?> value="<?php echo e(route('admin.refund.refund_attr', ['rejected'])); ?>"><?php echo e(translate('Rejected')); ?></option>
                            </select>
                        </div>
                    <?php endif; ?>

                    <div class="hs-unfold mr-2">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white h--40px filter-button-show"
                           href="javascript:;">
                            <i class="tio-filter-list mr-1"></i> <?php echo e(translate('messages.filter')); ?> <span
                                class="badge badge-success badge-pill ml-1" id="filter_count"></span>
                        </a>
                    </div>

                    
                    <!-- End Unfold -->
                </div>
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table id="datatable"
                       class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table fz--14px"
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
                     "isResponsive": false,
                     "isShowPaging": false,
                     "paging": false
                   }'>
                    <thead class="thead-light">
                    <tr>
                        <th class="border-0">
                            <?php echo e(translate('messages.sl')); ?>

                        </th>
                        <th class="table-column-pl-0 border-0"><?php echo e(translate('messages.order_id')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.order_date')); ?></th>
                        <?php if($status == 'scheduled'): ?>
                            <th class="border-0"><?php echo e(translate('messages.scheduled_at')); ?></th>
                        <?php endif; ?>
                        <th class="border-0"><?php echo e(translate('messages.customer_information')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.parcel_category')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.Payment_By')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.total_amount')); ?></th>

                        <?php if($status == 'refunded'): ?>
                            <th class="text-center border-0"><?php echo e(translate('messages.Refunded_order_status')); ?></th>
                        <?php else: ?>
                            <th class="text-center border-0"><?php echo e(translate('messages.order_status')); ?></th>
                        <?php endif; ?>
                        <th class="text-center border-0"><?php echo e(translate('messages.actions')); ?></th>
                    </tr>
                    </thead>

                    <tbody id="set-rows">
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <tr class="status-<?php echo e($order['order_status']); ?> class-all">
                            <td class="">
                                <?php echo e($key+$orders->firstItem()); ?>

                            </td>
                            <td class="table-column-pl-0">
                                <a href="<?php echo e(route('admin.parcel.order.details',['id'=>$order['id']])); ?>"><?php echo e($order['id']); ?></a>
                            </td>
                            <td>
                                <div>
                                    <div>
                                        <?php echo e(Helpers::date_format($order->created_at)); ?>

                                    </div>
                                    <div class="d-block text-uppercase">
                                        <?php echo e(Helpers::time_format($order->created_at)); ?>

                                    </div>
                                </div>
                            </td>
                            <?php if($status == 'scheduled'): ?>
                                <td>
                                    <div>
                                        <div>
                                            <?php echo e(Helpers::date_format($order->schedule_at)); ?>

                                        </div>
                                        <div class="d-block text-uppercase">
                                            <?php echo e(Helpers::time_format($order->schedule_at)); ?>

                                        </div>
                                    </div>
                                </td>
                            <?php endif; ?>
                            <td>
                                <?php if($order->is_guest): ?>
                                    <?php ($customer_details = json_decode($order['delivery_address'],true)); ?>
                                    <strong><?php echo e($customer_details['contact_person_name']); ?></strong>
                                    <a href="tel:<?php echo e($customer_details['contact_person_number']); ?>">
                                        <div><?php echo e($customer_details['contact_person_number']); ?></div>
                                    </a>
                                <?php elseif($order->customer): ?>

                                    <a class="text-body" href="<?php echo e(route('admin.customer.view',[$order['user_id']])); ?>">
                                        <strong>
                                            <div> <?php echo e($order->customer['f_name'].' '.$order->customer['l_name']); ?></div>
                                        </strong>
                                    </a>
                                    <a href="tel:<?php echo e($order->customer['phone']); ?>">
                                        <div><?php echo e($order->customer['phone']); ?></div>
                                    </a>
                                <?php else: ?>
                                    <label
                                        class="badge badge-danger"><?php echo e(translate('messages.invalid_customer_data')); ?></label>
                                <?php endif; ?>
                            </td>

                            <td>
                                <div><?php echo e(Str::limit($order->parcel_category?$order->parcel_category->name:translate('messages.not_found'),20,'...')); ?></div>
                            </td>

                            <td>
                                <div><?php echo e(translate($order->charge_payer)); ?></div>
                                <strong class="text-success">
                                    <?php echo e(translate($order->payment_method)); ?>

                                </strong>
                            </td>


                            <td>
                                <div class="text-right mw--85px">
                                    <div>
                                        <?php echo e(Helpers::format_currency($order['order_amount'])); ?>

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
                                <?php elseif($order['order_status']=='handover'): ?>
                                    <span class="badge badge-soft-danger">
                                      <?php echo e(translate('messages.handover')); ?>

                                    </span>
                                <?php elseif($order['order_status']=='canceled'): ?>
                                    <span class="badge badge-soft-danger">
                                      <?php echo e(translate('messages.canceled')); ?>

                                    </span>
                                <?php elseif($order['order_status']=='accepted'): ?>
                                    <span class="badge badge-soft-danger">
                                      <?php echo e(translate('messages.accepted')); ?>

                                    </span>
                                <?php elseif($order['order_status']=='refund_requested'): ?>
                                    <span class="badge badge-soft-danger">
                                      <?php echo e(translate('messages.refund_requested')); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-soft-danger">
                                      <?php echo e(str_replace('_',' ',$order['order_status'])); ?>

                                    </span>
                                <?php endif; ?>

                            </td>
                            <td>
                                <div class="btn--container justify-content-center">
                                    <a class="ml-2 btn btn-sm btn--warning btn-outline-warning action-btn"
                                       href="<?php echo e(route('admin.parcel.order.details',['id'=>$order['id']])); ?>">
                                        <i class="tio-invisible"></i>
                                    </a>
                                    <a class="ml-2 btn btn-sm btn--primary btn-outline-primary action-btn"
                                       href="<?php echo e(route('admin.order.generate-invoice',['id'=>$order['id']])); ?>">
                                        <i class="tio-print"></i>
                                    </a>
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
                <?php echo $orders->appends($_GET)->links(); ?>

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
        <!-- End Card -->

        <!-- Order Filter Modal -->
        <div id="datatableFilterSidebar"
             class="hs-unfold-content_ sidebar sidebar-bordered sidebar-box-shadow initial-hidden">
            <div class="card card-lg sidebar-card sidebar-footer-fixed">
                <div class="card-header">
                    <h4 class="card-header-title"><?php echo e(translate('messages.order_filter')); ?></h4>

                    <!-- Toggle Button -->
                    <a class="js-hs-unfold-invoker_ btn btn-icon btn-sm btn-ghost-dark ml-2 filter-button-hide"
                       href="javascript:;">
                        <i class="tio-clear tio-lg"></i>
                    </a>
                    <!-- End Toggle Button -->
                </div>
                <?php
                $filter_count = 0;
                if (isset($zone_ids) && count($zone_ids) > 0) $filter_count += 1;
                if (isset($vendor_ids) && count($vendor_ids) > 0) $filter_count += 1;
                if ($status == 'all') {
                    if (isset($orderstatus) && count($orderstatus) > 0) $filter_count += 1;
                    if (isset($scheduled) && $scheduled == 1) $filter_count += 1;
                }

                if (isset($from_date) && isset($to_date)) $filter_count += 1;
                if (isset($order_type)) $filter_count += 1;

                ?>
                    <!-- Body -->
                <form class="card-body sidebar-body sidebar-scrollbar" action="<?php echo e(route('admin.order.filter')); ?>"
                      method="POST" id="order_filter_form">
                    <?php echo csrf_field(); ?>
                    <small class="text-cap mb-3"><?php echo e(translate('messages.zone')); ?></small>

                    <div class="mb-2 initial--21">
                        <select name="zone[]" data-title="<?php echo e(translate('messages.select_zone')); ?>"
                                data-placeholder="<?php echo e(translate('messages.select_zone')); ?>" id="zone_ids"
                                class="form-control js-select2-custom" multiple="multiple">
                            <?php $__currentLoopData = \App\Models\Zone::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option
                                    value="<?php echo e($zone->id); ?>" <?php echo e(isset($zone_ids)?(in_array($zone->id, $zone_ids)?'selected':''):''); ?>><?php echo e($zone->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <hr class="my-4">
                    <?php if($status == 'all'): ?>
                        <small class="text-cap mb-3"><?php echo e(translate('messages.order_status')); ?></small>

                        <!-- Custom Checkbox -->
                        <div class="custom-control custom-radio mb-2">
                            <input type="checkbox" id="orderStatus2" name="orderStatus[]" class="custom-control-input"
                                   <?php echo e(isset($orderstatus)?(in_array('pending', $orderstatus)?'checked':''):''); ?> value="pending">
                            <label class="custom-control-label"
                                   for="orderStatus2"><?php echo e(translate('messages.pending')); ?></label>
                        </div>
                        <div class="custom-control custom-radio mb-2">
                            <input type="checkbox" id="orderStatus1" name="orderStatus[]" class="custom-control-input"
                                   value="confirmed" <?php echo e(isset($orderstatus)?(in_array('confirmed', $orderstatus)?'checked':''):''); ?>>
                            <label class="custom-control-label"
                                   for="orderStatus1"><?php echo e(translate('messages.confirmed')); ?></label>
                        </div>
                        <div class="custom-control custom-radio mb-2">
                            <input type="checkbox" id="orderStatus3" name="orderStatus[]" class="custom-control-input"
                                   value="processing" <?php echo e(isset($orderstatus)?(in_array('processing', $orderstatus)?'checked':''):''); ?>>
                            <label class="custom-control-label"
                                   for="orderStatus3"><?php echo e(translate('messages.processing')); ?></label>
                        </div>
                        <div class="custom-control custom-radio mb-2">
                            <input type="checkbox" id="orderStatus4" name="orderStatus[]" class="custom-control-input"
                                   value="picked_up" <?php echo e(isset($orderstatus)?(in_array('picked_up', $orderstatus)?'checked':''):''); ?>>
                            <label class="custom-control-label"
                                   for="orderStatus4"><?php echo e(translate('messages.out_for_delivery')); ?></label>
                        </div>
                        <div class="custom-control custom-radio mb-2">
                            <input type="checkbox" id="orderStatus5" name="orderStatus[]" class="custom-control-input"
                                   value="delivered" <?php echo e(isset($orderstatus)?(in_array('delivered', $orderstatus)?'checked':''):''); ?>>
                            <label class="custom-control-label"
                                   for="orderStatus5"><?php echo e(translate('messages.delivered')); ?></label>
                        </div>

                        <div class="custom-control custom-radio mb-2">
                            <input type="checkbox" id="orderStatus7" name="orderStatus[]" class="custom-control-input"
                                   value="failed" <?php echo e(isset($orderstatus)?(in_array('failed', $orderstatus)?'checked':''):''); ?>>
                            <label class="custom-control-label"
                                   for="orderStatus7"><?php echo e(translate('messages.failed')); ?></label>
                        </div>
                        <div class="custom-control custom-radio mb-2">
                            <input type="checkbox" id="orderStatus8" name="orderStatus[]" class="custom-control-input"
                                   value="canceled" <?php echo e(isset($orderstatus)?(in_array('canceled', $orderstatus)?'checked':''):''); ?>>
                            <label class="custom-control-label"
                                   for="orderStatus8"><?php echo e(translate('messages.canceled')); ?></label>
                        </div>
                     
                    <?php endif; ?>

                    <hr class="my-4">

                    <small class="text-cap mb-3"><?php echo e(translate('messages.payment_status')); ?></small>
                    <div class="mb-2 initial--21">
                        <select name="payment_status" data-title="<?php echo e(translate('messages.payment_status')); ?>"
                                data-placeholder="<?php echo e(translate('messages.payment_status')); ?>"
                                class="form-control js-select2-custom">
                            <option
                                value="all" <?php echo e(isset($payment_status) &&  $payment_status== 'all' ?'selected':''); ?>><?php echo e(translate('messages.All')); ?></option>
                            <option
                                value="paid" <?php echo e(isset($payment_status) &&  $payment_status== 'paid' ?'selected':''); ?>><?php echo e(translate('messages.paid')); ?></option>
                            <option
                                value="unpaid" <?php echo e(isset($payment_status) &&  $payment_status== 'unpaid' ?'selected':''); ?>><?php echo e(translate('messages.unpaid')); ?></option>
                        </select>
                    </div>
                    <hr class="my-4">

                    <small class="text-cap mb-3"><?php echo e(translate('messages.payment_By')); ?></small>
                    <div class="mb-2 initial--21">
                        <select name="payment_by" data-title="<?php echo e(translate('messages.payment_By')); ?>"
                                data-placeholder="<?php echo e(translate('messages.payment_By')); ?>"
                                class="form-control js-select2-custom">
                            <option
                                value="all" <?php echo e(isset($payment_By) &&  $payment_By== 'all' ?'selected':''); ?>><?php echo e(translate('messages.All')); ?></option>
                            <option
                                value="sender" <?php echo e(isset($payment_By) &&  $payment_By== 'sender' ?'selected':''); ?>><?php echo e(translate('messages.Sender')); ?></option>
                            <option
                                value="receiver" <?php echo e(isset($payment_By) &&  $payment_By== 'receiver' ?'selected':''); ?>><?php echo e(translate('messages.Receiver')); ?></option>
                        </select>
                    </div>

                    <hr class="my-4">

                    <small class="text-cap mb-3"><?php echo e(translate('messages.date_between')); ?></small>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group m-0">
                                <input type="date" name="from_date" class="form-control" id="date_from"
                                       value="<?php echo e(isset($from_date)?$from_date:''); ?>">
                            </div>
                        </div>
                        <div class="col-12 text-center">----<?php echo e(translate('messages.to')); ?>----</div>
                        <div class="col-12">
                            <div class="form-group">
                                <input type="date" name="to_date" class="form-control" id="date_to"
                                       value="<?php echo e(isset($to_date)?$to_date:''); ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="card-footer sidebar-footer">
                        <div class="row gx-2">
                            <div class="col">
                                <button type="reset" class="btn btn-block btn-white"
                                        id="reset"><?php echo e(translate('Clear all filters')); ?></button>
                            </div>
                            <div class="col">
                                <button type="submit"
                                        class="btn btn-block btn-primary"><?php echo e(translate('messages.save')); ?></button>
                            </div>
                        </div>
                    </div>
                    <!-- End Footer -->
                </form>
            </div>
        </div>
        <!-- End Order Filter Modal -->
        <?php $__env->stopSection(); ?>

        <?php $__env->startPush('script_2'); ?>
            <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/order-list.js"></script>
            <script>
                "use strict";
                $(document).on('ready', function () {
                    <?php if($filter_count>0): ?>
                    $('#filter_count').html(<?php echo e($filter_count); ?>);
                    <?php endif; ?>

                    // INITIALIZATION OF DATATABLES
                    // =======================================================
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
                                action: function (e, dt, node, config) {
                                    window.location.href = '<?php echo e(route("admin.parcel.parcel_orders_export",['status'=>$status,'file_type'=>'excel','type'=>'parcel', request()->getQueryString()])); ?>';
                                }
                            },
                            {
                                extend: 'csv',
                                className: 'd-none',
                                action: function (e, dt, node, config) {
                                    window.location.href = '<?php echo e(route("admin.parcel.parcel_orders_export",['status'=>$status,'file_type'=>'csv','type'=>'parcel', request()->getQueryString()])); ?>';
                                }
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

                    $('#export-print').click(function () {
                        datatable.button('.buttons-print').trigger()
                    });

                    $('#datatableSearch').on('mouseup', function (e) {
                        let $input = $(this),
                            oldValue = $input.val();

                        if (oldValue == "") return;

                        setTimeout(function () {
                            let newValue = $input.val();

                            if (newValue == "") {
                                // Gotcha
                                datatable.search('').draw();
                            }
                        }, 1);
                    });

                    $('#toggleColumn_date').change(function (e) {
                        datatable.columns(2).visible(e.target.checked)
                    })

                    $('#toggleColumn_customer').change(function (e) {
                        datatable.columns(3).visible(e.target.checked)
                    })
                    $('#toggleColumn_store').change(function (e) {
                        datatable.columns(4).visible(e.target.checked)
                    })


                    $('#toggleColumn_total').change(function (e) {
                        datatable.columns(5).visible(e.target.checked)
                    })
                    $('#toggleColumn_order_status').change(function (e) {
                        datatable.columns(6).visible(e.target.checked)
                    })

                    $('#toggleColumn_actions').change(function (e) {
                        datatable.columns(7).visible(e.target.checked)
                    })
                });

                $('#reset').on('click', function () {
                    // e.preventDefault();
                    location.href = '<?php echo e(url('/')); ?>/admin/order/filter/reset';
                });

            </script>
    <?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/order/parcel-list.blade.php ENDPATH**/ ?>