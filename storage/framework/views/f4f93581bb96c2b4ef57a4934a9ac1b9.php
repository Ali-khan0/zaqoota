
<div class="row">
    <div class="col-lg-12 text-center "><h1 > <?php echo e(translate($data['is_provider'] ? 'provider_Cash_Transactions' : 'Store_Cash_Transactions')); ?>

    </h1></div>
    <div class="col-lg-12">

    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('Filter_Criteria')); ?></th>
                <th></th>
                <th>
                    <?php echo e(translate('Search_Bar_Content')); ?>: <?php echo e($data['search'] ?? translate('N/A')); ?>

                </th>
                <th> </th>
                </tr>


        <tr>
            <th><?php echo e(translate('sl')); ?></th>
            <th><?php echo e(translate('Transaction_ID')); ?></th>
            <th><?php echo e(translate('Transaction_Time')); ?></th>
            <th><?php echo e(translate('Balance_Before_Transaction')); ?></th>
            <th><?php echo e(translate('Transaction_Amount')); ?></th>
            <th><?php echo e(translate('Reference')); ?></th>
            <th><?php echo e(translate('Payment_method')); ?></th>

        </thead>
        <tbody>
        <?php $__currentLoopData = $data['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
        <td><?php echo e($loop->index+1); ?></td>
        <td><?php echo e($tr->id); ?></td>
        <td><?php echo e($tr?->created_at->format('Y-m-d '.config('timeformat')) ??  translate('N/A')); ?></td>
        <td>
            <?php echo e(\App\CentralLogics\Helpers::format_currency($tr->current_balance)); ?>

        </td>
        <td>
            <?php echo e(\App\CentralLogics\Helpers::format_currency($tr->amount)); ?>

        </td>
        <td><?php echo e($tr->ref ??  translate('N/A')); ?></td>
        <td><?php echo e($tr->method ??  translate('N/A')); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/store-cash-transaction.blade.php ENDPATH**/ ?>