<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate('messages.collect_cash_transactions')); ?></h1></div>
    <div class="col-lg-12">



    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('filter_criteria')); ?> -</th>
                <th></th>
                <th></th>
                <th> 

                    <?php echo e(translate('Search_Bar_Content')); ?>- <?php echo e($data['search'] ??translate('N/A')); ?>


                </th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th><?php echo e(translate('messages.sl')); ?></th>
                <th><?php echo e(translate('messages.transaction_id')); ?></th>
                <th><?php echo e(translate('messages.transaction_time')); ?></th>
                <th><?php echo e(translate('messages.collected_amount')); ?></th>
                <th><?php echo e(translate('messages.collected_from')); ?></th>
                <th><?php echo e(translate('messages.user_type')); ?></th>
                <th><?php echo e(translate('messages.phone')); ?></th>
                <th><?php echo e(translate('messages.email')); ?></th>
                <th><?php echo e(translate('messages.payment_method')); ?></th>
                <th><?php echo e(translate('messages.references')); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data['account_transactions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $at): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($key+1); ?></td>
                <td><?php echo e($at->id); ?></td>
                <td><?php echo e($at->created_at->format('Y-m-d '.config('timeformat'))); ?></td>
                <td><?php echo e($at['amount']); ?></td>
                <td>
                    <?php if($at->store): ?>
                    <?php echo e($at->store->name); ?>

                    <?php elseif($at->deliveryman): ?>
                    <?php echo e($at->deliveryman->f_name); ?> <?php echo e($at->deliveryman->l_name); ?>

                    <?php else: ?>
                        <?php echo e(translate('messages.not_found')); ?>

                    <?php endif; ?>
                </td>
                <td><?php echo e(translate($at['from_type'])); ?></td>
                <td>
                    <?php if($at->store): ?>
                    <?php echo e($at->store->phone); ?>

                    <?php elseif($at->deliveryman): ?>
                    <?php echo e($at->deliveryman->phone); ?>

                    <?php else: ?>
                        <?php echo e(translate('messages.not_found')); ?>

                    <?php endif; ?>
                </td>
                <td>
                    <?php if($at->store): ?>
                    <?php echo e($at->store->email); ?>

                    <?php elseif($at->deliveryman): ?>
                    <?php echo e($at->deliveryman->email); ?>

                    <?php else: ?>
                        <?php echo e(translate('messages.not_found')); ?>

                    <?php endif; ?>
                </td>
                <td><?php echo e(translate($at->method)); ?></td>
                <td><?php echo e($at['ref']); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/collect-cash-transaction.blade.php ENDPATH**/ ?>