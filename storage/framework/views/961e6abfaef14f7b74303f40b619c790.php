<?php $__env->startSection('title', translate('messages.New Provider Request - Details')); ?>


<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between flex-wrap gap-3">
                <div>
                    <h1 class="page-header-title text-break">
                        <span class="page-header-icon">
                            <img src="<?php echo e(asset('/public/assets/admin/img/rental/provider-details.png')); ?>" class="w--22" alt="">
                        </span>
                        <span><?php echo e(translate('messages.Provider_Details')); ?>

                    </h1></span>
                    </h1>
                </div>
                <div class="d-flex align-items-start flex-wrap gap-2">
                    <a href="<?php echo e(route('admin.rental.provider.edit-basic-setup', $store->id)); ?>" class="btn btn--primary-light float-right mb-0">
                        <i class="tio-edit"></i> <?php echo e(translate('messages.edit_provider')); ?>

                    </a>
                    <?php if($store->vendor->status === null): ?>
                    <a class="btn btn--warning-light font-weight-bold float-right mb-0" data-deny="cancel" data-toggle="modal"
                       data-target="#exampleModal--cancel"><i
                            class="tio-clear font-weight-bold pr-1"></i>
                        <?php echo e(translate('messages.reject')); ?></a>
                    <?php endif; ?>
                    <a class="btn btn--primary font-weight-bold float-right mr-2 mb-0" data-deny="approve" data-toggle="modal"
                       data-target="#exampleModal--approve"
                       href="javascript:"><i
                            class="tio-done font-weight-bold pr-1"></i><?php echo e(translate('messages.approve')); ?></a>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="taxi-banner radius-10 mt-4 mb-20"
             style="background-image: url('<?php echo e($store->cover_photo_full_url ?? asset('public/assets/admin/img/100x100/1.png')); ?>'); background-repeat: no-repeat; background-position: center; background-size: cover;">
        <div class="taxi-info-wrapper d-flex flex-wrap flex-sm-nowrap gap-30px">
                <div class="logo">
                    <img data-onerror-image="<?php echo e(asset('public/assets/admin/img/100x100/1.png')); ?>"
                         src="<?php echo e($store->logo_full_url ?? asset('public/assets/admin/img/100x100/1.png')); ?>" width="150" class="rounded-8"
                         alt="">
                </div>
                <div class="taxi-info">
                    <h3 class="fs-20 fw-bold text--title mb-20"> <?php echo e($store->name); ?></h3>
                    <div class="details d-flex flex-wrap flex-column flex-sm-row gap-40px">
                        <div class="details-single d-flex align-items-center gap-2">
                            <img src="<?php echo e(asset('public/assets/admin/img/icons/zone.png')); ?>" width="36" height="36"
                                 class="rounded" alt="">
                            <div>
                                <h5 class="lh--12 mb-0 color-3C3C3C"> <?php echo e(translate('messages.Business_zone')); ?>

                                </h5>
                                <span class="fs-13 lh--12 color-484848"><?php echo e($store->address); ?></span>
                            </div>
                        </div>
                        <div class="details-single d-flex align-items-center gap-2">
                            <img src="<?php echo e(asset('public/assets/admin/img/icons/job-type.png')); ?>" width="36"
                                 height="36" class="rounded" alt="">
                            <div>
                                <h5 class="lh--12 mb-0 color-3C3C3C"> <?php echo e(translate('messages.Business_Plan')); ?>

                                </h5>
                                <?php if($store->store_business_model == 'none'): ?>
                                    <span class="fs-13 lh--12 color-484848"><?php echo e(translate($store->package->package_name )); ?></span><br>
                                    <span class="fs-13 lh--12 color-484848"><?php echo e(translate('payment_failed')); ?></span>
                                <?php else: ?>
                                <span class="fs-13 lh--12 color-484848"><?php echo e(translate($store->store_business_model )); ?></span>
                                <?php endif; ?>

                            </div>
                        </div>
                        <div class="details-single d-flex align-items-center gap-2">
                            <img src="<?php echo e(asset('/public/assets/admin/img/rental/det-icon.png')); ?>" width="36"
                                 height="36" class="rounded" alt="">
                            <div>
                                <h5 class="lh--12 mb-0 color-3C3C3C"> <?php echo e(translate('messages.Approx. Pickup Time')); ?>

                                </h5>
                                <span class="fs-13 lh--12 color-484848"><?php echo e($store->delivery_time); ?></span>
                            </div>
                        </div>
                      
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div>
                    <h5 class="text-title mb-1">
                        <?php echo e(translate('messages.Provider_Information')); ?>

                    </h5>
                    <p class="fs-12">
                        <?php echo e(translate('messages.Here you can see all the information that provider submit during registration')); ?>

                    </p>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-lg-6">
                        <div class="card __bg-FAFAFA border-0 h-100">
                            <div class="card-body">
                                <h5 class="mb-10px font-bold"> <?php echo e(translate('messages.General_Information')); ?>

                                </h5>
                                <?php ($language = \App\Models\BusinessSetting::where('key', 'language')->first()); ?>
                                <?php ($language = $language->value ?? null); ?>
                                <?php ($defaultLang = 'en'); ?>
                                <div class="div">
                                    <?php if($language): ?>
                                        <ul class="nav nav-tabs mb-4">
                                            <li class="nav-item">
                                                <a class="nav-link lang_link active" href="#"
                                                   id="default-link"><?php echo e(translate('Default')); ?></a>
                                            </li>
                                            <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="nav-item">
                                                    <a class="nav-link lang_link" href="#"
                                                       id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    <?php endif; ?>
                                    <?php if($language): ?>
                                        <div class="lang_form" id="default-form">
                                            <div class="resturant--info-address">
                                                <ul class="address-info address-info-2 p-0 text-dark">
                                                    <li class="d-flex align-items-start">
                                                        <span class="label min-w-sm-auto"><?php echo e(translate('messages.Vendor Name')); ?></span>
                                                        <span>: <?php echo e($store->name); ?> <?php echo e($store->name); ?></span>
                                                    </li>
                                                    <li class="d-flex align-items-start">
                                                        <span class="label min-w-sm-auto"><?php echo e(translate('messages.Business Address')); ?></span>
                                                        <span>: <?php echo e($store->address); ?> </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                if(count($store?->translations ?? [])){
                                                    $translate = [];
                                                    foreach($store['translations'] as $t)
                                                    {
                                                        if($t->locale == $lang && $t->key=="name"){
                                                            $translate[$lang]['name'] = $t->value;
                                                        }
                                                    }
                                                }
                                            ?>
                                            <div class="d-none lang_form" id="<?php echo e($lang); ?>-form">
                                                <div class="resturant--info-address">
                                                    <ul class="address-info address-info-2 p-0 text-dark">
                                                        <li class="d-flex align-items-start">
                                                            <span class="label min-w-sm-auto"><?php echo e(translate('messages.Provider Name')); ?></span>
                                                            <span>: <?php echo e($translate[$lang]['name']??''); ?></span>
                                                        </li>
                                                        <li class="d-flex align-items-start">
                                                            <span class="label min-w-sm-auto"><?php echo e(translate('messages.Business Address')); ?></span>
                                                            <span>: <?php echo e($store->address); ?> </span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <div id="default-form">
                                            <div class="resturant--info-address">
                                                <ul class="address-info address-info-2 p-0 text-dark">
                                                    <li class="d-flex align-items-start">
                                                        <span class="label min-w-sm-auto"><?php echo e(translate('messages.Provider Name')); ?></span>
                                                        <span>: <?php echo e($store->name); ?> <?php echo e($store->name); ?></span>
                                                    </li>
                                                    <li class="d-flex align-items-start">
                                                        <span class="label min-w-sm-auto"><?php echo e(translate('messages.Business Address')); ?></span>
                                                        <span>: <?php echo e($store->address); ?></span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-6">
                        <div class="card __bg-FAFAFA border-0 h-100">
                            <div class="card-body">
                                <h5 class="mb-10px font-bold"> <?php echo e(translate('messages.Owner_Information')); ?>

                                </h5>
                                <div class="resturant--info-address">
                                    <ul class="address-info address-info-2 p-0 text-dark">
                                        <li class="d-flex align-items-start">
                                            <span class="label min-w-sm-auto"><?php echo e(translate('messages.First Name')); ?></span>
                                            <span>: <?php echo e($store->vendor->f_name); ?> </span>
                                        </li>
                                        <li class="d-flex align-items-start">
                                            <span class="label min-w-sm-auto"><?php echo e(translate('messages.Last Name')); ?></span>
                                            <span>: <?php echo e($store->vendor->l_name); ?></span>
                                        </li>
                                        <li class="d-flex align-items-start">
                                            <span class="label min-w-sm-auto"><?php echo e(translate('messages.Phone')); ?></span>
                                            <span>: <?php echo e($store->vendor->phone); ?></span>
                                        </li>
                                    </ul>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card __bg-FAFAFA border-0 h-100">
                            <div class="card-body">
                                <h5 class="mb-10px font-bold"> <?php echo e(translate('messages.Pickup_Zone')); ?>

                                </h5>
                                <div class="d-flex gap-2 gap-sm-3 flex-wrap">
                                    <?php $__currentLoopData = json_decode($store->pickup_zone_id) ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pickup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $zoneName = $store->pickupZones[$pickup] ?? 'Unknown Zone';
                                        ?>
                                        <label class="badge badge-soft-dark rounded-20 p-2 m-0 font-medium">
                                            <?php echo e($zoneName); ?>

                                        </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card __bg-FAFAFA border-0 h-100">
                            <div class="card-body">
                                <h5 class="mb-10px font-bold"> <?php echo e(translate('messages.Login Information')); ?>

                                </h5>


                                <div class="resturant--info-address">
                                    <ul class="address-info address-info-2 p-0 text-dark">
                                        <li class="d-flex align-items-start">
                                            <span class="label min-w-sm-auto"><?php echo e(translate('messages.Email')); ?></span>
                                            <span>: <?php echo e($store->vendor->email); ?></span>
                                        </li>
                                        <li class="d-flex align-items-start">
                                            <span class="label min-w-sm-auto"><?php echo e(translate('messages.Password')); ?></span>
                                            <span>: <?php echo e(translate('*************')); ?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                            <div class="d-flex justify-content-end gap-3">
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
<?php $__env->stopSection(); ?>


<?php $__env->startPush('script_2'); ?>
 <script src="<?php echo e(asset('Modules/Rental/public/assets/js/admin/view-pages/new-provider-details.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/provider/new-request-details.blade.php ENDPATH**/ ?>