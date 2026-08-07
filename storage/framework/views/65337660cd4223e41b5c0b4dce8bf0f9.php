<?php $__env->startSection('title',translate('messages.add_new_condition')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/condition.png')); ?>" class="w--20" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.Common_Condition_Setup')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="card">
            <div class="card-body">
                <form action="<?php echo e(route('admin.common-condition.store')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <?php if($language): ?>
                    <?php ($defaultLang = $language[0]); ?>
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
                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.name')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                        <input type="text" name="name[]" class="form-control" placeholder="<?php echo e(translate('messages.new_condition')); ?>" maxlength="191">
                    </div>
                    <input type="hidden" name="lang[]" value="default">
                    <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-group d-none lang_form" id="<?php echo e($lang); ?>-form">
                            <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.name')); ?> (<?php echo e(strtoupper($lang)); ?>)</label>
                            <input type="text" name="name[]" class="form-control" placeholder="<?php echo e(translate('messages.new_condition')); ?>" maxlength="191">
                        </div>
                        <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="form-group">
                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.name')); ?></label>
                        <input type="text" name="name" class="form-control" placeholder="<?php echo e(translate('messages.new_condition')); ?>" value="<?php echo e(old('name')); ?>" maxlength="191">
                    </div>
                    <input type="hidden" name="lang[]" value="default">
                <?php endif; ?>
                    <div class="btn--container justify-content-end mt-20">
                        <button type="reset" id="reset_btn" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo e(isset($condition)?translate('messages.update'):translate('messages.add')); ?></button>
                    </div>

                </form>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header py-2 border-0">
                <div class="search--button-wrapper">
                    <h5 class="card-title"><?php echo e(translate('messages.Common_Conditions')); ?><span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($conditions->total()); ?></span></h5>
                    <form  class="search-form">
                        <!-- Search -->
                        <div class="input-group input--group">
                            <input id="datatableSearch" name="search" value="<?php echo e(request()?->search ?? null); ?>"  type="search" class="form-control" placeholder="<?php echo e(translate('messages.search_by_name')); ?>" aria-label="<?php echo e(translate('messages.Common_Conditions')); ?>">
                            <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                        </div>
                        <!-- End Search -->
                    </form>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive datatable-custom">
                    <table id="columnSearchDatatable"
                        class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                        data-hs-datatables-options='{
                            "search": "#datatableSearch",
                            "entries": "#datatableEntries",
                            "isResponsive": false,
                            "isShowPaging": false,
                            "paging":false,
                        }'>
                        <thead class="thead-light">
                            <tr>
                                <th class="border-0"><?php echo e(translate('sl')); ?></th>
                                <th class="border-0 w--1"><?php echo e(translate('messages.Common_Condition_Name')); ?></th>
                                <th class="border-0 text-center"><?php echo e(translate('messages.Total_Products')); ?></th>
                                <th class="border-0 text-center"><?php echo e(translate('messages.status')); ?></th>
                                <th class="border-0 text-center"><?php echo e(translate('messages.action')); ?></th>
                            </tr>
                        </thead>

                        <tbody id="table-div">
                        <?php $__currentLoopData = $conditions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$condition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($key+$conditions->firstItem()); ?></td>
                                <td>
                                    <span class="d-block font-size-sm text-body">
                                        <?php echo e(Str::limit($condition['name'],20,'...')); ?>

                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="d-block font-size-sm text-body">
                                        <?php echo e($condition->items->count()); ?>

                                    </span>
                                </td>
                                <td>
                                    <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox<?php echo e($condition->id); ?>">
                                    <input type="checkbox" data-url="<?php echo e(route('admin.common-condition.status',[$condition['id'],$condition->status?0:1])); ?>" class="toggle-switch-input redirect-url" id="stocksCheckbox<?php echo e($condition->id); ?>" <?php echo e($condition->status?'checked':''); ?>>
                                        <span class="toggle-switch-label mx-auto">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                    </label>
                                </td>
                                <td>
                                    <div class="btn--container justify-content-center">
                                        <a class="btn action-btn btn--primary btn-outline-primary"
                                            href="<?php echo e(route('admin.common-condition.edit',[$condition['id']])); ?>" title="<?php echo e(translate('messages.edit_condition')); ?>"><i class="tio-edit"></i>
                                        </a>
                                        <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:" data-id="condition-<?php echo e($condition['id']); ?>" data-message="<?php echo e(translate('messages.Want to delete this condition')); ?>"  title="<?php echo e(translate('messages.delete_condition')); ?>"><i class="tio-delete-outlined"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.common-condition.delete',[$condition['id']])); ?>" method="post" id="condition-<?php echo e($condition['id']); ?>">
                                            <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if(count($conditions) !== 0): ?>
            <hr>
            <?php endif; ?>
            <div class="page-area">
                <?php echo $conditions->links(); ?>

            </div>
            <?php if(count($conditions) === 0): ?>
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

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/common-condition-index.js"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/common-condition/index.blade.php ENDPATH**/ ?>