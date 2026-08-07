<?php $__env->startSection('title',translate('messages.notification')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/notification.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.notification')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="row g-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo e(route('admin.rental.notification.store')); ?>" method="post" enctype="multipart/form-data" id="notification">
                            <?php echo csrf_field(); ?>
                            <div class="row gy-3">
                                <div class="col-lg-6">
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <div class="form-group mb-0">
                                                <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.title')); ?></label>
                                                <input type="text" name="notification_title" class="form-control" placeholder="<?php echo e(translate('messages.new_notification')); ?>" required maxlength="191">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group mb-0">
                                                <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.zone')); ?></label>
                                                <select name="zone" id="zone" class="form-control js-select2-custom" >
                                                    <option value="all"><?php echo e(translate('messages.all')); ?></option>
                                                    <?php $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($zone['id']); ?>"><?php echo e($zone['name']); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group mb-0">
                                                <label class="input-label" for="tergat"><?php echo e(translate('messages.send_to')); ?></label>

                                                <select name="tergat" class="form-control js-select2-custom" id="tergat" data-placeholder="<?php echo e(translate('messages.select_tergat')); ?>" required>
                                                    <option value="customer"><?php echo e(translate('messages.customer')); ?></option>
                                                    <option value="store"><?php echo e(translate('messages.Provider')); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group mb-0">
                                                <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.description')); ?></label>
                                                <textarea name="description" class="form-control" maxlength="1000" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="h-100 d-flex flex-column">
                                        <label class="d-block text-center mt-auto mb-0">
                                            <?php echo e(translate('messages.image')); ?>

                                            <small class="text-danger"> ( <?php echo e(translate('messages.ratio')); ?> 900x300 )</small>
                                        </label>
                                        <div class="text-center py-3 my-auto">
                                            <img class="img--vertical" id="viewer" data-src="<?php echo e(asset('public/assets/admin/img/900x400/img1.jpg')); ?>"
                                                src="<?php echo e(asset('public/assets/admin/img/900x400/img1.jpg')); ?>" alt="image"/>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" name="image" id="customFileEg1" class="custom-file-input"
                                                accept=".webp, .jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                            <label class="custom-file-label" for="customFileEg1"><?php echo e(translate('messages.choose_file')); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="btn--container justify-content-end">
                                        <button type="reset" id="reset_btn" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                                        <button type="submit" id="submit" class="btn btn--primary"><?php echo e(translate('messages.send_notification')); ?></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header py-2">
                        <div class="search--button-wrapper">
                            <h5 class="card-title"><?php echo e(translate('Notification list')); ?><span class="badge badge-soft-dark ml-2"><?php echo e($notifications->total()); ?></span></h5>
                            <form class="search-form" >
                                <!-- Search -->
                                <div class="input-group input--group min--270">
                                    <input type="search" name="search"  class="form-control"
                                    value="<?php echo e(request()?->search ?? null); ?>"  placeholder="<?php echo e(translate('messages.search_notification')); ?>">
                                    <button type="submit" class="btn btn--secondary">
                                    <i class="tio-search"></i>
                                    </button>
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


                                    <a id="export-excel" class="dropdown-item" href="<?php echo e(route('admin.rental.notification.export', ['type'=>'excel' , request()->getQueryString()])); ?>">
                                        <img class="avatar avatar-xss avatar-4by3 mr-2"
                                            src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                            alt="Image Description">
                                        <?php echo e(translate('messages.excel')); ?>

                                    </a>
                                    <a id="export-csv" class="dropdown-item" href="<?php echo e(route('admin.rental.notification.export', ['type'=>'csv', request()->getQueryString()])); ?>">
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
                               class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                               data-hs-datatables-options='{
                                 "order": [],
                                 "orderCellsTop": true,
                                 "paging": false
                               }'>
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0"><?php echo e(translate('messages.SL')); ?></th>
                                    <th class="border-0"><?php echo e(translate('messages.title')); ?></th>
                                    <th class="border-0"><?php echo e(translate('messages.description')); ?></th>
                                    <th class="border-0"><?php echo e(translate('messages.image')); ?></th>
                                    <th class="border-0"><?php echo e(translate('messages.zone')); ?></th>
                                    <th class="border-0"><?php echo e(translate('messages.tergat')); ?></th>
                                    <th class="text-center border-0"><?php echo e(translate('messages.status')); ?></th>
                                    <th class="text-center border-0"><?php echo e(translate('messages.action')); ?></th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key+$notifications->firstItem()); ?></td>
                                    <td>
                                    <span title="<?php echo e($notification['title']); ?>" class="d-block font-size-sm text-body">
                                        <?php echo e(substr($notification['title'],0,25)); ?> <?php echo e(strlen($notification['title'])>25?'...':''); ?>

                                    </span>
                                    </td>
                                    <td title="<?php echo e($notification['description']); ?>">
                                        <?php echo e(substr($notification['description'],0,25)); ?> <?php echo e(strlen($notification['description'])>25?'...':''); ?>

                                    </td>
                                    <td>
                                        <?php if($notification['image']!=null): ?>
                                            <img class="h--50px onerror-image"
                                            src="<?php echo e($notification['image_full_url']); ?>"
                                                data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>">
                                        <?php else: ?>
                                            <label class="badge badge-soft-warning"><?php echo e(translate('No Image')); ?></label>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo e($notification->zone_id==null?translate('messages.all'):($notification->zone?$notification->zone->name:translate('messages.zone_deleted'))); ?>

                                    </td>
                                    <td class="text-uppercase">
                                        <?php echo e(translate($notification->tergat)); ?>

                                    </td>
                                    <td>
                                        <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox<?php echo e($notification->id); ?>">
                                            <input type="checkbox" data-url="<?php echo e(route('admin.rental.notification.status',[$notification['id'],$notification->status?0:1])); ?>" class="toggle-switch-input redirect-url" id="stocksCheckbox<?php echo e($notification->id); ?>" <?php echo e($notification->status?'checked':''); ?> hidden>
                                            <span class="toggle-switch-label mx-auto">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a class="btn action-btn btn--primary btn-outline-primary"
                                            href="<?php echo e(route('admin.rental.notification.edit',[$notification['id']])); ?>" title="<?php echo e(translate('messages.edit_notification')); ?>"><i class="tio-edit"></i>
                                            </a>
                                            <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:"
                                               data-id="notification-<?php echo e($notification['id']); ?>" data-message="<?php echo e(translate('Want to delete this notification ?')); ?>" title="<?php echo e(translate('messages.delete_notification')); ?>"><i class="tio-delete-outlined"></i>
                                            </a>
                                            <form action="<?php echo e(route('admin.rental.notification.delete',[$notification['id']])); ?>" method="post" id="notification-<?php echo e($notification['id']); ?>">
                                                <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if(count($notifications) !== 0): ?>
                    <hr>
                    <?php endif; ?>
                    <div class="page-area">
                        <?php echo $notifications->links(); ?>

                    </div>
                    <?php if(count($notifications) === 0): ?>
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
    <script src="<?php echo e(asset('Modules/Rental/public/assets/js/admin/view-pages/push-notification-list.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/push-notification/list.blade.php ENDPATH**/ ?>