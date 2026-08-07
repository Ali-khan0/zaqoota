<?php $__env->startSection('title',translate('Vehicle Bulk Import')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link href="<?php echo e(asset('public/assets/admin/css/tags-input.min.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/items.png')); ?>" class="w--22" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.items_bulk_import')); ?>

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
                                        <?php echo e(translate('Fill_up_the_data_according_to_the_format_and_validations.')); ?>

                                    </li>
                                    <li>
                                        <?php echo e(translate('You_can_get_store_id_module_id_and_unit_id_from_their_list_please_input_the_right_ids.')); ?>

                                    </li>
                                    <li>
                                        <?php echo e(translate('For_ecommerce_item_avaliable_time_start_and_end_will_be_00:00:00_and_23:59:59')); ?>

                                    </li>
                                    <li>
                                        <?php echo e(translate('If_you_want_to_create_a_product_with_variation,_just_create_variations_from_the_generate_variation_section_below_and_click_generate_value.')); ?>

                                    </li>
                                    <li>
                                        <?php echo e(translate('Copy_the_value_and_paste_the_the_spread_sheet_file_column_name_variation_in_the_selected_product_row.')); ?>

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
                                       <?php echo e(translate('In_the_Excel_file_upload_section,_first_select_the_upload_option.')); ?>

                                    </li>
                                    <li>
                                       <?php echo e(translate('Upload_your_file_in_.xls,_.xlsx_format.')); ?>

                                    </li>
                                    <li>
                                       <?php echo e(translate('Finally_click_the_upload_button.')); ?>

                                    </li>
                                    <li>
                                       <?php echo e(translate('You_can_upload_your_product_images_in_product_folder_from_gallery_and_copy_image`s_path.')); ?>

                                    </li>


                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center pb-4">
                    <h3 class="mb-3 export--template-title font-regular"><?php echo e(translate('download_spreadsheet_template')); ?></h3>
                    <div class="btn--container justify-content-center export--template-btns">
                        <a href="<?php echo e(asset('public/assets/vehicle_bulk_format_provider.xlsx')); ?>" download="" class="btn btn--primary btn-outline-primary"><?php echo e(translate('With Current Data')); ?></a>
                        <a href="<?php echo e(asset('public/assets/vehicle_bulk_format_nodata_provider.xlsx')); ?>" download="" class="btn btn--primary"><?php echo e(translate('Without Any Data')); ?></a>
                    </div>
                </div>
            </div>
        </div>
        <br>
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
                            <h5 class="text-capitalize mb-3"><?php echo e(translate('Import_items_file')); ?></h5>
                            <label class="uploadDnD d-block">
                                <div class="form-group inputDnD input_image input_image_edit position-relative">
                                    <div class="upload-text">
                                        <div>
                                            <img src="<?php echo e(asset('/public/assets/admin/img/bulk-import-3.png')); ?>" alt="">
                                        </div>
                                        <div class="filename"><?php echo e(translate('Must_be_Excel_files_using_our_Excel_template_above')); ?></div>
                                    </div>
                                    <input type="file" name="products_file" class="form-control-file text--primary font-weight-bold action-upload-section-dot-area" id="products_file">
                                </div>
                            </label>

                        </div>
                    </div>
                    <div class="btn--container justify-content-end mt-20">
                        <button id="reset_btn" type="reset"
                                data-alert="<?php echo e(translate('Must_be_Excel_files_using_our_Excel_template_above')); ?>"
                                class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                        <button type="button"
                                class="btn btn--primary update_or_import"
                                data-no="<?php echo e(translate('no')); ?>"
                                data-yes="<?php echo e(translate('yes')); ?>"
                                data-title="<?php echo e(translate('Are you sure?')); ?>"
                                data-desc="<?php echo e(translate('You_want_to_')); ?>"
                                data-text="<?php echo e(translate(' Data')); ?>">
                                <?php echo e(translate('messages.Upload')); ?>

                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/tags-input.min.js"></script>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/product-import.js"></script>
    <script src="<?php echo e(asset('Modules/Rental/public/assets/js/view-pages/provider/vehicle-bulk-import.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/provider/vehicle/bulk-import.blade.php ENDPATH**/ ?>