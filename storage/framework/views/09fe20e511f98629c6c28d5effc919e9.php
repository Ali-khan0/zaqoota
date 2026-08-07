<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(translate('trip_transaction_statement')); ?></title>
    <meta http-equiv="Content-Type" content="text/html;"/>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="<?php echo e(asset('Modules/Rental/public/assets/css/admin/trip-transaction-statement.css')); ?>">
</head>

<link rel="stylesheet" href="<?php echo e(asset('Modules/Rental/public/assets/css/admin/font-awesome.min.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('Modules/Rental/public/assets/css/admin/google-font.css')); ?>">

<body>
<div class="first">
    <table class="bs-0 mb-30 px-10">
        <tr>
            <th class="content-position-y text-left">
                <h2><?php echo e(translate('messages.trip_transaction_statement')); ?></h2>
                <p class="fz-14"><?php echo e(translate('date')); ?> : <?php echo e(date('d M Y ' . config('timeformat'), strtotime(now()))); ?></p>
                <h4 class="text-uppercase mb-1 fz-14">
                    <?php echo e(translate('statement')); ?>: #<?php echo e($trip_transaction->trip->id); ?>

                </h4>
            </th>
            <th class="content-position-y text-right">
                <img height="50" src="<?php echo e(asset("/storage/app/public/business/$company_web_logo")); ?>" alt="">
            </th>
        </tr>
    </table>
</div>
<div class="">
    <section>
        <table class="content-position-y fz-12">
            <tr>
                <td class="p-1">
                    <table>
                        <tr>
                            <td>
                                <div class="">
                                    <p class="fz-14"><?php echo e(translate('date')); ?> :
                                        <?php echo e(date('d M Y ' . config('timeformat'), strtotime($trip_transaction->trip['created_at']))); ?>

                                    </p>
                                    <?php if($trip_transaction->trip->provider): ?>
                                        <p class="fz-14 custom-class-1" ><?php echo e(translate('provider')); ?> : <?php echo e($trip_transaction->trip->provider->name); ?></p>
                                        <?php else: ?>
                                        <p class="fz-14 custom-class-1" ><?php echo e(translate('messages.provider_not_found')); ?></p>
                                    <?php endif; ?>
                                    <?php if(isset($trip_transaction->trip->customer) ): ?>
                                        <p class="fz-14 custom-class-1"><?php echo e(translate('customer')); ?> : <?php echo e($trip_transaction->trip->customer['f_name'] . ' ' . $trip_transaction->trip->customer['l_name']); ?></p>
                                    <?php endif; ?>
                                </div>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>

                <td>
                    <table>
                        <tr>
                            <td class="text-right">
                                <p class="fz-14"><?php echo e(translate('delivered_by')); ?> : <?php echo e(ucfirst($trip_transaction->received_by)); ?></p>
                                <p class="fz-14"><?php echo e(translate('payment_method')); ?> : <?php echo e(translate(str_replace('_', ' ', $trip_transaction->trip['payment_method']))); ?></p>
                                <p class="fz-14"><?php echo e(translate('payment_status')); ?> : <?php echo e($trip_transaction->status ? translate('messages.refunded') : translate('messages.completed')); ?></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>


    </section>
</div>

<br>

