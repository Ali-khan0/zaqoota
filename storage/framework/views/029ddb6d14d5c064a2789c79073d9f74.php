<div class="col-lg-12">
    <div class="general_wrapper">
        <div class="outline-wrapper">
            <div class="card shadow--card-2 border-0 bg-animate">
                <div class="card-header">
                    <h5 class="card-title">
                        <span class="card-header-icon mr-2">
                            <i class="tio-tune-horizontal"></i>
                        </span>
                        <span> <?php echo e(translate('Store_&_Category_Info')); ?> </span>
                    </h5>
                    <?php if(isset($openai_config) && data_get($openai_config, 'status') == 1): ?>
                        <button type="button"
                            class="btn bg-white text-primary opacity-1 generate_btn_wrapper p-0 mb-2 general_setup_auto_fill"
                            id="general_setup_auto_fill"
                            data-route="<?php echo e(route('admin.product.general-setup-auto-fill')); ?>"
                            data-error="<?php echo e(translate('Please provide an item name and description so the AI can generate a suitable data.')); ?>"
                            data-restaurant-id=""
                            data-lang="en">
                            <div class="btn-svg-wrapper">
                                <img width="18" height="18" class=""
                                    src="<?php echo e(asset('public/assets/admin/img/svg/blink-right-small.svg')); ?>"
                                    alt="">
                            </div>
                            <span class="ai-text-animation d-none" role="status">
                                <?php echo e(translate('Just_a_second')); ?>

                            </span>
                            <span class="btn-text"><?php echo e(translate('Generate')); ?></span>
                        </button>
                    <?php endif; ?>

                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <?php ($column = 4); ?>
                        <?php if(Auth::guard('admin')->check()): ?>
                            <div class="col-sm-6 col-lg-3">

                                <div class="form-group mb-0 error-wrapper">
                                    <label class="input-label" for="store_id"><?php echo e(translate('messages.store')); ?> <span
                                            class="form-label-secondary text-danger" data-toggle="tooltip"
                                            data-placement="right"
                                            data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                        </span><span class="input-label-secondary"></span></label>
                                    <select name="store_id" id="store_id"
                                        title="<?php echo e(translate('messages.select_store')); ?>"
                                        <?php echo e(isset(request()->product_gellary) == false ? 'required' : ''); ?>

                                        data-placeholder="<?php echo e(translate('messages.select_store')); ?>"
                                        class="js-data-example-ajax form-control">
                                        <?php if(isset($product->store) && request()->product_gellary != 1): ?>
                                            <option value="<?php echo e($product->store_id); ?>" selected="selected">
                                                <?php echo e($product->store->name); ?></option>
                                        <?php endif; ?>
                                    </select>
                                </div>


                            </div>
                            <?php ($column = 3); ?>
                            <div class="col-sm-6 col-lg-<?php echo e($column); ?>">
                                <div class="form-group mb-0 error-wrapper">
                                    <label class="input-label"
                                        for="exampleFormControlSelect1"><?php echo e(translate('messages.category')); ?><span
                                            class="form-label-secondary text-danger" data-toggle="tooltip"
                                            data-placement="right"
                                            data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                        </span></label>
                                    <select name="category_id" id="category_id"
                                        data-placeholder="<?php echo e(translate('Select_Category')); ?>"
                                        <?php if(!Auth::guard('admin')->check()): ?> data-url="<?php echo e(url('/')); ?>/vendor-panel/item/get-categories?parent_id=" data-id="sub-categories" <?php endif; ?>
                                        class="form-control js-data-example-ajax get-request" required>

                                        <?php if(isset($category)): ?>
                                            <option selected value="<?php echo e($category['id']); ?>"><?php echo e($category['name']); ?>

                                            </option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="col-sm-6 col-lg-4">
                                <div class="form-group mb-0 error-wrapper">
                                    <label class="input-label"
                                        for="exampleFormControlSelect1"><?php echo e(translate('messages.category')); ?><span
                                            class="input-label-secondary">*</span></label>
                                    <select name="category_id" id="category_id"
                                        class="form-control js-select2-custom get-request"
                                        data-url="<?php echo e(url('/')); ?>/vendor-panel/item/get-categories?parent_id="
                                        data-id="sub-categories">
                                        <option value="">---<?php echo e(translate('messages.select')); ?>---</option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option
                                                    value="<?php echo e($category['id']); ?>" <?php echo e(isset($product) && $category->id==$product_category[0]->id ? 'selected' : ''); ?> ><?php echo e($category['name']); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                        <?php endif; ?>



                        <div class="col-sm-6 col-lg-<?php echo e($column); ?>">


                            <div class="form-group mb-0 error-wrapper">
                                <label class="input-label"
                                    for="exampleFormControlSelect1"><?php echo e(translate('messages.sub_category')); ?><span
                                        class="form-label-secondary" data-toggle="tooltip" data-placement="right"
                                        data-original-title="<?php echo e(translate('messages.category_required_warning')); ?>"><img
                                            src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>"
                                            alt="<?php echo e(translate('messages.category_required_warning')); ?>"></span></label>



                                <select name="sub_category_id"
                                    data-placeholder="<?php echo e(translate('Select_Sub_Category')); ?>"
                                    class="js-data-example-ajax form-control" id="sub-categories">
                                    <?php if(isset($sub_category)): ?>
                                        <option value="<?php echo e($sub_category['id']); ?>"><?php echo e($sub_category['name']); ?>

                                        </option>
                                    <?php endif; ?>
                                </select>
                            </div>


                        </div>

                        <?php if(Config::get('module.current_module_type') == 'food'): ?>
                            <div class="col-sm-6 col-lg-<?php echo e($column); ?>" id="veg_input">
                                <div class="form-group mb-0 error-wrapper">
                                    <label class="input-label"
                                        for="exampleFormControlInput1"><?php echo e(translate('messages.item_type')); ?> <span
                                            class="form-label-secondary text-danger" data-toggle="tooltip"
                                            data-placement="right"
                                            data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                        </span></label>
                                    <select name="veg" id="veg" class="form-control js-select2-custom"
                                        required>
                                        <option <?php echo e(isset($product) && $product->veg == 1 ? 'selected' : ''); ?>

                                            value="1"><?php echo e(translate('messages.veg')); ?></option>
                                        <option <?php echo e(isset($product) && $product->veg == 0 ? 'selected' : ''); ?>

                                            value="0"><?php echo e(translate('messages.non_veg')); ?></option>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>




                        <?php if(Config::get('module.current_module_type') == 'pharmacy'): ?>

                            <div class="col-sm-6 col-lg-<?php echo e($column); ?>" id="condition_input">

                                <div class="form-group mb-0 error-wrapper">
                                    <label class="input-label"
                                        for="condition_id"><?php echo e(translate('messages.Suitable_For')); ?><span
                                            class="input-label-secondary"></span></label>
                                    <select name="condition_id" id="condition_id"
                                        data-placeholder="<?php echo e(translate('messages.Select_Condition')); ?>"
                                        class="js-data-example-ajax form-control">

                                        <?php if(isset($product?->pharmacy_item_details?->common_condition_id)): ?>
                                            <option value="<?php echo e($product->pharmacy_item_details->common_condition_id); ?>"
                                                selected="selected">
                                                <?php echo e($product->pharmacy_item_details?->common_condition->name); ?></option>
                                        <?php elseif(isset($temp_product) && $temp_product == 1 && $product->common_condition_id): ?>
                                            <option value="<?php echo e($product->common_condition_id); ?>" selected="selected">
                                                <?php echo e($product->common_condition->name); ?></option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if(Config::get('module.current_module_type') == 'ecommerce'): ?>

                            <div class="col-sm-6 col-lg-<?php echo e($column); ?>" id="brand_input">
                                <div class="form-group mb-0 error-wrapper">
                                    <label class="input-label" for="brand_id"><?php echo e(translate('messages.Brand')); ?><span
                                            class="input-label-secondary"></span></label>
                                    <select name="brand_id" id="brand_id"
                                        data-placeholder="<?php echo e(translate('messages.Select_brand')); ?>"
                                        class="js-data-example-ajax form-control">
                                        <?php if(isset($product->ecommerce_item_details?->brand_id)): ?>
                                            <option value="<?php echo e($product->ecommerce_item_details->brand_id); ?>"
                                                selected="selected">
                                                <?php echo e($product->ecommerce_item_details?->brand->name); ?></option>
                                        <?php elseif(isset($temp_product) && $temp_product == 1 && $product->brand_id): ?>
                                            <option value="<?php echo e($product->brand_id); ?>" selected="selected">
                                                <?php echo e($product->brand->name); ?></option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if(Config::get('module.current_module_type') != 'food'): ?>

                            <div class="col-sm-6 col-lg-<?php echo e($column); ?>" id="unit_input">
                                <div class="form-group mb-0 error-wrapper">
                                    <label class="input-label text-capitalize"
                                        for="unit"><?php echo e(translate('messages.unit')); ?></label>
                                    <select name="unit" id="unit"
                                        data-placeholder="<?php echo e(translate('messages.select_unit')); ?>"
                                        class="form-control js-select2-custom">
                                        <?php $__currentLoopData = \App\Models\Unit::get(['id', 'unit']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($unit->id); ?>"
                                                <?php echo e(isset($product) && $unit->id == $product->unit_id ? 'selected' : ''); ?>>
                                                <?php echo e($unit->unit); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>




                        <?php if(Config::get('module.current_module_type') == 'grocery' || Config::get('module.current_module_type') == 'food'): ?>
                            <?php if(isset($temp_product) && $temp_product == 1): ?>
                                <?php ($product_nutritions = \App\Models\Nutrition::whereIn('id', json_decode($product?->nutrition_ids))->pluck('id')); ?>
                                <?php ($product_allergies = \App\Models\Allergy::whereIn('id', json_decode($product?->allergy_ids))->pluck('id')); ?>
                            <?php else: ?>
                                <?php ($product_nutritions = isset($product) ? $product->nutritions->pluck('id') : null); ?>
                                <?php ($product_allergies = isset($product) ? $product->allergies->pluck('id') : null); ?>
                            <?php endif; ?>

                            <div class="col-sm-6 col-lg-6 error-wrapper" id="nutrition">
                                <label class="input-label" for="">
                                    <?php echo e(translate('Nutrition')); ?>

                                    <span class="input-label-secondary"
                                        title="<?php echo e(translate('Specify the necessary keywords relating to energy values for the item and type this content & press enter.')); ?>"
                                        data-toggle="tooltip">
                                        <i class="tio-info-outined"></i>
                                    </span>
                                </label>
                                <select name="nutritions[]" id="nutritions_input"
                                    class="form-control multiple-select2"
                                    data-placeholder="<?php echo e(translate('messages.Type your content and press enter')); ?>"
                                    multiple>
                                    <?php ($nutritions = \App\Models\Nutrition::select(['id','nutrition'])->get() ?? []); ?>
                                    <?php $__currentLoopData = $nutritions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nutrition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option
                                            <?php echo e($product_nutritions && $product_nutritions->contains($nutrition->id) ? 'selected' : ''); ?>

                                            value="<?php echo e($nutrition->nutrition); ?>"><?php echo e($nutrition->nutrition); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>


                            <div class="col-sm-6 col-lg-6 error-wrapper" id="allergy">
                                <label class="input-label" for="">
                                    <?php echo e(translate('Allegren Ingredients')); ?>

                                    <span class="input-label-secondary"
                                        title="<?php echo e(translate('Specify the ingredients of the item which can make a reaction as an allergen and type this content & press enter.')); ?>"
                                        data-toggle="tooltip">
                                        <i class="tio-info-outined"></i>
                                    </span>
                                </label>
                                <select name="allergies[]" class="form-control multiple-select2" id="allergy_input"
                                    data-placeholder="<?php echo e(translate('messages.Type your content and press enter')); ?>"
                                    multiple>
                                    <?php ($allergies = \App\Models\Allergy::select(['id','allergy'])->get() ?? []); ?>

                                    <?php $__currentLoopData = $allergies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allergy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option
                                            <?php echo e($product_allergies && $product_allergies->contains($allergy->id) ? 'selected' : ''); ?>

                                            value="<?php echo e($allergy->allergy); ?>"><?php echo e($allergy->allergy); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        <?php endif; ?>



                        <?php if(Config::get('module.current_module_type') == 'grocery' || Config::get('module.current_module_type') == 'food'): ?>
                            <div class="col-sm-6 col-lg-4 error-wrapper" id="halal">
                                <div class="form-check mb-sm-2 pb-sm-1">
                                    <input class="form-check-input" name="is_halal" type="checkbox" value="1"
                                        id="is_halal"
                                        <?php echo e(isset($product) && $product->is_halal == 1 ? 'checked' : (isset($temp_product) && $temp_product == 1 && $product->is_halal == 1 ? 'checked' : '')); ?>>
                                    <label class="form-check-label" for="is_halal">
                                        <?php echo e(translate('messages.Is_It_Halal')); ?>

                                    </label>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if(Config::get('module.current_module_type') == 'pharmacy'): ?>
                            <div class="col-sm-6 col-lg--6 error-wrapper" id="generic_name">
                                <label class="input-label" for="sub-categories">
                                    <?php echo e(translate('generic_name')); ?>

                                    <span class="input-label-secondary"
                                        title="<?php echo e(translate('Specify the medicine`s active ingredient that makes it work')); ?>"
                                        data-toggle="tooltip">
                                        <i class="tio-info-outined"></i>
                                    </span>
                                </label>
                                <div class="dropdown suggestion_dropdown">
                                    <input type="text" id="generic_name_input"
                                        value="<?php echo e((isset($temp_product) && $temp_product == 1 ? \App\Models\GenericName::where('id', json_decode($product?->generic_ids))->first()?->generic_name : isset($product)) ? $product?->generic->pluck('generic_name')->first() : ''); ?>"
                                        class="form-control" name="generic_name" autocomplete="off">
                                    <?php ($generic_names = \App\Models\GenericName::select(['id','generic_name'])->get() ?? []); ?>
                                    <?php if(count($generic_names) > 0): ?>
                                        <div class="dropdown-menu">
                                            <?php $__currentLoopData = $generic_names ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $generic_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="dropdown-item"><?php echo e($generic_name->generic_name); ?></div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-4 error-wrapper" id="basic">
                                <div class="form-check mb-sm-2 pb-sm-1">
                                    <input class="form-check-input" name="basic" type="checkbox" value="1"
                                        id="is_basic_medicine"
                                        <?php echo e(isset($product) && $product->pharmacy_item_details?->is_basic == 1 ? 'checked' : (isset($temp_product) && $temp_product == 1 && $product->basic == 1 ? 'checked' : '')); ?>>
                                    <label class="form-check-label" for="is_basic_medicine">
                                        <?php echo e(translate('messages.Is_Basic_Medicine')); ?>

                                    </label>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-4 error-wrapper" id="is_prescription_required">
                                <div class="form-check mb-sm-2 pb-sm-1">
                                    <input class="form-check-input" name="is_prescription_required" type="checkbox"
                                        value="1" id="prescription_required"
                                        <?php echo e(isset($product) && $product->pharmacy_item_details?->is_prescription_required == 1 ? 'checked' : (isset($temp_product) && $temp_product == 1 && $product->is_prescription_required == 1 ? 'checked' : '')); ?>>
                                    <label class="form-check-label" for="prescription_required">
                                        <?php echo e(translate('messages.is_prescription_required')); ?>

                                    </label>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if(Config::get('module.current_module_type') == 'grocery'): ?>
                            <div class="col-sm-6 col-lg-4 error-wrapper" id="organic">
                                <div class="form-check mb-sm-2 pb-sm-1">
                                    <input class="form-check-input" name="organic" type="checkbox" value="1"
                                        id="is_organic"
                                        <?php echo e(isset($product) && $product->organic == 1 ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="is_organic">
                                        <?php echo e(translate('messages.is_organic')); ?>

                                    </label>
                                </div>
                            </div>
                        <?php endif; ?>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(Config::get('module.current_module_type') == 'food'): ?>
    <?php if(Auth::guard('admin')->check()): ?>
        <div class="col-lg-6" id="addon_input">
            <div class="general_wrapper">
                <div class="outline-wrapper">
                    <div class="card shadow--card-2 border-0 bg-animate">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon mr-2">
                                    <i class="tio-dashboard-outlined"></i>
                                </span>
                                <span><?php echo e(translate('messages.addon')); ?></span>
                            </h5>
                        </div>
                        <div class="card-body error-wrapper">
                            <label class="input-label"
                                for="exampleFormControlSelect1"><?php echo e(translate('Select_Add-on')); ?><span
                                    class="input-label-secondary" data-toggle="tooltip" data-placement="right"
                                    data-original-title="<?php echo e(translate('messages.The_selected_addon’s_will_be_displayed_in_this_food_details')); ?>"><img
                                        src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>"
                                        alt="<?php echo e(translate('messages.The_selected_addon’s_will_be_displayed_in_this_food_details')); ?>"></span></label>
                            <select name="addon_ids[]" class="form-control border js-select2-custom"
                                multiple="multiple" id="add_on">

                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="col-lg-6">
            <div class="general_wrapper">
                <div class="outline-wrapper">
                    <div class="card shadow--card-2 border-0 bg-animate">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon"><i class="tio-puzzle"></i></span>
                                <span><?php echo e(translate('addon')); ?></span>
                            </h5>
                        </div>
                        <div class="card-body pb-0">
                            <div class="row g-2">
                                <div class="col-12">
                                    <div class="form-group error-wrapper">
                                        <label class="input-label"
                                            for="exampleFormControlSelect1"><?php echo e(translate('messages.addon')); ?><span
                                                class="input-label-secondary"></span></label>
                                        <select name="addon_ids[]" class="form-control js-select2-custom" id="add_on"
                                            multiple="multiple">
                                            <?php $__currentLoopData = \App\Models\AddOn::where('store_id', \App\CentralLogics\Helpers::get_store_id())->orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($addon['id']); ?>"
                                                    <?php echo e(isset($product) && in_array($addon->id, json_decode($product['add_ons'], true)) ? 'selected' : ''); ?>>
                                                    <?php echo e($addon['name']); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="col-lg-6" id="time_input">
        <div class="general_wrapper">
            <div class="outline-wrapper">
                <div class="card shadow--card-2 border-0 bg-animate">
                    <div class="card-header">
                        <h5 class="card-title">
                            <span class="card-header-icon mr-2"><i class="tio-date-range"></i></span>
                            <span><?php echo e(translate('time_schedule')); ?></span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-sm-6">
                                <div class="form-group mb-0 error-wrapper">
                                    <label class="input-label"
                                        for="exampleFormControlInput1"><?php echo e(translate('messages.available_time_starts')); ?><span
                                            class="form-label-secondary text-danger" data-toggle="tooltip"
                                            data-placement="right"
                                            data-original-title="<?php echo e(translate('messages.Required.')); ?>">
                                            *
                                        </span></label>
                                    <input type="time" name="available_time_starts"
                                        value="<?php echo e(isset($product) ? $product?->available_time_starts : old('available_time_starts')); ?>"
                                        class="form-control" id="available_time_starts"
                                        placeholder="<?php echo e(translate('messages.Ex:_10:30_am')); ?> " required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group mb-0 error-wrapper">
                                    <label class="input-label"
                                        for="exampleFormControlInput1"><?php echo e(translate('messages.available_time_ends')); ?><span
                                            class="form-label-secondary text-danger" data-toggle="tooltip"
                                            data-placement="right"
                                            data-original-title="<?php echo e(translate('messages.Required.')); ?>">
                                            *
                                        </span></label>
                                    <input type="time" name="available_time_ends" class="form-control"
                                        value="<?php echo e(isset($product) ? $product?->available_time_ends : old('available_time_ends')); ?>"
                                        id="available_time_ends" placeholder="5:45 pm" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>


<div class="col-lg-12">
    <div class="general_wrapper">
        <div class="outline-wrapper">
            <div class="card shadow--card-2 border-0 bg-animate">
                <div class="card-header">
                    <h5 class="card-title">
                        <span class="card-header-icon mr-2"><i class="tio-label"></i></span>
                        <span><?php echo e(translate('Seaech_Tags')); ?></span>
                    </h5>
                </div>
                <div class="card-body">


                    <?php if(isset($temp_product) && $temp_product == 1): ?>
                        <div class="form-group error-wrapper">
                            <?php ($tags = \App\Models\Tag::whereIn('id', json_decode($product?->tag_ids))->get('tag')); ?>
                            <input type="text" class="form-control" id="tags" name="tags"
                                placeholder="<?php echo e(translate('messages.search_tags')); ?>"
                                value="<?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($c->tag . ','); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>"
                                data-role="tagsinput">
                        </div>
                    <?php else: ?>
                        <div class="form-group error-wrapper">
                            <input type="text" class="form-control" id="tags" name="tags"
                                placeholder="<?php echo e(translate('messages.search_tags')); ?>"
                                <?php if(isset($product)): ?> value="<?php $__currentLoopData = $product->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($c->tag . ','); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>" <?php endif; ?>
                                data-role="tagsinput">
                        </div>
                    <?php endif; ?>


                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/product/partials/_category_and_general.blade.php ENDPATH**/ ?>