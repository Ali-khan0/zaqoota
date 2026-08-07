<?php $__currentLoopData = $expense; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td scope="row"><?php echo e($key+1); ?></td>
        <td>
            <?php if($exp->order): ?>

            <div>
                <a
                    href="<?php echo e(route('admin.order.details', ['id' => $exp->order->id,'module_id'=>$exp->order->module_id])); ?>"><?php echo e($exp['order_id']); ?></a>
            </div>
            <?php endif; ?>
        </td>
        <td>
            <?php echo e(date('Y-m-d '.config('timeformat'),strtotime($exp->created_at))); ?>

        </td>
        <td><label class="text-uppercase"><?php echo e(translate("messages.{$exp['type']}")); ?></label></td>
        <td class="text-center">
            <?php if(isset($exp->order->customer)): ?>
            <?php echo e($exp->order->customer->f_name.' '.$exp->order->customer->l_name); ?>

            <?php else: ?>
            <label class="badge badge-danger"><?php echo e(translate('messages.invalid_customer_data')); ?></label>

            <?php endif; ?>
        </td>
        <td class="text-right pr-xl-5">
            <div class="pr-xl-5">
                <?php echo e(\App\CentralLogics\Helpers::format_currency($exp['amount'])); ?>

            </div>
        </td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/report/partials/_expense_table.blade.php ENDPATH**/ ?>