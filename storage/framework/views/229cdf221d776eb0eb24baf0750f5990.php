<?php $__env->startSection('title','Advertisement Details'); ?>

<?php $__env->startSection('advertisement'); ?>
active
<?php $__env->stopSection(); ?>
<?php if(isset($request_page_type)): ?>
<?php $__env->startSection('advertisement_request'); ?>
<?php else: ?>
<?php $__env->startSection('advertisement_list'); ?>
<?php endif; ?>
active
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css_or_js'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/assets/admin/css/daterangepicker.css')); ?>"/>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <h1 class="page-header-title m-0 d-flex align-items-center gap-2">
            <img src="<?php echo e(asset('public/assets/admin/img/advertisement.png')); ?>" alt="">
            <?php echo e(translate('Ads Details')); ?>

        </h1>
        <div class="d-flex gap-1">

            <?php if($previousId): ?>

            <a href="<?php echo e(route('admin.advertisement.show', [$previousId])); ?>"  data-toggle="tooltip"
                data-placement="top" title="<?php echo e(translate('Previous_advertisement')); ?>" class="arrow-icon">
                <i class="tio-chevron-left"></i>
                </a>
            <?php endif; ?>




                <?php if($nextId): ?>
                <a href="<?php echo e(route('admin.advertisement.show', [$nextId] )); ?>"  data-toggle="tooltip"
                data-placement="top" title="<?php echo e(translate('next_advertisement')); ?>" class="arrow-icon">
                    <i class="tio-chevron-right"></i>
                </a>

                <?php endif; ?>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-xl-8">
            <div class="card mb-3 h-100">
                <div class="card-body p-3 p-sm-4 fs-12">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h4><?php echo e(translate('Ads_ID_#')); ?><?php echo e($advertisement->id); ?></h4>
                            <p class="d-flex gap-2 align-items-center mb-0">
                                <span class="w-80px"><?php echo e(translate('Ad Placed')); ?></span>
                                <span class="mx-1">:</span>
                                <span class="font-medium text-title"><?php echo e(\App\CentralLogics\Helpers::time_date_format($advertisement->created_at)); ?></span>
                            </p>
                            <p class="d-flex gap-2 align-items-center mb-0">
                                <span class="w-80px"><?php echo e(translate('Ad Type')); ?>  </span>
                                <span class="mx-1">:</span>
                                <span class="font-medium text-title"><?php echo e(translate($advertisement->add_type)); ?></span>
                            </p>
                            <p class="d-flex gap-2 align-items-center mb-0">
                                <span class="w-80px"><?php echo e(translate('Duration')); ?> </span>
                                <span class="mx-1">:</span>
                                <span class="font-medium text-title"><?php echo e(\App\CentralLogics\Helpers::date_format($advertisement->start_date).' - ' .\App\CentralLogics\Helpers::date_format($advertisement->end_date)); ?></span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-20">
                                <div class="d-flex align-items-center flex-wrap gap-2 justify-content-md-end approve-buttons">
                                    <?php if( $advertisement->status === 'pending'): ?>


                                    <a type="button"  class="btn btn-outline-danger new-dynamic-submit-model"
                                    id="data-add-<?php echo e($advertisement->id); ?>"
                                    data-id="data-add-<?php echo e($advertisement->id); ?>"
                                    data-title="<?php echo e(translate('Are you sure you want to deny the request?')); ?>"
                                    data-text="<p><?php echo e(translate('You will lost the Store ads request.')); ?></p>"
                                    data-image="<?php echo e(asset('public/assets/admin/img/modal/deny.png')); ?>"
                                    data-type="deny"
                                    data-btn_class = "btn-primary"
                                    data-2nd_btn_text = "<?php echo e(translate('messages.Cancel')); ?>"

                                    href="#">
                                    <i class="tio-clear"></i>
                                    <span><?php echo e(translate('Deny')); ?></span>
                                        </a>

                                        <form  id="data-add-<?php echo e($advertisement->id); ?>_form" action="<?php echo e(route('admin.advertisement.status',['status' => 'paused' ,'id' => $advertisement->id])); ?>" method="get">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('get'); ?>
                                            <input type="hidden"  name="cancellation_note" id="data-add-<?php echo e($advertisement?->id); ?>_note">
                                            <input type="hidden"  name="status" value="denied">
                                            <input type="hidden"  name="id" value="<?php echo e($advertisement->id); ?>">
                                        </form>

                                    <a type="button" class="btn btn-outline-success" href="#"
                                        <?php if($advertisement->active == 0): ?>
                                        data-toggle="modal" data-target="#exp-approve-model"

                                        <?php else: ?>

                                        data-toggle="modal" data-target="#confirm-approve-model"
                                        <?php endif; ?>
                                         >

                                        <i class="tio-done"></i>
                                        <span><?php echo e(translate('Approve')); ?></span>
                                        </a>
                                    <?php elseif($advertisement->status === 'denied'): ?>
                                        <a type="button" class="btn btn-outline-success" href="#"


                                            <?php if($advertisement->active == 0): ?>
                                            data-toggle="modal" data-target="#exp-approve-model"

                                            <?php else: ?>

                                            data-toggle="modal" data-target="#confirm-approve-model"
                                            <?php endif; ?>

                                            >
                                            <i class="tio-done"></i>
                                            <span><?php echo e(translate('Approve')); ?></span>
                                        </a>
                                    <?php endif; ?>

                                    <a href="<?php echo e(route('admin.advertisement.edit',[$advertisement->id ,'request_page_type'=> isset($request_page_type) ])); ?>" class="btn btn--primary">
                                        <i class="tio-edit"></i>
                                        <span><?php echo e(translate('Edit Ads')); ?></span>
                                    </a>
                                </div>
                            </div>
                            <div class="d-flex flex-column gap-2 gap-lg-3 align-items-lg-end">
                                <p class="d-flex gap-2 align-items-center mb-0 justify-content-md-end">
                                    <span><?php echo e(translate('Status')); ?>: </span>
                                    <?php if($advertisement->status == 'approved' && $advertisement->active == 1 ): ?>
                                    <span class="px-2  badge badge-soft-primary rounded-pill"><?php echo e(translate('messages.running')); ?></span>
                                    <?php elseif($advertisement->status == 'approved' && $advertisement->active == 2 ): ?>
                                    <span class="px-2  badge badge-soft-success rounded-pill"><?php echo e(translate('messages.approved')); ?></span>
                                    <?php elseif($advertisement->status == 'paused' && $advertisement->active == 1 ): ?>
                                    <span class="px-2  badge badge-soft-warning rounded-pill"><?php echo e(translate('messages.paused')); ?></span>
                                    <?php elseif(in_array($advertisement->status ,['denied','expired'] )): ?>
                                    <span class="px-2  badge badge-soft-danger rounded-pill"><?php echo e(translate($advertisement->status)); ?></span>
                                    <?php elseif($advertisement->active == 0): ?>
                                    <span class="px-2  badge badge-soft-secondary rounded-pill"><?php echo e(translate('messages.Expired')); ?></span>
                                    <?php else: ?>
                                    <span class="px-2  badge badge-soft-info rounded-pill"><?php echo e(translate($advertisement->status)); ?></span>
                                    <?php endif; ?>


                                </p>
                                <p class="d-flex gap-2 align-items-center mb-0 justify-content-md-end">
                                    <span><?php echo e(translate('Payment Status')); ?>: </span>
                                    <?php if($advertisement->is_paid == 1): ?>
                                    <span class="font-semibold text-success"><?php echo e(translate('Paid')); ?></span>
                                    <?php else: ?>
                                    <span class="font-semibold text-danger"><?php echo e(translate('Unpaid')); ?></span>

                                    <?php endif; ?>
                                </p>
                            </div>
                            </div>
                            <div class="col-lg-12">
                        <?php if( ($advertisement->status == 'denied' && $advertisement->cancellation_note  != null) || ($advertisement->status == 'paused' && $advertisement->pause_note  != null) ): ?>
                            <div class="border rounded d-flex flex-wrap p-2 mb-4 gap-1 bg--3">
                                <div class="text-danger font-bold">
                                    <?php echo e($advertisement->status == 'denied' ? translate('#_Cancellation Note') : translate('#_Pause Note')); ?> :
                                </div>
                                <div class="flex-grow"><?php echo e($advertisement->status == 'denied' ? $advertisement->cancellation_note : $advertisement->pause_note); ?></div>
                            </div>

                            <?php endif; ?>
                        <hr class="m-0">
                    </div>








                    <div class="col-lg-5">
                        <div class="js-nav-scroller hs-nav-scroller-horizontal">

                            <ul class="nav nav-tabs mb-3 border-0">
                                <li class="nav-item">
                                    <a class="nav-link text--black lang_link active"
                                    href="#"
                                    id="default-link"><?php echo e(translate('messages.default')); ?></a>
                                </li>
                                <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="nav-item">
                                        <a class="nav-link text--black lang_link"
                                            href="#"
                                            id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                        </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                            <div class="lang_form" id="default-form">
                                <h4 class="mb-2"><?php echo e(translate('Title')); ?>:</h4>
                                <p class=""><?php echo e($advertisement?->getRawOriginal('title')); ?></p>
                                <h4 class="mb-2"><?php echo e(translate('Description')); ?>:</h4>
                                <p class="m-0"><?php echo e($advertisement?->getRawOriginal('description')); ?></p>

                            </div>





                            <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                if(count($advertisement['translations'])){
                                    $translate = [];
                                    foreach($advertisement['translations'] as $t)
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

                                    <h4 class="mb-2"><?php echo e(translate('Title')); ?>:</h4>
                                    <p class=""><?php echo e($translate[$lang]['title']??'------------'); ?></p>
                                    <h4 class="mb-2"><?php echo e(translate('Description')); ?>:</h4>
                                    <p class="m-0"><?php echo e($translate[$lang]['description']??'------------'); ?></p>

                                </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>






                        <div class="col-lg-7">
                            <?php if($advertisement?->add_type == 'video_promotion'): ?>
                            <div class="d-flex gap-3 flex-wrap flex-sm-nowrap">
                                <div class="w-100">
                                    <h4 class="mb-2"><?php echo e(translate('Video')); ?></h4>
                                    <div class="img-wrap max-w-260px position-relative rounded overflow-hidden before-content" data-toggle="modal" data-target="#video-modal">
                                        <video src="<?php echo e($advertisement?->video_attachment_full_url); ?>" controls class="w-100 rounded"></video>
                                    </div>
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="d-flex gap-3 flex-wrap flex-sm-nowrap">
                                <div class="w-100 add-profile-image">
                                    <h4 class="mb-2"><?php echo e(translate('Profile Image')); ?></h4>
                                    <div class="cursor-pointer profile_image_view img-wrap max-w-130px">
                                        <img src="<?php echo e($advertisement?->profile_image_full_url); ?>" class="w-100 rounded object-cover aspect-1-1">
                                    </div>
                                </div>
                                <div class="w-100 add-profile-banner">
                                    <h4 class="mb-2"><?php echo e(translate('Cover Image')); ?></h4>
                                    <div class="cursor-pointer cover_image_view img-wrap max-w-260px">
                                        <img src="<?php echo e($advertisement?->cover_image_full_url); ?>" class="w-100 rounded object-cover aspect-2-1">
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="h-100 d-flex flex-column gap-3">
                <div class="card flex-grow">
                    <div class="card-body">
                        <h3 class="text-center mb-4"><?php echo e(translate('Advertisement Setup')); ?></h3>
                        <div class="form-group">
                            <label class="toggle-switch toggle-switch-sm d-flex justify-content-between border rounded px-3 px-xl-4 form-control">
                                <span class="line--limit-1"><?php echo e(translate('Paid Status')); ?></span>
                                <input type="checkbox" id="is_paid" value="1" name="is_paid" data-id="is_paid" data-type="toggle" data-image-on="<?php echo e(asset('public/assets/admin/img/modal/dm-tips-on.png')); ?>" data-image-off="<?php echo e(asset('public/assets/admin/img/modal/dm-tips-off.png')); ?>" data-title-on="<?php echo e(translate('messages.Are_you_sure?')); ?>" data-title-off="<?php echo e(translate('messages.Are_you_sure?')); ?>" data-text-on="<p><?php echo e(translate('You_want_to_marked_this_advertisment_as_Paid.')); ?></p>" data-text-off="<p><?php echo e(translate('You_want_to_marked_this_advertisment_as_Unpaid.')); ?></p>" class="status toggle-switch-input dynamic-checkbox" <?php echo e($advertisement?->is_paid == 1 ? 'checked'  : ''); ?> >
                                <span class="toggle-switch-label text">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </label>
                        </div>

                        <form action="<?php echo e(route('admin.advertisement.paidStatus')); ?>" id="is_paid_form" method="get">
                            <input type="hidden" name="add_id" value="<?php echo e($advertisement?->id); ?>">
                        </form>
                            <?php if(!in_array($advertisement->status ,['denied','pending']) && $advertisement->active == 1  ): ?>

                            <div class="mb-20">
                                <label class="form-label"><?php echo e(translate('Ads Status')); ?></label>
                                


                                <?php if($advertisement->status == 'paused'): ?>
                                <a class="btn btn-soft-primary justify-content-center d-flex gap-2 align-items-center new-dynamic-submit-model"


                                id="data-add-<?php echo e($advertisement->id); ?>"
                                data-id="data-add-<?php echo e($advertisement->id); ?>"

                                data-title="<?php echo e(translate('Are you sure you want to Resume the request?')); ?>"
                                data-text="<p><?php echo e(translate('This ad will be run again and will show in the user app & websites.')); ?></p>"
                                data-image="<?php echo e(asset('public/assets/admin/img/modal/resume.png')); ?>"
                                data-type="resume"
                                data-btn_class = "btn-primary"


                                href="#">
                                    <i class="tio-pause-circle"></i>
                                    <?php echo e(translate('Resume_Ads')); ?>

                                </a>

                                <form  id="data-add-<?php echo e($advertisement->id); ?>_form" action="<?php echo e(route('admin.advertisement.status',['status' => 'approved' ,'id' => $advertisement->id])); ?>" method="get">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('get'); ?>
                                    <input type="hidden"  name="status" value="approved">
                                    <input type="hidden"  name="id" value="<?php echo e($advertisement->id); ?>">
                                </form>

                            <?php elseif($advertisement->status == 'approved' && ($advertisement->active == 1 || $advertisement->active == 2 )): ?>
                            <a class="btn btn-soft-danger justify-content-center d-flex gap-2 align-items-center new-dynamic-submit-model"
                            id="data-add-<?php echo e($advertisement->id); ?>"
                            data-id="data-add-<?php echo e($advertisement->id); ?>"
                            data-title="<?php echo e(translate('Are you sure you want to Pause the request?')); ?>"
                            data-text="<p><?php echo e(translate('This ad will be pause and not show in the user app & websites.')); ?></p>"
                            data-image="<?php echo e(asset('public/assets/admin/img/modal/pause.png')); ?>"
                            data-type="pause"

                            href="#">
                                <i class="tio-pause-circle"></i>
                                <?php echo e(translate('Pause_Ads')); ?>

                                </a>

                                <form  id="data-add-<?php echo e($advertisement->id); ?>_form" action="<?php echo e(route('admin.advertisement.status',['status' => 'paused' ,'id' => $advertisement->id])); ?>" method="get">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('get'); ?>
                                    <input type="hidden"  name="pause_note" id="data-add-<?php echo e($advertisement?->id); ?>_note">
                                    <input type="hidden"  name="status" value="paused">
                                    <input type="hidden"  name="id" value="<?php echo e($advertisement->id); ?>">
                                </form>
                            <?php endif; ?>



                            </div>
                            <?php endif; ?>

                        <div>
                            <label class="form-label"><?php echo e(translate('Validity')); ?></label>
                            <div class="position-relative">
                                <i class="tio-calendar-month icon-absolute-on-right"></i>
                                <input type="text" class="form-control h-45 position-relative bg-transparent" value="<?php echo e(Carbon\Carbon::parse($advertisement?->start_date)->format('m/d/Y')  . ' - '.  Carbon\Carbon::parse($advertisement?->end_date)->format('m/d/Y')); ?>" name="dates" placeholder="Select Validation Date">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card flex-grow">
                    <div class="card-body">
                        <h5 class="card-title mb-3 align-items-center gap-2 text-title">
                            <span class="card-header-icon">
                                <i class="tio-shop"></i>
                            </span>
                            <span><?php echo e(translate('Store info')); ?></span>
                        </h5>
                        <a href="<?php echo e(route('admin.store.view', $advertisement->store_id)); ?>" class="media align-items-start deco-none resturant--information-single">
                            <div class="avatar avatar-circle">
                                <img class="avatar-img w-75px" src="<?php echo e($advertisement->store['logo_full_url'] ?? asset('public/assets/admin/img/100x100/food-default-image.png')); ?>" alt="image">

                            </div>
                            <div class="media-body pl-3">
                                <span class="fz--14px text-title font-semibold text-hover-primary d-block">
                                    <?php echo e($advertisement?->store?->name); ?>

                                    </span>
                                    <span class="text-body">
                                        <strong class="text-title font-semibold">
                                            <?php echo e($advertisement?->store?->total_order); ?>


                                            </strong>
                                            <?php echo e(translate('Orders served')); ?>

                                            </span>
                                            <span class="text-title font-semibold d-block">
                                                <i class="tio-call-talking-quiet"></i> <?php echo e($advertisement?->store?->phone); ?>

                                </span>
                                <span class="text-title">
                                    <i class="tio-poi"></i> <?php echo e($advertisement?->store?->address); ?>

                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="video-modal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header px-4 pt-4">
                    <h4 class="modal-title"><?php echo e(translate('Video Preview')); ?></h4>
                    <button type="button" data-dismiss="modal" class="btn p-0">
                        <i class="tio-clear fs-24"></i>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <video src="<?php echo e($advertisement?->video_attachment_full_url); ?>" controls class="w-100 rounded d-flex"></video>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="imagemodal_profile" tabindex="-1"
    role="dialog" aria-labelledby="order_proof"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"
                    id="order_proof">
                    <?php echo e(translate('Profile Image')); ?></h4>
                <button type="button" class="close"
                    data-dismiss="modal"><span
                        aria-hidden="true">&times;</span><span
                        class="sr-only"><?php echo e(translate('messages.cancel')); ?></span></button>
            </div>
            <div class="modal-body">
                <img src="<?php echo e($advertisement?->profile_image_full_url); ?>"
                    class="initial--22 w-100">
            </div>

            <div class="modal-footer">
                <a class="btn btn-primary" data-dismiss="modal"
                   href="#">
                    <?php echo e(translate('messages.Close')); ?>

                </a>
            </div>
        </div>
    </div>
</div>
    <div class="modal fade" id="imagemodal_cover" tabindex="-1"
    role="dialog" aria-labelledby="order_proof"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"
                    id="order_proof">
                    <?php echo e(translate('Cover Image')); ?></h4>
                <button type="button" class="close"
                    data-dismiss="modal"><span
                        aria-hidden="true">&times;</span><span
                        class="sr-only"><?php echo e(translate('messages.cancel')); ?></span></button>
            </div>
            <div class="modal-body">
                <img src="<?php echo e($advertisement?->cover_image_full_url); ?>"
                    class="initial--22 w-100">
            </div>

            <div class="modal-footer">
                <a class="btn btn-primary" data-dismiss="modal"
                   href="#">
                    <?php echo e(translate('messages.Close')); ?>

                </a>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="exp-approve-model">
    <div class="modal-dialog modal-dialog-centered status-warning-modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true" class="tio-clear"></span>
                </button>
            </div>
            <div class="modal-body pb-5 pt-0">
                <div class="max-349 mx-auto mb-20">
                    <div>
                        <div class="text-center">
                            <img src="<?php echo e(asset('public/assets/admin/img/modal/timeout.png')); ?>" class="mb-20">
                            <h5 class="modal-title"></h5>
                        </div>
                        <div class="text-center" >
                            <h3 > <?php echo e(translate('This advertisement is already expired.')); ?></h3>
                            <div > <p><?php echo e(translate('After approval this Advertisement will automatically show in the expired list as the duration is already over.')); ?></h3></p></div>
                        </div>

                        </div>

                    <div class="btn--container justify-content-center">
                            <a href="<?php echo e(route('admin.advertisement.edit',[$advertisement->id ,'request_page_type'=> isset($request_page_type) ])); ?>"  class="btn btn-success min-w-120" ><?php echo e(translate("Edit & Approve")); ?></a>
                            <a href="<?php echo e(route('admin.advertisement.status',['status' => 'approved' ,'id' => $advertisement->id ,'approved' => 1])); ?>" type="button"  class="btn btn--secondary  min-w-120"><?php echo e(translate('Only Approve')); ?></a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirm-approve-model">
    <div class="modal-dialog modal-dialog-centered status-warning-modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true" class="tio-clear"></span>
                </button>
            </div>
            <div class="modal-body pb-5 pt-0">
                <div class="max-349 mx-auto mb-20">
                    <div>
                        <div class="text-center">
                            <img width="80" src="<?php echo e(asset('public/assets/admin/img/modal/tick.png')); ?>" class="mb-20">
                            <h5 class="modal-title"></h5>
                        </div>
                        <div class="text-center" >
                            <h3 > <?php echo e(translate('Are_you_sure_?')); ?></h3>
                            <div > <p><?php echo e(translate('After approval this Advertisement will show in The User App & Websites.')); ?></h3></p></div>
                        </div>

                        </div>

                    <div class="btn--container justify-content-center">
                        <button data-dismiss="modal" class="btn btn--secondary min-w-120" ><?php echo e(translate("Not_Now")); ?></button>
                        <a href="<?php echo e(route('admin.advertisement.status',['status' => 'approved' ,'id' => $advertisement->id ,'approved' => 1])); ?>" type="button"  class="btn btn-primary min-w-120"><?php echo e(translate('Approve')); ?></a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>

    <script type="text/javascript" src="<?php echo e(asset('public/assets/admin/js/moment.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('public/assets/admin/js/daterangepicker.min.js')); ?>"></script>

    <script>
        $(function() {
            $('input[name="dates"]').daterangepicker({
                startDate: moment('<?php echo e($advertisement?->start_date); ?>').startOf('hour'),
                endDate: moment('<?php echo e($advertisement?->end_date); ?>').startOf('hour'),
                minDate: new Date(),
                autoUpdateInput: false,

            });
            $('.js-select').each(function () {
                let select2 = $.HSCore.components.HSSelect2.init($(this));
            });

            $('input[name="dates"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('M/D/Y') + ' - ' + picker.endDate.format('M/D/Y'));
                location.href = '<?php echo e(route('admin.advertisement.updateDate',$advertisement->id)); ?>' + '?start_date=' + picker.startDate.format('M/D/Y') + '&end_date=' + picker.endDate.format('M/D/Y');
            });

        });

        $('.modal').on('hidden.bs.modal', function (e) {
            $(this).find('video')[0].pause();
        });

        $('.profile_image_view').on('click', function () {

            $('#imagemodal_profile').modal('show');
        })
        $('.cover_image_view').on('click', function () {

            $('#imagemodal_cover').modal('show');
        })
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/advertisement/details.blade.php ENDPATH**/ ?>