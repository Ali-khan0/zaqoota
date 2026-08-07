<?php $__env->startSection('title',translate('messages.new_provider_requests')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <img class="onerror-image"
                src="<?php echo e(asset('/public/assets/admin/img/rental/provider.png')); ?>" width="30" alt="img"> &nbsp;
                <?php echo e(translate('messages.new_provider_requests')); ?></h1>
            <div class="page-header-select-wrapper">

                <?php if(!isset(auth('admin')->user()->zone_id)): ?>
                    <div class="select-item">
                        <select name="zone_id" class="form-control js-select2-custom set-filter" data-url="<?php echo e(url()->full()); ?>" data-filter="zone_id">
                            <option value="" <?php echo e(!request('zone_id')?'selected':''); ?>><?php echo e(translate('messages.All_Zones')); ?></option>
                            <?php $__currentLoopData = \App\Models\Zone::orderBy('name')->get(['name','id' ]); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option
                                    value="<?php echo e($z['id']); ?>" <?php echo e(isset($zone) && $zone->id == $z['id']?'selected':''); ?>>
                                    <?php echo e($z['name']); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                <?php endif; ?>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="js-nav-scroller hs-nav-scroller-horizontal mt-2">
                        <!-- Nav -->
                        <ul class="nav nav-tabs mb-3 border-0 nav--tabs">
                            <li class="nav-item">
                                <a class="nav-link <?php echo e(request('request_type') == 'pending_provider' ? 'active' : ''); ?>" href="<?php echo e(route('admin.rental.provider.new-requests')); ?>?request_type=pending_provider"   aria-disabled="true"><?php echo e(translate('messages.Pending_Request')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?php echo e(request('request_type') == 'denied_provider' ? 'active' : ''); ?>" href="<?php echo e(route('admin.rental.provider.new-requests')); ?>?request_type=denied_provider"  aria-disabled="true"><?php echo e(translate('messages.Rejected_Request')); ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <!-- Header -->
            <div class="card-header py-2">
                <div class="search--button-wrapper">
                    <h5 class="card-title"><?php echo e(translate('messages.providers_list')); ?> <span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($stores->total()); ?></span></h5>
                    <form action="javascript:" id="search-form" class="search-form">
                        <!-- Search -->
                        <?php echo csrf_field(); ?>
                        <div class="input-group input--group">
                            <input id="datatableSearch_" type="search" name="search" class="form-control"
                                   placeholder="<?php echo e(translate('ex_:_Search_Provider_Name')); ?>" value="<?php echo e(isset($search_by) ? $search_by : ''); ?>" aria-label="<?php echo e(translate('messages.search')); ?>" required>
                            <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                        </div>
                    </form>
                    <!-- End Search -->
                </div>
            </div>
            <!-- End Header -->

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
                        <tr>
                            <th class="border-0"><?php echo e(translate('sl')); ?></th>
                            <th class="border-0"><?php echo e(translate('messages.provider')); ?></th>
                            <th class="border-0"><?php echo e(translate('messages.owner_info')); ?></th>
                            <th class="border-0"><?php echo e(translate('messages.business_zone')); ?></th>
                            <th class="text-uppercase border-0"><?php echo e(translate('messages.business_plan')); ?></th>
                            <th class="text-center border-0"><?php echo e(translate('messages.action')); ?></th>
                        </tr>
                    </thead>

                    <tbody id="set-rows">
                    <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+$stores->firstItem()); ?></td>
                            <td>
                                <div>
                                    <a href="<?php echo e(route('admin.rental.provider.new-requests-details', $store->id)); ?>" class="table-rest-info" alt="<?php echo e(translate('view provider')); ?>">
                                        <img class="img--60 circle onerror-image" data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
                                             src="<?php echo e($store['logo_full_url'] ?? asset('public/assets/admin/img/160x160/img1.jpg')); ?>" >
                                        <div class="info"><div class="text--title">
                                                <?php echo e(Str::limit($store->name,20,'...')); ?>

                                            </div>
                                            <div class="font-light">
                                                <?php echo e($store['phone']); ?>

                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <div class="table-rest-info d-block">
                                    <div class="info">
                                        <div title="<?php echo e($store->vendor->f_name.' '.$store->vendor->l_name); ?>" class="text--title">
                                            <?php echo e(Str::limit($store->vendor->f_name.' '.$store->vendor->l_name,20,'...')); ?>

                                        </div>
                                        <div>
                                            <span class="font-light">
                                                <?php echo e($store['email']); ?>

                                            </span>
                                        </div>
                                    </div>
                                </div>

                            </td>
                            <td>
                                <?php echo e($store->zone?$store->zone->name:translate('messages.zone_deleted')); ?>

                            </td>
                            <td>
                                <div class="table-rest-info d-block">
                                    <div class="info">
                                        <div title="Car Rental Service" class="text--title">
                                            <?php echo e(ucwords($store->store_business_model)); ?>

                                        </div>
                                        <div>
                                            <span class="font-light">
                                                <?php echo e($store?->package?->package_name); ?>

                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="btn--container justify-content-center">
                                    <?php if($store->vendor->status == 0): ?>
                                        <button type="button"
                                                class="btn action-btn btn--varify btn-outline-varify shadow-none"
                                                data-deny="approve" data-toggle="modal"
                                                data-target="#exampleModal--approve"><i class="tio-done"></i>
                                        </button>
                                    <?php endif; ?>
                                    <?php if(!isset($store->vendor->status)): ?>
                                        <button type="button"
                                                class="btn action-btn btn--danger btn-outline-danger shadow-none"
                                                data-deny="cancel" data-toggle="modal"
                                                data-target="#exampleModal--cancel"><i class="tio-clear"></i>
                                        </button>
                                    <?php endif; ?>
                                    <a class="btn action-btn btn--warning btn-outline-warning"
                                       href="<?php echo e(route('admin.rental.provider.new-requests-details', $store->id)); ?>"
                                       title="<?php echo e(translate('messages.details')); ?>"><i
                                            class="tio-visible-outlined"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="exampleModal--approve" tabindex="-1" aria-labelledby="exampleModalLabel--approve"
                             aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body pt-5 p-md-5">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <img src="<?php echo e(asset('public/assets/admin/img/new-img/close-icon-dark.svg')); ?>" alt="">
                                        </button>

                                        <div class="d-flex justify-content-center mb-4">
                                            <img width="75" height="75" src="<?php echo e(asset('public/assets/admin/img/modal/mark.png')); ?>"
                                                 class="rounded-circle" alt="">
                                        </div>

                                        <h3 class="text--title mb-6 font-medium text-center">
                                            <?php echo e(translate('Are you sure, want to approve the request?')); ?></h3>
                                        <form method="get" action="<?php echo e(route('admin.rental.provider.approve-or-deny',[$store['id'],1])); ?>">
                                            <?php echo csrf_field(); ?>
                                            <div class="form-floating">
                                                <input type="hidden" value="1" name="status">
                                                <div class="d-flex justify-content-center gap-3">
                                                    <button type="button" data-dismiss="modal" aria-label="Close"
                                                            class="btn btn--reset"><?php echo e(translate('Cancel')); ?></button>
                                                    <button type="submit" class="btn btn--primary"><?php echo e(translate('Approve')); ?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="exampleModal--cancel" tabindex="-1" aria-labelledby="exampleModalLabel--cancel"
                             aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body pt-5 p-md-5">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <img src="<?php echo e(asset('public/assets/admin/img/new-img/close-icon-dark.svg')); ?>" alt="">
                                        </button>

                                        <div class="d-flex justify-content-center mb-4">
                                            <img width="75" height="75" src="<?php echo e(asset('public/assets/admin/img/icons/delete.png')); ?>"
                                                 class="rounded-circle" alt="">
                                        </div>

                                        <h3 class="text--title mb-6 font-medium text-center">
                                            <?php echo e(translate('Are you sure, want to cancel the request?')); ?></h3>
                                        <form method="get" action="<?php echo e(route('admin.rental.provider.approve-or-deny',[$store['id'],0])); ?>">
                                            <?php echo csrf_field(); ?>
                                            <div class="form-floating">
                                                <label for="add-your-note" class="font-medium input-label text--title"><?php echo e(translate('Cancellation Note')); ?>

                                                    <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="Cancellation Note">
                                                            <i class="tio-info text--title opacity-60"></i>
                                                    </span>
                                                </label>
                                                <div class="mb-30">
                                                    <textarea
                                                        class="form-control h--90"
                                                        placeholder="<?php echo e(translate('Type your Cancellation Note')); ?>"
                                                        name="message"
                                                        id="add-your-note"
                                                        maxlength="60"
                                                        required
                                                    ></textarea>
                                                    <div id="char-count">0/60</div>
                                                </div>
                                                <input type="hidden" value="0" name="status">
                                                <div class="d-flex justify-content-end gap-3">
                                                    <button type="button" data-dismiss="modal" aria-label="Close"
                                                            class="btn btn--reset"><?php echo e(translate('Cancel')); ?></button>
                                                    <button type="submit" class="btn btn--primary"><?php echo e(translate('Deny')); ?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

            </div>
            <!-- End Table -->
            <?php if(count($stores) !== 0): ?>
                <hr>
            <?php endif; ?>
            <div class="page-area">
                <?php echo $stores->withQueryString()->links(); ?>

            </div>
            <?php if(count($stores) === 0): ?>
                <div class="empty--data">
                    <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                    <h5>
                        <?php echo e(translate('no_data_found')); ?>

                    </h5>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="d-none" id="data-set"
        data-translate-are-you-sure="<?php echo e(translate('Are_you_sure?')); ?>"
        data-translate-no="<?php echo e(translate('no')); ?>"
        data-translate-yes="<?php echo e(translate('yes')); ?>"
         data-full-url="<?php echo e(url()->full()); ?>"
    ></div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
<script src="<?php echo e(asset('Modules/Rental/public/assets/js/admin/view-pages/new-provider-list.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/provider/new-request.blade.php ENDPATH**/ ?>