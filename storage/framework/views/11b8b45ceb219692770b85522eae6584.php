<form action="<?php echo e(route('admin.category.update', [$category['id']])); ?>" method="post" enctype="multipart/form-data"
      class="d-flex flex-column h-100">
    <?php echo method_field('post'); ?>
    <?php echo csrf_field(); ?>
    <div>
        <div class="custom-offcanvas-header bg--secondary d-flex justify-content-between align-items-center px-3 py-3">
            <h3 class="mb-0"><?php echo e($category->position == 0 ? translate('Edit_Category') : translate('Edit_Sub_Category')); ?></h2>
                <button type="button"
                        class="btn-close w-25px h-25px border rounded-circle d-center bg--secondary text-dark offcanvas-close fz-15px p-0"
                        aria-label="Close">&times;
                </button>
        </div>
        <div class="custom-offcanvas-body p-20">
            <div class="bg--secondary rounded p-20 mb-20">
                <div class="mb-15">
                    <h4 class="mb-0"><?php echo e(translate('Availability')); ?></h4>
                    <p class="fz-12px">
                        <?php echo e(translate('If_you_turn_off_this_status_this_category_will_not_be_available')); ?>

                    </p>
                </div>
                <label class="border d-flex align-items-center bg-white-n justify-content-between rounded p-10px px-3">
                    <?php echo e(translate('Status')); ?>

                    <div class="toggle-switch ml-auto justify-content-end toggle-switch-sm" for="status">
                        <input type="checkbox" name="status" value="1" <?php echo e($category['status'] ? 'checked' : ''); ?>

                        class="toggle-switch-input" id="status">
                        <span class="toggle-switch-label">
                            <span class="toggle-switch-indicator"></span>
                        </span>
                    </div>
                </label>
            </div>


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
                                <label class="input-label"
                                       for="exampleFormControlInput1"><?php echo e($category->position == 0 ? translate('Category_Name') : translate('Sub_Category_Name')); ?>

                                    (<?php echo e(translate('messages.default')); ?>)
                                    <span class="form-label-secondary text-danger" data-toggle="tooltip"
                                          data-placement="right"
                                          data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                    </span>

                                </label>
                                <input type="text" name="name[]" value="<?php echo e($category?->getRawOriginal('name')); ?>"
                                       class="form-control" placeholder="<?php echo e(translate('messages.new_category')); ?>"
                                       maxleng="255">
                            </div>
                            <input type="hidden" name="lang[]" value="default">
                            <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    if (count($category['translations'])) {
                                        $translate = [];
                                        foreach ($category['translations'] as $t) {
                                            if ($t->locale == $lang && $t->key == 'name') {
                                                $translate[$lang]['name'] = $t->value;
                                            }
                                        }
                                    }
                                    ?>

                                <div class="form-group d-none lang_form1" id="<?php echo e($lang); ?>-form1">
                                    <label class="input-label"
                                           for="exampleFormControlInput1"><?php echo e($category->position == 0 ? translate('Category_Name') : translate('Sub_Category_Name')); ?>

                                        (<?php echo e(strtoupper($lang)); ?>)
                                    </label>
                                    <input type="text" name="name[]" value="<?php echo e($translate[$lang]['name'] ?? ''); ?>"
                                           class="form-control"
                                           placeholder="<?php echo e(translate('messages.Type_Category_Name')); ?>" maxlength="191">
                                </div>
                                <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="form-group">
                                <label class="input-label"
                                       for="exampleFormControlInput1"><?php echo e($category->position == 0 ? translate('Category_Name') : translate('Sub_Category_Name')); ?></label>
                                <input type="text" name="name" class="form-control"
                                       placeholder="<?php echo e(translate('messages.new_category')); ?>"
                                       value="<?php echo e($category?->getRawOriginal('name')); ?>" maxlength="191">
                            </div>
                            <input type="hidden" name="lang[]" value="default">
                        <?php endif; ?>

                    </div>
                </div>
                    <?php if($category->position != 0): ?>
                        <div class="form-group mb-3">
                            <label class="input-label"
                                   for="exampleFormControlSelect1"><?php echo e(translate('messages.main_category')); ?>

                                <span class="input-label-secondary">*</span></label>
                            <select id="exampleFormControlSelect1" name="parent_id" class="custom-select"
                                    required>
                                <option value="" selected disabled><?php echo e(translate('Select Main Category')); ?></option>
                                <?php $__currentLoopData = $mainCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mainCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($mainCategory['id']); ?>" <?php echo e($category->parent_id == $mainCategory['id'] ? 'selected' : ''); ?>><?php echo e($mainCategory['name']); ?>

                                        (<?php echo e(Str::limit($mainCategory->module->module_name, 15, '...')); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    <?php endif; ?>

                <div class="form-group mb-3">
                    <label class="input-label" for="">
                        <?php echo e(translate('messages.Priority')); ?>

                    </label>
                    <select required name="priority" data-original-title="<?php echo e(translate('messages.Select_Priority')); ?>"
                            class="custom-select">
                        <option <?php echo e($category['priority'] == 0 ? 'selected' : ''); ?> value="0">
                            <?php echo e(translate('messages.Normal')); ?></option>
                        <option <?php echo e($category['priority'] == 1 ? 'selected' : ''); ?> value="1">
                            <?php echo e(translate('messages.Medium')); ?></option>
                        <option <?php echo e($category['priority'] == 2 ? 'selected' : ''); ?> value="2">
                            <?php echo e(translate('messages.High')); ?></option>
                    </select>
                </div>

                <?php if($category->position == 0 && $categoryWiseTax): ?>
                    <div class="row">

                        <div class="col-12">
                            <span class="mb-2 d-block title-clr fw-normal"><?php echo e(translate('Select Tax Rate')); ?></span>
                            <select name="tax_ids[]" required id="" class="form-control js-select2-custom1"
                                    multiple="multiple" placeholder="Type & Select Tax Rate">
                                <?php $__currentLoopData = $taxVats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxVat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option <?php echo e(in_array($taxVat->id, $taxVatIds) ? 'selected' : ''); ?>

                                            value="<?php echo e($taxVat->id); ?>"> <?php echo e($taxVat->name); ?>

                                        (<?php echo e($taxVat->tax_rate); ?>%)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if($category->position == 0 ): ?>
                    <div class="col-md-12">
                        <div class="bg--secondary rounded p-20 mb-20">

                            <div class="h-100 d-flex align-items-center flex-column">
                                <label class="mb-4 text-center text-title">
                                    <?php echo e(translate('messages.image')); ?>

                                    <small
                                        class="color-656566 d-block"> <?php echo e(translate('messages.Upload image')); ?></small>
                                </label>
                                <label class="text-center my-auto position-relative d-inline-block">
                                    <img class="img--176 border--dashed rounded viewer_img" id=""
                                         src="<?php echo e($category['image_full_url']); ?>"
                                         data-onerror-image="<?php echo e(asset('public/assets/admin/img/upload-img.png')); ?>"
                                         alt=""/>
                                    <div class="icon-file-group">
                                        <div class="icon-file">
                                            <input type="file" name="image" id=""
                                                   class="custom-file-input custom__FileEg read-url"
                                                   accept=".webp, .jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                            <i class="tio-edit"></i>
                                        </div>
                                    </div>
                                </label>
                            </div>

                        </div>
                    </div>
                <?php endif; ?>
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
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/category/_edit.blade.php ENDPATH**/ ?>