
<form action="<?php echo e(route('admin.business-settings.reactFaqUpdate',[$faq['id']])); ?>" method="post"
    class="d-flex flex-column h-100" enctype="multipart/form-data">

    <?php echo csrf_field(); ?>
    <div>
        <div class="custom-offcanvas-header bg--secondary d-flex justify-content-between align-items-center px-3 py-3">
            <h3 class="mb-0"><?php echo e(translate('Edit_Faq')); ?></h3>
            <button type="button"
                class="btn-close w-25px h-25px border rounded-circle d-center bg--secondary offcanvas-close fz-15px p-0"
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
                                <div class="col-md-12">
                                    <label class="input-label"
                                        for="exampleFormControlInput1"><?php echo e(translate('Question')); ?>

                                        (<?php echo e(translate('messages.default')); ?>)

                                        <span class="form-label-secondary text-danger" data-toggle="tooltip"
                                            data-placement="right"
                                            data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                        </span>

                                    </label>
                                    <input id="Reviewer_name" data-maxlength="150" type="text" name="question[]"
                                        class="form-control" value="<?php echo e($faq?->getRawOriginal('question')); ?>"
                                        placeholder="<?php echo e(translate('Ex: John')); ?>" required>

                                    <div class="d-flex justify-content-end">
                                        <span class="text-body-light text-counting text-right d-block mt-1">0/150</span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="input-label"
                                        for="exampleFormControlInput1"><?php echo e(translate('messages.Answer')); ?>

                                        (<?php echo e(translate('messages.default')); ?>)
                                        <span class="form-label-secondary text-danger" data-toggle="tooltip"
                                            data-placement="right"
                                            data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                        </span>

                                    </label>

                                    <textarea id="Reviewer_review" data-maxlength="100"
                                          type="text"
                                        name="answer[]" class="form-control" placeholder="<?php echo e(translate('Ex: John')); ?>" required><?php echo e($faq?->getRawOriginal('answer')); ?></textarea>

                                    <div class="d-flex justify-content-end">
                                        <span class="text-body-light text-counting text-right d-block mt-1">0/500</span>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="lang[]" value="default">

                            <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                if (count($faq['translations'])) {
                                    $translate = [];
                                    foreach ($faq['translations'] as $t) {
                                        if ($t->locale == $lang && $t->key == 'question') {
                                            $translate[$lang]['question'] = $t->value;
                                        }
                                        if ($t->locale == $lang && $t->key == 'answer') {
                                            $translate[$lang]['answer'] = $t->value;
                                        }
                                    }
                                }
                                ?>

                                <div class="form-group d-none lang_form1" id="<?php echo e($lang); ?>-form1">

                                    <div class="col-md-12">

                                        <label class="input-label"
                                            for="exampleFormControlInput1"><?php echo e(translate('Question')); ?>

                                            (<?php echo e(strtoupper($lang)); ?>)
                                        </label>
                                        <input type="text" name="question[]"
                                            value="<?php echo e($translate[$lang]['question'] ?? ''); ?>" class="form-control"
                                            data-maxlength="150" placeholder="<?php echo e(translate('Question')); ?>"
                                            maxlength="191">
                                        <div class="d-flex justify-content-end">
                                            <span class="text-body-light text-counting text-right d-block mt-1">0/150</span>
                                        </div>
                                    </div>

                                    <div class="col-md-12">

                                        <label class="input-label"
                                            for="exampleFormControlInput1"><?php echo e(translate('answer')); ?>

                                            (<?php echo e(strtoupper($lang)); ?>)
                                        </label>
                                        <textarea type="text" name="answer[]"
                                            class="form-control"
                                            data-maxlength="500" placeholder="<?php echo e(translate('messages.answer')); ?>"
                                            maxlength="191"><?php echo e($translate[$lang]['answer'] ?? ''); ?></textarea>
                                        <div class="d-flex justify-content-end">
                                            <span class="text-body-light text-counting text-right d-block mt-1">0/500</span>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php endif; ?>

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
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/landing-page-settings/_react-landing-page-faq-edit.blade.php ENDPATH**/ ?>