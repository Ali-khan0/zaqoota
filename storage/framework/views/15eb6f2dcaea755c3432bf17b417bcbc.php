<?php if(count($combinations) > 0): ?>
    <table class="table table-borderless table--vertical-middle">
        <thead class="thead-light __bg-7">
        <tr>
            <th class="text-center border-0">
                <span class="control-label m-0"><?php echo e(translate('messages.Variant')); ?></span>
            </th>
            <th class="text-center border-0">
                <span class="control-label"><?php echo e(translate('messages.Variant Price')); ?></span>
            </th>
            <?php if($stock): ?>
                <th class="text-center border-0">
                    <span class="control-label text-capitalize"><?php echo e(translate('messages.stock')); ?></span>
                </th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>

        <?php $__currentLoopData = $combinations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $combination): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="text-center">
                    <label class="control-label m-0"><?php echo e($combination['type']); ?></label>
                    <input value="<?php echo e($combination['type']); ?>" name="type[]" type="hidden">
                </td>
                <td>
                    <input type="number" name="price_<?php echo e($combination['type']); ?>"
                           value="<?php echo e($combination['price']); ?>" min="0"
                           step="0.01"
                           class="form-control" required>
                </td>
                <?php if($stock): ?>
                    <td>
                        <input type="number" onkeyup="update_qty()" name="stock_<?php echo e($combination['type']); ?>" value="<?php echo e($combination['stock']??0); ?>" min="0" step="0.01"
                                class="form-control" required>
                    </td>
                <?php endif; ?>

            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
<?php endif; ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/product/partials/_edit-combinations.blade.php ENDPATH**/ ?>