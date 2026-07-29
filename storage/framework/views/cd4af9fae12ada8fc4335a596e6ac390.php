<?php $__env->startSection('title', translate('messages.admin_landing_page')); ?>

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
                <div class="text--primary-2 py-1 d-flex flex-wrap align-items-center" type="button" data-toggle="modal"
                    data-target="#how-it-works">
                    <strong class="mr-2"><?php echo e(translate('How the Setting Works')); ?></strong>
                    <div>
                        <i class="tio-info-outined"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-4 mt-2">
            <div class="js-nav-scroller hs-nav-scroller-horizontal">
                <?php echo $__env->make('admin-views.business-settings.landing-page-settings.top-menu-links.admin-landing-page-links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
        <?php ($feature_title = \App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key', 'feature_title')->first()); ?>
        <?php ($feature_short_description = \App\Models\DataSetting::withoutGlobalScope('translate')->where('type','admin_landing_page')->where('key', 'feature_short_description')->first()); ?>
        <?php ($language = \App\Models\BusinessSetting::where('key', 'language')->first()); ?>
        <?php ($language = $language->value ?? null); ?>

        <?php if($language): ?>
            <ul class="nav nav-tabs mb-4 border-0">
                <li class="nav-item">
                    <a class="nav-link lang_link active" href="#"
                        id="default-link"><?php echo e(translate('messages.default')); ?></a>
                </li>
                <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="nav-item">
                        <a class="nav-link lang_link" href="#"
                            id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php endif; ?>
        <div class="tab-content">
            <div class="tab-pane fade show active">
                <form action="<?php echo e(route('admin.business-settings.admin-landing-page-settings', 'feature-title')); ?>"
                    method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <h5 class="card-title mb-3">
                        <span class="card-header-icon mr-2"><i class="tio-settings-outlined"></i></span>
                        <span><?php echo e(translate('Feature Title & Short Description')); ?></span>
                    </h5>
                    <div class="card mb-3">
                        <div class="card-body">

                            <?php if($language): ?>
                                <div class="row g-3 lang_form default-form">
                                    <div class="col-sm-6">
                                        <label for="feature_title" class="form-label"><?php echo e(translate('Title')); ?>

                                            (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary"
                                                data-toggle="tooltip" data-placement="right"
                                                data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                    alt="">
                                            </span>
                                            <span class="form-label-secondary text-danger"
                                                  data-toggle="tooltip" data-placement="right"
                                                  data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                </span></label>
                                        <input id="feature_title" type="text" maxlength="80" name="feature_title[]"
                                            value="<?php echo e($feature_title?->getRawOriginal('value')); ?>" class="form-control"
                                            placeholder="<?php echo e(translate('Ex_:_Remarkable_Features_that_You_Can_Count')); ?>" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="feature_short_description" class="form-label"><?php echo e(translate('Short Description')); ?>

                                            (<?php echo e(translate('messages.default')); ?>)<span class="form-label-secondary"
                                                data-toggle="tooltip" data-placement="right"
                                                data-original-title="<?php echo e(translate('Write_the_title_within_240_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                    alt="">
                                            </span>
                                            <span class="form-label-secondary text-danger"
                                                  data-toggle="tooltip" data-placement="right"
                                                  data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                </span></label>
                                        <input id="feature_short_description" type="text" maxlength="240" name="feature_short_description[]"
                                            value="<?php echo e($feature_short_description?->getRawOriginal('value')); ?>" class="form-control"
                                            placeholder="<?php echo e(translate('Ex_:_Jam-packed_with_outstanding_features…')); ?>" required>
                                    </div>
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                                <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    if (isset($feature_title->translations) && count($feature_title->translations)) {
                                        $feature_title_translate = [];
                                        foreach ($feature_title->translations as $t) {
                                            if ($t->locale == $lang && $t->key == 'feature_title') {
                                                $feature_title_translate[$lang]['value'] = $t->value;
                                            }
                                        }
                                    }
                                    if (isset($feature_short_description->translations) && count($feature_short_description->translations)) {
                                        $feature_short_description_translate = [];
                                        foreach ($feature_short_description->translations as $t) {
                                            if ($t->locale == $lang && $t->key == 'feature_short_description') {
                                                $feature_short_description_translate[$lang]['value'] = $t->value;
                                            }
                                        }
                                    }
                                    ?>
                                    <div class="row g-3 d-none lang_form" id="<?php echo e($lang); ?>-form">
                                        <div class="col-sm-6">
                                            <label for="feature_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Title')); ?>

                                                (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                        <input id="feature_title<?php echo e($lang); ?>" type="text"  maxlength="80" name="feature_title[]"
                                                value="<?php echo e($feature_title_translate[$lang]['value'] ?? ''); ?>"
                                                class="form-control"
                                                placeholder="<?php echo e(translate('Ex_:_Remarkable_Features_that_You_Can_Count')); ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="feature_short_description<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Short Description')); ?>

                                                (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write_the_title_within_240_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                            </span></label>
                                        <input type="text" id="feature_short_description<?php echo e($lang); ?>" maxlength="240" name="feature_short_description[]"
                                                value="<?php echo e($feature_short_description_translate[$lang]['value'] ?? ''); ?>"
                                                class="form-control"
                                                placeholder="<?php echo e(translate('Ex_:_Jam-packed_with_outstanding_features…')); ?>">
                                        </div>
                                    </div>
                                    <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label for="feature_title" class="form-label"><?php echo e(translate('Title')); ?><span
                                                class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                                                data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                    alt="">
                                            </span></label>
                                        <input id="feature_title" type="text" maxlength="80" name="feature_title[]" class="form-control"
                                            placeholder="<?php echo e(translate('Ex_:_Remarkable_Features_that_You_Can_Count')); ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="feature_short_description" class="form-label"><?php echo e(translate('Short Description')); ?><span
                                                class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                                                data-original-title="<?php echo e(translate('Write_the_title_within_240_characters')); ?>">
                                                <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                    alt="">
                                            </span></label>
                                        <input id="feature_short_description" type="text" maxlength="240" name="feature_short_description[]"
                                            class="form-control"
                                            placeholder="<?php echo e(translate('Ex_:_Jam-packed_with_outstanding_features…')); ?>">
                                    </div>
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                            <?php endif; ?>
                            <div class="btn--container justify-content-end mt-20">
                                <button type="reset" class="btn btn--reset mb-2"><?php echo e(translate('Reset')); ?></button>
                                <button type="submit"
                                    class="btn btn--primary mb-2"><?php echo e(translate('Save')); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
                <form action="<?php echo e(route('admin.business-settings.admin-landing-page-settings', 'feature-list')); ?>"
                    method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row g-4">
                                <?php if($language): ?>
                                    <div class="col-md-6 lang_form default-form">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="title" class="form-label"><?php echo e(translate('Title')); ?>

                                                    (<?php echo e(translate('messages.default')); ?>)<span
                                                        class="form-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                            alt="">
                                                    </span>
                                                    <span class="form-label-secondary text-danger"
                                                          data-toggle="tooltip" data-placement="right"
                                                          data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                </span></label>
                                                <input id="title" type="text" maxlength="20" name="title[]" class="form-control"
                                                    placeholder="<?php echo e(translate('Ex_:_Shopping')); ?>" required>
                                            </div>
                                            <div class="col-12">
                                                <label for="sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?>

                                                    (<?php echo e(translate('messages.default')); ?>)<span
                                                        class="form-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                            alt="">
                                                    </span>
                                                    <span class="form-label-secondary text-danger"
                                                          data-toggle="tooltip" data-placement="right"
                                                          data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                </span></label>
                                                <input id="sub_title" type="text" maxlength="80" name="sub_title[]"
                                                    class="form-control"
                                                    placeholder="<?php echo e(translate('Ex_:_Best_shopping_experience')); ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="lang[]" value="default">
                                    <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-md-6 d-none lang_form" id="<?php echo e($lang); ?>-form1">
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <label for="title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Title')); ?>

                                                        (<?php echo e(strtoupper($lang)); ?>)<span
                                                        class="form-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="<?php echo e(translate('Write_the_title_within_20_characters')); ?>">
                                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                            alt="">
                                                    </span></label>
                                                <input id="title<?php echo e($lang); ?>" type="text" maxlength="20" name="title[]" class="form-control"
                                                        placeholder="<?php echo e(translate('Ex_:_Shopping')); ?>">
                                                </div>
                                                <div class="col-12">
                                                    <label for="sub_title<?php echo e($lang); ?>" class="form-label"><?php echo e(translate('Sub Title')); ?>

                                                        (<?php echo e(strtoupper($lang)); ?>)<span
                                                        class="form-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="<?php echo e(translate('Write_the_title_within_80_characters')); ?>">
                                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                            alt="">
                                                    </span></label>
                                                <input id="sub_title<?php echo e($lang); ?>" type="text" maxlength="80" name="sub_title[]" class="form-control"
                                                        placeholder="<?php echo e(translate('Ex_:_Best_shopping_experience')); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <div class="col-md-6">
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label for="title" class="form-label"><?php echo e(translate('Title')); ?><span
                                                        class="form-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="<?php echo e(translate('Write_the_title_within_50_characters')); ?>">
                                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                            alt="">
                                                    </span></label>
                                                <input id="title" type="text" maxlength="50" name="title[]" class="form-control"
                                                    placeholder="<?php echo e(translate('Ex_:_Shopping')); ?>">
                                            </div>
                                            <div class="col-12">
                                                <label for="sub_title" class="form-label"><?php echo e(translate('Sub Title')); ?><span
                                                        class="form-label-secondary" data-toggle="tooltip"
                                                        data-placement="right"
                                                        data-original-title="<?php echo e(translate('Write_the_title_within_50_characters')); ?>">
                                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                                            alt="">
                                                    </span></label>
                                                <input id="sub_title" type="text" maxlength="50" name="sub_title[]"
                                                    class="form-control"
                                                    placeholder="<?php echo e(translate('Ex_:_Best_shopping_experience')); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="lang[]" value="default">
                                <?php endif; ?>

                                <div class="col-md-6">
                                    <label class="form-label d-block mb-3">
                                        <?php echo e(translate('messages.Image')); ?> <span class="text--primary"><?php echo e(translate('(size:_1:1)')); ?></span>
                                        <span class="form-label-secondary text-danger"
                                              data-toggle="tooltip" data-placement="right"
                                              data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                </span>
                                        <div class="fs-12 opacity-70">
                                            <?php echo e(translate(IMAGE_FORMAT.' ' . 'Less Than 2MB')); ?>

                                        </div>
                                    </label>
                                    <label class="upload-img-3 m-0">
                                        <div class="img">
                                            <img src="<?php echo e(asset('/public/assets/admin/img/aspect-1.png')); ?>"
                                            data-onerror-image="<?php echo e(asset('/public/assets/admin/img/aspect-1.png')); ?>"
                                                alt="image" class="img__aspect-1 min-w-187px max-w-187px onerror-image">
                                        </div>
                                        <input class="upload-file__input single_file_input" accept="<?php echo e(IMAGE_EXTENSION); ?>" type="file" name="image" hidden>
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
                <?php ($features = \App\Models\AdminFeature::all()); ?>
                <div class="card">
                    <div class="card-header py-2">
                        <div class="search--button-wrapper">
                            <h5 class="card-title"><?php echo e(translate('Features_List')); ?>


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
                                    <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($key + 1); ?></td>
                                            <td>
                                                <div class="text--title">
                                                    <?php echo e($feature->title); ?>

                                                </div>
                                            </td>
                                            <td>
                                                <span class="d-block font-size-sm text-body">
                                                    <?php echo e($feature->sub_title); ?>


                                            </td>
                        <td>
                            <img  src="<?php echo e($feature?->image_full_url ?? asset('/public/assets/admin/img/upload-3.png')); ?>"

                                class="__size-105 onerror-image"  data-onerror-image="<?php echo e(asset('/public/assets/admin/img/upload-3.png')); ?>" alt="image">
                        </td>
                        <td>
                            <label class="toggle-switch toggle-switch-sm">
                                <input type="checkbox"

                                    data-id="status-<?php echo e($feature->id); ?>"
                                    data-type="toggle"
                                    data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/feature-list-on.png')); ?>"
                                    data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/feature-list-off.png')); ?>"
                                    data-title-on="<?php echo e(translate('By Turning ON ')); ?> <strong><?php echo e(translate('Feature List Section')); ?>"
                                    data-title-off="<?php echo e(translate('By Turning OFF ')); ?> <strong><?php echo e(translate('Feature List Section')); ?>"
                                    data-text-on="<p><?php echo e(translate('Feature list is enabled. You can now access its features and functionality')); ?></p>"
                                    data-text-off="<p><?php echo e(translate('Feature list will be disabled. You can enable it in the settings to access its features and functionality')); ?></p>"
                                    class="status toggle-switch-input dynamic-checkbox"


                                    <?php echo e($feature->status ? 'checked' : ''); ?>>
                                <span class="toggle-switch-label">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                            <form
                                action="<?php echo e(route('admin.business-settings.feature-status', [$feature->id, $feature->status ? 0 : 1])); ?>"
                                method="get" id="status-<?php echo e($feature->id); ?>_form">
                            </form>
                        </td>

                        <td>
                            <div class="btn--container justify-content-center">
                                <a class="btn action-btn btn--primary btn-outline-primary"
                                    href="<?php echo e(route('admin.business-settings.feature-edit', [$feature['id']])); ?>">
                                    <i class="tio-edit"></i>
                                </a>
                                <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:"

                                   data-id="banner-<?php echo e($feature['id']); ?>"
                                   data-message="<?php echo e(translate('Want to delete this banner ?')); ?>"

                                    title="<?php echo e(translate('messages.delete_banner')); ?>"><i
                                        class="tio-delete-outlined"></i>
                                </a>
                                <form action="<?php echo e(route('admin.business-settings.feature-delete', [$feature['id']])); ?>"
                                    method="post" id="banner-<?php echo e($feature['id']); ?>">
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
                <?php if(count($features) === 0): ?>
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
    <?php echo $__env->make('admin-views.business-settings.landing-page-settings.partial.how-it-work', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/business-settings/landing-page-settings/admin-feature-list.blade.php ENDPATH**/ ?>