<?php $__env->startSection('title',translate('messages.units')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/category.png')); ?>" class="w--20" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.add_new_unit')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="row g-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo e(route('admin.unit.store')); ?>" method="post">
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
                                            <input type="text" name="unit[]" id="default_title"
                                                class="form-control" placeholder="<?php echo e(translate('messages.unit_name')); ?>" maxlength="191"

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
                                                    <input type="text" name="unit[]" id="<?php echo e($lang); ?>_title"
                                                        class="form-control" placeholder="<?php echo e(translate('messages.unit_name')); ?>" maxlength="191"
                                                         >
                                                </div>
                                                <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <div id="default-form">
                                            <div class="form-group">
                                                <label class="input-label"
                                                    for="exampleFormControlInput1"><?php echo e(translate('messages.name')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                                <input type="text" name="unit[]" class="form-control"
                                                    placeholder="<?php echo e(translate('messages.unit_name')); ?>" maxlength="191" required>
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
                                <?php echo e(translate('messages.unit_list')); ?><span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($units->total()); ?></span></h5>
                            <form class="search-form">
                                <!-- Search -->

                                <div class="input-group input--group">
                                    <input id="datatableSearch_" type="search" name="search" class="form-control"  value="<?php echo e(request()?->search); ?>"
                                            placeholder="<?php echo e(translate('messages.search_unit')); ?>" aria-label="Search" >
                                    <button type="submit" class="btn btn--secondary">
                                        <i class="tio-search"></i>
                                    </button>
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
                                    <a id="export-excel" class="dropdown-item" href="<?php echo e(route('admin.unit.export', ['type'=>'excel',request()->getQueryString()])); ?>">
                                        <img class="avatar avatar-xss avatar-4by3 mr-2"
                                            src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                            alt="Image Description">
                                        <?php echo e(translate('messages.excel')); ?>

                                    </a>
                                    <a id="export-csv" class="dropdown-item" href="<?php echo e(route('admin.unit.export', ['type'=>'csv',request()->getQueryString()])); ?>">
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
                                <th class="border-0"><?php echo e(translate('messages.unit')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.action')); ?></th>
                            </tr>

                            </thead>

                            <tbody id="set-rows"  class="text-center">
                            <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key+$units->firstItem()); ?></td>
                                    <td>
                                    <span title="<?php echo e($unit['unit']); ?>" class="d-block font-size-sm text-body">
                                        <?php echo e(Str::limit($unit['unit'],20,'...')); ?>

                                    </span>
                                    </td>
                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route('admin.unit.edit',[$unit['id']])); ?>" title="<?php echo e(translate('messages.edit')); ?>"><i class="tio-edit"></i>
                                            </a>
                                            <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:" data-id="unit-<?php echo e($unit['id']); ?>" data-message="<?php echo e(translate('Want to delete this unit ?')); ?>" title="<?php echo e(translate('messages.delete')); ?>"><i class="tio-delete-outlined"></i>
                                            </a>
                                            <form action="<?php echo e(route('admin.unit.destroy',[$unit['id']])); ?>"
                                                    method="post" id="unit-<?php echo e($unit['id']); ?>">
                                                <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if(count($units) !== 0): ?>
                    <hr>
                    <?php endif; ?>
                    <div class="page-area">
                        <?php echo $units->links(); ?>

                    </div>
                    <?php if(count($units) === 0): ?>
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

    <script>
        "use strict";
        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            let datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

            $('#column1_search').on('keyup', function () {
                datatable
                    .columns(1)
                    .search(this.value)
                    .draw();
            });


            $('#column3_search').on('change', function () {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                let select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });

        $('#search-form').on('submit', function () {
            let formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '<?php echo e(route('admin.unit.search')); ?>',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('.page-area').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/unit/index.blade.php ENDPATH**/ ?>