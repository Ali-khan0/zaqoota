<?php $__env->startSection('title',translate('messages.Create_Role')); ?>
<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

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

                <div class="bg-light rounded p-3 mb-20">
                    <div class="d-flex align-items-center mr-2 flex-wrap justify-content-between select--all-checkes">
                        <h5 class="input-label m-0 text-capitalize"><?php echo e(translate('messages.Module Wise Permission')); ?></h5>
                        <div class="check-item p-2 d-flex align-items-center gap-2 pb-0 w-auto cursor-pointer">
                            <label for="select-all" class="fs-14 text-nowrap font-semibold text-title m-0"><?php echo e(translate('messages.All Module Permission')); ?></label>
                            <div class="form-group form-check form--check m-0 ml-2">
                                <input type="checkbox" value="" class="form-check-input rounded position-relative rounded" id="select-all">
                            </div>
                        </div>
                    </div>
                    <div class="check--item-wrapper d-inline">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="bg-white rounded select-subwrapper">
                                    <div class="border-bottom p-3 d-flex align-items-center justify-content-between flex-wrap flex-xxl-nowrap gap-1">
                                        <h5 class="m-0 font-medium"><?php echo e(translate('messages.General Management')); ?></h5>
                                        <div class="check-item p-2 d-flex align-items-center gap-2 pb-0 w-auto cursor-pointer">
                                            <label for="select-allsub-1" class="fs-14 text-title m-0"><?php echo e(translate('messages.Select All')); ?></label>
                                            <div class="form-group form-check form--check m-0 ml-2">
                                                <input type="checkbox" name="" value="" class="form-check-input rounded position-relative rounded check-all" id="select-allsub-1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-3">
                                        <div class="d-flex flex-wrap module-wise-gap">
                                            <div class="check-item p-2">
                                                <div class="form-group form-check form--check m-0">
                                                    <input type="checkbox" name="modules[]" value="dashboard" class="form-check-input rounded"
                                                        id="dashboard">
                                                    <label class="form-check-label qcont text-dark" for="dashboard"><?php echo e(translate('messages.Dashboard')); ?></label>
                                                </div>
                                            </div>
                                            <div class="check-item p-2">
                                                <div class="form-group form-check form--check m-0">
                                                    <input type="checkbox" name="modules[]" value="profile" class="form-check-input rounded"
                                                        id="profile">
                                                    <label class="form-check-label qcont text-dark" for="profile"><?php echo e(translate('messages.Profile')); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-white rounded select-subwrapper">
                                    <div class="border-bottom p-3 d-flex align-items-center justify-content-between flex-wrap flex-xxl-nowrap gap-1">
                                        <h5 class="m-0 font-medium"><?php echo e(translate('messages.Order Management')); ?></h5>
                                        <div class="check-item p-2 d-flex align-items-center gap-2 pb-0 w-auto cursor-pointer">
                                            <label for="select-allsub-2" class="fs-14 text-title m-0"><?php echo e(translate('messages.Select All')); ?></label>
                                            <div class="form-group form-check form--check m-0 ml-2">
                                                <input type="checkbox" name="" value="" class="form-check-input rounded position-relative rounded check-all" id="select-allsub-2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-3">
                                        <div class="d-flex flex-wrap module-wise-gap">
                                            <div class="check-item p-2">
                                                <div class="form-group form-check form--check m-0">
                                                    <input type="checkbox" name="modules[]" value="order" class="form-check-input rounded"
                                                        id="order">
                                                    <label class="form-check-label qcont text-dark" for="order"><?php echo e(translate('messages.All Orders')); ?></label>
                                                </div>
                                            </div>
                                            <?php if(\App\CentralLogics\Helpers::employee_module_permission_check('pos')): ?>
                                            <div class="check-item p-2">
                                                <div class="form-group form-check form--check m-0">
                                                    <input type="checkbox" name="modules[]" value="pos" class="form-check-input rounded"
                                                        id="pos">
                                                    <label class="form-check-label qcont text-dark" for="pos"><?php echo e(translate('messages.Point of Sale (POS)')); ?></label>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-white rounded select-subwrapper">
                                    <div class="border-bottom p-3 d-flex align-items-center justify-content-between flex-wrap flex-xxl-nowrap gap-1">
                                        <h5 class="m-0 font-medium"><?php echo e(translate('messages.Item Management')); ?></h5>
                                        <div class="check-item p-2 d-flex align-items-center gap-2 pb-0 w-auto cursor-pointer">
                                            <label for="select-allsub-3" class="fs-14 text-title m-0"><?php echo e(translate('messages.Select All')); ?></label>
                                            <div class="form-group form-check form--check m-0 ml-2">
                                                <input type="checkbox" name="" value="" class="form-check-input rounded position-relative rounded check-all" id="select-allsub-3">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-3">
                                        <div class="d-flex flex-lg-nowrap flex-wrap module-wise-gap">
                                            <div class="check-item p-2">
                                                <div class="form-group form-check form--check m-0">
                                                    <input type="checkbox" name="modules[]" value="item" class="form-check-input rounded"
                                                        id="item">
                                                    <label class="form-check-label qcont text-dark" for="item"><?php echo e(translate('messages.Items')); ?></label>
                                                </div>
                                            </div>
                                            <?php if(config('module.'.\App\CentralLogics\Helpers::get_store_data()->module->module_type)['add_on']): ?>
                                            <div class="check-item p-2">
                                                <div class="form-group form-check form--check m-0">
                                                    <input type="checkbox" name="modules[]" value="addon" class="form-check-input rounded"
                                                        id="addon">
                                                    <label class="form-check-label qcont text-dark" for="addon"><?php echo e(translate('messages.Addons')); ?></label>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                            <div class="check-item p-2">
                                                <div class="form-group form-check form--check m-0">
                                                    <input type="checkbox" name="modules[]" value="category" class="form-check-input rounded"
                                                        id="category">
                                                    <label class="form-check-label qcont text-dark" for="category"><?php echo e(translate('messages.Categories')); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-white rounded select-subwrapper">
                                    <div class="border-bottom p-3 d-flex align-items-center justify-content-between flex-wrap flex-xxl-nowrap gap-1">
                                        <h5 class="m-0 font-medium"><?php echo e(translate('messages.Marketing Section')); ?></h5>
                                        <div class="check-item p-2 d-flex align-items-center gap-2 pb-0 w-auto cursor-pointer">
                                            <label for="select-allsub-4" class="fs-14 text-title m-0"><?php echo e(translate('messages.Select All')); ?></label>
                                            <div class="form-group form-check form--check m-0 ml-2">
                                                <input type="checkbox" name="" value="" class="form-check-input rounded position-relative rounded check-all" id="select-allsub-4">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-3">
                                        <div class="d-flex flex-lg-nowrap flex-wrap module-wise-gap">
                                            <div class="check-item p-2">
                                                <div class="form-group form-check form--check m-0">
                                                    <input type="checkbox" name="modules[]" value="campaign" class="form-check-input rounded"
                                                        id="campaign">
                                                    <label class="form-check-label qcont text-dark" for="campaign"><?php echo e(translate('messages.Campaign')); ?></label>
                                                </div>
                                            </div>
                                            <div class="check-item p-2">
                                                <div class="form-group form-check form--check m-0">
                                                    <input type="checkbox" name="modules[]" value="coupon" class="form-check-input rounded"
                                                        id="coupon">
                                                    <label class="form-check-label qcont text-dark" for="coupon"><?php echo e(translate('messages.Coupon')); ?></label>
                                                </div>
                                            </div>
                                            <div class="check-item p-2">
                                                <div class="form-group form-check form--check m-0">
                                                    <input type="checkbox" name="modules[]" value="banner" class="form-check-input rounded"
                                                        id="banner">
                                                    <label class="form-check-label qcont text-dark" for="banner"><?php echo e(translate('messages.Banner')); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-white rounded select-subwrapper">
                                    <div class="border-bottom p-3 d-flex align-items-center justify-content-between flex-wrap flex-xxl-nowrap gap-1">
                                        <h5 class="m-0 font-medium"><?php echo e(translate('messages.Advertisement Management')); ?></h5>
                                        <div class="check-item p-2 d-flex align-items-center gap-2 pb-0 w-auto cursor-pointer">
                                            <label for="select-allsub-5" class="fs-14 text-title m-0"><?php echo e(translate('messages.Select All')); ?></label>
                                            <div class="form-group form-check form--check m-0 ml-2">
                                                <input type="checkbox" name="" value="" class="form-check-input rounded position-relative rounded check-all" id="select-allsub-5">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-3">
                                        <div class="d-flex flex-wrap module-wise-gap">
                                                <div class="check-item p-2">
                                                <div class="form-group form-check form--check m-0">
                                                    <input type="checkbox" name="modules[]" value="advertisement" class="form-check-input rounded"
                                                        id="advertisement">
                                                    <label class="form-check-label qcont text-dark" for="advertisement"><?php echo e(translate('messages.New Advertisement')); ?></label>
                                                </div>
                                            </div>
                                            <div class="check-item p-2">
                                                <div class="form-group form-check form--check m-0">
                                                    <input type="checkbox" name="modules[]" value="advertisement_list" class="form-check-input rounded"
                                                        id="advertisement_list">
                                                    <label class="form-check-label qcont text-dark" for="advertisement_list"><?php echo e(translate('messages.Advertisement List')); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if(\App\CentralLogics\Helpers::get_store_data()->sub_self_delivery): ?>
                            <div class="col-md-6">
                                <div class="bg-white rounded select-subwrapper">
                                    <div class="border-bottom p-3 d-flex align-items-center justify-content-between flex-wrap flex-xxl-nowrap gap-1">
                                        <h5 class="m-0 font-medium"><?php echo e(translate('messages.Delivery Man Management')); ?></h5>
                                        <div class="check-item p-2 d-flex align-items-center gap-2 pb-0 w-auto cursor-pointer">
                                            <label for="select-allsub-10" class="fs-14 text-title m-0"><?php echo e(translate('messages.Select All')); ?></label>
                                            <div class="form-group form-check form--check m-0 ml-2">
                                                <input type="checkbox" name="" value="" class="form-check-input rounded position-relative rounded check-all" id="select-allsub-10">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-3">
                                        <div class="d-flex flex-wrap module-wise-gap">
                                                <div class="check-item p-2">
                                                <div class="form-group form-check form--check m-0">
                                                    <input type="checkbox" name="modules[]" value="deliveryman" class="form-check-input rounded"
                                                        id="deliveryman">
                                                    <label class="form-check-label qcont text-dark" for="deliveryman"><?php echo e(translate('messages.New deliveryman')); ?></label>
                                                </div>
                                            </div>
                                            <div class="check-item p-2">
                                                <div class="form-group form-check form--check m-0">
                                                    <input type="checkbox" name="modules[]" value="deliveryman_list" class="form-check-input rounded"
                                                        id="deliveryman_list">
                                                    <label class="form-check-label qcont text-dark" for="deliveryman_list"><?php echo e(translate('messages.Deliveryman List')); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="col-md-6">
                                <div class="bg-white rounded select-subwrapper">
                                    <div class="border-bottom p-3 d-flex align-items-center justify-content-between flex-wrap flex-xxl-nowrap gap-1">
                                        <h5 class="m-0 font-medium"><?php echo e(translate('messages.Wallet Management')); ?></h5>
                                        <div class="check-item p-2 d-flex align-items-center gap-2 pb-0 w-auto cursor-pointer">
                                            <label for="select-allsub-6" class="fs-14 text-title m-0"><?php echo e(translate('messages.Select All')); ?></label>
                                            <div class="form-group form-check form--check m-0 ml-2">
                                                <input type="checkbox" name="" value="" class="form-check-input rounded position-relative rounded check-all" id="select-allsub-6">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-3">
                                        <div class="d-flex flex-wrap module-wise-gap">
                                            <div class="check-item p-2">
                                                <div class="form-group form-check form--check m-0">
                                                    <input type="checkbox" name="modules[]" value="wallet" class="form-check-input rounded"
                                                        id="wallet">
                                                    <label class="form-check-label qcont text-dark" for="wallet"><?php echo e(translate('messages.My Wallet')); ?></label>
                                                </div>
                                            </div>
                                            <div class="check-item p-2">
                                                <div class="form-group form-check form--check m-0">
                                                    <input type="checkbox" name="modules[]" value="wallet_method" class="form-check-input rounded"
                                                        id="wallet_method">
                                                    <label class="form-check-label qcont text-dark" for="wallet_method"><?php echo e(translate('messages.Wallet Method')); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-white rounded select-subwrapper">
                                    <div class="border-bottom p-3 d-flex align-items-center justify-content-between flex-wrap flex-xxl-nowrap gap-1">
                                        <h5 class="m-0 font-medium"><?php echo e(translate('messages.Employee Management')); ?></h5>
                                        <div class="check-item p-2 d-flex align-items-center gap-2 pb-0 w-auto cursor-pointer">
                                            <label for="select-allsub-7" class="fs-14 text-title m-0"><?php echo e(translate('messages.Select All')); ?></label>
                                            <div class="form-group form-check form--check m-0 ml-2">
                                                <input type="checkbox" name="" value="" class="form-check-input rounded position-relative rounded check-all" id="select-allsub-7">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-3">
                                        <div class="d-flex flex-wrap module-wise-gap">
                                            <div class="check-item p-2">
                                                <div class="form-group form-check form--check m-0">
                                                    <input type="checkbox" name="modules[]" value="role" class="form-check-input rounded"
                                                        id="role">
                                                    <label class="form-check-label qcont text-dark" for="role"><?php echo e(translate('messages.Role Management')); ?></label>
                                                </div>
                                            </div>
                                            <div class="check-item p-2">
                                                <div class="form-group form-check form--check m-0">
                                                    <input type="checkbox" name="modules[]" value="employee" class="form-check-input rounded"
                                                        id="employee">
                                                    <label class="form-check-label qcont text-dark" for="employee"><?php echo e(translate('messages.All Employee')); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-white rounded select-subwrapper">
                                    <div class="border-bottom p-3 d-flex align-items-center justify-content-between flex-wrap flex-xxl-nowrap gap-1">
                                        <h5 class="m-0 font-medium"><?php echo e(translate('messages.Report Section')); ?></h5>
                                        <div class="check-item p-2 d-flex align-items-center gap-2 pb-0 w-auto cursor-pointer">
                                            <label for="select-allsub-8" class="fs-14 text-title m-0"><?php echo e(translate('messages.Select All')); ?></label>
                                            <div class="form-group form-check form--check m-0 ml-2">
                                                <input type="checkbox" name="" value="" class="form-check-input rounded position-relative rounded check-all" id="select-allsub-8">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-3">
                                        <div class="d-flex flex-wrap module-wise-gap">
                                            <div class="check-item p-2">
                                                <div class="form-group form-check form--check m-0">
                                                    <input type="checkbox" name="modules[]" value="expense_report" class="form-check-input rounded"
                                                            id="expense_report">
                                                    <label class="form-check-label qcont text-dark" for="expense_report"><?php echo e(translate('messages.Expense Report')); ?></label>
                                                </div>
                                            </div>
                                            <div class="check-item p-2">
                                                <div class="form-group form-check form--check m-0">
                                                    <input type="checkbox" name="modules[]" value="disbursement_report" class="form-check-input rounded"
                                                        id="disbursement_report">
                                                    <label class="form-check-label qcont text-dark" for="disbursement_report"><?php echo e(translate('messages.Disbursement Report')); ?></label>
                                                </div>
                                            </div>
                                            <div class="check-item p-2">
                                                <div class="form-group form-check form--check m-0">
                                                    <input type="checkbox" name="modules[]" value="vat_report" class="form-check-input rounded"
                                                        id="vat_report">
                                                    <label class="form-check-label qcont text-dark" for="vat_report"><?php echo e(translate('messages.Vat Report')); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 check--item-wrapper d-inline">
                        <div class="bg-white rounded select-subwrapper">
                            <div class="border-bottom p-3 d-flex align-items-center justify-content-between flex-wrap flex-xxl-nowrap gap-1">
                                <h5 class="m-0 font-medium"><?php echo e(translate('messages.Business Management')); ?></h5>
                                <div class="check-item p-2 d-flex align-items-center gap-2 pb-0 w-auto cursor-pointer">
                                    <label for="select-allsub-9" class="fs-14 text-title m-0"><?php echo e(translate('messages.Select All')); ?></label>
                                    <div class="form-group form-check form--check m-0 ml-2">
                                        <input type="checkbox" name="" value="" class="form-check-input rounded position-relative rounded check-all" id="select-allsub-9">
                                    </div>
                                </div>
                            </div>
                            <div class="p-3">
                                <div class="m-0 row g-3">
                                    <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-3 col-sm-4">
                                        <div class="check-item p-2">
                                            <div class="form-group form-check form--check m-0">
                                                <input type="checkbox" name="modules[]" value="store_setup" class="form-check-input rounded"
                                                        id="store_setup">
                                                <label class="form-check-label text-nowrap qcont text-dark" for="store_setup"><?php echo e(translate('messages.Store Setup')); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-3 col-sm-4">
                                        <div class="check-item p-2">
                                            <div class="form-group form-check form--check m-0">
                                                <input type="checkbox" name="modules[]" value="notification_setup" class="form-check-input rounded"
                                                    id="notification_setup">
                                                <label class="form-check-label text-nowrap qcont text-dark" for="notification_setup"><?php echo e(translate('messages.Notification Setup')); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-3 col-sm-4">
                                        <div class="check-item p-2">
                                            <div class="form-group form-check form--check m-0">
                                                <input type="checkbox" name="modules[]" value="my_shop" class="form-check-input rounded"
                                                    id="my_shop">
                                                <label class="form-check-label text-nowrap qcont text-dark" for="my_shop"><?php echo e(translate('messages.MY Shop')); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-3 col-sm-4">
                                        <div class="check-item p-2">
                                            <div class="form-group form-check form--check m-0">
                                                <input type="checkbox" name="modules[]" value="business_plan" class="form-check-input rounded"
                                                    id="business_plan">
                                                <label class="form-check-label text-nowrap qcont text-dark" for="business_plan"><?php echo e(translate('messages.Business Plan')); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if(\App\CentralLogics\Helpers::employee_module_permission_check('reviews')): ?>
                                    <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-3 col-sm-4">
                                            <div class="check-item p-2">
                                            <div class="form-group form-check form--check m-0">
                                                <input type="checkbox" name="modules[]" value="reviews" class="form-check-input rounded"
                                                    id="reviews">
                                                <label class="form-check-label text-nowrap qcont text-dark" for="reviews"><?php echo e(translate('messages.Reviews')); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-3 col-sm-4">
                                        <div class="check-item p-2">
                                            <div class="form-group form-check form--check m-0">
                                                <input type="checkbox" name="modules[]" value="chat" class="form-check-input rounded"
                                                    id="chat">
                                                <label class="form-check-label text-nowrap qcont text-dark" for="chat"><?php echo e(translate('messages.Chat')); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                        <?php echo e(translate('messages.roles_table')); ?><span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($rl->total()); ?></span>
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
                    <?php $__currentLoopData = $rl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td ><?php echo e($k+$rl->firstItem()); ?></td>
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
                                <div class="btn--container justify-content-center">
                                    <a class="btn action-btn btn--primary btn-outline-primary"
                                        href="<?php echo e(route('vendor.custom-role.edit',[$r['id']])); ?>" title="<?php echo e(translate('messages.edit_role')); ?>"><i class="tio-edit"></i>
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
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php if(count($rl) !== 0): ?>
                <hr>
                <?php endif; ?>
                <div class="page-area">
                    <table>
                        <tfoot>
                        <?php echo $rl->links(); ?>

                        </tfoot>
                    </table>
                </div>
                <?php if(count($rl) === 0): ?>
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
<script>
$(document).ready(function () {
    // Global select all
    $('#select-all').on('change', function () {
        const isChecked = $(this).is(':checked');
        $('input[type="checkbox"][name="modules[]"]').prop('checked', isChecked);
        $('.check-all').prop('checked', isChecked);
    });

    // Group-wise select all
    $('.check-all').on('change', function () {
        const container = $(this).closest('.select-subwrapper');
        const isChecked = $(this).is(':checked');
        container.find('input[type="checkbox"][name="modules[]"]').prop('checked', isChecked);

        // Update global select-all status
        updateGlobalSelectAll();
    });

    // Individual checkbox change
    $('input[type="checkbox"][name="modules[]"]').on('change', function () {
        const container = $(this).closest('.select-subwrapper');
        const allInGroup = container.find('input[type="checkbox"][name="modules[]"]').length;
        const checkedInGroup = container.find('input[type="checkbox"][name="modules[]"]:checked').length;

        // Set group select-all checkbox based on state
        container.find('.check-all').prop('checked', allInGroup === checkedInGroup);

        // Update global select-all status
        updateGlobalSelectAll();
    });

    // Function to update global select-all checkbox
    function updateGlobalSelectAll() {
        const all = $('input[type="checkbox"][name="modules[]"]').length;
        const checked = $('input[type="checkbox"][name="modules[]"]:checked').length;
        $('#select-all').prop('checked', all === checked);
    }
});
</script>
<?php $__env->stopPush(); ?>



<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/custom-role/create.blade.php ENDPATH**/ ?>