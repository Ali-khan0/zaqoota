

<?php $__env->startPush('script'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="text-center">
        <h1><?php echo e(translate('Please do not refresh this page...')); ?></h1>
    </div>

    <form method="POST" action="<?php echo e($base_url); ?>" accept-charset="UTF-8" class="form-horizontal" role="form" id="payfast-form">
        <?php $__currentLoopData = $data_array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <button class="btn btn-block" id="pay-button" type="submit" style="display:none"></button>
            </div>
        </div>
    </form>

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("pay-button").click();
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('payment-views.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/payment-views/payfast.blade.php ENDPATH**/ ?>