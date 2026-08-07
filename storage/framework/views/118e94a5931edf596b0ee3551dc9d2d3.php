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

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,400&display=swap');

        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            font-size: 13px;
            line-height: 21px;
            color: #737883;
            background: #f7fbff;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: #334257;
            margin: 0;
        }

        * {
            box-sizing: border-box
        }

        :root {
            --base: #006161
        }

        .main-table {
            width: 500px;
            background: #FFFFFF;
            margin: 0 auto;
            padding: 40px;
        }

        .main-table-td {}

        img {
            max-width: 100%;
        }

        .cmn-btn {
            background: var(--base);
            color: #fff;
            padding: 8px 20px;
            display: inline-block;
            text-decoration: none;
        }

        .mb-1 {
            margin-bottom: 5px;
        }

        .mb-2 {
            margin-bottom: 10px;
        }

        .mb-3 {
            margin-bottom: 15px;
        }

        .mb-4 {
            margin-bottom: 20px;
        }

        .mb-5 {
            margin-bottom: 25px;
        }

        hr {
            border-color: rgba(0, 170, 109, 0.3);
            margin: 16px 0
        }

        .border-top {
            border-top: 1px solid rgba(0, 170, 109, 0.3);
            padding: 15px 0 10px;
            display: block;
        }

        .d-block {
            display: block;
        }

        .privacy {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
        }

        .privacy a {
            text-decoration: none;
            color: #334257;
            position: relative;
            margin-left: auto;
            margin-right: auto;
        }

        .privacy a span {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #334257;
            display: inline-block;
            margin: 0 7px;
        }

        .social {
            margin: 15px 0 8px;
            display: block;
        }

        .copyright {
            text-align: center;
            display: block;
        }

        div {
            display: block;
        }

        .text-center {
            text-align: center;
        }

        .text-base {
            color: var(--base);
            font-weight: 700
        }

        .font-medium {
            font-family: 500;
        }

        .font-bold {
            font-family: 700;
        }

        a {
            text-decoration: none;
        }

        .bg-section {
            background: #E3F5F1;
        }

        .p-10 {
            padding: 10px;
        }

        .mt-0 {
            margin-top: 0;
        }

        .w-100 {
            width: 100%;
        }

        .order-table {
            padding: 10px;
            background: #fff;
        }

        .order-table tr td {
            vertical-align: top
        }

        .order-table .subtitle {
            margin: 0;
            margin-bottom: 10px;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .bg-section-2 {
            background: #F8F9FB;
        }

        .p-1 {
            padding: 5px;
        }

        .p-2 {
            padding: 10px;
        }

        .px-3 {
            padding-inline: 15px
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .m-0 {
            margin: 0;
        }

        .text-base {
            color: var(--base);
            font-weight: 700
        }

        .mail-img-1 {
            width: 140px;
            height: 60px;
            object-fit: contain
        }

        .mail-img-2 {
            width: 130px;
            height: 45px;
            object-fit: contain
        }

        .mail-img-3 {
            width: 100%;
            height: 172px;
            object-fit: cover
        }

        .social img {
            width: 24px;
        }
    </style>

</head>


<body style="background-color: #e9ecef;padding:15px">

    <table dir="<?php echo e($site_direction); ?>" class="main-table">
        <tbody>
            <tr>
                <td class="main-table-td">
                    <h2 class="mb-3" id="mail-title"><?php echo e($title ?? translate('Main_Title_or_Subject_of_the_Mail')); ?>

                    </h2>
                    <div class="mb-1" id="mail-body"><?php echo $body ?? translate('Hi_Sabrina,'); ?></div>
                    <span class="d-block text-center mb-3">
                        <?php if($data?->button_url): ?>
                            <a type="button" href="<?php echo e($data['button_url'] ?? '#'); ?>" class="cmn-btn"
                                id="mail-button"><?php echo e($data['button_name'] ?? 'Submit'); ?></a>
                        <?php endif; ?>
                    </span>
                    <table class="bg-section p-10 w-100">
                        <tbody>
                            <tr>
                                <td class="p-10">
                                    <span class="d-block text-center">
                                        <img class="mb-2 mail-img-2"
                                            src="<?php echo e($data['logo_full_url'] ?? asset('/public/assets/admin/img/blank1.png')); ?>"
                                            alt="">
                                        <h3 class="mb-3 mt-0"><?php echo e(translate('Trip_Info')); ?></h3>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="order-table w-100">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <h3 class="subtitle"><?php echo e(translate('Trip_Summary')); ?></h3>
                                                    <span class="d-block"><?php echo e(translate('Trip')); ?>#
                                                        <?php echo e($trip->id); ?></span>
                                                        <span class="d-block"><?php echo e(\App\CentralLogics\Helpers::time_date_format($trip->schedule_at)); ?></span>

                                                        <div class="text-break mb-1">
                                                            <span class="opacity-70"><?php echo e(translate('messages.pickup_location')); ?></span> <span>:</span>
                                                            <span><?php echo e($trip?->pickup_location['location_name']); ?></span>
                                                        </div>
                                                        <div class="text-break mb-1">
                                                            <span class="opacity-70"><?php echo e(translate('messages.destination_location')); ?></span> <span>:</span>
                                                            <span><?php echo e($trip?->destination_location['location_name']); ?></span>
                                                        </div>

                                                    </td>
                                                <td style="max-width:130px">
                                                    <h3 class="subtitle"><?php echo e(translate('Customer_Info')); ?></h3>

                                                    <?php ($address = $trip->user_info); ?>
                                                    <?php ($subtotal = 0); ?>
                                                    <span
                                                        class="d-block"><?php echo e($trip->customer?->f_name . ' ' . $trip->customer?->l_name ?? $address['contact_person_name']); ?></span>
                                                    <span class="d-block">
                                                        <?php echo e($trip->customer?->phone ?? ($address['contact_person_number'] ?? null)); ?>

                                                    </span>

                                                </td>
                                            </tr>

                                            <td colspan="2">
                                                <table class="w-100">
                                                    <thead class="bg-section-2">
                                                        <tr>
                                                            <th class="text-left p-1 px-3"><?php echo e(translate('#')); ?>

                                                            </th>
                                                            <th class="text-left p-1 px-3"><?php echo e(translate('Vehicle')); ?>

                                                            </th>
                                                            <th class="text-left p-1 px-3"><?php echo e(translate('Hour/Km/Day')); ?>

                                                            </th>
                                                            <th class="text-right p-1 px-3"><?php echo e(translate('Fare')); ?>

                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php $__currentLoopData = $trip->trip_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                            $subtotal += $details['calculated_price'];
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

                                                                <td class=" p-2 px-3">
                                                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($getPrice)); ?>  x   <?php echo e($getType); ?>

                                                                </td>


                                                                <td class="text-right p-2 px-3">
                                                                    <h4>
                                                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($details['calculated_price'])); ?>

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
                                                                            <h4><?php echo e(translate('messages.total')); ?></h4>
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
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>

                    <?php if(isset($url)): ?>
                        <div class="mb-2">
                            <a href="<?php echo e($url); ?>" target="_blank"><?php echo e(translate('Download Invoice')); ?></a>
                        </div>
                    <?php endif; ?>

                    <div class="mb-2" id="mail-footer">
                        <?php echo e($footer_text ?? 'Please contact us for any queries, we’re always happy to help. '); ?>

                    </div>
                    <div>
                        <?php echo e(translate('Thanks & Regards')); ?>,
                    </div>
                    <div class="mb-4">
                        <?php echo e($company_name); ?>

                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="privacy">
                        <?php ( $landing_data = \App\Models\DataSetting::where('type', 'admin_landing_page')->whereIn('key', ['shipping_policy_status', 'refund_policy_status', 'cancellation_policy_status'])->pluck('value', 'key')->toArray()); ?>
                        <a href="<?php echo e(route('privacy-policy')); ?>" id="privacy-check"
                            style="<?php echo e(isset($data['privacy']) && $data['privacy'] == 1 ? '' : 'display:none;'); ?>"><?php echo e(translate('Privacy_Policy')); ?></a>
                        <?php if(isset($landing_data['refund_policy_status']) && $landing_data['refund_policy_status'] == 1): ?>
                            <a href="<?php echo e(route('refund')); ?>" id="refund-check"
                                style="<?php echo e(isset($data['refund']) && $data['refund'] == 1 ? '' : 'display:none;'); ?>"><span
                                    class="dot"></span><?php echo e(translate('Refund_Policy')); ?></a>
                        <?php endif; ?>
                        <?php if(isset($landing_data['cancellation_policy_status']) && $landing_data['cancellation_policy_status'] == 1): ?>
                            <a href="<?php echo e(route('cancelation')); ?>" id="cancelation-check"
                                style="<?php echo e(isset($data['cancelation']) && $data['cancelation'] == 1 ? '' : 'display:none;'); ?>"><span
                                    class="dot"></span><?php echo e(translate('Cancelation_Policy')); ?></a>
                        <?php endif; ?>
                        <a href="<?php echo e(route('contact-us')); ?>" id="contact-check"
                            style="<?php echo e(isset($data['contact']) && $data['contact'] == 1 ? '' : 'display:none;'); ?>"><span
                                class="dot"></span><?php echo e(translate('Contact_us')); ?></a>
                    </span>
                    <span class="social" style="text-align:center">
                        <?php ($social_media = \App\Models\SocialMedia::active()->get()); ?>
                        <?php if(isset($social_media)): ?>
                            <?php $__currentLoopData = $social_media; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e($social->link); ?>" target=”_blank” id="<?php echo e($social->name); ?>-check"
                                    style="margin: 0 5px;text-decoration:none;<?php echo e(isset($data[$social->name]) && $data[$social->name] == 1 ? '' : 'display:none;'); ?>">
                                    <img src="<?php echo e(asset('/public/assets/admin/img/img/')); ?>/<?php echo e($social->name); ?>.png"
                                        alt="">
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </span>
                    <span class="copyright" id="mail-copyright">
                        <?php echo e($copyright_text ?? translate('Copyright 2023 6ammart. All right reserved')); ?>

                    </span>
                </td>
            </tr>
        </tbody>
    </table>


</body>

</html>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/email-templates/rental/new-email-format-3.blade.php ENDPATH**/ ?>