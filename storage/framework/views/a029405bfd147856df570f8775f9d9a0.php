<?php $__env->startSection('title',translate('messages.account_transaction')); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <div class="page-header">
        <h1 class="page-header-title">
            <span class="page-header-icon">
                <img src="<?php echo e(asset('public/assets/admin/img/collect-cash.png')); ?>" class="w--22" alt="">
            </span>
            <span>
                <?php echo e(translate('messages.collect_cash_transaction')); ?>

            </span>
        </h1>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="<?php echo e(route('admin.transactions.account-transaction.store')); ?>" method='post' id="add_transaction">
                <?php echo csrf_field(); ?>
                <div class="row g-3">
                    <div class="col-lg-4 col-sm-6">
                        <div class="form-group mb-0">
                        <label class="form-label" for="type"><?php echo e(translate('messages.collect_from')); ?><span class="input-label-secondary"></span></label>
                            <select name="type" id="type" class="form-control">
                                <option value="deliveryman"><?php echo e(translate('messages.deliveryman')); ?></option>
                                <option value="store"><?php echo e(translate('messages.store')); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="form-group mb-0">
                            <label class="form-label" for="store"><?php echo e(translate('messages.store')); ?><span class="input-label-secondary"></span></label>
                            <select id="store" name="store_id" data-placeholder="<?php echo e(translate('messages.select_store')); ?>" class="form-control" title="Select Restaurant" disabled>

                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="form-group mb-0">
                            <label class="form-label" for="deliveryman"><?php echo e(translate('messages.deliveryman')); ?><span class="input-label-secondary"></span></label>
                            <select id="deliveryman" name="deliveryman_id" data-placeholder="<?php echo e(translate('messages.select_deliveryman')); ?>" class="form-control" title="Select deliveryman">

                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="form-group mb-0">
                            <label class="form-label" for="method"><?php echo e(translate('messages.payment_method')); ?><span class="input-label-secondary"></span></label>
                            <input class="form-control" type="text" name="method" id="method" required maxlength="191" placeholder="<?php echo e(translate('messages.Ex_:_Card')); ?>">
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="form-group mb-0">
                            <label class="form-label" for="ref"><?php echo e(translate('messages.reference')); ?><span class="input-label-secondary"></span></label>
                            <input  class="form-control" type="text" name="ref" id="ref" maxlength="191">
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="form-group mb-0">
                            <label class="form-label" for="amount"><?php echo e(translate('messages.amount')); ?> <?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?><span class="input-label-secondary" id="account_info"></span></label>
                            <input class="form-control" type="number" min=".01" step="0.01" name="amount" id="amount" max="999999999999.99" placeholder="<?php echo e(translate('messages.Ex_:_1000')); ?>">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="btn--container justify-content-end">
                            <button class="btn btn--reset" type="reset" id="reset_btn"><?php echo e(translate('messages.reset')); ?></button>

                            <button class="btn btn--primary" type="submit"><?php echo e(translate('messages.collect_cash')); ?></button>
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
                        <h5 class="card-title d-flex gap-2 align-items-center">
                            <span>
                                <?php echo e(translate('messages.transaction_history')); ?>

                            </span>
                            <span class="badge badge-soft-secondary" id="itemCount">
                                <?php echo e($account_transaction->total()); ?>

                            </span>
                        </h5>

                        <form class="search-form theme-style">
                            <div class="input-group input--group">
                                <input id="datatableSearch" name="search" type="search" class="form-control h--40px" placeholder="<?php echo e(translate('Ex:_Referance,_Name')); ?>" value="<?php echo e(request()?->search ?? null); ?>" aria-label="<?php echo e(translate('messages.search_here')); ?>">
                                <button type="submit" class="btn btn--secondary h--40px"><i class="tio-search"></i></button>
                            </div>
                        </form>

                        <?php if(request()->get('search')): ?>
                            <button type="reset" class="btn btn--primary ml-2 location-reload-to-base" data-url="<?php echo e(url()->full()); ?>"><?php echo e(translate('messages.reset')); ?></button>
                        <?php endif; ?>


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
                                <a id="export-excel" class="dropdown-item" href="<?php echo e(route('admin.transactions.account-transaction.export', ['type'=>'excel',request()->getQueryString()])); ?>">
                                    <img class="avatar avatar-xss avatar-4by3 mr-2"
                                        src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                        alt="Image Description">
                                    <?php echo e(translate('messages.excel')); ?>

                                </a>
                                <a id="export-csv" class="dropdown-item" href="<?php echo e(route('admin.transactions.account-transaction.export', ['type'=>'csv',request()->getQueryString()])); ?>">
                                    <img class="avatar avatar-xss avatar-4by3 mr-2"
                                        src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                        alt="Image Description">
                                    .<?php echo e(translate('messages.csv')); ?>

                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="datatable"
                            class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0"><?php echo e(translate('SL')); ?></th>
                                    <th class="border-0"><?php echo e(translate('messages.collect_from')); ?></th>
                                    <th class="border-0"><?php echo e(translate('messages.type')); ?></th>
                                    <th class="border-0"><?php echo e(translate('messages.received_at')); ?></th>
                                    <th class="border-0"><?php echo e(translate('messages.amount')); ?></th>
                                    <th class="border-0"><?php echo e(translate('messages.reference')); ?></th>
                                    <th class="border-0 text-center"><?php echo e(translate('messages.action')); ?></th>
                                </tr>
                            </thead>
                            <tbody id="set-rows">
                            <?php $__currentLoopData = $account_transaction; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$at): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($k+$account_transaction->firstItem()); ?></td>
                                    <td>
                                        <?php if($at->store): ?>
                                        <a href="<?php echo e(route('admin.store.view',[$at->store['id'],'module_id'=>$at->store['module_id']])); ?>"><?php echo e(Str::limit($at->store->name, 20, '...')); ?></a>
                                        <?php elseif($at->deliveryman): ?>
                                        <a href="<?php echo e(route('admin.users.delivery-man.preview',[$at->deliveryman->id])); ?>"><?php echo e($at->deliveryman->f_name); ?> <?php echo e($at->deliveryman->l_name); ?></a>
                                        <?php else: ?>
                                            <?php echo e(translate('messages.not_found')); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td><label class="text-uppercase"><?php echo e(translate($at['from_type'])); ?></label></td>
                                    <td><?php echo e(\App\CentralLogics\Helpers::time_date_format($at->created_at)); ?></td>
                                    <td><div class="pl-4">
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($at['amount'])); ?>

                                    </div></td>
                                    <td><div title="<?php echo e(translate($at['ref'])); ?>" class="pl-4">
                                        <?php echo e(Str::limit(translate($at['ref']),40,'...')); ?>


                                    </div></td>
                                    <td>
                                        <div class="btn--container justify-content-center"> <a href="#"
                                            data-payment_method="<?php echo e($at->method); ?>"
                                            data-ref="<?php echo e(translate($at['ref'])); ?>"
                                            data-amount="<?php echo e(\App\CentralLogics\Helpers::format_currency($at['amount'])); ?>"
                                            data-date="<?php echo e(\App\CentralLogics\Helpers::time_date_format($at->created_at)); ?>"
                                            data-type="<?php echo e($at->from_type == 'deliveryman' ?  translate('DeliveryMan_Info') : translate('Store_Info')); ?>"
                                            data-phone="<?php echo e($at->store ?  $at?->store?->phone : $at?->deliveryman?->phone); ?>"
                                            data-address="<?php echo e($at->store ?  $at?->store?->address : $at?->deliveryman?->last_location?->location ?? translate('address_not_found')); ?>"
                                            data-latitude="<?php echo e($at->store ?  $at?->store?->latitude : $at?->deliveryman?->last_location?->location ?? 0); ?>"
                                            data-longitude="<?php echo e($at->store ?  $at?->store?->longitude : $at?->deliveryman?->last_location?->location ?? 0); ?>"
                                            data-name="<?php echo e($at->store ?  $at?->store?->name : $at?->deliveryman?->f_name.' '.$at?->deliveryman?->l_name); ?>"

                                            class="btn action-btn btn--warning btn-outline-warning withdraw-info-show" ><i class="tio-visible"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if(count($account_transaction) !== 0): ?>
                <hr>
                <?php endif; ?>
                <div class="page-area">
                    <?php echo $account_transaction->links(); ?>

                </div>
                <?php if(count($account_transaction) === 0): ?>
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


