

<?php $__empty_1 = true; $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<?php ($user= $conv->sender_type == 'delivery_man' ? $conv->receiver :  $conv->sender); ?>
<?php if(isset($user)): ?>
    <?php ($unchecked=($conv->last_message->sender_id == $user->id) ? $conv->unread_message_count : 0); ?>
    <input type="hidden" id="deliver_man" value="<?php echo e($deliveryMan->id); ?>">
    <div
        class="chat-user-info d-flex p-3 align-items-center customer-list view-conv "
        data-url="<?php echo e(route('admin.users.delivery-man.message-view',['conversation_id'=>$conv->id,'user_id'=>$user->id])); ?>" data-active-id="customer-<?php echo e($user->id); ?>" data-conv-id="<?php echo e($conv->id); ?>" data-sender-id="<?php echo e($user->id); ?>"
        id="customer-<?php echo e($user->id); ?>">
        <div class="chat-user-info-img d-none d-md-block">
            <img class="avatar-img onerror-image"
            src="<?php echo e($user['image_full_url']); ?>"
                    data-onerror-image="<?php echo e(asset('public/assets/admin')); ?>/img/160x160/img1.jpg"
                    alt="Image Description">
        </div>
        <div class="chat-user-info-content">
            <h5 class="mb-0 d-flex justify-content-between">
                <span class=" mr-3"><?php echo e($user['f_name'].' '.$user['l_name']); ?></span>
                <small class="text-muted"><?php echo e($conv?->last_message?->created_at ?  \App\CentralLogics\Helpers::time_date_format($conv?->last_message?->created_at) : ''); ?></small>
            </h5>
            <small class="text-muted mb-1"><?php echo e($user['phone']); ?></small>
            <div class="d-flex justify-content-between gap-1" >

                <div class="text-title fs-12"><?php echo e($conv?->last_message?->message ?? ($conv?->last_message?->file ? translate('files_send') : '' )); ?></div>
                <span class="<?php echo e($unchecked ? 'badge badge-primary' : ''); ?>"><?php echo e($unchecked ? $unchecked : ''); ?></span>
            </div>
        </div>
    </div>
<?php else: ?>
    <div
        class="chat-user-info d-flex border-bottom p-3 align-items-center customer-list">
        <div class="chat-user-info-img d-none d-md-block">
            <img class="avatar-img"
                    src='<?php echo e(asset('public/assets/admin')); ?>/img/160x160/img1.jpg'
                    alt="Image Description">
        </div>
        <div class="chat-user-info-content">
            <h5 class="mb-0 d-flex justify-content-between">
                <span class=" mr-3"><?php echo e(translate('Account not found')); ?></span>
            </h5>
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
<?php /**PATH /var/www/zaqoota/resources/views/admin-views/delivery-man/partials/_conversation_list.blade.php ENDPATH**/ ?>