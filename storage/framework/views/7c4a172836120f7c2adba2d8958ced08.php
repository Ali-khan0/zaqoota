

<?php $__env->startSection('title', translate('Customer Withdraw Request')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <div class="page-header">
            <h1 class="page-header-title mr-3 mb-md-0">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/icons/wallet.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.customer_withdraw_transaction')); ?>

                </span>
            </h1>
        </div>

        <div class="card mt-2">
            <div class="card-header flex-wrap py-2 border-0">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <h4 class="mb-0"><?php echo e(translate('messages.transaction_History')); ?></h4>
                    <span class="badge badge-soft-dark rounded-circle"><?php echo e($withdraw_req->total()); ?></span>
                </div>
                <div class="search--button-wrapper justify-content-end">
                    <form class="search-form theme-style">
                        <div class="input-group input--group">
                            <input id="datatableSearch" name="search" type="search" value="<?php echo e(request()?->search ?? null); ?>" class="form-control h--40px" placeholder="<?php echo e(translate('messages.search_here')); ?>" aria-label="<?php echo e(translate('messages.search_here')); ?>">
                            <button type="submit" class="btn btn--secondary h--40px"><i class="tio-search"></i></button>
                        </div>
                    </form>
                    <?php if(request()->get('search')): ?>
                        <button type="reset" class="btn btn--primary ml-2 location-reload-to-base" data-url="<?php echo e(url()->full()); ?>"><?php echo e(translate('messages.reset')); ?></button>
                    <?php endif; ?>

                    <div class="max-sm-flex-1">
                        <select name="withdraw_status_filter" class="custom-select h--40px py-0 status-filter theme-style">
                            <option value="all" <?php echo e(session()->has('withdraw_status_filter') && session('withdraw_status_filter') == 'all' ? 'selected' : ''); ?>>
                                <?php echo e(translate('messages.all')); ?>

                            </option>
                            <option value="approved" <?php echo e(session()->has('withdraw_status_filter') && session('withdraw_status_filter') == 'approved' ? 'selected' : ''); ?>>
                                <?php echo e(translate('messages.approved')); ?>

                            </option>
                            <option value="denied" <?php echo e(session()->has('withdraw_status_filter') && session('withdraw_status_filter') == 'denied' ? 'selected' : ''); ?>>
                                <?php echo e(translate('messages.denied')); ?>

                            </option>
                            <option value="pending" <?php echo e(session()->has('withdraw_status_filter') && session('withdraw_status_filter') == 'pending' ? 'selected' : ''); ?>>
                                <?php echo e(translate('messages.pending')); ?>

                            </option>
                        </select>
                    </div>

                    <div class="hs-unfold mr-2">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle min-height-40" href="javascript:;"
                            data-hs-unfold-options='{"target": "#usersExportDropdown","type": "css-animation"}'>
                            <i class="tio-download-to mr-1"></i> <?php echo e(translate('messages.export')); ?>

                        </a>
                        <div id="usersExportDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                            <span class="dropdown-header"><?php echo e(translate('messages.download_options')); ?></span>
                            <a id="export-excel" class="dropdown-item" href="<?php echo e(route('admin.transactions.customer.withdraw_export', ['type'=>'excel', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2" src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg" alt="">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item" href="<?php echo e(route('admin.transactions.customer.withdraw_export', ['type'=>'csv', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2" src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg" alt="">
                                .<?php echo e(translate('messages.csv')); ?>

                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="datatable" class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                        <thead class="thead-light">
                        <tr>
                            <th class="border-0"><?php echo e(translate('SL')); ?></th>
                            <th class="border-0"><?php echo e(translate('messages.amount')); ?></th>
                            <th class="border-0"><?php echo e(translate('messages.customer')); ?></th>
                            <th class="border-0"><?php echo e(translate('messages.request_time')); ?></th>
                            <th class="border-0"><?php echo e(translate('messages.status')); ?></th>
                            <th class="border-0"><?php echo e(translate('messages.action')); ?></th>
                        </tr>
                        </thead>
                        <tbody id="set-rows">
                        <?php $__currentLoopData = $withdraw_req; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $wr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td scope="row"><?php echo e($k + $withdraw_req->firstItem()); ?></td>
                                <td><?php echo e(\App\CentralLogics\Helpers::format_currency($wr['amount'])); ?></td>
                                <td>
                                    <?php if($wr->user): ?>
                                        <?php echo e($wr->user->f_name); ?> <?php echo e($wr->user->l_name); ?> (<?php echo e($wr->user->phone); ?>)
                                    <?php else: ?>
                                        <?php echo e(translate('messages.customer_deleted')); ?>

                                    <?php endif; ?>
                                </td>
                                <td><?php echo e(\App\CentralLogics\Helpers::time_date_format($wr->created_at)); ?></td>
                                <td>
                                    <?php if($wr->approved == 0): ?>
                                        <label class="badge badge-soft-primary"><?php echo e(translate('messages.pending')); ?></label>
                                    <?php elseif($wr->approved == 1): ?>
                                        <label class="badge badge-soft-success"><?php echo e(translate('messages.approved')); ?></label>
                                    <?php else: ?>
                                        <label class="badge badge-soft-danger"><?php echo e(translate('messages.denied')); ?></label>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($wr->user): ?>
                                        <a href="#" data-id="<?php echo e($wr->id); ?>" class="btn action-btn btn--warning btn-outline-warning withdraw-info-show">
                                            <i class="tio-visible-outlined"></i>
                                        </a>
                                    <?php else: ?>
                                        <?php echo e(translate('messages.customer_deleted')); ?>

                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php if(count($withdraw_req) !== 0): ?>
                <hr>
            <?php endif; ?>
            <div class="page-area">
                <?php echo $withdraw_req->links(); ?>

            </div>
            <?php if(count($withdraw_req) === 0): ?>
                <div class="empty--data">
                    <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                    <h5><?php echo e(translate('no_data_found')); ?></h5>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="withdraw-info-sidebar-wrap">
        <div class="withdraw-info-sidebar-overlay"></div>
        <div class="withdraw-info-sidebar">
            <div class="d-flex pb-3">
                <span class="circle bg-light withdraw-info-hide cursor-pointer">
                    <i class="tio-clear"></i>
                </span>
            </div>
            <div id="data-view"></div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script>
        "use strict";
        $('.withdraw-info-hide, .withdraw-info-sidebar-overlay').on('click', function () {
            $('.withdraw-info-sidebar, .withdraw-info-sidebar-overlay').removeClass('show');
        });

        $(document).on('click', '.withdraw-info-show', function () {
            let id = $(this).data('id');
            fetch_data(id);
        });

        $(document).on('click', '.show-approve-view', function () {
            let id = $(this).data('id');
            let url = "<?php echo e(route('admin.transactions.customer.withdraw_status', ['data_id'])); ?>";
            url = url.replace('data_id', id);
            let htmlContent = `
            <form class="withdraw_status_form" action="${url}" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mt-5">
                    <h5 class="font-semibold text-center mb-3"><?php echo e(translate('approval_note')); ?></h5>
                    <textarea required name="note" class="form-control" rows="6" maxlength="200" placeholder="<?php echo e(translate('Type_a_note_about_request_approval')); ?>"></textarea>
                    <input name="approved" value="1" type="hidden">
                    <div class="mt-4 d-flex justify-content-center gap-3">
                        <button type="button" data-id="${id}" class="btn btn-soft-secondary min-w-100px withdraw-info-show">
                            <i class="tio-arrow-backward"></i>
                            <?php echo e(translate('back')); ?>

                        </button>
                        <button type="submit" class="btn btn-success set_disable min-w-100px"><?php echo e(translate('complete')); ?></button>
                    </div>
                </div>
            </form>`;
            $('#data-view').empty().html(htmlContent);
        });

        $(document).on('click', '.show-deny-view', function () {
            let id = $(this).data('id');
            let url = "<?php echo e(route('admin.transactions.customer.withdraw_status', ['data_id'])); ?>";
            url = url.replace('data_id', id);
            let htmlContent = `
            <form class="withdraw_status_form" action="${url}" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mt-5">
                    <h5 class="font-semibold text-center mb-3"><?php echo e(translate('denial_note')); ?></h5>
                    <textarea required name="note" class="form-control" rows="6" maxlength="200" placeholder="<?php echo e(translate('Type_a_note_about_request_denial')); ?>"></textarea>
                    <input name="approved" value="2" type="hidden">
                    <div class="mt-4 d-flex justify-content-center gap-3">
                        <button type="button" data-id="${id}" class="btn btn-soft-secondary min-w-100px withdraw-info-show">
                            <i class="tio-arrow-backward"></i>
                            <?php echo e(translate('back')); ?>

                        </button>
                        <button type="submit" class="btn btn-success set_disable min-w-100px"><?php echo e(translate('complete')); ?></button>
                    </div>
                </div>
            </form>`;
            $('#data-view').empty().html(htmlContent);
        });

        $('.status-filter').on('change', function () {
            let type = $(this).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '<?php echo e(route('admin.transactions.customer.status-filter')); ?>',
                data: { withdraw_status_filter: type },
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function () {
                    location.reload();
                }
            });
        });

        function fetch_data(id) {
            $.ajax({
                url: "<?php echo e(route('admin.transactions.customer.getWithdrawDetails')); ?>" + '?withdraw_id=' + id,
                type: "get",
                beforeSend: function () {
                    $('#data-view').empty();
                    $('#loading').show();
                },
                success: function (data) {
                    $('.withdraw-info-sidebar, .withdraw-info-sidebar-overlay').addClass('show');
                    $("#data-view").append(data.view);
                },
                complete: function () {
                    $('#loading').hide();
                }
            });
        }

        $(document).on('submit', '.withdraw_status_form', function () {
            $(this).find('button[type="submit"]').attr('disabled', true);
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/wallet/customer-withdraw.blade.php ENDPATH**/ ?>