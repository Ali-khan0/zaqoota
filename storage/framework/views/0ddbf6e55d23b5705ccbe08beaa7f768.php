<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate('provider_vehicle_reports')); ?></h1></div>
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
                    <?php echo e(translate('Total Trip Amount')); ?>- <?php echo e(\App\CentralLogics\Helpers::number_format_short($data['trips']->sum('trip_amount'))); ?>

                    <br>
                    <?php echo e(translate('total_tax')); ?>- <?php echo e(\App\CentralLogics\Helpers::number_format_short($data['trips']->sum('tax_amount'))); ?>

                    <br>
                    <?php echo e(translate('total_commission')); ?>- <?php echo e(\App\CentralLogics\Helpers::number_format_short($data['trips']->sum('trip_transaction_sum_admin_commission')-$data['trips']->sum('trip_transaction_sum_admin_expense'))); ?>

                    <br>
                    <?php echo e(translate('total_provider_earning')); ?>- <?php echo e(\App\CentralLogics\Helpers::number_format_short($data['trips']->sum('trip_transaction_sum_store_amount'))); ?>

                </th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        <tr>
            <th><?php echo e(translate('sl')); ?></th>
            <th><?php echo e(translate('vehicle_image')); ?></th>
            <th><?php echo e(translate('Vehicle Info')); ?></th>
            <th><?php echo e(translate('Total Trip')); ?></th>
            <th>
                <?php echo e(translate('Total Trip Amount')); ?></th>
            <th>
                <?php echo e(translate('Discount_Given')); ?></th>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data['vehicles']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($key+1); ?></td>
            <td></td>
            <td><?php echo e($item['name']); ?></td>
            <td>
                <?php echo e($item->trips_count ?? 0); ?>

            </td>
            <td>
                <?php echo e(\App\CentralLogics\Helpers::format_currency($item->trips_sum_price)); ?>

            </td>
            <td>
                <?php echo e(\App\CentralLogics\Helpers::format_currency($item->total_discount)); ?>

            </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/file-exports/provider-sales-report.blade.php ENDPATH**/ ?>