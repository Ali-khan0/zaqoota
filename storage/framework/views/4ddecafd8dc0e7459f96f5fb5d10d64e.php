<?php $__env->startSection('title',$store->name."'s ".translate('messages.conversation')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <!-- Custom styles for this page -->
    <link href="<?php echo e(asset('public/assets/admin/css/croppie.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('Modules/Rental/public/assets/css/admin/provider-conversation.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <?php echo $__env->make('rental::admin.provider.details.partials._header',['store'=>$store], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!-- Page Heading -->
    <div class="tab-content">
        <div class="tab-pane fade show active" id="product">
            <div class="row pt-2">
                <div class="content container-fluid">
                    <!-- Page Header -->
                    <div class="page-header">
                        <h1 class="page-header-title"><?php echo e(translate('messages.conversation_list')); ?></h1>
                    </div>
                    <!-- End Page Header -->

                    <div class="row g-3">
                        <div class="col-lg-4 col-md-6">
                            <!-- Card -->
                            <div class="card">
                                <div class="card-header border-0">
                                    <div class="input-group input---group">
                                        <div class="input-group-prepend border-inline-end-0">
                                            <span class="input-group-text border-inline-end-0" id="basic-addon1"><i class="tio-search"></i></span>
                                        </div>
                                        <input type="text" class="form-control border-inline-start-0 pl-1" id="serach" placeholder="<?php echo e(translate('Search')); ?>" aria-label="Username"
                                            aria-describedby="basic-addon1" autocomplete="off">
                                    </div>
                                </div>
                                <input type="hidden" id="vendor_id" value="<?php echo e($store->id); ?>">
                                <!-- Body -->
                                <div class="card-body p-0 conversation-list-scroll" id="vendor-conversation-list">
                                    <div class="border-bottom"></div>
                                    <?php echo $__env->make('admin-views.vendor.view.partials._conversation_list', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                </div>
                                <!-- End Body -->
                            </div>
                            <!-- End Card -->
                        </div>
                        <div class="col-lg-8 col-nd-6" id="vendor-view-conversation">
                            <div class="text-center mt-2">
                                <h4 class="initial-29"><?php echo e(translate('messages.view_conversation')); ?>

                                </h4>
                            </div>
                        </div>
                    </div>
                    <!-- End Row -->
                </div>


            </div>
        </div>
    </div>
</div>

<div class="d-none" id="data-set"
     data-message-list-url="<?php echo e(route('admin.store.message-list')); ?>"
        data-view-conv-url="<?php echo e(route('admin.store.view', ['store' => $store->id, 'tab' => 'conversations'])); ?>"
     >
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
<script src="<?php echo e(asset('Modules/Rental/public/assets/js/admin/view-pages/provi-conversation.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/provider/details/conversations.blade.php ENDPATH**/ ?>