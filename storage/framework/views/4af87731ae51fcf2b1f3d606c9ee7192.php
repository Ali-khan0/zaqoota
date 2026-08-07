<div>
    <div class="table-responsive">
        <table id="datatable" class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
            <thead class="thead-light">
                <tr>
                    <th class="border-0"><?php echo e(translate('messages.sl#')); ?></th>
                    <th class="border-0"><?php echo e(translate('messages.created_at')); ?></th>
                    <th class="border-0"><?php echo e(translate('messages.amount')); ?></th>
                    <th class="border-0"><?php echo e(translate('messages.status')); ?></th>
                    <th class="border-0"><?php echo e(translate('messages.action')); ?></th>
                </tr>
            </thead>
            <tbody>
            <?php ($withdraw_transaction = \App\Models\WithdrawRequest::where('vendor_id', $store->vendor->id)->paginate(25)); ?>
            <?php $__currentLoopData = $withdraw_transaction; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$wt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td scope="row"><?php echo e($k+$withdraw_transaction->firstItem()); ?></td>
                    <td><?php echo e(date('Y-m-d '.config('timeformat'), strtotime($wt->created_at))); ?></td>
                    <td><?php echo e(\App\CentralLogics\Helpers::format_currency($wt->amount)); ?></td>
                    <td>
                        <?php if($wt->approved==0): ?>
                            <label class="badge badge-primary"><?php echo e(translate('messages.pending')); ?></label>
                        <?php elseif($wt->approved==1): ?>
                            <label class="badge badge-success"><?php echo e(translate('messages.approved')); ?></label>
                        <?php else: ?>
                            <label class="badge badge-danger"><?php echo e(translate('messages.denied')); ?></label>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo e(route('admin.store.withdraw_view',[$wt['id'],$store->vendor['id']])); ?>"
                            class="btn btn--warning action-btn btn-outline-warning"><i class="tio-visible"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php if(count($withdraw_transaction) !== 0): ?>
<hr>
<?php endif; ?>
<div class="page-area">
    <?php echo $withdraw_transaction->links(); ?>

</div>
<?php if(count($withdraw_transaction) === 0): ?>
<div class="empty--data">
    <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
    <h5>
        <?php echo e(translate('no_data_found')); ?>

    </h5>
</div>
<?php endif; ?>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/provider/details/partials/withdraw_transaction.blade.php ENDPATH**/ ?>