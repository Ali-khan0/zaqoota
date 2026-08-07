<?php $__env->startSection('title',translate('messages.admin_landing_page')); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <div class="page-header pb-0">
        <div class="d-flex flex-wrap justify-content-between">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/landing.png')); ?>" class="w--20" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.admin_landing_pages')); ?>

                </span>
            </h1>
            <div class="text--primary-2 py-1 d-flex flex-wrap align-items-center" type="button" data-toggle="modal" data-target="#how-it-works">
                <strong class="mr-2"><?php echo e(translate('See_how_it_works!')); ?></strong>
                <div>
                    <i class="tio-info-outined"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-20 mt-2">
        <div class="js-nav-scroller hs-nav-scroller-horizontal">
            <?php echo $__env->make('admin-views.business-settings.landing-page-settings.top-menu-links.admin-landing-page-links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>

    <?php ($language=\App\Models\BusinessSetting::where('key','language')->first()); ?>
    <?php ($language = $language->value ?? null); ?>
    <?php ($defaultLang = str_replace('_', '-', app()->getLocale())); ?>
    <?php if($language): ?>
        <ul class="nav nav-tabs mb-4 border-0">
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
    <?php endif; ?>
    <div class="tab-content">
        <div class="tab-pane fade show active">
            <form action="<?php echo e(route('admin.business-settings.admin-landing-page-settings', 'promotional-section')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <?php if($language): ?>
                            <div class="row g-3 lang_form" id="default-form">
                                <div class="col-sm-6">
                                    <label for="title" class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span>
                                        <span class="form-label-secondary text-danger"
                                              data-toggle="tooltip" data-placement="right"
                                              data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                </span></label>
                                        <input id="title" required type="text"  maxlength="20" name="title[]" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                </div>
                                <div class="col-sm-6">
                                    <label for="sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?> (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span>
                                        <span class="form-label-secondary text-danger"
                                              data-toggle="tooltip" data-placement="right"
                                              data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                </span></label>
                                        <input id="sub_title" required type="text"  maxlength="80" name="sub_title[]" class="form-control" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                </div>
                            </div>
                            <input type="hidden" name="lang[]" value="default">
                                <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="row g-3 d-none lang_form" id="<?php echo e($lang); ?>-form">
                                        <div class="col-sm-6">
                                            <label for="title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                        <input id="title<?php echo e($lang); ?>" type="text"  maxlength="20" name="title[]" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="sub_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Sub Title')); ?> (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                        <input type="text"  id="sub_title<?php echo e($lang); ?>" maxlength="80" name="sub_title[]" class="form-control" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                        </div>
                                    </div>
                                    <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label  for="title" class="form-label"><?php echo e(translate('Title')); ?></label>
                                        <input id="title" type="text" name="title[]" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?></label>
                                        <input  id="sub_title" type="text" name="sub_title[]" class="form-control" placeholder="<?php echo e(translate('messages.sub_title_here...')); ?>">
                                    </div>
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                            <?php endif; ?>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label d-block mb-3">
                                    <?php echo e(translate('Banner')); ?>  <span class="text--primary"><?php echo e(translate('(size: 3:1)')); ?></span>
                                    <span class="form-label-secondary text-danger"
                                          data-toggle="tooltip" data-placement="right"
                                          data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                </span>
                                    <div class="fs-12 opacity-70">
                                        <?php echo e(translate(IMAGE_FORMAT.' ' . 'Less Than 2MB')); ?>

                                    </div>
                                </label>

                                <label class="upload-img-3 m-0 d-block">
                                    <div class="img">
                                        <img src="<?php echo e(asset('/public/assets/admin/img/upload-4.png')); ?>" data-onerror-image="<?php echo e(asset('/public/assets/admin/img/upload-4.png')); ?>" class="vertical-img mw-100 vertical onerror-image" alt="">
                                    </div>
                                        <input accept="<?php echo e(IMAGE_EXTENSION); ?>" class="upload-file__input single_file_input"  type="file" name="image" hidden>
                                </label>
                            </div>
                        </div>
                        <div class="btn--container justify-content-end mt-20">
                            <button type="reset" class="btn btn--reset mb-2"><?php echo e(translate('Reset')); ?></button>
                            <button type="submit" class="btn btn--primary mb-2"><?php echo e(translate('Add')); ?></button>
                        </div>
                    </div>
                </div>
            </form>
            <?php ($banners=\App\Models\AdminPromotionalBanner::all()); ?>
            <div class="card">
                <div class="card-header py-2">
                    <div class="search--button-wrapper">
                        <h5 class="card-title"><?php echo e(translate('Promotional_Banner_List')); ?>

                            
                        </h5>
                    </div>
                </div>
                <div class="card-body p-0">
                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table id="columnSearchDatatable"
                                class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                data-hs-datatables-options='{
                                    "order": [],
                                    "orderCellsTop": true,
                                    "paging":false

                                }'>
                            <thead class="thead-light">
                            <tr>
                                <th class="border-0"><?php echo e(translate('sl')); ?></th>
                                <th class="border-0"><?php echo e(translate('Title')); ?></th>
                                <th class="border-0"><?php echo e(translate('Sub Title')); ?></th>
                                <th class="border-0"><?php echo e(translate('Image')); ?></th>
                                <th class="border-0"><?php echo e(translate('Status')); ?></th>
                                <th class="text-center border-0"><?php echo e(translate('messages.action')); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key+1); ?></td>
                                    <td>
                                        <div class="text--title">
                                        <?php echo e($banner->title); ?>

                                        </div>
                                    </td>
                                    <td>
                                        <span class="d-block font-size-sm text-body">
                                            <?php echo e($banner->sub_title); ?>

                                         </span>
                                    </td>
                                    <td>
                                        <img
                                        src="<?php echo e($banner->image_full_url ?? asset('/public/assets/admin/img/upload-3.png')); ?>"
                                        data-onerror-image="<?php echo e(asset('/public/assets/admin/img/upload-3.png')); ?>" class="__size-105 onerror-image" alt="">
                                    </td>
                                    <td>
                                        <label class="toggle-switch toggle-switch-sm">
                                            <input type="checkbox"
                                                   data-id="status-<?php echo e($banner->id); ?>"
                                                   data-type="status"
                                                   data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/promotional-on.png')); ?>"
                                                   data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/promotional-off.png')); ?>"
                                                   data-title-on="<?php echo e(translate('By Turning ON Promotional Banner Section')); ?>"
                                                   data-title-off="<?php echo e(translate('By Turning OFF Promotional Banner Section')); ?>"
                                                   data-text-on="<p><?php echo e(translate('Promotional banner will be enabled. You will be able to see promotional activity')); ?></p>"
                                                   data-text-off="<p><?php echo e(translate('Promotional banner will be disabled. You will be unable to see promotional activity')); ?></p>"
                                                   class="status toggle-switch-input dynamic-checkbox"
                                                   id="status-<?php echo e($banner->id); ?>" <?php echo e($banner->status?'checked':''); ?>>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                        <form action="<?php echo e(route('admin.business-settings.promotional-status',[$banner->id,$banner->status?0:1])); ?>" method="get" id="status-<?php echo e($banner->id); ?>_form">
                                        </form>
                                    </td>

                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route('admin.business-settings.promotional-edit',[$banner['id']])); ?>">
                                                <i class="tio-edit"></i>
                                            </a>
                                            <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:"
                                               data-id="banner-<?php echo e($banner['id']); ?>"
                                               data-message="<?php echo e(translate('Want to delete this banner ?')); ?>"
                                               title="<?php echo e(translate('messages.delete_banner')); ?>"><i class="tio-delete-outlined"></i>
                                            </a>
                                            <form action="<?php echo e(route('admin.business-settings.promotional-delete',[$banner['id']])); ?>" method="post" id="banner-<?php echo e($banner['id']); ?>">
                                                <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                            </form>
                                        </div>
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
                    <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                    <h5>
                        <?php echo e(translate('no_data_found')); ?>

                    </h5>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
    <!-- How it Works -->
    <?php echo $__env->make('admin-views.business-settings.landing-page-settings.partial.how-it-work', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/landing-page-settings/admin-promotional-section.blade.php ENDPATH**/ ?>