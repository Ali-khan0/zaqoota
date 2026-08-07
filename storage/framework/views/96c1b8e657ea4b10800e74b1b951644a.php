<html>
<head>
    <title>Merchant Check Out Page</title>
</head>
<body>
<div class="text-center"> <h1>Please do not refresh this page...</h1></div>
<form method="post" action="<?php echo \Illuminate\Support\Facades\Config::get('config_paytm.PAYTM_TXN_URL') ?>" name="f1">
    <table border="1">
        <tbody>
        <?php $__currentLoopData = $paramList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <input type="hidden" name="<?php echo e($name); ?>" value="<?php echo e($value); ?>">
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <input type="hidden" name="CHECKSUMHASH" value="<?php echo e($checkSum); ?>">
        </tbody>
    </table>
    <script type="text/javascript">
        document.f1.submit();
    </script>
</form>
</body>
</html>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/paytm-payment-view.blade.php ENDPATH**/ ?>