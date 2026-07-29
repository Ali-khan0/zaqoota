<?php $__env->startSection('title',translate('messages.item_list')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php ($store_data=\App\CentralLogics\Helpers::get_store_data()); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="btn--container align-items-center mb-0">
                <div class="mr-auto">
                    <h1 class="page-header-title"><i class="tio-filter-list"></i> <?php echo e(translate('messages.item_list')); ?><span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($items->total()); ?></span></h1>
                </div>


            </div>
        </div>
        <!-- End Page Header -->


        <!-- End Page Header -->
        <div class="card mb-3">
            <!-- Header -->
            <div class="card-header py-2 border-0">
                <h1><?php echo e(translate('search_data')); ?></h1>
            </div>
                <div class="row mr-1 ml-2 mb-5">

                    <div class="col-sm-6 col-md-4">
                        <div class="select-item">
                            <select name="category_id" id="category" data-placeholder="<?php echo e(translate('messages.select_category')); ?>"
                                class="js-data-example-ajax form-control set-filter" id="category_id"
                                data-url="<?php echo e(url()->full()); ?>" data-filter="category_id">
                                <?php if($category): ?>
                                <option value="<?php echo e($category->id); ?>" selected><?php echo e($category->name); ?></option>
                                <?php else: ?>
                                <option value="all" selected><?php echo e(translate('messages.all_category')); ?></option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="select-item">
                            <select name="sub_category_id" class="form-control js-select2-custom set-filter" data-placeholder="<?php echo e(translate('messages.select_sub_category')); ?>" id="sub-categories" data-url="<?php echo e(url()->full()); ?>" data-filter="sub_category_id">
                                <option value="all" selected><?php echo e(translate('messages.all_sub_category')); ?></option>
                                <?php $__currentLoopData = $sub_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option
                                    value="<?php echo e($z['id']); ?>" <?php echo e(request()?->sub_category_id == $z['id']?'selected':''); ?>>
                                    <?php echo e($z['name']); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>


                    <?php if(($store_data->module->module_type == 'food') && $toggle_veg_non_veg): ?>
                    <!-- Veg/NonVeg filter -->

                <div class="col-sm-6 col-md-4">
                    <div class="select-item">
                        <select name="category_id" data-url="<?php echo e(url()->full()); ?>" data-filter="type" data-placeholder="<?php echo e(translate('messages.all')); ?>" class="form-control max-lg-h-40px set-filter">
                            <option value="all" <?php echo e($type=='all'?'selected':''); ?>><?php echo e(translate('messages.all')); ?></option>
                            <option value="veg" <?php echo e($type=='veg'?'selected':''); ?>><?php echo e(translate('messages.veg')); ?></option>
                            <option value="non_veg" <?php echo e($type=='non_veg'?'selected':''); ?>><?php echo e(translate('messages.non_veg')); ?></option>
                        </select>
                    </div>
                </div>
                    <!-- End Veg/NonVeg filter -->
                    <?php endif; ?>
                </div>
            </div>


        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header py-2  border-0">
                <div class="search--button-wrapper justify-content-end">
                    <form class="search-form">
                    <?php echo csrf_field(); ?>
                        <!-- Search -->
                        <div class="input-group input--group">
                            <input id="" type="search" name="search" value="<?php echo e(request()?->search ?? null); ?>" class="form-control" placeholder="<?php echo e(translate('messages.ex_search_name')); ?>" aria-label="<?php echo e(translate('messages.search_here')); ?>">
                            <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                        </div>
                        <!-- End Search -->
                    </form>
                    <!-- End Unfold -->
                    <div>
                        <a href="<?php echo e(route('vendor.item.add-new')); ?>" class="btn btn--primary m-0 pull-right"><i
                                    class="tio-add-circle"></i> <?php echo e(translate('messages.add_new_item')); ?></a>
                    </div>
                </div>
            </div>
            <!-- End Header -->


            <!-- Table -->
            <div class="table-responsive datatable-custom">
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
                    <thead class="thead-light">
                        <tr>
                            <th class="border-0"><?php echo e(translate('messages.#')); ?></th>
                            <th class="border-0 w-20p"><?php echo e(translate('messages.name')); ?></th>
                            <th class="border-0 w-20p"><?php echo e(translate('messages.category')); ?></th>
                            <?php if($store_data->module->module_type != 'food'): ?>
                            <th class="border-0 w-20p"><?php echo e(translate('messages.quantity')); ?></th>
                            <?php endif; ?>
                            <th class="border-0"><?php echo e(translate('messages.price')); ?></th>
                            <th class="border-0 text-center"><?php echo e(translate('messages.Recommended')); ?></th>
                             <?php if($productWiseTax): ?>
                            <th  class="border-0 "><?php echo e(translate('messages.Vat/Tax')); ?></th>
                            <?php endif; ?>
                            <th class="border-0 text-center"><?php echo e(translate('messages.status')); ?></th>
                            <th class="border-0 text-center"><?php echo e(translate('messages.action')); ?></th>
                        </tr>
                    </thead>

                    <tbody id="set-rows">
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+$items->firstItem()); ?></td>
                            <td>
                                <a class="media align-items-center" href="<?php echo e(route('vendor.item.view',[$item['id']])); ?>">
                                    <img class="avatar avatar-lg mr-3 onerror-image" src="<?php echo e($item['image_full_url']); ?>"
                                         data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>" alt="<?php echo e($item->name); ?> image">
                                    <div class="media-body">
                                        <h5 class="text-hover-primary mb-0"><?php echo e(Str::limit($item['name'],20,'...')); ?></h5>
                                    </div>
                                </a>
                            </td>
                            <td>
                            <?php echo e(Str::limit($item->category?$item->category->name:translate('messages.category_deleted'),20,'...')); ?>

                            </td>
                            <?php if($store_data->module->module_type != 'food'): ?>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <h5 class="text-hover-primary fw-medium mb-0"><?php echo e($item->stock); ?></h5>
                                    <span data-toggle="modal"  data-id="<?php echo e($item->id); ?>"  data-target="#update-quantity" class="text-primary tio-add-circle fs-22 cursor-pointer update-quantity"></span>
                                </div>
                            </td>
                            <?php endif; ?>
                            <td>
                                <div class="mw--85px">
                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($item['price'])); ?>

                                </div>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <div class="mx-auto">
                                        <label class="toggle-switch toggle-switch-sm mr-2"  data-toggle="tooltip" data-placement="top" title="<?php echo e(translate('messages.Recommend_to_customers')); ?>" for="recCheckbox<?php echo e($item->id); ?>">
                                            <input type="checkbox" data-url="<?php echo e(route('vendor.item.recommended',[$item['id'],$item->recommended?0:1])); ?>" class="toggle-switch-input redirect-url" id="recCheckbox<?php echo e($item->id); ?>" <?php echo e($item->recommended?'checked':''); ?>>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
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
                                    <input type="checkbox" data-url="<?php echo e(route('vendor.item.status',[$item['id'],$item->status?0:1])); ?>" class="toggle-switch-input redirect-url" id="stocksCheckbox<?php echo e($item->id); ?>" <?php echo e($item->status?'checked':''); ?>>
                                    <span class="toggle-switch-label mx-auto">
                                        <span class="toggle-switch-indicator"></span>
                                    </span>
                                </label>
                            </td>
                            <td>
                                <div class="btn--container justify-content-center">
                                    <a class="btn btn-sm btn--primary btn-outline-primary action-btn"
                                        href="<?php echo e(route('vendor.item.edit',[$item['id']])); ?>" title="<?php echo e(translate('messages.edit_item')); ?>"><i class="tio-edit"></i>
                                    </a>
                                    <a class="btn btn-sm btn--danger btn-outline-danger action-btn form-alert" href="javascript:"
                                        data-id="food-<?php echo e($item['id']); ?>" data-message="<?php echo e(translate('Want to delete this item ?')); ?>" title="<?php echo e(translate('messages.delete_item')); ?>"><i class="tio-delete-outlined"></i>
                                    </a>
                                </div>
                                <form action="<?php echo e(route('vendor.item.delete',[$item['id']])); ?>"
                                        method="post" id="food-<?php echo e($item['id']); ?>">
                                    <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <hr>
                <div class="page-area">
                    <table>
                        <tfoot class="border-top">
                        <?php echo $items->links(); ?>

                        </tfoot>
                    </table>
                </div>
                <?php if(count($items) === 0): ?>
                <div class="empty--data">
                    <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                    <h5>
                        <?php echo e(translate('no_data_found')); ?>

                    </h5>
                </div>
                <?php endif; ?>
            </div>
            <!-- End Table -->
        </div>
        <!-- End Card -->
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

                    <form action="<?php echo e(route('vendor.item.stock-update')); ?>" method="post">
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script>
        "use strict";
        $(document).on('ready', function () {
        // INITIALIZATION OF DATATABLES
        // =======================================================
        let datatable = $.HSCore.components.HSDatatables.init($('#datatable'), {
          select: {
            style: 'multi',
            classMap: {
              checkAll: '#datatableCheckAll',
              counter: '#datatableCounter',
              counterInfo: '#datatableCounterInfo'
            }
          },
          language: {
            zeroRecords: '<div class="text-center p-4">' +
                '<img class="w-7rem mb-3" src="<?php echo e(asset('public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="Image Description">' +

                '</div>'
          }
        });






            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                let select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });

        $('#category').select2({
            ajax: {
                url: '<?php echo e(route("vendor.category.get-all")); ?>',
                data: function (params) {
                    return {
                        q: params.term, // search term
                        all:true,
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

        // $('#search-form').on('submit', function (e) {
        //     e.preventDefault();
        //     let formData = new FormData(this);
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //     $.post({
        //         url: '<?php echo e(route('vendor.item.search')); ?>',
        //         data: formData,
        //         cache: false,
        //         contentType: false,
        //         processData: false,
        //         beforeSend: function () {
        //             $('#loading').show();
        //         },
        //         success: function (data) {
        //             $('#set-rows').html(data.view);
        //             $('#itemCount').html(data.count);
        //             $('.page-area').hide();
        //         },
        //         complete: function () {
        //             $('#loading').hide();
        //         },
        //     });
        // });

        $('.update-quantity').on('click', function (){
        let val = $(this).data('id');
        $.get({
            url: '<?php echo e(route('vendor.item.get_stock')); ?>',
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

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/vendor-views/product/list.blade.php ENDPATH**/ ?>