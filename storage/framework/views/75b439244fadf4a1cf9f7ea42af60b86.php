<?php $__env->startSection('title',translate('messages.store_wallet')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h2 class="page-header-title text-capitalize">
                        <div class="card-header-icon d-inline-flex mr-2 img">
                            <img src="<?php echo e(asset('/public/assets/admin/img/image_90.png')); ?>" alt="public">
                        </div>
                        <span>
                            <?php echo e(translate('messages.store_wallet')); ?>

                        </span>
                    </h2>
                </div>
            </div>
        </div>
        <!-- End Page Header -->


        <?php
        $wallet = \App\Models\StoreWallet::where('vendor_id',\App\CentralLogics\Helpers::get_vendor_id())->first();
        if(isset($wallet)==false){
            \Illuminate\Support\Facades\DB::table('store_wallets')->insert([
                'vendor_id'=>\App\CentralLogics\Helpers::get_vendor_id(),
                'created_at'=>now(),
                'updated_at'=>now()
            ]);
            $wallet = \App\Models\StoreWallet::where('vendor_id',\App\CentralLogics\Helpers::get_vendor_id())->first();
        }
        ?>
        <?php echo $__env->make('vendor-views.wallet.partials._balance_data',['wallet'=>$wallet], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


        <div class="card-header border-0 py-2">
            <div class="search--button-wrapper">
                <h2 class="card-title">
                    <?php echo e(translate('Total_Disbursements')); ?> <span class="badge badge-soft-secondary ml-2" id="countItems"><?php echo e($disbursements->total()); ?></span>
                </h2>
                <form class="search-form">
                    <!-- Search -->
                    <div class="input--group input-group input-group-merge input-group-flush">
                        <input class="form-control" value="<?php echo e(request()?->search  ?? null); ?>" placeholder="<?php echo e(translate('search_by_ID')); ?>" name="search">
                        <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                    </div>
                    <!-- End Search -->
                </form>
                <!-- Static Export Button -->
                <div class="hs-unfold ml-3">
                    <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle btn export-btn btn-outline-primary btn--primary font--sm" href="javascript:;"
                       data-hs-unfold-options='{
                                    "target": "#usersExportDropdown",
                                    "type": "css-animation"
                                }'>
                        <i class="tio-download-to mr-1"></i> <?php echo e(translate('messages.export')); ?>

                    </a>
                    <div id="usersExportDropdown"
                         class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                        <span class="dropdown-header"><?php echo e(translate('messages.download_options')); ?></span>
                        <a id="export-excel" class="dropdown-item" href="<?php echo e(route('vendor.wallet.export', ['type'=>'excel',request()->getQueryString()])); ?>">
                            <img class="avatar avatar-xss avatar-4by3 mr-2" src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg" alt="Image Description">
                            <?php echo e(translate('messages.excel')); ?>

                        </a>
                        <a id="export-csv" class="dropdown-item" href="<?php echo e(route('vendor.wallet.export', ['type'=>'csv',request()->getQueryString()])); ?>">
                            <img class="avatar avatar-xss avatar-4by3 mr-2" src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg" alt="Image Description">
                            <?php echo e(translate('messages.csv')); ?>

                        </a>

                    </div>
                </div>
                <!-- Static Export Button -->

                <!-- Action button after check table row -->
                <div id="action-section" class="d--none">
                    <button class="btn btn-danger btn-outline-danger" id="cancel"><?php echo e(translate('cancel')); ?></button>
                    <button class="btn btn-success" id="complete"><?php echo e(translate('complete')); ?></button>
                </div>
                <!-- Action button after check table row -->

            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-thead-bordered table-align-middle card-table">
                    <thead>
                    <tr>
                        <th><?php echo e(translate('sl')); ?></th>
                        <th><?php echo e(translate('ID')); ?></th>
                        <th><?php echo e(translate('Created_at')); ?></th>
                        <th><?php echo e(translate('Disburse_Amount')); ?></th>
                        <th><?php echo e(translate('Payment_method')); ?></th>
                        <th><?php echo e(translate('Payout_Date')); ?></th>
                        <th><?php echo e(translate('status')); ?></th>
                        <th>
                            <div class="text-center">
                                <?php echo e(translate('action')); ?>

                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $disbursements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <tr>
                            <td>
                                <span class="font-weight-bold"><?php echo e($key+ $disbursements->firstItem()); ?></span>
                            </td>
                            <td>
                                <span class="font-weight-bold"><?php echo e($store->disbursement_id); ?></span>
                            </td>
                            <td>
                                <?php echo e(\App\CentralLogics\Helpers::time_date_format( $store->created_at )); ?>


                            </td>

                            <td>
                                <?php echo e(\App\CentralLogics\Helpers::format_currency($store['disbursement_amount'])); ?>

                            </td>
                            <td>
                                <div>
                                    <?php echo e($store->withdraw_method->method_name); ?>

                                </div>
                            </td>
                            <td>
                                <?php ($store_disbursement_waiting_time = (int) \App\Models\BusinessSetting::where('key', 'store_disbursement_waiting_time')->first()?->value ?? 0); ?>
                                <div>
                                    <?php echo e($store->created_at->addDays($store_disbursement_waiting_time)->format('d-M-y')); ?>

                                    <small>
                                        <?php echo e(translate('Estimated')); ?>

                                    </small>
                                </div>
                            </td>
                            <td>
                                <?php if($store->status=='pending'): ?>
                                    <label class="badge badge-soft-primary"><?php echo e(translate('pending')); ?></label>
                                <?php elseif($store->status=='completed'): ?>
                                    <label class="badge badge-soft-success"><?php echo e(translate('Completed')); ?></label>
                                <?php else: ?>
                                    <label class="badge badge-soft-danger"><?php echo e(translate('canceled')); ?></label>
                                <?php endif; ?>
                            </td>


                            <td>
                                <div class="btn--container justify-content-center">
                                    <a class="btn btn-sm btn--primary btn-outline-primary action-btn" data-toggle="modal" data-target="#payment-info-<?php echo e($store->id); ?>" title="<?php echo e(translate('View_Details')); ?>">
                                        <i class="tio-visible"></i>
                                    </a>

                                </div>
                            </td>
                            <div class="modal fade" id="payment-info-<?php echo e($store->id); ?>">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header pb-4">
                                            <button type="button" class="payment-modal-close btn-close border-0 outline-0 bg-transparent" data-dismiss="modal">
                                                <i class="tio-clear"></i>
                                            </button>
                                            <div class="w-100 text-center">
                                                <h2 class="mb-2"><?php echo e(translate('Payment_Information')); ?></h2>
                                                <div>
                                                    <span class="mr-2"><?php echo e(translate('Disbursement_ID')); ?></span>
                                                    <strong>#<?php echo e($store->disbursement_id); ?></strong>
                                                </div>
                                                <div class="mt-2">
                                                    <span class="mr-2"><?php echo e(translate('status')); ?></span>
                                                    <?php if($store->status=='pending'): ?>
                                                        <label class="badge badge-soft-primary"><?php echo e(translate('pending')); ?></label>
                                                    <?php elseif($store->status=='completed'): ?>
                                                        <label class="badge badge-soft-success"><?php echo e(translate('Completed')); ?></label>
                                                    <?php else: ?>
                                                        <label class="badge badge-soft-danger"><?php echo e(translate('canceled')); ?></label>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card shadow--card-2">
                                                <div class="card-body">
                                                    <div class="d-flex flex-wrap payment-info-modal-info p-xl-4">
                                                        <div class="item">
                                                            <h5><?php echo e(translate('Store_Information')); ?></h5>
                                                            <ul class="item-list">
                                                                <li class="d-flex flex-wrap">
                                                                    <span class="name"><?php echo e(translate('name')); ?></span>
                                                                    <span>:</span>
                                                                    <strong><?php echo e($store?->store?->name); ?></strong>
                                                                </li>
                                                                <li class="d-flex flex-wrap">
                                                                    <span class="name"><?php echo e(translate('contact')); ?></span>
                                                                    <span>:</span>
                                                                    <strong><?php echo e($store?->store?->phone); ?></strong>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="item">
                                                            <h5><?php echo e(translate('Owner_Information')); ?></h5>
                                                            <ul class="item-list">
                                                                <li class="d-flex flex-wrap">
                                                                    <span class="name"><?php echo e(translate('name')); ?></span>
                                                                    <span>:</span>
                                                                    <strong><?php echo e($store->store->vendor->f_name); ?> <?php echo e($store->store->vendor->l_name); ?></strong>
                                                                </li>
                                                                <li class="d-flex flex-wrap">
                                                                    <span class="name"><?php echo e(translate('email')); ?></span>
                                                                    <span>:</span>
                                                                    <strong><?php echo e($store->store->vendor->email); ?></strong>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="item w-100">
                                                            <h5><?php echo e(translate('Account_Information')); ?></h5>
                                                            <ul class="item-list">
                                                                <li class="d-flex flex-wrap">
                                                                    <span class="name"><?php echo e(translate('payment_method')); ?></span>
                                                                    <span>:</span>
                                                                    <strong><?php echo e($store->withdraw_method->method_name); ?></strong>
                                                                </li>
                                                                <li class="d-flex flex-wrap">
                                                                    <span class="name"><?php echo e(translate('amount')); ?></span>
                                                                    <span>:</span>
                                                                    <strong><?php echo e(\App\CentralLogics\Helpers::format_currency($store['disbursement_amount'])); ?></strong>
                                                                </li>
                                                                <?php $__empty_1 = true; $__currentLoopData = json_decode($store->withdraw_method->method_fields, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                    <li class="d-flex flex-wrap">
                                                                        <span class="name"><?php echo e(translate($key)); ?></span>
                                                                        <span>:</span>
                                                                        <strong><?php echo e($item); ?></strong>
                                                                    </li>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                                                <?php endif; ?>

                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php if(count($disbursements) === 0): ?>
                    <div class="empty--data">
                        <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                        <h5>
                            <?php echo e(translate('no_data_found')); ?>

                        </h5>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="card-footer pt-0 border-0">
            <?php echo e($disbursements->links()); ?>

        </div>
    </div>

    <div class="modal fade" id="payment_model" tabindex="-1"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo e(translate('messages.Pay_Via_Online')); ?>  </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <form action="<?php echo e(route('vendor.wallet.make_payment')); ?>" method="POST" class="needs-validation">
                    <div class="modal-body">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" value="<?php echo e(\App\CentralLogics\Helpers::get_store_id()); ?>" name="store_id"/>
                        <input type="hidden" value="<?php echo e(abs($wallet->collected_cash)); ?>" name="amount"/>
                        <h5 class="mb-5 "><?php echo e(translate('Pay_Via_Online')); ?> &nbsp; <small>(<?php echo e(translate('Faster_&_secure_way_to_pay_bill')); ?>)</small></h5>
                        <div class="row g-3">
                            <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="col-sm-6">
                                    <div class="d-flex gap-3 align-items-center">
                                        <input type="radio" required id="<?php echo e($item['gateway']); ?>" name="payment_gateway" value="<?php echo e($item['gateway']); ?>">
                                        <label for="<?php echo e($item['gateway']); ?>" class="d-flex align-items-center gap-3 mb-0">
                                            <img height="24" src="<?php echo e(asset('storage/app/public/payment_modules/gateway_image/'. $item['gateway_image'])); ?>" alt="">
                                            <?php echo e($item['gateway_title']); ?>

                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <h1><?php echo e(translate('no_payment_gateway_found')); ?></h1>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button id="reset_btn" type="reset" data-dismiss="modal" class="btn btn-secondary" ><?php echo e(translate('Close')); ?> </button>
                        <button type="submit" class="btn btn-primary"><?php echo e(translate('Proceed')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>


    <div class="modal fade" id="Adjust_wallet" tabindex="-1"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo e(translate('messages.Adjust_Wallet')); ?>  </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <form action="<?php echo e(route('vendor.wallet.make_wallet_adjustment')); ?>" method="POST" class="needs-validation">
                    <div class="modal-body">
                        <?php echo csrf_field(); ?>
                        <h5 class="mb-5 "><?php echo e(translate('This_will_adjust_the_collected_cash_on_your_earning')); ?> </h5>
                    </div>

                    <div class="modal-footer">
                        <button id="reset_btn" type="reset" data-dismiss="modal" class="btn btn-secondary" ><?php echo e(translate('Close')); ?> </button>
                        <button type="submit" class="btn btn-primary"><?php echo e(translate('Proceed')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/vendor/wallet-method.js"></script>
    <script>
        "use strict";
        $('#withdraw_method').on('change', function () {
    $('#submit_button').attr("disabled","true");
    let method_id = this.value;

    // Set header if need any otherwise remove setup part
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "<?php echo e(route('vendor.wallet.method-list')); ?>" + "?method_id=" + method_id,
        data: {},
        processData: false,
        contentType: false,
        type: 'get',
        success: function (response) {
            $('#submit_button').removeAttr('disabled');
            let method_fields = response.content.method_fields;
            $("#method-filed__div").html("");
            method_fields.forEach((element, index) => {
                $("#method-filed__div").append(`
                    <div class="form-group mt-2">
                        <label for="wr_num" class="fz-16 text-capitalize c1 mb-2">${element.input_name.replaceAll('_', ' ')}</label>
                        <input type="${element.input_type == 'phone' ? 'number' : element.input_type  }" class="form-control" name="${element.input_name}" placeholder="${element.placeholder}" ${element.is_required === 1 ? 'required' : ''}>
                    </div>
                `);
            })

        },
        error: function () {

        }
    });
});


$('.payment-warning').on('click',function (event ){
            event.preventDefault();
            toastr.info(
                "<?php echo e(translate('messages.Currently,_there_are_no_payment_options_available._Please_contact_admin_regarding_any_payment_process_or_queries.')); ?>", {
                    CloseButton: true,
                    ProgressBar: true
                });
        });
$(document).ready(function() {
    $("#withdraw_form").on("submit", function(event) {
        $('#set_disable').attr('disabled', true);

    });
});
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/wallet/disbursement.blade.php ENDPATH**/ ?>