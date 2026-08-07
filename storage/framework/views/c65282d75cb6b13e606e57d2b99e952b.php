<?php $__env->startSection('title', translate('Trip Details')); ?>



<?php $__env->startSection($trip->trip_status); ?>
    active
<?php $__env->stopSection(); ?>


<?php $__env->startPush('css_or_js'); ?>
  <link rel="stylesheet" href="<?php echo e(asset('Modules/Rental/public/assets/css/admin/trip-details.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">
                        <span class="page-header-icon">
                            <img src="<?php echo e(asset('/public/assets/admin/img/car-logo.png')); ?>" class="w--20" alt="">
                        </span>
                        <span>
                            <?php echo e(translate('trips_details')); ?>

                        </span>
                    </h1>
                </div>
            </div>
        </div>
        <!-- Page Header -->

        <div class="row flex-xl-nowrap" id="printableArea">
            <div class="col-lg-8 order-print-area-left">
                <!-- Card -->
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header align-items-stretch flex-column border-0 pb-0">
                        <div class="d-flex align-items-start justify-content-between flex-wrap mb-2">
                            <div class="order-invoice-left d-flex d-sm-block justify-content-between">
                                <div>
                                    <h1 class="page-header-title d-flex align-items-center __gap-5px">
                                        <?php echo e(translate('Trip ID')); ?> # <?php echo e($trip->id); ?>

                                        <?php if($trip->edited): ?>
                                        <span class="badge badge--pending text-capitalize">
                                            <?php echo e(translate('messages.edited')); ?>

                                        </span>
                                        <?php endif; ?>
                                    </h1>
                                    <span class="mt-2 d-block d-flex align-items-center __gap-5px">
                                        <?php echo e(translate('Placed on')); ?> <?php echo e(\App\CentralLogics\Helpers::time_date_format($trip?->created_at)); ?>

                                        <?php if($trip->scheduled): ?>
                                        <br>
                                        <?php echo e(translate('Schedule At')); ?>  <?php echo e(\App\CentralLogics\Helpers::time_date_format($trip?->schedule_at)); ?>

                                        <?php endif; ?>
                                    </span>
                                    <div class="fs-14 text-title mt-2 pt-1 mb-2 d-flex align-items-center __gap-5px">
                                        <span><?php echo e(translate('Provider')); ?></span> <span>:</span>
                                        <span class="font-bold"><?php echo e($trip?->provider?->name); ?></span>
                                        <button type="button" class="btn btn--primary-light px-2 py-1 shadow-none"
                                                data-toggle="modal" data-target="#providerLocationModal">
                                            <i class="tio-poi"></i> <?php echo e(translate('View map')); ?>

                                        </button>
                                    </div>
                                    <div class="fs-14 text-title mt-2 pt-1 mb-2 d-flex align-items-center __gap-5px">
                                    <span><?php echo e(translate('Trip Type')); ?></span> <span>:</span>
                                        <span class="font-bold"><?php echo e(translate($trip->trip_type)); ?></span>
                                        <span>(<?php echo e($trip->scheduled ?  translate('messages.scheduled') : translate('messages.Instant')); ?>)</span>
                                    </div>
                                    <div class="fs-14 text-title mt-2 pt-1 mb-2 d-flex align-items-center __gap-5px">

                                        <?php if($trip->trip_type == 'hourly'): ?>
                                        <span><?php echo e(translate('Total ')); ?> <?php echo e(translate('Hour')); ?></span> <span>:</span>
                                        <span class="font-bold"><?php echo e($trip->estimated_hours); ?> <?php echo e(translate('hrs')); ?></span>
                                        <?php elseif($trip->trip_type == 'day_wise'): ?>
                                        <span><?php echo e(translate('Total ')); ?> <?php echo e(translate('Days')); ?></span> <span>:</span>
                                        <span class="font-bold"><?php echo e((int) (round($trip->estimated_hours/24))); ?> <?php echo e(translate('Days')); ?></span>
                                        <?php else: ?>
                                        <span><?php echo e(translate('Total ')); ?> <?php echo e(translate('KM')); ?></span> <span>:</span>
                                        <span class="font-bold"><?php echo e($trip->distance); ?> <?php echo e(translate('KM')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="d-sm-none">
                                    <a class="btn btn--primary print--btn font-regular d-flex align-items-center __gap-5px"
                                       href="<?php echo e(route('admin.rental.trip.generate-invoice',["id" => $trip->id])); ?>">
                                        <i class="tio-print mr-sm-1"></i>
                                        <span><?php echo e(translate('messages.print_invoice')); ?></span>
                                    </a>
                                </div>
                            </div>
                            <div class="order-invoice-right mt-3 mt-sm-0">
                                <div class="btn--container ml-auto align-items-center justify-content-end">


                                    <?php if($trip->trip_status == 'pending' && $is_deleted != 1): ?>
                                        <button class="btn btn--primary btn-outline-primary font-bold" type="button"
                                                data-toggle="modal" data-target="#editTripModal">
                                            <i class="tio-edit mr-sm-1"></i> <?php echo e(translate('Edit Trip')); ?>

                                        </button>
                                    <?php endif; ?>
                                    <a class="btn btn--primary print--btn py-2 px-3 font-bold d-none d-sm-block" href="<?php echo e(route('admin.rental.trip.generate-invoice',["id" => $trip->id])); ?>">
                                        <i class="tio-print mr-sm-1"></i> <span><?php echo e(translate('Print invoice')); ?></span>
                                    </a>
                                </div>
                                <div class="text-right mt-3 order-invoice-right-contents text-capitalize">
                                    <h6>

                                        <?php
                                        $statusClasses = [
                                            'pending' => 'badge--pending-1',
                                            'completed' => 'badge--accepted',
                                            'canceled' => 'badge--cancel',
                                            'ongoing' => 'badge--pending',
                                            'payment_failed' => 'badge--cancel',
                                        ];

                                        $badgeClass = $statusClasses[$trip->trip_status] ?? 'badge--accepted';
                                    ?>


                                        <span><?php echo e(translate('Trip Status')); ?></span> <span>:</span>
                                        <span class="<?php echo e($badgeClass); ?> badge  ml-2 ml-sm-3 text-capitalize">
                                            <?php echo e(translate($trip->trip_status)); ?>

                                        </span>
                                    </h6>
                                    <h6>
                                        <span><?php echo e(translate('Payment status')); ?></span> <span>:</span>
                                        <strong class="<?php echo e($trip->payment_status  == 'paid' ? 'text-success' :'text-danger'); ?>"><?php echo e(translate($trip->payment_status)); ?></strong>

                                    </h6>
                                    <?php if($trip->payment_method): ?>
                                    <h6>
                                        <span><?php echo e(translate('Payment method')); ?></span> <span>:</span>
                                        <span class="font-semibold"><?php echo e(translate($trip->payment_method ?? 'cash payment')); ?></span>
                                    </h6>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                        <?php if(!empty($trip->trip_note)): ?>
                            <div class="__bg-FAFAFA p-2 rounded">
                                <h6 class="fs-14 text-title">
                                    <?php echo e(translate('Note')); ?>:
                                    <span class="font-regular"><?php echo e($trip->trip_note); ?></span>
                                </h6>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body px-0">
                        <!-- item cart -->
                        <div class="table-responsive">
                            <table
                                class="table table-thead-bordered table-nowrap table-align-middle card-table dataTable no-footer mb-0">
                                <thead class="thead-light">
                                <tr>
                                    <th class="border-0">#</th>
                                    <th class="border-0"><?php echo e(translate('Vehicle Details')); ?></th>
                                    <th class="border-0"><?php echo e(translate('Unit Fair')); ?></th>
                                    <th class="border-0 text-center"><?php echo e(translate('Quantity')); ?></th>
                                    <th class="border-0 text-center"><?php echo e(translate('Total Hour/Km/Day')); ?></th>
                                    <th class="border-0 text-center"><?php echo e(translate('Fare')); ?></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                    $subtotal = 0;
                                ?>
                                <?php $__currentLoopData = $trip?->trip_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <div>
                                                <?php echo e($loop->iteration); ?>

                                            </div>
                                        </td>
                                        <td>
                                            <div class="media media--sm">
                                                <a class="avatar avatar-xl mr-3" href="<?php echo e(route('admin.rental.provider.vehicle.details', $detail->vehicle_id)); ?>">
                                                    <img class="img-fluid rounded aspect-ratio-1 onerror-image"
                                                         src="<?php echo e(data_get($detail?->vehicle,'thumbnailFullUrl',asset('public/assets/admin/img/160x160/img2.jpg') )); ?>"
                                                         data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                                                         alt="Image Description">
                                                </a>
                                                <div class="media-body">
                                                    <div class="fs-12 text--title">
                                                        <div class="fz-12 font-semibold line--limit-1">
                                                            <?php echo e($detail?->vehicle_details['name']); ?></div>
                                                            <?php if($detail?->vehicle): ?>

                                                            <div><span class="font-semibold mr-2"><?php echo e(translate('Category')); ?> :</span><?php echo e(Str::limit($detail?->vehicle?->category?->name, 15, '...')); ?></div>
                                                            <div><span class="font-semibold mr-2"><?php echo e(translate('Brand')); ?> :</span><?php echo e(Str::limit($detail?->vehicle?->brand?->name, 15, '...')); ?></div>
                                                            <?php else: ?>
                                                            <div><span class="text--danger mr-2"><?php echo e(translate('Vehicle_Not_Found_!!!')); ?> </span></div>

                                                            <?php endif; ?>

                                                    </div>
                                                </div>
                                            </div>
                                            <?php if($detail?->tripVehicleDetails->isEmpty()): ?>
                                                <?php if(!in_array($trip->trip_status, ['ongoing','pending', 'completed', 'canceled']) && $is_deleted != 1): ?>
                                                    <div class="mt-2">
                                                        <button
                                                            class="btn btn--primary btn-outline-primary p-5px rounded-20 d-flex align-items-center gap-1 assign-vehicle-btn"
                                                            type="button"
                                                            data-toggle="modal"
                                                            data-target="#assignVehicleModal"
                                                            data-details_id = "<?php echo e($detail->id); ?>"
                                                            data-trip_id = "<?php echo e($detail->trip_id); ?>"
                                                            data-vehicle_id = "<?php echo e($detail->vehicle_id); ?>"
                                                            data-quantity = "<?php echo e($detail->quantity); ?>"
                                                            data-img = "<?php echo e(data_get($detail?->vehicle,'thumbnailFullUrl',asset('public/assets/admin/img/160x160/img2.jpg') )); ?>"
                                                            data-name = "<?php echo e($detail?->vehicle_details['name']); ?>"
                                                            data-vendor = "<?php echo e($trip?->provider?->name); ?>"
                                                            data-category = "<?php echo e(Str::limit($detail?->vehicle?->category?->name, 15, '...')); ?>"
                                                            data-brand = "<?php echo e(Str::limit($detail?->vehicle?->brand?->name, 15, '...')); ?>"
                                                            data-list="<?php echo e(json_encode($detail?->vehicle?->vehicleIdentities)); ?>"
                                                            data-trip_vehicle_details="<?php echo e(json_encode($detail?->tripVehicleDetails)); ?>"
                                                        >
                                                            <?php echo e(translate('Assign Vehicle')); ?> <span class="fs-24"><i
                                                                    class="tio-add-circle"></i></span>
                                                        </button>
                                                    </div>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <div class="mt-2 bg--F6F6F6 p-2 radius-15 mb-4 d-inline-block">
                                                    <div class="d-flex justify-content-between gap-3 mb-10px text--title">
                                                        <span><?php echo e(translate('Assigned Vehicle')); ?></span>
                                                        <?php if(!in_array($trip->trip_status, ['ongoing','pending', 'completed', 'canceled'])): ?>
                                                            <button
                                                                class="btn btn--primary p-5px rounded-circle d-flex align-items-center justify-content-center assign-vehicle-btn"
                                                                type="button"
                                                                data-toggle="modal"
                                                                data-target="#assignVehicleModal"
                                                                data-details_id = "<?php echo e($detail->id); ?>"
                                                                data-trip_id = "<?php echo e($detail->trip_id); ?>"
                                                                data-vehicle_id = "<?php echo e($detail->vehicle_id); ?>"
                                                                data-quantity = "<?php echo e($detail->quantity); ?>"
                                                                data-img = "<?php echo e(data_get($detail?->vehicle,'thumbnailFullUrl',asset('public/assets/admin/img/160x160/img2.jpg') )); ?>"
                                                                data-name = "<?php echo e($detail?->vehicle_details['name']); ?>"
                                                                data-vendor = "<?php echo e($trip?->provider?->name); ?>"
                                                                data-category = "<?php echo e(Str::limit($detail?->vehicle?->category?->name, 15, '...')); ?>"
                                                                data-brand = "<?php echo e(Str::limit($detail?->vehicle?->brand?->name, 15, '...')); ?>"
                                                                data-list="<?php echo e(json_encode($detail?->vehicle?->vehicleIdentities)); ?>"
                                                                data-trip_vehicle_details="<?php echo e(json_encode($detail?->tripVehicleDetails)); ?>"
                                                            >
                                                                <i class="tio-edit fs-12"></i>
                                                            </button>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="text-wrap">
                                                        <?php
                                                            $licensePlates = $detail?->tripVehicleDetails->map(function($tripVehicleDetails) {
                                                                return $tripVehicleDetails?->vehicle_identity_data?->license_plate_number;
                                                            });
                                                            $licensePlatesString = $licensePlates->filter()->implode(', ');
                                                        ?>

                                                        <?php if($licensePlatesString): ?>
                                                            <?php echo e($licensePlatesString); ?>

                                                        <?php else: ?>
                                                        <?php echo e(translate('Not Found')); ?>

                                                        <?php endif; ?>

                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <?php
                                            if($detail->rental_type == 'hourly'){
                                                $getPrice=$detail->vehicle_details['hourly_price'];
                                                $getType=translate('Hr');
                                            }elseif ($detail->rental_type == 'day_wise') {
                                                $getPrice=$detail->vehicle_details['day_wise_price'];
                                                $getType=translate('Day');
                                            } else{
                                                $getPrice=$detail->vehicle_details['distance_price'];
                                                $getType=translate('KM');
                                            }
                                            ?>
                                            <div class="fs-14 text--title">
                                                <?php echo e(\App\CentralLogics\Helpers::format_currency($getPrice)); ?> /<?php echo e($getType); ?>

                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="fs-14  text--title font-bold">
                                                <?php echo e($detail->quantity); ?>

                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="fs-14 text--title">
                                                <?php if($trip->trip_type == 'hourly'): ?>
                                                <?php echo e($trip->estimated_hours); ?> <?php echo e(translate('hrs')); ?>

                                                <?php elseif($trip->trip_type == 'day_wise'): ?>
                                                <?php echo e((int) (round($trip->estimated_hours/24))); ?> <?php echo e(translate('days')); ?>

                                                <?php else: ?>
                                                <?php echo e($trip->distance); ?> <?php echo e(translate('KM')); ?>

                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="fs-14 text--title">
                                                <?php echo e(\App\CentralLogics\Helpers::format_currency($detail->calculated_price)); ?>

                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                        $subtotal += $detail->calculated_price;
                                    ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <!-- End Media -->
                                </tbody>
                            </table>
                        </div>
                        <div class="mx-3">
                            <hr>
                        </div>
                        <div class="row justify-content-md-end mb-3 mt-4 mx-0">
                            <div class="col-md-9 col-lg-8">
                                <dl class="row text-right text-title">
                                    <dt class="col-6 font-regular"><?php echo e(translate('Trip Fare')); ?></dt>
                                    <dd class="col-6">
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($subtotal)); ?></dd>

                                    <dt class="col-6"><?php echo e(translate('Subtotal')); ?>

                                        <?php if($trip->tax_status == 'included'): ?>
                                        (<?php echo e(translate('messages.TAX_Included')); ?>)
                                        <?php endif; ?>

                                    </dt>
                                    <dd class="col-6 font-semibold">
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($subtotal)); ?>

                                    </dd>
                                    <dt class="col-6 font-regular"><?php echo e(translate('discount')); ?></dt>
                                    <dd class="col-6">
                                        -<?php echo e(\App\CentralLogics\Helpers::format_currency($trip->discount_on_trip)); ?>

                                    </dd>

                                    <dt class="col-6 font-regular"><?php echo e(translate('Coupon discount')); ?></dt>
                                    <dd class="col-6">
                                        -<?php echo e(\App\CentralLogics\Helpers::format_currency($trip->coupon_discount_amount)); ?>

                                    </dd>

                                    <?php if($trip->ref_bonus_amount > 0): ?>
                                    <dt class="col-6 font-regular"><?php echo e(translate('Referral_Discount')); ?></dt>
                                    <dd class="col-6">
                                        -<?php echo e(\App\CentralLogics\Helpers::format_currency($trip->ref_bonus_amount)); ?>

                                    </dd>
                                    <?php endif; ?>


                                    <?php if($trip->tax_status == 'excluded' && $trip->tax_amount > 0): ?>
                                    <dt class="col-6 font-regular text-uppercase"><?php echo e(translate('Vat/tax')); ?></dt>
                                    <dd class="col-6 text-right">
                                        +<?php echo e(\App\CentralLogics\Helpers::format_currency($trip->tax_amount)); ?>

                                    </dd>
                                    <?php endif; ?>
                                    <dt class="col-6 font-regular "><?php echo e(\App\CentralLogics\Helpers::get_business_data('additional_charge_name')??\App\CentralLogics\Helpers::get_business_data('additional_charge_name')??translate('messages.additional_charge')); ?></dt>
                                    <dd class="col-6 text-right">
                                        + <?php echo e(\App\CentralLogics\Helpers::format_currency($trip->additional_charge)); ?></dd>

                                        <dt class="col-6 font-bold"><?php echo e(translate('Total')); ?></dt>
                                    <dd class="col-6 font-bold"><?php echo e(\App\CentralLogics\Helpers::format_currency($trip->trip_amount)); ?></dd>
                                </dl>
                                <!-- End Row -->
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
            <?php
                $tripDrivers = $trip?->vehicle_identity->whereNotNull('vehicle_driver_id');
                $tripVehicles = $trip?->vehicle_identity->whereNotNull('vehicle_identity_id')->count();
                $driverCount = $tripDrivers->count()
            ?>
            <div class="col-lg-4 order-print-area-right">
                <?php if($trip->trip_status != 'completed' || $trip->payment_status != 'paid' ): ?>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"><?php echo e(translate('trip_setup')); ?></h5>
                        </div>
                        <div class="card-body">
                            <?php if($trip->trip_status != 'completed'): ?>
                                <div class="hs-unfold w-100 mb-20">
                                    <label for="" class="font-semibold text-title"><?php echo e(translate('Trip Status')); ?></label>
                                    <div class="dropdown">
                                        <button
                                            class="form-control h--45px dropdown-toggle d-flex justify-content-between align-items-center w-100"
                                            type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <?php echo e(translate($trip->trip_status)); ?>

                                        </button>
                                        <div class="dropdown-menu text-capitalize" aria-labelledby="dropdownMenuButton">
                                            <?php
                                                $statuses = ['pending', 'confirmed', 'ongoing', 'completed', 'canceled'];
                                            ?>
                                            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($status !== strtolower($trip->trip_status)): ?>
                                                    <a class="dropdown-item route-alert"
                                                       data-url="<?php echo e(route('admin.rental.trip.status', ['id' => $trip['id'], 'status' => $status])); ?>"
                                                       data-message="Change status to <?php echo e($status); ?>?" href="javascript:">
                                                        <?php echo e(translate($status)); ?>

                                                    </a>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="hs-unfold w-100 mb-20">
                                <label for="" class="font-semibold text-title"><?php echo e(translate('Payment Status')); ?></label>
                                <div class="dropdown">
                                    <button
                                        class="form-control h--45px dropdown-toggle d-flex justify-content-between align-items-center w-100"
                                        type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?php echo e(ucfirst($trip->payment_status)); ?>

                                    </button>
                                    <div class="dropdown-menu text-capitalize" aria-labelledby="dropdownMenuButton">
                                        <?php
                                            $paymentStatuses = ['paid', 'unpaid'];
                                        ?>
                                        <?php $__currentLoopData = $paymentStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($status !== strtolower($trip->payment_status)): ?>
                                                <a class="dropdown-item route-alert"
                                                   data-url="<?php echo e(route('admin.rental.trip.payment.status', ['id' => $trip['id'], 'status' => $status])); ?>"
                                                   data-message="Change status to <?php echo e(ucfirst($status)); ?>?" href="javascript:">
                                                    <?php echo e(ucfirst($status)); ?>

                                                </a>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                            <?php if($driverCount <= 0 && $tripVehicles > 0): ?>
                                <button type="button"
                                        class="btn btn--primary w-100"
                                        data-toggle="modal" data-target="#assignDriverModal">
                                    <i class="tio-bike"></i>
                                    <span class="ml-2"><?php echo e(translate('Assign Driver')); ?></span>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if($driverCount > 0): ?>
                    <div class="card mt-2">
                        <div class="card-header">
                            <h5 class="mb-0"><?php echo e(translate('Driver List')); ?></h5>
                            <?php if(!in_array($trip->trip_status, ['pending', 'completed', 'canceled'])): ?>
                                <a href="#" class="btn action-btn btn--primary btn-outline-primary p-0 assign-driver-modal">
                                    <i class="tio-edit"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <button class="btn btn--reset font-medium w-100 d-flex justify-content-between align-items-center px-3 driverListCollapseBtn" type="button" data-toggle="collapse" data-target="#driverListCollapse" aria-expanded="false" aria-controls="driverListCollapse">
                                <?php echo e($driverCount); ?> <?php echo e(translate('driver Assigned')); ?> <i class="tio-down-ui fs-10"></i>
                            </button>

                            <div class="table-responsive collapse" id="driverListCollapse">
                                <table
                                    class="table table-nowrap table-align-middle card-table no-footer mb-0">
                                    <tbody>
                                    <?php $__currentLoopData = $tripDrivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driverDetails): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex gap-4 align-items-center">
                                                    <div><?php echo e($loop->iteration); ?></div>
                                                    <div class="fs-12 font-semibold text--title">
                                                        <div>
                                                            <span><?php echo e($driverDetails?->driver?->fullName); ?></span>
                                                            <span class="fs-10 opacity-70">(<?php echo e($driverDetails?->driver?->phone); ?>)</span>
                                                        </div>
                                                        <div class="opacity-60"><?php echo e(translate('Car No')); ?>: <?php echo e($driverDetails?->vehicle_identity_data?->license_plate_number); ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="card mt-2">
                    <div class="card-body">
                        <div class="position-relative">
                            <div class="map-fullscreen-btn_wrapper">
                                <button type="button" data-toggle="modal" data-target="#pickupDesModal"
                                        class="btn border-0 shadow--card-2">
                                    <i class="tio-fullscreen-1-1"></i>
                                </button>
                            </div>
                            <div class="location-map" id="pickup_location_map">
                                <div class="initial--25 rounded-8 custom_map_canvas" id="custom_route_line_map_canvas">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <ul class="trip-details-address text--title px-0 pt-2">
                            <li>
                                <span class="svg">
                                    <span class="text--title bg--F6F6F6 p-10px rounded"><i class="tio-poi"></i></span>
                                </span>
                                <span class="w-0 flex-grow-1">
                                    <span class="font-medium"><?php echo e(translate('Home')); ?>:</span>
                                    <span class="opacity-70"><?php echo e($trip->pickup_location['location_name']); ?></span>
                                </span>
                            </li>
                            <li>
                                <span class="svg">
                                    <span class="text--title bg--F6F6F6 p-10px rounded"><i
                                            class="tio-navigate-outlined rotate-45 d-inline-block"></i></span>
                                </span>
                                <span class="w-0 flex-grow-1 font-medium">
                                    <?php echo e($trip->destination_location['location_name']); ?>

                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card mt-2">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title mb-3 d-flex flex-wrap align-items-center">
                                <span><?php echo e(translate('messages.Customer_Info')); ?></span>
                            </h5>

                            <?php if($trip->is_guest == 1): ?>
                                <small class="badge-pill badge-soft-primary p-2 font-bold">
                                    <?php echo e(translate('Guest_user')); ?>

                                </small>
                            <?php endif; ?>
                        </div>


                        <?php if($trip->customer): ?>
                            <a class="media align-items-center deco-none customer--information-single" href="<?php echo e(route('admin.users.customer.rental.view', $trip->user_id)); ?>?module=1">
                                <div class="avatar avatar-circle">
                                    <img class="avatar-img onerror-image"
                                         data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
                                         src="<?php echo e($trip->customer['imageFullUrl']); ?>"
                                         alt="Image Description">
                                </div>
                                <div class="media-body">
                                    <span class="text--title fs-14 font-semibold d-block text-hover-primary mb-1"><?php echo e($trip->customer->fullName); ?></span>

                                    <div class="text--title d-flex align-items-center gap-1">
                                        <span>
                                            <span class="font-bold"><?php echo e($trip?->customer?->trips?->count()); ?></span>
                                            <?php echo e(translate('messages.trip')); ?>

                                        </span>
                                    </div>

                                    <div class="text--title">
                                        <?php echo e($trip?->customer?->phone); ?>

                                    </div>

                                    <div class="text--title">
                                        <?php echo e($trip?->customer?->email); ?>

                                    </div>

                                </div>
                            </a>
                            <?php elseif($trip?->user_info['contact_person_name']): ?>

                            <div class="media align-items-center deco-none customer--information-single" href="#">
                                <div class="avatar avatar-circle">
                                    <img class="avatar-img onerror-image"

                                        src="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
                                        alt="Image Description">
                                </div>
                                <div class="media-body">
                                    <span class="text--title fs-14 font-semibold d-block text-hover-primary mb-1"><?php echo e($trip?->user_info['contact_person_name']); ?></span>



                                    <div class="text--title">
                                        <?php echo e($trip?->user_info['contact_person_number']); ?>

                                    </div>

                                    <div class="text--title">
                                        <?php echo e($trip?->user_info['contact_person_email']); ?>

                                    </div>

                                </div>
                            </div>



                        <?php else: ?>
                            <div class="text--title">
                                <?php echo e(translate('messages.Guest_user')); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card mt-2">
                    <div class="card-body">
                        <h5 class="card-title mb-3 d-flex flex-wrap align-items-center">
                            <span><?php echo e(translate('messages.Provider_Info')); ?></span>
                        </h5>
                        <a class="media align-items-center deco-none resturant--information-single" href="<?php echo e(route('admin.rental.provider.details', $trip->provider_id)); ?>">
                            <div class="avatar avatar-circle">
                                <img class="avatar-img w-75px border-000-01 onerror-image"
                                     data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
                                     src="<?php echo e($trip?->provider?->logoFullUrl); ?>"
                                     alt="Image Description">
                            </div>
                            <div class="media-body">
                                <div class="text--title fs-14 font-semibold d-block text-hover-primary mb-1">
                                    <?php echo e($trip?->provider?->name); ?>

                                </div>

                                <div class="text--title">
                                    <span class="font-bold"><?php echo e($trip?->provider?->trips()?->where('trip_status' ,'completed')->count()); ?></span>
                                    <?php echo e(translate('messages.Trip_served')); ?>

                                </div>

                                <div class="text--title d-flex align-items-center">
                                    <?php echo e($trip?->provider?->email); ?>

                                </div>

                                <div class="text--title d-flex align-items-baseline">
                                    <i class="tio-poi mr-2"></i>
                                    <?php echo e($trip?->provider?->address); ?>

                                </div>

                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->
    </div>

    <!--Assign Driver Modal -->
    <div class="modal fade" id="assignDriverModal" tabindex="-1" role="dialog"
         aria-labelledby="assignDriverModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header p-2 pb-0 justify-content-end flex-shrink-0">
                    <button type="button" class="close p-0 m-0" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <form action="<?php echo e(route('admin.rental.trip.assign.driver')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="trip_id" value="<?php echo e($trip->id); ?>">
                    <div class="modal-body px-4 py-0">
                        <h5 class="font-bold"><?php echo e(translate('Assign Driver')); ?></h5>
                        <div class="fs-12 mb-20">
                        <span id="vehicle-assign-count">
                            <?php echo e(count($trip?->vehicle_identity?->filter(fn($v) => !$v->vehicle_driver_id))); ?>

                        </span>
                            <?php echo e(translate('Vehicle need to assign driver')); ?>

                        </div>
                        <div class="card shadow-none">
                            <div class="table-responsive">
                                <table
                                    class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table dataTable no-footer mb-0">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="border-0"><?php echo e(translate('Vehicle List')); ?></th>
                                        <th class="border-0"><?php echo e(translate('Selected Driver')); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $trip?->vehicle_identity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicleDetails): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <div class="media media--sm">
                                                    <a class="mr-3" href="#">
                                                        <img width="60" height="40" class="img--ratio-2 onerror-image rounded h--40px"
                                                             src="<?php echo e(data_get($vehicleDetails?->vehicles,'thumbnailFullUrl',asset('public/assets/admin/img/160x160/img2.jpg') )); ?>"
                                                             data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                                                             alt="Image Description">
                                                    </a>
                                                    <div class="media-body">
                                                        <div class="fs-12 text--title">
                                                            <div class="font-bold"><?php echo e(translate($vehicleDetails?->vehicles?->name)); ?></div>
                                                            <div class="font-semibold opacity-60"><?php echo e(translate('Car No')); ?>: <?php echo e($vehicleDetails?->vehicle_identity_data?->license_plate_number); ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column w-100">
                                                    <select name="driver_ids[<?php echo e($vehicleDetails->id); ?>]"
                                                            class="form-control js-select2-custom driver-select"
                                                            data-placeholder="<?php echo e(translate('messages.select_vehicle_driver')); ?>"
                                                            id="driver_<?php echo e($vehicleDetails->id); ?>">
                                                        <option value="" selected disabled>
                                                            <span class="fs-12 text--title"><?php echo e(translate('Select Vendors')); ?></span>
                                                        </option>
                                                        <?php $__currentLoopData = $trip?->provider?->vehicleDriver ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $providerDriver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($providerDriver->id); ?>"
                                                                    <?php echo e($vehicleDetails->vehicle_driver_id == $providerDriver->id ? 'selected' : ''); ?>

                                                                    data-driver-id="<?php echo e($providerDriver->id); ?>">
                                                                <span class="fs-12 text--title"><?php echo e($providerDriver?->fullName); ?></span>
                                                                <br>
                                                                <span class="fs-10 text--title opacity-70">(<?php echo e($providerDriver->phone); ?>)</span>
                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 flex-shrink-0 px-4">
                        <div class="btn--container justify-content-end">
                            <button type="reset" data-dismiss="modal" aria-label="Close"
                                    class="btn btn--warning-light min-w-120px"><?php echo e(translate('messages.cancel')); ?></button>
                            <button type="submit"
                                    class="btn btn--primary min-w-120px"><?php echo e(translate('messages.assign')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!--Assign Vehicle Modal -->
    <div class="modal fade" id="assignVehicleModal" tabindex="-1" role="dialog"
         aria-labelledby="assignVehicleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header p-2 pb-0 justify-content-end flex-shrink-0">
                    <button type="button" class="close p-0 m-0" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <form action="<?php echo e(route('admin.rental.trip.assign.vehicle')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body px-4 py-0">
                        <div class="media media--sm flex-wrap mb-20">
                            <a class="mr-3" href="#">
                                <img id="vehicleImage" width="160" class="img-fluid rounded aspect-2-1 onerror-image"
                                     src="<?php echo e(asset('public/assets/admin/img/car-demo.png')); ?>"
                                     data-onerror-image="<?php echo e(asset('public/assets/admin/img/car-demo.png')); ?>"
                                     alt="Image Description">
                            </a>
                            <div class="media-body">
                                <div class="text--title">
                                    <div class="fs-20 font-semibold line--limit-1" id="vehicleName"><?php echo e(translate('Vehicle Name')); ?></div>
                                    <div class="mb-2"><span class="font-semibold"> <?php echo e(translate('Vendor')); ?>:</span> <span id="vehicleVendor"><?php echo e(translate('Vehicle Name')); ?></span></div>
                                    <div class="d-flex flex-wrap gap-2 gap-sm-4">
                                        <div><span class="font-semibold"> <?php echo e(translate('Category')); ?>  :</span> <span id="vehicleCategory"> <?php echo e(translate('Category')); ?> </span></div>
                                        <div><span class="font-semibold"> <?php echo e(translate('Brand')); ?>  :</span> <span id="vehicleBrand"> <?php echo e(translate('Brand')); ?> </span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h5 class="font-bold"> <?php echo e(translate('Vehicles List')); ?><span class="fs-12 font-regular">(<?php echo e(translate('Select any of')); ?> <span id="vehicleQuantity"></span> <?php echo e(translate('vehicle')); ?>)</span></h5>
                        <div class="card shadow-none">
                            <div class="table-responsive">
                                <table
                                    class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table dataTable no-footer mb-0">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="border-0"> <?php echo e(translate('SL.')); ?></th>
                                        <th class="border-0"> <?php echo e(translate('VIN Number')); ?></th>
                                        <th class="border-0"> <?php echo e(translate('License Number')); ?></th>
                                        <th class="border-0 text-center"><?php echo e(translate('Action')); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 flex-shrink-0 px-4">
                        <div class="btn--container justify-content-end">
                            <button type="reset" id="reset_btn" data-dismiss="modal" aria-label="Close"
                                    class="btn btn--warning-light min-w-120px"><?php echo e(translate('messages.cancel')); ?></button>
                            <button type="submit"
                                    class="btn btn--primary min-w-120px"><?php echo e(translate('messages.add')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!--Show Provider location on map Modal -->
    <div class="modal fade" id="providerLocationModal" tabindex="-1" role="dialog"
         aria-labelledby="providerLocationModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pt-4 px-4">
                    <h4 class="modal-title" id="providerLocationModalLabel"><?php echo e(translate('messages.Trip ID #')); ?> <?php echo e($trip->id); ?>

                    </h4>
                    <button type="button" class="close p-0 m-0" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-12 modal_body_map">
                            <div class="location-map" id="location-map">
                                <div class="initial--25 rounded-8 custom_map_canvas" id="provider_map_canvas"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!--Show Pickup/Destinaton route on map Modal -->
    <div class="modal fade" id="pickupDesModal" tabindex="-1" role="dialog" aria-labelledby="pickupDesModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pt-4 px-4">
                    <h4 class="modal-title" id="pickupDesModalLabel"><?php echo e(translate('messages.Trip ID # ')); ?>  <?php echo e($trip->id); ?></h4>
                    <button type="button" class="close p-0 m-0" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-12 modal_body_map">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!--Show Edit trip Modal -->
    <div class="modal fade" id="editTripModal" tabindex="-1" role="dialog" aria-labelledby="editTripModalLabel">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content modal-scroll">
                <div class="modal-header pt-4 px-4 flex-shrink-0">
                    <h4 class="modal-title" id="editTripModalLabel"><?php echo e(translate('messages.Trip ID # ')); ?>  <?php echo e($trip->id); ?></h4>
                    <button type="button" class="close p-0 m-0" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <form action="" method="post" id="updateForm">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" id="pickup-lat" name="pickup_lat">
                    <input type="hidden" id="pickup-lng" name="pickup_lng">
                    <input type="hidden" id="destination-lat" name="destination_lat">
                    <input type="hidden" id="destination-lng" name="destination_lng">
                    <input type="hidden" id="distance-input" name="distance">
                    <input type="hidden" name="trip_id" value="<?php echo e($trip->id); ?>">


                    <div class="modal-body px-4 py-0">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group text-title">
                                    <label class="input-label font-semibold" for=""><?php echo e(translate('Pickup Location')); ?></label>
                                    <div class="position-relative w-100 d-flex align-items-center">
                                        <input type="text" name="pickup_location" id="pickup-input" class="form-control pr-2"
                                               placeholder="Enter your pickup location"
                                               value="<?php echo e($trip?->pickup_location['location_name']); ?>">
                                        <div class="input-icon fs-20 opacity-60">
                                            <i class="tio-poi"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group text-title">
                                    <label class="input-label font-semibold" for=""><?php echo e(translate('Destination')); ?></label>
                                    <div class="position-relative w-100 d-flex align-items-center">
                                        <input type="text" name="destination_location" id="destination-input" class="form-control pr-2"
                                               placeholder="Enter your destination location"
                                               value="<?php echo e($trip?->destination_location['location_name']); ?>">
                                        <div class="input-icon fs-20 opacity-60">
                                            <i class="tio-navigate-outlined rotate-45 d-block"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group text-title">
                                    <label class="input-label font-semibold" for=""><?php echo e(translate('Trip Type')); ?></label>
                                    <input type="text" class="form-control pr-2" name="trip_type" value="<?php echo e($trip->trip_type); ?>" hidden>
                                    <input type="text" class="form-control pr-2"  value="<?php echo e(translate($trip->trip_type)); ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group text-title">
                                    <label class="input-label font-semibold" for="trip-schedule"><?php echo e(translate('Trip Schedule')); ?></label>
                                    <div class="position-relative w-100 d-flex align-items-center">
                                        <input type="datetime-local" name="schedule_at" id="trip-schedule" readonly
                                               value="<?php echo e($trip->schedule_at); ?>" class="form-control pr-2 opacity-lg"
                                               placeholder="Enter your destination location">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card p-0">
                            <div class="card-body p-0 bg--F6F6F6">
                                <!-- item cart -->
                                <div class="table-responsive">
                                    <table
                                        class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table dataTable no-footer mb-0">
                                        <thead class="bg--EDEDED text--title">
                                        <tr>
                                            <th class="border-0">#</th>
                                            <th class="border-0"><?php echo e(translate('Vehicle Details')); ?></th>
                                            <th class="border-0"><?php echo e(translate('Unit Fair')); ?></th>
                                            <th class="border-0 text-center"><?php echo e(translate('Quantity')); ?></th>
                                            <th class="border-0 text-center"><?php echo e(translate('Total Hour/Km/Day')); ?></th>
                                            <th class="border-0 text-center"><?php echo e(translate('Fare')); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $subtotal = 0;
                                        ?>
                                        <?php $__currentLoopData = $trip?->trip_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $editDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                    <div class="eta_amount">
                                                        <?php echo e($loop->iteration); ?>

                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="media media--sm eta_amount">
                                                        <a class="avatar avatar-xl mr-3" href="<?php echo e(route('admin.rental.provider.vehicle.details', $editDetail->vehicle_id)); ?>">
                                                            <img class="img-fluid rounded aspect-ratio-1 onerror-image"
                                                                 src="<?php echo e(data_get($editDetail?->vehicle,'thumbnailFullUrl',asset('public/assets/admin/img/160x160/img2.jpg') )); ?>"
                                                                 data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                                                                 alt="Image Description">
                                                        </a>
                                                        <div class="media-body">
                                                            <div class="fs-12 text--title">
                                                                <div class="fz-12 font-semibold line--limit-1">
                                                                    <?php echo e($editDetail?->vehicle_details['name']); ?></div>
                                                                <div><span class="font-semibold mr-2"><?php echo e(translate('Category')); ?> :</span><?php echo e(Str::limit($editDetail?->vehicle?->category?->name, 15, '...')); ?>

                                                                </div>
                                                                <div><span class="font-semibold mr-2"><?php echo e(translate('Brand')); ?> :</span><?php echo e(Str::limit($editDetail?->vehicle?->brand?->name, 15, '...')); ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="fs-14 eta_amount text--title">
                                                             <?php
                                                            if($editDetail->rental_type == 'hourly'){
                                                                $getPrice=$editDetail->vehicle_details['hourly_price'];
                                                                $getType=translate('Hr');
                                                            }elseif ($editDetail->rental_type == 'day_wise') {
                                                                $getPrice=$editDetail->vehicle_details['day_wise_price'];
                                                                $getType=translate('Daily');
                                                            } else{
                                                                $getPrice=$editDetail->vehicle_details['distance_price'];
                                                                $getType=translate('KM');
                                                            }
                                                            ?>
                                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($getPrice)); ?>  /<?php echo e($getType); ?>

                                                    </div>
                                                </td>

                                                <td class="text-center">
                                                    <div class="d-flex flex-column gap-1 align-items-center">
                                                        <span class="eta_amount  d-none"> </span>
                                                        <input type="number" name="quantity" class="form-control fs-14 text--title w--60px quantity-input text-center" min="1" max="<?php echo e($editDetail->vehicle_variations_count); ?>"
                                                        data-max_quantity="<?php echo e($editDetail?->vehicle_variations_count); ?>"
                                                        data-max_original_quantity="<?php echo e($editDetail->quantity); ?>"
                                                        data-id="<?php echo e($editDetail->id); ?>" data-vehicle_id="<?php echo e($editDetail->vehicle_id); ?>"  value="<?php echo e($editDetail->quantity); ?>" placeholder="EX:5">
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <span class="eta_amount  d-none"> </span>
                                                        <?php if($trip->trip_type == 'hourly'): ?>
                                                        <span> <?php echo e($trip->estimated_hours); ?> <?php echo e(translate('hrs')); ?></span>
                                                        <?php elseif($trip->trip_type == 'day_wise'): ?>
                                                        <span> <?php echo e((int) (round($trip->estimated_hours/24))); ?> <?php echo e(translate('days')); ?></span>
                                                        <?php else: ?>
                                                        <span class="distance-input">  <?php echo e($trip->distance); ?> <?php echo e(translate('KM')); ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>

                                                <td class="text-center">
                                                    <div class="d-flex flex-column gap-1 align-items-center">
                                                        <span class="eta_amount_mt d-none "> <?php echo e(translate('*System_EST_Fare:')); ?>

                                                            <small id="est_<?php echo e($editDetail->id); ?>" class=" text--warning"> </small>
                                                        </span>
                                                        <input type="text" name="price" min="1" max="999999999"
                                                               data-price="<?php echo e($editDetail->price); ?>"
                                                               class="form-control w--120px text-center fs-14 text--title fare-total"
                                                               data-id="<?php echo e($editDetail->id); ?>"
                                                               data-vehicle_id="<?php echo e($editDetail->vehicle_id); ?>"
                                                               data-old-value="<?php echo e($editDetail->original_price  * $editDetail->quantity); ?>"
                                                               data-quantity="<?php echo e($editDetail->quantity); ?>"
                                                               value="<?php echo e(\App\CentralLogics\Helpers::format_currency($editDetail->calculated_price)); ?>"
                                                               placeholder="fare">
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                                $subtotal += $editDetail->calculated_price;
                                            ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <!-- End Media -->
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mx-3">
                                    <hr>
                                </div>
                                <div class="row justify-content-md-end mb-3 mt-4 mx-0">
                                    <div class="col-md-9 col-lg-8">
                                        <dl class="row text-right text-title">
                                            <dt class="col-6 font-regular"><?php echo e(translate('Trip Fare')); ?></dt>
                                            <dd class="col-6 total_fare">
                                                <?php echo e(\App\CentralLogics\Helpers::format_currency($subtotal)); ?>

                                            </dd>

                                            <dt class="col-6"><?php echo e(translate('Subtotal')); ?></dt>
                                            <dd class="col-6 font-semibold subtotal">
                                                <?php echo e(\App\CentralLogics\Helpers::format_currency($subtotal)); ?>

                                            </dd>

                                            <dt class="col-6 font-regular "><?php echo e(translate('discount')); ?></dt>
                                            <dd class="col-6 discount_amount">
                                                -<?php echo e(\App\CentralLogics\Helpers::format_currency($trip->discount_on_trip)); ?>

                                            </dd>

                                            <dt class="col-6 font-regular "><?php echo e(translate('Coupon discount')); ?></dt>
                                            <dd class="col-6 coupon_discount_amount">
                                                -<?php echo e(\App\CentralLogics\Helpers::format_currency($trip->coupon_discount_amount)); ?>

                                            </dd>


                                            <?php if($trip->ref_bonus_amount > 0): ?>
                                            <dt class="col-6 font-regular"><?php echo e(translate('Referral_Discount')); ?></dt>
                                            <dd class="col-6 ref_bonus_amount">
                                                -<?php echo e(\App\CentralLogics\Helpers::format_currency($trip->ref_bonus_amount)); ?>

                                            </dd>
                                            <?php endif; ?>

                                            <dt class="col-6 font-regular"><?php echo e(translate('Vat/Tax')); ?>

                                                <span id="tax_include_or_exclude"></span>
                                            </dt>

                                            <dd class="col-6 text-right tax_amount">
                                            + <?php echo e(\App\CentralLogics\Helpers::format_currency($trip->tax_amount)); ?>

                                            </dd>

                                            <dt class="col-6 font-regular "><?php echo e(\App\CentralLogics\Helpers::get_business_data('additional_charge_name')??\App\CentralLogics\Helpers::get_business_data('additional_charge_name')??translate('messages.additional_charge')); ?></dt>
                                            <dd class="col-6 text-right additional_charge">
                                                + <?php echo e(\App\CentralLogics\Helpers::format_currency($trip->additional_charge)); ?></dd>

                                            <dt class="col-6 font-bold"><?php echo e(translate('Total')); ?></dt>
                                            <dd class="col-6 font-bold grand-total"><?php echo e(\App\CentralLogics\Helpers::format_currency($trip->trip_amount)); ?></dd>
                                        </dl>
                                        <!-- End Row -->
                                    </div>
                                </div>
                                <!-- End Row -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 flex-shrink-0 px-4">
                        <div class="btn--container justify-content-end">

                            <button type="reset" id="reset_btn"  class="btn btn--warning-light min-w-120px close-modal"><?php echo e(translate('messages.cancel')); ?></button>
                            <button id="edit-trip" type="button"  class="btn btn--primary  min-w-120px"><?php echo e(translate('messages.update')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pt-4 px-4 flex-shrink-0">
                    <h4 class="modal-title"><?php echo e(translate('messages.Trip ID # ')); ?>  <?php echo e($trip->id); ?></h4>
                    <button type="button" class="close p-0 m-0" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body px-4 py-4">
                    <input id="search-input" type="text" class="form-control mb-3" placeholder="Search location...">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="currency_symbol" value="<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>">
    <input type="hidden" id="tax_included" value="<?php echo e(translate('(Included)')); ?>">
    <div id="max_quantity_msg" data-max-quantity-msg="<?php echo e(translate('Maximum available quantity is')); ?>"></div>
    <div id="get_calculation_url" data-url="<?php echo e(route('admin.rental.trip.get-calculation')); ?>"></div>

    <div id="provider_latitude" data-provider-latitude="<?php echo e($trip?->provider?->latitude ?? 0); ?>"></div>
    <div id="provider_longitude" data-provider-longitude="<?php echo e($trip?->provider?->longitude ?? 0); ?>"></div>
    <div id="provider_name" data-provider-name="<?php echo e(Str::limit($trip?->provider?->name ?? '', 15, '...')); ?>"></div>
    <div id="provider_address" data-provider-address="<?php echo e($trip?->provider?->address ?? ''); ?>"></div>
    <div id="provider_logo" data-provider-logo="<?php echo e($trip?->provider?->logo_full_url ?? asset('public/assets/admin/img/100x100/1.png')); ?>"></div>
    <div id="map-marker-image" data-map-marker-image="<?php echo e(asset('public/assets/admin/img/icons/pickup.svg')); ?>"></div>
    <div id="pickup-location-lat" data-pickup-location-lat="<?php echo e($trip->pickup_location['lat']); ?>"></div>
    <div id="pickup-location-lng" data-pickup-location-lng="<?php echo e($trip->pickup_location['lng']); ?>"></div>
    <div id="destination-location-lat" data-destination-location-lat="<?php echo e($trip->destination_location['lat']); ?>"></div>
    <div id="destination-location-lng" data-destination-location-lng="<?php echo e($trip->destination_location['lng']); ?>"></div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(\App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value); ?>&libraries=places&v=3.45.8"></script>
    <script src="<?php echo e(asset('Modules/Rental/public/assets/js/admin/view-pages/trip-details.js')); ?>"></script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/trip/details.blade.php ENDPATH**/ ?>