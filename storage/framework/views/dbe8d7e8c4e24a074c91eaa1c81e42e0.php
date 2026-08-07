<div class="row">
    <div class="col-lg-12 text-center ">
        <h1> <?php echo e(translate('Admin_Tax_Report')); ?></h1>
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
                    <th class="border-0"><?php echo e(translate('messages.sl')); ?></th>
                    <th class="border-0"><?php echo e(translate('Income Source')); ?></th>
                    <th class="border-0"><?php echo e(translate('Total Income')); ?></th>
                    <th class="border-0"><?php echo e(translate('Total Tax')); ?></th>
            </thead>
            <tbody>
                <?php
                    $count = 1;
                ?>
                <?php $__currentLoopData = $data['taxData']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <?php echo e($count++); ?>


                        </td>
                        <td>
                            <?php echo e(translate($key)); ?>

                        </td>
                        <td>

                            <?php echo e(\App\CentralLogics\Helpers::format_currency($item['total_base_amount'])); ?>

                        </td>
                        <td>
                            <?php
                                $totalTaxAmount = collect($item['taxes'] ?? [])
                                    ->flatten(1)
                                    ->sum('total_tax_amount');
                                $totalTax = collect($item['taxes'] ?? [])
                                    ->flatten(1)
                                    ->sum('tax_rate');
                            ?>
                            <div class="d-flex flex-column gap-1">
                                <div class="d-flex fz-14 gap-3 align-items-center title-clr">
                                    <?php echo e(translate('Total')); ?> (<?php echo e($totalTax); ?>%): <span>
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($totalTaxAmount)); ?></span>
                                </div>,<br>

                                <?php $__currentLoopData = $item['taxes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxName => $taxItems): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__currentLoopData = $taxItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="d-flex fz-11 gap-3 align-items-center">
                                            <?php echo e($taxName); ?> (<?php echo e($tax['tax_rate']); ?>%) :
                                            <span><?php echo e(\App\CentralLogics\Helpers::format_currency($tax['total_tax_amount'])); ?></span>
                                        </div>,<br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div>
                        </td>

                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/admin-tax-report.blade.php ENDPATH**/ ?>