<?php $__env->startSection('title',$store->name."'s ".translate('messages.reviews')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <!-- Custom styles for this page -->
    <link href="<?php echo e(asset('public/assets/admin/css/croppie.css')); ?>" rel="stylesheet">

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <?php echo $__env->make('rental::admin.provider.details.partials._header',['store'=>$store], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!-- Page Heading -->
    <div class="tab-content">
        <div class="tab-pane fade show active" id="product">
            <div class="resturant-review-top" id="store_details">
                <div class="resturant-review-left mb-3">
                    <?php ($user_rating = null); ?>
                    <?php ($total_rating = 0); ?>
                    <?php ($total_reviews = 0); ?>
                    <h1 class="title"><?php echo e(number_format($avgRating, 1)); ?><span class="out-of">/5</span></h1>
                    <?php if($avgRating == 5): ?>
                    <div class="rating">
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                    </div>
                    <?php elseif($avgRating < 5 && $avgRating >= 4.5): ?>
                    <div class="rating">
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star-half"></i></span>
                    </div>
                    <?php elseif($avgRating < 4.5 && $avgRating >= 4): ?>
                    <div class="rating">
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                    </div>
                    <?php elseif($avgRating < 4 && $avgRating >= 3.5): ?>
                    <div class="rating">
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star-half"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                    </div>
                    <?php elseif($avgRating < 3.5 && $avgRating >= 3): ?>
                    <div class="rating">
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                    </div>
                    <?php elseif($avgRating < 3 && $avgRating >= 2.5): ?>
                    <div class="rating">
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star-half"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                    </div>
                    <?php elseif($avgRating < 2.5 && $avgRating > 2): ?>
                    <div class="rating">
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                    </div>
                    <?php elseif($avgRating < 2 && $avgRating >= 1.5): ?>
                    <div class="rating">
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star-half"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                    </div>
                    <?php elseif($avgRating < 1.5 && $avgRating > 1): ?>
                    <div class="rating">
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                    </div>
                    <?php elseif($avgRating < 1 && $avgRating > 0): ?>
                    <div class="rating">
                        <span><i class="tio-star-half"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                    </div>
                    <?php elseif($avgRating == 1): ?>
                    <div class="rating">
                        <span><i class="tio-star"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                    </div>
                    <?php elseif($avgRating == 0): ?>
                    <div class="rating">
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                        <span><i class="tio-star-outlined"></i></span>
                    </div>
                    <?php endif; ?>
                    <div class="info">
                        <span><?php echo e($totalReviews); ?> <?php echo e(translate('messages.reviews')); ?></span>
                    </div>
                </div>
                <div class="resturant-review-right">
                    <ul class="list-unstyled list-unstyled-py-2 mb-0">
                        <!-- Review Ratings -->
                        <li class="d-flex align-items-center font-size-sm">
                            <span class="progress-name mr-3"><?php echo e(translate('messages.excellent')); ?></span>
                            <div class="progress flex-grow-1">
                                <div class="progress-bar" role="progressbar"
                                     style="width: <?php echo e($totalReviews > 0 ? ($excellentCount / $totalReviews) * 100 : 0); ?>%;"
                                     aria-valuenow="<?php echo e($totalReviews > 0 ? ($excellentCount / $totalReviews) * 100 : 0); ?>"
                                     aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="ml-3"><?php echo e($excellentCount); ?></span>
                        </li>
                        <!-- End Review Ratings -->

                        <!-- Review Ratings -->
                        <li class="d-flex align-items-center font-size-sm">
                            <span class="progress-name mr-3"><?php echo e(translate('messages.good')); ?></span>
                            <div class="progress flex-grow-1">
                                <div class="progress-bar" role="progressbar"
                                     style="width: <?php echo e($totalReviews > 0 ? ($goodCount / $totalReviews) * 100 : 0); ?>%;"
                                     aria-valuenow="<?php echo e($totalReviews > 0 ? ($goodCount / $totalReviews) * 100 : 0); ?>"
                                     aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="ml-3"><?php echo e($goodCount); ?></span>
                        </li>
                        <!-- End Review Ratings -->

                        <!-- Review Ratings -->
                        <li class="d-flex align-items-center font-size-sm">
                            <span class="progress-name mr-3"><?php echo e(translate('messages.average')); ?></span>
                            <div class="progress flex-grow-1">
                                <div class="progress-bar" role="progressbar"
                                     style="width: <?php echo e($totalReviews > 0 ? ($averageCount / $totalReviews) * 100 : 0); ?>%;"
                                     aria-valuenow="<?php echo e($totalReviews > 0 ? ($averageCount / $totalReviews) * 100 : 0); ?>"
                                     aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="ml-3"><?php echo e($averageCount); ?></span>
                        </li>
                        <!-- End Review Ratings -->

                        <!-- Review Ratings -->
                        <li class="d-flex align-items-center font-size-sm">
                            <span class="progress-name mr-3"><?php echo e(translate('messages.below_average')); ?></span>
                            <div class="progress flex-grow-1">
                                <div class="progress-bar" role="progressbar"
                                     style="width: <?php echo e($totalReviews > 0 ? ($belowAverageCount / $totalReviews) * 100 : 0); ?>%;"
                                     aria-valuenow="<?php echo e($totalReviews > 0 ? ($belowAverageCount / $totalReviews) * 100 : 0); ?>"
                                     aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="ml-3"><?php echo e($belowAverageCount); ?></span>
                        </li>
                        <!-- End Review Ratings -->

                        <!-- Review Ratings -->
                        <li class="d-flex align-items-center font-size-sm">
                            <span class="progress-name mr-3"><?php echo e(translate('messages.poor')); ?></span>
                            <div class="progress flex-grow-1">
                                <div class="progress-bar" role="progressbar"
                                     style="width: <?php echo e($totalReviews > 0 ? ($poorCount / $totalReviews) * 100 : 0); ?>%;"
                                     aria-valuenow="<?php echo e($totalReviews > 0 ? ($poorCount / $totalReviews) * 100 : 0); ?>"
                                     aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="ml-3"><?php echo e($poorCount); ?></span>
                        </li>
                        <!-- End Review Ratings -->
                    </ul>
                </div>
            </div>
            <div class="card">

                    <!-- Header -->
            <div class="card-header py-2">
                <div class="search--button-wrapper">
                    <h5 class="card-title"><?php echo e(translate('messages.Review_list')); ?>


                        <span class="badge badge-soft-dark ml-2"
                        id="itemCount"><?php echo e($tripReviews->total()); ?></span>
                    </h5>
                    
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
                            <a id="export-excel" class="dropdown-item" href="<?php echo e(route('admin.rental.provider.export-review', ['provider_id' => request()->id, 'type' => 'excel', request()->getQueryString()])); ?>">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="<?php echo e(asset('public/assets/admin')); ?>/svg/components/excel.svg"
                                    alt="Image Description">
                                <?php echo e(translate('messages.excel')); ?>

                            </a>
                            <a id="export-csv" class="dropdown-item" href="<?php echo e(route('admin.rental.provider.export-review', ['provider_id' => request()->id, 'type'=>'csv', request()->getQueryString()])); ?>">
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


                <div class="card-body p-0 verticle-align-middle-table">
                    <div class="table-responsive datatable-custom">
                        <table id="columnSearchDatatable"
                               class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                            <tr>
                                <th class="border-0"><?php echo e(translate('sl')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Review_ID')); ?></th>
                                <th class="w-10p"><?php echo e(translate('messages.vehicle')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Customer')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Review')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Date')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Provider_Reply')); ?></th>
                                <th class="text-center border-0"><?php echo e(translate('messages.Status')); ?></th>
                            </tr>
                            </thead>

                            <tbody id="set-rows">
                            <?php $__currentLoopData = $tripReviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $tripReview): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key + $tripReviews->firstItem()); ?></td>
                                    <td><?php echo e($tripReview->review_id); ?></td>

                                    <td class="d-flex">
                                        <?php if($tripReview->vehicle): ?>
                                            <a class="media align-items-center mb-1" href="<?php echo e(route('admin.rental.provider.vehicle.details', $tripReview->vehicle_id)); ?>">
                                                <img class="avatar avatar-lg mr-3 onerror-image"
                                                     src="<?php echo e($tripReview->vehicle['thumbnailFullUrl'] ?? asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                                                     data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>"
                                                     alt="<?php echo e($tripReview->vehicle['name']); ?> image">
                                            </a>
                                            <div class="py-2">
                                                <a class="media align-items-center mb-1" href="<?php echo e(route('admin.rental.provider.vehicle.details', $tripReview->vehicle_id)); ?>">
                                                    <div class="media-body">
                                                        <h5 class="text-hover-primary mb-0"><?php echo e(Str::limit($tripReview->vehicle['name'],20,'...')); ?></h5>
                                                    </div>
                                                </a>
                                                <a class="mr-5 text-body" href="<?php echo e(route('admin.rental.trip.details', $tripReview->trip_id)); ?>"> <?php echo e(translate('Trip_ID')); ?>: <?php echo e($tripReview->trip_id); ?></a>
                                            </div>
                                        <?php else: ?>
                                            <?php echo e(translate('messages.Trip_deleted!')); ?>

                                        <?php endif; ?>

                                    </td>

                                    <td>
                                        <div class="table-rest-info d-block">
                                            <div class="info">
                                                <div title="Car Rental Service" class="text--info">
                                                    <?php echo e($tripReview->customer->fullName); ?>

                                                </div>
                                                <div>
                                                <span class="font-light">
                                                    <?php echo e($tripReview->customer->phone); ?>

                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="font-semibold text--warning">
                                            <i class="fs-13 tio-star"></i>
                                            <?php echo e($tripReview->rating); ?>

                                        </div>
                                        <?php if($tripReview->comment): ?>
                                            <div class="line--limit-2 max-w--220px">
                                                <?php echo e($tripReview->comment); ?>

                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo e($tripReview->reviewDate); ?>

                                        <br>
                                        <?php echo e($tripReview->reviewTime); ?>

                                    </td>
                                    <td>
                                        <div class="line--limit-2 max-w--220px">
                                            <?php echo e($tripReview->reply ? $tripReview->reply : 'N/A'); ?>

                                        </div>
                                    <td>
                                        <label class="toggle-switch toggle-switch-sm" for="publishCheckbox<?php echo e($tripReview->id); ?>">
                                            <input type="checkbox" data-url="<?php echo e(route('admin.rental.provider.vehicle.review.status', $tripReview->id)); ?>" class="toggle-switch-input redirect-url"
                                                   id="publishCheckbox<?php echo e($tripReview->id); ?>" <?php echo e($tripReview->status ? 'checked' : ''); ?>>
                                            <span class="toggle-switch-label mx-auto">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                        </label>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                    </div>
                    <?php if(count($tripReviews) !== 0): ?>
                        <hr>
                    <?php endif; ?>
                    <div class="page-area mt-3">
                        <?php echo $tripReviews->appends($_GET)->links(); ?>

                    </div>
                    <?php if(count($tripReviews) === 0): ?>
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
<div id="title" data-title="<?php echo e(translate('Are_you_sure?')); ?>"></div>
<div id="buttonCancel" data-no="<?php echo e(translate('no')); ?>"></div>
<div id="buttonApprove" data-yes="<?php echo e(translate('yes')); ?>"></div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('Modules/Rental/public/assets/js/admin/view-pages/provider-review.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/admin/provider/details/review.blade.php ENDPATH**/ ?>