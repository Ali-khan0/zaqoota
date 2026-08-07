<?php $__env->startSection('title', translate('messages.settings')); ?>

<?php $__env->startSection('3rd_party'); ?>
    active
<?php $__env->stopSection(); ?>
<?php $__env->startSection('openAI'); ?>
    active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <i class="tio-robot"></i>
                </span>
                <span><?php echo e(translate('OpenAI_Configuration')); ?>

                </span>
            </h1>
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-5 mt-4 __gap-12px">
                <div class="js-nav-scroller hs-nav-scroller-horizontal mt-2">
                    <!-- Nav -->
                    <ul class="nav nav-tabs border-0 nav--tabs nav--pills">
                        <li class="nav-item">
                            <a class="nav-link   <?php echo e(Request::is('admin/business-settings/open-ai') ? 'active' : ''); ?>"
                                href="<?php echo e(route('admin.business-settings.openAI')); ?>"
                                aria-disabled="true"><?php echo e(translate('AI Configuration')); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(Request::is('admin/business-settings/open-ai-settings') ? 'active' : ''); ?>"
                                href="<?php echo e(route('admin.business-settings.openAISettings')); ?>"
                                aria-disabled="true"><?php echo e(translate('AI Settings')); ?></a>
                        </li>
                    </ul>
                    <!-- End Nav -->
                </div>
            </div>
        </div>
        <!-- End Page Header -->


        <div class="col-12">

            <div class="card mt-2">
                <div class="card-header card-header-shadow">
                    <h5 class="card-title">
                        <span>
                            <span class="page-header-icon">
                                <i class="tio-robot"></i>
                            </span>
                            <?php echo e(translate('Vendor_limits_on_using_AI')); ?>

                        </span>

                    </h5>
                </div>

                <form action="<?php echo e(route('admin.business-settings.openAISettingsUpdate')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('put'); ?>
                    <div class="card-body">
                        <div class="py-2">
                            <div class="row g-3 align-items-end">

                                <div class="align-self-center  col-4">
                                    <div class="text-left">
                                        <h4 class="align-items-center">
                                            <span>
                                                <?php echo e(translate('Section_wise_data_generation')); ?>

                                            </span>
                                        </h4>
                                        <p>
                                            <?php echo e(translate('Set how many times  AI can generate data for each element of the vendor panel or app')); ?>

                                        </p>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="card __bg-F8F9FC-card text-left">
                                        <div class="card-body">
                                            <div class="form-group mb-0">
                                                <label class="input-label" for="section_wise_ai_limit">
                                                    <?php echo e(translate('Section_wise_data_generation_limit')); ?>

                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input id="section_wise_ai_limit" type="number" min="0" required
                                                    max="99999999999" class="form-control" name="section_wise_ai_limit"
                                                    value="<?php echo e($data['section_wise_ai_limit'] ?? ''); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 align-items-end">
                                <div class="align-self-center  col-4">
                                    <div class="text-left">
                                        <h4 class="align-items-center">
                                            <span>
                                                <?php echo e(translate('Image_based_data_generation')); ?>

                                            </span>
                                        </h4>
                                        <p>
                                            <?php echo e(translate('Set how many times AI can generate data from an image upload ')); ?>

                                        </p>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="card __bg-F8F9FC-card text-left">
                                        <div class="card-body">
                                            <div class="form-group mb-0">
                                                <label class="input-label" for="image_upload_limit_for_ai">
                                                    <?php echo e(translate('Image_upload_generation_limit')); ?>

                                                     <span class="text-danger">*</span>
                                                </label>
                                                <input id="image_upload_limit_for_ai" type="number" min="0" required
                                                    max="99999999999" class="form-control" name="image_upload_limit_for_ai"
                                                    value="<?php echo e($data['image_upload_limit_for_ai'] ?? ''); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="mb-4 mt-4 col-12">
                            <div class="btn--container justify-content-end">
                                <button type="reset" id="reset_btn"
                                    class="btn btn--reset location-reload"><?php echo e(translate('Reset')); ?></button>
                                <button type="<?php echo e(env('APP_MODE') != 'demo' ? 'submit' : 'button'); ?>" id="submit"
                                    class="btn btn--primary call-demo"><?php echo e(translate('Save_Information')); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/3rd_party/open_ai_settings.blade.php ENDPATH**/ ?>