<?php $__env->startSection('title',translate('messages.store_wallet')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h2 class="page-header-title text-capitalize">
                        <div class="card-header-icon d-inline-flex mr-2 img">
                            <img src="<?php echo e(asset('/public/assets/admin/img/image_90.png')); ?>" alt="public">
                        </div>
                        <span>
                            <?php echo e(translate('messages.disbursement_method_setup')); ?>

                        </span>
                    </h2>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <!-- Card -->
        <div class="card">
            <div class="card-header py-2">
                <div class="search--button-wrapper">
                    <h3 class="card-title">
                        <?php echo e(translate('disbursement_methods')); ?><span class="badge badge-soft-secondary"  id="countfoods"><?php echo e($vendor_withdrawal_methods->total()); ?></span>
                    </h3>
                    <form >
                        <!-- Search -->
                        <div class="input-group input--group">
                            <input id="datatableSearch_" type="search" name="search" class="form-control" placeholder="<?php echo e(translate('Ex : Search by name')); ?>"  value="<?php echo e(request()?->search ?? null); ?>" aria-label="Search">

                            <button type="submit" class="btn btn--secondary">
                                <i class="tio-search"></i>
                            </button>
                        </div>
                        <!-- End Search -->
                    </form>
                </div>
                &nbsp;
                <div class="p--10px">
                    <a class="btn btn--primary btn-outline-primary w-100" href="javascript:" data-toggle="modal" data-target="#balance-modal"><?php echo e(translate('messages.add_new_method')); ?></a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="datatable"
                           class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table" data-hs-datatables-options='{
                            "order": [],
                            "orderCellsTop": true,
                            "paging":false
                        }'>
                        <thead class="thead-light">
                        <tr>
                            <th><?php echo e(translate('messages.sl')); ?></th>
                            <th><?php echo e(translate('messages.payment_method_name')); ?></th>
                            <th><?php echo e(translate('messages.payment_info')); ?></th>
                            <th><?php echo e(translate('messages.default')); ?></th>
                            <th class="w-100px text-center"><?php echo e(translate('messages.action')); ?></th>
                        </tr>
                        </thead>
                        <tbody id="set-rows">
                        <?php $__currentLoopData = $vendor_withdrawal_methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <th scope="row"><?php echo e($k+$vendor_withdrawal_methods->firstItem()); ?></th>
                                <td class="text-capitalize text-break text-hover-primary"><?php echo e($e['method_name']); ?></td>
                                <td>
                                    <div class="col-md-8 mt-2">
                                        <?php $__empty_1 = true; $__currentLoopData = json_decode($e->method_fields, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <h5 class="text-capitalize "> <?php echo e(translate($key)); ?>: <?php echo e($item); ?></h5>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <h5 class="text-capitalize"> <?php echo e(translate('messages.No_Data_found')); ?></h5>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <div>
                                            <label class="toggle-switch toggle-switch-sm mr-2" data-toggle="tooltip" data-placement="top" title="<?php echo e(translate('messages.make_default_method')); ?>" for="statusCheckbox<?php echo e($e->id); ?>">
                                                <input type="checkbox" data-url="<?php echo e(route('vendor.wallet-method.default',[$e['id'],$e->is_default?0:1])); ?>" class="toggle-switch-input redirect-url" id="statusCheckbox<?php echo e($e->id); ?>" <?php echo e($e->is_default?'checked':''); ?>>
                                                <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                            </label>
                                        </div>
                                    </div>
                                </td>
                                <td>

                                    <?php if(auth('vendor_employee')->id()  != $e['id']): ?>
                                        <div class="btn--container justify-content-center">
                                            <a class="btn btn-sm btn--danger btn-outline-danger action-btn form-alert" href="javascript:"
                                               data-id="employee-<?php echo e($e['id']); ?>" data-message="<?php echo e(translate('messages.Want_to_delete_this_method_info')); ?>" title="<?php echo e(translate('messages.delete_method')); ?>"><i class="tio-delete-outlined"></i>
                                            </a>
                                            <form action="<?php echo e(route('vendor.wallet-method.delete',[$e['id']])); ?>"
                                                  method="post" id="employee-<?php echo e($e['id']); ?>">
                                                <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <?php if(count($vendor_withdrawal_methods) === 0): ?>
                        <div class="empty--data">
                            <img src="<?php echo e(asset('public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                            <h5>
                                <?php echo e(translate('no_data_found')); ?>

                            </h5>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-footer">
                <div class="page-area">
                    <table>
                        <tfoot>
                        <?php echo $vendor_withdrawal_methods->links(); ?>

                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!-- Card -->


        <div class="modal fade" id="balance-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <?php echo e(translate('messages.add_method')); ?>

                        </h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true" class="btn btn--circle btn-soft-danger text-danger"><ti class="tio-clear"></ti></span>
                        </button>
                    </div>
                    <form action="<?php echo e(route('vendor.wallet-method.store')); ?>" method="post">
                        <div class="modal-body">
                            <?php echo csrf_field(); ?>
                            <div class="">
                                <select class="form-control" id="withdraw_method" name="withdraw_method" required>
                                    <option value="" selected disabled><?php echo e(translate('Select_Disburse_Method')); ?></option>
                                    <?php $__currentLoopData = $withdrawal_methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item['id']); ?>"><?php echo e($item['method_name']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="" id="method-filed__div">
                            </div>
                        </div>
                        <div class="modal-footer pt-0 border-0">
                            <button type="button" class="btn btn--reset" data-dismiss="modal"><?php echo e(translate('messages.cancel')); ?></button>
                            <button type="submit" id="submit_button" disabled class="btn btn--primary"><?php echo e(translate('messages.Submit')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script_2'); ?>
    <script>
        "use strict";
        $('#withdraw_method').on('change', function () {
            $('#submit_button').attr("disabled","true");
            let method_id = this.value;

            // Set header if need any otherwise remove setup part
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "<?php echo e(route('vendor.wallet.method-list')); ?>" + "?method_id=" + method_id,
                data: {},
                processData: false,
                contentType: false,
                type: 'get',
                success: function (response) {
                    $('#submit_button').removeAttr('disabled');
                    let method_fields = response.content.method_fields;
                    $("#method-filed__div").html("");
                    method_fields.forEach((element, index) => {
                        $("#method-filed__div").append(`
                    <div class="form-group mt-2">
                        <label for="wr_num" class="fz-16 c1 mb-2">${element.input_name.replaceAll('_', ' ').toUpperCase()}</label>
                        <input type="${element.input_type == 'phone' ? 'number' : element.input_type  }" class="form-control" name="${element.input_name}" placeholder="${element.placeholder}" ${element.is_required === 1 ? 'required' : ''}>
                    </div>
                `);
                    })

                },
                error: function () {

                }
            });
        });
        function showMyModal(data) {
            $(".modal-body #hiddenValue").html(data);
            $('#exampleModal').modal('show');
        }

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/wallet-method/index.blade.php ENDPATH**/ ?>