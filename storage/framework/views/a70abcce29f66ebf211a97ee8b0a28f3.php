<?php $__env->startSection('title', translate('Order Details')); ?>


<?php $__env->startSection('content'); ?>

<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-sm mb-2 mb-sm-0">
                <h1 class="page-header-title">
                    <span class="page-header-icon">
                        <img src="<?php echo e(asset('/public/assets/admin/img/shopping-basket.png')); ?>" class="w--20" alt="">
                    </span>
                    <span>
                        <?php echo e(translate('Parcel_details')); ?>

                    </span>

                </h1>
            </div>

            <div class="col-sm-auto">
                <a class="btn-icon btn-sm btn-soft-secondary rounded-circle mr-1"
                    href="<?php echo e(route('admin.order.details', [$order['id'] - 1])); ?>" data-toggle="tooltip"
                    data-placement="top" title="<?php echo e(translate('Previous order')); ?>">
                    <i class="tio-chevron-left"></i>
                </a>
                <a class="btn-icon btn-sm btn-soft-secondary rounded-circle"
                    href="<?php echo e(route('admin.order.details', [$order['id'] + 1])); ?>" data-toggle="tooltip"
                    data-placement="top" title="<?php echo e(translate('Next order')); ?>">
                    <i class="tio-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- Page Header -->

    <div class="row flex-xl-nowrap" id="printableArea">
        <div class="col-lg-8 order-print-area-left">
            <!-- Card -->
            <div class="card mb-3 mb-lg-5">
                <!-- Header -->
                <div class="card-header border-0 align-items-start flex-wrap">
                    <div class="order-invoice-left d-flex d-sm-block justify-content-between">
                        <div>
                            <h1 class="page-header-title d-flex align-items-center __gap-5px">
                                <?php echo e(translate('messages.order')); ?> #<?php echo e($order['id']); ?>



                            </h1>
                            <span class="mt-2 d-block d-flex align-items-center __gap-5px">
                                <i class="tio-date-range"></i>
                                <?php echo e(date('d M Y ' . config('timeformat'), strtotime($order['created_at']))); ?>

                            </span>

                            <?php if($order->schedule_at && $order->scheduled): ?>
                                <h6 class="text-capitalize d-flex align-items-center __gap-5px">
                                    <span><?php echo e(translate('messages.scheduled_at')); ?></span>
                                    <span>:</span> <label
                                        class="fz--10 badge badge-soft-warning"><?php echo e(date('d M Y ' . config('timeformat'), strtotime($order['schedule_at']))); ?></label>
                                </h6>
                            <?php endif; ?>
                            <?php if($order->coupon): ?>
                                <h6 class="text-capitalize d-flex align-items-center __gap-5px">
                                    <span><?php echo e(translate('messages.coupon')); ?></span>
                                    <span>:</span> <label class="fz--10 badge badge-soft-primary"><?php echo e($order->coupon_code); ?>

                                        (<?php echo e(translate('messages.' . $order->coupon->coupon_type)); ?>)</label>
                                </h6>
                            <?php endif; ?>
                            <div class="hs-unfold mt-1">
                                <h5>
                                    <button
                                        class="btn py-1 px-2 order--details-btn-sm btn--primary btn-outline-primary btn--sm font-regular d-flex align-items-center __gap-5px"
                                        data-toggle="modal" data-target="#locationModal"><i class="tio-poi"></i>
                                        <?php echo e(translate('messages.show_locations_on_map')); ?></button>
                                </h5>
                            </div>
                            <?php if($order['delivery_instruction']): ?>
                                <div class="__bg-FAFAFA fs-12 rounded p-10px mt-2 mb-3">
                                    <strong class="text-title"><?php echo e(translate('messages.delivery_instruction')); ?>

                                        :</strong> <?php echo e($order['delivery_instruction']); ?>

                                </div>
                                <!-- New Note -->
                            <?php endif; ?>

                            <!-- New Note -->
                            <?php if(
                                    $order->parcelCancellation?->return_fee > 0 &&
                                    !in_array($order->parcelCancellation?->cancel_by, ['deliveryman', 'admin_for_deliveryman'])
                                ): ?>
                                <div
                                    class="bg-danger-5 p-10px rounded d-flex align-items-center justify-content-between gap-1 mt-3">
                                    <span
                                        class="text-title text-capitalize fs-12"><?php echo e(translate('Customer will pay parcel & return fee')); ?></span>
                                    <h4 class="m-0 text-title text-nowrap">
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($order->parcelCancellation?->return_fee + $order->order_amount)); ?>

                                    </h4>
                                </div>
                            <?php endif; ?>
                            <!-- New Note End -->

                            <?php if($order['unavailable_item_note']): ?>
                                <h6 class="w-100 badge-soft-warning mt-3 p-1 rounded">
                                    <span class="text-dark">
                                        <?php echo e(translate('messages.order_unavailable_item_note')); ?> :
                                    </span>
                                    <?php echo e($order['unavailable_item_note']); ?>

                                </h6>
                            <?php endif; ?>

                            <?php if($order['order_note']): ?>
                                <h6>
                                    <?php echo e(translate('messages.order_note')); ?> :
                                    <?php echo e($order['order_note']); ?>

                                </h6>
                            <?php endif; ?>
                            <?php if($order?->offline_payments && $order?->offline_payments->status == 'denied' && $order?->offline_payments->note): ?>
                                <h6 class="w-100 badge-soft-warning p-1 rounded mt-2">
                                    <span class="text-dark">
                                        <?php echo e(translate('messages.Offline_payment_rejection_note')); ?> :
                                    </span>
                                    <?php echo e($order?->offline_payments->note); ?>

                                </h6>
                            <?php endif; ?>
                        </div>
                        <div class="d-sm-none">
                            <a class="btn btn--primary print--btn font-regular d-flex align-items-center __gap-5px"
                                href=<?php echo e(route('admin.order.generate-invoice', [$order['id']])); ?>>
                                <i class="tio-print mr-sm-1"></i>
                                <span><?php echo e(translate('messages.print_invoice')); ?></span>
                            </a>
                        </div>
                    </div>
                    <div class="order-invoice-right mt-3 mt-sm-0">
                        <div class="btn--container flex-wrap ml-auto align-items-end justify-content-end">


                            <a class="btn btn--primary print--btn font-regular py-2 px-3 d-none d-sm-block" href=<?php echo e(route('admin.order.generate-invoice', [$order['id']])); ?>>
                                <i class="tio-print mr-sm-1"></i>
                                <span><?php echo e(translate('messages.print_invoice')); ?></span>
                            </a>
                        </div>
                        <div class="text-right mt-3 order-invoice-right-contents text-capitalize">
                            <h6>
                                <span><?php echo e(translate('status')); ?></span> <span>:</span>
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
                                        <?php echo e(translate(str_replace('_', ' ', $order['order_status']))); ?>

                                    </span>
                                <?php endif; ?>
                            </h6>
                            <h6 class="text-capitalize">
                                <span><?php echo e(translate('messages.payment_method')); ?></span> <span>:</span>
                                <span><?php echo e(translate(str_replace('_', ' ', $order['payment_method']))); ?></span>
                            </h6>

                            <!-- offline_payment -->
                            <?php if($order?->offline_payments): ?>
                                <span><?php echo e(translate('Payment_verification')); ?></span> <span>:</span>
                                <?php if($order?->offline_payments->status == 'pending'): ?>
                                    <span class="badge badge-soft-info ml-2 ml-sm-3 text-capitalize">
                                        <?php echo e(translate('messages.pending')); ?>

                                    </span>
                                <?php elseif($order?->offline_payments->status == 'verified'): ?>
                                    <span class="badge badge-soft-success ml-2 ml-sm-3 text-capitalize">
                                        <?php echo e(translate('messages.verified')); ?>

                                    </span>
                                <?php elseif($order?->offline_payments->status == 'denied'): ?>
                                    <span class="badge badge-soft-danger ml-2 ml-sm-3 text-capitalize">
                                        <?php echo e(translate('messages.denied')); ?>

                                    </span>
                                <?php endif; ?>

                                <?php $__currentLoopData = json_decode($order->offline_payments->payment_info); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($key != 'method_id'): ?>
                                        <h6 class="">
                                            <div class="d-flex justify-content-sm-end text-capitalize">
                                                <span class="title-color"><?php echo e(translate($key)); ?> :</span>
                                                <strong><?php echo e($item); ?></strong>
                                            </div>
                                        </h6>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

                            <h6 class="">
                                <?php if($order['transaction_reference'] == null): ?>
                                    <span><?php echo e(translate('messages.reference_code')); ?></span> <span>:</span>
                                    <button class="btn btn-outline-primary btn-sm py-half fs-12" data-toggle="modal"
                                        data-target=".bd-example-modal-sm">
                                        <?php echo e(translate('messages.add')); ?>

                                    </button>
                                <?php else: ?>
                                    <span><?php echo e(translate('messages.reference_code')); ?></span> <span>:</span>
                                    <span><?php echo e($order['transaction_reference']); ?></span>
                                <?php endif; ?>
                            </h6>

                            <h6 class="text-capitalize">
                                <span><?php echo e(translate('Order Type')); ?></span>
                                <span>:</span> <label
                                    class="fz--10 badge badge-soft-primary m-0"><?php echo e(translate(str_replace('_', ' ', $order['order_type']))); ?></label>
                            </h6>
                            <h6 class="text-capitalize">
                                <span><?php echo e(translate('Paid By')); ?></span>
                                <span>:</span> <label
                                    class="fz--10 badge badge-soft-secondary m-0"><?php echo e(translate($order->charge_payer)); ?></label>
                            </h6>
                            <h6>
                                <span><?php echo e(translate('payment_status')); ?></span> <span>:</span>
                                <?php if($order['payment_status'] == 'paid'): ?>
                                    <span class="badge badge-soft-success ml-sm-3">
                                        <?php echo e(translate('messages.paid')); ?>

                                    </span>
                                <?php elseif($order['payment_status'] == 'partially_paid'): ?>
                                    <?php if($order->payments()->where('payment_status', 'unpaid')->exists()): ?>
                                        <strong class="text-danger"><?php echo e(translate('messages.partially_paid')); ?></strong>
                                    <?php else: ?>
                                        <strong class="text-success"><?php echo e(translate('messages.paid')); ?></strong>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <strong class="text-danger"><?php echo e(translate('messages.unpaid')); ?></strong>
                                <?php endif; ?>
                            </h6>
                        </div>
                    </div>
                </div>
                <!-- End Header -->

                <!-- Body -->
                <div class="card-body px-0">

                    <div class="mx-3">
                        <div class="media align-items-center cart--media pb-2">
                            <div class="avatar avatar-xl mr-3"
                                title="<?php echo e($order->parcel_category ? $order->parcel_category->name : translate('messages.parcel_category_not_found')); ?>">
                                <img class="img-fluid onerror-image"
                                    src="<?php echo e($order->parcel_category?->image_full_url ?? asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                                    data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>">
                            </div>
                            <div class="media-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <strong>
                                            <?php echo e(Str::limit($order->parcel_category ? $order->parcel_category->name : translate('messages.parcel_category_not_found'), 25, '...')); ?></strong><br>
                                        <div class="font-size-sm text-body">
                                            <span><?php echo e($order->parcel_category ? $order->parcel_category->description : translate('messages.parcel_category_not_found')); ?></span>
                                        </div>
                                    </div>

                                    <div class="col col-md-2 align-self-center">
                                        <h6><?php echo e(translate('messages.distance')); ?></h6>
                                        <span><?php echo e($order->distance); ?> <?php echo e(translate('km')); ?></span>
                                    </div>
                                    <div class="col col-md-1 align-self-center">

                                    </div>

                                    <div class="col col-md-3 align-self-center text-right">
                                        <h6><?php echo e(translate('messages.delivery_charge')); ?></h6>
                                        <span><?php echo e(\App\CentralLogics\Helpers::format_currency($order['delivery_charge'])); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-2">
                    </div>



                    <div class="row justify-content-md-end mb-3 mt-4 mx-0">
                        <div class="col-12">
                            <dl class="row text-right px-3">

                                <?php if(($order->tax_status == 'excluded' && $order['total_tax_amount'] > 0) || $order->tax_status == null): ?>
                                    <dt class="col-6 col-sm-8 p-0 font-regular"><?php echo e(translate('messages.vat/tax')); ?>:
                                    </dt>
                                    <dd class="col-6 col-sm-4 p-0 text-right">
                                        +
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($order['total_tax_amount'])); ?>


                                    </dd>
                                <?php endif; ?>

                                <dt class="col-6 col-sm-8 p-0 font-regular">
                                    <?php echo e(translate('messages.delivery_man_tips')); ?>

                                </dt>
                                <dd class="col-6 col-sm-4 p-0">
                                    + <?php echo e(\App\CentralLogics\Helpers::format_currency($order['dm_tips'])); ?></dd>
                                <dt class="col-6 col-sm-8 p-0 font-regular text-truncate">
                                    <?php echo e(\App\CentralLogics\Helpers::get_business_data('additional_charge_name') ?? (\App\CentralLogics\Helpers::get_business_data('additional_charge_name') ?? translate('messages.additional_charge'))); ?>

                                    <hr>
                                </dt>

                                <dd class="col-6 col-sm-4 p-0">
                                    + <?php echo e(\App\CentralLogics\Helpers::format_currency($order['additional_charge'])); ?>

                                    <hr>
                                </dd>

                                <dt class="col-6 col-sm-8 p-0 fs-16">
                                    <div class="d-flex align-items-center gap-2 justify-content-end">
                                        <?php echo e(translate('messages.total')); ?>

                                        <?php echo e($order->tax_status == 'included' ? '(' . translate('messages.TAX_Included') . ')' : ''); ?>


                                        <?php if(in_array($order->parcelCancellation?->cancel_by, ['deliveryman', 'admin_for_deliveryman'])): ?>
                                            <span class="form-label-secondary text-danger d-flex" data-toggle="tooltip"
                                                data-placement="right"
                                                data-original-title="<?php echo e(translate('No delivery fee will be charged if Delivery Man cancels the order')); ?>"><img
                                                    src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                    alt="Veg/non-veg toggle"> </span>
                                        <?php endif; ?>

                                        </span>
                                        <?php if($order->parcelCancellation?->return_fee > 0 && $order->charge_payer != 'receiver'): ?>
                                            <?php if($order->payment_method != 'cash_on_delivery'): ?>
                                                <?php if($order->payment_status == 'paid'): ?>
                                                    <span class="badge border-0 fs-10 badge-soft-success">
                                                        <?php echo e(translate('messages.Paid')); ?>

                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge border-0 fs-10 badge-soft-danger">
                                                        <?php echo e(translate('Due')); ?>

                                                    </span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </dt>
                                <dd class="col-6 col-sm-4 p-0 font-semibold text-title">
                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($order['delivery_charge'] + $order['total_tax_amount'] + $order['dm_tips'] + $order['additional_charge'] - $order['coupon_discount_amount'] - $order['ref_bonus_amount'])); ?>

                                </dd>
                                <?php if($order->parcelCancellation?->return_fee > 0): ?>

                                    <dt class="col-6 col-sm-8 p-0 fs-16">
                                        <div
                                            class="d-flex fs-12 font-regular color-222324CC align-items-center gap-2 justify-content-end">
                                            <?php echo e(translate('messages.return_fee')); ?>

                                            <?php if($order?->parcelCancellation?->return_fee_payment_status == 'paid'): ?>
                                                <span class="badge border-0 fs-10 badge-soft-success">
                                                    <?php echo e(translate('messages.Paid')); ?>

                                                </span>
                                            <?php else: ?>
                                                <span class="badge border-0 fs-10 badge-soft-danger">
                                                    <?php echo e(translate('Due')); ?>

                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <?php if(
                                                $order->parcelCancellation?->return_fee > 0 &&
                                                !in_array($order->parcelCancellation?->cancel_by, ['deliveryman', 'admin_for_deliveryman'])
                                            ): ?>
                                            <hr>
                                        <?php endif; ?>
                                    </dt>
                                    <dd class="col-6 col-sm-4 p-0">
                                        <div class="fs-14 text-title">
                                            <?php echo e(\App\CentralLogics\Helpers::format_currency($order?->parcelCancellation?->return_fee)); ?>

                                        </div>
                                        <?php if(
                                                $order->parcelCancellation?->return_fee > 0 &&
                                                !in_array($order->parcelCancellation?->cancel_by, ['deliveryman', 'admin_for_deliveryman'])
                                            ): ?>
                                            <hr>
                                        <?php endif; ?>
                                    </dd>
                                <?php endif; ?>

                                <?php if(
                                        $order->parcelCancellation?->return_fee > 0 &&
                                        !in_array($order->parcelCancellation?->cancel_by, ['deliveryman', 'admin_for_deliveryman'])
                                    ): ?>
                                    <dt class="col-6 col-sm-8 p-0 fs-16">
                                        <div
                                            class="d-flex fs-16 font-semibold font-regular text-title align-items-center gap-2 justify-content-end">
                                            <?php echo e(translate('Sub Total')); ?>


                                            <?php if($order?->parcelCancellation?->return_fee_payment_status == 'paid'): ?>
                                                <span class="badge border-0 fs-10 badge-soft-success">
                                                    <?php echo e(translate('messages.Paid')); ?>

                                                </span>
                                            <?php else: ?>
                                                <span class="badge border-0 fs-10 badge-soft-danger">
                                                    <?php echo e(translate('Due')); ?>

                                                </span>
                                            <?php endif; ?>


                                        </div>
                                    </dt>
                                    <dd class="col-6 col-sm-4 p-0">
                                        <div class="fs-16 text-title font-semibold">
                                            <?php echo e(\App\CentralLogics\Helpers::format_currency($order['delivery_charge'] + $order['total_tax_amount'] + $order['dm_tips'] + $order['additional_charge'] - $order['coupon_discount_amount'] - $order['ref_bonus_amount'] + $order?->parcelCancellation?->return_fee ?? 0)); ?>

                                        </div>
                                    </dd>
                                <?php endif; ?>





                                <?php if($order?->payments): ?>
                                    <?php $__currentLoopData = $order?->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($payment->payment_status == 'paid'): ?>
                                            <?php if($payment->payment_method == 'cash_on_delivery'): ?>
                                                <dt class="col-6 col-sm-8 p-0 font-regular">
                                                    <?php echo e(translate('messages.Paid_with_Cash')); ?>

                                                    (<?php echo e(translate('COD')); ?>)
                                                    :
                                                </dt>
                                            <?php else: ?>
                                                <dt class="col-6 col-sm-8 p-0 font-regular">
                                                    <?php echo e(translate('messages.Paid_by')); ?>

                                                    <?php echo e(translate($payment->payment_method)); ?> :
                                                </dt>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <dt class="col-6 col-sm-8 p-0 font-regular"><?php echo e(translate('Due_Amount')); ?>

                                                (<?php echo e($payment->payment_method == 'cash_on_delivery' ? translate('messages.COD') : translate($payment->payment_method)); ?>)
                                                :</dt>
                                        <?php endif; ?>
                                        <dd class="col-6 col-sm-4 p-0 text-right">
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

        <div class="col-lg-4 order-print-area-right">
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title text-title mb-2 fs-14"><?php echo e(translate('Parcel_Status')); ?>

                        <?php if($order?->parcelCancellation?->is_refunded == 1): ?>
                            <span class='ml-2 badge badge-soft-primary'>
                                <?php echo e(translate('Refunded')); ?>

                            </span>
                        <?php endif; ?>

                    </h5>
                    <div class="hs-unfold w-100">
                        <div class="dropdown">
                            <button <?php if(
                                in_array($order['order_status'], [
                                    'refund_requested',
                                    'refunded',
                                    'refund_request_canceled',
                                    'delivered',
                                    'failed',
                                    'returned',
                                ])
                            ): echo 'disabled'; endif; ?> <?php echo e($order['order_status'] == 'canceled' && $order?->parcelCancellation && $order->parcelCancellation->before_pickup == 1 ? 'disabled' : ''); ?>

                                class="form-control h--45px dropdown-toggle d-flex justify-content-between align-items-center w-100"
                                type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <?php
