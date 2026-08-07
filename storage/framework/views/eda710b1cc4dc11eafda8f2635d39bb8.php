
<div class="row">
    <?php ($address = \App\Models\BusinessSetting::where(['key' => 'address'])->first()->value); ?>
    <table>
        <thead>
            <tr>

                <th>
                    <?php echo e(translate('Disbursement_Invoice')); ?>

                </th>
                <th></th>
                <th></th>
                <th>

                </th>
            </tr>
            <tr>

                <th>
                    <?php echo e(\App\CentralLogics\Helpers::time_date_format(date("Y-m-d h:i:s",time()))); ?>

                </th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e($address); ?>

                </th>
            </tr>
            <tr>
                <th>
                    <?php echo e(translate('Disbursement_ID')); ?>:<?php echo e($data['disbursement']['id']); ?>

                    <br>

                </th>
                <th></th>
                <th>
                    <?php echo e(translate('created_at')); ?>

                    <br>
                    <?php echo e(\App\CentralLogics\Helpers::time_date_format($data['disbursement']['created_at'])); ?>

                </th>
                <th>
                    <?php echo e(translate('total_amount')); ?>

                    <br>
                    <?php echo e(\App\CentralLogics\Helpers::format_currency($data['disbursement']['total_amount'])); ?>


                </th>
            </tr>
        <tr>
            <th><?php echo e(translate('sl')); ?></th>
            <?php if($data['type'] == 'store'): ?>

            <th><?php echo e(translate('Store_Info')); ?></th>
            <?php else: ?>
            <th><?php echo e(translate('Delivery_Man_Info')); ?></th>
            <?php endif; ?>
            <th><?php echo e(translate('Payment_method')); ?></th>
            <th><?php echo e(translate('amount')); ?></th>
            <th><?php echo e(translate('status')); ?></th>

        </thead>
        <tbody>
        <?php $__currentLoopData = $data['disbursements']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $disb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
        <td><?php echo e($loop->index+1); ?></td>
        <?php if($data['type'] == 'store'): ?>

        <td><?php echo e($disb->store->name); ?></td>
        <?php else: ?>
            <th><?php echo e($disb->delivery_man->f_name.' '.$disb->delivery_man->l_name); ?></th>
        <?php endif; ?>
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
        <td>
            <?php echo e(\App\CentralLogics\Helpers::format_currency($disb['disbursement_amount'])); ?>

        </td>
        <td>
            <?php if($disb->status=='pending'): ?>
            <label class="badge badge-soft-primary"><?php echo e(translate('pending')); ?></label>
        <?php elseif($disb->status=='completed'): ?>
            <label class="badge badge-soft-success"><?php echo e(translate('Completed')); ?></label>
        <?php else: ?>
            <label class="badge badge-soft-danger"><?php echo e(translate('canceled')); ?></label>
        <?php endif; ?>
        </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/disbursement.blade.php ENDPATH**/ ?>