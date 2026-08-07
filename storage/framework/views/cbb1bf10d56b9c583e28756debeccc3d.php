<?php $__env->startSection('title',translate('messages.Campaign List')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-notice"></i> <?php echo e(translate('messages.item_campaign')); ?> <span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($campaigns->total()); ?></span></h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <!-- Card -->
                <div class="card">
                    <div class="card-header py-2 border-0">
                        <h5 class="card-title"></h5>
                        <form id="search-form">
                            <?php echo csrf_field(); ?>
                            <!-- Search -->
                            <div class="input--group input-group input-group-merge input-group-flush">
                                <input id="datatableSearch" type="search" name="search" class="form-control" placeholder=" <?php echo e(translate('messages.Search by title')); ?>" aria-label="<?php echo e(translate('messages.search_here')); ?>">
                                <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                            </div>
                            <!-- End Search -->
                        </form>
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
                                <th><?php echo e(translate('messages.sl')); ?></th>
                                <th ><?php echo e(translate('messages.title')); ?></th>
                                <th ><?php echo e(translate('messages.date')); ?></th>
                                <th ><?php echo e(translate('messages.time')); ?></th>
                                <th ><?php echo e(translate('messages.price')); ?></th>
                            </tr>

                            </thead>

                            <tbody id="set-rows">
                            <?php $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key+$campaigns->firstItem()); ?></td>
                                    <td>
                                        <span class="d-block text-body"><?php echo e(Str::limit($campaign['title'],25,'...')); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <span class="bg-gradient-light text-dark"><?php echo e($campaign->start_date?$campaign->start_date->format('d M, Y'). ' - ' .$campaign->end_date->format('d M, Y'): 'N/A'); ?></span>
                                    </td>
                                    <td>
                                        <span class="bg-gradient-light text-dark"><?php echo e($campaign->start_time?$campaign->start_time->format(config('timeformat')). ' - ' .$campaign->end_time->format(config('timeformat')): 'N/A'); ?></span>
                                    </td>
                                    <td><?php echo e(\App\CentralLogics\Helpers::format_currency($campaign->price)); ?></td>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <div class="page-area px-4 pb-3">
                            <div class="d-flex align-items-center justify-content-end">
                                <div>
                                    <?php echo $campaigns->links(); ?>

                                </div>
                            </div>
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

        "use strict";
        $('#search-form').on('submit', function (event) {
            event.preventDefault();
            let formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '<?php echo e(route('vendor.campaign.searchItem')); ?>',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('#itemCount').html(data.count);
                    $('.page-area').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/campaign/item_list.blade.php ENDPATH**/ ?>