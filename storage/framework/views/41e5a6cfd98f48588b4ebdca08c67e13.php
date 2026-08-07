<div class="row">
    <div class="col-lg-12 text-center "><h1><?php echo e(translate('messages.customer_withdraw_transaction')); ?></h1></div>
    <div class="col-lg-12">
    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('filter_criteria')); ?> -</th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('request_status')); ?>- <?php echo e($data['request_status']?translate($data['request_status']):translate('all')); ?>

                    <br>
                    <?php echo e(translate('Search_Bar_Content')); ?>- <?php echo e($data['search'] ?? translate('N/A')); ?>

                </th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th><?php echo e(translate('messages.sl')); ?></th>
                <th><?php echo e(translate('messages.request_time')); ?></th>
                <th><?php echo e(translate('messages.requested_amount')); ?></th>
                <th><?php echo e(translate('messages.customer')); ?></th>
                <th><?php echo e(translate('messages.phone')); ?></th>
                <th><?php echo e(translate('messages.email')); ?></th>
                <th><?php echo e(translate('messages.request_status')); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data['withdraw_requests']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $wr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($key+1); ?></td>
                <td><?php echo e(date('Y-m-d '.config('timeformat'), strtotime($wr->created_at))); ?></td>
                <td><?php echo e($wr['amount']); ?></td>
                <td>
                    <?php if($wr->user): ?>
                        <?php echo e($wr->user->f_name); ?> <?php echo e($wr->user->l_name); ?>

                    <?php else: ?>
                        <?php echo e(translate('messages.customer_deleted')); ?>

                    <?php endif; ?>
                </td>
                <td><?php echo e($wr->user->phone ?? ''); ?></td>
                <td><?php echo e($wr->user->email ?? ''); ?></td>
                <td>
                    <?php if($wr->approved==0): ?>
                        <?php echo e(translate('messages.pending')); ?>

                    <?php elseif($wr->approved==1): ?>
                        <?php echo e(translate('messages.approved')); ?>

                    <?php else: ?>
                        <?php echo e(translate('messages.denied')); ?>

                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/customer-withdraw-transaction.blade.php ENDPATH**/ ?>