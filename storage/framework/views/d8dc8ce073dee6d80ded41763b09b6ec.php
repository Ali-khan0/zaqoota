<?php $__env->startSection('title',translate('messages.Item Bulk Import')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link href="<?php echo e(asset('public/assets/admin/css/tags-input.min.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php ($store_data=\App\CentralLogics\Helpers::get_store_data()); ?>
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
        <div class="card">
            <div class="card-body">
                <div class="export-steps style-2">
                    <div class="export-steps-item">
                        <div class="inner">
                            <h5><?php echo e(translate('STEP 1')); ?></h5>
                            <p>
                                <?php echo e(translate('Download Excel File')); ?>

                            </p>
                        </div>
                    </div>
                    <div class="export-steps-item">
                        <div class="inner">
                            <h5><?php echo e(translate('STEP 2')); ?></h5>
                            <p>
                                <?php echo e(translate('Match Spread sheet data according to instruction')); ?>

                            </p>
                        </div>
                    </div>
                    <div class="export-steps-item">
                        <div class="inner">
                            <h5><?php echo e(translate('STEP 3')); ?></h5>
                            <p>
                                <?php echo e(translate('Validate data and complete import')); ?>

                            </p>
                        </div>
                    </div>
                </div>
                <div class="jumbotron pt-1 mb-0 pb-4 bg-white">
                    <h3><?php echo e(translate('messages.Instructions')); ?> : </h3>
                    <p><?php echo e(translate('1. Download the format file and fill it with proper data.')); ?></p>

                    <p><?php echo e(translate('2. You can download the example file to understand how the data must be filled.')); ?></p>

                    <p><?php echo e(translate('3. Once you have downloaded and filled the format file, upload it in the form below and submit.')); ?></p>
                    <p><?php echo e(translate('4. You can get store id, module id and unit id from their list, please input the right ids.')); ?></p>

                    <p><?php echo e(translate('5. For ecommerce item avaliable time start and end will be 00:00:00 and 23:59:59')); ?></p>

                    <p><?php echo e(translate('6. You can upload your product images in product folder from gallery, and copy image`s path.')); ?></p>
                    <p><?php echo e(translate('7. Image_file_name_must_be_in_30_character')); ?></p>

                </div>
                <div class="text-center pb-4">
                    <h3 class="mb-3 export--template-title"><?php echo e(translate('download_spreadsheet_template')); ?></h3>
                    <div class="btn--container justify-content-center export--template-btns">

                        <?php if($store_data->module->module_type == 'food'): ?>
                            <a href="<?php echo e(asset('public/assets/restaurant_panel/foods_bulk_format.xlsx')); ?>" download="" class="btn btn-dark"><?php echo e(translate('template_with_existing_data')); ?></a>
                        <?php else: ?>
                            <a href="<?php echo e(asset('public/assets/restaurant_panel/items_bulk_format.xlsx')); ?>" download="" class="btn btn-dark"><?php echo e(translate('template_with_existing_data')); ?></a>
                        <?php endif; ?>

                        <a href="<?php echo e(asset('public/assets/restaurant_panel/items_bulk_format_nodata.xlsx')); ?>" download="" class="btn btn-dark"><?php echo e(translate('template_without_data')); ?></a>
                    </div>
                </div>
            </div>
        </div>
        <form class="product-form" id="import_form" action="<?php echo e(route('vendor.item.bulk-import')); ?>" method="POST"
                enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="button" id="btn_value">
            <div class="card mt-2 rest-part">
                <div class="card-body">
                    <h4 class="mb-3"><?php echo e(translate('messages.import_items_file')); ?></h4>
                    <div class="custom-file custom--file">
                        <input type="file" name="products_file" class="form-control" id="products_file">
                        <label class="custom-file-label" for="products_file"><?php echo e(translate('messages.Choose File')); ?></label>
                    </div>
                    <div class="btn--container justify-content-end mt-20">
                        <button id="reset_btn" type="reset" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                        <button type="submit" name="button" value="update" class="btn btn--warning submit_btn"><?php echo e(translate('messages.update')); ?></button>
                        <button type="submit" name="button" value="import" class="btn btn--primary submit_btn"><?php echo e(translate('messages.Import')); ?></button>
                    </div>
                </div>
            </div>
        </form>

        <form action="javascript:" method="post" id="item_form" enctype="multipart/form-data">
            <div id="food_variation_section" style="display: none">
                <div class="card mt-2 rest-part">
                    <div class="card-header">
                        <h5 class="card-title">
                            
                            <span><?php echo e(translate('messages.food_variations_generator')); ?></span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-md-12">
                                <div id="add_new_option">
                                </div>
                                <br>
                                <div class="mt-2">
                                    <a class="btn btn-outline-success"
                                        id="add_new_option_button"><?php echo e(translate('add_new_variation')); ?></a>
                                </div> <br><br>
                            </div>
                        </div>
                        <div class="btn--container justify-content-end mb-3">
                            <button type="submit" class="btn btn--primary"><?php echo e(translate('generate')); ?></button>
                        </div>
                        <textarea name="" id="food_variation_outpot" class="form-control" rows="5" readonly></textarea>
                    </div>
                </div>
            </div>
        </form>
<br>
        <form action="javascript:" method="post" id="item_form_2" enctype="multipart/form-data">
            <div id="attribute_section" style="display: none">
                <h4 class="mb-3"><?php echo e(translate('Generate Variation')); ?></h4>
                <div class="card card mt-2 rest-part">
                    <div class="card-header border-0 p-0">
                        <div class="alert w-100 alert-soft-primary alert-dismissible fade show d-flex m-0" role="alert">
                            <div>
                                <img src="<?php echo e(asset('/public/assets/admin/img/icons/intel.png')); ?>" width="22" alt="">
                            </div>
                            <div class="w-0 flex-grow-1 pl-3">
                                <strong><?php echo e(translate('Attention!')); ?></strong>
                              <?php echo e(translate('You_must_generate_variations_from_this_generator_if_you_want_to_add_variations_to_your_products.You_must_copy_from_the_specific_filed_and_past_it_to_the_specific_column_at_your_excel_sheet.Otherwise_you_might_get_500_error_if_you_swap_or_entered_invalid_data.And_if_you_want_to_make_it_empty_then_you_have_to_enter_an_empty_array_[_]_.')); ?>

                            </div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                            <label class="input-label m-0"><?php echo e(translate('messages.attribute')); ?><span class="input-label-secondary"></span></label>
                            <button type="submit" class="btn btn--primary"><?php echo e(translate('generate value')); ?></button>
                        </div>
                        <div class="row g-2">
                            <div class="col-lg-6">
                                <div class="form-group mb-0">
                                    <select name="attribute_id[]" id="choice_attributes"
                                        class="form-control js-select2-custom" multiple="multiple">
                                        <?php $__currentLoopData = \App\Models\Attribute::orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($attribute['id']); ?>"><?php echo e($attribute['name']); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="customer_choice_options pt-3" id="customer_choice_options">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="variant_combination" id="variant_combination">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for=""><?php echo e(translate('messages.Generated_varient')); ?> <span class="form-label-secondary text-danger " data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('messages.This_field_is_for_geenrated_variation._copy_them_&_paste_into_excel_sheet')); ?> "><img src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>" alt="Veg non veg"> * </span></label>
                                <textarea name="" id="variation_output" class="form-control" rows="5" readonly></textarea>
                            </div>
                            <div class="col-md-4">
                                <label for=""><?php echo e(translate('messages.Generated_choice_option')); ?> <span class="form-label-secondary text-danger " data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('messages.Choice_option_is_required_if_you_are_using_product_variation')); ?>"><img src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>" alt="Veg non veg"> * </span></label>
                                <textarea name="" id="choice_output" class="form-control" rows="5" readonly></textarea>
                            </div>
                            <div class="col-md-4">
                                <label for=""><?php echo e(translate('messages.Generated_attributes_field')); ?> <span class="form-label-secondary text-danger " data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('messages.Attributes_is_required_if_you_are_using_product_variation')); ?>"><img src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>" alt="Veg non veg"> * </span></label>
                                <textarea name="" id="attributes" class="form-control" rows="5" readonly></textarea>
                            </div>
                        </div>

                        <div class="btn--container justify-content-end mt-2 mb-2">
                            <button type="reset" class="btn btn--reset"><?php echo e(translate('Reset')); ?></button>
                        </div>


                    </div>
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/tags-input.min.js"></script>
    <script>
        "use strict";
        let count = 0;
        let countRow = 0;
        let element = 0;
        $(document).ready(function() {
            <?php if($module_type== 'food'): ?>
            $('#food_variation_section').show();
            $('#attribute_section').hide();
            <?php else: ?>
            $('#food_variation_section').hide();
            $('#attribute_section').show();
            <?php endif; ?>
            $("#add_new_option_button").click(function(e) {
                count++;
                let add_option_view = `
                <div class="card view_new_option mb-2" >
                    <div class="card-header">
                        <label for="" id=new_option_name_` + count + `> <?php echo e(translate('add_new')); ?></label>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-lg-3 col-md-6">
                                <label for=""><?php echo e(translate('name')); ?></label>
                                 <input required name=options[` + count +
                    `][name] class="form-control new_option_name" type="text" data-count="`+
                    count +`">
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <label class="input-label text-capitalize d-flex alig-items-center"><span class="line--limit-1"><?php echo e(translate('messages.selcetion_type')); ?> </span>
                                    </label>
                                    <div class="resturant-type-group border">
                                        <label class="form-check form--check mr-2 mr-md-4">
                                                <input class="form-check-input show_min_max" data-count="`+count+`" type="radio" value="multi"
                                                name="options[` + count + `][type]" id="type` + count +
                    `" checked
                                                >
                                                <span class="form-check-label">
                                                    <?php echo e(translate('Multiple Selection')); ?>

                    </span>
                </label>

                <label class="form-check form--check mr-2 mr-md-4">
                    <input class="form-check-input hide_min_max" data-count="`+count+`" type="radio" value="single"
                                                name="options[` + count + `][type]" id="type` + count +
                    `"
                                                >
                                                <span class="form-check-label">
                                                    <?php echo e(translate('Single Selection')); ?>

                    </span>
                </label>
        </div>
    </div>
    </div>
    <div class="col-12 col-lg-6">
    <div class="row g-2">
        <div class="col-sm-6 col-md-4">
            <label for=""><?php echo e(translate('Min')); ?></label>
                                        <input id="min_max1_` + count + `" required  name="options[` + count + `][min]" class="form-control" type="number" min="1">
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <label for=""><?php echo e(translate('Max')); ?></label>
                                        <input id="min_max2_` + count + `"   required name="options[` + count + `][max]" class="form-control" type="number" min="1">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="d-md-block d-none">&nbsp;</label>
                                            <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <input id="options[` + count + `][required]" name="options[` +
                    count + `][required]" type="checkbox">
                                                <label for="options[` + count + `][required]" class="m-0"><?php echo e(translate('Required')); ?></label>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-danger btn-sm delete_input_button"
                                                    title="<?php echo e(translate('Delete')); ?>">
                                                    <i class="tio-add-to-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="option_price_` + count + `" >
                            <div class="border rounded p-3 pb-0 mt-3">
                                <div  id="option_price_view_` + count + `">
                                    <div class="row g-3 add_new_view_row_class mb-3">
                                        <div class="col-md-4 col-sm-6">
                                            <label for=""><?php echo e(translate('Option_name')); ?></label>
                                            <input class="form-control" required type="text" name="options[` +
                    count +
                    `][values][0][label]" id="">
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <label for=""><?php echo e(translate('Additional_price')); ?></label>
                                            <input class="form-control" required type="number" min="0" step="0.01" name="options[` +
                    count + `][values][0][optionPrice]" id="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3 p-3 mr-1 d-flex "  id="add_new_button_` + count +
                    `">
                                   <button type="button" class="btn btn--primary btn-outline-primary add_new_row_button" data-count="`+
                    count +`" ><?php echo e(translate('Add_New_Option')); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;

                $("#add_new_option").append(add_option_view);
            });
        });

        function show_min_max(data) {
            $('#min_max1_' + data).removeAttr("readonly");
            $('#min_max2_' + data).removeAttr("readonly");
            $('#min_max1_' + data).attr("required", "true");
            $('#min_max2_' + data).attr("required", "true");
        }

        function hide_min_max(data) {
            $('#min_max1_' + data).val(null).trigger('change');
            $('#min_max2_' + data).val(null).trigger('change');
            $('#min_max1_' + data).attr("readonly", "true");
            $('#min_max2_' + data).attr("readonly", "true");
            $('#min_max1_' + data).attr("required", "false");
            $('#min_max2_' + data).attr("required", "false");
        }

        $(document).on('change', '.show_min_max', function () {
            let data = $(this).data('count');
            show_min_max(data);
        });

        $(document).on('change', '.hide_min_max', function () {
            let data = $(this).data('count');
            hide_min_max(data);
        });




        function new_option_name(value, data) {
            $("#new_option_name_" + data).empty();
            $("#new_option_name_" + data).text(value)
            console.log(value);
        }

        function removeOption(e) {
            element = $(e);
            element.parents('.view_new_option').remove();
        }

        $(document).on('click', '.delete_input_button', function () {
            let e = $(this);
            removeOption(e);
        });

        function deleteRow(e) {
            element = $(e);
            element.parents('.add_new_view_row_class').remove();
        }

        $(document).on('click', '.deleteRow', function () {
            let e = $(this);
            deleteRow(e);
        });


        function add_new_row_button(data) {
            count = data;
            countRow = 1 + $('#option_price_view_' + data).children('.add_new_view_row_class').length;
            let add_new_row_view = `
        <div class="row add_new_view_row_class mb-3 position-relative pt-3 pt-sm-0">
            <div class="col-md-4 col-sm-5">
                    <label for=""><?php echo e(translate('Option_name')); ?></label>
                    <input class="form-control" required type="text" name="options[` + count + `][values][` +
                countRow + `][label]" id="">
                </div>
                <div class="col-md-4 col-sm-5">
                    <label for=""><?php echo e(translate('Additional_price')); ?></label>
                    <input class="form-control"  required type="number" min="0" step="0.01" name="options[` +
                count +
                `][values][` + countRow + `][optionPrice]" id="">
                </div>
                <div class="col-sm-2 max-sm-absolute">
                    <label class="d-none d-sm-block">&nbsp;</label>
                    <div class="mt-1">
                        <button type="button" class="btn btn-danger btn-sm deleteRow"
                            title="<?php echo e(translate('Delete')); ?>">
                            <i class="tio-add-to-trash"></i>
                        </button>
                    </div>
            </div>
        </div>`;
            $('#option_price_view_' + data).append(add_new_row_view);

        }

        $(document).on('click', '.add_new_row_button', function () {
            let data = $(this).data('count');
            add_new_row_button(data);
        });

        $(document).on('keyup', '.new_option_name', function () {
            let data = $(this).data('count');
            let value = $(this).val();
            new_option_name(value, data);
        });

        $('#choice_attributes').on('change', function() {
            $('#customer_choice_options').html(null);
            $('#variant_combination').html(null);
            $.each($("#choice_attributes option:selected"), function() {
                if ($(this).val().length > 50) {
                    toastr.error(
                        '<?php echo e(translate('validation.max.string', ['attribute' => translate('messages.variation'), 'max' => '50'])); ?>', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    return false;
                }
                add_more_customer_choice_option($(this).val(), $(this).text());
            });
        });

        function add_more_customer_choice_option(i, name) {
        let n = name;

        $('#customer_choice_options').append(
            `<div class="__choos-item"><div><input type="hidden" name="choice_no[]" value="${i}"><input type="text" class="form-control d-none" name="choice[]" value="${n}" placeholder="<?php echo e(translate('messages.choice_title')); ?>" readonly> <label class="form-label">${n}</label> </div><div><input type="text" class="form-control combination_update" name="choice_options_${i}[]" placeholder="<?php echo e(translate('messages.enter_choice_values')); ?>" data-role="tagsinput"></div></div>`
        );
        $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
    }

        function combination_update() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "<?php echo e(route('vendor.item.variant-combination')); ?>",
                data: $('#item_form_2').serialize() + '&stock=' + true,
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    $('#loading').hide();
                    $('#variant_combination').html(data.view);
                    if (data.length < 1) {
                        $('input[name="current_stock"]').attr("readonly", false);
                    }
                }
            });
        }

        $(document).on('change', '.combination_update', function () {
            combination_update();
        });

        $('#item_form_2').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '<?php echo e(route('vendor.item.variation-generate')); ?>',
                data: $('#item_form_2').serialize(),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    $('#loading').hide();
                    if (data.errors) {
                        for (let i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                    $('#variation_output').val(data.variation),
                    $('#choice_output').val(data.choice_options),
                    $('#attributes').val(data.attributes)
                    }
                }
            });
        });

        $('#item_form').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '<?php echo e(route('vendor.item.food-variation-generate')); ?>',
                data: $('#item_form').serialize(),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#loading').show();
                },
                success: function(data) {
                    $('#loading').hide();
                    if (data.errors) {
                        for (let i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        $('#food_variation_outpot').val(data.variation)
                    }
                }
            });
        });

        $('#reset_btn').click(function(){
            $('#bulk__import').val(null);
        })


        $(document).on("click", ".submit_btn", function(e){
            e.preventDefault();
            let data = $(this).val();
            myFunction(data)
        });


        function myFunction(data) {
            Swal.fire({
                title: '<?php echo e(translate('Are you sure?')); ?>' ,
                text: "<?php echo e(translate('You_want_to_')); ?>" +data,
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#FC6A57',
                cancelButtonText: '<?php echo e(translate('messages.no')); ?>',
                confirmButtonText: '<?php echo e(translate('messages.yes')); ?>',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $('#btn_value').val(data);
                    $("#import_form").submit();
                }
            })
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/product/bulk-import.blade.php ENDPATH**/ ?>