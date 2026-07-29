

<?php $__env->startSection('title',translate('messages.deliverymen')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/delivery-man.png')); ?>" class="w--26" alt="">
                </span>
                <span><?php echo e(translate('messages.deliveryman')); ?></span>
            </h1>
        </div>
        <!-- End Page Header -->
        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header py-2 border-0">
                <div class="search--button-wrapper justify-content-end">
                    <h5 class="card-title mr-auto">
                        <?php echo e(translate('messages.deliveryman_list')); ?><span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($deliveryMen->total()); ?></span>
                    </h5>
                    <div class="min--200">
                        <select name="filter" class="form-control js-select2-custom set-filter" data-filter="filter"
                        data-url="<?php echo e(url()->full()); ?>">
                            <option  value="all"><?php echo e(translate('messages.All_Types')); ?></option>
                            <option <?php echo e(request()?->get('filter') == 'active' ? 'selected' : ''); ?>  value="active"><?php echo e(translate('messages.Online')); ?></option>
                            <option  <?php echo e(request()?->get('filter') == 'inactive' ? 'selected' : ''); ?> value="inactive"><?php echo e(translate('messages.Offline')); ?></option>
                            <option <?php echo e(request()?->get('filter') == 'blocked' ? 'selected' : ''); ?>  value="blocked"><?php echo e(translate('messages.Suspended')); ?></option>
                        </select>
                    </div>
                    <div class="min--200">
                        <select name="job_type" class="form-control js-select2-custom set-filter" data-filter="job_type"
                        data-url="<?php echo e(url()->full()); ?>">
                            <option  value="all"><?php echo e(translate('messages.All_Job_Types')); ?></option>
                            <option  <?php echo e(request()?->get('job_type') == 'freelancer' ? 'selected' : ''); ?> value="freelancer"><?php echo e(translate('messages.Freelancer')); ?></option>
                            <option <?php echo e(request()?->get('job_type') == 'salary_base' ? 'selected' : ''); ?>  value="salary_base"><?php echo e(translate('messages.Salary_Base')); ?></option>
                        </select>
                    </div>
                    <?php if(!isset(auth('admin')->user()->zone_id)): ?>
                    <div class="min--200">
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

                    <form class="search-form">
                        <div class="input-group input--group">
                            <input id="datatableSearch_" type="search" name="search" class="form-control h--45px"
                            placeholder="<?php echo e(translate('ex:_DM_name_email_or_phone')); ?>" value="<?php echo e(request()->get('search')); ?>" aria-label="Search" required>
                            <button type="submit" class="btn btn--secondary h--45px"><i class="tio-search"></i></button>

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
                            <a id="export-excel" class="dropdown-item" href="<?php echo e(route('admin.users.delivery-man.export', ['type'=>'excel',request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                    alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item" href="<?php echo e(route('admin.users.delivery-man.export', ['type'=>'csv',request()->getQueryString()])); ?>">
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
                        <th class="border-0 text-capitalize"><?php echo e(translate('messages.dm_list_initial_deposit')); ?></th>
                        <th class="border-0 text-capitalize"><?php echo e(translate('messages.dm_list_reg_fee_remaining')); ?></th>
                        <th class="border-0 text-capitalize"><?php echo e(translate('messages.Total_Completed_Orders')); ?></th>
                        <th class="border-0 text-capitalize"><?php echo e(translate('messages.availability_status')); ?></th>
                        <th class="border-0 text-capitalize"><?php echo e(translate('messages.Status')); ?></th>
                        <th class="border-0 text-center text-capitalize"><?php echo e(translate('messages.action')); ?></th>
                    </tr>
                    </thead>

                    <tbody id="set-rows">
                    <?php $__currentLoopData = $deliveryMen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$dm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+$deliveryMen->firstItem()); ?></td>
                            <td>
                                <a class="table-rest-info max-w-400px min-w-220" href="<?php echo e(route('admin.users.delivery-man.preview',[$dm['id']])); ?>">
                                    <img class="onerror-image" data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
                                    src="<?php echo e($dm['image_full_url']); ?>"
                                    alt="<?php echo e($dm['f_name']); ?> <?php echo e($dm['l_name']); ?>">
                                    <div class="info">
                                        <h5 class="text-hover-primary line--limit-2 text-wrap mb-0"><?php echo e($dm['f_name'].' '.$dm['l_name']); ?></h5>
                                        <span class="d-block text-body">
                                            <span class="rating">
                                            <i class="tio-star"></i> <?php echo e(count($dm->rating)>0?number_format($dm->rating[0]->average, 1, '.', ' '):0); ?>

                                            </span>
                                        </span>
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
                                <?php ($rf = $dm->registrationFee); ?>
                                <?php if($rf && $rf->manual_confirmed): ?>
                                    <span class="text--title font-medium"><?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?><?php echo e(number_format($rf->manual_paid_amount, 2)); ?></span>
                                <?php elseif($rf): ?>
                                    <span class="badge badge-soft-warning"><?php echo e(translate('messages.pending')); ?></span>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($rf ?? null): ?>
                                    <span class="text--title font-medium"><?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?><?php echo e(number_format($rf->wallet_remaining_due, 2)); ?></span>
                                    <?php if($rf->completed_at): ?>
                                        <span class="badge badge-soft-success ml-1"><?php echo e(translate('messages.completed')); ?></span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a class="deco-none" href="<?php echo e(route('admin.users.delivery-man.preview',['id'=> $dm['id'],'tab' => 'transaction' ])); ?>"><?php echo e(count($dm['order_transaction'])); ?></a>
                            </td>
                            <td>
                                <div>
                                    <?php echo e(translate('messages.currently_assigned_orders')); ?> : <?php echo e($dm->current_orders); ?>

                                </div>
                                <div>
                                    <?php echo e(translate('messages.active_status')); ?> :
                                    <?php if($dm->application_status == 'approved'): ?>
                                        <?php if($dm->active): ?>
                                        <strong class="text-capitalize text-primary"><?php echo e(translate('messages.online')); ?></strong>
                                        <?php else: ?>
                                        <strong class="text-capitalize text-secondary"><?php echo e(translate('messages.offline')); ?></strong>
                                        <?php endif; ?>
                                    <?php elseif($dm->application_status == 'denied'): ?>
                                        <strong class="text-capitalize text-danger"><?php echo e(translate('messages.denied')); ?></strong>
                                    <?php else: ?>
                                        <strong class="text-capitalize text-info"><?php echo e(translate('messages.pending')); ?></strong>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <td>
                                <?php if($dm->status == 1): ?>
                                <strong class="text-capitalize text-primary"><?php echo e(translate('messages.Active')); ?></strong>
                                <?php else: ?>
                                <strong class="text-capitalize text-danger"><?php echo e(translate('messages.Suspended')); ?></strong>

                                <?php endif; ?>

                            </td>
                            <td>
                                <div class="btn--container justify-content-center">
                                    <a class="btn action-btn btn--warning btn-outline-warning"
                                            href="<?php echo e(route('admin.users.delivery-man.preview',[$dm['id']])); ?>"
                                            title="<?php echo e(translate('messages.view')); ?>"><i
                                                class="tio-visible-outlined"></i>
                                        </a>
                                    <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route('admin.users.delivery-man.edit',[$dm['id']])); ?>" title="<?php echo e(translate('messages.edit')); ?>"><i class="tio-edit"></i>
                                        </a>
                                        <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:" data-id="delivery-man-<?php echo e($dm['id']); ?>" data-message="<?php echo e(translate('Want to remove this deliveryman ?')); ?>" title="<?php echo e(translate('messages.delete')); ?>"><i class="tio-delete-outlined"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.users.delivery-man.delete',[$dm['id']])); ?>" method="post" id="delivery-man-<?php echo e($dm['id']); ?>">
                                        <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                    </form>
                                </div>
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

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script>
        "use strict";
        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            let datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

            $('#column1_search').on('keyup', function () {
                datatable
                    .columns(1)
                    .search(this.value)
                    .draw();
            });

            $('#column2_search').on('keyup', function () {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });

            $('#column3_search').on('keyup', function () {
                datatable
                    .columns(3)
                    .search(this.value)
                    .draw();
            });

            $('#column4_search').on('keyup', function () {
                datatable
                    .columns(4)
                    .search(this.value)
                    .draw();
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                let select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });

        $('#search-form').on('submit', function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '<?php echo e(route('admin.users.delivery-man.search')); ?>',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('#itemCount').html(data.count);
                    $('.page-area').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/delivery-man/list.blade.php ENDPATH**/ ?>