<?php $__env->startSection('title',translate('messages.Store_Transactions')); ?>

<?php $__env->startSection('subscriberList'); ?>
active
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css_or_js'); ?>


<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="content container-fluid">
        <div class="page-header">
            <div class="d-flex flex-wrap justify-content-between align-items-center py-2">
                <div class="flex-grow-1">
                    <div class="d-flex align-items-start">
                        <img src="<?php echo e(asset('/public/assets/admin/img/store.png')); ?>" width="24" alt="img">
                        <div class="w-0 flex-grow pl-2">
                            <h1 class="page-header-title"><?php echo e($store->name); ?> <?php echo e(translate('Subscription')); ?> &nbsp; &nbsp;
                                <?php if($store?->store_sub_update_application?->status == 0): ?>
                                <span class=" badge badge-pill badge-danger">  &nbsp; <?php echo e(translate('Expired')); ?>  &nbsp; </span>
                                <?php elseif($store?->store_sub_update_application?->is_canceled == 1): ?>
                                <span class=" badge badge-pill badge-warning">  &nbsp; <?php echo e(translate('canceled')); ?>  &nbsp; </span>
                                <?php elseif($store?->store_sub_update_application?->status == 1): ?>
                                <span class=" badge badge-pill badge-success">  &nbsp; <?php echo e(translate('Active')); ?>  &nbsp; </span>
                                <?php endif; ?>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="js-nav-scroller hs-nav-scroller-horizontal mb-4">
            <ul class="nav nav-tabs border-0 nav--tabs nav--pills">
                <li class="nav-item">
                    <a href="<?php echo e(route('vendor.subscriptionackage.subscriberDetail',$store->id)); ?>" class="nav-link "><?php echo e(translate('Subscription_Details')); ?> </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('vendor.subscriptionackage.subscriberTransactions',$store->id)); ?>" class="nav-link"><?php echo e(translate('Transactions')); ?></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link active"><?php echo e(translate('Subscription_Refunds')); ?></a>
                </li>
            </ul>
        </div>

        <div class="card">
            <div class="card-header flex-wrap py-2 border-0">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <h4 class="mb-0"><?php echo e(translate('Transaction_History')); ?></h4>
                    <span class="badge badge-soft-dark rounded-circle"><?php echo e($transactions->total()); ?></span>
                </div>
                
                <!-- End Row -->
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-borderless middle-align __txt-14px">
                        <thead class="thead-light white--space-false">
                            <th class="border-top px-4 border-bottom text-center"><?php echo e(translate('sl')); ?></th>
                            <th class="border-top px-4 border-bottom"><div class="text-title"><?php echo e(translate('Transaction_Date')); ?></div></th>
                            <th class="border-top px-4 border-bottom"><?php echo e(translate('Package_Name')); ?></th>
                            <th class="border-top px-4 border-bottom"><?php echo e(translate('Refund_Amount')); ?></th>
                            <th class="border-top px-4 border-bottom"><?php echo e(translate('Refunded_for')); ?></th>
                            <th class="border-top px-4 border-bottom"><?php echo e(translate('Status')); ?></th>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=> $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>
                                <td class="px-4 text-center"><?php echo e($k + $transactions->firstItem()); ?></td>
                                <td class="px-4">
                                    <div class="pl-4"><?php echo e(\App\CentralLogics\Helpers::date_format($transaction->created_at)); ?></div>
                                </td>

                                <td class="px-4">
                                    <div class="text-title"><?php echo e($transaction?->package?->package_name); ?></div>
                                </td>

                                <td class="px-4">
                                    <div class="w--120px text-title text-right pr-5"><?php echo e(\App\CentralLogics\Helpers::format_currency($transaction->amount)); ?></div>
                                </td>
                                <td class="px-4">
                                    <div class="w--120px text-title text-right pr-5"><?php echo e(str_replace(['validity_left_'], '', $transaction->reference)); ?> <?php echo e(translate('messages.Days')); ?></div>
                                </td>


                                <td class="px-4">
                                    <span class="text-success">
                                        <?php echo e(translate('success')); ?>

                                    </span>

                                </td>

                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                    </table>
                </div>
                <?php if(count($transactions) !== 0): ?>
                <hr>
                <?php endif; ?>
                <div class="page-area">
                    <?php echo $transactions->withQueryString()->links(); ?>

                </div>
                <?php if(count($transactions) === 0): ?>
                <div class="empty--data">
                    <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                    <h5>
                        <?php echo e(translate('no_data_found')); ?>

                    </h5>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>




<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
<script>
    $("#date_from").on("change", function () {
        $('#date_to').attr('min',$(this).val());
    });

    $("#date_to").on("change", function () {
        $('#date_from').attr('max',$(this).val());
    });


        $(document).on('change','.filter', function () {
            if($(this).val() == 'custom'){
                $('#date_from').removeAttr('readonly').attr('name', 'start_date').attr('required', true);
                $('#date_to').removeAttr('readonly').attr('name', 'end_date').attr('required', true);
            }
            else{
                $('#date_from').attr('readonly',true).removeAttr('name', 'start_date').removeAttr('required');
                $('#date_to').attr('readonly',true).removeAttr('name', 'end_date').removeAttr('required');
            }
        });
        $(document).ready(function() {
            $('.printButton').click(function() {
                window.open($(this).data('url'), '_blank');
            });
        });

</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/subscription/subscriber/wallet-transaction.blade.php ENDPATH**/ ?>