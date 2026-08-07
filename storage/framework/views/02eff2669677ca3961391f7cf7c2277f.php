<?php $__env->startSection('title',translate('messages.flash_sales')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/condition.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.flash_sale_product_setup')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="row g-3">


            <div class="col-12">
                <div class="card">
                    <div class="card-header py-2 border-0">
                        <div class="search--button-wrapper">
                            <h5 class="card-title">
                                <?php echo e(translate('messages.flash_sale_product_list')); ?><span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($items->total()); ?></span>
                            </h5>
                            <form  class="search-form">
                                <!-- Search -->

                                <div class="input-group input--group">
                                    <input id="datatableSearch_" value="<?php echo e(request()?->search ?? null); ?>" type="search" name="search" class="form-control"
                                            placeholder="<?php echo e(translate('ex_:_name')); ?>" aria-label="Search" >
                                    <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                                </div>
                                <!-- End Search -->
                            </form>
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
                                <th class="border-0"><?php echo e(translate('messages.product')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Current_Stock')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Flash_sale_Qty')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Qty_Sold')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Discount')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Sold_Amount')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.status')); ?></th>
                            </tr>

                            </thead>

                            <tbody id="set-rows">
                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-center">
                                        <span class="mr-3">
                                            <?php echo e($key+$items->firstItem()); ?>

                                        </span>
                                    </td>

                                    <?php
                                    $t2= Carbon\Carbon::parse($item->flashSale->end_date) ;
                                    ?>


                                    <td class="text-center">
                                        <a class="media align-items-center" href="<?php echo e(route('vendor.item.view',[$item['item_id']])); ?>">
                                            <img class="avatar avatar-lg mr-3 onerror-image" src="<?php echo e($item->item['image_full_url']); ?>"
                                                    data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>" alt="<?php echo e($item->item->name); ?> image">
                                            <div class="media-body">
                                                <h5 class="text-hover-primary mb-0"><?php echo e(Str::limit($item->item['name'],20,'...')); ?></h5>
                                            </div>
                                        </a>
                                    </td>

                                    <td class="text-center">
                                        <?php echo e($item['available_stock']); ?>

                                    </td>
                                    <td class="text-center">
                                        <?php echo e($item['stock']); ?>

                                    </td>
                                    <td class="text-center">
                                        <?php echo e($item['sold']); ?>

                                    </td>
                                    <td class="text-center">
                                        <?php if($item->discount_type == 'percent'): ?>
                                        <?php echo e($item['discount']); ?> %
                                        <?php else: ?>
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($item['discount'])); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($item['price'] * $item['sold'])); ?>


                                    </td>
                                    <td class="text-center">
                                        <?php if($item['status'] == 0 || $item->flashSale->is_publish == 0): ?>
                                        <span class="badge badge-soft-info"><?php echo e(translate('off')); ?></span>
                                        <?php elseif($item->flashSale->is_publish == 1 && $t2->gte(now())  ): ?>
                                        <span class="badge badge-soft-success"> <?php echo e(translate('running')); ?> </span>
                                        <?php else: ?>
                                        <span class="badge badge-soft-danger"><?php echo e(translate('expired')); ?></span>
                                        <?php endif; ?>
                                    </td>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if(count($items) !== 0): ?>
                    <hr>
                    <?php endif; ?>
                    <div class="page-area">
                        <?php echo $items->links(); ?>

                    </div>
                    <?php if(count($items) === 0): ?>
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

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/product/flash_sale/list.blade.php ENDPATH**/ ?>