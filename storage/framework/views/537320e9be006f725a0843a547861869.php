<?php $__env->startSection('title', translate('messages.update_parcel_category')); ?>


<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/edit.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.update_parcel_category')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="card">
            <div class="card-body">
                <form action="<?php echo e(route('admin.parcel.category.update', [$parcel_category['id']])); ?>" method="post"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row g-3">
                        <?php echo method_field('PUT'); ?>
                        <?php ($language = \App\Models\BusinessSetting::where('key', 'language')->first()); ?>
                        <?php ($language = $language->value ?? null); ?>
                        <?php ($defaultLang = str_replace('_', '-', app()->getLocale())); ?>
                        <div class="col-lg-12">
                            <?php if($language): ?>
                                <?php ($defaultLang = json_decode($language)[0]); ?>
                                <ul class="nav nav-tabs mb-4">
                                    <li class="nav-item">
                                        <a class="nav-link lang_link active" href="#"
                                            id="default-link"><?php echo e(translate('messages.default')); ?></a>
                                    </li>
                                    <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="nav-item">
                                            <a class="nav-link lang_link" href="#"
                                                id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-6">
                            <?php if($language): ?>
                                <div class="lang_form" id="default-form">
                                    <div class="form-group">
                                        <label class="input-label" for="default_name"><?php echo e(translate('messages.name')); ?>

                                            (<?php echo e(translate('messages.default')); ?>)</label>
                                        <input type="text" name="name[]" id="default_name" class="form-control"
                                            placeholder="<?php echo e(translate('messages.new_food')); ?>"
                                            value="<?php echo e($parcel_category?->getRawOriginal('name')); ?>">
                                    </div>
                                    <input type="hidden" name="lang[]" value="default">
                                    <div class="form-group">
                                        <label class="input-label"
                                            for="exampleFormControlInput1"><?php echo e(translate('messages.short_description')); ?>

                                            (<?php echo e(translate('messages.default')); ?>)</label>
                                        <textarea type="text" name="description[]" class="form-control ckeditor"><?php echo $parcel_category?->getRawOriginal('description'); ?></textarea>
                                    </div>
                                </div>
                                <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    if (count($parcel_category['translations'])) {
                                        $translate = [];
                                        foreach ($parcel_category['translations'] as $t) {
                                            if ($t->locale == $lang && $t->key == 'name') {
                                                $translate[$lang]['name'] = $t->value;
                                            }
                                            if ($t->locale == $lang && $t->key == 'description') {
                                                $translate[$lang]['description'] = $t->value;
                                            }
                                        }
                                    }
                                    ?>
                                    <div class="d-none lang_form" id="<?php echo e($lang); ?>-form">
                                        <div class="form-group">
                                            <label class="input-label"
                                                for="<?php echo e($lang); ?>_name"><?php echo e(translate('messages.name')); ?>

                                                (<?php echo e(strtoupper($lang)); ?>)</label>
                                            <input type="text" name="name[]" id="<?php echo e($lang); ?>_name"
                                                class="form-control" placeholder="<?php echo e(translate('messages.new_food')); ?>"
                                                value="<?php echo e($translate[$lang]['name'] ?? ''); ?>">
                                        </div>
                                        <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                        <div class="form-group">
                                            <label class="input-label"
                                                for="exampleFormControlInput1"><?php echo e(translate('messages.short_description')); ?>

                                                (<?php echo e(strtoupper($lang)); ?>)</label>
                                            <textarea type="text" name="description[]" class="form-control ckeditor"><?php echo $translate[$lang]['description'] ?? ''; ?></textarea>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div id="default-form">
                                    <div class="form-group">
                                        <label class="input-label"
                                            for="exampleFormControlInput1"><?php echo e(translate('messages.name')); ?> (EN)</label>
                                        <input type="text" name="name[]" class="form-control"
                                            placeholder="<?php echo e(translate('messages.new_food')); ?>"
                                            value="<?php echo e($parcel_category['name']); ?>" required>
                                    </div>
                                    <input type="hidden" name="lang[]" value="en">
                                    <div class="form-group">
                                        <label class="input-label"
                                            for="exampleFormControlInput1"><?php echo e(translate('messages.short_description')); ?></label>
                                        <textarea type="text" name="description[]" class="form-control ckeditor"><?php echo $parcel_category['description']; ?></textarea>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if($parcel_category->position == 0): ?>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-6">
                            <div class="h-100 d-flex flex-column">
                                <label class="mb-0 mt-auto d-block text-center">
                                    <?php echo e(translate('messages.image')); ?>

                                    <small class="text-danger">* ( <?php echo e(translate('messages.ratio')); ?> 200x200 )</small>
                                </label>
                                <div class="text-center py-3 my-auto">
                                    <img class="img--130 onerror-image" id="viewer"
                                        src="<?php echo e($parcel_category['image_full_url']); ?>"
                                        data-onerror-image="<?php echo e(asset('/public/assets/admin/img/400x400/img2.jpg')); ?>" />
                                </div>
                                <div class="custom-file">
                                    <input type="file" name="image" id="customFileEg1" class="custom-file-input"
                                        accept=".webp, .jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    <label class="custom-file-label"
                                        for="customFileEg1"><?php echo e(translate('messages.choose_file')); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label
                                    class="input-label text-capitalize"><?php echo e(translate('messages.per_km_shipping_charge')); ?></label>
                                <input type="number" step=".01" min="0"
                                    placeholder="<?php echo e(translate('messages.per_km_shipping_charge')); ?>" class="form-control"
                                    name="parcel_per_km_shipping_charge"
                                    value="<?php echo e($parcel_category->parcel_per_km_shipping_charge); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label
                                    class="input-label text-capitalize"><?php echo e(translate('messages.minimum_shipping_charge')); ?></label>
                                <input type="number" step=".01" min="0"
                                    placeholder="<?php echo e(translate('messages.minimum_shipping_charge')); ?>"
                                    class="form-control" name="parcel_minimum_shipping_charge"
                                    value="<?php echo e($parcel_category->parcel_minimum_shipping_charge); ?>">
                            </div>
                        </div>
                        <?php if($categoryWiseTax): ?>
                                <div class="col-6">
                                    <span
                                        class="mb-2 d-block title-clr fw-normal"><?php echo e(translate('Select Tax Rate')); ?></span>
                                    <select name="tax_ids[]" required id=""
                                        class="form-control js-select2-custom" multiple="multiple"
                                        placeholder="Type & Select Tax Rate">
                                        <?php $__currentLoopData = $taxVats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxVat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option <?php echo e(in_array($taxVat->id, $taxVatIds) ? 'selected' : ''); ?>

                                                value="<?php echo e($taxVat->id); ?>"> <?php echo e($taxVat->name); ?>

                                                (<?php echo e($taxVat->tax_rate); ?>%)
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                        <?php endif; ?>
                        <div class="col-12">
                            <div class="btn--container justify-content-end">
                                <button type="reset" id="reset_btn"
                                    class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                                <button type="submit"
                                    class="btn btn--primary"><?php echo e(translate('messages.update')); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- End Table -->
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script>
        "use strict";

        function readURL(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();

                reader.onload = function(e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function() {
            readURL(this);
        });

        $(".lang_link").click(function(e) {
            e.preventDefault();
            $(".lang_link").removeClass('active');
            $(".lang_form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.substring(0, form_id.length - 5);
            console.log(lang);
            $("#" + lang + "-form").removeClass('d-none');
        });

        $('#reset_btn').click(function() {
            $('#module_id').val("<?php echo e($parcel_category->module_id); ?>").trigger('change');
            $('#viewer').attr('src',
                "<?php echo e(asset('storage/app/public/parcel_category')); ?>/<?php echo e($parcel_category['image']); ?>");
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/parcel/category/edit.blade.php ENDPATH**/ ?>