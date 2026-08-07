<?php $__env->startSection('title',translate('messages.Review List')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Heading -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/star.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.customers_reviews')); ?>

                </span>
            </h1>
        </div>
        <!-- Page Heading -->
        <!-- Card -->
        <div class="card">
            <?php ($store_review_reply = App\Models\BusinessSetting::where('key' , 'store_review_reply')->first()->value ?? 0); ?>
            <div class="card-header flex-wrap py-2 border-0">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <h4 class="mb-0"><?php echo e(translate('reviews')); ?></h4>
                    <span class="badge badge-soft-dark rounded-circle"><?php echo e($reviews->total()); ?></span>
                </div>
                <div class="search--button-wrapper justify-content-end">

                    <form class="search-form">
                        <div class="input-group input--group">
                            <input name="search" type="search" value="<?php echo e(request()?->search); ?>" class="form-control h--40px" placeholder="<?php echo e(translate('Ex : Search by item name')); ?>" aria-label="Search here">
                            <button type="submit" class="btn btn--secondary h--40px"><i class="tio-search"></i></button>
                        </div>
                    </form>
                    <!-- Unfold -->
                    <div class="hs-unfold">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle btn export-btn font--sm"
                            href="javascript:;"
                            data-hs-unfold-options="{
                                &quot;target&quot;: &quot;#usersExportDropdown&quot;,
                                &quot;type&quot;: &quot;css-animation&quot;
                            }"
                            data-hs-unfold-target="#usersExportDropdown" data-hs-unfold-invoker="">
                            <i class="tio-download-to mr-1"></i> <?php echo e(translate('export')); ?>

                        </a>

                        <div id="usersExportDropdown"
                            class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right hs-unfold-content-initialized hs-unfold-css-animation animated hs-unfold-reverse-y hs-unfold-hidden">

                            <span class="dropdown-header"><?php echo e(translate('download_options')); ?></span>
                            <a id="export-excel" class="dropdown-item"
                                href="<?php echo e(route('vendor.reviewsExport', ['export_type' => 'excel', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin/svg/components/excel.svg')); ?>"
                                    alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item"
                                href="<?php echo e(route('vendor.reviewsExport', ['export_type' => 'excel', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin/svg/components/placeholder-csv-format.svg')); ?>"
                                    alt="Image Description">
                                .<?php echo e(translate('messages.csv')); ?>

                            </a>

                        </div>
                    </div>
                    <!-- End Unfold -->
                </div>
                <!-- End Row -->
            </div>
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
                        <th class="border-0"><?php echo e(translate('messages.Reply_date')); ?></th>
                        <?php if($store_review_reply == '1'): ?>
                            <th class="text-center"><?php echo e(translate('messages.action')); ?></th>
                        <?php endif; ?>
                    </tr>
                    </thead>

                    <tbody>
                    <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+$reviews->firstItem()); ?></td>
                            <td><?php echo e($review->review_id); ?></td>
                            <td>
                                <?php if($review->item): ?>
                                    <div class="position-relative media align-items-center">
                                        <a class=" text-hover-primary absolute--link" href="<?php echo e(route('vendor.item.view',[$review->item['id']])); ?>">
                                            <img class="avatar avatar-lg mr-3  onerror-image"  data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
                                                 src="<?php echo e($review->item['image_full_url']); ?>" alt="<?php echo e($review->item->name); ?> image">
                                        </a>
                                        <div class="media-body">
                                            <h5 class="text-hover-primary important--link mb-0"><?php echo e(Str::limit($review->item['name'],10)); ?></h5>
                                            <!-- Static -->
                                            <a href="<?php echo e(route('vendor.order.details',['id'=>$review->order_id])); ?>"  class="fz--12 text-body important--link"><?php echo e(translate('Order ID')); ?> #<?php echo e($review->order_id); ?></a>
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
                                        <h5 class="d-block text-hover-primary mb-1"><?php echo e(Str::limit($review->customer['f_name']." ".$review->customer['l_name'])); ?> <i
                                                class="tio-verified text-primary" data-toggle="tooltip" data-placement="top"
                                                title="Verified Customer"></i></h5>
                                        <span class="d-block font-size-sm text-body"><?php echo e(Str::limit($review->customer->phone)); ?></span>
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
                                       data-original-title="<?php echo e($review?->comment); ?>" >
                                        <?php echo e(Str::limit($review['comment'], 80)); ?>

                                    </p>
                                </div>
                            </td>
                            <td>
                                <span class="d-block">
                                    <?php echo e(\App\CentralLogics\Helpers::date_format($review->created_at)); ?>

                                </span>
                                <span class="d-block"> <?php echo e(\App\CentralLogics\Helpers::time_format($review->created_at)); ?></span>
                            </td>
                            <td>
                                <?php if($review->replied_at): ?>
                                    <span class="d-block">
                                        <?php echo e(\App\CentralLogics\Helpers::date_format($review->replied_at)); ?>

                                    </span>
                                    <span class="d-block"> <?php echo e(\App\CentralLogics\Helpers::time_format($review->replied_at)); ?></span>

                                <?php else: ?>
                                    -------
                                <?php endif; ?>
                            </td>
                            <?php if($store_review_reply == '1'): ?>
                                <td>
                                    <div class="btn--container justify-content-center">
                                        <a  class="btn btn-sm btn--primary <?php echo e($review->reply ? 'btn-outline-primary' : ''); ?>" data-toggle="modal" data-target="#reply-<?php echo e($review->id); ?>" title="View Details">
                                            <?php echo e($review->reply ? translate('view_reply') : translate('give_reply')); ?>

                                        </a>
                                    </div>
                                </td>
                            <?php endif; ?>
                            <div class="modal fade" id="reply-<?php echo e($review->id); ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header pb-4">
                                            <button type="button" class="payment-modal-close btn-close border-0 outline-0 bg-transparent" data-dismiss="modal">
                                                <i class="tio-clear"></i>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="position-relative media align-items-center">
                                                <a class="absolute--link" href="<?php echo e(route('vendor.item.view',[$review->item['id']])); ?>">
                                                </a>
                                                <img class="avatar avatar-lg mr-3  onerror-image"  data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
                                                     src="<?php echo e($review->item['image_full_url']); ?>" alt="<?php echo e($review->item->name); ?> image">
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
                                                        <h5 class="d-block text-hover-primary mb-1"><?php echo e(Str::limit($review->customer['f_name']." ".$review->customer['l_name'])); ?> <i
                                                                class="tio-verified text-primary" data-toggle="tooltip" data-placement="top"
                                                                title="Verified Customer"></i></h5>
                                                        <span class="d-block font-size-sm text-body"><?php echo e($review->comment); ?></span>
                                                    </div>
                                                <?php else: ?>
                                                    <?php echo e(translate('messages.customer_not_found')); ?>

                                                <?php endif; ?>
                                            </div>
                                            <div class="mt-3">
                                                <form action="<?php echo e(route('vendor.review-reply',[$review['id']])); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <textarea id="reply" name="reply" required class="form-control" cols="30" rows="3" placeholder="<?php echo e(translate('Write_your_reply_here')); ?>"><?php echo e($review->reply ?? ''); ?></textarea>
                                                    <div class="mt-3 btn--container justify-content-end">
                                                        <button class="btn btn-primary"><?php echo e($review->reply ? translate('update_reply') : translate('send_reply')); ?></button>
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
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script>
        "use strict";
        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            let datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/review/index.blade.php ENDPATH**/ ?>