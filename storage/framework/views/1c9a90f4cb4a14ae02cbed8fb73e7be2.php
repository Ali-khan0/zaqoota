<?php $__env->startSection('title',''); ?>

<?php $__env->startPush('css_or_js'); ?>
    
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <style type="text/css" media="print">
        @page {
            size: auto;   /* auto is the initial value */
            margin: 0;  /* this affects the margin in the printer settings */
        }

    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<?php echo $__env->make('admin-views.order.partials._invoice', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin.print', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/order/invoice-print.blade.php ENDPATH**/ ?>