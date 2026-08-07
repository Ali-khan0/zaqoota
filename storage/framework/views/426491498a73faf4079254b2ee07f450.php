
<div class="row">
    <div class="col-lg-12 text-center "><h1 > <?php echo e(translate('Tax_List')); ?>

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
             <th class="border-0"><?php echo e(translate('sl')); ?></th>
            <th class="border-0"><?php echo e(translate('messages.tax_name')); ?></th>
            <th class="border-0"><?php echo e(translate('messages.tax_rate')); ?></th>
            <th class="border-0 text-end"><?php echo e(translate('messages.status')); ?></th>

        </thead>
        <tbody>
        <?php $__currentLoopData = $data['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $taxVat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
        <td><?php echo e($loop->index+1); ?></td>
        <td><?php echo e($taxVat->name); ?></td>
        <td><?php echo e($taxVat->tax_rate); ?> %</td>
        <td><?php echo e($taxVat->is_active == 1 ? translate('messages.Active') : translate('messages.Inactive')); ?></td>

            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/TaxModule/Resources/views/file-exports/tax_list_export.blade.php ENDPATH**/ ?>