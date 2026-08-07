
<div class="row">
    <div class="col-lg-12 text-center "><h1 > <?php echo e(translate('Module_List')); ?>

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
            <th><?php echo e(translate('name')); ?></th>
            <th><?php echo e(translate('module_id')); ?></th>
            <th><?php echo e(translate('business_Module_type')); ?></th>
            <th><?php echo e(translate('total_stores')); ?></th>
            <th><?php echo e(translate('Status')); ?></th>

        </thead>
        <tbody>
        <?php $__currentLoopData = $data['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
        <td><?php echo e($loop->index+1); ?></td>
        <td><?php echo e($addon->module_name); ?></td>
        <td><?php echo e($addon->id); ?></td>
        <td>
            <?php echo e(translate($addon->module_type)); ?>

        </td>
        <td>
            <?php echo e($addon->stores_count); ?>

        </td>

        <td><?php echo e($addon?->status == 1 ? translate('Active') : translate('Inactive')); ?></td>

            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/module.blade.php ENDPATH**/ ?>