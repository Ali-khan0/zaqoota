<div>
    <div class="table-responsive">
        <table id="datatable"
            class="table table-thead-bordered table-align-middle card-table">
            <thead class="thead-light">
                <tr>
                    <th class="w--1 border-0"><?php echo e(translate('sl')); ?></th>
                    <th class="w--1 border-0"><?php echo e(translate('messages.Trip_id')); ?></th>
                    <th class="w--2 border-0"><?php echo e(translate('messages.total_trip_amount')); ?></th>
                    <th class="w--3 border-0"><?php echo e(translate('messages.provider_earned')); ?></th>
                    <th class="w--1 border-0"><?php echo e(translate('messages.admin_earned')); ?></th>
                    <th class="w--1 border-0"><?php echo e(translate('messages.additional_charge')); ?></th>
                    <th class="w--1 border-0"><?php echo e(translate('messages.vat/tax')); ?></th>
                </tr>
            </thead>
            <tbody>
            <?php ($digitalTransaction = \Modules\Rental\Entities\TripTransaction::where('vendor_id', $store->vendor->id)->latest()->paginate(25)); ?>
            <?php $__currentLoopData = $digitalTransaction; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td scope="row"><?php echo e($key+$digitalTransaction->firstItem()); ?></td>
                    <td><a href="<?php echo e(route('admin.rental.trip.details',$transaction->trip_id)); ?>"><?php echo e($transaction->trip_id); ?></a></td>
                    <td><?php echo e(\App\CentralLogics\Helpers::format_currency($transaction->trip_amount)); ?></td>
                    <td><?php echo e(\App\CentralLogics\Helpers::format_currency($transaction->store_amount - $transaction->tax)); ?></td>
                    <td><?php echo e(\App\CentralLogics\Helpers::format_currency($transaction->admin_commission)); ?></td>
                    <td><?php echo e(\App\CentralLogics\Helpers::format_currency($transaction->additional_charge)); ?></td>
                    <td><?php echo e(\App\CentralLogics\Helpers::format_currency($transaction->tax)); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php if(count($digitalTransaction) !== 0): ?>
<hr>
<?php endif; ?>
<div class="page-area">
    <?php echo $digitalTransaction->links(); ?>

</div>
<?php if(count($digitalTransaction) === 0): ?>
<div class="empty--data">
    <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
    <h5>
        <?php echo e(translate('no_data_found')); ?>

    </h5>
</div>
<?php endif; ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/provider/details/partials/digital_transaction.blade.php ENDPATH**/ ?>