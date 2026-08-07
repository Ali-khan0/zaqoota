<!DOCTYPE html>
<?php
$lang = \App\CentralLogics\Helpers::system_default_language();
$site_direction = \App\CentralLogics\Helpers::system_default_direction();
?>
<html lang="<?php echo e($lang); ?>" class="<?php echo e($site_direction === 'rtl' ? 'active' : ''); ?>">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(translate('Email_Template')); ?></title>

    <link rel="stylesheet" href="<?php echo e(asset('Modules/Rental/public/assets/css/admin/google-font.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('Modules/Rental/public/assets/css/admin/trip-invoice.css')); ?>">
</head>


<body>

    <table dir="<?php echo e($site_direction); ?>" class="main-table" style="min-width: 720px">
        <tbody>
            <tr>
                <td class="main-table-td">

                    <table class="bg-section p-10 w-100">
                        <tbody>
                            <tr>
                                <td class="p-10" style="text-align:center">
                                    <img class="mb-2 mail-img-2"
                                        src="<?php echo e(\App\CentralLogics\Helpers::get_full_url('business', $logo?->value ?? '', $logo?->storage[0]?->value ?? 'public', 'favicon')); ?>"
                                        alt="">
                                    <h3 class="mb-3 mt-0"><?php echo e(translate('Trip_Info')); ?></h3>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="order-table w-100">
                                        <tbody>
                                            <tr>
                                                <td style="width:150px">
                                                    <h3 class="subtitle"><?php echo e(translate('Trip_Summary')); ?></h3>
                                                    <div class="d-block"><?php echo e(translate('Trip')); ?># <?php echo e($trip->id); ?>

                                                    </div>
                                                    <div class="d-block"><?php echo e(\App\CentralLogics\Helpers::time_date_format($trip->schedule_at)); ?> <?php echo e($trip->scheduled ? '('. translate('messages.scheduled') .')' : ''); ?> </div>
                                                    <div class="text-break mb-1">
                                                        <span class="opacity-70"><?php echo e(translate('messages.pickup_location')); ?></span> <span>:</span>
                                                        <span><?php echo e($trip?->pickup_location['location_name']); ?></span>
                                                    </div>
                                                    <div class="text-break mb-1">
                                                        <span class="opacity-70"><?php echo e(translate('messages.destination_location')); ?></span> <span>:</span>
                                                        <span><?php echo e($trip?->destination_location['location_name']); ?></span>
                                                    </div>
                                                </td>

                                                <td class="px-3" style="width:100px">
                                                    <h3 class="subtitle"><?php echo e(translate('User Info')); ?></h3>
                                                    <?php ($address = $trip->user_info); ?>
                                                    <div class="d-block">
                                                        <?php echo e($address['contact_person_name'] ?? $trip?->customer?->f_name . ' ' . $trip?->customer?->l_name); ?>

                                                    </div>
                                                    <div class="d-block">
                                                        <?php echo e($address['contact_person_number'] ?? $trip?->customer?->phone); ?>

                                                    </div>

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="order-table w-100">
                                        <tbody>
                                            <tr>
                                                <?php
                                                $subtotal = 0;
                                                $total = 0;
                                                $sub_total = 0;
                                                $total_tax = 0;
                                                $total_shipping_cost = $trip->delivery_charge;
                                                $total_discount_on_product = 0;
                                                $extra_discount = 0;
                                                $total_addon_price = 0;
                                                ?>
                                                <td>
                                                    <table class="w-100">
                                                        <thead class="bg-section-2">
                                                            <tr>
                                                                <th class="text-left p-1 px-3"><?php echo e(translate('#')); ?>

                                                                </th>
                                                                <th class="text-left p-1 px-3">
                                                                    <?php echo e(translate('Vehicle')); ?>

                                                                </th>
                                                                <th class="text-left p-1 px-3">
                                                                    <?php echo e(translate('Hour/Km/Day')); ?>

                                                                </th>
                                                                <th class="text-right p-1 px-3"><?php echo e(translate('Fare')); ?>

                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>


                                                            <?php $__currentLoopData = $trip->trip_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php
                                                                $subtotal += $details['calculated_price'] ;
                                                                $item_details = $details->vehicle_details;
                                                                ?>
                                                                <tr>
                                                                    <td class="text-left p-1 px-3">
                                                                        <?php echo e($key + 1); ?>

                                                                    </td>
                                                                    <td class="text-left p-2 px-3">
                                                                        <span style="font-size: 14px;">
                                                                            <?php echo e(Str::limit($item_details['name'], 40, '...')); ?>

                                                                        </span>
                                                                        <br>

                                                                        <span>x <?php echo e($details->quantity); ?></span>
                                                                    </td>
                                                                    <td class=" p-2 px-3">


                                                                        <?php
                                                                            if($details->rental_type == 'hourly'){
                                                                                $getPrice=$details->vehicle_details['hourly_price'];
                                                                                $getType=$trip->estimated_hours.' '.translate('Hrs');
                                                                            }elseif ($details->rental_type == 'day_wise') {
                                                                                $getPrice=$details->vehicle_details['day_wise_price'];
                                                                                $getType=( (int) round($details->estimated_hours/ 24) ).' '.translate('Days');
                                                                            } else{
                                                                                $getPrice=$details->vehicle_details['distance_price'];
                                                                                $getType= $trip->distance .' '.translate('KM');
                                                                            }
                                                                        ?>

                                                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($getPrice)); ?>  x   <?php echo e($getType); ?>

                                                                    </td>
                                                                    <td class="text-right p-2 px-3">
                                                                        <h4>
                                                                            <?php echo e(\App\CentralLogics\Helpers::format_currency($details['calculated_price'] )); ?>

                                                                        </h4>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                            <tr>
                                                                <td colspan="4">
                                                                    <hr class="mt-0">
                                                                    <table class="w-100">

                                                                        <tr>
                                                                            <td style="width: 40%"></td>
                                                                            <td class="p-1 px-3">
                                                                                <?php echo e(translate('messages.price')); ?>

                                                                            </td>
                                                                            <td class="text-right p-1 px-3">
                                                                                <?php echo e(\App\CentralLogics\Helpers::format_currency($subtotal)); ?>

                                                                            </td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td style="width: 40%"></td>
                                                                            <td class="p-1 px-3">
                                                                                <?php echo e(translate('messages.subtotal')); ?>

                                                                                <?php if($trip->tax_status == 'included'): ?>
                                                                                    (<?php echo e(translate('messages.TAX_Included')); ?>)
                                                                                <?php endif; ?>
                                                                            </td>
                                                                            <td class="text-right p-1 px-3">
                                                                                <?php echo e(\App\CentralLogics\Helpers::format_currency($subtotal)); ?>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width: 40%"></td>
                                                                            <td class="p-1 px-3">
                                                                                <?php echo e(translate('messages.discount')); ?>

                                                                            </td>
                                                                            <td class="text-right p-1 px-3">
                                                                                <?php echo e(\App\CentralLogics\Helpers::format_currency($trip->discount_on_trip)); ?>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width: 40%"></td>
                                                                            <td class="p-1 px-3">
                                                                                <?php echo e(translate('messages.coupon_discount')); ?>

                                                                            </td>
                                                                            <td class="text-right p-1 px-3">
                                                                                <?php echo e(\App\CentralLogics\Helpers::format_currency($trip->coupon_discount_amount)); ?>

                                                                            </td>
                                                                        </tr>
                                                                        <?php if($trip?->ref_bonus_amount > 0): ?>
                                                                            <tr>
                                                                                <td style="width: 40%"></td>
                                                                                <td class="p-1 px-3">
                                                                                    <?php echo e(translate('messages.Referral_Discount')); ?>

                                                                                </td>
                                                                                <td class="text-right p-1 px-3">
                                                                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($trip->ref_bonus_amount)); ?>

                                                                                </td>
                                                                            </tr>
                                                                        <?php endif; ?>



                                                                        <?php if($trip->tax_status == 'excluded' || $trip->tax_status == null): ?>
                                                                            <tr>
                                                                                <td style="width: 40%"></td>
                                                                                <td class="p-1 px-3">
                                                                                    <?php echo e(translate('messages.tax')); ?>

                                                                                </td>
                                                                                <td class="text-right p-1 px-3">
                                                                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($trip->tax_amount)); ?>

                                                                                </td>
                                                                            </tr>
                                                                        <?php else: ?>

                                                                        <?php endif; ?>

                                                                        <tr>
                                                                            <td style="width: 40%"></td>
                                                                            <td class="p-1 px-3">
                                                                                <?php echo e(\App\CentralLogics\Helpers::get_business_data('additional_charge_name')??\App\CentralLogics\Helpers::get_business_data('additional_charge_name')??translate('messages.additional_charge')); ?>

                                                                            </td>
                                                                            <td class="text-right p-1 px-3">
                                                                                <?php echo e(\App\CentralLogics\Helpers::format_currency($trip->additional_charge)); ?>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width: 40%"></td>
                                                                            <td class="p-1 px-3">
                                                                                <h4><?php echo e(translate('messages.total')); ?>

                                                                                </h4>
                                                                            </td>
                                                                            <td class="text-right p-1 px-3">
                                                                                <span
                                                                                    class="text-base"><?php echo e(\App\CentralLogics\Helpers::format_currency($trip->trip_amount)); ?></span>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>

                </td>
            </tr>
            <tr>
                <td style="text-align:center">

                    <div class="copyright" style="text-align:center" id="">
                        <?php echo e(translate('Please')); ?>

                        <a class="text-base"
                            href="mailto:<?php echo e($BusinessData['email_address']); ?>"><?php echo e(translate('contact us')); ?></a>
                        <?php echo e(translate('for any queries, we’re always happy to help.')); ?>

                    </div>
                    <div class="copyright" style="text-align:center" id="mail-copyright">
                        <?php echo e($BusinessData['footer_text'] ?? translate('Copyright 2023 6ammart. All right reserved')); ?>

                    </div>
                </td>
            </tr>
        </tbody>
    </table>


</body>

</html>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/email-templates/pdf-rental/trip-invoice.blade.php ENDPATH**/ ?>