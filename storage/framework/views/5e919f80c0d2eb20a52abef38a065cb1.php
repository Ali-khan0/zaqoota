<div class="modal-header p-0">
    <h4 class="modal-title product-title">
    </h4>
    <button class="close call-when-done" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="d-flex flex-row align-items-center">
        <?php if(config('toggle_veg_non_veg') &&
            config('module.' . \App\CentralLogics\Helpers::get_store_data()->module->module_type)['veg_non_veg']): ?>
            <span
                class="badge badge-<?php echo e($product->veg ? 'success' : 'danger'); ?> position-absolute"><?php echo e($product->veg ? translate('messages.veg') : translate('messages.non_veg')); ?></span>
        <?php endif; ?>
        <!-- Product gallery-->
        <div class="d-flex align-items-center justify-content-center active">
            <img class="img-responsive img-responsive-1 onerror-image "
            src="<?php echo e($product['image_full_url']); ?>"
                 data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                data-zoom="<?php echo e(asset('storage/app/public/product')); ?>/<?php echo e($product['image']); ?>" alt="Product image"
                width="">
            <div class="cz-image-zoom-pane"></div>
        </div>
        <!-- Product details-->
        <div class="details pl-2">
            <a href="<?php echo e(route('vendor.item.view', $product->id)); ?>"
                class="h3 mb-2 product-title text-capitalize text-break"><?php echo e($product->name); ?></a>

                <?php if(isset($product->module_id) && $product->module->module_type == 'food'): ?>
                <div class="mb-3 text-dark">
                    <span class="h3 font-weight-normal text-accent mr-1">
                        <?php echo e(\App\CentralLogics\Helpers::get_food_price_range($product, true)); ?>

                    </span>
                    <?php if($product->discount > 0 || \App\CentralLogics\Helpers::get_store_discount($product->store)): ?>
                        <strike class="initial--18">
                            <?php echo e(\App\CentralLogics\Helpers::get_food_price_range($product)); ?>

                        </strike>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <div class="mb-3 text-dark">
                    <span class="h3 font-weight-normal text-accent mr-1">
                        <?php echo e(\App\CentralLogics\Helpers::get_price_range($product, true)); ?>

                    </span>
                    <?php if($product->discount > 0 || \App\CentralLogics\Helpers::get_store_discount($product->store)): ?>
                        <strike class="initial--18">
                            <?php echo e(\App\CentralLogics\Helpers::get_price_range($product)); ?>

                        </strike>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

            <?php if($product->discount > 0): ?>
                <div class="text-dark">
                    <strong><?php echo e(translate('messages.discount')); ?> : </strong>
                    <strong
                        id="set-discount-amount"><?php echo e(\App\CentralLogics\Helpers::get_product_discount($product)); ?></strong>
                </div>
            <?php endif; ?>
            <!-- Product panels-->
        </div>
    </div>
    <div class="row pt-2">
        <div class="col-12">
            <?php
            $cart = false;
            if (session()->has('cart')) {
                foreach (session()->get('cart') as $key => $cartItem) {
                    if (is_array($cartItem) && $cartItem['id'] == $product['id']) {
                        $cart = $cartItem;
                    }
                }
            }

            ?>
            <h2><?php echo e(translate('messages.description')); ?></h2>
            <span class="d-block text-dark text-break">
                <?php echo $product->description; ?>

            </span>

            <?php if(in_array($product->module->module_type ,['food','grocery'])): ?>
            <?php if(count($product->nutritions) ): ?>
                <h4 class="mt-2"> <?php echo e(translate('messages.Nutrition_Details')); ?></h4>
                <span class="d-block text-dark text-break">
                    <?php $__currentLoopData = $product->nutritions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nutrition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e($nutrition->nutrition); ?><?php echo e(!$loop->last ? ',' : '.'); ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </span>
            <?php endif; ?>
            <?php if(count($product->allergies)): ?>
                <h4 class="mt-2"> <?php echo e(translate('messages.Allergie_Ingredients')); ?></h4>
                <span class="d-block text-dark text-break">
                    <?php $__currentLoopData = $product->allergies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allergy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e($allergy->allergy); ?><?php echo e(!$loop->last ? ',' : '.'); ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </span>
            <?php endif; ?>
        <?php endif; ?>

        <?php if(in_array($product->module->module_type ,['pharmacy'])): ?>
            <?php if($product->generic->pluck('generic_name')->first()): ?>
                <h4 class="mt-2"> <?php echo e(translate('generic_name')); ?></h4>
                <span class="d-block text-dark text-break">
                    <?php echo e($product->generic->pluck('generic_name')->first()); ?>

                </span>
            <?php endif; ?>
        <?php endif; ?>

            <form id="add-to-cart-form" class="mb-2">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo e($product->id); ?>">
                <?php if($product->module->module_type == 'food'): ?>
                    <?php if($product->food_variations): ?>

                        <?php $__currentLoopData = json_decode($product->food_variations); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $choice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(isset($choice->price) == false): ?>
                                <div class="h3 p-0 pt-2"><?php echo e($choice->name); ?> <small  class="text-muted initial--18">
                                        (<?php echo e($choice->required == 'on' ? translate('messages.Required') : translate('messages.optional')); ?>)
                                    </small>
                                </div>
                                <?php if($choice->min != 0 && $choice->max != 0): ?>
                                    <small class="d-block mb-3">
                                        <?php echo e(translate('You_need_to_select_minimum_ ')); ?> <?php echo e($choice->min); ?>

                                        <?php echo e(translate('to_maximum_ ')); ?> <?php echo e($choice->max); ?>

                                        <?php echo e(translate('options')); ?>

                                    </small>
                                <?php endif; ?>

                                <div>
                                    <input type="hidden" name="variations[<?php echo e($key); ?>][min]"
                                        value="<?php echo e($choice->min); ?>">
                                    <input type="hidden" name="variations[<?php echo e($key); ?>][max]"
                                        value="<?php echo e($choice->max); ?>">
                                    <input type="hidden" name="variations[<?php echo e($key); ?>][required]"
                                        value="<?php echo e($choice->required); ?>">
                                    <input type="hidden" name="variations[<?php echo e($key); ?>][name]"
                                        value="<?php echo e($choice->name); ?>">
                                    <?php $__currentLoopData = $choice->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="form-check form--check d-flex pr-5 mr-6">
                                            <input class="form-check-input"
                                                type="<?php echo e($choice->type == 'multi' ? 'checkbox' : 'radio'); ?>"
                                                id="choice-option-<?php echo e($key); ?>-<?php echo e($k); ?>"
                                                name="variations[<?php echo e($key); ?>][values][label][]"
                                                value="<?php echo e($option->label); ?>" autocomplete="off">

                                            <label class="form-check-label"
                                                for="choice-option-<?php echo e($key); ?>-<?php echo e($k); ?>"><?php echo e(Str::limit($option->label, 20, '...')); ?></label>
                                            <span
                                                class="ml-auto"><?php echo e(\App\CentralLogics\Helpers::format_currency($option->optionPrice)); ?></span>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                <?php else: ?>
                    <?php $__currentLoopData = json_decode($product->choice_options); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $choice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="h3 p-0 pt-2"><?php echo e($choice->title); ?>

                        </div>

                        <div class="d-flex justify-content-left flex-wrap">
                            <?php $__currentLoopData = $choice->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <input class="btn-check" type="radio" id="<?php echo e($choice->name); ?>-<?php echo e($option); ?>"
                                    name="<?php echo e($choice->name); ?>" value="<?php echo e($option); ?>"
                                    <?php if($key == 0): ?> checked <?php endif; ?> autocomplete="off">
                                <label class="btn btn-sm check-label mx-1 choice-input text-break"
                                    for="<?php echo e($choice->name); ?>-<?php echo e($option); ?>"><?php echo e(Str::limit($option, 20, '...')); ?></label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>

                <!-- Quantity + Add to cart -->
                <div class="d-flex justify-content-between">
                    <div class="product-description-label mt-2 text-dark h3"><?php echo e(translate('messages.quantity')); ?>:
                    </div>
                    <div class="product-quantity d-flex align-items-center">
                        <div class="input-group input-group--style-2 pr-3 w-160px">
                            <span class="input-group-btn">
                                <button class="btn btn-number text-dark p-10px" type="button" data-type="minus"
                                    data-field="quantity" disabled="disabled">
                                    <i class="tio-remove  font-weight-bold"></i>
                                </button>
                            </span>
                            <input type="text" name="quantity"
                                class="form-control input-number text-center cart-qty-field" placeholder="1"
                                value="1" min="1" max="<?php echo e($product->maximum_cart_quantity?? '9999999999'); ?>">
                            <span class="input-group-btn">
                                <button class="btn btn-number text-dark p-10px" type="button" data-type="plus"
                                    data-field="quantity">
                                    <i class="tio-add  font-weight-bold"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <?php ($add_ons = json_decode($product->add_ons)); ?>
                <?php if(count($add_ons) > 0 && $add_ons[0]): ?>
                    <div class="h3 p-0 pt-2"><?php echo e(translate('messages.addon')); ?></div>

                    <div class="d-flex justify-content-left flex-wrap">
                        <?php $__currentLoopData = \App\Models\AddOn::whereIn('id', $add_ons)->active()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $add_on): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex-column pb-2">
                                <input type="hidden" name="addon-price<?php echo e($add_on->id); ?>"
                                    value="<?php echo e($add_on->price); ?>">
                                <input class="btn-check addon-chek addon-quantity-input-toggle" type="checkbox" id="addon<?php echo e($key); ?>"
                                     name="addon_id[]"
                                    value="<?php echo e($add_on->id); ?>" autocomplete="off">
                                <label
                                    class="d-flex align-items-center btn btn-sm check-label mx-1 addon-input text-break"
                                    for="addon<?php echo e($key); ?>"><?php echo e(Str::limit($add_on->name, 20, '...')); ?> <br>
                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($add_on->price)); ?></label>
                                <label class="input-group addon-quantity-input mx-1 shadow bg-white rounded px-1"
                                    for="addon<?php echo e($key); ?>">
                                    <button class="btn btn-sm h-100 text-dark px-0 decrease-button" type="button"
                                            data-id="<?php echo e($add_on->id); ?>"><i
                                            class="tio-remove  font-weight-bold"></i></button>
                                    <input type="number" name="addon-quantity<?php echo e($add_on->id); ?>"
                                        class="form-control text-center border-0 h-100" placeholder="1"
                                        value="1" min="1" max="9999999999" readonly>
                                    <button class="btn btn-sm h-100 text-dark px-0 increase-button" type="button"
                                            data-id="<?php echo e($add_on->id); ?>"><i
                                            class="tio-add  font-weight-bold"></i></button>
                                </label>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
                <div class="row no-gutters d-none mt-2 text-dark" id="chosen_price_div">
                    <div class="col-2">
                        <div class="product-description-label"><?php echo e(translate('messages.Total Price')); ?>:</div>
                    </div>
                    <div class="col-10">
                        <div class="product-price">
                            <strong id="chosen_price"></strong>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-2">
                    <button class="btn btn--primary h--45px w-40p add-To-Cart"  type="button">
                        <i class="tio-shopping-cart"></i>
                        <?php echo e(translate('messages.add_to_cart')); ?>

                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/common.js"></script>
<script type="text/javascript">
    "use strict";
    cartQuantityInitialize();
    getVariantPrice();
    $('#add-to-cart-form input').on('change', function() {
        getVariantPrice();
    });
</script>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/pos/_quick-view-data.blade.php ENDPATH**/ ?>