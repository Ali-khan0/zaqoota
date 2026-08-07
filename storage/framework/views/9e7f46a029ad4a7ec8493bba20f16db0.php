<?php $__env->startSection('title', translate('messages.vehicle_list')); ?>

<?php $__env->startPush('css_or_js'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <?php echo $__env->make('rental::admin.provider.details.partials._header',['store'=>$store], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div class="row g-2 mb-20">
            <div class="col-sm-6 col-lg-3">
                <a class="order--card h-100" href="javascript:">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-subtitle m-0">
                            <span><?php echo e(translate('All')); ?></span>
                        </h6>
                        <span class="card-title text-title">
                            <?php echo e($totalVehicles); ?>

                        </span>
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-lg-3">
                <a class="order--card h-100" href="javascript:">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-subtitle m-0">
                            <span><?php echo e(translate('messages.Ongoing')); ?></span>
                        </h6>
                        <span class="card-title text--warning">
                            <?php echo e($ongoingVehicles); ?>

                        </span>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3">
                <a class="order--card h-100" href="javascript:">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-subtitle m-0">
                            <span><?php echo e(translate('messages.Active')); ?></span>
                        </h6>
                        <span class="card-title text--success">
                            <?php echo e($activeVehicles); ?>

                        </span>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3">
                <a class="order--card h-100" href="javascript:">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-subtitle m-0">
                            <span><?php echo e(translate('messages.Inctive')); ?></span>
                        </h6>
                        <span class="card-title text--danger">
                            <?php echo e($inactiveVehicles); ?>

                        </span>
                    </div>
                </a>
            </div>
        </div>
        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header py-2">
                <div class="search--button-wrapper">
                    <h5 class="card-title text--title">
                        <?php echo e(translate('messages.Total_Vehicles')); ?>

                        <span class="badge badge-soft-dark ml-2 rounded-circle" id="itemCount"><?php echo e($vehicles->total()); ?></span>
                    </h5>
                    <form class="search-form">
                        <!-- Search -->
                        <div class="input-group input--group">
                            <input id="datatableSearch_" type="search" value="<?php echo e(request()?->search ?? null); ?>"
                                   name="search" class="form-control"
                                   placeholder="<?php echo e(translate('Search by name, owner info...')); ?>"
                                   aria-label="<?php echo e(translate('messages.Search by name, owner info...')); ?>">
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
                    <div class="hs-unfold mr-2">
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
                               href="<?php echo e(route('admin.rental.provider.vehicle.export', ['provider_id'=>request()->id,'type' => 'excel', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                     src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                     alt="<?php echo e(translate('Image Description')); ?>">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item"
                               href="<?php echo e(route('admin.rental.provider.vehicle.export', ['provider_id'=>request()->id,'type' => 'csv', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                     src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                     alt="<?php echo e(translate('Image Description')); ?>">
                                <?php echo e(translate('messages.csv')); ?>

                            </a>

                        </div>
                    </div>
                    <!-- End Unfold -->
                    <a class="btn btn--primary font-weight-bold float-right mr-2 mb-0"
                       href="<?php echo e(route('admin.rental.provider.vehicle.create')); ?>?provider_id=<?php echo e(request()->id); ?>"><?php echo e(translate('messages.new_vehicle')); ?></a>
                </div>
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table id="columnSearchDatatable"
                       class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                       data-hs-datatables-options='{
                        "order": [],
                        "orderCellsTop": true,
                        "paging":false

                    }'>
                    <thead class="thead-light">
                    <tr>
                        <th class="border-0"><?php echo e(translate('sl')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.Vehicle_Info')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.Category')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.Brand')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.Total_Trip')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.Trip Fair')); ?></th>
                        <th class="text-center border-0"><?php echo e(translate('messages.New_Tag')); ?></th>
                        <th class="text-center border-0"><?php echo e(translate('messages.Status')); ?></th>
                        <th class="text-center border-0"><?php echo e(translate('messages.Action')); ?></th>
                    </tr>
                    </thead>

                    <tbody id="set-rows">
                    <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+$vehicles->firstItem()); ?></td>
                            <td>
                                <div class="text--title">
                                    <a href="<?php echo e(route('admin.rental.provider.vehicle.details', $vehicle->id)); ?>" class="font-medium">
                                        <?php echo e($vehicle->name); ?>

                                    </a>
                                    <div class="opacity-lg">
                                        <?php echo e($vehicle->model); ?>

                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text--title font-medium">
                                    <?php echo e($vehicle?->category?->name); ?>

                                </div>
                            </td>
                            <td>
                                <div class="text--title font-medium">
                                    <?php echo e($vehicle?->brand?->name); ?>

                                </div>
                            </td>
                            <td>
                                <div class="text--title font-medium">
                                    <?php echo e(count($vehicle->tripDetails)); ?>

                                </div>
                            </td>
                            <td>
                                <div class="text--title">
                                    <?php if($vehicle->trip_hourly): ?>
                                        <div>
                                            <span class="opacity-lg"><?php echo e(translate('Hourly')); ?>: </span>
                                            <span class="font-semibold"><?php echo e(\App\CentralLogics\Helpers::format_currency($vehicle['hourly_price'])); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($vehicle->trip_distance): ?>
                                        <div>
                                            <span class="opacity-lg"><?php echo e(translate('Distance Wise')); ?>: </span>
                                            <span class="font-semibold"><?php echo e(\App\CentralLogics\Helpers::format_currency($vehicle['distance_price'])); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($vehicle->trip_day_wise): ?>
                                        <div>
                                            <span class="opacity-lg"><?php echo e(translate('Per Day')); ?>: </span>
                                            <span class="font-semibold"><?php echo e(\App\CentralLogics\Helpers::format_currency($vehicle['day_wise_price'])); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <label class="toggle-switch toggle-switch-sm" for="stocksCheckboxNew<?php echo e($vehicle->id); ?>">
                                        <input type="checkbox" data-url="<?php echo e(route('admin.rental.provider.vehicle.new-tag',[$vehicle['id'],$vehicle->new_tag?0:1])); ?>"
                                               class="toggle-switch-input redirect-url" id="stocksCheckboxNew<?php echo e($vehicle->id); ?>" <?php echo e($vehicle->new_tag?'checked':''); ?>>
                                        <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox<?php echo e($vehicle->id); ?>">
                                        <input type="checkbox" data-url="<?php echo e(route('admin.rental.provider.vehicle.status',[$vehicle['id'],$vehicle->status?0:1])); ?>"
                                               class="toggle-switch-input redirect-url" id="stocksCheckbox<?php echo e($vehicle->id); ?>" <?php echo e($vehicle->status?'checked':''); ?>>
                                        <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="btn--container justify-content-center">
                                    <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route('admin.rental.provider.vehicle.details', $vehicle->id)); ?>?provider_id=<?php echo e($vehicle->provider_id); ?>&provider_vehicle_list=true"
                                       title="<?php echo e(translate('messages.view')); ?>"><i class="tio-visible-outlined"></i>
                                    </a>
                                    <a class="btn action-btn btn-outline-primary" href="<?php echo e(route('admin.rental.provider.vehicle.edit', $vehicle->id)); ?>"
                                       title="<?php echo e(translate('messages.edit_store')); ?>"><i class="tio-edit"></i>
                                    </a>
                                    <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:"
                                       data-id="vehicle-<?php echo e($vehicle['id']); ?>" data-message="<?php echo e(translate('Want to delete this vehicle')); ?>" title="<?php echo e(translate('messages.delete_vehicle')); ?>"><i
                                            class="tio-delete-outlined"></i>
                                    </a>

                                </div>
                                <form action="<?php echo e(route('admin.rental.provider.vehicle.delete',[$vehicle['id']])); ?>" method="post" id="vehicle-<?php echo e($vehicle->id); ?>">
                                    <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

            </div>
            <?php if(count($vehicles) !== 0): ?>
                <hr>
            <?php endif; ?>
            <div class="page-area">
                <?php echo $vehicles->appends($_GET)->links(); ?>

            </div>
            <?php if(count($vehicles) === 0): ?>
                <div class="empty--data">
                    <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="<?php echo e(translate('public')); ?>">
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

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/provider/details/vehicle-list.blade.php ENDPATH**/ ?>