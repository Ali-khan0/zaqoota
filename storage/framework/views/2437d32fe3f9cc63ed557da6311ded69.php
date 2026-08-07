<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate('Contact_messages')); ?></h1></div>
    <div class="col-lg-12">



    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('Message_Analytics')); ?></th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('Total')); ?>: <?php echo e($data->count()); ?>



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
            <th><?php echo e(translate('Name')); ?></th>
            <th><?php echo e(translate('Email')); ?></th>
            <th><?php echo e(translate('Subject')); ?></th>
            <th><?php echo e(translate('Message')); ?></th>
            <th><?php echo e(translate('Reply')); ?></th>
            <th><?php echo e(translate('Seen')); ?></th>
            <th><?php echo e(translate('Created_at')); ?> </th>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
        <td><?php echo e($loop->index+1); ?></td>
        <td><?php echo e($message->name); ?></td>
        <td><?php echo e($message->email); ?></td>
        <td><?php echo e($message->subject); ?></td>
        <td><?php echo e($message->message); ?></td>
        <td><?php echo e($message->reply ?? translate('messages.N/A')); ?></td>
        <td><?php echo e($message->seen == 0 ? translate('unseen') : translate('seen')); ?></td>
        <td><?php echo e(\App\CentralLogics\Helpers::time_date_format($message->created_at)); ?></td>

            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/contact_message.blade.php ENDPATH**/ ?>