<?php $__env->startSection('title', translate('offline_Payment_Method')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-4 pb-2">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="<?php echo e(asset('/public/assets/admin/img/3rd-party.png')); ?>" alt="">
                <?php echo e(translate('Offline_Payment_Method_Setup')); ?>

            </h2>
        </div>
        <!-- End Page Title -->

        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div class="js-nav-scroller hs-nav-scroller-horizontal mb-2">
                <!-- Nav -->
                <ul class="nav nav-tabs border-0 nav--tabs">
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(!request()->has('status') ? 'active':''); ?>" href="<?php echo e(route('admin.business-settings.offline')); ?>"><?php echo e(translate('all')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request('status') == 'active' ? 'active':''); ?>" href="<?php echo e(route('admin.business-settings.offline')); ?>?status=active"><?php echo e(translate('active')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request('status') == 'inactive' ? 'active':''); ?>" href="<?php echo e(route('admin.business-settings.offline')); ?>?status=inactive"><?php echo e(translate('inactive')); ?></a>
                    </li>

                </ul>
                <!-- End Nav -->
            </div>
        </div>

        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
                <div class="card">
                    <!-- Data Table Top -->
                    <div class="px-3 py-4">
                        <div class="row g-2 flex-grow-1">
                            <div class="col-sm-8 col-md-6 col-lg-4">
                                <!-- Search -->
                                <form action="<?php echo e(route('admin.business-settings.offline')); ?>" method="GET">
                                    <div class="input-group input-group-custom input-group-merge">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch_" type="search" name="search" class="form-control" placeholder="<?php echo e(translate('search_by_name')); ?>" aria-label="Search by ID or name" value="<?php echo e(request('search')); ?>" required="">
                                        <button type="submit" class="btn btn--primary input-group-text"><?php echo e(translate('search')); ?></button>
                                    </div>
                                </form>
                                <!-- End Search -->
                            </div>
                            <div class="col-sm-4 col-md-6 col-lg-8 d-flex justify-content-end">
                                <a href="<?php echo e(route('admin.business-settings.offline.new')); ?>" class="btn btn--primary"><i class="tio-add"></i> <?php echo e(translate('add_New_Method')); ?></a>
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- End Data Table Top -->

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                                <thead class="thead-light thead-50 text-capitalize">
                                    <tr>
                                        <th><?php echo e(translate('SL')); ?></th>
                                        <th><?php echo e(translate('payment_Method_Name')); ?></th>
                                        <th><?php echo e(translate('payment_Info')); ?></th>
                                        <th><?php echo e(translate('required_Info_From_Customer')); ?></th>
                                        <th><?php echo e(translate('status')); ?></th>
                                        <th class="text-center"><?php echo e(translate('action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($key+$methods->firstItem()); ?></td>
                                            <td><?php echo e($method->method_name); ?></td>
                                            <td>
                                                <div class="d-flex flex-column gap-1">
                                                    <?php $__currentLoopData = $method->method_fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div><?php echo e(ucwords(str_replace('_',' ',$item['input_name']))); ?> : <?php echo e($item['input_data']); ?></div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </td>
                                            <td>
                                                <?php $__currentLoopData = $method->method_informations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $info_key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php echo e(ucwords(str_replace('_',' ',$item['customer_input']))); ?>

                                                    <?php echo e(count($method->method_informations) > ($info_key+1) ?'|':''); ?>

                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </td>

                                            <td>
                                                <label class="toggle-switch toggle-switch-sm">
                                                    <input type="checkbox"
                                                           data-id="status-<?php echo e($method->id); ?>"
                                                           data-type="status"
                                                           data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/wallet-on.png')); ?>"
                                                           data-image-off=" <?php echo e(asset('/public/assets/admin/img/modal/wallet-off.png')); ?>"
                                                           data-title-on="<?php echo e(translate('Want_to_enable_this_offline_payment_method?')); ?>"
                                                           data-title-off="<?php echo e(translate('Want_to_disable_this_offline_payment_method?')); ?>"
                                                           data-text-on="<p><?php echo e(translate('It_will_be_available_on_the_user_views.')); ?></p>"
                                                           data-text-off="<p><?php echo e(translate('It_will_be_hidden_from_the_user_views.')); ?></p>"
                                                           class="status toggle-switch-input dynamic-checkbox"
                                                           id="status-<?php echo e($method->id); ?>" <?php echo e($method->status?'checked':''); ?>>
                                                    <span class="toggle-switch-label">
                                                        <span class="toggle-switch-indicator"></span>
                                                    </span>
                                                </label>
                                                <form action="<?php echo e(route('admin.business-settings.offline.status',['id'=>$method->id])); ?>" method="get" id="status-<?php echo e($method->id); ?>_form">
                                                </form>
                                            </td>

                                            <td>
                                                <div class="btn--container justify-content-center">
                                                    <a class="btn action-btn btn--primary btn-outline-primary" title="Edit" href="<?php echo e(route('admin.business-settings.offline.edit', ['id'=>$method->id])); ?>">
                                                        <i class="tio-edit"></i>
                                                    </a>
                                                    <button class="btn action-btn btn--danger btn-outline-danger form-alert" title="Delete"
                                                            data-id="delete-method_name-<?php echo e($method->id); ?>"
                                                            data-message="<?php echo e(translate('Want_to_delete_this_offline_payment_method')); ?>">
                                                        <i class="tio-delete-outlined"></i>
                                                    </button>

                                                    <form action="<?php echo e(route('admin.business-settings.offline.delete')); ?>" method="post" id="delete-method_name-<?php echo e($method->id); ?>">
                                                        <?php echo csrf_field(); ?>
                                                        <input type="hidden" value="<?php echo e($method->id); ?>" name="id" required>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>

                            <?php if($methods->count() > 0): ?>
                                <div class="p-3 d-flex justify-content-end">
                                    <?php
                                        if (request()->has('status')) {
                                            $paginationLinks = $methods->links();
                                            $modifiedLinks = preg_replace('/href="([^"]*)"/', 'href="$1&status='.request('status').'"', $paginationLinks);
                                        } else {
                                            $modifiedLinks = $methods->links();
                                        }
                                    ?>

                                    <?php echo $modifiedLinks; ?>

                                </div>
                            <?php else: ?>
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
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/offline-payment/index.blade.php ENDPATH**/ ?>