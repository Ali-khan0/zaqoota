<?php $__env->startSection('title', translate('Provider Tax Report')); ?>

<?php $__env->startSection('provider_tax_report'); ?>
    active
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!--- Provider Tax Details Page -->
        <h2 class="mb-20 mt-5"><?php echo e(translate('Provider Tax Report')); ?></h3>
            <div class="bg--secondary rounded p-20">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-15">
                    <div>
                        <h5 class="mb-1"><?php echo e($store->name); ?></h3>
                            <p class="fz-12px mb-0"><?php echo e(translate('messages.Date')); ?>: <?php echo e($startDate); ?> -
                                <?php echo e($endDate); ?></p>
                    </div>
                    <div class="hs-unfold mr-2 hungar-export">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-primary dropdown-toggle h--40px" href="javascript:;"
                            data-hs-unfold-options='{
                        "target": "#usersExportDropdown2", "type": "css-animation" }'>
                            <i class="tio-download-to mr-1"></i> <?php echo e(translate('messages.export')); ?>

                        </a>
                        <div id="usersExportDropdown2"
                            class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                            <span class="dropdown-header"><?php echo e(translate('messages.download_options')); ?></span>
                            <a id="export-excel" class="dropdown-item"
                                href="<?php echo e(route('admin.transactions.rental.report.providerTaxExport', ['export_type' => 'excel', 'id' => $store->store_id, request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                    alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item"
                                href="<?php echo e(route('admin.transactions.rental.report.providerTaxExport', ['export_type' => 'csv', 'id' => $store->store_id, request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                    alt="Image Description">
                                <?php echo e(translate('messages.csv')); ?>

                            </a>
                        </div>
                    </div>
                </div>
                <div
                    class="text-capitalize d-flex align-items-center gap-3 justify-content-between flex-md-nowrap flex-wrap">
                    <div class="bg-white p-12 w-100 rounded d-flex align-items-center justify-content-between">
                        <?php echo e(translate('messages.total_order_amount')); ?> <span
                            class="title-clr"><?php echo e(\App\CentralLogics\Helpers::format_currency($totalOrderAmount)); ?></span>
                    </div>
                    <div
                        class="text-capitalize bg-white p-12 w-100 rounded d-flex align-items-center justify-content-between">
                        <?php echo e(translate('messages.total_tax_amount')); ?> <span class="title-clr">
                            <?php echo e(\App\CentralLogics\Helpers::format_currency($totalTax)); ?></span>
                    </div>
                </div>
            </div>
            <div class="card p-20 mt-5">
                <div class="table-responsive datatable-custom">
                    <table id="datatable"
                        class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table fz--14px">
                        <thead class="thead-light">
                            <tr>
                                <th class="border-0"><?php echo e(translate('sl')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Trip_id')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Trip_amount')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.tax_type')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.tax_amount')); ?></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php echo e($key + $orders->firstItem()); ?>

                                    </td>
                                    <td>

                                        <a  href="<?php echo e(route('admin.rental.trip.details', [$order['id']])); ?>">
                                            #<?php echo e($order->id); ?></a>

                                    </td>
                                    <td>
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($order->trip_amount)); ?>

                                    </td>
                                    <td>
                                        <?php echo e(translate('trip_wise')); ?>

                                    </td>
                                    <td>
                                        <div class="d-flex flex-column gap-1">
                                            <?php if(count($order->orderTaxes) > 0): ?>
                                                <?php ($sum_tax_amount = collect($order->orderTaxes)->sum('tax_amount')); ?>
                                                <div class="d-flex fz-14 gap-3 align-items-center title-clr">
                                                    <?php echo e(translate('Sum of Taxes:')); ?> <span>
                                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($sum_tax_amount)); ?></span>
                                                </div>

                                                <?php $__currentLoopData = $order->orderTaxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="d-flex fz-11 gap-3 align-items-center">
                                                        <?php echo e($tax['tax_name']); ?>:
                                                        <span><?php echo e(\App\CentralLogics\Helpers::format_currency($tax['tax_amount'])); ?>

                                                    </span>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                <div class="d-flex fz-14 gap-3 align-items-center title-clr">
                                                    <?php echo e(translate('Tax Amount:')); ?> <span>
                                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($order->tax_amount)); ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                    </table>
                </div>
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
                <!-- End Table -->
            </div>
    </div>



<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/report/tax-report/provider-tax-detail-report.blade.php ENDPATH**/ ?>