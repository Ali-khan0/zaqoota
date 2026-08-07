<?php $__env->startSection('title',translate('Banner View')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-6">
                    <h1 class="page-header-title"><?php echo e($banner->title); ?></h1>
                </div>
                <div class="col-6">
                    <a href="<?php echo e(url()->previous()); ?>" class="btn btn-primary float-right">
                        <i class="tio-back-ui"></i> <?php echo e(translate('messages.back')); ?>

                    </a>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <!-- Card -->
        <div class="card mb-3 mb-lg-5">
            <!-- Body -->
            <div class="card-body">
                <div class="row align-items-md-center gx-md-5">
                    <div class="col-md-auto mb-3 mb-md-0">
                        <div class="d-flex align-items-center">
                            <img class="avatar avatar-xxl avatar-4by3 mr-4 onerror-image"
                            src="<?php echo e($banner->image_full_url); ?>"
                                 data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                                 alt="Image Description">
                            <div class="d-block">


                            </div>
                        </div>
                    </div>

                    <div class="col-md">
                        <h4><?php echo e(translate('messages.short_description')); ?> : </h4>
                        <p><?php echo e($banner->description); ?></p>
                    </div>

                </div>
            </div>
            <!-- End Body -->
        </div>
        <!-- End Card -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <!-- Card -->
                <div class="card">
                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table id="columnSearchDatatable"
                               class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                               data-hs-datatables-options='{
                                 "order": [],
                                 "orderCellsTop": true
                               }'>
                            <thead class="thead-light">
                            <tr>
                                <th><?php echo e(translate('messages.#')); ?></th>
                                <th class="w--15"><?php echo e(translate('messages.logo')); ?></th>
                                <th class="w--2"><?php echo e(translate('messages.name')); ?></th>
                                <th class="w--25"><?php echo e(translate('messages.store')); ?></th>
                                <th><?php echo e(translate('messages.email')); ?></th>
                                <th><?php echo e(translate('messages.phone')); ?></th>
                                <th><?php echo e(translate('messages.action')); ?></th>
                            </tr>
                            <tr>
                                <th colspan="3">
                                    <form action="<?php echo e(route('admin.banner.addstore',$banner->id)); ?>" id="store-add-form" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <!-- Search -->
                                        <div class="row">
                                            <div class="input-group-prepend col-md-7">
                                            <?php ($allstores=App\Models\Store::all()); ?>
                                                <select name="store_id" id="store_id" class="form-control">
                                                    <?php $__empty_1 = true; $__currentLoopData = $allstores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <?php if(!in_array($store->id, $store_ids)): ?>
                                                    <option value="<?php echo e($store->id); ?>" ><?php echo e($store->name); ?></option>
                                                    <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <option value=""><?php echo e(translate('messages.no_data_found')); ?></option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn--primary col-md-5"><?php echo e(translate('messages.add_store')); ?></button>

                                        </div>
                                        <!-- End Search -->
                                    </form>
                                </th>
                                <th></th>
                                <th colspan="3">
                                    <form action="javascript:" id="search-form">
                                        <!-- Start Search -->
                                        <div class="input-group input--group">
                                            <input id="datatableSearch_" type="search" name="search" class="form-control" placeholder="<?php echo e(translate('messages.search')); ?>" aria-label="Search" required>
                                            <button type="submit" class="btn btn--secondary">
                                                <i class="tio-search"></i>
                                            </button>
                                        </div>
                                        <!-- End Search -->
                                    </form>
                                </th>

                                <th></th>
                                <th></th>
                            </tr>
                            </thead>

                            <tbody id="set-rows">
                            <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$dm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key+1); ?></td>
                                    <td>
                                        <div class="inline--1">
                                            <img class="img--60 img--circle onerror-image"
                                                 data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
                                                 src="<?php echo e($dm['logo_full_url']); ?>"
>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="d-block font-size-sm text-body">
                                            <?php echo e($dm->name); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <span class="d-block font-size-sm text-body">
                                            <?php echo e($dm->vendor->f_name.' '.$dm->vendor->l_name); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <?php echo e($dm->email); ?>

                                        
                                    </td>
                                    <td>
                                        <?php echo e($dm['phone']); ?>

                                    </td>
                                    <td>
                                        <!-- Dropdown -->
                                        <div class="inline--2 redirect-url"
                                                 data-url="<?php echo e(route('admin.banner.campaign',[$banner->id, $dm['id']])); ?>">
                                                <span class="legend-indicator bg-danger"></span><?php echo e(translate('messages.remove')); ?>

                                            </div>
                                        <!-- End Dropdown -->
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <hr>

                        <div class="page-area">
                            <table>
                                <tfoot>
                                <?php echo $stores->links(); ?>

                                </tfoot>
                            </table>
                        </div>

                    </div>
                    <!-- End Table -->
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script>
        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            var datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

            $('#column1_search').on('keyup', function () {
                datatable
                    .columns(1)
                    .search(this.value)
                    .draw();
            });

            $('#column2_search').on('keyup', function () {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });

            $('#column3_search').on('keyup', function () {
                datatable
                    .columns(3)
                    .search(this.value)
                    .draw();
            });

            $('#column4_search').on('keyup', function () {
                datatable
                    .columns(4)
                    .search(this.value)
                    .draw();
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>

    <script>

        $('#search-form').on('submit', function () {
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '<?php echo e(route('admin.store.search')); ?>',
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

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/banner/view.blade.php ENDPATH**/ ?>