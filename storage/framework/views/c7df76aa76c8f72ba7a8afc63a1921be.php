<div class="row">
    <div class="col-lg-12 text-center "><h1 >Basic Campaign List</h1></div>
    <div class="col-lg-12">



    <table>
        <thead>
            <tr>
                <th>Message Analytics</th>
                <th></th>
                <th></th>
                <th> Total Campaign : <?php echo e($data->count()); ?>


<br>
Dara
                </th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
                </tr>
        <tr>
            <th>SL</th>
            <th>Cmapaign Name</th>
            <th>Description</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Daily Start Time</th>
            <th>Daily End Time</th>
            <th>Total Store Joined </th>
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
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/user-export.blade.php ENDPATH**/ ?>