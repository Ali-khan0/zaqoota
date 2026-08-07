<?php $__env->startSection('title',translate('messages.parcel_settings')); ?>

 <?php $__env->startSection('parcel_settings'); ?>
 active
 <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('public/assets/admin/img/parcel.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                    <?php echo e(translate('messages.parcel_settings')); ?>

                </span>
            </h1>
        </div>
        <!-- End Page Header -->

        <div class="card">
            <div class="card-body">
                <form action="<?php echo e(route('admin.parcel.update.settings')); ?>" method="post"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label  class="input-label text-capitalize"><?php echo e(translate('messages.per_km_shipping_charge')); ?>  (<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)</label>
                                <input type="number" min="0" step=".01" placeholder="<?php echo e(translate('messages.per_km_shipping_charge')); ?>" class="form-control" name="parcel_per_km_shipping_charge"
                                    value="<?php echo e($parcelPerKmShippingCharge??''); ?>">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label class="input-label text-capitalize"><?php echo e(translate('messages.minimum_shipping_charge')); ?> (<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)</label>
                                <input type="number" min="0" step=".01" placeholder="<?php echo e(translate('messages.minimum_shipping_charge')); ?>" class="form-control" name="parcel_minimum_shipping_charge"
                                    value="<?php echo e($parcelMinimumShippingCharge??''); ?>">
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="form-group">
                                <label class="input-label text-capitalize"><?php echo e(translate('messages.deliveryman_commission')); ?> (%)</label>
                                <input type="number" min="0" step=".01" placeholder="<?php echo e(translate('messages.deliveryman_commission')); ?>" class="form-control" name="parcel_commission_dm" max="100" value="<?php echo e($parcelCommissionDm??''); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="btn--container justify-content-end">
                        <button type="reset" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                        <button type="<?php echo e(env('APP_MODE')!='demo'?'submit':'button'); ?>"  class="btn btn--primary call-demo"><?php echo e(translate('messages.submit')); ?></button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-12 pt-sm-3">
            <div class="report-card-inner mb-4 pt-3 mw-100">
                <form action="<?php echo e(route('admin.parcel.instruction')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-md-0 mb-3">
                        <div class="mx-1">
                            <h5 class="form-label mb-0">
                                <?php echo e(translate('messages.Add a Delivery Instruction')); ?>

                            </h5>
                        </div>
                    </div>

                    <?php if($language): ?>
                        <ul class="nav nav-tabs nav--tabs mt-3 mb-3 ">
                            <li class="nav-item">
                                <a class="nav-link lang_link1 active"
                                   href="#"
                                   id="default-link1"><?php echo e(translate('Default')); ?></a>
                            </li>
                            <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="nav-item">
                                    <a class="nav-link lang_link1"
                                       href="#"
                                       id="<?php echo e($lang); ?>-link1"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php endif; ?>
                    <div class="row align-items-end">



                        <div class="col-md-10 lang_form1 default-form1">
                            <label class="form-label"><?php echo e(translate('Instruction')); ?> (<?php echo e(translate('Default')); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write the instruction within 191 characters')); ?>">
                                                    <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                                </span></label>
                            <input type="text" class="form-control h--45px" maxlength="191" name="instruction[]"
                                   placeholder="<?php echo e(translate('Ex:_parcel_contains_document')); ?>">
                            <input type="hidden" name="lang[]" value="default">
                        </div>

                        <?php if($language): ?>
                            <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-10 d-none lang_form1" id="<?php echo e($lang); ?>-form1">
                                    <label class="form-label"><?php echo e(translate('Instruction')); ?> (<?php echo e(strtoupper($lang)); ?>)<span class="form-label-secondary" data-toggle="tooltip" data-placement="right" data-original-title="<?php echo e(translate('Write the instruction within 191 characters')); ?>">
                                                    <img src="<?php echo e(asset('public/assets/admin/img/info-circle.svg')); ?>" alt="">
                                                </span></label>
                                    <input type="text" class="form-control h--45px" maxlength="191" name="instruction[]"
                                           placeholder="<?php echo e(translate('Ex:_parcel_contains_document')); ?>">
                                    <input type="hidden" name="lang[]" value="<?php echo e($lang); ?>">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>


                        <div class="col-md-auto">
                            <button type="submit" class="btn btn--primary h--45px btn-block"><?php echo e(translate('messages.Add Now')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body mb-3">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-md-0 mb-3">
                    <div class="mx-1">
                        <h5 class="form-label mb-5">
                            <?php echo e(translate('Delivery Instruction List')); ?>

                        </h5>
                    </div>
                </div>




                <!-- Table -->
                <div class="card-body p-0">
                    <div class="table-responsive datatable-custom">
                        <table id="columnSearchDatatable"
                               class="table table-borderless table-thead-bordered table-align-middle" data-hs-datatables-options='{
                        "isResponsive": false,
                        "isShowPaging": false,
                        "paging":false,
                    }'>
                            <thead class="thead-light">
                            <tr>
                                <th class="border-0"><?php echo e(translate('messages.SL')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.Instruction')); ?></th>
                                <th class="border-0"><?php echo e(translate('messages.status')); ?></th>
                                <th class="border-0 text-center"><?php echo e(translate('messages.action')); ?></th>
                            </tr>
                            </thead>

                            <tbody id="table-div">
                            <?php $__currentLoopData = $instructions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$instruction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key+$instructions->firstItem()); ?></td>

                                    <td>
                                <span class="d-block font-size-sm text-body" title="<?php echo e($instruction->instruction); ?>">
                                    <?php echo e(Str::limit($instruction->instruction, 50,'...')); ?>

                                </span>
                                    </td>
                                    <td>
                                        <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox<?php echo e($instruction->id); ?>">
                                            <input type="checkbox" data-url="<?php echo e(route('admin.parcel.instruction_status',[$instruction['id'],$instruction->status?0:1])); ?>" class="toggle-switch-input redirect-url" id="stocksCheckbox<?php echo e($instruction->id); ?>" <?php echo e($instruction->status?'checked':''); ?>>
                                            <span class="toggle-switch-label">
                                        <span class="toggle-switch-indicator"></span>
                                    </span>
                                        </label>
                                    </td>

                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a class="btn btn-sm btn--primary btn-outline-primary action-btn edit-instruction"
                                               title="<?php echo e(translate('messages.edit')); ?>" data-id="<?php echo e($instruction['id']); ?>"
                                               data-toggle="modal"   data-target="#add_update_instruction_<?php echo e($instruction->id); ?>"
                                            ><i class="tio-edit"></i>
                                            </a>


                                            <a class="btn btn-sm btn--danger btn-outline-danger action-btn form-alert" href="javascript:"
                                               data-id="instruction-<?php echo e($instruction['id']); ?>" data-message="<?php echo e(translate('Want to delete this instruction ?')); ?>"
                                               title="<?php echo e(translate('messages.delete')); ?>">
                                                <i class="tio-delete-outlined"></i>
                                            </a>
                                            <form action="<?php echo e(route('admin.parcel.instruction_delete',[$instruction['id']])); ?>"
                                                  method="post" id="instruction-<?php echo e($instruction['id']); ?>">
                                                <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Modal -->
                                <div class="modal fade" id="add_update_instruction_<?php echo e($instruction->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"><?php echo e(translate('messages.Instruction_Update')); ?></label></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="<?php echo e(route('admin.parcel.instruction_edit')); ?>" method="post">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('put'); ?>

                                                    <?php ($instruction=  \App\Models\ParcelDeliveryInstruction::withoutGlobalScope('translate')->with('translations')->find($instruction->id)); ?>

                                                    <ul class="nav nav-tabs nav--tabs mb-3 border-0">
                                                        <li class="nav-item">
                                                            <a class="nav-link update-lang_link add_active active"
                                                               href="#"
                                                               id="default-link"><?php echo e(translate('Default')); ?></a>
                                                        </li>
                                                        <?php if($language): ?>
                                                            <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <li class="nav-item">
                                                                    <a class="nav-link update-lang_link"
                                                                       href="#"
                                                                       data-reason-id="<?php echo e($instruction->id); ?>"
                                                                       id="<?php echo e($lang); ?>-link"><?php echo e(\App\CentralLogics\Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')'); ?></a>
                                                                </li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    </ul>
                                                    <input type="hidden" name="instruction_id"  value="<?php echo e($instruction->id); ?>" />

                                                    <div class="form-group mb-3 add_active_2  update-lang_form" id="default-form_<?php echo e($instruction->id); ?>">
                                                        <label class="form-label"><?php echo e(translate('Instruction')); ?> (<?php echo e(translate('messages.default')); ?>) </label>
                                                        <input class="form-control" name='instruction[]' maxlength="191" value="<?php echo e($instruction?->getRawOriginal('instruction')); ?>" type="text">
                                                        <input type="hidden" name="lang1[]" value="default">
                                                    </div>
                                                    <?php if($language): ?>
                                                        <?php $__empty_1 = true; $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                <?php
                                                                if($instruction?->translations){
                                                                    $translate = [];
                                                                    foreach($instruction?->translations as $t)
                                                                    {
                                                                        if($t->locale == $lang && $t->key=="instruction"){
                                                                            $translate[$lang]['instruction'] = $t->value;
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                            <div class="form-group mb-3 d-none update-lang_form" id="<?php echo e($lang); ?>-langform_<?php echo e($instruction->id); ?>">
                                                                <label class="form-label"><?php echo e(translate('Instruction')); ?> (<?php echo e(strtoupper($lang)); ?>)</label>
                                                                <input class="form-control" name='instruction[]' maxlength="191" value="<?php echo e($translate[$lang]['instruction'] ?? null); ?>"  type="text">
                                                                <input type="hidden" name="lang1[]" value="<?php echo e($lang); ?>">
                                                            </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <?php endif; ?>
                                                <?php endif; ?>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(translate('Close')); ?></button>
                                                <button type="submit" class="btn btn-primary"><?php echo e(translate('Save_changes')); ?></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php if(count($instructions) === 0): ?>
                            <div class="empty--data">
                                <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                                <h5>
                                    <?php echo e(translate('no_data_found')); ?>

                                </h5>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="card-footer pt-0 border-0">
                        <div class="page-area px-4 pb-3">
                            <div class="d-flex align-items-center justify-content-end">
                                <div>
                                    <?php echo $instructions->links(); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Table -->

        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
<script src="<?php echo e(asset('public/assets/admin/js/view-pages/parcel_delivery_setup.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/parcel/settings.blade.php ENDPATH**/ ?>