$message = match ($order['order_status']) {
    'pending' => translate('messages.pending'),
    'confirmed' => translate('messages.confirmed'),
    'accepted' => translate('messages.confirmed'),
    'processing' => translate('messages.processing'),
    'handover' => translate('messages.confirmed'),
    'picked_up' => translate('messages.out_for_delivery'),
    'delivered' => translate('messages.delivered'),
    'canceled' => translate('messages.canceled'),
    'returned' => translate('messages.returned'),
    default => translate('messages.status'),
};
                                    ?>
                                <?php echo e($message); ?>

                            </button>

                            <div class="dropdown-menu text-capitalize" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item <?php echo e($order['order_status'] == 'pending' ? 'active' : ''); ?> <?php echo e($order['order_status'] == 'canceled' ? 'disabled' : ''); ?> route-alert"
                                    data-url="<?php echo e(route('admin.order.status', ['id' => $order['id'], 'order_status' => 'pending'])); ?>"
                                    data-message="<?php echo e(translate('Change status to pending ?')); ?>"
                                    href="javascript:"><?php echo e(translate('messages.pending')); ?></a>
                                <a class="dropdown-item <?php echo e(in_array($order['order_status'], ['accepted', 'confirmed', 'handover']) ? 'active' : ''); ?> route-alert <?php echo e($order['order_status'] == 'canceled' ? 'disabled' : ''); ?>"
                                    data-url="<?php echo e(route('admin.order.status', ['id' => $order['id'], 'order_status' => 'confirmed'])); ?>"
                                    data-message="<?php echo e(translate('Change status to confirmed ?')); ?>"
                                    href="javascript:"><?php echo e(translate('messages.confirmed')); ?></a>

                                <a class="dropdown-item <?php echo e($order['order_status'] == 'picked_up' ? 'active' : ''); ?> route-alert <?php echo e($order['order_status'] == 'canceled' ? 'disabled' : ''); ?>"
                                    data-url="<?php echo e(route('admin.order.status', ['id' => $order['id'], 'order_status' => 'picked_up'])); ?>"
                                    data-message="<?php echo e(translate('Change status to out for delivery ?')); ?>"
                                    href="javascript:"><?php echo e(translate('messages.out_for_delivery')); ?></a>
                                <a class="dropdown-item <?php echo e($order['order_status'] == 'delivered' ? 'active' : ''); ?> route-alert <?php echo e($order['order_status'] == 'canceled' ? 'disabled' : ''); ?>"
                                    data-url="<?php echo e(route('admin.order.status', ['id' => $order['id'], 'order_status' => 'delivered'])); ?>"
                                    data-message="<?php echo e(translate('Change status to delivered (payment status will be paid if not)?')); ?>"
                                    href="javascript:"><?php echo e(translate('messages.delivered')); ?></a>
                                <a class="dropdown-item trigger-reason offcanvas-trigger <?php echo e($order['order_status'] == 'canceled' ? 'disabled' : ''); ?> <?php echo e($order['order_status'] == 'canceled' ? 'active' : ''); ?>"
                                    data-target="#percel-cancellation_offcanvas"><?php echo e(translate('messages.canceled')); ?></a>
                                <?php if(
                                        $order['order_status'] == 'canceled' &&
                                        $order?->parcelCancellation &&
                                        $order->parcelCancellation->before_pickup == 0
                                    ): ?>
                                    <a class="dropdown-item route-alert"
                                        data-url="<?php echo e(route('admin.order.parcelReturn', ['id' => $order['id'], 'order_status' => 'returned'])); ?>"
                                        data-message="<?php echo e(translate('Return_the_parcel ?')); ?>"
                                        href="javascript:"><?php echo e(translate('messages.return_parcel')); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php if(
                            !in_array($order['order_status'], [
                                'refund_requested',
                                'refunded',
                                'refund_request_canceled',
                                'delivered',
                                'canceled',
                                'returned',
                            ]) && $order->delivery_man_id == null
                        ): ?>
                        <div class="w-100 text-center mt-3">
                            <button type="button" class="btn btn--primary w-100" data-toggle="modal" data-target="#myModal"
                                data-lat='21.03' data-lng='105.85'>
                                <?php echo e(translate('messages.assign_delivery_man_manually')); ?>

                            </button>
                        </div>
                    <?php endif; ?>
                    <?php if($order?->parcelCancellation && $order?->parcelCancellation?->is_delivery_charge_refundable == 1): ?>
                        <?php if($order?->parcelCancellation?->is_refunded == 0): ?>
                            <div class="w-100 text-center mt-3">
                                <button type="button" class="btn btn--primary w-100" data-toggle="modal"
                                    data-target="#manually_parcel_amount_refund">
                                    <?php echo e(translate('Manually_Refund_To_User')); ?>

                                </button>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php if($order->parcelCancellation): ?>

                <div class="card mb-2">
                    <!-- Canceled New -->
                    <div class="card-body">
                        <?php if($order->parcelCancellation?->return_otp != null): ?>
                            <div class="__bg-FAFAFA p-2 rounded d-flex align-items-center justify-content-between gap-1">
                                <span class="text-title fs-12"><?php echo e(translate('Parcel Returned OTP')); ?></span>
                                <h3 class="m-0 text-title text-nowrap"><?php echo e($order->parcelCancellation?->return_otp); ?>

                                </h3>
                            </div>
                        <?php endif; ?>
                        <ul class="delivery--information-single mt-3 ">
                            <li>
                                <span class="name"><?php echo e(translate('Canceled_By')); ?> </span>
                                <span class="info"> <?php echo e(translate($order->canceled_by)); ?> </span>
                            </li>

                        </ul>
                        <?php if($order->parcelCancellation?->return_fee > 0): ?>
                            <div
                                class="bg-FF40401A p-10px text-capitalize rounded d-flex align-items-center justify-content-between gap-1 mt-3">

                                <?php if(
                                        $order->charge_payer == 'receiver' &&
                                        !in_array($order->parcelCancellation?->cancel_by, ['deliveryman', 'admin_for_deliveryman'])
                                    ): ?>
                                    <span
                                        class="text-title fs-12"><?php echo e(translate('Customer will pay both parcel & return fee')); ?></span>
                                    <h4 class="m-0 text-title text-nowrap">
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($order->parcelCancellation?->return_fee + $order->order_amount)); ?>

                                    </h4>
                                <?php else: ?>
                                    <span class="text-title fs-12"><?php echo e(translate('Customer will pay return fee')); ?></span>
                                    <h4 class="m-0 text-title text-nowrap">
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($order->parcelCancellation?->return_fee)); ?>

                                    </h4>
                                <?php endif; ?>

                            </div>
                        <?php endif; ?>
                        <div class="p-10px __bg-FAFAFA mt-3">
                            <?php if(is_array($order->parcelCancellation?->reason) && count($order->parcelCancellation?->reason) > 0): ?>
                                <div class="fs-12">
                                    <span class="text-title font-medium"><?php echo e(translate('Cancel Reason')); ?></span> <br>
                                    <ul>
                                        <?php $__currentLoopData = $order->parcelCancellation?->reason; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reason): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="mr-1"><?php echo e($reason); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <?php if($order->parcelCancellation?->note): ?>
                                <div class="fs-12 mt-3">
                                    <span class="text-title font-medium"><?php echo e(translate('Comment')); ?></span> <br>
                                    <p class="ml-2"> <?php echo e($order->parcelCancellation?->note); ?> </p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if($order->parcelCancellation?->before_pickup === 0): ?>
                            <div class="mt-3 d-flex gap-2 text-title mt-3">
                                <i class="tio-calendar-month mt-1"></i>
                                <div class="fs-12 text-title">
                                    <?php echo e(translate('Estimated Return Date & Time:')); ?> <span>
                                        <?php echo e($order->parcelCancellation?->set_return_date == 0 ? translate('Not Set Yet') : \App\CentralLogics\Helpers::time_date_format($order->parcelCancellation?->return_date)); ?>

                                    </span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if($order->delivery_man): ?>
            <div class="card mt-2">
                <div class="card-body">
                    <h5 class="card-title mb-10px d-flex flex-wrap align-items-center">
                        <span class="card-header-icon">
                            <i class="tio-user"></i>
                        </span>
                        <span><?php echo e(translate('messages.deliveryman')); ?></span>
                        <?php if(
                                !in_array($order['order_status'], [
                                    'refund_requested',
                                    'refunded',
                                    'refund_request_canceled',
                                    'delivered',
                                    'canceled',
                                    'returned',
                                ])
                            ): ?>
                            <a type="button" href="#myModal" class="text--base fs-12 font-midium cursor-pointer ml-auto"
                                data-toggle="modal" data-target="#myModal">
                                <?php echo e(translate('messages.change')); ?>

                            </a>
                        <?php endif; ?>
                    </h5>
                    <a class="media align-items-center deco-none customer--information-single __bg-FAFAFA rounded p-10px mb-10px"
                        href="<?php echo e(!$order?->store?->sub_self_delivery ? route('admin.users.delivery-man.preview', [$order->delivery_man['id']]) : '#'); ?>">
                        <div class="avatar avatar-circle">
                            <img class="avatar-img onerror-image"
                                data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
                                src="<?php echo e($order->delivery_man?->image_full_url ?? asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
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
                    </a>
                    <?php ($address = $order->dm_last_location); ?>
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-1 font-regular"><?php echo e(translate('messages.last_location')); ?></h5>
                    </div>
                    <?php if(isset($address)): ?>
                        <span class="d-block">
                            <a target="_blank" class="base--clr fs-12"
                                href="http://maps.google.com/maps?z=12&t=m&q=loc:<?php echo e($address['latitude']); ?>+<?php echo e($address['longitude']); ?>">
                                <i class="tio-map color-222324CC"></i> <?php echo e($address['location']); ?><br>
                            </a>
                        </span>
                    <?php else: ?>
                        <span class="d-block text-lowercase qcont">
                            <?php echo e(translate('messages.location_not_found')); ?>

                        </span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
            <?php if(
                    $order?->offline_payments &&
                    !in_array($order->order_status, [
                        'refund_requested',
                        'refunded',
                        'refund_request_canceled',
                        'delivered',
                        'canceled',
                    ])
                ): ?>
                <div class="card">

                    <div class="card-body">
                        <div class="card border-info text-center mb-2">
                            <div class="card-body">
                                <h2>
                                    <?php echo e($order?->offline_payments->status == 'verified' ? translate('Payment_Verified') : translate('Payment_Verification')); ?>

                                </h2>
                                <?php if($order?->offline_payments->status == 'pending'): ?>
                                    <p class="text-danger">
                                        <?php echo e(translate('Please_Verify_the_payment_before_confirm_order.')); ?>

                                    </p>
                                    <div class="btn--container justify-content-center">
                                        <button type="button" class="btn btn--primary btn-sm" data-toggle="modal"
                                            data-target="#verifyViewModal"><?php echo e(translate('messages.Verify_Payment')); ?></button>
                                    </div>
                                <?php elseif($order?->offline_payments->status == 'verified'): ?>
                                    <div class="btn--container justify-content-center">
                                        <button type="button" class="btn btn--primary btn-sm" data-toggle="modal"
                                            data-target="#verifyViewModal"><?php echo e(translate('messages.Payment_Details')); ?></button>
                                    </div>
                                <?php elseif($order?->offline_payments->status == 'denied'): ?>
                                    <div class="btn--container justify-content-center">
                                        <button type="button" class="btn btn--primary btn-sm" data-toggle="modal"
                                            data-target="#verifyViewModal"><?php echo e(translate('messages.Recheck_Verification')); ?></button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>




            <div class="card mt-2">
                <div class="card-body pt-3">
                    <?php if($order->customer && $order->is_guest == 0): ?>
                        <h5 class="card-title mb-10px">
                            <span class="card-header-icon">
                                <i class="tio-user"></i>
                            </span>
                            <span><?php echo e(translate('customer_information')); ?></span>
                        </h5>

                        <a class="media align-items-center deco-none customer--information-single __bg-FAFAFA rounded p-10px mb-10px"
                            href="<?php echo e(route('admin.users.customer.view', [$order->customer['id']])); ?>">
                            <div class="avatar avatar-circle">
                                <img class="avatar-img onerror-image"
                                    data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
                                    src="<?php echo e($order->customer->image_full_url); ?>" alt="Image Description">
                            </div>
                            <div class="media-body">
                                <span class="fz--14px text--title font-semibold text-hover-primary d-block">
                                    <?php echo e($order->customer['f_name'] . ' ' . $order->customer['l_name']); ?>

                                </span>
                                <span><?php echo e($order->customer->orders_count); ?> <?php echo e(translate('messages.orders')); ?></span>
                                <span class="text--title font-semibold d-flex align-items-center">
                                    <i class="tio-call-talking-quiet mr-2"></i>
                                    <span><?php echo e($order->customer['phone']); ?></span>
                                </span>
                                <span class="text--title d-flex align-items-center">
                                    <i class="tio-email mr-2"></i> <span><?php echo e($order->customer['email']); ?></span>
                                </span>
                            </div>
                        </a>
                    <?php elseif($order->is_guest): ?>
                        <span class="badge badge-soft-success py-2 d-block qcont mb-3">
                            <?php echo e(translate('Guest_user')); ?>

                        </span>
                    <?php else: ?>
                        <span class="badge badge-soft-danger py-2 d-block qcont">
                            <?php echo e(translate('Customer Not found!')); ?>

                        </span>
                    <?php endif; ?>


                </div>
            </div>




            <!-- Dlivery Info Card -->
            <div class="card mb-2 mt-2">
                <div class="card-body">
                    <?php if($order->delivery_address): ?>
                    <?php ($address = json_decode($order->delivery_address, true)); ?>
                    <div class="d-flex justify-content-between align-items-center mb-10px">
                        <h5 class="card-title">
                            <span class="card-header-icon">
                                <i class="tio-user"></i>
                            </span>
                            <span><?php echo e(translate('messages.sender')); ?></span>
                        </h5>

                    </div>
                    <?php if(isset($address)): ?>

                        <div class="delivery--information-single __bg-FAFAFA p-10px rounded mb-10px">
                            <span class="name"><?php echo e(translate('messages.name')); ?></span>
                            <span
                                class="info"><?php echo e(data_get($address, 'contact_person_name', translate('messages.N/A'))); ?></span>
                            <span class="name"><?php echo e(translate('messages.contact')); ?></span>
                            <a class="deco-none info"
                                href="tel:<?php echo e(data_get($address, 'contact_person_number', translate('messages.N/A'))); ?>">
                                <?php echo e(data_get($address, 'contact_person_number', translate('messages.N/A'))); ?></a>
                            <?php if(data_get($address, 'house') != ''): ?>
                                <span class="name"><?php echo e(translate('House')); ?></span> <span
                                    class="info"><?php echo e(data_get($address, 'house', translate('messages.N/A'))); ?></span>
                            <?php endif; ?>
                            <?php if(data_get($address, 'floor') != ''): ?>
                                <span class="name"><?php echo e(translate('Floor')); ?></span> <span
                                    class="info"><?php echo e(data_get($address, 'floor', translate('messages.N/A'))); ?></span>
                            <?php endif; ?>

                            <?php if(data_get($address, 'road') != ''): ?>
                                <span class="name"><?php echo e(translate('Road')); ?></span> <span
                                    class="info"><?php echo e(data_get($address, 'road', translate('messages.N/A'))); ?></span>
                            <?php endif; ?>

                            <?php if(isset($address['address'])): ?>
                                <?php if(data_get($address, 'latitude', null) && data_get($address, 'longitude', null)): ?>
                                    <a target="_blank" class="d-flex align-items-center base--clr fs-12"
                                        href="http://maps.google.com/maps?z=12&t=m&q=loc:<?php echo e($address['latitude']); ?>+<?php echo e($address['longitude']); ?>">
                                        <i class="tio-poi color-222324CC"></i><?php echo e($address['address']); ?>

                                    </a>
                                <?php else: ?>
                                    <i class="tio-poi color-222324CC"></i><?php echo e($address['address']); ?>

                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                    <?php endif; ?>
                    <?php endif; ?>
                    <!-- Polish Version-->
                    <?php if($order->receiver_details): ?>
                    <hr>
                    <?php ($receiver_details = $order->receiver_details); ?>
                    <h5 class="card-title mb-10px">
                        <span class="card-header-icon">
                            <i class="tio-user"></i>
                        </span>
                        <span><?php echo e(translate('messages.receiver_info')); ?></span>
                    </h5>
                    <?php if(isset($receiver_details)): ?>
                        <span class="delivery--information-single __bg-FAFAFA p-10px mb-10px rounded">
                            <span class="name"><?php echo e(translate('messages.name')); ?></span>
                            <span class="info"><?php echo e($receiver_details['contact_person_name']); ?></span>
                            <span class="name"><?php echo e(translate('messages.contact')); ?></span>
                            <a class="deco-none info d-flex" href="tel:<?php echo e($receiver_details['contact_person_number']); ?>">
                                <?php echo e($receiver_details['contact_person_number']); ?></a>
                            <?php if(data_get($receiver_details, 'floor') != ''): ?>
                                <span class="name"><?php echo e(translate('Floor')); ?></span> <span
                                    class="info"><?php echo e(data_get($receiver_details, 'floor', translate('messages.N/A'))); ?></span>
                            <?php endif; ?>
                            <?php if(data_get($receiver_details, 'house') != ''): ?>
                                <span class="name"><?php echo e(translate('House')); ?></span> <span
                                    class="info"><?php echo e(data_get($receiver_details, 'house', translate('messages.N/A'))); ?></span>
                            <?php endif; ?>

                            <?php if(data_get($receiver_details, 'road') != ''): ?>
                                <span class="name"><?php echo e(translate('Road')); ?></span> <span
                                    class="info"><?php echo e(data_get($receiver_details, 'road', translate('messages.N/A'))); ?></span>
                            <?php endif; ?>

                    <?php endif; ?>
                        <?php if(isset($receiver_details['address'])): ?>
                            <?php if(isset($receiver_details['latitude']) && isset($receiver_details['longitude'])): ?>
                                <a class="base--clr fs-12 d-flex" target="_blank"
                                    href="http://maps.google.com/maps?z=12&t=m&q=loc:<?php echo e($receiver_details['latitude']); ?>+<?php echo e($receiver_details['longitude']); ?>">
                                    <i class="tio-poi color-222324CC"></i><?php echo e($receiver_details['address']); ?>

                                </a>
                            <?php else: ?>
                                <i class="tio-poi color-222324CC"></i><?php echo e($receiver_details['address']); ?>

                            <?php endif; ?>


                        <?php endif; ?>
                    </span>
                    <?php endif; ?>
                </div>
            </div>





            <!-- Customer Card -->
            <?php ($data = isset($order->order_proof) ? json_decode($order->order_proof, true) : []); ?>
            <?php if(in_array($order->order_status, ['handover', 'delivered', 'picked_up']) || ($data != null && count($data) > 0)): ?>
            <!-- order proof -->
            <div class="card mb-2 mt-2">
                <div class="card-header border-0 mb-10px text-center pb-0">
                    <h5 class="m-0 fs-14 color-222324CC"><?php echo e(translate('messages.delivery_proof')); ?> </h5>
                    <?php if(in_array($order->order_status, ['handover', 'delivered', 'picked_up'])): ?>
                        <button class="btn btn-outline-primary btn-sm px-3 py-1 fs-14" data-toggle="modal"
                            data-target=".order-proof-modal"> <?php echo e(translate('messages.add')); ?> </button>
                    <?php endif; ?>
                </div>
                <div class="card-body pt-0">
                    <?php if($data): ?>
                    <div class="__bg-FAFAFA p-10px rounded">
                        <label class="input-label" for="order_proof"><?php echo e(translate('messages.image')); ?> :
                        </label>
                        <div class="row g-1">
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php ($img = is_array($img) ? $img : ['img' => $img, 'storage' => 'public']); ?>
                            <div class="col-3">
                                <img class="img__aspect-1 rounded border w-100 onerror-image" data-toggle="modal"
                                    data-target="#imagemodal<?php echo e($key); ?>"
                                    data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                                    src="<?php echo e(\App\CentralLogics\Helpers::get_full_url('order', $img['img'], $img['storage'])); ?>">
                            </div>
                            <div class="modal fade" id="imagemodal<?php echo e($key); ?>" tabindex="-1" role="dialog"
                                aria-labelledby="order_proof_<?php echo e($key); ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="order_proof_<?php echo e($key); ?>">
                                                <?php echo e(translate('order_proof_image')); ?>

                                            </h4>
                                            <button type="button" class="close" data-dismiss="modal"><span
                                                    aria-hidden="true">&times;</span><span
                                                    class="sr-only"><?php echo e(translate('messages.cancel')); ?></span></button>
                                        </div>
                                        <div class="modal-body">
                                            <img src="<?php echo e(\App\CentralLogics\Helpers::get_full_url('order', $img['img'], $img['storage'])); ?>"
                                                class="initial--22 w-100">
                                        </div>
                                        <?php ($storage = $img['storage'] ?? 'public'); ?>
                                        <?php ($file = $storage == 's3' ? base64_encode('order/' . $img['img']) : base64_encode('public/order/' . $img['img'])); ?>
                                        <div class="modal-footer">
                                            <a class="btn btn-primary"
                                                href="<?php echo e(route('admin.file-manager.download', [$file, $storage])); ?>"><i
                                                    class="tio-download"></i>
                                                <?php echo e(translate('messages.download')); ?>

                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>


        </div>
    </div>
    <!-- End Row -->
