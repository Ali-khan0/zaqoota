resources/views/file-exports/vendor-wise-tax-report.blade.php<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate('messages.trip_report')); ?></h1></div>
    <div class="col-lg-12">



    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('filter_criteria')); ?> -</th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('zone' )); ?> - <?php echo e($data['zone']??translate('all')); ?>

                    <br>
                    <?php echo e(translate('provider' )); ?> - <?php echo e($data['provider']??translate('all')); ?>

                    <br>
                    <?php echo e(translate('customer' )); ?> - <?php echo e($data['customer']??translate('all')); ?>

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
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th><?php echo e(translate('messages.sl')); ?></th>
                <th><?php echo e(translate('messages.trip_id')); ?></th>
                <th><?php echo e(translate('messages.Customer info')); ?></th>
                <th><?php echo e(translate('messages.provider_name')); ?></th>
                <th><?php echo e(translate('messages.Total Fare of Vehicle')); ?></th>
                <th><?php echo e(translate('messages.Discount on Vehicle')); ?></th>
                <th><?php echo e(translate('messages.coupon_discount')); ?></th>
                <th><?php echo e(translate('messages.referral_discount')); ?></th>
                <th><?php echo e(translate('messages.Total_discounted_amount')); ?></th>
                <th><?php echo e(\App\CentralLogics\Helpers::get_business_data('additional_charge_name')??translate('messages.additional_charge')); ?></th>
                <th><?php echo e(translate('messages.tax')); ?></th>
                <th><?php echo e(translate('messages.total_amount')); ?></th>
                <th><?php echo e(translate('messages.payment_status')); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data['trips']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($key+1); ?></td>
                <td><?php echo e($trip->id); ?></td>
                <td>
                    <?php if($trip->customer): ?>
                        <?php echo e($trip->customer['f_name'] . ' ' . $trip->customer['l_name']); ?>

                    <?php else: ?>
                        <?php echo e(translate('not_found')); ?>

                    <?php endif; ?>
                </td>
                <td>
                    <?php if($trip->provider): ?>
                        <?php echo e($trip->provider->name); ?>

                    <?php else: ?>
                        <?php echo e(translate('messages.not_found')); ?>

                    <?php endif; ?>
                </td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($trip['trip_amount'] - $trip->additional_charge-$trip['tax_amount']+$trip['coupon_discount_amount'] + $trip['discount_on_trip'] + $trip['ref_bonus_amount'] )); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short( $trip['discount_on_trip'] )); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($trip['coupon_discount_amount'])); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($trip['ref_bonus_amount'])); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($trip['coupon_discount_amount'] + $trip['discount_on_trip'] + $trip['ref_bonus_amount'] )); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($trip['additional_charge'])); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($trip['tax_amount'])); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($trip['trip_amount'])); ?></td>
                <td><?php echo e(translate($trip->payment_status)); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/file-exports/trip-report.blade.php ENDPATH**/ ?>