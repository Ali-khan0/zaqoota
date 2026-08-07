<?php $__env->startSection('title', translate('messages.expense_report')); ?>

<?php $__env->startPush('css_or_js'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $vendorData = \App\CentralLogics\Helpers::get_store_data();
        $vendor = $vendorData?->module_type;
        $title = $vendor == 'rental' ? 'Provider' : 'Store';
        $orderOrTrip = $vendor == 'rental' ? 'trip' : 'order';
        $type = $vendor == 'rental' ? 'vehicle' : 'item';
    ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    
                </span>
                <span>
                    <?php echo e(translate('messages.expense_report')); ?>

                </span>
            </h1>
            <div class="__page-header-txt mt-3">
                <?php echo e(translate('This report will show all the '.$orderOrTrip.' in which the '.$title.' discount has been used. The '.$title.' discounts are: Free delivery, Coupon discount & '.$type.' discounts(partial according to '.$orderOrTrip.' commission).')); ?>

            </div>

        </div>
        <!-- End Page Header -->

        <div class="card mb-20">
            <div class="card-body">
                <h4 class=""><?php echo e(translate('Search Data')); ?></h4>
                <form method="get">
                    <div class="row g-3">
                        <div class="col-sm-6 col-md-3">
                            <select class="form-control set-filter" name="filter"
                                    data-url="<?php echo e(url()->full()); ?>" data-filter="filter">
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
                                    value=<?php echo e($from ? $from  : ''); ?> required>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <input type="date" name="to" id="to_date" class="form-control"
                                    placeholder="<?php echo e(translate('End Date')); ?>"
                                    value=<?php echo e($to ? $to  : ''); ?>  required>
                            </div>
                        <?php endif; ?>
                        <div class="col-sm-6 col-md-3 ml-auto">
                            <button type="submit"
                                class="btn btn-primary btn-block h--45px"><?php echo e(translate('Filter')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Stats -->
        <!-- Card -->
        <div class="card mt-3">
            <!-- Header -->
            <div class="card-header border-0 py-2">
                <div class="search--button-wrapper">
                    <h3 class="card-title">
                        <?php echo e(translate('messages.expense_lists')); ?> <span
                            class="badge badge-soft-secondary" id="countItems"><?php echo e($expense->total()); ?></span>
                    </h3>
                    <form  class="search-form">
                        <!-- Search -->
                        <div class="input--group input-group input-group-merge input-group-flush">
                            <input name="search" value="<?php echo e(request()->search ?? null); ?>"   type="search" class="form-control" placeholder="<?php echo e(translate('Search by Order ID')); ?>">
                            <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                        </div>
                        <!-- End Search -->
                    </form>
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
                            <a id="export-excel" class="dropdown-item" href="<?php echo e(route('vendor.report.expense-export', ['type'=>'excel',request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                    alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item" href="<?php echo e(route('vendor.report.expense-export', ['type'=>'csv',request()->getQueryString()])); ?>">
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
                                <th ><?php echo e(translate('sl')); ?></th>
                                <?php if($module_type == 'rental'): ?>
                                <th class="text-center" ><?php echo e(translate('trip_id')); ?></th>
                                <?php else: ?>
                                <th class="text-center" ><?php echo e(translate('messages.order_id')); ?></th>
                                <?php endif; ?>
                                <th class="text-center" ><?php echo e(translate('Date & Time')); ?></th>
                                <th class="text-center" ><?php echo e(translate('Expense Type')); ?></th>
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
                                <?php if($module_type == 'rental'): ?>
                                    <td class="text-center" >
                                        <?php if(isset($exp['trip_id'])): ?>
                                            <a href="<?php echo e(route('vendor.trip.details',['id'=>$exp['trip_id']])); ?>"><?php echo e($exp['trip_id']); ?></a>
                                        <?php else: ?>
                                            <label class="badge badge-danger"><?php echo e(translate('messages.invalid_trip_data')); ?></label>
                                        <?php endif; ?>
                                    </td>
                                <?php else: ?>
                                    <td class="text-center" >
                                        <?php if(isset($exp['order_id'])): ?>
                                            <a href="<?php echo e(route('vendor.order.details',['id'=>$exp['order_id']])); ?>"><?php echo e($exp['order_id']); ?></a>
                                        <?php else: ?>
                                            <label class="badge badge-danger"><?php echo e(translate('messages.invalid_order_data')); ?></label>
                                        <?php endif; ?>
                                    </td>
                                <?php endif; ?>
                                <td class="text-center">
                                    <?php echo e(date('Y-m-d '.config('timeformat'),strtotime($exp->created_at))); ?>

                                </td>
                                <td class="text-center" >
                                    <?php echo e(Str::title(translate("messages.{$exp['type']}"))); ?></td>




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
            </div>            <!-- End Body -->
        </div>
        <!-- End Card -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/vendor/report.js"></script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/report/expense-report.blade.php ENDPATH**/ ?>