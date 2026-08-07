<?php $__env->startSection('title',translate('messages.add_fund')); ?>

<?php $__env->startPush('css_or_js'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title mr-3">
                <span class="page-header-icon">
                    <img src="<?php echo e(asset('/public/assets/admin/img/money.png')); ?>" class="w--26" alt="">
                </span>
                <span>
                     <?php echo e(translate("messages.add_fund")); ?>

                </span>
            </h1>
        </div>
        <!-- Page Header -->
        <div class="card gx-2 gx-lg-3">
            <div class="card-body">
                <form action="<?php echo e(route('admin.users.customer.wallet.add-fund')); ?>" method="post" enctype="multipart/form-data" id="add_fund">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-sm-6 col-12">
                            <div class="form-group">
                                <label class="input-label" for="customer"><?php echo e(translate('messages.customer')); ?>

                                    <span class="form-label-secondary text-danger"
                                          data-toggle="tooltip" data-placement="right"
                                          data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                            </span>
                                </label>
                                <select id='customer' name="customer_id" data-placeholder="<?php echo e(translate('messages.select_customer_by_name_or_phone')); ?>" class="js-data-example-ajax form-control" required>

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div class="form-group">
                                <label class="input-label" for="amount"><?php echo e(translate("messages.amount")); ?> <?php echo e(\App\CentralLogics\Helpers::currency_symbol()); ?>

                                    <span class="form-label-secondary text-danger"
                                          data-toggle="tooltip" data-placement="right"
                                          data-original-title="<?php echo e(translate('messages.Required.')); ?>"> *
                            </span>
                                </label>
                                <input type="number" placeholder="<?php echo e(translate('Ex: 50')); ?>" class="form-control" name="amount" min="0" id="amount" step=".01" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="input-label" for="referance"><?php echo e(translate('messages.reference')); ?> <small>(<?php echo e(translate('messages.optional')); ?>)</small></label>

                                <input type="text" placeholder="<?php echo e(translate('Ex: 123')); ?>" class="form-control" name="referance" id="referance">
                            </div>
                        </div>
                    </div>
                    <div class="btn--container justify-content-end">
                        <button type="reset" id="reset" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                        <button type="submit" id="submit" class="btn btn--primary"><?php echo e(translate('messages.submit')); ?></button>
                    </div>
                </form>
            </div>
            <!-- End Table -->
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
    <script>
        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            var datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

            $('#column1_search').on('keyup', function () {
                datatable
                    .columns(1)
                    .search(this.value)
                    .draw();
            });


            $('#column3_search').on('change', function () {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>

    <script>

        $('#add_fund').on('submit', function (e) {

            e.preventDefault();
            var formData = new FormData(this);

            Swal.fire({
                title: '<?php echo e(translate('messages.are_you_sure')); ?>',
                text: '<?php echo e(translate('messages.you_want_to_add_fund')); ?> '+$('#amount').val()+' <?php echo e(\App\CentralLogics\Helpers::currency_code().' '.translate('messages.to')); ?> '+$('#customer option:selected').text()+'<?php echo e(translate('messages.to_wallet')); ?>',
                type: 'info',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: 'primary',
                cancelButtonText: '<?php echo e(translate('messages.no')); ?>',
                confirmButtonText: '<?php echo e(translate('messages.add_to_fund')); ?>',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.post({
                        url: '<?php echo e(route('admin.users.customer.wallet.add-fund')); ?>',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $('#loading').show();
                        },
                        success: function (data) {
                            if (data.errors) {
                                for (var i = 0; i < data.errors.length; i++) {
                                    toastr.error(data.errors[i].message, {
                                        CloseButton: true,
                                        ProgressBar: true
                                    });
                                }
                            } else {
                                $('#loading').hide();
                                toastr.success('<?php echo e(translate("messages.fund_added_successfully")); ?>', {
                                    CloseButton: true,
                                    ProgressBar: true
                                });
                                setTimeout(function () {
                                    window.location.reload();
                                }, 2000);

                            }
                        }
                    });
                }
            })
        })

        $('.js-data-example-ajax').select2({
            ajax: {
                url: '<?php echo e(route('admin.users.customer.select-list')); ?>',
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data) {
                    return {
                    results: data
                    };
                },
                __port: function (params, success, failure) {
                    var $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                }
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/customer/wallet/add_fund.blade.php ENDPATH**/ ?>