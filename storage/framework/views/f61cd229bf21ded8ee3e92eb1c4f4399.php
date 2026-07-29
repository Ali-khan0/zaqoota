<?php use App\CentralLogics\Helpers; ?>


<?php $__env->startSection('title',ucfirst(str_replace('_',' ',$status).' '.translate('messages.orders'))); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <?php ($parcel_order = Request::is('admin/parcel/dispatch*')); ?>
<?php if(isset($parcel)): ?>
    <?php ($parcel_order= true); ?>
<?php endif; ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div class="">
                    <h1 class="page-header-title text-capitalize">
                        <span class="page-header-icon">
                            <img src="<?php echo e(asset('public/assets/admin/img/items.png')); ?>" class="w--22" alt="">
                        </span>
                        <span>
                            <?php echo e(translate('messages.'.$status)); ?> <?php echo e(translate('messages.orders')); ?> <span
                                class="badge badge-soft-dark ml-2"><?php echo e($total); ?></span>
                        </span>
                    </h1>
                </div>
                <?php if(isset($module_section_type)): ?>
                    <div class="min--280 max-sm-flex-grow-1">
                        <!-- Select -->
                        <select name="zone_id" class="form-control js-select2-custom set-filter"
                                data-url="<?php echo e(url()->full()); ?>"
                                data-filter="module_id"
                                title="<?php echo e(translate('messages.select_modules')); ?>">
                            <option
                                value="" <?php echo e(!request('module_id') ? 'selected':''); ?>><?php echo e(translate('messages.all_modules')); ?></option>
                            <?php $__currentLoopData = \App\Models\Module::notParcel()->where('module_type',$module_section_type)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option
                                    value="<?php echo e($module->id); ?>" <?php echo e(request('module_id') == $module->id?'selected':''); ?>>
                                    <?php echo e($module['module_name']); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <!-- End Select -->
                    </div>
                <?php endif; ?>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->

        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header border-0 py-2">
                <div class="search--button-wrapper justify-content-end">
                    <form class="search-form min--260">
                        <!-- Search -->
                        <div class="input-group input--group">
                            <input id="datatableSearch_" type="search" value="<?php echo e(request()->get('search')); ?>" name="search" class="form-control h--40px"
                                   placeholder="<?php echo e(translate('messages.Ex:')); ?> 10010"
                                   aria-label="<?php echo e(translate('messages.search')); ?>" required>
                            <input type="hidden" name="parcel_order" value="0">
                            <input type="hidden" name="module_section_type" value="<?php echo e(isset($module)?$module:''); ?>">
                            <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>

                        </div>
                        <!-- End Search -->
                    </form>
                    <?php if(request()->get('search')): ?>
                        <button type="reset" class="btn btn--primary ml-2 location-reload-to-base" data-url="<?php echo e(url()->full()); ?>"><?php echo e(translate('messages.reset')); ?></button>
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
                    <!-- End Datatable Info -->

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


                            <span class="dropdown-header"><?php echo e(translate('messages.download_options')); ?></span>
                            <a id="export-excel" class="dropdown-item" href="javascript:">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                     src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                     alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item" href="javascript:">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                     src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                     alt="Image Description">
                                .<?php echo e(translate('messages.csv')); ?>

                            </a>

                        </div>
                    </div>
                    <!-- End Unfold -->
                    <!-- Unfold -->
                    <div class="hs-unfold mr-2">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white h--40px" href="javascript:"
                           id="filter-button-on">
                            <i class="tio-filter-list mr-1"></i> <?php echo e(translate('Filters')); ?> <span
                                class="badge badge-success badge-pill ml-1" id="filter_count"></span>
                        </a>
                    </div>
                    <!-- End Unfold -->
                </div>
                <!-- End Row -->
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table id="datatable"
                       class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100 fz--14px"
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
                     "paging": false
                   }'>
                    <thead class="thead-light">
                    <tr>
                        <th class="border-0">
                            <?php echo e(translate('sl')); ?>

                        </th>
                        <th class="table-column-pl-0 border-0"><?php echo e(translate('messages.order_id')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.order_date')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.customer_information')); ?></th>
                        <?php if(!$parcel_order): ?>

                            <th class="border-0"><?php echo e(translate('messages.store')); ?></th>
                        <?php endif; ?>
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
                                <a href="<?php echo e(route('admin.order.details',['id'=>$order['id'],'module_id'=>$order['module_id']])); ?>"><?php echo e($order['id']); ?></a>
                            </td>
                            <td><?php echo e(Helpers::time_date_format($order['created_at'])); ?></td>
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
                            <?php if(!$parcel_order): ?>
                                <td>
                                    <div><?php echo e($order->store?$order->store->name:'Store deleted!'); ?></div>
                                </td>
                            <?php endif; ?>
                            <td>
                                <div class="text-right mw--85px">
                                    <div>
                                        <?php echo e(Helpers::format_currency($order['order_amount'])); ?>

                                    </div>
                                    <?php if($order->payment_status=='paid'): ?>
                                        <strong class="text-danger">
                                            <?php echo e(translate('messages.paid')); ?>

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
                                <?php else: ?>
                                    <span class="badge badge-soft-danger">
                                      <?php echo e(str_replace('_',' ',$order['order_status'])); ?>

                                    </span>
                                <?php endif; ?>
                                <?php if(!$parcel_order): ?>
                                    <?php if($order['order_type']=='take_away'): ?>
                                        <div class="text-title mt-1">
                                            <?php echo e(translate('messages.take_away')); ?>

                                        </div>
                                    <?php else: ?>
                                        <div class="text-title mt-1">
                                            <?php echo e(translate('messages.home_delivery')); ?>

                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn--container justify-content-center">
                                    <a class="btn action-btn btn--warning btn-outline-warning"
                                       href="<?php echo e(route('admin.order.details',['id'=>$order['id'],'module_id'=>$order['module_id']])); ?>"><i
                                            class="tio-visible-outlined"></i></a>
                                    <?php if(Request::is('admin/dispatch*')): ?>
                                        <a class="btn action-btn btn--primary btn-outline-primary" target="_blank"
                                           href="<?php echo e(route('admin.dispatch.order.generate-invoice',[$order['id']])); ?>"><i
                                                class="tio-download"></i></a>
                                    <?php else: ?>
                                        <a class="btn action-btn btn--primary btn-outline-primary" target="_blank"
                                           href="<?php echo e(route('admin.order.generate-invoice',[$order['id']])); ?>"> <i
                                                class="tio-print"></i></a>
                                    <?php endif; ?>
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
                <?php echo $orders->links(); ?>

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
                    <a class="js-hs-unfold-invoker_ btn btn-icon btn-sm btn-ghost-dark ml-2" href="javascript:"
                       id="filter-button-off">
                        <i class="tio-clear tio-lg"></i>
                    </a>
                    <!-- End Toggle Button -->
                </div>

                <!-- Body -->
                <form class="card-body sidebar-body sidebar-scrollbar" action="<?php echo e(route('admin.order.filter')); ?>"
                      method="POST" id="order_filter_form">
                    <?php echo csrf_field(); ?>
                    <small class="text-cap mb-3"><?php echo e(translate('messages.zone')); ?></small>

                    <div class="mb-2 initial--21">
                        <select name="zone[]" id="zone_ids" class="form-control js-select2-custom" multiple="multiple">
                            <?php $__currentLoopData = \App\Models\Zone::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option
                                    value="<?php echo e($zone->id); ?>" <?php echo e(isset($zone_ids)?(in_array($zone->id, $zone_ids)?'selected':''):''); ?>><?php echo e($zone->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <?php if(!$parcel_order): ?>

                    <hr class="my-4">
                    <small class="text-cap mb-3"><?php echo e(translate('messages.store')); ?></small>
                    <div class="mb-2 initial--21">
                        <select name="vendor[]" id="vendor_ids" class="form-control js-select2-custom"
                                multiple="multiple">
                            <?php $__currentLoopData = \App\Models\Store::whereIn('id', $vendor_ids)->get(['id','name']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($store->id); ?>" selected><?php echo e($store->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <?php endif; ?>

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
                            <input type="checkbox" id="orderStatus6" name="orderStatus[]" class="custom-control-input"
                                   value="returned" <?php echo e(isset($orderstatus)?(in_array('returned', $orderstatus)?'checked':''):''); ?>>
                            <label class="custom-control-label"
                                   for="orderStatus6"><?php echo e(translate('messages.returned')); ?></label>
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
                        <div class="custom-control custom-radio mb-2">
                            <input type="checkbox" id="orderStatus9" name="orderStatus[]" class="custom-control-input"
                                   value="refund_requested" <?php echo e(isset($orderstatus)?(in_array('refund_requested', $orderstatus)?'checked':''):''); ?>>
                            <label class="custom-control-label"
                                   for="orderStatus9"><?php echo e(translate('messages.refundRequest')); ?></label>
                        </div>
                        <div class="custom-control custom-radio mb-2">
                            <input type="checkbox" id="orderStatus10" name="orderStatus[]" class="custom-control-input"
                                   value="refunded" <?php echo e(isset($orderstatus)?(in_array('refunded', $orderstatus)?'checked':''):''); ?>>
                            <label class="custom-control-label"
                                   for="orderStatus10"><?php echo e(translate('messages.refunded')); ?></label>
                        </div>

                        <hr class="my-4">

                        <div class="custom-control custom-radio mb-2">
                            <input type="checkbox" id="scheduled" name="scheduled" class="custom-control-input"
                                   value="1" <?php echo e(isset($scheduled)?($scheduled==1?'checked':''):''); ?>>
                            <label class="custom-control-label text-uppercase"
                                   for="scheduled"><?php echo e(translate('messages.scheduled')); ?></label>
                        </div>
                        <hr class="my-4">
                        <small class="text-cap mb-3"><?php echo e(translate('messages.order_type')); ?></small>
                        <div class="custom-control custom-radio mb-2">
                            <input type="radio" id="take_away" name="order_type" class="custom-control-input"
                                   value="take_away" <?php echo e(isset($order_type)?($order_type=='take_away'?'checked':''):''); ?>>
                            <label class="custom-control-label text-uppercase"
                                   for="take_away"><?php echo e(translate('messages.take_away')); ?></label>
                        </div>
                        <div class="custom-control custom-radio mb-2">
                            <input type="radio" id="delivery" name="order_type" class="custom-control-input"
                                   value="delivery" <?php echo e(isset($order_type)?($order_type=='delivery'?'checked':''):''); ?>>
                            <label class="custom-control-label text-uppercase"
                                   for="delivery"><?php echo e(translate('messages.delivery')); ?></label>
                        </div>
                        <hr class="my-4">
                    <?php endif; ?>
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
                                        id="reset"><?php echo e(translate('Clear_all_filters')); ?></button>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-block btn-primary"><?php echo e(translate('Save')); ?></button>
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

            <script>

                document.getElementById('filter-button-on').addEventListener('click', function () {
                    $('#datatableFilterSidebar, .hs-unfold-overlay').show(500);
                });


                document.getElementById('filter-button-off').addEventListener('click', function () {
                    $('#datatableFilterSidebar, .hs-unfold-overlay').hide(500);
                });

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

                <?php if($filter_count>0): ?>
                $('#filter_count').html(<?php echo e($filter_count); ?>);
                <?php endif; ?>

                function filter_zone_orders(id) {
                    location.href = '<?php echo e(url('/')); ?>/admin/order/zone-filter/' + id;
                }

                $(document).on('ready', function () {
                    // INITIALIZATION OF SELECT2
                    // =======================================================
                    $('.js-select2-custom').each(function () {
                        var select2 = $.HSCore.components.HSSelect2.init($(this));
                    });

                    var zone_id = [];
                    $('#zone_ids').on('change', function () {
                        if ($(this).val()) {
                            zone_id = $(this).val();
                        } else {
                            zone_id = [];
                        }
                    });


                    $('#vendor_ids').select2({
                        ajax: {
                            url: '<?php echo e(url('/')); ?>/admin/store/get-stores',
                            data: function (params) {
                                return {
                                    q: params.term, // search term
                                    zone_ids: zone_id,
                                    page: params.page
                                };
                            },
                            processResults: function (data) {
                                return {
                                    results: data
                                };
                            },
                            __port: function (params, success, failure) {
                                var $request = $.ajax(params);

                                $request.then(success);
                                $request.fail(failure);

                                return $request;
                            }
                        }
                    });

                    // INITIALIZATION OF DATATABLES
                    // =======================================================
                    var datatable = $.HSCore.components.HSDatatables.init($('#datatable'), {
                        dom: 'Bfrtip',
                        buttons: [
                            {
                                extend: 'copy',
                                className: 'd-none'
                            },
                            {
                                extend: 'excel',
                                className: 'd-none'
                            },
                            {
                                extend: 'csv',
                                className: 'd-none'
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

                    $('#datatableSearch').on('mouseup', function (e) {
                        var $input = $(this),
                            oldValue = $input.val();

                        if (oldValue == "") return;

                        setTimeout(function () {
                            var newValue = $input.val();

                            if (newValue == "") {
                                // Gotcha
                                datatable.search('').draw();
                            }
                        }, 1);
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
                    $('#toggleColumn_restaurant').change(function (e) {
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

                    // INITIALIZATION OF TAGIFY
                    // =======================================================
                    $('.js-tagify').each(function () {
                        var tagify = $.HSCore.components.HSTagify.init($(this));
                    });

                    $("#date_from").on("change", function () {
                        $('#date_to').attr('min', $(this).val());
                    });

                    $("#date_to").on("change", function () {
                        $('#date_from').attr('max', $(this).val());
                    });
                });

                $('#reset').on('click', function () {
                    // e.preventDefault();
                    location.href = '<?php echo e(url('/')); ?>/admin/order/filter/reset';
                });
            </script>

    <?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/order/distaptch_list.blade.php ENDPATH**/ ?>