<div class="">
    <div class="content-position-y">
        <table class="customers bs-0">
            <thead>
                <tr>
                    <th class="custom-class-background"><?php echo e(translate('SL')); ?></th>
                    <th class="custom-class-background"><?php echo e(translate('details')); ?></th>
                    <th class="custom-class-background"><?php echo e(translate('amount')); ?></th>
                </tr>
            </thead>
            <?php
            ?>
            <tbody>
                <tr>
                    <td>1</td>
                    <td><?php echo e(translate('messages.total_vehicle_amount')); ?></td>
                    <td><?php echo e(\App\CentralLogics\Helpers::format_currency($trip_transaction->trip->trip_details()->sum(DB::raw('calculated_price')))); ?></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td><?php echo e(translate('messages.vehicle_discount')); ?></td>
                    <td><?php echo e(\App\CentralLogics\Helpers::format_currency($trip_transaction->trip->discount_on_trip)); ?></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td><?php echo e(translate('messages.total_coupon_discount')); ?></td>
                    <td><?php echo e(\App\CentralLogics\Helpers::format_currency($trip_transaction->trip['coupon_discount_amount'])); ?></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td><?php echo e(translate('messages.referral_discount')); ?></td>
                    <td><?php echo e(\App\CentralLogics\Helpers::format_currency($trip_transaction->trip['ref_bonus_amount'])); ?></td>
                </tr>
                <tr>
                    <td>5</td>
                    <td><?php echo e(translate('messages.total_discounted_amount')); ?></td>
                    <td><?php echo e(\App\CentralLogics\Helpers::format_currency($trip_transaction->trip['coupon_discount_amount'] + $trip_transaction->trip->discount_on_trip +$trip_transaction->trip['ref_bonus_amount'])); ?></td>
                </tr>
                <tr>
                    <td>6</td>
                    <td><?php echo e(translate('messages.total_vat/_tax')); ?></td>
                    <td><?php echo e(\App\CentralLogics\Helpers::format_currency($trip_transaction->tax_amount)); ?></td>
                </tr>
                <tr>
                    <td>7</td>
                    <td><?php echo e(\App\CentralLogics\Helpers::get_business_data('additional_charge_name')??translate('messages.additional_charge')); ?></td>
                    <td><?php echo e(\App\CentralLogics\Helpers::format_currency($trip_transaction->additional_charge)); ?></td>
                </tr>
                <tr>
                    <td>8</td>
                    <td><?php echo e(translate('messages.total_trip_amount')); ?></td>
                    <td><?php echo e(\App\CentralLogics\Helpers::format_currency($trip_transaction->trip_amount)); ?></td>
                </tr>
            </tbody>
        </table>
        <br><br><br>
        <table class="customers bs-0">
            <thead>
                <tr>
                    <th class="custom-class-background-transparent"><?php echo e(translate('additional_information')); ?></th>
                    <th class="custom-class-background-transparent"><?php echo e(translate('totals')); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo e(translate('messages.admin_discount')); ?></td>
                    <td><?php echo e(\App\CentralLogics\Helpers::format_currency($trip_transaction->admin_expense)); ?></td>
                </tr>
                <tr>
                    <td><?php echo e(translate('messages.provider_discount')); ?></td>
                    <td><?php echo e(\App\CentralLogics\Helpers::format_currency($trip_transaction->store_expense)); ?></td>
                </tr>
                <tr>
                    <td><?php echo e(translate('messages.admin_commission')); ?></td>
                    <td><?php echo e(\App\CentralLogics\Helpers::format_currency( $trip_transaction->admin_commission)); ?></td>
                </tr>
                <tr>
                    <td><?php echo e(translate('messages.admin_net_income')); ?></td>
                    <td><?php echo e(\App\CentralLogics\Helpers::format_currency($trip_transaction->admin_net_income)); ?></td>
                </tr>
                <tr>
                    <td><?php echo e(translate('messages.provider_net_income')); ?></td>
                    <td><?php echo e(\App\CentralLogics\Helpers::format_currency($trip_transaction->store_amount - $trip_transaction->tax_amount)); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<br>
<br>

<div class="row">
    <section>
        <table class="">
            <tr>
                <th class="fz-12 font-normal pb-3">
                    <?php echo e(translate('If_you_require_any_assistance_or_have_feedback_or_suggestions_about_our_site,_you')); ?> <br /> <?php echo e(translate('can_email_us_at')); ?> <a href="mailto:(<?php echo e($company_email); ?>)"><?php echo e($company_email); ?></a>
                </th>
            </tr>
            <tr>
                <th class="content-position-y bg-light py-4">
                    <div class="d-flex justify-content-center gap-2">
                        <div class="mb-2">
                            <i class="fa fa-phone"></i>
                            <?php echo e(translate('phone')); ?>

                            : <?php echo e($company_phone); ?>

                        </div>
                        <div class="mb-2">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            <?php echo e(translate('email')); ?>

                            : <?php echo e($company_email); ?>

                        </div>
                    </div>
                    <div class="mb-2">
                        <?php echo e(url('/')); ?>

                    </div>
                    <div>
                        &copy; <?php echo e($company_name); ?>. <span
                    class="d-none d-sm-inline-block"><?php echo e($footer_text); ?></span>
                    </div>
                </th>
            </tr>
        </table>
    </section>
</div>

</body>
</html>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/report/trip-transaction-statement.blade.php ENDPATH**/ ?>