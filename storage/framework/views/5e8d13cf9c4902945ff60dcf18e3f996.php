<?php $__env->startPush('script'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="text-center"> <h1>Please do not refresh this page...</h1></div>

    <form method="POST" action="<?php echo route('paystack.payment',['token'=>$data->id]); ?>" accept-charset="UTF-8"
          class="form-horizontal"
          role="form">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <input type="hidden" name="email"
                       value="<?php echo e($payer->email!=null?$payer->email:'required@email.com'); ?>"> 
                <input type="hidden" name="orderID" value="<?php echo e($data->attribute_id); ?>">
                <input type="hidden" name="amount"
                       value="<?php echo e($data->payment_amount*100); ?>"> 
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="currency"
                       value="<?php echo e($data->currency_code); ?>">
                <input type="hidden" name="metadata"
                       value="<?php echo e(json_encode($array = ['orderID' => $data->id,'cancel_action'=> url('/').'/payment-cancel'])); ?>"> 
                <input type="hidden" name="reference"
                       value="<?php echo e($reference); ?>"> 

                <button class="btn btn-block" id="pay-button" type="submit" style="display:none"></button>
            </div>

        </div>
    </form>

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("pay-button").click();
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('payment-views.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/payment-views/paystack.blade.php ENDPATH**/ ?>