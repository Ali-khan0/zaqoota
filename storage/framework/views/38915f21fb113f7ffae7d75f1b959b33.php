<?php $__env->startSection('title', translate('messages.Add New Vehicle')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header pb-20">
            <div class="d-flex justify-content-between flex-wrap gap-3">
                <div>
                    <h1 class="page-header-title text-break">
                        <span class="page-header-icon">
                            <img src="<?php echo e(asset('public/assets/admin/img/car-logo.png')); ?>" alt="">
                        </span>
                        <span><?php echo e(translate('messages.Add New Vehicle')); ?>

                    </h1>
                </div>
            </div>
        </div>
        <?php ($language = \App\Models\BusinessSetting::where('key', 'language')->first()); ?>
        <?php ($language = $language->value ?? null); ?>

        <form action="" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <div class="row g-3">
                <div class="col-lg-12">
                    <div class="card mt-4">
                        <div class="card-header">
                            <div>
                                <h5 class="text-title mb-1">
                                    <?php echo e(translate('messages.General_Information')); ?>

                                </h5>
                                <p class="fs-12 mb-0">
                                    <?php echo e(translate('messages.Insert the basic information of the vehicle')); ?>

                                </p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-lg-6">
                                    <div class="card __bg-FAFAFA border-0">
                                        <div class="card-body">
                                            <?php if($language): ?>
                                                <ul class="nav nav-tabs border-0 mb-4">
                                                    <li class="nav-item">
                                                        <a class="nav-link lang_link active" href="#"
                                                           id="default-link"><?php echo e(translate('Default')); ?></a>
                                                    </li>
                                                    <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li class="nav-item">
                                                            <a class="nav-link lang_link" href="#"
                                                               id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            <?php endif; ?>
                                            <?php if($language): ?>
                                                <div class="lang_form" id="default-form">
                                                    <div class="form-group mb-20">
                                                        <label class="input-label font-semibold"
                                                               for="default_name"><?php echo e(translate('messages.vehicle_name')); ?>

                                                            (<?php echo e(translate('messages.Default')); ?>)<span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" name="name[]" id="default_name"
                                                               class="form-control"
                                                               value="<?php echo e(old('name.0')); ?>"
                                                               placeholder="<?php echo e(translate('messages.type_vehicle_name')); ?>"
                                                               required>
                                                    </div>
                                                    <input type="hidden" name="lang[]" value="default">
                                                    <div class="form-group mb-0">
                                                        <label class="input-label font-semibold"
                                                               for="exampleFormControlInput1"><?php echo e(translate('messages.short_description')); ?>

                                                            (<?php echo e(translate('messages.default')); ?>)</label>
                                                        <textarea type="text" name="description[]" placeholder="<?php echo e(translate('messages.type_short_description')); ?>"
                                                                  class="form-control min-h-90px ckeditor"><?php echo e(old('description.0')); ?></textarea>
                                                    </div>
                                                </div>
                                                <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="d-none lang_form" id="<?php echo e($lang); ?>-form">
                                                        <div class="form-group mb-20">
                                                            <label class="input-label font-semibold"
                                                                   for="<?php echo e($lang); ?>_name"><?php echo e(translate('messages.vehicle_name')); ?>

                                                                (<?php echo e(strtoupper($lang)); ?>)
                                                            </label>
                                                            <input type="text" name="name[]"
                                                                   id="<?php echo e($lang); ?>_name" class="form-control" value="<?php echo e(old('name.'.$key+1)); ?>"
                                                                   placeholder="<?php echo e(translate('messages.vehicle_name')); ?>">
                                                        </div>
                                                        <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                                        <div class="form-group mb-0">
                                                            <label class="input-label font-semibold"
                                                                   for="exampleFormControlInput1"><?php echo e(translate('messages.short_description')); ?>

                                                                (<?php echo e(strtoupper($lang)); ?>)</label>
                                                            <textarea type="text" name="description[]" placeholder="<?php echo e(translate('messages.vehicle_description')); ?>"
                                                                      class="form-control min-h-90px ckeditor"><?php echo e(old('description.'.$key+1)); ?></textarea>
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                <div id="default-form">
                                                    <div class="form-group mb-0">
                                                        <label class="input-label font-semibold"
                                                               for="exampleFormControlInput1"><?php echo e(translate('messages.vehicle_name')); ?>

                                                            (<?php echo e(translate('messages.default')); ?>)</label><span class="text-danger">*</span>
                                                        <input type="text" name="name[]" class="form-control"
                                                               placeholder="<?php echo e(translate('messages.vehicle_name')); ?>" required>
                                                    </div>
                                                    <input type="hidden" name="lang[]" value="default">
                                                    <div class="form-group mb-0">
                                                        <label class="input-label font-semibold"
                                                               for="exampleFormControlInput1"><?php echo e(translate('messages.short_description')); ?>

                                                        </label>
                                                        <textarea type="text" name="description[]" placeholder="<?php echo e(translate('messages.vehicle_description')); ?>"
                                                                  class="form-control min-h-90px ckeditor"></textarea>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <div class="text-center">
                                        <label class="text--title fs-16 font-semibold mb-1">
                                            <?php echo e(translate('Vehicle_Thumbnail')); ?><span class="text-danger">*</span>
                                        </label>
                                        <div class="mb-20">
                                            <p class="fs-12">
                                                <?php echo e(translate('JPG, JPEG, PNG Less Than 1MB')); ?> <strong class="font-semibold">(<?php echo e(translate('Ratio 2:1')); ?>)</strong>
                                            </p>
                                        </div>
                                        <div class="upload-file image-general d-inline-block w-auto">
                                            <a href="javascript:void(0);" class="remove-btn opacity-0 z-index-99">
                                                <i class="tio-clear"></i>
                                            </a>
                                            <input type="file" name="thumbnail" class="upload-file__input single_file_input"
                                                accept=".webp, .jpg, .jpeg, .png"  value="" required>
                                            <label
                                                class="upload-file-wrapper height-150px max-w-300px aspect-2-1">
                                                <div class="upload-file-textbox text-center w-100">
                                                    <img width="34" height="34" src="<?php echo e(asset('public/assets/admin/img/document-upload.svg')); ?>" alt="">
                                                    <h6 class="mt-2 font-semibold text-center">
                                                        <span><?php echo e(translate('Click to upload')); ?></span>
                                                        <br>
                                                        <?php echo e(translate('or drag and drop')); ?>

                                                    </h6>
                                                </div>
                                                <img class="upload-file-img d-none ratio-2" width="300" height="150" loading="lazy"  src="" alt="">
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h5 class="text-title mb-1">
                                    <?php echo e(translate('messages.Images')); ?><span class="text-danger">*</span>
                                </h5>
                                <p class="fs-12 mb-0">
                                    <?php echo e(translate('messages.JPG, JPEG, PNG Less Than 1MB')); ?>

                                    <span class="font-semibold"> <?php echo e(translate('(Ratio 2:1)')); ?></span>
                                </p>
                            </div>
                        </div>
                        <div class="card-body py-1">

                            <div class="d-flex pt-20 pb-2 overflow-x-auto">
                               <div class="d-flex gap-3 flex-shrink-0" id="image_container">
                                   <div class="upload-file text-wrapper h--100px w--200px flex-shrink-0"
                                        id="image_upload_wrapper">
                                       <input type="file" name="images[]"
                                              class="upload-file__input multiple_image_input" accept=".webp, .jpg,.jpeg,.png" multiple required>
                                       <div
                                           class="upload-file__img d-flex gap-0 justify-content-center align-items-center h-100 max-w-300px p-0">
                                           <div class="upload-file__textbox">
                                               <img width="34" height="34"
                                                    src="<?php echo e(asset('public/assets/admin/img/document-upload.png')); ?>"
                                                    alt="" class="svg">
                                               <h6 class="mt-2 font-semibold">
                                                   <span class="text-info"><?php echo e(translate('Click to upload')); ?></span><br>
                                                   <?php echo e(translate('or drag and drop')); ?>

                                               </h6>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h5 class="text-title mb-1">
                                    <?php echo e(translate('messages.Vehicle_Information')); ?>

                                </h5>
                                <p class="fs-12 mb-0">
                                    <?php echo e(translate('messages.Insert_The_Vehicle\'s_General_Informations')); ?>

                                </p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-lg-4">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="choice_provider"><?php echo e(translate('messages.provider')); ?><span class="text-danger">*</span></label>
                                        <select name="provider_id" id="choice_provider" class="form-control js-select2-custom"
                                                data-placeholder="<?php echo e(translate('messages.select_vehicle_provider')); ?>" required>
                                            <option value="" selected disabled><?php echo e(translate('messages.select_vehicle_provider')); ?></option>
                                            <?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($provider->id); ?>"
                                                    <?php echo e((old('provider_id') == $provider->id || request()->provider_id == $provider->id) ? 'selected' : ''); ?>>
                                                <?php echo e($provider->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="choice_brand"><?php echo e(translate('messages.brand')); ?><span class="text-danger">*</span></label>
                                        <select name="brand_id" id="choice_brand" class="form-control js-select2-custom"
                                                data-placeholder="<?php echo e(translate('messages.select_vehicle_brand')); ?>" required>
                                            <option value="" selected disabled><?php echo e(translate('messages.select_vehicle_brand')); ?></option>
                                            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($brand->id); ?>" <?php echo e(old('brand_id') == $brand->id ? 'selected' : ''); ?>>
                                                    <?php echo e($brand->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for=""><?php echo e(translate('messages.Model')); ?><span class="text-danger">*</span></label>
                                        <input type="text" name="model" class="form-control" placeholder="Model Name" value="<?php echo e(old('model')); ?>" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="choice_category"><?php echo e(translate('messages.category')); ?><span class="text-danger">*</span></label>
                                        <select name="category_id" id="choice_category" class="form-control js-select2-custom"
                                                data-placeholder="<?php echo e(translate('messages.select_vehicle_category')); ?>" required>
                                            <option value="" selected disabled><?php echo e(translate('messages.select_vehicle_category')); ?></option>
                                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id') == $category->id ? 'selected' : ''); ?>>
                                                    <?php echo e($category->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="choice_type"><?php echo e(translate('messages.type')); ?><span class="text-danger">*</span></label>
                                        <select name="type" id="choice_type" class="form-control js-select2-custom"
                                                data-placeholder="<?php echo e(translate('messages.select_vehicle_type')); ?>" required>
                                            <option value="" selected disabled><?php echo e(translate('messages.select_vehicle_type')); ?></option>
                                            <option value="family" <?php echo e(old('type') == 'family' ? 'selected' : ''); ?>><?php echo e(translate('messages.family')); ?></option>
                                            <option value="luxury" <?php echo e(old('type') == 'luxury' ? 'selected' : ''); ?>><?php echo e(translate('messages.Luxury')); ?></option>
                                            <option value="affordable" <?php echo e(old('type') == 'affordable' ? 'selected' : ''); ?>><?php echo e(translate('messages.Affordable')); ?></option>
                                            <option value="executives" <?php echo e(old('type') == 'executives' ? 'selected' : ''); ?>><?php echo e(translate('messages.Executives')); ?></option>
                                            <option value="compact" <?php echo e(old('type') == 'compact' ? 'selected' : ''); ?>><?php echo e(translate('messages.Compact')); ?></option>
                                            <option value="full_size" <?php echo e(old('type') == 'full_size' ? 'selected' : ''); ?>><?php echo e(translate('messages.Full-Size')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for=""><?php echo e(translate('messages.Engine Capacity (cc)')); ?><span class="text-danger">*</span></label>
                                        <input type="number" name="engine_capacity" class="form-control" placeholder="Ex: 450" value="<?php echo e(old('engine_capacity')); ?>" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for=""><?php echo e(translate('messages.Engine Power (hp)')); ?><span class="text-danger">*</span></label>
                                        <input type="number" name="engine_power" class="form-control" placeholder="Ex: 100" value="<?php echo e(old('engine_power')); ?>" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for=""><?php echo e(translate('messages.Seating Capacity')); ?><span class="text-danger">*</span></label>
                                        <input type="number" name="seating_capacity" class="form-control" placeholder="Input how many person can seat" value="<?php echo e(old('seating_capacity')); ?>" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for=""><?php echo e(translate('messages.Air Condition')); ?><span class="text-danger">*</span></label>
                                        <div class="resturant-type-group border">
                                            <label class="form-check form--check mr-2 mr-md-4">
                                                <input class="form-check-input" type="radio" value="1" name="air_condition" <?php echo e(old('air_condition') == '1' ? 'checked' : ''); ?>>
                                                <span class="form-check-label"><?php echo e(translate('messages.yes')); ?></span>
                                            </label>
                                            <label class="form-check form--check mr-2 mr-md-4">
                                                <input class="form-check-input" type="radio" value="0" name="air_condition" <?php echo e(old('air_condition') == '0' ? 'checked' : ''); ?>>
                                                <span class="form-check-label"><?php echo e(translate('messages.no')); ?></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="choice_fuel_type"><?php echo e(translate('messages.fuel_type')); ?><span class="text-danger">*</span></label>
                                        <select name="fuel_type" id="choice_fuel_type" class="form-control js-select2-custom"
                                                data-placeholder="<?php echo e(translate('messages.select_fuel_type')); ?>" required>
                                            <option value="" selected disabled><?php echo e(translate('messages.select_vehicle_fuel_type')); ?></option>
                                            <option value="octan" <?php echo e(old('fuel_type') == 'octan' ? 'selected' : ''); ?>><?php echo e(translate('messages.Octan')); ?></option>
                                            <option value="diesel" <?php echo e(old('fuel_type') == 'diesel' ? 'selected' : ''); ?>><?php echo e(translate('messages.diesel')); ?></option>
                                            <option value="CNG" <?php echo e(old('fuel_type') == 'CNG' ? 'selected' : ''); ?>><?php echo e(translate('messages.CNG')); ?></option>
                                            <option value="petrol" <?php echo e(old('fuel_type') == 'petrol' ? 'selected' : ''); ?>><?php echo e(translate('messages.Petrol')); ?></option>
                                            <option value="electric" <?php echo e(old('fuel_type') == 'electric' ? 'selected' : ''); ?>><?php echo e(translate('messages.Electric')); ?></option>
                                            <option value="jet_fuel" <?php echo e(old('fuel_type') == 'jet_fuel' ? 'selected' : ''); ?>><?php echo e(translate('messages.Jet Fuel')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="choice_transmission_type"><?php echo e(translate('messages.transmission_type')); ?><span class="text-danger">*</span></label>
                                        <select name="transmission_type" id="choice_transmission_type" class="form-control js-select2-custom"
                                                data-placeholder="<?php echo e(translate('messages.select_vehicle_transmission')); ?>" required>
                                            <option value="" selected disabled><?php echo e(translate('messages.select_vehicle_transmission')); ?></option>
                                            <option value="automatic" <?php echo e(old('transmission_type') == 'automatic' ? 'selected' : ''); ?>><?php echo e(translate('Automatic')); ?></option>
                                            <option value="manual" <?php echo e(old('transmission_type') == 'manual' ? 'selected' : ''); ?>><?php echo e(translate('Manual')); ?></option>
                                            <option value="continuously_variable" <?php echo e(old('transmission_type') == 'continuously_variable' ? 'selected' : ''); ?>><?php echo e(translate('Continuously Variable')); ?></option>
                                            <option value="dual_clutch" <?php echo e(old('transmission_type') == 'dual_clutch' ? 'selected' : ''); ?>><?php echo e(translate('Dual-Clutch')); ?></option>
                                            <option value="semi_automatic" <?php echo e(old('transmission_type') == 'semi_automatic' ? 'selected' : ''); ?>><?php echo e(translate('Semi-Automatic')); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header flex-wrap gap-3">
                            <div class="flex-grow-1">
                                <h5 class="text-title mb-1">
                                    <?php echo e(translate('messages.Vehicle Identity')); ?>

                                </h5>
                                <p class="fs-12 mb-0">
                                    <?php echo e(translate('messages.Insert_The_Vehicle\'s_Unique_Informations')); ?>

                                </p>
                            </div>
                            <label class="d-flex align-items-center gap-2">
                                <span class="text--title">
                                    <?php echo e(translate('messages.Same Model Multiple Vehicles')); ?>

                                </span>
                                <input class="form-check-input single-select position-relative m-0" type="checkbox" name="multiple_vehicles">
                            </label>
                        </div>
                        <div class="card-body d-flex flex-column gap-20px">
                            <div class="d-flex gap-20px flex-column flex-md-row equal-width" id="input-container">
                                <div class="form-group mb-0">
                                    <label class="input-label"
                                           for=""><?php echo e(translate('messages.VIN Number')); ?><span class="text-danger">*</span></label>
                                    <input type="text" name="vehicle[vin_number][]" class="form-control"
                                           placeholder="Type your vin number" value="" required>
                                </div>
                                <div class="form-group mb-0">
                                    <label class="input-label"
                                           for=""><?php echo e(translate('messages.License Plate Number')); ?><span class="text-danger">*</span></label>
                                    <input type="text" name="vehicle[license_plate_number][]" class="form-control"
                                           placeholder="Type your license plate number" value="" required>
                                </div>
                                <button type="button"
                                     data-vin="<?php echo e(translate("messages.VIN Number")); ?>"
                                        data-license="<?php echo e(translate("messages.License Plate Number")); ?>"
                                        class="btn plus-btn shadow-none text--primary p-0 fs-32 lh--1 text-left mt-md-4 add-btn">
                                    <i class="tio-add-circle-outlined"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h5 class="text-title mb-1">
                                    <?php echo e(translate('messages.Pricing & Discounts')); ?>

                                </h5>
                                <p class="fs-12 mb-0">
                                    <?php echo e(translate('messages.Insert_The_Pricing & Discount Informations')); ?>

                                </p>
                            </div>
                        </div>
                            <div class="card-body">

                    <div class="bg--secondary rounded p-20 mobile-space-0">
                                            <div class="mb-3">
                        <h6 class="fz--14px mb-1">
                            <?php echo e(translate('messages.Trip Type')); ?>

                        </h6>
                        <p class="fs-12 mb-0">
                            <?php echo e(translate('messages.Choose the trip type you prefer.')); ?>

                        </p>
                    </div>
                        <div class="bg-white rounded p-15 border">

                            <div class="row g-3">

                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group mb-0">
                                        <div class="p-0 resturant-type-group">
                                            <label class="d-flex mb-0 form-check item">
                                                <input class="form-check-input single-select" type="checkbox" name="trip_hourly"
                                                        value="hourly" <?php echo e(old('trip_hourly') == 'hourly' ? 'checked' : ''); ?>>
                                                <span class="form-check-label ml-2 mt-1">
                                                    <span class="title-clr d-block fz--14px"><?php echo e(translate('Hourly')); ?></span>
                                                    <p class="fz-12px mb-0 "><?php echo e(translate('Set your hourly rental price.')); ?></p>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group mb-0">
                                        <div class="p-0 resturant-type-group">
                                            <label class="d-flex mb-0 form-check item">
                                                <input class="form-check-input single-select" type="checkbox" name="trip_day_wise" value="trip_day_wise">
                                                <span class="form-check-label ml-2 mt-1">
                                                    <span class="title-clr d-block fz--14px"><?php echo e(translate('Per Day')); ?></span>
                                                    <p class="fz-12px mb-0 "><?php echo e(translate('Set your Per Day rental price.')); ?></p>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                   <div class="col-md-6 col-lg-4">
                                    <div class="form-group mb-0">
                                        <div class="p-0 resturant-type-group">
                                            <label class="d-flex mb-0 form-check item">
                                                <input class="form-check-input single-select" type="checkbox" name="trip_distance"
                                                        value="distance_wise" <?php echo e(old('trip_distance') == 'distance_wise' ? 'checked' : ''); ?>>
                                                <span class="form-check-label ml-2 mt-1">
                                                    <span class="title-clr d-block fz--14px"><?php echo e(translate('Distance Wise')); ?></span>
                                                    <p class="fz-12px mb-0 "><?php echo e(translate('Set your distance wise rental price.')); ?></p>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mt-2">

                            <div class="col-hide">
                                <div class="form-group mb-0">
                                    <label class="input-label" for=""><?php echo e(translate('messages.Hourly Wise Price ($/per hour)')); ?><span class="text-danger">*</span></label>
                                    <input type="number" name="hourly_price" class="form-control"
                                            placeholder="Ex: 35.25" min="0.01" step="0.01" value="<?php echo e(old('hourly_price')); ?>" required>
                                </div>
                            </div>

                            <div class="col-hide">
                                <div class="form-group mb-0">
                                    <label class="input-label" for=""><?php echo e(translate('messages.Per Day Price ($/per day)')); ?><span class="text-danger">*</span></label>
                                    <input type="number" name="day_wise_price" class="form-control"
                                            placeholder="Ex: 35.25" min="0.01" step="0.01" value="<?php echo e(old('day_wise_price')); ?>" required>
                                </div>
                            </div>
                            <div class="col-hide">
                                <div class="form-group mb-0">
                                    <label class="input-label" for=""><?php echo e(translate('messages.Distance Wise Price ($/per km)')); ?><span class="text-danger">*</span></label>
                                    <input type="number" name="distance_price" class="form-control"
                                            placeholder="Ex: 35.25" min="0.01" step="0.01" value="<?php echo e(old('distance_price')); ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-20 bg--secondary rounded p-20 mobile-space-0">
                        <div class="row g-3">
                            <div class="col-xxl-3 col-md-4">
                                <div class="mb-0">
                                    <h6 class="fz--14px mb-1">
                                        <?php echo e(translate('messages.Give Discount')); ?>

                                    </h6>
                                    <p class="fz-12px mb-0">
                                        <?php echo e(translate('messages.Set a discount that applies to all pricing types—hourly, daily, and distance-based')); ?>

                                    </p>
                                </div>
                            </div>
                            <div class="col-xxl-9 col-md-8">
                                <div class="bg-white rounded p-20 mobile-space-0">
                                    <div class="form-group mb-0">
                                        <div class="custom-group-btn border">
                                            <div class="flex-sm-grow-1">
                                                <input id="discount_input" type="number" name="discount_price" class="form-control h--45px border-0 pl-unset"
                                                        placeholder="Ex: 10" min="0" step="0.001" value="<?php echo e(old('discount_price')); ?>">
                                            </div>
                                            <div class="flex-shrink-0">
                                                <select name="discount_type" id="discount_type" class="custom-select ltr border-0">
                                                    <option value="percent" <?php echo e(old('discount_type') == 'percent' ? 'selected' : ''); ?>>%</option>
                                                    <option value="amount" <?php echo e(old('discount_type') == 'amount' ? 'selected' : ''); ?>>
                                                        <?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>

                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h5 class="text-title mb-1">
                                    <?php echo e(translate('messages.Search_Tags')); ?>

                                </h5>
                                <p class="fs-12 mb-0">
                                    <?php echo e(translate('messages.Insert_The_Tags_For_Appear_In_User\'s_Search_List')); ?>

                                </p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-0 pickup-zone-tag">
                                <select name="tag[]" id="pickup_zones12"
                                        class="form-control js-select2-custom select2-hidden-accessible" multiple="multiple">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h5 class="text-title mb-1">
                                    <?php echo e(translate('messages.Vehicle_Documents')); ?><span class="text-danger">*</span>
                                </h5>
                                <p class="fs-12 mb-0">
                                    <?php echo e(translate('messages.Upload_Vehicle\'s_Important_Documents')); ?>

                                </p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex py-3 overflow-x-auto">
                                <div class="d-flex gap-3 flex-shrink-0" id="pdf-container">
                                    <div class="upload-file text-wrapper document-wrapper" id="upload-wrapper">
                                        <input type="file" name="documents[]"
                                            class="upload-file__input multiple_document_input" accept="*"
                                            multiple required>
                                        <div
                                            class="upload-file__img d-flex justify-content-center align-items-center h-100 max-w-300px p-0">
                                            <div class="upload-file__textbox pdf">
                                                <img width="34" height="34"
                                                    src="<?php echo e(asset('public/assets/admin/img/document-upload.png')); ?>"
                                                    alt="" class="svg">
                                                <h6 class="font-semibold">
                                                    <span class="text-info"><?php echo e(translate('Click to upload')); ?></span><br>
                                                    <?php echo e(translate('or drag and drop')); ?>

                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="btn--container justify-content-end mt-20">
                        <button type="reset" id="reset_btn"
                                class="btn btn--reset min-w-120px"><?php echo e(translate('messages.reset')); ?></button>
                        <button type="submit"
                                class="btn btn--primary min-w-120px"><?php echo e(translate('messages.submit')); ?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>

<input type="hidden" id="file_size_error_text" value="<?php echo e(translate('file_size_too_big')); ?>">
<input type="hidden" id="file_type_error_text" value="<?php echo e(translate('please_only_input_png_or_jpg_type_file')); ?>">
<input type="hidden" id="max_file_upload_limit_error_text" value="<?php echo e(translate('maximum_file_upload_limit_is_')); ?>">



<div id="file-assets"
    data-picture-icon="<?php echo e(asset('public/assets/admin/img/picture.svg')); ?>"
    data-document-icon="<?php echo e(asset('public/assets/admin/img/document.svg')); ?>"
    data-blank-thumbnail="<?php echo e(asset('public/assets/admin/img/blank2.png')); ?>">
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin/js/spartan-multi-image-picker.js')); ?>"></script>
    <script src="<?php echo e(asset('Modules/Rental/public/assets/js/view-pages/provider/pdf.min.js')); ?>"></script>
    <script src="<?php echo e(asset('Modules/Rental/public/assets/js/admin/view-pages/vehicle-create.js')); ?>"></script>
    <script src="<?php echo e(asset('Modules/Rental/public/assets/js/view-pages/provider/multiple-upload.js')); ?>"></script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/vehicle/create.blade.php ENDPATH**/ ?>