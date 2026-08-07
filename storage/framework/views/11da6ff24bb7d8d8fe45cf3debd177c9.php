<?php use App\CentralLogics\Helpers; ?>

<?php $__env->startSection('title', translate('Subscribed Emails')); ?>
<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title mr-3">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/email.png')); ?>" class="w--26" alt="">
                </span>
                <span><?php echo e(translate('messages.Subscriber List')); ?>

                        
                </span>
            </h1>
        </div>
        <!-- Page Header -->
        <div class="card mb-3">
            <div class="card-body">
                <form>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label"><?php echo e(translate('Subscription Date')); ?></label>
                            <div class="position-relative">
                                <span class="tio-calendar icon-absolute-on-right"></span>
                                <input type="text" readonly data-title="<?php echo e(translate('Select_Subscription_Date_Range')); ?>" name="join_date" value="<?php echo e(request()->get('join_date')  ?? null); ?>" class="date-range-picker form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><?php echo e(translate('Sort By')); ?></label>
                            <select name="filter" data-placeholder="<?php echo e(translate('messages.Select Mail Sorting Order')); ?>" class="form-control js-select2-custom">
                                <option  value="" selected disabled > <?php echo e(translate('messages.Select Mail Sorting Order')); ?> </option>
                                <option  <?php echo e(request()->get('filter')  == 'oldest'?'selected':''); ?> value="oldest"><?php echo e(translate('messages.Sort by oldest')); ?></option>
                                <option  <?php echo e(request()->get('filter')  == 'latest'?'selected':''); ?> value="latest"><?php echo e(translate('messages.Sort by newest')); ?></option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><?php echo e(translate('Choose First')); ?></label>
                            <input type="number" min="1" name="show_limit" class="form-control" value="<?php echo e(request()->get('show_limit')); ?>" class="form-control" placeholder="<?php echo e(translate('Ex : 100')); ?>">
                        </div>
                    </div>
                    <div class="btn--container justify-content-end mt-20">
                        <button type="submit" class="btn btn--primary"><?php echo e(translate('Filter')); ?></button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header border-0 py-2">

                <h4><?php echo e(translate('messages.Mail List')); ?>

                    <span class="badge badge-soft-dark ml-2" id="count"><?php echo e($subscribedCustomers->count()); ?></span>
                </h4>


                <div class="search--button-wrapper justify-content-end">
                    <form class="search-form">
                        <div class="input-group input--group">
                            <input type="search" name="search" class="form-control"
                                   placeholder="<?php echo e(translate('ex_: search_email')); ?>"
                                   aria-label="<?php echo e(translate('messages.search')); ?>" value="<?php echo e(request()?->search); ?>">
                            <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                        </div>
                    </form>
                    <?php if(request()->get('search')): ?>
                        <button type="reset" class="btn btn--primary ml-2 location-reload-to-base"
                                data-url="<?php echo e(url()->full()); ?>"><?php echo e(translate('messages.reset')); ?></button>
                    <?php endif; ?>

                    <!-- Unfold -->
                    <div class="hs-unfold mr-2">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle min-height-40"
                           href="javascript:"
                           data-hs-unfold-options='{
                                                        "target": "#usersExportDropdown",
                                                        "type": "css-animation"
                                                    }'>
                            <i class="tio-download-to mr-1"></i> <?php echo e(translate('messages.export')); ?>

                        </a>

                        <div id="usersExportDropdown"
                             class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                            <span class="dropdown-header"><?php echo e(translate('messages.download_options')); ?></span>
                            <a id="export-excel" class="dropdown-item"
                               href="<?php echo e(route('admin.users.customer.subscriber-export', ['type'=>'excel',request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                     src="<?php echo e(asset('public/assets/admin/svg/components/excel.svg')); ?>"
                                     alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item"
                               href="<?php echo e(route('admin.users.customer.subscriber-export', ['type'=>'csv',request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                     src="<?php echo e(asset('public/assets/admin/svg/components/placeholder-csv-format.svg')); ?>"
                                     alt="Image Description">
                                .<?php echo e(translate('messages.csv')); ?>

                            </a>
                        </div>
                    </div>
                    <!-- End Unfold -->
                </div>
            </div>
            <!-- End Header -->

            <?php
            $count= 0;
            ?>
            <div class="card-body p-0">
                <!-- Table -->
                <div class="table-responsive datatable-custom">
                    <table id="datatable"
                        class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table generalData"
                        data-hs-datatables-options='{
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
                            <th class="border-0"><?php echo e(translate('messages.email')); ?></th>
                            <th class="border-0"><?php echo e(translate('messages.created_at')); ?></th>
                        </tr>
                        </thead>
                        <tbody id="set-rows">
                        <?php if(count($subscribedCustomers)): ?>
                            <?php $__currentLoopData = $subscribedCustomers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php echo e((request()->get('show_limit') ?  $count++ : $key  )+ $subscribedCustomers->firstItem()); ?>

                                    </td>

                                    <td>
                                        <?php echo e($customer->email); ?>

                                    </td>
                                    <td>  <?php echo e(Helpers::time_date_format($customer->created_at)); ?> </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        </tbody>

                    </table>
                </div>
                <?php if(count($subscribedCustomers) !== 0): ?>
                    <hr>
                <?php endif; ?>
                <div class="page-area">
                    <?php echo $subscribedCustomers->withQueryString()->links(); ?>

                </div>
                <?php if(count($subscribedCustomers) === 0): ?>
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
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/customer/subscribed-emails.blade.php ENDPATH**/ ?>