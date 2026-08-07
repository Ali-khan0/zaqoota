<?php $__env->startSection('title',translate('Edit Role')); ?>
<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <!-- Page Heading -->
    <div class="page-header">
        <h1 class="page-header-title">
            <span class="page-header-icon">
                <img src="<?php echo e(asset('public/assets/admin/img/edit.png')); ?>" class="w--26" alt="">
            </span>
            <span>
                <?php echo e(translate('messages.employee_Role')); ?>

            </span>
        </h1>
    </div>
    <!-- Page Heading -->
    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo e(route('admin.users.custom-role.update',[$role['id']])); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <?php if($language): ?>
                            <ul class="nav nav-tabs mb-4">
                                <li class="nav-item">
                                    <a class="nav-link lang_link active"
                                    href="#"
                                    id="default-link"><?php echo e(translate('messages.default')); ?></a>
                                </li>
                                <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="nav-item">
                                        <a class="nav-link lang_link"
                                            href="#"
                                            id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <div class="lang_form" id="default-form">
                                <div class="form-group">
                                    <label class="input-label" for="default_title"><?php echo e(translate('messages.role_name')); ?> (<?php echo e(translate('messages.default')); ?>) <span class="form-label-secondary text-danger"
                                        data-toggle="tooltip" data-placement="right"
                                        data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                        </span>
                                 </label>
                                    <input type="text" name="name[]" id="default_title" class="form-control" placeholder="<?php echo e(translate('role_name_example')); ?>" value="<?php echo e($role?->getRawOriginal('name')); ?>"  >
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                            </div>
                            <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.role_name')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                <input type="text" name="name[]" class="form-control" placeholder="<?php echo e(translate('role_name_example')); ?>" value="<?php echo e($role['name']); ?>" maxlength="100">
                            </div>
                            <input type="hidden" name="lang[]" value="default">
                        </div>
                        <?php endif; ?>

                        <div class="d-flex flex-wrap select--all-checkes">
                            <h5 class="input-label m-0 text-capitalize"><?php echo e(translate('messages.Update_permission')); ?> : </h5>
                            <div class="check-item pb-0 w-auto">
                                <div class="form-group form-check form--check m-0 ml-2">
                                    <input type="checkbox" name="modules[]" value="account" class="form-check-input" id="select-all">
                                    <label class="form-check-label ml-2" for="select-all"><?php echo e(translate('Select All')); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="check--item-wrapper">
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="collect_cash" class="form-check-input"
                                           id="collect_cash"  <?php echo e(in_array('collect_cash',(array)json_decode($role['modules']))?'checked':''); ?>>
                                    <label class="form-check-label qcont text-dark" for="collect_cash"><?php echo e(translate('messages.collect_cash')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="addon" class="form-check-input"
                                           id="addon"  <?php echo e(in_array('addon',(array)json_decode($role['modules']))?'checked':''); ?>>
                                    <label class="form-check-label qcont text-dark" for="addon"><?php echo e(translate('messages.addon')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="attribute" class="form-check-input"
                                           id="attribute"  <?php echo e(in_array('attribute',(array)json_decode($role['modules']))?'checked':''); ?>>
                                    <label class="form-check-label qcont text-dark" for="attribute"><?php echo e(translate('messages.attribute')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="advertisement" class="form-check-input"
                                           id="advertisement"  <?php echo e(in_array('advertisement',(array)json_decode($role['modules']))?'checked':''); ?>>
                                    <label class="form-check-label qcont text-dark" for="advertisement"><?php echo e(translate('messages.advertisement')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="banner" class="form-check-input"
                                           id="banner"  <?php echo e(in_array('banner',(array)json_decode($role['modules']))?'checked':''); ?>>
                                    <label class="form-check-label qcont text-dark" for="banner"><?php echo e(translate('messages.banner')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="campaign" class="form-check-input"
                                           id="campaign"  <?php echo e(in_array('campaign',(array)json_decode($role['modules']))?'checked':''); ?>>
                                    <label class="form-check-label qcont text-dark" for="campaign"><?php echo e(translate('messages.campaign')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="category" class="form-check-input"
                                           id="category"  <?php echo e(in_array('category',(array)json_decode($role['modules']))?'checked':''); ?>>
                                    <label class="form-check-label qcont text-dark" for="category"><?php echo e(translate('messages.category')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="coupon" class="form-check-input"
                                           id="coupon"  <?php echo e(in_array('coupon',(array)json_decode($role['modules']))?'checked':''); ?>>
                                    <label class="form-check-label qcont text-dark" for="coupon"><?php echo e(translate('messages.coupon')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="cashback" class="form-check-input"
                                           id="cashback"  <?php echo e(in_array('cashback',(array)json_decode($role['modules']))?'checked':''); ?>>
                                    <label class="form-check-label qcont text-dark" for="cashback"><?php echo e(translate('messages.cashback')); ?></label>
                                </div>
                            </div>

                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="customer_management" class="form-check-input"
                                           id="customer_management"  <?php echo e(in_array('customer_management',(array)json_decode($role['modules']))?'checked':''); ?>>
                                    <label class="form-check-label qcont text-dark" for="customer_management"><?php echo e(translate('messages.customer_management')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="deliveryman" class="form-check-input"
                                           id="deliveryman"  <?php echo e(in_array('deliveryman',(array)json_decode($role['modules']))?'checked':''); ?>>
                                    <label class="form-check-label qcont text-dark" for="deliveryman"><?php echo e(translate('messages.deliveryman')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="disbursement" class="form-check-input"
                                           id="disbursement"  <?php echo e(in_array('disbursement',(array)json_decode($role['modules']))?'checked':''); ?>>
                                    <label class="form-check-label qcont text-dark" for="disbursement"><?php echo e(translate('messages.disbursement')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="provide_dm_earning" class="form-check-input"
                                           id="provide_dm_earning"  <?php echo e(in_array('provide_dm_earning',(array)json_decode($role['modules']))?'checked':''); ?>>
                                    <label class="form-check-label qcont text-dark" for="provide_dm_earning"><?php echo e(translate('messages.provide_dm_earning')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="employee" class="form-check-input"
                                           id="employee"  <?php echo e(in_array('employee',(array)json_decode($role['modules']))?'checked':''); ?>>
                                    <label class="form-check-label qcont text-dark" for="employee"><?php echo e(translate('messages.Employee')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="item" class="form-check-input"
                                           id="item"  <?php echo e(in_array('item',(array)json_decode($role['modules']))?'checked':''); ?>>
                                    <label class="form-check-label qcont text-dark" for="item"><?php echo e(translate('messages.item')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="notification" class="form-check-input"
                                           id="notification"  <?php echo e(in_array('notification',(array)json_decode($role['modules']))?'checked':''); ?>>
                                    <label class="form-check-label qcont text-dark" for="notification"><?php echo e(translate('messages.push_notification')); ?> </label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="order" class="form-check-input"
                                           id="order"  <?php echo e(in_array('order',(array)json_decode($role['modules']))?'checked':''); ?>>
                                    <label class="form-check-label qcont text-dark" for="order"><?php echo e(translate('messages.order')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="store" class="form-check-input"
                                           id="store"  <?php echo e(in_array('store',(array)json_decode($role['modules']))?'checked':''); ?>>
                                    <label class="form-check-label qcont text-dark" for="store"><?php echo e(translate('messages.store')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="report" class="form-check-input"
                                            id="report"  <?php echo e(in_array('report',(array)json_decode($role['modules']))?'checked':''); ?>>
                                    <label class="form-check-label qcont text-dark" for="report"><?php echo e(translate('messages.report')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="settings" class="form-check-input"
                                           id="settings"  <?php echo e(in_array('settings',(array)json_decode($role['modules']))?'checked':''); ?>>
                                    <label class="form-check-label qcont text-dark" for="settings"><?php echo e(translate('messages.settings')); ?></label>
                                </div>
                            </div>

                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="withdraw_list" class="form-check-input"
                                            id="withdraw_list"  <?php echo e(in_array('withdraw_list',(array)json_decode($role['modules']))?'checked':''); ?>>
                                    <label class="form-check-label qcont text-dark" for="withdraw_list"><?php echo e(translate('messages.withdraw_list')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="zone" class="form-check-input"
                                           id="zone"  <?php echo e(in_array('zone',(array)json_decode($role['modules']))?'checked':''); ?>>
                                    <label class="form-check-label qcont text-dark" for="zone"><?php echo e(translate('messages.zone')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="module" class="form-check-input"
                                           id="module_system"  <?php echo e(in_array('module',(array)json_decode($role['modules']))?'checked':''); ?>>
                                    <label class="form-check-label qcont text-dark" for="module_system"><?php echo e(translate('messages.module')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="parcel" class="form-check-input"
                                           id="parcel"  <?php echo e(in_array('parcel',(array)json_decode($role['modules']))?'checked':''); ?>>
                                    <label class="form-check-label qcont text-dark" for="parcel"><?php echo e(translate('messages.parcel')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="pos" class="form-check-input"
                                           id="pos"  <?php echo e(in_array('pos',(array)json_decode($role['modules']))?'checked':''); ?>>
                                    <label class="form-check-label qcont text-dark" for="pos"><?php echo e(translate('messages.pos')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="unit" class="form-check-input"
                                           id="unit"  <?php echo e(in_array('unit',(array)json_decode($role['modules']))?'checked':''); ?>>
                                    <label class="form-check-label qcont text-dark" for="unit"><?php echo e(translate('messages.unit')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="subscription" class="form-check-input"
                                           id="subscription"  <?php echo e(in_array('subscription',(array)json_decode($role['modules']))?'checked':''); ?>>
                                    <label class="form-check-label qcont text-dark" for="subscription"><?php echo e(translate('messages.subscription')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="brand" class="form-check-input"
                                           id="brand"  <?php echo e(in_array('brand',(array)json_decode($role['modules']))?'checked':''); ?>>
                                    <label class="form-check-label qcont text-dark" for="brand"><?php echo e(translate('messages.brand')); ?></label>
                                </div>
                            </div>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="modules[]" value="common_condition" class="form-check-input"
                                           id="common_condition"  <?php echo e(in_array('common_condition',(array)json_decode($role['modules']))?'checked':''); ?>>
                                    <label class="form-check-label qcont text-dark" for="common_condition"><?php echo e(translate('messages.common_condition')); ?></label>
                                </div>
                            </div>
                        </div>
                        <?php if(addon_published_status('Rental')): ?>
                            <div class="pt-5">
                                <h4><?php echo e(translate('Rental Role')); ?></h4>
                            </div>
                            <div class="check--item-wrapper">
                                <div class="check-item">
                                    <div class="form-group form-check form--check">
                                        <input type="checkbox" name="modules[]" value="trip" class="form-check-input"
                                               id="trip" <?php echo e(in_array('trip',(array)json_decode($role['modules']))?'checked':''); ?>>
                                        <label class="form-check-label qcont text-dark" for="trip"><?php echo e(translate('messages.Trip')); ?></label>
                                    </div>
                                </div>
                                <div class="check-item">
                                    <div class="form-group form-check form--check">
                                        <input type="checkbox" name="modules[]" value="promotion" class="form-check-input"
                                               id="promotion" <?php echo e(in_array('promotion',(array)json_decode($role['modules']))?'checked':''); ?>>
                                        <label class="form-check-label qcont text-dark" for="promotion"><?php echo e(translate('messages.Promotion')); ?></label>
                                    </div>
                                </div>
                                <div class="check-item">
                                    <div class="form-group form-check form--check">
                                        <input type="checkbox" name="modules[]" value="vehicle" class="form-check-input"
                                               id="vehicle" <?php echo e(in_array('vehicle',(array)json_decode($role['modules']))?'checked':''); ?>>
                                        <label class="form-check-label qcont text-dark" for="vehicle"><?php echo e(translate('messages.Vehicle')); ?></label>
                                    </div>
                                </div>
                                <div class="check-item">
                                    <div class="form-group form-check form--check">
                                        <input type="checkbox" name="modules[]" value="provider" class="form-check-input"
                                               id="provider" <?php echo e(in_array('provider',(array)json_decode($role['modules']))?'checked':''); ?>>
                                        <label class="form-check-label qcont text-dark" for="provider"><?php echo e(translate('messages.Provider')); ?></label>
                                    </div>
                                </div>
                                <div class="check-item">
                                    <div class="form-group form-check form--check">
                                        <input type="checkbox" name="modules[]" value="driver" class="form-check-input"
                                               id="driver" <?php echo e(in_array('driver',(array)json_decode($role['modules']))?'checked':''); ?>>
                                        <label class="form-check-label qcont text-dark" for="driver"><?php echo e(translate('messages.Driver')); ?></label>
                                    </div>
                                </div>
                                <div class="check-item">
                                    <div class="form-group form-check form--check">
                                        <input type="checkbox" name="modules[]" value="download_app" class="form-check-input"
                                               id="download_app" <?php echo e(in_array('download_app',(array)json_decode($role['modules']))?'checked':''); ?>>
                                        <label class="form-check-label qcont text-dark" for="download_app"><?php echo e(translate('messages.Download app')); ?></label>
                                    </div>
                                </div>
                                <div class="check-item">
                                    <div class="form-group form-check form--check">
                                        <input type="checkbox" name="modules[]" value="rental_report" class="form-check-input"
                                               id="rental_report" <?php echo e(in_array('rental_report',(array)json_decode($role['modules']))?'checked':''); ?>>
                                        <label class="form-check-label qcont text-dark" for="rental_report"><?php echo e(translate('messages.Report')); ?></label>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="btn--container justify-content-end mt-4">
                            <button type="reset" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                            <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.update')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/custom-role-index.js"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/custom-role/edit.blade.php ENDPATH**/ ?>