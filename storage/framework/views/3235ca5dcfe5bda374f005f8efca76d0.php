<?php $__env->startSection('title',translate('Provider Bulk Import')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/resturant.png')); ?>" class="w--20" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.Providers_bulk_import')); ?>

                </span>
            </h1>
        </div>
        <!-- Content Row -->
        <div class="card">
            <div class="card-body">
                <div class="export-steps-2">
                    <div class="row g-4">
                        <div class="col-sm-6 col-lg-4">
                            <div class="export-steps-item-2 h-100">
                                <div class="top">
                                    <div>
                                        <h3 class="fs-20"><?php echo e(translate('Step 1')); ?></h3>
                                        <div>
                                            <?php echo e(translate('Download_Excel_File')); ?>

                                        </div>
                                    </div>
                                    <img src="<?php echo e(asset('/public/assets/admin/img/bulk-import-1.png')); ?>" alt="">
                                </div>
                                <h4><?php echo e(translate('Instruction')); ?></h4>
                                <ul class="m-0 pl-4">
                                    <li>
                                        <?php echo e(translate('Download_the_format_file_and_fill_it_with_proper_data.')); ?>

                                    </li>
                                    <li>
                                        <?php echo e(translate('You_can_download_the_example_file_to_understand_how_the_data_must_be_filled.')); ?>

                                    </li>
                                    <li>
                                        <?php echo e(translate('Have_to_upload_excel_file.')); ?>

                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="export-steps-item-2 h-100">
                                <div class="top">
                                    <div>
                                        <h3 class="fs-20"><?php echo e(translate('Step 2')); ?></h3>
                                        <div>
                                            <?php echo e(translate('Match_Spread_sheet_data_according_to_instruction')); ?>

                                        </div>
                                    </div>
                                    <img src="<?php echo e(asset('/public/assets/admin/img/bulk-import-2.png')); ?>" alt="">
                                </div>
                                <h4><?php echo e(translate('Instruction')); ?></h4>
                                <ul class="m-0 pl-4">
                                    <li>
                                        <?php echo e(translate('Download the format file and fill it with proper data.')); ?>

                                    </li>
                                    <li>
                                        <?php echo e(translate('You can download the example file to understand how the data must be filled.')); ?>

                                    </li>
                                    <li>
                                        <?php echo e(translate('Have to upload zip file')); ?>

                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="export-steps-item-2 h-100">
                                <div class="top">
                                    <div>
                                        <h3 class="fs-20"><?php echo e(translate('Step 3')); ?></h3>
                                        <div>
                                            <?php echo e(translate('Validate data and complete import')); ?>

                                        </div>
                                    </div>
                                    <img src="<?php echo e(asset('/public/assets/admin/img/bulk-import-3.png')); ?>" alt="">
                                </div>
                                <h4><?php echo e(translate('Instruction')); ?></h4>
                                <ul class="m-0 pl-4">
                                    <li>
                                        <?php echo e(translate('Download the format file and fill it with proper data.')); ?>

                                    </li>
                                    <li>
                                        <?php echo e(translate('You can download the example file to understand how the data must be filled.')); ?>

                                    </li>
                                    <li>
                                        <?php echo e(translate('Have to upload zip file')); ?>

                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center pb-4">
                    <h3 class="mb-3 export--template-title font-regular"><?php echo e(translate('download_spreadsheet_template')); ?></h3>
                    <div class="btn--container justify-content-center export--template-btns">

                        <a href="<?php echo e(asset('public/assets/providers_bulk_format.xlsx')); ?>" download="" class="btn btn--primary btn-outline-primary"><?php echo e(translate('Template with Existing Data')); ?></a>
                        <a href="<?php echo e(asset('public/assets/providers_bulk_format_nodata.xlsx')); ?>" download="" class="btn btn--primary"><?php echo e(translate('Template without Data')); ?></a>

                    </div>
                </div>
            </div>
        </div>



        <form class="product-form" id="import_form" action="" method="POST"
        enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

        <input type="hidden" name="button" id="btn_value">
        <div class="card mt-2 rest-part">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <h5 class="text-capitalize mb-3"><?php echo e(translate('Select_Data_Upload_type')); ?></h5>
                        <div class="module-radio-group border rounded">
                            <label class="form-check form--check">
                                <input class="form-check-input "   value="import" type="radio" name="upload_type" checked>
                                <span class="form-check-label py-20">
                                    <?php echo e(translate('Upload_New_Data')); ?>

                                </span>
                            </label>
                            <label class="form-check form--check">
                                <input class="form-check-input " value="update" type="radio" name="upload_type">
                                <span class="form-check-label py-20">
                                    <?php echo e(translate('Update_Existing_Data')); ?>

                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <h5 class="text-capitalize mb-3"><?php echo e(translate('Import_Providers_file')); ?></h5>
                        <label class="uploadDnD d-block">
                            <div class="form-group inputDnD input_image input_image_edit position-relative">
                                <div class="upload-text">
                                    <div>
                                        <img src="<?php echo e(asset('/public/assets/admin/img/bulk-import-3.png')); ?>" alt="">
                                    </div>
                                    <div data-text="<?php echo e(translate('Must_be_Excel_files_using_our_Excel_template_above')); ?>" class="filename"><?php echo e(translate('Must_be_Excel_files_using_our_Excel_template_above')); ?></div>
                                </div>
                                <input type="file" name="products_file" class="form-control-file text--primary font-weight-bold action-upload-section-dot-area" id="products_file">
                            </div>
                        </label>

                    </div>
                </div>
                <div class="btn--container justify-content-end mt-20">
                    <button id="reset_btn" type="reset" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                    <button type="button" data-massage="<?php echo e(translate('You_want_to_')); ?>" data-title="<?php echo e(translate('Are you sure?')); ?>" data-yes="<?php echo e(translate('messages.Yes')); ?>" data-no="<?php echo e(translate('messages.No')); ?>" class="btn btn--primary update_or_import"><?php echo e(translate('messages.Upload')); ?></button>
                </div>
            </div>
        </div>
    </form>
</div>


    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
<script src="<?php echo e(asset('Modules/Rental/public/assets/js/admin/view-pages/provider-bulk-import.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/provider/bulk-import.blade.php ENDPATH**/ ?>