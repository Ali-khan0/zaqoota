<?php $__env->startSection('title', translate('Parcel Cancellation Setup')); ?>
<?php $__env->startSection('parcel_cancellation'); ?>
    active
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div id="content-disable" class="content container-fluid">
        <div class="d-flex align-items-center mb-20 gap-2">
            <img width="22" height="22" src="<?php echo e(asset('public/assets/admin/img/parcel-cancellation-setup.png')); ?>"
                alt="cencellation-icon">
            <h2 class="mb-0 fs-24 lh-base"><?php echo e(translate('Parcel Cancellation Setup')); ?></h2>
        </div>
        <div class="card mb-20">
            <div class="card-header rounded-10 flex-sm-nowrap flex-wrap gap-2">
                <div class="max-w-700">
                    <h4 class="mb-1 text-title"><?php echo e(translate('Parcel Cancellation Feature')); ?></h4>
                    <p class="fs-12 m-0 text-title">
                        <?php echo e(translate('Enable and configure cancellation rules that apply after parcel pickup.')); ?></p>
                </div>
                
            </div>


            <?php if($parcel_cancellation_status): ?>
                <form action="<?php echo e(route('admin.parcel.cancellationSettingsUpdate')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('put'); ?>
                    <div class="card-body">
                        <div class="d-flex flex-column gap-20px">
                            <div class="row align-items-center g-3">
                                <div class="col-lg-4 col-md-5">
                                    <div class="max-w-353px">
                                        <h4 class="mb-1 text-title"><?php echo e(translate('Basic Setup')); ?></h4>
                                        <p class="fs-12 m-0 color-758590">
                                            <?php echo e(translate('Setup additional delivery cancelation fee & return fee for customer and rider.')); ?>

                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-7">
                                    <div class="__bg-FAFAFA rounded p--20">
                                        <div class="row g-3">

                                            <div class="col-sm-12">
                                                <div class="form-group m-0">
                                                    <div
                                                        class="d-flex align-items-center gap-1 justify-content-between flex-wrap mb-2">
                                                        <label for=""
                                                            class="fs-14 mb-0 color-222324"><?php echo e(translate('Return Fee (%)')); ?>

                                                         <span class="text-danger">* </span>
                                                        </label>
                                                        <label class="toggle-switch toggle-switch-sm-extra">
                                                            <input id="return_fee_status" type="checkbox" value='1'
                                                                name="return_fee_status" class="status toggle-switch-input"
                                                                <?php echo e($parcel_cancellation_basic_setup['return_fee_status'] ?? null ? 'checked' : ''); ?>>
                                                            <span class="toggle-switch-label text mb-0">
                                                                <span class="toggle-switch-indicator"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <input type="number" name='return_fee'
                                                        <?php echo e($parcel_cancellation_basic_setup['return_fee_status'] ?? null ? 'required' : ''); ?>

                                                        id="return_fee"
                                                        value="<?php echo e($parcel_cancellation_basic_setup['return_fee'] ?? ''); ?>"
                                                        min="0" max="100" step="0.01"
                                                        class="form-control bg-white <?php echo e($parcel_cancellation_basic_setup['return_fee_status'] ?? null ? '' : 'disabled'); ?>"
                                                        placeholder="Ex: 10">
                                                </div>
                                            </div>
                                            <div class="d-flex align-item-center justify-content-between cursor-pointer">
                                                <div class="form-check mr-4 m-0">
                                                    <input class="form-check-input checkbox-theme-20 single-select"
                                                        <?php echo e($parcel_cancellation_basic_setup['do_not_charge_return_fee_on_deliveryman_cancel'] ?? null ? 'checked' : ''); ?>

                                                        type="checkbox" value="1"
                                                        name="do_not_charge_return_fee_on_deliveryman_cancel"
                                                        id="cancalation_address_">
                                                </div>
                                                <label class="form-check-label ml-2 fs-14 " for="cancalation_address_">
                                                    <?php echo e(translate('Do not charge any return fee to customer if deliveryman cancel the order after pickup')); ?>

                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center g-3">
                                <div class="col-lg-4 col-md-5">
                                    <div class="max-w-353px">
                                        <h4 class="mb-1 text-title"><?php echo e(translate('Parcel Return Time & Fee')); ?></h4>
                                        <p class="fs-12 m-0 color-758590">
                                            <?php echo e(translate('When the toggle is turned ON the parcel return time and fee are activated for rider.')); ?>

                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-7">
                                    <div class="__bg-FAFAFA rounded p--20">
                                        <div class="row g-3">
                                            <div class="col-sm-12">
                                                <div
                                                    class="d-flex align-items-center justify-content-between bg-white border px-3 py-2 rounded h-45px">
                                                    <label for=""
                                                        class="fs-14 fs-14 w-100 mb-0"><?php echo e(translate('Status')); ?></label>
                                                    <label class="toggle-switch toggle-switch-sm-extra">
                                                        <input id="return_time_fee_status" name='status' type="checkbox"
                                                            class="status toggle-switch-input" value='1'
                                                            <?php echo e($parcel_return_time_fee['status'] ?? null ? 'checked' : ''); ?>>
                                                        <span class="toggle-switch-label text mb-0">
                                                            <span class="toggle-switch-indicator"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-md-12 col-lg-6">
                                                <div class="form-group m-0">
                                                    <label for="" class="fs-14 mb-2 color-222324">
                                                        <?php echo e(translate('Set Time')); ?>

                                                        <span class="fs-12 color-A7A7A7" data-toggle="tooltip"
                                                            data-placement="top"
                                                            data-original-title="<?php echo e(translate('Set Time')); ?>">
                                                            <i class="tio-info"></i>
                                                        </span>
                                                        <span class="text-danger">* </span>
                                                    </label>
                                                    <div class="d-flex align-items-center border rounded overflow-hidden">
                                                        <input type="number" name='parcel_return_time'
                                                            value="<?php echo e($parcel_return_time_fee['parcel_return_time'] ?? ''); ?>"
                                                            min="0"
                                                            class="form-control disableClass bg-white border-0 rounded-0 <?php echo e($parcel_return_time_fee['status'] ?? null ? '' : 'disabled'); ?> "
                                                            placeholder="Ex: 10">

                                                        <select name="return_time_type" id=""
                                                            class="custom-select bg-F3F4F5 w-auto border-0 rounded-0  disableClass <?php echo e($parcel_return_time_fee['status'] ?? null ? '' : 'disabled'); ?>">
                                                            <option selected value="day"><?php echo e(translate('Day')); ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-12 col-lg-6">
                                                <div class="form-group m-0">
                                                    <label for="" class="fs-14 mb-2 color-222324">
                                                        <?php echo e(translate('Return Fee for Driver if Time Exceeds ')); ?>

                                                        (<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)
                                                        <span class="fs-12 color-A7A7A7" data-toggle="tooltip"
                                                            data-placement="top"
                                                            data-original-title="<?php echo e(translate('Return Fee for Driver if Time Exceeds ')); ?>">
                                                            <i class="tio-info"></i>
                                                            <span class="text-danger">* </span>
                                                        </span>
                                                    </label>
                                                    <input type="number" name="return_fee_for_dm"
                                                        value="<?php echo e($parcel_return_time_fee['return_fee_for_dm'] ?? ''); ?>"
                                                        min="0" max="999999999" step="0.01"
                                                        class="form-control bg-white disableClass <?php echo e($parcel_return_time_fee['status'] ?? null ? '' : 'disabled'); ?>"
                                                        placeholder="Ex: 10">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn--container justify-content-end mt-4">
                            <button type="reset"
                                class="btn min-w-120px btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                            <button type="submit"
                                class="btn min-w-120px btn--primary"><?php echo e(translate('messages.save')); ?></button>
                        </div>
                    </div>
                </form>
            <?php endif; ?>

        </div>

        <form action="<?php echo e(route('admin.parcel.cancellationReason')); ?>" method="post" class="card mb-20">
            <?php echo csrf_field(); ?>
            <?php echo method_field('post'); ?>
            <div class="card-header flex-sm-nowrap flex-wrap gap-2">
                <h3 class="m-0 text-title"><?php echo e(translate('Parcel cancellation reason')); ?></h3>
            </div>
            <div class="card-body">
                <?php if($language): ?>
                    <ul class="nav nav-tabs border-0 mb-4">
                        <li class="nav-item">
                            <a class="nav-link lang_link active" href="#"
                                id="default-link"><?php echo e(translate('messages.default')); ?></a>
                        </li>
                        <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="nav-item">
                                <a class="nav-link lang_link" href="#"
                                    id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                <?php endif; ?>


                <div class="row g-3">
                    <div class="col-sm-6 lang_form" id="default-form">
                        <div class="form-group m-0">
                            <label class="fs-14 mb-2 color-222324"><?php echo e(translate('Parcel cancellation reason')); ?>

                                (<?php echo e(translate('Default')); ?>)
                                 <span class="text-danger">* </span>
                            </label>
                            <textarea rows="1" name="reason[]" data-target="#char-count"
                                class="form-control min-h-45px bg-white char-counter" maxlength="150" placeholder="Type Tittle"></textarea>
                            <div id="char-count" class="color-A7A7A7 mt-1 fs-14 text-right">0/150</div>
                            <input type="hidden" name="lang[]" value="default">
                        </div>
                    </div>

                    <?php if($language): ?>
                        <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-sm-6  lang_form d-none" id="<?php echo e($lang); ?>-form">
                                <label class="fs-14 mb-2 color-222324 "><?php echo e(translate('Parcel cancellation reason')); ?>

                                    (<?php echo e(strtoupper($lang)); ?>)
                                     <span class="text-danger">* </span>
                                </label>
                                <textarea rows="1" name="reason[]" data-target="#feedback-count-<?php echo e($lang); ?>"
                                    class="form-control min-h-45px bg-white char-counter" maxlength="150" placeholder="Type Tittle"></textarea>
                                <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                <div id="feedback-count-<?php echo e($lang); ?>" class="color-A7A7A7 mt-1 fs-14 text-right">
                                    0/150</div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    <div class="col-sm-6 col-lg-3">
                        <div class="form-group m-0">
                            <label for="" class="fs-14 mb-2 color-222324">
                                <?php echo e(translate('Cancellation type')); ?>

                                 <span class="text-danger">* </span>
                            </label>
                            <select name="cancellation_type" required id=""
                                class="custom-select fs-12 title-clr">
                                <option value="" selected disabled><?php echo e(translate('Select Cancellation Type')); ?>

                                </option>
                                <option value="before_pickup"><?php echo e(translate('before_pickup')); ?></option>
                                <option value="after_pickup"><?php echo e(translate('after_pickup')); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="form-group m-0">
                            <label for="" class="fs-14 mb-2 color-222324">
                                <?php echo e(translate('User Type')); ?>

                                 <span class="text-danger">* </span>
                            </label>
                            <select name="user_type" required id="" class="custom-select fs-12 title-clr">
                                <option value="" selected disabled><?php echo e(translate('Select User Type')); ?></option>
                                <option value="customer"><?php echo e(translate('Customer')); ?></option>
                                
                                
                                <option value="deliveryman"><?php echo e(translate('Deliveryman')); ?></option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="btn--container justify-content-end mt-4">
                    <button type="reset" class="btn min-w-120px btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                    <button type="submit"
                        class="btn min-w-120px btn--primary"><?php echo e(translate('messages.submit')); ?></button>
                </div>
            </div>
        </form>

        <div class="card border-0">
            <div class="card-header border-0 flex-wrap gap-2">
                <h4 class="title-clr m-0"><?php echo e(translate('messages.parcel_cancellation_reason')); ?></h4>
                <div class="d-flex align-items-center flex-wrap gap-3">
                    <form class="search-form w-340-lg">
                        <div class="input-group input--group">
                            <input name="search" type="search" class="form-control" placeholder="Search by Reason"
                                value="<?php echo e(request()->get('search') ?? ''); ?>">
                            <button type="submit" class="btn btn--primary"><i class="tio-search"></i></button>
                        </div>
                    </form>
                    <div class="hs-unfold mr-2">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white text-title font-medium dropdown-toggle min-height-40"
                            href="javascript:;"
                            data-hs-unfold-options='{
                                "target": "#usersExportDropdown",
                                "type": "css-animation"
                            }'>
                            <i class="tio-download-to mr-1 text-title"></i> <?php echo e(translate('messages.export')); ?>

                        </a>
                        <div id="usersExportDropdown"
                            class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">
                            <span class="dropdown-header"><?php echo e(translate('messages.download_options')); ?></span>
                            <a id="export-excel" class="dropdown-item"
                                href="<?php echo e(route('admin.parcel.cancellationReasonExport', ['type' => 'excel', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                    alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item"
                                href="<?php echo e(route('admin.parcel.cancellationReasonExport', ['type' => 'csv', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                    alt="Image Description">
                                .<?php echo e(translate('messages.csv')); ?>

                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table m-0 table-borderless table-thead-bordered table-nowrap table-align-middle">
                    <thead class="bg-table-head">
                        <tr>
                            <th class="fs-14 text-title font-semibold top-border-table">
                                <?php echo e(translate('SL')); ?>

                            </th>
                            <th class="fs-14 text-title font-semibold top-border-table">
                                <?php echo e(translate('messages.reason')); ?>

                            </th>
                            <th class="fs-14 text-title font-semibold top-border-table">
                                <?php echo e(translate('messages.cancellation_type')); ?>

                            </th>
                            <th class="fs-14 text-title font-semibold top-border-table">
                                <?php echo e(translate('messages.user_type')); ?>

                            </th>
                            <th class="fs-14 text-title font-semibold top-border-table">
                                <?php echo e(translate('messages.status')); ?>

                            </th>
                            <th class="fs-14 text-center text-title font-semibold top-border-table">
                                <?php echo e(translate('messages.action')); ?>

                            </th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php $__currentLoopData = $cancellationReasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="p-3 fs-14 title-clr font-medium"><?php echo e($key + $cancellationReasons->firstItem()); ?>

                                </td>
                                <td class="p-3">
                                    <div class="max-w-700 fs-14 title-clr font-medium min-w-140">
                                        <?php echo e(Str::limit($item->reason, 25, '...')); ?>

                                    </div>
                                </td>
                                <td class="p-3 fs-14 title-clr font-medium min-w-140">
                                    <?php echo e(translate($item->cancellation_type)); ?></td>
                                <td class="p-3 fs-14 title-clr font-regular min-w-140"><?php echo e(translate($item->user_type)); ?>

                                </td>
                                <td class="p-3">
                                    <label class="toggle-switch toggle-switch-sm">
                                        <input type="checkbox" class="status toggle-switch-input redirect-url"
                                            data-url="<?php echo e(route('admin.parcel.cancellationReasonStatus', [$item->id])); ?>"
                                            <?php echo e($item->status == 1 ? 'checked' : ''); ?>>
                                        <span class="toggle-switch-label text mb-0">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                    </label>
                                </td>
                                <td class="p-3">
                                    <div class="btn--container justify-content-center">

                                        <a class="btn btn-sm text-end action-btn btn-outline-theme-dark text--info info-hover offcanvas-trigger get_data data-info-show"
                                            data-target="#offcanvas__customBtn3" data-id="<?php echo e($item['id']); ?>"
                                            data-url="<?php echo e(route('admin.parcel.cancellationReasonEdit', [$item['id']])); ?>"
                                            href="javascript:" title="<?php echo e(translate('messages.edit_reason')); ?>"><i
                                                class="tio-edit"></i></a>


                                        <a class="btn action-btn btn--danger btn-outline-danger form-alert"
                                            href="javascript:" data-id="reason-<?php echo e($item['id']); ?>"
                                            data-message="<?php echo e(translate('Want to delete this cancellation reason?')); ?>"
                                            title="<?php echo e(translate('messages.delete_cancellation_reason')); ?>"><i
                                                class="tio-delete-outlined"></i>
                                        </a>

                                        <form action="<?php echo e(route('admin.parcel.cancellationReasonDelete', [$item['id']])); ?>"
                                            method="post" id="reason-<?php echo e($item['id']); ?>">
                                            <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>
                </table>
            </div>
            <?php if(count($cancellationReasons) !== 0): ?>
                <hr>
            <?php endif; ?>
            <div class="page-area">
                <?php echo $cancellationReasons->withQueryString()->links(); ?>

            </div>
            <?php if(count($cancellationReasons) === 0): ?>
                <div class="empty--data">
                    <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                    <h5>
                        <?php echo e(translate('no_data_found')); ?>

                    </h5>
                </div>
            <?php endif; ?>
        </div>
    </div>



    

    <!-- Parcel Cancellation Modal -->
    

    <div id="offcanvas__customBtn3" class="custom-offcanvas d-flex flex-column justify-content-between">
        <div id="data-view" class="h-100">
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script>
        initCharCounter();
        $('#return_fee_status').on('click', function() {
            if ($('#return_fee_status').is(':checked')) {
                $('#return_fee').removeClass('disabled').prop('required', true);
            } else {
                $('#return_fee').addClass('disabled').prop('required', false);
            }
        });
        $('#return_time_fee_status').on('click', function() {
            if ($('#return_time_fee_status').is(':checked')) {
                $('.disableClass').removeClass('disabled').prop('required', true);
            } else {
                $('.disableClass').addClass('disabled').prop('required', false);
            }
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
                    console.log(data);

                    $("#data-view").append(data.view);
                    initLangTabs();
                    initCharCounter();
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

        $('.offcanvas-trigger').on('click', function(e) {
            e.preventDefault();
            var target = $(this).data('target');
            $(target).addClass('open');
            $('#offcanvasOverlay').addClass('show');

        });

        function initSelect2Dropdowns() {
            $('.offcanvas-close, #offcanvasOverlay').on('click', function() {
                $('.custom-offcanvas').removeClass('open');
                $('#offcanvasOverlay').removeClass('show');
                $('#content-disable').removeClass('disabled');
            });
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/parcel/parcel-cancellation-setup.blade.php ENDPATH**/ ?>