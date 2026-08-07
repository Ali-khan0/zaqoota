<?php $__env->startSection('title', __('fleet_management.assigned_riders_for_manager', ['manager' => $fleetManager->full_name])); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <div class="page-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h1 class="page-header-title">
                    <?php echo e(__('fleet_management.assigned_riders_for_manager', ['manager' => $fleetManager->full_name])); ?>

                </h1>
                <p class="text-muted mb-0">
                    <?php echo e(__('fleet_management.assigned_riders_intro')); ?>

                    <?php if($fleetManager->zones->isNotEmpty()): ?>
                        &middot; <?php echo e($fleetManager->zones->pluck('name')->join(', ')); ?>

                    <?php endif; ?>
                </p>
            </div>
            <div>
                <a class="btn btn-outline-info"
                   href="<?php echo e(route('admin.users.delivery-man.fleet-manager.report', $fleetManager->id)); ?>">
                    <i class="tio-chart-bar-1"></i> <?php echo e(__('fleet_management.report')); ?>

                </a>
                <a class="btn btn-secondary"
                   href="<?php echo e(route('admin.users.delivery-man.fleet-manager.index')); ?>">
                    <?php echo e(__('fleet_management.back')); ?>

                </a>
            </div>
        </div>

        <div class="row mb-3">
            <?php $__currentLoopData = [
                [__('fleet_management.assigned_riders'), $summary['assigned'], 'primary', false],
                [__('fleet_management.riders_with_due'), $summary['with_due'], 'danger', false],
                [__('fleet_management.rider_payable_balance'), $summary['payable'], 'warning', true],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $value, $color, $currency]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 mb-2">
                    <div class="card h-100 border-left border-<?php echo e($color); ?>">
                        <div class="card-body">
                            <small class="text-muted"><?php echo e($label); ?></small>
                            <h3 class="mb-0">
                                <?php echo e($currency ? \App\CentralLogics\Helpers::format_currency($value) : $value); ?>

                            </h3>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="card">
            <div class="card-header">
                <form method="get" class="row w-100 align-items-end">
                    <div class="col-md-5 mb-2">
                        <label><?php echo e(__('fleet_management.search')); ?></label>
                        <input type="search"
                               name="search"
                               class="form-control"
                               value="<?php echo e(request('search')); ?>"
                               placeholder="<?php echo e(__('fleet_management.search_riders')); ?>">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label><?php echo e(__('fleet_management.payment_due')); ?></label>
                        <select name="due_status" class="form-control">
                            <option value=""><?php echo e(__('fleet_management.all_balances')); ?></option>
                            <option value="with_due" <?php if(request('due_status') === 'with_due'): echo 'selected'; endif; ?>>
                                <?php echo e(__('fleet_management.with_outstanding_balance')); ?>

                            </option>
                            <option value="clear" <?php if(request('due_status') === 'clear'): echo 'selected'; endif; ?>>
                                <?php echo e(__('fleet_management.fully_paid')); ?>

                            </option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <button class="btn btn--primary" type="submit"><?php echo e(__('fleet_management.filter')); ?></button>
                        <a class="btn btn-light"
                           href="<?php echo e(route('admin.users.delivery-man.fleet-manager.riders', $fleetManager->id)); ?>">
                            <?php echo e(__('fleet_management.reset')); ?>

                        </a>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-borderless align-middle mb-0">
                    <thead class="thead-light">
                    <tr>
                        <th><?php echo e(__('fleet_management.rider')); ?></th>
                        <th><?php echo e(__('fleet_management.area')); ?></th>
                        <th><?php echo e(__('fleet_management.contact')); ?></th>
                        <th><?php echo e(__('fleet_management.rider_account_status')); ?></th>
                        <th><?php echo e(__('fleet_management.payment_due')); ?></th>
                        <th class="text-center"><?php echo e(__('fleet_management.actions')); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $riders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php ($payable = max(0, (float) ($rider->wallet?->collected_cash ?? 0))); ?>
                        <tr class="<?php echo e($payable > 0 ? 'table-warning' : ''); ?>">
                            <td>
                                <a href="<?php echo e(route('admin.users.delivery-man.preview', $rider->id)); ?>">
                                    <strong><?php echo e($rider->full_name); ?></strong>
                                </a>
                                <br><small class="text-muted">#<?php echo e($rider->id); ?></small>
                            </td>
                            <td><?php echo e($rider->zone?->name ?: '—'); ?></td>
                            <td>
                                <a href="tel:<?php echo e($rider->phone); ?>"><?php echo e($rider->phone); ?></a>
                                <?php if($rider->email): ?><br><small><?php echo e($rider->email); ?></small><?php endif; ?>
                            </td>
                            <td>
                                <span class="badge badge-soft-<?php echo e($rider->status ? 'success' : 'danger'); ?>">
                                    <?php echo e($rider->status ? __('fleet_management.active') : __('fleet_management.inactive')); ?>

                                </span>
                            </td>
                            <td>
                                <strong class="<?php echo e($payable > 0 ? 'text-danger' : 'text-success'); ?>">
                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($payable)); ?>

                                </strong>
                            </td>
                            <td class="text-center text-nowrap">
                                <a class="btn btn-sm btn-outline-primary"
                                   href="<?php echo e(route('admin.users.delivery-man.preview', $rider->id)); ?>">
                                    <?php echo e(__('fleet_management.view_profile')); ?>

                                </a>
                                <form method="post"
                                      action="<?php echo e(route('admin.users.delivery-man.fleet-manager.unassign', $rider->id)); ?>"
                                      class="d-inline"
                                      onsubmit="return confirm('<?php echo e(__('fleet_management.unassign_rider_confirm')); ?>')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-sm btn-outline-danger" type="submit">
                                        <?php echo e(__('fleet_management.unassign')); ?>

                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5"><?php echo e(__('fleet_management.no_riders')); ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($riders->hasPages()): ?>
                <div class="card-footer"><?php echo e($riders->links()); ?></div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/delivery-man/fleet-manager/riders.blade.php ENDPATH**/ ?>