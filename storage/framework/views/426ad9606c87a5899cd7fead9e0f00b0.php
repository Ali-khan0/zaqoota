<?php $__env->startSection('title', __('fleet_management.fleet_manager_withdrawals')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <div class="page-header">
            <h1 class="page-header-title"><?php echo e(__('fleet_management.fleet_manager_withdrawals')); ?></h1>
            <p class="text-muted mb-0"><?php echo e(__('fleet_management.withdrawals_intro')); ?></p>
        </div>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger"><?php echo e($errors->first()); ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <form method="get" class="row w-100">
                    <div class="col-md-4 mb-2">
                        <input type="search" name="search" class="form-control" value="<?php echo e(request('search')); ?>"
                               placeholder="<?php echo e(__('fleet_management.search_manager_placeholder')); ?>">
                    </div>
                    <div class="col-md-3 mb-2">
                        <select name="fleet_manager_id" class="form-control js-select2-custom">
                            <option value=""><?php echo e(__('fleet_management.all_fleet_managers')); ?></option>
                            <?php $__currentLoopData = $fleetManagers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manager): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($manager->id); ?>" <?php echo e((int) request('fleet_manager_id') === $manager->id ? 'selected' : ''); ?>>
                                    <?php echo e($manager->full_name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <select name="status" class="form-control">
                            <option value=""><?php echo e(__('fleet_management.all_statuses')); ?></option>
                            <?php $__currentLoopData = ['pending', 'approved', 'rejected']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($status); ?>" <?php echo e(request('status') === $status ? 'selected' : ''); ?>>
                                    <?php echo e(__('fleet_management.status_'.$status)); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <button class="btn btn--primary btn-block" type="submit"><?php echo e(__('fleet_management.filter')); ?></button>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-borderless mb-0">
                    <thead class="thead-light">
                    <tr>
                        <th><?php echo e(__('fleet_management.requested')); ?></th>
                        <th><?php echo e(__('fleet_management.fleet_manager')); ?></th>
                        <th><?php echo e(__('fleet_management.amount')); ?></th>
                        <th><?php echo e(__('fleet_management.withdrawal_method')); ?></th>
                        <th><?php echo e(__('fleet_management.account_details')); ?></th>
                        <th><?php echo e(__('fleet_management.status')); ?></th>
                        <th><?php echo e(__('fleet_management.actions')); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $withdrawals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdrawal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($withdrawal->created_at); ?></td>
                            <td>
                                <strong><?php echo e($withdrawal->fleetManager?->full_name); ?></strong><br>
                                <a href="tel:<?php echo e($withdrawal->fleetManager?->phone); ?>"><?php echo e($withdrawal->fleetManager?->phone); ?></a>
                            </td>
                            <td><?php echo e(\App\CentralLogics\Helpers::format_currency($withdrawal->amount)); ?></td>
                            <td><?php echo e($withdrawal->method_name); ?></td>
                            <td>
                                <?php $__currentLoopData = $withdrawal->method_fields ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div><small><?php echo e(str($key)->replace('_', ' ')->title()); ?>:</small> <?php echo e($value); ?></div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if($withdrawal->manager_note): ?>
                                    <div class="text-muted mt-1"><?php echo e($withdrawal->manager_note); ?></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge badge-soft-<?php echo e($withdrawal->status === 'approved' ? 'success' : ($withdrawal->status === 'rejected' ? 'danger' : 'warning')); ?>">
                                    <?php echo e(__('fleet_management.status_'.$withdrawal->status)); ?>

                                </span>
                                <?php if($withdrawal->admin_note): ?><br><small><?php echo e($withdrawal->admin_note); ?></small><?php endif; ?>
                            </td>
                            <td>
                                <?php if($withdrawal->status === 'pending'): ?>
                                    <form method="post"
                                          action="<?php echo e(route('admin.transactions.fleet-manager.withdrawals.review', $withdrawal->id)); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <input name="admin_note" class="form-control form-control-sm mb-1"
                                               placeholder="<?php echo e(__('fleet_management.admin_note')); ?>">
                                        <button name="status" value="approved" class="btn btn-sm btn-outline-success" type="submit">
                                            <?php echo e(__('fleet_management.approve')); ?>

                                        </button>
                                        <button name="status" value="rejected" class="btn btn-sm btn-outline-danger" type="submit">
                                            <?php echo e(__('fleet_management.reject')); ?>

                                        </button>
                                    </form>
                                <?php else: ?>
                                    <small><?php echo e($withdrawal->reviewer?->full_name); ?><br><?php echo e($withdrawal->reviewed_at); ?></small>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5"><?php echo e(__('fleet_management.no_withdrawal_requests')); ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if($withdrawals->hasPages()): ?>
                <div class="card-footer"><?php echo e($withdrawals->withQueryString()->links()); ?></div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/delivery-man/fleet-manager/withdrawals.blade.php ENDPATH**/ ?>