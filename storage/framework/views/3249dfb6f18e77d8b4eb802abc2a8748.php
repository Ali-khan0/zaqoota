<?php $__env->startSection('title',$store->name."'s ".translate('messages.transactions')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <!-- Custom styles for this page -->
    <link href="<?php echo e(asset('public/assets/admin/css/croppie.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <?php echo $__env->make('admin-views.vendor.view.partials._header',['store'=>$store], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="card">
        <div class="card-header border-0 py-2">
            <div class="search--button-wrapper">
                <ul class="nav nav-tabs mr-auto transaction--table-nav">
                    <li class="nav-item">
                        <?php ($account_transaction = \App\Models\AccountTransaction::where('from_type', 'store')->where('type', 'collected')->where('from_id', $store->id)->count()); ?>
                        <?php ($account_transaction = isset($account_transaction) ? $account_transaction : 0); ?>
                        <a class="nav-link text-capitalize <?php echo e($sub_tab=='cash'?'active':''); ?>" href="<?php echo e(route('admin.store.view', ['store'=>$store->id, 'tab'=> 'transaction', 'sub_tab'=>'cash'])); ?>"  aria-disabled="true"><?php echo e(translate('cash_transaction')); ?> (<?php echo e($account_transaction); ?>)</a>
                    </li>
                    <li class="nav-item">
                        <?php ($digital_transaction = \App\Models\OrderTransaction::where('vendor_id', $store->vendor->id)->count()); ?>
                        <?php ($digital_transaction = isset($digital_transaction) ? $digital_transaction : 0); ?>
                        <a class="nav-link text-capitalize <?php echo e($sub_tab=='digital'?'active':''); ?>" href="<?php echo e(route('admin.store.view', ['store'=>$store->id, 'tab'=> 'transaction', 'sub_tab'=>'digital'])); ?>"  aria-disabled="true"><?php echo e(translate('order_transactions')); ?> (<?php echo e($digital_transaction); ?>)</a>
                    </li>
                    <li class="nav-item">
                        <?php ($withdraw_transaction = \App\Models\WithdrawRequest::where('vendor_id',$store->vendor->id)->count()); ?>
                        <?php ($withdraw_transaction = isset($withdraw_transaction) ? $withdraw_transaction : 0); ?>
                        <a class="nav-link text-capitalize <?php echo e($sub_tab=='withdraw'?'active':''); ?>" href="<?php echo e(route('admin.store.view', ['store'=>$store->id, 'tab'=> 'transaction', 'sub_tab'=>'withdraw'])); ?>"  aria-disabled="true"><?php echo e(translate('withdraw_transactions')); ?> (<?php echo e($withdraw_transaction); ?>)</a>
                    </li>
                </ul>
                <!-- Unfold -->
                <div class="hs-unfold mr-2">
                    <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle h--40px" href="javascript:;"
                        data-hs-unfold-options='{
                            "target": "#usersExportDropdown",
                            "type": "css-animation"
                        }'>
                        <i class="tio-download-to mr-1"></i> <?php echo e(translate('messages.export')); ?>

                    </a>

                    <div id="usersExportDropdown"
                            class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                        <span class="dropdown-header"><?php echo e(translate('messages.download_options')); ?></span>
                        <?php if($sub_tab=='cash'): ?>
                        <a id="export-excel" class="dropdown-item" href="<?php echo e(route('admin.store.cash_export', ['type'=>'excel', 'store_id'=>$store->id])); ?>">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                    alt="Image Description">
                            <?php echo e(translate('messages.excel')); ?>

                        </a>
                        <a id="export-csv" class="dropdown-item" href="<?php echo e(route('admin.store.cash_export', ['type'=>'csv', 'store_id'=>$store->id])); ?>">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                    alt="Image Description">
                            .<?php echo e(translate('messages.csv')); ?>

                        </a>
                        <?php elseif($sub_tab=='digital'): ?>
                        <a id="export-excel" class="dropdown-item" href="<?php echo e(route('admin.store.order_export', ['type'=>'excel', 'store_id'=>$store->id])); ?>">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                    alt="Image Description">
                            <?php echo e(translate('messages.excel')); ?>

                        </a>
                        <a id="export-csv" class="dropdown-item" href="<?php echo e(route('admin.store.order_export', ['type'=>'csv', 'store_id'=>$store->id])); ?>">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                    alt="Image Description">
                            .<?php echo e(translate('messages.csv')); ?>

                        </a>
                        <?php elseif($sub_tab=='withdraw'): ?>
                        <a id="export-excel" class="dropdown-item" href="<?php echo e(route('admin.store.withdraw_trans_export', ['type'=>'excel', 'store_id'=>$store->id])); ?>">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                    alt="Image Description">
                            <?php echo e(translate('messages.excel')); ?>

                        </a>
                        <a id="export-csv" class="dropdown-item" href="<?php echo e(route('admin.store.withdraw_trans_export', ['type'=>'csv', 'store_id'=>$store->id])); ?>">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                    alt="Image Description">
                            .<?php echo e(translate('messages.csv')); ?>

                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- End Unfold -->
            </div>
        </div>
        <div class="card-body p-0">

        <?php if($sub_tab=='cash'): ?>
            <?php echo $__env->make('admin-views.vendor.view.partials.cash_transaction', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php elseif($sub_tab=='digital'): ?>
            <?php echo $__env->make('admin-views.vendor.view.partials.digital_transaction', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php elseif($sub_tab=='withdraw'): ?>
            <?php echo $__env->make('admin-views.vendor.view.partials.withdraw_transaction', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <!-- Page level plugins -->
    <script>
        "use strict";
        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();
            // INITIALIZATION OF DATATABLES
            // =======================================================
            let datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

            $('#column1_search').on('keyup', function () {
                datatable
                    .columns(1)
                    .search(this.value)
                    .draw();
            });

            $('#column2_search').on('keyup', function () {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });

            $('#column3_search').on('change', function () {
                datatable
                    .columns(3)
                    .search(this.value)
                    .draw();
            });

            $('#column4_search').on('keyup', function () {
                datatable
                    .columns(4)
                    .search(this.value)
                    .draw();
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                let select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/vendor/view/transaction.blade.php ENDPATH**/ ?>