<?php $__env->startSection('title', translate('messages.Order Details')); ?>


<?php $__env->startSection('content'); ?>
    <?php

    $tax_included =0;
    if (count($order->details) > 0) {
        $campaign_order = isset($order?->details[0]?->item_campaign_id ) ? true : false;
    }
    $max_processing_time = explode('-', $order['store']['delivery_time'])[0];
    ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">
                        <span class="page-header-icon">
                            <img src="<?php echo e(asset('/public/assets/admin/img/shopping-basket.png')); ?>" class="w--20"
                                alt="">
                        </span>
                        <span>
                            <?php echo e(translate('order_details')); ?> <span
                                class="badge badge-soft-dark rounded-circle ml-1"><?php echo e($order->details->count()); ?></span>
                        </span>
                    </h1>
                </div>

                <div class="col-sm-auto">
                    <a class="btn btn-icon btn-sm btn-soft-secondary rounded-circle mr-1"
                        href="<?php echo e(route('vendor.order.details', [$order['id'] - 1])); ?>" data-toggle="tooltip"
                        data-placement="top" title="Previous order">
                        <i class="tio-chevron-left"></i>
                    </a>
                    <a class="btn btn-icon btn-sm btn-soft-secondary rounded-circle"
                        href="<?php echo e(route('vendor.order.details', [$order['id'] + 1])); ?>" data-toggle="tooltip"
                        data-placement="top" title="Next order">
                        <i class="tio-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <div class="row" id="printableArea">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <!-- Card -->
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header border-0 align-items-start flex-wrap">
                        <div class="order-invoice-left d-flex d-sm-flex justify-content-between">
                            <div>
                                <h1 class="page-header-title">
                                    <?php echo e(translate('messages.order')); ?> #<?php echo e($order['id']); ?>

                                    <?php if($order->edited): ?>
                                        <span class="badge badge-soft-danger ml-sm-3">
                                            <?php echo e(translate('messages.edited')); ?>

                                        </span>
                                    <?php endif; ?>
                                </h1>
                                <span class="mt-2 d-block">
                                    <i class="tio-date-range"></i>
                                    <?php echo e(date('d M Y ' . config('timeformat'), strtotime($order['created_at']))); ?>

                                </span>
                                <?php if($order->schedule_at && $order->scheduled): ?>
                                    <h6 class="text-capitalize">
                                        <?php echo e(translate('messages.scheduled_at')); ?>

                                        : <label
                                            class="fz--10 badge badge-soft-warning"><?php echo e(date('d M Y ' . config('timeformat'), strtotime($order['schedule_at']))); ?></label>
                                    </h6>
                                <?php endif; ?>
                                <?php if($order['cancellation_reason']): ?>
                                <h6>
                                    <span class="text-danger"><?php echo e(translate('messages.order_cancellation_reason')); ?> :</span>
                                    <?php echo e($order['cancellation_reason']); ?>

                                </h6>
                                <?php endif; ?>

                           
                                <!-- New Note -->
                                <?php if($order['bring_change_amount'] > 0): ?>
                                <div class="info-notes-bg px-3 color-222324CC py-2 rounded fs-12  gap-2 mt-2">
                                    <?php echo e(translate('Please_bring')); ?> <strong class="text-title"> <?php echo e(\App\CentralLogics\Helpers::format_currency($order['bring_change_amount'])); ?></strong> <?php echo e(translate('in_change_when_making_the_delivery')); ?>.
                                </div>
                                <?php endif; ?>
                                <!-- New Note End -->
                                <?php if($order['unavailable_item_note']): ?>
                                    <h6 class="w-100 badge-soft-warning p-1 rounded mt-2">
                                        <span class="text-dark">
                                            <?php echo e(translate('messages.order_unavailable_item_note')); ?> :
                                        </span>
                                        <?php echo e($order['unavailable_item_note']); ?>

                                    </h6>
                                <?php endif; ?>
                                <?php if($order['delivery_instruction']): ?>
                                    <h6 class="w-100 badge-soft-warning p-1 rounded mt-2">
                                        <span class="text-dark">
                                            <?php echo e(translate('messages.order_delivery_instruction')); ?> :
                                        </span>
                                        <?php echo e($order['delivery_instruction']); ?>

                                    </h6>
                                <?php endif; ?>
                                <?php if($order['order_note']): ?>
                                    <h6>
                                        <?php echo e(translate('messages.order_note')); ?> :
                                        <?php echo e($order['order_note']); ?>

                                    </h6>
                                <?php endif; ?>
                            </div>
                            <div class="d-sm-none">
                                <a class="btn btn--primary print--btn font-regular"
                                    href=<?php echo e(route('vendor.order.generate-invoice', [$order['id']])); ?>>
                                    <i class="tio-print mr-sm-1"></i> <span><?php echo e(translate('messages.print_invoice')); ?></span>
                                </a>
                            </div>
                        </div>


                        <div class="order-invoice-right mt-3 mt-sm-0">
                            <div class="btn--container ml-auto align-items-center justify-content-end">
                                <a class="btn btn--primary print--btn font-regular d-none d-sm-block"
                                    href=<?php echo e(route('vendor.order.generate-invoice', [$order['id']])); ?>>
                                    <i class="tio-print mr-sm-1"></i> <span><?php echo e(translate('messages.print_invoice')); ?></span>
                                </a>
                            </div>
                            <div class="text-right mt-3 order-invoice-right-contents text-capitalize">
                                <h6>
                                    <?php echo e(translate('messages.payment_status')); ?> :
                                    <?php if($order['payment_status'] == 'paid'): ?>
                                        <span class="badge badge-soft-success ml-sm-3">
                                            <?php echo e(translate('messages.paid')); ?>

                                        </span>
                                        <?php elseif($order['payment_status'] == 'partially_paid'): ?>

                                        <?php if($order->payments()->where('payment_status','unpaid')->exists()): ?>
                                        <span class="text-danger"><?php echo e(translate('messages.partially_paid')); ?></span>
                                        <?php else: ?>
                                        <span class="text-success"><?php echo e(translate('messages.paid')); ?></span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="badge badge-soft-danger ml-sm-3">
                                            <?php echo e(translate('messages.unpaid')); ?>

                                        </span>
                                    <?php endif; ?>
                                </h6>
                                <?php if($order->store && $order->store->module->module_type == 'food'): ?>
                                <h6>
                                    <span><?php echo e(translate('cutlery')); ?></span> <span>:</span>
                                    <?php if($order['cutlery'] == '1'): ?>
                                        <span class="badge badge-soft-success ml-sm-3">
                                            <?php echo e(translate('messages.yes')); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-soft-danger ml-sm-3">
                                            <?php echo e(translate('messages.no')); ?>

                                        </span>
                                    <?php endif; ?>

                                </h6>
                                <?php endif; ?>
                                <h6 class="text-capitalize">
                                    <?php echo e(translate('messages.payment_method')); ?> :
                                    <?php echo e(translate(str_replace('_', ' ', $order['payment_method']))); ?>

                                </h6>
                                <?php if($order['transaction_reference']): ?>
                                    <h6 class="">
                                        <?php echo e(translate('messages.reference_code')); ?> :
                                        <button class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                            data-target=".bd-example-modal-sm">
                                            <?php echo e(translate('messages.add')); ?>

                                        </button>
                                    </h6>
                                <?php endif; ?>
                                <h6 class="text-capitalize"><?php echo e(translate('messages.order_type')); ?>

                                    : <label
                                        class="fz--10 badge m-0 badge-soft-primary"><?php echo e(translate(str_replace('_', ' ', $order['order_type']))); ?></label>
                                </h6>
                                <h6>
                                    <?php echo e(translate('messages.order_status')); ?> :
                                    <?php if($order['order_status'] == 'pending'): ?>
                                        <span class="badge badge-soft-info ml-2 ml-sm-3 text-capitalize">
                                            <?php echo e(translate('messages.pending')); ?>

                                        </span>
                                    <?php elseif($order['order_status'] == 'confirmed'): ?>
                                        <span class="badge badge-soft-info ml-2 ml-sm-3 text-capitalize">
                                            <?php echo e(translate('messages.confirmed')); ?>

                                        </span>
                                    <?php elseif($order['order_status'] == 'processing'): ?>
                                        <span class="badge badge-soft-warning ml-2 ml-sm-3 text-capitalize">
                                            <?php echo e(translate('messages.processing')); ?>

                                        </span>
                                    <?php elseif($order['order_status'] == 'picked_up'): ?>
                                        <span class="badge badge-soft-warning ml-2 ml-sm-3 text-capitalize">
                                            <?php echo e(translate('messages.out_for_delivery')); ?>

                                        </span>
                                    <?php elseif($order['order_status'] == 'delivered'): ?>
                                        <span class="badge badge-soft-success ml-2 ml-sm-3 text-capitalize">
                                            <?php echo e(translate('messages.delivered')); ?>

                                        </span>
                                    <?php elseif($order['order_status'] == 'failed'): ?>
                                        <span class="badge badge-soft-danger ml-2 ml-sm-3 text-capitalize">
                                            <?php echo e(translate('messages.payment_failed')); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-soft-danger ml-2 ml-sm-3 text-capitalize">
                                            <?php echo e(str_replace('_', ' ', $order['order_status'])); ?>

                                        </span>
                                    <?php endif; ?>
                                </h6>
                                <?php if($order->order_attachment): ?>
                                        <?php
                                            $order_images = json_decode($order->order_attachment,true);
                                        ?>
                                    
                                        <h5 class="text-dark">
                                            <?php echo e(translate('messages.prescription')); ?>:
                                        </h5>
                                        <div class="d-flex flex-wrap flex-md-row-reverse __gap-15px" >
                                            <?php $__currentLoopData = $order_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php ($item = is_array($item)?$item:['img'=>$item,'storage'=>'public']); ?>
                                                <div>
                                                    <button class="btn w-100 px-0" data-toggle="modal"
                                                        data-target="#prescriptionimagemodal<?php echo e($key); ?>"
                                                        title="<?php echo e(translate('messages.order_attachment')); ?>">
                                                        <div class="gallary-card ml-auto">
                                                            <img  src="<?php echo e(\App\CentralLogics\Helpers::get_full_url('order',$item['img'],$item['storage'])); ?>"
                                                                alt="<?php echo e(translate('messages.prescription')); ?>"
                                                                class="initial--22 object-cover">
                                                        </div>
                                                    </button>
                                                </div>
                                                <div class="modal fade" id="prescriptionimagemodal<?php echo e($key); ?>" tabindex="-1"
                                                    role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel">
                                                                    <?php echo e(translate('messages.prescription')); ?></h4>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"><span
                                                                        aria-hidden="true">&times;</span><span
                                                                        class="sr-only"><?php echo e(translate('messages.cancel')); ?></span></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <img src="<?php echo e(\App\CentralLogics\Helpers::get_full_url('order',$item['img'],$item['storage'])); ?>"
                                                                    class="initial--22 w-100" alt="image">
                                                            </div>
                                                            <?php ($storage = $item['storage']??'public'); ?>
                                                            <?php ($file = $storage == 's3'?base64_encode('order/' . $item['img']):base64_encode('public/order/' . $item['img'])); ?>
                                                            <div class="modal-footer">
                                                                <a class="btn btn-primary"
                                                                    href="<?php echo e(route('admin.file-manager.download', [$file,$storage])); ?>"><i
                                                                        class="tio-download"></i>
                                                                    <?php echo e(translate('messages.download')); ?>

                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body px-0">
                        <?php
                        $total_addon_price = 0;
                        $product_price = 0;
                        $store_discount_amount = 0;
                        $admin_flash_discount_amount = $order['flash_admin_discount_amount'];
                        $ref_bonus_amount = $order['ref_bonus_amount'];
                        $extra_packaging_amount = $order['extra_packaging_amount'];
                        $store_flash_discount_amount = $order['flash_store_discount_amount'];

                        if ($order->prescription_order == 1) {
                            $product_price = $order['order_amount'] - $order['delivery_charge'] - $order['total_tax_amount'] - $order['dm_tips'] - $order['additional_charge'] + $order['store_discount_amount'];
                            if($order->tax_status == 'included'){
                                $product_price += $order['total_tax_amount'];
                            }
                        }

                        $total_addon_price = 0;
                        ?>
                        <div class="table-responsive">
                            <table
                                class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table dataTable no-footer mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-0"><?php echo e(translate('messages.#')); ?></th>
                                        <th class="border-0"><?php echo e(translate('messages.item_details')); ?></th>
                                        <?php if($order->store->module->module_type == 'food'): ?>
                                            <th class="border-0"><?php echo e(translate('messages.addons')); ?></th>
                                        <?php endif; ?>
                                        <th class="text-right  border-0"><?php echo e(translate('messages.price')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $order->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(isset($detail->item_id)): ?>
                                            <?php ($detail->item = json_decode($detail->item_details, true)); ?>
                                            <?php ($product = \App\Models\Item::where(['id' => $detail->item['id']])->first()); ?>
                                            <!-- Media -->
                                            <tr>
                                                <td>
                                                    <div>
                                                        <?php echo e($key + 1); ?>

                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="media media--sm">
                                                        <a class="avatar avatar-xl mr-3"
                                                            href="<?php echo e(route('vendor.item.view', $detail->item['id'])); ?>">
                                                            <img class="img-fluid rounded onerror-image"
                                                            src="<?php echo e($product->image_full_url  ?? asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                                                                 data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                                                                alt="Image Description">
                                                        </a>
                                                        <div class="media-body">
                                                            <div>
                                                                <strong
                                                                    class="line--limit-1"><?php echo e(Str::limit($detail->item['name'], 25, '...')); ?></strong>
                                                                <h6>
                                                                    <?php echo e($detail['quantity']); ?> x
                                                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($detail['price'])); ?>

                                                                </h6>
                                                                <?php if($order->store && $order->store->module->module_type == 'food'): ?>
                                                                    <?php if(isset($detail['variation']) ? json_decode($detail['variation'], true) : []): ?>
                                                                        <?php $__currentLoopData = json_decode($detail['variation'], true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <?php if(isset($variation['name']) && isset($variation['values'])): ?>
                                                                                <span class="d-block text-capitalize">
                                                                                    <strong>
                                                                                        <?php echo e($variation['name']); ?> -
                                                                                    </strong>
                                                                                </span>
                                                                                <?php $__currentLoopData = $variation['values']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                    <span class="d-block text-capitalize">
                                                                                        &nbsp; &nbsp;
                                                                                        <?php echo e($value['label']); ?> :
                                                                                        <strong><?php echo e(\App\CentralLogics\Helpers::format_currency($value['optionPrice'])); ?></strong>
                                                                                    </span>
                                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                            <?php else: ?>
                                                                                <?php if(isset(json_decode($detail['variation'], true)[0])): ?>
                                                                                    <strong><u>
                                                                                            <?php echo e(translate('messages.Variation')); ?>

                                                                                            : </u></strong>
                                                                                    <?php $__currentLoopData = json_decode($detail['variation'], true)[0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key1 => $variation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                        <div
                                                                                            class="font-size-sm text-body">
                                                                                            <span><?php echo e($key1); ?>

                                                                                                : </span>
                                                                                            <span
                                                                                                class="font-weight-bold"><?php echo e($variation); ?></span>
                                                                                        </div>
                                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                                <?php endif; ?>
                                                                                
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
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <?php if($order->store->module->module_type == 'food'): ?>
                                                    <td>
                                                        <div>
                                                            <?php $__currentLoopData = json_decode($detail['add_ons'], true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2 => $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if($key2 == 0): ?>
                                                                    <strong><u><?php echo e(translate('messages.addons')); ?> :
                                                                        </u></strong>
                                                                <?php endif; ?>
                                                                <div class="font-size-sm text-body">
                                                                    <span><?php echo e(Str::limit($addon['name'], 25, '...')); ?> :
                                                                    </span>
                                                                    <span class="font-weight-bold">
                                                                        <?php echo e($addon['quantity']); ?> x
                                                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($addon['price'])); ?>

                                                                    </span>
                                                                </div>
                                                                <?php ($total_addon_price += $addon['price'] * $addon['quantity']); ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </div>
                                                    </td>
                                                <?php endif; ?>
                                                <td>
                                                    <div class="text-right">
                                                        <?php ($amount = $detail['price'] * $detail['quantity']); ?>
                                                        <h5><?php echo e(\App\CentralLogics\Helpers::format_currency($amount)); ?></h5>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php ($product_price += $amount); ?>
                                            <?php ($store_discount_amount += $detail['discount_on_item'] * $detail['quantity']); ?>
                                            <!-- End Media -->
                                        <?php elseif(isset($detail->item_campaign_id)): ?>
                                            <?php ($detail->campaign = json_decode($detail->item_details, true)); ?>
                                            <?php ($campaign = \App\Models\ItemCampaign::where(['id' => $detail->campaign['id']])->first()); ?>
                                            <!-- Media -->
                                            <tr>
                                                <td>
                                                    <div>
                                                        <?php echo e($key + 1); ?>

                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="media media--sm">
                                                        <div class="avatar avatar-xl mr-3">
                                                            <img class="img-fluid onerror-image"
                                                            src="<?php echo e($campaign?->image_full_url ?? asset('public/assets/admin/img/160x160/img2.jpg')); ?>"

                                                                 data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                                                                alt="Image Description">
                                                        </div>
                                                        <div class="media-body">
                                                            <div>
                                                                <strong
                                                                    class="line--limit-1"><?php echo e(Str::limit($detail->campaign['name'], 25, '...')); ?></strong>

                                                                <h6>
                                                                    <?php echo e($detail['quantity']); ?> x
                                                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($detail['price'])); ?>

                                                                </h6>

                                                                <?php if(count(json_decode($detail['variation'], true)) > 0): ?>
                                                                    <strong><u><?php echo e(translate('messages.variation')); ?> :
                                                                        </u></strong>
                                                                    <?php $__currentLoopData = json_decode($detail['variation'], true)[0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key1 => $variation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php if($key1 != 'stock'): ?>
                                                                            <div class="font-size-sm text-body">
                                                                                <span><?php echo e($key1); ?> : </span>
                                                                                <span
                                                                                    class="font-weight-bold"><?php echo e(Str::limit($variation, 25, '...')); ?></span>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php endif; ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <?php if($order->store->module->module_type == 'food'): ?>
                                                    <td>
                                                        <?php $__currentLoopData = json_decode($detail['add_ons'], true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2 => $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($key2 == 0): ?>
                                                                <strong><u><?php echo e(translate('messages.addons')); ?> :
                                                                    </u></strong>
                                                            <?php endif; ?>
                                                            <div class="font-size-sm text-body">
                                                                <span><?php echo e(Str::limit($addon['name'], 20, '...')); ?> : </span>
                                                                <span class="font-weight-bold">
                                                                    <?php echo e($addon['quantity']); ?> x
                                                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($addon['price'])); ?>

                                                                </span>
                                                            </div>
                                                            <?php ($total_addon_price += $addon['price'] * $addon['quantity']); ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </td>
                                                <?php endif; ?>
                                                <td>
                                                    <div class="text-right">
                                                        <?php ($amount = $detail['price'] * $detail['quantity']); ?>
                                                        <h5><?php echo e(\App\CentralLogics\Helpers::format_currency($amount)); ?></h5>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php ($product_price += $amount); ?>
                                            <?php ($store_discount_amount += $detail['discount_on_item'] * $detail['quantity']); ?>
                                            <!-- End Media -->
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="mx-3">
                            <hr>
                        </div>
                        <?php

                        $coupon_discount_amount = $order['coupon_discount_amount'];

                        $total_price = $product_price + $total_addon_price - $store_discount_amount - $coupon_discount_amount - $admin_flash_discount_amount -$ref_bonus_amount -$extra_packaging_amount -$store_flash_discount_amount;

                        $total_tax_amount = $order['total_tax_amount'];
                        if($order->tax_status == 'included'){
                                $total_tax_amount=0;
                            }
                        $tax_included = \App\Models\BusinessSetting::where(['key'=>'tax_included'])->first() ?  \App\Models\BusinessSetting::where(['key'=>'tax_included'])->first()->value : 0;

                        $store_discount_amount = $order['store_discount_amount'];

                        ?>
                        <div class="row justify-content-md-end mb-3 mx-0 mt-4">
                            <div class="col-md-9 col-lg-8">
                                <dl class="row text-right">
                                    <dt class="col-6"><?php echo e(translate('messages.items_price')); ?>:</dt>
                                    <dd class="col-6"><?php echo e(\App\CentralLogics\Helpers::format_currency($product_price)); ?>

                                    </dd>
                                    <?php if($order->store->module->module_type == 'food'): ?>
                                        <dt class="col-6"><?php echo e(translate('messages.addon_cost')); ?>:</dt>

                                        <dd class="col-6">
                                            <?php echo e(\App\CentralLogics\Helpers::format_currency($total_addon_price)); ?>

                                            <hr>
                                        </dd>
                                    <?php endif; ?>

                                    <dt class="col-6"><?php echo e(translate('messages.subtotal')); ?>

                                        <?php if($order->tax_status == 'included' ||  $tax_included ==  1): ?>
                                        (<?php echo e(translate('messages.TAX_Included')); ?>)
                                        <?php endif; ?>
                                        :</dt>

                                    <dd class="col-6">
                                        <?php if($order->prescription_order == 1 && in_array($order['order_status'],['pending','confirmed','processing','accepted'])): ?>
                                            <button class="btn btn-sm" type="button" data-toggle="modal"
                                                data-target="#edit-order-amount"><i class="tio-edit"></i></button>
                                        <?php endif; ?>
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($product_price + $total_addon_price)); ?>

                                    </dd>
                                    <dt class="col-6"><?php echo e(translate('messages.discount')); ?>:</dt>
                                    <dd class="col-6">
                                        <?php if($order->prescription_order == 1 && in_array($order['order_status'],['pending','confirmed','processing','accepted'])): ?>
                                            <button class="btn btn-sm" type="button" data-toggle="modal"
                                                data-target="#edit-discount-amount"><i class="tio-edit"></i></button>
                                        <?php endif; ?>
                                        - <?php echo e(\App\CentralLogics\Helpers::format_currency($store_discount_amount + $admin_flash_discount_amount  +$store_flash_discount_amount)); ?>

                                    </dd>



                                    <dt class="col-6"><?php echo e(translate('messages.coupon_discount')); ?>:</dt>
                                    <dd class="col-6">
                                        - <?php echo e(\App\CentralLogics\Helpers::format_currency($coupon_discount_amount)); ?></dd>

                                    <?php if($ref_bonus_amount > 0): ?>
                                    <dt class="col-6"><?php echo e(translate('messages.Referral_Discount')); ?>:</dt>
                                    <dd class="col-6">
                                        - <?php echo e(\App\CentralLogics\Helpers::format_currency($ref_bonus_amount)); ?></dd>

                                    <?php endif; ?>

                                    <?php if($order->tax_status == 'excluded' || $order->tax_status == null  ): ?>
                                    <dt class="col-sm-6"><?php echo e(translate('messages.vat/tax')); ?>:</dt>
                                    <dd class="col-sm-6">
                                        +
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($total_tax_amount)); ?>

                                    </dd>
                                    <?php endif; ?>
                                    <dt class="col-6"><?php echo e(translate('messages.delivery_man_tips')); ?></dt>
                                    <dd class="col-6">
                                        + <?php echo e(\App\CentralLogics\Helpers::format_currency($order->dm_tips)); ?></dd>
                                    <dt class="col-6"><?php echo e(translate('messages.delivery_fee')); ?>:</dt>
                                    <dd class="col-6">
                                        <?php ($del_c = $order['delivery_charge']); ?>
                                        + <?php echo e(\App\CentralLogics\Helpers::format_currency($del_c)); ?>

                                        <hr>
                                    </dd>
                                    <dt class="col-6"><?php echo e(\App\CentralLogics\Helpers::get_business_data('additional_charge_name')??translate('messages.additional_charge')); ?>:</dt>
                                    <dd class="col-6">
                                        <?php ($additional_charge = $order['additional_charge']); ?>
                                        + <?php echo e(\App\CentralLogics\Helpers::format_currency($additional_charge)); ?>

                                    </dd>
                                    <?php if($extra_packaging_amount > 0): ?>
                                    <dt class="col-6"><?php echo e(translate('messages.Extra_Packaging_Amount')); ?>:</dt>
                                    <dd class="col-6">
                                        + <?php echo e(\App\CentralLogics\Helpers::format_currency($extra_packaging_amount)); ?></dd>
                                    <?php endif; ?>
                                    <?php if($order['partially_paid_amount'] > 0): ?>

                                    <dt class="col-6"><?php echo e(translate('messages.partially_paid_amount')); ?>:</dt>
                                    <dd class="col-6">
                                        <?php ($partially_paid_amount = $order['partially_paid_amount']); ?>
                                            <?php echo e(\App\CentralLogics\Helpers::format_currency($partially_paid_amount)); ?>

                                    </dd>
                                    <dt class="col-6"><?php echo e(translate('messages.due_amount')); ?>:</dt>
                                    <?php if($order['payment_method'] == 'partial_payment'): ?>

                                    <dd class="col-6">
                                            <?php echo e(\App\CentralLogics\Helpers::format_currency($order->order_amount-$partially_paid_amount)); ?>

                                    </dd>
                                    <?php else: ?>
                                    <dd class="col-6">
                                            <?php echo e(\App\CentralLogics\Helpers::format_currency(0)); ?>

                                    </dd>
                                    <?php endif; ?>
                                    <?php endif; ?>

                                    <dt class="col-6"><?php echo e(translate('messages.total')); ?>:</dt>
                                    <dd class="col-6">
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($product_price + $del_c + $total_tax_amount + $total_addon_price + $additional_charge - $coupon_discount_amount - $store_discount_amount - $admin_flash_discount_amount  - $ref_bonus_amount + $extra_packaging_amount-$store_flash_discount_amount + $order->dm_tips)); ?>

                                    </dd>
                                    <?php if($order?->payments): ?>
                                        <?php $__currentLoopData = $order?->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($payment->payment_status == 'paid'): ?>
                                                <?php if( $payment->payment_method == 'cash_on_delivery'): ?>

                                                <dt class="col-sm-6"><?php echo e(translate('messages.Paid_with_Cash')); ?> (<?php echo e(translate('COD')); ?>) :</dt>
                                                <?php else: ?>

                                                <dt class="col-sm-6"><?php echo e(translate('messages.Paid_by')); ?> <?php echo e(translate($payment->payment_method)); ?> :</dt>
                                                <?php endif; ?>
                                            <?php else: ?>

                                            <dt class="col-sm-6"><?php echo e(translate('Due_Amount')); ?> (<?php echo e($payment->payment_method == 'cash_on_delivery' ?  translate('messages.COD') : translate($payment->payment_method)); ?>) :</dt>
                                            <?php endif; ?>
                                        <dd class="col-sm-6">
                                            <?php echo e(\App\CentralLogics\Helpers::format_currency($payment->amount)); ?>

                                        </dd>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </dl>
                                <!-- End Row -->
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>

            <div class="col-lg-4">
                <!-- Card -->
                <?php if($order->order_status != 'refund_requested' &&
                    $order->order_status != 'refunded' &&
                    $order->order_status != 'delivered'): ?>
                    <div class="card mb-2">
                        <!-- Header -->
                        <div class="card-header justify-content-center text-center px-0 mx-4">
                            <h5 class="card-header-title text-capitalize">
                                <span><?php echo e(translate('messages.order_setup')); ?></span>
                            </h5>
                        </div>
                        <!-- End Header -->

                        <!-- Body -->

                        <div class="card-body">
                            <!-- Order Status Flow Starts -->
                            <?php ($order_delivery_verification = (bool) \App\Models\BusinessSetting::where(['key' => 'order_delivery_verification'])->first()->value); ?>
                            <div class="mb-4">
                                <div class="row g-1">
                                    <div class="<?php echo e(config('canceled_by_store') ? 'col-6' : 'col-12'); ?>">
                                        <a class="btn btn--primary w-100 fz--13 px-2 <?php echo e($order['order_status'] == 'pending' ? '' : 'd-none'); ?> route-alert"
                                           data-url="<?php echo e(route('vendor.order.status', ['id' => $order['id'], 'order_status' => 'confirmed'])); ?>"
                                           data-message="<?php echo e(translate('messages.confirm_this_order_?')); ?>"
                                            href="javascript:"><?php echo e(translate('messages.confirm_this_order')); ?></a>
                                    </div>
                                    <?php if(config('canceled_by_store')): ?>
                                        <div class="col-6">
                                            <a class="btn btn--danger w-100 fz--13 px-2 cancelled-status <?php echo e($order['order_status'] == 'pending' ? '' : 'd-none'); ?>"
                                               ><?php echo e(translate('Cancel Order')); ?></a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                    <?php if($order->store && $order->store->module->module_type == 'food'): ?>
                                        <a class="btn btn--primary w-100 order-status-change-alert <?php echo e($order['order_status'] == 'confirmed' || $order['order_status'] == 'accepted' ? '' : 'd-none'); ?>"

                                           data-url="<?php echo e(route('vendor.order.status', ['id' => $order['id'], 'order_status' => 'processing'])); ?>"
                                           data-message="<?php echo e(translate('Change status to cooking ?')); ?>"
                                           data-verification="false"
                                           data-processing-time="<?php echo e($max_processing_time); ?>"
                                           href="javascript:"><?php echo e(translate('messages.proceed_for_processing')); ?></a>
                                    <?php else: ?>
                                    <a class="btn btn--primary w-100 route-alert  <?php echo e($order['order_status'] == 'confirmed' || $order['order_status'] == 'accepted' ? '' : 'd-none'); ?>"
                                       data-url="<?php echo e(route('vendor.order.status', ['id' => $order['id'], 'order_status' => 'processing'])); ?>"
                                       data-message="<?php echo e(translate('messages.proceed_for_processing')); ?>"
                                    href="javascript:"><?php echo e(translate('messages.proceed_for_processing')); ?></a>
                                    <?php endif; ?>
                                <a class="btn btn--primary w-100 route-alert <?php echo e($order['order_status'] == 'processing' ? '' : 'd-none'); ?>"
                                   data-url="<?php echo e(route('vendor.order.status', ['id' => $order['id'], 'order_status' => 'handover'])); ?>"
                                   data-message="<?php echo e(translate('messages.make_ready_for_handover')); ?>"
                                    href="javascript:"><?php echo e(translate('messages.make_ready_for_handover')); ?></a>
                                 <?php if($order['order_status'] == 'handover'|| ($order['order_status'] == 'picked_up' && $order->store->sub_self_delivery == 1)): ?>
                                    <a class="btn  w-100
                                    <?php echo e(($order['order_type'] == 'take_away' || $order->store->sub_self_delivery == 1)  ?  'btn--primary order-status-change-alert'  :  'btn--secondary  self-delivery-warning'); ?> "
                                       data-url="<?php echo e(route('vendor.order.status', ['id' => $order['id'], 'order_status' => 'delivered'])); ?>"
                                       data-message="<?php echo e(translate('messages.Change status to delivered (payment status will be paid if not)?')); ?>"
                                       data-verification="<?php echo e($order_delivery_verification ? 'true' : 'false'); ?>"
                                        href="javascript:"><?php echo e(translate('messages.make_delivered')); ?></a>
                                 <?php endif; ?>

                            </div>
                        </div>

                        <!-- End Body -->
                    </div>
                <?php endif; ?>
                <!-- End Card -->
                <?php if($order->order_status == 'canceled'): ?>
                <ul class="delivery--information-single mt-3">
                    <li>
                        <span class=" badge badge-soft-danger "> <?php echo e(translate('messages.Cancel_Reason')); ?> :</span>
                        <span class="info">  <?php echo e($order->cancellation_reason); ?> </span>
                    </li>

                    <li>
                        <span class="name"><?php echo e(translate('Cancel_Note')); ?> </span>
                        <span class="info">  <?php echo e($order->cancellation_note ?? translate('messages.N/A')); ?> </span>
                    </li>
                    <li>
                        <span class="name"><?php echo e(translate('Canceled_By')); ?> </span>
                        <span class="info">  <?php echo e(translate($order->canceled_by)); ?> </span>
                    </li>
                    <?php if($order->payment_status == 'paid' || $order->payment_status == 'partially_paid' ): ?>
                            <?php if( $order?->payments): ?>
                                <?php ( $pay_infos =$order->payments()->where('payment_status','paid')->get()); ?>
                                <?php $__currentLoopData = $pay_infos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pay_info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <span class="name"><?php echo e(translate('Amount_paid_by')); ?> <?php echo e(translate($pay_info->payment_method)); ?> </span>
                                        <span class="info">  <?php echo e(\App\CentralLogics\Helpers::format_currency($pay_info->amount)); ?> </span>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                            <li>
                                <span class="name"><?php echo e(translate('Amount_paid_by')); ?> <?php echo e(translate($order->payment_method)); ?> </span>
                                <span class="info ">  <?php echo e(\App\CentralLogics\Helpers::format_currency($order->order_amount)); ?> </span>
                            </li>
                            <?php endif; ?>
                    <?php endif; ?>

                    <?php if($order->payment_status == 'paid' || $order->payment_status == 'partially_paid'): ?>
                        <?php if( $order?->payments): ?>
                            <?php ( $amount =$order->payments()->where('payment_status','paid')->sum('amount')); ?>
                                <li>
                                    <span class="name"><?php echo e(translate('Amount_Returned_To_Wallet')); ?> </span>
                                    <span class="info">  <?php echo e(\App\CentralLogics\Helpers::format_currency($amount)); ?> </span>
                                </li>
                        <?php else: ?>
                        <li>
                            <span class="name"><?php echo e(translate('Amount_Returned_To_Wallet')); ?> </span>
                            <span class="info">  <?php echo e(\App\CentralLogics\Helpers::format_currency($order->order_amount)); ?> </span>
                        </li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
                <hr class="w-100">
            <?php endif; ?>
                <?php if($order['order_type'] != 'take_away'): ?>
                    <!-- Card -->
                    <div class="card mb-2">
                        <!-- Header -->
                        <div class="card-header">
                            <h4 class="card-header-title">
                                <span class="card-header-icon"><i class="tio-user"></i></span>
                                <span><?php echo e(translate('messages.Delivery Man')); ?></span>
                            </h4>
                        </div>
                        <!-- End Header -->

                        <!-- Body -->
                        <div class="card-body">
                            <?php if($order->delivery_man): ?>
                                <div class="media align-items-center customer--information-single" href="javascript:">
                                    <div class="avatar avatar-circle">
                                        <img class="avatar-img onerror-image"
                                             data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
                                             src="<?php echo e($order->delivery_man->image_full_url); ?>"
                                            alt="Image Description">
                                    </div>
                                    <div class="media-body">
                                        <span
                                            class="text-body d-block text-hover-primary mb-1"><?php echo e($order->delivery_man['f_name'] . ' ' . $order->delivery_man['l_name']); ?></span>

                                        <span class="text--title font-semibold d-flex align-items-center">
                                            <i class="tio-shopping-basket-outlined mr-2"></i>
                                            <?php echo e($order->delivery_man->orders_count); ?>

                                            <?php echo e(translate('messages.orders_delivered')); ?>

                                        </span>

                                        <span class="text--title font-semibold d-flex align-items-center">
                                            <i class="tio-call-talking-quiet mr-2"></i>
                                            <?php echo e($order->delivery_man['phone']); ?>

                                        </span>

                                        <span class="text--title font-semibold d-flex align-items-center">
                                            <i class="tio-email-outlined mr-2"></i>
                                            <?php echo e($order->delivery_man['email']); ?>

                                        </span>
                                    </div>
                                </div>

                                <?php if($order['order_type'] != 'take_away'): ?>
                                    <hr>
                                    <?php ($address = $order->dm_last_location); ?>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5><?php echo e(translate('messages.last_location')); ?></h5>
                                    </div>
                                    <?php if(isset($address)): ?>
                                        <span class="d-block">
                                            <a target="_blank"
                                                href="http://maps.google.com/maps?z=12&t=m&q=loc:<?php echo e($address['latitude']); ?>+<?php echo e($address['longitude']); ?>">
                                                <i class="tio-map"></i> <?php echo e($address['location']); ?><br>
                                            </a>
                                        </span>
                                    <?php else: ?>
                                        <span class="d-block text-lowercase qcont">
                                            <?php echo e(translate('messages.location_not_found')); ?>

                                        </span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="badge badge-soft-danger py-2 d-block qcont">
                                    <?php echo e(translate('messages.deliveryman_not_found')); ?>

                                </span>
                            <?php endif; ?>
                        </div>
                        <!-- End Body -->
                    </div>
                <?php endif; ?>
                <!-- End Card -->

                <!-- order proof -->
                <div class="card mb-2 mt-2">
                    <div class="card-header border-0 text-center pb-0">
                        <h4 class="m-0"><?php echo e(translate('messages.delivery_proof')); ?> </h4>
                        <?php if($order['store']['sub_self_delivery']): ?>

                        <button class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                            data-target=".order-proof-modal">
                                            <?php echo e(translate('messages.add')); ?>

                                        </button>
                        <?php endif; ?>
                    </div>
                    <?php ($data = isset($order->order_proof) ? json_decode($order->order_proof, true) : 0); ?>
                    <div class="card-body pt-2">
                        <?php if($data): ?>
                        <label class="input-label"
                            for="order_proof"><?php echo e(translate('messages.image')); ?> : </label>
                        <div class="row g-3">
                                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php ($img = is_array($img)?$img:['img'=>$img,'storage'=>'public']); ?>
                                    <div class="col-3">
                                        <img class="img__aspect-1 rounded border w-100 onerror-image" data-toggle="modal"
                                            data-target="#imagemodal<?php echo e($key); ?>"
                                             data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                                             src="<?php echo e(\App\CentralLogics\Helpers::get_full_url('order',$img['img'],$img['storage'])); ?>"
                                             alt="image">
                                    </div>
                                    <div class="modal fade" id="imagemodal<?php echo e($key); ?>" tabindex="-1"
                                        role="dialog" aria-labelledby="order_proof_<?php echo e($key); ?>"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title"
                                                        id="order_proof_<?php echo e($key); ?>">
                                                        <?php echo e(translate('order_proof_image')); ?></h4>
                                                    <button type="button" class="close"
                                                        data-dismiss="modal"><span
                                                            aria-hidden="true">&times;</span><span
                                                            class="sr-only"><?php echo e(translate('messages.cancel')); ?></span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <img src="<?php echo e(\App\CentralLogics\Helpers::get_full_url('order',$img['img'],$img['storage'])); ?>"
                                                        class="initial--22 w-100" alt="img">
                                                </div>
                                                <?php ($storage = $img['storage']??'public'); ?>
                                                <?php ($file = $storage == 's3'?base64_encode('order/' . $img['img']):base64_encode('public/order/' . $img['img'])); ?>
                                                <div class="modal-footer">
                                                    <a class="btn btn-primary"
                                                        href="<?php echo e(route('admin.file-manager.download', [$file,$storage])); ?>"><i
                                                            class="tio-download"></i>
                                                        <?php echo e(translate('messages.download')); ?>

                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php endif; ?>
                    </div>
                </div>

                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title">
                            <span class="card-header-icon"><i class="tio-user"></i></span>
                            <span><?php echo e(translate('messages.customer')); ?></span>
                        </h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <?php if($order->customer): ?>
                        <div class="card-body">

                            <div class="media align-items-center customer--information-single" href="javascript:">
                                <div class="avatar avatar-circle">
                                    <img class="avatar-img onerror-image "
                                         data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
                                         src="<?php echo e($order->customer->image_full_url); ?>"
                                        alt="Image Description">
                                </div>
                                <div class="media-body">
                                    <span
                                        class="text-body d-block text-hover-primary mb-1"><?php echo e($order->customer['f_name'] . ' ' . $order->customer['l_name']); ?></span>

                                    <span class="text--title font-semibold d-flex align-items-center">
                                        <i class="tio-shopping-basket-outlined mr-2"></i>
                                        <?php echo e($order->customer->orders_count); ?>

                                        <?php echo e(translate('messages.orders_delivered')); ?>

                                    </span>

                                    <span class="text--title font-semibold d-flex align-items-center">
                                        <i class="tio-call-talking-quiet mr-2"></i>
                                        <?php echo e($order->customer['phone']); ?>

                                    </span>

                                    <span class="text--title font-semibold d-flex align-items-center">
                                        <i class="tio-email-outlined mr-2"></i>
                                        <?php echo e($order->customer['email']); ?>

                                    </span>

                                </div>
                            </div>
                            <hr>




                            <?php if($order->delivery_address): ?>
                                <?php ($address = json_decode($order->delivery_address, true)); ?>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5><?php echo e(translate('messages.delivery_info')); ?></h5>
                                </div>
                                <?php if(isset($address)): ?>
                                    <span class="delivery--information-single d-block">
                                        <div class="d-flex">
                                            <span class="name"><?php echo e(translate('messages.name')); ?>:</span>
                                            <span class="info"><?php echo e($address['contact_person_name']); ?></span>
                                        </div>
                                        <div class="d-flex">
                                            <span class="name"><?php echo e(translate('messages.contact')); ?>:</span>
                                            <a class="info deco-none"
                                                href="tel:<?php echo e($address['contact_person_number']); ?>">
                                                <?php echo e($address['contact_person_number']); ?></a>
                                        </div>
                                        <div class="d-flex">
                                            <span class="name"><?php echo e(translate('Floor')); ?>:</span>
                                            <span
                                                class="info"><?php echo e(isset($address['floor']) ? $address['floor'] : ''); ?></span>
                                        </div>

                                        <div class="d-flex mb-2">
                                            <span class="name"><?php echo e(translate('House')); ?>:</span>
                                            <span
                                                class="info"><?php echo e(isset($address['house']) ? $address['house'] : ''); ?></span>
                                        </div>
                                        <div class="d-flex">
                                            <span class="name"><?php echo e(translate('Road')); ?>:</span>
                                            <span
                                                class="info"><?php echo e(isset($address['road']) ? $address['road'] : ''); ?></span>
                                        </div>
                                        <?php if($order['order_type'] != 'take_away' && isset($address['address'])): ?>
                                            <?php if(isset($address['latitude']) && isset($address['longitude'])): ?>
                                                <a target="_blank"
                                                    href="http://maps.google.com/maps?z=12&t=m&q=loc:<?php echo e($address['latitude']); ?>+<?php echo e($address['longitude']); ?>">
                                                    <i class="tio-map"></i><?php echo e($address['address']); ?><br>
                                                </a>
                                            <?php else: ?>
                                                <i class="tio-map"></i><?php echo e($address['address']); ?><br>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                    <?php elseif($order->is_guest): ?>
                        <div class="card-body">
                            <span class="badge badge-soft-success py-2 mb-2 d-block qcont">
                                <?php echo e(translate('Guest_user')); ?>

                            </span>
                            <?php if($order->delivery_address): ?>
                            <?php ($address = json_decode($order->delivery_address, true)); ?>
                            <div class="d-flex justify-content-between align-items-center">
                                <h5><?php echo e(translate('messages.delivery_info')); ?></h5>
                            </div>
                            <?php if(isset($address)): ?>
                                <span class="delivery--information-single d-block">
                                    <div class="d-flex">
                                        <span class="name"><?php echo e(translate('messages.name')); ?>:</span>
                                        <span class="info"><?php echo e($address['contact_person_name']); ?></span>
                                    </div>
                                    <div class="d-flex">
                                        <span class="name"><?php echo e(translate('messages.contact')); ?>:</span>
                                        <a class="info deco-none"
                                            href="tel:<?php echo e($address['contact_person_number']); ?>">
                                            <?php echo e($address['contact_person_number']); ?></a>
                                    </div>
                                    <div class="d-flex">
                                        <span class="name"><?php echo e(translate('Floor')); ?>:</span>
                                        <span
                                            class="info"><?php echo e(isset($address['floor']) ? $address['floor'] : ''); ?></span>
                                    </div>

                                    <div class="d-flex mb-2">
                                        <span class="name"><?php echo e(translate('House')); ?>:</span>
                                        <span
                                            class="info"><?php echo e(isset($address['house']) ? $address['house'] : ''); ?></span>
                                    </div>

                                    <div class="d-flex">
                                        <span class="name"><?php echo e(translate('Road')); ?>:</span>
                                        <span
                                            class="info"><?php echo e(isset($address['road']) ? $address['road'] : ''); ?></span>
                                    </div>

                                    <?php if($order['order_type'] != 'take_away' && isset($address['address'])): ?>
                                    <hr>
                                        <?php if(isset($address['latitude']) && isset($address['longitude'])): ?>
                                            <a target="_blank"
                                                href="http://maps.google.com/maps?z=12&t=m&q=loc:<?php echo e($address['latitude']); ?>+<?php echo e($address['longitude']); ?>">
                                                <i class="tio-map"></i><?php echo e($address['address']); ?><br>
                                            </a>
                                        <?php else: ?>
                                            <i class="tio-map"></i><?php echo e($address['address']); ?><br>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </span>
                            <?php endif; ?>
                        <?php endif; ?>

                        </div>
                    <?php else: ?>
                        <div class="card-body">
                            <span class="badge badge-soft-danger py-2 d-block qcont">
                                <?php echo e(translate('Customer Not found!')); ?>

                            </span>
                        </div>
                    <?php endif; ?>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
        </div>
        <!-- End Row -->
    </div>



        <!-- Modal -->
        <div class="modal fade order-proof-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4" id="mySmallModalLabel"><?php echo e(translate('messages.add_delivery_proof')); ?></h5>
                    <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal"
                        aria-label="Close">
                        <i class="tio-clear tio-lg"></i>
                    </button>
                </div>

                <form action="<?php echo e(route('vendor.order.add-order-proof', [$order['id']])); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <!-- Input Group -->
                        <div class="flex-grow-1 mx-auto">

                            <div class="d-flex flex-wrap __gap-12px __new-coba" id="coba">
                                <?php ($proof = isset($order->order_proof) ? json_decode($order->order_proof, true) : 0); ?>
                                <?php if($proof): ?>

                                <?php $__currentLoopData = $proof; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php ($photo = is_array($photo)?$photo:['img'=>$photo,'storage'=>'public']); ?>

                                            <div class="spartan_item_wrapper min-w-176px max-w-176px">
                                                <img class="img--square"
                                                    src="<?php echo e(\App\CentralLogics\Helpers::get_full_url('order',$photo['img'],$photo['storage'])); ?>"
                                                    alt="order image">

                                                <div class="pen spartan_remove_row"><i class="tio-edit"></i></div>
                                                <a href="<?php echo e(route('vendor.order.remove-proof-image', ['id' => $order['id'], 'name' => $photo])); ?>"
                                                    class="spartan_remove_row"><i class="tio-add-to-trash"></i></a>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- End Input Group -->
                        <div class="text-right mt-2">
                            <button class="btn btn--primary"><?php echo e(translate('messages.submit')); ?></button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- End Modal -->

    <div class="modal fade" id="edit-order-amount" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo e(translate('messages.update_order_amount')); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('vendor.order.update-order-amount')); ?>" method="POST" class="row">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="order_id" value="<?php echo e($order->id); ?>">
                        <div class="form-group col-12">
                            <label for="order_amount"><?php echo e(translate('messages.order_amount')); ?></label>
                            <input id="order_amount" type="number" class="form-control" name="order_amount" min="0"
                                value="<?php echo e(round($order['order_amount'] - $order['total_tax_amount']  - $order['additional_charge'] -  $order['delivery_charge'] + $order['store_discount_amount'] - $order['dm_tips'] ,6)); ?>" step=".01">
                        </div>

                        <div class="form-group col-sm-12">
                            <button class="btn btn-sm btn-primary"
                                type="submit"><?php echo e(translate('messages.submit')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit-discount-amount" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo e(translate('messages.update_discount_amount')); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('vendor.order.update-discount-amount')); ?>" method="POST" class="row">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="order_id" value="<?php echo e($order->id); ?>">
                        <div class="form-group col-12">
                            <label for="discount_amount"><?php echo e(translate('messages.discount_amount')); ?></label>
                            <input type="number" id="discount_amount" class="form-control" name="discount_amount" min="0"
                                value="<?php echo e($order['store_discount_amount']); ?>" step=".01">
                        </div>

                        <div class="form-group col-sm-12">
                            <button class="btn btn-sm btn-primary"
                                type="submit"><?php echo e(translate('messages.submit')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- End Content -->


<?php $__env->stopSection(); ?>
<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin/js/spartan-multi-image-picker.js')); ?>"></script>
    <script type="text/javascript">
        "use strict";


        $('.self-delivery-warning').on('click',function (event ){
            event.preventDefault();
            toastr.info(
                "<?php echo e(translate('messages.Self_Delivery_is_Disable')); ?>", {
                    CloseButton: true,
                    ProgressBar: true
                });
        });



        $('.cancelled-status').on('click',function (){
            Swal.fire({
                title: '<?php echo e(translate('messages.are_you_sure')); ?>',
                text: '<?php echo e(translate('messages.Change status to canceled ?')); ?>',
                type: 'warning',
                html:
                    `   <select class="form-control js-select2-custom mx-1" name="reason" id="reason">
                    <?php $__currentLoopData = $reasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($r->reason); ?>">
                            <?php echo e($r->reason); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </select>`,
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#FC6A57',
                cancelButtonText: '<?php echo e(translate('messages.no')); ?>',
                confirmButtonText: '<?php echo e(translate('messages.yes')); ?>',
                reverseButtons: true,
                onOpen: function () {
                    $('.js-select2-custom').select2({
                        minimumResultsForSearch: 5,
                        width: '100%',
                        placeholder: "Select Reason",
                        language: "en",
                    });
                }
            }).then((result) => {
                if (result.value) {
                    let reason = document.getElementById('reason').value;
                    location.href = '<?php echo route('vendor.order.status', ['id' => $order['id'],'order_status' => 'canceled']); ?>&reason='+reason,'<?php echo e(translate('Change status to canceled ?')); ?>';
                }
            })

        });

        $('.order-status-change-alert').on('click',function (){
            let route = $(this).data('url');
            let message = $(this).data('message');
            let verification = $(this).data('verification');
            let processing = $(this).data('processing-time') ?? false;

            if (verification) {
                Swal.fire({
                    title: '<?php echo e(translate('Enter order verification code')); ?>',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    cancelButtonColor: 'default',
                    confirmButtonColor: '#FC6A57',
                    confirmButtonText: '<?php echo e(translate('messages.submit')); ?>',
                    showLoaderOnConfirm: true,
                    preConfirm: (otp) => {
                        location.href = route + '&otp=' + otp;
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                })
            } else if (processing) {
                Swal.fire({
                    title: '<?php echo e(translate('messages.Are you sure ?')); ?>',
                    type: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: 'default',
                    confirmButtonColor: '#FC6A57',
                    cancelButtonText: '<?php echo e(translate('messages.Cancel')); ?>',
                    confirmButtonText: '<?php echo e(translate('messages.submit')); ?>',
                    inputPlaceholder: "<?php echo e(translate('Enter processing time')); ?>",
                    input: 'text',
                    html: message + '<br/>'+'<label><?php echo e(translate('Enter Processing time in minutes')); ?></label>',
                    inputValue: processing,
                    preConfirm: (processing_time) => {
                        location.href = route + '&processing_time=' + processing_time;
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                })
            } else {
                Swal.fire({
                    title: '<?php echo e(translate('messages.Are you sure ?')); ?>',
                    text: message,
                    type: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: 'default',
                    confirmButtonColor: '#FC6A57',
                    cancelButtonText: '<?php echo e(translate('messages.No')); ?>',
                    confirmButtonText: '<?php echo e(translate('messages.Yes')); ?>',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        location.href = route;
                    }
                })
            }

        });

        $(function() {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'order_proof[]',
                maxCount: 6-<?php echo e(($order->order_proof && is_array($order->order_proof))?count(json_decode($order->order_proof)):0); ?>,
                rowHeight: '176px !important',
                groupClassName: 'spartan_item_wrapper min-w-176px max-w-176px',
                maxFileSize: '',
                placeholderImage: {
                    image: "<?php echo e(asset('public/assets/admin/img/upload-img.png')); ?>",
                    width: '176px'
                },
                dropFileLabel: "Drop Here",
                onAddRow: function(index, file) {

                },
                onRenderedPreview: function(index) {

                },
                onRemoveRow: function(index) {

                },
                onExtensionErr: function() {
                    toastr.error(
                        "<?php echo e(translate('messages.please_only_input_png_or_jpg_type_file')); ?>", {
                            CloseButton: true,
                            ProgressBar: true
                        });
                },
                onSizeErr: function() {
                    toastr.error("<?php echo e(translate('messages.file_size_too_big')); ?>", {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/order/order-view.blade.php ENDPATH**/ ?>