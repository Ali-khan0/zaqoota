<?php $__env->startSection('title',translate('messages.sub_category')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/categories.png')); ?>" class="w--20" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.sub_category')); ?> <span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($categories->total()); ?></span>
                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header py-2 border-0">
                        <div class="search--button-wrapper justify-content-end">
                            <form  class="search-form min--280">
                                <?php echo csrf_field(); ?>
                                <!-- Search -->
                                <div class="input-group input--group">
                                    <input   value="<?php echo e(request()?->search ?? null); ?>" type="search" name="search" class="form-control" placeholder="<?php echo e(translate('messages.ex_:_search_sub_category')); ?>" aria-label="<?php echo e(translate('messages.search_here')); ?>">
                                    <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                                </div>
                                <!-- End Search -->
                            </form>
                            <!-- Unfold -->
                            <div class="hs-unfold mr-2">
                                <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle h--40px" href="javascript:"
                                    data-hs-unfold-options='{
                                        "target": "#usersExportDropdown",
                                        "type": "css-animation"
                                    }'>
                                    <i class="tio-download-to mr-1"></i> <?php echo e(translate('messages.export')); ?>

                                </a>

                                <div id="usersExportDropdown"
                                        class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">

                                    <span
                                        class="dropdown-header"><?php echo e(translate('messages.download_options')); ?></span>
                                    <a id="export-excel" class="dropdown-item" href="<?php echo e(route('vendor.category.export-sub-categories',['type'=>'excel',request()->getQueryString()])); ?>">
                                        <img class="avatar avatar-xss avatar-4by3 mr-2"
                                                src="<?php echo e(asset('public/assets/admin/svg/components/excel.svg')); ?>"
                                                alt="Image Description">
                                        <?php echo e(translate('messages.excel')); ?>

                                    </a>
                                    <a id="export-csv" class="dropdown-item" href="<?php echo e(route('vendor.category.export-sub-categories', ['type'=>'csv',request()->getQueryString()])); ?>">
                                        <img class="avatar avatar-xss avatar-4by3 mr-2"
                                                src="<?php echo e(asset('public/assets/admin/svg/components/placeholder-csv-format.svg')); ?>"
                                                alt="Image Description">
                                        .<?php echo e(translate('messages.csv')); ?>

                                    </a>
                                    
                                </div>
                            </div>
                            <!-- End Unfold -->
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive datatable-custom">
                            <table id="columnSearchDatatable"
                                class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                data-hs-datatables-options='{
                                    "search": "#datatableSearch",
                                    "entries": "#datatableEntries",
                                    "isResponsive": false,
                                    "isShowPaging": false,
                                    "paging":false,
                                }'>
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-0"><?php echo e(translate('messages.#')); ?></th>
                                        <th class="border-0"><?php echo e(translate('messages.category_id')); ?></th>
                                        <th class="border-0"><?php echo e(translate('messages.main_category')); ?></th>
                                        <th class="border-0"><?php echo e(translate('messages.sub_category')); ?></th>
                                    </tr>
                                </thead>

                                <tbody id="set-rows">
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key+$categories->firstItem()); ?></td>
                                        <td><?php echo e($category->id); ?></td>
                                        <td>
                                            <span class="d-block font-size-sm text-body">
                                                <?php echo e(Str::limit($category->parent?$category->parent['name']:translate('messages.category_deleted'),20,'...')); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <span class="d-block font-size-sm text-body">
                                                <?php echo e(Str::limit($category->name,20,'...')); ?>

                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer page-area">
                        <!-- Pagination -->
                        <?php echo $categories->links(); ?>

                        <!-- End Pagination -->
                        <?php if(count($categories) === 0): ?>
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
    </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/category/sub-index.blade.php ENDPATH**/ ?>