</div>

<!-- Modal -->
<div class="modal fade" id="refund_cancelation_note" tabindex="-1" role="dialog"
    aria-labelledby="refund_cancelation_note_l" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="refund_cancelation_note_l">
                    <?php echo e(translate('messages.add_Order Rejection_Note')); ?>

                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo e(route('admin.refund.order_refund_rejection')); ?>" method="post">
                    <?php echo method_field('PUT'); ?>
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="order_id" value="<?php echo e($order->id); ?>">
                    <input type="text" class="form-control" name="admin_note" value="<?php echo e(old('admin_note')); ?>"
                        placeholder="Fake Order">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(translate('close')); ?></button>
                <button type="submit" class="btn btn-danger"><?php echo e(translate('messages.Confirm_Order Rejection')); ?>

                </button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="mySmallModalLabel"><?php echo e(translate('messages.reference_code_add')); ?>

                </h5>
                <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal"
                    aria-label="Close">
                    <i class="tio-clear tio-lg"></i>
                </button>
            </div>

            <form action="<?php echo e(route('admin.order.add-payment-ref-code', [$order['id']])); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <!-- Input Group -->
                    <div class="form-group">
                        <input type="text" name="transaction_reference" class="form-control"
                            placeholder="<?php echo e(translate('messages.Ex:')); ?> Code123" required>
                    </div>
                    <!-- End Input Group -->
                    <div class="text-right">
                        <button class="btn btn--primary"><?php echo e(translate('messages.submit')); ?></button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- End Modal -->
