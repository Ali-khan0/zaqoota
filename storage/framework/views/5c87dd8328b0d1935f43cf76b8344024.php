
<div class="row">
    <div class="col-lg-12 text-center "><h1 > <?php echo e(translate('Store_Wise_Review_List')); ?>

    </h1></div>
    <div class="col-lg-12">

    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('Store_details')); ?></th>
                <th></th>
                <th>
                    <?php echo e(translate('Store_Name')); ?>- <?php echo e($data['store_name'] ?? translate('All')); ?>

                    <br>
                    <?php echo e(translate('Store_ID')); ?>- <?php echo e($data['store_id'] ?? translate('All')); ?>

                    <br>

                    <?php echo e(translate('Rating')); ?>- <?php echo e($data['rating']?? translate('All')); ?>

                    <br>
                    <?php echo e(translate('Reviews')); ?>- <?php echo e($data['total_reviews'] ?? translate('All')); ?>

                </th>
                <th> </th>
                </tr>


        <tr>
            <th><?php echo e(translate('sl')); ?></th>
            <th><?php echo e(translate('messages.Review_Id')); ?></th>
            <th><?php echo e(translate('Item_Name')); ?></th>
            <th><?php echo e(translate('Order_ID')); ?></th>
            <th><?php echo e(translate('Customer_Name')); ?></th>
            <th><?php echo e(translate('Rating')); ?></th>
            <th><?php echo e(translate('Review')); ?></th>
            <th ><?php echo e(translate('messages.store_reply')); ?></th>
            <th><?php echo e(translate('Status')); ?></th>

        </thead>
        <tbody>
        <?php $__currentLoopData = $data['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <tr>
        <td><?php echo e($loop->index+1); ?></td>
        <td><?php echo e($review?->review_id); ?></td>
        <td><?php echo e($review?->item?->name); ?></td>
        <td> <?php echo e($review->order_id); ?></td>
        <td>
            <?php echo e($review?->customer ? $review?->customer?->f_name .' '.$review?->customer?->l_name  : translate('messages.Customer_Not_Found')); ?>

        </td>
        <td> <?php echo e($review->rating); ?></td>
        <td><?php echo e($review->comment); ?></td>
        <td><?php echo e($review?->reply ?? translate('not_given')); ?></td>
        <td><?php echo e($review->status == 1 ? translate('messages.active') : translate('messages.inactive')); ?></td>

            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/store_wise_item_review.blade.php ENDPATH**/ ?>