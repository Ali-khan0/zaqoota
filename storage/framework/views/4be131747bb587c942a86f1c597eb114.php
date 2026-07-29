<?php $__env->startSection('title',translate('Employee List')); ?>
<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <div class="page-header">
    <!-- Page Heading -->
        <div class="d-flex flex-wrap align-items-center justify-content-between">
            <h1 class="page-header-title mb-3 mr-1">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/role.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.Employee_list')); ?>

                </span>
            </h1>
            <a href="<?php echo e(route('admin.users.employee.add-new')); ?>" class="btn btn--primary mb-3">
                <i class="tio-add-circle"></i>
                <span class="text"><?php echo e(translate('messages.add_new')); ?></span>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-2 border-0">
                    <div class="search--button-wrapper">
                        <h5 class="card-title"><?php echo e(translate('messages.Employee_table')); ?> <span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($employees->total()); ?></span></h5>
                        <form class="search-form min--200">
                            <!-- Search -->
                            <div class="input-group input--group">
                                <input id="datatableSearch_" type="search" name="search"  value="<?php echo e(request()->get('search')); ?>" class="form-control" placeholder="<?php echo e(translate('messages.ex_:_search_name')); ?>" aria-label="Search">
                                <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                            </div>
                            <!-- End Search -->
                        </form>

                        <?php if(request()->get('search')): ?>
                        <button type="reset" class="btn btn--primary ml-2 location-reload-to-base" data-url="<?php echo e(url()->full()); ?>"><?php echo e(translate('messages.reset')); ?></button>
                        <?php endif; ?>

                                            <!-- Unfold -->
                    <div class="hs-unfold mr-2">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle h--45px min-height-40" href="javascript:;"
                            data-hs-unfold-options='{
                                    "target": "#usersExportDropdown",
                                    "type": "css-animation"
                                }'>
                            <i class="tio-download-to mr-1"></i> <?php echo e(translate('messages.export')); ?>

                        </a>

                        <div id="usersExportDropdown"
                            class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                            <span class="dropdown-header"><?php echo e(translate('messages.download_options')); ?></span>
                            <a id="export-excel" class="dropdown-item" href="<?php echo e(route('admin.users.employee.export', ['type'=>'excel',request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                    alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item" href="<?php echo e(route('admin.users.employee.export', ['type'=>'csv',request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                    alt="Image Description">
                                .<?php echo e(translate('messages.csv')); ?>

                            </a>
                        </div>
                    </div>
                    <!-- End Unfold -->
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="datatable"
                               class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100"
                               data-hs-datatables-options='{
                                 "order": [],
                                 "orderCellsTop": true,
                                 "paging":false
                               }'>
                            <thead class="thead-light">
                            <tr>
                                <th class="border-0"><?php echo e(translate('sl')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.name')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.email')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.phone')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Role')); ?></th>
                                <th class="border-0 text-center"><?php echo e(translate('messages.action')); ?></th>
                            </tr>
                            </thead>
                            <tbody id="set-rows">
                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <th scope="row"><?php echo e($k+$employees->firstItem()); ?></th>
                                    <td class="text-capitalize"><?php echo e($employee['f_name']); ?> <?php echo e($employee['l_name']); ?></td>
                                    <td >
                                      <?php echo e($employee['email']); ?>

                                    </td>
                                    <td><?php echo e($employee['phone']); ?></td>
                                    <td><?php echo e($employee->role?$employee->role['name']:translate('messages.role_deleted')); ?></td>
                                    <td>
                                        <?php if(auth('admin')->id()  != $employee['id']): ?>
                                        <div class="btn--container justify-content-center">
                                            <a class="btn action-btn btn--primary btn-outline-primary"
                                                href="<?php echo e(route('admin.users.employee.edit',[$employee['id']])); ?>" title="<?php echo e(translate('messages.edit_Employee')); ?>"><i class="tio-edit"></i>
                                            </a>
                                            <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:" data-id="employee-<?php echo e($employee['id']); ?>" data-message="<?php echo e(translate('messages.Want_to_delete_this_role')); ?>" title="<?php echo e(translate('messages.delete_Employee')); ?>"><i class="tio-delete-outlined"></i>
                                            </a>
                                        </div>
                                        <form action="<?php echo e(route('admin.users.employee.delete',[$employee['id']])); ?>"
                                                method="post" id="employee-<?php echo e($employee['id']); ?>">
                                            <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                        </form>
                                        <?php else: ?>
                                        <div class="btn--container justify-content-center">
                                        <span class="badge-pill badge-soft-primary"> <?php echo e(translate('messages.N/A')); ?> </span>
                                    </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if(count($employees) !== 0): ?>
                <hr>
                <?php endif; ?>
                <div class="page-area">
                    <?php echo $employees->links(); ?>

                </div>
                <?php if(count($employees) === 0): ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/employee/list.blade.php ENDPATH**/ ?>