<?php $__env->startSection('title',translate('low_stock_list')); ?>
<?php $__env->startSection('low_stock_list'); ?>
active
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-header-title">
            <span class="page-header-icon">
                <img src="<?php echo e(asset('public/assets/admin/img/report.png')); ?>" class="w--22" alt="">
            </span>
            <span>
                <?php echo e(translate('low_stock_list')); ?>

                <span class="badge badge-soft-secondary" id=""><?php echo e($items->total()); ?></span>
            </span>
        </h1>
    </div>
    <!-- End Page Header -->
    <!-- Card -->
    <div class="card mt-3">
        <!-- Header -->
        <div class="card-header border-0 py-2">
            <div class="search--button-wrapper justify-content-end">
                <form class="search-form">
                    <!-- Search -->
                    <div class="input-group input--group">
                        <input id="datatableSearch" name="search" type="search" class="form-control" placeholder="<?php echo e(translate('ex_:_search_name')); ?>" aria-label="<?php echo e(translate('messages.search_here')); ?>" value="<?php echo e(request()->query('search')); ?>">
                        <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                    </div>
                    <!-- End Search -->
                </form>
                <div class="min--200">
                    <select name="zone_id" class="form-control js-select2-custom set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="zone_id" id="zone">
                        <option value="all"><?php echo e(translate('All Zones')); ?></option>
                        <?php $__currentLoopData = \App\Models\Zone::orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($z['id']); ?>" <?php echo e(isset($zone) && $zone->id == $z['id']?'selected':''); ?>>
                                <?php echo e(($z['name'])); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="min--200">
                    <select name="store_id" data-placeholder="<?php echo e(translate('messages.select_store')); ?>" class="js-data-example-ajax form-control set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="store_id">
                        <?php if(isset($store)): ?>
                            <option value="<?php echo e($store->id); ?>" selected><?php echo e($store->name); ?></option>
                        <?php else: ?>
                            <option value="all" selected><?php echo e(translate('messages.all_stores')); ?></option>
                        <?php endif; ?>
                    </select>
                </div>
                <!-- Unfold -->
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
                        <a id="export-excel" class="dropdown-item" href="<?php echo e(route('admin.transactions.report.stock-wise-report-export', ['type'=>'excel',request()->getQueryString()])); ?>">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                alt="Image Description">
                            <?php echo e(translate('messages.excel')); ?>

                        </a>
                        <a id="export-csv" class="dropdown-item" href="<?php echo e(route('admin.transactions.report.stock-wise-report-export', ['type'=>'csv',request()->getQueryString()])); ?>">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                alt="Image Description">
                            .<?php echo e(translate('messages.csv')); ?>

                        </a>
                    </div>
                </div>
                <!-- End Unfold -->
            </div>
            <!-- End Row -->
        </div>
        <!-- End Header -->

        <!-- Table -->
        <div class="table-responsive datatable-custom" id="table-div">
            <table id="datatable" class="table table-borderless table-thead-bordered table-nowrap card-table" data-hs-datatables-options='{
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
                        <th class="border-0"><?php echo e(translate('sl')); ?></th>
                        <th class="border-0 w--2"><?php echo e(translate('messages.name')); ?></th>
                        <th class="border-0 w--2"><?php echo e(translate('messages.store')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.zone')); ?></th>
                        <th class="border-0"><?php echo e(translate('Current stock')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.action')); ?></th>
                    </tr>
                </thead>

                <tbody id="set-rows">

                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($key+$items->firstItem()); ?></td>
                        <td>
                            <a class="media align-items-center" href="<?php echo e(route('admin.item.view',[$item['id'],'module_id'=>$item['module_id']])); ?>">
                                <img class="avatar avatar-lg mr-3 onerror-image"

                                src="<?php echo e($item['image_full_url'] ?? asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                                 data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>" alt="<?php echo e($item->name); ?> image">
                                <div class="media-body">
                                    <h5 class="text-hover-primary mb-0 max-width-200px word-break line--limit-2"><?php echo e($item['name']); ?></h5>
                                </div>
                            </a>
                        </td>
                        <td>
                            <?php if($item->store): ?>
                            <?php echo e(Str::limit($item->store->name,25,'...')); ?>

                            <?php else: ?>
                            <?php echo e(translate('messages.store_deleted')); ?>

                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($item->store): ?>
                            <?php echo e($item->store?->zone?->name); ?>

                            <?php else: ?>
                            <?php echo e(translate('messages.not_found')); ?>

                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo e($item->stock); ?>

                        </td>
                        <td>
                            <a class="btn action-btn btn--primary btn-outline-primary update-quantity" href="javascript:" title="<?php echo e(translate('messages.edit_quantity')); ?>" data-id="<?php echo e($item->id); ?>" data-toggle="modal" data-target="#update-quantity"><i class="tio-edit"></i>
                            </a>
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
                <?php echo $items->links(); ?>

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

<?php $__env->stopSection(); ?>




<?php $__env->startPush('script_2'); ?>

<script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chart.js/dist/Chart.min.js"></script>
<script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chartjs-chart-matrix/dist/chartjs-chart-matrix.min.js"></script>
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/hs.chartjs-matrix.js"></script>

<script>
    "use strict";
    $('.update-quantity').on('click', function (){
        let val = $(this).data('id');
        $.get({
            url: '<?php echo e(url('/')); ?>/admin/item/get-variations?id='+val,
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

    $(document).on('ready', function() {
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
                        <?php if(Config::get('module.current_module_id')): ?>
                        module_id: <?php echo e(Config::get('module.current_module_id')); ?>

                        ,
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

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/report/stock-report.blade.php ENDPATH**/ ?>