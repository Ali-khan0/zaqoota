<?php $__env->startSection('title',$store->name."'s ".translate('messages.discount')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <!-- Custom styles for this page -->
    <link href="<?php echo e(asset('public/assets/admin/css/croppie.css')); ?>" rel="stylesheet">

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <?php echo $__env->make('rental::admin.provider.details.partials._header',['store'=>$store], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!-- Page Heading -->
    <div class="tab-content">
        <div class="tab-pane fade show active" id="vendor">
            <div class="card">
                <div class="card-header">
                    <div>

                        <h5 class="card-title">
                            <i class="tio-info"></i>
                            <span><?php echo e(translate('messages.discount_info')); ?></span>
                        </h5>
                        <div class="text--info mb-3">
                            <?php echo e(translate('* When this discount is available, is applied on all the vehicles in this provider.')); ?>

                        </div>
                    </div>
                    <div class="btn--container justify-content-end">
                        <?php if($store->discount): ?>
                        <button type="button" class="btn-sm btn--primary" data-toggle="modal" data-target="#updatesettingsmodal">
                            <i class="tio-open-in-new"></i> <?php echo e(translate('messages.update')); ?>

                        </button>
                        <button type="button" data-id="discount-<?php echo e($store->id); ?>" data-message="<?php echo e(translate('Want to remove discount?')); ?>" class="btn btn--danger text-white form-alert"><i class="tio-delete-outlined"></i>  <?php echo e(translate('messages.delete')); ?></button>
                        <?php else: ?>
                        <button type="button" class="btn-sm btn--primary" data-toggle="modal" data-target="#updatesettingsmodal">
                            <i class="tio-add"></i> <?php echo e(translate('messages.add_discount')); ?>

                        </button>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <?php if($store->discount): ?>
                    <div class="row gy-3">
                        <div class="col-md-4 align-self-center text-center">

                            <div class="discount-item text-center">
                                <h5 class="subtitle"><?php echo e(translate('messages.discount_amount')); ?></h5>
                                <h4 class="amount"><?php echo e($store->discount?round($store->discount->discount):0); ?>%</h4>
                            </div>

                        </div>
                        <div class="col-md-4 text-center text-md-left">
                            <div class="discount-item">
                                <h5 class="subtitle"><?php echo e(translate('messages.duration')); ?></h5>
                                <ul class="list-unstyled list-unstyled-py-3 text-dark">
                                    <li class="p-0 pt-1 justify-content-center justify-content-md-start">
                                        <span><?php echo e(translate('messages.start_date')); ?> :</span>
                                        <strong><?php echo e($store->discount?date('Y-m-d',strtotime($store->discount->start_date)):''); ?> <?php echo e($store->discount?date(config('timeformat'), strtotime($store->discount->start_time)):''); ?></strong>
                                    </li>
                                    <li class="p-0 pt-1 justify-content-center justify-content-md-start">
                                        <span><?php echo e(translate('messages.end_date')); ?> :</span>
                                        <strong><?php echo e($store->discount?date('Y-m-d', strtotime($store->discount->end_date)):''); ?> <?php echo e($store->discount?date(config('timeformat'), strtotime($store->discount->end_time)):''); ?></strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4 text-center text-md-left">

                            <h5 class="subtitle"><?php echo e(translate('purchase_conditions')); ?></h5>

                            <ul class="list-unstyled list-unstyled-py-3 text-dark">
                                <li class="p-0 pt-1 justify-content-center justify-content-md-start">
                                    <span><?php echo e(translate('messages.max_discount')); ?> :</span>
                                    <strong><?php echo e(\App\CentralLogics\Helpers::format_currency($store->discount?$store->discount->max_discount:0)); ?></strong>
                                </li>
                                <li class="p-0 pt-1 justify-content-center justify-content-md-start">
                                    <span><?php echo e(translate('messages.min_purchase')); ?> :</span>
                                    <strong><?php echo e(\App\CentralLogics\Helpers::format_currency($store->discount?$store->discount->min_purchase:0)); ?></strong>
                                </li>
                            </ul>

                        </div>
                    </div>
                    <?php else: ?>
                    <div class="text-center">
                        <span class="card-subtitle"><?php echo e(translate('no_discount_created_yet')); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="updatesettingsmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header shadow py-3">
        <h5 class="modal-title" id="exampleModalCenterTitle"><?php echo e($store->discount?translate('messages.update'):translate('messages.add_discount')); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body pb-4 pt-4">
        <form id="discount-form" method="POST">
            <?php echo csrf_field(); ?>
            <div class="row gx-2">
                <div class="col-md-4 col-6">
                    <div class="form-group">
                        <label class="input-label" for="title"><?php echo e(translate('messages.discount_amount')); ?> (%)</label>
                        <input type="number" min="0" max="100" step="0.01" name="discount" class="form-control" required value="<?php echo e($store->discount?$store->discount->discount:'0'); ?>">
                    </div>
                </div>
                <div class="col-md-4 col-6">
                    <div class="form-group">
                        <label class="input-label" for="title"><?php echo e(translate('messages.min_purchase')); ?> (<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)</label>
                        <input type="number" name="min_purchase" step="0.01" min="0" max="999999999" class="form-control" placeholder="100" value="<?php echo e($store->discount?$store->discount->min_purchase:'0'); ?>">
                    </div>
                </div>
                <div class="col-md-4 col-6">
                    <div class="form-group">
                        <label class="input-label" for="title"><?php echo e(translate('messages.max_discount')); ?> (<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)</label>
                        <input type="number" min="0" max="999999999" step="0.01" name="max_discount" class="form-control" value="<?php echo e($store->discount?$store->discount->max_discount:'0'); ?>">
                    </div>
                </div>
            </div>
            <div class="row gx-2">
                <div class="col-md-6 col-6">
                    <div class="form-group">
                        <label class="input-label" for="title"><?php echo e(translate('messages.start_date')); ?></label>
                        <input type="date" id="date_from" class="form-control" required name="start_date" value="<?php echo e($store->discount?date('Y-m-d',strtotime($store->discount->start_date)):''); ?>">
                    </div>
                </div>
                <div class="col-md-6 col-6">
                    <div class="form-group">
                        <label class="input-label" for="title"><?php echo e(translate('messages.end_date')); ?></label>
                        <input type="date" id="date_to" class="form-control" required name="end_date" value="<?php echo e($store->discount?date('Y-m-d', strtotime($store->discount->end_date)):''); ?>">
                    </div>

                </div>
                <div class="col-md-6 col-6">
                    <div class="form-group">
                        <label class="input-label" for="title"><?php echo e(translate('messages.start_time')); ?></label>
                        <input type="time" id="start_time" class="form-control" required name="start_time" value="<?php echo e($store->discount?date('H:i',strtotime($store->discount->start_time)):'00:00'); ?>">
                    </div>
                </div>
                <div class="col-md-6 col-6">
                    <label class="input-label" for="title"><?php echo e(translate('messages.end_time')); ?></label>
                    <input type="time" id="end_time" class="form-control" required name="end_time" value="<?php echo e($store->discount?date('H:i', strtotime($store->discount->end_time)):'23:59'); ?>">
                </div>
            </div>
            <div class="btn--container justify-content-end">
                <button type="reset" class="btn btn--reset"><?php echo e(translate('reset')); ?></button>
                <?php if($store->discount): ?>
                    <button type="submit" class="btn btn--primary"><i class="tio-open-in-new"></i> <?php echo e(translate('messages.update')); ?></button>
                <?php else: ?>
                    <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.add')); ?></button>
                <?php endif; ?>
            </div>
        </form>
        <form action="<?php echo e(route('admin.store.clear-discount',[$store->id])); ?>" method="post" id="discount-<?php echo e($store->id); ?>">
            <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
        </form>
      </div>
    </div>
  </div>
</div>


<div class="d-none" id="data-set"
     data-discount-url="<?php echo e(route('admin.store.discount',$store->id)); ?>">
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
<script src="<?php echo e(asset('Modules/Rental/public/assets/js/admin/view-pages/provider-discount.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/provider/details/discount.blade.php ENDPATH**/ ?>