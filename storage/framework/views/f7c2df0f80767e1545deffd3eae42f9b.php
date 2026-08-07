<?php $__env->startSection('title', translate('messages.vehicle_details')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('/public/assets/admin/vendor/simplebar/dist/simplebar.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('/public/assets/admin/vendor/drift-zoom/dist/drift-basic.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('Modules/Rental/public/assets/css/provider/vehicle.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between flex-wrap gap-3">
                <div>
                    <h1 class="page-header-title text-break">
                        <span class="page-header-icon">
                            <img src="<?php echo e(asset('public/assets/admin/img/car-logo.png')); ?>" alt="">
                        </span>
                        <span><?php echo e($vehicle->name); ?>

                    </h1>
                </div>
                <div class="d-flex align-items-start flex-wrap gap-2">
                    <a class="btn btn--cancel h--45px d-flex gap-2 align-items-center form-alert" href="javascript:"
                       data-id="vehicle-<?php echo e($vehicle['id']); ?>" data-message="<?php echo e(translate('Want to delete this vehicle')); ?>" title="<?php echo e(translate('messages.delete_vehicle')); ?>">
                        <i class="tio-delete"></i>
                        <?php echo e(translate('messages.delete')); ?>

                    </a>

                    <form action="<?php echo e(route('vendor.vehicle.delete',[$vehicle['id']])); ?>?vehicle_list=<?php echo e(request()->vehicle_list); ?>" method="post" id="vehicle-<?php echo e($vehicle->id); ?>">
                        <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                    </form>
                    <a href="javascript:" class="btn btn--reset d-flex justify-content-between align-items-center gap-4 lh--1 h--45px">
                        <?php echo e(translate('messages.new_tag')); ?>

                        <label class="toggle-switch toggle-switch-sm" for="stocksCheckboxNew<?php echo e($vehicle->id); ?>">
                            <input type="checkbox" data-url="<?php echo e(route('vendor.vehicle.new-tag',[$vehicle['id'],$vehicle->new_tag?0:1])); ?>"
                                   class="toggle-switch-input redirect-url" id="stocksCheckboxNew<?php echo e($vehicle->id); ?>" <?php echo e($vehicle->new_tag?'checked':''); ?>>
                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                        </label>
                    </a>
                    <a href="javascript:" class="btn btn--reset d-flex justify-content-between align-items-center gap-4 lh--1 h--45px">
                        <?php echo e(translate('messages.status')); ?>

                        <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox<?php echo e($vehicle->id); ?>">
                            <input type="checkbox" data-url="<?php echo e(route('vendor.vehicle.status',[$vehicle['id'],$vehicle->status?0:1])); ?>"
                                   class="toggle-switch-input redirect-url" id="stocksCheckbox<?php echo e($vehicle->id); ?>" <?php echo e($vehicle->status?'checked':''); ?>>
                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                        </label>
                    </a>
                    <a href="<?php echo e(route('vendor.vehicle.edit', $vehicle->id)); ?>" class="btn btn--primary h--45px d-flex gap-2 align-items-center">
                        <i class="tio-edit"></i>
                        <?php echo e(translate('messages.Edit_Vechicle')); ?>

                    </a>
                </div>
            </div>
        </div>
        <div class="card mb-20">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="cz-product-gallery mb-20 mb-lg-0">
                            <div class="cz-preview">
                                <div id="sync1" class="owl-carousel owl-theme product-thumbnail-slider">
                                    <div class="owl-item active">
                                        <div class="product-preview-item d-flex align-items-center justify-content-center active"
                                             id="000">
                                            <img class="cz-image-zoom img-responsive w-100"
                                                 src="<?php echo e($vehicle['thumbnailFullUrl']); ?>"
                                                 data-zoom="<?php echo e($vehicle['thumbnailFullUrl']); ?>"
                                                 alt="Product" width="">
                                            <div class="cz-image-zoom-pane"></div>
                                        </div>
                                    </div>
                                    <?php $__currentLoopData = $vehicle['imagesFullUrl']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="owl-item ">
                                            <div class="product-preview-item d-flex align-items-center justify-content-center active"
                                                 id="image<?php echo e($key); ?>">
                                                <img class="cz-image-zoom img-responsive w-100"
                                                     src="<?php echo e($img); ?>"
                                                     data-zoom="<?php echo e($img); ?>"
                                                     alt="Product" width="">
                                                <div class="cz-image-zoom-pane"></div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            <div class="cz">
                                <div class="table-responsive" data-simplebar>
                                    <div class="d-flex">
                                        <div id="sync2" class="owl-carousel owl-theme product-thumb-slider">

                                            <div class="">
                                                <a class="product-preview-thumb color-variants-preview-box-CD5C5C active d-flex align-items-center justify-content-center"
                                                   id="preview-imgCD5C5C" href="#000">
                                                    <img alt="Product"
                                                         src="<?php echo e($vehicle['thumbnailFullUrl']); ?>">
                                                </a>
                                            </div>
                                            <?php $__currentLoopData = $vehicle['imagesFullUrl']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="">
                                                    <a class="product-preview-thumb color-variants-preview-box-CD5C5C active d-flex align-items-center justify-content-center"
                                                       id="preview-imgCD5C5C" href="#<?php echo e($key); ?>1">
                                                        <img alt="Product"
                                                             src="<?php echo e($img); ?>">
                                                    </a>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div>
                            <div class="d-flex flex-column-reverse flex-lg-row gap-20px gap-lg-40px">
                                <?php if($language): ?>
                                    <ul class="nav nav-tabs border-0 mb-4 flex-grow-1 flex-nowrap">
                                        <li class="nav-item">
                                            <a class="nav-link lang_link active" href="#"
                                               id="default-link"><?php echo e(translate('Default')); ?></a>
                                        </li>
                                        <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="nav-item">
                                                <a class="nav-link lang_link" href="#"
                                                   id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php endif; ?>
                                <div class="floating-review-wrapper">
                                    <div class="rating--review border rounded">
                                        <h5 class="title border-line font-medium d-flex align-items-center lh--1 mb-0">
                                                <span class="fs-14">
                                                    <span class="font-bold"><?php echo e($avgRating); ?></span>
                                                    <span class="color-758590">/5</span>
                                                </span>
                                            <div class="info text--title fs-14"><?php echo e($totalReviews); ?> <?php echo e(translate('Reviews')); ?></div>
                                        </h5>
                                    </div>
                                    <ul class="list-unstyled list-unstyled-py-2 mb-0 rating--review-right review-color-progress">
                                        <!-- Review Ratings -->
                                        <li class="d-flex align-items-center font-size-sm">
                                            <span class="progress-name mr-3"><?php echo e(translate('Excellent')); ?></span>
                                            <div class="progress flex-grow-1">
                                                <div class="progress-bar" role="progressbar"
                                                     style="width: <?php echo e($totalRating > 0 ? ($excellentCount / $totalRating) * 100 : 0); ?>%;"
                                                     aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span class="ml-3"><?php echo e($excellentCount); ?></span>
                                        </li>
                                        <!-- End Review Ratings -->

                                        <!-- Review Ratings -->
                                        <li class="d-flex align-items-center font-size-sm">
                                            <span class="progress-name mr-3"><?php echo e(translate('Good')); ?></span>
                                            <div class="progress flex-grow-1">
                                                <div class="progress-bar" role="progressbar"
                                                     style="width: <?php echo e($totalRating > 0 ? ($goodCount / $totalRating) * 100 : 0); ?>%;"
                                                     aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span class="ml-3"><?php echo e($goodCount); ?></span>
                                        </li>
                                        <!-- End Review Ratings -->

                                        <!-- Review Ratings -->
                                        <li class="d-flex align-items-center font-size-sm">
                                            <span class="progress-name mr-3"><?php echo e(translate('Average')); ?></span>
                                            <div class="progress flex-grow-1">
                                                <div class="progress-bar" role="progressbar"
                                                     style="width: <?php echo e($totalRating > 0 ? ($averageCount / $totalRating) * 100 : 0); ?>%;"
                                                     aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span class="ml-3"><?php echo e($averageCount); ?></span>
                                        </li>
                                        <!-- End Review Ratings -->

                                        <!-- Review Ratings -->
                                        <li class="d-flex align-items-center font-size-sm">
                                            <span class="progress-name mr-3"><?php echo e(translate('Below average')); ?></span>
                                            <div class="progress flex-grow-1">
                                                <div class="progress-bar" role="progressbar"
                                                     style="width: <?php echo e($totalRating > 0 ? ($belowAverageCount / $totalRating) * 100 : 0); ?>%;"
                                                     aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span class="ml-3"><?php echo e($belowAverageCount); ?></span>
                                        </li>
                                        <!-- End Review Ratings -->

                                        <!-- Review Ratings -->
                                        <li class="d-flex align-items-center font-size-sm">
                                            <span class="progress-name mr-3"><?php echo e(translate('Poor')); ?></span>
                                            <div class="progress flex-grow-1">
                                                <div class="progress-bar" role="progressbar"
                                                     style="width: <?php echo e($totalRating > 0 ? ($poorCount / $totalRating) * 100 : 0); ?>%;"
                                                     aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span class="ml-3"><?php echo e($poorCount); ?></span>
                                        </li>
                                        <!-- End Review Ratings -->
                                    </ul>
                                </div>
                            </div>
                            <?php if($language): ?>
                                <div class="lang_form text--title" id="default-form">
                                    <h3 class="text--title fs-20 ont-bold mb-10px"><?php echo e($vehicle?->getRawOriginal('name')); ?></h3>
                                    <h5 class="text--title font-semibold opacity-lg mb-10px">Description:</h5>
                                    <div class="fs-12 opacity-lg description-text">
                                        <span class="short-description"><?php echo e(Str::limit($vehicle?->getRawOriginal('description'), 2100)); ?></span>
                                        <span class="full-description display-none"><?php echo e($vehicle?->getRawOriginal('description')); ?></span>
                                        <a href="#" class="text--info font-medium see-more">See more</a>
                                    </div>
                                </div>

                                <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        if(count($vehicle['translations'])){
                                            $translate = [];
                                            foreach($vehicle['translations'] as $t)
                                            {
                                                if($t->locale == $lang && $t->key=="name"){
                                                    $translate[$lang]['name'] = $t->value;
                                                }
                                            }
                                        }
                                    ?>
                                    <div class="lang_form d-none text--title" id="<?php echo e($lang); ?>-form">
                                        <h3 class="text--title fs-20 ont-bold mb-10px"><?php echo e($translate[$lang]['name']??''); ?></h3>
                                        <h5 class="text--title font-semibold opacity-lg mb-10px">Description:</h5>
                                        <div class="fs-12 opacity-lg description-text">
                                            <span class="short-description"><?php echo e(Str::limit($translate[$lang]['description'] ?? '', 2100)); ?></span>
                                            <span class="full-description display-none"><?php echo e($translate[$lang]['description'] ?? ''); ?></span>
                                            <a href="#" class="text--info font-medium see-more">See more</a>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-20">
            <div class="col-lg-3 mb-20 mb-lg-0">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <a class="resturant--information-single" href="<?php echo e(url('vendor-panel/store/view')); ?>">
                            <img class="img--65 rounded mx-auto mb-3 onerror-image" data-onerror-image=""
                                 src="<?php echo e($vehicle?->provider['logoFullUrl']); ?>" alt="Image Description">
                            <div class="text-center text--title">
                                <h5 class="text-capitalize font-semibold text-hover-primary d-block mb-1">
                                    <?php echo e($vehicle?->provider?->name); ?>

                                </h5>
                                <span class="opacity-lg">
                                    <?php echo e($vehicle?->provider?->address); ?>

                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="card h-100">
                    <!-- Table -->
                    <div class="table-responsive">
                        <table id="" class="table table-borderless table-thead-bordered table-nowrap card-table">
                            <thead class="thead-light">
                            <tr>
                                <th class="border-0"><?php echo e(translate('messages.General_Info')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Fare_&_Discounts')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Other_Features')); ?></th>
                            </tr>
                            </thead>

                            <tbody id="set-rows">
                            <tr>
                                <td>
                                    <div>
                                        <div class="d-flex"> <span class="min-w-110px"><?php echo e(translate('Brand')); ?></span><span
                                                class="font-semibold">: <?php echo e($vehicle?->brand?->name); ?></span></div>
                                        <div class="d-flex"><span class="min-w-110px"><?php echo e(translate('Category')); ?></span><span
                                                class="font-semibold">: <?php echo e($vehicle?->category?->name); ?></span></div>
                                        <div class="d-flex"><span class="min-w-110px"><?php echo e(translate('Type')); ?></span><span
                                                class="font-semibold">: <?php echo e($vehicle?->type); ?></span></div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <?php if($vehicle->trip_hourly): ?>
                                            <div class="d-flex"> <span class="min-w-110px"><?php echo e(translate('Hourly')); ?></span>
                                                <span class="font-semibold">: <?php echo e(\App\CentralLogics\Helpers::format_currency($vehicle['hourly_price'])); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if($vehicle->trip_distance): ?>
                                            <div class="d-flex"><span class="min-w-110px"><?php echo e(translate('Distance Wise')); ?></span>
                                                <span class="font-semibold">:<?php echo e(\App\CentralLogics\Helpers::format_currency($vehicle['distance_price'])); ?></span>
                                            </div>
                                        <?php endif; ?>
                                         <?php if($vehicle->trip_day_wise): ?>
                                        <div class="d-flex"><span class="min-w-110px"><?php echo e(translate('Per Day')); ?></span>
                                            <span class="font-semibold">:<?php echo e(\App\CentralLogics\Helpers::format_currency($vehicle['day_wise_price'])); ?></span>
                                        </div>
                                        <?php endif; ?>
                                        <div class="d-flex"><span class="min-w-110px"><?php echo e(translate('Discount')); ?></span><span
                                                class="font-semibold">: <?php echo e($vehicle->discount_type == 'percent' ? $vehicle->discount_price.' %' : \App\CentralLogics\Helpers::format_currency($vehicle->discount_price)); ?></span></div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-between gap-20px">
                                        <div>
                                            <div class="d-flex"> <span class="min-w-110px"><?php echo e(translate('Air Condition')); ?></span><span
                                                    class="font-semibold">: <?php echo e($vehicle->air_condition ? 'Yes' : 'No'); ?></span></div>
                                            <div class="d-flex"><span class="min-w-110px"><?php echo e(translate('Transmission')); ?></span><span
                                                    class="font-semibold">:
                                                        <?php echo e(ucwords($vehicle->transmission_type)); ?></span></div>
                                            <div class="d-flex"><span class="min-w-110px"><?php echo e(translate('Fuel Type')); ?></span><span
                                                    class="font-semibold">: <?php echo e($vehicle->fuel_type); ?></span></div>
                                        </div>
                                        <div>
                                            <div class="d-flex"> <span class="min-w-110px"><?php echo e(translate('Engine Capacity')); ?></span><span
                                                    class="font-semibold">: <?php echo e($vehicle->engine_capacity); ?></span></div>
                                            <div class="d-flex"><span class="min-w-110px"><?php echo e(translate('Seating Capacity')); ?></span><span
                                                    class="font-semibold">:
                                                        <?php echo e($vehicle->seating_capacity); ?></span></div>
                                            <div class="d-flex"><span class="min-w-110px"><?php echo e(translate('Engine Power')); ?></span><span
                                                    class="font-semibold">: <?php echo e($vehicle->engine_power); ?></span></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                    <!-- End Table -->
                </div>
            </div>
        </div>

        <div class="card mb-20">
            <!-- Table -->
            <div class="table-responsive">
                <table id="" class="table table-borderless table-thead-bordered table-nowrap card-table">
                    <thead class="thead-light">
                    <tr>
                        <th class="border-0"><?php echo e(translate('messages.Identity_Info')); ?></th>
                    </tr>
                    </thead>

                    <tbody id="set-rows">
                    <tr>
                        <td>
                            <div class="row">
                                <?php $__currentLoopData = $vehicle->vehicleIdentities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $multi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-lg-4 col-md-6">
                                    <div class="font-semibold text--title">
                                        <div class="opacity-70 mb-2"><?php echo e(translate('Vehicle')); ?> <?php echo e($loop->iteration); ?></div>
                                        <div class="border rounded p-3 d-flex gap-4 justify-content-between">
                                            <div>
                                                <div class="fs-12 opacity-60"><?php echo e(translate('VIN Number')); ?></div>
                                                <div><?php echo e($multi->vin_number); ?></div>
                                            </div>
                                            <div class="pr-4">
                                                <div class="fs-12 opacity-60"><?php echo e(translate('Registration No.')); ?></div>
                                                <div><?php echo e($multi->license_plate_number); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
            <!-- End Table -->
        </div>
        <div class="card mb-20">
            <div class="card-header">
                <div>
                    <h5 class="text-title mb-1">
                        <?php echo e(translate('messages.Additional_Documents')); ?>

                    </h5>
                    <p class="fs-12">
                        <?php echo e(translate('messages.Here you can see all images & document for the provider')); ?>

                    </p>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex gap-3 flex-wrap">
                    <?php $__currentLoopData = $vehicle['documentsFullUrl']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="pdf-single" data-pdf-url="<?php echo e($doc); ?>">
                            <div class="pdf-frame">
                                <canvas class="pdf-preview display-none"></canvas>
                                <img class="pdf-thumbnail" src="<?php echo e($doc); ?>" alt="<?php echo e(translate('File Thumbnail')); ?>">
                            </div>
                            <div class="overlay">
                                <a href="javascript:void(0);" class="download-btn">
                                    <i class="tio-download-to"></i>
                                </a>
                                <div class="pdf-info d-flex gap-10px align-items-center">
                                    <img src="<?php echo e(asset('public/assets/admin/img/document.svg')); ?>" width="34" alt="<?php echo e(translate('Document Logo')); ?>">
                                    <div class="fs-13 text--title d-flex flex-column">
                                        <span class="file-name js-filename-truncate"></span>
                                        <span class="opacity-50"><?php echo e(translate('Click to view the file')); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <div class="card">
            <!-- Header -->
            <div class="card-header py-2">
                <div class="search--button-wrapper">
                    <h5 class="card-title text--title">
                        <?php echo e(translate('messages.Reviews')); ?>

                        <span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($vehicleReview->total()); ?></span>
                    </h5>
                    <!-- Unfold -->
                    <div class="hs-unfold mr-2">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle min-height-40 font-semibold"
                           href="javascript:;"
                           data-hs-unfold-options='{
                            "target": "#usersExportDropdown",
                            "type": "css-animation"
                        }'>
                            <i class="tio-download-to mr-1"></i> <?php echo e(translate('messages.export')); ?>

                        </a>

                        <div id="usersExportDropdown"
                             class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">

                            <span class="dropdown-header"><?php echo e(translate('messages.download_options')); ?></span>
                            <a id="export-excel" class="dropdown-item"
                               href="<?php echo e(route('vendor.vehicle.review.export', ['vehicle_id' => request()->id, 'type' => 'excel', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                     src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                     alt="<?php echo e(translate('Image Description')); ?>">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item"
                               href="<?php echo e(route('vendor.vehicle.review.export', ['vehicle_id' => request()->id, 'type' => 'csv', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                     src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                     alt="<?php echo e(translate('Image Description')); ?>">
                                .<?php echo e(translate('messages.csv')); ?>

                            </a>

                        </div>
                    </div>
                    <!-- End Unfold -->
                </div>
            </div>
            <!-- End Header -->
            <?php ($store_review_reply = App\Models\BusinessSetting::where('key' , 'store_review_reply')->first()->value ?? 0); ?>
            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table id="columnSearchDatatable"
                       class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                       data-hs-datatables-options='{
                            "order": [],
                            "orderCellsTop": true,
                            "paging": false
                        }'>
                    <thead class="thead-light">
                    <tr>
                        <th class="border-0"><?php echo e(translate('messages.#')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.Review_Id')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.Vehicle')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.reviewer')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.review')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.date')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.Reply_date')); ?></th>
                        <?php if($store_review_reply == '1'): ?>
                            <th class="text-center"><?php echo e(translate('messages.action')); ?></th>
                        <?php endif; ?>
                    </tr>
                    </thead>

                    <tbody>
                    <?php $__currentLoopData = $vehicleReview; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+$vehicleReview->firstItem()); ?></td>
                            <td><?php echo e($review->review_id); ?></td>
                            <td>
                                <?php if($review->vehicle): ?>
                                    <div class="position-relative media align-items-center">
                                        <a class=" text-hover-primary absolute--link" href="<?php echo e(route('vendor.vehicle.details',$review->vehicle_id)); ?>">
                                            <img class="avatar avatar-lg mr-3  onerror-image"  data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
                                                 src="<?php echo e($review->vehicle->thumbnail_full_url); ?>" alt="<?php echo e($review?->vehicle?->name); ?> <?php echo e(translate('image')); ?>">
                                        </a>
                                        <div class="media-body">
                                            <h5 class="text-hover-primary important--link mb-0"><?php echo e(Str::limit($review?->vehicle?->name,10)); ?></h5>
                                            <!-- Static -->
                                            <a href="<?php echo e(route('vendor.trip.details',$review->trip_id)); ?>"  class="fz--12 text-body important--link"><?php echo e(translate('Trip ID')); ?> #<?php echo e($review->trip_id); ?></a>
                                            <!-- Static -->
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <?php echo e(translate('messages.Food_deleted!')); ?>

                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($review->customer): ?>
                                    <div>
                                        <h5 class="d-block text-hover-primary mb-1"><?php echo e(Str::limit($review->customer['f_name']." ".$review->customer['l_name'])); ?> <i
                                                class="tio-verified text-primary" data-toggle="tooltip" data-placement="top"
                                                title="<?php echo e(translate('Verified Customer')); ?>"></i></h5>
                                        <span class="d-block font-size-sm text-body"><?php echo e(Str::limit($review->customer->phone)); ?></span>
                                    </div>
                                <?php else: ?>
                                    <?php echo e(translate('messages.customer_not_found')); ?>

                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="text-wrap w-18rem">
                                    <label class="rating">
                                        <i class="tio-star"></i>
                                        <span><?php echo e($review->rating); ?></span>
                                    </label>
                                    <p data-toggle="tooltip" data-placement="bottom"
                                       data-original-title="<?php echo e($review?->comment); ?>" >
                                        <?php echo e(Str::limit($review['comment'], 80)); ?>

                                    </p>
                                </div>
                            </td>
                            <td>
                                <span class="d-block">
                                    <?php echo e(\App\CentralLogics\Helpers::date_format($review->created_at)); ?>

                                </span>
                                <span class="d-block"> <?php echo e(\App\CentralLogics\Helpers::time_format($review->created_at)); ?></span>
                            </td>
                            <td>
                                <p class="text-wrap" data-toggle="tooltip" data-placement="top"
                                   data-original-title="<?php echo e($review?->reply); ?>"><?php echo $review->reply?Str::limit($review->reply, 50, '...'): translate('messages.Not_replied_Yet'); ?></p>
                            </td>
                            <?php if($store_review_reply == '1'): ?>
                                <td>
                                    <div class="btn--container justify-content-center">
                                        <a  class="btn btn-sm btn--primary <?php echo e($review->reply ? 'btn-outline-primary' : ''); ?>" data-toggle="modal" data-target="#reply-<?php echo e($review->id); ?>" title="<?php echo e(translate('View Details')); ?>">
                                            <?php echo e($review->reply ? translate('view_reply') : translate('give_reply')); ?>

                                        </a>
                                    </div>
                                </td>
                            <?php endif; ?>
                            <div class="modal fade" id="reply-<?php echo e($review->id); ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header pb-4">
                                            <button type="button" class="payment-modal-close btn-close border-0 outline-0 bg-transparent" data-dismiss="modal">
                                                <i class="tio-clear"></i>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="position-relative media align-items-center">
                                                <a class="absolute--link" href="<?php echo e(route('vendor.vehicle.details',$review->vehicle_id)); ?>">
                                                </a>
                                                <img class="avatar avatar-lg mr-3  onerror-image"  data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
                                                     src="<?php echo e($review?->vehicle?->thumbnail_full_url); ?>" alt="<?php echo e($review?->vehicle?->name); ?> <?php echo e(translate('image')); ?>">
                                                <div>
                                                    <h5 class="text-hover-primary mb-0"><?php echo e($review?->vehicle?->name); ?></h5>
                                                    <?php if($review?->vehicle?->avg_rating == 5): ?>
                                                        <div class="rating">
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                        </div>
                                                    <?php elseif($review?->vehicle?->avg_rating < 5 && $review?->vehicle?->avg_rating >= 4.5): ?>
                                                        <div class="rating">
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star-half"></i></span>
                                                        </div>
                                                    <?php elseif($review?->vehicle?->avg_rating < 4.5 && $review?->vehicle?->avg_rating >= 4): ?>
                                                        <div class="rating">
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                        </div>
                                                    <?php elseif($review?->vehicle?->avg_rating < 4 && $review?->vehicle?->avg_rating >= 3.5): ?>
                                                        <div class="rating">
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star-half"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                        </div>
                                                    <?php elseif($review?->vehicle?->avg_rating < 3.5 && $review?->vehicle?->avg_rating >= 3): ?>
                                                        <div class="rating">
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                        </div>
                                                    <?php elseif($review?->vehicle?->avg_rating < 3 && $review?->vehicle?->avg_rating >= 2.5): ?>
                                                        <div class="rating">
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star-half"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                        </div>
                                                    <?php elseif($review?->vehicle?->avg_rating < 2.5 && $review?->vehicle?->avg_rating > 2): ?>
                                                        <div class="rating">
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                        </div>
                                                    <?php elseif($review?->vehicle?->avg_rating < 2 && $review?->vehicle?->avg_rating >= 1.5): ?>
                                                        <div class="rating">
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star-half"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                        </div>
                                                    <?php elseif($review?->vehicle?->avg_rating < 1.5 && $review?->vehicle?->avg_rating > 1): ?>
                                                        <div class="rating">
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                        </div>
                                                    <?php elseif($review?->vehicle?->avg_rating < 1 && $review?->vehicle?->avg_rating > 0): ?>
                                                        <div class="rating">
                                                            <span><i class="tio-star-half"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                        </div>
                                                    <?php elseif($review?->vehicle?->avg_rating == 1): ?>
                                                        <div class="rating">
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                        </div>
                                                    <?php elseif($review?->vehicle?->avg_rating == 0): ?>
                                                        <div class="rating">
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <div class="mt-2">
                                                <?php if($review->customer): ?>
                                                    <div>
                                                        <h5 class="d-block text-hover-primary mb-1"><?php echo e(Str::limit($review?->customer?->fullName)); ?> <i
                                                                class="tio-verified text-primary" data-toggle="tooltip" data-placement="top"
                                                                title="<?php echo e(translate('Verified Customer')); ?>"></i></h5>
                                                        <span class="d-block font-size-sm text-body"><?php echo e($review->comment); ?></span>
                                                    </div>
                                                <?php else: ?>
                                                    <?php echo e(translate('messages.customer_not_found')); ?>

                                                <?php endif; ?>
                                            </div>
                                            <div class="mt-3">
                                                <form action="<?php echo e(route('vendor.rental.review.reply', $review->id)); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <textarea id="reply" name="reply" required class="form-control" cols="30" rows="3" placeholder="<?php echo e(translate('Write_your_reply_here')); ?>"><?php echo e($review->reply ?? ''); ?></textarea>
                                                    <div class="mt-3 btn--container justify-content-end">
                                                        <button class="btn btn-primary"><?php echo e($review->reply ? translate('update_reply') : translate('send_reply')); ?></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

            </div>
            <?php if(count($vehicleReview) !== 0): ?>
                <hr>
            <?php endif; ?>
            <div class="page-area mt-3">
                <?php echo $vehicleReview->appends($_GET)->links(); ?>

            </div>
            <?php if(count($vehicleReview) === 0): ?>
                <div class="empty--data">
                    <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                    <h5>
                        <?php echo e(translate('no_data_found')); ?>

                    </h5>
                </div>
            <?php endif; ?>
            <!-- End Table -->
        </div>
    </div>
    <!-- End Modal -->
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('/public/assets/admin/vendor/simplebar/dist/simplebar.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/public/assets/admin/vendor/drift-zoom/dist/Drift.min.js')); ?>"></script>
    <script src="<?php echo e(asset('Modules/Rental/public/assets/js/view-pages/provider/pdf.min.js')); ?>"></script>
    <script src="<?php echo e(asset('Modules/Rental/public/assets/js/view-pages/provider/vehicle-details.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/provider/vehicle/details.blade.php ENDPATH**/ ?>