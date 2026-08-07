<form action="<?php echo e(route('admin.parcel.cancellationReasonUpdate', [$reason['id']])); ?>" method="post"
    class="d-flex flex-column h-100">
    <?php echo method_field('put'); ?>
    <?php echo csrf_field(); ?>
    <div>
        <div class="custom-offcanvas-header bg--secondary d-flex justify-content-between align-items-center px-3 py-3">
            <h3 class="mb-0"><?php echo e(translate('Edit_Reason')); ?></h3>
            <button type="button"
                class="btn-close w-25px h-25px border rounded-circle d-center bg--secondary text-dark offcanvas-close fz-15px p-0"
                aria-label="Close">&times;</button>
        </div>
        <div class="custom-offcanvas-body p-20">
            <div class="bg--secondary rounded p-20 mb-20">
                <?php if($language): ?>
                    <ul class="nav nav-tabs mb-4 border-0">
                        <li class="nav-item">
                            <a class="nav-link lang_link1 active" href="#"
                                id="default-link"><?php echo e(translate('messages.default')); ?></a>
                        </li>
                        <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="nav-item">
                                <a class="nav-link lang_link1" href="#"
                                    id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php endif; ?>
                <div class="row">
                    <div class="col-12">
                        <?php if($language): ?>
                            <div class="form-group lang_form1" id="default-form1">
                                <label class="fs-14 mb-2 color-222324"><?php echo e(translate('Parcel cancellation reason')); ?>

                                    (<?php echo e(translate('Default')); ?>)
                                </label>
                                <textarea rows="1" name="reason[]" data-target="#edit-char-count"
                                    class="form-control min-h-45px bg-white char-counter" maxlength="150" placeholder="Type Tittle"><?php echo e($reason?->getRawOriginal('reason')); ?></textarea>
                                <div id="edit-char-count" class="color-A7A7A7 mt-1 fs-14 text-right">0/150</div>
                                <input type="hidden" name="lang[]" value="default">
                            </div>
                            <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                if (count($reason['translations'])) {
                                    $translate = [];
                                    foreach ($reason['translations'] as $t) {
                                        if ($t->locale == $lang && $t->key == 'reason') {
                                            $translate[$lang]['name'] = $t->value;
                                        }
                                    }
                                }
                                ?>

                                <div class="form-group d-none lang_form1" id="<?php echo e($lang); ?>-form1">
                                    <label
                                        class="fs-14 mb-2 color-222324 "><?php echo e(translate('Parcel cancellation reason')); ?>

                                        (<?php echo e(strtoupper($lang)); ?>)
                                    </label>
                                    <textarea rows="1" name="reason[]" data-target="#edit-feedback-count-<?php echo e($lang); ?>"
                                        class="form-control min-h-45px bg-white char-counter" maxlength="150" placeholder="Type Tittle"><?php echo e($translate[$lang]['name'] ?? ''); ?></textarea>
                                    <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                    <div id="edit-feedback-count-<?php echo e($lang); ?>"
                                        class="color-A7A7A7 mt-1 fs-14 text-right">
                                        0/150</div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="" class="fs-14 mb-2 color-222324">
                                <?php echo e(translate('Cancellation type')); ?>

                            </label>
                            <select name="cancellation_type" required id=""
                                class="custom-select fs-12 title-clr">
                                <option <?php echo e($reason?->cancellation_type == 'before_pickup' ? 'selected' : ''); ?>

                                    value="before_pickup"><?php echo e(translate('before_pickup')); ?></option>
                                <option <?php echo e($reason?->cancellation_type == 'after_pickup' ? 'selected' : ''); ?>

                                    value="after_pickup"><?php echo e(translate('after_pickup')); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="" class="fs-14 mb-2 color-222324">
                                <?php echo e(translate('User Type')); ?>

                            </label>
                            <select name="user_type" required id="" class="custom-select fs-12 title-clr">
                                <option <?php echo e($reason?->user_type == 'customer' ? 'selected' : ''); ?> value="customer">
                                    <?php echo e(translate('Customer')); ?></option>
                                <option <?php echo e($reason?->user_type == 'deliveryman' ? 'selected' : ''); ?>

                                    value="deliveryman"><?php echo e(translate('Deliveryman')); ?></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div
        class="align-items-center bg-white bottom-0 d-flex gap-3 justify-content-center mt-auto offcanvas-footer p-3 position-sticky">
        <button type="button"
            class="btn w-100 btn--secondary offcanvas-close h--40px"><?php echo e(translate('Cancel')); ?></button>
        <button type="submit" class="btn w-100 btn--primary h--40px"><?php echo e(translate('Update')); ?></button>
    </div>
</form>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/parcel/parcel-cancellation-reason-edit.blade.php ENDPATH**/ ?>