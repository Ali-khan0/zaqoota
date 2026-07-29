<?php $__env->startSection('title',translate('messages.flash_sales')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/condition.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.flash_sale_setup')); ?>

                </span>
            </h1>
        </div>
        <?php ($language=\App\Models\BusinessSetting::where('key','language')->first()); ?>
        <?php ($language = $language->value ?? null); ?>
        <?php ($defaultLang = str_replace('_', '-', app()->getLocale())); ?>
        <!-- End Page Header -->
        <div class="row g-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo e(route('admin.flash-sale.store')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <?php if($language): ?>
                                    <ul class="nav nav-tabs mb-3 border-0">
                                        <li class="nav-item">
                                            <a class="nav-link lang_link active"
                                            href="#"
                                            id="default-link"><?php echo e(translate('messages.default')); ?></a>
                                        </li>
                                        <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="nav-item">
                                                <a class="nav-link lang_link"
                                                    href="#"
                                                    id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                    <div class="row">
                                        <div class="col-12">

                                            <div class="lang_form" id="default-form">
                                                <div class="form-group">
                                                    <label class="input-label"
                                                        for="default_title"><?php echo e(translate('messages.title')); ?>

                                                        (<?php echo e(translate('messages.default')); ?>)
                                                    </label>
                                                    <input type="text" name="title[]" id="default_title"
                                                        class="form-control" maxlength="100" placeholder="<?php echo e(translate('messages.ex_:_new_flash_sale')); ?>"
                                                    >
                                                </div>
                                                <input type="hidden" name="lang[]" value="default">
                                            </div>
                                        <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="d-none lang_form"
                                                id="<?php echo e($lang); ?>-form">
                                                <div class="form-group">
                                                    <label class="input-label"
                                                        for="<?php echo e($lang); ?>_title"><?php echo e(translate('messages.title')); ?>

                                                        (<?php echo e(strtoupper($lang)); ?>)
                                                    </label>
                                                    <input type="text" maxlength="100" name="title[]" id="<?php echo e($lang); ?>_title"
                                                        class="form-control" placeholder="<?php echo e(translate('messages.ex_:_new_flash_sale')); ?>">
                                                </div>
                                                <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="input-label"
                                                    for="default_title"><?php echo e(translate('messages.discount_Bearer')); ?>

                                                    <span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('messages.Define_the_cost_amount_you_want_to_bear_for_this_Flash_Sale.The_total_bear_amount_should_be_100.')); ?>">
                                                        <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                                    </span>
                                                </label>
                                            </div>
                                            <div class="row g-3 __bg-F8F9FC-card">
                                                <div class="col-sm-6">
                                                    <label class="form-label"><?php echo e(translate('admin')); ?>(%)</label>
                                                <input type="number"  min=".01" step="0.001" max="100" name="admin_discount_percentage"
                                                        value=""
                                                        class="form-control" id="adminDiscount"
                                                        placeholder="<?php echo e(translate('Ex_:_50')); ?>" required>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-label"><?php echo e(translate('messages.store_owner')); ?>(%)</label>
                                                <input type="number"  min=".01" step="0.001" max="100" name="vendor_discount_percentage"
                                                        value=""
                                                        class="form-control" id="storeDiscount"
                                                        placeholder="<?php echo e(translate('Ex_:_50')); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="input-label"
                                                    for="default_title"><?php echo e(translate('messages.validity')); ?>

                                                </label>
                                            </div>
                                            <div class="row g-3 __bg-F8F9FC-card">
                                                <div class="col-6">
                                                    <div>
                                                        <label class="input-label" for="title"><?php echo e(translate('messages.start_date')); ?></label>
                                                        <input type="datetime-local" id="from" class="form-control" required="" name="start_date">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div>
                                                        <label class="input-label" for="title"><?php echo e(translate('messages.end_date')); ?></label>
                                                        <input type="datetime-local" id="to" class="form-control" required="" name="end_date">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php endif; ?>
                            <div class="btn--container justify-content-end mt-5">
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
                                <?php echo e(translate('messages.flash_sale_list')); ?><span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($flash_sales->total()); ?></span>
                            </h5>
                            <form  class="search-form">
                                <!-- Search -->

                                <div class="input-group input--group">
                                    <input id="datatableSearch_" value="<?php echo e(request()?->search ?? null); ?>" type="search" name="search" class="form-control"
                                            placeholder="<?php echo e(translate('ex_:_flash_sale_title')); ?>" aria-label="Search" >
                                    <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                                </div>
                                <!-- End Search -->
                            </form>
                            <?php if(request()->get('search')): ?>
                            <button type="reset" class="btn btn--primary ml-2 location-reload-to-base" data-url="<?php echo e(url()->full()); ?>"><?php echo e(translate('messages.reset')); ?></button>
                            <?php endif; ?>

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
                                <th class="border-0"><?php echo e(translate('messages.title')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.duration')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.active_products')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.publish')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.action')); ?></th>
                            </tr>

                            </thead>

                            <tbody id="set-rows">
                            <?php $__currentLoopData = $flash_sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$flash_sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-center">
                                        <span  class="mr-3">
                                            <?php echo e($key+$flash_sales->firstItem()); ?>

                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span title="<?php echo e($flash_sale['title']); ?>" class="font-size-sm text-body mr-3">
                                            <?php echo e(Str::limit($flash_sale['title'],20,'...')); ?>

                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="bg-gradient-light text-dark"><?php echo e($flash_sale->start_date?$flash_sale->start_date->format('d/M/Y'). ' - ' .$flash_sale->end_date->format('d/M/Y'): 'N/A'); ?></span>
                                    </td>
                                    <td class="text-center">
                                        <span class="font-size-sm text-body mr-3">
                                            <?php echo e($flash_sale->activeProducts->count()); ?>

                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <label class="toggle-switch toggle-switch-sm" for="is_publish-<?php echo e($flash_sale['id']); ?>">
                                            <input type="checkbox" class="toggle-switch-input dynamic-checkbox" <?php echo e($flash_sale->is_publish?'checked':''); ?>

                                                    data-id="is_publish-<?php echo e($flash_sale['id']); ?>"
                                                   data-type="status"
                                                   data-image-on='<?php echo e(asset('/public/assets/admin/img/modal')); ?>/zone-status-on.png'
                                                   data-image-off="<?php echo e(asset('/public/assets/admin/img/modal')); ?>/zone-status-off.png"
                                                   data-title-on="<?php echo e(translate('Want_to_publish_this_flash_sale?')); ?>"
                                                   data-title-off="<?php echo e(translate('Want_to_hide_this_flash_sale?')); ?>"
                                                   data-text-on="<p><?php echo e(translate('If_you_publish_this_flash_sale,_Customers_can_see_all_stores_&_products_available_under_this_flash_sale_from_the_Customer_App_&_Website._other_flash_sales_will_be_turned_off.')); ?></p>"
                                                   data-text-off="<p><?php echo e(translate('If_you_hide_this_flash_sale,_Customers_Will_NOT_see_all_stores_&_products_available_under_this_flash_sale_from_the_Customer_App_&_Website.')); ?></p>"
                                                   id="is_publish-<?php echo e($flash_sale['id']); ?>">
                                            <span class="toggle-switch-label mx-auto">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                        <form action="<?php echo e(route('admin.flash-sale.publish',[$flash_sale['id'],$flash_sale->is_publish?0:1])); ?>" method="get" id="is_publish-<?php echo e($flash_sale['id']); ?>_form">
                                        </form>
                                    </td>
                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a class="btn p-2 btn--primary btn-outline-primary" href="<?php echo e(route('admin.flash-sale.add-product',[$flash_sale['id']])); ?>" title="<?php echo e(translate('messages.add-product')); ?>"><i class="tio-add"></i><?php echo e(translate('messages.Add_new_product')); ?>

                                            </a>
                                            <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route('admin.flash-sale.edit',[$flash_sale['id']])); ?>" title="<?php echo e(translate('messages.edit')); ?>"><i class="tio-edit"></i>
                                            </a>
                                            <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:" data-id="flash_sale-<?php echo e($flash_sale['id']); ?>" data-message="<?php echo e(translate('Want to delete this flash_sale ?')); ?>" title="<?php echo e(translate('messages.delete')); ?>"><i class="tio-delete-outlined"></i>
                                            </a>
                                            <form action="<?php echo e(route('admin.flash-sale.delete',[$flash_sale['id']])); ?>"
                                                    method="post" id="flash_sale-<?php echo e($flash_sale['id']); ?>">
                                                <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if(count($flash_sales) !== 0): ?>
                    <hr>
                    <?php endif; ?>
                    <div class="page-area">
                        <?php echo $flash_sales->links(); ?>

                    </div>
                    <?php if(count($flash_sales) === 0): ?>
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
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/flash-sale-index.js"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/flash-sale/index.blade.php ENDPATH**/ ?>