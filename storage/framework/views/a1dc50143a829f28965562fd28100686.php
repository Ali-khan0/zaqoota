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
                    <th class="border-0"><?php echo e(translate('sl')); ?></th>
                    <th class="border-0"><?php echo e(translate('messages.id')); ?></th>
                    <th class=""><?php echo e(translate('messages.Category_Name')); ?></th>
                    <?php if($data['categoryWiseTax']): ?>

                    <th class="border-0 w--1"><?php echo e(translate('messages.Vat/Tax')); ?></th>
                    <?php endif; ?>
                    <th class="border-0 text-center"><?php echo e(translate('messages.status')); ?></th>

            </thead>

            <tbody>
                <?php $__currentLoopData = $data['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($key + 1); ?></td>
                        <td><?php echo e($category->id); ?></td>
                        <td>
                            <?php echo e(Str::limit($category['name'], 20, '...')); ?>


                        </td>
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

                        <td><?php echo e($category->status == 1 ? translate('messages.Active') : translate('messages.Inactive')); ?>

                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/addon-category-export.blade.php ENDPATH**/ ?>