<div>
    <div class="table-responsive">
        <table id="datatable"
            class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
            <thead class="thead-light">
                <tr>
                    <th class="border-0"><?php echo e(translate('sl')); ?></th>
                    <th class="border-0"><?php echo e(translate('messages.received_at')); ?></th>
                    <th class="border-0"><?php echo e(translate('messages.balance_before_transaction')); ?></th>
                    <th class="border-0"><?php echo e(translate('messages.amount')); ?></th>
                    <th class="border-0"><?php echo e(translate('messages.reference')); ?></th>
                    
                </tr>
            </thead>
            <tbody>
            <?php ($account_transaction = \App\Models\AccountTransaction::where('from_type', 'store')->where('type', 'collected')->where('from_id', $store->vendor->id)->paginate(25)); ?>
            <?php $__currentLoopData = $account_transaction; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$at): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($k+$account_transaction->firstItem()); ?></td>
                    <td><?php echo e($at->created_at->format('Y-m-d '.config('timeformat'))); ?></td>
                    <td><?php echo e(\App\CentralLogics\Helpers::format_currency($at['current_balance'])); ?></td>
                    <td><?php echo e(\App\CentralLogics\Helpers::format_currency($at['amount'])); ?></td>
                    <td><?php echo e(translate($at['ref'])); ?></td>
                    <td>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php if(count($account_transaction) !== 0): ?>
<hr>
<?php endif; ?>
<div class="page-area">
    <?php echo $account_transaction->links(); ?>

</div>
<?php if(count($account_transaction) === 0): ?>
<div class="empty--data">
    <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
    <h5>
        <?php echo e(translate('no_data_found')); ?>

    </h5>
</div>
<?php endif; ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/provider/details/partials/cash_transaction.blade.php ENDPATH**/ ?>