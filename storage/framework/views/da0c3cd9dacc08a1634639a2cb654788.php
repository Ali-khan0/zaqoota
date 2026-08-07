<?php
    $vendorData = \App\CentralLogics\Helpers::get_store_data();
    $title = $vendorData?->module_type == 'rental' && addon_published_status('Rental') ? 'Provider' : 'Store';
?>


<?php $__env->startSection('title', translate('messages.' . $title . '_wallet')); ?>

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
                            <?php echo e(translate('messages.' . $title . '_wallet')); ?>

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

        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="datatable"
                       class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                       data-hs-datatables-options='{
                                    "order": [],
                                    "orderCellsTop": true,
                                    "paging":false
                                }' >
                    <thead class="thead-light">
                    <tr>
                        <th><?php echo e(translate('messages.sl')); ?></th>
                        <th><?php echo e(translate('messages.amount')); ?></th>
                        <th><?php echo e(translate('messages.request_time')); ?></th>
                        <th><?php echo e(translate('messages.disbursement_method')); ?></th>
                        <th><?php echo e(translate('messages.Transaction_Type')); ?></th>
                        <th><?php echo e(translate('messages.status')); ?></th>
                        <th ><?php echo e(translate('messages.note')); ?></th>
                        <th class="w-5px"><?php echo e(translate('messages.Action')); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $withdraw_req; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$wr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <tr>
                            <td><?php echo e($k+$withdraw_req->firstItem()); ?></td>
                            <td> <?php echo e(\App\CentralLogics\Helpers::format_currency($wr['amount'])); ?></td>

                            <td>
                                <span class="d-block"><?php echo e(\App\CentralLogics\Helpers::time_date_format($wr['created_at'])); ?></span>
                            </td>
                            <td>
                                <?php if($wr->method): ?>

                                    <a href="#" data-toggle="modal" data-target="#exampleModal1-<?php echo e($wr->id); ?>">
                                        <?php echo e(translate($wr->method->method_name)); ?></a>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal1-<?php echo e($wr->id); ?>" tabindex="-1"  role="dialog" aria-labelledby="exampleModalLabel"        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel"><?php echo e(translate('messages.disbursement_method_details')); ?>  </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>

                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <?php $__currentLoopData = json_decode($wr->withdrawal_method_fields, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$method_field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <label class="mt-2"  for="<?php echo e($key); ?>"><?php echo e(translate($key)); ?></label>
                                                            <input type="text" class="form-control" readonly value="<?php echo e($method_field); ?>" id="<?php echo e($key); ?>">
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button id="reset_btn" type="reset" data-dismiss="modal" class="btn btn-secondary" ><?php echo e(translate('Close')); ?> </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php else: ?>
                                    <?php echo e(translate('Default_method')); ?>

                                <?php endif; ?>

                            </td>
                            <td>
                                <?php if($wr->type ==  'adjustment' ): ?>
                                    <?php echo e(translate('Wallet_Adjustment')); ?>

                                <?php elseif($wr->type == 'manual' ): ?>
                                    <?php echo e(translate('Withdraw_Request')); ?>

                                <?php elseif($wr->type == 'disbursement' ): ?>
                                    <?php echo e(translate('disbursement')); ?>

                                <?php else: ?>
                                    <?php echo e(translate($wr->type)); ?>

                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($wr->approved==0): ?>
                                    <label class="badge badge-soft-info"><?php echo e(translate('messages.pending')); ?></label>
                                <?php elseif($wr->approved==1): ?>
                                    <label class="badge badge-soft-success"><?php echo e(translate('messages.approved')); ?></label>
                                <?php else: ?>
                                    <label class="badge badge-soft-danger"><?php echo e(translate('messages.denied')); ?></label>
                                <?php endif; ?>
                            </td>


                            <td >
                                <?php if($wr->transaction_note ): ?>
                                    <?php if($wr->transaction_note == 'Store_wallet_adjustment_partial' ): ?>
                                   <?php echo e(translate('Adjusted_Amount_Partially')); ?>

                                    <?php elseif($wr->transaction_note == 'Store_wallet_adjustment_full' ): ?>
                                        <?php echo e(translate('Adjusted_Amount')); ?>

                                    <?php else: ?>
                                        <?php echo Str::limit(translate($wr->transaction_note), 20,
                                   '<a  href="#" class="showMyModal" data-message="'.translate($wr->transaction_note).'" >...Read more.</a>'
                                   ); ?>

                                    <?php endif; ?>

                                <?php else: ?>
                                    <?php echo e(translate('messages.N/A')); ?>

                                <?php endif; ?>
                            </td>

                            <td>

                                <?php if($wr->approved==0): ?>
                                    <a class="btn btn-outline-danger btn--danger action-btn form-alert" href="javascript:" data-id="withdraw-<?php echo e($wr['id']); ?>" data-message="<?php echo e(translate('Want to delete this  ?')); ?>" title="<?php echo e(translate('messages.delete')); ?>"><i class="tio-delete-outlined"></i>
                                    </a>

                                    <form action="<?php echo e(route('vendor.wallet.close-request',[$wr['id']])); ?>"
                                          method="post" id="withdraw-<?php echo e($wr['id']); ?>">
                                        <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                    </form>
                                <?php else: ?>
                                    <label><?php echo e(translate('messages.complete')); ?></label>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php if(count($withdraw_req) === 0): ?>
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
            <?php echo e($withdraw_req->links()); ?>

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

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/wallet/index.blade.php ENDPATH**/ ?>