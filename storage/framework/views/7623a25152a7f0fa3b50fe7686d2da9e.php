
<div class="row">
    <div class="col-lg-12 text-center "><h1 > <?php echo e(translate('review_List')); ?>

    </h1></div>
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
            <th><?php echo e(translate('sl')); ?></th>
            <th><?php echo e(translate('Provider_Name')); ?></th>
            <th><?php echo e(translate('Trip_ID')); ?></th>
            <th><?php echo e(translate('Customer_name')); ?></th>
            <th><?php echo e(translate('Vehicle_name')); ?></th>
            <th><?php echo e(translate('Rating')); ?></th>
            <th><?php echo e(translate('Comment')); ?></th>
            <th><?php echo e(translate('Reply')); ?></th>
            <th><?php echo e(translate('Status')); ?></th>

        </thead>
        <tbody>
        <?php $__currentLoopData = $data['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($loop->index+1); ?></td>
                <td><?php echo e($review->provider->name); ?></td>
                <td><?php echo e($review->trip->id); ?></td>
                <td><?php echo e($review?->customer?->fullName); ?></td>
                <td><?php echo e($review?->vehicle?->name); ?></td>
                <td><?php echo e($review?->rating); ?></td>
                <td><?php echo e($review?->comment); ?></td>
                <td><?php echo e($review?->reply); ?></td>
                 <td><?php echo e($review->status == 1 ? translate('messages.Active') : translate('messages.Inactive')); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/file-exports/vehicle-review-export.blade.php ENDPATH**/ ?>