<?php $__env->startSection('title',translate('messages.banner')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/fi_9752284.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.Banner_Setup')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <form action="<?php echo e(route('vendor.banner.store')); ?>" method="POST" enctype="multipart/form-data" class="custom-validation">
                    <?php echo csrf_field(); ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12 d-flex justify-content-end">

                                    <div class="blinkings">
                                        <strong class="mr-2"><?php echo e(translate('instructions')); ?></strong>
                                        <div>
                                            <i class="tio-info-outined"></i>
                                        </div>
                                        <div class="business-notes">
                                            <h6><img src="<?php echo e(asset('/public/assets/admin/img/notes.png')); ?>" alt=""> <?php echo e(translate('Note')); ?></h6>
                                            <div>
                                                <?php echo e(translate('messages.Customer_will_see_there_banners_in_your_store_details_page_in_website_and_user_apps.')); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group error-wrapper">

                                        <label for="title" class="form-label"><?php echo e(translate('Banner_title')); ?></label>
                                        <input id="title" type="text" name="title" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>" required>
                                    </div>
                                    <div class="form-group error-wrapper">

                                        <label for="default_link" class="form-label"><?php echo e(translate('Redirection_URL_/_Link')); ?></label>
                                        <input id="default_link" type="url" name="default_link" class="form-control" placeholder="<?php echo e(translate('messages.Enter_URL')); ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                        <h3 class="form-label d-block mb-2">
                                                <?php echo e(translate('Upload_Banner')); ?>

                                            </h3>
                                    <label class="upload-img-3 m-0 d-block error-wrapper">
                                        <div class="img">
                                            <img src="<?php echo e(asset('/public/assets/admin/img/upload-4.png')); ?>" id="viewer"  class="vertical-img mw-100 vertical" alt="">
                                        </div>
                                            <input type="file" name="image"  hidden required>
                                    </label>
                                    <h3 class="form-label d-block mt-2">
                                        <?php echo e(translate('Banner_Image_Ratio_3:1')); ?>

                                    </h3>
                                    <p><?php echo e(translate('image_format_:_jpg_,_png_,_jpeg_|_maximum_size:_2_MB')); ?></p>
                                </div>
                                <div class="col-sm-6">
                                </div>
                            </div>
                            <div class="btn--container justify-content-end mt-20">
                                <button type="reset" id="reset_btn" class="btn btn--reset"><?php echo e(translate('Reset')); ?></button>
                                <button type="submit" class="btn btn--primary"><?php echo e(translate('Submit')); ?></button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <div class="card">
                    <div class="card-header py-2 border-0">
                        <div class="search--button-wrapper">
                            <h5 class="card-title">
                                <?php echo e(translate('messages.banner_list')); ?><span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($banners->count()); ?></span>
                            </h5>
                            <form id="search-form" class="search-form">
                                <!-- Search -->
                                <div class="input-group input--group">
                                    <input id="datatableSearch" type="search" name="search" class="form-control" placeholder="<?php echo e(translate('messages.search_by_title')); ?>" aria-label="<?php echo e(translate('messages.search_here')); ?>" value="<?php echo e(request()->search); ?>">
                                    <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                                </div>
                                <!-- End Search -->
                            </form>
                        </div>
                    </div>
                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table id="columnSearchDatatable"
                               class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                               data-hs-datatables-options='{
                                "order": [],
                                "orderCellsTop": true,
                                "search": "#datatableSearch",
                                "entries": "#datatableEntries",
                                "isResponsive": false,
                                "isShowPaging": false,
                                "paging": false
                               }'
                               >
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0"><?php echo e(translate('messages.SL')); ?></th>
                                    <th class="border-0"><?php echo e(translate('messages.title')); ?></th>
                                    <th class="border-0"><?php echo e(translate('messages.banner_Image')); ?></th>
                                    <th class="border-0"><?php echo e(translate('messages.redirection_Link')); ?></th>
                                    <th class="border-0 text-center"><?php echo e(translate('messages.status')); ?></th>
                                    <th class="border-0 text-center"><?php echo e(translate('messages.action')); ?></th>
                                </tr>
                            </thead>

                            <tbody id="set-rows">
                            <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key+$banners->firstItem()); ?></td>
                                    <td><h5 class="text-hover-primary mb-0"><?php echo e(Str::limit($banner['title'], 25, '...')); ?></h5></td>
                                    <td>
                                        <span class="media align-items-center">
                                            <img class="img--ratio-3 w-auto h--50px rounded mr-2 onerror-image" src="<?php echo e($banner['image_full_url']); ?>"
                                                 data-onerror-image="<?php echo e(asset('/public/assets/admin/img/900x400/img1.jpg')); ?>"
                                                  alt="<?php echo e($banner->name); ?> image">
                                        </span>
                                    </td>
                                    <td><a href="<?php echo e($banner->default_link); ?>"> <?php echo e(Str::limit($banner['default_link'], 60, '...')); ?></a></td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <label class="toggle-switch toggle-switch-sm" for="statusCheckbox<?php echo e($banner->id); ?>">
                                            <input type="checkbox"
                                                   data-url="<?php echo e(route('vendor.banner.status_update',[$banner['id'],$banner->status?0:1])); ?>"
                                                   class="toggle-switch-input redirect-url" id="statusCheckbox<?php echo e($banner->id); ?>" <?php echo e($banner->status?'checked':''); ?>>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route('vendor.banner.edit',[$banner['id']])); ?>" title="<?php echo e(translate('messages.edit_banner')); ?>"><i class="tio-edit"></i>
                                            </a>
                                            <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:"
                                               data-id="banner-<?php echo e($banner['id']); ?>"
                                               data-message="<?php echo e(translate('Want to delete this banner ?')); ?>"
                                                title="<?php echo e(translate('messages.delete_banner')); ?>"><i class="tio-delete-outlined"></i>
                                            </a>
                                            <form action="<?php echo e(route('vendor.banner.delete',[$banner['id']])); ?>"
                                                        method="post" id="banner-<?php echo e($banner['id']); ?>">
                                                    <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

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
            </div>
            <!-- End Table -->
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
        <script>
            "use strict";
            $('#reset_btn').click(function(){
                $('#viewer').attr('src','<?php echo e(asset('/public/assets/admin/img/upload-4.png')); ?>');
            })
        </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/vendor-views/banner/index.blade.php ENDPATH**/ ?>