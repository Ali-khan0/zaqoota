<div class="content container-fluid invoice-page initial-38">
    <div id="printableArea">
        <div>
            <div class="text-center">
                <input type="button" class="btn btn-primary mt-3 non-printable print-Div"
                       value="<?php echo e(translate('Proceed,_If_thermal_printer_is_ready.')); ?>" />
                <a href="<?php echo e(url()->previous()); ?>"
                   class="btn btn-danger non-printable mt-3"><?php echo e(translate('messages.back')); ?></a>
            </div>

            <hr class="non-printable">

            <div class="print--invoice initial-38-1">
                <?php if($trip?->provider): ?>
                    <div class="text-center pt-4 mb-3">
                        <img class="invoice-logo" src="<?php echo e(asset('/public/assets/admin/img/car_icon.svg')); ?>"
                             alt="">
                        <div class="top-info">
                            <h2 class="store-name">
                                 <?php echo e($trip?->provider?->name); ?>

                            </h2>
                            <div>
                                <img src="<?php echo e(asset('/public/assets/admin/img/location_icon.svg')); ?>" alt="">
                                <?php echo e($trip?->provider?->address); ?>

                            </div>
                            <div class="mt-1 d-flex justify-content-center">
                                <span><img src="<?php echo e(asset('/public/assets/admin/img/phone_icon.svg')); ?>" alt=""></span>&nbsp;
                                <span><?php echo e($trip?->provider?->phone); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="img-wrap">
                    <div class="top-info">

                        <img src="<?php echo e(asset('/public/assets/admin/img/line_icon.svg')); ?>" alt="" class="w-100">
                    </div>
                    <div class="order-info-id text-center">
                        <div class="d-flex justify-content-center mb-2 fs-12">
                            <span class="fw-medium"><?php echo e(translate('trip_Id')); ?></span>
                            <span>:</span>
                            <span class="fw-medium"><?php echo e($trip?->id); ?></span>
                        </div>
                        <div>
                            <?php echo e(\App\CentralLogics\Helpers::time_date_format($trip?->schedule_at)); ?>

                        </div>
                        <div>
                            <?php if($trip->provider?->gst_status): ?>
                                <span><?php echo e(translate('Gst No')); ?></span> <span>:</span> <span><?php echo e($trip?->provider?->gst_code); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="order-info-details">
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="mb-1">
                                    <span class="opacity-70"><?php echo e(translate('messages.customer_name')); ?></span> <span>:</span>
                                    <span><?php echo e($trip?->customer ? $trip?->customer?->fullName : $trip?->user_info['contact_person_name']); ?></span>
                                </div>
                                <div class="mb-1">
                                    <span class="opacity-70"><?php echo e(translate('messages.phone')); ?></span> <span>:</span>
                                    <span><?php echo e($trip?->customer ? $trip?->customer?->phone : $trip?->user_info['contact_person_number']); ?></span>
                                </div>
                                <div class="text-break mb-1">
                                    <span class="opacity-70"><?php echo e(translate('messages.pickup_location')); ?></span> <span>:</span>
                                    <span><?php echo e($trip?->pickup_location['location_name']); ?></span>
                                </div>
                                <div class="text-break mb-1">
                                    <span class="opacity-70"><?php echo e(translate('messages.destination_location')); ?></span> <span>:</span>
                                    <span><?php echo e($trip?->destination_location['location_name']); ?></span>
                                </div>
                            </div>
                        </div>

                        <div><img src="<?php echo e(asset('/public/assets/admin/img/line_icon.svg')); ?>" alt="" class="w-100"></div>

                        <div>
                            <table class="table invoice--table text-black mb-1">
                                <thead class="border-0">
                                <tr class="border-0">
                                    <th><?php echo e(translate('messages.Vehicle_List')); ?></th>
                                    <th class="w-10p"></th>
                                    <th><?php echo e(translate('messages.price')); ?></th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php ($sub_total = 0); ?>
                                <?php ($total_tax = 0); ?>
                                <?php ($total_dis_on_pro = 0); ?>
                                <?php $__currentLoopData = $trip->trip_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <div><?php echo e($loop->iteration); ?>.</div>
                                                <div class="opacity-70">
                                                    <strong class="d-block mb-1"><?php echo e($details?->vehicle_details['name']); ?></strong>
                                                    <span class="fs-9">
                                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($details['price'])); ?>/<?php echo e(translate($details?->rental_type)); ?>,
                                                        <?php echo e($details->quantity); ?> <?php echo e(translate('Vehicle')); ?>,
                                                        <?php
                                                           if( $details->rental_type == 'hourly'){
                                                            $getTime= $details->estimated_hours .' Hours';
                                                        } elseif( $details->rental_type == 'day_wise'){
                                                            $getTime=( (int) round($details->estimated_hours/ 24)  ) .'Days'; ;
                                                        } else{
                                                            $getTime=  $details->distance .' Km';
                                                        }
                                                        ?>
                                                        <?php echo e($getTime); ?>

                                                    </span><br>
                                                    <?php ($licensePlates = $details?->tripVehicleDetails->map(function($vehicleDetails) {
                                                            return $vehicleDetails?->vehicle_identity_data?->license_plate_number ?? translate('vehicle not found');
                                                        })->filter()->implode(', ') ?? translate('vehicle not assign')); ?>

                                                    <span class="fs-9"><?php if($licensePlates): ?> <?php echo e(translate('Vehicles')); ?>: <?php echo e($licensePlates); ?> <?php endif; ?> </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td>
                                            <?php ($amount = $details['price'] * $details['quantity']); ?>
                                            <?php echo e(\App\CentralLogics\Helpers::format_currency($amount)); ?>

                                        </td>
                                    </tr>
                                    <?php ($sub_total += $amount); ?>
                                    <?php ($total_tax += $details['tax_amount'] * $details['quantity']); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <div><img src="<?php echo e(asset('/public/assets/admin/img/line_icon.svg')); ?>" alt="" class="w-100"></div>

                        <div class="checkout--info">
                            <dl class="row text-right">
                                <dt class="col-6 opacity-70"><?php echo e(translate('messages.Subtotal')); ?>

                                    <?php if($trip->tax_status == 'included' ): ?>
                                        (<?php echo e(translate('messages.TAX_Included')); ?>)
                                    <?php endif; ?>
                                    :</dt>
                                <dd class="col-6"> <?php echo e(\App\CentralLogics\Helpers::format_currency($sub_total)); ?> </dd>

                                <dt class="col-6 opacity-70"><?php echo e(translate('messages.Discount')); ?>:</dt>
                                <dd class="col-6">  - <?php echo e(\App\CentralLogics\Helpers::format_currency($trip['discount_on_trip'])); ?></dd>

                                <dt class="col-6 opacity-70"><?php echo e(translate('messages.Coupon_Discount')); ?>:</dt>
                                <dd class="col-6"> - <?php echo e(\App\CentralLogics\Helpers::format_currency($trip['coupon_discount_amount'])); ?></dd>

                                <dt class="col-6 opacity-70"><?php echo e(translate('messages.tax')); ?>:</dt>
                                <dd class="col-6"> +<?php echo e(\App\CentralLogics\Helpers::format_currency($trip['tax_amount'])); ?></dd>

                                <dt class="col-6 total"><?php echo e(translate('messages.total')); ?>:</dt>
                                <dd class="col-6 total"> <?php echo e(\App\CentralLogics\Helpers::format_currency($trip->trip_amount)); ?></dd>
                            </dl>
                        </div>
                    </div>

                    <div class="top-info">
                        <img src="<?php echo e(asset('/public/assets/admin/img/line_icon.svg')); ?>" alt="" class="w-100">
                        <div><?php echo e(translate('Thank You')); ?></div>
                        <img src="<?php echo e(asset('/public/assets/admin/img/line_icon.svg')); ?>" alt="" class="w-100">

                        <div class="copyright">
                            &copy; <?php echo e(\App\Models\BusinessSetting::where(['key' => 'business_name'])->first()->value); ?>.
                            <span class="d-none d-sm-inline-block"><?php echo e(\App\Models\BusinessSetting::where(['key' => 'footer_text'])->first()->value); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('Modules/Rental/public/assets/js/admin/view-pages/invoice.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/trip/partials/_invoice.blade.php ENDPATH**/ ?>