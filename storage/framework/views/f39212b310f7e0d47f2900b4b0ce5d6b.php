<?php $__env->startSection('content'); ?>
    <!-- Title -->
    <div class="text-center text-white mb-4">
        <h2>6amMart Software Installation</h2>
        <h6 class="fw-normal">All Done, Great Job. Your software is ready to run.</h6>
    </div>

    <!-- Card -->
    <div class="card mt-4">
        <div class="p-4 mb-md-3 mx-xl-4 px-md-5">
            <div class="p-4 rounded mb-4 text-center">
                <h5 class="fw-normal">Configure the following setting to run the system properly</h5>

                <ul class="list-group mar-no mar-top bord-no">
                    <li class="list-group-item">Business Setting</li>
                    <li class="list-group-item">MAIL Setting</li>
                    <li class="list-group-item">Payment Gateway Configuration</li>
                    <li class="list-group-item">SMS Gateway Configuration</li>
                    <li class="list-group-item">3rd Party APIs</li>
                </ul>
            </div>

            <div class="text-center">
                <a href="<?php echo e(env('APP_URL')); ?>" target="_blank" class="btn btn-secondary px-sm-5">Landing Page</a>
                <?php
                $data = \App\Models\DataSetting::where('type', 'login_admin')->pluck('value')->first();
                ?>
                <a href="<?php echo e(env('APP_URL')); ?>/login/<?php echo e($data); ?>" target="_blank" class="btn btn-dark px-sm-5">Admin Panel</a>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.blank', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/installation/step6.blade.php ENDPATH**/ ?>