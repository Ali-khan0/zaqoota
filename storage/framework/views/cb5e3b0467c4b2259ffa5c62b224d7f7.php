
<?php $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php ($user= $conv->sender_type == 'vendor' ? $conv->receiver :  $conv->sender); ?>
<?php if(isset($user ) && $conv->last_message): ?>
    <?php ($unchecked=($conv->last_message->sender_id == $user->id) ? $conv->unread_message_count : 0); ?>
    <div
        class="chat-user-info d-flex border-bottom p-3 align-items-center customer-list <?php echo e($unchecked ? 'conv-active' : ''); ?>"
        onclick="viewConvs('<?php echo e(route('vendor.message.view',['conversation_id'=>$conv->id,'user_id'=>$user->id])); ?>','customer-<?php echo e($user->id); ?>','<?php echo e($conv->id); ?>','<?php echo e($user->id); ?>')"
        id="customer-<?php echo e($user->id); ?>">
        <div class="chat-user-info-img d-none d-md-block">
            <img class="avatar-img onerror-image"
                 data-onerror-image="<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>"
                 src="<?php echo e($user['image_full_url']); ?>"
                    alt="Image Description">
        </div>

        <div class="chat-user-info-content">
            <h5 class="mb-0 d-flex justify-content-between">
                <span class=" mr-3"><?php echo e($user['f_name'].' '.$user['l_name']); ?></span> <span
                    class="<?php echo e($unchecked ? 'badge badge-info' : ''); ?>"><?php echo e($unchecked ? $unchecked : ''); ?></span>
                    <small><?php echo e(date(config('timeformat'),strtotime($conv->last_message->created_at))); ?></small>
            </h5>
            <small><?php echo e($user['phone']); ?></small>
            <div class="text-title"><?php echo e(Str::limit($conv->last_message->message ??'', 35, '...')); ?></div>
        </div>
    </div>
<?php else: ?>
    <div
        class="chat-user-info d-flex border-bottom p-3 align-items-center customer-list">
        <div class="chat-user-info-img d-none d-md-block">
            <img class="avatar-img"
                    src='<?php echo e(asset('public/assets/admin/img/160x160/img1.jpg')); ?>'
                    alt="Image Description">
        </div>
        <div class="chat-user-info-content">
            <h5 class="mb-0 d-flex justify-content-between">
                <span class=" mr-3"><?php echo e(translate('messages.user_not_found')); ?></span>
            </h5>
        </div>
    </div>
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/common.js"></script><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/messages/data.blade.php ENDPATH**/ ?>