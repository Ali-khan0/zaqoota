<?php $__env->startSection('title', translate('messages.Notification_Setup')); ?>
<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">

        <!-- Title -->
        <div class="mb-3 d-flex align-items-start gap-2">
            <img src="<?php echo e(asset('/public/assets/admin/img/bell-2.png')); ?>" alt="">
            <div class="w-0 flex-grow mb-2">
                 <h1 class="page-header-title m-0"><?php echo e(translate('Notification_Setup')); ?></h1>
                <?php echo e(translate('From here you setup what types of notification you can receive from')); ?> <?php echo e($business_name); ?>

            </div>
        </div>

        <div class="card">

            <div class="card-body p-0">
                <div class="table-responsive datatable-custom">
                    <table class="font-size-sm table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                        <thead class="thead-light">
                        <tr>
                            <th><?php echo e(translate('sl')); ?></th>
                            <th ><?php echo e(translate('Topics')); ?></th>
                            <th ><?php echo e(translate('Push Notification')); ?></th>
                            <th  ><?php echo e(translate('Mail')); ?></th>
                            <th class="text-center"><?php echo e(translate('SMS')); ?></th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php ($item_admin_data = \App\CentralLogics\Helpers::getNotificationStatusDataAdmin($module_type == 'rental' ? 'provider' : 'store',$item->key)); ?>
                            <tr>
                                <td><?php echo e($key +1); ?></td>
                                <td>
                                    <h5 class="text-capitalize"><?php echo e(translate($item->title)); ?></h5>
                                    <div class="white-space-initial max-w-400px">
                                        <?php echo e(translate($item->sub_title)); ?>

                                    </div>
                                </td>
                                <td>
                                    <?php if($item_admin_data->push_notification_status == 'disable'): ?>
                                        <span class="badge badge-pill badge--info pr-6">  <?php echo e(translate('messages.N/A')); ?></span>
                                    <?php elseif($item_admin_data->push_notification_status == 'inactive'): ?>
                                        <label class="toggle-switch toggle-switch-sm" data-toggle="tooltip" title="<?php echo e(translate('This_notification_turned_off_by_admin.')); ?>">
                                            <input type="checkbox"
                                                    class="status toggle-switch-input dynamic-checkbox"  disabled>
                                            <span class="toggle-switch-label text">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    <?php else: ?>

                                        <label class="toggle-switch toggle-switch-sm" data-toggle="tooltip"  <?php if($item->push_notification_status  == 'active'): ?>
                                            title="<?php echo e(translate('Turn_Off_push_notification_for') .' '.translate($item->title)); ?>"
                                        <?php else: ?>
                                            title="<?php echo e(translate('Turn_On_push_notification_for') .' '.translate($item->title)); ?>"
                                        <?php endif; ?> >
                                            <input type="checkbox"
                                                   id="push_notification_<?php echo e($item->key); ?>"
                                                   data-id="push_notification_<?php echo e($item->key); ?>"
                                                   data-type="toggle" data-image-on="<?php echo e(asset('public/assets/admin/img/modal/mail-success.png')); ?>" data-image-off="<?php echo e(asset('public/assets/admin/img/modal/mail-warning.png')); ?>" data-title-on="<?php echo e(translate('Want to enable the Push Notification For') .' '.  translate($item->title)); ?> ?" data-title-off="<?php echo e(translate('Want to disable the Push Notification For') .' '.  translate($item->title)); ?> ?" data-text-on="<p><?php echo e(translate('Push Notification Will Be Enabled For')  .' '.  translate($item->title)); ?></p>" data-text-off="<p><?php echo e(translate('Push Notification Will Be disabled For')  .' '.  translate($item->title)); ?></p>" class="status toggle-switch-input dynamic-checkbox"  <?php echo e($item->push_notification_status  == 'active' ? 'checked' : ''); ?>>
                                            <span class="toggle-switch-label text">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                        <form action="<?php echo e(route('vendor.business-settings.notification_status_change',['key'=> $item->key  ,'type' => 'push_notification'])); ?>" method="get" id="push_notification_<?php echo e($item->key); ?>_form">
                                        </form>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if($item_admin_data->mail_status == 'disable'): ?>
                                        <span class="badge badge-pill badge--info pr-6">  <?php echo e(translate('messages.N/A')); ?></span>
                                    <?php elseif($item_admin_data->mail_status == 'inactive'): ?>
                                        <label class="toggle-switch toggle-switch-sm" data-toggle="tooltip" title="<?php echo e(translate('This_mail_turned_off_by_admin')); ?>">
                                            <input type="checkbox"
                                                   class="status toggle-switch-input dynamic-checkbox"  disabled>
                                            <span class="toggle-switch-label text">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    <?php else: ?>

                                        <label class="toggle-switch toggle-switch-sm" data-toggle="tooltip"
                                        <?php if($item->mail_status  == 'active'): ?>
                                            data-toggle="tooltip" title="<?php echo e(translate('Turn_Off_Mail_for') .' '.translate($item->title)); ?>"
                                            <?php else: ?>
                                            data-toggle="tooltip" title="<?php echo e(translate('Turn_On_Mail_for') .' '.translate($item->title)); ?>"
                                            <?php endif; ?>>

                                            <input type="checkbox" data-type="toggle"
                                                   id="mail_<?php echo e($item->key); ?>"
                                                   data-id="mail_<?php echo e($item->key); ?>"
                                                   data-image-on="<?php echo e(asset('public/assets/admin/img/modal/mail-success.png')); ?>" data-image-off="<?php echo e(asset('public/assets/admin/img/modal/mail-warning.png')); ?>" data-title-on="<?php echo e(translate('Want to enable the Mail For') .' '.  translate($item->title)); ?> ?" data-title-off="<?php echo e(translate('Want to disable the Mail For') .' '.  translate($item->title)); ?> ?" data-text-on="<p><?php echo e(translate('Mail Will Be Enabled For')  .' '.  translate($item->title)); ?></p>" data-text-off="<p><?php echo e(translate('Mail Will Be disabled For')  .' '.  translate($item->title)); ?></p>" class="status toggle-switch-input dynamic-checkbox" <?php echo e($item->mail_status  == 'active' ? 'checked' : ''); ?>>
                                            <span class="toggle-switch-label text">
                                               <span class="toggle-switch-indicator"></span>
                                           </span>
                                        </label>
                                        <form action="<?php echo e(route('vendor.business-settings.notification_status_change',['key'=> $item->key  ,'type' => 'Mail'])); ?>" method="get" id="mail_<?php echo e($item->key); ?>_form">
                                        </form>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <?php if($item_admin_data->sms_status == 'disable'): ?>
                                        <span class="badge badge-pill badge--info">  <?php echo e(translate('messages.N/A')); ?></span>
                                    <?php elseif($item_admin_data->sms_status == 'inactive'): ?>
                                        <label class="toggle-switch toggle-switch-sm" data-toggle="tooltip" title="<?php echo e(translate('This_sms_turned_off_by_admin')); ?>">
                                            <input type="checkbox"
                                                   class="status toggle-switch-input dynamic-checkbox"  disabled>
                                            <span class="toggle-switch-label text">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    <?php else: ?>

                                        <label class="toggle-switch toggle-switch-sm" data-toggle="tooltip"    <?php if($item->mail_status  == 'active'): ?>
                                            data-toggle="tooltip" title="<?php echo e(translate('Turn_Off_Mail_for') .' '.translate($item->title)); ?>"
                                            <?php else: ?>
                                            data-toggle="tooltip" title="<?php echo e(translate('Turn_On_Mail_for') .' '.translate($item->title)); ?>"
                                            <?php endif; ?>>
                                            <input type="checkbox"
                                                   id="SMS_<?php echo e($item->key); ?>"
                                                   data-id="SMS_<?php echo e($item->key); ?>"
                                                   data-type="toggle" data-image-on="<?php echo e(asset('public/assets/admin/img/modal/mail-success.png')); ?>" data-image-off="<?php echo e(asset('public/assets/admin/img/modal/mail-warning.png')); ?>" data-title-on="<?php echo e(translate('Want to disable the SMS For') .' '.  translate($item->title)); ?> ?" data-title-off="<?php echo e(translate('Want to disable the SMS For') .' '.  translate($item->title)); ?> ?" data-text-on="<p><?php echo e(translate('SMS Will Be Enabled For')  .' '.  translate($item->title)); ?></p>" data-text-off="<p><?php echo e(translate('SMS Will Be disabled For')  .' '.  translate($item->title)); ?></p>" class="status toggle-switch-input dynamic-checkbox" <?php echo e($item->sms_status  == 'active' ? 'checked' : ''); ?>>
                                            <span class="toggle-switch-label text">
                                               <span class="toggle-switch-indicator"></span>
                                           </span>
                                        </label>
                                        <form action="<?php echo e(route('vendor.business-settings.notification_status_change',['key'=> $item->key ,'type' => 'SMS'])); ?>" method="get" id="SMS_<?php echo e($item->key); ?>_form">
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/vendor-views/business-settings/notification-index.blade.php ENDPATH**/ ?>