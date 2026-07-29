<?php $__env->startSection('title',$store->name."'s ".translate('messages.reviews')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <!-- Custom styles for this page -->
    <link href="<?php echo e(asset('public/assets/admin/css/croppie.css')); ?>" rel="stylesheet">

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <?php echo $__env->make('admin-views.vendor.view.partials._header',['store'=>$store], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!-- Page Heading -->
    <div class="tab-content">
        <div class="tab-pane fade show active" id="product">
            <div class="resturant-review-top" id="store_details">
                <div class="resturant-review-left mb-3">
                    <?php ($user_rating = null); ?>
                    <?php ($total_rating = 0); ?>
                    <?php ($total_reviews = 0); ?>
                    <?php ($store_reviews = \App\CentralLogics\StoreLogic::calculate_store_rating($store['rating'])); ?>
                    <?php ($user_rating = $store_reviews['rating']); ?>
                    <?php ($reviews = $store_reviews['total']); ?>
                    <h1 class="title"><?php echo e(number_format($user_rating, 1)); ?><span class="out-of">/5</span></h1>
                    <?php if($user_rating == 5): ?>
                    <div class="rating">
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                    </div>
                    <?php elseif($user_rating < 5 && $user_rating >= 4.5): ?>
                    <div class="rating">
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star-half"></i></span>
                    </div>
                    <?php elseif($user_rating < 4.5 && $user_rating >= 4): ?>
                    <div class="rating">
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                    </div>
                    <?php elseif($user_rating < 4 && $user_rating >= 3.5): ?>
                    <div class="rating">
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star-half"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                    </div>
                    <?php elseif($user_rating < 3.5 && $user_rating >= 3): ?>
                    <div class="rating">
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                    </div>
                    <?php elseif($user_rating < 3 && $user_rating >= 2.5): ?>
                    <div class="rating">
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star-half"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                    </div>
                    <?php elseif($user_rating < 2.5 && $user_rating > 2): ?>
                    <div class="rating">
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                    </div>
                    <?php elseif($user_rating < 2 && $user_rating >= 1.5): ?>
                    <div class="rating">
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star-half"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                    </div>
                    <?php elseif($user_rating < 1.5 && $user_rating > 1): ?>
                    <div class="rating">
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                    </div>
                    <?php elseif($user_rating < 1 && $user_rating > 0): ?>
                    <div class="rating">
                        <span><i class="tio-star-half"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                    </div>
                    <?php elseif($user_rating == 1): ?>
                    <div class="rating">
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                    </div>
                    <?php elseif($user_rating == 0): ?>
                    <div class="rating">
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                    </div>
                    <?php endif; ?>
                    <div class="info">
                        
                        <span><?php echo e($reviews); ?> <?php echo e(translate('messages.reviews')); ?></span>
                    </div>
                </div>
                <div class="resturant-review-right">
                    <ul class="list-unstyled list-unstyled-py-2 mb-0">
                    <?php ($ratings = $store->rating); ?>
                    <?php ($five = $ratings[0]); ?>
                    <?php ($four = $ratings[1]); ?>
                    <?php ($three = $ratings[2]); ?>
                    <?php ($two = $ratings[3]); ?>
                    <?php ($one = $ratings[4]); ?>
                    <?php ($total_rating = $one+$two+$three+$four+$five); ?>
                    <?php ($total_rating = $total_rating==0?1:$total_rating); ?>
                    <!-- Review Ratings -->
                        <li class="d-flex align-items-center font-size-sm">
                            <span
                                class="progress-name mr-3"><?php echo e(translate('messages.excellent')); ?></span>
                            <div class="progress flex-grow-1">
                                <div class="progress-bar" role="progressbar"
                                        style="width: <?php echo e(($five/$total_rating)*100); ?>%;"
                                        aria-valuenow="<?php echo e(($five/$total_rating)*100); ?>"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="ml-3"><?php echo e($five); ?></span>
                        </li>
                        <!-- End Review Ratings -->

                        <!-- Review Ratings -->
                        <li class="d-flex align-items-center font-size-sm">
                            <span class="progress-name mr-3"><?php echo e(translate('messages.good')); ?></span>
                            <div class="progress flex-grow-1">
                                <div class="progress-bar" role="progressbar"
                                        style="width: <?php echo e(($four/$total_rating)*100); ?>%;"
                                        aria-valuenow="<?php echo e(($four/$total_rating)*100); ?>"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="ml-3"><?php echo e($four); ?></span>
                        </li>
                        <!-- End Review Ratings -->

                        <!-- Review Ratings -->
                        <li class="d-flex align-items-center font-size-sm">
                            <span class="progress-name mr-3"><?php echo e(translate('messages.average')); ?></span>
                            <div class="progress flex-grow-1">
                                <div class="progress-bar" role="progressbar"
                                        style="width: <?php echo e(($three/$total_rating)*100); ?>%;"
                                        aria-valuenow="<?php echo e(($three/$total_rating)*100); ?>"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="ml-3"><?php echo e($three); ?></span>
                        </li>
                        <!-- End Review Ratings -->

                        <!-- Review Ratings -->
                        <li class="d-flex align-items-center font-size-sm">
                            <span class="progress-name mr-3"><?php echo e(translate('messages.below_average')); ?></span>
                            <div class="progress flex-grow-1">
                                <div class="progress-bar" role="progressbar"
                                        style="width: <?php echo e(($two/$total_rating)*100); ?>%;"
                                        aria-valuenow="<?php echo e(($two/$total_rating)*100); ?>"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="ml-3"><?php echo e($two); ?></span>
                        </li>
                        <!-- End Review Ratings -->

                        <!-- Review Ratings -->
                        <li class="d-flex align-items-center font-size-sm">

                            <span class="progress-name mr-3"><?php echo e(translate('messages.poor')); ?></span>
                            <div class="progress flex-grow-1">
                                <div class="progress-bar" role="progressbar"
                                        style="width: <?php echo e(($one/$total_rating)*100); ?>%;"
                                        aria-valuenow="<?php echo e(($one/$total_rating)*100); ?>"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="ml-3"><?php echo e($one); ?></span>
                        </li>
                        <!-- End Review Ratings -->
                    </ul>
                </div>
            </div>
            <div class="card">

                    <!-- Header -->
            <div class="card-header py-2">
                <div class="search--button-wrapper">
                    <h5 class="card-title"><?php echo e(translate('messages.Review_list')); ?></h5>
                    
                    <!-- Unfold -->
                    <div class="hs-unfold mr-2">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle min-height-40" href="javascript:;"
                            data-hs-unfold-options='{
                                    "target": "#usersExportDropdown",
                                    "type": "css-animation"
                                }'>
                            <i class="tio-download-to mr-1"></i> <?php echo e(translate('messages.export')); ?>

                        </a>

                        <div id="usersExportDropdown"
                            class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">

                            <span class="dropdown-header"><?php echo e(translate('messages.download_options')); ?></span>
                            <a id="export-excel" class="dropdown-item" href="<?php echo e(route('admin.store.store_wise_reviwe_export', ['type'=>'excel', 'id' => $store->id,request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                    alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item" href="<?php echo e(route('admin.store.store_wise_reviwe_export', ['type'=>'csv','id' => $store->id,request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/placeholder-csv-format.svg"
                                    alt="Image Description">
                                .<?php echo e(translate('messages.csv')); ?>

                            </a>

                        </div>
                    </div>
                    <!-- End Unfold -->
                </div>
            </div>
           

                            <?php ($reviews = $store->reviews()->with('item',function($query){
                                $query->withoutGlobalScope(\App\Scopes\StoreScope::class);
                            })->with('customer')
                            ->latest()->paginate(25)); ?>
                <div class="card-body p-0 verticle-align-middle-table">
                    <div class="table-responsive datatable-custom">
                        <table id="columnSearchDatatable"
                               class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                               data-hs-datatables-options='{
                            "order": [],
                            "orderCellsTop": true,
                            "paging":false
                        }'>
                            <thead class="thead-light">
                            <tr>
                                <th class="text-center max-90px"><?php echo e(translate('messages.sl')); ?></th>
                                <th><?php echo e(translate('messages.Review_Id')); ?></th>
                                <th><?php echo e(translate('messages.item')); ?></th>
                                <th class="pl-4"><?php echo e(translate('messages.reviewer_info')); ?></th>
                                <th><?php echo e(translate('messages.review')); ?></th>
                                <th><?php echo e(translate('messages.date')); ?></th>
                                <th class="w-30p text-center"><?php echo e(translate('messages.store_reply')); ?></th>
                                <th class="text-center w-100px"><?php echo e(translate('messages.status')); ?></th>
                            </tr>
                            </thead>

                            <tbody id="set-rows">

                            <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="text-center"><?php echo e($key+$reviews->firstItem()); ?></td>
                                    <td><?php echo e($review->review_id); ?></td>
                                    <td>
                                        <?php if($review->item): ?>
                                            <a class="media align-items-center" href="<?php echo e(route('admin.item.view',[$review->item['id']])); ?>">
                                                <img class="avatar avatar-lg mr-3 onerror-image"

                                                     src="<?php echo e($review?->item['image_full_url'] ?? asset('public/assets/admin/img/160x160/img1.jpg')); ?>"


                                                     data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>" alt="<?php echo e($review->item->name); ?> image">
                                                <div class="media-body">
                                                    <h5 class="text-hover-primary mb-0"><?php echo e(Str::limit($review->item['name'],10)); ?></h5>
                                                    <!-- Static Order ID -->
                                                    <a class="text-body" href="<?php echo e(route('admin.order.details',['id'=>$review->order_id])); ?>">Order ID: <?php echo e($review->order_id); ?></a>
                                                    <!-- Static Order ID -->
                                                </div>
                                            </a>
                                        <?php else: ?>
                                            <?php echo e(translate('messages.Food_deleted!')); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($review->customer): ?>
                                            <a
                                                href="<?php echo e(route('admin.customer.view',[$review['user_id']])); ?>">
                                                <div>
                                    <span class="d-block h5 text-hover-primary mb-0"><?php echo e(Str::limit($review->customer['f_name']." ".$review->customer['l_name'], 15)); ?> <i
                                            class="tio-verified text-primary" data-toggle="tooltip" data-placement="top"
                                            title="Verified Customer"></i></span>
                                                    <span class="d-block font-size-sm text-body"><?php echo e(Str::limit($review->customer->phone)); ?></span>
                                                </div>
                                            </a>
                                        <?php else: ?>
                                            <?php echo e(translate('messages.customer_not_found')); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="text-wrap w-18rem">
                                    <span class="d-block rating">
                                        <?php echo e($review->rating); ?> <i class="tio-star"></i>
                                    </span>
                                            <small class="d-block" data-toggle="tooltip" data-placement="left"
                                                   data-original-title="<?php echo e($review['comment']); ?>" >
                                                <?php echo e(Str::limit($review['comment'], 80)); ?>

                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo e(\App\CentralLogics\Helpers::time_date_format($review->created_at)); ?>

                                    </td>
                                    <td>
                                        <p class="text-wrap text-center" data-toggle="tooltip" data-placement="top"
                                           data-original-title="<?php echo e($review?->reply); ?>"><?php echo $review->reply?Str::limit($review->reply, 50, '...'): translate('messages.Not_replied_Yet'); ?></p>
                                    </td>

                                    <td>
                                        <label class="toggle-switch toggle-switch-sm" for="reviewCheckbox<?php echo e($review->id); ?>">
                                            <input type="checkbox" data-id="status-<?php echo e($review['id']); ?>" data-message="<?php echo e($review->status?translate('messages.you_want_to_hide_this_review_for_customer'):translate('messages.you_want_to_show_this_review_for_customer')); ?>" class="toggle-switch-input status_form_alert" id="reviewCheckbox<?php echo e($review->id); ?>" <?php echo e($review->status?'checked':''); ?>>
                                            <span class="toggle-switch-label">
                                        <span class="toggle-switch-indicator"></span>
                                    </span>
                                        </label>
                                        <form action="<?php echo e(route('admin.item.reviews.status',[$review['id'],$review->status?0:1])); ?>" method="get" id="status-<?php echo e($review['id']); ?>">
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php if(count($reviews) !== 0): ?>
                            <hr>
                        <?php endif; ?>
                        <div class="page-area px-4 pb-3">
                            <div class="d-flex align-items-center justify-content-end">
                                <div>
                                    <?php echo $reviews->links(); ?>

                                </div>
                            </div>
                        </div>
                        <?php if(count($reviews) === 0): ?>
                        <div class="empty--data">
                            <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                            <h5>
                                <?php echo e(translate('no_data_found')); ?>

                            </h5>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <!-- Page level plugins -->
    <script>
        "use strict";
        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();
            // INITIALIZATION OF DATATABLES
            // =======================================================
            let datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

            $('#column1_search').on('keyup', function () {
                datatable
                    .columns(1)
                    .search(this.value)
                    .draw();
            });

            $('#column2_search').on('keyup', function () {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });

            $('#column3_search').on('change', function () {
                datatable
                    .columns(3)
                    .search(this.value)
                    .draw();
            });

            $('#column4_search').on('keyup', function () {
                datatable
                    .columns(4)
                    .search(this.value)
                    .draw();
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                let select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });

        $('#search-form').on('submit', function () {
            let formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '<?php echo e(route('admin.item.search')); ?>',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('.page-area').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });

        $(".status_form_alert").on("click", function (e) {
            const id = $(this).data('id');
            const message = $(this).data('message');
            e.preventDefault();
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
                    $('#' + id).submit()
                }
            })
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/vendor/view/review.blade.php ENDPATH**/ ?>