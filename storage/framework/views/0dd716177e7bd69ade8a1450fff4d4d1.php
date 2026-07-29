<div class="d-flex flex-row cart--table-scroll">
    <table class="table table-bordered">
        <thead class="text-muted thead-light">
            <tr class="text-center">
                <th class="border-bottom-0" scope="col"><?php echo e(translate('messages.item')); ?></th>
                <th class="border-bottom-0" scope="col"><?php echo e(translate('messages.qty')); ?></th>
                <th class="border-bottom-0" scope="col"><?php echo e(translate('messages.price')); ?></th>
                <th class="border-bottom-0" scope="col"><?php echo e(translate('messages.delete')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $subtotal = 0;
            $addon_price = 0;
            $tax = session()->get('tax_amount');
            $discount = 0;
            $discount_type = 'amount';
            $discount_on_product = 0;
            $variation_price = 0;
            ?>
            <?php if(session()->has('cart') && count(session()->get('cart')) > 0): ?>
                <?php
                $cart = session()->get('cart');
                if (isset($cart['discount'])) {
                    $discount = $cart['discount'];
                    $discount_type = $cart['discount_type'];
                }
                ?>
                <?php $__currentLoopData = session()->get('cart'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cartItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(is_array($cartItem)): ?>
                        <?php
                        $variation_price +=  $cartItem['variation_price'] ?? 0;
                        $product_subtotal = $cartItem['price'] * $cartItem['quantity'];
                        $discount_on_product += $cartItem['discount'] * $cartItem['quantity'];
                        $subtotal += $product_subtotal;
                        $addon_price += $cartItem['addon_price'];
                        ?>
                        <tr>
                            <td class="media align-items-center cursor-pointer quick-View-Cart-Item"
                                data-product-id="<?php echo e($cartItem['id']); ?>" data-item-key="<?php echo e($key); ?>">
                                <img class="avatar avatar-sm mr-1 onerror-image"
                                     data-onerror-image="<?php echo e(asset('public/assets/admin/img/100x100/2.png')); ?>"
                                     src="<?php echo e($cartItem['image_full_url']); ?>"

                                    alt="<?php echo e($cartItem['name']); ?> image">
                                <div class="media-body">
                                    <h5 class="text-hover-primary mb-0"><?php echo e(Str::limit($cartItem['name'], 10)); ?></h5>
                                    <small><?php echo e(Str::limit($cartItem['variant'], 20)); ?></small>
                                </div>
                            </td>
                            <td class="text-center middle-align">
                                <input type="number" data-key="<?php echo e($key); ?>"
                                    class="amount--input form-control text-center  update-Quantity" value="<?php echo e($cartItem['quantity']); ?>"
                                    min="1" max="<?php echo e($cartItem['maximum_cart_quantity']?? '9999999999'); ?>" >
                            </td>
                            <td class="text-center px-0 py-1">
                                <div class="btn">
                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($product_subtotal)); ?>

                                </div>
                            </td>
                            <td class="align-items-center text-center ">
                                <a href="javascript:"  data-product-id="<?php echo e($key); ?>"
                                    class="btn btn-sm btn-outline-danger remove-From-Cart"> <i class="tio-delete-outlined"></i></a>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
    $add = false;
    if (session()->has('address') && count(session()->get('address')) > 0) {
        $add = true;
        $delivery_fee = session()->get('address')['delivery_fee'];
    } else {
        $delivery_fee = 0;
    }

    $total = $subtotal + $addon_price;

    if ($discount_type == 'percent' && $discount > 0) {
        $discount_amount = (($total - $discount_on_product) * $discount) / 100;
    } else {
        $discount_amount = $discount;
    }

    $total -= $discount_amount + $discount_on_product;

    $tax_amount = session()->get('tax_amount');
    $tax_included = session()->get('tax_included');

    if ($tax_included ==  1){
        $tax_amount = 0;
    }

    $total += $delivery_fee;

    if (isset($cart['paid'])) {
        $paid = $cart['paid'];
        $change = $total + $tax_amount - $paid;
    } else {
        $paid = $total + $tax_amount;
        $change = 0;
    }
?>
<form action="<?php echo e(route('vendor.pos.order')); ?>" id='order_place' method="post">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="user_id" id="customer_id">
    <div class="box p-3">
        <dl class="row">

            <dt class="col-6 font-regular"><?php echo e(translate('messages.addon')); ?>:</dt>
            <dd class="col-6 text-right"><?php echo e(\App\CentralLogics\Helpers::format_currency($addon_price)); ?></dd>

            <dt class="col-6 font-regular"><?php echo e(translate('messages.subtotal')); ?>

                <?php if($tax_included ==  1): ?>
                (<?php echo e(translate('messages.TAX_Included')); ?>)
                <?php endif; ?>
                :</dt>
            <dd class="col-6 text-right"><?php echo e(\App\CentralLogics\Helpers::format_currency($subtotal + $addon_price)); ?></dd>


            <dt class="col-6 font-regular"><?php echo e(translate('messages.discount')); ?> :</dt>
            <dd class="col-6 text-right">-
                <?php echo e(\App\CentralLogics\Helpers::format_currency(round($discount_on_product, 2))); ?></dd>
            <dt class="col-6 font-regular"><?php echo e(translate('messages.delivery_fee')); ?> :</dt>
            <dd class="col-6 text-right" id="delivery_price">
                <?php echo e(\App\CentralLogics\Helpers::format_currency($delivery_fee)); ?></dd>

            <dt class="col-6 font-regular"><?php echo e(translate('messages.extra_discount')); ?> :</dt>
            <dd class="col-6 text-right"><button class="btn btn-sm" type="button" data-toggle="modal"
                    data-target="#add-discount"><i class="tio-edit"></i></button>-
                <?php echo e(\App\CentralLogics\Helpers::format_currency(round($discount_amount, 2))); ?></dd>
            <?php if($tax_included !=  1): ?>
                <dt class="col-6 font-regular"><?php echo e(translate('messages.tax')); ?> : </dt>
                <dd class="col-6 text-right">



                    <?php echo e(\App\CentralLogics\Helpers::format_currency(round($tax_amount, 2))); ?>

                </dd>
            <?php endif; ?>
            <dd class="col-12">
                <hr class="m-0">
            </dd>
            <input type="hidden" id='total_order_amount' value="<?php echo e(round($total + $tax_amount, 2)); ?>">
            <dt class="col-6 font-regular"><?php echo e(translate('Total')); ?>: </dt>
            <dd class="col-6 text-right h4 b">
                <?php echo e(\App\CentralLogics\Helpers::format_currency(round($total + $tax_amount, 2))); ?> </dd>
        </dl>
        <div class="pos--payment-options mt-3 mb-3">
            <h5 class="mb-3"><?php echo e(translate($add ? 'messages.Payment Method' : 'Paid by')); ?></h5>
            <ul>
                <?php if($add): ?>
                    <?php ($cod = \App\CentralLogics\Helpers::get_business_settings('cash_on_delivery')); ?>
                    <?php if($cod['status']): ?>
                        <li>
                            <label>
                                <input type="radio" name="type" value="cash_on_delivery" hidden checked>
                                <span><?php echo e(translate('Cash On Delivery')); ?></span>
                            </label>
                        </li>
                    <?php endif; ?>
                <?php else: ?>
                    <li id="payment_cash">
                        <label>
                            <input type="radio" name="type" value="cash" hidden="" checked>
                            <span><?php echo e(translate('messages.Cash')); ?></span>
                        </label>
                    </li>
                    <li id="payment_card">
                        <label>
                            <input type="radio" name="type" value="card" hidden="">
                            <span><?php echo e(translate('messages.Card')); ?></span>
                        </label>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
        <?php if(!$add): ?>
            <div id="paid_section">
                <div class="mt-4 d-flex justify-content-between pos--payable-amount">
                    <label class="m-0"><?php echo e(translate('Paid Amount')); ?> :</label>
                    <div>
                        <span data-toggle="modal" data-target="#insertPayableAmount" class="text-body"><i
                                class="tio-edit"></i></span>
                        <span><?php echo e(\App\CentralLogics\Helpers::format_currency($paid)); ?></span>
                        <input type="hidden" name="amount" value="<?php echo e($paid); ?>">
                    </div>
                </div>
                <div class="mt-4 d-flex justify-content-between pos--payable-amount">
                    <label class="m-0"><?php echo e(translate('Change Amount')); ?> :</label>
                    <div>
                        <span><?php echo e(\App\CentralLogics\Helpers::format_currency($change)); ?></span>
                        <input type="hidden" value="<?php echo e($change); ?>">
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="row button--bottom-fixed g-1 bg-white">
            <div class="col-sm-6">
                <button type="submit" class="btn  btn--primary btn-sm btn-block place-order-submit"><?php echo e(translate('place_order')); ?>

                </button>
            </div>
            <div class="col-sm-6">
                <a href="#" class="btn btn--reset btn-sm btn-block empty-Cart"
                    ><?php echo e(translate('Clear Cart')); ?></a>
            </div>
        </div>
    </div>
</form>
<div class="modal fade" id="insertPayableAmount" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light border-bottom py-3">
                <h5 class="modal-title"><?php echo e(translate('messages.payment')); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id='payable_store_amount'>
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="form-group col-12">
                            <label class="input-label"
                                for="paid"><?php echo e(translate('messages.amount')); ?>(<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)</label>
                            <input type="number" class="form-control"  id="paid" name="paid" min="0" step="0.01"
                                value="<?php echo e($paid); ?>">
                        </div>
                    </div>
                    <div class="form-group col-12 mb-0">
                        <div class="btn--container justify-content-end">
                            <button class="btn btn-sm btn--primary payable-amount" type="button" >
                                <?php echo e(translate('messages.submit')); ?>

                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="add-discount" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo e(translate('messages.update_discount')); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo e(route('vendor.pos.discount')); ?>" method="post" class="row">
                    <?php echo csrf_field(); ?>
                    <div class="form-group col-sm-6">
                        <label for="discount_input"><?php echo e(translate('messages.discount')); ?></label>
                        <input type="number" class="form-control" name="discount" min="0"
                            id="discount_input" value="<?php echo e($discount); ?>"
                            max="<?php echo e($discount_type == 'percent' ? 100 : 1000000000); ?>">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="discount_input_type"><?php echo e(translate('messages.type')); ?></label>
                        <select name="type" class="form-control" id="discount_input_type" >
                            <option value="amount" <?php echo e($discount_type == 'amount' ? 'selected' : ''); ?>>
                                <?php echo e(translate('messages.amount')); ?>(<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)
                            </option>
                            <option value="percent" <?php echo e($discount_type == 'percent' ? 'selected' : ''); ?>>
                                <?php echo e(translate('messages.percent')); ?>(%)</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-12">
                        <button class="btn btn-sm btn--primary"
                            type="submit"><?php echo e(translate('messages.submit')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add-tax" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo e(translate('messages.update_tax')); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo e(route('vendor.pos.tax')); ?>" method="POST" class="row" id="order_submit_form">
                    <?php echo csrf_field(); ?>
                    <div class="form-group col-12">
                        <label for="tax"><?php echo e(translate('messages.tax')); ?>(%)</label>
                        <input type="number" id="tax" class="form-control" name="tax" min="0">
                    </div>

                    <div class="form-group col-sm-12">
                        <button class="btn btn-sm btn--primary"
                            type="submit"><?php echo e(translate('messages.submit')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light border-bottom py-3">
                <h5 class="modal-title flex-grow-1 text-center"><?php echo e(translate('Delivery Information')); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?php
                if (session()->has('address')) {
                    $old = session()->get('address');
                } else {
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
                            <input type="text" id="contact_person_name" class="form-control" name="contact_person_name"
                                value="<?php echo e($old ? $old['contact_person_name'] : ''); ?>"
                                placeholder="<?php echo e(translate('Ex: Jhone')); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="input-label" for="contact_person_number"><?php echo e(translate('Contact Number')); ?><span
                                    class="input-label-secondary text-danger">*</span></label>
                            <input type="tel" id="contact_person_number" class="form-control" name="contact_person_number"
                                value="<?php echo e($old ? $old['contact_person_number'] : ''); ?>"
                                placeholder="<?php echo e(translate('Ex: +3264124565')); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="input-label" for="road"><?php echo e(translate('messages.Road')); ?><span
                                    class="input-label-secondary text-danger">*</span></label>
                            <input type="text" id="road" class="form-control" name="road"
                                value="<?php echo e($old ? $old['road'] : ''); ?>" placeholder="<?php echo e(translate('Ex: 4th')); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="input-label" for="house"><?php echo e(translate('messages.House')); ?><span
                                    class="input-label-secondary text-danger">*</span></label>
                            <input type="text" id="house" class="form-control" name="house"
                                value="<?php echo e($old ? $old['house'] : ''); ?>" placeholder="<?php echo e(translate('Ex: 45/C')); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="input-label" for="floor"><?php echo e(translate('messages.Floor')); ?><span
                                    class="input-label-secondary text-danger">*</span></label>
                            <input type="text" id="floor" class="form-control" name="floor"
                                value="<?php echo e($old ? $old['floor'] : ''); ?>" placeholder="<?php echo e(translate('Ex: 1A')); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="input-label" for="longitude"><?php echo e(translate('messages.longitude')); ?><span
                                    class="input-label-secondary text-danger">*</span></label>
                            <input type="text" class="form-control" id="longitude" name="longitude"
                                value="<?php echo e($old ? $old['longitude'] : ''); ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="input-label" for="latitude"><?php echo e(translate('messages.latitude')); ?><span
                                    class="input-label-secondary text-danger">*</span></label>
                            <input type="text" class="form-control" id="latitude" name="latitude"
                                value="<?php echo e($old ? $old['latitude'] : ''); ?>" readonly>
                        </div>
                        <div class="col-md-12">
                            <label class="input-label" for="address"><?php echo e(translate('messages.address')); ?></label>
                            <textarea name="address" id="address" class="form-control" cols="30" rows="3"
                                placeholder="<?php echo e(translate('Ex: address')); ?>"><?php echo e($old ? $old['address'] : ''); ?></textarea>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <span class="text-primary">
                                    <?php echo e(translate('* pin the address in the map to calculate delivery fee')); ?>

                                </span>
                                <div>
                                    <span><?php echo e(translate('Delivery fee')); ?> :</span>
                                    <input type="hidden" name="distance" id="distance">
                                    <input type="hidden" name="delivery_fee" id="delivery_fee"
                                        value="<?php echo e($old ? $old['delivery_fee'] : ''); ?>">
                                    <strong><?php echo e($old ? $old['delivery_fee'] : 0); ?>

                                        <?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?></strong>
                                </div>
                            </div>
                            <input id="pac-input" class="controls rounded initial-8"
                                title="<?php echo e(translate('messages.search_your_location_here')); ?>" type="text"
                                placeholder="<?php echo e(translate('messages.search_here')); ?>" />
                            <div class="mb-2 h-200px" id="map"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="btn--container justify-content-end">
                            <button class="btn btn-sm btn--primary w-100 delivery-Address-Store" type="button"
                                >
                                <?php echo e(translate('Update_Delivery address')); ?>

                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/common.js"></script>
<?php /**PATH /var/www/zaqoota/resources/views/vendor-views/pos/_cart.blade.php ENDPATH**/ ?>