<div class="sidebar-wrap">
    <div class="withdraw-info-sidebar-overlay"></div>
    <div class="withdraw-info-sidebar">
        <div class="d-flex pb-3">
            <span class="circle bg-light withdraw-info-hide cursor-pointer">
                <i class="tio-clear"></i>
            </span>
        </div>

        <div class="d-flex flex-column align-items-center gap-1 mb-4">
            <h3 class="mb-3"><?php echo e(translate('account_Transaction_Information')); ?></h3>
            <div class="d-flex gap-2 align-items-center fs-12">
                <span><?php echo e(translate('method')); ?>:</span>
                <span id="payment_method" class="text-dark font-semibold"></span>
            </div>
            <div class="d-flex gap-2 align-items-center fs-12">
                <span><?php echo e(translate('amount')); ?>:</span>
                <span class="text-dark font-bold" id="amount"> </span>
            </div>
            <div class="d-flex gap-2 align-items-center fs-12">
                <span><?php echo e(translate('request_time')); ?>:</span>
                <span id="date"></span>
            </div>
            <div class="d-flex gap-2 align-items-center fs-12">
                <span><?php echo e(translate('reference')); ?>:</span>
                <span id="ref"></span>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6 class="mb-0 font-medium" id="type"></h6>
            </div>
            <div class="card-body">
                <div class="key-val-list d-flex flex-column gap-2" style="--min-width: 60px">
                    <div class="key-val-list-item d-flex gap-3">
                        <span><?php echo e(translate('name')); ?>:</span>
                        <span id="name"></span>
                    </div>
                    <div class="key-val-list-item d-flex gap-3">
                        <span><?php echo e(translate('phone')); ?>:</span>
                        <a href="tel:" id="phone" class="text-dark"></a>
                    </div>
                    <div class="key-val-list-item d-flex gap-3">
                        <span><?php echo e(translate('address')); ?>:</span>
                        <a id="address" target="_blank"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
