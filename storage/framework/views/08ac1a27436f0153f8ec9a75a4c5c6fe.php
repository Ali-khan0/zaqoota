<div class="row">
    <div class="col-lg-12 text-center ">
        <h1><?php echo e(translate('Provider_Tax_Reports')); ?></h1>
    </div>
    <div class="col-lg-12">



        <table>
            <thead>
                <tr>
                    <th><?php echo e(translate('Search_Criteria')); ?></th>
                    <th></th>
                    <th></th>
                    <th>

                        <?php if(isset($data['summary'])): ?>
                            <br>
                            <?php echo e(translate('total_Trips')); ?> - <?php echo e(\App\CentralLogics\Helpers::format_currency($data['summary']->total_orders ??0)); ?>

                            <br>
                            <?php echo e(translate('total_Trip_amount')); ?> - <?php echo e(\App\CentralLogics\Helpers::format_currency($data['summary']->total_order_amount ??0)); ?>

                            <br>
                            <?php echo e(translate('total_tax')); ?> - <?php echo e(\App\CentralLogics\Helpers::format_currency($data['summary']->total_tax ??0)); ?>

                        <?php endif; ?>
                        <?php if($data['from']): ?>
                            <br>
                            <?php echo e(translate('from')); ?> -
                            <?php echo e($data['from'] ? Carbon\Carbon::parse($data['from'])->format('d M Y') : ''); ?>

                        <?php endif; ?>
                        <?php if($data['to']): ?>
                            <br>
                            <?php echo e(translate('to')); ?> -
                            <?php echo e($data['to'] ? Carbon\Carbon::parse($data['to'])->format('d M Y') : ''); ?>

                        <?php endif; ?>
                        <br>

                        <?php echo e(translate('Search_Bar_Content')); ?>- <?php echo e($data['search'] ?? translate('N/A')); ?>

                        <br>

                    </th>
                    <th> </th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <th class="border-0"><?php echo e(translate('sl')); ?></th>
                    <th class="border-0"><?php echo e(translate('Provider Info')); ?></th>
                    <th class="border-0"><?php echo e(translate('Total Trips')); ?></th>
                    <th class="border-0"><?php echo e(translate('Total Trip Amount')); ?></th>
                    <th class="border-0"><?php echo e(translate('Tax Amount')); ?></th>
            </thead>
            <tbody>
                <?php $__currentLoopData = $data['stores']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <?php echo e($key +1); ?>

                        </td>
                        <td>
                            <span class="fz-14 title-clr">
                                <?php echo e($store->store_name); ?>

                                <span class="fz-11 d-block"><?php echo e($store->store_phone); ?></span>
                            </span>
                        </td>
                        <td>
                            <?php echo e($store->total_orders); ?>

                        </td>
                        <td>
                            <?php echo e(\App\CentralLogics\Helpers::format_currency($store->total_order_amount)); ?>

                        </td>
                      <td>
                                        <?php ($sum_tax_amount=collect($store->tax_data)->sum('total_tax_amount')); ?>

                                        <div class="d-flex flex-column gap-1">
                                            <?php if($store->store_total_tax_amount - $sum_tax_amount> 0 ): ?>

                                            <div class="d-flex fz-14 gap-3 align-items-center title-clr">
                                                <?php echo e(translate('Tax Amount:')); ?> <span>
                                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($store->store_total_tax_amount - $sum_tax_amount)); ?></span>
                                            </div> <br>
                                            <?php endif; ?>
                                            <?php if($sum_tax_amount > 0 ): ?>
                                                <div class="d-flex fz-14 gap-3 align-items-center title-clr">
                                                    <?php echo e(translate('Sum of Taxes:')); ?> <span>
                                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($sum_tax_amount)); ?></span>
                                                </div> <br>
                                                <?php $__currentLoopData = $store->tax_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="d-flex fz-11 gap-3 align-items-center">
                                                        <?php echo e($tax['tax_name']); ?>:
                                                        <span><?php echo e(\App\CentralLogics\Helpers::format_currency($tax['total_tax_amount'])); ?>

                                                    </span>
                                                    </div> <br>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            <?php endif; ?>
                                        </div>
                                    </td>

                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/file-exports/provider-wise-tax-report.blade.php ENDPATH**/ ?>