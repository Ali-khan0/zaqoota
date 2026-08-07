<div class="row">
    <div class="col-lg-12 text-center ">
        <h1><?php echo e(translate('Parcel_Tax_Reports')); ?></h1>
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
                            <?php echo e(translate('total_orders')); ?> - <?php echo e($data['summary']['total_orders'] ??0); ?>

                            <br>
                            <?php echo e(translate('total_order_amount')); ?> - <?php echo e($data['summary']['total_order_amount'] ??0); ?>

                            <br>
                            <?php echo e(translate('total_tax')); ?> - <?php echo e($data['summary']['total_tax'] ??0); ?>

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

                    </th>
                    <th> </th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <th class="border-0"><?php echo e(translate('sl')); ?></th>
                    <th class="border-0"><?php echo e(translate('Order ID')); ?></th>
                    <th class="border-0"><?php echo e(translate('Total Order Amount')); ?></th>
                    <th class="border-0"><?php echo e(translate('Tax Amount')); ?></th>
            </thead>
            <tbody>
                <?php $__currentLoopData = $data['orders']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <?php echo e($key +1); ?>

                        </td>
                        <td>
                            <?php echo e($order->id); ?>

                        </td>
                        <td>
                            <?php echo e(\App\CentralLogics\Helpers::format_currency($order->order_amount)); ?>

                        </td>
                        <td>
                            <div class="d-flex flex-column gap-1">
                                <div class="d-flex fz-14 gap-3 align-items-center title-clr">
                                    <?php echo e(translate('Total:')); ?> <span>
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($order->total_tax_amount)); ?></span>
                                </div>, <br>
                                <?php $__currentLoopData = $order->orderTaxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="d-flex fz-11 gap-3 align-items-center">
                                        <?php echo e($tax['tax_name']); ?>:
                                        <span><?php echo e(\App\CentralLogics\Helpers::format_currency($tax['tax_amount'])); ?>

                                        </span>
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
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/parcel-wise-tax-report.blade.php ENDPATH**/ ?>