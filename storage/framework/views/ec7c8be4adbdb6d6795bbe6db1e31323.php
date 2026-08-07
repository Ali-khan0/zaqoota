<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate('reviews')); ?></h1></div>
    <div class="col-lg-12">



    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('review')); ?></th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('Total')); ?>: <?php echo e($data['data']->count()); ?>



                </th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
                </tr>
            <tr>
                <th><?php echo e(translate('Search_Criteria')); ?></th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('Search_Bar_Content')); ?>: : <?php echo e($data['search']  ??translate('N/A')); ?>

                </th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
                </tr>
        <tr>
            <th class="border-0"><?php echo e(translate('messages.#')); ?></th>
            <th class="border-0"><?php echo e(translate('messages.Review_Id')); ?></th>
            <th class="border-0"><?php echo e(translate('messages.item')); ?></th>
            <th class="border-0"><?php echo e(translate('messages.order_id')); ?></th>
            <th class="border-0"><?php echo e(translate('messages.reviewer')); ?></th>
            <th class="border-0"><?php echo e(translate('messages.review')); ?></th>
            <th class="border-0"><?php echo e(translate('messages.date')); ?></th>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($key+1); ?></td>
                <td><?php echo e($review->review_id); ?></td>
        <td><?php echo e($review->item['name']); ?></td>
        <td><?php echo e($review->order_id); ?></td>

        <td>
            <?php if($review->customer): ?>
                <div>
                    <h5 class="d-block text-hover-primary mb-1"><?php echo e(Str::limit($review->customer['f_name']." ".$review->customer['l_name'])); ?> <i
                            class="tio-verified text-primary" data-toggle="tooltip" data-placement="top"
                            title="Verified Customer"></i></h5>
                    <span class="d-block font-size-sm text-body">(<?php echo e(Str::limit($review->customer->phone)); ?>)</span>
                </div>
            <?php else: ?>
                <?php echo e(translate('messages.customer_not_found')); ?>

            <?php endif; ?>
        </td>
        <td>
            <div class="text-wrap w-18rem">
                <label class="rating">
                    <i class="tio-star"></i>
                    <span><?php echo e($review->rating); ?></span>
                </label>
                <p data-toggle="tooltip" data-placement="bottom"
                   data-original-title="<?php echo e($review?->comment); ?>" >
                    <?php echo e($review['comment']); ?>

                </p>
            </div>
        </td>
        <td>
            <span class="d-block">
                <?php echo e(\App\CentralLogics\Helpers::date_format($review->created_at)); ?>

            </span>
            <span class="d-block"> <?php echo e(\App\CentralLogics\Helpers::time_format($review->created_at)); ?></span>
        </td>

            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/reviews.blade.php ENDPATH**/ ?>