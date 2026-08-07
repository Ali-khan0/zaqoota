<?php $__env->startSection('title', translate('Advertisement List')); ?>
<?php $__env->startSection('advertisement'); ?>
active
<?php $__env->stopSection(); ?>
<?php $__env->startSection('advertisement_list'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid overflow-hidden">



    <?php if($ads_count == 0): ?>




    <h1 class="page-header-title mb-3"><?php echo e(translate('Advertisement List')); ?></h1>

    <div class="card">
        <div class="card-body">
            <div class="text-center max-w-700 mb-10 mt-10 mx-auto pt-5">
                <img src="<?php echo e(asset('public/assets/admin/img/advertisement-list.png')); ?>" class="mw-100 mb-3" alt="">
                <h4 class="mb-2"><?php echo e(translate('Advertisement List')); ?></h4>
                <p class="mb-4"><?php echo e(translate('Create an advertisement for your targeted audience, as none has been created yet.')); ?></p>
                
                
            </div>
        </div>
    </div>



    <?php else: ?>




    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="page-header-title d-flex align-items-center gap-2">
            <img src="<?php echo e(asset('public/assets/admin/img/advertisement.png')); ?>" alt="">
            <?php echo e(translate('messages.Ads_list')); ?>

            <span class="badge badge-soft-dark ml-2"><?php echo e($adds->total()); ?></span>
        </h1>
        <a href="<?php echo e(route('admin.advertisement.create')); ?>" class="btn btn-primary">  <i class="tio-add"></i> <?php echo e(translate('New Advertisement')); ?></a>
    </div>
    <!-- Title -->


    <div class="card">

        <div class="card-header py-2 border-0">
            <div class="search--button-wrapper">
            <h5 class="card-title"></h5>
            <form >
                <!-- Search -->
                <div class="input--group input-group input-group-merge input-group-flush">
                    <input id="datatableSearch" type="search" name="search"  value="<?php echo e(request()?->search ?? null); ?>"  class="form-control" placeholder="<?php echo e(translate('Search by ads ID or store name')); ?>" aria-label="<?php echo e(translate('messages.search_here')); ?>">
                    <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                </div>
                <!-- End Search -->
            </form>
            <div class="select-item min-w-135px">
                <select name="subscription_list" class="form-control js-select2-custom set-filter"
                data-url="<?php echo e(url()->full()); ?>" data-filter="ads_type">
                    <option  value="all"><?php echo e(translate('messages.All Ads')); ?></option>
                    <option <?php echo e(request()?->ads_type =='running'?'selected':''); ?> value="running"><?php echo e(translate('running')); ?> </option>
                    <option <?php echo e(request()?->ads_type =='paused'?'selected':''); ?> value="paused"><?php echo e(translate('paused')); ?> </option>
                    <option <?php echo e(request()?->ads_type =='approved'?'selected':''); ?> value="approved"><?php echo e(translate('approved')); ?> </option>
                    <option <?php echo e(request()?->ads_type =='expired'?'selected':''); ?> value="expired"><?php echo e(translate('expired')); ?> </option>
                </select>
            </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive datatable-custom">
                <table class="font-size-sm table table-borderless table-thead-bordered table-nowrap table-align-middle card-table min-h-225px">
                    <thead class="thead-light">
                        <tr>
                            <th><?php echo e(translate('sl')); ?></th>
                            <th ><?php echo e(translate('Ads ID')); ?></th>
                            <th ><?php echo e(translate('Ads Title')); ?></th>
                            <th ><?php echo e(translate('Store Info')); ?></th>
                            <th ><?php echo e(translate('Ads Type')); ?></th>
                            <th ><?php echo e(translate('Duration')); ?></th>
                            <th ><?php echo e(translate('Status')); ?></th>
                            <th ><?php echo e(translate('Priority')); ?></th>
                            <th ><?php echo e(translate('Action')); ?></th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php $__currentLoopData = $adds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $add): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <tr>

                            <td><?php echo e($key+$adds->firstItem()); ?></td>
                            <td> <a href="<?php echo e(route('admin.advertisement.show',$add->id)); ?>"> <?php echo e($add->id); ?></a></td>
                            <td><?php echo e(Str::limit($add->title, 20)); ?></td>
                            <td>
                                <a class="media align-items-center text-body" href="<?php echo e(route('admin.store.view', $add?->store_id)); ?>">
                                    <img class="avatar avatar-lg mr-3" src="<?php echo e($add->store['logo_full_url'] ?? asset('public/assets/admin/img/100x100/food-default-image.png')); ?>" alt="">
                                    <div class="media-body">
                                        <h5 class="mb-0"><?php echo e($add?->store?->name); ?></h5>
                                        <small class="text-body"><?php echo e($add?->store?->email); ?></small>
                                    </div>
                                </a>
                            </td>

                            <td><?php echo e(translate($add?->add_type)); ?></td>
                            <td>
                                <?php echo e(\App\CentralLogics\Helpers::date_format($add->start_date)); ?> - <br> <?php echo e(\App\CentralLogics\Helpers::date_format($add->end_date)); ?>

                            </td>
                            <td>
                                <?php if($add->status == 'approved' && $add->active == 1 ): ?>
                                <label class="badge badge-soft-primary rounded-pill"><?php echo e(translate('messages.running')); ?></label>
                                <?php elseif($add->status == 'approved' && $add->active == 2 ): ?>
                                <label class="badge badge-soft-success rounded-pill"><?php echo e(translate('messages.approved')); ?></label>
                                <?php elseif($add->status == 'paused' && $add->active == 1 ): ?>
                                <label class="badge badge-soft-warning rounded-pill"><?php echo e(translate('messages.paused')); ?></label>
                                <?php elseif(in_array($add->status ,['denied','expired'] )): ?>
                                <label class="badge badge-soft-danger rounded-pill"><?php echo e(translate($add->status)); ?></label>
                                <?php elseif($add->active == 0): ?>
                                <label class="badge badge-soft-secondary rounded-pill"><?php echo e(translate('messages.Expired')); ?></label>
                                <?php else: ?>
                                <label class="badge badge-soft-info rounded-pill"><?php echo e(translate($add->status)); ?></label>
                                <?php endif; ?>

                            </td>
                            <td>
                                <?php if( in_array($add->status ,['denied','expired']) || $add->active == 0): ?>
                                <div class="d-flex align-items-center gap-2 ml-3" data-toggle="tooltip" title="<?php echo e(translate('Expired & Denied ads has no priority.')); ?>">
                                    <span><?php echo e(translate('N/A')); ?></span> <img src="<?php echo e(asset('public/assets/admin/img/na.png')); ?>" alt="">
                                </div>
                                <?php else: ?>

                                <select id="select_option_<?php echo e($add->id); ?>" data-priority_old_value="<?php echo e($add?->priority); ?>" data-prority_id="<?php echo e($add->id); ?>" class="form-control w-70px p-0 h-30px js-select2-custom update-priority">
                                    <option value="<?php echo e($add?->priority == null ||  $add?->priority == 0 ?  '' : $add?->priority); ?>"><?php echo e($add?->priority == null ||  $add?->priority == 0 ?  translate('N/A') : $add?->priority); ?> </option>
                                    <?php for($i = 1; $i <= $total_adds; $i++): ?>
                                    <?php if($add?->priority != $i ): ?>
                                    <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                                    <?php endif; ?>
                                    <?php endfor; ?>
                                    <?php if( $add?->priority !== null): ?>
                                        <option value=""><?php echo e(translate('N/A')); ?> </option>
                                    <?php endif; ?>
                                </select>
                                <?php endif; ?>



                            </td>
                            <td>
                                <div class="dropdown dropdown-2">
                                    <button type="button" class="bg-transparent border rounded px-2 py-1 title-color" data-toggle="dropdown" aria-expanded="false">
                                        <i class="tio-more-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu" dir="ltr">
                                        <a class="dropdown-item d-flex gap-2 align-items-center" href="<?php echo e(route('admin.advertisement.show',$add->id)); ?>">
                                            <i class="tio-visible-outlined"></i>
                                            <?php echo e(translate('View Ads')); ?>

                                        </a>

                                        <?php if($add->active == 0): ?>
                                        <a class="dropdown-item d-flex gap-2 align-items-center" href="<?php echo e(route('admin.advertisement.edit',$add->id)); ?>">
                                            <i class="tio-edit"></i>
                                            <?php echo e(translate('Edit & Resubmit Ads')); ?>

                                            </a>

                                            <?php else: ?>
                                            <a class="dropdown-item d-flex gap-2 align-items-center" href="<?php echo e(route('admin.advertisement.edit',$add->id)); ?>">
                                                <i class="tio-edit"></i>
                                                <?php echo e(translate('Edit Ads')); ?>

                                            </a>
                                        <?php endif; ?>




                                        <?php if($add->status == 'paused'): ?>
                                            <a class="dropdown-item d-flex gap-2 align-items-center new-dynamic-submit-model"


                                            id="data-add-<?php echo e($add->id); ?>"
                                            data-id="data-add-<?php echo e($add->id); ?>"

                                            data-title="<?php echo e(translate('Are you sure you want to Resume the request?')); ?>"
                                            data-text="<p><?php echo e(translate('This ad will be run again and will show in the user app & websites.')); ?></p>"
                                            data-image="<?php echo e(asset('public/assets/admin/img/modal/resume.png')); ?>"
                                            data-type="resume"
                                            data-btn_class = "btn-primary"


                                            href="#">
                                                <i class="tio-pause-circle"></i>
                                                <?php echo e(translate('Resume_Ads')); ?>

                                            </a>

                                            <form  id="data-add-<?php echo e($add->id); ?>_form" action="<?php echo e(route('admin.advertisement.status',['status' => 'approved' ,'id' => $add->id])); ?>" method="get">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('get'); ?>
                                                <input type="hidden"  name="status" value="approved">
                                                <input type="hidden"  name="id" value="<?php echo e($add->id); ?>">
                                            </form>




                                        <?php elseif($add->status == 'approved' && $add->active == 1): ?>
                                        <a class="dropdown-item d-flex gap-2 align-items-center new-dynamic-submit-model"
                                        id="data-add-<?php echo e($add->id); ?>"
                                        data-id="data-add-<?php echo e($add->id); ?>"
                                        data-title="<?php echo e(translate('Are you sure you want to Pause the request?')); ?>"
                                        data-text="<p><?php echo e(translate('This ad will be pause and not show in the user app & websites.')); ?></p>"
                                        data-image="<?php echo e(asset('public/assets/admin/img/modal/pause.png')); ?>"
                                        data-type="pause"

                                        href="#">
                                            <i class="tio-pause-circle"></i>
                                            <?php echo e(translate('Pause_Ads')); ?>

                                            </a>

                                            <form  id="data-add-<?php echo e($add->id); ?>_form" action="<?php echo e(route('admin.advertisement.status',['status' => 'paused' ,'id' => $add->id])); ?>" method="get">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('get'); ?>
                                                <input type="hidden"  name="pause_note" id="data-add-<?php echo e($add?->id); ?>_note">
                                                <input type="hidden"  name="status" value="paused">
                                                <input type="hidden"  name="id" value="<?php echo e($add->id); ?>">
                                            </form>
                                        <?php endif; ?>





                                        <a class="dropdown-item d-flex gap-2 align-items-center" href="<?php echo e(route('admin.advertisement.copyAdd', $add->id)); ?>" >
                                            <i class="tio-copy"></i>
                                            <?php echo e(translate('Copy_Ads')); ?>

                                            </a>


                                        <a class="dropdown-item d-flex gap-2 align-items-center new-dynamic-submit-model"
                                        id="delete-add-<?php echo e($add->id); ?>"
                                            data-id="delete-add-<?php echo e($add->id); ?>"
                                            <?php if($add->status != 'paused' && $add->active == 1): ?>
                                                data-title="<?php echo e(translate('You can’t delete the ad')); ?>"
                                                data-text="<p><?php echo e(translate('This Advertisement is currently running, To delete this ad from the list, please  resume the Ad first . Once the status is updated, you can proceed with deletion')); ?></p>"
                                                data-image="<?php echo e(asset('public/assets/admin/img/modal/package-status-disable.png')); ?>"
                                                data-type="warning"
                                            <?php else: ?>
                                                data-type="delete"
                                                data-title="<?php echo e(translate('Confirm Ad Deletion')); ?>"
                                                data-text="<p><?php echo e(translate('Deleting this ad will remove it permanently. Are you sure you want to proceed?')); ?></p>"
                                                data-image="<?php echo e(asset('public/assets/admin/img/modal/delete-icon.png')); ?>"
                                            <?php endif; ?>
                                            >
                                            <i class="tio-delete"></i>
                                            <?php echo e(translate('Delete_Ads')); ?>

                                            </a>
                                            <form  id="delete-add-<?php echo e($add->id); ?>_form" action="<?php echo e(route('admin.advertisement.destroy',$add->id)); ?>" method="post">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('delete'); ?>
                                            </form>



                                    </ul>
                                </div>
                            </td>
                        </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php if(count($adds) === 0): ?>
                <div class="empty--data">
                    <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                    <h5>
                        <?php echo e(translate('no_data_found')); ?>

                    </h5>
                </div>
                <?php endif; ?>
                <div class="page-area px-4 pb-3">
                    <div class="d-flex align-items-center justify-content-end">
                        <div>
                            <?php echo $adds->links(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php endif; ?>


</div>


<div class="modal fade" id="priority-update-modal">
    <div class="modal-dialog modal-dialog-centered status-warning-modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true" class="tio-clear"></span>
                </button>
            </div>
            <div class="modal-body pb-5 pt-0">
                <form action="<?php echo e(route('admin.advertisement.priority')); ?>" method="get">
                <div class="max-349 mx-auto mb-20">
                    <div>
                        <div class="text-center">
                            <img src="<?php echo e(asset('public/assets/admin/img/modal/package-status-disable.png')); ?>" class="mb-20">
                            <h5 class="modal-title" id="toggle-title"></h5>
                        </div>
                        <div class="text-center" id="toggle-message">
                            <h3 ><?php echo e(translate('Are_you_sure_you_want_to_Priority_of_this_Advertisement?')); ?></h3>
                        </div>
                        <input id="update_priority_value"   name="priority_value" type="hidden">
                        <input id="update_priority_id" name="priority_id" type="hidden">
                        <input id="update_priority_old_value"  type="hidden">
                        </div>

                    <div class="btn--container justify-content-center mt-3">
                        <button data-dismiss="modal" type="reset" id="reset_btn" class="btn btn--cancel" ><?php echo e(translate("Not_Now")); ?></button>
                        <button type="sbmit" class="btn btn-primary min-w-120"><?php echo e(translate('Yes')); ?></button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>





<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
<script>
    $(document).ready(function() {


    $('.update-priority').on('change', function() {


        let update_priority_value = $(this).val();
        let update_priority_old_value = $(this).data('priority_old_value');
        let update_priority_id = $(this).data('prority_id');

        $('#update_priority_value').val(update_priority_value)
        $('#update_priority_old_value').val(update_priority_old_value)
        $('#update_priority_id').val(update_priority_id)
        $('#priority-update-modal').modal('show')
    });
    $('#reset_btn').on('click', function() {

        $('#update_priority_id').val()

        $('#select_option_'+$('#update_priority_id').val()).val( $('#update_priority_old_value').val()
        ).trigger('change');

    });




});

</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/advertisement/list.blade.php ENDPATH**/ ?>