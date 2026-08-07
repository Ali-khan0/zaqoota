<?php $__env->startSection('title',translate('messages.parcel_category')); ?>


<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/parcel.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.parcel_category')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->

        <div class="card">
            <div class="card-body">
                <form action="<?php echo e(route('admin.parcel.category.store')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row g-3">
                    <?php ($language=\App\Models\BusinessSetting::where('key','language')->first()); ?>
                    <?php ($language = $language->value ?? null); ?>
                    <?php ($defaultLang = str_replace('_', '-', app()->getLocale())); ?>
                    <?php if($language): ?>
                    <div class="col-12">
                        <ul class="nav nav-tabs mb-3 border-0">
                            <li class="nav-item">
                                <a class="nav-link lang_link active"
                                href="#"
                                id="default-link"><?php echo e(translate('messages.default')); ?></a>
                            </li>
                            <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="nav-item">
                                    <a class="nav-link lang_link"
                                        href="#"
                                        id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <div class="col-md-6">
                        <?php if($language): ?>
                        <div class="lang_form" id="default-form">
                            <div class="form-group">
                                <label class="input-label" for="default_name"><?php echo e(translate('messages.name')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                <input type="text" name="name[]" id="default_name" class="form-control" placeholder="<?php echo e(translate('messages.new_item')); ?>"  >
                            </div>
                            <input type="hidden" name="lang[]" value="default">
                            <div class="form-group">
                                <label class="input-label" for="description"><?php echo e(translate('messages.short_description')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                <textarea type="text" name="description[]" class="form-control ckeditor"  ></textarea>
                            </div>
                        </div>
                            <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="d-none lang_form" id="<?php echo e($lang); ?>-form">
                                    <div class="form-group">
                                        <label class="input-label" for="<?php echo e($lang); ?>_name"><?php echo e(translate('messages.name')); ?> (<?php echo e(strtoupper($lang)); ?>)</label>
                                        <input type="text" name="name[]" id="<?php echo e($lang); ?>_name" class="form-control" placeholder="<?php echo e(translate('messages.new_item')); ?>"  >
                                    </div>
                                    <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                    <div class="form-group">
                                        <label class="input-label" for="description"><?php echo e(translate('messages.short_description')); ?> (<?php echo e(strtoupper($lang)); ?>)</label>
                                        <textarea type="text" name="description[]" class="form-control ckeditor"  ></textarea>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div id="default-form">
                                <div class="form-group">
                                    <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.name')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                    <input type="text" name="name[]" class="form-control" placeholder="<?php echo e(translate('messages.new_item')); ?>" required>
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                                <div class="form-group">
                                    <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.short_description')); ?></label>
                                    <textarea type="text" name="description[]" class="form-control ckeditor"></textarea>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <input name="position" value="0" class="initial-hidden">
                    </div>
                    <div class="col-md-6">
                        <div class="h-100 d-flex flex-column">
                            <label class="text-center d-block mt-auto">
                                <?php echo e(translate('messages.image')); ?>

                                <small class="text-danger">* ( <?php echo e(translate('messages.ratio')); ?> 200x200)</small>
                            </label>
                            <div class="text-center py-3 my-auto">
                                <img class="img--120" id="viewer"
                                    src="<?php echo e(asset('public/assets/admin/img/900x400/img1.jpg')); ?>"
                                    alt="image"/>
                            </div>
                            <div class="custom-file">
                                <input type="file" name="image" id="customFileEg1" class="custom-file-input"
                                    accept=".webp, .jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required>
                                <label class="custom-file-label" for="customFileEg1"><?php echo e(translate('messages.choose_file')); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label  class="input-label text-capitalize"><?php echo e(translate('messages.per_km_shipping_charge')); ?></label>
                            <input type="number" step=".01" min="0" placeholder="<?php echo e(translate('messages.per_km_shipping_charge')); ?>" class="form-control" name="parcel_per_km_shipping_charge">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="input-label text-capitalize"><?php echo e(translate('messages.minimum_shipping_charge')); ?></label>
                            <input type="number" step=".01" min="0" placeholder="<?php echo e(translate('messages.minimum_shipping_charge')); ?>" class="form-control" name="parcel_minimum_shipping_charge">
                        </div>
                    </div>
                    <?php if($categoryWiseTax): ?>
                    <div class="col-md-6">

                                <span class="mb-2 d-block title-clr fw-normal"><?php echo e(translate('Select Tax Rate')); ?></span>
                                <select name="tax_ids[]" id="tax__rate" class="form-control js-select2-custom"
                                    multiple="multiple" required placeholder="Type & Select Tax Rate">
                                    <?php $__currentLoopData = $taxVats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxVat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($taxVat->id); ?>"> <?php echo e($taxVat->name); ?>

                                            (<?php echo e($taxVat->tax_rate); ?>%)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <?php endif; ?>
                    <div class="col-12">
                        <div class="btn--container justify-content-end">
                            <button type="reset" id="reset_btn" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                            <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.Add Parcel Category')); ?></button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header py-2 border-0">
                <div class="search--button-wrapper">
                    <h5 class="card-title">
                        <?php echo e(translate('messages.parcel_category_list')); ?>

                        <span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($parcel_categories->total()); ?></span>
                    </h5>

                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive datatable-custom">
                    <table id="columnSearchDatatable"
                        class="table table-borderless table-thead-bordered table-align-middle" data-hs-datatables-options='{
                            "isResponsive": false,
                            "isShowPaging": false,
                            "paging":false,
                        }'>
                        <thead class="thead-light">
                            <tr>
                                <th class="border-0"><?php echo e(translate('messages.SL')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.id')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.name')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.module')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.status')); ?></th>
                                <th class="border-0 text-center"><?php echo e(translate('messages.orders_count')); ?></th>
                                <th class="border-0 text-center"><?php echo e(translate('messages.per_km_shipping_charge')); ?></th>
                                <th class="border-0 text-center"><?php echo e(translate('messages.minimum_shipping_charge')); ?></th>
                                  <?php if($categoryWiseTax): ?>
                                <th  class="border-0 "><?php echo e(translate('messages.Vat/Tax')); ?></th>
                                <?php endif; ?>
                                <th class="border-0 text-center"><?php echo e(translate('messages.action')); ?></th>
                            </tr>
                        </thead>

                        <tbody id="table-div">
                        <?php $__currentLoopData = $parcel_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($key+$parcel_categories->firstItem()); ?></td>
                                <td><?php echo e($category->id); ?></td>
                                <td>
                                    <span class="d-block font-size-sm text-body">
                                        <?php echo e(Str::limit($category['name'], 20,'...')); ?>

                                    </span>
                                </td>
                                <td>
                                    <span class="d-block font-size-sm text-body">
                                        <?php echo e(Str::limit($category->module->module_name, 15,'...')); ?>

                                    </span>
                                </td>
                                <td>
                                    <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox<?php echo e($category->id); ?>">
                                    <input type="checkbox" data-url="<?php echo e(route('admin.parcel.category.status',[$category['id'],$category->status?0:1])); ?>" class="toggle-switch-input redirect-url" id="stocksCheckbox<?php echo e($category->id); ?>" <?php echo e($category->status?'checked':''); ?>>
                                        <span class="toggle-switch-label">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                    </label>
                                </td>
                                <td>
                                    <div class="text-center">
                                        <?php echo e($category->orders_count); ?>

                                    </div>
                                </td>
                                <td>
                                    <div class="text-center">
                                        <?php echo e($category->parcel_per_km_shipping_charge?\App\CentralLogics\Helpers::format_currency($category->parcel_per_km_shipping_charge): 'N/A'); ?>

                                    </div>
                                </td>
                                <td>
                                    <div class="text-center">
                                        <?php echo e($category->parcel_minimum_shipping_charge?\App\CentralLogics\Helpers::format_currency($category->parcel_minimum_shipping_charge): 'N/A'); ?>

                                    </div>
                                </td>
                                      <?php if($categoryWiseTax): ?>
                                <td>
                                    <span class="d-block font-size-sm text-body">
                                        <?php $__empty_1 = true; $__currentLoopData = $category?->taxVats?->pluck('tax.name', 'tax.tax_rate')->toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <span> <?php echo e($tax); ?> : <span class="font-bold">
                                                    (<?php echo e($key); ?>%)
                                                </span> </span>
                                            <br>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <span> <?php echo e(translate('messages.no_tax')); ?> </span>
                                        <?php endif; ?>
                                    </span>
                                </td>
                                <?php endif; ?>
                                <td>
                                    <div class="btn--container justify-content-center">
                                        <a class="btn action-btn btn--primary btn-outline-primary"
                                            href="<?php echo e(route('admin.parcel.category.edit',[$category['id']])); ?>" title="<?php echo e(translate('messages.edit_category')); ?>"><i class="tio-edit"></i>
                                        </a>
                                        <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:"
                                        data-id="category-<?php echo e($category['id']); ?>" data-message="<?php echo e(translate('Want to delete this category')); ?>" title="<?php echo e(translate('messages.delete_category')); ?>"><i class="tio-delete-outlined"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.parcel.category.destroy',[$category['id']])); ?>" method="post" id="category-<?php echo e($category['id']); ?>">
                                            <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if(count($parcel_categories) !== 0): ?>
            <hr>
            <?php endif; ?>
            <div class="page-area">
                <?php echo $parcel_categories->links(); ?>

            </div>
            <?php if(count($parcel_categories) === 0): ?>
            <div class="empty--data">
                <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                <h5>
                    <?php echo e(translate('no_data_found')); ?>

                </h5>
            </div>
            <?php endif; ?>
        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script>
        "use strict";
        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================

            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                let select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this);
        });

        $(".lang_link").click(function(e){
            e.preventDefault();
            $(".lang_link").removeClass('active');
            $(".lang_form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.substring(0, form_id.length - 5);
            console.log(lang);
            $("#"+lang+"-form").removeClass('d-none');
            if(lang == '<?php echo e($defaultLang); ?>')
            {
                $(".from_part_2").removeClass('d-none');
            }
            else
            {
                $(".from_part_2").addClass('d-none');
            }
        });

        $('#reset_btn').click(function(){
            $('#module_id').val(null).trigger('change');
            $('#viewer').attr('src', "<?php echo e(asset('public/assets/admin/img/900x400/img1.jpg')); ?>");
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/parcel/category/index.blade.php ENDPATH**/ ?>