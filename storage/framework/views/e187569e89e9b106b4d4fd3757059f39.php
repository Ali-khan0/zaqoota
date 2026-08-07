<?php $__env->startSection('title', __('fleet_management.fleet_managers')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <div class="page-header d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-header-title"><?php echo e(__('fleet_management.fleet_managers')); ?></h1>
                <p class="text-muted mb-0"><?php echo e(__('fleet_management.manage_rider_supervisors')); ?></p>
            </div>
            <a href="<?php echo e(route('admin.users.delivery-man.fleet-manager.create')); ?>" class="btn btn--primary">
                <i class="tio-add"></i> <?php echo e(__('fleet_management.add_fleet_manager')); ?>

            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <form class="w-100">
                    <div class="input-group">
                        <input type="search" name="search" class="form-control" value="<?php echo e(request('search')); ?>"
                               placeholder="<?php echo e(__('fleet_management.search_manager_placeholder')); ?>">
                        <div class="input-group-append">
                            <button class="btn btn--primary" type="submit"><?php echo e(__('fleet_management.search')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-borderless align-middle mb-0">
                    <thead class="thead-light">
                    <tr>
                        <th><?php echo e(__('fleet_management.manager')); ?></th>
                        <th><?php echo e(__('fleet_management.areas')); ?></th>
                        <th><?php echo e(__('fleet_management.riders')); ?></th>
                        <th><?php echo e(__('fleet_management.commission')); ?></th>
                        <th><?php echo e(__('fleet_management.earned_available')); ?></th>
                        <th><?php echo e(__('fleet_management.shift')); ?></th>
                        <th><?php echo e(__('fleet_management.status')); ?></th>
                        <th class="text-center"><?php echo e(__('fleet_management.actions')); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $fleetManagers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manager): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <strong><?php echo e($manager->full_name); ?></strong>
                                <div class="text-muted"><?php echo e($manager->phone); ?></div>
                                <?php if($manager->employee_id): ?>
                                    <small><?php echo e($manager->employee_id); ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php echo e($manager->zones->pluck('name')->join(', ')); ?>

                            </td>
                            <td>
                                <a href="<?php echo e(route('admin.users.delivery-man.fleet-manager.riders', $manager->id)); ?>">
                                    <?php echo e($manager->riders_count); ?> / <?php echo e($manager->rider_capacity); ?>

                                </a>
                            </td>
                            <td><?php echo e(number_format((float) $manager->commission_percentage, 2)); ?>%</td>
                            <td>
                                <strong><?php echo e(\App\CentralLogics\Helpers::format_currency($manager->wallet?->total_earning ?? 0)); ?></strong>
                                <br>
                                <small>
                                    <?php echo e(__('fleet_management.available')); ?>:
                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($manager->wallet?->available_balance ?? 0)); ?>

                                </small>
                            </td>
                            <td>
                                <?php echo e($manager->shift_start ?: '—'); ?> – <?php echo e($manager->shift_end ?: '—'); ?>

                            </td>
                            <td>
                                <span class="badge <?php echo e($manager->status && !$manager->on_leave ? 'badge-soft-success' : 'badge-soft-danger'); ?>">
                                    <?php echo e($manager->on_leave ? __('fleet_management.on_leave') : ($manager->status ? __('fleet_management.active') : __('fleet_management.inactive'))); ?>

                                </span>
                            </td>
                            <td class="text-center">
                                <a class="btn btn-sm btn-outline-secondary"
                                   href="<?php echo e(route('admin.users.delivery-man.fleet-manager.riders', $manager->id)); ?>">
                                    <i class="tio-group-senior"></i> <?php echo e(__('fleet_management.view_riders')); ?>

                                </a>
                                <a class="btn btn-sm btn-outline-info"
                                   href="<?php echo e(route('admin.users.delivery-man.fleet-manager.report', $manager->id)); ?>">
                                    <i class="tio-chart-bar-1"></i> <?php echo e(__('fleet_management.report')); ?>

                                </a>
                                <a class="btn btn-sm btn-outline-primary"
                                   href="<?php echo e(route('admin.users.delivery-man.fleet-manager.edit', $manager->id)); ?>">
                                    <i class="tio-edit"></i> <?php echo e(__('fleet_management.edit')); ?>

                                </a>
                                <form method="post"
                                      action="<?php echo e(route('admin.users.delivery-man.fleet-manager.status', $manager->id)); ?>"
                                      class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <button class="btn btn-sm btn-outline-secondary" type="submit">
                                        <?php echo e($manager->status ? __('fleet_management.deactivate') : __('fleet_management.activate')); ?>

                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5"><?php echo e(__('fleet_management.no_fleet_managers')); ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if($fleetManagers->hasPages()): ?>
                <div class="card-footer"><?php echo e($fleetManagers->withQueryString()->links()); ?></div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/delivery-man/fleet-manager/index.blade.php ENDPATH**/ ?>