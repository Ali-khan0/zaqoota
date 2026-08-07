<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate('trip_transactions_report')); ?></h1></div>
    <div class="col-lg-12">



    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('Search_Criteria')); ?></th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('zone' )); ?> - <?php echo e($data['zone']??translate('all')); ?>

                    <br>
                    <?php echo e(translate('provider' )); ?> - <?php echo e($data['provider']??translate('all')); ?>

                    <?php if($data['from']): ?>
                    <br>
                    <?php echo e(translate('from' )); ?> - <?php echo e($data['from']?Carbon\Carbon::parse($data['from'])->format('d M Y'):''); ?>

                    <?php endif; ?>
                    <?php if($data['to']): ?>
                    <br>
                    <?php echo e(translate('to' )); ?> - <?php echo e($data['to']?Carbon\Carbon::parse($data['to'])->format('d M Y'):''); ?>

                    <?php endif; ?>
                    <br>
                    <?php echo e(translate('filter')); ?>- <?php echo e(translate($data['filter'])); ?>

                    <br>
                    <?php echo e(translate('Search_Bar_Content')); ?>- <?php echo e($data['search'] ??translate('N/A')); ?>


                </th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
                </tr>
            <tr>
                <th><?php echo e(translate('Transaction_Analytics')); ?></th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('Total_completed_amount')); ?> - <?php echo e($data['totalAmount'] ??translate('N/A')); ?>

                    <br>
                    <?php echo e(translate('Admin_Earnings')); ?> - <?php echo e($data['adminEarned'] ??translate('N/A')); ?>

                    <br>
                    <?php echo e(translate('Provider_Earnings')); ?> - <?php echo e($data['providerEarned'] ??translate('N/A')); ?>

                    <br>
                </th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        <tr>
            <th class="border-0"><?php echo e(translate('sl')); ?></th>
            <th class="border-0"><?php echo e(translate('messages.trip_id')); ?></th>
            <th class="border-0"><?php echo e(translate('messages.provider')); ?></th>
            <th class="border-0"><?php echo e(translate('messages.customer')); ?></th>
            <th class="border-0 min-w-120"><?php echo e(translate('messages.Total_Trip_Amount')); ?></th>
            <th class="border-0"><?php echo e(translate('messages.Discount on Vehicle')); ?></th>
            <th class="border-0"><?php echo e(translate('messages.Coupon_Discount')); ?></th>
            <th class="border-0"><?php echo e(translate('messages.Referral_Discount')); ?></th>
            <th class="border-0"><?php echo e(translate('messages.Total Discounted Amount')); ?></th>
            <th class="border-0"><?php echo e(translate('messages.vat/tax')); ?></th>
            <th class="border-0"><?php echo e(translate('messages.Admin_Commission')); ?></th>
            <th class="border-0">
                <?php echo e(\App\CentralLogics\Helpers::get_business_data('additional_charge_name') ?? translate('messages.additional_charge')); ?>

            </th>
            <th class="border-0"><?php echo e(translate('messages.Admin_Discount')); ?></th>
            <th class="min-w-140 text-capitalize"><?php echo e(translate('Admin_net_income')); ?></th>
            <th class="border-0 text-capitalize"><?php echo e(translate('messages.provider_discount')); ?></th>
            <th class="min-w-140 text-capitalize"><?php echo e(translate('provider_net_income')); ?></th>
            <th class="border-0 min-w-120 text-capitalize"><?php echo e(translate('messages.Total Amount Received by')); ?></th>
            <th class="border-top border-bottom text-capitalize">
                <?php echo e(translate('messages.payment_method')); ?></th>
            <th class="border-0 text-capitalize"><?php echo e(translate('messages.payment_status')); ?></th>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data['tripTransactions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $ot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($key+1); ?></td>
                <td><?php echo e($ot->trip_id); ?></td>
                <td >
                    <?php echo e(Str::limit($ot->trip?->provider?->name ?? translate('messages.Not Found'),25,'...')); ?>

                </td>
                <td>
                    <?php if($ot->trip->customer): ?>
                    <strong><?php echo e($ot->trip->customer['f_name'] . ' ' . $ot->trip->customer['l_name']); ?></strong>

                <?php elseif($ot->trip?->user_info['contact_person_name']): ?>
                <strong><?php echo e($ot->trip?->user_info['contact_person_name']); ?></strong>

                <?php else: ?>
                    <?php echo e(translate('messages.Guest_user')); ?>

                <?php endif; ?>
                </td>
                
                <td><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->trip_amount)); ?></td>

                
                <td><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->trip->discount_on_trip)); ?></td>

                
                <td><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->trip['coupon_discount_amount'])); ?></td>
                
                <td><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->trip['ref_bonus_amount'])); ?></td>
                
                <td>  <?php echo e(\App\CentralLogics\Helpers::format_currency($ot->trip['coupon_discount_amount'] + $ot->trip['ref_bonus_amount'] + $ot->trip->discount_on_trip)); ?></td>

                <td><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->tax)); ?></td>

                
                <td><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->admin_commission)); ?></td>


                <td><?php echo e(\App\CentralLogics\Helpers::format_currency(($ot->additional_charge))); ?></td>
                
                <td><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->admin_expense)); ?></td>


                
                <td><?php echo e(\App\CentralLogics\Helpers::format_currency(($ot->admin_net_income))); ?></td>
                
                <td><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->store_expense)); ?></td>
                
                <td><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->store_amount - $ot->tax)); ?></td>
                <?php if($ot->received_by == 'admin'): ?>
                    <td><?php echo e(translate('messages.admin')); ?></td>
                <?php elseif($ot->received_by == 'vendor'): ?>
                    <td><?php echo e(translate('messages.provider')); ?></td>
                <?php endif; ?>
                <td>
                    <?php echo e(translate(str_replace('_', ' ', $ot->trip['payment_method']))); ?>

                </td>
                <td>
                    <?php echo e(translate('messages.completed')); ?>

                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/file-exports/transaction-report.blade.php ENDPATH**/ ?>