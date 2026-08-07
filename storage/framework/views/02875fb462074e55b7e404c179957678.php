<?php $__env->startSection('title', translate('messages.dm_milestone_bonus')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon"><i class="tio-gift"></i></span>
                <?php echo e(translate('messages.dm_milestone_bonus')); ?>

            </h1>
            <div class="mt-2">
                <a href="<?php echo e(route('admin.delivery-man.milestone-bonus.awards')); ?>" class="btn btn-sm btn--primary"><?php echo e(translate('messages.dm_bonus_awards')); ?></a>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header"><h5 class="mb-0"><?php echo e(translate('messages.add_new')); ?></h5></div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.delivery-man.milestone-bonus.store')); ?>" method="post" class="row align-items-end">
                    <?php echo csrf_field(); ?>
                    <div class="col-md-3 mb-2">
                        <label class="form-label"><?php echo e(translate('messages.type')); ?></label>
                        <select name="period_type" class="form-control" required>
                            <option value="daily"><?php echo e(translate('messages.period_daily')); ?></option>
                            <option value="weekly"><?php echo e(translate('messages.period_weekly')); ?></option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label"><?php echo e(translate('messages.orders_required')); ?></label>
                        <input type="number" name="orders_required" class="form-control" min="1" required>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label"><?php echo e(translate('messages.bonus_amount')); ?></label>
                        <input type="number" step="0.01" name="bonus_amount" class="form-control" min="0" required>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.add')); ?></button>
                    </div>
                </form>
                <p class="text-muted small mb-0"><?php echo e(translate('messages.maximum')); ?> 4 <?php echo e(translate('messages.daily')); ?> / 4 <?php echo e(translate('messages.weekly')); ?>.</p>
            </div>
        </div>

        <?php $__currentLoopData = ['daily' => $daily, 'weekly' => $weekly]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period => $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0"><?php echo e($period === 'daily' ? translate('messages.period_daily') : translate('messages.period_weekly')); ?></h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-borderless table-thead-bordered table-nowrap">
                        <thead class="thead-light">
                            <tr>
                                <th><?php echo e(translate('messages.milestone_slot')); ?></th>
                                <th><?php echo e(translate('messages.orders_required')); ?></th>
                                <th><?php echo e(translate('messages.bonus_amount')); ?></th>
                                <th><?php echo e(translate('messages.status')); ?></th>
                                <th><?php echo e(translate('messages.action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($m->slot); ?></td>
                                    <td colspan="3">
                                        <form action="<?php echo e(route('admin.delivery-man.milestone-bonus.update', $m->id)); ?>" method="post" class="form-inline flex-wrap align-items-center">
                                            <?php echo csrf_field(); ?>
                                            <input type="number" name="orders_required" value="<?php echo e($m->orders_required); ?>" class="form-control form-control-sm mr-2 mb-1" min="1" style="width:90px">
                                            <input type="number" step="0.01" name="bonus_amount" value="<?php echo e($m->bonus_amount); ?>" class="form-control form-control-sm mr-2 mb-1" min="0" style="width:110px">
                                            <select name="status" class="form-control form-control-sm mr-2 mb-1" style="width:100px">
                                                <option value="1" <?php echo e($m->status ? 'selected' : ''); ?>><?php echo e(translate('messages.active')); ?></option>
                                                <option value="0" <?php echo e(!$m->status ? 'selected' : ''); ?>><?php echo e(translate('messages.inactive')); ?></option>
                                            </select>
                                            <button type="submit" class="btn btn-sm btn--primary mb-1"><?php echo e(translate('messages.update')); ?></button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="<?php echo e(route('admin.delivery-man.milestone-bonus.delete', $m->id)); ?>" method="post" class="d-inline" onsubmit="return confirm('<?php echo e(translate('messages.are_you_sure')); ?>');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger"><?php echo e(translate('messages.delete')); ?></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="5" class="text-center py-3"><?php echo e(translate('messages.no_data_found')); ?></td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/delivery-man/dm-milestone-bonus-index.blade.php ENDPATH**/ ?>