<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate('item_report')); ?></h1></div>
    <div class="col-lg-12">



    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('Search_Criteria')); ?></th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('module' )); ?> - <?php echo e($data['module']?translate($data['module']):translate('all')); ?>

                    <br>
                    <?php echo e(translate('zone' )); ?> - <?php echo e($data['zone']??translate('all')); ?>

                    <br>
                    <?php echo e(translate('store' )); ?> - <?php echo e($data['store']??translate('all')); ?>

                    <?php if($data['from']): ?>
                    <br>
                    <?php echo e(translate('from' )); ?> - <?php echo e($data['from']?Carbon\Carbon::parse($data['from'])->format('d M Y'):''); ?>

                    <?php endif; ?>
                    <?php if($data['to']): ?>
                    <br>
                    <?php echo e(translate('to' )); ?> - <?php echo e($data['to']?Carbon\Carbon::parse($data['to'])->format('d M Y'):''); ?>

                    <?php endif; ?>
                    <br>
                    <?php echo e(translate('filter')); ?>- <?php echo e(translate($data['filter'])); ?>

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
            <th><?php echo e(translate('messages.item_image')); ?></th>
            <th><?php echo e(translate('messages.item_name')); ?></th>
            <th><?php echo e(translate('messages.module')); ?></th>
            <th><?php echo e(translate('messages.store_name')); ?></th>
            <th><?php echo e(translate('messages.stock')); ?></th>
            <th><?php echo e(translate('messages.total_order_count')); ?></th>
            <th><?php echo e(translate('messages.unit_price')); ?></th>
            <th><?php echo e(translate('messages.total_amount_sold')); ?></th>
            <th><?php echo e(translate('messages.total_discount_given')); ?></th>
            <th><?php echo e(translate('messages.average_sale_value')); ?></th>
            <th><?php echo e(translate('messages.total_ratings_given')); ?></th>
            <th><?php echo e(translate('messages.average_ratings')); ?></th>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($key+1); ?></td>
                <td></td>
                <td><?php echo e($item['name']); ?></td>
                <td>
                    <?php echo e($item->module->module_name); ?>

                </td>
                <td>
                    <?php if($item->store): ?>
                    <?php echo e($item->store->name); ?>

                    <?php else: ?>
                    <?php echo e(translate('messages.store_deleted')); ?>

                    <?php endif; ?>
                </td>
                <td>
                    <?php echo e($item->module->module_type == 'food'? translate('N/A') : $item->stock); ?>

                </td>
                <td>
                    <?php echo e($item->orders_sum_quantity ?? 0); ?>

                </td>
                <td>
                    <?php echo e(\App\CentralLogics\Helpers::format_currency($item->price)); ?>

                </td>
                <td>
                    <?php echo e(\App\CentralLogics\Helpers::format_currency($item->orders_sum_price)); ?>

                </td>
                <td>
                    <?php echo e(\App\CentralLogics\Helpers::format_currency($item->total_discount)); ?>

                </td>
                <td>
                    <?php echo e($item->orders_count>0? \App\CentralLogics\Helpers::format_currency(($item->orders_sum_price-$item->total_discount)/($item->orders_sum_quantity ?? 0) ) :0); ?>

                </td>
                <td><?php echo e($item->rating_count); ?></td>
                <td><?php echo e(round($item->avg_rating,1)); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/item-report.blade.php ENDPATH**/ ?>