<!-- Modal -->
<div class="modal fade order-proof-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="mySmallModalLabel"><?php echo e(translate('messages.add_delivery_proof')); ?>

                </h5>
                <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal"
                    aria-label="Close">
                    <i class="tio-clear tio-lg"></i>
                </button>
            </div>

            <form action="<?php echo e(route('admin.order.add-order-proof', [$order['id']])); ?>" method="post"
                enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="flex-grow-1 mx-auto">
                        <div class="d-flex flex-wrap __gap-12px __new-coba" id="coba">
                            <?php ($proof = isset($order->order_proof) ? json_decode($order->order_proof, true) : 0); ?>
                            <?php if($proof): ?>

                            <?php $__currentLoopData = $proof; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php ($photo = is_array($photo) ? $photo : ['img' => $photo, 'storage' => 'public']); ?>
                            <div class="spartan_item_wrapper min-w-176px max-w-176px">
                                <img class="img--square"
                                    src="<?php echo e(\App\CentralLogics\Helpers::get_full_url('order', $photo['img'], $photo['storage'])); ?>"
                                    alt="order image">
                                <div class="pen spartan_remove_row"><i class="tio-edit"></i></div>
                                <a href="<?php echo e(route('admin.order.remove-proof-image', ['id' => $order['id'], 'name' => $photo['img']])); ?>"
                                    class="spartan_remove_row"><i class="tio-add-to-trash"></i></a>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="text-right mt-2">
                        <button class="btn btn--primary"><?php echo e(translate('messages.submit')); ?></button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Modal -->
