
<div class="row">
    <?php ($address = \App\Models\BusinessSetting::where(['key' => 'address'])->first()->value); ?>
    <table>
        <thead>
            <tr>

                <th>
                    <?php echo e(translate('Disbursement_report')); ?>

                </th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>

                </th>
            </tr>
            <tr>

                <th><?php echo e(translate('filter_criteria')); ?> -</th>
                <th></th>
                <th>

                    <?php echo e(translate('zone' )); ?> - <?php echo e($data['zone']??translate('all')); ?>

                    <br>
                    <?php if($data['type'] == 'store'): ?>
                        <?php echo e(translate('store' )); ?> - <?php echo e($data['store']??translate('all')); ?>

                    <?php else: ?>
                        <?php echo e(translate('delivery_man' )); ?> - <?php echo e($data['delivery_man']??translate('all')); ?>

                    <?php endif; ?>
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

                    <br>
                    <?php echo e(translate('status')); ?>: <?php echo e($data['status'] ?? translate('N/A')); ?>


                </th>
                <th></th>
                <th></th>
                <th>

                </th>
            </tr>
            <tr>

                <th>
                <?php echo e(translate('Pending_Disbursements')); ?> - <?php echo e($data['pending'] ?? translate('N/A')); ?>

                </th>
                <th></th>
                <th><?php echo e(translate('Completed_Disbursements')); ?> - <?php echo e($data['completed'] ?? translate('N/A')); ?>

                </th>
                <th></th>
                <th><?php echo e(translate('Canceled_Transactions')); ?> - <?php echo e($data['canceled'] ?? translate('N/A')); ?>

                </th>
                <th>

                </th>
            </tr>
        <tr>
            <th><?php echo e(translate('sl')); ?></th>
            <?php if($data['type'] == 'store'): ?>

            <th><?php echo e(translate('Store_Info')); ?></th>
            <?php else: ?>
            <th><?php echo e(translate('Delivery_Man_Info')); ?></th>
            <?php endif; ?>
            <th><?php echo e(translate('created_at')); ?></th>
            <th><?php echo e(translate('amount')); ?></th>
            <th><?php echo e(translate('Payment_method')); ?></th>
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
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/disbursement-report.blade.php ENDPATH**/ ?>