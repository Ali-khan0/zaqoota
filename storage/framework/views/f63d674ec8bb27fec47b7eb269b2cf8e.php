<?php $__env->startSection('title', translate('messages.dm_bonus_awards')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="page-header-title"><?php echo e(translate('messages.dm_bonus_awards')); ?></h1>
                </div>
                <div class="col-auto">
                    <a href="<?php echo e(route('admin.user.delivery-man.milestone-bonus')); ?>" class="btn btn--secondary"><?php echo e(translate('messages.back')); ?></a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header py-2">
                <form class="search-form">
                    <div class="input-group input--group max--320">
                        <input type="search" name="search" class="form-control h--45px" placeholder="<?php echo e(translate('ex:_DM_name_email_or_phone')); ?>" value="<?php echo e(request('search')); ?>">
                        <button type="submit" class="btn btn--secondary h--45px"><i class="tio-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-borderless table-thead-bordered table-nowrap">
                    <thead class="thead-light">
                        <tr>
                            <th><?php echo e(translate('messages.deliveryman')); ?></th>
                            <th><?php echo e(translate('messages.type')); ?></th>
                            <th><?php echo e(translate('messages.orders_required')); ?></th>
                            <th><?php echo e(translate('messages.delivered')); ?></th>
                            <th><?php echo e(translate('messages.bonus_amount')); ?></th>
                            <th><?php echo e(translate('messages.period')); ?></th>
                            <th><?php echo e(translate('messages.date')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $awards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php ($dm = $a->deliveryMan); ?>
                            <?php ($ms = $a->milestone); ?>
                            <tr>
                                <td>
                                    <?php if($dm): ?>
                                        <?php echo e($dm->f_name); ?> <?php echo e($dm->l_name); ?><br><small class="text-muted"><?php echo e($dm->phone); ?></small>
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($ms ? ucfirst($ms->period_type) : '—'); ?></td>
                                <td><?php echo e($ms ? $ms->orders_required : '—'); ?></td>
                                <td><?php echo e($a->delivered_count); ?></td>
                                <td><?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?><?php echo e(number_format($a->amount, 2)); ?></td>
                                <td><code><?php echo e($a->period_key); ?></code></td>
                                <td><?php echo e($a->awarded_at); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="7" class="text-center py-4"><?php echo e(translate('messages.no_data_found')); ?></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if($awards->hasPages()): ?>
                <div class="card-footer"><?php echo e($awards->links()); ?></div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/delivery-man/milestone-bonus/awards.blade.php ENDPATH**/ ?>