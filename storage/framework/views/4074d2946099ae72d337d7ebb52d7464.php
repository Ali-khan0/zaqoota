<?php $__env->startSection('title',translate('Campaign view')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title text-break"><?php echo e($campaign->title); ?></h1>
        </div>
        <!-- End Page Header -->
        <!-- Card -->
        <div class="card mb-3 mb-lg-5">
            <!-- Body -->
            <div class="card-body">
                <div class="row align-items-md-center gx-md-5">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <img class="rounded initial--5 onerror-image" src="<?php echo e($campaign->image_full_url); ?>"
                        data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>" alt="Image Description">
                    </div>

                    <div class="col-md-8">
                        <h4><?php echo e(translate('messages.short_description')); ?> : </h4>
                        <p><?php echo e($campaign->description); ?></p>
                        <form action="<?php echo e(route('admin.campaign.addstore',$campaign->id)); ?>" id="store-add-form" method="POST">
                            <?php echo csrf_field(); ?>
                            <!-- Search -->
                            <div class="d-flex flex-wrap g-2">
                                <div class="flex-grow-1">
                                <?php ($allstores=App\Models\Store::Active()->where('module_id', $campaign->module_id)->get()); ?>
                                    <select name="store_id" id="store_id" class="form-control">
                                        <?php $__empty_1 = true; $__currentLoopData = $allstores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php if(!in_array($store->id, $store_ids)): ?>
                                        <option value="<?php echo e($store->id); ?>" ><?php echo e($store->name); ?></option>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <option value=""><?php echo e(translate('messages.no_data_found')); ?></option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn--primary font-weight-regular h--45px"><i class="tio-add-circle-outlined"></i> <?php echo e(translate('messages.add_store')); ?></button>
                                </div>
                            </div>
                            <!-- End Search -->
                        </form>
                    </div>

                </div>
            </div>
            <!-- End Body -->
        </div>
        <!-- End Card -->
        <!-- Card -->
        <div class="card">
            <div class="card-header py-2 border-0">
                <div class="search--button-wrapper">
                    <span class="card-title"></span>
                </div>
            </div>
            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table id="columnSearchDatatable"
                        class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                        data-hs-datatables-options='{
                            "order": [],
                            "orderCellsTop": true
                        }'>
                    <thead class="thead-light">
                        <tr>
                            <th class="border-0"><?php echo e(translate('messages.SL')); ?></th>
                            <th class="border-0 w--15"><?php echo e(translate('messages.logo')); ?></th>
                            <th class="border-0 w--2"><?php echo e(translate('messages.store')); ?></th>
                            <th class="border-0 w--25"><?php echo e(translate('messages.owner')); ?></th>
                            <th class="border-0"><?php echo e(translate('messages.email')); ?></th>
                            <th class="border-0"><?php echo e(translate('messages.phone')); ?></th>
                            <th class="border-0"><?php echo e(translate('messages.status')); ?></th>
                            <th class="border-0"><?php echo e(translate('messages.action')); ?></th>
                        </tr>
                    </thead>

                    <tbody id="set-rows">
                    <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+1); ?></td>
                            <td>
                                <img width="45" class="img--circle onerror-image" data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>" src="<?php echo e($store['logo_full_url']); ?>"
                                >
                            </td>
                            <td>
                                <a href="<?php echo e(route('admin.store.view', $store->id)); ?>" title="<?php echo e($store->name); ?>" class="d-block font-size-sm text-body">
                                    <?php echo e($store->name); ?>

                                </a>
                            </td>
                            <td>
                                <span title=" <?php echo e($store->vendor->f_name.' '.$store->vendor->l_name); ?>" class="d-block font-size-sm text-body">
                                    <?php echo e($store->vendor->f_name.' '.$store->vendor->l_name); ?>

                                </span>
                            </td>
                            <td title="<?php echo e($store->email); ?>">
                                <a href="mailto:<?php echo e($store->email); ?>">
                                <?php echo e($store->email); ?></a>
                            </td>
                            <td title="<?php echo e($store['phone']); ?>">
                                <a href="tel:<?php echo e($store['phone']); ?>">
                                    <?php echo e($store['phone']); ?>

                                </a>
                            </td>
                            <?php ($status = $store->pivot ? $store->pivot->campaign_status : translate('messages.not_found')); ?>
                                <td class="text-capitalize">
                                    <?php if($status == 'pending'): ?>
                                        <span class="badge badge-soft-info">
                                            <?php echo e(translate('messages.not_approved')); ?>

                                        </span>
                                    <?php elseif($status == 'confirmed'): ?>
                                        <span class="badge badge-soft-success">
                                            <?php echo e(translate('messages.confirmed')); ?>

                                        </span>
                                    <?php elseif($status == 'rejected'): ?>
                                        <span class="badge badge-soft-danger">
                                            <?php echo e(translate('messages.rejected')); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-soft-info">
                                            <?php echo e(translate(str_replace('_', ' ', $status))); ?>

                                        </span>
                                    <?php endif; ?>

                                </td>
                            <td>
                                <?php if($store->pivot && $store->pivot->campaign_status == 'pending'): ?>
                                <div class="btn--container justify-content-center">
                                    <a class="btn btn-sm btn--primary btn-outline-primary action-btn status-change-alert"
                                        data-url="<?php echo e(route('admin.campaign.store_confirmation', [$campaign->id, $store->id, 'confirmed'])); ?>" data-message="<?php echo e(translate('messages.you_want_to_confirm_this_store')); ?>"
                                        class="toggle-switch-input" data-toggle="tooltip" data-placement="top" title="<?php echo e(translate('Approve')); ?>">
                                        <i class="tio-done font-weight-bold"></i>
                                    </a>
                                    <a class="btn btn-sm btn--danger btn-outline-danger action-btn status-change-alert" href="javascript:"
                                        data-url="<?php echo e(route('admin.campaign.store_confirmation', [$campaign->id, $store->id, 'rejected'])); ?>" data-message="<?php echo e(translate('messages.you_want_to_reject_this_store')); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(translate('Deny')); ?>">
                                        <i class="tio-clear font-weight-bold"></i>
                                    </a>
                                    <div></div>
                                </div>
                                <?php elseif($store->pivot && $store->pivot->campaign_status == 'rejected'): ?>

                                <div class="btn--container justify-content-center">
                                    <a class="btn btn-sm btn--primary btn-outline-primary action-btn status-change-alert"
                                        data-url="<?php echo e(route('admin.campaign.store_confirmation', [$campaign->id, $store->id, 'confirmed'])); ?>" data-message="<?php echo e(translate('messages.you_want_to_confirm_this_store')); ?>"
                                        class="toggle-switch-input" data-toggle="tooltip" data-placement="top" title="<?php echo e(translate('Approve')); ?>">
                                        <i class="tio-done font-weight-bold"></i>
                                    </a>

                                </div>
                                <?php else: ?>
                                <div class="btn--container justify-content-center">
                                    <a class="btn btn--danger btn-outline-danger action-btn form-alert" href="javascript:"
                                        data-id="campaign-<?php echo e($store->id); ?>" data-message="<?php echo e(translate('messages.want_to_remove_store')); ?>" title="<?php echo e(translate('messages.delete_campaign')); ?>"><i class="tio-delete-outlined"></i>
                                    </a>

                                    <form action="<?php echo e(route('admin.campaign.remove-store',[$campaign->id, $store['id']])); ?>"
                                                    method="GET" id="campaign-<?php echo e($store->id); ?>">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <hr>

                <div class="page-area">
                    <table>
                        <tfoot>
                        <?php echo $stores->links(); ?>

                        </tfoot>
                    </table>
                </div>

            </div>
            <!-- End Table -->
        </div>
        <!-- End Card -->
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script>
        "use strict";
        $('.status-change-alert').on('click', function (event){
            let url = $(this).data('url');
            let message = $(this).data('message');
            event.preventDefault();
            Swal.fire({
                title: '<?php echo e(translate('Are you sure?')); ?>' ,
                text: message,
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#FC6A57',
                cancelButtonText: '<?php echo e(translate('messages.no')); ?>',
                confirmButtonText: '<?php echo e(translate('messages.yes')); ?>',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    location.href=url;
                }
            })
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/campaign/basic/view.blade.php ENDPATH**/ ?>