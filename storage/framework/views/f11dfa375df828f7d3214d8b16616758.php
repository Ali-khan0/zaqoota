<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="card mt-3">
                <div class="card-body">
                    <div class="mar-ver pad-btm text-center mb-4">
                        <h1 class="h3">
                            Software Update
                        </h1>
                    </div>


                    <form method="POST" action="<?php echo e(route('update-system')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="bg-light p-4 rounded mb-4">
                            <div class="px-xl-2 pb-sm-3">
                                <div class="row gy-4">
                                    <div class="col-md-6">
                                        <div class="from-group">
                                            <label for="username" class="d-flex align-items-center gap-2 mb-2">
                                                <span class="fw-medium">Username</span>
                                                <span class="cursor-pointer" data-bs-toggle="tooltip"
                                                      data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                                                      data-bs-html="true"
                                                      data-bs-title="The username of your codecanyon account">
                                                      <img src="<?php echo e(asset('public/assets/installation')); ?>/assets/img/svg-icons/info2.svg" class="svg" alt="">
                                                </span>
                                            </label>
                                            <input type="text" id="username" class="form-control" name="username"
                                                   value="<?php echo e(env('BUYER_USERNAME')); ?>"
                                                   placeholder="Ex: John Doe" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="from-group">
                                            <label for="purchase_key" class="mb-2">Purchase Code</label>
                                            <input type="text" id="purchase_key" class="form-control" name="purchase_key"
                                                   value="<?php echo e(env('PURCHASE_CODE')); ?>"
                                                   placeholder="Ex: 19xxxxxx-ca5c-49c2-83f6-696a738b0000" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex gap-3 align-items-center mt-4">
                                    <img
                                        src="<?php echo e(asset('public/assets/installation')); ?>/assets/img/svg-icons/php-version.svg"
                                        alt="">
                                    <div
                                        class="d-flex align-items-center gap-2 justify-content-between flex-grow-1">
                                        PHP Version 8.2 +

                                        <?php ($phpVersion = number_format((float)phpversion(), 2, '.', '')); ?>
                                        <?php if($phpVersion >= 8.2): ?>
                                            <img width="20"
                                                 src="<?php echo e(asset('public/assets/installation')); ?>/assets/img/svg-icons/check.png"
                                                 alt="">
                                        <?php else: ?>
                                            <span class="cursor-pointer" data-bs-toggle="tooltip"
                                                  data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                                                  data-bs-html="true" data-bs-delay='{"hide":1000}'
                                                  data-bs-title="Your php version in server is lower than 8.2 version
                                                       <a href='https://support.cpanel.net/hc/en-us/articles/360052624713-How-to-change-the-PHP-version-for-a-domain-in-cPanel-or-WHM'
                                                       class='d-block' target='_blank'>See how to update</a> ">
                                                    <img
                                                        src="<?php echo e(asset('public/assets/installation')); ?>/assets/img/svg-icons/info.svg"
                                                        class="svg text-danger" alt="">
                                                </span>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-dark px-sm-5" <?php echo e($phpVersion >= 8.2?'':'disabled'); ?>>Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.blank', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/update/update-software.blade.php ENDPATH**/ ?>