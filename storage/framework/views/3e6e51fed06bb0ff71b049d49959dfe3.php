

<div class="d-flex flex-column align-items-center gap-1 mb-3">
    <h3 class="mb-3"><?php echo e(translate('withdraw_Information')); ?></h3>
    <div class="d-flex gap-2 align-items-center mb-1 flex-wrap">
        <span><?php echo e(translate('withdraw_Amount')); ?>:</span>
        <span class="font-semibold"><?php echo e(\App\CentralLogics\Helpers::format_currency($withdraw['amount'])); ?></span>
<?php if($withdraw->approved == 1): ?>
<label class="badge badge-soft-success mb-0"><?php echo e(translate('approved')); ?></label>

<?php elseif($withdraw->approved ==0): ?>
<label class="badge badge-soft-primary mb-0"><?php echo e(translate('Pending')); ?></label>
<?php else: ?>

<label class="badge badge-soft-danger mb-0"><?php echo e(translate('Denied')); ?></label>
<?php endif; ?>


    </div>
    <div class="d-flex gap-2 align-items-center fs-12">
        <span><?php echo e(translate('request_time')); ?>:</span>
        <span><?php echo e(\App\CentralLogics\Helpers::time_date_format($withdraw->created_at)); ?></span>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <h6 class="mb-0 font-medium"><?php echo e(translate('store_Info')); ?></h6>
    </div>
    <div class="card-body">
        <div class="key-val-list d-flex flex-column gap-2" style="--min-width: 60px">
            <div class="key-val-list-item d-flex gap-3">
                <span><?php echo e(translate('Name')); ?>:</span>
                <span><?php echo e($withdraw->vendor->stores[0]->name); ?></span>
            </div>
            <div class="key-val-list-item d-flex gap-3">
                <span><?php echo e(translate('Address')); ?>:</span>
                <a href="https://www.google.com/maps/search/?api=1&query=<?php echo e(data_get($withdraw->vendor->stores[0],'latitude',0)); ?>,<?php echo e(data_get($withdraw->vendor->stores[0],'longitude',0)); ?>" target="_blank"><?php echo e($withdraw->vendor->stores[0]['address']); ?></a>

            </div>
        </div>

        <div class="rounded bg-light p-3 mt-3">
            <div class="key-val-list-item d-flex gap-3">
                <span><?php echo e(translate('Store_Balance')); ?>:</span>
                <span class="font-semibold text-primary fs-16"> <?php echo e($withdraw->vendor->wallet->balance > 0 ? \App\CentralLogics\Helpers::format_currency($withdraw->vendor->wallet->balance) : 0); ?></span>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <h6 class="mb-0 font-medium"><?php echo e(translate('owner_Info')); ?></h6>
    </div>
    <div class="card-body">
        <div class="key-val-list d-flex flex-column gap-2" style="--min-width: 60px">
            <div class="key-val-list-item d-flex gap-3">
                <span><?php echo e(translate('Name')); ?>:</span>
                <span><?php echo e($withdraw->vendor->f_name.' '.$withdraw->vendor->l_name); ?></span>
            </div>
            <div class="key-val-list-item d-flex gap-3">
                <span><?php echo e(translate('Email')); ?>:</span>
                <a href="mailto:<?php echo e($withdraw->vendor->email); ?>" class="text-dark"><?php echo e($withdraw->vendor->email); ?></a>
            </div>
            <div class="key-val-list-item d-flex gap-3">
                <span><?php echo e(translate('Phone')); ?>:</span>
                <a href="tel:<?php echo e($withdraw->vendor->phone); ?>" class="text-dark"><?php echo e($withdraw->vendor->phone); ?></a>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <h6 class="mb-0 font-medium"><?php echo e(translate('payment_Info')); ?></h6>
    </div>
    <div class="card-body">
        <div class="key-val-list d-flex flex-column gap-2" style="--min-width: 60px">
          <div class="key-val-list-item d-flex gap-3">
            <span><?php echo e(translate('method')); ?>:</span>
            <span><?php echo e($withdraw?->method?->method_name); ?></span>
        </div>
        <?php if($withdraw?->withdrawal_method_fields): ?>
        <?php $__currentLoopData = json_decode($withdraw?->withdrawal_method_fields, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="key-val-list-item d-flex gap-3">
                <span><?php echo e(translate($key)); ?>:</span>
                <span><?php echo e(is_array($item) ? '' : htmlspecialchars($item)); ?></span>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <h5 class="text-capitalize"><?php echo e(translate('messages.No_Data_found')); ?></h5>
        <?php endif; ?>
        </div>
    </div>
</div>

    <?php if($withdraw->approved == 1): ?>
    <div class="">
        <h5 class="font-medium"><?php echo e(translate('approved_Note')); ?></h5>
        <div class="rounded bg-light p-3">
            <?php echo e(str_replace('_' ,' ' ,$withdraw->transaction_note)); ?>

        </div>
        <?php elseif($withdraw->approved == 2): ?>
    </div> <div class="">
        <h5 class="font-medium"><?php echo e(translate('Denial_Note')); ?></h5>
        <div class="rounded bg-light p-3">
            <?php echo e(str_replace('_' ,' ' ,$withdraw->transaction_note)); ?>

        </div>
    </div>
    <?php endif; ?>

    <?php if($withdraw->approved == 0): ?>
    <div class="mt-4 d-flex justify-content-center gap-3">
        <button type="button" data-id="<?php echo e($withdraw->id); ?>" class="btn btn-soft-danger withdraw-info-hide min-w-100px show-deny-view"><?php echo e(translate('deny')); ?></button>
        <button type="button" data-id="<?php echo e($withdraw->id); ?>" class="btn btn-success withdraw-info-hide min-w-100px show-approve-view"><?php echo e(translate('approve')); ?></button>
    </div>
    <?php endif; ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/wallet/partials/_side_view.blade.php ENDPATH**/ ?>