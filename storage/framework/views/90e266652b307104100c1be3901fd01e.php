<?php $__env->startSection('title', translate('messages.add_new_addon')); ?>

<?php $__env->startPush('css_or_js'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/addon.png')); ?>" class="w--20" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.add_new_addon')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="card">
            <div class="card-body">
                <form action="<?php echo e(isset($addon) ? route('admin.addon.update', [$addon['id']]) : route('admin.addon.store')); ?>"
                    method="post">
                    <?php echo csrf_field(); ?>
                    <?php if($language): ?>
                        <ul class="nav nav-tabs mb-4">
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
                        <div class="col-sm-6 col-lg-4">
                            <?php if($language): ?>
                                <div class="form-group lang_form" id="default-form">
                                    <label class="input-label"
                                        for="exampleFormControlInput1"><?php echo e(translate('messages.name')); ?>

                                        (<?php echo e(translate('messages.default')); ?>)</label>
                                    <input type="text" name="name[]" class="form-control"
                                        placeholder="<?php echo e(translate('messages.new_addon')); ?>" maxlength="191">
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                                <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-group d-none lang_form" id="<?php echo e($lang); ?>-form">
                                        <label class="input-label"
                                            for="exampleFormControlInput1"><?php echo e(translate('messages.name')); ?>

                                            (<?php echo e(strtoupper($lang)); ?>)
                                        </label>
                                        <input type="text" name="name[]" class="form-control"
                                            placeholder="<?php echo e(translate('messages.new_addon')); ?>" maxlength="191">
                                    </div>
                                    <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="form-group">
                                    <label class="input-label"
                                        for="exampleFormControlInput1"><?php echo e(translate('messages.name')); ?></label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="<?php echo e(translate('messages.new_addon')); ?>" value="<?php echo e(old('name')); ?>"
                                        maxlength="191">
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                            <?php endif; ?>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="form-group">
                                <label class="input-label"
                                    for="exampleFormControlSelect1"><?php echo e(translate('messages.store')); ?><span
                                        class="input-label-secondary"></span></label>
                                <select name="store_id" id="store_id" class="js-data-example-ajax form-control"
                                    data-placeholder="<?php echo e(translate('messages.select_store')); ?>">

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="form-group">
                                <label class="input-label"
                                    for="exampleFormControlInput1"><?php echo e(translate('messages.price')); ?></label>
                                <input type="number" min="0" max="999999999999.99" name="price" step="0.01"
                                    value="<?php echo e(old('price')); ?>" class="form-control" placeholder="100" required>
                            </div>
                        </div>


                        <div class="col-sm-6 col-lg-4">
                            <div class="form-group">
                                <span class="mb-2 d-block title-clr fw-normal"><?php echo e(translate('Category')); ?></span>
                                <select name="category_id" required class="form-control js-select2-custom"
                                    placeholder="Select Category">
                                    <option selected disabled value=""> <?php echo e(translate('messages.select_category')); ?></option>
                                    <?php $__currentLoopData = $addonCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addonCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($addonCategory->id); ?>"> <?php echo e($addonCategory->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                            </div>
                        </div>


                        <?php if($productWiseTax): ?>
                            <div class="col-sm-6 col-lg-4">
                                <div class="form-group">
                                    <span
                                        class="mb-2 d-block title-clr fw-normal"><?php echo e(translate('Select Tax Rate')); ?></span>
                                    <select name="tax_ids[]" required id="tax__rate" class="form-control js-select2-custom"
                                        multiple="multiple" placeholder="Type & Select Tax Rate">
                                        <?php $__currentLoopData = $taxVats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxVat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($taxVat->id); ?>"> <?php echo e($taxVat->name); ?>

                                                (<?php echo e($taxVat->tax_rate); ?>%)
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                </div>
                            </div>

                        <?php endif; ?>
                    </div>


                    <div class="btn--container justify-content-end">
                        <button type="reset" id="reset_btn"
                            class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                        <button type="submit"
                            class="btn btn--primary"><?php echo e(isset($addon) ? translate('messages.update') : translate('messages.add')); ?></button>
                    </div>

                </form>
            </div>
        </div>

        <div class="card mt-1">
            <div class="card-header py-2 border-0">
                <div class="search--button-wrapper justify-content-end">
                    <h5 class="card-title"> <?php echo e(translate('messages.addon_list')); ?><span
                            class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($addons->total()); ?></span>
                    </h5>
                    <div class="min--220">
                        <select name="store_id" id="store" data-url="<?php echo e(route('admin.addon.add-new')); ?>"
                            data-placeholder="<?php echo e(translate('messages.select_store')); ?>"
                            class="js-data-example-ajax form-control store-filter" title="Select Restaurant">
                            <?php if(isset($store)): ?>
                                <option value="<?php echo e($store->id); ?>" selected><?php echo e($store->name); ?></option>
                            <?php else: ?>
                                <option value="all" selected><?php echo e(translate('messages.all_stores')); ?></option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <form class="search-form">
                        <!-- Search -->
                        <div class="input-group input--group">
                            <input type="search" name="search" value="<?php echo e(request()->search ?? null); ?>"
                                class="form-control min-height-45"
                                placeholder="<?php echo e(translate('messages.ex_:_addons_name')); ?>" aria-label="Search addons">
                            <button type="submit" class="btn btn--secondary min-height-45"><i class="tio-search"></i>
                            </button>
                        </div>
                        <!-- End Search -->
                    </form>
                    <div class="hs-unfold">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle min-height-40"
                            href="javascript:;"
                            data-hs-unfold-options='{
                                    "target": "#usersExportDropdown",
                                    "type": "css-animation"
                                }'>
                            <i class="tio-download-to mr-1"></i> <?php echo e(translate('messages.export')); ?>

                        </a>
                    </div>
                    <div id="usersExportDropdown"
                        class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                        <span class="dropdown-header"><?php echo e(translate('messages.download_options')); ?></span>
                        <a id="export-excel" class="dropdown-item"
                            href="
                            <?php echo e(route('admin.addon.export', ['type' => 'excel', request()->getQueryString()])); ?>

                            ">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                alt="Image Description">
                            <?php echo e(translate('messages.excel')); ?>

                        </a>
                        <a id="export-csv" class="dropdown-item"
                            href="
                        <?php echo e(route('admin.addon.export', ['type' => 'csv', request()->getQueryString()])); ?>">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                alt="Image Description">
                            .<?php echo e(translate('messages.csv')); ?>

                        </a>
                    </div>


                    <!-- End Unfold -->
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive datatable-custom">
                <table id="datatable"
                    class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                    data-hs-datatables-options='{
                        "search": "#datatableSearch",
                        "entries": "#datatableEntries",
                        "isResponsive": false,
                        "isShowPaging": false,
                        "paging":false
                            }'>
                    <thead class="thead-light">
                        <tr>
                            <th><?php echo e(translate('sl')); ?></th>
                            <th><?php echo e(translate('messages.name')); ?></th>
                            <th><?php echo e(translate('messages.price')); ?></th>
                            <th><?php echo e(translate('messages.store')); ?></th>
                            <?php if($productWiseTax): ?>
                            <th><?php echo e(translate('messages.Vat/Tax')); ?></th>
                            <?php endif; ?>

                            <th class="text-center"><?php echo e(translate('messages.status')); ?></th>
                            <th class="text-center"><?php echo e(translate('messages.action')); ?></th>
                        </tr>
                    </thead>

                    <tbody id="set-rows">
                        <?php $__currentLoopData = $addons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($key + $addons->firstItem()); ?></td>
                                <td>
                                    <span class="d-block font-size-sm text-body">
                                        <?php echo e(Str::limit($addon['name'], 20, '...')); ?>

                                    </span>
                                </td>
                                <td><?php echo e(\App\CentralLogics\Helpers::format_currency($addon['price'])); ?></td>
                                <td><?php echo e(Str::limit($addon->store ? $addon->store->name : translate('messages.store_deleted'), 25, '...')); ?>

                                </td>


                                <?php if($productWiseTax): ?>
                                <td>
                                    <span class="d-block font-size-sm text-body">
                                        <?php $__empty_1 = true; $__currentLoopData = $addon?->taxVats?->pluck('tax.name', 'tax.tax_rate')->toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
                                    <label class="toggle-switch toggle-switch-sm" for="stausCheckbox<?php echo e($addon->id); ?>">
                                        <input type="checkbox"
                                            data-url="<?php echo e(route('admin.addon.status', [$addon['id'], $addon->status ? 0 : 1])); ?>"
                                            class="toggle-switch-input redirect-url"
                                            id="stausCheckbox<?php echo e($addon->id); ?>" <?php echo e($addon->status ? 'checked' : ''); ?>>
                                        <span class="toggle-switch-label mx-auto">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                    </label>
                                </td>
                                <td>
                                    <div class="btn--container justify-content-center">
                                        <a class="btn btn-sm text-end action-btn info--outline text--info info-hover offcanvas-trigger get_data data-info-show" data-target="#offcanvas__customBtn3" data-id="<?php echo e($addon['id']); ?>"  data-url="<?php echo e(route('admin.addon.edit',[$addon['id']])); ?>" href="javascript:"
                                            title="<?php echo e(translate('messages.edit_addon')); ?>"><i class="tio-edit"></i></a>
                                        <a class="btn action-btn btn--danger btn-outline-danger form-alert"
                                            data-id="addon-<?php echo e($addon['id']); ?>"
                                            data-message="<?php echo e(translate('Want to delete this addon ?')); ?>"
                                            href="javascript:" title="<?php echo e(translate('messages.delete_addon')); ?>"><i
                                                class="tio-delete-outlined"></i></a>
                                        <form action="<?php echo e(route('admin.addon.delete', [$addon['id']])); ?>" method="post"
                                            id="addon-<?php echo e($addon['id']); ?>">
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
        <?php if(count($addons) !== 0): ?>
            <hr>
        <?php endif; ?>
        <div class="page-area">
            <?php echo $addons->links(); ?>

        </div>
        <?php if(count($addons) === 0): ?>
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
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/addon-index.js"></script>
    <script>
        "use strict";
function getStoreSelect2Config(showAll) {
    return {
        ajax: {
            url: '<?php echo e(url('/')); ?>/admin/store/get-stores',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                const data = {
                    q: params.term,
                    module_type: 'food',
                    module_id: <?php echo e(Config::get('module.current_module_id')); ?>,
                    page: params.page || 1
                };

                if (showAll) {
                    data.all = true;
                }

                return data;
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        placeholder: 'Select a store',
        allowClear: true
    };
}

        $('#store').select2(getStoreSelect2Config(true));
        $('#store_id').select2(getStoreSelect2Config(false));

            $(document).on('click', '.data-info-show', function() {
            let id = $(this).data('id');
            let url = $(this).data('url');
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
                    $('#store_id1').select2(getStoreSelect2Config(false));
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
            });
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/addon/index.blade.php ENDPATH**/ ?>