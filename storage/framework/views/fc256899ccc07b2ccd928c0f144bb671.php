<?php $__env->startSection('title', translate('messages.driver')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/banner.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.drivers')); ?>

                </span>
            </h1>
        </div>

        <div class="row g-2 mb-20">
            <div class="col-sm-6 col-lg-4">
                <a class="order--card h-100" href="javascript:">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-subtitle m-0">
                            <span><?php echo e(translate('All')); ?></span>
                        </h6>
                        <span class="card-title text-title">
                            <?php echo e($totalDrivers ?? 0); ?>

                        </span>
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-lg-4">
                <a class="order--card h-100" href="javascript:">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-subtitle m-0">
                            <span><?php echo e(translate('messages.Active')); ?></span>
                        </h6>
                        <span class="card-title text--success">
                            <?php echo e($activeDrivers?? 0); ?>

                        </span>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-lg-4">
                <a class="order--card h-100" href="javascript:">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-subtitle m-0">
                            <span><?php echo e(translate('messages.Inactive')); ?></span>
                        </h6>
                        <span class="card-title text--info">
                            <?php echo e($inactiveDrivers ?? 0); ?>

                        </span>
                    </div>
                </a>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">



                <div class="card">
                    <div class="card-header py-2">
                        <div class="search--button-wrapper gap-20px">
                            <h5 class="card-title text--title flex-grow-1"><?php echo e(translate('messages.Driver_List')); ?><span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($drivers->count()); ?></span></h5>

                            <form class="search-form m-0 flex-grow-1 max-w-353px" method="get" action="">
                                <!-- Search -->
                                <div class="input-group input--group">
                                    <input id="datatableSearch_" type="search" value="<?php echo e(request()?->search ?? null); ?>"
                                           name="search" class="form-control"
                                           placeholder="<?php echo e(translate('Search by driver name...')); ?>"
                                           aria-label="<?php echo e(translate('messages.Search by driver name...')); ?>">
                                    <button type="submit" class="btn btn--secondary bg--primary"><i
                                            class="tio-search"></i></button>

                                </div>
                                <!-- End Search -->
                            </form>
                            <?php if(request()->get('search')): ?>
                                <button type="reset" class="btn btn--primary ml-2 location-reload-to-base"
                                        data-url="<?php echo e(url()->full()); ?>"><?php echo e(translate('messages.reset')); ?></button>
                            <?php endif; ?>
                            <!-- Unfold -->
                            <div class="hs-unfold m-0">
                                <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle min-height-40 font-semibold"
                                   href="javascript:;"
                                   data-hs-unfold-options='{
                                    "target": "#usersExportDropdown",
                                    "type": "css-animation"
                                }'>
                                    <i class="tio-download-to mr-1"></i> <?php echo e(translate('messages.export')); ?>

                                </a>

                                <div id="usersExportDropdown"
                                     class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">

                                    <span class="dropdown-header"><?php echo e(translate('messages.download_options')); ?></span>
                                    <a id="export-excel" class="dropdown-item"
                                       href="<?php echo e(route('vendor.driver.export', ['type' => 'excel', request()->getQueryString()])); ?>">
                                        <img class="avatar avatar-xss avatar-4by3 mr-2"
                                             src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                             alt="Image Description">
                                        <?php echo e(translate('messages.excel')); ?>

                                    </a>
                                    <a id="export-csv" class="dropdown-item"
                                       href="<?php echo e(route('vendor.driver.export', ['type' => 'csv', request()->getQueryString()])); ?>">
                                        <img class="avatar avatar-xss avatar-4by3 mr-2"
                                             src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                             alt="Image Description">
                                        .<?php echo e(translate('messages.csv')); ?>

                                    </a>

                                </div>
                            </div>
                            <a class="btn btn--primary font-weight-bold float-right mr-2 mb-0"
                            href="<?php echo e(route('vendor.driver.create', request()->id)); ?>"><?php echo e(translate('messages.new_driver')); ?></a>
                            <!-- End Unfold -->
                        </div>
                    </div>
                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table id="columnSearchDatatable"
                               class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                            <tr>
                                <th class="border-0"><?php echo e(translate('sl')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Driver_Info')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Total_Trip')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Complete')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Cancel_Trip')); ?></th>
                                <th class="text-center border-0"><?php echo e(translate('messages.Driver_Status')); ?></th>
                                <th class="text-center border-0"><?php echo e(translate('messages.Action')); ?></th>
                            </tr>
                            </thead>

                            <tbody id="set-rows">
                            <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key+$drivers->firstItem()); ?></td>
                                    <td>
                                        <div class="text--title">
                                            <div class="font-medium">
                                                <?php echo e(Str::limit($driver->fullName, 20,'...')); ?>

                                            </div>
                                            <div class="opacity-lg font-regular">
                                                <?php echo e($driver->phone); ?>

                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo e($driver->trips()->count()); ?>

                                    </td>
                                    <td>
                                        <?php echo e(count($driver->completedTrips)); ?>

                                    </td>
                                    <td>
                                        <?php echo e(count($driver->canceledTrips)); ?>

                                    </td>
                                    <td>
                                        <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox<?php echo e($driver->id); ?>">
                                            <input type="checkbox" data-url="<?php echo e(route('vendor.driver.status',[$driver['id'],$driver->status?0:1])); ?>" class="toggle-switch-input redirect-url" id="stocksCheckbox<?php echo e($driver->id); ?>" <?php echo e($driver->status?'checked':''); ?>>
                                            <span class="toggle-switch-label mx-auto">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a class="btn action-btn btn--warning btn-outline-warning" href="<?php echo e(route('vendor.driver.details', $driver->id)); ?>"
                                               title="<?php echo e(translate('messages.edit_store')); ?>"><i class="tio-visible-outlined"></i>
                                            </a>
                                            <a class="btn action-btn btn-outline-primary" href="<?php echo e(route('vendor.driver.edit', $driver->id)); ?>"
                                               title="<?php echo e(translate('messages.edit_store')); ?>"><i class="tio-edit"></i>
                                            </a>
                                            <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:"
                                               data-id="brand-<?php echo e($driver['id']); ?>" data-message="<?php echo e(translate('Want to delete this driver')); ?>" title="<?php echo e(translate('messages.delete_driver')); ?>"><i class="tio-delete-outlined"></i>
                                            </a>
                                            <form action="<?php echo e(route('vendor.driver.delete',[$driver['id']])); ?>" method="post" id="brand-<?php echo e($driver['id']); ?>">
                                                <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if(count($drivers) !== 0): ?>
                        <hr>
                    <?php endif; ?>
                    <div class="page-area">
                        <?php echo $drivers->links(); ?>

                    </div>
                    <?php if(count($drivers) === 0): ?>
                        <div class="empty--data">
                            <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                            <h5>
                                <?php echo e(translate('no_data_found')); ?>

                            </h5>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <!-- End Table -->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/provider/driver/list.blade.php ENDPATH**/ ?>