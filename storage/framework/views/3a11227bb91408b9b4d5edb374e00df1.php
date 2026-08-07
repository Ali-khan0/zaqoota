<?php $__env->startSection('title',translate('Customer Details')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-print-none pb-3">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title mb-1"><?php echo e(translate('messages.customer_id')); ?> #<?php echo e($customer['id']); ?></h1>
                    <span class="fs-12">
                        <?php echo e(translate('messages.joined_at')); ?> : <?php echo e(date('d M Y '.config('timeformat'),strtotime($customer['created_at']))); ?>

                    </span>

                </div>
            </div>
        </div>
        <?php if(addon_published_status('Rental')): ?>
            <?php ($id = request()->user_id); ?>
            <!-- Nav Menus -->
            <ul class="nav nav-tabs border-0 nav--tabs nav--pills mb-4">
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->module != 1 ? 'active' : ''); ?>   " href="<?php echo e(route('admin.users.customer.view', $id)); ?>"><?php echo e(translate('All_Module')); ?></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo e(request()->module == 1 ?'active' : ''); ?> " href="<?php echo e(route('admin.users.customer.rental.view',['module'=> true,'user_id'=>$id])); ?>"><?php echo e(translate('Rental_Module')); ?></a>
                </li>
            </ul>
        <?php endif; ?>
        <!-- End Page Header -->
        <?php if($customer['f_name']): ?>
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div class="d-flex gap-2 align-items-center">
                        <img src="<?php echo e(asset('public/assets/admin/img/icons/coupon-icon.png')); ?>" width="16" height="16" alt="">
                        <p class="mb-0"><?php echo e(translate('If you want to make a customized COUPON for this customer, click the Create Coupon button and influence them buy more from your store.')); ?></p>
                    </div>

                    <a href="<?php echo e(route('admin.coupon.add-new',['customer' => $customer['id']])); ?>" class="btn btn-warning text-white font-semibold">
                        <i class="tio-add"></i>
                        <?php echo e(translate('messages.create_coupon')); ?>

                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="row mb-3 g-2">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-3">
                            <div class="color-card flex-column align-items-center justify-content-center color-2 flex-grow-1">
                                <div class="img-box">
                                    <img class="resturant-icon w--30" src="<?php echo e(asset('/public/assets/admin/img/icons/order-icon-1.png')); ?>" alt="">
                                </div>
                                <div class="d-flex flex-column align-items-center">
                                    <h2 class="title"> <?php echo e($orders->total()); ?> </h2>
                                    <div class="subtitle">
                                        <?php echo e(translate('total_order')); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="color-card flex-column align-items-center justify-content-center color-5 flex-grow-1">
                                <div class="img-box">
                                    <img class="resturant-icon w--30" src="<?php echo e(asset('/public/assets/admin/img/icons/order-icon-2.png')); ?>" alt="">
                                </div>
                                <div class="d-flex flex-column align-items-center">
                                    <h2 class="title"> <?php echo e(\App\CentralLogics\Helpers::format_currency($total_order_amount[0]->total_order_amount)); ?> </h2>
                                    <div class="subtitle">
                                        <?php echo e(translate('total_order_amount')); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-3">
                            <div class="color-card flex-column align-items-center justify-content-center color-7 flex-grow-1">
                                <div class="img-box">
                                    <img class="resturant-icon w--30" src="<?php echo e(asset('/public/assets/admin/img/icons/order-icon-3.png')); ?>" alt="transactions">
                                </div>
                                <div class="d-flex flex-column align-items-center">
                                    <h2 class="title"> <?php echo e($customer->wallet_balance??0); ?> </h2>
                                    <div class="subtitle">
                                        <?php echo e(translate('messages.wallet_balance')); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="color-card flex-column align-items-center justify-content-center color-4 flex-grow-1">
                                <div class="img-box">
                                    <img class="resturant-icon w--30" src="<?php echo e(asset('/public/assets/admin/img/icons/order-icon-4.png')); ?>" alt="transactions">
                                </div>
                                <div class="d-flex flex-column align-items-center">
                                    <h2 class="title"> <?php echo e($customer->loyalty_point??0); ?> </h2>
                                    <div class="subtitle">
                                        <?php echo e(translate('messages.loyalty_point')); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="printableArea">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="card">
                    <div class="card-header border-0 py-2 d-flex flex-wrap gap-2">
                        <div class="search--button-wrapper">
                            <h5 class="card-title d-flex gap-2 align-items-center">
                                <?php echo e(translate('order_list')); ?>

                                <span class="badge badge-soft-secondary"><?php echo e($orders->total()); ?></span>
                            </h5>

                            <div class="min--260">
                                <form class="search-form theme-style">
                                    <div class="input-group input--group">
                                        <input  type="search" name="search" class="form-control"
                                        placeholder="<?php echo e(translate('ex_: search_by_order_id')); ?>" aria-label="<?php echo e(translate('messages.search')); ?>" value="<?php echo e(request()?->search); ?>" >
                                        <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                                    </div>
                                </form>

                            </div>
                            <?php if(request()->get('search')): ?>
                                 <button type="reset" class="btn btn--primary ml-2 location-reload-to-base" data-url="<?php echo e(url()->full()); ?>"><?php echo e(translate('messages.reset')); ?></button>
                                 <?php endif; ?>
                        </div>
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
                            <a id="export-excel" class="dropdown-item" href="<?php echo e(route('admin.customer.order-export', ['type'=>'excel','id'=>$customer->id,request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                    alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item" href="<?php echo e(route('admin.customer.order-export', ['type'=>'csv','id'=>$customer->id,request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                    alt="Image Description">
                                .<?php echo e(translate('messages.csv')); ?>

                            </a>
                        </div>
                    </div>
                    <!-- End Unfold -->
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
                                    <th class="border-0 pl-4"><?php echo e(translate('SL')); ?></th>
                                    <th class="border-0"><?php echo e(translate('messages.order_ID')); ?></th>
                                    <th class="border-0"><?php echo e(translate('messages.store')); ?></th>
                                    <th class="border-0 "><?php echo e(translate('messages.status')); ?></th>
                                    <th class="border-0 text-center "><?php echo e(translate('messages.total_Items')); ?></th>
                                    <th class="border-0 "><?php echo e(translate('messages.total_amount')); ?></th>
                                    <th class="border-0 "><?php echo e(translate('messages.order_date')); ?></th>
                                    <th class="border-0 text-center"><?php echo e(translate('messages.action')); ?></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <div class="pl-2">
                                                <?php echo e($key+$orders->firstItem()); ?>

                                            </div>
                                        </td>
                                        <td>
                                            <a class="text-dark" href="<?php echo e(route((isset($order) && $order->order_type=='parcel')?'admin.parcel.order.details':'admin.order.details',['id'=>$order['id'],'module_id'=>$order['module_id']])); ?>"><?php echo e($order['id']); ?></a>
                                        </td>
                                        <th>
                                            <?php if($order->store): ?>
                                            <div><a  class="text--title" href="<?php echo e(route('admin.store.view', $order->store_id)); ?>" alt="view store"><?php echo e(Str::limit($order->store?$order->store->name:translate('messages.store deleted!'),20,'...')); ?></a></div>
                                            <?php else: ?>
                                                <div><?php echo e(Str::limit(translate('messages.not_found'),20,'...')); ?></div>
                                            <?php endif; ?>
                                        </th>
                                        <td class="text-capitalize ">
                                            <?php if($order['order_status']=='pending'): ?>
                                                <span class="badge badge-soft-info">
                                      <?php echo e(translate('messages.pending')); ?>

                                    </span>
                                            <?php elseif($order['order_status']=='confirmed'): ?>
                                                <span class="badge badge-soft-info">
                                      <?php echo e(translate('messages.confirmed')); ?>

                                    </span>
                                            <?php elseif($order['order_status']=='processing'): ?>
                                                <span class="badge badge-soft-warning">
                                      <?php echo e(translate('messages.processing')); ?>

                                    </span>
                                            <?php elseif($order['order_status']=='picked_up'): ?>
                                                <span class="badge badge-soft-warning">
                                      <?php echo e(translate('messages.out_for_delivery')); ?>

                                    </span>
                                            <?php elseif($order['order_status']=='delivered'): ?>
                                                <span class="badge badge-soft-success">
                                      <?php echo e(translate('messages.delivered')); ?>

                                    </span>
                                            <?php elseif($order['order_status']=='failed'): ?>
                                                <span class="badge badge-soft-danger">
                                      <?php echo e(translate('messages.payment_failed')); ?>

                                    </span>
                                            <?php elseif($order['order_status']=='handover'): ?>
                                                <span class="badge badge-soft-danger">
                                      <?php echo e(translate('messages.handover')); ?>

                                    </span>
                                            <?php elseif($order['order_status']=='canceled'): ?>
                                                <span class="badge badge-soft-danger">
                                      <?php echo e(translate('messages.canceled')); ?>

                                    </span>
                                            <?php elseif($order['order_status']=='accepted'): ?>
                                                <span class="badge badge-soft-danger">
                                      <?php echo e(translate('messages.accepted')); ?>

                                    </span>
                                            <?php elseif($order['order_status']=='refund_requested'): ?>
                                                <span class="badge badge-soft-danger">
                                      <?php echo e(translate('messages.refund_requested')); ?>

                                    </span>
                                            <?php else: ?>
                                                <span class="badge badge-soft-danger">
                                      <?php echo e(str_replace('_',' ',$order['order_status'])); ?>

                                    </span>
                                            <?php endif; ?>

                                        </td>
                                        <td>
                                            <div class="text-center mw--85px mx-auto">
                                                <?php echo e($order?->details_count != 0  ?  $order?->details_count: translate('messages.N/A')); ?>

                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <?php echo e(\App\CentralLogics\Helpers::format_currency($order['order_amount'])); ?>

                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <div>
                                                    <?php echo e(\App\CentralLogics\Helpers::date_format($order->created_at)); ?>

                                                </div>
                                                <div class="d-block text-uppercase">
                                                    <?php echo e(\App\CentralLogics\Helpers::time_format($order->created_at)); ?>

                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn--container justify-content-center">
                                                <a class="btn action-btn btn--warning btn-outline-warning" href="<?php echo e(route((isset($order) && $order->order_type=='parcel')?'admin.parcel.order.details':'admin.order.details',['id'=>$order['id']])); ?>" title="<?php echo e(translate('messages.view')); ?> "><i class="tio-visible"></i></a>
                                                
                                                <a class="btn action-btn btn--primary btn-outline-primary" target="_blank" href="<?php echo e(route('admin.order.generate-invoice',[$order['id']])); ?>" title="<?php echo e(translate('messages.download')); ?>">
                                                    <i class="tio-download-to"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if(count($orders) !== 0): ?>
                    <hr>
                    <?php endif; ?>
                    <div class="page-area">
                        <?php echo $orders->links(); ?>

                    </div>
                    <?php if(count($orders) === 0): ?>
                    <div class="empty--data">
                        <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                        <h5>
                            <?php echo e(translate('no_data_found')); ?>

                        </h5>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-title d-flex flex-wrap align-items-center gap-2">
                            <div class="d-flex align-items-center gap-1">
                                <span class="card-header-icon">
                                    <i class="tio-user"></i>
                                </span>
                                <span class=""> <?php echo e(translate('customer_information')); ?></span>
                            </div>
                            <span class="badge badge-soft-info"><?php echo e(translate('total_order')); ?>: <?php echo e($orders->total()); ?></span>
                        </h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <?php if($customer): ?>
                        <div class="card-body">
                            <div class="media gap-3 flex-wrap">
                                <div class="avatar avatar-circle avatar-70">
                                    <img class="avatar-img onerror-image" width="70" height="70" data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>" src="<?php echo e($customer->image_full_url); ?>"
                                    alt="Image Description">
                                </div>
                                <div class="media-body">
                                    <div class="key-value-list d-flex flex-column gap-2 text-dark" style="--min-width: 60px">
                                        <div class="key-val-list-item d-flex gap-3">
                                            <div><?php echo e(translate('name')); ?></div>:
                                            <div class="font-semibold"><?php echo e($customer['f_name']? $customer['f_name'].' '.$customer['l_name'] : translate('messages.Incomplete_Profile')); ?></div>
                                        </div>
                                        <div class="key-val-list-item d-flex gap-3">
                                            <div><?php echo e(translate('contact')); ?></div>:
                                            <a href="tel:<?php echo e($customer['phone']); ?>" class="text-dark font-semibold"><?php echo e($customer['phone'] ?? translate('messages.N/A')); ?></a>
                                        </div>
                                        <div class="key-val-list-item d-flex gap-3">
                                            <div><?php echo e(translate('email')); ?></div>:
                                            <a href="mailto:<?php echo e($customer['email']); ?>" class="text-dark font-semibold"><?php echo e($customer['email'] ?? translate('messages.N/A')); ?></a>
                                        </div>
                                        <?php $__currentLoopData = $customer->addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="key-val-list-item d-flex gap-3">
                                                <div><?php echo e(translate('address')); ?></div>:
                                                <a href="https://www.google.com/maps/search/?api=1&query=<?php echo e(data_get($address,'latitude',0)); ?>,<?php echo e(data_get($address,'longitude',0)); ?>" target="_blank"><?php echo e($address['address']); ?></a>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>

                                    
                                </div>
                            </div>


                            

                        </div>
                <?php endif; ?>
                <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
        </div>
        <!-- End Row -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>

    <script>
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
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/customer/customer-view.blade.php ENDPATH**/ ?>