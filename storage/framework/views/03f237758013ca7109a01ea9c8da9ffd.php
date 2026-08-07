<?php $__env->startSection('title', translate('messages.registration_fee_ledger')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="page-header-title"><?php echo e(translate('messages.registration_fee_ledger')); ?></h1>
                    <?php if($fee->deliveryMan): ?>
                        <p class="mb-0"><?php echo e($fee->deliveryMan->f_name); ?> <?php echo e($fee->deliveryMan->l_name); ?> — <?php echo e(translate('messages.remaining_due')); ?>:
                            <strong><?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?><?php echo e(number_format($fee->wallet_remaining_due, 2)); ?></strong></p>
                    <?php endif; ?>
                </div>
                <div class="col-auto">
                    <a href="<?php echo e(route('admin.users.delivery-man.registration-fee')); ?>" class="btn btn--secondary"><?php echo e(translate('messages.back')); ?></a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="table-responsive datatable-custom">
                <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle">
                    <thead class="thead-light">
                        <tr>
                            <th><?php echo e(translate('messages.type')); ?></th>
                            <th><?php echo e(translate('messages.amount')); ?></th>
                            <th><?php echo e(translate('messages.direction')); ?></th>
                            <th><?php echo e(translate('messages.reference')); ?></th>
                            <th><?php echo e(translate('messages.date')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $ledgers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e(str_replace('_', ' ', $row->transaction_type)); ?></td>
                                <td><?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?><?php echo e(number_format($row->amount, 2)); ?></td>
                                <td><?php echo e($row->direction); ?></td>
                                <td><?php echo e($row->reference ?? '—'); ?></td>
                                <td><?php echo e($row->created_at); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4"><?php echo e(translate('messages.no_data_found')); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if($ledgers->hasPages()): ?>
                <div class="card-footer"><?php echo e($ledgers->links()); ?></div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/delivery-man/registration-fee-ledger.blade.php ENDPATH**/ ?>