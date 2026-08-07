<?php $__env->startSection('title',translate('Product_Gallery')); ?>

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
                            <img src="<?php echo e(asset('public/assets/admin/img/group.png')); ?>" class="w--22" alt="">
                        </span>
                        <span>
                            <?php echo e(translate('messages.Product_Gallery')); ?> <span class="badge badge-soft-dark ml-2" id="foodCount"></span>
                        </span>
                    </h1>
                </div>
            </div>

        </div>
        <!-- End Page Header -->
        <!-- Card -->
        <div class="card mb-3">
            <!-- Header -->
            <div class="card-body border-0">
                <form id="search-form" action="javascript:;" class="search-form">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" value="1" name="product_gallery">
                    <div class="row g-2">
                        <div class="col-md-3 col-lg-3">
                            <select name="store_id" id="store" data-url="<?php echo e(url()->full()); ?>" data-placeholder="<?php echo e(translate('messages.select_store')); ?>" class="js-data-example-ajax form-control store-filter" required title="Select Store" oninvalid="this.setCustomValidity('<?php echo e(translate('messages.please_select_store')); ?>')">
                                <?php if($store): ?>
                                    <option value="<?php echo e($store->id); ?>" selected><?php echo e($store->name); ?></option>
                                <?php else: ?>
                                    <option value="all" selected><?php echo e(translate('messages.all_stores')); ?></option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-3 col-lg-3">
                            <select name="category_id" id="category_id" data-placeholder="<?php echo e(translate('messages.select_category')); ?>"
                                    class="js-data-example-ajax form-control set-filter" id="category_id"
                                    data-url="<?php echo e(url()->full()); ?>" data-filter="category_id">
                                <?php if($category): ?>
                                    <option value="<?php echo e($category->id); ?>" selected><?php echo e($category->name); ?></option>
                                <?php else: ?>
                                    <option value="all" selected><?php echo e(translate('messages.all_category')); ?></option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <input id="datatableSearch" type="search" value="<?php echo e(request()?->search ?? null); ?>" name="search" class="form-control h--42px" placeholder="<?php echo e(translate('messages.ex_search_name')); ?>" aria-label="<?php echo e(translate('messages.search_here')); ?>">
                        </div>
                        <div class="col-md-2 col-lg-2 text-end">
                            <button type="submit" class="btn btn--primary w-100 h-100"><?php echo e(translate('messages.search')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- End Header -->
        </div>

        <div class="row" id="set-rows">
                        <?php echo $__env->make('admin-views.product.partials._gallery', [
                            $items,
                        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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

        $('#toggleColumn_vendor').change(function (e) {
          datatable.columns(3).visible(e.target.checked)
        })

        $('#toggleColumn_status').change(function (e) {
          datatable.columns(5).visible(e.target.checked)
        })
        $('#toggleColumn_price').change(function (e) {
          datatable.columns(4).visible(e.target.checked)
        })
        $('#toggleColumn_action').change(function (e) {
          datatable.columns(6).visible(e.target.checked)
        })

            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                let select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });

        $('#store').select2({
            ajax: {
                url: '<?php echo e(url('/')); ?>/admin/store/get-stores',
                data: function (params) {
                    return {
                        q: params.term, // search term
                        module_id:<?php echo e(Config::get('module.current_module_id')); ?>,
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
                url: '<?php echo e(route("admin.category.get-all")); ?>',
                data: function (params) {
                    return {
                        q: params.term, // search term
                        all:true,
                        module_id:<?php echo e(Config::get('module.current_module_id')); ?>,
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

        $('#search-form').on('submit', function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    let queryParams = $(this).serialize();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.post({
        url: '<?php echo e(route('admin.item.search')); ?>?' + queryParams,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $('#loading').show();
        },
        success: function (data) {
            $('#set-rows').html(data.view);
            $('.page-area').hide();
            $('#foodCount').html(data.count);
        },
        complete: function () {
            $('#loading').hide();
        },
    });
});
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/product/product_gallery.blade.php ENDPATH**/ ?>