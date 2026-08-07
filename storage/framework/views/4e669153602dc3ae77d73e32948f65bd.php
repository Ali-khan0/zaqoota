<?php $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td><?php echo e($key+1); ?></td>
    <td>
        <a href="<?php echo e(route('admin.campaign.view',['basic',$campaign->id])); ?>" class="d-block text-body"><?php echo e(Str::limit($campaign['title'],25, '...')); ?></a>
    </td>
    <td><?php echo e(Str::limit($campaign->module->module_name, 15, '...')); ?></td>
    <td>
        <span class="bg-gradient-light text-dark"><?php echo e($campaign->start_date?$campaign->start_date->format('d/M/Y'). ' - ' .$campaign->end_date->format('d/M/Y'): 'N/A'); ?></span>
    </td>
    <td>
        <span class="bg-gradient-light text-dark text-uppercase"><?php echo e($campaign->start_time?date(config('timeformat'),strtotime($campaign->start_time)). ' - ' .date(config('timeformat'),strtotime($campaign->end_time)): 'N/A'); ?></span>
    </td>
    <td>
        <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox<?php echo e($campaign->id); ?>">
            <input type="checkbox" data-url="<?php echo e(route('admin.campaign.status',['basic',$campaign['id'],$campaign->status?0:1])); ?>" class="toggle-switch-input redirect-url" id="stocksCheckbox<?php echo e($campaign->id); ?>" <?php echo e($campaign->status?'checked':''); ?>>
            <span class="toggle-switch-label">
                <span class="toggle-switch-indicator"></span>
            </span>
        </label>
    </td>
    <td>
        <div class="btn--container justify-content-center">
            <a class="btn action-btn btn-outline-primary btn--primary"
                href="<?php echo e(route('admin.campaign.edit',['basic',$campaign['id']])); ?>" title="<?php echo e(translate('messages.edit_campaign')); ?>"><i class="tio-edit"></i>
            </a>
            <a class="btn action-btn btn-outline-danger btn--danger form-alert" href="javascript:" data-id="campaign-<?php echo e($campaign['id']); ?>" data-message="<?php echo e(translate('messages.Want_to_delete_this_item')); ?>"
               title="<?php echo e(translate('messages.delete_campaign')); ?>"><i class="tio-delete-outlined"></i>
            </a>
            <form action="<?php echo e(route('admin.campaign.delete',[$campaign['id']])); ?>"
                            method="post" id="campaign-<?php echo e($campaign['id']); ?>">
                <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
            </form>
        </div>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/campaign/basic/partials/_table.blade.php ENDPATH**/ ?>