<?php $__env->startSection('title',''); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('Modules/Rental/public/assets/css/admin/trip-invoice.css')); ?>" media="print">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<?php echo $__env->make('rental::admin.trip.partials._invoice', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin.print', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/trip/invoice-print.blade.php ENDPATH**/ ?>