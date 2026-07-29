<?php $__env->startSection('title',translate('messages.banner')); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <div class="page-header">
        <h1 class="page-header-title">
            <span class="page-header-icon">
                <img src="<?php echo e(asset('public/assets/admin/img/3rd-party.png')); ?>" class="w--26" alt="">
            </span>
            <span>
                <?php echo e(translate('messages.Other_Promotional_Content_Setup')); ?>

            </span>
        </h1>
    </div>
    <div class="mb-20 mt-2">
        <div class="js-nav-scroller hs-nav-scroller-horizontal">
            <?php echo $__env->make('admin-views.other-banners.partial.parcel-links', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade show active">
            <div class="row g-3">
                <div class="col-lg-12 mb-3 mb-lg-2">
                    <div class="card h-100">
                        <form action="<?php echo e(route('admin.promotional-banner.store')); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <input type="text" name="key" value="promotional_banner"  hidden>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-12 d-flex justify-content-between">
                                            <span class="d-flex g-1">
                                                <img src="<?php echo e(asset('public/assets/admin/img/other-banner.png')); ?>" class="h-85" alt="">
                                                <h3 class="form-label d-block mb-2">
                                                    <?php echo e(translate('messages.Promotional Banners')); ?>

                                                </h3>
                                            </span>
                                        </div>
                                        <div class="col-12">
                                            <label class="__upload-img aspect-4-1 m-auto d-block">
                                                <div class="img">
                                                    <img class="onerror-image"    src="<?php echo e(asset('/public/assets/admin/img/upload-placeholder.png')); ?>" data-onerror-image="<?php echo e(asset('/public/assets/admin/img/upload-placeholder.png')); ?>" alt="">




                                                </div>
                                                    <input type="file" name="image"  hidden>
                                            </label>
                                            <div class="text-center mt-5">
                                                <h3 class="form-label d-block mt-2">
                                                <?php echo e(translate('Banner_Image_Ratio_4:1')); ?>

                                            </h3>
                                            <p><?php echo e(translate('image_format_:_jpg_,_png_,_jpeg_|_maximum_size:_2_MB')); ?></p>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn--container justify-content-end mt-20">
                                        <button type="submit" class="btn btn--primary mb-2"><?php echo e(translate('Submit')); ?></button>
                                    </div>
                                </div>
                            </form>
                            <?php ($banners=\App\Models\ModuleWiseBanner::where('module_id',Config::get('module.current_module_id'))->where('key','promotional_banner')->get()); ?>
                            
                                <div class="card-header py-2">
                                    <div class="search--button-wrapper">
                                        <h5 class="card-title"><?php echo e(translate('Promotional_Banner_List')); ?>

                                        </h5>
                                    </div>
                                </div>
                                <div class="card-body p-0">
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
                                                <th class="border-0"><?php echo e(translate('sl')); ?></th>
                                                <th class="border-0"><?php echo e(translate('Image')); ?></th>
                                                <th class="border-0"><?php echo e(translate('Status')); ?></th>
                                                <th class="text-center border-0"><?php echo e(translate('messages.action')); ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($key+1); ?></td>
                                                    <td>
                                                        <img src="<?php echo e($banner->value_full_url ?? asset('/public/assets/admin/img/upload-3.png')); ?>" data-toggle="modal"
                                                             data-target="#imagemodal<?php echo e($key); ?>"  data-onerror-image="<?php echo e(asset('/public/assets/admin/img/upload-3.png')); ?>" class="__size-105 onerror-image" alt="">
                                                        <div class="modal fade" id="imagemodal<?php echo e($key); ?>" tabindex="-1"
                                                             role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title" id="myModalLabel">
                                                                            <?php echo e(translate('messages.banner')); ?></h4>
                                                                        <button type="button" class="close"
                                                                                data-dismiss="modal"><span
                                                                                aria-hidden="true">&times;</span><span
                                                                                class="sr-only"><?php echo e(translate('messages.cancel')); ?></span></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <img src="<?php echo e($banner->value_full_url ?? asset('/public/assets/admin/img/upload-3.png')); ?>"
                                                                             class="initial--22 w-100">
                                                                    </div>







                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <label class="toggle-switch toggle-switch-sm">
                                                            <input type="checkbox" class="toggle-switch-input dynamic-checkbox"
                                                                   data-id="status-<?php echo e($banner->id); ?>"
                                                                   data-type="status"
                                                                   data-image-on="<?php echo e(asset('/public/assets/admin/img/modal')); ?>/promotional-on.png"
                                                                   data-image-off="<?php echo e(asset('/public/assets/admin/img/modal')); ?>/promotional-off.png"
                                                                   data-title-on="<?php echo e(translate('By Turning ONN Promotional Banner Section')); ?>"
                                                                   data-title-off="<?php echo e(translate('By Turning OFF Promotional Banner Section')); ?>"
                                                                   data-text-on="<p><?php echo e(translate('Promotional banner will be enabled. You will be able to see promotional activity')); ?></p>"
                                                                   data-text-off="<p><?php echo e(translate('Promotional banner will be disabled. You will be unable to see promotional activity')); ?></p>"
                                                                   id="status-<?php echo e($banner->id); ?>" <?php echo e($banner->status?'checked':''); ?>>
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                            </span>
                                                        </label>
                                                        <form action="<?php echo e(route('admin.promotional-banner.update-status',[$banner->id,$banner->status?0:1])); ?>" method="get" id="status-<?php echo e($banner->id); ?>_form">
                                                        </form>
                                                    </td>

                                                    <td>
                                                        <div class="btn--container justify-content-center">
                                                            <a class="btn action-btn btn--primary btn-outline-primary" href="<?php echo e(route('admin.promotional-banner.edit',[$banner['id']])); ?>">
                                                                <i class="tio-edit"></i>
                                                            </a>
                                                            <a class="btn action-btn btn--danger btn-outline-danger form-alert" href="javascript:"
                                                               data-id="banner-<?php echo e($banner['id']); ?>" data-message="<?php echo e(translate('Want to delete this banner ?')); ?>"
                                                             title="<?php echo e(translate('messages.delete_banner')); ?>"><i class="tio-delete-outlined"></i>
                                                            </a>
                                                            <form action="<?php echo e(route('admin.promotional-banner.delete',[$banner['id']])); ?>" method="post" id="banner-<?php echo e($banner['id']); ?>">
                                                                <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>

                                    </div>
                                    <!-- End Table -->
                                </div>
                                <?php if(count($banners) === 0): ?>
                                <div class="empty--data">
                                    <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                                    <h5>
                                        <?php echo e(translate('no_data_found')); ?>

                                    </h5>
                                </div>
                                <?php endif; ?>
                            
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/other-banners.js"></script>
        <script>
            $('#reset_btn').click(function(){
                $('#viewer').attr('src','<?php echo e(asset('/public/assets/admin/img/upload-placeholder.png')); ?>');
            })
        </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/other-banners/parcel-index.blade.php ENDPATH**/ ?>