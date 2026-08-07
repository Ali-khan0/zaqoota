<?php $__env->startSection('title',translate('messages.Store_Transactions')); ?>

<?php $__env->startSection('subscriberList'); ?>
active
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css_or_js'); ?>


<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="content container-fluid">
        <div class="page-header">
            <div class="d-flex flex-wrap justify-content-between align-items-center py-2">
                <div class="flex-grow-1">
                    <div class="d-flex align-items-start">
                        <img src="<?php echo e(asset('/public/assets/admin/img/store.png')); ?>" width="24" alt="img">
                        <div class="w-0 flex-grow pl-2">
                            <h1 class="page-header-title"><?php echo e($store->name); ?> <?php echo e(translate('Subscription')); ?> &nbsp; &nbsp;
                                <?php if($store?->status == 0 &&  $store?->vendor?->status == 0): ?>
                                <span class=" badge badge-pill badge-info">  &nbsp; <?php echo e(translate('Approval_Pending')); ?>  &nbsp; </span>
                                <?php elseif($store?->store_sub_update_application?->status == 0): ?>
                                <span class=" badge badge-pill badge-danger">  &nbsp; <?php echo e(translate('Expired')); ?>  &nbsp; </span>
                                <?php elseif($store?->store_sub_update_application?->is_canceled == 1): ?>
                                <span class=" badge badge-pill badge-warning">  &nbsp; <?php echo e(translate('canceled')); ?>  &nbsp; </span>
                                <?php elseif($store?->store_sub_update_application?->status == 1): ?>
                                <span class=" badge badge-pill badge-success">  &nbsp; <?php echo e(translate('Active')); ?>  &nbsp; </span>
                                <?php endif; ?>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="js-nav-scroller hs-nav-scroller-horizontal mb-4">
            <ul class="nav nav-tabs border-0 nav--tabs nav--pills">
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.business-settings.subscriptionackage.subscriberDetail',$id)); ?>" class="nav-link "><?php echo e(translate('Subscription_Details')); ?> </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link active"><?php echo e(translate('Transactions')); ?></a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.business-settings.subscriptionackage.subscriberWalletTransactions',$store->id)); ?>" class="nav-link"><?php echo e(translate('Subscription_Refunds')); ?></a>
                </li>
            </ul>
        </div>
        <div class="card mb-20">
            <div class="card-header border-0">
                <h3 class="text--title card-title"><?php echo e(translate('Filter_Option')); ?></h3>
            </div>
            <form action="<?php echo e(route('admin.business-settings.subscriptionackage.subscriberTransactions',$id)); ?>" method="get">
                <div class="card-body">
                    <div class="row">
                    <div class="col-lg-4 col-sm-4">
                        <div class="form-group">
                            <label class="input-label text-capitalize"><?php echo e(translate('Duration')); ?></label>
                                <select class="form-control js-select2-custom filter" id="filter" name="filter" >
                                    <option value="all_time" <?php echo e(isset($filter) && $filter == 'all_time' ? 'selected' : ''); ?>>
                                        <?php echo e(translate('messages.All Time')); ?></option>
                                    <option value="this_year" <?php echo e(isset($filter) && $filter == 'this_year' ? 'selected' : ''); ?>>
                                        <?php echo e(translate('messages.This Year')); ?></option>

                                    <option value="this_month"
                                        <?php echo e(isset($filter) && $filter == 'this_month' ? 'selected' : ''); ?>>
                                        <?php echo e(translate('messages.This Month')); ?></option>
                                    <option value="this_week" <?php echo e(isset($filter) && $filter == 'this_week' ? 'selected' : ''); ?>>
                                        <?php echo e(translate('messages.This Week')); ?></option>
                                    <option value="custom" <?php echo e(isset($filter) && $filter == 'custom' ? 'selected' : ''); ?>>
                                        <?php echo e(translate('messages.Custom')); ?></option>
                                </select>
                            </div>
                    </div>
                    <div class="col-lg-4 col-sm-4">
                        <div class="form-group">
                            <label class="input-label text-capitalize" for="date_from"><?php echo e(translate('start_date')); ?></label>
                            <input type="date"  value="<?php echo e(request()?->start_date); ?>" <?php echo e(isset($filter) && $filter == 'custom' ? " required  name='start_date' " : 'readonly'); ?>   class="form-control" id="date_from" >
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4">
                        <div class="form-group">
                            <label class="input-label text-capitalize" for="date_to"><?php echo e(translate('end_date')); ?></label>
                            <input type="date" value="<?php echo e(request()?->end_date); ?>" <?php echo e(isset($filter) && $filter == 'custom' ? " required  name='end_date' " : 'readonly'); ?>  class="form-control" id="date_to" >
                        </div>
                    </div>
                </div>
                <div class="btn--container justify-content-end">
                    <button type="reset" id="reset_btn" class="btn btn--reset"><?php echo e(translate('Reset')); ?></button>
                    <button type="submit" class="btn btn--primary"><?php echo e(translate('Submit')); ?></button>
                </div>
            </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header flex-wrap py-2 border-0">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <h4 class="mb-0"><?php echo e(translate('Transaction_History')); ?></h4>
                    <span class="badge badge-soft-dark rounded-circle"><?php echo e($transactions->total()); ?></span>
                </div>
                <div class="search--button-wrapper justify-content-end">
                    <div class="max-sm-flex-1">
                        <select name="plan_type"  data-url="<?php echo e(url()->full()); ?>" data-filter="plan_type" class="custom-select h--40px py-0 status-filter set-filter">
                            <option <?php echo e(request()?->plan_type == 'all' ? 'selected' : ''); ?>  value="all">
                                <?php echo e(translate('all')); ?>

                            </option>
                            <option <?php echo e(request()?->plan_type == 'renew' ? 'selected' : ''); ?>  value="renew">
                                <?php echo e(translate('renewal')); ?>

                            </option>
                            <option <?php echo e(request()?->plan_type == 'new_plan' ? 'selected' : ''); ?>  value="new_plan">
                                <?php echo e(translate('Migrate_to_New_Plan')); ?>

                            </option>
                            <option <?php echo e(request()?->plan_type == 'first_purchased' ? 'selected' : ''); ?>  value="first_purchased">
                                <?php echo e(translate('Purchased')); ?>

                            </option>

                        </select>
                    </div>
                    <form class="search-form">
                        <div class="input-group input--group">
                            <input name="search" type="search" value="<?php echo e(request()?->search); ?>" class="form-control h--40px" placeholder="<?php echo e(translate('Ex : Search by Transaction ID ')); ?>" aria-label="Search here">
                            <button type="submit" class="btn btn--secondary h--40px"><i class="tio-search"></i></button>
                        </div>
                    </form>
                    <!-- Unfold -->
                    <div class="hs-unfold">
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
                                href="<?php echo e(route('admin.business-settings.subscriptionackage.subscriberTransactionExport', [ 'id' =>$store->id, 'export_type' => 'excel', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin/svg/components/excel.svg')); ?>"
                                    alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item"
                                href="<?php echo e(route('admin.business-settings.subscriptionackage.subscriberTransactionExport', [ 'id' =>$store->id, 'export_type' => 'csv', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin/svg/components/placeholder-csv-format.svg')); ?>"
                                    alt="Image Description">
                                .<?php echo e(translate('messages.csv')); ?>

                            </a>

                        </div>
                    </div>
                    <!-- End Unfold -->
                </div>
                <!-- End Row -->
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-borderless middle-align __txt-14px">
                        <thead class="thead-light white--space-false">
                            <th class="border-top px-4 border-bottom text-center"><?php echo e(translate('sl')); ?></th>
                            <th class="border-top px-4 border-bottom"><?php echo e(translate('Transaction_ID')); ?></th>
                            <th class="border-top px-4 border-bottom"><div class="text-title"><?php echo e(translate('Transaction_Date')); ?></div></th>
                            <th class="border-top px-4 border-bottom"><?php echo e(translate('Store')); ?></th>
                            <th class="border-top px-4 border-bottom"><?php echo e(translate('Pricing')); ?></th>
                            <th class="border-top px-4 border-bottom"><?php echo e(translate('Payment_Type')); ?></th>
                            <th class="border-top px-4 border-bottom"><?php echo e(translate('Status')); ?></th>
                            <th class="border-top px-4 border-bottom text-center"><?php echo e(translate('Action')); ?></th>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=> $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>
                                <td class="px-4 text-center"><?php echo e($k + $transactions->firstItem()); ?></td>

                                <td class="px-4">
                                    <div class="text-title"><?php echo e($transaction->id); ?></div>
                                </td>
                                <td class="px-4">
                                    <div class="pl-4"><?php echo e(\App\CentralLogics\Helpers::date_format($transaction->created_at)); ?></div>
                                </td>
                                <td class="px-4">
                                    <div class="text-title"><?php echo e($transaction?->store?->name ?? translate('messages.store deleted!')); ?>

                                        <?php if($transaction?->subscription?->status == 1 && $transaction?->subscription?->expiry_date_parsed && $transaction->subscription->expiry_date_parsed->subDays((int) $subscription_deadline_warning_days)->isBefore(now())): ?>
                                        <span title="<div class='text-left'>Expiring Soon <br /> Expiration Date: <?php echo e(\App\CentralLogics\Helpers::date_format($transaction->subscription->expiry_date_parsed)); ?></div>" data-toggle="tooltip" data-html="true">
                                            <img src="<?php echo e(asset('/public/assets/admin/img/invalid.svg')); ?>" alt="">
                                        </span>
                                        <?php endif; ?>


                                    </div>
                                </td>
                                <td class="px-4">
                                    <div class="w--120px text-title text-right pr-5"><?php echo e(\App\CentralLogics\Helpers::format_currency($transaction->paid_amount)); ?></div>
                                </td>
                                <td class="px-4">
                                    <div>
                                        <?php if( $transaction->plan_type == 'renew'  ): ?>
                                        <div class="text-title"><?php echo e(translate('Renewal')); ?></div>
                                        <?php elseif($transaction->plan_type == 'new_plan'  ): ?>
                                        <div class="text-title"><?php echo e(translate('Migrate_to_New_Plan')); ?></div>
                                        <?php elseif($transaction->plan_type == 'first_purchased'  ): ?>
                                        <div class="text-title"><?php echo e(translate('Purchased')); ?></div>
                                        <?php else: ?>
                                        <div class="text-title"><?php echo e(translate($transaction->plan_type)); ?></div>
                                        <?php endif; ?>

                                        <div class="text-success font-medium"><?php echo e(translate('Paid_by')); ?>  <?php echo e(translate($transaction->payment_method)); ?></div>
                                    </div>
                                </td>
                                <td class="px-4">
                                    <?php if( $transaction->payment_status == 'success'): ?>
                                    <span class="text-success">
                                    <?php elseif($transaction->payment_status ==  'on_hold'): ?>
                                    <span class="text--info">
                                    <?php else: ?>
                                        <span class="text--danger">
                                    <?php endif; ?>
                                        <?php echo e(translate($transaction->payment_status)); ?>

                                    </span>

                                </td>
                                <td class="px-4">
                                    <div class="btn--container justify-content-center">
                                        <button class="btn action-btn btn--warning btn-outline-warning printButton" data-url=<?php echo e(route('admin.business-settings.subscriptionackage.invoice',$transaction->id)); ?> >
                                            <i class="tio-print"></i>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                    </table>
                </div>
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
        </div>
    </div>




<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
<script>
    $("#date_from").on("change", function () {
        $('#date_to').attr('min',$(this).val());
    });

    $("#date_to").on("change", function () {
        $('#date_from').attr('max',$(this).val());
    });


        $(document).on('change','.filter', function () {
            if($(this).val() == 'custom'){
                $('#date_from').removeAttr('readonly').attr('name', 'start_date').attr('required', true);
                $('#date_to').removeAttr('readonly').attr('name', 'end_date').attr('required', true);
            }
            else{
                $('#date_from').attr('readonly',true).removeAttr('name', 'start_date').removeAttr('required');
                $('#date_to').attr('readonly',true).removeAttr('name', 'end_date').removeAttr('required');
            }
        });
        $(document).ready(function() {
            $('.printButton').click(function() {
                window.open($(this).data('url'), '_blank');
            });
        });
    $(document).on("click", "#reset_btn", function () {
        setTimeout(reset, 10);
    });

    function reset(){
        $('.filter').trigger('change');
    }
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/subscription/subscriber/transaction.blade.php ENDPATH**/ ?>