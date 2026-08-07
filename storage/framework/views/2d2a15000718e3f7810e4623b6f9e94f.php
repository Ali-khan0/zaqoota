<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate('provider_trip_reports')); ?></h1></div>
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
                <th><?php echo e(translate('Analytics')); ?></th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('total_trips')); ?>- <?php echo e($data['total_trips']); ?>

                    <br>
                    <?php echo e(translate('total_trip_amount')); ?>- <?php echo e($data['total_trip_amount']); ?>

                    <br>
                    <?php echo e(translate('canceled_trip')); ?>- <?php echo e($data['total_canceled_count']); ?>

                    <br>
                    <?php echo e(translate('completed_trips')); ?>- <?php echo e($data['total_completed_count']); ?>

                    <br>
                    <?php echo e(translate('incomplete_trips')); ?>- <?php echo e($data['total_ongoing_count']); ?>

                </th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        <tr>
            <th><?php echo e(translate('sl')); ?></th>
            <th><?php echo e(translate('messages.trip_id')); ?></th>
            <th><?php echo e(translate('messages.trip_booking_date')); ?></th>
            <th><?php echo e(translate('messages.trip_schedule_date')); ?></th>
            <th><?php echo e(translate('messages.customer_name')); ?></th>
            <th><?php echo e(translate('messages.provider_name')); ?></th>
            <th><?php echo e(translate('messages.Total Trip Amount')); ?></th>
            <th><?php echo e(translate('messages.payment_status')); ?></th>
            <th><?php echo e(translate('messages.discounted_amount')); ?></th>
            <th><?php echo e(translate('messages.tax')); ?></th>
        </thead>
        <tbody>
            <?php $__currentLoopData = $data['trips']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($key+1); ?></td>
                <td><?php echo e($trip->id); ?></td>
                <td><div>
                    <?php echo e(date('d M Y', strtotime($trip['created_at']))); ?>

                </div>
                <br>
                <div>
                    <?php echo e(date(config('timeformat'), strtotime($trip['created_at']))); ?>

                </div></td>
                <td><div>
                    <?php echo e(date('d M Y', strtotime($trip['schedule_at']))); ?>

                </div>
                <br>
                <div>
                    <?php echo e(date(config('timeformat'), strtotime($trip['schedule_at']))); ?>

                </div></td>
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
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($trip['trip_amount'])); ?></td>
                <td><?php echo e(translate($trip->payment_status)); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($trip['coupon_discount_amount']  + $trip['ref_bonus_amount'] +  $trip['discount_on_trip'])); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::number_format_short($trip['tax_amount'])); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/file-exports/provider-trips-report.blade.php ENDPATH**/ ?>