<?php use App\Models\DataSetting;use App\Models\ReactPromotionalBanner; ?>


<?php $__env->startSection('title',translate('messages.react_landing_page')); ?>

<?php $__env->startSection('content'); ?>
    <?php ($banner=null); ?>
    <div class="content container-fluid">
        <div class="page-header pb-0">
            <div class="d-flex flex-wrap justify-content-between">
                <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/landing.png')); ?>" class="w--20" alt="">
                </span>
                    <span>
                    <?php echo e(translate('messages.react_landing_page')); ?>

                </span>
                </h1>
                <div class="text--primary-2 py-1 d-flex flex-wrap align-items-center" type="button" data-toggle="modal"
                     data-target="#how-it-works">
                    <strong class="mr-2"><?php echo e(translate('See_how_it_works!')); ?></strong>
                    <div>
                        <i class="tio-info-outined"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-20 mt-2">
            <div class="js-nav-scroller hs-nav-scroller-horizontal">
                <?php echo $__env->make('admin-views.business-settings.landing-page-settings.top-menu-links.react-landing-page-links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
        <div class="card py-3 px-xxl-4 px-3 mb-20">
            <div class="d-flex flex-sm-nowrap flex-wrap gap-3 align-items-center justify-content-between">
                <div class="">
                    <h3 class="mb-1"><?php echo e(translate('Promotional Banners Section')); ?></h3>
                    <p class="mb-0 gray-dark fs-12">
                        <?php echo e(translate('See how your Promotional Banners  Section will look to customers.')); ?>

                    </p>
                </div>
                <div class="max-w-300px ml-sm-auto">
                    <button type="button" class="btn btn-outline-primary py-2 fs-12 px-3 offcanvas-trigger"
                            data-target="#promotional-banner_section">
                        <i class="tio-invisible"></i> <?php echo e(translate('Section Preview')); ?>

                    </button>
                </div>
            </div>
        </div>
        <?php ($promotional_banner_section_status = \App\Models\DataSetting::where('type', 'react_landing_page')->where('key', "promotional_banner_section_status")->first()); ?>
        <div class="card py-3 px-xxl-4 px-3 mb-15 mt-4">
            <div class="row g-3 align-items-center justify-content-between">
                <div class="col-xxl-9 col-lg-8 col-md-7 col-sm-6">
                    <div class="">
                        <h3 class="mb-1"><?php echo e(translate('Show Promotional Banner Section')); ?></h3>
                        <p class="mb-0 gray-dark fs-12">
                            <?php echo e(translate('If you turn of the availability status, this section will not show in the website')); ?>

                        </p>
                    </div>
                </div>
                <div class="col-xxl-3 col-lg-4 col-md-5 col-sm-6">
                    <div class="py-2 px-3 rounded d-flex justify-content-between border align-items-center w-300">
                        <h5 class="text-capitalize fw-normal mb-0"><?php echo e(translate('Status')); ?></h5>

                        <form
                            action="<?php echo e(route('admin.business-settings.statusUpdate', ['type' => 'react_landing_page', 'key' => 'promotional_banner_section_status'])); ?>"
                            method="get" id="CheckboxStatus_form">
                        </form>
                        <label class="toggle-switch toggle-switch-sm" for="CheckboxStatus">
                            <input type="checkbox" data-id="CheckboxStatus" data-type="status"
                                   data-image-on="<?php echo e(asset('/public/assets/admin/img/status-ons.png')); ?>"
                                   data-image-off="<?php echo e(asset('/public/assets/admin/img/off-danger.png')); ?>"
                                   data-title-on="<?php echo e(translate('Do you want turn on this section ?')); ?>"
                                   data-title-off="<?php echo e(translate('Do you want to turn off this section ?')); ?>"
                                   data-text-on="<p><?php echo e(translate('If you turn on this section will be show in react landing page.')); ?>"
                                   data-text-off="<p><?php echo e(translate('If you turn off this section will not be show in react landing page.')); ?></p>"
                                   class="toggle-switch-input  status dynamic-checkbox" id="CheckboxStatus"
                                <?php echo e($promotional_banner_section_status?->value ? 'checked' : ''); ?>>
                            <span class="toggle-switch-label text">
                                <span class="toggle-switch-indicator"></span>
                            </span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-content">
            <div class="tab-pane fade show active">
                <!-- <h5 class="card-title mb-3 mt-3">
                    <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span> <span><?php echo e(translate('Banner Section')); ?></span>
                </h5> -->
                <div class="card mb-20">
                    <div class="card-header">
                        <div class="">
                            <h3 class="mb-1"><?php echo e(translate('Add Promotional Banner')); ?></h3>
                            <p class="mb-0 gray-dark fs-12">
                                <?php echo e(translate('Upload and manage promotional images or food category banners.')); ?>

                            </p>
                        </div>
                    </div>
                    <div class="card-body">
                        <form class="custom-validation"
                              action="<?php echo e(route('admin.business-settings.promotional-banner-store')); ?>"
                              method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="card p-xxl-4 p-1">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <!-- <div>
                                        <label class="form-label d-block mb-3">
                                            <?php echo e(translate('Banner')); ?>  <span class="text--primary"><?php echo e(translate('(size: 2:1)')); ?></span><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('If_you_want_to_upload_one_banner_then_you_have_to_upload_it_in_2:1_ratio_otherwise_the_ratio_will_be_same_as_before.')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span>
                                        </label>

                                        <label class="upload-img-3 d-block max-w-640">
                                            <div class="img">
                                                <img src="<?php echo e(asset("/public/assets/admin/img/upload-4.png")); ?>" data-onerror-image="<?php echo e(asset("/public/assets/admin/img/upload-4.png")); ?>" class="vertical-img w-100 mw-100 onerror-image" alt="">
                                            </div>
                                            <input type="file"  name="image" hidden="">
                                        </label>
                                    </div> -->
                                        <div class="bg--secondary h-100 rounded p-md-4 p-3">
                                            <div class="text-center py-2">
                                                <div class="mb-4">
                                                    <h5 class="mb-1"><?php echo e(translate('Upload Promotional Image')); ?></h5>
                                                    <p class="mb-0 fs-12 gray-dark"><?php echo e(translate('Upload your Promotional Image')); ?></p>
                                                </div>
                                                <div class="mx-auto text-center error-wrapper">
                                                    <div class="upload-file_custom">
                                                        <input type="file" name="image"
                                                               class="upload-file__input single_file_input"
                                                               accept=".webp, .jpg, .jpeg, .png, .gif" required>
                                                        <label class="upload-file__wrapper ratio-3-1 m-0">
                                                            <div class="upload-file-textbox text-center">
                                                                <img width="22" class="svg"
                                                                     src="<?php echo e(asset('public/assets/admin/img/document-upload.svg')); ?>"
                                                                     alt="img">
                                                                <h6 class="mt-1 color-656566 fw-medium fs-10 lh-base text-center">
                                                                    <span class="theme-clr">Click to upload</span>
                                                                    <br>
                                                                    Or drag and drop
                                                                </h6>
                                                            </div>
                                                            <img class="upload-file-img" loading="lazy" src=""
                                                                 data-default-src="" alt="" style="display: none;">
                                                        </label>
                                                        <div class="overlay">
                                                            <div
                                                                class="d-flex gap-1 justify-content-center align-items-center h-100">
                                                                <button type="button"
                                                                        class="btn btn-outline-info icon-btn view_btn">
                                                                    <i class="tio-invisible"></i>
                                                                </button>
                                                                <button type="button"
                                                                        class="btn btn-outline-info icon-btn edit_btn">
                                                                    <i class="tio-edit"></i>
                                                                </button>
                                                                <button type="button" class="remove_btn btn icon-btn">
                                                                    <i class="tio-delete text-danger"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="fs-10 text-center mb-0 mt-lg-4 mt-3">
                                                    <?php echo e(translate('JPG, JPEG, PNG, Gif Image size : Max 2 MB')); ?> <span
                                                        class="font-medium text-title"><?php echo e(translate('(3:1)')); ?></span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="btn--container justify-content-end mt-20">
                                    <button type="reset" class="btn btn--reset mb-2"><?php echo e(translate('Reset')); ?></button>
                                    <button type="submit" class="btn btn--primary mb-2"><?php echo e(translate('Add')); ?></button>
                                </div>
                            </div>
                        </form>

                        <div class="card mt-20">
                            <?php ($banners = \App\Models\ReactPromotionalBanner::get()); ?>
                            <div class="card-header py-2 border-0">
                                <div
                                    class="d-flex w-100 flex-wrap gap-2 align-items-center justify-content-between">
                                    <h4 class="text-black m-0">Promotional Banner List</h4>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <!-- Table -->
                                <div class="table-responsive datatable-custom">
                                    <table
                                        class="table table-borderless table-thead-borderless table-align-middle table-nowrap card-table m-0">
                                        <thead class="thead-light">
                                        <tr>
                                            <th class="border-top-0"><?php echo e(translate('SL')); ?></th>
                                            <th class="border-top-0"><?php echo e(translate('banner Image')); ?></th>
                                            <th class="border-top-0 text-center"><?php echo e(translate('Status')); ?></th>
                                            <th class="text-center border-top-0"><?php echo e(translate('Action')); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($key+1); ?></td>
                                                <td>
                                                    <img
                                                        src="<?php echo e(\App\CentralLogics\Helpers::get_full_url('promotional_banner',$banner->image ?? '','public')); ?>"
                                                        data-onerror-image="<?php echo e(asset('/public/assets/admin/img/upload-3.png')); ?>"
                                                        class="w-135px min-w-50px h-50px rounded mw-100 onerror-image"
                                                        alt="">
                                                </td>
                                                <td>
                                                    <label class="toggle-switch mx-auto toggle-switch-sm">
                                                        <input type="checkbox"
                                                               data-id="react_promotional_banner_status_<?php echo e($banner->id); ?>"
                                                               data-type="status"
                                                               data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/testimonial-on.png')); ?>"
                                                               data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/testimonial-off.png')); ?>"
                                                               data-title-on="<?php echo e(translate('Want_to_Enable_this')); ?> <strong><?php echo e(translate('Promotional_Banner')); ?></strong>"
                                                               data-title-off="<?php echo e(translate('Want_to_Disable_this')); ?> <strong><?php echo e(translate('Promotional_Banner')); ?></strong>"
                                                               data-text-on="<p><?php echo e(translate('If_enabled,_it_will_be_available_on_the_React_Landing_page')); ?></p>"
                                                               data-text-off="<p><?php echo e(translate('If_disabled,_it_will_be_hidden_from_the_React_Landing_page')); ?></p>"
                                                               class="status toggle-switch-input dynamic-checkbox"
                                                               id="react_promotional_banner_status_<?php echo e($banner->id); ?>" <?php echo e($banner->status?'checked':''); ?>>
                                                        <span class="toggle-switch-label mx-auto">
                                                            <span class="toggle-switch-indicator"></span>
                                                            </span>
                                                    </label>
                                                    <form
                                                        action="<?php echo e(route('admin.business-settings.promotional-banner-status',[$banner->id,$banner->status?0:1])); ?>"
                                                        method="get"
                                                        id="react_promotional_banner_status_<?php echo e($banner->id); ?>_form">
                                                    </form>
                                                </td>
                                                <td>
                                                    <div class="btn--container justify-content-center">
                                                        <a class="btn action-btn btn-outline-theme-light editBannerBtn"
                                                           data-toggle="modal"
                                                           data-target="#updateBanner"
                                                           data-id="<?php echo e($banner->id); ?>"
                                                           data-image="<?php echo e($banner->image_full_url); ?>"
                                                           data-action="<?php echo e(route('admin.business-settings.promotional-banner-update',[$banner->id])); ?>"
                                                           href="#0">
                                                            <i class="tio-edit"></i>
                                                        </a>
                                                        <a class="btn action-btn btn--danger btn-outline-danger form-alert"
                                                           href="javascript:"
                                                           data-id="react_promotional_banner-<?php echo e($banner['id']); ?>"
                                                           data-message="<?php echo e(translate('Want_to_Delete_this_Promotional_Banner')); ?>"
                                                           data-message-2="<?php echo e(translate('If_yes,_the_banner_will_be_removed_from_this_list')); ?>"
                                                           title="<?php echo e(translate('messages.delete_react_promotional_banner')); ?>"><i
                                                                class="tio-delete-outlined"></i>
                                                        </a>
                                                    </div>
                                                    <form
                                                        action="<?php echo e(route('admin.business-settings.promotional-banner-delete',[$banner['id']])); ?>"
                                                        method="post"
                                                        id="react_promotional_banner-<?php echo e($banner['id']); ?>">
                                                        <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>

                                </div>
                                <!-- End Table -->
                            </div>
                            <?php if(count($banners) === 0): ?>
                                <div class="empty--data">
                                    <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>"
                                         alt="public">
                                    <h5>
                                        <?php echo e(translate('no_data_found')); ?>

                                    </h5>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Section View Offcanvas here -->
        <div id="promotional-banner_section"
             class="custom-offcanvas offcanvas-750 d-flex flex-column justify-content-between">
            <form action="<?php echo e(route('taxvat.store')); ?>" method="post">
                <div>
                    <div
                        class="custom-offcanvas-header bg--secondary d-flex justify-content-between align-items-center px-3 py-3">
                        <div class="py-1">
                            <h3 class="mb-0 line--limit-1"><?php echo e(translate('messages.Promotional Banners Section Preview')); ?></h3>
                        </div>
                        <button type="button"
                                class="btn-close w-25px h-25px border rounded-circle d-center bg--secondary text-dark offcanvas-close fz-15px p-0"
                                aria-label="Close">
                            &times;
                        </button>
                    </div>
                    <div class="custom-offcanvas-body custom-offcanvas-body-100  p-20">
                        <section class="common-section-view bg-white border rounded-10">
                            <div class="container p-0">
                                <div class="row g-3">
                                    <?php $__currentLoopData = $banners->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-lg-6">
                                            <div class="promotional-banner-thumb broder w-100 h-100 rounded-20">
                                                <img
                                                    src="<?php echo e($banner->image_full_url); ?>"
                                                    alt="" class="rounded-20 border initial--28">
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </form>
        </div>
        <div id="offcanvasOverlay" class="offcanvas-overlay"></div>
        <!-- Section View Offcanvas end -->
        <!-- Modal -->
        <div class="modal fade" id="updateBanner" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header pt-2 px-2">
                        <button type="button" class="close fs-24" data-dismiss="modal" aria-label="Close">
                            <i class="tio-clear fs-24"></i>
                        </button>
                    </div>
                    <div class="modal-body p-xl-4 p-2">
                        <div class="card-body p-0">
                            <div class="mb-xxl-4 mb-xl-4 mb-3 text-center">
                                <h5 class="mb-0"><?php echo e(translate('Update Banner Image')); ?></h5>
                            </div>
                            <form class="custom-validation" method="post" action="" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="card-custom-static p-md-4 p-3">
                                    <div
                                        class="bg-light2 p-20 max-w-555px rounded mx-auto d-flex align-items-center justify-content-center">
                                        <div class="error-wrapper">
                                            <div class="upload-file_custom">
                                                <input type="file" name="image"
                                                       class="upload-file__input single_file_input"
                                                       accept=".webp, .jpg, .jpeg, .png, .gif" <?php echo e($banner?->image ? '':'required'); ?>>
                                                <label class="upload-file__wrapper ratio-3-1 m-0">
                                                    <div class="upload-file-textbox text-center">
                                                        <img width="22" class="svg"
                                                             src="<?php echo e(asset('public/assets/admin/img/document-upload.svg')); ?>"
                                                             alt="img">
                                                        <h6 class="mt-1 color-656566 fw-medium fs-10 lh-base text-center">
                                                            <span class="theme-clr">Click to upload</span>
                                                            <br>
                                                            Or drag and drop
                                                        </h6>
                                                    </div>
                                                    <img class="upload-file-img" loading="lazy"
                                                         src="<?php echo e($banner->image_full_url ?? ''); ?>"
                                                         data-default-src="<?php echo e($banner->image_full_url ?? ''); ?>" alt=""
                                                         style="display: none;">
                                                </label>
                                                <div class="overlay">
                                                    <div
                                                        class="d-flex gap-1 justify-content-center align-items-center h-100">
                                                        <button type="button"
                                                                class="btn btn-outline-info icon-btn view_btn">
                                                            <i class="tio-invisible"></i>
                                                        </button>
                                                        <button type="button"
                                                                class="btn btn-outline-info icon-btn edit_btn">
                                                            <i class="tio-edit"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="fs-10 text-center mb-0 mt-lg-4 mt-3">
                                                <?php echo e(translate('JPG, JPEG, PNG, Gif Image Less Than 2MB')); ?> <span
                                                    class="font-medium text-title"><?php echo e(translate('(3:1)')); ?></span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="btn--container justify-content-end mt-4">
                                        <button type="reset" class="btn btn--reset"><?php echo e(translate('Reset')); ?></button>
                                        <button type="submit" class="btn btn--primary"><?php echo e(translate('Update')); ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- How it Works -->
        <?php echo $__env->make('admin-views.business-settings.landing-page-settings.partial.how-it-work-react', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php $__env->stopSection(); ?>

        <?php $__env->startPush('script_2'); ?>
            <script>
                $(document).on('click', '.editBannerBtn', function () {
                    let imageUrl = $(this).data('image');
                    let bannerId = $(this).data('id');
                    let action = $(this).data('action');

                    let $modal = $('#updateBanner');
                    let $img = $modal.find('.upload-file-img');

                    if (imageUrl) {
                        $img.attr('src', imageUrl).show();
                        $modal.find('.upload-file-textbox').hide();
                    } else {
                        $img.hide();
                        $modal.find('.upload-file-textbox').show();
                    }

                    $modal.find('form').attr('action', action);
                });
            </script>
    <?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/landing-page-settings/react-landing-promotion-banners.blade.php ENDPATH**/ ?>