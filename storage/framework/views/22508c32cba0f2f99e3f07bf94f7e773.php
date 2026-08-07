<?php $__env->startSection('title', translate('FCM Settings')); ?>

<?php $__env->startPush('css_or_js'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/firebase.png')); ?>" class="w--26" alt="">
                </span>
                <span><?php echo e(translate('messages.firebase_push_notification_setup')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <?php
        $mod_type = 'rental';
        ?>
        <div class="card">
            <div class="card-header card-header-shadow pb-0">
                <div class="d-flex flex-wrap justify-content-between w-100 row-gap-1">
                    <ul class="nav nav-tabs nav--tabs border-0 gap-2">
                        <li class="nav-item mr-2 mr-md-4">
                            <a href="<?php echo e(route('admin.business-settings.fcm-index')); ?>"
                                class="nav-link pb-2 px-0 pb-sm-3 active" data-slide="1">
                                <img src="<?php echo e(asset('/public/assets/admin/img/notify.png')); ?>" alt="">
                                <span><?php echo e(translate('Push Notification')); ?></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('admin.business-settings.fcm-config')); ?>" class="nav-link pb-2 px-0 pb-sm-3"
                                data-slide="2">
                                <img src="<?php echo e(asset('/public/assets/admin/img/firebase2.png')); ?>" alt="">
                                <span><?php echo e(translate('Firebase Configuration')); ?></span>
                            </a>
                        </li>
                    </ul>
                    <div class="py-1">
                        <div class="tab--content">
                            <div class="item show text--primary-2 d-flex flex-wrap align-items-center" type="button"
                                data-toggle="modal" data-target="#push-notify-modal">
                                <strong class="mr-2"><?php echo e(translate('Read Documentation')); ?></strong>
                                <div class="blinkings">
                                    <i class="tio-info-outined"></i>
                                </div>
                            </div>
                            <div class="item text--primary-2 d-flex flex-wrap align-items-center" type="button"
                                data-toggle="modal" data-target="#firebase-modal">
                                <strong class="mr-2"><?php echo e(translate('Where to get this information')); ?></strong>
                                <div class="blinkings">
                                    <i class="tio-info-outined"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="push-notify">
                        <?php ($language = \App\Models\BusinessSetting::where('key', 'language')->first()); ?>
                        <?php ($language = $language->value ?? null); ?>
                        <?php ($defaultLang = 'en'); ?>
                        <div class="row justify-content-between">
                            <div class="col-sm-auto mb-5">
                                <?php if($language): ?>
                                    <?php ($defaultLang = json_decode($language)[0]); ?>
                                    <ul class="nav nav-tabs border-0">
                                        <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="nav-item">
                                                <a class="nav-link lang_link <?php echo e($lang == $defaultLang ? 'active' : ''); ?>"
                                                    href="#"
                                                    id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                            <div class="col-sm-auto mb-5">
                                <select name="module_type" class="form-control js-select2-custom set-filter"
                                    data-url="<?php echo e(url()->full()); ?>" data-filter="module_type"
                                    title="<?php echo e(translate('messages.select_modules')); ?>">
                                    <?php $__currentLoopData = config('module.module_type'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($module); ?>" <?php echo e($mod_type == $module ? 'selected' : ''); ?>>
                                            <?php echo e(ucfirst(translate($module))); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <small><?php echo e(translate('*Select Module Here')); ?></small>
                            </div>
                        </div>
                        <form action="<?php echo e(route('admin.business-settings.update-fcm-messages-rental')); ?>" method="post">
                            <?php echo csrf_field(); ?>

                            <?php if($language): ?>
                                <?php ($defaultLang = json_decode($language)[0]); ?>
                                <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang_key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="<?php echo e($lang != $defaultLang ? 'd-none' : ''); ?> lang_form"
                                        id="<?php echo e($lang); ?>-form">
                                        <div class="row">
                                            <?php ($trip_pending_messages = \App\Models\NotificationMessage::with('translations')->where('module_type', $mod_type)->where('key', 'trip_pending_message')->first()); ?>
                                            <?php ($data = $trip_pending_messages ? $trip_pending_messages : null); ?>
                                            <?php
                                            if (isset($trip_pending_messages->translations) && count($trip_pending_messages->translations)) {
                                                $translate = [];
                                                foreach ($trip_pending_messages->translations as $t) {
                                                    if ($t->locale == $lang && $t->key == 'trip_pending_message') {
                                                        $translate[$lang]['message'] = $t->value;
                                                    }
                                                }
                                            }
                                            ?>
                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <div class="d-flex flex-wrap justify-content-between mb-2">
                                                        <span class="d-block form-label">
                                                            <?php echo e(translate('messages.trip_pending_messages')); ?>

                                                            (<?php echo e(strtoupper($lang)); ?>)
                                                        </span>
                                                        <?php if($lang == 'en'): ?>
                                                            <label
                                                                class="switch--custom-label toggle-switch d-flex align-items-center"
                                                                for="pending_status">
                                                                <input type="checkbox" data-id="pending_status"
                                                                    data-type="toggle"
                                                                    data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-on.png')); ?>"
                                                                    data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-off.png')); ?>"
                                                                    data-title-on="<?php echo e(translate('By Turning ON Trip')); ?> <strong><?php echo e(translate('pending Message')); ?></strong>"
                                                                    data-title-off="<?php echo e(translate('By Turning OFF Trip')); ?> <strong><?php echo e(translate('pending Message')); ?></strong>"
                                                                    data-text-on="<p><?php echo e(translate('User will get a clear message to know that the Trip is pending.')); ?></p>"
                                                                    data-text-off="<p><?php echo e(translate('User cannot get a clear message to know that the Trip is pending or not.')); ?></p>"
                                                                    class="status toggle-switch-input add-required-attribute  dynamic-checkbox-toggle"
                                                                    name="trip_pending_message_status"
                                                                    data-textarea-name="trip_pending_message" value="1"
                                                                    id="pending_status"
                                                                    <?php echo e($data ? ($data['status'] == 1 ? 'checked' : '') : ''); ?>>
                                                                <span class="toggle-switch-label">
                                                                    <span class="toggle-switch-indicator"></span>
                                                                </span>
                                                            </label>
                                                        <?php endif; ?>
                                                    </div>
                                                    <textarea name="trip_pending_message[]" placeholder="<?php echo e(translate('Write your message')); ?>"
                                                        class="form-control pending_messages"
                                                        <?php if($lang == 'en'): ?> <?php echo e($data ? ($data['status'] == 1 ? 'required' : '') : ''); ?> <?php endif; ?>><?php echo isset($translate) && isset($translate[$lang])
                                                            ? $translate[$lang]['message']
                                                            : ($data
                                                                ? $data['message']
                                                                : ''); ?></textarea>
                                                </div>
                                            </div>

                                            <?php ($trip_confirm_message = \App\Models\NotificationMessage::with('translations')->where('module_type', $mod_type)->where('key', 'trip_confirm_message')->first()); ?>
                                            <?php ($data = $trip_confirm_message ? $trip_confirm_message : ''); ?>
                                            <?php
                                            if (isset($trip_confirm_message->translations) && count($trip_confirm_message->translations)) {
                                                $translate_2 = [];
                                                foreach ($trip_confirm_message->translations as $t) {
                                                    if ($t->locale == $lang && $t->key == 'trip_confirm_message') {
                                                        $translate_2[$lang]['message'] = $t->value;
                                                    }
                                                }
                                            }

                                            ?>
                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <div class="d-flex flex-wrap justify-content-between mb-2">
                                                        <span class="d-block form-label">
                                                            <?php echo e(translate('messages.trip_confirm_message')); ?>

                                                        </span>
                                                        <?php if($lang == 'en'): ?>
                                                            <label
                                                                class="switch--custom-label toggle-switch d-flex align-items-center mb-0"
                                                                for="confirm_status">
                                                                <input type="checkbox" data-id="confirm_status"
                                                                    data-type="toggle"
                                                                    data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-on.png')); ?>"
                                                                    data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-off.png')); ?>"
                                                                    data-title-on="<?php echo e(translate('By Turning ON Trip')); ?> <strong><?php echo e(translate('confirmation Message')); ?></strong>"
                                                                    data-title-off="<?php echo e(translate('By Turning OFF Trip')); ?> <strong><?php echo e(translate('confirmation Message')); ?></strong>"
                                                                    data-text-on="<p><?php echo e(translate('User will get a clear message to know that the trip is confirmed.')); ?></p>"
                                                                    data-text-off="<p><?php echo e(translate('User cannot get a clear message to know that the trip is confirmed or not.')); ?></p>"
                                                                    class="status toggle-switch-input add-required-attribute  dynamic-checkbox-toggle"
                                                                    name="trip_confirm_message_status"
                                                                    data-textarea-name="confirm_message" value="1"
                                                                    id="confirm_status"
                                                                    <?php echo e($data ? ($data['status'] == 1 ? 'checked' : '') : ''); ?>>
                                                                <span class="toggle-switch-label">
                                                                    <span class="toggle-switch-indicator"></span>
                                                                </span>
                                                            </label>
                                                        <?php endif; ?>
                                                    </div>
                                                    <textarea name="trip_confirm_message[]" placeholder="<?php echo e(translate('Write your message')); ?>"
                                                        class="form-control confirm_message"
                                                        <?php if($lang == 'en'): ?> <?php echo e($data ? ($data['status'] == 1 ? 'required' : '') : ''); ?> <?php endif; ?>><?php echo isset($translate_2) && isset($translate_2[$lang])
                                                            ? $translate_2[$lang]['message']
                                                            : ($data
                                                                ? $data['message']
                                                                : ''); ?></textarea>
                                                </div>
                                            </div>

                                                <?php ($trip_ongoing_message = \App\Models\NotificationMessage::with('translations')->where('module_type', $mod_type)->where('key', 'trip_ongoing_message')->first()); ?>

                                                <?php ($data = $trip_ongoing_message ? $trip_ongoing_message : null); ?>

                                                <?php
                                                if (isset($trip_ongoing_message->translations) && count($trip_ongoing_message->translations)) {
                                                    $translate_3 = [];
                                                    foreach ($trip_ongoing_message->translations as $t) {
                                                        if ($t->locale == $lang && $t->key == 'trip_ongoing_message') {
                                                            $translate_3[$lang]['message'] = $t->value;
                                                        }
                                                    }
                                                }

                                                ?>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <div class="d-flex flex-wrap justify-content-between mb-2">
                                                            <span class="d-block form-label">
                                                                <?php echo e(translate('messages.trip_ongoing_message')); ?>

                                                            </span>
                                                            <?php if($lang == 'en'): ?>
                                                                <label
                                                                    class="switch--custom-label toggle-switch d-flex align-items-center mb-0"
                                                                    for="processing_status">
                                                                    <input type="checkbox" data-id="processing_status"
                                                                        data-type="toggle"
                                                                        data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-on.png')); ?>"
                                                                        data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-off.png')); ?>"
                                                                        data-title-on="<?php echo e(translate('By Turning ON Trip')); ?> <strong><?php echo e(translate('Ongoing Message')); ?></strong>"
                                                                        data-title-off="<?php echo e(translate('By Turning OFF Trip')); ?> <strong><?php echo e(translate('Ongoing Message')); ?></strong>"
                                                                        data-text-on="<p><?php echo e(translate('User will get a clear message to know that the trip is Ongoing.')); ?></p>"
                                                                        data-text-off="<p><?php echo e(translate('User cannot get a clear message to know that the trip is Ongoing or not.')); ?></p>"
                                                                        class="status toggle-switch-input add-required-attribute  dynamic-checkbox-toggle"
                                                                        name="trip_ongoing_message_status"
                                                                        data-textarea-name="processing_message"
                                                                        value="1" id="processing_status"
                                                                        <?php echo e($data ? ($data['status'] == 1 ? 'checked' : '') : ''); ?>>
                                                                    <span class="toggle-switch-label">
                                                                        <span class="toggle-switch-indicator"></span>
                                                                    </span>
                                                                </label>
                                                            <?php endif; ?>
                                                        </div>
                                                        <textarea name="trip_ongoing_message[]" placeholder="<?php echo e(translate('Write your message')); ?>"
                                                            class="form-control processing_message"
                                                            <?php if($lang == 'en'): ?> <?php echo e($data ? ($data['status'] == 1 ? 'required' : '') : ''); ?> <?php endif; ?>><?php echo isset($translate_3) && isset($translate_3[$lang])
                                                                ? $translate_3[$lang]['message']
                                                                : ($data
                                                                    ? $data['message']
                                                                    : ''); ?></textarea>
                                                    </div>
                                                </div>

                                                <?php ($trip_complete_message = \App\Models\NotificationMessage::with('translations')->where('module_type', $mod_type)->where('key', 'trip_complete_message')->first()); ?>
                                                <?php ($data = $trip_complete_message ? $trip_complete_message : ''); ?>
                                                <?php
                                                if (isset($trip_complete_message->translations) && count($trip_complete_message->translations)) {
                                                    $translate_4 = [];
                                                    foreach ($trip_complete_message->translations as $t) {
                                                        if ($t->locale == $lang && $t->key == 'trip_complete_message') {
                                                            $translate_4[$lang]['message'] = $t->value;
                                                        }
                                                    }
                                                }

                                                ?>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="form-group">
                                                        <div class="d-flex flex-wrap justify-content-between mb-2">
                                                            <span class="d-block form-label">
                                                                <?php echo e(translate('messages.trip_complete_message')); ?>

                                                            </span>
                                                            <?php if($lang == 'en'): ?>
                                                                <label
                                                                    class="switch--custom-label toggle-switch d-flex align-items-center mb-0"
                                                                    for="trip_complete_message_status">
                                                                    <input type="checkbox"
                                                                        data-id="trip_complete_message_status"
                                                                        data-type="toggle"
                                                                        data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-on.png')); ?>"
                                                                        data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-off.png')); ?>"
                                                                        data-title-on="<?php echo e(translate('By Turning ON Trip')); ?> <strong><?php echo e(translate('Trip complete Message')); ?></strong>"
                                                                        data-title-off="<?php echo e(translate('By Turning OFF Trip')); ?> <strong><?php echo e(translate('Trip complete Message')); ?></strong>"
                                                                        data-text-on="<p><?php echo e(translate('User will get a clear message to know that the trip is completed.')); ?></p>"
                                                                        data-text-off="<p><?php echo e(translate('User cannot get a clear message to know that the trip is completed or not.')); ?></p>"
                                                                        class="status toggle-switch-input add-required-attribute  dynamic-checkbox-toggle"
                                                                        name="trip_complete_message_status"
                                                                        data-textarea-name="trip_complete_message"
                                                                        value="1" id="trip_complete_message_status"
                                                                        <?php echo e($data ? ($data['status'] == 1 ? 'checked' : '') : ''); ?>>
                                                                    <span class="toggle-switch-label">
                                                                        <span class="toggle-switch-indicator"></span>
                                                                    </span>
                                                                </label>
                                                            <?php endif; ?>
                                                        </div>
                                                        <textarea name="trip_complete_message[]" placeholder="<?php echo e(translate('Write your message')); ?>"
                                                            class="form-control trip_complete_message"
                                                            <?php if($lang == 'en'): ?> <?php echo e($data ? ($data['status'] == 1 ? 'required' : '') : ''); ?> <?php endif; ?>><?php echo isset($translate_4) && isset($translate_4[$lang])
                                                                ? $translate_4[$lang]['message']
                                                                : ($data
                                                                    ? $data['message']
                                                                    : ''); ?></textarea>
                                                    </div>
                                                </div>



                                            <?php ($trip_cancel_message = \App\Models\NotificationMessage::with('translations')->where('module_type', $mod_type)->where('key', 'trip_cancel_message')->first()); ?>
                                            <?php ($data = $trip_cancel_message ? $trip_cancel_message : ''); ?>
                                            <?php
                                            if (isset($trip_cancel_message->translations) && count($trip_cancel_message->translations)) {
                                                $translate_5 = [];
                                                foreach ($trip_cancel_message->translations as $t) {
                                                    if ($t->locale == $lang && $t->key == 'trip_cancel_message') {
                                                        $translate_5[$lang]['message'] = $t->value;
                                                    }
                                                }
                                            }

                                            ?>

                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <div class="d-flex flex-wrap justify-content-between mb-2">
                                                        <span class="d-block form-label">
                                                            <?php echo e(translate('messages.trip_cancel_message')); ?>

                                                        </span>
                                                        <?php if($lang == 'en'): ?>
                                                            <label
                                                                class="switch--custom-label toggle-switch d-flex align-items-center mb-0"
                                                                for="out_for_delivery">
                                                                <input type="checkbox" data-id="out_for_delivery"
                                                                    data-type="toggle"
                                                                    data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-on.png')); ?>"
                                                                    data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-off.png')); ?>"
                                                                    data-title-on="<?php echo e(translate('By Turning ON Trip')); ?> <strong><?php echo e(translate('Cancel Message')); ?></strong>"
                                                                    data-title-off="<?php echo e(translate('By Turning OFF Trip')); ?> <strong><?php echo e(translate('Cancel Message')); ?></strong>"
                                                                    data-text-on="<p><?php echo e(translate('User will get a clear message to know that the trip is canceled.')); ?></p>"
                                                                    data-text-off="<p><?php echo e(translate('User cannot get a clear message to know that the trip is canceled or not.')); ?></p>"
                                                                    class="status toggle-switch-input add-required-attribute  dynamic-checkbox-toggle"
                                                                    name="trip_cancel_message_status"
                                                                    data-textarea-name="trip_cancel_message"
                                                                    value="1" id="out_for_delivery"
                                                                    <?php echo e($data ? ($data['status'] == 1 ? 'checked' : '') : ''); ?>>
                                                                <span class="toggle-switch-label">
                                                                    <span class="toggle-switch-indicator"></span>
                                                                </span>
                                                            </label>
                                                        <?php endif; ?>
                                                    </div>
                                                    <textarea name="trip_cancel_message[]" placeholder="<?php echo e(translate('Write your message')); ?>"
                                                        class="form-control trip_cancel_message"
                                                        <?php if($lang == 'en'): ?> <?php echo e($data ? ($data['status'] == 1 ? 'required' : '') : ''); ?> <?php endif; ?>><?php echo isset($translate_5) && isset($translate_5[$lang])
                                                            ? $translate_5[$lang]['message']
                                                            : ($data
                                                                ? $data['message']
                                                                : ''); ?></textarea>
                                                </div>
                                            </div>



                                            <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                            <input type="hidden" name="module_type" value="<?php echo e($mod_type); ?>">
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            <div class="btn--container justify-content-end">
                                <button type="reset" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                                <button type="submit"
                                    class="btn btn--primary"><?php echo e(translate('messages.submit')); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Firebase Modal -->
        <div class="modal fade" id="push-notify-modal">
            <div class="modal-dialog status-warning-modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true" class="tio-clear"></span>
                        </button>
                    </div>
                    <div class="modal-body pb-5 pt-0">
                        <div class="single-item-slider owl-carousel">
                            <div class="item">
                                <div class="mb-20">
                                    <div class="text-center">
                                        <img src="<?php echo e(asset('/public/assets/admin/img/email-templates/3.png')); ?>"
                                            alt="" class="mb-20">
                                        <h5 class="modal-title">
                                            <?php echo e(translate('Write_a_message_in_the_Notification_Body')); ?></h5>
                                    </div>
                                    <p>
                                        <?php echo e(translate('you_can_add_your_message_using_placeholders_to_include_dynamic_content._Here_are_some_examples_of_placeholders_you_can_use:')); ?>

                                    </p>
                                    <ul>
                                        <li>
                                            {userName}: <?php echo e(translate('the_name_of_the_user.')); ?>

                                        </li>
                                        <li>
                                            {storeName}: <?php echo e(translate('the_name_of_the_store.')); ?>

                                        </li>
                                        <li>
                                            {orderId}: <?php echo e(translate('the_order_id.')); ?>

                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="item">
                                <div class="mb-20">
                                    <div class="text-center">
                                        <img src="<?php echo e(asset('/public/assets/admin/img/firebase/slide-4.png')); ?>"
                                            alt="" class="mb-20">
                                        <h5 class="modal-title">
                                            <?php echo e(translate('Please Visit the Docs to Set FCM on Mobile Apps')); ?></h5>
                                    </div>
                                    <div class="text-center">
                                        <p>
                                            <?php echo e(translate('Please check the documentation below for detailed instructions on setting up your mobile app to receive Firebase Cloud Messaging (FCM) notifications.')); ?>

                                        </p>
                                        <a href="https://docs.6amtech.com/docs-six-am-mart/mobile-apps/mandatory-setup"
                                            target="_blank"><?php echo e(translate('Click Here')); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="slide-counter"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/fcm-index-rental.blade.php ENDPATH**/ ?>