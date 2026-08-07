<?php $__env->startPush('script'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <?php if(isset($config)): ?>
        <div class="text-center"> <h1>Please do not refresh this page...</h1></div>

        <div class="col-md-6 mb-4" style="cursor: pointer">
            <div class="card">
                <div class="card-body" style="height: 70px">
                    <?php ($secretkey = $config->secret_key); ?>
                    <?php ($data = new \stdClass()); ?>
                    <?php ($data->merchantId = $config->merchant_id); ?>
                    <?php ($data->amount =  number_format($payment_data->payment_amount, 2)  ); ?>
                    <?php ($data->attribute = $payment_data->attribute); ?>
                    <?php ($data->attribute_id = $payment_data->attribute_id); ?>
                    <?php ($data->name = $payer->name??''); ?>
                    <?php ($data->email = $payer->email ??''); ?>
                    <?php ($data->phone = $payer->phone ??''); ?>
                    <?php ($mode = $config->mode ?? 'test'); ?>
                    
                    <?php ($data->hashed_string = md5($secretkey . urldecode($data->attribute.$data->amount.$data->attribute_id) )); ?>

                    <form id="form" method="post" action="https://<?php echo e($mode =='live'?'app.senangpay.my':'sandbox.senangpay.my'); ?>/payment/<?php echo e($config->merchant_id); ?>">
                        <input type="hidden" name="amount" value="<?php echo e($data->amount); ?>">
                        <input type="hidden" name="name" value="<?php echo e($data->name); ?>">
                        <input type="hidden" name="email" value="<?php echo e($data->email); ?>">
                        <input type="hidden" name="phone" value="<?php echo e($data->phone); ?>">
                        <input type="hidden" name="hash" value="<?php echo e($data->hashed_string); ?>">
                        <input type="hidden" name="detail" value="<?php echo e($data->attribute); ?>">
                        <input type="hidden" name="order_id" value="<?php echo e($data->attribute_id); ?>">
                    </form>

                </div>
            </div>
        </div>
    <?php endif; ?>

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("form").submit();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('payment-views.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/payment-views/senang-pay.blade.php ENDPATH**/ ?>