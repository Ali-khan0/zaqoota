<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate('expense_reports')); ?></h1></div>
    <div class="col-lg-12">



    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('Search_Criteria')); ?></th>
                <th></th>
                <th></th>
                <th>
                    <?php if(isset($data['module'])): ?>
                    <?php echo e(translate('module' )); ?> - <?php echo e($data['module']?translate($data['module']):translate('all')); ?>

                    <br>
                    <?php endif; ?>

                    <?php echo e(translate('zone' )); ?> - <?php echo e($data['zone']??translate('all')); ?>

                    <br>
                    <?php echo e((isset($data['module_type']) && $data['module_type'] == 'rental')?translate('provider'):translate('vendor')); ?> - <?php echo e($data['store']??translate('all')); ?>

                    <?php if(!isset($data['type']) ): ?>
                    <br>
                    <?php echo e(translate('customer' )); ?> - <?php echo e($data['customer']??translate('all')); ?>

                    <?php endif; ?>
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
            <?php if(isset($data['module_type'])): ?>
            <th><?php echo e($data['module_type'] == 'rental'? translate('trip_id') : translate('messages.order_id')); ?></th>
            <?php elseif(addon_published_status('Rental')): ?>
                <th><?php echo e(translate('messages.order_id')); ?></th>
                <th><?php echo e(translate('trip_id')); ?></th>
            <?php endif; ?>
            <th><?php echo e(translate('Date & Time')); ?></th>
            <th><?php echo e(translate('Expense Type')); ?></th>
            <th><?php echo e(translate('Customer Name')); ?></th>
            <th><?php echo e(translate('expense amount')); ?></th>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data['expenses']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($key+1); ?></td>
                <?php if(isset($data['module_type'])): ?>
                    <td>
                        <?php if($exp->order && $data['module_type'] != 'rental'): ?>
                            <?php echo e($exp['order_id']); ?>

                        <?php elseif($exp->trip && $data['module_type'] == 'rental'): ?>
                            <?php echo e($exp['trip_id']); ?>

                        <?php endif; ?>
                    </td>
                <?php elseif(addon_published_status('Rental')): ?>
                    <td><?php echo e($exp['order_id']); ?></td>
                    <td><?php echo e($exp['trip_id']); ?></td>
                <?php endif; ?>
                <td>
                    <?php echo e(date('Y-m-d '.config('timeformat'),strtotime($exp->created_at))); ?>

                </td>
                <td><?php echo e(translate("messages.{$exp['type']}")); ?></td>
                <td class="text-center">
                    <?php if($exp->order): ?>

                    <?php if($exp->order?->is_guest): ?>
                    <?php ($customer_details = json_decode($exp->order['delivery_address'],true)); ?>
                    <strong><?php echo e($customer_details['contact_person_name']); ?></strong>

                    <?php elseif($exp->order?->customer): ?>

                    <?php echo e($exp->order?->customer['f_name'].' '.$exp->order?->customer['l_name']); ?>

                    <?php else: ?>
                        <label
                            class="badge badge-danger"><?php echo e(translate('messages.invalid_customer_data')); ?></label>
                    <?php endif; ?>

                    <?php elseif($exp->trip): ?>
                    <?php if($exp?->trip?->customer): ?>

                        <?php echo e($exp?->trip?->customer?->fullName); ?>


                        <?php elseif($exp?->trip?->user_info['contact_person_name']): ?>
                            <div class="font-medium">
                                <?php echo e($exp?->trip?->user_info['contact_person_name']); ?>

                            </div>
                        <?php else: ?>
                            <?php echo e(translate('messages.Guest_user')); ?>

                        <?php endif; ?>


                    <?php elseif($exp['type'] == 'add_fund_bonus'): ?>
                    <?php echo e($exp->user->f_name.' '.$exp->user->l_name); ?>

                    <?php else: ?>
                    <label class="badge badge-danger"><?php echo e(translate('messages.invalid_customer_data')); ?></label>

                    <?php endif; ?>
                </td>
                <td><?php echo e(\App\CentralLogics\Helpers::format_currency($exp['amount'])); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/expense-report.blade.php ENDPATH**/ ?>