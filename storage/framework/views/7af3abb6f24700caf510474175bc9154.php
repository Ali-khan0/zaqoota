<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate('messages.Subscriber_list')); ?></h1></div>
    <div class="col-lg-12">



    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('filter_criteria')); ?> -</th>
                <th></th>
                <th></th>
                <th>

                    <?php echo e(translate('zone' )); ?> - <?php echo e($data['zone']); ?>



                    <br>
                    <?php echo e(translate('filter')); ?>- <?php echo e(translate($data['filter'])); ?>


                    <br>
                    <?php echo e(translate('Search_Bar_Content')); ?>- <?php echo e($data['search'] ??translate('N/A')); ?>


                </th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th class="border-top px-4 border-bottom text-center"><?php echo e(translate('sl')); ?></th>
                <th class="border-top px-4 border-bottom"> <?php echo e(translate('Store Info')); ?>  </th>
                <th class="border-top px-4 border-bottom"> <?php echo e(translate('Current Package Name')); ?> </th>
                <th class="border-top px-4 border-bottom"> <?php echo e(translate('Package Price')); ?>  </th>
                <th class="border-top px-4 border-bottom"> <?php echo e(translate('Exp Date')); ?>  </th>
                <th class="border-top px-4 border-bottom text-center"> <?php echo e(translate('Total Subscription Used')); ?>  </th>
                <th class="border-top px-4 border-bottom text-center"> <?php echo e(translate('is_trial')); ?>  </th>
                <th class="border-top px-4 border-bottom text-center"> <?php echo e(translate('is_cancel')); ?>  </th>
                <th class="border-top px-4 border-bottom text-center"><?php echo e(translate('Status')); ?> </th>
            </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=> $subscriber): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>

                    <td class=" text-center"><?php echo e($k + 1); ?></td>
                    <td >
                        <?php echo e($subscriber->name); ?>

                    </td>
                    <td >
                        <div><?php echo e($subscriber?->store_sub_update_application?->package?->package_name); ?></div>
                    </td>
                    <td >
                        <div class="text-title"><?php echo e(\App\CentralLogics\Helpers::format_currency($subscriber?->store_sub_update_application?->package?->price)); ?></div>
                    </td>
                    <td >
                        <div class="text-title"><?php echo e(\App\CentralLogics\Helpers::date_format($subscriber?->store_sub_update_application?->expiry_date_parsed)); ?></div>
                    </td>
                    <td >
                        <div class="text-title pl-3"><?php echo e($subscriber?->store_all_sub_trans_count); ?></div>
                    </td>
                    <td class="px-4">
                        <div class="text-title pl-3">
                            <?php if($subscriber?->store_sub_update_application?->is_trial): ?>
                            <span class="badge badge-pill badge-info"><?php echo e(translate('Yes')); ?></span>

                            <?php else: ?>
                            <span class="badge badge-pill badge-success"><?php echo e(translate('No')); ?></span>
                            <?php endif; ?>

                    </div>
                    <td class="px-4">
                        <div class="text-title pl-3">
                            <?php if($subscriber?->store_sub_update_application?->is_canceled): ?>
                            <span class="badge badge-pill badge-warning"><?php echo e(translate('Yes')); ?></span>

                            <?php else: ?>
                            <span class="badge badge-pill badge-success"><?php echo e(translate('No')); ?></span>
                            <?php endif; ?>

                    </div>
                    <td class=" text-center">
                        <div>
                            <?php if($subscriber?->status == 0 &&  $subscriber?->vendor?->status == 0): ?>
                            <span class="badge badge-soft-info"><?php echo e(translate('Approval_Pending')); ?></span>
                            
                            <?php elseif($subscriber?->store_sub_update_application?->status == 0): ?>
                            <span class="badge badge-soft-danger"><?php echo e(translate('Expired')); ?></span>
                            <?php elseif($subscriber?->store_sub_update_application?->status == 1): ?>
                            <span class="badge badge-soft-success"><?php echo e(translate('Active')); ?></span>
                            <?php endif; ?>
                        </div>
                    </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/subscription_subscriber_list.blade.php ENDPATH**/ ?>