
<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="col-12">
    <div class="card mb-3">
        <!-- Body -->
        <div class="card-body ml-2">
            <div class="table-responsive">
                <div class="min-width-720">
                    <div class="d-flex">
                        <div>
                            <div class="d-flex flex-wrap align-items-center food--media position-relative mr-4">
                                <img class="avatar avatar-xxl avatar-4by3 onerror-image"
                                src="<?php echo e($item['image_full_url']); ?>"
                                    data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                                    alt="Image Description">
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="table-responsive">
                                <div class="d-flex justify-content-between">
                                    <h2 class="ml-3"><?php echo e($item?->getRawOriginal('name')); ?> </h2>
                                    <div>
                                        <a target="_blank" href="<?php echo e(route('vendor.item.edit',['id' => $item->id , 'product_gellary' => true ])); ?>" class="btn btn--sm btn-outline-primary">
                                            <?php echo e(translate('messages.use_this_product_info')); ?>

                                        </a>


                                    </div>
                                </div>
                                <table class="table table-borderless table-thead-bordered">
                                    <thead>
                                        <tr>
                                            <th class="px-4 border-0">
                                                <h4 class="m-0 text-capitalize"><?php echo e(translate('General_Information')); ?></h4>
                                            </th>
                                            <th class="px-4 border-0">
                                                <h4 class="m-0 text-capitalize"><?php echo e(translate('Available_Variations')); ?></h4>
                                            </th>
                                            <th class="px-4 border-0">
                                                <h4 class="m-0 text-capitalize"><?php echo e(translate('tags')); ?></h4>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="px-4 max-w--220px">
                                                <span class="d-block mb-1">
                                                    <span><?php echo e(translate('messages.Category')); ?> : </span>
                                                    <strong><?php echo e(Str::limit(($item?->category?->parent ? $item?->category?->parent?->name : $item?->category?->name )  ?? translate('messages.uncategorize')
                                                        , 20, '...')); ?></strong>
                                                </span>
                                                <span class="d-block mb-1">
                                                    <span><?php echo e(translate('messages.Sub_Category')); ?> : </span>
                                                    <strong><?php echo e(Str::limit(($item?->category?->name )  ?? translate('messages.uncategorize')
                                                        , 20, '...')); ?></strong>
                                                </span>
                                                <?php if($item->module->module_type == 'grocery'): ?>
                                                <span class="d-block mb-1">
                                                    <span><?php echo e(translate('messages.Is_Organic')); ?> : </span>
                                                    <strong> <?php echo e($item->organic == 1 ?  translate('messages.yes') : translate('messages.no')); ?></strong>
                                                </span>
                                                <?php endif; ?>
                                                <?php if($item->module->module_type == 'food'): ?>
                                                <span class="d-block mb-1">
                                                    <span><?php echo e(translate('messages.Item_type')); ?> : </span>
                                                    <strong> <?php echo e($item->veg == 1 ?  translate('messages.veg') : translate('messages.non_veg')); ?></strong>
                                                </span>
                                                <?php else: ?>
                                                    <?php if($item?->unit): ?>
                                                    <span class="d-block mb-1">
                                                        <span><?php echo e(translate('messages.Unit')); ?> : </span>
                                                        <strong> <?php echo e($item?->unit?->unit); ?></strong>
                                                    </span>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-4">
                                                <?php if($item->module->module_type == 'food'): ?>
                                                    <?php if($item->food_variations && is_array(json_decode($item['food_variations'], true))): ?>
                                                        <?php $__currentLoopData = json_decode($item->food_variations, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if(isset($variation['price'])): ?>
                                                                <span class="d-block mb-1 text-capitalize">
                                                                    <strong>
                                                                        <?php echo e(translate('please_update_the_food_variations.')); ?>

                                                                    </strong>
                                                                </span>
                                                            <?php break; ?>

                                                        <?php else: ?>
                                                            <span class="d-block text-capitalize">
                                                                <strong>
                                                                    <?php echo e($variation['name']); ?> -
                                                                </strong>
                                                            </span>

                                                            <?php if(isset($variation['values'])): ?>
                                                                <?php $__currentLoopData = $variation['values']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <span class="d-block text-capitalize">
                                                                        &nbsp; &nbsp; <?php echo e($value['label']); ?>

                                                                    </span>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <?php if($item->variations && is_array(json_decode($item['variations'], true))): ?>
                                                    <?php $__currentLoopData = json_decode($item['variations'], true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <span class="d-block mb-1 text-capitalize">
                                                            <?php echo e($variation['type']); ?>

                                                        </span>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                        </td>
                                        <?php endif; ?>

                                        <td>
                                            <?php $__currentLoopData = $item->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($c->tag.','); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                    <div>
                        <h6> <?php echo e(translate('description')); ?>:</h6>
                        <P> <?php echo e($item?->getRawOriginal('description')); ?></P>
                    </div>
                </div>
            </div>


        </div>
        <!-- End Body -->
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/common.js"></script><?php /**PATH /var/www/zaqoota/resources/views/vendor-views/product/partials/_gallery.blade.php ENDPATH**/ ?>