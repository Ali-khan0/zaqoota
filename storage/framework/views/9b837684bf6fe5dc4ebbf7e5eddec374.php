<div class="row">
    <div class="col-lg-12 text-center ">
        <h1><?php echo e(translate('Vendor_Vat_Report')); ?></h1>
    </div>
    <div class="col-lg-12">



        <table>
            <thead>
                <tr>
                    <th><?php echo e(translate('Summary')); ?></th>
                    <th></th>
                    <th></th>
                    <th>

                        <?php if(isset($data['summary'])): ?>
                            
                            <br>
                            <?php echo e(translate('total_order_amount')); ?> - <?php echo e(\App\CentralLogics\Helpers::format_currency($data['summary']->total_order_amount ?? 0)); ?>

                            <br>
                            <?php echo e(translate('total_tax')); ?> - <?php echo e(\App\CentralLogics\Helpers::format_currency($data['summary']->total_tax ?? 0)); ?>

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
                    <th class="border-0"><?php echo e(translate('messages.order_id')); ?></th>
                    <th class="border-0"><?php echo e(translate('messages.order_amount')); ?></th>
                    <th class="border-0"><?php echo e(translate('messages.tax_type')); ?></th>
                    <th class="border-0"><?php echo e(translate('messages.tax_amount')); ?></th>
            </thead>
            <tbody>
                <?php $__currentLoopData = $data['orders']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <?php echo e($key + 1); ?>

                        </td>
                        <td>
                            #<?php echo e($order->id); ?>

                        </td>
                        <td>
                            <?php echo e(\App\CentralLogics\Helpers::format_currency($order->order_amount)); ?>

                        </td>
                        <td>
                            <?php echo e(translate($order?->tax_type ?? 'order_wise')); ?>

                        </td>
                        <td>
                                        <?php
                                        if ($order?->tax_type == 'category_wise') {
                                            $tax_type = 'category_tax';
                                        } elseif ($order?->tax_type == 'product_wise') {
                                            $tax_type = 'product_tax';
                                        } else {
                                            $tax_type = 'order_wise';
                                        }

                                        $taxLabels = [
                                            'basic' => translate($tax_type),
                                            'tax_on_packaging_charge' => translate('Packaging Charge'),
                                        ];

                                        $groupedByTaxOn = $order->orderTaxes->groupBy('tax_on');
                                        $totalTaxAmount = $order->orderTaxes->sum('tax_amount');
                                        ?>

                                        <div class="d-flex flex-column gap-1">
                                            <?php if(count($order->orderTaxes) > 0): ?>
                                                <div class="fw-bold">
                                                    <?php echo e(translate('Total Tax')); ?>:
                                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($totalTaxAmount)); ?>

                                                </div>, <br>

                                                <?php $__currentLoopData = $groupedByTaxOn; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxOn => $taxGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if(isset($taxLabels[$taxOn])): ?>
                                                        <div class="mt-2 text-capitalize fw-semibold">
                                                            <?php echo e($taxLabels[$taxOn]); ?>:</div> <br>

                                                        <?php

                                                            $taxByName = $taxGroup
                                                                ->groupBy('tax_name')
                                                                ->map(function ($group) {
                                                                    return $group->sum('tax_amount');
                                                                });
                                                        ?>

                                                        <?php $__currentLoopData = $taxByName; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $amount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="d-flex fz-11 gap-3 align-items-center">
                                                                <span><?php echo e($name); ?> :</span>
                                                                <span><?php echo e(\App\CentralLogics\Helpers::format_currency($amount)); ?></span>
                                                            </div> <br>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                <div class="d-flex fz-14 gap-3 align-items-center title-clr">
                                                    <?php echo e(translate('Tax Amount:')); ?> <span>
                                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($order->total_tax_amount)); ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/vendor-tax-report.blade.php ENDPATH**/ ?>