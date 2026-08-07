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
        <div>
            <h1 class="page-header-title mb-1 d-flex align-items-center gap-2">
                
                <?php echo e(translate('Advertisement ID')); ?> #<?php echo e($advertisement->id); ?>

            </h1>
            <p class="d-flex gap-2 align-items-center mb-0">
                <span><?php echo e(translate('Ad Placed')); ?></span>
                <span class="mx-1">:</span>
                <span class="font-medium text-title"><?php echo e(\App\CentralLogics\Helpers::time_date_format($advertisement->created_at)); ?></span>
            </p>
        </div>
        
        <a href="#" class="btn btn--primary new-dynamic-submit-model"

            id="data-edit-<?php echo e($advertisement->id); ?>"
            data-id="data-edit-<?php echo e($advertisement->id); ?>"

            data-title="<?php echo e(translate('Do You Want to Edit?')); ?>"
            data-text="<p><?php echo e(translate('Your ad is running. If you edit this ad, it will be listed for pending and needs to be approved by the Admin. After the approval, it will be running again.')); ?></p>"
            data-image="<?php echo e(asset('public/assets/admin/img/modal/package-status-disable.png')); ?>"
            data-type="resume"
            data-btn_class = "btn-primary"
            data-success_btn_text = "<?php echo e(translate('Yes, Edit')); ?>"


            >
            <i class="tio-edit"></i>
            <span><?php echo e(translate('Edit Ads')); ?></span>
        </a>


        </div>
            <form  id="data-edit-<?php echo e($advertisement->id); ?>_form" action="<?php echo e(route('vendor.advertisement.edit',[$advertisement->id ,'request_page_type'=> isset($request_page_type) ])); ?>" method="get">
               
            </form>
    <div class="row g-3">
        <div class="col-xl-8">
            <div class="card mb-3 h-100">
                <div class="card-body p-3 p-sm-4 fs-12">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h4><?php echo e(translate('Ad Details')); ?></h4>

                        </div>
                        <div class="col-md-6">
                            <div class="mb-20">
                                <div class="d-flex align-items-center flex-wrap gap-2 justify-content-md-end approve-buttons">


                                </div>
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








                    <div class="col-lg-12">
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






                        <div class="col-lg-12">
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
                        <h3 class=" mb-4"><?php echo e(translate('Ad Status')); ?></h3>
<hr>
                        <div class="d-flex flex-column gap-2 gap-lg-3 ">
                            <p class="d-flex gap-2 justify-content-between align-items-center mb-0 ">
                                <span><?php echo e(translate('Request_Verify_Status')); ?>: </span>
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


                            <p class="d-flex justify-content-between gap-2 align-items-center mb-0">
                                <span><?php echo e(translate('Payment Status')); ?>

                                <span class="mx-1">:</span></span>
                                <?php if($advertisement->is_paid == 1): ?>
                                <span class="font-semibold text-success"><?php echo e(translate('Paid')); ?></span>
                                <?php else: ?>
                                <span class="font-semibold text-danger"><?php echo e(translate('Unpaid')); ?></span>

                                <?php endif; ?>
                            </p>
                            <p class="d-flex gap-2 justify-content-between align-items-center mb-0">
                                <span><?php echo e(translate('Ad Type')); ?>

                                <span class="mx-1">:</span> </span>
                                <span class="font-medium text-title"><?php echo e(translate($advertisement->add_type)); ?></span>
                            </p>
                            <p class="d-flex gap-2 justify-content-between align-items-center mb-0">
                                <span><?php echo e(translate('Duration')); ?><span class="mx-1">:</span></span>
                                <span class="font-medium text-title"><?php echo e(\App\CentralLogics\Helpers::date_format($advertisement->start_date).' - ' .\App\CentralLogics\Helpers::date_format($advertisement->end_date)); ?></span>
                            </p>
                        </div>

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

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/advertisement/details.blade.php ENDPATH**/ ?>