<?php $__env->startSection('title',translate('messages.update_notification')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/notification.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.notification_update')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="card">
            <div class="card-body">
                <form action="<?php echo e(route('admin.notification.update',[$notification['id']])); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div class="row g-2">
                                <div class="col-12">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.title')); ?></label>
                                        <input type="text" value="<?php echo e($notification['title']); ?>" name="notification_title" class="form-control" placeholder="<?php echo e(translate('messages.new_notification')); ?>" required maxlength="191">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.zone')); ?></label>
                                        <select name="zone" id="zone" class="form-control js-select2-custom" >
                                            <option value="all" <?php echo e(isset($notification->zone_id)?'':'selected'); ?>><?php echo e(translate('messages.all_zone')); ?></option>
                                            <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($zone['id']); ?>"  <?php echo e($notification->zone_id==$zone['id']?'selected':''); ?>><?php echo e($zone['name']); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="tergat"><?php echo e(translate('messages.send_to')); ?></label>

                                        <select name="tergat" class="form-control" id="tergat" data-placeholder="<?php echo e(translate('messages.select_tergat')); ?>" required>
                                            <option value="customer" <?php echo e($notification->tergat=='customer'?'selected':''); ?>><?php echo e(translate('messages.customer')); ?></option>
                                            <option value="deliveryman" <?php echo e($notification->tergat=='deliveryman'?'selected':''); ?>><?php echo e(translate('messages.deliveryman')); ?></option>
                                            <option value="store" <?php echo e($notification->tergat=='store'?'selected':''); ?>><?php echo e(translate('messages.store')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.description')); ?></label>
                                        <textarea name="description" class="form-control" maxlength="1000" required><?php echo e($notification['description']); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="h-100 d-flex flex-column">
                                <label class="d-block text-center mt-auto mb-0">
                                    <?php echo e(translate('messages.image')); ?>

                                    <small class="text-danger">* ( <?php echo e(translate('messages.ratio')); ?> 900x300 )</small>
                                </label>
                                <div class="text-center py-3 my-auto">
                                    <img class="img--vertical onerror-image" id="viewer"
                                    src="<?php echo e($notification['image_full_url']); ?>"
                                    data-onerror-image="<?php echo e(asset('public/assets/admin/img/900x400/img1.jpg')); ?>" alt="image"/>
                                </div>
                                <div class="custom-file">
                                    <input type="file" name="image" id="customFileEg1" class="custom-file-input"
                                        accept=".webp, .jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    <label class="custom-file-label" for="customFileEg1"><?php echo e(translate('messages.choose_file')); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn--container mt-4 justify-content-end">
                        <button type="reset" id="reset_btn" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.send_again')); ?></button>
                    </div>
                </form>
            </div>
            <!-- End Table -->
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/notification.js"></script>
    <script>
        "use strict";
            $('#reset_btn').click(function(){
                $('#zone').val("<?php echo e($notification->zone_id); ?>").trigger('change');
                $('#viewer').attr('src', "<?php echo e(asset('storage/app/public/notification')); ?>/<?php echo e($notification['image']); ?>");
            })
        </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/notification/edit.blade.php ENDPATH**/ ?>