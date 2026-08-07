<div class="row">
    <div class="col-lg-12 text-center "><h1 > <?php echo e(Config::get('module.current_module_type')== 'food' ?  translate('Food_Campaign_List') : translate('Item_Campaign_List')); ?>

    </h1></div>
    <div class="col-lg-12">

    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('Filter_Criteria')); ?></th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('Module')); ?>: <?php echo e($module_name); ?>

                    <br>
                    <?php echo e(translate('Search_Bar_Content')); ?>: <?php echo e($search ??translate('N/A')); ?>

                </th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
                </tr>


        <tr>
            <th><?php echo e(translate('sl')); ?></th>
            <th><?php echo e(translate('Item_Name')); ?></th>
            <th><?php echo e(translate('Description')); ?></th>
            <th><?php echo e(translate('Category_Name')); ?></th>
            <th><?php echo e(translate('Sub_Category_Name')); ?></th>
            <th><?php echo e(translate('Item_Unit')); ?></th>
            <th><?php echo e(translate('Price')); ?></th>
            <th><?php echo e(translate('Available_Variations')); ?> </th>
            <th><?php echo e(translate('Discount')); ?> </th>
            <th><?php echo e(translate('Discount_Type')); ?> </th>
            <?php if(Config::get('module.current_module_type') != 'food'): ?>
            <th><?php echo e(translate('Available_Stock')); ?> </th>
            <?php endif; ?>


            <th><?php echo e(translate('Start_Date')); ?> </th>
            <th><?php echo e(translate('End_Date')); ?> </th>
            <th><?php echo e(translate('Daily_Start_Time')); ?> </th>
            <th><?php echo e(translate('Daily_End_Time')); ?> </th>
            <th><?php echo e(translate('Store_Name')); ?> </th>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
        <td><?php echo e($loop->index+1); ?></td>
        <td><?php echo e($campaign->title); ?></td>
        <td><?php echo e($campaign->description); ?></td>
        <td>
            <?php echo e(\App\CentralLogics\Helpers::get_category_name($campaign->category_ids)); ?>

        </td>
        <td>
        <?php echo e(\App\CentralLogics\Helpers::get_sub_category_name($campaign->category_ids) ?? translate('N/A')); ?>

        </td>

        <td><?php echo e($campaign?->unit?->unit ?? translate('N/A')); ?></td>
        <td>
            <?php echo e(\App\CentralLogics\Helpers::format_currency($campaign->price)); ?>

        </td>
        <td>
            <?php if(Config::get('module.current_module_type') == 'food'): ?>
            <?php echo e(\App\CentralLogics\Helpers::get_food_variations($campaign->food_variations) == "  "  ? translate('N/A'): \App\CentralLogics\Helpers::get_food_variations($campaign->food_variations)); ?>

            <?php else: ?>
            <?php echo e(\App\CentralLogics\Helpers::get_attributes($campaign->choice_options) == "  "  ? translate('N/A'): \App\CentralLogics\Helpers::get_attributes($campaign->choice_options)); ?>

            <?php endif; ?>
        </td>
        <td><?php echo e($campaign->discount); ?></td>
        <td><?php echo e($campaign->discount_type); ?></td>


        <?php if(Config::get('module.current_module_type') != 'food'): ?>
            <td><?php echo e($campaign->stock); ?></td>
        <?php endif; ?>

        <td><?php echo e($campaign->start_date->format('d M Y')); ?></td>
        <td><?php echo e($campaign->end_date->format('d M Y')); ?></td>
        <td><?php echo e(\Carbon\Carbon::parse($campaign->start_time)->format("H:i A")); ?></td>
        <td><?php echo e(\Carbon\Carbon::parse($campaign->end_time)->format("H:i A")); ?></td>
        <td><?php echo e($campaign?->store?->name); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/item-campaign.blade.php ENDPATH**/ ?>