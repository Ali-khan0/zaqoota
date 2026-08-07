<?php $__env->startSection('title', translate('Provider Tax Report')); ?>

<?php $__env->startSection('provider_tax_report'); ?>
    active
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">


        <!--- Provider Tax Report -->
        <h2 class="mb-20"><?php echo e(translate('Provider Tax Report')); ?></h3>
            <div class="card p-20 mb-20">
                <form action="" method="get">
                    <div class="row g-lg-4 g-3 align-items-end">
                        <div class="col-lg-4 col-md-6">
                            <label class="form-label"><?php echo e(translate('Date Range')); ?></label>
                            <div class="position-relative">
                                <?php
                                    $dataRange = Carbon\Carbon::parse($startDate)->format('m/d/Y') . ' - ' . Carbon\Carbon::parse($endDate)->format('m/d/Y');
                                ?>
                                <i class="tio-calendar-month icon-absolute-on-right"></i>
                                <input type="text" data-title="<?php echo e(translate('Select_Date_Range')); ?>" name="dates" value="<?php echo e($dataRange  ?? null); ?>" class="date-range-picker form-control">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <span class="mb-2 d-block title-clr fw-normal"><?php echo e(translate('Select Provider')); ?></span>
                            


                            <select name="provider_id" data-placeholder="<?php echo e(translate('messages.select_provider')); ?>"
                                data-get-provider-url="<?php echo e(route('admin.store.get-providers')); ?>"
                                data-zone-id="<?php echo e(isset($zone) ? $zone->id : ''); ?>"
                                data-module-id="<?php echo e(request('module_id') ?? ''); ?>" class="js-data-example-ajax form-control "
                                data-url="<?php echo e(url()->full()); ?>" data-filter="provider_id">
                                <?php if(isset($store)): ?>
                                    <option value="<?php echo e($store->id); ?>" selected><?php echo e($store->name); ?></option>
                                <?php else: ?>
                                    <option value="all" selected><?php echo e(translate('messages.all_providers')); ?></option>
                                <?php endif; ?>
                            </select>


                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="d-flex justify-content-end">
                                <button type="submit"
                                    class="btn min-w-135px btn--primary"><?php echo e(translate('Filter')); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card p-20 mb-20">
                <div class="row g-lg-4 g-3">
                    <div class="col-md-6 col-xl-4">
                        <div
                            class="bg--secondary rounded p-15 d-flex align-items-center justify-content-between gap-2 flex-wrap">
                            <div class="d-flex align-items-center gap-2 font-semibold title-clr">
                                <img src="<?php echo e(asset('/public/assets/admin/img/t-total-order.png')); ?>" alt="img">
                                <?php echo e(translate('Total Orders')); ?>

                            </div>
                            <h3 class="theme-clr fw-bold mb-0"><?php echo e($totalOrders); ?></h3>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div
                            class="bg--secondary rounded p-15 d-flex align-items-center justify-content-between gap-2 flex-wrap">
                            <div class="d-flex align-items-center gap-2 font-semibold title-clr">
                                <img src="<?php echo e(asset('/public/assets/admin/img/t-toal-amount.png')); ?>" alt="img">
                                <?php echo e(translate('Total Order Amount')); ?>

                            </div>
                            <h3 class="text-success fw-bold mb-0">
                                <?php echo e(\App\CentralLogics\Helpers::format_currency($totalOrderAmount)); ?></h3>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div
                            class="bg--secondary rounded p-15 d-flex align-items-center justify-content-between gap-2 flex-wrap">
                            <div class="d-flex align-items-center gap-2 font-semibold title-clr">
                                <img src="<?php echo e(asset('/public/assets/admin/img/t-tax-amount.png')); ?>" alt="img">
                                <?php echo e(translate('Total Tax Amount')); ?>

                            </div>
                            <h3 class="text-danger fw-bold mb-0">
                                <?php echo e(\App\CentralLogics\Helpers::format_currency($totalTax)); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <!--- Provider Tax Report Here -->
            <div class="card p-20 mt-5">
                <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap mb-20">
                    <h4 class="mb-0"><?php echo e(translate('All Provider Taxes')); ?></h4>
                    <div class="search--button-wrapper justify-content-end">
                        <form class="search-form min--260">
                            <div class="input-group input--group">
                                <input id="datatableSearch_" type="search" name="search" class="form-control h--40px"
                                    placeholder="<?php echo e(translate('messages.Ex: Name')); ?> "
                                    value="<?php echo e(request()?->search ?? null); ?>"
                                    aria-label="<?php echo e(translate('messages.search')); ?>">
                                    <input type="hidden" name="dates" value="<?php echo e($dateRange); ?>">
                                <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                            </div>
                        </form>

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
                            "target": "#usersExportDropdown", "type": "css-animation" }'>
                                <i class="tio-download-to mr-1"></i> <?php echo e(translate('messages.export')); ?>

                            </a>
                            <div id="usersExportDropdown"
                                class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                                <span class="dropdown-header"><?php echo e(translate('messages.download_options')); ?></span>
                                <a id="export-excel" class="dropdown-item"
                                    href="<?php echo e(route('admin.transactions.rental.report.providerWiseTaxExport', ['export_type' => 'excel', request()->getQueryString()])); ?>">
                                    <img class="avatar avatar-xss avatar-4by3 mr-2"
                                        src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                        alt="Image Description">
                                    <?php echo e(translate('messages.excel')); ?>

                                </a>
                                <a id="export-csv" class="dropdown-item"
                                    href="<?php echo e(route('admin.transactions.rental.report.providerWiseTaxExport', ['export_type' => 'csv', request()->getQueryString()])); ?>">
                                    <img class="avatar avatar-xss avatar-4by3 mr-2"
                                        src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                        alt="Image Description">
                                    .<?php echo e(translate('messages.csv')); ?>

                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Table -->
                <div class="table-responsive datatable-custom">
                    <table id="datatable"
                        class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table fz--14px">
                        <thead class="thead-light">
                            <tr>
                                <th class="border-0"><?php echo e(translate('sl')); ?></th>
                                <th class="border-0"><?php echo e(translate('Provider Info')); ?></th>
                                <th class="border-0"><?php echo e(translate('Total Trips')); ?></th>
                                <th class="border-0"><?php echo e(translate('Total Trip Amount')); ?></th>
                                <th class="border-0"><?php echo e(translate('Tax Amount')); ?></th>
                                <th class="border-0 text-end"><?php echo e(translate('Action')); ?></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php echo e($key + $stores->firstItem()); ?>

                                    </td>
                                    <td>
                                        <span class="fz-14 title-clr">
                                            <a href="<?php echo e(route('admin.rental.provider.details', $store->store_id)); ?>" target="_blank"
                                                rel="noopener noreferrer"> <?php echo e($store->store_name); ?></a>

                                            <span class="fz-11 d-block"> <a href="tel:<?php echo e($store->store_phone); ?>">
                                                    <?php echo e($store->store_phone); ?></a></span>
                                        </span>
                                    </td>
                                    <td>
                                        <?php echo e($store->total_orders); ?>

                                    </td>
                                    <td>
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($store->total_order_amount)); ?>

                                    </td>
                                    <td>
                                        <?php ($sum_tax_amount=collect($store->tax_data)->sum('total_tax_amount')); ?>

                                        <div class="d-flex flex-column gap-1">
                                            <?php if($store->store_total_tax_amount - $sum_tax_amount> 0 ): ?>

                                            <div class="d-flex fz-14 gap-3 align-items-center title-clr">
                                                <?php echo e(translate('Tax Amount:')); ?> <span>
                                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($store->store_total_tax_amount - $sum_tax_amount)); ?></span>
                                            </div>
                                            <?php endif; ?>
                                            <?php if($sum_tax_amount > 0 ): ?>
                                                <div class="d-flex fz-14 gap-3 align-items-center title-clr">
                                                    <?php echo e(translate('Sum of Taxes:')); ?> <span>
                                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($sum_tax_amount)); ?></span>
                                                </div>
                                                <?php $__currentLoopData = $store->tax_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="d-flex fz-11 gap-3 align-items-center">
                                                        <?php echo e($tax['tax_name']); ?>:
                                                        <span><?php echo e(\App\CentralLogics\Helpers::format_currency($tax['total_tax_amount'])); ?>

                                                    </span>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex gap-2 justify-content-end">
                                            <a class="btn btn-sm btn--primary action-btn btn-outline-primary" target="_blank"
                                                href="<?php echo e(route('admin.transactions.rental.report.providerTax', ['id' => $store->store_id, 'dates' => $dateRange])); ?>">
                                                <i class="tio-invisible"></i>
                                            </a>
                                            <a class="btn btn-sm action-btn success-border btn-outline-varify text-success"
                                                href="<?php echo e(route('admin.transactions.rental.report.providerTaxExport', ['export_type' => 'excel', 'id' => $store->store_id, request()->getQueryString()])); ?>">
                                                <svg width="11" height="12" viewBox="0 0 11 12" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.87499 4.31958H7.37499V0.56958H3.625V4.31958H1.125L5.5 9.31957L9.87499 4.31958ZM0.5 10.5696H10.5V11.8196H0.5V10.5696Z"
                                                        fill="#04BB7B" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                    </table>
                </div>
                <!-- End Table -->
                <?php if(count($stores) !== 0): ?>
                    <hr>
                <?php endif; ?>
                <div class="page-area">
                    <?php echo $stores->links(); ?>

                </div>
                <?php if(count($stores) === 0): ?>
                    <div class="empty--data">
                        <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                        <h5>
                            <?php echo e(translate('no_data_found')); ?>

                        </h5>
                    </div>
                <?php endif; ?>
            </div>
            <!--- Provider Tax Details Page -->
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('Modules/Rental/public/assets/js/admin/view-pages/provider-tax-report.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/report/tax-report/provider-tax-report.blade.php ENDPATH**/ ?>