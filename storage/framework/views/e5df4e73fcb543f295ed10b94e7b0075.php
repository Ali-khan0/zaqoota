
<div class="row">
    <?php ($address = \App\Models\BusinessSetting::where(['key' => 'address'])->first()->value); ?>
    <table>
        <thead>
            <tr>

                <th>
                    <?php echo e(translate('Disbursement_List')); ?>

                </th>
                <th></th>
                <th></th>
                <th>
                    <?php if($data['type'] == 'store'): ?>
                        <?php echo e(translate($data['is_provider'] ? 'Provider' : 'Store')); ?> - <?php echo e($data['store']); ?>

                    <?php else: ?>
                        <?php echo e(translate('Delivery_man')); ?> - <?php echo e($data['delivery_man']); ?>

                    <?php endif; ?>
                </th>
                <th></th>
                <th>

                </th>
            </tr>
        <tr>
            <th><?php echo e(translate('sl')); ?></th>
            <th><?php echo e(translate('id')); ?></th>
            <th><?php echo e(translate('created_at')); ?></th>
            <th><?php echo e(translate('amount')); ?></th>
            <th><?php echo e(translate('Payment_method')); ?></th>
            <th><?php echo e(translate('status')); ?></th>

        </thead>
        <tbody>
        <?php $__currentLoopData = $data['disbursements']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $disb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
        <td><?php echo e($loop->index+1); ?></td>
        <td><?php echo e($disb['disbursement_id']); ?></td>
        <td><?php echo e(\App\CentralLogics\Helpers::time_date_format($disb['created_at'])); ?></td>
        <td>
            <?php echo e(\App\CentralLogics\Helpers::format_currency($disb['disbursement_amount'])); ?>

        </td>
        <td>
            <div class="name"><?php echo e(translate('payment_method')); ?> : <?php echo e($disb->withdraw_method->method_name); ?></div>
            <?php $__empty_1 = true; $__currentLoopData = json_decode($disb->withdraw_method->method_fields, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <br>
                <div>
                    <span><?php echo e(translate($key)); ?></span>
                    <span>:</span>
                    <span class="name"><?php echo e($item); ?></span>
                </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

            <?php endif; ?>
        </td>
        <td><?php echo e($disb['status']); ?></td>

            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/disbursement-history.blade.php ENDPATH**/ ?>