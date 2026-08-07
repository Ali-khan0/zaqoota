<?php $__env->startSection('title',translate('Edit Role')); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">

    <!-- Page Heading -->
    <div class="page-header">
        <h1 class="page-header-title">
            <span class="page-header-icon">
                <img src="<?php echo e(asset('public/assets/admin/img/edit.png')); ?>" class="w--26" alt="">
            </span>
            <span>
                <?php echo e(translate('messages.edit_role')); ?>

            </span>
        </h1>
    </div>
    <!-- Page Heading -->

    <!-- Content Row -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                <span class="card-header-icon">
                    <i class="tio-document-text-outlined"></i>
                </span>
                <span><?php echo e(translate('messages.role_form')); ?></span>
            </h5>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('vendor.custom-role.update',[$role['id']])); ?>" method="post">
                <?php echo csrf_field(); ?>
                <?php ($language=\App\Models\BusinessSetting::where('key','language')->first()); ?>
                <?php ($language = $language->value ?? null); ?>
                <?php ($defaultLang = str_replace('_', '-', app()->getLocale())); ?>
                <?php if($language): ?>
                    <ul class="nav nav-tabs mb-4">
                        <li class="nav-item">
                            <a class="nav-link lang_link active"
                            href="#"
                            id="default-link"><?php echo e(translate('messages.default')); ?></a>
                        </li>
                        <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="nav-item">
                                <a class="nav-link lang_link"
                                    href="#"
                                    id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <div class="lang_form" id="default-form">
                        <div class="form-group">
                            <label class="input-label" for="default_title"><?php echo e(translate('messages.role_name')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                            <input type="text" name="name[]" id="default_title" class="form-control" placeholder="<?php echo e(translate('role_name_example')); ?>" value="<?php echo e($role?->getRawOriginal('name')); ?>"  >
                        </div>
                        <input type="hidden" name="lang[]" value="default">
                    </div>
                    <?php $__currentLoopData = json_decode($language); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            if(count($role['translations'])){
                                $translate = [];
                                foreach($role['translations'] as $t)
                                {
                                    if($t->locale == $lang && $t->key=="name"){
                                        $translate[$lang]['name'] = $t->value;
                                    }
                                }
                            }
                        ?>
                        <div class="d-none lang_form" id="<?php echo e($lang); ?>-form">
                            <div class="form-group">
                                <label class="input-label" for="<?php echo e($lang); ?>_title"><?php echo e(translate('messages.role_name')); ?> (<?php echo e(strtoupper($lang)); ?>)</label>
                                <input type="text" name="name[]" id="<?php echo e($lang); ?>_title" class="form-control" placeholder="<?php echo e(translate('role_name_example')); ?>" value="<?php echo e($translate[$lang]['name']??''); ?>"  >
                            </div>
                            <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                <div id="default-form">
                    <div class="form-group">
                        <label class="input-label" for="name"><?php echo e(translate('messages.role_name')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                        <input type="text" id="name" name="name[]" class="form-control" placeholder="<?php echo e(translate('role_name_example')); ?>" value="<?php echo e($role['name']); ?>" maxlength="100" required>
                    </div>
                    <input type="hidden" name="lang[]" value="default">
                </div>
                <?php endif; ?>

                <h5><?php echo e(translate('messages.module_permission')); ?> : </h5>
                <hr>
                <div class="check--item-wrapper mx-0">
                    <div class="check-item">
                        <div class="form-group form-check form--check">
                            <input type="checkbox" name="modules[]" value="trip" class="form-check-input"
                                   id="trip" <?php echo e(in_array('trip',(array)json_decode($role['modules']))?'checked':''); ?>>
                            <label class="form-check-label input-label " for="trip"><?php echo e(translate('messages.Trip')); ?></label>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="form-group form-check form--check">
                            <input type="checkbox" name="modules[]" value="vehicle" class="form-check-input"
                                   id="vehicle" <?php echo e(in_array('vehicle',(array)json_decode($role['modules']))?'checked':''); ?>>
                            <label class="form-check-label input-label " for="vehicle"><?php echo e(translate('messages.Vehicle')); ?></label>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="form-group form-check form--check">
                            <input type="checkbox" name="modules[]" value="driver" class="form-check-input"
                                   id="driver" <?php echo e(in_array('driver',(array)json_decode($role['modules']))?'checked':''); ?>>
                            <label class="form-check-label input-label " for="driver"><?php echo e(translate('messages.Driver')); ?></label>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="form-group form-check form--check">
                            <input type="checkbox" name="modules[]" value="marketing" class="form-check-input"
                                   id="marketing" <?php echo e(in_array('marketing',(array)json_decode($role['modules']))?'checked':''); ?>>
                            <label class="form-check-label input-label " for="marketing"><?php echo e(translate('messages.Marketing')); ?></label>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="form-group form-check form--check">
                            <input type="checkbox" name="modules[]" value="store_setup" class="form-check-input"
                                   id="store_setup" <?php echo e(in_array('store_setup',(array)json_decode($role['modules']))?'checked':''); ?>>
                            <label class="form-check-label input-label " for="store_setup"><?php echo e(translate('messages.Store setup')); ?></label>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="form-group form-check form--check">
                            <input type="checkbox" name="modules[]" value="wallet" class="form-check-input"
                                   id="wallet" <?php echo e(in_array('wallet',(array)json_decode($role['modules']))?'checked':''); ?>>
                            <label class="form-check-label input-label " for="wallet"><?php echo e(translate('messages.My wallet')); ?></label>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="form-group form-check form--check">
                            <input type="checkbox" name="modules[]" value="bank_info" class="form-check-input"
                                   id="bank_info" <?php echo e(in_array('bank_info',(array)json_decode($role['modules']))?'checked':''); ?>>
                            <label class="form-check-label input-label " for="bank_info"><?php echo e(translate('messages.Profile')); ?></label>
                        </div>
                    </div>

                    <div class="check-item">
                        <div class="form-group form-check form--check">
                            <input type="checkbox" name="modules[]" value="employee" class="form-check-input"
                                   id="employee" <?php echo e(in_array('employee',(array)json_decode($role['modules']))?'checked':''); ?>>
                            <label class="form-check-label input-label " for="employee"><?php echo e(translate('messages.Employees')); ?></label>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="form-group form-check form--check">
                            <input type="checkbox" name="modules[]" value="my_shop" class="form-check-input"
                                   id="my_shop" <?php echo e(in_array('my_shop',(array)json_decode($role['modules']))?'checked':''); ?>>
                            <label class="form-check-label input-label " for="my_shop"><?php echo e(translate('messages.My shop')); ?></label>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="form-group form-check form--check">
                            <input type="checkbox" name="modules[]" value="reviews" class="form-check-input"
                                   id="reviews" <?php echo e(in_array('reviews',(array)json_decode($role['modules']))?'checked':''); ?>>
                            <label class="form-check-label input-label " for="reviews"><?php echo e(translate('messages.reviews')); ?></label>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="form-group form-check form--check">
                            <input type="checkbox" name="modules[]" value="chat" class="form-check-input"
                                   id="chat" <?php echo e(in_array('chat',(array)json_decode($role['modules']))?'checked':''); ?>>
                            <label class="form-check-label input-label " for="chat"><?php echo e(translate('messages.chat')); ?></label>
                        </div>
                    </div>
                    <div class="check-item">
                        <div class="form-group form-check form--check">
                            <input type="checkbox" name="modules[]" value="report" class="form-check-input"
                                   id="report" <?php echo e(in_array('report',(array)json_decode($role['modules']))?'checked':''); ?>>
                            <label class="form-check-label input-label " for="report"><?php echo e(translate('messages.Report')); ?></label>
                        </div>
                    </div>
                </div>
                <div class="btn--container justify-content-end mt-4">
                    <button type="reset" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                    <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.update')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.vendor.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/Modules/Rental/Resources/views/provider/employee/edit.blade.php ENDPATH**/ ?>