<div id="shipping-address-modal" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalTopCoverTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-top-cover bg-dark text-center">
                <figure class="position-absolute right-0 bottom-0 left-0 mb--1">
                    <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                        viewBox="0 0 1920 100.1">
                        <path fill="#fff" d="M0,0c0,0,934.4,93.4,1920,0v100.1H0L0,0z" />
                    </svg>
                </figure>

                <div class="modal-close">
                    <button type="button" class="btn btn-icon btn-sm btn-ghost-light" data-dismiss="modal"
                        aria-label="Close">
                        <svg width="16" height="16" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                            <path fill="currentColor"
                                d="M11.5,9.5l5-5c0.2-0.2,0.2-0.6-0.1-0.9l-1-1c-0.3-0.3-0.7-0.3-0.9-0.1l-5,5l-5-5C4.3,2.3,3.9,2.4,3.6,2.6l-1,1 C2.4,3.9,2.3,4.3,2.5,4.5l5,5l-5,5c-0.2,0.2-0.2,0.6,0.1,0.9l1,1c0.3,0.3,0.7,0.3,0.9,0.1l5-5l5,5c0.2,0.2,0.6,0.2,0.9-0.1l1-1 c0.3-0.3,0.3-0.7,0.1-0.9L11.5,9.5z" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- End Header -->

            <div class="modal-top-cover-icon">
                <span class="icon icon-lg icon-light icon-circle icon-centered shadow-soft">
                    <i class="tio-location-search"></i>
                </span>
            </div>

            <?php if(isset($address)): ?>
                <form action="<?php echo e(route('admin.order.update-shipping', [$order['id']])); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="requiredLabel" class="col-md-2 col-form-label input-label text-md-right">
                                <?php echo e(translate('messages.type')); ?>

                            </label>
                            <div class="col-md-10 js-form-message">
                                <input type="text" class="form-control" name="address_type"
                                    value="<?php echo e($address['address_type']); ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="requiredLabel" class="col-md-2 col-form-label input-label text-md-right">
                                <?php echo e(translate('messages.contact')); ?>

                            </label>
                            <div class="col-md-10 js-form-message">
                                <input type="text" class="form-control" name="contact_person_number"
                                    value="<?php echo e($address['contact_person_number']); ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="requiredLabel" class="col-md-2 col-form-label input-label text-md-right">
                                <?php echo e(translate('messages.name')); ?>

                            </label>
                            <div class="col-md-10 js-form-message">
                                <input type="text" class="form-control" name="contact_person_name"
                                    value="<?php echo e($address['contact_person_name']); ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="requiredLabel" class="col-md-2 col-form-label input-label text-md-right">
                                <?php echo e(translate('House')); ?>

                            </label>
                            <div class="col-md-10 js-form-message">
                                <input type="text" class="form-control" name="house"
                                    value="<?php echo e(isset($address['house']) ? $address['house'] : ''); ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="requiredLabel" class="col-md-2 col-form-label input-label text-md-right">
                                <?php echo e(translate('Floor')); ?>

                            </label>
                            <div class="col-md-10 js-form-message">
                                <input type="text" class="form-control" name="floor"
                                    value="<?php echo e(isset($address['floor']) ? $address['floor'] : ''); ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="requiredLabel" class="col-md-2 col-form-label input-label text-md-right">
                                <?php echo e(translate('Road')); ?>

                            </label>
                            <div class="col-md-10 js-form-message">
                                <input type="text" class="form-control" name="road"
                                    value="<?php echo e(isset($address['road']) ? $address['road'] : ''); ?>">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="requiredLabel" class="col-md-2 col-form-label input-label text-md-right">
                                <?php echo e(translate('messages.address')); ?>

                            </label>
                            <div class="col-md-10 js-form-message">
                                <input type="text" class="form-control" name="address" value="<?php echo e($address['address']); ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="requiredLabel" class="col-md-2 col-form-label input-label text-md-right">
                                <?php echo e(translate('messages.latitude')); ?>

                            </label>
                            <div class="col-md-4 js-form-message">
                                <input type="text" class="form-control" name="latitude" id="latitude"
                                    value="<?php echo e($address['latitude']); ?>">
                            </div>
                            <label for="requiredLabel" class="col-md-2 col-form-label input-label text-md-right">
                                <?php echo e(translate('messages.longitude')); ?>

                            </label>
                            <div class="col-md-4 js-form-message">
                                <input type="text" class="form-control" name="longitude" id="longitude"
                                    value="<?php echo e($address['longitude']); ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <input id="pac-input" class="controls rounded initial-8"
                                title="<?php echo e(translate('messages.search_your_location_here')); ?>" type="text"
                                placeholder="<?php echo e(translate('messages.search_here')); ?>" />
                            <div class="mb-2 h-200px" id="map"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--reset"
                            data-dismiss="modal"><?php echo e(translate('messages.close')); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.save_changes')); ?></button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- End Modal -->

