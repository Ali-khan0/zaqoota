<?php ($editing = $fleetManager->exists); ?>
<?php $__env->startSection('title', $editing ? __('fleet_management.edit_fleet_manager') : __('fleet_management.add_fleet_manager')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <div class="page-header">
            <h1 class="page-header-title">
                <?php echo e($editing ? __('fleet_management.edit_fleet_manager') : __('fleet_management.add_fleet_manager')); ?>

            </h1>
        </div>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post"
              action="<?php echo e($editing ? route('admin.users.delivery-man.fleet-manager.update', $fleetManager->id) : route('admin.users.delivery-man.fleet-manager.store')); ?>">
            <?php echo csrf_field(); ?>
            <?php if($editing): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

            <div class="card mb-3">
                <div class="card-header"><h5 class="mb-0"><?php echo e(__('fleet_management.account_information')); ?></h5></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label><?php echo e(__('fleet_management.first_name')); ?> *</label>
                            <input name="f_name" class="form-control" required value="<?php echo e(old('f_name', $fleetManager->f_name)); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label><?php echo e(__('fleet_management.last_name')); ?></label>
                            <input name="l_name" class="form-control" value="<?php echo e(old('l_name', $fleetManager->l_name)); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label><?php echo e(__('fleet_management.employee_id')); ?></label>
                            <input name="employee_id" class="form-control" value="<?php echo e(old('employee_id', $fleetManager->employee_id)); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label><?php echo e(__('fleet_management.phone')); ?> *</label>
                            <input name="phone" class="form-control" required value="<?php echo e(old('phone', $fleetManager->phone)); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label><?php echo e(__('fleet_management.email')); ?></label>
                            <input name="email" type="email" class="form-control" value="<?php echo e(old('email', $fleetManager->email)); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label><?php echo e(__('fleet_management.password')); ?> <?php echo e($editing ? '' : '*'); ?></label>
                            <input name="password" type="password" class="form-control" <?php echo e($editing ? '' : 'required'); ?>>
                            <?php if($editing): ?><small class="text-muted"><?php echo e(__('fleet_management.leave_password_blank')); ?></small><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header"><h5 class="mb-0"><?php echo e(__('fleet_management.operational_scope')); ?></h5></div>
                <div class="card-body">
                    <?php ($selectedZones = array_map('intval', (array) old('zone_ids', $fleetManager->exists ? $fleetManager->zones->pluck('id')->all() : []))); ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label><?php echo e(__('fleet_management.assigned_areas')); ?> *</label>
                            <select name="zone_ids[]" id="fleet-manager-areas"
                                    class="form-control js-select2-custom" multiple required
                                    data-placeholder="<?php echo e(__('fleet_management.search_and_select_areas')); ?>">
                                <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($zone->id); ?>" <?php echo e(in_array($zone->id, $selectedZones) ? 'selected' : ''); ?>>
                                        <?php echo e($zone->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <small class="text-muted"><?php echo e(__('fleet_management.area_search_hint')); ?></small>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label><?php echo e(__('fleet_management.primary_area')); ?></label>
                            <select name="primary_zone_id" id="fleet-manager-primary-area"
                                    class="form-control js-select2-custom"
                                    data-placeholder="<?php echo e(__('fleet_management.use_first_selected_area')); ?>">
                                <option value=""><?php echo e(__('fleet_management.use_first_selected_area')); ?></option>
                                <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($zone->id); ?>" <?php echo e((int) old('primary_zone_id', $fleetManager->primary_zone_id) === $zone->id ? 'selected' : ''); ?>>
                                        <?php echo e($zone->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label><?php echo e(__('fleet_management.rider_capacity')); ?> *</label>
                            <input name="rider_capacity" type="number" min="1" class="form-control" required
                                   value="<?php echo e(old('rider_capacity', $fleetManager->rider_capacity ?: 50)); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label><?php echo e(__('fleet_management.shift_start')); ?></label>
                            <input name="shift_start" type="time" class="form-control" value="<?php echo e(old('shift_start', $fleetManager->shift_start)); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label><?php echo e(__('fleet_management.shift_end')); ?></label>
                            <input name="shift_end" type="time" class="form-control" value="<?php echo e(old('shift_end', $fleetManager->shift_end)); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label><?php echo e(__('fleet_management.joining_date')); ?></label>
                            <input name="joining_date" type="date" class="form-control"
                                   value="<?php echo e(old('joining_date', optional($fleetManager->joining_date)->format('Y-m-d'))); ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label><?php echo e(__('fleet_management.contract_type')); ?></label>
                            <select name="contract_type" class="form-control">
                                <?php $__currentLoopData = ['employee', 'contractor', 'external_fleet']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($type); ?>" <?php echo e(old('contract_type', $fleetManager->contract_type ?: 'employee') === $type ? 'selected' : ''); ?>>
                                        <?php echo e(__('fleet_management.contract_'.$type)); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label><?php echo e(__('fleet_management.commission_percentage')); ?> (%) *</label>
                            <input name="commission_percentage" type="number" min="0" max="100" step="0.01"
                                   class="form-control" required
                                   value="<?php echo e(old('commission_percentage', $fleetManager->commission_percentage ?? 0)); ?>">
                            <small class="text-muted"><?php echo e(__('fleet_management.commission_percentage_hint')); ?></small>
                        </div>
                        <div class="col-md-3 mb-3">
                            <input type="hidden" name="status" value="0">
                            <label class="d-block">
                                <input type="checkbox" name="status" value="1" <?php echo e(old('status', $fleetManager->exists ? $fleetManager->status : true) ? 'checked' : ''); ?>>
                                <?php echo e(__('fleet_management.active')); ?>

                            </label>
                            <input type="hidden" name="on_leave" value="0">
                            <label class="d-block">
                                <input type="checkbox" name="on_leave" value="1" <?php echo e(old('on_leave', $fleetManager->on_leave) ? 'checked' : ''); ?>>
                                <?php echo e(__('fleet_management.on_leave')); ?>

                            </label>
                        </div>
                        <div class="col-md-9 mb-3">
                            <label><?php echo e(__('fleet_management.internal_notes')); ?></label>
                            <textarea name="notes" class="form-control" rows="3"><?php echo e(old('notes', $fleetManager->notes)); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <button class="btn btn--primary" type="submit"><?php echo e(__('fleet_management.save')); ?></button>
            <a class="btn btn-secondary" href="<?php echo e(route('admin.users.delivery-man.fleet-manager.index')); ?>"><?php echo e(__('fleet_management.cancel')); ?></a>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script>
        "use strict";

        $(function () {
            const $areas = $('#fleet-manager-areas');
            const $primaryArea = $('#fleet-manager-primary-area');

            if (!$areas.hasClass('select2-hidden-accessible')) {
                $.HSCore.components.HSSelect2.init($areas);
            }
            if (!$primaryArea.hasClass('select2-hidden-accessible')) {
                $.HSCore.components.HSSelect2.init($primaryArea);
            }

            function syncPrimaryAreaOptions() {
                const selectedAreaIds = ($areas.val() || []).map(String);
                const currentPrimaryArea = String($primaryArea.val() || '');

                $primaryArea.find('option[value!=""]').each(function () {
                    $(this).prop('disabled', !selectedAreaIds.includes(String(this.value)));
                });

                if (currentPrimaryArea && !selectedAreaIds.includes(currentPrimaryArea)) {
                    $primaryArea.val('').trigger('change.select2');
                } else {
                    $primaryArea.trigger('change.select2');
                }
            }

            $areas.on('change', syncPrimaryAreaOptions);
            syncPrimaryAreaOptions();
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/delivery-man/fleet-manager/form.blade.php ENDPATH**/ ?>