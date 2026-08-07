<?php $__env->startSection('title',translate('messages.custom_role')); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-header-title">
            <span class="page-header-icon">
                <img src="<?php echo e(asset('public/assets/admin/img/role.png')); ?>" class="w--26" alt="">
            </span>
            <span>
                <?php echo e(translate('messages.employee_Role')); ?>

            </span>
        </h1>
    </div>
    <!-- End Page Header -->
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo e(route('admin.users.custom-role.create')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <?php if($language): ?>
                        <ul class="nav nav-tabs mb-4">
                            <li class="nav-item">
                                <a class="nav-link lang_link active"
                                href="#"
                                id="default-link"><?php echo e(translate('messages.default')); ?></a>
                            </li>
                            <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="nav-item">
                                    <a class="nav-link lang_link"
                                        href="#"
                                        id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                            <div class="form-group lang_form" id="default-form">
                                <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.role_name')); ?> (<?php echo e(translate('messages.default')); ?>) <span class="form-label-secondary text-danger"
                                    data-toggle="tooltip" data-placement="right"
                                    data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                    </span>
                                </label>
                                <input type="text" name="name[]" class="form-control" placeholder="<?php echo e(translate('role_name_example')); ?>" maxlength="191">
                            </div>
                            <input type="hidden" name="lang[]" value="default">
                                <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-group d-none lang_form" id="<?php echo e($lang); ?>-form">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.role_name')); ?> (<?php echo e(strtoupper($lang)); ?>)</label>
                                        <input type="text" name="name[]" class="form-control" placeholder="<?php echo e(translate('role_name_example')); ?>" maxlength="191">
                                    </div>
                                    <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="form-group">
                                    <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.role_name')); ?></label>
                                    <input type="text" name="name" class="form-control" placeholder="<?php echo e(translate('role_name_example')); ?>" value="<?php echo e(old('name')); ?>" maxlength="191">
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                            <?php endif; ?>

                        <div class="d-flex flex-wrap select--all-checkes">
                            <h5 class="input-label m-0 text-capitalize"><?php echo e(translate('messages.Set_permission')); ?> : </h5>
                            <div class="check-item pb-0 w-auto">
                                <div class="form-group form-check form--check m-0 ml-2">
                                    <input type="checkbox" name="modules[]" value="collect_cash" class="form-check-input" id="select-all">
                                    <label class="form-check-label ml-2" for="select-all"><?php echo e(translate('select_all')); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="check--item-wrapper">
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="collect_cash" class="form-check-input"
                                           id="collect_cash">
                                    <label class="form-check-label qcont text-dark" for="collect_cash"><?php echo e(translate('messages.collect_Cash')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="addon" class="form-check-input"
                                           id="addon">
                                    <label class="form-check-label qcont text-dark" for="addon"><?php echo e(translate('messages.addon')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="attribute" class="form-check-input"
                                           id="attribute">
                                    <label class="form-check-label qcont text-dark" for="attribute"><?php echo e(translate('messages.attribute')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="advertisement" class="form-check-input"
                                           id="advertisement">
                                    <label class="form-check-label qcont text-dark" for="advertisement"><?php echo e(translate('messages.advertisement')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="banner" class="form-check-input"
                                           id="banner">
                                    <label class="form-check-label qcont text-dark" for="banner"><?php echo e(translate('messages.banner')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="campaign" class="form-check-input"
                                           id="campaign">
                                    <label class="form-check-label qcont text-dark" for="campaign"><?php echo e(translate('messages.campaign')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="category" class="form-check-input"
                                           id="category">
                                    <label class="form-check-label qcont text-dark" for="category"><?php echo e(translate('messages.category')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="coupon" class="form-check-input"
                                           id="coupon">
                                    <label class="form-check-label qcont text-dark" for="coupon"><?php echo e(translate('messages.coupon')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="cashback" class="form-check-input"
                                           id="cashback">
                                    <label class="form-check-label qcont text-dark" for="cashback"><?php echo e(translate('messages.cashback')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="customer_management" class="form-check-input"
                                           id="customer_management">
                                    <label class="form-check-label qcont text-dark" for="customer_management"><?php echo e(translate('messages.customer_management')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="deliveryman" class="form-check-input"
                                           id="deliveryman">
                                    <label class="form-check-label qcont text-dark" for="deliveryman"><?php echo e(translate('messages.deliveryman')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="disbursement" class="form-check-input"
                                           id="disbursement">
                                    <label class="form-check-label qcont text-dark" for="disbursement"><?php echo e(translate('messages.disbursement')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="provide_dm_earning" class="form-check-input"
                                           id="provide_dm_earning">
                                    <label class="form-check-label qcont text-dark" for="provide_dm_earning"><?php echo e(translate('messages.provide_dm_earning')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="employee" class="form-check-input"
                                           id="employee">
                                    <label class="form-check-label qcont text-dark" for="employee"><?php echo e(translate('messages.Employee')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="item" class="form-check-input"
                                           id="item">
                                    <label class="form-check-label qcont text-dark" for="item"><?php echo e(translate('messages.item')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="notification" class="form-check-input"
                                           id="notification">
                                    <label class="form-check-label qcont text-dark" for="notification"><?php echo e(translate('messages.notification')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="order" class="form-check-input"
                                           id="order">
                                    <label class="form-check-label qcont text-dark" for="order"><?php echo e(translate('messages.order')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="store" class="form-check-input"
                                           id="store">
                                    <label class="form-check-label qcont text-dark" for="store"><?php echo e(translate('messages.store')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="report" class="form-check-input"
                                            id="report">
                                    <label class="form-check-label qcont text-dark" for="report"><?php echo e(translate('messages.report')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="settings" class="form-check-input"
                                           id="settings">
                                    <label class="form-check-label qcont text-dark" for="settings"><?php echo e(translate('messages.settings')); ?></label>
                                </div>
                            </div>

                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="withdraw_list" class="form-check-input"
                                            id="withdraw_list">
                                    <label class="form-check-label qcont text-dark" for="withdraw_list"><?php echo e(translate('messages.withdraw_list')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="zone" class="form-check-input"
                                           id="zone">
                                    <label class="form-check-label qcont text-dark" for="zone"><?php echo e(translate('messages.zone')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="module" class="form-check-input"
                                           id="module_system">
                                    <label class="form-check-label qcont text-dark" for="module_system"><?php echo e(translate('messages.module')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="parcel" class="form-check-input"
                                           id="parcel">
                                    <label class="form-check-label qcont text-dark" for="parcel"><?php echo e(translate('messages.parcel')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="pos" class="form-check-input"
                                           id="pos">
                                    <label class="form-check-label qcont text-dark" for="pos"><?php echo e(translate('messages.pos')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="unit" class="form-check-input"
                                           id="unit">
                                    <label class="form-check-label qcont text-dark" for="unit"><?php echo e(translate('messages.unit')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="subscription" class="form-check-input"
                                           id="subscription">
                                    <label class="form-check-label qcont text-dark" for="subscription"><?php echo e(translate('messages.subscription')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="brand" class="form-check-input"
                                           id="brand">
                                    <label class="form-check-label qcont text-dark" for="brand"><?php echo e(translate('messages.brand')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="common_condition" class="form-check-input"
                                           id="common_condition">
                                    <label class="form-check-label qcont text-dark" for="common_condition"><?php echo e(translate('messages.common_condition')); ?></label>
                                </div>
                            </div>
                        </div>
                        <?php if(addon_published_status('Rental')): ?>
                            <div class="pt-5">
                                <h4><?php echo e(translate('Rental Role')); ?></h4>
                            </div>
                            <div class="check--item-wrapper">
                                <div class="check-item">
                                    <div class="form-group form-check form--check">
                                        <input type="checkbox" name="modules[]" value="trip" class="form-check-input"
                                               id="trip">
                                        <label class="form-check-label qcont text-dark" for="trip"><?php echo e(translate('messages.Trip')); ?></label>
                                    </div>
                                </div>
                                <div class="check-item">
                                    <div class="form-group form-check form--check">
                                        <input type="checkbox" name="modules[]" value="promotion" class="form-check-input"
                                               id="promotion">
                                        <label class="form-check-label qcont text-dark" for="promotion"><?php echo e(translate('messages.Promotion')); ?></label>
                                    </div>
                                </div>
                                <div class="check-item">
                                    <div class="form-group form-check form--check">
                                        <input type="checkbox" name="modules[]" value="vehicle" class="form-check-input"
                                               id="vehicle">
                                        <label class="form-check-label qcont text-dark" for="vehicle"><?php echo e(translate('messages.Vehicle')); ?></label>
                                    </div>
                                </div>
                                <div class="check-item">
                                    <div class="form-group form-check form--check">
                                        <input type="checkbox" name="modules[]" value="provider" class="form-check-input"
                                               id="provider">
                                        <label class="form-check-label qcont text-dark" for="provider"><?php echo e(translate('messages.Provider')); ?></label>
                                    </div>
                                </div>
                                <div class="check-item">
                                    <div class="form-group form-check form--check">
                                        <input type="checkbox" name="modules[]" value="driver" class="form-check-input"
                                               id="driver">
                                        <label class="form-check-label qcont text-dark" for="driver"><?php echo e(translate('messages.Driver')); ?></label>
                                    </div>
                                </div>
                                <div class="check-item">
                                    <div class="form-group form-check form--check">
                                        <input type="checkbox" name="modules[]" value="download_app" class="form-check-input"
                                               id="download_app">
                                        <label class="form-check-label qcont text-dark" for="download_app"><?php echo e(translate('messages.Download app')); ?></label>
                                    </div>
                                </div>
                                <div class="check-item">
                                    <div class="form-group form-check form--check">
                                        <input type="checkbox" name="modules[]" value="rental_report" class="form-check-input"
                                               id="rental_report">
                                        <label class="form-check-label qcont text-dark" for="rental_report"><?php echo e(translate('messages.Report')); ?></label>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="btn--container justify-content-end mt-4">
                            <button type="reset" id="reset-btn" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                            <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.submit')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-0 py-2">
                    <div class="search--button-wrapper">
                        <h5 class="card-title">
                            <?php echo e(translate('messages.roles_table')); ?> <span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($roles->total()); ?></span>
                        </h5>
                        <form class="search-form min--200">
                            <!-- Search -->
                            <div class="input-group input--group">
                                <input id="datatableSearch_" type="search" name="search"  value="<?php echo e(request()?->search); ?>" class="form-control" placeholder="<?php echo e(translate('ex_:_search_role_name')); ?>" aria-label="Search">
                                <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                            </div>
                            <!-- End Search -->
                        </form>
                        <?php if(request()->get('search')): ?>
                        <button type="reset" class="btn btn--primary ml-2 location-reload-to-base" data-url="<?php echo e(url()->full()); ?>"><?php echo e(translate('messages.reset')); ?></button>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive datatable-custom">
                        <table id="columnSearchDatatable"
                               class="role--table table table-borderless table-thead-bordered table-align-middle card-table"
                               data-hs-datatables-options='{
                                 "order": [],
                                 "orderCellsTop": true,
                                 "paging":false
                               }'>
                            <thead class="thead-light">
                            <tr>
                                <th scope="col" class="border-0"><?php echo e(translate('sl')); ?></th>
                                <th scope="col" class="border-0"><?php echo e(translate('messages.role_name')); ?></th>
                                <th scope="col" class="border-0"><?php echo e(translate('messages.Permissions')); ?></th>
                                <th scope="col" class="border-0"><?php echo e(translate('messages.created_at')); ?></th>
                                <th scope="col" class="border-0 text-center"><?php echo e(translate('messages.action')); ?></th>
                            </tr>
                            </thead>
                            <tbody  id="set-rows">
                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td scope="row"><?php echo e($k+$roles->firstItem()); ?></td>
                                    <td title="<?php echo e($role['name']); ?>" ><?php echo e(Str::limit($role['name'],25,'...')); ?></td>
                                    <td class="text-capitalize">
                                        <?php if($role['modules']!=null): ?>
                                            <?php $__currentLoopData = (array)json_decode($role['modules']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo e(translate(str_replace('_',' ',$module))); ?>


                                                <?php echo e(!$loop->last ? ',' : '.'); ?>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="create-date">
                                            <?php echo e(\App\CentralLogics\Helpers::date_format($role['created_at'])); ?>

                                        </div>
                                    </td>

                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a class="btn action-btn btn--primary btn-outline-primary"
                                                href="<?php echo e(route('admin.users.custom-role.edit',[$role['id']])); ?>" title="<?php echo e(translate('messages.edit_role')); ?>"><i class="tio-edit"></i>
                                            </a>
                                            <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:" data-id="role-<?php echo e($role['id']); ?>" data-message="<?php echo e(translate('messages.Want_to_delete_this_role')); ?>"
                                               title="<?php echo e(translate('messages.delete_role')); ?>"><i class="tio-delete-outlined"></i>
                                            </a>
                                        </div>
                                        <form action="<?php echo e(route('admin.users.custom-role.delete',[$role['id']])); ?>"
                                                method="post" id="role-<?php echo e($role['id']); ?>">
                                            <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if(count($roles) !== 0): ?>
                    <hr>
                    <?php endif; ?>
                    <div class="page-area">
                        <?php echo $roles->links(); ?>

                    </div>
                    <?php if(count($roles) === 0): ?>
                    <div class="empty--data">
                        <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                        <h5>
                            <?php echo e(translate('no_data_found')); ?>

                        </h5>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/custom-role-index.js"></script>


<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/custom-role/create.blade.php ENDPATH**/ ?>