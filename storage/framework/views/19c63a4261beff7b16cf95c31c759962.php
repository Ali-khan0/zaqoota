<?php $__env->startSection('title',translate('messages.banner')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/banner.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.add_new_banner')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <div class="card">
                    <div class="card-body">
                        <form id="banner_form" class="custom-validation" data-ajax="true">
                            
                            <div class="row g-3">
                                <div class="col-lg-6">
                                    <?php if($language): ?>
                                    <ul class="nav nav-tabs mb-3 border-0">
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
                                    <div class="lang_form" id="default-form">
                                        <div class="form-group error-wrapper">
                                            <label class="input-label"
                                                for="default_title"><?php echo e(translate('messages.title')); ?>

                                                (Default)
                                            </label>
                                            <input type="text" name="title[]" id="default_title"
                                                class="form-control" placeholder="<?php echo e(translate('messages.new_banner')); ?>" required
                                            >
                                        </div>
                                        <input type="hidden" name="lang[]" value="default">
                                    </div>
                                        <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="d-none lang_form"
                                                id="<?php echo e($lang); ?>-form">
                                                <div class="form-group error-wrapper">
                                                    <label class="input-label"
                                                        for="<?php echo e($lang); ?>_title"><?php echo e(translate('messages.title')); ?>

                                                        (<?php echo e(strtoupper($lang)); ?>)
                                                    </label>
                                                    <input type="text" name="title[]" id="<?php echo e($lang); ?>_title"
                                                        class="form-control" placeholder="<?php echo e(translate('messages.new_banner')); ?>">
                                                </div>
                                                <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <div id="default-form">
                                            <div class="form-group error-wrapper">
                                                <label class="input-label"
                                                    for="exampleFormControlInput1"><?php echo e(translate('messages.title')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                                <input type="text" name="title[]" class="form-control"
                                                    placeholder="<?php echo e(translate('messages.new_banner')); ?>" required>
                                            </div>
                                            <input type="hidden" name="lang[]" value="default">
                                        </div>
                                    <?php endif; ?>
                                    <div class="form-group error-wrapper">
                                        <label class="input-label" for="title"><?php echo e(translate('messages.zone')); ?></label>
                                        <select name="zone_id" id="zone" class="form-control js-select2-custom" required>
                                            <option disabled selected>---<?php echo e(translate('messages.select')); ?>---</option>
                                            <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(isset(auth('admin')->user()->zone_id)): ?>
                                                    <?php if(auth('admin')->user()->zone_id == $zone->id): ?>
                                                        <option value="<?php echo e($zone->id); ?>" selected><?php echo e($zone->name); ?></option>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <option value="<?php echo e($zone['id']); ?>"><?php echo e($zone['name']); ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="form-group error-wrapper">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.banner_type')); ?></label>
                                        <select name="banner_type" id="banner_type" class="form-control">
                                            <option value="store_wise"><?php echo e(translate('messages.store_wise')); ?></option>
                                            <option value="item_wise"><?php echo e(translate('messages.item_wise')); ?></option>
                                            <option value="default"><?php echo e(translate('messages.default')); ?></option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-0 error-wrapper" id="store_wise">
                                        <label class="input-label" for="exampleFormControlSelect1"><?php echo e(translate('messages.store')); ?><span
                                                class="input-label-secondary"></span></label>
                                        <select name="store_id" id="store_id" class="js-data-example-ajax form-control"  title="<?php echo e(translate('messages.select_store')); ?>">
                                            <option disabled selected>---<?php echo e(translate('messages.select_store')); ?>---</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-0 error-wrapper" id="item_wise">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.select_item')); ?></label>
                                        <select name="item_id" id="choice_item" class="form-control js-select2-custom" placeholder="<?php echo e(translate('messages.select_item')); ?>">

                                        </select>
                                    </div>
                                    <div class="form-group mb-0 error-wrapper" id="default">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.default_link')); ?>(<?php echo e(translate('messages.optional')); ?>)</label>
                                        <input type="text" name="default_link" class="form-control" placeholder="<?php echo e(translate('messages.default_link')); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="error-wrapper">
                                        <div class="h-100 d-flex flex-column">
                                            <label class="mt-auto mb-0 d-block text-center"><?php echo e(translate('messages.banner_image')); ?> <small class="text-danger">* ( <?php echo e(translate('messages.ratio')); ?> 3:1 )</small></label>
                                            <div class="text-center py-3 my-auto">
                                                <img class="img--vertical" id="viewer"
                                                    src="<?php echo e(asset('public/assets/admin/img/900x400/img1.jpg')); ?>" alt="banner image"/>
                                            </div>
                                            <div class="custom-file">
                                                <input type="file" name="image" id="customFileEg1" class="custom-file-input"
                                                    accept=".webp, .jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required>
                                                <label class="custom-file-label" for="customFileEg1"><?php echo e(translate('messages.choose_file')); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-4">
                                    <div class="btn--container justify-content-end">
                                        <button type="reset" id="reset_btn" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                                        <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.submit')); ?></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <div class="card">
                    <div class="card-header py-2 border-0">
                        <div class="search--button-wrapper">
                            <h5 class="card-title">
                                <?php echo e(translate('messages.banner_list')); ?><span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($banners->count()); ?></span>
                            </h5>
                            <form  class="search-form">
                                <!-- Search -->
                                <div class="input-group input--group">
                                    <input id="datatableSearch" type="search" value="<?php echo e(request()->get('search')?? ''); ?>" name="search" class="form-control" placeholder="<?php echo e(translate('messages.search_by_title')); ?>" aria-label="<?php echo e(translate('messages.search_here')); ?>">
                                    <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                                </div>
                                <!-- End Search -->
                            </form>
                            <?php if(request()->get('search')): ?>
                            <button type="reset" class="btn btn--primary ml-2 location-reload-to-base" data-url="<?php echo e(url()->full()); ?>"><?php echo e(translate('messages.reset')); ?></button>
                            <?php endif; ?>

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
                                    <th class="border-0"><?php echo e(translate('messages.type')); ?></th>
                                    <th class="border-0 text-center"><?php echo e(translate('messages.featured')); ?> <span class="input-label-secondary"
                                        data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('if_you_turn/off_on_this_featured,_it_will_effect_on_website_&_user_app')); ?>"><img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>"
                                            alt="public/img"></span></th>
                                    <th class="border-0 text-center"><?php echo e(translate('messages.status')); ?></th>
                                    <th class="border-0 text-center"><?php echo e(translate('messages.action')); ?></th>
                                </tr>
                            </thead>

                            <tbody id="set-rows">
                            <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key+$banners->firstItem()); ?></td>
                                    <td>
                                        <span class="media align-items-center">
                                            <img class="img--ratio-3 w-auto h--50px rounded mr-2 onerror-image" src="<?php echo e($banner['image_full_url']); ?>"
                                                data-onerror-image="<?php echo e(asset('/public/assets/admin/img/900x400/img1.jpg')); ?>" alt="<?php echo e($banner->name); ?> image">
                                            <div class="media-body">
                                                <h5 title="<?php echo e($banner['title']); ?>" class="text-hover-primary mb-0"><?php echo e(Str::limit($banner['title'], 25, '...')); ?></h5>
                                            </div>
                                        </span>
                                    <span class="d-block font-size-sm text-body">

                                    </span>
                                    </td>
                                    <td><?php echo e(translate('messages.'.$banner['type'])); ?></td>

                                    <td  >
                                        <div class="d-flex justify-content-center">
                                            <label class="toggle-switch toggle-switch-sm" for="featuredCheckbox<?php echo e($banner->id); ?>">
                                            <input type="checkbox"
                                            data-id="featuredCheckbox<?php echo e($banner->id); ?>"
                                            data-type="status"
                                            data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/basic_campaign_on.png')); ?>"
                                            data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/basic_campaign_off.png')); ?>"
                                            data-title-on="<?php echo e(translate('By_Turning_ON_As_Featured!')); ?>"
                                            data-title-off="<?php echo e(translate('By_Turning_OFF_As_Featured!')); ?>"
                                            data-text-on="<p><?php echo e(translate('If_you_turn_on_this_featured,_then_promotional_banner_will_show_on_website_and_user_app_with_store_or_item.')); ?></p>"
                                            data-text-off="<p><?php echo e(translate('If_you_turn_off_this_featured,_then_promotional_banner_won’t_show_on_website_and_user_app')); ?></p>"
                                            class="toggle-switch-input  dynamic-checkbox" id="featuredCheckbox<?php echo e($banner->id); ?>" <?php echo e($banner->featured?'checked':''); ?>>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                        </div>
                                    </td>
                                    <form action="<?php echo e(route('admin.banner.featured',[$banner['id'],$banner->featured?0:1])); ?>"
                                        method="get" id="featuredCheckbox<?php echo e($banner->id); ?>_form">
                                        </form>

                                    <td  >
                                        <div class="d-flex justify-content-center">
                                            <label class="toggle-switch toggle-switch-sm" for="statusCheckbox<?php echo e($banner->id); ?>">
                                            <input type="checkbox"
                                            data-id="statusCheckbox<?php echo e($banner->id); ?>"
                                            data-type="status"
                                            data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/basic_campaign_on.png')); ?>"
                                            data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/basic_campaign_off.png')); ?>"
                                            data-title-on="<?php echo e(translate('By_Turning_ON_Banner!')); ?>"
                                            data-title-off="<?php echo e(translate('By_Turning_OFF_Banner!')); ?>"
                                            data-text-on="<p><?php echo e(translate('If_you_turn_on_this_status,_it_will_show_on_user_website_and_app.')); ?></p>"
                                            data-text-off="<p><?php echo e(translate('If_you_turn_off_this_status,_it_won’t_show_on_user_website_and_app')); ?></p>"
                                            class="toggle-switch-input  dynamic-checkbox" id="statusCheckbox<?php echo e($banner->id); ?>" <?php echo e($banner->status?'checked':''); ?>>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                        </div>
                                    </td>

                                    <form action="<?php echo e(route('admin.banner.status',[$banner['id'],$banner->status?0:1])); ?>"
                                        method="get" id="statusCheckbox<?php echo e($banner->id); ?>_form">
                                        </form>
                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route('admin.banner.edit',[$banner['id']])); ?>" title="<?php echo e(translate('messages.edit_banner')); ?>"><i class="tio-edit"></i>
                                            </a>
                                            <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:" data-id="banner-<?php echo e($banner['id']); ?>" data-message="<?php echo e(translate('Want to delete this banner ?')); ?>"><i class="tio-delete-outlined"></i>
                                            </a>
                                            <form action="<?php echo e(route('admin.banner.delete',[$banner['id']])); ?>"
                                                        method="post" id="banner-<?php echo e($banner['id']); ?>">
                                                    <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                    </div>
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
            <!-- End Table -->
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/banner-index.js"></script>
    <script>
        "use strict";
        var module_id = <?php echo e(Config::get('module.current_module_id')); ?>;

        function get_items()
        {
            var nurl = '<?php echo e(url('/')); ?>/admin/item/get-items?module_id='+module_id;

            if(!Array.isArray(zone_id))
            {
                nurl += '&zone_id='+zone_id;
            }

            $.get({
                url: nurl,
                dataType: 'json',
                success: function (data) {
                    $('#choice_item').empty().append(data.options);
                }
            });
        }

        $(document).on('ready', function () {

            module_id = <?php echo e(Config::get('module.current_module_id')); ?>;
            get_items();

            $('.js-data-example-ajax').select2({
                ajax: {
                    url: '<?php echo e(url('/')); ?>/admin/store/get-stores',
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            zone_ids: [zone_id],
                            page: params.page,
                            module_id: module_id
                        };
                    },
                    processResults: function (data) {
                        return {
                        results: data
                        };
                    },
                    __port: function (params, success, failure) {
                        var $request = $.ajax(params);

                        $request.then(success);
                        $request.fail(failure);

                        return $request;
                    }
                }
            });

        });

        $('#banner_form').on('submit', function (e) {
            e.preventDefault();

            let $form = $(this);
            if (!$form.valid()) {
                return false;
            }

            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: "<?php echo e(route('admin.banner.store')); ?>",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        toastr.success('<?php echo e(translate("messages.banner_added_successfully")); ?>', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        setTimeout(function () {
                            location.href = '<?php echo e(route("admin.banner.add-new")); ?>';
                        }, 2000);
                    }
                }
            });
        });



        $('#reset_btn').click(function(){
        $('#module_select').val(null).trigger('change');
        $('#zone').val(null).trigger('change');
        $('#store_id').val(null).trigger('change');
        $('#choice_item').val(null).trigger('change');
        $('#viewer').attr('src','<?php echo e(asset('public/assets/admin/img/900x400/img1.jpg')); ?>');
    })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/banner/index.blade.php ENDPATH**/ ?>