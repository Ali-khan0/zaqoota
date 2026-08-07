<?php $__env->startSection('title', translate('Customer List')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title mr-3">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('/public/assets/admin/img/people.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                     <?php echo e(translate('messages.customers')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="card mb-3">
            <div class="card-body">
                <form>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label"><?php echo e(translate('Order Date')); ?></label>
                            <div class="position-relative">
                                <span class="tio-calendar icon-absolute-on-right"></span>
                                <input type="text" data-title="<?php echo e(translate('Select_Order_Date_Range')); ?>" data-startDate="09/04/2024"  data-endDate="09/24/2024" readonly name="order_date" value="<?php echo e(request()->get('order_date')  ?? null); ?>" class="date-range-picker form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><?php echo e(translate('Customer Joining Date')); ?></label>
                            <div class="position-relative">
                                <span class="tio-calendar icon-absolute-on-right"></span>
                                <input type="text" data-title="<?php echo e(translate('Select_Customer_Joining_Date_Range')); ?>" readonly name="join_date" value="<?php echo e(request()->get('join_date') ?? null); ?>" class="date-range-picker form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><?php echo e(translate('Customer status')); ?></label>
                            <select name="filter" data-placeholder="<?php echo e(translate('messages.Select_Status')); ?>" class="form-control js-select2-custom ">
                                <option  value="" selected disabled > <?php echo e(translate('messages.Select_Status')); ?> </option>
                                <option  <?php echo e(request()->get('filter')  == 'all'?'selected':''); ?> value="all"><?php echo e(translate('messages.All_Customers')); ?></option>
                                <option  <?php echo e(request()->get('filter')  == 'active'?'selected':''); ?> value="active"><?php echo e(translate('messages.Active_Customers')); ?></option>
                                <option  <?php echo e(request()->get('filter')  == 'blocked'?'selected':''); ?> value="blocked"><?php echo e(translate('messages.Inactive_Customers')); ?></option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><?php echo e(translate('Sort By')); ?></label>
                            <select name="order_wise"  data-placeholder="<?php echo e(translate('messages.Select Customer Sorting Order')); ?>"

                            class="form-control js-select2-custom">
                                <option value="" selected disabled > <?php echo e(translate('messages.Select Customer Sorting Order')); ?> </option>
                                <option  <?php echo e(request()->get('order_wise')  == 'top'?'selected':''); ?>  value="top"><?php echo e(translate('messages.Sort by order count')); ?></option>
                                <option <?php echo e(request()->get('order_wise')  == 'order_amount'?'selected':''); ?>  value="order_amount"><?php echo e(translate('messages.Sort by order amount')); ?></option>
                                <option <?php echo e(request()->get('order_wise')  == 'oldest'?'selected':''); ?>  value="oldest"><?php echo e(translate('messages.Sort by oldest')); ?></option>
                                <option <?php echo e(request()->get('order_wise')  == 'latest'?'selected':''); ?>  value="latest"><?php echo e(translate('messages.Sort by newest')); ?></option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><?php echo e(translate('Choose First')); ?></label>
                            <input type="number" min="1" name="show_limit" class="form-control" value="<?php echo e(request()->get('show_limit')); ?>" placeholder="<?php echo e(translate('Ex : 100')); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="d-md-block">&nbsp;</label>
                            <div class="btn--container justify-content-end">
                                <button type="submit" class="btn btn--primary"><?php echo e(translate('Filter')); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header border-0  py-2">
                <h3>
                    <?php echo e(translate('messages.customer_list')); ?> <span class="badge badge-soft-dark ml-2" id="count"><?php echo e($customers->total()); ?></span>
                </h3>
                <div class="search--button-wrapper justify-content-end">


                    <form class="search-form">
                        <!-- Search -->
                        <div class="input-group input--group">
                            <input id="datatableSearch_" type="search" name="search" class="form-control min-height-40"
                                value="<?php echo e(request()->get('search')); ?>" placeholder="<?php echo e(translate('ex:_name_email_or_phone')); ?>"
                                aria-label="Search" >
                            <button type="submit" class="btn btn--secondary min-height-40"><i class="tio-search"></i></button>

                        </div>
                        <!-- End Search -->
                    </form>
                    <?php if(request()->get('search')): ?>
                    <button type="reset" class="btn btn--primary ml-2 location-reload-to-base" data-url="<?php echo e(url()->full()); ?>"><?php echo e(translate('messages.reset')); ?></button>
                    <?php endif; ?>

                    <!-- Unfold -->
                    <div class="hs-unfold mr-2">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle min-height-40" href="javascript:;"
                            data-hs-unfold-options='{
                                    "target": "#usersExportDropdown",
                                    "type": "css-animation"
                                }'>
                            <i class="tio-download-to mr-1"></i> <?php echo e(translate('messages.export')); ?>

                        </a>

                        <div id="usersExportDropdown"
                            class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                            <span class="dropdown-header"><?php echo e(translate('messages.download_options')); ?></span>
                            <a id="export-excel" class="dropdown-item" href="<?php echo e(route('admin.customer.export', ['type'=>'excel',request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                    alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item" href="<?php echo e(route('admin.customer.export', ['type'=>'csv',request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                    alt="Image Description">
                                .<?php echo e(translate('messages.csv')); ?>

                            </a>
                        </div>
                    </div>
                </div>
                <!-- End Row -->
            </div>
            <!-- End Header -->

            <div class="card-body p-0">
                <!-- Table -->
                <div class="table-responsive datatable-custom">
                    <table id="datatable"
                        class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table" data-hs-datatables-options='{
                            "columnDefs": [{
                                "targets": [0],
                                "orderable": false
                            }],
                            "order": [],
                            "info": {
                            "totalQty": "#datatableWithPaginationInfoTotalQty"
                            },
                            "search": "#datatableSearch",
                            "entries": "#datatableEntries",
                            "pageLength": 25,
                            "isResponsive": false,
                            "isShowPaging": false,
                            "paging":false
                        }'>
                        <thead class="thead-light">
                            <tr>
                                <th class="border-0">
                                    <?php echo e(translate('sl')); ?>

                                </th>
                                <th class="table-column-pl-0 border-0"><?php echo e(translate('messages.name')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.contact_information')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.total_order')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.total_order_amount')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Joining_date')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.active')); ?>/<?php echo e(translate('messages.inactive')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.actions')); ?></th>
                            </tr>
                        </thead>
                        <?php
                            $count= 0;
                        ?>
                        <tbody id="set-rows">
                            <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr class="">
                                    <td class="">
                                        <?php echo e((request()->get('show_limit') ?  $count++ : $key  )+ $customers->firstItem()); ?>

                                    </td>
                                    <td class="table-column-pl-0">
                                        <div class="d-flex align-items-center gap-2">
                                            <img class="rounded aspect-1-1 object-cover" width="40" data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>" src="<?php echo e($customer->image_full_url); ?>" alt="Image Description">
                                            <a href="<?php echo e(route('admin.users.customer.view', [$customer['id']])); ?>" class="text--hover max-w-400px min-w-220">
                                                <?php echo e($customer['f_name'] ?  $customer['f_name'] . ' ' . $customer['l_name'] : translate('messages.Incomplete_Profile')); ?>

                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <a href="mailto:<?php echo e($customer['email']); ?>">
                                                <?php echo e($customer['email']); ?>

                                            </a>
                                        </div>
                                        <div>
                                            <a href="tel:<?php echo e($customer['phone']); ?>">
                                                <?php echo e($customer['phone']); ?>

                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <label class="badge">
                                            <?php echo e($customer->orders_count); ?>

                                        </label>
                                    </td>
                                    <td>
                                        <label class="badge">
                                            <?php echo e(\App\CentralLogics\Helpers::format_currency( $customer->orders()->sum('order_amount'))); ?>

                                        </label>
                                    </td>
                                    <td>
                                        <label class="badge">
                                            <?php echo e(\App\CentralLogics\Helpers::date_format( $customer->created_at)); ?>

                                        </label>
                                    </td>
                                    <td>
                                        <label class="toggle-switch toggle-switch-sm ml-xl-4" for="stocksCheckbox<?php echo e($customer->id); ?>">
                                            <input type="checkbox" data-url="<?php echo e(route('admin.users.customer.status', [$customer->id, $customer->status ? 0 : 1])); ?>" data-message="<?php echo e($customer->status? translate('messages.you_want_to_block_this_customer'): translate('messages.you_want_to_unblock_this_customer')); ?>"
                                                class="toggle-switch-input status_change_alert" id="stocksCheckbox<?php echo e($customer->id); ?>"
                                                <?php echo e($customer->status ? 'checked' : ''); ?>>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </td>
                                    <td>
                                        <a class="btn action-btn btn--warning btn-outline-warning"
                                            href="<?php echo e(route('admin.users.customer.view', [$customer['id']])); ?>"
                                            title="<?php echo e(translate('messages.view_customer')); ?>"><i
                                                class="tio-visible-outlined"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <!-- End Table -->
            </div>

            <?php if(count($customers) !== 0): ?>
            <hr>
            <?php endif; ?>
            <div class="page-area">
                <?php echo $customers->withQueryString()->links(); ?>

            </div>
            <?php if(count($customers) === 0): ?>
            <div class="empty--data">
                <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                <h5>
                    <?php echo e(translate('no_data_found')); ?>

                </h5>
            </div>
            <?php endif; ?>

        </div>
        <!-- End Card -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/customer-list.js"></script>
    <script>
        "use strict";

        $('.status_change_alert').on('click', function (event) {
            let url = $(this).data('url');
            let message = $(this).data('message');
            status_change_alert(url, message, event)
        })

        function status_change_alert(url, message, e) {
            e.preventDefault();
            Swal.fire({
                title: '<?php echo e(translate('messages.Are you sure?')); ?>',
                text: message,
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#FC6A57',
                cancelButtonText: '<?php echo e(translate('messages.no')); ?>',
                confirmButtonText: '<?php echo e(translate('messages.Yes')); ?>',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    location.href = url;
                }
            })
        }

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/customer/list.blade.php ENDPATH**/ ?>