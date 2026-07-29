<?php $__env->startSection('title',translate('messages.Cashback_Offer')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header d-flex flex-wrap align-items-center justify-content-between">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/Create_Cashback_Offer.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.Create_Cashback_Offer')); ?>

                </span>
            </h1>
            
        </div>

        <!-- End Page Header -->
        <div class="row g-2">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body" id="form_data">
                        <form id="cashback-submit" action="<?php echo e(route('admin.users.cashback.store')); ?>" method="POST">
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
                                </div>

                                <div class="col-md-4 col-lg-4 col-sm-6">
                                    <div class="lang_form" id="default-form">
                                        <div class="form-group">
                                            <label class="input-label"
                                                for="default_title"><?php echo e(translate('messages.title')); ?>

                                                (<?php echo e(translate('Default')); ?>)
                                                <span class="form-label-secondary text-danger"
                                                      data-toggle="tooltip" data-placement="right"
                                                      data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                            </span>
                                            </label>
                                            <input required type="text" value="<?php echo e(old('title.0')); ?>" name="title[]" maxlength="254" id="default_title"
                                                class="form-control" placeholder="<?php echo e(translate('messages.Eid_Dhamaka')); ?>" >
                                        </div>
                                        <input type="hidden" name="lang[]" value="default">
                                    </div>
                                        <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="d-none lang_form"
                                                id="<?php echo e($lang); ?>-form">
                                                <div class="form-group">
                                                    <label class="input-label"
                                                        for="<?php echo e($lang); ?>_title"><?php echo e(translate('messages.title')); ?>

                                                        (<?php echo e(strtoupper($lang)); ?>)
                                                    </label>
                                                    <input type="text" name="title[]" maxlength="254"  value="<?php echo e(old('title.'.$key+1)); ?>" id="<?php echo e($lang); ?>_title"
                                                        class="form-control" placeholder="<?php echo e(translate('messages.Eid_Dhamaka')); ?>"
                                                         >
                                                </div>
                                                <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <div id="default-form">
                                            <div class="form-group">
                                                <label class="input-label"
                                                    for="exampleFormControlInput1"><?php echo e(translate('messages.title')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                                <input type="text" name="title[]" maxlength="254" class="form-control"
                                                    placeholder="<?php echo e(translate('messages.Eid_Dhamaka')); ?>">
                                            </div>
                                            <input type="hidden" name="lang[]" value="default">
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="col-md-4 col-lg-4 col-sm-6" id="customer_wise">
                                    <div class="form-group">
                                        <label class="input-label" for="select_customer"><?php echo e(translate('messages.select_customer')); ?>

                                            <span class="form-label-secondary text-danger"
                                                  data-toggle="tooltip" data-placement="right"
                                                  data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                            </span></label>
                                        <select required name="customer_id[]" id="select_customer"
                                            class="form-control js-select2-custom"
                                            multiple="multiple" data-placeholder="<?php echo e(translate('messages.select_customer')); ?>">
                                            <option   value="all"><?php echo e(translate('messages.all')); ?> </option>
                                        <?php $__currentLoopData = \App\Models\User::get(['id','f_name','l_name']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option class="select_customer_option" value="<?php echo e($user->id); ?>" <?php echo e((isset($customer) && is_numeric($customer) && ($customer == $user->id))?'selected':''); ?>><?php echo e($user->f_name.' '.$user->l_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>



                                <div class="col-md-4 col-lg-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.Cashback_Type')); ?> <span class="form-label-secondary text-danger"
                                            data-toggle="tooltip" data-placement="right"
                                            data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                            </span></label>
                                        <select name="cashback_type" class="form-control" id="cashback_type" required>
                                            <option <?php echo e(old('cashback_type')  == 'percentage' ? "selected": ''); ?> value="percentage"><?php echo e(translate('messages.percentage')); ?> (%)</option>
                                            <option <?php echo e(old('cashback_type')  == 'amount' ? "selected": ''); ?>  value="amount"><?php echo e(translate('messages.amount')); ?> <?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.Cashback_Amount')); ?>


                                            <span class="<?php echo e(old('cashback_type')  == 'percentage' ||  old('cashback_type') == null  ? '': 'd-none'); ?> " id="percentage">(%)</span>
                                            <span  class=" <?php echo e(old('cashback_type')  == 'amount' && old('cashback_type') !== null ? '': 'd-none'); ?> " id='cuttency_symbol'>(<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)
                                            </span>

                                            <span
                                            class="input-label-secondary text--title" data-toggle="tooltip"
                                            data-placement="right"
                                            data-original-title="<?php echo e(translate('Set_the_value_of_Cashback_percentage/_amount_which_will_transfer_to_the_customer_wallet_when_the__order_is_completed.')); ?>">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                        <span class="form-label-secondary text-danger"
                                        data-toggle="tooltip" data-placement="right"
                                        data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                        </span>

                                        </label>
                                        <input type="number" value="<?php echo e(old('cashback_amount')); ?>" step="0.01" min="1" max="100"  placeholder="<?php echo e(translate('messages.Ex:_100')); ?>"  name="cashback_amount" id="Cash_back_amount" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-4 col-lg-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.Minimum_Purchase')); ?> (<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)
                                            <span class="form-label-secondary text-danger"
                                                  data-toggle="tooltip" data-placement="right"
                                                  data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                            </span></label>
                                        <input type="number" step="0.01" id="min_purchase" value="<?php echo e(old('min_purchase')); ?>" required name="min_purchase" value="0" min="0" max="999999999999.99" class="form-control"
                                             placeholder="<?php echo e(translate('messages.Ex:_100')); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="max_discount"><?php echo e(translate('messages.Max Cashback')); ?> (<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)</label>
                                        <input type="number"   placeholder="<?php echo e(translate('messages.Ex:_100')); ?>" step="0.01" min="0" value="<?php echo e(old('cashback_type')  == 'percentage' ?  old('max_discount') : null); ?>" max="999999999999.99" name="max_discount" id="max_discount" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-4 col-lg-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.Start_Date')); ?>

                                            <span class="form-label-secondary text-danger"
                                                  data-toggle="tooltip" data-placement="right"
                                                  data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                            </span></label>
                                        <input type="date" name="start_date" value="<?php echo e(old('start_date')); ?>" class="form-control" id="date_from" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.End_Date')); ?>

                                            <span class="form-label-secondary text-danger"
                                                  data-toggle="tooltip" data-placement="right"
                                                  data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                            </span></label>
                                        <input type="date" name="end_date"  value="<?php echo e(old('end_date')); ?>" class="form-control" id="date_to" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4 col-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.Limit_for_Same_User')); ?>

                                            <span class="form-label-secondary text-danger"
                                                  data-toggle="tooltip" data-placement="right"
                                                  data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                            </span></label>
                                        <input type="number" step="1" required  value="<?php echo e(old('same_user_limit')); ?>" name="same_user_limit" value="0" min="0" max="9999999" class="form-control"
                                             placeholder="<?php echo e(translate('messages.Ex:_5')); ?>">
                                    </div>
                                </div>

                            </div>
                            <div class="btn--container justify-content-end">
                                <button type="reset" id="reset_btn" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                                <button type="submit" class="btn btn--primary cashback-submit"><?php echo e(translate('messages.submit')); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header py-2 border-0">
                        <div class="search--button-wrapper">
                            <h5 class="card-title"><?php echo e(translate('messages.Cashback_List')); ?><span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($cashbacks->total()); ?></span></h5>
                            <form  class="search-form min--270">
                                <!-- Search -->
                                <div class="input-group input--group">
                                    <input id="datatableSearch" type="search" name="search" value="<?php echo e(request()?->search); ?>" class="form-control" placeholder="<?php echo e(translate('messages.Ex_:_Search_by_title')); ?>" aria-label="<?php echo e(translate('messages.search_here')); ?>">
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
                                <th class="border-0"><?php echo e(translate('messages.Name')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.CashBack_Type')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Amount')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Duration')); ?></th>
                                <th class="border-0 text-center"><?php echo e(translate('messages.Total_Used')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.status')); ?></th>
                                <th class="border-0 text-center"><?php echo e(translate('messages.action')); ?></th>
                            </tr>
                            </thead>

                            <tbody id="set-rows">
                            <?php $__currentLoopData = $cashbacks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$bonus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key+$cashbacks->firstItem()); ?></td>
                                    <td>
                                    <span class="d-block font-size-sm text-body" title="<?php echo e($bonus['title']); ?>">
                                    <?php echo e(Str::limit($bonus['title'],25,'...')); ?>

                                    </span>
                                    </td>


                                    <td><?php echo e(translate($bonus['cashback_type'])); ?></td>
                                    <td> <?php echo e($bonus['cashback_type'] == 'amount' ? \App\CentralLogics\Helpers::format_currency($bonus['cashback_amount']) : $bonus['cashback_amount'] .' %'); ?></td>
                                    <td> <?php echo e(\App\CentralLogics\Helpers::date_format($bonus->start_date)); ?> -  <?php echo e(\App\CentralLogics\Helpers::date_format($bonus->end_date)); ?></td>

                                    <td class="text-center"><?php echo e($bonus['total_used']); ?></td>
                                    <td>
                                        <label class="toggle-switch toggle-switch-sm" for="bonusCheckbox<?php echo e($bonus->id); ?>">
                                            <input type="checkbox" data-url="<?php echo e(route('admin.users.cashback.status',[$bonus['id'],$bonus->status?0:1])); ?>" class="toggle-switch-input redirect-url" id="bonusCheckbox<?php echo e($bonus->id); ?>" <?php echo e($bonus->status?'checked':''); ?>>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="btn--container justify-content-center">

                                            <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route('admin.users.cashback.update',[$bonus['id']])); ?>" title="<?php echo e(translate('messages.edit_cashback')); ?>"><i class="tio-edit"></i>
                                            </a>
                                            
                                            <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:" data-id="bonus-<?php echo e($bonus['id']); ?>" data-message="<?php echo e(translate('Want_to_delete_this_Cashback_?')); ?>" title="<?php echo e(translate('messages.delete_bonus')); ?>"><i class="tio-delete-outlined"></i>
                                            </a>
                                            <form action="<?php echo e(route('admin.users.cashback.delete',[$bonus['id']])); ?>"
                                            method="post" id="bonus-<?php echo e($bonus['id']); ?>">
                                                <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                        <?php if(count($cashbacks) !== 0): ?>
                        <hr>
                        <?php endif; ?>
                        <div class="page-area">
                            <?php echo $cashbacks->links(); ?>

                        </div>
                        <?php if(count($cashbacks) === 0): ?>
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
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/cashback-index.js"></script>
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

//     $('.edit_cashback').on('click', function (e) {

//     let url = "<?php echo e(route('admin.users.cashback.update', ['id'])); ?>";
//         url = url.replace('id', $(this).data("id"));
//     e.preventDefault();
//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });
//     $.ajax({
//         type: "GET",
//         url: url,
//         cache: false,
//         beforeSend: function () {
//             $('#loading').show();
//         },
//         success: function (data) {
//             $('#form_data').html(data.view);
//         },
//         complete: function () {
//             $('#loading').hide();
//         },
//         error: function(xhr, textStatus, errorThrown) {
//             console.error("Error:", textStatus, errorThrown);
//         }
//     });
// });

</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/promotions/cashback/index.blade.php ENDPATH**/ ?>