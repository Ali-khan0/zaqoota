<?php $__env->startSection('title', translate('messages.banner')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/banner.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.Banners')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h5 class="text-title mb-1">
                                <?php echo e(translate('messages.Add_New_Banner')); ?>

                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" id="banner_form" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row g-3">
                                <div class="col-lg-6">
                                    <div class="__bg-FAFAFA p-4 radius-10 mb-4">
                                        <?php if($language): ?>
                                            <ul class="nav nav-tabs mb-3 border-0">
                                                <li class="nav-item">
                                                    <a class="nav-link lang_link active" href="#"
                                                        id="default-link"><?php echo e(translate('messages.default')); ?></a>
                                                </li>
                                                <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li class="nav-item">
                                                        <a class="nav-link lang_link" href="#"
                                                            id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                            <div class="lang_form" id="default-form">
                                                <div class="form-group mb-0">
                                                    <label class="input-label"
                                                        for="default_title"><?php echo e(translate('messages.title')); ?>

                                                        (<?php echo e(translate('Default')); ?>)
                                                    </label>
                                                    <input type="text" name="title[]" id="default_title"
                                                        class="form-control" value="<?php echo e(old('title.0')); ?>"
                                                        placeholder="<?php echo e(translate('messages.new_banner')); ?>" required>
                                                </div>
                                                <input type="hidden" name="lang[]" value="default">
                                            </div>
                                            <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="d-none lang_form" id="<?php echo e($lang); ?>-form">
                                                    <div class="form-group mb-0">
                                                        <label class="input-label"
                                                            for="<?php echo e($lang); ?>_title"><?php echo e(translate('messages.title')); ?>

                                                            (<?php echo e(strtoupper($lang)); ?>)
                                                        </label>
                                                        <input type="text" name="title[]" id="<?php echo e($lang); ?>_title"
                                                            class="form-control" value="<?php echo e(old('title.'.$key+1)); ?>"
                                                            placeholder="<?php echo e(translate('messages.new_banner')); ?>">
                                                    </div>
                                                    <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group mb-0 ">
                                        <label class="input-label"
                                            for="exampleFormControlInput1"><?php echo e(translate('messages.default_link')); ?>(<?php echo e(translate('messages.optional')); ?>)</label>
                                        <input type="url" name="default_link" class="form-control"
                                            placeholder="<?php echo e(translate('messages.default_link')); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="h-100 d-flex flex-column justify-content-between">
                                        <div class="form-group">
                                            <label
                                                class="fs-16 text-title font-semibold  mb-0"><?php echo e(translate('messages.Banner_Image')); ?></label>
                                            <p class="mb-20"><?php echo e(translate('JPG, JPEG, PNG Less Than 2MB')); ?> <span
                                                    class="font-weight-bold">(<?php echo e(translate('Ratio 3:1')); ?>)</span>
                                            </p>

                                            <div class="upload-file image-general">
                                                <a href="javascript:void(0);" class="remove-btn opacity-0 z-index-99">
                                                    <i class="tio-clear"></i>
                                                </a>
                                                <input type="file" name="image" class="upload-file__input single_file_input"
                                                    accept=".webp, .jpg, .jpeg, .png" required>
                                                <label class="upload-file-wrapper fullwidth">
                                                    <div class="upload-file-textbox text-center">
                                                        <img width="34" height="34"
                                                            src="<?php echo e(asset('public/assets/admin/img/document-upload.svg')); ?>"
                                                            alt="">
                                                        <h6 class="mt-2 font-semibold  text-center">
                                                            <span><?php echo e(translate('Click to upload')); ?></span>
                                                            <br>
                                                            <?php echo e(translate('or drag and drop')); ?>

                                                        </h6>
                                                    </div>
                                                    <img class="upload-file-img d-none" loading="lazy"
                                                        alt="">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="btn--container justify-content-end">
                                            <button type="reset" id="reset_btn"
                                                class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                                            <button type="submit"
                                                class="btn btn--primary"><?php echo e(translate('messages.submit')); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <div class="card">
                    <div class="card-header py-2">
                        <div class="search--button-wrapper gap-20px">
                            <h5 class="card-title text--title flex-grow-1"><?php echo e(translate('messages.Banner_List')); ?><span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($banners->count()); ?></span></h5>

                            <form class="search-form m-0 flex-grow-1 max-w-353px">
                                <!-- Search -->
                                <div class="input-group input--group">
                                    <input id="datatableSearch_" type="search" value="<?php echo e(request()?->search ?? null); ?>"
                                        name="search" class="form-control"
                                        placeholder="<?php echo e(translate('Search by banner title...')); ?>"
                                        aria-label="<?php echo e(translate('messages.Search by banner title...')); ?>">
                                    <button type="submit" class="btn btn--secondary bg--primary"><i
                                            class="tio-search"></i></button>

                                </div>
                                <!-- End Search -->
                            </form>
                            <?php if(request()->get('search')): ?>
                                <button type="reset" class="btn btn--primary ml-2 location-reload-to-base"
                                    data-url="<?php echo e(url()->full()); ?>"><?php echo e(translate('messages.reset')); ?></button>
                            <?php endif; ?>
                            <!-- Unfold -->
                            <div class="hs-unfold m-0">
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
                                        href="<?php echo e(route('vendor.rental_banner.export', ['type' => 'excel', request()->getQueryString()])); ?>">
                                        <img class="avatar avatar-xss avatar-4by3 mr-2"
                                            src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                            alt="Image Description">
                                        <?php echo e(translate('messages.excel')); ?>

                                    </a>
                                    <a id="export-csv" class="dropdown-item"
                                        href="<?php echo e(route('vendor.rental_banner.export', ['type' => 'csv', request()->getQueryString()])); ?>">
                                        <img class="avatar avatar-xss avatar-4by3 mr-2"
                                            src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                            alt="Image Description">
                                        .<?php echo e(translate('messages.csv')); ?>

                                    </a>

                                </div>
                            </div>
                            <!-- End Unfold -->
                        </div>
                    </div>
                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table id="columnSearchDatatable"
                            class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0"><?php echo e(translate('messages.SL')); ?></th>
                                    <th class="border-0"><?php echo e(translate('messages.Banner_Info')); ?></th>
                                    <th class="border-0"><?php echo e(translate('messages.banner_type')); ?></th>
                                    <th class="border-0 text-center"><?php echo e(translate('messages.featured')); ?> <span class="input-label-secondary"
                                        data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('if_you_turn/off_on_this_featured,_it_will_effect_on_website_&_user_app')); ?>"><img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                            alt="public/img"></span></th>
                                    <th class="border-0 text-center"><?php echo e(translate('messages.status')); ?></th>
                                    <th class="border-0 text-center"><?php echo e(translate('messages.action')); ?></th>
                                </tr>
                            </thead>

                            <tbody id="set-rows">
                                <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key+$banners->firstItem()); ?></td>
                                    <td>
                                        <span class="media align-items-center">
                                            <img class="img--ratio-3 w-auto h--50px rounded mr-2 onerror-image" src="<?php echo e($banner['image_full_url']); ?>"
                                                data-onerror-image="<?php echo e(asset('/public/assets/admin/img/900x400/img1.jpg')); ?>" alt="<?php echo e($banner->name); ?> image">
                                            <div class="media-body">
                                                <h5 title="<?php echo e($banner['title']); ?>" class="text-hover-primary mb-0"><?php echo e(Str::limit($banner['title'], 25, '...')); ?></h5>
                                            </div>
                                        </span>
                                    <span class="d-block font-size-sm text-body">

                                    </span>
                                    </td>
                                    <td><?php echo e($banner['type'] == 'store_wise' ?  translate('provider_wise') : translate($banner['type'])); ?></td>

                                    <td  >
                                        <div class="d-flex justify-content-center">
                                            <label class="toggle-switch toggle-switch-sm" for="featuredCheckbox<?php echo e($banner->id); ?>">
                                            <input type="checkbox"
                                            data-id="featuredCheckbox<?php echo e($banner->id); ?>"
                                            data-type="status"
                                            data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/basic_campaign_on.png')); ?>"
                                            data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/basic_campaign_off.png')); ?>"
                                            data-title-on="<?php echo e(translate('By_Turning_ON_As_Featured!')); ?>"
                                            data-title-off="<?php echo e(translate('By_Turning_OFF_As_Featured!')); ?>"
                                            data-text-on="<p><?php echo e(translate('If_you_turn_on_this_featured,_then_promotional_banner_will_show_on_website_and_user_app_with_store_or_item.')); ?></p>"
                                            data-text-off="<p><?php echo e(translate('If_you_turn_off_this_featured,_then_promotional_banner_won’t_show_on_website_and_user_app')); ?></p>"
                                            class="toggle-switch-input  dynamic-checkbox" id="featuredCheckbox<?php echo e($banner->id); ?>" <?php echo e($banner->featured?'checked':''); ?>>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                        </div>
                                    </td>
                                    <form action="<?php echo e(route('vendor.rental_banner.featured',[$banner['id'],$banner->featured?0:1])); ?>"
                                        method="get" id="featuredCheckbox<?php echo e($banner->id); ?>_form">
                                        </form>

                                    <td  >
                                        <div class="d-flex justify-content-center">
                                            <label class="toggle-switch toggle-switch-sm" for="statusCheckbox<?php echo e($banner->id); ?>">
                                            <input type="checkbox"
                                            data-id="statusCheckbox<?php echo e($banner->id); ?>"
                                            data-type="status"
                                            data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/basic_campaign_on.png')); ?>"
                                            data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/basic_campaign_off.png')); ?>"
                                            data-title-on="<?php echo e(translate('By_Turning_ON_Banner!')); ?>"
                                            data-title-off="<?php echo e(translate('By_Turning_OFF_Banner!')); ?>"
                                            data-text-on="<p><?php echo e(translate('If_you_turn_on_this_status,_it_will_show_on_user_website_and_app.')); ?></p>"
                                            data-text-off="<p><?php echo e(translate('If_you_turn_off_this_status,_it_won’t_show_on_user_website_and_app')); ?></p>"
                                            class="toggle-switch-input  dynamic-checkbox" id="statusCheckbox<?php echo e($banner->id); ?>" <?php echo e($banner->status?'checked':''); ?>>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                        </div>
                                    </td>

                                    <form action="<?php echo e(route('vendor.rental_banner.status',[$banner['id'],$banner->status?0:1])); ?>"
                                        method="get" id="statusCheckbox<?php echo e($banner->id); ?>_form">
                                        </form>
                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route('vendor.rental_banner.edit',[$banner['id']])); ?>" title="<?php echo e(translate('messages.edit_banner')); ?>"><i class="tio-edit"></i>
                                            </a>
                                            <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:" data-id="banner-<?php echo e($banner['id']); ?>" data-message="<?php echo e(translate('Want to delete this banner ?')); ?>"><i class="tio-delete-outlined"></i>
                                            </a>
                                            <form action="<?php echo e(route('vendor.rental_banner.delete',[$banner['id']])); ?>"
                                                        method="post" id="banner-<?php echo e($banner['id']); ?>">
                                                    <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                            </tbody>
                        </table>
                    </div>
                    <?php if(count($banners) !== 0): ?>
                    <hr>
                    <?php endif; ?>
                    <div class="page-area">
                        <?php echo $banners->links(); ?>

                    </div>
                    <?php if(count($banners) === 0): ?>
                    <div class="empty--data">
                        <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                        <h5>
                            <?php echo e(translate('no_data_found')); ?>

                        </h5>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <!-- End Table -->
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin/js/view-pages/banner-index.js')); ?>"></script>
    <script src="<?php echo e(asset('Modules/Rental/public/assets/js/view-pages/provider/banner-list.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/provider/banner/list.blade.php ENDPATH**/ ?>