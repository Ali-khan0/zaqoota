<?php $__env->startSection('title',translate('messages.new_page')); ?>

<?php $__env->startPush('css_or_js'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">

    <h3 class="mb-20">Surge Price</h3>

    <table id="#0" class="table m-0 table-borderless table-thead-bordered table-align-middle">
        <tbody id="table-div">
            <tr>
                <td colspan="">
                    <div class="bg-light rounded table-column p-5 text-center">
                        <div class="pt-5">
                            <img class="mb-20" src="<?php echo e(asset('public/assets/admin/img/price-emty.png')); ?>" alt="status">
                            <h4 class="mb-3">Currently you don’t have any Surge Price</h4>
                            <p class="mb-20 fs-12 mx-auto max-w-400px">To enable surge pricing, you must create at least one Surge Price. In this page you see all the surge price you added.</p>
                            <a href="#0" class="btn btn--primary">
                                Create Surge Price
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

</div>


<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/test/surgeprice-setup/emty.blade.php ENDPATH**/ ?>