<?php $__env->startSection('title', translate('Admin Tax Report')); ?>

<?php $__env->startSection('tax_report'); ?>
    active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">


        <!--- Admin Tax Report -->
        <h2 class="mb-20"><?php echo e(translate('messages.Admin Tax Report')); ?></h3>
            <!--- Tax Details Page -->
            <h2 class="mb-20 mt-5"><?php echo e(translate('messages.Tax Details')); ?></h2>
            <div class="bg--secondary rounded p-20">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-15">
                    <div>
                        <h5 class="mb-1"><?php echo e(translate($taxSource)); ?> <?php echo e(translate('Taxes')); ?></h5>
                        <p class="fz-12px mb-0"><?php echo e(translate('Date:')); ?> <?php echo e($startDate); ?> - <?php echo e($endDate); ?></p>
                    </div>
                    <div class="hs-unfold mr-2 hungar-export">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-primary dropdown-toggle h--40px" href="javascript:;"
                            data-hs-unfold-options='{
                        "target": "#usersExportDropdown4", "type": "css-animation" }'>
                            <i class="tio-download-to mr-1"></i> <?php echo e(translate('messages.export')); ?>

                        </a>
                        <div id="usersExportDropdown4"
                            class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                            <span class="dropdown-header"><?php echo e(translate('messages.download_options')); ?></span>
                            <a id="export-excel" class="dropdown-item" href="<?php echo e(route('admin.transactions.report.getTaxDetailsExport',['source'=> $taxSource ,'export_type' => 'excel', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                    alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item" href="<?php echo e(route('admin.transactions.report.getTaxDetailsExport',['source'=> $taxSource ,'export_type' => 'excel', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                    alt="Image Description">
                                .<?php echo e(translate('messages.csv')); ?>

                            </a>
                        </div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="bg-white p-12 w-100 rounded d-flex align-items-center justify-content-between">
                            <?php echo e(translate('Total_Transactions')); ?> <h4 class="theme-clr fw-bold mb-0"><?php echo e($total_count); ?>

                            </h4>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-white p-12 w-100 rounded d-flex align-items-center justify-content-between">
                            <?php echo e(translate('Total_Amount')); ?> <h4 class="theme-clr fw-bold mb-0">
                                <?php echo e(\App\CentralLogics\Helpers::format_currency($total_amount)); ?></h4>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-white p-12 w-100 rounded d-flex align-items-center justify-content-between">
                            <?php echo e(translate('Total Tax Percentage')); ?> <h4 class="cus-warning-light-clr fw-bold mb-0">
                                <?php echo e($total_tax_rate); ?> %</h4>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-white p-12 w-100 rounded d-flex align-items-center justify-content-between">
                            <?php echo e(translate('Total Tax Amount')); ?> <h4 class="cus-warning-clr fw-bold mb-0">
                                <?php echo e(\App\CentralLogics\Helpers::format_currency($total_tax_amount)); ?></h4>
                        </div>
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
                                <th class="border-0"><?php echo e(translate('Transaction ID')); ?></th>
                                <th class="border-0"><?php echo e(translate('Amount')); ?></th>
                                <th class="border-0"><?php echo e(translate('Tax Amount')); ?></th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php $__currentLoopData = $taxData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php echo e($key + $taxData->firstItem()); ?>

                                    </td>
                                    <td>
                                        <?php echo e($item->id); ?>

                                    </td>
                                    <td>
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($item->paid_amount)); ?>

                                    </td>

                                    <td>
                                        <?php
                                            $taxSummary = collect($item['calculated_taxes']);
                                            $totalTaxRate = $taxSummary->sum('tax_rate');
                                            $totalTaxAmount = $taxSummary->sum('tax_amount');
                                        ?>

                                        <div class="d-flex flex-column gap-1">
                                            <div class="d-flex fz-14 gap-3 align-items-center title-clr">
                                                <?php echo e(translate('Total')); ?> (<?php echo e($totalTaxRate); ?>%):
                                                <span>
                                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($totalTaxAmount)); ?></span>
                                            </div>

                                            <?php $__currentLoopData = $item['calculated_taxes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxItems): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="d-flex fz-11 gap-3 align-items-center">
                                                    <?php echo e($taxItems['tax_name']); ?> (<?php echo e($taxItems['tax_rate']); ?>%) :
                                                    <span><?php echo e(\App\CentralLogics\Helpers::format_currency($taxItems['tax_amount'])); ?></span>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                    </table>
                </div>

                <?php if(count($taxData) !== 0): ?>
                    <hr>
                <?php endif; ?>
                <div class="page-area">
                    <?php echo $taxData->withQueryString()->links(); ?>

                </div>
                <?php if(count($taxData) === 0): ?>
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

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/report/tax-report/admin-subscription-tax-report-details.blade.php ENDPATH**/ ?>