<?php $__env->startSection('title',translate('messages.Delivery Man Preview')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/deliveryman.png')); ?>" class="w--30" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.delivery_man_details')); ?>

                </span>
            </h1>
            <div class="js-nav-scroller hs-nav-scroller-horizontal">
                <ul class="nav nav-tabs mb-3 border-0 nav--tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo e(route('vendor.delivery-man.preview', ['id'=>$dm->id, 'tab'=> 'info'])); ?>"  aria-disabled="true"><?php echo e(translate('messages.info')); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('vendor.delivery-man.preview', ['id'=>$dm->id, 'tab'=> 'transaction'])); ?>"  aria-disabled="true"><?php echo e(translate('messages.transaction')); ?></a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- End Page Header -->

        <div class="row mb-3 g-3 justify-content-center">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-sm-6 col-md-4">
                <div class="resturant-card card--bg-1">
                    <h2 class="title">
                        <?php echo e($dm->orders->count()); ?>

                    </h2>
                    <h5 class="subtitle">
                        <?php echo e(translate('messages.total_delivered_orders')); ?>

                    </h5>
                    <img class="resturant-icon w--30" src="<?php echo e(asset('public/assets/admin/img/tick.png')); ?>" alt="img">
                </div>
            </div>

            <!-- Collected Cash Card Example -->
            <div class="col-sm-6 col-md-4">
                <div class="resturant-card card--bg-2">
                    <h2 class="title">
                        <?php echo e(\App\CentralLogics\Helpers::format_currency($dm->wallet?$dm->wallet->collected_cash:0.0)); ?>

                    </h2>
                    <h5 class="subtitle">
                        <?php echo e(translate('messages.cash_in_hand')); ?>

                    </h5>
                    <img class="resturant-icon w--30" src="<?php echo e(asset('public/assets/admin/img/withdraw-amount.png')); ?>" alt="img">
                </div>
            </div>

            <!-- Total Earning Card Example -->
            <div class="col-sm-6 col-md-4">
                <div class="resturant-card card--bg-3">
                    <h2 class="title">
                        <?php echo e(\App\CentralLogics\Helpers::format_currency($dm->wallet?$dm->wallet->total_earning:0.00)); ?>

                    </h2>
                    <h5 class="subtitle">
                        <?php echo e(translate('messages.total_earning')); ?>

                    </h5>
                    <img class="resturant-icon w--30" src="<?php echo e(asset('public/assets/admin/img/pending.png')); ?>" alt="img">
                </div>
            </div>

        </div>
        <!-- Card -->
        <div class="card mb-3 mb-lg-5">
            <div class="card-header py-2">
                <div class="search--button-wrapper">
                    <h4 class="card-title mb-md-0"><?php echo e($dm['f_name'].' '.$dm['l_name']); ?><?php if($dm['status']): ?> <?php if($dm['active']): ?> <label class="badge badge-soft-primary m-0 ml-2"><?php echo e(translate('messages.online')); ?></label> <?php else: ?> <label class="badge badge-soft-danger m-0 ml-2"><?php echo e(translate('messages.offline')); ?></label> <?php endif; ?>  <?php else: ?> <span class="badge badge-danger"><?php echo e(translate('messages.suspended')); ?></span> <?php endif; ?></h4>

                    <a  href="javascript:"
                        data-url="<?php echo e(route('vendor.delivery-man.status',[$dm['id'],$dm->status?0:1])); ?>"
                        data-title="<?php echo e(translate('Are_you_sure_?')); ?>"
                        data-message="<?php echo e($dm->status?'Want to suspend this deliveryman ?':'Want to unsuspend this deliveryman'); ?>"
                        class="btn <?php echo e($dm->status?'btn-danger':'btn-success'); ?>  route-alert">
                            <?php echo e($dm->status?translate('messages.suspend_this_delivery_man'):translate('messages.unsuspend_this_delivery_man')); ?>

                    </a>
                </div>
            </div>
            <!-- Body -->
            <div class="card-body">
                <div class="row gy-3 align-items-center">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center justify-content-center">
                            <img class="avatar avatar-xxl avatar-4by3 mr-4 img--120 onerror-image"
                                 data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
                                 src="<?php echo e($dm['image_full_url']); ?>"
                                 alt="Image Description">
                                 <div class="d-block">
                                    <div class="rating--review">
                                        <h1 class="title"><?php echo e(count($dm->rating)>0?number_format($dm->rating[0]->average, 1, '.', ' '):0); ?><span class="out-of">/5</span></h1>
                                        <?php if(count($dm->rating)>0): ?>
                                        <?php if($dm->rating[0]->average == 5): ?>
                                        <div class="rating">
                                            <span><i class="tio-star"></i></span>
                                            <span><i class="tio-star"></i></span>
                                            <span><i class="tio-star"></i></span>
                                            <span><i class="tio-star"></i></span>
                                            <span><i class="tio-star"></i></span>
                                        </div>
                                        <?php elseif($dm->rating[0]->average < 5 && $dm->rating[0]->average >= 4.5): ?>
                                        <div class="rating">
                                            <span><i class="tio-star"></i></span>
                                            <span><i class="tio-star"></i></span>
                                            <span><i class="tio-star"></i></span>
                                            <span><i class="tio-star"></i></span>
                                            <span><i class="tio-star-half"></i></span>
                                        </div>
                                        <?php elseif($dm->rating[0]->average < 4.5 && $dm->rating[0]->average >= 4): ?>
                                        <div class="rating">
                                            <span><i class="tio-star"></i></span>
                                            <span><i class="tio-star"></i></span>
                                            <span><i class="tio-star"></i></span>
                                            <span><i class="tio-star"></i></span>
                                            <span><i class="tio-star-outlined"></i></span>
                                        </div>
                                        <?php elseif($dm->rating[0]->average < 4 && $dm->rating[0]->average >= 3.5): ?>
                                        <div class="rating">
                                            <span><i class="tio-star"></i></span>
                                            <span><i class="tio-star"></i></span>
                                            <span><i class="tio-star"></i></span>
                                            <span><i class="tio-star-half"></i></span>
                                            <span><i class="tio-star-outlined"></i></span>
                                        </div>
                                        <?php elseif($dm->rating[0]->average < 3.5 && $dm->rating[0]->average >= 3): ?>
                                        <div class="rating">
                                            <span><i class="tio-star"></i></span>
                                            <span><i class="tio-star"></i></span>
                                            <span><i class="tio-star"></i></span>
                                            <span><i class="tio-star-outlined"></i></span>
                                            <span><i class="tio-star-outlined"></i></span>
                                        </div>
                                        <?php elseif($dm->rating[0]->average < 3 && $dm->rating[0]->average >= 2.5): ?>
                                        <div class="rating">
                                            <span><i class="tio-star"></i></span>
                                            <span><i class="tio-star"></i></span>
                                            <span><i class="tio-star-half"></i></span>
                                            <span><i class="tio-star-outlined"></i></span>
                                            <span><i class="tio-star-outlined"></i></span>
                                        </div>
                                        <?php elseif($dm->rating[0]->average < 2.5 && $dm->rating[0]->average > 2): ?>
                                        <div class="rating">
                                            <span><i class="tio-star"></i></span>
                                            <span><i class="tio-star"></i></span>
                                            <span><i class="tio-star-outlined"></i></span>
                                            <span><i class="tio-star-outlined"></i></span>
                                            <span><i class="tio-star-outlined"></i></span>
                                        </div>
                                        <?php elseif($dm->rating[0]->average < 2 && $dm->rating[0]->average >= 1.5): ?>
                                        <div class="rating">
                                            <span><i class="tio-star"></i></span>
                                            <span><i class="tio-star-half"></i></span>
                                            <span><i class="tio-star-outlined"></i></span>
                                            <span><i class="tio-star-outlined"></i></span>
                                            <span><i class="tio-star-outlined"></i></span>
                                        </div>
                                        <?php elseif($dm->rating[0]->average < 1.5 && $dm->rating[0]->average > 1): ?>
                                        <div class="rating">
                                            <span><i class="tio-star"></i></span>
                                            <span><i class="tio-star-outlined"></i></span>
                                            <span><i class="tio-star-outlined"></i></span>
                                            <span><i class="tio-star-outlined"></i></span>
                                            <span><i class="tio-star-outlined"></i></span>
                                        </div>
                                        <?php elseif($dm->rating[0]->average < 1 && $dm->rating[0]->average > 0): ?>
                                        <div class="rating">
                                            <span><i class="tio-star-half"></i></span>
                                            <span><i class="tio-star-outlined"></i></span>
                                            <span><i class="tio-star-outlined"></i></span>
                                            <span><i class="tio-star-outlined"></i></span>
                                            <span><i class="tio-star-outlined"></i></span>
                                        </div>
                                        <?php elseif($dm->rating[0]->average == 1): ?>
                                        <div class="rating">
                                            <span><i class="tio-star"></i></span>
                                            <span><i class="tio-star-outlined"></i></span>
                                            <span><i class="tio-star-outlined"></i></span>
                                            <span><i class="tio-star-outlined"></i></span>
                                            <span><i class="tio-star-outlined"></i></span>
                                        </div>
                                        <?php elseif($dm->rating[0]->average == 0): ?>
                                        <div class="rating">
                                            <span><i class="tio-star-outlined"></i></span>
                                            <span><i class="tio-star-outlined"></i></span>
                                            <span><i class="tio-star-outlined"></i></span>
                                            <span><i class="tio-star-outlined"></i></span>
                                            <span><i class="tio-star-outlined"></i></span>
                                        </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <div class="info">

                                        <span><?php echo e($dm->reviews->count()); ?> <?php echo e(translate('messages.reviews')); ?></span>
                                    </div>
                                    </div>
                                </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <ul class="list-unstyled list-unstyled-py-2 mb-0 rating--review-right py-3">

                        <?php ($total=$dm->reviews->count()); ?>
                        <!-- Review Ratings -->
                            <li class="d-flex align-items-center font-size-sm">
                                <?php ($five=\App\CentralLogics\Helpers::dm_rating_count($dm['id'],5)); ?>
                                <span
                                    class="progress-name mr-3"><?php echo e(translate('excellent')); ?></span>
                                <div class="progress flex-grow-1">
                                    <div class="progress-bar" role="progressbar"
                                         style="width: <?php echo e($total==0?0:($five/$total)*100); ?>%;"
                                         aria-valuenow="<?php echo e($total==0?0:($five/$total)*100); ?>"
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="ml-3"><?php echo e($five); ?></span>
                            </li>
                            <!-- End Review Ratings -->

                            <!-- Review Ratings -->
                            <li class="d-flex align-items-center font-size-sm">
                                <?php ($four=\App\CentralLogics\Helpers::dm_rating_count($dm['id'],4)); ?>
                                <span class="progress-name mr-3"><?php echo e(translate('good')); ?></span>
                                <div class="progress flex-grow-1">
                                    <div class="progress-bar" role="progressbar"
                                         style="width: <?php echo e($total==0?0:($four/$total)*100); ?>%;"
                                         aria-valuenow="<?php echo e($total==0?0:($four/$total)*100); ?>"
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="ml-3"><?php echo e($four); ?></span>
                            </li>
                            <!-- End Review Ratings -->

                            <!-- Review Ratings -->
                            <li class="d-flex align-items-center font-size-sm">
                                <?php ($three=\App\CentralLogics\Helpers::dm_rating_count($dm['id'],3)); ?>
                                <span class="progress-name mr-3"><?php echo e(translate('average')); ?></span>
                                <div class="progress flex-grow-1">
                                    <div class="progress-bar" role="progressbar"
                                         style="width: <?php echo e($total==0?0:($three/$total)*100); ?>%;"
                                         aria-valuenow="<?php echo e($total==0?0:($three/$total)*100); ?>"
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="ml-3"><?php echo e($three); ?></span>
                            </li>
                            <!-- End Review Ratings -->

                            <!-- Review Ratings -->
                            <li class="d-flex align-items-center font-size-sm">
                                <?php ($two=\App\CentralLogics\Helpers::dm_rating_count($dm['id'],2)); ?>
                                <span class="progress-name mr-3"><?php echo e(translate('below_average')); ?></span>
                                <div class="progress flex-grow-1">
                                    <div class="progress-bar" role="progressbar"
                                         style="width: <?php echo e($total==0?0:($two/$total)*100); ?>%;"
                                         aria-valuenow="<?php echo e($total==0?0:($two/$total)*100); ?>"
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="ml-3"><?php echo e($two); ?></span>
                            </li>
                            <!-- End Review Ratings -->

                            <!-- Review Ratings -->
                            <li class="d-flex align-items-center font-size-sm">
                                <?php ($one=\App\CentralLogics\Helpers::dm_rating_count($dm['id'],1)); ?>
                                <span class="progress-name mr-3"><?php echo e(translate('poor')); ?></span>
                                <div class="progress flex-grow-1">
                                    <div class="progress-bar" role="progressbar"
                                         style="width: <?php echo e($total==0?0:($one/$total)*100); ?>%;"
                                         aria-valuenow="<?php echo e($total==0?0:($one/$total)*100); ?>"
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="ml-3"><?php echo e($one); ?></span>
                            </li>
                            <!-- End Review Ratings -->
                        </ul>
                    </div>
                </div>
            </div>
            <!-- End Body -->
        </div>
        <!-- End Card -->
        <?php ($store=\App\CentralLogics\Helpers::get_store_data()); ?>


        <?php if($store->review_permission): ?>

        <!-- Card -->
        <div class="card">

            <div class="table-responsive datatable-custom">
                <table id="datatable" class="table table-borderless table-thead-bordered table-nowrap card-table"
                       data-hs-datatables-options='{
                     "columnDefs": [{
                        "targets": [0, 3, 6],
                        "orderable": false
                      }],
                     "order": [],
                     "info": {
                       "totalQty": "#datatableWithPaginationInfoTotalQty"
                     },
                     "search": "#datatableSearch",
                     "entries": "#datatableEntries",
                     "pageLength": 25,
                     "isResponsive": false,
                     "isShowPaging": false,
                     "pagination": "datatablePagination"
                   }'>
                    <thead class="thead-light">
                    <tr>
                        <th class="border-0"><?php echo e(translate('messages.reviewer')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.review')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.attachment')); ?></th>
                        <th class="border-0"><?php echo e(translate('messages.date')); ?></th>
                    </tr>
                    </thead>

                    <tbody>

                    <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <?php if($review->customer): ?>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-circle">
                                            <img class="avatar-img onerror-image" width="75" height="75"
                                                 data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
                                                 src="<?php echo e($review->customer->image_full_url); ?>"
                                                alt="Image Description">
                                        </div>
                                        <div class="ml-3">
                                        <span class="d-block h5 text-hover-primary mb-0"><?php echo e($review->customer['f_name']." ".$review->customer['l_name']); ?> <i
                                                class="tio-verified text-primary" data-toggle="tooltip" data-placement="top"
                                                title="Verified Customer"></i></span>
                                            <span class="d-block font-size-sm text-body"><?php echo e($review->customer->email); ?></span>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <?php echo e(translate('messages.customer_not_found')); ?>

                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="text-wrap w-18rem" >
                                    <div class="d-flex mb-2">
                                        <label class="badge badge-soft-info">
                                            <?php echo e($review->rating); ?> <i class="tio-star"></i>
                                        </label>
                                    </div>
                                    <p>
                                        <?php echo e($review['comment']); ?>

                                    </p>
                                </div>
                            </td>
                            <td>
                                <?php $__currentLoopData = json_decode($review['attachment'],true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php ($attachment = is_array($attachment)?$attachment:['img'=>$attachment,'storage'=>'public']); ?>
                                    <img width="100" class="onerror-image" data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img2.jpg')); ?>"  src="<?php echo e(\App\CentralLogics\Helpers::get_full_url($attachment['img'],$attachment['img'],$attachment['storage'] ?? 'public')); ?>"
                                    alt="image">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </td>
                            <td>
                                <?php echo e(date('d M Y '. config('timeformat'),strtotime($review['created_at']))); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <!-- End Table -->



            <?php if(count($reviews) === 0): ?>
                <div class="empty--data">
                    <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                    <h5>
                        <?php echo e(translate('no_data_found')); ?>

                    </h5>
                </div>
            <?php endif; ?>

            <!-- Footer -->
            <div class="card-footer">
                <!-- Pagination -->
                <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                    <div class="col-12">
                        <?php echo $reviews->links(); ?>

                    </div>
                </div>
                <!-- End Pagination -->
            </div>
            <!-- End Footer -->
        </div>
        <!-- End Card -->

        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/delivery-man/view/info.blade.php ENDPATH**/ ?>