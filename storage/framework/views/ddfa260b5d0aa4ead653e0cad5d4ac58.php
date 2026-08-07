<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate('store_summary_reports')); ?></h1></div>
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
                    <?php echo e(translate('new_registered_store')); ?>- <?php echo e($data['new_stores'] ??translate('N/A')); ?>

                    <br>
                    <?php echo e(translate('total_orders')); ?>- <?php echo e($data['orders'] ??translate('N/A')); ?>

                    <br>
                    <?php echo e(translate('total_order_amount')); ?>- <?php echo e($data['total_order_amount'] ??translate('N/A')); ?>

                    <br>
                    <?php echo e(translate('completed_orders')); ?>- <?php echo e($data['total_delivered'] ??translate('N/A')); ?>

                    <br>
                    <?php echo e(translate('incomplete_orders')); ?>- <?php echo e($data['total_ongoing'] ??translate('N/A')); ?>

                    <br>
                    <?php echo e(translate('canceled_orders')); ?>- <?php echo e($data['total_canceled'] ??translate('N/A')); ?>

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
            <th><?php echo e(translate('store_name')); ?></th>
            <th><?php echo e(translate('Total Order')); ?></th>
            <th><?php echo e(translate('Total Delivered Order')); ?></th>
            <th><?php echo e(translate('Total Amount')); ?></th>
            <th><?php echo e(translate('Completion Rate')); ?></th>
            <th><?php echo e(translate('Ongoing Rate')); ?></th>
            <th><?php echo e(translate('Cancelation Rate')); ?></th>
            <th><?php echo e(translate('Total_Refund_requests')); ?></th>
            <th><?php echo e(translate('Pending_Refund_requests')); ?></th>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data['stores']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php ($delivered = $store->orders->where('order_status', 'delivered')->count()); ?>
        <?php ($canceled = $store->orders->where('order_status', 'canceled')->count()); ?>
        <?php ($refunded = $store->orders->where('order_status', 'refunded')->count()); ?>
        <?php ($refund_requested = $store->orders->whereNotNull('refund_requested')->count()); ?>
        <tr>
            <td><?php echo e($key+1); ?></td>
            <td>
                <?php echo e($store->name); ?>

            </td>
            <td>
                <?php echo e($store->orders->count()); ?>

            </td>
            <td>
                <?php echo e($delivered); ?>

            </td>
            <td>
                <?php echo e(\App\CentralLogics\Helpers::number_format_short($store->orders->where('order_status','delivered')->sum('order_amount'))); ?>

            </td>
            <td>
                <?php echo e(($store->orders->count() > 0 && $delivered > 0)? number_format((100*$delivered)/$store->orders->count(), config('round_up_to_digit')): 0); ?>%
            </td>
            <td>
                <?php echo e(($store->orders->count() > 0 && $delivered > 0)? number_format((100*($store->orders->count()-($delivered+$canceled)))/$store->orders->count(), config('round_up_to_digit')): 0); ?>%
            </td>
            <td>
                <?php echo e(($store->orders->count() > 0 && $canceled > 0)? number_format((100*$canceled)/$store->orders->count(), config('round_up_to_digit')): 0); ?>%
            </td>
            <td>
                <?php echo e($refunded); ?>

            </td>
            <td>
                <?php echo e($refund_requested); ?>

            </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/store-summary-report.blade.php ENDPATH**/ ?>