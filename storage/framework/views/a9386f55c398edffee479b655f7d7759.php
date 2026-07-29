<?php $__env->startSection('title',translate('Store List')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title"><i class="tio-filter-list"></i> <?php echo e(translate('messages.stores')); ?> <span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($stores->total()); ?></span></h1>
            <div class="page-header-select-wrapper">
            </div>
        </div>
        <!-- End Page Header -->


        <!-- Resturent Card Wrapper -->
        <div class="row g-3 mb-3">
            <div class="col-xl-3 col-sm-6">
                <div class="resturant-card card--bg-1">
                    <h4 class="title"><?php echo e($total_store); ?></h4>
                    <span class="subtitle"><?php echo e(translate('messages.total_stores')); ?></span>
                    <img class="resturant-icon" src="<?php echo e(asset('/public/assets/admin/img/total-store.png')); ?>" alt="store">
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="resturant-card card--bg-2">
                    <h4 class="title"><?php echo e($active_stores); ?></h4>
                    <span class="subtitle"><?php echo e(translate('messages.active_stores')); ?></span>
                    <img class="resturant-icon" src="<?php echo e(asset('/public/assets/admin/img/active-store.png')); ?>" alt="store">
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="resturant-card card--bg-3">
                    <h4 class="title"><?php echo e($inactive_stores); ?></h4>
                    <span class="subtitle"><?php echo e(translate('messages.inactive_stores')); ?></span>
                    <img class="resturant-icon" src="<?php echo e(asset('/public/assets/admin/img/close-store.png')); ?>" alt="store">
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="resturant-card card--bg-4">
                    <h4 class="title"><?php echo e($recent_stores); ?></h4>
                    <span class="subtitle"><?php echo e(translate('messages.newly_joined_stores')); ?></span>
                    <img class="resturant-icon" src="<?php echo e(asset('/public/assets/admin/img/add-store.png')); ?>" alt="store">
                </div>
            </div>
        </div>
        <!-- Resturent Card Wrapper -->
        <!-- Transaction Information -->
        <ul class="transaction--information text-uppercase">
            <li class="text--info">
                <i class="tio-document-text-outlined"></i>
                <div>
                    <span><?php echo e(translate('messages.total_transactions')); ?></span> <strong><?php echo e($total_transaction); ?></strong>
                </div>
            </li>

            <?php if(auth('admin')->user()->role_id == 1): ?>
                <li class="seperator"></li>
                <li class="text--success">
                    <i class="tio-checkmark-circle-outlined success--icon"></i>
                    <div>
                        <span><?php echo e(translate('messages.commission_earned')); ?></span> <strong><?php echo e(\App\CentralLogics\Helpers::format_currency($comission_earned)); ?></strong>
                    </div>
                </li>
            <?php endif; ?>

            <li class="seperator"></li>
            <li class="text--danger">
                <i class="tio-atm"></i>
                <div>
                    <span><?php echo e(translate('messages.total_store_withdraws')); ?></span> <strong><?php echo e(\App\CentralLogics\Helpers::format_currency($store_withdraws)); ?></strong>
                </div>
            </li>
        </ul>
        <!-- Transaction Information -->

        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header py-2">
                <div class="search--button-wrapper">
                    <h5 class="card-title"><?php echo e(translate('messages.stores_list')); ?></h5>

                <?php if(!isset(auth('admin')->user()->zone_id)): ?>
                <div class="select-item min--280">
                    <select name="zone_id" class="form-control js-select2-custom set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="zone_id">
                        <option value="" <?php echo e(!request('zone_id')?'selected':''); ?>><?php echo e(translate('messages.All_Zones')); ?></option>
                        <?php $__currentLoopData = \App\Models\Zone::orderBy('name')->get(['id','name']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option
                                value="<?php echo e($z['id']); ?>" <?php echo e(isset($zone) && $zone->id == $z['id']?'selected':''); ?>>
                                <?php echo e($z['name']); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <?php endif; ?>
                    <form class="search-form">
                                    <!-- Search -->
                        <div class="input-group input--group">
                            <input id="datatableSearch_" type="search" value="<?php echo e(request()?->search ?? null); ?>" name="search" class="form-control"
                                    placeholder="<?php echo e(translate('ex_:_Search_Store_Name')); ?>" aria-label="<?php echo e(translate('messages.search')); ?>" >
                            <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>

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
                            <a id="export-excel" class="dropdown-item" href="<?php echo e(route('admin.store.export', ['type'=>'excel',request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                    alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item" href="<?php echo e(route('admin.store.export', ['type'=>'csv',request()->getQueryString()])); ?>">
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
                        <th class="border-0"><?php echo e(translate('sl')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.store_information')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.owner_information')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.zone')); ?></th>
                        <th class="text-uppercase border-0"><?php echo e(translate('messages.featured')); ?></th>
                        <th class="text-uppercase border-0"><?php echo e(translate('messages.status')); ?></th>
                        <th class="text-center border-0"><?php echo e(translate('messages.action')); ?></th>
                    </tr>
                    </thead>

                    <tbody id="set-rows">
                    <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+$stores->firstItem()); ?></td>
                            <td>
                                <div>
                                    <a href="<?php echo e(route('admin.store.view', $store->id)); ?>" class="table-rest-info" alt="view store">
                                    <img class="img--60 circle onerror-image" data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"

                                            src="<?php echo e($store['logo_full_url'] ?? asset('public/assets/admin/img/160x160/img1.jpg')); ?>"

                                            >
                                        <div class="info"><div title="<?php echo e($store?->name); ?>" class="text--title">
                                            <?php echo e(Str::limit($store->name,20,'...')); ?>

                                            </div>
                                            <div class="font-light">
                                                <?php echo e(translate('messages.id')); ?>:<?php echo e($store->id); ?>

                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </td>

                            <td>
                                <span title="<?php echo e($store?->vendor?->f_name.' '.$store?->vendor?->l_name); ?>" class="d-block font-size-sm text-body">
                                    <?php echo e(Str::limit($store->vendor->f_name.' '.$store->vendor->l_name,20,'...')); ?>

                                </span>
                                <div>
                                    <a href="tel:<?php echo e($store['phone']); ?>">
                                        <?php echo e($store['phone']); ?>

                                    </a>
                                </div>
                            </td>
                            <td>
                                <?php echo e($store->zone?$store->zone->name:translate('messages.zone_deleted')); ?>

                            </td>
                            <td>
                                <label class="toggle-switch toggle-switch-sm" for="featuredCheckbox<?php echo e($store->id); ?>">
                                    <input type="checkbox" data-url="<?php echo e(route('admin.store.featured',[$store->id,$store->featured?0:1])); ?>" class="toggle-switch-input redirect-url" id="featuredCheckbox<?php echo e($store->id); ?>" <?php echo e($store->featured?'checked':''); ?>>
                                    <span class="toggle-switch-label">
                                        <span class="toggle-switch-indicator"></span>
                                    </span>
                                </label>
                            </td>

                            <td>
                                <?php if(isset($store->vendor->status)): ?>
                                    <?php if($store->vendor->status): ?>
                                    <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox<?php echo e($store->id); ?>">
                                        <input type="checkbox" data-url="<?php echo e(route('admin.store.status',[$store->id,$store->status?0:1])); ?>" data-message="<?php echo e(translate('messages.you_want_to_change_this_store_status')); ?>" class="toggle-switch-input status_change_alert" id="stocksCheckbox<?php echo e($store->id); ?>" <?php echo e($store->status?'checked':''); ?>>
                                        <span class="toggle-switch-label">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                    </label>
                                    <?php else: ?>
                                    <span class="badge badge-soft-danger"><?php echo e(translate('messages.denied')); ?></span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="badge badge-soft-danger"><?php echo e(translate('messages.pending')); ?></span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <div class="btn--container justify-content-center">
                                    <a class="btn action-btn btn--warning btn-outline-warning"
                                            href="<?php echo e(route('admin.store.view', $store->id)); ?>"
                                            title="<?php echo e(translate('messages.view')); ?>"><i
                                                class="tio-visible-outlined"></i>
                                        </a>
                                    <a class="btn action-btn btn--primary btn-outline-primary"
                                    href="<?php echo e(route('admin.store.edit',[$store['id']])); ?>" title="<?php echo e(translate('messages.edit_store')); ?>"><i class="tio-edit"></i>
                                    </a>
                                    <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:"
                                    data-id="vendor-<?php echo e($store['id']); ?>" data-message="<?php echo e(translate('You want to remove this store')); ?>" title="<?php echo e(translate('messages.delete_store')); ?>"><i class="tio-delete-outlined"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.store.delete',[$store['id']])); ?>" method="post" id="vendor-<?php echo e($store['id']); ?>">
                                        <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

            </div>
                <?php if(count($stores) !== 0): ?>
                <hr>
                <?php endif; ?>
                <div class="page-area">
                    <?php echo $stores->withQueryString()->links(); ?>

                </div>
                <?php if(count($stores) === 0): ?>
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
        $('.status_change_alert').on('click', function (event) {
            let url = $(this).data('url');
            let message = $(this).data('message');
            status_change_alert(url, message, event)
        })

        function status_change_alert(url, message, e) {
            e.preventDefault();
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
        }
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
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/vendor/list.blade.php ENDPATH**/ ?>