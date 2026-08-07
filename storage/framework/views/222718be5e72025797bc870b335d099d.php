<?php $__env->startSection('content'); ?>
    <h1>Hello World</h1>

    <p>Module: <?php echo config('ai.name'); ?></p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('ai::layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/AI/resources/views/index.blade.php ENDPATH**/ ?>