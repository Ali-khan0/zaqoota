<?php
    $isRental = $data['is_rental'] == 1 ? 'Provider' : 'Store';
    $isVehicle = $data['is_rental'] == 1 ? 'vehicle' : 'item';
    $isTrip = $data['is_rental'] == 1 ? 'trip' : 'order';
?>
<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate($isRental.'_List')); ?></h1></div>
    <div class="col-lg-12">



    <table>
        <thead>




        <tr>

            <th><?php echo e(translate('Total_'.$isRental)); ?> - <?php echo e($data['data']->count() ?? translate('N/A')); ?> </th>
            <th></th>
            <th></th>
            <th> <?php echo e(translate('Active_'.$isRental)); ?> - <?php echo e($data['data']->where('status',1)->count() ?? translate('N/A')); ?> </th>
            <th></th>
            <th></th>
            <th> <?php echo e(translate('Inactive_'.$isRental)); ?> - <?php echo e($data['data']->where('status',0)->count() ?? translate('N/A')); ?> </th>
            <th></th>
            <th></th>
            <th> <?php echo e(translate('Newly_Joined')); ?> - <?php echo e($data['data']->where('created_at', '>=', now()->subDays(30)->toDateTimeString())->count() ?? translate('N/A')); ?> </th>
            <th></th>

        </tr>
            <tr>
                <th><?php echo e(translate('Filter_Criteria')); ?></th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('zone' )); ?> - <?php echo e($data['zone']??translate('all')); ?>


                    <br>
                    <?php echo e(translate('Module' )); ?> - <?php echo e($data['module']??translate('all')); ?>


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
            <th><?php echo e(translate($isRental.'_ID')); ?></th>
            <th><?php echo e(translate($isRental.'_Logo')); ?></th>
            <th><?php echo e(translate($isRental.'_Name')); ?></th>
            <th><?php echo e(translate('Ratings')); ?></th>
            <th>  <?php echo e(translate('Owner_Information')); ?></th>
            <th>   <?php echo e(translate('Address')); ?></th>
            <th> <?php echo e(translate('Total_'.$isVehicle.'s')); ?></th>
            <th> <?php echo e(translate('Total_'.$isTrip.'s')); ?></th>
            <th><?php echo e(translate('Featured_?')); ?></th>
            <th><?php echo e(translate('Status')); ?></th>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($key+1); ?></td>
            <td><?php echo e($store['id']); ?></td>
            <td>&nbsp;</td>
            <td><?php echo e($store['name']); ?></td>
            <td>
                <?php if($isRental == 'Provider'): ?>
                    <?php echo e(number_format($store->vehicle_reviews->avg('rating'))); ?>

                <?php else: ?>
                    <?php ($store_reviews = \App\CentralLogics\StoreLogic::calculate_store_rating($store['rating'])); ?>
                    <?php echo e(number_format($store_reviews['rating'], 1)); ?>

                <?php endif; ?>

            </td>
            <td> <?php echo e($store->vendor->f_name .' '  .$store->vendor->l_name); ?>

                        <br>
                    <?php echo e($store->vendor->phone); ?>

            </td>
            <td> <?php echo e($store->address); ?> </td>
            <td>
                <?php if($isRental == 'Provider'): ?>
                    <?php echo e(count($store->vehicles)); ?>

                <?php else: ?>
                    <?php echo e($store->items_count); ?>

                <?php endif; ?>
            </td>
            <td>
                <?php if($isRental == 'Provider'): ?>
                    <?php echo e(count($store->trips)); ?>

                <?php else: ?>
                    <?php echo e($store->orders()->StoreOrder()->count()); ?>

                <?php endif; ?>
            </td>
            <td>
                <?php echo e($store->featured == 1 ? translate('Yes') : translate('No')); ?>

            </td>
            <td>
                <?php echo e($store->status == 1 ? translate('Active') : translate('Inactive')); ?>

            </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/store-list.blade.php ENDPATH**/ ?>