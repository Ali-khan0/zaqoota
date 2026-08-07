<?php $__env->startSection('title', translate('Automated_Message')); ?>

<?php $__env->startPush('css_or_js'); ?>
<link rel="stylesheet" href="<?php echo e(asset('public/assets/admin/css/owl.min.css')); ?>">
<?php $__env->stopPush(); ?>

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

        <div class="card mb-3 mt-0">
            <div class="card-body mb-3">


                <div class="report-card-inner mb-4 mw-100">
                    <form action="<?php echo e(route('admin.business-settings.automated_message.store')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <?php if($language): ?>
                        <ul class="nav nav-tabs nav--tabs d-block nav-slider owl-theme owl-carousel mb-4">
                            <li class="nav-item">
                                <a class="nav-link lang_link1 active px-0" href="#"
                                    id="default-link1"><?php echo e(translate('Default')); ?></a>
                            </li>
                            <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="nav-item">
                                    <a class="nav-link lang_link1 px-0" href="#"
                                        id="<?php echo e($lang); ?>-link1"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <?php endif; ?>
                        <div class="row align-items-end">



                            <div class="col-md-12 lang_form1 default-form1">
                                <label for="reason" class="form-label"><?php echo e(translate('Automated_Message/Reason')); ?>

                                    (<?php echo e(translate('Default')); ?>)

                                    <span class="input-label-secondary text--title" data-toggle="tooltip"
                                    data-placement="right"
                                    data-original-title="<?php echo e(translate('You_must_set_predefined_reasons_for_customers_to_select_This_will_guide_them_in_choosing_a_reason_when_reporting_any_issues_with_their_order.')); ?>">
                                        <i class="tio-info-outined"></i>
                                    </span>

                                </label>
                                <input id="reason" type="text" class="form-control h--45px" name="message[]" maxlength="255"
                                    placeholder="<?php echo e(translate('Ex:Enter_the_message')); ?>">
                                <input type="hidden" name="lang[]" value="default">
                            </div>

                            <?php if($language): ?>
                                <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-12 d-none lang_form1" id="<?php echo e($lang); ?>-form1">
                                        <label for="reason<?php echo e($lang); ?>"
                                            class="form-label"><?php echo e(translate('Automated_Message/Reason')); ?>

                                            (<?php echo e(strtoupper($lang)); ?>)</label>
                                        <input id="reason<?php echo e($lang); ?>" type="text" class="form-control h--45px"
                                            name="message[]" maxlength="255" placeholder="<?php echo e(translate('Ex:Enter_the_message')); ?>">
                                        <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

                        </div>
                        <div class="mt-3 btn--container justify-content-end">
                            <button type="reset" id="reset_btn"
                                class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                            <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.Submit')); ?></button>
                        </div>

                    </form>
                </div>
            </div>
        </div>


        <div class="card">

            <div class="card-header border-0">
                <div class="mx-1">
                    <h5 class="form-label mb-2">
                        <?php echo e(translate('Total message')); ?>

                        <span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($messages->total()); ?></span>
                    </h5>
                </div>
                <div class="search--button-wrapper justify-content-end">
                    <form class="search-form">
                        <!-- Search -->
                        <div class="input-group input--group">
                            <input id="datatableSearch" name="search" value="<?php echo e(request()?->search ?? null); ?>"
                                type="search" class="form-control h--40px"
                                placeholder="<?php echo e(translate('ex_:Search_by_message')); ?>"
                                aria-label="<?php echo e(translate('messages.search_here')); ?>">
                            <button type="submit" class="btn btn--secondary h--40px"><i class="tio-search"></i></button>
                        </div>
                        <!-- End Search -->
                    </form>
                    <?php if(request()->get('search')): ?>
                        <button type="reset" class="btn btn--primary ml-2 location-reload-to-base"
                            data-url="<?php echo e(url()->full()); ?>"><?php echo e(translate('messages.reset')); ?></button>
                    <?php endif; ?>
                </div>
                <!-- End Row -->
            </div>




            <!-- Table -->
            <div class="card-body p-0">
                <div class="table-responsive datatable-custom">
                    <table id="columnSearchDatatable" class="table table-borderless table-thead-bordered table-align-middle"
                        data-hs-datatables-options='{
                        "isResponsive": false,
                        "isShowPaging": false,
                        "paging":false,
                    }'>
                        <thead class="thead-light">
                            <tr>
                                <th class="border-0"><?php echo e(translate('messages.SL')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.message')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.status')); ?></th>
                                <th class="border-0 text-center"><?php echo e(translate('messages.action')); ?></th>
                            </tr>
                        </thead>

                        <tbody id="table-div">
                            <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key + $messages->firstItem()); ?></td>

                                    <td>
                                        <span class="d-block font-size-sm text-body" title="<?php echo e($message->message); ?>">
                                            <?php echo e(Str::limit($message->message, 50, '...')); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <label class="toggle-switch toggle-switch-sm"
                                            for="stocksCheckbox<?php echo e($message->id); ?>">
                                            <input type="checkbox"
                                                data-url="<?php echo e(route('admin.business-settings.automated_message.status', [$message['id'], $message->status ? 0 : 1])); ?>"
                                                class="toggle-switch-input redirect-url"
                                                id="stocksCheckbox<?php echo e($message->id); ?>" <?php echo e($message->status ? 'checked' : ''); ?>>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </td>

                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a class="btn btn-sm btn--primary btn-outline-primary action-btn edit-reason"
                                                title="<?php echo e(translate('messages.edit')); ?>" data-toggle="modal"
                                                data-target="#add_update_reason_<?php echo e($message->id); ?>"><i
                                                    class="tio-edit"></i>
                                            </a>

                                            <a class="btn btn-sm btn--danger btn-outline-danger action-btn form-alert"
                                                href="javascript:" data-id="refund_reason-<?php echo e($message['id']); ?>"
                                                data-message="<?php echo e(translate('Want to delete this message ?')); ?>"
                                                title="<?php echo e(translate('messages.delete')); ?>">
                                                <i class="tio-delete-outlined"></i>
                                            </a>
                                            <form action="<?php echo e(route('admin.business-settings.automated_message.destroy', [$message['id']])); ?>"
                                                method="post" id="refund_reason-<?php echo e($message['id']); ?>">
                                                <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Modal -->
                                <div class="modal fade" id="add_update_reason_<?php echo e($message->id); ?>" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    <?php echo e(translate('messages.Automated_Message/Reason_Update')); ?></label></h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="<?php echo e(route('admin.business-settings.automated_message.update')); ?>" method="post">
                                                <div class="modal-body">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('put'); ?>

                                                    <?php ($message = \App\Models\AutomatedMessage::withoutGlobalScope('translate')->with('translations')->find($message->id)); ?>
                                                <div class="js-nav-scroller hs-nav-scroller-horizontal mb-4">
                                                    <ul class="nav nav-tabs nav--tabs d-block border-0 nav-slider owl-theme owl-carousel mb-4">
                                                        <li class="nav-item">
                                                            <a class="nav-link update-lang_link add_active active px-0"
                                                                href="#"
                                                                id="default-link"><?php echo e(translate('Default')); ?></a>
                                                        </li>
                                                        <?php if($language): ?>
                                                            <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link update-lang_link px-0" href="#"
                                                                        data-reason-id="<?php echo e($message->id); ?>"
                                                                        id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                                                </li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                                    <input type="hidden" name="message_id"
                                                        value="<?php echo e($message->id); ?>" />

                                                    <div class="form-group mb-3 add_active_2  update-lang_form"
                                                        id="default-form_<?php echo e($message->id); ?>">
                                                        <label for="reason"
                                                            class="form-label"><?php echo e(translate('Automated_Message/Reason')); ?>

                                                            (<?php echo e(translate('messages.default')); ?>) </label>
                                                        <input id="reason" class="form-control" name='message[]'
                                                            value="<?php echo e($message?->getRawOriginal('message')); ?>" maxlength="255"
                                                            type="text">
                                                        <input type="hidden" name="lang1[]" value="default">
                                                    </div>
                                                    <?php if($language): ?>
                                                        <?php $__empty_1 = true; $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                            <?php
                                                            if ($message?->translations) {
                                                                $translate = [];
                                                                foreach ($message?->translations as $t) {
                                                                    if ($t->locale == $lang && $t->key == 'message') {
                                                                        $translate[$lang]['message'] = $t->value;
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                            <div class="form-group mb-3 d-none update-lang_form"
                                                                id="<?php echo e($lang); ?>-langform_<?php echo e($message->id); ?>">
                                                                <label for="reason<?php echo e($lang); ?>"
                                                                    class="form-label"><?php echo e(translate('Automated_Message/Reason')); ?>

                                                                    (<?php echo e(strtoupper($lang)); ?>)</label>
                                                                <input id="reason<?php echo e($lang); ?>"
                                                                    class="form-control" name='message[]' maxlength="255"
                                                                    value="<?php echo e($translate[$lang]['message'] ?? null); ?>"
                                                                    type="text">
                                                                <input type="hidden" name="lang1[]"
                                                                    value="<?php echo e($lang); ?>">
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal"><?php echo e(translate('Close')); ?></button>
                                                    <button type="submit"
                                                        class="btn btn-primary"><?php echo e(translate('Save_changes')); ?></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <?php if(count($messages) === 0): ?>
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
                                <?php echo $messages->links(); ?>

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
    <script src="<?php echo e(asset('public/assets/admin/js/owl.min.js')); ?>"></script>
    <script>
        $('.nav-slider').owlCarousel({
            margin: 30,
            loop: false,
            autoWidth: true,
            items: 4
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/automated_message.blade.php ENDPATH**/ ?>