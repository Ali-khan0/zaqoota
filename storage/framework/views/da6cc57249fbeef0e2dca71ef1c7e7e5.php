<?php $__env->startSection('title',translate('messages.Delivery Man Preview')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title text-break">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/delivery-man.png')); ?>" class="w--26" alt="">
                </span>
                <span><?php echo e($deliveryMan['f_name'].' '.$deliveryMan['l_name']); ?></span>
            </h1>
            <div class="">
                <?php echo $__env->make('admin-views.delivery-man.partials._tab_menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
        <!-- End Page Header -->

        <div class="card mb-3 mb-lg-5 mt-2">
            <div class="card-header border-0 py-2">
                <div class="search--button-wrapper">
                    <h5 class="card-title">
                        <?php echo e(translate('Total_Disbursements')); ?> <span class="badge badge-soft-secondary ml-2" id="countItems"><?php echo e($disbursements->total()); ?></span>
                    </h5>
                    <form class="search-form">
                        <!-- Search -->
                        <div class="input--group input-group input-group-merge input-group-flush">
                            <input class="form-control" value="<?php echo e(request()?->search  ?? null); ?>" placeholder="<?php echo e(translate('search_by_disbursement_id')); ?>" name="search">
                            <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                        </div>
                        <!-- End Search -->
                    </form>
                    <!-- Static Export Button -->
                    <div class="hs-unfold ml-3">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle btn export-btn btn-outline-primary btn--primary font--sm" href="javascript:;"
                           data-hs-unfold-options='{
                            "target": "#usersExportDropdown",
                            "type": "css-animation"
                        }'>
                            <i class="tio-download-to mr-1"></i> <?php echo e(translate('messages.export')); ?>

                        </a>
                        <div id="usersExportDropdown"
                             class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                            <span class="dropdown-header"><?php echo e(translate('messages.download_options')); ?></span>
                            <a id="export-excel" class="dropdown-item" href="<?php echo e(route('admin.users.delivery-man.disbursement-export', ['id'=>$deliveryMan->id,'type'=>'excel',request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2" src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg" alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item" href="<?php echo e(route('admin.users.delivery-man.disbursement-export', ['id'=>$deliveryMan->id,'type'=>'excel',request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2" src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg" alt="Image Description">
                                <?php echo e(translate('messages.csv')); ?>

                            </a>
                        </div>
                    </div>
                    <!-- Static Export Button -->

                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-thead-bordered table-align-middle card-table">
                        <thead>
                        <tr>
                            <th><?php echo e(translate('sl')); ?></th>
                            <th><?php echo e(translate('id')); ?></th>
                            <th><?php echo e(translate('Disburse_Amount')); ?></th>
                            <th><?php echo e(translate('Payment_method')); ?></th>
                            <th><?php echo e(translate('status')); ?></th>
                            <th>
                                <div class="text-center">
                                    <?php echo e(translate('action')); ?>

                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $disbursements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $disbursement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <span class="font-weight-bold"><?php echo e($key+$disbursements->firstItem()); ?></span>
                                </td>
                                <td>
                                    #<?php echo e($disbursement->disbursement_id); ?>

                                </td>
                                <td>
                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($disbursement['disbursement_amount'])); ?>

                                </td>
                                <td>
                                    <div>
                                        <?php echo e($disbursement?->withdraw_method?->method_name ?? translate('messages.N/A')); ?>

                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-soft-primary"><?php echo e($disbursement->status); ?></span>
                                </td>
                                <td>
                                    <div class="btn--container justify-content-center">
                                        <a class="btn btn-sm btn--primary btn-outline-primary action-btn" data-toggle="modal" data-target="#payment-info-<?php echo e($disbursement->id); ?>" title="View Details">
                                            <i class="tio-visible"></i>
                                        </a>
                                    </div>
                                </td>
                                <div class="modal fade" id="payment-info-<?php echo e($disbursement->id); ?>">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header pb-4">
                                                <button type="button" class="payment-modal-close btn-close border-0 outline-0 bg-transparent" data-dismiss="modal">
                                                    <i class="tio-clear"></i>
                                                </button>
                                                <div class="w-100 text-center">
                                                    <h2 class="mb-2"><?php echo e(translate('Payment_Information')); ?></h2>
                                                    <div>
                                                        <span class="mr-2"><?php echo e(translate('Disbursement_ID')); ?></span>
                                                        <strong>#<?php echo e($disbursement->disbursement_id); ?></strong>
                                                    </div>
                                                    <div class="mt-2">
                                                        <span class="mr-2"><?php echo e(translate('status')); ?></span>
                                                        <span class="badge badge-soft-primary"><?php echo e($disbursement->status); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card shadow--card-2">
                                                    <div class="card-body">
                                                        <div class="d-flex flex-wrap payment-info-modal-info p-xl-4">
                                                            <div class="item">
                                                                <h5><?php echo e(translate('Delivery_Man_Information')); ?></h5>
                                                                <ul class="item-list">
                                                                    <li class="d-flex flex-wrap">
                                                                        <span class="name"><?php echo e(translate('name')); ?></span>
                                                                        <span>:</span>
                                                                        <strong><?php echo e($disbursement->delivery_man->f_name.' '.$disbursement->delivery_man->l_name); ?></strong>
                                                                    </li>
                                                                    <li class="d-flex flex-wrap">
                                                                        <span class="name"><?php echo e(translate('contact')); ?></span>
                                                                        <span>:</span>
                                                                        <strong><?php echo e($disbursement?->delivery_man?->phone); ?></strong>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="item">

                                                            </div>
                                                            <div class="item w-100">
                                                                <h5><?php echo e(translate('Account_Information')); ?></h5>
                                                                <ul class="item-list">
                                                                    <li class="d-flex flex-wrap">
                                                                        <span class="name"><?php echo e(translate('payment_method')); ?></span>
                                                                        <strong><?php echo e($disbursement?->withdraw_method?->method_name ?? translate('messages.N/A')); ?></strong>
                                                                    </li>
                                                                    <li class="d-flex flex-wrap">
                                                                        <span class="name"><?php echo e(translate('amount')); ?></span>
                                                                        <strong><?php echo e(\App\CentralLogics\Helpers::format_currency($disbursement['disbursement_amount'])); ?></strong>
                                                                    </li>
                                                                    <?php if($disbursement?->withdraw_method?->method_fields): ?>
                                                                    <?php $__empty_1 = true; $__currentLoopData = json_decode($disbursement->withdraw_method?->method_fields, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                        <li class="d-flex flex-wrap">
                                                                            <span class="name"><?php echo e(translate($key)); ?></span>
                                                                            <strong><?php echo e($item); ?></strong>
                                                                        </li>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                                                    <?php endif; ?>

                                                                    <?php endif; ?>

                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <?php if(count($disbursements) === 0): ?>
                        <div class="empty--data">
                             <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                            <h5>
                                <?php echo e(translate('no_data_found')); ?>

                            </h5>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="page-area px-4 pb-3">
                <div class="d-flex align-items-center justify-content-end">
                    <div>
                        <?php echo $disbursements->links(); ?>

                    </div>
                </div>
            </div>
        </div>
        <!-- End Card -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/delivery-man/view/disbursement.blade.php ENDPATH**/ ?>