<?php $__env->startSection('title', translate('messages.order_cancellation_reasons')); ?>

<?php $__env->startPush('css_or_js'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title text-capitalize">
                <div class="card-header-icon d-inline-flex mr-2 img">
                    <img src="<?php echo e(asset('/public/assets/admin/img/email.png')); ?>" alt="public">
                </div>
                <span>
                    <?php echo e(translate('messages.order_cancellation_reasons')); ?>

                </span>
            </h1>
        </div>

        <div class="col-lg-12 pt-sm-3">
            <div class="report-card-inner mb-4 pt-3 mw-100">
                <form action="<?php echo e(route('admin.business-settings.order-cancel-reasons.store')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-md-0 mb-3">
                        <div class="mx-1">
                            <h5 class="form-label mb-0">
                                <?php echo e(translate('messages.add_an_order_cancellation_reason')); ?>

                            </h5>
                        </div>
                    </div>
                    <div class="row g-2 align-items-end">
                        <div class="col-md-7">
                            <div>
                                <label for="order_cancellation"></label>
                                <input type="text" class="form-control h--45px" name="reason" id="order_cancellation"
                                    value="<?php echo e(old('reason')); ?>" placeholder="Ex: Item is Broken" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div>
                                <label for="order_cancellation_reason"></label>
                                <select name="user_type" id="order_cancellation_reason" class="form-control h--45px"
                                    required>
                                    <option value=""><?php echo e(translate('messages.select_user_type')); ?></option>
                                    <option value="admin"><?php echo e(translate('messages.admin')); ?></option>
                                    <option value="store"><?php echo e(translate('messages.store')); ?></option>
                                    <option value="customer"><?php echo e(translate('messages.customer')); ?></option>
                                    <option value="deliveryman"><?php echo e(translate('messages.deliveryman')); ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-auto">
                            <button type="submit"
                                class="btn btn--primary h--45px btn-block"><?php echo e(translate('messages.add_reason')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body mb-3">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-md-0 mb-3">
                    <div class="mx-1">
                        <h5 class="form-label mb-4">
                            <?php echo e(translate('messages.order_cancellation_reason_list')); ?>

                        </h5>
                    </div>
                </div>

                <!-- Table -->
                <div class="card-body p-0">
                    <div class="table-responsive datatable-custom">
                        <table id="columnSearchDatatable"
                            class="table table-borderless table-thead-bordered table-align-middle"
                            data-hs-datatables-options='{
                        "isResponsive": false,
                        "isShowPaging": false,
                        "paging":false,
                    }'>
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0"><?php echo e(translate('messages.SL')); ?></th>
                                    <th class="border-0"><?php echo e(translate('messages.Reason')); ?></th>
                                    <th class="border-0"><?php echo e(translate('messages.type')); ?></th>
                                    <th class="border-0"><?php echo e(translate('messages.status')); ?></th>
                                    <th class="border-0 text-center"><?php echo e(translate('messages.action')); ?></th>
                                </tr>
                            </thead>

                            <tbody id="table-div">
                                <?php $__currentLoopData = $reasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $reason): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + $reasons->firstItem()); ?></td>

                                        <td>
                                            <span class="d-block font-size-sm text-body">
                                                <?php echo e(Str::limit($reason->reason, 25, '...')); ?>

                                            </span>
                                        </td>
                                        <td><?php echo e(Str::title($reason->user_type)); ?></td>
                                        <td>
                                            <label class="toggle-switch toggle-switch-sm"
                                                for="stocksCheckbox<?php echo e($reason->id); ?>">
                                                <input type="checkbox"
                                                    data-url="<?php echo e(route('admin.business-settings.order-cancel-reasons.status', [$reason['id'], $reason->status ? 0 : 1])); ?>" class="toggle-switch-input redirect-url"
                                                    id="stocksCheckbox<?php echo e($reason->id); ?>"
                                                    <?php echo e($reason->status ? 'checked' : ''); ?>>
                                                <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                        </td>

                                        <td>
                                            <div class="btn--container justify-content-center">

                                                <button
                                                    class="btn action-btn btn--primary btn-outline-primary identifyingClass show-modal"
                                                    data-id="<?php echo e($reason['id']); ?>" title="<?php echo e(translate('messages.edit')); ?>" data-data="<?php echo e($reason->reason); ?>" data-type="<?php echo e($reason->user_type); ?>">
                                                    <i class="tio-edit"></i>
                                                </button>


                                                <a class="btn btn-sm btn--danger btn-outline-danger action-btn form-alert"
                                                    href="javascript:"
                                                    data-id="order-cancellation-reason-<?php echo e($reason['id']); ?>" data-message="<?php echo e(translate('messages.want_to_delete_this_order_cancellation_reason')); ?>"
                                                    title="<?php echo e(translate('messages.delete')); ?>">
                                                    <i class="tio-delete-outlined"></i>
                                                </a>
                                                <form
                                                    action="<?php echo e(route('admin.business-settings.order-cancel-reasons.destroy', [$reason['id']])); ?>"
                                                    method="post" id="order-cancellation-reason-<?php echo e($reason['id']); ?>">
                                                    <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Table -->
            </div>
        </div>
    </div>




    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo e(translate('messages.order_cancellation_reason_Update')); ?></label></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo e(route('admin.business-settings.order-cancel-reasons.update')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('put'); ?>
                    <div class="modal-body">
                            <input type="hidden" name="reason_id" id="hiddenValue" />
                            <input class="form-control" name='reason' id="hiddenValuetext" required type="text">
                            <label for="hiddenValuetype"></label>
                            <select name="user_type" id="hiddenValuetype" class="form-control h--45px"
                                required>
                                <option value=""><?php echo e(translate('messages.select_user_type')); ?></option>
                                <option value="admin"><?php echo e(translate('messages.admin')); ?></option>
                                <option value="store"><?php echo e(translate('messages.store')); ?></option>
                                <option value="customer"><?php echo e(translate('messages.customer')); ?></option>
                                <option value="deliveryman"><?php echo e(translate('messages.deliveryman')); ?></option>
                            </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(translate('Close')); ?></button>
                        <button type="submit" class="btn btn-primary"><?php echo e(translate('Save_changes')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script_2'); ?>
    <script>
        "use strict";
        $('.show-modal').on('click', function (){
            let id = $(this).data('id');
            let data = $(this).data('data');
            let type = $(this).data('type');
            showMyModal(id, data, type);
        })
        function showMyModal(id, data, type) {
            $(".modal-body #hiddenValue").val(id);
            $(".modal-body #hiddenValuetext").val(data);
            $(".modal-body #hiddenValuetype").val(type);
            $('#exampleModal').modal('show');
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/order/cancelation-reason.blade.php ENDPATH**/ ?>