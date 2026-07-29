<?php use App\CentralLogics\Helpers; ?>


<?php $__env->startSection('title',translate('messages.customer_loyalty_point_report')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $from = session('from_date');
        $to = session('to_date');
    ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title mr-3">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/customer-loyalty.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                     <?php echo e(translate('messages.customer_loyalty_point_report')); ?>

                </span>
            </h1>
        </div>
        <!-- Page Header -->

        
        <div class="card mb-3">
            <div class="card-body">
                <h4 class="card-title mb-4">
                    <span><?php echo e(translate('messages.filter_options')); ?></span>
                </h4>

                <form action="<?php echo e(route('admin.users.customer.loyalty-point.set-date')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="row justify-content-end align-items-end g-3">
                        <div class="col-lg-4">
                            <?php
                                $transaction_status=request()->get('transaction_type');
                            ?>
                            <label class="text-dark text-capitalize"
                                   for="add-fund-type"><?php echo e(translate('messages.add_fund_type')); ?></label>
                            <select name="transaction_type" id="add-fund-type"
                                    class="form-control js-select2-custom  set-filter" data-url="<?php echo e(url()->full()); ?>"
                                    data-filter="transaction_type"
                                    title="<?php echo e(translate('messages.select_transaction_type')); ?>">
                                <option value="all"><?php echo e(translate('messages.all_type')); ?></option>
                                <option
                                    value="point_to_wallet" <?php echo e(isset($transaction_status) && $transaction_status=='point_to_wallet'?'selected':''); ?>><?php echo e(translate('messages.point_to_wallet')); ?></option>
                                <option
                                    value="order_place" <?php echo e(isset($transaction_status) && $transaction_status=='order_place'?'selected':''); ?>><?php echo e(translate('messages.order_place')); ?></option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label class="text-dark text-capitalize"
                                   for="customer"><?php echo e(translate('messages.customer')); ?></label>
                            <select id='customer' name="customer_id" data-url="<?php echo e(url()->full()); ?>"
                                    data-filter="customer_id"
                                    data-placeholder="<?php echo e(translate('messages.select_customer')); ?>"
                                    class="js-data-example-ajax form-control set-filter"
                                    title="<?php echo e(translate('messages.select_customer')); ?>">
                                <?php if(request()->get('customer_id') && $customer_info = \App\Models\User::find(request()->get('customer_id'))): ?>
                                    <option value="<?php echo e($customer_info->id); ?>"
                                            selected><?php echo e($customer_info->f_name.' '.$customer_info->l_name); ?>

                                        (<?php echo e($customer_info->phone); ?>)
                                    </option>
                                <?php endif; ?>

                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label class="text-dark text-capitalize"
                                   for="filter"><?php echo e(translate('messages.duration')); ?></label>
                            <select class="form-control js-select2-custom  set-filter" name="filter"
                                    data-url="<?php echo e(url()->full()); ?>" data-filter="filter">
                                <option
                                    value="all_time" <?php echo e(isset($filter) && $filter == 'all_time' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.All Time')); ?></option>
                                <option
                                    value="this_year" <?php echo e(isset($filter) && $filter == 'this_year' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.This Year')); ?></option>
                                <option value="previous_year"
                                    <?php echo e(isset($filter) && $filter == 'previous_year' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.Previous Year')); ?></option>
                                <option value="this_month"
                                    <?php echo e(isset($filter) && $filter == 'this_month' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.This Month')); ?></option>
                                <option
                                    value="this_week" <?php echo e(isset($filter) && $filter == 'this_week' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.This Week')); ?></option>
                                <option value="custom" <?php echo e(isset($filter) && $filter == 'custom' ? 'selected' : ''); ?>>
                                    <?php echo e(translate('messages.Custom')); ?></option>
                            </select>
                        </div>
                        <?php if(isset($filter) && $filter == 'custom'): ?>
                            <div class="col-lg-4">

                                <input type="date" name="from" id="from_date" class="form-control"
                                       placeholder="<?php echo e(translate('Start Date')); ?>"
                                       <?php echo e(session()->has('from_date') ? 'value=' . session('from_date') : ''); ?> required>

                            </div>
                            <div class="col-lg-4">

                                <input type="date" name="to" id="to_date" class="form-control"
                                       placeholder="<?php echo e(translate('End Date')); ?>"
                                       <?php echo e(session()->has('to_date') ? 'value=' . session('to_date') : ''); ?> required>

                            </div>
                        <?php endif; ?>
                        <div class="col-lg-4">
                            <div class="btn--container justify-content-end">
                                <button type="reset" class="btn btn--reset location-reload-to-base"
                                        data-url="<?php echo e(url()->full()); ?>"><?php echo e(translate('messages.reset')); ?></button>
                                <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.filter')); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>

        
        <div class="card mb-3">
            <div class="card-body">
                <div class="row g-3">
                    <?php
                        $credit = (int)$data[0]->total_credit??0;
                        $debit = (int)$data[0]->total_debit??0;
                        $balance = $credit - $debit;
                    ?>
                        <!--Debit earned-->
                    <div class="col-md-4">
                        <div class="color-card color-6">
                            <div class="img-box">
                                <img class="resturant-icon w--30"
                                     src="<?php echo e(asset('public/assets/admin/img/customer-loyality/1.png')); ?>"
                                     alt="transactions">
                            </div>
                            <div>
                                <h2 class="title">
                                    <?php echo e($credit); ?>

                                </h2>
                                <div class="subtitle">
                                    <?php echo e(translate('messages.points_Earned')); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Debit earned End-->

                    <!--credit earned-->
                    <div class="col-md-4">
                        <div class="color-card color-2">
                            <div class="img-box">
                                <img class="resturant-icon w--30"
                                     src="<?php echo e(asset('public/assets/admin/img/customer-loyality/4.png')); ?>"
                                     alt="transactions">
                            </div>
                            <div>
                                <h2 class="title">
                                    <?php echo e($debit); ?>

                                </h2>
                                <div class="subtitle">
                                    <?php echo e(translate('messages.points_Converted')); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--credit earned end-->

                    <!--balance earned-->
                    <div class="col-md-4">
                        <div class="color-card color-4">
                            <div class="img-box">
                                <img class="resturant-icon w--30"
                                     src="<?php echo e(asset('public/assets/admin/img/customer-loyality/2.png')); ?>"
                                     alt="transactions">
                            </div>
                            <div>
                                <h2 class="title">
                                    <?php echo e($balance); ?>

                                </h2>
                                <div class="subtitle">
                                    <?php echo e(translate('messages.current_Points_in_Wallet')); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--balance earned end-->
                </div>
            </div>

        </div>

        <!-- End Stats -->
        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header border-0">
                <h4 class="card-title">
                    <span><?php echo e(translate('messages.transactions')); ?></span>
                </h4>
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
                           href="<?php echo e(route('admin.users.customer.loyalty-point.export', ['type'=>'excel',request()->getQueryString()])); ?>">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                 src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                 alt="Image Description">
                            <?php echo e(translate('messages.excel')); ?>

                        </a>
                        <a id="export-csv" class="dropdown-item"
                           href="<?php echo e(route('admin.users.customer.loyalty-point.export', ['type'=>'csv',request()->getQueryString()])); ?>">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                 src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                 alt="Image Description">
                            .<?php echo e(translate('messages.csv')); ?>

                        </a>
                    </div>
                </div>
                <!-- End Unfold -->
            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="datatable"
                           class="table table-thead-bordered table-align-middle card-table table-nowrap">
                        <thead class="thead-light">
                        <tr>
                            <th class="border-0"><?php echo e(translate('SL')); ?></th>
                            <th class="border-0"><?php echo e(translate('messages.transaction_ID')); ?></th>
                            <th class="border-0"><?php echo e(translate('messages.Customer_info')); ?></th>
                            <th class="border-0"><?php echo e(translate('messages.points_earned')); ?></th>
                            <th class="border-0"><?php echo e(translate('messages.points_converted')); ?></th>
                            <th class="border-0"><?php echo e(translate('messages.current_points_in_wallet')); ?></th>
                            <th class="border-0"><?php echo e(translate('messages.transaction_type')); ?></th>
                            <th class="border-0"><?php echo e(translate('messages.reference')); ?></th>
                            <th class="border-0"><?php echo e(translate('messages.created_at')); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$wt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr scope="row">
                                <td><?php echo e($k+$transactions->firstItem()); ?></td>
                                <td><?php echo e($wt->transaction_id); ?></td>
                                <td><a class="text-dark"
                                       href="<?php echo e(route('admin.users.customer.view',['user_id'=>$wt->user_id])); ?>"><?php echo e(Str::limit($wt->user?$wt->user->f_name.' '.$wt->user->l_name:translate('messages.not_found'),20,'...')); ?></a>
                                </td>
                                <td><?php echo e($wt->credit); ?></td>
                                <td><?php echo e($wt->debit); ?></td>
                                <td><?php echo e($wt->balance); ?></td>
                                <td>
                                    <span
                                        class="badge badge-soft-<?php echo e($wt->transaction_type=='point_to_wallet'?'success':'dark'); ?>">
                                        <?php echo e(translate('messages.'.$wt->transaction_type)); ?>

                                    </span>
                                </td>
                                <td><?php echo e($wt->reference); ?></td>
                                <td>
                                    <?php echo e(Helpers::date_format($wt->created_at)); ?>

                                    <br>
                                    <?php echo e(Helpers::time_format($wt->created_at)); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- End Body -->
            <?php if(count($transactions) !== 0): ?>
                <hr>
            <?php endif; ?>
            <div class="page-area">
                <?php echo $transactions->withQueryString()->links(); ?>

            </div>
            <?php if(count($transactions) === 0): ?>
                <div class="empty--data">
                    <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                    <h5>
                        <?php echo e(translate('no_data_found')); ?>

                    </h5>
                </div>
            <?php endif; ?>
        </div>
        <!-- End Card -->
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('script_2'); ?>


    <script>
        "use strict";
        $('.js-data-example-ajax').select2({
            ajax: {
                url: '<?php echo e(route('admin.users.customer.select-list')); ?>',
                data: function (params) {
                    return {
                        q: params.term, // search term
                        all: true,
                        page: params.page
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                __port: function (params, success, failure) {
                    let $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/customer/loyalty-point/report.blade.php ENDPATH**/ ?>