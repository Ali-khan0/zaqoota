<?php $__env->startSection('title', translate('messages.Add Addon Category')); ?>

<?php $__env->startPush('css_or_js'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div id="content-disable" class="content container-fluid ">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/category.png')); ?>" class="w--20" alt="">
                </span>
                <span>
                    <?php echo e(translate('add_new_addon_category')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->

        <div  class="card">
            <div class="card-body">
                <form action="<?php echo e(route('admin.addon.addon-category-store')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <?php if($language): ?>
                        <ul class="nav nav-tabs mb-4 border-0">
                            <li class="nav-item">
                                <a class="nav-link lang_link active offcanvas-close" href="#"
                                    id="default-link"><?php echo e(translate('messages.default')); ?></a>
                            </li>
                            <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="nav-item">
                                    <a class="nav-link lang_link offcanvas-close" href="#"
                                        id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?php if($language): ?>
                                <div class="form-group lang_form" id="default-form">
                                    <label class="input-label"
                                        for="exampleFormControlInput1"><?php echo e(translate('messages.Category_Name')); ?>

                                        (<?php echo e(translate('messages.default')); ?>)
                                        <span class="form-label-secondary text-danger" data-toggle="tooltip"
                                            data-placement="right"
                                            data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                        </span>

                                    </label>
                                    <input type="text" name="name[]" value="<?php echo e(old('name.0')); ?>" class="form-control"
                                        placeholder="<?php echo e(translate('messages.new_category')); ?>" maxlength="255">
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                                <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-group d-none lang_form" id="<?php echo e($lang); ?>-form">
                                        <label class="input-label"
                                            for="exampleFormControlInput1"><?php echo e(translate('messages.Category_Name')); ?>

                                            (<?php echo e(strtoupper($lang)); ?>)
                                        </label>
                                        <input type="text" name="name[]" value="<?php echo e(old('name.' . $key + 1)); ?>"
                                            class="form-control"
                                            placeholder="<?php echo e(translate('messages.Type_Category_Name')); ?>" maxlength="191">
                                    </div>
                                    <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="form-group">
                                    <label class="input-label"
                                        for="exampleFormControlInput1"><?php echo e(translate('messages.Category_Name')); ?></label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="<?php echo e(translate('messages.new_category')); ?>"
                                        value="<?php echo e(old('name')); ?>" maxlength="191">
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                            <?php endif; ?>

                        </div>
                        <div class="col-md-6">
                            <?php if($categoryWiseTax): ?>
                                <span class="mb-2 d-block title-clr fw-normal"><?php echo e(translate('Select Tax Rate')); ?></span>
                                <select name="tax_ids[]" required id="tax__rate" class="form-control js-select2-custom"
                                    multiple="multiple" placeholder="Type & Select Tax Rate">
                                    <?php $__currentLoopData = $taxVats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxVat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($taxVat->id); ?>"> <?php echo e($taxVat->name); ?>

                                            (<?php echo e($taxVat->tax_rate); ?>%)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            <?php endif; ?>
                        </div>

                    </div>
                    <div class="btn--container justify-content-end mt-20">
                        <button type="reset" id="reset_btn"
                            class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.add')); ?></button>
                    </div>

                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header py-2 border-0">
                <div class="search--button-wrapper">
                    <h5 class="card-title"><?php echo e(translate('messages.category_list')); ?><span
                            class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($categories->total()); ?></span></h5>

                    <form class="search-form">
                        <!-- Search -->
                        <div class="input-group input--group">
                            <input type="search" name="search" value="<?php echo e(request()?->search ?? null); ?>"
                                class="form-control min-height-45" placeholder="<?php echo e(translate('messages.search_here')); ?>"
                                aria-label="<?php echo e(translate('messages.ex_:_categories')); ?>">
                            <input type="hidden" name="position" value="0">
                            <button type="submit" class="btn btn--secondary min-height-45"><i
                                    class="tio-search"></i></button>
                        </div>
                        <!-- End Search -->
                    </form>

                    <!-- Unfold -->
                    <div class="hs-unfold mr-2">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle min-height-40"
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
                                href="<?php echo e(route('admin.addon.addon-category-export', ['type' => 'excel', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                    alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item"
                                href="<?php echo e(route('admin.addon.addon-category-export', ['type' => 'csv', request()->getQueryString()])); ?>">
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
            <div class="card-body p-0">
                <div class="table-responsive datatable-custom">
                    <table id="columnSearchDatatable"
                        class="table table-borderless table-thead-bordered table-align-middle"
                        data-hs-datatables-options='{
                            "isResponsive": false,
                            "isShowPaging": false,
                            "paging":false,
                        }'>
                        <thead class="thead-light">
                            <tr>
                                <th class="border-0"><?php echo e(translate('sl')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.id')); ?></th>
                                <th class=""><?php echo e(translate('messages.Category_Name')); ?></th>
                                <?php if($categoryWiseTax): ?>
                                    <th class="border-0 w--1"><?php echo e(translate('messages.Vat/Tax')); ?></th>
                                <?php endif; ?>
                                <th class="border-0 text-center"><?php echo e(translate('messages.status')); ?></th>
                                <th class="border-0 text-center"><?php echo e(translate('messages.action')); ?></th>
                            </tr>
                        </thead>

                        <tbody id="table-div">
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key + $categories->firstItem()); ?></td>
                                    <td><?php echo e($category->id); ?></td>
                                    <td>
                                        <?php echo e(Str::limit($category['name'], 20, '...')); ?>


                                    </td>

                                    <?php if($categoryWiseTax): ?>
                                        <td>
                                            <span class="d-block font-size-sm text-body">

                                                <?php $__empty_1 = true; $__currentLoopData = $category?->taxVats?->pluck('tax.name', 'tax.tax_rate')->toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <span> <?php echo e($item); ?> : <span class="font-bold">
                                                            (<?php echo e($key); ?>%)
                                                        </span> </span>
                                                    <br>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <span> <?php echo e(translate('messages.no_tax')); ?> </span>
                                                <?php endif; ?>
                                            </span>
                                        </td>
                                    <?php endif; ?>

                                    <td>
                                        <label class="toggle-switch toggle-switch-sm"
                                            for="stocksCheckbox<?php echo e($category->id); ?>">
                                            <input type="checkbox"
                                                data-url="<?php echo e(route('admin.addon.addon-category-status', [$category->id])); ?>"
                                                class="toggle-switch-input redirect-url"
                                                id="stocksCheckbox<?php echo e($category->id); ?>"
                                                <?php echo e($category->status ? 'checked' : ''); ?>>
                                            <span class="toggle-switch-label mx-auto">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </td>

                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a class="btn btn-sm text-end action-btn info--outline text--info info-hover offcanvas-trigger get_data data-info-show"
                                                data-target="#offcanvas__customBtn3" data-id="<?php echo e($category['id']); ?>"
                                                data-url="<?php echo e(route('admin.addon.addon-category-edit', [$category['id']])); ?>"
                                                href="javascript:" title="<?php echo e(translate('messages.edit_category')); ?>"><i
                                                    class="tio-edit"></i>
                                            </a>
                                            <a class="btn action-btn btn--danger btn-outline-danger form-alert"
                                                href="javascript:" data-id="category-<?php echo e($category['id']); ?>"
                                                data-message="<?php echo e(translate('Want to delete this category')); ?>"
                                                title="<?php echo e(translate('messages.delete_category')); ?>"><i
                                                    class="tio-delete-outlined"></i>
                                            </a>
                                        </div>
                                        <form
                                            action="<?php echo e(route('admin.addon.addon-category-delete', [$category['id']])); ?>"
                                            method="post" id="category-<?php echo e($category['id']); ?>">
                                            <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                        </form>
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
                <?php echo $categories->appends($_GET)->links(); ?>

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

    <div id="offcanvas__customBtn3" class="custom-offcanvas d-flex flex-column justify-content-between">
        <div id="data-view" class="h-100">
        </div>
    </div>



<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script>
        "use strict";
        document.getElementById('reset_btn').addEventListener('click', function() {
            const select = $('#tax__rate');
            select.val(null).trigger('change');
        });


        $(document).on('click', '.data-info-show', function() {
            let id = $(this).data('id');
            let url = $(this).data('url');
            $('#content-disable').addClass('disabled');
            fetch_data(id, url)
        })

        function fetch_data(id, url) {
            $.ajax({
                url: url,
                type: "get",
                beforeSend: function() {
                    $('#data-view').empty();
                    $('#loading').show()
                },
                success: function(data) {
                    $("#data-view").append(data.view);
                    initLangTabs();
                    initSelect2Dropdowns();
                },
                complete: function() {
                    $('#loading').hide()
                }
            })
        }


        function initLangTabs() {
            const langLinks = document.querySelectorAll(".lang_link1");
            langLinks.forEach(function(langLink) {
                langLink.addEventListener("click", function(e) {
                    e.preventDefault();
                    langLinks.forEach(function(link) {
                        link.classList.remove("active");
                    });
                    this.classList.add("active");
                    document.querySelectorAll(".lang_form1").forEach(function(form) {
                        form.classList.add("d-none");
                    });
                    let form_id = this.id;
                    let lang = form_id.substring(0, form_id.length - 5);
                    $("#" + lang + "-form1").removeClass("d-none");
                    if (lang === "default") {
                        $(".default-form1").removeClass("d-none");
                    }
                });
            });
        }

        function initSelect2Dropdowns() {
            $('.js-select2-custom1').select2({
                placeholder: 'Select tax rate',
                allowClear: true
            });
             $('.offcanvas-close, #offcanvasOverlay').on('click', function () {
        $('.custom-offcanvas').removeClass('open');
        $('#offcanvasOverlay').removeClass('show');
         $('#content-disable').removeClass('disabled');
            });
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/addon/addon-category/index.blade.php ENDPATH**/ ?>