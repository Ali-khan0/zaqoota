<?php $__env->startSection('title',translate('FCM Settings')); ?>

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
        $mod_type = 'grocery';
        if(request('module_type')){
            $mod_type = request('module_type');
        }
        ?>
        <div class="card">
            <div class="card-header card-header-shadow pb-0">
                <div class="d-flex flex-wrap justify-content-between w-100 row-gap-1">
                    <ul class="nav nav-tabs nav--tabs border-0 gap-2">
                        <li class="nav-item mr-2 mr-md-4">
                            <a href="<?php echo e(route('admin.business-settings.fcm-index')); ?>" class="nav-link pb-2 px-0 pb-sm-3 active" data-slide="1">
                                <img src="<?php echo e(asset('/public/assets/admin/img/notify.png')); ?>" alt="">
                                <span><?php echo e(translate('Push Notification')); ?></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('admin.business-settings.fcm-config')); ?>" class="nav-link pb-2 px-0 pb-sm-3" data-slide="2">
                                <img src="<?php echo e(asset('/public/assets/admin/img/firebase2.png')); ?>" alt="">
                                <span><?php echo e(translate('Firebase Configuration')); ?></span>
                            </a>
                        </li>
                    </ul>
                    <div class="py-1">
                        <div class="tab--content">
                            <div class="item show text--primary-2 d-flex flex-wrap align-items-center" type="button" data-toggle="modal" data-target="#push-notify-modal">
                                <strong class="mr-2"><?php echo e(translate('Read Documentation')); ?></strong>
                                <div class="blinkings">
                                    <i class="tio-info-outined"></i>
                                </div>
                            </div>
                            <div class="item text--primary-2 d-flex flex-wrap align-items-center" type="button" data-toggle="modal" data-target="#firebase-modal">
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
                        <?php ($language=\App\Models\BusinessSetting::where('key','language')->first()); ?>
                        <?php ($language = $language->value ?? null); ?>
                        <?php ($defaultLang = 'en'); ?>
                        <div class="row justify-content-between">
                            <div class="col-sm-auto mb-5">
                                <?php if($language): ?>
                                    <?php ($defaultLang = json_decode($language)[0]); ?>
                                    <ul class="nav nav-tabs border-0">
                                        <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="nav-item">
                                                <a class="nav-link lang_link <?php echo e($lang == $defaultLang? 'active':''); ?>" href="#" id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang).'('.strtoupper($lang).')'); ?></a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                            <div class="col-sm-auto mb-5">
                                <select name="module_type" class="form-control js-select2-custom set-filter"
                                data-url="<?php echo e(url()->full()); ?>"
                                data-filter="module_type"
                                title="<?php echo e(translate('messages.select_modules')); ?>">
                                    <?php $__currentLoopData = config('module.module_type'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option
                                            value="<?php echo e($module); ?>" <?php echo e($mod_type == $module?'selected':''); ?>>
                                            <?php echo e(ucfirst(translate($module))); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <small><?php echo e(translate('*Select Module Here')); ?></small>
                            </div>
                        </div>
                        <form action="<?php echo e(route('admin.business-settings.update-fcm-messages')); ?>" method="post"
                                enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>

                            <?php if($language): ?>
                            <?php ($defaultLang = json_decode($language)[0]); ?>
                            <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang_key => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <div class="<?php echo e($lang != $defaultLang ? 'd-none':''); ?> lang_form" id="<?php echo e($lang); ?>-form">
                                    <div class="row">
                                        <?php ($opm=\App\Models\NotificationMessage::with('translations')->where('module_type',$mod_type)->where('key','order_pending_message')->first()); ?>
                                        <?php ($data=$opm?$opm:null); ?>
                                        <?php
                                                if(isset($opm->translations) && count($opm->translations)){
                                                    $translate = [];
                                                    foreach($opm->translations as $t)
                                                    {
                                                        if($t->locale == $lang && $t->key=='order_pending_message'){
                                                            $translate[$lang]['message'] = $t->value;
                                                        }
                                                    }

                                                }
                                                ?>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <div class="d-flex flex-wrap justify-content-between mb-2">
                                                    <span class="d-block form-label">
                                                        <?php echo e(translate('messages.order_pending_message')); ?> (<?php echo e(strtoupper($lang)); ?>)
                                                    </span>
                                                <?php if($lang == 'en'): ?>
                                                        <label class="switch--custom-label toggle-switch d-flex align-items-center"
                                                            for="pending_status">
                                                            <input type="checkbox"
                                                                   data-id="pending_status"
                                                                   data-type="toggle"
                                                                   data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-on.png')); ?>"
                                                                   data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-off.png')); ?>"
                                                                   data-title-on="<?php echo e(translate('By Turning ON Order')); ?> <strong><?php echo e(translate('pending Message')); ?></strong>"
                                                                   data-title-off="<?php echo e(translate('By Turning OFF Order')); ?> <strong><?php echo e(translate('pending Message')); ?></strong>"
                                                                   data-text-on="<p><?php echo e(translate('User will get a clear message to know that the order is pending.')); ?></p>"
                                                                   data-text-off="<p><?php echo e(translate('User cannot get a clear message to know that the order is pending or not.')); ?></p>"
                                                                   class="status toggle-switch-input add-required-attribute  dynamic-checkbox-toggle"
                                                                   name="pending_status"

                                                                   data-textarea-name="pending_messages"
                                                                value="1" id="pending_status" <?php echo e($data?($data['status']==1?'checked':''):''); ?>>
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                            </span>
                                                        </label>

                                                <?php endif; ?>
                                                </div>
                                                <textarea name="pending_message[]" placeholder="<?php echo e(translate('Write your message')); ?>" class="form-control pending_messages"
                                                <?php if($lang == 'en'): ?>
                                                <?php echo e($data?($data['status']==1?'required':''):''); ?>

                                                <?php endif; ?>
                                                ><?php echo (isset($translate) && isset($translate[$lang]))?$translate[$lang]['message']:($data?$data['message']:''); ?></textarea>
                                            </div>
                                        </div>

                                        <?php ($ocm=\App\Models\NotificationMessage::with('translations')->where('module_type',$mod_type)->where('key','order_confirmation_msg')->first()); ?>
                                        <?php ($data=$ocm?$ocm:''); ?>
                                        <?php
                                        if(isset($ocm->translations)&&count($ocm->translations)){
                                                $translate_2 = [];
                                                foreach($ocm->translations as $t)
                                                {
                                                    if($t->locale == $lang && $t->key=='order_confirmation_msg'){
                                                        $translate_2[$lang]['message'] = $t->value;
                                                    }
                                                }

                                            }

                                        ?>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <div class="d-flex flex-wrap justify-content-between mb-2">
                                                    <span class="d-block form-label">
                                                        <?php echo e(translate('messages.order_confirmation_message')); ?>

                                                    </span>
                                                    <?php if($lang == 'en'): ?>
                                                        <label class="switch--custom-label toggle-switch d-flex align-items-center mb-0"
                                                            for="confirm_status">
                                                            <input type="checkbox"
                                                                   data-id="confirm_status"
                                                                   data-type="toggle"
                                                                   data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-on.png')); ?>"
                                                                   data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-off.png')); ?>"
                                                                   data-title-on="<?php echo e(translate('By Turning ON Order')); ?> <strong><?php echo e(translate('confirmation Message')); ?></strong>"
                                                                   data-title-off="<?php echo e(translate('By Turning OFF Order')); ?> <strong><?php echo e(translate('confirmation Message')); ?></strong>"
                                                                   data-text-on="<p><?php echo e(translate('User will get a clear message to know that the order is confirmed.')); ?></p>"
                                                                   data-text-off="<p><?php echo e(translate('User cannot get a clear message to know that the order is confirmed or not.')); ?></p>"
                                                                   class="status toggle-switch-input add-required-attribute  dynamic-checkbox-toggle"
                                                                   name="confirm_status"
                                                                   data-textarea-name="confirm_message"

                                                                value="1" id="confirm_status" <?php echo e($data?($data['status']==1?'checked':''):''); ?>>
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                            </span>
                                                        </label>

                                                    <?php endif; ?>
                                                </div>
                                                <textarea name="confirm_message[]"  placeholder="<?php echo e(translate('Write your message')); ?>" class="form-control confirm_message"
                                                <?php if($lang == 'en'): ?>
                                                <?php echo e($data?($data['status']==1?'required':''):''); ?>

                                                <?php endif; ?> ><?php echo (isset($translate_2) && isset($translate_2[$lang]))?$translate_2[$lang]['message']:($data?$data['message']:''); ?></textarea>
                                            </div>
                                        </div>
                                        <?php if($mod_type != 'parcel'): ?>


                                        <?php ($oprm=\App\Models\NotificationMessage::with('translations')->where('module_type',$mod_type)->where('key','order_processing_message')->first()); ?>

                                        <?php ($data=$oprm?$oprm:null); ?>

                                        <?php
                                        if(isset($oprm->translations) && count($oprm->translations)){
                                                $translate_3 = [];
                                                foreach($oprm->translations as $t)
                                                {
                                                    if($t->locale == $lang && $t->key=='order_processing_message'){
                                                        $translate_3[$lang]['message'] = $t->value;
                                                    }
                                                }

                                            }

                                        ?>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <div class="d-flex flex-wrap justify-content-between mb-2">
                                                    <span class="d-block form-label">
                                                        <?php echo e(translate('messages.order_processing_message')); ?>

                                                    </span>
                                                    <?php if($lang == 'en'): ?>
                                                        <label class="switch--custom-label toggle-switch d-flex align-items-center mb-0" for="processing_status">
                                                            <input type="checkbox"
                                                                   data-id="processing_status"
                                                                   data-type="toggle"
                                                                   data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-on.png')); ?>"
                                                                   data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-off.png')); ?>"
                                                                   data-title-on="<?php echo e(translate('By Turning ON Order')); ?> <strong><?php echo e(translate('processing Message')); ?></strong>"
                                                                   data-title-off="<?php echo e(translate('By Turning OFF Order')); ?> <strong><?php echo e(translate('processing Message')); ?></strong>"
                                                                   data-text-on="<p><?php echo e(translate('User will get a clear message to know that the order is processing.')); ?></p>"
                                                                   data-text-off="<p><?php echo e(translate('User cannot get a clear message to know that the order is processing or not.')); ?></p>"
                                                                   class="status toggle-switch-input add-required-attribute  dynamic-checkbox-toggle"
                                                                   name="processing_status"
                                                                   data-textarea-name="processing_message"
                                                                   value="1" id="processing_status" <?php echo e($data?($data['status']==1?'checked':''):''); ?>>
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                            </span>
                                                        </label>

                                                    <?php endif; ?>
                                                </div>
                                                <textarea name="processing_message[]"  placeholder="<?php echo e(translate('Write your message')); ?>" class="form-control processing_message"                                           <?php if($lang == 'en'): ?>
                                                <?php echo e($data?($data['status']==1?'required':''):''); ?>

                                                <?php endif; ?>
                                                ><?php echo (isset($translate_3) && isset($translate_3[$lang]))?$translate_3[$lang]['message']:($data?$data['message']:''); ?></textarea>
                                            </div>
                                        </div>

                                        <?php ($dbs=\App\Models\NotificationMessage::with('translations')->where('module_type',$mod_type)->where('key','order_handover_message')->first()); ?>
                                        <?php ($data=$dbs?$dbs:''); ?>
                                        <?php
                                        if(isset($dbs->translations) && count($dbs->translations)){
                                                $translate_4 = [];
                                                foreach($dbs->translations as $t)
                                                {
                                                    if($t->locale == $lang && $t->key=='order_handover_message'){
                                                        $translate_4[$lang]['message'] = $t->value;
                                                    }
                                                }

                                            }

                                        ?>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <div class="d-flex flex-wrap justify-content-between mb-2">
                                                    <span class="d-block form-label">
                                                        <?php echo e(translate('messages.order_Handover_message')); ?>

                                                    </span>
                                                    <?php if($lang == 'en'): ?>
                                                        <label class="switch--custom-label toggle-switch d-flex align-items-center mb-0"
                                                                for="order_handover_message_status">
                                                            <input type="checkbox"
                                                                   data-id="order_handover_message_status"
                                                                   data-type="toggle"
                                                                   data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-on.png')); ?>"
                                                                   data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-off.png')); ?>"
                                                                   data-title-on="<?php echo e(translate('By Turning ON Order')); ?> <strong><?php echo e(translate('Order Handover Message')); ?></strong>"
                                                                   data-title-off="<?php echo e(translate('By Turning OFF Order')); ?> <strong><?php echo e(translate('Order Handover Message')); ?></strong>"
                                                                   data-text-on="<p><?php echo e(translate('User will get a clear message to know that the order is handovered.')); ?></p>"
                                                                   data-text-off="<p><?php echo e(translate('User cannot get a clear message to know that the order is handovered or not.')); ?></p>"
                                                                   class="status toggle-switch-input add-required-attribute  dynamic-checkbox-toggle"

                                                                   name="order_handover_message_status"
                                                                   data-textarea-name="order_handover_message"
                                                                   value="1"
                                                                    id="order_handover_message_status" <?php echo e($data?($data['status']==1?'checked':''):''); ?>>
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                            </span>
                                                        </label>

                                                    <?php endif; ?>
                                                </div>
                                                <textarea name="order_handover_message[]"  placeholder="<?php echo e(translate('Write your message')); ?>" class="form-control order_handover_message"                                           <?php if($lang == 'en'): ?>
                                                <?php echo e($data?($data['status']==1?'required':''):''); ?>

                                                <?php endif; ?>
                                                ><?php echo (isset($translate_4) && isset($translate_4[$lang]))?$translate_4[$lang]['message']:($data?$data['message']:''); ?></textarea>
                                            </div>
                                        </div>
                                        <?php endif; ?>


                                        <?php ($ofdm=\App\Models\NotificationMessage::with('translations')->where('module_type',$mod_type)->where('key','out_for_delivery_message')->first()); ?>
                                        <?php ($data=$ofdm?$ofdm:''); ?>
                                        <?php
                                        if(isset($ofdm->translations) && count($ofdm->translations)){
                                                $translate_5 = [];
                                                foreach($ofdm->translations as $t)
                                                {
                                                    if($t->locale == $lang && $t->key=='out_for_delivery_message'){
                                                        $translate_5[$lang]['message'] = $t->value;
                                                    }
                                                }

                                            }

                                        ?>

                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <div class="d-flex flex-wrap justify-content-between mb-2">
                                                    <span class="d-block form-label">
                                                        <?php echo e(translate('messages.order_out_for_delivery_message')); ?>

                                                    </span>
                                                    <?php if($lang == 'en'): ?>
                                                        <label class="switch--custom-label toggle-switch d-flex align-items-center mb-0"
                                                                for="out_for_delivery">
                                                            <input type="checkbox"
                                                                   data-id="out_for_delivery"
                                                                   data-type="toggle"
                                                                   data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-on.png')); ?>"
                                                                   data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-off.png')); ?>"
                                                                   data-title-on="<?php echo e(translate('By Turning ON Order')); ?> <strong><?php echo e(translate('Out For Delivery Message')); ?></strong>"
                                                                   data-title-off="<?php echo e(translate('By Turning OFF Order')); ?> <strong><?php echo e(translate('Out For Delivery Message')); ?></strong>"
                                                                   data-text-on="<p><?php echo e(translate('User will get a clear message to know that the order is out for delivery.')); ?></p>"
                                                                   data-text-off="<p><?php echo e(translate('User cannot get a clear message to know that the order is out for delivery or not.')); ?></p>"
                                                                   class="status toggle-switch-input add-required-attribute  dynamic-checkbox-toggle"
                                                                   name="out_for_delivery_status"
                                                                   data-textarea-name="out_for_delivery_message"
                                                                    value="1" id="out_for_delivery" <?php echo e($data?($data['status']==1?'checked':''):''); ?>>
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                                </span>
                                                        </label>
                                                    <?php endif; ?>
                                                </div>
                                                <textarea name="out_for_delivery_message[]"  placeholder="<?php echo e(translate('Write your message')); ?>" class="form-control out_for_delivery_message"                                           <?php if($lang == 'en'): ?>
                                                <?php echo e($data?($data['status']==1?'required':''):''); ?>

                                                <?php endif; ?>
                                                ><?php echo (isset($translate_5) && isset($translate_5[$lang]))?$translate_5[$lang]['message']:($data?$data['message']:''); ?></textarea>
                                            </div>
                                        </div>

                                        <?php ($odm=\App\Models\NotificationMessage::with('translations')->where('module_type',$mod_type)->where('key','order_delivered_message')->first()); ?>
                                        <?php ($data=$odm?$odm:''); ?>
                                        <?php
                                        if(isset($odm->translations)&&count($odm->translations)){
                                                $translate_6 = [];
                                                foreach($odm->translations as $t)
                                                {
                                                    if($t->locale == $lang && $t->key=='order_delivered_message'){
                                                        $translate_6[$lang]['message'] = $t->value;
                                                    }
                                                }

                                            }

                                        ?>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <div class="d-flex flex-wrap justify-content-between mb-2">
                                                    <span class="d-block form-label">
                                                        <?php echo e(translate('messages.order_delivered_message')); ?>

                                                    </span>
                                                    <?php if($lang == 'en'): ?>
                                                        <label class="switch--custom-label toggle-switch d-flex align-items-center mb-0"
                                                                for="delivered_status">
                                                            <input type="checkbox"
                                                                   data-id="delivered_status"
                                                                   data-type="toggle"
                                                                   data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-on.png')); ?>"
                                                                   data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-off.png')); ?>"
                                                                   data-title-on="<?php echo e(translate('By Turning ON Order')); ?> <strong><?php echo e(translate('delivered Message')); ?></strong>"
                                                                   data-title-off="<?php echo e(translate('By Turning OFF Order')); ?> <strong><?php echo e(translate('delivered Message')); ?></strong>"
                                                                   data-text-on="<p><?php echo e(translate('User will get a clear message to know that the order is delivered.')); ?></p>"
                                                                   data-text-off="<p><?php echo e(translate('User cannot get a clear message to know that the order is delivered or not.')); ?></p>"
                                                                   class="status toggle-switch-input add-required-attribute  dynamic-checkbox-toggle"
                                                                   name="delivered_status"
                                                                   data-textarea-name="delivered_message"
                                                                    value="1" id="delivered_status" <?php echo e($data?($data['status']==1?'checked':''):''); ?>>
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                                </span>
                                                        </label>

                                                    <?php endif; ?>
                                                </div>
                                                <textarea name="delivered_message[]"  placeholder="<?php echo e(translate('Write your message')); ?>" class="form-control delivered_message"                                           <?php if($lang == 'en'): ?>
                                                <?php echo e($data?($data['status']==1?'required':''):''); ?>

                                                <?php endif; ?>
                                                ><?php echo (isset($translate_6) && isset($translate_6[$lang]))?$translate_6[$lang]['message']:($data?$data['message']:''); ?></textarea>
                                            </div>
                                        </div>

                                        <?php ($dba=\App\Models\NotificationMessage::with('translations')->where('module_type',$mod_type)->where('key','delivery_boy_assign_message')->first()); ?>
                                        <?php ($data=$dba?$dba:''); ?>
                                        <?php
                                        if(isset($dba->translations) && count($dba->translations)){
                                                $translate_7 = [];
                                                foreach($dba->translations as $t)
                                                {
                                                    if($t->locale == $lang && $t->key=='delivery_boy_assign_message'){
                                                        $translate_7[$lang]['message'] = $t->value;
                                                    }
                                                }

                                            }

                                        ?>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <div class="d-flex flex-wrap justify-content-between mb-2">
                                                    <span class="d-block form-label">
                                                        <?php echo e(translate('messages.deliveryman_assign_message')); ?>

                                                    </span>
                                                    <?php if($lang == 'en'): ?>
                                                        <label class="switch--custom-label toggle-switch d-flex align-items-center mb-0"
                                                            for="delivery_boy_assign">
                                                            <input type="checkbox"
                                                                   data-id="delivery_boy_assign"
                                                                   data-type="toggle"
                                                                   data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-on.png')); ?>"
                                                                   data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-off.png')); ?>"
                                                                   data-title-on="<?php echo e(translate('By Turning ON Order')); ?> <strong><?php echo e(translate('Delivery Man Assigned Message')); ?></strong>"
                                                                   data-title-off="<?php echo e(translate('By Turning OFF Order')); ?> <strong><?php echo e(translate('Delivery Man Assigned Message')); ?></strong>"
                                                                   data-text-on="<p><?php echo e(translate('User will get a clear message to know that the order is assigned to a delivery man.')); ?></p>"
                                                                   data-text-off="<p><?php echo e(translate('User cannot get a clear message to know that the order is assigned to a delivery man or not.')); ?></p>"
                                                                   class="status toggle-switch-input add-required-attribute  dynamic-checkbox-toggle"
                                                                   data-textarea-name="delivery_boy_assign_message"
                                                                   name="delivery_boy_assign_status"
                                                                value="1"
                                                                id="delivery_boy_assign" <?php echo e($data?($data['status']==1?'checked':''):''); ?>>
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                            </span>
                                                        </label>

                                                    <?php endif; ?>
                                                </div>
                                                <textarea name="delivery_boy_assign_message[]"  placeholder="<?php echo e(translate('Write your message')); ?>" class="form-control delivery_boy_assign_message"                                           <?php if($lang == 'en'): ?>
                                                <?php echo e($data?($data['status']==1?'required':''):''); ?>

                                                <?php endif; ?>
                                                ><?php echo (isset($translate_7) && isset($translate_7[$lang]))?$translate_7[$lang]['message']:($data?$data['message']:''); ?></textarea>
                                            </div>
                                        </div>

                                        <?php ($dbc=\App\Models\NotificationMessage::with('translations')->where('module_type',$mod_type)->where('key','delivery_boy_delivered_message')->first()); ?>

                                        <?php ($data=$dbc?$dbc:''); ?>
                                        <?php
                                        if(isset($dbc->translations) && count($dbc->translations)){
                                                $translate_8 = [];
                                                foreach($dbc->translations as $t)
                                                {
                                                    if($t->locale == $lang && $t->key=='delivery_boy_delivered_message'){
                                                        $translate_8[$lang]['message'] = $t->value;
                                                    }
                                                }

                                            }

                                        ?>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <div class="d-flex flex-wrap justify-content-between mb-2">
                                                    <span class="d-block form-label">
                                                        <?php echo e(translate('messages.deliveryman_delivered_message')); ?>

                                                    </span>
                                                    <?php if($lang == 'en'): ?>
                                                        <label class="switch--custom-label toggle-switch d-flex align-items-center mb-0"
                                                                for="delivery_boy_delivered">
                                                            <input type="checkbox"
                                                                   data-id="delivery_boy_delivered"
                                                                   data-type="toggle"
                                                                   data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-on.png')); ?>"
                                                                   data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-off.png')); ?>"
                                                                   data-title-on="<?php echo e(translate('By Turning ON Order')); ?> <strong><?php echo e(translate('Delivery Man Delivered Message')); ?></strong>"
                                                                   data-title-off="<?php echo e(translate('By Turning OFF Order')); ?> <strong><?php echo e(translate('Delivery Man Delivered Message')); ?></strong>"
                                                                   data-text-on="<p><?php echo e(translate('User will get a clear message to know that the order is delivered by a delivery man.')); ?></p>"
                                                                   data-text-off="<p><?php echo e(translate('User cannot get a clear message to know that the order is delivered by a delivery man or not.')); ?></p>"
                                                                   class="status toggle-switch-input add-required-attribute  dynamic-checkbox-toggle"
                                                                   name="delivery_boy_delivered_status"
                                                                   data-textarea-name="delivery_boy_delivered_message"
                                                                    value="1"
                                                                    id="delivery_boy_delivered" <?php echo e($data?($data['status']==1?'checked':''):''); ?>>
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                                </span>
                                                        </label>

                                                    <?php endif; ?>
                                                </div>

                                                <textarea name="delivery_boy_delivered_message[]"  placeholder="<?php echo e(translate('Write your message')); ?>" class="form-control delivery_boy_delivered_message"                                           <?php if($lang == 'en'): ?>
                                                <?php echo e($data?($data['status']==1?'required':''):''); ?>

                                                <?php endif; ?>
                                                ><?php echo (isset($translate_8) && isset($translate_8[$lang]))?$translate_8[$lang]['message']:($data?$data['message']:''); ?></textarea>
                                            </div>
                                        </div>

                                        <?php ($ocm=\App\Models\NotificationMessage::with('translations')->where('module_type',$mod_type)->where('key','order_cancled_message')->first()); ?>
                                        <?php ($data=$ocm?$ocm:''); ?>
                                        <?php
                                        if(isset($ocm->translations) && count($ocm->translations)){

                                                $translate_9 = [];
                                                foreach($ocm->translations as $t)
                                                {
                                                    if($t->locale == $lang && $t->key=='order_cancled_message'){
                                                        $translate_9[$lang]['message'] = $t->value;
                                                    }
                                                }

                                            }

                                        ?>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <div class="d-flex flex-wrap justify-content-between mb-2">
                                                    <span class="d-block form-label">
                                                        <?php echo e(translate('messages.order_canceled_message')); ?>

                                                    </span>
                                                    <?php if($lang == 'en'): ?>
                                                        <label class="switch--custom-label toggle-switch d-flex align-items-center mb-0"
                                                                for="order_cancled_message">
                                                            <input type="checkbox"
                                                                   name="order_cancled_message_status"
                                                                   data-id="order_cancled_message"
                                                                   data-type="toggle"
                                                                   data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-on.png')); ?>"
                                                                   data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-off.png')); ?>"
                                                                   data-title-on="<?php echo e(translate('By Turning ON Order')); ?> <strong><?php echo e(translate('canceled Message')); ?></strong>"
                                                                   data-title-off="<?php echo e(translate('By Turning OFF Order')); ?> <strong><?php echo e(translate('canceled Message')); ?></strong>"
                                                                   data-text-on="<p><?php echo e(translate('User will get a clear message to know that the order is canceled.')); ?></p>"
                                                                   data-text-off="<p><?php echo e(translate('User cannot get a clear message to know that the order is canceled or not.')); ?></p>"
                                                                   class="status toggle-switch-input add-required-attribute  dynamic-checkbox-toggle"
                                                                   data-textarea-name="order_cancled_message"
                                                                    value="1"
                                                                    id="order_cancled_message" <?php echo e($data?($data['status']==1?'checked':''):''); ?>>
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                                </span>
                                                        </label>

                                                    <?php endif; ?>
                                                </div>

                                                <textarea name="order_cancled_message[]"  placeholder="<?php echo e(translate('Write your message')); ?>" class="form-control order_cancled_message"                                           <?php if($lang == 'en'): ?>
                                                <?php echo e($data?($data['status']==1?'required':''):''); ?>

                                                <?php endif; ?>
                                                ><?php echo (isset($translate_9) && isset($translate_9[$lang]))?$translate_9[$lang]['message']:($data?$data['message']:''); ?></textarea>
                                            </div>
                                        </div>
                                        <?php if($mod_type != 'parcel'): ?>
                                            <?php ($orm=\App\Models\NotificationMessage::with('translations')->where('module_type',$mod_type)->where('key','order_refunded_message')->first()); ?>
                                            <?php ($data=$orm?$orm:''); ?>
                                            <?php
                                            if(isset($orm->translations)&&count($orm->translations)){
                                                    $translate_10 = [];
                                                    foreach($orm->translations as $t)
                                                    {
                                                        if($t->locale == $lang && $t->key=='order_refunded_message'){
                                                            $translate_10[$lang]['message'] = $t->value;
                                                        }
                                                    }

                                                }

                                            ?>
                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <div class="d-flex flex-wrap justify-content-between mb-2">
                                                        <span class="d-block form-label">
                                                            <?php echo e(translate('messages.order_refunded_message')); ?>

                                                        </span>
                                                        <?php if($lang == 'en'): ?>
                                                            <label class="switch--custom-label toggle-switch d-flex align-items-center mb-0"
                                                            for="order_refunded_message">
                                                                <input type="checkbox"
                                                                       data-id="order_refunded_message"
                                                                       data-type="toggle"
                                                                       data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-on.png')); ?>"
                                                                       data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-off.png')); ?>"
                                                                       data-title-on="<?php echo e(translate('By Turning ON Order')); ?> <strong><?php echo e(translate('Order Refund Message')); ?></strong>"
                                                                       data-title-off="<?php echo e(translate('By Turning OFF Order')); ?> <strong><?php echo e(translate('Order Refund Message')); ?></strong>"
                                                                       data-text-on="<p><?php echo e(translate('User will get a clear message to know that the order is refunded.')); ?></p>"
                                                                       data-text-off="<p><?php echo e(translate('User cannot get a clear message to know that the order is refunded or not.')); ?></p>"
                                                                       class="status toggle-switch-input add-required-attribute  dynamic-checkbox-toggle"
                                                                       name="order_refunded_message_status"
                                                                       data-textarea-name="order_refunded_message"
                                                                       value="1"
                                                                        id="order_refunded_message" <?php echo e($data?($data['status']==1?'checked':''):''); ?>>
                                                                <span class="toggle-switch-label">
                                                                    <span class="toggle-switch-indicator"></span>
                                                                    </span>
                                                            </label>
                                                        <?php endif; ?>
                                                    </div>

                                                    <textarea name="order_refunded_message[]"  placeholder="<?php echo e(translate('Write your message')); ?>" class="form-control order_refunded_message"                                           <?php if($lang == 'en'): ?>
                                                    <?php echo e($data?($data['status']==1?'required':''):''); ?>

                                                    <?php endif; ?>
                                                    ><?php echo (isset($translate_10) && isset($translate_10[$lang]))?$translate_10[$lang]['message']:($data?$data['message']:''); ?></textarea>
                                                </div>
                                            </div>

                                            <?php ($rrcm=\App\Models\NotificationMessage::with('translations')->where('module_type',$mod_type)->where('key','refund_request_canceled')->first()); ?>
                                            <?php ($data=$rrcm?$rrcm:''); ?>
                                            <?php
                                            if(isset($rrcm->translations) && count($rrcm->translations)){
                                                    $translate_11 = [];
                                                    foreach($rrcm->translations as $t)
                                                    {
                                                        if($t->locale == $lang && $t->key=='refund_request_canceled'){
                                                            $translate_11[$lang]['message'] = $t->value;
                                                        }
                                                    }
                                                }

                                            ?>
                                            <div class="col-md-6 col-lg-4">
                                                <div class="form-group">
                                                    <div class="d-flex flex-wrap justify-content-between mb-2">
                                                        <span class="d-block form-label">
                                                            <?php echo e(translate('messages.refund_request_canceled_message')); ?>

                                                        </span>
                                                        <?php if($lang == 'en'): ?>
                                                            <label class="switch--custom-label toggle-switch d-flex align-items-center mb-0"
                                                            for="refund_request_canceled">
                                                                <input type="checkbox"
                                                                       data-id="refund_request_canceled"
                                                                       data-type="toggle"
                                                                       data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-on.png')); ?>"
                                                                       data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-off.png')); ?>"
                                                                       data-title-on="<?php echo e(translate('By Turning ON Order')); ?> <strong><?php echo e(translate('Refund Request Cancel Message')); ?></strong>"
                                                                       data-title-off="<?php echo e(translate('By Turning OFF Order')); ?> <strong><?php echo e(translate('Refund Request Cancel Message')); ?></strong>"
                                                                       data-text-on="<p><?php echo e(translate('User will get a clear message to know that the order\'s refund request is canceled.')); ?></p>"
                                                                       data-text-off="<p><?php echo e(translate('User cannot get a clear message to know that the order\'s refund request is canceled or not.')); ?></p>"
                                                                       class="status toggle-switch-input add-required-attribute  dynamic-checkbox-toggle"

                                                                       name="refund_request_canceled_status"

                                                                       data-textarea-name="refund_request_canceled"
                                                                        value="1"
                                                                        id="refund_request_canceled" <?php echo e($data?($data['status']==1?'checked':''):''); ?>>
                                                                <span class="toggle-switch-label">
                                                                    <span class="toggle-switch-indicator"></span>
                                                                    </span>
                                                            </label>
                                                        <?php endif; ?>
                                                    </div>
                                                    <textarea name="refund_request_canceled[]"  placeholder="<?php echo e(translate('Write your message')); ?>" class="form-control refund_request_canceled"                                           <?php if($lang == 'en'): ?>
                                                    <?php echo e($data?($data['status']==1?'required':''):''); ?>

                                                    <?php endif; ?>
                                                    ><?php echo (isset($translate_11) && isset($translate_11[$lang]))?$translate_11[$lang]['message']:($data?$data['message']:''); ?></textarea>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?php ($ooa=\App\Models\NotificationMessage::with('translations')->where('module_type',$mod_type)->where('key','offline_order_accept_message')->first()); ?>
                                        <?php ($data=$ooa?$ooa:''); ?>
                                        <?php
                                        if(isset($ooa->translations) && count($ooa->translations)){

                                                $translate_12 = [];
                                                foreach($ooa->translations as $t)
                                                {
                                                    if($t->locale == $lang && $t->key=='offline_order_accept_message'){
                                                        $translate_12[$lang]['message'] = $t->value;
                                                    }
                                                }

                                            }

                                        ?>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <div class="d-flex flex-wrap justify-content-between mb-2">
                                                    <span class="d-block form-label">
                                                        <?php echo e(translate('messages.offline_order_accept_message')); ?>

                                                    </span>
                                                    <?php if($lang == 'en'): ?>
                                                        <label class="switch--custom-label toggle-switch d-flex align-items-center mb-0"
                                                                for="offline_order_accept_message">
                                                            <input type="checkbox"

                                                                   data-id="offline_order_accept_message"
                                                                   data-type="toggle"
                                                                   data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-on.png')); ?>"
                                                                   data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-off.png')); ?>"
                                                                   data-title-on="<?php echo e(translate('By Turning ON Offline Order')); ?> <strong><?php echo e(translate('accept Message')); ?></strong>"
                                                                   data-title-off="<?php echo e(translate('By Turning OFF Offline Order')); ?> <strong><?php echo e(translate('accept Message')); ?></strong>"
                                                                   data-text-on="<p><?php echo e(translate('User will get a clear message to know that the offline order is accepted.')); ?></p>"
                                                                   data-text-off="<p><?php echo e(translate('User cannot get a clear message to know that the offline order is accepted or not.')); ?></p>"
                                                                   class="status toggle-switch-input add-required-attribute  dynamic-checkbox-toggle"
                                                                   name="offline_order_accept_message_status"
                                                                   data-textarea-name="offline_order_accept_message"
                                                                    value="1"
                                                                    id="offline_order_accept_message" <?php echo e($data?($data['status']==1?'checked':''):''); ?>>
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                                </span>
                                                        </label>

                                                    <?php endif; ?>
                                                </div>

                                                <textarea name="offline_order_accept_message[]"  placeholder="<?php echo e(translate('Write your message')); ?>" class="form-control offline_order_accept_message"                                           <?php if($lang == 'en'): ?>
                                                <?php echo e($data?($data['status']==1?'required':''):''); ?>

                                                <?php endif; ?>
                                                ><?php echo (isset($translate_12) && isset($translate_12[$lang]))?$translate_12[$lang]['message']:($data?$data['message']:''); ?></textarea>
                                            </div>
                                        </div>
                                        <?php ($ood=\App\Models\NotificationMessage::with('translations')->where('module_type',$mod_type)->where('key','offline_order_deny_message')->first()); ?>
                                        <?php ($data=$ood?$ood:''); ?>
                                        <?php
                                        if(isset($ood->translations) && count($ood->translations)){

                                                $translate_13 = [];
                                                foreach($ood->translations as $t)
                                                {
                                                    if($t->locale == $lang && $t->key=='offline_order_deny_message'){
                                                        $translate_13[$lang]['message'] = $t->value;
                                                    }
                                                }

                                            }

                                        ?>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <div class="d-flex flex-wrap justify-content-between mb-2">
                                                    <span class="d-block form-label">
                                                        <?php echo e(translate('messages.offline_order_deny_message')); ?>

                                                    </span>
                                                    <?php if($lang == 'en'): ?>
                                                        <label class="switch--custom-label toggle-switch d-flex align-items-center mb-0"
                                                                for="offline_order_deny_message">
                                                            <input type="checkbox"
                                                                   data-id="offline_order_deny_message"
                                                                   data-type="toggle"
                                                                   data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-on.png')); ?>"
                                                                   data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/pending-order-off.png')); ?>"
                                                                   data-title-on="<?php echo e(translate('By Turning ON Offline Order')); ?> <strong><?php echo e(translate('deny Message')); ?></strong>"
                                                                   data-title-off="<?php echo e(translate('By Turning OFF Offline Order')); ?> <strong><?php echo e(translate('deny Message')); ?></strong>"
                                                                   data-text-on="<p><?php echo e(translate('User will get a clear message to know that the offline order is denied.')); ?></p>"
                                                                   data-text-off="<p><?php echo e(translate('User cannot get a clear message to know that the offline order is denied or not.')); ?></p>"
                                                                   class="status toggle-switch-input add-required-attribute  dynamic-checkbox-toggle"
                                                                   name="offline_order_deny_message_status"
                                                                   data-textarea-name="offline_order_deny_message"
                                                                   value="1"
                                                                    id="offline_order_deny_message" <?php echo e($data?($data['status']==1?'checked':''):''); ?>>
                                                            <span class="toggle-switch-label">
                                                                <span class="toggle-switch-indicator"></span>
                                                                </span>
                                                        </label>

                                                    <?php endif; ?>
                                                </div>

                                                <textarea name="offline_order_deny_message[]"  placeholder="<?php echo e(translate('Write your message')); ?>" class="form-control offline_order_deny_message"                                           <?php if($lang == 'en'): ?>
                                                <?php echo e($data?($data['status']==1?'required':''):''); ?>

                                                <?php endif; ?>
                                                ><?php echo (isset($translate_13) && isset($translate_13[$lang]))?$translate_13[$lang]['message']:($data?$data['message']:''); ?></textarea>
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
                                <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.submit')); ?></button>
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
                                        <img src="<?php echo e(asset('/public/assets/admin/img/email-templates/3.png')); ?>" alt="" class="mb-20">
                                        <h5 class="modal-title"><?php echo e(translate('Write_a_message_in_the_Notification_Body')); ?></h5>
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
                                        <img src="<?php echo e(asset('/public/assets/admin/img/firebase/slide-4.png')); ?>" alt="" class="mb-20">
                                        <h5 class="modal-title"><?php echo e(translate('Please Visit the Docs to Set FCM on Mobile Apps')); ?></h5>
                                    </div>
                                    <div class="text-center">
                                        <p>
                                            <?php echo e(translate('Please check the documentation below for detailed instructions on setting up your mobile app to receive Firebase Cloud Messaging (FCM) notifications.')); ?>

                                        </p>
                                        <a href="https://docs.6amtech.com/docs-six-am-mart/mobile-apps/mandatory-setup" target="_blank"><?php echo e(translate('Click Here')); ?></a>
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


<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/fcm-index.blade.php ENDPATH**/ ?>