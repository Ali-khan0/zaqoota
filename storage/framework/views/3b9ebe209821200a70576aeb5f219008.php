<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate('loyalty_point_transaction_history')); ?></h1></div>
    <div class="col-lg-12">



    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('Search_Criteria')); ?></th>
                <th></th>
                <th>
                    <?php if($data['from']): ?>
                    <br>
                    <?php echo e(translate('from' )); ?> - <?php echo e($data['from']?Carbon\Carbon::parse($data['from'])->format('d M Y'):''); ?>

                    <?php endif; ?>
                    <?php if($data['to']): ?>
                    <br>
                    <?php echo e(translate('to' )); ?> - <?php echo e($data['to']?Carbon\Carbon::parse($data['to'])->format('d M Y'):''); ?>

                    <?php endif; ?>
                    <br>
                    <?php echo e(translate('transaction_type')); ?>- <?php echo e($data['transaction_type']?translate($data['transaction_type']):translate('messages.All')); ?>

                    <br>
                    <?php echo e(translate('customers')); ?>- <?php echo e($data['customer']??translate('messages.All')); ?>


                </th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
                </tr>
                <?php
                $credit = $data['data'][0]->total_credit;
                $debit = $data['data'][0]->total_debit;
                $balance = $credit - $debit;
            ?>
            <tr>
                <th><?php echo e(translate('Analytics')); ?></th>
                <th></th>
                <th>
                    <?php echo e(translate('messages.earned')); ?>- <?php echo e($debit); ?>

                    <br>
                    <?php echo e(translate('messages.converted')); ?>- <?php echo e($credit); ?>

                    <br>
                    <?php echo e(translate('messages.balance')); ?>- <?php echo e($balance); ?>

                </th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        <tr>
            <th><?php echo e(translate('sl')); ?></th>
            <th><?php echo e(translate('messages.transaction_id')); ?></th>
            <th><?php echo e(translate('messages.transaction_date')); ?></th>
            <th><?php echo e(translate('messages.customer')); ?></th>
            <th><?php echo e(translate('messages.earned')); ?></th>
            <th><?php echo e(translate('messages.converted')); ?></th>
            <th><?php echo e(translate('messages.balance')); ?></th>
            <th><?php echo e(translate('messages.transaction_type')); ?></th>
            <th><?php echo e(translate('messages.reference')); ?></th>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data['transactions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $wt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($key+1); ?></td>
            <td><?php echo e($wt->transaction_id); ?></td>
            <td>
                <?php echo e(date('d-m-Y',strtotime($wt['created_at']))); ?>

            </td>
            <td><?php echo e($wt->user?$wt->user->f_name.' '.$wt->user->l_name:translate('messages.not_found')); ?></td>
            <td><?php echo e($wt->credit); ?></td>
            <td><?php echo e($wt->debit); ?></td>
            <td><?php echo e($wt->balance); ?></td>
            <td>
                <?php echo e(translate('messages.'.$wt->transaction_type)); ?>

            </td>
            <td><?php echo e($wt->reference); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/customer-loyalty-transaction.blade.php ENDPATH**/ ?>