<script>
    "use strict";
    $('.withdraw-info-hide, .withdraw-info-sidebar-overlay').on('click', function () {
        $('.withdraw-info-sidebar, .withdraw-info-sidebar-overlay').removeClass('show');
    });
    $('.withdraw-info-show').on('click', function () {

        let data = $(this).data();
        console.log(data)
            $('.sidebar-wrap #payment_method').text(data.payment_method);
            $('.sidebar-wrap #amount').text(data.amount);
            $('.sidebar-wrap #type').text(data.type);
            $('.sidebar-wrap #date').text(data.date);
            $('.sidebar-wrap #ref').text(data.ref);
            $('.sidebar-wrap #name') .text(data.name);
            $('.sidebar-wrap #phone').text(data.phone).attr('href', 'tel:' + data.phone);
            $('.sidebar-wrap #address').text(data.address).attr('href', "https://www.google.com/maps/search/?api=1&query=" + data.latitude + "," + data.longitude);
            // $('#deliverymanReviewModal').modal('show');

            $('.withdraw-info-sidebar, .withdraw-info-sidebar-overlay').addClass('show');

    })
</script>

<script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/account-index.js"></script>
<script>
    "use strict";

    $('#store').select2({
        ajax: {
            url: '<?php echo e(url('/')); ?>/admin/store/get-stores',
            data: function (params) {
                return {
                    q: params.term, // search term
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

    $('#deliveryman').select2({
        ajax: {
            url: '<?php echo e(url('/')); ?>/admin/users/delivery-man/get-deliverymen',
            data: function (params) {
                return {
                    q: params.term, // search term
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

    $('#store').on('change', function() {
        $.get({
            url: '<?php echo e(url('/')); ?>/admin/store/get-account-data/'+this.value,
            dataType: 'json',
            success: function (data) {
                $('#account_info').html('(<?php echo e(translate('messages.cash_in_hand')); ?>: '+data.cash_in_hand+' <?php echo e(translate('messages.total_earning')); ?>: '+data.earning_balance+')');
            },
        });
    })

    $('#deliveryman').on('change', function() {
        $.get({
            url: '<?php echo e(url('/')); ?>/admin/users/delivery-man/get-account-data/'+this.value,
            dataType: 'json',
            success: function (data) {
                $('#account_info').html('(<?php echo e(translate('messages.cash_in_hand')); ?>: '+data.cash_in_hand+' <?php echo e(translate('messages.total_earning')); ?>: '+data.earning_balance+')');
            },
        });
    })

    $('#add_transaction').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post({
            url: '<?php echo e(route('admin.transactions.account-transaction.store')); ?>',
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
                        location.href = '<?php echo e(route('admin.transactions.account-transaction.index')); ?>';
                    }, 2000);
                }
            }
        });
    });


</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/account/index.blade.php ENDPATH**/ ?>