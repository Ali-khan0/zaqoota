<?php $__env->startSection('title', translate('messages.withdraw_method')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-3">
            <div class="page-title-wrap d-flex justify-content-between flex-wrap align-items-center gap-3 mb-3">
                <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                    <img width="20" src="<?php echo e(asset('/public/assets/admin/img/withdraw-icon.png')); ?>" alt="">
                    <?php echo e(translate('messages.withdraw_method_list')); ?>

                </h2>
            </div>
        </div>
        <!-- End Page Title -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="search--button-wrapper px-4 py-3 d-flex flex-wrap align-items-center justify-content-between">
                        <span class="fs-16 font-semibold text-title">
                            <?php echo e(translate('Methods')); ?> <span class="badge badge-soft-dark rounded-circle ml-1"><?php echo e($withdrawal_methods->total()); ?></span>
                        </span>
                        <div class="d-flex align-items-center gap-2 flex-wrap">

                            <form class="search-form theme-style">
                            <div class="input-group input--group">
                                <input id="datatableSearch" name="search" type="search" class="form-control h--40px" placeholder="<?php echo e(translate('Ex:_Referance,_Name')); ?>" value="<?php echo e(request()?->search ?? null); ?>" aria-label="<?php echo e(translate('messages.search_here')); ?>">
                                <button type="submit" class="btn bbtn btn--primary h--40px"><i class="tio-search"></i></button>
                            </div>
                        </form>

                        <?php if(request()->get('search')): ?>
                            <button type="reset" class="btn btn--primary ml-2 location-reload-to-base" data-url="<?php echo e(url()->full()); ?>"><?php echo e(translate('messages.reset')); ?></button>
                        <?php endif; ?>


                            <div class="">
                                <a href="<?php echo e(route('admin.transactions.withdraw-method.create')); ?>" class="btn btn--primary fs-12 h--40px">
                                    <i class="tio-add"></i>
                                    <?php echo e(translate('messages.add_new_method')); ?>

                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="datatable" class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                            <thead class="bg-table-head thead-50 text-capitalize">
                                <tr>
                                    <th class="fs-14 text-title font-semibold"><?php echo e(translate('messages.SL')); ?></th>
                                    <th class="fs-14 text-title font-semibold"><?php echo e(translate('messages.method_name')); ?></th>
                                    <th class="fs-14 text-title font-semibold"><?php echo e(translate('messages.method_fields')); ?></th>
                                    <th class="fs-14 text-title font-semibold text-center"><?php echo e(translate('messages.active_status')); ?></th>
                                    <th class="fs-14 text-title font-semibold text-center" ><?php echo e(translate('messages.default_method')); ?></th>
                                    <th class="text-center fs-14 text-title font-semibold"><?php echo e(translate('messages.action')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $withdrawal_methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$withdrawal_method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="p-3 fs-14 text-title"><?php echo e($withdrawal_methods->firstitem()+$key); ?></td>
                                    <td class="p-3 fs-14 text-title"><?php echo e($withdrawal_method['method_name']); ?></td>
                                    
                                    <td class="p-3">
                                        <div class="d-flex gap-2 align-items-center  flex-wrap">
                                            <?php $__currentLoopData = $withdrawal_method['method_fields']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$method_field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="d-flex flex-wrap align-items-center __bg-FAFAFA py-1 px-2 rounded fs-12 gap-1">
                                                    <div class="d-flex align-items-center gap-1 text-title">
                                                        <b class="color-334257B2 font-regular"><?php echo e(translate('messages.Name')); ?>: </b> <span class="text--semititle"><?php echo e(translate($method_field['input_name'])); ?></span>
                                                    </div>
                                                    <div class="line" style="width: 1px; height: 10px; background-color: #2223241A;"></div>
                                                    <div class="d-flex align-items-center gap-1 text-title">
                                                        <b class="color-334257B2 font-regular"><?php echo e(translate('messages.Type')); ?>:</b> <span class="text--semititle"><?php echo e(translate($method_field['input_type'])); ?></span>
                                                    </div>
                                                    <div class="line" style="width: 1px; height: 10px; background-color: #2223241A;"></div>
                                                    <div class="d-flex align-items-center gap-1 text-title">
                                                        <b class="color-334257B2 font-regular"><?php echo e(translate('messages.Placeholder')); ?>:</b> <span class="text--semititle"><?php echo e($method_field['placeholder']); ?></span>
                                                    </div>
                                                     <div class="line" style="width: 1px; height: 10px; background-color: #2223241A;"></div>
                                                    <div class="d-flex align-items-center gap-1 text-title">
                                                        <b class="color-334257B2 font-regular"><?php echo e(translate('Is_Required')); ?>:</b> <span class="text--semititle"><?php echo e($method_field['is_required'] ? translate('Yes') :  translate('No')); ?></span>
                                                    </div>

                                                    <br/>

                                                </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            
                                        </div>
                                    </td>
                                    <td class="p-3 text-center">
                                        <label class="toggle-switch toggle-switch-sm">
                                            <input class="toggle-switch-input status featured-status"
                                                   data-id="<?php echo e($withdrawal_method->id); ?>"
                                                   type="checkbox" <?php echo e($withdrawal_method->is_active?'checked':''); ?>>
                                                   <span class="toggle-switch-label mx-auto">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                        </label>
                                    </td>
                                    <td class="p-3 text-center">
                                        <label class="toggle-switch mx-auto toggle-switch-sm">
                                            <input type="checkbox" class="default-method toggle-switch-input"
                                            id="<?php echo e($withdrawal_method->id); ?>" <?php echo e($withdrawal_method->is_default == 1?'checked':''); ?>>
                                                   <span class="toggle-switch-label mx-auto">
                                                    <span class="toggle-switch-indicator"></span>
                                                </span>
                                        </label>
                                    </td>
                                    <td class="p-3">
                                        <div class="btn--container justify-content-center">
                                            <a href="<?php echo e(route('admin.transactions.withdraw-method.edit',[$withdrawal_method->id])); ?>"
                                               class="btn action-btn btn-outline-theme-dark">
                                                <i class="tio-edit"></i>
                                            </a>

                                            <?php if(!$withdrawal_method->is_default): ?>
                                                <a class="btn btn-sm btn--danger btn-outline-danger action-btn form-alert" href="javascript:"
                                                   title="<?php echo e(translate('messages.Delete')); ?>" data-id="delete-<?php echo e($withdrawal_method->id); ?>" data-message="<?php echo e(translate('Want to delete this item ?')); ?>">
                                                    <i class="tio-delete-outlined"></i>
                                                </a>
                                                <form action="<?php echo e(route('admin.transactions.withdraw-method.delete',[$withdrawal_method->id])); ?>"
                                                      method="post" id="delete-<?php echo e($withdrawal_method->id); ?>">
                                                    <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php if(count($withdrawal_methods)==0): ?>
                            <div class="empty--data">
                                <img src="<?php echo e(asset('/public/assets/admin/svg/illustrations/sorry.svg')); ?>" alt="public">
                        <h5>
                            <?php echo e(translate('no_data_found')); ?>

                        </h5>
                            </div>
                       <?php endif; ?>
                    </div>

                    <div class="table-responsive mt-4">
                        <div class="px-4 d-flex justify-content-center justify-content-md-end">
                            <!-- Pagination -->
                            <?php echo e($withdrawal_methods->links()); ?>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>



    <!-- Withdraw Method List Modal -->
    <div class="modal fade" id="withdrawMethodList" tabindex="-1" role="dialog" aria-labelledby="withdrawMethodListLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
             <div id="data-view"> </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>


<?php $__env->startPush('script_2'); ?>
  <script>
      "use strict";
      $(document).on('change', '.default-method', function () {
          let id = $(this).attr("id");
          let status = $(this).prop("checked") === true ? 1:0;

          $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
              url: "<?php echo e(route('admin.transactions.withdraw-method.default-status-update')); ?>",
              method: 'POST',
              data: {
                  id: id,
                  status: status
              },
              success: function (data) {
                  if(data.success == true) {
                      toastr.success('<?php echo e(translate('messages.Default_Method_updated_successfully')); ?>');
                      setTimeout(function(){
                          location.reload();
                      }, 1000);
                  }
                  else if(data.success == false) {
                      toastr.error('<?php echo e(translate('messages.Default_Method_updated_failed.')); ?>');
                      setTimeout(function(){
                          location.reload();
                      }, 1000);
                  }
              }
          });
      });

      $('.featured-status').on('change', function () {
          let id = $(this).data('id');
          $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
              url: "<?php echo e(route('admin.transactions.withdraw-method.status-update')); ?>",
              method: 'POST',
              data: {
                  id: id
              },
              success: function (data) {
                  toastr.success('<?php echo e(translate('messages.status_updated_successfully')); ?>');
              }
          });
      })


      function fetch_data(id) {
            $.ajax({
                url: "<?php echo e(route('admin.transactions.withdraw-method.getMethodInfo')); ?>" + '?id=' + id,
                type: "get",

                beforeSend: function () {
                    $('#data-view').empty();
                    $('#loading').show()
                },
                success: function(data) {
                    $("#withdrawMethodList").modal("show");
                    $("#data-view").append(data.view);
                },
                complete: function () {
                    $('#loading').hide()
                }
            })
        }



        $(document).on('click', '.withdraw-info-show', function () {
            let id = $(this).data('id');
            fetch_data(id)

        })


  </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/zaqoota/resources/views/admin-views/withdraw-method/withdraw-methods-list.blade.php ENDPATH**/ ?>