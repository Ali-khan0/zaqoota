<?php $__env->startPush('script'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="text-center"> <h1>Please do not refresh this page...</h1></div>
    <form method="post" action="<?php echo \Illuminate\Support\Facades\Config::get('paytm_config.PAYTM_TXN_URL') ?>" id="form">
        <table border="1">
            <tbody>
            <?php $__currentLoopData = $paramList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <input type="hidden" name="<?php echo e($name); ?>" value="<?php echo e($value); ?>">
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <input type="hidden" name="CHECKSUMHASH" value="<?php echo e($checkSum); ?>">
            </tbody>
        </table>
    </form>

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("form").submit();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('payment-views.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/payment-views/paytm.blade.php ENDPATH**/ ?>