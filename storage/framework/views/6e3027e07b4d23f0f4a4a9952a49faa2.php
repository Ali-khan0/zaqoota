
<div class="row">
    <div class="col-lg-12 text-center "><h1 > <?php echo e(translate('Review_List')); ?>

    </h1></div>
    <div class="col-lg-12">

    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('Filter_Criteria')); ?></th>
                <th></th>
                <th>
                    <?php echo e(translate('Store')); ?>: <?php echo e($data['store'] ?? translate('All')); ?>

                    <br>

                    <?php if(isset($data['category']) ): ?>
                    <?php echo e(translate('Category')); ?>: <?php echo e($data['category'] ?? translate('All')); ?>

                    <br>
                    <?php endif; ?>

                    <?php echo e(translate('Total_reviews')); ?>: <?php echo e($data['data']->count() ?? translate('All')); ?>

                    <br>
                    <?php echo e(translate('Search_Bar_Content')); ?>: <?php echo e($data['search'] ?? translate('N/A')); ?>


                </th>
                <th> </th>
                </tr>


        <tr>
            <th><?php echo e(translate('sl')); ?></th>
            <th><?php echo e(translate('Item_Name')); ?></th>
            <th><?php echo e(translate('Order_ID')); ?></th>
            <th><?php echo e(translate('Customer_Name')); ?></th>
            <th><?php echo e(translate('Store_Name')); ?></th>
            <th><?php echo e(translate('Rating')); ?></th>
            <th><?php echo e(translate('Review')); ?></th>
            <th><?php echo e(translate('Status')); ?></th>

        </thead>
        <tbody>
        <?php $__currentLoopData = $data['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
        <td><?php echo e($loop->index+1); ?></td>
        <td><?php echo e($review?->item?->name); ?></td>
        <td> <?php echo e($review->order_id); ?></td>
        <td>
            <?php echo e($review?->customer ?  $review?->customer?->f_name .' '.$review?->customer?->l_name  : translate('messages.Customer_Not_Found')); ?>

        </td>
        <td><?php echo e($review?->item?->store?->name ?? translate('messages.store_deleted')); ?></td>
        <td> <?php echo e($review->rating); ?></td>
        <td><?php echo e($review->comment); ?></td>
        <td><?php echo e($review->status == 1 ? translate('messages.active') : translate('messages.inactive')); ?></td>

            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/item-review.blade.php ENDPATH**/ ?>