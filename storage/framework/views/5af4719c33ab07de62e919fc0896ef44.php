<?php $__env->startSection('title', translate('Forbidden')); ?>
<?php $__env->startSection('code', '403'); ?>
<?php $__env->startSection('message', translate($exception->getMessage() ?: 'Forbidden')); ?>

<?php echo $__env->make('errors::minimal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/errors/403.blade.php ENDPATH**/ ?>