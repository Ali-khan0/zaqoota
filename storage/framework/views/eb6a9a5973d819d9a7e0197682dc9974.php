<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate('messages.delivery_man_payments')); ?></h1></div>
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
                <th><?php echo e(translate('messages.provided_st')); ?></th>
                <th><?php echo e(translate('messages.payment_amount')); ?></th>
                <th><?php echo e(translate('messages.delivery_man_name')); ?></th>
                <th><?php echo e(translate('messages.phone')); ?></th>
                <th><?php echo e(translate('messages.payment_method')); ?></th>
                <th><?php echo e(translate('messages.references')); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data['dm_earnings']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $at): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($key+1); ?></td>
                <td><?php echo e($at->id); ?></td>
                <td><?php echo e($at->created_at->format('Y-m-d '.config('timeformat'))); ?></td>
                <td><?php echo e($at['amount']); ?></td>
                <td>
                    <?php if($at->delivery_man): ?>
                    <?php echo e($at->delivery_man->f_name.' '.$at->delivery_man->l_name); ?>

                    <?php else: ?>
                    <?php echo e(translate('messages.deliveryman_deleted')); ?>

                    <?php endif; ?>
                </td>
                <td>
                    <?php if($at->delivery_man): ?>
                    <?php echo e($at->delivery_man->phone); ?>

                    <?php else: ?>
                    <?php echo e(translate('messages.deliveryman_deleted')); ?>

                    <?php endif; ?>
                </td>
                <td><?php echo e(translate($at->method)); ?></td>
                <?php if(  $at['ref'] == 'delivery_man_wallet_adjustment_full'): ?>
                    <td><?php echo e(translate('wallet_adjusted')); ?></td>
                <?php elseif( $at['ref'] == 'delivery_man_wallet_adjustment_partial'): ?>
                    <td><?php echo e(translate('wallet_adjusted_partially')); ?></td>
                <?php else: ?>
                    <td><?php echo e($at['ref']); ?></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/deliveryman-payment.blade.php ENDPATH**/ ?>