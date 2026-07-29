<?php $__env->startSection('title',translate('messages.gallery')); ?>
<?php $__env->startSection('content'); ?>
<div class="content container-fluid">

        <div class="page-header">

        </div>
    <!-- Page Heading -->
    <div class="page-header d-flex flex-wrap justify-content-between">
        <h1 class="page-header-title">
            <span class="page-header-icon">
                <img src="<?php echo e(asset('public/assets/admin/img/folder-logo.png')); ?>" class="w--26" alt="">
            </span>
            <span>
                <?php echo e(translate('messages.gallery')); ?>

            </span>
        </h1>
    </div>
    <div class="mb-20 mt-2">
        <div class="js-nav-scroller hs-nav-scroller-horizontal">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-20 __gap-12px">
                <div class="js-nav-scroller hs-nav-scroller-horizontal mt-2">
                    <!-- Nav -->
                    <ul class="nav nav-tabs border-0 nav--tabs nav--pills">
                        <li class="nav-item">
                            <a class="nav-link <?php echo e($storage == 'local' ? 'active' : ''); ?>"
                               href="<?php echo e(route('admin.business-settings.file-manager.index', ['folder_path'=>'cHVibGlj', 'storage'=>'local'])); ?>"><?php echo e(translate('local_storage')); ?></a>
                        </li>
                        <?php if(\App\CentralLogics\Helpers::getDisk() == 's3'): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e($storage == 's3' ? 'active' : ''); ?>"
                               href="<?php echo e(route('admin.business-settings.file-manager.index', ['folder_path'=>'cHVibGlj', 'storage'=>'s3'])); ?>"><?php echo e(translate('S3_bucket')); ?></a>
                        </li>
                        <?php endif; ?>
                    </ul>
                    <!-- End Nav -->
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
            <div class="card-header">
                <?php
                    $pwd = explode('/',base64_decode($folder_path));
                    $awsUrl = config('filesystems.disks.s3.url');
                    $awsBucket = config('filesystems.disks.s3.bucket');
                ?>
                    <h5 class="card-title"><?php echo e(end($pwd) == ''?'Root':end($pwd)); ?> <span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e(count($data)); ?></span></h5>
                <div class="d-flex flex-wrap justify-content-between">
                    <button type="button" class="btn btn--primary modalTrigger mr-3" data-toggle="modal" data-target="#exampleModal">
                        <i class="tio-add-circle"></i>
                        <span class="text"><?php echo e(translate('messages.add_new')); ?></span>
                    </button>
                    <a class="btn btn-sm badge-soft-primary" href="<?php echo e(url()->previous()); ?>"><i class="tio-arrow-long-left mr-2"></i><?php echo e(translate('messages.back')); ?></a>
                </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-6 col-sm-auto">
                            <?php if($file['type']=='folder'): ?>
                            <a class="btn p-0 btn--folder"  href="<?php echo e(route('admin.business-settings.file-manager.index', [base64_encode($file['path']),$storage])); ?>">
                                <img class="img-thumbnail border-0 p-0" src="<?php echo e(asset('public/assets/admin/img/folder.png')); ?>" alt="">
                                <p><?php echo e(Str::limit($file['name'],10)); ?></p>
                            </a>
                            <?php elseif($file['type']=='file'): ?>

                                <div class="folder-btn-item mx-auto">
                                <button class="btn p-0 w-100" title="<?php echo e($file['name']); ?>">
                                    <div class="gallary-card">
                                        <img src="<?php echo e($storage == 's3'? Storage::disk($storage)->url($file['path']) : asset('storage/app/'.$file['path'])); ?>" alt="<?php echo e($file['name']); ?>" class="w-100 rounded">

                                    </div>
                                    <small class="overflow-hidden text-title"><?php echo e(Str::limit($file['name'],10)); ?></small>
                                </button>
                                <div class="btn-items">
                                    <a href="#" title="<?php echo e(translate('View Image')); ?>" data-toggle="tooltip" data-placement="left">
                                        <img src="<?php echo e(asset('/public/assets/admin/img/download/view.png')); ?>" data-toggle="modal" data-target="#imagemodal<?php echo e($key); ?>" alt="">
                                    </a>
                                    <a href="#" title="<?php echo e(translate('Copy Link')); ?>" class="copy-test" data-toggle="tooltip" data-placement="left" data-file-path="<?php echo e($file['db_path']); ?>">
                                        <img src="<?php echo e(asset('/public/assets/admin/img/download/link.png')); ?>" alt="">
                                    </a>
                                    <a title="<?php echo e(translate('Download')); ?>" data-toggle="tooltip" data-placement="left" href="<?php echo e(route('admin.business-settings.file-manager.download', [base64_encode($file['path']),$storage])); ?>">
                                        <img src="<?php echo e(asset('/public/assets/admin/img/download/download.png')); ?>" alt="">
                                    </a>
                                    <form action="<?php echo e(route('admin.business-settings.file-manager.destroy',base64_encode($file['path']))); ?>" method="post"  class="form-submit-warning">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('delete'); ?>
                                        <button type="submit" title="<?php echo e(translate('Delete')); ?>" data-toggle="tooltip" data-placement="left"><i class="tio-delete"></i></button>
                                    </form>
                                </div>
                            </div>
                            <div class="modal fade" id="imagemodal<?php echo e($key); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog max-w-640">
                                    <div class="modal-content">
                                        <button type="button" class="close right-top-close-icon" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                        <div class="modal-header p-1">
                                            <div class="gallery-modal-header w-100">
                                                <span><?php echo e($file['name']); ?></span>
                                                <a href="#" class="d-block ml-auto copy-test" data-file-path="<?php echo e($file['db_path']); ?>">
                                                    <?php echo e(translate('Copy Path')); ?> <i class="tio-link"></i>
                                                </a>
                                                <a class="d-block" href="<?php echo e(route('admin.business-settings.file-manager.download', [base64_encode($file['path']),$storage])); ?>">
                                                    <?php echo e(translate('Download')); ?> <i class="tio-download-to"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="modal-body p-1 pt-0">
                                            <img src="<?php echo e($storage == 's3'? Storage::disk($storage)->url($file['path']) : asset('storage/app/'.$file['path'])); ?>" class="w-100">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="indicator"></div>
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><?php echo e(translate('messages.upload_file')); ?> </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo e(route('admin.business-settings.file-manager.image-upload')); ?>"  method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="text" name="path" value = "<?php echo e(base64_decode($folder_path)); ?>" hidden>
                    <input type="text" name="disk" value = "<?php echo e($storage); ?>" hidden>
                    <div class="form-group">
                        <label class="input-label"
                               for="exampleFormControlInput1"><?php echo e(translate('messages.upload_image')); ?></label>
                        <div class="custom-file">
                            <input type="file" name="images[]" id="customFileUpload" class="custom-file-input" accept=".webp, .jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" multiple>
                            <label class="custom-file-label" for="customFileUpload"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="input-label"
                               for="exampleFormControlInput1"><?php echo e(translate('messages.upload_zip_file')); ?></label>
                        <div class="custom-file">
                            <input type="file" name="file" id="customZipFileUpload" class="custom-file-input" accept=".zip">
                            <label class="custom-file-label" id="zipFileLabel" for="customZipFileUpload"></label>
                        </div>
                    </div>

                    <div class="row" id="files"></div>
                    <div class="form-group mb-0">
                        <input class="btn btn--primary text-white" type="submit" value="<?php echo e(translate('messages.upload')); ?>">
                    </div>
                </form>
            </div>
          </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="how-it-works">
        <div class="modal-dialog modal-lg warning-modal">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <h3 class="modal-title mb-3"><?php echo e(translate('Check how the settings works')); ?></h3>
                    </div>
                    <img src="<?php echo e(asset('/public/assets/admin/img/zone-instruction.png')); ?>" alt="admin/img" class="w-100">
                    <div class="mt-3 d-flex flex-wrap align-items-center justify-content-end">
                        <div class="btn--container justify-content-end">
                            <button id="reset_btn" type="reset" class="btn btn--reset" data-dismiss="modal"><?php echo e(translate("Close")); ?></button>
                            <button type="submit" class="btn btn--primary" data-dismiss="modal"><?php echo e(translate('Got It')); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/file-manager.js"></script>
<script>
    "use strict";

    function form_submit_warrning(e) {
        e.preventDefault();
        Swal.fire({
            title: "<?php echo e(translate('Are you sure?')); ?>",
            text: "<?php echo e(translate('you_want_to_delete')); ?>",
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: 'default',
            confirmButtonColor: '#FC6A57',
            cancelButtonText: '<?php echo e(translate('messages.no')); ?>',
            confirmButtonText: '<?php echo e(translate('messages.yes')); ?>',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                e.target.submit();
                // this.submit();
            }
        })
    };

</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/file-manager/index.blade.php ENDPATH**/ ?>