<!--Dm assign Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?php echo e(translate('messages.assign_deliveryman')); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5 my-2">
                        <ul class="list-group overflow-auto initial--23">
                            <?php $__currentLoopData = $deliveryMen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="list-group-item">
                                    <span class="dm_list" role='button' data-id="<?php echo e($dm['id']); ?>">
                                        <img class="avatar avatar-sm avatar-circle mr-1 onerror-image"
                                            data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
                                            src="<?php echo e($dm['image_full_url']); ?>" alt="<?php echo e($dm['name']); ?>">
                                        <?php echo e($dm['name']); ?>

                                    </span>

                                    <a class="btn btn-primary btn-xs float-right add-delivery-man"
                                        data-id="<?php echo e($dm['id']); ?>"><?php echo e(translate('messages.assign')); ?></a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <div class="col-md-7 modal_body_map">
                        <div class="location-map" id="dmassign-map">
                            <div class="initial--24" id="map_canvas"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<!--Show locations on map Modal -->
<div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-labelledby="locationModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="locationModalLabel"><?php echo e(translate('messages.location_data')); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 modal_body_map">
                        <div class="location-map" id="location-map">
                            <div class="initial--25" id="location_map_canvas"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->





<?php if($order?->offline_payments): ?>
<div class="modal fade" id="verifyViewModal" tabindex="-1" aria-labelledby="verifyViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-end  border-0">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true" class="tio-clear"></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex align-items-center flex-column gap-3 text-center">
                    <h2><?php echo e(translate('Payment_Verification')); ?>

                        <?php if($order?->offline_payments->status == 'verified'): ?>
                            <span class="badge badge-soft-success mt-3 mb-3"><?php echo e(translate('messages.verified')); ?></span>
                        <?php endif; ?>
                    </h2>
                    <p class="text-danger mb-2 mt-2">
                        <?php echo e(translate('Please_Check_&_Verify_the_payment_information_weather_it_is_correct_or_not_before_confirm_the_order.')); ?>

                    </p>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-3"><?php echo e(translate('messages.customer_information')); ?></h4>
                        <div class="d-flex flex-column gap-2">
                            <?php if($order->is_guest): ?>
                            <?php ($customer_details = json_decode($order['delivery_address'], true)); ?>

                                <div class="d-flex align-items-center gap-2">
                                    <span><?php echo e(translate('Name')); ?></span>:
                                    <span class="text-dark">
                                        <?php echo e($customer_details['contact_person_name']); ?></span>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <span><?php echo e(translate('Phone')); ?></span>:
                                    <span class="text-dark">
                                        <?php echo e($customer_details['contact_person_number']); ?></span>
                                </div>
                            <?php elseif($order->customer): ?>
                                <div class="d-flex align-items-center gap-2">
                                    <span><?php echo e(translate('Name')); ?></span>:
                                    <span class="text-dark"> <a class="text-body text-capitalize"
                                            href="<?php echo e(route('admin.customer.view', [$order['user_id']])); ?>">
                                            <?php echo e($order->customer['f_name'] . ' ' . $order->customer['l_name']); ?>

                                        </a>
                                    </span>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <span><?php echo e(translate('Phone')); ?></span>:
                                    <span class="text-dark"><?php echo e($order->customer['phone']); ?> </span>
                                </div>
                            <?php else: ?>
                            <label class="badge badge-danger"><?php echo e(translate('messages.invalid_customer_data')); ?></label>
                            <?php endif; ?>

                        </div>

                        <div class="mt-5">
                            <h4 class="mb-3"><?php echo e(translate('messages.Payment_Information')); ?></h4>
                            <div class="row g-3">
                                <?php $__currentLoopData = json_decode($order->offline_payments->payment_info); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($key != 'method_id'): ?>
                                        <div class="col-sm-6  col-lg-5">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="w-sm-25"> <?php echo e(translate($key)); ?></span>:
                                                <span class="text-dark text-break"><?php echo e($item); ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <div class="d-flex flex-column gap-2 mt-3">
                                <div class="d-flex align-items-center gap-2">
                                    <span><?php echo e(translate('Customer_Note')); ?></span>:
                                    <span
                                        class="text-dark text-break"><?php echo e($order->offline_payments?->customer_note ?? translate('messages.N/A')); ?>

                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <?php if($order?->offline_payments->status != 'verified'): ?>
                    <div class="btn--container justify-content-end mt-20">
                        <?php if($order?->offline_payments->status != 'denied'): ?>
                            <button type="button" class="btn btn--danger btn-outline-danger offline_payment_cancelation_note"
                                data-toggle="modal" data-target="#offline_payment_cancelation_note" data-id="<?php echo e($order['id']); ?>"
                                class="btn btn--reset"><?php echo e(translate('Payment_Didn’t_Recerive')); ?></button>
                        <?php elseif($order?->offline_payments->status == 'denied'): ?>
                            <button type="button"
                                data-url="<?php echo e(route('admin.order.offline_payment', ['id' => $order['id'], 'verify' => 'switched_to_cod'])); ?>"
                                data-message="<?php echo e(translate('messages.Make_the_payment_verified_for_this_order')); ?>"
                                class="btn btn-info mb-2 route-alert"><?php echo e(translate('Switched_to_COD')); ?></button>
                        <?php endif; ?>

                        <button type="button"
                            data-url="<?php echo e(route('admin.order.offline_payment', ['id' => $order['id'], 'verify' => 'yes'])); ?>"
                            data-message="<?php echo e(translate('messages.Make_the_payment_verified_for_this_order')); ?>"
                            class="btn btn--primary mb-2 route-alert"><?php echo e(translate('Yes,_Payment_Received')); ?></button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="offline_payment_cancelation_note" tabindex="-1" role="dialog"
    aria-labelledby="offline_payment_cancelation_note_l" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="offline_payment_cancelation_note_l">
                    <?php echo e(translate('messages.Add_Offline_Payment_Rejection_Note')); ?>

                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo e(route('admin.order.offline_payment')); ?>" method="get">
                    <input type="hidden" name="id" value="<?php echo e($order->id); ?>">
                    <input type="text" required class="form-control" name="note" value="<?php echo e(old('note')); ?>"
                        placeholder="<?php echo e(translate('transaction_id_mismatched')); ?>">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(translate('close')); ?></button>
                <button type="submit"
                    class="btn btn--danger btn-outline-danger"><?php echo e(translate('messages.Confirm_Rejection')); ?>

                </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<!-- End Modal -->
