<?php $__env->startSection('title',translate('Campaign List')); ?>


<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <h1 class="page-header-title">
                    <span class="page-header-icon">
                        <img src="<?php echo e(asset('public/assets/admin/img/campaign.png')); ?>" class="w--26" alt="">
                    </span>
                    <span>
                        <?php echo e(translate('messages.campaign')); ?>

                    </span>
                </h1>
                    <a class="btn btn--primary" href="<?php echo e(route('admin.campaign.add-new', 'item')); ?>">
                        <i class="tio-add-circle"></i> <?php echo e(translate('messages.add_new_campaign')); ?>

                    </a>
            </div>
        </div>
        <!-- End Page Header -->
        <!-- Card -->
        <div class="card">
            <div class="card-header border-0 py-2">
                <div class="search--button-wrapper">
                    <h5 class="card-title"><?php echo e(translate('messages.campaign_list')); ?><span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($campaigns->total()); ?></span></h5>
                    <form class="search-form min--270">

                        <!-- Search -->
                        <div class="input-group input--group">
                            <input id="datatableSearch" type="search" value="<?php echo e(request()?->search ?? null); ?>" name="search" class="form-control" placeholder="<?php echo e(translate('messages.Ex:_Campaign title...')); ?>" aria-label="<?php echo e(translate('messages.search_here')); ?>">
                            <button type="submit" class="btn btn--secondary">
                                <i class="tio-search"></i>
                            </button>
                        </div>
                        <!-- End Search -->
                    </form>

                    <?php if(request()->get('search')): ?>
                    <button type="reset" class="btn btn--primary ml-2 location-reload-to-base" data-url="<?php echo e(url()->full()); ?>"><?php echo e(translate('messages.reset')); ?></button>
                    <?php endif; ?>


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
                            <a id="export-excel" class="dropdown-item" href="
                                <?php echo e(route('admin.campaign.item_campaign_export', ['type' => 'excel', request()->getQueryString()])); ?>

                                ">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                    alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item" href="
                            <?php echo e(route('admin.campaign.item_campaign_export', ['type' => 'csv', request()->getQueryString()])); ?>">
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
                <!-- Table -->
                <div class="table-responsive datatable-custom">
                    <table id="columnSearchDatatable"
                        class="font-size-sm table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                        data-hs-datatables-options='{
                            "order": [],
                            "orderCellsTop": true,
                            "paging":false
                        }'>
                        <thead class="thead-light">
                        <tr>
                            <th class="border-0"><?php echo e(translate('sl')); ?></th>
                            <th class="border-0" ><?php echo e(translate('messages.title')); ?></th>
                            <th class="border-0" ><?php echo e(translate('messages.date')); ?></th>
                            <th class="border-0" ><?php echo e(translate('messages.time')); ?></th>
                            <th class="border-0" ><?php echo e(translate('messages.price')); ?></th>
                            <th class="border-0 text-center"><?php echo e(translate('messages.status')); ?></th>
                            <th class="border-0 text-center"><?php echo e(translate('messages.action')); ?></th>
                        </tr>

                        </thead>

                        <tbody id="set-rows">
                        <?php $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($key+$campaigns->firstItem()); ?></td>
                                <td>
                                    <a href="<?php echo e(route('admin.campaign.view',['item',$campaign->id])); ?>" title="<?php echo e($campaign['title']); ?>" class="d-block text-body" ><?php echo e(Str::limit($campaign['title'],25,'...')); ?></a>
                                </td>
                                <td>
                                    <span class="bg-gradient-light text-dark"><?php echo e($campaign->start_date? \App\CentralLogics\Helpers::date_format($campaign?->start_date).'-'.  \App\CentralLogics\Helpers::date_format($campaign?->end_date): 'N/A'); ?></span>
                                </td>
                                <td>
                                    <span class="bg-gradient-light text-dark"><?php echo e($campaign->start_time? \App\CentralLogics\Helpers::time_format($campaign?->start_time).'-'.  \App\CentralLogics\Helpers::time_format($campaign?->end_time): 'N/A'); ?></span>
                                </td>
                                <td><?php echo e(\App\CentralLogics\Helpers::format_currency($campaign->price)); ?></td>
                                <td>
                                    <div class="d-flex flex-wrap justify-content-center">
                                        <label class="toggle-switch toggle-switch-sm" for="campaignCheckbox<?php echo e($campaign->id); ?>">
                                            <input type="checkbox"  class="toggle-switch-input  dynamic-checkbox"
                                            data-id="campaignCheckbox<?php echo e($campaign->id); ?>"
                                            data-type="status"
                                            data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/basic_campaign_on.png')); ?>"
                                            data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/basic_campaign_off.png')); ?>"
                                            data-title-on="<?php echo e(translate('By_Turning_ON_Campaign!')); ?>"
                                            data-title-off="<?php echo e(translate('By_Turning_OFF_Campaign!')); ?>"
                                            data-text-on="<p><?php echo e(translate('Turned_on_to_customer_website_and_apps._Are_you_sure_you_want_to_turn_on_the_campaign_already_inactive.')); ?></p>"
                                            data-text-off="<p><?php echo e(translate('Turned_off_to_customer_website_and_apps._Are_you_sure_you_want_to_turn_off_the_campaign_already_active')); ?></p>"
                                            id="campaignCheckbox<?php echo e($campaign->id); ?>" <?php echo e($campaign->status?'checked':''); ?>>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </div>
                                </td>

                                <form action="<?php echo e(route('admin.campaign.status',['item',$campaign['id'],$campaign->status?0:1])); ?>"
                                    method="get" id="campaignCheckbox<?php echo e($campaign->id); ?>_form">
                                    </form>
                                <td>
                                    <div class="btn--container justify-content-center">
                                        <a class="btn action-btn btn--primary btn-outline-primary"
                                            href="<?php echo e(route('admin.campaign.edit',['item',$campaign['id']])); ?>" title="<?php echo e(translate('messages.edit_campaign')); ?>"><i class="tio-edit"></i>
                                        </a>
                                        <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:"
                                            data-id="campaign-<?php echo e($campaign['id']); ?>" data-message="<?php echo e(translate('Want to delete this item ?')); ?>" title="<?php echo e(translate('messages.delete_campaign')); ?>"><i class="tio-delete-outlined"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.campaign.delete-item',[$campaign['id']])); ?>"
                                                    method="post" id="campaign-<?php echo e($campaign['id']); ?>">
                                            <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                    <?php if(count($campaigns) !== 0): ?>
                    <hr>
                    <?php endif; ?>
                    <div class="page-area">
                        <?php echo $campaigns->links(); ?>

                    </div>
                    <?php if(count($campaigns) === 0): ?>
                    <div class="empty--data">
                        <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                        <h5>
                            <?php echo e(translate('no_data_found')); ?>

                        </h5>
                    </div>
                    <?php endif; ?>
                <!-- End Table -->
            </div>
        </div>
        <!-- End Card -->
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
                    .search(this.value)
                    .draw();
            });

            $('#column2_search').on('keyup', function () {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });

            $('#column3_search').on('change', function () {
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

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/campaign/item/list.blade.php ENDPATH**/ ?>