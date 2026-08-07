<?php $__env->startSection('title',translate('messages.Campaign List')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php ($store_id = \App\CentralLogics\Helpers::get_store_id()); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/campaign.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.campaign_list')); ?><span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($campaigns->total()); ?></span>
                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <!-- Card -->
        <div class="card">
            <div class="card-header border-0 justify-content-end ">
                <form  class="min--250">
                    <?php echo csrf_field(); ?>
                    <!-- Search -->
                    <div class="input-group input--group">
                        <input id="datatableSearch_"  value="<?php echo e(request()?->search ?? ''); ?>" type="search" name="search" class="form-control" placeholder="<?php echo e(translate('messages.ex_search_name')); ?>" aria-label="<?php echo e(translate('messages.search')); ?>">
                        <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                    </div>
                    <!-- End Search -->
                </form>
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
                        <tr>
                            <th class="border-0"><?php echo e(translate('messages.#')); ?></th>
                            <th class="border-0 w-30p"><?php echo e(translate('messages.title')); ?></th>
                            <th class="border-0 w-25p"><?php echo e(translate('messages.image')); ?></th>
                            <th class="border-0 w-25p"><?php echo e(translate('messages.date_duration')); ?></th>
                            <th class="border-0 w-25p"><?php echo e(translate('messages.time_duration')); ?></th>
                            <th class="border-0 text-center"><?php echo e(translate('messages.status')); ?></th>
                            <th class="border-0 text-center"><?php echo e(translate('messages.action')); ?></th>
                        </tr>
                    </thead>

                    <tbody id="set-rows">
                    <?php $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+$campaigns->firstItem()); ?></td>
                            <td>
                                <span class="d-block font-size-sm text-body">
                                    <?php echo e(Str::limit($campaign['title'],25,'...')); ?>

                                </span>
                            </td>
                            <td>
                                <div class="overflow-hidden">
                                    <img class="img--vertical max--200 mw--200 onerror-image" src="<?php echo e($campaign['image_full_url']); ?>"
                                         data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>"  alt="image">
                                </div>
                            </td>
                            <td>
                                <span class="bg-gradient-light text-dark"><?php echo e($campaign->start_date?$campaign->start_date->format('d M, Y'). ' - ' .$campaign->end_date->format('d M, Y'): 'N/A'); ?></span>
                            </td>
                            <td>
                                <span class="bg-gradient-light text-dark"><?php echo e($campaign->start_time?date(config('timeformat'),strtotime($campaign->start_time)). ' - ' .date(config('timeformat'),strtotime($campaign->end_time)): 'N/A'); ?></span>
                            </td>
                            <?php
                            $store_ids = [];
                            $store_status = '--';
                            foreach($campaign->stores as $store)
                                {
                                    if ($store->id == $store_id && $store->pivot) {
                                        $store_status = $store->pivot->campaign_status;
                                    }
                                    $store_ids[] = $store->id;
                                }
                             ?>
                            <td class="text-capitalize">
                                <?php if($store_status == 'pending'): ?>
                                    <span class="badge badge-soft-info">
                                        <?php echo e(translate('messages.not_approved')); ?>

                                    </span>
                                <?php elseif($store_status == 'confirmed'): ?>
                                    <span class="badge badge-soft-success">
                                        <?php echo e(translate('messages.confirmed')); ?>

                                    </span>
                                <?php elseif($store_status == 'rejected'): ?>
                                    <span class="badge badge-soft-danger">
                                        <?php echo e(translate('messages.rejected')); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-soft-info">
                                        <?php echo e(translate(str_replace('_', ' ', $store_status))); ?>

                                    </span>
                                <?php endif; ?>

                            </td>
                            <td class="text-center">
                                <?php if($store_status == 'rejected'): ?>
                                    <span class="badge badge-pill badge-danger"><?php echo e(translate('Rejected')); ?></span>
                                <?php else: ?>
                                    <?php if(in_array($store_id,$store_ids)): ?>

                                    <span type="button"
                                          data-id="campaign-<?php echo e($campaign['id']); ?>"
                                          data-message="<?php echo e(translate('messages.alert_store_out_from_campaign')); ?>"
                                          title="You are already joined. Click to out from the campaign." class="badge btn--danger text-white  form-alert "><?php echo e(translate('messages.leave')); ?></span>
                                    <form action="<?php echo e(route('vendor.campaign.remove-store',[$campaign['id'],$store_id])); ?>"
                                            method="GET" id="campaign-<?php echo e($campaign['id']); ?>">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                    <?php else: ?>
                                    <span type="button" class="badge btn--primary text-white form-alert"
                                          data-id="campaign-<?php echo e($campaign['id']); ?>"
                                          data-message="<?php echo e(translate('messages.alert_store_join_campaign')); ?>"
                                        title="Click to join the campaign"><?php echo e(translate('messages.join')); ?></span>
                                    <form action="<?php echo e(route('vendor.campaign.add-store',[$campaign['id'],$store_id])); ?>"
                                            method="GET" id="campaign-<?php echo e($campaign['id']); ?>">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php if(count($campaigns) !== 0): ?>
                <hr>
                <?php endif; ?>
                <table class="page-area">
                    <tfoot>
                    <?php echo $campaigns->links(); ?>

                    </tfoot>
                </table>
                <?php if(count($campaigns) === 0): ?>
                <div class="empty--data">
                    <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                    <h5>
                        <?php echo e(translate('no_data_found')); ?>

                    </h5>
                </div>
                <?php endif; ?>
            </div>
            <!-- End Table -->
        </div>
        <!-- End Card -->
    </div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/campaign/list.blade.php ENDPATH**/ ?>