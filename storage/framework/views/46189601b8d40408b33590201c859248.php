<table id="columnSearchDatatable"
        class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
        data-hs-datatables-options='{
        "order": [],
        "orderCellsTop": true,

        "entries": "#datatableEntries",
        "isResponsive": false,
        "isShowPaging": false,
        "pagination": "datatablePagination"
        }'>
    <thead class="thead-light">
        <tr>
            <th class="border-0"><?php echo e(translate('sl')); ?></th>
            <th class="border-0"><?php echo e(translate('messages.bonus_title')); ?></th>
            <th class="border-0"><?php echo e(translate('messages.bonus_info')); ?></th>
            <th class="border-0"><?php echo e(translate('messages.bonus_amount')); ?></th>
            <th class="border-0"><?php echo e(translate('messages.started_on')); ?></th>
            <th class="border-0"><?php echo e(translate('messages.expires_on')); ?></th>
            <th class="border-0"><?php echo e(translate('messages.status')); ?></th>
            <th class="border-0 text-center"><?php echo e(translate('messages.action')); ?></th>
        </tr>
    </thead>

    <tbody id="set-rows">
        <?php $__currentLoopData = $bonuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$bonus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($key+1); ?></td>
            <td>
<span class="d-block font-size-sm text-body">
                                    <?php echo e(Str::limit($bonus['title'],25,'...')); ?>

                                    </span>
            </td>
            <td><?php echo e(translate('messages.minimum_add_amount')); ?> -    <?php echo e(\App\CentralLogics\Helpers::format_currency($bonus['minimum_add_amount'])); ?> <br>
                <?php echo e(translate('messages.maximum_bonus')); ?> - <?php echo e(\App\CentralLogics\Helpers::format_currency($bonus['maximum_bonus_amount'])); ?></td>
            <td><?php echo e($bonus->bonus_type == 'amount'?\App\CentralLogics\Helpers::format_currency($bonus['bonus_amount']): $bonus['bonus_amount'].' (%)'); ?></td>
            <td><?php echo e(\Carbon\Carbon::parse($bonus->start_date)->format('d M Y')); ?></td>
            <td><?php echo e(\Carbon\Carbon::parse($bonus->end_date)->format('d M Y')); ?></td>
            <td>
                <label class="toggle-switch toggle-switch-sm" for="bonusCheckbox<?php echo e($bonus->id); ?>">
                    <input type="checkbox" data-url="<?php echo e(route('admin.users.customer.wallet.bonus.status',[$bonus['id'],$bonus->status?0:1])); ?>" class="toggle-switch-input redirect-url" id="bonusCheckbox<?php echo e($bonus->id); ?>" <?php echo e($bonus->status?'checked':''); ?>>
                    <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                </label>
            </td>
            <td>
                <div class="btn--container justify-content-center">

                    <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route('admin.users.customer.wallet.bonus.update',[$bonus['id']])); ?>" title="<?php echo e(translate('messages.edit_bonus')); ?>"><i class="tio-edit"></i>
                    </a>
                    <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:" data-id="bonus-<?php echo e($bonus['id']); ?>" data-message="<?php echo e(translate('Want to delete this bonus ?')); ?>" title="<?php echo e(translate('messages.delete_bonus')); ?>"><i class="tio-delete-outlined"></i>
                    </a>
                    <form action="<?php echo e(route('admin.users.customer.wallet.bonus.delete',[$bonus['id']])); ?>"
                          method="post" id="bonus-<?php echo e($bonus['id']); ?>">
                        <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                    </form>
                </div>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<hr>
<table>
    <tfoot>

    </tfoot>
</table>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/wallet-bonus/partials/_table.blade.php ENDPATH**/ ?>