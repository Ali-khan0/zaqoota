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
                    <h1 class="page-header-title"><i class="tio-filter-list"></i> <?php echo e(translate('messages.Pending_For_Approval_products')); ?><span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($items->total()); ?></span></h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header py-2  border-0">
                <h4><?php echo e(translate('messages.Item_List')); ?></h4>
                <div class="search--button-wrapper justify-content-end">
                    <form class="search-form">

                        <!-- Search -->
                        <div class="input-group input--group">
                            <input id="datatableSearch" type="search"  value="<?php echo e(request()?->search ?? null); ?>" name="search" class="form-control" placeholder="<?php echo e(translate('messages.ex_search_name')); ?>" aria-label="<?php echo e(translate('messages.search_here')); ?>">
                            <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                        </div>
                        <!-- End Search -->
                    </form>
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
                            <th class="border-0"><?php echo e(translate('messages.price')); ?></th>
                            <th class="border-0 "><?php echo e(translate('messages.status')); ?></th>
                            <th class="border-0 text-center"><?php echo e(translate('messages.action')); ?></th>
                        </tr>
                    </thead>

                    <tbody id="set-rows">
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+$items->firstItem()); ?></td>
                            <td>
                                <a class="media align-items-center" href="<?php echo e(route('vendor.item.requested_item_view',['id'=> $item['id']])); ?>">
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
                            <td>
                                <div class="mw--85px">
                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($item['price'])); ?>

                                </div>
                            </td>
                            <td>
                                    <?php if($item->is_rejected == 1): ?>
                                    <span class="badge badge-soft-danger text-capitalize">
                                        <?php echo e(translate('messages.rejected')); ?>

                                    </span>
                                    <?php else: ?>
                                    <span class="badge badge-soft-info text-capitalize">
                                        <?php echo e(translate('messages.pending')); ?>

                                    </span>
                                    <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn--container justify-content-center">
                                    <?php if($item->is_rejected == 1): ?>
                                    <a class="btn btn-sm btn--primary btn-outline-primary action-btn"
                                        href="<?php echo e(route('vendor.item.edit',[$item['id'] , 'temp_product' => true])); ?>" title="<?php echo e(translate('messages.edit_item')); ?>"><i class="tio-edit"></i>
                                    </a>
                                    <?php endif; ?>
                                    <a class="btn btn-sm btn--danger btn-outline-danger action-btn form-alert" href="javascript:"
                                        data-id="food-<?php echo e($item['id']); ?>" data-message="<?php echo e(translate('Want to delete this item ?')); ?>" title="<?php echo e(translate('messages.delete_item')); ?>"><i class="tio-delete-outlined"></i>
                                    </a>
                                </div>
                                <form action="<?php echo e(route('vendor.item.delete',[$item['id']])); ?>"
                                        method="post" id="food-<?php echo e($item['id']); ?>">
                                    <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                    <input type="hidden" value="1" name="temp_product" >
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

        $('#datatableSearch').on('mouseup', function (e) {
          let $input = $(this),
            oldValue = $input.val();

          if (oldValue == "") return;

          setTimeout(function(){
            let newValue = $input.val();

            if (newValue == ""){
              // Gotcha
              datatable.search('').draw();
            }
          }, 1);
        });

        $('#toggleColumn_index').change(function (e) {
          datatable.columns(0).visible(e.target.checked)
        })
        $('#toggleColumn_name').change(function (e) {
          datatable.columns(1).visible(e.target.checked)
        })

        $('#toggleColumn_type').change(function (e) {
          datatable.columns(2).visible(e.target.checked)
        })

        $('#toggleColumn_status').change(function (e) {
          datatable.columns(4).visible(e.target.checked)
        })
        $('#toggleColumn_price').change(function (e) {
          datatable.columns(3).visible(e.target.checked)
        })
        $('#toggleColumn_action').change(function (e) {
          datatable.columns(5).visible(e.target.checked)
        })


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
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/product/pending_list.blade.php ENDPATH**/ ?>