<div class="row">
    <div class="col-lg-12 text-center ">
        <h1> <?php echo e(translate('Parcel_Cancellation_Reason_List')); ?>

        </h1>
    </div>
    <div class="col-lg-12">

        <table>
            <thead>
                <tr>
                    <th><?php echo e(translate('Filter_Criteria')); ?></th>
                    <th></th>
                    <th>

                        <?php echo e(translate('Search_Bar_Content')); ?>: <?php echo e($data['search'] ?? translate('N/A')); ?>


                    </th>
                    <th> </th>
                </tr>


                <tr>
                    <th class="fs-14 text-title font-semibold top-border-table">
                        <?php echo e(translate('SL')); ?>

                    </th>
                    <th class="fs-14 text-title font-semibold top-border-table">
                        <?php echo e(translate('messages.reason')); ?>

                    </th>
                    <th class="fs-14 text-title font-semibold top-border-table">
                        <?php echo e(translate('messages.cancellation_type')); ?>

                    </th>
                    <th class="fs-14 text-title font-semibold top-border-table">
                        <?php echo e(translate('messages.user_type')); ?>

                    </th>
                    <th class="fs-14 text-title font-semibold top-border-table">
                        <?php echo e(translate('messages.status')); ?>

                    </th>

                </tr>

            </thead>
            <tbody>
                <?php $__currentLoopData = $data['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($key + 1); ?></td>
                        <td class="p-3">
                            <div class="max-w-700 fs-14 title-clr font-medium min-w-140">
                                <?php echo e(Str::limit($item->reason, 25, '...')); ?>

                            </div>
                        </td>
                        <td class="p-3 fs-14 title-clr font-medium min-w-140">
                            <?php echo e(translate($item->cancellation_type)); ?></td>
                        <td class="p-3 fs-14 title-clr font-regular min-w-140"><?php echo e(translate($item->user_type)); ?>

                        </td>
                        <td class="p-3">
                            <?php if($item->status == 1): ?>
                                <span class="badge badge-soft-success fs-12"><?php echo e(translate('Active')); ?></span>
                            <?php else: ?>
                                <span class="badge badge-soft-danger fs-12"><?php echo e(translate('Inactive')); ?></span>
                            <?php endif; ?>
                        </td>

                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



            </tbody>
        </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/parcel-cancellation-reason.blade.php ENDPATH**/ ?>