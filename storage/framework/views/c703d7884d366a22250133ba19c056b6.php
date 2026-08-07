<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate('messages.Subscription_Transactions')); ?></h1></div>
    <div class="col-lg-12">



    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('filter_criteria')); ?> -</th>
                <th></th>
                <th></th>
                <th>
                    <?php if(isset($data['package_name'])): ?>
                    <?php echo e(translate('Package_name' )); ?> - <?php echo e($data['package_name']); ?>


                    <?php elseif(isset($data['store'])): ?>
                    <?php echo e(translate('Store_Name' )); ?> - <?php echo e($data['store']); ?>

                    <?php else: ?>
                    <?php echo e(translate('All_transactions' )); ?>


                    <?php endif; ?>

                    <?php if($data['start_date']): ?>
                    <br>
                    <?php echo e(translate('start_date' )); ?> - <?php echo e($data['start_date']?Carbon\Carbon::parse($data['start_date'])->format('d M Y'):''); ?>

                    <?php endif; ?>
                    <?php if($data['end_date']): ?>
                    <br>
                    <?php echo e(translate('end_date' )); ?> - <?php echo e($data['end_date']?Carbon\Carbon::parse($data['end_date'])->format('d M Y'):''); ?>

                    <?php endif; ?>
                    <br>
                    <?php echo e(translate('filter')); ?>- <?php echo e(translate($data['filter'])); ?>

                    <br>
                    <?php echo e(translate('plan_type')); ?>- <?php echo e(translate($data['plan_type'])); ?>

                    <br>
                    <?php echo e(translate('Search_Bar_Content')); ?>- <?php echo e($data['search'] ??translate('N/A')); ?>


                </th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th class="border-top px-4 border-bottom text-center"><?php echo e(translate('sl')); ?></th>
                <th class="border-top px-4 border-bottom"><?php echo e(translate('Transaction_ID')); ?></th>
                <th class="border-top px-4 border-bottom"><div class="text-title"><?php echo e(translate('Transaction_Date')); ?></div></th>
                <th class="border-top px-4 border-bottom"><?php echo e(translate('Store')); ?></th>
                <th class="border-top px-4 border-bottom"><?php echo e(translate('Pricing')); ?></th>
                <th class="border-top px-4 border-bottom"><?php echo e(translate('Payment_Type')); ?></th>
                <th class="border-top px-4 border-bottom"><?php echo e(translate('Status')); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=> $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="px-4 text-center"><?php echo e($k + 1); ?></td>

                <td class="px-4">
                    <div class="text-title"><?php echo e($transaction->id); ?></div>
                </td>
                <td class="px-4">
                    <div class="pl-4"><?php echo e(\App\CentralLogics\Helpers::date_format($transaction->created_at)); ?></div>
                </td>
                <td class="px-4">
                    <div class="text-title"><?php echo e($transaction?->store?->name ?? translate('messages.store deleted!')); ?>


                    </div>
                </td>
                <td class="px-4">
                    <div class="w--120px text-title text-right pr-5"><?php echo e(\App\CentralLogics\Helpers::format_currency($transaction->paid_amount)); ?></div>
                </td>
                <td class="px-4">
                    <div>
                        <?php if( $transaction->plan_type == 'renew'  ): ?>
                        <div class="text-title"><?php echo e(translate('Renewal')); ?></div>
                        <?php elseif($transaction->plan_type == 'new_plan'  ): ?>
                        <div class="text-title"><?php echo e(translate('Migrate_to_New_Plan')); ?></div>
                        <?php elseif($transaction->plan_type == 'first_purchased'  ): ?>
                        <div class="text-title"><?php echo e(translate('Purchased')); ?></div>
                        <?php else: ?>
                        <div class="text-title"><?php echo e(translate($transaction->plan_type)); ?></div>
                        <?php endif; ?>
                        &nbsp;
                        <div class="text-success font-medium"><?php echo e(translate('Paid_by')); ?>  <?php echo e(translate($transaction->payment_method)); ?></div>
                    </div>
                </td>
                <td class="px-4">
                    <?php if( $transaction->payment_status == 'success'): ?>
                    <span class="text-success">
                    <?php elseif($transaction->payment_status ==  'on_hold'): ?>
                    <span class="text--info">
                    <?php else: ?>
                        <span class="text--danger">
                    <?php endif; ?>
                        <?php echo e(translate($transaction->payment_status)); ?>

                    </span>

                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/subscription_transactions.blade.php ENDPATH**/ ?>