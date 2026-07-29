<?php $__env->startSection('title',translate('messages.Contact Messages')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
            <!-- Page Title -->
            <div class="mb-3">
                <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                    <img width="20" src="<?php echo e(asset('/public/assets/back-end/img/message.png')); ?>" alt="">
                    <?php echo e(translate('messages.all_message_lists')); ?>

                </h2>
            </div>
            <!-- End Page Title -->
        <!-- End Page Header -->
        <div class="row g-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header py-2 border-0">
                        <div class="search--button-wrapper">
                            <h5 class="card-title">
                                <?php echo e(translate('messages.message_lists')); ?> <span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($contacts->total()); ?></span>
                            </h5>
                            <form class="search-form">
                                <div class="input-group input--group">
                                    <input  type="search" name="search" class="form-control"
                                    placeholder="<?php echo e(translate('ex_: search_by_name,_email,_or_subject')); ?>" aria-label="<?php echo e(translate('messages.search')); ?>" value="<?php echo e(request()?->search); ?>" >
                                    <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                                </div>
                            </form>
                           <?php if(request()->get('search')): ?>
                                <button type="reset" class="btn btn--primary ml-2 location-reload-to-base" data-url="<?php echo e(url()->full()); ?>"><?php echo e(translate('messages.reset')); ?></button>
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
                                       href="<?php echo e(route('admin.users.contact.exportList', ['type'=>'excel',request()->getQueryString()])); ?>">
                                        <img class="avatar avatar-xss avatar-4by3 mr-2"
                                             src="<?php echo e(asset('public/assets/admin/svg/components/excel.svg')); ?>"
                                             alt="Image Description">
                                        <?php echo e(translate('messages.excel')); ?>

                                    </a>
                                    <a id="export-csv" class="dropdown-item"
                                       href="<?php echo e(route('admin.users.contact.exportList', ['type'=>'csv',request()->getQueryString()])); ?>">
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
                            <tr class="text-center">
                                <th class="border-0"><?php echo e(translate('messages.sl')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.name')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.email')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.subject')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Seen/Unseen')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.action')); ?></th>
                            </tr>

                            </thead>

                            <tbody id="set-rows">
                            <?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-center">
                                        <span class="mr-3">
                                            <?php echo e($key+1); ?>

                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="font-size-sm text-body mr-3">
                                            <?php echo e(Str::limit($contact['name'],20,'...')); ?>

                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="font-size-sm text-body mr-3">
                                            <?php echo e($contact['email']); ?>

                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="font-size-sm text-body mr-3 white--space-initial max-w-180px mx-auto">
                                            <?php echo e(Str::limit($contact['subject'],40,'...')); ?>

                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="font-size-sm text-body mr-3">
                                            <?php if($contact->seen==1): ?>
                                            <label class="badge badge-soft-success mb-0"><?php echo e(translate('messages.Seen')); ?></label>
                                        <?php else: ?>
                                            <label class="badge badge-soft-info mb-0"><?php echo e(translate('messages.Not_Seen_Yet')); ?></label>
                                        <?php endif; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route('admin.users.contact.contact-view',[$contact['id']])); ?>" title="<?php echo e(translate('messages.edit')); ?>"><i class="tio-invisible"></i>
                                            </a>
                                            <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:" data-id="contact-<?php echo e($contact['id']); ?>" data-message="<?php echo e(translate('messages.Want to delete this message?')); ?>" title="<?php echo e(translate('messages.delete')); ?>"><i class="tio-delete-outlined"></i>
                                            </a>
                                            <form action="<?php echo e(route('admin.users.contact.contact-delete',[$contact['id']])); ?>"
                                                    method="post" id="contact-<?php echo e($contact['id']); ?>">
                                                <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if(count($contacts) !== 0): ?>
                    <hr>
                    <?php endif; ?>
                    <div class="page-area">
                        <?php echo $contacts->links(); ?>

                    </div>
                    <?php if(count($contacts) === 0): ?>
                    <div class="empty--data">
                        <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                        <h5>
                            <?php echo e(translate('messages.no_data_found')); ?>

                        </h5>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <!-- End Table -->
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/contact-index.js"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/contacts/list.blade.php ENDPATH**/ ?>