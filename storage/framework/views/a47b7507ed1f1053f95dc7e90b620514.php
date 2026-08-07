
<?php
$keys = array_keys($cart_product_ids);
$index = array_search($product->id, $keys);

?>


<div class="pos-product-card <?php echo e(in_array($product->id,array_keys($cart_product_ids))?'active quick-View-Cart-Item':' quick-View'); ?> product-card card  h-100"
    data-product-id="<?php echo e($product->id); ?>" data-item-key="<?php echo e($index ?? null); ?>"
    data-id="<?php echo e($product->id); ?>" data-item-count="<?php echo e(isset($cart_product_ids[$product->id])?$cart_product_ids[$product->id]:0); ?>">
    <div class="inline_product clickable p-0 initial--31">
        <div class="d-flex align-items-center justify-content-center h-100 d-block w-100 ">
            <img
            src="<?php echo e($product['image_full_url'] ?? asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
            data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                class="w-100 h-100 object-cover onerror-image" alt="image">
        </div>
    </div>

    <div class="card-body inline_product text-center p-1 clickable">
        <div class="product-title text-dark text-capitalize max-text-2-line">
            
            <?php echo e($product['name']); ?>

        </div>
        <div class="product-price text-center mt-2">
            <span class="text-primary font-weight-bold">
                <?php echo e(\App\CentralLogics\Helpers::format_currency($product['price']-\App\CentralLogics\Helpers::product_discount_calculate($product, $product['price'], $store_data)['discount_amount'])); ?>

            </span>
        </div>
    </div>
</div>
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/common.js"></script>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/pos/_single_product.blade.php ENDPATH**/ ?>