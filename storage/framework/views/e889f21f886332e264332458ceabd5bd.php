<?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td class="pl-4"><?php echo e($key+1); ?></td>
    <td><?php echo e($module->id); ?></td>
    <td>
        <span class="d-block font-size-sm text-body">
            <?php echo e(Str::limit($module['module_name'], 20,'...')); ?>

        </span>
    </td>
    <td>
        <span class="d-block font-size-sm text-body text-capitalize">
            <?php echo e(Str::limit($module['module_type'], 20,'...')); ?>

        </span>
    </td>
    <td>
        <label class="toggle-switch toggle-switch-sm" for="status-<?php echo e($module->id); ?>">
            <input type="checkbox" class="toggle-switch-input dynamic-checkbox"
                   data-id="status-<?php echo e($module->id); ?>"
                   data-type="status"
                   data-image-on='<?php echo e(asset('/public/assets/admin/img/modal')); ?>/module-on.png'
                   data-image-off="<?php echo e(asset('/public/assets/admin/img/modal')); ?>/module-off.png"
                   data-title-on="<?php echo e(translate('Want_to_activate_this')); ?> <strong><?php echo e(translate('Business_Module?')); ?></strong>','<?php echo e(translate('Want_to_deactivate_this')); ?> <strong><?php echo e(translate('Business_Module?')); ?></strong>"
                   data-title-off="<p><?php echo e(translate('If_you_activate_this_business_module,_all_its_features_and_functionalities_will_be_available_and_accessible_to_all_users.')); ?></p>"
                   data-text-on="<p><?php echo e(translate('If_you_deactivate_this_business_module,_all_its_features_and_functionalities_will_be_disabled_and_hidden_from_users.')); ?></p>"
                   data-text-off=""
                   class="toggle-switch-input" id="status-<?php echo e($module->id); ?>" <?php echo e($module->status?'checked':''); ?>>
            <span class="toggle-switch-label">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
        </label>
        <form action="<?php echo e(route('admin.business-settings.module.status',[$module['id'],$module->status?0:1])); ?>" method="get" id="status-<?php echo e($module->id); ?>_form">
        </form>
    </td>
    <td class="text-center"><?php echo e($module->stores_count); ?></td>
    <td>
        <div class="btn--container justify-content-center">
            <a class="btn action-btn btn--primary btn-outline-primary"
                href="<?php echo e(route('admin.business-settings.module.edit',[$module['id']])); ?>" title="<?php echo e(translate('messages.edit_Business_Module')); ?>"><i class="tio-edit"></i>
            </a>
        </div>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/module/partials/_table.blade.php ENDPATH**/ ?>