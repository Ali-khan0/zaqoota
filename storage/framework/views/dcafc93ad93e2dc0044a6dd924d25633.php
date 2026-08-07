<?php $__env->startSection('title',translate('Add new coupon')); ?>

<?php $__env->startSection('content'); ?>
<?php ($store_data = \App\CentralLogics\Helpers::get_store_data()); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-add-circle-outlined"></i> <?php echo e(translate('messages.add_new_coupon')); ?></h1>
                </div>
            </div>
        </div>
        <?php ($language=\App\Models\BusinessSetting::where('key','language')->first()); ?>
        <?php ($language = $language->value ?? null); ?>
        <?php ($defaultLang = str_replace('_', '-', app()->getLocale())); ?>
        <!-- End Page Header -->
        <div class="card mb-3">
            <div class="card-body">
                <form action="<?php echo e(route('vendor.coupon.store')); ?>" method="post" class="custom-validation">
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
                                <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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

                                        (<?php echo e(translate('messages.Default')); ?>)
                                    </label>
                                    <input type="text" name="title[]" id="default_title"
                                        class="form-control" placeholder="<?php echo e(translate('messages.new_coupon')); ?>"
                                        required
                                         >
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                            </div>
                                <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="d-none lang_form"
                                        id="<?php echo e($lang); ?>-form">
                                        <div class="form-group error-wrapper">
                                            <label class="input-label"
                                                for="<?php echo e($lang); ?>_title"><?php echo e(translate('messages.title')); ?>

                                                (<?php echo e(strtoupper($lang)); ?>)
                                            </label>
                                            <input type="text" name="title[]" id="<?php echo e($lang); ?>_title"
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
                                            for="title"><?php echo e(translate('messages.title')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                        <input type="text" id="title" name="title[]" class="form-control"
                                            placeholder="<?php echo e(translate('messages.new_coupon')); ?>">
                                    </div>
                                    <input type="hidden" name="lang[]" value="default">
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="form-group error-wrapper">
                                <label class="input-label" for="coupon_type"><?php echo e(translate('messages.coupon_type')); ?></label>
                                <select id="coupon_type" name="coupon_type" class="form-control" >
                                    <option value="default"><?php echo e(translate('messages.default')); ?></option>
                                    <?php if($store_data->sub_self_delivery == 1): ?>
                                    <option value="free_delivery"><?php echo e(translate('messages.free_delivery')); ?></option>
                                    <?php endif; ?>
                            </select>
                            </div>
                        </div>



                        <div class="col-lg-3 col-sm-6">
                            <div class="form-group error-wrapper">
                                <label class="input-label" for="coupon_code"><?php echo e(translate('messages.code')); ?></label>
                                <input id="coupon_code" type="text" name="code" class="form-control"
                                    placeholder="<?php echo e(\Illuminate\Support\Str::random(8)); ?>" required maxlength="100">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="form-group error-wrapper">
                                <label class="input-label" for="coupon_limit"><?php echo e(translate('messages.limit_for_same_user')); ?></label>
                                <input type="number" name="limit" id="coupon_limit" class="form-control" placeholder="<?php echo e(translate('messages.Ex :')); ?> 10" max="100">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="form-group error-wrapper">
                                <label class="input-label" for="date_from"><?php echo e(translate('messages.start_date')); ?></label>
                                <input type="date" name="start_date" class="form-control" id="date_from" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="form-group error-wrapper">
                                <label class="input-label" for="date_to"><?php echo e(translate('messages.expire_date')); ?></label>
                                <input type="date" name="expire_date" class="form-control" id="date_to" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="form-group error-wrapper">
                                <label class="input-label" for="discount_type"><?php echo e(translate('messages.discount_type')); ?></label>
                                <select name="discount_type" class="form-control" id="discount_type">
                                    <option value="amount">
                                            <?php echo e(translate('messages.amount').' ('.\App\CentralLogics\Helpers::currency_symbol().')'); ?>

                                    </option>
                                    <option value="percent" > <?php echo e(translate('messages.percent').' (%)'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="form-group error-wrapper">
                                <label class="input-label" for="discount"><?php echo e(translate('messages.discount')); ?> </label>
                                <input type="number" step="0.01" min="1" max="999999999999.99" name="discount" id="discount" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="form-group error-wrapper">
                                <label class="input-label" for="max_discount"><?php echo e(translate('messages.max_discount')); ?></label>
                                <input type="number" step="0.01" min="0" value="0" max="999999999999.99" name="max_discount" id="max_discount" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="form-group error-wrapper">
                                <label class="input-label" for="min_purchase"><?php echo e(translate('messages.min_purchase')); ?></label>
                                <input id="min_purchase" type="number" step="0.01" name="min_purchase" value="0" min="0" max="999999999999.99" class="form-control"
                                    placeholder="100">
                            </div>
                        </div>
                    </div>
                    <div class="btn--container justify-content-end">
                        <button id="reset_btn" type="button" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.submit')); ?></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header py-2">
                <div class="search--button-wrapper">
                    <h5 class="card-title"><?php echo e(translate('messages.coupon_list')); ?><span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($coupons->total()); ?></span></h5>
                    <form method="get">

                        <!-- Search -->
                        <div class="input--group input-group input-group-merge input-group-flush">
                            <input id="datatableSearch" type="search" value="<?php echo e(request()?->search ?? ''); ?>" name="search" class="form-control" placeholder="<?php echo e(translate('messages.Ex :_Search by title or code')); ?>" aria-label="<?php echo e(translate('messages.search_here')); ?>">
                            <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                        </div>
                        <!-- End Search -->
                    </form>
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
                        "paging":false,
                        }'>
                    <thead class="thead-light">
                    <tr>
                        <th><?php echo e(translate('messages.sl')); ?></th>
                        <th><?php echo e(translate('messages.title')); ?></th>
                        <th><?php echo e(translate('messages.code')); ?></th>
                        <th><?php echo e(translate('messages.type')); ?></th>
                        <th><?php echo e(translate('messages.total_uses')); ?></th>
                        <th><?php echo e(translate('messages.min_purchase')); ?></th>
                        <th><?php echo e(translate('messages.max_discount')); ?></th>
                        <th>
                            <div class="text-center">
                                <?php echo e(translate('messages.discount')); ?>

                            </div>
                        </th>
                        <th><?php echo e(translate('messages.discount_type')); ?></th>
                        <th><?php echo e(translate('messages.start_date')); ?></th>
                        <th><?php echo e(translate('messages.expire_date')); ?></th>

                        <th><?php echo e(translate('messages.status')); ?></th>
                        <th class="text-center"><?php echo e(translate('messages.action')); ?></th>
                    </tr>
                    </thead>

                    <tbody id="set-rows">
                    <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+$coupons->firstItem()); ?></td>
                            <td>
                            <span class="d-block font-size-sm text-body">
                                <?php echo e(Str::limit($coupon['title'],15,'...')); ?>

                            </span>
                            </td>
                            <td><?php echo e($coupon['code']); ?></td>
                            <td><?php echo e(translate('messages.'.$coupon->coupon_type)); ?></td>
                            <td><?php echo e($coupon->total_uses); ?></td>
                            <td>
                                <div class="text-right mw-87px">
                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($coupon['min_purchase'])); ?>

                                </div>
                            </td>
                            <td>
                                <div class="text-right mw-87px">
                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($coupon['max_discount'])); ?>

                                </div>
                            </td>
                            <td>
                                <div class="text-center">
                                    <?php echo e($coupon['discount']); ?>

                                </div>
                            </td>
                            <?php if($coupon['discount_type'] == 'percent'): ?>
                            <td><?php echo e(translate('messages.percent')); ?></td>
                            <?php elseif($coupon['discount_type'] == 'amount'): ?>
                            <td><?php echo e(translate('messages.amount')); ?></td>
                            <?php else: ?>
                            <td><?php echo e($coupon['discount_type']); ?></td>
                            <?php endif; ?>

                            <td><?php echo e($coupon['start_date']); ?></td>
                            <td><?php echo e($coupon['expire_date']); ?></td>

                            <td>
                                <label class="toggle-switch toggle-switch-sm" for="couponCheckbox<?php echo e($coupon->id); ?>">
                                    <input type="checkbox"
                                           data-url="<?php echo e(route('vendor.coupon.status',[$coupon['id'],$coupon->status?0:1])); ?>"
                                          class="toggle-switch-input redirect-url" id="couponCheckbox<?php echo e($coupon->id); ?>" <?php echo e($coupon->status?'checked':''); ?>>
                                    <span class="toggle-switch-label">
                                        <span class="toggle-switch-indicator"></span>
                                    </span>
                                </label>
                            </td>
                            <td>
                                <div class="btn--container justify-content-center">
                                    <a class="ml-2 btn btn-sm btn--warning btn-outline-warning action-btn" href="#0" data-toggle="modal" data-target="#coupon_btn">
                                        <i class="tio-invisible"></i>
                                    </a>
                                    <a class="btn btn-sm btn--primary btn-outline-primary action-btn" href="<?php echo e(route('vendor.coupon.update',[$coupon['id']])); ?>" title="<?php echo e(translate('messages.edit_coupon')); ?>"><i class="tio-edit"></i>
                                    </a>
                                    <a class="btn btn-sm btn--danger btn-outline-danger action-btn form-alert"
                                       data-id="coupon-<?php echo e($coupon['id']); ?>"
                                       data-message="<?php echo e(translate('Want to delete this coupon ?')); ?>"
                                       href="javascript:" title="<?php echo e(translate('messages.delete_coupon')); ?>"><i class="tio-delete-outlined"></i>
                                    </a>
                                    <form action="<?php echo e(route('vendor.coupon.delete',[$coupon['id']])); ?>"
                                    method="post" id="coupon-<?php echo e($coupon['id']); ?>">
                                    <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php if(count($coupons) === 0): ?>
                <div class="empty--data">
                    <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                    <h5>
                        <?php echo e(translate('no_data_found')); ?>

                    </h5>
                </div>
                <?php endif; ?>
                <div class="page-area px-4 pb-3">
                    <div class="d-flex align-items-center justify-content-end">
                        <div>
                            <?php echo $coupons->links(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Table -->
    </div>




    <!-- Coupon Details Modal -->
<div class="modal shedule-modal fade" id="coupon_btn" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content pb-1">
      <div class="d-flex align-items-center justify-content-between gap-2 py-3 px-3">
        <p class="m-0 d-xl-block d-none"></p>
        <div class="text-center">
            <h3 class="title-clr mb-0">Coupon Details</h3>
        </div>
        <button type="button" class="close bg-light w-30px h-30 rounded-circle" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-15">
            <div>
                <h3 class="title-clr mb-0">Super offer (30%)</h3>
                <div class="d-flex align-items-center gap-1">
                    <span class="fs-14">Duration:</span>
                    <p class="fs-14 m-0 text-title">01 Oct 2022 - 05 Jul 2025</p>
                </div>
            </div>
            <div class="bg-warning-10 py-2 px-3 rounded text-center">
                <h2 class="mb-0 text_FF7500">30%</h2>
                <p class="fs-16 text_FF7500 m-0">Discount</p>
            </div>
        </div>
        <ul class="coupon-details-list d-flex flex-wrap bg-light rounded p-3 mb-3">
            <li class="d-flex flex-sm-nowrap flex-wrap list-none li align-items-center gap-1">
                <span class="fs-14 w-135px d-block min-w-135px">Coupon type </span>
                <span>:</span>
                <span class="fs-14 text-title">Store Wise</span>
            </li>
            <li class="d-flex flex-sm-nowrap flex-wrap list-none align-items-center gap-1">
                <span class="fs-14 w-135px d-block min-w-135px">Selected Store </span>
                <span>:</span>
                <span class="fs-14 text-title">Online Market</span>
            </li>
            <li class="d-flex flex-sm-nowrap flex-wrap list-none align-items-center gap-1">
                <span class="fs-14 w-135px d-block min-w-135px">Limit for same user </span>
                <span>:</span>
                <span class="fs-14 text-title">5</span>
            </li>
            <li class="d-flex flex-sm-nowrap flex-wrap list-none align-items-center gap-1">
                <span class="fs-14 w-135px d-block min-w-135px">Max discount($) </span>
                <span>:</span>
                <span class="fs-14 text-title">200.00</span>
            </li>
            <li class="d-flex flex-sm-nowrap flex-wrap list-none align-items-center gap-1">
                <span class="fs-14 w-135px d-block min-w-135px">Min purchase($) </span>
                <span>:</span>
                <span class="fs-14 text-title">100.00</span>
            </li>
            <li class="d-flex flex-sm-nowrap flex-wrap list-none gap-1">
                <span class="fs-14 w-135px d-block min-w-135px">Min purchase($) </span>
                <span>:</span>
                <span class="fs-14 text-title">Esther Howard, Dianne Russell, Darlene Robertson</span>
            </li>
        </ul>
        <div class="bg-light rounded p-3">
            <h5 class="title-clr mb-15">Coupon Code</h5>
            <div class="custom-copy-text position-relative h--45px w-100 rounded overflow-hidden">
                <input type="text" class="text-inside form-control rounded-0 pe-30" value="NewUser" />
                <span class="copy-btn bg-primary text-white d-flex align-items-center justify-content-center w-40px h--45px position-absolute end-cus-0 top-50 cursor-pointer text-primary"><i class="tio-copy text-white"></i></span>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin/js/view-pages/vendor-coupon.js')); ?>"></script>
<script>
    "use strict";
    $(document).on('ready', function () {
        $('#date_from').attr('min',(new Date()).toISOString().split('T')[0]);
        $('#date_to').attr('min',(new Date()).toISOString().split('T')[0]);
    });

        $('#reset_btn').click(function(){
            $('#coupon_title').val('');
            $('#coupon_code').val(null);
            $('#coupon_limit').val(null);
            $('#date_from').val(null);
            $('#date_to').val(null);
            $('#discount_type').val('amount');
            $('#discount').val(null);
            $('#max_discount').val(0);
            $('#min_purchase').val(0);
            $('#select_customer').val(null).trigger('change');
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/coupon/index.blade.php ENDPATH**/ ?>