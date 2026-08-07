<div class="d-flex flex-column gap-3">
     <?php $__currentLoopData = $reasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $reason): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <div class="d-flex align-item-center justify-content-between cursor-pointer">
            <label class="form-check-label fs-14 m-0" for="cancalation_address_<?php echo e($key); ?>">
                <?php echo e($reason['reason']); ?>

            </label>
            <div class="form-check m-0">
                <input class="form-check-input checkbox-theme-20 single-select" type="checkbox" value="<?php echo e($reason['reason']); ?>"
                    name="reason[]" id="cancalation_address_<?php echo e($key); ?>">
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/order/partials/_parcel_cancellation_reasons.blade.php ENDPATH**/ ?>