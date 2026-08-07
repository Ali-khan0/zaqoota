<?php $__env->startPush('script'); ?>
    
    <script src="https://js.stripe.com/v3/"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="text-center"> <h1>Please do not refresh this page...</h1></div>


<script type="text/javascript">
    // Create an instance of the Stripe object with your publishable API key
    var stripe = Stripe('<?php echo e($config->published_key); ?>');
    document.addEventListener("DOMContentLoaded", function () {
        fetch("<?php echo e(url("payment/stripe/token/?payment_id={$data->id}")); ?>", {
            method: "GET",
        }).then(function (response) {
            console.log(response)
            return response.text();
        }).then(function (session) {
            console.log(session)
            return stripe.redirectToCheckout({sessionId: JSON.parse(session).id});
        }).then(function (result) {
            if (result.error) {
                alert(result.error.message);
            }
        }).catch(function (error) {
            console.error("error:", error);
        });
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('payment-views.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/payment-views/stripe.blade.php ENDPATH**/ ?>