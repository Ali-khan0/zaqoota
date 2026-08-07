<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate('delivery_man_review_list')); ?></h1></div>
    <div class="col-lg-12">



    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('delivery_man_info')); ?></th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('name')); ?>- <?php echo e($data['dm']->f_name.' '.$data['dm']->l_name); ?>

                    <br>
                    <?php echo e(translate('phone')); ?>- <?php echo e($data['dm']->phone); ?>

                    <br>
                    <?php echo e(translate('email')); ?>- <?php echo e($data['dm']->email); ?>

                    <br>
                    <?php echo e(translate('total_rating')); ?>- <?php echo e(count($data['dm']->rating)); ?>

                    <br>
                    <?php echo e(translate('average_review')); ?>- <?php echo e(count($data['dm']->rating)>0?number_format($data['dm']->rating[0]->average, 1, '.', ' '):0); ?>


                </th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            
        <tr>
            <th><?php echo e(translate('sl')); ?></th>
            <th><?php echo e(translate('messages.order_id')); ?></th>
            <th><?php echo e(translate('messages.customer_name')); ?></th>
            <th><?php echo e(translate('messages.store_name')); ?></th>
            <th><?php echo e(translate('messages.rating')); ?></th>
            <th><?php echo e(translate('messages.review')); ?></th>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data['reviews']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($key+1); ?></td>
                <td>
                    <?php echo e($review->order_id); ?>

                </td>
                <td>
                    <?php if($review->customer): ?>
                        <?php echo e($review->customer?$review->customer->f_name:""); ?> <?php echo e($review->customer?$review->customer->l_name:""); ?>

                    <?php else: ?>
                        <?php echo e(translate('messages.customer_not_found')); ?>

                    <?php endif; ?>
                </td>
                <td>
                    <?php echo e($review->order?->store?->name); ?>

                </td>
                <td><?php echo e($review->rating); ?></td>
                <td><?php echo e($review->comment); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/single-deliveryman-review.blade.php ENDPATH**/ ?>