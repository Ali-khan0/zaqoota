<?php $__env->startSection('title', translate('messages.all_trips')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('Modules/Rental/public/assets/css/provider/trip-list.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between flex-wrap gap-3">
                <div>
                    <h1 class="page-header-title text-break">
                        <span class="page-header-icon">
                            <img src="<?php echo e(asset('public/assets/admin/img/zone.png')); ?>" class="w--22" alt="">
                        </span>
                        <span><?php echo e(translate('messages.All_Trips')); ?>

                            <span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($total); ?></span>
                        </span>
                    </h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header justify-content-between gap-3 py-2 flex-wrap">
                <form action="" method="get" class="search-form flex-grow-1 max-w-450px">
                    <!-- Search -->
                    <input type="hidden" value="<?php echo e(request()?->status); ?>" name="status" >
                    <div class="input-group input--group">
                        <input id="datatableSearch_" type="search" value="<?php echo e(request()?->search ?? null); ?>"
                               name="search" class="form-control"
                               placeholder="<?php echo e(translate('Search by trip ID, customer name, email')); ?>"
                               aria-label="<?php echo e(translate('messages.Search by trip ID, customer name, email')); ?>">
                        <button type="submit" class="btn btn--secondary bg--primary"><i class="tio-search"></i></button>
                    </div>
                    <!-- End Search -->
                </form>
                <?php if(request()->get('search')): ?>
                    <button type="reset" class="btn btn--primary ml-2 location-reload-to-base"
                            data-url="<?php echo e(url()->full()); ?>"><?php echo e(translate('messages.reset')); ?></button>
                <?php endif; ?>
                <div class="search--button-wrapper justify-content-end gap-20px">
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
                               href="<?php echo e(route('vendor.trip.export', ['type' => 'excel', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                     src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                     alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item"
                               href="<?php echo e(route('vendor.trip.export', ['type' => 'csv', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                     src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                     alt="Image Description">
                                .<?php echo e(translate('messages.csv')); ?>

                            </a>

                        </div>
                    </div>
                    <!-- End Unfold -->

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
                        <th class="border-0"><?php echo e(translate('messages.Driver_Info')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.Vehicle_Info')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.Trip_Type')); ?></th>
                        <th class="text-end border-0"><?php echo e(translate('messages.Trip_Amount')); ?></th>
                        <th class="text-center border-0"><?php echo e(translate('messages.Trip_Status')); ?></th>
                        <th class="text-center border-0"><?php echo e(translate('messages.Action')); ?></th>
                    </tr>
                    </thead>

                    <tbody id="set-rows">
                    <?php $__currentLoopData = $trips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($key+$trips->firstItem()); ?></td>
                        <td class="text--title font-semibold">
                            <a href="<?php echo e(route('vendor.trip.details', $trip->id)); ?>"><?php echo e($trip->id); ?></a>
                        </td>
                        <td>
                            <div class="text--title">
                                <?php echo e(\App\CentralLogics\Helpers::date_format($trip?->created_at)); ?>

                                <br>
                                <?php echo e(\App\CentralLogics\Helpers::time_format($trip?->created_at)); ?>

                            </div>
                        </td>
                        <td>
                            <div class="text--title">
                                <?php echo e(\App\CentralLogics\Helpers::date_format($trip?->schedule_at)); ?>

                                <br>
                                <?php echo e(\App\CentralLogics\Helpers::time_format($trip?->schedule_at)); ?>

                            </div>
                        </td>
                        <td>
                            <div class="text--title">
                                <?php if($trip->customer): ?>
                                    <div class="font-medium">
                                        <?php echo e($trip->customer->fullName); ?>

                                    </div>
                                    <div class="opacity-lg">
                                        <?php echo e($trip->customer->email); ?>

                                    </div>
                                <?php elseif($trip?->user_info['contact_person_name']): ?>
                                    <div class="font-medium">
                                        <?php echo e($trip?->user_info['contact_person_name']); ?>

                                    </div>
                                    <div class="opacity-lg">
                                        <?php echo e($trip?->user_info['contact_person_email']); ?>

                                    </div>
                                <?php else: ?>
                                    <?php echo e(translate('messages.Guest_user')); ?>

                                <?php endif; ?>
                            </div>
                        </td>

                        <?php
                            $maxDisplay = 3;
                            $totalVehicle = count($trip->assignedVehicle);
                            $totalDriver = count($trip->assignedDriver);
                            $totalTripe = count($trip->trip_details);
                        ?>
                        <td>
                            <?php if($totalDriver): ?>
                                <?php if($totalDriver > 1): ?>
                                    <div class="d-flex align-items-center gap-2" data-html="true" data-toggle="tooltip"
                                         title="<div class='d-flex flex-column p-2'>
                                             <?php $__currentLoopData = $trip->assignedDriver; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $tooltipDriver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class='media gap-3 <?php echo e(!$loop->last ? 'border-bottom mb-2 pb-2' : ''); ?>'>
                                                    <img height='40' src='<?php echo e($tooltipDriver->driver['imageFullUrl']); ?>'  class='rounded ratio-1-1' width='40' alt='...'>
                                                    <div class='media-body'>
                                                        <h5 class='d-flex align-items-center gap-2 text-white mb-0'>
                                                            <a href='<?php echo e(route('vendor.driver.details', $tooltipDriver->driver->id)); ?>' class='text-white'><?php echo e(Str::limit($tooltipDriver->driver['fullName'],12,'...')); ?></a>
                                                        </h5>
                                                        <div class='d-flex align-items-center gap-2 fs-10'><?php echo e(Str::limit( $tooltipDriver->driver->email,12,'...')); ?></div>
                                                    </div>
                                                </div>
                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                         </div>">
                                        <div class="d-flex">
                                            <?php $__currentLoopData = $trip->assignedDriver->take($maxDisplay); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $assignedDriver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <img width="35"  class="rounded-circle aspect-1-1 border border-white shadow-sm <?php echo e($key > 0 ? 'ml-n2' : ''); ?>" src="<?php echo e($assignedDriver->driver['imageFullUrl']); ?>" alt="">
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <?php if($totalDriver > $maxDisplay): ?>
                                            <span>+<?php echo e($totalDriver - $maxDisplay); ?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="text--title">
                                        <?php if($trip->assignedDriver->isNotEmpty()): ?>
                                            <a href="<?php echo e(route('vendor.driver.details', $trip->assignedDriver->first()?->driver?->id)); ?>" class="font-medium">
                                                <?php echo e(Str::limit($trip->assignedDriver->first()?->driver?->fullName,12,'...')); ?>

                                            </a>
                                            <div class="opacity-lg">
                                                <?php echo e(Str::limit($trip->assignedDriver->first()?->driver?->email,12,'...' )); ?>

                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="text-muted fs-12 mt-1">
                                    <?php echo e(translate('messages.Unassigned')); ?>

                                </div>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php if($totalVehicle > 0): ?>
                                <div class="text-primary text-underline font-weight-medium" data-html="true" data-toggle="tooltip"
                                     title="<div class='d-flex flex-column p-2'>
                                         <?php $__currentLoopData = $trip->trip_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                             <?php if($detail?->vehicle): ?>
                                                 <div class='media gap-3 <?php echo e(!$loop->last ? 'border-bottom mb-2 pb-2' : ''); ?>'>
                                                     <img src='<?php echo e(data_get($detail?->vehicle,'thumbnailFullUrl',asset('public/assets/admin/img/160x160/img2.jpg') )); ?>' class='rounded ratio-1-1' width='40' alt='...'>
                                                     <div class='media-body'>
                                                         <h5 class='d-flex align-items-center gap-2 text-white mb-0'>
                                                            <a href='<?php echo e(route('vendor.vehicle.details', $detail->vehicle_id)); ?>' class='text-white'><?php echo e(Str::limit($detail->vehicle_details['name'],12,'...')); ?></a>
                                                         </h5>
                                                         <div class='d-flex align-items-center gap-2 fs-10'><?php echo e(translate('messages.car_Assigned')); ?>: <?php echo e($detail->tripVehicleDetails->count()); ?></div>
                                                     </div>
                                                 </div>
                                             <?php else: ?>
                                                 <div class='media gap-3 <?php echo e(!$loop->last ? 'border-bottom mb-2 pb-2' : ''); ?>'>
                                                     <img src='<?php echo e(data_get($detail?->vehicle,'thumbnailFullUrl',asset('public/assets/admin/img/160x160/img2.jpg') )); ?>' class='rounded ratio-1-1' width='40' alt='...'>
                                                     <div class='media-body'>
                                                         <h5 class='d-flex align-items-center gap-2 text-white mb-0'>
                                                            <span class='text-white'><?php echo e(Str::limit($detail->vehicle_details['name'],12,'...')); ?></span>
                                                        </h5>
                                                         <div class='d-flex align-items-center text-danger gap-2 fs-10'><?php echo e(translate('Vehicle_Not_Found_!!!')); ?></div>
                                                     </div>
                                                 </div>
                                             <?php endif; ?>
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
                                    <?php echo e(translate($trip->trip_type)); ?>

                                </div>
                                <div class="opacity-lg">
                                    <?php echo e($trip->scheduled ?translate('messages.scheduled'): translate('messages.Instant')); ?>

                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="text--title text-end">
                                <div class="font-semobold">
                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($trip->trip_amount)); ?>

                                </div>
                                <div class="opacity-lg font-medium <?php echo e($trip->payment_status  == 'paid' ? 'text--success' : 'text--danger'); ?> ">
                                    <?php echo e(translate($trip->payment_status)); ?>

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

                                $badgeClass = $statusClasses[$trip->trip_status] ?? 'badge-soft-info';
                            ?>
                            <label class="badge <?php echo e($badgeClass); ?> border-0">
                                <?php echo e(translate($trip->trip_status)); ?>

                            </label>
                            </div>
                        </td>
                        <td>
                            <div class="btn--container justify-content-center">
                                <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route("vendor.trip.generate-invoice",["id" => $trip->id])); ?>"
                                   title="<?php echo e(translate('messages.download')); ?>"><i class="tio-download-to"></i>
                                </a>
                                <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route('vendor.trip.details', $trip->id)); ?>"
                                   title="<?php echo e(translate('messages.view')); ?>"><i class="tio-visible-outlined"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

            </div>
            <?php if(count($trips) !== 0): ?>
                <hr>
            <?php endif; ?>
            <div class="page-area">
                <?php echo $trips->appends($_GET)->links(); ?>

            </div>
            <?php if(count($trips) === 0): ?>
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

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/provider/trip/list.blade.php ENDPATH**/ ?>