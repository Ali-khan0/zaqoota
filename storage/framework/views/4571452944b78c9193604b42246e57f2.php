<?php $__env->startSection('title', translate('messages.expense_report')); ?>

<?php $__env->startPush('css_or_js'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/report.png')); ?>" class="w--22" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.expense_report')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->

        <div class="light-card mb-3 d-flex gap-3 rounded align-items-center p-3 fs-12">
            <img width="18" src="<?php echo e(asset('public/assets/admin/img/icons/intel.png')); ?>" alt="">
            <?php echo e(translate('This report will show all the orders in which the admin discount has been used. The admin discount are: Free delivery over, store discount, Coupon discount & item discounts(partial according to order commission).')); ?>

        </div>

        <div class="card mb-20">
            <div class="card-body">
                <h4 class="mb-3"><?php echo e(translate('Filter Data')); ?></h4>
                <form action="<?php echo e(route('admin.transactions.report.set-date')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="row g-3">
                        <div class="col-sm-6 col-md-3">
                            <select name="module_id" class="form-control js-select2-custom set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="module_id"
                                title="<?php echo e(translate('messages.select_modules')); ?>">
                                <option value="" <?php echo e(!request('module_id') ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.all_modules')); ?></option>
                                <?php $__currentLoopData = \App\Models\Module::notParcel()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($module->id); ?>"
                                        <?php echo e(request('module_id') == $module->id ? 'selected' : ''); ?>>
                                        <?php echo e($module['module_name']); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <select name="zone_id" class="form-control js-select2-custom set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="zone_id">
                                <option value="all"><?php echo e(translate('messages.All_Zones')); ?></option>
                                <?php $__currentLoopData = \App\Models\Zone::orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($z['id']); ?>"
                                        <?php echo e(isset($zone) && $zone->id == $z['id'] ? 'selected' : ''); ?>>
                                        <?php echo e($z['name']); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <select name="store_id"
                                data-placeholder="<?php echo e(translate('messages.select_vendor')); ?>"
                                class="js-data-example-ajax form-control set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="store_id">
                                <?php if(isset($store)): ?>
                                    <option value="<?php echo e($store->id); ?>" selected><?php echo e($store->name); ?></option>
                                <?php else: ?>
                                    <option value="all" selected><?php echo e(translate('messages.all_vendors')); ?></option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <select name="customer_id"
                                data-placeholder="<?php echo e(translate('messages.select_customer')); ?>"
                                class="js-data-example-ajax-2 form-control set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="customer_id">
                                <?php if(isset($customer)): ?>
                                    <option value="<?php echo e($customer->id); ?>" selected><?php echo e($customer->f_name . ' ' .$customer->l_name); ?></option>
                                <?php else: ?>
                                    <option value="all" selected><?php echo e(translate('messages.all_customers')); ?></option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <select class="form-control js-select2-custom set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="type" name="type">
                                <option value="all" <?php echo e(isset($type) && $type == 'all' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.All Type')); ?></option>
                                <option value="add_fund_bonus" <?php echo e(isset($type) && $type == 'add_fund_bonus' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.add_fund_bonus')); ?></option>
                                <option value="free_delivery" <?php echo e(isset($type) && $type == 'free_delivery' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.free_delivery')); ?></option>
                                <option value="coupon_discount" <?php echo e(isset($type) && $type == 'coupon_discount' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.coupon_discount')); ?></option>
                                <option value="discount_on_product" <?php echo e(isset($type) && $type == 'discount_on_product' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.discount_on_product')); ?></option>
                                <option value="flash_sale_discount" <?php echo e(isset($type) && $type == 'flash_sale_discount' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.flash_sale_discount')); ?></option>
                                <option value="CashBack" <?php echo e(isset($type) && $type == 'CashBack' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.CashBack')); ?></option>
                                <option value="referral_discount" <?php echo e(isset($type) && $type == 'referral_discount' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.Referral_Discount')); ?></option>
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <select class="form-control js-select2-custom set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="filter" name="filter">
                                <option value="all_time" <?php echo e(isset($filter) && $filter == 'all_time' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.All Time')); ?></option>
                                <option value="this_year" <?php echo e(isset($filter) && $filter == 'this_year' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.This Year')); ?></option>
                                <option value="previous_year"
                                    <?php echo e(isset($filter) && $filter == 'previous_year' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.Previous Year')); ?></option>
                                <option value="this_month"
                                    <?php echo e(isset($filter) && $filter == 'this_month' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.This Month')); ?></option>
                                <option value="this_week" <?php echo e(isset($filter) && $filter == 'this_week' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.This Week')); ?></option>
                                <option value="custom" <?php echo e(isset($filter) && $filter == 'custom' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.Custom')); ?></option>
                            </select>
                        </div>
                        <?php if(isset($filter) && $filter == 'custom'): ?>
                            <div class="col-sm-6 col-md-3">

                                <input type="date" name="from" id="from_date" class="form-control"
                                    placeholder="<?php echo e(translate('Start Date')); ?>"
                                    <?php echo e(session()->has('from_date') ? 'value=' . session('from_date') : ''); ?> required>

                            </div>
                            <div class="col-sm-6 col-md-3">

                                <input type="date" name="to" id="to_date" class="form-control"
                                    placeholder="<?php echo e(translate('End Date')); ?>"
                                    <?php echo e(session()->has('to_date') ? 'value=' . session('to_date') : ''); ?> required>

                            </div>
                        <?php endif; ?>
                        <div class="col-sm-6 col-md-3 ml-auto">
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn--primary h--45px min-w-100px"><?php echo e(translate('Filter')); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php
            $from = session('from_date') . ' 00:00:00';
            $to = session('to_date') . ' 23:59:59';
        ?>

        <!-- End Stats -->
        <!-- Card -->
        <div class="card mt-3">
            <!-- Header -->
            <div class="card-header border-0 py-2">
                <div class="search--button-wrapper">
                    <h3 class="card-title d-flex align-items-center gap-2">
                        <?php echo e(translate('messages.expense_lists')); ?>

                        <span class="badge badge-soft-secondary" id="countItems"><?php echo e($expense->total()); ?></span>
                    </h3>
                    <form class="search-form theme-style">
                        <!-- Search -->
                        <div class="input--group input-group input-group-merge input-group-flush">
                            <input name="search" type="search" value="<?php echo e(request()?->search ?? null); ?>" class="form-control" placeholder="<?php echo e(translate('Search by Order ID')); ?>">
                            <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                        </div>
                        <!-- End Search -->
                    </form>

                    <?php if(request()->get('search')): ?>
                        <button type="reset" class="btn btn--primary ml-2 location-reload-to-base" data-url="<?php echo e(url()->full()); ?>"><?php echo e(translate('messages.reset')); ?></button>
                    <?php endif; ?>
                    <!-- Static Export Button -->
                    <div class="hs-unfold ml-3">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle btn export-btn font--sm"
                            href="javascript:;"
                            data-hs-unfold-options="{
                                &quot;target&quot;: &quot;#usersExportDropdown&quot;,
                                &quot;type&quot;: &quot;css-animation&quot;
                            }"
                            data-hs-unfold-target="#usersExportDropdown" data-hs-unfold-invoker="">
                            <i class="tio-download-to mr-1"></i> <?php echo e(translate('export')); ?>

                        </a>

                        <div id="usersExportDropdown"
                            class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right hs-unfold-content-initialized hs-unfold-css-animation animated hs-unfold-reverse-y hs-unfold-hidden">

                            <span class="dropdown-header"><?php echo e(translate('download_options')); ?></span>
                            <a id="export-excel" class="dropdown-item" href="<?php echo e(route('admin.transactions.report.expense-export', ['export_type'=>'excel',request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                    alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item" href="<?php echo e(route('admin.transactions.report.expense-export', ['export_type'=>'csv',request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                    alt="Image Description">
                                .<?php echo e(translate('messages.csv')); ?>

                            </a>
                        </div>
                    </div>
                    <!-- Static Export Button -->
                </div>
            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-borderless middle-align __txt-14px">
                        <thead class="thead-light white--space-false">
                            <tr>
                                <th class="border-0"><?php echo e(translate('sl')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.order_id')); ?></th>
                                <?php if(addon_published_status('Rental')): ?>
                                <th class="border-0"><?php echo e(translate('trip_id')); ?></th>
                                <?php endif; ?>
                                <th class="border-0"><?php echo e(translate('Date & Time')); ?></th>
                                <th class="border-0"><?php echo e(translate('Expense Type')); ?></th>
                                <th class="text-center" ><?php echo e(translate('Customer Name')); ?></th>
                                <th class="border-0 text-right pr-xl-5">
                                    <div class="pr-xl-5">
                                        <?php echo e(translate('expense amount')); ?>

                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="set-rows">
                            <?php $__currentLoopData = $expense; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td scope="row"><?php echo e($key+$expense->firstItem()); ?></td>
                                <td>
                                    <?php if($exp->order): ?>

                                    <div>
                                        <a class="text-dark" href="<?php echo e(route('admin.order.details', ['id' => $exp->order->id,'module_id'=>$exp->order->module_id])); ?>"><?php echo e($exp['order_id']); ?></a>
                                    </div>
                                    <?php else: ?>
                                    <label class="badge badge-primary"><?php echo e(translate('messages.Other_Expenses')); ?></label>
                                    <?php endif; ?>
                                </td>
                                <?php if(addon_published_status('Rental')): ?>
                                <td>
                                    <?php if($exp->trip): ?>

                                    <div>
                                        <a class="text-dark" href="<?php echo e(route('admin.rental.trip.details', $exp->trip->id)); ?>"><?php echo e($exp['trip_id']); ?></a>
                                    </div>
                                    <?php else: ?>
                                    <label class="badge badge-primary"><?php echo e(translate('messages.Other_Expenses')); ?></label>
                                    <?php endif; ?>
                                </td>
                                <?php endif; ?>
                                <td>
                                    <?php echo e(date('Y-m-d '.config('timeformat'),strtotime($exp->created_at))); ?>

                                </td>
                                <td><label><?php echo e(ucwords(translate("messages.{$exp['type']}"))); ?></label></td>
                                <td class="text-center">
                                    <?php if($exp->order): ?>

                                    <?php if($exp->order?->is_guest): ?>
                                    <?php ($customer_details = json_decode($exp->order['delivery_address'],true)); ?>
                                    <strong><?php echo e($customer_details['contact_person_name']); ?></strong>

                                    <?php elseif($exp->order?->customer): ?>

                                    <?php echo e($exp->order?->customer['f_name'].' '.$exp->order?->customer['l_name']); ?>

                                    <?php else: ?>
                                        <label
                                            class="badge badge-danger"><?php echo e(translate('messages.invalid_customer_data')); ?></label>
                                    <?php endif; ?>

                                    <?php elseif($exp->trip): ?>
                                    <?php if($exp?->trip?->customer): ?>

                                        <?php echo e($exp?->trip?->customer?->fullName); ?>


                                        <?php elseif($exp?->trip?->user_info['contact_person_name']): ?>
                                            <div class="font-medium">
                                                <?php echo e($exp?->trip?->user_info['contact_person_name']); ?>

                                            </div>
                                        <?php else: ?>
                                            <?php echo e(translate('messages.Guest_user')); ?>

                                        <?php endif; ?>


                                    <?php elseif($exp['type'] == 'add_fund_bonus'): ?>
                                    <?php echo e($exp->user->f_name.' '.$exp->user->l_name); ?>

                                    <?php else: ?>
                                    <label class="badge badge-danger"><?php echo e(translate('messages.invalid_customer_data')); ?></label>

                                    <?php endif; ?>
                                </td>
                                <td class="text-right pr-xl-5">
                                    <div class="pr-xl-5">
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($exp['amount'])); ?>

                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <!-- End Table -->


                <?php if(count($expense) !== 0): ?>
                    <hr>
                    <div class="page-area">
                        <?php echo $expense->withQueryString()->links(); ?>

                    </div>
                <?php endif; ?>
                <?php if(count($expense) === 0): ?>
                    <div class="empty--data">
                        <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                        <h5>
                            <?php echo e(translate('no_data_found')); ?>

                        </h5>
                    </div>
                <?php endif; ?>
            </div>
            <!-- End Body -->
        </div>
        <!-- End Card -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chartjs-chart-matrix/dist/chartjs-chart-matrix.min.js">
    </script>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/hs.chartjs-matrix.js"></script>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/admin-reports.js"></script>
    <script>
        "use strict";
        $(document).on('ready', function() {
            $('.js-data-example-ajax').select2({
                ajax: {
                    url: '<?php echo e(url('/')); ?>/admin/store/get-stores',
                    data: function(params) {
                        return {
                            q: params.term, // search term
                            // all:true,
                            <?php if(isset($zone)): ?>
                                zone_ids: [<?php echo e($zone->id); ?>],
                            <?php endif; ?>
                            <?php if(request('module_id')): ?>
                                module_id: <?php echo e(request('module_id')); ?>,
                            <?php endif; ?>
                            page: params.page
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    __port: function(params, success, failure) {
                        let $request = $.ajax(params);

                        $request.then(success);
                        $request.fail(failure);

                        return $request;
                    }
                }
            });

            $('.js-data-example-ajax-2').select2({
                ajax: {
                    url: '<?php echo e(url('/')); ?>/admin/customer/select-list',
                    data: function(params) {
                        return {
                            q: params.term, // search term
                            // all:true,
                            <?php if(isset($zone)): ?>
                                zone_ids: [<?php echo e($zone->id); ?>],
                            <?php endif; ?>
                            <?php if(request('module_id')): ?>
                                module_id: <?php echo e(request('module_id')); ?>,
                            <?php endif; ?>
                            <?php if(request('store_id')): ?>
                                store_id: <?php echo e(request('store_id')); ?>,
                            <?php endif; ?>
                            page: params.page
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    __port: function(params, success, failure) {
                        let $request = $.ajax(params);

                        $request.then(success);
                        $request.fail(failure);

                        return $request;
                    }
                }
            });
        });

        $('#search-form').on('submit', function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '<?php echo e(route('admin.transactions.report.expense-report-search')); ?>',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('#countItems').html(data.count);
                    $('.page-area').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/report/expense-report.blade.php ENDPATH**/ ?>