<?php $__env->startSection('title', translate('Refund Settings')); ?>

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
                    <?php echo e(translate('messages.refund_settings')); ?>

                </span>
            </h1>
        </div>

        <!-- End Page Header -->
        <div class="card mb-3">
            <div class="card-body">
                <div
                    class="maintenance-mode-toggle-bar d-flex flex-wrap justify-content-between border border-primary rounded align-items-center p-2">
                    <?php ($config = $refund_active_status->value ?? null); ?>
                    <h5 class="text-capitalize m-0 text--info text--primary">
                        <i class="tio-settings-outlined"></i>
                        <?php echo e(translate('messages.Refund Request_Mode')); ?>

                    </h5>
                    <label class="toggle-switch toggle-switch-sm">
                        <input type="checkbox" class="status toggle-switch-input refund_mode"
                            <?php echo e(isset($config) && $config ? 'checked' : ''); ?>>
                        <span class="toggle-switch-label text mb-0">
                            <span class="toggle-switch-indicator"></span>
                        </span>
                    </label>
                </div>
                <div class="mt-2">
                    <?php echo e(translate('*By Turning ON Refund Mode, Customers Can Sent Refund Requests')); ?>

                </div>
            </div>
        </div>



        <div class="col-lg-12 pt-sm-3">
            <div class="report-card-inner mb-4 pt-3 mw-100">
                <form action="<?php echo e(route('admin.refund.refund_reason')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-md-0 mb-3">
                        <div class="mx-1">
                            <h5 class="form-label mb-0">
                                <?php echo e(translate('messages.Add a Refund Reason')); ?>

                            </h5>
                        </div>
                    </div>
                    <div class="row g-2 align-items-end">
                        <div class="col-md-10">
                            <div>
                                <label class="floating-label" for="refund_reason"></label>
                                <input type="text" class="form-control h--45px" name="reason" id="refund_reason"
                                    value="<?php echo e(old('reason')); ?>" placeholder="Ex: Item is Broken" required>
                            </div>
                        </div>

                        <div class="col-md-auto">
                            <button type="submit"
                                class="btn btn--primary h--45px btn-block"><?php echo e(translate('messages.Add Now')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body mb-3">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-md-0 mb-3">
                    <div class="mx-1">
                        <h5 class="form-label mb-0">
                            <?php echo e(translate('Refund Reason List')); ?>

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
                                        <td>
                                            <label class="toggle-switch toggle-switch-sm"
                                                for="stocksCheckbox<?php echo e($reason->id); ?>">
                                                <input type="checkbox" data-url="<?php echo e(route('admin.refund.reason_status', [$reason['id'], $reason->status ? 0 : 1])); ?>" class="toggle-switch-input redirect-url"
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
                                                    class="btn action-btn btn--primary btn-outline-primary identifyingClass"
                                                    data-id=<?php echo e($reason['id']); ?>

                                                    title="<?php echo e(translate('messages.edit_category')); ?>"
                                                    data-toggle="modal" data-target="#exampleModal<?php echo e($reason['id']); ?>">
                                                    <i class="tio-edit"></i>
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal<?php echo e($reason['id']); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel"><?php echo e(translate('messages.Reason')); ?>

                                                                    <?php echo e(translate('messages.Update')); ?></label></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="<?php echo e(route('admin.refund.reason_edit')); ?>" method="post">
                                                                    <?php echo csrf_field(); ?>
                                                                    <?php echo method_field('PUT'); ?>
                                                                    <input type="hidden" name="reason_id" id="hiddenValue" value="<?php echo e($reason['id']); ?>" />
                                                                    <input class="form-control" name='reason' id="reason_title" value="<?php echo e($reason['reason']); ?>" required type="text">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(translate('messages.Close')); ?></button>
                                                                <button type="submit" class="btn btn-primary"><?php echo e(translate('messages.save_changes')); ?></button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a class="btn btn-sm btn--danger btn-outline-danger action-btn form-alert"
                                                    href="javascript:"
                                                    data-id="refund_reason-<?php echo e($reason['id']); ?>"
                                                   data-message="<?php echo e(translate('Want to delete this refund reason ?')); ?>"
                                                    title="<?php echo e(translate('messages.delete')); ?>">
                                                    <i class="tio-delete-outlined"></i>
                                                </a>
                                                <form action="<?php echo e(route('admin.refund.reason_delete', [$reason['id']])); ?>"
                                                    method="post" id="refund_reason-<?php echo e($reason['id']); ?>">
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


<?php $__env->stopSection(); ?>
<?php $__env->startPush('script_2'); ?>
    <script>
        "use strict";
        $('.refund_mode').on('click', function (){
            Swal.fire({
                title: '<?php echo e(translate('Are you sure?')); ?>' ,
                text: 'Be careful before you turn on/off Refund Request mode',
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#377dff',
                cancelButtonText: '<?php echo e(translate('messages.no')); ?>',
                confirmButtonText: '<?php echo e(translate('messages.yes')); ?>',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.get({
                        url: '<?php echo e(route('admin.refund.refund_mode')); ?>',
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $('#loading').show();
                        },
                        success: function(data) {
                            toastr.success(data.message);
                        },
                        complete: function() {
                            $('#loading').hide();
                        },
                    });
                } else {
                    location.reload();
                }
            })

        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/refund/index.blade.php ENDPATH**/ ?>