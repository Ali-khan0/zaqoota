<?php $__env->startSection('title',translate('messages.coupons')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/add.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('Add new coupon')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="row g-2">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo e(route('admin.coupon.store')); ?>" method="POST" class="">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-12">
                                    <?php if($language): ?>
                                    <ul class="nav nav-tabs mb-3 border-0">
                                        <li class="nav-item">
                                            <a class="nav-link lang_link active"
                                            href="#"
                                            id="default-link"><?php echo e(translate('messages.default')); ?></a>
                                        </li>
                                        <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="nav-item">
                                                <a class="nav-link lang_link"
                                                    href="#"
                                                    id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                    <div class="lang_form" id="default-form">
                                        <div class="form-group error-wrapper">
                                            <label class="input-label"
                                                for="default_title"><?php echo e(translate('messages.title')); ?>

                                                (Default)
                                            </label>
                                            <input type="text" value="<?php echo e(old('title.0')); ?>" name="title[]" id="default_title" required
                                                class="form-control" placeholder="<?php echo e(translate('messages.new_coupon')); ?>" >
                                        </div>
                                        <input type="hidden" name="lang[]" value="default">
                                    </div>
                                        <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="d-none lang_form"
                                                id="<?php echo e($lang); ?>-form">
                                                <div class="form-group error-wrapper">
                                                    <label class="input-label"
                                                        for="<?php echo e($lang); ?>_title"><?php echo e(translate('messages.title')); ?>

                                                        (<?php echo e(strtoupper($lang)); ?>)
                                                    </label>
                                                    <input type="text" name="title[]"   value="<?php echo e(old('title.' . $key+1)); ?>" id="<?php echo e($lang); ?>_title"
                                                        class="form-control" placeholder="<?php echo e(translate('messages.new_coupon')); ?>"
                                                         >
                                                </div>
                                                <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <div id="default-form">
                                            <div class="form-group error-wrapper">
                                                <label class="input-label"
                                                    for="exampleFormControlInput1"><?php echo e(translate('messages.title')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                                <input type="text" name="title[]" class="form-control"
                                                    placeholder="<?php echo e(translate('messages.new_coupon')); ?>">
                                            </div>
                                            <input type="hidden" name="lang[]" value="default">
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-4 col-lg-3 col-sm-6">
                                    <div class="form-group error-wrapper">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.coupon_type')); ?></label>
                                        <select name="coupon_type" id="coupon_type" class="form-control" required>
                                            <option disabled selected>---<?php echo e(translate('messages.Select_coupon_type')); ?>---</option>
                                            <option value="store_wise"><?php echo e(translate('messages.store_wise')); ?></option>
                                            <option value="zone_wise"><?php echo e(translate('messages.zone_wise')); ?></option>
                                            <option value="free_delivery"><?php echo e(translate('messages.free_delivery')); ?></option>
                                            <option value="first_order"><?php echo e(translate('messages.first_order')); ?></option>
                                            <option value="default"><?php echo e(translate('messages.default')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-3 col-sm-6" id="store_wise">
                                    <div class="form-group error-wrapper">
                                        <label class="input-label" for="exampleFormControlSelect1"><?php echo e(translate('messages.store')); ?><span
                                                class="input-label-secondary"></span></label>
                                        <select name="store_ids[]" id="store_id" class="js-data-example-ajax form-control" data-placeholder="<?php echo e(translate('messages.select_store')); ?>" title="<?php echo e(translate('messages.select_store')); ?>">
                                            <option disabled selected>---<?php echo e(translate('messages.select_store')); ?>---</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-3 col-sm-6" id="zone_wise">
                                    <div class="form-group error-wrapper">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.select_zone')); ?></label>
                                        <select name="zone_ids[]" id="choice_zones"
                                            class="form-control multiple-select2"
                                            multiple="multiple" data-placeholder="<?php echo e(translate('messages.select_zone')); ?>">
                                        <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($zone->id); ?>"><?php echo e($zone->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-6" id="customer_wise">

                                    <div class="form-group pickup-zone-tag error-wrapper">
                                        <label class="input-label" for="select_customer"><?php echo e(translate('messages.select_customer')); ?></label>
                                        <select name="customer_ids[]" id="select_customer"
                                            class="form-control  multiple-select2" multiple="multiple" data-placeholder="<?php echo e(translate('messages.select_customer')); ?>">
                                            <option  value="all"><?php echo e(translate('messages.all')); ?> </option>
                                            <?php $__currentLoopData = \App\Models\User::withoutGlobalScopes()->get(['id','f_name','l_name']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option class="select_customer_option" value="<?php echo e($user->id); ?>" <?php echo e((isset($customer) && is_numeric($customer) && ($customer == $user->id))?'selected':''); ?>><?php echo e($user->f_name.' '.$user->l_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-3 col-sm-6">
                                    <div class="form-group error-wrapper">
                                        <div class="d-flex justify-content-between">
                                            <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.code')); ?></label>
                                            
                                        </div>

                                        <input type="text" name="code" class="form-control" value="<?php echo e(old('code')); ?>"
                                            placeholder="<?php echo e(\Illuminate\Support\Str::random(8)); ?>" required maxlength="100">
                                    </div>
                                </div>
                                <div id="limit_for_same_user" class="col-md-4 col-lg-3 col-sm-6">
                                    <div class="form-group error-wrapper">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.limit_for_same_user')); ?></label>
                                        <input type="number" name="limit" value="<?php echo e(old('limit')); ?>" id="coupon_limit" class="form-control" placeholder="EX: 10" min="1" max="100">
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-3 col-sm-6">
                                    <div class="form-group error-wrapper">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.start_date')); ?></label>
                                        <input type="date" name="start_date" value="<?php echo e(old('start_date')); ?>" class="form-control" id="date_from" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-3 col-sm-6">
                                    <div class="form-group error-wrapper">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.expire_date')); ?></label>
                                        <input type="date" name="expire_date" value="<?php echo e(old('expire_date')); ?>" class="form-control" id="date_to" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-3 col-sm-6">
                                    <div class="form-group error-wrapper">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.discount_type')); ?></label>
                                        <select name="discount_type" class="form-control" id="discount_type" required>
                                            <option value="amount"><?php echo e(translate('messages.amount')); ?> (<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)
                                            </option>
                                            <option value="percent"><?php echo e(translate('messages.percent')); ?> (%)</option>
                                        </select>
                                    </div>
                                </div>
                                   <div class="col-md-4 col-lg-3 col-sm-6">
                                    <div class="form-group error-wrapper">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.min_purchase')); ?> (<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)</label>
                                        <input type="number" step="0.01" id="min_purchase" value="<?php echo e(old('min_purchase') ?? 0); ?>" name="min_purchase"   min="0" max="999999999999.99" class="form-control"
                                            placeholder="100">
                                    </div>
                                </div>

                                <div class="col-md-4 col-lg-3 col-sm-6">
                                    <div class="form-group error-wrapper">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.discount')); ?>

                                            <span class="input-label-secondary text--title" data-toggle="tooltip"
                                                data-placement="right"
                                                data-original-title="<?php echo e(translate('Currently_you_need_to_manage_discount_with_the_Store.')); ?>">
                                                <i class="tio-info-outined"></i>
                                            </span>
                                        </label>
                                        <input type="number" step="0.01" min="1" max="999999999999.99" value="<?php echo e(old('discount')); ?>" name="discount" id="discount" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-3 col-sm-6">
                                    <div class="form-group error-wrapper">
                                        <label class="input-label" for="max_discount"><?php echo e(translate('messages.max_discount')); ?> (<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)</label>
                                        <input type="number" step="0.01" min="0" value="<?php echo e(old('max_discount')?? 0); ?>"  max="999999999999.99" name="max_discount" id="max_discount" class="form-control" readonly>
                                    </div>
                                </div>

                            </div>
                            <div class="btn--container justify-content-end">
                                <button type="reset" id="reset_btn" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                                <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.submit')); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header py-2 border-0">
                        <div class="search--button-wrapper">
                            <h5 class="card-title"><?php echo e(translate('messages.coupon_list')); ?><span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($coupons->total()); ?></span></h5>
                            <form class="search-form min--270">

                                <!-- Search -->
                                <div class="input-group input--group">
                                    <input id="datatableSearch" type="search" name="search" value="<?php echo e(request()?->search ?? null); ?>" class="form-control" placeholder="<?php echo e(translate('messages.Ex:_Coupon_Title_Or_Code')); ?>" aria-label="<?php echo e(translate('messages.search_here')); ?>">
                                    <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                                </div>
                                <!-- End Search -->
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
                                    <a id="export-excel" class="dropdown-item" href="
                                        <?php echo e(route('admin.coupon.coupon_export', ['type' => 'excel', request()->getQueryString()])); ?>

                                        ">
                                        <img class="avatar avatar-xss avatar-4by3 mr-2"
                                            src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                            alt="Image Description">
                                        <?php echo e(translate('messages.excel')); ?>

                                    </a>
                                    <a id="export-csv" class="dropdown-item" href="
                                    <?php echo e(route('admin.coupon.coupon_export', ['type' => 'csv', request()->getQueryString()])); ?>">
                                        <img class="avatar avatar-xss avatar-4by3 mr-2"
                                            src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                            alt="Image Description">
                                        .<?php echo e(translate('messages.csv')); ?>

                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Table -->
                    <div class="table-responsive datatable-custom" id="table-div">
                        <table id="columnSearchDatatable"
                               class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                               data-hs-datatables-options='{
                                "order": [],
                                "orderCellsTop": true,

                                "entries": "#datatableEntries",
                                "isResponsive": false,
                                "isShowPaging": false,
                                "paging":false
                               }'>
                            <thead class="thead-light">
                            <tr>
                                <th class="border-0"><?php echo e(translate('sl')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.title')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.code')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.type')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.total_uses')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.min_purchase')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.max_discount')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.discount')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.discount_type')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.start_date')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.expire_date')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.status')); ?></th>
                                <th class="border-0 text-center"><?php echo e(translate('messages.action')); ?></th>
                            </tr>
                            </thead>

                            <tbody id="set-rows">
                            <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key+$coupons->firstItem()); ?></td>
                                    <td>
                                    <span title="<?php echo e($coupon['title']); ?>" class="d-block font-size-sm text-body">
                                    <?php echo e(Str::limit($coupon['title'],15,'...')); ?>

                                    </span>
                                    </td>
                                    <td><?php echo e($coupon['code']); ?></td>

                                    <td><?php echo e(translate('messages.'.$coupon->coupon_type)); ?></td>
                                    <td><?php echo e($coupon->total_uses); ?></td>
                                    <td><?php echo e(\App\CentralLogics\Helpers::format_currency($coupon['min_purchase'])); ?></td>
                                    <td><?php echo e(\App\CentralLogics\Helpers::format_currency($coupon['max_discount'])); ?></td>
                                    <td><?php echo e($coupon['discount']); ?></td>
                                    <td><?php echo e(translate($coupon['discount_type'])); ?> <?php echo e($coupon['discount_type'] == 'amount' ? (\App\CentralLogics\Helpers::currency_symbol())  : ( $coupon['discount_type'] == 'percent' ? ("%") : '')); ?></td>
                                    <td><?php echo e(\App\CentralLogics\Helpers::date_format($coupon['start_date'])); ?></td>
                                    <td><?php echo e(\App\CentralLogics\Helpers::date_format($coupon['expire_date'])); ?></td>
                                    <td>
                                        <label class="toggle-switch toggle-switch-sm" for="couponCheckbox<?php echo e($coupon->id); ?>">
                                            <input type="checkbox" data-url="<?php echo e(route('admin.coupon.status',[$coupon['id'],$coupon->status?0:1])); ?>" class="toggle-switch-input redirect-url" id="couponCheckbox<?php echo e($coupon->id); ?>" <?php echo e($coupon->status?'checked':''); ?>>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a class="ml-2 btn btn-sm btn--warning btn-outline-warning action-btn data-info-show" href="#0" data-toggle="modal" data-target="#coupon_btn"
                                            data-id="<?php echo e($coupon['id']); ?>"
                                            data-url="<?php echo e(route('admin.coupon.viewCoupon',[$coupon['id']])); ?>"
                                            >
                                                <i class="tio-invisible"></i>
                                            </a>
                                            <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route('admin.coupon.update',[$coupon['id']])); ?>"title="<?php echo e(translate('messages.edit_coupon')); ?>"><i class="tio-edit"></i>
                                            </a>
                                            <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:" data-id="coupon-<?php echo e($coupon['id']); ?>" data-message="<?php echo e(translate('Want to delete this coupon ?')); ?>" title="<?php echo e(translate('messages.delete_coupon')); ?>"><i class="tio-delete-outlined"></i>
                                            </a>
                                            <form action="<?php echo e(route('admin.coupon.delete',[$coupon['id']])); ?>"
                                            method="post" id="coupon-<?php echo e($coupon['id']); ?>">
                                                <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                        <?php if(count($coupons) !== 0): ?>
                        <hr>
                        <?php endif; ?>
                        <div class="page-area">
                            <?php echo $coupons->links(); ?>

                        </div>
                        <?php if(count($coupons) === 0): ?>
                        <div class="empty--data">
                            <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                            <h5>
                                <?php echo e(translate('no_data_found')); ?>

                            </h5>
                        </div>
                        <?php endif; ?>
                </div>
            </div>
            <!-- End Table -->
        </div>
    </div>

