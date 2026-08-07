
<div class="row">
    <div class="col-lg-12 text-center "><h1 > <?php echo e(translate('Attributes_List')); ?>

    </h1></div>
    <div class="col-lg-12">

    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('Filter_Criteria')); ?></th>
                <th></th>
                <th>
                    <?php echo e(translate('Search_Bar_Content')); ?>: <?php echo e($data['search'] ?? translate('N/A')); ?>


                </th>
                <th> </th>
                </tr>


        <tr>
            <th><?php echo e(translate('sl')); ?></th>
            <th><?php echo e(translate('Unit')); ?></th>
            <th><?php echo e(translate('ID')); ?></th>

        </thead>
        <tbody>
        <?php $__currentLoopData = $data['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
        <td><?php echo e($loop->index+1); ?></td>
        <td><?php echo e($attribute->unit); ?></td>
        <td><?php echo e($attribute->id); ?></td>

            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/unit.blade.php ENDPATH**/ ?>