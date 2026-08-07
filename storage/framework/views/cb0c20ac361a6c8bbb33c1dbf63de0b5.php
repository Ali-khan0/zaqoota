<?php $__env->startSection('title',translate('messages.Delivery Man Preview')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title text-break">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/delivery-man.png')); ?>" class="w--26" alt="">
                </span>
                <span><?php echo e($deliveryMan['f_name'].' '.$deliveryMan['l_name']); ?></span>
            </h1>
            <div class="">
                <?php echo $__env->make('admin-views.delivery-man.partials._tab_menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Card -->
        <div class="card mb-3 mb-lg-5 mt-2">
            <div class="card-header flex-wrap py-2 border-0 gap-2">
                <div class="search--button-wrapper">
                    <h4 class="card-title"><?php echo e(translate('messages.order_transactions')); ?></h4>
                    <div class="min--260">
                        <input type="date" class="form-control set-filter" placeholder="<?php echo e(translate('mm/dd/yyyy')); ?>" data-url="<?php echo e(route('admin.users.delivery-man.preview',['id'=>$deliveryMan->id, 'tab'=> 'transaction'])); ?>" data-filter="date" value="<?php echo e($date); ?>">
                    </div>
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
                        <a id="export-excel" class="dropdown-item" href="<?php echo e(route('admin.users.delivery-man.earning-export', ['type'=>'excel','id'=>$deliveryMan->id,request()->getQueryString()])); ?>">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                alt="Image Description">
                            <?php echo e(translate('messages.excel')); ?>

                        </a>
                        <a id="export-csv" class="dropdown-item" href="<?php echo e(route('admin.users.delivery-man.earning-export', ['type'=>'csv','id'=>$deliveryMan->id,request()->getQueryString()])); ?>">
                            <img class="avatar avatar-xss avatar-4by3 mr-2"
                                src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                alt="Image Description">
                            .<?php echo e(translate('messages.csv')); ?>

                        </a>
                    </div>
                </div>
                <!-- End Unfold -->
            </div>
            <!-- Body -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="datatable"
                        class="table table-borderless table-thead-bordered table-nowrap justify-content-between table-align-middle card-table">
                        <thead class="thead-light">
                            <tr>
                                <th class="border-0"><?php echo e(translate('sl')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.order_id')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.delivery_fee_earned')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.delivery_tips')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.date')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php ($digital_transaction = \App\Models\OrderTransaction::where('delivery_man_id', $deliveryMan->id)
                        ->when($date, function($query)use($date){
                            return $query->whereDate('created_at', $date);
                        })->paginate(25)); ?>

                        <?php $__currentLoopData = $digital_transaction; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$dt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>
                                <td scope="row"><?php echo e($k+$digital_transaction->firstItem()); ?></td>
                                <td><a href="<?php echo e(route((isset($dt->order) && $dt->order->order_type=='parcel')?'admin.parcel.order.details':'admin.order.details',[$dt->order_id,'module_id'=>$dt->order->module_id])); ?>"><?php echo e($dt->order_id); ?></a></td>
                               <td><?php echo e(\App\CentralLogics\Helpers::format_currency($dt->original_delivery_charge)); ?></td>
                               <td><?php echo e(\App\CentralLogics\Helpers::format_currency($dt->dm_tips)); ?></td>
                                <td> <?php echo e(\App\CentralLogics\Helpers::date_format($dt->created_at )); ?></td>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- End Body -->
            <div class="card-footer">
                <?php echo $digital_transaction->links(); ?>

            </div>
        </div>
        <!-- End Card -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/delivery-man/view/transaction.blade.php ENDPATH**/ ?>