<?php $__env->startSection('title', translate('edit_Offline_Payment_Method')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-4 pb-2">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="<?php echo e(asset('/public/assets/admin/img/3rd-party.png')); ?>" alt="">
                <?php echo e(translate('Edit_Offline_Payment_Method')); ?>

            </h2>
        </div>
        <!-- End Page Title -->

        <form action="<?php echo e(route('admin.business-settings.offline.update')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="card mt-3">
                <div class="card-header gap-2 flex-wrap">
                    <div class="d-flex align-items-center gap-2">
                        <img width="20" src="<?php echo e(asset('/public/assets/admin/img/payment-card.png')); ?>" alt="">
                        <h5 class="mb-0"><?php echo e(translate('payment_Information')); ?></h5>
                    </div>
                    <a href="javascript:"  class="btn btn--primary add-input-fields-group"><i class="tio-add"></i> <?php echo e(translate('Add_New_Field')); ?> </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-4 col-sm-6">
                            <div class="form-group">
                                <label for="method_name" class="title_color"><?php echo e(translate('payment_Method_Name')); ?></label>
                                <input id="method_name" type="text" class="form-control" placeholder="<?php echo e(translate('ex')); ?>: <?php echo e(translate('bkash')); ?>" name="method_name" required value="<?php echo e($data->method_name); ?>">
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="id" value="<?php echo e($data->id); ?>">

                    <div class="input-fields-section" id="input-fields-section">
                        <?php $__currentLoopData = $data->method_fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php ($aRandomNumber = rand()); ?>
                            <div class="row align-items-end" id="<?php echo e($aRandomNumber); ?>">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="input_name" class="title_color"><?php echo e(translate('Title')); ?></label>
                                        <input id="input_name" type="text" name="input_name[]" class="form-control" placeholder="<?php echo e(translate('ex')); ?>: <?php echo e(translate('Bank_Name')); ?>" required value="<?php echo e(ucwords(str_replace('_',' ',$item['input_name']))); ?> ">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="input_data" class="title_color"><?php echo e(translate('Data')); ?></label>
                                        <input id="input_data" type="text" name="input_data[]" class="form-control" placeholder="<?php echo e(translate('ex')); ?>: <?php echo e(translate('ABC_bank')); ?>" required value="<?php echo e($item['input_data']); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-end">
                                            <a href="javascript:" class="btn action-btn btn--danger btn-outline-danger remove-input-fields-group" data-id="<?php echo e($aRandomNumber); ?>" title="Delete" >
                                            <i class="tio-delete-outlined"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header gap-2 flex-wrap">
                    <div class="d-flex align-items-center gap-2">
                        <img width="20" src="<?php echo e(asset('/public/assets/admin/img/payment-card-fill.png')); ?>" alt="">
                        <h5 class="mb-0"><?php echo e(translate('required_Information_from_Customer')); ?></h5>
                    </div>
                    <a href="javascript:"  class="btn btn--primary add-customer-input-fields-group"><i class="tio-add"></i> <?php echo e(translate('Add_New_Field')); ?> </a>
                </div>
                <div class="card-body">
                    <div class="customer-input-fields-section" id="customer-input-fields-section">
                        <?php $__currentLoopData = $data->method_informations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php ($cRandomNumber = rand()); ?>
                            <div class="row align-items-end" id="<?php echo e($cRandomNumber); ?>">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="customer_input" class="title_color"><?php echo e(translate('input_field_Name')); ?></label>
                                        <input id="customer_input" type="text" name="customer_input[]" class="form-control" placeholder="<?php echo e(translate('ex')); ?>: <?php echo e(translate('payment_By')); ?>" required value="<?php echo e(ucwords(str_replace('_',' ',$item['customer_input']))); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="customer_placeholder" class="title_color"><?php echo e(translate('place_Holder')); ?></label>
                                        <input id="customer_placeholder" type="text" name="customer_placeholder[]" class="form-control" placeholder="<?php echo e(translate('ex')); ?>: <?php echo e(translate('enter_name')); ?>" required value="<?php echo e($item['customer_placeholder']); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-between gap-2">
                                            <div class="form-check text-start mb-3">

                                                <label class="form-check-label text-dark" for="<?php echo e($cRandomNumber+1); ?>">
                                                    <input type="checkbox" class="form-check-input" id="<?php echo e($cRandomNumber+1); ?>" name="is_required[]" <?php echo e((isset($item['is_required']) && $item['is_required']) == 1 ? 'checked':''); ?>> <?php echo e(translate('is_Required')); ?> ?
                                                </label>
                                            </div>

                                            <a class="btn action-btn btn--danger btn-outline-danger  remove-input-fields-group" data-id="<?php echo e($cRandomNumber); ?>" title="Delete" >
                                                 <i class="tio-delete-outlined"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <div class="btn--container justify-content-end mt-20">
                <button type="reset" class="btn btn--reset"><?php echo e(translate('Reset')); ?></button>
                <button type="submit"   class="btn btn--primary mb-2"><?php echo e(translate('submit')); ?></button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('script_2'); ?>
<script>
    "use strict"
    $(document).on('click', '.add-input-fields-group', function () {
        let id = Math.floor((Math.random() + 1 )* 9999);
        let new_field = `<div class="row align-items-end" id="`+id+`" style="display: none;">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="input_name" class="title_color"><?php echo e(translate('Title')); ?></label>
                                    <input type="text" name="input_name[]" class="form-control" placeholder="<?php echo e(translate('ex')); ?>: <?php echo e(translate('bank_Name')); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="input_data" class="title_color"><?php echo e(translate('Data')); ?></label>
                                    <input type="text" name="input_data[]" class="form-control" placeholder="<?php echo e(translate('ex')); ?>: <?php echo e(translate('AVC_bank')); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="d-flex justify-content-end">
                                        <a href="javascript:" class="btn action-btn btn--danger btn-outline-danger remove-input-fields-group" data-id="`+id+`" title="Delete" >
                                             <i class="tio-delete-outlined"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>`;

        $('#input-fields-section').append(new_field);
        $('#'+id).fadeIn();
    });

    $(document).on('click', '.add-customer-input-fields-group', function () {

        let id = Math.floor((Math.random() + 1 )* 9999);
        let new_field = `<div class="row align-items-end" id="`+id+`" style="display: none;">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="title_color"><?php echo e(translate('input_field_Name')); ?></label>
                                    <input type="text" name="customer_input[]" class="form-control" placeholder="<?php echo e(translate('ex')); ?>: <?php echo e(translate('payment_By')); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="customer_placeholder" class="title_color"><?php echo e(translate('place_Holder')); ?></label>
                                    <input type="text" name="customer_placeholder[]" class="form-control" placeholder="<?php echo e(translate('ex')); ?>: <?php echo e(translate('enter_name')); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="d-flex justify-content-between gap-2">
                                        <div class="form-check text-start mb-3">

                                            <label class="form-check-label text-dark" for="`+id+1+`">
                                                <input type="checkbox" class="form-check-input" id="`+id+1+`" name="is_required[]"> <?php echo e(translate('is_Required')); ?> ?
                                            </label>
                                        </div>

                                        <a class="btn action-btn btn--danger btn-outline-danger remove-input-fields-group" data-id="`+id+`" title="Delete" >
                                             <i class="tio-delete-outlined"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>`;

        $('#customer-input-fields-section').append(new_field);
        $('#'+id).fadeIn();
    });

    $(document).on('click', '.remove-input-fields-group', function () {
        $('#'+$(this).data('id')).remove();

    });

</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/offline-payment/edit.blade.php ENDPATH**/ ?>