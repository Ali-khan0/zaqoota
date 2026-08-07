

<?php $__env->startSection('title',translate('new_joining_requests')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title"><i class="tio-filter-list"></i> <?php echo e(translate('new_joining_requests')); ?></h1>
            <div class="page-header-select-wrapper">
                <?php if(!isset(auth('admin')->user()->zone_id)): ?>
                <div class="col-sm-auto min--240">
                    <select name="zone_id" class="form-control js-select2-custom set-filter" data-filter="zone_id"
                            data-url="<?php echo e(url()->full()); ?>">
                        <option value="all"><?php echo e(translate('messages.All_Zones')); ?></option>
                        <?php $__currentLoopData = \App\Models\Zone::orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option
                                value="<?php echo e($z['id']); ?>" <?php echo e(isset($zone) && $zone->id == $z['id']?'selected':''); ?>>
                                <?php echo e($z['name']); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <?php endif; ?>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="js-nav-scroller hs-nav-scroller-horizontal mt-2">
                        <!-- Nav -->
                        <ul class="nav nav-tabs mb-3 border-0 nav--tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="<?php echo e(route('admin.users.delivery-man.new')); ?>"   aria-disabled="true"><?php echo e(translate('messages.pending_delivery_man')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('admin.users.delivery-man.deny')); ?>"  aria-disabled="true"><?php echo e(translate('messages.denied_deliveryman')); ?></a>
                            </li>
                        </ul>
                        <!-- End Nav -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header py-2 border-0">
                <div class="search--button-wrapper">
                    <h5 class="card-title">
                        <?php echo e(translate('messages.deliveryman_list')); ?> <span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($deliveryMen->total()); ?></span>
                    </h5>
                    <form  class="search-form">
                            <div class="input-group input--group">
                                <input id="datatableSearch_" type="search" id="search" name="search_by" class="form-control"
                                        placeholder="<?php echo e(translate('ex:_DM_name_email_or_phone')); ?>" value="<?php echo e(request()?->search_by); ?>" aria-label="<?php echo e(translate('messages.search')); ?>" >
                                <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                            </div>
                        </form>
                        <?php if(request()->get('search_by')): ?>
                        <button type="reset" class="btn btn--primary ml-2 location-reload-to-base" data-url="<?php echo e(url()->full()); ?>"><?php echo e(translate('messages.reset')); ?></button>
                        <?php endif; ?>
                </div>
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table id="columnSearchDatatable"
                        class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                        data-hs-datatables-options='{
                            "order": [],
                            "orderCellsTop": true,
                            "paging":false
                        }'>
                    <thead class="thead-light">
                    <tr>
                        <th class="border-0 text-capitalize"><?php echo e(translate('sl')); ?></th>
                        <th class="border-0 text-capitalize"><?php echo e(translate('messages.name')); ?></th>
                        <th class="border-0 text-capitalize"><?php echo e(translate('messages.contact_info')); ?></th>
                        <th class="border-0 text-capitalize"><?php echo e(translate('messages.zone')); ?></th>
                        <th class="border-0 text-capitalize"><?php echo e(translate('messages.job_type')); ?></th>
                        <th class="border-0 text-capitalize"><?php echo e(translate('messages.join_request_date')); ?></th>
                        <th class="border-0 text-center text-capitalize"><?php echo e(translate('messages.action')); ?></th>
                    </tr>
                    </thead>

                    <tbody id="set-rows">
                    <?php $__currentLoopData = $deliveryMen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$dm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+$deliveryMen->firstItem()); ?></td>
                            <td>
                                <a class="table-rest-info" href="<?php echo e(route('admin.users.delivery-man.preview',[$dm['id']])); ?>">
                                    <img class="onerror-image" data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
                                    src="<?php echo e($dm['image_full_url']); ?>"
                                    alt="<?php echo e($dm['f_name']); ?> <?php echo e($dm['l_name']); ?>">
                                    <div class="info">
                                        <h5 class="text-hover-primary mb-0"><?php echo e($dm['f_name'].' '.$dm['l_name']); ?></h5>
                                    </div>
                                </a>
                            </td>
                            <td>
                                <a class="deco-none" href="tel:<?php echo e($dm['phone']); ?>"><?php echo e($dm['phone']); ?></a>
                            </td>
                            <td>
                                <?php if($dm->zone): ?>
                                <label class="text--title font-medium mb-0"><?php echo e($dm->zone->name); ?></label>
                                <?php else: ?>
                                <label class="text--title font-medium mb-0"><?php echo e(translate('messages.zone_deleted')); ?></label>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php echo e($dm->earning ==  1 ?  translate('messages.freelancer')  : translate('messages.salary_based')); ?>

                            </td>
                            <td>
                                <?php echo e(\App\CentralLogics\Helpers::time_date_format($dm->created_at )); ?>


                            </td>
                            <td>
                                <?php if($dm->application_status == 'approved'): ?>

                                <?php else: ?>
                                <div class="col-md-12">
                                    <div class="btn--container justify-content-end">
                                        <a class="btn action-btn btn--primary btn-outline-primary js-dm-open-approve-modal" data-toggle="tooltip" data-placement="top"
                                        data-original-title="<?php echo e(translate('messages.approve')); ?>" data-dm-id="<?php echo e($dm['id']); ?>"
                                            href="javascript:"><i class="tio-done font-weight-bold"></i> </a>
                                        <a class="btn action-btn btn--primary btn-outline-primary"  data-toggle="tooltip" data-placement="top" data-original-title="<?php echo e(translate('messages.edit')); ?>" href="<?php echo e(route('admin.users.delivery-man.edit',[$dm['id']])); ?>" ><i class="tio-edit"></i>
                                        </a>
                                        <?php if($dm->application_status !='denied'): ?>
                                        <a class="btn action-btn btn--danger btn-outline-danger request-alert" data-toggle="tooltip" data-placement="top"
                                        data-original-title="<?php echo e(translate('messages.deny')); ?>" data-url="<?php echo e(route('admin.users.delivery-man.application',[$dm['id'],'denied'])); ?>" data-message="<?php echo e(translate('messages.you_want_to_deny_this_application')); ?>"
                                            href="javascript:"><i class="tio-clear font-weight-bold"></i></a>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
                <?php if(count($deliveryMen) !== 0): ?>
                <hr>
                <?php endif; ?>
                <div class="page-area">
                    <?php echo $deliveryMen->links(); ?>

                </div>
                <?php if(count($deliveryMen) === 0): ?>
                <div class="empty--data">
                    <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                    <h5>
                        <?php echo e(translate('no_data_found')); ?>

                    </h5>
                </div>
                <?php endif; ?>
            <!-- End Table -->
        </div>
        <!-- End Card -->
    </div>

    <?php echo $__env->make('admin-views.delivery-man.partials._dm_approve_modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/deliveryman-new-denied-list.js"></script>
    <script>
        "use strict";
        $(document).on('click', '.js-dm-open-approve-modal', function (e) {
            e.preventDefault();
            $('#dm_approve_dm_id').val($(this).data('dm-id'));
            $('#dmApproveModal').modal('show');
        });
        function request_alert(url, message) {
            Swal.fire({
                title: '<?php echo e(translate('messages.are_you_sure')); ?>',
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
                    location.href = url;
                }
            })
        }
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/delivery-man/new.blade.php ENDPATH**/ ?>