<?php $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td><?php echo e($key+1); ?></td>
        <td>
            <a href="<?php echo e(route('admin.campaign.view',['item',$campaign->id])); ?>" class="d-block text-body"><?php echo e(Str::limit($campaign['title'],25,'...')); ?></a>
        </td>
        <td>
            <span class="bg-gradient-light text-dark"><?php echo e($campaign->start_date?$campaign->start_date->format('d/M/Y'). ' - ' .$campaign->end_date->format('d/M/Y'): 'N/A'); ?></span>
        </td>
        <td>
            <span class="bg-gradient-light text-dark"><?php echo e($campaign->start_time?$campaign->start_time->format(config('timeformat')). ' - ' .$campaign->end_time->format(config('timeformat')): 'N/A'); ?></span>
        </td>
        <td><?php echo e($campaign->price); ?></td>
        <td>
            <div class="d-flex flex-wrap justify-content-center">
                <label class="toggle-switch toggle-switch-sm" for="campaignCheckbox<?php echo e($campaign->id); ?>">
                    <input type="checkbox" data-url="<?php echo e(route('admin.campaign.status',['item',$campaign['id'],$campaign->status?0:1])); ?>" class="toggle-switch-input redirect-url" id="campaignCheckbox<?php echo e($campaign->id); ?>" <?php echo e($campaign->status?'checked':''); ?>>
                    <span class="toggle-switch-label">
                        <span class="toggle-switch-indicator"></span>
                    </span>
                </label>
            </div>
        </td>
        <td>
            <div class="btn--container justify-content-center">
                <a class="btn action-btn btn--primary btn-outline-primary"
                    href="<?php echo e(route('admin.campaign.edit',['item',$campaign['id']])); ?>" title="<?php echo e(translate('messages.edit_campaign')); ?>"><i class="tio-edit"></i>
                </a>
                <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:"
                   data-id="campaign-<?php echo e($campaign['id']); ?>" data-message="<?php echo e(translate('Want to delete this item ?')); ?>" title="<?php echo e(translate('messages.delete_campaign')); ?>"><i class="tio-delete-outlined"></i>
                </a>
                <form action="<?php echo e(route('admin.campaign.delete-item',[$campaign['id']])); ?>"
                            method="post" id="campaign-<?php echo e($campaign['id']); ?>">
                    <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                </form>
            </div>
        </td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/campaign/item/partials/_table.blade.php ENDPATH**/ ?>