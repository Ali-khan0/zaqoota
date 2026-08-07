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
        <!-- End Page Header -->
        <div class="card mb-3">
            <div class="card-body">
                <form action="" method="post">
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
                                    <div class="form-group">
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
                                        <div class="form-group">
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
                                    <div class="form-group">
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
                            <div class="form-group">
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
                            <div class="form-group">
                                <label class="input-label" for="coupon_code"><?php echo e(translate('messages.code')); ?></label>
                                <input id="coupon_code" type="text" name="code" class="form-control"
                                       placeholder="<?php echo e(\Illuminate\Support\Str::random(8)); ?>" required maxlength="100">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="form-group">
                                <label class="input-label" for="coupon_limit"><?php echo e(translate('messages.limit_for_same_user')); ?></label>
                                <input type="number" name="limit" id="coupon_limit" class="form-control" placeholder="<?php echo e(translate('messages.Ex :')); ?> 10" max="100">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="form-group">
                                <label class="input-label" for="date_from"><?php echo e(translate('messages.start_date')); ?></label>
                                <input type="date" name="start_date" class="form-control" id="date_from" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="form-group">
                                <label class="input-label" for="date_to"><?php echo e(translate('messages.expire_date')); ?></label>
                                <input type="date" name="expire_date" class="form-control" id="date_to" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="form-group">
                                <label class="input-label" for="min_purchase"><?php echo e(translate('messages.min_trip_amount')); ?></label>
                                <input id="min_purchase" type="number" step="0.01" name="min_purchase" value="0" min="0" max="999999999999.99" class="form-control"
                                       placeholder="100">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="form-group">
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
                            <div class="form-group">
                                <label class="input-label" for="discount"><?php echo e(translate('messages.discount')); ?> </label>
                                <input type="number" step="0.01" min="1" max="999999999999.99" name="discount" id="discount" class="form-control" placeholder="<?php echo e(translate('messages.Ex :')); ?> 100" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="form-group">
                                <label class="input-label" for="max_discount"><?php echo e(translate('messages.max_discount')); ?></label>
                                <input type="number" step="0.01" min="0" value="0" max="999999999999.99" name="max_discount" id="max_discount" class="form-control" readonly>
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
                        <th><?php echo e(translate('messages.min_trip_amount')); ?></th>
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
                                           data-url="<?php echo e(route('vendor.rental_coupon.status',[$coupon['id']])); ?>"
                                           class="toggle-switch-input redirect-url" id="couponCheckbox<?php echo e($coupon->id); ?>" <?php echo e($coupon->status?'checked':''); ?>>
                                    <span class="toggle-switch-label">
                                        <span class="toggle-switch-indicator"></span>
                                    </span>
                                </label>
                            </td>
                            <td>
                                <div class="btn--container justify-content-center">
                                    <a class="btn btn-sm btn--primary btn-outline-primary action-btn" href="<?php echo e(route('vendor.rental_coupon.edit',[$coupon['id']])); ?>" title="<?php echo e(translate('messages.edit_coupon')); ?>"><i class="tio-edit"></i>
                                    </a>
                                    <a class="btn btn-sm btn--danger btn-outline-danger action-btn form-alert"
                                       data-id="coupon-<?php echo e($coupon['id']); ?>"
                                       data-message="<?php echo e(translate('Want to delete this coupon ?')); ?>"
                                       href="javascript:" title="<?php echo e(translate('messages.delete_coupon')); ?>"><i class="tio-delete-outlined"></i>
                                    </a>
                                    <form action="<?php echo e(route('vendor.rental_coupon.delete',[$coupon['id']])); ?>"
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

    <input type="hidden" id="min-purchase-toast" value="<?php echo e(translate('messages.Discount amount cannot be greater than minimum purchase amount')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin/js/view-pages/vendor-coupon.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/provider/coupon/list.blade.php ENDPATH**/ ?>