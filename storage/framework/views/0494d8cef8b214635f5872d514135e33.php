<?php $__env->startSection('title',translate('messages.Update category')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/edit.png')); ?>" class="w--20" alt="">
                </span>
                <span>
                    <?php echo e($category->position?translate('messages.sub').' ':''); ?><?php echo e(translate('messages.category_update')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="card">
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?php if($language): ?>
                                <ul class="nav nav-tabs mb-4 border-0">
                                    <li class="nav-item">
                                        <a class="nav-link lang_link active"
                                        href="#"
                                        id="default-link"><?php echo e(translate('messages.default')); ?></a>
                                    </li>
                                    <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="nav-item">
                                            <a class="nav-link lang_link"
                                                href="#"
                                                id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            <?php endif; ?>
                            <?php if($language): ?>
                                <div class="form-group lang_form" id="default-form">
                                    <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.name')); ?> (<?php echo e(translate('messages.default')); ?>) <span class="form-label-secondary text-danger"
                                        data-toggle="tooltip" data-placement="right"
                                        data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                        </span>
                                    </label>
                                    <input type="text" name="name[]" class="form-control" placeholder="<?php echo e(translate('messages.new_category')); ?>" maxlength="191" value="<?php echo e($category?->getRawOriginal('name')); ?>"  >
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                                <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <?php
                                        if(count($category?->translations ?? [])){
                                            $translate = [];
                                            foreach($category['translations'] as $t)
                                            {
                                                if($t->locale == $lang && $t->key=="name"){
                                                    $translate[$lang]['name'] = $t->value;
                                                }
                                            }
                                        }
                                    ?>
                                    <div class="form-group d-none lang_form" id="<?php echo e($lang); ?>-form">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.name')); ?> (<?php echo e(strtoupper($lang)); ?>)</label>
                                        <input type="text" name="name[]" class="form-control" placeholder="<?php echo e(translate('messages.new_category')); ?>" maxlength="191" value="<?php echo e($translate[$lang]['name']??''); ?>"  >
                                    </div>
                                    <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="form-group">
                                    <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.name')); ?></label>
                                    <input type="text" name="name" class="form-control" placeholder="<?php echo e(translate('messages.new_category')); ?>" value="<?php echo e($category['name']); ?>" maxlength="191">
                                </div>
                                <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                            <?php endif; ?>


                        </div>
                        <div class="col-md-6">
                            <?php if($category->position == 0): ?>
                            <div class="h-100 d-flex align-items-center flex-column">
                                <label class="mb-4"><?php echo e(translate('messages.image')); ?>

                                    <small class="text-danger">* ( <?php echo e(translate('messages.ratio')); ?> 1:1 )</small>
                                </label>
                                <label class="text-center my-auto position-relative d-inline-block">
                                    <img class="img--176 border" id="viewer"
                                    src="<?php echo e($category['image_full_url']); ?>"
                                        data-onerror-image="<?php echo e(asset('public/assets/admin/img/upload-img.png')); ?>"
                                        alt=""/>
                                    <div class="icon-file-group">
                                        <div class="icon-file">
                                            <input type="file" name="image" id="customFileEg1" class="custom-file-input read-url"
                                                accept=".webp, .jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                                <i class="tio-edit"></i>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="btn--container justify-content-end mt-20">
                        <button type="reset" data-image="<?php echo e($category['image_full_url']); ?>" id="reset_btn" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.update')); ?></button>
                    </div>
                </form>
            </div>
            <!-- End Table -->
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/category-index.js"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/category/edit.blade.php ENDPATH**/ ?>