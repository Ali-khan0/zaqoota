<?php $__env->startSection('title', __('fleet_management.rider_payment_accountability')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <div class="page-header">
            <h1 class="page-header-title"><?php echo e(__('fleet_management.rider_payment_accountability')); ?></h1>
            <p class="text-muted mb-0"><?php echo e(__('fleet_management.accountability_intro')); ?></p>
        </div>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger"><?php echo e($errors->first()); ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <div class="w-100">
                    <h5 class="mb-3"><?php echo e(__('fleet_management.manager_recovery_accountability')); ?></h5>
                    <form method="get" class="row align-items-end">
                        <div class="col-lg-3 col-md-6 mb-2">
                            <label><?php echo e(__('fleet_management.search')); ?></label>
                            <input type="search"
                                   name="search"
                                   class="form-control"
                                   value="<?php echo e(request('search')); ?>"
                                   placeholder="<?php echo e(__('fleet_management.search_manager_or_rider')); ?>">
                        </div>
                        <div class="col-lg-3 col-md-6 mb-2">
                            <label><?php echo e(__('fleet_management.fleet_manager')); ?></label>
                            <select name="fleet_manager_id" class="form-control">
                                <option value=""><?php echo e(__('fleet_management.all_fleet_managers')); ?></option>
                                <?php $__currentLoopData = $managerOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manager): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($manager->id); ?>" <?php if((int) request('fleet_manager_id') === $manager->id): echo 'selected'; endif; ?>>
                                        <?php echo e($manager->full_name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-4 mb-2">
                            <label><?php echo e(__('fleet_management.area')); ?></label>
                            <select name="zone_id" class="form-control">
                                <option value=""><?php echo e(__('fleet_management.all_areas')); ?></option>
                                <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($zone->id); ?>" <?php if((int) request('zone_id') === $zone->id): echo 'selected'; endif; ?>>
                                        <?php echo e($zone->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-4 mb-2">
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
                        <div class="col-lg-2 col-md-4 mb-2">
                            <button class="btn btn--primary" type="submit"><?php echo e(__('fleet_management.filter')); ?></button>
                            <a class="btn btn-light"
                               href="<?php echo e(route('admin.users.delivery-man.fleet-manager.collections')); ?>">
                                <?php echo e(__('fleet_management.reset')); ?>

                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-borderless align-middle mb-0">
                    <thead class="thead-light">
                    <tr>
                        <th><?php echo e(__('fleet_management.fleet_manager')); ?></th>
                        <th><?php echo e(__('fleet_management.areas')); ?></th>
                        <th><?php echo e(__('fleet_management.assigned_riders')); ?></th>
                        <th><?php echo e(__('fleet_management.riders_with_due')); ?></th>
                        <th><?php echo e(__('fleet_management.riders_clear')); ?></th>
                        <th><?php echo e(__('fleet_management.rider_payable_balance')); ?></th>
                        <th><?php echo e(__('fleet_management.highest_rider_due')); ?></th>
                        <th><?php echo e(__('fleet_management.contact')); ?></th>
                        <th class="text-center"><?php echo e(__('fleet_management.actions')); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $recoveryManagers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manager): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php ($payable = max(0, (float) $manager->rider_payable_balance)); ?>
                        <tr class="<?php echo e($payable > 0 ? 'table-warning' : ''); ?>">
                            <td>
                                <a href="<?php echo e(route('admin.users.delivery-man.fleet-manager.report', $manager->id)); ?>">
                                    <strong><?php echo e($manager->full_name); ?></strong>
                                </a>
                                <?php if($manager->employee_id): ?>
                                    <br><small class="text-muted"><?php echo e($manager->employee_id); ?></small>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($manager->zones->pluck('name')->join(', ') ?: '—'); ?></td>
                            <td><?php echo e($manager->riders_count); ?></td>
                            <td>
                                <span class="badge badge-soft-<?php echo e($manager->riders_with_due_count > 0 ? 'danger' : 'success'); ?>">
                                    <?php echo e($manager->riders_with_due_count); ?>

                                </span>
                            </td>
                            <td><?php echo e(max(0, $manager->riders_count - $manager->riders_with_due_count)); ?></td>
                            <td>
                                <strong class="<?php echo e($payable > 0 ? 'text-danger' : 'text-success'); ?>">
                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($payable)); ?>

                                </strong>
                            </td>
                            <td><?php echo e(\App\CentralLogics\Helpers::format_currency(max(0, (float) $manager->highest_rider_payable))); ?></td>
                            <td>
                                <a href="tel:<?php echo e($manager->phone); ?>"><?php echo e($manager->phone); ?></a>
                                <?php if($manager->email): ?><br><small><?php echo e($manager->email); ?></small><?php endif; ?>
                            </td>
                            <td class="text-center text-nowrap">
                                <a class="btn btn-sm btn-outline-primary"
                                   href="<?php echo e(route('admin.users.delivery-man.fleet-manager.riders', ['id' => $manager->id, 'due_status' => 'with_due'])); ?>">
                                    <i class="tio-group-senior"></i> <?php echo e(__('fleet_management.view_due_riders')); ?>

                                </a>
                                <a class="btn btn-sm btn-outline-secondary"
                                   href="<?php echo e(route('admin.users.delivery-man.fleet-manager.riders', $manager->id)); ?>">
                                    <?php echo e(__('fleet_management.view_all_riders')); ?>

                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="9" class="text-center py-5"><?php echo e(__('fleet_management.no_accountability_results')); ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($recoveryManagers->hasPages()): ?>
                <div class="card-footer"><?php echo e($recoveryManagers->links()); ?></div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/delivery-man/fleet-manager/collections.blade.php ENDPATH**/ ?>