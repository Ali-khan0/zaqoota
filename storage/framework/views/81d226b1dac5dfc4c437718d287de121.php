
<div class="row">
    <div class="col-lg-12 text-center "><h1 > <?php echo e(translate('Banner_List')); ?>

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
            <th><?php echo e(translate('Banner_Title')); ?></th>
            <th><?php echo e(translate('Banner_Type')); ?></th>
            <th><?php echo e(translate('Provider')); ?></th>
            <th><?php echo e(translate('Url')); ?></th>
            <th><?php echo e(translate('Featured')); ?></th>
            <th><?php echo e(translate('Status')); ?></th>

        </thead>
        <tbody>
        <?php $__currentLoopData = $data['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
        <td><?php echo e($loop->index+1); ?></td>
        <td><?php echo e($brand->title); ?></td>
        <td><?php echo e($brand->type == 'store_wise' ? translate('Provider_Wise') :translate('messages.default')); ?></td>

        <td><?php echo e($brand->type == 'store_wise' ?  $brand?->store?->name ?? "----------" : "-------------"); ?></td>

        <td><?php echo e($brand?->default_link ?? '-------------'); ?></td>

        <td><?php echo e($brand->featured == 1 ? translate('messages.Yes') : translate('messages.No')); ?></td>
        <td><?php echo e($brand->status == 1 ? translate('messages.Active') : translate('messages.Inactive')); ?></td>

            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/file-exports/banner-export.blade.php ENDPATH**/ ?>