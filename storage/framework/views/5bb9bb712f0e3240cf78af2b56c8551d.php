<div class="row">
    <div class="col-lg-12 text-center ">
        <h1> <?php echo e(translate('Addon_List')); ?>

        </h1>
    </div>
    <div class="col-lg-12">

        <table>
            <thead>
                <tr>
                    <th><?php echo e(translate('Filter_Criteria')); ?></th>
                    <th></th>
                    <th>
                        <?php echo e(translate('Store')); ?>: <?php echo e($data['store'] ?? translate('N/A')); ?>

                        <br>
                        <?php echo e(translate('Search_Bar_Content')); ?>: <?php echo e($data['search'] ?? translate('N/A')); ?>


                    </th>
                    <th> </th>
                </tr>


                <tr>
                    <th><?php echo e(translate('sl')); ?></th>
                    <th><?php echo e(translate('Addon_Name')); ?></th>
                    <th><?php echo e(translate('Price')); ?></th>
                    <th><?php echo e(translate('Store_name')); ?></th>


                    <?php if($data['productWiseTax']): ?>
                        <th class="border-0 w--1"><?php echo e(translate('messages.Vat/Tax')); ?></th>
                    <?php endif; ?>

            </thead>
            <tbody>
                <?php $__currentLoopData = $data['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($loop->index + 1); ?></td>
                        <td><?php echo e($addon->name); ?></td>
                        <td>
                            <?php echo e(\App\CentralLogics\Helpers::format_currency($addon->price)); ?>

                        </td>
                        <td><?php echo e($addon?->store?->name ?? translate('N/A')); ?></td>


                        <?php if($data['productWiseTax']): ?>
                            <td>
                                <span class="d-block font-size-sm text-body">

                                    <?php $__empty_1 = true; $__currentLoopData = $addon?->taxVats?->pluck('tax.name', 'tax.tax_rate')->toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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

                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/addon.blade.php ENDPATH**/ ?>