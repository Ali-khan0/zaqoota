<?php $__currentLoopData = $expense; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td scope="row"><?php echo e($k+1); ?></td>
    <td><label class="text-uppercase"><?php echo e($exp['type']); ?></label></td>
    <td><div class="pl-4">
        <?php echo e(\App\CentralLogics\Helpers::format_currency($exp['amount'])); ?>

    </div></td>
    <td><div class="pl-4">
        <?php echo e($exp['description']); ?>

    </div></td>
    <td><?php echo e(date('Y-m-d '.config('timeformat'),strtotime($exp->created_at))); ?></td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/report/partials/_expense_table.blade.php ENDPATH**/ ?>