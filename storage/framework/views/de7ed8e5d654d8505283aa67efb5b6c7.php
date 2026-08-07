<?php $__env->startSection('title',translate('messages.surge_price_list')); ?>

<?php $__env->startPush('css_or_js'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<?php if(count($zone->surge_prices) > 0 ): ?>
    <div class="content container-fluid">

        <h3 class="mb-20"><?php echo e(translate('messages.Surge_Price')); ?></h3>
        <div class="card">
            <div class="card-header py-2 border-0">
                <div class="search--button-wrapper">
                    <h5 class="card-title">
                        <?php echo e(translate('messages.Surge_Price_List')); ?><span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($surges->total()); ?></span>
                    </h5>
                    <form class="search-form">
                        <!-- Search -->
                        <div class="input-group input--group">
                            <input id="datatableSearch_" type="search" name="search" class="form-control"
                                    placeholder="<?php echo e(translate('messages.Search_Surge_Price')); ?>"  value="<?php echo e(request()?->search ?? null); ?>" aria-label="<?php echo e(translate('messages.search')); ?>" required>
                            <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                        </div>
                        <!-- End Search -->
                    </form>
                    <a href="<?php echo e(route('admin.business-settings.zone.surge-price.create',[$zone['id']])); ?>" class="btn btn--primary"><?php echo e(translate('Create Surge Price')); ?></a>
                </div>
            </div>
            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table id="columnSearchDatatable"
                        class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-0 fs-14"><?php echo e(translate('Sl')); ?></th>
                            <th class="border-0 fs-14"><?php echo e(translate('Title')); ?></th>
                            <th class="border-0 fs-14">
                            <div class="min-w-135px">
                                <?php echo e(translate('Selected Module')); ?>

                            </div>
                            </th>
                            <th class="border-0 fs-14">
                            <div class="min-w-135px">
                                <?php echo e(translate('Price Increase Rate')); ?>

                            </div>
                            </th>
                            <th class="border-0 fs-14">
                            <div class="min-w-135px">
                                <?php echo e(translate('Surge Price Schedule')); ?>

                            </div>
                            </th>
                            <th class="border-0 fs-14"><?php echo e(translate('Duration')); ?></th>
                            <th class="border-0 fs-14"><?php echo e(translate('Status')); ?></th>
                            <th class="border-0 fs-14 text-center"><?php echo e(translate('Action')); ?></th>
                        </tr>
                    </thead>

                    <tbody id="set-rows">
                    <?php $__currentLoopData = $surges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$surge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="pl-4"><?php echo e($key+$surges->firstItem()); ?></td>
                            <td><?php echo e($surge['surge_price_name']); ?></td>
                            <td>
                                <?php ($names = \App\models\Module::whereIn('id', $surge->module_ids)->pluck('module_name')->implode(', ')); ?>
                                <span class="d-block text-limit-2 max-w-220px">
                                    <?php echo e($names); ?>

                                </span>
                            </td>
                            <td>
                                <?php echo e($surge['price']); ?><?php echo e($surge['price_type'] === 'percent' ? '%' : \App\CentralLogics\Helpers::currency_symbol()); ?>

                            </td>
                            <td class="text-capitalize">
                                <?php echo e($surge['duration_type']); ?>

                            </td>
                            <td>
                                <?php if($surge->duration_type === 'daily'): ?>
                                    <span class="d-block max-w-220px min-w-176px">
                                        <span class="d-block text-title"><?php echo e(\App\CentralLogics\Helpers::time_format($surge->start_time)); ?> - <?php echo e(\App\CentralLogics\Helpers::time_format($surge->end_time)); ?></span>
                                        <span class="text-wrap">
                                            <?php echo e(\App\CentralLogics\Helpers::date_format($surge->start_date)); ?> <?php echo e(translate('to')); ?> <?php echo e(\App\CentralLogics\Helpers::date_format($surge->end_date)); ?>

                                        </span>
                                    </span>
                                <?php elseif($surge->duration_type === 'weekly'): ?>
                                    <span class="d-block max-w-220px min-w-176px">
                                        <span class="d-block text-title"><?php echo e(\App\CentralLogics\Helpers::time_format($surge->start_time)); ?> - <?php echo e(\App\CentralLogics\Helpers::time_format($surge->end_time)); ?></span>
                                        <span class="text-wrap">
                                            <?php if($surge->is_permanent): ?>
                                            <?php echo e(translate('messages.permanent')); ?>

                                            <?php else: ?>
                                            <?php echo e(\App\CentralLogics\Helpers::date_format($surge->start_date)); ?> <?php echo e(translate('to')); ?> <?php echo e(\App\CentralLogics\Helpers::date_format($surge->end_date)); ?>

                                            <?php endif; ?>
                                            <?php if($surge->weekly_days && count($surge->weekly_days) > 0): ?>
                                                <?php echo e('('.implode(', ', $surge->weekly_days).')'); ?>

                                            <?php endif; ?>
                                        </span>
                                    </span>
                                <?php elseif($surge->duration_type === 'custom'): ?>
                                    <span class="d-block max-w-220px min-w-176px">
                                        <span class="text-wrap">
                                            <?php ($customDays = $surge->custom_days); ?>
                                            <?php ($start = \Carbon\Carbon::parse(reset($customDays))); ?>
                                            <?php ($end = \Carbon\Carbon::parse(end($customDays))); ?>
                                            <?php echo e(\App\CentralLogics\Helpers::date_format($start)); ?> <?php echo e(translate('to')); ?> <?php echo e(\App\CentralLogics\Helpers::date_format($end)); ?>

                                        </span>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <label class="toggle-switch toggle-switch-sm" for="status-<?php echo e($surge['id']); ?>">
                                    <input type="checkbox" class="toggle-switch-input dynamic-checkbox"
                                            data-id="status-<?php echo e($surge['id']); ?>"
                                            data-type="status"
                                            data-image-on='<?php echo e(asset('public/assets/admin/img/status-ons.png')); ?>'
                                            data-image-off="<?php echo e(asset('public/assets/admin/img/status-ons.png')); ?>"
                                            data-title-on="<?php echo e(translate('Turn_On_The_Status?')); ?>"
                                            data-title-off="<?php echo e(translate('Turn_Off_The_Status?')); ?>"
                                            data-text-on="<p><?php echo e(translate('Are_you_sure,_do_you_want_to_turn_on_the_Surge_Price_status_from_your_system.')); ?></p>"
                                            data-text-off="<p><?php echo e(translate('Are_you_sure,_do_you_want_to_turn_off_the_Surge_Price_status_from_your_system.')); ?></p>"
                                            id="status-<?php echo e($surge['id']); ?>" <?php echo e($surge->status?'checked':''); ?>>
                                    <span class="toggle-switch-label">
                                        <span class="toggle-switch-indicator"></span>
                                    </span>
                                </label>
                                <form action="<?php echo e(route('admin.business-settings.zone.surge-price.status',[$surge['id'],$surge->status?0:1])); ?>" method="get" id="status-<?php echo e($surge['id']); ?>_form">
                                </form>
                            </td>
                            <td>
                                <div class="btn--container justify-content-center">
                                    <a class="btn action-btn btn--primary btn-outline-primary"
                                        href="<?php echo e(route('admin.business-settings.zone.surge-price.edit',[$surge['id']])); ?>" title="<?php echo e(translate('messages.edit_surge')); ?>"><i class="tio-edit"></i>
                                    </a>
                                    <a class="btn  action-btn btn--danger btn-outline-danger form-alert" href="javascript:"
                                        data-id="surge-<?php echo e($surge['id']); ?>" data-message="<?php echo e(translate('messages.Are_you_sure_you_want_to_delete_this_surge_Price_&_remove_it_permanently?')); ?>" title="<?php echo e(translate('messages.delete_surge')); ?>"><i class="tio-delete-outlined"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.business-settings.zone.surge-price.delete',[$surge['id']])); ?>"
                                            method="post" id="surge-<?php echo e($surge['id']); ?>">
                                        <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <?php if(count($surges) !== 0): ?>
            <hr>
            <?php endif; ?>
            <div class="page-area">
                <?php echo $surges->withQueryString()->links(); ?>

            </div>
            <?php if(count($surges) === 0): ?>
            <div class="empty--data">
                <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                <h5>
                    <?php echo e(translate('no_data_found')); ?>

                </h5>
            </div>
            <?php endif; ?>
        </div>
    </div>
<?php else: ?>
<h3 class="mt-3 px-2"><?php echo e(translate('messages.Surge_Price')); ?></h3>
        <table id="#0" class="table m-0 table-borderless table-thead-bordered table-align-middle">
            <tbody id="table-div">
                <tr>
                    <td colspan="">
                        <div class="bg-light rounded table-column p-5 text-center">
                            <div class="pt-5">
                                <img class="mb-20" src="<?php echo e(asset('public/assets/admin/img/price-emty.png')); ?>" alt="status">
                                <h4 class="mb-3"><?php echo e(translate('Currently you don’t have any Surge Price')); ?></h4>
                                <p class="mb-20 fs-12 mx-auto max-w-400px"><?php echo e(translate('To enable surge pricing, you must create at least one Surge Price. In this page you see all the surge price you added.')); ?></p>
                                <a href="<?php echo e(route('admin.business-settings.zone.surge-price.create',[$zone['id']])); ?>" class="btn btn--primary">
                                    <?php echo e(translate('Create Surge Price')); ?>

                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
<?php endif; ?>



        <?php $__env->stopSection(); ?>

        <?php $__env->startPush('script_2'); ?>
        <?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/zone/surge-setup.blade.php ENDPATH**/ ?>