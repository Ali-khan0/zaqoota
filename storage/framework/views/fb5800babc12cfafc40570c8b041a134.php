<?php $__env->startSection('title',translate('messages.Vehicle_List')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title"><i class="tio-car"></i> <?php echo e(translate('messages.vehicles_category_list')); ?> <span class="badge badge-soft-dark ml-2" id="itemCount"><?php echo e($vehicles->total()); ?></span></h1>
                </div>

                <div class="col-sm-auto">
                    <a class="btn btn--primary" href="<?php echo e(route('admin.users.delivery-man.vehicle.create')); ?>">
                        <i class="tio-add"></i> <?php echo e(translate('messages.add_vehicle_category')); ?>

                    </a>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">
                <!-- Card -->
                <div class="card">
                    <div class="card-header py-2 border-0">
                        <div class="search--button-wrapper">
                            <h5 class="card-title"></h5>
                            <form id="search-form">
                                <!-- Search -->
                                <div class="input--group input-group input-group-merge input-group-flush">
                                    <input id="datatableSearch" type="search" name="search"  value="<?php echo e(request()?->search); ?>"  class="form-control" placeholder="<?php echo e(translate('Ex_:_Search_by_type...')); ?>" aria-label="Search here">
                                    <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>
                                </div>
                                <!-- End Search -->
                            </form>
                            <?php if(request()->get('search')): ?>
                            <button type="reset" class="btn btn--primary ml-2 location-reload-to-base" data-url="<?php echo e(url()->full()); ?>"><?php echo e(translate('messages.reset')); ?></button>
                            <?php endif; ?>

                        </div>
                    </div>
                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table id="columnSearchDatatable"
                               class="font-size-sm table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                               data-hs-datatables-options='{
                                 "order": [],
                                 "orderCellsTop": true,
                                 "paging":false
                               }'>
                            <thead class="thead-light">
                            <tr>
                                <th><?php echo e(translate('messages.sl')); ?></th>
                                <th ><?php echo e(translate('messages.Type')); ?></th>
                                <th ><?php echo e(translate('messages.Total_Deliveryman')); ?></th>
                                <th ><?php echo e(translate('messages.minimum_coverage_area')); ?> (<?php echo e(translate('messages.km')); ?>) </th>
                                <th ><?php echo e(translate('messages.Maximum_coverage_area')); ?> (<?php echo e(translate('messages.km')); ?>)</th>
                                <th ><?php echo e(translate('messages.Extra_charges')); ?>  (<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)</th>
                                <th><?php echo e(translate('messages.status')); ?></th>
                                <th class="text-center"><?php echo e(translate('messages.action')); ?></th>
                            </tr>
                            </thead>

                            <tbody id="set-rows">
                            <?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key+$vehicles->firstItem()); ?></td>
                                    <td>
                                        <span class="d-block text-body"><a href="<?php echo e(route('admin.users.delivery-man.vehicle.view',[$vehicle->id])); ?>"><?php echo e(Str::limit($vehicle['type'],25, '...')); ?></a>
                                        </span>
                                    </td>
                                    <td>
                                        <?php echo e($vehicle->delivery_man_count); ?>

                                    </td>
                                    <td>
                                        <span class="bg-gradient-light text-dark">
                                            <?php echo e($vehicle->starting_coverage_area); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <span class="bg-gradient-light text-dark">
                                            <?php echo e($vehicle->maximum_coverage_area); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <span class="bg-gradient-light text-dark">
                                         <?php echo e(\App\CentralLogics\Helpers::format_currency($vehicle->extra_charges)); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox<?php echo e($vehicle->id); ?>">
                                            <input type="checkbox"
                                            data-id="statusCheckbox<?php echo e($vehicle->id); ?>"
                                            data-type="status"
                                            data-image-on="<?php echo e(asset('/public/assets/admin/img/modal/mail-success.png')); ?>"
                                            data-image-off="<?php echo e(asset('/public/assets/admin/img/modal/mail-warning.png')); ?>"
                                            data-title-on="<?php echo e(translate('By_Turning_ON_Vehicle_Category!')); ?>"
                                            data-title-off="<?php echo e(translate('By_Turning_OFF_Vehicle_Category!')); ?>"
                                            data-text-on="<p><?php echo e(translate('Turned_on_this_vehicle_category_extra_charge_will_be_added_on_the_delivery_charge_and_this_categories_deliverymen_can_receives_the_order.')); ?></p>"
                                            data-text-off="<p><?php echo e(translate('Turned_off_this_vehicle_category_extra_charge_will_not_be_added_on_the_delivery_charge_and_this_categories_deliverymen_can_not_receives_the_order')); ?></p>"
                                            class="toggle-switch-input dynamic-checkbox" id="stocksCheckbox<?php echo e($vehicle->id); ?>" <?php echo e($vehicle->status?'checked':''); ?>>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </td>

                            <form action="<?php echo e(route('admin.users.delivery-man.vehicle.status',[$vehicle['id'],$vehicle->status?0:1])); ?>"
                                method="get" id="statusCheckbox<?php echo e($vehicle->id); ?>_form">
                                </form>
                                    <td>
                                        <div class="btn--container justify-content-center">
                                            <a href="#"
                                            data-id="<?php echo e($vehicle->id); ?>"
                                            data-vehicle_type="<?php echo e($vehicle->type); ?>"
                                            data-status="<?php echo e($vehicle->status); ?>"
                                            data-starting_coverage_area="<?php echo e($vehicle->starting_coverage_area); ?>"
                                            data-maximum_coverage_area="<?php echo e($vehicle->maximum_coverage_area); ?>"
                                            data-extra_charges="<?php echo e($vehicle->extra_charges); ?>"
                                            data-edit_button="<?php echo e(route('admin.users.delivery-man.vehicle.edit',[$vehicle['id']])); ?>"
                                            data-delete_button="vehicle-<?php echo e($vehicle['id']); ?>"
                                            class="btn action-btn btn--warning btn-outline-warning vehicle-info-show" ><i class="tio-visible"></i>
                                            </a>
                                            <a class="btn btn-sm btn--primary btn-outline-primary action-btn"
                                                href="<?php echo e(route('admin.users.delivery-man.vehicle.edit',[$vehicle['id']])); ?>" title="<?php echo e(translate('messages.edit_vehicle_category')); ?>"><i class="tio-edit"></i>
                                            </a>
                                            <a class="btn btn-sm btn--danger btn-outline-danger action-btn form-alert" href="javascript:"
                                                data-id="vehicle-<?php echo e($vehicle['id']); ?>" data-message="<?php echo e(translate('messages.Want_to_delete_this_vehicle_category')); ?>" title="<?php echo e(translate('messages.delete_vehicle_category')); ?>"><i class="tio-delete-outlined"></i>
                                            </a>
                                            <form action="<?php echo e(route('admin.users.delivery-man.vehicle.delete',['id' =>$vehicle['id']])); ?>"
                                                        method="post" id="vehicle-<?php echo e($vehicle['id']); ?>">
                                                <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php if(count($vehicles) === 0): ?>
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
                                    <?php echo $vehicles->links(); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Table -->
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>





    <div class="modal fade" id="vehicledetailList">
        <div class="modal-dialog status-warning-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true" class="tio-clear"></span>
                    </button>
                </div>
                <div class="modal-body pb-5 pt-0">
                    <div class="mx-auto mb-20">
                        <div class="mb-4" >

                            <div class="d-flex justify-content-center mb-2  align-items-center gap-2  fs-16">
                                <span  class="text-dark"><?php echo e(translate('Vehicle_Type')); ?></span>
                                :
                                <span id="vehicle_type" class="font-semibold text-dark">  </span>
                            </div>
                            <div class="d-flex justify-content-center mb-2 align-items-center gap-2">
                                <span  class="text-dark"><?php echo e(translate('status')); ?></span>
                                :
                                <span id="status"></span>
                            </div>

                            <div class="bg-light border mt-4 p-4 rounded text-dark">
                                <div class="d-flex justify-content-center  align-items-center gap-2">
                                    <span><?php echo e(translate('minimum_coverage_area')); ?> (<?php echo e(translate('messages.km')); ?>)</span>
                                    :
                                    <span class="font-semibold text-dark" id="starting_coverage_area"></span>
                                </div>
                                <div class="d-flex justify-content-center mb-2 mt-2 align-items-center gap-2">
                                    <span><?php echo e(translate('maximum_coverage_area')); ?> (<?php echo e(translate('messages.km')); ?>)</span>
                                    :
                                    <span class="font-semibold text-dark" id="maximum_coverage_area"></span>
                                </div>
                                <div class="d-flex justify-content-center  align-items-center gap-2">
                                    <span><?php echo e(translate('extra_charges')); ?> (<?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>)</span>
                                    :
                                    <span class="font-semibold text-dark" id="extra_charges"></span>
                                </div>
                            </div>
                        </div>
                        <div class="btn--container mt-2 mb-2 justify-content-center">
                            <a href="#" id="delete_button" data-message="<?php echo e(translate('messages.Want_to_delete_this_vehicle_category')); ?>" title="<?php echo e(translate('messages.delete_vehicle')); ?>" class="btn btn--cancel min-w-120 form-alert">  <?php echo e(translate("delete")); ?>  </a>
                            <a href="#"  id="edit_button" type="button" class="btn btn--primary min-w-120" ><?php echo e(translate('Edit')); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script>
        "use strict";

        $('.vehicle-info-show').on('click', function () {
            let data = $(this).data();
            $('.modal-body #id').text(data.id);
            $('.modal-body #vehicle_type').text(data.vehicle_type);
            $('.modal-body #starting_coverage_area').text(data.starting_coverage_area);
            $('.modal-body #maximum_coverage_area').text(data.maximum_coverage_area);
            $('.modal-body #extra_charges') .text(data.extra_charges);
            $('.modal-body #delete_button').attr('data-id',  data.delete_button);
            $('.modal-body #edit_button').attr('href',  data.edit_button);
                if(data.status == 1){
                    $('.modal-body #status').text('<?php echo e(translate('messages.Active')); ?>').addClass('badge badge-soft-success');
                } else{
                    $('.modal-body #status').text('<?php echo e(translate('messages.Inactive')); ?>').addClass('badge badge-soft-danger');
                }
        $('#vehicledetailList').modal('show');
    })

        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            var datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

            $('#column1_search').on('keyup', function () {
                datatable
                    .search(this.value)
                    .draw();
            });

            $('#column2_search').on('keyup', function () {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });

            $('#column3_search').on('change', function () {
                datatable
                    .columns(3)
                    .search(this.value)
                    .draw();
            });

            $('#column4_search').on('keyup', function () {
                datatable
                    .columns(4)
                    .search(this.value)
                    .draw();
            });



        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/dm-vehicle/list.blade.php ENDPATH**/ ?>