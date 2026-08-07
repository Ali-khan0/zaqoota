<div class="card h-100">
    <!-- Header -->
    <div class="card-header">
        <div class="chat-user-info w-100 d-flex align-items-center">
            <div class="chat-user-info-img">
                <img class="avatar-img onerror-image"
                src="<?php echo e($user['image_full_url']); ?>"
                    data-onerror-image="<?php echo e(asset('public/assets/admin')); ?>/img/160x160/img1.jpg"
                    alt="Image Description">
            </div>
            <div class="chat-user-info-content">
                <h5 class="mb-0 text-capitalize">
                    <?php echo e($user['f_name'].' '.$user['l_name']); ?></h5>
                <small><?php echo e($user['phone']); ?></small>
            </div>
        </div>
    </div>

    <div class="card-body d-flex flex-column">
        <div class="scroll-down">
            <?php ($count=0); ?>
            <?php ($created_for=0); ?>
            <?php $__empty_1 = true; $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $con): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php if( Carbon\Carbon::parse($con?->created_at)->format('Y-m-d') == now()->format('Y-m-d') && $count == 0): ?>
                        <div class="d-flex justify-content-center"><?php echo e(translate('Today').' '. \App\CentralLogics\Helpers::time_format($con?->created_at)); ?></div>
                        <?php ($count=1); ?>
                    <?php elseif(Carbon\Carbon::parse($con?->created_at)->format('Y-m-d') != $created_for && $count == 0): ?>
                        <div class="d-flex justify-content-center"><?php echo e(\App\CentralLogics\Helpers::time_date_format($con?->created_at)); ?></div>
                        <?php ($count=1); ?>
                        <?php ($created_for=Carbon\Carbon::parse($con?->created_at)->format('Y-m-d')); ?>
                    <?php else: ?>
                        <?php ($count=0); ?>
                    <?php endif; ?>

                <?php if($con->sender_id == $user->id): ?>
                    <div class="py-2 d-flex gap-2 align-items-end">
                        <div class="chat-user-conv-img">
                            <img class="avatar-img onerror-image" width="28" height="28" src="<?php echo e($user['image_full_url']); ?>" data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>" alt="Image Description">
                        </div>

                        <div class="conv-reply-1">
                            <h6 data-toggle="tooltip" data-placement="top" title="<?php echo e(\App\CentralLogics\Helpers::time_date_format($con?->created_at)); ?>"><?php echo e($con->message); ?></h6>
                            <?php if($con->file!=null): ?>
                            <?php $__currentLoopData = $con->file_full_url; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <br>
                                <img class="w-100 mb-3"

                                src="<?php echo e($img); ?>"
                                >
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="py-2">
                        <div class="conv-reply-2">
                            <h6 data-toggle="tooltip" data-placement="top" title="<?php echo e(\App\CentralLogics\Helpers::time_date_format($con?->created_at)); ?>"><?php echo e($con->message); ?></h6>
                            <?php if($con->file!=null): ?>
                            <?php $__currentLoopData = $con->file_full_url; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <br>
                                <img class="w-100 mb-3"

                                src="<?php echo e($img); ?>"
                                >
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                <div class="empty-conversation-content d-flex flex-column align-items-center gap-3">
                    <img width="128" height="128" src="<?php echo e(asset('/public/assets/admin/img/icons/empty-conversation.png')); ?>" alt="public">
                    <h5 class="text-muted">
                        <?php echo e(translate('no_conversation_found')); ?>

                    </h5>
                </div>

            <?php endif; ?>
            <div id="scroll-here"></div>
        </div>
    </div>



    <div class="mt-auto d-flex justify-content-center fs-12 font-medium text-dark p-3">
        <?php echo e(translate('You_can’t_reply_to_this_conversation.')); ?> &nbsp;
        <div class="text-danger d-inline-block learn-more-wrap cursor-pointer">
            <?php echo e(translate('Learn_more')); ?>


            <div class="learn-more-content p-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <img class="rounded-circle" width="20" height="20" src="<?php echo e(asset('public/assets/admin/img/icons/info-icon.png')); ?>" alt="">
                    <h6 class="mb-0"> <?php echo e(translate('Learn_more')); ?></h6>
                </div>
                <p class="mb-0 text-muted text-normal"><?php echo e(translate('You can’t chat with deliveryman because it’s delivery man previous chat history, only you can monitor or view their conversation to avoid unexpected situation.')); ?></p>
            </div>
        </div>
    </div>




</div>
<script>
    "use strict";
    $(document).ready(function () {
        $('.scroll-down').animate({
            scrollTop: $('#scroll-here').offset().top
        },0);
    });
</script>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/delivery-man/partials/_conversations.blade.php ENDPATH**/ ?>