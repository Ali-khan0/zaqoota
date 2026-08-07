<?php $__env->startSection('title',translate('edit_bonus')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/edit.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.wallet_bonus_update')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->
        <div class="card">
            <div class="card-body">
                <form action="<?php echo e(route('admin.users.customer.wallet.bonus.update',[$bonus['id']])); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="row g-3">
                        <div class="col-12">
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
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="input-label" for="default_title"><?php echo e(translate('messages.Bonus_Title')); ?> (<?php echo e(translate('messages.default')); ?>) <span class="form-label-secondary text-danger"
                                                            data-toggle="tooltip" data-placement="right"
                                                            data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                            </span></label>
                                                        <input type="text" name="title[]" id="default_title" class="form-control" placeholder="<?php echo e(translate('messages.title')); ?>" value="<?php echo e($bonus?->getRawOriginal('title')); ?>"  >
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="input-label" for="default_description"><?php echo e(translate('messages.Short_Description')); ?> (<?php echo e(translate('messages.default')); ?>) <span class="form-label-secondary text-danger"
                                                            data-toggle="tooltip" data-placement="right"
                                                            data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                            </span></label>
                                                        <input type="text" name="description[]" id="default_description" class="form-control" placeholder="<?php echo e(translate('messages.description')); ?>" value="<?php echo e($bonus?->getRawOriginal('description')); ?>"  >
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="lang[]" value="default">
                                        </div>
                                        <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                if(count($bonus['translations'])){
                                                    $translate = [];
                                                    foreach($bonus['translations'] as $t)
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
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label class="input-label" for="<?php echo e($lang); ?>_title"><?php echo e(translate('messages.Bonus_Title')); ?> (<?php echo e(strtoupper($lang)); ?>)</label>
                                                            <input type="text" name="title[]" id="<?php echo e($lang); ?>_title" class="form-control" placeholder="<?php echo e(translate('messages.title')); ?>" value="<?php echo e($translate[$lang]['title']??''); ?>"  >
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label class="input-label" for="<?php echo e($lang); ?>_description"><?php echo e(translate('messages.Short_Description')); ?> (<?php echo e(strtoupper($lang)); ?>)</label>
                                                            <input type="text" name="description[]" id="<?php echo e($lang); ?>_description" class="form-control" placeholder="<?php echo e(translate('messages.description')); ?>" value="<?php echo e($translate[$lang]['description']??''); ?>"  >
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                    <div id="default-form">
                                        <div class="form-group">
                                            <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.Bonus_Title')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                            <input type="text" name="title[]" class="form-control" placeholder="<?php echo e(translate('messages.title')); ?>" value="<?php echo e($bonus['title']); ?>" maxlength="100">
                                        </div>
                                        <input type="hidden" name="lang[]" value="default">
                                    </div>
                                    <?php endif; ?>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-6">
                            <div class="form-group m-0">
                                <label class="input-label" for="bonus_type"><?php echo e(translate('messages.Bonus_Type')); ?> <span class="form-label-secondary text-danger"
                                    data-toggle="tooltip" data-placement="right"
                                    data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                    </span></label>
                                <select name="bonus_type" id="bonus_type" class="form-control">
                                    <option value="amount" <?php echo e($bonus['bonus_type']=='amount'?'selected':''); ?>><?php echo e(translate('messages.amount')); ?> (<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)
                                    </option>
                                    <option value="percentage" <?php echo e($bonus['bonus_type']=='percentage'?'selected':''); ?>>
                                        <?php echo e(translate('messages.percentage')); ?> (%)
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-6">
                            <div class="form-group m-0">
                                <label class="input-label" for="bonus_amount"><?php echo e(translate('messages.Bonus_Amount')); ?>

                                    <span    class="<?php echo e($bonus['bonus_type']=='amount'? '':'d-none'); ?>" id='cuttency_symbol'>(<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)
                                    </span>
                                    <span   class="<?php echo e($bonus['bonus_type']=='percentage'? '':'d-none'); ?>" id="percentage">(%)</span>

                                    <span
                                    class="input-label-secondary text--title" data-toggle="tooltip"
                                    data-placement="right"
                                    data-original-title="<?php echo e(translate('Set_the_bonus_amount/percentage_a_customer_will_receive_after_adding_money_to_his_wallet.')); ?>">
                                    <i class="tio-info-outined"></i>
                                </span>
                                <span class="form-label-secondary text-danger"
                                data-toggle="tooltip" data-placement="right"
                                data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                </span>
                                </label>
                                <input type="number" id="bonus_amount" min="1" max="<?php echo e($bonus['bonus_type'] == 'percentage'? '100' : '999999999999.99'); ?>" step="0.01" value="<?php echo e($bonus['bonus_amount']); ?>"
                                       name="bonus_amount" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-6">
                            <div class="form-group m-0">
                                <label class="input-label" for="minimum_add_amount"><?php echo e(translate('messages.Minimum_Add_Money_Amount')); ?>

                                    (<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)
                                            <span
                                            class="input-label-secondary text--title" data-toggle="tooltip"
                                            data-placement="right"
                                            data-original-title="<?php echo e(translate('Set_the_minimum_add_money_amount_for_a_customer_to_be_eligible_for_the_bonus.')); ?>">
                                            <i class="tio-info-outined"></i>
                                        </span>
                                        <span class="form-label-secondary text-danger"
                                        data-toggle="tooltip" data-placement="right"
                                        data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                        </span>
                                </label>
                                <input type="number" id="minimum_add_amount" min="1" max="999999999999.99" step="0.01" value="<?php echo e($bonus['minimum_add_amount']); ?>"
                                       name="minimum_add_amount" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-6">
                            <div class="form-group m-0">
                                <label class="input-label" for="exampleFormControlInput1">
                                    <?php echo e(translate('messages.Maximum_Bonus')); ?> (<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)
                                    <span
                                    class="input-label-secondary text--title" data-toggle="tooltip"
                                    data-placement="right"
                                    data-original-title="<?php echo e(translate('Set_the_maximum_bonus_amount_a_customer_can_receive_for_adding_money_to_his_wallet.')); ?>">
                                    <i class="tio-info-outined"></i>
                                </span>

                                </label>
                                <input type="number" min="0" max="999999999999.99" step="0.01" value="<?php echo e($bonus['maximum_bonus_amount']); ?>" name="maximum_bonus_amount" id="maximum_bonus_amount" class="form-control" <?php echo e($bonus['bonus_type']=='amount'?'readonly="readonly"':''); ?>>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-6">
                            <div class="form-group m-0">
                                <label class="input-label" for="date_from"><?php echo e(translate('messages.start_date')); ?> <span class="form-label-secondary text-danger"
                                                        data-toggle="tooltip" data-placement="right"
                                                        data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                        </span></label>
                                <input type="date" name="start_date" class="form-control" id="date_from" placeholder="<?php echo e(translate('messages.select_date')); ?>" max="<?php echo e(date("Y-m-d",strtotime($bonus["end_date"]))); ?>" value="<?php echo e(date('Y-m-d',strtotime($bonus['start_date']))); ?>"                     data-hs-flatpickr-options='{
                                    "dateFormat": "Y-m-d"
                                  }'>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-6">
                            <div class="form-group m-0">
                                <label class="input-label" for="date_to"><?php echo e(translate('messages.expire_date')); ?> <span class="form-label-secondary text-danger"
                                                        data-toggle="tooltip" data-placement="right"
                                                        data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                                        </span></label>
                                <input type="date" name="end_date" class="form-control" placeholder="<?php echo e(translate('messages.select_date')); ?>" min="<?php echo e(date("Y-m-d",strtotime($bonus["start_date"]))); ?>" id="date_to" value="<?php echo e(date('Y-m-d',strtotime($bonus['end_date']))); ?>"
                                       data-hs-flatpickr-options='{
                                     "dateFormat": "Y-m-d"
                                   }'>
                            </div>
                        </div>
                    </div>
                    <div class="btn--container justify-content-end mt-4">
                        <button type="reset" id="reset_btn" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.update')); ?></button>
                    </div>
                </form>
            </div>
            <!-- End Table -->
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script src="<?php echo e(asset('public/assets/admin')); ?>/js/view-pages/wallet-bonus-edit.js"></script>
    <script>
        "use strict";
        $(document).on('ready', function () {
            $('#date_from').attr('min',(new Date()).toISOString().split('T')[0]);
            $('#date_from').attr('max','<?php echo e(date("Y-m-d",strtotime($bonus["end_date"]))); ?>');
            $('#date_to').attr('min','<?php echo e(date("Y-m-d",strtotime($bonus["start_date"]))); ?>');
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/wallet-bonus/edit.blade.php ENDPATH**/ ?>