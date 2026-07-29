                <div class="col-md-12" id="attribute_section">
                    <div class="card shadow--card-2 border-0">
                        <div class="card-header">
                            <h5 class="card-title">
                                <span class="card-header-icon"><i class="tio-canvas-text"></i></span>
                                <span><?php echo e(translate('attribute')); ?></span>
                            </h5>
                        <?php if(isset($openai_config) && data_get($openai_config, 'status') == 1): ?>
                        <button type="button" class="btn bg-white text-primary opacity-1 generate_btn_wrapper p-0 mb-2 other_variation_setup_auto_fill"
                            id="other_variation_setup_auto_fill" data-route="<?php echo e(route('admin.product.generate-other-variation-data')); ?>"
                            data-error="<?php echo e(translate('Please provide an item name and description so the AI can generate a suitable variations.')); ?>"
                            data-lang="en">
                            <div class="btn-svg-wrapper">
                                <img width="18" height="18" class=""
                                    src="<?php echo e(asset('public/assets/admin/img/svg/blink-right-small.svg')); ?>" alt="">
                            </div>
                            <span class="ai-text-animation d-none" role="status">
                                <?php echo e(translate('Just_a_second')); ?>

                            </span>
                            <span class="btn-text"><?php echo e(translate('Generate')); ?></span>
                        </button>
                        <?php endif; ?>
                        </div>
                        <div class="card-body pb-0">
                            <div class="row g-2">
                                <div class="col-12">
                                    <div class="form-group mb-0 error-wrapper">
                                        <label class="input-label"
                                            for="exampleFormControlSelect1"><?php echo e(translate('messages.attribute')); ?><span
                                                class="input-label-secondary"></span></label>
                                        <select name="attribute_id[]" id="choice_attributes"
                                        data-placeholder="<?php echo e(translate('messages.Select_attribute')); ?>"
                                            class="form-control js-select2-custom" multiple="multiple">
                                            <?php $__currentLoopData = \App\Models\Attribute::orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($attribute['id']); ?>"><?php echo e($attribute['name']); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <div class="customer_choice_options d-flex __gap-24px error-wrapper" id="customer_choice_options">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="variant_combination" id="variant_combination">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php /**PATH /var/www/zaqoota/resources/views/admin-views/product/partials/_other_variations.blade.php ENDPATH**/ ?>