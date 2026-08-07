<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate('provider_summary_reports')); ?></h1></div>
    <div class="col-lg-12">



    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('Search_Criteria')); ?></th>
                <th></th>
                <th></th>
                <th>
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
                    <?php echo e(translate('new_registered_provider')); ?>- <?php echo e($data['new_providers'] ??translate('N/A')); ?>

                    <br>
                    <?php echo e(translate('total_trips')); ?>- <?php echo e($data['trips'] ??translate('N/A')); ?>

                    <br>
                    <?php echo e(translate('total_trip_amount')); ?>- <?php echo e($data['total_trip_amount'] ??translate('N/A')); ?>

                    <br>
                    <?php echo e(translate('completed_trips')); ?>- <?php echo e($data['total_completed'] ??translate('N/A')); ?>

                    <br>
                    <?php echo e(translate('incomplete_trips')); ?>- <?php echo e($data['total_ongoing'] ??translate('N/A')); ?>

                    <br>
                    <?php echo e(translate('canceled_trips')); ?>- <?php echo e($data['total_canceled'] ??translate('N/A')); ?>

                </th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th><?php echo e(translate('Payment_Statistics')); ?></th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('cash_payments')); ?> - <?php echo e($data['cash_payments'] ??translate('N/A')); ?>

                    <br>
                    <?php echo e(translate('digital_payments')); ?> - <?php echo e($data['digital_payments'] ??translate('N/A')); ?>

                    <br>
                    <?php echo e(translate('wallet_payments')); ?> - <?php echo e($data['wallet_payments'] ??translate('N/A')); ?>

                </th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        <tr>
            <th><?php echo e(translate('sl')); ?></th>
            <th><?php echo e(translate('provider_name')); ?></th>
            <th><?php echo e(translate('Total Amount')); ?></th>
            <th><?php echo e(translate('Total Trip')); ?></th>
            <th><?php echo e(translate('Total Completed Trip')); ?></th>
            <th><?php echo e(translate('Completion Rate')); ?></th>
            <th><?php echo e(translate('Ongoing Rate')); ?></th>
            <th><?php echo e(translate('Cancelation Rate')); ?></th>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data['providers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php ($completed = $provider->trips->where('trip_status', 'completed')->count()); ?>
        <?php ($canceled = $provider->trips->where('trip_status', 'canceled')->count()); ?>
        <?php ($refunded = $provider->trips->where('trip_status', 'refunded')->count()); ?>
        <?php ($refund_requested = $provider->trips->whereNotNull('refund_requested')->count()); ?>
        <tr>
            <td><?php echo e($key+1); ?></td>
            <td>
                <?php echo e($provider->name); ?>

            </td>
            <td>
                <?php echo e(\App\CentralLogics\Helpers::number_format_short($provider->trips->where('trip_status','completed')->sum('trip_amount'))); ?>

            </td>
            <td>
                <?php echo e($provider->trips->count()); ?>

            </td>
            <td>
                <?php echo e($completed); ?>

            </td>
            <td>
                <?php echo e(($provider->trips->count() > 0 && $completed > 0)? number_format((100*$completed)/$provider->trips->count(), config('round_up_to_digit')): 0); ?>%
            </td>
            <td>
                <?php echo e(($provider->trips->count() > 0 && $completed > 0)? number_format((100*($provider->trips->count()-($completed+$canceled)))/$provider->trips->count(), config('round_up_to_digit')): 0); ?>%
            </td>
            <td>
                <?php echo e(($provider->trips->count() > 0 && $canceled > 0)? number_format((100*$canceled)/$provider->trips->count(), config('round_up_to_digit')): 0); ?>%
            </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/file-exports/provider-summary-report.blade.php ENDPATH**/ ?>