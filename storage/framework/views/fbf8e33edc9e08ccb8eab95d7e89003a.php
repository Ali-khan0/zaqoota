<?php $__env->startSection('title', __('fleet_management.fleet_manager_report')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <div class="page-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h1 class="page-header-title"><?php echo e(__('fleet_management.fleet_manager_report')); ?></h1>
                <p class="text-muted mb-0">
                    <?php echo e($fleetManager->full_name); ?> &middot; <?php echo e(number_format((float) $fleetManager->commission_percentage, 2)); ?>%
                </p>
            </div>
            <div>
                <a class="btn btn-outline-primary"
                   href="<?php echo e(route('admin.users.delivery-man.fleet-manager.edit', $fleetManager->id)); ?>">
                    <i class="tio-edit"></i> <?php echo e(__('fleet_management.edit')); ?>

                </a>
                <a class="btn btn-secondary"
                   href="<?php echo e(route('admin.users.delivery-man.fleet-manager.index')); ?>">
                    <?php echo e(__('fleet_management.back')); ?>

                </a>
            </div>
        </div>

        <?php ($wallet = $fleetManager->wallet); ?>
        <div class="row mb-3">
            <?php $__currentLoopData = [
                [__('fleet_management.total_earned'), $wallet?->total_earning ?? 0, 'success'],
                [__('fleet_management.available_balance'), $wallet?->available_balance ?? 0, 'primary'],
                [__('fleet_management.pending_withdrawal'), $wallet?->pending_withdraw ?? 0, 'warning'],
                [__('fleet_management.total_withdrawn'), $wallet?->total_withdrawn ?? 0, 'info'],
                [__('fleet_management.rider_payable_balance'), $summary['rider_payable_balance'], 'danger'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $value, $color]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 col-xl-2 mb-3">
                    <div class="card h-100 border-left border-<?php echo e($color); ?>">
                        <div class="card-body">
                            <small class="text-muted"><?php echo e($label); ?></small>
                            <h4 class="mb-0"><?php echo e(\App\CentralLogics\Helpers::format_currency($value)); ?></h4>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="row mb-3">
            <div class="col-md-4 mb-2">
                <div class="card card-body">
                    <small class="text-muted"><?php echo e(__('fleet_management.assigned_riders')); ?></small>
                    <h4><?php echo e($summary['riders']); ?></h4>
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <div class="card card-body">
                    <small class="text-muted"><?php echo e(__('fleet_management.riders_with_due')); ?></small>
                    <h4><?php echo e($summary['riders_with_due']); ?></h4>
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <div class="card card-body">
                    <small class="text-muted"><?php echo e(__('fleet_management.commission_orders')); ?></small>
                    <h4><?php echo e($summary['orders']); ?></h4>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="w-100">
                    <h5><?php echo e(__('fleet_management.commission_earning_history')); ?></h5>
                    <p class="text-muted mb-3"><?php echo e(__('fleet_management.commission_eligibility_hint')); ?></p>
                    <form method="get" class="row align-items-end">
                        <div class="col-md-3 mb-2">
                            <label><?php echo e(__('fleet_management.search')); ?></label>
                            <input type="search" name="search" class="form-control"
                                   value="<?php echo e(request('search')); ?>"
                                   placeholder="<?php echo e(__('fleet_management.search_order_or_rider')); ?>">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label><?php echo e(__('fleet_management.status')); ?></label>
                            <select name="status" class="form-control">
                                <option value=""><?php echo e(__('fleet_management.all_statuses')); ?></option>
                                <option value="earned" <?php if(request('status') === 'earned'): echo 'selected'; endif; ?>>
                                    <?php echo e(__('fleet_management.earning_status_earned')); ?>

                                </option>
                                <option value="reversed" <?php if(request('status') === 'reversed'): echo 'selected'; endif; ?>>
                                    <?php echo e(__('fleet_management.earning_status_reversed')); ?>

                                </option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label><?php echo e(__('fleet_management.from')); ?></label>
                            <input type="date" name="from" class="form-control" value="<?php echo e(request('from')); ?>">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label><?php echo e(__('fleet_management.to')); ?></label>
                            <input type="date" name="to" class="form-control" value="<?php echo e(request('to')); ?>">
                        </div>
                        <div class="col-md-3 mb-2">
                            <button class="btn btn--primary" type="submit"><?php echo e(__('fleet_management.filter')); ?></button>
                            <a class="btn btn-light"
                               href="<?php echo e(route('admin.users.delivery-man.fleet-manager.report', $fleetManager->id)); ?>">
                                <?php echo e(__('fleet_management.reset')); ?>

                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-borderless mb-0">
                    <thead class="thead-light">
                    <tr>
                        <th><?php echo e(__('fleet_management.date')); ?></th>
                        <th><?php echo e(__('fleet_management.order')); ?></th>
                        <th><?php echo e(__('fleet_management.rider')); ?></th>
                        <th><?php echo e(__('fleet_management.delivery_amount')); ?></th>
                        <th><?php echo e(__('fleet_management.admin_commission_pool')); ?></th>
                        <th><?php echo e(__('fleet_management.commission')); ?></th>
                        <th><?php echo e(__('fleet_management.earned')); ?></th>
                        <th><?php echo e(__('fleet_management.status')); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $earnings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $earning): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($earning->created_at); ?></td>
                            <td>#<?php echo e($earning->order_id); ?></td>
                            <td>
                                <?php echo e($earning->deliveryMan?->full_name ?? __('fleet_management.deleted_rider')); ?>

                                <?php if($earning->deliveryMan?->phone): ?><br><small><?php echo e($earning->deliveryMan->phone); ?></small><?php endif; ?>
                            </td>
                            <td><?php echo e(\App\CentralLogics\Helpers::format_currency($earning->delivery_amount)); ?></td>
                            <td><?php echo e(\App\CentralLogics\Helpers::format_currency($earning->admin_commission_amount)); ?></td>
                            <td><?php echo e(number_format((float) $earning->fleet_commission_percentage, 2)); ?>%</td>
                            <td><?php echo e(\App\CentralLogics\Helpers::format_currency($earning->amount)); ?></td>
                            <td>
                                <span class="badge badge-soft-<?php echo e($earning->status === 'earned' ? 'success' : 'danger'); ?>">
                                    <?php echo e(__('fleet_management.earning_status_'.$earning->status)); ?>

                                </span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5"><?php echo e(__('fleet_management.no_commission_earnings')); ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if($earnings->hasPages()): ?>
                <div class="card-footer"><?php echo e($earnings->withQueryString()->links()); ?></div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/delivery-man/fleet-manager/report.blade.php ENDPATH**/ ?>