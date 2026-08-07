<?php $__env->startSection('title', translate('refund_settings')); ?>


<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title mr-3">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/business.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.business_setup')); ?>

                </span>
            </h1>
            <?php echo $__env->make('admin-views.business-settings.partials.nav-menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
                        <input type="checkbox" class="status toggle-switch-input refund-mode"
                            <?php echo e(isset($config) && $config ? 'checked' : ''); ?>>
                        <span class="toggle-switch-label text mb-0">
                            <span class="toggle-switch-indicator"></span>
                        </span>
                    </label>
                </div>
                <div class="mt-2">
                    <?php echo e(translate('messages.*Customers_cannot_request_a_Refund_if_the_Admin_does_not_specify_a_cause_for_refund_even_though_they_see_the_Refund_option._So_Admin_MUST_provide_a_proper_Refund_Reason._At_least_one_reason_Must_be_ON_in_the_reason_list.')); ?>

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
                    <?php ($language=\App\Models\BusinessSetting::where('key','language')->first()); ?>
                    <?php ($language = $language->value ?? null); ?>
                    <?php ($defaultLang = str_replace('_', '-', app()->getLocale())); ?>
                    <?php if($language): ?>
                    <ul class="nav nav-tabs nav--tabs mt-3 mb-3 ">
                        <li class="nav-item">
                            <a class="nav-link lang_link1 active"
                            href="#"
                            id="default-link1"><?php echo e(translate('Default')); ?></a>
                        </li>
                        <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="nav-item">
                                <a class="nav-link lang_link1"
                                    href="#"
                                    id="<?php echo e($lang); ?>-link1"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <?php endif; ?>
                    <div class="row align-items-end">



                        <div class="col-md-10 lang_form1 default-form1">
                            <label for="reason" class="form-label"><?php echo e(translate('Reason')); ?> (<?php echo e(translate('Default')); ?>)</label>
                            <input id="reason" type="text" class="form-control h--45px" name="reason[]"
                                        placeholder="<?php echo e(translate('Ex:_Item_is_Broken')); ?>">
                                        <input type="hidden" name="lang[]" value="default">
                        </div>
.
                        <?php if($language): ?>
                        <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-10 d-none lang_form1" id="<?php echo e($lang); ?>-form1">
                                <label for="reason<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Reason')); ?> (<?php echo e(strtoupper($lang)); ?>)</label>
                                <input id="reason<?php echo e($lang); ?>" type="text" class="form-control h--45px" name="reason[]"
                                        placeholder="<?php echo e(translate('Ex:_Item_is_Broken')); ?>">
                                <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>


                        <div class="col-md-auto">
                            <button type="submit" class="btn btn--primary h--45px btn-block"><?php echo e(translate('messages.Add Now')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body mb-3">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-md-0 mb-3">
                    <div class="mx-1">
                        <h5 class="form-label mb-5">
                            <?php echo e(translate('Refund Reason List')); ?>

                        </h5>
                    </div>
                </div>




        <!-- Table -->
        <div class="card-body p-0">
            <div class="table-responsive datatable-custom">
                <table id="columnSearchDatatable"
                    class="table table-borderless table-thead-bordered table-align-middle" data-hs-datatables-options='{
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
                    <?php $__currentLoopData = $reasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$reason): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+$reasons->firstItem()); ?></td>

                            <td>
                                <span class="d-block font-size-sm text-body" title="<?php echo e($reason->reason); ?>">
                                    <?php echo e(Str::limit($reason->reason, 50,'...')); ?>

                                </span>
                            </td>
                            <td>
                                <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox<?php echo e($reason->id); ?>">
                                <input type="checkbox" data-url="<?php echo e(route('admin.refund.reason_status',[$reason['id'],$reason->status?0:1])); ?>" class="toggle-switch-input redirect-url" id="stocksCheckbox<?php echo e($reason->id); ?>" <?php echo e($reason->status?'checked':''); ?>>
                                    <span class="toggle-switch-label">
                                        <span class="toggle-switch-indicator"></span>
                                    </span>
                                </label>
                            </td>

                            <td>
                                <div class="btn--container justify-content-center">
                                    <a class="btn btn-sm btn--primary btn-outline-primary action-btn edit-reason"
                                        title="<?php echo e(translate('messages.edit')); ?>"
                                            data-toggle="modal"   data-target="#add_update_reason_<?php echo e($reason->id); ?>"
                                        ><i class="tio-edit"></i>
                                    </a>

                                    <a class="btn btn-sm btn--danger btn-outline-danger action-btn form-alert" href="javascript:"
                                       data-id="refund_reason-<?php echo e($reason['id']); ?>"
                                       data-message="<?php echo e(translate('Want to delete this refund reason ?')); ?>"

                                title="<?php echo e(translate('messages.delete')); ?>">
                                <i class="tio-delete-outlined"></i>
                            </a>
                                    <form action="<?php echo e(route('admin.refund.reason_delete',[$reason['id']])); ?>"
                                    method="post" id="refund_reason-<?php echo e($reason['id']); ?>">
                                <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                            </form>
                                </div>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="add_update_reason_<?php echo e($reason->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><?php echo e(translate('messages.Refund_Reason_Update')); ?></label></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                        <form action="<?php echo e(route('admin.refund.reason_edit')); ?>" method="post">
                                    <div class="modal-body">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('put'); ?>

                                            <?php ($reason=  \App\Models\RefundReason::withoutGlobalScope('translate')->with('translations')->find($reason->id)); ?>
                                            <?php ($language=\App\Models\BusinessSetting::where('key','language')->first()); ?>
                                        <?php ($language = $language->value ?? null); ?>
                                        <?php ($defaultLang = str_replace('_', '-', app()->getLocale())); ?>
                                        <ul class="nav nav-tabs nav--tabs mb-3 border-0">
                                            <li class="nav-item">
                                                <a class="nav-link update-lang_link add_active active"
                                                href="#"

                                                id="default-link"><?php echo e(translate('Default')); ?></a>
                                            </li>
                                            <?php if($language): ?>
                                            <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="nav-item">
                                                    <a class="nav-link update-lang_link"
                                                        href="#"
                                                        data-reason-id="<?php echo e($reason->id); ?>"
                                                        id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </ul>
                                            <input type="hidden" name="reason_id"  value="<?php echo e($reason->id); ?>" />

                                            <div class="form-group mb-3 add_active_2  update-lang_form" id="default-form_<?php echo e($reason->id); ?>">
                                                <label for="reason" class="form-label"><?php echo e(translate('Reason')); ?> (<?php echo e(translate('messages.default')); ?>) </label>
                                                <input id="reason" class="form-control" name='reason[]' value="<?php echo e($reason?->getRawOriginal('reason')); ?>" type="text">
                                                <input type="hidden" name="lang1[]" value="default">
                                            </div>
                                                            <?php if($language): ?>
                                                                <?php $__empty_1 = true; $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                <?php
                                                                    if($reason?->translations){
                                                                        $translate = [];
                                                                        foreach($reason?->translations as $t)
                                                                        {
                                                                            if($t->locale == $lang && $t->key=="reason"){
                                                                                $translate[$lang]['reason'] = $t->value;
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <div class="form-group mb-3 d-none update-lang_form" id="<?php echo e($lang); ?>-langform_<?php echo e($reason->id); ?>">
                                                                        <label for="reason<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Reason')); ?> (<?php echo e(strtoupper($lang)); ?>)</label>
                                                                        <input id="reason<?php echo e($lang); ?>" class="form-control" name='reason[]' value="<?php echo e($translate[$lang]['reason'] ?? null); ?>"  type="text">
                                                                        <input type="hidden" name="lang1[]" value="<?php echo e($lang); ?>">
                                                                    </div>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(translate('Close')); ?></button>
                                                    <button type="submit" class="btn btn-primary"><?php echo e(translate('Save_changes')); ?></button>
                                                </div>
                                        </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php if(count($reasons) === 0): ?>
                <div class="empty--data">
                    <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                    <h5>
                        <?php echo e(translate('no_data_found')); ?>

                    </h5>
                </div>
                <?php endif; ?>
            </div>
            <div class="card-footer pt-0 border-0">
                <div class="page-area px-4 pb-3">
                    <div class="d-flex align-items-center justify-content-end">
                        <div>
                            <?php echo $reasons->links(); ?>

                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <!-- End Table -->

            </div>
        </div>


<?php $__env->stopSection(); ?>
<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin/js/view-pages/business-settings-refund-reasons-page.js')); ?>"></script>
<script>

    $('.refund-mode').on('click', function(event){
        event.preventDefault();
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
                        location.reload();
                        $('#loading').hide();
                    },
                });
            }
        })

    });

</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/refund-index.blade.php ENDPATH**/ ?>