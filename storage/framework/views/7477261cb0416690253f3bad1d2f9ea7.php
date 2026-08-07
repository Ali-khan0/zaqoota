    <!-- Page Header -->
    <div class="page-header pb-0">
        <div class="page-header">
            <div class="d-flex justify-content-between flex-wrap gap-3">
                <div>
                    <h1 class="page-header-title text-break">
                        <span class="page-header-icon">
                            <img src="<?php echo e(asset('public/assets/admin/img/store.png')); ?>" class="w--22" alt="">
                        </span>
                        <span><?php echo e(translate('messages.Provider_Details')); ?>

                    </h1></span>
                    </h1>
                </div>
                <?php if(!request()->tab): ?>
                    <div class="d-flex align-items-start flex-wrap gap-2">
                        <a href="javascript:" class="btn btn--reset d-flex justify-content-between align-items-center gap-4 lh--1 h--45px">
                            <?php echo e(translate('messages.status')); ?>

                            <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox<?php echo e($store->id); ?>">
                                <input type="checkbox" data-url="<?php echo e(route('admin.store.status',[$store['id'],$store->status?0:1])); ?>"
                                       class="toggle-switch-input redirect-url" id="stocksCheckbox<?php echo e($store->id); ?>" <?php echo e($store->status?'checked':''); ?>>
                                <span class="toggle-switch-label">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </a>
                        <a href="<?php echo e(route('admin.rental.provider.edit-basic-setup', $store->id)); ?>" class="btn btn--primary font-weight-bold float-right mr-2 mb-0">
                            <i class="tio-edit"></i> <?php echo e(translate('messages.edit_provider')); ?>

                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php if($store->vendor->status): ?>
        <!-- Nav Scroller -->
        <div class="js-nav-scroller hs-nav-scroller-horizontal">
            <span class="hs-nav-scroller-arrow-prev d-none">
                <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                    <i class="tio-chevron-left"></i>
            </a>
            </span>

            <span class="hs-nav-scroller-arrow-next d-none">
                <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                    <i class="tio-chevron-right"></i>
                </a>
            </span>

            <!-- Nav -->
            <ul class="nav nav-tabs page-header-tabs mb-2">
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request('tab')==null?'active':''); ?>" href="<?php echo e(route('admin.rental.provider.details', $store->id)); ?>"><?php echo e(translate('messages.overview')); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request('tab')=='order'?'active':''); ?>" href="<?php echo e(route('admin.rental.provider.details', ['id'=>$store->id, 'tab'=> 'order'])); ?>"  aria-disabled="true"><?php echo e(translate('messages.Trip List')); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request('tab')=='driver'?'active':''); ?>" href="<?php echo e(route('admin.rental.provider.details', ['id'=>$store->id, 'tab'=> 'driver'])); ?>"  aria-disabled="true"><?php echo e(translate('messages.driver list')); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request('tab')=='vehicle'?'active':''); ?>" href="<?php echo e(route('admin.rental.provider.details', ['id'=>$store->id, 'tab'=> 'vehicle'])); ?>"  aria-disabled="true"><?php echo e(translate('messages.Vehicles')); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request('tab')=='reviews'?'active':''); ?>" href="<?php echo e(route('admin.rental.provider.details', ['id'=>$store->id, 'tab'=> 'reviews'])); ?>"  aria-disabled="true"><?php echo e(translate('messages.reviews')); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request('tab')=='discount'?'active':''); ?>" href="<?php echo e(route('admin.rental.provider.details', ['id'=>$store->id, 'tab'=> 'discount'])); ?>"  aria-disabled="true"><?php echo e(translate('messages.discounts')); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request('tab')=='transaction'?'active':''); ?>" href="<?php echo e(route('admin.rental.provider.details', ['id'=>$store->id, 'tab'=> 'transaction'])); ?>"  aria-disabled="true"><?php echo e(translate('messages.transactions')); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request('tab')=='settings'?'active':''); ?>" href="<?php echo e(route('admin.rental.provider.details', ['id'=>$store->id, 'tab'=> 'settings'])); ?>"  aria-disabled="true"><?php echo e(translate('messages.settings')); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request('tab')=='conversations'?'active':''); ?>" href="<?php echo e(route('admin.rental.provider.details', ['id'=>$store->id, 'tab'=> 'conversations'])); ?>"  aria-disabled="true"><?php echo e(translate('Conversations')); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request('tab')=='meta-data'?'active':''); ?>" href="<?php echo e(route('admin.rental.provider.details', ['id'=>$store->id, 'tab'=> 'meta-data'])); ?>"  aria-disabled="true"><?php echo e(translate('meta_data')); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  <?php echo e(request('tab')=='disbursements' ?'active':''); ?>" href="<?php echo e(route('admin.rental.provider.details', ['id'=>$store->id, 'tab'=> 'disbursements'])); ?>"  aria-disabled="true"><?php echo e(translate('messages.disbursements')); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  <?php echo e(request('tab')=='business_plan' ?'active':''); ?>" href="<?php echo e(route('admin.rental.provider.details', ['id'=>$store->id, 'tab'=> 'business_plan'])); ?>"  aria-disabled="true"><?php echo e(translate('messages.business_plan')); ?></a>
                </li>
            </ul>
            <!-- End Nav -->
        </div>
        <!-- End Nav Scroller -->
        <?php endif; ?>
    </div>
    <!-- End Page Header -->
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/provider/details/partials/_header.blade.php ENDPATH**/ ?>