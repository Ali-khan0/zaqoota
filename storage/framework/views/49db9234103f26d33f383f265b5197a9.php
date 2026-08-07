<?php $__env->startSection('title', translate('messages.Driver_Details')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between flex-wrap gap-3">
                <div>
                    <h1 class="page-header-title text-break">
                        <span class="page-header-icon">
                            <img src="<?php echo e(asset('public/assets/admin/img/car-logo.png')); ?>" alt="">
                        </span>
                        <span><?php echo e(translate('messages.Driver_Details')); ?>

                    </h1>
                </div>
                <div class="d-flex align-items-start flex-wrap gap-2">
                    <a class="btn btn--cancel h--45px d-flex gap-2 align-items-center form-alert" href="javascript:"
                       data-id="brand-<?php echo e($driver['id']); ?>" data-message="<?php echo e(translate('Want to delete this driver')); ?>" title="<?php echo e(translate('messages.delete_driver')); ?>">
                        <i class="tio-delete-outlined"></i>
                        <?php echo e(translate('messages.delete')); ?>

                    </a>
                    <form action="<?php echo e(route('vendor.driver.delete',[$driver['id']])); ?>?driver_list=true" method="post" id="brand-<?php echo e($driver['id']); ?>">
                        <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                    </form>
                    <a href="javascript:" class="btn btn--reset d-flex justify-content-between align-items-center gap-4 lh--1 h--45px">
                        <?php echo e(translate('messages.status')); ?>

                        <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox<?php echo e($driver->id); ?>">
                            <input type="checkbox" data-url="<?php echo e(route('vendor.driver.status',[$driver['id'],$driver->status?0:1])); ?>" class="toggle-switch-input redirect-url" id="stocksCheckbox<?php echo e($driver->id); ?>" <?php echo e($driver->status?'checked':''); ?>>
                            <span class="toggle-switch-label mx-auto">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                        </label>
                    </a>
                    <a href="<?php echo e(route('vendor.driver.edit', $driver->id)); ?>" class="btn btn--primary h--45px d-flex gap-2 align-items-center">
                        <i class="tio-edit"></i>
                        <?php echo e(translate('messages.Edit_Driver')); ?>

                    </a>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Card -->
        <div class="card mb-20">
            <div class="card-body p-4">
                <div class="card border p-3 p-sm-4 shadow-none mb-3">
                    <div class="media align-items-sm-center flex-column flex-sm-row">
                        <div class="mb-3 mb-sm-0">
                            <img height="115" class="aspect-ratio-1 w-auto rounded mr-4 onerror-image"
                                src="<?php echo e($driver['image_full_url']); ?>" alt="">
                        </div>
                        <div class="media-body text--title d-flex justify-content-around flex-column flex-lg-row gap-3">
                            <div class="mr-0 mr-lg-4">
                                <h3 class="fs-20 mb-0"><?php echo e($driver?->fullName); ?></h3>
                                <div class="d-flex gap-3">
                                    <span class="min-w-110px"><?php echo e(translate('Phone')); ?></span>
                                    <span>: <?php echo e($driver->phone); ?></span>
                                </div>
                                <div class="d-flex gap-3">
                                    <span class="min-w-110px"><?php echo e(translate('Email')); ?></span>
                                    <span>: <?php echo e($driver->email); ?></span>
                                </div>
                            </div>

                            <div class="mr-0 mr-lg-4">
                                <h5 class=""><?php echo e(translate('Identity Information')); ?></h5>
                                <div class="d-flex gap-3">
                                    <span class="min-w-110px"><?php echo e(translate('Identity Type')); ?></span>
                                    <span>: <?php echo e(translate($driver->identity_type)); ?></span>
                                </div>
                                <div class="d-flex gap-3">
                                    <span class="min-w-110px"><?php echo e(translate('Identity Number')); ?></span>
                                    <span>: <?php echo e($driver->identity_number); ?></span>
                                </div>
                            </div>
                            <div class="mr-0 mr-lg-4">
                                <h5 class=""><?php echo e(translate('Provider Info')); ?></h5>
                                <div class="align-items-center d-flex gap-2 resturant--information-single text-left">
                                    <img height="45" class="aspect-ratio-1 onerror-image rounded"
                                        src="<?php echo e($driver?->provider?->logo_full_url); ?>"
                                        alt="<?php echo e(translate('Image Description')); ?>">
                                    <div class="text--title">

                                            <h5 class="text-capitalize font-semibold text-hover-primary d-block mb-1">
                                                <?php echo e($driver?->provider?->name); ?>

                                                <span class="btn btn--warning fs-12 rounded-20 text-white py-1 px-2 ml-1">
                                                    <i
                                                        class="tio-star mr-1"></i><?php echo e(number_format($driver?->provider?->vehicle_reviews->avg('rating'), 1) ?? 0.0); ?>

                                                </span>
                                            </h5>

                                        <span class="opacity-lg">
                                            <?php echo e($driver?->provider?->phone); ?>

                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <?php if(count($driver['identity_image_full_url']) > 0): ?>

                        <h5 class="text--title mb-20"><?php echo e(translate('Identity Image')); ?></h5>
                        <div class="d-flex gap-4 flex-wrap">
                            <?php $__currentLoopData = $driver['identity_image_full_url']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div>
                                    <img width="275" data-toggle="modal" data-target="#imagemodal<?php echo e($key); ?>"
                                        class="aspect-2-1 object--cover rounded-10" src="<?php echo e($img); ?>"
                                        alt="Identity image">
                                </div>

                                <div class="modal fade" id="imagemodal<?php echo e($key); ?>" tabindex="-1" role="dialog"
                                    aria-labelledby="order_proof_<?php echo e($key); ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="order_proof_<?php echo e($key); ?>">
                                                    <?php echo e(translate('Identity Image')); ?></h4>
                                                <button type="button" class="close" data-dismiss="modal"><span
                                                        aria-hidden="true">&times;</span><span
                                                        class="sr-only"><?php echo e(translate('messages.cancel')); ?></span></button>
                                            </div>
                                            <div class="modal-body scroll-down">
                                                <img src="<?php echo e($img); ?>" class="initial--22 w-100">
                                            </div>

                                            <div class="modal-footer">
                                                <a href="<?php echo e($img); ?>" download class="btn btn-primary"
                                                    class="download-icon mt-3">
                                                    <img src="<?php echo e(asset('/public/assets/admin/new-img/download-icon.svg')); ?>"
                                                        alt="">
                                                    <?php echo e(translate('messages.download')); ?>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- End Card -->

        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header py-2">
                <div class="search--button-wrapper gap-20px">
                    <h5 class="card-title text--title flex-grow-1"><?php echo e(translate('messages.Total_Trips')); ?>

                        <span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($driverTrips->count()); ?></span>


                    </h5>
                    <form class="search-form flex-grow-1 max-w-353px">
                        <!-- Search -->
                        <div class="input-group input--group">
                            <input id="datatableSearch_" type="search" value="<?php echo e(request()?->search ?? null); ?>"
                                   name="search" class="form-control"
                                   placeholder="<?php echo e(translate('Search by trip ID')); ?>"
                                   aria-label="<?php echo e(translate('messages.Search by trip ID...')); ?>">
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
                               href="<?php echo e(route('vendor.driver.trip.export', ['id' => request()->id,'type' => 'excel', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                     src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                     alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item"
                               href="<?php echo e(route('vendor.driver.trip.export', ['id' => request()->id, 'type' => 'csv', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                     src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                     alt="Image Description">
                                .<?php echo e(translate('messages.csv')); ?>

                            </a>

                        </div>
                    </div>
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
                        <th class="border-0"><?php echo e(translate('messages.Trip ID')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.Booking_Date')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.Schedule_At')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.Customer_Info')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.Vehicle_Info')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.Trip_Type')); ?></th>
                        <th class="text-center border-0"><?php echo e(translate('messages.Trip_Status')); ?></th>
                        <th class="text-center border-0"><?php echo e(translate('messages.Action')); ?></th>
                    </tr>
                    </thead>

                    <tbody id="set-rows">
                    <?php $__currentLoopData = $driverTrips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $driverTrip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+$driverTrips->firstItem()); ?></td>
                            <td>
                                <div class="text--title font-semibold">
                                    <?php echo e($driverTrip?->trip?->id); ?>

                                </div>
                            </td>
                            <td>
                                <div class="text--title">
                                    <?php echo e(\App\CentralLogics\Helpers::date_format($driverTrip?->trip?->created_at)); ?>

                                    <br>
                                    <?php echo e(\App\CentralLogics\Helpers::time_format($driverTrip?->trip?->created_at)); ?>

                                </div>
                            </td>
                            <td>
                                <div class="text--title">
                                    <?php echo e(\App\CentralLogics\Helpers::date_format($driverTrip?->trip?->schedule_at)); ?>

                                    <br>
                                    <?php echo e(\App\CentralLogics\Helpers::time_format($driverTrip?->trip?->schedule_at)); ?>

                                </div>
                            </td>
                            <td>
                                <div class="text--title">
                                    <?php if($driverTrip?->trip?->customer): ?>
                                        <div class="font-medium">
                                            <?php echo e($driverTrip?->trip?->customer?->fullName); ?>

                                        </div>
                                        <div class="opacity-lg">
                                            <?php echo e($driverTrip?->trip?->customer?->email); ?>

                                        </div>

                                    <?php elseif($driverTrip?->trip?->user_info['contact_person_name']): ?>
                                        <div class="font-medium">
                                            <?php echo e($driverTrip?->trip?->user_info['contact_person_name']); ?>

                                        </div>
                                        <div class="opacity-lg">
                                            <?php echo e($driverTrip?->trip?->user_info['contact_person_email']); ?>

                                        </div>
                                    <?php else: ?>
                                        <?php echo e(translate('messages.Guest_user')); ?>

                                    <?php endif; ?>
                                </div>
                            </td>
                            <?php
                                $maxDisplay = 3;
                                $totalVehicle = count($driverTrip?->trip?->assignedVehicle);
                            ?>
                            <td>
                                <?php if($totalVehicle > 0): ?>
                                    <div class="text-primary text-underline font-weight-medium" data-html="true" data-toggle="tooltip"
                                         title="<div class='d-flex flex-column p-2'>
                                         <?php $__currentLoopData = $driverTrip?->trip?->trip_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class='media gap-3 <?php echo e(!$loop->last ? 'border-bottom mb-2 pb-2' : ''); ?>'>
                                                <img src='<?php echo e($detail->vehicle?->thumbnailFullUrl); ?>' class='rounded ratio-1-1' width='40' alt='...'>
                                                <div class='media-body'>
                                                    <h5 class='d-flex align-items-center gap-2 text-white mb-0'><?php echo e($detail->vehicle_details['name']); ?></h5>
                                                    <div class='d-flex align-items-center gap-2 fs-10'><?php echo e(translate('messages.car_Assigned')); ?>: <?php echo e($detail->tripVehicleDetails->count()); ?></div>
                                                </div>
                                            </div>
                                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>">
                                        <?php echo e($totalVehicle); ?> <?php echo e(translate('messages.vehicles')); ?>

                                    </div>
                                <?php else: ?>
                                    <div class="text--warning font-medium">
                                        <?php echo e(translate('messages.Unassigned')); ?>

                                    </div>
                                <?php endif; ?>

                            </td>
                            <td>
                                <div class="text--title">
                                    <div class="font-medium">
                                        <?php echo e(translate($driverTrip?->trip?->trip_type)); ?>

                                    </div>
                                    <div class="opacity-lg">
                                        <?php echo e($driverTrip?->trip?->scheduled ? translate('messages.scheduled'): translate('messages.Instant')); ?>

                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">

                                    <?php
                                    $statusClasses = [
                                        'pending' => 'badge-soft-info',
                                        'completed' => 'badge-soft-success',
                                        'canceled' => 'badge-soft-danger',
                                        'ongoing' => 'badge-soft-warning',
                                        'payment_failed' => 'badge-soft-danger',
                                    ];

                                    $badgeClass = $statusClasses[$driverTrip?->trip?->trip_status] ?? 'badge-soft-info';
                                ?>
                                <label class="badge <?php echo e($badgeClass); ?> border-0">
                                    <?php echo e(translate($driverTrip?->trip?->trip_status)); ?>

                                </label>


                                </div>
                            </td>
                            <td>
                                <div class="btn--container justify-content-center">
                                    <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route("vendor.trip.generate-invoice",["id" => $driverTrip?->trip?->id])); ?>"
                                       title="<?php echo e(translate('messages.download')); ?>"><i class="tio-download-to"></i>
                                    </a>
                                    <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route('vendor.trip.details', $driverTrip?->trip?->id)); ?>"
                                       title="<?php echo e(translate('messages.view')); ?>"><i class="tio-visible-outlined"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

            </div>
            <?php if(count($driverTrips) !== 0): ?>
                <hr>
            <?php endif; ?>
            <div class="page-area">
                <?php echo $driverTrips->appends($_GET)->links(); ?>

            </div>
            <?php if(count($driverTrips) === 0): ?>
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

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/provider/driver/details.blade.php ENDPATH**/ ?>