<div class="d-flex flex-row cart--table-scroll px-2">
    <table class="table table--vertical-middle">
        <thead class="text-muted thead-light">
            <tr class="text-center">
                <th class="border-bottom-0 border-top-0" scope="col"><?php echo e(translate('messages.food')); ?></th>
                <th class="border-bottom-0 border-top-0" scope="col"><?php echo e(translate('messages.QTY')); ?></th>
                <th class="border-bottom-0 border-top-0 text-right" scope="col"><?php echo e(translate('messages.Unit_price')); ?></th>
                <th class="border-bottom-0 border-top-0" scope="col"><?php echo e(translate('messages.delete')); ?></th>
            </tr>
        </thead>
        <tbody class="border-left border-right border-bottom">
        <?php
            $subtotal = 0;
            $addon_price = 0;
            $tax = session()->get('tax_amount');
            $discount = 0;
            $discount_type = 'amount';
            $discount_on_product = 0;
            $variation_price  = 0;
        ?>
        <?php if(session()->has('cart') && count( session()->get('cart')) > 0): ?>
            <?php
                $cart = session()->get('cart');
                if(isset($cart['discount']))
                {
                    $discount = $cart['discount'];
                    $discount_type = $cart['discount_type'];
                }
            ?>
            <?php $__currentLoopData = session()->get('cart'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cartItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <?php if(is_array($cartItem)): ?>
                <?php
                $variation_price += $cartItem['variation_price'] ?? 0;
                $product_subtotal = ($cartItem['price'])*$cartItem['quantity'];
                $discount_on_product += ($cartItem['discount']*$cartItem['quantity']);
                $subtotal += $product_subtotal;
                $addon_price += $cartItem['addon_price'];
                ?>
            <tr>
                <td class="media align-items-center cursor-pointer quick-View-Cart-Item" data-product-id="<?php echo e($cartItem['id']); ?>" data-item-key="<?php echo e($key); ?>">
                    <img class="avatar avatar-sm mr-1 onerror-image"
                    src="<?php echo e($cartItem['image_full_url']); ?>" data-onerror-image="<?php echo e(asset('public/assets/admin/img/100x100/2.png')); ?>" alt="<?php echo e($cartItem['name']); ?> image">
                    <div class="media-body">
                        <h6 class="text-hover-primary mb-0 fs-12"><?php echo e(Str::limit($cartItem['name'], 14)); ?></h6>
                        <small><?php echo e(Str::limit($cartItem['variant'], 20)); ?></small>
                    </div>
                </td>
                <td class="text-center middle-align">
                    <input type="number"  data-key="<?php echo e($key); ?>"  class="amount--input form-control text-center update-Quantity" data-oldvalue="<?php echo e($cartItem['quantity']); ?>" value="<?php echo e($cartItem['quantity']); ?>" min="1"
                    max="<?php echo e((isset($cartItem['stock_quantity']) && $cartItem['stock_quantity'] > 0) ?   ($cartItem['maximum_cart_quantity'] ?  min($cartItem['stock_quantity'], $cartItem['maximum_cart_quantity']) : $cartItem['stock_quantity'])  : $cartItem['maximum_cart_quantity'] ??  '9999999999'); ?>" >
                </td>
                <td class="text-right fs-14 font-medium">
                    <?php echo e(\App\CentralLogics\Helpers::format_currency($product_subtotal)); ?>

                </td>
                <td>
                    <div class="d-flex justify-content-center">
                        <a href="javascript:" data-product-id="<?php echo e($key); ?>" class="pos-cart-remove-btn remove-From-Cart rounded-circle"> <i class="tio-delete-outlined"></i></a>
                    </div>
                </td>
            </tr>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
    $total = $subtotal + $addon_price;

    if ($discount_type == 'percent' && $discount > 0) {
        $discount_amount = (($total - $discount_on_product) * $discount) / 100;
    } else {
        $discount_amount = $discount;
    }

    $total -= ($discount_amount + $discount_on_product);

    $tax_amount = session()->get('tax_amount');
    $tax_included = session()->get('tax_included');
//    $tax_included = ($tax_included && $tax_amount > 0) ? 1 : 0;

    $delivery_fee = session()->get('address.delivery_fee', 0);
    $total += $delivery_fee;
?>

<div class="box p-3">
    <dl class="row text-dark">
        <?php if(Config::get('module.current_module_type') == 'food'): ?>

        <dd  class="col-6"><?php echo e(translate('messages.addon')); ?>:</dd>
        <dd class="col-6 text-right"><?php echo e(\App\CentralLogics\Helpers::format_currency($addon_price)); ?></dd>
        <?php endif; ?>

        <dd  class="col-6"><?php echo e(translate('messages.subtotal')); ?>

            <?php if($tax_included ==  1): ?>
                (<?php echo e(translate('messages.TAX_Included')); ?>)
                <?php ($tax_amount=0); ?>
            <?php endif; ?>
            :</dd>
        <dd class="col-6 text-right"><?php echo e(\App\CentralLogics\Helpers::format_currency($subtotal+$addon_price)); ?></dd>


        
        

        <dd  class="col-6"><?php echo e(translate('messages.discount')); ?> :</dd>
        <dd class="col-6 text-right">- <?php echo e(\App\CentralLogics\Helpers::format_currency(round($discount_on_product,2))); ?></dd>
        <dd class="col-6"><?php echo e(translate('messages.delivery_fee')); ?> :</dd>
        <dd class="col-6 text-right" id="delivery_price">
            <?php echo e(\App\CentralLogics\Helpers::format_currency($delivery_fee)); ?></dd>
        <?php if($tax_included !=  1): ?>
            <dd  class="col-6"><?php echo e(translate('messages.tax')); ?>  : </dd>
            <dd class="col-6 text-right">
            <?php echo e(\App\CentralLogics\Helpers::format_currency(round($tax_amount,2))); ?></dd>
        <?php endif; ?>
        <dd  class="col-6 pr-0">
            <hr class="my-0">
        </dd>
        <dd  class="col-6 pl-0">
            <hr class="my-0">
        </dd>
        <dt  class="col-6"><?php echo e(translate('messages.total')); ?>  : </dt>
        <dt class="col-6 text-right">
            <?php echo e(\App\CentralLogics\Helpers::format_currency(round($total+$tax_amount, 2))); ?>

        </dt>
    </dl>

    <form action="<?php echo e(route('admin.pos.order')); ?>?store_id=<?php echo e(request('store_id')); ?>" id='order_place' method="post" >
        <?php echo csrf_field(); ?>
        <input type="hidden" name="user_id" id="customer_id">
        <div class="pos--payment-options mt-3 mb-3">
            <p class="mb-3"><?php echo e(translate('paid_By')); ?></p>
            <ul>
                <?php ($cod=\App\CentralLogics\Helpers::get_business_settings('cash_on_delivery')); ?>
                <?php if($cod['status']): ?>
                <li>
                    <label>
                        <input type="radio" name="type" value="cash" hidden checked>
                        <span><?php echo e(translate('Cash On Delivery')); ?></span>
                    </label>
                </li>
                <?php endif; ?>
                <?php ($wallet=\App\CentralLogics\Helpers::get_business_settings('wallet_status')); ?>
                <?php if($wallet): ?>
                <li>
                    <label>
                        <input type="radio" name="type" value="wallet" hidden <?php echo e($cod['status']? '':'checked'); ?>>
                        <span><?php echo e(translate('Wallet')); ?></span>
                    </label>
                </li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="row button--bottom-fixed g-1 bg-white">
            <div class="col-sm-6">
                <button type="button" class="btn h-100  btn-outline-danger btn-block empty-Cart" <?php echo e((session()->has('cart') && count( session()->get('cart')) > 0)?'':'disabled'); ?>><?php echo e(translate('messages.Clear Cart')); ?> </button>
            </div>
            <div class="col-sm-6">
                <button type="submit" class="btn  btn--primary place-order-submit btn-block"><?php echo e(translate('messages.place_order')); ?> </button>
            </div>
        </div>
    </form>
</div>


<div class="modal fade" id="couponModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modal-scroll">
            <div class="modal-header pt-3 pb-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4 pt-0">
                <div class="text-center">
                    <h3 class="modal-title flex-grow-1 text-center"><?php echo e(translate('Coupon Discount')); ?></h3>
                    <p>Select from available coupon or input code</p>
                </div>
                <div>
                    <div class="mb-4">
                        <label class="form-label">Available Coupons</label>
                        <div class="coupon-slider owl-carousel owl-theme">
                            <div class="coupon-slider-item">
                                <button class="coupon-slider-button active" type="button">
                                    <div class="left">
                                        <h6>Code : NewUser</h6>
                                        <small>Use it in 1st order</small>
                                    </div>
                                    <div class="right">
                                        <h6>10%</h6>
                                        <small>Discount</small>
                                    </div>
                                    <i class="tio-checkmark-circle checkmark"></i>
                                </button>
                            </div>
                            <div class="coupon-slider-item">
                                <button class="coupon-slider-button" type="button">
                                    <div class="left">
                                        <h6>Code : NewUser</h6>
                                        <small>Use it in 1st order</small>
                                    </div>
                                    <div class="right">
                                        <h6>10%</h6>
                                        <small>Discount</small>
                                    </div>
                                    <i class="tio-checkmark-circle checkmark"></i>
                                </button>
                            </div>
                            <div class="coupon-slider-item">
                                <button class="coupon-slider-button" type="button">
                                    <div class="left">
                                        <h6>Code : NewUser</h6>
                                        <small>Use it in 1st order</small>
                                    </div>
                                    <div class="right">
                                        <h6>10%</h6>
                                        <small>Discount</small>
                                    </div>
                                    <i class="tio-checkmark-circle checkmark"></i>
                                </button>
                            </div>
                            <div class="coupon-slider-item">
                                <button class="coupon-slider-button" type="button">
                                    <div class="left">
                                        <h6>Code : NewUser</h6>
                                        <small>Use it in 1st order</small>
                                    </div>
                                    <div class="right">
                                        <h6>10%</h6>
                                        <small>Discount</small>
                                    </div>
                                    <i class="tio-checkmark-circle checkmark"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <label class="form-label">Coupon Code</label>
                    <input type="text" class="form-control">
                    <div class="btn--container justify-content-end mt-20">
                        <button class="btn btn--reset" type="button" data-dismiss="modal">
                            Cancel
                        </button>
                        <button class="btn btn-sm btn--primary text-white" type="button">
                            Apply
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="deliveryAddrModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modal-scroll">
            <div class="modal-header bg-light border-bottom py-3">
                <h4 class="modal-title flex-grow-1 text-center"><?php echo e(translate('delivery_options')); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <?php if($store): ?>
            <div class="modal-body p-xxl-4 p-3">
                <?php
                    if(session()->has('address')) {
                        $old = session()->get('address');
                    }else {
                        $old = null;
                    }
                ?>
                <form id='delivery_address_store'>
                    <?php echo csrf_field(); ?>

                    <div class="row g-2" id="delivery_address">
                        <div class="col-md-6">
                            <label class="input-label"
                                for="contact_person_name"><?php echo e(translate('messages.contact_person_name')); ?><span
                                            class="input-label-secondary text-danger">*</span></label>
                            <input  id="contact_person_name" type="text" class="form-control" name="contact_person_name"
                                value="<?php echo e($old ? $old['contact_person_name'] : ''); ?>" placeholder="<?php echo e(translate('messages.Ex :')); ?> Jhone">
                        </div>
                        <div class="col-md-6">
                            <label class="input-label"
                                for="contact_person_number"><?php echo e(translate('Contact Number')); ?><span
                                            class="input-label-secondary text-danger">*</span></label>
                            <input id="contact_person_number" type="tel" class="form-control" name="contact_person_number"
                                value="<?php echo e($old ? $old['contact_person_number'] : ''); ?>"  placeholder="<?php echo e(translate('messages.Ex :')); ?> +3264124565">
                        </div>
                        <div class="col-md-6">
                            <label class="input-label" for="road"><?php echo e(translate('messages.Road')); ?></label>
                            <input id="road" type="text" class="form-control" name="road" value="<?php echo e($old ? $old['road'] : ''); ?>"  placeholder="<?php echo e(translate('messages.Ex :')); ?> 4th">
                        </div>
                        <div class="col-md-3">
                            <label  class="input-label" for="house"><?php echo e(translate('messages.House')); ?></label>
                            <input id="house" type="text" class="form-control" name="house" value="<?php echo e($old ? $old['house'] : ''); ?>" placeholder="<?php echo e(translate('messages.Ex :')); ?> 45/C">
                        </div>
                        <div class="col-md-3">
                            <label class="input-label" for="floor"><?php echo e(translate('messages.Floor')); ?></label>
                            <input id="floor" type="text" class="form-control" name="floor" value="<?php echo e($old ? $old['floor'] : ''); ?>"  placeholder="<?php echo e(translate('messages.Ex :')); ?> 1A">
                        </div>
                    </div>

                    <div class="border p-3 mt-3 rounded border-success">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="input-label" for="longitude"><?php echo e(translate('messages.longitude')); ?><span
                                                class="input-label-secondary text-danger">*</span></label>
                                <input  type="text" class="form-control" id="longitude" name="longitude"
                                    value="<?php echo e($old ? $old['longitude'] : ''); ?>" readonly >
                            </div>
                            <div class="col-md-6">
                                <label class="input-label" for="latitude"><?php echo e(translate('messages.latitude')); ?><span
                                                class="input-label-secondary text-danger">*</span></label>
                                <input  type="text" class="form-control" id="latitude" name="latitude"
                                    value="<?php echo e($old ? $old['latitude'] : ''); ?>" readonly>
                            </div>
                            <div class="col-md-12">
                                <label class="input-label" for="address"><?php echo e(translate('messages.address')); ?></label>
                                <textarea id="address" name="address" class="form-control" cols="30" rows="3" placeholder="<?php echo e(translate('messages.Ex :')); ?> address"><?php echo e($old ? $old['address'] : ''); ?></textarea>
                            </div>
                            <div class="col-12">
                                <div class="d-flex flex-wrap gap-1 justify-content-between mb-3">
                                    <div>
                                        <span class="text-danger">*</span>
                                        <?php echo e(translate(' pin the address in the map to calculate delivery fee')); ?>

                                    </div>
                                    <div class="btn btn--primary text-white">
                                        <input type="hidden" name="distance" id="distance">
                                        <span><?php echo e(translate('Delivery fee')); ?> :</span>
                                        <input type="hidden" name="delivery_fee" id="delivery_fee" value="<?php echo e($old ? $old['delivery_fee'] : ''); ?>">
                                        <strong><?php echo e($old ? $old['delivery_fee'] : 0); ?> <?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?></strong>
                                    </div>
                                </div>
                                <input id="pac-input" class="controls map-search__option rounded initial-8"
                                    title="<?php echo e(translate('messages.search_your_location_here')); ?>" type="text"
                                    placeholder="<?php echo e(translate('messages.search_here')); ?>" />
                                <div class="mb-2 h-200px" id="map"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="btn--container justify-content-end mt-20">
                            <button class="btn btn-sm btn--primary w-100 delivery-Address-Store" type="button">
                                <?php echo e(translate('Update_Delivery address')); ?>

                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <?php else: ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="text-center">
                            <h2>
                                <?php echo e(translate('messages.please_select_a_store_first')); ?>

                            </h2>
                            <button data-dismiss="modal" class="btn btn-primary"><?php echo e(translate('messages.Ok')); ?></button>
                        </div>
                    </div>
                </div>
            </div>

            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/common.js"></script>
    <script>
        $(document).ready(function(){
            $('.coupon-slider').owlCarousel({
                margin: 15,
                loop: false,
                autoWidth: true,
                items: 3,
            })

        })
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/pos/_cart.blade.php ENDPATH**/ ?>