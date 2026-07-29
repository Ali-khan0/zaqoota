    <!-- Page Header -->
    <div class="page-header pb-0">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-20">
            <div>
                <h1 class="page-header-title text-break fs-24 m-0">
                    <span class="page-header-icon">
                        <img src="<?php echo e(asset('public/assets/admin/img/store-new.png')); ?>" class="w--26" alt="">
                    </span>
                    <span><?php echo e($store->name); ?></span>
                </h1>
            </div>
            <div class="d-flex align-items-center flex-wrap gap-3">

                <a href=" <?php echo e(!isset($store->vendor->status) || $store->vendor->status == 0 ? route('admin.store.edit', [$store->id, 'pending'=>1]) : route('admin.store.edit', [$store->id])); ?>"
                    class="btn btn--primary border-0 bg--soft-priamry-10 text-primary m-0 float-right">
                    <i class="tio-edit"></i> <?php echo e($store->module_type == 'rental' ? translate('messages.Edit_Provider') :translate('messages.Edit_Store')); ?>

                </a>
                <?php if(!isset($store->vendor->status) || $store->vendor->status == 0): ?>
                    <?php if(!isset($store->vendor->status)): ?>
                        <a class="btn btn--danger border-0 bg--soft-danger-10 text-danger m-0 text-capitalize font-weight-bold float-right "
                            href="javascript:" data-toggle="modal" data-target="#confirmation-reason-btn"><i
                                class="tio-clear font-weight-bold pr-1"></i> <?php echo e(translate('messages.Reject')); ?></a>
                    <?php endif; ?>
                    <a class="btn btn--primary border-0 m-0 text-capitalize font-weight-bold float-right swal_fire_alert"
                        data-url="<?php echo e(route('admin.store.application', [$store['id'], 1])); ?>"
                         data-title="<?php echo e(translate('messages.are_you_sure_?')); ?>"
                                       data-image_url="<?php echo e(asset('public/assets/admin/img/off-danger.png')); ?>"
                                       data-confirm_button_text="<?php echo e(translate('messages.yes')); ?>"
                                       data-cancel_button_text="<?php echo e(translate('messages.No')); ?>"
                                       data-message="<?php echo e(translate('messages.you_want_to_approve_the_vendor_joining_request.')); ?>"
                        href="javascript:"><i
                            class="tio-done font-weight-bold pr-1"></i><?php echo e(translate('messages.approve')); ?></a>
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
                        <a class="nav-link <?php echo e(request('tab') == null ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.store.view', $store->id)); ?>"><?php echo e(translate('messages.overview')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request('tab') == 'order' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.store.view', ['store' => $store->id, 'tab' => 'order'])); ?>"
                            aria-disabled="true"><?php echo e(translate('messages.orders')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request('tab') == 'item' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.store.view', ['store' => $store->id, 'tab' => 'item'])); ?>"
                            aria-disabled="true"><?php echo e(translate('messages.items')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request('tab') == 'reviews' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.store.view', ['store' => $store->id, 'tab' => 'reviews'])); ?>"
                            aria-disabled="true"><?php echo e(translate('messages.reviews')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request('tab') == 'discount' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.store.view', ['store' => $store->id, 'tab' => 'discount'])); ?>"
                            aria-disabled="true"><?php echo e(translate('messages.discounts')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request('tab') == 'transaction' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.store.view', ['store' => $store->id, 'tab' => 'transaction'])); ?>"
                            aria-disabled="true"><?php echo e(translate('messages.transactions')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request('tab') == 'settings' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.store.view', ['store' => $store->id, 'tab' => 'settings'])); ?>"
                            aria-disabled="true"><?php echo e(translate('messages.settings')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request('tab') == 'conversations' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.store.view', ['store' => $store->id, 'tab' => 'conversations'])); ?>"
                            aria-disabled="true"><?php echo e(translate('Conversations')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e(request('tab') == 'meta-data' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.store.view', ['store' => $store->id, 'tab' => 'meta-data'])); ?>"
                            aria-disabled="true"><?php echo e(translate('meta_data')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  <?php echo e(request('tab') == 'disbursements' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.store.view', ['store' => $store->id, 'tab' => 'disbursements'])); ?>"
                            aria-disabled="true"><?php echo e(translate('messages.disbursements')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  <?php echo e(request('tab') == 'business_plan' ? 'active' : ''); ?>"
                            href="<?php echo e(route('admin.store.view', ['store' => $store->id, 'tab' => 'business_plan'])); ?>"
                            aria-disabled="true"><?php echo e(translate('messages.business_plan')); ?></a>
                    </li>
                </ul>
                <!-- End Nav -->
            </div>
            <!-- End Nav Scroller -->
        <?php endif; ?>
    </div>
    <!-- End Page Header -->


    <!-- Confiramtion Reason Modal -->
    <div class="modal shedule-modal fade" id="confirmation-reason-btn" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content pb-2 max-w-500">
                <form action="<?php echo e(route('admin.store.application', [$store['id'], 0])); ?>" method="get">
                <div class="modal-header">
                    <button type="button"
                        class="close bg-modal-btn w-30px h-30 rounded-circle position-absolute right-0 top-0 m-2 z-2"
                        data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img src="<?php echo e(asset('public/assets/admin/img/delete-confirmation.png')); ?>" alt="icon"
                            class="mb-3">
                        <h3 class="mb-2"><?php echo e(translate('messages.Are_you_sure_?')); ?></h3>
                        <p class="mb-0"><?php echo e(translate('You want to deny this joining application?')); ?></p>
                    </div>
                    <div class="px-3 mt-4">
                        <h5 class="mb-2"><?php echo e(translate('messages.Reason')); ?></h5>
                        <textarea name="rejection_note" id="" class="form-control" rows="2" required
                            placeholder="<?php echo e(translate('messages.Type_here_the_denied_reason...')); ?>"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-center border-0 pt-0 gap-2">
                    <button type="button" class="btn min-w-120px btn--reset" data-dismiss="modal"><?php echo e(translate('messages.No')); ?></button>
                    <button type="submit" class="btn min-w-120px btn--primary"><?php echo e(translate('messages.Yes')); ?></button>
                </div>
            </form>
            </div>
        </div>
    </div>
<?php /**PATH /var/www/zaqoota/resources/views/admin-views/vendor/view/partials/_header.blade.php ENDPATH**/ ?>