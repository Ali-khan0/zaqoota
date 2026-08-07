<?php $__env->startSection('title', translate('messages.Create New Provider')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('Modules/Rental/public/assets/css/admin/provider-create.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header pb-20">
            <div class="d-flex justify-content-between flex-wrap gap-3">
                <div>
                    <h1 class="page-header-title text-break">
                        <span class="page-header-icon">
                            <img src="<?php echo e(asset('public/assets/admin/img/provider.png')); ?>" class="w--22" alt="">
                        </span>
                        <span><?php echo e(translate('messages.Create New Provider')); ?>

                    </span> </h1>

                </div>
            </div>
        </div>

        <?php ($language = \App\Models\BusinessSetting::where('key', 'language')->first()?->value ?? null); ?>
        <!-- End Page Header -->
        <form action="#" method="post" enctype="multipart/form-data" id="providerFormSubmit">
            <?php echo csrf_field(); ?>

            <div id="businessSetup">
                <div class="custom-timeline d-flex flex-wrap gap-40px text-title mb-2">
                    <h4 class="single"><span class="count">1</span><?php echo e(translate('Business Basic Setup')); ?></h4>
                    <h4 class="single opacity-70"><span class="count2">2</span><?php echo e(translate('Business Plan Setup')); ?></h4>
                </div>

                <div class="row g-2">
                    <div class="col-lg-12">
                        <div class="card mt-4">
                            <div class="card-header">
                                <div>
                                    <h5 class="text-title mb-1">
                                        <?php echo e(translate('messages.General_Info')); ?>

                                    </h5>
                                    <p class="fs-12 mb-0">
                                        <?php echo e(translate('messages. Insert the basic information of the provider ')); ?>

                                    </p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-lg-6">
                                        <div class="card __bg-FAFAFA border-0">
                                            <div class="card-body">
                                                <?php if($language): ?>
                                                    <ul class="nav nav-tabs mb-4 flex-nowrap">
                                                        <li class="nav-item">
                                                            <a class="nav-link lang_link text-nowrap active" href="#"
                                                                id="default-link"><?php echo e(translate('Default')); ?></a>
                                                        </li>
                                                        <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <li class="nav-item">
                                                                <a class="nav-link lang_link text-nowrap" href="#"
                                                                    id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                                            </li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                <?php endif; ?>
                                                <?php if($language): ?>
                                                    <div class="lang_form" id="default-form">
                                                        <div class="form-group">
                                                            <label class="input-label font-semibold"
                                                                for="default_name"><?php echo e(translate('messages.name')); ?>

                                                                (<?php echo e(translate('messages.Default')); ?>)
                                                            </label>
                                                            <input type="text" name="name[]" id="default_name"
                                                                class="form-control"
                                                                placeholder="<?php echo e(translate('messages.provider_name')); ?>" value="<?php echo e(old('default_name')); ?>" required>
                                                        </div>
                                                        <input type="hidden" name="lang[]" value="default">
                                                        <div class="form-group mb-0">
                                                            <label class="input-label font-semibold"
                                                                for="exampleFormControlInput1"><?php echo e(translate('messages.address')); ?>

                                                                (<?php echo e(translate('messages.default')); ?>)</label>
                                                            <textarea type="text" name="address[]" id="default_address" placeholder="<?php echo e(translate('messages.address')); ?>"
                                                                class="form-control min-h-90px ckeditor"></textarea>
                                                        </div>
                                                    </div>
                                                    <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="d-none lang_form" id="<?php echo e($lang); ?>-form">
                                                            <div class="form-group">
                                                                <label class="input-label font-semibold"
                                                                    for="<?php echo e($lang); ?>_name"><?php echo e(translate('messages.name')); ?>

                                                                    (<?php echo e(strtoupper($lang)); ?>)
                                                                </label>
                                                                <input type="text" name="name[]"
                                                                    id="<?php echo e($lang); ?>_name" class="form-control"
                                                                    placeholder="<?php echo e(translate('messages.provider_name')); ?>">
                                                            </div>
                                                            <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                                            <div class="form-group mb-0">
                                                                <label class="input-label font-semibold"
                                                                    for="exampleFormControlInput1"><?php echo e(translate('messages.address')); ?>

                                                                    (<?php echo e(strtoupper($lang)); ?>)</label>
                                                                <textarea type="text" name="address[]" placeholder="<?php echo e(translate('messages.address')); ?>"
                                                                    class="form-control min-h-90px ckeditor"></textarea>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php else: ?>
                                                    <div id="default-form">
                                                        <div class="form-group">
                                                            <label class="input-label font-semibold"
                                                                for="exampleFormControlInput1"><?php echo e(translate('messages.name')); ?>

                                                                (<?php echo e(translate('messages.default')); ?>)</label>
                                                            <input type="text" name="name[]" class="form-control"
                                                                placeholder="<?php echo e(translate('messages.provider_name')); ?>" required>
                                                        </div>
                                                        <input type="hidden" name="lang[]" value="default">
                                                        <div class="form-group mb-0">
                                                            <label class="input-label font-semibold"
                                                                for="exampleFormControlInput1"><?php echo e(translate('messages.address')); ?>

                                                            </label>
                                                            <textarea type="text" name="address[]" placeholder="<?php echo e(translate('messages.address')); ?>"
                                                                class="form-control min-h-90px ckeditor"></textarea>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-6">
                                        <div class="d-flex flex-column flex-sm-row gap-4">
                                            <div class="__custom-upload-img">
                                                <?php ($logo = \App\Models\BusinessSetting::where('key', 'logo')->first()); ?>
                                                <?php ($logo = $logo->value ?? ''); ?>
                                                <label class="form-label mb-1">
                                                    <?php echo e(translate('logo')); ?>

                                                </label>
                                                <div class="mb-20">
                                                    <p class="fs-12 max-width-170px"><?php echo e(translate('JPG, JPEG, PNG Less Than 2MB')); ?> <strong
                                                            class="font-semibold">(<?php echo e(translate('Ratio 1:1')); ?>)</strong></p>
                                                </div>
                                                <label
                                                    class="position-relative d-inline-block image--border cursor-pointer w-100 h-165 max-w-165">
                                                    <img class="h-165 aspect-ratio-1 rounded-10 display-none"
                                                        id="logoImageViewer"
                                                        data-onerror-image="<?php echo e(asset('public/assets/admin/img/upload.png')); ?>"
                                                        src="<?php echo e(asset('public/assets/admin/img/upload-img.png')); ?>"
                                                        alt="logo image"/>
                                                    <div class="upload-file__textbox p-2 h-100">
                                                        <img width="34" height="34"
                                                            src="<?php echo e(asset('public/assets/admin/img/document-upload.png')); ?>"
                                                            alt="" class="svg">
                                                        <h6 class="mt-2 text-center font-semibold fs-12">
                                                            <span
                                                                class="text-info"><?php echo e(translate('messages.Click to upload')); ?></span>
                                                            <br>
                                                            <?php echo e(translate('messages.or drag and drop')); ?>

                                                        </h6>
                                                    </div>
                                                    <div class="icon-file-group outside">

                                                        <input type="file" name="logo" id="customFileEg1"
                                                                class="custom-file-input"
                                                                accept=".webp, .jpg, .png, .jpeg|image/*">
                                                    </div>
                                                </label>
                                            </div>

                                            <div class="__custom-upload-img">
                                                <?php ($icon = \App\Models\BusinessSetting::where('key', 'icon')->first()); ?>
                                                <?php ($icon = $icon->value ?? ''); ?>
                                                <label class="form-label mb-1">
                                                    <?php echo e(translate('Cover')); ?>

                                                </label>
                                                <div class="mb-20">
                                                    <p class="fs-12">
                                                        <?php echo e(translate('JPG, JPEG, PNG Less Than 2MB')); ?>

                                                        <br>
                                                        <strong class="font-semibold">(<?php echo e(translate('Ratio 2:1')); ?>)</strong>
                                                    </p>
                                                </div>
                                                <label
                                                    class="position-relative d-inline-block image--border cursor-pointer w-100 h-165 min-w-330 min-w-100-mobile">
                                                    <img class="img--vertical-2 h-165 rounded-10 image--border display-none"
                                                        id="coverImageViewer"
                                                        data-onerror-image="<?php echo e(asset('public/assets/admin/img/upload-img.png')); ?>"
                                                        src="<?php echo e(asset('public/assets/admin/img/upload-img.png')); ?>"
                                                        alt="Fav icon" />
                                                    <div class="upload-file__textbox p-2 h-100">
                                                        <img width="34" height="34"
                                                            src="<?php echo e(asset('public/assets/admin/img/document-upload.png')); ?>"
                                                            alt="" class="svg">
                                                        <h6 class="mt-2 text-center font-semibold fs-12">
                                                            <span
                                                                class="text-info"><?php echo e(translate('messages.Click to upload')); ?></span>
                                                            <br>
                                                            <?php echo e(translate('messages.or drag and drop')); ?>

                                                        </h6>
                                                    </div>
                                                    <div class="icon-file-group outside">

                                                        <input type="file" name="cover_photo" id="coverImageUpload"
                                                                class="custom-file-input"
                                                                accept=".webp, .jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                                    </div>
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
                                        <?php echo e(translate('messages.Business_Info')); ?>

                                    </h5>
                                    <p class="fs-12 mb-0">
                                        <?php echo e(translate('messages.Insert the necessary information to operate the business')); ?>

                                    </p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row g-3 my-0">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="input-label font-semibold"
                                                for="choice_zones"><?php echo e(translate('messages.business_zone')); ?>

                                                <span class="form-label-secondary" data-toggle="tooltip"
                                                    data-placement="right"
                                                    data-original-title="<?php echo e(translate('messages.Select the zone from where the business will be operated')); ?>">
                                                    <i class="tio-info text--title opacity-60"></i>
                                                </span>
                                            </label>
                                            <select name="zone_id" data-zone-coordinates-url="<?php echo e(route('admin.zone.get-coordinates', ['id' => 'PLACEHOLDER_ID'])); ?>" id="choice_zones" required
                                                class="form-control js-select2-custom"
                                                data-placeholder="<?php echo e(translate('messages.select_zone')); ?>">
                                                <option value="" selected disabled>
                                                    <?php echo e(translate('messages.select_zone')); ?></option>
                                                <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if(isset(auth('admin')->user()->zone_id)): ?>
                                                        <?php if(auth('admin')->user()->zone_id == $zone->id): ?>
                                                            <option value="<?php echo e($zone->id); ?>"><?php echo e($zone->name); ?></option>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <option value="<?php echo e($zone->id); ?>"><?php echo e($zone->name); ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="form-group mb-5 pickup-zone-tag">
                                            <label class="input-label font-semibold"
                                                for="pickup_zones"><?php echo e(translate('messages.pickup_zone')); ?><span
                                                    class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                                                    data-original-title="<?php echo e(translate('messages.Select zones from where customer can choose their pickup locations for trip booking')); ?>">
                                                    <i class="tio-info text--title opacity-60"></i>
                                                </span></label>
                                            <select name="pickup_zones[]" id="pickup_zones"
                                                class="form-control  multiple-select2" multiple="multiple">
                                                <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if(isset(auth('admin')->user()->zone_id)): ?>
                                                        <?php if(auth('admin')->user()->zone_id == $zone->id): ?>
                                                            <option value="<?php echo e($zone->id); ?>" selected><?php echo e($zone->name); ?>

                                                            </option>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <option value="<?php echo e($zone->id); ?>"><?php echo e($zone->name); ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label class="input-label" for="latitude"><?php echo e(translate('messages.latitude')); ?>

                                                <span class="input-label-secondary"
                                                      title="<?php echo e(translate('messages.provider_lat_lng_warning')); ?>"><img
                                                        src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>"
                                                        alt="<?php echo e(translate('messages.provider_lat_lng_warning')); ?>"></span></label>
                                            <input type="text" id="latitude" name="latitude"
                                                   class="form-control __form-control"
                                                   placeholder="<?php echo e(translate('messages.Ex:')); ?> -94.22213"
                                                   value="<?php echo e(old('latitude')); ?>" required readonly>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label class="input-label" for="longitude"><?php echo e(translate('messages.longitude')); ?>

                                                <span class="input-label-secondary"
                                                      title="<?php echo e(translate('messages.provider_lat_lng_warning')); ?>"><img
                                                        src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>"
                                                        alt="<?php echo e(translate('messages.provider_lat_lng_warning')); ?>"></span></label>
                                            <input type="text" name="longitude" class="form-control __form-control"
                                                   placeholder="<?php echo e(translate('messages.Ex:')); ?> 103.344322" id="longitude"
                                                   value="<?php echo e(old('longitude')); ?>" required readonly>
                                        </div>
                                        <div class="position-relative">
                                            <label class="input-label font-semibold"
                                                for="tax"><?php echo e(translate('Approx. Pickup Time')); ?></label>
                                            <div class="custom-group-btn">
                                                <div class="item flex-sm-grow-1">
                                                    <label class="floating-label"
                                                        for="min"><?php echo e(translate('Min')); ?>:</label>
                                                    <input id="min" type="number" name="minimum_delivery_time"
                                                        value=""
                                                        class="form-control h--45px border-0"
                                                        placeholder="<?php echo e(translate('messages.Ex :')); ?> 20"
                                                        pattern="^[0-9]{2}$" required>
                                                </div>
                                                <div class="separator"></div>
                                                <div class="item flex-sm-grow-1">
                                                    <label class="floating-label"
                                                        for="max"><?php echo e(translate('Max')); ?>:</label>
                                                    <input id="max" type="number" name="maximum_delivery_time"
                                                        value=""
                                                        class="form-control h--45px border-0"
                                                        placeholder="<?php echo e(translate('messages.Ex :')); ?> 30" pattern="[0-9]{2}$"
                                                        required>
                                                </div>
                                                <div class="separator"></div>
                                                <div class="item flex-shrink-0">
                                                    <select name="delivery_time_type" id="delivery_time_type"
                                                        class="custom-select border-0">
                                                        <option value="min"  >
                                                            <?php echo e(translate('messages.minutes')); ?>

                                                        </option>
                                                        <option value="hours" >
                                                            <?php echo e(translate('messages.hours')); ?>

                                                        </option>
                                                        <option value="days" >
                                                            <?php echo e(translate('messages.days')); ?>

                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <input id="pac-input1" class="controls rounded" data-toggle="tooltip"
                                            data-placement="right"
                                            data-original-title="<?php echo e(translate('messages.search_your_location_here')); ?>"
                                            type="text" placeholder="<?php echo e(translate('messages.search_here')); ?>" />
                                        <div id="map" class="min-h-100"></div>
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
                                        <?php echo e(translate('messages.owner_information')); ?>

                                    </h5>
                                    <p class="fs-12 mb-0">
                                        <?php echo e(translate('messages.Add the information of the Owner who operate the business')); ?>

                                    </p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4 col-sm-6">
                                        <div class="form-group mb-0">
                                            <label class="input-label"
                                                for="f_name"><?php echo e(translate('messages.first_name')); ?></label>
                                            <input type="text" name="f_name" class="form-control" id="f_name"
                                                placeholder="<?php echo e(translate('messages.first_name')); ?>" value="<?php echo e(old('f_name')); ?>"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="form-group mb-0">
                                            <label class="input-label"
                                                for="l_name"><?php echo e(translate('messages.last_name')); ?></label>
                                            <input type="text" name="l_name" class="form-control" id="l_name"
                                                placeholder="<?php echo e(translate('messages.last_name')); ?>" value="<?php echo e(old('l_name')); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="form-group mb-0">
                                            <label class="input-label"
                                                for="phone"><?php echo e(translate('messages.phone')); ?></label>
                                            <input type="tel" id="phone" name="phone" class="form-control"
                                                placeholder="<?php echo e(translate('messages.Ex:')); ?> 017********" value="<?php echo e(old('phone')); ?>"
                                                required>
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
                                        <?php echo e(translate('messages.account_information')); ?>

                                    </h5>
                                    <p class="fs-12 mb-0">
                                        <?php echo e(translate('messages.Insert the necessary information to account information')); ?>

                                    </p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4 col-sm-6">
                                        <div class="form-group mb-0">
                                            <label class="input-label"
                                                for="exampleFormControlInput1"><?php echo e(translate('messages.email')); ?></label>
                                            <input type="email" name="email" class="form-control" id="email"
                                                placeholder="<?php echo e(translate('messages.Ex:')); ?> ex@example.com"
                                                value="<?php echo e(old('email')); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="js-form-message form-group mb-0">
                                            <label class="input-label"
                                                for="signupSrPassword"><?php echo e(translate('password')); ?><span
                                                    class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                                                    data-original-title="<?php echo e(translate('messages.Must_contain_at_least_one_number_and_one_uppercase_and_lowercase_letter_and_symbol,_and_at_least_8_or_more_characters')); ?>">
                                                    <i class="tio-info text--title opacity-60"></i>
                                                </span></label>

                                            <div class="input-group input-group-merge">
                                                <input type="password" class="js-toggle-password form-control"
                                                    name="password" id="signupSrPassword"
                                                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                    title="<?php echo e(translate('messages.Must_contain_at_least_one_number_and_one_uppercase_and_lowercase_letter_and_symbol,_and_at_least_8_or_more_characters')); ?>"
                                                    placeholder="<?php echo e(translate('messages.password_length_placeholder', ['length' => '8+'])); ?>"
                                                    aria-label="8+ characters required"
                                                    data-msg="Your password is invalid. Please try again."
                                                    data-hs-toggle-password-options='{
                                                "target": [".js-toggle-password-target-1", ".js-toggle-password-target-2"],
                                                "defaultClass": "tio-hidden-outlined",
                                                "showClass": "tio-visible-outlined",
                                                "classChangeTarget": ".js-toggle-passowrd-show-icon-1"
                                                }'>
                                                <div class="js-toggle-password-target-1 input-group-append">
                                                    <a class="input-group-text" href="javascript:;">
                                                        <i class="js-toggle-passowrd-show-icon-1 tio-visible-outlined"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="password-feedback" class="pass password-feedback">
                                            <?php echo e(translate('messages.password_not_matched')); ?>

                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="js-form-message form-group mb-0">
                                            <label class="input-label"
                                                for="signupSrConfirmPassword"><?php echo e(translate('messages.Confirm Password')); ?></label>

                                            <div class="input-group input-group-merge">
                                                <input type="password" class="js-toggle-password form-control"
                                                    name="confirmPassword" id="signupSrConfirmPassword"
                                                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                                    title="<?php echo e(translate('messages.Must_contain_at_least_one_number_and_one_uppercase_and_lowercase_letter_and_symbol,_and_at_least_8_or_more_characters')); ?>"
                                                    placeholder="<?php echo e(translate('messages.password_length_placeholder', ['length' => '8+'])); ?>"
                                                    aria-label="8+ characters required"
                                                    data-msg="Password does not match the confirm password."
                                                    data-hs-toggle-password-options='{
                                                    "target": [".js-toggle-password-target-1", ".js-toggle-password-target-2"],
                                                    "defaultClass": "tio-hidden-outlined",
                                                    "showClass": "tio-visible-outlined",
                                                    "classChangeTarget": ".js-toggle-passowrd-show-icon-2"
                                                    }'>
                                                <div class="js-toggle-password-target-2 input-group-append">
                                                    <a class="input-group-text" href="javascript:;">
                                                        <i class="js-toggle-passowrd-show-icon-2 tio-visible-outlined"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="invalid-feedback" class="pass invalid-feedback">
                                            <?php echo e(translate('messages.password_not_matched')); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div>
                            <div class="card p-20">
                                <div class="mb-20">
                                    <h3 class="mb-1"><?php echo e(translate('Business TIN')); ?></h3>
                                    
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-8 col-xxl-9">
                                        <div class="bg--secondary rounded p-20 h-100">
                                            <div class="form-group">
                                                <label class="input-label mb-2 d-block title-clr fw-normal" for="exampleFormControlInput1"><?php echo e(translate('Taxpayer Identification Number(TIN)')); ?> </label>
                                                <input type="text" name="tin" placeholder="<?php echo e(translate('Type Your Taxpayer Identification Number(TIN)')); ?>" class="form-control"  >
                                            </div>
                                            <div class="form-group mb-0">
                                                <label class="input-label mb-2 d-block title-clr fw-normal" for="exampleFormControlInput1"><?php echo e(translate('Expire Date')); ?> </label>
                                                <input type="date" name="tin_expire_date" class="form-control"  >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-xxl-3">
                                        <div class="bg--secondary rounded p-20 h-100 single-document-uploaderwrap">
                                            <div class="d-flex align-items-center gap-1 justify-content-between mb-20">
                                                <div>
                                                    <h4 class="mb-1 fz--14px"><?php echo e(translate('TIN Certificate')); ?></h4>
                                                    <p class="fz-12px mb-0"><?php echo e(translate('pdf, doc, jpg. File size : max 2 MB')); ?></p>
                                                </div>
                                                <div class="d-flex gap-3 align-items-center">
                                                    <button type="button" id="doc_edit_btn" class="w-30px h-30 rounded d-flex align-items-center justify-content-center btn--primary btn px-3 icon-btn">
                                                        <i class="tio-edit"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div>
                                                <div id="file-assets"
                                                     data-picture-icon="<?php echo e(asset('public/assets/admin/img/picture.svg')); ?>"
                                                     data-document-icon="<?php echo e(asset('public/assets/admin/img/document.svg')); ?>"
                                                     data-blank-thumbnail="<?php echo e(asset('public/assets/admin/img/picture.svg')); ?>">
                                                </div>
                                                <!-- Upload box -->
                                                <div class="d-flex justify-content-center" id="pdf-container">
                                                    <div class="document-upload-wrapper" id="doc-upload-wrapper">
                                                        <input type="file" name="tin_certificate_image" class="document_input" accept=".doc, .pdf, .jpg, .png, .jpeg">
                                                        <div class="textbox">
                                                            <img width="40" height="40" class="svg"
                                                                 src="<?php echo e(asset('public/assets/admin/img/doc-uploaded.png')); ?>"
                                                                 alt="">
                                                            <p class="fs-12 mb-0"><?php echo e(translate('messages.Select a file or')); ?> <span class="font-semibold"><?php echo e(translate('messages.Drag & Drop')); ?></span>
                                                                <?php echo e(translate('messages.here')); ?></p>
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
                        <div class="btn--container justify-content-end mt-20">
                            <button type="reset" id="reset_btn"
                                class="btn btn--warning-light min-w-100px justify-content-center"><?php echo e(translate('messages.reset')); ?></button>
                            <button type="button"
                                class="btn btn--primary min-w-100px justify-content-center show-business-plan-div" id="nextStep"><?php echo e(translate('messages.next')); ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="businessPlan" class="d-none">
                <div class="custom-timeline d-flex flex-wrap gap-40px text-title mb-2">
                    <h4 class="single text-primary checked"><span class="count-checked">1</span><?php echo e(translate('messages.Business Basic Setup')); ?></h4>
                    <h4 class="single font-semibold"><span class="count btn-primary">2</span><?php echo e(translate('messages.Business Plan Setup')); ?></h4>
                </div>
                <div class="row g-2">
                    <div class="col-lg-12">
                        <div class="card mt-3">
                            <div class="card-header">
                                <div>
                                    <h5 class="text-title mb-1">
                                        <?php echo e(translate('messages.Choose Business Plan')); ?>

                                    </h5>
                                    <p class="fs-12 mb-0">
                                        <?php echo e(translate('messages.Pay per transaction or enjoy unlimited access with a subscription.')); ?>

                                    </p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-lg-6">
                                        <label class="business-plan-card-wrapper">
                                            <input type="radio" name="business_plan" class="business-plan-radio" value="commission-base" checked/>
                                            <div class="business-plan-card">
                                                <h4 class="fs-16 title text-title mb-10px opacity-70">
                                                    <?php echo e(translate('messages.Commission Base')); ?>

                                                </h4>
                                                <p class="fs-14 text-title opacity-70 mb-0">
                                                    <?php echo e(translate('messages.You have to give a certain percentage of commission to admin for every Trip request.')); ?>

                                                </p>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="business-plan-card-wrapper">
                                            <input type="radio" name="business_plan" class="business-plan-radio" value="subscription-base"/>
                                            <div class="business-plan-card">
                                                <h4 class="fs-16 title text-title mb-10px opacity-70">
                                                    <?php echo e(translate('messages.Subscription Base')); ?>

                                                </h4>
                                                <p class="fs-14 text-title opacity-70 mb-0">
                                                    <?php echo e(translate('messages.You have to pay certain amount in every month/year to admin as subscription fee.')); ?>

                                                </p>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="col-lg-12 mt-20" id="subscription-plan">
                                        <div>
                                            <div class="text-center mb-20">
                                                <h3 class="modal-title fs-16 opacity-lg font-bold">
                                                    <?php echo e(translate('Choose Subscription Package')); ?></h3>
                                            </div>
                                            <div class="plan-slider owl-theme owl-carousel owl-refresh">
                                                <?php $__empty_1 = true; $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <label class="__plan-item d-block hover <?php echo e((count($packages) > 4 && $key == 2) || (count($packages) < 5 && $key == 1) ? 'active' : ''); ?>">
                                                        <input type="radio" name="package_id" id="package_id"
                                                               value="<?php echo e($package->id); ?>" class="d-none" <?php echo e((count($packages) > 4 && $key == 2) || (count($packages) < 5 && $key == 1) ? 'checked' : ''); ?>>
                                                        <div class="inner-div">
                                                            <div class="text-center">
                                                                <h3 class="title"><?php echo e($package->package_name); ?></h3>
                                                                <h2 class="price"><?php echo e(\App\CentralLogics\Helpers::format_currency($package->price)); ?></h2>
                                                                <div class="day-count"><?php echo e($package->validity); ?>

                                                                    <?php echo e(translate('messages.days')); ?></div>
                                                            </div>
                                                            <ul class="info">

                                                                <?php if($package->mobile_app): ?>
                                                                    <li>
                                                                        <i class="tio-checkmark-circle"></i>
                                                                        <span><?php echo e(translate('messages.mobile_app')); ?></span>
                                                                    </li>
                                                                <?php endif; ?>
                                                                <?php if($package->chat): ?>
                                                                    <li>
                                                                        <i class="tio-checkmark-circle"></i>
                                                                        <span><?php echo e(translate('messages.chatting_options')); ?></span>
                                                                    </li>
                                                                <?php endif; ?>
                                                                <?php if($package->review): ?>
                                                                    <li>
                                                                        <i class="tio-checkmark-circle"></i>
                                                                        <span><?php echo e(translate('messages.review_section')); ?></span>
                                                                    </li>
                                                                <?php endif; ?>

                                                                <?php if($package->max_order == 'unlimited'): ?>
                                                                    <li>
                                                                        <i class="tio-checkmark-circle"></i>
                                                                        <span><?php echo e(translate('messages.Unlimited_Trips')); ?></span>
                                                                    </li>
                                                                <?php else: ?>
                                                                    <li>
                                                                        <i class="tio-checkmark-circle"></i>
                                                                        <span><?php echo e($package->max_order); ?> <?php echo e(translate('messages.Trips')); ?> </span>
                                                                    </li>
                                                                <?php endif; ?>
                                                                <?php if($package->max_product == 'unlimited'): ?>
                                                                    <li>
                                                                        <i class="tio-checkmark-circle"></i>
                                                                        <span><?php echo e(translate('messages.Unlimited_uploads')); ?></span>
                                                                    </li>
                                                                <?php else: ?>
                                                                    <li>
                                                                        <i class="tio-checkmark-circle"></i>
                                                                        <span><?php echo e($package->max_product); ?> <?php echo e(translate('messages.uploads')); ?></span>
                                                                    </li>
                                                                <?php endif; ?>
                                                            </ul>
                                                        </div>
                                                    </label>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <div class="text-center">
                                                        <?php echo e(translate('No Package Found')); ?>

                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="btn--container justify-content-end mt-20">
                            <button type="button" class="btn btn--reset min-w-100px justify-content-center" id="backBusinessSetup"><?php echo e(translate('messages.back')); ?></button>
                            <button type="submit" class="btn btn--primary min-w-100px justify-content-center" id="submit"><?php echo e(translate('messages.Submit')); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <?php ($default_location = \App\Models\BusinessSetting::where('key', 'default_location')->first()); ?>
    <?php ($default_location = $default_location->value ? json_decode($default_location->value, true) : 0); ?>

