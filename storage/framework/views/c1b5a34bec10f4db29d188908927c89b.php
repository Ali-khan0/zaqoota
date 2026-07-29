<div class="row">
    <div class="col-lg-12 text-center ">
        <h1> <?php echo e(Config::get('module.current_module_type') == 'food' ? translate('Food_List') : translate('Item_List')); ?>

        </h1>
    </div>
    <div class="col-lg-12">

        <table>
            <thead>
                <tr>
                    <th><?php echo e(translate('Filter_Criteria')); ?></th>
                    <th></th>
                    <th></th>
                    <th>
                        <?php echo e(translate('Store_Name')); ?>: <?php echo e($data['store_name']); ?>

                        <br>
                        <?php echo e(translate('Zone')); ?>: <?php echo e($data['zone']); ?>

                        <br>
                        <?php echo e(translate('Total_items')); ?>: <?php echo e($data['data']->count()); ?>

                        <?php if(!(isset($data['sub_tab']) && ($data['sub_tab'] == 'pending-items' || $data['sub_tab'] == 'rejected-items'))): ?>
                            <br>
                            <?php echo e(translate('Active_Items')); ?>: <?php echo e($data['data']->where('status', 1)->count()); ?>

                            <br>
                            <?php echo e(translate('Inactive_items')); ?>: <?php echo e($data['data']->where('status', 0)->count()); ?>

                        <?php endif; ?>
                        <br>
                        <?php echo e(translate('Search_Bar_Content')); ?>: <?php echo e($data['search'] ?? translate('N/A')); ?>

                    </th>
                    <th> </th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <th><?php echo e(translate('sl')); ?></th>
                    <th><?php echo e(translate('Image')); ?></th>
                    <th><?php echo e(translate('Item_Name')); ?></th>
                    <th><?php echo e(translate('Description')); ?></th>
                    <th><?php echo e(translate('Category_Name')); ?></th>
                    <th><?php echo e(translate('Sub_Category_Name')); ?></th>
                    <?php if(Config::get('module.current_module_type') == 'food'): ?>
                        <th><?php echo e(translate('Food_Type')); ?></th>
                    <?php else: ?>
                        <th><?php echo e(translate('Available_Stock')); ?> </th>
                    <?php endif; ?>
                    <th><?php echo e(translate('Price')); ?></th>
                    <th><?php echo e(translate('Available_Variations')); ?> </th>
                    <?php if(Config::get('module.current_module_type') == 'food'): ?>
                        <th><?php echo e(translate('Available_Addons')); ?> </th>
                    <?php else: ?>
                        <th><?php echo e(translate('Item_Unit')); ?></th>
                    <?php endif; ?>
                    <th><?php echo e(translate('Discount')); ?> </th>
                    <th><?php echo e(translate('Discount_Type')); ?> </th>
                    <th><?php echo e(translate('Available_From')); ?> </th>
                    <th><?php echo e(translate('Available_Till')); ?> </th>
                    <th><?php echo e(translate('Tags')); ?> </th>
                    <th><?php echo e(translate('Status')); ?> </th>
                    <?php if($data['productWiseTax']): ?>
                        <th class="border-0 w--1"><?php echo e(translate('messages.Vat/Tax')); ?></th>
                    <?php endif; ?>
            </thead>
            <tbody>
                <?php $__currentLoopData = $data['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($loop->index + 1); ?></td>
                        <td> &nbsp;</td>
                        <td><?php echo e($item->name); ?></td>
                        <td><?php echo e($item->description); ?></td>
                        <td>
                            <?php echo e(\App\CentralLogics\Helpers::get_category_name($item->category_ids)); ?>

                        </td>
                        <td>
                            <?php echo e(\App\CentralLogics\Helpers::get_sub_category_name($item->category_ids) ?? translate('N/A')); ?>

                        </td>
                        <?php if(Config::get('module.current_module_type') == 'food'): ?>
                            <td> <?php echo e($item->veg == 1 ? translate('Veg') : translate('Non_Veg')); ?></td>
                        <?php else: ?>
                            <td><?php echo e($item->stock); ?></td>
                        <?php endif; ?>
                        <td>
                            <?php echo e(\App\CentralLogics\Helpers::format_currency($item->price)); ?>

                        </td>
                        <td>
                            <?php if(Config::get('module.current_module_type') == 'food'): ?>
                                <?php echo e(\App\CentralLogics\Helpers::get_food_variations($item->food_variations) == '  ' ? translate('N/A') : \App\CentralLogics\Helpers::get_food_variations($item->food_variations)); ?>

                            <?php else: ?>
                                <?php echo e(\App\CentralLogics\Helpers::get_attributes($item->choice_options) == '  ' ? translate('N/A') : \App\CentralLogics\Helpers::get_attributes($item->choice_options)); ?>

                            <?php endif; ?>
                        </td>

                        <td>
                            <?php if(Config::get('module.current_module_type') == 'food'): ?>
                                <?php echo e(\App\CentralLogics\Helpers::get_addon_data($item->add_ons) == 0 ? translate('N/A') : \App\CentralLogics\Helpers::get_addon_data($item->add_ons)); ?>

                            <?php else: ?>
                                <?php echo e($item?->unit?->unit ?? translate('N/A')); ?>

                            <?php endif; ?>
                        </td>
                        <td><?php echo e($item->discount == 0 ? translate('N/A') : $item->discount); ?></td>
                        <td><?php echo e($item->discount_type); ?></td>
                        <td><?php echo e(Config::get('module.current_module_type') != 'grocery' ? \Carbon\Carbon::parse($item->available_time_starts)->format('H:i A') : translate('N/A')); ?>

                        </td>
                        <td><?php echo e(Config::get('module.current_module_type') != 'grocery' ? \Carbon\Carbon::parse($item->available_time_ends)->format('H:i A') : translate('N/A')); ?>

                        </td>


                        <?php if(isset($data['sub_tab']) && ($data['sub_tab'] == 'pending-items' || $data['sub_tab'] == 'rejected-items')): ?>
                            <td>
                                <?php ($tagids = json_decode($item?->tag_ids) ?? []); ?>
                                <?php ($tags = \App\Models\Tag::whereIn('id', $tagids)->get('tag')); ?>
                                <?php $__empty_1 = true; $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php echo e($c->tag . ','); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?> <?php echo e(translate('N/A')); ?>

                                <?php endif; ?>

                            </td>
                            <td> <?php echo e($item->is_rejected == 1 ? translate('Rejected') : translate('Pending')); ?></td>
                        <?php else: ?>
                            <td>
                                <?php $__empty_1 = true; $__currentLoopData = $item->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php echo e($c->tag . ','); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?> <?php echo e(translate('N/A')); ?>

                                <?php endif; ?>
                            </td>
                            <td> <?php echo e($item->status == 1 ? translate('Active') : translate('Inactive')); ?></td>
                        <?php endif; ?>

                        <?php if($data['productWiseTax']): ?>
                            <td>
                                <span class="d-block font-size-sm text-body">

                                    <?php $__empty_1 = true; $__currentLoopData = $item?->taxVats?->pluck('tax.name', 'tax.tax_rate')->toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <br>
                                        <span> <?php echo e($tax); ?> : <span class="font-bold">
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
<?php /**PATH /var/www/zaqoota/resources/views/file-exports/store-Item.blade.php ENDPATH**/ ?>