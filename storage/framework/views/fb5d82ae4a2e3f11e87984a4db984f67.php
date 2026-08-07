<?php $__env->startSection('title', "6amMart Software Activation Check"); ?>

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="card mt-3">
                <div class="card-body">
                    <div class="mar-ver pad-btm text-center mb-4">
                        <h1 class="h3"><?php echo e("6amMart Software Activation Check"); ?></h1>
                    </div>

                    <form method="POST" action="<?php echo e(route('system.activation-check')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="bg-light p-4 rounded mb-4">
                            <div class="px-xl-2 pb-sm-3">
                                <div class="row gy-4">
                                    <div class="col-md-6">
                                        <div class="from-group">
                                            <label for="username" class="d-flex align-items-center gap-2 mb-2">
                                                <span class="fw-medium"><?php echo e("Codecanyon Username"); ?></span>
                                                <span class="cursor-pointer" data-bs-toggle="tooltip"
                                                      data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                                                      data-bs-html="true"
                                                      data-bs-title="The username of your codecanyon account">
                                                      <img class="svg" alt=""
                                                           src="<?php echo e(asset('public/assets/installation/assets/img/svg-icons/info2.svg')); ?>">
                                                </span>
                                            </label>
                                            <input type="text" id="username" class="form-control" name="username"
                                                   value="<?php echo e(env('BUYER_USERNAME') ??''); ?>"
                                                   placeholder="<?php echo e("Ex: John Doe"); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="from-group">
                                            <label for="purchase_key" class="mb-2"><?php echo e("Purchase Code"); ?></label>
                                            <input type="text" id="purchase_key" class="form-control"
                                                   name="purchase_key" value="<?php echo e(env('PURCHASE_CODE')??''); ?>"
                                                   placeholder="<?php echo e("Ex: 19xxxxxx-ca5c-49c2-83f6-696a738b0000"); ?>"
                                                   required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-dark px-sm-5"><?php echo e("Check"); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.blank', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/installation/activation-check.blade.php ENDPATH**/ ?>