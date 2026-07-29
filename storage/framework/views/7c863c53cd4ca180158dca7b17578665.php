<?php $__env->startSection('title', $store->name . "'s " . translate('messages.items')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <!-- Custom styles for this page -->
    <link href="<?php echo e(asset('public/assets/admin/css/croppie.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <?php echo $__env->make('admin-views.vendor.view.partials._header', ['store' => $store], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <!-- Page Heading -->

        <div class="tab-content">
            <div class="tab-pane fade show active" id="product">

                <div class="col-12 mb-3">
                    <div class="row g-2">
                        <?php ($item = \App\Models\Item::withoutGlobalScope(\App\Scopes\StoreScope::class)->where(['store_id' => $store->id])->count()); ?>
                        <div class="col-sm-6 col-lg-3">
                            <a class="order--card h-100"
                                href="<?php echo e(route('admin.store.view', ['store' => $store->id, 'tab' => 'item'])); ?>">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                                        <img src="<?php echo e(asset('/public/assets/admin/img/store_items/fi_9752284.png')); ?>"
                                            alt="dashboard" class="oder--card-icon">
                                        <span><?php echo e(translate('All_Items')); ?></span>
                                    </h6>
                                    <span class="card-title text-success">
                                        <?php echo e($item); ?>

                                    </span>
                                </div>
                            </a>
                        </div>

                        <?php ( $item = \App\Models\Item::withoutGlobalScope(\App\Scopes\StoreScope::class)->where(['store_id' => $store->id, 'status' => 1])->count()); ?>
                        <div class="col-sm-6 col-lg-3">
                            <a class="order--card h-100"
                                href="<?php echo e(route('admin.store.view', ['store' => $store->id, 'tab' => 'item', 'sub_tab' => 'active-items'])); ?>">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                                        <img src="<?php echo e(asset('/public/assets/admin/img/store_items/fi_10608883.png')); ?>"
                                            alt="dashboard" class="oder--card-icon">
                                        <span><?php echo e(translate('messages.Active_Items')); ?></span>
                                    </h6>
                                    <span class="card-title text-success">
                                        <?php echo e($item); ?>

                                    </span>
                                </div>
                            </a>
                        </div>
                        <?php ( $item = \App\Models\Item::withoutGlobalScope(\App\Scopes\StoreScope::class)->where(['store_id' => $store->id, 'status' => 0])->count()); ?>
                        <div class="col-sm-6 col-lg-3">
                            <a class="order--card h-100"
                                href="<?php echo e(route('admin.store.view', ['store' => $store->id, 'tab' => 'item', 'sub_tab' => 'inactive-items'])); ?>">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                                        <img src="<?php echo e(asset('/public/assets/admin/img/store_items/fi_10186054.png')); ?>"
                                            alt="dashboard" class="oder--card-icon">
                                        <span><?php echo e(translate('messages.Inactive_Items')); ?></span>
                                    </h6>
                                    <span class="card-title text-success">
                                        <?php echo e($item); ?>

                                    </span>
                                </div>
                            </a>
                        </div>
                        <?php ($item = \App\Models\TempProduct::withoutGlobalScope(\App\Scopes\StoreScope::class)->where(['store_id' => $store->id, 'is_rejected' => 0])->count()); ?>
                        <div class="col-sm-6 col-lg-3">
                            <a class="order--card h-100"
                                href="<?php echo e(route('admin.store.view', ['store' => $store->id, 'tab' => 'item', 'sub_tab' => 'pending-items'])); ?>">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                                        <img src="<?php echo e(asset('/public/assets/admin/img/store_items/fi_5106700.png')); ?>"
                                            alt="dashboard" class="oder--card-icon">
                                        <span><?php echo e(translate('messages.Pending_for_Approval')); ?></span>
                                    </h6>
                                    <span class="card-title text-success">
                                        <?php echo e($item); ?>

                                    </span>
                                </div>
                            </a>
                        </div>
                        <?php ($item = \App\Models\TempProduct::withoutGlobalScope(\App\Scopes\StoreScope::class)->where(['store_id' => $store->id, 'is_rejected' => 1])->count()); ?>
                        <div class="col-sm-6 col-lg-3">
                            <a class="order--card h-100"
                                href="<?php echo e(route('admin.store.view', ['store' => $store->id, 'tab' => 'item', 'sub_tab' => 'rejected-items'])); ?>">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="card-subtitle d-flex justify-content-between m-0 align-items-center">
                                        <img src="<?php echo e(asset('/public/assets/admin/img/store_items/image 89.png')); ?>"
                                            alt="dashboard" class="oder--card-icon">
                                        <span><?php echo e(translate('messages.Rejected_Items')); ?></span>
                                    </h6>
                                    <span class="card-title text-success">
                                        <?php echo e($item); ?>

                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <?php
                $item = match ($sub_tab) {
                    'active-items' => translate('messages.Active'),
                    'inactive-items' => translate('messages.Inactive'),
                    'pending-items' => translate('messages.Pending'),
                    'rejected-items' => translate('messages.Rejected'),
                    default => '',
                };
                ?>

                <div class="card">
                    <div class="card-header border-0 py-2">
                        <div class="search--button-wrapper">
                            <h3 class="card-title"> <?php echo e($item ?? ''); ?> <?php echo e(translate('messages.items')); ?> <span
                                    class="badge badge-soft-dark ml-2"><span
                                        class="total_items"><?php echo e($foods->total()); ?></span></span>
                            </h3>

                            <form class="search-form">
                                <input type="hidden" name="store_id" value="<?php echo e($store->id); ?>">
                                <!-- Search -->
                                <div class="input-group input--group">
                                    <input id="datatableSearch" name="search" value="<?php echo e(request()?->search ?? null); ?>"
                                        type="search" class="form-control h--40px"
                                        placeholder="<?php echo e(translate('Search by name...')); ?>"
                                        aria-label="<?php echo e(translate('messages.search_here')); ?>">
                                    <button type="submit" class="btn btn--secondary h--40px"><i
                                            class="tio-search"></i></button>
                                </div>
                                <!-- End Search -->
                            </form>

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
                                        href="<?php echo e(route('admin.item.store-item-export', ['type' => 'excel', 'table' => isset($sub_tab) && ($sub_tab == 'pending-items' || $sub_tab == 'rejected-items') ? 'TempProduct' : null, 'sub_tab' => $sub_tab ?? null, 'store_id' => $store->id, request()->getQueryString()])); ?>">
                                        <img class="avatar avatar-xss avatar-4by3 mr-2"
                                            src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                            alt="Image Description">
                                        <?php echo e(translate('messages.excel')); ?>

                                    </a>
                                    <a id="export-csv" class="dropdown-item"
                                        href="<?php echo e(route('admin.item.store-item-export', ['type' => 'csv', 'table' => isset($sub_tab) && ($sub_tab == 'pending-items' || $sub_tab == 'rejected-items') ? 'TempProduct' : null, 'sub_tab' => $sub_tab ?? null, 'store_id' => $store->id, request()->getQueryString()])); ?>">
                                        <img class="avatar avatar-xss avatar-4by3 mr-2"
                                            src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                            alt="Image Description">
                                        .<?php echo e(translate('messages.csv')); ?>

                                    </a>

                                </div>
                            </div>
                            <!-- End Unfold -->
                            <a href="<?php echo e(route('admin.item.add-new')); ?>" class="btn btn--primary pull-right"><i
                                    class="tio-add-circle"></i> <?php echo e(translate('messages.add_new_item')); ?></a>
                        </div>
                    </div>
                    <div class="table-responsive datatable-custom">
                        <table id="columnSearchDatatable"
                            class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                            data-hs-datatables-options='{
                                "order": [],
                                "orderCellsTop": true,
                                "paging": false
                            }'>
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0"><?php echo e(translate('sl')); ?></th>
                                    <th class="border-0"><?php echo e(translate('messages.name')); ?></th>
                                    <th class="border-0"><?php echo e(translate('messages.type')); ?></th>
                                    <?php if(Config::get('module.current_module_type') != 'food' &&
                                            !(isset($sub_tab) && ($sub_tab == 'rejected-items' || $sub_tab == 'pending-items'))): ?>
                                        <th class="border-0"><?php echo e(translate('messages.quantity')); ?></th>
                                    <?php endif; ?>
                                    <th class="border-0"><?php echo e(translate('messages.price')); ?></th>
                                      <?php if($productWiseTax): ?>
                                        <th  class="border-0 "><?php echo e(translate('messages.Vat/Tax')); ?></th>
                                    <?php endif; ?>
                                    <th class="border-0"><?php echo e(translate('messages.status')); ?></th>
                                    <th class="border-0 text-center"><?php echo e(translate('messages.action')); ?></th>
                                </tr>
                            </thead>

                            <tbody id="setrows">

                                <?php $__currentLoopData = $foods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $food): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(isset($sub_tab) && ($sub_tab == 'rejected-items' || $sub_tab == 'pending-items')): ?>
                                        <tr>
                                            <td><?php echo e($key + $foods->firstItem()); ?></td>
                                            <td>
                                                <a class="media align-items-center"
                                                    href="<?php echo e(route('admin.item.requested_item_view', ['id' => $food['id']])); ?>">
                                                    <img class="avatar avatar-lg mr-3 onerror-image"
                                                        src="<?php echo e($food['image_full_url'] ?? asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                                                        data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                                                        alt="<?php echo e($food->name); ?> image">
                                                    <div class="media-body">
                                                        <h5 class="text-hover-primary mb-0">
                                                            <?php echo e(Str::limit($food['name'], 20, '...')); ?></h5>
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <?php echo e(Str::limit($food->category ? $food->category->name : translate('messages.category_deleted'), 20, '...')); ?>

                                            </td>

                                            <td>
                                                <div class="mw--85px">
                                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($food['price'])); ?>

                                                </div>
                                            </td>

                                             <?php if($productWiseTax): ?>
                                            <td>
                                                <span class="d-block font-size-sm text-body">
                                                    <?php $__empty_1 = true; $__currentLoopData = $food?->taxVats?->pluck('tax.name', 'tax.tax_rate')->toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                        <span> <?php echo e($tax); ?> : <span class="font-bold">
                                                                (<?php echo e($key); ?>%)
                                                            </span> </span>
                                                        <br>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                        <span> <?php echo e(translate('messages.no_tax')); ?> </span>
                                                    <?php endif; ?>
                                                </span>

                                            </td>

                                            <?php endif; ?>
                                            <td>
                                                <div class="">
                                                    <?php if($food->is_rejected == 1): ?>
                                                        <span class="badge badge-soft-danger  text-capitalize">
                                                            <?php echo e(translate('messages.rejected')); ?>

                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge badge-soft-info  text-capitalize">
                                                            <?php echo e(translate('messages.pending')); ?>

                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn--container justify-content-center">
                                                    <a class="ml-2 btn btn-sm btn--warning btn-outline-warning action-btn"
                                                        data-toggle="tooltip" data-placement="top"
                                                        data-original-title="<?php echo e(translate('messages.View')); ?>"
                                                        href="<?php echo e(route('admin.item.requested_item_view', ['id' => $food['id']])); ?>">
                                                        <i class="tio-invisible"></i>
                                                    </a>
                                                    <a class="btn action-btn btn--primary btn-outline-primary route-alert"
                                                        data-toggle="tooltip" data-placement="top"
                                                        data-original-title="<?php echo e(translate('messages.approve')); ?>"
                                                        data-url="<?php echo e(route('admin.item.approved', ['id' => $food['id']])); ?>"
                                                        data-message="<?php echo e(translate('messages.you_want_to_approve_this_product')); ?>"
                                                        href="javascript:"><i class="tio-done font-weight-bold"></i> </a>
                                                    <?php if($food->is_rejected == 0): ?>
                                                        <a class="btn action-btn btn--danger btn-outline-danger canceled-status"
                                                            data-toggle="tooltip" data-placement="top"
                                                            data-original-title="<?php echo e(translate('messages.deny')); ?>"
                                                            data-url="<?php echo e(route('admin.item.deny', ['id' => $food['id']])); ?>"
                                                            data-message="<?php echo e(translate('you_want_to_deny_this_product')); ?>"
                                                            href="javascript:"><i
                                                                class="tio-clear font-weight-bold"></i></a>
                                                    <?php endif; ?>
                                                    <a class="btn action-btn btn--primary btn-outline-primary"
                                                        href="<?php echo e(route('admin.item.edit', [$food['id'], 'temp_product' => true])); ?>"
                                                        title="<?php echo e(translate('messages.edit_item')); ?>"><i
                                                            class="tio-edit"></i>
                                                    </a>
                                                    <a class="btn action-btn btn--danger btn-outline-danger form-alert"
                                                        href="javascript:" data-url="food-<?php echo e($food['id']); ?>"
                                                        data-message="<?php echo e(translate('messages.Want_to_delete_this_item')); ?>"
                                                        title="<?php echo e(translate('messages.delete_item')); ?>"><i
                                                            class="tio-delete-outlined"></i>
                                                    </a>
                                                    <form action="<?php echo e(route('admin.item.delete', [$food['id']])); ?>"
                                                        method="post" id="food-<?php echo e($food['id']); ?>">
                                                        <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                                        <input type="hidden" value="1" name="temp_product">
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <tr>
                                            <td><?php echo e($key + 1); ?></td>
                                            <td>
                                                <a class="media align-items-center"
                                                    href="<?php echo e(route('admin.item.view', [$food['id']])); ?>">
                                                    <img class="avatar avatar-lg mr-3 onerror-image"
                                                        src="<?php echo e($food['image_full_url'] ?? asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                                                        data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                                                        alt="<?php echo e($food->name); ?> image">

                                                    <div class="media-body">
                                                        <h5 class="text-hover-primary mb-0">
                                                            <?php echo e(Str::limit($food['name'], 20, '...')); ?></h5>
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <?php echo e(Str::limit($food->category ? $food->category->name : translate('messages.category_deleted'), 20, '...')); ?>

                                            </td>
                                            <?php if(Config::get('module.current_module_type') != 'food'): ?>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <h5 class="text-hover-primary fw-medium mb-0"><?php echo e($food->stock); ?>

                                                        </h5>
                                                        <span data-toggle="modal" data-id="<?php echo e($food->id); ?>"
                                                            data-target="#update-quantity"
                                                            class="text-primary tio-add-circle fs-22 cursor-pointer update-quantity"></span>
                                                    </div>
                                                </td>
                                            <?php endif; ?>
                                            <td><?php echo e(\App\CentralLogics\Helpers::format_currency($food['price'])); ?></td>
                                            <?php if($productWiseTax): ?>
                                            <td>
                                                <span class="d-block font-size-sm text-body">
                                                    <?php $__empty_1 = true; $__currentLoopData = $food?->taxVats?->pluck('tax.name', 'tax.tax_rate')->toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                        <span> <?php echo e($tax); ?> : <span class="font-bold">
                                                                (<?php echo e($key); ?>%)
                                                            </span> </span>
                                                        <br>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                        <span> <?php echo e(translate('messages.no_tax')); ?> </span>
                                                    <?php endif; ?>
                                                </span>
                                            </td>

                                            <?php endif; ?>
                                            <td>
                                                <label class="toggle-switch toggle-switch-sm"
                                                    for="stocksCheckbox<?php echo e($food->id); ?>">
                                                    <input type="checkbox" class="toggle-switch-input redirect-url"
                                                        data-url="<?php echo e(route('admin.item.status', [$food['id'], $food->status ? 0 : 1])); ?>"
                                                        id="stocksCheckbox<?php echo e($food->id); ?>"
                                                        <?php echo e($food->status ? 'checked' : ''); ?>>
                                                    <span class="toggle-switch-label">
                                                        <span class="toggle-switch-indicator"></span>
                                                    </span>
                                                </label>
                                            </td>
                                            <td>
                                                <div class="btn--container justify-content-center">
                                                    <a class="btn action-btn btn--primary btn-outline-primary"
                                                        href="<?php echo e(route('admin.item.edit', [$food['id']])); ?>"
                                                        title="<?php echo e(translate('messages.edit_item')); ?>"><i
                                                            class="tio-edit"></i>
                                                    </a>
                                                    <a class="btn action-btn btn--danger btn-outline-danger form-alert"
                                                        href="javascript:" data-id="food-<?php echo e($food['id']); ?>"
                                                        data-message="<?php echo e(translate('messages.Want to delete this item ?')); ?>"
                                                        title="<?php echo e(translate('messages.delete_item')); ?>"><i
                                                            class="tio-delete-outlined"></i>
                                                    </a>
                                                </div>
                                                <form action="<?php echo e(route('admin.item.delete', [$food['id']])); ?>"
                                                    method="post" id="food-<?php echo e($food['id']); ?>">
                                                    <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if(count($foods) !== 0): ?>
                        <hr>
                    <?php endif; ?>
                    <div class="page-area">
                        <?php echo $foods->links(); ?>

                    </div>
                    <?php if(count($foods) === 0): ?>
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

    
    <div class="modal fade update-quantity-modal" id="update-quantity" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-0">

                    <form action="<?php echo e(route('admin.item.stock-update')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <div class="mt-2 rest-part w-100"></div>
                        <div class="btn--container justify-content-end">
                            <button type="reset" data-dismiss="modal" aria-label="Close"
                                class="btn btn--reset"><?php echo e(translate('cancel')); ?></button>
                            <button type="submit" id="submit_new_customer"
                                class="btn btn--primary"><?php echo e(translate('update_stock')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <!-- Page level plugins -->
    <script>
        "use script";
        // Call the dataTables jQuery plugin
        $(document).ready(function() {
            $('#dataTable').DataTable();

            // INITIALIZATION OF DATATABLES
            // =======================================================
            let datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

            $('#column1_search').on('keyup', function() {
                datatable
                    .columns(1)
                    .search(this.value)
                    .draw();
            });

            $('#column2_search').on('keyup', function() {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });

            $('#column3_search').on('change', function() {
                datatable
                    .columns(3)
                    .search(this.value)
                    .draw();
            });

            $('#column4_search').on('keyup', function() {
                datatable
                    .columns(4)
                    .search(this.value)
                    .draw();
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function() {
                let select2 = $.HSCore.components.HSSelect2.init($(this));
            });

        });
        $('.update-quantity').on('click', function() {
            let val = $(this).data('id');
            $.get({
                url: '<?php echo e(route('admin.item.get_stock')); ?>',
                data: {
                    id: val
                },
                dataType: 'json',
                success: function(data) {
                    $('.rest-part').empty().html(data.view);
                    update_qty();
                },
            });
        })

        function update_qty() {
            let total_qty = 0;
            let qty_elements = $('input[name^="stock_"]');
            for (let i = 0; i < qty_elements.length; i++) {
                total_qty += parseInt(qty_elements.eq(i).val());
            }
            if (qty_elements.length > 0) {

                $('input[name="current_stock"]').attr("readonly", 'readonly');
                $('input[name="current_stock"]').val(total_qty);
            } else {
                $('input[name="current_stock"]').attr("readonly", false);
            }
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/vendor/view/product.blade.php ENDPATH**/ ?>