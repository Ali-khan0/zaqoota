
<div class="row">
    <div class="col-lg-12 text-center "><h1 > <?php echo e(translate('Push_Notification_List')); ?>

    </h1></div>
    <div class="col-lg-12">

    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('Search_Criteria')); ?></th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('Search_Bar_Content')); ?>: <?php echo e($data['search'] ??translate('N/A')); ?>

                </th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
                </tr>


        <tr>
            <th><?php echo e(translate('sl')); ?></th>
            <th><?php echo e(translate('Notification_Title')); ?></th>
            <th><?php echo e(translate('Created_At')); ?></th>
            <th><?php echo e(translate('Description')); ?></th>
            <th><?php echo e(translate('Image')); ?></th>
            <th><?php echo e(translate('Zone')); ?></th>
            <th><?php echo e(translate('Targeted Users')); ?></th>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
        <td><?php echo e($loop->index+1); ?></td>
        <td><?php echo e($coupon->title); ?></td>
        <td><?php echo e(\Carbon\Carbon::parse($coupon->created_at)->format('d M Y')); ?></td>
        <td><?php echo e($coupon->description); ?></td>
            <td></td>
        
        <td><?php echo e($coupon?->zone?->name ??  translate('All')); ?></td>

        <td><?php echo e(translate($coupon->tergat)); ?></td>


            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/file-exports/push_notification.blade.php ENDPATH**/ ?>