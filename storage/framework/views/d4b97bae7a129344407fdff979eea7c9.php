

<?php $__env->startSection('content'); ?>
    <div class="text-center py-5">
        <?php if(isset($errorMessage)): ?>
            <h2 class="text-danger mb-3">AssanPay</h2>
            <p class="mb-4"><?php echo e($errorMessage); ?></p>
            <a href="<?php echo e(url()->previous()); ?>" class="btn btn-primary">Back</a>
        <?php else: ?>
            <h1>Please wait…</h1>
            <p>Redirecting to AssanPay.</p>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('payment-views.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/payment-views/assan-pay.blade.php ENDPATH**/ ?>