<div class="row">
    <div class="col-lg-12 text-center ">
        <h1><?php echo e(translate($data['taxSource'])); ?> <?php echo e(translate('Tax_Details_Report')); ?></h1>
    </div>
    <div class="col-lg-12">



        <table>
            <thead>
                <tr>
                    <th><?php echo e(translate('Search_Criteria')); ?></th>
                    <th></th>
                    <th></th>
                    <th>

                        
                           <br>
                        <?php echo e(translate('total_tax_amount')); ?> - <?php echo e(\App\CentralLogics\Helpers::format_currency($data['total_tax_amount']) ?? 0); ?>

                        <br>
                        <?php echo e(translate('total_amount')); ?> - <?php echo e(\App\CentralLogics\Helpers::format_currency($data['total_amount'])); ?>


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

                        
                        <br>

                    </th>
                    <th> </th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <th class="border-0"><?php echo e(translate('sl')); ?></th>
                    <th class="border-0"><?php echo e(translate('Transaction ID')); ?></th>
                    <th class="border-0"><?php echo e(translate('Amount')); ?></th>
                    <th class="border-0"><?php echo e(translate('Tax Amount')); ?></th>
            </thead>
            <tbody>
                <?php $__currentLoopData = $data['taxData']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <?php echo e($key + 1); ?>

                        </td>
                        <td>
                            <?php echo e($item->id); ?>

                        </td>
                        <td>
                            <?php echo e(\App\CentralLogics\Helpers::format_currency($item->paid_amount)); ?>

                        </td>

                        <td>
                            <?php
                                $taxSummary = collect($item['calculated_taxes']);
                                $totalTaxRate = $taxSummary->sum('tax_rate');
                                $totalTaxAmount = $taxSummary->sum('tax_amount');
                            ?>

                            <div class="d-flex flex-column gap-1">
                                <div class="d-flex fz-14 gap-3 align-items-center title-clr">
                                    <?php echo e(translate('Total')); ?> (<?php echo e($totalTaxRate); ?>%):
                                    <span>
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($totalTaxAmount)); ?></span>
                                </div>,
                                <br>
                                <?php $__currentLoopData = $item['calculated_taxes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxItems): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="d-flex fz-11 gap-3 align-items-center">
                                        <?php echo e($taxItems['tax_name']); ?> (<?php echo e($taxItems['tax_rate']); ?>%) :
                                        <span><?php echo e(\App\CentralLogics\Helpers::format_currency($taxItems['tax_amount'])); ?></span>
                                    </div>, <br>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div>
                        </td>

                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/admin-subscription-tax-details-report.blade.php ENDPATH**/ ?>