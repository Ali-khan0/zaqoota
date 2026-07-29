<?php $__env->startSection('title',translate('messages.Add new sub category')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/edit.png')); ?>" class="w--20" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.add_new_sub_category')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="card">
            <div class="card-body">
                <form action="<?php echo e(route('admin.category.store')); ?>" method="post">
                <?php echo csrf_field(); ?>
                    <div class="row">
                    <?php if($language): ?>
                        <?php ($defaultLang = $language[0]); ?>
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs mb-4">
                                <li class="nav-item">
                                    <a class="nav-link lang_link active"
                                    href="#"
                                    id="default-link"><?php echo e(translate('messages.default')); ?></a>
                                </li>
                                <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="nav-item">
                                        <a class="nav-link lang_link"
                                            href="#"
                                            id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                        <div class="form-group lang_form col-sm-6" id="default-form">
                            <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.name')); ?> (<?php echo e(translate('messages.default')); ?>) <span class="form-label-secondary text-danger"
                                data-toggle="tooltip" data-placement="right"
                                data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                </span>
                            </label>
                            <input type="text" name="name[]" class="form-control" placeholder="<?php echo e(translate('messages.new_sub_category')); ?>" maxlength="191"  >
                        </div>
                        <input type="hidden" name="lang[]" value="default">
                        <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="form-group d-none lang_form col-sm-6" id="<?php echo e($lang); ?>-form">
                                <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.name')); ?> (<?php echo e(strtoupper($lang)); ?>)</label>
                                <input type="text" name="name[]" class="form-control" placeholder="<?php echo e(translate('messages.new_sub_category')); ?>" maxlength="191"  >
                            </div>
                            <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <div class="form-group col-sm-6">
                            <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.name')); ?></label>
                            <input type="text" name="name" class="form-control" placeholder="<?php echo e(translate('messages.new_sub_category')); ?>" value="<?php echo e(old('name')); ?>" maxlength="191">
                        </div>
                        <input type="hidden" name="lang[]" value="default">
                    <?php endif; ?>
                        <div class="form-group col-sm-6">
                            <label class="input-label"
                                for="exampleFormControlSelect1"><?php echo e(translate('messages.main_category')); ?>

                                <span class="input-label-secondary">*</span></label>
                            <select id="exampleFormControlSelect1" name="parent_id" class="form-control js-select2-custom" required>
                                <option value="" selected disabled><?php echo e(translate('Select Main Category')); ?></option>
                                <?php $__currentLoopData = $mainCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category['id']); ?>" ><?php echo e($category['name']); ?> (<?php echo e(Str::limit($category->module->module_name, 15, '...')); ?>)</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <input name="position" value="1" hidden>

                          <div class="form-group col-sm-6">
                                <label class="input-label" for="">
                                    <?php echo e(translate('messages.Priority')); ?>

                                </label>
                                <select required name="priority"
                                    data-original-title="<?php echo e(translate('messages.Select_Priority')); ?>"
                                    class="custom-select">
                                    <option value="0"><?php echo e(translate('messages.Normal')); ?></option>
                                    <option value="1"><?php echo e(translate('messages.Medium')); ?></option>
                                    <option value="2"><?php echo e(translate('messages.High')); ?></option>
                                </select>
                            </div>

                        <div class="col-sm-12">
                            <div class="btn--container justify-content-end">
                                <button type="reset" id="reset_btn" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                                <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.add')); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header py-2 border-0">
                <div class="search--button-wrapper">
                    <h5 class="card-title"><?php echo e(translate('messages.sub_category_list')); ?><span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($categories->total()); ?></span></h5>

                    <form   class="search-form">
                        <!-- Search -->
                        <div class="input-group input--group">
                            <input id="datatableSearch" data-reload_url="<?php echo e(url()->full()); ?>" name="search" value="<?php echo e(request()?->search ?? null); ?>"  type="search" class="form-control" placeholder="<?php echo e(translate('messages.ex_:_search_sub_categories')); ?>" aria-label="<?php echo e(translate('messages.ex_:_sub_categories')); ?>">
                            <input type="hidden" name="position" value="1">
                            <input type="hidden" name="sub_category" value="1">
                            <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                        </div>
                        <!-- End Search -->
                    </form>
                    <?php if(request()->get('search')): ?>
                    <button type="reset" class="btn btn--primary ml-2 location-reload-to-category" data-url="<?php echo e(url()->full()); ?>"><?php echo e(translate('messages.reset')); ?></button>
                    <?php endif; ?>
                    <!-- Unfold -->
                    <div class="hs-unfold mr-2">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle min-height-40" href="javascript:;"
                            data-hs-unfold-options='{
                                    "target": "#usersExportDropdown",
                                    "type": "css-animation"
                                }'>
                            <i class="tio-download-to mr-1"></i> <?php echo e(translate('messages.export')); ?>

                        </a>

                        <div id="usersExportDropdown"
                            class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">

                            <span class="dropdown-header"><?php echo e(translate('messages.download_options')); ?></span>
                            <a id="export-excel" class="dropdown-item" href="<?php echo e(route('admin.category.export-categories', ['type' => 'excel', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                    alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item" href="<?php echo e(route('admin.category.export-categories', ['type' => 'csv', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                    alt="Image Description">
                                .<?php echo e(translate('messages.csv')); ?>

                            </a>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive datatable-custom">
                    <table id="columnSearchDatatable"
                        class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                        data-hs-datatables-options='{
                            "search": "#datatableSearch",
                            "entries": "#datatableEntries",
                            "isResponsive": false,
                            "isShowPaging": false,
                            "paging":false,
                        }'>
                        <thead class="thead-light">
                            <tr>
                                <th class="border-0"><?php echo e(translate('sl')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.id')); ?></th>
                                <th class="border-0 w--1"><?php echo e(translate('messages.main_category')); ?></th>
                                <th class="border-0 text-center"><?php echo e(translate('messages.sub_category')); ?></th>
                                <th class="border-0 text-center"><?php echo e(translate('messages.status')); ?></th>
                                <th class="border-0 text-center"><?php echo e(translate('messages.featured')); ?></th>
                                <th class="border-0 text-center"><?php echo e(translate('messages.priority')); ?></th>
                                <th class="border-0 text-center"><?php echo e(translate('messages.action')); ?></th>
                            </tr>
                        </thead>

                        <tbody id="table-div">
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($key+$categories->firstItem()); ?></td>
                                <td><?php echo e($category->id); ?></td>
                                <td>
                                    <span class="d-block font-size-sm text-body">
                                        <?php echo e($category?->parent?->name ? Str::limit($category->parent['name'],20,'...') : translate('Invalid_Category')); ?>

                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="d-block font-size-sm text-body">
                                        <?php echo e(Str::limit($category?->name,20,'...')); ?>

                                    </span>
                                </td>
                                <td>
                                    <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox<?php echo e($category->id); ?>">
                                    <input type="checkbox" data-url="<?php echo e(route('admin.category.status',[$category['id'],$category->status?0:1])); ?>" class="toggle-switch-input redirect-url" id="stocksCheckbox<?php echo e($category->id); ?>" <?php echo e($category->status?'checked':''); ?>>
                                        <span class="toggle-switch-label mx-auto">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                    </label>
                                </td>
                                <td>
                                        <label class="toggle-switch toggle-switch-sm"
                                            for="featuredCheckbox<?php echo e($category->id); ?>">
                                            <input type="checkbox" data-id="featuredCheckbox<?php echo e($category->id); ?>"
                                                data-type="status"
                                                data-image-on="<?php echo e(asset('/public/assets/admin/img/status-ons.png')); ?>"
                                                data-image-off="<?php echo e(asset('/public/assets/admin/img/off-danger.png')); ?>"
                                                data-title-on="<?php echo e(translate('Do you want to Featured this sub category ?')); ?>"
                                                data-title-off="<?php echo e(translate('Don’t you want to Featured this sub category?')); ?>"
                                                data-text-on="<p><?php echo e(translate('If you turn on this sub category as a featured category it will show in customer app landing page.')); ?>"
                                                data-text-off="<p><?php echo e(translate('If you turn off this sub category from featured category it will not show in customer app landing page.')); ?></p>"
                                                class="toggle-switch-input dynamic-checkbox"
                                                id="featuredCheckbox<?php echo e($category->id); ?>"
                                                <?php echo e($category->featured ? 'checked' : ''); ?>>
                                            <span class="toggle-switch-label mx-auto">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>

                                        <form
                                            action="<?php echo e(route('admin.category.featured', [$category['id'], $category->featured ? 0 : 1])); ?>"
                                            method="get" id="featuredCheckbox<?php echo e($category->id); ?>_form">
                                        </form>
                                    </td>
                                <td>
                                    <form action="<?php echo e(route('admin.category.priority',$category->id)); ?>" class="priority-form">
                                        <select name="priority" id="priority" class="form-control priority-select form--control-select mx-auto <?php echo e($category->priority == 0 ? 'text-title':''); ?> <?php echo e($category->priority == 1 ? 'text-info':''); ?> <?php echo e($category->priority == 2 ? 'text-success':''); ?>">
                                            <option value="0" <?php echo e($category->priority == 0?'selected':''); ?>><?php echo e(translate('messages.normal')); ?></option>
                                            <option value="1" <?php echo e($category->priority == 1?'selected':''); ?>><?php echo e(translate('messages.medium')); ?></option>
                                            <option value="2" <?php echo e($category->priority == 2?'selected':''); ?>><?php echo e(translate('messages.high')); ?></option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <div class="btn--container justify-content-center">
                                             <a class="btn action-btn btn-outline-theme-dark offcanvas-trigger data-info-show" href="javascript:void(0)"
                                                data-id="<?php echo e($category['id']); ?>"
                                                data-url="<?php echo e(route('admin.category.edit', [$category['id']])); ?>"

                                            data-target="#offcanvas__categoryBtn">
                                                <i class="tio-edit"></i>
                                            </a>
                                        <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:"
                                           data-id="category-<?php echo e($category['id']); ?>" data-message="<?php echo e(translate('Want to delete this category')); ?>" title="<?php echo e(translate('messages.delete_category')); ?>"><i class="tio-delete-outlined"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.category.delete',[$category['id']])); ?>" method="post" id="category-<?php echo e($category['id']); ?>">
                                            <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if(count($categories) !== 0): ?>
            <hr>
            <?php endif; ?>
            <div class="page-area">
                <?php echo $categories->appends(request()->query())->links(); ?>

            </div>
            <?php if(count($categories) === 0): ?>
            <div class="empty--data">
                <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                <h5>
                    <?php echo e(translate('no_data_found')); ?>

                </h5>
            </div>
            <?php endif; ?>
        </div>
    </div>
        <div id="offcanvas__categoryBtn" class="custom-offcanvas d-flex flex-column justify-content-between">
         <div id="data-view" class="h-100">
        </div>
    </div>
    <div id="offcanvasOverlay" class="offcanvas-overlay"></div>



<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/sub-category-index.js"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/category/sub-index.blade.php ENDPATH**/ ?>