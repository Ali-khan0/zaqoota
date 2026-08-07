
<div class="row">
    <div class="col-lg-12 text-center "><h1 > <?php echo e(translate('Coupon_List')); ?>

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
            <th><?php echo e(translate('Coupon_Title')); ?></th>
            <th><?php echo e(translate('Coupon_Code')); ?></th>
            <th><?php echo e(translate('Module')); ?></th>
            <th><?php echo e(translate('Coupon_Type')); ?></th>
            <th><?php echo e(translate('Number_of_Uses')); ?></th>
            <th><?php echo e(translate('Min_Purchase_Amount')); ?></th>
            <th><?php echo e(translate('Max_Discount_Amount')); ?> </th>
            <th><?php echo e(translate('Discount_Type')); ?> </th>
            <th><?php echo e(translate('Discount')); ?> </th>
            <th><?php echo e(translate('Start_Date')); ?> </th>
            <th><?php echo e(translate('End_Date')); ?> </th>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
        <td><?php echo e($loop->index+1); ?></td>
        <td><?php echo e($coupon->title); ?></td>
        <td><?php echo e($coupon->code); ?></td>
        <td><?php echo e(translate($coupon->module->module_name)); ?></td>
        <?php if( $coupon->coupon_type == 'store_wise'): ?>
        <td><?php echo e(translate('messages.Provider_wise')); ?></td>
        <?php elseif($coupon->coupon_type == 'first_order'): ?>
        <td><?php echo e(translate('messages.first_trip')); ?></td>
        <?php else: ?>
        <td><?php echo e(translate('messages.'.$coupon->coupon_type)); ?></td>
        <?php endif; ?>
        <td><?php echo e($coupon->total_uses); ?></td>
        <td><?php echo e($coupon->min_purchase); ?></td>
        <td><?php echo e($coupon->max_discount); ?></td>
        <td><?php echo e($coupon->discount); ?></td>
        <td><?php echo e(translate($coupon->discount_type)); ?></td>
        <td><?php echo e(\Carbon\Carbon::parse($coupon->start_date)->format('d M Y')); ?></td>
        <td><?php echo e(\Carbon\Carbon::parse($coupon->expire_date)->format('d M Y')); ?></td>

            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/file-exports/coupon-export.blade.php ENDPATH**/ ?>