<?php $__env->startSection('title',translate('messages.banner')); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <div class="page-header">
        <h1 class="page-header-title">
            <span class="page-header-icon">
                <img src="<?php echo e(asset('public/assets/admin/img/3rd-party.png')); ?>" class="w--26" alt="">
            </span>
            <span>
                <?php echo e(translate('messages.Other_Promotional_Content_Setup')); ?>

            </span>
        </h1>
    </div>
    <div class="mb-20 mt-2">
        <div class="js-nav-scroller hs-nav-scroller-horizontal">
            <?php echo $__env->make('admin-views.other-banners.partial.parcel-links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>
    <?php ($language=\App\Models\BusinessSetting::where('key','language')->first()); ?>
    <?php ($language = $language->value ?? null); ?>
    <?php ($defaultLang = str_replace('_', '-', app()->getLocale())); ?>
    <div class="tab-content">
        <div class="tab-pane fade show active">
            <div class="card mb-3">
                <div class="card-body">
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
                        <form action="<?php echo e(route('admin.promotional-banner.why-choose-store')); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="row g-3">
                                <?php if($language): ?>
                                <div class="col-6">
                                    <div class="row lang_form default-form">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                                            <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                                        </span></label>
                                                <input type="text"  maxlength="80" name="title[]" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label"><?php echo e(translate('messages.Short_Description')); ?> (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_short_description_within_100_characters')); ?>">
                                                            <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                                        </span></label>
                                                <textarea type="text"  maxlength="100" name="short_description[]" class="form-control" rows="3" <?php echo e(translate('messages.short_description_here...')); ?>> </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="lang[]" value="default">
                                    <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="row d-none lang_form" id="<?php echo e($lang); ?>-form1">

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                                    <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                                </span></label>
                                                <input type="text"  maxlength="80" name="title[]" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label"><?php echo e(translate('messages.Short_Description')); ?> (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_short_description_within_100_characters')); ?>">
                                                    <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                                </span></label>
                                                <textarea type="text"  maxlength="100" name="short_description[]" class="form-control" rows="3" <?php echo e(translate('messages.short_description_here...')); ?>> </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </div>

                                <?php else: ?>
                                <div class="col-sm-6">
                                    <label class="form-label"><?php echo e(translate('Title')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                    <input type="text"  maxlength="80" name="title[]" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                </div>
                                    <input type="hidden" name="lang[]" value="default">
                                <?php endif; ?>
                                <div class="col-sm-6">
                                    <div class="ml-5">
                                        <div>

                                            <label class="form-label"><?php echo e(translate('image (1:1)')); ?></label>
                                        </div>
                                        <label class="upload-img-3 m-0">
                                            <div class="img">
                                                <img src="<?php echo e(asset('/public/assets/admin/img/aspect-1.png')); ?>" alt="" class="img__aspect-1 min-w-187px max-w-187px">
                                            </div>
                                              <input type="file"  name="image" hidden>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="btn--container justify-content-end mt-20">
                                <button type="reset" class="btn btn--reset"><?php echo e(translate('Reset')); ?></button>
                                <button type="submit" class="btn btn--primary mb-2"><?php echo e(translate('Submit')); ?></button>
                            </div>
                        </form>
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
                                    <th class="border-0"><?php echo e(translate('messages.Short_Description')); ?></th>
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
                                            <div class="text--title" title="<?php echo e($banner->title); ?>">
                                                <?php echo e(strlen($banner->title) > 30 ? substr($banner->title, 0, 30).'...' : $banner->title); ?>

                                            </div>
                                        </td>
                                        <td>
                                            <div class="text--title" title="<?php echo e($banner->short_description); ?>">
                                                <?php echo e(strlen($banner->short_description) > 40 ? substr($banner->short_description, 0, 40).'...' : $banner->short_description); ?>

                                            </div>
                                        </td>
                                        <td>
                                            <img  src="<?php echo e($banner->image_full_url ?? asset('/public/assets/admin/img/upload-3.png')); ?>"
                                            data-onerror-image="<?php echo e(asset('/public/assets/admin/img/upload-3.png')); ?>" class="__size-105 onerror-image" alt="">
                                        </td>
                                        <td>
                                            <label class="toggle-switch toggle-switch-sm">
                                                <input type="checkbox" class="toggle-switch-input dynamic-checkbox"
                                                       data-id="status-<?php echo e($banner->id); ?>"
                                                       data-type="status"
                                                       data-image-on="<?php echo e(asset('/public/assets/admin/img/modal')); ?>/this-criteria-on.png"
                                                       data-image-off="<?php echo e(asset('/public/assets/admin/img/modal')); ?>/this-criteria-off.png"
                                                       data-title-on="<?php echo e(translate('messages.Want_to_enable')); ?> <strong><?php echo e(translate('this_feature?')); ?>"
                                                       data-title-off="<?php echo e(translate('messages.Want_to_disable')); ?> <strong><?php echo e(translate('this_feature?')); ?>"
                                                       data-text-on="<p><?php echo e(translate('If_yes,_it_will_be_available_on_this_module.')); ?></p>"
                                                       data-text-off="<p><?php echo e(translate('If_yes,_it_will_be_hidden_from_this_module.')); ?></p>"
                                                       id="status-<?php echo e($banner->id); ?>" <?php echo e($banner->status?'checked':''); ?>>
                                                <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                            <form action="<?php echo e(route('admin.promotional-banner.why-choose-status-update',[$banner->id,$banner->status?0:1])); ?>" method="get" id="status-<?php echo e($banner->id); ?>_form">
                                            </form>
                                        </td>

                                        <td>
                                            <div class="btn--container justify-content-center">
                                                <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route('admin.promotional-banner.why-choose-edit',[$banner['id']])); ?>">
                                                    <i class="tio-edit"></i>
                                                </a>
                                                <a class="btn action-btn btn--danger btn-outline-danger form-alert-title" href="javascript:"
                                                data-id="criteria-<?php echo e($banner['id']); ?>" data-title="<?php echo e(translate('Want_to_delete_this_feature_?')); ?>" data-message="<?php echo e(translate('If_yes,_It_will_be_removed_from_this_list_and_this_module.')); ?>" title="<?php echo e(translate('messages.delete_criteria')); ?>"><i class="tio-delete-outlined"></i>
                                                </a>
                                                <form action="<?php echo e(route('admin.promotional-banner.why-choose-delete',[$banner['id']])); ?>" method="post" id="criteria-<?php echo e($banner['id']); ?>">
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
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/other-banners.js"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/other-banners/parcel-why-choose.blade.php ENDPATH**/ ?>