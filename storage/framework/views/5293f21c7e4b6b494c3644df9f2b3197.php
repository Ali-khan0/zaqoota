<?php $__env->startSection('title', translate('Provider Report')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="content container-fluid">
        <?php
            $from = session('from_date');
            $to = session('to_date');
        ?>

        <!-- Page Header -->
        <div class="page-header report-page-header">
            <div class="d-flex">
                <img src="<?php echo e(asset('public/assets/admin/img/store-report.svg')); ?>" class="page-header-icon" alt="">
                <div class="w-0 flex-grow-1 pl-3">
                    <h1 class="page-header-title m-0">
                        <?php echo e(translate('Provider Report')); ?>

                    </h1>
                    <span>
                        <?php echo e(translate('Monitor_provider’s_business_analytics_&_Reports')); ?>

                    </span>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Page Header Menu -->
        <ul class="nav nav-tabs page-header-tabs mb-2">
            <li class="nav-item">
                <a href="<?php echo e(route('admin.transactions.rental.report.provider-summary-report')); ?>" class="nav-link"><?php echo e(translate('Summary Report')); ?></a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(route('admin.transactions.rental.report.provider-sales-report')); ?>" class="nav-link active"><?php echo e(translate('Vehicle Report')); ?></a>
            </li>
            <li class="nav-item">
                <a href="<?php echo e(route('admin.transactions.rental.report.provider-trip-report')); ?>" class="nav-link"><?php echo e(translate('Trip Report')); ?></a>
            </li>
        </ul>

        <div class="card filter--card">
            <div class="card-body p-xl-5">
                <h5 class="form-label m-0 mb-3">
                    <?php echo e(translate('Filter Data')); ?>

                </h5>
                <form action="<?php echo e(route('admin.transactions.rental.report.set-date')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="row g-3">
                        <div class="col-md-4 col-sm-6">
                            <select name="zone_id" class="form-control js-select2-custom set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="zone_id" id="zone">
                                <option value="all"><?php echo e(translate('messages.All_Zones')); ?></option>
                                <?php $__currentLoopData = \App\Models\Zone::orderBy('name')->get(['id','name']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($z['id']); ?>"
                                        <?php echo e(isset($zone) && $zone->id == $z['id'] ? 'selected' : ''); ?>>
                                        <?php echo e($z['name']); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <select name="provider_id" data-get-provider-url="<?php echo e(route('admin.store.get-providers')); ?>"
                                    data-zone-id="<?php echo e(isset($zone) ? $zone->id : ''); ?>"
                                    data-placeholder="<?php echo e(translate('messages.select_provider')); ?>"
                                    class="js-data-example-ajax form-control set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="provider_id">
                                <?php if(isset($provider)): ?>
                                    <option value="<?php echo e($provider->id); ?>" selected><?php echo e($provider->name); ?></option>
                                <?php else: ?>
                                    <option value="all" selected><?php echo e(translate('messages.all_providers')); ?></option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <select class="form-control set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="filter" name="filter">
                                <option value="all_time" <?php echo e(isset($filter) && $filter == 'all_time' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.All Time')); ?></option>
                                <option value="this_year" <?php echo e(isset($filter) && $filter == 'this_year' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.This Year')); ?></option>
                                <option value="previous_year"
                                    <?php echo e(isset($filter) && $filter == 'previous_year' ? 'selected' : ''); ?>><?php echo e(translate('messages.Previous Year')); ?>

                                </option>
                                <option value="this_month"
                                    <?php echo e(isset($filter) && $filter == 'this_month' ? 'selected' : ''); ?>><?php echo e(translate('messages.This Month')); ?></option>
                                <option value="this_week" <?php echo e(isset($filter) && $filter == 'this_week' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.This Week')); ?></option>
                                <option value="custom" <?php echo e(isset($filter) && $filter == 'custom' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('Custom')); ?></option>
                            </select>
                        </div>
                        <?php if(isset($filter) && $filter == 'custom'): ?>
                        <div class="col-md-4 col-sm-6">
                            <input type="date" name="from" id="from_date"
                                <?php echo e(session()->has('from_date') ? 'value=' . session('from_date') : ''); ?>

                                class="form-control" required>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <input type="date" name="to" id="to_date"
                                <?php echo e(session()->has('to_date') ? 'value=' . session('to_date') : ''); ?> class="form-control"
                                required>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <button type="submit" class="btn btn--primary btn-block"><?php echo e(translate('show_data')); ?></button>
                        </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>


        <div class="store-report-content mt-11px">
            <div class="left-content">
                <div class="left-content-card">
                    <img src="<?php echo e(asset('/public/assets/admin/img/report/gross.svg')); ?>" alt="">
                    <div class="info">
                        <h4 class="subtitle">
                            <?php echo e(\App\CentralLogics\Helpers::number_format_short($trips->sum('trip_amount'))); ?></h4>
                        <h6 class="subtext"><?php echo e(translate('Total Trip Amount')); ?></h6>
                    </div>
                </div>
                <div class="left-content-card">
                    <img src="<?php echo e(asset('/public/assets/admin/img/report/tax.svg')); ?>" alt="">
                    <div class="info">
                        <h4 class="subtitle">
                            <?php echo e(\App\CentralLogics\Helpers::number_format_short($trips->sum('tax_amount'))); ?></h4>
                        <h6 class="subtext"><?php echo e(translate('Total Tax')); ?></h6>
                    </div>
                </div>
                <div class="left-content-card">
                    <img src="<?php echo e(asset('/public/assets/admin/img/report/commission.svg')); ?>" alt="">
                    <div class="info">
                        <h4 class="subtitle">
                            <?php echo e(\App\CentralLogics\Helpers::number_format_short($trips->sum('trip_transaction_sum_admin_commission')-$trips->sum('trip_transaction_sum_admin_expense'))); ?>

                        </h4>
                        <h6 class="subtext"><?php echo e(translate('Total Commission')); ?></h6>
                    </div>
                </div>
            </div>
            <div class="center-chart-area">
                <div class="center-chart-header">
                    <h4 class="title"><?php echo e(translate('Total Trip')); ?></h4>
                    <h5 class="subtitle"><?php echo e(translate('Average Trip Value :')); ?>

                        <?php echo e($trips->count() > 0 ? \App\CentralLogics\Helpers::number_format_short($trips->sum('trip_amount') / $trips->count()) : 0); ?>

                        <span class="input-label-secondary text--title" data-toggle="tooltip"
                    data-placement="right"
                    data-original-title="<?php echo e(translate('This Average Trip Value is calculated from all completed trips')); ?>">
                    <i class="tio-info-outined"></i>
                </span>
                    </h5>
                </div>


                <canvas id="updatingData" class="store-center-chart"
                    data-chart-labels='[<?php echo e(implode(",",$label)); ?>]'
                    data-chart-data='[<?php echo e(implode(",",$data)); ?>]'
                    data-chart-currency-symbol="<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>">
                </canvas>

            </div>
            <div class="right-content">
                <!-- Dognut Pie -->
                <div class="card h-100 bg-white payment-statistics-shadow">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="earning-statistics-content">
                            <h6 class="subtitle"><?php echo e(translate('Total Provider Earnings')); ?></h6>
                            <h3 class="title">
                                <?php echo e(\App\CentralLogics\Helpers::number_format_short($trips->sum('trip_transaction_sum_store_amount'))); ?>

                            </h3>
                        </div>
                    </div>
                </div>
                <!-- Dognut Pie -->
            </div>
        </div>

        <div class="mt-11px card">
            <div class="card-header border-0 py-2">
                <div class="search--button-wrapper">
                    <h5 class="card-title"><?php echo e(translate('Total Trips')); ?></h5>
                    <form class="search-form">
                        <!-- Search -->
                        
                        <div class="input-group input--group">
                            <input id="datatableSearch_" type="search" name="search" class="form-control"
                                placeholder="<?php echo e(translate('Search by vehicle..')); ?>"
                                aria-label="<?php echo e(translate('messages.search')); ?>" value="<?php echo e(request()?->search ?? null); ?>" required>
                            <button type="button" class="btn btn--secondary"><i class="tio-search"></i></button>

                        </div>
                        <!-- End Search -->
                    </form>
                    <!-- Unfold -->
                    <div class="hs-unfold mr-2">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle min-height-40"
                            href="javascript:;"
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
                                href="<?php echo e(route('admin.transactions.rental.report.provider-sales-report-export', ['type' => 'excel', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                    alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item"
                                href="<?php echo e(route('admin.transactions.rental.report.provider-sales-report-export', ['type' => 'csv', request()->getQueryString()])); ?>">
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
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <thead class="thead-light white--space-false">
                            <tr>
                                <th class="border-top border-bottom text-capitalize"><?php echo e(translate('SL')); ?></th>
                                <th class="border-top border-bottom text-capitalize"><?php echo e(translate('Vehicle Info')); ?></th>
                                <th class="border-top border-bottom text-capitalize text-center"><?php echo e(translate('Total Trip')); ?></th>
                                <th class="border-top border-bottom text-capitalize text-center">
                                    <?php echo e(translate('Total Trip Amount')); ?></th>
                                <th class="border-top border-bottom text-capitalize text-center">
                                    <?php echo e(translate('Discount Given')); ?></th>
                                <th class="border-top border-bottom text-capitalize text-center"><?php echo e(translate('Action')); ?>

                                </th>
                            </tr>
                        </thead>
                        <tbody id="set-rows">

                            <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key + $vehicles->firstItem()); ?></td>
                                    <td>
                                        <a class="media align-vehicle-center"
                                            href="<?php echo e(route('admin.rental.provider.vehicle.details', $vehicle->id)); ?>">
                                            <div class="media-body">
                                                <h5 class="text-hover-primary mb-0"><?php echo e($vehicle['name']); ?></h5>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <?php echo e($vehicle->trips_count ?? 0); ?>

                                    </td>
                                    <td class="text-center">
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($vehicle->trips_sum_price)); ?>

                                    </td>
                                    <td class="text-center">
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($vehicle->total_discount)); ?>

                                    </td>
                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a href="<?php echo e(route('admin.rental.provider.vehicle.details', $vehicle->id)); ?>"
                                                class="action-btn btn--primary btn-outline-primary">
                                                <i class="tio-invisible"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <?php if(count($vehicles) !== 0): ?>
                        <hr>
                        <div class="page-area">
                            <?php echo $vehicles->withQueryString()->links(); ?>

                        </div>
                    <?php endif; ?>
                    <?php if(count($vehicles) === 0): ?>
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

    <?php $__env->stopSection(); ?>


    <?php $__env->startPush('script'); ?>
    <?php $__env->stopPush(); ?>


    <?php $__env->startPush('script_2'); ?>
        <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chart.js/dist/Chart.min.js"></script>
        <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chart.js.extensions/chartjs-extensions.js"></script>
        <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js"> </script>
        <script src="<?php echo e(asset('Modules/Rental/public/assets/js/admin/view-pages/provider-sales-report.js')); ?>"></script>

    <?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/report/provider-sales-report.blade.php ENDPATH**/ ?>