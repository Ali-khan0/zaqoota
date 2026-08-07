<?php if(count($combinations[0]) > 0): ?>
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




















            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $combination): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(strlen($combination['name']) > 0): ?>
                    <tr>
                        <td class="text-center">
                            <label class="control-label m-0"><?php echo e($combination['name']); ?></label>
                        </td>
                        <td class="error-wrapper">
                            <input type="number" name="price_<?php echo e($combination['name']); ?>" value="<?php echo e($combination['price']); ?>" min="0" step="0.01"
                                   class="form-control" required>
                        </td>
                        <?php if($stock): ?>
                            <td class="error-wrapper"><input type="number" name="stock_<?php echo e($combination['name']); ?>" value="<?php echo e($combination['stock']); ?>" min="0"
                                       class="form-control" required></td>
                        <?php endif; ?>

                    </tr>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <script>
        "use strict";
        update_qty();
        function update_qty()
        {
            let total_qty = 0;
            let qty_elements = $('input[name^="stock_"]');
            for(let i=0; i<qty_elements.length; i++)
            {
                total_qty += parseInt(qty_elements.eq(i).val());
            }
            if(qty_elements.length > 0)
            {

                $('input[name="current_stock"]').attr("readonly", true);
                $('input[name="current_stock"]').val('wrfrwf');
            }
            else{
                $('input[name="current_stock"]').attr("readonly", false);
            }
        }
        $('input[name^="stock_"]').on('keyup', function () {
            let total_qty = 0;
            let qty_elements = $('input[name^="stock_"]');
            for(let i=0; i<qty_elements.length; i++)
            {
                total_qty += parseInt(qty_elements.eq(i).val());
            }
            $('input[name="current_stock"]').val(total_qty);
        });

        $('.update_qty').on('keyup', function () {
            update_qty();
        });

    </script>
<?php endif; ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/product/partials/_variant-combinations.blade.php ENDPATH**/ ?>