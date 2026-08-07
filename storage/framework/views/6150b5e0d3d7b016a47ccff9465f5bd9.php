<?php $__env->startSection('title',translate('messages.attributes')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/attribute.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.add_new_attribute')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="row g-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo e(route('admin.attribute.store')); ?>" method="post">
                            <?php echo csrf_field(); ?>
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
                                        <div class="form-group">
                                            <label class="input-label"
                                                for="default_title"><?php echo e(translate('messages.name')); ?>

                                                (<?php echo e(translate('messages.default')); ?>) <span class="form-label-secondary text-danger"
                                                data-toggle="tooltip" data-placement="right"
                                                data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                </span>

                                            </label>
                                            <input type="text" name="name[]" id="default_title"
                                                class="form-control" placeholder="<?php echo e(translate('messages.ex_:_new_attribute')); ?>"
                                            >
                                        </div>
                                        <input type="hidden" name="lang[]" value="default">
                                    </div>
                                        <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="d-none lang_form"
                                                id="<?php echo e($lang); ?>-form">
                                                <div class="form-group">
                                                    <label class="input-label"
                                                        for="<?php echo e($lang); ?>_title"><?php echo e(translate('messages.name')); ?>

                                                        (<?php echo e(strtoupper($lang)); ?>)
                                                    </label>
                                                    <input type="text" name="name[]" id="<?php echo e($lang); ?>_title"
                                                        class="form-control" placeholder="<?php echo e(translate('messages.ex_:_new_attribute')); ?>">
                                                </div>
                                                <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <div id="default-form">
                                            <div class="form-group">
                                                <label class="input-label"
                                                    for="exampleFormControlInput1"><?php echo e(translate('messages.name')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                                <input type="text" name="name[]" class="form-control"
                                                    placeholder="<?php echo e(translate('messages.ex_:_new_attribute')); ?>">
                                            </div>
                                            <input type="hidden" name="lang[]" value="default">
                                        </div>
                                    <?php endif; ?>
                            <div class="btn--container justify-content-end">
                                <button type="reset" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                                <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.submit')); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header py-2 border-0">
                        <div class="search--button-wrapper">
                            <h5 class="card-title">
                                <?php echo e(translate('messages.attribute_list')); ?><span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($attributes->total()); ?></span>
                            </h5>
                            <form  class="search-form">
                                <!-- Search -->

                                <div class="input-group input--group">
                                    <input id="datatableSearch_" value="<?php echo e(request()?->search ?? null); ?>" type="search" name="search" class="form-control"
                                            placeholder="<?php echo e(translate('ex_:_attribute_name')); ?>" aria-label="Search" >
                                    <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                                </div>
                                <!-- End Search -->
                            </form>
                            <?php if(request()->get('search')): ?>
                            <button type="reset" class="btn btn--primary ml-2 location-reload-to-base" data-url="<?php echo e(url()->full()); ?>"><?php echo e(translate('messages.reset')); ?></button>
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
                                    <a id="export-excel" class="dropdown-item" href="<?php echo e(route('admin.attribute.export-attributes', ['type'=>'excel' , request()->getQueryString() ])); ?>">
                                        <img class="avatar avatar-xss avatar-4by3 mr-2"
                                            src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                            alt="Image Description">
                                        <?php echo e(translate('messages.excel')); ?>

                                    </a>
                                    <a id="export-csv" class="dropdown-item" href="<?php echo e(route('admin.attribute.export-attributes', ['type'=>'csv' , request()->getQueryString() ])); ?>">
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
                            <tr class="text-center">
                                <th class="border-0"><?php echo e(translate('sl')); ?></th>
                                <th class="border-0"><?php echo e(translate('ID')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.name')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.action')); ?></th>
                            </tr>

                            </thead>

                            <tbody id="set-rows">
                            <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-center">
                                        <span class="mr-3">
                                            <?php echo e($key+$attributes->firstItem()); ?>

                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="mr-3">
                                            <?php echo e($attribute['id']); ?>

                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span title="<?php echo e($attribute['name']); ?>" class="font-size-sm text-body mr-3">
                                            <?php echo e(Str::limit($attribute['name'],20,'...')); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route('admin.attribute.edit',[$attribute['id']])); ?>" title="<?php echo e(translate('messages.edit')); ?>"><i class="tio-edit"></i>
                                            </a>
                                            <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:" data-id="attribute-<?php echo e($attribute['id']); ?>" data-message="<?php echo e(translate('Want to delete this attribute ?')); ?>" title="<?php echo e(translate('messages.delete')); ?>"><i class="tio-delete-outlined"></i></a>
                                            <form action="<?php echo e(route('admin.attribute.delete',[$attribute['id']])); ?>"
                                                    method="post" id="attribute-<?php echo e($attribute['id']); ?>">
                                                <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if(count($attributes) !== 0): ?>
                    <hr>
                    <?php endif; ?>
                    <div class="page-area">
                        <?php echo $attributes->links(); ?>

                    </div>
                    <?php if(count($attributes) === 0): ?>
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
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/attribute-index.js"></script>
    <script>
        "use strict";

        $(".lang_link").click(function(e){
            e.preventDefault();
            $(".lang_link").removeClass('active');
            $(".lang_form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.substring(0, form_id.length - 5);
            console.log(lang);
            $("#"+lang+"-form").removeClass('d-none');
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/attribute/index.blade.php ENDPATH**/ ?>