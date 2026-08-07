<?php $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td><?php echo e($key+1); ?></td>
    <td>
        <span class="d-block text-body"><?php echo e(Str::limit($campaign['title'],25,'...')); ?>

        </span>
    </td>
    <td>
        <span class="bg-gradient-light text-dark"><?php echo e($campaign->start_date?$campaign->start_date->format('d M, Y'). ' - ' .$campaign->end_date->format('d M, Y'): 'N/A'); ?></span>
    </td>
    <td>
        <span class="bg-gradient-light text-dark"><?php echo e($campaign->start_time?$campaign->start_time->format(config('timeformat')). ' - ' .$campaign->end_time->format(config('timeformat')): 'N/A'); ?></span>
    </td>
    <td><?php echo e($campaign->price); ?></td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/campaign/partials/_item_table.blade.php ENDPATH**/ ?>