<div class="d-none" id="data-set"
    data-admin-zone-id="<?php echo e(auth('admin')->user()->zone_id); ?>"

    data-lat="<?php echo e($default_location ? $default_location['lat'] : '23.757989'); ?>"
    data-lng="<?php echo e($default_location ? $default_location['lng'] : '90.360587'); ?>"
    data-logoImageViewer="<?php echo e(asset('public/assets/admin/img/upload.png')); ?>"

    data-get-all-modules-url="<?php echo e(route('restaurant.get-all-modules')); ?>"
    data-password-valid="<?php echo e(translate('Password is valid')); ?>"
    data-password-invalid="<?php echo e(translate('Password format is invalid')); ?>"
    data-password-matched="<?php echo e(translate('Passwords Matched')); ?>"
    data-password-not-matched="<?php echo e(translate('confirmPassword not match')); ?>"

    data-store-logo-required="<?php echo e(translate('Store_logo_&_cover_photos_are_required')); ?>"
    data-store-name-required="<?php echo e(translate('Store_name_is_required')); ?>"
    data-store-address-required="<?php echo e(translate('Store_address_is_required')); ?>"
    data-select-zone="<?php echo e(translate('You_must_select_a_zone')); ?>"
    data-map-latlong-required="<?php echo e(translate('Must_click_on_the_map_for_lat/long')); ?>"
    data-tax-required="<?php echo e(translate('tax_is_required')); ?>"
    data-pickup-zone-required="<?php echo e(translate('You_must_select_a_pickup_zone')); ?>"
    data-min-delivery-time-required="<?php echo e(translate('minimum_delivery_time_is_required')); ?>"
    data-max-delivery-time-required="<?php echo e(translate('max_delivery_time_is_required')); ?>"
    data-first-name-required="<?php echo e(translate('first_name_is_required')); ?>"
    data-last-name-required="<?php echo e(translate('last_name_is_required')); ?>"
    data-phone-required="<?php echo e(translate('valid_phone_number_is_required')); ?>"
    data-email-required="<?php echo e(translate('email_is_required')); ?>"
    data-password-required="<?php echo e(translate('password_is_required')); ?>"
    data-confirm-password-mismatch="<?php echo e(translate('confirm_password_does_not_match')); ?>"
    data-select_pickup_zone="<?php echo e(translate('select_pickup_zone')); ?>"

></div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>

    <script src="<?php echo e(asset('public/assets/admin/js/file-preview/pdf.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/admin/js/file-preview/pdf-worker.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/admin/js/file-preview/add-multiple-document-upload.js')); ?>"></script>

    <script src="<?php echo e(asset('public/assets/admin/js/spartan-multi-image-picker.js')); ?>"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(\App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value); ?>&libraries=drawing,places&v=3.45.8">
    </script>
    <script src="<?php echo e(asset('Modules/Rental/public/assets/js/admin/view-pages/provider-create.js')); ?>"></script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/provider/create.blade.php ENDPATH**/ ?>