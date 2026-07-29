<div class="content container-fluid invoice-page">
    <div class="ff-emoji" id="printableArea">
        <div class="print--invoice">
            <?php if($order->store): ?>
                <div class="text-center pt-4 mb-3">
                    <img class="invoice-logo" src="<?php echo e(asset('/public/assets/admin/img/invoice-logo.png')); ?>"
                        alt="">
                    <div class="top-info">
                        <h2 class="store-name"><?php echo e($order->store->name); ?></h2>
                        <div>
                            <?php echo e($order->store->address); ?>

                        </div>
                        <div class="mt-1">
                            <?php echo e(translate('messages.phone')); ?> : <?php echo e($order->store->phone); ?>

                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="top-info">
                <img src="<?php echo e(asset('/public/assets/admin/img/invoice-star.png')); ?>" alt="" class="w-100">
                <div class="text-uppercase text-center"><?php echo e(translate('messages.cash_receipt')); ?></div>
                <img src="<?php echo e(asset('/public/assets/admin/img/invoice-star.png')); ?>" alt="" class="w-100">
            </div>
            <div class="order-info-id text-center">
                <h5><?php echo e(translate('order_id')); ?> : <?php echo e($order['id']); ?></h5>
                <div>
                    <?php echo e(date('d/M/Y ' . config('timeformat'), strtotime($order['created_at']))); ?>

                </div>
            </div>
            <div class="order-info-details">
                <div class="row mt-3">
                    <?php if($order->order_type == 'parcel'): ?>
                        <div class="col-12">
                            <?php ($address = json_decode($order->delivery_address, true)); ?>
                            <h5><?php echo e(translate('messages.sender_info')); ?></h5>
                            <div>
                                <?php echo e(translate('messages.sender_name')); ?> :
                                <?php echo e(isset($address) ? $address['contact_person_name'] : $order->address['f_name'] . ' ' . $order->customer['l_name']); ?>

                            </div>
                            <div>
                                <?php echo e(translate('messages.phone')); ?> :
                                <?php echo e(isset($address) ? $address['contact_person_number'] : $order->customer['phone']); ?>

                            </div>
                            <div class="text-break">
                                <?php echo e(translate('messages.address')); ?> :
                                <?php echo e(isset($address) ? $address['address'] : ''); ?>

                            </div>
                            <?php ($address = $order->receiver_details); ?>
                            <h5><u><?php echo e(translate('messages.receiver_info')); ?></u></h5>
                            <div>
                                <?php echo e(translate('messages.receiver_name')); ?> :
                                <?php echo e(isset($address) ? $address['contact_person_name'] : $order->address['f_name'] . ' ' . $order->customer['l_name']); ?>

                            </div>
                            <div>
                                <?php echo e(translate('messages.phone')); ?> :
                                <?php echo e(isset($address) ? $address['contact_person_number'] : $order->customer['phone']); ?>

                            </div>
                            <div class="text-break">
                                <?php echo e(translate('messages.address')); ?> :
                                <?php echo e(isset($address) ? $address['address'] : ''); ?>

                            </div>
                        </div>
                    <?php else: ?>
                        <div class="col-12">
                            <?php ($address = json_decode($order->delivery_address, true)); ?>
                            <?php if(!empty($address)): ?>
                                <h5>
                                    <?php echo e(translate('messages.contact_name')); ?> :
                                    <?php echo e(isset($address['contact_person_name']) ? $address['contact_person_name'] : ''); ?>

                                </h5>
                                <h5>
                                    <?php echo e(translate('messages.phone')); ?> :
                                    <?php echo e(isset($address['contact_person_number']) ? $address['contact_person_number'] : ''); ?>

                                </h5>
                            <?php endif; ?>
                            <h5 class="text-break">
                                <?php echo e(translate('messages.address')); ?> :
                                <?php echo e(isset($order->delivery_address) ? json_decode($order->delivery_address, true)['address'] : ''); ?>

                            </h5>
                        </div>
                    <?php endif; ?>
                </div>
                <table class="table invoice--table text-black mt-3">
                    <thead class="border-0">
                        <tr class="border-0">
                            <th><?php echo e(translate('messages.desc')); ?></th>
                            <th class="w-10p"></th>
                            <th><?php echo e(translate('messages.price')); ?></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if($order->order_type == 'parcel'): ?>
                            <tr>
                                <td><?php echo e(translate('messages.delivery_charge')); ?></td>
                                <td class="text-center">1</td>
                                <td><?php echo e(\App\CentralLogics\Helpers::format_currency($order->delivery_charge)); ?></td>
                            </tr>
                        <?php else: ?>
                            <?php ($sub_total = 0); ?>
                            <?php ($total_tax = 0); ?>
                            <?php ($total_dis_on_pro = 0); ?>
                            <?php ($add_ons_cost = 0); ?>
                            <?php $__currentLoopData = $order->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php ($item = json_decode($detail->item_details, true)); ?>
                                <tr>
                                    <td class="text-break">
                                        <?php echo e($item['name']); ?> <br>
                                        <?php if($order->store && $order->store->module->module_type == 'food'): ?>
                                            <?php if(count(json_decode($detail['variation'], true)) > 0): ?>
                                                <strong><u><?php echo e(translate('messages.variation')); ?> : </u></strong>
                                                <?php $__currentLoopData = json_decode($detail['variation'], true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if(isset($variation['name']) && isset($variation['values'])): ?>
                                                        <span class="d-block text-capitalize">
                                                            <strong><?php echo e($variation['name']); ?> - </strong>
                                                        </span>
                                                        <?php $__currentLoopData = $variation['values']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <span class="d-block text-capitalize">
                                                                &nbsp; &nbsp; <?php echo e($value['label']); ?> :
                                                                <strong><?php echo e(\App\CentralLogics\Helpers::format_currency($value['optionPrice'])); ?></strong>
                                                            </span>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                        <?php if(isset(json_decode($detail['variation'], true)[0])): ?>
                                                            <?php $__currentLoopData = json_decode($detail['variation'], true)[0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key1 => $variation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <div class="font-size-sm text-body">
                                                                    <span><?php echo e($key1); ?> : </span>
                                                                    <span
                                                                        class="font-weight-bold"><?php echo e($variation); ?></span>
                                                                </div>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                        <?php break; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php if(count(json_decode($detail['variation'], true)) > 0): ?>
                                                <strong><u><?php echo e(translate('messages.variation')); ?>

                                                        :
                                                    </u></strong>
                                                <?php
                                                $detailsVariation = isset(json_decode($detail['variation'], true)[0]) ? json_decode($detail['variation'], true)[0] : json_decode($detail['variation'], true);
                                                ?>
                                                <?php $__currentLoopData = $detailsVariation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key1 => $variation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($key1 != 'stock' || ($order->store && config('module.' . $order->store->module->module_type)['stock'])): ?>
                                                        <div class="font-size-sm text-body">
                                                            <span><?php echo e($key1); ?> :
                                                            </span>
                                                            <span class="font-weight-bold">
                                                                <?php echo e(Str::limit(implode(', ', (array) $variation), 15, '...')); ?>

                                                            </span>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <div class="addons">
                                            <?php $__currentLoopData = json_decode($detail['add_ons'], true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2 => $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($key2 == 0): ?>
                                                    <strong><u><?php echo e(translate('messages.addons')); ?> :
                                                        </u></strong>
                                                <?php endif; ?>
                                                <div>
                                                    <span class="text-break"><?php echo e($addon['name']); ?> : </span>
                                                    <span class="font-weight-bold">
                                                        <?php echo e($addon['quantity']); ?> x
                                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($addon['price'])); ?>

                                                    </span>
                                                </div>
                                                <?php ($add_ons_cost += $addon['price'] * $addon['quantity']); ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <?php if(count(json_decode($detail['variation'], true)) <= 0): ?>
                                            <div class="price">
                                                <?php echo e(\App\CentralLogics\Helpers::format_currency($detail->price)); ?>

                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo e($detail['quantity']); ?>

                                    </td>
                                    <td class="w-28p">
                                        <?php ($amount = $detail['price'] * $detail['quantity']); ?>
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($amount)); ?>

                                    </td>
                                </tr>
                                <?php ($sub_total += $amount); ?>
                                <?php ($total_tax += $detail['tax_amount'] * $detail['quantity']); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                    </tbody>
                </table>
                <div class="checkout--info">
                    <dl class="row text-right">
                        <?php if($order->order_type != 'parcel'): ?>
                            <dt class="col-6"><?php echo e(translate('messages.subtotal')); ?>

                                <?php if($order->tax_status == 'included'): ?>
                                    (<?php echo e(translate('messages.TAX_Included')); ?>)
                                <?php endif; ?>
                                :
                            </dt>
                            <dd class="col-6">
                                <?php echo e(\App\CentralLogics\Helpers::format_currency($sub_total + $add_ons_cost)); ?></dd>
                            <dt class="col-6"><?php echo e(translate('messages.discount')); ?>:</dt>
                            <dd class="col-6">
                                -
                                <?php echo e(\App\CentralLogics\Helpers::format_currency($order['store_discount_amount'] + $order['flash_admin_discount_amount'] + $order['flash_store_discount_amount'])); ?>

                            </dd>
                            <dt class="col-6"><?php echo e(translate('messages.coupon_discount')); ?>:</dt>
                            <dd class="col-6">
                                -
                                <?php echo e(\App\CentralLogics\Helpers::format_currency($order['coupon_discount_amount'])); ?>

                            </dd>
                            <?php if($order->tax_status == 'excluded' || $order->tax_status == null): ?>
                                <dt class="col-6"><?php echo e(translate('messages.vat/tax')); ?>:</dt>
                                <dd class="col-6">+
                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($order['total_tax_amount'])); ?></dd>
                            <?php endif; ?>
                            <dt class="col-6"><?php echo e(translate('messages.delivery_man_tips')); ?>:</dt>
                            <dd class="col-6">
                                <?php ($delivery_man_tips = $order['dm_tips']); ?>
                                + <?php echo e(\App\CentralLogics\Helpers::format_currency($delivery_man_tips)); ?>

                            </dd>
                            <dt class="col-6"><?php echo e(translate('messages.delivery_charge')); ?>:</dt>
                            <dd class="col-6">
                                <?php ($del_c = $order['delivery_charge']); ?>
                                <?php echo e(\App\CentralLogics\Helpers::format_currency($del_c)); ?>

                            </dd>
                        <?php else: ?>
                            <dt class="col-6"><?php echo e(translate('messages.delivery_man_tips')); ?>:</dt>
                            <dd class="col-6">
                                <?php ($delivery_man_tips = $order['dm_tips']); ?>
                                + <?php echo e(\App\CentralLogics\Helpers::format_currency($delivery_man_tips)); ?>

                            </dd>
                        <?php endif; ?>
                        <dt class="col-6 total"><?php echo e(translate('messages.total')); ?>:</dt>
                        <dd class="col-6 total">
                            <?php echo e(\App\CentralLogics\Helpers::format_currency($order->order_amount)); ?></dd>
                    </dl>
                    <?php if($order->payment_method != 'cash_on_delivery'): ?>
                        <div class="d-flex flex-row justify-content-between border-top">
                            <span><?php echo e(translate('messages.Paid by')); ?>:
                                <?php echo e(translate('messages.' . $order->payment_method)); ?></span>
                            <span><?php echo e(translate('messages.amount')); ?>:
                                <?php echo e($order->adjusment + $order->order_amount); ?></span>
                            <span><?php echo e(translate('messages.change')); ?>: <?php echo e(abs($order->adjusment)); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="top-info mt-2">
                <img src="<?php echo e(asset('/public/assets/admin/img/invoice-star.png')); ?>" alt="" class="w-100">
                <div class="text-uppercase text-center"><?php echo e(translate('THANK YOU')); ?></div>
                <img src="<?php echo e(asset('/public/assets/admin/img/invoice-star.png')); ?>" alt="" class="w-100">
                <div class="copyright">
                    &copy; <?php echo e(\App\Models\BusinessSetting::where(['key' => 'business_name'])->first()->value); ?>. <span
                        class="d-none d-sm-inline-block"><?php echo e(\App\Models\BusinessSetting::where(['key' => 'footer_text'])->first()->value); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/zaqoota/resources/views/admin-views/pos/invoice.blade.php ENDPATH**/ ?>