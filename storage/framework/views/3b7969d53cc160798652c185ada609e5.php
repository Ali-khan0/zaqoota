<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate('Basic_Campaign_List')); ?></h1></div>
    <div class="col-lg-12">



    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('Message_Analytics')); ?></th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('Total_Campaign')); ?>: <?php echo e($data->count()); ?>

                    <br>
                    <?php echo e(translate('Currently_Running')); ?>: <?php echo e($data->where('status',1)->count()); ?>


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
                    <?php echo e(translate('Search_Bar_Content')); ?>: : <?php echo e($search ??translate('N/A')); ?>

                </th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
                </tr>
        <tr>
            <th><?php echo e(translate('sl')); ?></th>
            <th><?php echo e(translate('Campaign_Name')); ?></th>
            <th><?php echo e(translate('Description')); ?></th>
            <th><?php echo e(translate('Start_Date')); ?></th>
            <th><?php echo e(translate('End_Date')); ?></th>
            <th><?php echo e(translate('Daily_Start_Time')); ?></th>
            <th><?php echo e(translate('Daily_End_Time')); ?></th>
            <th><?php echo e(translate('Total_Store_Joined')); ?> </th>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
        <td><?php echo e($loop->index+1); ?></td>
        <td><?php echo e($campaign->title); ?></td>
        <td><?php echo e($campaign->description); ?></td>
        <td><?php echo e($campaign->start_date->format('d M Y')); ?></td>
        <td><?php echo e($campaign->end_date->format('d M Y')); ?></td>
        <td><?php echo e(\Carbon\Carbon::parse($campaign->start_time)->format("H:i A")); ?></td>
        <td><?php echo e(\Carbon\Carbon::parse($campaign->end_time)->format("H:i A")); ?></td>
        <td><?php echo e($campaign->stores->count()); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/basic-campaign.blade.php ENDPATH**/ ?>