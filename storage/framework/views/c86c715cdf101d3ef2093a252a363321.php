
<h3 class="modal-title text-center fs-20 mb-4"><?php echo e(translate('messages.stock_Update')); ?></h3>

<div class="d-flex gap-4 mb-3">
    <img class="rounded img--100"  src="<?php echo e($product['image_full_url'] ?? asset('public/assets/admin/img/160x160/img2.jpg')); ?>"alt="product">
    <div>
        <div class="d-flex gap-2 fs-16 align-items-center">
            <span><?php echo e(translate('Product_Name')); ?> </span>:
            <span class="font-semibold text-dark"><?php echo e($product->name); ?></span>
        </div>
        <div class="d-flex gap-2 fs-16 align-items-center">
            <span><?php echo e(translate('Current_Stock')); ?> </span>:
            <span class="font-semibold text-dark"><?php echo e($product->stock); ?></span>
        </div>
    </div>
</div>

<input name="product_id" value="<?php echo e($product->id); ?>" type="hidden" class="initial-hidden">
<div id="quantity" class="form-group error-wrapper">
    <label for="total_qty" class="input-label" >
        <?php echo e(translate('Total_Quantity')); ?>

    </label>
    <input type="number" min="1" class="form-control" id="total_qty" name="current_stock" value="<?php echo e($product->stock); ?>" id="quantity" <?php echo e(count(json_decode($product['variations'],true)) > 0 ? 'readonly' : ""); ?>>
</div>

<?php if(count(json_decode($product['variations'],true)) > 0): ?>

<div class="table-responsive mb-5">
    <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle mb-0">
        <thead class="bg-E5F5F6">
            <tr>
                <th class="text--title fs-20"><?php echo e(translate('SL')); ?></th>
                <th class="text--title fs-20"><?php echo e(translate('Variant')); ?></th>
                <th class="text--title fs-20 "><?php echo e(translate('Price')); ?></th>
                <th class="text--title fs-20 "><?php echo e(translate('Stock')); ?></th>
            </tr>
        </thead>
        <tbody id="set-rows">
            <?php $__currentLoopData = json_decode($product['variations'],true) ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $combination): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class=""><?php echo e($key + 1); ?></td>
                    <td class="">
                        <?php echo e($combination['type']); ?>



                    </td>
                    <td class="error-wrapper">
                        <input value="<?php echo e($combination['type']); ?>" name="type[]" type="hidden">
                        <input type="number" name="price_<?php echo e($key); ?>_<?php echo e($combination['type']); ?>"
                        value="<?php echo e($combination['price'] ?? 0); ?>" min="0"
                        step="0.01"
                        class="form-control" >
                    </td>
                    <td class="w-200 error-wrapper">
                        <input type="number" name="stock_<?php echo e($key); ?>_<?php echo e($combination['type']); ?>"
                            value="<?php echo e($combination['stock'] ?? 0); ?>" min="1" max="999999999" class="form-control update_qty"
                            required>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<script>

    $('.update_qty').on('keyup', function () {
            update_qty();
        });

</script>
<?php /**PATH /var/www/zaqoota/resources/views/admin-views/product/partials/_get_stock_data.blade.php ENDPATH**/ ?>