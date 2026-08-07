<?php $__env->startSection('title', translate('Parcel Tax Report')); ?>

<?php $__env->startSection('parcel_tax_report'); ?>
    active
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">


        <!--- Vendor Tax Report -->
        <h2 class="mb-20"><?php echo e(translate('Parcel Tax Report')); ?></h3>
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
                            <div class="d-flex justify-content-start">
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
            <!--- Vendor Tax Report Here -->
            <div class="card p-20 mt-5">
                <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap mb-20">
                    <h4 class="mb-0"><?php echo e(translate('All Taxes')); ?></h4>
                    <div class="search--button-wrapper justify-content-end">
                        <div class="hs-unfold mr-2">
                            <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle h--40px" href="javascript:;"
                                data-hs-unfold-options='{
                            "target": "#usersExportDropdown", "type": "css-animation" }'>
                                <i class="tio-download-to mr-1"></i> <?php echo e(translate('messages.export')); ?>

                            </a>
                            <div id="usersExportDropdown"
                                class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                                <span class="dropdown-header"><?php echo e(translate('messages.download_options')); ?></span>
                                <a id="export-excel" class="dropdown-item" href="<?php echo e(route('admin.transactions.report.parcel-wise-tax-export', ['export_type' => 'excel', request()->getQueryString()])); ?>">
                                    <img class="avatar avatar-xss avatar-4by3 mr-2"
                                        src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                        alt="Image Description">
                                    <?php echo e(translate('messages.excel')); ?>

                                </a>
                                <a id="export-csv" class="dropdown-item" href="<?php echo e(route('admin.transactions.report.parcel-wise-tax-export', ['export_type' => 'csv', request()->getQueryString()])); ?>">
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
                                <th class="border-0"><?php echo e(translate('Order Id')); ?></th>
                                <th class="border-0"><?php echo e(translate('Total Order Amount')); ?></th>
                                <th class="border-0"><?php echo e(translate('Tax Amount')); ?></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php echo e($key + $orders->firstItem()); ?>

                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.parcel.order.details', ['id' => $order['id']])); ?>"><?php echo e($order->id); ?></a>
                                    </td>
                                    <td>
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($order->order_amount)); ?>

                                    </td>
                                    <td>
                                        <?php
                                        if ($order?->tax_type == 'category_wise') {
                                            $tax_type = 'category_tax';
                                        } elseif ($order?->tax_type == 'product_wise') {
                                            $tax_type = 'product_tax';
                                        } else {
                                            $tax_type = 'order_wise';
                                        }

                                        $taxLabels = [
                                            'basic' => translate($tax_type),
                                            'tax_on_packaging_charge' => translate('Packaging Charge'),
                                        ];

                                        $groupedByTaxOn = $order->orderTaxes->groupBy('tax_on');
                                        $totalTaxAmount = $order->orderTaxes->sum('tax_amount');
                                        ?>

                                        <div class="d-flex flex-column gap-1">
                                            <?php if(count($order->orderTaxes) > 0): ?>
                                                <div class="fw-bold">
                                                    <?php echo e(translate('Total Tax')); ?>:
                                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($totalTaxAmount)); ?>

                                                </div>

                                                <?php $__currentLoopData = $groupedByTaxOn; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxOn => $taxGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if(isset($taxLabels[$taxOn])): ?>
                                                        <div class="mt-2 text-capitalize fw-semibold">
                                                            <?php echo e($taxLabels[$taxOn]); ?>:</div>

                                                        <?php

                                                            $taxByName = $taxGroup
                                                                ->groupBy('tax_name')
                                                                ->map(function ($group) {
                                                                    return $group->sum('tax_amount');
                                                                });
                                                        ?>

                                                        <?php $__currentLoopData = $taxByName; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $amount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="d-flex fz-11 gap-3 align-items-center">
                                                                <span><?php echo e($name); ?></span>
                                                                <span><?php echo e(\App\CentralLogics\Helpers::format_currency($amount)); ?></span>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                <div class="d-flex fz-14 gap-3 align-items-center title-clr">
                                                    <?php echo e(translate('Tax Amount:')); ?> <span>
                                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($order->total_tax_amount)); ?></span>
                                                </div>
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
            <!--- Vendor Tax Details Page -->
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script>
        "use strict";

        $(document).on('ready', function() {
            $('.js-data-example-ajax').select2({
                ajax: {
                    url: '<?php echo e(url('/')); ?>/admin/store/get-stores',
                    data: function(params) {
                        return {
                            q: params.term, // search term
                            all: true,

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
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/report/tax-report/parcel-tax-report.blade.php ENDPATH**/ ?>