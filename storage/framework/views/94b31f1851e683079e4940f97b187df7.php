<?php $__env->startSection('title',translate('messages.Create_Role')); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <!-- Page Heading -->
    <div class="page-header">
        <h1 class="page-header-title">
            <span class="page-header-icon">
                <img src="<?php echo e(asset('public/assets/admin/img/role.png')); ?>" class="w--26" alt="">
            </span>
            <span>
                <?php echo e(translate('messages.custom_role')); ?>

            </span>
        </h1>
    </div>
    <!-- Page Heading -->
    <?php ($language=\App\Models\BusinessSetting::where('key','language')->first()); ?>
    <?php ($language = $language->value ?? null); ?>
    <?php ($defaultLang = str_replace('_', '-', app()->getLocale())); ?>
    <!-- Content Row -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                <span class="card-header-icon">
                    <i class="tio-document-text-outlined"></i>
                </span>
                <span><?php echo e(translate('messages.role_form')); ?></span>
            </h5>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('vendor.custom-role.create')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <?php if($language): ?>
                        <ul class="nav nav-tabs mb-4">
                            <li class="nav-item">
                                <a class="nav-link lang_link active"
                                href="#"
                                id="default-link"><?php echo e(translate('messages.default')); ?></a>
                            </li>
                            <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="nav-item">
                                    <a class="nav-link lang_link"
                                        href="#"
                                        id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                            <div class="form-group lang_form" id="default-form">
                                <label class="input-label" for="name"><?php echo e(translate('messages.role_name')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                <input type="text" id="name" name="name[]" class="form-control" placeholder="<?php echo e(translate('role_name_example')); ?>" maxlength="191"  >
                            </div>
                            <input type="hidden" name="lang[]" value="default">
                                <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-group d-none lang_form" id="<?php echo e($lang); ?>-form">
                                        <label class="input-label" for="name<?php echo e($lang); ?>"><?php echo e(translate('messages.role_name')); ?> (<?php echo e(strtoupper($lang)); ?>)</label>
                                        <input type="text" id="name<?php echo e($lang); ?>" name="name[]" class="form-control" placeholder="<?php echo e(translate('role_name_example')); ?>" maxlength="191"  >
                                    </div>
                                    <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="form-group">
                                    <label class="input-label" for="name"><?php echo e(translate('messages.role_name')); ?></label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="<?php echo e(translate('role_name_example')); ?>" value="<?php echo e(old('name')); ?>" required maxlength="191">
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                            <?php endif; ?>

                <h5 class="text-capitalize"><?php echo e(translate('messages.module_permission')); ?> : </h5>
                <hr>
                <div class="check--item-wrapper mx-0">
                    <div class="check-item">
                        <div class="form-group form-check form--check">
                            <input type="checkbox" name="modules[]" value="trip" class="form-check-input"
                                    id="trip">
                            <label class="form-check-label input-label " for="trip"><?php echo e(translate('messages.Trip')); ?></label>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="form-group form-check form--check">
                            <input type="checkbox" name="modules[]" value="vehicle" class="form-check-input"
                                    id="vehicle">
                            <label class="form-check-label input-label " for="vehicle"><?php echo e(translate('messages.Vehicle')); ?></label>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="form-group form-check form--check">
                            <input type="checkbox" name="modules[]" value="driver" class="form-check-input" id="driver">
                            <label class="form-check-label input-label " for="driver"><?php echo e(translate('messages.Driver')); ?></label>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="form-group form-check form--check">
                            <input type="checkbox" name="modules[]" value="marketing" class="form-check-input"
                                    id="marketing">
                            <label class="form-check-label input-label " for="marketing"><?php echo e(translate('messages.Marketing')); ?></label>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="form-group form-check form--check">
                            <input type="checkbox" name="modules[]" value="store_setup" class="form-check-input"
                                    id="store_setup">
                            <label class="form-check-label input-label " for="store_setup"><?php echo e(translate('messages.Store setup')); ?></label>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="form-group form-check form--check">
                            <input type="checkbox" name="modules[]" value="wallet" class="form-check-input"
                                    id="wallet">
                            <label class="form-check-label input-label " for="wallet"><?php echo e(translate('messages.My wallet')); ?></label>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="form-group form-check form--check">
                            <input type="checkbox" name="modules[]" value="bank_info" class="form-check-input"
                                    id="bank_info">
                            <label class="form-check-label input-label " for="bank_info"><?php echo e(translate('messages.Profile')); ?></label>
                        </div>
                    </div>

                    <div class="check-item">
                        <div class="form-group form-check form--check">
                            <input type="checkbox" name="modules[]" value="employee" class="form-check-input"
                                    id="employee">
                            <label class="form-check-label input-label " for="employee"><?php echo e(translate('messages.Employees')); ?></label>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="form-group form-check form--check">
                            <input type="checkbox" name="modules[]" value="my_shop" class="form-check-input"
                                    id="my_shop">
                            <label class="form-check-label input-label " for="my_shop"><?php echo e(translate('messages.My shop')); ?></label>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="form-group form-check form--check">
                            <input type="checkbox" name="modules[]" value="reviews" class="form-check-input"
                                    id="reviews">
                            <label class="form-check-label input-label " for="reviews"><?php echo e(translate('messages.reviews')); ?></label>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="form-group form-check form--check">
                            <input type="checkbox" name="modules[]" value="chat" class="form-check-input"
                                    id="chat">
                            <label class="form-check-label input-label " for="chat"><?php echo e(translate('messages.chat')); ?></label>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="form-group form-check form--check">
                            <input type="checkbox" name="modules[]" value="report" class="form-check-input"
                                    id="report">
                            <label class="form-check-label input-label " for="report"><?php echo e(translate('messages.Report')); ?></label>
                        </div>
                    </div>
                </div>
                <div class="btn--container justify-content-end mt-4">
                    <button type="reset" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                    <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.submit')); ?></button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header border-0">
            <div class="search--button-wrapper">
                <h5 class="card-title">
                    <span class="card-header-icon">
                        <i class="tio-document-text-outlined"></i>
                    </span>
                    <span>
                        <?php echo e(translate('messages.roles_table')); ?><span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($roles->total()); ?></span>
                    </span>
                </h5>
                <form  class="search-form min--250">
                    <!-- Search -->
                    <div class="input-group input--group">
                        <input  value="<?php echo e(request()?->search ?? ''); ?>" type="search" name="search" class="form-control" placeholder="<?php echo e(translate('messages.search_role')); ?>" aria-label="<?php echo e(translate('messages.search')); ?>">
                        <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                    </div>
                    <!-- End Search -->
                </form>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive datatable-custom">
                <table id="columnSearchDatatable"
                        class="table table-borderless table-thead-bordered table-align-middle card-table"
                        data-hs-datatables-options='{
                            "order": [],
                            "orderCellsTop": true,
                            "paging":false
                        }'>
                    <thead class="thead-light">
                        <tr>
                            <th class="border-0 w-50px"><?php echo e(translate('messages.sl#')); ?></th>
                            <th class="border-0 w-50px"><?php echo e(translate('messages.role_name')); ?></th>
                            <th class="border-0 w-100px"><?php echo e(translate('messages.modules')); ?></th>
                            <th class="border-0 w-50px"><?php echo e(translate('messages.created_at')); ?></th>
                            <th class="border-0 w-50px text-center"><?php echo e(translate('messages.action')); ?></th>
                        </tr>
                    </thead>
                    <tbody  id="set-rows">
                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td ><?php echo e($k+$roles->firstItem()); ?></td>
                            <td><?php echo e(Str::limit($r['name'],20,'...')); ?></td>
                            <td class="text-capitalize">
                                <?php if($r['modules']!=null): ?>
                                    <?php $__currentLoopData = (array)json_decode($r['modules']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <?php if($m == 'bank_info'): ?>
                                    <?php echo e(translate('messages.profile')); ?>

                                    <?php else: ?>
                                    <?php echo e(translate(str_replace('_',' ',$m))); ?>

                                    <?php endif; ?>


                                    <?php echo e(!$loop->last ? ',' : '.'); ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e(date('d-M-y',strtotime($r['created_at']))); ?></td>
                            <td>
                                <?php if(auth('vendor_employee')?->user()?->employee_role_id  != $r['id']): ?>
                                    <div class="btn--container justify-content-center">
                                        <a class="btn action-btn btn--primary btn-outline-primary"
                                            href="<?php echo e(route('vendor.custom-role.update',$r['id'])); ?>" title="<?php echo e(translate('messages.edit_role')); ?>"><i class="tio-edit"></i>
                                        </a>
                                        <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:"
                                           data-id="role-<?php echo e($r['id']); ?>" data-message="<?php echo e(translate('messages.Want_to_delete_this_role')); ?>"
                                             title="<?php echo e(translate('messages.delete_role')); ?>"><i class="tio-delete-outlined"></i>
                                        </a>
                                    </div>
                                    <form action="<?php echo e(route('vendor.custom-role.delete',[$r['id']])); ?>"
                                            method="post" id="role-<?php echo e($r['id']); ?>">
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
                <?php if(count($roles) !== 0): ?>
                <hr>
                <?php endif; ?>
                <div class="page-area">
                    <table>
                        <tfoot>
                        <?php echo $roles->links(); ?>

                        </tfoot>
                    </table>
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
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/provider/employee/list.blade.php ENDPATH**/ ?>