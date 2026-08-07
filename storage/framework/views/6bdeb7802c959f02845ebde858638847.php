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
    <?php ($why_choose_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key','why_choose_title')->first()); ?>
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
            <form action="<?php echo e(route('admin.business-settings.admin-landing-page-settings', 'why-choose-title')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <?php if($language): ?>
                            <div class="row g-3 lang_form" id="default-form">
                                <div class="col-sm-12">
                                    <label for="why_choose_title" class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(translate('messages.default')); ?>)<span
                                                        class="form-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                            alt="">
                                                    </span><span class="form-label-secondary text-danger"
                                                                 data-toggle="tooltip" data-placement="right"
                                                                 data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                </span></label>
                                                <input required id="why_choose_title" type="text" maxlength="80" name="why_choose_title[]" class="form-control" value="<?php echo e($why_choose_title?->getRawOriginal('value')); ?>" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                </div>
                            </div>
                            <input type="hidden" name="lang[]" value="default">
                                <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                if(isset($why_choose_title->translations)&&count($why_choose_title->translations)){
                                        $why_choose_title_translate = [];
                                        foreach($why_choose_title->translations as $t)
                                        {
                                            if($t->locale == $lang && $t->key=='why_choose_title'){
                                                $why_choose_title_translate[$lang]['value'] = $t->value;
                                            }
                                        }

                                    }
                                    ?>
                                    <div class="row g-3 d-none lang_form" id="<?php echo e($lang); ?>-form">
                                        <div class="col-sm-12">
                                            <label for="why_choose_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(strtoupper($lang)); ?>)<span
                                                class="form-label-secondary" data-toggle="tooltip"
                                                data-placement="right"
                                                data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                    alt="">
                                            </span></label>
                                                <input id="why_choose_title<?php echo e($lang); ?>" type="text" maxlength="80" name="why_choose_title[]" class="form-control" value="<?php echo e($why_choose_title_translate[$lang]['value']?? ''); ?>" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                        </div>
                                    </div>
                                    <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="row g-3">
                                    <div class="col-sm-12">
                                        <label for="why_choose_title" class="form-label"><?php echo e(translate('Title')); ?><span
                                                        class="form-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                            alt="">
                                                    </span></label>
                                                <input id="why_choose_title" type="text" maxlength="80" name="why_choose_title[]" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                    </div>
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                            <?php endif; ?>
                        <div class="btn--container justify-content-end mt-20">
                            <button type="reset" class="btn btn--reset mb-2"><?php echo e(translate('Reset')); ?></button>
                            <button type="submit"   class="btn btn--primary mb-2"><?php echo e(translate('Save')); ?></button>
                        </div>
                    </div>
                </div>
            </form>
                <form action="<?php echo e(route('admin.business-settings.admin-landing-page-settings', 'special-criteria-list')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                <h5 class="card-title mb-3 mt-3">
                    <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span> <span><?php echo e(translate('Special Criteria List Section ')); ?></span>
                </h5>
                <div class="card mb-3">
                    <div class="card-body">

                            <div class="row g-3">
                                <?php if($language): ?>
                                <div class="col-sm-6 lang_form default-form">
                                    <label for="title" class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(translate('messages.default')); ?>)<span
                                                        class="form-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="<?php echo e(translate('Write_the_title_within_40_characters')); ?>">
                                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                            alt="">
                                                    </span>
                                        <span class="form-label-secondary text-danger"
                                              data-toggle="tooltip" data-placement="right"
                                              data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                </span></label>
                                                <input required id="title" type="text" maxlength="40" name="title[]" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                                    <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-sm-6 d-none lang_form" id="<?php echo e($lang); ?>-form1">
                                        <label for="title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(strtoupper($lang)); ?>)<span
                                                        class="form-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="<?php echo e(translate('Write_the_title_within_40_characters')); ?>">
                                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                            alt="">
                                                    </span></label>
                                                <input  id="title<?php echo e($lang); ?>" type="text" maxlength="40" name="title[]" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                    </div>
                                        <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                <div class="col-sm-6">
                                    <label for="title" class="form-label"><?php echo e(translate('Title')); ?><span
                                                        class="form-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="<?php echo e(translate('Write_the_title_within_40_characters')); ?>">
                                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                            alt="">
                                                    </span></label>
                                                <input id="title" type="text" maxlength="40" name="title[]" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                </div>
                                    <input type="hidden" name="lang[]" value="default">
                                <?php endif; ?>
                                <div class="col-sm-6">
                                    <div>

                                        <label class="form-label mb-3"><?php echo e(translate('Criteria Icon/ Image')); ?><span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate(IMAGE_FORMAT.' ' . 'Less Than 2MB')); ?>">
                                            <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                        </span>
                                            <span class="form-label-secondary text-danger"
                                                  data-toggle="tooltip" data-placement="right"
                                                  data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                </span><div class="fs-12 opacity-70">
                                                <?php echo e(translate(IMAGE_FORMAT.' ' . 'Less Than 2MB')); ?>

                                            </div></label>
                                    </div>
                                    <label class="upload-img-3 m-0">
                                        <div class="img">
                                            <img src="<?php echo e(asset('/public/assets/admin/img/aspect-1.png')); ?>" alt="" class="img__aspect-1 min-w-187px max-w-187px">
                                        </div>
                                          <input class="upload-file__input single_file_input" accept="<?php echo e(IMAGE_EXTENSION); ?>" type="file"  name="image" hidden>
                                    </label>
                                </div>
                            </div>
                            <div class="btn--container justify-content-end mt-20">
                                <button type="reset" class="btn btn--reset mb-2"><?php echo e(translate('Reset')); ?></button>
                                <button type="submit"   class="btn btn--primary mb-2"><?php echo e(translate('Add')); ?></button>
                            </div>
                        </div>
                        </div>
                    </form>
                    <?php ($criterias=\App\Models\AdminSpecialCriteria::all()); ?>
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
                                    <th class="border-0"><?php echo e(translate('Image')); ?></th>
                                    <th class="border-0"><?php echo e(translate('Status')); ?></th>
                                    <th class="text-center border-0"><?php echo e(translate('messages.action')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $criterias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$criteria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key+1); ?></td>
                                        <td>
                                            <div class="text--title">
                                            <?php echo e($criteria->title); ?>

                                            </div>
                                        </td>
                                        <td>
                                            <img  src="<?php echo e($criteria->image_full_url ?? asset('/public/assets/admin/img/upload-3.png')); ?>"
                                            data-onerror-image="<?php echo e(asset('/public/assets/admin/img/upload-3.png')); ?>" class="__size-105 onerror-image" alt="">
                                        </td>
                                        <td>
                                            <label class="toggle-switch toggle-switch-sm">
                                                <input type="checkbox"
                                                      id="status-<?php echo e($criteria->id); ?>"
                                                       data-id="status-<?php echo e($criteria->id); ?>"
                                                       data-type="status"
                                                       data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/this-criteria-on.png')); ?>"
                                                       data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/this-criteria-off.png')); ?>"
                                                       data-title-on="<?php echo e(translate('Want to enable this feature?')); ?>"
                                                       data-title-off="<?php echo e(translate('Want to disable this feature?')); ?>"
                                                       data-text-on="<p><?php echo e(translate('It will be available on the landing page.')); ?></p>"
                                                       data-text-off="<p><?php echo e(translate('It will be hidden from the landing page.')); ?></p>"
                                                       class="status toggle-switch-input dynamic-checkbox"

                                                    <?php echo e($criteria->status?'checked':''); ?>>
                                                <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                            <form action="<?php echo e(route('admin.business-settings.criteria-status',[$criteria->id,$criteria->status?0:1])); ?>" method="get" id="status-<?php echo e($criteria->id); ?>_form">
                                            </form>
                                        </td>

                                        <td>
                                            <div class="btn--container justify-content-center">
                                                <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route('admin.business-settings.criteria-edit',[$criteria['id']])); ?>">
                                                    <i class="tio-edit"></i>
                                                </a>
                                                <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:"
                                                   data-id="criteria-<?php echo e($criteria['id']); ?>"
                                                   data-message="<?php echo e(translate('Want to delete this criteria ?')); ?>"
                                                   title="<?php echo e(translate('messages.delete_criteria')); ?>"><i class="tio-delete-outlined"></i>
                                                </a>
                                                <form action="<?php echo e(route('admin.business-settings.criteria-delete',[$criteria['id']])); ?>" method="post" id="criteria-<?php echo e($criteria['id']); ?>">
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
                    <?php if(count($criterias) === 0): ?>
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

    <!-- How it Works -->
    <?php echo $__env->make('admin-views.business-settings.landing-page-settings.partial.how-it-work', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/landing-page-settings/admin-landing-why-choose.blade.php ENDPATH**/ ?>