<div class="modal fade" id="manually_parcel_amount_refund" tabindex="-1" role="dialog"
    aria-labelledby="offline_payment_cancelation_note_l" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">
                    <?php echo e(translate('Parcel_Amount_Refund')); ?>

                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo e(route('admin.order.parcelRefund')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('put'); ?>
                    <input type="hidden" name="id" value="<?php echo e($order->id); ?>">
                    <input type="number" min="0" step="0.0001" max="<?php echo e(round($order->order_amount, 2)); ?>" required
                        class="form-control" name="refund_amount" value="<?php echo e($order->order_amount); ?>">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(translate('close')); ?></button>
                <button type="submit"
                    class="btn btn--danger btn-outline-danger"><?php echo e(translate('messages.Confirm_Refund')); ?>

                </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Parcel cancellation Offcanvas -->
<div id="percel-cancellation_offcanvas" class="custom-offcanvas d-flex flex-column justify-content-between">
    <form action="<?php echo e(route('admin.order.CancelParcel')); ?>" method="post">
        <div>
            <?php echo method_field('put'); ?>
            <?php echo csrf_field(); ?>
            <input type="hidden" name="order_id" value="<?php echo e($order->id); ?>">
            <div
                class="custom-offcanvas-header bg--secondary d-flex justify-content-between align-items-center px-3 py-3">
                <h3 class="mb-0"><?php echo e(translate('messages.Parcel cancellation')); ?></h2>
                    <button type="button"
                        class="btn-close w-25px h-25px border rounded-circle d-center bg--secondary text-dark offcanvas-close fz-15px p-0"
                        aria-label="Close">&times;</button>
            </div>
            <div class="custom-offcanvas-body p-20">
                <div class="mb-20">
                    <label for="" class="text-title fs-14 mb-2">
                        <?php echo e(translate('Delivery Cancelled From')); ?> <span class="text-danger">*</span>
                    </label>
                    <div class="d-flex align-items-center gap-4 border rounded py-2 px-3">
                        <div class="custom-control custom-radio w-100">
                            <input type="radio"
                                data-cancellation_type="<?php echo e(in_array($order->order_status, ['picked_up', 'delivered']) ? 'after_pickup' : 'before_pickup'); ?>"
                                data-url="<?php echo e(route('admin.order.parcelCancellationReason')); ?>" id="customer_er"
                                name="delivery_cancelled_by" class="custom-control-input" value="customer" checked>
                            <label class="custom-control-label text-capitalize"
                                for="customer_er"><?php echo e(translate('messages.Customer')); ?></label>
                        </div>
                        <div class="custom-control custom-radio w-100">
                            <input type="radio" id="delivery"
                                data-cancellation_type="<?php echo e(in_array($order->order_status, ['picked_up', 'delivered']) ? 'after_pickup' : 'before_pickup'); ?>"
                                data-url="<?php echo e(route('admin.order.parcelCancellationReason')); ?>"
                                name="delivery_cancelled_by" class="custom-control-input" value="deliveryman">
                            <label class="custom-control-label text-capitalize"
                                for="delivery"><?php echo e(translate('messages.Deliveryman')); ?></label>
                        </div>
                    </div>
                </div>
                <div class="mb-20 pb-2">
                    <h4 class="mb-10px"><?php echo e(translate('messages.Please select cancellation reason')); ?></h4>
                    <div id="data-view"> </div>
                </div>
                <div>
                    <h4 class="mb-10px"><?php echo e(translate('Comment')); ?></h4>
                    <textarea name="note" data-target="#char-count" class="form-control char-counter" maxlength="100"
                        placeholder="<?php echo e(translate('messages.Type here your cancel reason...')); ?>" rows="3"></textarea>
                    <span id="char-count" class="text-right color-A7A7A7 d-block mt-1">0/100</span>
                </div>
            </div>
        </div>
        <div class="offcanvas-footer p-3 d-flex align-items-center justify-content-center gap-3">
            <button type="button"
                class="btn w-100 btn--reset offcanvas-close"><?php echo e(translate('messages.Continue Delivery')); ?></button>
            <button type="submit" class="btn w-100 btn--primary"><?php echo e(translate('messages.Submit')); ?></button>
        </div>
    </form>
</div>
<div id="offcanvasOverlay" class="offcanvas-overlay"></div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(\App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value); ?>&libraries=places,marker&v=3.61">
        </script>
    <script>
        $(document).on('click', 'input[name="delivery_cancelled_by"], .trigger-reason', function () {
            let $input;

            if ($(this).is('input[name="delivery_cancelled_by"]')) {
                $input = $(this);
            } else {
                $input = $('input[name="delivery_cancelled_by"]:checked');
            }

            if ($input.length) {
                let type = $input.val();
                let url = $input.data('url');
                let cancellation_type = $input.data('cancellation_type');
                fetch_data(type, url, cancellation_type);
            }
        });

        function fetch_data(type, url, cancellation_type) {
            $.ajax({
                url: url,
                type: "get",
                data: {
                    user_type: type,
                    cancellation_type: cancellation_type

                },
                beforeSend: function () {
                    $('#data-view').empty();
                    $('#loading').show()
                },
                success: function (data) {
                    $("#data-view").append(data.view);
                },
                complete: function () {
                    $('#loading').hide()
                }
            })
        }

        $('.js-select2-custom').each(function () {
            var select2 = $.HSCore.components.HSSelect2.init($(this));
        });
        initCharCounter();

        $('.add-delivery-man').on('click', function () {
            id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: '<?php echo e(url('/')); ?>/admin/order/add-delivery-man/<?php echo e($order['id']); ?>/' + id,
                success: function (data) {
                    location.reload();
                    console.log(data)
                    toastr.success('Successfully added', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                error: function (response) {
                    console.log(response);
                    toastr.error(response.responseJSON.message, {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        })

        function last_location_view() {
            toastr.warning('Only available when order is out for delivery!', {
                CloseButton: true,
                ProgressBar: true
            });
        }

        var deliveryMan = <?php echo json_encode($deliveryMen); ?>;
        var map = null;
        const mapId = "<?php echo e(\App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value); ?>"
        var myLatlng = new google.maps.LatLng(<?php echo e($address['latitude']); ?>, <?php echo e($address['longitude']); ?>);
        var dmbounds = new google.maps.LatLngBounds(null);
        var locationbounds = new google.maps.LatLngBounds(null);
        var dmMarkers = [];
        dmbounds.extend(myLatlng);
        locationbounds.extend(myLatlng);
        var myOptions = {
            center: myLatlng,
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapId: mapId,

            panControl: true,
            mapTypeControl: false,
            panControlOptions: {
                position: google.maps.ControlPosition.RIGHT_CENTER
            },
            zoomControl: true,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.LARGE,
                position: google.maps.ControlPosition.RIGHT_CENTER
            },
            scaleControl: false,
            streetViewControl: false,
            streetViewControlOptions: {
                position: google.maps.ControlPosition.RIGHT_CENTER
            }
        };

        function initializeGMap() {

            map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

            var infowindow = new google.maps.InfoWindow();

            map.fitBounds(dmbounds);
            for (var i = 0; i < deliveryMan.length; i++) {
                if (deliveryMan[i].lat) {
                    // var contentString = "<div style='float:left'><img style='max-height:40px;wide:auto;' src='<?php echo e(asset('storage/app/public/delivery-man')); ?>/"+deliveryMan[i].image+"'></div><div style='float:right; padding: 10px;'><b>"+deliveryMan[i].name+"</b><br/> "+deliveryMan[i].location+"</div>";
                    var point = new google.maps.LatLng(deliveryMan[i].lat, deliveryMan[i].lng);
                    dmbounds.extend(point);
                    map.fitBounds(dmbounds);
                    var activeIconContent = document.createElement("img");
                    activeIconContent.src = "<?php echo e(asset('public/assets/admin/img/delivery_boy_map.png')); ?>";
                    activeIconContent.alt = "Active DM";
                    activeIconContent.style.width = '100%';
                    activeIconContent.style.height = '100%';
                    activeIconContent.style.borderRadius = '50%';
                    var marker = new google.maps.marker.AdvancedMarkerElement({
                        position: point,
                        map: map,
                        title: deliveryMan[i].location,
                        content: activeIconContent
                    });
                    dmMarkers[deliveryMan[i].id] = marker;
                    google.maps.event.addListener(marker, 'click', (function (marker, i) {
                        return function () {
                            infowindow.setContent(
                                "<div style='float:left'><img style='max-height:40px;wide:auto;' src='" +
                                deliveryMan[i].image_link +
                                "'></div><div style='float:right; padding: 10px;'><b>" + deliveryMan[i]
                                    .name + "</b><br/> " + deliveryMan[i].location + "</div>");
                            infowindow.open(map, marker);
                        }
                    })(marker, i));
                }

            };
        }

        function initMap() {
            let map = new google.maps.Map(document.getElementById("map"), {
                zoom: 13,
                center: {
                    lat: <?php echo e(isset($order->store) ? $order->store->latitude : '23.757989'); ?>,
                    lng: <?php echo e(isset($order->store) ? $order->store->longitude : '90.360587'); ?>

                    },
                mapId: mapId,
            });

            let zonePolygon = null;

            //get current location block
            let infoWindow = new google.maps.InfoWindow();
            // Try HTML5 geolocation.
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        myLatlng = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,
                        };
                        infoWindow.setPosition(myLatlng);
                        infoWindow.setContent("Location found.");
                        infoWindow.open(map);
                        map.setCenter(myLatlng);
                    },
                    () => {
                        handleLocationError(true, infoWindow, map.getCenter());
                    }
                );
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWindow, map.getCenter());
            }
            //-----end block------
            const input = document.getElementById("pac-input");
            const searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);
            let markers = [];
            const bounds = new google.maps.LatLngBounds();
            searchBox.addListener("places_changed", () => {
                const places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }
                // Clear out the old markers.
                markers.forEach((marker) => {
                    marker.setMap(null);
                });
                markers = [];
                // For each place, get the icon, name and location.
                places.forEach((place) => {
                    if (!place.geometry || !place.geometry.location) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    console.log(place.geometry.location);
                    if (!google.maps.geometry.poly.containsLocation(
                        place.geometry.location,
                        zonePolygon
                    )) {
                        toastr.error('<?php echo e(translate('messages.out_of_coverage')); ?>', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        return false;
                    }

                    document.getElementById('latitude').value = place.geometry.location.lat();
                    document.getElementById('longitude').value = place.geometry.location.lng();

                    // Create a marker for each place.
                    markers.push(
                        new google.maps.marker.AdvancedMarkerElement({
                            map,
                            title: place.name,
                            position: place.geometry.location,
                        })
                    );

                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
            });


        }

        $(document).ready(function () {

            // Re-init map before show modal
            $('#myModal').on('shown.bs.modal', function (event) {
                initMap();
                var button = $(event.relatedTarget);
                $("#dmassign-map").css("width", "100%");
                $("#map_canvas").css("width", "100%");
            });

            // Trigger map resize event after modal shown
            $('#myModal').on('shown.bs.modal', function () {
                initializeGMap();
                google.maps.event.trigger(map, "resize");
                map.setCenter(myLatlng);
            });

            // Address change modal modal shown
            $('#shipping-address-modal').on('shown.bs.modal', function () {
                initMap();
                // google.maps.event.trigger(map, "resize");
                // map.setCenter(myLatlng);
            });


            function initializegLocationMap() {
                map = new google.maps.Map(document.getElementById("location_map_canvas"), myOptions);

                var infowindow = new google.maps.InfoWindow();

                <?php if($order->customer && isset($address)): ?>
                var activeIconContent = document.createElement("img");
                activeIconContent.src = "<?php echo e(asset('public/assets/admin/img/customer_location.png')); ?>";
                activeIconContent.alt = "Active DM";
                activeIconContent.style.width = '100%'; 
                activeIconContent.style.height = '100%'; 
                activeIconContent.style.borderRadius = '50%'; 
                    var marker = new google.maps.marker.AdvancedMarkerElement({
                        position: new google.maps.LatLng(<?php echo e($address['latitude']); ?>,
                                    <?php echo e($address['longitude']); ?>),
                        map: map,
                        title: "<?php echo e($order->customer->f_name); ?> <?php echo e($order->customer->l_name); ?>",
                        content: activeIconContent
                    });

                    google.maps.event.addListener(marker, 'click', (function (marker) {
                        return function () {
                            infowindow.setContent(
                                "<div style='float:left'><img style='max-height:40px;wide:auto;' src='<?php echo e($order?->customer?->image_full_url ?? asset('public/assets/admin/img/160x160/img1.jpg')); ?>'></div><div style='float:right; padding: 10px;'><b><?php echo e($order->customer->f_name); ?> <?php echo e($order->customer->l_name); ?></b><br /><?php echo e($address['address']); ?></div>"
                            );
                            infowindow.open(map, marker);
                        }
                    })(marker));
                    locationbounds.extend(marker.position);
                <?php endif; ?>
                    <?php if($order->delivery_man && $order->dm_last_location): ?>
                    var activeIconContent = document.createElement("img");
                activeIconContent.src = "<?php echo e(asset('public/assets/admin/img/delivery_boy_map.png')); ?>";
                activeIconContent.alt = "Active DM";
                activeIconContent.style.width = '100%'; 
                activeIconContent.style.height = '100%'; 
                activeIconContent.style.borderRadius = '50%'; 
                        var dmmarker = new google.maps.marker.AdvancedMarkerElement({
                            position: new google.maps.LatLng(<?php echo e($order->dm_last_location['latitude']); ?>,
                                        <?php echo e($order->dm_last_location['longitude']); ?>),
                            map: map,
                            title: "<?php echo e($order->delivery_man->f_name); ?> <?php echo e($order->delivery_man->l_name); ?>",
                            content: activeIconContent
                        });

                        google.maps.event.addListener(dmmarker, 'click', (function (dmmarker) {
                            return function () {
                                infowindow.setContent(
                                    "<div style='float:left'><img style='max-height:40px;wide:auto;' src='<?php echo e($order?->delivery_man?->image_full_url ?? asset('public/assets/admin/img/160x160/img1.jpg')); ?>'></div> <div style='float:right; padding: 10px;'><b><?php echo e($order->delivery_man->f_name); ?> <?php echo e($order->delivery_man->l_name); ?></b><br /> <?php echo e($order->dm_last_location['location']); ?></div>"
                                );
                                infowindow.open(map, dmmarker);
                            }
                        })(dmmarker));
                        locationbounds.extend(dmmarker.position);
                    <?php endif; ?>


                    <?php if(isset($receiver_details)): ?>
                        var Receivermarker = new google.maps.marker.AdvancedMarkerElement({
                            position: new google.maps.LatLng(<?php echo e($receiver_details['latitude']); ?>,
                                        <?php echo e($receiver_details['longitude']); ?>),
                            map: map,
                            title: "<?php echo e(Str::limit($receiver_details['contact_person_name'], 15, '...')); ?>",
                            // icon: "<?php echo e(asset('public/assets/admin/img/restaurant_map.png')); ?>"
                        });

                        google.maps.event.addListener(Receivermarker, 'click', (function (Receivermarker) {
                            return function () {
                                infowindow.open(map, Receivermarker);
                            }
                        })(Receivermarker));
                        locationbounds.extend(Receivermarker.position);
                    <?php endif; ?>

                google.maps.event.addListenerOnce(map, 'idle', function () {
                    map.fitBounds(locationbounds);
                });
            }

            // Re-init map before show modal
            $('#locationModal').on('shown.bs.modal', function (event) {
                initializegLocationMap();
            });


            $('.dm_list').on('click', function () {
                var id = $(this).data('id');
                map.panTo(dmMarkers[id].position);
                map.setZoom(13);
                dmMarkers[id].setAnimation(google.maps.Animation.BOUNCE);
                window.setTimeout(() => {
                    dmMarkers[id].setAnimation(null);
                }, 3);
            });
        })
    </script>

    <script src="<?php echo e(asset('public/assets/admin/js/spartan-multi-image-picker.js')); ?>"></script>
    <script type="text/javascript">
        $(function () {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'order_proof[]',
                maxCount: 6 -
                        <?php echo e($order->order_proof && is_array($order->order_proof) ? count(json_decode($order->order_proof)) : 0); ?>,
                rowHeight: '176px !important',
                groupClassName: 'spartan_item_wrapper min-w-176px max-w-176px',
                maxFileSize: '',
                placeholderImage: {
                    image: "<?php echo e(asset('public/assets/admin/img/upload-img.png')); ?>",
                    width: '176px'
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error(
                        "<?php echo e(translate('messages.please_only_input_png_or_jpg_type_file')); ?>", {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error("<?php echo e(translate('messages.file_size_too_big')); ?>", {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/order/parcel-order-view.blade.php ENDPATH**/ ?>