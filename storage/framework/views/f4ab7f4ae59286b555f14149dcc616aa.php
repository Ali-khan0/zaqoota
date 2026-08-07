<div class="row">
    <div class="col-lg-12 text-center "><h1 ><?php echo e(translate('order_transactions_report')); ?></h1></div>
    <div class="col-lg-12">



    <table>
        <thead>
            <tr>
                <th><?php echo e(translate('Search_Criteria')); ?></th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('module' )); ?> - <?php echo e($data['module']?translate($data['module']):translate('all')); ?>

                    <br>
                    <?php echo e(translate('zone' )); ?> - <?php echo e($data['zone']??translate('all')); ?>

                    <br>
                    <?php echo e(translate('store' )); ?> - <?php echo e($data['store']??translate('all')); ?>

                    <?php if($data['from']): ?>
                    <br>
                    <?php echo e(translate('from' )); ?> - <?php echo e($data['from']?Carbon\Carbon::parse($data['from'])->format('d M Y'):''); ?>

                    <?php endif; ?>
                    <?php if($data['to']): ?>
                    <br>
                    <?php echo e(translate('to' )); ?> - <?php echo e($data['to']?Carbon\Carbon::parse($data['to'])->format('d M Y'):''); ?>

                    <?php endif; ?>
                    <br>
                    <?php echo e(translate('filter')); ?>- <?php echo e(translate($data['filter'])); ?>

                    <br>
                    <?php echo e(translate('Search_Bar_Content')); ?>- <?php echo e($data['search'] ??translate('N/A')); ?>


                </th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
                </tr>
            <tr>
                <th><?php echo e(translate('Transaction_Analytics')); ?></th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('Completed_Transactions')); ?>- <?php echo e($data['delivered'] ??translate('N/A')); ?>

                    <br>
                    <?php echo e(translate('Refunded_Transactions')); ?>- <?php echo e($data['canceled'] ??translate('N/A')); ?>

                </th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th><?php echo e(translate('Earning_Analytics')); ?></th>
                <th></th>
                <th></th>
                <th>
                    <?php echo e(translate('Admin_Earnings')); ?> - <?php echo e($data['admin_earned'] ??translate('N/A')); ?>

                    <br>
                    <?php echo e(translate('Store_Earnings')); ?> - <?php echo e($data['store_earned'] ??translate('N/A')); ?>

                    <br>
                    <?php echo e(translate('Delivery_Man_Earnings')); ?> - <?php echo e($data['deliveryman_earned'] ??translate('N/A')); ?>

                </th>
                <th> </th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        <tr>
            <th><?php echo e(translate('sl')); ?></th>
            <th><?php echo e(translate('messages.order_id')); ?></th>
            <th><?php echo e(translate('messages.store')); ?></th>
            <th><?php echo e(translate('messages.customer_name')); ?></th>
            <th><?php echo e(translate('messages.total_item_amount')); ?></th>
            <th><?php echo e(translate('messages.item_discount')); ?></th>
            <th><?php echo e(translate('messages.coupon_discount')); ?></th>
            <th><?php echo e(translate('messages.referral_discount')); ?></th>
            <th><?php echo e(translate('messages.discounted_amount')); ?></th>
            <th><?php echo e(translate('messages.vat/tax')); ?></th>
            <th><?php echo e(translate('messages.delivery_charge')); ?></th>
            <th><?php echo e(translate('messages.order_amount')); ?></th>
            <th><?php echo e(translate('messages.admin_discount')); ?></th>
            <th><?php echo e(translate('messages.store_discount')); ?></th>
            <th><?php echo e(translate('messages.admin_commission')); ?></th>
            <th><?php echo e(\App\CentralLogics\Helpers::get_business_data('additional_charge_name')??translate('messages.additional_charge')); ?></th>
            <th><?php echo e(translate('messages.extra_packaging_amount')); ?></th>
            <th><?php echo e(translate('commision_on_delivery_charge')); ?></th>
            <th><?php echo e(translate('admin_net_income')); ?></th>
            <th><?php echo e(translate('store_net_income')); ?></th>
            <th><?php echo e(translate('messages.amount_received_by')); ?></th>
            <th><?php echo e(translate('messages.payment_method')); ?></th>
            <th><?php echo e(translate('messages.payment_status')); ?></th>
        </thead>
        <tbody>
        <?php $__currentLoopData = $data['order_transactions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $ot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($key+1); ?></td>
                <td><?php echo e($ot->order_id); ?></td>
                <td>
                    <?php if($ot->order->store): ?>
                        <?php echo e(Str::limit($ot->order->store->name,25,'...')); ?>

                    <?php else: ?>
                        <?php echo e(translate('messages.parcel_order')); ?>

                    <?php endif; ?>
                </td>
                <td>
                    <?php if($ot->order->customer): ?>
                        <?php echo e($ot->order->customer['f_name'] . ' ' . $ot->order->customer['l_name']); ?>

                    <?php else: ?>
                        <?php echo e(translate('messages.not_found')); ?>

                    <?php endif; ?>
                </td>
                
                <td><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->order['order_amount'] - $ot->additional_charge - $ot->order['dm_tips']-$ot->order['delivery_charge'] - $ot['tax'] + $ot->order['coupon_discount_amount'] + $ot->order['store_discount_amount']   +$ot->order['flash_admin_discount_amount'] + $ot->order['flash_store_discount_amount'] + $ot->order['ref_bonus_amount'] - $ot->order['extra_packaging_amount'])); ?></td>


                
                <td><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->order->details()->sum(DB::raw('discount_on_item * quantity')) + $ot->order['flash_admin_discount_amount'] +$ot->order['flash_store_discount_amount'])); ?></td>

                <td><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->order['coupon_discount_amount'])); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->order['ref_bonus_amount'])); ?></td>
                
                <td>  <?php echo e(\App\CentralLogics\Helpers::number_format_short($ot->order['coupon_discount_amount'] + $ot->order['store_discount_amount']+$ot->order['flash_store_discount_amount']+$ot->order['flash_admin_discount_amount'] +$ot->order['ref_bonus_amount'])); ?></td>

                <td><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->tax)); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->delivery_charge)); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->order_amount)); ?></td>
                
                <td><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->admin_expense)); ?></td>
                
                <td><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->discount_amount_by_store+$ot->order['flash_store_discount_amount'])); ?></td>
                
                <td><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->net_non_delivery_commission - $ot->additional_charge - $ot->order['flash_admin_discount_amount'])); ?></td>

                <td><?php echo e(\App\CentralLogics\Helpers::format_currency(($ot->additional_charge))); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::format_currency(($ot->extra_packaging_amount))); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->net_delivery_commission)); ?></td>
                
                <td><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->net_admin_commission - $ot->order['flash_admin_discount_amount'])); ?></td>
                <td><?php echo e(\App\CentralLogics\Helpers::format_currency($ot->store_amount -($ot?->order?->order_type == 'parcel' ? 0: $ot->tax))); ?></td>
                <?php if($ot->received_by == 'admin'): ?>
                    <td><?php echo e(translate('messages.admin')); ?></td>
                <?php elseif($ot->received_by == 'deliveryman'): ?>
                    <td>
                        <div><?php echo e(translate('messages.delivery_man')); ?></div>
                        <div>
                            <?php if(isset($ot->delivery_man) && $ot->delivery_man->earning == 1): ?>
                                <?php echo e(translate('messages.freelance')); ?>

                            <?php elseif(isset($ot->delivery_man) && $ot->delivery_man->earning == 0 && $ot->delivery_man->type == 'restaurant_wise'): ?>
                                <?php echo e(translate('messages.restaurant')); ?>

                            <?php elseif(isset($ot->delivery_man) && $ot->delivery_man->earning == 0 && $ot->delivery_man->type == 'zone_wise'): ?>
                                <?php echo e(translate('messages.admin')); ?>

                            <?php endif; ?>
                        </div>
                    </td>
                <?php elseif($ot->received_by == 'store'): ?>
                    <td><?php echo e(translate('messages.store')); ?></td>
                <?php endif; ?>
                <td>
                        <?php echo e(translate(str_replace('_', ' ', $ot->order['payment_method']))); ?>

                </td>
                <td>
                    <?php if($ot->status): ?>
                        <?php echo e(translate('messages.refunded')); ?>

                    <?php else: ?>
                        <?php echo e(translate('messages.completed')); ?>

                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/file-exports/transaction-report.blade.php ENDPATH**/ ?>