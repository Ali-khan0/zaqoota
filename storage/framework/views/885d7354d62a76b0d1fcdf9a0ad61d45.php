<?php $__env->startSection('title',translate('Update campaign')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link href="<?php echo e(asset('public/assets/admin/css/tags-input.min.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/edit.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.update_campaign')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <form
        id="campaign_form"
                enctype="multipart/form-data" class="custom-validation" data-ajax="true">
                <div class="row g-2">
                <?php ($language=\App\Models\BusinessSetting::where('key','language')->first()); ?>
                <?php ($language = $language->value ?? null); ?>
                <?php ($defaultLang = str_replace('_', '-', app()->getLocale())); ?>
                <?php if($language): ?>
                <div class="col-12">
                    <ul class="nav nav-tabs mb-3 border-0">
                        <li class="nav-item">
                            <a class="nav-link lang_link active"
                            href="#"
                            id="default-link"><?php echo e(translate('messages.default')); ?></a>
                        </li>
                        <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="nav-item">
                                <a class="nav-link lang_link"
                                    href="#"
                                    id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <?php endif; ?>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon">
                                    <i class="tio-fastfood"></i>
                                </span>
                                <span><?php echo e(translate('messages.Item Info')); ?></span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php if($language): ?>
                            <div class="lang_form" id="default-form">
                                <div class="form-group error-wrapper">
                                    <label class="input-label" for="default_title"><?php echo e(translate('messages.title')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                    <input type="text" name="title[]" id="default_title" class="form-control" placeholder="<?php echo e(translate('messages.new_food')); ?>" value="<?php echo e($campaign?->getRawOriginal('title')); ?>" required>
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                                <div class="form-group pt-2 mb-0 error-wrapper">
                                    <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.short_description')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                    <textarea type="text" name="description[]" class="form-control ckeditor min--height-200" required><?php echo $campaign?->getRawOriginal('description'); ?></textarea>
                                </div>
                            </div>
                                <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        if(count($campaign['translations'])){
                                            $translate = [];
                                            foreach($campaign['translations'] as $t)
                                            {
                                                if($t->locale == $lang && $t->key=="title"){
                                                    $translate[$lang]['title'] = $t->value;
                                                }
                                                if($t->locale == $lang && $t->key=="description"){
                                                    $translate[$lang]['description'] = $t->value;
                                                }
                                            }
                                        }
                                    ?>
                                    <div class="d-none lang_form" id="<?php echo e($lang); ?>-form">
                                        <div class="form-group error-wrapper">
                                            <label class="input-label" for="<?php echo e($lang); ?>_title"><?php echo e(translate('messages.title')); ?> (<?php echo e(strtoupper($lang)); ?>)</label>
                                            <input type="text" name="title[]" id="<?php echo e($lang); ?>_title" class="form-control" placeholder="<?php echo e(translate('messages.new_food')); ?>" value="<?php echo e($translate[$lang]['title']??''); ?>">
                                        </div>
                                        <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                        <div class="form-group pt-2 mb-0 error-wrapper">
                                            <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.short_description')); ?> (<?php echo e(strtoupper($lang)); ?>)</label>
                                            <textarea type="text" name="description[]" class="form-control ckeditor min--height-200"><?php echo $translate[$lang]['description']??''; ?></textarea>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                            <div id="default-form">
                                <div class="form-group error-wrapper">
                                    <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.title')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                    <input type="text" name="title[]" class="form-control" placeholder="<?php echo e(translate('messages.new_food')); ?>" value="<?php echo e($campaign['title']); ?>">
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                                <div class="form-group pt-2 mb-0 error-wrapper">
                                    <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.short_description')); ?></label>
                                    <textarea type="text" name="description[]" class="form-control ckeditor min--height-200"><?php echo $campaign['description']; ?></textarea>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon">
                                    <i class="tio-comment-image-outlined"></i>
                                </span>
                                <span><?php echo e(translate('messages.Item Image')); ?></span>
                            </h5>
                        </div>
                        <div class="error-wrapper">
                            <div class="card-body d-flex flex-column">
                                <label>
                                    <?php echo e(translate('messages.item_image')); ?>

                                    <small class="text-danger">* ( <?php echo e(translate('messages.ratio')); ?> 1:1 )</small>
                                </label>

                                <div id="image-viewer-section" class="text-center py-3 my-auto">
                                    <img class="img--120 onerror-image" id="viewer"
                                    src="<?php echo e($campaign->image_full_url); ?>" alt="campaign image" data-onerror-image="<?php echo e(asset('public/assets/admin/img/100x100/2.png')); ?>"/>
                                </div>
                                <div class="custom-file">
                                    <input type="file" name="image" id="customFileEg1" class="custom-file-input"
                                            accept=".webp, .jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    <label class="custom-file-label" for="customFileEg1"><?php echo e(translate('messages.choose_file')); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon">
                                    <i class="tio-dashboard-outlined"></i>
                                </span>
                                <span><?php echo e(translate('messages.Item Details')); ?></span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group mb-0 error-wrapper">
                                        <label class="input-label" for="exampleFormControlSelect1"><?php echo e(translate('messages.store')); ?><span
                                                class="input-label-secondary"></span></label>
                                        <select name="store_id" class="js-data-example-ajax form-control" id="store_id"  data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('messages.select_store')); ?>" disabled>
                                            <?php if($campaign->store): ?>
                                            <option value="<?php echo e($campaign->store->id); ?>" selected><?php echo e($campaign->store->name); ?></option>
                                            <?php else: ?>
                                            <option selected disabled><?php echo e(translate('messages.select_store')); ?></option>
                                            <?php endif; ?>
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-3 col-sm-6" id="stock_input">
                                    <div class="form-group mb-0 error-wrapper">
                                        <label class="input-label" for="total_stock"><?php echo e(translate('messages.total_stock')); ?></label>
                                        <input type="number" class="form-control" name="current_stock" value="<?php echo e($campaign->stock); ?>" id="quantity">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3" id="maximum_cart_quantity">
                                    <div class="form-group mb-0 error-wrapper">
                                        <label class="input-label"
                                            for="maximum_cart_quantity"><?php echo e(translate('messages.maximum_cart_quantity')); ?></label>
                                        <input type="number" class="form-control" name="maximum_cart_quantity" value="<?php echo e($campaign->maximum_cart_quantity); ?>" min="0" id="cart_quantity">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6" id="addon_input">
                                    <div class="form-group mb-0 error-wrapper">
                                        <label class="input-label" for="exampleFormControlSelect1"><?php echo e(translate('messages.addon')); ?><span
                                                class="input-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('messages.store_required_warning')); ?>"><img src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>" alt="<?php echo e(translate('messages.store_required_warning')); ?>"></span></label>
                                        <select name="addon_ids[]" id="add_on" class="form-control js-select2-custom" multiple="multiple">
                                            <?php $__currentLoopData = \App\Models\AddOn::orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($addon['id']); ?>" <?php echo e(in_array($addon->id,json_decode($campaign['add_ons'],true))?'selected':''); ?>><?php echo e($addon['name']); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group mb-0">
                                        <label class="input-label" for="exampleFormControlSelect1"><?php echo e(translate('messages.category')); ?><span
                                                class="input-label-secondary">*</span></label>
                                        <select name="category_id" class="js-data-example-ajax form-control" id="category_id" required>
                                            <?php if($category): ?>
                                                <option value="<?php echo e($category['id']); ?>" ><?php echo e($category['name']); ?></option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group mb-0 error-wrapper">
                                        <label class="input-label" for="exampleFormControlSelect1"><?php echo e(translate('messages.sub_category')); ?><span
                                                class="input-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('messages.category_required_warning')); ?>"><img src="<?php echo e(asset('/public/assets/admin/img/info-circle.svg')); ?>" alt="<?php echo e(translate('messages.category_required_warning')); ?>"></span></label>
                                        <select name="sub_category_id" class="js-data-example-ajax form-control" id="sub-categories">
                                            <?php if(isset($sub_category)): ?>
                                            <option value="<?php echo e($sub_category['id']); ?>" ><?php echo e($sub_category['name']); ?></option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 co-sml-6">
                                    <div class="form-group error-wrapper" id="veg_non_veg">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.item_type')); ?></label>
                                        <select name="veg" class="form-control js-select2-custom">
                                            <option value="0" <?php echo e($campaign['veg']==0?'selected':''); ?>><?php echo e(translate('messages.non_veg')); ?></option>
                                            <option value="1" <?php echo e($campaign['veg']==1?'selected':''); ?>><?php echo e(translate('messages.veg')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <?php if(Config::get('module.current_module_type') == 'pharmacy'): ?>
                                <div class="col-sm-6" id="generic_name">
                                    <label class="input-label" for="sub-categories">
                                        <?php echo e(translate('generic_name')); ?>

                                        <span class="input-label-secondary" title="<?php echo e(translate('Specify the medicine`s active ingredient that makes it work')); ?>" data-toggle="tooltip">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                    </label>
                                    <div class="error-wrapper">
                                        <div class="dropdown suggestion_dropdown">
                                            <input type="text" class="form-control" data-toggle="dropdown" placeholder="<?php echo e(translate('messages.Type your content here')); ?>" name="generic_name" value="<?php echo e($campaign->generic->pluck('generic_name')->first()); ?>" autocomplete="off">
                                            <?php if(count(\App\Models\GenericName::select(['generic_name'])->get())>0): ?>
                                                <div class="dropdown-menu">
                                                    <?php $__currentLoopData = \App\Models\GenericName::select(['generic_name'])->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $generic_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="dropdown-item"><?php echo e($generic_name->generic_name); ?></div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="row g-2">
                                <?php if(Config::get('module.current_module_type') == 'grocery' || Config::get('module.current_module_type') == 'food'): ?>

                                        <?php ($campaign_nutritions = $campaign->nutritions->pluck('id')); ?>
                                        <?php ($campaign_allergies = $campaign->allergies->pluck('id')); ?>


                                    <div class="col-sm-6 error-wrapper" id="nutrition">
                                        <label class="input-label" for="sub-categories">
                                            <?php echo e(translate('Nutrition')); ?>

                                            <span class="input-label-secondary" title="<?php echo e(translate('Specify the necessary keywords relating to energy values for the item.')); ?>" data-toggle="tooltip">
                                                <i class="tio-info-outined"></i>
                                            </span>
                                        </label>
                                        <select name="nutritions[]" class="form-control multiple-select2" data-placeholder="<?php echo e(translate('messages.Type your content and press enter')); ?>" multiple>
                                            <?php $__currentLoopData = \App\Models\Nutrition::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nutrition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($nutrition->nutrition); ?>" <?php echo e($campaign_nutritions->contains($nutrition->id) ? 'selected' : ''); ?>><?php echo e($nutrition->nutrition); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>


                                    <div class="col-sm-6 error-wrapper" id="allergy">
                                        <label class="input-label" for="sub-categories">
                                            <?php echo e(translate('Allegren Ingredients')); ?>

                                            <span class="input-label-secondary" title="<?php echo e(translate('Specify the ingredients of the item which can make a reaction as an allergen.')); ?>" data-toggle="tooltip">
                                                <i class="tio-info-outined"></i>
                                            </span>
                                        </label>
                                        <select name="allergies[]" class="form-control multiple-select2" data-placeholder="<?php echo e(translate('messages.Type your content and press enter')); ?>" multiple>
                                            <?php $__currentLoopData = \App\Models\Allergy::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allergy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($allergy->allergy); ?>" <?php echo e($campaign_allergies->contains($allergy->id) ? 'selected' : ''); ?>><?php echo e($allergy->allergy); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon"><i class="tio-dollar-outlined"></i></span>
                                <span>
                                    <?php echo e(translate('messages.amount')); ?>

                                </span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group mb-0 error-wrapper">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.price')); ?></label>
                                        <input type="number" min="1" max="999999999" step="0.01" value="<?php echo e($campaign->price); ?>" name="price" class="form-control"
                                                placeholder="<?php echo e(translate('messages.Ex:')); ?> 100" required>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group mb-0 error-wrapper">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.discount')); ?><span class="input-label-secondary text--title" data-toggle="tooltip"
                                            data-placement="right"
                                            data-original-title="<?php echo e(translate('Currently you need to manage discount with store.')); ?>">
                                            <i class="tio-info-outined"></i>
                                        </span></label>
                                        <input type="number" min="0" max="999999999" value="<?php echo e($campaign->discount); ?>" name="discount" class="form-control"
                                                placeholder="<?php echo e(translate('messages.Ex:')); ?> 100" >
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group mb-0 error-wrapper">
                                        <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.discount_type')); ?></label>
                                        <select name="discount_type" class="form-control js-select2-custom">
                                            <option value="percent" <?php echo e($campaign->discount_type == 'percent'?'selected':''); ?>><?php echo e(translate('messages.percent')); ?></option>
                                            <option value="amount" <?php echo e($campaign->discount_type == 'amount'?'selected':''); ?>><?php echo e(translate('messages.amount')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 co-sml-6">
                                    <div class="form-group mb-0 error-wrapper" id="unit_input">
                                        <label class="input-label text-capitalize" for="unit"><?php echo e(translate('messages.unit')); ?></label>
                                        <select name="unit" class="form-control js-select2-custom">
                                            <?php $__currentLoopData = \App\Models\Unit::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($unit->id); ?>" <?php echo e($unit->id == $campaign->unit_id? 'selected':''); ?>><?php echo e($unit->unit); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                       <?php if($productWiseTax): ?>
                <div class="col-lg-12">
                    <div class="card shadow--card-2 border-0">
                        <div class="card-header flex-wrap">
                            <h5 class="card-title">
                                <span class="card-header-icon mr-2">
                                    <i class="tio-canvas-text"></i>
                                </span>
                                <span><?php echo e(translate('messages.Tax_Information')); ?></span>
                            </h5>
                        </div>
                        <div class="card-body error-wrapper">
                                <span class="mb-2 d-block title-clr fw-normal"><?php echo e(translate('Select Tax Rate')); ?></span>
                                <select name="tax_ids[]" required id="tax__rate" class="form-control js-select2-custom"
                                    multiple="multiple" placeholder="Type & Select Tax Rate">
                                    <?php $__currentLoopData = $taxVats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxVat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php echo e(in_array($taxVat->id, $taxVatIds) ? 'selected' : ''); ?> value="<?php echo e($taxVat->id); ?>"> <?php echo e($taxVat->name); ?>

                                            (<?php echo e($taxVat->tax_rate); ?>%)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                            </div>
                        </div>
                    </div>

                    <?php endif; ?>

                <div class="col-lg-12" id="food_variation_section">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon">
                                    <i class="tio-canvas-text"></i>
                                </span>
                                <span> <?php echo e(translate('messages.food_variations')); ?></span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-md-12 error-wrapper" >
                                    <div id="add_new_option">
                                    <?php if(isset($campaign->food_variations)): ?>
                                        <?php $__currentLoopData = json_decode($campaign->food_variations,true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_choice_options=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(isset($item["price"])): ?>
                                                <?php break; ?>
                                            <?php else: ?>
                                                <?php echo $__env->make('admin-views.product.partials._new_variations',['item'=>$item,'key'=>$key_choice_options+1], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <button type="button" class="btn btn-outline-success" id="add_new_option_button"><?php echo e(translate('add_new_variation')); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" id="attribute_section">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon">
                                    <i class="tio-canvas-text"></i>
                                </span>
                                <span><?php echo e(translate('messages.Add Attribute')); ?></span>
                            </h5>
                        </div>
                        <div class="card-body pb-0">
                            <div class="row g-2">
                                <div class="col-12">
                                    <div class="form-group mb-0 error-wrapper">
                                        <label class="input-label" for="exampleFormControlSelect1"><?php echo e(translate('messages.attribute')); ?><span class="input-label-secondary"></span></label>
                                        <select name="attribute_id[]" id="choice_attributes" class="form-control js-select2-custom" multiple="multiple">
                                            <?php $__currentLoopData = \App\Models\Attribute::orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($attribute['id']); ?>" <?php echo e(in_array($attribute->id,json_decode($campaign['attributes'],true))?'selected':''); ?>><?php echo e($attribute['name']); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="customer_choice_options error-wrapper" id="customer_choice_options">
                                        <?php echo $__env->make('admin-views.product.partials._choices',['choice_no'=>json_decode($campaign['attributes']),'choice_options'=>json_decode($campaign['choice_options'],true)], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="variant_combination error-wrapper" id="variant_combination">
                                        <?php echo $__env->make('admin-views.product.partials._edit-combinations',['combinations'=>json_decode($campaign['variations'],true),'stock'=>config('module.'.$campaign->module->module_type)['stock']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon"><i class="tio-date-range"></i></span>
                                <span><?php echo e(translate('messages.time_schedule')); ?></span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group error-wrapper">
                                        <label class="input-label" for="title"><?php echo e(translate('messages.start_date')); ?></label>
                                        <input type="date" id="date_from" class="form-control" required="" name="start_date" value="<?php echo e($campaign->start_date->format('Y-m-d')); ?>">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group error-wrapper">
                                        <label class="input-label" for="title"><?php echo e(translate('messages.end_date')); ?></label>
                                        <input type="date" id="date_to" class="form-control" required="" name="end_date" value="<?php echo e($campaign->end_date->format('Y-m-d')); ?>">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group error-wrapper">
                                        <label class="input-label" for="title"><?php echo e(translate('messages.start_time')); ?></label>
                                        <input type="time" id="start_time" class="form-control" name="start_time" value="<?php echo e($campaign->start_time->format('H:i')); ?>">
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group error-wrapper">
                                        <label class="input-label" for="title"><?php echo e(translate('messages.end_time')); ?></label>
                                        <input type="time" id="end_time" class="form-control" name="end_time" value="<?php echo e($campaign->end_time->format('H:i')); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="btn--container justify-content-end mt-2">
                        <button type="reset" id="reset_btn" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.update')); ?></button>
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
        let element = "";
        function getStoreData(route, id) {
            $.get({
                url: route,
                dataType: 'json',
                success: function (data) {
                    $('#' + id).empty().append(data.options);
                },
            });
        }
        function getRequest(route, id) {
            $.get({
                url: route,
                dataType: 'json',
                success: function (data) {
                    $('#' + id).empty().append(data.options);
                },
            });
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this);
            $('#viewer').show(1000)
        });

        $(document).ready(function () {
            <?php if(count(json_decode($campaign['add_ons'], true))>0): ?>
            getStoreData('<?php echo e(url('/')); ?>/admin/store/get-addons?store_id=<?php echo e($campaign['store_id']); ?><?php $__currentLoopData = json_decode($campaign['add_ons'], true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>&data[]=<?php echo e($addon); ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>','add_on');
            <?php else: ?>
            getStoreData('<?php echo e(url('/')); ?>/admin/store/get-addons?data[]=0&store_id=<?php echo e($campaign['store_id']); ?>','add_on');
            <?php endif; ?>
        });




        $('#choice_attributes').on('change', function () {
            $('#customer_choice_options').html(null);
            $.each($("#choice_attributes option:selected"), function () {
                add_more_customer_choice_option($(this).val(), $(this).text());
            });
        });

        function add_more_customer_choice_option(i, name) {
            let n = name.split(' ').join('');
            $('#customer_choice_options').append('<div class="row gy-1"><div class="col-sm-3"><input type="hidden" name="choice_no[]" value="' + i + '"><input type="text" class="form-control" name="choice[]" value="' + n + '" placeholder="Choice Title" readonly></div><div class="col-sm-9"><input type="text" class="form-control combination_update" name="choice_options_' + i + '[]" placeholder="<?php echo e(translate('messages.enter_choice_values')); ?>" data-role="tagsinput"></div></div>');
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
                url: '<?php echo e(route('admin.item.variant-combination')); ?>',
                data: $('#campaign_form').serialize(),
                success: function (data) {
                    console.log(data.view);
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

        var module_id = <?php echo e($campaign->module_id); ?>;
        var module_type = "<?php echo e($campaign->module->module_type); ?>";
        if (module_type == 'food') {
                $('#food_variation_section').show();
                $('#attribute_section').hide();
            } else {
                $('#food_variation_section').hide();
                $('#attribute_section').show();
            }
        var parent_category_id = <?php echo e($category?$category->id:0); ?>;
        <?php
            $module_data = config('module.'.$campaign->module->module_type);
            unset($module_data['description']);
        ?>
        var module_data = <?php echo e(str_replace('"','',json_encode($module_data))); ?>;
        input_field_visibility_update();
        function modulChange(id)
        {
            $.get({
                url: "<?php echo e(url('/')); ?>/admin/module/"+id,
                dataType: 'json',
                success: function (data) {
                    module_data = data.data;
                    stock = module_data.stock;
                    input_field_visibility_update();
                    combination_update();
                },
            });
            module_id = id;
        }

        function input_field_visibility_update()
        {
            if(module_data.stock)
            {
                $('#stock_input').show();
            }
            else
            {
                $('#stock_input').hide();
            }
            if(module_data.add_on)
            {
                $('#addon_input').show();
            }
            else{
                $('#addon_input').hide();
            }

            if(module_data.item_available_time)
            {
                $('#time_input').hide();
            }
            else{
                $('#time_input').show();
            }

            if(module_data.veg_non_veg)
            {
                $('#veg_input').show();
            }
            else{
                $('#veg_input').hide();
            }

            if(module_data.unit)
            {
                $('#unit_input').show();
            }
            else{
                $('#unit_input').hide();
            }
        }


        $('#category_id').on('change', function () {
            parent_category_id = $(this).val();
            console.log(parent_category_id);
        });
        $('#store_id').select2({
            ajax: {
                url: '<?php echo e(url('/')); ?>/admin/store/get-stores',
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        module_id: module_id
                    };
                },
                processResults: function (data) {
                    return {
                    results: data
                    };
                },
                __port: function (params, success, failure) {
                    var $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });

        $('#category_id').select2({
            ajax: {
                url: '<?php echo e(url('/')); ?>/admin/item/get-categories?parent_id=0',
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        module_id: module_id
                    };
                },
                processResults: function (data) {
                    return {
                    results: data
                    };
                },
                __port: function (params, success, failure) {
                    var $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });

        $('#sub-categories').select2({
            ajax: {
                url: '<?php echo e(url('/')); ?>/admin/item/get-categories',
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page,
                        module_id: module_id,
                        parent_id: parent_category_id,
                        sub_category: true
                    };
                },
                processResults: function (data) {
                    return {
                    results: data
                    };
                },
                __port: function (params, success, failure) {
                    var $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });

        $("#date_from").on("change", function () {
            $('#date_to').attr('min',$(this).val());
        });

        $("#date_to").on("change", function () {
            $('#date_from').attr('max',$(this).val());
        });

        $(document).ready(function(){
            $('#date_to').attr('min',('<?php echo e($campaign->start_date->format('Y-m-d')); ?>'));
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });

        $('#campaign_form').on('submit', function(e) {
            e.preventDefault();

            let $form = $(this);
            if (!$form.valid()) {
                return false;
            }

            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '<?php echo e(route('admin.campaign.update-item', [$campaign->id])); ?>',
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
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        toastr.success('<?php echo e(translate('messages.Campaign updated successfully')); ?>', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        setTimeout(function() {
                            location.href =
                                '<?php echo e(route('admin.campaign.list', 'item')); ?>';
                        }, 2000);
                    }
                }
            });
        });

        $(".lang_link").click(function(e){
            e.preventDefault();
            $(".lang_link").removeClass('active');
            $(".lang_form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.substring(0, form_id.length - 5);
            console.log(lang);
            $("#"+lang+"-form").removeClass('d-none');
            if(lang == 'en')
            {
                $("#from_part_2").removeClass('d-none');
            }
            else
            {
                $("#from_part_2").addClass('d-none');
            }
        })

            $('#reset_btn').click(function(){
                location.reload(true);
            })


    function show_min_max(data){
        console.log(data);
        $('#min_max1_'+data).removeAttr("readonly");
        $('#min_max2_'+data).removeAttr("readonly");
        $('#min_max1_'+data).attr("required","true");
        $('#min_max2_'+data).attr("required","true");
    }
    function hide_min_max (data){
        console.log(data);
        $('#min_max1_'+data).val(null).trigger('change');
        $('#min_max2_'+data).val(null).trigger('change');
        $('#min_max1_'+data).attr("readonly","true");
        $('#min_max2_'+data).attr("readonly","true");
        $('#min_max1_'+data).attr("required","false");
        $('#min_max2_'+data).attr("required","false");
    }

    $(document).on('change', '.show_min_max', function () {
        let data = $(this).data('count');
        show_min_max(data);
    });

    $(document).on('change', '.hide_min_max', function () {
        let data = $(this).data('count');
        hide_min_max(data);
    });



    var count= <?php echo e(isset($campaign->food_variations)?count(json_decode($campaign->food_variations,true)):0); ?>;

    $(document).ready(function(){
        console.log(count);

        $("#add_new_option_button").click(function(e) {
            count++;
            var add_option_view = `
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
                                            name="options[` + count + `][type]" id="type` + count + `" checked">
                                            <span class="form-check-label">
                                                <?php echo e(translate('Multiple')); ?>

                </span>
            </label>

            <label class="form-check form--check mr-2 mr-md-4">
                <input class="form-check-input hide_min_max" data-count="`+count+`" type="radio" value="single"
                                            name="options[` + count + `][type]" id="type` + count + `">
                                            <span class="form-check-label">
                                                <?php echo e(translate('Single')); ?>

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
                                    <button type="button" class="btn btn-outline-primary add_new_row_button" data-count="`+
                count +`" ><?php echo e(translate('Add_New_Option')); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;

            $("#add_new_option").append(add_option_view);
        });

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

        function deleteRow(e) {
            element = $(e);
            element.parents('.add_new_view_row_class').remove();
        }

        $(document).on('click', '.delete_input_button', function () {
            let e = $(this);
            removeOption(e);
        });


        $(document).on('click', '.deleteRow', function () {
            let e = $(this);
            deleteRow(e);
        });

        $(document).on('keyup', '.new_option_name', function () {
            let data = $(this).data('count');
            let value = $(this).val();
            new_option_name(value, data);
        });

        let countRow = 0;
    function add_new_row_button(data)
    {
        count = data;
        countRow = 1 + $('#option_price_view_' + data).children('.add_new_view_row_class').length;
        var add_new_row_view = `
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

</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/campaign/item/edit.blade.php ENDPATH**/ ?>