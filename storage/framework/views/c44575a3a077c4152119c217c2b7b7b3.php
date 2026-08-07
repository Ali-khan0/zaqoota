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

    <?php ($testimonial_title=\App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key','testimonial_title')->first()); ?>
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
            <form action="<?php echo e(route('admin.business-settings.admin-landing-page-settings', 'testimonial-title')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <?php if($language): ?>
                            <div class="row g-3 lang_form" id="default-form">
                                <div class="col-sm-12">
                                    <label for="testimonial_title" class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(translate('messages.default')); ?>)<span
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
                                <input required id="testimonial_title" type="text" maxlength="40" name="testimonial_title[]" class="form-control" value="<?php echo e($testimonial_title?->getRawOriginal('value')); ?>" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                </div>
                            </div>
                            <input type="hidden" name="lang[]" value="default">
                                <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                if(isset($testimonial_title->translations)&&count($testimonial_title->translations)){
                                        $testimonial_title_translate = [];
                                        foreach($testimonial_title->translations as $t)
                                        {
                                            if($t->locale == $lang && $t->key=='testimonial_title'){
                                                $testimonial_title_translate[$lang]['value'] = $t->value;
                                            }
                                        }

                                    }
                                    ?>
                                    <div class="row g-3 d-none lang_form" id="<?php echo e($lang); ?>-form">
                                        <div class="col-sm-12">
                                            <label for="testimonial_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Title')); ?> (<?php echo e(strtoupper($lang)); ?>)<span
                                                class="form-label-secondary" data-toggle="tooltip"
                                                data-placement="right"
                                                data-original-title="<?php echo e(translate('Write_the_title_within_40_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                    alt="">
                                            </span></label>
                                        <input id="testimonial_title<?php echo e($lang); ?>" type="text" maxlength="40" name="testimonial_title[]" class="form-control" value="<?php echo e($testimonial_title_translate[$lang]['value']?? ''); ?>" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
                                        </div>
                                    </div>
                                    <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="row g-3">
                                    <div class="col-sm-12">
                                        <label for="testimonial_title" class="form-label"><?php echo e(translate('Title')); ?><span
                                            class="form-label-secondary" data-toggle="tooltip"
                                            data-placement="right"
                                            data-original-title="<?php echo e(translate('Write_the_title_within_40_characters')); ?>">
                                            <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                alt="">
                                        </span></label>
                                    <input type="text" id="testimonial_title" maxlength="40" name="testimonial_title[]" class="form-control" placeholder="<?php echo e(translate('messages.title_here...')); ?>">
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
            <form action="<?php echo e(route('admin.business-settings.admin-landing-page-settings', 'testimonial-list')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <h5 class="card-title mb-3 mt-3">
                    <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span> <span><?php echo e(translate('Testimonial List Section')); ?></span>
                </h5>
                <div class="card mb-3">
                    <div class="card-body">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label"><?php echo e(translate('Reviewer Name')); ?>

                                            <span class="form-label-secondary text-danger"
                                                  data-toggle="tooltip" data-placement="right"
                                                  data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                </span>
                                        </label>
                                        <input required id="name" type="text" name="name" class="form-control" placeholder="<?php echo e(translate('Ex:  John Doe')); ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="designation" class="form-label"><?php echo e(translate('Designation')); ?>

                                            <span class="form-label-secondary text-danger"
                                                  data-toggle="tooltip" data-placement="right"
                                                  data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                </span>
                                        </label>
                                        <input required id="designation" type="text" name="designation" class="form-control" placeholder="<?php echo e(translate('Ex:  CTO')); ?>">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="review" class="form-label"><?php echo e(translate('messages.review')); ?><span
                                            class="form-label-secondary" data-toggle="tooltip"
                                            data-placement="right"
                                            data-original-title="<?php echo e(translate('Write_the_title_within_250_characters')); ?>">
                                            <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                alt="">
                                        </span>
                                            <span class="form-label-secondary text-danger"
                                                  data-toggle="tooltip" data-placement="right"
                                                  data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                </span>
                                        </label>
                                        <textarea required id="review" name="review" maxlength="250" placeholder="<?php echo e(translate('Very Good Company')); ?>" class="form-control h92px"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex gap-40px">
                                    <div>
                                        <label class="form-label d-block mb-3">
                                            <?php echo e(translate('Reviewer Image')); ?>  <span class="text--primary"><?php echo e(translate('(1:1)')); ?></span>
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
                                                <img src="<?php echo e(asset("/public/assets/admin/img/aspect-1.png")); ?>"
                                                data-onerror-image="<?php echo e(asset("/public/assets/admin/img/aspect-1.png")); ?>" class="img__aspect-1 min-w-187px max-w-187px onerror-image" alt="">
                                            </div>
                                            <input accept="<?php echo e(IMAGE_EXTENSION); ?>" class="upload-file__input single_file_input" type="file"  name="reviewer_image" hidden="">
                                        </label>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <label class="form-label d-block mb-3">
                                            <?php echo e(translate('Company Logo')); ?>  <span class="text--primary">(3:1)</span>
                                            <span class="form-label-secondary text-danger"
                                                  data-toggle="tooltip" data-placement="right"
                                                  data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                </span>
                                            <div class="fs-12 opacity-70">
                                                <?php echo e(translate(IMAGE_FORMAT.' ' . 'Less Than 2MB')); ?>

                                            </div>
                                        </label>
                                        <label class="upload-img-4 m-0 d-block my-auto">
                                            <div class="img">
                                                <img src="<?php echo e(asset("/public/assets/admin/img/aspect-3-1.png")); ?>" data-onerror-image="<?php echo e(asset("/public/assets/admin/img/aspect-3-1.png")); ?>" class="vertical-img max-w-187px onerror-image" alt="">
                                            </div>
                                            <input accept="<?php echo e(IMAGE_EXTENSION); ?>" class="upload-file__input single_file_input" type="file" id="image-upload-2" name="company_image" hidden="">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn--container justify-content-end mt-20">
                            <button type="reset" class="btn btn--reset mb-2"><?php echo e(translate('Reset')); ?></button>
                            <button type="submit"   class="btn btn--primary mb-2"><?php echo e(translate('Add')); ?></button>
                        </div>

                    </div>
                    </div>
                </form>
                    <?php ($reviews=\App\Models\AdminTestimonial::all()); ?>
                    <div class="card-body p-0">
                        <!-- Table -->
                        <div class="table-responsive datatable-custom">
                            <table class="table table-borderless table-thead-bordered table-align-middle table-nowrap card-table m-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-top-0"><?php echo e(translate('SL')); ?></th>
                                        <th class="border-top-0"><?php echo e(translate('Reviewer Name')); ?></th>
                                        <th class="border-top-0"><?php echo e(translate('Designation')); ?></th>
                                        <th class="border-top-0"><?php echo e(translate('Reviews')); ?></th>
                                        <th class="text-center border-top-0"><?php echo e(translate('Reviewer Image')); ?></th>
                                        <th class="text-center border-top-0"><?php echo e(translate('Company Image')); ?></th>
                                        <th class="text-center border-top-0"><?php echo e(translate('Status')); ?></th>
                                        <th class="text-center border-top-0"><?php echo e(translate('Action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key+1); ?></td>
                                        <td>
                                            <div class="text--title">
                                            <?php echo e($review->name); ?>

                                            </div>
                                        </td>
                                        <td>
                                            <div class="text--title">
                                            <?php echo e($review->designation); ?>

                                            </div>
                                        </td>
                                        <td>
                                            <div class="word-break">
                                                <?php echo e($review->review); ?>

                                            </div>
                                        </td>
                                        <td>
                                            <img   src="<?php echo e($review?->reviewer_image_full_url ?? asset('/public/assets/admin/img/upload-3.png')); ?>"

                                            data-onerror-image="<?php echo e(asset('/public/assets/admin/img/upload-3.png')); ?>" class="__size-105 onerror-image" alt="">
                                        </td>
                                        <td>
                                            <img
                                            src="<?php echo e($review?->company_image_full_url ?? asset('/public/assets/admin/img/upload-3.png')); ?>"

                                            data-onerror-image="<?php echo e(asset('/public/assets/admin/img/upload-3.png')); ?>" class="__size-105 onerror-image" alt="">
                                        </td>
                                        <td>
                                            <label class="toggle-switch toggle-switch-sm">
                                                <input type="checkbox"
                                                       data-id="status-<?php echo e($review->id); ?>"
                                                       data-type="status"
                                                       data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/testimonial-on.png')); ?>"
                                                       data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/testimonial-off.png')); ?>"
                                                       data-title-on="<?php echo e(translate('By Turning ON ')); ?> <strong><?php echo e(translate('This review')); ?>"
                                                       data-title-off="<?php echo e(translate('By Turning OFF ')); ?> <strong><?php echo e(translate('This review')); ?>"
                                                       data-text-on="<p><?php echo e(translate('This section will be enabled. You can see this section on your landing page.')); ?></p>"
                                                       data-text-off="<p><?php echo e(translate('This section will be disabled. You can enable it in the settings.')); ?></p>"
                                                       class="status toggle-switch-input dynamic-checkbox"

                                                       id="status-<?php echo e($review->id); ?>" <?php echo e($review->status?'checked':''); ?>>
                                                <span class="toggle-switch-label">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                            </label>
                                            <form action="<?php echo e(route('admin.business-settings.review-status',[$review->id,$review->status?0:1])); ?>" method="get" id="status-<?php echo e($review->id); ?>_form">
                                            </form>
                                        </td>

                                        <td>
                                            <div class="btn--container justify-content-center">
                                                <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route('admin.business-settings.review-edit',[$review['id']])); ?>">
                                                    <i class="tio-edit"></i>
                                                </a>
                                                <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:"
                                                   data-id="review-<?php echo e($review['id']); ?>"
                                                   data-message="<?php echo e(translate('Want to delete this review ?')); ?>"><i class="tio-delete-outlined"></i>
                                                </a>
                                                <form action="<?php echo e(route('admin.business-settings.review-delete',[$review['id']])); ?>" method="post" id="review-<?php echo e($review['id']); ?>">
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
                    <?php if(count($reviews) === 0): ?>
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

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/landing-page-settings/admin-landing-testimonial.blade.php ENDPATH**/ ?>