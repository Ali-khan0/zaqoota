<?php $__env->startSection('title', translate('DB_clean')); ?>

<?php $__env->startPush('css_or_js'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-header-title">
            <span class="page-header-icon">
                <img src="<?php echo e(asset('public/assets/admin/img/cloud-database.png')); ?>" class="w--26" alt="">
            </span>
            <span>
                <?php echo e(translate('Clean database')); ?>

            </span>
        </h1>
    </div>
    <!-- End Page Header -->
        <div class="alert alert--danger alert-danger mb-3" role="alert">
            <span class="alert--icon"><i class="tio-info"></i></span>
            <strong class="text--title"><?php echo e(translate('note_:')); ?></strong>
            <span>
                <?php echo e(translate('This_page_contains_sensitive_information.Make_sure_before_changing.')); ?>

            </span>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="<?php echo e(route('admin.business-settings.clean-db')); ?>" method="post"
                      enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="check--item-wrapper clean--database-checkgroup mt-0">
                        <?php $__currentLoopData = $tables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="check-item">
                                <div class="form-group form-check form--check">
                                    <input type="checkbox" name="tables[]" value="<?php echo e($table); ?>" class="form-check-input" id="<?php echo e($table); ?>">
                                    <label class="form-check-label text-dark <?php echo e(Session::get('direction') === "rtl" ? 'mr-3' : ''); ?>;" for="<?php echo e($table); ?>"><?php echo e(Str::limit($table, 20)); ?> <span class="badge-pill badge-secondary mx-2"><?php echo e($rows[$key]); ?></span></label>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="btn--container justify-content-end mt-4">
                        <button type="reset" class="btn btn--reset"><?php echo e(translate('messages.reset')); ?></button>
                        <button type="<?php echo e(env('APP_MODE')!='demo'?'submit':'button'); ?>" class="btn btn--primary call-demo"><?php echo e(translate('Clear')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>



<?php $__env->stopSection(); ?>

<?php $__env->startPush('script_2'); ?>
<script>
    "use strict";

    let store_dependent = ['stores','store_schedule', 'discounts' ,'campaign_store' ,'store_configs' ,'store_notification_settings' ,'store_subscriptions','store_wallets','disbursements' ,'disbursement_details','disbursement_withdrawal_methods'] ;
    let order_dependent = ['order_delivery_histories','d_m_reviews', 'delivery_histories', 'track_deliverymen', 'order_details', 'reviews','order_transactions','offline_payments','order_payments','order_references','refunds','cash_back_histories','expenses'];
    let zone_dependent = ['stores','vendors', 'orders'];
    $(document).ready(function () {
        $('.form-check-input').on('change', function(event){
            if($(this).is(':checked')){
                if(event.target.id === 'zones' || event.target.id === 'stores' || event.target.id === 'vendors') {
                    checked_stores(true);
                }

                if(event.target.id === 'zones' || event.target.id === 'orders') {
                    checked_orders(true);
                }
            } else {
                if(store_dependent.includes(event.target.id)) {
                    if(check_store() || check_zone()){
                        console.log('store_checked');
                        $(this).prop('checked', true);
                    }
                } else if(order_dependent.includes(event.target.id)) {
                    if(check_orders() || check_zone()){
                        $(this).prop('checked', true);
                    }
                } else if(zone_dependent.includes(event.target.id)) {
                    if(check_zone()){
                        $(this).prop('checked', true);
                    }
                }
            }

        });


    })

    function checked_stores(status) {
        store_dependent.forEach(function(value){
            $('#'+value).prop('checked', status);
        });
        $('#vendors').prop('checked', status);

    }

    function checked_orders(status) {
        order_dependent.forEach(function(value){
            $('#'+value).prop('checked', status);
        });
        $('#orders').prop('checked', status);
    }



    function check_zone() {
        if($('#zones').is(':checked')) {
            toastr.warning("<?php echo e(translate('messages.table_unchecked_warning',['table'=>'zones'])); ?>");
            return true;
        }
        return false;
    }

    function check_orders() {
        if($('#orders').is(':checked')) {
            toastr.warning("<?php echo e(translate('messages.table_unchecked_warning',['table'=>'orders'])); ?>");
            return true;
        }
        return false;
    }

    function check_store() {
        if($('#stores').is(':checked') || $('#vendors').is(':checked')) {
            toastr.warning("<?php echo e(translate('messages.table_unchecked_warning',['table'=>'stores/vendors'])); ?>");
            return true;
        }
        return false;
    }

    $("form").on('submit',function(e) {
        e.preventDefault();
        Swal.fire({
            title: '<?php echo e(translate('Are you sure?')); ?>',
            text: "<?php echo e(translate('Sensitive_data! Make_sure_before_changing.')); ?>",
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: 'default',
            confirmButtonColor: '#FC6A57',
            cancelButtonText: '<?php echo e(translate('messages.no')); ?>',
            confirmButtonText: '<?php echo e(translate('messages.yes')); ?>',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                this.submit();
            }else{
                e.preventDefault();
                toastr.success("<?php echo e(translate('Cancelled')); ?>");
                location.reload();
            }
        })
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/business-settings/db-index.blade.php ENDPATH**/ ?>