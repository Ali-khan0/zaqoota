<?php $__env->startSection('title',translate('messages.Employee List')); ?>
<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <div class="page-header">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <h1 class="page-header-title mb-2">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/role.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.employee_list')); ?>

                    <span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($em->total()); ?></span>
                </span>

            </h1>
            <a href="<?php echo e(route('vendor.employee.add-new')); ?>" class="btn btn--primary mb-2">
                <i class="tio-add-circle"></i>
                <span class="text"><?php echo e(translate('messages.add_new_employee')); ?></span>
            </a>
        </div>
    </div>
    <!-- Page Heading -->

    <div class="card">
        <div class="card-header py-2 justify-content-end border-0">
            <div class="search--button-wrapper justify-content-end">
                <form  class="search-form">

                    <!-- Search -->
                    <div class="input-group input--group">
                        <input  value="<?php echo e(request()?->search ?? null); ?>"  type="search" name="search" class="form-control" placeholder="<?php echo e(translate('messages.Ex:')); ?> <?php echo e(translate('Search by name or email..')); ?>" aria-label="Search">
                        <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                    </div>
                    <!-- End Search -->
                </form>
                <!-- Unfold -->
                <div class="hs-unfold mr-2">
                    <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle h--40px" href="javascript:;"
                        data-hs-unfold-options='{
                            "target": "#usersExportDropdown",
                            "type": "css-animation"
                        }'>
                        <i class="tio-download-to mr-1"></i> <?php echo e(translate('messages.export')); ?>

                    </a>

                    <div id="usersExportDropdown"
                            class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">

                        <span
                            class="dropdown-header"><?php echo e(translate('messages.download_options')); ?></span>
                        <a id="export-excel" class="dropdown-item" href="<?php echo e(route('vendor.employee.export-employee', ['type'=>'excel',request()->getQueryString()])); ?>">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin/svg/components/excel.svg')); ?>"
                                    alt="Image Description">
                            <?php echo e(translate('messages.excel')); ?>

                        </a>
                        <a id="export-csv" class="dropdown-item" href="<?php echo e(route('vendor.employee.export-employee', ['type'=>'csv',request()->getQueryString()])); ?>">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin/svg/components/placeholder-csv-format.svg')); ?>"
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
                        class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                        data-hs-datatables-options='{
                            "order": [],
                            "orderCellsTop": true,
                            "paging":false
                        }'>
                    <thead class="thead-light">
                    <tr>
                        <th class="border-0"><?php echo e(translate('messages.#')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.name')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.email')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.phone')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.Role')); ?></th>
                        <th class="border-0 text-center"><?php echo e(translate('messages.action')); ?></th>
                    </tr>
                    </thead>
                    <tbody id="set-rows">
                    <?php $__currentLoopData = $em; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <th scope="row"><?php echo e($k+$em->firstItem()); ?></th>
                            <td class="text-capitalize text-break"><?php echo e($e['f_name']); ?> <?php echo e($e['l_name']); ?></td>
                            <td><?php echo e($e['email']); ?></td>
                            <td><?php echo e($e['phone']); ?></td>
                            <td><?php echo e($e->role?$e->role['name']:translate('messages.role_deleted')); ?></td>
                            <td>
                                <?php if(auth('vendor_employee')->id()  != $e['id']): ?>
                                    <div class="btn--container justify-content-center">
                                        <a class="btn action-btn btn--primary btn-outline-primary"
                                            href="<?php echo e(route('vendor.employee.edit',[$e['id']])); ?>" title="<?php echo e(translate('messages.edit_Employee')); ?>"><i class="tio-edit"></i>
                                        </a>
                                        <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:"
                                           data-id="employee-<?php echo e($e['id']); ?>"
                                           data-message="<?php echo e(translate('messages.Want_to_delete_this_role')); ?>"
                                            title="<?php echo e(translate('messages.delete_Employee')); ?>"><i class="tio-delete-outlined"></i>
                                        </a>
                                    </div>
                                    <form action="<?php echo e(route('vendor.employee.delete',[$e['id']])); ?>"
                                            method="post" id="employee-<?php echo e($e['id']); ?>">
                                        <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                    </form>
                                <?php else: ?>
                                    <div class="btn--container justify-content-center">
                                    <?php echo e(translate('N/A')); ?>

                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if(count($em) !== 0): ?>
        <div class="card-footer">
            <div class="page-area">
                <table>
                    <tfoot>
                    <?php echo $em->links(); ?>

                    </tfoot>
                </table>
            </div>
        </div>
        <?php endif; ?>
        <?php if(count($em) === 0): ?>
        <div class="empty--data">
            <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
            <h5>
                <?php echo e(translate('no_data_found')); ?>

            </h5>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/vendor-views/employee/list.blade.php ENDPATH**/ ?>