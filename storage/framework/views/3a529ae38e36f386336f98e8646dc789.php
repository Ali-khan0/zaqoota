<div class="modal-header border-0 pb-0 d-flex justify-content-end">
    <button
        type="button"
        class="btn-close border-0"
        data-dismiss="modal"
        aria-label="Close"
    ><i class="tio-clear"></i></button>
</div>
<div class="modal-body px-4 px-sm-5">
    <div class="mb-4 text-center">
        <?php ($logo=\App\Models\BusinessSetting::where('key','logo')->first()); ?>
        <img
            width="200"
            src="<?php echo e(\App\CentralLogics\Helpers::get_full_url('business', $logo?->value?? '', $logo?->storage[0]?->value ?? 'public','upload_image')); ?>"

            alt="image"
            class="dark-support onerror-image"  data-onerror-image="<?php echo e(asset('public/assets/admin/img/img1.jpg')); ?>" />
    </div>
    <h2 class="text-center mb-4"><?php echo e($addon_name); ?></h2>

    <form action="<?php echo e(route('admin.business-settings.system-addon.activation')); ?>" method="post" id="customer_login_modal" autocomplete="off">
        <?php echo csrf_field(); ?>
        <div class="form-group mb-4">
            <label for="username"><?php echo e(translate('Codecanyon_usename')); ?></label>
            <input
                name="username" id="username"
                class="form-control"
                placeholder="<?php echo e(translate('Ex:_Riad_Uddin')); ?>" required
            />
        </div>
        <div class="form-group mb-6">
            <label for="purchase_code"><?php echo e(translate('Purchase_Code')); ?></label>
            <input
                name="purchase_code" id="purchase_code"
                class="form-control"
                placeholder="<?php echo e(translate('Ex: 987652')); ?>" required
            />
            <input type="text" name="path" class="form-control" value="<?php echo e($path); ?>" hidden>
        </div>

        <div class="btn--container justify-content-center gap-3 mb-3">
            <button type="button" class="fs-16 btn btn-secondary flex-grow-1" data-dismiss="modal"><?php echo e(translate('cancel')); ?></button>
            <button type="submit" class="fs-16 btn btn--primary flex-grow-1"><?php echo e(translate('Activate')); ?></button>
        </div>
    </form>
</div>
<?php /**PATH /home/ali/Documents/xaqoota/vps_backup_before_the_migration/zaqoota/resources/views/admin-views/system/addon/partials/activation-modal-data.blade.php ENDPATH**/ ?>