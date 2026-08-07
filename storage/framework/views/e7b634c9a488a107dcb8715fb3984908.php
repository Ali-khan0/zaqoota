<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate('limited_stock_report')); ?></h1></div>
    <div class="col-lg-12">



    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('Search_Criteria')); ?></th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('zone' )); ?> - <?php echo e($data['zone']??translate('all')); ?>

                    <br>
                    <?php echo e(translate('store' )); ?> - <?php echo e($data['store']??translate('all')); ?>

                    <br>
                    <?php echo e(translate('Search_Bar_Content')); ?>- <?php echo e($data['search'] ??translate('N/A')); ?>


                </th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
                </tr>
        <tr>
            <th><?php echo e(translate('sl')); ?></th>
            <th><?php echo e(translate('item_image')); ?></th>
            <th><?php echo e(translate('item_name')); ?></th>
            <th><?php echo e(translate('current_stock')); ?></th>
            <th><?php echo e(translate('category_name')); ?></th>
            <th><?php echo e(translate('unit')); ?></th>
            <th><?php echo e(translate('variation')); ?></th>
            <th><?php echo e(translate('price')); ?></th>
            <th><?php echo e(translate('store_name')); ?></th>
            <th><?php echo e(translate('module_name')); ?></th>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($key+1); ?></td>
                <td></td>
                <td><?php echo e($item['name']); ?></td>
                <td>
                    <?php if($item->module->module_type != 'food'): ?>
                    <?php echo e($item->stock); ?>

                    <?php endif; ?>
                </td>
                <td>
                    <?php echo e(\App\CentralLogics\Helpers::get_category_name($item->category_ids)); ?>

                </td>
                <td><?php echo e($item?->unit?->unit ?? translate('N/A')); ?></td>
                <td>
                    <?php if($item->module->module_type == 'food'): ?>
                    <?php echo e(\App\CentralLogics\Helpers::get_food_variations($item->food_variations) == "  "  ? translate('N/A'): \App\CentralLogics\Helpers::get_food_variations($item->food_variations)); ?>

                    <?php else: ?>
                    <?php echo e(\App\CentralLogics\Helpers::get_attributes($item->choice_options) == "  "  ? translate('N/A'): \App\CentralLogics\Helpers::get_attributes($item->choice_options)); ?>

                    <?php endif; ?>
                </td>
                <td>
                    <?php echo e(\App\CentralLogics\Helpers::format_currency($item->price)); ?>

                </td>
                <td>
                    <?php if($item->store): ?>
                    <?php echo e($item->store->name); ?>

                    <?php else: ?>
                    <?php echo e(translate('messages.store_deleted')); ?>

                    <?php endif; ?>
                </td>
                <td>
                    <?php echo e($item->module->module_name); ?>

                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/limited-stock-report.blade.php ENDPATH**/ ?>