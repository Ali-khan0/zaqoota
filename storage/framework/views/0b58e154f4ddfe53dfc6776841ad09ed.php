<?php $__env->startSection('title',translate('messages.item_report')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <?php
        $from = session('from_date');
        $to = session('to_date');
    ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/report.png')); ?>" class="w--22" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.item_report')); ?>

                    <?php if(isset($filter) && $filter != 'all_time'): ?>
                    <span class="mb-0 h6 badge badge-soft-success ml-2"
                        id="itemCount">( <?php echo e(session('from_date')); ?> - <?php echo e(session('to_date')); ?> )</span>
                        <?php endif; ?>
                </span>
            </h1>
        </div>
        <!-- End Page Header -->

        <div class="card mb-20">
            <div class="card-body">
                <h4 class=""><?php echo e(translate('Search Data')); ?></h4>
                <form action="<?php echo e(route('admin.transactions.report.set-date')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                <div class="row g-3">
                    <div class="col-sm-6 col-md-3">
                        <select name="module_id" class="form-control js-select2-custom set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="module_id" title="<?php echo e(translate('messages.select_modules')); ?>">
                            <option value="" <?php echo e(!request('module_id') ? 'selected':''); ?>><?php echo e(translate('messages.all_modules')); ?></option>
                            <?php $__currentLoopData = \App\Models\Module::notParcel()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option
                                    value="<?php echo e($module->id); ?>" <?php echo e(request('module_id') == $module->id?'selected':''); ?>>
                                    <?php echo e($module['module_name']); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <select name="zone_id" class="form-control js-select2-custom set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="zone_id" id="zone">
                    <option value="all"><?php echo e(translate('messages.All_Zones')); ?></option>
                    <?php $__currentLoopData = \App\Models\Zone::orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option
                            value="<?php echo e($z['id']); ?>" <?php echo e(isset($zone) && $zone->id == $z['id']?'selected':''); ?>>
                            <?php echo e($z['name']); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <select name="store_id" data-placeholder="<?php echo e(translate('messages.select_store')); ?>" class="js-data-example-ajax form-control set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="store_id" >
                            <?php if(isset($store)): ?>
                            <option value="<?php echo e($store->id); ?>" selected><?php echo e($store->name); ?></option>
                            <?php else: ?>
                            <option value="all" selected><?php echo e(translate('messages.all_stores')); ?></option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <select name="category_id" id="category_id"
                        class="js-data-example-ajax form-control set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="category_id"  id="category_id">
                        <?php if(isset($category)): ?>
                        <option value="<?php echo e($category->id); ?>" selected><?php echo e($category->name); ?></option>
                        <?php else: ?>
                        <option value="all" selected><?php echo e(translate('messages.All Categories')); ?></option>
                        <?php endif; ?>
                    </select>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <select class="form-control set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="filter"  name="filter">
                            <option value="all_time" <?php echo e(isset($filter) && $filter == "all_time" ? 'selected' : ''); ?>><?php echo e(translate('messages.All Time')); ?></option>
                            <option value="this_year" <?php echo e(isset($filter) && $filter == "this_year" ? 'selected' : ''); ?>><?php echo e(translate('messages.This Year')); ?></option>
                            <option value="previous_year" <?php echo e(isset($filter) && $filter == "previous_year" ? 'selected' : ''); ?>><?php echo e(translate('messages.Previous Year')); ?></option>
                            <option value="this_month" <?php echo e(isset($filter) && $filter == "this_month" ? 'selected' : ''); ?>><?php echo e(translate('messages.This Month')); ?></option>
                            <option value="this_week" <?php echo e(isset($filter) && $filter == "this_week" ? 'selected' : ''); ?>><?php echo e(translate('messages.This Week')); ?></option>
                            <option value="custom" <?php echo e(isset($filter) && $filter == 'custom' ? 'selected' : ''); ?>>
                                <?php echo e(translate('messages.Custom')); ?></option>
                        </select>
                    </div>
                    <?php if(isset($filter) && $filter == 'custom'): ?>
                    <div class="col-sm-6 col-md-3">

                            <input type="date" name="from" id="from_date" class="form-control" placeholder="<?php echo e(translate('Start Date')); ?>" <?php echo e(session()->has('from_date')?'value='.session('from_date'):''); ?> required>

                    </div>
                    <div class="col-sm-6 col-md-3">

                            <input type="date" name="to" id="to_date" class="form-control" placeholder="<?php echo e(translate('End Date')); ?>" <?php echo e(session()->has('to_date')?'value='.session('to_date'):''); ?> required>

                    </div>
                    <?php endif; ?>
                    <div class="col-sm-6 col-md-3 ml-auto">
                        <button type="submit" class="btn btn-primary btn-block h--45px"><?php echo e(translate('Filter')); ?></button>
                    </div>
                </div>
            </form>
            </div>
        </div>
        <!-- Card -->
        <div class="row card mt-4">
            <!-- Header -->
            <div class="card-header border-0 py-2">
                <div class="search--button-wrapper">
                    <h3 class="card-title">
                        <?php echo e(translate('Item report table')); ?><span class="badge badge-soft-secondary" id="countItems"><?php echo e($items->total()); ?></span>
                    </h3>
                    <form class="search-form">
                    <!-- Search -->
                    <div class="input--group input-group">
                        <input id="datatableSearch" name="search" type="search" class="form-control" placeholder="<?php echo e(translate('ex_:_search_item_name')); ?>" value="<?php echo e(request()?->search ?? null); ?>" aria-label="<?php echo e(translate('messages.search_here')); ?>">
                        <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                    </div>
                    <!-- End Search -->
                    </form>
                    <?php if(request()->get('search')): ?>
                        <button type="reset" class="btn btn--primary ml-2 location-reload-to-base" data-url="<?php echo e(url()->full()); ?>"><?php echo e(translate('messages.reset')); ?></button>
                    <?php endif; ?><!-- Unfold -->
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
                            <a id="export-excel" class="dropdown-item" href="<?php echo e(route('admin.transactions.report.item-wise-export', ['type'=>'excel',request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                    alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item" href="<?php echo e(route('admin.transactions.report.item-wise-export', ['type'=>'csv',request()->getQueryString()])); ?>">
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
                <table id="datatable" class="table table-borderless table-thead-bordered table-nowrap card-table"
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
                        <th><?php echo e(translate('sl')); ?></th>
                        <th class="w--2"><?php echo e(translate('messages.name')); ?></th>
                        <th class="w--2"><?php echo e(translate('messages.module')); ?></th>
                        <th class="w--2"><?php echo e(translate('messages.store')); ?></th>
                        <th><?php echo e(translate('messages.stock')); ?></th>
                        <th><?php echo e(translate('messages.sell_count')); ?></th>
                        <th><?php echo e(translate('messages.price')); ?></th>
                        <th><?php echo e(translate('messages.total_amount_sold')); ?></th>
                        <th><?php echo e(translate('messages.total_discount_given')); ?></th>
                        <th><?php echo e(translate('messages.average_sale_value')); ?></th>
                        <th><?php echo e(translate('messages.average_ratings')); ?></th>
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
                                        <h5 class="text-hover-primary mb-0" title="<?php echo e($item['name']); ?>">
                                            <?php echo e(strlen($item['name']) > 30 ? substr($item['name'], 0, 30).'...' : $item['name']); ?>

                                        </h5>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <?php echo e($item->module->module_name); ?>

                            </td>
                            <td>
                                <?php if($item->store): ?>
                                <?php echo e(Str::limit($item->store->name,25,'...')); ?>

                                <?php else: ?>
                                <?php echo e(translate('messages.store_deleted')); ?>

                                <?php endif; ?>
                            </td>
                            <td>
                                <?php echo e($item->module->module_type == 'food'? translate('N/A') : $item->stock); ?>

                            </td>
                            <td>
                                <?php echo e($item->orders_sum_quantity ?? 0); ?>

                            </td>
                            <td>
                                <?php echo e(\App\CentralLogics\Helpers::format_currency($item->price)); ?>

                            </td>
                            <td>
                                <?php echo e(\App\CentralLogics\Helpers::format_currency($item->orders_sum_price)); ?>

                            </td>
                            <td>
                                <?php echo e(\App\CentralLogics\Helpers::format_currency($item->total_discount)); ?>

                            </td>
                            <td>
                                <?php echo e($item->orders_count>0? \App\CentralLogics\Helpers::format_currency(($item->orders_sum_price-$item->total_discount)/($item->orders_sum_quantity ?? 0) ) :0); ?>

                            </td>
                            <td>
                                <div class="rating">
                                    <span><i class="tio-star"></i></span><?php echo e(round($item->avg_rating,1)); ?> (<?php echo e($item->rating_count); ?>)
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('script_2'); ?>

    <script src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chart.js/dist/Chart.min.js"></script>
    <script
        src="<?php echo e(asset('public/assets/admin')); ?>/vendor/chartjs-chart-matrix/dist/chartjs-chart-matrix.min.js"></script>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/hs.chartjs-matrix.js"></script>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/admin-reports.js"></script>
    <script>
        "use strict";
        $(document).on('ready', function () {
            $('.js-data-example-ajax').select2({
                ajax: {
                    url: '<?php echo e(url('/')); ?>/admin/store/get-stores',
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            // all:true,
                    <?php if(isset($zone)): ?>zone_ids: [<?php echo e($zone->id); ?>], <?php endif; ?>
                    <?php if(request('module_id')): ?>module_id: <?php echo e(request('module_id')); ?>, <?php endif; ?>
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
                url: '<?php echo e(url('/')); ?>/admin/item/get-categories?parent_id=0',
                data: function(params) {
                    return {
                        q: params.term, // search term
                        <?php if(request('module_id')): ?>module_id: <?php echo e(request('module_id')); ?>, <?php endif; ?>
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

        $('#search-form').on('submit', function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '<?php echo e(route('admin.transactions.report.item-wise-report-search')); ?>',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('#countItems').html(data.count);
                    $('.page-area').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/report/item-wise-report.blade.php ENDPATH**/ ?>