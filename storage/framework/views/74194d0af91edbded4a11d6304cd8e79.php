<?php $__env->startSection('title',translate('messages.bonuses')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header d-flex flex-wrap align-items-center justify-content-between">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/add.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.wallet_bonus_setup')); ?>

                </span>
            </h1>
            <div class="text--primary-2 d-flex flex-wrap align-items-center" type="button" data-toggle="modal" data-target="#how-it-works">
                <strong class="mr-2"><?php echo e(translate('See_how_it_works!')); ?></strong>
                <div class="blinkings">
                    <i class="tio-info-outined"></i>
                </div>
            </div>
        </div>

        <!-- End Page Header -->
        <div class="row g-2">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo e(route('admin.users.customer.wallet.bonus.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-12">
                                    <?php if($language): ?>
                                    <ul class="nav nav-tabs mb-3 border-0">
                                        <li class="nav-item">
                                            <a class="nav-link lang_link active"
                                            href="#"
                                            id="default-link"><?php echo e(translate('messages.default')); ?></a>
                                        </li>
                                        <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="nav-item">
                                                <a class="nav-link lang_link"
                                                    href="#"
                                                    id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                    <div class="lang_form" id="default-form">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="input-label"
                                                        for="default_title"><?php echo e(translate('messages.Bonus_Title')); ?>

                                                        (<?php echo e(translate('messages.Default')); ?>)   <span class="form-label-secondary text-danger"
                                                        data-toggle="tooltip" data-placement="right"
                                                        data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                        </span>
                                                    </label>
                                                    <input type="text" name="title[]" id="default_title"
                                                        class="form-control" placeholder="<?php echo e(translate('messages.Ex:_EID_Dhamaka')); ?>"
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="input-label"
                                                        for="default_description"><?php echo e(translate('messages.Short_Description')); ?>

                                                        (<?php echo e(translate('messages.Default')); ?>) <span class="form-label-secondary text-danger"
                                                        data-toggle="tooltip" data-placement="right"
                                                        data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                        </span>
                                                    </label>
                                                    <input type="text" name="description[]" id="default_description"
                                                        class="form-control" placeholder="<?php echo e(translate('messages.Ex:_EID_Dhamaka')); ?>"
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="lang[]" value="default">
                                    </div>
                                        <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="d-none lang_form"
                                                id="<?php echo e($lang); ?>-form">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label class="input-label"
                                                                for="<?php echo e($lang); ?>_title"><?php echo e(translate('messages.Bonus_Title')); ?>

                                                                (<?php echo e(strtoupper($lang)); ?>)
                                                            </label>
                                                            <input type="text" name="title[]" id="<?php echo e($lang); ?>_title"
                                                                class="form-control" placeholder="<?php echo e(translate('messages.Ex:_EID_Dhamaka')); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label class="input-label"
                                                                for="<?php echo e($lang); ?>_description"><?php echo e(translate('messages.Short_Description')); ?>

                                                                (<?php echo e(strtoupper($lang)); ?>)
                                                            </label>
                                                            <input type="text" name="description[]" id="<?php echo e($lang); ?>_description"
                                                                class="form-control" placeholder="<?php echo e(translate('messages.Ex:_EID_Dhamaka')); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <div id="default-form">
                                            <div class="form-group">
                                                <label class="input-label"
                                                    for="exampleFormControlInput1"><?php echo e(translate('messages.Bonus_Title')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                                <input type="text" name="title[]" class="form-control"
                                                placeholder="<?php echo e(translate('messages.Ex:_EID_Dhamaka')); ?>">
                                            </div>
                                            <input type="hidden" name="lang[]" value="default">
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-4 col-lg-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.Bonus_Type')); ?> <span class="form-label-secondary text-danger"
                                            data-toggle="tooltip" data-placement="right"
                                            data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                            </span></label>
                                        <select name="bonus_type" class="form-control" id="bonus_type" required>
                                            <option value="percentage"><?php echo e(translate('messages.percentage')); ?> (%)</option>
                                            <option value="amount"><?php echo e(translate('messages.amount')); ?> <?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.Bonus_Amount')); ?>


                                            <span  class="d-none" id='cuttency_symbol'>(<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)
                                            </span>
                                            <span id="percentage">(%)</span>

                                            <span
                                            class="input-label-secondary text--title" data-toggle="tooltip"
                                            data-placement="right"
                                            data-original-title="<?php echo e(translate('Set_the_bonus_amount/percentage_a_customer_will_receive_after_adding_money_to_his_wallet.')); ?>">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                        <span class="form-label-secondary text-danger"
                                        data-toggle="tooltip" data-placement="right"
                                        data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                        </span>

                                        </label>
                                        <input type="number" step="0.01" min="1" max="999999999999.99"  placeholder="<?php echo e(translate('messages.Ex:_100')); ?>"  name="bonus_amount" id="bonus_amount" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.Minimum_Add_Money_Amount')); ?>


                                                         (<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)
                                            <span
                                            class="input-label-secondary text--title" data-toggle="tooltip"
                                            data-placement="right"
                                            data-original-title="<?php echo e(translate('Set_the_minimum_add_money_amount_for_a_customer_to_be_eligible_for_the_bonus.')); ?>">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                        <span class="form-label-secondary text-danger"
                                        data-toggle="tooltip" data-placement="right"
                                        data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                        </span>
                                        </label>
                                        <input type="number" step="0.01" min="1" max="999999999999.99" placeholder="<?php echo e(translate('messages.Ex:_10')); ?>" name="minimum_add_amount" id="minimum_add_amount" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.Maximum_Bonus')); ?> (<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)
                                            <span
                                            class="input-label-secondary text--title" data-toggle="tooltip"
                                            data-placement="right"
                                            data-original-title="<?php echo e(translate('Set_the_maximum_bonus_amount_a_customer_can_receive_for_adding_money_to_his_wallet.')); ?>">
                                            <i class="tio-info-outined"></i>
                                        </span>

                                        </label>
                                        <input type="number" step="0.01" min="1" max="999999999999.99"  placeholder="<?php echo e(translate('messages.Ex:_1000')); ?>" name="maximum_bonus_amount" id="maximum_bonus_amount" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.start_date')); ?><span class="form-label-secondary text-danger"
                                                        data-toggle="tooltip" data-placement="right"
                                                        data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                        </span></label>
                                        <input type="date" name="start_date" class="form-control" id="date_from" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.expire_date')); ?><span class="form-label-secondary text-danger"
                                                        data-toggle="tooltip" data-placement="right"
                                                        data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                        </span></label>
                                        <input type="date" name="end_date" class="form-control" id="date_to" required>
                                    </div>
                                </div>
                            </div>
                            <div class="btn--container justify-content-end">
                                <button type="reset" id="reset_btn" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                                <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.submit')); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header py-2 border-0">
                        <div class="search--button-wrapper">
                            <h5 class="card-title"><?php echo e(translate('messages.bonus_list')); ?><span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($bonuses->total()); ?></span></h5>
                            <form id="dataSearch" class="search-form min--270">
                            <?php echo csrf_field(); ?>
                                <!-- Search -->
                                <div class="input-group input--group">
                                    <input id="datatableSearch" type="search" name="search" class="form-control" placeholder="<?php echo e(translate('messages.Ex_:_Search_by_bonus_title')); ?>" aria-label="<?php echo e(translate('messages.search_here')); ?>">
                                    <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                                </div>
                                <!-- End Search -->
                            </form>
                        </div>
                    </div>
                    <!-- Table -->
                    <div class="table-responsive datatable-custom" id="table-div">
                        <table id="columnSearchDatatable"
                               class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                               data-hs-datatables-options='{
                                "order": [],
                                "orderCellsTop": true,

                                "entries": "#datatableEntries",
                                "isResponsive": false,
                                "isShowPaging": false,
                                "paging":false
                               }'>
                            <thead class="thead-light">
                            <tr>
                                <th class="border-0"><?php echo e(translate('sl')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.bonus_title')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.bonus_info')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.bonus_amount')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.started_on')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.expires_on')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.status')); ?></th>
                                <th class="border-0 text-center"><?php echo e(translate('messages.action')); ?></th>
                            </tr>
                            </thead>

                            <tbody id="set-rows">
                            <?php $__currentLoopData = $bonuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$bonus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key+$bonuses->firstItem()); ?></td>
                                    <td>
                                    <span class="d-block font-size-sm text-body">
                                    <?php echo e(Str::limit($bonus['title'],25,'...')); ?>

                                    </span>
                                    </td>
                                    <td><?php echo e(translate('messages.minimum_add_amount')); ?> -    <?php echo e(\App\CentralLogics\Helpers::format_currency($bonus['minimum_add_amount'])); ?> <br>
                                        <?php echo e(translate('messages.maximum_bonus')); ?> - <?php echo e(\App\CentralLogics\Helpers::format_currency($bonus['maximum_bonus_amount'])); ?></td>
                                    <td><?php echo e($bonus->bonus_type == 'amount'?\App\CentralLogics\Helpers::format_currency($bonus['bonus_amount']): $bonus['bonus_amount'].' (%)'); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($bonus->start_date)->format('d M Y')); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($bonus->end_date)->format('d M Y')); ?></td>
                                    <td>
                                        <label class="toggle-switch toggle-switch-sm" for="bonusCheckbox<?php echo e($bonus->id); ?>">
                                            <input type="checkbox" data-url="<?php echo e(route('admin.users.customer.wallet.bonus.status',[$bonus['id'],$bonus->status?0:1])); ?>" class="toggle-switch-input redirect-url" id="bonusCheckbox<?php echo e($bonus->id); ?>" <?php echo e($bonus->status?'checked':''); ?>>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="btn--container justify-content-center">

                                            <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route('admin.users.customer.wallet.bonus.update',[$bonus['id']])); ?>" title="<?php echo e(translate('messages.edit_bonus')); ?>"><i class="tio-edit"></i>
                                            </a>
                                            <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:" data-id="bonus-<?php echo e($bonus['id']); ?>" data-message="<?php echo e(translate('Want to delete this bonus ?')); ?>" title="<?php echo e(translate('messages.delete_bonus')); ?>"><i class="tio-delete-outlined"></i>
                                            </a>
                                            <form action="<?php echo e(route('admin.users.customer.wallet.bonus.delete',[$bonus['id']])); ?>"
                                            method="post" id="bonus-<?php echo e($bonus['id']); ?>">
                                                <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                        <?php if(count($bonuses) !== 0): ?>
                        <hr>
                        <?php endif; ?>
                        <div class="page-area">
                            <?php echo $bonuses->links(); ?>

                        </div>
                        <?php if(count($bonuses) === 0): ?>
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
            <!-- End Table -->
        </div>
    </div>
    <div class="modal fade" id="how-it-works">
        <div class="modal-dialog status-warning-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" class="tio-clear"></span>
                    </button>
                </div>
                <div class="modal-body pb-5 pt-0">
                    <div class="single-item-slider owl-carousel">
                        <div class="item">
                            <div class="mb-20">
                                <div class="text-center">
                                    <img src="<?php echo e(asset('/public/assets/admin/img/image_127.png')); ?>" alt="" class="mb-20">
                                    <h5 class="modal-title"><?php echo e(translate('Wallet_bonus_is_only_applicable_when_a_customer_add_fund_to_wallet_via_outside_payment_gateway_!')); ?></h5>
                                </div>
                                <ul>
                                    <li>
                                        <?php echo e(translate('Customer_will_get_extra_amount_to_his_/_her_wallet_additionally_with_the_amount_he_/_she_added_from_other_payment_gateways._The_bonus_amount_will_be_deduct_from_admin_wallet_&_will_consider_as_admin_expense.')); ?>

                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="slide-counter"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/wallet-bonus-index.js"></script>
<script>
    "use strict";
    $(document).on('ready', function () {
        // INITIALIZATION OF DATATABLES
        // =======================================================
        let datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'), {
            select: {
                style: 'multi',
                classMap: {
                    checkAll: '#datatableCheckAll',
                    counter: '#datatableCounter',
                    counterInfo: '#datatableCounterInfo'
                }
            },
            language: {
                zeroRecords: '<div class="text-center p-4">' +
                '<img class="w-7rem mb-3" src="<?php echo e(asset('public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="Image Description">' +

                '</div>'
            }
        });
    });

    $('#dataSearch').on('submit', function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '<?php echo e(route('admin.users.customer.wallet.bonus.search')); ?>',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#table-div').html(data.view);
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

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/wallet-bonus/index.blade.php ENDPATH**/ ?>