

<?php $__env->startSection('title',translate('All Products with Stores')); ?>

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
                            <?php echo e(translate('All Products with Stores')); ?> <span class="badge badge-soft-dark ml-2" id="foodCount"><?php echo e($items->total()); ?></span>
                        </span>
                    </h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        
        <div class="card mb-3">
            <!-- Header -->
            <div class="card-header py-2 border-0">
                <h1><?php echo e(translate('search_data')); ?></h1>
            </div>

            <div class="row mr-1 ml-2 mb-2">
                <div class="col-sm-6 col-md-3">
                    <div class="select-item">
                        <select name="store_id" id="store" data-url="<?php echo e(url()->full()); ?>" data-placeholder="<?php echo e(translate('messages.select_store')); ?>" class="js-data-example-ajax form-control store-filter" title="Select Store">
                            <?php if($store): ?>
                            <option value="<?php echo e($store->id); ?>" selected><?php echo e($store->name); ?></option>
                            <?php else: ?>
                            <option value="all" selected><?php echo e(translate('messages.all_stores')); ?></option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="select-item">
                        <select name="status" class="form-control js-select2-custom set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="status">
                            <option value="all" <?php echo e($status_filter == 'all' ? 'selected' : ''); ?>><?php echo e(translate('All Status')); ?></option>
                            <option value="pending" <?php echo e($status_filter == 'pending' ? 'selected' : ''); ?>><?php echo e(translate('Pending')); ?></option>
                            <option value="approved" <?php echo e($status_filter == 'approved' ? 'selected' : ''); ?>><?php echo e(translate('Approved')); ?></option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <form action="javascript:" id="search-form">
                        <div class="input-group input-group-merge input-group-flush">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tio-search"></i>
                                </div>
                            </div>
                            <input id="datatableSearch" type="search" name="search" value="<?php echo e(request('search')); ?>" class="form-control" placeholder="<?php echo e(translate('messages.search_by_product_name')); ?>" aria-label="<?php echo e(translate('messages.search')); ?>">
                        </div>
                    </form>
                </div>

                <div class="col-sm-6 col-md-3">
                    <button type="button" class="btn btn--primary btn-block" onclick="filter()">
                        <i class="tio-filter-list mr-1"></i><?php echo e(translate('Filter')); ?>

                    </button>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header py-2 border-0">
                <div class="search--button-wrapper">
                    <h5 class="card-title">
                        <span class="card-title-icon"><i class="tio-apps"></i></span>
                        <span><?php echo e(translate('products_list')); ?></span>
                    </h5>
                </div>
            </div>
            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table id="columnSearchDatatable"
                    class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                    data-hs-datatables-options='{
                        "order": [],
                        "orderCellsTop": true,
                        "paging": false
                    }'>
                    <thead class="bg-table-head">
                    <tr>
                        <th class="text-title border-0"><?php echo e(translate('sl')); ?></th>
                        <th class="text-title border-0"><?php echo e(translate('messages.name')); ?></th>
                        <th class="text-title border-0"><?php echo e(translate('messages.category')); ?></th>
                        <th class="text-title border-0"><?php echo e(translate('messages.store')); ?></th>
                        <th class="text-title border-0"><?php echo e(translate('messages.price')); ?></th>
                        <th class="text-title border-0"><?php echo e(translate('messages.status')); ?></th>
                        <th class="text-title border-0 text-center"><?php echo e(translate('messages.action')); ?></th>
                    </tr>
                    </thead>

                    <tbody id="set-rows">
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+$items->firstItem()); ?></td>
                            <td>
                                <a class="media align-items-center" href="<?php echo e($item['type'] == 'temp_product' ? route('admin.item.requested_item_view',['id'=> $item['id']]) : route('admin.item.view',['id'=> $item['id']])); ?>">
                                    <img class="avatar avatar-lg mr-3 onerror-image"
                                    src="<?php echo e($item['image_full_url']); ?>"
                                    data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>" alt="<?php echo e($item['name']); ?> image">
                                    <div class="media-body">
                                        <h5 class="text-hover-primary mb-0"><?php echo e(Str::limit($item['name'],20,'...')); ?></h5>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <?php echo e(Str::limit($item['category_name'],20,'...')); ?>

                            </td>
                            <td>
                                <a href="<?php echo e(route('admin.store.view', $item['store_id'])); ?>" class="table-rest-info" alt="view store"> 
                                    <?php echo e(Str::limit($item['store_name'], 20, '...')); ?>

                                </a>
                            </td>
                            <td>
                                <div class="mw--85px">
                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($item['price'])); ?>

                                </div>
                            </td>
                            <td>
                                <?php if($item['status'] == 'approved'): ?>
                                <span class="badge badge-soft-success text-capitalize">
                                    <?php echo e(translate('messages.approved')); ?>

                                </span>
                                <?php elseif($item['status'] == 'rejected'): ?>
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
                                    <a class="btn action-btn btn--primary btn-outline-primary" 
                                        href="<?php echo e(route('admin.store.view', ['store' => $item['store_id'], 'tab' => 'item'])); ?>" 
                                        title="<?php echo e(translate('View Store Items')); ?>">
                                        <i class="tio-shop"></i>
                                    </a>
                                    <?php if($item['type'] == 'temp_product'): ?>
                                        <a class="ml-2 btn btn-sm btn--warning btn-outline-warning action-btn" 
                                            href="<?php echo e(route('admin.item.requested_item_view',['id'=> $item['id']])); ?>"
                                            title="<?php echo e(translate('messages.View')); ?>">
                                            <i class="tio-invisible"></i>
                                        </a>
                                    <?php else: ?>
                                        <a class="ml-2 btn btn-sm btn--warning btn-outline-warning action-btn" 
                                            href="<?php echo e(route('admin.item.view',['id'=> $item['id']])); ?>"
                                            title="<?php echo e(translate('messages.View')); ?>">
                                            <i class="tio-invisible"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <!-- End Table -->

            <!-- Footer -->
            <div class="card-footer">
                <div class="row">
                    <div class="col-12">
                        <?php echo $items->links(); ?>

                    </div>
                </div>
            </div>
            <!-- End Footer -->
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script>
        function filter() {
            let store_id = $('#store').val();
            let status = $('select[name="status"]').val();
            let search = $('#datatableSearch').val();
            
            let url = new URL(window.location.href);
            url.searchParams.set('store_id', store_id);
            url.searchParams.set('status', status);
            if(search) {
                url.searchParams.set('search', search);
            } else {
                url.searchParams.delete('search');
            }
            url.searchParams.delete('page');
            
            window.location.href = url.href;
        }

        $(document).on('ready', function () {
            $('#datatableSearch').on('keypress', function(e) {
                if (e.which === 13) {
                    filter();
                }
            });

            $('.set-filter').on('change', function() {
                filter();
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/product/all-products-stores.blade.php ENDPATH**/ ?>