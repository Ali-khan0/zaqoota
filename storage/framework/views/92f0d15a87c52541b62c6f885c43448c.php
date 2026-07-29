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
                <a class="btn btn--primary" href="<?php echo e(route('admin.campaign.add-new', 'basic')); ?>">
                    <i class="tio-add-circle"></i> <?php echo e(translate('messages.add_new_campaign')); ?>

                </a>
            </div>
        </div>
        <!-- End Page Header -->
        <!-- Card -->
        <div class="card">
            <div class="card-header py-2 border-0">
                <div class="search--button-wrapper">
                    <h5 class="card-title">
                        <?php echo e(translate('messages.campaign_list')); ?>

                        <span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($campaigns->total()); ?></span>
                    </h5>
                    <form class="search-form">

                        <!-- Search -->
                        <div class="input-group input--group">
                            <input id="datatableSearch" type="search" name="search"  value="<?php echo e(request()?->search ?? null); ?>" class="form-control" placeholder="<?php echo e(translate('messages.Ex:_Search Title ...')); ?>" aria-label="Search here">
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
                            <a id="export-excel" class="dropdown-item" href="
                                <?php echo e(route('admin.campaign.basic_campaign_export', ['type' => 'excel', request()->getQueryString()])); ?>

                                ">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                    alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item" href="
                            <?php echo e(route('admin.campaign.basic_campaign_export', ['type' => 'csv', request()->getQueryString()])); ?>">
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
                        class="font-size-sm table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                        data-hs-datatables-options='{
                            "order": [],
                            "orderCellsTop": true,
                            "paging":false
                        }'>
                    <thead class="thead-light">
                    <tr>
                        <th class="border-0"><?php echo e(translate('messages.#')); ?></th>
                        <th class="border-0" ><?php echo e(translate('messages.title')); ?></th>
                        <th class="border-0" ><?php echo e(translate('messages.date_duration')); ?></th>
                        <th class="border-0" ><?php echo e(translate('messages.time_duration')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.status')); ?></th>
                        <th class="border-0 text-center"><?php echo e(translate('messages.action')); ?></th>
                    </tr>
                    </thead>

                    <tbody id="set-rows">
                    <?php $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+$campaigns->firstItem()); ?></td>
                            <td>
                                <a href="<?php echo e(route('admin.campaign.view',['basic',$campaign->id])); ?>" title="<?php echo e($campaign['title']); ?>" class="d-block text-body"><?php echo e(Str::limit($campaign['title'],25, '...')); ?></a>
                            </td>
                            <td>
                                <span class="bg-gradient-light text-dark"><?php echo e($campaign->start_date? \App\CentralLogics\Helpers::date_format($campaign?->start_date).'-'.  \App\CentralLogics\Helpers::date_format($campaign?->end_date): 'N/A'); ?></span>
                            </td>
                            <td>
                                <span class="bg-gradient-light text-dark"><?php echo e($campaign->start_time? \App\CentralLogics\Helpers::time_format($campaign?->start_time).'-'.  \App\CentralLogics\Helpers::time_format($campaign?->end_time): 'N/A'); ?></span>
                            </td>
                            <td>
                                <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox<?php echo e($campaign->id); ?>">
                                    <input type="checkbox" data-url=""
                                    data-id="stocksCheckbox<?php echo e($campaign->id); ?>"
                                    data-type="status"
                                    data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/basic_campaign_on.png')); ?>"
                                    data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/basic_campaign_off.png')); ?>"
                                    data-title-on="<?php echo e(translate('By_Turning_ON_Campaign!')); ?>"
                                    data-title-off="<?php echo e(translate('By_Turning_OFF_Campaign!')); ?>"
                                    data-text-on="<p><?php echo e(translate('If_you_turn_on_this_status,_it_will_show_on_user_website_and_app.')); ?></p>"
                                    data-text-off="<p><?php echo e(translate('If_you_turn_off_this_status,_it_won’t_show_on_user_website_and_app')); ?></p>"
                                    class="toggle-switch-input dynamic-checkbox" id="stocksCheckbox<?php echo e($campaign->id); ?>" <?php echo e($campaign->status?'checked':''); ?>>
                                    <span class="toggle-switch-label">
                                        <span class="toggle-switch-indicator"></span>
                                    </span>
                                </label>
                            </td>
                            <form action="<?php echo e(route('admin.campaign.status',['basic',$campaign['id'],$campaign->status?0:1])); ?>"
                            method="get" id="stocksCheckbox<?php echo e($campaign->id); ?>_form">
                            </form>
                            <td>
                                <div class="btn--container justify-content-center">
                                    <a class="btn action-btn btn-outline-primary btn--primary"
                                        href="<?php echo e(route('admin.campaign.edit',['basic',$campaign['id']])); ?>" title="<?php echo e(translate('messages.edit_campaign')); ?>"><i class="tio-edit"></i>
                                    </a>
                                    <a class="btn action-btn btn-outline-danger btn--danger form-alert" href="javascript:" data-id="campaign-<?php echo e($campaign['id']); ?>" data-message="<?php echo e(translate('messages.Want_to_delete_this_item')); ?>"
                                         title="<?php echo e(translate('messages.delete_campaign')); ?>"><i class="tio-delete-outlined"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.campaign.delete',[$campaign['id']])); ?>"
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
        <!-- End Card -->
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/campaign/basic/list.blade.php ENDPATH**/ ?>