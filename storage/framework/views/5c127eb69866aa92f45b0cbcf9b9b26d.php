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

<?php $__env->startPush('script'); ?>
    <script>
        function printDiv(divName) {
            window.open('<?php echo e(route("admin.order.print-invoice",["id" => $order->id])); ?>', '_blank');
        }

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/order/invoice.blade.php ENDPATH**/ ?>