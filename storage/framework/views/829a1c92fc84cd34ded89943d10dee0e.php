<?php $__env->startSection('title',translate('Item Campaign Preview')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <h1 class="page-header-title">
                    <span class="page-header-icon">
                        <img src="<?php echo e(asset('public/assets/admin/img/product.png')); ?>" class="w--26" alt="">
                    </span>
                    <span>
                        <?php echo e($campaign['title']); ?>

                    </span>
                </h1>
                    <a class="btn btn--primary" href="<?php echo e(route('admin.campaign.edit',['item',$campaign['id']])); ?>">
                        <i class="tio-edit"></i> <?php echo e(translate('messages.edit')); ?>

                    </a>
            </div>
        </div>
        <!-- End Page Header -->

        <div class="card mb-3">
            <!-- Body -->
            <div class="card-body">
                <div class="row align-items-md-center">
                    <div class="col-md-6 col-lg-4 mb-3 mb-md-0">
                            <img class="rounded img--ratio-3 onerror-image" src="<?php echo e($campaign['image_full_url']); ?>"
                            data-onerror-image="<?php echo e(asset('/public/assets/admin/img/900x400/img1.jpg')); ?>" alt="Image Description">
                    </div>
                    <div class="col-md-6">
                        <span class="d-block mb-1">
                            <?php echo e(translate('messages.campaign_starts_from')); ?> :
                            <strong class="text--title"><?php echo e($campaign->start_date->format('Y-M-d')); ?></strong>
                        </span>
                        <span class="d-block mb-1">
                            <?php echo e(translate('messages.campaign_ends_at')); ?> :
                            <strong class="text--title"><?php echo e($campaign->end_date->format('Y-M-d')); ?></strong>
                        </span>
                        <span class="d-block mb-1">
                            <?php echo e(translate('messages.available_time_starts')); ?> :
                            <strong class="text--title"><?php echo e($campaign->start_time->format(config('timeformat'))); ?></strong>
                        </span>
                        <span class="d-block">
                            <?php echo e(translate('messages.available_time_ends')); ?> :
                            <strong class="text--title"><?php echo e($campaign->end_time->format(config('timeformat'))); ?></strong>
                        </span>
                    </div>
                </div>
            </div>
            <!-- End Body -->
        </div>

        <div class="row g-2">
            <div class="col-lg-4 col-xl-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="text-center">
                            <span class="mb-3"><?php echo e(translate('messages.store_info')); ?></span>
                            <?php if($campaign->store): ?>
                            <div class="w-100 my-2">
                                <a href="<?php echo e(route('admin.store.view', $campaign->store_id)); ?>" title="<?php echo e($campaign->store['name']); ?>">
                                    <img
                                        class="img--100 rounded-circle onerror-image"
                                        data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
                                        src="<?php echo e($campaign?->store?->logo_full_url ?? asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
                                        alt="Image Description">
                                    <h5 class="input-label mt-2"><?php echo e($campaign->store['name']); ?></h5>
                                </a>
                                <?php else: ?>
                                <span class="badge-info"><?php echo e(translate('messages.store_deleted')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xl-9">
                <div class="card h-100">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-borderless table-thead-bordered table-align-middle">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="px-4 border-0 w--120px">
                                            <h4 class="m-0"><?php echo e(translate('messages.short_description')); ?></h4>
                                        </th>
                                        <th class="px-4 border-0 w--120px">
                                            <h4 class="m-0"><?php echo e(translate('messages.price')); ?></h4>
                                        </th>
                                        <th class="px-4 border-0 w--120px">
                                            <h4 class="m-0"><?php echo e(translate('messages.variations')); ?></h4>
                                        </th>
                                        <?php if(in_array($campaign->module->module_type ,['food'])): ?>
                                        <th class="px-4 border-0 w--120px">
                                            <h4 class="m-0"><?php echo e(translate('Addons')); ?></h4>
                                        </th>
                                        <?php endif; ?>
                                        <?php if(in_array($campaign->module->module_type ,['food','grocery'])): ?>
                                            <th class="px-4 border-0 w--120px">
                                                <h4 class="m-0 text-capitalize"><?php echo e(translate('nutrition')); ?></h4>
                                            </th>
                                            <th class="px-4 border-0 w--120px">
                                                <h4 class="m-0 text-capitalize"><?php echo e(translate('allergy')); ?></h4>
                                            </th>
                                        <?php endif; ?>
                                        <?php if(in_array($campaign->module->module_type ,['pharmacy'])): ?>
                                        <th class="px-4 border-0 w--120px">
                                            <h4 class="m-0 text-capitalize"><?php echo e(translate('generic_name')); ?></h4>
                                        </th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="px-4">
                                            <p><?php echo e($campaign['description']); ?></p>
                                        </td>
                                        <td class="px-4">
                                            <div>

                                                <span class="d-block text-dark"><?php echo e(translate('messages.price')); ?> : <strong><?php echo e(\App\CentralLogics\Helpers::format_currency($campaign['price'])); ?></strong>
                                                </span>

                                                <span class="d-block text-dark"><?php echo e(translate('messages.discount')); ?> :
                                                    <strong><?php echo e(\App\CentralLogics\Helpers::format_currency(\App\CentralLogics\Helpers::discount_calculate($campaign,$campaign['price']))); ?></strong>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-4">
                                            <?php if($campaign->module->module_type == 'food'): ?>
                                            <?php if($campaign->food_variations && is_array(json_decode($campaign['food_variations'], true))): ?>
                                                <?php $__currentLoopData = json_decode($campaign->food_variations, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if(isset($variation['price'])): ?>
                                                        <span class="d-block mb-1 text-capitalize">
                                                            <strong>
                                                                <?php echo e(translate('please_update_the_food_variations.')); ?>

                                                            </strong>
                                                        </span>
                                                    <?php break; ?>

                                                <?php else: ?>
                                                    <span class="d-block text-capitalize">
                                                        <strong>
                                                            <?php echo e($variation['name']); ?> -
                                                        </strong>
                                                        <?php if($variation['type'] == 'multi'): ?>
                                                            <?php echo e(translate('messages.multiple_select')); ?>

                                                        <?php elseif($variation['type'] == 'single'): ?>
                                                            <?php echo e(translate('messages.single_select')); ?>

                                                        <?php endif; ?>
                                                        <?php if($variation['required'] == 'on'): ?>
                                                            - (<?php echo e(translate('messages.required')); ?>)
                                                        <?php endif; ?>
                                                    </span>

                                                    <?php if($variation['min'] != 0 && $variation['max'] != 0): ?>
                                                        (<?php echo e(translate('messages.Min_select')); ?>: <?php echo e($variation['min']); ?> -
                                                        <?php echo e(translate('messages.Max_select')); ?>: <?php echo e($variation['max']); ?>)
                                                    <?php endif; ?>

                                                    <?php if(isset($variation['values'])): ?>
                                                        <?php $__currentLoopData = $variation['values']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <span class="d-block text-capitalize">
                                                                &nbsp; &nbsp; <?php echo e($value['label']); ?> :
                                                                <strong><?php echo e(\App\CentralLogics\Helpers::format_currency($value['optionPrice'])); ?></strong>
                                                            </span>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        <?php else: ?>.
                                        <?php if($campaign->variations && is_array(json_decode($campaign['variations'], true))): ?>
                                            <?php $__currentLoopData = json_decode($campaign['variations'], true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="d-block mb-1 text-capitalize">
                                                    <?php echo e($variation['type']); ?> :
                                                    <?php echo e(\App\CentralLogics\Helpers::format_currency($variation['price'])); ?>

                                                </span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if(in_array($campaign->module->module_type ,['food'])): ?>
                                        </td>
                                        <td class="px-4">
                                            <?php $__currentLoopData = \App\Models\AddOn::whereIn('id',json_decode($campaign['add_ons'],true))->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <small class="d-block text-capitalize">
                                                <?php echo e($addon['name']); ?> : <?php echo e(\App\CentralLogics\Helpers::format_currency($addon['price'])); ?>

                                                </small>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                        <?php endif; ?>
                                        <?php if(in_array($campaign->module->module_type ,['food','grocery'])): ?>
                                            <td class="px-4">
                                                <?php if($campaign->nutritions): ?>
                                                    <?php $__currentLoopData = $campaign->nutritions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nutrition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php echo e($nutrition->nutrition); ?><?php echo e(!$loop->last ? ',' : '.'); ?>

                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-4">
                                                <?php if($campaign->allergies): ?>
                                                    <?php $__currentLoopData = $campaign->allergies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allergy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php echo e($allergy->allergy); ?><?php echo e(!$loop->last ? ',' : '.'); ?>

                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </td>
                                        <?php endif; ?>
                                        <?php if(in_array($campaign->module->module_type ,['pharmacy'])): ?>
                                            <td class="px-4">
                                                <?php if($campaign->generic->pluck('generic_name')->first()): ?>
                                                    <?php echo e($campaign->generic->pluck('generic_name')->first()); ?>

                                                <?php endif; ?>
                                            </td>

                                        <?php endif; ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- End Card -->
        <?php ($orders = $campaign->orderdetails()->paginate(config('default_pagination'))); ?>
        <!-- Card -->
        <div class="card mt-3">
            <div class="table-responsive datatable-custom">
                <table id="datatable"
                       class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                       data-hs-datatables-options='{
                     "columnDefs": [{
                        "targets": [0],
                        "orderable": false
                      }],
                     "order": [],
                     "info": {
                       "totalQty": "#datatableWithPaginationInfoTotalQty"
                     },
                     "search": "#datatableSearch",
                     "entries": "#datatableEntries",
                     "pageLength": 25,
                     "isResponsive": false,
                     "isShowPaging": false,
                     "pagination": "datatablePagination"
                   }'>
                    <thead class="thead-light">
                    <tr>
                        <th class="border-0">
                            SL
                        </th>
                        <th class="table-column-pl-0 border-0"><?php echo e(translate('messages.order')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.date')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.customer')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.store')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.payment_status')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.total')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.order_status')); ?></th>
                    </tr>
                    </thead>

                    <tbody id="set-rows">
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <tr class="status-<?php echo e($order['order_status']); ?> class-all">
                            <td class="">
                                <?php echo e($key+1); ?>

                            </td>
                            <td class="table-column-pl-0">
                                <a href="<?php echo e(route('admin.order.details',['id'=>$order['order_id']])); ?>"><?php echo e($order->order['id']); ?></a>
                            </td>
                            <td><?php echo e(date('d M Y',strtotime($order->order['created_at']))); ?></td>
                            <td>
                                <?php if($order->order->customer): ?>
                                    <a class="text-body text-capitalize"
                                       href="<?php echo e(route('admin.customer.view',[$order->order['user_id']])); ?>"><?php echo e($order->order->customer['f_name'].' '.$order->order->customer['l_name']); ?></a>
                                <?php else: ?>
                                    <label class="badge badge-danger"><?php echo e(translate('messages.invalid_customer_data')); ?></label>
                                <?php endif; ?>
                            </td>
                            <td>
                                <label class="badge badge-soft-primary"><?php echo e(Str::limit($order->order->store?$order->order->store->name:translate('messages.store deleted!'),20,'...')); ?></label>
                            </td>
                            <td>
                                <?php if($order->order->payment_status=='paid'): ?>
                                    <span class="badge badge-soft-success">
                                      <span class="legend-indicator bg-success"></span><?php echo e(translate('messages.paid')); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-soft-danger">
                                      <span class="legend-indicator bg-danger"></span><?php echo e(translate('messages.unpaid')); ?>

                                    </span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e(\App\CentralLogics\Helpers::format_currency($order->order['order_amount'])); ?></td>
                            <td class="text-capitalize">
                                <?php if($order->order['order_status']=='pending'): ?>
                                    <span class="badge badge-soft-info ml-2 ml-sm-3">
                                      <?php echo e(translate('messages.pending')); ?>

                                    </span>
                                <?php elseif($order->order['order_status']=='confirmed'): ?>
                                    <span class="badge badge-soft-info ml-2 ml-sm-3">
                                      <?php echo e(translate('messages.confirmed')); ?>

                                    </span>
                                <?php elseif($order->order['order_status']=='processing'): ?>
                                    <span class="badge badge-soft-warning ml-2 ml-sm-3">
                                      <?php echo e(translate('messages.processing')); ?>

                                    </span>
                                <?php elseif($order->order['order_status']=='out_for_delivery'): ?>
                                    <span class="badge badge-soft-warning ml-2 ml-sm-3">
                                      <?php echo e(translate('messages.out_for_delivery')); ?>

                                    </span>
                                <?php elseif($order->order['order_status']=='delivered'): ?>
                                    <span class="badge badge-soft-success ml-2 ml-sm-3">
                                      <?php echo e(translate('messages.delivered')); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-soft-danger ml-2 ml-sm-3">
                                      <?php echo e(str_replace('_',' ',$order->order['order_status'])); ?>

                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <!-- Footer -->
            <div class="card-footer">
                <!-- Pagination -->
                <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                    <div class="col-12">
                        <?php echo $orders->links(); ?>

                    </div>
                </div>
                <!-- End Pagination -->
            </div>
            <!-- End Footer -->
        </div>
        <!-- End Card -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/campaign/item/view.blade.php ENDPATH**/ ?>