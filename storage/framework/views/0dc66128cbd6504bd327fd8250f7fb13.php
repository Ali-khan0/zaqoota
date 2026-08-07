<?php $__env->startSection('title', translate('messages.transaction_report')); ?>

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
                    <?php echo e(translate('messages.transection_report')); ?>

                    <?php if(isset($filter) && $filter != 'all_time'): ?>
                        <span class="mb-0 h6 badge badge-soft-success ml-2" id="itemCount">( <?php echo e(session('from_date')); ?> -
                            <?php echo e(session('to_date')); ?> )</span>
                    <?php endif; ?>
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
                            <select name="zone_id" class="form-control js-select2-custom set-filter"
                                data-url="<?php echo e(url()->full()); ?>" data-filter="zone_id" id="zone">
                                <option value="all"><?php echo e(translate('messages.All_Zones')); ?></option>
                                <?php $__currentLoopData = \App\Models\Zone::orderBy('name')->get(['id', 'name']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($z['id']); ?>"
                                        <?php echo e(isset($zone) && $zone->id == $z['id'] ? 'selected' : ''); ?>>
                                        <?php echo e($z['name']); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <select name="provider_id"
                                 data-get-provider-url="<?php echo e(route('admin.store.get-providers')); ?>"
                                    data-zone-id="<?php echo e(isset($zone) ? $zone->id : ''); ?>"
                                data-module-id="<?php echo e(request('module_id') ?? ''); ?>"

                            data-url="<?php echo e(url()->full()); ?>" data-filter="provider_id"
                                data-placeholder="<?php echo e(translate('messages.select_provider')); ?>"
                                class="js-data-example-ajax form-control set-filter">
                                <?php if(isset($provider)): ?>
                                    <option value="<?php echo e($provider->id); ?>" selected><?php echo e($provider->name); ?></option>
                                <?php else: ?>
                                    <option value="all" selected><?php echo e(translate('messages.all_providers')); ?></option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="col-sm-6 col-md-3">
                            <select class="form-control set-filter" name="filter" data-url="<?php echo e(url()->full()); ?>"
                                data-filter="filter">
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
        <div class="mb-20">
            <div class="row g-3">
                <div class="col-lg-12">
                    <div class="row g-2">
                        <div class="col-sm-4">
                            <a class="__card-3 h-100" href="#">
                                <img src="<?php echo e(asset('/public/assets/admin/img/report/new/trx1.png')); ?>" class="icon"
                                    alt="report/new">
                                <h3 class="title text-008958">
                                    <?php echo e(\App\CentralLogics\Helpers::number_format_short($totalAmount)); ?>

                                </h3>
                                <h6 class="subtitle"><?php echo e(translate('Completed Transaction')); ?></h6>
                                <div class="info-icon" data-toggle="tooltip" data-placement="top"
                                    data-original-title="<?php echo e(translate('After a successful trip completion, the full Trip amount goes to this section.')); ?>">
                                    <img src="<?php echo e(asset('/public/assets/admin/img/report/new/info1.png')); ?>"
                                        alt="report/new">
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-4">
                            <a class="__card-3 h-100" href="#">
                                <img src="<?php echo e(asset('/public/assets/admin/img/report/new/trx7.png')); ?>" class="icon"
                                    alt="report/new">
                                <h3 class="title text-006AE5">
                                    <?php echo e(\App\CentralLogics\Helpers::number_format_short($adminEarned)); ?>

                                </h3>
                                <h6 class="subtitle"><?php echo e(translate('Admin Earning')); ?></h6>
                                <div class="info-icon" data-toggle="tooltip" data-placement="top"
                                    data-original-title="<?php echo e(translate('After a successful trip completion, the admin commission and service fee will be added to the admin\'s earnings.')); ?>">
                                    <img src="<?php echo e(asset('/public/assets/admin/img/report/new/info2.png')); ?>"
                                        alt="report/new">
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-4">
                            <a class="__card-3 h-100" href="#">
                                <img src="<?php echo e(asset('/public/assets/admin/img/report/new/trx6.png')); ?>" class="icon"
                                    alt="report/new">
                                <h3 class="title text-success">
                                    <?php echo e(\App\CentralLogics\Helpers::number_format_short($providerEarned)); ?>

                                </h3>
                                <h6 class="subtitle"><?php echo e(translate('Provider Earning')); ?></h6>
                                <div class="info-icon" data-toggle="tooltip" data-placement="top"
                                    data-original-title="<?php echo e(translate('After a successful trip completion, the trip amount without discount will be added to the provider’s earnings')); ?>">
                                    <img src="<?php echo e(asset('/public/assets/admin/img/report/new/info1.png')); ?>"
                                        alt="report/new">
                                </div>
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
                        <?php echo e(translate('messages.trip_transactions')); ?> <span class="badge badge-soft-secondary"
                            id="countItems"><?php echo e($tripTransactions->total()); ?></span>
                    </h3>
                    <form>
                        <!-- Search -->
                        <div class="input--group input-group ">
                            <input  class="form-control" placeholder="<?php echo e(translate('Search by Trip ID')); ?>"
                                value="<?php echo e(request()?->search ?? null); ?>" type="search" name="search">
                            <button class="btn btn--secondary"><i class="tio-search"></i></button>
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
                                href="<?php echo e(route('admin.transactions.rental.report.transaction-report-export', ['type' => 'excel', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin/svg/components/excel.svg')); ?>"
                                    alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item"
                                href="<?php echo e(route('admin.transactions.rental.report.transaction-report-export', ['type' => 'csv', request()->getQueryString()])); ?>">
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
                    <table id="datatable" class="table table-thead-bordered table-align-middle card-table">
                        <thead class="thead-light">
                            <tr>
                                <th class="border-0"><?php echo e(translate('sl')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.trip_id')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.provider')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.customer')); ?></th>
                                <th class="border-0 min-w-120"><?php echo e(translate('messages.Total_Trip_Amount')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Discount on Vehicle')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Coupon_Discount')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Referral_Discount')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Total Discounted Amount')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.vat/tax')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Admin_Commission')); ?></th>
                                <th class="border-0">
                                    <?php echo e(\App\CentralLogics\Helpers::get_business_data('additional_charge_name') ?? translate('messages.additional_charge')); ?>

                                </th>
                                <th class="border-0"><?php echo e(translate('messages.Admin_Discount')); ?></th>
                                <th class="min-w-140 text-capitalize"><?php echo e(translate('Admin_net_income')); ?></th>
                                <th class="border-0 text-capitalize"><?php echo e(translate('messages.provider_discount')); ?></th>
                                <th class="min-w-140 text-capitalize"><?php echo e(translate('provider_net_income')); ?></th>
                                <th class="border-0 min-w-120 text-capitalize"><?php echo e(translate('messages.Total Amount Received by')); ?></th>
                                <th class="border-top border-bottom text-capitalize">
                                    <?php echo e(translate('messages.payment_method')); ?></th>
                                <th class="border-0 text-capitalize"><?php echo e(translate('messages.payment_status')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.action')); ?></th>
                            </tr>
                        </thead>
                        <tbody id="set-rows">
                            <?php $__currentLoopData = $tripTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $ot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr scope="row">
                                    <td><?php echo e($k + $tripTransactions->firstItem()); ?></td>
                                    <td><a
                                            href="<?php echo e(route('admin.transactions.rental.trip.details', $ot->trip_id)); ?>"><?php echo e($ot->trip_id); ?></a>
                                    </td>
                                    <td class="text-capitalize">
                                        <?php echo e(Str::limit($ot?->trip?->provider?->name ?? translate('messages.Not Found'), 25, '...')); ?>

                                    </td>
                                    <td class="white-space-nowrap">
                                        <?php if($ot->trip->customer): ?>
                                            <a class="text-body text-capitalize"
                                                href="<?php echo e(route('admin.users.customer.view', [$ot->trip['user_id']])); ?>">
                                                <strong><?php echo e($ot->trip?->customer?->f_name . ' ' . $ot->trip?->customer?->l_name); ?></strong>
                                            </a>
                                        <?php elseif($ot->trip?->user_info['contact_person_name']): ?>
                                            <a class="text-body text-capitalize" href="#">
                                                <strong><?php echo e($ot->trip?->user_info['contact_person_name']); ?></strong>
                                            </a>
                                        <?php else: ?>
                                            <?php echo e(translate('messages.Guest_user')); ?>

                                        <?php endif; ?>

                                    </td>
                                    
                                    <td class="white-space-nowrap">
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($ot->trip_amount)); ?></td>

                                    
                                    <td class="white-space-nowrap">
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($ot->trip->discount_on_trip)); ?></td>

                                    
                                    <td class="white-space-nowrap">
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($ot->trip['coupon_discount_amount'])); ?>

                                    </td>
                                    
                                    <td class="white-space-nowrap">
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($ot->trip['ref_bonus_amount'])); ?>

                                    </td>
                                    
                                    <td class="white-space-nowrap">
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($ot->trip['coupon_discount_amount'] + $ot->trip['ref_bonus_amount'] + $ot->trip->discount_on_trip)); ?>

                                    </td>

                                    <td class="white-space-nowrap">
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($ot->tax)); ?></td>

                                    
                                    <td class="white-space-nowrap">
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($ot->admin_commission)); ?></td>


                                    <td class="white-space-nowrap">
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($ot->additional_charge)); ?></td>
                                    
                                    <td class="white-space-nowrap">
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($ot->admin_expense)); ?></td>


                                    
                                    <td class="white-space-nowrap">
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($ot->admin_net_income)); ?></td>
                                    
                                    <td class="white-space-nowrap">
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($ot->store_expense)); ?></td>
                                    
                                    <td class="white-space-nowrap">
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($ot->store_amount - $ot->tax)); ?>

                                    </td>
                                    <?php if($ot->received_by == 'admin'): ?>
                                        <td class="text-capitalize white-space-nowrap"><?php echo e(translate('messages.admin')); ?>

                                        </td>
                                    <?php elseif($ot->received_by == 'vendor'): ?>
                                        <td class="text-capitalize white-space-nowrap">
                                            <?php echo e(translate('messages.provider')); ?></td>
                                    <?php endif; ?>
                                    <td class="mw--85px text-capitalize min-w-120 ">
                                        <?php echo e(translate(str_replace('_', ' ', $ot->trip['payment_method']))); ?>

                                    </td>
                                    <td class="text-capitalize white-space-nowrap">
                                        <span class="badge badge-soft-success">
                                            <?php echo e(translate('messages.completed')); ?>

                                        </span>
                                    </td>

                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a class="btn btn-outline-success square-btn btn-sm mr-1 action-btn"
                                                href="<?php echo e(route('admin.transactions.rental.report.generate-statement', [$ot['id']])); ?>">
                                                <i class="tio-download-to"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <!-- End Body -->
                    <?php if(count($tripTransactions) !== 0): ?>
                        <hr>
                    <?php endif; ?>
                    <div class="page-area">
                        <?php echo $tripTransactions->links(); ?>

                    </div>
                    <?php if(count($tripTransactions) === 0): ?>
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
    <script src="<?php echo e(asset('Modules/Rental/public/assets/js/admin/view-pages/transaction-report.js')); ?>"></script>


<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/report/transaction-report.blade.php ENDPATH**/ ?>