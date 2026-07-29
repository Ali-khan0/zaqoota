<?php $__env->startSection('title',translate('messages.Product_Gallery')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php ($store_data=\App\CentralLogics\Helpers::get_store_data()); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="btn--container align-items-center mb-0">
                <div class="d-flex gap-2">
                    <img class="h--50px"
                        src="<?php echo e(asset('public/assets/admin/img/group.png')); ?>" alt="Product_Gallery">
                    <div>
                        <h1 class="page-header-title"> <?php echo e(translate('messages.Product_Gallery')); ?><span class="badge badge-soft-dark ml-2" id="itemCount"></span></h1>
                    <p><?php echo e(translate('search_product_and_use_its_info_to_create_own_product')); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <!-- Card -->
        <div class="card mb-3">
            <!-- Header -->
            <div class="card-body border-0">
                <form id="search-form" class="search-form">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" value="1" name="product_gallery">
                    <div class="row">
                        <div class="col-11">
                            <input id="datatableSearch" type="search" value="<?php echo e(request()?->search ?? null); ?>" name="search" class="form-control" placeholder="<?php echo e(translate('messages.ex_search_name')); ?>" aria-label="<?php echo e(translate('messages.search_here')); ?>">
                        </div>
                        <div class="col-1">
                            <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.search')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- End Header -->
        </div>
        <!-- End Card -->
        <div>
            <h2><?php echo e(translate('messages.Product_List')); ?></h2>
            <p><?php echo e(translate('search_product_and_use_its_info_to_create_own_product')); ?></p>
        </div>

                    <div class="row" id="set-rows">
                        <?php echo $__env->make('vendor-views.product.partials._gallery', [
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

            <!-- End Table -->
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

        $('#search-form').on('submit', function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '<?php echo e(route('vendor.item.search')); ?>',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('#itemCount').html(data.count);
                    $('.page-area').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/vendor-views/product/product_gallery.blade.php ENDPATH**/ ?>