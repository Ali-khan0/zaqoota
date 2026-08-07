<?php $__env->startSection('title',translate('messages.disbursement')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>


<div class="content container-fluid">
    <div class="page-header">
        <h1 class="page-header-title">
            <span class="page-header-icon">
                <img src="<?php echo e(asset('/public/assets/admin/img/report/new/disburstment.png')); ?>" class="w--22" alt="">
            </span>
            <span><?php echo e(translate('Disbursement_Details')); ?></span>
        </h1>
    </div>
    <!-- Reports -->

    <div class="card">
        <div class="card-header flex-wrap justify-content-between gap-3">
            <div class="left">
                <h3 class="m-0 font-bold"><?php echo e($disbursement->title); ?>

                    <?php if($disbursement->status=='pending'): ?>
                        <label class="badge badge-soft-primary"><?php echo e(translate('pending')); ?></label>
                    <?php elseif($disbursement->status=='completed'): ?>
                        <label class="badge badge-soft-success"><?php echo e(translate('Completed')); ?></label>
                    <?php elseif($disbursement->status=='partially_completed'): ?>
                        <label class="badge badge-soft-info"><?php echo e(translate('partially_completed')); ?></label>
                    <?php else: ?>
                        <label class="badge badge-soft-danger"><?php echo e(translate('canceled')); ?></label>
                    <?php endif; ?>
                </h3>
                <span><?php echo e(translate('created_at')); ?> <?php echo e(\App\CentralLogics\Helpers::time_date_format($disbursement->created_at)); ?></span>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-2">
                <div class="d-flex flex-wrap align-items-center mr-2">
                    <span><?php echo e(translate('total_amount')); ?></span> <span class="mx-2">:</span> <h3 class="m-0"><?php echo e(\App\CentralLogics\Helpers::format_currency($disbursement['total_amount'])); ?></h3>
                </div>
                <div class="w-16rem">
                    <select name="module_id" class="form-control js-select2-custom set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="module_id"
                            title="<?php echo e(translate('messages.select_modules')); ?>">
                        <option value="" <?php echo e(!request('module_id') ? 'selected' : ''); ?>>
                            <?php echo e(translate('messages.all_modules')); ?></option>
                        <?php $__currentLoopData = \App\Models\Module::notParcel()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($module->id); ?>"
                                <?php echo e(request('module_id') == $module->id ? 'selected' : ''); ?>>
                                <?php echo e($module['module_name']); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="w-16rem">
                    <select name="store_id"
                            data-placeholder="<?php echo e(translate('messages.select_store')); ?>"
                            class="js-data-example-ajax form-control store-filter" data-url="<?php echo e(url()->full()); ?>">
                        <?php if(isset($store)): ?>
                            <option value="<?php echo e($store->id); ?>" selected><?php echo e($store->name); ?></option>
                        <?php else: ?>
                            <option value="all" selected><?php echo e(translate('messages.all_stores')); ?></option>
                        <?php endif; ?>
                    </select>

                </div>
                <div class="w-16rem">
                    <select name="payment_method_id" data-url="<?php echo e(url()->current()); ?>"
                            data-placeholder="<?php echo e(translate('messages.select_payment_method')); ?>"
                            class="js-select2-custom form-control payment-method-filter">

                        <option value="all"><?php echo e(translate('messages.all_payment_methods')); ?></option>
                        <?php $__currentLoopData = \App\Models\WithdrawalMethod::ofStatus(1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($method['id']); ?>"
                                <?php echo e(isset($payment_method_id) && is_numeric($payment_method_id) && ($payment_method_id  == $method['id']) ? 'selected' : ''); ?>>
                                <?php echo e($method['method_name']); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-header border-0 py-2">
            <div class="search--button-wrapper">
                <h2 class="card-title">
                    <?php echo e(translate('Total_Disbursements')); ?> <span class="badge badge-soft-secondary ml-2" id="countItems"><?php echo e($disbursement_stores->total()); ?></span>
                </h2>
                <form class="search-form">
                    <!-- Search -->
                    <div class="input--group input-group input-group-merge input-group-flush">
                        <input class="form-control" value="<?php echo e(request()?->search  ?? null); ?>" placeholder="<?php echo e(translate('search_by_store_info')); ?>" name="search">
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
                        <a id="export-excel" class="dropdown-item" href="<?php echo e(route('admin.transactions.store-disbursement.export', ['id'=>$disbursement->id,'type'=>'excel',request()->getQueryString()])); ?>">
                            <img class="avatar avatar-xss avatar-4by3 mr-2" src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg" alt="Image Description">
                            <?php echo e(translate('messages.excel')); ?>

                        </a>
                        <a id="export-csv" class="dropdown-item" href="<?php echo e(route('admin.transactions.store-disbursement.export', ['id'=>$disbursement->id,'type'=>'csv',request()->getQueryString()])); ?>">
                            <img class="avatar avatar-xss avatar-4by3 mr-2" src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg" alt="Image Description">
                            <?php echo e(translate('messages.csv')); ?>

                        </a>
                        <a id="export-pdf" class="dropdown-item" href="<?php echo e(route('admin.transactions.store-disbursement.export', ['id'=>$disbursement->id,'type'=>'pdf',request()->getQueryString()])); ?>">
                            <img class="avatar avatar-xss avatar-4by3 mr-2" src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/pdf.svg" alt="Image Description">
                            <?php echo e(translate('messages.pdf')); ?>

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
                            <th>
                                <label class="form-check form--check mb-14">
                                    <input type="checkbox" id="select-all" class="form-check-input">
                                </label>
                            </th>
                            <th><?php echo e(translate('sl')); ?></th>
                            <th><?php echo e(translate('Store_Info')); ?></th>
                            <th><?php echo e(translate('Disburse_Amount')); ?></th>
                            <th><?php echo e(translate('Payment_method')); ?></th>
                            <th><?php echo e(translate('status')); ?></th>
                            <th>
                                <div class="text-center">
                                    <?php echo e(translate('action')); ?>

                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $disbursement_stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <label class="form-check form--check mb-14">
                                        <input type="checkbox" name="store_ids[]" class="form-check-input rest-check" value="<?php echo e($store->store_id); ?>">
                                    </label>
                                </td>
                                <td>
                                    <span class="font-weight-bold"><?php echo e($key+ $disbursement_stores->firstItem()); ?></span>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('admin.transactions.store.view', $store->store->id)); ?>" alt="view store"
                                        class="table-rest-info">
                                        <div class="info">
                                            <span class="d-block text-body">
                                                <?php echo e(Str::limit($store->store->name, 20, '...')); ?><br>
                                            </span>
                                        </div>
                                    </a>
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

                                        <?php if($store->status == 'completed'): ?>
                                            <a class="btn btn-sm btn--danger btn-outline-danger action-btn action-btn-section" href="<?php echo e(route('admin.transactions.store-disbursement.change-status', ['id'=>$store->id,'status'=>'pending'])); ?>" data-toggle="tooltip" title="<?php echo e(translate('Reverse_status_Back_to_Pending')); ?>">
                                                <i class="tio-restore"></i>
                                            </a>
                                        <?php else: ?>
                                            <?php if($store->status != 'canceled'): ?>
                                            <a class="btn btn-sm btn--danger btn-outline-danger action-btn action-btn-section" href="<?php echo e(route('admin.transactions.store-disbursement.change-status', ['id'=>$store->id,'status'=>'canceled'])); ?>" data-toggle="tooltip" title="<?php echo e(translate('cancel')); ?>">
                                                <i class="tio-clear"></i>
                                            </a>
                                            <?php endif; ?>
                                            <a class="btn btn-sm btn--primary btn-outline-primary action-btn action-btn-section" href="<?php echo e(route('admin.transactions.store-disbursement.change-status', ['id'=>$store->id,'status'=>'completed'])); ?>" title="<?php echo e(translate('complete')); ?>" data-toggle="tooltip">
                                                <i class="tio-done"></i>
                                            </a>
                                        <?php endif; ?>
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
                                                <div class="mt-3 btn--container justify-content-end">
                                                    <?php if($store->status =='pending'): ?>
                                                    <a type="button" href="<?php echo e(route('admin.transactions.store-disbursement.change-status', ['id'=>$store->id,'status'=>'canceled'])); ?>" class="btn btn--reset" ><?php echo e(translate('cancel')); ?></a>
                                                    <?php endif; ?>
                                                    <?php if($store->status != 'completed'): ?>
                                                    <a type="button" href="<?php echo e(route('admin.transactions.store-disbursement.change-status', ['id'=>$store->id,'status'=>'completed'])); ?>" class="btn btn--primary"><?php echo e(translate('complete')); ?></a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php if(!$disbursement_stores): ?>
                    <div class="empty--data">
                        <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                        <h5>
                            <?php echo e(translate('no_data_found')); ?>

                        </h5>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="page-area px-4 pb-3">
            <div class="d-flex align-items-center justify-content-end">
                <div>
                    <?php echo $disbursement_stores->links(); ?>

                </div>
            </div>
        </div>
    </div>

</div>



<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script>
        "use strict";
        $(document).ready(function() {
            let disbursement_id = sessionStorage.getItem('disbursement_id');
            if(disbursement_id && (disbursement_id != <?php echo e($disbursement->id); ?>)){
                sessionStorage.removeItem('selectedValues');
                sessionStorage.removeItem('selectedDmValues');
                sessionStorage.removeItem('disbursement_id');
            }
            let storedValues = sessionStorage.getItem('selectedValues');
            // Initialize as an array
            let checkedValues = storedValues ? JSON.parse(storedValues) : [];

            let storeIds = <?php echo e($store_ids); ?>;

            if (checkedValues.length > 0) {
                $('#action-section').show();
                $('.action-btn-section').hide();
            } else {
                $('#action-section').hide();
                $('.action-btn-section').show();
            }

            if ((checkedValues.length > 0) && (checkedValues.length == storeIds.length)) {
                $('#select-all').prop('checked', true);
            }

            $('.rest-check').each(function() {
                let checkboxValue = parseInt($(this).val());
                if (checkedValues.includes(checkboxValue)) {
                    $(this).prop('checked', true);
                }
            });


            $('#select-all').on('click', function() {
                if (this.checked) {
                    $('.rest-check').each(function() {
                        this.checked = true;
                    });
                    checkedValues = storeIds;
                } else {
                    $('.rest-check').each(function() {
                        this.checked = false;
                    });
                    checkedValues = [];
                }
                saveSelectedValues();
            });

            $('.rest-check').on('click', function() {
                if ($('.rest-check:checked').length == $('.rest-check').length) {
                    $('#select-all').prop('checked', true);
                } else {
                    $('#select-all').prop('checked', false);
                }
                let value = parseInt($(this).val());
                console.log(value);
                if (this.checked) {
                    // Add the value to the array when the checkbox is checked
                    checkedValues.push(value);
                } else {
                    // Remove the value from the array when the checkbox is unchecked
                    let index = checkedValues.indexOf(value);
                    if (index !== -1) {
                        checkedValues.splice(index, 1);
                    }
                }
                saveSelectedValues();
                console.log(checkedValues);
            });

            function saveSelectedValues() {
                if (checkedValues.length > 0) {
                    $('#action-section').show();
                    $('.action-btn-section').hide();
                } else {
                    $('#action-section').hide();
                    $('.action-btn-section').show();
                }
                // Store the selected values in sessionStorage as a JSON string
                sessionStorage.setItem('selectedValues', JSON.stringify(checkedValues));
                sessionStorage.setItem('disbursement_id', <?php echo e($disbursement->id); ?>);
            }

            $('#complete').on('click', function() {
                $.get({
                    url: '<?php echo e(route('admin.transactions.store-disbursement.status')); ?>',
                    dataType: 'json',
                    data: {
                        disbursement_id: <?php echo e($disbursement->id); ?>,
                        store_ids: checkedValues,
                        status: 'completed'
                    },
                    beforeSend: function() {
                        $('#loading').show();
                    },
                    success: function(response) {
                        checkedValues = [];
                        saveSelectedValues();
                        if (response.status == 'error') {
                            toastr.error(response.message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }else if(response.status == 'success'){
                            toastr.success(response.message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                            location.reload();
                        }

                    },
                    complete: function() {
                        $('#loading').hide();
                    },
                });
            });
            $('#cancel').on('click', function() {
                $.get({
                    url: '<?php echo e(route('admin.transactions.store-disbursement.status')); ?>',
                    dataType: 'json',
                    data: {
                        disbursement_id: <?php echo e($disbursement->id); ?>,
                        store_ids: checkedValues,
                        status: 'canceled'
                    },
                    beforeSend: function() {
                        $('#loading').show();
                    },
                    success: function(response) {
                        if (response.status == 'error') {
                            toastr.error(response.message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }else if(response.status == 'success'){
                            checkedValues = [];
                            saveSelectedValues();
                            toastr.success(response.message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                            location.reload();
                        }

                    },
                    complete: function() {
                        $('#loading').hide();
                    },
                });
            });




            $('.js-data-example-ajax').select2({
                ajax: {
                    url: '<?php echo e(url('/')); ?>/admin/store/get-stores',
                    data: function(params) {
                        return {
                            q: params.term, // search term
                            all:true,
                            <?php if(isset($zone)): ?>
                                zone_ids: [<?php echo e($zone->id); ?>],
                            <?php endif; ?>
                            <?php if(request('module_id')): ?>
                            module_id: <?php echo e(request('module_id')); ?>,
                            <?php endif; ?>

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

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/store-disbursement/view.blade.php ENDPATH**/ ?>