<!-- Coupon Details Modal -->
<div class="modal shedule-modal fade" id="coupon_btn" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content pb-1">
      <div class="d-flex align-items-center justify-content-between gap-2 py-3 px-3">
        <p class="m-0 d-xl-block d-none"></p>
        <div class="text-center">
            <h3 class="title-clr mb-0"><?php echo e(translate('messages.Coupon Details')); ?></h3>
        </div>
        <button type="button" class="close bg-light w-30px h-30 rounded-circle" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="data-view">

      </div>

    </div>
  </div>
</div>
    <input type="hidden" id="min-purchase-toast" value="<?php echo e(translate('messages.Discount amount cannot be greater than minimum purchase amount')); ?>">

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/coupon-index.js"></script>
<script>
    "use strict";
$(document).on('click', '.copy-to-clipboard', function () {
    copyToClipboardById($(this).data('id'));
});

function copyToClipboardById(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        navigator.clipboard.writeText(element.value)
            .then(() => {
                toastr.success('Copied to clipboard!');
            })
            .catch(() => {
                toastr.error('Failed to copy!');
            });
    } else {
        toastr.warning('Element not found.');
    }
}
    $(document).on('ready', function () {

        let module_id = <?php echo e(Config::get('module.current_module_id')); ?>;

        $('.js-data-example-ajax').select2({
            ajax: {
                url: '<?php echo e(url('/')); ?>/admin/store/get-stores',
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        module_id: module_id
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

    });
    $('#select_customer').on('change', function () {
        let customer = $(this).val();
        if (Array.isArray(customer) && customer.includes("all")) {
            $('.select_customer_option').prop('disabled', true);
            customer = ["all"];
            $(this).val(customer);
        } else {
            $('.select_customer_option').prop('disabled', false);
        }
    });

      $(document).on('click', '.data-info-show', function() {
            let id = $(this).data('id');
            let url = $(this).data('url');
            $('#content-disable').addClass('disabled');
            fetch_data(id, url)
        })



        function fetch_data(id, url) {
            $.ajax({
                url: url,
                type: "get",
                beforeSend: function() {
                    $('#data-view').empty();
                    $('#loading').show()
                },
                success: function(data) {
                    $("#data-view").append(data.view);
                },
                complete: function() {
                    $('#loading').hide()
                }
            })
        }


    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/coupon/index.blade.php ENDPATH**/ ?>