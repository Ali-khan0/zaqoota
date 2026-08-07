<?php $__env->startSection('title',translate('messages.brand list')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <div class="card mt-3">
            <div class="card-header py-2 border-0">
                <div class="search--button-wrapper">
                    <h5 class="card-title"><?php echo e(translate('messages.brand_list')); ?><span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($brands->total()); ?></span></h5>

                    <form class="search-form" method="get" action="">
                        <!-- Search -->
                        <div class="input-group input--group">
                            <input type="search" name="search" value="<?php echo e(request()?->search ?? null); ?>" class="form-control min-height-45" placeholder="<?php echo e(translate('messages.search_by_brand_name')); ?>" aria-label="<?php echo e(translate('messages.ex_:_categories')); ?>">
                            <button type="submit" class="btn btn--secondary min-height-45"><i class="tio-search"></i></button>
                        </div>
                        <!-- End Search -->
                    </form>
                    <?php if(request()->get('search')): ?>
                        <button type="reset" class="btn btn--primary ml-2 location-reload-to-brand" data-url="<?php echo e(url()->full()); ?>"><?php echo e(translate('messages.reset')); ?></button>
                    <?php endif; ?>
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
                            <a id="export-excel" class="dropdown-item" href="<?php echo e(route('vendor.vehicle_brand.export', ['type' => 'excel', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                     src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                     alt="<?php echo e(translate('Image Description')); ?>">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item" href="<?php echo e(route('vendor.vehicle_brand.export', ['type' => 'csv', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                     src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                     alt="<?php echo e(translate('Image Description')); ?>">
                                <?php echo e(translate('messages.csv')); ?>

                            </a>

                        </div>
                    </div>
                    <!-- End Unfold -->
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive datatable-custom">
                    <table id="columnSearchDatatable"
                           class="table table-borderless table-thead-bordered table-align-middle"
                           data-hs-datatables-options='{
                            "isResponsive": false,
                            "isShowPaging": false,
                            "paging":false,
                        }'>
                        <thead class="thead-light">
                        <tr>
                            <th class="border-0"><?php echo e(translate('sl')); ?></th>
                            <th class="border-0"><?php echo e(translate('messages.brand_id')); ?></th>
                            <th class="border-0"><?php echo e(translate('messages.brand_image')); ?></th>
                            <th class="border-0"><?php echo e(translate('messages.brand_name')); ?></th>
                        </tr>
                        </thead>

                        <tbody id="table-div">
                        <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($key+$brands->firstItem()); ?></td>
                                <td><?php echo e($brand->id); ?></td>
                                <td>
                                    <span class="media align-items-center">
                                    <img class="w-auto h--50px aspect-2-1 rounded onerror-image" src="<?php echo e($brand['image_full_url']); ?>" data-onerror-image="<?php echo e($brand['image_full_url']); ?>" alt="<?php echo e(translate('brand image')); ?>">
                                </span>
                                </td>
                                <td>
                                    <span class="d-block font-size-sm text-body">
                                        <?php echo e(Str::limit($brand['name'], 20,'...')); ?>

                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if(count($brands) !== 0): ?>
                <hr>
            <?php endif; ?>
            <div class="page-area">
                <?php echo $brands->appends($_GET)->links(); ?>

            </div>
            <?php if(count($brands) === 0): ?>
                <div class="empty--data">
                    <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                    <h5>
                        <?php echo e(translate('no_data_found')); ?>

                    </h5>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/provider/brand/list.blade.php ENDPATH**/ ?>