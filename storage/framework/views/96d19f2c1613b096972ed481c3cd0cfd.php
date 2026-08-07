<?php $__env->startSection('title', __('fleet_management.fleet_rider_assignments')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <div class="page-header">
            <h1 class="page-header-title"><?php echo e(__('fleet_management.fleet_rider_assignments')); ?></h1>
            <p class="text-muted mb-0"><?php echo e(__('fleet_management.assignments_intro')); ?></p>
        </div>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger"><?php echo e($errors->first()); ?></div>
        <?php endif; ?>

        <form method="post" action="<?php echo e(route('admin.users.delivery-man.fleet-manager.assign')); ?>">
            <?php echo csrf_field(); ?>
            <div class="card mb-3">
                <div class="card-header"><h5 class="mb-0"><?php echo e(__('fleet_management.assignment')); ?></h5></div>
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-md-4 mb-3">
                            <label><?php echo e(__('fleet_management.fleet_manager')); ?></label>
                            <select name="fleet_manager_id" class="form-control" required>
                                <option value=""><?php echo e(__('fleet_management.select_fleet_manager')); ?></option>
                                <?php $__currentLoopData = $fleetManagers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manager): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($manager->id); ?>">
                                        <?php echo e($manager->full_name); ?> (<?php echo e($manager->riders_count); ?>/<?php echo e($manager->rider_capacity); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-5 mb-3">
                            <label><?php echo e(__('fleet_management.assignment_reason')); ?></label>
                            <input name="reason" class="form-control" maxlength="191">
                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn--primary btn-block" type="submit"><?php echo e(__('fleet_management.assign_selected_riders')); ?></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <div class="row w-100">
                        <div class="col-md-4">
                            <input form="rider-filter" name="search" class="form-control" value="<?php echo e(request('search')); ?>" placeholder="<?php echo e(__('fleet_management.search_riders')); ?>">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-borderless mb-0">
                        <thead class="thead-light">
                        <tr>
                            <th><input type="checkbox" onclick="document.querySelectorAll('.rider-check').forEach(el => el.checked = this.checked)"></th>
                            <th><?php echo e(__('fleet_management.rider')); ?></th>
                            <th><?php echo e(__('fleet_management.area')); ?></th>
                            <th><?php echo e(__('fleet_management.current_manager')); ?></th>
                            <th><?php echo e(__('fleet_management.payment_due')); ?></th>
                            <th><?php echo e(__('fleet_management.action')); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $riders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><input class="rider-check" type="checkbox" name="rider_ids[]" value="<?php echo e($rider->id); ?>"></td>
                                <td><strong><?php echo e($rider->full_name); ?></strong><br><small><?php echo e($rider->phone); ?></small></td>
                                <td><?php echo e($rider->zone?->name); ?></td>
                                <td><?php echo e($rider->fleetManager?->full_name ?: __('fleet_management.unassigned')); ?></td>
                                <td><?php echo e(\App\CentralLogics\Helpers::format_currency($rider->wallet?->collected_cash ?? 0)); ?></td>
                                <td>
                                    <?php if($rider->fleet_manager_id): ?>
                                        <button class="btn btn-sm btn-outline-danger" type="submit"
                                                form="unassign-<?php echo e($rider->id); ?>"><?php echo e(__('fleet_management.unassign')); ?></button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="6" class="text-center py-5"><?php echo e(__('fleet_management.no_riders')); ?></td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php if($riders->hasPages()): ?>
                    <div class="card-footer"><?php echo e($riders->withQueryString()->links()); ?></div>
                <?php endif; ?>
            </div>
        </form>

        <form id="rider-filter" method="get"></form>
        <?php $__currentLoopData = $riders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($rider->fleet_manager_id): ?>
                <form id="unassign-<?php echo e($rider->id); ?>" method="post"
                      action="<?php echo e(route('admin.users.delivery-man.fleet-manager.unassign', $rider->id)); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                </form>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <div class="card">
            <div class="card-header"><h5 class="mb-0"><?php echo e(__('fleet_management.recent_assignment_history')); ?></h5></div>
            <div class="table-responsive">
                <table class="table table-borderless mb-0">
                    <thead class="thead-light">
                    <tr>
                        <th><?php echo e(__('fleet_management.rider')); ?></th>
                        <th><?php echo e(__('fleet_management.fleet_manager')); ?></th>
                        <th><?php echo e(__('fleet_management.started')); ?></th>
                        <th><?php echo e(__('fleet_management.ended')); ?></th>
                        <th><?php echo e(__('fleet_management.assigned_by')); ?></th>
                        <th><?php echo e(__('fleet_management.ended_by')); ?></th>
                        <th><?php echo e(__('fleet_management.reason')); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($assignment->deliveryMan?->full_name); ?></td>
                            <td><?php echo e($assignment->fleetManager?->full_name); ?></td>
                            <td><?php echo e($assignment->started_at); ?></td>
                            <td><?php echo e($assignment->ended_at ?: __('fleet_management.active')); ?></td>
                            <td><?php echo e($assignment->assignedBy?->full_name); ?></td>
                            <td><?php echo e($assignment->endedBy?->full_name ?: '—'); ?></td>
                            <td>
                                <?php echo e($assignment->reason ?: '—'); ?>

                                <?php if($assignment->end_reason): ?>
                                    <br><small class="text-muted"><?php echo e($assignment->end_reason); ?></small>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/delivery-man/fleet-manager/assignments.blade.php ENDPATH**/ ?>