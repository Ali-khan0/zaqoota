<?php $__env->startSection('title',translate('messages.Update Unit')); ?>

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
                    <?php echo e(translate('messages.unit_update')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="card">
            <div class="card-body">
                <form action="<?php echo e(route('admin.unit.update',[$unit['id']])); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
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
                            <div class="lang_form" id="default-form">
                                <div class="form-group">
                                    <label class="input-label" for="default_title"><?php echo e(translate('messages.name')); ?> (<?php echo e(translate('messages.default')); ?>) <span class="form-label-secondary text-danger"
                                        data-toggle="tooltip" data-placement="right"
                                        data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                        </span>
                                    </label>
                                    <input type="text" name="unit[]" id="default_title" class="form-control" placeholder="<?php echo e(translate('messages.unit_name')); ?>" value="<?php echo e($unit?->getRawOriginal('unit')); ?>" maxlength="191"  >
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                            </div>
                            <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    if(count($unit['translations'])){
                                        $translate = [];
                                        foreach($unit['translations'] as $t)
                                        {
                                            if($t->locale == $lang && $t->key=="unit"){
                                                $translate[$lang]['unit'] = $t->value;
                                            }
                                        }
                                    }
                                ?>
                                <div class="d-none lang_form" id="<?php echo e($lang); ?>-form">
                                    <div class="form-group">
                                        <label class="input-label" for="<?php echo e($lang); ?>_title"><?php echo e(translate('messages.name')); ?> (<?php echo e(strtoupper($lang)); ?>)</label>
                                        <input type="text" name="unit[]" id="<?php echo e($lang); ?>_title" class="form-control" placeholder="<?php echo e(translate('messages.unit_name')); ?>" value="<?php echo e($translate[$lang]['unit']??''); ?>" maxlength="191"  >
                                    </div>
                                    <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                        <div id="default-form">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.name')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                <input type="text" name="unit[]" class="form-control" placeholder="<?php echo e(translate('messages.unit_name')); ?>" value="<?php echo e($unit['unit']); ?>" maxlength="191" required>
                            </div>
                            <input type="hidden" name="lang[]" value="default">
                        </div>
                        <?php endif; ?>
                    <div class="btn--container justify-content-end">
                        <button type="reset" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.update')); ?></button>
                    </div>
                </form>
            </div>
            <!-- End Table -->
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/unit/edit.blade.php ENDPATH**/ ?>