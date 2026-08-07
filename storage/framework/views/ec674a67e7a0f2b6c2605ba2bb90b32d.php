<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate('employee_list')); ?></h1></div>
    <div class="col-lg-12">



    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('Analytics')); ?></th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('total_employee')); ?>- <?php echo e($data['employees']->count()); ?>

                    <br>
                    <?php echo e(translate('active_employee')); ?>- <?php echo e($data['employees']->where('status',1)->count()); ?>

                    <br>
                    <?php echo e(translate('inactive_employee')); ?>- <?php echo e($data['employees']->where('status',0)->count()); ?>

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
                    <?php echo e(translate('Search_Bar_Content')); ?>- <?php echo e($data['search'] ??translate('N/A')); ?>


                </th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
                </tr>
        <tr>
            <th><?php echo e(translate('sl')); ?></th>
            <th><?php echo e(translate('employee_image')); ?></th>
            <th><?php echo e(translate('first_name')); ?></th>
            <th><?php echo e(translate('last_name')); ?></th>
            <th><?php echo e(translate('phone')); ?></th>
            <th><?php echo e(translate('email')); ?></th>
            <th><?php echo e(translate('role')); ?></th>
            <th><?php echo e(translate('zone')); ?></th>
            <th><?php echo e(translate('joining_date')); ?></th>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data['employees']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($key+1); ?></td>
            <td></td>
            <td><?php echo e($employee['f_name']); ?></td>
            <td><?php echo e($employee['l_name']); ?></td>
            <td><?php echo e($employee['phone']); ?></td>
            <td><?php echo e($employee['email']); ?></td>
            <td><?php echo e($employee->role?$employee->role['name']:translate('messages.role_deleted')); ?></td>
            <td><?php echo e($employee->zones?$employee->zones->name:translate('messages.all')); ?></td>
            <td>
                <?php echo e(date('Y-m-d '.config('timeformat'),strtotime($employee->created_at))); ?>

            </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/employee-list.blade.php ENDPATH**/ ?>