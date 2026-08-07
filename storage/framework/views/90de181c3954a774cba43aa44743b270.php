<?php $__env->startSection('title',translate('messages.Update condition')); ?>

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
                    <?php echo e(translate('messages.Common_Condition_Update')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="card">
            <div class="card-body">
                <form action="<?php echo e(route('admin.common-condition.update',[$condition['id']])); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-12">
                            <?php if($language): ?>
                                <ul class="nav nav-tabs mb-4">
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
                        </div>
                        <div class="col-12">
                            <?php if($language): ?>
                                <div class="form-group lang_form" id="default-form">
                                    <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.name')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                    <input type="text" name="name[]" class="form-control" placeholder="<?php echo e(translate('messages.new_condition')); ?>" maxlength="191" value="<?php echo e($condition?->getRawOriginal('name')); ?>">
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                                <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        if(count($condition['translations'])){
                                            $translate = [];
                                            foreach($condition['translations'] as $t)
                                            {
                                                if($t->locale == $lang && $t->key=="name"){
                                                    $translate[$lang]['name'] = $t->value;
                                                }
                                            }
                                        }
                                    ?>
                                    <div class="form-group d-none lang_form" id="<?php echo e($lang); ?>-form">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.name')); ?> (<?php echo e(strtoupper($lang)); ?>)</label>
                                        <input type="text" name="name[]" class="form-control" placeholder="<?php echo e(translate('messages.new_condition')); ?>" maxlength="191" value="<?php echo e($translate[$lang]['name']??''); ?>">
                                    </div>
                                    <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="form-group">
                                    <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.name')); ?></label>
                                    <input type="text" name="name" class="form-control" placeholder="<?php echo e(translate('messages.new_condition')); ?>" value="<?php echo e($condition['name']); ?>" maxlength="191">
                                </div>
                                <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="btn--container justify-content-end mt-20">
                        <button type="reset" id="reset_btn" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.update')); ?></button>
                    </div>
                </form>
            </div>
            <!-- End Table -->
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/common-condition-index.js"></script>
    <script>
        "use strict";
        $('#reset_btn').click(function(){
            $('#module_id').val("<?php echo e($condition->module_id); ?>").trigger('change');
            $('#viewer').attr('src', "<?php echo e(asset('storage/app/public/condition')); ?>/<?php echo e($condition['image']); ?>");
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/common-condition/edit.blade.php ENDPATH**/ ?>