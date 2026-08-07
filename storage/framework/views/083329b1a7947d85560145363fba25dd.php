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
                    <div class="card-body">
                        <form action="<?php echo e(route('admin.flash-sale.store-product')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="flash_sale_id" value="<?php echo e($flash_sale->id); ?>">
                            <div class="row mb-3">
                                <div class="col-12 mb-2">
                                    <div class="form-group mb-0" id="item_wise">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.select_item')); ?></label>
                                        <select name="item_id" id="choice_item" class="form-control js-select2-custom" placeholder="<?php echo e(translate('messages.select_item')); ?>">

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="total_stock"><?php echo e(translate('messages.total_stock')); ?></label>
                                        <input type="number" placeholder="<?php echo e(translate('messages.Ex:_10')); ?>" class="form-control" name="stock" min="0" id="quantity">
                                    </div>
                                </div>
                                <div class="col-sm-4 col-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1"><?php echo e(translate('messages.discount_type')); ?><span
                                                class="input-label-secondary text--title" data-toggle="tooltip"
                                                data-placement="right"
                                                data-original-title="<?php echo e(translate('Admin_shares_the_same_percentage/amount_on_discount_as_he_takes_commissions_from_stores')); ?>">
                                                <i class="tio-info-outined"></i>
                                            </span>
                                        </label>
                                        <select name="discount_type" id="discount_type"
                                            class="form-control js-select2-custom">
                                            
                                            <option value="percent"><?php echo e(translate('messages.percent')); ?></option>
                                            <option value="amount"><?php echo e(translate('messages.amount')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label"
                                            for="exampleFormControlInput1"><?php echo e(translate('messages.discount')); ?></label>
                                        <input type="number" min="0" max="9999999999999999999999" value="0" step="0.001"
                                            name="discount" class="form-control" id="discount_amount"
                                            placeholder="<?php echo e(translate('messages.Ex:')); ?> 100">
                                    </div>
                                </div>
                            </div>

                            <div class="btn--container justify-content-end">
                                <button type="reset" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                                <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.submit')); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

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
                                            placeholder="<?php echo e(translate('ex_:_product_name')); ?>" aria-label="Search" >
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
                                <th class="border-0"><?php echo e(translate('messages.store')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.stock_for_this_sale')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Qty_Sold')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.price')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.status')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.action')); ?></th>
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
                                    <td class="text-center">
                                        <a class="media align-items-center" href="<?php echo e(route('admin.item.view',[$item['item_id']])); ?>">
                                            <img class="avatar avatar-lg mr-3 onerror-image" src="<?php echo e($item->item['image_full_url']); ?>"
                                            data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>" alt="<?php echo e($item->item->name); ?> image">
                                            <div class="media-body">
                                                <h5 title="<?php echo e($item->item['name']); ?>" class="text-hover-primary mb-0"><?php echo e(Str::limit($item->item['name'],20,'...')); ?></h5>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="text-center" title="<?php echo e($item->item->store?$item->item->store->name:''); ?>">
                                        <?php echo e(Str::limit($item->item->store?$item->item->store->name:translate('messages.store deleted!'), 20, '...')); ?>

                                        </td>
                                    <td class="text-center">
                                        <?php echo e($item['stock']); ?>

                                    </td>
                                    <td class="text-center">
                                        <?php echo e($item['sold']); ?>

                                    </td>
                                    <td class="text-center">
                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($item['price'])); ?>

                                    </td>
                                    <td class="text-center">
                                        <label class="toggle-switch toggle-switch-sm" for="publishCheckbox<?php echo e($item->id); ?>">
                                            <input type="checkbox" data-url="<?php echo e(route('admin.flash-sale.status-product',[$item['id'],$item->status?0:1])); ?>" class="toggle-switch-input redirect-url" id="publishCheckbox<?php echo e($item->id); ?>" <?php echo e($item->status?'checked':''); ?>>
                                            <span class="toggle-switch-label mx-auto">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn--container justify-content-center">
                                            <a class="btn action-btn btn--danger btn-outline-danger form-control form-alert" href="javascript:" data-id="item-<?php echo e($item['id']); ?>" data-message="<?php echo e(translate('Want to delete this item ?')); ?>" title="<?php echo e(translate('messages.delete')); ?>"><i class="tio-delete-outlined"></i>
                                            </a>
                                            <form action="<?php echo e(route('admin.flash-sale.delete-product',[$item['id']])); ?>"
                                                    method="post" id="item-<?php echo e($item['id']); ?>">
                                                <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                            </form>
                                        </div>
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
    <script>
        let zone_id = [];
        let module_id = <?php echo e(Config::get('module.current_module_id')); ?>;

        function get_items()
        {
            let nurl = '<?php echo e(url('/')); ?>/admin/item/get-items-flashsale?module_id='+module_id;

            if(!Array.isArray(zone_id))
            {
                nurl += '&zone_id='+zone_id;
            }

            $.get({
                url: nurl,
                dataType: 'json',
                success: function (data) {
                    $('#choice_item').empty().append(data.options);
                }
            });
        }
        $(document).on('ready', function () {

            module_id = <?php echo e(Config::get('module.current_module_id')); ?>;
            get_items();




                // INITIALIZATION OF SELECT2
                // =======================================================
                $('.js-select2-custom').each(function () {
                    let select2 = $.HSCore.components.HSSelect2.init($(this));
                });
            });

        $('#discount_type').on('change', function() {
         if($('#discount_type').val() == 'current_active_discount')
            {
                $('#discount_amount').attr("readonly","true");
            }
            else
            {
                $('#discount_amount').removeAttr("readonly");
            }
        });

        </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/flash-sale/product-index.blade.php ENDPATH**/ ?>