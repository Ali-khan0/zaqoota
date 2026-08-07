<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate('store_sales_reports')); ?></h1></div>
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
                <th><?php echo e(translate('Analytics')); ?></th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('gross_sale')); ?>- <?php echo e(\App\CentralLogics\Helpers::number_format_short($data['orders']->sum('order_amount'))); ?>

                    <br>
                    <?php echo e(translate('total_tax')); ?>- <?php echo e(\App\CentralLogics\Helpers::number_format_short($data['orders']->sum('total_tax_amount'))); ?>

                    <br>
                    <?php echo e(translate('total_commission')); ?>- <?php echo e(\App\CentralLogics\Helpers::number_format_short($data['orders']->sum('transaction_sum_admin_commission')-$data['orders']->sum('transaction_sum_fleet_manager_commission'))); ?>

                    <br>
                    <?php echo e(translate('total_store_earning')); ?>- <?php echo e(\App\CentralLogics\Helpers::number_format_short($data['orders']->sum('transaction_sum_store_amount'))); ?>

                </th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        <tr>
            <th><?php echo e(translate('sl')); ?></th>
            <th><?php echo e(translate('product_image')); ?></th>
            <th><?php echo e(translate('Product_name')); ?></th>
            <th><?php echo e(translate('Available_Variations')); ?></th>
            <th><?php echo e(translate('QTY_Sold')); ?></th>
            <th>
                <?php echo e(translate('Gross_Sale')); ?></th>
            <th>
                <?php echo e(translate('Discount_Given')); ?></th>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($key+1); ?></td>
            <td></td>
            <td><?php echo e($item['name']); ?></td>
            <td>
                <?php if($item->module->module_type == 'food'): ?>
                <?php echo e(\App\CentralLogics\Helpers::get_food_variations($item->food_variations) == "  "  ? translate('N/A'): \App\CentralLogics\Helpers::get_food_variations($item->food_variations)); ?>

                <?php else: ?>
                <?php echo e(\App\CentralLogics\Helpers::get_attributes($item->choice_options) == "  "  ? translate('N/A'): \App\CentralLogics\Helpers::get_attributes($item->choice_options)); ?>

                <?php endif; ?>
            </td>
            <td>
                <?php echo e($item->orders_sum_quantity ?? 0); ?>

            </td>
            <td>
                <?php echo e(\App\CentralLogics\Helpers::format_currency($item->orders_sum_price)); ?>

            </td>
            <td>
                <?php echo e(\App\CentralLogics\Helpers::format_currency($item->total_discount)); ?>

            </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/store-sales-report.blade.php ENDPATH**/ ?>