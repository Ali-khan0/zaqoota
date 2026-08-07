<?php $__env->startSection('title',translate('messages.deliverymen_earning_provide')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <!-- Page Heading -->
    <div class="page-header">
        <h1 class="page-header-title">
            <span class="page-header-icon">
                <img src="<?php echo e(asset('public/assets/admin/img/report.png')); ?>" class="w--22" alt="">
            </span>
            <span>
                <?php echo e(translate('messages.provide_deliverymen_earning')); ?>

            </span>
        </h1>
    </div>
    <!-- Page Heading -->
    <div class="card">
        <div class="card-body">
            <form action="<?php echo e(route('admin.transactions.provide-deliveryman-earnings.store')); ?>" method='post' id="add_transaction">
                <?php echo csrf_field(); ?>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="form-group mb-0">
                            <label class="form-label" for="deliveryman"><?php echo e(translate('messages.deliveryman')); ?><span class="input-label-secondary"></span></label>
                            <select id="deliveryman" name="deliveryman_id" data-placeholder="<?php echo e(translate('messages.select_deliveryman')); ?>" data-url="<?php echo e(url('/')); ?>/admin/users/delivery-man/get-account-data/" data-type="deliveryman" class="form-control account-data" title="Select deliveryman">

                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group mb-0">
                            <label class="form-label" for="amount"><?php echo e(translate('messages.amount')); ?><span class="input-label-secondary" id="account_info"></span></label>
                            <input class="form-control" type="number" min="1" step="0.01" name="amount" id="amount" max="999999999999.99" placeholder="<?php echo e(translate('ex_100')); ?>">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group mb-0">
                            <label class="form-label" for="method"><?php echo e(translate('messages.method')); ?><span class="input-label-secondary"></span></label>
                            <input class="form-control" type="text" name="method" id="method" required maxlength="191" placeholder="<?php echo e(translate('ex_cash')); ?>">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group mb-0">
                            <label class="form-label" for="ref"><?php echo e(translate('messages.reference')); ?><span class="input-label-secondary"></span></label>
                            <input  class="form-control" type="text" name="ref" id="ref" maxlength="191" placeholder="<?php echo e(translate('ex_collect_cash')); ?>">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="btn--container justify-content-end">
                            <button class="btn btn--reset" type="reset" id="reset_btn"><?php echo e(translate('messages.reset')); ?></button>
                            <button class="btn btn--primary" type="submit"><?php echo e(translate('messages.save')); ?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-2 border-0">
                    <div class="search--button-wrapper">
                        <h5 class="card-title">
                            <span class="card-header-icon">
                                <i class="tio-user"></i>
                            </span>
                            <span>
                                <?php echo e(translate('messages.deliverymen_earning_provide_table')); ?>

                            </span>
                            <span class="badge badge-soft-secondary" id="itemCount">
                                (<?php echo e($provide_dm_earning->total()); ?>)
                            </span>
                        </h5>

                        <form class="search-form">
                        
                            <!-- Search -->
                            <div class="input-group input--group">
                                <input id="datatableSearch" name="search" type="search" class="form-control h--40px" placeholder="<?php echo e(translate('ex_:_search_delivery_man')); ?>" value="<?php echo e(request()?->search ?? null); ?>" aria-label="<?php echo e(translate('messages.search_here')); ?>">
                                <button type="submit" class="btn btn--secondary h--40px"><i class="tio-search"></i></button>
                            </div>
                            <!-- End Search -->
                        </form>

                        <!-- Unfold -->
                        <div class="hs-unfold mr-2">
                            <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle min-height-40" href="javascript:;"
                                data-hs-unfold-options='{
                                        "target": "#usersExportDropdown",
                                        "type": "css-animation"
                                    }'>
                                <i class="tio-download-to mr-1"></i> <?php echo e(translate('messages.export')); ?>

                            </a>

                            <div id="usersExportDropdown"
                                class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                                <span class="dropdown-header"><?php echo e(translate('messages.download_options')); ?></span>
                                <a id="export-excel" class="dropdown-item" href="<?php echo e(route('admin.transactions.export-deliveryman-earning', ['type'=>'excel',request()->getQueryString()])); ?>">
                                    <img class="avatar avatar-xss avatar-4by3 mr-2"
                                        src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                        alt="Image Description">
                                    <?php echo e(translate('messages.excel')); ?>

                                </a>
                                <a id="export-csv" class="dropdown-item" href="<?php echo e(route('admin.transactions.export-deliveryman-earning', ['type'=>'csv',request()->getQueryString()])); ?>">
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
                        <table id="datatable"
                            class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0"><?php echo e(translate('sl')); ?></th>
                                    <th class="border-0"><?php echo e(translate('messages.name')); ?></th>
                                    <th class="border-0"><?php echo e(translate('messages.received_at')); ?></th>
                                    <th class="border-0"><?php echo e(translate('messages.amount')); ?></th>
                                    <th class="border-0"><?php echo e(translate('messages.method')); ?></th>
                                    <th class="border-0"><?php echo e(translate('messages.reference')); ?></th>
                                </tr>
                            </thead>
                            <tbody id="set-rows">
                            <?php $__currentLoopData = $provide_dm_earning; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$at): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($k+$provide_dm_earning->firstItem()); ?></td>
                                    <td><?php if($at->delivery_man): ?><a href="<?php echo e(route('admin.users.delivery-man.preview', $at->delivery_man_id)); ?>"><?php echo e($at->delivery_man->f_name.' '.$at->delivery_man->l_name); ?></a> <?php else: ?> <label class="text-capitalize text-danger"><?php echo e(translate('messages.deliveryman_deleted')); ?></label> <?php endif; ?> </td>
                                    <td><?php echo e(\App\CentralLogics\Helpers::time_date_format($at->created_at)); ?></td>
                                    <td><?php echo e(\App\CentralLogics\Helpers::format_currency($at['amount'])); ?></td>
                                    <td><?php echo e($at['method']); ?></td>
                                    <?php if(  $at['ref'] == 'delivery_man_wallet_adjustment_full'): ?>
                                        <td><?php echo e(translate('wallet_adjusted')); ?></td>
                                    <?php elseif( $at['ref'] == 'delivery_man_wallet_adjustment_partial'): ?>
                                        <td><?php echo e(translate('wallet_adjusted_partially')); ?></td>
                                    <?php else: ?>
                                        <td><?php echo e($at['ref']); ?></td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if(count($provide_dm_earning) !== 0): ?>
                <hr>
                <?php endif; ?>
                <div class="page-area">
                    <?php echo $provide_dm_earning->links(); ?>

                </div>
                <?php if(count($provide_dm_earning) === 0): ?>
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
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/deliveryman-earning-provide.js"></script>
<script>
    "use strict";

    $('#deliveryman').select2({
        ajax: {
            url: '<?php echo e(url('/')); ?>/admin/users/delivery-man/get-deliverymen',
            data: function (params) {
                return {
                    q: params.term, // search term
                    earning: true,
                    page: params.page
                };
            },
            processResults: function (data) {
                return {
                results: data
                };
            },
            __port: function (params, success, failure) {
                var $request = $.ajax(params);

                $request.then(success);
                $request.fail(failure);

                return $request;
            }
        }
    });

    $('#add_transaction').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post({
            url: '<?php echo e(route('admin.transactions.provide-deliveryman-earnings.store')); ?>',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.errors) {
                    for (var i = 0; i < data.errors.length; i++) {
                        toastr.error(data.errors[i].message, {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                } else {
                    toastr.success('<?php echo e(translate('messages.transaction_saved')); ?>', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                    setTimeout(function () {
                        location.href = '<?php echo e(route('admin.transactions.provide-deliveryman-earnings.index')); ?>';
                    }, 2000);
                }
            }
        });
    });

    function getAccountData(route, data_id, type)
    {
        $.get({
                url: route+data_id,
                dataType: 'json',
                success: function (data) {
                    $('#account_info').html('(<?php echo e(translate('messages.cash_in_hand')); ?>: '+data.cash_in_hand+' <?php echo e(translate('messages.earning_balance')); ?>: '+data.earning_balance+')');
                },
            });
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/deliveryman-earning-provide/index.blade.php ENDPATH**/ ?>