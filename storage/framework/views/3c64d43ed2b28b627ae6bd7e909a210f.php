<?php $__env->startSection('title',translate('Edit_Cashback_Offer')); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/Create_Cashback_Offer.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.Edit_Cashback_Offer')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->

        <div class="card">
            <div class="card-body" id="form_data">
                <form action="<?php echo e(route('admin.users.cashback.update',['id'=>$cashback?->id ])); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-12">
                            <?php if($language): ?>
                            <ul class="nav nav-tabs mb-3 border-0">
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
                        </div>

                        <div class="col-md-4 col-lg-4 col-sm-6">
                            <div class="lang_form" id="default-form">
                                <div class="form-group">
                                    <label class="input-label"
                                        for="default_title"><?php echo e(translate('messages.title')); ?>

                                        (<?php echo e(translate('Default')); ?>)
                                    </label>
                                    <input type="text" name="title[]" maxlength="254" value="<?php echo e($cashback?->getRawOriginal('title')); ?>" id="default_title"
                                        class="form-control" placeholder="<?php echo e(translate('messages.Eid_Dhamaka')); ?>" >
                                </div>
                                <input type="hidden" name="lang[]" value="default">
                            </div>
                                <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                if(count($cashback['translations'])){
                                    $translate = [];
                                    foreach($cashback['translations'] as $t)
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
                                    <div class="d-none lang_form"
                                        id="<?php echo e($lang); ?>-form">
                                        <div class="form-group">
                                            <label class="input-label"
                                                for="<?php echo e($lang); ?>_title"><?php echo e(translate('messages.title')); ?>

                                                (<?php echo e(strtoupper($lang)); ?>)
                                            </label>
                                            <input type="text" name="title[]" maxlength="254" id="<?php echo e($lang); ?>_title" value="<?php echo e($translate[$lang]['title']??''); ?>"
                                                class="form-control" placeholder="<?php echo e(translate('messages.Eid_Dhamaka')); ?>"
                                                 >
                                        </div>
                                        <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div id="default-form">
                                    <div class="form-group">
                                        <label class="input-label"
                                            for="exampleFormControlInput1"><?php echo e(translate('messages.title')); ?> (<?php echo e(translate('messages.default')); ?>)</label>
                                        <input type="text" name="title[]" maxlength="254" class="form-control"
                                            placeholder="<?php echo e(translate('messages.Eid_Dhamaka')); ?>">
                                    </div>
                                    <input type="hidden" name="lang[]" value="default">
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-4 col-lg-4 col-sm-6" id="customer_wise">
                            <div class="form-group">
                                <label class="input-label" for="select_customer"><?php echo e(translate('messages.select_customer')); ?></label>
                                <select required name="customer_id[]" id="select_customer"
                                class="form-control js-select2-custom"
                                multiple="multiple" placeholder="<?php echo e(translate('messages.select_customer')); ?>">
                                <option value="all" <?php echo e(in_array('all', json_decode($cashback->customer_id))?'selected':''); ?>><?php echo e(translate('messages.all')); ?> </option>
                                <?php $__currentLoopData = \App\Models\User::get(['id','f_name','l_name']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($user->id); ?>" <?php echo e(in_array($user->id, json_decode($cashback->customer_id))?'selected':''); ?>><?php echo e($user->f_name.' '.$user->l_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            </div>
                        </div>



                        <div class="col-md-4 col-lg-4 col-sm-6">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.Cashback_Type')); ?> <span class="form-label-secondary text-danger"
                                    data-toggle="tooltip" data-placement="right"
                                    data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                    </span></label>
                                <select name="cashback_type" class="form-control"  data-mas_discount="<?php echo e($cashback?->max_discount ?? null); ?>" id="cashback_type" required>
                                    <option <?php echo e($cashback->cashback_type ==  'percentage' ? 'selected'  : ''); ?> value="percentage"><?php echo e(translate('messages.percentage')); ?> (%)</option>
                                    <option <?php echo e($cashback->cashback_type ==  'amount' ? 'selected'  : ''); ?> value="amount"><?php echo e(translate('messages.amount')); ?> <?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-6">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.Cashback_Amount')); ?>


                                    <span  class=" <?php echo e($cashback->cashback_type ==  'percentage' ? 'd-none'  : ''); ?>   " id='cuttency_symbol'>(<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)
                                    </span>
                                    <span  class=" <?php echo e($cashback->cashback_type ==  'percentage' ? ''  : 'd-none'); ?>"  id="percentage">(%)</span>

                                    <span
                                    class="input-label-secondary text--title" data-toggle="tooltip"
                                    data-placement="right"
                                    data-original-title="<?php echo e(translate('Set_the_Cash_back_amount/percentage_a_customer_will_receive_after_a_successfull_order.')); ?>">
                                    <i class="tio-info-outined"></i>
                                </span>
                                <span class="form-label-secondary text-danger"
                                data-toggle="tooltip" data-placement="right"
                                data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                                </span>

                                </label>
                                <input type="number"   step="0.01" min="1" value="<?php echo e($cashback->cashback_amount); ?>" max="<?php echo e($cashback->cashback_type ==  'percentage' ? '100'  : '999999999.99'); ?>"  placeholder="<?php echo e(translate('messages.Ex:_100')); ?>"  name="cashback_amount" id="Cash_back_amount" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-4 col-lg-4 col-sm-6">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.Minimum_Purchase')); ?> (<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)</label>
                                <input type="number" step="0.01" id="min_purchase" required name="min_purchase" value="<?php echo e($cashback->min_purchase); ?>" min="0" max="999999999999.99" class="form-control"
                                placeholder="<?php echo e(translate('messages.Ex:_100')); ?>">
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-6">
                            <div class="form-group">
                                <label class="input-label" for="max_discount"><?php echo e(translate('messages.Maximum_Discount')); ?> (<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)</label>
                                <input type="number" step="0.01" min="0" placeholder="<?php echo e(translate('messages.Ex:_100')); ?>"  max="999999999999.99"  <?php echo e($cashback->cashback_type ==  'percentage' ? 'required'  : 'readonly'); ?>   value="<?php echo e($cashback->max_discount); ?>" name="max_discount" id="max_discount" class="form-control" >
                            </div>
                        </div>

                        <div class="col-md-4 col-lg-4 col-sm-6">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.Start_Date')); ?></label>
                                <input type="date" name="start_date" value="<?php echo e($cashback->start_date); ?>" class="form-control" id="date_from" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-6">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.End_Date')); ?></label>
                                <input type="date" name="end_date" value="<?php echo e($cashback->end_date); ?>"  class="form-control" id="date_to" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-6">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1"><?php echo e(translate('messages.Limit_for_Same_User')); ?></label>
                                <input type="number" step="1" name="same_user_limit" value="<?php echo e($cashback->same_user_limit); ?>"  value="0" min="0" max="9999999" class="form-control" required
                                placeholder="<?php echo e(translate('messages.Ex:_5')); ?>">
                            </div>
                        </div>

                    </div>
                    <div class="btn--container justify-content-end">
                        <button type="reset" id="reset_btn" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo e(translate('messages.Update')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script>


        "use strict";
        $('#reset_btn').click(function(){
            setTimeout(reset_select, 100);
        })
        function reset_select(){
            $('#select_customer').trigger('change');
            if($('#cashback_type').val() == 'amount')
                    {
                        $('#max_discount').attr("readonly","true");
                        $('#max_discount').removeAttr("required");
                        $('#percentage').addClass('d-none');
                        $('#cuttency_symbol').removeClass('d-none');
                        $('#Cash_back_amount').attr('max',99999999999);
                    }else{
                        $('#max_discount').removeAttr("readonly");
                        $('#max_discount').attr("required","true");
                        $('#percentage').removeClass('d-none');
                        $('#cuttency_symbol').addClass('d-none');
                        $('#Cash_back_amount').attr('max',100);
                    }
        }
        $(document).on('ready', function () {
            $('#date_from').attr('min',(new Date()).toISOString().split('T')[0]);
            $('#date_from').attr('max','<?php echo e(date("Y-m-d",strtotime($cashback["end_date"]))); ?>');
            $('#date_to').attr('min','<?php echo e(date("Y-m-d",strtotime($cashback["start_date"]))); ?>');
        });



        $(document).ready(function() {

                $('#cashback_type').on('change', function() {


                    if($('#cashback_type').val() == 'amount')
                    {
                        $('#max_discount').attr("readonly","true");
                        $('#max_discount').removeAttr("required");
                        $('#max_discount').val( $(this).data("max_discount"));
                        $('#percentage').addClass('d-none');
                        $('#cuttency_symbol').removeClass('d-none');
                        $('#Cash_back_amount').attr('max',99999999999);
                    }
                    else
                    {
                        $('#max_discount').removeAttr("readonly");
                        $('#max_discount').attr("required","true");
                        $('#percentage').removeClass('d-none');
                        $('#cuttency_symbol').addClass('d-none');
                        $('#Cash_back_amount').attr('max',100);

                    }
                });

                $('#date_from').attr('min',(new Date()).toISOString().split('T')[0]);
                $('#date_to').attr('min',(new Date()).toISOString().split('T')[0]);

                // INITIALIZATION OF SELECT2
                // =======================================================
                $('.js-select2-custom').each(function () {
                    let select2 = $.HSCore.components.HSSelect2.init($(this));
                });
            });

            $("#date_from").on("change", function () {
                $('#date_to').attr('min',$(this).val());
            });

            $("#date_to").on("change", function () {
                $('#date_from').attr('max',$(this).val());
            });




    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/promotions/cashback/edit.blade.php ENDPATH**/ ?>