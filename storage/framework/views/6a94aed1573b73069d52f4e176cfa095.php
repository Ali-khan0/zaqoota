<?php $__env->startSection('title', translate('Item Preview')); ?>

<?php $__env->startPush('css_or_js'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex flex-wrap justify-content-between">
                <h1 class="page-header-title text-break">
                    <span class="page-header-icon">
                        <img src="<?php echo e(asset('public/assets/admin/img/p_gal.png')); ?>" class="w--22" alt="">
                    </span>
                    <span><?php echo e(translate('Product_Details')); ?></span>
                </h1>

            </div>
        </div>
        <!-- End Page Header -->

        <div class="card mb-3">
            <!-- Body -->
            <div class="card-body">
                <div class="d-flex flex-wrap gap-4">
                    <div>
                        <div class="d-flex flex-wrap align-items-center food--media position-relative mr-4 mt-4">
                            <img class="avatar avatar-xxl avatar-4by3 onerror-image aspect-ratio-1 h-unset"
                            src="<?php echo e($product['image_full_url'] ?? asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                                data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                                alt="Image Description">
                                <?php if($product['is_rejected'] == 1 ): ?>

                                <div class="reject-info"> <?php echo e(translate('Your_Item_Has_Been_Rejected')); ?></div>
                                <?php endif; ?>

                                <div class="review-info"> <?php echo e(translate('This item is under review')); ?></div>
                        </div>
                    </div>
                    <div class="w-70 flex-grow">
                        <div class="d-flex justify-content-end">
                            <div class="d-flex flex-wrap gap-2 align-items-start">
                                <a href="<?php echo e(route('admin.item.edit', [$product['id'],'temp_product' => true])); ?>" class="btn btn-sm btn-- btn-outline-primary">
                                    <i class="tio-redo font-weight-bold "></i>  <?php echo e(translate('messages.Edit_&_Approve')); ?>

                                </a>
                                <?php if($product->is_rejected == 0): ?>
                                <a data-toggle="tooltip" data-placement="top"
                                data-original-title="<?php echo e(translate('messages.Reject')); ?>" data-url="<?php echo e(route('admin.item.deny', ['id'=> $product['id']])); ?>" data-message="<?php echo e(translate('you_want_to_deny_this_product')); ?>"
                                    href="javascript:" class="btn btn-sm btn--danger cancelled_status">
                                    <?php echo e(translate('messages.Reject')); ?>

                                </a>
                                <?php endif; ?>
                                <a data-toggle="tooltip" data-placement="top"
                                data-original-title="<?php echo e(translate('messages.approve')); ?>"
                                    data-url="<?php echo e(route('admin.item.approved',[ 'id'=> $product['id']])); ?>" data-message="<?php echo e(translate('messages.you_want_to_approve_this_product')); ?>"
                                    href="javascript:" class="btn btn-sm btn--primary request_alert">
                                    <?php echo e(translate('messages.approve')); ?> <i class="tio-checkmark-circle-outlined font-weight-bold pr-1"></i>
                                </a>
                            </div>
                        </div>
                        <?php ($language = \App\Models\BusinessSetting::where('key', 'language')->first()?->value ?? null); ?>
                        <?php ($defaultLang = str_replace('_', '-', app()->getLocale())); ?>
                            <?php if($language): ?>
                            <ul class="nav nav-tabs mb-3 pt-3">
                                <li class="nav-item">
                                    <a class="nav-link lang_link active" href="#"
                                        id="default-link"><?php echo e(translate('messages.default')); ?></a>
                                </li>
                                <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="nav-item">
                                    <a class="nav-link lang_link" href="#"
                                    id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <?php endif; ?>

                        <div class="lang_form" id="default-form">
                            <h2 class="mt-3"><?php echo e($product?->getRawOriginal('name')); ?> </h2>
                            <h6> <?php echo e(translate('description')); ?>:</h6>
                            <P> <?php echo e($product?->getRawOriginal('description')); ?></P>
                        </div>

                        <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    if (count($product['translations'])) {
                                        $translate = [];
                                        foreach ($product['translations'] as $t) {
                                            if ($t->locale == $lang && $t->key == 'name') {
                                                $translate[$lang]['name'] = $t->value;
                                            }
                                            if ($t->locale == $lang && $t->key == 'description') {
                                                $translate[$lang]['description'] = $t->value;
                                            }
                                        }
                                    }
                                    ?>
                                    <div class="d-none lang_form" id="<?php echo e($lang); ?>-form">
                                        <h2><?php echo e($translate[$lang]['name'] ?? ''); ?> </h2>
                                        <h6> <?php echo e(translate('description')); ?>:</h6>
                                        <P> <?php echo $translate[$lang]['description'] ?? ''; ?></P>
                                    </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>


            </div>
            <!-- End Body -->
        </div>

    <!-- Description Card Start -->
    <div class="card mb-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-borderless table-thead-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th class="px-4 border-0">
                                <h4 class="m-0 text-capitalize"><?php echo e(translate('General_Information')); ?></h4>
                            </th>
                            <th class="px-4 border-0">
                                <h4 class="m-0 text-capitalize"><?php echo e(translate('price_Information')); ?></h4>
                            </th>
                                <?php if(in_array($product->module->module_type ,['food','grocery'])): ?>
                                <th class="px-4 border-0">
                                    <h4 class="m-0 text-capitalize"><?php echo e(translate('Nutrition')); ?></h4>
                                </th>
                                <th class="px-4 border-0">
                                    <h4 class="m-0 text-capitalize"><?php echo e(translate('Allergy')); ?></h4>
                                </th>

                                <?php endif; ?>
                                <?php if(in_array($product->module->module_type ,['pharmacy'])): ?>
                                <th class="px-4 border-0">
                                    <h4 class="m-0 text-capitalize"><?php echo e(translate('Generic_Name')); ?></h4>
                                </th>
                                <?php endif; ?>
                            <th class="px-4 border-0">
                                <h4 class="m-0 text-capitalize"><?php echo e(translate('Available_Variations')); ?></h4>
                            </th>
                            <?php if($product->module->module_type == 'food'): ?>
                                <th class="px-4 border-0">
                                    <h4 class="m-0 text-capitalize"><?php echo e(translate('addons')); ?></h4>
                                </th>
                            <?php endif; ?>
                            <th class="px-4 border-0">
                                <h4 class="m-0 text-capitalize"><?php echo e(translate('tags')); ?></h4>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-4 max-w--220px product-gallery-info">
                                <span class="d-block mb-1">
                                    <span><?php echo e(translate('messages.Store')); ?></span>
                                    <span>:</span>
                                    <strong><?php echo e($product?->store?->name); ?></strong>
                                </span>
                                <span class="d-block mb-1">
                                    <span><?php echo e(translate('messages.Category')); ?></span>
                                    <span>:</span>
                                    <strong><?php echo e(Str::limit(($product?->category?->parent ? $product?->category?->parent?->name : $product?->category?->name )  ?? translate('messages.uncategorize')
                                        , 20, '...')); ?></strong>
                                </span>
                                <span class="d-block mb-1">
                                    <span><?php echo e(translate('messages.Sub_Category')); ?></span>
                                    <span>:</span>
                                    <strong><?php echo e(Str::limit(( $product?->category?->parent?->name ? $product?->category?->name : '---' )
                                        , 20, '...')); ?></strong>
                                </span>
                                <?php if($product->module->module_type == 'grocery'): ?>
                                <span class="d-block mb-1">
                                    <span><?php echo e(translate('messages.Is_Organic')); ?></span>
                                    <span>:</span>
                                    <strong> <?php echo e($product->organic == 1 ?  translate('messages.yes') : translate('messages.no')); ?></strong>
                                </span>
                                <?php endif; ?>
                                <?php if($product->module->module_type == 'food'): ?>
                                <span class="d-block mb-1">
                                    <span><?php echo e(translate('messages.Item_type')); ?></span>
                                    <span>:</span>
                                    <strong> <?php echo e($product->veg == 1 ?  translate('messages.veg') : translate('messages.non_veg')); ?></strong>
                                </span>
                                <?php else: ?>
                                <span class="d-block mb-1">
                                    <span><?php echo e(translate('messages.Total_stock')); ?></span>
                                    <span>:</span>
                                    <strong> <?php echo e($product->stock); ?></strong>
                                </span>

                                    <?php if($product?->unit): ?>
                                    <span class="d-block mb-1">
                                        <span><?php echo e(translate('messages.Unit')); ?></span>
                                        <span>:</span>
                                        <strong> <?php echo e($product?->unit?->unit); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if(config('module.' . $product->module->module_type)['item_available_time']): ?>
                                <span class="d-block mb-1">
                                    <span><?php echo e(translate('messages.available_time_starts')); ?></span>
                                    <span>:</span>
                                    <strong><?php echo e(date(config('timeformat'), strtotime($product['available_time_starts']))); ?></strong>
                                </span>
                                <span class="d-block mb-1">
                                    <span><?php echo e(translate('messages.available_time_ends')); ?></span>
                                    <span>:</span>
                                    <strong><?php echo e(date(config('timeformat'), strtotime($product['available_time_ends']))); ?></strong>
                                </span>
                            <?php endif; ?>
                            </td>
                            <td class="px-4 product-gallery-info">
                                <span class="d-block mb-1">
                                    <span><?php echo e(translate('messages.Unit_Price')); ?></span>
                                    <span>:</span>
                                    <strong><?php echo e(\App\CentralLogics\Helpers::format_currency($product['price'])); ?></strong>
                                </span>
                                <span class="d-block mb-1">
                                    <span><?php echo e(translate('messages.discounted_amount')); ?></span>
                                    <span>:</span>
                                    <strong><?php echo e(\App\CentralLogics\Helpers::format_currency(\App\CentralLogics\Helpers::discount_calculate($product, $product['price']))); ?></strong>
                                </span>
                                <span class="d-block mb-1">
                                    <span><?php echo e(translate('messages.discount')); ?></span>
                                    <span>:</span>
                                    <strong> <?php echo e($product->discount_type == 'percent' ? $product->discount .' %' :  \App\CentralLogics\Helpers::format_currency($product['discount'])); ?> </strong>
                                </span>



                            </td>


                            <?php ($product_nutritions = $product?->nutrition_ids ? \App\Models\Nutrition::whereIn('id', json_decode($product?->nutrition_ids))->pluck('nutrition') : []); ?>
                            <?php ($product_allergies = $product?->allergy_ids ?\App\Models\Allergy::whereIn('id', json_decode($product?->allergy_ids))->pluck('allergy') : []); ?>

                            <?php if(in_array($product->module->module_type ,['food','grocery'])): ?>
                            <td class="px-4 product-gallery-info">

                                    <?php $__currentLoopData = $product_nutritions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nutrition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php echo e($nutrition); ?><?php echo e(!$loop->last ? ',' : '.'); ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </td>
                            <td class="px-4 product-gallery-info">
                                    <?php $__currentLoopData = $product_allergies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allergy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php echo e($allergy); ?><?php echo e(!$loop->last ? ',' : '.'); ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </td>
                            <?php endif; ?>
                            <?php if(in_array($product->module->module_type ,['pharmacy'])): ?>
                                <td class="px-4 product-gallery-info">
                                    <?php echo e(\App\Models\GenericName::where('id', json_decode($product?->generic_ids))->first()?->generic_name); ?>

                                </td>
                            <?php endif; ?>

                            <td class="px-4 product-gallery-info">
                                <?php if($product->module->module_type == 'food'): ?>
                                    <?php if($product->food_variations && is_array(json_decode($product['food_variations'], true))): ?>
                                        <?php $__currentLoopData = json_decode($product->food_variations, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                                <?php if($variation['type'] == 'multi'): ?>
                                                    <?php echo e(translate('messages.multiple_select')); ?>

                                                <?php elseif($variation['type'] == 'single'): ?>
                                                    <?php echo e(translate('messages.single_select')); ?>

                                                <?php endif; ?>
                                                <?php if($variation['required'] == 'on'): ?>
                                                    - (<?php echo e(translate('messages.required')); ?>)
                                                <?php endif; ?>
                                            </span>

                                            <?php if($variation['min'] != 0 && $variation['max'] != 0): ?>
                                                (<?php echo e(translate('messages.Min_select')); ?>: <?php echo e($variation['min']); ?> -
                                                <?php echo e(translate('messages.Max_select')); ?>: <?php echo e($variation['max']); ?>)
                                            <?php endif; ?>

                                            <?php if(isset($variation['values'])): ?>
                                                <?php $__currentLoopData = $variation['values']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="d-block text-capitalize">
                                                        &nbsp; &nbsp; <?php echo e($value['label']); ?> :
                                                        <strong><?php echo e(\App\CentralLogics\Helpers::format_currency($value['optionPrice'])); ?></strong>
                                                    </span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if($product->variations && is_array(json_decode($product['variations'], true))): ?>
                                    <?php $__currentLoopData = json_decode($product['variations'], true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="d-block mb-1 text-capitalize">
                                            <span><?php echo e($variation['type']); ?></span>
                                            <span>:</span>
                                            <strong><?php echo e(\App\CentralLogics\Helpers::format_currency($variation['price'])); ?></strong>
                                        </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                        </td>
                        <?php endif; ?>
                        <?php if($product->module->module_type == 'food'): ?>
                            <td class="px-4 product-gallery-info">
                                
                                    <?php $__currentLoopData = \App\Models\AddOn::whereIn('id', json_decode($product['add_ons'], true))->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="d-block mb-1 text-capitalize">
                                            <span><?php echo e($addon['name']); ?></span>
                                            <span>:</span>
                                            <strong><?php echo e(\App\CentralLogics\Helpers::format_currency($addon['price'])); ?></strong>
                                        </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                            </td>
                        <?php endif; ?>

                        <?php ( $tags =\App\Models\Tag::whereIn('id',json_decode($product?->tag_ids) )->get('tag')); ?>
                            <td>
                                <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($c->tag.','); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Description Card End -->

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
<script>
    "use strict";
    $(".request_alert").on("click", function () {
        const url = $(this).data('url');
        const message = $(this).data('message');
            Swal.fire({
                title: '<?php echo e(translate('messages.are_you_sure')); ?>',
                text: message,
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#FC6A57',
                cancelButtonText: '<?php echo e(translate('messages.no')); ?>',
                confirmButtonText: '<?php echo e(translate('messages.yes')); ?>',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    location.href = url;
                }
            })
        })

    $(".cancelled_status").on("click", function () {
            const route = $(this).data('url');
            const message = $(this).data('message');
            const processing = false;
            Swal.fire({
                    //text: message,
                    title: '<?php echo e(translate('messages.Are you sure ?')); ?>',
                    type: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: 'default',
                    confirmButtonColor: '#FC6A57',
                    cancelButtonText: '<?php echo e(translate('messages.Cancel')); ?>',
                    confirmButtonText: '<?php echo e(translate('messages.submit')); ?>',
                    inputPlaceholder: "<?php echo e(translate('Enter_a_reason')); ?>",
                    input: 'text',
                    html: message + '<br/>'+'<label><?php echo e(translate('Enter_a_reason')); ?></label>',
                    inputValue: processing,
                    preConfirm: (note) => {
                        location.href = route + '&note=' + note;
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                })
        })
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/product/requested_product_view.blade.php ENDPATH**/ ?>