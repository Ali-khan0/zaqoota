<?php $__env->startSection('title', translate('messages.trip_report')); ?>

<?php $__env->startPush('css_or_js'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('/public/assets/admin/img/report/report.png')); ?>" class="w--22" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.trip_report')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->

        <div class="card mb-20">
            <div class="card-body">
                <h4 class=""><?php echo e(translate('Search Data')); ?></h4>
                <form action="<?php echo e(route('admin.transactions.rental.report.set-date')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="row g-3">
                        <div class="col-sm-6 col-md-3">
                            <select name="zone_id" class="form-control js-select2-custom set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="zone_id" id="zone">
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
                            <select name="provider_id"
                                data-placeholder="<?php echo e(translate('messages.select_provider')); ?>"
                                data-get-provider-url="<?php echo e(route('admin.store.get-providers')); ?>"
                                data-zone-id="<?php echo e(isset($zone) ? $zone->id : ''); ?>"
                                data-module-id="<?php echo e(request('module_id') ?? ''); ?>"

                                class="js-data-example-ajax form-control set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="provider_id">
                                <?php if(isset($provider)): ?>
                                    <option value="<?php echo e($provider->id); ?>" selected><?php echo e($provider->name); ?></option>
                                <?php else: ?>
                                    <option value="all" selected><?php echo e(translate('messages.all_providers')); ?></option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <select name="customer_id"
                                data-get-provider-url="<?php echo e(route('admin.customer.select-list')); ?>"
                                data-zone-id="<?php echo e(isset($zone) ? $zone->id : ''); ?>"
                                data-module-id="<?php echo e(request('module_id') ?? ''); ?>"
                                data-provider-id="<?php echo e(isset($provider) ? $provider->id : ''); ?>"
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
                            <select class="form-control set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="filter" name="filter">
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
                            <button type="submit"
                                class="btn btn-primary btn-block h--45px"><?php echo e(translate('Filter')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php
            $from = session('from_date') . ' 00:00:00';
            $to = session('to_date') . ' 23:59:59';
        ?>
        <div class="mb-20">
            <div class="row g-4">
                <div class="col-lg-4">
                    <a class="__card-1 h-100" href="#">
                        <img src="<?php echo e(asset('/public/assets/admin/img/report/new/total.png')); ?>" class="icon" alt="report/new">
                        <h3 class="title"><?php echo e($trips->total()); ?></h3>
                        <h6 class="subtitle"><?php echo e(translate('messages.total_trips')); ?></h6>
                    </a>
                </div>
                <div class="col-lg-8">
                    <div class="row g-3">
                        <div class="col-sm-6 col-md-6">
                            <a class="__card-2 __bg-1" href="#">
                            <h4 class="title"><?php echo e($total_progress_count); ?></h4>
                            <span class="subtitle"><?php echo e(translate('messages.in_progress_trips')); ?> <span data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('This count includes all the pending & confirmed trips')); ?>"><img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="<?php echo e(translate('messages.in_progress_trips')); ?>"></span></span>
                            <img src="<?php echo e(asset('/public/assets/admin/img/report/new/progress-report.png')); ?>" alt="report/new" class="card-icon">
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <a class="__card-2 __bg-2" href="#">
                            <h4 class="title"><?php echo e($total_ongoing_count); ?></h4>
                            <span class="subtitle"><?php echo e(translate('messages.ongoing_trips')); ?></span>
                            <img src="<?php echo e(asset('/public/assets/admin/img/report/new/on-the-way.png')); ?>" alt="report/new" class="card-icon">
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <a class="__card-2 __bg-3" href="#">
                            <h4 class="title"><?php echo e($total_completed_count); ?></h4>
                            <span class="subtitle"><?php echo e(translate('messages.completed_trips')); ?></span>
                            <img src="<?php echo e(asset('/public/assets/admin/img/report/new/delivered.png')); ?>" alt="report/new" class="card-icon">
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <a class="__card-2 __bg-6" href="#">
                            <h4 class="title"><?php echo e($total_canceled_count); ?></h4>
                            <span class="subtitle"><?php echo e(translate('messages.canceled_trips')); ?></span>
                            <img src="<?php echo e(asset('/public/assets/admin/img/report/new/canceled.png')); ?>" alt="report/new" class="card-icon">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- End Stats -->
        <!-- Card -->
        <div class="card mt-3">
            <!-- Header -->
            <div class="card-header border-0 py-2">
                <div class="search--button-wrapper">
                    <h3 class="card-title">
                        <?php echo e(translate('messages.Total Trips')); ?> <span
                            class="badge badge-soft-secondary" id="countItems"><?php echo e($trips->total()); ?></span>
                    </h3>
                    <form class="search-form">
                        <!-- Search -->
                        <div class="input--group input-group input-group-merge input-group-flush">
                            <input name="search" type="search" class="form-control" value="<?php echo e(request()->query('search')); ?>" placeholder="<?php echo e(translate('Search by Trip ID')); ?>">
                            <button type="button" class="btn btn--secondary"><i class="tio-search"></i></button>
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
                            <a id="export-excel" class="dropdown-item"
                                href="<?php echo e(route('admin.transactions.rental.report.trip-report-export', ['type' => 'excel', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin/svg/components/excel.svg')); ?>"
                                    alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item"
                                href="<?php echo e(route('admin.transactions.rental.report.trip-report-export', ['type' => 'csv', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin/svg/components/placeholder-csv-format.svg')); ?>"
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
                                <th class="text-capitalize border-top border-bottom"><?php echo e(translate('messages.sl')); ?></th>
                                <th class="text-capitalize border-top border-bottom"><?php echo e(translate('messages.trip_id')); ?></th>
                                <th class="text-capitalize border-top border-bottom"><?php echo e(translate('messages.Provider info')); ?></th>
                                <th class="text-capitalize border-top border-bottom"><?php echo e(translate('messages.Customer info')); ?></th>
                                <th class="text-capitalize border-top border-bottom"><?php echo e(translate('messages.Total Fare of Vehicle')); ?></th>
                                <th class="text-capitalize border-top border-bottom"><?php echo e(translate('messages.Discount on Vehicle')); ?></th>
                                <th class="text-capitalize border-top border-bottom"><?php echo e(translate('messages.coupon_discount')); ?></th>
                                <th class="text-capitalize border-top border-bottom"><?php echo e(translate('messages.referral_discount')); ?></th>
                                <th class="text-capitalize border-top border-bottom"><?php echo e(translate('messages.Total_discounted_amount')); ?></th>
                                <th class="text-capitalize border-top border-bottom text-center"><?php echo e(translate('messages.tax')); ?></th>
                                <th class="text-capitalize border-top border-bottom text-center"><?php echo e(\App\CentralLogics\Helpers::get_business_data('additional_charge_name')??translate('messages.additional_charge')); ?></th>
                                <th class="text-capitalize border-top border-bottom"><?php echo e(translate('messages.Total Trip Amount')); ?></th>
                                <th class="text-capitalize border-top border-bottom"><?php echo e(translate('messages.Total Amount Received By')); ?></th>
                                <th class="text-capitalize border-top border-bottom"><?php echo e(translate('messages.payment_method')); ?></th>
                                <th class="text-capitalize border-top border-bottom"><?php echo e(translate('messages.Trip Status')); ?></th>
                                <th class="text-capitalize border-top border-bottom text-center"><?php echo e(translate('messages.action')); ?>

                                </th>
                            </tr>
                        </thead>
                        <tbody id="set-rows">
                            <?php $__currentLoopData = $trips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="status-<?php echo e($trip['trip_status']); ?> class-all">
                                    <td class="">
                                        <?php echo e($key + $trips->firstItem()); ?>

                                    </td>
                                    <td class="table-column-pl-0">
                                        <a
                                            href="<?php echo e(route('admin.rental.trip.details', $trip->id)); ?>"><?php echo e($trip['id']); ?></a>
                                    </td>
                                    <td  class="text-capitalize">
                                        <?php if($trip->provider): ?>
                                            <?php echo e(Str::limit($trip->provider->name,25,'...')); ?>

                                        <?php else: ?>
                                            <label class="badge badge-danger"><?php echo e(translate('messages.invalid')); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($trip->is_guest): ?>
                                        <?php ($customer_details = $trip['user_info']); ?>
                                        <strong><?php echo e($customer_details['contact_person_name']); ?></strong>
                                        <div><?php echo e($customer_details['contact_person_number']); ?></div>

                                        <?php elseif($trip->customer): ?>
                                        <a class="text-body text-capitalize"
                                            href="<?php echo e(route('admin.users.customer.view', [$trip['user_id']])); ?>">
                                            <strong><?php echo e($trip->customer['f_name'] . ' ' . $trip->customer['l_name']); ?></strong>
                                        </a>
                                        <?php else: ?>
                                            <label class="badge badge-danger"><?php echo e(translate('messages.invalid_customer_data')); ?></label>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="text-right mw--85px">
                                            <div>
                                                <?php echo e(\App\CentralLogics\Helpers::number_format_short(($trip['trip_amount']+$trip['coupon_discount_amount'] + $trip['discount_on_trip'] + $trip['ref_bonus_amount']) - ($trip->additional_charge + $trip['tax_amount']) )); ?>

                                            </div>
                                            <?php if($trip->payment_status == 'paid'): ?>
                                                <strong class="text-success">
                                                    <?php echo e(translate('messages.paid')); ?>

                                                </strong>
                                            <?php else: ?>
                                                <strong class="text-danger">
                                                    <?php echo e(translate('messages.unpaid')); ?>

                                                </strong>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="text-center mw--85px">
                                        <?php echo e(\App\CentralLogics\Helpers::number_format_short( $trip['discount_on_trip'] )); ?>

                                    </td>
                                    <td class="text-center mw--85px">
                                        <?php echo e(\App\CentralLogics\Helpers::number_format_short($trip['coupon_discount_amount'])); ?>

                                    </td>
                                    <td class="text-center mw--85px">
                                        <?php echo e(\App\CentralLogics\Helpers::number_format_short($trip['ref_bonus_amount'])); ?>

                                    </td>
                                    <td class="text-center mw--85px">
                                        <?php echo e(\App\CentralLogics\Helpers::number_format_short($trip['coupon_discount_amount'] + $trip['discount_on_trip'] + $trip['ref_bonus_amount'])); ?>

                                    </td>
                                    <td class="text-center mw--85px white-space-nowrap">
                                        <?php echo e(\App\CentralLogics\Helpers::number_format_short($trip['tax_amount'])); ?>

                                    </td>
                                    <td class="text-center mw--85px">
                                        <?php echo e(\App\CentralLogics\Helpers::number_format_short($trip['additional_charge'])); ?>

                                    </td>
                                    <td>
                                        <div class="text-right mw--85px">
                                            <div>
                                                <?php echo e(\App\CentralLogics\Helpers::number_format_short($trip['trip_amount'])); ?>

                                            </div>
                                            <?php if($trip->payment_status == 'paid'): ?>
                                                <strong class="text-success">
                                                    <?php echo e(translate('messages.paid')); ?>

                                                </strong>
                                            <?php else: ?>
                                                <strong class="text-danger">
                                                    <?php echo e(translate('messages.unpaid')); ?>

                                                </strong>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="text-center mw--85px text-capitalize">
                                        <?php echo e(isset($trip->trip_transaction) ? $trip->trip_transaction->received_by : translate('messages.not_received_yet')); ?>

                                    </td>
                                    <td class="text-center mw--85px text-capitalize">
                                            <?php echo e(translate(str_replace('_', ' ', $trip['payment_method']))); ?>

                                    </td>
                                    <td class="text-center mw--85px text-capitalize">
                                        <?php if($trip['trip_status']=='pending'): ?>
                                                <span class="badge badge-soft-info">
                                                  <?php echo e(translate('messages.pending')); ?>

                                                </span>
                                            <?php elseif($trip['trip_status']=='confirmed'): ?>
                                                <span class="badge badge-soft-info">
                                                  <?php echo e(translate('messages.confirmed')); ?>

                                                </span>
                                            <?php elseif($trip['trip_status']=='ongoing'): ?>
                                                <span class="badge badge-soft-warning">
                                                  <?php echo e(translate('messages.ongoing')); ?>

                                                </span>
                                            <?php elseif($trip['trip_status']=='picked_up'): ?>
                                                <span class="badge badge-soft-warning">
                                                  <?php echo e(translate('messages.out_for_delivery')); ?>

                                                </span>
                                            <?php elseif($trip['trip_status']=='completed'): ?>
                                                <span class="badge badge-soft-success">
                                                  <?php echo e(translate('messages.completed')); ?>

                                                </span>
                                            <?php elseif($trip['trip_status']=='failed'): ?>
                                                <span class="badge badge-soft-danger">
                                                  <?php echo e(translate('messages.payment_failed')); ?>

                                                </span>
                                            <?php elseif($trip['trip_status']=='handover'): ?>
                                                <span class="badge badge-soft-danger">
                                                  <?php echo e(translate('messages.handover')); ?>

                                                </span>
                                            <?php elseif($trip['trip_status']=='canceled'): ?>
                                                <span class="badge badge-soft-danger">
                                                  <?php echo e(translate('messages.canceled')); ?>

                                                </span>
                                            <?php elseif($trip['trip_status']=='accepted'): ?>
                                                <span class="badge badge-soft-danger">
                                                  <?php echo e(translate('messages.accepted')); ?>

                                                </span>
                                            <?php elseif($trip['trip_status']=='refund_request_canceled'): ?>
                                                <span class="badge badge-soft-danger">
                                                  <?php echo e(translate('messages.refund_request_canceled')); ?>

                                                </span>
                                            <?php else: ?>
                                                <span class="badge badge-soft-danger">
                                                  <?php echo e(str_replace('_',' ',$trip['trip_status'])); ?>

                                                </span>
                                            <?php endif; ?>

                                    </td>


                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a class="ml-2 btn btn-sm btn--warning btn-outline-warning action-btn"
                                                href="<?php echo e(route('admin.rental.trip.details', $trip->id)); ?>">
                                                <i class="tio-invisible"></i>
                                            </a>
                                            <a class="ml-2 btn btn-sm btn--primary btn-outline-primary action-btn"
                                                href="<?php echo e(route('admin.transactions.rental.trip.generate-invoice', ['id' => $trip['id']])); ?>">
                                                <i class="tio-print"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <?php if(count($trips) !== 0): ?>
                        <hr>
                    <?php endif; ?>
                    <div class="page-area">
                        <?php echo $trips->links(); ?>

                    </div>
                    <?php if(count($trips) === 0): ?>
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
    <script src="<?php echo e(asset('Modules/Rental/public/assets/js/admin/view-pages/trip-report.js')); ?>"></script>

<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/report/trip-report.blade.php ENDPATH**/ ?>