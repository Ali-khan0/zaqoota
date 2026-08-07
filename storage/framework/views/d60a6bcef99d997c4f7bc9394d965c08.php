<div class="row">
    <div class="col-lg-12 text-center ">
        <h1> <?php echo e(translate('Category_List')); ?>

        </h1>
    </div>
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
                    <th><?php echo e(translate('Category_Name')); ?></th>
                    <th><?php echo e(translate('Category_ID')); ?></th>
                    <th><?php echo e(translate('Module')); ?></th>
                    <th><?php echo e(translate('Priority')); ?></th>
                    <th><?php echo e(translate('Featured')); ?></th>
                    <?php if($data['categoryWiseTax']): ?>
                        <th class="border-0 w--1"><?php echo e(translate('messages.Vat/Tax')); ?></th>
                    <?php endif; ?>
                    <th><?php echo e(translate('Status')); ?></th>

            </thead>
            <tbody>
                <?php $__currentLoopData = $data['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($loop->index + 1); ?></td>
                        <td><?php echo e($category->name); ?></td>
                        <td><?php echo e($category->id); ?></td>
                        <td><?php echo e($category?->module?->module_name); ?></td>
                        <?php
                            $return_value = match ($category->priority) {
                                0 => translate('messages.normal'),
                                1 => translate('messages.medium'),
                                2 => translate('messages.high'),
                            };
                        ?>
                        <td><?php echo e($return_value); ?></td>
                        <td><?php echo e($category->featured == 1 ? translate('messages.Yes') : '--'); ?> </td>
                        <?php if($data['categoryWiseTax']): ?>
                        <td>
                            <span class="d-block font-size-sm text-body">

                                <?php $__empty_1 = true; $__currentLoopData = $category?->taxVats?->pluck('tax.name', 'tax.tax_rate')->toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <br>
                                <span> <?php echo e($item); ?> : <span class="font-bold">
                                    (<?php echo e($key); ?>%)
                                </span> </span>
                                <br>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <span> <?php echo e(translate('messages.no_tax')); ?> </span>
                                <?php endif; ?>
                            </span>
                        </td>
                        <?php endif; ?>
                        <td><?php echo e($category->status == 1 ? translate('messages.Active') : translate('messages.Inactive')); ?>  </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/category-export.blade.php ENDPATH**/ ?>