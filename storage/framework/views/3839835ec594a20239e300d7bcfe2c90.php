<?php $__env->startSection('title', translate('Service Unavailable')); ?>
<?php $__env->startSection('code', '503'); ?>
<?php $__env->startSection('message', translate($exception->getMessage() ?: 'Service Unavailable')); ?>

<?php echo $__env->make('errors::minimal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/errors/503.blade.php ENDPATH**/ ?>