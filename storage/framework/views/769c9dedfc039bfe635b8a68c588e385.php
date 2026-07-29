<?php $__env->startSection('title', translate('Item Preview')); ?>

<?php $__env->startPush('css_or_js'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <?php ($store_data = \App\CentralLogics\Helpers::get_store_data()); ?>

    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex flex-wrap justify-content-between">
                <h1 class="page-header-title text-break">
                    <span class="page-header-icon">
                        <img src="<?php echo e(asset('public/assets/admin/img/items.png')); ?>" class="w--22" alt="">
                    </span>
                    <span><?php echo e($product['name']); ?></span>
                </h1>
                <div>

                    <?php if($store_data->module->module_type != 'food'): ?>
                        <a data-toggle="modal" data-id="<?php echo e($product->id); ?>" data-target="#update-quantity"
                            class="btn btn--primary update-quantity">
                            <?php echo e(translate('messages.Update_Stock')); ?>

                        </a>
                    <?php endif; ?>
                    <a href="<?php echo e(route('vendor.item.edit', [$product['id']])); ?>" class="btn btn--primary">
                        <i class="tio-edit"></i> <?php echo e(translate('messages.edit')); ?>

                    </a>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Card -->
        <div class="review--information-wrapper mb-3">
            <div class="card h-100">
                <!-- Body -->
                <div class="card-body">
                    <div class="row align-items-md-center">
                        <div class="col-lg-5 col-md-6 mb-3 mb-md-0">
                            <div class="d-flex flex-wrap align-items-center food--media">
                                <img class="avatar avatar-xxl avatar-4by3 mr-4 onerror-image"
                                    src="<?php echo e($product['image_full_url']); ?>"
                                    data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                                    alt="Image Description">
                                <div class="d-block">
                                    <div class="rating--review">
                                        <h1 class="title"><?php echo e(number_format($product->avg_rating, 1)); ?><span
                                                class="out-of">/5</span></h1>
                                        <div class="rating">
                                            <?php $__currentLoopData = range(1, 5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span>
                                                    <?php if($product->avg_rating >= $i): ?>
                                                        <i class="tio-star"></i>
                                                    <?php elseif($product->avg_rating >= $i - 0.5): ?>
                                                        <i class="tio-star-half"></i>
                                                    <?php else: ?>
                                                        <i class="tio-star-outlined"></i>
                                                    <?php endif; ?>
                                                </span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <div class="info">
                                            <span><?php echo e(translate('messages.of')); ?> <?php echo e($product->reviews->count()); ?>

                                                <?php echo e(translate('messages.reviews')); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-7 col-md-6 mx-auto">
                            <ul class="list-unstyled list-unstyled-py-2 mb-0 rating--review-right py-3">
                                <?php ($total = $product->rating ? array_sum(json_decode($product->rating, true)) : 0); ?>
                                <!-- Review Ratings -->
                                <li class="d-flex align-items-center font-size-sm">
                                    <?php ($five = $product->rating ? json_decode($product->rating, true)[5] : 0); ?>
                                    <span class="progress-name mr-3"><?php echo e(translate('excellent')); ?></span>
                                    <div class="progress flex-grow-1">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: <?php echo e($total == 0 ? 0 : ($five / $total) * 100); ?>%;"
                                            aria-valuenow="<?php echo e($total == 0 ? 0 : ($five / $total) * 100); ?>" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                    <span class="ml-3"><?php echo e($five); ?></span>
                                </li>
                                <!-- End Review Ratings -->

                                <!-- Review Ratings -->
                                <li class="d-flex align-items-center font-size-sm">
                                    <?php ($four = $product->rating ? json_decode($product->rating, true)[4] : 0); ?>
                                    <span class="progress-name mr-3"><?php echo e(translate('good')); ?></span>
                                    <div class="progress flex-grow-1">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: <?php echo e($total == 0 ? 0 : ($four / $total) * 100); ?>%;"
                                            aria-valuenow="<?php echo e($total == 0 ? 0 : ($four / $total) * 100); ?>" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                    <span class="ml-3"><?php echo e($four); ?></span>
                                </li>
                                <!-- End Review Ratings -->

                                <!-- Review Ratings -->
                                <li class="d-flex align-items-center font-size-sm">
                                    <?php ($three = $product->rating ? json_decode($product->rating, true)[3] : 0); ?>
                                    <span class="progress-name mr-3"><?php echo e(translate('average')); ?></span>
                                    <div class="progress flex-grow-1">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: <?php echo e($total == 0 ? 0 : ($three / $total) * 100); ?>%;"
                                            aria-valuenow="<?php echo e($total == 0 ? 0 : ($three / $total) * 100); ?>" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                    <span class="ml-3"><?php echo e($three); ?></span>
                                </li>
                                <!-- End Review Ratings -->

                                <!-- Review Ratings -->
                                <li class="d-flex align-items-center font-size-sm">
                                    <?php ($two = $product->rating ? json_decode($product->rating, true)[2] : 0); ?>
                                    <span class="progress-name mr-3"><?php echo e(translate('below_average')); ?></span>
                                    <div class="progress flex-grow-1">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: <?php echo e($total == 0 ? 0 : ($two / $total) * 100); ?>%;"
                                            aria-valuenow="<?php echo e($total == 0 ? 0 : ($two / $total) * 100); ?>" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                    <span class="ml-3"><?php echo e($two); ?></span>
                                </li>
                                <!-- End Review Ratings -->

                                <!-- Review Ratings -->
                                <li class="d-flex align-items-center font-size-sm">
                                    <?php ($one = $product->rating ? json_decode($product->rating, true)[1] : 0); ?>
                                    <span class="progress-name mr-3"><?php echo e(translate('poor')); ?></span>
                                    <div class="progress flex-grow-1">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: <?php echo e($total == 0 ? 0 : ($one / $total) * 100); ?>%;"
                                            aria-valuenow="<?php echo e($total == 0 ? 0 : ($one / $total) * 100); ?>" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                    <span class="ml-3"><?php echo e($one); ?></span>
                                </li>
                                <!-- End Review Ratings -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Card -->
        <?php if(\App\CentralLogics\Helpers::get_store_data()->review_permission): ?>
            <!-- Description Card Start -->
            <div class="card mb-3">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-borderless table-thead-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th class="px-4 border-0">
                                        <h4 class="m-0 text-capitalize"><?php echo e(translate('short_description')); ?></h4>
                                    </th>
                                    <?php if(in_array($product->module->module_type, ['food', 'grocery'])): ?>
                                        <th class="px-4 border-0">
                                            <h4 class="m-0 text-capitalize"><?php echo e(translate('Nutrition')); ?></h4>
                                        </th>
                                        <th class="px-4 border-0">
                                            <h4 class="m-0 text-capitalize"><?php echo e(translate('Allergy')); ?></h4>
                                        </th>
                                    <?php endif; ?>


                                    <?php if($store_data->module->module_type != 'food'): ?>
                                        <th class="px-4 border-0">
                                            <h4 class="m-0 text-capitalize"><?php echo e(translate('Stock')); ?></h4>
                                        </th>
                                    <?php endif; ?>
                                    <?php if(in_array($product->module->module_type, ['pharmacy'])): ?>
                                        <th class="px-4 border-0">
                                            <h4 class="m-0 text-capitalize"><?php echo e(translate('Generic_Name')); ?></h4>
                                        </th>
                                    <?php endif; ?>
                                    <th class="px-4 border-0">
                                        <h4 class="m-0 text-capitalize"><?php echo e(translate('price')); ?></h4>
                                    </th>
                                    <th class="px-4 border-0">
                                        <h4 class="m-0 text-capitalize"><?php echo e(translate('variations')); ?></h4>
                                    </th>
                                    <?php if(\App\CentralLogics\Helpers::get_store_data()->module->module_type == 'food'): ?>
                                        <th class="px-4 border-0">
                                            <h4 class="m-0 text-capitalize"><?php echo e(translate('addons')); ?></h4>
                                        </th>
                                    <?php endif; ?>
                                    <th class="px-4 border-0">
                                        <h4 class="m-0 text-capitalize"><?php echo e(translate('tags')); ?></h4>
                                    </th>
                                    <?php if($productWiseTax): ?>
                                        <th class="px-4 border-0">
                                            <h4 class="m-0 text-capitalize"><?php echo e(translate('Tax/Vat')); ?></h4>
                                        </th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="px-4 max-w--220px">
                                        <div class="">
                                            <?php echo $product['description']; ?>

                                        </div>
                                    </td>
                                    <?php if(in_array($product->module->module_type, ['food', 'grocery'])): ?>
                                        <td class="px-4">
                                            <?php if($product->nutritions): ?>
                                                <?php $__currentLoopData = $product->nutritions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nutrition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php echo e($nutrition->nutrition); ?><?php echo e(!$loop->last ? ',' : '.'); ?>

                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-4">
                                            <?php if($product->allergies): ?>
                                                <?php $__currentLoopData = $product->allergies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allergy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php echo e($allergy->allergy); ?><?php echo e(!$loop->last ? ',' : '.'); ?>

                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>

                                    <?php if($product->module->module_type != 'food'): ?>
                                        <td class="px-4"><?php echo e($product->stock); ?></td>
                                    <?php endif; ?>

                                    <?php if(in_array($product->module->module_type, ['pharmacy'])): ?>
                                        <td class="px-4">
                                            <?php if($product->generic->pluck('generic_name')->first()): ?>
                                                <?php echo e($product->generic->pluck('generic_name')->first()); ?>

                                            <?php endif; ?>
                                        </td>

                                    <?php endif; ?>

                                    <td class="px-4">
                                        <span class="d-block mb-1">
                                            <span><?php echo e(translate('messages.price')); ?> : </span>
                                            <strong><?php echo e(\App\CentralLogics\Helpers::format_currency($product['price'])); ?></strong>
                                        </span>
                                        <span class="d-block mb-1">
                                            <span><?php echo e(translate('messages.discount')); ?> :</span>
                                                         <strong>  <?php echo e($product['discount_type'] == 'percent' ? $product['discount'] . ' %' : \App\CentralLogics\Helpers::format_currency($product['discount'])); ?>   </strong>
                                            
                                        </span>
                                        <?php if(config('module.' . $product->module->module_type)['item_available_time']): ?>
                                            <span class="d-block mb-1">
                                                <?php echo e(translate('messages.available_time_starts')); ?> :
                                                <strong><?php echo e(date(config('timeformat'), strtotime($product['available_time_starts']))); ?></strong>
                                            </span>
                                            <span class="d-block mb-1">
                                                <?php echo e(translate('messages.available_time_ends')); ?> :
                                                <strong><?php echo e(date(config('timeformat'), strtotime($product['available_time_ends']))); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4">
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
                                                            (<?php echo e(translate('messages.Min_select')); ?>:
                                                            <?php echo e($variation['min']); ?> -
                                                            <?php echo e(translate('messages.Max_select')); ?>:
                                                            <?php echo e($variation['max']); ?>)
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
                                                        <?php echo e($variation['type']); ?> :
                                                        <?php echo e(\App\CentralLogics\Helpers::format_currency($variation['price'])); ?>

                                                    </span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                    </td>
        <?php endif; ?>
        <?php if(\App\CentralLogics\Helpers::get_store_data()->module->module_type == 'food'): ?>
            <td class="px-4">
                <?php if(config('module.' . $product->module->module_type)['add_on']): ?>
                    <?php $__currentLoopData = \App\Models\AddOn::whereIn('id', json_decode($product['add_ons'], true))->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="d-block mb-1 text-capitalize">
                            <?php echo e($addon['name']); ?> : <?php echo e(\App\CentralLogics\Helpers::format_currency($addon['price'])); ?>

                        </span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </td>
        <?php endif; ?>
        <?php if($product->tags): ?>
            <td>
                <?php $__currentLoopData = $product->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e($c->tag . ','); ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </td>
        <?php endif; ?>
        <?php if($productWiseTax): ?>
            <td>

                <span class="d-block font-size-sm text-body">
                    <?php $__empty_1 = true; $__currentLoopData = $product?->taxVats?->pluck('tax.name', 'tax.tax_rate')->toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <span> <?php echo e($tax); ?> : <span class="font-bold">
                                (<?php echo e($key); ?>%)
                            </span> </span>
                        <br>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <span> <?php echo e(translate('messages.no_tax')); ?> </span>
                    <?php endif; ?>
                </span>
            </td>
        <?php endif; ?>
        </tr>
        </tbody>
        </table>
    </div>
    </div>
    </div>
    <!-- Description Card End -->

    <!-- Card -->
    <div class="card">
        <?php ($store_review_reply = App\Models\BusinessSetting::where('key', 'store_review_reply')->first()->value ?? 0); ?>
        <!-- Table -->
        <div class="table-responsive datatable-custom">
            <table id="columnSearchDatatable"
                class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                data-hs-datatables-options='{
                            "order": [],
                            "orderCellsTop": true,
                            "paging": false
                        }'>
                <thead class="thead-light">
                    <tr>
                        <th class="border-0"><?php echo e(translate('messages.#')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.Review_Id')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.item')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.reviewer')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.review')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.date')); ?></th>
                        <?php if($store_review_reply == '1'): ?>
                            <th class="text-center"><?php echo e(translate('messages.action')); ?></th>
                        <?php endif; ?>
                    </tr>
                </thead>

                <tbody>
                    <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key + $reviews->firstItem()); ?></td>
                            <td><?php echo e($review->review_id); ?></td>
                            <td>
                                <?php if($review->item): ?>
                                    <div class="position-relative media align-items-center">
                                        <a class=" text-hover-primary absolute--link"
                                            href="<?php echo e(route('vendor.item.view', [$review->item['id']])); ?>">
                                            <img class="avatar avatar-lg mr-3  onerror-image"
                                                data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
                                                src="<?php echo e($review->item['image_full_url']); ?>"
                                                alt="<?php echo e($review->item->name); ?> image">
                                        </a>
                                        <div class="media-body">
                                            <h5 class="text-hover-primary important--link mb-0">
                                                <?php echo e(Str::limit($review->item['name'], 10)); ?></h5>
                                            <!-- Static -->
                                            <a href="<?php echo e(route('vendor.order.details', ['id' => $review->order_id])); ?>"
                                                class="fz--12 text-body important--link"><?php echo e(translate('Order ID')); ?>

                                                #<?php echo e($review->order_id); ?></a>
                                            <!-- Static -->
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <?php echo e(translate('messages.Food_deleted!')); ?>

                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($review->customer): ?>
                                    <div>
                                        <h5 class="d-block text-hover-primary mb-1">
                                            <?php echo e(Str::limit($review->customer['f_name'] . ' ' . $review->customer['l_name'])); ?>

                                            <i class="tio-verified text-primary" data-toggle="tooltip"
                                                data-placement="top" title="Verified Customer"></i></h5>
                                        <span
                                            class="d-block font-size-sm text-body"><?php echo e(Str::limit($review->customer->phone)); ?></span>
                                    </div>
                                <?php else: ?>
                                    <?php echo e(translate('messages.customer_not_found')); ?>

                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="text-wrap w-18rem">
                                    <label class="rating">
                                        <i class="tio-star"></i>
                                        <span><?php echo e($review->rating); ?></span>
                                    </label>
                                    <p data-toggle="tooltip" data-placement="bottom"
                                        data-original-title="<?php echo e($review?->comment); ?>">
                                        <?php echo e(Str::limit($review['comment'], 80)); ?>

                                    </p>
                                </div>
                            </td>
                            <td>
                                <span class="d-block">
                                    <?php echo e(\App\CentralLogics\Helpers::date_format($review->created_at)); ?>

                                </span>
                                <span class="d-block">
                                    <?php echo e(\App\CentralLogics\Helpers::time_format($review->created_at)); ?></span>
                            </td>
                            <?php if($store_review_reply == '1'): ?>
                                <td>
                                    <div class="btn--container justify-content-center">
                                        <a class="btn btn-sm btn--primary <?php echo e($review->reply ? 'btn-outline-primary' : ''); ?>"
                                            data-toggle="modal" data-target="#reply-<?php echo e($review->id); ?>"
                                            title="View Details">
                                            <?php echo e($review->reply ? translate('view_reply') : translate('give_reply')); ?>

                                        </a>
                                    </div>
                                </td>
                            <?php endif; ?>
                            <div class="modal fade" id="reply-<?php echo e($review->id); ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header pb-4">
                                            <button type="button"
                                                class="payment-modal-close btn-close border-0 outline-0 bg-transparent"
                                                data-dismiss="modal">
                                                <i class="tio-clear"></i>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="position-relative media align-items-center">
                                                <a class="absolute--link"
                                                    href="<?php echo e(route('vendor.item.view', [$review->item['id']])); ?>">
                                                </a>
                                                <img class="avatar avatar-lg mr-3  onerror-image"
                                                    data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
                                                    src="<?php echo e($review->item['image_full_url']); ?>"
                                                    alt="<?php echo e($review->item->name); ?> image">
                                                <div>
                                                    <h5 class="text-hover-primary mb-0"><?php echo e($review->item['name']); ?></h5>
                                                    <?php if($review->item['avg_rating'] == 5): ?>
                                                        <div class="rating">
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                        </div>
                                                    <?php elseif($review->item['avg_rating'] < 5 && $review->item['avg_rating'] >= 4.5): ?>
                                                        <div class="rating">
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star-half"></i></span>
                                                        </div>
                                                    <?php elseif($review->item['avg_rating'] < 4.5 && $review->item['avg_rating'] >= 4): ?>
                                                        <div class="rating">
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                        </div>
                                                    <?php elseif($review->item['avg_rating'] < 4 && $review->item['avg_rating'] >= 3.5): ?>
                                                        <div class="rating">
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star-half"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                        </div>
                                                    <?php elseif($review->item['avg_rating'] < 3.5 && $review->item['avg_rating'] >= 3): ?>
                                                        <div class="rating">
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                        </div>
                                                    <?php elseif($review->item['avg_rating'] < 3 && $review->item['avg_rating'] >= 2.5): ?>
                                                        <div class="rating">
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star-half"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                        </div>
                                                    <?php elseif($review->item['avg_rating'] < 2.5 && $review->item['avg_rating'] > 2): ?>
                                                        <div class="rating">
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                        </div>
                                                    <?php elseif($review->item['avg_rating'] < 2 && $review->item['avg_rating'] >= 1.5): ?>
                                                        <div class="rating">
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star-half"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                        </div>
                                                    <?php elseif($review->item['avg_rating'] < 1.5 && $review->item['avg_rating'] > 1): ?>
                                                        <div class="rating">
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                        </div>
                                                    <?php elseif($review->item['avg_rating'] < 1 && $review->item['avg_rating'] > 0): ?>
                                                        <div class="rating">
                                                            <span><i class="tio-star-half"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                        </div>
                                                    <?php elseif($review->item['avg_rating'] == 1): ?>
                                                        <div class="rating">
                                                            <span><i class="tio-star"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                        </div>
                                                    <?php elseif($review->item['avg_rating'] == 0): ?>
                                                        <div class="rating">
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                            <span><i class="tio-star-outlined"></i></span>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <div class="mt-2">
                                                <?php if($review->customer): ?>
                                                    <div>
                                                        <h5 class="d-block text-hover-primary mb-1">
                                                            <?php echo e(Str::limit($review->customer['f_name'] . ' ' . $review->customer['l_name'])); ?>

                                                            <i class="tio-verified text-primary" data-toggle="tooltip"
                                                                data-placement="top" title="Verified Customer"></i></h5>
                                                        <span
                                                            class="d-block font-size-sm text-body"><?php echo e(Str::limit($review->comment)); ?></span>
                                                    </div>
                                                <?php else: ?>
                                                    <?php echo e(translate('messages.customer_not_found')); ?>

                                                <?php endif; ?>
                                            </div>
                                            <div class="mt-2">
                                                <form action="<?php echo e(route('vendor.review-reply', [$review['id']])); ?>"
                                                    method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <textarea id="reply" name="reply" required class="form-control" cols="30" rows="3"
                                                        placeholder="<?php echo e(translate('Write_your_reply_here')); ?>"><?php echo e($review->reply ?? ''); ?></textarea>
                                                    <div class="mt-3 btn--container justify-content-end">
                                                        <button
                                                            class="btn btn-primary"><?php echo e($review->reply ? translate('update_reply') : translate('send_reply')); ?></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php if(count($reviews) !== 0): ?>
                <hr>
            <?php endif; ?>
            <table>
                <tfoot>
                    <?php echo $reviews->links(); ?>

                </tfoot>
            </table>
            <?php if(count($reviews) === 0): ?>
                <div class="empty--data">
                    <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                    <h5>
                        <?php echo e(translate('no_data_found')); ?>

                    </h5>
                </div>
            <?php endif; ?>
        </div>
        <!-- End Table -->
    </div>
    <!-- End Card -->
    <?php endif; ?>
    </div>
    
    <div class="modal fade update-quantity-modal" id="update-quantity" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-0">

                    <form action="<?php echo e(route('vendor.item.stock-update')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <div class="mt-2 rest-part w-100"></div>
                        <div class="btn--container justify-content-end">
                            <button type="reset" data-dismiss="modal" aria-label="Close"
                                class="btn btn--reset"><?php echo e(translate('cancel')); ?></button>
                            <button type="submit" id="submit_new_customer"
                                class="btn btn--primary"><?php echo e(translate('update_stock')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script>
        "use strict";

        $('.update-quantity').on('click', function() {
            let val = $(this).data('id');
            $.get({
                url: '<?php echo e(route('vendor.item.get_stock')); ?>',
                data: {
                    id: val
                },
                dataType: 'json',
                success: function(data) {
                    $('.rest-part').empty().html(data.view);
                    update_qty();
                },
            });
        })

        function update_qty() {
            let total_qty = 0;
            let qty_elements = $('input[name^="stock_"]');
            for (let i = 0; i < qty_elements.length; i++) {
                total_qty += parseInt(qty_elements.eq(i).val());
            }
            if (qty_elements.length > 0) {

                $('input[name="current_stock"]').attr("readonly", 'readonly');
                $('input[name="current_stock"]').val(total_qty);
            } else {
                $('input[name="current_stock"]').attr("readonly", false);
            }
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/vendor-views/product/view.blade.php ENDPATH**/ ?>