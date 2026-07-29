<?php $__env->startSection('title',translate('Update Banner')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/edit.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.update_banner')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <div class="card">
                    <div class="card-body">
                        <form data-ajax="true" id="banner_form" class="custom-validation">
                            <div class="row g-3">
                                <div class="col-lg-6">
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
                                            <div class="form-group error-wrapper">
                                                <label class="input-label" for="default_title"><?php echo e(translate('messages.title')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                                <input type="text" name="title[]" id="default_title" class="form-control" placeholder="<?php echo e(translate('messages.new_banner')); ?>" required value="<?php echo e($banner?->getRawOriginal('title')); ?>">
                                            </div>
                                            <input type="hidden" name="lang[]" value="default">
                                        </div>
                                        <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                if(count($banner['translations'])){
                                                    $translate = [];
                                                    foreach($banner['translations'] as $t)
                                                    {
                                                        if($t->locale == $lang && $t->key=="title"){
                                                            $translate[$lang]['title'] = $t->value;
                                                        }
                                                    }
                                                }
                                            ?>
                                            <div class="d-none lang_form" id="<?php echo e($lang); ?>-form">
                                                <div class="form-group error-wrapper">
                                                    <label class="input-label" for="<?php echo e($lang); ?>_title"><?php echo e(translate('messages.title')); ?> (<?php echo e(strtoupper($lang)); ?>)</label>
                                                    <input type="text" name="title[]" id="<?php echo e($lang); ?>_title" class="form-control" placeholder="<?php echo e(translate('messages.new_banner')); ?>" value="<?php echo e($translate[$lang]['title']??''); ?>">
                                                </div>
                                                <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                    <div id="default-form">
                                        <div class="form-group error-wrapper">
                                            <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.title')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                            <input type="text" name="title[]" class="form-control" placeholder="<?php echo e(translate('messages.new_banner')); ?>" value="<?php echo e($banner['title']); ?>" maxlength="100">
                                        </div>
                                        <input type="hidden" name="lang[]" value="default">
                                    </div>
                                    <?php endif; ?>
                                    <div class="form-group error-wrapper">
                                        <label class="input-label" for="title"><?php echo e(translate('messages.zone')); ?></label>
                                        <select name="zone_id" id="zone" class="form-control js-select2-custom">
                                            <option  disabled selected>---<?php echo e(translate('messages.select')); ?>---</option>
                                            <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(isset(auth('admin')->user()->zone_id)): ?>
                                                    <?php if(auth('admin')->user()->zone_id == $zone->id): ?>
                                                        <option value="<?php echo e($zone['id']); ?>" <?php echo e($zone->id == $banner->zone_id?'selected':''); ?>><?php echo e($zone['name']); ?></option>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                <option value="<?php echo e($zone['id']); ?>" <?php echo e($zone->id == $banner->zone_id?'selected':''); ?>><?php echo e($zone['name']); ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="form-group error-wrapper">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.banner_type')); ?></label>
                                        <select name="banner_type" id="banner_type" class="form-control">
                                            <option value="store_wise" <?php echo e($banner->type == 'store_wise'? 'selected':''); ?>><?php echo e(translate('messages.store_wise')); ?></option>
                                            <option value="item_wise" <?php echo e($banner->type == 'item_wise'? 'selected':''); ?>><?php echo e(translate('messages.item_wise')); ?></option>
                                            <option value="default" <?php echo e($banner->type == 'default'? 'selected':''); ?>><?php echo e(translate('messages.default')); ?></option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-0 error-wrapper" id="store_wise">
                                        <label class="input-label" for="exampleFormControlSelect1"><?php echo e(translate('messages.store')); ?><span
                                                class="input-label-secondary"></span></label>
                                        <select name="store_id" id="store_id" class="js-data-example-ajax" id="resturant_ids"  title="Select Restaurant">
                                        <?php if($banner->type=='store_wise'): ?>
                                        <?php ($store = \App\Models\Store::where('id', $banner->data)->first()); ?>
                                            <?php if($store): ?>
                                            <option value="<?php echo e($store->id); ?>" selected><?php echo e($store->name); ?></option>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        </select>
                                    </div>
                                    <div class="form-group mb-0 error-wrapper" id="item_wise">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.select_item')); ?></label>
                                        <select name="item_id" id="choice_item" class="form-control js-select2-custom" placeholder="<?php echo e(translate('messages.select_item')); ?>">

                                        </select>
                                    </div>
                                    <div class="form-group mb-0 error-wrapper" id="default">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.default_link')); ?></label>
                                        <input type="text" name="default_link" class="form-control" value="<?php echo e($banner->default_link); ?>" placeholder="<?php echo e(translate('messages.default_link')); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="error-wrapper">
                                        <div class="h-100 d-flex flex-column">
                                            <label class="mt-auto mb-0 d-block text-center">
                                                <?php echo e(translate('messages.banner_image')); ?>

                                                <small class="text-danger">* ( <?php echo e(translate('messages.ratio')); ?> 900x300 )</small>
                                            </label>
                                            <div class="text-center py-3 my-auto">
                                                <img class="img--vertical onerror-image" id="viewer" data-onerror-image="<?php echo e(asset('public/assets/admin/img/900x400/img1.jpg')); ?>" src="<?php echo e($banner['image_full_url']); ?>"
                                                alt="banner image"/>
                                            </div>
                                            <div class="custom-file">
                                                <input type="file" name="image" id="customFileEg1" class="custom-file-input"
                                                    accept=".webp, .jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                                <label class="custom-file-label" for="customFileEg1"><?php echo e(translate('messages.choose_file')); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-4">
                                    <div class="btn--container justify-content-end">
                                        <button type="reset" id="reset_btn" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                                        <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.update')); ?></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Table -->
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/banner-edit.js"></script>
    <script>
        "use strict";

        var zone_id = <?php echo e($banner->zone_id); ?>;

        var module_id = <?php echo e($banner->module_id); ?>;

        function get_items()
        {
            var nurl = '<?php echo e(url('/')); ?>/admin/item/get-items?module_id='+module_id;

            if(!Array.isArray(zone_id))
            {
                nurl += '&zone_id='+zone_id;
            }

            $.get({
                url: nurl,
                dataType: 'json',
                success: function (data) {
                    $('#choice_item').empty().append(data.options);
                }
            });
        }
        $(document).on('ready', function () {
            banner_type_change('<?php echo e($banner->type); ?>');
            if($('#banner_type').val() !== 'item_wise' ){
                get_items();
            }
            $('#zone').on('change', function(){
                if($(this).val())
                {
                    zone_id = $(this).val();
                    // get_items();
                }
                else
                {
                    zone_id = true;
                }
            });

            $('.js-data-example-ajax').select2({
                ajax: {
                    url: '<?php echo e(url('/')); ?>/admin/store/get-stores',
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            zone_ids: [zone_id],
                            page: params.page,
                            module_id: module_id
                        };
                    },
                    processResults: function (data) {
                        return {
                        results: data
                        };
                    },
                    __port: function (params, success, failure) {
                        var $request = $.ajax(params);

                        $request.then(success);
                        $request.fail(failure);

                        return $request;
                    }
                }
            });



            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });


        <?php if($banner->type == 'item_wise'): ?>
        getRequest('<?php echo e(url('/')); ?>/admin/item/get-items?module_id=<?php echo e($banner->module_id); ?>&zone_id=<?php echo e($banner->zone_id); ?>&data[]=<?php echo e($banner->data); ?>','choice_item');
        <?php endif; ?>
        $('#banner_form').on('submit', function (e) {
            e.preventDefault();

            let $form = $(this);
            if (!$form.valid()) {
                return false;
            }

            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: "<?php echo e(route('admin.banner.update', [$banner['id']])); ?>",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        toastr.success("<?php echo e(translate('messages.banner_updated_successfully')); ?>", {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        setTimeout(function () {
                            location.href = "<?php echo e(url()->full()); ?>";
                        }, 2000);
                    }
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/banner/edit.blade.php ENDPATH**/ ?>