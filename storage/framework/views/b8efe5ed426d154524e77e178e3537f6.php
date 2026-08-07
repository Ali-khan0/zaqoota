<?php $__env->startSection('title','Advertisement Requests'); ?>
<?php $__env->startSection('advertisement'); ?>
active
<?php $__env->stopSection(); ?>
<?php $__env->startSection('advertisement_request'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <!-- Title -->
    <h1 class="page-header-title mb-3 d-flex align-items-center gap-2">
        <img src="<?php echo e(asset('public/assets/admin/img/advertisement.png')); ?>" alt="">
        <?php echo e(translate('messages.Advertisement_Requests')); ?>

        <span class="badge badge-soft-dark ml-2"><?php echo e($count); ?></span>
    </h1>

    <!-- Nav Menus -->
    <ul class="nav nav-tabs border-0 nav--tabs nav--pills mb-4">
        <li class="nav-item">
            <a class="nav-link  <?php echo e(!request()?->type  ? 'active' : ''); ?>" href="<?php echo e(route('admin.advertisement.requestList')); ?>"><?php echo e(translate('New_Request')); ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo e(request()?->type == 'update-requests' ? 'active' : ''); ?> " href="<?php echo e(route('admin.advertisement.requestList',['type'=> 'update-requests'])); ?>"><?php echo e(translate('Update_Request')); ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo e(request()?->type == 'denied-requests' ? 'active' : ''); ?> " href="<?php echo e(route('admin.advertisement.requestList',['type'=> 'denied-requests'])); ?>"><?php echo e(translate('Denied_Requests')); ?></a>
        </li>
    </ul>



    <div class="card">


        <div class="card-header py-2 border-0">
            <div class="search--button-wrapper">
                <h5 class="card-title"> <?php echo e(translate('messages.Advertisement')); ?> <span class="badge badge-soft-dark ml-2"><?php echo e($adds->total()); ?></span></h5>
                <form>
                    <!-- Search -->
                    <div class="input--group input-group input-group-merge input-group-flush">
                        <input id="datatableSearch" type="search" name="search" value="<?php echo e(request()?->search ?? null); ?>" class="form-control" placeholder="<?php echo e(translate('Search by ads ID or store name')); ?>" aria-label="<?php echo e(translate('messages.search_here')); ?>">
                        <input type="hidden" value="<?php echo e(request()?->type); ?>" name='type'>
                        <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                    </div>
                    <!-- End Search -->
                </form>

            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive datatable-custom">
                <table class="font-size-sm table table-borderless table-thead-bordered table-nowrap table-align-middle card-table min-h-225px">
                    <thead class="thead-light">
                        <tr>
                            <th><?php echo e(translate('sl')); ?></th>
                            <th><?php echo e(translate('Ads ID')); ?></th>
                            <th ><?php echo e(translate('Ads Title')); ?></th>
                            <th><?php echo e(translate('Store Info')); ?></th>
                            <th><?php echo e(translate('Ads Type')); ?></th>
                            <th><?php echo e(translate('Duration')); ?></th>
                            <th><?php echo e(translate('Action')); ?></th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php $__currentLoopData = $adds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $add): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <tr>

                            <td><?php echo e($key+$adds->firstItem()); ?></td>
                            <td> <a href="<?php echo e(route('admin.advertisement.show',[$add->id ,'request_page_type'=> request()?->type ?? 'pending-requests'])); ?>"> <?php echo e($add->id); ?></a></td>
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
                                <div class="dropdown dropdown-2">
                                    <button type="button" class="bg-transparent border rounded px-2 py-1 title-color" data-toggle="dropdown" aria-expanded="false">
                                        <i class="tio-more-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu "dir="ltr">
                                        <a class="dropdown-item d-flex gap-2 align-items-center" href="<?php echo e(route('admin.advertisement.show',[$add->id ,'request_page_type'=> request()?->type ?? 'pending-requests'])); ?>">
                                            <i class="tio-visible-outlined"></i>
                                            <?php echo e(translate('View Ads')); ?>

                                        </a>

                                        <?php if($add->status == 'denied' || $add->active == 0): ?>
                                        <a class="dropdown-item d-flex gap-2 align-items-center" href="<?php echo e(route('admin.advertisement.edit',[$add->id ,'request_page_type'=> request()?->type ?? 'pending-requests'])); ?>">
                                            <i class="tio-edit"></i>
                                            <?php echo e(translate('Edit & Resubmit Ads')); ?>

                                        </a>


                                        <?php else: ?>
                                        <a class="dropdown-item d-flex gap-2 align-items-center" href="<?php echo e(route('admin.advertisement.edit',[$add->id ,'request_page_type'=> request()?->type ?? 'pending-requests'])); ?>">
                                            <i class="tio-edit"></i>
                                            <?php echo e(translate('Edit Ads')); ?>

                                        </a>
                                        <?php endif; ?>

                                        <?php if($add->status == 'pending'): ?>


                                        <a class="dropdown-item d-flex gap-2 align-items-center approve_add"

                                        data-is_expired="<?php echo e($add->active); ?>"
                                        data-approve_url=<?php echo e(route('admin.advertisement.status',['status' => 'approved' ,'id' => $add->id ,'approved' => 1])); ?>

                                        data-edit_url=<?php echo e(route('admin.advertisement.edit',[$add->id ,'request_page_type'=> isset($request_page_type) ])); ?>


                                        href="#">
                                            <i class="tio-done"></i>
                                            <?php echo e(translate('Approve')); ?>

                                        </a>

                                        <a class="dropdown-item d-flex gap-2 align-items-center new-dynamic-submit-model" id="data-add-<?php echo e($add->id); ?>" data-id="data-add-<?php echo e($add->id); ?>" data-title="<?php echo e(translate('Are you sure you want to deny the request?')); ?>" data-text="<p><?php echo e(translate('You will lost the Store ads request.')); ?></p>" data-image="<?php echo e(asset('public/assets/admin/img/modal/deny.png')); ?>" data-type="deny" data-btn_class="btn-primary" data-2nd_btn_text="<?php echo e(translate('messages.Cancel')); ?>" href="#">
                                            <i class="tio-clear-circle-outlined"></i>
                                            <?php echo e(translate('Cancel_Ads')); ?>

                                        </a>

                                        <form id="data-add-<?php echo e($add->id); ?>_form" action="<?php echo e(route('admin.advertisement.status',['status' => 'paused' ,'id' => $add->id])); ?>" method="get">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('get'); ?>
                                            <input type="hidden" name="cancellation_note" id="data-add-<?php echo e($add?->id); ?>_note">
                                            <input type="hidden" name="status" value="denied">
                                            <input type="hidden" name="id" value="<?php echo e($add->id); ?>">
                                        </form>






                                        <?php endif; ?>

                                        <?php if($add->status != 'pending'): ?>
                                        <a class="dropdown-item d-flex gap-2 align-items-center" href="<?php echo e(route('admin.advertisement.destroy',$add->id)); ?>">
                                            <i class="tio-delete"></i>
                                            <?php echo e(translate('Delete_Ads')); ?>

                                        </a>
                                        <?php endif; ?>
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
                            <?php echo $adds->withQueryString()->links(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="approve-model1">
    <div class="modal-dialog modal-dialog-centered status-warning-modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true" class="tio-clear"></span>
                </button>
            </div>
            <div class="modal-body pb-5 pt-0">
                <div class="max-349 mx-auto mb-20">
                    <div>
                        <div class="text-center">
                            <img src="<?php echo e(asset('public/assets/admin/img/modal/timeout.png')); ?>" class="mb-20">
                            <h5 class="modal-title"></h5>
                        </div>
                        <div class="text-center" >
                            <h3 > <?php echo e(translate('This advertisement is already expired.')); ?></h3>
                            <div > <p><?php echo e(translate('After approval this Advertisement will automatically show in the expired list as the duration is already over.')); ?></h3></p></div>
                        </div>

                        </div>

                    <div class="btn--container justify-content-center">
                            <a href="#" id="edit_url1"  class="btn btn-success min-w-120" ><?php echo e(translate("Edit & Approve")); ?></a>
                            <a href="#" id="approve_url1"  type="button"  class="btn btn--secondary  min-w-120"><?php echo e(translate('Only Approve')); ?></a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<div class="modal fade" id="confirm-approve-model">
    <div class="modal-dialog modal-dialog-centered status-warning-modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true" class="tio-clear"></span>
                </button>
            </div>
            <div class="modal-body pb-5 pt-0">
                <div class="max-349 mx-auto mb-20">
                    <div>
                        <div class="text-center">
                            <img width="80" src="<?php echo e(asset('public/assets/admin/img/modal/tick.png')); ?>" class="mb-20">
                            <h5 class="modal-title"></h5>
                        </div>
                        <div class="text-center" >
                            <h3 > <?php echo e(translate('Are_you_sure_?')); ?></h3>
                            <div > <p><?php echo e(translate('After approval this Advertisement will show in The User App & Websites.')); ?></h3></p></div>
                        </div>

                        </div>

                    <div class="btn--container justify-content-center">
                        <button data-dismiss="modal" class="btn btn--secondary min-w-120" ><?php echo e(translate("Not_Now")); ?></button>
                        <a href="#" id="approve_url" type="button"  class="btn btn-primary min-w-120"><?php echo e(translate('Approve')); ?></a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>


<script>
    $(document).on("click", ".approve_add", function () {
    const edit_url = $(this).data("edit_url");
    const approve_url = $(this).data("approve_url");
    const is_expired = $(this).data("is_expired");


    if(is_expired !== 0){
        $("#approve_url").attr("href", approve_url);
        $("#confirm-approve-model").modal('show');
    }
    else{
        $("#approve_url1").attr("href", approve_url);
        $("#edit_url1").attr("href", edit_url);
        $("#approve-model1").modal('show');

    }




});
</script>


<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/advertisement/request-list.blade.php ENDPATH**/ ?>