<?php $__env->startSection('title',translate('Item List')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center g-2">
                <div class="col-md-9 col-12">
                    <h1 class="page-header-title">
                        <span class="page-header-icon">
                            <img src="<?php echo e(asset('public/assets/admin/img/items.png')); ?>" class="w--22" alt="">
                        </span>
                        <span>
                            <?php echo e(translate('messages.item_list')); ?> <span class="badge badge-soft-dark ml-2" id="foodCount"><?php echo e($items->total()); ?></span>
                        </span>
                    </h1>
                </div>
            </div>

        </div>
        <!-- End Page Header -->
        <!-- Card -->

        <?php
            $pharmacy =0;
            if (Config::get('module.current_module_type') == 'pharmacy'){
                $pharmacy =1;
            }
        ?>
            <div class="card mb-3">
                <form action="" method="get">
                <div class="card-body">
                    <!-- Header -->
                    <div class="card-header border-0 px-0 pt-0 pb-xxl-3">
                        <h1 class="m-0"><?php echo e(translate('search_data')); ?></h1>
                    </div>
                    <div class="row g-lg-3 g-2">
                        <div class="col-sm-6 col-md-3">
                            <div class="select-item">
                            <select name="store_id" id="store"
                            data-url="<?php echo e(route("admin.store.get-stores")); ?>"
                            data-placeholder="<?php echo e(translate('messages.select_store')); ?>" class="js-data-example-ajax form-control" required title="Select Store" >
                                <?php if($store): ?>
                                <option value="<?php echo e($store->id); ?>" selected><?php echo e($store->name); ?></option>
                                <?php else: ?>
                                <option value="all" selected><?php echo e(translate('messages.all_stores')); ?></option>
                                <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <?php if(!isset(auth('admin')->user()->zone_id)): ?>
                            <div class="select-item">
                                <select name="zone_id" class="form-control js-select2-custom">
                                    <option value="" <?php echo e(!request('zone_id')?'selected':''); ?>><?php echo e(translate('messages.All_Zones')); ?></option>
                                    <?php $__currentLoopData = \App\Models\Zone::orderBy('name')->get(['id','name']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option
                                            value="<?php echo e($z['id']); ?>" <?php echo e(request()?->zone_id == $z['id']?'selected':''); ?>>
                                            <?php echo e($z['name']); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-sm-6 col-md-<?php echo e($pharmacy == 1 ? '2':'3'); ?>">
                            <div class="select-item">

                                <select name="category_id" id="category_id" data-placeholder="<?php echo e(translate('messages.select_category')); ?>" data-url="<?php echo e(route("admin.category.get-all")); ?>" class="js-data-example-ajax form-control"  >
                                    <?php if($category): ?>
                                    <option value="<?php echo e($category->id); ?>" selected><?php echo e($category->name); ?></option>
                                    <?php else: ?>
                                    <option value="all" selected><?php echo e(translate('messages.all_category')); ?></option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-<?php echo e($pharmacy == 1 ? '2':'3'); ?>">
                            <div class="select-item">
                                <select name="sub_category_id" class="form-control js-data-example-ajax "
                                data-url="<?php echo e(route('admin.item.get-categories')); ?>"
                                data-placeholder="<?php echo e(translate('messages.select_sub_category')); ?>" id="sub-categories">
                                    <?php if($sub_category): ?>
                                    <option value="<?php echo e($sub_category->id); ?>" selected><?php echo e($sub_category->name); ?></option>
                                    <?php else: ?>
                                    <option value="all" selected><?php echo e(translate('messages.all_sub_category')); ?></option>
                                    <?php endif; ?>

                                </select>
                            </div>
                        </div>
                        <?php if($pharmacy == 1): ?>
                            <div class="col-sm-6 col-md-2">
                                <div class="select-item">
                                <select name="condition_id" id="condition_id" class="form-control"
                                    data-url="<?php echo e(route('admin.common-condition.get-all')); ?>"
                                    data-placeholder="<?php echo e(translate('messages.Select_Condition')); ?>">
                                    <?php if($condition): ?>
                                    <option value="<?php echo e($condition->id); ?>" selected><?php echo e($condition->name); ?></option>
                                    <?php else: ?>
                                    <option value="all" selected><?php echo e(translate('messages.all_conditions')); ?></option>
                                    <?php endif; ?>
                                </select>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="btn--container justify-content-end mt-xl-4 mt-3">
                        <button type="reset" data-url="<?php echo e(url()->current()); ?>" class="btn btn--reset redirect-url"><?php echo e(translate('messages.reset')); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.Filter')); ?></button>
                    </div>
                </div>
                </form>
            </div>

        <div class="card">
            <!-- Header -->
            <div class="card-header py-2 border-0">
                <div class="search--button-wrapper justify-content-end">
                    <form class="search-form">

                        <!-- Search -->
                        <div class="input-group input--group">
                            <input id="datatableSearch" name="search" value="<?php echo e(request()?->search ?? null); ?>" type="search" class="form-control h--40px" placeholder="<?php echo e(translate('ex_:_search_item_by_name')); ?>" aria-label="<?php echo e(translate('messages.search_here')); ?>">
                            <button type="submit" class="btn btn--primary h--40px"><i class="tio-search"></i></button>
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
                            <a id="export-excel" class="dropdown-item" href="<?php echo e(route('admin.item.export', ['type' => 'excel', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                    alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item" href="<?php echo e(route('admin.item.export', ['type' => 'csv', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                    alt="Image Description">
                                .<?php echo e(translate('messages.csv')); ?>

                            </a>

                        </div>
                    </div>
                    <!-- End Unfold -->
                    <?php if(Config::get('module.current_module_type') != 'food'): ?>
                    <div>
                        <a href="<?php echo e(route('admin.report.stock-report')); ?>" class="btn btn--primary font-regular"><?php echo e(translate('messages.Low_Stock_List')); ?></a>
                    </div>
                    <?php endif; ?>
                    <?php if(\App\CentralLogics\Helpers::get_mail_status('product_approval')): ?>
                    <div>
                        <a href="<?php echo e(route('admin.item.approval_list')); ?>" class="btn btn--primary font-regular"><?php echo e(translate('messages.New_Product_Request')); ?></a>
                    </div>
                    <?php endif; ?>
                </div>
                <!-- End Row -->
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive datatable-custom" id="table-div">
                <table id="datatable" class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                    data-hs-datatables-options='{
                        "columnDefs": [{
                            "targets": [],
                            "width": "5%",
                            "orderable": false
                        }],
                        "order": [],
                        "info": {
                        "totalQty": "#datatableWithPaginationInfoTotalQty"
                        },

                        "entries": "#datatableEntries",

                        "isResponsive": false,
                        "isShowPaging": false,
                        "paging":false
                    }'>
                    <thead class="bg-table-head">
                    <tr>
                        <th class="text-title border-0"><?php echo e(translate('sl')); ?></th>
                        <th class="text-title border-0"><?php echo e(translate('messages.name')); ?></th>
                        <th class="text-title border-0"><?php echo e(translate('messages.category')); ?></th>
                        <?php if(Config::get('module.current_module_type') != 'food'): ?>
                        <th class="text-title border-0"><?php echo e(translate('messages.quantity')); ?></th>
                        <?php endif; ?>
                        <th class="text-title border-0"><?php echo e(translate('messages.store')); ?></th>
                        <th class="text-title border-0 text-center"><?php echo e(translate('messages.price')); ?></th>

                        <?php if($productWiseTax): ?>
                        <th class="text-title border-0 "><?php echo e(translate('messages.Vat/Tax')); ?></th>
                        <?php endif; ?>

                        <th class="text-title border-0 text-center"><?php echo e(translate('messages.status')); ?></th>
                        <th class="text-title border-0 text-center"><?php echo e(translate('messages.action')); ?></th>
                    </tr>
                    </thead>

                    <tbody id="set-rows">
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+$items->firstItem()); ?></td>
                            <td>
                                <a class="media align-items-center" href="<?php echo e(route('admin.item.view',[$item['id']])); ?>">
                                    <img class="avatar avatar-lg mr-3 onerror-image"

                                    src="<?php echo e($item['image_full_url'] ?? asset('public/assets/admin/img/160x160/img2.jpg')); ?>"

                                    data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>" alt="<?php echo e($item->name); ?> image">
                                    <div title="<?php echo e($item['name']); ?>" class="media-body">
                                        <h5 class="text-hover-primary mb-0"><?php echo e(Str::limit($item['name'],20,'...')); ?></h5>
                                    </div>
                                </a>
                            </td>
                            <td title="<?php echo e($item?->category?->name); ?>">
                            <?php echo e(Str::limit($item->category?$item->category->name:translate('messages.category_deleted'),20,'...')); ?>

                            </td>
                            <?php if(Config::get('module.current_module_type') != 'food'): ?>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <h5 class="text-hover-primary fw-medium mb-0"><?php echo e($item->stock); ?></h5>
                                    <span data-toggle="modal"  data-id="<?php echo e($item->id); ?>"  data-target="#update-quantity" class="text-primary tio-add-circle fs-22 cursor-pointer update-quantity"></span>
                                </div>
                            </td>
                            <?php endif; ?>
                            <td>
                                <?php if($item->store): ?>
                                <a title="<?php echo e($item?->store?->name); ?>" href="<?php echo e(route('admin.store.view', $item->store->id)); ?>" class="table-rest-info" alt="view store"> <?php echo e(Str::limit($item->store->name, 20, '...')); ?></a>
                                <?php else: ?>
                                <?php echo e(translate('messages.store deleted!')); ?>

                                <?php endif; ?>

                            </td>
                            <td>
                                <div class="text-right mw--85px">
                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($item['price'])); ?>

                                </div>
                            </td>

                            <?php if($productWiseTax): ?>
                                <td>
                                    <span class="d-block font-size-sm text-body">
                                        <?php $__empty_1 = true; $__currentLoopData = $item?->taxVats?->pluck('tax.name', 'tax.tax_rate')->toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
                                <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox<?php echo e($item->id); ?>">
                                    <input type="checkbox" class="toggle-switch-input redirect-url" data-url="<?php echo e(route('admin.item.status',[$item['id'],$item->status?0:1])); ?>" id="stocksCheckbox<?php echo e($item->id); ?>" <?php echo e($item->status?'checked':''); ?>>
                                    <span class="toggle-switch-label mx-auto">
                                        <span class="toggle-switch-indicator"></span>
                                    </span>
                                </label>
                            </td>
                            <td>
                                <div class="btn--container justify-content-center">
                                    <a class="btn action-btn btn--primary btn-outline-primary"
                                        href="<?php echo e(route('admin.item.edit',[$item['id']])); ?>" title="<?php echo e(translate('messages.edit_item')); ?>"><i class="tio-edit"></i>
                                    </a>
                                    <a class="btn  action-btn btn--danger btn-outline-danger form-alert" href="javascript:"
                                        data-id="food-<?php echo e($item['id']); ?>" data-message="<?php echo e(translate('messages.Want_to_delete_this_item')); ?>" title="<?php echo e(translate('messages.delete_item')); ?>"><i class="tio-delete-outlined"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.item.delete',[$item['id']])); ?>"
                                            method="post" id="food-<?php echo e($item['id']); ?>">
                                        <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <?php if(count($items) !== 0): ?>
                <hr>
            <?php endif; ?>
            <div class="page-area">
                <tfoot class="border-top">
                <?php echo $items->withQueryString()->links(); ?>

            </div>
            <?php if(count($items) === 0): ?>
                <div class="empty--data">
                    <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                    <h5>
                        <?php echo e(translate('no_data_found')); ?>

                    </h5>
                </div>
            <?php endif; ?>
            <!-- End Table -->
        </div>
        <!-- End Card -->
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
                            <button type="reset" data-dismiss="modal" aria-label="Close" class="btn btn--reset"><?php echo e(translate('cancel')); ?></button>
                            <button type="submit" id="submit_new_customer" class="btn btn--primary"><?php echo e(translate('update_stock')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

   <input type="hidden" id="current_module_id" value="<?php echo e(Config::get('module.current_module_id')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script>
        "use strict";
        $(document).on('ready', function () {
            let datatable = $.HSCore.components.HSDatatables.init($('#datatable'), {
            select: {
                style: 'multi',
                classMap: {
                checkAll: '#datatableCheckAll',
                counter: '#datatableCounter',
                counterInfo: '#datatableCounterInfo'
                }
            },
            });
        });

        $('#store').select2({
            ajax: {
                url: $('#store').data('url'),
                data: function (params) {
                    return {
                        q: params.term, // search term
                        all:true,
                        module_id:$('#current_module_id').val(),
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

        $('#category_id').select2({
            ajax: {
                url: $('#category_id').data('url'),
                data: function (params) {
                    return {
                        q: params.term,
                        all:true,
                        module_id:$('#current_module_id').val(),
                        position:0,
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

        $('#category_id').on('change', function (e) {
            $('#sub-categories').val(null).trigger('change');
        })

        $('#sub-categories').select2({
            ajax: {
                url: $('#sub-categories').data('url'),
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        module_id: $('#current_module_id').val(),
                        parent_id: $('#category_id').val(),
                        sub_category: true
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

        $('#condition_id').select2({
            ajax: {
                url: $('#condition_id').data('url'),
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        all:true,
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

        $('.update-quantity').on('click', function (){
            let val = $(this).data('id');
            $.get({
                url: '<?php echo e(route('admin.item.get_stock')); ?>',
                data: { id: val },
                dataType: 'json',
                success: function (data) {
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
            if(qty_elements.length > 0)
            {

                $('input[name="current_stock"]').attr("readonly", 'readonly');
                $('input[name="current_stock"]').val(total_qty);
            }
            else{
                $('input[name="current_stock"]').attr("readonly", false);
            }
        }



    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/product/list.blade.php ENDPATH**/ ?>